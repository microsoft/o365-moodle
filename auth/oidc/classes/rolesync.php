<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * System role sync from an OIDC ID token claim.
 *
 * @package auth_oidc
 * @author Lai Wei <lai.wei@enovation.ie>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2026 onwards Microsoft, Inc. (http://microsoft.com/)
 */

namespace auth_oidc;

use context_system;
use core_text;
use Throwable;

/**
 * Assigns Moodle system roles to users based on a claim in their OIDC ID token.
 *
 * Roles assigned by this feature are recorded with a component and item ID, so manually assigned roles are never
 * modified or removed. Other plugins (for example local_o365) can reuse the helpers with their own component.
 */
class rolesync {
    /**
     * Component recorded on role assignments created by the claim mapping.
     */
    public const COMPONENT = 'auth_oidc';

    /**
     * Item ID recorded on role assignments created by the claim mapping.
     */
    public const ITEMID = 1;

    /**
     * Get the roles that can be mapped: roles assignable in the system context, except guest, user and frontpage roles.
     *
     * @return array Role shortname => role ID.
     */
    public static function get_mappable_roles(): array {
        global $DB;

        $sql = "SELECT r.shortname, r.id
                  FROM {role} r
                  JOIN {role_context_levels} rcl ON rcl.roleid = r.id AND rcl.contextlevel = :contextlevel
                 WHERE r.archetype NOT IN ('guest', 'user', 'frontpage')";

        return $DB->get_records_sql_menu($sql, ['contextlevel' => CONTEXT_SYSTEM]);
    }

    /**
     * Parse a mapping text. Each non-empty line has the format "source=roleshortname[,roleshortname...]".
     * Lines starting with # are ignored.
     *
     * @param string $text The mapping text.
     * @param callable|null $keyvalidator Optional callback receiving a key and returning the normalised key, or null
     *                                    if the key is not valid.
     * @return array [mapping, errors]. Mapping is key => array of role shortnames. Errors is an array of
     *               [type, value] pairs, where type is "format", "key" or "role".
     */
    public static function parse_mapping(string $text, ?callable $keyvalidator = null): array {
        $mapping = [];
        $errors = [];
        $mappableroles = self::get_mappable_roles();

        foreach (preg_split('/\R/', $text) as $line) {
            $line = trim($line);
            if ($line === '' || strpos($line, '#') === 0) {
                continue;
            }

            $parts = explode('=', $line, 2);
            $key = trim($parts[0]);
            $shortnames = isset($parts[1]) ? array_filter(array_map('trim', explode(',', $parts[1]))) : [];
            if ($key === '' || empty($shortnames)) {
                $errors[] = ['format', $line];
                continue;
            }

            if ($keyvalidator !== null) {
                $normalisedkey = $keyvalidator($key);
                if ($normalisedkey === null) {
                    $errors[] = ['key', $key];
                    continue;
                }
                $key = $normalisedkey;
            }

            foreach ($shortnames as $shortname) {
                if (!isset($mappableroles[$shortname])) {
                    $errors[] = ['role', $shortname];
                    continue 2;
                }
            }

            $mapping[$key] = array_values(array_unique(array_merge($mapping[$key] ?? [], $shortnames)));
        }

        return [$mapping, $errors];
    }

    /**
     * Validate and normalise the key of a claim mapping line, which has the format "claim|value".
     *
     * @param string $key The key part of the mapping line.
     * @return string|null The key with the value lowercased (Unicode-aware), or null if the key is not valid.
     */
    public static function normalise_claim_key(string $key): ?string {
        $parts = explode('|', $key, 2);
        $claim = trim($parts[0]);
        $value = trim($parts[1] ?? '');
        if ($claim === '' || $value === '') {
            return null;
        }

        return $claim . '|' . core_text::strtolower($value);
    }

    /**
     * Parse a claim mapping text. Each non-empty line has the format "claim|value=roleshortname[,roleshortname...]".
     *
     * @param string $text The mapping text.
     * @return array [mapping, errors], see parse_mapping(). Mapping keys have the format "claim|lowercasedvalue".
     */
    public static function parse_claim_mapping(string $text): array {
        return self::parse_mapping($text, [self::class, 'normalise_claim_key']);
    }

    /**
     * Get the configured claim value mapping, resolved to role IDs. Invalid entries are ignored.
     *
     * @return array Claim name => lowercased claim value => array of role IDs.
     */
    public static function get_mapping(): array {
        $text = (string) get_config('auth_oidc', 'rolesync_claimmap');
        if (trim($text) === '') {
            return [];
        }

        $mappableroles = self::get_mappable_roles();
        [$mapping] = self::parse_claim_mapping($text);

        $result = [];
        foreach ($mapping as $key => $shortnames) {
            [$claim, $value] = explode('|', $key, 2);
            foreach ($shortnames as $shortname) {
                $result[$claim][$value][] = (int) $mappableroles[$shortname];
            }
        }

        return $result;
    }

    /**
     * Whether roles that are no longer matched should be removed.
     *
     * @return bool
     */
    public static function is_revoke_enabled(): bool {
        return (bool) get_config('auth_oidc', 'rolesync_revoke');
    }

    /**
     * Make a user's system roles from one source match the given set of role IDs.
     *
     * Only role assignments created for the given component and item ID are ever removed.
     *
     * @param int $userid The Moodle user ID.
     * @param array $roleids The role IDs the user should have from this source.
     * @param bool $revoke Whether to remove role assignments from this source that are not in $roleids.
     * @param string $component The component recorded on the role assignments.
     * @param int $itemid The item ID recorded on the role assignments.
     * @return array [added, removed] role ID arrays.
     */
    public static function apply_roles(
        int $userid,
        array $roleids,
        bool $revoke,
        string $component = self::COMPONENT,
        int $itemid = self::ITEMID
    ): array {
        global $DB;

        $context = context_system::instance();
        $roleids = array_values(array_unique(array_map('intval', $roleids)));

        $existing = $DB->get_records('role_assignments', [
            'userid' => $userid,
            'contextid' => $context->id,
            'component' => $component,
            'itemid' => $itemid,
        ]);
        $have = [];
        foreach ($existing as $assignment) {
            $have[(int) $assignment->roleid] = true;
        }

        $added = [];
        foreach ($roleids as $roleid) {
            if (!isset($have[$roleid])) {
                role_assign($roleid, $userid, $context->id, $component, $itemid);
                $added[] = $roleid;
            }
        }

        $removed = [];
        if ($revoke) {
            foreach (array_keys($have) as $roleid) {
                if (!in_array($roleid, $roleids, true)) {
                    role_unassign($roleid, $userid, $context->id, $component, $itemid);
                    $removed[] = $roleid;
                }
            }
        }

        return [$added, $removed];
    }

    /**
     * Remove the roles that role sync assigned to a user, when the user is no longer synced from the ID token.
     *
     * This is used when a user is disconnected from OIDC or switched to another authentication method, as later
     * logins no longer sync their roles. Nothing is removed when removal is disabled, and manually assigned roles are
     * never touched.
     *
     * @param int $userid The Moodle user ID.
     * @return array The IDs of the removed roles.
     */
    public static function remove_user_roles(int $userid): array {
        if (!self::is_revoke_enabled()) {
            return [];
        }

        [, $removed] = self::apply_roles($userid, [], true);

        return $removed;
    }

    /**
     * Convert a token claim value to a list of strings to match against the claim mapping.
     *
     * A scalar claim value is kept as one exact value, as it may contain spaces or commas (for example "Human Resources"),
     * so it must match a mapping value in full. A claim that holds several values has to be an array, as sent by
     * Microsoft Entra ID for the groups and roles claims.
     *
     * @param mixed $claimvalue The claim value.
     * @return array The trimmed, non-empty, unique values.
     */
    public static function claim_value_to_list($claimvalue): array {
        if (is_scalar($claimvalue)) {
            $claimvalue = [$claimvalue];
        }
        if (!is_array($claimvalue)) {
            return [];
        }

        $values = [];
        foreach ($claimvalue as $value) {
            if (is_scalar($value) && trim((string) $value) !== '') {
                $values[] = trim((string) $value);
            }
        }

        return array_values(array_unique($values));
    }

    /**
     * Sync the system roles of a user from the claims configured for role sync in an ID token.
     *
     * Every mapping line is checked against the claim it names, and the user gets the roles of all matching lines.
     *
     * @param int $userid The Moodle user ID.
     * @param jwt $idtoken The user's ID token.
     * @return array|null [added, removed] role ID arrays, or null if the roles were left untouched.
     */
    public static function sync_user_from_token(int $userid, jwt $idtoken): ?array {
        $roleids = [];
        $claimnames = $idtoken->claim('_claim_names');
        foreach (self::get_mapping() as $claim => $valuemapping) {
            // Entra ID omits the groups claim when the user belongs to too many groups ("overage"), and points to Graph
            // instead. The user's groups are unknown in that case, so leave their roles untouched.
            if (is_array($claimnames) && isset($claimnames[$claim])) {
                return null;
            }

            foreach (self::claim_value_to_list($idtoken->claim($claim)) as $value) {
                if (isset($valuemapping[core_text::strtolower($value)])) {
                    $roleids = array_merge($roleids, $valuemapping[core_text::strtolower($value)]);
                }
            }
        }

        return self::apply_roles($userid, $roleids, self::is_revoke_enabled());
    }

    /**
     * Sync the system roles of a user from the ID token stored for them. Never throws.
     *
     * @param int $userid The Moodle user ID.
     * @return void
     */
    public static function sync_user_from_stored_token(int $userid): void {
        global $DB;

        try {
            $tokenrecord = $DB->get_record('auth_oidc_token', ['userid' => $userid], 'id, idtoken', IGNORE_MULTIPLE);
            if (empty($tokenrecord->idtoken)) {
                return;
            }

            $idtoken = jwt::instance_from_encoded($tokenrecord->idtoken);
            self::sync_user_from_token($userid, $idtoken);
        } catch (Throwable $e) {
            utils::debug('Role sync from token failed for user ' . $userid . ': ' . $e->getMessage(), __METHOD__, $e);
        }
    }
}

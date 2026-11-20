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
 * System role sync from Microsoft 365 groups feature main class.
 *
 * @package local_o365
 * @author Lai Wei <lai.wei@enovation.ie>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2026 onwards Microsoft, Inc. (http://microsoft.com/)
 */

namespace local_o365\feature\rolesync;

use auth_oidc\rolesync;
use context_system;
use local_o365\rest\unified;
use local_o365\utils;
use Throwable;

/**
 * Assigns Moodle system roles to users based on Microsoft 365 group membership.
 *
 * Roles assigned by this feature are recorded with the local_o365 component, so manually assigned roles are never
 * modified or removed. Role sync from an ID token claim lives in auth_oidc, as it is not specific to Microsoft 365.
 */
class main {
    /**
     * Item ID of role assignments created by the group mapping.
     */
    public const SOURCE_GROUP = 1;

    /**
     * Component recorded on role assignments created by this feature.
     */
    public const COMPONENT = 'local_o365';

    /**
     * Get the roles that can be mapped: roles assignable in the system context, except guest, user and frontpage roles.
     *
     * @return array Role shortname => role ID.
     */
    public static function get_mappable_roles(): array {
        return rolesync::get_mappable_roles();
    }

    /**
     * Parse a group mapping text. Each non-empty line has the format "group object ID=roleshortname[,roleshortname...]".
     * Lines starting with # are ignored.
     *
     * @param string $text The mapping text.
     * @return array [mapping, errors]. Mapping is lowercased group object ID => array of role shortnames. Errors is an
     *               array of [type, value] pairs, where type is "format", "group" or "role".
     */
    public static function parse_mapping(string $text): array {
        [$mapping, $errors] = rolesync::parse_mapping($text, function (string $key): ?string {
            $isguid = preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i', $key);

            return $isguid ? strtolower($key) : null;
        });

        foreach ($errors as &$error) {
            $error[0] = $error[0] === 'key' ? 'group' : $error[0];
        }

        return [$mapping, $errors];
    }

    /**
     * Get the configured group mapping, resolved to role IDs. Invalid entries are ignored.
     *
     * @return array Lowercased group object ID => array of role IDs.
     */
    public static function get_mapping(): array {
        $text = (string) get_config('local_o365', 'rolesync_groupmap');
        if (trim($text) === '') {
            return [];
        }

        $mappableroles = self::get_mappable_roles();
        [$mapping] = self::parse_mapping($text);

        $result = [];
        foreach ($mapping as $key => $shortnames) {
            foreach ($shortnames as $shortname) {
                $result[$key][] = (int) $mappableroles[$shortname];
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
        return (bool) get_config('local_o365', 'rolesync_revoke');
    }

    /**
     * Make a user's system roles from the group mapping match the given set of role IDs.
     *
     * Only role assignments created by this feature are ever removed.
     *
     * @param int $userid The Moodle user ID.
     * @param array $roleids The role IDs the user should have from the group mapping.
     * @param bool $revoke Whether to remove role assignments from this feature that are not in $roleids.
     * @return array [added, removed] role ID arrays.
     */
    public static function apply_roles(int $userid, array $roleids, bool $revoke): array {
        return rolesync::apply_roles($userid, $roleids, $revoke, self::COMPONENT, self::SOURCE_GROUP);
    }

    /**
     * Sync the system roles of all users from the configured Microsoft 365 group mapping.
     *
     * Both the owners and the (transitive) members of each mapped group receive the mapped roles. Users without an active
     * Microsoft 365 connection are skipped.
     *
     * @param unified $graphclient The Graph API client.
     * @param callable|null $trace Optional callback receiving a progress message string and an indentation level.
     * @return bool False if any group could not be read, true otherwise.
     */
    public static function sync_groups(unified $graphclient, ?callable $trace = null): bool {
        global $DB;

        $trace = $trace ?? function (string $message, int $level = 0): void {
        };
        $mapping = self::get_mapping();
        $revoke = self::is_revoke_enabled();
        $complete = true;
        $roleshortnames = array_flip(self::get_mappable_roles());
        $rolenames = function (array $roleids) use ($roleshortnames): string {
            return implode(', ', array_map(function ($roleid) use ($roleshortnames) {
                return $roleshortnames[$roleid] ?? ('#' . $roleid);
            }, array_unique($roleids)));
        };

        $rolelabel = function (array $roleids) use ($rolenames): string {
            return $rolenames($roleids) . (count(array_unique($roleids)) === 1 ? ' role' : ' roles');
        };

        $trace('Role removal: ' . ($revoke ? 'enabled' : 'disabled') . '.');
        $trace('Configured group role mappings: ' . count($mapping) . '.');

        // Collect the members and owners of each mapped group.
        $groups = [];
        $rolesbyoid = [];
        foreach ($mapping as $groupoid => $roleids) {
            $groupname = '(unknown)';
            try {
                $group = $graphclient->get_group($groupoid);
                $groupname = $group['displayName'] ?? $groupname;
            } catch (Throwable $e) {
                $trace('Could not read details of group ' . $groupoid . ': ' . $e->getMessage(), 1);
            }

            try {
                $members = $graphclient->get_transitive_group_members($groupoid);
                $owners = array_filter($graphclient->get_group_owners($groupoid) ?? [], function ($owner) {
                    return !isset($owner['@odata.type']) || $owner['@odata.type'] === '#microsoft.graph.user';
                });
            } catch (Throwable $e) {
                $trace('Group ' . $groupoid . ' (' . $groupname . '): could not read members and owners: ' .
                    $e->getMessage(), 1);
                utils::debug($e->getMessage(), __METHOD__, $e);
                $complete = false;
                continue;
            }

            $groupusers = [];
            foreach (array_merge($members, $owners) as $user) {
                if (!empty($user['id'])) {
                    $groupusers[strtolower($user['id'])] = true;
                }
            }
            $groups[$groupoid] = [
                'name' => $groupname,
                'roleids' => $roleids,
                'oids' => array_keys($groupusers),
                'memberscount' => count($members),
                'ownerscount' => count($owners),
            ];

            foreach (array_keys($groupusers) as $oid) {
                $rolesbyoid[$oid] = array_merge($rolesbyoid[$oid] ?? [], $roleids);
            }
        }

        // Map Microsoft user object IDs to Moodle users.
        $rolesbyuserid = [];
        $useridbyoid = [];
        $oidbyuserid = [];
        foreach (array_chunk(array_keys($rolesbyoid), 1000) as $oids) {
            [$insql, $params] = $DB->get_in_or_equal($oids, SQL_PARAMS_NAMED);
            $sql = "SELECT o.moodleid, o.objectid
                      FROM {local_o365_objects} o
                      JOIN {user} u ON u.id = o.moodleid AND u.deleted = 0
                     WHERE o.type = 'user' AND LOWER(o.objectid) $insql";
            $users = [];
            $recordset = $DB->get_recordset_sql($sql, $params);
            foreach ($recordset as $record) {
                $users[] = $record;
            }
            $recordset->close();

            foreach ($users as $user) {
                // Object mappings are created when users are provisioned, before their first login, so also require an
                // active Microsoft 365 connection (a Graph resource OIDC token).
                if (!utils::is_o365_connected((int) $user->moodleid)) {
                    continue;
                }

                $rolesbyuserid[(int) $user->moodleid] = array_merge(
                    $rolesbyuserid[(int) $user->moodleid] ?? [],
                    $rolesbyoid[strtolower($user->objectid)]
                );
                $useridbyoid[strtolower($user->objectid)] = (int) $user->moodleid;
                $oidbyuserid[(int) $user->moodleid] = $user->objectid;
            }
        }

        // Users that still hold a role from a previous run must be visited too, so that their roles can be revoked.
        // When a group could not be read, membership is unknown, so skip revocation to avoid removing roles by mistake.
        if ($revoke && !$complete) {
            $trace('Skipping role removal because at least one group could not be read.');
        }
        $revokeeffective = $revoke && $complete;
        $userids = array_keys($rolesbyuserid);
        if ($revokeeffective) {
            $existingusers = $DB->get_fieldset_select(
                'role_assignments',
                'DISTINCT userid',
                'component = :component AND itemid = :itemid AND contextid = :contextid',
                ['component' => self::COMPONENT, 'itemid' => self::SOURCE_GROUP, 'contextid' => context_system::instance()->id]
            );
            $userids = array_unique(array_merge($userids, $existingusers));
        }

        // Load the users in batches, rather than one query per user. Deleted users are left out, and so are skipped.
        $usernames = [];
        foreach (array_chunk($userids, 1000) as $chunk) {
            [$insql, $params] = $DB->get_in_or_equal($chunk, SQL_PARAMS_NAMED);
            $usernames += $DB->get_records_select_menu('user', "deleted = 0 AND id $insql", $params, '', 'id, username');
        }

        // Apply the roles. A user can be in several groups, so the roles are applied once per user.
        $results = [];
        foreach ($userids as $userid) {
            if (!isset($usernames[$userid])) {
                continue;
            }

            $results[$userid] = self::apply_roles(
                (int) $userid,
                $rolesbyuserid[$userid] ?? [],
                $revokeeffective
            );
        }

        $describe = function (int $userid) use ($usernames, $oidbyuserid): string {
            return 'User ' . $userid . ' (' . $usernames[$userid] . ', Microsoft ID ' . ($oidbyuserid[$userid] ?? 'n/a') . ')';
        };

        // Report the results per group.
        foreach ($groups as $groupoid => $group) {
            $trace('Group ' . $groupoid . ' (' . $group['name'] . '): roles ' . $rolenames($group['roleids']) . '; ' .
                $group['memberscount'] . ' member(s), ' . $group['ownerscount'] . ' owner(s), ' .
                count($group['oids']) . ' distinct user(s).', 1);

            $notconnected = 0;
            $unaffected = 0;
            $changes = [];
            foreach ($group['oids'] as $oid) {
                if (!isset($useridbyoid[$oid])) {
                    $notconnected++;
                    continue;
                }

                $userid = $useridbyoid[$oid];
                $newroles = array_intersect($results[$userid][0] ?? [], $group['roleids']);
                if (empty($newroles)) {
                    $unaffected++;
                } else {
                    $changes[] = $describe($userid) . ': added ' . $rolelabel($newroles) . '.';
                }
            }

            $trace('Connected users: ' . (count($group['oids']) - $notconnected) . ', changed: ' . count($changes) .
                ', unaffected: ' . $unaffected . ', not connected to Microsoft 365 (skipped): ' . $notconnected . '.', 2);
            foreach ($changes as $change) {
                $trace($change, 3);
            }
        }

        // Roles removed from users that no longer qualify are not tied to a single group.
        $removals = [];
        foreach ($results as $userid => [, $oldroles]) {
            if (!empty($oldroles)) {
                $removals[] = $describe($userid) . ': removed ' . $rolelabel($oldroles) . '.';
            }
        }
        if (!empty($removals)) {
            $trace('Roles removed from users that no longer qualify through any mapped group:', 1);
            foreach ($removals as $removal) {
                $trace($removal, 2);
            }
        }

        $added = 0;
        $removed = 0;
        $changed = 0;
        foreach ($results as [$newroles, $oldroles]) {
            $added += count($newroles);
            $removed += count($oldroles);
            $changed += (empty($newroles) && empty($oldroles)) ? 0 : 1;
        }

        // Count Microsoft IDs on both sides: identity links are not unique, so several IDs can resolve to one Moodle user.
        $trace(count($rolesbyoid) . ' distinct Microsoft user(s) in the mapped groups, ' . count($useridbyoid) .
            ' of them connected to Microsoft 365, ' . (count($rolesbyoid) - count($useridbyoid)) .
            ' not connected (skipped).');
        $trace('Users processed: ' . count($results) . ', changed: ' . $changed . ', unaffected: ' .
            (count($results) - $changed) . '.');
        $trace("Role assignments added: $added, removed: $removed.");

        return $complete;
    }
}

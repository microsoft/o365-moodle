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
 * Helper for the repository_office365 upgrade steps.
 *
 * @package    repository_office365
 * @copyright  2026 Microsoft, Inc.
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace repository_office365;

/**
 * Helper for the repository_office365 upgrade steps.
 *
 * @package    repository_office365
 * @copyright  2026 Microsoft, Inc.
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class upgrade_helper {
    /**
     * The "Link to the file" and "Create an access controlled link to the file" options did not exist.
     */
    public const LINK_OPTIONS_NONE = 'none';

    /**
     * The link options existed and were on unless the admin disabled them (disabledirectlink, disableanonymousshare).
     */
    public const LINK_OPTIONS_OPTOUT = 'optout';

    /**
     * The link options existed and were off unless the admin enabled them (enabledirectlink, enableanonymousshare).
     */
    public const LINK_OPTIONS_OPTIN = 'optin';

    /**
     * Plugin versions at which the link options behaviour changed, across all the supported Moodle versions.
     *
     * The plugin version of each Moodle version is higher than the one of the previous Moodle version, so a site
     * upgrading across Moodle versions can be placed on this single list. Each entry is the first plugin version
     * with the given behaviour, the behaviour holds until the next entry.
     *
     * Moodle 4.5: 2024100715 (4.5.3) opt-out, 2024100730 (4.5.6) opt-in.
     * Moodle 5.0: 2025040800 (5.0.0) none, 2025040810 (5.0.2) opt-out, 2025040825 (5.0.5) opt-in.
     * Moodle 5.1: 2025100600 (5.1.0) opt-out, 2025100601 (5.1.1) opt-in.
     * Moodle 5.2: 2026042000 (5.2.0) opt-in, which is covered by the entry above.
     */
    private const LINK_OPTIONS_VERSIONS = [
        2024100715 => self::LINK_OPTIONS_OPTOUT,
        2024100730 => self::LINK_OPTIONS_OPTIN,
        2025040800 => self::LINK_OPTIONS_NONE,
        2025040810 => self::LINK_OPTIONS_OPTOUT,
        2025040825 => self::LINK_OPTIONS_OPTIN,
        2025100600 => self::LINK_OPTIONS_OPTOUT,
        2025100601 => self::LINK_OPTIONS_OPTIN,
    ];

    /**
     * Get how the link options behaved in the given version of the plugin.
     *
     * @param float|int $version The plugin version, usually the version a site is upgrading from.
     * @return string One of the LINK_OPTIONS_* constants.
     */
    public static function get_link_options_behaviour($version): string {
        $behaviour = self::LINK_OPTIONS_NONE;
        foreach (self::LINK_OPTIONS_VERSIONS as $from => $frombehaviour) {
            if ($version < $from) {
                break;
            }
            $behaviour = $frombehaviour;
        }

        return $behaviour;
    }

    /**
     * Get the link types of the file references that this site holds for repository_office365.
     *
     * Only references created by the link options carry a link type, older references are not counted.
     *
     * @return string[] The link types found: 'directlink' and/or 'controlledshare'.
     */
    public static function get_used_link_types(): array {
        global $DB;

        $sql = "SELECT fr.id, fr.reference
                  FROM {files_reference} fr
                  JOIN {repository_instances} ri ON ri.id = fr.repositoryid
                  JOIN {repository} r ON r.id = ri.typeid
                 WHERE r.type = :type";
        $used = [];
        $records = $DB->get_recordset_sql($sql, ['type' => 'office365']);
        foreach ($records as $record) {
            $decoded = base64_decode($record->reference, true);
            $reference = $decoded === false ? null : json_decode($decoded, true);
            if (is_array($reference) && isset($reference['linktype'])) {
                $used[$reference['linktype']] = true;
            }

            if (isset($used['directlink']) && isset($used['controlledshare'])) {
                break;
            }
        }
        $records->close();

        return array_keys($used);
    }
}

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
 * User connections table data source and row renderer.
 *
 * @package local_o365
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright 2016 onwards Remote-Learner Inc (http://www.remote-learner.net)
 */

namespace local_o365\feature\userconnections;

use core\url;
use html_writer;

/**
 * User connections table data source and row renderer.
 *
 * The manage user connections page renders an empty HTML table and loads its rows through DataTables server-side
 * processing (the "userconnections_ajax" mode of local_o365\page\acp). This class centralises the base query used to
 * fetch the connection data and the rendering of each column so the page and the AJAX endpoint stay in sync.
 */
class table {
    /**
     * Get the translated header for each column.
     *
     * @return array Map of column key => header string.
     */
    public static function get_column_headers(): array {
        return [
            'muser' => get_string('acp_userconnections_column_muser', 'local_o365'),
            'o365user' => get_string('acp_userconnections_column_o365user', 'local_o365'),
            'usinglogin' => get_string('acp_userconnections_column_usinglogin', 'local_o365'),
            'status' => get_string('acp_userconnections_column_status', 'local_o365'),
            'actions' => get_string('acp_userconnections_column_actions', 'local_o365'),
        ];
    }

    /**
     * Get the base SQL and parameters used to fetch user connection data.
     *
     * The query joins the Moodle user table with the OpenID Connect token, the local_o365 connection and the
     * local_o365 object tables. Callers can append additional filtering to the returned WHERE clause (the query ends
     * with a WHERE condition) using the "aotok", "o365match" and "objects" aliases.
     *
     * @return array [string $sql, array $params]
     */
    public static function get_base_sql(): array {
        $columns = [
            'u.id AS userid',
            'u.firstname AS userfirstname',
            'u.firstnamephonetic AS userfirstnamephonetic',
            'u.lastname AS userlastname',
            'u.lastnamephonetic AS userlastnamephonetic',
            'u.middlename AS usermiddlename',
            'u.alternatename AS useralternatename',
            'u.auth AS userauth',
            'aotok.oidcusername AS toko365username',
            'o365match.entraidupn AS matchedo365username',
            'o365match.uselogin AS matcheduselogin',
            'objects.o365name AS objectso365name',
            'COALESCE(aotok.oidcusername, o365match.entraidupn, objects.o365name) AS o365username',
        ];

        $sql = 'SELECT ' . implode(', ', $columns) . '
                  FROM {user} u
             LEFT JOIN {auth_oidc_token} aotok ON aotok.userid = u.id
             LEFT JOIN {local_o365_connections} o365match ON o365match.muserid = u.id
             LEFT JOIN {local_o365_objects} objects ON objects.moodleid = u.id AND objects.type = :o365objecttype
                 WHERE u.deleted = 0 AND u.username <> :o365guestusername';
        $params = ['o365objecttype' => 'user', 'o365guestusername' => 'guest'];

        return [$sql, $params];
    }

    /**
     * Get the SQL snippet used to apply the DataTables free-text search box.
     *
     * The snippet operates on the aliases produced by get_base_sql(), so it must be applied to a query that wraps
     * that base query as a sub-query.
     *
     * @param string $search The search term entered by the user.
     * @return array [string $sql, array $params]
     */
    public static function get_search_sql(string $search): array {
        global $DB;

        $search = trim($search);
        if ($search === '') {
            return ['', []];
        }

        $fullname = $DB->sql_concat('userfirstname', "' '", 'userlastname');
        $fields = [$fullname, 'userfirstname', 'userlastname', 'o365username'];

        $conditions = [];
        $params = [];
        $likeparam = '%' . $DB->sql_like_escape($search) . '%';
        foreach ($fields as $i => $field) {
            $placeholder = 'o365ucsearch' . $i;
            $conditions[] = $DB->sql_like($field, ':' . $placeholder, false, false);
            $params[$placeholder] = $likeparam;
        }

        return ['(' . implode(' OR ', $conditions) . ')', $params];
    }

    /**
     * Render the "Moodle user" column.
     *
     * @param \stdClass $row A row returned by the base query.
     * @return string
     */
    public static function render_muser(\stdClass $row): string {
        $userdata = [
            'firstname' => $row->userfirstname,
            'firstnamephonetic' => $row->userfirstnamephonetic,
            'lastname' => $row->userlastname,
            'lastnamephonetic' => $row->userlastnamephonetic,
            'middlename' => $row->usermiddlename,
            'alternatename' => $row->useralternatename,
        ];
        $viewurl = new url('/user/view.php', ['id' => $row->userid]);
        return html_writer::link($viewurl, fullname((object) $userdata));
    }

    /**
     * Render the "Microsoft 365 user" column.
     *
     * @param \stdClass $row A row returned by the base query.
     * @return string
     */
    public static function render_o365user(\stdClass $row): string {
        return s($row->o365username ?? '');
    }

    /**
     * Render the "Using login" column.
     *
     * @param \stdClass $row A row returned by the base query.
     * @return string
     */
    public static function render_usinglogin(\stdClass $row): string {
        if (!empty($row->toko365username) || !empty($row->objectso365name)) {
            // Actively connected or synced users.
            if (isset($row->userauth) && $row->userauth === 'oidc') {
                return get_string('yes');
            } else {
                return get_string('no');
            }
        } else if (!empty($row->matchedo365username)) {
            return (!empty($row->matcheduselogin)) ? get_string('yes') : get_string('no');
        }

        return '';
    }

    /**
     * Get the connection status key for a row.
     *
     * @param \stdClass $row A row returned by the base query.
     * @return string One of 'connected', 'matched', 'synced' or 'noconnection'.
     */
    public static function get_status_key(\stdClass $row): string {
        if (!empty($row->toko365username)) {
            return 'connected';
        } else if (!empty($row->matchedo365username)) {
            return 'matched';
        } else if (!empty($row->objectso365name)) {
            return 'synced';
        }

        return 'noconnection';
    }

    /**
     * Render the "Connection status" column.
     *
     * @param \stdClass $row A row returned by the base query.
     * @return string
     */
    public static function render_status(\stdClass $row): string {
        $statuscss = 'padding:0.25rem;display:block;';
        switch (self::get_status_key($row)) {
            case 'connected':
                $label = get_string('acp_userconnections_connectionstatus_connected', 'local_o365');
                return html_writer::tag('span', $label, ['class' => 'alert-success', 'style' => $statuscss]);
            case 'matched':
                $label = get_string('acp_userconnections_connectionstatus_matched', 'local_o365');
                $style = 'padding:0.25rem;display:block;color:#960;background-color:#fed;';
                return html_writer::tag('span', $label, ['class' => 'alert-info', 'style' => $style]);
            case 'synced':
                $label = get_string('acp_userconnections_connectionstatus_synced', 'local_o365');
                return html_writer::tag('span', $label, ['class' => 'alert-info', 'style' => $statuscss]);
            default:
                $label = get_string('acp_userconnections_connectionstatus_noconnection', 'local_o365');
                return html_writer::tag('span', $label, ['style' => 'font-style:italic;opacity:0.5']);
        }
    }

    /**
     * Render the "Actions" column.
     *
     * @param \stdClass $row A row returned by the base query.
     * @return string
     */
    public static function render_actions(\stdClass $row): string {
        $urlparams = [
            'userid' => $row->userid,
            'sesskey' => sesskey(),
        ];
        $links = [];
        switch (self::get_status_key($row)) {
            case 'connected':
                $links[] = self::action_link($urlparams, 'userconnections_disconnect', 'acp_userconnections_table_disconnect');
                $links[] = self::action_link($urlparams, 'userconnections_resync', 'acp_userconnections_table_resync');
                break;
            case 'matched':
                $links[] = self::action_link($urlparams, 'userconnections_unmatch', 'acp_userconnections_table_unmatch');
                break;
            case 'synced':
                $links[] = self::action_link($urlparams, 'userconnections_resync', 'acp_userconnections_table_resync');
                break;
            default:
                $links[] = self::action_link($urlparams, 'userconnections_manualmatch', 'acp_userconnections_table_match');
                break;
        }

        return implode('<br />', $links);
    }

    /**
     * Build a single action link for the "Actions" column.
     *
     * @param array $urlparams Base URL parameters (userid, sesskey).
     * @param string $mode The acp.php mode this action triggers.
     * @param string $stringkey The local_o365 language string key for the link text.
     * @return string
     */
    protected static function action_link(array $urlparams, string $mode, string $stringkey): string {
        $urlparams['mode'] = $mode;
        $url = new url('/local/o365/acp.php', $urlparams);
        return html_writer::link($url, get_string($stringkey, 'local_o365'));
    }
}

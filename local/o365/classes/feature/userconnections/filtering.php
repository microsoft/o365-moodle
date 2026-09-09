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
 * User filtering class.
 *
 * @package local_o365
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright 2016 onwards Remote-Learner Inc (http://www.remote-learner.net)
 */

namespace local_o365\feature\userconnections;

defined('MOODLE_INTERNAL') || die();

global $CFG;

require_once($CFG->dirroot . '/user/filters/lib.php');

/**
 * User filtering class.
 */
class filtering extends \user_filtering {
    /**
     * Creates known user filter if present.
     *
     * @param string $fieldname
     * @param boolean $advanced
     * @return object filter
     */
    public function get_field($fieldname, $advanced) {
        global $DB, $USER;
        switch ($fieldname) {
            case 'username':
                $label = get_string('acp_userconnections_filtering_musername', 'local_o365');
                return new \user_filter_text('username', $label, $advanced, 'u.username');

            case 'o365username':
                $label = get_string('acp_userconnections_filtering_o365username', 'local_o365');
                return new \user_filter_text('o365username', $label, $advanced, 'o365username');

            case 'idnumber':
                return new \user_filter_text('idnumber', get_string('idnumber'), $advanced, 'u.idnumber');

            case 'realname':
                $label = get_string('acp_userconnections_filtering_muserfullname', 'local_o365');
                $filteron = $DB->sql_fullname();
                return new \user_filter_text('realname', $label, $advanced, $filteron);

            case 'lastname':
                return new \user_filter_text('lastname', get_string('lastname'), $advanced, 'u.lastname');

            case 'firstname':
                return new \user_filter_text('firstname', get_string('firstname'), $advanced, 'u.firstname');

            case 'email':
                return new \user_filter_text('email', get_string('email'), $advanced, 'u.email');

            case 'connectionstatus':
                $label = get_string('acp_userconnections_filtering_connectionstatus', 'local_o365');
                $options = [
                    'connected' => get_string('acp_userconnections_connectionstatus_connected', 'local_o365'),
                    'matched' => get_string('acp_userconnections_connectionstatus_matched', 'local_o365'),
                    'synced' => get_string('acp_userconnections_connectionstatus_synced', 'local_o365'),
                    'noconnection' => get_string('acp_userconnections_connectionstatus_noconnection', 'local_o365'),
                ];
                return new \user_filter_simpleselect('connectionstatus', $label, $advanced, 'connectionstatus', $options);

            case 'accountstatus':
                $label = get_string('acp_userconnections_filtering_accountstatus', 'local_o365');
                $options = [
                    'active' => get_string('acp_userconnections_accountstatus_active', 'local_o365'),
                    'suspended' => get_string('acp_userconnections_accountstatus_suspended', 'local_o365'),
                ];
                return new \user_filter_simpleselect('accountstatus', $label, $advanced, 'accountstatus', $options);

            default:
                return null;
        }
    }

    /**
     * Constructor.
     *
     * @param array|null $fieldnames Array of visible user fields.
     * @param string|null $baseurl Base url used for submission/return.
     * @param array|null $extraparams Extra page parameters.
     */
    public function __construct($fieldnames = null, $baseurl = null, $extraparams = null) {
        global $SESSION;

        if (!isset($SESSION->user_filtering)) {
            $SESSION->user_filtering = [];
        }

        // On the first visit within a session, pre-select the "active" account status so that suspended accounts are
        // hidden by default. Afterwards the admin has full control over this filter, including removing it (which shows
        // accounts of any status).
        if (empty($SESSION->local_o365_userconnections_filterinit)) {
            $SESSION->local_o365_userconnections_filterinit = true;
            $seedaccountstatus = is_array($fieldnames)
                && array_key_exists('accountstatus', $fieldnames)
                && !array_key_exists('accountstatus', $SESSION->user_filtering);
            if ($seedaccountstatus) {
                $SESSION->user_filtering['accountstatus'][] = ['value' => 'active'];
            }
        }

        parent::__construct($fieldnames, $baseurl, $extraparams);

        // Swap in an "add filter" form that uses a shorter "Filter" section header. The parent constructor has already
        // processed any submitted filter using its own form, so this instance is only used for display.
        $this->_addform = new add_filter_form($baseurl, ['fields' => $this->_fields, 'extraparams' => $extraparams]);
    }

    /**
     * Returns sql where statement based on active user filters.
     *
     * @param string $extra sql
     * @param array|null $params named params (recommended prefix ex)
     * @return array sql string and $params
     */
    public function get_sql_filter($extra = '', ?array $params = null) {
        global $SESSION;

        $sqls = [];
        if ($extra != '') {
            $sqls[] = $extra;
        }

        $params = (array)$params;

        if (!empty($SESSION->user_filtering)) {
            foreach ($SESSION->user_filtering as $fname => $datas) {
                if (!array_key_exists($fname, $this->_fields)) {
                    continue; // Filter not used.
                }

                if ($fname == 'o365username' || $fname == 'connectionstatus' || $fname == 'accountstatus') {
                    continue;
                }

                $field = $this->_fields[$fname];
                foreach ($datas as $i => $data) {
                    [$s, $p] = $field->get_sql_filter($data);
                    $sqls[] = $s;
                    $params = $params + $p;
                }
            }
        }

        if (empty($sqls)) {
            return ['', []];
        } else {
            $sqls = implode(' AND ', $sqls);
            return [$sqls, $params];
        }
    }

    /**
     * Get the filter value for the "o365username" filter.
     *
     * @return array List of filter SQLs and parameters for the o365username filter.
     */
    public function get_filter_o365username() {
        global $SESSION;
        $sqls = [];
        $params = [];
        $fname = 'o365username';
        if (isset($SESSION->user_filtering[$fname])) {
            $datas = $SESSION->user_filtering[$fname];
            $field = $this->_fields[$fname];
            foreach ($datas as $i => $data) {
                [$s, $p] = $field->get_sql_filter($data);
                $sqls[] = $s;
                $params = $params + $p;
            }
        }

        if (empty($sqls)) {
            return ['', []];
        } else {
            $sqls = implode(' AND ', $sqls);
            return [$sqls, $params];
        }
    }

    /**
     * Get the filter value for the "connectionstatus" filter.
     *
     * The connection status is a value derived from several joined tables rather than a single column, so it cannot be
     * expressed with the generic filter classes. This method turns the selected status into an SQL snippet that operates
     * on the joined columns of the base query (see the table class and the userconnections AJAX endpoint).
     *
     * @return array List of the filter SQL snippet and its parameters for the connectionstatus filter.
     */
    public function get_filter_connectionstatus(): array {
        global $SESSION;

        $fname = 'connectionstatus';
        if (!isset($SESSION->user_filtering[$fname])) {
            return ['', []];
        }

        $snippets = [
            'connected' => 'aotok.oidcusername IS NOT NULL',
            'matched' => '(aotok.oidcusername IS NULL AND o365match.entraidupn IS NOT NULL)',
            'synced' => '(aotok.oidcusername IS NULL AND o365match.entraidupn IS NULL AND objects.o365name IS NOT NULL)',
            'noconnection' => '(aotok.oidcusername IS NULL AND o365match.entraidupn IS NULL AND objects.o365name IS NULL)',
        ];

        // The statuses are mutually exclusive, so multiple selected values are combined with OR.
        $sqls = [];
        foreach ($SESSION->user_filtering[$fname] as $data) {
            $value = $data['value'] ?? '';
            if (isset($snippets[$value]) && !in_array($snippets[$value], $sqls)) {
                $sqls[] = $snippets[$value];
            }
        }

        if (empty($sqls)) {
            return ['', []];
        }

        return ['(' . implode(' OR ', $sqls) . ')', []];
    }

    /**
     * Get the filter value for the "accountstatus" filter.
     *
     * Filters on the Moodle account's suspended flag. When the filter is not active no restriction is applied (accounts
     * of any status are shown); the "active" default is seeded into the session on the first visit (see the constructor).
     *
     * @return array List of the filter SQL snippet and its parameters for the accountstatus filter.
     */
    public function get_filter_accountstatus(): array {
        global $SESSION;

        $fname = 'accountstatus';
        if (!isset($SESSION->user_filtering[$fname])) {
            return ['', []];
        }

        $snippets = [
            'active' => 'u.suspended = 0',
            'suspended' => 'u.suspended = 1',
        ];

        // Active and suspended are mutually exclusive, so multiple selected values are combined with OR
        // (selecting both is equivalent to showing accounts of any status).
        $sqls = [];
        foreach ($SESSION->user_filtering[$fname] as $data) {
            $value = $data['value'] ?? '';
            if (isset($snippets[$value]) && !in_array($snippets[$value], $sqls)) {
                $sqls[] = $snippets[$value];
            }
        }

        if (empty($sqls)) {
            return ['', []];
        }

        return ['(' . implode(' OR ', $sqls) . ')', []];
    }
}

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
 * @package local_o365
 * @author James McQuillan <james.mcquillan@remote-learner.net>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 */

namespace local_o365\adminsetting;

global $CFG;
require_once($CFG->dirroot.'/lib/adminlib.php');

/**
 * Admin setting to control field mappings for users.
 */
class fieldmap extends \admin_setting {
    /** @var bool Whether to use the update behavior column. */
    protected $showbehavcolumn = true;

    /** @var str The string ID fron local_o365 to use as the heading for the remote field column. */
    protected $remotefieldstrid = 'settings_fieldmap_header_remote';

    /**
     * Constructor
     * @param string $name unique ascii name, either 'mysetting' for settings that in config,
     *                     or 'myplugin/mysetting' for ones in config_plugins.
     * @param string $visiblename localised name
     * @param string $description localised long description
     * @param mixed $defaultsetting string or array depending on implementation
     */
    public function __construct($name, $visiblename, $description, $defaultsetting, $remotefields = [], $localfields = [], $syncbehav = [], $lockoptions = []) {
        global $DB;

        $this->syncbehavopts = $syncbehav;
        $this->synclockopts = $lockoptions;
        $this->remotefields = $remotefields;
        $this->localfields = $localfields;

        return parent::__construct($name, $visiblename, $description, $defaultsetting);
    }

    /**
     * Return the setting
     *
     * @return mixed returns config if successful else null
     */
    public function get_setting() {
        return unserialize($this->config_read($this->name));
    }

    /**
     * Write the setting.
     *
     * We do this manually so just pretend here.
     *
     * @param mixed $data Incoming form data.
     * @return string Always empty string representing no issues.
     */
    public function write_setting($data) {
        $newconfig = [];

        if (empty($data) || $data === $this->get_defaultsetting()) {
            $this->config_write($this->name, serialize($this->get_defaultsetting()));
            return '';
        }

        if (!isset($data['remotefield']) || !is_array($data['remotefield'])) {
            // Broken data, wipe setting.
            $this->config_write($this->name, serialize($newconfig));
            return '';
        }
        if (!isset($data['localfield']) || !is_array($data['localfield'])) {
            // Broken data, wipe setting.
            $this->config_write($this->name, serialize($newconfig));
            return '';
        }

        if ($this->showbehavcolumn === true) {
            if (!isset($data['behavior']) || !is_array($data['behavior'])) {
                // Broken data, wipe setting.
                $this->config_write($this->name, serialize($newconfig));
                return '';
            }
            if (!isset($data['locking']) || !is_array($data['locking'])) {
                // Broken data, wipe setting.
                $this->config_write($this->name, serialize($newconfig));
                return '';
            }
        }

        foreach ($data['remotefield'] as $i => $fieldname) {
            if (!isset($data['localfield'][$i])) {
                continue;
            }

            $configentry = $data['remotefield'][$i].'/'.$data['localfield'][$i];

            if ($this->showbehavcolumn === true) {
                if (!isset($data['behavior'][$i])) {
                    continue;
                } else {
                    $configentry .= '/'.$data['behavior'][$i];
                }

                if (!isset($data['locking'][$i])) {
                    continue;
                } else {
                    $configentry .= '/'.$data['locking'][$i];
                }
            }

            $newconfig[] = $configentry;
        }
        $this->config_write($this->name, serialize($newconfig));
        return '';
    }

    /**
     * Return an XHTML string for the setting.
     *
     * @return string Returns an XHTML string
     */
    public function output_html($data, $query = '') {
        global $DB, $OUTPUT;

        $html = \html_writer::start_tag('div');

        $style = 'button.addmapping, .fieldlist select, .fieldlist button {vertical-align:middle;margin:0;}';
        $style .= '.fieldlist {margin-bottom:0.5rem;}';
        $html .= \html_writer::tag('style', $style);
        $hiddenattrs = ['type' => 'hidden', 'name' => $this->get_full_name().'[save]', 'value' => 'save'];
        $html .= \html_writer::empty_tag('input', $hiddenattrs);

        $fieldlist = new \html_table;
        $fieldlist->attributes['class'] = 'fieldlist';
        $fieldlist->head = [
            get_string($this->remotefieldstrid, 'local_o365'),
            '',
            get_string('settings_fieldmap_header_local', 'local_o365'),
        ];
        if ($this->showbehavcolumn === true) {
            $fieldlist->head[] = get_string('settings_fieldmap_header_behavior', 'local_o365');
            $fieldlist->head[] = get_string('settings_fieldmap_header_locking', 'local_o365');
        }
        $fieldlist->data = [];

        if ($data === false) {
            $data = $this->get_defaultsetting();
        }
        if (empty($data) || !is_array($data)) {
            $data = [];
        }
        foreach ($data as $fieldmap) {
            $fieldmap = explode('/', $fieldmap);

            if ($this->showbehavcolumn === true) {
                if (count($fieldmap) !== 4) {
                    continue;
                }
                list($remotefield, $localfield, $behavior, $locking) = $fieldmap;
                if (!isset($this->syncbehavopts[$behavior])) {
                    continue;
                }
            } else {
                list($remotefield, $localfield) = $fieldmap;
            }

            if (!isset($this->remotefields[$remotefield])) {
                continue;
            }
            if (!isset($this->localfields[$localfield])) {
                continue;
            }

            $row = [
                \html_writer::select($this->remotefields, $this->get_full_name().'[remotefield][]', $remotefield, false),
                \html_writer::tag('span', '&rarr;'),
                \html_writer::select($this->localfields, $this->get_full_name().'[localfield][]', $localfield, false),
            ];
            if ($this->showbehavcolumn === true) {
                $row[] = \html_writer::select($this->syncbehavopts, $this->get_full_name().'[behavior][]', $behavior, false);
                $row[] = \html_writer::select($this->synclockopts, $this->get_full_name().'[locking][]', $locking, false);
            }
            $row [] = \html_writer::tag('button', 'X', ['class' => 'removerow']);

            $fieldlist->data[] = $row;
        }
        $html .= \html_writer::table($fieldlist);

        $html .= \html_writer::tag('button', get_string('settings_fieldmap_addmapping', 'local_o365'), ['class' => 'addmapping']);

        // Add row template.
        $maptpl = \html_writer::start_tag('tr');
        $maptpl .= \html_writer::tag('td', \html_writer::select($this->remotefields, $this->get_full_name().'[remotefield][]', ''));
        $maptpl .= \html_writer::tag('td', \html_writer::tag('span', '&rarr;'));
        $maptpl .= \html_writer::tag('td', \html_writer::select($this->localfields, $this->get_full_name().'[localfield][]', ''));
        if ($this->showbehavcolumn === true) {
            $maptpl .= \html_writer::tag('td', \html_writer::select($this->syncbehavopts, $this->get_full_name().'[behavior][]', '', false));
            $maptpl .= \html_writer::tag('td', \html_writer::select($this->synclockopts, $this->get_full_name().'[locking][]', '', false));
        }
        $maptpl .= \html_writer::tag('td', \html_writer::tag('button', 'X', ['class' => 'removerow']));
        $maptpl .= \html_writer::end_tag('tr');
        $html .= \html_writer::tag('textarea', htmlentities($maptpl), ['class' => 'maptpl', 'style' => 'display:none;']);

        // Using a <script> tag here instead of $PAGE->requires->js() because using $PAGE object loads file too late.
        $scripturl = new \moodle_url('/local/o365/classes/adminsetting/fieldmap.js');
        $html .= \html_writer::script('', $scripturl->out());
        $html .= \html_writer::script('$(function() { $("#admin-'.$this->name.'").fieldmap({}); });');

        $html .= \html_writer::end_tag('div');

        return format_admin_setting($this, $this->visiblename, $html, $this->description, true, '', null, $query);
    }

    /**
     * Return the default mapping.
     */
    public static function defaultmap() {
        $default = [
            'givenName/firstname/always',
            'surname/lastname/always',
            'mail/email/always',
            'city/city/always',
            'country/country/always',
            'department/department/always',
            'preferredLanguage/lang/always',
        ];
        return $default;
    }
}

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
 * Microsoft OneDrive Repository Plugin
 * @package    repository_onedrive
 * @author Sushant Gawali (sushant@introp.net)
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft Open Technologies, Inc. (http://msopentech.com/)
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot.'/local/msaccount/msaccount_client.php');

/**
 * Microsoft onedrive repository plugin.
 *
 * @package    repository_onedrive
 */
class repository_onedrive extends repository {
    const API = 'https://apis.live.net/v5.0/';
    private $msacountapi = null;

    /**
     * Constructor
     *
     * @param int $repositoryid repository instance id.
     * @param int|stdClass $context a context id or context object.
     * @param array $options repository options.
     */
    public function __construct($repositoryid, $context = SYSCONTEXTID, $options = array()) {
        parent::__construct($repositoryid, $context, $options);

        $this->msacountapi = msaccount_api::getinstance();
    }

    /**
     * Checks whether the user is logged in or not.
     *
     * @return bool true when logged in
     */
    public function check_login() {
        return $this->msacountapi->is_logged_in();
    }

    /**
     * Print the login form, if required
     *
     * @return array of login options
     */
    public function print_login() {
        $url = $this->msacountapi->get_login_url();

        if ($this->options['ajax']) {
            $popup = new stdClass();
            $popup->type = 'popup';
            $popup->url = $url->out(false);
            return array('login' => array($popup));
        } else {
            echo '<a target="_blank" href="'.$url->out(false).'">'.get_string('login', 'repository').'</a>';
        }
    }

    /**
     * Given a path, and perhaps a search, get a list of files.
     *
     * See details on {@link http://docs.moodle.org/dev/Repository_plugins}
     *
     * @param string $path identifier for current path
     * @param string $page the page number of file list
     * @return array list of files including meta information as specified by parent.
     */
    public function get_listing($path='', $page = '') {
        $ret = array();
        $ret['dynload'] = true;
        $ret['nosearch'] = true;
        $ret['manage'] = 'https://onedrive.com/';

        $fileslist = $this->get_items_list($path);
        $fileslist = array_filter($fileslist, array($this, 'filter'));
        $ret['list'] = $fileslist;

        // Generate path bar, always start with the plugin name.
        $ret['path']   = array();
        $ret['path'][] = array('name' => $this->name, 'path' => '');

        // Now add each level folder.
        $trail = '';
        if (!empty($path)) {
            $parts = explode('/', $path);
            foreach ($parts as $folderid) {
                if (!empty($folderid)) {

                    // If it is file, then break the loop.
                    if (strpos($folderid , 'file') === 0) {
                        break;
                    }
                    $trail .= ('/'.$folderid);
                    $ret['path'][] = array('name' => $this->get_item_name($folderid), 'path' => $trail);
                }
            }
        }
        return $ret;
    }

    /**
     * Downloads a repository file and saves to a path.
     *
     * @param string $id identifier of file
     * @param string $filename to save file as
     * @return array with keys:
     *          path: internal location of the file
     *          url: URL to the source
     */
    public function get_file($id, $filename = '') {
        $path = $this->prepare_file($filename);
        return;
    }

    /**
     * Return names of the options to display in the repository form
     *
     * @return array of option names
     */
    public static function get_type_option_names() {
        return array('clientid', 'secret', 'pluginname');
    }

    /**
     * Logout from repository instance and return
     * login form.
     *
     * @return page to display
     */
    public function logout() {
        $this->msacountapi->log_out();
        return $this->print_login();
    }

    /**
     * This repository doesn't support global search.
     *
     * @return bool if supports global search
     */
    public function global_search() {
        return false;
    }

    /**
     * This repoistory supports any filetype.
     *
     * @return string '*' means this repository support any files
     */
    public function supported_filetypes() {
        return '*';
    }

    /**
     * This repostiory only supports internal files
     *
     * @return int return type bitmask supported
     */
    public function supported_returntypes() {
        return FILE_INTERNAL;
    }

    /**
     * Returns a list of OneDrive item(s) at the given path (folders or files).
     *
     * @param string $path the path containing folder id / file id.
     * @return mixed Array of items formatted for fileapi
     */
    private function get_items_list($path) {

        global $OUTPUT;

        $parts = explode('/', $path);
        $contentid = end($parts);

        if (empty($contentid)) {
            $url = self::API."/me/skydrive/files";
        } else if (strpos($contentid, 'file') === 0) {
            // Check if it is file id.
            $url = self::API.$contentid;
        } else {
            // Check if it is folder id.
            $url = self::API.$contentid."/files";
        }

        $response = json_decode($this->msacountapi->myget($url));

        $items = array();

        if (isset($response->error)) {
            return $items;
        }

        if ($response && isset($response->data)) {
            foreach ($response->data as $item) {
                $items[] = array(
                    'title' => $item->name,
                    'path' => $path.'/'.urlencode($item->id),
                    'date' => strtotime($item->updated_time),
                    'thumbnail' => $OUTPUT->pix_url(file_extension_icon($item->name, 90))->out(false),
                    'source' => $item->id,
                    'url' => $item->link,
                    'author' => $item->from->name,
                    'id' => $item->id,
                    'children' => array()
                );

            }
        } else if (!empty($response)) {
            $items[] = array(
                'title' => $response->name,
                'path' => $path,
                'date' => strtotime($response->updated_time),
                'thumbnail' => $OUTPUT->pix_url(file_extension_icon($response->name, 90))->out(false),
                'source' => $response->id,
                'url' => $response->link,
                'author' => $response->from->name,
                'id' => $response->id,
                'children' => array()
            );
        }
        return $items;
    }

    /**
     * Returns the name of the OneDrive item (folder or file) given its id.
     *
     * @param string $itemid the id of the OneDrive folder or file
     * @return mixed item name or false in case of error
     */
    private function get_item_name($itemid) {

        if (empty($itemid)) {
            throw new coding_exception('Empty item_id passed to get_item_name');
        }

        $url = self::API.$itemid;
        $response = json_decode($this->msacountapi->myget($url));

        return $response->name.".zip";
    }
}

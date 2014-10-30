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
 * Microsoft OneNote Repository Plugin
 *
 * @package    repository_onenote
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot.'/local/onenote/onenote_api.php');

/**
 * Microsoft OneNote repository plugin.
 *
 * @package    repository_onenote
 */
class repository_onenote extends repository {
    /** @var microsoft_onenote onenote oauth2 api helper object */
    private $onenote = null;

    /**
     * Constructor
     *
     * @param int $repositoryid repository instance id.
     * @param int|stdClass $context a context id or context object.
     * @param array $options repository options.
     */
    public function __construct($repositoryid, $context = SYSCONTEXTID, $options = array()) {
        parent::__construct($repositoryid, $context, $options);

        $returnurl = new moodle_url('/repository/repository_callback.php');
        $returnurl->param('callback', 'yes');
        $returnurl->param('repo_id', $this->id);
        $returnurl->param('sesskey', sesskey());

        $this->onenote = microsoft_onenote::get_onenote_api($returnurl);
        $this->check_login();
    }

    /**
     * Checks whether the user is logged in or not.
     *
     * @return bool true when logged in
     */
    public function check_login() {
        return $this->onenote->is_logged_in();
    }

    /**
     * Print the login form, if required
     *
     * @return array of login options
     */
    public function print_login() {
        $url = $this->onenote->get_login_url();

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
        $ret['manage'] = 'https://onenote.com/';

        $fileslist = $this->onenote->get_items_list($path);
        // Filter list for accepted types. Hopefully this will be done by core some day.
        $fileslist = array_filter($fileslist, array($this, 'filter'));
        $ret['list'] = $fileslist;

        // Generate path bar, always start with the plugin name.
        $ret['path']   = array();
        $ret['path'][] = array('name'=> $this->name, 'path'=>'');

        // Now add each level folder.
        $trail = '';
        if (!empty($path)) {
            $parts = explode('/', $path);
            foreach ($parts as $folderid) {
                if (!empty($folderid)) {
                    $trail .= ('/'.$folderid);
                    $ret['path'][] = array('name' => $this->onenote->get_item_name($folderid),
                                           'path' => $trail);
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
        return $this->onenote->download_page($id, $path);
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
        $this->onenote->log_out();
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
    
    
    /* TODO:
    caching code:
    @var cache_session cache of notebooknames
    var $itemnamecache = null;
    
        // Make a session cache
        $this->itemnamecache = cache::make('local_onenote', 'foldername');

     * get_item_name
     *         // Cache based on oauthtoken and item_id.
        $cachekey = $this->item_cache_key($item_id);

        if ($item_name = $this->itemnamecache->get($cachekey)) {
            return $item_name;
        }

        and:
        $this->itemnamecache->set($cachekey, $response->value[0]->name);
     
     *    /**
     * Returns a key for itemname cache
     *
     * @param string $item_id the id which is to be cached
     * @return string the cache key to use
     private function item_cache_key($item_id) {
        // Cache based on oauthtoken and item_id.
        return $this->get_tokenname().'_'.$item_id;
    }
 */
}

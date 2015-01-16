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
 * Convenient wrappers and helper for using the OneDrive API
 * @package    local_onedrive
 * @author Sushant Gawali (sushant@introp.net)
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft Open Technologies, Inc. (http://msopentech.com/)
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot.'/local/msaccount/msaccount_client.php');

/**
 * A helper class to access Microsoft OneDrive using the REST api.
 * This is a singleton class.
 *
 * @package    local_onedrive
 */
class onedrive_api {
    /** @var string Base url to access API */
    // TODO: Switch to non-beta version
    const API = 'https://apis.live.net/v5.0/'; // 'https://www.onenote.com/api/v1.0';.

    private static $instance = null;
    private $msacountapi = null;

    /**
     * Constructor.
     *
     * Initializes msaccount_api instance which is used to do moest of the underlying authentication and
     * REST API operations. This is a singleton class, do not use the constructor directly to create an instance.
     * Use the getinstance() method instead.
     */
    protected function __construct() {
        $this->msaccountapi = msaccount_api::getinstance();
    }

    /**
     * Gets the instance of onenote_api. Use this method to get an instance of the class instead of the constructor.
     * @return null|static
     */
    public static function getinstance() {
        if (null === self::$instance) {
            self::$instance = new static();
        }

        self::$instance->get_msaccount_api()->is_logged_in();

        return self::$instance;
    }

    /**
     * Return instance of the underlying msaccount_api.
     * @return null|static
     */
    public function get_msaccount_api() {
        return $this->msaccountapi;
    }

    // Helper methods.

    /**
     * Helper to call the is_logged_in() method of the msaccount_api class.
     */
    public function is_logged_in() {
        return $this->get_msaccount_api()->is_logged_in();
    }

    /**
     * Get the msaccount_api login url.
     */
    public function get_login_url() {
        return $this->get_msaccount_api()->get_login_url();
    }

    /**
     * Logout from the Microsoft Account.
     */
    public function log_out() {
        return $this->get_msaccount_api()->log_out();
    }

    /**
     * Return the HTML for the sign in widget for OneNote.
     * Please refer to the styles.css file for styling this widget.
     * @return string HTML containing the sign in widget.
     */
    public function render_signin_widget() {
        return $this->get_msaccount_api()->render_signin_widget();
    }

    /**
     * Returns a list of OneDrive item(s) at the given path (folders or files).
     *
     * @param string $path the path containing folder id / file id.
     * @return mixed Array of items formatted for fileapi
     */
    public function get_items_list($path){

        global $OUTPUT;

        $parts = explode('/', $path);
        $contentid = end($parts);

        if(empty($contentid)){
            $url = self::API."/me/skydrive/files";
        }else if(strpos($contentid, 'file') === 0){
            // Check if it is file id.
            $url = self::API.$contentid;
        }else{
            // Check if it is folder id.
            $url = self::API.$contentid."/files";
        }

        $response = json_decode($this->get_msaccount_api()->myget($url));

        $items = array();

        if (isset($response->error)) {
            return $items;
        }

        if($response && isset($response->data)){
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
        }
        elseif(!empty($response)){
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
    public function get_item_name($itemid) {

        if (empty($itemid)) {
            throw new coding_exception('Empty item_id passed to get_item_name');
        }

        $url = self::API.$itemid;
        $response = json_decode($this->get_msaccount_api()->myget($url));

        return $response->name.".zip";
    }
}

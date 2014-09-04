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
 * Functions for operating with the OneNote API
 *
 * @package    repository_onenote
 */


defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir.'/oauthlib.php');

/**
 * A helper class to access microsoft live resources using the api.
 *
 * This uses the microsoft API defined in
 * http://msdn.microsoft.com/en-us/library/hh243648.aspx
 *
 * @package    repository_onenote
 */
class microsoft_onenote extends oauth2_client {
    /** @var string OAuth 2.0 scope */
    const SCOPE = 'office.onenote_create';
    /** @var string Base url to access API */
    const API = 'https://www.onenote.com/api/v1.0';
    /** @var cache_session cache of notebooknames */
    var $notebooknamecache = null;

    /**
     * Construct a onenote request object
     *
     * @param string $clientid client id for OAuth 2.0 provided by microsoft
     * @param string $clientsecret secret for OAuth 2.0 provided by microsoft
     * @param moodle_url $returnurl url to return to after succseful auth
     */
    public function __construct($clientid, $clientsecret, $returnurl) {
        parent::__construct($clientid, $clientsecret, $returnurl, self::SCOPE);

        error_log('microsoft_onenote constructor');
        error_log(print_r($clientid, true));
        error_log(print_r($clientsecret, true));
        error_log(print_r($returnurl, true));

        // Make a session cache
        $this->notebooknamecache = cache::make('repository_onenote', 'foldername');
    }

    /**
     * Should HTTP GET be used instead of POST?
     *
     * The Microsoft API does not support POST, so we should use
     * GET instead (with the auth_token passed as a GET param).
     *
     * @return bool true if GET should be used
     */
    protected function use_http_get() {
        return false;
    }

    /**
     * Returns the auth url for OAuth 2.0 request
     * @return string the auth url
     */
    protected function auth_url() {
        return 'https://login.live.com/oauth20_authorize.srf';
    }

    /**
     * Returns the token url for OAuth 2.0 request
     * @return string the auth url
     */
    protected function token_url() {
        return 'https://login.live.com/oauth20_token.srf';
    }

    /**
     * Downloads a section to a  file from onenote using authenticated request
     *
     * @param string $id id of section
     * @param string $path path to save section to
     * @return array stucture for repository download_file
     */
    public function download_section($id, $path) {
        // TODO: how to download notebook or section?
        $url = self::API."/notebooks/".$id."/sections";

        // Microsoft live redirects to the real download location..
        $this->setopt(array('CURLOPT_FOLLOWLOCATION' => true, 'CURLOPT_MAXREDIRS' => 3));
        $content = $this->get($url);
        file_put_contents($path, $content);
        return array('path'=>$path, 'url'=>$url);
    }

    /**
     * Returns a notebook name property for a given notebookid.
     *
     * @param string $notebookid the notebook id which is passed
     * @return mixed notebook name or false in case of error
     */
    public function get_notebook_name($notebookid) {
        if (empty($notebookid)) {
            throw new coding_exception('Empty notebookid passed to get_notebook_name');
        }

        // Cache based on oauthtoken and notebookid.
        $cachekey = $this->notebook_cache_key($notebookid);

        if ($notebookname = $this->notebooknamecache->get($cachekey)) {
            return $notebookname;
        }

        $url = self::API."/notebooks/{$notebookid}";
        $ret = json_decode($this->get($url));
        if (isset($ret->error)) {
            $this->log_out();
            return false;
        }

        error_log(print_r($ret, true));

        $this->notebooknamecache->set($cachekey, $ret->value[0]->name);
        return $ret->name;
    }

    /**
     * Returns a list of items (notebooks and sections)
     *
     * @param string $path the path which we are in
     * @return mixed Array of items formatted for fileapi
     */
    public function get_items_list($path = '') {
        global $OUTPUT;

        error_log('get_items_list called');
        error_log(print_r($path, true));
        $precedingpath = '';
        $enumerating_notebooks = false;

        if (empty($path)) {
            $enumerating_notebooks = true;
            $url = self::API."/notebooks";
        } else {
            $parts = explode('/', $path);
            $currentnotebookid = array_pop($parts);
            $url = self::API."/{$currentnotebookid}/sections/";
        }

        error_log(print_r($url, true));
        $ret = json_decode($this->get($url));

        error_log(print_r($ret, true));

        if (isset($ret->error)) {
            $this->log_out();
            return false;
        }

        $items = array();

        if ($ret) {
            foreach ($ret->value as $item) {
                if ($enumerating_notebooks) {
                    $items[] = array(
                        'title' => $item->name,
                        //'size' => $item->size,
                        'date' => strtotime($item->lastModifiedTime),
                        'thumbnail' => $OUTPUT->pix_url(file_extension_icon($item->name, 90))->out(false),
                        'source' => $item->id,
                        'url' => $item->self,
                        'author' => $item->createdBy,
                        'children' => array()
                    );
                } else {
                    $items[] = array(
                        'title' => $item->name,
                        //'size' => $item->size,
                        'date' => strtotime($item->lastModifiedTime),
                        'thumbnail' => $OUTPUT->pix_url(file_extension_icon($item->name, 90))->out(false),
                        'source' => $item->id,
                        'url' => $item->self,
                        'author' => $item->createdBy
                    );
                }
            }
        }

        return $items;
    }

    /**
     * Returns a key for notebooknane cache
     *
     * @param string $notebookid the notebook id which is to be cached
     * @return string the cache key to use
     */
    private function notebook_cache_key($notebookid) {
        // Cache based on oauthtoken and notebookid.
        return $this->get_tokenname().'_'.$notebookid;
    }
}

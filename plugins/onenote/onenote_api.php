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
    const SCOPE = 'office.onenote_update';
    /** @var string Base url to access API */
    const API = 'https://www.onenote.com/api/v1.0';
    /** @var cache_session cache of notebooknames */
    var $notebooknamecache = null;
    private $isget = TRUE; 
    /**-
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
            return $this->isget;    
    }

    /**
     * Returns the auth url for OAuth 2.0 request
     * @return string the auth url
     */
    protected function auth_url() {
        return 'https://login.live.com/oauth20_authorize.srf';
    }

    /**
     * Returns the token url for OAuth 12.0 request
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
     public function download_section($section_id, $path) {
        error_log('download_section called: ' . print_r($section_id, true));

        // TODO: how to download notebook or section?
        $url = self::API."/sections/".$section_id."/pages";
        error_log(print_r($url,true)); 
        // Microsoft live redirects to the real download location..
        $this->setopt(array('CURLOPT_FOLLOWLOCATION' => true, 'CURLOPT_MAXREDIRS' => 3));
        $this->isget = FALSE;
        $this->request($url);        
        $response = $this->get($url);
        $this->isget = TRUE;
        $response = json_decode($response);

        error_log("response: " . print_r($response, true));

        if (!$response || isset($response->error)) {
            $this->log_out();
            return null;
        }

        file_put_contents($path, $response->value);
        return array('path'=>$path, 'url'=>$url);
    }

    /**
     * Returns a notebook name property for a given notebookid.
     *
     * @param string $notebookid the notebook id which is passed
     * @return mixed notebook name or false in case of error
     */
    public function get_notebook_name($notebookid) {
        error_log('get_notebook_name called: ' . print_r($notebookid, true));

        if (empty($notebookid)) {
            throw new coding_exception('Empty notebookid passed to get_notebook_name');
        }

        // Cache based on oauthtoken and notebookid.
        $cachekey = $this->notebook_cache_key($notebookid);

        if ($notebookname = $this->notebooknamecache->get($cachekey)) {
            return $notebookname;
        }

        $url = self::API."/notebooks/{$notebookid}";
        $this->isget = FALSE;
        $this->request($url);
        $response = json_decode($this->get($url));
        $this->isget = TRUE;
        error_log('response: ' . print_r($response, true));

        if (!$response || isset($response->error)) {
            $this->log_out();
            return false;
        }

        $this->notebooknamecache->set($cachekey, $response->value[0]->name);
        return $response->value[0]->name;
    }

    /**
     * Returns a list of items (notebooks and sections)
     *
     * @param string $path the path which we are in
     * @return mixed Array of items formatted for fileapi
     */
    public function get_items_list($path = '') {
        global $OUTPUT;

        $precedingpath = '';
        $enumerating_notebooks = false;

        if (empty($path)) {
            $enumerating_notebooks = true;
            $url = self::API."/notebooks";
        } else {
            $parts = explode('/', $path);
            $currentnotebookid = array_pop($parts);
            $url = self::API."/notebooks/{$currentnotebookid}/sections/";
        }

 
         $this->isget = FALSE;
         $this->request($url);
         $response = json_decode($this->get($url));
         $this->isget = TRUE;
         
          
         if (isset($response->error)) {
            $this->log_out();
            return false;
        }

        $items = array();
        
            
        if ($response && $response->value) {
            foreach ($response->value as $item) {
                if ($enumerating_notebooks) {
                    $items[] = array(
                        'title' => $item->name,
                        'path' => $path.'/'.urlencode($item->id),
                        //'size' => $item->size,
                        'date' => strtotime($item->lastModifiedTime),
                        'thumbnail' => $OUTPUT->pix_url(file_extension_icon($item->name, 90))->out(false),
                        'source' => $item->id,
                        'url' => $item->self,
                        'author' => $item->createdBy,
                        'id' => $item->id,
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
        if(isset($items->id)) {
            $this->insert_notes($items);    
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

    private function insert_notes($notes) {
        $noteurl = self::API."/notebooks/";                
        $courses = enrol_get_my_courses();
        error_log(print_r($notes,true));
        $notes_array = array();
            if($notes) {
              foreach ($notes as $note) {
                if($note['id']) {
                    $not[$note['id']] = $note['title'];                
                    array_push($notes_array,$not);    
                }  
                                
               }    
            }
            
            if(count($notes_array) != ''){  
                 foreach($notes_array as $notes) {
                    if(!(in_array('MoodleNote', $notes))){                        
                     $param = array(
                          "name" => "MoodleNote"   
                         );                         
                     $note_name = json_encode($param);
                     $this->setHeader('Content-Type: application/json');
                     $this->isget = FALSE;
                     $this->request($noteurl);
                     $created_notes = json_decode($this->post($noteurl,$note_name));
                     $this->isget = TRUE;
                     //$created_notes = create_oneNote_notes($access_token->token,$note_name);                     
                     $note_id = $created_notes->id;                                          
                     if($courses) {            
                        foreach($courses as $course) {                            
                            $param_section = array(
                                     "name" => $course->fullname
                                        );                        
                             $section = json_encode($param_section);                            
                             $sectionurl = self::API."/notebooks/".$note_id."/sections/";
                             $this->setHeader('Content-Type: application/json');
                             $this->isget = FALSE;
                             $this->request($sectionurl);
                             $getsection = json_decode($this->post($sectionurl,$section));
                             $this->isget = TRUE;
                             error_log(print_r($getsection, true));
                        }
                     }                            
                 } else {                     
                     $note_id = array_search("MoodleNote", $notes);
                     error_log("hereeee");
                     error_log(print_r($note_id,true));
                     $sectionurl = self::API."/notebooks/".$note_id."/sections/";
                     $this->setHeader('Content-Type: application/json');
                     $this->isget = FALSE;
                     $this->request($sectionurl);
                     $getsection = json_decode($this->get($sectionurl));
                     $this->isget = FALSE;
                     error_log(print_r($getsection, true));
                     
                     $sections = array();
                     if(isset($getsection->value)) {
                        foreach($getsection->value as $section) {      
                              array_push($sections,$section->name);                  
                          }             
                     }
                     if($courses) {            
                        foreach($courses as $course) {
                            if(!in_array($course->fullname, $sections)) {
                                $param_section = array(
                                     "name" => $course->fullname
                                        );                        
                                $section = json_encode($param_section);
                                $this->setHeader('Content-Type: application/json');
                                $this->isget = FALSE;
                                $this->request($sectionurl);
                                $eventresponse = $this->post($sectionurl,$section);
                                $this->isget = TRUE;
                                //create_oneNote_section($access_token->token, $note_id, $section);
                             }
                            }
                         }
                     }
            
                 } 
             } else {                    
                    $param = array(
                          "name" => "MoodleNote"   
                         );
                         
                     $note_name = json_encode($param);
                     $this->setHeader('Content-Type: application/json');
                     $this->isget = FALSE;
                     $this->request($noteurl);
                     $created_notes = json_decode($this->post($noteurl,$note_name));
                     $this->isget = TRUE;                     
                     error_log(print_r($created_notes,true));
                     $note_id = $created_notes->id;
                     $sectionurl = self::API."/notebooks/".$note_id."/sections/";
                     if($courses) {            
                        foreach($courses as $course) {
                            $param_section = array(
                                     "name" => $course->fullname
                                        );                        
                            $section = json_encode($param_section);
                          //  $eventresponse = create_oneNote_section($access_token->token, $note_id, $section);
                            $this->setHeader('Content-Type: application/json');
                            $this->isget = FALSE;
                            $this->request($sectionurl);
                            $eventresponse = $this->post($sectionurl,$section);
                            $this->isget = TRUE;            
                        }
                     } 
             }  
         
    }

}
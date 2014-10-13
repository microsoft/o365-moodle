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
 * Tests for notes events.
 *
 * @package    core_notes
 * @copyright  2013 Ankit Agarwal
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later.
 */

defined('MOODLE_INTERNAL') || die();
global $CFG;
require_once($CFG->dirroot.'/lib/oauthlib.php');
require_once($CFG->dirroot.'/repository/onenote/onenote_api.php');
/**
 * Class microsoft_onenote_testcase
 *
 */
class microsoft_onenote_testcase extends advanced_testcase {

    /** @var  stdClass A note object. */
    private $onenote_test;
    
    public function  setup() {
    	$returnurl = new moodle_url('/repository/repository_callback.php');
    	$this->onenote_test = new microsoft_onenote(get_config('onenote', 'clientid'), get_config('onenote', 'secret'), $returnurl);
    	 //$onenote_api = microsoft_onenote::get_onenote_api();
	    //$onenote_token = $onenote_api->get_accesstoken();
    }
    
    
	public function test_microsoftinstance() {
		/*$returnurl = new moodle_url('/repository/repository_callback.php');
		$this->onenote_test = new microsoft_onenote('', '', $returnurl);*/
		$onenote_api = $this->onenote_test->get_onenote_api();
		//$onenote_api = microsoft_onenote::get_onenote_api();
     }
    
     public function test_getitemname() {
     	
     }
    
    /*public function  test_getMicrosoftOnenoteapi() {    	
    	$onenote_api = microsoft_onenote::get_onenote_api();
        $onenote_token = $onenote_api->get_accesstoken();      
        
        
    }*/
   
}

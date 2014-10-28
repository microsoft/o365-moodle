<?php
//use MyProject\Proxies\__CG__\OtherProject\Proxies\__CG__\stdClass;
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
require_once($CFG->dirroot . '/mod/assign/tests/base_test.php');
/**
 * Class microsoft_onenote_testcase
 *
 */
class microsoft_onenote_testcase extends advanced_testcase {

    /** @var  stdClass A note object. */
    private $onenote_api;
    
    private $accesstoken;
    /** @var stdClass $user A user to submit an assignment. */
    protected $user;

    /** @var stdClass $course New course created to hold the assignment activity. */
    protected $course1;
    protected $course2;

    /** @var stdClass $cm A context module object. */
    protected $cm;

    /** @var stdClass $context Context of the assignment activity. */
    protected $context;

    /** @var stdClass $assign The assignment object. */
    protected $assign;
    
    
    
    public function  setup() {
    	global $DB;    	
    	$this->resetAfterTest(true);
    	$this->user = $this->getDataGenerator()->create_user();
    	$this->course1  = $this->getDataGenerator()->create_course();
    	$this->course2 = $this->getDataGenerator()->create_course();
    	
    	//setting user and enrolling to the courses created with teacher role.
    	$this->setUser($this->user->id);
    	$c1ctx = context_course::instance($this->course1->id);
    	$c2ctx = context_course::instance($this->course2->id);
    	$this->getDataGenerator()->enrol_user($this->user->id, $this->course1->id,4);
    	$this->getDataGenerator()->enrol_user($this->user->id, $this->course2->id,4);
    	$this->assertCount(1, get_enrolled_users($c1ctx));
    	$this->assertCount(1, get_enrolled_users($c2ctx));
    	$this->assertCount(2, enrol_get_my_courses());
    	$courses = enrol_get_my_courses();
    	 
    	$this->onenote_api = microsoft_onenote::get_onenote_api();
    //	error_log("incourse");
    //	error_log(print_r($courses,true));
   // 	error_log("inenrolcourse");
    	/*$token = new stdClass();
    	$token->token = "EwB4Aq1DBAAUGCCXc8wU/zFu9QnLdZXy+YnElFkAAbJ035V/2j8ddS2CiJoMRf938a1DxEtErYcOSNmU8FF8lN10sdICPX2s6o42PTR3G1TE0cVGLGGUs1/nzRWjlx3HRKYW7bGBUPCba8XExfLsjs2FVLZBMG0gUHAA1e54xqp3qI1nYHzN9P16u9O6oHuDTP6njK6GCoamsVL1naxoSCCWMRs/2t1CHiSUB1WQ2zMo5g5dRzvxp+4SCISIo5UcSBuzzsKVX/pPR1JoxZTQLbFrogQYxc2YrPtoUX8riw0OiosOVgSUyQDKRDtQEZwdNGKR2NijNc6EDf35ljo3b29FVYT7RQahG6M5I7h50eXYK4CvUoQO6ZRAwwHnqSADZgAACKfRC9CAJ+LoSAFtg/G8N7RlRlQvkgjyULJaDa34gWN+Wex/CrUF16SF/hgOB56G8kziTs5ub8wK4cI5yE57vNQ3Xc7BfHFkBKLH2UR0lSc9pm+wu7WKBEC5T2th4JcqrqpK1vqWcqOxQFTwj6UM6mPu+zsQJ2QjE4NYyd6HdpqHdk8iNbc3phvdW/oXflH/Tl8QJY7Gu7WWjy/nk//h0ZG5G3//kbFWzF+zO+tdtMbPxGjmxw5FNRsxKg956pt8IEsl9UhZvWa/tSh219gFgqn+xyLpejmaho6Of0zkaPSu2NLMq6hzJM+NI6dHM+eL3Y3OhcDg9616wGFwj2unwCl8PD893TrCIDHN1PUrxgDOLFr1WJC06ZavYMtApHB8XkaiGxhJJR0/zItmtILK7GnJDKLlSsWBsnJ+m9KHZZILrSKPgVQFvye44/93NUDwAOfPZAE=";
    	$token->expires = "1413460546";
        $this->setAccessToken($token);
    	 */
      	//$onenote_token = $this->onenote_api->get_onenote_token
    	
    }
    
   /* public function setAccessToken($token) {
    	$this->accesstoken = $token;  
    }*/
   
    public function test_getmicrosoft_repo() {
       $onenote_id = $this->onenote_api->get_onenote_repo_id();
       $this->assertNotEmpty($onenote_id,"No value");       	
    }
    
   
    public function test_getitemlist() { 
    	   	 	
    	$item_list = $this->onenote_api->get_items_list();    
    	$this->assertNotEmpty($item_list,"No value");
    }
    
    
     public function test_getpage() {
     	
     	$item_list = $this->onenote_api->get_items_list();
     	$generator = $this->getDataGenerator()->get_plugin_generator('mod_assign');
     	$params['course'] = $this->course1->id;
     	$instance = $generator->create_instance($params);
     	$this->cm = get_coursemodule_from_instance('assign', $instance->id);
     	$this->context = context_module::instance($this->cm->id);
     	$this->assign = new testable_assign($this->context, $this->cm, $this->course1);
     	$assign_details = $this->assign->get_instance();
     	$assign_id = $assign_details->id; 
     	$save_assigment = $this->onenote_api->get_page($assign_id,false);
      	print_r($save_assigment);
     	
     }

   
}

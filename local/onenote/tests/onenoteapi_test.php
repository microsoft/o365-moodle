<?php
/**
 * Unit tests for the onenote_api class.
 *
 * In order to run these tests, you need to do the following:
 * 1) Create a file phpu_config_data.json and place it in the same folder as this file.
 * 2) The file should contain config data for running these unit tests: 
 * {
    "client_id": "valid client id for the Microsoft application you want to use for testing",
    "client_secret": "valid client secret for the Microsoft application you want to use for testing",
    "refresh_tokens": [
        "valid refresh token for the first Microsoft Account user you want to use for testing", 
        "valid refresh token for the second Microsoft Account user you want to use for testing"
     ]
   }
   3) Run the unit tests using the standard process for running PHP Unit tests for Moodle.
 */
defined('MOODLE_INTERNAL') || die();
global $CFG;
require_once ($CFG->dirroot . '/local/onenote/onenote_api.php');
require_once ($CFG->dirroot . '/mod/assign/tests/base_test.php');

/**
 * Class microsoft_onenote_testcase
 */
class microsoft_onenote_testcase extends advanced_testcase
{
    private $onenote_api;

    protected $user;

    protected $user1;

    protected $course1;

    protected $course2;

    protected $cm;

    protected $cm1;

    protected $context;

    protected $context1;

    protected $assign;

    protected $assign1;
    
    protected $config;

    public function setup()
    {
        global $CFG;
        
        $this->resetAfterTest(true);
        
        // read settings from config.json
        $config_data = file_get_contents($CFG->dirroot . '/local/onenote/tests/phpu_config_data.json');
        if (!$config_data) {
            echo 'Please provide PHPUnit testing configs in a config.json file';
            return false;
        }
        
        $this->config = json_decode($config_data, false);
        
        $this->user = $this->getDataGenerator()->create_user();
        $this->user1 = $this->getDataGenerator()->create_user();
        $this->course1 = $this->getDataGenerator()->create_course();
        $this->course2 = $this->getDataGenerator()->create_course();
        
        // setting user and enrolling to the courses created with teacher role.
        $this->setUser($this->user->id);
        $c1ctx = context_course::instance($this->course1->id);
        $c2ctx = context_course::instance($this->course2->id);
        $this->getDataGenerator()->enrol_user($this->user->id, $this->course1->id, 4);
        $this->getDataGenerator()->enrol_user($this->user->id, $this->course2->id, 4);
        $this->assertCount(2, enrol_get_my_courses());
        $courses = enrol_get_my_courses();
        
        // student enrollment
        $this->setUser($this->user1->id);
        $this->getDataGenerator()->enrol_user($this->user1->id, $this->course1->id, 5);
        $this->getDataGenerator()->enrol_user($this->user1->id, $this->course2->id, 5);
        
        $this->assertCount(2, get_enrolled_users($c1ctx));
        // $this->assertCount(2, get_enrolled_users($c2ctx));
    }

    public function set_test_config() {
        set_config('clientid', $this->config->client_id, 'local_msaccount');
        set_config('clientsecret', $this->config->client_secret, 'local_msaccount');
        $this->onenote_api = onenote_api::getInstance();
    }

    public function set_user($index)
    {
        if ($index == 0)
            $this->setUser($this->user->id);
        else
            $this->setUser($this->user1->id);
        
        $this->onenote_api->get_msaccount_api()->store_refresh_token($this->config->refresh_tokens[$index]);
        $this->assertEquals(true, $this->onenote_api->get_msaccount_api()->refresh_token());
        $this->assertEquals(true, $this->onenote_api->get_msaccount_api()->is_logged_in());
    }

    public function test_getitemlist()
    {
        $this->set_test_config();
        $this->set_user(0);
        
        $item_list = $this->onenote_api->get_items_list();
        $note_section_names = array();
        $course1 = $this->course1->fullname;
        $course2 = $this->course2->fullname;
        $expected_names = array(
            'Moodle Notebook',
            $course1,
            $course2
        );
        
        foreach ($item_list as $item)
            if ($item['title'] == "Moodle Notebook") {
                array_push($note_section_names, "Moodle Notebook");
                $item_list = $this->onenote_api->get_items_list($item['path']);
                foreach ($item_list as $item) {
                    array_push($note_section_names, $item['title']);
                }
            }
        
        $this->assertTrue(in_array("Moodle Notebook", $note_section_names), "Moodle Notebook not present");
        $this->assertTrue(in_array($course1, $note_section_names), "Test course1 is not present");
        $this->assertTrue(in_array($course2, $note_section_names), "Test course2 is  not present");
        $this->assertTrue(count($expected_names) == count(array_intersect($expected_names, $note_section_names)), "Same elements are not present");
        $this->assertNotEmpty($item_list, "No value");
    }

    public function test_getpage()
    {
        $this->set_test_config();
        $this->set_user(0);
        
        $item_list = $this->onenote_api->get_items_list();
        
        // Creating a testable assignment
        $generator = $this->getDataGenerator()->get_plugin_generator('mod_assign');
        $params['course'] = $this->course1->id;
        $instance = $generator->create_instance($params);
        $this->cm = get_coursemodule_from_instance('assign', $instance->id);
        $this->context = context_module::instance($this->cm->id);
        $this->assign = new testable_assign($this->context, $this->cm, $this->course1);
        $assign_details = $this->assign->get_instance();
        $assign_id = $assign_details->id;
        
        // To get the notebooks of student
        $this->set_user(1);
        
        $item_list = $this->onenote_api->get_items_list();
        
        // Student submission to onenote
        $create_submission = $this->create_submission_feedback($this->cm, false, false, null, null, null);
        $this->submission = $this->assign->get_user_submission($this->user1->id, true);
        
        // Saving the assignment
        $data = new stdClass();
        $saveassign = new assign_submission_onenote($this->assign, '');
        $save_assign = $saveassign->save($this->submission, $data);
        
        // Creating feedback for submission
        $this->set_user(0);
        
        // Saving the grade
        $this->grade = $this->assign->get_user_grade($this->user1->id, true);
        $gradeassign = new assign_feedback_onenote($this->assign, '');
        $grade_assign = $gradeassign->save($this->grade, $data);
        $grade_id = $this->grade->grade;
        $create_feedback = $this->create_submission_feedback($this->cm, true, true, $this->user1->id, $this->submission->id, $grade_id);
        
        if (filter_var($create_submission, FILTER_VALIDATE_URL)) {
            if (strpos($this->course1->fullname, urldecode($create_submission))) {
                $this->assertTrue("The value is present");
            }
        }
        
        if (filter_var($create_feedback, FILTER_VALIDATE_URL)) {
            if (strpos($this->course1->fullname, urldecode($create_feedback))) {
                $this->assertTrue("The value is present");
            }
        }
    }

    public function test_downloadpage()
    {
        $this->set_test_config();
        $this->set_user(0);
        
        $item_list = $this->onenote_api->get_items_list();
        $generator = $this->getDataGenerator()->get_plugin_generator('mod_assign');
        $params['course'] = $this->course2->id;
        $instance = $generator->create_instance($params);
        $this->cm = get_coursemodule_from_instance('assign', $instance->id);
        $this->context = context_module::instance($this->cm->id);
        $this->assign = new testable_assign($this->context, $this->cm, $this->course2);
        $assign_details = $this->assign->get_instance();
        $assign_id = $assign_details->id;
        
        // To get the notebooks of student
        $this->set_user(1);
        $item_list = $this->onenote_api->get_items_list();
        
        $create_submission = $this->create_submission_feedback($this->cm, false, false, null, null, null);
        $this->submission = $this->assign->get_user_submission($this->user1->id, true);
        // Saving the assignment
        $data = new stdClass();
        $saveassign = new assign_submission_onenote($this->assign, '');
        $save_assign = $saveassign->save($this->submission, $data);
        
        $this->assertNotEmpty($save_assign, "File has not created");
    }

    public function create_submission_feedback($cm, $want_feedback_page = false, $is_teacher = false, $submission_user_id = null, $submission_id = null, $grade_id = null)
    {
        $submission_feedback = $this->onenote_api->get_page($cm->id, $want_feedback_page, $is_teacher, $submission_user_id, $submission_id, $grade_id);
        return $submission_feedback;
    }
}

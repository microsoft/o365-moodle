<?php
require_once($CFG->dirroot.'/local/oevents/office_lib.php');

class block_oemail extends block_list {
    public function init() {
        $this->title = get_string('oemail', 'block_oemail');
    }

    public function get_content() {
        if (!isloggedin()) {
            return null;
        }

        if ($this->content !== null) {
            return $this->content;
        }

        $this->content = $this->_get_content();

        return $this->content;
    }

    public function _get_content() {
        global $SESSION;

        // get email from Office365
        $messages = o365_get_messages($SESSION->accesstoken);
        //error_log(print_r($messages, true));

        $content = new stdClass;
        $content->items = array();
        $content->icons = null; //array();

        foreach ($messages->value as $message) {
            $content->items[] = html_writer::tag('a', $message->Subject, array('href' => "https://outlook.office365.com/EWS/OData/Me/Messages('" . $message->Id . "')"));
            //$content->icons[] = html_writer::empty_tag('img', array('src' => 'images/icons/1.gif', 'class' => 'icon'));
        }

        $content->footer = (is_array($messages->value) && (count($messages->value) > 0)) ? (count($messages->value) . " Messages.") : "No messages.";

        return $content;
    }

    public function cron() {
        mtrace( "Office365 Email cron script is starting." );

        $this->content = $this->_get_content();

        mtrace( "Office365 Email cron script completed." );

        return true;
    }
}
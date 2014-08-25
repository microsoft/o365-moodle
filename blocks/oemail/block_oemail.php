<?php
require_once($CFG->dirroot.'/local/oevents/office_lib.php');
require_once($CFG->dirroot.'/local/oevents/util.php');

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
        
        check_token_expiry();
        
        date_default_timezone_set('UTC');
        // get email from Office365
        $messages = o365_get_messages($SESSION->accesstoken);
        //echo "<pre>";
      //  print_r($messages);exit;
        
        //error_log(print_r($messages, true));

        $content = new stdClass;
        $content->items = array();
        $content->icons = null; //array();
        $content->items[] = "<table border='1'><tr><td>From</td><td>Subject</td><td>Date</td></tr>"; 
        foreach ($messages->value as $message) {
            //echo "<pre>";print_r($message);exit;
            $date_rec = strtotime($message->DateTimeReceived);
            $date_rec = date("M j G:i:s",$date_rec);//"https://outlook.office365.com/EWS/OData/Me/Messages('" . $message->Id . "')"
            $content->items[] ="<tr><td>".$message->From->Name."</td><td>". 
                                html_writer::tag('a', $message->Subject, array('class'=> 'maillink','href' =>"mailto:".$message->ToRecipients[0]->Address.
                                "?subject=".$message->Subject."&body=".$message->Body->Content))."</td>
                                <td>".$date_rec."</td></tr>";
            //$content->icons[] = html_writer::empty_tag('img', array('src' => 'images/icons/1.gif', 'class' => 'icon'));
        }
        $content->items[] = "</table>";
        $content->footer = (is_array($messages->value) && (count($messages->value) > 0)) ? (count($messages->value) . " Messages.") : "No messages.";
       
        return $content;
    }
    //TODO install outlook in local, then need to pass the items to the function.
    public function open_mail(){
        $objApp = new COM("Outlook.Application") or die("Couldnot open");        
        $myItem = $objApp->CreateItem(0);        
        $myItem->To='recip@ient.com';        
        $myItem->SentOnBehalfOfName = 'from@address.com';        
        $myItem->Subject="This is a test";        
        $myItem->Body="This is a Body Section now.....!";        
        $myItem->Display(); 
    }
    

    public function cron() {
        mtrace( "Office365 Email cron script is starting." );

        $this->content = $this->_get_content();

        mtrace( "Office365 Email cron script completed." );

        return true;
    }
}


<?php
require_once($CFG->dirroot.'/lib/oauthlib.php');
require_once($CFG->dirroot.'/repository/onenote/onenote_api.php');

class block_onenote extends block_list {
    public function init() {
        $this->title = get_string('onenote', 'block_onenote');
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
        global $USER, $COURSE;
        
        error_log('_get_content called');
        $content = new stdClass;
        $content->items = array();
        $content->icons = '';

        $onenote_api = microsoft_onenote::get_onenote_api();
        $onenote_token = $onenote_api->get_accesstoken();
        
        if (isset($onenote_token)) {
            // add the "save to onenote" button if this is a file upload type of assignment
            $cm_instance_id = optional_param('id', null, PARAM_INT);
            
            if ($cm_instance_id) {
                if (!microsoft_onenote::is_teacher($COURSE->id, $USER->id)) {
                    $action_params['action'] = 'save';
                    $action_params['id'] = $cm_instance_id;
                    $url = new moodle_url('/blocks/onenote/onenote_actions.php', $action_params);
    
                    $content->items[] =
                        '<a onclick="window.open(this.href,\'_blank\'); setTimeout(function(){ location.reload(); }, 2000); return false;" href="' . 
                        $url->out(false) . 
                        '" class="onenote_linkbutton">' . 'Work on the assignment in OneNote' . '</a>';
    
                    $content->items[] = '<br/>';
                }
            
                $notes = $onenote_api->get_items_list('');
                
                if ($notes) {
//                     $content->items[] = '<div class="box block_tree_box">' .
//                     '<ul class="block_tree list"><li class="type_unknown contains_branch" aria-expanded="true"><p class="tree_item branch root_node"><a href="http://vinlocaldomain.com:88/my/">Your Notebooks</a></p><ul>' .
//                     '<li class="type_setting collapsed item_with_icon"><p class="tree_item leaf"><a href="http://vinlocaldomain.com:88/blog/index.php?courseid=0"><img alt="" class="smallicon navicon" title="" src="http://vinlocaldomain.com:88/theme/image.php/clean/core/1413927861/i/navigationitem" />Site blogs</a></p></li>' .
//                     '<li class="type_setting collapsed item_with_icon"><p class="tree_item leaf"><a href="http://vinlocaldomain.com:88/badges/view.php?type=1"><img alt="" class="smallicon navicon" title="" src="http://vinlocaldomain.com:88/theme/image.php/clean/core/1413927861/i/navigationitem" />Site badges</a></p></li>' .
//                     '</ul></li></ul></div>';
                    
                    foreach ($notes as $note) {
                        $content->items[] = '<a href="' . $note['url'] . '" target="_blank">' . $note['title'] . '</a>';
                    }
                } else {
                    $content->items[] = "No notebooks";
                }
            }
        } else {
            $content->items[] = microsoft_onenote::get_onenote_signin_widget();
        }

        return $content;
    }
}

require_once($CFG->dirroot.'/blocks/onenote/onenote.html');

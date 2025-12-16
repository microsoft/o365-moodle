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
 * Boost o365teams mod_quiz renderer.
 *
 * @package    theme_boost_o365teams
 * @copyright  2018 Enovation Solutions
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/mod/quiz/renderer.php');

/**
 * mod_quiz
 *
 * @package    theme_boost_o365teams
 * @copyright  2018 Enovation Solutions
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class theme_boost_o365teams_mod_quiz_renderer extends \mod_quiz\output\renderer {
    /**
     * Ouputs the form for making an attempt
     *
     * @param quiz_attempt $attemptobj
     * @param int $page Current page number
     * @param array $slots Array of integers relating to questions
     * @param int $id ID of the attempt
     * @param int $nextpage Next page number
     */
    public function attempt_form($attemptobj, $page, $slots, $id, $nextpage) {
        $output = '';

        // Start the form.
        $output .= html_writer::start_tag(
            'form',
            ['action' => new moodle_url(
                $attemptobj->processattempt_url(),
                ['cmid' => $attemptobj->get_cmid()]
            ), 'method' => 'post',
                'enctype' => 'multipart/form-data', 'accept-charset' => 'utf-8',
            'id' => 'responseform']
        );
        $output .= html_writer::start_tag('div');

        // Print all the questions.
        foreach ($slots as $slot) {
            $output .= $attemptobj->render_question(
                $slot,
                false,
                $this,
                $attemptobj->attempt_url($slot, $page),
                $this
            );
        }

        $navmethod = $attemptobj->get_quiz()->navmethod;
        $output .= $this->attempt_navigation_buttons_with_link(
            $page,
            $attemptobj->is_last_page($page),
            $navmethod,
            $attemptobj->view_url()
        );

        // Some hidden fields to trach what is going on.
        $output .= html_writer::empty_tag('input', ['type' => 'hidden', 'name' => 'attempt',
            'value' => $attemptobj->get_attemptid()]);
        $output .= html_writer::empty_tag('input', ['type' => 'hidden', 'name' => 'thispage',
            'value' => $page, 'id' => 'followingpage']);
        $output .= html_writer::empty_tag('input', ['type' => 'hidden', 'name' => 'nextpage',
            'value' => $nextpage]);
        $output .= html_writer::empty_tag('input', ['type' => 'hidden', 'name' => 'timeup',
            'value' => '0', 'id' => 'timeup']);
        $output .= html_writer::empty_tag('input', ['type' => 'hidden', 'name' => 'sesskey',
            'value' => sesskey()]);
        $output .= html_writer::empty_tag('input', ['type' => 'hidden', 'name' => 'scrollpos',
            'value' => '', 'id' => 'scrollpos']);

        // Add a hidden field with questionids. Do this at the end of the form, so
        // if you navigate before the form has finished loading, it does not wipe all
        // the student's answers.
        $output .= html_writer::empty_tag('input', ['type' => 'hidden', 'name' => 'slots',
            'value' => implode(',', $attemptobj->get_active_slots($page))]);

        // Finish the form.
        $output .= html_writer::end_tag('div');
        $output .= html_writer::end_tag('form');

        $output .= $this->connection_warning();

        return $output;
    }

    /**
     * Display the prev/next buttons that go at the bottom of each page of the attempt.
     * A new "return to quiz menu" button is added in the custom renderer function.
     *
     * This function is created based on attemp_navigation_buttons() function of parent class.
     *
     * @param int $page the page number. Starts at 0 for the first page.
     * @param bool $lastpage is this the last page in the quiz?
     * @param string $navmethod Optional quiz attribute, 'free' (default) or 'sequential'
     * @param string|bool $viewurl URL to the view quiz page.
     * @return string HTML fragment.
     */
    protected function attempt_navigation_buttons_with_link($page, $lastpage, $navmethod = 'free', $viewurl = null) {
        $output = '';

        $output .= html_writer::start_tag('div', ['class' => 'submitbtns submitbtns_with_return']);
        if ($page > 0 && $navmethod == 'free') {
            $output .= html_writer::empty_tag('input', ['type' => 'submit', 'name' => 'previous',
                'value' => get_string('navigateprevious', 'quiz'), 'class' => 'mod_quiz-prev-nav btn btn-secondary']);
        }

        if ($lastpage) {
            $nextlabel = get_string('endtest', 'quiz');
        } else {
            $nextlabel = get_string('navigatenext', 'quiz');
        }

        $output .= html_writer::empty_tag('input', ['type' => 'submit', 'name' => 'next',
            'value' => $nextlabel, 'class' => 'mod_quiz-next-nav btn btn-primary']);
        if ($viewurl) {
            // Return button.
            $output .= html_writer::link(
                $viewurl,
                get_string('navigatereturn', 'theme_boost_o365teams'),
                ['class' => 'btn btn-secondary mod_quiz-return-nav']
            );
        }

        $output .= html_writer::end_tag('div');

        return $output;
    }

    /**
     * No Question message
     *
     * @param boolean $canedit
     * @param url $editurl
     * @return string
     */
    public function no_questions_message($canedit, $editurl) {
        $output = '';
        $output .= $this->notification(get_string('noquestions', 'quiz'));
        if ($canedit) {
            $output .= $this->single_button($editurl, get_string('editquiz', 'quiz'), 'get', ["primary" => true]);
        }

        return $output;
    }
}

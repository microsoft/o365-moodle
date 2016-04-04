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
 * Language file definitions for OneNote local plugin
 * @package    local_onenote
 * @author Vinayak (Vin) Bhalerao (v-vibhal@microsoft.com)
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright  Microsoft, Inc.
 */

$string['pluginname'] = 'Microsoft OneNote';
$string['submissiontitle'] = 'Submission: {$a->assign_name} [{$a->student_firstname} {$a->student_lastname}]';
$string['feedbacktitle'] = 'Feedback: {$a->assign_name} [{$a->student_firstname} {$a->student_lastname}]';
$string['connction_error'] = 'Cannot connect to OneNote. Please wait a few moments and retry.';
$string['onenote_page_error'] = 'Could not open the OneNote page for this submission or feedback.';
$string['error_noapiavailable'] = 'No OneNote API is available. If using the Office 365 plugin set, we were not able to contact OneNote. Otherwise, please install local_msaccount.';
$string['notebookname'] = 'Moodle Notebook';
$string['erroronenoteapibadcall'] = 'Error in API call.';
$string['erroronenoteapibadcall_message'] = 'Error in API call: {$a}';
$string['errornosection'] = 'Could not get or create a section in your OneNote Notebook';
$string['errornopostdata'] = 'Could not create page data to send to OneNote.';
$string['errorsubmissioninteachercontext'] = 'Attempted to create a submission from teacher grading context.';
$string['errorfeedbackinstudentcontext'] = 'Attempted to create feedback in student submission context.';
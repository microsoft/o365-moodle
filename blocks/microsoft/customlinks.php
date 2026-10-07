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
 * This page allows administrators to manage the custom links shown in the block.
 *
 * @package block_microsoft
 * @author Lai Wei <lai.wei@enovation.ie>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2026 onwards Microsoft, Inc. (http://microsoft.com/)
 */

use core\context\system;
use core\url;

require_once(__DIR__ . '/../../config.php');
require_once($CFG->libdir . '/adminlib.php');
require_once($CFG->dirroot . '/blocks/microsoft/classes/form/custom_links_form.php');
require_once($CFG->dirroot . '/blocks/microsoft/lib.php');

require_login();

$context = system::instance();
require_capability('moodle/site:config', $context);

$pageurl = new url('/blocks/microsoft/customlinks.php');
$returnurl = new url('/admin/settings.php', ['section' => 'blocksettingmicrosoft']);

$PAGE->set_context($context);
$PAGE->set_url($pageurl);
$PAGE->set_pagelayout('admin');
$PAGE->set_primary_active_tab('siteadminnode');
$PAGE->set_secondary_active_tab('modules');
$PAGE->set_title(get_string('customlinks', 'block_microsoft'));
// The page heading is printed by block_microsoft_get_settings_nav_html(), so Moodle's own heading is left empty.
$PAGE->set_heading('');

$storedlinks = block_microsoft_get_stored_custom_links();
$iconoptions = block_microsoft_get_custom_link_icon_options();

$form = new block_microsoft_custom_links_form($pageurl, ['count' => count($storedlinks)]);

if ($form->is_cancelled()) {
    redirect($returnurl);
} else if ($data = $form->get_data()) {
    if (block_microsoft_save_custom_links($data, $storedlinks, $context)) {
        redirect($pageurl, get_string('changessaved'), null, \core\output\notification::NOTIFY_SUCCESS);
    }
    redirect($pageurl, get_string('customlink_nochanges', 'block_microsoft'), null, \core\output\notification::NOTIFY_INFO);
}

if (!$form->is_submitted()) {
    $defaults = [];
    foreach (array_values($storedlinks) as $i => $link) {
        $draftitemid = 0;
        file_prepare_draft_area(
            $draftitemid,
            $context->id,
            'block_microsoft',
            BLOCK_MICROSOFT_CUSTOMLINKS_ICON_FILEAREA,
            $link['id'],
            $iconoptions
        );
        $defaults['linkid'][$i] = $link['id'];
        $defaults['linkname'][$i] = $link['name'];
        $defaults['linkurl'][$i] = $link['url'];
        $defaults['linktarget'][$i] = $link['target'];
        $defaults['linkshowall'][$i] = (int) $link['showall'];
        $defaults['linkicon'][$i] = $draftitemid;
    }
    $form->set_data($defaults);
}

echo $OUTPUT->header();
echo block_microsoft_get_settings_nav_html('customlinks', get_string('customlinks', 'block_microsoft'));
$form->display();
echo $OUTPUT->footer();

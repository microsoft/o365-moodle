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
 * Admin page to clear the stored tokens of all users, or of selected users.
 *
 * @package auth_oidc
 * @author Lai Wei <lai.wei@enovation.ie>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 */

use auth_oidc\form\clear_user_tokens_form;
use core\context\system;
use core\url;

require_once(__DIR__ . '/../../config.php');
require_once($CFG->libdir . '/adminlib.php');
require_once($CFG->dirroot . '/auth/oidc/lib.php');

require_login();

$context = system::instance();
$pageurl = new url('/auth/oidc/clearusertokens.php');

admin_externalpage_setup('auth_oidc_clear_user_tokens');

require_admin();

$PAGE->set_url($pageurl);
$PAGE->set_context($context);
$PAGE->set_pagelayout('admin');
$PAGE->set_heading(get_string('clear_user_tokens', 'auth_oidc'));
$PAGE->set_title(get_string('clear_user_tokens', 'auth_oidc'));

$confirm = optional_param('confirm', 0, PARAM_BOOL);
$scope = optional_param('scope', 'selected', PARAM_ALPHA);
$userids = optional_param_array('userids', [], PARAM_INT);

// Step 3: clear the tokens, after the admin has confirmed.
if ($confirm) {
    require_sesskey();

    if ($scope === 'all') {
        $count = auth_oidc_clear_user_tokens();
    } else {
        $count = auth_oidc_clear_user_tokens($userids);
    }

    redirect(
        $pageurl,
        get_string('clear_user_tokens_success', 'auth_oidc', $count),
        null,
        \core\output\notification::NOTIFY_SUCCESS
    );
}

$form = new clear_user_tokens_form($pageurl);

// Step 2: ask the admin to confirm.
if ($formdata = $form->get_data()) {
    if ($formdata->scope === 'all') {
        $params = ['confirm' => 1, 'scope' => 'all'];
        $message = get_string('clear_user_tokens_confirm_all', 'auth_oidc', auth_oidc_count_users_with_tokens());
    } else {
        $params = ['confirm' => 1, 'scope' => 'selected', 'userids' => $formdata->userids];
        $message = get_string(
            'clear_user_tokens_confirm_selected',
            'auth_oidc',
            auth_oidc_count_users_with_tokens($formdata->userids)
        );
    }

    echo $OUTPUT->header();
    echo auth_oidc_get_settings_nav_html('auth_oidc_clear_user_tokens');
    echo $OUTPUT->confirm($message, new url($pageurl, $params), $pageurl);
    echo $OUTPUT->footer();
    exit;
}

// Step 1: choose whose tokens to clear.
echo $OUTPUT->header();
echo auth_oidc_get_settings_nav_html('auth_oidc_clear_user_tokens');
echo html_writer::div(get_string('clear_user_tokens_desc', 'auth_oidc'), 'mb-3');

// The core user selector prints the full name of a user without a first name and last name as a blank space, which
// leaves an empty option in the list. Mark such users with a "(no name)" label, as the options and the tags of the
// selected users are rendered by JS.
$PAGE->requires->js_amd_inline('
    const nonamelabel = ' . json_encode(get_string('clear_user_tokens_no_name', 'auth_oidc'), JSON_HEX_TAG) . ';
    const marknoname = () => {
        document.querySelectorAll(\'[data-field="fullname"]\').forEach((element) => {
            if (element.textContent.trim() === \'\') {
                element.textContent = nonamelabel;
                element.classList.add(\'font-italic\', \'text-muted\');
            }
        });
    };
    new MutationObserver(marknoname).observe(document.body, {childList: true, subtree: true});
    marknoname();
');

$form->display();
echo $OUTPUT->footer();

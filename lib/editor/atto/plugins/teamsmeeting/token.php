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
 * Issues a fresh single-use token authenticating the return trip from the
 * external meeting-creation app to result.php.
 *
 * The dialogue fetches one of these for every meeting it creates rather than
 * reusing the token generated at page load: result_token::validate() consumes
 * the token on first use, so a page load's token is only good for the first
 * meeting created on that page.
 *
 * @package    atto_teamsmeeting
 * @copyright  2026 Enovation Solutions
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

define('AJAX_SCRIPT', true);

require_once(__DIR__ . '/../../../../../config.php');

require_login();

// Minting a token is a state-changing action (it inserts a user_private_key
// record), so - unlike ajax.php's read-only lookup - this needs the usual
// CSRF defences: POST only, with a valid sesskey. Without them a forged
// cross-site request could not read the response (session cookies aren't
// shared with the attacker's origin), but could still mint keys freely.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    die();
}
require_sesskey();

// Not cacheable: every request must mint a fresh token, never replay a
// cached one. This also sets the JSON content type, so the response isn't
// treated as HTML/text by intermediaries.
send_headers('application/json', false);

$context = context_system::instance();

echo json_encode(['session' => \atto_teamsmeeting\result_token::generate((int) $USER->id, $context->id)]);
die();

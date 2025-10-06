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
 * A script that displays an error message in iframe when meeting is not found.
 *
 * @package     tiny_teamsmeeting
 * @copyright   2023 Enovation Solutions
 * @author      Oliwer Banach <oliwer.banach@enovation.ie>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../../../../config.php');

require_login();

// Error message text.
$errormessage = get_string('iframe_error', 'tiny_teamsmeeting');

// SVG error icon.
$svgattributes = [
    'xmlns' => 'http://www.w3.org/2000/svg',
    'viewBox' => '0 0 32 32',
    'width' => '32',
    'xml:space' => 'preserve',
    'xmlns:xlink' => 'http://www.w3.org/1999/xlink',
    'style' => 'width:100px; align-self: center; display: flex; margin-bottom: 1.5rem;',
];

$circleattributes = [
    'cx' => '16',
    'cy' => '16',
    'id' => 'BG',
    'r' => '16',
    'style' => 'fill:#D72828;',
];

$pathattributes = [
    'd' => 'M14.5,25h3v-3h-3V25z M14.5,6v13h3V6H14.5z',
    'id' => 'Exclamatory_x5F_Sign',
    'style' => 'fill:#E6E6E6;',
];

$svg = html_writer::start_tag('svg', $svgattributes);
$svg .= html_writer::start_tag('g');
$svg .= html_writer::start_tag('g', ['id' => 'Error_1_']);
$svg .= html_writer::start_tag('g', ['id' => 'Error']);
$svg .= html_writer::empty_tag('circle', $circleattributes);
$svg .= html_writer::empty_tag('path', $pathattributes);
$svg .= html_writer::end_tag('g');
$svg .= html_writer::end_tag('g');
$svg .= html_writer::end_tag('g');
$svg .= html_writer::end_tag('svg');

// Error message span.
$spanattributes = [
    'class' => 'meetingcreatedheader',
    'style' => 'font-size: 20px; font-weight: 600; display: block; text-align: center;',
];
$messagespan = html_writer::tag('span', $errormessage, $spanattributes);

// Container div.
$divattributes = [
    'style' => 'display: flex; flex-direction: column; margin-top: 2rem; padding: 2rem; font-family: sans-serif;',
];
echo html_writer::div($svg . $messagespan, '', $divattributes);

exit;

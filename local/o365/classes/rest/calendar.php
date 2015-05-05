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
 * @package local_o365
 * @author James McQuillan <james.mcquillan@remote-learner.net>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft Open Technologies, Inc. (http://msopentech.com/)
 */

namespace local_o365\rest;

/**
 * API client for o365 calendar.
 */
class calendar extends \local_o365\rest\o365api {
    /**
     * Get the API client's oauth2 resource.
     *
     * @return string The resource for oauth2 tokens.
     */
    public static function get_resource() {
        return (static::use_chinese_api() === true) ? 'https://partner.outlook.cn' : 'https://outlook.office365.com';
    }

    /**
     * Get the base URI that API calls should be sent to.
     *
     * @return string|bool The URI to send API calls to, or false if a precondition failed.
     */
    public function get_apiuri() {
        return static::get_resource().'/api/v1.0/me';
    }

    /**
     * Get a list of the user's o365 calendars.
     *
     * @return array|null Returned response, or null if error.
     */
    public function get_calendars() {
        $response = $this->apicall('get', '/calendars');
        $response = @json_decode($response, true);
        return $response;
    }

    /**
     * Get a list of events.
     *
     * @param string $calendarid The calendar ID to get events from. If empty, primary calendar used.
     * @param  [type] $since      [description]
     * @return [type]             [description]
     */
    public function get_events($calendarid = null, $since = null) {
        $endpoint = (!empty($calendarid)) ? '/calendars/'.$calendarid.'/events' : '/events';
        if (!empty($since)) {
            $since = date('c', $since);
            $endpoint .= '?$filter=DateTimeCreated%20ge%20'.$since;
        }
        $response = $this->apicall('get', $endpoint);
        $response = @json_decode($response, true);
        return $response;
    }

    /**
     * Create a new event in the user's o365 calendar.
     *
     * @param string $subject The event's title/subject.
     * @param string $body The event's body/description.
     * @param int $starttime The timestamp when the event starts.
     * @param int $endtime The timestamp when the event ends.
     * @param array $attendees Array of moodle user objects that are attending the event.
     * @param array $other Other parameters to include.
     * @param string $calendarid The o365 ID of the calendar to create the event in.
     * @return array|null Returned response, or null if error.
     */
    public function create_event($subject, $body, $starttime, $endtime, $attendees, array $other = array(), $calendarid = null) {
        $eventdata = [
            'Subject' => $subject,
            'Body' => [
                'ContentType' => 'HTML',
                'Content' => $body,
            ],
            'Start' => date('c', $starttime),
            'End' => date('c', $endtime),
            'Attendees' => [],
        ];
        foreach ($attendees as $attendee) {
            $eventdata['Attendees'][] = [
                'EmailAddress' => [
                    'Address' => $attendee->email,
                    'Name' => $attendee->firstname.' '.$attendee->lastname,
                ],
                'Type' => 'Resource'
            ];
        }
        $eventdata = array_merge($eventdata, $other);
        $eventdata = json_encode($eventdata);
        $endpoint = (!empty($calendarid)) ? '/calendars/'.$calendarid.'/events' : '/events';
        $response = $this->apicall('post', $endpoint, $eventdata);
        $response = @json_decode($response, true);
        return $response;
    }

    /**
     * Update an event.
     *
     * @param string $outlookeventid The event ID in o365 outlook.
     * @param array $updated Array of updated information. Keys are 'subject', 'body', 'starttime', 'endtime', and 'attendees'.
     * @return array|null Returned response, or null if error.
     */
    public function update_event($outlookeventid, $updated) {
        if (empty($outlookeventid) || empty($updated)) {
            return [];
        }
        $updateddata = [];
        if (!empty($updated['subject'])) {
            $updateddata['Subject'] = $updated['subject'];
        }
        if (!empty($updated['body'])) {
            $updateddata['Body'] = ['ContentType' => 'HTML', 'Content' => $updated['body']];
        }
        if (!empty($updated['starttime'])) {
            $updateddata['Start'] = date('c', $updated['starttime']);
        }
        if (!empty($updated['endtime'])) {
            $updateddata['End'] = date('c', $updated['endtime']);
        }
        if (isset($updated['attendees'])) {
            $updateddata['Attendees'] = [];
            foreach ($updated['attendees'] as $attendee) {
                $updateddata['Attendees'][] = [
                    'EmailAddress' => [
                        'Address' => $attendee->email,
                        'Name' => $attendee->firstname.' '.$attendee->lastname,
                    ],
                    'Type' => 'Resource'
                ];
            }
        }
        $updateddata = json_encode($updateddata);
        $response = $this->apicall('patch', '/events/'.$outlookeventid, $updateddata);
        $response = @json_decode($response, true);
        return $response;
    }

    /**
     * Delete an event.
     *
     * @param string $outlookeventid The event ID in o365 outlook.
     * @return bool Success/Failure.
     */
    public function delete_event($outlookeventid) {
        if (!empty($outlookeventid)) {
            $this->apicall('delete', '/events/'.$outlookeventid);
        }
        return true;
    }
}

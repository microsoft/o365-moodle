<?php

namespace local_o365\feature\calsync\calendar;

/**
 * Calendar object representing a user calendar.
 */
class user extends base {
	/**
	 * Constructor.
	 *
	 * @param int $userid The ID of the user who's calendar we're syncing.
	 * @param \moodle_database $DB An active database connection.
	 * @param \local_o365\feature\calsync\main $calapi A calendar API instance to sync with.
	 * @param bool $debug Whether to output debug messages (in cron, for example.)
	 */
	public function __construct($userid, $DB, \local_o365\feature\calsync\main $calapi, $debug = false) {
		$this->userid = $userid;
		$this->DB = $DB;
		$this->calapi = $calapi;
		$this->debug = $debug;
	}

	/**
	 * Determine whether this calendar has been synced since a given timestamp.
	 *
	 * @param int $timestamp The timestamp to check.
	 * @return bool If true, this calendar has been synced at a time more recent than $timestamp. False otherwise.
	 */
	protected function has_been_synced_since($timestamp) {
		$lastusersync = $this->DB->get_record('config_plugins', ['plugin' => 'local_o365', 'name' => 'cal_user_lastsync']);
        if (!empty($lastusersync)) {
            $lastusersync = @unserialize($lastusersync->value);
            if (is_array($lastusersync) && isset($lastusersync[$this->userid]) && (int)$lastusersync[$this->userid] > $timestamp) {
                return true;
            }
        }
        return false;
	}

	/**
	 * Save the sync time for this user.
	 *
	 * @param int $timestamp The timestamp to save.
	 * @return bool Success/Failure.
	 */
	protected function save_sync_time($timestamp) {
		if (empty($timestamp) || (string)(int)$timestamp !== (string)$timestamp) {
			// Invalid timestamp.
			return false;
		}
		$lastusersync = $this->DB->get_record('config_plugins', ['plugin' => 'local_o365', 'name' => 'cal_user_lastsync']);
		$value = [];
		if (!empty($lastusersync)) {
			$value = @unserialize($lastusersync->value);
		}
		if (empty($value) || !is_array($value)) {
			$value = [];
		}
		if ((isset($value[$this->userid]) && $value[$this->userid] < $timestamp) || !isset($value[$this->userid])) {
			$value[$this->userid] = $timestamp;
		}
        set_config('cal_user_lastsync', serialize($value), 'local_o365');
        return true;
	}

	/**
	 * Determine whether we can sync the calendar or not.
	 *
	 * @return bool True if we can sync, false otherwise.
	 */
	public function can_sync() {
		$usertoken = $this->calapi->get_user_token($this->userid);
        return (!empty($usertoken)) ? true : false;
	}

	/**
	 * Get Moodle events to sync.
	 *
	 * @return \moodle_recordset A recordset of events, including associated calidmap data.
	 */
	public function get_events() {
		$sql = 'SELECT ev.id AS eventid,
                       ev.name AS eventname,
                       ev.description AS eventdescription,
                       ev.timestart AS eventtimestart,
                       ev.timeduration AS eventtimeduration,
                       idmap.outlookeventid,
                       idmap.origin AS idmaporigin
                  FROM {event} ev
             LEFT JOIN {local_o365_calidmap} idmap ON ev.id = idmap.eventid AND idmap.userid = ev.userid
                 WHERE ev.courseid = 0
                       AND ev.groupid = 0
                       AND ev.userid = ?
              ORDER BY ev.id ASC';
        return $this->DB->get_recordset_sql($sql, [$this->userid]);
	}

	/**
	 * Sync an event with Office 365 based on existing sync and subscription data.
	 *
	 * @param \stdClass $eventrec The Moodle event record.
	 * @param \stdClass $idmaprec The local_o365_calidmap record.
	 * @param \stdClass $subscription The local_o365_calsub record.
	 */
	public function sync_event($eventrec, $idmaprec, $subscription) {
		if (!empty($subscription)) {
			// User is subscribed to this calendar. Update outlook.
			if (empty($idmaprec->outlookeventid)) {
                // Event not synced, if outward subscription exists sync to o365.
                if ($subscription->syncbehav === 'out' || $subscription->syncbehav === 'both') {
                    $this->mtrace('Creating event in Outlook.', 'se1');
                    $subject = $eventrec->name;
                    $body = $eventrec->description;
                    $evstart = $eventrec->timestart;
                    $evend = $eventrec->timestart + $eventrec->timeduration;
                    $calid = (!empty($subscription->o365calid)) ? $subscription->o365calid : null;
                    if (isset($subscription->isprimary) && $subscription->isprimary == 1) {
                        $calid = null;
                    }
                    $this->calapi->create_event_raw($this->userid, $eventrec->id, $subject, $body, $evstart, $evend, [], [], $calid);
                    return true;
                } else {
                    $this->mtrace('Not creating event in Outlook. (Sync settings are inward-only.)', 'se2');
                    return true;
                }
            } else {
                // Event synced. If event was created in Moodle and subscription is inward-only, delete o365 event.
                if ($idmaprec->origin === 'moodle' && $subscription->syncbehav === 'in') {
                    $this->mtrace('Removing event from Outlook (Created in Moodle, sync settings are inward-only.)', 'se3');
                    $this->calapi->delete_event_raw($this->userid, $idmaprec->outlookeventid);
                    return true;
                } else {
                    $this->mtrace('Event already synced.', 'se4');
                    return true;
                }
            }
		} else {
			// User is not subscribed to this calendar. Delete relevant events.
            if (!empty($idmaprec->outlookeventid)) {
                if ($idmaprec->origin === 'moodle') {
                    $this->mtrace('Removing event from Outlook.', 'se5');
                    // Event was created in Moodle, delete o365 event.
                    $this->calapi->delete_event_raw($this->userid, $idmaprec->outlookeventid);
                    return true;
                } else {
                    $this->mtrace('Not removing event from Outlook (It was created there.)', 'se6');
                    return true;
                }
            } else {
                $this->mtrace('Did not have an outlookeventid. Event not synced?', 'se7');
                return true;
            }
		}
	}

	/**
	 * Sync the calendar with Office 365.
	 *
	 * @param int $timestart The time the sync operation was requested.
	 * @return bool Success/Failure.
	 */
	public function sync($timestart) {
		if ($this->can_sync() !== true) {
			$errmsg = 'Could not get user token for user calendar sync (userid '.$this->userid.')';
			$this->mtrace($errmsg, 's0');
			\local_o365\utils::debug($errmsg);
			return false;
		}

		$params = ['user_id' => $this->userid, 'caltype' => 'user', 'caltypeid' => $this->userid];
		$subscription = $this->DB->get_record('local_o365_calsub', $params);

		$events = $this->get_events();
		foreach ($events as $event) {
			$this->mtrace('Syncing user event #'.$event->eventid, 's1');
			$eventrec = (object)[
				'id' => $event->eventid,
				'name' => $event->eventname,
				'description' => $event->eventdescription,
				'timestart' => $event->eventtimestart,
				'timeduration' => $event->eventtimeduration,
			];
			$idmaprec = (object)[
				'outlookeventid' => (isset($event->outlookeventid)) ? $event->outlookeventid : null,
                'origin' => (isset($event->idmaporigin)) ? $event->idmaporigin : null,
			];
			$this->sync_event($eventrec, $idmaprec, $subscription);
		}
		$events->close();

		$this->save_sync_time($timestart);
	}
}

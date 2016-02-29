<?php

namespace local_o365\feature\calsync\calendar;

class base {
	/**
     * Optionally run mtrace() based on $this->debug setting.
     *
     * @param string $msg The debug message.
     */
    protected function mtrace($msg, $trace = null, $eol = "\n") {
        if ($this->debug === true) {
            if (!empty($trace)) {
                $msg .= ' (Trace: '.$trace.')';
            }
            mtrace($msg, $eol);
        }
    }

	/**
     * Sync the calendar with Office 365.
     *
     * @param int $timestart The time the sync operation was requested.
     * @return bool Success/Failure.
     */
    public function sync($timestart) {

	}
}
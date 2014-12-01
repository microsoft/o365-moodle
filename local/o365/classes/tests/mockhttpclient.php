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
 * @copyright (C) 2014 onwards Remote-Learner.net Inc (http://www.remote-learner.net)
 */

namespace local_o365\tests;

/**
 * A mock HTTP client allowing set responses.
 */
class mockhttpclient extends \local_o365\httpclient {
	/** @var string The stored set response. */
	protected $mockresponse = '';

	/**
	 * Set a response to return.
	 *
	 * @param string $response The response to return.
	 */
	public function set_response($response) {
		$this->mockresponse = $response;
	}

	/**
	 * Return the set response instead of making the actual HTTP request.
	 *
	 * @param string $url The request URL
	 * @param array $options Additional curl options.
	 * @return string The set response.
	 */
	protected function request($url, $options = array()) {
		return $this->mockresponse;
	}
}
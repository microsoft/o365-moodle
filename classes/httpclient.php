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
 * @package auth_oidc
 * @author James McQuillan <james.mcquillan@remote-learner.net>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Remote-Learner.net Inc (http://www.remote-learner.net)
 */

namespace auth_oidc;

/**
 * Implementation of the httpclientinterface using CURL.
 */
class httpclient implements \auth_oidc\httpclientinterface {

	/**
	 * Encodes an array to the application/x-www-form-urlencoded format.
	 *
	 * @param array $ar An associative array to encode.
	 * @return string The array encoded as application/x-www-form-urlencoded.
	 */
	protected function urlencode_array(array $ar) {
		foreach ($ar as $k => $v) {
			$ar[$k] = urlencode($k).'='.urlencode($v);
		}
		return implode('&', $ar);
	}

	/**
	 * Generate a client tag.
	 *
	 * @return string A client tag.
	 */
	protected function get_clienttag() {
		global $CFG;

		$iid = sha1($CFG->wwwroot);
		$mdlver = '1.0';
		$ostype = 'Linux|Windows';
		$osver = '3.4.30|6.2.9000';
		$arch = 'x64';
		$ver = '1.0';

		$clienttag = "Moodle/{$mdlver} (lang=PHP; os={$ostype}; os_version={$osver}; arch={$arch}; version={$ver}; MoodleInstallId={$iid})";
		return $clienttag;
	}

	/**
	 * Post data to a URL.
	 *
	 * @param string $url The URL to post to.
	 * @param string|array $data The data to post.
	 * @return string The returned data.
	 */
	public function post($url, $data) {
		$ch = curl_init();
		$curlopts = [
			CURLOPT_URL => $url,
			CURLOPT_HEADER => false,
			CURLOPT_POST => true,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_FOLLOWLOCATION => true,
		];

		$clienttag = $this->get_clienttag();
		$curlopts[CURLOPT_HTTPHEADER][] = 'User-Agent: '.$clienttag;
		$curlopts[CURLOPT_HTTPHEADER][] = 'X-ClientService-ClientTag: '.$clienttag;

		if (is_array($data)) {
			$curlopts[CURLOPT_HTTPHEADER][] = 'Content-Type: application/x-www-form-urlencoded';
			$data = $this->urlencode_array($data);
		} elseif (is_string($data)) {
			$curlopts[CURLOPT_HTTPHEADER][] = 'Content-Type: text/plain';
		}
		$curlopts[CURLOPT_POSTFIELDS] = $data;

		curl_setopt_array($ch, $curlopts);
		$returned = curl_exec($ch);
		if ($returned === false) {
			$errorstring = curl_error($ch);
			curl_close($ch);
			throw new \Exception('CURL Error: '.$errorstring);
		} else {
			curl_close($ch);
			return $returned;
		}
	}
}

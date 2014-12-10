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

namespace local_o365;

require_once($CFG->dirroot.'/lib/filelib.php');

/**
 * An httpclientinterface implementation, using curl class as backend and adding patch and merge methods.
 */
class httpclient extends \curl implements \local_o365\httpclientinterface {
    /**
     * HTTP PATCH method
     *
     * @param string $url
     * @param array|string $params
     * @param array $options
     * @return bool
     */
    public function patch($url, $params = '', $options = array()) {
        $options['CURLOPT_CUSTOMREQUEST'] = 'PATCH';

        if (is_array($params)) {
            $this->_tmp_file_post_params = array();
            foreach ($params as $key => $value) {
                if ($value instanceof stored_file) {
                    $value->add_to_curl_request($this, $key);
                } else {
                    $this->_tmp_file_post_params[$key] = $value;
                }
            }
            $options['CURLOPT_POSTFIELDS'] = $this->_tmp_file_post_params;
            unset($this->_tmp_file_post_params);
        } else {
            // Var $params is the raw post data.
            $options['CURLOPT_POSTFIELDS'] = $params;
        }
        return $this->request($url, $options);
    }

    /**
     * HTTP MERGE method
     *
     * @param string $url
     * @param array|string $params
     * @param array $options
     * @return bool
     */
    public function merge($url, $params = '', $options = array()) {
        $options['CURLOPT_CUSTOMREQUEST'] = 'MERGE';

        if (is_array($params)) {
            $this->_tmp_file_post_params = array();
            foreach ($params as $key => $value) {
                if ($value instanceof stored_file) {
                    $value->add_to_curl_request($this, $key);
                } else {
                    $this->_tmp_file_post_params[$key] = $value;
                }
            }
            $options['CURLOPT_POSTFIELDS'] = $this->_tmp_file_post_params;
            unset($this->_tmp_file_post_params);
        } else {
            // Var $params is the raw post data.
            $options['CURLOPT_POSTFIELDS'] = $params;
        }
        return $this->request($url, $options);
    }

    /**
     * HTTP PUT method
     *
     * @param string $url
     * @param array $params
     * @param array $options
     * @return bool
     */
    public function put($url, $params = array(), $options = array()) {
        if (!isset($params['file'])) {
            throw new \Exception('No file parameter in httpclient::put');
        }
        if (is_file($params['file'])) {
            $fp = fopen($params['file'], 'r');
            $size = filesize($params['file']);
        } else {
            $fp = fopen('php://temp', 'w+');
            $size = strlen($params['file']);
            if (!$fp) {
                throw new \Exception('Could not open temporary location to store file.');
            }
            fwrite($fp, $params['file']);
            fseek($fp, 0);
        }
        $options['CURLOPT_PUT'] = 1;
        $options['CURLOPT_INFILESIZE'] = $size;
        $options['CURLOPT_INFILE'] = $fp;
        if (!isset($this->options['CURLOPT_USERPWD'])) {
            $this->setopt(array('CURLOPT_USERPWD'=>'anonymous: noreply@moodle.org'));
        }

        $ret = $this->request($url, $options);
        fclose($fp);
        return $ret;
    }
}

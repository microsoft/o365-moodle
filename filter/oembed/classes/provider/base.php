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
 * @package filter_oembed
 * @author Matthew Cannings
 * @author James McQuillan <james.mcquillan@remote-learner.net>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright 2012 Matthew Cannings; modified 2015 by Microsoft, Inc.
 */

namespace filter_oembed\provider;

global $CFG;
require_once($CFG->dirroot.'/lib/filelib.php');

/**
 * Base class for oembed providers.
 */
class base {
    /**
     * Main filter function.
     *
     * @param string $text Incoming text.
     * @return string Filtered text.
     */
    public function filter($text) {
        return $text;
    }

    /**
     * Return the HTML content to be embedded given the response from the OEmbed request.
     * This method returns the thumbnail image if we lazy loading is enabled. Ogtherwise it returns the
     * embeddable HTML returned from the OEmbed request. An error message is returned if there was an error during
     * the request.
     *
     * @param array $json Response object returned from the OEmbed request.
     * @param string $params Additional parameters to include in the embed URL.
     * @return string The HTML content to be embedded in the page.
     */
    protected function getoembedhtml($json, $params = '') {
        if ($json === null) {
            return '<h3>'.get_string('connection_error', 'filter_oembed').'</h3>';
        }

        $embed = $json['html'];

        if (!empty($params)) {
            $embed = str_replace('?feature=oembed', '?feature=oembed'.htmlspecialchars($params), $embed);
        }

        if (get_config('filter_oembed', 'lazyload')) {
            $embed = htmlspecialchars($embed);
            $dom = new \DOMDocument();

            // To surpress the loadHTML Warnings.
            libxml_use_internal_errors(true);
            $dom->loadHTML($json['html']);
            libxml_use_internal_errors(false);

            // Get height and width of iframe.
            $height = $dom->getElementsByTagName('iframe')->item(0)->getAttribute('height');
            $width = $dom->getElementsByTagName('iframe')->item(0)->getAttribute('width');

            $embedcode = '<a class="lvoembed lvvideo" data-embed="'.$embed.'"';
            $embedcode .= 'href="#" data-height="'. $height .'" data-width="'. $width .'"><div class="filter_oembed_lazyvideo_container">';
            $embedcode .= '<img class="filter_oembed_lazyvideo_placeholder" src="'.$json['thumbnail_url'].'" />';
            $embedcode .= '<div class="filter_oembed_lazyvideo_title"><div class="filter_oembed_lazyvideo_text">'.$json['title'].'</div></div>';
            $embedcode .= '<span class="filter_oembed_lazyvideo_playbutton"></span>';
            $embedcode .= '</div></a>';
        } else {
            $embedcode = $embed;
        }

        return $embedcode;
    }

    /**
     * Makes the OEmbed request to the service that supports the protocol.
     *
     * @param string $url URL for the OEmbed request
     * @return mixed|null|string The HTTP response object from the OEmbed request.
     */
    protected function getoembeddata($url, $retryno = 0) {
        $curl = new \curl();
        $ret = $curl->get($url);

        // Check if curl call fails.
        if ($curl->errno != CURLE_OK) {
            $retrylimit = get_config('filter_oembed', 'retrylimit');
            // Check if error is due to network connection.
            if (in_array($curl->errno, [6, 7, 28])) {
                // Try curl call up to 3 times.
                usleep(50000);
                $retryno = (!is_int($retryno)) ? 0 : $retryno+1;
                if ($retryno < $retrylimit) {
                    return $this->getoembeddata($url, $retryno);
                } else {
                    return null;
                }
            } else {
                return null;
            }
        }

        $result = json_decode($ret, true);
        return $result;
    }
}

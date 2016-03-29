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
            $embedcode .= 'href="#" data-height="'. $height .'" data-width="'. $width .'"><div class="lazyvideo_container">';
            $embedcode .= '<img class="lazyvideo_placeholder" src="'.$json['thumbnail_url'].'" />';
            $embedcode .= '<div class="lazyvideo_title"><div class="lazyvideo_text">'.$json['title'].'</div></div>';
            $embedcode .= '<span class="lazyvideo_playbutton"></span>';
            $embedcode .= '</div></a>';
        } else {
            $embedcode = $embed;
        }

        return $embedcode;
    }

    /**
     * Makes the OEmbed request to the service that supports the protocol.
     *
     * @param $www URL for the Oembed request
     * @return mixed|null|string The HTTP response object from the OEmbed request.
     */
    protected function getoembeddata($www) {
        $crl = curl_init();
        $timeout = 15;
        curl_setopt($crl, CURLOPT_URL, $www);
        curl_setopt($crl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($crl, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($crl, CURLOPT_SSL_VERIFYPEER, false);
        $ret = curl_exec($crl);

        // Check if curl call fails.
        if ($ret === false) {
            // Check if error is due to network connection.
            if (in_array(curl_errno($crl), ['6', '7', '28'])) {

                // Try curl call for 3 times pausing 0.5 sec.
                for ($i = 0; $i < 3; $i++) {
                    $ret = curl_exec($crl);

                    // If we get proper response, break the loop.
                    if ($ret !== false) {
                        break;
                    }

                    usleep(500000);
                }

                // If still curl call failing, return null.
                if ($ret === false) {
                    return null;
                }
            } else {
                return null;
            }
        }

        curl_close($crl);
        $result = json_decode($ret, true);
        return $result;
    }
}

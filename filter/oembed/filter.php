<?php
// This file is part of Moodle-oembed-Filter
//
// Moodle-oembed-Filter is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle-oembed-Filter is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle-oembed-Filter.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Filter for component 'filter_oembed'
 *
 * @package   filter_oembed
 * @copyright 2012 Matthew Cannings; modified 2015 by Microsoft Open Technologies, Inc.
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * code based on the following filters...
 * Screencast (Mark Schall)
 * Soundcloud (Troy Williams)
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir.'/filelib.php');

/**
 * Filter for processing HTML content containing links to media from services that support the OEmbed protocol.
 * The filter replaces the links with the embeddable content returned from the service via the Oembed protocol.
 *
 * @package    filter_oembed
 */
class filter_oembed extends moodle_text_filter {

    /**
     * Set up the filter using settings provided in the admin settings page.
     *
     * @param $page
     * @param $context
     */
    public function setup($page, $context) {
        // This only requires execution once per request.
        static $jsinitialised = false;
        if (get_config('filter_oembed', 'lazyload')) {
            if (empty($jsinitialised)) {
                $page->requires->yui_module(
                        'moodle-filter_oembed-lazyload',
                        'M.filter_oembed.init_filter_lazyload',
                        array(array('courseid' => 0)));
                $jsinitialised = true;
            }
        }
    }

    /**
     * Filters the given HTML text, looking for links pointing to media from services that support the Oembed
     * protocol and replacing them with the embeddable content returned from the protocol.
     *
     * @param $text HTML to be processed.
     * @param $options
     * @return string String containing processed HTML.
     */
    public function filter($text, array $options = array()) {
        global $CFG;

        if (!is_string($text) or empty($text)) {
            // Non string data can not be filtered anyway.
            return $text;
        }
//        if (get_user_device_type() !== 'default'){
            // no lazy video on mobile
            // return $text;

//        }
        if (stripos($text, '</a>') === false) {
            // Performance shortcut - all regexes below end with the </a> tag.
            // If not present nothing can match.
            return $text;
        }

        $newtext = $text; // We need to return the original value if regex fails!

        if (get_config('filter_oembed', 'youtube')) {
            $search = '/<a\s[^>]*href="((https?:\/\/(www\.)?)(youtube\.com|youtu\.be|youtube\.googleapis.com)\/(?:embed\/|v\/|watch\?v=|watch\?.+&amp;v=|watch\?.+&v=)?((\w|-){11})(.*?))"(.*?)>(.*?)<\/a>/is';
            $newtext = preg_replace_callback($search, 'filter_oembed_youtubecallback', $newtext);
        }
        if (get_config('filter_oembed', 'vimeo')) {
            $search = '/<a\s[^>]*href="(https?:\/\/(www\.)?)(vimeo\.com)\/(\d+)(.*?)"(.*?)>(.*?)<\/a>/is';
            $newtext = preg_replace_callback($search, 'filter_oembed_vimeocallback', $newtext);
        }
        if (get_config('filter_oembed', 'slideshare')) {
            $search = '/<a\s[^>]*href="(https?:\/\/(www\.)?)(slideshare\.net)\/(.*?)"(.*?)>(.*?)<\/a>/is';
            $newtext = preg_replace_callback($search, 'filter_oembed_slidesharecallback', $newtext);
        }
        if (get_config('filter_oembed', 'officemix')) {
            $search = '/<a\s[^>]*href="(https?:\/\/(www\.)?)(mix\.office\.com)\/(.*?)"(.*?)>(.*?)<\/a>/is';
            $newtext = preg_replace_callback($search, 'filter_oembed_officemixcallback', $newtext);
        }
        if (get_config('filter_oembed', 'issuu')) {
            $search = '/<a\s[^>]*href="(https?:\/\/(www\.)?)(issuu\.com)\/(.*?)"(.*?)>(.*?)<\/a>/is';
            $newtext = preg_replace_callback($search, 'filter_oembed_issuucallback', $newtext);
        }
        if (get_config('filter_oembed', 'screenr')) {
            $search = '/<a\s[^>]*href="(https?:\/\/(www\.)?)(screenr\.com)\/(.*?)"(.*?)>(.*?)<\/a>/is';
            $newtext = preg_replace_callback($search, 'filter_oembed_screenrcallback', $newtext);
        }
        if (get_config('filter_oembed', 'soundcloud')) {
            $search = '/<a\s[^>]*href="(https?:\/\/(www\.)?)(soundcloud\.com)\/(.*?)"(.*?)>(.*?)<\/a>/is';
            $newtext = preg_replace_callback($search, 'filter_oembed_soundcloudcallback', $newtext);
        }
        if (get_config('filter_oembed', 'ted')) {
            $search = '/<a\s[^>]*href="(https?:\/\/(www\.)?)(ted\.com)\/talks\/(.*?)"(.*?)>(.*?)<\/a>/is';
            $newtext = preg_replace_callback($search, 'filter_oembed_tedcallback', $newtext);
        }
        if (get_config('filter_oembed', 'pollev')) {
            $search = '/<a\s[^>]*href="(https?:\/\/(www\.)?)(polleverywhere\.com)\/(polls|multiple_choice_polls|free_text_polls)\/(.*?)"(.*?)>(.*?)<\/a>/is';
            $newtext = preg_replace_callback($search, 'filter_oembed_pollevcallback', $newtext);
        }
        if (empty($newtext) or $newtext === $text) {
            // Error or not filtered.
            unset($newtext);
            return $text;
        }

        return $newtext;
    }
}

/**
 * Looks for links pointing to Youtube content and processes them.
 *
 * @param $link HTML tag containing a link
 * @return string HTML content after processing.
 */
function filter_oembed_youtubecallback($link) {
    global $CFG;
    $url = "http://www.youtube.com/oembed?url=".trim($link[1])."&format=json";
    $jsonret = filter_oembed_curlcall($url);
    return filter_oembed_vidembed($jsonret, trim($link[7]));
}

/**
 * Looks for links pointing to Vimeo content and processes them.
 *
 * @param $link HTML tag containing a link
 * @return string HTML content after processing.
 */
function filter_oembed_vimeocallback($link) {
    global $CFG;
    $url = "http://vimeo.com/api/oembed.json?url=".trim($link[1]).trim($link[2]).trim($link[3]).'/'.trim($link[4]).'&maxwidth=480&maxheight=270';
    $jsonret = filter_oembed_curlcall($url);
    return filter_oembed_vidembed($jsonret);
}

/**
 * Looks for links pointing to TED content and processes them.
 *
 * @param $link HTML tag containing a link
 * @return string HTML content after processing.
 */
function filter_oembed_tedcallback($link) {
    global $CFG;
    $url = "http://www.ted.com/services/v1/oembed.json?url=".trim($link[1]).trim($link[3]).'/talks/'.trim($link[4]).'&maxwidth=480&maxheight=270';
    $jsonret = filter_oembed_curlcall($url);
    return filter_oembed_vidembed($jsonret);
}

/**
 * Looks for links pointing to SlideShare content and processes them.
 *
 * @param $link HTML tag containing a link
 * @return string HTML content after processing.
 */
function filter_oembed_slidesharecallback($link) {
    global $CFG;
    $url = "http://www.slideshare.net/api/oembed/2?url=".trim($link[1]).trim($link[3]).'/'.trim($link[4])."&format=json&maxwidth=480&maxheight=270";
    $json = filter_oembed_curlcall($url);
    return $json === null ? '<h3>'. get_string('connection_error', 'filter_oembed') .'</h3>' : $json['html'];
}

/**
 * Looks for links pointing to Microsoft Office Mix content and processes them.
 *
 * @param $link HTML tag containing a link
 * @return string HTML content after processing.
 */
function filter_oembed_officemixcallback($link) {
    global $CFG;
    $url = "https://mix.office.com/oembed/?url=".trim($link[1]).trim($link[2]).trim($link[3]).'/'.trim($link[4]);
    $json = filter_oembed_curlcall($url);

    if($json === null){
        return '<h3>'. get_string('connection_error', 'filter_oembed') .'</h3>';
    }

    // Increase the height and width of iframe.
    $json['html'] = str_replace('width="348"', 'width="480"', $json['html']);
    $json['html'] = str_replace('height="245"', 'height="320"', $json['html']);
    $json['html'] = str_replace('height="310"', 'height="410"', $json['html']);
    $json['html'] = str_replace('height="267"', 'height="350"', $json['html']);
    return filter_oembed_vidembed($json);
}

/**
 * Looks for links pointing to PollEverywhere content and processes them.
 *
 * @param $link HTML tag containing a link
 * @return string HTML content after processing.
 */
function filter_oembed_pollevcallback($link) {
    global $CFG;
    $url = "http://www.polleverywhere.com/services/oembed?url=".trim($link[1]).trim($link[3]).'/'.trim($link[4]).'/'.trim($link[5])."&format=json&maxwidth=480&maxheight=270";
    $json = filter_oembed_curlcall($url);
    return $json === null ? '<h3>'. get_string('connection_error', 'filter_oembed') .'</h3>' : $json['html'];
}

/**
 * Looks for links pointing to Issuu content and processes them.
 *
 * @param $link HTML tag containing a link
 * @return string HTML content after processing.
 */
function filter_oembed_issuucallback($link) {
    global $CFG;
    $url = "http://issuu.com/oembed?url=".trim($link[1]).trim($link[3]).'/'.trim($link[4])."&format=json";
    $json = filter_oembed_curlcall($url);
    return $json === null ? '<h3>'. get_string('connection_error', 'filter_oembed') .'</h3>' : $json['html'];
}

/**
 * Looks for links pointing to Screenr content and processes them.
 *
 * @param $link HTML tag containing a link
 * @return string HTML content after processing.
 */
function filter_oembed_screenrcallback($link) {
    global $CFG;
    $url = "http://www.screenr.com/api/oembed.json?url=".trim($link[1]).trim($link[3]).'/'.trim($link[4]).'&maxwidth=480&maxheight=270';
    $json = filter_oembed_curlcall($url);
    return filter_oembed_vidembed($json);
}

/**
 * Looks for links pointing to SoundCloud content and processes them.
 *
 * @param $link HTML tag containing a link
 * @return string HTML content after processing.
 */
function filter_oembed_soundcloudcallback($link) {
    global $CFG;
    $url = "http://soundcloud.com/oembed?url=".trim($link[1]).trim($link[3]).'/'.trim($link[4])."&format=json&maxwidth=480&maxheight=270'";
    $json = filter_oembed_curlcall($url);
    return filter_oembed_vidembed($json);
}

/**
 * Makes the OEmbed request to the service that supports the protocol.
 *
 * @param $www URL for the Oembed request
 * @return mixed|null|string The HTTP response object from the OEmbed request.
 */
function filter_oembed_curlcall($www) {
    $crl = curl_init();
    $timeout = 15;
    curl_setopt ($crl, CURLOPT_URL, $www);
    curl_setopt ($crl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt ($crl, CURLOPT_CONNECTTIMEOUT, $timeout);
    curl_setopt ($crl, CURLOPT_SSL_VERIFYPEER, false);
    $ret = curl_exec($crl);

    // Check if curl call fails.
    if ($ret === false) {
        // Check if error is due to network connection.
        if (in_array(curl_errno($crl), array('6', '7', '28'))) {

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
function filter_oembed_vidembed($json, $params = '') {

    if ($json === null) {
        return '<h3>'. get_string('connection_error', 'filter_oembed') .'</h3>';
    }

    $embed = $json['html'];

    if ($params != ''){
        $embed = str_replace('?feature=oembed', '?feature=oembed'.htmlspecialchars($params), $embed );
    }

    if (get_config('filter_oembed', 'lazyload')) {
        $embed = htmlspecialchars($embed);
        $dom = new DOMDocument();

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

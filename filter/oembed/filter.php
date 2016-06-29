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
 * @copyright 2012 Matthew Cannings; modified 2015 by Microsoft, Inc.
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
        if (get_config('filter_oembed', 'provider_powerbi_enabled')) {
            global $PAGE;
            $PAGE->requires->yui_module('moodle-filter_oembed-powerbiloader', 'M.filter_oembed.init_powerbiloader');
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
        // if (get_user_device_type() !== 'default'){
            // no lazy video on mobile
            // return $text;

        // }
        if (stripos($text, '</a>') === false) {
            // Performance shortcut - all regexes below end with the </a> tag.
            // If not present nothing can match.
            return $text;
        }

        $newtext = $text; // We need to return the original value if regex fails!

        if (get_config('filter_oembed', 'youtube')) {
            $search = '/<a\s[^>]*href="((https?:\/\/(www\.)?)(youtube\.com|youtu\.be|youtube\.googleapis.com)\/(?:embed\/|v\/|watch\?v=|watch\?.+?&amp;v=|watch\?.+?&v=)?((\w|-){11})(.*?))"(.*?)>(.*?)<\/a>/is';
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
        $odburl = get_config('local_o365', 'odburl');
        if (get_config('filter_oembed', 'o365video') && !empty($odburl)) {
            $odburl = preg_replace('/^https?:\/\//', '', $odburl);
            $odburl = preg_replace('/\/.*/', '', $odburl);
            $trimedurl = preg_replace("/-my/", "", $odburl);
            $search = '/<a\s[^>]*href="(https?:\/\/)('.$odburl.'|'.$trimedurl.')\/(.*?)"(.*?)>(.*?)<\/a>/is';
            $newtext = preg_replace_callback($search, 'filter_oembed_o365videocallback', $newtext);
        }
        if (get_config('filter_oembed', 'sway')) {
            $search = '/<a\s[^>]*href="(https?:\/\/(www\.)?)(sway\.com)\/(.*?)"(.*?)>(.*?)<\/a>/is';
            $newtext = preg_replace_callback($search, 'filter_oembed_swaycallback', $newtext);
        }

        // New method for embed providers.
        $providers = static::get_supported_providers();
        $filterconfig = get_config('filter_oembed');
        foreach ($providers as $provider) {
            $enabledkey = 'provider_'.$provider.'_enabled';
            if (!empty($filterconfig->$enabledkey)) {
                $providerclass = '\filter_oembed\provider\\'.$provider;
                if (class_exists($providerclass)) {
                    $provider = new $providerclass();
                    $newtext = $provider->filter($newtext);
                }
            }
        }

        if (empty($newtext) or $newtext === $text) {
            // Error or not filtered.
            unset($newtext);
            return $text;
        }

        return $newtext;
    }

    /**
     * Return list of supported providers.
     *
     * @return array Array of supported providers.
     */
    public static function get_supported_providers() {
        return [
            'docsdotcom', 'powerbi', 'officeforms'
        ];
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
    $url = "http://www.youtube.com/oembed?url=".urlencode(trim($link[1]))."&format=json";
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
 * Looks for links pointing to Office 365 Video content and processes them.
 *
 * @param $link HTML tag containing a link
 * @return string HTML content after processing.
 */
function filter_oembed_o365videocallback($link) {
    if (empty($link[3])) {
        return $link[0];
    }
    $link[3] = preg_replace("/&amp;/", "&", $link[3]);
    $values = array();
    parse_str($link[3], $values);
    if (empty($values['chid']) || empty($values['vid'])) {
        return $link[0];
    }
    if (!\local_o365\rest\sharepoint::is_configured()) {
        \local_o365\utils::debug('filter_oembed share point is not configured', 'filter_oembed_o365videocallback');
        return $link[0];
    }
    try {
        $spresource = \local_o365\rest\sharepoint::get_resource();
        if (!empty($spresource)) {
            $httpclient = new \local_o365\httpclient();
            $clientdata = \local_o365\oauth2\clientdata::instance_from_oidc();
            $sptoken = \local_o365\oauth2\systemtoken::instance(null, $spresource, $clientdata, $httpclient);
            if (!empty($sptoken)) {
                $sharepoint = new \local_o365\rest\sharepoint($sptoken, $httpclient);
                // Retrieve api url for video service.
                $url = $sharepoint->videoservice_discover();
                if (!empty($url)) {
                    $sharepoint->override_resource($url);
                    $width = 640;
                    if (!empty($values['width'])) {
                        $width = $values['width'];
                    }
                    $height = 360;
                    if (!empty($values['height'])) {
                        $height = $values['height'];
                    }
                    // Retrieve embed code.
                    return $sharepoint->get_video_embed_code($values['chid'], $values['vid'], $width, $height);
                }
            }
        }
    } catch (\Exception $e) {
        \local_o365\utils::debug('filter_oembed share point execption: '.$e->getMessage(), 'filter_oembed_o365videocallback', $e);
    }
    return $link[0];
}

/**
 * Looks for links pointing to sway.com content and processes them.
 *
 * @param $link HTML tag containing a link
 * @return string HTML content after processing.
 */
function filter_oembed_swaycallback($link) {
    global $CFG;
    $width = 500;
    $height = 760;
    $link[4] = preg_replace("/&amp;/", "&", $link[4]);
    $id = preg_replace("/^(.*)(\?(.*)?)/", "$1", $link[4]);
    $url = "https://www.sway.com/s/".trim($id)."/embed";
    // Check for optional width and height passed as query string.
    if (preg_match("/width/", $link[4])) {
        $query = array();
        parse_str(preg_replace("/^(.*)\?/", "", $link[4]), $query);
        if (!empty($query['width'])) {
            $width = $query['width'];
        }
        if (!empty($query['height'])) {
            $height = $query['height'];
        }
    }
    $options = array(
        'class' => 'oembed_sway',
        'width' => $width.'px',
        'height' => $height.'px',
        'src' => $url,
        'frameborder' => '0',
        'marginwidth' => '0',
        'scrolling' => 'no',
        'style' => 'border: none; max-width:100%; max-height:100vh',
        'allowfullscreen' => '',
        'webkitallowfullscreen' => '',
        'msallowfullscreen' => '',
    );
    return html_writer::tag('iframe', '', $options);
}

/**
 * Makes the OEmbed request to the service that supports the protocol.
 *
 * @param $url URL for the Oembed request
 * @return mixed|null|string The HTTP response object from the OEmbed request.
 */
function filter_oembed_curlcall($url) {
   static $cache;

    if (!isset($cache)) {
        $cache = cache::make('filter_oembed', 'embeddata');
    }

    if ($ret = $cache->get(md5($url))) {
        return json_decode($ret, true);
    }

    $curl = new \curl();
    $ret = $curl->get($url);

    // Check if curl call fails.
    if ($curl->errno != CURLE_OK) {
        // Check if error is due to network connection.
        if (in_array($curl->errno, [6, 7, 28])) {
            // Try curl call up to 3 times.
            usleep(50000);
            $retryno = (!is_int($retryno)) ? 0 : $retryno+1;
            if ($retryno < 3) {
                return $this->getoembeddata($url, $retryno);
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

    $cache->set(md5($url), $ret);
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

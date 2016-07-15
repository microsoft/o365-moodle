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
 * @author Aashay Zajriya<aashay@introp.net>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2016 onwards Microsoft Open Technologies, Inc. (http://msopentech.com/)
 */

namespace filter_oembed\provider;
/**
 * oEmbed provider implementation for Microsoft Forms
 */
class officeforms extends base {
    /**
     * Get the replacement oembed HTML.
     *
     * @param array $matched Matched URL.
     * @return string The replacement text/HTML.
     */
    public function get_replacement($matched) {
        if (!empty($matched)) {
            $url = $matched[1].$matched[3].'/'.$matched[4].'/ResponsePage.aspx?id='.$matched[6].'&embed=true';
            $embedhtml = $this->getembedhtml($url);
            return $embedhtml;
        }
        return $matched[0];
    }

    /**
     * Filter the text.
     *
     * @param string $text Incoming text.
     * @return string Filtered text.
     */
    public function filter($text) {
        $search = '/<a\s[^>]*href="(https?:\/\/(www\.)?)(forms\.office\.com)\/(.+?)\/(DesignPage\.aspx)#FormId=(.+?)"(.*?)>(.*?)<\/a>/is';
        return preg_replace_callback($search, [$this, 'get_replacement'], $text);
    }

    /**
     * Return the HTML content to be embedded.
     *
     * @param string $embedurl Additional parameters to include in the embed URL.
     * @return string The HTML content to be embedded in the page.
     */
    private function getembedhtml($embedurl) {
        $iframeattrs = [
            'src' => $embedurl,
            'height' => '768px',
            'width' => '99%',
            'frameborder' => '0',
            'marginwidth' => '0',
            'marginheight' => '0',
            'style' => 'border: none; max-width: 100%; max-height: 100vh',
            'allowfullscreen' => 'true',
            'webkitallowfullscreen' => 'true',
            'mozallowfullscreen' => 'true',
            'msallowfullscreen' => 'true',
        ];
        return \html_writer::tag('iframe', ' ', $iframeattrs);
    }
}

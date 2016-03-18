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
 * @author Sushant Gawali <sushant@introp.net>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2016 onwards Microsoft Open Technologies, Inc. (http://msopentech.com/)
 */

namespace filter_oembed\provider;
/**
 * oEmbed provider implementation for Docs.com
 */
class powerbi extends base {
    /**
     * Get the replacement oembed HTML.
     *
     * @param array $matched Matched URL.
     * @return string The replacement text/HTML.
     */
    public function get_replacement($matched) {
        $httpclient = new \local_o365\httpclient();
        $clientdata = \local_o365\oauth2\clientdata::instance_from_oidc();
        $resource = \filter_oembed\rest\powerbi::get_resource();
        $token = \local_o365\oauth2\systemtoken::instance(null, $resource, $clientdata, $httpclient);
        if (!empty($token)) {
            $powerbi = new \filter_oembed\rest\powerbi($token, $httpclient);
            if ($matched[6] == 'reports') {
                $reportsdata = $powerbi->apicall('get', 'reports');
                $embedurl = $powerbi->getreportoembedurl($matched[7], $reportsdata);
                $embedhtml = $this->getembedhtml($embedurl);
                $embedhtml .= '<input type="hidden" class="token" value="' . $token->get_token(). '">';
                return $embedhtml;
            }
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
        $search = '/<a\s[^>]*href="(https?:\/\/(app\.)?)(powerbi\.com)\/(.+?)\/(.+?)\/(.+?)\/(.+?)\/(.+?)"(.*?)>(.*?)<\/a>/is';
        return preg_replace_callback($search, [$this, 'get_replacement'], $text);
    }

    private function getembedhtml($embedurl) {
        return '<iframe class="powerbi_iframe" src="'. $embedurl . '" '
                . 'height="768px" width="99%" frameborder="0" seamless></iframe>';
    }
}

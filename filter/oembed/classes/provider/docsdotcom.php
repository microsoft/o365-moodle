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
 * @author James McQuillan <james.mcquillan@remote-learner.net>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2016 onwards Microsoft, Inc. (http://microsoft.com/)
 */

namespace filter_oembed\provider;

/**
 * oEmbed provider implementation for Docs.com
 */
class docsdotcom extends base {
    /**
     * Get the replacement oembed HTML.
     *
     * @param array $matched Matched URL.
     * @return string The replacement text/HTML.
     */
    public function get_replacement($matched) {
        if (!empty($matched[0])) {
            $params = [
                'url' => $matched[1]. $matched[3] . '/' . $matched[4] . '/' . $matched[5] . '/' . $matched[6],
                'format' => 'json',
                'maxwidth' => '600',
                'maxheight' => '400',
            ];
            $oembedurl = new \moodle_url('https://docs.com/api/oembed', $params);
            $oembeddata = $this->getoembeddata($oembedurl->out(false));
            return '<div class="filter_oembed_docsdotcom">'.$this->getoembedhtml($oembeddata).'</div>';
        } else {
            return $matched[0];
        }
    }

    /**
     * Filter the text.
     *
     * @param string $text Incoming text.
     * @return string Filtered text.
     */
    public function filter($text) {
        $search = '/<a\s[^>]*href="(https?:\/\/(www\.)?)(docs\.com)\/(.+?)\/(.+?)\/(.+?)"(.*?)>(.*?)<\/a>/is';
        return preg_replace_callback($search, [$this, 'get_replacement'], $text);
    }
}

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
 * Unit tests for the filter_oembed.
 *
 * @package    filter_oembed
 * @author Sushant Gawali (sushant@introp.net)
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright Microsoft Open Technologies, Inc.
 */

defined('MOODLE_INTERNAL') || die();

global $CFG;
require_once($CFG->dirroot . '/filter/oembed/filter.php');


class filter_oembed_testcase extends basic_testcase {

    protected $filter;

    /**
     * Sets up the test cases.
     */
    protected function setUp() {
        parent::setUp();
        $this->filter = new filter_oembed(context_system::instance(), array());
    }

    /**
     * Performs unit tests for all services supported by the filter.
     */
    public function test_filter() {

        $souncloudlink = '<p><a href="https://soundcloud.com/el-silenzio-fatal/enrique-iglesias-el-perdedor">soundcloud</a></p>';
        $youtubelink = '<p><a href="https://www.youtube.com/watch?v=ns6gCZI-Nj8">Youtube</a></p>';
        $officemixlink = '<p><a href="https://mix.office.com/watch/50ujrxsjvp9c">mix</a></p>';
        $vimeolink = '<p><a href="http://vimeo.com/115538038">vimeo</a></p>';
        $tedlink = '<p><a href="https://www.ted.com/talks/aj_jacobs_how_healthy_living_nearly_killed_me">Ted</a></p>';
        $slidesharelink = '<p><a href="http://www.slideshare.net/timbrown/ideo-values-slideshare1">slideshare</a></p>';
        $issuulink = '<p><a href="http://issuu.com/hujawes/docs/dehorew">issuu</a></p>';
        $screenrlink = '<p><a href="https://www.screenr.com/wxVH">screenr</a></p>';
        $polleverywherelink = '<p><a href="https://www.polleverywhere.com/multiple_choice_polls/AyCp2jkJ2HqYKXc/web">';
        $polleverywherelink .= '$popolleverywhere</a></p>';

        $filterinput = $souncloudlink.$youtubelink.$officemixlink.$vimeolink.$tedlink.$slidesharelink.$issuulink.$screenrlink;
        $filterinput .= $polleverywherelink;

        $filteroutput = $this->filter->filter($filterinput);

        $youtubeoutput = '<iframe width="480" height="270" src="http://www.youtube.com/embed/ns6gCZI-Nj8?feature=oembed"';
        $youtubeoutput .= ' frameborder="0" allowfullscreen></iframe>';
        $this->assertContains($youtubeoutput, $filteroutput, 'Youtube filter fails');

        $soundcloudoutput = '<iframe width="480" height="270" scrolling="no" frameborder="no"';
        $soundcloudoutput .= ' src="https://w.soundcloud.com/player/?visual=true&url=http%3A%2F%2Fapi.soundcloud.com%';
        $soundcloudoutput .= '2Ftracks%2F132183772&show_artwork=true&maxwidth=480&maxheight=270%27"></iframe>';
        $this->assertContains($soundcloudoutput, $filteroutput, 'Soundcloud filter fails');

        $officemixoutput = '<iframe width="480" height="320" src="https://mix.office.com/embed/50ujrxsjvp9c" frameborder="0"';
        $officemixoutput .= ' allowfullscreen></iframe>';
        $this->assertContains($officemixoutput, $filteroutput, 'Office mix filter fails');

        $vimeooutput = '<iframe src="//player.vimeo.com/video/115538038" width="480" height="270" frameborder="0"';
        $vimeooutput .= ' title="Snow Fun" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
        $this->assertContains($vimeooutput, $filteroutput, 'Vimeo filter fails');

        $tedoutput = '<iframe src="https://embed-ssl.ted.com/talks/aj_jacobs_how_healthy_living_nearly_killed_me.html" width="480"';
        $tedoutput .= ' height="270" frameborder="0" scrolling="no" webkitAllowFullScreen mozallowfullscreen allowFullScreen>';
        $tedoutput .= '</iframe>';
        $this->assertContains($tedoutput, $filteroutput, 'Ted filter fails');

        $issuuoutput = '<div data-url="http://issuu.com/hujawes/docs/dehorew" style="width: 525px; height: 322px;"';
        $issuuoutput .= ' class="issuuembed"></div><script type="text/javascript" src="//e.issuu.com/embed.js" async="true">';
        $issuuoutput .= '</script>';
        $this->assertContains($issuuoutput, $filteroutput, 'Issuu filter fails');

        $screenroutput = '<iframe src="https://www.screenr.com/embed/wxVH" width="650" height="396" frameborder="0"></iframe>';
        $this->assertContains($screenroutput, $filteroutput, 'Screenr filter fails');

        $polleverywhereoutput = '<script src="http://www.polleverywhere.com/multiple_choice_polls/AyCp2jkJ2HqYKXc/web.js';
        $polleverywhereoutput .= '?results_count_format=percent"></script>';
        $this->assertContains($polleverywhereoutput, $filteroutput, 'Poll everywhare filter fails');

        $slideshareoutput = '<iframe src="http://www.slideshare.net/slideshow/embed_code/29331355" width="427" height="356"';
        $slideshareoutput .= ' frameborder="0" marginwidth="0" marginheight="0" scrolling="no" style="border:1px solid #CCC;';
        $slideshareoutput .= ' border-width:1px; margin-bottom:5px; max-width: 100%;" allowfullscreen> </iframe>';
        $this->assertContains($slideshareoutput, $filteroutput, 'Slidershare filter fails');
    }
}

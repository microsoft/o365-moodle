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
 * Test cases for functions in lib.php.
 *
 * @package local_o365
 * @author Lai Wei <lai.wei@enovation.ie>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2026 onwards Microsoft, Inc. (http://microsoft.com/)
 */

namespace local_o365;

use advanced_testcase;

/**
 * Tests functions in lib.php.
 *
 * @group local_o365
 * @group office365
 */
final class lib_test extends advanced_testcase {
    /**
     * The Sec-Fetch-* request headers touched by these tests.
     */
    private const FETCH_HEADERS = ['HTTP_SEC_FETCH_MODE', 'HTTP_SEC_FETCH_DEST', 'HTTP_SEC_FETCH_SITE'];

    /**
     * @var array The original values of the Sec-Fetch-* server variables, restored after each test.
     */
    private $originalheaders = [];

    /**
     * @var array The original request cookies, restored after each test.
     */
    private $originalcookies = [];

    /**
     * Perform setup before every test. This tells Moodle's phpunit to reset the database after every test.
     */
    protected function setUp(): void {
        global $CFG, $SESSION;

        parent::setUp();
        $this->resetAfterTest(true);

        require_once($CFG->dirroot . '/local/o365/lib.php');

        foreach (self::FETCH_HEADERS as $header) {
            if (array_key_exists($header, $_SERVER)) {
                $this->originalheaders[$header] = $_SERVER[$header];
            }
            unset($_SERVER[$header]);
        }

        $this->originalcookies = $_COOKIE;
        unset($_COOKIE[local_o365_get_teams_frame_cookie_name()]);

        $SESSION = new \stdClass();
        // Boost is the only theme every supported Moodle version ships (theme_classic was removed from core), and
        // theme_boost_o365teams is not installed in every test environment.
        set_config('customtheme', 'boost', 'local_o365');
    }

    /**
     * Restore the Sec-Fetch-* server variables and the request cookies.
     */
    protected function tearDown(): void {
        foreach (self::FETCH_HEADERS as $header) {
            unset($_SERVER[$header]);
        }
        foreach ($this->originalheaders as $header => $value) {
            $_SERVER[$header] = $value;
        }
        $this->originalheaders = [];

        $_COOKIE = $this->originalcookies;
        $this->originalcookies = [];

        parent::tearDown();
    }

    /**
     * Simulate a request reaching local_o365_after_require_login(), or the Teams tab entry page.
     *
     * The Teams frame cookie is not set by any request: the entry page's JavaScript sets it in the browser once the
     * Teams SDK handshake has succeeded, which cannot be run here. Tests model the browser instead: they state which
     * browsing contexts hold the cookie, as only the Teams tab does after a successful handshake, and pass that as
     * $teamsframe for the requests of that context.
     *
     * @param array $headers The Sec-Fetch-* server variables of the request.
     * @param bool $teamsframe Whether the browser sends the Teams frame cookie with the request. A browser only does
     *                         so for requests made from inside the Teams tab, as the cookie is Partitioned.
     * @param bool $entrypage Whether the request is for local/o365/teams_tab.php, which applies the Teams theme
     *                        itself instead of going through local_o365_after_require_login().
     */
    private function send_request(array $headers, bool $teamsframe, bool $entrypage = false): void {
        foreach (self::FETCH_HEADERS as $header) {
            unset($_SERVER[$header]);
        }
        foreach ($headers as $header => $value) {
            $_SERVER[$header] = $value;
        }

        $cookiename = local_o365_get_teams_frame_cookie_name();
        if ($teamsframe) {
            $_COOKIE[$cookiename] = '1';
        } else {
            unset($_COOKIE[$cookiename]);
        }

        if ($entrypage) {
            // What local/o365/teams_tab.php does on the server.
            local_o365_apply_teams_theme();
        } else {
            local_o365_after_require_login(null, false, null, true, false);
        }
    }

    /**
     * Data provider for test_after_require_login_theme_override().
     *
     * @return array Test cases: request headers, Teams frame cookie sent, initial session override, expected session override.
     */
    public static function after_require_login_provider(): array {
        $teamsoverride = ['theme' => 'boost', 'local_o365_teamstheme' => true];
        $iframe = ['HTTP_SEC_FETCH_MODE' => 'navigate', 'HTTP_SEC_FETCH_DEST' => 'iframe'];
        $document = ['HTTP_SEC_FETCH_MODE' => 'navigate', 'HTTP_SEC_FETCH_DEST' => 'document'];

        return [
            'Cross-site iframe without the marker is not the Teams tab (e.g. an external tool returning to Moodle)' => [
                $iframe + ['HTTP_SEC_FETCH_SITE' => 'cross-site'],
                false,
                [],
                [],
            ],
            'Cross-site iframe without the marker clears an override a Teams tab set meanwhile' => [
                $iframe + ['HTTP_SEC_FETCH_SITE' => 'cross-site'],
                false,
                $teamsoverride,
                [],
            ],
            'Cross-site iframe without the marker does not clear an unrelated override' => [
                $iframe + ['HTTP_SEC_FETCH_SITE' => 'cross-site'],
                false,
                ['theme' => 'unrelatedtheme'],
                ['theme' => 'unrelatedtheme'],
            ],
            'Cross-site iframe carrying the marker applies the theme (page the entry page redirects to)' => [
                $iframe + ['HTTP_SEC_FETCH_SITE' => 'cross-site'],
                true,
                [],
                $teamsoverride,
            ],
            'Moodle embedded by a page of its own site is not the Teams tab' => [
                $iframe + ['HTTP_SEC_FETCH_SITE' => 'same-site'],
                false,
                [],
                [],
            ],
            'Same-site iframe clears an override a Teams tab set meanwhile' => [
                $iframe + ['HTTP_SEC_FETCH_SITE' => 'same-site'],
                false,
                $teamsoverride,
                [],
            ],
            'Same-site iframe does not clear an unrelated override' => [
                $iframe + ['HTTP_SEC_FETCH_SITE' => 'same-site'],
                false,
                ['theme' => 'unrelatedtheme'],
                ['theme' => 'unrelatedtheme'],
            ],
            'Same-origin iframe in a direct browser page, no override (e.g. Turnitin modal)' => [
                $iframe + ['HTTP_SEC_FETCH_SITE' => 'same-origin'],
                false,
                [],
                [],
            ],
            'Same-origin iframe in a direct browser page does not clear an unrelated override' => [
                $iframe + ['HTTP_SEC_FETCH_SITE' => 'same-origin'],
                false,
                ['theme' => 'unrelatedtheme'],
                ['theme' => 'unrelatedtheme'],
            ],
            'Same-origin iframe in a direct browser page clears an override a Teams tab set meanwhile' => [
                $iframe + ['HTTP_SEC_FETCH_SITE' => 'same-origin'],
                false,
                $teamsoverride,
                [],
            ],
            'User-initiated iframe navigation outside the Teams tab clears a Teams override' => [
                $iframe + ['HTTP_SEC_FETCH_SITE' => 'none'],
                false,
                $teamsoverride,
                [],
            ],
            'Iframe without Sec-Fetch-Site leaves a Teams override alone' => [
                $iframe,
                false,
                $teamsoverride,
                $teamsoverride,
            ],
            'Same-origin iframe navigation inside the Teams tab keeps the override' => [
                $iframe + ['HTTP_SEC_FETCH_SITE' => 'same-origin'],
                true,
                $teamsoverride,
                $teamsoverride,
            ],
            'Same-origin iframe navigation inside the Teams tab restores a cleared override' => [
                $iframe + ['HTTP_SEC_FETCH_SITE' => 'same-origin'],
                true,
                [],
                $teamsoverride,
            ],
            'User-initiated iframe navigation inside the Teams tab restores a cleared override' => [
                $iframe + ['HTTP_SEC_FETCH_SITE' => 'none'],
                true,
                [],
                $teamsoverride,
            ],
            'User-initiated iframe navigation outside the Teams tab does not apply the theme' => [
                $iframe + ['HTTP_SEC_FETCH_SITE' => 'none'],
                false,
                [],
                [],
            ],
            'Iframe without Sec-Fetch-Site does not apply the theme' => [
                $iframe,
                false,
                [],
                [],
            ],
            'Direct browser navigation clears the Teams override' => [
                $document + ['HTTP_SEC_FETCH_SITE' => 'none'],
                false,
                $teamsoverride,
                [],
            ],
            'Direct browser navigation keeps an unrelated override' => [
                $document + ['HTTP_SEC_FETCH_SITE' => 'none'],
                false,
                ['theme' => 'unrelatedtheme'],
                ['theme' => 'unrelatedtheme'],
            ],
            'Subresource request in the Teams tab keeps the override' => [
                ['HTTP_SEC_FETCH_MODE' => 'cors', 'HTTP_SEC_FETCH_DEST' => 'empty', 'HTTP_SEC_FETCH_SITE' => 'same-origin'],
                true,
                $teamsoverride,
                $teamsoverride,
            ],
            'Browser without Sec-Fetch headers keeps the override' => [
                [],
                false,
                $teamsoverride,
                $teamsoverride,
            ],
        ];
    }

    /**
     * Test that local_o365_after_require_login() only applies the Teams theme to iframe navigations made from
     * inside the Teams tab, i.e. carrying the Teams frame cookie, whatever their Sec-Fetch-Site.
     *
     * @dataProvider after_require_login_provider
     * @covers ::local_o365_after_require_login
     * @param array $headers The Sec-Fetch-* server variables of the request.
     * @param bool $teamsframe Whether the request carries the Teams frame cookie.
     * @param array $initial The initial $SESSION properties.
     * @param array $expected The expected $SESSION properties after the callback ran.
     */
    public function test_after_require_login_theme_override(
        array $headers,
        bool $teamsframe,
        array $initial,
        array $expected
    ): void {
        global $SESSION;

        foreach ($initial as $property => $value) {
            $SESSION->$property = $value;
        }

        $this->send_request($headers, $teamsframe);

        $this->assertEquals($expected, (array)$SESSION);
    }

    /**
     * Test that a Teams tab keeps its theme when a direct browser tab sharing the session navigates in between.
     *
     * The Teams tab and the browser tab share one Moodle session, but only the Teams tab sends the Partitioned
     * Teams frame cookie, so it is the only one whose same-origin iframe navigations restore the override. Iframes
     * embedded in the browser tab are never themed as Teams.
     *
     * @covers ::local_o365_after_require_login
     */
    public function test_after_require_login_restores_teams_theme_after_browser_navigation(): void {
        global $SESSION;

        $teamsoverride = ['theme' => 'boost', 'local_o365_teamstheme' => true];
        $iframe = ['HTTP_SEC_FETCH_MODE' => 'navigate', 'HTTP_SEC_FETCH_DEST' => 'iframe'];
        $document = ['HTTP_SEC_FETCH_MODE' => 'navigate', 'HTTP_SEC_FETCH_DEST' => 'document', 'HTTP_SEC_FETCH_SITE' => 'none'];

        // The Teams tab loads the entry page in a cross-site iframe and the page applies the theme. The Teams SDK
        // handshake succeeds there, so the page's script stores the Teams frame cookie, which the browser keeps in the
        // cookie partition of the Teams tab.
        $this->send_request($iframe + ['HTTP_SEC_FETCH_SITE' => 'cross-site'], false, true);
        $teamstabhascookie = true;
        $this->assertEquals($teamsoverride, (array)$SESSION);

        // The user navigates in a normal browser tab sharing the session: the override is cleared. That tab does
        // not have the cookie.
        $this->send_request($document, false);
        $this->assertEquals([], (array)$SESSION);

        // A page embedded by that browser tab, e.g. the Turnitin modal, is not themed as Teams.
        $this->send_request($iframe + ['HTTP_SEC_FETCH_SITE' => 'same-origin'], false);
        $this->assertEquals([], (array)$SESSION);

        // The user then follows a link inside the already-open Teams tab: the override is restored.
        $this->send_request($iframe + ['HTTP_SEC_FETCH_SITE' => 'same-origin'], $teamstabhascookie);
        $this->assertEquals($teamsoverride, (array)$SESSION);

        // The browser tab navigates again, clearing it once more, and the Teams tab restores it again.
        $this->send_request($document, false);
        $this->assertEquals([], (array)$SESSION);
        $this->send_request($iframe + ['HTTP_SEC_FETCH_SITE' => 'same-origin'], $teamstabhascookie);
        $this->assertEquals($teamsoverride, (array)$SESSION);
    }

    /**
     * Test that following a link inside a frame keeps the theme the entry into that frame decided on.
     *
     * An entry that gets the Teams theme must keep it for the first same-origin link, and an entry that does not get
     * it must not be themed by that link either. In particular, Moodle embedded by a page of its own site cannot be
     * given a frame-scoped Teams marker (its cookie would share the partition of direct browser tabs), so it is
     * treated like any other non-Teams iframe from its first request on, instead of being themed and then losing
     * the theme at the first link.
     *
     * @covers ::local_o365_after_require_login
     */
    public function test_after_require_login_entry_then_link_keeps_the_same_theme_decision(): void {
        global $SESSION;

        $teamsoverride = ['theme' => 'boost', 'local_o365_teamstheme' => true];
        $iframe = ['HTTP_SEC_FETCH_MODE' => 'navigate', 'HTTP_SEC_FETCH_DEST' => 'iframe'];
        $link = $iframe + ['HTTP_SEC_FETCH_SITE' => 'same-origin'];

        // Teams tab entry (cross-site) applies the theme, and the handshake then lets its script store the cookie.
        // The page it goes on to (still cross-site, now with the cookie), and the links inside it, are themed too.
        $this->send_request($iframe + ['HTTP_SEC_FETCH_SITE' => 'cross-site'], false, true);
        $teamstabhascookie = true;
        $this->assertEquals($teamsoverride, (array)$SESSION);
        $this->send_request($iframe + ['HTTP_SEC_FETCH_SITE' => 'cross-site'], $teamstabhascookie);
        $this->assertEquals($teamsoverride, (array)$SESSION);
        $this->send_request($link, $teamstabhascookie);
        $this->assertEquals($teamsoverride, (array)$SESSION);
        $this->send_request($link, $teamstabhascookie);
        $this->assertEquals($teamsoverride, (array)$SESSION);

        // Moodle embedded by a page of its own site: not themed on entry, and not on the links inside it either.
        $SESSION = new \stdClass();
        $sitetabhascookie = false;
        $this->send_request($iframe + ['HTTP_SEC_FETCH_SITE' => 'same-site'], $sitetabhascookie);
        $this->assertEquals([], (array)$SESSION);
        $this->send_request($link, $sitetabhascookie);
        $this->assertEquals([], (array)$SESSION);

        // Such an embed does not inherit an override left in the shared session by a Teams tab either.
        $SESSION = new \stdClass();
        $SESSION->theme = $teamsoverride['theme'];
        $SESSION->local_o365_teamstheme = true;
        $this->send_request($iframe + ['HTTP_SEC_FETCH_SITE' => 'same-site'], false);
        $this->assertEquals([], (array)$SESSION);
    }

    /**
     * Test that a modal in an already-open browser page does not inherit an override a Teams tab sets meanwhile.
     *
     * The browser page was opened before the Teams tab loaded, so nothing has cleared the override the Teams tab
     * then wrote to the shared session. The modal, a same-origin iframe without the Teams frame cookie, must not
     * be themed as Teams, while an unrelated override of that page must survive.
     *
     * @covers ::local_o365_after_require_login
     * @covers ::local_o365_clear_teams_theme
     */
    public function test_after_require_login_clears_teams_theme_for_modal_in_open_browser_page(): void {
        global $SESSION;

        $teamsoverride = ['theme' => 'boost', 'local_o365_teamstheme' => true];
        $iframe = ['HTTP_SEC_FETCH_MODE' => 'navigate', 'HTTP_SEC_FETCH_DEST' => 'iframe'];
        $modal = $iframe + ['HTTP_SEC_FETCH_SITE' => 'same-origin'];

        // A normal browser page is already open. Then the Teams tab loads and sets the shared session override, and
        // its script stores the Teams frame cookie once the handshake succeeded.
        $this->send_request($iframe + ['HTTP_SEC_FETCH_SITE' => 'cross-site'], false, true);
        $teamstabhascookie = true;
        $this->assertEquals($teamsoverride, (array)$SESSION);

        // The browser page opens a modal (no Teams frame cookie): the override this plugin set is cleared.
        $this->send_request($modal, false);
        $this->assertEquals([], (array)$SESSION);

        // The Teams tab follows a link (it has the cookie): the override is restored.
        $this->send_request($modal, $teamstabhascookie);
        $this->assertEquals($teamsoverride, (array)$SESSION);

        // The modal of the browser page clears it again.
        $this->send_request($modal, false);
        $this->assertEquals([], (array)$SESSION);

        // An override this plugin did not set, e.g. Moodle's ?theme= URL switch, is left alone by that modal.
        $SESSION->theme = 'unrelatedtheme';
        $this->send_request($modal, false);
        $this->assertEquals(['theme' => 'unrelatedtheme'], (array)$SESSION);
    }

    /**
     * Test that opening the Teams tab entry page directly does not make later iframes look like the Teams tab.
     *
     * local/o365/teams_tab.php applies the Teams theme unconditionally. Opened in a normal browser tab there is no Teams
     * host, so the Teams SDK handshake fails and the page's script does not store the Teams frame cookie. Were it
     * stored there, it would land in Moodle's own cookie partition, which the browser tab and the iframes it embeds
     * (e.g. the Turnitin modal) share, and the modal would get the Teams theme back after the override was cleared.
     *
     * @covers ::local_o365_apply_teams_theme
     * @covers ::local_o365_after_require_login
     */
    public function test_direct_entry_page_access_does_not_mark_same_origin_iframes_as_teams(): void {
        global $SESSION;

        $iframe = ['HTTP_SEC_FETCH_MODE' => 'navigate', 'HTTP_SEC_FETCH_DEST' => 'iframe'];
        $document = ['HTTP_SEC_FETCH_MODE' => 'navigate', 'HTTP_SEC_FETCH_DEST' => 'document', 'HTTP_SEC_FETCH_SITE' => 'none'];

        // Someone opens the entry page directly in a browser tab. The page still applies the theme to the session
        // (it does so for every request), but the handshake fails there, so no cookie is stored.
        $this->send_request($document, false, true);
        $browsertabhascookie = false;
        $this->assertEquals(['theme' => 'boost', 'local_o365_teamstheme' => true], (array)$SESSION);

        // The next page in that tab clears the override.
        $this->send_request($document, $browsertabhascookie);
        $this->assertEquals([], (array)$SESSION);

        // The Turnitin modal, a same-origin iframe of that tab, is not themed as Teams.
        $this->send_request($iframe + ['HTTP_SEC_FETCH_SITE' => 'same-origin'], $browsertabhascookie);
        $this->assertEquals([], (array)$SESSION);
    }

    /**
     * Test that an iframe of a normal Moodle page coming back from another site does not make later iframes look like Teams.
     *
     * Sec-Fetch-Site: cross-site does not identify the top-level site. An iframe in an ordinary Moodle page, e.g. an
     * external tool, can navigate its own iframe to another site and back to Moodle, or be redirected through one, and
     * the request then looks just like the Teams tab being loaded, even for the Teams tab entry page. The top-level
     * site is still Moodle's own, so a cookie stored for it would land in the partition shared with the page's other
     * iframes, e.g. a modal, which would get the Teams theme. Nothing on the server can tell, so the Teams SDK
     * handshake, which only succeeds under a Teams host, decides whether the page's script stores the cookie.
     *
     * @covers ::local_o365_apply_teams_theme
     * @covers ::local_o365_after_require_login
     */
    public function test_iframe_coming_back_from_another_site_is_not_marked_as_teams(): void {
        global $SESSION;

        $teamsoverride = ['theme' => 'boost', 'local_o365_teamstheme' => true];
        $iframe = ['HTTP_SEC_FETCH_MODE' => 'navigate', 'HTTP_SEC_FETCH_DEST' => 'iframe'];
        $comingback = $iframe + ['HTTP_SEC_FETCH_SITE' => 'cross-site'];
        $modal = $iframe + ['HTTP_SEC_FETCH_SITE' => 'same-origin'];

        // A normal browser page has an iframe that comes back to an ordinary Moodle page from another site.
        $browserpagehascookie = false;
        $this->send_request($comingback, $browserpagehascookie);
        $this->assertEquals([], (array)$SESSION);

        // It comes back to the Teams tab entry page. The page applies the theme to the shared session, but the
        // handshake cannot succeed under a Moodle page, so the cookie is not stored and the modal the browser
        // page opens afterwards is not themed as Teams: it clears the override instead.
        $this->send_request($comingback, $browserpagehascookie, true);
        $this->assertEquals($teamsoverride, (array)$SESSION);
        $this->send_request($modal, $browserpagehascookie);
        $this->assertEquals([], (array)$SESSION);

        // The same iframe coming back to an ordinary page again does not inherit an override from a Teams tab.
        $this->send_request($comingback, $browserpagehascookie, true);
        $this->send_request($comingback, $browserpagehascookie);
        $this->assertEquals([], (array)$SESSION);

        // The real Teams tab loads: its handshake succeeds, its script stores the cookie, and it keeps working while
        // the browser page's iframes, without the cookie, still are not themed.
        $this->send_request($comingback, false, true);
        $teamstabhascookie = true;
        $this->assertEquals($teamsoverride, (array)$SESSION);
        $this->send_request($modal, $browserpagehascookie);
        $this->assertEquals([], (array)$SESSION);
        $this->send_request($modal, $teamstabhascookie);
        $this->assertEquals($teamsoverride, (array)$SESSION);
    }

    /**
     * Test the Teams frame cookie name and attributes.
     *
     * @covers ::local_o365_get_teams_frame_cookie_name
     * @covers ::local_o365_get_teams_frame_cookie
     * @covers ::local_o365_in_teams_frame
     */
    public function test_teams_frame_cookie(): void {
        global $CFG;

        $CFG->sessioncookie = 'x_y-z';
        $name = local_o365_get_teams_frame_cookie_name();
        $this->assertEquals('local_o365_teamsframex_yz', $name);

        $cookie = local_o365_get_teams_frame_cookie();
        $this->assertStringStartsWith($name . '=1; Path=', $cookie);
        // Partitioned is what keeps the cookie from being sent from a direct browser tab, and it requires Secure.
        foreach (['Secure', 'SameSite=None', 'Partitioned'] as $attribute) {
            $this->assertStringContainsString('; ' . $attribute, $cookie);
        }
        // It is set from JavaScript, which cannot set an HttpOnly cookie.
        $this->assertStringNotContainsString('HttpOnly', $cookie);

        $this->assertFalse(local_o365_in_teams_frame());
        $_COOKIE[$name] = '1';
        $this->assertTrue(local_o365_in_teams_frame());
    }

    /**
     * Data provider for test_teams_frame_cookie_store_options().
     *
     * @return array Test cases: session cookie domain, expected Cookie Store domain, null if it has none.
     */
    public static function teams_frame_cookie_store_options_provider(): array {
        return [
            'No domain' => ['', null],
            'Domain without a leading dot' => ['example.com', 'example.com'],
            'Domain with a leading dot, which the Cookie Store API rejects' => ['.example.com', 'example.com'],
            'Subdomain with a leading dot' => ['.moodle.example.com', 'moodle.example.com'],
            'Several leading dots' => ['..example.com', 'example.com'],
            'Only a dot' => ['.', null],
        ];
    }

    /**
     * Test the options that identify the Teams frame cookie to the Cookie Store API.
     *
     * @dataProvider teams_frame_cookie_store_options_provider
     * @covers ::local_o365_get_teams_frame_cookie_store_options
     * @param string $sessiondomain The session cookie domain.
     * @param string|null $expecteddomain The domain the options should have, null if none.
     */
    public function test_teams_frame_cookie_store_options(string $sessiondomain, ?string $expecteddomain): void {
        $options = local_o365_get_teams_frame_cookie_store_options(['path' => '/moodle/', 'domain' => $sessiondomain]);

        $this->assertSame(local_o365_get_teams_frame_cookie_name(), $options['name']);
        $this->assertSame('/moodle/', $options['path']);
        if ($expecteddomain === null) {
            $this->assertArrayNotHasKey('domain', $options);
        } else {
            $this->assertSame($expecteddomain, $options['domain']);
        }

        // The session cookie parameters are only a default.
        $this->assertArrayHasKey('path', local_o365_get_teams_frame_cookie_store_options());
    }

    /**
     * Test the JavaScript the Teams tab entry page runs to store the Teams frame cookie.
     *
     * @covers ::local_o365_get_teams_frame_marker_js
     */
    public function test_teams_frame_marker_js(): void {
        global $CFG;

        // Over HTTPS it defines markTeamsFrame(), which sets exactly the Teams frame cookie, as a valid JavaScript
        // string, and verifies where it can that the browser stored it as a partitioned cookie.
        $CFG->wwwroot = 'https://www.example.com/moodle';
        $js = local_o365_get_teams_frame_marker_js();
        $this->assertStringStartsWith('function markTeamsFrame() {', $js);
        $this->assertStringContainsString(json_encode(local_o365_get_teams_frame_cookie(), JSON_UNESCAPED_SLASHES), $js);
        $this->assertStringContainsString('window.cookieStore', $js);
        $this->assertStringContainsString('"partitioned":true', $js);
        $this->assertStringContainsString('item.partitioned === true', $js);

        // With the Cookie Store API, partitioning is probed with a temporary cookie the server does not recognise, and
        // the real marker is only created once the probe was reported as partitioned. Until then no cookie the server
        // would take for the Teams tab exists, however many contexts of a browser that does not partition it send it.
        $name = local_o365_get_teams_frame_cookie_name();
        $probename = local_o365_get_teams_frame_probe_cookie_name();
        $this->assertStringContainsString('"name":"' . $probename . '"', $js);
        $this->assertStringContainsString('probe.expires = Date.now() + 60000;', $js);
        $this->assertStringContainsString('if (partitioned) {', $js);
        $this->assertGreaterThan(strpos($js, 'if (partitioned) {'), strpos($js, '"name":"' . $name . '"'));
        $this->assertLessThan(strpos($js, 'if (partitioned) {'), strpos($js, '"name":"' . $probename . '"'));
        $this->assertSame(1, substr_count($js, '"name":"' . $name . '"'));

        // CookieStore.delete() defaults partitioned to false, so a probe stored as a partitioned cookie is only deleted
        // when told to look for one, otherwise it would stay until it expires. An unpartitioned one is deleted as such.
        $deleteoptions = ['name' => $probename] + local_o365_get_teams_frame_cookie_store_options();
        $partitioneddelete = json_encode($deleteoptions + ['partitioned' => true], JSON_UNESCAPED_SLASHES);
        $this->assertStringContainsString(
            'var deleteoptions = partitioned ? ' . $partitioneddelete . ' : ' . json_encode($deleteoptions, JSON_UNESCAPED_SLASHES),
            $js
        );

        // When the probe or the marker cannot be created the fallback expires both as ordinary and partitioned cookies.
        $this->assertStringContainsString(
            'var expired = ' . json_encode(local_o365_get_teams_frame_cookie_expiry_headers(), JSON_UNESCAPED_SLASHES),
            $js
        );
        $probeexpiry = local_o365_get_teams_frame_cookie_expiry_headers($probename);
        $this->assertStringContainsString('var probeexpired = ' . json_encode($probeexpiry, JSON_UNESCAPED_SLASHES), $js);
        $this->assertStringContainsString('expired.concat(probeexpired).forEach(function(header) {', $js);

        // The returned promise never rejects, as the Teams tab entry page waits for it before navigating on.
        $this->assertStringContainsString('.catch(function() {', $js);
        $this->assertStringContainsString('return Promise.resolve();', $js);
        // Every placeholder was replaced.
        $this->assertStringNotContainsString('__', $js);

        // Without the Cookie Store API the cookie is only set once document.hasStorageAccess() has shown that the frame
        // has no unpartitioned cookies, never unverified: that is the only place it is set with document.cookie.
        $this->assertStringContainsString('document.hasStorageAccess', $js);
        $this->assertSame(1, substr_count($js, 'document.cookie = cookie;'));
        $this->assertGreaterThan(strpos($js, 'if (!unpartitioned) {'), strpos($js, 'document.cookie = cookie;'));
        // Where neither can verify it, the function ends without setting anything.
        $noverification = "// Partitioning cannot be verified here, so there is no marker.\n    return Promise.resolve();";
        $this->assertStringContainsString($noverification, $js);

        // Without HTTPS the cookie could not be Secure, so there is nothing to set.
        $CFG->wwwroot = 'http://www.example.com/moodle';
        $CFG->sslproxy = false;
        $this->assertEquals('function markTeamsFrame() { return Promise.resolve(); }', local_o365_get_teams_frame_marker_js());
    }

    /**
     * Test the headers that expire the Teams frame cookie.
     *
     * @covers ::local_o365_get_teams_frame_cookie_expiry_headers
     */
    public function test_teams_frame_cookie_expiry_headers(): void {
        $name = local_o365_get_teams_frame_cookie_name();

        $headers = local_o365_get_teams_frame_cookie_expiry_headers();
        $this->assertCount(2, $headers);
        foreach ($headers as $header) {
            $this->assertStringStartsWith($name . '=; Max-Age=0; Path=', $header);
            $this->assertStringContainsString('; Secure; SameSite=None', $header);
        }

        // One expires the cookie as the ordinary cookie a browser without Partitioned support stores, one the
        // Partitioned variant.
        $this->assertStringNotContainsString('Partitioned', $headers[0]);
        $this->assertStringEndsWith('; Partitioned', $headers[1]);

        // Another cookie of the same scope can be expired the same way.
        $probeheaders = local_o365_get_teams_frame_cookie_expiry_headers(local_o365_get_teams_frame_probe_cookie_name());
        $this->assertStringStartsWith(local_o365_get_teams_frame_probe_cookie_name() . '=; Max-Age=0; Path=', $probeheaders[0]);
        $this->assertStringEndsWith('; Partitioned', $probeheaders[1]);
    }

    /**
     * Test the name of the temporary cookie used to probe whether the browser partitions cookies.
     *
     * The server only recognises the Teams frame cookie, so the probe must neither be that cookie nor be mistaken for it.
     *
     * @covers ::local_o365_get_teams_frame_probe_cookie_name
     * @covers ::local_o365_in_teams_frame
     */
    public function test_teams_frame_probe_cookie_name(): void {
        global $CFG;

        $CFG->sessioncookie = 'x_y-z';
        $name = local_o365_get_teams_frame_cookie_name();
        $probename = local_o365_get_teams_frame_probe_cookie_name();

        $this->assertEquals('local_o365_teamsprobex_yz', $probename);
        $this->assertNotEquals($name, $probename);
        $this->assertStringStartsNotWith($name, $probename);
        $this->assertStringStartsNotWith($probename, $name);

        // A request that carries only the probe is not taken for the Teams tab.
        $_COOKIE[$probename] = '1';
        $this->assertFalse(local_o365_in_teams_frame());
    }

    /**
     * Test that a modal in an already-open page is not themed as Teams when partitioning cannot be verified.
     *
     * Where the entry page's script cannot verify that the browser partitions the Teams frame cookie, it does not set
     * it. Were it set unverified, a browser that does not partition it would send it with the next modal of a Moodle
     * page that is already open, which would get the Teams theme before any top-level request could give the browser
     * away. Without the cookie that modal is not themed as Teams, and neither are the pages of the Teams tab: in such a
     * browser the Teams tab does not get the Teams theme, which is the deliberate price of never theming other iframes.
     *
     * @covers ::local_o365_after_require_login
     * @covers ::local_o365_in_teams_frame
     */
    public function test_modal_in_open_page_is_not_themed_when_partitioning_cannot_be_verified(): void {
        global $SESSION;

        $teamsoverride = ['theme' => 'boost', 'local_o365_teamstheme' => true];
        $iframe = ['HTTP_SEC_FETCH_MODE' => 'navigate', 'HTTP_SEC_FETCH_DEST' => 'iframe'];
        $modal = $iframe + ['HTTP_SEC_FETCH_SITE' => 'same-origin'];

        // A normal browser page is already open. The Teams tab loads in the same browser and its handshake succeeds,
        // but its script cannot verify partitioning (no Cookie Store API, and the Storage Access API missing or
        // reporting access to unpartitioned cookies), so no cookie is stored in any context.
        $this->send_request($iframe + ['HTTP_SEC_FETCH_SITE' => 'cross-site'], false, true);
        $nocookie = false;
        $this->assertEquals($teamsoverride, (array)$SESSION);

        // The open page opens a modal before any other top-level request: it is not themed as Teams.
        $this->send_request($modal, $nocookie);
        $this->assertEquals([], (array)$SESSION);

        // Nor is the page the Teams tab goes on to: the theme is lost after the entry page, but no other iframe is
        // themed as Teams.
        $this->send_request($iframe + ['HTTP_SEC_FETCH_SITE' => 'cross-site'], $nocookie);
        $this->assertEquals([], (array)$SESSION);
        $this->send_request($modal, $nocookie);
        $this->assertEquals([], (array)$SESSION);
    }

    /**
     * Test that a browser which does not partition the Teams frame cookie does not make other iframes look like Teams.
     *
     * A browser that accepts third-party cookies but does not support the Partitioned attribute stores the cookie as an
     * ordinary cookie, which direct browser tabs and their modals send as well. Cookie presence is then no proof of a
     * Teams context. A partitioned cookie is never sent to top-level Moodle pages, so one top-level request that carries
     * it gives such a browser away, after which the cookie is no longer trusted nor set again.
     *
     * @covers ::local_o365_after_require_login
     * @covers ::local_o365_discard_leaked_teams_frame_cookie
     * @covers ::local_o365_in_teams_frame
     */
    public function test_teams_frame_cookie_is_not_trusted_once_a_top_level_request_carries_it(): void {
        global $CFG, $SESSION;

        $teamsoverride = ['theme' => 'boost', 'local_o365_teamstheme' => true];
        $leaked = ['local_o365_teamsframeleaked' => true];
        $iframe = ['HTTP_SEC_FETCH_MODE' => 'navigate', 'HTTP_SEC_FETCH_DEST' => 'iframe'];
        $document = ['HTTP_SEC_FETCH_MODE' => 'navigate', 'HTTP_SEC_FETCH_DEST' => 'document', 'HTTP_SEC_FETCH_SITE' => 'none'];
        $link = $iframe + ['HTTP_SEC_FETCH_SITE' => 'same-origin'];

        // The Teams tab loads and its handshake succeeds. This browser stores the cookie as an ordinary cookie, so every
        // context sends it. Nothing gives that away yet, so the Teams tab is themed as usual.
        $this->send_request($iframe + ['HTTP_SEC_FETCH_SITE' => 'cross-site'], false, true);
        $sharedjar = true;
        $this->send_request($link, $sharedjar);
        $this->assertEquals($teamsoverride, (array)$SESSION);

        // The user loads a Moodle page directly in a browser tab. A partitioned cookie would not be sent there, this one
        // is: the Teams override is cleared and the browser is marked as not partitioning the cookie.
        $this->send_request($document, $sharedjar);
        $this->assertEquals($leaked, (array)$SESSION);

        // From then on the cookie proves nothing. The modal of that page is not themed as Teams, although it sends the
        // cookie, and neither is the Teams tab, as this browser cannot keep the two apart.
        $this->send_request($link, $sharedjar);
        $this->assertEquals($leaked, (array)$SESSION);
        $this->send_request($iframe + ['HTTP_SEC_FETCH_SITE' => 'cross-site'], $sharedjar);
        $this->assertEquals($leaked, (array)$SESSION);

        // The Teams tab entry page does not set the cookie again.
        $CFG->wwwroot = 'https://www.example.com/moodle';
        $this->assertEquals('function markTeamsFrame() { return Promise.resolve(); }', local_o365_get_teams_frame_marker_js());
    }
}

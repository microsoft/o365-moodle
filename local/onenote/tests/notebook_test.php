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
 * Unit tests for finding and remembering the OneNote notebook used for Moodle.
 *
 * @package    local_onenote
 * @copyright  2026 Enovation
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_onenote;

use local_onenote\api\base;

/**
 * Tests that the notebook of a user is found by its id, so that it is not duplicated when its title changes.
 *
 * @group local_onenote
 * @covers \local_onenote\notebook
 * @covers \local_onenote\api\base::find_moodle_notebook
 * @covers \local_onenote\api\base::sync_notebook_data
 */
final class notebook_test extends \advanced_testcase {
    /** @var \stdClass The user whose OneNote account is used. */
    private $user;

    /**
     * Create the user.
     */
    protected function setUp(): void {
        parent::setUp();
        $this->resetAfterTest();
        $this->user = $this->getDataGenerator()->create_user();
        $this->setUser($this->user);
    }

    /**
     * Create a notebook as returned by the OneNote API.
     *
     * @param string $id The notebook id.
     * @param string $title The notebook title.
     * @return array The notebook.
     */
    private static function notebook(string $id, string $title): array {
        return ['id' => $id, 'title' => $title];
    }

    /**
     * Create an API stub with a fake OneNote account, which is the array of notebooks keyed by id with their titles.
     *
     * @param array $account The notebook titles by notebook id that are in the account.
     * @return base The API stub, with public $account, $created and $listfails properties.
     */
    private function create_api(array $account = []): base {
        return new class ($account) extends base {
            /** @var array The titles of the notebooks in the account, by notebook id. */
            public $account;
            /** @var int The number of notebooks created. */
            public $created = 0;
            /** @var bool Whether getting the notebooks fails. */
            public $listfails = false;
            /** @var int The number of notebooks in a page of notebooks, or 0 to return them all in one page. */
            public $pagesize = 0;
            /** @var int|null The number of notebooks to skip in the page of notebooks that fails, or null if no page fails. */
            public $failatskip = null;
            /** @var string|null A link to give as the link to the next page of the first page instead of the real one. */
            public $nextlink = null;
            /** @var bool Whether every page has a link to the page that skips 2 notebooks, so the pages never end. */
            public $loops = false;
            /** @var string[] The endpoints of the requests for notebooks that were made. */
            public $requests = [];

            /**
             * Create the stub.
             *
             * @param array $account The titles of the notebooks in the account, by notebook id.
             */
            public function __construct(array $account) {
                $this->account = $account;
            }

            /**
             * Answer the calls made for notebooks from the fake account.
             *
             * @param string $httpmethod The HTTP method to use.
             * @param string $apimethod The API endpoint/method to call.
             * @param string $params Additional parameters to include.
             * @param array $options Additional options for the request.
             * @return string The JSON response.
             */
            public function apicall($httpmethod, $apimethod, $params = '', $options = []) {
                if ($httpmethod === 'get' && preg_match('#^/notebooks(\\?\\$skip=(\\d+))?$#', $apimethod, $matches)) {
                    $skip = isset($matches[2]) ? (int) $matches[2] : 0;
                    $this->requests[] = $apimethod;
                    if ($this->listfails || $this->failatskip === $skip) {
                        return json_encode(['error' => 'Service unavailable']);
                    }

                    $items = [];
                    foreach ($this->account as $id => $title) {
                        $items[] = [
                            'id' => $id,
                            'displayName' => $title,
                            'links' => ['oneNoteWebUrl' => ['href' => 'https://onenote.example.com/' . $id]],
                            'createdBy' => 'Test',
                        ];
                    }

                    $response = [];
                    if ($this->pagesize > 0) {
                        $next = $skip + $this->pagesize;
                        if ($next < count($items)) {
                            $response['@odata.nextLink'] = 'https://graph.microsoft.com/v1.0/me/onenote/notebooks?$skip=' . $next;
                        }
                        $items = array_slice($items, $skip, $this->pagesize);
                    }
                    if ($this->nextlink !== null && $skip === 0) {
                        $response['@odata.nextLink'] = $this->nextlink;
                    }
                    if ($this->loops) {
                        $response['@odata.nextLink'] = 'https://graph.microsoft.com/v1.0/me/onenote/notebooks?$skip=2';
                    }
                    $response['value'] = $items;

                    return json_encode($response);
                }

                if ($apimethod === '/notebooks' && $httpmethod === 'post') {
                    $this->created++;
                    $id = 'created-' . $this->created;
                    $this->account[$id] = json_decode($params, true)['displayName'];
                    return json_encode(['id' => $id]);
                }

                if (preg_match('#^/notebooks/[^/]+/sections/$#', $apimethod) && $httpmethod === 'get') {
                    return json_encode(['value' => []]);
                }

                throw new \coding_exception('Unexpected call to OneNote: ' . $httpmethod . ' ' . $apimethod);
            }

            /**
             * Stub.
             *
             * @param string $url A full URL to get.
             * @param array $options Additional options for the request.
             * @return string Always an empty string.
             */
            public function geturl($url, $options = []) {
                return '';
            }

            /**
             * Stub.
             */
            public function get_token() {
                return null;
            }

            /**
             * Stub.
             */
            public function is_logged_in() {
                return true;
            }

            /**
             * Stub.
             */
            public function get_login_url() {
                return '';
            }

            /**
             * Stub.
             */
            public function log_out() {
            }

            /**
             * Stub.
             */
            public function render_signin_widget() {
                return '';
            }
        };
    }

    /**
     * The title of a new notebook is the default one unless a title is configured.
     */
    public function test_get_creation_title(): void {
        $this->assertSame('Moodle Notebook', notebook::get_creation_title());

        set_config('notebookname', '  Course notebook  ', 'local_onenote');
        $this->assertSame('Course notebook', notebook::get_creation_title());
    }

    /**
     * The candidate titles start with the configured title and include the default title, without duplicates.
     */
    public function test_get_candidate_titles(): void {
        $this->assertSame(['Moodle Notebook'], notebook::get_candidate_titles());

        set_config('notebookname', 'Course notebook', 'local_onenote');
        $this->assertSame(['Course notebook', 'Moodle Notebook'], notebook::get_candidate_titles());
    }

    /**
     * The stored notebook id can be stored, replaced and deleted.
     */
    public function test_store_id(): void {
        global $DB;

        $this->assertNull(notebook::get_stored_id($this->user->id));

        notebook::store_id($this->user->id, 'notebook-1');
        $this->assertSame('notebook-1', notebook::get_stored_id($this->user->id));

        notebook::store_id($this->user->id, 'notebook-2');
        $this->assertSame('notebook-2', notebook::get_stored_id($this->user->id));
        $this->assertEquals(1, $DB->count_records(notebook::TABLE, ['userid' => $this->user->id]));

        $otheruser = $this->getDataGenerator()->create_user();
        notebook::store_id($otheruser->id, 'notebook-3');
        notebook::delete_stored_id($this->user->id);
        $this->assertNull(notebook::get_stored_id($this->user->id));
        $this->assertSame('notebook-3', notebook::get_stored_id($otheruser->id));
    }

    /**
     * A notebook that is not stored yet is found by its title, and its id is stored.
     */
    public function test_resolve_finds_notebook_by_title(): void {
        $notebooks = [self::notebook('a', 'Personal notes'), self::notebook('b', 'Moodle Notebook')];

        $found = notebook::resolve($notebooks, $this->user->id);

        $this->assertSame('b', $found['id']);
        $this->assertSame('b', notebook::get_stored_id($this->user->id));
    }

    /**
     * The notebook is still found by its id after it is renamed.
     */
    public function test_resolve_finds_renamed_notebook_by_id(): void {
        notebook::store_id($this->user->id, 'b');
        $notebooks = [self::notebook('a', 'Moodle Notebook'), self::notebook('b', 'My renamed notebook')];

        $found = notebook::resolve($notebooks, $this->user->id);

        $this->assertSame('b', $found['id']);
        $this->assertSame('b', notebook::get_stored_id($this->user->id));
    }

    /**
     * A stored id that is no longer in the account, because the notebook was deleted, falls back to the title.
     */
    public function test_resolve_falls_back_to_title_when_stored_id_is_gone(): void {
        notebook::store_id($this->user->id, 'deleted');
        $notebooks = [self::notebook('c', 'Moodle Notebook')];

        $found = notebook::resolve($notebooks, $this->user->id);

        $this->assertSame('c', $found['id']);
        $this->assertSame('c', notebook::get_stored_id($this->user->id));
    }

    /**
     * Nothing is found, and the stored id is kept, when there is no notebook for Moodle.
     */
    public function test_resolve_returns_null_when_not_found(): void {
        notebook::store_id($this->user->id, 'deleted');

        $this->assertNull(notebook::resolve([self::notebook('a', 'Personal notes')], $this->user->id));
        $this->assertNull(notebook::resolve([], $this->user->id));
        $this->assertSame('deleted', notebook::get_stored_id($this->user->id));
    }

    /**
     * The notebook is created, and its id stored, when the user has no notebook for Moodle.
     */
    public function test_sync_creates_notebook(): void {
        $api = $this->create_api(['a' => 'Personal notes']);

        $this->assertNull($api->find_moodle_notebook());
        $this->assertIsArray($api->sync_notebook_data());

        $this->assertSame(1, $api->created);
        $this->assertSame('Moodle Notebook', $api->account['created-1']);
        $this->assertSame('created-1', notebook::get_stored_id($this->user->id));
        $this->assertSame('created-1', $api->find_moodle_notebook()['id']);
    }

    /**
     * The configured title is given to the new notebook.
     */
    public function test_sync_creates_notebook_with_configured_title(): void {
        set_config('notebookname', 'Course notebook', 'local_onenote');
        $api = $this->create_api();

        $api->sync_notebook_data();

        $this->assertSame('Course notebook', $api->account['created-1']);
    }

    /**
     * The notebook is not created again by later syncs, even if its title is changed in OneNote or in the configuration.
     */
    public function test_sync_does_not_duplicate_notebook_when_title_changes(): void {
        $api = $this->create_api();
        $api->sync_notebook_data();
        $this->assertSame(1, $api->created);

        // The user renames the notebook in OneNote.
        $api->account['created-1'] = 'My own title';
        $api->sync_notebook_data();

        // The administrator changes the title of new notebooks.
        set_config('notebookname', 'Another title', 'local_onenote');
        $api->sync_notebook_data();

        $this->assertSame(1, $api->created);
        $this->assertCount(1, $api->account);
        $this->assertSame('created-1', $api->find_moodle_notebook()['id']);
    }

    /**
     * A notebook created before the notebook id was stored is reused.
     */
    public function test_sync_reuses_legacy_notebook(): void {
        $api = $this->create_api(['a' => 'Personal notes', 'legacy' => 'Moodle Notebook']);

        $this->assertSame('legacy', $api->find_moodle_notebook()['id']);
        $this->assertIsArray($api->sync_notebook_data());

        $this->assertSame(0, $api->created);
        $this->assertSame('legacy', notebook::get_stored_id($this->user->id));
    }

    /**
     * A notebook is not created when the existing notebooks cannot be retrieved, as it may already exist.
     */
    public function test_sync_does_not_create_notebook_when_notebooks_cannot_be_retrieved(): void {
        $api = $this->create_api(['legacy' => 'Moodle Notebook']);
        $api->listfails = true;

        $this->assertFalse($api->sync_notebook_data());
        $this->assertNull($api->find_moodle_notebook());

        $this->assertSame(0, $api->created);
        $this->assertNull(notebook::get_stored_id($this->user->id));
    }

    /**
     * A new notebook replaces the stored one when the notebook was deleted in OneNote.
     */
    public function test_sync_recreates_deleted_notebook(): void {
        $api = $this->create_api();
        $api->sync_notebook_data();
        unset($api->account['created-1']);

        $api->sync_notebook_data();

        $this->assertSame(2, $api->created);
        $this->assertSame('created-2', notebook::get_stored_id($this->user->id));
    }

    /**
     * The notebook is found on a later page of notebooks, so it is not duplicated.
     */
    public function test_notebook_on_a_later_page_is_found(): void {
        $api = $this->create_api([
            'a' => 'Notes 1',
            'b' => 'Notes 2',
            'c' => 'Notes 3',
            'd' => 'Notes 4',
            'legacy' => 'Moodle Notebook',
        ]);
        $api->pagesize = 2;

        $this->assertSame('legacy', $api->find_moodle_notebook()['id']);

        // The id is stored, and the notebook is still found when it is renamed.
        $api->account['legacy'] = 'Renamed';
        $this->assertIsArray($api->sync_notebook_data());
        $this->assertSame(0, $api->created);
        $this->assertSame('legacy', notebook::get_stored_id($this->user->id));
        $this->assertCount(5, $api->account);
    }

    /**
     * A notebook is not created, and the stored id is kept, when a later page of notebooks cannot be retrieved.
     */
    public function test_sync_does_not_create_notebook_when_a_later_page_fails(): void {
        $api = $this->create_api(['a' => 'Notes 1', 'b' => 'Notes 2', 'c' => 'Moodle Notebook']);
        notebook::store_id($this->user->id, 'c');
        $api->pagesize = 2;
        $api->failatskip = 2;

        $this->assertFalse($api->sync_notebook_data());
        $this->assertNull($api->find_moodle_notebook());

        $this->assertSame(0, $api->created);
        $this->assertSame('c', notebook::get_stored_id($this->user->id));
    }

    /**
     * A link to a next page that is not a link to the notebooks is not followed.
     */
    public function test_sync_does_not_follow_unexpected_next_link(): void {
        foreach (
            [
                'https://graph.microsoft.com/v1.0/me/onenote/notebooks/a/sections?$skip=2',
                'https://graph.microsoft.com/v1.0/users',
                'not a link',
            ] as $link
        ) {
            $api = $this->create_api(['a' => 'Notes 1', 'b' => 'Notes 2']);
            $api->nextlink = $link;

            $this->assertFalse($api->sync_notebook_data(), $link);
            $this->assertSame(0, $api->created, $link);
        }
    }

    /**
     * Only the path and the query of the link to the next page are used, so a link to another host is not requested.
     */
    public function test_next_link_is_requested_from_the_api_only(): void {
        $api = $this->create_api(['a' => 'Notes 1', 'b' => 'Notes 2', 'c' => 'Moodle Notebook']);
        $api->pagesize = 2;

        $this->assertSame('c', $api->find_moodle_notebook()['id']);

        $api->nextlink = 'https://attacker.example.com/v1.0/me/onenote/notebooks?$skip=2';
        $api->requests = [];
        $this->assertSame('c', $api->find_moodle_notebook()['id']);
        $this->assertSame(['/notebooks', '/notebooks?$skip=2'], $api->requests);
    }

    /**
     * A response that keeps linking to the same next page does not make the lookup loop, or create a notebook.
     */
    public function test_sync_stops_when_next_link_repeats(): void {
        $api = $this->create_api(['a' => 'Notes 1', 'b' => 'Notes 2']);
        $api->loops = true;

        $this->assertFalse($api->sync_notebook_data());
        $this->assertSame(0, $api->created);
        $this->assertCount(2, $api->requests);
    }
}

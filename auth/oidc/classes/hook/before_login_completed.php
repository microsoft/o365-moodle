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

namespace auth_oidc\hook;

use auth_oidc\jwt;

/**
 * Allow plugins to perform additional checks before a user login is completed.
 *
 * This hook is dispatched by auth_oidc after authenticate_user_login() has
 * succeeded, but before complete_user_login() is called. The hook manager
 * does not catch exceptions raised by callbacks, so a callback can reject
 * the login by throwing an exception (e.g. \moodle_exception) - doing so
 * will propagate out of the hook dispatch and prevent complete_user_login()
 * from being called. There is no other signal (e.g. a flag on this hook) to
 * reject the login; a plain return from a callback allows the login to
 * proceed.
 *
 * @package    auth_oidc
 * @copyright  2026 Ariadne
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
#[\core\attribute\label('Allow plugins to perform additional checks before a user login is completed.')]
#[\core\attribute\tags('user', 'login')]
class before_login_completed {
    /**
     * Constructor for the hook.
     *
     * @param jwt $idtoken The id_token of the user attempting to log in.
     */
    public function __construct(
        /** @var jwt The id_token of the user attempting to log in */
        public readonly jwt $idtoken
    ) {
    }
}

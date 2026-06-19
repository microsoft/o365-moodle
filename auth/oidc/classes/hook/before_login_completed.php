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
 * Allow plugins to callback as soon possible after user has completed login.
 *
 * @package    auth_oidc
 * @copyright  2026 Ariadne
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
#[\core\attribute\label('Allow plugins to callback as soon possible after user has completed login.')]
#[\core\attribute\tags('user', 'login')]
class before_login_completed {
    /**
     * Constructor for the hook.
     */
    public function __construct(
        /** @var jwt The course instance */
        public readonly jwt $idtoken
    ) {
    }
}

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
 * Admin settings page that cannot be opened directly while it is hidden.
 *
 * @package    auth_oidc
 * @author     Lai Wei <lai.wei@enovation.ie>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright  (C) 2026 onwards Microsoft, Inc. (http://microsoft.com/)
 */

namespace auth_oidc\adminsetting;

/**
 * Settings page that is refused when opened through /admin/settings.php while it is hidden.
 *
 * A hidden admin_settingpage is only left out of the admin tree, tabs and search: Moodle still serves it by its URL. This
 * page also denies access in that case. Access is deliberately not denied anywhere else, because Moodle skips the settings
 * of pages that fail the access check when saving, and the settings of hidden pages still need to be listed and saved on
 * the new settings page after an installation or upgrade.
 */
class auth_oidc_admin_settingpage extends \admin_settingpage {
    /**
     * Check whether the current user can access the page.
     *
     * @return bool
     */
    public function check_access() {
        if ($this->is_hidden() && $this->is_opened_directly()) {
            return false;
        }

        return parent::check_access();
    }

    /**
     * Whether the current request opens this page by its section in the admin settings.
     *
     * @return bool
     */
    protected function is_opened_directly(): bool {
        global $SCRIPT;

        return $SCRIPT === '/admin/settings.php' && optional_param('section', '', PARAM_ALPHANUMEXT) === $this->name;
    }
}

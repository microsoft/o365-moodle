<?php
/**
 * A user account was created via OIDC.
 *
 * @package auth_oidc
 */

namespace auth_oidc\event;

defined('MOODLE_INTERNAL') || die();

/**
 * Event fired when a user account is created with OIDC.
 */
class user_account extends \core\event\base {
    /**
     * Return localised event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventaccountcreated', 'auth_oidc');
    }

    /**
     * Returns non-localised event description with id's for admin use only.
     *
     * @return string
     */
    public function get_description() {
        return json_encode($this->other);
    }

    /**
     * Init method.
     *
     * @return void
     */
    protected function init() {
        $this->context = \context_system::instance();
        $this->data['crud'] = 'r';
        $this->data['edulevel'] = self::LEVEL_OTHER;
        $this->data['objecttable'] = 'user';
    }
}

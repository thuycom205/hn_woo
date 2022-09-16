<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WOO_TRELLO_Data {
	private $params;

	/**
	 * WOO_TRELLO_Data constructor.
	 * Init setting
	 */
	public function __construct()
    {
        global $current_user;

        global $wlb_settings;
        if (!is_object($current_user)) {
            $this->params = [];
            return;
        }
        $user = $current_user->user_login;
        $param = 'woo_trello_params_' . $user;

        if (!$wlb_settings) {
            $wlb_settings = get_option($param, array());
        }
        $this->params = $wlb_settings;

    }

	/**
	 * Check show title
	 * @return mixed|void
	 */
	public function hide_title() {
		return apply_filters( 'wlb_hide_title', $this->params['hide_title'] );
	}

	/**
	 * Check show see more button
	 * @return mixed|void
	 */


	public function get_key() {
		//return apply_filters( 'wlb_get_key', $this->params['key'] );
	}


}

new WOO_TRELLO_Data();
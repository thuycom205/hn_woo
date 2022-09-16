<?php

/*
Class Name: WOO_LOOKBOOK_Admin_Settings
Author: Andy Ha (support@villatheme.com)
Author URI: http://villatheme.com
Copyright 2017 villatheme.com. All rights reserved.
*/
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WOO_TRELLO_Admin_Settings {
	static $params;
	static protected $instagram;
	protected $settings;

	public function __construct() {
		$this->settings = new WOO_TRELLO_Data();
		add_action( 'admin_init', array( $this, 'save_meta_boxes' ) );
	}

	/**
	 * HTML setting page
	 * @return array
	 */
	public static function page_callback() {
        $user = wp_get_current_user()->user_login;
        $param = 'woo_trello_params_'.$user;

		self::$params = get_option( $param, array() );
        $a=1;
		//self::$params = get_option( $param, array() );
		?>
        <div class='lmask'></div>
        <div class="wrap woocommerce-lookbook">
            <h2><?php esc_attr_e( 'Trello Integration Settings', 'woocommerce-lookbook' ) ?></h2>
            <form method="post" action="" class="vi-ui form">
				<?php echo ent2ncr( self::set_nonce() ) ?>

                <div class="vi-ui attached tabular menu">
                    <div class="item active" data-tab="design">
						<?php esc_html_e( 'Sync Option', 'woocommerce-lookbook' ) ?>
                    </div>

                    <div class="item" data-tab="update">
						<?php esc_html_e( 'Key Setting', 'woocommerce-lookbook' ) ?>
                    </div>
                </div>
                <!-- Design !-->
                <div class="vi-ui bottom attached tab segment active" data-tab="design">
                    <!-- Tab Content !-->
                    <h3><?php esc_html_e( 'Trello integration setting', 'woocommerce-lookbook' ) ?></h3>
                    <table class="optiontable form-table">
                        <tbody>

                        <tr valign="top">
                            <th scope="row">
                                <label for="<?php echo self::set_field( 'enable_trello_integration' ) ?>">
									<?php esc_html_e( 'Enable Trello Integration', 'woocommerce-lookbook' ) ?>
                                </label>
                            </th>
                            <td>
                                <div class="vi-ui toggle checkbox">
                                    <input id="<?php echo self::set_field( 'enable_trello_integration' ) ?>"
                                           type="checkbox" <?php checked( self::get_field( 'enable_trello_integration' ), 1 ) ?>
                                           tabindex="0" class="hidden" value="1"
                                           name="<?php echo self::set_field( 'enable_trello_integration' ) ?>"/>
                                    <label></label>
                                </div>
                                <p class="description"><?php esc_html_e( 'You can turn off synchronization from order to card on Trello by disable this ', 'woocommerce-lookbook' ) ?></p>
                            </td>
                        </tr>


                        </tbody>
                    </table>
                    <h3><?php esc_html_e( 'Card option', 'woocommerce-lookbook' ) ?></h3>
                    <table class="optiontable form-table">
                        <tbody>
                        <tr valign="top">
                            <th scope="row">
                                <label for="<?php echo self::set_field( 'add_date_to_card_title' ) ?>">
									<?php esc_html_e( 'Add order date to card title', 'woocommerce-lookbook' ) ?>
                                </label>
                            </th>
                            <td>
                                <div class="vi-ui toggle checkbox">
                                    <input id="<?php echo self::set_field( 'add_date_to_card_title' ) ?>"
                                           type="checkbox" <?php checked( self::get_field( 'add_date_to_card_title' ), 1 ) ?>
                                           tabindex="0" class="hidden" value="1"
                                           name="<?php echo self::set_field( 'add_date_to_card_title' ) ?>"/>
                                    <label></label>
                                </div>
                                <p class="description"><?php esc_html_e( 'Order date will be added to card title if you enable it', 'woocommerce-lookbook' ) ?></p>

                            </td>
                        </tr>


                        <!--field switcher for customer name -->
                        <tr valign="top">
                            <th scope="row">
                                <label for="<?php echo self::set_field( 'sync_customer_name' ) ?>">
                                    <?php esc_html_e( 'Add customer name to card description', 'woocommerce-trello' ) ?>
                                </label>
                            </th>
                            <td>
                                <div class="vi-ui toggle checkbox">
                                    <input id="<?php echo self::set_field( 'sync_customer_name' ) ?>"
                                           type="checkbox" <?php checked( self::get_field( 'sync_customer_name' ), 1 ) ?>
                                           tabindex="0" class="hidden" value="1"
                                           name="<?php echo self::set_field( 'sync_customer_name' ) ?>"/>
                                    <label></label>
                                </div>
                                <p class="description"><?php esc_html_e( 'Customer name of the order will show on card description if you enable this field', 'woocommerce-lookbook' ) ?></p>
                            </td>
                        </tr>
                        <!--end of field switcher for customer name-->
                        <!--field switcher for billing address -->
                        <tr valign="top">
                            <th scope="row">
                                <label for="<?php echo self::set_field( 'sync_billing_address' ) ?>">
                                    <?php esc_html_e( 'Add billing address to card description', 'woocommerce-trello' ) ?>
                                </label>
                            </th>
                            <td>
                                <div class="vi-ui toggle checkbox">
                                    <input id="<?php echo self::set_field( 'sync_billing_address' ) ?>"
                                           type="checkbox" <?php checked( self::get_field( 'sync_billing_address' ), 1 ) ?>
                                           tabindex="0" class="hidden" value="1"
                                           name="<?php echo self::set_field( 'sync_billing_address' ) ?>"/>
                                    <label></label>
                                </div>
                                <p class="description"><?php esc_html_e( 'Billing address of the order will show on card description if you enable this field', 'woocommerce-lookbook' ) ?></p>
                            </td>
                        </tr>
                        <!--end of field switcher for billing address -->
                        <!--field switcher for shipping address -->
                        <tr valign="top">
                            <th scope="row">
                                <label for="<?php echo self::set_field( 'sync_shipping_address' ) ?>">
                                    <?php esc_html_e( 'Add shipping address to card description', 'woocommerce-trello' ) ?>
                                </label>
                            </th>
                            <td>
                                <div class="vi-ui toggle checkbox">
                                    <input id="<?php echo self::set_field( 'sync_shipping_address' ) ?>"
                                           type="checkbox" <?php checked( self::get_field( 'sync_shipping_address' ), 1 ) ?>
                                           tabindex="0" class="hidden" value="1"
                                           name="<?php echo self::set_field( 'sync_shipping_address' ) ?>"/>
                                    <label></label>
                                </div>
                                <p class="description"><?php esc_html_e( 'Shipping address of the order will show on card description if you enable this field', 'woocommerce-lookbook' ) ?></p>
                            </td>
                        </tr>
                        <!--end of field switcher for shipping address -->
                     <!--field switcher for payment method address -->
                        <tr valign="top">
                            <th scope="row">
                                <label for="<?php echo self::set_field( 'sync_payment_method' ) ?>">
                                    <?php esc_html_e( 'Add payment method to card description', 'woocommerce-trello' ) ?>
                                </label>
                            </th>
                            <td>
                                <div class="vi-ui toggle checkbox">
                                    <input id="<?php echo self::set_field( 'sync_payment_method' ) ?>"
                                           type="checkbox" <?php checked( self::get_field( 'sync_payment_method' ), 1 ) ?>
                                           tabindex="0" class="hidden" value="1"
                                           name="<?php echo self::set_field( 'sync_payment_method' ) ?>"/>
                                    <label></label>
                                </div>
                                <p class="description"><?php esc_html_e( 'Payment method of the order will show on card description if you enable this field', 'woocommerce-lookbook' ) ?></p>
                            </td>
                        </tr>
                        <!--end of field switcher for payment method -->

                        <!--field switcher for total of the order -->
                        <tr valign="top">
                            <th scope="row">
                                <label for="<?php echo self::set_field( 'sync_order_total' ) ?>">
                                    <?php esc_html_e( 'Add  order total to card description', 'woocommerce-trello' ) ?>
                                </label>
                            </th>
                            <td>
                                <div class="vi-ui toggle checkbox">
                                    <input id="<?php echo self::set_field( 'sync_order_total') ?>"
                                           type="checkbox" <?php checked( self::get_field( 'sync_order_total' ), 1 ) ?>
                                           tabindex="0" class="hidden" value="1"
                                           name="<?php echo self::set_field( 'sync_order_total') ?>"/>
                                    <label></label>
                                </div>
                                <p class="description"><?php esc_html_e( 'Order total will show on card description if you enable this field', 'woocommerce-lookbook' ) ?></p>
                            </td>
                        </tr>
                        <!--end of field switcher for total of the order -->
                        <tr valign="top">
                            <th scope="row">
                                <label for="<?php echo self::set_field( 'color_label' ) ?>">
									<?php esc_html_e( 'Color Label', 'woocommerce-lookbook' ) ?>
                                </label>
                            </th>
                            <td>
                                <select name="<?php echo self::set_field( 'color_label' ) ?>"
                                        class="vi-ui fluid dropdown">
                                    <option <?php selected( self::get_field( 'color_label' ), "yellow" ) ?>
                                            value="yellow"><?php esc_attr_e( 'Yellow', 'woocommerce-lookbook' ) ?></option>
                                    <option <?php selected( self::get_field( 'color_label' ), "purple" ) ?>
                                            value="purple"><?php esc_attr_e( 'Purple', 'woocommerce-lookbook' ) ?></option>
                                    <option <?php selected( self::get_field( 'color_label' ), "blue" ) ?>
                                            value="blue"><?php esc_attr_e( 'Blue', 'woocommerce-lookbook' ) ?></option>
                                    <option <?php selected( self::get_field( 'color_label' ), "red" ) ?>
                                            value="red"><?php esc_attr_e( 'Red', 'woocommerce-lookbook' ) ?></option>
                                    <option <?php selected( self::get_field( 'color_label' ), "green" ) ?>
                                            value="green"><?php esc_attr_e( 'Green', 'woocommerce-lookbook' ) ?></option>
                                    <option <?php selected( self::get_field( 'color_label' ), "orange" ) ?>
                                            value="orange"><?php esc_attr_e( 'Orange', 'woocommerce-lookbook' ) ?>
                                    </option>
                                    <option <?php selected( self::get_field( 'color_label' ), "black" ) ?>
                                            value="black"><?php esc_attr_e( 'Black', 'woocommerce-lookbook' ) ?></option>
                                    <option <?php selected( self::get_field( 'color_label' ), "sky") ?>
                                            value="sky"><?php esc_attr_e( 'Sky', 'woocommerce-lookbook' ) ?></option>
                                    <option <?php selected( self::get_field( 'color_label' ), "pink" ) ?>
                                            value="pink"><?php esc_attr_e( 'Pink', 'woocommerce-lookbook' ) ?></option>
                                    <option <?php selected( self::get_field( 'color_label' ), 'lime' ) ?>
                                            value="lime"><?php esc_attr_e( 'Lime', 'woocommerce-lookbook' ) ?></option>
                                </select>
                            </td>
                        </tr>

                        </tbody>
                    </table>


                </div>
                <!-- Update !-->
                <div class="vi-ui bottom attached tab segment" data-tab="update">
                    <!-- Tab Content !-->
                    <table class="optiontable form-table">
                        <tbody>

                        <tr valign="top">
                            <th scope="row">
                                <label for="auto-update-key"><?php esc_html_e( 'Auto Update Key', 'woocommerce-lookbook' ) ?></label>
                            </th>
                            <td>
                                <div class="fields">
                                    <div class="ten wide field">
                                        <input type="text" name="<?php echo self::set_field( 'key' ) ?>"
                                               id="trello-key"
                                               class="villatheme-autoupdate-key-field"
                                               value="<?php echo self::get_field( 'key' ) ?>">
                                    </div>
                                    <div class="six wide field">
                                        <span class="vi-ui button green villatheme-get-key-button"
                                              data-href="https://trello.com/1/authorize?expiration=never&name=Trello+Integration&scope=read%2Cwrite&response_type=token&key=fc37781b415ba6e22400ce1be85d4a1d
"
                                              data-id="21233957"><?php echo esc_html__( 'Get Key', 'woocommerce-lookbook' ) ?></span>
                                    </div>
                                </div>
                                <div>
                                    <div onclick="mas_connect_trello(this)"><span>Connect Trello</span></div>
                                </div>
                                <div>
                                    <div id="mastrello_admin_url" data-adminurl="<?php echo admin_url( 'admin-ajax.php' ) ?>"></div>
                                    <div id="mastrello_admin_url_user_id" data-userid="<?php ?>"></div>
                                </div>


                                <p class="description"><?php echo __( 'Please fill your key what you get from Trello</a>.  See guide <a target="_blank" href="https://thexseed.com/knowledge-base/how-to-use-trello-connector/">here</a>', 'woocommerce-lookbook' ) ?></p>
                            </td>
                        </tr>

                        <!--Board-->
                        <tr valign="top">
                            <th scope="row">
                                <label for="<?php echo self::set_field( 'trello_card' ) ?>">
                                    <?php esc_html_e( 'Board', 'woocommerce-lookbook' ) ?>
                                </label>
                            </th>
                            <td>
                                <select id="trello_card" name="<?php echo self::set_field( 'trello_card' ) ?>"
                                       >
                                </select>
                                <p class="description"><?php echo __( 'specify the board which the cards will be created in', 'woocommerce-lookbook' ) ?></p>

                            </td>
                        </tr>
                        <!--End Board-->
                        <!--List-->
                        <tr valign="top">
                            <th scope="row">
                                <label for="<?php echo self::set_field( 'trello_list' ) ?>">
                                    <?php esc_html_e( 'List', 'woocommerce-lookbook' ) ?>
                                </label>
                            </th>
                            <td>
                                <select id="trello_list" name="<?php echo self::set_field( 'trello_list' ) ?>">
                                </select>
                                <p class="description"><?php echo __( 'specify the list which the cards will be created in', 'woocommerce-lookbook' ) ?></p>

                            </td>
                        </tr>
                        <!--End List-->



                        </tbody>
                    </table>
                </div>
                <div id="trello_card_init" data-value="<?php if (isset(self::$params['trello_card'])) { echo self::$params['trello_card']; } ?>"> </div>
                <div id="trello_list_init" data-value="<?php if (isset(self::$params['trello_list'])) {  echo self::$params['trello_list']; } ?>"> </div>
                <p>
                    <button class="vi-ui button labeled icon primary wlb-submit">
                        <i class="send icon"></i> <?php esc_html_e( 'Save', 'woocommerce-lookbook' ) ?>
                    </button>

                </p>
            </form>
        </div>

		<?php
		//do_action( 'mas_support_woocommerce-lookbook' );
	}

	/**
	 * Set Nonce
	 * @return string
	 */
	protected static function set_nonce() {
		return wp_nonce_field( 'woo_lookbook_settings', '_woo_lookbook_nonce' );
	}

	/**
	 * Set field in meta box
	 *
	 * @param      $field
	 * @param bool $multi
	 *
	 * @return string
	 */
	protected static function set_field( $field, $multi = false ) {
		if ( $field ) {
			if ( $multi ) {
				return 'woo_trello_params[' . $field . '][]';
			} else {
				return 'woo_trello_params[' . $field . ']';
			}
		} else {
			return '';
		}
	}

	/**
	 * Get Post Meta
	 *
	 * @param $field
	 *
	 * @return bool
	 */
	public static function get_field( $field, $default = '' ) {
		//global $wlb_settings;
		$params = [];

		if ( self::$params ) {
			$params = self::$params;
		} else {
			self::$params = $params;
		}
		if ( isset( $params[ $field ] ) && $field ) {
			return $params[ $field ];
		} else {
			return $default;
		}

	}

	public function close_iframe() {
		/*Update access token*/
		if ( isset( $_GET['code'] ) && isset( $_GET['page'] ) && $_GET['code'] && $_GET['page'] == 'woocommerce-lookbook-settings' ) {
			$params = array(
				'client_id'     => self::get_field( 'ins_client_id', '' ),
				'client_secret' => self::get_field( 'ins_client_secret', '' ),
				'grant_type'    => 'authorization_code',
				'redirect_uri'  => admin_url( 'edit.php?post_type=woocommerce-lookbook&page=woocommerce-lookbook-settings' ),
				'code'          => $_GET['code']
			);
			$ch     = curl_init( 'https://api.instagram.com/oauth/access_token' );
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
			curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, 'POST' );
			curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
			curl_setopt( $ch, CURLOPT_POSTFIELDS, $params );
			$result = curl_exec( $ch );
			$data   = json_decode( $result, true );
			if ( isset( $data['access_token'] ) && $data['access_token'] ) {
				$options               = get_option( 'woo_lookbook_params' );
				$options['fb_user_id'] = $data['access_token'];
				update_option( 'woo_trello_params', $options );

			} else {
				esc_html_e( 'Please save Settings and get access token again.', 'woocommerce-lookbook' );
				die;
			}
			?>
            <script type="text/javascript">
                window.close();
            </script>
			<?php
		}

	}

	public function save_meta_boxes() {
		$setting_url = admin_url( 'edit.php?post_type=woocommerce-lookbook&page=woocommerce-lookbook-settings' );
		$key         = $this->settings->get_key();

		global $pagenow;
		//if ( $pagenow === 'edit.php' && isset( $_REQUEST['post_type'], $_REQUEST['page'] ) && $_REQUEST['post_type'] === 'woocommerce-trello' && $_REQUEST['page'] === 'trello-integration-settings' ) {
		if (true ) {


			if ( ! isset( $_POST['_woo_lookbook_nonce'] ) || ! isset( $_POST['woo_trello_params'] ) ) {
				return;
			}
			if ( ! wp_verify_nonce( $_POST['_woo_lookbook_nonce'], 'woo_lookbook_settings' ) ) {
				return;
			}
			if ( ! current_user_can( 'edit_posts' ) ) {
				return;
			}
			$data = wc_clean( $_POST['woo_trello_params'] );

//			if ( empty( $data['ins_access_token'] ) ) {
//				delete_transient( 'wlb_ins_access_token' );
//			} else {
//				set_transient( 'wlb_ins_access_token', $data['ins_access_token'], 7775000 );
//			}

			delete_transient( 'wlb_instagram_data' );
			delete_transient( 'wlb_auto_sync_instagram' );

			if ( isset( $data['check_key'] ) ) {
				unset( $data['check_key'] );
				delete_transient( '_site_transient_update_plugins' );
				delete_transient( 'villatheme_item_12172' );
				delete_option( 'woocommerce-lookbook_messages' );

			}
            $user = wp_get_current_user()->user_login;
            $param = 'woo_trello_params_'.$user;
			update_option( $param, $data );
		}

	}

	/**
	 * @param $value
	 *
	 * @return array|string
	 */
	private function stripslashes_deep( $value ) {
		$value = is_array( $value ) ? array_map( 'stripslashes_deep', $value ) : stripslashes( $value );

		return $value;
	}
} ?>
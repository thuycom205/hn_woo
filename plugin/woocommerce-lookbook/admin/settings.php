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

class WOO_LOOKBOOK_Admin_Settings {
	static $params;
	static protected $instagram;
	protected $settings;

	public function __construct() {
		$this->settings = new WOO_LOOKBOOK_Data();
		add_action( 'admin_init', array( $this, 'save_meta_boxes' ) );
	}

	/**
	 * HTML setting page
	 * @return array
	 */
	public static function page_callback() {
        $user = wp_get_current_user()->user_login;
        $param = 'woo_lookbook_params'.$user;
		self::$params = get_option( 'woo_lookbook_params', array() );
		//self::$params = get_option( $param, array() );
		?>
        <div class="wrap woocommerce-lookbook">
            <h2><?php esc_attr_e( 'WooCommerce Lookbook Settings', 'woocommerce-lookbook' ) ?></h2>
            <form method="post" action="" class="vi-ui form">
				<?php echo ent2ncr( self::set_nonce() ) ?>

                <div class="vi-ui attached tabular menu">
                    <div class="item active" data-tab="design">
						<?php esc_html_e( 'Design', 'woocommerce-lookbook' ) ?>
                    </div>
                    <div class="item " data-tab="product">
						<?php esc_html_e( 'Product', 'woocommerce-lookbook' ) ?>
                    </div>
                    <div class="item " data-tab="instagram">
						<?php esc_html_e( 'Instagram', 'woocommerce-lookbook' ) ?>
                    </div>
                    <div class="item" data-tab="update">
						<?php esc_html_e( 'Update', 'woocommerce-lookbook' ) ?>
                    </div>
                </div>
                <!-- Design !-->
                <div class="vi-ui bottom attached tab segment active" data-tab="design">
                    <!-- Tab Content !-->
                    <h3><?php esc_html_e( 'Node Options', 'woocommerce-lookbook' ) ?></h3>
                    <table class="optiontable form-table">
                        <tbody>
                        <tr valign="top">
                            <th scope="row">
                                <label for="<?php echo self::set_field( 'icon' ) ?>">
									<?php esc_html_e( 'Icon', 'woocommerce-lookbook' ) ?>
                                </label>
                            </th>
                            <td>
                                <select name="<?php echo self::set_field( 'icon' ) ?>" class="vi-ui fluid dropdown">
                                    <option <?php selected( self::get_field( 'icon' ), 0 ) ?>
                                            value="0"><?php esc_attr_e( 'Default', 'woocommerce-lookbook' ) ?></option>
                                    <option <?php selected( self::get_field( 'icon' ), 1 ) ?>
                                            value="1"><?php esc_attr_e( 'Number', 'woocommerce-lookbook' ) ?></option>
                                    <option <?php selected( self::get_field( 'icon' ), 2 ) ?>
                                            value="2"><?php esc_attr_e( 'Marker', 'woocommerce-lookbook' ) ?></option>
                                    <option <?php selected( self::get_field( 'icon' ), 3 ) ?>
                                            value="3"><?php esc_attr_e( 'Alphabet', 'woocommerce-lookbook' ) ?></option>
                                    <option <?php selected( self::get_field( 'icon' ), 4 ) ?>
                                            value="4"><?php esc_attr_e( 'Price', 'woocommerce-lookbook' ) ?></option>
                                </select>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                <label><?php esc_html_e( 'Color', 'woocommerce-lookbook' ) ?></label>
                            </th>
                            <td>
                                <input type="text" class="color-picker"
                                       name="<?php echo self::set_field( 'icon_color' ) ?>"
                                       value="<?php echo self::get_field( 'icon_color', '#fff' ) ?>"
                                       style="background-color: <?php echo esc_attr( self::get_field( 'icon_color', '#fff' ) ) ?>"/>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                <label><?php esc_html_e( 'Background color', 'woocommerce-lookbook' ) ?></label>
                            </th>
                            <td>
                                <input type="text" class="color-picker"
                                       name="<?php echo self::set_field( 'icon_background_color' ) ?>"
                                       value="<?php echo self::get_field( 'icon_background_color', '#E8CE40' ) ?>"
                                       style="background-color: <?php echo esc_attr( self::get_field( 'icon_background_color', '#E8CE40' ) ) ?>"/>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                <label><?php esc_html_e( 'Border color', 'woocommerce-lookbook' ) ?></label>
                            </th>
                            <td>
                                <input type="text" class="color-picker"
                                       name="<?php echo self::set_field( 'icon_border_color' ) ?>"
                                       value="<?php echo self::get_field( 'icon_border_color', '#E8CE40' ) ?>"
                                       style="background-color: <?php echo esc_attr( self::get_field( 'icon_border_color', '#E8CE40' ) ) ?>"/>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                <label for="<?php echo self::set_field( 'hide_title' ) ?>">
									<?php esc_html_e( 'Hide Title', 'woocommerce-lookbook' ) ?>
                                </label>
                            </th>
                            <td>
                                <div class="vi-ui toggle checkbox">
                                    <input id="<?php echo self::set_field( 'hide_title' ) ?>"
                                           type="checkbox" <?php checked( self::get_field( 'hide_title' ), 1 ) ?>
                                           tabindex="0" class="hidden" value="1"
                                           name="<?php echo self::set_field( 'hide_title' ) ?>"/>
                                    <label></label>
                                </div>
                                <p class="description"></p>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                <label><?php esc_html_e( 'Title Color', 'woocommerce-lookbook' ) ?></label>
                            </th>
                            <td>
                                <input type="text" class="color-picker"
                                       name="<?php echo self::set_field( 'title_color' ) ?>"
                                       value="<?php echo self::get_field( 'title_color', '#212121' ) ?>"
                                       style="background-color: <?php echo esc_attr( self::get_field( 'title_color', '#212121' ) ) ?>"/>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                <label><?php esc_html_e( 'Title Background Color', 'woocommerce-lookbook' ) ?></label>
                            </th>
                            <td>
                                <input type="text" class="color-picker"
                                       name="<?php echo self::set_field( 'title_background_color' ) ?>"
                                       value="<?php echo self::get_field( 'title_background_color', '#eee' ) ?>"
                                       style="background-color: <?php echo esc_attr( self::get_field( 'title_background_color', '#212121' ) ) ?>"/>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <h3><?php esc_html_e( 'Quick view', 'woocommerce-lookbook' ) ?></h3>
                    <table class="optiontable form-table">
                        <tbody>
                        <tr valign="top">
                            <th scope="row">
                                <label for="<?php echo self::set_field( 'modal_style' ) ?>">
									<?php esc_html_e( 'Modal style', 'woocommerce-lookbook' ) ?>
                                </label>
                            </th>
                            <td>
                                <select name="<?php echo self::set_field( 'modal_style' ) ?>"
                                        class="vi-ui fluid dropdown">
                                    <option <?php selected( self::get_field( 'modal_style' ), 0 ) ?>
                                            value="0"><?php esc_attr_e( 'Box', 'woocommerce-lookbook' ) ?></option>
                                    <option <?php selected( self::get_field( 'modal_style' ), 1 ) ?>
                                            value="1"><?php esc_attr_e( 'Full width', 'woocommerce-lookbook' ) ?></option>
                                </select>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                <label for="<?php echo self::set_field( 'loading_icon' ) ?>">
									<?php esc_html_e( 'Loading Icon', 'woocommerce-lookbook' ) ?>
                                </label>
                            </th>
                            <td>
                                <select name="<?php echo self::set_field( 'loading_icon' ) ?>"
                                        class="vi-ui fluid dropdown">
                                    <option <?php selected( self::get_field( 'loading_icon' ), 0 ) ?>
                                            value="0"><?php esc_attr_e( 'Default', 'woocommerce-lookbook' ) ?></option>
                                    <option <?php selected( self::get_field( 'loading_icon' ), 1 ) ?>
                                            value="1"><?php esc_attr_e( 'Double Bounce', 'woocommerce-lookbook' ) ?></option>
                                    <option <?php selected( self::get_field( 'loading_icon' ), 2 ) ?>
                                            value="2"><?php esc_attr_e( 'Wave', 'woocommerce-lookbook' ) ?></option>
                                    <option <?php selected( self::get_field( 'loading_icon' ), 3 ) ?>
                                            value="3"><?php esc_attr_e( 'Wandering Cubes', 'woocommerce-lookbook' ) ?></option>
                                    <option <?php selected( self::get_field( 'loading_icon' ), 4 ) ?>
                                            value="4"><?php esc_attr_e( 'Pulse', 'woocommerce-lookbook' ) ?></option>
                                    <option <?php selected( self::get_field( 'loading_icon' ), 5 ) ?>
                                            value="5"><?php esc_attr_e( 'Chasing dots', 'woocommerce-lookbook' ) ?></option>
                                    <option <?php selected( self::get_field( 'loading_icon' ), 6 ) ?>
                                            value="6"><?php esc_attr_e( 'Three Bounce', 'woocommerce-lookbook' ) ?></option>
                                    <option <?php selected( self::get_field( 'loading_icon' ), 7 ) ?>
                                            value="7"><?php esc_attr_e( 'Circle', 'woocommerce-lookbook' ) ?></option>
                                    <option <?php selected( self::get_field( 'loading_icon' ), 8 ) ?>
                                            value="8"><?php esc_attr_e( 'Cube grid', 'woocommerce-lookbook' ) ?></option>
                                    <option <?php selected( self::get_field( 'loading_icon' ), 9 ) ?>
                                            value="9"><?php esc_attr_e( 'Fading Circle', 'woocommerce-lookbook' ) ?></option>
                                    <option <?php selected( self::get_field( 'loading_icon' ), 10 ) ?>
                                            value="10"><?php esc_attr_e( 'Folding cube', 'woocommerce-lookbook' ) ?></option>
                                </select>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                <label><?php esc_html_e( 'Text Color', 'woocommerce-lookbook' ) ?></label>
                            </th>
                            <td>
                                <input type="text" class="color-picker"
                                       name="<?php echo self::set_field( 'text_color' ) ?>"
                                       value="<?php echo self::get_field( 'text_color', '#E8CE40' ) ?>"
                                       style="background-color: <?php echo esc_attr( self::get_field( 'text_color', '#E8CE40' ) ) ?>"/>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                <label><?php esc_html_e( 'Background Color', 'woocommerce-lookbook' ) ?></label>
                            </th>
                            <td>
                                <input type="text" class="color-picker"
                                       name="<?php echo self::set_field( 'background_color' ) ?>"
                                       value="<?php echo self::get_field( 'background_color', '#fff' ) ?>"
                                       style="background-color: <?php echo esc_attr( self::get_field( 'background_color', '#fff' ) ) ?>"/>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                <label><?php esc_html_e( 'Border radius', 'woocommerce-lookbook' ) ?></label>
                            </th>
                            <td>
                                <div class="vi-ui form">
                                    <div class="inline fields">
                                        <input type="number" name="<?php echo self::set_field( 'border_radius' ) ?>"
                                               value="<?php echo self::get_field( 'border_radius', 0 ) ?>"/>
                                        <label><?php esc_html_e( 'px', 'woocommerce-lookbook' ) ?></label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                <label for="<?php echo self::set_field( 'close_button' ) ?>">
									<?php esc_html_e( 'Hide Close Button', 'woocommerce-lookbook' ) ?>
                                </label>
                            </th>
                            <td>
                                <div class="vi-ui toggle checkbox">
                                    <input id="<?php echo self::set_field( 'close_button' ) ?>"
                                           type="checkbox" <?php checked( self::get_field( 'close_button' ), 1 ) ?>
                                           tabindex="0" class="hidden" value="1"
                                           name="<?php echo self::set_field( 'close_button' ) ?>"/>
                                    <label></label>
                                </div>
                                <p class="description"></p>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                <label for="<?php echo self::set_field( 'see_more' ) ?>">
									<?php esc_html_e( 'Hide See More Button', 'woocommerce-lookbook' ) ?>
                                </label>
                            </th>
                            <td>
                                <div class="vi-ui toggle checkbox">
                                    <input id="<?php echo self::set_field( 'see_more' ) ?>"
                                           type="checkbox" <?php checked( self::get_field( 'see_more' ), 1 ) ?>
                                           tabindex="0" class="hidden" value="1"
                                           name="<?php echo self::set_field( 'see_more' ) ?>"/>
                                    <label></label>
                                </div>
                                <p class="description"></p>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                <label for="<?php echo self::set_field( 'add_to_cart' ) ?>">
									<?php esc_html_e( 'Add to cart', 'woocommerce-lookbook' ) ?>
                                </label>
                            </th>
                            <td>
                                <select name="<?php echo self::set_field( 'add_to_cart' ) ?>"
                                        class="vi-ui fluid dropdown">
                                    <option <?php selected( self::get_field( 'add_to_cart' ), 0 ) ?>
                                            value="0"><?php esc_attr_e( 'Default', 'woocommerce-lookbook' ) ?></option>
                                    <option <?php selected( self::get_field( 'add_to_cart' ), 1 ) ?>
                                            value="1"><?php esc_attr_e( 'Cart page', 'woocommerce-lookbook' ) ?></option>
                                    <option <?php selected( self::get_field( 'add_to_cart' ), 2 ) ?>
                                            value="2"><?php esc_attr_e( 'Checkout page', 'woocommerce-lookbook' ) ?></option>
                                </select>
                                <p class="description"><?php esc_html_e( 'When add to cart on quick view, Customer will redirect to cart or checkout page', 'woocommerce-lookbook' ) ?></p>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                <label for="<?php echo self::set_field( 'nav_pos' ) ?>">
									<?php esc_html_e( 'Navigation position', 'woocommerce-lookbook' ) ?>
                                </label>
                            </th>
                            <td>
                                <select name="<?php echo self::set_field( 'nav_pos' ) ?>"
                                        class="vi-ui fluid dropdown wlb-nav-pos">
                                    <option <?php selected( self::get_field( 'nav_pos' ), 0 ) ?>
                                            value="0"><?php esc_attr_e( 'Default', 'woocommerce-lookbook' ) ?></option>
                                    <option <?php selected( self::get_field( 'nav_pos' ), 'top' ) ?>
                                            value="top"><?php esc_attr_e( 'Top', 'woocommerce-lookbook' ) ?></option>
                                    <option <?php selected( self::get_field( 'nav_pos' ), 'bottom' ) ?>
                                            value="bottom"><?php esc_attr_e( 'Bottom', 'woocommerce-lookbook' ) ?></option>
                                </select>
                                <!--                                <p class="description">-->
								<?php //esc_html_e( 'When add to cart on quick view, Customer will redirect to cart or checkout page', 'woocommerce-lookbook' ) ?><!--</p>-->
                            </td>
                        </tr>
                        <tr valign="top" class="wlb-alignment" style="<?php if ( self::get_field( 'nav_pos' ) == '0' ) {
							echo 'display:none;';
						} ?>">
                            <th scope="row">
                                <label for="<?php echo self::set_field( 'nav_align' ) ?>">
									<?php esc_html_e( 'Navigation alignment', 'woocommerce-lookbook' ) ?>
                                </label>
                            </th>
                            <td>
                                <select name="<?php echo self::set_field( 'nav_align' ) ?>"
                                        class="vi-ui fluid dropdown">
                                    <option <?php selected( self::get_field( 'nav_align' ), 'left' ) ?>
                                            value="left"><?php esc_attr_e( 'Left', 'woocommerce-lookbook' ) ?></option>
                                    <option <?php selected( self::get_field( 'nav_align' ), 'center' ) ?>
                                            value="center"><?php esc_attr_e( 'Center', 'woocommerce-lookbook' ) ?></option>
                                    <option <?php selected( self::get_field( 'nav_align' ), 'right' ) ?>
                                            value="right"><?php esc_attr_e( 'Right', 'woocommerce-lookbook' ) ?></option>
                                </select>
                                <!--                                <p class="description">-->
								<?php //esc_html_e( 'When add to cart on quick view, Customer will redirect to cart or checkout page', 'woocommerce-lookbook' ) ?><!--</p>-->
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                <label for="<?php echo self::set_field( 'nav_icon' ) ?>">
									<?php esc_html_e( 'Navigation icon', 'woocommerce-lookbook' ) ?>
                                </label>
                            </th>
                            <td>
								<?php
								for ( $i = 0; $i <= 2; $i ++ ) {
									$name    = self::set_field( 'nav_icon' );
									$checked = self::get_field( 'nav_icon' ) == $i ? "checked='checked'" : '';
									$html    = "<div class='wlb-nav-icon-option'>";
									$html    .= "<input type='radio' name='{$name}' {$checked} value='{$i}'>";
									$html    .= " <span class='wlb-nav-icon arrow-left-{$i}'></span>";
									$html    .= " <span class='wlb-nav-icon arrow-right-{$i}'></span>";
									$html    .= " <span class='wlb-nav-icon close-{$i}'></span>";
									$html    .= "</div>";
									echo $html;
								}
								?>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <h3><?php esc_html_e( 'Slide Options', 'woocommerce-lookbook' ) ?></h3>
                    <table class="optiontable form-table">
                        <tbody>
                        <tr valign="top">
                            <th scope="row">
                                <label><?php esc_html_e( 'Width', 'woocommerce-lookbook' ) ?></label>
                            </th>
                            <td>
                                <div class="vi-ui form">
                                    <div class="inline fields">
                                        <input type="number" name="<?php echo self::set_field( 'slide_width' ) ?>"
                                               value="<?php echo self::get_field( 'slide_width', 1170 ) ?>"/>
                                        <label><?php esc_html_e( 'px', 'woocommerce-lookbook' ) ?></label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                <label><?php esc_html_e( 'Height', 'woocommerce-lookbook' ) ?></label>
                            </th>
                            <td>
                                <div class="vi-ui form">
                                    <div class="inline fields">
                                        <input type="number" name="<?php echo self::set_field( 'slide_height' ) ?>"
                                               value="<?php echo self::get_field( 'slide_height', 600 ) ?>"/>
                                        <label><?php esc_html_e( 'px', 'woocommerce-lookbook' ) ?></label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                <label><?php esc_html_e( 'Number items per row', 'woocommerce-lookbook' ) ?></label>
                            </th>
                            <td>
                                <div class="vi-ui form">
                                    <div class="inline fields">
                                        <input type="number" name="<?php echo self::set_field( 'slide_cols' ) ?>"
                                               value="<?php echo self::get_field( 'slide_cols', 3 ) ?>"
                                               min="1" max="5"/>

                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                <label for="<?php echo self::set_field( 'slide_effect' ) ?>">
									<?php esc_html_e( 'Effect', 'woocommerce-lookbook' ) ?>
                                </label>
                            </th>
                            <td>
                                <select name="<?php echo self::set_field( 'slide_effect' ) ?>"
                                        class="vi-ui fluid dropdown">
                                    <option <?php selected( self::get_field( 'slide_effect' ), 0 ) ?>
                                            value="0"><?php esc_attr_e( 'Slide', 'woocommerce-lookbook' ) ?></option>
                                    <option <?php selected( self::get_field( 'slide_effect' ), 1 ) ?>
                                            value="1"><?php esc_attr_e( 'Fade', 'woocommerce-lookbook' ) ?></option>
                                </select>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                <label for="<?php echo self::set_field( 'slide_pagination' ) ?>">
									<?php esc_html_e( 'Slide Pagination', 'woocommerce-lookbook' ) ?>
                                </label>
                            </th>
                            <td>
                                <div class="vi-ui toggle checkbox">
                                    <input id="<?php echo self::set_field( 'slide_pagination' ) ?>"
                                           type="checkbox" <?php checked( self::get_field( 'slide_pagination' ), 1 ) ?>
                                           tabindex="0" class="hidden" value="1"
                                           name="<?php echo self::set_field( 'slide_pagination' ) ?>"/>
                                    <label></label>
                                </div>
                                <p class="description"></p>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                <label for="<?php echo self::set_field( 'slide_navigation' ) ?>">
									<?php esc_html_e( 'Slide Navigation', 'woocommerce-lookbook' ) ?>
                                </label>
                            </th>
                            <td>
                                <div class="vi-ui toggle checkbox">
                                    <input id="<?php echo self::set_field( 'slide_navigation' ) ?>"
                                           type="checkbox" <?php checked( self::get_field( 'slide_navigation' ), 1 ) ?>
                                           tabindex="0" class="hidden" value="1"
                                           name="<?php echo self::set_field( 'slide_navigation' ) ?>"/>
                                    <label></label>
                                </div>
                                <p class="description"></p>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                <label for="<?php echo self::set_field( 'slide_auto_play' ) ?>">
									<?php esc_html_e( 'Auto play', 'woocommerce-lookbook' ) ?>
                                </label>
                            </th>
                            <td>
                                <div class="vi-ui toggle checkbox">
                                    <input id="<?php echo self::set_field( 'slide_auto_play' ) ?>"
                                           type="checkbox" <?php checked( self::get_field( 'slide_auto_play' ), 1 ) ?>
                                           tabindex="0" class="hidden" value="1"
                                           name="<?php echo self::set_field( 'slide_auto_play' ) ?>"/>
                                    <label></label>
                                </div>
                                <p class="description"></p>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                <label><?php esc_html_e( 'Duration', 'woocommerce-lookbook' ) ?></label>
                            </th>
                            <td>
                                <div class="vi-ui form">
                                    <div class="inline fields">
                                        <input type="number" name="<?php echo self::set_field( 'slide_time' ) ?>"
                                               value="<?php echo self::get_field( 'slide_time', 5000 ) ?>"/>
                                        <label><?php esc_html_e( 'milliseconds', 'woocommerce-lookbook' ) ?></label>
                                    </div>
                                </div>
                                <p class="description"><?php esc_html_e( 'Specify a time to advance to the next lookbook.', 'woocommerce-lookbook' ) ?></p>
                            </td>
                        </tr>
                        </tbody>
                    </table>

                    <h3><?php esc_html_e( 'Gallery Options', 'woocommerce-lookbook' ) ?></h3>
                    <table class="optiontable form-table">
                        <tbody>
                        <tr valign="top">
                            <th scope="row">
                                <label><?php esc_html_e( 'Number items per row', 'woocommerce-lookbook' ) ?></label>
                            </th>
                            <td>
                                <div class="vi-ui form">
                                    <div class="inline fields">
                                        <input type="number" name="<?php echo self::set_field( 'gallery_cols' ) ?>"
                                               value="<?php echo self::get_field( 'gallery_cols', 3 ) ?>"
                                               min="1" max="5"/>
                                        <label><?php esc_html_e( 'items', 'woocommerce-lookbook' ) ?></label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                <label for="<?php echo self::set_field( 'slide_navigation' ) ?>">
									<?php esc_html_e( 'Change to slide on mobile', 'woocommerce-lookbook' ) ?>
                                </label>
                            </th>
                            <td>
                                <div class="vi-ui toggle checkbox">
                                    <input id="<?php echo self::set_field( 'gallery_to_slide' ) ?>"
                                           type="checkbox" <?php checked( self::get_field( 'gallery_to_slide' ), 1 ) ?>
                                           tabindex="0" class="hidden" value="1"
                                           name="<?php echo self::set_field( 'gallery_to_slide' ) ?>"/>
                                    <label></label>
                                </div>
                                <p class="description"></p>
                            </td>
                        </tr>
                        </tbody>
                    </table>

                    <h3><?php esc_html_e( 'Custom Script', 'woocommerce-lookbook' ) ?></h3>
                    <table class="optiontable form-table">
                        <tbody>
                        <tr valign="top">
                            <th scope="row">
                                <label><?php esc_html_e( 'Custom CSS', 'woocommerce-lookbook' ) ?></label>
                            </th>
                            <td>
                                <textarea type="text"
                                          name="<?php echo self::set_field( 'custom_css' ) ?>"><?php echo self::get_field( 'custom_css' ) ?></textarea>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="vi-ui bottom attached tab segment" data-tab="product">
                    <!-- Tab Content !-->
                    <table class="optiontable form-table">
                        <tbody>
                        <tr valign="top">
                            <th scope="row">
                                <label for="<?php echo self::set_field( 'link_redirect' ) ?>">
									<?php esc_html_e( 'Link Redirect', 'woocommerce-lookbook' ) ?>
                                </label>
                            </th>
                            <td>
                                <div class="vi-ui toggle checkbox">
                                    <input id="<?php echo self::set_field( 'link_redirect' ) ?>"
                                           type="checkbox" <?php checked( self::get_field( 'link_redirect' ), 1 ) ?>
                                           tabindex="0" class="hidden" value="1"
                                           name="<?php echo self::set_field( 'link_redirect' ) ?>"/>
                                    <label></label>
                                </div>
                                <p class="description"><?php esc_html_e( 'Click on Nodes will redirect the page to the single product page.', 'woocommerce-lookbook' ) ?></p>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                <label for="<?php echo self::set_field( 'external_product' ) ?>">
									<?php esc_html_e( 'External Link', 'woocommerce-lookbook' ) ?>
                                </label>
                            </th>
                            <td>
                                <div class="vi-ui toggle checkbox">
                                    <input id="<?php echo self::set_field( 'external_product' ) ?>"
                                           type="checkbox" <?php checked( self::get_field( 'external_product' ), 1 ) ?>
                                           tabindex="0" class="hidden" value="1"
                                           name="<?php echo self::set_field( 'external_product' ) ?>"/>
                                    <label></label>
                                </div>
                                <p class="description"><?php esc_html_e( 'Click on Nodes will redirect the page to the external link instead of the single product page. Working only with External/Affiliate products.', 'woocommerce-lookbook' ) ?></p>
                            </td>
                        </tr>

                        </tbody>
                    </table>
                </div>
                <!-- Instagram !-->
                <div class="vi-ui bottom attached tab segment" data-tab="instagram">
                    <h3>How to get Instagram Access Token.</h3>
                    <ul>
                        <li>
							<?php
							$guide = esc_html__( '1. Create Facebook App at ', 'woocommerce-lookbook' );
							$guide .= '<a target="_blank" href="https://developers.facebook.com/">https://developers.facebook.com/</a>';
							$guide .= '</li><li>';
							$guide .= esc_html__( '2. Add Facebook login & Instagram module', 'woocommerce-lookbook' );
							$guide .= '</li><li>';
							$guide .= esc_html__( '3. Copy ', 'woocommerce-lookbook' );
							$guide .= '<strong>' . admin_url( 'edit.php?post_type=woocommerce-lookbook&page=woocommerce-lookbook-settings#/instagram' ) . '</strong>';
							$guide .= esc_html__( ' to Facebook Login > Settings > Valid OAuth Redirect URIs', 'woocommerce-lookbook' );
							echo $guide;
							?>
                        </li>
                        <li>
                            <iframe width="560" height="315" src="https://www.youtube.com/embed/109jLhPIokY" frameborder="0"
                                    allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </li>
                    </ul>

                    <!-- Tab Content !-->
                    <table class="optiontable form-table">
                        <tbody>

                        <tr valign="top">
                            <th scope="row">
                                <label for="<?php echo self::set_field( 'ins_client_id' ) ?>">
									<?php esc_html_e( 'Client ID', 'woocommerce-lookbook' ) ?>
                                </label>
                            </th>
                            <td>
                                <input type="text" name="<?php echo self::set_field( 'ins_client_id' ) ?>"
                                       value="<?php echo self::get_field( 'ins_client_id', '' ) ?>"/>

                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                <label for="<?php echo self::set_field( 'ins_client_secret' ) ?>">
									<?php esc_html_e( 'Client Secret', 'woocommerce-lookbook' ) ?>
                                </label>
                            </th>
                            <td>
                                <input type="text" name="<?php echo self::set_field( 'ins_client_secret' ) ?>"
                                       value="<?php echo self::get_field( 'ins_client_secret', '' ) ?>"/>
                            </td>
                        </tr>

						<?php
						$access_token  = self::get_field( 'ins_access_token' );
						$instagram     = new VillaTheme_Instagram();
						$instagram->fb = $instagram->fb_connect();
						$check_token   = $instagram->check_token_live( $access_token );
						$access_token  = ( $check_token !== false || $check_token !== null ) ? $access_token : '';
						?>
                        <tr valign="top">
                            <th scope="row">
                                <label for="<?php echo self::set_field( 'ins_access_token' ) ?>">
									<?php esc_html_e( 'Access Token', 'woocommerce-lookbook' ) ?>
                                </label>
                            </th>
                            <td>
                                <input type="hidden" name="<?php echo self::set_field( 'ins_page_id' ) ?>"
                                       value="<?php echo self::get_field( 'ins_page_id', '' ) ?>"/>
                                <input type="text" name="<?php echo self::set_field( 'ins_access_token' ) ?>"
                                       value="<?php echo $access_token ?>"/>
                            </td>
                        </tr>

                        <tr valign="top">
                            <th scope="row"></th>
                            <td>
								<?php
								if ( self::get_field( 'ins_client_id', '' ) && self::get_field( 'ins_client_secret', '' ) ) {
									if ( ! $access_token ) {
										$link_call_back = add_query_arg(
											array( 'post_type' => 'woocommerce-lookbook', 'page' => 'woocommerce-lookbook-settings#/instagram' ),
											admin_url( 'edit.php' )
										);

										$link_login = $instagram->get_link_login(
											$link_call_back,
											array(
												'public_profile',
												'instagram_manage_comments',
												'instagram_basic',
												'pages_show_list',
												'pages_read_engagement'
											) );
										?>
                                        <a href="<?php echo $link_login ?>"
                                           class="vi-ui button green"><?php esc_html_e( 'Get Access Token', 'woocommerce-lookbook' ) ?></a>
									<?php }
								} ?>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                <label for="<?php echo self::set_field( 'ins_display' ) ?>">
									<?php esc_html_e( 'Display', 'woocommerce-lookbook' ) ?>
                                </label>
                            </th>
                            <td>
                                <select name="<?php echo self::set_field( 'ins_display' ) ?>"
                                        class="vi-ui fluid dropdown">
                                    <option <?php selected( self::get_field( 'ins_display' ), 0 ) ?>
                                            value="0"><?php esc_attr_e( 'Gallery', 'woocommerce-lookbook' ) ?></option>
                                    <option <?php selected( self::get_field( 'ins_display' ), 1 ) ?>
                                            value="1"><?php esc_attr_e( 'Carousel', 'woocommerce-lookbook' ) ?></option>
                                </select>
                            </td>
                        </tr>

                        <tr valign="top">
                            <th scope="row">
                                <label><?php esc_html_e( 'Number items per row', 'woocommerce-lookbook' ) ?></label>
                            </th>
                            <td>
                                <select name="<?php echo self::set_field( 'ins_items_per_row' ) ?>"
                                        class="vi-ui fluid dropdown">
                                    <option <?php selected( self::get_field( 'ins_items_per_row' ), 3 ) ?>
                                            value="3"><?php esc_attr_e( '3', 'woocommerce-lookbook' ) ?></option>
                                    <option <?php selected( self::get_field( 'ins_items_per_row' ), 4 ) ?>
                                            value="4"><?php esc_attr_e( '4', 'woocommerce-lookbook' ) ?></option>
                                    <option <?php selected( self::get_field( 'ins_items_per_row' ), 5 ) ?>
                                            value="5"><?php esc_attr_e( '5', 'woocommerce-lookbook' ) ?></option>
                                </select>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                <label><?php esc_html_e( 'Display limit', 'woocommerce-lookbook' ) ?></label>
                            </th>
                            <td>
                                <input type="number" name="<?php echo self::set_field( 'ins_display_limit' ) ?>"
                                       value="<?php echo self::get_field( 'ins_display_limit', 12 ) ?>"/>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                <label for="<?php echo self::set_field( 'ins_link' ) ?>">
									<?php esc_html_e( 'Link to Instagram', 'woocommerce-lookbook' ) ?>
                                </label>
                            </th>
                            <td>
                                <div class="vi-ui toggle checkbox">
                                    <input id="<?php echo self::set_field( 'ins_link' ) ?>"
                                           type="checkbox" <?php checked( self::get_field( 'ins_link' ), 1 ) ?>
                                           tabindex="0" class="hidden" value="1"
                                           name="<?php echo self::set_field( 'ins_link' ) ?>"/>
                                    <label></label>
                                </div>
                            </td>
                        </tr>

                        </tbody>
                    </table>
                    <h3><?php esc_html_e( 'Synchronize', 'woocommerce-lookbook' ) ?></h3>
                    <table class="optiontable form-table">
                        <tbody>
                        <tr valign="top">
                            <th scope="row">
                                <label for="<?php echo self::set_field( 'ins_schedule' ) ?>">
									<?php esc_html_e( 'Schedule', 'woocommerce-lookbook' ) ?>
                                </label>
                            </th>
                            <td>
                                <select name="<?php echo self::set_field( 'ins_schedule' ) ?>"
                                        class="vi-ui fluid dropdown">
                                    <option <?php selected( self::get_field( 'ins_schedule' ), 0 ) ?>
                                            value="0"><?php esc_attr_e( 'Never', 'woocommerce-lookbook' ) ?></option>
                                    <option <?php selected( self::get_field( 'ins_schedule' ), 1 ) ?>
                                            value="1"><?php esc_attr_e( '1 hour', 'woocommerce-lookbook' ) ?></option>
                                    <option <?php selected( self::get_field( 'ins_schedule' ), 2 ) ?>
                                            value="2"><?php esc_attr_e( '6 hours', 'woocommerce-lookbook' ) ?></option>
                                    <option <?php selected( self::get_field( 'ins_schedule' ), 3 ) ?>
                                            value="3"><?php esc_attr_e( '12 hours', 'woocommerce-lookbook' ) ?></option>
                                    <option <?php selected( self::get_field( 'ins_schedule' ), 4 ) ?>
                                            value="4"><?php esc_attr_e( '24 hours', 'woocommerce-lookbook' ) ?></option>
                                    <option <?php selected( self::get_field( 'ins_schedule' ), 5 ) ?>
                                            value="5"><?php esc_attr_e( '72 hours', 'woocommerce-lookbook' ) ?></option>
                                    <option <?php selected( self::get_field( 'ins_schedule' ), 6 ) ?>
                                            value="6"><?php esc_attr_e( '1 week', 'woocommerce-lookbook' ) ?></option>
                                </select>
                                <p class="description"><?php esc_html_e( 'The action will trigger when someone visits your WordPress site.', 'woocommerce-lookbook' ) ?></p>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                <label for="<?php echo self::set_field( 'ins_image_status' ) ?>">
									<?php esc_html_e( 'Image Status', 'woocommerce-lookbook' ) ?>
                                </label>
                            </th>
                            <td>
                                <select name="<?php echo self::set_field( 'ins_image_status' ) ?>"
                                        class="vi-ui fluid dropdown">
                                    <option <?php selected( self::get_field( 'ins_image_status' ), 0 ) ?>
                                            value="0"><?php esc_attr_e( 'Pending', 'woocommerce-lookbook' ) ?></option>
                                    <option <?php selected( self::get_field( 'ins_image_status' ), 1 ) ?>
                                            value="1"><?php esc_attr_e( 'Public', 'woocommerce-lookbook' ) ?></option>
                                    <option <?php selected( self::get_field( 'ins_image_status' ), 2 ) ?>
                                            value="2"><?php esc_attr_e( 'Draft', 'woocommerce-lookbook' ) ?></option>
                                </select>
                                <p class="description"><?php esc_html_e( 'Lookbooks status after images are imported.', 'woocommerce-lookbook' ) ?></p>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                <label for="<?php echo self::set_field( 'ins_duplicate' ) ?>">
									<?php esc_html_e( 'Data Update', 'woocommerce-lookbook' ) ?>
                                </label>
                            </th>
                            <td>
                                <select name="<?php echo self::set_field( 'ins_duplicate' ) ?>"
                                        class="vi-ui fluid dropdown">
                                    <option <?php selected( self::get_field( 'ins_duplicate' ), 0 ) ?>
                                            value="0"><?php esc_attr_e( 'Skip', 'woocommerce-lookbook' ) ?></option>
                                    <option <?php selected( self::get_field( 'ins_duplicate' ), 1 ) ?>
                                            value="1"><?php esc_attr_e( 'Duplicate', 'woocommerce-lookbook' ) ?></option>
                                    <option <?php selected( self::get_field( 'ins_duplicate' ), 2 ) ?>
                                            value="2"><?php esc_attr_e( 'Update Likes, Comments', 'woocommerce-lookbook' ) ?></option>
                                </select>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                <label for="<?php echo self::set_field( 'ins_image_quantity' ) ?>">
									<?php esc_html_e( 'Image Quantity', 'woocommerce-lookbook' ) ?>
                                </label>
                            </th>
                            <td>
                                <input type="number"
                                       name="<?php echo self::set_field( 'ins_image_quantity' ) ?>"
                                       value="<?php echo self::get_field( 'ins_image_quantity', 10 ) ?>"/>
                                <p class="description"><?php esc_html_e( 'List images are get from API. The fewer quantity sync faster. Maximum:12', 'woocommerce-lookbook' ) ?></p>
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
                                               id="auto-update-key"
                                               class="villatheme-autoupdate-key-field"
                                               value="<?php echo self::get_field( 'key' ) ?>">
                                    </div>
                                    <div class="six wide field">
                                        <span class="vi-ui button green villatheme-get-key-button"
                                              data-href="https://api.envato.com/authorization?response_type=code&client_id=villatheme-download-keys-6wzzaeue&redirect_uri=https://villatheme.com/update-key"
                                              data-id="21233957"><?php echo esc_html__( 'Get Key', 'woocommerce-lookbook' ) ?></span>
                                    </div>
                                </div>

								<?php do_action( 'woocommerce-lookbook_key' ) ?>

                                <p class="description"><?php echo __( 'Please fill your key what you get from <a target="_blank" href="https://villatheme.com/my-download">Villatheme</a>. You can automatically update WooCommerce Lookbook plugin. See guide <a target="_blank" href="https://villatheme.com/knowledge-base/how-to-use-auto-update-feature/">here</a>', 'woocommerce-lookbook' ) ?></p>
                            </td>
                        </tr>


                        </tbody>
                    </table>
                </div>
                <p>
                    <button class="vi-ui button labeled icon primary wlb-submit">
                        <i class="send icon"></i> <?php esc_html_e( 'Save', 'woocommerce-lookbook' ) ?>
                    </button>
                    <button class="vi-ui button labeled icon wlb-submit"
                            name="<?php echo self::set_field( 'check_key' ) ?>">
                        <i class="send icon"></i> <?php esc_html_e( 'Save & Check Key', 'woocommerce-multi-currency' ) ?>
                    </button>
                </p>
            </form>
        </div>
        <div class="woocommerce-lookbook-iframe">
        </div>
		<?php
		do_action( 'villatheme_support_woocommerce-lookbook' );
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
				return 'woo_lookbook_params[' . $field . '][]';
			} else {
				return 'woo_lookbook_params[' . $field . ']';
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
		global $wlb_settings;
		$params = $wlb_settings;

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
				update_option( 'woo_lookbook_params', $options );

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
		new VillaTheme_Plugin_Check_Update (
			WOO_LOOKBOOK_VERSION,                    // current version
			'https://villatheme.com/wp-json/downloads/v3',  // update path
			'woocommerce-lookbook/woocommerce-lookbook.php',                  // plugin file slug
			'woocommerce-lookbook', '12172', $key, $setting_url
		);
		new VillaTheme_Plugin_Updater( 'woocommerce-lookbook/woocommerce-lookbook.php', 'woocommerce-lookbook', $setting_url );

		global $pagenow;
		if ( $pagenow === 'edit.php' && isset( $_REQUEST['post_type'], $_REQUEST['page'] ) && $_REQUEST['post_type'] === 'woocommerce-lookbook' && $_REQUEST['page'] === 'woocommerce-lookbook-settings' ) {


			if ( ! isset( $_POST['_woo_lookbook_nonce'] ) || ! isset( $_POST['woo_lookbook_params'] ) ) {
				return;
			}
			if ( ! wp_verify_nonce( $_POST['_woo_lookbook_nonce'], 'woo_lookbook_settings' ) ) {
				return;
			}
			if ( ! current_user_can( 'manage_woocommerce' ) ) {
				return;
			}
			$data = wc_clean( $_POST['woo_lookbook_params'] );

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

			update_option( 'woo_lookbook_params', $data );
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
<?php

/*
Class Name: WOO_LOOKBOOK_Admin_Product
Author: Andy Ha (support@villatheme.com)
Author URI: http://villatheme.com
Copyright 2017 villatheme.com. All rights reserved.
*/
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WOO_TRELLO_Admin_Product {
	protected $settings;
	protected $data;

	function __construct() {
		$this->settings = new WOO_TRELLO_Data();
		add_action( 'save_post', array( $this, 'save_metabox' ), 10, 2 );
		add_action( 'admin_enqueue_scripts', array( $this, 'product_scripts' ), 10, 2 );

		/*Search product*/
		add_action( 'wp_ajax_wlb_search_lookbook', array( $this, 'search_lookbook' ) );

		/*Add tab in product edit page*/
		add_filter( 'woocommerce_product_data_tabs', array( $this, 'woocommerce_product_data_tabs' ) );
		add_action( 'woocommerce_product_data_panels', array( $this, 'woocommerce_product_data_panels' ) );
	}

	public function woocommerce_product_data_panels() {
		global $post;
		$position       = $this->get_data( $post->ID, 'position', 0 );
		$shortcode_type = $this->get_data( $post->ID, 'shortcode_type', 0 );
		$enable         = $this->get_data( $post->ID, 'enable', 0 );
		$lookbooks      = $this->get_data( $post->ID, 'lookbooks', array() );
		$align          = $this->get_data( $post->ID, 'align', 0 );

		?>
		<div id="lookbook_product_data" class="panel woocommerce_options_panel hidden">
			<table class="table" cellspacing="5" cellpadding="5" width="100%">
				<tbody>
				<tr>
					<td align="left" width="20%"><?php esc_html_e( 'Enable', 'woocommerce-lookbook' ) ?></td>
					<td>
						<input name="wlb_params[enable]" type="checkbox" value="1" <?php checked( $enable, 1 ) ?> />
						<p class="description"><?php esc_html_e( 'Enable to display Lookbook on the single product page', 'woocommerce-lookbook' ) ?></p>
					</td>
				</tr>
				<tr>
					<td align="left" width="20%"><?php esc_html_e( 'Position', 'woocommerce-lookbook' ) ?></td>
					<td>
						<select name="wlb_params[position]" class="select short">
							<option value="0" <?php selected( $position, 0 ) ?>><?php esc_html_e( 'Above Description Tab', 'woocommerce-lookbook' ) ?></option>
							<option value="1" <?php selected( $position, 1 ) ?>><?php esc_html_e( 'Below Description Tab', 'woocommerce-lookbook' ) ?></option>
						</select>
						<p class="description"><?php esc_html_e( 'Select lookbook position.', 'woocommerce-lookbook' ) ?></p>

					</td>
				</tr>
				<tr>
					<td align="left" width="150px"><?php esc_html_e( 'Shortcode type', 'woocommerce-lookbook' ) ?></td>
					<td>
						<select name="wlb_params[shortcode_type]" class="select short">
							<option value="0" <?php selected( $shortcode_type, 0 ) ?>><?php esc_html_e( 'Single Image', 'woocommerce-lookbook' ) ?></option>
							<option value="1" <?php selected( $shortcode_type, 1 ) ?>><?php esc_html_e( 'Slides', 'woocommerce-lookbook' ) ?></option>
						</select>
					</td>
					<p class="description"><?php esc_html_e( 'Select how lookbooks should be played.', 'woocommerce-lookbook' ) ?></p>
				</tr>
				<tr>
					<td align="left" width="150px"><?php esc_html_e( 'Lookbooks', 'woocommerce-lookbook' ) ?></td>
					<td>
						<select name="wlb_params[lookbooks][]" multiple="multiple" class="wlb-lookbook-search" style="width: 50%;">
							<?php
							if ( is_array( $lookbooks ) && count( array_filter( $lookbooks ) ) ) {
								foreach ( $lookbooks as $lookbook ) {
									if ( get_post_type( $lookbook ) == 'woocommerce-lookbook' ) { ?>
										<option selected value="<?php echo esc_attr( $lookbook ) ?>"><?php echo get_post_field( 'post_title', $lookbook ) ?></option>
									<?php }
								}
								?>
							<?php }
							?>
						</select>
						<p class="description"><?php esc_html_e( 'Select lookbooks to display.', 'woocommerce-lookbook' ) ?></p>
					</td>
				</tr>
				<tr>
					<td align="left" width="150px"><?php esc_html_e( 'Align', 'woocommerce-lookbook' ) ?></td>
					<td>
						<select name="wlb_params[align]" class="select short">
							<option value="0" <?php selected( $align, 0 ) ?>><?php esc_html_e( 'Center', 'woocommerce-lookbook' ) ?></option>
							<option value="1" <?php selected( $align, 1 ) ?>><?php esc_html_e( 'Left', 'woocommerce-lookbook' ) ?></option>
							<option value="2" <?php selected( $align, 2 ) ?>><?php esc_html_e( 'Right', 'woocommerce-lookbook' ) ?></option>
						</select>
					</td>
				</tr>
				</tbody>
			</table>

		</div>
		<?php
		wp_nonce_field( 'wlb_product_metabox_save', '_wlb_nonce' );
	}

	/**
	 * Init lable tab
	 *
	 * @param $tab
	 *
	 * @return mixed
	 */
	public function woocommerce_product_data_tabs( $tab ) {
		$tab['lookbook'] = array(
			'label'    => esc_html__( 'LookBook', 'woocommerce-lookbook' ),
			'target'   => 'lookbook_product_data',
			'class'    => array(),
			'priority' => 71,
		);

		return $tab;
	}

	/**
	 * Select 2 search product
	 */
	public function search_lookbook() {

		if ( ! current_user_can( 'manage_woocommerce' ) ) {
			return;
		}

		$keyword = isset($_GET['keyword'])? sanitize_text_field($_GET['keyword']):'';

		if ( empty( $keyword ) ) {
			die();
		}
		$arg            = array(
			'post_status'    => 'publish',
			'post_type'      => 'woocommerce-lookbook',
			'posts_per_page' => 50,
			's'              => $keyword

		);
		$the_query      = new WP_Query( $arg );
		$found_products = array();
		if ( $the_query->have_posts() ) {
			while ( $the_query->have_posts() ) {
				$the_query->the_post();

				$product          = array( 'id' => get_the_ID(), 'text' => get_the_title() );
				$found_products[] = $product;
			}
		}
		wp_send_json( $found_products );
		die;
	}

	/**
	 * Load CSS and JS in product edit page
	 */
	public function product_scripts() {

		$screen = get_current_screen();
		if ( get_post_type() == 'product' && $screen->id == 'product' ) {

			wp_enqueue_style( 'select2', WOO_LOOKBOOK_CSS . 'select2.min.css' );
			wp_enqueue_style( 'woocommerce-lookbook-admin-product', WOO_LOOKBOOK_CSS . 'woocommerce-lookbook-admin-product.css' );

			wp_enqueue_media();
			wp_enqueue_script( 'select2' );
//			wp_enqueue_script( 'select2', WOO_LOOKBOOK_JS . 'select2.min.js', array( 'jquery' ), '4.0.5' );
			wp_enqueue_script( 'woocommerce-lookbook-admin-product', WOO_LOOKBOOK_JS . 'woocommerce-lookbook-admin-product.js', array( 'jquery' ) );
		}
	}

	/**
	 * Handles saving the meta box.
	 *
	 * @param int     $post_id Post ID.
	 * @param WP_Post $post    Post object.
	 *
	 * @return null
	 */
	public function save_metabox( $post_id, $post ) {
		// Add nonce for security and authentication.
		$nonce_name   = isset( $_POST['_wlb_nonce'] ) ? $_POST['_wlb_nonce'] : '';
		$nonce_action = 'wlb_product_metabox_save';

		// Check if nonce is set.
		if ( ! isset( $nonce_name ) ) {
			return;
		}

		// Check if nonce is valid.
		if ( ! wp_verify_nonce( $nonce_name, $nonce_action ) ) {
			return;
		}

		// Check if user has permissions to save data.
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		// Check if not an autosave.
		if ( wp_is_post_autosave( $post_id ) ) {
			return;
		}

		// Check if not a revision.
		if ( wp_is_post_revision( $post_id ) ) {
			return;
		}

		if ( ! isset( $_POST['wlb_params'] ) ) {
			return;
		}
		update_post_meta( $post_id, 'wlb_params', $_POST['wlb_params'] );
	}

	/**
	 * Get Post Meta
	 *
	 * @param $field
	 *
	 * @return bool
	 */
	private function get_data( $post_id, $field, $default = '' ) {


		if ( $this->data ) {
			$params = $this->data;
		} else {
			$this->data = get_post_meta( $post_id, 'wlb_params', true );
			$params     = $this->data;
		}

		if ( isset( $params[$field] ) && $field ) {
			return $params[$field];
		} else {
			return $default;
		}
	}


} ?>
<?php

/*
Class Name: WOO_LOOKBOOK_Admin_Lookbook
Author: Andy Ha (support@villatheme.com)
Author URI: http://villatheme.com
Copyright 2017 villatheme.com. All rights reserved.
*/
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WOO_LOOKBOOK_Admin_Lookbook {
	protected $settings;
	protected $data;

	function __construct() {
		$this->settings = new WOO_LOOKBOOK_Data();
		add_action( 'add_meta_boxes', array( $this, 'add_metabox' ) );
		add_action( 'save_post', array( $this, 'save_metabox' ), 10, 2 );
		add_action( 'admin_enqueue_scripts', array( $this, 'product_scripts' ), 10, 2 );

		/*Search product*/
		add_action( 'wp_ajax_wlb_search_product', array( $this, 'search_product' ) );

		/*Show shortcode*/
		add_action( 'edit_form_before_permalink', array( $this, 'show_shortcode' ) );

		/*Instagram*/
		add_action( 'manage_posts_extra_tablenav', array( $this, 'sync_button' ) );

		/*Sync Instagram*/
		add_action( 'wp_ajax_wlb_sync_instagram', array( $this, 'sync_instagram' ) );

		/*Sync Instagram*/
		add_action( 'wp_ajax_wlb_change_status', array( $this, 'change_status' ) );

		/*Add column*/
		add_filter( 'manage_woocommerce-lookbook_posts_columns', array( $this, 'define_columns' ) );
		add_action( 'manage_woocommerce-lookbook_posts_custom_column', array( $this, 'lookbook_columns' ), 10, 2 );
	}

	/**
	 * Change post status
	 */
	public function change_status() {
		if ( ! current_user_can( 'manage_woocommerce' ) ) {
			die;
		}
		$post_id = isset($_POST['p_id']) ? sanitize_text_field($_POST['p_id']):'';
		$post_status = isset($_POST['p_status']) ? sanitize_text_field($_POST['p_status']):'';
		if ( $post_id ) {
			switch ( $post_status ) {
				case 1:
					$status = 'publish';
					break;
				case 2:
					$status = 'draft';
					break;
				default:
					$status = 'pending';
			}
			$post_arg = array(
				'ID'          => $post_id,
				'post_status' => $status,
			);
			wp_update_post( $post_arg );
		}
		die;
	}

	/**
	 * Add custom columns
	 *
	 * @param $column_name
	 * @param $post_id
	 */
	public function lookbook_columns( $column_name, $post_id ) {
		if ( ! current_user_can( 'manage_woocommerce' ) ) {
			return;
		}
		switch ( $column_name ) {
			case 'wlb_thumbnail':
				if ( $this->get_data( $post_id, 'image' ) ) {
					?>
                    <img src="<?php echo wp_get_attachment_image_url( $this->get_data( $post_id, 'image' ) ) ?>"/>
					<?php
					//echo $this->get_data( $post_id, 'code' );
				}
				break;
			case 'wlb_shortcode':
				if ( $this->get_data( $post_id, 'instagram' ) ) {
					?>
                    <textarea type="text wlb-input" class="wlb-shortcode short-text" readonly>[woocommerce_lookbook_instagram]</textarea>
					<?php
				} else { ?>
                    <textarea type="text wlb-input" class="wlb-shortcode short-text"
                              readonly>[woocommerce_lookbook id="<?php echo esc_attr( $post_id ) ?>"]</textarea>
				<?php }
				break;
			case 'wlb_instagram':
				if ( $this->get_data( $post_id, 'instagram', 0 ) ) {
					echo '<i class="check icon wlb-green"></i>';
				}
				break;
			default:
				$post_status = get_post_field( 'post_status', $post_id );
				?>
                <div class="vi-ui mini buttons" data-id="<?php echo esc_attr( $post_id ) ?>">
                    <span data-val="1"
                          class="vi-ui button <?php echo $post_status == 'publish' ? 'green' : '' ?>"><?php echo esc_html__( 'Publish', 'woocommerce-lookbook' ) ?></span>
                    <span data-val="0"
                          class="vi-ui button <?php echo $post_status == 'pending' ? 'orange' : '' ?>"><?php echo esc_html__( 'Pending', 'woocommerce-lookbook' ) ?></span>
                    <span data-val="2"
                          class="vi-ui button <?php echo $post_status == 'draft' ? 'grey' : '' ?>"><?php echo esc_html__( 'Draft', 'woocommerce-lookbook' ) ?></span>
                </div>
			<?php
		}
	}

	/**
	 * Get Post Meta
	 *
	 * @param $field
	 *
	 * @return bool
	 */
	private function get_data( $post_id, $field, $default = '' ) {


		if ( isset( $this->data[ $post_id ] ) && $this->data[ $post_id ] ) {
			$params = $this->data[ $post_id ];
		} else {
			$this->data[ $post_id ] = get_post_meta( $post_id, 'wlb_params', true );
			$params                 = $this->data[ $post_id ];
		}
		if ( isset( $params[ $field ] ) && $field ) {
			return $params[ $field ];
		} else {
			return $default;
		}
	}

	/**
	 * Define Status button column
	 *
	 * @param $col
	 *
	 * @return mixed
	 */
	public function define_columns( $col ) {
		$date = $col['date'];
		unset( $col['date'] );
		if ( current_user_can( 'manage_woocommerce' ) ) {
			$col['wlb_instagram']    = esc_html__( 'Instagram', 'woocommerce-lookbook' );
			$col['wlb_thumbnail']    = esc_html__( 'Image', 'woocommerce-lookbook' );
			$col['wlb_shortcode']    = esc_html__( 'Shortcode', 'woocommerce-lookbook' );
			$col['wlb_quick_status'] = esc_html__( 'Status', 'woocommerce-lookbook' );
			$col['date']             = $date;
		}

		return $col;
	}

	/**
	 * Sync Ajax
	 */
	public function sync_instagram() {
		if ( ! current_user_can( 'manage_woocommerce' ) ) {
			return;
		}

		$import = new VillaTheme_Instagram();
		$import->import( false );
		die;
	}

	/**
	 * Show button
	 *
	 * @param $which
	 */
	public function sync_button() {
        return;
		if ( ! current_user_can( 'manage_woocommerce' ) ) {
			return;
		}

		if ( get_current_screen()->id == 'edit-woocommerce-lookbook' ) { ?>
            <div class="alignleft actions">
                <span class="vi-ui mini button instagram wlb-instagram-sync"><i
                            class="instagram icon"></i><?php echo esc_html__( 'Sync Instagram', 'woocommerce-lookbook' ) ?></span>
            </div>
			<?php
			if ( ! get_transient( 'wlb_ins_access_token' ) && $this->settings->get_ins_client_id() && $this->settings->get_ins_client_secret() ) {
				$link_call_back = add_query_arg( array(
					'post_type' => 'woocommerce-lookbook',
				), admin_url( 'edit.php' ) );
				$instagram      = new VillaTheme_Instagram();
				$link_login     = $instagram->get_link_login(
					$link_call_back,
					array(
						'public_profile',
						'instagram_manage_comments',
						'instagram_basic',
						'pages_show_list',
					) );
				?>
                <a href="<?php echo $link_login ?>"
                   class="vi-ui button green mini"><?php esc_html_e( 'Get Access Token', 'woocommerce-lookbook' ) ?></a>
				<?php
			}
		}
	}

	/**
	 * Show shortcode
	 *
	 * @param $post
	 */
	public function show_shortcode( $post ) {
		$screen = get_current_screen();
        $current_user = wp_get_current_user();
        $shop_name = $current_user->user_login;
		if ( get_post_type() == 'woocommerce-lookbook' && $screen->id == 'woocommerce-lookbook' ) {
			?>
            <div class="wlb-shortcode">
                <label>
					<?php echo esc_html__( 'Url of lookbook', 'woocommerce-lookbook' ) ?>
                    <input type="text" size="30" value='https://<?php echo $shop_name?>/apps/lookbook/<?php echo $post->ID ?>'
                           readonly/>
                    <a href="https://<?php echo $shop_name?>/apps/lookbook/<?php echo $post->ID ?>">View lookbook</a>
                </label>
            </div>
		<?php }
	}

	/**
	 * Select 2 search product
	 */
	public function search_product() {

		if ( ! current_user_can( 'manage_woocommerce' ) ) {
			return;
		}
		$keyword = isset($_GET['keyword'])? sanitize_text_field($_GET['keyword']):'';

		if ( empty( $keyword ) ) {
			die();
		}
		$arg            = array(
			'post_status'    => 'publish',
			'post_type'      => 'product',
			'posts_per_page' => 50,
			's'              => $keyword,
			'tax_query'      => array(
				array(
					'taxonomy' => 'product_type',
					'field'    => 'slug',
					'terms'    => array( 'simple', 'variable', 'external', 'rentable','mix-and-match' ),
					'operator' => 'IN'
				),
			)
		);
		$the_query      = new WP_Query( $arg );
		$found_products = array();
		if ( $the_query->have_posts() ) {
			while ( $the_query->have_posts() ) {
				$the_query->the_post();
				$terms = wp_get_post_terms( get_the_ID(), 'product_type' );
				if ( $terms[0]->slug == 'variable' ) {
					$ex_title = esc_html__( ' (Variable #' . get_the_ID() . ')', 'woocommerce-lookbook' );
				} else {
					$ex_title = '';
				}
				$product = array( 'id' => get_the_ID(), 'text' => get_the_title() . $ex_title );

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
		if ( get_post_type() == 'woocommerce-lookbook' && $screen->id == 'woocommerce-lookbook' ) {
			wp_enqueue_style( 'woocommerce-lookbook-button', WOO_LOOKBOOK_CSS . 'button.min.css' );
			wp_enqueue_style( 'woocommerce-lookbook-admin-metabox', WOO_LOOKBOOK_CSS . 'woocommerce-lookbook-admin-metabox.css' );
			wp_enqueue_style( 'select2', WOO_LOOKBOOK_CSS . 'select2.min.css' );

			wp_enqueue_media();
			wp_enqueue_script( 'jquery-ui-draggable' );
			wp_enqueue_script( 'select2', WOO_LOOKBOOK_JS . 'select2.min.js', array( 'jquery' ), '4.0.5' );
			wp_enqueue_script( 'woocommerce-lookbook-admin-metabox', WOO_LOOKBOOK_JS . 'woocommerce-lookbook-admin-metabox.js', array( 'jquery' ) );
		}
		if ( $screen->id == 'edit-woocommerce-lookbook' ) {
			wp_enqueue_style( 'woocommerce-lookbook-button', WOO_LOOKBOOK_CSS . 'button.min.css' );
			wp_enqueue_style( 'woocommerce-lookbook-icon', WOO_LOOKBOOK_CSS . 'icon.min.css' );
			wp_enqueue_style( 'woocommerce-lookbook-edit', WOO_LOOKBOOK_CSS . 'woocommerce-lookbook-admin-lookbook.css' );


			wp_enqueue_script( 'woocommerce-lookbook-admin-lookbook', WOO_LOOKBOOK_JS . 'woocommerce-lookbook-admin-lookbook.js', array( 'jquery' ) );

			// Localize the script with new data
			$translation_array = array(
				'ajax_url'   => esc_url( admin_url( 'admin-ajax.php' ) ),
				'sync_title' => esc_html__( 'Sync Instagram', 'woocommerce-lookbook' ),
				'loading'    => esc_html__( 'Loading', 'woocommerce-lookbook' ),
			);
			wp_localize_script( 'woocommerce-lookbook-admin-lookbook', '_wlb_params', $translation_array );
		}
	}

	/**
	 * Adds the meta box.
	 */
	public function add_metabox() {
		add_meta_box(
			'woocommerce-lookbook',
			__( 'Image', 'woocommerce-lookbook' ),
			array( $this, 'render_metabox' ),
			'woocommerce-lookbook',
			'normal',
			'high'
		);
		add_meta_box(
			'woocommerce-lookbook-sidebar',
			__( 'Node', 'woocommerce-lookbook' ),
			array( $this, 'render_metabox_node' ),
			'woocommerce-lookbook',
			'side',
			'high'
		);

	}

	public function render_metabox_node( $post ) { ?>
        <div class="wlb-table">

			<?php
			$product_ids = $this->get_data( $post->ID, 'product_id' );
			$product_info = $this->get_data( $post->ID, 'product_info' );
            $product_handle = $this->get_data( $post->ID, 'product_handle' );
            $wlb_params = $this->get_data( $post->ID, 'wlb_params' );
           // if (is_array($product_info)) $product_info = "Teeshert";
			$pos_x       = $this->get_data( $post->ID, 'x' );
			$pos_y       = $this->get_data( $post->ID, 'y' );
			if ( is_array( $product_ids ) && count( $product_ids ) ) {
				foreach ( $product_ids as $k => $product_id ) {
					if ( ! $product_id ) {
						continue;
					}
					//$product = wc_get_product( $product_id );
					//if ( ! is_object( $product ) || $product->get_status() != 'publish' ) {
					//	continue;
					//}
					?>
                    <div class="wlb-data wlb-item-<?php echo esc_attr( $k ) ?>"
                         data-id="<?php echo esc_attr( $k ) ?>">

                        <div class="wlb-field">
                        <input style="display: none" class="wlb-product" name="wlb_params[product_handle][]"  <?php if (isset($product_handle[$k])) { ?> value="<?php echo $product_handle[$k] ?>" <?php  } ?> />

                         <input style="display: none" class="wlb-product" name="wlb_params[product_info][]"  <?php if (isset($product_info[$k])) { ?> value="<?php echo $product_info[$k] ?>" <?php  } ?> />
                        </div>
                        <strong>Type product name to search for your product</strong>
                        <select class="s_product_id s_product_id_updated wlb-product" data-productid="<?php echo $product_id ?>"  <?php if (isset($product_info[$k])) { ?>  data-productname="<?php echo $product_info[$k] ?>" name="wlb_params[product_id][]" <?php  } ?> >

                        </select>

                        <div class="wlb-field">
							<?php esc_html_e( 'X', 'woocommerce-lookbook' ) ?>
                            <input class="wlb-x" type="number" name="wlb_params[x][]"
                                   value="<?php echo esc_attr( $pos_x[ $k ] ) ?>" min="0" max="100" step="0.01"/> <br/>
							<?php esc_html_e( 'Y', 'woocommerce-lookbook' ) ?>
                            <input class="wlb-y" type="number" name="wlb_params[y][]"
                                   value="<?php echo esc_attr( $pos_y[ $k ] ) ?>" min="0" max="100" step="0.01"/>
                        </div>
                        <span class="wlb-remove">x</span>

                    </div>
				<?php }
			} ?>
        </div>
        <div class="wlb-error"></div>
        <p>
			<span class="vi-ui wlb-add-new button green button-primary">
				<?php esc_html_e( 'Add node', 'woocommerce-lookbook' ) ?>
			</span>
        </p>
	<?php }

	/**
	 * Renders the meta box.
	 */
	public function render_metabox( $post ) { ?>

		<?php

		// Get WordPress' media upload URL
		$upload_link = esc_url( get_upload_iframe_src( 'image', $post->ID ) );

		// See if there's a media id already saved as post meta
		$your_img_id = $this->get_data( $post->ID, 'image' );

		// Get the image src
		$your_img_src = wp_get_attachment_image_src( $your_img_id, 'full' );

		// For convenience, see if the array is valid
		$you_have_img = is_array( $your_img_src );
		$product_ids  = $this->get_data( $post->ID, 'product_id' );
		$pos_x        = $this->get_data( $post->ID, 'x' );
		$pos_y        = $this->get_data( $post->ID, 'y' );
		?>

        <!-- Your image container, which can be manipulated with js -->
        <div class="wlb-image-container">
			<?php

			if ( is_array( $product_ids ) && count( $product_ids ) ) {
				foreach ( $product_ids as $k => $product_id ) {
					$x = isset( $pos_x[ $k ] ) ? $pos_x[ $k ] : 0;
					$y = isset( $pos_y[ $k ] ) ? $pos_y[ $k ] : 0;
					?>
                    <span class="wlb-node wlb-node-<?php echo esc_attr( $k ) ?>"
                          data-id="<?php echo esc_attr( $k ) ?>"
                          style="left: <?php echo $x ?>%;top: <?php echo $y ?>%">+</span>
				<?php }
			} ?>
			<?php if ( $you_have_img ) : ?>
                <img class="wlb-image" src="<?php echo $your_img_src[0] ?>" alt="" style="max-width:100%;"/>
			<?php endif; ?>
        </div>
        <!-- Your add & remove image links -->
        <div class="hide-if-no-js">
            <p>
                <a class="vi-ui button green wlb-upload-img <?php if ( $you_have_img ) {
					echo 'hidden';
				} ?>" href="<?php echo $upload_link ?>">
					<?php esc_html_e( 'Add Image', 'woocommerce-lookbook' ) ?>
                </a>
                <a class="vi-ui button red wlb-delete-img <?php if ( ! $you_have_img ) {
					echo 'hidden';
				} ?>" href="#">
					<?php esc_html_e( 'Remove this image', 'woocommerce-lookbook' ) ?>
                </a>
            </p>
        </div>
        <!-- A hidden input to set and post the chosen image id -->
        <input class="wlb-image-data" name="wlb_params[image]" type="hidden"
               value="<?php echo esc_attr( $your_img_id ); ?>"/>
        <input name="wlb_params[instagram]" type="hidden"
               value="<?php echo esc_attr( $this->get_data( $post->ID, 'instagram' ) ); ?>"/>
        <input name="wlb_params[code]" type="hidden"
               value="<?php echo esc_attr( $this->get_data( $post->ID, 'code' ) ); ?>"/>
        <input name="wlb_params[date]" type="hidden"
               value="<?php echo esc_attr( $this->get_data( $post->ID, 'date' ) ); ?>"/>
        <input name="wlb_params[comments]" type="hidden"
               value="<?php echo esc_attr( $this->get_data( $post->ID, 'comments' ) ); ?>"/>
        <input name="wlb_params[likes]" type="hidden"
               value="<?php echo esc_attr( $this->get_data( $post->ID, 'likes' ) ); ?>"/>

		<?php

		// Add nonce for security and authentication.
		wp_nonce_field( 'wlb_metabox_save', '_wlb_nonce' );
	}

	/**
	 * Handles saving the meta box.
	 *
	 * @param int $post_id Post ID.
	 * @param WP_Post $post Post object.
	 *
	 * @return null
	 */
	public function save_metabox( $post_id, $post ) {
        global $wpdb;
        if ($post->post_type=='woocommerce-lookbook' && isset($_REQUEST['wlb_params']) ) {
            if ($post->post_status == 'publish') {
                // @codingStandardsIgnoreStart
                $wpdb->query(
                    $wpdb->prepare(
                        "
			UPDATE $wpdb->posts
			SET post_status = '%s'
			WHERE post_type = '%s'
			AND ID = '%d'

			",
                        'private',
                        'woocommerce-lookbook',
                        $post_id
                    )
                );
            }
        }

		// Add nonce for security and authentication.
		$nonce_name   = isset( $_POST['_wlb_nonce'] ) ? $_POST['_wlb_nonce'] : '';
		$nonce_action = 'wlb_metabox_save';

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
		update_post_meta( $post_id, 'wlb_params', wc_clean( $_POST['wlb_params'] ) );
	}
}
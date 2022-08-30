<?php

/**
 * Class WOO_LOOKBOOK_Frontend_Shortcode
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WOO_LOOKBOOK_Frontend_Shortcode {
	protected $settings;
	protected $data;

	public function __construct() {

		$this->settings = new WOO_LOOKBOOK_Data();
		/*Register scripts*/
		add_action( 'wp_enqueue_scripts', array( $this, 'shortcode_scripts' ) );
		/*Overlay*/
//		add_action( 'wp_footer', array( $this, 'overlay' ) );

		/*Auto update Instagram*/
		add_action( 'init', array( $this, 'auto_sync' ) );

		/*Register shortcode*/
		add_shortcode( 'woocommerce_lookbook', array( $this, 'register_shortcode' ) );
		add_shortcode( 'woocommerce_lookbook_slide', array( $this, 'register_shortcode_slide' ) );
		add_shortcode( 'woocommerce_lookbook_instagram', array( $this, 'register_shortcode_instagram' ) );

		/*Show quick view*/
//		add_action( 'wp_ajax_nopriv_wlb_get_product', array( $this, 'get_product' ) );
//		add_action( 'wp_ajax_wlb_get_product', array( $this, 'get_product' ) );
		self::add_ajax_events();

		/*Show Instagram on quickview*/
		add_action( 'wp_ajax_nopriv_wlb_get_lookbook', array( $this, 'get_lookbook' ) );
		add_action( 'wp_ajax_wlb_get_lookbook', array( $this, 'get_lookbook' ) );
        /** Thuy added */
        add_action( 'wp_ajax_nopriv_wlb_get_lookbook_saas', array( $this, 'get_lookbook_saas' ) );
        add_action( 'wp_ajax_wlb_get_lookbook_saas', array( $this, 'get_lookbook_saas' ) );

		/*Quick view*/
		add_action( 'woocommerce_lookbook_single_product_summary', array( $this, 'product_single_title' ), 5 );
		add_action( 'woocommerce_lookbook_single_product_summary', 'woocommerce_template_single_rating', 10 );
		add_action( 'woocommerce_lookbook_single_product_summary', array( $this, 'product_price' ), 10 );
		add_action( 'woocommerce_lookbook_single_product_summary', array( $this, 'product_short_desc' ), 20 );
		add_action( 'woocommerce_lookbook_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
		add_action( 'woocommerce_lookbook_single_product_summary', array( $this, 'read_more' ), 40 );

		/*Product on quickview Gallery*/
		add_action( 'woocommerce_lookbook_single_product_gallery', array( $this, 'product_single_title' ), 5 );
		add_action( 'woocommerce_lookbook_single_product_gallery', array( $this, 'product_price' ), 10 );
		add_action( 'woocommerce_lookbook_single_product_gallery', 'woocommerce_template_single_add_to_cart', 30 );

		add_action( 'wlb_elementor_register_scripts', array( $this, 'shortcode_scripts' ) );
		add_action( 'wlb_elementor_register_scripts', array( $this, 'localize_script' ) );
		add_action( 'wlb_elementor_get_inline_style', array( $this, 'get_inline_style' ) );
	}
	public static function add_ajax_events() {
		$ajax_events = array(
			'wlb_get_product'   => true,
		);
		foreach ( $ajax_events as $ajax_event => $nopriv ) {
			add_action( 'wp_ajax_woocommerce_' . $ajax_event, array( __CLASS__, $ajax_event ) );
			if ( $nopriv ) {
				add_action( 'wp_ajax_nopriv_woocommerce_' . $ajax_event, array( __CLASS__, $ajax_event ) );
			}
			// WC AJAX can be used for frontend ajax requests.
			add_action( 'wc_ajax_' . $ajax_event, array( __CLASS__, $ajax_event ) );
		}
	}

    public function get_lookbook_saas()  {
        $this->enqueue_scripts();


        $ids = $_REQUEST['id'];
        if ( ! $ids ) {
            return false;
        }

        $ids = array_filter( explode( ',', trim( $ids ) ) );
        if ( count( $ids ) < 1 ) {
            return false;
        }

        ob_start();

        foreach ( $ids as $id ) {
            $image_id = $this->get_data( $id, 'image' );

            $products = $this->get_data( $id, 'product_id' );
            $product_infos = $this->get_data( $id, 'product_info' );
            $product_handle = $this->get_data( $id, 'product_handle' );
            $pos_x    = $this->get_data( $id, 'x' );
            $pos_y    = $this->get_data( $id, 'y' );

            $img_url = wp_get_attachment_url( $image_id );

            if ( ! $img_url ) {
                continue;
            } ?>
            <div class="woocommerce-lookbook wlb-show-node wlb-lookbook-item-wrapper">
                <div class="woocommerce-lookbook-inner">
                    <img src="<?php echo esc_url( $img_url ) ?>" class="wlb-image"/>
                    <?php if ( is_array( $products ) && count( $products ) ) {
                        foreach ( $products as $k => $product ) {
                            if ( ! $product ) {
                                continue;
                            }
                            $product_title = $product_infos[$k];
                            $product_url = $product_handle[$k];
                            echo $this->get_node( $product,$product_title,$product_url, $pos_x[ $k ], $pos_y[ $k ] );
                            ?>
                        <?php }
                    } ?>
                </div>
            </div>
            <div class="wlb-clearfix"></div>
        <?php }
        $html = ob_get_clean();
        wp_head();

        echo  $html;
       // wp_send_json($return_arr);
        wp_die();
    }

	public function product_short_desc() {
		global $post;

		$short_description = $post->post_excerpt;

		if ( ! $short_description ) {
			return;
		}

		?>
        <div class="wlb-product-short-description">
			<?php echo $short_description; // WPCS: XSS ok. ?>
        </div>
	<?php }

	/**
	 * Show Product price
	 */
	public function product_price() {
		global $product;
		do_action('woocommerce_lookbook_wlb_before_product_price');
		?>
        <div class="wlb-product-price">
			<?php echo $product->get_price_html(); ?>
        </div>
	    <?php
		do_action('woocommerce_lookbook_wlb_after_product_price');
	}

	/**
	 * Show product title
	 */
	public function product_single_title() {
		$url = get_the_permalink();
		do_action('woocommerce_lookbook_wlb_before_product_title');
		the_title( '<h3 class="wlb-product-title entry-title"><a target="_blank" href="' . esc_url( $url ) . '">', '</a></h3>' );
		do_action('woocommerce_lookbook_wlb_after_product_title');
	}

	/**
	 *
	 */
	public function auto_sync() {
		$schedule = (int) $this->settings->get_ins_schedule();
		if ( ! $schedule || get_transient( 'wlb_auto_sync_instagram' ) ) {
			return;
		}

		set_transient( 'wlb_auto_sync_instagram', true, (int) $this->settings->get_ins_schedule() );
		$ins = new VillaTheme_Instagram();
		$ins->import();
	}

	/**
	 * Add remove link
	 */
	public function read_more() {
		if ( $this->settings->see_more() ) {
			return false;
		}
		global $post; ?>
        <div class="wlb-read-more">
            <a class="wlb-read-more-button"
               href="<?php the_permalink( $post->ID ) ?>"><?php esc_html_e( 'See more', 'woocommerce-lookbook' ) ?></a>
        </div>
	<?php }

	/**
	 * Quick view Instagram
	 */
	public function get_lookbook() {
		global $product, $post;
		$lookbook_id = isset($_POST['lookbook_id'])? sanitize_text_field($_POST['lookbook_id']):'';
		if ( $lookbook_id ) {
			$products = $this->get_data( $lookbook_id, 'product_id', array() );
			$style    = $this->settings->get_modal_style() ? $this->settings->get_modal_style() : 0;
			$left     = do_shortcode( '[woocommerce_lookbook id="' . $lookbook_id . '"]' );
			ob_start();
			?>
            <div class="wlb-instagram-controls">
				<?php $likes = $this->get_data( $lookbook_id, 'likes' );
				if ( $likes ) {
					?>
                    <div class="wlb-instagram-controls-likes">
						<?php echo esc_html( $likes ) ?>
                    </div>
				<?php }
				$comments = $this->get_data( $lookbook_id, 'comments' );
				if ( $comments ) {
					?>
                    <div class="wlb-instagram-controls-comments">
						<?php echo esc_html( $comments ) ?>
                    </div>
				<?php }
				$code = $this->get_data( $lookbook_id, 'code' );
				if ( $code && $this->settings->ins_link() ) {
					?>
                    <div class="wlb-instagram-controls-link">
						<?php $ins_url = 'https://www.instagram.com/p/' . $code ?>
                        <a target="_blank"
                           href="<?php echo esc_url( $ins_url ) ?>"><?php esc_html_e( 'View on Instagram', 'woocommerce-lookbook' ) ?></a>
                    </div>
				<?php } ?>
            </div>
            <div class="wlb-instagram-description">
				<?php echo esc_html( get_post_field( 'post_title', $lookbook_id ) ) ?>
            </div>
            <div class="wlb-product-galleries">
				<?php if ( count( $products ) ) { ?>
					<?php foreach ( $products as $product_id ) {

						if ( defined( 'ICL_LANGUAGE_CODE' ) ) {
							$product_id = apply_filters( 'wpml_object_id', $product_id, 'product', false, ICL_LANGUAGE_CODE );
						}

						$product = wc_get_product( $product_id );
						$post    = get_post( $product_id );
						?>
                        <div class="wlb-product-gallery wlb-<?php echo esc_attr( $product->get_type() ) ?> product">
                            <div class="wlb-product-row">
								<?php if ( $style == 1 ) { ?>
                                    <div class="wlb-product-image">
                                        <div id="product-<?php the_ID(); ?>" <?php wc_product_class( '', $product ); ?>>
											<?php
											wc_get_template( 'product-image.php', '', '', WOO_LOOKBOOK_TEMPLATES );
											?>
                                        </div>
                                    </div>
								<?php } ?>
                                <div class="wlb-product-form">
									<?php do_action( 'woocommerce_lookbook_single_product_gallery' ); ?>
                                </div>
                            </div>
                        </div>
						<?php
					}
				} ?>
            </div>
			<?php
			$right = ob_get_clean();
			wp_send_json( array( 'left' => $left, 'right' => $right ) );
		}
		die;
	}

	/**Get Post Meta
	 *
	 * @param $post_id
	 * @param $field
	 * @param string $default
	 *
	 * @return string
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
	 * Quick view
	 */
	public static  function wlb_get_product() {
//	public function get_product() {
		global $product, $post;
		$prod_id = isset($_POST['product_id'])? sanitize_text_field($_POST['product_id']):'';
		$product = wc_get_product( $prod_id );
		$post    = get_post( $prod_id );
		ob_start();
		wc_get_template( 'product-image.php', '', '', WOO_LOOKBOOK_TEMPLATES );// array( 'product' => $product )
		$left = ob_get_clean();
		ob_start();
		?>
        <div class="wlb-<?php echo esc_attr( $product->get_type() ) ?>">
			<?php
			/**
			 * woocommerce_single_product_summary hook.
			 *
			 * @hooked woocommerce_template_single_title - 5
			 * @hooked woocommerce_template_single_rating - 10
			 * @hooked woocommerce_template_single_price - 10
			 * @hooked woocommerce_template_single_excerpt - 20
			 * @hooked woocommerce_template_single_add_to_cart - 30
			 * @hooked woocommerce_template_single_meta - 40
			 * @hooked woocommerce_template_single_sharing - 50
			 * @hooked WC_Structured_Data::generate_product_data() - 60
			 */
			do_action( 'woocommerce_lookbook_single_product_summary' ); ?>
        </div>
		<?php
		$right = ob_get_clean();
		wp_send_json( array( 'left' => $left, 'right' => $right ) );
		die;
	}

	/**
	 * Init Overlay
	 */
	public function overlay() {
		wp_enqueue_script( 'wc-add-to-cart-variation' );
		$style     = $this->settings->get_modal_style();
		$nav_pos   = $this->settings->get_nav_position();
		$nav_align = $this->settings->get_nav_alignment();
		?>
        <div class="woocommerce-lookbook-quickview <?php echo is_rtl() ? 'wlb-rtl' : ''; ?>" style="display: none">
            <div class="woocommerce-lookbook-quickview-inner single-product">
                <div class="wlb-overlay"></div>
                <div class="wlb-product-wrapper wlb-<?php echo $style ?>">
					<?php echo $this->loading_html(); ?>
                    <div class="wlb-product-frame wlb-lookbook-container product" style="display: none">
                        <div class="wlb-left">
                            <div class="wlb-controls <?php echo $nav_pos ?>" style="text-align: <?php echo $nav_align ?>">
                                <span class="wlb-controls-previous"></span>
                                <span class="wlb-controls-next"></span>
								<?php if ( ! $this->settings->enable_close_button() && in_array( $nav_pos, array( 'top', 'bottom' ) ) ) {
									echo '<span class="wlb-close"></span>';
								} ?>
                            </div>
                            <div class="wlb-lookbook-data">
                            </div>
                        </div>
                        <div class="wlb-right">
							<?php if ( ! $this->settings->enable_close_button() && ! $nav_pos ) {
								echo '<span class="wlb-close"></span>';
							} ?>
                            <div class="wlb-product-data">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="wlb-added">
			<?php echo esc_html__( 'Product added successful', 'woocommerce-lookbook' ) ?>
        </div>
		<?php
	}

	/**
	 * Load loading html
	 * @return mixed
	 */
	private function loading_html() {
		ob_start();

		switch ( $this->settings->get_loading_icon() ) {
			case  1:
				?>
                <div class="wlb-double-bounce wlb-loading">
                    <div class="wlb-child wlb-double-bounce1"></div>
                    <div class="wlb-child wlb-double-bounce2"></div>
                </div>
				<?php break;
			case  2:
				?>
                <div class="wlb-wave wlb-loading">
                    <div class="wlb-rect wlb-rect1"></div>
                    <div class="wlb-rect wlb-rect2"></div>
                    <div class="wlb-rect wlb-rect3"></div>
                    <div class="wlb-rect wlb-rect4"></div>
                    <div class="wlb-rect wlb-rect5"></div>
                </div>
				<?php break;
			case  3:
				?>
                <div class="wlb-wandering-cubes wlb-loading">
                    <div class="wlb-cube wlb-cube1"></div>
                    <div class="wlb-cube wlb-cube2"></div>
                </div>
				<?php break;
			case  4:
				?>
                <div class="wlb-spinner wlb-spinner-pulse wlb-loading"></div>
				<?php break;
			case  5:
				?>
                <div class="wlb-chasing-dots wlb-loading">
                    <div class="wlb-child wlb-dot1"></div>
                    <div class="wlb-child wlb-dot2"></div>
                </div>
				<?php break;
			case  6:
				?>
                <div class="wlb-three-bounce wlb-loading">
                    <div class="wlb-child wlb-bounce1"></div>
                    <div class="wlb-child wlb-bounce2"></div>
                    <div class="wlb-child wlb-bounce3"></div>
                </div>
				<?php break;
			case  7:
				?>
                <div class="wlb-circle wlb-loading">
                    <div class="wlb-circle1 wlb-child"></div>
                    <div class="wlb-circle2 wlb-child"></div>
                    <div class="wlb-circle3 wlb-child"></div>
                    <div class="wlb-circle4 wlb-child"></div>
                    <div class="wlb-circle5 wlb-child"></div>
                    <div class="wlb-circle6 wlb-child"></div>
                    <div class="wlb-circle7 wlb-child"></div>
                    <div class="wlb-circle8 wlb-child"></div>
                    <div class="wlb-circle9 wlb-child"></div>
                    <div class="wlb-circle10 wlb-child"></div>
                    <div class="wlb-circle11 wlb-child"></div>
                    <div class="wlb-circle12 wlb-child"></div>
                </div>
				<?php break;
			case  8:
				?>
                <div class="wlb-cube-grid wlb-loading">
                    <div class="wlb-cube wlb-cube1"></div>
                    <div class="wlb-cube wlb-cube2"></div>
                    <div class="wlb-cube wlb-cube3"></div>
                    <div class="wlb-cube wlb-cube4"></div>
                    <div class="wlb-cube wlb-cube5"></div>
                    <div class="wlb-cube wlb-cube6"></div>
                    <div class="wlb-cube wlb-cube7"></div>
                    <div class="wlb-cube wlb-cube8"></div>
                    <div class="wlb-cube wlb-cube9"></div>
                </div>
				<?php break;
			case  9:
				?>
                <div class="wlb-fading-circle wlb-loading">
                    <div class="wlb-circle1 wlb-circle"></div>
                    <div class="wlb-circle2 wlb-circle"></div>
                    <div class="wlb-circle3 wlb-circle"></div>
                    <div class="wlb-circle4 wlb-circle"></div>
                    <div class="wlb-circle5 wlb-circle"></div>
                    <div class="wlb-circle6 wlb-circle"></div>
                    <div class="wlb-circle7 wlb-circle"></div>
                    <div class="wlb-circle8 wlb-circle"></div>
                    <div class="wlb-circle9 wlb-circle"></div>
                    <div class="wlb-circle10 wlb-circle"></div>
                    <div class="wlb-circle11 wlb-circle"></div>
                    <div class="wlb-circle12 wlb-circle"></div>
                </div>
				<?php break;
			case  10:
				?>
                <div class="wlb-folding-cube wlb-loading">
                    <div class="wlb-cube1 wlb-cube"></div>
                    <div class="wlb-cube2 wlb-cube"></div>
                    <div class="wlb-cube4 wlb-cube"></div>
                    <div class="wlb-cube3 wlb-cube"></div>
                </div>
				<?php break;
			default: ?>
                <div class="wlb-rotating-plane wlb-loading"></div>
			<?php }

		return ob_get_clean();
	}

	/**
	 * Shortcode scripts
	 */
	public function shortcode_scripts() {
		//libs
		wp_register_style( 'woocommerce-vi-flexslider', WOO_LOOKBOOK_CSS . 'vi_flexslider.min.css', array(), WOO_LOOKBOOK_VERSION );
		wp_register_script( 'jquery-slides', WOO_LOOKBOOK_JS . 'jquery.slides.min.js', array( 'jquery' ), '3.0.4' );
		wp_register_script( 'jquery-vi-flexslider', WOO_LOOKBOOK_JS . 'jquery.vi_flexslider.min.js', array( 'jquery' ), '2.7.0' );

		//exe
		$suffix = WP_DEBUG ? '.css' : '.min.css';
		wp_register_style( 'woocommerce-lookbook', WOO_LOOKBOOK_CSS . 'woocommerce-lookbook' . $suffix, array(), WOO_LOOKBOOK_VERSION );
		$suffix = WP_DEBUG ? '.js' : '.min.js';
		wp_register_script( 'woocommerce-lookbook', WOO_LOOKBOOK_JS . 'woocommerce-lookbook' . $suffix, array( 'jquery' ), WOO_LOOKBOOK_VERSION );
	}

	public function get_inline_style() {
		$icon_background_color  = $this->settings->get_icon_background_color();
		$icon_color             = $this->settings->get_icon_color();
		$icon_border_color      = $this->settings->get_icon_border_color();
		$title_color            = $this->settings->get_title_color();
		$title_background_color = $this->settings->get_title_background_color();
		$css                    = ".woocommerce-lookbook .woocommerce-lookbook-inner .wlb-item .wlb-pulse{
                                    background-color:{$icon_background_color};
                                    border-color:{$icon_border_color};
                                    color:{$icon_color};
                                    }
                                    .woocommerce-lookbook .woocommerce-lookbook-inner .wlb-item .wlb-dot{
                                        border-color:{$icon_border_color};
                                    }
                                    .woocommerce-lookbook .woocommerce-lookbook-inner .wlb-item.default{
                                        background-color:{$icon_background_color};
                                        color:{$icon_color};
                                    }
                                    .woocommerce-lookbook .woocommerce-lookbook-inner .wlb-item .wlb-pin:after{
                                        background-color:{$icon_color};
                                    }
                                    .woocommerce-lookbook .woocommerce-lookbook-inner .wlb-item .wlb-pin{
                                        background-color:{$icon_background_color};
                                    }
                                    .woocommerce-lookbook .wlb-speech-bubble{
                                        background-color: {$title_background_color};
                                        color:{$title_color};
                                    }
                                    .woocommerce-lookbook .wlb-speech-bubble:after{
                                        border-bottom-color: {$title_background_color};
                                    }
                                    .wlb-lookbook-slide-outer, .wlb-lookbook-slide{
                                        max-width:{$this->settings->get_slide_width()}px;
                                        max-height:{$this->settings->get_slide_height()}px;
                                    }";

		/*Quick view Custom CSS*/
		$text_color       = $this->settings->get_text_color();
		$background_color = $this->settings->get_background_color();
		$border_radius    = $this->settings->get_border_radius() . 'px';
		$css              .= ".woocommerce-lookbook-quickview-inner .wlb-product-wrapper.wlb-0 .wlb-product-frame{
                                border-radius:{$border_radius};
                                background-color:{$background_color};
                                color:{$text_color};
                            }";
		$css              .= ".woocommerce-lookbook-quickview-inner .wlb-product-wrapper.wlb-1 .wlb-product-frame, 
		                        .woocommerce-lookbook-quickview-inner .wlb-product-wrapper.wlb-1 .wlb-product-frame .wlb-left .wlb-lookbook-data{
                                border-radius:{$border_radius};
                            }";
		$css              .= ".woocommerce-lookbook-quickview-inner .wlb-product-wrapper.wlb-1 .wlb-product-frame .wlb-right{
                                background-color:{$background_color};
                                color:{$text_color};
                            }";

		$icon_selected = $this->settings->get_nav_icon();
		$nav_icons     = array(
			array( 'next' => 'f105', 'previous' => 'f106', 'close' => 'f101' ),
			array( 'next' => 'e900', 'previous' => 'e901', 'close' => 'f10a' ),
			array( 'next' => 'e903', 'previous' => 'e902', 'close' => 'e904' ),
		);

		$css .= ".wlb-controls .wlb-controls-next:before {content: '\\{$nav_icons[$icon_selected]['next']}';}";
		$css .= ".wlb-controls .wlb-controls-previous:before {content: '\\{$nav_icons[$icon_selected]['previous']}';}";
		$css .= ".woocommerce-lookbook-quickview .wlb-close:before {content: '\\{$nav_icons[$icon_selected]['close']}'; }";

		$custom_css = $this->settings->get_custom_css();

		if ( $custom_css ) {
			$css .= $custom_css;
		}
		wp_add_inline_style( 'woocommerce-lookbook', $css );
	}

	public function localize_script() {
//		global $wp_scripts;
//		$handles = array();
//		$src_url = [];
//		foreach ( $handles as $handle ) {
//			if ( in_array( $handle, $wp_scripts->queue ) ) {
//				$src_url[] = $wp_scripts->registered[ $handle ]->src;
//			}
//		}


		/*Node Custom CSS*/

		/*Check Add to cart redirect URL*/
		switch ( $this->settings->get_add_to_cart() ) {
			case 1:
				$redirect_url = wc_get_cart_url();
				break;
			case 2:
				$redirect_url = wc_get_checkout_url();
				break;
			default:
				$redirect_url = '';
		}
		/*Init Data look book*/
		$data_slide = array(
			'ajax_url'         => admin_url( 'admin-ajax.php' ),
			'wc_ajax_url'                => WC_AJAX::get_endpoint( "%%endpoint%%" ),
			'width'            => $this->settings->get_slide_width(),
			'height'           => $this->settings->get_slide_height(),
			'navigation'       => $this->settings->slide_navigation() ? true : false,
			'effect'           => $this->settings->slide_effect() ? 'fade' : 'slide',
			'pagination'       => $this->settings->slide_pagination() ? true : false,
			'auto'             => $this->settings->slide_auto_play() ? true : false,
			'time'             => $this->settings->get_slide_time(),
			'cols'             => $this->settings->get_slide_cols(),
			'gallery_to_slide' => $this->settings->get_gallery_to_slide_option(),
//			'modal_style'      => $this->settings->get_modal_style(),
			'redirect_url'     => $redirect_url,
//			'callbackScript'   => $src_url
		);

		wp_localize_script( 'woocommerce-lookbook', '_woocommerce_lookbook_params', $data_slide );
	}

	public function enqueue_scripts() {
		wp_enqueue_script( 'flexslider' );
		wp_enqueue_script( 'wc-single-product' );
		wp_enqueue_style( 'woocommerce-vi-flexslider' );
		wp_enqueue_script( 'jquery-slides' );
		wp_enqueue_script( 'jquery-vi-flexslider' );
		wp_enqueue_style( 'woocommerce-lookbook' );
		wp_enqueue_script( 'woocommerce-lookbook' );
		$this->get_inline_style();
		$this->localize_script();
		add_action( 'wp_footer', array( $this, 'overlay' ) );
	}

	/**
	 * @param $atts
	 */
	public function register_shortcode_instagram( $atts ) {
		$this->enqueue_scripts();

		$atts      = shortcode_atts(
			array(
				'style' => $this->settings->get_ins_display() ? 'carousel' : 'gallery',
				'row'   => $this->settings->get_ins_items_per_row(),
				'limit' => $this->settings->get_ins_display_limit(),
			), $atts
		);
		$args      = array(
			'post_type'      => 'woocommerce-lookbook',
			'post_status'    => array( 'publish' ),
			'posts_per_page' => $atts['limit'],
			'order'          => 'DESC',
			'orderby'        => 'date',
			'meta_query'     => array(
				array(
					'key'     => 'wlb_params',
					'value'   => 's:9:"instagram";s:1',
					'compare' => 'LIKE',
				),
			)
		);
		$the_query = new WP_Query( $args );
		ob_start(); ?>
        <div class="woocommerce-lookbook <?php echo $atts['style'] == 'carousel' ? 'wlb-lookbook-carousel' : 'wlb-lookbook-gallery' ?>"
             data-col="<?php echo esc_attr( $atts['row'] ) ?>" data-rtl="<?php echo is_rtl() ? 1 : 0; ?>">
            <div class="woocommerce-lookbook-inner">
				<?php if ( $the_query->have_posts() ) {
					while ( $the_query->have_posts() ) {
						$the_query->the_post();
						$id = get_the_ID();
						$attachmen_id = $this->get_data( $id, 'image' );
						$pos_x        = $this->get_data( $id, 'x' );
						$pos_y        = $this->get_data( $id, 'y' );
						$src          = wp_get_attachment_image_url( $attachmen_id, 'lookbook' );
						$products     = $this->get_data( $id, 'product_id' );
						$product_infos     = $this->get_data( $id, 'product_info' );
						$product_handle     = $this->get_data( $id, 'product_handle' );
						if ( $src ) {
							?>
                            <div class="wlb-lookbook-item-wrapper wlb-lookbook-instagram-item wlb-col-<?php echo esc_attr( $atts['row'] ) ?>">
                                <div class="wlb-lookbook-instagram-item-inner">
                                    <img src="<?php echo esc_url( $src ) ?>" class=""/>
									<?php
									if ( is_array( $products ) && count( $products ) ) {
										foreach ( $products as $k => $product ) {
                                            $product_title = $product_infos[$k];
                                            $url = $product_handle[$k];
											if ( ! $product ) {
												continue;
											}
											echo $this->get_node( $product,$product_title,$url, $pos_x[ $k ], $pos_y[ $k ] );
										}
									} ?>
                                    <div class="wlb-zoom" data-id="<?php echo esc_attr( $id ) ?>"></div>
                                </div>
                            </div>
						<?php }
					}
				}
				wp_reset_postdata();
				?>
            </div>
        </div>
		<?php $html = ob_get_clean();

		return $html;
	}

	/*
	 *
	 */

	/**
	 * Make mark on image
	 *
	 * @param $product_id
	 * @param $pos_x
	 * @param $pos_y
	 *
	 * @return mixed
	 */
	private function get_node( $product_id, $title,$url,$pos_x, $pos_y ) {

		if ( defined( 'ICL_LANGUAGE_CODE' ) ) {
			$product_id = apply_filters( 'wpml_object_id', $product_id, 'product', false, ICL_LANGUAGE_CODE );
		}

		ob_start();
		$link    = '';
//		$product = wc_get_product( $product_id );
//		if ( ! is_object( $product ) || $product->get_status() != 'publish' ) {
//			return ob_get_clean();
//		}
		if ( $this->settings->link_redirect() ) {
			//if ( $product->is_type( 'external' ) && $this->settings->external_product() ) {
				//$url = get_post_meta( $product->get_id(), '_product_url', '#' );
			    $url = 'http://google.com';
				if ( ! $url ) {
					$url = get_permalink( $product_id );
				}
				$link = '<a target="_blank" class="wlb-link" href="' . esc_url( $url ) . '"></a>';
			//}
			$class = 'wlb-redirect';
		} else {
			$class = 'wlb-ajax';
		}

		/*Make title HTML*/
		$title_html = $align_ver = $align_hor = '';

		if ( ! $this->settings->hide_title() ) {
//			$title     = get_post_field( 'post_title', $product_id );
			$align_ver = $pos_x > 50 ? 'wlb-speech-right' : 'wlb-speech-left';
			$align_hor = $pos_y > 10 ? 'wlb-speech-top' : 'wlb-speech-bottom';
			if ( $title ) {
				$title_html = '<div class="wlb-speech ' . $align_ver . ' ' . $align_hor . '"><div class="wlb-speech-bubble">' . esc_html( $title ) . '</div></div>';
			}
		}

		/*Show Node*/
		switch ( $this->settings->get_icon() ) {
			case 1:
				?>
                <div class="wlb-marker wlb-item <?php echo esc_attr( $class ) ?>"
                     data-pid="<?php echo esc_attr( $product_id ) ?>"
                     data-purl="<?php echo  $url  ?>"
                     style="left: <?php echo esc_attr( $pos_x ); ?>%;top:<?php echo esc_attr( $pos_y ) ?>%;">
					<?php echo $link ?>
                    <div class="wlb-pulse"></div>
                    <div class="wlb-dot"></div>
					<?php echo $title_html ?>
                </div>
				<?php break;
			case 2:
				?>
                <div class="wlb-item wlb-marker-pin <?php echo esc_attr( $class ) ?>"
                     data-pid="<?php echo esc_attr( $product_id ) ?>"
                     style="left: <?php echo esc_attr( $pos_x ); ?>%;top:<?php echo esc_attr( $pos_y ) ?>%;">
                    <div class="wlb-pin"><?php echo $link ?></div>
                    <div class="wlb-marker-pulse"></div>
					<?php echo $title_html ?>
                </div>
				<?php break;
			case 3:
				?>
                <div class="wlb-marker wlb-alphabet wlb-item <?php echo esc_attr( $class ) ?>"
                     data-pid="<?php echo esc_attr( $product_id ) ?>"
                     style="left: <?php echo esc_attr( $pos_x ); ?>%;top:<?php echo esc_attr( $pos_y ) ?>%;">
					<?php echo $link ?>
                    <div class="wlb-pulse"></div>
                    <div class="wlb-dot"></div>
					<?php echo $title_html ?>
                </div>
				<?php break;
			case 4:
				?>
                <div class="wlb-marker wlb-node-price wlb-item <?php echo esc_attr( $class ) ?>"
                     data-pid="<?php echo esc_attr( $product_id ) ?>"
                     style="left: <?php echo esc_attr( $pos_x ); ?>%;top:<?php echo esc_attr( $pos_y ) ?>%;">
					<?php echo $link ?>
					<?php echo '<div class="wlb-speech ' . $align_ver . '"><div class="wlb-speech-bubble">' .' $product->get_price_html()' . '</div></div>' ?>
                </div>
				<?php break;
			default:
				?>
                <div class="wlb-item wlb-default <?php echo esc_attr( $class ) ?>"
                     data-pid="<?php echo esc_attr( $product_id ) ?>"
                     style="left: <?php echo esc_attr( $pos_x ); ?>%;top:<?php echo esc_attr( $pos_y ) ?>%;"><?php echo $link ?>
                    +<?php echo $title_html ?></div>
			<?php
		}

		return ob_get_clean();
	}

	/**
	 * @param $atts
	 */
	public function register_shortcode_slide( $atts ) {

		$this->enqueue_scripts();
		$atts = shortcode_atts(
			array(
				'layout' => '',
				'id'     => '',
			), $atts
		);

		$ids = $atts['id'];
		if ( ! $ids ) {
			return false;
		}

		if ( ! $atts['layout'] ) {
			$atts['layout'] = 'carousel';
		}

		$ids = array_filter( explode( ',', trim( $ids ) ) );
		if ( count( $ids ) < 1 ) {
			return false;
		}
		$html = $class_outer = $class_inner = $class_width = '';

		if ( $atts['layout'] == 'gallery' && $this->settings->get_gallery_to_slide_option() ) {
			$loop = array( 'gallery', 'carousel' );
		} elseif ( $atts['layout'] == 'gallery' ) {
			$loop = array( 'gallery' );
		} else {
			$loop = array( 'carousel' );
		}

		if ( $atts['layout'] == 'gallery' || $atts['layout'] == 'carousel' ) {
			ob_start();
			foreach ( $loop as $key => $item ) {
				$flexible = count( $loop ) == 2 ? 'wlb-flag' : '';
				?>
                <div class="<?php echo "wlb-lookbook-{$item}-outer" ?>">
                    <div class="<?php echo "wlb-lookbook-{$item} {$flexible}" ?>">
                        <div class="wlb-lookbook-items">
							<?php foreach ( $ids as $id ) {

								$image_id = $this->get_data( $id, 'image' );

								$products = $this->get_data( $id, 'product_id' );
								$pos_x    = $this->get_data( $id, 'x' );
								$pos_y    = $this->get_data( $id, 'y' );

								$img_url = wp_get_attachment_url( $image_id );

								if ( ! $img_url ) {
									continue;
								} ?>

                                <div class="woocommerce-lookbook wlb-lookbook-item-wrapper <?php echo 'wlb-col-' . $this->settings->get_gallery_cols() ?>">
                                    <div class="woocommerce-lookbook-inner">
                                        <img src="<?php echo esc_url( $img_url ) ?>" class="wlb-image"/>
										<?php if ( count( $products ) && is_array( $products ) ) {
											foreach ( $products as $k => $product ) {

												if ( ! $product ) {
													continue;
												}

												echo $this->get_node( $product, $pos_x[ $k ], $pos_y[ $k ] );
												?>
											<?php }
										} ?>
                                        <div class="wlb-zoom" data-id="<?php echo esc_attr( $id ) ?>"></div>

                                    </div>
                                </div>
							<?php } ?>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
				<?php
			}
			$html = ob_get_clean();
		}

		return $html;

	}

	/**
	 * Shortcode HTML
	 *
	 * @param $atts
	 *
	 * @return bool|string
	 */
	public function register_shortcode( $atts ) {
		$this->enqueue_scripts();

		$atts = shortcode_atts(
			array(
				'id' => '',
			), $atts
		);

		$ids = $atts['id'];
		if ( ! $ids ) {
			return false;
		}

		$ids = array_filter( explode( ',', trim( $ids ) ) );
		if ( count( $ids ) < 1 ) {
			return false;
		}

		ob_start();

		foreach ( $ids as $id ) {
			$image_id = $this->get_data( $id, 'image' );

			$products = $this->get_data( $id, 'product_id' );
			$pos_x    = $this->get_data( $id, 'x' );
			$pos_y    = $this->get_data( $id, 'y' );

			$img_url = wp_get_attachment_url( $image_id );

			if ( ! $img_url ) {
				continue;
			} ?>
            <div class="woocommerce-lookbook wlb-show-node wlb-lookbook-item-wrapper">
                <div class="woocommerce-lookbook-inner">
                    <img src="<?php echo esc_url( $img_url ) ?>" class="wlb-image"/>
					<?php if ( is_array( $products ) && count( $products ) ) {
						foreach ( $products as $k => $product ) {
							if ( ! $product ) {
								continue;
							}
							echo $this->get_node( $product, $pos_x[ $k ], $pos_y[ $k ] );
							?>
						<?php }
					} ?>
                </div>
            </div>
            <div class="wlb-clearfix"></div>
		<?php }
		$html = ob_get_clean();

		return $html;
	}

}
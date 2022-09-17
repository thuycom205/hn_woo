<?php

/*
Class Name: WOO_LOOKBOOK_Admin_Admin
Author: Andy Ha (support@villatheme.com)
Author URI: http://villatheme.com
Copyright 2015 villatheme.com. All rights reserved.
*/
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WOO_LOOKBOOK_Admin_Admin {
	protected $settings;

	function __construct() {
		$this->settings = new WOO_LOOKBOOK_Data();
		add_filter(
			'plugin_action_links_woocommerce-lookbook/woocommerce-lookbook.php', array(
				$this,
				'settings_link'
			)
		);
		add_action( 'init', array( $this, 'init' ) );
		add_action( 'admin_menu', array( $this, 'menu_page' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ), PHP_INT_MAX );
	}


	/**
	 * Init Script in Admin
	 */
	public function admin_enqueue_scripts() {
        wp_enqueue_style( 'woocommerce-lookbook-selectizecss', WOO_LOOKBOOK_JS . 'selectize.css' );

        wp_enqueue_script( 'woocommerce-lookbook-selectize', WOO_LOOKBOOK_JS . 'selectize.js', array( 'jquery' ) );

        $page = isset( $_REQUEST['page'] ) ? $_REQUEST['page'] : '';
		if ( $page == 'woocommerce-lookbook-settings' ) {
			global $wp_scripts;
			$scripts = $wp_scripts->registered;
			//			print_r($scripts);
			foreach ( $scripts as $k => $script ) {
				preg_match( '/^\/wp-/i', $script->src, $result );
				if ( count( array_filter( $result ) ) < 1 ) {
					if ( 'query-monitor' != $script->handle ) {
						wp_dequeue_script( $script->handle );
					}
				}
			}

			/*Stylesheet*/
			wp_enqueue_style( 'woocommerce-lookbook-button', WOO_LOOKBOOK_CSS . 'button.min.css' );
			wp_enqueue_style( 'woocommerce-lookbook-table', WOO_LOOKBOOK_CSS . 'table.min.css' );
			wp_enqueue_style( 'woocommerce-lookbook-transition', WOO_LOOKBOOK_CSS . 'transition.min.css' );
			wp_enqueue_style( 'woocommerce-lookbook-form', WOO_LOOKBOOK_CSS . 'form.min.css' );
			wp_enqueue_style( 'woocommerce-lookbook-icon', WOO_LOOKBOOK_CSS . 'icon.min.css' );
			wp_enqueue_style( 'woocommerce-lookbook-dropdown', WOO_LOOKBOOK_CSS . 'dropdown.min.css' );
			wp_enqueue_style( 'woocommerce-lookbook-checkbox', WOO_LOOKBOOK_CSS . 'checkbox.min.css' );
			wp_enqueue_style( 'woocommerce-lookbook-segment', WOO_LOOKBOOK_CSS . 'segment.min.css' );
			wp_enqueue_style( 'woocommerce-lookbook-menu', WOO_LOOKBOOK_CSS . 'menu.min.css' );
			wp_enqueue_style( 'woocommerce-lookbook-tab', WOO_LOOKBOOK_CSS . 'tab.css' );
			wp_enqueue_style( 'woocommerce-lookbook-admin', WOO_LOOKBOOK_CSS . 'woocommerce-lookbook-admin.css' );
			wp_enqueue_style( 'select2', WOO_LOOKBOOK_CSS . 'select2.min.css' );

			wp_enqueue_script( 'select2' );
			wp_enqueue_script( 'woocommerce-lookbook-transition', WOO_LOOKBOOK_JS . 'transition.min.js', array( 'jquery' ) );
			wp_enqueue_script( 'woocommerce-lookbook-dropdown', WOO_LOOKBOOK_JS . 'dropdown.js', array( 'jquery' ) );
			wp_enqueue_script( 'woocommerce-lookbook-checkbox', WOO_LOOKBOOK_JS . 'checkbox.js', array( 'jquery' ) );
			wp_enqueue_script( 'woocommerce-lookbook-tab', WOO_LOOKBOOK_JS . 'tab.js', array( 'jquery' ) );
			wp_enqueue_script( 'woocommerce-lookbook-address', WOO_LOOKBOOK_JS . 'jquery.address-1.6.min.js', array( 'jquery' ) );
			wp_enqueue_script( 'jquery-ui-sortable' );
			wp_enqueue_script( 'woocommerce-lookbook-admin', WOO_LOOKBOOK_JS . 'woocommerce-lookbook-admin.js', array( 'jquery' ) );
			/*Color picker*/
			wp_enqueue_script(
				'iris', admin_url( 'js/iris.min.js' ), array(
				'jquery-ui-draggable',
				'jquery-ui-slider',
				'jquery-touch-punch'
			), false, 1
			);

		}


	}

	/**
	 * Link to Settings
	 *
	 * @param $links
	 *
	 * @return mixed
	 */
	public function settings_link( $links ) {
		$settings_link = '<a href="edit.php?post_type=woocommerce-lookbook&page=woocommerce-lookbook-settings" title="' . __( 'Settings', 'woocommerce-lookbook' ) . '">' . __( 'Settings', 'woocommerce-lookbook' ) . '</a>';
		array_unshift( $links, $settings_link );

		return $links;
	}


	/**
	 * Function init when run plugin+
	 */
	function init() {
		/*Register post type*/

		load_plugin_textdomain( 'woocommerce-lookbook' );
		$this->load_plugin_textdomain();
		$this->register_post_type();


	}

	public function register_post_type() {
		$labels = array(
			'name'               => _x( 'WC Lookbooks', 'woocommerce-lookbook', 'woocommerce-lookbook' ),
			'singular_name'      => _x( 'WC Lookbook', 'woocommerce-lookbook', 'woocommerce-lookbook' ),
			'menu_name'          => _x( 'WC Lookbooks', 'Lookbooks', 'woocommerce-lookbook' ),
			'name_admin_bar'     => _x( 'WC Lookbook', 'Lookbook', 'woocommerce-lookbook' ),
			'add_new'            => _x( 'Add New', 'woocommerce-lookbook', 'woocommerce-lookbook' ),
			'add_new_item'       => __( 'Add New Lookbook', 'woocommerce-lookbook' ),
			'new_item'           => __( 'New Lookbook', 'woocommerce-lookbook' ),
			'edit_item'          => __( 'Edit Lookbook', 'woocommerce-lookbook' ),
			'view_item'          => __( 'View Lookbook', 'woocommerce-lookbook' ),
			'all_items'          => __( 'All Lookbooks', 'woocommerce-lookbook' ),
			'search_items'       => __( 'Search Lookbooks', 'woocommerce-lookbook' ),
			'parent_item_colon'  => __( 'Parent Lookbooks:', 'woocommerce-lookbook' ),
			'not_found'          => __( 'No books found.', 'woocommerce-lookbook' ),
			'not_found_in_trash' => __( 'No books found in Trash.', 'woocommerce-lookbook' )
		);

		$args = array(
			'labels'             => $labels,
			'description'        => __( 'Description.', 'woocommerce-lookbook' ),
			'public'             => false,
			'publicly_queryable' => false,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => false,
			'rewrite'            => array( 'slug' => 'woocommerce-lookbook' ),
			'capability_type'    => 'post',
			'has_archive'        => false,
			'hierarchical'       => false,
			'menu_position'      => 2,
			'supports'           => array( 'title' ),
			'menu_icon'          => 'dashicons-location'
		);

		register_post_type( 'woocommerce-lookbook', $args );
	}

	/**
	 * load Language translate
	 */
	public function load_plugin_textdomain() {
		$locale = apply_filters( 'plugin_locale', get_locale(), 'woocommerce-lookbook' );
		// Global + Frontend Locale
		load_textdomain( 'woocommerce-lookbook', WOO_LOOKBOOK_LANGUAGES . "woocommerce-lookbook-$locale.mo" );
		load_plugin_textdomain( 'woocommerce-lookbook', false, WOO_LOOKBOOK_LANGUAGES );
	}

	/**
	 * Register a custom menu page.
	 */
	public function menu_page() {
		add_submenu_page(
			'edit.php?post_type=woocommerce-lookbook',
			esc_html__( 'WooCommerce Lookbook Setting page', 'woocommerce-lookbook' ),
			esc_html__( 'Settings', 'woocommerce-lookbook' ),
			'edit_posts',
			'woocommerce-lookbook-settings',
			array( 'WOO_LOOKBOOK_Admin_Settings', 'page_callback' )
		);
	}

}

?>
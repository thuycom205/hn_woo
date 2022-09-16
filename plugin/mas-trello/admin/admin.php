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

class WOO_TRELLO_Admin_Admin {
	protected $settings;
    static $key = 'fc37781b415ba6e22400ce1be85d4a1d';


    function __construct() {
		$this->settings = new WOO_TRELLO_Data();
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
        wp_enqueue_style( 'woocommerce-trello-admin', WOO_TRELLO_CSS . 'mas.trello.admin.css' );
        wp_enqueue_style( 'woocommerce-trello-selectizecss', WOO_LOOKBOOK_JS . 'selectize.css' );

        wp_enqueue_script( 'woocommerce-trello-selectize', WOO_LOOKBOOK_JS . 'selectize.js', array( 'jquery' ) );

        $page = isset( $_REQUEST['page'] ) ? $_REQUEST['page'] : '';
		if ( $page == 'trello-integration-settings' ) {
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
			wp_enqueue_script( 'woocommerce-trello-admin', WOO_TRELLO_JS . 'woocommerce-trello-admin.js', array( 'jquery' ) );
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

		load_plugin_textdomain( 'woocommerce-trello' );
		$this->load_plugin_textdomain();
		$this->register_post_type();


	}

	public function register_post_type() {
		$labels = array(
			'name'               => _x( 'Trello integration setting', 'woocommerce-trello', 'woocommerce-trello' ),
			'singular_name'      => _x( 'Trello integration setting', 'woocommerce-trello', 'woocommerce-trello' ),
			'menu_name'          => _x( 'Trello integration setting', 'Lookbooks', 'woocommerce-trello' ),
			'name_admin_bar'     => _x( 'Trello integration setting', 'Lookbook', 'woocommerce-trello' ),
			'add_new'            => _x( 'Add Trello integration setting', 'woocommerce-trello', 'woocommerce-trello' ),
			'add_new_item'       => __( 'Add New Trello integration setting', 'woocommerce-trello' ),
			'new_item'           => __( 'New Trello integration setting', 'woocommerce-trello' ),
			'edit_item'          => __( 'Edit Trello integration setting', 'woocommerce-trello' ),
			'view_item'          => __( 'View Trello integration setting', 'woocommerce-trello' ),
			'all_items'          => __( 'All Trello integration setting', 'woocommerce-trello' ),
			'search_items'       => __( 'Search Trello integration setting', 'woocommerce-trello' ),
			'parent_item_colon'  => __( 'Parent Trello integration setting:', 'woocommerce-trello' ),
			'not_found'          => __( 'No Trello integration setting found.', 'woocommerce-trello' ),
			'not_found_in_trash' => __( 'No Trello integration setting found in Trash.', 'woocommerce-trello' )
		);

		$args = array(
			'labels'             => $labels,
			'description'        => __( 'Description.', 'woocommerce-trello' ),
			'public'             => false,
			'publicly_queryable' => false,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => false,
			'rewrite'            => array( 'slug' => 'woocommerce-trello' ),
			'capability_type'    => 'post',
			'has_archive'        => false,
			'hierarchical'       => false,
			'menu_position'      => 2,
			'supports'           => array( 'title' ),
			'menu_icon'          => 'dashicons-update'
		);

		register_post_type( 'woocommerce-trello', $args );
	}

	/**
	 * load Language translate
	 */
	public function load_plugin_textdomain() {
		$locale = apply_filters( 'plugin_locale', get_locale(), 'woocommerce-trello' );
		// Global + Frontend Locale
		load_textdomain( 'woocommerce-trello', WOO_LOOKBOOK_LANGUAGES . "woocommerce-trello-$locale.mo" );
		load_plugin_textdomain( 'woocommerce-trello', false, WOO_LOOKBOOK_LANGUAGES );
	}

	/**
	 * Register a custom menu page.
	 */
	public function menu_page() {

        add_submenu_page(
			'edit.php?post_type=woocommerce-trello',
			esc_html__( 'WooCommerce Lookbook Setting page', 'woocommerce-trello' ),
			esc_html__( 'Settings', 'woocommerce-trello' ),
			'edit_posts',
			'trello-integration-settings',
			array( 'WOO_TRELLO_Admin_Settings', 'page_callback' )
		);
        add_submenu_page(
			'edit.php?post_type=woocommerce-trello',
			esc_html__( 'test', 'woocommerce-trello' ),
			esc_html__( 'test', 'woocommerce-trello' ),
			'edit_posts',
			'trello-integration-settings-test',
			array( 'WOO_TRELLO_Admin_Admin', 'test' )
		);
	}

    public function test() {
       $o = self::getting_all_trello_boards('c23c6abb9097558aead148f4c86656cc5c3fcbe2be5317d563a36ada3aefe5b3');
        return $o;
    }
    public function getting_all_trello_boards($token=''){
        if (empty($token)) {
            return;
        }

        $key = self::$key ;
        $url = 'https://api.trello.com/1/members/me/boards?&filter=open&key='.$key.'&token='.$token.'';

        $trello_returns = wp_remote_get( $url , array());
        $boards = array();

        if ($trello_returns['response']['code'] == 200) {
            foreach (json_decode($trello_returns['body'] , true) as $key => $value) {
                $boards[$value['id']] = $value['name'];
            }
        }else{
            # Error Log
        }
        return array( $trello_returns['response']['code'] , $boards );
    }

    # Gatting Lists
    public function bptc_gatting_spacific_board_lists( $token='', $board_id=''){
        if (empty($token) || empty($board_id)) {
            return;
        }
        $key = $this->key ;
        $url = 'https://api.trello.com/1/boards/'.$board_id.'/lists?filter=open&key='.$key.'&token='.$token.'';

        $trello_returns = wp_remote_get( $url , array());
        $lists = array();

        if ($trello_returns['response']['code'] == 200) {
            foreach (json_decode($trello_returns['body'] , true) as $key => $value) {
                $lists[$value['id']] = $value['name'];
            }
        }else{
            # Error Log

        }

        return array( $trello_returns['response']['code'] , $lists );
    }

}

?>
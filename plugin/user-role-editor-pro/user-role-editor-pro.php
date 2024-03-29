<?php
/*
Plugin Name: User Role Editor Pro
Plugin URI: https://www.role-editor.com
Description: Change/add/delete WordPress user roles and capabilities.
Version: 4.60
Author: Vladimir Garagulia
Author URI: https://www.role-editor.com
Text Domain: user-role-editor
Domain Path: /lang/
*/

/*
 Copyright 2010-2021  Vladimir Garagulia  (email: support@role-editor.com)
*/

if ( ! function_exists( 'get_option' ) ) {
  header( 'HTTP/1.0 403 Forbidden' );
  die;  // Silence is golden, direct call is prohibited
}

if ( defined( 'URE_PLUGIN_URL') ) {
   wp_die( 'It seems that other version of User Role Editor is active. Please deactivate it before use this version' );
}
    
define( 'URE_VERSION', '4.60' );
define( 'URE_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'URE_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'URE_PLUGIN_BASE_NAME', plugin_basename( __FILE__ ) );
define( 'URE_PLUGIN_FILE', basename( __FILE__ ) );
define( 'URE_PLUGIN_FULL_PATH', __FILE__ );
define( 'URE_UPDATE_URL', 'https://update.role-editor.com' );

require_once( URE_PLUGIN_DIR .'includes/classes/base-lib.php' );
require_once( URE_PLUGIN_DIR .'includes/classes/lib.php' );
require_once( URE_PLUGIN_DIR .'pro/includes/classes/lib-pro.php' );

// check PHP version
$ure_required_php_version = '5.6';
$exit_msg = 'User Role Editor requires PHP '. $ure_required_php_version .' or newer. '. 
            '<a href="http://wordpress.org/about/requirements/">Please update!</a>';
URE_Lib_Pro::check_version( PHP_VERSION, $ure_required_php_version, $exit_msg, __FILE__ );

// check WP version
$ure_required_wp_version = '4.4';
$exit_msg = 'User Role Editor requires WordPress '. $ure_required_wp_version .' or newer. '. 
            '<a href="http://codex.wordpress.org/Upgrading_WordPress">Please update!</a>';
URE_Lib::check_version( get_bloginfo( 'version' ), $ure_required_wp_version, $exit_msg, __FILE__ );

require_once( URE_PLUGIN_DIR .'includes/loader.php' );
require_once( URE_PLUGIN_DIR .'pro/includes/loader.php' );

// Uninstall action
register_uninstall_hook( URE_PLUGIN_FULL_PATH, array('User_Role_Editor_Pro', 'uninstall') );

$GLOBALS['user_role_editor'] = User_Role_Editor_Pro::get_instance();

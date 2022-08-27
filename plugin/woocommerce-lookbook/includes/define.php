<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
define( 'WOO_LOOKBOOK_DIR', WP_PLUGIN_DIR . DIRECTORY_SEPARATOR . "woocommerce-lookbook" . DIRECTORY_SEPARATOR );
define( 'WOO_LOOKBOOK_ADMIN', WOO_LOOKBOOK_DIR . "admin" . DIRECTORY_SEPARATOR );
define( 'WOO_LOOKBOOK_FRONTEND', WOO_LOOKBOOK_DIR . "frontend" . DIRECTORY_SEPARATOR );
define( 'WOO_LOOKBOOK_LANGUAGES', WOO_LOOKBOOK_DIR . "languages" . DIRECTORY_SEPARATOR );
define( 'WOO_LOOKBOOK_INCLUDES', WOO_LOOKBOOK_DIR . "includes" . DIRECTORY_SEPARATOR );
define( 'WOO_LOOKBOOK_TEMPLATES', WOO_LOOKBOOK_DIR . "templates" . DIRECTORY_SEPARATOR );

$plugin_url = plugins_url( 'woocommerce-lookbook' );
$plugin_url = str_replace( '/includes', '', $plugin_url );
define( 'WOO_LOOKBOOK_CSS', $plugin_url . "/css/" );
define( 'WOO_LOOKBOOK_CSS_DIR', WOO_LOOKBOOK_DIR . "css" . DIRECTORY_SEPARATOR );
define( 'WOO_LOOKBOOK_JS', $plugin_url . "/js/" );
define( 'WOO_LOOKBOOK_JS_DIR', WOO_LOOKBOOK_DIR . "js" . DIRECTORY_SEPARATOR );
define( 'WOO_LOOKBOOK_IMAGES', $plugin_url . "/images/" );


/*Include functions file*/
if ( is_file( WOO_LOOKBOOK_INCLUDES . "data.php" ) ) {
	require_once WOO_LOOKBOOK_INCLUDES . "data.php";
}

if ( is_file( WOO_LOOKBOOK_INCLUDES . "functions.php" ) ) {
	require_once WOO_LOOKBOOK_INCLUDES . "functions.php";
}
/*Include functions file*/
if ( is_file( WOO_LOOKBOOK_INCLUDES . "check_update.php" ) ) {
	require_once WOO_LOOKBOOK_INCLUDES . "check_update.php";
}
if ( is_file( WOO_LOOKBOOK_INCLUDES . "update.php" ) ) {
	require_once WOO_LOOKBOOK_INCLUDES . "update.php";
}
if ( is_file( WOO_LOOKBOOK_INCLUDES . "support.php" ) ) {
	require_once WOO_LOOKBOOK_INCLUDES . "support.php";
}

if ( is_file( WOO_LOOKBOOK_INCLUDES . "elementor/elementor.php" ) ) {
	require_once WOO_LOOKBOOK_INCLUDES . "elementor/elementor.php";
}

if ( is_file( WOO_LOOKBOOK_INCLUDES . "facebook-sdk/autoload.php" ) ) {
	require_once WOO_LOOKBOOK_INCLUDES . "facebook-sdk/autoload.php";
}

if ( is_file( WOO_LOOKBOOK_INCLUDES . "instagram.php" ) ) {
	require_once WOO_LOOKBOOK_INCLUDES . "instagram.php";
}

vi_include_folder( WOO_LOOKBOOK_ADMIN, 'WOO_LOOKBOOK_Admin_' );
vi_include_folder( WOO_LOOKBOOK_FRONTEND, 'WOO_LOOKBOOK_Frontend_' );

new VillaTheme_Support_Pro(
	array(
		'support'   => 'https://villatheme.com/supports/forum/plugins/woocommerce-lookbook/',
		'docs'      => 'http://docs.villatheme.com/?item=woocommerce-lookbook',
		'review'    => 'https://codecanyon.net/downloads',
		'css'       => WOO_LOOKBOOK_CSS,
		'image'     => WOO_LOOKBOOK_IMAGES,
		'slug'      => 'woocommerce-lookbook',
		'menu_slug' => 'edit.php?post_type=woocommerce-lookbook',
		'version'   => WOO_LOOKBOOK_VERSION
	)
);
<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
define( 'WOO_TRELLO_DIR', WP_PLUGIN_DIR . DIRECTORY_SEPARATOR . "mas-trello" . DIRECTORY_SEPARATOR );
define( 'WOO_TRELLO_ADMIN', WOO_TRELLO_DIR . "admin" . DIRECTORY_SEPARATOR );
define( 'WOO_TRELLO_FRONTEND', WOO_TRELLO_DIR . "frontend" . DIRECTORY_SEPARATOR );
define( 'WOO_TRELLO_LANGUAGES', WOO_TRELLO_DIR . "languages" . DIRECTORY_SEPARATOR );
define( 'WOO_TRELLO_INCLUDES', WOO_TRELLO_DIR . "includes" . DIRECTORY_SEPARATOR );
define( 'WOO_TRELLO_TEMPLATES', WOO_TRELLO_DIR . "templates" . DIRECTORY_SEPARATOR );

$plugin_url = plugins_url( 'mas-trello' );
$plugin_url = str_replace( '/includes', '', $plugin_url );
define( 'WOO_TRELLO_CSS', $plugin_url . "/css/" );
define( 'WOO_TRELLO_CSS_DIR', WOO_TRELLO_DIR . "css" . DIRECTORY_SEPARATOR );
define( 'WOO_TRELLO_JS', $plugin_url . "/js/" );
define( 'WOO_TRELLO_JS_DIR', WOO_TRELLO_DIR . "js" . DIRECTORY_SEPARATOR );
define( 'WOO_TRELLO_IMAGES', $plugin_url . "/images/" );


/*Include functions file*/
if ( is_file( WOO_TRELLO_INCLUDES . "data.php" ) ) {
	require_once WOO_TRELLO_INCLUDES . "data.php";
}
if ( is_file( WOO_TRELLO_INCLUDES . "Utils.php" ) ) {
	require_once WOO_TRELLO_INCLUDES . "Utils.php";
}

if ( is_file( WOO_TRELLO_INCLUDES . "functions.php" ) ) {
	require_once WOO_TRELLO_INCLUDES . "functions.php";
}
/*Include functions file*/
if ( is_file( WOO_TRELLO_INCLUDES . "check_update.php" ) ) {
	require_once WOO_TRELLO_INCLUDES . "check_update.php";
}
if ( is_file( WOO_TRELLO_INCLUDES . "update.php" ) ) {
	require_once WOO_TRELLO_INCLUDES . "update.php";
}
if ( is_file( WOO_TRELLO_INCLUDES . "support.php" ) ) {
	require_once WOO_TRELLO_INCLUDES . "support.php";
}

if ( is_file( WOO_TRELLO_INCLUDES . "elementor/elementor.php" ) ) {
	require_once WOO_TRELLO_INCLUDES . "elementor/elementor.php";
}

//if ( is_file( WOO_TRELLO_INCLUDES . "facebook-sdk/autoload.php" ) ) {
//	require_once WOO_TRELLO_INCLUDES . "facebook-sdk/autoload.php";
//}
//
//if ( is_file( WOO_TRELLO_INCLUDES . "instagram.php" ) ) {
//	require_once WOO_TRELLO_INCLUDES . "instagram.php";
//}

recursive_include_folder( WOO_TRELLO_ADMIN, 'WOO_TRELLO_Admin_' );
recursive_include_folder( WOO_TRELLO_FRONTEND, 'WOO_TRELLO_Frontend_' );


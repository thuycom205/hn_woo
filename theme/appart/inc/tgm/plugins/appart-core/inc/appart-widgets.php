<?php 


if ( !function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}

include( plugin_dir_path( __FILE__ ) . '/widgets/Appart_about_us.php' );
include( plugin_dir_path( __FILE__ ) . '/widgets/Appart_contact_info.php' );
include( plugin_dir_path( __FILE__ ) . '/widgets/Appart_social_sites.php' );
include( plugin_dir_path( __FILE__ ) . '/widgets/Appart_recent_posts.php' );

function appart_register_widgets() {
	register_widget( 'Appart_about_us' );
	register_widget( 'Appart_contact_info' );
	register_widget( 'Appart_social_sites' );
	register_widget( 'Appart_recent_posts' );
}
add_action( 'widgets_init', 'appart_register_widgets' );

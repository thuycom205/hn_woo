<?php

require_once( plugin_dir_path( __FILE__ ) . 'twitter-slider-widget.php' );

if ( is_admin() ) {
	require_once( plugin_dir_path( __FILE__ ) . 'twitter-widget-settings.php' );
}

add_action( 'widgets_init', function () {
    register_widget( 'Appland_twitter_widget' );
});

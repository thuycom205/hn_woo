<?php
require_once get_theme_file_path('/inc/class-tgm-plugin-activation.php');
add_action( 'tgmpa_register', 'acrony_register_required_plugins' );
function acrony_register_required_plugins() {
	$plugins = array(
        
		// Add CMB2 plugin. Userd for Create Extra New Field in .
		array(
			'name'      => 'CMB2',
			'slug'      => 'cmb2',
			'required'  => true,
		),        
		array(
			'name'      => 'Acrony Core',
            'slug'      => 'acrony-core',
            'source'    => get_theme_file_path('/lib/plugins/acrony-core.zip'),
            'required'  => true,
            'version'   => '1.0.0'
		),     
		array(
			'name'      => 'Revolution Slider',
            'slug'      => 'revslider',
            'source'    => get_theme_file_path('/lib/plugins/revslider.zip'),
            'required'  => false,
            'version'   => '1.0.0'
		),
        array(
            'name'      => 'MailChimp for WordPress',
            'slug'      => 'mailchimp-for-wp',
            'required'  => false
        ),
        array(
            'name'      => 'Easy Google Fonts',
            'slug'      => 'easy-google-fonts',
            'required'  => false
        ),
        array(
            'name'      => 'One Click Demo Import',
            'slug'      => 'unyson',
            'required'  => false
        ),
        array(
            'name'      => 'KingComposer Page Builder',
            'slug'      => 'kingcomposer',
            'required'  => false
        ),
        array(
            'name'      => 'Contact Form 7',
            'slug'      => 'contact-form-7',
            'required'  => false
        ),
        array(
            'name'      => 'Envato Toolkit',
            'slug'      => 'toolkit-for-envato',
            'required'  => false
        ),
        array(
            'name'      => 'Classic Editor',
            'slug'      => 'classic-editor',
            'required'  => false
        ),
        array(
            'name'      => 'WooCommerce',
            'slug'      => 'woocommerce',
            'required'  => false
        )
        
	);

	$config = array(
		'id'           => 'acrony',
		'default_path' => '',
		'menu'         => 'tgmpa-install-plugins',
		'has_notices'  => true,
		'dismissable'  => true,
		'dismiss_msg'  => '',
		'is_automatic' => false,
		'message'      => '',
	);

	tgmpa( $plugins, $config );
}
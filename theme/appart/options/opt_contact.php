<?php
// Contact page settings
Redux::setSection('appart_opt', array(
    'title'     => esc_html__('Contact Page', 'appart'),
    'id'        => 'appart_contact_opt',
    'icon'      => 'dashicons dashicons-email-alt',
    'fields'    => array(
        array(
            'title'     => esc_html__('Information boxes', 'appart'),
            'subtitle'  => esc_html__('Add here top information boxes in three column format.', 'appart'),
            'id'        => 'information_boxes',
            'class'     => 'information_boxes',
            'type'      => 'slides',
            'content_title' => esc_html__('Information box', 'appart'),
            'placeholder' => array(
                'title'           => esc_html__('Enter Title Here ', 'appart'),
                'description'     => esc_html__('Enter Information Here', 'appart'),
            ),
            'show' => array(
            	'url' => false,
                'title' => true,
                'description' => true,
            )
        ),
    )
));


// Contact form settings
Redux::setSection('appart_opt', array(
    'title'     => esc_html__('Contact Form', 'appart'),
    'id'        => 'appart_contact_form',
    'icon'      => 'dashicons dashicons-feedback',
    'subsection'=> true,
    'fields'    => array(
        array(
            'title'     => esc_html__('Contact form title ', 'appart'),
            'id'        => 'contact_form_title',
            'type'      => 'text',
            'default'   => 'Leave a Message'
        ),
        array(
            'title'     => esc_html__('Contact form shortcode ', 'appart'),
            'subtitle'  => esc_html__('Generate the contact form with Contact Form 7 plugin then enter here the form shortcode.', 'appart'),
            'id'        => 'contact_form_shortcode',
            'type'      => 'text',
        ),
        array(
            'title'     => esc_html__('How to use theme\'s contact form?', 'appart'),
            'desc'      => appart_wp_kses(__('Install and activate the Contact Form 7 plugin from Appearance > Install Plugins. You can get the contact form templates from <a href="https://goo.gl/PHGNG2" target="_blank">here</a>', 'appart')),
            'id'        => 'contact_form_info',
            'type'      => 'info',
            'style'     => 'warning',
            'icon'      => 'dashicons dashicons-info',
        ),
        array(
            'title'     => esc_html__('How to use Google re-capcha in your contact form?', 'appart'),
            'desc'      => esc_html__('Install and activate the Contact Form recaptcha plugin from Appearance > Install Plugins and configure it with your recaptcha keys.', 'appart'),
            'id'        => 'contact_form_recaptcha_info',
            'type'      => 'info',
            'style'     => 'warning',
            'icon'      => 'dashicons dashicons-info',
        ),
    )
));

// Map settings
Redux::setSection('appart_opt', array(
    'title'     => esc_html__('Map Settings', 'appart'),
    'id'        => 'map_settings',
    'icon'      => 'dashicons dashicons-chart-area',
    'subsection'=> true,
    'fields'    => array(
    	 array(
            'title'     => esc_html__('Map', 'appart'),
            'subtitle'  => esc_html__('Show/hide the Google map on contact page.', 'appart'),
            'id'        => 'is_google_map',
            'type'      => 'switch',
            'on'		=> esc_html__('Show', 'appart'),
            'off'		=> esc_html__('Hide', 'appart'),
        ),
        array(
            'title'     => esc_html__('Map API key', 'appart'),
            'subtitle'  => appart_wp_kses(__('Enter her your Google map API key. Get it from <a href="https://developers.google.com/maps/documentation/javascript/get-api-key">here</a>', 'appart')),
            'id'        => 'map_api',
            'type'      => 'text',
            'default'   => 'AIzaSyBumN1FxU0vF8HVI_qy9yFlwcZ4Wop_RtY',
            'required'  => array('is_google_map', '=', true)
        ),
        array(
            'title'     => esc_html__('Map latitude key', 'appart'),
            'subtitle'  => appart_wp_kses(__('Get the latitude from <a href="https://www.latlong.net/">here</a>', 'appart')),
            'id'        => 'latitude',
            'type'      => 'text',
            'default'   => '42.008315',
            'required'  => array('is_google_map', '=', true)
        ),
        array(
            'title'     => esc_html__('Map Longitude key', 'appart'),
            'subtitle'  => appart_wp_kses(__('Get the Longitude from <a href="https://www.latlong.net/">here</a>', 'appart')),
            'id'        => 'longitude',
            'type'      => 'text',
            'default'   => '-88.163807',
            'required'  => array('is_google_map', '=', true)
        ),
        array(
            'title'     => esc_html__('Map zoom label', 'appart'),
            'id'        => 'map_zoom',
            'type'      => 'slider',
            'default'       => 12,
            'min'           => 2,
            'step'          => 1,
            'max'           => 100,
            'display_value' => 'label',
            'required'  => array('is_google_map', '=', true)
        ),
        array(
            'title'     => esc_html__('Map marker', 'appart'),
            'id'        => 'map_marker',
            'type'      => 'media',
            'compiler'  => true,
            'default'   => array(
                'url'   => APPART_DIR_IMG.'/map_marker.png'
            ),
            'required'  => array('is_google_map', '=', true)
        ),
    )
));
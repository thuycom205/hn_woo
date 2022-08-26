<?php

Redux::setSection('appart_opt', array(
    'title'     => esc_html__('404 Error Page', 'appart'),
    'id'        => '404_0pt',
    'icon'      => 'dashicons dashicons-info',
    'fields'    => array(
        array(
            'title'     => esc_html__('Error Heading Text', 'appart'),
            'id'        => 'error_heading',
            'type'      => 'text',
            'default'   => esc_html__("404", 'appart')
        ),
        array(
            'title'     => esc_html__('Title', 'appart'),
            'id'        => 'error_title',
            'type'      => 'text',
            'default'   => esc_html__("Oops, This Page Could Not Be Found!", 'appart')
        ),
        array(
            'title'     => esc_html__('Subtitle', 'appart'),
            'id'        => 'error_subtitle',
            'type'      => 'text',
            'default'   => esc_html__("We can't seem to find the page you're looking for", 'appart')
        ),
        array(
            'title'     => esc_html__('Home button label', 'appart'),
            'id'        => 'error_home_btn_label',
            'type'      => 'text',
            'default'   => esc_html__("Back to home", 'appart')
        ),
        array(
            'title'     => esc_html__('Background Image', 'appart'),
            'id'        => '404_bg',
            'type'      => 'media',
        ),
    )
));

<?php
// Shop page
Redux::setSection('appart_opt', array(
    'title'            => esc_html__( 'Shop Settings', 'appart' ),
    'id'               => 'shop_opt',
    'icon'             => 'dashicons dashicons-cart',
    'fields'           => array(
        array(
            'title'     => esc_html__('Cart Icon', 'appart'),
            'subtitle'  => esc_html__('Show/Hide cart icon on the header (besides menu item).', 'appart'),
            'id'        => 'is_cart_icon',
            'type'      => 'switch',
            'on'        => esc_html__('Show', 'appart'),
            'off'       => esc_html__('Hide', 'appart'),
        ),
        array(
            'title'     => esc_html__('Sidebar', 'appart'),
            'subtitle'  => esc_html__('Select the sidebar position of Shop page. And remove the Shop sidebar widgets to make the Shop page full-width', 'appart'),
            'id'        => 'shop_sidebar',
            'type'      => 'image_select',
            'options'   => array(
                'left' => array(
                    'alt' => esc_html__('Left Sidebar', 'appart'),
                    'img' => APPART_DIR_IMG.'/layouts/sidebar_left.jpg'
                ),
                'right' => array(
                    'alt' => esc_html__('Right Sidebar', 'appart'),
                    'img' => APPART_DIR_IMG.'/layouts/sidebar_right.jpg',
                ),
            ),
            'default' => 'left'
        ),
         array(
            'title'     => esc_html__('Header Title ', 'appart'),
            'id'        => 'shop_title',
            'type'      => 'text',
            'default'   => 'Shop Page'
        ),
          array(
            'title'     => esc_html__('Header Subtitle ', 'appart'),
            'id'        => 'shop_subtitle',
            'type'      => 'textarea',
            'default'   => 'Do you have any project that you need get going?'
        ),
          array(
            'title'     => esc_html__('Header Background Image', 'appart'),
            'id'        => 'shop_bg_image',
            'type'      => 'media',
            'compiler'  => true
        ),
    ),
));
<?php

// Header Section
Redux::setSection('appart_opt', array(
    'title'            => esc_html__( 'Header Settings', 'appart' ),
    'id'               => 'header_sec',
    'customizer_width' => '400px',
    'icon'             => 'el el-home'
) );


Redux::setSection('appart_opt', array(
    'title'            => esc_html__( 'Logo settings', 'appart' ),
    'id'               => 'logo_opt',
    'subsection'       => true,
    'icon'             => 'dashicons dashicons-schedule',
    'fields'           => array(
        array(
            'title'     => esc_html__('Upload logo', 'appart'),
            'subtitle'  => esc_html__( 'Upload here a image file for your logo', 'appart' ),
            'id'        => 'main_logo',
            'type'      => 'media',
            'compiler'  => true,
            'default'  => array(
                'url'   => APPART_DIR_IMG.'/logo.png'
            )
        ),
        array(
            'title'     => esc_html__('Sticky header logo', 'appart'),
            'id'        => 'sticky_logo',
            'type'      => 'media',
            'compiler'  => true,
            'default'   => array(
                'url'   => APPART_DIR_IMG.'/logo-dk.png'
            )
        ),
        array(
            'title'     => esc_html__('Logo dimensions', 'appart'),
            'subtitle'  => esc_html__( 'Set a custom height width for your upload logo.', 'appart' ),
            'id'        => 'logo_dimensions',
            'type'      => 'dimensions',
            'units'     => array('em','px','%'),
            'output'    => '.navbar-brand>img'
        ),
        array(
            'title'     => esc_html__('Padding', 'appart'),
            'subtitle'  => esc_html__('Padding around the logo. Input the padding as clockwise (Top Right Bottom Left)', 'appart'),
            'id'        => 'logo_padding',
            'type'      => 'spacing',
            'output'    => array( '.navbar-brand' ),
            'mode'      => 'padding',
            'units'     => array( 'em', 'px', '%' ),      // You can specify a unit value. Possible: px, em, %
            'units_extended' => 'true',
            'default'   => array(
                'padding-top'    => '0px',
                'padding-right'  => '0px',
                'padding-bottom' => '0px',
                'padding-left'   => '0px'
            )
        ),
    )
) );

// Navbar styling
Redux::setSection('appart_opt', array(
    'title'            => esc_html__( 'Menu Styling', 'appart' ),
    'id'               => 'navbar_styling',
    'subsection'       => true,
    'icon'             => 'dashicons dashicons-schedule',
    'fields'           => array(
        array(
            'title'     => esc_html__('Navbar box layout', 'appart'),
            'id'        => 'navbar_layout',
            'type'      => 'button_set',
            'default'   => 'boxed',
            'options'   => array(
                'boxed' => esc_html__('Boxed', 'appart'),
                'full_width' => esc_html__('Stretched (Full Width)', 'appart'),
            )
        ),
        array(
            'title'     => esc_html__('Menu font properties', 'appart'),
            'id'        => 'menu_font_typo',
            'type'      => 'typography',
            'default'  => array(
                'font-family'   => 'Poppins',
                'font-weight'   => '400',
                'color'         => '#fff',
                'font-size'     => '14px',
            ),
            'output'  => '.navbar-expand-lg.navbar .navbar-nav li > a'
        ),
        array(
            'title'     => esc_html__('Sticky menu color', 'appart'),
            'subtitle'  => esc_html__('Menu item font color on sticky menu mode.', 'appart'),
            'id'        => 'sticky_menu_font_color',
            'output'    => array('.navbar-expand-lg.navbar.shrink .navbar-nav .nav-item a'),
            'type'      => 'color',
            'default'   => '#000'
        ),
        array(
            'title'     => esc_html__('Sticky menu background color', 'appart'),
            'id'        => 'sticky_menu_bg_color',
            'output'    => array('.navbar-expand-lg.navbar.shrink'),
            'type'      => 'color',
            'mode'      => 'background',
        ),
        array(
            'title'     => esc_html__('Menu item padding', 'appart'),
            'subtitle'  => esc_html__('Padding around the each menu item.', 'appart'),
            'id'        => 'menu_item_padding',
            'type'      => 'spacing',
            'output'    => array( '.navbar .navbar-nav .menu-item' ),
            'mode'      => 'margin',
            'units'     => array( 'em', 'px', '%' ),      // You can specify a unit value. Possible: px, em, %
            'units_extended' => 'true',
            'default'   => array(
                'margin-top'    => '0px',
                'margin-right'  => '40px',
                'margin-bottom' => '0px',
                'margin-left'   => '0px'
            )
        ),
    )
));

// Menu action button
Redux::setSection('appart_opt', array(
    'title'            => esc_html__( 'Menu Action Button', 'appart' ),
    'id'               => 'menu_action_btn_opt',
    'subsection'       => true,
    'icon'             => 'dashicons dashicons-minus',
    'fields'           => array(
        array(
            'title'     => esc_html__('Show/hide button', 'appart'),
            'subtitle'  => esc_html__('Toggle this switcher to show or hide the menu action button.', 'appart'),
            'id'        => 'is_menu_action_btn',
            'type'      => 'switch',
            'on'        => esc_html__('Show', 'appart'),
            'off'       => esc_html__('Hide', 'appart'),
        ),
        array(
            'title'     => esc_html__('Label', 'appart'),
            'subtitle'  => esc_html__('Leave the button label field empty to hide the menu action button.', 'appart'),
            'id'        => 'menu_btn_label',
            'type'      => 'text',
            'default'   => 'Get Started',
        ),
        array(
            'title'     => esc_html__('URL', 'appart'),
            'id'        => 'menu_btn_url',
            'type'      => 'text',
            'default'   => '#',
        ),

        array(
            'title'     => esc_html__('Button font properties', 'appart'),
            'id'        => 'menu_btn_typo',
            'type'      => 'typography',
            'output'    => '.get-btn',
            'color'     => false,
            'default'  => array(
                'font-family'   => 'Poppins',
                'font-weight'   => '400',
                'font-size'     => '14px',
            ),
        ),
        array(
            'title'     => esc_html__('Button padding', 'appart'),
            'subtitle'  => esc_html__('Padding around the menu action button.', 'appart'),
            'id'        => 'menu_btn_padding',
            'type'      => 'spacing',
            'output'    => array( '.get-btn, .nav_fluid .get-btn' ),
            'mode'      => 'padding',
            'units'     => array( 'em', 'px', '%' ),  // You can specify a unit value. Possible: px, em, %
            'units_extended' => 'true',
            'default'   => array(
                'padding-top'    => '15px',
                'padding-right'  => '28px',
                'padding-bottom' => '15px',
                'padding-left'   => '28px'
            ),
        ),

        /**
         * Button colors
         * Style will apply on the Non sticky mode and sticky mode of the header
         */
        array(
            'title'     => esc_html__('Button Colors', 'appart'),
            'subtitle'  => esc_html__('Button colors on non sticky mode.', 'appart'),
            'id'        => 'button_colors',
            'type'      => 'section',
            'indent'    => true
        ),
        array(
            'title'     => esc_html__('Font color', 'appart'),
            'id'        => 'menu_btn_font_color',
            'type'      => 'color',
            'output'    => array('.get-btn, .nav_fluid .get-btn'),
        ),
        array(
            'title'     => esc_html__('Background color', 'appart'),
            'id'        => 'menu_btn_bg_color',
            'type'      => 'color',
            'mode'      => 'background',
            'output'    => array('.get-btn, .nav_fluid .get-btn'),
        ),

        // Button color on hover stats
        array(
            'title'     => esc_html__('Hover font color', 'appart'),
            'subtitle'  => esc_html__('Font color on hover stats.', 'appart'),
            'id'        => 'menu_btn_hover_font_color',
            'type'      => 'color',
            'output'    => array('.get-btn:hover, .nav_fluid .get-btn:hover'),
        ),
        array(
            'title'     => esc_html__('Hover background color', 'appart'),
            'subtitle'  => esc_html__('Background color on hover stats.', 'appart'),
            'id'        => 'menu_btn_hover_bg_color',
            'type'      => 'color',
            'mode'      => 'background',
            'output'    => array('.get-btn:hover, .nav_fluid .get-btn:hover'),
        ),

        array(
            'id'     => 'button_colors-end',
            'type'   => 'section',
            'indent' => false,
        ),

        /*
         * Button colors on sticky mode
         */
        array(
            'title'     => esc_html__('Sticky Button Style', 'appart'),
            'subtitle'  => esc_html__('Button colors on sticky mode.', 'appart'),
            'id'        => 'button_colors_sticky',
            'type'      => 'section',
            'indent'    => true
        ),
        array(
            'title'     => esc_html__('Border color', 'appart'),
            'id'        => 'menu_btn_border_color_sticky',
            'type'      => 'color',
            'mode'      => 'border-color',
            'output'    => array('nav#fixed-top.shrink .get-btn, nav#fixed-top.shrink.nav_fluid .get-btn'),
        ),
        array(
            'title'     => esc_html__('Font color', 'appart'),
            'id'        => 'menu_btn_font_color_sticky',
            'type'      => 'color',
            'output'    => array('nav#fixed-top.shrink .get-btn, nav#fixed-top.shrink.nav_fluid .get-btn'),
        ),
        array(
            'title'     => esc_html__('Background color', 'appart'),
            'id'        => 'menu_btn_bg_color_sticky',
            'type'      => 'color',
            'mode'      => 'background',
            'output'    => array('nav#fixed-top.shrink .get-btn, nav#fixed-top.shrink.nav_fluid .get-btn'),
        ),
        // Button color on hover stats
        array(
            'title'     => esc_html__('Hover font color', 'appart'),
            'subtitle'  => esc_html__('Font color on hover stats.', 'appart'),
            'id'        => 'menu_btn_hover_font_color_sticky',
            'type'      => 'color',
            'output'    => array('nav#fixed-top.shrink .get-btn:hover, nav#fixed-top.shrink.nav_fluid .get-btn:hover'),
        ),
        array(
            'title'     => esc_html__('Hover background color', 'appart'),
            'subtitle'  => esc_html__('Background color on hover stats.', 'appart'),
            'id'        => 'menu_btn_hover_bg_color_sticky',
            'type'      => 'color',
            'output'    => array(
                'background' => 'nav#fixed-top.shrink .get-btn:hover, nav#fixed-top.shrink.nav_fluid .get-btn:hover',
                'border-color' => 'nav#fixed-top.shrink .get-btn:hover, nav#fixed-top.shrink.nav_fluid .get-btn:hover',
            ),
        ),

        array(
            'id'     => 'button_colors-sticky-end',
            'type'   => 'section',
            'indent' => false,
        ),
    )
));

// Title-bar
Redux::setSection('appart_opt', array(
    'title'            => esc_html__( 'Title-bar', 'appart' ),
    'id'               => 'title_bar_opt',
    'subsection'       => true,
    'icon'             => 'dashicons dashicons-schedule',
    'fields'           => array(
        array(
            'title'     => esc_html__('Title-bar overlay color', 'appart'),
            'id'        => 'title_bar_overlay_color',
            'type'      => 'color_rgba',
            'mode'      => 'background',
            'default'   => array(
                'color' => '#000000',
                'alpha' => '.35'
            ),
            'output'    => array('.banner-area:before')
        ),
        array(
            'title'     => esc_html__('Title-bar padding', 'appart'),
            'id'        => 'title_bar_padding',
            'type'      => 'spacing',
            'output'    => array( '.banner-area' ),
            'mode'      => 'padding',
            'units'     => array( 'em', 'px', '%' ),      // You can specify a unit value. Possible: px, em, %
            'units_extended' => 'true',
            'default'   => array(
                'padding-top'    => '240px',
                'padding-right'  => '0px',
                'padding-bottom' => '187px',
                'padding-left'   => '0px'
            )
        ),
    )
));
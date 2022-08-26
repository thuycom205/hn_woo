<?php


// Footer Section
Redux::setSection('appart_opt', array(
	'title'     => esc_html__('Footer Settings', 'appart'),
	'id'        => 'appart_footer',
	'icon'      => 'dashicons dashicons-download',
	'fields'    => array(
		array(
			'title'     => esc_html__('Copyright text', 'appart'),
			'subtitle'  => esc_html__('Footer Copyright text', 'appart'),
			'id'        => 'copyright_txt',
			'type'      => 'editor',
			'default'   => '© 2021 <a href="http://droitthemes.com">DroitThemes</a>. All rights reserved',
			'args'    => array(
				'wpautop'       => true,
				'media_buttons' => false,
				'textarea_rows' => 5,
				//'tabindex' => 1,
				//'editor_css' => '',
				'teeny'         => false,
				//'tinymce' => array(),
				'quicktags'     => false,
			)
		),
	)
));

Redux::setSection('appart_opt', array(
	'title'     => esc_html__('Background settings', 'appart'),
	'id'        => 'appart_footer_bg',
	'icon'      => 'dashicons dashicons-admin-appearance',
	'subsection' => true,
	'fields'    => array(
		array(
			'title'     => esc_html__('Footer Background image', 'appart'),
			'desc'      => esc_html__('The main footer background image', 'appart'),
			'id'        => 'footer_bg_image',
			'type'      => 'media',
			'compiler'  => true
		),
		array(
			'title'     => esc_html__('Footer top background color', 'appart'),
			'id'        => 'footer_top_bg_color',
			'type'      => 'color',
            'mode'      => 'background',
            'output'    => array('.footer-five .footer-top')
		),
		array(
			'title'     => esc_html__('Footer bottom background color', 'appart'),
			'id'        => 'footer_btm_bg_color',
			'type'      => 'color',
            'mode'      => 'background',
            'output'    => array('.footer-five .footer_bottom')
		),
	)
));

Redux::setSection('appart_opt', array(
	'title'     => esc_html__('Text colors', 'appart'),
	'id'        => 'appart_footer_text_colors',
	'icon'      => 'dashicons dashicons-editor-paragraph',
	'subsection' => true,
	'fields'    => array(
		array(
			'title'     => esc_html__('Footer top font color', 'appart'),
			'id'        => 'footer_top_font_color',
			'type'      => 'color',
            'output'    => array('
                .footer_sidebar p,
                .footer_sidebar .widget_recent_comments ul li,
                .footer_sidebar .widget_recent_comments ul li a,
                .footer_sidebar a.rsswidget,
                .footer_sidebar .rssSummary,
                .footer-widget .tagcloud a,
                .footer-widget cite,
                .footer-widget .widget_rss span.rss-date,
                .footer_sidebar .widget_recent_entries li a,
                .footer-five .footer-top .footer_sidebar .widget.widget_social .social-icon li a,
                .footer_sidebar .widget.widget_nav_menu ul li a, 
                .footer_sidebar .widget.widget_meta ul li a, 
                .footer_sidebar .widget.widget_pages ul li a, 
                .footer_sidebar .widget.widget_archive ul li a, 
                .footer_sidebar .widget.widget_categories ul li a,
                .footer-top .footer_sidebar .widget.widget_contact ul li .fleft,
                .footer-five .footer-top .footer_sidebar .widget.widget_contact ul li .fleft a,
                .footer-five .footer-top .footer_sidebar .widget.widget_contact ul li i,
                .footer-top .footer_sidebar .widget.widget_twitter .tweets li .tweets-text'
            )
		),
        array(
            'title'     => esc_html__('Footer link hover color', 'appart'),
            'id'        => 'footer_link_hover',
            'type'      => 'color',
        ),
		array(
			'title'     => esc_html__('Footer bottom font color', 'appart'),
			'id'        => 'footer_btm_font_color',
			'type'      => 'color',
            'output'    => array('.footer-five .footer_bottom, .footer_bottom a')
		),
		array(
			'title'     => esc_html__('Footer bottom link color', 'appart'),
			'id'        => 'footer_btm_link_color',
			'type'      => 'color',
            'output'    => array('.footer-five .footer_bottom a')
		),
		array(
			'title'     => esc_html__('Widget title color', 'appart'),
			'id'        => 'widget_title_color',
			'type'      => 'color',
            'output'    => array('.footer-five .footer-top .footer_sidebar .widget .widget_title_two')
		),
	)
));
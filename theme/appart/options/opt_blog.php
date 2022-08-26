<?php

Redux::setSection('appart_opt', array(
	'title'     => esc_html__('Blog settings', 'appart'),
	'id'        => 'blog_page',
	'icon'      => 'dashicons dashicons-admin-post',
	'fields'    => array(
		array(
			'title'     => esc_html__('Blog page title', 'appart'),
			'subtitle'  => esc_html__('Give here the blog page title', 'appart'),
			'desc'      => esc_html__('This text will be show on blog page banner', 'appart'),
			'id'        => 'blog_title',
			'type'      => 'text',
			'default'   => 'Blog'
		),
		array(
			'title'     => esc_html__('Blog page subtitle', 'appart'),
			'id'        => 'blog_subtitle',
			'type'      => 'textarea',
			'default'   => 'A feeling You have never experienced before. Get hold of a future technology now'
		),
		array(
			'title'     => esc_html__('Title bar background', 'appart'),
			'subtitle'  => esc_html__('Upload image file as Blog page title bar background', 'appart'),
			'id'        => 'blog_header_bg',
			'type'      => 'media',
		),
	)
));


Redux::setSection('appart_opt', array(
	'title'     => esc_html__('Blog archive', 'appart'),
	'id'        => 'blog_meta_opt',
	'icon'      => 'dashicons dashicons-info',
	'subsection' => true,
	'fields'    => array(
        array(
            'title'     => esc_html__('Blog excerpt', 'appart'),
            'subtitle'  => esc_html__('How much words you want to show in blog page.', 'appart'),
            'id'        => 'blog_excerpt',
            'type'      => 'text',
            'default'   => '40'
        ),
		array(
			'title'     => esc_html__('Enable/disable social share', 'appart'),
			'id'        => 'is_social_share',
			'type'      => 'switch',
            'on'        => 'Enabled',
            'off'       => 'Disabled',
            'default'   => '1'
		),
		array(
			'title'     => esc_html__('Show/hide post meta', 'appart'),
			'subtitle'  => esc_html__('Show/hide post meta on blog archive page', 'appart'),
			'id'        => 'is_post_meta',
			'type'      => 'switch',
            'on'        => 'Show',
            'off'       => 'Hide',
            'default'   => '1',
		),
		array(
			'title'     => esc_html__('Show/hide post author name', 'appart'),
			'id'        => 'is_post_author',
			'type'      => 'switch',
            'on'        => 'Show',
            'off'       => 'Hide',
            'default'   => '1',
            'required' => array( 'is_post_meta', '=', 1 )
		),
		array(
			'title'     => esc_html__('Show/hide post date', 'appart'),
			'id'        => 'is_post_date',
			'type'      => 'switch',
            'on'        => 'Show',
            'off'       => 'Hide',
            'default'   => '1',
            'required' => array( 'is_post_meta', '=', 1 )
		),
		array(
			'title'     => esc_html__('Show/hide post category', 'appart'),
			'id'        => 'is_post_cat',
			'type'      => 'switch',
            'on'        => 'Show',
            'off'       => 'Hide',
            'default'   => '1',
            'required' => array( 'is_post_meta', '=', 1 )
		),
	)
));


Redux::setSection('appart_opt', array(
	'title'     => esc_html__('Blog single', 'appart'),
	'id'        => 'blog_single_opt',
	'icon'      => 'dashicons dashicons-info',
	'subsection' => true,
	'fields'    => array(
		array(
			'title'     => esc_html__('Enable/disable social share', 'appart'),
			'id'        => 'is_social_share',
			'type'      => 'switch',
            'on'        => 'Enabled',
            'off'       => 'Disabled',
            'default'   => '1'
		),
		array(
			'title'     => esc_html__('Show/hide post tag', 'appart'),
			'id'        => 'is_post_tag',
			'type'      => 'switch',
            'on'        => 'Show',
            'off'       => 'Hide',
            'default'   => '1'
		),
	)
));

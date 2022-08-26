<?php 

require __DIR__.'/widgets/accordion.php';
require __DIR__.'/widgets/animated_text.php';
require __DIR__.'/widgets/bar_chart.php';
require __DIR__.'/widgets/img_carousel.php';
require __DIR__.'/widgets/pricing.php';
require __DIR__.'/widgets/process.php';
require __DIR__.'/widgets/share_buttons.php';
require __DIR__.'/widgets/skill-bar.php';
require __DIR__.'/widgets/tab.php';
require __DIR__.'/widgets/testimonial.php';
require __DIR__.'/widgets/timeline.php';

 function wpml_droit_addons_translates( $widgets ) {

	$widgets['droit-alert'] = [
		'conditions' => [ 'widgetType'  =>  'droit-alert' ],
		'fields' => [
			'droit_alert' => [
			'field'       => '_dl_alert_title',
			 'type'        => __( 'Alert Title', 'droit-addons' ),
			 'editor_type' => 'AREA'
			]
		]
	];

	$widgets[ 'droit-animated-text' ] = [  
		'conditions' => [ 'widgetType' => 'droit-animated-text' ],
		'fields'     => [
				'before_text_title_1' => [
					'field'       => '_dl_animatedtitle_before_text',
					'type'        => __( 'Before Text', 'droit-addons' ),
					'editor_type' => 'LINE'
				]            
		],
	];

	$widgets['droit-bloglist'] = [
		'conditions' => [ 'widgetType'  =>  'droit-bloglist' ],
		'fields' => [
			'droit_alert'  => [
			'field'        => '_blog_list_read_more_text',
			 'type'        => __( 'Read More Text', 'droit-addons' ),
			 'editor_type' => 'LINE'
			]
		]
	];

	$widgets[ 'droit-card' ] = [ 
		'conditions' => [ 'widgetType' => 'droit-card' ],
		'fields'     => [
			'card_title_text_1' => [
				'field'       => '_card_title_text',
				'field_id'    => 'card_title_text_1',
				'type'        => __( 'This is the heading', 'droit-addons' ),
				'editor_type' => 'LINE'
			],
			'card_title_text_2' => [
				'field'       => '_card_description_text',
				'field_id'    => 'card_title_text_2',
				'type'        => __( 'Hello World Title (DL)', 'droit-addons' ),
				'editor_type' => 'AREA'
			],
			'card_title_text_3' => [
				'field'       => '_card_btn_text',
				'field_id'    => 'card_title_text_3',
				'type'        => __( 'View More', 'droit-addons' ),
				'editor_type' => 'LINE'
			]
		],
	];

	$widgets[ 'droit-countdown' ] = [ 
		'conditions' => [ 'widgetType' => 'droit-countdown' ],
		'fields'     => [
			'dl_label_1' => [
				'field'       => '_dl_label_days',
				'field_id'    => 'dl_label_1',
				'type'        => __( 'Days', 'droit-addons' ),
				'editor_type' => 'LINE'
			],
			'dl_label_2' => [
				'field'       => '_dl_label_hours',
				'field_id'    => 'dl_label_2',
				'type'        => __( 'Hours', 'droit-addons' ),
				'editor_type' => 'LINE'
			],
			'dl_label_3' => [
				'field'       => '_dl_label_minutes',
				'field_id'    => 'dl_label_3',
				'type'        => __( 'Minutes', 'droit-addons' ),
				'editor_type' => 'LINE'
			],
			'dl_label_4' => [
				'field'       => '_dl_label_seconds',
				'field_id'    => 'dl_label_4',
				'type'        => __( 'Seconds', 'droit-addons' ),
				'editor_type' => 'LINE'
			]
		],
	];

	$widgets[ 'droit-infobox' ] = [ 
		'conditions' => [ 'widgetType' => 'droit-infobox' ],
		'fields'     => [
			'droit_infobox_text_1' => [
				'field'       => 'dl_infobox_title',
				'field_id'    => 'droit_infobox_text_1',
				'type'        => __( 'Type Info Box Title', 'droit-addons' ),
				'editor_type' => 'LINE'
			],
			'droit_infobox_text_2' => [
				'field'       => '_infobox_content',
				'field_id'    => 'droit_infobox_text_2',
				'type'        => __( 'Type info box description', 'droit-addons' ),
				'editor_type' => 'AREA'
			],
			'droit_infobox_text_3' => [
				'field'       => '_infobox_btn',
				'field_id'    => 'droit_infobox_text_3',
				'type'        => __( 'Learn More', 'droit-addons' ),
				'editor_type' => 'LINE'
			]
		],
	];

	$widgets['droit-newstricker'] = [
		'conditions' => [ 'widgetType'  =>  'droit-newstricker' ],
		'fields' => [
			'dl_newstricker_title'  => [
			 'field'       => '_dl_newstricker_title',
			 'type'        => __( 'Breaking News', 'droit-addons' ),
			 'editor_type' => 'LINE'
			]
		]
	];

	$widgets[ 'droit-title' ] = [ 
		'conditions' => [ 'widgetType' => 'droit-title' ],
		'fields'     => [
			'dl_title_text_1' => [
				'field'       => '_dl_title_text',
				'field_id'    => 'dl_title_text_1',
				'type'        => __( 'This is the heading', 'droit-addons' ),
				'editor_type' => 'AREA'
			],
			'dl_title_text_2' => [
				'field'       => '_dl_sub_title_text',
				'field_id'    => 'dl_title_text_2',
				'type'        => __( 'Hello World Title (DL)', 'droit-addons' ),
				'editor_type' => 'AREA'
			],
			'dl_title_text_3' => [
				'field'       => '_dl_tcontent_text',
				'field_id'    => 'dl_title_text_3',
				'type'        => __( 'View More', 'droit-addons' ),
				'editor_type' => 'AREA'
			]
		],
	];

	$widgets[ 'droit-team' ] = [ 
		'conditions' => [ 'widgetType' => 'droit-team' ],
		'fields'     => [
			'dl_team_member_1' => [
				'field'       => '_dl_team_member_name',
				'field_id'    => 'dl_team_member_1',
				'type'        => __( 'John Smith', 'droit-addons' ),
				'editor_type' => 'LINE'
			],
			'dl_team_member_2' => [
				'field'       => '_dl_team_member_job_title',
				'field_id'    => 'dl_team_member_2',
				'type'        => __( 'Software Engineer', 'droit-addons' ),
				'editor_type' => 'LINE'
			]
		],
	];

	$widgets['droit-table'] = [
		'conditions' => [ 'widgetType'  =>  'droit-table' ],
		'fields' => [
			'droit_table'  => [
			'field'        => '_dl_table_header_col',
			 'type'        => __( 'Column Name', 'droit-addons' ),
			 'editor_type' => 'LINE'
			]
		]
	];

	$widgets[ 'droit-pricing' ] = [ 
		'conditions' => [ 'widgetType' => 'droit-pricing' ],
		'fields'     => [
			'droit_pricing_1' => [
				'field'       => '_dl_pricing_heading_text',
				'field_id'    => 'droit_pricing_1',
				'type'        => __( 'This is the heading', 'droit-addons' ),
				'editor_type' => 'LINE'
			],
			'droit_pricing_2' => [
				'field'       => '_dl_pricing_heading_desc',
				'field_id'    => 'droit_pricing_2',
				'type'        => __( 'Hello World Title (DL)', 'droit-addons' ),
				'editor_type' => 'AREA'
			],
			'droit_pricing_3' => [
				'field'       => '_dl_pricing_button_text',
				'field_id'    => 'droit_pricing_3',
				'type'        => __( 'View More', 'droit-addons' ),
				'editor_type' => 'LINE'
			],
			'droit_pricing_4' => [
				'field'       => '_dl_pricing_period',
				'field_id'    => 'droit_pricing_4',
				'type'        => __( 'View More', 'droit-addons' ),
				'editor_type' => 'LINE'
			]
		],
	];

	$widgets['droit-newstricker'] = [
		'conditions' => [ 'widgetType'  =>  'droit-newstricker' ],
		'fields' => [
			'dl_newstricker'  => [
			'field'        => '_dl_newstricker_title',
			 'type'        => __( 'Enter your title', 'droit-addons' ),
			 'editor_type' => 'LINE'
			]
		]
	];

	$widgets[ 'droit-iconbox' ] = [ 
		'conditions' => [ 'widgetType' => 'droit-iconbox' ],
		'fields'     => [
			'dl_iconbox_1' => [
				'field'       => '_iconbox_title_text',
				'field_id'    => 'dl_iconbox_1',
				'type'        => __( 'Enter your title', 'droit-addons' ),
				'editor_type' => 'LINE'
			],
			'dl_iconbox_2' => [
				'field'       => '_iconbox_description_text',
				'field_id'    => 'dl_iconbox_2',
				'type'        => __( 'Software Engineer', 'droit-addons' ),
				'editor_type' => 'AREA'
			]
		],
	];

	$widgets[ 'droit-accordion' ] = [ 
		'conditions' => [ 'widgetType' => 'droit-accordion' ],
		'integration-class' => 'DROIT_ELEMENTOR\WPML\Accordion'
	];
	$widgets[ 'droit-animated-text' ] = [ 
		'conditions' => [ 'widgetType' => 'droit-animated-text' ],
		'integration-class' => 'DROIT_ELEMENTOR\WPML\Animated_Text'
	];
	$widgets[ 'droit-bar-chart' ] = [ 
		'conditions' => [ 'widgetType' => 'droit-bar-chart' ],
		'integration-class' => 'DROIT_ELEMENTOR\WPML\Bar_Chart'
	];
	$widgets[ 'droit-img-carousel' ] = [ 
		'conditions' => [ 'widgetType' => 'droit-img-carousel' ],
		'integration-class' => 'DROIT_ELEMENTOR\WPML\Img_Carousel'
	];
	$widgets[ 'droit-pricing' ] = [ 
		'conditions' => [ 'widgetType' => 'droit-pricing' ],
		'integration-class' => 'DROIT_ELEMENTOR\WPML\Pricing'
	];
	$widgets[ 'droit-process' ] = [ 
		'conditions' => [ 'widgetType' => 'droit-process' ],
		'integration-class' => 'DROIT_ELEMENTOR\WPML\Process'
	];
	$widgets[ 'droit-share_Buttons' ] = [ 
		'conditions' => [ 'widgetType' => 'droit-share_Buttons' ],
		'integration-class' => 'DROIT_ELEMENTOR\WPML\Share_Buttons'
	];
	$widgets[ 'droit-skill-bar' ] = [ 
		'conditions' => [ 'widgetType' => 'droit-skill-bar' ],
		'integration-class' => 'DROIT_ELEMENTOR\WPML\Skill_Bar'
	];
	$widgets[ 'droit-skill-bar' ] = [ 
		'conditions' => [ 'widgetType' => 'droit-skill-bar' ],
		'integration-class' => 'DROIT_ELEMENTOR\WPML\Skill_Bar'
	];
	$widgets[ 'droit-tab' ] = [ 
		'conditions' => [ 'widgetType' => 'droit-tab' ],
		'integration-class' => 'DROIT_ELEMENTOR\WPML\Tab'
	];
	$widgets[ 'droit-testimonial' ] = [ 
		'conditions' => [ 'widgetType' => 'it-testimonial' ],
		'integration-class' => 'DROIT_ELEMENTOR\WPML\Testimonial'
	];
	$widgets[ 'droit-timeline' ] = [ 
		'conditions' => [ 'widgetType' => 'droit-timeline' ],
		'integration-class' => 'DROIT_ELEMENTOR\WPML\Timeline'
	];

	return $widgets;
}
add_filter( 'wpml_elementor_widgets_to_translate', 'wpml_droit_addons_translates' );

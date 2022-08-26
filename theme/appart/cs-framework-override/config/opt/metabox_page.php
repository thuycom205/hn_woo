<?php
$options[]    = array(
    'id'        => 'page_metaboxes',
    'title'     => esc_html__('Page Settings', 'appart'),
    'post_type' =>  array('page'),
    'context'   => 'normal',
    'priority'  => 'default',
    'sections'  => array(
        array(
            'name'  => 'page_title_bar',
            'icon'  => 'dashicons dashicons-minus',
            'fields' => array(
                array(
                    'id'        => 'is_titlebar',
                    'type'      => 'switcher',
                    'title'     => esc_html__('Title Bar', 'appart'),
                    'default'   => true
                ),
                array(
                    'id'        => 'titlebar_bg_color',
                    'type'      => 'color_picker',
                    'title'     => esc_html__('Overlay Color', 'appart'),
                    'subtitle'  => esc_html__('Set the Title-bar background overlay color', 'appart'),
                    'dependency'=> array('is_titlebar', '==', '1')
                ),
                array(
                    'id'        => 'menu_color',
                    'type'      => 'color_picker',
                    'title'     => esc_html__('Menu Color', 'appart'),
                ),
            ),
        ),
    ),
);
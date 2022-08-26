<?php
$options[]    = array(
    'id'        => 'product_metaboxes',
    'title'     => esc_html__('Title-bar', 'appart'),
    'post_type' =>  array('product'),
    'context'   => 'normal',
    'priority'  => 'default',
    'sections'  => array(
        array(
            'name'  => 'product_title_bar',
            'icon'  => 'dashicons dashicons-minus',
            'fields' => array(
                array(
                    'id'        => 'title',
                    'type'      => 'text',
                    'title'     => esc_html__('Title', 'appart'),
                ),
                array(
                    'id'        => 'subtitle',
                    'type'      => 'text',
                    'title'     => esc_html__('Subtitle', 'appart'),
                ),
                array(
                    'id'        => 'bg_image',
                    'type'      => 'upload',
                    'title'     => esc_html__('Background image', 'appart'),
                ),
            ),
        ),
    ),
);
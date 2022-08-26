<?php

// Register Widget areas
add_action('widgets_init', function() {

    register_sidebar(array(
        'name'          => esc_html__('Blog Sidebar', 'appart'),
        'description'   => esc_html__('Place widgets in the blog sidebar widgets area.', 'appart'),
        'id'            => 'sidebar_widgets',
        'before_widget' => '<div id="%1$s" class="widget sidebar-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widget_title">',
        'after_title'   => '</h2>'
    ));

    register_sidebar(array(
        'name'          => esc_html__('Shop Sidebar', 'appart'),
        'description'   => esc_html__('Place widgets in the Shop sidebar widgets area.', 'appart'),
        'id'            => 'shop_sidebar',
        'before_widget' => '<div id="%1$s" class="shop_widget mb_40 %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h5 class="f_robot_c f_700 widget_title mb_35">',
        'after_title'   => '</h5>'
    ));

    register_sidebar(array(
        'name'          => esc_html__('Footer widgets', 'appart'),
        'description'   => esc_html__('Add widgets here for Footer widgets area', 'appart'),
        'id'            => 'footer_widgets',
        'before_widget' => '<div id="%1$s" class="widget footer-widget col-xs-6 col-sm-6 col-md-3 wow fadeIn %2$s" data-wow-delay="0ms" data-wow-duration="1500ms" data-wow-offset="0" style="visibility: visible; animation-duration: 1500ms; animation-delay: 0ms; animation-name: fadeIn;">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget_title_two">',
        'after_title'   => '</h4>'
    ));

});


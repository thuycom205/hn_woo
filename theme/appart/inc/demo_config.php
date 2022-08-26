<?php

// OneClick Demo Importer
add_filter( 'pt-ocdi/import_files', 'appart_import_files' );
function appart_import_files() {
    return array(
        array(
            'import_file_name'             => esc_html__('Demo one', 'appart'),
            'categories'                   => array( esc_html__('One Page', 'appart') ),
            'local_import_file'            => trailingslashit( get_template_directory() ) . 'inc/demos/demo1/contents.xml',
            'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'inc/demos/demo1/widgets.wie',
            'import_preview_image_url'     => trailingslashit( get_template_directory_uri() ).'inc/demos/demo1/screenshot.jpg',
            'import_notice'                => esc_html__( 'Install and activate all required plugins before you click on the "Yes! Import" button.', 'appart' ),
            'preview_url'                  => 'http://droitthemes.com/wp/appart/',
            'local_import_redux'           => array(
                array(
                    'file_path'   => trailingslashit( get_template_directory() ) . 'inc/demos/demo1/settings.json',
                    'option_name' => 'appart_opt',
                ),
            ),
        ),
        array(
            'import_file_name'             => esc_html__('Demo two', 'appart'),
            'categories'                   => array( esc_html__('One Page', 'appart') ),
            'local_import_file'            => trailingslashit( get_template_directory() ) . 'inc/demos/demo2/contents.xml',
            'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'inc/demos/demo2/widgets.wie',
            'import_preview_image_url'     => trailingslashit( get_template_directory_uri() ).'inc/demos/demo2/screenshot.jpg',
            'import_notice'                => esc_html__( 'Install and activate all required plugins before you click on the "Yes! Import" button.', 'appart' ),
            'preview_url'                  => 'http://droitthemes.com/wp/appart/demo2',
            'local_import_redux'           => array(
                array(
                    'file_path'   => trailingslashit( get_template_directory() ) . 'inc/demos/demo2/settings.json',
                    'option_name' => 'appart_opt',
                ),
            ),
        ),
        array(
            'import_file_name'             => esc_html__('Demo three', 'appart'),
            'categories'                   => array( esc_html__('One Page', 'appart') ),
            'local_import_file'            => trailingslashit( get_template_directory() ) . 'inc/demos/demo3/contents.xml',
            'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'inc/demos/demo3/widgets.wie',
            'import_preview_image_url'     => trailingslashit( get_template_directory_uri() ).'inc/demos/demo3/screenshot.jpg',
            'import_notice'                => esc_html__( 'Install and activate all required plugins before you click on the "Yes! Import" button.', 'appart' ),
            'preview_url'                  => 'http://droitthemes.com/wp/appart/demo3',
            'local_import_redux'           => array(
                array(
                    'file_path'   => trailingslashit( get_template_directory() ) . 'inc/demos/demo3/settings.json',
                    'option_name' => 'appart_opt',
                ),
            ),
        ),
        array(
            'import_file_name'             => esc_html__('Demo four', 'appart'),
            'categories'                   => array( esc_html__('One Page', 'appart') ),
            'local_import_file'            => trailingslashit( get_template_directory() ) . 'inc/demos/demo4/contents.xml',
            'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'inc/demos/demo4/widgets.wie',
            'import_preview_image_url'     => trailingslashit( get_template_directory_uri() ).'inc/demos/demo4/screenshot.jpg',
            'import_notice'                => esc_html__( 'Install and activate all required plugins before you click on the "Yes! Import" button.', 'appart' ),
            'preview_url'                  => 'http://droitthemes.com/wp/appart/demo4',
            'local_import_redux'           => array(
                array(
                    'file_path'   => trailingslashit( get_template_directory() ) . 'inc/demos/demo4/settings.json',
                    'option_name' => 'appart_opt',
                ),
            ),
        ),
        array(
            'import_file_name'             => esc_html__('Demo five', 'appart'),
            'categories'                   => array( esc_html__('One Page', 'appart') ),
            'local_import_file'            => trailingslashit( get_template_directory() ) . 'inc/demos/demo5/contents.xml',
            'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'inc/demos/demo5/widgets.wie',
            'import_preview_image_url'     => trailingslashit( get_template_directory_uri() ).'inc/demos/demo5/screenshot.jpg',
            'import_notice'                => esc_html__( 'Install and activate all required plugins before you click on the "Yes! Import" button.', 'appart' ),
            'preview_url'                  => 'http://droitthemes.com/wp/appart/demo5',
            'local_import_redux'           => array(
                array(
                    'file_path'   => trailingslashit( get_template_directory() ) . 'inc/demos/demo5/settings.json',
                    'option_name' => 'appart_opt',
                ),
            ),
        ),
        array(
            'import_file_name'             => esc_html__('Demo six', 'appart'),
            'categories'                   => array( esc_html__('One Page', 'appart') ),
            'local_import_file'            => trailingslashit( get_template_directory() ) . 'inc/demos/demo6/contents.xml',
            'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'inc/demos/demo6/widgets.wie',
            'import_preview_image_url'     => trailingslashit( get_template_directory_uri() ).'inc/demos/demo6/screenshot.jpg',
            'import_notice'                => esc_html__( 'Install and activate all required plugins before you click on the "Yes! Import" button.', 'appart' ),
            'preview_url'                  => 'http://droitthemes.com/wp/appart/demo6',
            'local_import_redux'           => array(
                array(
                    'file_path'   => trailingslashit( get_template_directory() ) . 'inc/demos/demo6/settings.json',
                    'option_name' => 'appart_opt',
                ),
            ),
        ),
        array(
            'import_file_name'             => esc_html__('Multi-page Demo', 'appart'),
            'categories'                   => array( esc_html__('Multi-page (Shop Included)', 'appart') ),
            'local_import_file'            => trailingslashit( get_template_directory() ) . 'inc/demos/multipage/contents.xml',
            'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'inc/demos/multipage/widgets.wie',
            'import_preview_image_url'     => trailingslashit( get_template_directory_uri() ).'inc/demos/multipage/screenshot.jpg',
            'import_notice'                => esc_html__( 'Install and activate all required plugins before you click on the "Yes! Import" button.', 'appart' ),
            'preview_url'                  => 'http://droitthemes.com/wp/appart/multipage',
            'local_import_redux'           => array(
                array(
                    'file_path'   => trailingslashit( get_template_directory() ) . 'inc/demos/multipage/settings.json',
                    'option_name' => 'appart_opt',
                ),
            ),
        ),
    );
}


function appart_after_import_setup() {
    // Assign menus to their locations.
    $main_menu = get_term_by( 'name', 'Main Menu', 'nav_menu' );

    set_theme_mod( 'nav_menu_locations', array(
            'main_menu' => $main_menu->term_id,
        )
    );

    // Assign front page and posts page (blog page).
    $front_page_id = get_page_by_title( 'Home' );
    $blog_page_id  = get_page_by_title( 'Blog' );

    update_option( 'show_on_front', 'page' );
    update_option( 'page_on_front', $front_page_id->ID );
    update_option( 'page_for_posts', $blog_page_id->ID );

}
add_action( 'pt-ocdi/after_import', 'appart_after_import_setup' );

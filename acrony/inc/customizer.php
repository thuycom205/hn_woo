<?php
/**
 * Acrony Theme Customizer
 *
 * @package Acrony
 * @since Acrony 1.0
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $acrony_customize Theme Customizer object.
 */
function acrony_customize_register( $acrony_customizer ) { 
    
    
    function acrony_sanitize_select( $input, $setting ) {
      // Ensure input is a slug.
      $input = sanitize_key( $input );
      // Get list of choices from the control associated with the setting.
      $choices = $setting->manager->get_control( $setting->id )->choices;
      // If the input is a valid key, return it; otherwise, return the default.
      return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
    }
    
    function acrony_sanitize_url( $url ) {
      return esc_url_raw( $url );
    }
    
    function acrony_text_field( $text ) {
      return esc_html( $text );
    }
        
    function acrony_sanitize_checkbox( $checked ) {
      return ( ( isset( $checked ) && true == $checked ) ? true : false );
    }  
    
        
    // Acrony Theme Option Start
    $acrony_customizer->add_panel('acrony_panel',array(
        'title'=> esc_html__( 'Theme Option','acrony' ),
        'description'=> esc_html__( 'You can use all content.','acrony' ),
        'priority'=> 0,
    ));
    
    // Acrony General Options Start
    $acrony_customizer->add_section('general_options',array(
        'title'=> esc_html__( 'General Options','acrony' ),
        'priority'=>10,
        'panel'=>'acrony_panel',
    ));
  
    $acrony_customizer->add_setting('acrony_preloader',array(
        'capability'     => 'edit_theme_options',
        'transport'      => 'refresh',
        'sanitize_callback' => 'acrony_sanitize_checkbox',
    ));    
    $acrony_customizer->add_control('acrony_preloader',array(
        'label' => esc_html__( 'Disable Prealoader', 'acrony' ),
        'type' => 'checkbox',
        'section'  => 'general_options',
        'settings' => 'acrony_preloader',
    ));
    
    // Show ScrollUp Button
    $acrony_customizer->add_setting('acrony_scrollUp',array(
        'capability'     => 'edit_theme_options',
        'transport'      => 'refresh',
        'sanitize_callback' => 'acrony_sanitize_checkbox',
    ));    
    $acrony_customizer->add_control('acrony_scrollUp',array(
        'label' => esc_html__( 'Disable ScrollUp Button', 'acrony' ),
        'type' => 'checkbox',
        'section'  => 'general_options',
        'settings' => 'acrony_scrollUp',
    ));
    
    // Acrony Mainmenu Options Start
    $acrony_customizer->add_section('mainmenu_option',array(
        'title'=> esc_html__( 'Mainmenu','acrony' ),
        'priority'=>10,
        'panel'=>'acrony_panel',
    ));
    
    
    // Menu Layout
    $acrony_customizer->add_setting( 'acrony_menu_layout', array(
      'capability' => 'edit_theme_options',
      'sanitize_callback' => 'acrony_sanitize_select',
      'default' => 'boxed',
    ) );

    $acrony_customizer->add_control( 'acrony_menu_layout', array(
      'type' => 'select',
      'settings' => 'acrony_menu_layout',
      'section' => 'mainmenu_option', // Add a default or your own section
      'label' => __( 'Menu Layout','acrony' ),
      'description' => __( 'Choose the Menu Layout Style (Boxed / Fullwidth)','acrony' ),
      'choices' => array(
            'boxed' => __( 'Boxed' , 'acrony' ),
            'full_width' => __( 'Full Width' , 'acrony' ),
        )
    ) );
    
    $acrony_customizer->add_setting('header_overly_color', array(
        'capability'            => 'edit_theme_options',
        'transport'		        => 'refresh',
        'default'               => '#1992ec',
        'sanitize_callback'     => 'esc_attr',
    ));

    $acrony_customizer->add_control( new WP_Customize_Color_Control( $acrony_customizer, 'header_overly_color', array(
        'label'      => esc_html__( 'Header Background Color','acrony' ),
        'section'    => 'colors',
        'settings'   => 'header_overly_color',
    ) ) );

    
        
    // Show Sticky Menu
    $acrony_customizer->add_setting('acrony_sticky_menu',array(
        'capability'     => 'edit_theme_options',
        'transport'      => 'refresh',
        'sanitize_callback' => 'acrony_sanitize_checkbox',
    ));    
    $acrony_customizer->add_control('acrony_sticky_menu',array(
        'label' => esc_html__( 'Disable Sticky Menu', 'acrony' ),
        'type' => 'checkbox',
        'section'  => 'mainmenu_option',
        'settings' => 'acrony_sticky_menu',
    ));
            
    // Show Sticky Menu
    $acrony_customizer->add_setting('acrony_transparent_menu',array(
        'capability'     => 'edit_theme_options',
        'transport'      => 'refresh',
        'sanitize_callback' => 'acrony_sanitize_checkbox',
    ));    
    $acrony_customizer->add_control('acrony_transparent_menu',array(
        'label' => esc_html__( 'Enable Transparent Menu', 'acrony' ),
        'type' => 'checkbox',
        'section'  => 'mainmenu_option',
        'settings' => 'acrony_transparent_menu',
    ));
    
            
    // Menu Button Text
    $acrony_customizer->add_setting('acrony_menu_button_text',array(
        'capability'     => 'edit_theme_options',
        'transport'      => 'refresh',
        'sanitize_callback' => 'acrony_text_field',
    ));    
    $acrony_customizer->add_control('acrony_menu_button_text',array(
        'label' => esc_html__( 'Button Text', 'acrony' ),
        'type' => 'text',
        'section'  => 'mainmenu_option',
        'settings' => 'acrony_menu_button_text',
        'input_attrs' => array(
            'placeholder' => __( 'Button Text','acrony' ),
          )
    ));
    
    
                
    // Show Sticky Menu
    $acrony_customizer->add_setting('acrony_menu_button_url',array(
        'capability'     => 'edit_theme_options',
        'transport'      => 'refresh',
        'sanitize_callback' => 'acrony_sanitize_url',
    ));    
    $acrony_customizer->add_control('acrony_menu_button_url',array(
        'label' => esc_html__( 'Button URL', 'acrony' ),
        'type' => 'url',
        'section'  => 'mainmenu_option',
        'settings' => 'acrony_menu_button_url',
        'input_attrs' => array(
            'placeholder' => __( 'www.example.com','acrony' ),
          )
    ));
    
    
    // Show Sticky Menu
    $acrony_customizer->add_setting('menu_style_hr1',array(
        'capability'     => 'edit_theme_options',
    ));    
    $acrony_customizer->add_control('menu_style_hr1',array(
        'description' => '<br><hr><br>',
        'type' => 'hidden',
        'section'  => 'mainmenu_option',
        'settings' => 'menu_style_hr1'
    ));

    
    
        
    $acrony_customizer->add_setting( 'menu_bg_color', array(
        'capability'     => 'edit_theme_options',
        'transport'      => 'refresh',
    ) );
    $acrony_customizer->add_control(
        new WP_Customize_Color_Control(
            $acrony_customizer, 'menu_bg_color',
            array(
                'label' => __(
                    'Menu BG Color', 'acrony' 
                ),
                'section' => 'mainmenu_option',
                'settings' => 'menu_bg_color'
            )
        )
    );
    
    $acrony_customizer->add_setting( 'menu_sticky_bg', array(
        'capability'     => 'edit_theme_options',
        'transport'      => 'refresh',
    ) );
    $acrony_customizer->add_control(
        new WP_Customize_Color_Control(
            $acrony_customizer, 'menu_sticky_bg',
            array(
                'label' => __(
                    'Sticky Menu BG Color', 'acrony' 
                ),
                'section' => 'mainmenu_option',
                'settings' => 'menu_sticky_bg'
            )
        )
    );
    
        
    // Show Sticky Menu
    $acrony_customizer->add_setting('menu_style_hr2',array(
        'capability'     => 'edit_theme_options',
    ));    
    $acrony_customizer->add_control('menu_style_hr2',array(
        'description' => '<br><hr><br>',
        'type' => 'hidden',
        'section'  => 'mainmenu_option',
        'settings' => 'menu_style_hr2'
    ));

    
    

    $acrony_customizer->add_setting( 'logo_text_color', array(
        'capability'     => 'edit_theme_options',
        'transport'      => 'refresh',
    ) );
    $acrony_customizer->add_control(
        new WP_Customize_Color_Control(
            $acrony_customizer, 'logo_text_color',
            array(
                'label' => __(
                    'Logo Text Color', 'acrony' 
                ),
                'section' => 'mainmenu_option',
                'settings' => 'logo_text_color'
            )
        )
    );
    

    $acrony_customizer->add_setting( 'sticky_logo_color', array(
        'capability'     => 'edit_theme_options',
        'transport'      => 'refresh',
    ) );
    $acrony_customizer->add_control(
        new WP_Customize_Color_Control(
            $acrony_customizer, 'sticky_logo_color',
            array(
                'label' => __(
                    'Sticky Logo Color', 'acrony' 
                ),
                'section' => 'mainmenu_option',
                'settings' => 'sticky_logo_color'
            )
        )
    );
    

    $acrony_customizer->add_setting( 'logo_hover_text_color', array(
        'capability'     => 'edit_theme_options',
        'transport'      => 'refresh',
    ) );
    $acrony_customizer->add_control(
        new WP_Customize_Color_Control(
            $acrony_customizer, 'logo_hover_text_color',
            array(
                'label' => __(
                    'Logo Text Color', 'acrony' 
                ),
                'section' => 'mainmenu_option',
                'settings' => 'logo_hover_text_color'
            )
        )
    );
    
    
        
    // Show Sticky Menu
    $acrony_customizer->add_setting('menu_style_hr3',array(
        'capability'     => 'edit_theme_options',
    ));    
    $acrony_customizer->add_control('menu_style_hr3',array(
        'description' => '<br><hr><br>',
        'type' => 'hidden',
        'section'  => 'mainmenu_option',
        'settings' => 'menu_style_hr3'
    ));

    
    
    $acrony_customizer->add_setting( 'menu_item_color', array(
        'capability'     => 'edit_theme_options',
        'transport'      => 'refresh',
    ) );
    $acrony_customizer->add_control(
        new WP_Customize_Color_Control(
            $acrony_customizer, 'menu_item_color',
            array(
                'label' => __(
                    'Menu Text Color', 'acrony' 
                ),
                'section' => 'mainmenu_option',
                'settings' => 'menu_item_color'
            )
        )
    );
            
    $acrony_customizer->add_setting( 'menu_sticky_item_color', array(
        'capability'     => 'edit_theme_options',
        'transport'      => 'refresh',
    ) );
    $acrony_customizer->add_control(
        new WP_Customize_Color_Control(
            $acrony_customizer, 'menu_sticky_item_color',
            array(
                'label' => __(
                    'Sticky Menu Text Color', 'acrony' 
                ),
                'section' => 'mainmenu_option',
                'settings' => 'menu_sticky_item_color'
            )
        )
    );
        
    $acrony_customizer->add_setting( 'menu_item_hover_color', array(
        'capability'     => 'edit_theme_options',
        'transport'      => 'refresh',
    ) );
    $acrony_customizer->add_control(
        new WP_Customize_Color_Control(
            $acrony_customizer, 'menu_item_hover_color',
            array(
                'label' => __(
                    'Menu Hover Text Color', 'acrony' 
                ),
                'section' => 'mainmenu_option',
                'settings' => 'menu_item_hover_color'
            )
        )
    );
    
    
    
        
    // Show Sticky Menu
    $acrony_customizer->add_setting('menu_style_hr4',array(
        'capability'     => 'edit_theme_options',
    ));    
    $acrony_customizer->add_control('menu_style_hr4',array(
        'description' => '<br><hr><br>',
        'type' => 'hidden',
        'section'  => 'mainmenu_option',
        'settings' => 'menu_style_hr1'
    ));

    
    $acrony_customizer->add_setting( 'button_text_color', array(
        'capability'     => 'edit_theme_options',
        'transport'      => 'refresh',
    ) );
    $acrony_customizer->add_control(
        new WP_Customize_Color_Control(
            $acrony_customizer, 'button_text_color',
            array(
                'label' => __( 'Button Text Color', 'acrony' ),
                'section' => 'mainmenu_option',
                'settings' => 'button_text_color'
            )
        )
    );    
    
    $acrony_customizer->add_setting( 'button_hover_text_color', array(
        'capability'     => 'edit_theme_options',
        'transport'      => 'refresh',
    ) );
    $acrony_customizer->add_control(
        new WP_Customize_Color_Control(
            $acrony_customizer, 'button_hover_text_color',
            array(
                'label' => __(
                    'Button Hover Text Color', 'acrony' 
                ),
                'section' => 'mainmenu_option',
                'settings' => 'button_hover_text_color'
            )
        )
    );
    
    $acrony_customizer->add_setting( 'button_bg_color', array(
        'capability'     => 'edit_theme_options',
        'transport'      => 'refresh',
    ) );
    $acrony_customizer->add_control(
        new WP_Customize_Color_Control(
            $acrony_customizer, 'button_bg_color',
            array(
                'label' => __(
                    'Button Text Color', 'acrony' 
                ),
                'section' => 'mainmenu_option',
                'settings' => 'button_bg_color'
            )
        )
    );
    
    
    $acrony_customizer->add_setting( 'button_hover_bg_color', array(
        'capability'     => 'edit_theme_options',
        'transport'      => 'refresh',
    ) );
    $acrony_customizer->add_control(
        new WP_Customize_Color_Control(
            $acrony_customizer, 'button_hover_bg_color',
            array(
                'label' => __(
                    'Button Hover BG color', 'acrony' 
                ),
                'section' => 'mainmenu_option',
                'settings' => 'button_hover_bg_color'
            )
        )
    );
    
    
    /**
    * footer_options Logo
    */
    $acrony_customizer->add_section('footer_options', array(
        'title'		    => esc_html__( 'Footer Options', 'acrony' ),
        'description'	=> esc_html__( 'To display footer menu options. Use this shortcode [acrony_social_menu] for social menu.', 'acrony' ),
        'priority'      => 10,
        'panel'         => 'acrony_panel',
    ));
    /*-- Facebook URL Field --*/
    $acrony_customizer->add_setting('copyright_text', array(
        'transport'		=> 'refresh',
        'default'       => __('All copyrights reserved by Author.','acrony'),
    ));
    $acrony_customizer->add_control('copyright_text', array(
        'section'		=> 'footer_options',
        'label'			=> esc_html__( 'Copyright Text','acrony' ),
        'setting'		=> 'copyright_text',
        'section'       => 'footer_options'
    ));
    /*-- Facebook URL Field --*/
    $acrony_customizer->add_setting('facebook', array(
        'transport'		=> 'refresh'
    ));
    $acrony_customizer->add_control('facebook', array(
        'section'		=> 'footer_options',
        'label'			=> esc_html__( 'Facebook','acrony' ),
        'setting'		=> 'facebook',
        'section'       => 'footer_options'
    ));
    /*-- Twitter URL Field --*/
    $acrony_customizer->add_setting('twitter', array(
        'transport'		=> 'refresh'
    ));
    $acrony_customizer->add_control('twitter', array(
        'section'		=> 'footer_options',
        'label'			=> esc_html__( 'Twitter', 'acrony' ),
        'setting'		=> 'twitter',
        'section'       => 'footer_options'
    ));
    /*-- Linkedin URL Field --*/
    $acrony_customizer->add_setting('linkedin', array(
        'transport'		=> 'refresh'
    ));
    $acrony_customizer->add_control('linkedin', array(
        'section'		=> 'footer_options',
        'label'			=> esc_html__( 'Linkedin', 'acrony' ),
        'setting'		=> 'linkedin',
        'section'       => 'footer_options'
    ));
    /*-- Instagram URL Field --*/
    $acrony_customizer->add_setting('instagram', array(
        'transport'		=> 'refresh'
    ));
    $acrony_customizer->add_control('instagram', array(
        'section'		=> 'footer_options',
        'label'			=> esc_html__( 'Instagram','acrony' ),
        'setting'		=> 'instagram',
        'section'       => 'footer_options'
    ));
    /*-- Flickr URL Field --*/
    $acrony_customizer->add_setting('flickr', array(
        'transport'		=> 'refresh'
    ));
    $acrony_customizer->add_control('flickr', array(
        'section'		=> 'footer_options',
        'label'			=> esc_html__( 'Flickr','acrony' ),
        'setting'		=> 'flickr',
        'section'       => 'footer_options'
    ));
    /*-- Pinterest URL Field --*/
    $acrony_customizer->add_setting('pinterest', array(
        'transport'		=> 'refresh'
    ));
    $acrony_customizer->add_control('pinterest', array(
        'section'		=> 'footer_options',
        'label'			=> esc_html__( 'Pinterest', 'acrony' ),
        'setting'		=> 'pinterest',
        'section'       => 'footer_options'
    ));     
    /*-- Dribbble URL Field --*/
    $acrony_customizer->add_setting('dribbble', array(
        'transport'		=> 'refresh'
    ));
    $acrony_customizer->add_control('dribbble', array(
        'section'		=> 'footer_options',
        'label'			=> esc_html__( 'Dribbble','acrony' ),
        'setting'		=> 'dribbble',
        'section'       => 'footer_options'
    )); 
    
    /*-- YouTube URL Field --*/
    $acrony_customizer->add_setting('youtube', array(
        'default'		=> '',
        'transport'		=> 'refresh'
    ));
    $acrony_customizer->add_control('youtube', array(
        'section'		=> 'footer_options',
        'label'			=> esc_html__( 'YouTube','acrony' ),
        'setting'		=> 'youtube',
        'section'       => 'footer_options'
    ));
    
}
add_action( 'customize_register', 'acrony_customize_register' );
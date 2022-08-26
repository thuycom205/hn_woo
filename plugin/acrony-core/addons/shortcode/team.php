<?php
add_action( 'init', 'acrony_team_addons', 99 );
if( !function_exists('acrony_team_addons') ){
    function acrony_team_addons(){
       if( function_exists('kc_add_map') ){
           kc_add_map(array(
                'acrony_team' => array(
                    'name' => esc_html__('Team','acrony-core'),
                    'icon' => 'acrony_icon  icon_team',
                    'category' => 'Acrony',
                    'params' => array(
                        'General' => array(  
                            array(
                                'name' => 'team_image',
                                'type' => 'attach_image',
                                'label' => esc_html__('Image','acrony-core')
                            ),                                                      
                            array(
                                'name' => 'image_size',
                                'type' => 'dropdown',
                                'label' => __( 'Image Size','acrony-core' ),
                                'description' => __( 'Set the image size : thumbnail, medium, large, acrony_blog_thumb or full .','acrony-core' ),
                                'options' 		=> array(
                                    'thumbnail'		=> __('Thumbnail', 'acrony-core'),
                                    'medium'		    => __('Medium', 'acrony-core'),
                                    'large'		    => __('Large', 'acrony-core'),
                                    'acrony_blog_thumb' => __('Acrony Blog Thumb ', 'acrony-core'),
                                    'full'		    => __('Full', 'acrony-core'),
                                ),
                                'value' => 'large',
                            ),
                            array(
                                'name' => 'team_name',
                                'label' => esc_html__('Name','acrony-core'),
                                'type' => 'text'
                            ),
                            array(
                                'name' => 'position',
                                'label' => esc_html__('Position','acrony-core'),
                                'type' => 'text'
                            ),
                            array(
                                'name' => 'social_show',
                                'label' => esc_html__('Use Social Menu','acrony-core'),
                                'type' => 'toggle',
                                'value' => 'yes'
                            ),
                            array(
                                'type' => 'group',
                                'label' => esc_html__('Add social menu','acrony-core'),
                                'name' => 'social_items',
                                'description'	=> __( 'Repeat this fields with each item created, Each item social menu element.', 'acrony-core' ),
                                'options' => array(
                                    'add_text' => esc_html__('Add New Social','acrony-core')
                                ),
                                'params' => array(
                                    array(
                                        'name' => 'social_url',
                                        'type' => 'text',
                                        'label' => esc_html__('Social URL','acrony-core'),
                                        'description' => esc_html__('Enter your social profile link','acrony-core'),
                                        'value' => '#'
                                    ),
                                    array(
                                        'name' => 'social_icon',
                                        'type' => 'icon_picker',
                                        'label' => esc_html__('Choose Social Icon','acrony-core')
                                    )
                                ),
                                'relation' => array(
                                    'parent' => 'social_show',
                                    'show_when' => 'yes'
                                )
                            ),
                            array(
                                'name' => 'wrapper_class',
                                'type' => 'text',
                                'label' => esc_html__( 'Wrapper Extra Class' , 'acrony-core' ),
                                'description' => esc_html__( 'If you wish to style a particular content element differently, please add a class name to this field and refer to it in your custom CSS file.', 'acrony-core')
                            )
                        ),
                        'Styling' => array(
                            array(
                                'name' => 'acrony_team_style',
                                'type' => 'css',
                                'options' => array(
                                    array(
                                        'screens' => "any,1024,999,767,479",
                                        'Box' => array(
                                            array( 'property' => 'background', 'label' => 'Background Color' ),
                                            array( 'property' => 'width', 'label' => 'Width' ),
                                            array( 'property' => 'height', 'label' => 'Height' ),
                                            array( 'property' => 'text-align', 'label' => 'Text Align' ),
                                            array( 'property' => 'display', 'label' => 'Display' ),
                                            array( 'property' => 'border', 'label' => 'Border' ),
                                            array( 'property' => 'box-shadow', 'label' => 'Box Shadow' ),
                                            array( 'property' => 'border-radius', 'label' => 'Border Radius' ),
                                            array( 'property' => 'padding', 'label' => 'Padding' ),
                                            array( 'property' => 'margin', 'label' => 'Margin' ),
                                            array( 'property' => 'overflow', 'label' => 'Overflow' ),
                                        ),
                                        'Content Box' => array(
                                            array( 'property' => 'background', 'label' => 'Background Color', 'selector' => '.team-details' ),
                                            array( 'property' => 'width', 'label' => 'Width', 'selector' => '.team-details' ),
                                            array( 'property' => 'height', 'label' => 'Height', 'selector' => '.team-details' ),
                                            array( 'property' => 'text-align', 'label' => 'Text Align', 'selector' => '.team-details' ),
                                            array( 'property' => 'display', 'label' => 'Display', 'selector' => '.team-details' ),
                                            array( 'property' => 'border', 'label' => 'Border', 'selector' => '.team-details' ),
                                            array( 'property' => 'box-shadow', 'label' => 'Box Shadow', 'selector' => '.team-details' ),
                                            array( 'property' => 'border-radius', 'label' => 'Border Radius', 'selector' => '.team-details' ),
                                            array( 'property' => 'padding', 'label' => 'Padding', 'selector' => '.team-details' ),
                                            array( 'property' => 'margin', 'label' => 'Margin', 'selector' => '.team-details' ),
                                            array( 'property' => 'overflow', 'label' => 'Overflow', 'selector' => '.team-details' ),
                                        ),
                                        'Title' => array(
                                            array('property' => 'color', 'label' => 'Color','selector' => '.team-details .team-title-box .title'),
                                            array('property' => 'color', 'label' => 'Hover Color','selector' => '.team-details .team-title-box .title:hover'),
                                            array('property' => 'background-color', 'label' => 'Title Bar Color','selector' => '.title:before, .title:after'),
                                            array('property' => 'font-family', 'label' => 'Font Family', 'selector' => '.team-details .team-title-box .title'),
                                            array('property' => 'font-size', 'label' => 'Font Size', 'selector' => '.team-details .team-title-box .title'),
                                            array('property' => 'font-weight', 'label' => 'Font Weight', 'selector' => '.team-details .team-title-box .title'),
                                            array('property' => 'line-height', 'label' => 'Line Height', 'selector' => '.team-details .team-title-box .title'),
                                            array('property' => 'text-transform', 'label' => 'Text Transform', 'selector' => '.team-details .team-title-box .title'),
                                            array('property' => 'letter-spacing', 'label' => 'Letter Spacing', 'selector' => '.team-details .team-title-box .title')
                                        ),
                                        'Position' => array(
                                            array('property' => 'color', 'label' => 'Color','selector' => '.team-details .team-title-box .position'),
                                            array('property' => 'color', 'label' => 'Hover Color','selector' => '.team-details .team-title-box .position:hover'),
                                            array('property' => 'font-family', 'label' => 'Font Family', 'selector' => '.team-details .team-title-box .position'),
                                            array('property' => 'font-size', 'label' => 'Font Size', 'selector' => '.team-details .team-title-box .position'),
                                            array('property' => 'font-weight', 'label' => 'Font Weight', 'selector' => '.team-details .team-title-box .position'),
                                            array('property' => 'line-height', 'label' => 'Line Height', 'selector' => '.team-details .team-title-box .position'),
                                            array('property' => 'text-transform', 'label' => 'Text Transform', 'selector' => '.team-details .team-title-box .position'),
                                            array('property' => 'letter-spacing', 'label' => 'Letter Spacing', 'selector' => '.team-details .team-title-box .position')
                                        ),
                                        'Social' => array(
                                            array('property' => 'color', 'label' => 'Color','selector' => '.team-details .team-social > a'),
                                            array('property' => 'color', 'label' => 'Hover Color','selector' => '.team-details .team-social > a:hover'),
                                            array('property' => 'background-color', 'label' => 'Background Color', 'selector' => '.team-details .team-social > a'),
                                            array('property' => 'background-color', 'label' => 'Hover Background Color', 'selector' => '.team-details .team-social > a:hover'),
                                            array('property' => 'font-size', 'label' => 'Font Size', 'selector' => '.team-details .team-social > a'),
                                            array('property' => 'letter-spacing', 'label' => 'Letter Spacing', 'selector' => '.team-details .team-social > a'),
                                            array('property' => 'width', 'label' => 'Widht','selector' => '.team-details .team-social > a'),
                                            array('property' => 'height', 'label' => 'Height', 'selector' => '.team-details .team-social > a'),
                                            array('property' => 'border', 'label' => 'Border', 'selector' => '.team-details .team-social > a'),
                                            array('property' => 'box-shadow', 'label' => 'Box Shadow', 'selector' => '.team-details .team-social > a'),
                                            array('property' => 'box-shadow', 'label' => 'Hover Box Shadow', 'selector' => '.team-details .team-social > a:hover'),
                                            array('property' => 'border-radius', 'label' => 'Border Radius', 'selector' => '.team-details .team-social > a'),
                                            array('property' => 'padding', 'label' => 'Padding', 'selector' => '.team-details .team-social > a'),
                                            array('property' => 'margin', 'label' => 'Margin', 'selector' => '.team-details .team-social > a')
                                        )
                                    )
                                )
                            )
                        ),
                        'Animate' => array(
                            array(
                                'name'    => 'animate',
                                'type'    => 'animate'
                            )
                        )
                    )
                )
           ));
       } 
    }
}
if( ! function_exists('acrony_team_content') ){
    function acrony_team_content( $atts, $conten = '' ){
        $image_size = 'large';
        extract($atts);  
        $data = array();        
        $wrapper_classes = apply_filters( 'kc-el-class', $atts );
        $wrapper_classes[] = 'single-team';
        $data[] = '<div class="'.implode( ' ', $wrapper_classes ).'">';        
        if( isset($team_image) and !empty($team_image) ){
            $data[] = '<div class="team-image">';
            $data[] = wp_get_attachment_image( $team_image , $image_size );
            if( $social_show == 'yes' and !empty($social_items) ){
                $data[] = '<div class="team-social">';
                foreach($social_items as $social_item){
                    if( !empty($social_item->social_url) and !empty($social_item->social_icon) ){    
                        $data[] = '<a href="'.esc_url($social_item->social_url).'"><i class="'.esc_attr($social_item->social_icon).'"></i></a>';
                    }                
                }            
                $data[] = '</div>';
            }
            $data[] = '</div>';
        }
        $data[] = '<div class="team-details">';
        $data[] = '<div class="team-title-box">';
        if( isset($team_name) and !empty($team_name) ){
            $data[] = '<h4 class="title">'.esc_html($team_name).'</h4>';
        }
        if( isset($position) and !empty($position) ){
            $data[] = '<span class="position">'.esc_html($position).'</span>';
        }        
        $data[] = '</div>';
        $data[] = '</div>';
        $data[] = '</div>';        
        $data = implode( ' ', $data );        
        return $data;        
    }
    
}
add_shortcode('acrony_team','acrony_team_content');
?>
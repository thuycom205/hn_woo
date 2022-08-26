<?php
add_action( 'init','acrony_feature_addons', 99 );
if( !function_exists('acrony_feature_addons') ){
    function acrony_feature_addons(){
        if( function_exists('kc_add_map') ){
            kc_add_map(
                array(
                    'acrony_feature' => array(
                        'name'      => __( 'Feature Box' , 'acrony-core' ),
                        'icon'      => 'acrony_icon icon_feature',
                        'category'  => 'Acrony',
                        'params'    => array(
                            'General' => array(
                                array(
                                    'name' => 'box_style_type',
                                    'label' => esc_html__('Select Template','acrony-core'),
                                    'type' => 'dropdown',
                                    'options' => array(
                                        'box_1' => esc_html__('Box Style One', 'acrony-core' ),
                                        'box_2' => esc_html__('Box Style Two', 'acrony-core' ),
                                        'box_3' => esc_html__('Box Style Three', 'acrony-core' ),
                                        'box_4' => esc_html__('Box Style Four', 'acrony-core' ),
                                    ),
                                    'value' => 'box_1',
                                    'description' => esc_html__('Default Select Template No: one','acrony-core'),
                                ),
                                array(
                                    'name'      => 'icon_type',
                                    'label'     => __( 'Icon Type','acrony-core' ),
                                    'type'      => 'dropdown',
                                    'options'   => array(
                                        'image'     => __( 'Image Icon','acrony-core' ),
                                        'font'      => __( 'Font Icon','acrony-core' )
                                    )
                                ),
                                array(
                                    'name'      => 'font_icon',
                                    'label'     => __( 'Font Icon','acrony-core' ),
                                    'type'      => 'icon_picker',
                                    'relation'  => array(
                                        'parent'    => 'icon_type',
                                        'show_when' => 'font'
                                    ),
                                    'description' => __( 'Please choose the font icon form here.','acrony-core' )
                                ),
                                array(
                                    'name'      => 'image_icon',
                                    'label'     => __( 'Image Icon' , 'acrony-core' ),
                                    'type'      => 'attach_image',
                                    'relation'  => array(
                                        'parent'    => 'icon_type',
                                        'show_when' => 'image'
                                    ),
                                    'description' => __( 'Please select image icon.','acrony-core' ),
                                ), 
                                array(
                                    'name'      => 'title',
                                    'label'     => __( 'Title', 'acrony-core' ),
                                    'type'      => 'text'
                                ),
                                array(
                                    'name'      => 'desc',
                                    'label'     => __( 'Description','acrony-core' ),
                                    'type'      => 'textarea'
                                ),
                                array(
                                    'name'      => 'read_more_show',
                                    'label'     => __( 'Use Read More', 'acrony-core' ),
                                    'type'      => 'toggle'
                                ),
                                array(
                                    'name'      => 'more_link',
                                    'label'     => __( 'Add Read More Link','acrony-core' ),
                                    'type'      => 'link',
                                    'relation'  => array(
                                        'parent'    => 'read_more_show',
                                        'show_when' => 'yes'
                                    )
                                ),
                                array(
                                    'name'      => 'custom_class',
                                    'label'     => __( 'Custom class','acrony-core' ),
                                    'type'      => 'text',
                                    'description' => __( 'Add your extra class.' , 'acrony-core' )
                                )
                            ),
                            'Styling' => array(
                                array(
                                    'name' => 'acrony_button_style',
                                    'type'    => 'css',
                                    'options' => array(
                                        array(
                                            "screens" => "any,1024,999,767,479",
                                            'Boxes' => array(
                                                array('property' => 'color', 'label' => 'Color'),
                                                array('property' => 'color', 'label' => 'Hover Color','selector' => ':hover'),
                                                array('property' => 'background', 'label' => 'Background Color'),
                                                array('property' => 'background', 'label' => 'Hover Background Color', 'selector' => ':hover'),
                                                array('property' => 'font-family', 'label' => 'Font Family'),
                                                array('property' => 'font-size', 'label' => 'Font Size'),
                                                array('property' => 'font-weight', 'label' => 'Font Weight'),
                                                array('property' => 'line-height', 'label' => 'Line Height'),
                                                array('property' => 'text-transform', 'label' => 'Text Transform'),
                                                array('property' => 'text-align', 'label' => 'Text Align'),
                                                array('property' => 'letter-spacing', 'label' => 'Letter Spacing'),
                                                array('property' => 'float', 'label' => 'Float'),
                                                array('property' => 'width', 'label' => 'Widht'),
                                                array('property' => 'height', 'label' => 'Height'),
                                                array('property' => 'display', 'label' => 'Display'),
                                                array('property' => 'border', 'label' => 'Border'),
                                                array('property' => 'border', 'label' => 'Hover Border', 'selector' => ':hover'),
                                                array('property' => 'box-shadow', 'label' => 'Box Shadow'),
                                                array('property' => 'box-shadow', 'label' => 'Hover Box Shadow', 'selector' => ':hover'),
                                                array('property' => 'border-radius', 'label' => 'Border Radius'),
                                                array('property' => 'padding', 'label' => 'Padding'),
                                                array('property' => 'margin', 'label' => 'Margin')
                                            ),
                                            'Title' => array(
                                                array('property' => 'color', 'label' => 'Color','selector' => '.title'),
                                                array('property' => 'color', 'label' => 'Hover Color','selector' => ':hover .title'),
                                                array('property' => 'background-color', 'label' => 'Background Color', 'selector' => '.title'),
                                                array('property' => 'background-color', 'label' => 'Hover Background Color', 'selector' => '.title:hover'),
                                                array('property' => 'font-family', 'label' => 'Font Family', 'selector' => '.title'),
                                                array('property' => 'font-size', 'label' => 'Font Size', 'selector' => '.title'),
                                                array('property' => 'font-weight', 'label' => 'Font Weight', 'selector' => '.title'),
                                                array('property' => 'line-height', 'label' => 'Line Height', 'selector' => '.title'),
                                                array('property' => 'text-transform', 'label' => 'Text Transform', 'selector' => '.title'),
                                                array('property' => 'text-align', 'label' => 'Text Align', 'selector' => '.title'),
                                                array('property' => 'letter-spacing', 'label' => 'Letter Spacing', 'selector' => '.title'),
                                                array('property' => 'float', 'label' => 'Float', 'selector' => '.title'),
                                                array('property' => 'width', 'label' => 'Widht','selector' => '.title'),
                                                array('property' => 'height', 'label' => 'Height', 'selector' => '.title'),
                                                array('property' => 'display', 'label' => 'Display', 'selector' => '.title'),
                                                array('property' => 'border', 'label' => 'Border', 'selector' => '.title'),
                                                array('property' => 'box-shadow', 'label' => 'Box Shadow', 'selector' => '.title'),
                                                array('property' => 'box-shadow', 'label' => 'Hover Box Shadow', 'selector' => '.title:hover'),
                                                array('property' => 'border-radius', 'label' => 'Border Radius', 'selector' => '.title'),
                                                array('property' => 'padding', 'label' => 'Padding', 'selector' => '.title'),
                                                array('property' => 'margin', 'label' => 'Margin', 'selector' => '.title')
                                            ),
                                            'Desc' => array(
                                                array('property' => 'color', 'label' => 'Color','selector' => '.desc'),
                                                array('property' => 'color', 'label' => 'Hover Color','selector' => '.desc:hover'),
                                                array('property' => 'background-color', 'label' => 'Background Color', 'selector' => '.desc'),
                                                array('property' => 'background-color', 'label' => 'Hover Background Color', 'selector' => '.desc:hover'),
                                                array('property' => 'font-family', 'label' => 'Font Family', 'selector' => '.desc'),
                                                array('property' => 'font-size', 'label' => 'Font Size', 'selector' => '.desc'),
                                                array('property' => 'font-weight', 'label' => 'Font Weight', 'selector' => '.desc'),
                                                array('property' => 'line-height', 'label' => 'Line Height', 'selector' => '.desc'),
                                                array('property' => 'text-transform', 'label' => 'Text Transform', 'selector' => '.desc'),
                                                array('property' => 'text-align', 'label' => 'Text Align', 'selector' => '.desc'),
                                                array('property' => 'letter-spacing', 'label' => 'Letter Spacing', 'selector' => '.desc'),
                                                array('property' => 'float', 'label' => 'Float', 'selector' => '.desc'),
                                                array('property' => 'display', 'label' => 'Display', 'selector' => '.desc'),
                                                array('property' => 'border', 'label' => 'Border', 'selector' => '.desc'),
                                                array('property' => 'box-shadow', 'label' => 'Box Shadow', 'selector' => '.desc'),
                                                array('property' => 'box-shadow', 'label' => 'Hover Box Shadow', 'selector' => '.desc:hover'),
                                                array('property' => 'border-radius', 'label' => 'Border Radius', 'selector' => '.desc'),
                                                array('property' => 'padding', 'label' => 'Padding', 'selector' => '.desc'),
                                                array('property' => 'margin', 'label' => 'Margin', 'selector' => '.desc') 
                                            ),
                                            'Icon' => array(
                                                array('property' => 'color', 'label' => 'Color','selector' => '.icon'),
                                                array('property' => 'color', 'label' => 'Hover Color','selector' => ':hover .icon'),
                                                array('property' => 'background-color', 'label' => 'Background Color', 'selector' => '.icon'),
												array('property' => 'background-color', 'label' => 'Hover BG Color', 'selector' => ':hover .icon'),
												array('property' => 'background-color', 'label' => 'Over BG', 'selector' => '.icon:after,.icon:before'),
                                                array('property' => 'font-size', 'label' => 'Font Size', 'selector' => '.icon'),
                                                array('property' => 'line-height', 'label' => 'Line Height', 'selector' => '.icon'),
                                                array('property' => 'text-align', 'label' => 'Text Align', 'selector' => '.icon'),
                                                array('property' => 'letter-spacing', 'label' => 'Letter Spacing', 'selector' => '.icon'),
                                                array('property' => 'float', 'label' => 'Float', 'selector' => '.icon'),
                                                array('property' => 'width', 'label' => 'Widht','selector' => '.icon'),
                                                array('property' => 'height', 'label' => 'Height', 'selector' => '.icon'),
                                                array('property' => 'display', 'label' => 'Display', 'selector' => '.icon'),
                                                array('property' => 'border', 'label' => 'Border', 'selector' => '.icon'),
                                                array('property' => 'box-shadow', 'label' => 'Box Shadow', 'selector' => '.icon'),
                                                array('property' => 'box-shadow', 'label' => 'Hover Box Shadow', 'selector' => ':hover .icon'),
                                                array('property' => 'border-radius', 'label' => 'Border Radius', 'selector' => '.icon'),
                                                array('property' => 'padding', 'label' => 'Padding', 'selector' => '.icon'),
                                                array('property' => 'margin', 'label' => 'Margin', 'selector' => '.icon') 
                                            ),
                                            'Read More' => array(
                                                array('property' => 'color', 'label' => 'Color','selector' => '.bttn-more'),
                                                array('property' => 'color', 'label' => 'Hover Color','selector' => '.bttn-more:hover'),
                                                array('property' => 'background-color', 'label' => 'Background Color', 'selector' => '.bttn-more'),
                                                array('property' => 'background-color', 'label' => 'Hover Background Color', 'selector' => '.bttn-more:hover'),
                                                array('property' => 'font-family', 'label' => 'Font Family', 'selector' => '.bttn-more'),
                                                array('property' => 'font-size', 'label' => 'Font Size', 'selector' => '.bttn-more'),
                                                array('property' => 'font-weight', 'label' => 'Font Weight', 'selector' => '.bttn-more'),
                                                array('property' => 'line-height', 'label' => 'Line Height', 'selector' => '.bttn-more'),
                                                array('property' => 'text-transform', 'label' => 'Text Transform', 'selector' => '.bttn-more'),
                                                array('property' => 'text-align', 'label' => 'Text Align', 'selector' => '.bttn-more'),
                                                array('property' => 'letter-spacing', 'label' => 'Letter Spacing', 'selector' => '.bttn-more'),
                                                array('property' => 'float', 'label' => 'Float', 'selector' => '.bttn-more'),
                                                array('property' => 'display', 'label' => 'Display', 'selector' => '.bttn-more'),
                                                array('property' => 'border', 'label' => 'Border', 'selector' => '.bttn-more'),
                                                array('property' => 'box-shadow', 'label' => 'Box Shadow', 'selector' => '.bttn-more'),
                                                array('property' => 'box-shadow', 'label' => 'Hover Box Shadow', 'selector' => '.bttn-more:hover'),
                                                array('property' => 'border-radius', 'label' => 'Border Radius', 'selector' => '.bttn-more'),
                                                array('property' => 'padding', 'label' => 'Padding', 'selector' => '.bttn-more'),
                                                array('property' => 'margin', 'label' => 'Margin', 'selector' => '.bttn-more') 
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
                )
            );
        }   
    }
}
if( !function_exists('acrony_feature_content') ){
    function acrony_feature_content( $attr, $content = '' ){
        extract($attr); 
        $box_element = array();        
        $el_classes = apply_filters( 'kc-el-class', $attr );
        $el_classes[] = 'feature-box';
        $el_classes[] = esc_attr($box_style_type);        
        $box_element[] = '<div class="'.implode( ' ', $el_classes ).'">';      
        if( $icon_type == 'image' && !empty($image_icon) ){
            $box_element[] = '<div class="icon image">';
            $box_element[] = wp_get_attachment_image($image_icon,'large');
            $box_element[] = '</div>';
        }         
        if( $icon_type == 'font' && !empty($font_icon) ){
            $box_element[] = '<div class="icon font">';
            $box_element[] = '<i class="'.esc_attr($font_icon).'"></i>';
            $box_element[] = '</div>';
        }         
        if( !empty($title) ){
            $box_element[] = '<h4 class="title">'.esc_html($title).'</h4>';
        }     
        if( !empty($desc) ){
            $box_element[] = '<div class="desc">'.wp_kses($desc,wp_kses_allowed_html('post')).'</div>';
        } 
        if( $read_more_show == 'yes'){
            $more_link = explode('|',$more_link);
            $link_attr = array();            
            $link_attr[] = ( !empty($more_link[0]) ? 'href="'.esc_url($more_link[0]).'"' : 'href="#"' );
            $link_attr[] = ( !empty($more_link[1]) ? 'title="'.esc_attr($more_link[1]).'"' : '' );
            $link_attr[] = ( !empty($more_link[2]) ? 'target="'.esc_attr($more_link[2]).'"' : '' );
            $link_attr[] = 'class="bttn-more"';
            $box_element[] = '<a '.implode( ' ', $link_attr ).' >'.( !empty($more_link[1]) ? esc_html($more_link[1]) : __('Read More','acrony-core' ) ).'</a>';           
        }        
        $box_element[] = '</div>';        
        $data = implode( ' ', $box_element );   
        return $data;
    }
}
add_shortcode( 'acrony_feature' , 'acrony_feature_content' );
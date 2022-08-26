<?php
add_action( 'init','acrony_price_addons',99 );
if( !function_exists('acrony_price_addons') ){
    function acrony_price_addons(){
        if( function_exists('kc_add_map') ){
            kc_add_map(array(
                'acrony_price' => array(
                    'name'      => __( 'Price Table' , 'acrony-core' ),
                    'icon'      => 'acrony_icon icon_price',
                    'category'  => 'Acrony',
                    'params'    => array(
                        'General' => array(
                            array(
                                'name' => 'use_ribbon',
                                'type' => 'toggle',
                                'label' => esc_html__('Use Ribbon','acrony-core')
                            ),                            
                            array(
                                'name' => 'ribbon_text',
                                'type' => 'text',
                                'label' => esc_html__( 'Ribbon Text','acrony-core'),
                                'relation' => array(
                                    'parent' => 'use_ribbon',
                                    'show_when' => 'yes'
                                )
                            ),                            
                            array(
                                'name' => 'icon_type',
                                'label' => esc_html__( 'Icon Type', 'acrony-core' ),
                                'type' => 'select',
                                'options' => array(
                                    'none' => esc_html__( 'None','acrony-core' ),
                                    'image_icon' => esc_html__( 'Image Icon','acrony-core' ),
                                    'font_icon' => esc_html__( 'Font Icon','acrony-core' ),
                                ),
                                'value' => 'none'
                            ),
                            array(
                                'name' => 'image_icon',
                                'label' => esc_html__( 'Image Icon','acrony-core' ),
                                'type' => 'attach_image',
                                'relation' => array(
                                    'parent' => 'icon_type',
                                    'show_when' => 'image_icon'
                                )
                            ),
                            array(
                                'name' => 'font_icon',
                                'label' => esc_html__( 'Font Icon', 'acrony-core' ),
                                'type' => 'icon_picker',
                                'relation' => array(
                                    'parent' => 'icon_type',
                                    'show_when' => 'font_icon'
                                )
                            ),
                            array(
                                'name' => 'price_title',
                                'label' => esc_html__('Price Title','acrony-core'),
                                'type' => 'text'
                            ),
                            array(
                                'name' => 'price_rate',
                                'label' => esc_html__('Price rate','acrony-core'),
                                'type' => 'text'
                            ),
                            array(
                                'name' => 'price_time',
                                'label' => esc_html__('Price Time','acrony-core'),
                                'type' => 'text',
                                'value' => 'Per Month',
                                'description' => esc_html__('Per Year/Per Month/Per Day . Default Set Per Month','acrony-core')
                            ),
                            array(
                                'name' => 'price_content',
                                'label' => esc_html__('Price Content','acrony-core'),
                                'type' => 'editor'
                            ),
                            array(
                                'name' => 'button_switch',
                                'label' => esc_html__('Hide Button','acrony-core'),
                                'type' => 'toggle'
                            ),
                            array(
                                'name' => 'button_link',
                                'label' => esc_html__('Price Button','acrony-core'),
                                'type' => 'link',
                                'relation' => array(
                                    'parent' => 'button_switch',
                                    'hide_when' => 'yes'
                                )
                            ),                            
                            array(
                                'name' => 'button_template',
                                'label' => __('Button Template','acrony-core'),
                                'type' => 'dropdown',
                                'options' => array(
                                    'button_1' => esc_html__( 'Normal Button','acrony-core' ),
                                    'button_2' => esc_html__( 'Transparent Button','acrony-core' ),
                                ),
                                'value' => 'button_1',
                                'description' => esc_html__('Default Select Template: Button 1','acrony-core'),
                                'relation' => array(
                                    'parent' => 'button_switch',
                                    'hide_when' => 'yes'
                                )
                            ),
                            array(
                                'name' => 'ex_class',
                                'label' => esc_html__('Extra Custom Class','acrony-core'),
                                'type' => 'text'
                            ),
                        ),
                        'Style' => array(
                            array(
                                'name' => 'acrony_price_table',
                                'type' => 'css',
                                'options' => array(
                                    array(
								        "screens" => "any,1024,999,767,479",
                                        'Boxes' => array(
                                            array('property' => 'background', 'label' => 'Background Color'),
                                            array('property' => 'background-color', 'label' => 'Hover BG Color', 'selector' => ':hover'),
                                            array('property' => 'text-align', 'label' => 'Text Align'),
                                            array('property' => 'border', 'label' => 'Border'),
                                            array('property' => 'border-color', 'label' => 'Border Color Hover', 'selector' => ':hover'),
                                            array('property' => 'box-shadow', 'label' => 'Box Shadow'),
                                            array('property' => 'box-shadow', 'label' => 'Box Shadow Hover', 'selector' => ':hover'),
                                            array('property' => 'display', 'label' => 'Display'),
                                            array('property' => 'border-radius', 'label' => 'Border Radius'),
                                            array('property' => 'border-radius', 'label' => 'Border Radius Hover', 'selector' => ':hover'),
                                            array('property' => 'padding', 'label' => 'Padding'),
                                            array('property' => 'margin', 'label' => 'Margin'),
                                        ),
                                        'Title' => array(
                                            array('property' => 'color', 'label' => 'Color', 'selector' => '.price-title'),
                                            array('property' => 'font-family', 'label' => 'Font Family', 'selector' => '.price-title'),
                                            array('property' => 'font-size', 'label' => 'Font Size', 'selector' => '.price-title'),
                                            array('property' => 'font-weight', 'label' => 'Font Weight', 'selector' => '.price-title'),
                                            array('property' => 'line-height', 'label' => 'Line Height', 'selector' => '.price-title'),
                                            array('property' => 'text-transform', 'label' => 'Text Transform', 'selector' => '.price-title'),
                                            array('property' => 'text-align', 'label' => 'Text Align', 'selector' => '.price-title'),
                                            array('property' => 'margin', 'label' => 'Margin', 'selector' => '.price-title'),
                                            array('property' => 'padding', 'label' => 'Padding', 'selector' => '.price-title'),
                                        ),
                                        'Rate' => array(
                                            array('property' => 'color', 'label' => 'Color', 'selector' => '.price-rate'),
                                            array('property' => 'font-family', 'label' => 'Font Family', 'selector' => '.price-rate'),
                                            array('property' => 'font-size', 'label' => 'Font Size', 'selector' => '.price-rate'),
                                            array('property' => 'font-weight', 'label' => 'Font Weight', 'selector' => '.price-rate'),
                                            array('property' => 'line-height', 'label' => 'Line Height', 'selector' => '.price-rate'),
                                            array('property' => 'text-transform', 'label' => 'Text Transform', 'selector' => '.price-rate'),
                                            array('property' => 'display', 'label' => 'Display', 'selector' => '.price-rate'),
                                            array('property' => 'text-align', 'label' => 'Text Align', 'selector' => '.price-rate'),
                                            array('property' => 'margin', 'label' => 'Margin', 'selector' => '.price-rate'),
                                            array('property' => 'padding', 'label' => 'Padding', 'selector' => '.price-rate'),
                                        ),
                                        'Time' => array(
                                            array('property' => 'color', 'label' => 'Color', 'selector' => '.price-time'),
                                            array('property' => 'color', 'label' => 'Hover Color', 'selector' => ':hover .price-time'),
                                            array('property' => 'background', 'label' => 'Background', 'selector' => '.price-time'),
                                            array('property' => 'background', 'label' => 'Hover Background', 'selector' => ':hover .price-time'),
                                            array('property' => 'font-family', 'label' => 'Font Family', 'selector' => '.price-time'),
                                            array('property' => 'font-size', 'label' => 'Font Size', 'selector' => '.price-time'),
                                            array('property' => 'font-weight', 'label' => 'Font Weight', 'selector' => '.price-time'),
                                            array('property' => 'line-height', 'label' => 'Line Height', 'selector' => '.price-time'),
                                            array('property' => 'border', 'label' => 'Border', 'selector' => '.price-time'),
                                            array('property' => 'box-shadow', 'label' => 'Box Shadow', 'selector' => '.price-time'),
                                            array('property' => 'text-transform', 'label' => 'Text Transform', 'selector' => '.price-time'),
                                            array('property' => 'text-align', 'label' => 'Text Align', 'selector' => '.price-time'),
                                            array('property' => 'display', 'label' => 'Display', 'selector' => '.price-time'),
                                            array('property' => 'margin', 'label' => 'Margin', 'selector' => '.price-time'),
                                            array('property' => 'padding', 'label' => 'Padding', 'selector' => '.price-time'),
                                        ),
                                        'Content' => array(
                                            array('property' => 'color', 'label' => 'Color', 'selector' => '.price-content'),
                                            array('property' => 'font-family', 'label' => 'Font Family', 'selector' => '.price-content'),
                                            array('property' => 'font-size', 'label' => 'Font Size', 'selector' => '.price-content'),
                                            array('property' => 'font-weight', 'label' => 'Font Weight', 'selector' => '.price-content'),
                                            array('property' => 'line-height', 'label' => 'Line Height', 'selector' => '.price-content'),
                                            array('property' => 'text-transform', 'label' => 'Text Transform', 'selector' => '.price-content'),
                                            array('property' => 'text-align', 'label' => 'Text Align', 'selector' => '.price-content'),
                                            array('property' => 'padding', 'label' => 'Padding', 'selector' => '.price-content'),
                                            array('property' => 'margin', 'label' => 'Margin', 'selector' => '.price-content'),
                                        ),
                                        'Button' => array(
                                            array('property' => 'color', 'label' => 'Button Color', 'selector' => '.bttn' ),
                                            array('property' => 'color', 'label' => 'Button Hover Color', 'selector' => '.bttn:hover' ),
                                            array('property' => 'background', 'label' => 'Button BG Color', 'selector' => '.bttn' ),
                                            array('property' => 'background', 'label' => 'Button BG Hover Color', 'selector' => '.bttn:hover' ),
                                            array('property' => 'font-family', 'label' => 'Font Family', 'selector' => '.bttn' ),
                                            array('property' => 'font-size', 'label' => 'Font Size', 'selector' => '.bttn' ),
                                            array('property' => 'line-height', 'label' => 'Line Height', 'selector' => '.bttn' ),
                                            array('property' => 'font-weight', 'label' => 'Font Weight', 'selector' => '.bttn' ),
                                            array('property' => 'display', 'label' => 'Display', 'selector' => '.bttn' ),
                                            array('property' => 'float', 'label' => 'Float', 'selector' => '.bttn' ),
                                            array('property' => 'text-transform', 'label' => 'Text Transform', 'selector' => '.bttn' ),
                                            array('property' => 'box-shadow', 'label' => 'Box Shadow', 'selector' => '.bttn' ),
                                            array('property' => 'box-shadow', 'label' => 'Hover Shadow', 'selector' => '.bttn:hover' ),
                                            array('property' => 'border', 'label' => 'Button Border', 'selector' => '.bttn' ),
                                            array('property' => 'border-color', 'label' => 'Button Border Color Hover', 'selector' => '.bttn:hover' ),
                                            array('property' => 'border-radius', 'label' => 'Border Radius', 'selector' => '.bttn' ),
                                            array('property' => 'margin', 'label' => 'Margin', 'selector' => '.bttn' ),
                                            array('property' => 'padding', 'label' => 'Padding', 'selector' => '.bttn' )
                                        ),                                        
                                        'Ribbon' => array(
                                            array('property' => 'color', 'label' => 'Color', 'selector' => '.ribbon'),
                                            array('property' => 'color', 'label' => 'Hover Color', 'selector' => ':hover .ribbon'),
                                            array('property' => 'background-color', 'label' => 'Background Color', 'selector' => '.ribbon'),
                                            array('property' => 'background-color', 'label' => 'Hover BG Color', 'selector' => ':hover .ribbon'),
                                            array('property' => 'font-size', 'label' => 'Font Size', 'selector' => '.ribbon'),                                          
                                            array('property' => 'font-weight', 'label' => 'Font Weight', 'selector' => '.ribbon'),
                                            array('property' => 'text-align', 'label' => 'Text Align', 'selector' => '.ribbon'),
                                            array('property' => 'text-transform', 'label' => 'Text Transform', 'selector' => '.ribbon'),
                                            array('property' => 'line-height', 'label' => 'Line Height', 'selector' => '.ribbon'),
                                            array('property' => 'letter-spacing', 'label' => 'Letter Spacing', 'selector' => '.ribbon'),
                                            array('property' => 'position', 'label' => 'Position', 'selector' => '.ribbon'),
                                            array('property' => 'top', 'label' => 'Top', 'selector' => '.ribbon'),
                                            array('property' => 'bottom', 'label' => 'Bottom', 'selector' => '.ribbon'),
                                            array('property' => 'left', 'label' => 'Left', 'selector' => '.ribbon'),
                                            array('property' => 'right', 'label' => 'Right', 'selector' => '.ribbon'),
                                            array('property' => 'transform', 'label' => 'Transform', 'selector' => '.ribbon'),
                                            array('property' => 'margin', 'label' => 'Margin', 'selector' => '.ribbon'),
                                            array('property' => 'padding', 'label' => 'Paddin', 'selector' => '.ribbon'),
                                            array('property' => 'width', 'label' => 'Width', 'selector' => '.ribbon'),
                                            array('property' => 'height', 'label' => 'Height', 'selector' => '.ribbon'),
                                            array('property' => 'box-shadow', 'label' => 'Box Shadow', 'selector' => '.ribbon'),
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
                                    )
                                )
                            )
                        ),
                        'animate' => array(
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

if( !function_exists('acrony_price_content') ){
    function acrony_price_content( $attr, $content = '' ){
        $button_switch = $price_title = $price_rate = $price_time = $price_content = $button_link = $button_template = '';
        $button_attr = array();
        extract($attr);
        $el_classes = apply_filters( 'kc-el-class', $attr );
        $el_classes[] = 'price-box';
        if( isset($ex_class) and !empty($ex_class) ){
            $el_classes[] = esc_attr($ex_class);
        }        
        $button_link = explode( '|',$button_link);
        $button_attr[] = 'href="'.( !empty($button_link[0]) ? esc_url($button_link[0]) : '#' ).'"';
        $button_attr[] = ( !empty($button_link[1]) ? 'title="'.esc_attr($button_link[1]).'"' : '' );
        $button_attr[] = ( !empty($button_link[2]) ? 'target="'.esc_attr($button_link[2]).'"' : '' );
        $button_attr[] = 'class="bttn '.esc_attr($button_template).'"';        
        $data = array();        
        $data[] = '<div class="'.implode( ' ', $el_classes ).'">';        
        $data[] = '<div class="price-header">';        
        if( $use_ribbon == 'yes' and !empty($ribbon_text) ){
            $data[] = '<span class="ribbon">'.esc_html($ribbon_text).'</span>';
        }              
        if( $icon_type == 'image_icon' && !empty($image_icon) ){
            $data[] = '<div class="icon image">';
            $data[] = wp_get_attachment_image($image_icon,'large');
            $data[] = '</div>';
        }         
        if( $icon_type == 'font_icon' && !empty($font_icon) ){
            $data[] = '<div class="icon font">';
            $data[] = '<i class="'.esc_attr($font_icon).'"></i>';
            $data[] = '</div>';
        }        
        if( isset($price_title) and !empty($price_title) ){
            $data[] = '<div class="price-title">'.esc_html($price_title).'</div>';
        }
        if( isset($price_rate) and !empty($price_rate) ){
            $data[] = '<div class="price-rate">'.esc_html($price_rate).'</div>';
        }
        if( isset($price_time) and !empty($price_time) ){
            $data[] = '<div class="price-time">'.esc_html($price_time).'</div>';
        }        
        $data[] = '</div>';        
        if( isset($price_content) and !empty($price_content) ){
            $data[] = '<div class="price-content">'.wp_kses( $price_content, wp_kses_allowed_html('post') ).'</div>';
        }
        if( $button_switch != 'yes' ){
            $data[] = '<div class="footer"><a '.implode( ' ' , $button_attr ).'>'.( !empty($button_link[1]) ? esc_html($button_link[1]) : esc_html__( 'Start Using Free' , 'acrony-core' ) ).'</a></div>';
        }
        $data[] = '</div>';        
        $data = implode( ' ', $data );
        
        return $data;
    }    
}

add_shortcode( 'acrony_price','acrony_price_content' );
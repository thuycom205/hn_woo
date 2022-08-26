<?php
add_action( 'init','acrony_counter_addons',99);
    function acrony_counter_addons(){
        if( function_exists('kc_add_map') ){
            kc_add_map(array(
                'acrony_counter' => array(
                    'name' => esc_html__( 'Counter','acrony-core'),
                    'icon' => 'acrony_icon icon_counter',
                    'category' => 'Acrony',
                    'params' => array(
                        'General' => array(
                            array(
                                'name'  => 'show_icon',
                                'label' => __( 'Show Icon','acrony-core'),
                                'type'  => 'toggle',
                                'description' => __( 'To use check here.','acrony-core' )
                            ),
                            array(
                                'name' => 'icon_type',
                                'label' => __( 'Icon Type','acrony-core' ),
                                'type' => 'dropdown',
                                'options' => array(
                                    'image_icon' => __( 'Image Icon','acrony-core'),
                                    'font_icon' => __( 'Font Icon','acrony-core')
                                ),
                                'relation' => array(
                                    'parent' => 'show_icon',
                                    'show_when' => 'yes'
                                )
                            ),
                            array(
                                'name' => 'image_icon',
                                'type' => 'attach_image',
                                'label' => __( 'Select Image','acrony-core' ),
                                'description' => __( 'Please select the image icon form here.','acrony-core' ),
                                'relation' => array(
                                    'parent' => 'icon_type',
                                    'show_when' => 'image_icon'
                                )
                            ),
                            array(
                                'name' => 'font_icon',
                                'type' => 'icon_picker',
                                'label' => __( 'Choose Icon','acrony-core' ),
                                'description' => __( 'Plase choose the font icon.','acrony-core' ),
                                'relation' => array(
                                    'parent' => 'icon_type',
                                    'show_when' => 'font_icon'
                                )
                            ),
                            array(
                                'name' => 'count_number',
                                'type' => 'text',
                                'label' => __( 'Counter Number','acrony-core' ),
                                'description' => __( 'The targeted number to count up to (From zero).','acrony-core' )
                            ),
                            array(
                                'name' => 'count_desc',
                                'type' => 'text',
                                'label' => __( 'Counter Label','acrony-core' ),
                                'description' => __( 'The text description of the counter.','acrony-core' )
                            ),
                            array(
                                'name' => 'ex_class',
                                'type' => 'text',
                                'label' => __( 'Extra Class','acrony-core' ),
                                'description' => __( 'Custom class for wrapper of the shortcode widget.','acrony-core' )
                            )
                        ),                        
                        'Styling' => array(
                            array(
                                'name' => 'acrony_counter_style',
                                'type' => 'css',
                                'options' => array(
                                    array(
                                        "screens" => "any,1024,992,768,480",
                                        'Boxes' => array(
                                            array('property' => 'background-color', 'label' =>  esc_html__('Background','acrony-core')),
                                            array('property' => 'background-color', 'label' =>  esc_html__('Hover BG','acrony-core'), 'selector' => ':hover'),
                                            array('property' => 'text-align', 'label' =>  esc_html__('Text Align','acrony-core')),
                                            array('property' => 'border', 'label' =>  esc_html__('Border','acrony-core')),
                                            array('property' => 'border-radius', 'label' =>  esc_html__('Border Radius','acrony-core')),
                                            array('property' => 'box-shadow', 'label' =>  esc_html__('Box Shadow','acrony-core')),
                                            array('property' => 'box-shadow', 'label' =>  esc_html__('Hover Box Shadow','acrony-core'),'selector' => ':hover'),
                                            array('property' => 'transform', 'label' =>  esc_html__('Transform','acrony-core')),
                                            array('property' => 'transform', 'label' =>  esc_html__('Hover Transform','acrony-core'),'selector' => ':hover'),
                                            array('property' => 'margin', 'label' =>  esc_html__('Margin','acrony-core')),
                                            array('property' => 'padding', 'label' =>  esc_html__('Padding','acrony-core')),
                                            array('property' => 'width', 'label' =>  esc_html__('Width','acrony-core')),
                                            array('property' => 'height', 'label' =>  esc_html__('Height','acrony-core')),
                                            array('property' => 'overflow', 'label' =>  esc_html__('Overflow','acrony-core'))
                                        ),
                                        'Icon' => array(
                                            array('property' => 'color', 'label' =>  esc_html__('Color','acrony-core'), 'selector' => '.icon' ),
                                            array('property' => 'color', 'label' =>  esc_html__('Hover Color','acrony-core'), 'selector' => ':hover .icon'),
                                            array('property' => 'background-color', 'label' =>  esc_html__('Background Color','acrony-core'), 'selector' => '.icon'),
                                            array('property' => 'background-color', 'label' =>  esc_html__('Hover BG Color','acrony-core'), 'selector' => ':hover .icon' ),
                                            array('property' => 'font-size', 'label' =>  esc_html__('Font Size','acrony-core'), 'selector' => '.icon'),
                                            array('property' => 'line-height', 'label' =>  esc_html__('Line Height','acrony-core'), 'selector' => '.icon'),
                                            array('property' => 'border', 'label' =>  esc_html__('Border','acrony-core'), 'selector' => '.icon'),
                                            array('property' => 'float', 'label' =>  esc_html__('Float','acrony-core'), 'selector' => '.icon'),
                                            array('property' => 'border-radius', 'label' =>  esc_html__('Border Radius','acrony-core'), 'selector' => '.icon'),
                                            array('property' => 'box-shadow', 'label' =>  esc_html__('Box Shadow','acrony-core'), 'selector' => '.icon'),
                                            array('property' => 'box-shadow', 'label' =>  esc_html__('Hover Box Shadow','acrony-core'), 'selector' => ':hover .icon'),
                                            array('property' => 'margin', 'label' =>  esc_html__('Margin','acrony-core'), 'selector' => '.icon'),
                                            array('property' => 'padding', 'label' =>  esc_html__('Padding','acrony-core'), 'selector' => '.icon'),
                                            array('property' => 'width', 'label' =>  esc_html__('Width','acrony-core'), 'selector' => '.icon'),
                                            array('property' => 'height', 'label' =>  esc_html__('Height','acrony-core'), 'selector' => '.icon'),
                                            array('property' => 'overflow', 'label' =>  esc_html__('Overflow','acrony-core'), 'selector' => '.icon')
                                        ),
                                        'Number' => array(
                                            array('property' => 'color', 'label' =>  esc_html__('Color','acrony-core'), 'selector' => '.counterup' ),
                                            array('property' => 'color', 'label' =>  esc_html__('Hover Color','acrony-core'), 'selector' => ':hover .counterup' ),
                                            array('property' => 'font-family', 'label' =>  esc_html__('Font Family','acrony-core'), 'selector' => '.counterup' ),
                                            array('property' => 'font-size', 'label' =>  esc_html__('Font Size','acrony-core'), 'selector' => '.counterup' ),
                                            array('property' => 'font-weight', 'label' =>  esc_html__('Font Weight','acrony-core'), 'selector' => '.counterup' ),
                                            array('property' => 'font-style', 'label' =>  esc_html__('Font Style','acrony-core'), 'selector' => '.counterup' ),
                                            array('property' => 'text-decoration', 'label' =>  esc_html__('Text Decoration','acrony-core'), 'selector' => '.counterup' ),
                                            array('property' => 'text-shadow', 'label' =>  esc_html__('Text Shadow','acrony-core'), 'selector' => '.counterup' ),
                                            array('property' => 'line-height', 'label' =>  esc_html__('Line Height','acrony-core'), 'selector' => '.counterup' ),
                                            array('property' => 'letter-spacing', 'label' =>  esc_html__('Letter Spacing','acrony-core'), 'selector' => '.counterup' ),
                                            array('property' => 'border', 'label' =>  esc_html__('Border','acrony-core'), 'selector' => '.counterup' ),
                                            array('property' => 'display', 'label' =>  esc_html__('Display','acrony-core'), 'selector' => '.counterup' ),
                                            array('property' => 'margin', 'label' =>  esc_html__('Margin','acrony-core'), 'selector' => '.counterup' ),
                                            array('property' => 'padding', 'label' =>  esc_html__('Padding','acrony-core'), 'selector' => '.counterup' )                                            
                                        ),
                                        'Label' => array(
                                            array('property' => 'color', 'label' =>  esc_html__('Color','acrony-core'), 'selector' => '.title' ),
                                            array('property' => 'color', 'label' =>  esc_html__('Hover Color','acrony-core'), 'selector' => ':hover .title' ),
                                            array('property' => 'font-family', 'label' =>  esc_html__('Font Family','acrony-core'), 'selector' => '.title' ),
                                            array('property' => 'font-size', 'label' =>  esc_html__('Font Size','acrony-core'), 'selector' => '.title' ),
                                            array('property' => 'font-weight', 'label' =>  esc_html__('Font Weight','acrony-core'), 'selector' => '.title' ),
                                            array('property' => 'font-style', 'label' =>  esc_html__('Font Style','acrony-core'), 'selector' => '.title' ),
                                            array('property' => 'text-decoration', 'label' =>  esc_html__('Text Decoration','acrony-core'), 'selector' => '.title' ),
                                            array('property' => 'text-shadow', 'label' =>  esc_html__('Text Shadow','acrony-core'), 'selector' => '.title' ),
                                            array('property' => 'line-height', 'label' =>  esc_html__('Line Height','acrony-core'), 'selector' => '.title' ),
                                            array('property' => 'letter-spacing', 'label' =>  esc_html__('Letter Spacing','acrony-core'), 'selector' => '.title' ),
                                            array('property' => 'border', 'label' =>  esc_html__('Border','acrony-core'), 'selector' => '.title' ),
                                            array('property' => 'display', 'label' =>  esc_html__('Display','acrony-core'), 'selector' => '.title' ),
                                            array('property' => 'margin', 'label' =>  esc_html__('Margin','acrony-core'), 'selector' => '.title' ),
                                            array('property' => 'padding', 'label' =>  esc_html__('Padding','acrony-core'), 'selector' => '.title' )                                            
                                        )
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

if( !function_exists('acrony_counter_content') ){
    function acrony_counter_content( $atts, $content = '' ){
        extract($atts);        
        $box_element = array();
        
        $el_classes = apply_filters( 'kc-el-class', $atts );
        $el_classes[] = 'counter-box';
        
        // CounterUp Box
        $box_element[] = '<div class="'.implode( ' ', $el_classes ).'">';        
        
        // CounterUp Icon
        if( $show_icon == 'yes' ){
            if( $icon_type == 'font_icon' and !empty($font_icon) ){   
                $box_element[] = '<div class="icon">';
                $box_element[] = '<i class="'.esc_attr($font_icon).'"></i>';
                $box_element[] = '</div>';
            }
            if( $icon_type == 'image_icon' and !empty($image_icon) ){   
                $box_element[] = '<div class="icon">';
                $box_element[] = wp_get_attachment_image( esc_html($image_icon) );
                $box_element[] = '</div>';
            }            
        }        
                
        // CoiunterUp Label
        if( !empty($count_desc) ){
            $box_element[] = '<div class="title">'.esc_html($count_desc).'</div>';
        }
		
        // CounterUp Targeted Number
        if( !empty($count_number) ){
            $box_element[] = '<div class="counterup">'.esc_html($count_number).'</div>';
            wp_enqueue_script('waypoints');
            wp_enqueue_script('counter-up');
        }   

        
        $box_element[] = '</div>';
        
        $data = implode( ' ',$box_element);
        return $data;        
    }
}
add_shortcode( 'acrony_counter','acrony_counter_content' );
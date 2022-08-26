<?php

add_action( 'init' , 'acrony_text_box_addons' , 99 );
if( !function_exists('acrony_text_box_addons') ){
    function acrony_text_box_addons(){
        if( function_exists('kc_add_map') ){
            kc_add_map(array(
                'acrony_text_box' => array(
                    'name' => esc_html__( 'Text Box','acrony-core'),
                    'icon' => 'acrony_icon icon_text_box',
                    'category' => 'Acrony',  
                    'params' => array(
                        'General' => array(
                            array(
                                'name' => 'top_title',
                                'label' => esc_html__( 'Top Title' , 'acrony-core' ),
                                'type' => 'text'
                            ),
                            array(
                                'name' => 'title',
                                'label' => esc_html__( 'Title' , 'acrony-core' ),
                                'type' => 'text'
                            ),                           
                            array(
                                'name'      => 'heading_type',
                                'label'     => esc_html__('Title Heading Type','acrony-core'),
                                'type'      => 'select',
                                'options'   => array(
                                    'h1'    => 'H1',
                                    'h2'    => 'H2',
                                    'h3'    => 'H3',
                                    'h4'    => 'H4',
                                    'h5'    => 'H5',
                                    'h6'    => 'H6',
                                ),
                                'value'     => 'h3',
                                'description' => esc_html__('Default Heading type is: H3','acrony-core')
                            ),
                            array(
                                'name' => 'desc',
                                'label' => esc_html__( 'Description' , 'acrony-core' ),
                                'type' => 'textarea'
                            ), 
                            array(
                                'name' => 'show_button',
                                'label' => esc_html__( 'Show Read More Button' , 'acrony-core' ),
                                'type' => 'toggle'
                            ),
                            array(
                                'name' => 'button_link',
                                'label' => esc_html__( 'Button Link','acrony-core' ),
                                'type' => 'link',
                                'relation' => array(
                                    'parent' => 'show_button',
                                    'show_when' => 'yes'
                                )
                            ),                            
                            array(
                                'name' => 'button_template',
                                'label' => __('Button Template','acrony-core'),
                                'type' => 'dropdown',
                                'options' => array(
                                    'button_1' => esc_html__( "Normal Button", "acrony-core" ),
                                    'button_2' => esc_html__( "Transparent Button", "acrony-core" ),
                                ),
                                'value' => 'button_1',
                                'description' => esc_html__('Default Select Template: Button 1','acrony-core'),
                                'relation' => array(
                                    'parent' => 'show_button',
                                    'show_when' => 'yes'
                                )
                            ),
                            array(
                                'name' => 'extra_class',
                                'label' => esc_html__( 'Custom Class','acrony-core' ),
                                'type' => 'text',
                                'description' => esc_html__( 'Enter extra custom class','acrony-core' )
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
                                            array('property' => 'box-shadow', 'label' => 'Box Shadow'),
                                            array('property' => 'box-shadow', 'label' => 'Hover Box Shadow', 'selector' => ':hover'),
                                            array('property' => 'border-radius', 'label' => 'Border Radius'),
                                            array('property' => 'padding', 'label' => 'Padding'),
                                            array('property' => 'margin', 'label' => 'Margin')
                                        ),
                                        'Title' => array(
                                            array('property' => 'color', 'label' => 'Color','selector' => '.title'),
                                            array('property' => 'background-color', 'label' => 'Background Color', 'selector' => '.title'),
                                            array('property' => 'font-family', 'label' => 'Font Family', 'selector' => '.title'),
                                            array('property' => 'font-size', 'label' => 'Font Size', 'selector' => '.title'),
                                            array('property' => 'font-weight', 'label' => 'Font Weight', 'selector' => '.title'),
                                            array('property' => 'line-height', 'label' => 'Line Height', 'selector' => '.title'),
                                            array('property' => 'text-transform', 'label' => 'Text Transform', 'selector' => '.title'),
                                            array('property' => 'text-align', 'label' => 'Text Align', 'selector' => '.title'),
                                            array('property' => 'letter-spacing', 'label' => 'Letter Spacing', 'selector' => '.title'),
                                            array('property' => 'border', 'label' => 'Border', 'selector' => '.title'),
                                            array('property' => 'box-shadow', 'label' => 'Box Shadow', 'selector' => '.title'),
                                            array('property' => 'padding', 'label' => 'Padding', 'selector' => '.title'),
                                            array('property' => 'margin', 'label' => 'Margin', 'selector' => '.title')
                                        ),
                                        'Top Title' => array(
                                            array('property' => 'color', 'label' => 'Color','selector' => '.top-title'),
                                            array('property' => 'background-color', 'label' => 'Background Color', 'selector' => '.top-title'),
                                            array('property' => 'font-family', 'label' => 'Font Family', 'selector' => '.top-title'),
                                            array('property' => 'font-size', 'label' => 'Font Size', 'selector' => '.top-title'),
                                            array('property' => 'font-weight', 'label' => 'Font Weight', 'selector' => '.top-title'),
                                            array('property' => 'line-height', 'label' => 'Line Height', 'selector' => '.top-title'),
                                            array('property' => 'text-transform', 'label' => 'Text Transform', 'selector' => '.top-title'),
                                            array('property' => 'text-align', 'label' => 'Text Align', 'selector' => '.top-title'),
                                            array('property' => 'letter-spacing', 'label' => 'Letter Spacing', 'selector' => '.top-title'),
                                            array('property' => 'border', 'label' => 'Border', 'selector' => '.top-title'),
                                            array('property' => 'box-shadow', 'label' => 'Box Shadow', 'selector' => '.top-title'),
                                            array('property' => 'padding', 'label' => 'Padding', 'selector' => '.top-title'),
                                            array('property' => 'margin', 'label' => 'Margin', 'selector' => '.top-title')
                                        ),
                                        'Desc' => array(
                                            array('property' => 'color', 'label' => 'Color','selector' => '.desc'),
                                            array('property' => 'background-color', 'label' => 'Background Color', 'selector' => '.desc'),
                                            array('property' => 'font-family', 'label' => 'Font Family', 'selector' => '.desc'),
                                            array('property' => 'font-size', 'label' => 'Font Size', 'selector' => '.desc'),
                                            array('property' => 'font-weight', 'label' => 'Font Weight', 'selector' => '.desc'),
                                            array('property' => 'line-height', 'label' => 'Line Height', 'selector' => '.desc'),
                                            array('property' => 'text-transform', 'label' => 'Text Transform', 'selector' => '.desc'),
                                            array('property' => 'text-align', 'label' => 'Text Align', 'selector' => '.desc'),
                                            array('property' => 'letter-spacing', 'label' => 'Letter Spacing', 'selector' => '.desc'),
                                            array('property' => 'border', 'label' => 'Border', 'selector' => '.desc'),
                                            array('property' => 'box-shadow', 'label' => 'Box Shadow', 'selector' => '.desc'),
                                            array('property' => 'padding', 'label' => 'Padding', 'selector' => '.desc'),
                                            array('property' => 'margin', 'label' => 'Margin', 'selector' => '.desc')
                                        ),
                                        'Button' => array(
                                            array('property' => 'color', 'label' => 'Color', 'selector' => '.bttn' ),
                                            array('property' => 'background', 'label' => 'Background', 'selector' => '.bttn' ),
                                            array('property' => 'font-family', 'label' => 'Font Family', 'selector' => '.bttn' ),
                                            array('property' => 'font-size', 'label' => 'Font Size', 'selector' => '.bttn' ),
                                            array('property' => 'line-height', 'label' => 'Line Height', 'selector' => '.bttn' ),
                                            array('property' => 'font-weight', 'label' => 'Font Weight', 'selector' => '.bttn' ),
                                            array('property' => 'text-transform', 'label' => 'Text Transform', 'selector' => '.bttn' ),
                                            array('property' => 'text-align', 'label' => 'Align', 'selector' => '.bttn' ),
                                            array('property' => 'letter-spacing', 'label' => 'Letter Spacing', 'selector' => '.bttn' ),
                                            array('property' => 'float', 'label' => 'Float', 'selector' => '.bttn' ),
                                            array('property' => 'width', 'label' => 'Widht', 'selector' => '.bttn' ),
                                            array('property' => 'height', 'label' => 'Height', 'selector' => '.bttn' ),
                                            array('property' => 'display', 'label' => 'Display', 'selector' => '.bttn' ),
                                            array('property' => 'border', 'label' => 'Border', 'selector' => '.bttn' ),
                                            array('property' => 'box-shadow', 'label' => 'Box Shadow', 'selector' => '.bttn' ),
                                            array('property' => 'border-radius', 'label' => 'Border Radius', 'selector' => '.bttn' ),
                                            array('property' => 'padding', 'label' => 'Padding', 'selector' => '.bttn' ),
                                            array('property' => 'margin', 'label' => 'Margin', 'selector' => '.bttn' ) 
                                        ),                                        
                                        'Button Hover' => array(
                                            array('property' => 'color', 'label' => 'Color','selector' => '.bttn:hover'),
                                            array('property' => 'background', 'label' => 'Background', 'selector' => '.bttn:hover'),
                                            array('property' => 'border', 'label' => 'Border', 'selector' => '.bttn:hover'),
                                            array('property' => 'box-shadow', 'label' => 'Box Shadow', 'selector' => '.bttn:hover'),
                                            array('property' => 'border-radius', 'label' => 'Border Radius', 'selector' => '.bttn:hover'),
                                            array('property' => 'padding', 'label' => 'Padding', 'selector' => '.bttn:hover'),
                                            array('property' => 'margin', 'label' => 'Margin', 'selector' => '.bttn:hover')   
                                        ),
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

if( !function_exists('acrony_text_box_content') ){
    function acrony_text_box_content( $atts , $content = ''  ){
        $data = array();
        extract($atts);
        $button_link = explode( '|',$button_link );        
        $text_box_classes = apply_filters( 'kc-el-class', $atts );
        $text_box_classes[] = esc_attr('text-box');
        $text_box_classes[] = ( !empty($extra_class) ? esc_attr($extra_class) : '' );                
        $data[] = '<div class="'.implode( ' ', $text_box_classes ).'">';        
        if( isset($top_title) and !empty($top_title) ){
            $data[] = '<div class="top-title">'.esc_html($top_title).'</div>';
        }                
        if( isset($title) and !empty($title) ){
            $data[] = '<h3 class="title">'.esc_html($title).'</h3>';
        }
        if( isset($desc) and !empty($desc) ){
            $data[] = '<div class="desc">'.wp_kses($desc,wp_kses_allowed_html('post')).'</div>';
        }                
        if( isset($show_button) and $show_button == 'yes' ){            
            $button_attr['href'] = 'href="'.( !empty($button_link[0]) ? esc_url($button_link[0]) : '#' ).'"';
            $button_attr['class'] = 'class="bttn '.( !empty($button_template) ? esc_attr($button_template) : 'button_1' ).'"';
            $button_attr['title'] = ( !empty($button_link[1]) ? 'title="'.esc_attr($button_link[1]).'"' : '' );
            $button_attr['target'] = ( !empty($button_link[2]) ? 'target="'.esc_attr($button_link[2]).'"' : ''  );           
            $data[] = '<a '.implode( ' ',$button_attr ).' >'.( !empty($button_link[1]) ? esc_html($button_link[1]) : esc_html__( 'Read More' , 'acrony-core' )  ).'</a>';
        }
        $data[] = '</div>';        
        $data = implode( ' ', $data );
        return $data;    
    }    
}

add_shortcode( 'acrony_text_box' , 'acrony_text_box_content' );
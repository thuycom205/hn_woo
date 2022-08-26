<?php
add_action( 'init','acrony_page_title_addons',99 );
if( !function_exists('acrony_page_title_addons') ){
    function acrony_page_title_addons(){
        if( function_exists('kc_add_map') ){
            kc_add_map(array(
                'acrony_page_title' => array(
                    'name'      => esc_html__( 'Page Title','acrony-core' ),
                    'icon'      => 'acrony_icon icon_page_title',
                    'category'  => 'Acrony',
                    'params' => array(
                        'General' => array(
                            array(
                                'name' => 'title',
                                'type' => 'text',
                                'label' => esc_html__( 'Title','acrony-core' ),
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
                                'type' => 'textarea',
                                'label' => esc_html__( 'Description','acrony-core' ),
                            ),
                            array(
                                'name' => 'extra_class',
                                'type' => 'text',
                                'label' => __( 'Custom Class','acrony-core' ),
                                'description' => esc_html__( 'If you want to add a new custom class. Please write here.', 'acrony-core' )
                            )
                        ),
                        'Styling' => array(
                            array(
                                'name' => 'acrony_title_style',
                                'type'    => 'css',
                                'options' => array(
                                    array(
                                        "screens" => "any,1024,999,767,479",
                                        'Boxes' => array(
                                            array('property' => 'color', 'label' => 'Color'),
                                            array('property' => 'color', 'label' => 'Hover Color','selector' => ':hover'),
                                            array('property' => 'background', 'label' => 'Background Color'),
                                            array('property' => 'background-color', 'label' => 'Title Bar color', 'selector' => '.dots span'),
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

if( !function_exists('acrony_page_title_content') ){
    function acrony_page_title_content( $attr, $content = '' ){
        extract($attr);
        $data = array(); 
        $el_classes = apply_filters( 'kc-el-class', $attr ); 
        $el_classes[] = 'page-title';       
        $data[] = '<div class="'.implode( ' ',$el_classes ).'">';        
        if( isset($title) and !empty($title) ){
            $data[] = '<'.esc_attr($heading_type).' class="title">'.esc_html($title).'</'.esc_attr($heading_type).'>';
        }
        if( isset($desc) and !empty($desc) ){
            $data[] = '<div class="desc">'.wp_kses($desc,wp_kses_allowed_html('post')).'</div>';
        }
        $data[] = '</div>';        
        $data = implode( ' ', $data );        
        return $data;
    }    
}
add_shortcode( 'acrony_page_title','acrony_page_title_content' );
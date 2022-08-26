<?php
add_action( 'init','acrony_lightbox_addons',99 );
if( !function_exists('acrony_lightbox_addons') ){
    function acrony_lightbox_addons(){
        if( function_exists('kc_add_map') ){
            kc_add_map(array(
                'acrony_lightbox' => array(
                    'name'      => esc_html__( 'Lightbox','acrony-core' ),
                    'icon'      => 'acrony_icon icon_lightbox',
                    'category'  => 'Acrony',
                    'params' => array(
                        'General' => array(
                            array(
                                'name'  => 'click_event',
                                'label' => esc_html__( 'Button click event','acrony-core' ),
                                'type'  => 'dropdown',
                                'options' => array(
                                    'lightbox' => esc_html__( 'Open in lightbox','acrony-core' ),
                                    'link' => esc_html__( 'Open custom link','acrony-core' ),
                                ),
                                'description' => esc_html__( 'Select the click event when users click on the button', 'acrony-core' )
                            ),
                            array(
                                'name' => 'lightbox_content',
                                'label' => esc_html__( 'Image and Video URL','acrony-core' ),
                                'type' => 'text',
                                'description' => esc_html__( 'Lightbox will support only video and image url.','acrony-core' ),
                                'relation' => array(
                                    'parent' => 'click_event',
                                    'show_when' => 'lightbox'
                                )
                            ),
                            array(
                                'name' => 'link_content',
                                'label' => esc_html__( 'Enter Custom URL','acrony-core' ),
                                'type' => 'link',
                                'relation' => array(
                                    'parent' => 'click_event',
                                    'show_when' => 'link'
                                )
                            ),
                            array(
                                'name' => 'button_icon',
                                'type' => 'icon_picker',
                                'label' => esc_html__( 'Choose Button Icon', 'acrony-core' ),
                                'value' => 'fa-play'
                            ),
                            array(
                                'name' => 'bg_image',
                                'type' =>  'attach_image',
                                'label' => __( 'Select Background Image','acrony-core' )
                            ),
                            array(
                                'name' => 'button_ex_class',
                                'type' => 'text',
                                'label' => esc_html__( 'Button Extra Class','acrony-core' ),
                                'description' => esc_html__( 'Add class name for button tag.','acrony-core' ),
                            ),
                            array(
                                'name' => 'wrapper_ex_class',
                                'type' => 'text',
                                'label' => esc_html__( 'Wrapper Extra Class','acrony-core' ),
                                'description' => esc_html__( 'If you wish to style a particular content element differently, please add a class name to this field add refer to it in your custom CSS file.','acrony-core' )
                            )
                        ),
                        'Styling' => array(
                                array(
                                    'name' => 'acrony_lightbox_style',
                                    'type'    => 'css',
                                    'options' => array(
                                        array(
                                            "screens" => "any,1024,999,767,479",
                                            'Boxes' => array(
                                                array('property' => 'background', 'label' => 'Background Color'),
                                                array('property' => 'background', 'label' => 'Hover Background Color', 'selector' => ':hover'),
                                                array('property' => 'text-align', 'label' => 'Text Align'),
                                                array('property' => 'float', 'label' => 'Float'),
                                                array('property' => 'width', 'label' => 'Widht'),
                                                array('property' => 'height', 'label' => 'Height'),
                                                array('property' => 'display', 'label' => 'Display'),
                                                array('property' => 'border', 'label' => 'Border'),
                                                array('property' => 'box-shadow', 'label' => 'Box Shadow'),
                                                array('property' => 'box-shadow', 'label' => 'Hover Box Shadow', 'selector' => ':hover'),
                                                array('property' => 'border-radius', 'label' => 'Border Radius'),
                                                array('property' => 'padding', 'label' => 'Padding'),
                                                array('property' => 'margin', 'label' => 'Margin'),
                                                array('property' => 'overflow', 'label' => 'Overflow')
                                            ),
                                            'Button' => array(
                                                array('property' => 'color', 'label' => 'Color','selector' => '.button_play' ),
                                                array('property' => 'background', 'label' => 'Background','selector' => '.button_play' ),
                                                array('property' => 'background-color', 'label' => 'Overlay BG','selector' => '.button_play' ),
                                                array('property' => 'font-size', 'label' => 'Font Size','selector' => '.button_play' ),
                                                array('property' => 'line-height', 'label' => 'Line Height','selector' => '.button_play' ),
                                                array('property' => 'text-align', 'label' => 'Align','selector' => '.button_play' ),
                                                array('property' => 'letter-spacing', 'label' => 'Letter Spacing','selector' => '.button_play' ),
                                                array('property' => 'width', 'label' => 'Widht','selector' => '.button_play' ),
                                                array('property' => 'height', 'label' => 'Height','selector' => '.button_play' ),
                                                array('property' => 'display', 'label' => 'Display','selector' => '.button_play' ),
                                                array('property' => 'border', 'label' => 'Border','selector' => '.button_play' ),
                                                array('property' => 'box-shadow', 'label' => 'Box Shadow','selector' => '.button_play' ),
                                                array('property' => 'border-radius', 'label' => 'Border Radius','selector' => '.button_play' ),
                                                array('property' => 'padding', 'label' => 'Padding','selector' => '.button_play' ),
                                                array('property' => 'margin', 'label' => 'Margin','selector' => '.button_play' ) 
                                            ),                                        
                                            'Button Hover' => array(
                                                array('property' => 'color', 'label' => 'Color','selector' => '.button_play:hover'),
                                                array('property' => 'background', 'label' => 'Background', 'selector' => '.button_play:hover'),
                                                array('property' => 'border', 'label' => 'Border', 'selector' => '.button_play:hover'),
                                                array('property' => 'box-shadow', 'label' => 'Box Shadow', 'selector' => '.button_play:hover'),
                                                array('property' => 'border-radius', 'label' => 'Border Radius', 'selector' => '.button_play:hover'),
                                                array('property' => 'padding', 'label' => 'Padding', 'selector' => '.button_play:hover'),
                                                array('property' => 'margin', 'label' => 'Margin', 'selector' => '.button_play:hover')  
                                            ),
                                            'waves' => array(
                                                array('property' => 'background-color', 'label' => 'Background', 'selector' => '.waves-block .waves'),
                                                array('property' => 'opacity', 'label' => 'Opacity', 'selector' => '.waves-block .waves'),
                                                array('property' => 'border-radius', 'label' => 'Border Radius', 'selector' => '.waves-block .waves'),
                                                array('property' => 'box-shadow', 'label' => 'Box Shadow', 'selector' => '.waves-block .waves'),
                                                array('property' => 'width', 'label' => 'Width', 'selector' => '.waves-block .waves'),
                                                array('property' => 'height', 'label' => 'Height', 'selector' => '.waves-block .waves')
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


if( !function_exists('acrony_lightbox_content') ){
    function acrony_lightbox_content( $attr , $content = '' ){
        extract($attr);        
        $data = array();
        $wrapper_classes = apply_filters( 'kc-el-class', $attr );
        $wrapper_classes[] = 'lightbox_content';
        if( isset($wrapper_ex_class) and !empty($wrapper_ex_class) ){
            $wrapper_classes[] = $wrapper_ex_class;
        }        
        $button_classes[] = 'button_play';
        
        // Lightbox Data Cullect and Setup
        if( $click_event == 'lightbox' ){
            $button_attr[] = ( !empty($lightbox_content) ? 'href="'.esc_url($lightbox_content).'"' : 'href="#"' );
            $button_attr[] = 'data-lity';
        }        
        // Link Data Cullect and Setup
        if( $click_event == 'link' ){
            $link_content = explode( '|', $link_content );            
            $button_attr[] = 'href="'.( !empty($link_content[0]) ? esc_url($link_content[0]) : '#' ).'"';            
            $button_attr[] = ( !empty($link_content[1]) ? 'title="'.esc_attr($link_content[1]).'"' : '' );            
            $button_attr[] = ( !empty($link_content[2]) ? 'target="'.esc_attr($link_content[2]).'"' : '' );
        }        
        if( isset($button_ex_class) and !empty($button_ex_class) ){
            $button_classes[] = esc_attr($button_ex_class);
        }        
        $button_attr[] = 'class="'.implode( ' ' , $button_classes).'"';        
        $data[] = '<div class="'.implode( ' ', $wrapper_classes ).'">';
        if( isset($bg_image) and !empty($bg_image) ){   
            $data[] = '<div class="back_image">';
            $data[] = wp_get_attachment_image( $bg_image, 'full' );
            $data[] = '</div>';
        }
        $data[] = '<div class="waves-block"><div class="waves wave-1"></div><div class="waves wave-2"></div><div class="waves wave-3"></div></div>';
        $data[] = '<a '.implode( ' ', $button_attr ).' ><i class="'.( !empty($button_icon) ? esc_attr($button_icon) : 'fa-play' ).'"></i></a>';
        $data[] = '</div>';
        $data = implode( ' ', $data );        
        return $data;        
    }
}
add_shortcode( 'acrony_lightbox','acrony_lightbox_content' );
<?php
add_action( 'init', 'acrony_testimonial_addons' , 99 );
if( !function_exists('acrony_testimonial_addons') ){
    function acrony_testimonial_addons(){
        if( function_exists('kc_add_map') ){
            kc_add_map(array(
                'acrony_testimonial' => array(
                    'name' => __('Testimonial','acrony-core'),
                    'icon' => 'acrony_icon  icon_testimonial',
                    'category' => 'Acrony',
                    'params' => array(
                        'General' => array(
                            array(
                                'name' => 'view_type',
                                'label' => esc_html__( 'View Type','acrony-core' ),
                                'type' => 'select',
                                'options' => array(
                                    'grid' => esc_html__('Grid','acrony-core'),
                                    'carousel' => esc_html__('Carousel','acrony-core')
                                ),
                                'value' => 'grid'
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
                                'type'			=> 'dropdown',
                                'label'			=> __( 'Desktop Grid', 'acrony-core' ),
                                'name'			=> 'desktop_column',
                                'admin_label'	=> true,
                                'options' 		=> array(
                                    '12'		=> __('1 Column', 'acrony-core'),
                                    '6'		    => __('2 Column', 'acrony-core'),
                                    '4'		    => __('3 Column', 'acrony-core'),
                                    '3'		    => __('4 Column', 'acrony-core'),
                                ),
                                'relation' => array(
                                    'parent' => 'view_type',
                                    'show_when' => 'grid'
                                ),
                                'value' => '4'
                            ), 
                            array(
                                'type' => 'group',
                                'label' => __( 'Testimonial Items' , 'acrony-core' ),
                                'name' => 'testi_box',
                                'options' => array(
                                    'add_text' => __( 'Add Testimonial' , 'acrony-core' )
                                ),
                                'params' => array(
                                    array(
                                        'name' => 'desc',
                                        'type' => 'textarea',
                                        'label' => __( 'Client Says','acrony-core' ),
                                        'description' => __( 'What client sayes about yourself.','acrony-core' )
                                    ),
                                    array(
                                        'name' => 'name',
                                        'type' => 'text',
                                        'label' => __( 'Client Name' , 'acrony-core' )
                                    ),
                                    array(
                                        'name' => 'position',
                                        'type' => 'text',
                                        'label' => __( 'Client Position' , 'acrony-core' )
                                    ),
                                    array(
                                        'name' => 'thumb',
                                        'type' => 'attach_image',
                                        'label' => __( 'Client Photo','acrony-core' ),
                                        'description' => __( 'You can use extra class.' , 'acrony-core' )
                                    )
                                )
                            ),
                            array(
                                'name' => 'quote_image',
                                'type' => 'attach_image',
                                'label' => esc_html__( 'Quote Icon','acrony-core' )
                            ),
                            array(
                                'name' => 'items_number',
                                'label' => esc_html__('Items Per Slide','acrony-core'),
                                'type' => 'number_slider',
                                'options' => array(
                                    'min' => 1,
                                    'max' => 15,
                                    'show_input' => true
                                ),
                                'value' => 3,
                                'description' => esc_html__('The number of items displayed per slide (not apply for autoheight). Default is 3 items and 1 item on mobile.','acrony-core'),
                                'relation' => array(
                                    'parent' => 'view_type',
                                    'show_when' => 'carousel'
                                )
                            ),
                            array(
                                'name' => 'tablet',
                                'label' => esc_html__('Items On Tablet','acrony-core'),
                                'type' => 'number_slider',
                                'options' => array(
                                    'min' => 1,
                                    'max' => 10,
                                    'show_input' => true
                                ),
                                'value' => 2,
                                'description' => esc_html__('Display number of items per each slide (Tablet Screen)','acrony-core'),
                                'relation' => array(
                                    'parent' => 'view_type',
                                    'show_when' => 'carousel'
                                )
                            ),
                            array(
                                'name' => 'mobile',
                                'label' => esc_html__('Items On SmartPhone','acrony-core'),
                                'type' => 'number_slider',
                                'options' => array(
                                    'min' => 1,
                                    'max' => 5,
                                    'show_input' => true
                                ),
                                'value' => 1,
                                'description' => esc_html__('Display number of items per each slide (Mobile Screen)','acrony-core'),
                                'relation' => array(
                                    'parent' => 'view_type',
                                    'show_when' => 'carousel'
                                )
                            ),
                            array(
                                'name' => 'speed',
                                'label' => esc_html__('Speed','acrony-core'),
                                'type' => 'number_slider',
                                'options' => array(
                                    'min' => 1,
                                    'max' => 1500,
                                    'show_input' => true
                                ),
                                'value' => 500,
                                'description' => esc_html__('Set the speed at which auto playing sliders will transition (in second).','acrony-core'),
                                'relation' => array(
                                    'parent' => 'view_type',
                                    'show_when' => 'carousel'
                                )
                            ),
                            array(
                                'name' => 'delay',
                                'label' => esc_html__('Delay Time','acrony-core'),
                                'type' => 'number_slider',
                                'options' => array(
                                    'min' => 1,
                                    'max' => 15,
                                    'show_input' => true
                                ),
                                'value' => 8,
                                'description' => esc_html__('The delay time before moving on to a new slide.','acrony-core'),
                                'relation' => array(
                                    'parent' => 'view_type',
                                    'show_when' => 'carousel'
                                )
                            ),
                            array(
                                'name' => 'navigation',
                                'label' => esc_html__('Navigation','acrony-core'),
                                'type' => 'toggle',
                                'relation' => array(
                                    'parent' => 'view_type',
                                    'show_when' => 'carousel'
                                )
                            ),
                            array(
                                'name' => 'pagination',
                                'label' => esc_html__('Pagination','acrony-core'),
                                'type' => 'toggle',
                                'description' => esc_html__('Show the pagination.','acrony-core'),
                                'relation' => array(
                                    'parent' => 'view_type',
                                    'show_when' => 'carousel'
                                )
                            ),
                            array(
                                'name' => 'auto_play',
                                'label' => esc_html__( 'Auto Play' , 'acrony-core' ),
                                'type' => 'toggle',
                                'description' => esc_html__('Add height to div "owl-wrapper-outer" so you can use diffrent heights on slides. Use it only for one item per page setting.','acrony-core'),
                                'relation' => array(
                                    'parent' => 'view_type',
                                    'show_when' => 'carousel'
                                )
                            ),
                            array(
                                'name' => 'ex_class',
                                'type' => 'text',
                                'label' => __( 'Extra class','acrony-core' )
                            )
                        ),
                        'Styling' => array(
                            array(
                                'name' => 'acrony_testimonial_style',
                                'type' => 'css',
                                'options' => array(
                                    array(
                                        "screens" => "any,1024,999,767,479",
                                        'Boxes' => array(
                                            array('property' => 'color', 'label' => 'Color', 'selector' => '.single-testimonial'),
                                            array('property' => 'background', 'label' => 'Background','selector' => '.single-testimonial'),
                                            array('property' => 'font-family', 'label' => 'Font Family', 'selector' => '.single-testimonial'),
                                            array('property' => 'font-size', 'label' => 'Font Size', 'selector' => '.single-testimonial'),
                                            array('property' => 'line-height', 'label' => 'Line Height', 'selector' => '.single-testimonial'),
                                            array('property' => 'font-weight', 'label' => 'Font Weight', 'selector' => '.single-testimonial'),
                                            array('property' => 'text-transform', 'label' => 'Text Transform', 'selector' => '.single-testimonial'),
                                            array('property' => 'text-align', 'label' => 'Text Alignment', 'selector' => '.single-testimonial'),
                                            array('property' => 'box-shadow', 'label' => 'Box Shadow', 'selector' => '.single-testimonial'),
                                            array('property' => 'border', 'label' => 'Border', 'selector' => '.single-testimonial'),
                                            array('property' => 'border-radius', 'label' => 'Border Radius', 'selector' => '.single-testimonial'),
                                            array('property' => 'padding', 'label' => 'Padding','selector' => '.single-testimonial'),
                                            array('property' => 'margin', 'label' => 'Margin','selector' => '.single-testimonial'),
                                            array('property' => 'overflow', 'label' => 'Overflow','selector' => '.single-testimonial')
                                        ),
                                        'Photo' => array(
                                            array('property' => 'border', 'label' => 'Border', 'selector' => '.single-testimonial .thumb'),
                                            array('property' => 'border-radius', 'label' => 'Border Radius', 'selector' => '.single-testimonial .thumb'),
                                            array('property' => 'box-shadow', 'label' => 'Box Shadow', 'selector' => '.single-testimonial .thumb'),
                                            array('property' => 'width', 'label' => 'Width', 'selector' => '.single-testimonial .thumb'),
									        array('property' => 'height', 'label' => 'Height', 'selector' => '.single-testimonial .thumb'),
                                            array('property' => 'padding', 'label' => 'Padding','selector' => '.single-testimonial .thumb'),
                                            array('property' => 'margin', 'label' => 'Margin','selector' => '.single-testimonial .thumb'),
                                            array('property' => 'overflow', 'label' => 'Overflow','selector' => '.single-testimonial .thumb')
                                        ),
                                        'Desc' => array(                                            
                                            array('property' => 'color', 'label' => 'Color', 'selector' => '.single-testimonial .desc'), 
                                            array('property' => 'font-family', 'label' => 'Font Family', 'selector' => '.single-testimonial .desc'),
                                            array('property' => 'font-size', 'label' => 'Font Size', 'selector' => '.single-testimonial .desc'),
                                            array('property' => 'line-height', 'label' => 'Line Height', 'selector' => '.single-testimonial .desc'),
                                            array('property' => 'font-weight', 'label' => 'Font Weight', 'selector' => '.single-testimonial .desc'),
                                            array('property' => 'text-transform', 'label' => 'Text Transform', 'selector' => '.single-testimonial .desc'),
                                            array('property' => 'text-align', 'label' => 'Text Alignment', 'selector' => '.single-testimonial .desc'),
                                            array('property' => 'border', 'label' => 'Border', 'selector' => '.single-testimonial .desc'),
                                            array('property' => 'padding', 'label' => 'Padding','selector' => '.single-testimonial .desc'),
                                            array('property' => 'margin', 'label' => 'Margin','selector' => '.single-testimonial .desc'),
                                        ),
                                        'Name' => array(                                            
                                            array('property' => 'color', 'label' => 'Color', 'selector' => '.single-testimonial .name'), 
                                            array('property' => 'font-family', 'label' => 'Font Family', 'selector' => '.single-testimonial .name'),
                                            array('property' => 'font-size', 'label' => 'Font Size', 'selector' => '.single-testimonial .name'),
                                            array('property' => 'line-height', 'label' => 'Line Height', 'selector' => '.single-testimonial .name'),
                                            array('property' => 'font-weight', 'label' => 'Font Weight', 'selector' => '.single-testimonial .name'),
                                            array('property' => 'text-transform', 'label' => 'Text Transform', 'selector' => '.single-testimonial .name'),
                                            array('property' => 'text-align', 'label' => 'Text Alignment', 'selector' => '.single-testimonial .name'),
                                            array('property' => 'border', 'label' => 'Border', 'selector' => '.single-testimonial .name'),
                                            array('property' => 'padding', 'label' => 'Padding','selector' => '.single-testimonial .name'),
                                            array('property' => 'margin', 'label' => 'Margin','selector' => '.single-testimonial .name')
                                        ),
                                        'Position' => array(                                            
                                            array('property' => 'color', 'label' => 'Color', 'selector' => '.single-testimonial .posi'), 
                                            array('property' => 'font-family', 'label' => 'Font Family', 'selector' => '.single-testimonial .posi'),
                                            array('property' => 'font-size', 'label' => 'Font Size', 'selector' => '.single-testimonial .posi'),
                                            array('property' => 'line-height', 'label' => 'Line Height', 'selector' => '.single-testimonial .posi'),
                                            array('property' => 'font-weight', 'label' => 'Font Weight', 'selector' => '.single-testimonial .posi'),
                                            array('property' => 'text-transform', 'label' => 'Text Transform', 'selector' => '.single-testimonial .posi'),
                                            array('property' => 'text-align', 'label' => 'Text Alignment', 'selector' => '.single-testimonial .posi'),
                                            array('property' => 'border', 'label' => 'Border', 'selector' => '.single-testimonial .posi'),
                                            array('property' => 'padding', 'label' => 'Padding','selector' => '.single-testimonial .posi'),
                                            array('property' => 'margin', 'label' => 'Margin','selector' => '.single-testimonial .posi')
                                        ),
                                        'Quote' => array(
                                            array('property' => 'border', 'label' => 'Border', 'selector' => '.single-testimonial .testi-quote'),
                                            array('property' => 'border-radius', 'label' => 'Border Radius', 'selector' => '.single-testimonial .testi-quote'),
                                            array('property' => 'box-shadow', 'label' => 'Box Shadow', 'selector' => '.single-testimonial .testi-quote'),
                                            array('property' => 'display', 'label' => 'Display', 'selector' => '.single-testimonial .testi-quote'),
                                            array('property' => 'float', 'label' => 'Float', 'selector' => '.single-testimonial .testi-quote'),
                                            array('property' => 'position', 'label' => 'Position', 'selector' => '.single-testimonial .testi-quote'),
                                            array('property' => 'top', 'label' => 'Top', 'selector' => '.single-testimonial .testi-quote'),
                                            array('property' => 'right', 'label' => 'Right', 'selector' => '.single-testimonial .testi-quote'),
                                            array('property' => 'bottom', 'label' => 'Bottom', 'selector' => '.single-testimonial .testi-quote'),
                                            array('property' => 'left', 'label' => 'Left', 'selector' => '.single-testimonial .testi-quote'),
                                            array('property' => 'width', 'label' => 'Width', 'selector' => '.single-testimonial .testi-quote'),
									        array('property' => 'height', 'label' => 'Height', 'selector' => '.single-testimonial .testi-quote'),
                                            array('property' => 'padding', 'label' => 'Padding','selector' => '.single-testimonial .testi-quote'),
                                            array('property' => 'margin', 'label' => 'Margin','selector' => '.single-testimonial .testi-quote'),
                                            array('property' => 'overflow', 'label' => 'Overflow','selector' => '.single-testimonial .testi-quote')
                                        ),
                                        'Dots' => array(
                                            array('property' => 'width', 'label' =>  esc_html__('Width','acrony-core'), 'selector' => '.owl-controls .owl-page span' ),
                                            array('property' => 'height', 'label' =>  esc_html__('Height','acrony-core'), 'selector' => '.owl-controls .owl-page span' ),
                                            array('property' => 'background', 'label' =>  esc_html__('Dots Background','acrony-core'), 'selector' => '.owl-controls .owl-page span' ),
                                            array('property' => 'background', 'label' =>  esc_html__('Active Dot Background','acrony-core'), 'selector' => '.owl-controls .owl-page.active span:after' ),
                                            array('property' => 'margin', 'label' =>  esc_html__('Margin','acrony-core'), 'selector' => '.owl-controls .owl-page span' ),
                                            array('property' => 'padding', 'label' =>  esc_html__('Padding','acrony-core'), 'selector' => '.owl-controls .owl-page span' ),
                                            array('property' => 'border', 'label' =>  esc_html__('Border','acrony-core'), 'selector' => '.owl-controls .owl-page span' ),
                                            array('property' => 'border-radius', 'label' =>  esc_html__('Border Radius','acrony-core'), 'selector' => '.owl-controls .owl-page span' ),
                                            array('property' => 'box-shadow', 'label' =>  esc_html__('Box Shadow','acrony-core'), 'selector' => '.owl-controls .owl-page span' ),
                                        ),                                        
                                        'Navigation' => array(
                                            array('property' => 'font-size', 'label' =>  esc_html__('Font Size','acrony-core'), 'selector' => '.owl-controls .owl-buttons > div' ),
                                            array('property' => 'line-height', 'label' =>  esc_html__('Line Height','acrony-core'), 'selector' => '.owl-controls .owl-buttons > div' ),
                                            array('property' => 'color', 'label' =>  esc_html__('Color','acrony-core'), 'selector' => '.owl-controls .owl-buttons > div' ),
                                            array('property' => 'color', 'label' =>  esc_html__('Hover Color','acrony-core'), 'selector' => '.owl-controls .owl-buttons > div:hover' ),
                                            array('property' => 'background', 'label' =>  esc_html__('Background','acrony-core'), 'selector' => '.owl-controls .owl-buttons > div' ),
                                            array('property' => 'background', 'label' =>  esc_html__('Hover Background','acrony-core'), 'selector' => '.owl-controls .owl-buttons > div:hover' ),
                                            array('property' => 'border', 'label' =>  esc_html__('Border','acrony-core'), 'selector' => '.owl-controls .owl-buttons > div' ),
                                            array('property' => 'border-radius', 'label' =>  esc_html__('Border Radius','acrony-core'), 'selector' => '.owl-controls .owl-buttons > div' ),
                                            array('property' => 'box-shadow', 'label' =>  esc_html__('Box Shadow','acrony-core'), 'selector' => '.owl-controls .owl-buttons > div' ),
                                            array('property' => 'margin', 'label' =>  esc_html__('Margin','acrony-core'), 'selector' => '.owl-controls .owl-buttons > div' ),
                                            array('property' => 'padding', 'label' =>  esc_html__('Padding','acrony-core'), 'selector' => '.owl-controls .owl-buttons > div' ),
                                            array('property' => 'width', 'label' =>  esc_html__('Width','acrony-core'), 'selector' => '.owl-controls .owl-buttons > div' ),
                                            array('property' => 'height', 'label' =>  esc_html__('Height','acrony-core'), 'selector' => '.owl-controls .owl-buttons > div' ),
                                        ),
                                        
                                    )
                                )
                            )
                        )
                    )
                )
            ));
        }
    }    
}

if( !function_exists('acrony_testimonial_content') ){
    function acrony_testimonial_content( $attr, $content = '' ){
        $box_content = $item_classes = $element_attribute = array();
        $view_type = $desktop_column = $image_size = '';
                
        extract($attr);
        
        $wrp_class 	= apply_filters( 'kc-el-class', $attr );  
        $wrp_class[] = 'acrony-testimonial';
        
        
        if( $view_type == 'grid' ):
            $item_classes[] = 'col-sm-6 col-md-'.esc_attr($desktop_column);
        endif;
        
        
        if( $view_type == 'carousel' ):
            $items_number = ( !empty($items_number) ? $items_number : 2 );
            $item_on_tablet = ( !empty($tablet) ? $tablet : 2 );
            $item_on_phone = ( !empty($mobile) ? $mobile : 1 );
            wp_enqueue_script( 'owl-carousel' );
            wp_enqueue_style( 'owl-theme' );
            wp_enqueue_style( 'owl-carousel' );
            $wrp_class[] = 'kc-carousel-images';
            $wrp_class[] = 'owl-carousel-images';
            $wrp_class[] = 'kc-sync1';
            $owl_option = array(
                'items' 		=> $items_number,
                'tablet'        => $item_on_tablet,
                'mobile'        => $item_on_phone,
                'speed' 		=> $speed,
                'navigation' 	=> $navigation,
                'pagination' 	=> $pagination,
                'delay' 		=> $delay,
                'autoplay' 		=> $auto_play
            );   
            $owl_option     =   json_encode( $owl_option );  
            $element_attribute[] 	= "data-owl-i-options='$owl_option'";
        endif;
        
        
        $element_attribute[] 	= 'class="'. esc_attr( implode( ' ', $wrp_class ) ) .'"';
        
        $box_content[] = '<div '.implode( ' ',$element_attribute ).' >';
        
        if( !empty($testi_box) ){
            foreach( $testi_box as $testi_box ){
                $box_content[] = '<div class="'.implode( ' ',$item_classes ).'">';
                $box_content[] = '<div class="single-testimonial">';
                    if( isset($quote_image) and !empty($quote_image) ){
                        $box_content[] = '<div class="testi-quote">'.wp_get_attachment_image($quote_image,'full').'</div>';
                    }
                    $box_content[] = '<div class="testi-content">';       
                        if( !empty($testi_box->desc) ){
                            $box_content[] = '<div class="desc">'.esc_html($testi_box->desc).'</div>';
                        }
						if( !empty($testi_box->thumb) ) {
							$box_content[] = '<figure class="thumb">'.wp_get_attachment_image($testi_box->thumb,'medium').'</figure>';
						}
                        
                        if( !empty($testi_box->name) ){    
                            $box_content[] = '<h5 class="name">'.esc_html($testi_box->name).'</h5>';
                        }
                        if( !empty($testi_box->position) ){    
                            $box_content[] = '<span class="posi">'.esc_html($testi_box->position).'</span>';
                        }
                    $box_content[] = '</div>';
                    $box_content[] = '</div>';
                $box_content[] = '</div>';
            }
        }                
        $box_content[] = '</div>';

        $data = implode( ' ', $box_content );
        return $data;
    }
}

add_shortcode( 'acrony_testimonial' , 'acrony_testimonial_content' );
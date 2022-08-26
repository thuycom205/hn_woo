<?php
add_action( 'init', 'acrony_blog_box_addons', 99 );
if( !function_exists('acrony_blog_box_addons') ){
    function acrony_blog_box_addons(){
        if(function_exists('kc_add_map')){
            kc_add_map(array(
                'acrony_blog' => array(
                    'name' => esc_html__( 'Blog','acrony-core' ),
                    'category' => 'Acrony',
                    'icon' => 'acrony_icon icon_blog',
                    'params' => array(
                        'General' => array(
                            array(
                                'name' => 'view_type',
                                'label' => esc_html__( 'View Type','acrony-core' ),
                                'type' => 'select',
                                'options' => array(
                                    'grid' => esc_html__('Grid','acrony-core'),
                                    'carousel' => esc_html__('Carousel','acrony-core'),
                                    'masonry' => esc_html__('Masonry Grid','acrony-core')
                                ),
                                'value' => 'grid'
                            ),
                            array(
                                'name' => 'item_limit',
                                'label' => esc_html__( 'Posts Limit','acrony-core' ),
                                'type' => 'number_slider',
                                'options' => array(    // REQUIRED
                                    'min' => 1,
                                    'max' => 200,
                                    'show_input' => true
                                ),
                                'value' => 10
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
                                    'hide_when' => 'carousel'
                                ),
                                'value' => '4'
                            ),                           
                            array(
                                'type'			=> 'dropdown',
                                'label'			=> __( 'Tablet Grid', 'acrony-core' ),
                                'name'			=> 'tablet_column',
                                'admin_label'	=> true,
                                'options' 		=> array(
                                    '12'		=> __('1 Column', 'acrony-core'),
                                    '6'		    => __('2 Column', 'acrony-core'),
                                    '4'		    => __('3 Column', 'acrony-core'),
                                    '3'		    => __('4 Column', 'acrony-core'),
                                ),
                                'relation' => array(
                                    'parent' => 'view_type',
                                    'hide_when' => 'carousel'
                                ),
                                'value' => '6'
                            ),
                             array(
                                'type'			=> 'post_taxonomy',
                                'label'			=> __( 'Content Type', 'acrony-core' ),
                                'name'			=> 'post_taxonomy',
                                'description'	=> __( 'Choose supported content type such as post, custom post type, etc.', 'acrony-core' ),
                            ),
                            array(
                                'type'			=> 'dropdown',
                                'label'			=> __( 'Order by', 'acrony-core' ),
                                'name'			=> 'order_by',
                                'admin_label'	=> true,
                                'options' 		=> array(
                                    'ID'		=> __(' Post ID', 'acrony-core'),
                                    'author'	=> __(' Author', 'acrony-core'),
                                    'title'		=> __(' Title', 'acrony-core'),
                                    'name'		=> __(' Post name (post slug)', 'acrony-core'),
                                    'type'		=> __(' Post type (available since Version 4.0)', 'acrony-core'),
                                    'date'		=> __(' Date', 'acrony-core'),
                                    'modified'	=> __(' Last modified date', 'acrony-core'),
                                    'rand'		=> __(' Random order', 'acrony-core'),
                                    'comment_count'	=> __(' Number of comments', 'acrony-core')
                                )
                            ),
                            array(
                                'type'			=> 'dropdown',
                                'label'			=> __( 'Order post', 'acrony-core' ),
                                'name'			=> 'order_list',
                                'admin_label'	=> true,
                                'options' 		=> array(
                                    'ASC'		=> __(' ASC', 'acrony-core'),
                                    'DESC'		=> __(' DESC', 'acrony-core'),
                                )
                            ),
                            array(
                                'name' => 'title_word_limit',
                                'label' => esc_html__('Title Word Limit.','acrony-core'),
                                'type' => 'number_slider',
                                'options' => array(
                                    'min' => 1,
                                    'step' => 1,
                                    'max' => 100,
                                    'show_input' => true
                                ),
                                'value' => 5,
                                'description' => esc_html__('How many word will be show in the title.','acrony-core'),
                            ),
                            array(
                                'name' => 'desc_word_limit',
                                'label' => esc_html__('Content Word Limit.','acrony-core'),
                                'type' => 'number_slider',
                                'options' => array(
                                    'min' => 1,
                                    'step' => 1,
                                    'max' => 100,
                                    'show_input' => true
                                ),
                                'value' => 15,
                                'description' => esc_html__('How many word will be show in the description.','acrony-core'),
                            ),
                            array(
                                'name' => 'items_number',
                                'label' => esc_html__('Items Per Slide','acrony-core'),
                                'type' => 'number_slider',
                                'options' => array(
                                    'min' => 1,
                                    'step' => 1,
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
                                    'step' => 1,
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
                                    'step' => 1,
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
                                    'step' => 1,
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
                                    'step' => 1,
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
                                'name' => 'wrap_class',
                                'label' => esc_html__('Wrapper Class Name','acrony-core'),
                                'type' => 'text',
                                'description' => esc_html__('Custom class for wrapper of the shortcode widget.','acrony-core'),
                                'relation' => array(
                                    'parent' => 'view_type',
                                    'show_when' => 'carousel'
                                )
                            )  
                        ),
                        'Styling' => array(
                            array(
                                'name' => 'acrony_blog_box_style',
                                'type' => 'css',
                                'options' => array(
                                    array(
                                        "screens" => "any,1024,992,768,480",
                                        'Boxes' => array(
                                            array( 'property' => 'background', 'label' => 'Background Color', 'selector' => '.post-single' ),
                                            array( 'property' => 'width', 'label' => 'Width', 'selector' => '.post-single' ),
                                            array( 'property' => 'height', 'label' => 'Height', 'selector' => '.post-single' ),
                                            array( 'property' => 'text-align', 'label' => 'Text Align', 'selector' => '.post-single' ),
                                            array( 'property' => 'display', 'label' => 'Display', 'selector' => '.post-single' ),
                                            array( 'property' => 'border', 'label' => 'Border', 'selector' => '.post-single' ),
                                            array( 'property' => 'box-shadow', 'label' => 'Box Shadow', 'selector' => '.post-single' ),
                                            array( 'property' => 'border-radius', 'label' => 'Border Radius', 'selector' => '.post-single' ),
                                            array( 'property' => 'padding', 'label' => 'Padding', 'selector' => '.post-single' ),
                                            array( 'property' => 'margin', 'label' => 'Margin', 'selector' => '.post-single' ),
                                            array( 'property' => 'overflow', 'label' => 'Overflow', 'selector' => '.post-single' ),
                                        ),
                                        'Content Box' => array(
                                            array( 'property' => 'background', 'label' => 'Background Color', 'selector' => '.post-single .post-content' ),
                                            array( 'property' => 'width', 'label' => 'Width', 'selector' => '.post-single .post-content' ),
                                            array( 'property' => 'height', 'label' => 'Height', 'selector' => '.post-single .post-content' ),
                                            array( 'property' => 'text-align', 'label' => 'Text Align', 'selector' => '.post-single .post-content' ),
                                            array( 'property' => 'display', 'label' => 'Display', 'selector' => '.post-single .post-content' ),
                                            array( 'property' => 'border', 'label' => 'Border', 'selector' => '.post-single .post-content' ),
                                            array( 'property' => 'box-shadow', 'label' => 'Box Shadow', 'selector' => '.post-single .post-content' ),
                                            array( 'property' => 'border-radius', 'label' => 'Border Radius', 'selector' => '.post-single .post-content' ),
                                            array( 'property' => 'margin', 'label' => 'Margin', 'selector' => '.post-single .post-content' ),
                                            array( 'property' => 'padding', 'label' => 'Padding', 'selector' => '.post-single .post-content' ),
                                            array( 'property' => 'overflow', 'label' => 'Overflow', 'selector' => '.post-single .post-content' ),
                                        ),
                                        'Meta' => array(
                                            array('property' => 'color', 'label' =>  esc_html__('Color','acrony-core'), 'selector' => '.post-meta .meta-item' ),
                                            array('property' => 'font-family', 'label' =>  esc_html__('Font Family','acrony-core'), 'selector' => '.post-meta .meta-item' ),
                                            array('property' => 'font-size', 'label' =>  esc_html__('Font Size','acrony-core'), 'selector' => '.post-meta .meta-item' ),
                                            array('property' => 'font-weight', 'label' =>  esc_html__('Font Weight','acrony-core'), 'selector' => '.post-meta .meta-item' ),
                                            array('property' => 'font-style', 'label' =>  esc_html__('Font Style','acrony-core'), 'selector' => '.post-meta .meta-item' ),
                                            array('property' => 'text-decoration', 'label' =>  esc_html__('Text Decoration','acrony-core'), 'selector' => '.post-meta .meta-item' ),
                                            array('property' => 'text-shadow', 'label' =>  esc_html__('Text Shadow','acrony-core'), 'selector' => '.post-meta .meta-item' ),
                                            array('property' => 'line-height', 'label' =>  esc_html__('Line Height','acrony-core'), 'selector' => '.post-meta .meta-item' ),
                                            array('property' => 'letter-spacing', 'label' =>  esc_html__('Letter Spacing','acrony-core'), 'selector' => '.post-meta .meta-item' ),
                                            array('property' => 'border', 'label' =>  esc_html__('Border','acrony-core'), 'selector' => '.post-meta .meta-item' ),
                                            array('property' => 'display', 'label' =>  esc_html__('Display','acrony-core'), 'selector' => '.post-meta .meta-item' ),
                                            array('property' => 'margin', 'label' =>  esc_html__('Margin','acrony-core'), 'selector' => '.post-meta .meta-item' ),
                                            array('property' => 'padding', 'label' =>  esc_html__('Padding','acrony-core'), 'selector' => '.post-meta .meta-item' )                                            
                                        ),
                                        'Title' => array(
                                            array('property' => 'color', 'label' =>  esc_html__('Color','acrony-core'), 'selector' => '.post-single .title a' ),
                                            array('property' => 'color', 'label' =>  esc_html__('Hover Color','acrony-core'), 'selector' => '.post-single .title a:hover' ),
                                            array('property' => 'font-family', 'label' =>  esc_html__('Font Family','acrony-core'), 'selector' => '.post-single .title a' ),
                                            array('property' => 'font-size', 'label' =>  esc_html__('Font Size','acrony-core'), 'selector' => '.post-single .title a' ),
                                            array('property' => 'font-weight', 'label' =>  esc_html__('Font Weight','acrony-core'), 'selector' => '.post-single .title a' ),
                                            array('property' => 'font-style', 'label' =>  esc_html__('Font Style','acrony-core'), 'selector' => '.post-single .title a' ),
                                            array('property' => 'text-decoration', 'label' =>  esc_html__('Text Decoration','acrony-core'), 'selector' => '.post-single .title a' ),
                                            array('property' => 'text-shadow', 'label' =>  esc_html__('Text Shadow','acrony-core'), 'selector' => '.post-single .title a' ),
                                            array('property' => 'line-height', 'label' =>  esc_html__('Line Height','acrony-core'), 'selector' => '.post-single .title a' ),
                                            array('property' => 'letter-spacing', 'label' =>  esc_html__('Letter Spacing','acrony-core'), 'selector' => '.post-single .title a' ),
                                            array('property' => 'border', 'label' =>  esc_html__('Border','acrony-core'), 'selector' => '.post-single .title a' ),
                                            array('property' => 'display', 'label' =>  esc_html__('Display','acrony-core'), 'selector' => '.post-single .title a' ),
                                            array('property' => 'margin', 'label' =>  esc_html__('Margin','acrony-core'), 'selector' => '.post-single .title a' ),
                                            array('property' => 'padding', 'label' =>  esc_html__('Padding','acrony-core'), 'selector' => '.post-single .title a' )                                            
                                        ),
                                        'Desc' => array(
                                            array('property' => 'color', 'label' =>  esc_html__('Color','acrony-core'), 'selector' => '.content' ),
                                            array('property' => 'color', 'label' =>  esc_html__('Hover Color','acrony-core'), 'selector' => ':hover .content' ),
                                            array('property' => 'font-family', 'label' =>  esc_html__('Font Family','acrony-core'), 'selector' => '.content' ),
                                            array('property' => 'font-size', 'label' =>  esc_html__('Font Size','acrony-core'), 'selector' => '.content' ),
                                            array('property' => 'font-weight', 'label' =>  esc_html__('Font Weight','acrony-core'), 'selector' => '.content' ),
                                            array('property' => 'font-style', 'label' =>  esc_html__('Font Style','acrony-core'), 'selector' => '.content' ),
                                            array('property' => 'text-decoration', 'label' =>  esc_html__('Text Decoration','acrony-core'), 'selector' => '.content' ),
                                            array('property' => 'text-shadow', 'label' =>  esc_html__('Text Shadow','acrony-core'), 'selector' => '.content' ),
                                            array('property' => 'line-height', 'label' =>  esc_html__('Line Height','acrony-core'), 'selector' => '.content' ),
                                            array('property' => 'letter-spacing', 'label' =>  esc_html__('Letter Spacing','acrony-core'), 'selector' => '.content' ),
                                            array('property' => 'border', 'label' =>  esc_html__('Border','acrony-core'), 'selector' => '.content' ),
                                            array('property' => 'display', 'label' =>  esc_html__('Display','acrony-core'), 'selector' => '.content' ),
                                            array('property' => 'margin', 'label' =>  esc_html__('Margin','acrony-core'), 'selector' => '.content' ),
                                            array('property' => 'padding', 'label' =>  esc_html__('Padding','acrony-core'), 'selector' => '.content' )                                            
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
                                ),
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

if( !function_exists('acrony_blog_content') ){
    function acrony_blog_content( $attr, $content = '' ){        
        $items_number = $tablet = $mobile = $speed = $navigation = $pagination = $auto_play = $image_size = $acrony_post_limit_word = '';
        $image_size = 'large';
        $desc_word_limit = 15;
        $title_word_limit = 5;
        extract($attr);
        $item_limit = ( isset($item_limit) ? $item_limit : 10 );
        $orderby 		= isset( $order_by ) ? $order_by : 'ID';
        $order 			= isset( $order_list ) ? $order_list : 'ASC';
        $post_taxonomy_data = explode( ',', $post_taxonomy );
        $taxonomy_term 	= array();
        $post_type 		= 'post';
        if( isset($post_taxonomy_data) ){
            foreach( $post_taxonomy_data as  $post_taxonomy ){                
                $post_taxonomy_tmp 	= explode( ':', $post_taxonomy );
                $post_type          = $post_taxonomy_tmp[0];                
                if( isset( $post_taxonomy_tmp[1] ) ){
			         $taxonomy_term[] = $post_taxonomy_tmp[1];
                }                
            }
        }        
        $taxonomy_objects 		= get_object_taxonomies( $post_type, 'objects' );
        $taxonomy 				= key( $taxonomy_objects );        
        $args = array(
            'post-type'         => $post_type,
            'orderby'           => $orderby,
            'order' 	        => $order,
            'posts_per_page' 	=> $item_limit,
        );        
        if( count($taxonomy_term) ){
            $tax_query = array(
                'relation' => 'OR'
            );            
            foreach( $taxonomy_term as $term ){
                $tax_query[] = array(
                    'taxonomy' => $taxonomy,
                    'field'    => 'slug',
                    'terms'    => $term,
                );                
            }            
            $args['tax_query'] = $tax_query;            
        }
        $the_query = new WP_Query( $args ); 
        $element_attribute = $item_class = array();
        $el_classes = apply_filters( 'kc-el-class', $attr );
        $el_classes[] = $wrap_class;
        $el_classes[] = 'blog-items';
        $item_class[] = 'blog-small';
        if( $view_type == 'masonry' ){   
            $el_classes[] = 'masonrys';
        }
        if( $view_type == 'grid' ){
            $el_classes[] = 'grid-posts';
        }
        if( $view_type == 'carousel' ){
            $items_number 	= ( !empty( $items_number ) ) ? $items_number : 3;
            $tablet 	= ( !empty( $tablet ) ) ? $tablet : 2;
            $mobile 	= ( !empty( $mobile ) ) ? $mobile : 1;
            wp_enqueue_script( 'owl-carousel' );
            wp_enqueue_style( 'owl-theme' );
            wp_enqueue_style( 'owl-carousel' );
            $el_classes[] = 'kc-carousel-images';
            $el_classes[] = 'owl-carousel-images';
            $el_classes[] = 'carousel-post';
            $owl_option = array(
                'items' 		=> $items_number,
                'tablet' 	    => $tablet,
                'mobile' 	    => $mobile,
                'speed' 		=> $speed,
                'navigation' 	=> $navigation,
                'pagination' 	=> $pagination,
                'delay' 		=> $delay,
                'autoplay' 		=> $auto_play,
            );
            $owl_option = json_encode( $owl_option );
            $element_attribute[] = "data-owl-i-options='$owl_option'";
        }
        if( $view_type != 'carousel' ){
            $item_class[] = 'col-lg-'.$desktop_column;
            $item_class[] = 'col-sm-'.$tablet_column;
        }        
        $element_attribute['classes'] = 'class="'.implode( ' ',$el_classes ).'"';        
        ob_start();                
        echo '<div '.implode( ' ',$element_attribute ).'>';
        if($the_query->have_posts()){
            while($the_query->have_posts()){
                $the_query->the_post();
                ?>
            <div class="<?php echo implode( ' ', $item_class ); ?>">
                <div <?php post_class('post-single'); ?> >
                    <?php     
                        // Post-Attachment-function
                        acrony_post_thumbnail( $image_size );    
                    ?>
                    <div class="post-content">
                        <div class="post-meta">
                            <div class="meta-item"><i class="fal fa-calendar-alt"></i><?php echo get_the_date(); ?></div>
                        </div>
                        <h4 class="title"><a href="<?php echo get_the_permalink(); ?>"><?php echo wp_trim_words( get_the_title(), $title_word_limit,'.' ); ?></a></h4>
                        <div class="content">
                            <?php echo wp_trim_words( get_the_content(), $desc_word_limit,'...' ); ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            }
            wp_reset_query();
        }else{
            get_template_part(  'template-parts/post-formats/post', 'none' );
        }
        echo '</div>';
        $data = ob_get_contents();
        ob_end_clean();
        return $data;
    }
}
add_shortcode( 'acrony_blog','acrony_blog_content' );
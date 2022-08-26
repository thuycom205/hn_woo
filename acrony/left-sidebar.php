<?php

/**
Template Name: Left Sidebar
**/


get_header();
get_template_part('template-parts/site-header');
?>
       <section class="section-padding">
        <div class="container">
            <div class="row">
                <div class="pull-right col-xs-12 <?php echo ( is_active_sidebar( 'sidebar-1' ) ? 'col-md-8' : '' ); ?>">
                    <div class="posts-list start-height">
                        <?php 
                        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                            $args = array(
                                'post_type'=> 'post',
                                'posts_per_page'=> get_option('posts_per_page'),
                                'paged' => $paged,
                            );
                            $p_query = new WP_Query( $args );
                            if( $p_query->have_posts() ){                                
			                   // Start the loop.
                                while($p_query->have_posts()){
                                    $p_query->the_post();                                    
                                    /*
                                     * Include the Post-Format-specific template for the content.
                                     * If you want to override this in a child theme, then include a file
                                     * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                                     */
                                    get_template_part( 'template-parts/post-formats/post', get_post_format() );
			                         // End the loop.
                                }
                            }else{
		                        // If no content, include the "No posts found" template.
                                get_template_part( 'template-parts/post-formats/post', 'none' );
                            }                        
                        ?>
                    </div>
                    <?php
                        $total_pages = $p_query->max_num_pages;
                        if ($total_pages > 1 ){
                            $current_page       = max(1, get_query_var('paged'));
                            echo '<div class="space-60" ></div><div class="nav-links text-center">';
                            echo paginate_links(array(
                                'base'          => get_pagenum_link(1) . '%_%',
                                'format'        => '/page/%#%',
                                'current'       => $current_page,
                                'total'         => $total_pages,
                                'prev_text' => '<i class="fal fa-angle-left"></i>',
                                'next_text' => '<i class="fal fa-angle-right"></i>',
                                'end_size'      => 3,
                                'mid_size'      => 2,
                                'prev_next'     => true,
                                'type'          => 'plain',
                            ));
                            echo '</div>';
                        }
                    ?>
                </div>
                <div class="col-xs-12 <?php echo ( is_active_sidebar( 'sidebar-1' ) ? 'col-md-4' : '' ); ?>">
                <div class="hidden visible-xs visible-sm space-60"></div>
                    <?php get_sidebar(); ?>
                </div>
            </div>
        </div>
    </section>
    <?php get_footer(); ?>
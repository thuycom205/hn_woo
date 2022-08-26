<?php 
    get_header(); 
    get_template_part('template-parts/site-header'); 
?>
<section class="blog-area section-padding">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 <?php echo ( is_active_sidebar( 'sidebar-1' ) ? 'col-md-8' : '' ); ?> ">
                <?php 
                
                while ( have_posts() ) :
                the_post();
                
                //Populer post view count function
                if( function_exists('acrony_set_post_views') ){
                    acrony_set_post_views(get_the_ID());
                }
                
                get_template_part( 'template-parts/post-formats/post', get_post_format() );
                
                // Post share social menu function.
                if( function_exists('acrony_entry_footer') ){ 
                    echo acrony_entry_footer(); 
                }
                
                // Post share social menu function.
                if( function_exists('acrony_post_share_social') ){ 
                    acrony_post_share_social(); 
                }
                
                // If comments are open or we have at least one comment, load up the comment template.
                if ( comments_open() || get_comments_number() ) :
                    comments_template();
                endif;
                
                // Previous/next post navigation.
                the_post_navigation(array(
                    'next_text' => esc_html__( 'Next Post','acrony' ).'<span class="title">%title</span>',
                    'prev_text' => esc_html__( 'Prev Post' , 'acrony' ).'<span class="title">%title</span>',
                ));
                
        		endwhile;
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
<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package appart
 */

get_header();
$blog_column = is_active_sidebar( 'sidebar_widgets' ) ? '8' : '12';
?>

    <section class="blog-area blog_single_area sec-pad">
        <div class="container">
                <div class="row">
                    <div class="col-md-<?php echo esc_attr($blog_column); ?> col-sm-12">
                        <div class="blog-section blog_single">
                            <?php
                            while ( have_posts() ) : the_post();
                                get_template_part( 'template-parts/content-single', get_post_format() );
                            endwhile;
                            ?>
                        </div>
	                    <?php
	                    // If comments are open or we have at least one comment, load up the comment template.
	                    if ( comments_open() || get_comments_number() ) :
		                    comments_template();
	                    endif;
	                    ?>
                    </div>
                    <?php get_sidebar(); ?>
            </div>
        </div>
    </section>

<?php
get_footer();
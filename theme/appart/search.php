<?php
/**
 * The template for displaying search results pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package faster
 */

get_header();

?>

    <section class="blog-area sec-pad">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-7 col-sm-12">
                    <div class="blog-section">
                        <?php
                        if ( have_posts() ) {
                            while (have_posts()) : the_post();
                                get_template_part('template-parts/content-default', get_post_format());
                            endwhile;
                            appart_pagination();
                        }else {
                            get_template_part( 'template-parts/content', 'none' );
                        }
                        ?>
                    </div>
                </div>

                <?php get_sidebar(); ?>

            </div>
        </div>
    </section>

<?php
get_footer();
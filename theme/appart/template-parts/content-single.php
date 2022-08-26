<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package appart
 */

$opt = get_option('appart_opt');
$is_social_share = isset($opt['is_social_share']) ? $opt['is_social_share'] : '1';
$is_post_tag = isset($opt['is_post_tag']) ? $opt['is_post_tag'] : '1';
?>

<div <?php post_class('blog-section blog_single') ?>>
    <article class="blog-items">
        <div class="blog-content">
            <?php
            the_content();
            wp_link_pages( array(
	            'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'appart' ) . '</span>',
	            'after'       => '</div>',
	            'link_before' => '<span>',
	            'link_after'  => '</span>',
	            'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'appart' ) . ' </span>%',
	            'separator'   => '<span class="screen-reader-text">, </span>',
            ));
            ?>
        </div>
    </article>

    <div class="post_tag_info">

        <?php
        if($is_post_tag=='1') : ?>
            <div class="post_tag pull-left">
                <?php the_tags('<i class="fa fa-tag"></i> <span>', '</span><span>, ', '</span>'); ?>
            </div>
        <?php endif; ?>

        <div class="social_icon pull-right">
            <?php
            if(function_exists('appart_social_share')) {
                if($is_social_share=='1') {
                    appart_social_share();
                }
            }
            ?>
        </div>
    </div>

</div>
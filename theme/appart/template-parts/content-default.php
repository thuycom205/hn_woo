<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package appart
 */

$allowed_html = array(
	'a' => array(
		'href' => array(),
		'title' => array()
	),
	'br' => array(),
	'em' => array(),
	'strong' => array(),
    'iframe' => array(
        'src' => array(),
    )
);
$opt = get_option('appart_opt');
$blog_excerpt = !empty($opt['blog_excerpt']) ? $opt['blog_excerpt'] : 40 ;
$is_post_meta = isset($opt['is_post_meta']) ? $opt['is_post_meta'] : '1';
$is_post_author = isset($opt['is_post_author']) ? $opt['is_post_author'] : '1';
$is_post_date = isset($opt['is_post_date']) ? $opt['is_post_date'] : '1';
$is_post_cat = isset($opt['is_post_cat']) ? $opt['is_post_cat'] : '1';
?>

    <article <?php post_class('blog-items'); ?>>
        <?php
        if(has_post_format('video')) {
            $post_metas = get_post_meta(get_the_ID(), 'post_metas', true);
            $post_video_url = isset($post_metas['post_video_url']) ? $post_metas['post_video_url'] : '';
            ?>
            <div class="blog-video blog-video1">
                <?php echo wp_kses($post_video_url, $allowed_html); ?>
            </div>
            <?php
        }
        elseif(has_post_format('audio')) {
            $post_metas = get_post_meta(get_the_ID(), 'post_metas', true);
            $post_audio_url = isset($post_metas['post_audio_url']) ? $post_metas['post_audio_url'] : '';
            ?>
            <div class="blog-video blog-video1">
                <?php echo wp_kses($post_audio_url, $allowed_html); ?>
            </div>
            <?php
        }
        else {
            if(has_post_thumbnail()) {
                ?>
                <a href="<?php the_permalink(); ?>" class="blog-img">
                    <?php the_post_thumbnail('appart_750x400', array('class' => 'img-responsive')); ?>
                </a>
                <?php
            }
        }
        ?>
        <div class="blog-content">
            <?php
            if(is_sticky()) {
	            echo '<div class="featured_post">'.esc_html__('Featured', 'appart').'</div>';
            }
            ?>
            <a href="<?php the_permalink(); ?>"><h2> <?php the_title(); ?> </h2></a>
            <p> <?php echo wp_trim_words(get_the_content(), $blog_excerpt); ?> </p>

            <?php if($is_post_meta=='1') : ?>
                <ul class="post-info">

                    <?php if($is_post_date=='1') : ?>
                        <li> <?php esc_html_e('Date:', 'appart'); ?>
                            <span><a href="<?php appart_day_link(); ?> "> <?php the_time(get_option('date_format')); ?></a> </span>
                        </li>
                    <?php endif; ?>

                    <?php if($is_post_author=='1') : ?>
                        <li> <?php esc_html_e('Author:', 'appart'); ?>
                            <a href="<?php echo get_author_posts_url(get_the_author_meta('ID'), get_the_author_meta('user_nicename')) ?>">
                                <?php echo get_the_author_meta('display_name'); ?>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if($is_post_cat=='1') : ?>
                        <li> <?php esc_html_e('Category: ', 'appart'); ?><?php the_category(', ') ?></li>
                    <?php endif; ?>

                </ul>
            <?php endif; ?>

        </div>
    </article>
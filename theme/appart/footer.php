<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package
 */

$opt = get_option('appart_opt');

$copyright_text = !empty($opt['copyright_txt']) ? $opt['copyright_txt'] : esc_html__('© 2021 DroitThemes. All rights reserved', 'appart');
?>

<footer class="footer-five">
    <?php if(is_active_sidebar('footer_widgets')) : ?>
        <div class="footer-top">
            <div class="container">
                <div class="row footer_sidebar">
                    <?php dynamic_sidebar('footer_widgets') ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <div class="row m0 footer_bottom text-center">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
	                <?php echo appart_wp_kses($copyright_text); ?>
                </div>
            </div>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
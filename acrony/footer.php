<?php
$remove_widget = get_post_meta( get_the_ID(), '_acrony_footer_widget', true );

if( is_active_sidebar('sidebar-2') or is_active_sidebar('sidebar-3') and $remove_widget != 'on' ): ?>
<footer class="footer-area">
    <?php if(is_active_sidebar('sidebar-2')):  ?>
    <div class="footer-top">
        <div class="container">
            <div class="row masonrys">
                <?php dynamic_sidebar( 'sidebar-2' ); ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <?php if( !empty(get_theme_mod('copyright_text')) or function_exists('acrony_social_menu_link') ):  ?>
    <div class="footer-bottom">
        <div class="container">
            <div class="row masonrys">
                <div class="col-xs-12 col-sm-6">
                    <div class="copyright">
                        <?php echo wp_kses_post(get_theme_mod('copyright_text')); ?>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <?php echo acrony_social_menu_link(); ?>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</footer>
<?php endif; ?>
<?php wp_footer(); ?>
</body>
</html>
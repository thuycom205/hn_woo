<?php
    // Preloader switch data.
    $sticky_menu        = get_theme_mod('acrony_sticky_menu');
    $menu_layout        = get_theme_mod('acrony_menu_layout');
    $menu_button_text   = get_theme_mod('acrony_menu_button_text');
    $menu_button_url    = get_theme_mod('acrony_menu_button_url');

    if($menu_layout == 'full_width'){
        $menu_layout = 'container-fluid';
    }else{
        $menu_layout = 'container';
    }

?>
<nav class="navbar mainmenu-area static" <?php echo ( ( $sticky_menu !==true ) ? 'data-spy="affix" data-offset-top="100"' : '' ); ?> >
    <div class="<?php echo esc_attr($menu_layout); ?>">
        <div class="equal-height">
            <div class="site-branding">
                <?php 
                if( function_exists('the_custom_logo') && has_custom_logo() ):
                    the_custom_logo();
                else: ?>
                <a href="<?php echo esc_url(home_url('/')); ?>">
                    <?php bloginfo('title'); ?>
                </a>
                <?php endif; ?>
            </div>
            <div class="primary-menu">
                <?php
                if(has_nav_menu('primary_menu')){   
                    wp_nav_menu(array(
                        'theme_location' => 'primary_menu',
                        'menu_class'     => 'nav',
                        'container'      => ' ',
                        'walker'         =>  new acrony_Nav_Menu_Walker
                    ));
                }
                ?>
            </div>
            <div class="right-nav">              
                <?php
                if ( function_exists('acrony_custom_mini_cart') ) {
                    acrony_custom_mini_cart();
                }
                if(!empty($menu_button_text)): ?>
                    <a href="<?php echo ( !empty($menu_button_url) ? esc_url($menu_button_url) : '#' ); ?>" class="header-button"><?php echo esc_html($menu_button_text); ?></a>
                <?php endif; ?>
                <button type="button" id="menu-button">
                    <i class="fal fa-bars"></i>
                    <i class="fal fa-times"></i>
                </button>
            </div>
        </div>
    </div>
</nav>

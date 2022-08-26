<?php
$opt = get_option('appart_opt');
$navbar_layout = isset($opt['navbar_layout']) ? $opt['navbar_layout'] : 'boxed';
$is_preloader = '';
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo('charset'); ?>">
        <!-- For IE -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- For Resposive Device -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <?php wp_head(); ?>
    </head>

<body <?php body_class(); ?> data-spy="scroll" data-target=".navbar" data-offset="75">
<?php wp_body_open(); ?>
    <?php if( $is_preloader == 1 ) { ?>
        <div id="preloader">
            <div id="status">&nbsp;</div>
        </div>
    <?php } ?>

    <nav id="fixed-top" class="<?php echo appart_wp_kses( ($navbar_layout=='full_width') ) ? 'nav_fluid' : ''; ?> navbar navbar-toggleable-sm transparent-nav navbar-expand-lg <?php echo is_404() ? 'header_error' : ''; ?>">
        <?php if($navbar_layout=='boxed') : ?> <div class="container"> <?php endif; ?>
        <?php echo appart_wp_kses( ($navbar_layout=='full_width') ) ? '<div class="container-fluid">' : '' ?>


            <a class="navbar-brand" href="<?php echo esc_url(home_url('/')); ?>">
                <?php
                if (isset($opt['main_logo']['url'])) {
                    $sticky_logo = isset($opt['sticky_logo'] ['url']) ? $opt['sticky_logo'] ['url'] : '';
                    $retina_logo = isset($opt['retina_logo'] ['url']) ? $opt['retina_logo'] ['url'] : '';
                    if(!is_404()) {
                        ?>
                        <img src="<?php echo esc_url($opt['main_logo']['url']); ?>" data-rjs="<?php echo esc_url($retina_logo) ?>" alt="<?php bloginfo('name'); ?>">
                        <img src="<?php echo esc_url($sticky_logo); ?>" data-rjs="<?php echo esc_url($retina_logo) ?>" alt="<?php bloginfo('name'); ?>">
                        <?php
                    }else {
                        ?> <img src="<?php echo esc_url($sticky_logo); ?>" alt="<?php bloginfo('name'); ?>"> <?php
                    }
                } else {
                    echo '<h3>' . get_bloginfo('name') . '</h3>';
                }
                ?>
            </a>
            <!--========== Brand and toggle get grouped for better mobile display ==========-->
            <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="<?php esc_attr_e('Toggle navigation', 'appart') ?>">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <!--========== Collect the nav links, forms, and other content for toggling ==========-->
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <?php
                if( has_nav_menu('main_menu') ) {
                    wp_nav_menu( array(
                        'menu' => 'main_menu',
                        'theme_location' => 'main_menu',
                        'container' => null,
                        'menu_class' => 'navbar-nav ml-auto',
                        'depth' => 3,
                        'walker' => new Appart_Nav_Navwalker,
                        'fallback_cv' => 'Appart_Nav_Navwalker::fallback'
                    ));
                }
                ?>
                <?php get_template_part('template-parts/header', 'mini_cart'); ?>
                <?php
                $is_menu_action_btn = isset( $opt['is_menu_action_btn'] ) ? $opt['is_menu_action_btn'] : '';
                if( $is_menu_action_btn == '1' ) { ?>
                    <a href="<?php echo esc_url($opt['menu_btn_url']) ?>" class="get-btn">
                        <?php echo esc_html($opt['menu_btn_label']); ?>
                    </a>
                <?php } ?>
            </div>
        </div>
    </nav>

<?php
get_template_part('template-parts/header', 'titlebar');
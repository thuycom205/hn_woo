<?php
namespace AppartCore\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use  Elementor\Core\Schemes\Color;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Typography;
use WP_Query;



// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}



/**
 * Text Typing Effect
 *
 * Elementor widget for text typing effect.
 *
 * @since 1.7.0
 */
class Appart_shop_categories extends Widget_Base {

    public function get_name() {
        return 'appart_shop_categories';
    }

    public function get_title() {
        return __( 'Shop Categories', 'appart-core' );
    }

    public function get_icon() {
        return ' eicon-cart-medium';
    }

    public function get_categories() {
        return [ 'appart-elements' ];
    }

    protected function _register_controls() {

        $this->start_controls_section(
            'filter', [
                'label' => __( 'Filter', 'appart-core' ),
            ]
        );
        $this->add_control(
            'show_count', [
                'label' => esc_html__( 'Show category count', 'appart-core' ),
                'type' => Controls_Manager::NUMBER,
                'label_block' => true,
                'default' => 4
            ]
        );
        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings();
        ?>
        <section class="popular_category_area">
            <div class="container custom_container">
                <div class="row p_category_info">
                <?php
                $cats = get_terms(array(
                    'taxonomy' => 'product_cat',
                    'hide_empty' => true
                ));
                //echo '<pre>'.print_r($cats, 1).'</pre>';
                if(is_array($cats)) {
                $i = 0;
                foreach ($cats as $cat) {
                    $thumbnail_id = get_term_meta( $cat->term_id, 'thumbnail_id', true );
                    $image_url = wp_get_attachment_url( $thumbnail_id );
                    if($i == $settings['show_count']) {
                        break;
                    }
                    if(!empty($image_url)) { ?>
                        <div class="col-lg-3 col-sm-6">
                            <div class="p_category_item">
                                <?php echo wp_get_attachment_image($thumbnail_id, 'appart_350x400', '', array('class'=>'img-fluid')) ?>
                                <div class="content">
                                    <a href="<?php echo get_term_link($cat); ?>"> <h3> <?php echo $cat->name ?> </h3></a>
                                </div>
                            </div>
                        </div>
                        <?php
                    $i++;
                }}}
                ?>
                </div>
            </div>
        </section>
        <?php
    }

}
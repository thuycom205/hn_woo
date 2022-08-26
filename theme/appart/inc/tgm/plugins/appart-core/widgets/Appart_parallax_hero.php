<?php
namespace AppartCore\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;



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
class Appart_parallax_hero extends Widget_Base {

    public function get_name() {
        return 'appart-parallax_hero';
    }

    public function get_title() {
        return __( 'Hero (Parallax Images)', 'appart-hero' );
    }

    public function get_icon() {
        return ' eicon-laptop';
    }

    public function get_categories() {
        return [ 'appart-elements' ];
    }

    protected function _register_controls() {

        // ------------------------------  Title Section ------------------------------
        $this->start_controls_section(
            'title_sec',
            [
                'label' => __( 'Title section', 'appart-core' ),
            ]
        );
        $this->add_control(
            'title',
            [
                'label' => esc_html__( 'Title text', 'appart-core' ),
                'description' => esc_html__( 'Use <br> tag for line breaking.', 'appart-core' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => 'We create best wordpress Theme'
            ]
        );
        $this->add_control(
            'subtitle', [
                'label' => esc_html__( 'Subtitle text', 'appart-core' ),
                'description' => esc_html__( 'Use <br> tag for line breaking.', 'appart-core' ),
                'type' => Controls_Manager::TEXTAREA,
                'label_block' => true,
            ]
        );
        $this->end_controls_section(); // End title section


        // ------------------------------ Button ------------------------------
        $this->start_controls_section(
            'button', [
                'label' => __( 'Button', 'appart-core' ),
            ]
        );
        $this->add_control(
            'btn_label', [
                'label' => esc_html__( 'Button label', 'appart-core' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => 'Learn More',
            ]
        );
        $this->add_control(
            'btn_url', [
                'label' => __( 'Button URL', 'appart-core' ),
                'type' => Controls_Manager::URL,
                'default' => [
                    'url' => '#'
                ]
            ]
        );
        $this->end_controls_section(); // End the Button


        // ------------------------------  Featured image ------------------------------
        $this->start_controls_section(
            'featured_image', [
                'label' => __( 'Featured images', 'appart-core' ),
            ]
        );
        $this->add_control(
            'images', [
                'label' => esc_html__( 'Images', 'appart-core' ),
                'desc' => esc_html__( 'Upload the featured images', 'appart-core' ),
                'type' => Controls_Manager::GALLERY,
            ]
        );
        $this->end_controls_section(); // End title section


        /**
         * Style Tab
         * ------------------------------ Style Title ------------------------------
         *
         */
        $this->start_controls_section(
            'style_title', [
                'label' => __( 'Style section title', 'appart-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'color_prefix', [
                'label' => __( 'Text Color', 'appart-core' ),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .appart_new_content h1' => 'color: {{VALUE}};',
                ],
                'default' => '#282835'
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'typography_prefix',
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .appart_new_content h1',
            ]
        );
        $this->end_controls_section();


        //------------------------------ Style subtitle ------------------------------
        $this->start_controls_section(
            'style_subtitle', [
                'label' => __( 'Style subtitle', 'appart-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'color_subtitle', [
                'label' => __( 'Text Color', 'appart-core' ),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .appart_new_content p' => 'color: {{VALUE}};',
                ],
                'default' => '#747d85'
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'typography_subtitle',
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .appart_new_content p',
            ]
        );
        $this->end_controls_section();


        //------------------------------ Style button ------------------------------
        $this->start_controls_section(
            'style_button', [
                'label' => __( 'Style button', 'appart-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'bg_color_btn', [
                'label' => __( 'Background color', 'appart-core' ),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .appart_new_content .new_banner_btn' => 'background-color: {{VALUE}};',
                ],
                'default' => '#4c84ff'
            ]
        );
        $this->add_control(
            'color_btn', [
                'label' => __( 'Text color', 'appart-core' ),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .appart_new_content .new_banner_btn' => 'color: {{VALUE}};',
                ],
                'default' => '#fff'
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'typography_btn',
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .appart_new_content .new_banner_btn',
            ]
        );
        $this->end_controls_section();

    }

    protected function render() {

        $settings = $this->get_settings();
        $images = isset($settings['images']) ? $settings['images'] : '';
        ?>
        <section class="appart_new_banner_area">
            <div class="new_parallax_effect scene" id="scene">
                <?php
                if(is_array($images)) {
                foreach ($images as $index => $image) {
                    switch ($index) {
                        case 0:
                            $depth_x = '10';
                            $depth_y = '0.10';
                            break;
                        case 1:
                            $depth_x = '20';
                            $depth_y = '0.10';
                            break;
                        case 2:
                            $depth_x = '30';
                            $depth_y = '0.20';
                            break;
                        case 3:
                            $depth_x = '20';
                            $depth_y = '-0.20';
                            break;
                        case 4:
                            $depth_x = '25';
                            $depth_y = '-0.10';
                            break;
                        case 5:
                            $depth_x = '15';
                            $depth_y = '-0.20';
                            break;
                        case 6:
                            $depth_x = '35';
                            $depth_y = '0.10';
                            break;
                        case 7:
                            $depth_x = '20';
                            $depth_y = '0.30';
                            break;
                    }
                    ?>
                    <div class="item item_<?php echo $index; ?> layer"
                         data-depth-x="0.<?php echo esc_attr($depth_x) ?>"
                         data-depth-y="<?php echo esc_attr($depth_y) ?>">
                        <?php echo wp_get_attachment_image($image['id'], 'full') ?>
                    </div>
                <?php }} ?>
            </div>
            <div class="container">
                <div class="appart_new_content text-center">

                    <?php echo (!empty($settings['title'])) ? '<h1>'.wp_kses_post($settings['title']).'</h1>' : ''; ?>

                    <?php echo (!empty($settings['subtitle'])) ? '<p>'.wp_kses_post($settings['subtitle']).'</p>' : ''; ?>

                    <?php  if (!empty($settings['btn_label'])) :
                        $is_external = $settings['btn_url']['is_external'] == true ? 'target="_blank"' : ''; ?>
                        <a href="<?php echo esc_url($settings['btn_url']['url']) ?>"
                           class="new_banner_btn" <?php echo $is_external; ?>>
                            <?php echo esc_html($settings['btn_label']) ?>
                        </a>
                    <?php endif; ?>

                </div>
            </div>
        </section>
        <?php
    }

}
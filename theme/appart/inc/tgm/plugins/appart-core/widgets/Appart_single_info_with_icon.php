<?php
namespace AppartCore\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Typography;



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
class Appart_single_info_with_icon extends Widget_Base {

    public function get_name() {
        return 'karpartz_single_info';
    }

    public function get_title() {
        return __( 'Single info with icon', 'karpartz-hero' );
    }

    public function get_icon() {
        return ' eicon-icon-box';
    }

    public function get_categories() {
        return [ 'appart-elements' ];
    }

    protected function _register_controls() {

        // ------------------------------  Title ------------------------------
        $this->start_controls_section(
            'title_sec', [
                'label' => __( 'Title', 'karpartz-core' ),
            ]
        );

        $this->add_control(
            'title', [
                'label' => esc_html__( 'Title text', 'karpartz-core' ),
                'type' => Controls_Manager::TEXTAREA,
                'label_block' => true,
                'default' => 'Default Title'
            ]
        );

        $this->add_control(
            'color_title', [
                'label' => __( 'Text Color', 'karpartz-core' ),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .new_featured_item h4' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'typography_title',
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .new_featured_item h4',
            ]
        );

        $this->end_controls_section(); // End title section


        // ------------------------------  Subtitle ------------------------------
        $this->start_controls_section(
            'subtitle_sec', [
                'label' => __( 'Content', 'karpartz-core' ),
            ]
        );

        $this->add_control(
            'subtitle', [
                'label' => esc_html__( 'Subtitle text', 'karpartz-core' ),
                'type' => Controls_Manager::TEXTAREA,
                'label_block' => true,
            ]
        );

        $this->add_control(
            'color_subtitle', [
                'label' => __( 'Text Color', 'karpartz-core' ),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .new_featured_item p' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'typography_subtitle',
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .new_featured_item p',
            ]
        );
        $this->end_controls_section(); // End subtitle section


        // ------------------------------  Icon ------------------------------
        $this->start_controls_section(
            'icon_sec', [
                'label' => __( 'Icon', 'karpartz-core' ),
            ]
        );

        $this->add_control(
            'icon_type', [
                'label' => esc_html__( 'Icon type', 'karpartz-core' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'ti_icon',
                'options' => [
                    'ti_icon' => __( 'Themify Icon', 'karpartz-core' ),
                    'fontawesome' => __( 'Fontawesome Icon', 'karpartz-core' ),
                ]
            ]
        );

        $this->add_control(
            'ti_icon', [
                'label' => __( 'Themify Icon', 'karpartz-core' ),
                'type' => Controls_Manager::ICON,
                'options' => appart_thimify_icons(),
                'include' => appart_thimify_include_icons(),
                'default' => 'icon-trophy',
                'condition' => [
                    'icon_type' => 'ti_icon'
                ]
            ]
        );

        $this->add_control(
            'fontawesome', [
                'label' => __( 'FlatIcon', 'karpartz-core' ),
                'type' => Controls_Manager::ICON,
                'condition' => [
                    'icon_type' => 'fontawesome'
                ]
            ]
        );

        $this->add_control(
            'icon_color', [
                'label' => __( 'Color', 'karpartz-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .new_featured_item i' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings();
        if($settings['icon_type'] == 'ti_icon') {
            $icon = $settings['ti_icon'];
        }
        elseif($settings['icon_type'] == 'fontawesome') {
            $icon = $settings['fontawesome'];
        }
        ?>
        <div class="new_featured_item">
            <i class="<?php echo esc_attr($icon) ?>"></i>
            <?php echo !empty($settings['title']) ? '<h4>'.esc_html($settings['title']).'</h4>' : ''; ?>
            <?php echo !empty($settings['subtitle']) ? '<p>'.esc_html($settings['subtitle']).'</p>' : ''; ?>
        </div>
    <?php
    }
}
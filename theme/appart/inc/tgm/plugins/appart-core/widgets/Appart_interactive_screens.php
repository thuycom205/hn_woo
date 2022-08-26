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
class Appart_interactive_screens extends Widget_Base {

    public function get_name() {
        return 'appart-interactive-screens';
    }

    public function get_title() {
        return __( 'Interactive Screens', 'appart-hero' );
    }

    public function get_icon() {
        return ' eicon-posts-group';
    }

    public function get_categories() {
        return [ 'appart-elements' ];
    }

    protected function _register_controls() {

        // ------------------------------  Title Section ------------------------------
        $this->start_controls_section(
            'title_sec', [
                'label' => __( 'Title section', 'appart-core' ),
            ]
        );
        $this->add_control(
            'title_content', [
                'label' => esc_html__( 'Title contents', 'appart-core' ),
                'type' => Controls_Manager::WYSIWYG,
                'label_block' => true,
                'default' => '<h2>Run your business with AppLand</h2>
                             <p>Beautiful design to customize yourstorefront and showcase your products. We’re a team of creative and make amazing site in ecommerce from Unite States. We love colour pastel.</p>
                             <a href="#">GET STARTED</a>'
            ]
        );
        $this->end_controls_section(); // End title section

        // ------------------------------  Featured image ------------------------------
        $this->start_controls_section(
            'images_sec', [
                'label' => __( 'Featured images', 'appart-core' ),
            ]
        );
        $this->add_control(
            'images', [
                'label' => __( 'Images', 'appart-core' ),
                'type' => Controls_Manager::REPEATER,
                'title_field' => '{{{ title }}}',
                'fields' => [
                    [
                        'name' => 'title',
                        'label' => __( 'Image title', 'appart-core' ),
                        'type' => Controls_Manager::TEXT,
                        'label_block' => true
                    ],
                    [
                        'name' => 'image',
                        'label' => __( 'Image', 'appart-core' ),
                        'type' => Controls_Manager::MEDIA,
                    ],
                    [
                        'name' => 'image_position',
                        'label' => __( 'Image position', 'appart-core' ),
                        'type' => Controls_Manager::DIMENSIONS,
                        'size_units' => [ 'px', '%', 'em' ],
                        'selectors' => [
                            '{{WRAPPER}} .phone-mockup .phone {{{ # }}}' => 'top: {{TOP}}{{UNIT}}; right: {{RIGHT}}{{UNIT}}; bottom: {{BOTTOM}}{{UNIT}}; left: {{LEFT}}{{UNIT}};',
                        ],
                    ],
                    [
                        'name' => 'scroll_position',
                        'label' => __( 'Scroll position', 'appart-core' ),
                        'type' => Controls_Manager::SELECT,
                        'default' => 'after',
                        'options' => [
                            'before' => 'Before',
                            'after' => 'After',
                            'between' => 'Between',
                        ]
                    ],
                    [
                        'name' => 'top_x',
                        'label' => __( 'Top horizontal scroll position', 'appart-core' ),
                        'type' => Controls_Manager::NUMBER,
                        'default' => '-50'
                    ],
                    [
                        'name' => 'top_y',
                        'label' => __( 'Top vertical scroll position', 'appart-core' ),
                        'type' => Controls_Manager::NUMBER,
                        'default' => '-10'
                    ],
                    [
                        'name' => 'bottom_x',
                        'label' => __( 'Bottom horizontal scroll position', 'appart-core' ),
                        'type' => Controls_Manager::NUMBER,
                        'default' => '50'
                    ],
                    [
                        'name' => 'bottom_y',
                        'label' => __( 'Bottom vertical scroll position', 'appart-core' ),
                        'type' => Controls_Manager::NUMBER,
                        'default' => '-10'
                    ],
                ]
            ]
        );
        $this->end_controls_section(); // End title section


        // ------------------------------Buttons -------------------------
        $this->start_controls_section(
            'buttons_sec', [
                'label' => __( 'Buttons', 'appart-core' ),
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'label' => __( 'Button font properties', 'appart-core' ),
                'name' => 'typography_buttons',
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .b_features_content .app-store-btn a',
            ]
        );
        $this->add_control(
            'buttons', [
                'label' => __( 'Create buttons', 'appart-core' ),
                'type' => Controls_Manager::REPEATER,
                'title_field' => '{{{ label }}}',
                'fields' => [
                    [
                        'name' => 'label',
                        'label' => __( 'Button name', 'appart-core' ),
                        'type' => Controls_Manager::TEXT,
                        'label_block' => true,
                        'default' => 'Get app now'
                    ],
                    [
                        'name' => 'url',
                        'label' => __( 'Button URL', 'appart-core' ),
                        'type' => Controls_Manager::URL,
                        'default' => [
                            'url' => '#'
                        ]
                    ],
                    [
                        'name' => 'color',
                        'label' => __( 'Button color', 'appart-core' ),
                        'type' => Controls_Manager::COLOR,
                        'default' => '#fff',
                    ],
                    [
                        'name' => 'icon',
                        'label' => __( 'Button icon', 'appart-core' ),
                        'type' => Controls_Manager::ICON,
                        'default' => 'fa fa-apple',
                    ],
                ],
            ]
        );
        $this->end_controls_section(); // End Buttons
    }

    protected function render() {
        $settings = $this->get_settings();
        $images = isset($settings['images']) ? $settings['images'] : '';
        $buttons = isset($settings['buttons']) ? $settings['buttons'] : '';
        ?>
        <section class="business_features_area">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="b_features_content">
                           <?php echo wp_kses_post(wpautop($settings['title_content'])) ?>
                            <div class="app-store-btn">
                                <?php
                                if(is_array($buttons)) {
                                foreach ($buttons as $button) {
                                    $is_external = $button['url']['is_external'] ? 'target="_blank"' : '';
                                    echo '<a style="color:'.$button['color'].';" href="'.$button['url']['url'].'" '.$is_external.'>
                                    <i style="color:'.$button['color'].';" class="'.$button['icon'].'" aria-hidden="true"></i> '.$button['label'].' </a>';
                                }}
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="phone-mockup">
                            <?php
                            if(is_array($images)) {
                            $img_i = 1;
                            foreach ($images as $image) {
                                $unit = isset($image['image_position']['unit']) ? $image['image_position']['unit'] : '';
                                ?>
                                <style>
                                    .phone-mockup .phone-<?php echo $img_i ?> {
                                        <?php echo !empty($image['image_position']['top']) ? 'top:'.$image['image_position']['top'].$unit : ''; ?>;
                                        <?php echo !empty($image['image_position']['right']) ? 'right:'.$image['image_position']['right'].$unit : ''; ?>;
                                        <?php echo !empty($image['image_position']['bottom']) ? 'bottom:'.$image['image_position']['bottom'].$unit : ''; ?>;
                                        <?php echo !empty($image['image_position']['left']) ? 'left:'.$image['image_position']['left'].$unit : ''; ?>;
                                    }
                                </style>
                                <?php
                                $alt = !empty($image['title']) ? 'alt="'.$image['title'].'"' : '';
                                $top_x = !empty($image['top_x']) ? 'translateX('.$image['top_x'].'px)' : '';
                                $top_y = !empty($image['top_y']) ? 'translateY('.$image['top_y'].'px)' : '';
                                $bottom_x = !empty($image['bottom_x']) ? 'translateX('.$image['bottom_x'].'px)' : '';
                                $bottom_y = !empty($image['bottom_y']) ? 'translateY('.$image['bottom_y'].'px)' : '';
                                echo '<img class="phone-'.$img_i.' skrollable skrollable-'.$image['scroll_position'].'" 
                                      data-bottom="transform:'.$bottom_y.' '.$bottom_x.';" 
                                      data-top="transform:'.$top_y.' '.$top_x.';" 
                                      src="'.$image['image']['url'].'"
                                      '.$alt.'>';
                                ++$img_i;
                            }}
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php
    }

}
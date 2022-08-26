<?php
namespace AppartCore\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use  Elementor\Core\Schemes\Color;
use Elementor\Core\Schemes\Typography;
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
class Appart_tab extends Widget_Base {

    public function get_name() {
        return 'appart-tab';
    }

    public function get_title() {
        return __( 'AppArt Tab', 'appart-hero' );
    }

    public function get_icon() {
        return ' eicon-tabs';
    }

    public function get_categories() {
        return [ 'appart-elements' ];
    }

    protected function _register_controls() {

        // ------------------------------  Title Section ------------------------------
        $this->start_controls_section(
            'title_sec', [
                'label' => __( 'AppArt Tab', 'appart-core' ),
            ]
        );
        $this->add_control(
            'title_text', [
                'label' => esc_html__( 'Title text', 'appart-core' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => 'Users Review'
            ]
        );
        $this->add_control(
            'subtitle_text', [
                'label' => esc_html__( 'Subtitle text', 'appart-core' ),
                'type' => Controls_Manager::TEXTAREA,
                'label_block' => true,
                'default' => 'Our Products'
            ]
        );
        $this->end_controls_section(); // End title section

        // ------------------------------ Tab items ------------------------------
        $this->start_controls_section(
            'tab_items', [
                'label' => __( 'Tabs', 'appart-core' ),
            ]
        );
        $this->add_control(
            'tabs', [
                'label' => __( 'Tab items', 'appart-core' ),
                'type' => Controls_Manager::REPEATER,
                'title_field' => '{{{ title }}}',
                'default' => [

                ],
                'fields' => [
                    [
                        'name' => 'title',
                        'label' => esc_html__('Title', 'appart-core'),
                        'type' => Controls_Manager::TEXT,
                        'default' => 'Tab #1',
                    ],
                    [
                        'name' => 'content',
                        'type' =>  Controls_Manager::WYSIWYG,
                        'label' => esc_html__('Tab Content', 'appart-core'),
                    ],
                    [
                        'name' => 'is_box_shadow',
                        'type' =>  Controls_Manager::SWITCHER,
                        'label' => esc_html__('Is image box shadow?', 'appart-core'),
                        'description' => esc_html__('Enable/Disable image box shadow in tab content.', 'appart-core'),
                        'label_on' => __( 'Yes', 'appart-core' ),
                        'label_off' => __( 'No', 'appart-core' ),
                        'return_value' => 'yes',
                    ],
                ],
            ]
        );
        $this->end_controls_section();


        /**
         * Style Tab
         * ------------------------------ Style Title ------------------------------
         *
         */
        $this->start_controls_section(
            'style_title', [
                'label' => __( 'Style title', 'appart-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'color_prefix', [
                'label' => __( 'Text Color', 'appart-core' ),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Color::get_type(),
                    'value' => Color::COLOR_1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .title-four h2' => 'color: {{VALUE}};',
                ],
                'default' => '#1a264a'
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'typography_prefix',
                'scheme' => Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .title-four h2',
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
                    'type' => Color::get_type(),
                    'value' => Color::COLOR_1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .title-four p' => 'color: {{VALUE}};',
                ],
                'default' => '#585e68'
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'typography_subtitle',
                'scheme' => Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .title-four p',
            ]
        );
        $this->end_controls_section();
    }

    protected function render() {

        $settings = $this->get_settings();
        $tabs = isset($settings['tabs']) ? $settings['tabs'] : '';
        ?>
        <section class="features-area3">
            <div class="container">
                <div class="title-four text-center">
                    <?php if(!empty($settings['subtitle_text'])) : ?>
                        <h5> <?php echo $settings['subtitle_text']; ?> </h5>
                    <?php endif;?>
                    <?php if(!empty($settings['title_text'])) : ?>
                        <h2 class="wow fadeInUp"> <?php echo esc_html($settings['title_text']); ?> </h2>
                    <?php endif; ?>
                    <div class="br"></div>
                </div>
                <ul class="nav nav-tabs features-tab" role="tablist">
                    <?php
                    if(is_array($tabs)) {
                    $i = 1;
                    foreach ($tabs as $tab) {
                        $active = $i==1 ? 'active' : '';
                        echo '
                        <li role="presentation" class="nav-item">
                            <a href="#serviceNo-'.$i.'" class="nav-link '.$active.'" aria-controls="serviceNo-'.$i.'" role="tab" data-toggle="tab" aria-expanded="true"> '.$tab['title'].' </a>
                        </li>';
                        ++$i;
                    }}
                    ?>
                </ul>
                <div class="tab-content">
                    <?php
                    if(is_array($tabs)) {
                    $tc_i = 1;
                    foreach ($tabs as $tab) {
                        $active = $tc_i==1 ? 'active' : '';
                        $image_box_shadow = $tab['is_box_shadow']=='yes' ? 'image_box_shadow' : '';
                        ?>
                        <div role="tabpanel" class="tab-pane fade show <?php echo $active ?>" id="serviceNo-<?php echo $tc_i ?>">
                            <div class="row tab_content <?php echo $image_box_shadow ?>">
                                <?php echo wpautop($tab['content']) ?>
                            </div>
                        </div>
                        <?php
                        ++$tc_i;
                    }};
                    ?>
                </div>
            </div>
        </section>
        <?php
    }
}
<?php
namespace AppartCore\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use  Elementor\Core\Schemes\Color;
use Elementor\Core\Schemes\Typography;
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
class Appart_subscribe extends Widget_Base {

    public function get_name() {
        return 'appart_subsciribe';
    }

    public function get_title() {
        return __( 'Subscribe form', 'appart-core' );
    }

    public function get_icon() {
        return '  eicon-mailchimp';
    }

    public function get_categories() {
        return [ 'appart-elements' ];
    }

    protected function _register_controls() {

        // ------------------------------  Title Section ------------------------------
        $this->start_controls_section(
            'title_sec', [
                'label' => __( 'Contents', 'appart-core' ),
            ]
        );
        $this->add_control(
            'title_text', [
                'label' => esc_html__( 'Title text', 'appart-core' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => 'Find Our App On'
            ]
        );
        $this->add_control(
            'subtitle_text', [
                'label' => esc_html__( 'Subtitle text', 'appart-core' ),
                'type' => Controls_Manager::TEXTAREA,
                'label_block' => true,
                'default' => 'Receive updates, news and deals'
            ]
        );
        $this->end_controls_section(); // End title section

        // ------------------------------ MailChimp form ------------------------------
        $this->start_controls_section(
            'form_settings', [
                'label' => __( 'Form settings', 'appart-core' ),
            ]
        );
        $this->add_control(
            'btn_label', [
                'label' => esc_html__( 'Submit button label', 'appart-core' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => 'Subscribe'
            ]
        );
        $this->add_control(
            'email_placeholder', [
                'label' => esc_html__( 'Email filed placeholder', 'appart-core' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => 'Enter your email'
            ]
        );
        $this->add_control(
            'action_url', [
                'label' => esc_html__( 'Action URL', 'appart-core' ),
                'description' => __( 'Enter here your MailChimp action URL. <a href="https://goo.gl/JedUPV" target="_blank"> How to </a>', 'appart-core' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );
        $this->end_controls_section();
        /**
         * Style Tab
         * ------------------------------ Style Title ------------------------------
         */
        $this->start_controls_section(
            'style_title', [
                'label' => __( 'Style title', 'appart-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'color_title', [
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
                'name' => 'typography_title',
                'scheme' => Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .title-four h2',
            ]
        );
        $this->end_controls_section();

        //------------------------------ Style subtitle ------------------------------
        $this->start_controls_section(
            'style_subtitle',
            [
                'label' => __( 'Style subtitle', 'appart-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'color_suffix',
            [
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
            Group_Control_Typography::get_type(),
            [
                'name' => 'typography_subtitle',
                'scheme' => Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .title-four p',
            ]
        );
        $this->end_controls_section();

        //------------------------------ Style Section ------------------------------
        $this->start_controls_section(
            'style_section', [
                'label' => __( 'Style section', 'appart-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'sec_bg_image', [
                'label' => esc_html__( 'Background image', 'appart-core' ),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => get_stylesheet_directory_uri().'/assets/image/map_tecture.png'
                ]
            ]
        );
        $this->add_control(
            'sec_padding', [
                'label' => __( 'Section padding', 'appart-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .subscribe_area_two' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => '120',
                    'right' => '0',
                    'bottom' => '120',
                    'left' => '0',
                    'unit' => 'px', // The selected CSS Unit. 'px', '%', 'em',
                    'isLinked' => false,
                ],
            ]
        );
        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings();
        if(!empty($settings['sec_bg_image']['url'])) :
            ?>
            <style>
                .subscribe_area_two:before {
                    content: "";
                    background: url(<?php echo $settings['sec_bg_image']['url']; ?>) no-repeat scroll center 0;
                    position: absolute;
                    width: 100%;
                    height: 100%;
                    top: 0;
                    left: 0;
                    z-index: -1;
                }
            </style>
        <?php endif; ?>
        <section class="subscribe_area_two">
            <div class="container">
                <div class="wow fadeInUp">
                    <div class="title-four h_color text-center">
                        <?php if(!empty($settings['title_text'])) : ?>
                            <h2> <?php echo esc_html($settings['title_text']); ?> </h2>
                        <?php endif; ?>
                        <?php if(!empty($settings['subtitle_text'])) : ?>
                            <p class="p_color"><?php echo $settings['subtitle_text']; ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="input-group subcribes">
                        <form action="<?php echo $settings['action_url'] ?>" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" target="_blank" novalidate>
                            <input type="email" name="EMAIL" class="form-control memail" placeholder="<?php echo $settings['email_placeholder'] ?>">
                            <span class="input-group-btn">
                                <button class="btn btn-submit" type="submit"> <?php echo $settings['btn_label'] ?> </button>
                            </span>
                        </form>
                    </div>
                    <p class="mchimp-errmessage"></p>
                    <p class="mchimp-sucmessage"></p>
                </div>
            </div>
        </section>
        <?php
    }

}
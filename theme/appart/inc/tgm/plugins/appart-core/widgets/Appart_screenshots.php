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
class Appart_screenshots extends Widget_Base {

	public function get_name() {
		return 'appart-screenshots';
	}

	public function get_title() {
		return __( 'Screenshots Carousel', 'appart-hero' );
	}

	public function get_icon() {
		return ' eicon-post-slider';
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
			'title_text', [
				'label' => esc_html__( 'Title text', 'appart-core' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => 'Screen Shots'
			]
		);
		$this->add_control(
			'subtitle_text', [
				'label' => esc_html__( 'Subtitle text', 'appart-core' ),
				'type' => Controls_Manager::TEXTAREA,
				'label_block' => true,
				'default' => 'We’re a team of creative and make amazing site in ecommerce from Unite States. We love colour highlight and simple, its make our design look so awesome'
			]
		);
		$this->end_controls_section(); // End title section

		// ------------------------------  Featured image ------------------------------
		$this->start_controls_section(
			'images_sec', [
				'label' => __( 'Images', 'appart-core' ),
			]
		);
		$this->add_control(
			'images', [
				'label' => esc_html__( 'Add images', 'appart-core' ),
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
			'color_title', [
				'label' => __( 'Text Color', 'appart-core' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .section_title_three .title_three' => 'color: {{VALUE}};',
				],
				'default' => '#324865'
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(), [
				'name' => 'typography_title',
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .section_title_three .title_three',
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
					'{{WRAPPER}} .section_title_three p' => 'color: {{VALUE}};',
				],
				'default' => '#585e68'
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(), [
				'name' => 'typography_subtitle',
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .section_title_three p',
			]
		);
		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings();
		$images = isset($settings['images']) ? $settings['images'] : '';
        ?>
        <section class="screenshot_area_two">
            <div class="container">
                <div class="title-four text-center">
                    <?php if(!empty($settings['title_text'])) : ?>
                        <h2 class="title_three color-b"> <?php echo $settings['title_text']; ?> </h2>
                    <?php endif; ?>
                    <?php if(!empty($settings['subtitle_text'])) : ?>
                        <?php echo wpautop($settings['subtitle_text']);
                    endif; ?>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="swiper-container">
                            <div class="swiper-wrapper">
                                <?php
                                if(is_array($images)) {
                                foreach ($images as $image) {
                                    echo '<div class="swiper-slide">
                                            <img class="img-responsive" src="'.$image['url'].'" alt="">
                                         </div>';
                                }}
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <script src="<?php echo get_stylesheet_directory_uri().'/assets/vendor/swipper/swiper.min.js' ?>"></script>
        <script>
            function getSlide() {
                var wW = jQuery(window).width();
                if (wW < 601) {
                    return 1;
                }
                return 3;
            }
            var mySwiper = jQuery('.swiper-container').swiper({
                mode: 'horizontal',
                autoplay: 2000,
                loop: true,
                speed: 400,
                effect: 'coverflow',
                slidesPerView: getSlide(),
                grabCursor: true,
                nextButton: '.swiper-button-next',
                prevButton: '.swiper-button-prev',
                keyboardControl: true,
                pagination:'.swiper-pagination',
                paginationClickable: true,
                coverflow: {
                    rotate: 0,
                    stretch: 0,
                    depth: 170,
                    modifier: 1,
                    slideShadows: false
                }
            });
        </script>
        <?php
	}

}
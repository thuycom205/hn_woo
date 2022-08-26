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
class Appart_logo_carousel extends Widget_Base {

	public function get_name() {
		return 'appart-logo-carousel';
	}

	public function get_title() {
		return __( 'Logo Carousel', 'appart-hero' );
	}

	public function get_icon() {
		return 'eicon-carousel';
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
			'title_text', [
				'label' => esc_html__( 'Title text', 'appart-core' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => 'Trusted By Great Teams'
			]
		);

		$this->add_control(
			'subtitle_text', [
				'label' => esc_html__( 'Subtitle text', 'appart-core' ),
				'type' => Controls_Manager::TEXTAREA,
				'label_block' => true,
				'default' => 'We’re a team of creative and make amazing site in ecommerce from Unite States. We love colour pastel, highlight and simple, its make our design look so awesome'
			]
		);

		$this->add_control(
			'title_sec_margin', [
				'label' => esc_html__( 'Margin', 'appart-core' ),
				'description' => esc_html__( 'Margin around title section', 'appart-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .title-four' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'default' => [
					'top' => '0',
					'right' => '0',
					'bottom' => '100',
					'left' => '0',
					'unit' => 'px', // The selected CSS Unit. 'px', '%', 'em',
					'isLinked' => false,
				],
			]
		);

		$this->end_controls_section(); // End title section


		// ------------------------------ Feature list ------------------------------
		$this->start_controls_section(
			'logo_carousel', [
				'label' => __( 'Logos', 'appart-core' ),
			]
		);
		$this->add_control(
			'logos', [
				'label' => __( 'Add Logos', 'appart-core' ),
				'type' => Controls_Manager::REPEATER,
				'title_field' => '{{{ title }}}',
				'fields' => [
					[
						'name' => 'title',
						'label' => __( 'Logo title', 'appart-core' ),
						'type' => Controls_Manager::TEXT,
						'label_block' => true,
						'default' => 'Company Name'
					],
					[
						'name' => 'logo',
						'label' => __( 'Logo', 'appart-core' ),
						'type' => Controls_Manager::MEDIA,
					],
				],
			]
		);
		$this->end_controls_section(); // End Buttons


		/**
		 * Style Tab
		 * ------------------------------ Style Title ------------------------------
		 *
		 */
		$this->start_controls_section(
			'style_title', [
				'label' => __( 'Style Section Title', 'appart-core' ),
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
			'style_subtitle',
			[
				'label' => __( 'Style Subtitle', 'appart-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'color_suffix', [
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
        $this->add_control(
            'margin_around_subtitle', [
                'label' => __( 'Margin around the subtitle', 'appart-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .title-four p' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => '15',
                    'bottom' => '50',
                    'unit' => 'px', // The selected CSS Unit. 'px', '%', 'em',
                    'isLinked' => false,
                ],
            ]
        );
		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings();
		$logos = isset($settings['logos']) ? $settings['logos'] : '';
		?>
        <section class="clients-logo-area">
            <div class="container">
                <div class="title-four text-center">
                    <?php if(!empty($settings['title_text'])) : ?>
                        <h2> <?php echo $settings['title_text'] ?> </h2>
                    <?php endif; ?>
                    <?php if(!empty($settings['subtitle_text'])) : ?>
                        <p> <?php echo $settings['subtitle_text'] ?> </p>
                    <?php endif; ?>
                </div>
                <div class="clients-lg-slider owl-carousel">
                    <?php
                    if(is_array($logos)) {
                    foreach ($logos as $logo) {
                        ?>
                        <div class="item">
                            <img src="<?php echo $logo['logo']['url'] ?>" alt="<?php echo $logo['title'] ?>">
                        </div>
                        <?php
                    }}
                    ?>
                </div>
            </div>
        </section>
		<?php
	}
}

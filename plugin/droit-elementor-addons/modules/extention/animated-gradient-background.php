<?php
namespace DROIT_ELEMENTOR\Module\Extention;

defined( 'ABSPATH' ) || exit;

use \Elementor\Element_Base;

class Animated_Gradient_Background {

	/**
	 * Intance of the class
	 *
	 * @var object
	 */
	private static $instance;

	/**
	 * Loader.
	 */
	public function load() {
		add_action( 'elementor/frontend/after_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
		add_action( 'elementor/frontend/after_enqueue_styles', [ $this, 'enqueue_styles' ] );
		add_action( 'elementor/element/section/section_background/after_section_end', [ $this, 'animated_gradient_background_section' ], 10, 2 );
		add_action( 'elementor/element/container/section_background/after_section_end', [ $this, 'animated_gradient_background_section' ], 10, 2 );

		add_action( 'elementor/element/section/section_dl_animated_gradient_background/before_section_end', [ $this, 'add_controls' ], 10, 2 );
		add_action( 'elementor/element/container/section_dl_animated_gradient_background/before_section_end', [ $this, 'add_controls' ], 10, 2 );

		add_action( 'elementor/frontend/section/before_render', [ $this, 'render' ], 10, 1 );
		add_action( 'elementor/frontend/container/before_render',[ $this, 'render' ], 10, 1 );

		add_action( 'elementor/section/print_template', array( $this, 'render_template' ), 10, 2 );
		add_action( 'elementor/container/print_template', array( $this, 'render_template' ), 10, 2 );
	}

	/**
	 * Enqueue scripts.
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( 'droit-animated-gradient-bg', drdt_core()->js . 'dl-animated-gradient-bg' . drdt_core()->minify . '.js', [ 'jquery' ], drdt_core()->version, true );
	}

	/**
	 * Enqueue scripts.
	 */
	public function enqueue_styles() {
		wp_enqueue_style( 'droit-animated-gradient-bg', drdt_core()->css . 'dl-animated-gradient-bg.css', [], drdt_core()->version );
	}

	/**
	 * Add Animated Gradient Background Section.
	 *
	 * @param Element_Base $element Elementor Element.
	 */
	public function animated_gradient_background_section( Element_Base $element ) {
		$section = 'section_dl_animated_gradient_background';

		$element->start_controls_section(
			$section,
			[
				'label' => __( 'Animated Gradient Background', 'droit-elementor-addons' ) . dl_get_icon(),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$element->end_controls_section();
	}

	/**
	 * Controls.
	 *
	 * @param Element_Base $element Elementor Element.
	 */
	public function add_controls( Element_Base $element ) {
		if ( ! did_action( 'droitPro/loaded' ) ) {
            return;
        }
		$element->add_control(
			'dl_animated_gradient_bg',
			[
				'label'        => __( 'Enable Animated Gradient Background?', 'droit-elementor-addons' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'droit-elementor-addons' ),
				'label_off'    => __( 'No', 'droit-elementor-addons' ),
				'return_value' => 'yes',
				'default'      => '',
				'prefix_class' => 'dl-animated-gradient-bg-',
				'render_type'  => 'template',
			]
		);

		$element->add_control(
			'dl_animated_gradient_bg_angle',
			[
				'label' => __( 'Angle', 'droit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'deg' => [
						'min'  => -45,
						'max'  => 180,
						'step' => 2,
					],
				],
				'default' => [
					'unit' => 'deg',
					'size' => -45,
				],
				// 'selectors' => [
				// 	'{{WRAPPER}}' => 'background-image: linear-gradient({{SIZE}}deg, {{dl_animated_gradient_bg_color.VALUE}} 0%, {{dl_animated_gradient_bg_color_2.VALUE}} 100%);',
				// ],
				'condition' => [
					'dl_animated_gradient_bg' => 'yes',
				],
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'dl_animated_gradient_bg_color',
			[
				'label' => __( 'Add Color', 'droit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::COLOR,
			]
		);

		$element->add_control(
			'dl_animated_gradient_bg_color_list',
			[
				'label'      => __( 'Colors', 'droit-elementor-addons' ),
				'type'       => \Elementor\Controls_Manager::REPEATER,
				'fields'     => $repeater->get_controls(),
				'show_label' => true,
				'default'    => [
					[
						'dl_animated_gradient_bg_color' => '#ee7752',
					],
					[
						'dl_animated_gradient_bg_color' => '#e73c7e',
					],
					[
						'dl_animated_gradient_bg_color' => '#23a6d5',
					],
				],
				'condition' => [
					'dl_animated_gradient_bg' => 'yes',
				],
			]
		);
	}

	/**
	 * Render.
	 *
	 * @param Element_Base $element Elementor Element.
	 */
	public function render( Element_Base $element ) {
		$settings = $element->get_settings_for_display();

		if ( 'yes' === $settings['dl_animated_gradient_bg'] ) {
			$element->add_render_attribute( '_wrapper', 'data-gradient-angle', $settings['dl_animated_gradient_bg_angle']['size'] . 'deg' );
			$element->add_render_attribute( '_wrapper', 'data-gradient-colors', implode( ',', array_column( $settings['dl_animated_gradient_bg_color_list'], 'dl_animated_gradient_bg_color' ) ) );
		}
	}

	/**
	 * Editor Template.
	 */
	public function render_template( $template ) {
		if ( ! $template ) {
			return;
		}

		ob_start();
		$old_template = $template;
		?>
		<# if ( 'yes' === settings.dl_animated_gradient_bg ) { #>
			<#
				var gradient_angle = settings.dl_animated_gradient_bg_angle.size + 'deg';
				var gradient_colors = settings.dl_animated_gradient_bg_color_list.map(function(item) {
					return item.dl_animated_gradient_bg_color;
				}).join(',');
				var gradientColorBG = 'linear-gradient(' + gradient_angle + ', ' + gradient_colors + ')';
			#>
			<div class="dl-animated-gradient-bg" data-gradient-angle="{{ gradient_angle }}" data-gradient-colors="{{ gradient_colors }}" style="background-image: {{{ gradientColorBG }}}"></div>
		<# } #>
		<?php
		$content = ob_get_contents();
		ob_end_clean();
		$template = $content . $old_template;

		return $template;
	}
	/**
	 * Instantiate the class.
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

}

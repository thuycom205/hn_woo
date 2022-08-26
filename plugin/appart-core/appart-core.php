<?php
/**
 * Plugin Name: Appart Core
 * Plugin URI: https://themeforest.net/user/droitthemes/portfolio
 * Description: This plugin adds the core features to the Appart WordPress theme. You must have to install this plugin to work with this theme.
 * Version: 2.8
 * Author: DroitThemes
 * Author URI: https://themeforest.net/user/droitthemes/portfolio
 * Text domain: appart-core
 */

if ( !defined('ABSPATH') )
    die('-1');


// Make sure the same class is not loaded twice in free/premium versions.
if ( !class_exists( 'Appart_core' ) ) {
	/**
	 * Main Appart Core Class
	 *
	 * The main class that initiates and runs the Appart Core plugin.
	 *
	 * @since 1.7.0
	 */
	final class Appart_core {
		/**
		 * Appart Core Version
		 *
		 * Holds the version of the plugin.
		 *
		 * @since 1.7.0
		 * @since 1.7.1 Moved from property with that name to a constant.
		 *
		 * @var string The plugin version.
		 */
		const  VERSION = '1.0' ;
		/**
		 * Minimum Elementor Version
		 *
		 * Holds the minimum Elementor version required to run the plugin.
		 *
		 * @since 1.7.0
		 * @since 1.7.1 Moved from property with that name to a constant.
		 *
		 * @var string Minimum Elementor version required to run the plugin.
		 */
		const  MINIMUM_ELEMENTOR_VERSION = '1.7.0';
		/**
		 * Minimum PHP Version
		 *
		 * Holds the minimum PHP version required to run the plugin.
		 *
		 * @since 1.7.0
		 * @since 1.7.1 Moved from property with that name to a constant.
		 *
		 * @var string Minimum PHP version required to run the plugin.
		 */
		const  MINIMUM_PHP_VERSION = '5.4' ;
		/**
		 * Instance
		 *
		 * Holds a single instance of the `Press_Elements` class.
		 *
		 * @since 1.7.0
		 *
		 * @access private
		 * @static
		 *
		 * @var Press_Elements A single instance of the class.
		 */
		private static  $_instance = null ;
		/**
		 * Instance
		 *
		 * Ensures only one instance of the class is loaded or can be loaded.
		 *
		 * @since 1.7.0
		 *
		 * @access public
		 * @static
		 *
		 * @return Press_Elements An instance of the class.
		 */
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		/**
		 * Clone
		 *
		 * Disable class cloning.
		 *
		 * @since 1.7.0
		 *
		 * @access protected
		 *
		 * @return void
		 */
		public function __clone() {
			// Cloning instances of the class is forbidden
			_doing_it_wrong( __FUNCTION__, esc_html__( 'Cheatin&#8217; huh?', 'appart-core' ), '1.7.0' );
		}

		/**
		 * Wakeup
		 *
		 * Disable unserializing the class.
		 *
		 * @since 1.7.0
		 *
		 * @access protected
		 *
		 * @return void
		 */
		public function __wakeup() {
			// Unserializing instances of the class is forbidden.
			_doing_it_wrong( __FUNCTION__, esc_html__( 'Cheatin&#8217; huh?', 'appart-core' ), '1.7.0' );
		}

		/**
		 * Constructor
		 *
		 * Initialize the Appart Core plugins.
		 *
		 * @since 1.7.0
		 *
		 * @access public
		 */
		public function __construct() {
			$this->core_includes();
			$this->init_hooks();
			do_action( 'appart_core_loaded' );
		}

		/**
		 * Include Files
		 *
		 * Load core files required to run the plugin.
		 *
		 * @since 1.7.0
		 *
		 * @access public
		 */
		public function core_includes() {
			// Extra functions
			require_once __DIR__ . '/inc/extra.php';
			// Elementor custom fields icon
			require_once __DIR__ . '/fields/icons.php';
			require_once __DIR__ . '/fields/include_icons.php';
			// Twitter widget
			require_once  __DIR__ . '/widgets/twitter/twitter-widget.php';

			// Appart widget
			require_once  __DIR__ . '/inc/appart-widgets.php';
		}

		/**
		 * Init Hooks
		 *
		 * Hook into actions and filters.
		 *
		 * @since 1.7.0
		 *
		 * @access private
		 */
		private function init_hooks() {
			add_action( 'init', [ $this, 'i18n' ] );
			add_action( 'plugins_loaded', [ $this, 'init' ] );
		}

		/**
		 * Load Textdomain
		 *
		 * Load plugin localization files.
		 *
		 * @since 1.7.0
		 *
		 * @access public
		 */
		public function i18n() {
			load_plugin_textdomain( 'appart-core', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );
		}

		/**
		 * Init Appart Core
		 *
		 * Load the plugin after Elementor (and other plugins) are loaded.
		 *
		 * @since 1.0.0
		 * @since 1.7.0 The logic moved from a standalone function to this class method.
		 *
		 * @access public
		 */
		public function init() {

			if ( !did_action( 'elementor/loaded' ) ) {
				add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
				return;
			}

			// Check for required Elementor version

			if ( !version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
				add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
				return;
			}

			// Check for required PHP version

			if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
				add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
				return;
			}

			// Add new Elementor Categories
			add_action( 'elementor/init', [ $this, 'add_elementor_category' ] );

			// Register Widget Scripts
			add_action( 'elementor/frontend/after_register_scripts', [ $this, 'register_widget_scripts' ] );
            add_action( 'elementor/editor/before_enqueue_scripts', [ $this, 'register_widget_scripts' ] );

			// Register Widget Styles
			add_action( 'admin_enqueue_scripts', [ $this, 'register_admin_styles' ] );
			add_action( 'elementor/frontend/after_enqueue_styles', [ $this, 'register_widget_styles' ] );
			add_action( 'elementor/frontend/after_register_styles', [ $this, 'register_widget_styles' ] );

			// Register New Widgets
			add_action( 'elementor/widgets/widgets_registered', [ $this, 'on_widgets_registered' ] );
		}

		/**
		 * Admin notice
		 *
		 * Warning when the site doesn't have Elementor installed or activated.
		 *
		 * @since 1.1.0
		 * @since 1.7.0 Moved from a standalone function to a class method.
		 *
		 * @access public
		 */
		public function admin_notice_missing_main_plugin() {
			$message = sprintf(
			/* translators: 1: Appart Core 2: Elementor */
				esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'appart-core' ),
				'<strong>' . esc_html__( 'Appart core', 'appart-core' ) . '</strong>',
				'<strong>' . esc_html__( 'Elementor', 'appart-core' ) . '</strong>'
			);
			printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
		}

		/**
		 * Admin notice
		 *
		 * Warning when the site doesn't have a minimum required Elementor version.
		 *
		 * @since 1.1.0
		 * @since 1.7.0 Moved from a standalone function to a class method.
		 *
		 * @access public
		 */
		public function admin_notice_minimum_elementor_version() {
			$message = sprintf(
			/* translators: 1: Appart Core 2: Elementor 3: Required Elementor version */
				esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'appart-core' ),
				'<strong>' . esc_html__( 'Appart Core', 'appart-core' ) . '</strong>',
				'<strong>' . esc_html__( 'Elementor', 'appart-core' ) . '</strong>',
				self::MINIMUM_ELEMENTOR_VERSION
			);
			printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
		}

		/**
		 * Admin notice
		 *
		 * Warning when the site doesn't have a minimum required PHP version.
		 *
		 * @access public
		 */
		public function admin_notice_minimum_php_version() {
			$message = sprintf(
			/* translators: 1: Appart Core 2: PHP 3: Required PHP version */
				esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'appart-core' ),
				'<strong>' . esc_html__( 'Appart Core', 'appart-core' ) . '</strong>',
				'<strong>' . esc_html__( 'PHP', 'appart-core' ) . '</strong>',
				self::MINIMUM_PHP_VERSION
			);
			printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
		}

		/**
		 * Add new Elementor Categories
		 *
		 * Register new widget categories for Appart Core widgets.
		 *
		 * @access public
		 */
		public function add_elementor_category() {
			\Elementor\Plugin::instance()->elements_manager->add_category( 'appart-elements', [
				'title' => __( 'Appart Elements', 'appart-core' ),
			], 1 );
		}

		/**
		 * Register Widget Scripts
		 *
		 * Register custom scripts required to run Appart Core.
		 *
		 * @access public
		 */
		public function register_widget_scripts() {
			wp_enqueue_script( 'appart-core', plugins_url('assets/js/appart-core.js', __FILE__), array( 'jquery' ), '1.0', true );
		}

		/**
		 * Register Widget Styles
		 *
		 * Register custom styles required to run Appart Core.
		 *
		 * @access public
		 */
		public function register_widget_styles() {
			// Typing Effect
			wp_enqueue_style( 'themify-icon', plugins_url( 'assets/fonts/themify-icon/themify-icons.css', __FILE__ ) );
			wp_enqueue_style( 'appart-elementor-edit', plugins_url( 'assets/css/elementor-edit.css', __FILE__ ) );
		}


		/**
		 * Register Admin Styles
		 *
		 * Register custom styles required to AppArt WordPress Admin Dashboard.
		 *
		 * @access public
		 */
		public function register_admin_styles() {
            wp_enqueue_style( 'appart-admin', plugins_url( 'assets/css/appart-core-admin.css', __FILE__ ) );
		}

		/**
		 * Register New Widgets
		 *
		 * Include Appart Core widgets files and register them in Elementor.
		 *
		 * @since 1.0.0
		 * @since 1.7.1 The method moved to this class.
		 *
		 * @access public
		 */
		public function on_widgets_registered() {
			$this->include_widgets();
			$this->register_widgets();
		}

		/**
		 * Include Widgets Files
		 *
		 * Load Appart Core widgets files.
		 *
		 * @since 1.0.0
		 * @since 1.7.1 The method moved to this class.
		 *
		 * @access private
		 */
		private function include_widgets() {
			require_once __DIR__ . '/widgets/Appart_hero.php';
			require_once __DIR__ . '/widgets/Appart_features.php';
			require_once __DIR__ . '/widgets/Appart_screen_features.php';
			require_once __DIR__ . '/widgets/Appart_screens_features.php';
			require_once __DIR__ . '/widgets/Appart_single_video.php';
			require_once __DIR__ . '/widgets/Appart_call2action.php';
			require_once __DIR__ . '/widgets/Appart_targeted_screen_features.php';
			require_once __DIR__ . '/widgets/Appart_pricing_table.php';
			require_once __DIR__ . '/widgets/Appart_download_buttons.php';
			require_once __DIR__ . '/widgets/Appart_download_sec2.php';
			require_once __DIR__ . '/widgets/Appart_testimonials.php';
			require_once __DIR__ . '/widgets/Appart_app_info.php';
			require_once __DIR__ . '/widgets/Appart_subscribe.php';
			require_once __DIR__ . '/widgets/Appart_tab.php';
			require_once __DIR__ . '/widgets/Appart_team.php';
			require_once __DIR__ . '/widgets/Appart_screenshots.php';
			require_once __DIR__ . '/widgets/Appart_interactive_screens.php';
			require_once __DIR__ . '/widgets/Appart_logo_carousel.php';
			require_once __DIR__ . '/widgets/Appart_parallax_hero.php';
			require_once __DIR__ . '/widgets/Appart_single_info_with_icon.php';

			if(class_exists('WooCommerce')) {
                require_once __DIR__ . '/widgets/Appart_shop_categories.php';
                require_once __DIR__ . '/widgets/Appart_products.php';
            }
		}

		/**
		 * Register Widgets
		 *
		 * Register Appart Core widgets.
		 *
		 * @since 1.0.0
		 * @since 1.7.1 The method moved to this class.
		 *
		 * @access private
		 */
		private function register_widgets() {
			// Site Elements
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \AppartCore\Widgets\Appart_hero() );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \AppartCore\Widgets\Appart_features() );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \AppartCore\Widgets\Appart_screen_features() );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \AppartCore\Widgets\Appart_screens_features() );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \AppartCore\Widgets\Appart_single_video() );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \AppartCore\Widgets\Appart_call2action() );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \AppartCore\Widgets\Appart_targeted_screen_features() );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \AppartCore\Widgets\Appart_pricing_table() );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \AppartCore\Widgets\Appart_download_buttons() );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \AppartCore\Widgets\Appart_download_sec2() );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \AppartCore\Widgets\Appart_testimonials() );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \AppartCore\Widgets\Appart_app_info() );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \AppartCore\Widgets\Appart_subscribe() );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \AppartCore\Widgets\Appart_tab() );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \AppartCore\Widgets\Appart_team() );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \AppartCore\Widgets\Appart_screenshots() );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \AppartCore\Widgets\Appart_interactive_screens() );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \AppartCore\Widgets\Appart_logo_carousel() );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \AppartCore\Widgets\Appart_parallax_hero() );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \AppartCore\Widgets\Appart_single_info_with_icon() );

			if(class_exists('WooCommerce')) {
                \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \AppartCore\Widgets\Appart_shop_categories() );
                \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \AppartCore\Widgets\Appart_products() );
            }
		}

	}
}
// Make sure the same function is not loaded twice in free/premium versions.

if ( !function_exists( 'appart_core_load' ) ) {
	/**
	 * Load Appart Core
	 *
	 * Main instance of Press_Elements.
	 *
	 * @since 1.0.0
	 * @since 1.7.0 The logic moved from this function to a class method.
	 */
	function appart_core_load() {
		return Appart_core::instance();
	}

	// Run Appart Core
	appart_core_load();
}


add_action( 'wp_enqueue_scripts', function() {
	wp_dequeue_style('elementor-global');
});
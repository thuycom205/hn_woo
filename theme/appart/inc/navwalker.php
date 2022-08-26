<?php
/**
 * WP Bootstrap Navwalker
 *
 * @package WP-Bootstrap-Navwalker
 */

class Appart_Nav_Navwalker extends Walker_Nav_Menu {

	/**
	 * Start Level.
	 *
	 * @see Walker::start_lvl()
	 * @since 3.0.0
	 *
	 * @access public
	 * @param mixed $output Passed by reference. Used to append additional content.
	 * @param int   $depth (default: 0) Depth of page. Used for padding.
	 * @param array $args (default: array()) Arguments.
	 * @return void
	 */
	public function start_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat( "\t", $depth );
		if($depth==0) {
			$output .= "\n$indent<ul class=\" sub-menu dropdown-menu\" >\n";
		}elseif($depth==1) {
			$output .= "\n$indent<ul class=\" dropdown-menu sub-menu\" >\n";
		}
	}

	/**
	 * Start El.
	 *
	 * @see Walker::start_el()
	 * @since 3.0.0
	 *
	 * @access public
	 * @param mixed $output Passed by reference. Used to append additional content.
	 * @param mixed $item Menu item data object.
	 * @param int   $depth (default: 0) Depth of menu item. Used for padding.
	 * @param array $args (default: array()) Arguments.
	 * @param int   $id (default: 0) Menu item ID.
	 * @return void
	 */
	function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
		$url = $item->url;
		$url_hash = strpos($url, '#');

		global $wp_query;
		$indent = ( $depth > 0 ? str_repeat("\t", $depth) : '' ); // code indent
		// Depth-dependent classes.
		$depth_classes = array(
			( $depth == 0 ? 'main-menu-item nav-item' : 'sub-menu-item' ),
			( $depth >= 2 ? 'sub-sub-menu-item' : '' ),
			( $depth % 2 ? 'menu-item-odd' : 'menu-item-even' ),
			'menu-item-depth-' . $depth
		);
		$depth_class_names = esc_attr(implode(' ', $depth_classes));

		// Passed classes.
		$classes = empty($item->classes) ? array() : (array) $item->classes;
		$class_names = esc_attr(implode(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item)));

		// Build HTML.
		$output .= $indent . '<li id="nav-menu-item-' . $item->ID . '" class="' . $depth_class_names . ' ' . $class_names . '">';

		// Link attributes.
		$attributes = !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
		$attributes .= !empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
		$attributes .= !empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';

		if ($url_hash === 0) {
			if (is_front_page()) {
				$attributes .= !empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';
			} else {
				$attributes .= !empty($item->url) ? ' href="' . home_url() . esc_attr($item->url) . '"' : '';
			}
		} else {
			$attributes .= !empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';
		}
		$attributes .= ' class="page-scroll ' . ( $depth > 0 ? 'sub-menu-link' : 'main-menu-link nav-link' ) . '"';

		$before = isset($args->before) ? $args->before : '';
		$link_before = isset($args->link_before) ? $args->link_before : '';
		$after = isset($args->after) ? $args->after : '';
		$link_after = isset($args->link_after) ? $args->link_after : '';
		// Build HTML output and pass through the proper filter.
		$item_output = sprintf('%1$s<a%2$s>%3$s%4$s%5$s</a>%6$s', $before, $attributes, $link_before, apply_filters('the_title', $item->title, $item->ID), $link_after, $after
		);
		$output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
	}

	/**
	 * Traverse elements to create list from elements.
	 *
	 * Display one element if the element doesn't have any children otherwise,
	 * display the element and its children. Will only traverse up to the max
	 * depth and no ignore elements under that depth.
	 *
	 * This method shouldn't be called directly, use the walk() method instead.
	 *
	 * @see Walker::start_el()
	 * @since 2.5.0
	 *
	 * @access public
	 * @param mixed $element Data object.
	 * @param mixed $children_elements List of elements to continue traversing.
	 * @param mixed $max_depth Max depth to traverse.
	 * @param mixed $depth Depth of current element.
	 * @param mixed $args Arguments.
	 * @param mixed $output Passed by reference. Used to append additional content.
	 * @return null Null on failure with no changes to parameters.
	 */
	public function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {
		if ( ! $element ) {
			return; }
		$id_field = $this->db_fields['id'];
		// Display this element.
		if ( is_object( $args[0] ) ) {
			$args[0]->has_children = ! empty( $children_elements[ $element->$id_field ] ); }
		parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
	}

	/**
	 * Menu Fallback
	 * =============
	 * If this function is assigned to the wp_nav_menu's fallback_cb variable
	 * and a menu has not been assigned to the theme location in the WordPress
	 * menu manager the function with display nothing to a non-logged in user,
	 * and will add a link to the WordPress menu manager if logged in as an admin.
	 *
	 * @param array $args passed from the wp_nav_menu function.
	 */
	public static function fallback( $args ) {
		if ( current_user_can( 'edit_theme_options' ) ) {

			/* Get Arguments. */
			$container = $args['container'];
			$container_id = $args['container_id'];
			$container_class = $args['container_class'];
			$menu_class = $args['menu_class'];
			$menu_id = $args['menu_id'];

			if ( $container ) {
				echo '<' . esc_attr( $container );
				if ( $container_id ) {
					echo ' id="' . esc_attr( $container_id ) . '"';
				}
				if ( $container_class ) {
					echo ' class="' . sanitize_html_class( $container_class ) . '"'; }
				echo '>';
			}
			echo '<ul';
			if ( $menu_id ) {
				echo ' id="' . esc_attr( $menu_id ) . '"'; }
			if ( $menu_class ) {
				echo ' class="' . esc_attr( $menu_class ) . '"'; }
			echo '>';
			echo '<li><a href="' . esc_url( admin_url( 'nav-menus.php' ) ) . '">' . esc_html__( 'Add a menu', 'appart' ) . '</a></li>';
			echo '</ul>';
			if ( $container ) {
				echo '</' . esc_attr( $container ) . '>';
			}
		}
	}
}

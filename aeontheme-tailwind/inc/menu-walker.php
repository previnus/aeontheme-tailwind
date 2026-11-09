<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function aeon_fallback_menu( $args ) {
	$mobile = 'mobile-nav__list' === $args['menu_class'];
	$link_class = $mobile ? 'mobile-nav__link' : 'site-nav__link';
	$item_class = $mobile ? 'mobile-nav__item' : 'site-nav__item';
	$pages = get_pages( array( 'parent' => 0, 'sort_column' => 'menu_order,post_title', 'number' => 6 ) );

	echo '<ul class="' . esc_attr( $args['menu_class'] ) . '">';
	echo '<li class="' . esc_attr( $item_class ) . '"><a class="' . esc_attr( $link_class ) . '" href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Home', 'aeon-theme' ) . '</a></li>';
	foreach ( $pages as $page ) {
		if ( (int) $page->ID === (int) get_option( 'page_on_front' ) ) {
			continue;
		}
		echo '<li class="' . esc_attr( $item_class ) . '"><a class="' . esc_attr( $link_class ) . '" href="' . esc_url( get_permalink( $page ) ) . '">' . esc_html( get_the_title( $page ) ) . '</a></li>';
	}
	echo '</ul>';
}

function aeon_mega_menu_groups() {
	static $groups;
	if ( isset( $groups ) ) {
		return $groups;
	}

	$groups = array();
	$locations = get_nav_menu_locations();
	foreach ( array( 'mega_menu', 'mega_menu_product' ) as $location ) {
		if ( empty( $locations[ $location ] ) ) {
			continue;
		}
		$items = wp_get_nav_menu_items( $locations[ $location ] ) ?: array();
		$children = array();
		foreach ( $items as $item ) {
			$children[ (int) $item->menu_item_parent ][] = $item;
		}
		$groups = array_merge( $groups, aeon_menu_tree( $children ) );
	}
	return $groups;
}

function aeon_menu_tree( $items, $parent = 0 ) {
	$tree = array();
	foreach ( $items[ $parent ] ?? array() as $item ) {
		$tree[] = array(
			'title'    => $item->title,
			'url'      => $item->url,
			'children' => aeon_menu_tree( $items, (int) $item->ID ),
		);
	}
	return $tree;
}

function aeon_mega_menu_list( $items, $mobile, $depth = 0 ) {
	if ( ! $items ) {
		return '';
	}

	$list_class = $mobile ? 'mobile-nav__sub' : ( $depth ? 'nav-mega__list' : 'nav-mega__pane-grid' );
	$html = '<ul class="' . esc_attr( $list_class ) . '">';
	foreach ( $items as $item ) {
		$link = aeon_mega_nav_link( $item['url'], $item['title'], $mobile ? 'mobile-nav__sub-link' : 'nav-mega__link' );
		if ( $mobile && $item['children'] ) {
			$html .= '<li class="mobile-nav__item mobile-nav__item--nested"><div class="mobile-nav__row mobile-nav__row--nested">' . $link . aeon_submenu_toggle( $item['title'] ) . '</div>';
		} else {
			$html .= '<li>' . $link;
		}
		$html .= aeon_mega_menu_list( $item['children'], $mobile, $depth + 1 ) . '</li>';
	}
	return $html . '</ul>';
}

function aeon_menu_caret() {
	return '<svg width="9" height="6" viewBox="0 0 9 6" aria-hidden="true" focusable="false"><path d="M1 1l3.5 4L8 1" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>';
}

function aeon_submenu_toggle( $title ) {
	return '<button type="button" class="mobile-nav__sub-toggle js-mobile-sub-toggle" aria-expanded="false" aria-label="' .
		esc_attr( sprintf( __( 'Toggle %s submenu', 'aeon-theme' ), $title ) ) . '">' . aeon_menu_caret() . '</button>';
}

class Aeon_Menu_Walker extends Walker_Nav_Menu {
	public function start_lvl( &$output, $depth = 0, $args = null ) {
		$output .= '<ul class="site-nav__dropdown">';
	}

	public function start_el( &$output, $data_object, $depth = 0, $args = null, $current_object_id = 0 ) {
		$item = $data_object;
		$mega = 0 === $depth && 'secondary_menu' === $args->theme_location &&
			in_array( 'menu-item-has-mega', $item->classes, true ) && aeon_mega_menu_groups();
		$dropdown = $this->has_children && ! $mega;
		$classes = 'site-nav__item' . ( $dropdown ? ' js-has-dropdown' : '' );
		if ( $item->current || $item->current_item_ancestor ) {
			$classes .= ' current-menu-item';
		}

		$link_class = $depth ? 'site-nav__dropdown-link' : 'site-nav__link';
		if ( $mega ) {
			$link_class .= ' js-mega-trigger';
		}

		$output .= '<li class="' . esc_attr( $classes ) . '"><a class="' . esc_attr( $link_class ) . '" href="' . esc_url( $item->url ) . '"';
		if ( $item->current ) {
			$output .= ' aria-current="page"';
		}
		if ( $mega || $dropdown ) {
			$output .= ' aria-expanded="false"';
		}
		if ( $mega ) {
			$output .= ' aria-controls="aeon-mega-menu"';
		}
		$output .= '>' . esc_html( $item->title ) . ( $mega || $dropdown ? aeon_menu_caret() : '' ) . '</a>';
	}
}

class Aeon_Mobile_Menu_Walker extends Walker_Nav_Menu {
	public function start_lvl( &$output, $depth = 0, $args = null ) {
		$output .= '<ul class="mobile-nav__sub">';
	}

	public function start_el( &$output, $data_object, $depth = 0, $args = null, $current_object_id = 0 ) {
		$item = $data_object;
		$groups = 0 === $depth && ! $this->has_children && in_array( 'menu-item-has-mega', $item->classes, true ) ? aeon_mega_menu_groups() : array();
		$has_children = $this->has_children || $groups;
		$link = aeon_mega_nav_link( $item->url, $item->title, $depth ? 'mobile-nav__sub-link' : 'mobile-nav__link' );
		$output .= $depth ? '<li class="mobile-nav__item mobile-nav__item--nested">' : '<li class="mobile-nav__item">';
		$output .= $has_children ? '<div class="mobile-nav__row">' . $link . aeon_submenu_toggle( $item->title ) . '</div>' : $link;
		$output .= aeon_mega_menu_list( $groups, true );
	}
}

class Aeon_Footer_Menu_Walker extends Walker_Nav_Menu {
	public function start_el( &$output, $data_object, $depth = 0, $args = null, $current_object_id = 0 ) {
		$output .= '<li>' . aeon_mega_nav_link( $data_object->url, $data_object->title, 'site-footer__link' );
	}
}

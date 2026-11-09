<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function aeon_field( $name, $post_id = false ) {
	if ( ! function_exists( 'get_field' ) ) {
		return null;
	}

	// Prefer the stored reference, including field definitions from an existing site.
	$field = acf_maybe_get_field( $name, $post_id );
	if ( ! $field ) {
		$key = 'page_builder' === $name ? 'field_aeon_page_builder' : 'field_aeon_' . ( 'option' === $post_id ? 'options_' : 'blog_' ) . $name;
		$field = acf_get_field( $key ) ?: acf_get_field( $name );
	}

	return $field ? get_field( $field['key'], $post_id ) : null;
}

function aeon_option( $name, $default = '' ) {
	$value = aeon_field( $name, 'option' );
	if ( is_array( $default ) ) {
		return aeon_rows( $value ) ?: $default;
	}
	if ( is_int( $default ) ) {
		$value = is_array( $value ) ? ( $value['ID'] ?? null ) : $value;
		$id = filter_var( $value, FILTER_VALIDATE_INT, array( 'options' => array( 'min_range' => 1 ) ) );
		return false === $id ? $default : $id;
	}
	return is_scalar( $value ) && '' !== (string) $value ? (string) $value : $default;
}

function aeon_rows( $value ) {
	return is_array( $value ) ? array_values( array_filter( $value, 'is_array' ) ) : array();
}

function aeon_section_id( $base ) {
	static $used = array(
		'main' => true,
		'mobile-nav' => true,
		'aeon-mega-menu' => true,
	);
	$base = rawurldecode( sanitize_title( $base ) );
	if ( ! preg_match( '/\A[^\s\p{Cc}]+\z/u', $base ) ) {
		$base = 'section';
	}
	$id = $base;
	for ( $number = 2; isset( $used[ $id ] ); $number++ ) {
		$id = $base . '-' . $number;
	}
	$used[ $id ] = true;
	return $id;
}

function aeon_logo( $image_id, $class ) {
	$name = get_bloginfo( 'name' );
	$image_id = $image_id ?: get_theme_mod( 'custom_logo' );
	$image = $image_id ? wp_get_attachment_image( $image_id, 'medium', false, array(
		'class' => $class,
		'alt'   => $name,
	) ) : '';

	return $image ?: '<span class="aeon-wordmark ' . esc_attr( $class ) . '">' . esc_html( $name ) . '</span>';
}

function aeon_arrow_icon() {
	return '<svg width="18" height="9" viewBox="0 0 18 9" aria-hidden="true" focusable="false"><path d="M0 4.5h16M12 1l4 3.5L12 8" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>';
}

function aeon_render_shortcode( $value ) {
	if ( ! is_string( $value ) ) {
		return '';
	}

	$value = trim( $value );
	if ( ! preg_match( '/^\[([\w-]+)(?=[\s\/\]])/', $value, $matches ) || ! shortcode_exists( $matches[1] ) ) {
		return '';
	}

	// A dedicated shortcode field accepts one registered, self-contained embed.
	$pattern = get_shortcode_regex( array( $matches[1] ) );
	if ( ! preg_match( '/\A' . $pattern . '\z/s', $value, $parts ) || ! empty( $parts[5] ) ) {
		return '';
	}

	$output = do_shortcode( $value, true );
	return $value === $output ? '' : $output;
}

function aeon_modal_settings() {
	static $settings;
	if ( isset( $settings ) ) {
		return $settings;
	}

	$settings = array(
		'quote' => array(
			'shortcode' => aeon_option( 'quote_form_shortcode' ),
			'title'     => aeon_option( 'quote_modal_title', __( 'Request a quote', 'aeon-theme' ) ),
			'text'      => aeon_option( 'quote_modal_text' ),
		),
		'financing' => array(
			'shortcode' => aeon_option( 'financing_form_shortcode' ),
			'title'     => __( 'Ask about financing', 'aeon-theme' ),
			'text'      => '',
		),
		'product' => array(
			'shortcode' => aeon_option( 'product_form_shortcode' ),
			'title'     => __( 'Request a product quote', 'aeon-theme' ),
			'text'      => '',
		),
		'newsletter' => array(
			'shortcode' => aeon_option( 'newsletter_form_shortcode' ),
			'title'     => __( 'Subscribe to the newsletter', 'aeon-theme' ),
			'text'      => '',
		),
	);
	return $settings;
}

function aeon_modal_form( $type ) {
	static $forms = array();
	if ( ! array_key_exists( $type, $forms ) ) {
		$settings = aeon_modal_settings();
		$forms[ $type ] = aeon_render_shortcode( $settings[ $type ]['shortcode'] ?? '' );
	}
	return $forms[ $type ];
}

function aeon_contact_action( $label, $context = '', $class = 'btn btn--primary btn--wide', $type = 'quote', $product = '' ) {
	if ( ! $label ) {
		return '';
	}

	if ( 'quote' === $type && 'financing-page' === $context ) {
		$type = 'financing';
	}
	if ( 'quote' !== $type && ! aeon_modal_form( $type ) ) {
		$type = 'quote';
	}

	$content = esc_html( $label ) . aeon_arrow_icon();
	if ( aeon_modal_form( $type ) ) {
		return sprintf(
			'<button type="button" class="%s js-aeon-modal-open" data-modal="%s" data-quote-context="%s" data-product="%s" aria-haspopup="dialog" aria-controls="aeon-modal-%s">%s</button>',
			esc_attr( $class ),
			esc_attr( $type ),
			esc_attr( $context ),
			esc_attr( $product ),
			esc_attr( $type ),
			$content
		);
	}

	$url = esc_url( aeon_option( 'header_cta_url' ) );
	return $url ? '<a class="' . esc_attr( $class ) . '" href="' . $url . '">' . $content . '</a>' : '';
}

function aeon_blog_url() {
	$url = esc_url( aeon_option( 'blog_url' ) );
	if ( $url ) {
		return $url;
	}

	$blog = get_page_by_path( 'blog' );
	if ( $blog && 'publish' === $blog->post_status && 'template-blog.php' === get_page_template_slug( $blog ) ) {
		return get_permalink( $blog );
	}

	$posts_page = (int) get_option( 'page_for_posts' );
	return $posts_page && 'publish' === get_post_status( $posts_page ) ? get_permalink( $posts_page ) : home_url( '/' );
}

function aeon_mega_nav_link( $url, $label, $class ) {
	$url = esc_url( $url );
	if ( '#' === $url || '' === $url ) {
		return '<span class="' . esc_attr( $class ) . ' is-pending">' . esc_html( $label ) . '</span>';
	}
	return '<a class="' . esc_attr( $class ) . '" href="' . $url . '">' . esc_html( $label ) . '</a>';
}

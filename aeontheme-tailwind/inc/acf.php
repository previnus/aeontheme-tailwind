<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function aeon_has_acf_pro() {
	return function_exists( 'acf_add_options_page' ) && acf_get_field_type( 'flexible_content' ) && acf_get_field_type( 'repeater' );
}

function aeon_register_acf() {
	if ( ! aeon_has_acf_pro() ) {
		return;
	}

	// Keep the existing slug and default options storage for installed sites.
	acf_add_options_page( array(
		'page_title' => __( 'Aeon Theme Options', 'aeon-theme' ),
		'menu_title' => __( 'Aeon Theme Options', 'aeon-theme' ),
		'menu_slug'  => 'theme-options',
		'capability' => 'manage_options',
		'redirect'   => false,
	) );

	require_once __DIR__ . '/acf-fields.php';

	$legacy_keys = array();
	$page_location = array( 'param' => 'post_type', 'operator' => '==', 'value' => 'page' );
	$builder = acf_get_field( 'page_builder' );
	if ( ! $builder || 'flexible_content' !== $builder['type'] ) {
		aeon_acf_group( 'page_builder', __( 'Aeon Page Builder', 'aeon-theme' ), array( aeon_acf_builder() ), array( $page_location, array(
			'param' => 'page_template', 'operator' => '!=', 'value' => 'template-blog.php',
		) ) );
	} else {
		aeon_register_legacy_fields( array( $builder ), $legacy_keys );
	}

	$existing_options = array();
	foreach ( acf_get_field_groups( array( 'options_page' => 'theme-options' ) ) as $group ) {
		$fields = acf_get_fields( $group ) ?: array();
		$existing_options = array_merge( $existing_options, array_column( $fields, 'name' ) );
		aeon_register_legacy_fields( $fields, $legacy_keys );
	}
	aeon_acf_group( 'options', __( 'Aeon Site Settings', 'aeon-theme' ), aeon_acf_options( $existing_options ), array(
		array( 'param' => 'options_page', 'operator' => '==', 'value' => 'theme-options' ),
	) );
	add_filter( 'acf/prepare_field/key=field_aeon_options_favicon', '__return_false' );

	$blog_fields = aeon_acf_fields( 'blog', array( 'blog_hero_title', 'blog_hero_title_accent', 'blog_hero_lead' => 'textarea' ) );
	$blog_fields = array_filter( $blog_fields, static function ( $field ) use ( &$legacy_keys ) {
		$existing = acf_get_field( $field['name'] );
		if ( $existing ) {
			aeon_register_legacy_fields( array( $existing ), $legacy_keys );
		}
		return ! $existing;
	} );
	aeon_acf_group( 'blog', __( 'Blog Archive Header', 'aeon-theme' ), array_values( $blog_fields ), array(
		array( 'param' => 'page_template', 'operator' => '==', 'value' => 'template-blog.php' ),
	) );

	// Validate the stored shape before ACF expands repeaters or formats rich text.
	add_filter( 'acf/load_value', static function ( $value, $post_id, $field ) use ( $legacy_keys ) {
		$key = $field['key'] ?? '';
		return isset( $legacy_keys[ $key ] ) || 0 === strpos( $key, 'field_aeon_' )
			? aeon_validate_loaded_value( $value, $field )
			: $value;
	}, 1, 3 );
}
add_action( 'acf/init', 'aeon_register_acf', 20 );

function aeon_acf_admin_notice() {
	if ( current_user_can( 'manage_options' ) && ! aeon_has_acf_pro() ) {
		echo '<div class="notice notice-info"><p>' . esc_html__( 'Install and activate ACF PRO to enable the Aeon Page Builder and theme options. Standard WordPress content remains available.', 'aeon-theme' ) . '</p></div>';
	}
}
add_action( 'admin_notices', 'aeon_acf_admin_notice' );

function aeon_acf_picker_style() {
	$screen = get_current_screen();
	if ( aeon_has_acf_pro() && $screen && 'post' === $screen->base && 'page' === $screen->post_type ) {
		echo '<style>.acf-fc-popup{max-height:65vh;overflow-y:auto}</style>';
	}
}
add_action( 'admin_head', 'aeon_acf_picker_style' );

/**
 * Older schema exports use the ACF URL type for links. Allow same-site paths
 * and fragments in those fields while leaving other field groups alone.
 */
function aeon_register_legacy_fields( $fields, &$keys ) {
	foreach ( $fields as $field ) {
		$keys[ $field['key'] ] = true;
		if ( 'url' === ( $field['type'] ?? '' ) ) {
			add_filter( 'acf/validate_value/key=' . $field['key'], 'aeon_validate_legacy_url', 10, 2 );
		}
		if ( ! empty( $field['sub_fields'] ) ) {
			aeon_register_legacy_fields( $field['sub_fields'], $keys );
		}
		foreach ( $field['layouts'] ?? array() as $layout ) {
			aeon_register_legacy_fields( $layout['sub_fields'] ?? array(), $keys );
		}
	}
}

function aeon_validate_loaded_value( $value, $field ) {
	switch ( $field['type'] ?? '' ) {
		case 'flexible_content':
			// Retain the saved indices, which ACF uses to find each row's metadata.
			return is_array( $value ) ? array_filter( $value, 'is_string' ) : ( is_string( $value ) ? $value : null );
		case 'repeater':
			$count = filter_var( $value, FILTER_VALIDATE_INT, array( 'options' => array( 'min_range' => 0, 'max_range' => 10000 ) ) );
			return false === $count ? null : $count;
		case 'image':
			$id = filter_var( $value, FILTER_VALIDATE_INT, array( 'options' => array( 'min_range' => 1 ) ) );
			return false === $id ? null : $id;
		case 'number':
			return is_numeric( $value ) && is_finite( (float) $value ) ? $value : null;
		case 'text':
		case 'textarea':
		case 'wysiwyg':
		case 'email':
		case 'url':
			return is_scalar( $value ) ? wp_check_invalid_utf8( (string) $value ) : null;
		case 'true_false':
			return is_scalar( $value ) ? $value : null;
		case 'select':
			return empty( $field['multiple'] ) && ! is_scalar( $value ) ? null : $value;
		default:
			return $value;
	}
}

function aeon_validate_legacy_url( $valid, $value ) {
	if ( is_string( $value ) && false === strpos( $value, chr( 92 ) )
		&& preg_match( '~\A(?:/(?!/)|#)[^\s\x00-\x1F]*\z~', $value ) && esc_url_raw( $value ) === $value ) {
		return true;
	}
	return $valid;
}

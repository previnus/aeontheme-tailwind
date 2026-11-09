<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Stable field keys, scoped by layout and parent repeater. Keep field and
 * layout names stable so the templates can read existing site content.
 */
function aeon_acf_fields( $prefix, $definitions ) {
	$fields = array();
	foreach ( $definitions as $name => $definition ) {
		if ( is_int( $name ) ) {
			$name = $definition;
			$definition = 'text';
		}

		$path = $prefix . '_' . $name;
		$field = array(
			'key'   => 'field_aeon_' . $path,
			'name'  => $name,
			'label' => ucwords( str_replace( '_', ' ', $name ) ),
		);

		if ( is_array( $definition ) && ! isset( $definition['type'] ) ) {
			$field['type'] = 'repeater';
			$field['layout'] = 'block';
			$field['sub_fields'] = aeon_acf_fields( $path, $definition );
		} elseif ( is_array( $definition ) ) {
			$field = array_replace( $field, $definition );
		} else {
			$field['type'] = 'shortcode' === $definition ? 'text' : $definition;
			if ( 'image' === $definition ) {
				$field['return_format'] = 'id';
			}
			if ( 'shortcode' === $definition ) {
				$field['instructions'] = __( 'Enter one shortcode from an active plugin.', 'aeon-theme' );
			} elseif ( 'link' === $name || preg_match( '/(?:^|_)url(?:_[0-9]+)?$/', $name ) ) {
				$field['instructions'] = __( 'Use a full URL, a site path starting with /, or an anchor starting with #.', 'aeon-theme' );
			}
		}
		$fields[] = $field;
	}
	return $fields;
}

function aeon_acf_group( $name, $title, $fields, $location ) {
	if ( $fields ) {
		acf_add_local_field_group( array(
			'key'      => 'group_aeon_' . $name,
			'title'    => $title,
			'fields'   => $fields,
			'location' => array( $location ),
		) );
	}
}

function aeon_acf_builder() {
	$heading = array( 'title', 'section_label', 'section_number' );
	$links = array( 'label', 'url' );
	$text_rows = array( 'text' => 'textarea' );
	$stats = array( 'figure', 'label' );
	$hero = array(
		'title', 'title_accent', 'lead' => 'textarea', 'image' => 'image',
		'primary_cta_label', 'primary_cta_context', 'secondary_cta_label', 'secondary_cta_url',
	);
	$definitions = array(
		'hero' => array( 'Hero', array_merge( $hero, array( 'stats' => $stats ) ) ),
		'page_hero' => array( 'Page Header', array_merge( $hero, array(
			'eyebrow', 'breadcrumb', 'breadcrumb_url', 'breadcrumb_url_2', 'breadcrumb_url_3',
			'trust_stats' => $stats, 'dark' => 'true_false', 'plain_layout' => 'true_false',
		) ) ),
		'page_stub' => array( 'Intro With List', array(
			'title', 'eyebrow', 'lead' => 'textarea', 'primary_cta_label', 'primary_cta_context',
			'secondary_cta_label', 'secondary_cta_url', 'items' => array( 'title', 'anchor', 'text' => 'textarea' ),
		) ),
		'intro_columns' => array( 'Intro Columns', array(
			'title', 'lead' => 'textarea', 'text' => 'wysiwyg', 'aside_title', 'aside_items' => $text_rows,
		) ),
		'two_column_content' => array( 'Two Column Content', array(
			'title', 'eyebrow', 'content' => 'wysiwyg', 'image' => 'image', 'cta_label', 'cta_url',
		) ),
		'split_media' => array( 'Split Media', array(
			'title', 'tag', 'image' => 'image', 'text' => 'textarea', 'list' => $text_rows, 'reverse' => 'true_false',
		) ),
		'audience_cards' => array( 'Audience Cards', array_merge( $heading, array(
			'anchor', 'cards' => array(
				'title', 'eyebrow', 'tag', 'image' => 'image', 'text' => 'textarea',
				'bullets' => $text_rows, 'cta_label', 'url', 'dark' => 'true_false',
			),
		) ) ),
		'cards_grid' => array( 'Cards Grid', array(
			'title', 'eyebrow', 'cards' => array( 'heading', 'text' => 'textarea', 'image' => 'image', 'link' ),
		) ),
		'feature_cards' => array( 'Feature Cards', array(
			'title', 'cards' => array( 'title', 'text' => 'textarea' ),
		) ),
		'why_grid' => array( 'Highlights Grid', array_merge( $heading, array(
			'cards' => array( 'title', 'number', 'text' => 'textarea', 'image' => 'image' ),
		) ) ),
		'believe' => array( 'Values', array_merge( $heading, array(
			'items' => array( 'title', 'text' => 'textarea' ),
		) ) ),
		'capability_list' => array( 'Capability List', array_merge( $heading, array(
			'aside_text' => 'textarea', 'items' => array( 'title', 'number', 'text' => 'textarea', 'bullets' => $text_rows ),
		) ) ),
		'checklist_block' => array( 'Checklist', array(
			'title', 'aside_text' => 'textarea', 'items' => array( 'title', 'text' => 'textarea' ),
		) ),
		'process' => array( 'Process Timeline', array(
			'title', 'eyebrow', 'steps' => array( 'title', 'phase', 'duration', 'text' => 'textarea' ),
		) ),
		'numbered_steps' => array( 'Numbered Steps', array(
			'title', 'steps' => array( 'title', 'num', 'text' => 'textarea' ),
		) ),
		'story' => array( 'Story', array_merge( $heading, array(
			'lead' => 'textarea', 'body' => 'wysiwyg', 'image' => 'image', 'image_caption',
			'quote' => 'textarea', 'aside_text' => 'textarea', 'milestones' => array( 'year', 'text' => 'textarea' ),
		) ) ),
		'build_rows' => array( 'Card Carousels', array_merge( $heading, array(
			'anchor', 'rows' => array(
				'label', 'cta_label', 'cta_url',
				'cards' => array( 'name', 'subtitle', 'image' => 'image', 'logo_image' => 'image', 'badge_text', 'url' ),
			),
			'callout_title', 'callout_eyebrow', 'callout_text' => 'textarea', 'callout_cta_label', 'callout_cta_url',
			'trades_label', 'trades' => $text_rows, 'trades_cta_label', 'trades_cta_url',
		) ) ),
		'build_gallery' => array( 'Filterable Gallery', array(
			'title', 'tiles' => array( 'title', 'image' => 'image', 'group', 'tag', 'meta' ),
		) ),
		'gallery' => array( 'Image Gallery', array_merge( $heading, array(
			'dark' => 'true_false', 'view_all_label', 'view_all_url',
			'images' => array( 'image' => 'image', 'label', 'code', 'url', 'wide' => 'true_false' ),
		) ) ),
		'related_links' => array( 'Related Links', array_merge( $heading, array(
			'view_all_label', 'view_all_url',
			'cards' => array( 'title', 'kicker', 'text' => 'textarea', 'link_label', 'image' => 'image', 'url' ),
		) ) ),
		'directory' => array( 'Link Directory', array(
			'title', 'anchor', 'count_text',
			'source' => array( 'type' => 'select', 'choices' => array( 'custom' => 'Custom links', 'locations' => 'Global locations', 'trades' => 'Global categories' ) ),
			'groups' => array( 'group_title', 'links' => $links ),
		) ),
		'taxonomy' => array( 'Category Cards', array_merge( $heading, array(
			'anchor', 'columns' => array( 'type' => 'select', 'choices' => array( 'two' => 'Two', 'three' => 'Three' ) ),
			'chips_are_links' => 'true_false',
			'cards' => array( 'title', 'code', 'image' => 'image', 'text' => 'textarea', 'url', 'chips' => $links ),
			'cta_title', 'cta_code', 'cta_text' => 'textarea', 'cta_label', 'cta_context',
		) ) ),
		'tiles_grid' => array( 'Link Tiles', array_merge( $heading, array(
			'anchor', 'aside_text' => 'textarea', 'three_column' => 'true_false', 'tiles' => array( 'code', 'label', 'url' ),
		) ) ),
		'service_split' => array( 'Service Columns', array_merge( $heading, array(
			'anchor', 'aside_text' => 'textarea', 'columns' => array(
				'title', 'tag', 'text' => 'textarea', 'rows' => $text_rows, 'cta_label', 'cta_context',
			),
		) ) ),
		'sectors' => array( 'Image With List', array_merge( $heading, array(
			'anchor', 'image' => 'image', 'image_title', 'image_kicker', 'rows' => array( 'title', 'types' ),
			'cta_title', 'cta_eyebrow', 'cta_muted', 'cta_label', 'cta_url',
		) ) ),
		'spec_grid' => array( 'Specification Cards', array_merge( $heading, array(
			'aside_text' => 'textarea', 'cards' => array(
				'name', 'tier', 'text' => 'textarea', 'specs' => array( 'label', 'value' ), 'cta_context',
			),
		) ) ),
		'oem_partnerships' => array( 'Tabbed Partnerships', array_merge( $heading, array(
			'hide_section' => 'true_false', 'partners' => array(
				'name', 'credential', 'meta', 'text' => 'textarea', 'status_label', 'is_certified' => 'true_false',
				'benefits' => array( 'title', 'text' => 'textarea' ),
				'platforms_label', 'platforms' => array( 'name', 'detail' ), 'cta_context', 'secondary_label', 'secondary_url',
			),
		) ) ),
		'financing' => array( 'Financing', array_merge( $heading, array(
			'banner_title', 'banner_tag', 'banner_text' => 'textarea', 'banner_image' => 'image',
			'intro_text' => 'textarea', 'points' => $text_rows, 'cta_label', 'cta_context', 'secondary_label', 'secondary_url',
		) ) ),
		'careers' => array( 'Careers', array_merge( $heading, array(
			'text' => 'textarea', 'roles' => array( 'title', 'meta', 'text' => 'textarea', 'url' ), 'cta_label', 'cta_url',
		) ) ),
		'visit' => array( 'Visit and Opening Hours', array_merge( $heading, array(
			'address' => 'textarea', 'aside_text' => 'textarea', 'image' => 'image', 'image_title', 'image_kicker',
			'hours' => array( 'day', 'time' ), 'directions_label', 'directions_url', 'maps_label',
		) ) ),
		'faq' => array( 'FAQ', array_merge( $heading, array(
			'anchor', 'items' => array( 'question', 'answer' => 'wysiwyg' ),
		) ) ),
		'reviews' => array( 'Reviews', array_merge( $heading, array(
			'score', 'score_suffix', 'score_note', 'stars' => array( 'type' => 'number', 'min' => 0, 'max' => 5 ),
			'items' => array( 'name', 'role', 'initials', 'tag', 'quote' => 'textarea' ), 'review_shortcode' => 'shortcode',
		) ) ),
		'seo_copy' => array( 'Expandable Content', array(
			'title', 'eyebrow', 'anchor', 'intro' => 'wysiwyg', 'reveal_content' => 'wysiwyg', 'facts' => array( 'label', 'value' ),
		) ),
		'contact_form_info' => array( 'Contact Form and Details', array(
			'form_title', 'form_eyebrow', 'contact_form_shortcode' => 'shortcode',
			'info_cards' => array(
				'label', 'value' => 'textarea', 'url', 'note',
				'icon_type' => array( 'type' => 'select', 'choices' => array( 'phone' => 'Phone', 'email' => 'Email', 'location' => 'Location', 'hours' => 'Hours' ) ),
			),
		) ),
		'final_cta' => array( 'Contact Section', array_merge( $heading, array(
			'text' => 'textarea', 'note_text', 'note_text_copy', 'form_title', 'form_eyebrow', 'contact_form_shortcode' => 'shortcode',
		) ) ),
		'cta_band' => array( 'Call to Action Band', array( 'title', 'text' => 'textarea', 'button_label', 'button_url' ) ),
		'cta_section' => array( 'Call to Action With Image', array( 'title', 'text' => 'textarea', 'cta_label', 'cta_url', 'image' => 'image' ) ),
		'consult_band' => array( 'Consultation Band', array(
			'title', 'eyebrow', 'text' => 'textarea', 'cta_label', 'cta_context', 'cta_url',
			'style' => array( 'type' => 'select', 'choices' => array( 'dark' => 'Dark', 'orange' => 'Accent', 'orange_split' => 'Accent Split', 'orange_strip' => 'Accent Strip' ) ),
		) ),
		'shop_band' => array( 'Image Banner', array( 'title', 'image' => 'image' ) ),
		'spacer' => array( 'Spacer', array( 'height' => array( 'type' => 'number', 'min' => 0, 'max' => 1000, 'append' => 'px' ) ) ),
	);

	$layouts = array();
	foreach ( $definitions as $name => list( $label, $fields ) ) {
		$key = 'layout_aeon_' . $name;
		$layouts[ $key ] = array(
			'key'        => $key,
			'name'       => $name,
			'label'      => $label,
			'display'    => 'block',
			'sub_fields' => aeon_acf_fields( $name, $fields ),
		);
	}
	return array(
		'key'          => 'field_aeon_page_builder',
		'name'         => 'page_builder',
		'label'        => __( 'Page Sections', 'aeon-theme' ),
		'type'         => 'flexible_content',
		'button_label' => __( 'Add Section', 'aeon-theme' ),
		'layouts'      => $layouts,
	);
}

function aeon_acf_options( $existing_options = array() ) {
	$directory = array( 'group_title', 'links' => array( 'label', 'url' ) );
	$sections = array(
		'branding' => array( __( 'Branding', 'aeon-theme' ), array(
			'site_logo' => array(
				'type' => 'image', 'return_format' => 'id', 'label' => __( 'Header Logo', 'aeon-theme' ),
				'instructions' => __( 'Used over dark hero sections. The WordPress logo or site title is the fallback.', 'aeon-theme' ),
			),
			'sticky_header_logo' => array(
				'type' => 'image', 'return_format' => 'id', 'label' => __( 'Logo on Light Headers', 'aeon-theme' ),
			),
			'mobile_logo' => 'image', 'footer_logo' => 'image',
			'default_banner_image' => array(
				'type' => 'image', 'return_format' => 'id', 'label' => __( 'Default Social Preview Image', 'aeon-theme' ),
			),
		) ),
		'header_footer' => array( __( 'Header & Footer', 'aeon-theme' ), array(
			'header_cta_label', 'header_cta_url', 'phone_number', 'email_address' => 'email', 'email_text',
			'business_address', 'business_address_note', 'footer_text' => 'textarea',
			'footer_menu_name', 'footer_menu_name_second', 'contact_text', 'social_media_text', 'copyright_text',
			'social_links' => array( 'network', 'label', 'url' ),
			'legal_links' => array( 'label', 'url', 'custom_url' ),
			'directory_locations' => $directory, 'directory_trades' => $directory,
		) ),
		'forms' => array( __( 'Forms', 'aeon-theme' ), array(
			'quote_modal_title', 'quote_modal_text' => 'textarea', 'quote_form_shortcode' => 'shortcode',
			'financing_form_shortcode' => 'shortcode', 'product_form_shortcode' => 'shortcode', 'newsletter_form_shortcode' => 'shortcode',
		) ),
		'blog' => array( __( 'Blog', 'aeon-theme' ), array(
			'blog_url', 'written_by_text', 'post_author_name', 'post_author_bio' => 'textarea', 'filed_under_text_label',
			'related_posts_heading', 'post_cta_title', 'post_cta_text' => 'textarea', 'post_cta_button_label', 'post_cta_button_url',
		) ),
	);

	$fields = array();
	foreach ( $sections as $section => list( $label, $definitions ) ) {
		$section_fields = array_filter( aeon_acf_fields( 'options', $definitions ), static function ( $field ) use ( $existing_options ) {
			return ! in_array( $field['name'], $existing_options, true );
		} );
		if ( ! $section_fields ) {
			continue;
		}
		$fields[] = array(
			'key'       => 'field_aeon_options_tab_' . $section,
			'name'      => '',
			'label'     => $label,
			'type'      => 'tab',
			'placement' => 'top',
		);
		$fields = array_merge( $fields, $section_fields );
	}

	// Keep the old field readable for existing sites. New sites use the WordPress Site Icon.
	if ( ! in_array( 'favicon', $existing_options, true ) ) {
		$fields = array_merge( $fields, aeon_acf_fields( 'options', array( 'favicon' => 'image' ) ) );
	}
	return $fields;
}

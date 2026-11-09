<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once __DIR__ . '/inc/helpers.php';
require_once __DIR__ . '/inc/acf.php';
require_once __DIR__ . '/inc/menu-walker.php';

function aeon_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'custom-logo', array(
		'height'      => 100,
		'width'       => 300,
		'flex-height' => true,
		'flex-width'  => true,
	) );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );

	add_image_size( 'aeon-hero', 1600, 1000, true );
	add_image_size( 'aeon-card', 800, 600, true );
	add_image_size( 'aeon-gallery', 1200, 900, true );

	register_nav_menus( array(
		'primary_menu'          => __( 'Primary Menu', 'aeon-theme' ),
		'secondary_menu'        => __( 'Secondary Menu', 'aeon-theme' ),
		'mobile_menu'           => __( 'Mobile Menu', 'aeon-theme' ),
		'footer_menu'           => __( 'Footer Menu', 'aeon-theme' ),
		'footer_resources_menu' => __( 'Footer Resources Menu', 'aeon-theme' ),
		'mega_menu'             => __( 'Mega Menu', 'aeon-theme' ),
		'mega_menu_product'     => __( 'Additional Mega Menu', 'aeon-theme' ),
	) );
}
add_action( 'after_setup_theme', 'aeon_setup' );

function aeon_enqueue_assets() {
	$version = wp_get_theme( get_template() )->get( 'Version' );

	wp_enqueue_style( 'aeon-main', get_theme_file_uri( '/css/main.css' ), array(), $version );
	wp_enqueue_style( 'aeon-theme', get_stylesheet_uri(), array( 'aeon-main' ), $version );
	wp_enqueue_script( 'aeon-site', get_theme_file_uri( '/js/site.js' ), array( 'jquery' ), $version, true );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) && ! post_password_required() ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'aeon_enqueue_assets' );

function aeon_favicon() {
	$image_id = aeon_option( 'favicon', 0 );
	if ( $image_id && ! has_site_icon() ) {
		$url = wp_get_attachment_image_url( $image_id, 'thumbnail' );
		if ( $url ) {
			echo '<link rel="icon" href="' . esc_url( $url ) . '">';
		}
	}
}
add_action( 'wp_head', 'aeon_favicon' );

function aeon_body_classes( $classes ) {
	if ( is_page() && ! post_password_required( get_queried_object_id() ) && ! is_page_template( 'template-blog.php' ) ) {
		$builder = aeon_get_page_builder( get_queried_object_id() );
		if ( 'hero' === ( $builder[0]['acf_fc_layout'] ?? '' ) ) {
			$classes[] = 'has-hero-header';
		}
	}

	return $classes;
}
add_filter( 'body_class', 'aeon_body_classes' );

function aeon_get_page_builder( $post_id = null ) {
	return aeon_rows( aeon_field( 'page_builder', $post_id ?: get_the_ID() ) );
}

function aeon_render_layout( $layout ) {
	$name = $layout['acf_fc_layout'] ?? '';
	if ( ! is_string( $name ) || ! preg_match( '/\A[a-z0-9_]+\z/', $name ) ) {
		return false;
	}

	return false !== get_template_part( 'template-parts/layouts/' . $name, null, array( 'layout' => $layout ) );
}

function aeon_social_metadata() {
	$singular = is_singular();
	$public_singular = $singular && ! post_password_required( get_queried_object_id() );
	$description = $public_singular
		? wp_strip_all_tags( get_the_excerpt( get_queried_object_id() ) )
		: get_bloginfo( 'description' );
	$image = $public_singular ? get_the_post_thumbnail_url( get_queried_object_id(), 'large' ) : '';
	if ( ! $image ) {
		$banner_id = aeon_option( 'default_banner_image', 0 );
		$image = $banner_id ? wp_get_attachment_image_url( $banner_id, 'large' ) : '';
	}
	?>
	<meta property="og:type" content="<?php echo is_singular( 'post' ) ? 'article' : 'website'; ?>">
	<meta property="og:site_name" content="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
	<meta property="og:title" content="<?php echo esc_attr( wp_get_document_title() ); ?>">
	<meta property="og:url" content="<?php echo esc_url( $singular ? get_permalink( get_queried_object_id() ) : get_pagenum_link() ); ?>">
	<?php if ( $description ) : ?><meta property="og:description" content="<?php echo esc_attr( $description ); ?>"><?php endif; ?>
	<?php if ( $image ) : ?><meta property="og:image" content="<?php echo esc_url( $image ); ?>"><?php endif; ?>
	<meta name="twitter:card" content="<?php echo $image ? 'summary_large_image' : 'summary'; ?>">
	<?php
}
add_action( 'wp_head', 'aeon_social_metadata' );

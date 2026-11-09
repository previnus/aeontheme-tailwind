<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$phone = aeon_option( 'phone_number' );
$phone_href = preg_replace( '/[^0-9+]/', '', $phone );
$site_name = get_bloginfo( 'name' );
$light_logo_id = aeon_option( 'site_logo', 0 );
$dark_logo_id = aeon_option( 'sticky_header_logo', $light_logo_id );
$mobile_logo_id = aeon_option( 'mobile_logo', $dark_logo_id );
$mega_groups = aeon_mega_menu_groups();

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link" href="#main"><?php esc_html_e( 'Skip to content', 'aeon-theme' ); ?></a>
<?php
$cta_label = aeon_option( 'header_cta_label', __( 'Contact us', 'aeon-theme' ) );
$newsletter_form = aeon_modal_form( 'newsletter' );
?>
<header class="site-header js-site-header" data-block="header">
	<div class="aeon-container">
		<div class="site-header__row">
			<a class="site-header__logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php echo esc_attr( sprintf( __( '%s home', 'aeon-theme' ), $site_name ) ); ?>">
				<?php echo aeon_logo( $light_logo_id ?: $dark_logo_id, 'site-header__logo-mark--light' ); ?>
				<?php echo aeon_logo( $dark_logo_id, 'site-header__logo-mark--dark' ); ?>
			</a>
			<nav class="site-nav" aria-label="<?php esc_attr_e( 'Primary navigation', 'aeon-theme' ); ?>">
				<?php wp_nav_menu( array(
					'theme_location' => 'primary_menu',
					'container'      => false,
					'menu_class'     => 'site-nav__list',
					'fallback_cb'    => 'aeon_fallback_menu',
					'walker'         => new Aeon_Menu_Walker(),
				) ); ?>
			</nav>
			<div class="site-header__utility">
				<?php if ( $phone_href ) : ?><a class="site-header__phone" href="tel:<?php echo esc_attr( $phone_href ); ?>"><?php echo esc_html( $phone ); ?></a><?php endif; ?>
				<?php echo aeon_contact_action( $cta_label, 'header', 'btn btn--primary aeon-header-cta' ); ?>
				<button type="button" class="site-header__burger js-mobile-toggle" aria-expanded="false" aria-controls="mobile-nav" aria-label="<?php esc_attr_e( 'Open menu', 'aeon-theme' ); ?>"><svg width="20" height="14" viewBox="0 0 20 14" aria-hidden="true" focusable="false"><path d="M1 2h18M1 7h18M1 12h18" fill="none" stroke="currentColor" stroke-width="1.6"/></svg></button>
			</div>
		</div>
		<?php if ( has_nav_menu( 'secondary_menu' ) || $newsletter_form ) : ?>
			<div class="site-header__row site-header__row--secondary">
				<nav class="site-nav" aria-label="<?php esc_attr_e( 'Secondary navigation', 'aeon-theme' ); ?>">
					<?php wp_nav_menu( array(
						'theme_location' => 'secondary_menu',
						'container'      => false,
						'menu_class'     => 'site-nav__list',
						'fallback_cb'    => false,
						'walker'         => new Aeon_Menu_Walker(),
					) ); ?>
				</nav>
				<?php if ( $newsletter_form ) : ?>
					<button type="button" class="site-header__newsletter js-aeon-modal-open" data-modal="newsletter" aria-haspopup="dialog" aria-controls="aeon-modal-newsletter"><?php esc_html_e( 'Subscribe to the newsletter', 'aeon-theme' ); ?></button>
				<?php endif; ?>
			</div>
		<?php endif; ?>
	</div>
	<?php if ( $mega_groups ) : ?>
		<div class="nav-mega js-mega-panel" id="aeon-mega-menu" inert>
			<div class="aeon-container">
				<div class="nav-mega__inner">
					<div class="nav-mega__rail">
						<?php foreach ( $mega_groups as $index => $group ) : ?>
							<button type="button" class="nav-mega__rail-item js-mega-rail-item<?php echo 0 === $index ? ' is-active' : ''; ?>" data-mega-target="<?php echo esc_attr( $index ); ?>" aria-pressed="<?php echo 0 === $index ? 'true' : 'false'; ?>">
								<span class="nav-mega__rail-title"><?php echo esc_html( $group['title'] ); ?></span>
							</button>
						<?php endforeach; ?>
					</div>
					<div class="nav-mega__panel">
						<?php foreach ( $mega_groups as $index => $group ) : ?>
							<div class="nav-mega__pane<?php echo 0 === $index ? ' is-active' : ''; ?>" data-mega-pane="<?php echo esc_attr( $index ); ?>">
								<p class="nav-mega__pane-title"><?php echo aeon_mega_nav_link( $group['url'], $group['title'], 'nav-mega__pane-group-title' ); ?></p>
								<?php echo aeon_mega_menu_list( $group['children'], false ); ?>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</div>
	<?php endif; ?>
</header>

<div class="mobile-nav js-mobile-nav" id="mobile-nav" aria-hidden="true">
	<div class="mobile-nav__scrim js-mobile-scrim"></div>
	<div class="mobile-nav__panel" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e( 'Site menu', 'aeon-theme' ); ?>">
		<div class="mobile-nav__head">
			<?php echo aeon_logo( $mobile_logo_id, 'mobile-nav__logo' ); ?>
			<button type="button" class="mobile-nav__close js-mobile-close" aria-label="<?php esc_attr_e( 'Close menu', 'aeon-theme' ); ?>"><svg width="16" height="16" viewBox="0 0 16 16" aria-hidden="true" focusable="false"><path d="M2 2l12 12M14 2L2 14" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg></button>
		</div>
		<nav aria-label="<?php esc_attr_e( 'Mobile navigation', 'aeon-theme' ); ?>">
			<?php
			$mobile_locations = has_nav_menu( 'mobile_menu' ) ? array( 'mobile_menu' ) : array( 'primary_menu', 'secondary_menu' );
			foreach ( $mobile_locations as $location ) {
				wp_nav_menu( array(
					'theme_location' => $location,
					'container'      => false,
					'menu_class'     => 'mobile-nav__list',
					'fallback_cb'    => 'primary_menu' === $location ? 'aeon_fallback_menu' : false,
					'walker'         => new Aeon_Mobile_Menu_Walker(),
				) );
			}
			?>
		</nav>
		<div class="mobile-nav__footer">
			<?php echo aeon_contact_action( $cta_label, 'mobile-menu', 'btn btn--primary btn--block' ); ?>
			<?php if ( $phone_href ) : ?><a class="btn btn--outline-dark btn--block" href="tel:<?php echo esc_attr( $phone_href ); ?>"><?php echo esc_html( $phone ); ?></a><?php endif; ?>
			<?php if ( $newsletter_form ) : ?><button type="button" class="btn btn--outline-dark btn--block js-aeon-modal-open" data-modal="newsletter" aria-haspopup="dialog" aria-controls="aeon-modal-newsletter"><?php esc_html_e( 'Subscribe to the newsletter', 'aeon-theme' ); ?></button><?php endif; ?>
		</div>
	</div>
</div>
<main id="main">

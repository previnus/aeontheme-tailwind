<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$phone = aeon_option( 'phone_number' );
$phone_href = preg_replace( '/[^0-9+]/', '', $phone );
$email = sanitize_email( aeon_option( 'email_address' ) );
$address = aeon_option( 'business_address' );
$address_note = aeon_option( 'business_address_note' );
$footer_text = aeon_option( 'footer_text' );
$social_links = aeon_option( 'social_links', array() );
$legal_links = aeon_option( 'legal_links', array() );
$newsletter = aeon_modal_form( 'newsletter' );
?>
</main>
<footer class="site-footer" data-block="footer">
	<?php foreach ( array( 'locations' => __( 'Locations', 'aeon-theme' ), 'trades' => __( 'Browse by category', 'aeon-theme' ) ) as $source => $title ) : ?>
		<?php get_template_part( 'template-parts/layouts/directory', null, array( 'layout' => array( 'anchor' => 'footer-' . $source, 'title' => $title, 'source' => $source ) ) ); ?>
	<?php endforeach; ?>
	<div class="aeon-container">
		<div class="site-footer__grid">
			<div>
				<a class="aeon-footer-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo aeon_logo( aeon_option( 'footer_logo', 0 ), 'site-footer__logo' ); ?></a>
				<?php if ( $footer_text ) : ?><p class="site-footer__text"><?php echo esc_html( $footer_text ); ?></p><?php endif; ?>
				<?php if ( $address || $address_note ) : ?>
					<p class="site-footer__address"><?php echo esc_html( $address ); ?><?php if ( $address_note ) : ?><br><span class="site-footer__address-note"><?php echo esc_html( $address_note ); ?></span><?php endif; ?></p>
				<?php endif; ?>
			</div>
			<?php foreach ( array( 'footer_menu' => 'footer_menu_name', 'footer_resources_menu' => 'footer_menu_name_second' ) as $location => $title_field ) : ?>
				<?php if ( ! has_nav_menu( $location ) ) { continue; } ?>
				<div>
					<?php $title = aeon_option( $title_field ); ?>
					<?php if ( $title ) : ?><p class="site-footer__col-title t-mono"><?php echo esc_html( $title ); ?></p><?php endif; ?>
					<?php wp_nav_menu( array(
						'theme_location' => $location,
						'container'      => false,
						'menu_class'     => 'site-footer__list',
						'depth'          => 1,
						'fallback_cb'    => false,
						'walker'         => new Aeon_Footer_Menu_Walker(),
					) ); ?>
				</div>
			<?php endforeach; ?>
			<?php if ( $phone_href || $email || $social_links || $newsletter ) : ?>
				<div>
					<?php if ( $phone_href || $email ) : ?>
						<p class="site-footer__col-title t-mono"><?php echo esc_html( aeon_option( 'contact_text', __( 'Contact', 'aeon-theme' ) ) ); ?></p>
						<?php if ( $phone_href ) : ?><a class="site-footer__phone" href="tel:<?php echo esc_attr( $phone_href ); ?>"><?php echo esc_html( $phone ); ?></a><?php endif; ?>
						<?php if ( $email ) : ?><a class="site-footer__email" href="<?php echo esc_url( 'mailto:' . $email ); ?>"><?php echo esc_html( aeon_option( 'email_text', $email ) ); ?></a><?php endif; ?>
					<?php endif; ?>
					<?php if ( $social_links ) : ?>
						<p class="site-footer__col-title t-mono"><?php echo esc_html( aeon_option( 'social_media_text', __( 'Follow us', 'aeon-theme' ) ) ); ?></p>
						<ul class="site-footer__social">
							<?php foreach ( $social_links as $social ) : ?>
								<?php if ( empty( $social['url'] ) ) { continue; } ?>
								<li><a class="site-footer__social-link" href="<?php echo esc_url( $social['url'] ); ?>"><?php echo esc_html( ( $social['label'] ?? '' ) ?: ( $social['network'] ?? '' ) ); ?></a></li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>
					<?php if ( $newsletter ) : ?><button type="button" class="btn btn--outline-light js-aeon-modal-open" data-modal="newsletter" aria-haspopup="dialog" aria-controls="aeon-modal-newsletter"><?php esc_html_e( 'Subscribe', 'aeon-theme' ); ?></button><?php endif; ?>
				</div>
			<?php endif; ?>
		</div>
		<div class="site-footer__legal">
			<p class="site-footer__copyright t-mono"><?php echo esc_html( aeon_option( 'copyright_text', '© ' . wp_date( 'Y' ) . ' ' . get_bloginfo( 'name' ) ) ); ?></p>
			<?php if ( $legal_links ) : ?>
				<ul class="site-footer__legal-links">
					<?php foreach ( $legal_links as $link ) : ?>
						<?php $url = ( $link['custom_url'] ?? '' ) ?: ( $link['url'] ?? '' ); ?>
						<?php if ( $url ) : ?><li><a class="site-footer__legal-link t-mono" href="<?php echo esc_url( $url ); ?>"><?php echo esc_html( $link['label'] ?? '' ); ?></a></li><?php endif; ?>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</div>
	</div>
</footer>
<?php foreach ( aeon_modal_settings() as $type => $settings ) : ?>
	<?php $form = aeon_modal_form( $type ); if ( ! $form ) { continue; } ?>
	<div class="quote-modal js-aeon-modal" id="aeon-modal-<?php echo esc_attr( $type ); ?>" aria-hidden="true">
		<div class="quote-modal__scrim js-aeon-modal-close"></div>
		<div class="quote-modal__dialog" role="dialog" aria-modal="true" aria-labelledby="aeon-modal-title-<?php echo esc_attr( $type ); ?>">
			<button type="button" class="quote-modal__close js-aeon-modal-close" aria-label="<?php esc_attr_e( 'Close', 'aeon-theme' ); ?>"><svg width="16" height="16" viewBox="0 0 16 16" aria-hidden="true" focusable="false"><path d="M2 2l12 12M14 2L2 14" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg></button>
			<h2 class="quote-modal__title t-display-tight" id="aeon-modal-title-<?php echo esc_attr( $type ); ?>"><?php echo esc_html( $settings['title'] ); ?></h2>
			<?php if ( $settings['text'] ) : ?><p class="quote-modal__text"><?php echo esc_html( $settings['text'] ); ?></p><?php endif; ?>
			<?php echo $form; ?>
		</div>
	</div>
<?php endforeach; ?>
<?php wp_footer(); ?>
</body>
</html>

<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$layout = $args['layout'] ?? array();
$num = $layout['section_number'] ?? '';
$label = $layout['section_label'] ?? '';
$title = $layout['title'] ?? '';
$aside = $layout['aside_text'] ?? '';
$image_id = $layout['image'] ?? 0;
$address = $layout['address'] ?? '';
$hours = aeon_rows( $layout['hours'] ?? null );
$maps_url = $layout['directions_url'] ?? '';
$phone = aeon_option( 'phone_number' );
$phone_href = preg_replace( '/[^0-9+]/', '', $phone );
$arrow = '<svg width="18" height="9" viewBox="0 0 18 9" aria-hidden="true" focusable="false"><path d="M0 4.5h16M12 1l4 3.5L12 8" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>';
?>
<section class="aeon-section visit" data-block="visit" id="<?php echo esc_attr( aeon_section_id( 'visit' ) ); ?>">
	<div class="aeon-container">
		<div class="section-title">
			<div>
				<?php if ( $num || $label ) : ?><p class="section-title__num"><span class="section-title__rule" aria-hidden="true"></span><?php echo esc_html( $num ); ?> <span class="section-title__label"><?php echo esc_html( $label ); ?></span></p><?php endif; ?>
				<h2 class="section-title__heading t-display-tight"><?php echo esc_html( $title ); ?></h2>
			</div>
			<?php if ( $aside ) : ?><div class="section-title__aside"><p class="aeon-mb-0 u-muted"><?php echo esc_html( $aside ); ?></p></div><?php endif; ?>
		</div>
		<div class="visit__grid">
			<div class="visit__media">
				<?php if ( $image_id ) : echo wp_get_attachment_image( $image_id, 'aeon-gallery', false, array( 'alt' => $layout['image_title'] ?? $title ) ); endif; ?>
				<div class="visit__media-copy">
					<?php if ( ! empty( $layout['image_kicker'] ) ) : ?><p class="visit__kicker t-mono"><span class="visit__pin" aria-hidden="true"><svg width="16" height="16" viewBox="0 0 14 14" focusable="false"><path d="M7 13s4.5-4.6 4.5-7.6A4.5 4.5 0 002.5 5.4C2.5 8.4 7 13 7 13z" fill="none" stroke="currentColor" stroke-width="1.4"/><circle cx="7" cy="5.4" r="1.6" fill="none" stroke="currentColor" stroke-width="1.4"/></svg></span><?php echo esc_html( $layout['image_kicker'] ); ?></p><?php endif; ?>
					<?php if ( ! empty( $layout['image_title'] ) ) : ?><p class="visit__title t-display-tight"><?php echo esc_html( $layout['image_title'] ); ?></p><?php endif; ?>
					<?php if ( ! empty( $layout['directions_label'] ) && $maps_url ) : ?><a class="btn-arrow btn-arrow--light visit__directions" href="<?php echo esc_url( $maps_url ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $layout['directions_label'] ); ?><?php echo $arrow; ?></a><?php endif; ?>
				</div>
			</div>
			<div class="visit__card">
				<?php if ( $address ) : ?>
				<p class="visit__label t-mono"><?php esc_html_e( 'Address', 'aeon-theme' ); ?></p>
				<p class="visit__address"><?php echo nl2br( esc_html( $address ) ); ?></p>
				<?php endif; ?>
				<?php if ( ! empty( $hours ) ) : ?>
				<p class="visit__label t-mono"><?php esc_html_e( 'Hours', 'aeon-theme' ); ?></p>
				<dl class="visit__hours">
					<?php foreach ( $hours as $row ) : ?>
					<div class="visit__hours-row"><dt><?php echo esc_html( $row['day'] ?? '' ); ?></dt><dd><?php echo esc_html( $row['time'] ?? '' ); ?></dd></div>
					<?php endforeach; ?>
				</dl>
				<?php endif; ?>
				<div class="visit__actions">
					<?php if ( $phone_href ) : ?><a class="btn btn--primary visit__btn" href="tel:<?php echo esc_attr( $phone_href ); ?>"><svg width="15" height="15" viewBox="0 0 16 16" aria-hidden="true" focusable="false"><path d="M3 1.5h2.2l1.1 2.8-1.4 1a7.5 7.5 0 004.8 4.8l1-1.4 2.8 1.1V12a2.5 2.5 0 01-2.7 2.5A11.5 11.5 0 011.5 4.2A2.5 2.5 0 013 1.5z" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg><?php echo esc_html( $phone ); ?></a><?php endif; ?>
					<?php if ( ! empty( $layout['maps_label'] ) && $maps_url ) : ?><a class="btn btn--outline-light visit__btn" href="<?php echo esc_url( $maps_url ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $layout['maps_label'] ); ?><?php echo $arrow; ?></a><?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</section>

<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$layout = $args['layout'] ?? array();
$num = $layout['section_number'] ?? '';
$label = $layout['section_label'] ?? '';
$title = $layout['title'] ?? '';
$banner_image_id = $layout['banner_image'] ?? 0;
$banner_url = $banner_image_id ? wp_get_attachment_image_url( $banner_image_id, 'full' ) : '';
$points = aeon_rows( $layout['points'] ?? null );
?>
<section class="aeon-section" data-block="financing" id="<?php echo esc_attr( aeon_section_id( 'financing' ) ); ?>">
	<div class="aeon-container">
		<div class="section-title">
			<div>
			<?php if ( $num ) : ?>
	<p class="section-title__num"><span class="section-title__rule" aria-hidden="true"></span><?php echo esc_html( $num ); ?> <span class="section-title__label"><?php echo esc_html( $label ); ?></span></p><?php endif; ?>
				<h2 class="section-title__heading t-display-tight"><?php echo esc_html( $title ); ?></h2>
			</div>
		</div>
		<div class="financing__grid">
			<div class="financing__banner">
				<?php if ( $banner_url ) : ?><div class="financing__banner-media" style="background-image:url('<?php echo esc_url( $banner_url ); ?>')" role="img" aria-label="<?php echo esc_attr( $layout['banner_title'] ?? '' ); ?>"></div><?php endif; ?>
				<div class="financing__banner-scrim" aria-hidden="true"></div>
				<p class="financing__banner-tag t-mono aeon-mb-0"><?php echo esc_html( $layout['banner_tag'] ?? '' ); ?></p>
				<div class="financing__banner-body">
					<h3 class="financing__banner-title t-display-tight"><?php echo nl2br( esc_html( $layout['banner_title'] ?? '' ) ); ?></h3>
					<p class="financing__banner-text aeon-mb-0"><?php echo esc_html( $layout['banner_text'] ?? '' ); ?></p>
				</div>
			</div>
			<div class="financing__panel">
				<div>
					<p class="t-lead u-muted"><?php echo esc_html( $layout['intro_text'] ?? '' ); ?></p>
					<?php if ( ! empty( $points ) ) : ?>
					<ul class="financing__points">
						<?php foreach ( $points as $point ) : ?>
							<li class="financing__point"><svg width="14" height="14" viewBox="0 0 14 14" aria-hidden="true" focusable="false"><path d="M2 7.5l3.2 3.2L12 3.5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg><?php echo esc_html( $point['text'] ?? '' ); ?></li>
						<?php endforeach; ?>
					</ul>
					<?php endif; ?>
				</div>
				<div class="financing__actions">

					<?php echo aeon_contact_action( $layout['cta_label'] ?? '', $layout['cta_context'] ?? '', 'btn btn--primary btn--wide', 'financing' ); ?>
					<?php if ( ! empty( $layout['secondary_label'] ) ) : ?><a class="btn-arrow" href="<?php echo esc_url( $layout['secondary_url'] ?? '' ); ?>"><?php echo esc_html( $layout['secondary_label'] ); ?><svg width="18" height="9" viewBox="0 0 18 9" aria-hidden="true" focusable="false"><path d="M0 4.5h16M12 1l4 3.5L12 8" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg></a><?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</section>

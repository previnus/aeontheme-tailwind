<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$layout = $args['layout'] ?? array();
$num = $layout['section_number'] ?? '';
$label = $layout['section_label'] ?? '';
$title = $layout['title'] ?? '';
$anchor = aeon_section_id( ( $layout['anchor'] ?? '' ) ?: 'sectors' );
$image_id = $layout['image'] ?? 0;
$rows = aeon_rows( $layout['rows'] ?? null );
$cta_title = $layout['cta_title'] ?? '';
?>
<section class="aeon-section sectors<?php echo $cta_title ? ' sectors--has-cta' : ''; ?>" data-block="sectors" id="<?php echo esc_attr( $anchor ); ?>">
	<div class="aeon-container">
		<div class="section-title">
			<div>
				<?php if ( $num || $label ) : ?><p class="section-title__num"><span class="section-title__rule" aria-hidden="true"></span><?php echo esc_html( $num ); ?> <span class="section-title__label"><?php echo esc_html( $label ); ?></span></p><?php endif; ?>
				<h2 class="section-title__heading t-display-tight"><?php echo esc_html( $title ); ?></h2>
			</div>
		</div>
		<div class="sectors__split">
			<figure class="sectors__media">
				<?php if ( $image_id ) : echo wp_get_attachment_image( $image_id, 'aeon-gallery', false, array( 'alt' => wp_strip_all_tags( $layout['image_title'] ?? $title ) ) ); endif; ?>
				<?php if ( ! empty( $layout['image_kicker'] ) || ! empty( $layout['image_title'] ) ) : ?>
				<figcaption class="sectors__caption">
					<?php if ( ! empty( $layout['image_kicker'] ) ) : ?><p class="sectors__caption-kicker t-mono"><?php echo esc_html( $layout['image_kicker'] ); ?></p><?php endif; ?>
					<?php if ( ! empty( $layout['image_title'] ) ) : ?><p class="sectors__caption-title"><?php echo nl2br( esc_html( $layout['image_title'] ) ); ?></p><?php endif; ?>
				</figcaption>
				<?php endif; ?>
			</figure>
			<ol class="sectors__list">
				<?php foreach ( $rows as $i => $row ) : ?>
				<li class="sector-row"><span class="sector-row__code t-mono"><?php echo esc_html( str_pad( (string) ( $i + 1 ), 2, '0', STR_PAD_LEFT ) ); ?></span><div><h3 class="sector-row__title"><?php echo esc_html( $row['title'] ?? '' ); ?></h3><?php if ( ! empty( $row['types'] ) ) : ?><p class="sector-row__types"><?php echo esc_html( $row['types'] ); ?></p><?php endif; ?></div></li>
				<?php endforeach; ?>
			</ol>
		</div>
	</div>
	<?php if ( $cta_title ) : ?>
	<div class="sectors__cta">
		<div class="aeon-container">
			<div class="sectors__cta-grid">
				<?php if ( ! empty( $layout['cta_eyebrow'] ) ) : ?><p class="sectors__cta-eyebrow t-mono"><?php echo esc_html( $layout['cta_eyebrow'] ); ?></p><?php endif; ?>
				<p class="sectors__cta-title"><?php echo esc_html( $cta_title ); ?><?php if ( ! empty( $layout['cta_muted'] ) ) : ?> <span><?php echo esc_html( $layout['cta_muted'] ); ?></span><?php endif; ?></p>
				<?php if ( ! empty( $layout['cta_label'] ) ) : ?><a class="btn btn--primary" href="<?php echo esc_url( $layout['cta_url'] ?? '#contact' ); ?>"><?php echo esc_html( $layout['cta_label'] ); ?><svg width="18" height="9" viewBox="0 0 18 9" aria-hidden="true" focusable="false"><path d="M0 4.5h16M12 1l4 3.5L12 8" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg></a><?php endif; ?>
			</div>
		</div>
	</div>
	<?php endif; ?>
</section>

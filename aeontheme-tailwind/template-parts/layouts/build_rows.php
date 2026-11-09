<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$layout = $args['layout'] ?? array();
$num = $layout['section_number'] ?? '';
$label = $layout['section_label'] ?? '';
$title = $layout['title'] ?? '';
$anchor = aeon_section_id( ( $layout['anchor'] ?? '' ) ?: 'build-rows' );
$rows = aeon_rows( $layout['rows'] ?? null );
?>
<section class="aeon-section aeon-section--bone-2" data-block="build-rows" id="<?php echo esc_attr( $anchor ); ?>">
	<div class="aeon-container">
		<div class="section-title">
			<div>
			<?php if ( $num ) : ?>	<p class="section-title__num"><span class="section-title__rule" aria-hidden="true"></span><?php echo esc_html( $num ); ?> <span class="section-title__label"><?php echo esc_html( $label ); ?></span></p><?php endif; ?>
				<h2 class="section-title__heading t-display-tight"><?php echo esc_html( $title ); ?></h2>
			</div>
		</div>
		<?php foreach ( $rows as $row ) :
			$cards = aeon_rows( $row['cards'] ?? null );

			?>
		<div class="build-row js-carousel">
			<div class="build-row__head">
				<p class="t-eyebrow aeon-mb-0"><?php echo esc_html( $row['label'] ?? '' ); ?></p>
				<div class="build-row__actions">
					<?php if ( ! empty( $row['cta_label'] ) ) : ?><a class="btn btn--primary" href="<?php echo esc_url( $row['cta_url'] ?? '' ); ?>"><?php echo esc_html( $row['cta_label'] ); ?><svg width="18" height="9" viewBox="0 0 18 9" aria-hidden="true" focusable="false"><path d="M0 4.5h16M12 1l4 3.5L12 8" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg></a><?php endif; ?>
					<div class="build-row__arrows">
						<button type="button" class="build-row__arrow js-carousel-prev" aria-label="Scroll <?php echo esc_attr( $row['label'] ?? '' ); ?> left"><svg width="18" height="18" viewBox="0 0 18 18" aria-hidden="true" focusable="false"><path d="M11 3.5L5.5 9l5.5 5.5" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></button>
						<button type="button" class="build-row__arrow js-carousel-next" aria-label="Scroll <?php echo esc_attr( $row['label'] ?? '' ); ?> right"><svg width="18" height="18" viewBox="0 0 18 18" aria-hidden="true" focusable="false"><path d="M7 3.5L12.5 9 7 14.5" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></button>
					</div>
				</div>
			</div>
			<div class="build-row__viewport">
				<div class="build-row__track js-carousel-track"><?php foreach ( $cards as $card ) :
					$logo_id = $card['logo_image'] ?? 0;
					$img_id = $card['image'] ?? 0;
					?><div class="build-row__cell"><?php if ( $img_id ) : ?><a class="product-card" href="<?php echo esc_url( $card['url'] ?? '' ); ?>">
						<span class="product-card__media"><?php echo wp_get_attachment_image( $img_id, 'aeon-card', false, array( 'alt' => $card['name'] ?? '' ) ); ?></span>
						<span class="product-card__body aeon-d-block">
							<span class="product-card__name t-display-tight aeon-d-block"><?php echo esc_html( $card['name'] ?? '' ); ?></span>
							<span class="product-card__desc t-mono aeon-d-block"><?php echo esc_html( $card['subtitle'] ?? '' ); ?></span>
						</span>
					</a><?php else : ?><a class="brand-card" href="<?php echo esc_url( $card['url'] ?? '' ); ?>">
						<span class="brand-card__top"><?php if ( ! empty( $card['badge_text'] ) ) : ?><span class="brand-card__badge"><?php echo esc_html( $card['badge_text'] ); ?></span><?php endif; ?><span class="brand-card__plate">
<?php if ( $logo_id ) : echo wp_get_attachment_image( $logo_id, 'thumbnail', false, array( 'alt' => $card['name'] ?? '' ) ); else : ?><span class="brand-card__plate-text"><?php echo esc_html( $card['name'] ?? '' ); ?></span><?php endif; ?></span></span>
						<span>
							<span class="brand-card__name t-display-tight aeon-d-block"><?php echo esc_html( $card['name'] ?? '' ); ?></span>
							<span class="brand-card__platforms t-mono aeon-d-block"><?php echo esc_html( $card['subtitle'] ?? '' ); ?></span>
							<span class="brand-card__cta">Learn more<svg width="18" height="9" viewBox="0 0 18 9" aria-hidden="true" focusable="false"><path d="M0 4.5h16M12 1l4 3.5L12 8" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
						</span>
					</a><?php endif; ?></div><?php endforeach; ?></div>
			</div>
		</div>
		<?php endforeach; ?>
	</div>
	<?php if ( ! empty( $layout['callout_title'] ) ) : ?>
	<div class="callout-strip">
		<div>
			<p class="callout-strip__eyebrow t-mono"><?php echo esc_html( $layout['callout_eyebrow'] ?? '' ); ?></p>
			<h3 class="callout-strip__title t-display-tight"><?php echo esc_html( $layout['callout_title'] ); ?></h3>
			<p class="callout-strip__text"><?php echo esc_html( $layout['callout_text'] ?? '' ); ?></p>
		</div>
		<a class="btn btn--light btn--wide" href="<?php echo esc_url( $layout['callout_cta_url'] ?? '' ); ?>"><?php echo esc_html( $layout['callout_cta_label'] ?? '' ); ?><svg width="18" height="9" viewBox="0 0 18 9" aria-hidden="true" focusable="false"><path d="M0 4.5h16M12 1l4 3.5L12 8" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg></a>
	</div>
	<?php endif; ?>
	<?php if ( ! empty( $layout['trades'] ) ) : ?>
	<div class="aeon-container">
		<div class="category-strip">
			<div class="category-strip__group">
				<p class="category-strip__label t-mono aeon-mb-0"><?php echo esc_html( $layout['trades_label'] ?? '' ); ?></p>
				<ul class="category-strip__list"><?php foreach ( $layout['trades'] as $trade ) : ?><li><?php echo esc_html( $trade['text'] ?? '' ); ?></li><?php endforeach; ?></ul>
			</div>
			<a class="btn-arrow" href="<?php echo esc_url( $layout['trades_cta_url'] ?? '' ); ?>"><?php echo esc_html( $layout['trades_cta_label'] ?? '' ); ?><svg width="18" height="9" viewBox="0 0 18 9" aria-hidden="true" focusable="false"><path d="M0 4.5h16M12 1l4 3.5L12 8" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg></a>
		</div>
	</div>
	<?php endif; ?>
</section>

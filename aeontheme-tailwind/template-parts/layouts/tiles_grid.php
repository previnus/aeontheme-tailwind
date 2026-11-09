<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$layout = $args['layout'] ?? array();
$num = $layout['section_number'] ?? '';
$label = $layout['section_label'] ?? '';
$title = $layout['title'] ?? '';
$anchor = aeon_section_id( ( $layout['anchor'] ?? '' ) ?: 'tiles-grid' );
$aside = $layout['aside_text'] ?? '';
$three = ! empty( $layout['three_column'] );
$tiles = aeon_rows( $layout['tiles'] ?? null );
?>
<section class="aeon-section" data-block="tiles-grid" id="<?php echo esc_attr( $anchor ); ?>">
	<div class="aeon-container">
		<div class="section-title">
			<div>
			<?php if ( $num ) : ?>	<p class="section-title__num"><span class="section-title__rule" aria-hidden="true"></span><?php echo esc_html( $num ); ?> <span class="section-title__label"><?php echo esc_html( $label ); ?></span></p><?php endif; ?>
				<h2 class="section-title__heading t-display-tight"><?php echo esc_html( $title ); ?></h2>
			</div>
			<?php if ( $aside ) : ?><div class="section-title__aside"><p class="aeon-mb-0 u-muted"><?php echo esc_html( $aside ); ?></p></div><?php endif; ?>
		</div>
		<div class="tiles<?php echo $three ? ' tiles--three' : ''; ?>">
			<?php foreach ( $tiles as $tile ) :
				// Tiles without a real page yet (empty or an in-page "#…" anchor)
				// render as static cards — no link, no hover.
				$tile_url = $tile['url'] ?? '';
				$tile_tag = ( $tile_url && '#' !== $tile_url[0] ) ? 'a' : 'div';
				?>
			<<?php echo $tile_tag; ?> class="tiles__item<?php echo 'div' === $tile_tag ? ' tiles__item--static' : ''; ?>"<?php if ( 'a' === $tile_tag ) : ?> href="<?php echo esc_url( $tile_url ); ?>"<?php endif; ?>>
				<span class="tiles__top"><span class="tiles__code"><?php echo esc_html( $tile['code'] ?? '' ); ?></span><span><svg width="18" height="9" viewBox="0 0 18 9" aria-hidden="true" focusable="false"><path d="M0 4.5h16M12 1l4 3.5L12 8" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg></span></span>
				<span class="tiles__label"><?php echo esc_html( $tile['label'] ?? '' ); ?></span>
			</<?php echo $tile_tag; ?>>
			<?php endforeach; ?>
		</div>
	</div>
</section>

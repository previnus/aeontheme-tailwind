<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$layout = $args['layout'] ?? array();
$num = $layout['section_number'] ?? '';
$label = $layout['section_label'] ?? '';
$title = $layout['title'] ?? '';
$dark = ! empty( $layout['dark'] );
$images = aeon_rows( $layout['images'] ?? null );
?>
<section class="aeon-section<?php echo $dark ? ' aeon-section--dark' : ''; ?>" data-block="gallery" id="<?php echo esc_attr( aeon_section_id( 'gallery' ) ); ?>">
	<div class="aeon-container">
		<div class="section-title<?php echo $dark ? ' section-title--dark' : ''; ?>">
			<div>
		<?php if ( $num ) : ?>		<p class="section-title__num"><span class="section-title__rule" aria-hidden="true"></span><?php echo esc_html( $num ); ?> <span class="section-title__label"><?php echo esc_html( $label ); ?></span></p><?php endif; ?>
				<h2 class="section-title__heading t-display-tight"><?php echo esc_html( $title ); ?></h2>
			</div>
			<?php if ( ! empty( $layout['view_all_label'] ) ) : ?>
			<div class="section-title__aside"><a class="btn-arrow<?php echo $dark ? ' btn-arrow--light' : ''; ?>" href="<?php echo esc_url( $layout['view_all_url'] ?? '' ); ?>"><?php echo esc_html( $layout['view_all_label'] ); ?><svg width="18" height="9" viewBox="0 0 18 9" aria-hidden="true" focusable="false"><path d="M0 4.5h16M12 1l4 3.5L12 8" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg></a></div>
			<?php endif; ?>
		</div>
		<div class="gallery__grid">
			<?php foreach ( $images as $img ) :
				$image_id = $img['image'] ?? 0;
				$wide = ! empty( $img['wide'] );
				?>
			<a class="gallery__cell<?php echo $wide ? ' gallery__cell--wide' : ''; ?>" href="<?php echo esc_url( $img['url'] ?? '#gallery' ); ?>">
				<?php if ( $image_id ) : echo wp_get_attachment_image( $image_id, 'aeon-gallery', false, array( 'alt' => $img['label'] ?? '' ) ); endif; ?>
				<span class="gallery__scrim" aria-hidden="true"></span>
				<span class="gallery__meta">
					<span><span class="gallery__code t-mono aeon-d-block"><?php echo esc_html( $img['code'] ?? '' ); ?></span><span class="gallery__label"><?php echo esc_html( $img['label'] ?? '' ); ?></span></span>
					<span class="gallery__arrow"><svg width="18" height="9" viewBox="0 0 18 9" aria-hidden="true" focusable="false"><path d="M0 4.5h16M12 1l4 3.5L12 8" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
				</span>
			</a>
			<?php endforeach; ?>
		</div>
	</div>
</section>

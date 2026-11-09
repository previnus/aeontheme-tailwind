<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$layout = $args['layout'] ?? array();
$tag = $layout['tag'] ?? '';
$title = $layout['title'] ?? '';
$text = $layout['text'] ?? '';
$list = aeon_rows( $layout['list'] ?? null );
$image_id = $layout['image'] ?? 0;
$reverse = ! empty( $layout['reverse'] );
?>
<section class="aeon-section split-media" data-block="split-media">
	<div class="aeon-container">
		<div class="split-media__grid<?php echo $reverse ? ' split-media__grid--reverse' : ''; ?>">
			<div class="split-media__copy">
				<?php if ( $tag ) : ?><p class="t-mono u-orange"><?php echo esc_html( $tag ); ?></p><?php endif; ?>
				<?php if ( $title ) : ?><h2 class="split-media__title t-display-tight"><?php echo esc_html( $title ); ?></h2><?php endif; ?>
				<?php if ( $text ) : ?><p class="split-media__text"><?php echo esc_html( $text ); ?></p><?php endif; ?>
				<?php if ( ! empty( $list ) ) : ?>
				<ul class="split-media__list">
					<?php foreach ( $list as $item ) : ?>
						<li><span class="split-media__tick"><svg width="14" height="14" viewBox="0 0 14 14" aria-hidden="true" focusable="false"><path d="M2 7.5l3.2 3.2L12 3.5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg></span><?php echo esc_html( $item['text'] ?? '' ); ?></li>
					<?php endforeach; ?>
				</ul>
				<?php endif; ?>
			</div>
			<div class="split-media__media"><?php if ( $image_id ) : echo wp_get_attachment_image( $image_id, 'aeon-card', false, array( 'alt' => $title ) ); endif; ?></div>
		</div>
	</div>
</section>

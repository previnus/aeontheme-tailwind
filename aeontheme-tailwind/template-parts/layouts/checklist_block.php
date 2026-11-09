<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$layout = $args['layout'] ?? array();
$title = $layout['title'] ?? '';
$aside_text = $layout['aside_text'] ?? '';
$items = aeon_rows( $layout['items'] ?? null );
?>
<section class="aeon-section checklist-block" data-block="checklist">
	<div class="aeon-container">
		<div class="section-title">
			<div>
				<?php if ( $title ) : ?><h2 class="section-title__heading t-display-tight"><?php echo esc_html( $title ); ?></h2><?php endif; ?>
			</div>
			<?php if ( $aside_text ) : ?><div class="section-title__aside"><p class="checklist-block__aside"><?php echo esc_html( $aside_text ); ?></p></div><?php endif; ?>
		</div>
		<ul class="checklist">
			<?php foreach ( $items as $item ) : ?>
			<li class="checklist__item">
				<span class="checklist__tick"><svg width="14" height="14" viewBox="0 0 14 14" aria-hidden="true" focusable="false"><path d="M2 7.5l3.2 3.2L12 3.5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
				<div>
					<?php if ( ! empty( $item['title'] ) ) : ?><p class="checklist__title t-display-tight"><?php echo esc_html( $item['title'] ); ?></p><?php endif; ?>
					<?php if ( ! empty( $item['text'] ) ) : ?><p class="checklist__text"><?php echo esc_html( $item['text'] ); ?></p><?php endif; ?>
				</div>
			</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>

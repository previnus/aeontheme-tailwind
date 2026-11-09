<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$layout = $args['layout'] ?? array();
$title = $layout['title'] ?? '';
$lead = $layout['lead'] ?? '';
$text = $layout['text'] ?? '';
$aside_title = $layout['aside_title'] ?? '';
$aside_items = aeon_rows( $layout['aside_items'] ?? null );
?>
<section class="intro-columns" data-block="intro-columns">
	<div class="aeon-container">
		<div class="intro-columns__grid">
			<div>
				<?php if ( $title ) : ?><h2 class="intro-columns__title t-display-tight"><?php echo esc_html( $title ); ?></h2><?php endif; ?>
				<?php if ( $lead ) : ?><p class="intro-columns__lead"><?php echo esc_html( $lead ); ?></p><?php endif; ?>
				<?php if ( $text ) : ?><p class="intro-columns__text"><?php echo esc_html( $text ); ?></p><?php endif; ?>
			</div>
			<?php if ( $aside_title || ! empty( $aside_items ) ) : ?>
			<div class="intro-columns__aside">
				<?php if ( $aside_title ) : ?><p class="intro-columns__aside-title t-mono"><?php echo esc_html( $aside_title ); ?></p><?php endif; ?>
				<?php if ( ! empty( $aside_items ) ) : ?>
				<ul class="intro-columns__list">
					<?php foreach ( $aside_items as $item ) : ?>
						<li><?php echo esc_html( $item['text'] ?? '' ); ?></li>
					<?php endforeach; ?>
				</ul>
				<?php endif; ?>
			</div>
			<?php endif; ?>
		</div>
	</div>
</section>

<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$layout = $args['layout'] ?? array();
$num = $layout['section_number'] ?? '';
$label = $layout['section_label'] ?? '';
$title = $layout['title'] ?? '';
$aside = $layout['aside_text'] ?? '';
$items = aeon_rows( $layout['items'] ?? null );
?>
<section class="aeon-section" data-block="capability-list">
	<div class="aeon-container">
		<div class="section-title">
			<div>

<?php if ( $num ) : ?>	<p class="section-title__num"><span class="section-title__rule" aria-hidden="true"></span><?php echo esc_html( $num ); ?> <span class="section-title__label"><?php echo esc_html( $label ); ?></span></p><?php endif; ?>

				<h2 class="section-title__heading t-display-tight"><?php echo esc_html( $title ); ?></h2>
			</div>
			<?php if ( $aside ) : ?><div class="section-title__aside"><p class="aeon-mb-0 u-muted"><?php echo esc_html( $aside ); ?></p></div><?php endif; ?>
		</div>
		<div class="capability-list">
			<?php foreach ( $items as $item ) :
				$bullets = aeon_rows( $item['bullets'] ?? null );
				?>
			<article class="capability">
				<p class="capability__num t-mono aeon-mb-0"><?php echo esc_html( $item['number'] ?? '' ); ?></p>
				<h3 class="capability__title"><?php echo esc_html( $item['title'] ?? '' ); ?></h3>
				<p class="capability__text"><?php echo esc_html( $item['text'] ?? '' ); ?></p>
				<?php if ( ! empty( $bullets ) ) : ?>
				<ul class="capability__list">
					<?php foreach ( $bullets as $bullet ) : ?>
						<li><svg width="14" height="14" viewBox="0 0 14 14" aria-hidden="true" focusable="false"><path d="M2 7.5l3.2 3.2L12 3.5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg><?php echo esc_html( $bullet['text'] ?? '' ); ?></li>
					<?php endforeach; ?>
				</ul>
				<?php endif; ?>
			</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

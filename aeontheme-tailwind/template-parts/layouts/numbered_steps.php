<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$layout = $args['layout'] ?? array();
$title = $layout['title'] ?? '';
$steps = aeon_rows( $layout['steps'] ?? null );
?>
<section class="aeon-section process" data-block="process-steps">
	<div class="aeon-container">
		<?php if ( $title ) : ?>
		<div class="section-title">
			<div>
				<h2 class="section-title__heading t-display-tight"><?php echo esc_html( $title ); ?></h2>
			</div>
		</div>
		<?php endif; ?>
		<div class="process__grid">
			<?php foreach ( $steps as $step ) : ?>
			<div class="process__step">
				<p class="process__num t-mono"><?php echo esc_html( $step['num'] ?? '' ); ?></p>
				<?php if ( ! empty( $step['title'] ) ) : ?><h3 class="process__title t-display-tight"><?php echo esc_html( $step['title'] ); ?></h3><?php endif; ?>
				<?php if ( ! empty( $step['text'] ) ) : ?><p class="process__text"><?php echo esc_html( $step['text'] ); ?></p><?php endif; ?>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

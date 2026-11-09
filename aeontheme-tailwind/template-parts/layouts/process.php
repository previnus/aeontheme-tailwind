<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$layout = $args['layout'] ?? array();
$eyebrow = $layout['eyebrow'] ?? '';
$title = $layout['title'] ?? '';
$steps = aeon_rows( $layout['steps'] ?? null );
?>
<section class="process aeon-section" data-block="process">
	<div class="aeon-container">
		<?php if ( $eyebrow ) : ?><p class="t-eyebrow process__eyebrow"><?php echo esc_html( $eyebrow ); ?></p><?php endif; ?>
		<?php if ( $title ) : ?><h2 class="process__title t-display-tight"><?php echo esc_html( $title ); ?></h2><?php endif; ?>
		<div class="process__grid">
			<span class="process__rule" aria-hidden="true"></span>
			<?php foreach ( $steps as $step ) : ?>
			<div class="process__step">
				<span class="process__marker" aria-hidden="true"></span>
				<p class="process__phase t-mono aeon-mb-0"><?php echo esc_html( $step['phase'] ?? '' ); ?></p>
				<h3 class="process__step-title"><?php echo esc_html( $step['title'] ?? '' ); ?></h3>
				<p class="process__text aeon-mb-0"><?php echo esc_html( $step['text'] ?? '' ); ?></p>
				<?php if ( ! empty( $step['duration'] ) ) : ?><p class="process__tag t-mono"><?php echo esc_html( $step['duration'] ); ?></p><?php endif; ?>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

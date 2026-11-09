<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$layout = $args['layout'] ?? array();
$num = $layout['section_number'] ?? '';
$label = $layout['section_label'] ?? '';
$title = $layout['title'] ?? '';
$aside = $layout['aside_text'] ?? '';
$image_id = $layout['image'] ?? 0;
$quote = $layout['quote'] ?? '';
$lead = $layout['lead'] ?? '';
$body = $layout['body'] ?? '';
$caption = $layout['image_caption'] ?? '';
$milestones = aeon_rows( $layout['milestones'] ?? null );
?>
<section class="aeon-section" data-block="story" id="<?php echo esc_attr( aeon_section_id( 'story' ) ); ?>">
	<div class="aeon-container">
		<div class="section-title">
			<div>
		<?php if ( $num ) : ?>		<p class="section-title__num"><span class="section-title__rule" aria-hidden="true"></span><?php echo esc_html( $num ); ?> <span class="section-title__label"><?php echo esc_html( $label ); ?></span></p><?php endif; ?>

				<h2 class="section-title__heading t-display-tight"><?php echo nl2br( esc_html( $title ) ); ?></h2>
			</div>
			<?php if ( $aside ) : ?><div class="section-title__aside"><p class="aeon-mb-0 u-muted"><?php echo esc_html( $aside ); ?></p></div><?php endif; ?>
		</div>
		<div class="aeon-grid aeon-grid--story">
			<div class="aeon-grid__item">
				<?php if ( $image_id ) : ?><div class="story__media"><?php echo wp_get_attachment_image( $image_id, 'aeon-card', false, array( 'alt' => $title ) ); ?><?php if ( $caption ) : ?><p class="story__caption t-mono"><?php echo esc_html( $caption ); ?></p><?php endif; ?></div><?php endif; ?>
				<?php if ( $quote ) : ?><blockquote class="story__quote"><p class="story__quote-text t-display-tight"><?php echo esc_html( $quote ); ?></p></blockquote><?php endif; ?>
			</div>
			<div class="aeon-grid__item">
				<?php if ( $lead ) : ?><p class="t-lead"><?php echo esc_html( $lead ); ?></p><?php endif; ?>
				<div class="u-muted"><?php echo wp_kses_post( $body ); ?></div>
				<?php if ( ! empty( $milestones ) ) : ?>
				<dl class="milestones">
					<?php foreach ( $milestones as $milestone ) : ?>
					<div class="milestones__row"><dt class="milestones__year t-display-tight"><?php echo esc_html( $milestone['year'] ?? '' ); ?></dt><dd class="milestones__text"><?php echo esc_html( $milestone['text'] ?? '' ); ?></dd></div>
					<?php endforeach; ?>
				</dl>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>

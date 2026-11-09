<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$layout = $args['layout'] ?? array();
$num = $layout['section_number'] ?? '';
$label = $layout['section_label'] ?? '';
$title = $layout['title'] ?? '';
$partners = aeon_rows( $layout['partners'] ?? null );

if ( ! $partners || ! empty( $layout['hide_section'] ) ) {
	return;
}
$section_id = aeon_section_id( 'partnerships' );
?>
<section class="aeon-section aeon-section--dark" data-block="partnerships" id="<?php echo esc_attr( $section_id ); ?>">
	<div class="aeon-container">
		<div class="section-title section-title--dark">
			<div>
			<?php if ( $num ) : ?>	<p class="section-title__num"><span class="section-title__rule" aria-hidden="true"></span><?php echo esc_html( $num ); ?> <span class="section-title__label"><?php echo esc_html( $label ); ?></span></p><?php endif; ?>

				<h2 class="section-title__heading t-display-tight"><?php echo esc_html( $title ); ?></h2>
			</div>
		</div>
		<div class="js-tabs">
			<div class="partners__tabs" role="tablist" aria-label="Partners">
				<?php foreach ( $partners as $i => $partner ) :
					$slug = $section_id . '-' . ( $i + 1 );
					?><button type="button" class="partners__tab js-tab" id="aeon-partner-tab-<?php echo esc_attr( $slug ); ?>" role="tab" data-tab-target="aeon-partner-panel-<?php echo esc_attr( $slug ); ?>" aria-selected="<?php echo 0 === $i ? 'true' : 'false'; ?>" aria-controls="aeon-partner-panel-<?php echo esc_attr( $slug ); ?>" tabindex="<?php echo 0 === $i ? '0' : '-1'; ?>"><span class="partners__tab-dot<?php echo ! empty( $partner['is_certified'] ) ? ' partners__tab-dot--certified' : ''; ?>" aria-hidden="true"></span><?php echo esc_html( $partner['name'] ?? '' ); ?></button><?php endforeach; ?>
			</div>
			<?php foreach ( $partners as $i => $partner ) :
				$slug = $section_id . '-' . ( $i + 1 );
				$benefits = aeon_rows( $partner['benefits'] ?? null );
				$platforms = aeon_rows( $partner['platforms'] ?? null );
				?>
			<div class="partners__panel js-tab-panel" id="aeon-partner-panel-<?php echo esc_attr( $slug ); ?>" role="tabpanel" aria-labelledby="aeon-partner-tab-<?php echo esc_attr( $slug ); ?>"<?php echo 0 === $i ? '' : ' hidden'; ?>>
				<div class="partners__grid">
					<div>
						<p class="partners__status<?php echo empty( $partner['is_certified'] ) ? ' partners__status--pending' : ''; ?> t-mono"><?php echo esc_html( $partner['status_label'] ?? '' ); ?></p>
						<p class="partners__credential"><?php echo esc_html( $partner['credential'] ?? '' ); ?></p>
						<p class="partners__meta t-mono"><?php echo esc_html( $partner['meta'] ?? '' ); ?></p>
						<p class="partners__text"><?php echo esc_html( $partner['text'] ?? '' ); ?></p>
						<div class="partners__actions">
							<?php echo aeon_contact_action( __( 'Request a quote', 'aeon-theme' ), $partner['cta_context'] ?? '', 'btn btn--primary' ); ?>
							<?php if ( ! empty( $partner['secondary_label'] ) ) : ?><a class="btn btn--outline-light" href="<?php echo esc_url( $partner['secondary_url'] ?? '' ); ?>"><?php echo esc_html( $partner['secondary_label'] ); ?></a><?php endif; ?>
						</div>
					</div>
					<?php if ( ! empty( $benefits ) ) : ?>
					<ul class="partners__benefits">
						<?php foreach ( $benefits as $benefit ) : ?>
							<li class="partners__benefit"><svg width="14" height="14" viewBox="0 0 14 14" aria-hidden="true" focusable="false"><path d="M2 7.5l3.2 3.2L12 3.5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg><span><span class="partners__benefit-title aeon-d-block"><?php echo esc_html( $benefit['title'] ?? '' ); ?></span><span class="partners__benefit-text"><?php echo esc_html( $benefit['text'] ?? '' ); ?></span></span></li>
						<?php endforeach; ?>
					</ul>
					<?php endif; ?>
				</div>
				<?php if ( ! empty( $platforms ) ) : ?>
				<div class="partners__platforms">
					<p class="partners__platforms-label t-mono aeon-mb-0"><?php echo esc_html( $partner['platforms_label'] ?? '' ); ?></p>
					<?php foreach ( $platforms as $platform ) : ?>
						<div><p class="partners__platform-name aeon-mb-0"><?php echo esc_html( $platform['name'] ?? '' ); ?></p><p class="partners__platform-detail aeon-mb-0"><?php echo esc_html( $platform['detail'] ?? '' ); ?></p></div>
					<?php endforeach; ?>
				</div>
				<?php endif; ?>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

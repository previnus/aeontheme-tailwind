<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$layout = $args['layout'] ?? array();
$image_id = $layout['image'] ?? 0;
$title = $layout['title'] ?? '';
$title_accent = $layout['title_accent'] ?? '';
$lead = $layout['lead'] ?? '';
$primary_label = $layout['primary_cta_label'] ?? '';
$primary_context = $layout['primary_cta_context'] ?? '';
$secondary_label = $layout['secondary_cta_label'] ?? '';
$secondary_url = $layout['secondary_cta_url'] ?? '';
$stats = aeon_rows( $layout['stats'] ?? null );
$image_url = $image_id ? wp_get_attachment_image_url( $image_id, 'full' ) : '';
?>
<section class="hero" data-block="hero" id="<?php echo esc_attr( aeon_section_id( 'top' ) ); ?>">
	<?php if ( $image_url ) : ?>
	<div class="hero__media" style="background-image:url('<?php echo esc_url( $image_url ); ?>')" role="img" aria-label="<?php echo esc_attr( $title ); ?>"></div>
	<?php endif; ?>
	<div class="hero__scrim" aria-hidden="true"></div>
	<div class="hero__scrim hero__scrim--base" aria-hidden="true"></div>
	<div class="hero__accent" aria-hidden="true"></div>
	<div class="aeon-container hero__inner tw:relative">
		<h1 class="hero__title t-display-tight"><?php echo esc_html( $title ); ?> <?php if ( $title_accent ) : ?><span class="hero__title-accent"><?php echo esc_html( $title_accent ); ?></span><?php endif; ?></h1>
		<?php if ( $lead ) : ?><p class="hero__lead"><?php echo esc_html( $lead ); ?></p><?php endif; ?>
		<div class="hero__actions">
			<?php if ( $primary_label ) : ?><?php echo aeon_contact_action( $primary_label, $primary_context ); ?><?php endif; ?>
			<?php if ( $secondary_label ) : ?><a class="btn btn--outline-light btn--wide" href="<?php echo esc_url( $secondary_url ); ?>"><?php echo esc_html( $secondary_label ); ?></a><?php endif; ?>
		</div>
		<?php if ( ! empty( $stats ) ) : ?>
		<dl class="hero__stats">
			<?php foreach ( $stats as $stat ) : ?>
				<div><dt class="hero__stat-figure t-display"><?php echo esc_html( $stat['figure'] ?? '' ); ?></dt><dd class="hero__stat-label t-mono"><?php echo esc_html( $stat['label'] ?? '' ); ?></dd></div>
			<?php endforeach; ?>
		</dl>
		<?php endif; ?>
	</div>
</section>

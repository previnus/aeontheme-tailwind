<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$layout = $args['layout'] ?? array();
$eyebrow = $layout['eyebrow'] ?? '';
$title = $layout['title'] ?? '';
$lead = $layout['lead'] ?? '';
$items = aeon_rows( $layout['items'] ?? null );
$primary_label = $layout['primary_cta_label'] ?? '';
$primary_context = $layout['primary_cta_context'] ?? '';
$secondary_label = $layout['secondary_cta_label'] ?? '';
$secondary_url = $layout['secondary_cta_url'] ?? '';
?>

<section class="stub" data-block="page-stub" id="<?php echo esc_attr( aeon_section_id( 'top' ) ); ?>">
	<div class="aeon-container">
		<?php if ( $eyebrow ) : ?><p class="t-eyebrow"><?php echo esc_html( $eyebrow ); ?></p><?php endif; ?>
		<h1 class="stub__title t-display-tight"><?php echo nl2br( esc_html( $title ) ); ?></h1>
		<?php if ( $lead ) : ?><p class="stub__lead"><?php echo esc_html( $lead ); ?></p><?php endif; ?>
		<?php if ( ! empty( $items ) ) : ?>
		<ul class="stub__list">
			<?php foreach ( $items as $item ) :
				$id = empty( $item['anchor'] ) ? '' : aeon_section_id( $item['anchor'] );
				?>
				<li class="stub__item"<?php if ( $id ) : ?> id="<?php echo esc_attr( $id ); ?>"<?php endif; ?>><h2 class="stub__item-title"><?php echo esc_html( $item['title'] ?? '' ); ?></h2><p class="stub__item-text aeon-mb-0"><?php echo esc_html( $item['text'] ?? '' ); ?></p></li>
			<?php endforeach; ?>
		</ul>
		<?php endif; ?>
		<div class="stub__actions">
			<?php echo aeon_contact_action( $primary_label, $primary_context ); ?>
			<?php if ( $secondary_label && $secondary_url ) : ?>
				<a class="btn btn--outline-dark btn--wide" href="<?php echo esc_url( $secondary_url ); ?>"><?php echo esc_html( $secondary_label ); ?></a>
			<?php endif; ?>
		</div>
	</div>
</section>

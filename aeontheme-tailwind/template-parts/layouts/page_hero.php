<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$layout = $args['layout'] ?? array();
$dark = ! empty( $layout['dark'] );
$plain = ! empty( $layout['plain_layout'] );
$breadcrumb = $layout['breadcrumb'] ?? '';
$breadcrumb_url = $layout['breadcrumb_url'] ?? '';
$breadcrumb_url_2 = $layout['breadcrumb_url_2'] ?? '';
$breadcrumb_url_3 = $layout['breadcrumb_url_3'] ?? '';
$eyebrow = $layout['eyebrow'] ?? '';
$title = $layout['title'] ?? '';
$title_accent = $layout['title_accent'] ?? '';
$lead = $layout['lead'] ?? '';
$primary_label = $layout['primary_cta_label'] ?? '';
$primary_context = $layout['primary_cta_context'] ?? '';
$secondary_label = $layout['secondary_cta_label'] ?? '';
$secondary_url = $layout['secondary_cta_url'] ?? '';
$trust_stats = aeon_rows( $layout['trust_stats'] ?? null );
$image_id = $layout['image'] ?? 0;
$outline_class = $dark ? 'btn--outline-light' : 'btn--outline-dark';

$classes = 'page-hero';
if ( $dark ) { $classes .= ' page-hero--dark'; }
if ( $plain ) { $classes .= ' page-hero--plain'; }
?>
<section class="<?php echo esc_attr( $classes ); ?>" data-block="page-hero" id="<?php echo esc_attr( aeon_section_id( 'top' ) ); ?>">
	<div class="aeon-container">
		<?php if ( $plain ) : ?>
			<?php if ( $breadcrumb ) : ?><ol class="page-hero__breadcrumb"><li><a class="page-hero__breadcrumb-link" href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a></li><li><span aria-current="page"><?php echo esc_html( $breadcrumb ); ?></span></li></ol><?php endif; ?>
			<h1 class="page-hero__title t-display-tight"><?php echo esc_html( $title ); ?><?php if ( $title_accent ) : ?><br><span class="page-hero__title-accent"><?php echo esc_html( $title_accent ); ?></span><?php endif; ?></h1>
			<?php if ( $lead ) : ?><p class="page-hero__lead"><?php echo wp_kses_post( $lead ); ?></p><?php endif; ?>
			<?php if ( $primary_label || $secondary_label ) : ?>
			<div class="page-hero__actions">
				<?php if ( $primary_label ) : ?><a class="btn btn--primary btn--wide" href="<?php echo esc_url( $primary_context ? $primary_context : '#contact' ); ?>"><?php echo esc_html( $primary_label ); ?><svg width="18" height="9" viewBox="0 0 18 9" aria-hidden="true" focusable="false"><path d="M0 4.5h16M12 1l4 3.5L12 8" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg></a><?php endif; ?>
				<?php if ( $secondary_label ) : ?><a class="btn <?php echo esc_attr( $outline_class ); ?> btn--wide" href="<?php echo esc_url( $secondary_url ); ?>"><?php echo esc_html( $secondary_label ); ?></a><?php endif; ?>
			</div>
			<?php endif; ?>
		<?php else : ?>
		<div class="page-hero__grid">
			<div>
				<?php if ( $breadcrumb ) :
						$breadcrumb_crumbs = array_map( 'trim', explode( '/', $breadcrumb ) );
						$breadcrumb_current = array_pop( $breadcrumb_crumbs );






						$breadcrumb_urls = array( $breadcrumb_url, $breadcrumb_url_2, $breadcrumb_url_3 );
						?>
					<ol class="page-hero__breadcrumb">
						<?php foreach ( $breadcrumb_crumbs as $breadcrumb_i => $breadcrumb_crumb ) :
							$breadcrumb_crumb_url = $breadcrumb_urls[ $breadcrumb_i ] ?? '';
							if ( $breadcrumb_crumb_url
								&& false === strpos( $breadcrumb_crumb_url, '?' )
								&& false === strpos( $breadcrumb_crumb_url, '#' )
								&& wp_parse_url( $breadcrumb_crumb_url, PHP_URL_HOST ) === wp_parse_url( home_url(), PHP_URL_HOST ) ) {




								$breadcrumb_crumb_url = user_trailingslashit( $breadcrumb_crumb_url );
							}
							?>
							<li><?php if ( $breadcrumb_crumb_url ) : ?><a class="page-hero__breadcrumb-link" href="<?php echo esc_url( $breadcrumb_crumb_url ); ?>"><?php echo esc_html( $breadcrumb_crumb ); ?></a><?php else : ?><span class="no-page"><?php echo esc_html( $breadcrumb_crumb ); ?></span><?php endif; ?></li>
						<?php endforeach; ?>
						<li><span aria-current="page"><?php echo esc_html( $breadcrumb_current ); ?></span></li>
					</ol>
				<?php endif; ?>
				<?php if ( $eyebrow ) : ?><p class="page-hero__eyebrow t-eyebrow"><?php echo esc_html( $eyebrow ); ?></p><?php endif; ?>
				<h1 class="page-hero__title t-display-tight"><?php echo esc_html( $title ); ?><?php if ( $title_accent ) : ?><br><span class="page-hero__title-accent"><?php echo esc_html( $title_accent ); ?></span><?php endif; ?></h1>
				<?php if ( $lead ) : ?><p class="page-hero__lead"><?php echo wp_kses_post( $lead ); ?></p><?php endif; ?>
				<div class="page-hero__actions">
					<?php if ( $primary_label ) : ?><?php echo aeon_contact_action( $primary_label, $primary_context ); ?><?php endif; ?>
					<?php if ( $secondary_label ) : ?><a class="btn <?php echo esc_attr( $outline_class ); ?> btn--wide" href="<?php echo esc_url( $secondary_url ); ?>"><?php echo esc_html( $secondary_label ); ?></a><?php endif; ?>
				</div>
				<?php if ( ! empty( $trust_stats ) ) : ?>
				<dl class="page-hero__trust">
					<?php foreach ( $trust_stats as $stat ) : ?>
						<div><dt class="page-hero__trust-figure"><?php echo esc_html( $stat['figure'] ?? '' ); ?></dt><dd class="page-hero__trust-label"><?php echo esc_html( $stat['label'] ?? '' ); ?></dd></div>
					<?php endforeach; ?>
				</dl>
				<?php endif; ?>
			</div>
			<?php if ( $image_id ) : ?>
			<div class="page-hero__media"><?php echo wp_get_attachment_image( $image_id, 'aeon-hero', false, array( 'alt' => $title ) ); ?></div>
			<?php endif; ?>
		</div>
		<?php endif; ?>
	</div>
</section>

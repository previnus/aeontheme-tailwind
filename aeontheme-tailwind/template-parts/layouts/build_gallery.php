<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$layout = $args['layout'] ?? array();
$title = $layout['title'] ?? '';
$tiles = aeon_rows( $layout['tiles'] ?? null );

// Filter groups + subtags are derived straight from each tile's Group/Tag
// text fields — add a build with a new group or tag and the filter UI
// picks it up automatically, no separate filter setup needed.
$groups = array();
foreach ( $tiles as $tile ) {
	$group = trim( $tile['group'] ?? '' );
	$tag = trim( $tile['tag'] ?? '' );
	if ( ! $group ) {
		continue;
	}
	$slug = sanitize_title( $group );
	if ( ! isset( $groups[ $slug ] ) ) {
		$groups[ $slug ] = array( 'label' => $group, 'tags' => array() );
	}
	if ( $tag && ! in_array( $tag, $groups[ $slug ]['tags'], true ) ) {
		$groups[ $slug ]['tags'][] = $tag;
	}
}
$count = count( $tiles );
$lightbox_id = aeon_section_id( 'aeon-lightbox' );
?>
<section class="aeon-section aeon-section--tight" data-block="build-grid" id="<?php echo esc_attr( aeon_section_id( 'builds' ) ); ?>">
	<div class="aeon-container js-filter" data-filter-count="item">
		<div class="section-title">
			<div>
				<?php if ( $title ) : ?><h2 class="section-title__heading t-display-tight"><?php echo esc_html( $title ); ?></h2><?php endif; ?>
			</div>
			<?php if ( ! empty( $groups ) ) : ?>
			<div class="section-title__aside">
				<div class="filter-chips" role="group" aria-label="Filter gallery items">
					<button type="button" class="filter-chips__btn js-filter-btn is-active" data-group="" aria-pressed="true">All</button>
					<?php foreach ( $groups as $slug => $g ) : ?>
						<button type="button" class="filter-chips__btn js-filter-btn" data-group="<?php echo esc_attr( $slug ); ?>" aria-pressed="false"><?php echo esc_html( $g['label'] ); ?></button>
					<?php endforeach; ?>
				</div>
			</div>
			<?php endif; ?>
		</div>
		<div class="filter-meta">
			<p class="filter-meta__count t-mono js-filter-count"><?php echo (int) $count; ?> items</p>
			<?php foreach ( $groups as $slug => $g ) : ?>
				<?php if ( ! empty( $g['tags'] ) ) : ?>
				<div class="filter-meta__subtags js-subtags" data-group="<?php echo esc_attr( $slug ); ?>" hidden>
					<?php foreach ( $g['tags'] as $tag ) : ?>
						<button type="button" class="filter-subtag t-mono js-subtag-btn" data-tag="<?php echo esc_attr( $tag ); ?>" data-group="<?php echo esc_attr( $slug ); ?>"><?php echo esc_html( $tag ); ?></button>
					<?php endforeach; ?>
				</div>
				<?php endif; ?>
			<?php endforeach; ?>
		</div>
		<div class="build-grid">
			<?php foreach ( $tiles as $tile ) :
				$group_slug = sanitize_title( $tile['group'] ?? '' );
				$tag = $tile['tag'] ?? '';
				$image_id = $tile['image'] ?? 0;
				$tile_title = $tile['title'] ?? '';
				$meta = $tile['meta'] ?? '';
				$image_url = $image_id ? wp_get_attachment_image_url( $image_id, 'aeon-gallery' ) : '';
				$preview_title = $tile_title ?: __( 'Image preview', 'aeon-theme' );
				?>
			<figure class="build-tile js-filter-item" data-group="<?php echo esc_attr( $group_slug ); ?>" data-tag="<?php echo esc_attr( $tag ); ?>">
				<?php if ( $image_url ) : ?>
				<button type="button" class="build-tile__zoom js-lightbox-open" aria-haspopup="dialog" aria-controls="<?php echo esc_attr( $lightbox_id ); ?>" data-image="<?php echo esc_url( $image_url ); ?>" data-title="<?php echo esc_attr( $preview_title ); ?>" data-meta="<?php echo esc_attr( $meta ); ?>" aria-label="<?php echo esc_attr( $tile_title ? sprintf( __( 'View %s', 'aeon-theme' ), $tile_title ) : __( 'View image', 'aeon-theme' ) ); ?>"><?php echo wp_get_attachment_image( $image_id, 'aeon-gallery', false, array( 'class' => 'build-tile__img', 'alt' => $tile_title ) ); ?></button>
				<?php else : ?>
				<div class="build-tile__placeholder" aria-hidden="true"><span class="build-tile__placeholder-label t-mono">Photo needed</span></div>
				<?php endif; ?>
				<?php if ( $tag ) : ?><span class="build-tile__chip t-mono"><?php echo esc_html( $tag ); ?></span><?php endif; ?>
				<figcaption class="build-tile__cap">
					<?php if ( $tile_title ) : ?><span class="build-tile__title t-display-tight"><?php echo esc_html( $tile_title ); ?></span><?php endif; ?>
					<?php if ( $meta ) : ?><span class="build-tile__meta t-mono"><?php echo esc_html( $meta ); ?></span><?php endif; ?>
				</figcaption>
			</figure>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<div class="lightbox js-lightbox" id="<?php echo esc_attr( $lightbox_id ); ?>" data-block="lightbox" aria-hidden="true">
	<div class="lightbox__scrim js-lightbox-close"></div>
	<div class="lightbox__dialog" role="dialog" aria-modal="true" aria-labelledby="<?php echo esc_attr( $lightbox_id . '-title' ); ?>">
		<button type="button" class="lightbox__close js-lightbox-close" aria-label="Close"><svg width="16" height="16" viewBox="0 0 16 16" aria-hidden="true" focusable="false"><path d="M2 2l12 12M14 2L2 14" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg></button>
		<figure class="lightbox__figure">
			<div class="js-lightbox-media"></div>
			<figcaption class="lightbox__cap">
				<span class="lightbox__title t-display-tight js-lightbox-title" id="<?php echo esc_attr( $lightbox_id . '-title' ); ?>"></span>
				<span class="lightbox__meta t-mono js-lightbox-meta"></span>
			</figcaption>
		</figure>
	</div>
</div>

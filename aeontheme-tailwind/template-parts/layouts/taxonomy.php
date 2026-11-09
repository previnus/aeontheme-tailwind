<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$layout = $args['layout'] ?? array();
$num = $layout['section_number'] ?? '';
$label = $layout['section_label'] ?? '';
$title = $layout['title'] ?? '';
$anchor = aeon_section_id( ( $layout['anchor'] ?? '' ) ?: 'taxonomy' );
$columns = ( $layout['columns'] ?? 'two' ) === 'three' ? 'three' : 'two';
$cards = aeon_rows( $layout['cards'] ?? null );
// Hub pages link each chip to a model/product page; everywhere else chips
// are plain selling points, so they render as labels with no hover.
$chip_links = ! empty( $layout['chips_are_links'] );

// A chip is only a link (with hover) when it leads to a published page. In-page
// anchors and links to pages that are not live yet render as plain labels.
$chip_is_link = static function ( $url ) use ( $chip_links ) {
	$url = trim( (string) $url );
	if ( ! $chip_links || '' === $url || '#' === $url[0] ) {
		return false;
	}
	$path = strtok( $url, '#' );
	$host = wp_parse_url( $path, PHP_URL_HOST );
	if ( $host && wp_parse_url( home_url(), PHP_URL_HOST ) !== $host ) {
		return true; // external site
	}
	$post_id = url_to_postid( $host ? $path : home_url( $path ) );
	if ( ! $post_id ) {
		// Short URL of a nested page (WordPress redirects it to the full address).
		$slug  = basename( trim( (string) wp_parse_url( $path, PHP_URL_PATH ), '/' ) );
		$found = $slug ? get_posts( array( 'post_type' => 'page', 'name' => $slug, 'post_status' => 'publish', 'numberposts' => 1, 'fields' => 'ids' ) ) : array();
		$post_id = $found ? (int) $found[0] : 0;
	}
	return $post_id && 'publish' === get_post_status( $post_id );
};
?>
<section class="aeon-section" data-block="taxonomy" id="<?php echo esc_attr( $anchor ); ?>">
	<div class="aeon-container">
		<div class="section-title">
			<div>
			<?php if ( $num ) : ?>	<p class="section-title__num"><span class="section-title__rule" aria-hidden="true"></span><?php echo esc_html( $num ); ?> <span class="section-title__label"><?php echo esc_html( $label ); ?></span></p><?php endif; ?>
				<h2 class="section-title__heading t-display-tight"><?php echo esc_html( $title ); ?></h2>
			</div>
		</div>
		<div class="taxonomy taxonomy--<?php echo esc_attr( $columns ); ?>">
			<?php foreach ( $cards as $card ) :
				$image_id = $card['image'] ?? 0;
				$chips = aeon_rows( $card['chips'] ?? null );
				?>


						<article class="taxonomy__card" id="<?php echo esc_attr( aeon_section_id( ( $card['title'] ?? '' ) ?: 'category-card' ) ); ?>">
				<?php if ( $image_id ) : ?><div class="taxonomy__media"><?php echo wp_get_attachment_image( $image_id, 'aeon-card', false, array( 'alt' => $card['title'] ?? '' ) ); ?></div><?php endif; ?>




				<div class="taxonomy__body">
					<p class="taxonomy__code t-mono aeon-mb-0"><?php echo esc_html( $card['code'] ?? '' ); ?></p>
					<h3 class="taxonomy__title"><a href="<?php echo esc_url( $card['url'] ?? '' ); ?>"><?php echo esc_html( $card['title'] ?? '' ); ?></a></h3>
					<p class="taxonomy__text aeon-mb-0"><?php echo esc_html( $card['text'] ?? '' ); ?></p>
					<?php if ( ! empty( $chips ) ) : ?>
					<ul class="taxonomy__chips">
						<?php foreach ( $chips as $chip ) : ?>
							<?php if ( $chip_is_link( $chip['url'] ?? '' ) ) : ?>
							<li><a class="taxonomy__chip" href="<?php echo esc_url( $chip['url'] ); ?>"><?php echo esc_html( $chip['label'] ?? '' ); ?></a></li>
							<?php else : ?>
							<li><span class="taxonomy__chip taxonomy__chip--static"><?php echo esc_html( $chip['label'] ?? '' ); ?></span></li>
							<?php endif; ?>
						<?php endforeach; ?>
					</ul>
					<?php endif; ?>
				</div>
			</article>
			<?php endforeach; ?>
			<?php if ( ! empty( $layout['cta_title'] ) ) : ?>
			<article class="taxonomy__card taxonomy__card--cta">
				<p class="taxonomy__code t-mono aeon-mb-0"><?php echo esc_html( $layout['cta_code'] ?? '' ); ?></p>
				<h3 class="taxonomy__title"><?php echo esc_html( $layout['cta_title'] ); ?></h3>
				<p class="taxonomy__text u-muted-light aeon-mb-0"><?php echo esc_html( $layout['cta_text'] ?? '' ); ?></p>
				<?php echo aeon_contact_action( $layout['cta_label'] ?? '', $layout['cta_context'] ?? '', 'btn btn--light' ); ?>
			</article>
			<?php endif; ?>
		</div>
	</div>
</section>

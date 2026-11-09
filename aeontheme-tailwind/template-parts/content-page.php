<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<section class="page-hero" data-block="page-hero" id="top">
	<div class="aeon-container">
		<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?>
			<div class="page-hero__media">
				<?php the_post_thumbnail( 'aeon-hero', array( 'alt' => get_the_title() ) ); ?>
			</div>
		<?php endif; ?>
		<h1 class="t-display-tight"><?php the_title(); ?></h1>
		<div class="page-hero__content">
			<?php
			if ( post_password_required() ) {
				echo get_the_password_form();
			} else {
				the_content();
				wp_link_pages();
			}
			?>
		</div>
	</div>
</section>

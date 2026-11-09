<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header();

while ( have_posts() ) :
	the_post();
	?>
<section class="legal-page" data-block="legal-page" id="top">
	<div class="aeon-container">
		<h1 class="legal-page__title t-display-tight"><?php the_title(); ?></h1>
		<div class="legal-page__content">
			<?php the_content(); ?>
		</div>
	</div>
</section>
	<?php
endwhile;

get_footer();

<?php
/**
 * Template Name: Blog Archive
 * Template Post Type: page
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( post_password_required( get_queried_object_id() ) ) {
	require __DIR__ . '/page.php';
	return;
}

get_header();

get_template_part( 'template-parts/layouts/page_hero', null, array(
	'layout' => array(
		'dark'          => true,
		'plain_layout'  => true,
		'breadcrumb'    => get_the_title(),
		'title'         => aeon_field( 'blog_hero_title' ) ?: get_the_title(),
		'title_accent'  => aeon_field( 'blog_hero_title_accent' ),
		'lead'          => aeon_field( 'blog_hero_lead' ),
	),
) );

$paged = max( 1, (int) get_query_var( 'paged' ), (int) get_query_var( 'page' ) );

// Category filter runs on the server (?category=slug), so it covers every post
// across all pages — not just the 12 shown — and works for categories with or
// without sub-categories. A parent category also includes its children's posts.
$blog_url    = get_permalink();
$current     = isset( $_GET['category'] ) && is_string( $_GET['category'] ) ? sanitize_title( wp_unslash( $_GET['category'] ) ) : '';
$current_cat = $current ? get_category_by_slug( $current ) : false;
if ( ! $current_cat || is_wp_error( $current_cat ) ) {
	$current_cat = false;
	$current = '';
}
$active_group = $current_cat ? ( $current_cat->parent ? get_category( $current_cat->parent ) : $current_cat ) : null;

$query_args = array(
	'post_type'      => 'post',
	'posts_per_page' => 12,
	'paged'          => $paged,
);
if ( $current_cat ) {
	$query_args['cat'] = $current_cat->term_id; // includes child categories
}
$blog_query = new WP_Query( $query_args );

$top_groups = get_categories( array( 'parent' => 0, 'hide_empty' => false, 'exclude' => array( get_option( 'default_category' ) ) ) );
$filter_url = function ( $slug = '' ) use ( $blog_url ) {
	return $slug ? add_query_arg( 'category', $slug, $blog_url ) . '#posts' : $blog_url . '#posts';
};
?>
<section class="aeon-section" data-block="post-grid" id="posts">
	<div class="aeon-container" data-filter-count="post">
		<div class="section-title">
			<div>
				<h2 class="section-title__heading t-display-tight"><?php echo $current_cat ? esc_html( $current_cat->name ) : 'All Posts'; ?></h2>
			</div>
			<?php if ( ! empty( $top_groups ) ) : ?>
			<div class="section-title__aside">
				<div class="filter-chips" role="group" aria-label="Filter posts">
					<a class="filter-chips__btn<?php echo $active_group ? '' : ' is-active'; ?>" href="<?php echo esc_url( $filter_url() ); ?>"<?php echo $active_group ? '' : ' aria-current="page"'; ?>>All</a>
					<?php foreach ( $top_groups as $group ) :
						$on = $active_group && (int) $active_group->term_id === (int) $group->term_id;
						?>
						<a class="filter-chips__btn<?php echo $on ? ' is-active' : ''; ?>" href="<?php echo esc_url( $filter_url( $group->slug ) ); ?>"<?php echo $on ? ' aria-current="page"' : ''; ?>><?php echo esc_html( $group->name ); ?></a>
					<?php endforeach; ?>
				</div>
			</div>
			<?php endif; ?>
		</div>
		<div class="filter-meta">
			<p class="filter-meta__count t-mono"><?php echo (int) $blog_query->found_posts; ?> <?php echo 1 === (int) $blog_query->found_posts ? 'post' : 'posts'; ?></p>
			<?php if ( $active_group ) :
				$children = get_categories( array( 'parent' => $active_group->term_id, 'hide_empty' => false ) );
				if ( ! empty( $children ) ) :
					?>
				<div class="filter-meta__subtags">
					<?php foreach ( $children as $child ) :
						$on = $current_cat && (int) $current_cat->term_id === (int) $child->term_id;
						?>
						<a class="filter-subtag t-mono<?php echo $on ? ' is-active' : ''; ?>" href="<?php echo esc_url( $filter_url( $on ? $active_group->slug : $child->slug ) ); ?>"><?php echo esc_html( $child->name ); ?></a>
					<?php endforeach; ?>
				</div>
			<?php endif; endif; ?>
		</div>
		<div class="post-grid">
			<?php if ( $blog_query->have_posts() ) : while ( $blog_query->have_posts() ) : $blog_query->the_post();
				// Label on the card: the post's sub-category if it has one, otherwise its main category.
				$cats      = get_the_category();
				$label_cat = null;
				foreach ( $cats as $cat ) {
					if ( $cat->parent ) {
						$label_cat = $cat;
						break;
					}
				}
				if ( ! $label_cat ) {
					foreach ( $cats as $cat ) {
						if ( (int) $cat->term_id !== (int) get_option( 'default_category' ) ) {
							$label_cat = $cat;
							break;
						}
					}
				}
				$word_count = str_word_count( wp_strip_all_tags( get_the_content() ) );
				$read_min = max( 1, (int) ceil( $word_count / 200 ) );
				?>
				<article class="post-card">
					<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?>
						<a class="post-card__media" href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'aeon-card' ); ?></a>
					<?php endif; ?>
					<div class="post-card__body">
						<?php if ( $label_cat ) : ?><a class="post-card__tag t-mono" href="<?php echo esc_url( $filter_url( $label_cat->slug ) ); ?>"><?php echo esc_html( $label_cat->name ); ?></a><?php endif; ?>
						<h3 class="post-card__title t-display-tight"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
						<p class="post-card__excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 22 ) ); ?></p>
						<p class="post-card__meta t-mono"><?php echo esc_html( get_the_date( 'F Y' ) ); ?> &middot; <?php echo (int) $read_min; ?> min</p>
					</div>
				</article>
			<?php endwhile; else : ?>
				<p class="u-muted"><?php echo $current_cat ? 'No posts in this category yet.' : 'No posts yet.'; ?></p>
			<?php endif; ?>
		</div>
		<?php
		$pagination = paginate_links( array(
			'total'     => $blog_query->max_num_pages,
			'current'   => $paged,
			'mid_size'  => 2,
			'prev_text' => '&larr; Prev',
			'next_text' => 'Next &rarr;',
			'type'      => 'list',
			'add_args'  => $current ? array( 'category' => $current ) : false,
		) );
		if ( $pagination ) :
			?>
			<nav class="pagination" aria-label="Posts pagination"><?php echo wp_kses_post( $pagination ); ?></nav>
		<?php endif; ?>
		<?php wp_reset_postdata(); ?>
	</div>
</section>

<script>
/* Blog filter without page reload: chips, sub-tags, card labels and pagination load
   the new list over fetch and swap only the #posts section. The links stay normal
   links, so it still works without JavaScript, and the URL/Back button stay correct. */
(function () {
	var section = document.getElementById('posts');
	if (!section || !window.fetch || !window.DOMParser) { return; }
	var busy = false;

	function load(url, push) {
		if (busy) { window.location.href = url; return; }
		busy = true;
		section.setAttribute('aria-busy', 'true');
		fetch(url, { credentials: 'same-origin' })
			.then(function (r) { if (!r.ok) { throw new Error(r.status); } return r.text(); })
			.then(function (html) {
				var fresh = new DOMParser().parseFromString(html, 'text/html').getElementById('posts');
				if (!fresh) { throw new Error('no #posts'); }
				section.innerHTML = fresh.innerHTML;
				if (push) { history.pushState(null, '', url); }
				var top = section.getBoundingClientRect().top + window.pageYOffset - 140;
				if (window.pageYOffset > top) { window.scrollTo(0, top); }
			})
			.catch(function () { window.location.href = url; })
			.then(function () {
				busy = false;
				section.removeAttribute('aria-busy');
			});
	}

	section.addEventListener('click', function (e) {
		var a = e.target.closest('.filter-chips__btn, .filter-subtag, .post-card__tag, .pagination a');
		if (!a || !a.href || e.metaKey || e.ctrlKey || e.shiftKey || e.button !== 0) { return; }
		e.preventDefault();
		load(a.href, true);
	});

	window.addEventListener('popstate', function () {
		load(window.location.href, false);
	});
})();
</script>
<?php

get_template_part( 'template-parts/blog-cta' );
get_footer();

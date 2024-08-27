<?php
/**
 * Index template
 *
 * @author   <Author>
 * @version  1.0.0
 * @package  <Package>
 */

get_header();
if ( have_posts() ) {
	while ( have_posts() ) {
		the_post();
		?>
		<article  data-scroll-section>
			<header>
				<h1 class="xl"><?php the_title(); ?></h1>
			</header>
			<?php the_content(); ?>
		</article>
		<?php
	}
}
get_footer();

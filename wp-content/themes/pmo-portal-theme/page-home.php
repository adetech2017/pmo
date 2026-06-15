<?php
/**
 * Home Page Template
 *
 * @package PMO_Portal_Theme
 */

get_header();
?>

<main id="main-content" class="site-content">
	<?php
	if ( have_posts() ) {
		while ( have_posts() ) {
			the_post();
			?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<div class="entry-content">
					<?php the_content(); ?>
				</div>
			</article>
			<?php
		}
	}
	?>
</main>

<?php
get_footer();

<?php
/**
 * Page Template - Premium Government Platform
 *
 * @package PMO_Portal_Theme
 */

get_header();
?>

<main id="main-content" class="site-content">
  <div class="container" style="padding-top: var(--space-12); padding-bottom: var(--space-12);">
    <?php
    if ( have_posts() ) {
      while ( have_posts() ) {
        the_post();
        ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class( 'card' ); ?> style="background-color: var(--color-white); border: 1px solid var(--color-gray-100); border-radius: var(--radius-lg); padding: var(--space-8); max-width: 900px; margin: 0 auto;">

          <header style="margin-bottom: var(--space-8);">
            <h1 style="font-size: var(--font-size-h1); color: var(--color-primary); margin-bottom: var(--space-4);"><?php the_title(); ?></h1>
            <?php if ( is_singular() && ! is_front_page() ) { ?>
              <div style="color: var(--color-gray-600); font-size: var(--font-size-small);">
                Last updated: <?php echo esc_html( get_the_modified_date( 'F j, Y' ) ); ?>
              </div>
            <?php } ?>
          </header>

          <div class="entry-content" style="font-size: var(--font-size-body); line-height: var(--line-height-relaxed); color: var(--color-gray-700);">
            <?php
            the_content();
            wp_link_pages( array(
              'before' => '<div class="page-links" style="margin-top: var(--space-8);">' . esc_html__( 'Pages:', 'pmo-portal' ) . ' ',
              'after'  => '</div>',
              'link_before' => '<span style="background-color: var(--color-gray-100); padding: var(--space-2) var(--space-3); margin-right: var(--space-2); border-radius: var(--radius-sm); display: inline-block;">',
              'link_after'  => '</span>',
            ) );
            ?>
          </div>

        </article>
        <?php
      }
    }
    ?>
  </div>
</main>

<?php
get_footer();

<?php
/**
 * Single News Template - Premium Design
 *
 * @package PMO_Portal_Theme
 */

get_header();
?>

<main id="main-content" class="site-content">
  <div class="container" style="padding-top: var(--space-12); padding-bottom: var(--space-12);">
    <div style="display: grid; grid-template-columns: 1fr 300px; gap: var(--space-8);">

      <article id="post-<?php the_ID(); ?>" <?php post_class( 'card' ); ?> style="background-color: var(--color-white); border: 1px solid var(--color-gray-100); border-top: 4px solid var(--color-primary-700); border-radius: var(--radius-lg); padding: var(--space-8); background: linear-gradient(180deg, rgba(0, 61, 42, 0.02) 0%, transparent 100%);">

        <?php if ( has_post_thumbnail() ) { ?>
          <div style="margin-bottom: var(--space-8); border-radius: var(--radius-lg); overflow: hidden; border: 1px solid var(--color-gray-200);">
            <?php the_post_thumbnail( 'large' ); ?>
          </div>
        <?php } ?>

        <header style="margin-bottom: var(--space-8);">
          <h1 style="font-size: var(--font-size-h1); color: var(--color-primary-700); margin-bottom: var(--space-4);"><?php the_title(); ?></h1>
          <div style="display: flex; gap: var(--space-4); color: var(--color-gray-600); font-size: var(--font-size-small);">
            <span>By <?php the_author(); ?></span>
            <span>•</span>
            <span><?php echo esc_html( get_the_date( 'F j, Y' ) ); ?></span>
            <?php if ( get_the_modified_date( 'Ymd' ) !== get_the_date( 'Ymd' ) ) { ?>
              <span>•</span>
              <span><?php printf( esc_html__( 'Updated %s', 'pmo-portal' ), esc_html( get_the_modified_date( 'F j, Y' ) ) ); ?></span>
            <?php } ?>
          </div>
        </header>

        <div class="entry-content" style="font-size: var(--font-size-body); line-height: var(--line-height-relaxed); color: var(--color-gray-700); margin-bottom: var(--space-8);">
          <?php the_content(); ?>
        </div>

        <footer style="border-top: 1px solid var(--color-gray-200); padding-top: var(--space-8); margin-top: var(--space-8);">
          <nav style="display: flex; justify-content: space-between; gap: var(--space-4);">
            <div>
              <?php previous_post_link( '%link', '← Previous', false, '', 'pmo_news' ); ?>
            </div>
            <div>
              <a href="<?php echo esc_url( home_url( '/news' ) ); ?>" class="btn btn-outline">All News</a>
            </div>
            <div>
              <?php next_post_link( '%link', 'Next →', false, '', 'pmo_news' ); ?>
            </div>
          </nav>
        </footer>

      </article>

      <aside>
        <?php dynamic_sidebar( 'primary-sidebar' ); ?>
      </aside>

    </div>
  </div>
</main>

<?php get_footer(); ?>

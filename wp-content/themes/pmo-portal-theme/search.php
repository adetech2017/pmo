<?php
/**
 * Search Results Template - Premium Design
 *
 * @package PMO_Portal_Theme
 */

get_header();
?>

<main id="main-content" class="site-content">
  <section class="page-header" style="background: linear-gradient(135deg, var(--color-primary-dark), var(--color-primary-light)); color: var(--color-white); padding: var(--space-16) var(--container-padding-desktop);">
    <div class="container">
      <h1 style="color: var(--color-white); margin-bottom: var(--space-2);">Search Results</h1>
      <p style="color: rgba(255, 255, 255, 0.9);">
        <?php
        printf(
          esc_html__( 'Results for: %s', 'pmo-portal' ),
          '<strong>' . esc_html( get_search_query() ) . '</strong>'
        );
        ?>
      </p>
    </div>
  </section>

  <div class="container" style="padding-top: var(--space-16); padding-bottom: var(--space-16);">
    <?php if ( have_posts() ) { ?>
      <div class="grid grid-2">
        <?php while ( have_posts() ) { ?>
          <?php the_post(); ?>
          <div class="card" style="background-color: var(--color-white); border: 1px solid var(--color-gray-100); border-radius: var(--radius-lg); padding: var(--space-6); transition: all var(--transition-base);">
            <h3 style="font-size: var(--font-size-h4); margin-bottom: var(--space-3);">
              <a href="<?php the_permalink(); ?>" style="color: var(--color-primary); text-decoration: none;">
                <?php the_title(); ?>
              </a>
            </h3>
            <div style="font-size: var(--font-size-small); color: var(--color-gray-600); margin-bottom: var(--space-4);">
              <?php echo esc_html( get_post_type() ); ?> • <?php echo esc_html( get_the_date( 'M d, Y' ) ); ?>
            </div>
            <p style="font-size: var(--font-size-small); color: var(--color-gray-700); margin-bottom: var(--space-4);">
              <?php
              $excerpt = wp_trim_words( get_the_excerpt() ?: get_the_content(), 25 );
              echo esc_html( $excerpt );
              ?>
            </p>
            <a href="<?php the_permalink(); ?>" style="color: var(--color-accent); font-weight: var(--font-weight-semibold); text-decoration: none;">Read More →</a>
          </div>
        <?php } ?>
      </div>

      <div style="margin-top: var(--space-12); text-align: center;">
        <?php the_posts_pagination( array(
          'prev_text' => esc_html__( '← Previous', 'pmo-portal' ),
          'next_text' => esc_html__( 'Next →', 'pmo-portal' ),
        ) ); ?>
      </div>
    <?php } else { ?>
      <div style="text-align: center; padding: var(--space-20);">
        <h2 style="color: var(--color-primary); margin-bottom: var(--space-4);">No Results Found</h2>
        <p style="color: var(--color-gray-600); margin-bottom: var(--space-8);">
          No posts found matching your search terms. Try different keywords.
        </p>
        <form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" style="max-width: 500px; margin: 0 auto;">
          <div style="display: flex; gap: var(--space-4);">
            <input
              type="search"
              name="s"
              placeholder="Search..."
              value="<?php echo esc_attr( get_search_query() ); ?>"
              style="flex: 1; padding: var(--space-3) var(--space-4); border: 1px solid var(--color-gray-300); border-radius: var(--radius-lg); font-size: var(--font-size-body);"
            />
            <button type="submit" class="btn btn-primary">Search</button>
          </div>
        </form>
        <div style="margin-top: var(--space-12);">
          <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-outline">Back to Home</a>
        </div>
      </div>
    <?php } ?>
  </div>
</main>

<?php get_footer(); ?>

<style>
  .card:hover {
    box-shadow: var(--shadow-lg);
    border-color: var(--color-accent);
    transform: translateY(-4px);
  }
</style>

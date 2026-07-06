<?php
/**
 * Archive Projects Template - Premium Design
 *
 * @package PMO_Portal_Theme
 */

get_header();
?>

<main id="main-content" class="site-content">
  <section class="page-header" style="background: linear-gradient(135deg, var(--color-primary-dark), var(--color-primary-light)); color: var(--color-white); padding: var(--space-16) var(--container-padding-desktop);">
    <div class="container">
      <h1 style="color: var(--color-white); margin-bottom: var(--space-2);">Programmes & Projects</h1>
      <p style="color: rgba(255, 255, 255, 0.9); margin-bottom: 0;">Discover all projects and monitoring programmes</p>
    </div>
  </section>

  <div class="container" style="padding-top: var(--space-16); padding-bottom: var(--space-16);">
    <?php if ( have_posts() ) { ?>
      <div class="grid grid-3">
        <?php while ( have_posts() ) { ?>
          <?php the_post(); ?>
          <div class="card" style="background-color: var(--color-white); border: 1px solid var(--color-gray-100); border-radius: var(--radius-lg); overflow: hidden; transition: all var(--transition-base);">
            <?php if ( has_post_thumbnail() ) { ?>
              <div style="height: 200px; overflow: hidden; background: linear-gradient(135deg, var(--color-primary-dark), var(--color-primary-light));">
                <?php the_post_thumbnail( 'medium', array( 'style' => 'width: 100%; height: 100%; object-fit: cover;' ) ); ?>
              </div>
            <?php } ?>
            <div style="padding: var(--space-6);">
              <h3 style="font-size: var(--font-size-h4); margin-bottom: var(--space-3);">
                <a href="<?php the_permalink(); ?>" style="color: var(--color-primary); text-decoration: none;">
                  <?php the_title(); ?>
                </a>
              </h3>
              <p style="font-size: var(--font-size-small); color: var(--color-gray-600); margin-bottom: var(--space-4);">
                <?php echo esc_html( wp_trim_words( get_the_excerpt(), 15 ) ); ?>
              </p>
              <?php
              $progress = get_post_meta( get_the_ID(), '_pmo_progress_percentage', true );
              if ( $progress ) {
              ?>
              <div style="margin-bottom: var(--space-4);">
                <div style="font-size: var(--font-size-caption); color: var(--color-gray-600); margin-bottom: var(--space-2);">Progress</div>
                <div style="height: 6px; background: var(--color-gray-200); border-radius: var(--radius-full); overflow: hidden;">
                  <div style="background: var(--color-success); height: 100%; width: <?php echo esc_attr( $progress ); ?>%; transition: width 0.3s;"></div>
                </div>
              </div>
              <?php } ?>
              <a href="<?php the_permalink(); ?>" class="btn btn-primary" style="width: 100%; text-align: center;">View Details</a>
            </div>
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
        <h2 style="color: var(--color-primary); margin-bottom: var(--space-4);">No Projects Found</h2>
        <p style="color: var(--color-gray-600); margin-bottom: var(--space-8);">Check back soon for upcoming projects</p>
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-primary">Back to Home</a>
      </div>
    <?php } ?>
  </div>
</main>

<style>
  .card:hover {
    box-shadow: var(--shadow-lg);
    border-color: var(--color-accent-dark);
    transform: translateY(-4px);
  }
</style>

<?php get_footer(); ?>

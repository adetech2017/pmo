<?php
/**
 * 404 Not Found Page - Premium Design
 *
 * @package PMO_Portal_Theme
 */

get_header();
?>

<main id="main-content" class="site-content">
  <div style="background: linear-gradient(135deg, var(--color-primary-dark), var(--color-primary-light)); color: var(--color-white); padding: var(--space-32) var(--container-padding-desktop); text-align: center;">
    <div class="container">
      <div style="font-size: 6rem; font-weight: var(--font-weight-bold); margin-bottom: var(--space-4);">404</div>
      <h1 style="color: var(--color-white); font-size: var(--font-size-h1); margin-bottom: var(--space-4);">Page Not Found</h1>
      <p style="font-size: var(--font-size-body-lg); color: rgba(255, 255, 255, 0.9); margin-bottom: var(--space-8); max-width: 500px; margin-left: auto; margin-right: auto;">
        The page you're looking for doesn't exist. It may have been moved or deleted.
      </p>
      <div style="display: flex; gap: var(--space-4); justify-content: center;">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-secondary">Back to Homepage</a>
        <a href="<?php echo esc_url( home_url( '/projects' ) ); ?>" class="btn btn-outline" style="background-color: var(--color-white); color: var(--color-primary); border: 1.5px solid var(--color-white);">View Projects</a>
      </div>
    </div>
  </div>

  <section style="padding: var(--space-20) var(--container-padding-desktop);">
    <div class="container">
      <h2 style="text-align: center; margin-bottom: var(--space-12);">Quick Links</h2>
      <div class="grid grid-3">
        <div class="card" style="background-color: var(--color-white); border: 1px solid var(--color-gray-100); border-radius: var(--radius-lg); padding: var(--space-6); text-align: center;">
          <div style="font-size: 2rem; margin-bottom: var(--space-4);">📰</div>
          <h3 style="font-size: var(--font-size-h4); margin-bottom: var(--space-3);">Latest News</h3>
          <p style="color: var(--color-gray-600); margin-bottom: var(--space-4);">Stay updated with PMO news</p>
          <a href="<?php echo esc_url( home_url( '/news' ) ); ?>" class="btn btn-primary">Read News</a>
        </div>

        <div class="card" style="background-color: var(--color-white); border: 1px solid var(--color-gray-100); border-radius: var(--radius-lg); padding: var(--space-6); text-align: center;">
          <div style="font-size: 2rem; margin-bottom: var(--space-4);">📅</div>
          <h3 style="font-size: var(--font-size-h4); margin-bottom: var(--space-3);">Upcoming Events</h3>
          <p style="color: var(--color-gray-600); margin-bottom: var(--space-4);">Join our events</p>
          <a href="<?php echo esc_url( home_url( '/events' ) ); ?>" class="btn btn-primary">View Events</a>
        </div>

        <div class="card" style="background-color: var(--color-white); border: 1px solid var(--color-gray-100); border-radius: var(--radius-lg); padding: var(--space-6); text-align: center;">
          <div style="font-size: 2rem; margin-bottom: var(--space-4);">👥</div>
          <h3 style="font-size: var(--font-size-h4); margin-bottom: var(--space-3);">Our Team</h3>
          <p style="color: var(--color-gray-600); margin-bottom: var(--space-4);">Meet the leadership</p>
          <a href="<?php echo esc_url( home_url( '/leadership' ) ); ?>" class="btn btn-primary">See Team</a>
        </div>
      </div>
    </div>
  </section>
</main>

<?php get_footer(); ?>

<style>
  .card:hover {
    box-shadow: var(--shadow-lg);
    border-color: var(--color-accent);
    transform: translateY(-4px);
  }
</style>

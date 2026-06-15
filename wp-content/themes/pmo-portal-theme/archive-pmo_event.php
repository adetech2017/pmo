<?php
/**
 * Archive Events Template - Premium Design
 *
 * @package PMO_Portal_Theme
 */

get_header();
?>

<main id="main-content" class="site-content">
  <!-- Hero Section -->
  <section class="events-hero">
    <div class="events-hero-bg"></div>
    <div class="container" style="position: relative; z-index: 2;">
      <h1>Upcoming Events</h1>
      <p>Join us at our upcoming events and programmes</p>
    </div>
  </section>

  <!-- Events Grid -->
  <section class="section">
    <div class="container">
      <?php if ( have_posts() ) { ?>
        <div class="events-grid">
          <?php while ( have_posts() ) { ?>
            <?php the_post(); ?>
            <?php
            $event_date = get_post_meta( get_the_ID(), '_event_date', true );
            $event_time = get_post_meta( get_the_ID(), '_event_time', true );
            $event_venue = get_post_meta( get_the_ID(), '_event_venue', true );
            ?>
            <article class="event-card">
              <div class="event-date-box">
                <div class="event-day">
                  <?php echo esc_html( $event_date ? date( 'd', strtotime( $event_date ) ) : 'TBA' ); ?>
                </div>
                <div class="event-month">
                  <?php echo esc_html( $event_date ? date( 'M', strtotime( $event_date ) ) : '' ); ?>
                </div>
              </div>

              <div class="event-content">
                <h3>
                  <a href="<?php the_permalink(); ?>">
                    <?php the_title(); ?>
                  </a>
                </h3>

                <?php if ( $event_time ) { ?>
                  <div class="event-meta">
                    <i class="fas fa-clock"></i>
                    <span><?php echo esc_html( $event_time ); ?></span>
                  </div>
                <?php } ?>

                <?php if ( $event_venue ) { ?>
                  <div class="event-meta">
                    <i class="fas fa-map-marker-alt"></i>
                    <span><?php echo esc_html( $event_venue ); ?></span>
                  </div>
                <?php } ?>

                <div class="event-excerpt">
                  <?php echo wp_kses_post( get_the_excerpt() ); ?>
                </div>

                <a href="<?php the_permalink(); ?>" class="btn btn-primary btn-sm">Learn More</a>
              </div>
            </article>
          <?php } ?>
        </div>

        <?php the_posts_pagination( array(
          'prev_text' => esc_html__( '← Previous', 'pmo-portal' ),
          'next_text' => esc_html__( 'Next →', 'pmo-portal' ),
        ) ); ?>
      <?php } else { ?>
        <div class="no-events">
          <h2>No Events Found</h2>
          <p>Check back soon for upcoming events</p>
          <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-primary">Back to Home</a>
        </div>
      <?php } ?>
    </div>
  </section>
</main>

<?php get_footer(); ?>

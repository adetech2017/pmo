<?php
/**
 * Single Event Template - Premium Design
 *
 * @package PMO_Portal_Theme
 */

get_header();
?>

<main id="main-content" class="site-content">
  <section class="section single-event-section">
    <div class="container">
      <article class="single-event-card">

        <?php if ( has_post_thumbnail() ) { ?>
          <div class="event-featured-image">
            <?php the_post_thumbnail( 'large' ); ?>
          </div>
        <?php } ?>

        <header class="event-header">
          <h1><?php the_title(); ?></h1>
        </header>

        <?php
        $event_date = get_post_meta( get_the_ID(), '_event_date', true );
        $event_time = get_post_meta( get_the_ID(), '_event_time', true );
        $event_venue = get_post_meta( get_the_ID(), '_event_venue', true );
        $event_contact = get_post_meta( get_the_ID(), '_event_contact', true );
        ?>

        <div class="event-details-box">
          <div class="event-details-grid">
            <?php if ( $event_date ) { ?>
              <div class="event-detail">
                <div class="event-detail-icon">
                  <i class="fas fa-calendar-alt"></i>
                </div>
                <div class="event-detail-content">
                  <label>Date</label>
                  <p><?php echo esc_html( date( 'F j, Y', strtotime( $event_date ) ) ); ?></p>
                </div>
              </div>
            <?php } ?>

            <?php if ( $event_time ) { ?>
              <div class="event-detail">
                <div class="event-detail-icon">
                  <i class="fas fa-clock"></i>
                </div>
                <div class="event-detail-content">
                  <label>Time</label>
                  <p><?php echo esc_html( $event_time ); ?></p>
                </div>
              </div>
            <?php } ?>

            <?php if ( $event_venue ) { ?>
              <div class="event-detail">
                <div class="event-detail-icon">
                  <i class="fas fa-map-marker-alt"></i>
                </div>
                <div class="event-detail-content">
                  <label>Venue</label>
                  <p><?php echo esc_html( $event_venue ); ?></p>
                </div>
              </div>
            <?php } ?>

            <?php if ( $event_contact ) { ?>
              <div class="event-detail">
                <div class="event-detail-icon">
                  <i class="fas fa-phone"></i>
                </div>
                <div class="event-detail-content">
                  <label>Contact</label>
                  <p><?php echo esc_html( $event_contact ); ?></p>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>

        <div class="event-body">
          <?php the_content(); ?>
        </div>

        <footer class="event-footer">
          <a href="<?php echo esc_url( home_url( '/events' ) ); ?>" class="btn btn-primary">
            <i class="fas fa-arrow-left"></i> Back to Events
          </a>
        </footer>

      </article>
    </div>
  </section>
</main>

<?php get_footer(); ?>

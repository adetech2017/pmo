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
  <section style="background: linear-gradient(135deg, var(--color-primary-700) 0%, var(--color-primary-600) 50%, var(--color-info) 100%); color: var(--color-white); padding: var(--space-20) var(--container-padding-desktop); position: relative; overflow: hidden;">
    <!-- Decorative elements -->
    <div style="position: absolute; top: -50%; right: -10%; width: 800px; height: 800px; background: radial-gradient(circle, rgba(201, 162, 39, 0.12) 0%, transparent 70%); border-radius: 50%; pointer-events: none; animation: float 6s ease-in-out infinite;"></div>
    <div style="position: absolute; bottom: -30%; left: -5%; width: 500px; height: 500px; background: radial-gradient(circle, rgba(79, 172, 254, 0.08) 0%, transparent 70%); border-radius: 50%; pointer-events: none; animation: float 8s ease-in-out infinite 1s;"></div>

    <div class="container" style="position: relative; z-index: 2; animation: slideInUp 0.8s ease-out;">
      <div style="display: inline-block; padding: var(--space-1) var(--space-3); background: rgba(255, 255, 255, 0.15); border-radius: var(--radius-full); margin-bottom: var(--space-4); font-size: var(--font-size-small); font-weight: 700; letter-spacing: 0.5px;">
        🎯 EVENTS & PROGRAMMES
      </div>
      <h1 style="color: var(--color-white); margin-bottom: var(--space-4); font-size: clamp(2.5rem, 5vw, 3.5rem); font-weight: 800; letter-spacing: -0.02em;">Upcoming Events</h1>
      <p style="color: rgba(255, 255, 255, 0.95); font-size: var(--font-size-body-lg); line-height: var(--line-height-relaxed); max-width: 600px; font-weight: 400;">Join us at our upcoming events, workshops, and programmes</p>
    </div>
  </section>

  <!-- Events Grid -->
  <section class="section" style="background: var(--color-white);">
    <div class="container">
      <?php if ( have_posts() ) { ?>
        <div style="margin-bottom: var(--space-12); animation: slideInUp 0.8s ease-out;">
          <h2 style="font-size: clamp(2rem, 4vw, 2.5rem); margin-bottom: var(--space-3); font-weight: 800; color: var(--color-primary-700);">Event Calendar</h2>
          <div style="width: 120px; height: 5px; background: linear-gradient(90deg, var(--color-primary-700), var(--color-accent)); border-radius: 3px;"></div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: var(--space-8); margin-bottom: var(--space-16);">
          <?php
          $event_index = 0;
          while ( have_posts() ) {
            the_post();
            $event_date = get_post_meta( get_the_ID(), '_event_date', true );
            $event_time = get_post_meta( get_the_ID(), '_event_time', true );
            $event_venue = get_post_meta( get_the_ID(), '_event_venue', true );
            $event_contact = get_post_meta( get_the_ID(), '_event_contact', true );
            $delay = ( $event_index % 6 ) * 0.1;
            $event_index++;
            ?>
            <article class="event-card" style="background: var(--color-white); border-radius: var(--radius-xl); overflow: hidden; box-shadow: var(--shadow-md); border-top: 5px solid var(--color-accent); transition: all var(--transition-base); display: flex; flex-direction: column; opacity: 0; transform: translateY(30px); animation: slideInUp 0.6s ease-out forwards; animation-delay: <?php echo $delay; ?>s;">

              <!-- Date Badge Section -->
              <div style="padding: var(--space-6); background: linear-gradient(135deg, var(--color-accent), rgba(201, 162, 39, 0.8)); color: var(--color-white);">
                <div style="display: flex; align-items: flex-start; justify-content: space-between; gap: var(--space-4);">
                  <!-- Large Date Display -->
                  <div style="flex: 1;">
                    <div style="font-size: 2.5rem; font-weight: 800; line-height: 1;">
                      <?php echo esc_html( $event_date ? date( 'd', strtotime( $event_date ) ) : 'TBA' ); ?>
                    </div>
                    <div style="font-size: var(--font-size-body-lg); font-weight: 600; opacity: 0.95;">
                      <?php echo esc_html( $event_date ? date( 'F Y', strtotime( $event_date ) ) : 'Date TBA' ); ?>
                    </div>
                  </div>
                  <!-- Days Away -->
                  <?php
                  if ( $event_date ) {
                    $time = strtotime( $event_date );
                    $now = time();
                    $days = ceil( ( $time - $now ) / 86400 );
                    if ( $days >= 0 ) {
                      $status_color = $days <= 7 ? 'var(--color-danger)' : ($days <= 30 ? 'var(--color-warning)' : 'var(--color-success)');
                      ?>
                      <div style="background: rgba(255, 255, 255, 0.2); padding: var(--space-2) var(--space-3); border-radius: var(--radius-sm); text-align: center; min-width: 80px;">
                        <div style="font-size: var(--font-size-small); font-weight: 700; margin-bottom: var(--space-1);">
                          <?php echo $days; ?> Days
                        </div>
                        <div style="font-size: var(--font-size-caption); opacity: 0.9;">Away</div>
                      </div>
                      <?php
                    }
                  }
                  ?>
                </div>
              </div>

              <!-- Content -->
              <div style="padding: var(--space-6); flex: 1; display: flex; flex-direction: column;">

                <!-- Title -->
                <h3 style="margin-bottom: var(--space-4); font-size: 1.2rem; line-height: 1.4; font-weight: 700;">
                  <a href="<?php the_permalink(); ?>" style="color: var(--color-primary-700); text-decoration: none; transition: color var(--transition-fast);">
                    <?php the_title(); ?>
                  </a>
                </h3>

                <!-- Event Meta Info -->
                <div style="margin-bottom: var(--space-4); display: flex; flex-direction: column; gap: var(--space-3);">
                  <?php if ( $event_time ) { ?>
                    <div style="display: flex; align-items: center; gap: var(--space-2); color: var(--color-gray-700); font-size: var(--font-size-small);">
                      <span style="font-size: 1.1rem;">⏰</span>
                      <span style="font-weight: 600;"><?php echo esc_html( $event_time ); ?></span>
                    </div>
                  <?php } ?>

                  <?php if ( $event_venue ) { ?>
                    <div style="display: flex; align-items: center; gap: var(--space-2); color: var(--color-gray-700); font-size: var(--font-size-small);">
                      <span style="font-size: 1.1rem;">📍</span>
                      <span style="font-weight: 600;"><?php echo esc_html( $event_venue ); ?></span>
                    </div>
                  <?php } ?>

                  <?php if ( $event_contact ) { ?>
                    <div style="display: flex; align-items: center; gap: var(--space-2); color: var(--color-gray-700); font-size: var(--font-size-small);">
                      <span style="font-size: 1.1rem;">📞</span>
                      <span style="font-weight: 600;"><?php echo esc_html( $event_contact ); ?></span>
                    </div>
                  <?php } ?>
                </div>

                <!-- Description -->
                <p style="color: var(--color-gray-600); margin-bottom: var(--space-6); line-height: var(--line-height-relaxed); font-size: var(--font-size-small); flex: 1;">
                  <?php echo wp_kses_post( get_the_excerpt() ); ?>
                </p>

                <!-- CTA Button -->
                <a href="<?php the_permalink(); ?>" style="display: inline-flex; align-items: center; gap: var(--space-2); padding: var(--space-3) var(--space-6); background: linear-gradient(135deg, var(--color-primary-700), var(--color-primary-600)); color: var(--color-white); border-radius: var(--radius-lg); text-decoration: none; font-weight: 700; transition: all var(--transition-base); box-shadow: var(--shadow-sm); font-size: var(--font-size-small); width: fit-content;">
                  Register Now <span style="font-size: 1.1rem;">→</span>
                </a>
              </div>
            </article>
          <?php } ?>
        </div>

        <!-- Pagination -->
        <div style="margin-top: var(--space-16); text-align: center;">
          <?php the_posts_pagination( array(
            'prev_text' => '← Previous',
            'next_text' => 'Next →',
            'class'     => 'pagination',
          ) ); ?>
        </div>

      <?php } else { ?>
        <div style="text-align: center; padding: var(--space-20); background: var(--color-gray-50); border-radius: var(--radius-xl); animation: slideInUp 0.8s ease-out;">
          <div style="font-size: 4rem; margin-bottom: var(--space-4); animation: float 3s ease-in-out infinite;">🎯</div>
          <h2 style="color: var(--color-primary-700); margin-bottom: var(--space-4); font-size: 1.8rem; font-weight: 800;">No Events Found</h2>
          <p style="color: var(--color-gray-600); margin-bottom: var(--space-8); font-size: var(--font-size-body-lg); line-height: var(--line-height-relaxed);">Check back soon for upcoming events and programmes</p>
          <a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="display: inline-block; padding: var(--space-3) var(--space-8); background: linear-gradient(135deg, var(--color-primary-700), var(--color-primary-600)); color: var(--color-white); border-radius: var(--radius-lg); text-decoration: none; font-weight: 700; transition: all var(--transition-base); box-shadow: var(--shadow-md);">Back to Home</a>
        </div>
      <?php } ?>
    </div>
  </section>
</main>

<?php get_footer(); ?>

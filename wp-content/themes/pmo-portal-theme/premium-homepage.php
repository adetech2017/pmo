<?php
/**
 * Premium Homepage Template - Executive Government Design
 *
 * Sections:
 * 1. Hero Section
 * 2. Executive Director Message
 * 3. Mission, Vision, Mandate
 * 4. Impact Dashboard
 * 5. Programmes Preview
 * 6. Latest News
 * 7. Upcoming Events
 * 8. Gallery Preview
 * 9. Call to Action
 *
 * @package PMO_Portal_Theme
 */

get_header();
?>

<main id="main-content" class="site-content">

  <!-- ========== HERO SECTION ========== -->
  <section class="hero-premium" style="background: linear-gradient(135deg, var(--color-primary-dark) 0%, var(--color-primary) 100%); color: var(--color-white); padding: var(--space-20) 0; position: relative; overflow: hidden;">
    <div style="position: absolute; top: -50%; right: -10%; width: 600px; height: 600px; background: radial-gradient(circle, rgba(201, 162, 39, 0.1) 0%, transparent 70%); border-radius: 50%; pointer-events: none;"></div>

    <div class="container" style="position: relative; z-index: 2;">
      <div style="max-width: 800px;">
        <h1 style="font-size: var(--font-size-display); color: var(--color-white); margin-bottom: var(--space-3); line-height: 1.1;">
          Driving Accountability and Excellence Across Lagos State Parastatals
        </h1>
        <p style="font-size: var(--font-size-body-lg); color: rgba(255, 255, 255, 0.95); margin-bottom: var(--space-6); line-height: var(--line-height-relaxed); max-width: 600px;">
          The Lagos State Parastatals Monitoring Office ensures transparent, accountable, and efficient delivery of services across government agencies and public institutions.
        </p>
        <div style="display: flex; gap: var(--space-3); flex-wrap: wrap;">
          <a href="#programmes" class="btn btn-primary">Explore Programmes</a>
          <a href="#contact" class="btn" style="background: var(--color-white); color: var(--color-primary); font-weight: var(--font-weight-semibold); padding: var(--space-2) var(--space-3); border-radius: var(--radius-lg); text-decoration: none;">Contact Us</a>
        </div>
      </div>
    </div>
  </section>

  <!-- ========== EXECUTIVE MESSAGE ========== -->
  <section class="section" style="background: var(--color-white);">
    <div class="container">
      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: var(--space-8); align-items: center;">
        <div style="background: linear-gradient(135deg, var(--color-primary-dark), var(--color-primary)); border-radius: var(--radius-2xl); height: 400px; display: flex; align-items: center; justify-content: center; color: var(--color-white); font-size: 4rem;">
          👤
        </div>
        <div>
          <span class="badge badge-accent" style="margin-bottom: var(--space-3);">EXECUTIVE LEADERSHIP</span>
          <h2 style="margin-bottom: var(--space-3);">Executive Director's Message</h2>
          <p style="font-size: var(--font-size-body-lg); margin-bottom: var(--space-4);">
            The Lagos State Parastatals Monitoring Office is committed to ensuring that all state-owned enterprises and government agencies operate with the highest standards of transparency, accountability, and efficiency.
          </p>
          <p style="margin-bottom: var(--space-4);">
            Through rigorous monitoring, strategic guidance, and collaborative partnerships, we drive institutional excellence and deliver sustainable value to the people of Lagos State.
          </p>
          <p style="color: var(--color-gray-600); font-style: italic;">
            — Executive Director, PMO Lagos State
          </p>
        </div>
      </div>
    </div>
  </section>

  <!-- ========== MISSION, VISION, MANDATE ========== -->
  <section class="section" style="background: var(--color-gray-50);">
    <div class="container">
      <div style="text-align: center; margin-bottom: var(--space-10);">
        <h2>Our Foundation</h2>
        <p style="font-size: var(--font-size-body-lg); max-width: 600px; margin: var(--space-3) auto;">
          Mission, Vision, and Strategic Mandate
        </p>
      </div>

      <div class="grid grid-3">
        <!-- Mission -->
        <div class="card" style="text-align: center;">
          <div style="font-size: 3rem; margin-bottom: var(--space-4);">🎯</div>
          <h3>Our Mission</h3>
          <p>To ensure transparent, accountable, and efficient governance across Lagos State parastatals through rigorous monitoring and strategic oversight.</p>
        </div>

        <!-- Vision -->
        <div class="card" style="text-align: center;">
          <div style="font-size: 3rem; margin-bottom: var(--space-4);">🌟</div>
          <h3>Our Vision</h3>
          <p>A Lagos State where all public institutions operate with world-class standards of performance, accountability, and public-sector excellence.</p>
        </div>

        <!-- Mandate -->
        <div class="card" style="text-align: center;">
          <div style="font-size: 3rem; margin-bottom: var(--space-4);">⚖️</div>
          <h3>Our Mandate</h3>
          <p>Monitor, evaluate, and improve the performance of all state-owned enterprises and parastatals to maximize public value and institutional effectiveness.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- ========== IMPACT DASHBOARD ========== -->
  <section class="section" style="background: var(--color-white);">
    <div class="container">
      <div style="text-align: center; margin-bottom: var(--space-10);">
        <h2>Impact at a Glance</h2>
        <p style="color: var(--color-gray-600);">Key Government Performance Metrics</p>
      </div>

      <div class="grid grid-4">
        <div class="card" style="text-align: center; border-left: 4px solid var(--color-primary); padding: var(--space-4);">
          <div style="font-size: 2.5rem; font-weight: var(--font-weight-bold); color: var(--color-primary); margin-bottom: var(--space-2);">47</div>
          <div style="font-size: var(--font-size-small); color: var(--color-gray-600); font-weight: var(--font-weight-semibold); text-transform: uppercase;">Parastatals Monitored</div>
        </div>

        <div class="card" style="text-align: center; border-left: 4px solid var(--color-accent); padding: var(--space-4);">
          <div style="font-size: 2.5rem; font-weight: var(--font-weight-bold); color: var(--color-accent); margin-bottom: var(--space-2);">156</div>
          <div style="font-size: var(--font-size-small); color: var(--color-gray-600); font-weight: var(--font-weight-semibold); text-transform: uppercase;">Audits Conducted</div>
        </div>

        <div class="card" style="text-align: center; border-left: 4px solid var(--color-success); padding: var(--space-4);">
          <div style="font-size: 2.5rem; font-weight: var(--font-weight-bold); color: var(--color-success); margin-bottom: var(--space-2);">89</div>
          <div style="font-size: var(--font-size-small); color: var(--color-gray-600); font-weight: var(--font-weight-semibold); text-transform: uppercase;">Improvements Implemented</div>
        </div>

        <div class="card" style="text-align: center; border-left: 4px solid var(--color-primary-light); padding: var(--space-4);">
          <div style="font-size: 2.5rem; font-weight: var(--font-weight-bold); color: var(--color-primary-light); margin-bottom: var(--space-2);">34</div>
          <div style="font-size: var(--font-size-small); color: var(--color-gray-600); font-weight: var(--font-weight-semibold); text-transform: uppercase;">Capacity Sessions</div>
        </div>
      </div>
    </div>
  </section>

  <!-- ========== PROGRAMMES PREVIEW ========== -->
  <section class="section" id="programmes" style="background: var(--color-gray-50);">
    <div class="container">
      <div style="text-align: center; margin-bottom: var(--space-10);">
        <h2>Strategic Programmes</h2>
        <p style="color: var(--color-gray-600);">Key Focus Areas and Monitoring Initiatives</p>
      </div>

      <div class="grid grid-3">
        <div class="card" style="display: flex; flex-direction: column;">
          <div style="font-size: 2.5rem; margin-bottom: var(--space-4);">🚛</div>
          <h4>Transportation & Infrastructure</h4>
          <p style="flex: 1;">Monitoring efficiency and service delivery in transport-related parastatals and infrastructure agencies.</p>
          <a href="#" class="btn btn-primary" style="align-self: flex-start; margin-top: var(--space-4);">Learn More</a>
        </div>

        <div class="card" style="display: flex; flex-direction: column;">
          <div style="font-size: 2.5rem; margin-bottom: var(--space-4);">🏥</div>
          <h4>Health & Wellness</h4>
          <p style="flex: 1;">Ensuring quality healthcare delivery and operational excellence across health sector parastatals.</p>
          <a href="#" class="btn btn-primary" style="align-self: flex-start; margin-top: var(--space-4);">Learn More</a>
        </div>

        <div class="card" style="display: flex; flex-direction: column;">
          <div style="font-size: 2.5rem; margin-bottom: var(--space-4);">📚</div>
          <h4>Education & Development</h4>
          <p style="flex: 1;">Supporting quality education provision and institutional development in educational agencies.</p>
          <a href="#" class="btn btn-primary" style="align-self: flex-start; margin-top: var(--space-4);">Learn More</a>
        </div>
      </div>

      <div style="text-align: center; margin-top: var(--space-8);">
        <a href="/pmo/programmes/" class="btn btn-secondary">View All Programmes</a>
      </div>
    </div>
  </section>

  <!-- ========== LATEST NEWS ========== -->
  <section class="section" style="background: var(--color-white);">
    <div class="container">
      <div style="margin-bottom: var(--space-8);">
        <div style="display: flex; justify-content: space-between; align-items: center;">
          <div>
            <h2>Latest News & Updates</h2>
            <p style="color: var(--color-gray-600);">Government newsroom and press releases</p>
          </div>
          <a href="/pmo/news/" class="btn btn-outline">View All News</a>
        </div>
      </div>

      <div class="grid grid-3">
        <?php
        $news_args = array(
          'post_type'      => 'pmo_news',
          'posts_per_page' => 3,
          'orderby'        => 'date',
          'order'          => 'DESC',
        );
        $news_query = new WP_Query( $news_args );

        if ( $news_query->have_posts() ) {
          while ( $news_query->have_posts() ) {
            $news_query->the_post();
            ?>
            <article class="card">
              <div style="border-radius: var(--radius-lg); height: 180px; display: flex; align-items: center; justify-content: center; color: var(--color-white); font-size: 2.5rem; margin-bottom: var(--space-3); overflow: hidden; background: linear-gradient(135deg, var(--color-primary-dark), var(--color-primary));">
                <?php
                if ( has_post_thumbnail() ) {
                  the_post_thumbnail( 'medium', array( 'style' => 'width: 100%; height: 100%; object-fit: cover;' ) );
                } else {
                  echo '📰';
                }
                ?>
              </div>
              <div style="font-size: var(--font-size-small); color: var(--color-gray-500); margin-bottom: var(--space-2);">
                <?php echo esc_html( get_the_date( 'M d, Y' ) ); ?>
              </div>
              <h4><?php the_title(); ?></h4>
              <p style="font-size: var(--font-size-small); margin-bottom: var(--space-4);">
                <?php echo esc_html( wp_trim_words( get_the_excerpt(), 20 ) ); ?>
              </p>
              <a href="<?php the_permalink(); ?>" style="color: var(--color-accent); font-weight: var(--font-weight-semibold);">Read Full Article →</a>
            </article>
            <?php
          }
          wp_reset_postdata();
        } else {
          ?>
          <p>No news yet. Check back soon.</p>
          <?php
        }
        ?>
      </div>
    </div>
  </section>

  <!-- ========== UPCOMING EVENTS ========== -->
  <section class="section" style="background: var(--color-gray-50);">
    <div class="container">
      <div style="margin-bottom: var(--space-8);">
        <div style="display: flex; justify-content: space-between; align-items: center;">
          <div>
            <h2>Upcoming Events</h2>
            <p style="color: var(--color-gray-600);">Stakeholder engagement and capacity building</p>
          </div>
          <a href="/pmo/events/" class="btn btn-outline">View All Events</a>
        </div>
      </div>

      <div class="grid grid-3">
        <?php
        $events_args = array(
          'post_type'      => 'pmo_event',
          'posts_per_page' => 3,
          'orderby'        => 'date',
          'order'          => 'ASC',
        );
        $events_query = new WP_Query( $events_args );

        if ( $events_query->have_posts() ) {
          while ( $events_query->have_posts() ) {
            $events_query->the_post();
            $event_date = get_post_meta( get_the_ID(), '_event_date', true );
            $event_venue = get_post_meta( get_the_ID(), '_event_venue', true );
            ?>
            <div class="card">
              <div style="display: flex; align-items: center; gap: var(--space-3); margin-bottom: var(--space-4);">
                <div style="font-size: 2.5rem; font-weight: var(--font-weight-bold); color: var(--color-primary); min-width: 60px;">
                  <?php echo esc_html( $event_date ? date( 'd', strtotime( $event_date ) ) : 'TBA' ); ?>
                </div>
                <div>
                  <div style="font-size: var(--font-size-small); color: var(--color-gray-600); font-weight: var(--font-weight-semibold);">
                    <?php echo esc_html( $event_date ? date( 'M Y', strtotime( $event_date ) ) : 'Date TBA' ); ?>
                  </div>
                </div>
              </div>
              <h4><?php the_title(); ?></h4>
              <?php if ( $event_venue ) { ?>
                <p style="font-size: var(--font-size-small); color: var(--color-gray-600); margin-bottom: var(--space-4);">📍 <?php echo esc_html( $event_venue ); ?></p>
              <?php } ?>
              <a href="<?php the_permalink(); ?>" class="btn btn-primary" style="width: 100%; text-align: center;">Register</a>
            </div>
            <?php
          }
          wp_reset_postdata();
        } else {
          ?>
          <p>No events scheduled. Check back soon.</p>
          <?php
        }
        ?>
      </div>
    </div>
  </section>

  <!-- ========== CALL TO ACTION ========== -->
  <section class="section" style="background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-dark) 100%); color: var(--color-white); text-align: center;">
    <div class="container">
      <h2 style="color: var(--color-white); margin-bottom: var(--space-4);">Ready to Engage with PMO?</h2>
      <p style="font-size: var(--font-size-body-lg); color: rgba(255, 255, 255, 0.95); margin-bottom: var(--space-6); max-width: 600px; margin-left: auto; margin-right: auto;">
        Contact us to learn more about our programmes, submit reports, or schedule a meeting with our team.
      </p>
      <a href="#contact" class="btn" style="background: var(--color-white); color: var(--color-primary); padding: var(--space-2) var(--space-3); font-weight: var(--font-weight-semibold); border-radius: var(--radius-lg);">Contact Us Today</a>
    </div>
  </section>

</main>

<?php get_footer(); ?>

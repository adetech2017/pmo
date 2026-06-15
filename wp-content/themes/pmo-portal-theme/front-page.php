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

  <!-- ========== HERO CAROUSEL SECTION ========== -->
  <section class="hero-carousel">
    <div class="carousel-wrapper">
      <?php
      $carousel_args = array(
        'post_type'      => 'pmo_carousel',
        'posts_per_page' => -1,
        'orderby'        => 'menu_order',
        'order'          => 'ASC',
      );
      $carousel_query = new WP_Query( $carousel_args );

      if ( $carousel_query->have_posts() ) {
        while ( $carousel_query->have_posts() ) {
          $carousel_query->the_post();
          $subtitle = get_post_meta( get_the_ID(), '_carousel_subtitle', true );
          $button_text = get_post_meta( get_the_ID(), '_carousel_button_text', true );
          $button_link = get_post_meta( get_the_ID(), '_carousel_button_link', true );
          $image_id = get_post_thumbnail_id( get_the_ID() );
          $image_url = wp_get_attachment_image_url( $image_id, 'full' );
          ?>
          <div class="carousel-slide" style="background-image: url('<?php echo esc_url( $image_url ); ?>');">
            <div class="carousel-content">
              <h1><?php the_title(); ?></h1>
              <?php if ( $subtitle ) { ?>
                <p><?php echo esc_html( $subtitle ); ?></p>
              <?php } ?>
              <div class="carousel-buttons">
                <?php if ( $button_text && $button_link ) { ?>
                  <a href="<?php echo esc_url( $button_link ); ?>" class="btn btn-primary"><?php echo esc_html( $button_text ); ?></a>
                <?php } ?>
                <a href="#programmes" class="btn btn-light">Explore More</a>
              </div>
            </div>
          </div>
          <?php
        }
        wp_reset_postdata();
      }
      ?>
    </div>

    <!-- Carousel Navigation Dots -->
    <div class="carousel-dots">
      <?php
      for ( $i = 0; $i < $carousel_query->post_count; $i++ ) {
        ?>
        <button class="carousel-dot" data-slide="<?php echo $i; ?>" aria-label="Go to slide <?php echo $i + 1; ?>"></button>
        <?php
      }
      ?>
    </div>

    <!-- Carousel Controls -->
    <button class="carousel-nav-btn carousel-prev" aria-label="Previous slide">❮</button>
    <button class="carousel-nav-btn carousel-next" aria-label="Next slide">❯</button>
  </section>

  <!-- ========== STRATEGIC VISION SECTION ========== -->
  <section class="section vision-section">
    <div class="container">
      <div class="vision-content">
        <h2>Improve Efficiency and Effectiveness of all State-Owned Parastatals</h2>
        <p>We envision a future where every state-owned enterprise operates at peak efficiency, delivering exceptional value to the Lagos State Government and its citizens through strategic monitoring and governance excellence.</p>
      </div>
    </div>
  </section>

  <!-- ========== MISSION, VISION, MANDATE ========== -->
  <section class="section bg-gray">
    <div class="container">
      <div class="section-header">
        <h2>Our Foundation</h2>
        <p>Mission, Vision, and Strategic Mandate</p>
      </div>

      <div class="grid grid-3">
        <!-- Mission - Gold/Accent -->
        <div class="foundation-card mission">
          <div class="foundation-card-icon">🎯</div>
          <h3>Our Mission</h3>
          <p>To ensure transparent, accountable, and efficient governance across Lagos State parastatals through rigorous monitoring and strategic oversight.</p>
        </div>

        <!-- Vision - Teal/Vibrant -->
        <div class="foundation-card vision">
          <div class="foundation-card-icon">🌟</div>
          <h3>Our Vision</h3>
          <p>A Lagos State where all public institutions operate with world-class standards of performance, accountability, and public-sector excellence.</p>
        </div>

        <!-- Mandate - Indigo/Premium -->
        <div class="foundation-card mandate">
          <div class="foundation-card-icon">⚖️</div>
          <h3>Our Mandate</h3>
          <p>Monitor, evaluate, and improve the performance of all state-owned enterprises and parastatals to maximize public value and institutional effectiveness.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- ========== IMPACT DASHBOARD ========== -->
  <section class="section bg-white">
    <div class="container">
      <div class="section-header">
        <h2>Impact at a Glance</h2>
        <p>Key Government Performance Metrics</p>
      </div>

      <div class="grid grid-4">
        <div class="impact-card primary">
          <div class="impact-number">47</div>
          <div class="impact-label">Parastatals Monitored</div>
        </div>

        <div class="impact-card accent">
          <div class="impact-number">156</div>
          <div class="impact-label">Audits Conducted</div>
        </div>

        <div class="impact-card teal">
          <div class="impact-number">89</div>
          <div class="impact-label">Improvements Implemented</div>
        </div>

        <div class="impact-card indigo">
          <div class="impact-number">34</div>
          <div class="impact-label">Capacity Sessions</div>
        </div>
      </div>
    </div>
  </section>

  <!-- ========== PROGRAMMES PREVIEW ========== -->
  <section class="section bg-gray" id="programmes">
    <div class="container">
      <div class="section-header">
        <h2>Strategic Programmes</h2>
        <p>Key Focus Areas and Monitoring Initiatives</p>
      </div>

      <div class="grid grid-3">
        <!-- Transportation - Navy -->
        <div class="programme-card navy">
          <div class="programme-icon">🚛</div>
          <h4>Transportation & Infrastructure</h4>
          <p>Monitoring efficiency and service delivery in transport-related parastatals and infrastructure agencies.</p>
          <a href="#" class="programme-link">Learn More</a>
        </div>

        <!-- Health - Teal -->
        <div class="programme-card teal">
          <div class="programme-icon">🏥</div>
          <h4>Health & Wellness</h4>
          <p>Ensuring quality healthcare delivery and operational excellence across health sector parastatals.</p>
          <a href="#" class="programme-link">Learn More</a>
        </div>

        <!-- Education - Purple -->
        <div class="programme-card purple">
          <div class="programme-icon">📚</div>
          <h4>Education & Development</h4>
          <p>Supporting quality education provision and institutional development in educational agencies.</p>
          <a href="#" class="programme-link">Learn More</a>
        </div>
      </div>

      <div style="text-align: center; margin-top: var(--space-8);">
        <a href="/pmo/programmes/" class="btn btn-secondary">View All Programmes</a>
      </div>
    </div>
  </section>

  <!-- ========== LATEST NEWS ========== -->
  <section class="section bg-white">
    <div class="container">
      <div style="margin-bottom: var(--space-8);">
        <div class="news-header">
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

        $news_count = 0;
        if ( $news_query->have_posts() ) {
          while ( $news_query->have_posts() ) {
            $news_query->the_post();
            $news_count++;
            $card_class = $news_count === 1 ? 'card featured floating' : 'card card-small floating';
            ?>
            <article class="<?php echo esc_attr( $card_class ); ?>">
              <div class="news-card-image">
                <?php
                if ( has_post_thumbnail() ) {
                  the_post_thumbnail( 'medium', array( 'style' => 'width: 100%; height: 100%; object-fit: cover;' ) );
                } else {
                  echo '📰';
                }
                ?>
              </div>
              <div class="news-card-date"><?php echo esc_html( get_the_date( 'M d, Y' ) ); ?></div>
              <h4><?php the_title(); ?></h4>
              <p class="news-card-excerpt">
                <?php echo esc_html( wp_trim_words( get_the_excerpt(), 20 ) ); ?>
              </p>
              <a href="<?php the_permalink(); ?>" class="news-card-link">Read Full Article →</a>
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
  <section class="section bg-gray">
    <div class="container">
      <div style="margin-bottom: var(--space-8);">
        <div class="events-header">
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
              <div class="event-date-box">
                <div class="event-day">
                  <?php echo esc_html( $event_date ? date( 'd', strtotime( $event_date ) ) : 'TBA' ); ?>
                </div>
                <div>
                  <div class="event-month">
                    <?php echo esc_html( $event_date ? date( 'M Y', strtotime( $event_date ) ) : 'Date TBA' ); ?>
                  </div>
                </div>
              </div>
              <h4><?php the_title(); ?></h4>
              <?php if ( $event_venue ) { ?>
                <p class="event-venue">📍 <?php echo esc_html( $event_venue ); ?></p>
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
  <section class="section bg-primary">
    <div class="container">
      <div class="cta-content">
        <h2>Ready to Engage with PMO?</h2>
        <p>
          Contact us to learn more about our programmes, submit reports, or schedule a meeting with our team.
        </p>
        <a href="#contact" class="btn btn-light">Contact Us Today</a>
      </div>
    </div>
  </section>

</main>

<?php get_footer(); ?>

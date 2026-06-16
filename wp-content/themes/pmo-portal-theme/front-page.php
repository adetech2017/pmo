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

  <!-- ========== IMPACT STORY SECTION ========== -->
  <section class="impact-story" style="background: linear-gradient(135deg, rgba(44, 27, 71, 0.85) 0%, rgba(15, 124, 159, 0.85) 100%), url('<?php echo esc_url( get_template_directory_uri() . '/assets/images/impact-bg.jpg' ); ?>') center/cover; position: relative; padding: var(--space-20) var(--container-padding-desktop); color: white; overflow: hidden;">

    <!-- Animated background elements -->
    <div style="position: absolute; top: -50%; right: -10%; width: 800px; height: 800px; background: radial-gradient(circle, rgba(201, 162, 39, 0.1) 0%, transparent 70%); border-radius: 50%; pointer-events: none;"></div>

    <div class="container" style="position: relative; z-index: 2;">
      <!-- Inspiring Headline -->
      <div style="text-align: center; margin-bottom: var(--space-16); max-width: 800px; margin-left: auto; margin-right: auto;">
        <div style="display: inline-block; padding: var(--space-2) var(--space-4); background: rgba(255, 255, 255, 0.15); border-radius: var(--radius-full); margin-bottom: var(--space-6); font-size: var(--font-size-small); font-weight: var(--font-weight-semibold); backdrop-filter: blur(10px);">
          📊 OUR IMPACT
        </div>
        <h2 style="font-size: clamp(2rem, 5vw, 3.5rem); font-weight: 800; line-height: 1.2; margin-bottom: var(--space-6); letter-spacing: -0.02em;">
          Driving Excellence Across Lagos State Parastatals
        </h2>
        <p style="font-size: clamp(1rem, 2vw, 1.25rem); font-weight: 500; color: white; margin-bottom: var(--space-12);">
          Strategic oversight and rigorous monitoring creating measurable impact and sustainable governance improvements
        </p>
      </div>

      <!-- Impact Statistics Grid -->
      <div class="grid grid-4" style="margin-top: var(--space-12);">
        <!-- Statistic 1 -->
        <div class="impact-stat" style="text-align: center; padding: var(--space-8); background: rgba(255, 255, 255, 0.08); border-radius: var(--radius-lg); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.15); transition: all 0.3s ease;">
          <div style="font-size: 3.5rem; font-weight: 800; margin-bottom: var(--space-3); background: linear-gradient(135deg, #c9a227, #e8d4a0); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
            47
          </div>
          <div style="font-size: var(--font-size-body-lg); font-weight: 600;">Parastatals Monitored</div>
          <p style="font-size: var(--font-size-small); color: white; margin-top: var(--space-2);">Across all 20 LGAs</p>
        </div>

        <!-- Statistic 2 -->
        <div class="impact-stat" style="text-align: center; padding: var(--space-8); background: rgba(255, 255, 255, 0.08); border-radius: var(--radius-lg); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.15); transition: all 0.3s ease;">
          <div style="font-size: 3.5rem; font-weight: 800; margin-bottom: var(--space-3); background: linear-gradient(135deg, #79acfe, #4facfe); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
            156
          </div>
          <div style="font-size: var(--font-size-body-lg); font-weight: 600;">Audits Conducted</div>
          <p style="font-size: var(--font-size-small); color: white; margin-top: var(--space-2);">Comprehensive assessments</p>
        </div>

        <!-- Statistic 3 -->
        <div class="impact-stat" style="text-align: center; padding: var(--space-8); background: rgba(255, 255, 255, 0.08); border-radius: var(--radius-lg); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.15); transition: all 0.3s ease;">
          <div style="font-size: 3.5rem; font-weight: 800; margin-bottom: var(--space-3); background: linear-gradient(135deg, #047857, #10b981); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
            89
          </div>
          <div style="font-size: var(--font-size-body-lg); font-weight: 600;">Improvements Implemented</div>
          <p style="font-size: var(--font-size-small); color: white; margin-top: var(--space-2);">Governance enhancements</p>
        </div>

        <!-- Statistic 4 -->
        <div class="impact-stat" style="text-align: center; padding: var(--space-8); background: rgba(255, 255, 255, 0.08); border-radius: var(--radius-lg); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.15); transition: all 0.3s ease;">
          <div style="font-size: 3.5rem; font-weight: 800; margin-bottom: var(--space-3); background: linear-gradient(135deg, #4f6df5, #7c3aed); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
            34
          </div>
          <div style="font-size: var(--font-size-body-lg); font-weight: 600;">Capacity Sessions</div>
          <p style="font-size: var(--font-size-small); color: white; margin-top: var(--space-2);">Leadership development</p>
        </div>
      </div>

      <!-- Call to Action -->
      <div style="text-align: center; margin-top: var(--space-16);">
        <a href="<?php echo esc_url( home_url( '/news/' ) ); ?>" style="display: inline-block; padding: var(--space-4) var(--space-8); background: rgba(201, 162, 39, 0.9); color: white; border-radius: var(--radius-lg); text-decoration: none; font-weight: var(--font-weight-semibold); transition: all 0.3s ease; backdrop-filter: blur(10px);">
          Explore Our Impact Stories →
        </a>
      </div>
    </div>

    <style>
      .impact-stat {
        animation: slideInUp 0.8s ease-out backwards;
      }

      .impact-stat:nth-child(1) { animation-delay: 0.1s; }
      .impact-stat:nth-child(2) { animation-delay: 0.2s; }
      .impact-stat:nth-child(3) { animation-delay: 0.3s; }
      .impact-stat:nth-child(4) { animation-delay: 0.4s; }

      .impact-stat:hover {
        transform: translateY(-10px);
        background: rgba(255, 255, 255, 0.12);
        border-color: rgba(255, 255, 255, 0.25);
      }
    </style>
  </section>

  <!-- ========== WHAT WE DO INFOGRAPHIC ========== -->
  <section class="what-we-do" style="background: linear-gradient(180deg, rgba(15, 124, 159, 0.05) 0%, rgba(79, 109, 245, 0.05) 100%); padding: var(--space-16) var(--container-padding-desktop); position: relative; overflow: hidden;">

    <!-- Background decoration -->
    <div style="position: absolute; top: 0; left: 0; width: 500px; height: 500px; background: radial-gradient(circle, rgba(201, 162, 39, 0.08) 0%, transparent 70%); border-radius: 50%; transform: translate(-30%, -30%); pointer-events: none;"></div>
    <div style="position: absolute; bottom: 0; right: 0; width: 600px; height: 600px; background: radial-gradient(circle, rgba(79, 172, 254, 0.08) 0%, transparent 70%); border-radius: 50%; transform: translate(20%, 20%); pointer-events: none;"></div>

    <div class="container" style="position: relative; z-index: 2;">
      <!-- Section Header -->
      <div style="text-align: center; margin-bottom: var(--space-16); max-width: 700px; margin-left: auto; margin-right: auto;">
        <div style="display: inline-block; padding: var(--space-2) var(--space-4); background: rgba(79, 109, 245, 0.1); border-radius: var(--radius-full); margin-bottom: var(--space-4); font-size: var(--font-size-small); font-weight: var(--font-weight-semibold); color: var(--color-primary);">
          🎯 OUR CORE FUNCTIONS
        </div>
        <h2 style="font-size: clamp(2rem, 5vw, 3rem); font-weight: 800; line-height: 1.2; margin-bottom: var(--space-6); letter-spacing: -0.02em; color: var(--color-gray-900);">
          What We Do
        </h2>
        <p style="font-size: clamp(1rem, 2vw, 1.125rem); color: var(--color-gray-600); line-height: var(--line-height-relaxed);">
          Strategic monitoring, evaluation, and governance excellence across Lagos State parastatals
        </p>
      </div>

      <!-- Core Functions Grid -->
      <div class="grid grid-3" style="margin-top: var(--space-12);">

        <!-- Function 1: Monitoring -->
        <div class="what-we-do-card" style="padding: var(--space-8); background: var(--color-white); border-radius: var(--radius-xl); box-shadow: var(--shadow-md); transition: all 0.3s ease; border: 2px solid transparent; text-align: center;">
          <div style="font-size: 4rem; margin-bottom: var(--space-4); transform: scale(1); transition: transform 0.3s ease;">📊</div>
          <h3 style="font-size: 1.5rem; font-weight: 700; margin-bottom: var(--space-3); color: var(--color-primary);">
            Strategic Monitoring
          </h3>
          <p style="color: var(--color-gray-600); line-height: var(--line-height-relaxed); margin-bottom: var(--space-4);">
            Continuous oversight of parastatal operations to ensure efficiency, compliance, and optimal performance across all entities.
          </p>
          <a href="#" style="color: var(--color-primary); font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: var(--space-2);">
            Learn More →
          </a>
        </div>

        <!-- Function 2: Evaluation -->
        <div class="what-we-do-card" style="padding: var(--space-8); background: var(--color-white); border-radius: var(--radius-xl); box-shadow: var(--shadow-md); transition: all 0.3s ease; border: 2px solid transparent; text-align: center;">
          <div style="font-size: 4rem; margin-bottom: var(--space-4); transform: scale(1); transition: transform 0.3s ease;">📈</div>
          <h3 style="font-size: 1.5rem; font-weight: 700; margin-bottom: var(--space-3); color: var(--color-primary);">
            Performance Evaluation
          </h3>
          <p style="color: var(--color-gray-600); line-height: var(--line-height-relaxed); margin-bottom: var(--space-4);">
            Rigorous assessment of organizational performance against key metrics, strategic objectives, and government priorities.
          </p>
          <a href="#" style="color: var(--color-primary); font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: var(--space-2);">
            Learn More →
          </a>
        </div>

        <!-- Function 3: Governance -->
        <div class="what-we-do-card" style="padding: var(--space-8); background: var(--color-white); border-radius: var(--radius-xl); box-shadow: var(--shadow-md); transition: all 0.3s ease; border: 2px solid transparent; text-align: center;">
          <div style="font-size: 4rem; margin-bottom: var(--space-4); transform: scale(1); transition: transform 0.3s ease;">⚖️</div>
          <h3 style="font-size: 1.5rem; font-weight: 700; margin-bottom: var(--space-3); color: var(--color-primary);">
            Governance Enhancement
          </h3>
          <p style="color: var(--color-gray-600); line-height: var(--line-height-relaxed); margin-bottom: var(--space-4);">
            Implementing best practices and institutional reforms to strengthen accountability, transparency, and public sector excellence.
          </p>
          <a href="#" style="color: var(--color-primary); font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: var(--space-2);">
            Learn More →
          </a>
        </div>

        <!-- Function 4: Capacity Building -->
        <div class="what-we-do-card" style="padding: var(--space-8); background: var(--color-white); border-radius: var(--radius-xl); box-shadow: var(--shadow-md); transition: all 0.3s ease; border: 2px solid transparent; text-align: center;">
          <div style="font-size: 4rem; margin-bottom: var(--space-4); transform: scale(1); transition: transform 0.3s ease;">👥</div>
          <h3 style="font-size: 1.5rem; font-weight: 700; margin-bottom: var(--space-3); color: var(--color-primary);">
            Capacity Building
          </h3>
          <p style="color: var(--color-gray-600); line-height: var(--line-height-relaxed); margin-bottom: var(--space-4);">
            Training and development programs to build leadership skills and institutional competence across parastatals.
          </p>
          <a href="#" style="color: var(--color-primary); font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: var(--space-2);">
            Learn More →
          </a>
        </div>

        <!-- Function 5: Policy Advice -->
        <div class="what-we-do-card" style="padding: var(--space-8); background: var(--color-white); border-radius: var(--radius-xl); box-shadow: var(--shadow-md); transition: all 0.3s ease; border: 2px solid transparent; text-align: center;">
          <div style="font-size: 4rem; margin-bottom: var(--space-4); transform: scale(1); transition: transform 0.3s ease;">📋</div>
          <h3 style="font-size: 1.5rem; font-weight: 700; margin-bottom: var(--space-3); color: var(--color-primary);">
            Strategic Advisory
          </h3>
          <p style="color: var(--color-gray-600); line-height: var(--line-height-relaxed); margin-bottom: var(--space-4);">
            Evidence-based recommendations and strategic guidance to optimize institutional performance and government value.
          </p>
          <a href="#" style="color: var(--color-primary); font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: var(--space-2);">
            Learn More →
          </a>
        </div>

        <!-- Function 6: Reporting -->
        <div class="what-we-do-card" style="padding: var(--space-8); background: var(--color-white); border-radius: var(--radius-xl); box-shadow: var(--shadow-md); transition: all 0.3s ease; border: 2px solid transparent; text-align: center;">
          <div style="font-size: 4rem; margin-bottom: var(--space-4); transform: scale(1); transition: transform 0.3s ease;">📑</div>
          <h3 style="font-size: 1.5rem; font-weight: 700; margin-bottom: var(--space-3); color: var(--color-primary);">
            Transparent Reporting
          </h3>
          <p style="color: var(--color-gray-600); line-height: var(--line-height-relaxed); margin-bottom: var(--space-4);">
            Comprehensive and timely reporting on parastatal performance, audit findings, and governance improvements.
          </p>
          <a href="#" style="color: var(--color-primary); font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: var(--space-2);">
            Learn More →
          </a>
        </div>

      </div>
    </div>

    <style>
      .what-we-do-card {
        animation: slideInUp 0.6s ease-out backwards;
      }

      .what-we-do-card:nth-child(1) { animation-delay: 0.1s; }
      .what-we-do-card:nth-child(2) { animation-delay: 0.2s; }
      .what-we-do-card:nth-child(3) { animation-delay: 0.3s; }
      .what-we-do-card:nth-child(4) { animation-delay: 0.4s; }
      .what-we-do-card:nth-child(5) { animation-delay: 0.5s; }
      .what-we-do-card:nth-child(6) { animation-delay: 0.6s; }

      .what-we-do-card:hover {
        transform: translateY(-12px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        border-color: var(--color-primary);
      }

      .what-we-do-card:hover div:first-child {
        transform: scale(1.15) rotate(5deg);
      }
    </style>
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
  <section class="section bg-white">
    <div class="container">
      <!-- Section Header -->
      <div style="text-align: center; margin-bottom: var(--space-12); max-width: 700px; margin-left: auto; margin-right: auto;">
        <div style="display: inline-block; padding: var(--space-1) var(--space-3); background: rgba(79, 109, 245, 0.1); border-radius: var(--radius-full); margin-bottom: var(--space-4); font-size: var(--font-size-small); font-weight: var(--font-weight-semibold); color: var(--color-primary);">
          📅 UPCOMING EVENTS
        </div>
        <h2 style="font-size: 2rem; font-weight: 800; margin-bottom: var(--space-3); letter-spacing: -0.01em;">Upcoming Events</h2>
        <p style="color: var(--color-gray-600); line-height: var(--line-height-relaxed);">Stakeholder engagement, workshops, and capacity building sessions</p>
      </div>

      <!-- Events List -->
      <div style="display: flex; flex-direction: column; gap: var(--space-6); margin-bottom: var(--space-8);">
        <?php
        $events_args = array(
          'post_type'      => 'pmo_event',
          'posts_per_page' => 3,
          'orderby'        => 'date',
          'order'          => 'ASC',
        );
        $events_query = new WP_Query( $events_args );

        if ( $events_query->have_posts() ) {
          $event_index = 0;
          while ( $events_query->have_posts() ) {
            $events_query->the_post();
            $event_date = get_post_meta( get_the_ID(), '_event_date', true );
            $event_venue = get_post_meta( get_the_ID(), '_event_venue', true );
            $event_index++;
            ?>
            <div style="display: flex; gap: var(--space-6); padding: var(--space-6); background: var(--color-gray-50); border-radius: var(--radius-lg); border-left: 4px solid var(--color-primary); transition: all 0.3s ease; animation: slideInUp 0.6s ease-out backwards; animation-delay: <?php echo $event_index * 0.1; ?>s;" onmouseover="this.style.boxShadow='0 8px 24px rgba(0,0,0,0.1)'; this.style.transform='translateX(8px)'" onmouseout="this.style.boxShadow='none'; this.style.transform='translateX(0)'">

              <!-- Date Badge -->
              <div style="flex-shrink: 0; text-align: center; min-width: 80px;">
                <div style="background: var(--color-primary); color: white; border-radius: var(--radius-lg); padding: var(--space-3); font-weight: 800;">
                  <div style="font-size: 1.5rem; line-height: 1;">
                    <?php echo esc_html( $event_date ? date( 'd', strtotime( $event_date ) ) : 'TBA' ); ?>
                  </div>
                  <div style="font-size: var(--font-size-small); opacity: 0.95;">
                    <?php echo esc_html( $event_date ? date( 'M', strtotime( $event_date ) ) : '' ); ?>
                  </div>
                </div>
              </div>

              <!-- Event Details -->
              <div style="flex: 1; min-width: 0;">
                <h4 style="font-size: 1.2rem; font-weight: 700; margin-bottom: var(--space-2); color: var(--color-primary);">
                  <?php the_title(); ?>
                </h4>
                <?php if ( $event_venue ) { ?>
                  <div style="color: var(--color-gray-600); font-size: var(--font-size-small); margin-bottom: var(--space-2);">
                    📍 <?php echo esc_html( $event_venue ); ?>
                  </div>
                <?php } ?>
                <p style="color: var(--color-gray-600); font-size: var(--font-size-small); line-height: var(--line-height-relaxed); margin-bottom: var(--space-4);">
                  <?php echo esc_html( wp_trim_words( get_the_excerpt(), 20 ) ); ?>
                </p>
                <a href="<?php the_permalink(); ?>" style="color: var(--color-primary); font-weight: 600; text-decoration: none; font-size: var(--font-size-small);">
                  Register Now →
                </a>
              </div>
            </div>
            <?php
          }
          wp_reset_postdata();
        } else {
          ?>
          <div style="text-align: center; padding: var(--space-12); background: var(--color-gray-50); border-radius: var(--radius-lg);">
            <p style="color: var(--color-gray-600);">No events scheduled yet. Check back soon!</p>
          </div>
          <?php
        }
        ?>
      </div>

      <!-- View All Button -->
      <div style="text-align: center;">
        <a href="/pmo/events/" style="display: inline-block; padding: var(--space-3) var(--space-6); background: var(--color-primary); color: white; border-radius: var(--radius-lg); text-decoration: none; font-weight: var(--font-weight-semibold); transition: all 0.3s ease;" onmouseover="this.style.background='var(--color-primary-600)'" onmouseout="this.style.background='var(--color-primary)'">
          View All Events →
        </a>
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

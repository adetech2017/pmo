<?php
/**
 * Archive News Template - Premium Design
 *
 * @package PMO_Portal_Theme
 */

get_header();
?>

<main id="main-content" class="site-content">
  <!-- Hero Section with Animated Background -->
  <section style="background: linear-gradient(135deg, var(--color-primary-700) 0%, var(--color-primary-600) 50%, var(--color-info) 100%); color: var(--color-white); padding: var(--space-20) var(--container-padding-desktop); position: relative; overflow: hidden;">
    <!-- Decorative background elements -->
    <div style="position: absolute; top: -50%; right: -10%; width: 800px; height: 800px; background: radial-gradient(circle, rgba(201, 162, 39, 0.12) 0%, transparent 70%); border-radius: 50%; pointer-events: none; animation: float 6s ease-in-out infinite;"></div>
    <div style="position: absolute; bottom: -30%; left: -5%; width: 500px; height: 500px; background: radial-gradient(circle, rgba(79, 172, 254, 0.08) 0%, transparent 70%); border-radius: 50%; pointer-events: none; animation: float 8s ease-in-out infinite 1s;"></div>

    <div class="container" style="position: relative; z-index: 2;">
      <div style="max-width: 700px; animation: slideInUp 0.8s ease-out;">
        <div style="display: inline-block; padding: var(--space-1) var(--space-3); background: rgba(255, 255, 255, 0.15); border-radius: var(--radius-full); margin-bottom: var(--space-4); font-size: var(--font-size-small); font-weight: var(--font-weight-semibold); letter-spacing: 0.5px;">
          📰 LATEST UPDATES
        </div>
        <h1 style="color: var(--color-white); margin-bottom: var(--space-4); font-size: clamp(2.5rem, 5vw, 3.5rem); line-height: 1.2; font-weight: 800; letter-spacing: -0.02em;">News & Updates</h1>
        <p style="color: rgba(255, 255, 255, 0.95); font-size: var(--font-size-body-lg); line-height: var(--line-height-relaxed); margin-bottom: var(--space-6); font-weight: 400;">
          Stay informed with breaking news, press releases, and important announcements from the Lagos State Parastatals Monitoring Office
        </p>
      </div>
    </div>
  </section>

  <?php if ( have_posts() ) { ?>
    <!-- Featured Post Section -->
    <section style="background: var(--color-white);">
      <div class="container" style="padding: var(--space-12) 0;">
        <?php
        $featured_post = new WP_Query( array(
          'post_type'      => 'pmo_news',
          'posts_per_page' => 1,
          'orderby'        => 'date',
          'order'          => 'DESC',
        ) );

        if ( $featured_post->have_posts() ) {
          $featured_post->the_post();
          ?>
          <div class="featured-article" style="display: grid; grid-template-columns: 1fr 1fr; gap: var(--space-8); align-items: center; animation: slideInUp 0.8s ease-out;">
            <!-- Featured Image -->
            <div style="position: relative; border-radius: var(--radius-2xl); overflow: hidden; box-shadow: var(--shadow-xl); min-height: 400px; group: true;">
              <?php
              if ( has_post_thumbnail() ) {
                the_post_thumbnail( 'large', array( 'style' => 'width: 100%; height: 100%; object-fit: cover; transition: transform 0.6s ease;' ) );
              } else {
                echo '<div style="width: 100%; height: 100%; background: linear-gradient(135deg, var(--color-primary-700), var(--color-info)); display: flex; align-items: center; justify-content: center; color: var(--color-white); font-size: 4rem;">📰</div>';
              }
              ?>
            </div>

            <!-- Featured Content -->
            <div>
              <div style="display: inline-block; padding: var(--space-1) var(--space-3); background: linear-gradient(135deg, var(--color-accent), rgba(201, 162, 39, 0.8)); color: var(--color-white); font-size: var(--font-size-small); border-radius: var(--radius-sm); font-weight: 700; margin-bottom: var(--space-4); letter-spacing: 1px; text-transform: uppercase;">
                ⭐ FEATURED
              </div>

              <h2 style="font-size: clamp(1.75rem, 4vw, 2.25rem); margin-bottom: var(--space-4); line-height: 1.3; color: var(--color-primary-700); font-weight: 800; letter-spacing: -0.01em;">
                <?php the_title(); ?>
              </h2>

              <div style="display: flex; gap: var(--space-6); margin-bottom: var(--space-6); flex-wrap: wrap;">
                <span style="color: var(--color-gray-600); display: flex; align-items: center; gap: var(--space-2); font-size: var(--font-size-small);">
                  <span style="font-size: 1.2rem;">📅</span> <?php echo esc_html( get_the_date( 'M d, Y' ) ); ?>
                </span>
                <span style="color: var(--color-gray-600); display: flex; align-items: center; gap: var(--space-2); font-size: var(--font-size-small);">
                  <span style="font-size: 1.2rem;">⏱️</span> <?php echo esc_html( ceil( str_word_count( get_the_content() ) / 200 ) ); ?> min read
                </span>
              </div>

              <p style="font-size: var(--font-size-body-lg); color: var(--color-gray-700); line-height: var(--line-height-relaxed); margin-bottom: var(--space-8); font-weight: 400;">
                <?php echo esc_html( wp_trim_words( get_the_excerpt(), 30 ) ); ?>
              </p>

              <a href="<?php the_permalink(); ?>" class="btn-featured" style="display: inline-flex; align-items: center; gap: var(--space-3); padding: var(--space-3) var(--space-8); background: linear-gradient(135deg, var(--color-primary-700), var(--color-primary-600)); color: var(--color-white); border-radius: var(--radius-lg); text-decoration: none; font-weight: 700; transition: all var(--transition-base); box-shadow: var(--shadow-md); font-size: var(--font-size-body);">
                Read Full Article <span style="font-size: 1.3rem;">→</span>
              </a>
            </div>
          </div>
          <?php
          wp_reset_postdata();
        }
        ?>
      </div>
    </section>

    <!-- All News Grid Section -->
    <section style="background: var(--color-gray-50); padding: var(--space-16) var(--container-padding-desktop);">
      <div class="container">
        <div style="margin-bottom: var(--space-12); animation: slideInUp 0.8s ease-out;">
          <h2 style="font-size: clamp(2rem, 5vw, 2.5rem); margin-bottom: var(--space-3); font-weight: 800; color: var(--color-primary-700);">All Articles</h2>
          <div style="width: 120px; height: 5px; background: linear-gradient(90deg, var(--color-primary-700), var(--color-accent)); border-radius: 3px;"></div>
        </div>

        <!-- News Grid -->
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(340px, 1fr)); gap: var(--space-8);">
          <?php
          rewind_posts();
          $post_count = 0;
          while ( have_posts() ) {
            the_post();
            $post_count++;
            if ( $post_count === 1 ) {
              continue; // Skip the featured post
            }

            $category = '';
            $terms = get_the_terms( get_the_ID(), 'pmo_news_category' );
            if ( $terms ) {
              $category = $terms[0]->name;
            }
            $delay = ( ( $post_count - 2 ) % 6 ) * 0.1;
            ?>
            <div class="news-card" style="background: var(--color-white); border-radius: var(--radius-xl); overflow: hidden; box-shadow: var(--shadow-md); transition: all var(--transition-base); display: flex; flex-direction: column; opacity: 0; transform: translateY(30px); animation: slideInUp 0.6s ease-out forwards; animation-delay: <?php echo $delay; ?>s; cursor: pointer;">
              <!-- Image Container -->
              <div style="position: relative; height: 240px; overflow: hidden; background: linear-gradient(135deg, var(--color-primary-700), var(--color-info));">
                <?php
                if ( has_post_thumbnail() ) {
                  the_post_thumbnail( 'medium', array( 'style' => 'width: 100%; height: 100%; object-fit: cover; transition: transform 0.6s ease;' ) );
                } else {
                  echo '<div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; font-size: 3rem; color: var(--color-white);">📰</div>';
                }
                ?>

                <!-- Date Badge -->
                <div style="position: absolute; top: var(--space-4); left: var(--space-4); background: var(--color-accent); color: var(--color-white); padding: var(--space-2) var(--space-3); border-radius: var(--radius-lg); font-weight: 700; font-size: var(--font-size-small);">
                  <?php echo esc_html( get_the_date( 'M d' ) ); ?>
                </div>
              </div>

              <!-- Content -->
              <div style="padding: var(--space-6); flex: 1; display: flex; flex-direction: column;">
                <?php if ( $category ) { ?>
                  <span style="display: inline-block; color: var(--color-primary-700); font-size: var(--font-size-small); font-weight: 700; text-transform: uppercase; letter-spacing: 1px; margin-bottom: var(--space-3);">
                    <?php echo esc_html( $category ); ?>
                  </span>
                <?php } ?>

                <h3 style="margin-bottom: var(--space-3); flex: 1; line-height: 1.4;">
                  <a href="<?php the_permalink(); ?>" style="color: var(--color-primary-700); text-decoration: none; font-size: 1.2rem; font-weight: 700; transition: color var(--transition-base); display: block;">
                    <?php the_title(); ?>
                  </a>
                </h3>

                <p style="font-size: var(--font-size-small); color: var(--color-gray-600); margin-bottom: var(--space-4); line-height: var(--line-height-relaxed); flex: 1;">
                  <?php echo esc_html( wp_trim_words( get_the_excerpt(), 18 ) ); ?>
                </p>

                <a href="<?php the_permalink(); ?>" style="color: var(--color-accent); font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: var(--space-2); transition: all var(--transition-fast); font-size: var(--font-size-small);">
                  Continue Reading <span style="font-size: 1.1rem;">→</span>
                </a>
              </div>
            </div>
            <?php
          }
          ?>
        </div>

        <!-- Pagination -->
        <div style="margin-top: var(--space-16); text-align: center;">
          <?php the_posts_pagination( array(
            'prev_text' => '← Previous',
            'next_text' => 'Next →',
            'class'     => 'pagination',
          ) ); ?>
        </div>
      </div>
    </section>

  <?php } else { ?>
    <!-- No Posts Section -->
    <section style="background: var(--color-gray-50); padding: var(--space-20) var(--container-padding-desktop);">
      <div class="container" style="text-align: center; animation: slideInUp 0.8s ease-out;">
        <div style="font-size: 5rem; margin-bottom: var(--space-4); animation: float 3s ease-in-out infinite;">📰</div>
        <h2 style="color: var(--color-primary-700); margin-bottom: var(--space-4); font-size: 2rem; font-weight: 800;">No News Found</h2>
        <p style="color: var(--color-gray-600); margin-bottom: var(--space-8); font-size: var(--font-size-body-lg); line-height: var(--line-height-relaxed);">
          Check back soon for updates from the Parastatals Monitoring Office.
        </p>
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="display: inline-block; padding: var(--space-3) var(--space-6); background: linear-gradient(135deg, var(--color-primary-700), var(--color-primary-600)); color: var(--color-white); border-radius: var(--radius-lg); text-decoration: none; font-weight: 700; transition: all var(--transition-base); box-shadow: var(--shadow-md);">
          Back to Home
        </a>
      </div>
    </section>
  <?php } ?>

</main>

<?php get_footer();

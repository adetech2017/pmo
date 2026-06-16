<?php
/**
 * Programmes Page - Premium Government Design
 *
 * @package PMO_Portal_Theme
 */

get_header();
?>

<main id="main-content" class="site-content">

  <!-- Hero Section -->
  <section class="section" style="background: linear-gradient(135deg, var(--color-primary-700) 0%, var(--color-primary-600) 50%, var(--color-info) 100%); color: var(--color-white); padding: var(--space-16) var(--container-padding-desktop); position: relative; overflow: hidden;">
    <!-- Decorative elements -->
    <div style="position: absolute; top: -50%; right: -10%; width: 600px; height: 600px; background: radial-gradient(circle, rgba(201, 162, 39, 0.12) 0%, transparent 70%); border-radius: 50%; pointer-events: none; animation: float 6s ease-in-out infinite;"></div>
    <div style="position: absolute; bottom: -30%; left: -5%; width: 500px; height: 500px; background: radial-gradient(circle, rgba(79, 172, 254, 0.08) 0%, transparent 70%); border-radius: 50%; pointer-events: none; animation: float 8s ease-in-out infinite 1s;"></div>

    <div class="container" style="position: relative; z-index: 2; animation: slideInUp 0.8s ease-out;">
      <div style="display: inline-block; padding: var(--space-1) var(--space-3); background: rgba(255, 255, 255, 0.15); border-radius: var(--radius-full); margin-bottom: var(--space-4); font-size: var(--font-size-small); font-weight: 700; letter-spacing: 0.5px;">
        📊 PROGRAMMES & INITIATIVES
      </div>
      <h1 style="color: var(--color-white); margin-bottom: var(--space-4); font-size: clamp(2.5rem, 5vw, 3.5rem); font-weight: 800; letter-spacing: -0.02em;">Strategic Programmes</h1>
      <p style="color: rgba(255, 255, 255, 0.95); font-size: var(--font-size-body-lg); line-height: var(--line-height-relaxed); max-width: 600px; font-weight: 400;">Key initiatives driving institutional excellence and service delivery across Lagos State parastatals</p>
    </div>
  </section>

  <!-- Programmes Overview Section -->
  <section class="section" style="background: var(--color-white);">
    <div class="container">
      <div style="max-width: 800px; margin: 0 auto var(--space-16) auto; text-align: center; animation: slideInUp 0.8s ease-out;">
        <p style="font-size: var(--font-size-body-lg); color: var(--color-gray-700); line-height: var(--line-height-relaxed); font-weight: 400;">
          The PMO implements strategic programmes across key sectors to monitor, evaluate, and enhance the performance of Lagos State parastatals and government agencies.
        </p>
      </div>

      <!-- Programmes Grid -->
      <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: var(--space-8); margin-bottom: var(--space-16);">
        <?php
        $programmes_args = array(
          'post_type'      => 'pmo_programme',
          'posts_per_page' => -1,
          'orderby'        => 'title',
          'order'          => 'ASC',
        );
        $programmes_query = new WP_Query( $programmes_args );

        if ( $programmes_query->have_posts() ) {
          $index = 0;
          while ( $programmes_query->have_posts() ) {
            $programmes_query->the_post();
            $status = get_post_meta( get_the_ID(), '_programme_status', true );
            $budget = get_post_meta( get_the_ID(), '_programme_budget', true );
            $completion = intval( get_post_meta( get_the_ID(), '_programme_completion', true ) );

            // Status badge colors
            $status_color = '#047857'; // success
            if ( $status === 'Planned' ) $status_color = '#0369a1';
            elseif ( $status === 'In Progress' ) $status_color = '#d97706';
            elseif ( $status === 'Completed' ) $status_color = '#059669';
            elseif ( $status === 'Active' ) $status_color = '#c9a227';

            $delay = ( $index % 6 ) * 0.1;
            $index++;
            ?>
            <div class="programme-card" style="display: flex; flex-direction: column; background: var(--color-white); border-radius: var(--radius-xl); overflow: hidden; box-shadow: var(--shadow-md); border-left: 5px solid <?php echo $status_color; ?>; transition: all var(--transition-base); opacity: 0; transform: translateY(30px); animation: slideInUp 0.6s ease-out forwards; animation-delay: <?php echo $delay; ?>s;">
              <!-- Image Container -->
              <?php if ( has_post_thumbnail() ) { ?>
                <div style="height: 220px; overflow: hidden; position: relative;">
                  <?php the_post_thumbnail( 'medium', array( 'style' => 'width: 100%; height: 100%; object-fit: cover; transition: transform 0.6s ease;' ) ); ?>
                </div>
              <?php } else { ?>
                <div style="height: 220px; background: linear-gradient(135deg, var(--color-primary-700), var(--color-info)); display: flex; align-items: center; justify-content: center; color: var(--color-white); font-size: 3.5rem;">
                  📊
                </div>
              <?php } ?>

              <!-- Content -->
              <div style="padding: var(--space-6); flex: 1; display: flex; flex-direction: column;">
                <?php if ( $status ) { ?>
                  <div style="margin-bottom: var(--space-4); display: flex; align-items: center; gap: var(--space-3);">
                    <span style="display: inline-block; padding: var(--space-1) var(--space-3); background: <?php echo $status_color; ?>; color: var(--color-white); font-size: var(--font-size-small); border-radius: var(--radius-sm); font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">
                      <?php echo esc_html( $status ); ?>
                    </span>
                    <?php if ( $completion ) { ?>
                      <span style="font-size: var(--font-size-small); font-weight: 700; color: var(--color-gray-700);">
                        <?php echo $completion; ?>%
                      </span>
                    <?php } ?>
                  </div>
                <?php } ?>

                <h3 style="margin-bottom: var(--space-3); flex: 1; line-height: 1.4;">
                  <a href="<?php the_permalink(); ?>" style="color: var(--color-primary-700); text-decoration: none; font-size: 1.15rem; font-weight: 700; transition: color var(--transition-fast); display: block;">
                    <?php the_title(); ?>
                  </a>
                </h3>

                <div style="font-size: var(--font-size-small); color: var(--color-gray-600); margin-bottom: var(--space-4); line-height: var(--line-height-relaxed); flex: 1;">
                  <?php
                  $content = get_the_content();
                  if ( ! empty( $content ) ) {
                    echo esc_html( wp_trim_words( $content, 25 ) );
                  } elseif ( has_excerpt() ) {
                    echo esc_html( get_the_excerpt() );
                  }
                  ?>
                </div>

                <?php if ( $budget ) { ?>
                  <div style="margin-bottom: var(--space-4); padding-top: var(--space-4); border-top: 1px solid var(--color-gray-100);">
                    <p style="font-size: var(--font-size-small); color: var(--color-gray-700);">
                      <strong>Budget:</strong> <span style="color: var(--color-accent); font-weight: 700;"><?php echo esc_html( $budget ); ?></span>
                    </p>
                  </div>
                <?php } ?>

                <!-- Completion Progress Bar -->
                <?php if ( $completion ) { ?>
                  <div style="margin-bottom: var(--space-4);">
                    <div style="height: 6px; background: var(--color-gray-200); border-radius: 3px; overflow: hidden;">
                      <div style="height: 100%; background: linear-gradient(90deg, var(--color-success), var(--color-info)); width: <?php echo $completion; ?>%; transition: width 0.6s ease;"></div>
                    </div>
                  </div>
                <?php } ?>

                <a href="<?php the_permalink(); ?>" style="color: var(--color-accent); font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: var(--space-2); transition: all var(--transition-fast); font-size: var(--font-size-small);">
                  Learn More <span style="font-size: 1.1rem;">→</span>
                </a>
              </div>
            </div>
            <?php
          }
          wp_reset_postdata();
        } else {
          ?>
          <div style="grid-column: 1 / -1; text-align: center; padding: var(--space-12); animation: slideInUp 0.8s ease-out;">
            <div style="font-size: 3rem; margin-bottom: var(--space-4);">📊</div>
            <h3 style="color: var(--color-primary-700); margin-bottom: var(--space-4); font-size: 1.5rem; font-weight: 700;">No Programmes Yet</h3>
            <p style="color: var(--color-gray-600); font-size: var(--font-size-body-lg);">Strategic programmes will be displayed here. Check back soon for updates on key initiatives.</p>
          </div>
          <?php
        }
        ?>
      </div>
    </div>
  </section>

  <!-- Core Focus Areas Section -->
  <section class="section" style="background: var(--color-gray-50);">
    <div class="container">
      <div style="text-align: center; margin-bottom: var(--space-12); animation: slideInUp 0.8s ease-out;">
        <h2 style="font-size: clamp(2rem, 4vw, 2.5rem); font-weight: 800; margin-bottom: var(--space-4); color: var(--color-primary-700);">Core Focus Areas</h2>
        <p style="color: var(--color-gray-600); font-size: var(--font-size-body-lg); max-width: 600px; margin: 0 auto;">Strategic priorities driving our monitoring mandate across key sectors</p>
      </div>

      <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: var(--space-8);">
        <!-- Transportation & Infrastructure -->
        <div class="focus-card" style="text-align: center; padding: var(--space-8); background: var(--color-white); border-radius: var(--radius-xl); box-shadow: var(--shadow-md); border-top: 4px solid var(--color-info); transition: all var(--transition-base); opacity: 0; transform: translateY(30px); animation: slideInUp 0.6s ease-out forwards; animation-delay: 0s;">
          <div style="font-size: 3.5rem; margin-bottom: var(--space-4); display: inline-block; transition: transform 0.3s ease;">🚛</div>
          <h3 style="margin-bottom: var(--space-3); font-weight: 700; color: var(--color-primary-700);">Transportation & Infrastructure</h3>
          <p style="color: var(--color-gray-600); line-height: var(--line-height-relaxed); font-size: var(--font-size-small);">
            Monitoring efficiency and sustainability of transport-related parastatals and critical infrastructure agencies across Lagos State.
          </p>
        </div>

        <!-- Health & Wellness -->
        <div class="focus-card" style="text-align: center; padding: var(--space-8); background: var(--color-white); border-radius: var(--radius-xl); box-shadow: var(--shadow-md); border-top: 4px solid var(--color-success); transition: all var(--transition-base); opacity: 0; transform: translateY(30px); animation: slideInUp 0.6s ease-out forwards; animation-delay: 0.1s;">
          <div style="font-size: 3.5rem; margin-bottom: var(--space-4); display: inline-block; transition: transform 0.3s ease;">🏥</div>
          <h3 style="margin-bottom: var(--space-3); font-weight: 700; color: var(--color-primary-700);">Health & Wellness</h3>
          <p style="color: var(--color-gray-600); line-height: var(--line-height-relaxed); font-size: var(--font-size-small);">
            Ensuring quality healthcare delivery and operational excellence across health sector parastatals and agencies.
          </p>
        </div>

        <!-- Education & Development -->
        <div class="focus-card" style="text-align: center; padding: var(--space-8); background: var(--color-white); border-radius: var(--radius-xl); box-shadow: var(--shadow-md); border-top: 4px solid var(--color-accent); transition: all var(--transition-base); opacity: 0; transform: translateY(30px); animation: slideInUp 0.6s ease-out forwards; animation-delay: 0.2s;">
          <div style="font-size: 3.5rem; margin-bottom: var(--space-4); display: inline-block; transition: transform 0.3s ease;">📚</div>
          <h3 style="margin-bottom: var(--space-3); font-weight: 700; color: var(--color-primary-700);">Education & Development</h3>
          <p style="color: var(--color-gray-600); line-height: var(--line-height-relaxed); font-size: var(--font-size-small);">
            Supporting quality education provision and institutional development in educational agencies and training institutions.
          </p>
        </div>

        <!-- Environment & Sustainability -->
        <div class="focus-card" style="text-align: center; padding: var(--space-8); background: var(--color-white); border-radius: var(--radius-xl); box-shadow: var(--shadow-md); border-top: 4px solid #059669; transition: all var(--transition-base); opacity: 0; transform: translateY(30px); animation: slideInUp 0.6s ease-out forwards; animation-delay: 0.3s;">
          <div style="font-size: 3.5rem; margin-bottom: var(--space-4); display: inline-block; transition: transform 0.3s ease;">🌍</div>
          <h3 style="margin-bottom: var(--space-3); font-weight: 700; color: var(--color-primary-700);">Environment & Sustainability</h3>
          <p style="color: var(--color-gray-600); line-height: var(--line-height-relaxed); font-size: var(--font-size-small);">
            Promoting sustainable practices and environmental responsibility across all monitored agencies and parastatals.
          </p>
        </div>

        <!-- Governance & Accountability -->
        <div class="focus-card" style="text-align: center; padding: var(--space-8); background: var(--color-white); border-radius: var(--radius-xl); box-shadow: var(--shadow-md); border-top: 4px solid var(--color-warning); transition: all var(--transition-base); opacity: 0; transform: translateY(30px); animation: slideInUp 0.6s ease-out forwards; animation-delay: 0.4s;">
          <div style="font-size: 3.5rem; margin-bottom: var(--space-4); display: inline-block; transition: transform 0.3s ease;">⚖️</div>
          <h3 style="margin-bottom: var(--space-3); font-weight: 700; color: var(--color-primary-700);">Governance & Accountability</h3>
          <p style="color: var(--color-gray-600); line-height: var(--line-height-relaxed); font-size: var(--font-size-small);">
            Strengthening corporate governance frameworks and promoting transparency, accountability, and ethical practices.
          </p>
        </div>

        <!-- Performance Management -->
        <div class="focus-card" style="text-align: center; padding: var(--space-8); background: var(--color-white); border-radius: var(--radius-xl); box-shadow: var(--shadow-md); border-top: 4px solid var(--color-info); transition: all var(--transition-base); opacity: 0; transform: translateY(30px); animation: slideInUp 0.6s ease-out forwards; animation-delay: 0.5s;">
          <div style="font-size: 3.5rem; margin-bottom: var(--space-4); display: inline-block; transition: transform 0.3s ease;">📈</div>
          <h3 style="margin-bottom: var(--space-3); font-weight: 700; color: var(--color-primary-700);">Performance Management</h3>
          <p style="color: var(--color-gray-600); line-height: var(--line-height-relaxed); font-size: var(--font-size-small);">
            Implementing comprehensive performance measurement systems and driving results-oriented management across agencies.
          </p>
        </div>
      </div>
    </div>
  </section>

</main>

<?php get_footer();

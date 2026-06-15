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
  <section class="section" style="background: linear-gradient(135deg, var(--color-indigo) 0%, var(--color-teal) 100%); color: var(--color-white); padding: var(--space-16) var(--container-padding-desktop); position: relative; overflow: hidden;">
    <div style="position: absolute; top: -50%; right: -10%; width: 600px; height: 600px; background: radial-gradient(circle, rgba(201, 162, 39, 0.1) 0%, transparent 70%); border-radius: 50%; pointer-events: none;"></div>

    <div class="container" style="position: relative; z-index: 2;">
      <h1 style="color: var(--color-white); margin-bottom: var(--space-2);">Strategic Programmes</h1>
      <p style="color: rgba(255, 255, 255, 0.9); font-size: var(--font-size-body-lg);">Key initiatives driving institutional excellence and service delivery</p>
    </div>
  </section>

  <!-- Programmes Overview Section -->
  <section class="section" style="background: var(--color-white);">
    <div class="container">
      <div style="max-width: 800px; margin: 0 auto var(--space-16) auto; text-align: center;">
        <p style="font-size: var(--font-size-body-lg); color: var(--color-gray-700); line-height: var(--line-height-relaxed);">
          The PMO implements strategic programmes across key sectors to monitor, evaluate, and enhance the performance of Lagos State parastatals and government agencies.
        </p>
      </div>

      <!-- Programmes Grid -->
      <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: var(--space-6); margin-bottom: var(--space-16);">
        <?php
        $programmes_args = array(
          'post_type'      => 'pmo_programme',
          'posts_per_page' => -1,
          'orderby'        => 'title',
          'order'          => 'ASC',
        );
        $programmes_query = new WP_Query( $programmes_args );

        if ( $programmes_query->have_posts() ) {
          while ( $programmes_query->have_posts() ) {
            $programmes_query->the_post();
            $status = get_post_meta( get_the_ID(), '_programme_status', true );
            $budget = get_post_meta( get_the_ID(), '_programme_budget', true );
            ?>
            <div class="card" style="display: flex; flex-direction: column; border: 1px solid var(--color-gray-100); border-top: 4px solid var(--color-indigo); transition: all var(--transition-base);">
              <?php if ( has_post_thumbnail() ) { ?>
                <div style="height: 200px; overflow: hidden;">
                  <?php the_post_thumbnail( 'medium', array( 'style' => 'width: 100%; height: 100%; object-fit: cover;' ) ); ?>
                </div>
              <?php } else { ?>
                <div style="height: 200px; background: linear-gradient(135deg, var(--color-indigo), var(--color-teal)); display: flex; align-items: center; justify-content: center; color: var(--color-white); font-size: 2.5rem;">
                  📊
                </div>
              <?php } ?>

              <div style="padding: var(--space-6); flex: 1; display: flex; flex-direction: column;">
                <?php if ( $status ) { ?>
                  <div style="margin-bottom: var(--space-3);">
                    <span style="display: inline-block; padding: var(--space-1) var(--space-2); background: var(--color-indigo); color: var(--color-white); font-size: var(--font-size-small); border-radius: var(--radius-sm); font-weight: var(--font-weight-semibold);">
                      <?php echo esc_html( $status ); ?>
                    </span>
                  </div>
                <?php } ?>

                <h3 style="margin-bottom: var(--space-3); flex: 1;">
                  <a href="<?php the_permalink(); ?>" style="color: var(--color-primary); text-decoration: none;">
                    <?php the_title(); ?>
                  </a>
                </h3>

                <div style="font-size: var(--font-size-small); color: var(--color-gray-600); margin-bottom: var(--space-4); line-height: var(--line-height-relaxed);">
                  <?php
                  $content = get_the_content();
                  if ( ! empty( $content ) ) {
                    echo esc_html( wp_trim_words( $content, 30 ) );
                  } elseif ( has_excerpt() ) {
                    echo esc_html( get_the_excerpt() );
                  }
                  ?>
                </div>

                <?php if ( $budget ) { ?>
                  <div style="margin-bottom: var(--space-4); padding-top: var(--space-4); border-top: 1px solid var(--color-gray-100);">
                    <p style="font-size: var(--font-size-small); color: var(--color-gray-700);">
                      <strong>Budget:</strong> <?php echo esc_html( $budget ); ?>
                    </p>
                  </div>
                <?php } ?>

                <a href="<?php the_permalink(); ?>" style="color: var(--color-accent); font-weight: var(--font-weight-semibold); text-decoration: none;">
                  Learn More →
                </a>
              </div>
            </div>
            <?php
          }
          wp_reset_postdata();
        } else {
          ?>
          <div style="grid-column: 1 / -1; text-align: center; padding: var(--space-12);">
            <h3 style="color: var(--color-gray-700); margin-bottom: var(--space-4);">No Programmes Yet</h3>
            <p style="color: var(--color-gray-600);">Strategic programmes will be displayed here. Check back soon for updates on key initiatives.</p>
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
      <div style="text-align: center; margin-bottom: var(--space-12);">
        <h2>Core Focus Areas</h2>
        <p style="color: var(--color-gray-600); font-size: var(--font-size-body-lg);">Strategic priorities driving our monitoring mandate</p>
      </div>

      <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: var(--space-8);">
        <!-- Transportation & Infrastructure -->
        <div class="card" style="text-align: center; padding: var(--space-8);">
          <div style="font-size: 3rem; margin-bottom: var(--space-4);">🚛</div>
          <h3 style="margin-bottom: var(--space-3);">Transportation & Infrastructure</h3>
          <p style="color: var(--color-gray-600); line-height: var(--line-height-relaxed);">
            Monitoring efficiency and sustainability of transport-related parastatals and critical infrastructure agencies across Lagos State.
          </p>
        </div>

        <!-- Health & Wellness -->
        <div class="card" style="text-align: center; padding: var(--space-8);">
          <div style="font-size: 3rem; margin-bottom: var(--space-4);">🏥</div>
          <h3 style="margin-bottom: var(--space-3);">Health & Wellness</h3>
          <p style="color: var(--color-gray-600); line-height: var(--line-height-relaxed);">
            Ensuring quality healthcare delivery and operational excellence across health sector parastatals and agencies.
          </p>
        </div>

        <!-- Education & Development -->
        <div class="card" style="text-align: center; padding: var(--space-8);">
          <div style="font-size: 3rem; margin-bottom: var(--space-4);">📚</div>
          <h3 style="margin-bottom: var(--space-3);">Education & Development</h3>
          <p style="color: var(--color-gray-600); line-height: var(--line-height-relaxed);">
            Supporting quality education provision and institutional development in educational agencies and training institutions.
          </p>
        </div>

        <!-- Environment & Sustainability -->
        <div class="card" style="text-align: center; padding: var(--space-8);">
          <div style="font-size: 3rem; margin-bottom: var(--space-4);">🌍</div>
          <h3 style="margin-bottom: var(--space-3);">Environment & Sustainability</h3>
          <p style="color: var(--color-gray-600); line-height: var(--line-height-relaxed);">
            Promoting sustainable practices and environmental responsibility across all monitored agencies and parastatals.
          </p>
        </div>

        <!-- Governance & Accountability -->
        <div class="card" style="text-align: center; padding: var(--space-8);">
          <div style="font-size: 3rem; margin-bottom: var(--space-4);">⚖️</div>
          <h3 style="margin-bottom: var(--space-3);">Governance & Accountability</h3>
          <p style="color: var(--color-gray-600); line-height: var(--line-height-relaxed);">
            Strengthening corporate governance frameworks and promoting transparency, accountability, and ethical practices.
          </p>
        </div>

        <!-- Performance Management -->
        <div class="card" style="text-align: center; padding: var(--space-8);">
          <div style="font-size: 3rem; margin-bottom: var(--space-4);">📈</div>
          <h3 style="margin-bottom: var(--space-3);">Performance Management</h3>
          <p style="color: var(--color-gray-600); line-height: var(--line-height-relaxed);">
            Implementing comprehensive performance measurement systems and driving results-oriented management across agencies.
          </p>
        </div>
      </div>
    </div>
  </section>

</main>

<?php get_footer();

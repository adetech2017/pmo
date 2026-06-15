<?php
/**
 * Programmes Archive Template - Premium Design
 *
 * @package PMO_Portal_Theme
 */

get_header();
?>

<main id="main-content" class="site-content">

  <!-- Hero Section with Gradient -->
  <section style="background: linear-gradient(135deg, #2c1b47 0%, #1a4d6d 50%, #0f7c9f 100%); color: var(--color-white); padding: var(--space-20) var(--container-padding-desktop); position: relative; overflow: hidden;">
    <div style="position: absolute; top: -50%; right: -10%; width: 800px; height: 800px; background: radial-gradient(circle, rgba(201, 162, 39, 0.15) 0%, transparent 70%); border-radius: 50%; pointer-events: none;"></div>
    <div style="position: absolute; bottom: -30%; left: -5%; width: 500px; height: 500px; background: radial-gradient(circle, rgba(79, 172, 254, 0.1) 0%, transparent 70%); border-radius: 50%; pointer-events: none;"></div>

    <div class="container" style="position: relative; z-index: 2;">
      <div style="max-width: 800px;">
        <div style="display: inline-block; padding: var(--space-1) var(--space-3); background: rgba(255, 255, 255, 0.2); border-radius: var(--radius-full); margin-bottom: var(--space-4); font-size: var(--font-size-small); font-weight: var(--font-weight-semibold);">
          🎯 Government Programmes
        </div>
        <h1 style="color: var(--color-white); margin-bottom: var(--space-4); font-size: 3.5rem; line-height: 1.2; font-weight: 800;">Strategic Programmes</h1>
        <p style="color: rgba(255, 255, 255, 0.9); font-size: var(--font-size-body-lg); line-height: var(--line-height-relaxed); margin-bottom: 0;">
          Key initiatives driving institutional excellence, service delivery, and sustainable development across Lagos State parastatals and government agencies
        </p>
      </div>
    </div>
  </section>

  <?php if ( have_posts() ) { ?>

    <!-- Stats Section -->
    <section style="background: var(--color-white); padding: var(--space-12) var(--container-padding-desktop); border-bottom: 1px solid var(--color-gray-100);">
      <div class="container">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: var(--space-6);">
          <div style="text-align: center;">
            <div style="font-size: 2.5rem; font-weight: 800; color: var(--color-indigo); margin-bottom: var(--space-2);">
              <?php
              $total_posts = wp_count_posts( 'pmo_programme' );
              echo esc_html( $total_posts->publish );
              ?>
            </div>
            <div style="color: var(--color-gray-600); font-weight: var(--font-weight-semibold);">Total Programmes</div>
          </div>

          <div style="text-align: center;">
            <div style="font-size: 2.5rem; font-weight: 800; color: var(--color-teal); margin-bottom: var(--space-2);">
              <?php
              $in_progress = new WP_Query( [
                'post_type' => 'pmo_programme',
                'meta_key' => '_programme_status',
                'meta_value' => 'In Progress',
              ] );
              echo esc_html( $in_progress->found_posts );
              ?>
            </div>
            <div style="color: var(--color-gray-600); font-weight: var(--font-weight-semibold);">In Progress</div>
          </div>

          <div style="text-align: center;">
            <div style="font-size: 2.5rem; font-weight: 800; color: #28a745; margin-bottom: var(--space-2);">
              <?php
              $active = new WP_Query( [
                'post_type' => 'pmo_programme',
                'meta_key' => '_programme_status',
                'meta_value' => 'Active',
              ] );
              echo esc_html( $active->found_posts );
              ?>
            </div>
            <div style="color: var(--color-gray-600); font-weight: var(--font-weight-semibold);">Active Programmes</div>
          </div>
        </div>
      </div>
    </section>

    <!-- Programmes Grid Section -->
    <section style="padding: var(--space-16) var(--container-padding-desktop); background: var(--color-gray-50);">
      <div class="container">
        <!-- Filter/Sort Header -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--space-12);">
          <div>
            <h2 style="font-size: 2rem; margin-bottom: var(--space-2);">All Programmes</h2>
            <div style="width: 80px; height: 4px; background: linear-gradient(90deg, var(--color-indigo), var(--color-teal)); border-radius: 2px;"></div>
          </div>
        </div>

        <!-- Programmes Grid -->
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: var(--space-8);">
          <?php
          while ( have_posts() ) {
            the_post();
            $status = get_post_meta( get_the_ID(), '_programme_status', true );
            $budget = get_post_meta( get_the_ID(), '_programme_budget', true );
            $completion = get_post_meta( get_the_ID(), '_programme_completion', true );

            $status_color = [
              'Planned' => '#ffc107',
              'In Progress' => '#17a2b8',
              'Active' => '#28a745',
              'Completed' => '#6c757d',
            ][ $status ] ?? '#6c757d';
            ?>

            <a href="<?php the_permalink(); ?>" style="text-decoration: none; color: inherit; display: block; transition: all 0.3s ease;">
              <div style="background: var(--color-white); border-radius: var(--radius-xl); overflow: hidden; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1); transition: all 0.3s ease; hover: box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15); display: flex; flex-direction: column; height: 100%;">

                <!-- Image -->
                <div style="position: relative; height: 250px; overflow: hidden; background: linear-gradient(135deg, var(--color-indigo), var(--color-teal));">
                  <?php
                  if ( has_post_thumbnail() ) {
                    the_post_thumbnail( 'large', array( 'style' => 'width: 100%; height: 100%; object-fit: cover;' ) );
                  } else {
                    echo '<div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; font-size: 3.5rem; color: var(--color-white);">📊</div>';
                  }
                  ?>

                  <!-- Status Badge -->
                  <div style="position: absolute; top: var(--space-4); right: var(--space-4); background: <?php echo esc_attr( $status_color ); ?>; color: var(--color-white); padding: var(--space-2) var(--space-4); border-radius: var(--radius-lg); font-weight: var(--font-weight-semibold); font-size: var(--font-size-small); box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);">
                    <?php echo esc_html( $status ?: 'Pending' ); ?>
                  </div>
                </div>

                <!-- Content -->
                <div style="padding: var(--space-6); flex: 1; display: flex; flex-direction: column;">

                  <!-- Title -->
                  <h3 style="margin-bottom: var(--space-4); font-size: 1.3rem; line-height: 1.4; color: var(--color-primary); min-height: 3.5rem;">
                    <?php the_title(); ?>
                  </h3>

                  <!-- Description -->
                  <p style="font-size: var(--font-size-small); color: var(--color-gray-600); margin-bottom: var(--space-4); line-height: var(--line-height-relaxed); flex: 1;">
                    <?php echo esc_html( wp_trim_words( get_the_content(), 25 ) ); ?>
                  </p>

                  <!-- Budget -->
                  <?php if ( $budget ) { ?>
                    <div style="padding: var(--space-3); background: var(--color-gray-50); border-radius: var(--radius-lg); margin-bottom: var(--space-4); border-left: 4px solid var(--color-indigo);">
                      <div style="font-size: var(--font-size-small); color: var(--color-gray-600);">Budget</div>
                      <div style="font-weight: var(--font-weight-bold); color: var(--color-primary); font-size: 1.1rem;">
                        <?php echo esc_html( $budget ); ?>
                      </div>
                    </div>
                  <?php } ?>

                  <!-- Completion Progress -->
                  <?php if ( $completion !== '' ) { ?>
                    <div style="margin-bottom: var(--space-4);">
                      <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--space-2);">
                        <div style="font-size: var(--font-size-small); color: var(--color-gray-600); font-weight: var(--font-weight-semibold);">Completion</div>
                        <div style="font-weight: var(--font-weight-bold); color: var(--color-indigo);">
                          <?php echo intval( $completion ); ?>%
                        </div>
                      </div>
                      <div style="background: var(--color-gray-200); border-radius: 10px; height: 8px; overflow: hidden;">
                        <div style="background: linear-gradient(90deg, var(--color-indigo), var(--color-teal)); height: 100%; width: <?php echo intval( $completion ); ?>%; border-radius: 10px; transition: width 0.3s ease;"></div>
                      </div>
                    </div>
                  <?php } ?>

                  <!-- Learn More Link -->
                  <div style="margin-top: auto; padding-top: var(--space-4); border-top: 1px solid var(--color-gray-100);">
                    <span style="color: var(--color-indigo); font-weight: var(--font-weight-semibold); display: inline-flex; align-items: center; gap: var(--space-2);">
                      View Details <span>→</span>
                    </span>
                  </div>

                </div>
              </div>
            </a>

            <?php
          }
          wp_reset_postdata();
          ?>
        </div>

        <!-- Pagination -->
        <div style="margin-top: var(--space-12); text-align: center;">
          <?php the_posts_pagination( array(
            'prev_text' => '← Previous',
            'next_text' => 'Next →',
          ) ); ?>
        </div>
      </div>
    </section>

  <?php } else { ?>

    <!-- No Programmes -->
    <section style="padding: var(--space-20) var(--container-padding-desktop); background: var(--color-gray-50);">
      <div class="container" style="text-align: center;">
        <div style="font-size: 4rem; margin-bottom: var(--space-4);">📊</div>
        <h2 style="color: var(--color-primary); margin-bottom: var(--space-4); font-size: 1.8rem;">No Programmes Yet</h2>
        <p style="color: var(--color-gray-600); font-size: var(--font-size-body-lg); margin-bottom: var(--space-8); max-width: 500px; margin-left: auto; margin-right: auto;">
          Strategic programmes will be displayed here as they are created. Check back soon for updates on key initiatives and government programmes.
        </p>
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="display: inline-block; padding: var(--space-3) var(--space-6); background: var(--color-indigo); color: var(--color-white); border-radius: var(--radius-lg); text-decoration: none; font-weight: var(--font-weight-semibold);">
          Back to Home
        </a>
      </div>
    </section>

  <?php } ?>

</main>

<?php get_footer();

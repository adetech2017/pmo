<?php
/**
 * Single Programme Template
 *
 * @package PMO_Portal_Theme
 */

get_header();
?>

<main id="main-content" class="site-content">

  <!-- Hero Section -->
  <section style="background: linear-gradient(135deg, #2c1b47 0%, #1a4d6d 50%, #0f7c9f 100%); color: var(--color-white); padding: var(--space-16) var(--container-padding-desktop); position: relative; overflow: hidden;">
    <div style="position: absolute; top: -50%; right: -10%; width: 800px; height: 800px; background: radial-gradient(circle, rgba(201, 162, 39, 0.15) 0%, transparent 70%); border-radius: 50%; pointer-events: none;"></div>

    <div class="container" style="position: relative; z-index: 2;">
      <a href="<?php echo esc_url( home_url( '/programmes/' ) ); ?>" style="color: rgba(255, 255, 255, 0.8); text-decoration: none; display: inline-block; margin-bottom: var(--space-4);">
        ← Back to Programmes
      </a>
      <h1 style="color: var(--color-white); margin-bottom: var(--space-2); font-size: 3rem; line-height: 1.2;">
        <?php the_title(); ?>
      </h1>
    </div>
  </section>

  <div class="container" style="padding: var(--space-16) 0;">
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: var(--space-12);">

      <!-- Main Content -->
      <div>
        <!-- Featured Image -->
        <?php if ( has_post_thumbnail() ) { ?>
          <div style="margin-bottom: var(--space-12); border-radius: var(--radius-2xl); overflow: hidden; box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);">
            <?php the_post_thumbnail( 'large', array( 'style' => 'width: 100%; height: auto;' ) ); ?>
          </div>
        <?php } ?>

        <!-- Programme Description -->
        <div style="background: var(--color-white); padding: var(--space-8); border-radius: var(--radius-xl); box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08); margin-bottom: var(--space-12);">
          <h2 style="margin-bottom: var(--space-4); color: var(--color-primary);">Programme Overview</h2>
          <div style="color: var(--color-gray-700); line-height: var(--line-height-relaxed); font-size: var(--font-size-body-lg);">
            <?php the_content(); ?>
          </div>
        </div>
      </div>

      <!-- Sidebar -->
      <div>
        <!-- Programme Details Card -->
        <div style="background: linear-gradient(135deg, var(--color-indigo) 0%, var(--color-teal) 100%); color: var(--color-white); padding: var(--space-8); border-radius: var(--radius-xl); margin-bottom: var(--space-8);">
          <h3 style="color: var(--color-white); margin-bottom: var(--space-6); font-size: 1.3rem;">Programme Details</h3>

          <?php
          $status = get_post_meta( get_the_ID(), '_programme_status', true );
          $budget = get_post_meta( get_the_ID(), '_programme_budget', true );
          $start_date = get_post_meta( get_the_ID(), '_programme_start_date', true );
          $end_date = get_post_meta( get_the_ID(), '_programme_end_date', true );
          $completion = get_post_meta( get_the_ID(), '_programme_completion', true );
          ?>

          <!-- Status -->
          <?php if ( $status ) { ?>
            <div style="margin-bottom: var(--space-6); padding-bottom: var(--space-6); border-bottom: 1px solid rgba(255, 255, 255, 0.2);">
              <div style="font-size: var(--font-size-small); opacity: 0.9; margin-bottom: var(--space-2);">STATUS</div>
              <div style="font-size: 1.1rem; font-weight: var(--font-weight-semibold);">
                <?php
                $status_colors = [
                  'Planned' => '#ffc107',
                  'In Progress' => '#17a2b8',
                  'Active' => '#28a745',
                  'Completed' => '#6c757d',
                ];
                $color = $status_colors[ $status ] ?? '#6c757d';
                ?>
                <span style="display: inline-block; padding: var(--space-1) var(--space-3); background: <?php echo esc_attr( $color ); ?>; border-radius: var(--radius-sm); color: var(--color-white);">
                  <?php echo esc_html( $status ); ?>
                </span>
              </div>
            </div>
          <?php } ?>

          <!-- Budget -->
          <?php if ( $budget ) { ?>
            <div style="margin-bottom: var(--space-6); padding-bottom: var(--space-6); border-bottom: 1px solid rgba(255, 255, 255, 0.2);">
              <div style="font-size: var(--font-size-small); opacity: 0.9; margin-bottom: var(--space-2);">BUDGET</div>
              <div style="font-size: 1.2rem; font-weight: var(--font-weight-bold);">
                <?php echo esc_html( $budget ); ?>
              </div>
            </div>
          <?php } ?>

          <!-- Timeline -->
          <div style="margin-bottom: var(--space-6); padding-bottom: var(--space-6); border-bottom: 1px solid rgba(255, 255, 255, 0.2);">
            <div style="font-size: var(--font-size-small); opacity: 0.9; margin-bottom: var(--space-2);">TIMELINE</div>
            <div style="font-size: 0.9rem;">
              <?php if ( $start_date ) { ?>
                <div style="margin-bottom: var(--space-2);">
                  <strong>Start:</strong> <?php echo esc_html( wp_date( 'M d, Y', strtotime( $start_date ) ) ); ?>
                </div>
              <?php } ?>
              <?php if ( $end_date ) { ?>
                <div>
                  <strong>End:</strong> <?php echo esc_html( wp_date( 'M d, Y', strtotime( $end_date ) ) ); ?>
                </div>
              <?php } ?>
            </div>
          </div>

          <!-- Completion Progress -->
          <?php if ( $completion !== '' ) { ?>
            <div>
              <div style="font-size: var(--font-size-small); opacity: 0.9; margin-bottom: var(--space-3);">COMPLETION</div>
              <div style="background: rgba(255, 255, 255, 0.2); border-radius: 10px; height: 10px; overflow: hidden; margin-bottom: var(--space-2);">
                <div style="background: rgba(255, 255, 255, 0.9); height: 100%; width: <?php echo intval( $completion ); ?>%; border-radius: 10px;"></div>
              </div>
              <div style="font-size: 1rem; font-weight: var(--font-weight-bold); text-align: right;">
                <?php echo esc_html( $completion ); ?>%
              </div>
            </div>
          <?php } ?>
        </div>

        <!-- Related Info Box -->
        <div style="background: var(--color-gray-50); padding: var(--space-6); border-radius: var(--radius-xl); border-left: 4px solid var(--color-indigo);">
          <h4 style="color: var(--color-primary); margin-bottom: var(--space-4);">📌 Key Information</h4>
          <ul style="list-style: none; padding: 0; margin: 0;">
            <li style="margin-bottom: var(--space-3); color: var(--color-gray-700);">
              <strong>Type:</strong> Government Initiative
            </li>
            <li style="margin-bottom: var(--space-3); color: var(--color-gray-700);">
              <strong>Published:</strong> <?php echo esc_html( wp_date( 'M d, Y', strtotime( get_the_date() ) ) ); ?>
            </li>
            <li style="color: var(--color-gray-700);">
              <strong>Last Updated:</strong> <?php echo esc_html( wp_date( 'M d, Y', strtotime( get_the_modified_date() ) ) ); ?>
            </li>
          </ul>
        </div>
      </div>

    </div>
  </div>

  <!-- Back Link -->
  <section style="padding: var(--space-8) var(--container-padding-desktop); text-align: center; border-top: 1px solid var(--color-gray-100);">
    <div class="container">
      <a href="<?php echo esc_url( home_url( '/programmes/' ) ); ?>" style="display: inline-block; padding: var(--space-3) var(--space-6); background: var(--color-indigo); color: var(--color-white); border-radius: var(--radius-lg); text-decoration: none; font-weight: var(--font-weight-semibold);">
        ← Back to All Programmes
      </a>
    </div>
  </section>

</main>

<?php get_footer();

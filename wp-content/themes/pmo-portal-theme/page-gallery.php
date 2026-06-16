<?php
/**
 * Gallery Page Template - Displays Gallery Post Type
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
      <div style="max-width: 800px;">
        <div style="display: inline-block; padding: var(--space-1) var(--space-3); background: rgba(255, 255, 255, 0.15); border-radius: var(--radius-full); margin-bottom: var(--space-4); font-size: var(--font-size-small); font-weight: 700; letter-spacing: 0.5px;">
          🖼️ PHOTO COLLECTIONS
        </div>
        <h1 style="color: var(--color-white); margin-bottom: var(--space-4); font-size: clamp(2.5rem, 5vw, 3.5rem); line-height: 1.2; font-weight: 800; letter-spacing: -0.02em;">
          <?php the_title(); ?>
        </h1>
        <p style="color: rgba(255, 255, 255, 0.95); font-size: var(--font-size-body-lg); line-height: var(--line-height-relaxed); font-weight: 400;">
          Explore our collection of photographs and visual documentation from PMO events, programmes, and activities
        </p>
      </div>
    </div>
  </section>

  <!-- Gallery Collections Section -->
  <section style="padding: var(--space-16) var(--container-padding-desktop); background: var(--color-gray-50);">
    <div class="container">
      <!-- Header -->
      <div style="margin-bottom: var(--space-12); animation: slideInUp 0.8s ease-out;">
        <h2 style="font-size: clamp(2rem, 4vw, 2.5rem); margin-bottom: var(--space-3); font-weight: 800; color: var(--color-primary-700);">Photo Collections</h2>
        <div style="width: 120px; height: 5px; background: linear-gradient(90deg, var(--color-primary-700), var(--color-accent)); border-radius: 3px;"></div>
      </div>

      <?php
      $galleries = new WP_Query( array(
        'post_type' => 'pmo_gallery',
        'posts_per_page' => 12,
        'orderby' => 'date',
        'order' => 'DESC',
      ) );

      if ( $galleries->have_posts() ) {
        ?>
        <!-- Galleries Grid -->
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: var(--space-8);">
          <?php
          $index = 0;
          while ( $galleries->have_posts() ) {
            $galleries->the_post();
            $gallery_ids = get_post_meta( get_the_ID(), '_gallery_images', true );
            $image_count = ! empty( $gallery_ids ) ? count( explode( ',', $gallery_ids ) ) : 0;
            $first_image_id = ! empty( $gallery_ids ) ? intval( trim( explode( ',', $gallery_ids )[0] ) ) : null;
            $delay = ( $index % 6 ) * 0.1;
            $index++;
            ?>

            <a href="<?php the_permalink(); ?>" style="text-decoration: none; color: inherit;">
              <div class="gallery-card" style="background: var(--color-white); border-radius: var(--radius-xl); overflow: hidden; box-shadow: var(--shadow-md); transition: all var(--transition-base); display: flex; flex-direction: column; height: 100%; opacity: 0; transform: translateY(30px); animation: slideInUp 0.6s ease-out forwards; animation-delay: <?php echo $delay; ?>s;">

                <!-- Gallery Thumbnail -->
                <div style="position: relative; height: 280px; overflow: hidden; background: linear-gradient(135deg, var(--color-primary-700), var(--color-info));">
                  <?php
                  if ( $first_image_id ) {
                    echo wp_get_attachment_image( $first_image_id, 'large', false, array( 'style' => 'width: 100%; height: 100%; object-fit: cover; transition: transform 0.6s ease;' ) );
                  } else if ( has_post_thumbnail() ) {
                    the_post_thumbnail( 'large', array( 'style' => 'width: 100%; height: 100%; object-fit: cover; transition: transform 0.6s ease;' ) );
                  } else {
                    echo '<div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: var(--color-white); font-size: 3rem;">🖼️</div>';
                  }
                  ?>

                  <!-- Image Count Badge -->
                  <div style="position: absolute; top: var(--space-4); right: var(--space-4); background: var(--color-accent); color: var(--color-white); padding: var(--space-2) var(--space-4); border-radius: var(--radius-lg); font-weight: 700; font-size: var(--font-size-small); text-transform: uppercase; letter-spacing: 0.5px;">
                    📷 <?php echo intval( $image_count ); ?> Photos
                  </div>

                  <!-- Overlay on Hover -->
                  <div style="position: absolute; inset: 0; background: rgba(0, 0, 0, 0); display: flex; align-items: center; justify-content: center; opacity: 0; transition: all var(--transition-base); pointer-events: none;">
                    <span style="color: var(--color-white); font-size: 3rem; font-weight: bold;">👁️</span>
                  </div>
                </div>

                <!-- Content -->
                <div style="padding: var(--space-6); flex: 1; display: flex; flex-direction: column;">

                  <!-- Title -->
                  <h3 style="margin-bottom: var(--space-3); font-size: 1.2rem; line-height: 1.4; color: var(--color-primary-700); font-weight: 700; transition: color var(--transition-fast);">
                    <?php the_title(); ?>
                  </h3>

                  <!-- View Gallery Button -->
                  <div style="margin-top: auto; padding-top: var(--space-4); border-top: 1px solid var(--color-gray-100);">
                    <span style="color: var(--color-accent); font-weight: 700; display: inline-flex; align-items: center; gap: var(--space-2); transition: all var(--transition-fast); font-size: var(--font-size-small);">
                      View Gallery <span style="font-size: 1.1rem;">→</span>
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
        <?php
      } else {
        ?>
        <!-- No Galleries -->
        <div style="text-align: center; padding: var(--space-20); background: var(--color-white); border-radius: var(--radius-xl); animation: slideInUp 0.8s ease-out;">
          <div style="font-size: 4rem; margin-bottom: var(--space-4); animation: float 3s ease-in-out infinite;">🖼️</div>
          <h3 style="color: var(--color-primary-700); margin-bottom: var(--space-4); font-size: 1.5rem; font-weight: 800;">No Galleries Yet</h3>
          <p style="color: var(--color-gray-600); font-size: var(--font-size-body-lg); line-height: var(--line-height-relaxed);">
            Photo galleries will be displayed here.<br>
            <strong style="color: var(--color-primary-700);">To add galleries:</strong> Go to <strong style="color: var(--color-primary-700);">Galleries</strong> menu and create a new gallery with images.
          </p>
        </div>
        <?php
      }
      ?>
    </div>
  </section>

</main>

<?php get_footer();

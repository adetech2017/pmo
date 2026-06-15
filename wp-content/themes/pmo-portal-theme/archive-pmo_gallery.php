<?php
/**
 * Gallery Archive Template
 *
 * @package PMO_Portal_Theme
 */

get_header();
?>

<main id="main-content" class="site-content">

  <!-- Hero Section -->
  <section style="background: linear-gradient(135deg, #2c1b47 0%, #1a4d6d 50%, #0f7c9f 100%); color: var(--color-white); padding: var(--space-20) var(--container-padding-desktop); position: relative; overflow: hidden;">
    <div style="position: absolute; top: -50%; right: -10%; width: 800px; height: 800px; background: radial-gradient(circle, rgba(201, 162, 39, 0.15) 0%, transparent 70%); border-radius: 50%; pointer-events: none;"></div>
    <div style="position: absolute; bottom: -30%; left: -5%; width: 500px; height: 500px; background: radial-gradient(circle, rgba(79, 172, 254, 0.1) 0%, transparent 70%); border-radius: 50%; pointer-events: none;"></div>

    <div class="container" style="position: relative; z-index: 2;">
      <div style="max-width: 800px;">
        <div style="display: inline-block; padding: var(--space-1) var(--space-3); background: rgba(255, 255, 255, 0.2); border-radius: var(--radius-full); margin-bottom: var(--space-4); font-size: var(--font-size-small); font-weight: var(--font-weight-semibold);">
          🖼️ Visual Stories
        </div>
        <h1 style="color: var(--color-white); margin-bottom: var(--space-4); font-size: 3.5rem; line-height: 1.2; font-weight: 800;">Gallery</h1>
        <p style="color: rgba(255, 255, 255, 0.9); font-size: var(--font-size-body-lg); line-height: var(--line-height-relaxed);">
          Explore our collection of photographs and visual documentation from PMO events, programmes, and activities
        </p>
      </div>
    </div>
  </section>

  <?php if ( have_posts() ) { ?>

    <!-- Gallery Grid Section -->
    <section style="padding: var(--space-16) var(--container-padding-desktop); background: var(--color-gray-50);">
      <div class="container">
        <!-- Header -->
        <div style="margin-bottom: var(--space-12);">
          <h2 style="font-size: 2rem; margin-bottom: var(--space-2);">Photo Collections</h2>
          <div style="width: 80px; height: 4px; background: linear-gradient(90deg, var(--color-indigo), var(--color-teal)); border-radius: 2px;"></div>
        </div>

        <!-- Galleries Grid -->
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: var(--space-8);">
          <?php
          while ( have_posts() ) {
            the_post();
            $gallery_ids = get_post_meta( get_the_ID(), '_gallery_images', true );
            $image_count = ! empty( $gallery_ids ) ? count( explode( ',', $gallery_ids ) ) : 0;
            $first_image_id = ! empty( $gallery_ids ) ? intval( trim( explode( ',', $gallery_ids )[0] ) ) : null;
            ?>

            <a href="<?php the_permalink(); ?>" style="text-decoration: none; color: inherit;">
              <div style="background: var(--color-white); border-radius: var(--radius-xl); overflow: hidden; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1); transition: all 0.3s ease; display: flex; flex-direction: column; height: 100%;">

                <!-- Gallery Thumbnail -->
                <div style="position: relative; height: 280px; overflow: hidden; background: linear-gradient(135deg, var(--color-indigo), var(--color-teal));">
                  <?php
                  if ( $first_image_id ) {
                    echo wp_get_attachment_image( $first_image_id, 'large', false, array( 'style' => 'width: 100%; height: 100%; object-fit: cover;' ) );
                  } else if ( has_post_thumbnail() ) {
                    the_post_thumbnail( 'large', array( 'style' => 'width: 100%; height: 100%; object-fit: cover;' ) );
                  } else {
                    echo '<div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: var(--color-white); font-size: 3rem;">🖼️</div>';
                  }
                  ?>

                  <!-- Image Count Badge -->
                  <div style="position: absolute; top: var(--space-4); right: var(--space-4); background: var(--color-indigo); color: var(--color-white); padding: var(--space-2) var(--space-4); border-radius: var(--radius-lg); font-weight: var(--font-weight-semibold); font-size: var(--font-size-small);">
                    📷 <?php echo intval( $image_count ); ?> Photos
                  </div>
                </div>

                <!-- Content -->
                <div style="padding: var(--space-6); flex: 1; display: flex; flex-direction: column;">

                  <!-- Title -->
                  <h3 style="margin-bottom: var(--space-3); font-size: 1.3rem; line-height: 1.4; color: var(--color-primary);">
                    <?php the_title(); ?>
                  </h3>

                  <!-- View Gallery Button -->
                  <div style="margin-top: auto; padding-top: var(--space-4); border-top: 1px solid var(--color-gray-100);">
                    <span style="color: var(--color-indigo); font-weight: var(--font-weight-semibold); display: inline-flex; align-items: center; gap: var(--space-2);">
                      View Gallery <span>→</span>
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

    <!-- No Galleries -->
    <section style="padding: var(--space-20) var(--container-padding-desktop); background: var(--color-gray-50);">
      <div class="container" style="text-align: center;">
        <div style="font-size: 4rem; margin-bottom: var(--space-4);">🖼️</div>
        <h2 style="color: var(--color-primary); margin-bottom: var(--space-4); font-size: 1.8rem;">No Galleries Yet</h2>
        <p style="color: var(--color-gray-600); font-size: var(--font-size-body-lg); margin-bottom: var(--space-8); max-width: 500px; margin-left: auto; margin-right: auto;">
          Photo galleries will be displayed here as they are added. Check back soon for visual content from our events and activities.
        </p>
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="display: inline-block; padding: var(--space-3) var(--space-6); background: var(--color-indigo); color: var(--color-white); border-radius: var(--radius-lg); text-decoration: none; font-weight: var(--font-weight-semibold);">
          Back to Home
        </a>
      </div>
    </section>

  <?php } ?>

</main>

<?php get_footer();

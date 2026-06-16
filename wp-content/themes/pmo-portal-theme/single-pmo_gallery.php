<?php
/**
 * Single Gallery Template
 *
 * @package PMO_Portal_Theme
 */

get_header();
?>

<main id="main-content" class="site-content">

  <!-- Hero Section -->
  <section style="background: linear-gradient(135deg, var(--color-primary-700) 0%, var(--color-primary-600) 50%, var(--color-info) 100%); color: var(--color-white); padding: var(--space-16) var(--container-padding-desktop); position: relative; overflow: hidden;">
    <!-- Decorative elements -->
    <div style="position: absolute; top: -50%; right: -10%; width: 800px; height: 800px; background: radial-gradient(circle, rgba(201, 162, 39, 0.12) 0%, transparent 70%); border-radius: 50%; pointer-events: none; animation: float 6s ease-in-out infinite;"></div>

    <div class="container" style="position: relative; z-index: 2; animation: slideInUp 0.8s ease-out;">
      <a href="<?php echo esc_url( home_url( '/gallery/' ) ); ?>" style="color: rgba(255, 255, 255, 0.8); text-decoration: none; display: inline-block; margin-bottom: var(--space-4); transition: color var(--transition-fast); font-weight: 600;">
        ← Back to Gallery
      </a>
      <h1 style="color: var(--color-white); margin-bottom: var(--space-2); font-size: clamp(2rem, 5vw, 3.5rem); line-height: 1.2; font-weight: 800; letter-spacing: -0.02em;">
        <?php the_title(); ?>
      </h1>
    </div>
  </section>

  <div class="container" style="padding: var(--space-16) 0;">
    <!-- Description -->
    <?php if ( has_excerpt() || get_the_content() ) { ?>
      <div style="background: var(--color-white); padding: var(--space-8); border-radius: var(--radius-xl); box-shadow: var(--shadow-md); margin-bottom: var(--space-12); max-width: 800px; animation: slideInUp 0.8s ease-out;">
        <div style="color: var(--color-gray-700); line-height: var(--line-height-relaxed); font-size: var(--font-size-body-lg); font-weight: 400;">
          <?php
          if ( has_excerpt() ) {
            the_excerpt();
          } else {
            the_content();
          }
          ?>
        </div>
      </div>
    <?php } ?>

    <!-- Gallery Grid -->
    <?php
    $gallery_ids = get_post_meta( get_the_ID(), '_gallery_images', true );

    if ( ! empty( $gallery_ids ) ) {
      $ids_array = array_filter( array_map( 'intval', explode( ',', $gallery_ids ) ) );

      if ( ! empty( $ids_array ) ) {
        ?>
        <div style="margin-bottom: var(--space-12); animation: slideInUp 0.8s ease-out;">
          <h2 style="font-size: 1.8rem; margin-bottom: var(--space-3); color: var(--color-primary-700); font-weight: 800;">
            📸 Photo Gallery
          </h2>
          <p style="color: var(--color-gray-600); margin-bottom: var(--space-8); font-size: var(--font-size-small);">
            <?php echo count( $ids_array ); ?> Image<?php echo count( $ids_array ) !== 1 ? 's' : ''; ?> • Click any image to view full size
          </p>

          <!-- Masonry Gallery Grid -->
          <div class="gallery-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: var(--space-6); grid-auto-rows: 300px;">
            <?php
            $img_index = 0;
            foreach ( $ids_array as $image_id ) {
              $image_url = wp_get_attachment_image_url( $image_id, 'large' );
              $image_alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true );

              if ( $image_url ) {
                $img_delay = ( $img_index % 6 ) * 0.1;
                $img_index++;
                ?>
                <div class="gallery-item" style="position: relative; border-radius: var(--radius-xl); overflow: hidden; box-shadow: var(--shadow-md); transition: all var(--transition-base); cursor: pointer; opacity: 0; animation: slideInUp 0.6s ease-out forwards; animation-delay: <?php echo $img_delay; ?>s;" onclick="openLightbox('<?php echo esc_attr( $image_url ); ?>', '<?php echo esc_attr( $image_alt ); ?>')">
                  <img
                    src="<?php echo esc_url( $image_url ); ?>"
                    alt="<?php echo esc_attr( $image_alt ); ?>"
                    style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.6s ease; backface-visibility: hidden;"
                    loading="lazy"
                  >
                  <div style="position: absolute; inset: 0; background: rgba(0, 0, 0, 0); display: flex; align-items: center; justify-content: center; opacity: 0; transition: all var(--transition-base);">
                    <span style="color: var(--color-white); font-size: 2.5rem;">🔍</span>
                  </div>
                </div>
                <?php
              }
            }
            ?>
          </div>
        </div>
        <?php
      }
    } else {
      ?>
      <div style="text-align: center; padding: var(--space-16); background: var(--color-gray-50); border-radius: var(--radius-xl); animation: slideInUp 0.8s ease-out;">
        <div style="font-size: 3rem; margin-bottom: var(--space-4); animation: float 3s ease-in-out infinite;">🖼️</div>
        <p style="color: var(--color-gray-600); font-size: var(--font-size-body-lg); font-weight: 400;">
          No images in this gallery yet.
        </p>
      </div>
      <?php
    }
    ?>
  </div>

  <!-- Lightbox Modal -->
  <div id="lightbox" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0, 0, 0, 0.98); z-index: 9999; align-items: center; justify-content: center; animation: fadeIn 0.3s ease;">
    <!-- Close Button -->
    <button style="position: absolute; top: 20px; right: 30px; background: none; border: none; color: white; font-size: 40px; cursor: pointer; transition: all var(--transition-fast); opacity: 0.8; width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;" onmouseover="this.style.opacity='1'; this.style.transform='scale(1.1)'" onmouseout="this.style.opacity='0.8'; this.style.transform='scale(1)'" onclick="closeLightbox()">×</button>

    <!-- Image Container -->
    <img id="lightbox-image" src="" alt="" style="max-width: 90%; max-height: 85%; border-radius: var(--radius-lg); box-shadow: 0 24px 64px rgba(0, 0, 0, 0.4); animation: zoomIn 0.4s ease;">

    <!-- Image Info -->
    <p id="lightbox-alt" style="position: absolute; bottom: 30px; color: rgba(255, 255, 255, 0.8); font-size: 14px; text-align: center; max-width: 80%; line-height: 1.5;"></p>
  </div>

  <!-- Back Link -->
  <section style="padding: var(--space-12) var(--container-padding-desktop); text-align: center; border-top: 1px solid var(--color-gray-100); background: var(--color-white);">
    <div class="container" style="animation: slideInUp 0.8s ease-out;">
      <a href="<?php echo esc_url( home_url( '/gallery/' ) ); ?>" style="display: inline-block; padding: var(--space-3) var(--space-8); background: linear-gradient(135deg, var(--color-primary-700), var(--color-primary-600)); color: var(--color-white); border-radius: var(--radius-lg); text-decoration: none; font-weight: 700; transition: all var(--transition-base); box-shadow: var(--shadow-md); font-size: var(--font-size-body);">
        ← Back to All Galleries
      </a>
    </div>
  </section>

</main>

<script>
function openLightbox(imageSrc, imageAlt) {
  const lightbox = document.getElementById('lightbox');
  const img = document.getElementById('lightbox-image');
  const alt = document.getElementById('lightbox-alt');

  img.src = imageSrc;
  alt.textContent = imageAlt;
  lightbox.style.display = 'flex';
}

function closeLightbox() {
  const lightbox = document.getElementById('lightbox');
  lightbox.style.display = 'none';
}

// Close lightbox when clicking outside image
document.getElementById('lightbox')?.addEventListener('click', function(e) {
  if (e.target.id === 'lightbox') {
    closeLightbox();
  }
});

// Close on ESC key
document.addEventListener('keydown', function(e) {
  if (e.key === 'Escape') {
    closeLightbox();
  }
});
</script>

<?php get_footer();

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
  <section style="background: linear-gradient(135deg, #2c1b47 0%, #1a4d6d 50%, #0f7c9f 100%); color: var(--color-white); padding: var(--space-16) var(--container-padding-desktop); position: relative; overflow: hidden;">
    <div style="position: absolute; top: -50%; right: -10%; width: 800px; height: 800px; background: radial-gradient(circle, rgba(201, 162, 39, 0.15) 0%, transparent 70%); border-radius: 50%; pointer-events: none;"></div>

    <div class="container" style="position: relative; z-index: 2;">
      <a href="<?php echo esc_url( home_url( '/gallery/' ) ); ?>" style="color: rgba(255, 255, 255, 0.8); text-decoration: none; display: inline-block; margin-bottom: var(--space-4);">
        ← Back to Gallery
      </a>
      <h1 style="color: var(--color-white); margin-bottom: var(--space-2); font-size: 3rem; line-height: 1.2;">
        <?php the_title(); ?>
      </h1>
    </div>
  </section>

  <div class="container" style="padding: var(--space-16) 0;">
    <!-- Description -->
    <?php if ( has_excerpt() || get_the_content() ) { ?>
      <div style="background: var(--color-white); padding: var(--space-8); border-radius: var(--radius-xl); box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08); margin-bottom: var(--space-12); max-width: 800px;">
        <div style="color: var(--color-gray-700); line-height: var(--line-height-relaxed); font-size: var(--font-size-body-lg);">
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
        <div style="margin-bottom: var(--space-12);">
          <h2 style="font-size: 1.8rem; margin-bottom: var(--space-8); color: var(--color-primary);">
            Photo Gallery (<?php echo count( $ids_array ); ?> Images)
          </h2>

          <!-- Masonry Gallery Grid -->
          <div class="gallery-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: var(--space-6); grid-auto-rows: 300px;">
            <?php
            foreach ( $ids_array as $image_id ) {
              $image_url = wp_get_attachment_image_url( $image_id, 'large' );
              $image_alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true );

              if ( $image_url ) {
                ?>
                <div class="gallery-item" style="position: relative; border-radius: var(--radius-xl); overflow: hidden; box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12); transition: all 0.3s ease; cursor: pointer;" onclick="openLightbox('<?php echo esc_attr( $image_url ); ?>', '<?php echo esc_attr( $image_alt ); ?>')">
                  <img
                    src="<?php echo esc_url( $image_url ); ?>"
                    alt="<?php echo esc_attr( $image_alt ); ?>"
                    style="width: 100%; height: 100%; object-fit: cover; transition: all 0.3s ease;"
                    onmouseover="this.style.transform='scale(1.05)'"
                    onmouseout="this.style.transform='scale(1)'"
                  >
                  <div style="position: absolute; inset: 0; background: rgba(0, 0, 0, 0.3); display: flex; align-items: center; justify-content: center; opacity: 0; transition: opacity 0.3s ease;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0'">
                    <span style="color: var(--color-white); font-size: 2rem; font-weight: bold;">🔍</span>
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
      <div style="text-align: center; padding: var(--space-16); background: var(--color-gray-50); border-radius: var(--radius-xl);">
        <div style="font-size: 3rem; margin-bottom: var(--space-4);">🖼️</div>
        <p style="color: var(--color-gray-600); font-size: var(--font-size-body-lg);">
          No images in this gallery yet.
        </p>
      </div>
      <?php
    }
    ?>
  </div>

  <!-- Lightbox Modal -->
  <div id="lightbox" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0, 0, 0, 0.95); z-index: 9999; align-items: center; justify-content: center;">
    <button style="position: absolute; top: 20px; right: 30px; background: none; border: none; color: white; font-size: 32px; cursor: pointer;" onclick="closeLightbox()">×</button>

    <img id="lightbox-image" src="" alt="" style="max-width: 90%; max-height: 90%; border-radius: var(--radius-lg);">

    <p id="lightbox-alt" style="position: absolute; bottom: 30px; color: rgba(255, 255, 255, 0.8); font-size: 14px; text-align: center; max-width: 80%;"></p>
  </div>

  <!-- Back Link -->
  <section style="padding: var(--space-8) var(--container-padding-desktop); text-align: center; border-top: 1px solid var(--color-gray-100);">
    <div class="container">
      <a href="<?php echo esc_url( home_url( '/gallery/' ) ); ?>" style="display: inline-block; padding: var(--space-3) var(--space-6); background: var(--color-indigo); color: var(--color-white); border-radius: var(--radius-lg); text-decoration: none; font-weight: var(--font-weight-semibold);">
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

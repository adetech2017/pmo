<?php
/**
 * Single Leadership Template - Premium Design
 *
 * @package PMO_Portal_Theme
 */

get_header();
?>

<main id="main-content" class="site-content">
  <div class="container" style="padding-top: var(--space-12); padding-bottom: var(--space-12);">
    <article id="post-<?php the_ID(); ?>" <?php post_class( 'card' ); ?> style="background-color: var(--color-white); border: 1px solid var(--color-gray-100); border-radius: var(--radius-lg); padding: var(--space-8); max-width: 600px; margin: 0 auto; text-align: center;">

      <?php if ( has_post_thumbnail() ) { ?>
        <div style="margin-bottom: var(--space-8); border-radius: var(--radius-full); overflow: hidden; width: 200px; height: 200px; margin-left: auto; margin-right: auto;">
          <?php the_post_thumbnail( 'medium', array( 'style' => 'width: 100%; height: 100%; object-fit: cover;' ) ); ?>
        </div>
      <?php } ?>

      <header style="margin-bottom: var(--space-8);">
        <h1 style="font-size: var(--font-size-h1); color: var(--color-primary); margin-bottom: var(--space-2);"><?php the_title(); ?></h1>
        <?php
        $position = get_post_meta( get_the_ID(), '_leadership_position', true );
        if ( $position ) {
          echo '<div style="font-size: var(--font-size-body-lg); color: var(--color-accent); font-weight: var(--font-weight-semibold);">' . esc_html( $position ) . '</div>';
        }
        ?>
      </header>

      <div class="entry-content" style="font-size: var(--font-size-body); line-height: var(--line-height-relaxed); color: var(--color-gray-700); margin-bottom: var(--space-8);">
        <?php the_content(); ?>
      </div>

      <?php
      $phone = get_post_meta( get_the_ID(), '_leadership_phone', true );
      $email = get_post_meta( get_the_ID(), '_leadership_email', true );
      $office = get_post_meta( get_the_ID(), '_leadership_office', true );

      if ( $phone || $email || $office ) {
      ?>
      <div style="background-color: var(--color-gray-50); padding: var(--space-6); border-radius: var(--radius-lg);">
        <?php if ( $phone ) { ?>
          <div style="margin-bottom: var(--space-3);">
            <strong>Phone:</strong> <?php echo esc_html( $phone ); ?>
          </div>
        <?php } ?>
        <?php if ( $email ) { ?>
          <div style="margin-bottom: var(--space-3);">
            <strong>Email:</strong> <a href="mailto:<?php echo esc_attr( $email ); ?>" style="color: var(--color-accent);"><?php echo esc_html( $email ); ?></a>
          </div>
        <?php } ?>
        <?php if ( $office ) { ?>
          <div>
            <strong>Office:</strong> <?php echo esc_html( $office ); ?>
          </div>
        <?php } ?>
      </div>
      <?php } ?>

      <footer style="border-top: 1px solid var(--color-gray-200); padding-top: var(--space-8); margin-top: var(--space-8);">
        <a href="<?php echo esc_url( home_url( '/leadership' ) ); ?>" class="btn btn-primary">Back to Team</a>
      </footer>

    </article>
  </div>
</main>

<?php get_footer(); ?>

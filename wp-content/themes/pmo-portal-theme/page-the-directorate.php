<?php
/**
 * The Directorate Page - Staff Directory
 *
 * @package PMO_Portal_Theme
 */

get_header();
?>

<main id="main-content" class="site-content">

  <!-- Hero Section -->
  <section class="section about-hero">
    <div class="container">
      <h1>The Directorate</h1>
      <p>Meet the leadership team steering the Parastatals Monitoring Office</p>
    </div>
  </section>

  <!-- Main Directorate Section -->
  <section class="section directorate-section">
    <div class="container">

      <!-- Executive Leadership Section -->
      <div class="section-header exec-section-header">
        <h2>Executive Leadership</h2>
        <p>Senior management overseeing PMO operations</p>
      </div>

      <?php
      $exec_args = array(
        'post_type'      => 'pmo_directorate',
        'posts_per_page' => -1,
        'orderby'        => 'meta_value_num',
        'meta_key'       => '_display_order',
        'order'          => 'ASC',
        'meta_query'     => array(
          array(
            'key'     => '_position_level',
            'value'   => 'executive',
            'compare' => '=',
          ),
        ),
      );
      $exec_query = new WP_Query( $exec_args );
      ?>

      <div class="exec-grid">
        <?php
        if ( $exec_query->have_posts() ) {
          while ( $exec_query->have_posts() ) {
            $exec_query->the_post();
            $position_level = get_post_meta( get_the_ID(), '_position_level', true );
            $staff_role = get_post_meta( get_the_ID(), '_staff_role', true );
            $department = get_post_meta( get_the_ID(), '_department', true );
            $dept_color = get_post_meta( get_the_ID(), '_department_color', true );
            $email = get_post_meta( get_the_ID(), '_email', true );
            $phone = get_post_meta( get_the_ID(), '_phone', true );
            $image_id = get_post_thumbnail_id( get_the_ID() );
            $image_url = wp_get_attachment_image_url( $image_id, 'full' );

            if ( ! $dept_color ) {
              $dept_color = '#3b82f6';
            }

            // Get initials from name
            $name = get_the_title();
            $initials = implode( '', array_map( function( $word ) {
              return strtoupper( substr( $word, 0, 1 ) );
            }, explode( ' ', $name ) ) );
            ?>
            <div class="exec-card">
              <div class="exec-photo photo-exec">
                <?php if ( $image_url ) : ?>
                  <img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $name ); ?>" style="width: 100%; height: 100%; object-fit: cover; object-position: top;">
                <?php else : ?>
                  <div class="exec-photo-circle photo-exec-circle"><?php echo esc_html( substr( $initials, 0, 3 ) ); ?></div>
                <?php endif; ?>
              </div>
              <div class="exec-card-body">
                <span class="badge" style="background: <?php echo esc_attr( $dept_color ); ?>40; color: <?php echo esc_attr( $dept_color ); ?>; border: 1px solid <?php echo esc_attr( $dept_color ); ?>80;">
                  <?php echo esc_html( ! empty( $department ) ? $department : 'Executive' ); ?>
                </span>
                <p class="exec-name"><?php echo esc_html( $name ); ?></p>
                <p class="staff-role" style="color: <?php echo esc_attr( $dept_color ); ?>;"><?php echo esc_html( $staff_role ); ?></p>
                <p class="staff-desc"><?php echo wp_kses_post( get_the_excerpt() ); ?></p>
                <div class="exec-contact">
                  <?php if ( $email ) : ?>
                    <div class="contact-row">
                      <i class="fas fa-envelope" style="color: <?php echo esc_attr( $dept_color ); ?>;"></i>
                      <a href="mailto:<?php echo esc_attr( $email ); ?>" style="color: <?php echo esc_attr( $dept_color ); ?>;"><?php echo esc_html( $email ); ?></a>
                    </div>
                  <?php endif; ?>
                  <?php if ( $phone ) : ?>
                    <div class="contact-row">
                      <i class="fas fa-phone" style="color: <?php echo esc_attr( $dept_color ); ?>;"></i>
                      <span><?php echo esc_html( $phone ); ?></span>
                    </div>
                  <?php endif; ?>
                </div>
              </div>
            </div>
            <?php
          }
          wp_reset_postdata();
        } else {
          echo '<p>No executives found.</p>';
        }
        ?>
      </div>

      <!-- Department Staff Section -->
      <div class="section-header" style="margin-top: 4rem;">
        <h2>Department Staff</h2>
        <p>Directors across key operational departments</p>
      </div>

      <?php
      $dept_args = array(
        'post_type'      => 'pmo_directorate',
        'posts_per_page' => -1,
        'orderby'        => 'meta_value_num',
        'meta_key'       => '_display_order',
        'order'          => 'ASC',
        'meta_query'     => array(
          array(
            'key'     => '_position_level',
            'value'   => 'director',
            'compare' => '=',
          ),
        ),
      );
      $dept_query = new WP_Query( $dept_args );
      ?>

      <div class="dept-grid">
        <?php
        if ( $dept_query->have_posts() ) {
          while ( $dept_query->have_posts() ) {
            $dept_query->the_post();
            $staff_role = get_post_meta( get_the_ID(), '_staff_role', true );
            $department = get_post_meta( get_the_ID(), '_department', true );
            $dept_color = get_post_meta( get_the_ID(), '_department_color', true );
            $image_id = get_post_thumbnail_id( get_the_ID() );
            $image_url = wp_get_attachment_image_url( $image_id, 'full' );

            if ( ! $dept_color ) {
              $dept_color = '#3b82f6';
            }

            // Get initials from name
            $name = get_the_title();
            $initials = implode( '', array_map( function( $word ) {
              return strtoupper( substr( $word, 0, 1 ) );
            }, explode( ' ', $name ) ) );
            ?>
            <div class="dept-card">
              <div class="dept-photo" style="background: linear-gradient(135deg, <?php echo esc_attr( $dept_color ); ?>40, <?php echo esc_attr( $dept_color ); ?>20);">
                <?php if ( $image_url ) : ?>
                  <img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $name ); ?>" style="width: 100%; height: 100%; object-fit: cover; object-position: top;">
                <?php else : ?>
                  <div class="dept-photo-circle" style="background: <?php echo esc_attr( $dept_color ); ?>;"><?php echo esc_html( substr( $initials, 0, 2 ) ); ?></div>
                <?php endif; ?>
              </div>
              <div class="dept-card-body">
                <span class="badge" style="background: <?php echo esc_attr( $dept_color ); ?>40; color: <?php echo esc_attr( $dept_color ); ?>; border: 1px solid <?php echo esc_attr( $dept_color ); ?>80;">
                  <?php echo esc_html( ! empty( $department ) ? $department : 'Department' ); ?>
                </span>
                <p class="staff-name"><?php echo esc_html( $name ); ?></p>
                <p class="staff-role" style="color: <?php echo esc_attr( $dept_color ); ?>;"><?php echo esc_html( $staff_role ); ?></p>
                <p class="staff-desc"><?php echo wp_kses_post( get_the_excerpt() ); ?></p>
              </div>
            </div>
            <?php
          }
          wp_reset_postdata();
        } else {
          echo '<p>No department staff found.</p>';
        }
        ?>
      </div>

    </div>
  </section>

</main>

<?php get_footer(); ?>

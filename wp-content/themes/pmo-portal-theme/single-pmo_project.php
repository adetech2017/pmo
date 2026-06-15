<?php
/**
 * Single Project Template - Premium Design
 *
 * @package PMO_Portal_Theme
 */

get_header();
?>

<main id="main-content" class="site-content">
  <div class="container" style="padding-top: var(--space-12); padding-bottom: var(--space-12);">
    <div style="display: grid; grid-template-columns: 1fr 300px; gap: var(--space-8);">

      <article id="post-<?php the_ID(); ?>" <?php post_class( 'card' ); ?> style="background-color: var(--color-white); border: 1px solid var(--color-gray-100); border-radius: var(--radius-lg); padding: var(--space-8);">

        <?php if ( has_post_thumbnail() ) { ?>
          <div style="margin-bottom: var(--space-8); border-radius: var(--radius-lg); overflow: hidden;">
            <?php the_post_thumbnail( 'large', array( 'style' => 'width: 100%; height: auto; display: block;' ) ); ?>
          </div>
        <?php } ?>

        <header style="margin-bottom: var(--space-8);">
          <h1 style="font-size: var(--font-size-h1); color: var(--color-primary); margin-bottom: var(--space-4);"><?php the_title(); ?></h1>
          <div style="color: var(--color-gray-600); font-size: var(--font-size-small);">
            By <?php the_author(); ?> on <?php echo esc_html( get_the_date( 'F j, Y' ) ); ?>
          </div>
        </header>

        <div style="background-color: var(--color-gray-50); padding: var(--space-6); border-radius: var(--radius-lg); margin-bottom: var(--space-8);">
          <h3 style="margin-bottom: var(--space-6); font-size: var(--font-size-h3);">Project Details</h3>
          <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: var(--space-6);">
            <?php
            $fields = array(
              'Project Code' => '_pmo_project_code',
              'Contractor' => '_pmo_contractor',
              'Funding Source' => '_pmo_funding_source',
              'Beneficiaries' => '_pmo_beneficiaries',
              'Location' => '_pmo_location',
            );

            foreach ( $fields as $label => $meta_key ) {
              $value = get_post_meta( get_the_ID(), $meta_key, true );
              if ( $value ) {
                echo '<div>';
                echo '<div style="font-size: var(--font-size-small); color: var(--color-gray-600); font-weight: var(--font-weight-semibold); margin-bottom: var(--space-2);">' . esc_html( $label ) . '</div>';
                echo '<div>' . esc_html( $value ) . '</div>';
                echo '</div>';
              }
            }

            $budget = get_post_meta( get_the_ID(), '_pmo_budget', true );
            if ( $budget ) {
              echo '<div>';
              echo '<div style="font-size: var(--font-size-small); color: var(--color-gray-600); font-weight: var(--font-weight-semibold); margin-bottom: var(--space-2);">Budget</div>';
              echo '<div>₦' . esc_html( number_format( $budget, 2 ) ) . '</div>';
              echo '</div>';
            }
            ?>
          </div>
        </div>

        <?php
        $start_date = get_post_meta( get_the_ID(), '_pmo_start_date', true );
        $expected = get_post_meta( get_the_ID(), '_pmo_expected_completion', true );
        $actual = get_post_meta( get_the_ID(), '_pmo_actual_completion', true );
        ?>
        <?php if ( $start_date || $expected || $actual ) { ?>
          <div style="background-color: var(--color-gray-50); padding: var(--space-6); border-radius: var(--radius-lg); margin-bottom: var(--space-8);">
            <h3 style="margin-bottom: var(--space-6); font-size: var(--font-size-h3);">Project Timeline</h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: var(--space-6);">
              <?php if ( $start_date ) { ?>
                <div>
                  <div style="font-size: var(--font-size-small); color: var(--color-gray-600); font-weight: var(--font-weight-semibold); margin-bottom: var(--space-2);">Start Date</div>
                  <div><?php echo esc_html( wp_date( 'F j, Y', strtotime( $start_date ) ) ); ?></div>
                </div>
              <?php } ?>
              <?php if ( $expected ) { ?>
                <div>
                  <div style="font-size: var(--font-size-small); color: var(--color-gray-600); font-weight: var(--font-weight-semibold); margin-bottom: var(--space-2);">Expected Completion</div>
                  <div><?php echo esc_html( wp_date( 'F j, Y', strtotime( $expected ) ) ); ?></div>
                </div>
              <?php } ?>
              <?php if ( $actual ) { ?>
                <div>
                  <div style="font-size: var(--font-size-small); color: var(--color-gray-600); font-weight: var(--font-weight-semibold); margin-bottom: var(--space-2);">Actual Completion</div>
                  <div><?php echo esc_html( wp_date( 'F j, Y', strtotime( $actual ) ) ); ?></div>
                </div>
              <?php } ?>
            </div>
          </div>
        <?php } ?>

        <?php
        $progress = get_post_meta( get_the_ID(), '_pmo_progress_percentage', true );
        if ( $progress ) {
        ?>
        <div style="background-color: var(--color-gray-50); padding: var(--space-6); border-radius: var(--radius-lg); margin-bottom: var(--space-8);">
          <h3 style="margin-bottom: var(--space-6); font-size: var(--font-size-h3);">Project Progress</h3>
          <div style="margin-top: var(--space-4);">
            <div style="height: 40px; background: var(--color-gray-200); border-radius: var(--radius-lg); overflow: hidden;">
              <div style="background: linear-gradient(90deg, var(--color-success), var(--color-primary-light)); height: 100%; width: <?php echo esc_attr( $progress ); ?>%; transition: width 0.3s ease; display: flex; align-items: center; justify-content: center; color: var(--color-white); font-weight: var(--font-weight-bold); font-size: var(--font-size-small);">
                <?php echo esc_html( $progress . '%' ); ?>
              </div>
            </div>
          </div>
        </div>
        <?php } ?>

        <div class="entry-content" style="font-size: var(--font-size-body); line-height: var(--line-height-relaxed); color: var(--color-gray-700); margin-bottom: var(--space-8);">
          <?php the_content(); ?>
        </div>

        <?php
        $documents = get_post_meta( get_the_ID(), '_pmo_documents', true );
        if ( $documents ) {
        ?>
        <div style="background-color: var(--color-gray-50); padding: var(--space-6); border-radius: var(--radius-lg); margin-bottom: var(--space-8);">
          <h3 style="margin-bottom: var(--space-6); font-size: var(--font-size-h3);">Project Documents</h3>
          <?php
          $doc_list = explode( "\n", $documents );
          foreach ( $doc_list as $doc ) {
            $doc = trim( $doc );
            if ( $doc ) {
              echo '<p style="margin-bottom: var(--space-2);"><a href="' . esc_url( $doc ) . '" target="_blank" rel="noopener" style="color: var(--color-accent); text-decoration: none; font-weight: var(--font-weight-semibold);">📄 ' . esc_html( basename( parse_url( $doc, PHP_URL_PATH ) ) ) . '</a></p>';
            }
          }
          ?>
        </div>
        <?php } ?>

        <footer style="border-top: 1px solid var(--color-gray-200); padding-top: var(--space-8); margin-top: var(--space-8);">
          <nav style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: var(--space-4);">
            <div>
              <?php previous_post_link( '%link', '← Previous', false, '', 'pmo_project' ); ?>
            </div>
            <div>
              <a href="<?php echo esc_url( home_url( '/projects' ) ); ?>" class="btn btn-outline">All Projects</a>
            </div>
            <div>
              <?php next_post_link( '%link', 'Next →', false, '', 'pmo_project' ); ?>
            </div>
          </nav>
        </footer>

      </article>

      <aside style="display: flex; flex-direction: column; gap: var(--space-6);">
        <?php dynamic_sidebar( 'primary-sidebar' ); ?>
      </aside>

    </div>
  </div>
</main>

<?php get_footer();

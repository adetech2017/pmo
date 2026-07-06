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
  <section class="section" style="background: linear-gradient(135deg, var(--color-primary-700) 0%, var(--color-primary-600) 50%, var(--color-primary-400) 100%); color: var(--color-white); padding: var(--space-16) var(--container-padding-desktop); position: relative; overflow: hidden;">
    <!-- Decorative elements -->
    <div style="position: absolute; top: -50%; right: -10%; width: 600px; height: 600px; background: radial-gradient(circle, rgba(201, 162, 39, 0.12) 0%, transparent 70%); border-radius: 50%; pointer-events: none; animation: float 6s ease-in-out infinite;"></div>
    <div style="position: absolute; bottom: -30%; left: -5%; width: 500px; height: 500px; background: radial-gradient(circle, rgba(201, 162, 39, 0.06) 0%, transparent 70%); border-radius: 50%; pointer-events: none; animation: float 8s ease-in-out infinite 1s;"></div>

    <div class="container" style="position: relative; z-index: 2; animation: slideInUp 0.8s ease-out;">
      <div style="display: inline-block; padding: var(--space-1) var(--space-3); background: rgba(255, 255, 255, 0.15); border-radius: var(--radius-full); margin-bottom: var(--space-4); font-size: var(--font-size-small); font-weight: 700; letter-spacing: 0.5px;">
        <i class="fa-solid fa-scale-balanced" aria-hidden="true"></i> OUR MANDATE
      </div>
      <h1 style="color: var(--color-white); margin-bottom: var(--space-4); font-size: clamp(2.5rem, 5vw, 3.5rem); font-weight: 800; letter-spacing: -0.02em;">Our Mandate</h1>
      <p style="color: rgba(255, 255, 255, 0.95); font-size: var(--font-size-body-lg); line-height: var(--line-height-relaxed); max-width: 600px; font-weight: 400;">The statutory responsibilities of the Lagos State Parastatals Monitoring Office</p>
    </div>
  </section>

  <!-- Our Mandates Section -->
  <section class="section" style="background: var(--color-white);">
    <div class="container">
      <div class="section-header">
        <h2>Our Mandates</h2>
        <p>The functions assigned to the Parastatals Monitoring Office</p>
      </div>

      <?php
      $pmo_mandates = array(
        'Initiate, formulate, execute, monitor and evaluate policies relating to effective and efficient monitoring of Parastatal Organizations.',
        'Ensure that State parastatals are managed and run in accordance with the administrative guidelines.',
        'Prepare for the consideration of Government, consolidated annual report on Parastatals organization and government-owned companies.',
        'Set performance targets for Parastatals and Government owned companies, including Service Level Agreements.',
        'Monitor and evaluate performance of parastatals and government owned companies based on defined Key Performance Indicators to ensure that set targets are achieved and revenue targets are met where applicable.',
        'Ensure that all capital projects of all Parastatals and government owned companies get pre-payment inspection certificate from the Ministry of Economic Planning and Budget.',
        'In conjunction with other agencies of Government, initiate, identify and promote new projects and programs which have linkages with existing government expenditure and activities.',
        'Where necessary, recommend the streamlining of activities of Agencies and clarify their mandate to enhance their effectiveness and efficiency.',
        'Ensure the provision of a shared service IT infrastructure to ensure on-line presence and automate business processes towards full digitalization of all processes.',
        'Acting as the secretariat for transmitting all executive decisions and directives affecting all Parastatals, including the servicing of the quarterly meetings of chairmen of Parastatals organizations with the State Chief Executive, and as Liaison Office between the State Government and other Governments of the Federation in matters relating to Parastatals.',
        'Participating at statutory meetings of all parastatals e.g. appointment, promotion and disciplinary committee, departmental tenders board, funds Management Committee, etc.',
        'Participating at State Committees and other meetings in which matters relating to parastatals and Government-owned companies are discussed e.g. Financial Review Committee Meetings.',
        'Ensuring compliance with government financial guidelines and other financial accounting instructions.',
        'Ensuring rendition of up-to-date audited accounts and financial reports of parastatals organisations and Government-owned Companies within six months after the end of the preceding financial year.',
        'Routinely inspecting the accounts, bank statements and reconciliation of accounts, revenue performance and expenditure behaviour.',
        'Receiving and commenting on minutes of meetings of Board of Directors and management of Government-owned Companies and Parastatals in the State.',
        'Initiate, in conjunction with the Ministry of Justice, liquidation procedure where necessary and considered expedient, on any moribund Parastatals organisations and Government-owned companies.',
        'Organizing, in consultation with other MDAs, seminars, conferences and courses of instruction which are of collective value.',
        'Pensions and gratuity management/administration for parastatals, including verification of pensioners.',
        'Retreat with Chief Executives of Parastatals.',
        'Carry out any other cognate duties that may be assigned by the Chief Executive of the State.',
      );
      ?>

      <div class="mandates-list" style="max-width: 900px; margin: 0 auto var(--space-16) auto;">
        <?php
        $mandate_groups = array(
          __( 'Policy & Performance Mandates', 'pmo-portal' )              => array_slice( $pmo_mandates, 0, 9 ),
          __( 'Oversight & Administrative Responsibilities', 'pmo-portal' ) => array_slice( $pmo_mandates, 9 ),
        );
        $mandate_number = 0;
        foreach ( $mandate_groups as $group_title => $group_items ) {
          ?>
          <h3 style="color: var(--color-primary-700); font-size: 1.3rem; font-weight: 700; margin: var(--space-8) 0 var(--space-5) 0; padding-bottom: var(--space-3); border-bottom: 2px solid var(--color-gray-100);">
            <?php echo esc_html( $group_title ); ?>
          </h3>
          <?php foreach ( $group_items as $mandate ) {
            $mandate_number++;
            ?>
            <div class="mandate-item" style="display: flex; gap: var(--space-5); align-items: flex-start; padding: var(--space-5) var(--space-6); background: var(--color-gray-50); border-radius: var(--radius-lg); border-left: 4px solid var(--color-primary); margin-bottom: var(--space-4);">
              <div style="flex-shrink: 0; width: 44px; height: 44px; display: flex; align-items: center; justify-content: center; background: var(--color-primary); color: var(--color-white); font-weight: 800; border-radius: var(--radius-md); font-size: 1.05rem;">
                <?php echo intval( $mandate_number ); ?>
              </div>
              <p style="margin: 0; color: var(--color-gray-700); line-height: var(--line-height-relaxed);">
                <?php echo esc_html( $mandate ); ?>
              </p>
            </div>
          <?php } ?>
        <?php } ?>
      </div>

      <style>
        .mandate-item {
          transition: all var(--transition-base);
        }

        .mandate-item:hover {
          box-shadow: var(--shadow-md);
          transform: translateX(6px);
        }
      </style>

      <!-- Programmes Overview -->
      <div class="section-header">
        <h2>Strategic Programmes &amp; Initiatives</h2>
        <p>How we deliver on the mandate</p>
      </div>

      <div style="max-width: 800px; margin: 0 auto var(--space-16) auto; text-align: center;">
        <p style="font-size: var(--font-size-body-lg); color: var(--color-gray-700); line-height: var(--line-height-relaxed); font-weight: 400;">
          The PMO implements strategic programmes across key sectors to monitor, evaluate, and enhance the performance of Lagos State parastatals and government agencies.
        </p>
      </div>

      <!-- Programmes Grid -->
      <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(min(100%, 320px), 1fr)); gap: var(--space-8); margin-bottom: var(--space-16);">
        <?php
        $programmes_args = array(
          'post_type'      => 'pmo_programme',
          'posts_per_page' => 24,
          'orderby'        => 'title',
          'order'          => 'ASC',
        );
        $programmes_query = new WP_Query( $programmes_args );

        if ( $programmes_query->have_posts() ) {
          $index = 0;
          while ( $programmes_query->have_posts() ) {
            $programmes_query->the_post();
            $status = get_post_meta( get_the_ID(), '_programme_status', true );
            $budget = get_post_meta( get_the_ID(), '_programme_budget', true );
            $completion = intval( get_post_meta( get_the_ID(), '_programme_completion', true ) );

            // Status badge colors
            $status_color = '#047857'; // success
            if ( $status === 'Planned' ) $status_color = '#0369a1';
            elseif ( $status === 'In Progress' ) $status_color = '#d97706';
            elseif ( $status === 'Completed' ) $status_color = '#059669';
            elseif ( $status === 'Active' ) $status_color = '#c9a227';

            $delay = ( $index % 6 ) * 0.1;
            $index++;
            ?>
            <div class="programme-card" style="display: flex; flex-direction: column; background: var(--color-white); border-radius: var(--radius-xl); overflow: hidden; box-shadow: var(--shadow-md); border-left: 5px solid <?php echo esc_attr( $status_color ); ?>; transition: all var(--transition-base); opacity: 0; transform: translateY(30px); animation: slideInUp 0.6s ease-out forwards; animation-delay: <?php echo esc_attr( $delay ); ?>s;">
              <!-- Image Container -->
              <?php if ( has_post_thumbnail() ) { ?>
                <div style="height: 220px; overflow: hidden; position: relative;">
                  <?php the_post_thumbnail( 'medium', array( 'style' => 'width: 100%; height: 100%; object-fit: cover; transition: transform 0.6s ease;' ) ); ?>
                </div>
              <?php } else { ?>
                <div style="height: 220px; background: linear-gradient(135deg, var(--color-primary-700), var(--color-primary-400)); display: flex; align-items: center; justify-content: center; color: var(--color-white); font-size: 3.5rem;">
                  <i class="fa-solid fa-chart-column" aria-hidden="true"></i>
                </div>
              <?php } ?>

              <!-- Content -->
              <div style="padding: var(--space-6); flex: 1; display: flex; flex-direction: column;">
                <?php if ( $status ) { ?>
                  <div style="margin-bottom: var(--space-4); display: flex; align-items: center; gap: var(--space-3);">
                    <span style="display: inline-block; padding: var(--space-1) var(--space-3); background: <?php echo esc_attr( $status_color ); ?>; color: var(--color-white); font-size: var(--font-size-small); border-radius: var(--radius-sm); font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">
                      <?php echo esc_html( $status ); ?>
                    </span>
                    <?php if ( $completion ) { ?>
                      <span style="font-size: var(--font-size-small); font-weight: 700; color: var(--color-gray-700);">
                        <?php echo intval( $completion ); ?>%
                      </span>
                    <?php } ?>
                  </div>
                <?php } ?>

                <h3 style="margin-bottom: var(--space-3); flex: 1; line-height: 1.4;">
                  <a href="<?php the_permalink(); ?>" style="color: var(--color-primary-700); text-decoration: none; font-size: 1.15rem; font-weight: 700; transition: color var(--transition-fast); display: block;">
                    <?php the_title(); ?>
                  </a>
                </h3>

                <div style="font-size: var(--font-size-small); color: var(--color-gray-600); margin-bottom: var(--space-4); line-height: var(--line-height-relaxed); flex: 1;">
                  <?php
                  $content = get_the_content();
                  if ( ! empty( $content ) ) {
                    echo esc_html( wp_trim_words( $content, 25 ) );
                  } elseif ( has_excerpt() ) {
                    echo esc_html( get_the_excerpt() );
                  }
                  ?>
                </div>

                <?php if ( $budget ) { ?>
                  <div style="margin-bottom: var(--space-4); padding-top: var(--space-4); border-top: 1px solid var(--color-gray-100);">
                    <p style="font-size: var(--font-size-small); color: var(--color-gray-700);">
                      <strong>Budget:</strong> <span style="color: var(--color-accent-dark); font-weight: 700;"><?php echo esc_html( $budget ); ?></span>
                    </p>
                  </div>
                <?php } ?>

                <!-- Completion Progress Bar -->
                <?php if ( $completion ) { ?>
                  <div style="margin-bottom: var(--space-4);">
                    <div style="height: 6px; background: var(--color-gray-200); border-radius: 3px; overflow: hidden;">
                      <div style="height: 100%; background: linear-gradient(90deg, var(--color-success), var(--color-primary-400)); width: <?php echo intval( $completion ); ?>%; transition: width 0.6s ease;"></div>
                    </div>
                  </div>
                <?php } ?>

                <a href="<?php the_permalink(); ?>" style="color: var(--color-accent-dark); font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: var(--space-2); transition: all var(--transition-fast); font-size: var(--font-size-small);">
                  Learn More <span style="font-size: 1.1rem;">→</span>
                </a>
              </div>
            </div>
            <?php
          }
          wp_reset_postdata();
        } else {
          ?>
          <div style="grid-column: 1 / -1; text-align: center; padding: var(--space-12); animation: slideInUp 0.8s ease-out;">
            <div style="font-size: 3rem; margin-bottom: var(--space-4);"><i class="fa-solid fa-chart-column" aria-hidden="true"></i></div>
            <h3 style="color: var(--color-primary-700); margin-bottom: var(--space-4); font-size: 1.5rem; font-weight: 700;">No Programmes Yet</h3>
            <p style="color: var(--color-gray-600); font-size: var(--font-size-body-lg);">Strategic programmes will be displayed here. Check back soon for updates on key initiatives.</p>
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
      <div style="text-align: center; margin-bottom: var(--space-12); animation: slideInUp 0.8s ease-out;">
        <h2 style="font-size: clamp(2rem, 4vw, 2.5rem); font-weight: 800; margin-bottom: var(--space-4); color: var(--color-primary-700);">Core Focus Areas</h2>
        <p style="color: var(--color-gray-600); font-size: var(--font-size-body-lg); max-width: 600px; margin: 0 auto;">Strategic priorities driving our monitoring mandate across key sectors</p>
      </div>

      <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: var(--space-8);">
        <!-- Transportation & Infrastructure -->
        <div class="focus-card" style="text-align: center; padding: var(--space-8); background: var(--color-white); border-radius: var(--radius-xl); box-shadow: var(--shadow-md); border-top: 4px solid var(--color-primary-400); transition: all var(--transition-base); opacity: 0; transform: translateY(30px); animation: slideInUp 0.6s ease-out forwards; animation-delay: 0s;">
          <div style="font-size: 3.5rem; margin-bottom: var(--space-4); display: inline-block; transition: transform 0.3s ease;"><i class="fa-solid fa-truck" aria-hidden="true"></i></div>
          <h3 style="margin-bottom: var(--space-3); font-weight: 700; color: var(--color-primary-700);">Transportation & Infrastructure</h3>
          <p style="color: var(--color-gray-600); line-height: var(--line-height-relaxed); font-size: var(--font-size-small);">
            Monitoring efficiency and sustainability of transport-related parastatals and critical infrastructure agencies across Lagos State.
          </p>
        </div>

        <!-- Health & Wellness -->
        <div class="focus-card" style="text-align: center; padding: var(--space-8); background: var(--color-white); border-radius: var(--radius-xl); box-shadow: var(--shadow-md); border-top: 4px solid var(--color-success); transition: all var(--transition-base); opacity: 0; transform: translateY(30px); animation: slideInUp 0.6s ease-out forwards; animation-delay: 0.1s;">
          <div style="font-size: 3.5rem; margin-bottom: var(--space-4); display: inline-block; transition: transform 0.3s ease;"><i class="fa-solid fa-hospital" aria-hidden="true"></i></div>
          <h3 style="margin-bottom: var(--space-3); font-weight: 700; color: var(--color-primary-700);">Health & Wellness</h3>
          <p style="color: var(--color-gray-600); line-height: var(--line-height-relaxed); font-size: var(--font-size-small);">
            Ensuring quality healthcare delivery and operational excellence across health sector parastatals and agencies.
          </p>
        </div>

        <!-- Education & Development -->
        <div class="focus-card" style="text-align: center; padding: var(--space-8); background: var(--color-white); border-radius: var(--radius-xl); box-shadow: var(--shadow-md); border-top: 4px solid var(--color-accent); transition: all var(--transition-base); opacity: 0; transform: translateY(30px); animation: slideInUp 0.6s ease-out forwards; animation-delay: 0.2s;">
          <div style="font-size: 3.5rem; margin-bottom: var(--space-4); display: inline-block; transition: transform 0.3s ease;"><i class="fa-solid fa-book" aria-hidden="true"></i></div>
          <h3 style="margin-bottom: var(--space-3); font-weight: 700; color: var(--color-primary-700);">Education & Development</h3>
          <p style="color: var(--color-gray-600); line-height: var(--line-height-relaxed); font-size: var(--font-size-small);">
            Supporting quality education provision and institutional development in educational agencies and training institutions.
          </p>
        </div>

        <!-- Environment & Sustainability -->
        <div class="focus-card" style="text-align: center; padding: var(--space-8); background: var(--color-white); border-radius: var(--radius-xl); box-shadow: var(--shadow-md); border-top: 4px solid #059669; transition: all var(--transition-base); opacity: 0; transform: translateY(30px); animation: slideInUp 0.6s ease-out forwards; animation-delay: 0.3s;">
          <div style="font-size: 3.5rem; margin-bottom: var(--space-4); display: inline-block; transition: transform 0.3s ease;"><i class="fa-solid fa-earth-africa" aria-hidden="true"></i></div>
          <h3 style="margin-bottom: var(--space-3); font-weight: 700; color: var(--color-primary-700);">Environment & Sustainability</h3>
          <p style="color: var(--color-gray-600); line-height: var(--line-height-relaxed); font-size: var(--font-size-small);">
            Promoting sustainable practices and environmental responsibility across all monitored agencies and parastatals.
          </p>
        </div>

        <!-- Governance & Accountability -->
        <div class="focus-card" style="text-align: center; padding: var(--space-8); background: var(--color-white); border-radius: var(--radius-xl); box-shadow: var(--shadow-md); border-top: 4px solid var(--color-warning); transition: all var(--transition-base); opacity: 0; transform: translateY(30px); animation: slideInUp 0.6s ease-out forwards; animation-delay: 0.4s;">
          <div style="font-size: 3.5rem; margin-bottom: var(--space-4); display: inline-block; transition: transform 0.3s ease;"><i class="fa-solid fa-scale-balanced" aria-hidden="true"></i></div>
          <h3 style="margin-bottom: var(--space-3); font-weight: 700; color: var(--color-primary-700);">Governance & Accountability</h3>
          <p style="color: var(--color-gray-600); line-height: var(--line-height-relaxed); font-size: var(--font-size-small);">
            Strengthening corporate governance frameworks and promoting transparency, accountability, and ethical practices.
          </p>
        </div>

        <!-- Performance Management -->
        <div class="focus-card" style="text-align: center; padding: var(--space-8); background: var(--color-white); border-radius: var(--radius-xl); box-shadow: var(--shadow-md); border-top: 4px solid var(--color-primary-400); transition: all var(--transition-base); opacity: 0; transform: translateY(30px); animation: slideInUp 0.6s ease-out forwards; animation-delay: 0.5s;">
          <div style="font-size: 3.5rem; margin-bottom: var(--space-4); display: inline-block; transition: transform 0.3s ease;"><i class="fa-solid fa-arrow-trend-up" aria-hidden="true"></i></div>
          <h3 style="margin-bottom: var(--space-3); font-weight: 700; color: var(--color-primary-700);">Performance Management</h3>
          <p style="color: var(--color-gray-600); line-height: var(--line-height-relaxed); font-size: var(--font-size-small);">
            Implementing comprehensive performance measurement systems and driving results-oriented management across agencies.
          </p>
        </div>
      </div>
    </div>
  </section>

</main>

<?php get_footer();

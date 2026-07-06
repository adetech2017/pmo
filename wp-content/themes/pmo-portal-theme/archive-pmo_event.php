<?php
/**
 * Archive Events Template - Premium Design
 *
 * Shows upcoming events first, then concluded events.
 *
 * @package PMO_Portal_Theme
 */

get_header();

/**
 * Render a single event card.
 */
function pmo_render_event_card( $event_post, $index, $is_past ) {
	$event_date    = get_post_meta( $event_post->ID, '_event_date', true );
	$event_time    = get_post_meta( $event_post->ID, '_event_time', true );
	$event_venue   = get_post_meta( $event_post->ID, '_event_venue', true );
	$event_contact = get_post_meta( $event_post->ID, '_event_contact', true );
	$delay         = ( $index % 6 ) * 0.1;
	$badge_bg      = $is_past
		? 'linear-gradient(135deg, var(--color-gray-500, #6b7280), var(--color-gray-400, #9ca3af))'
		: 'linear-gradient(135deg, var(--color-accent-dark), #a5861c)';
	?>
	<article class="event-card" style="background: var(--color-white); border-radius: var(--radius-xl); overflow: hidden; box-shadow: var(--shadow-md); border-top: 5px solid <?php echo $is_past ? 'var(--color-gray-400, #9ca3af)' : 'var(--color-accent)'; ?>; transition: all var(--transition-base); display: flex; flex-direction: column; opacity: 0; transform: translateY(30px); animation: slideInUp 0.6s ease-out forwards; animation-delay: <?php echo esc_attr( $delay ); ?>s;">

		<!-- Date Badge Section -->
		<div style="padding: var(--space-6); background: <?php echo esc_attr( $badge_bg ); ?>; color: var(--color-white);">
			<div style="display: flex; align-items: flex-start; justify-content: space-between; gap: var(--space-4);">
				<!-- Large Date Display -->
				<div style="flex: 1;">
					<div style="font-size: 2.5rem; font-weight: 800; line-height: 1;">
						<?php echo esc_html( $event_date ? wp_date( 'd', strtotime( $event_date ) ) : 'TBA' ); ?>
					</div>
					<div style="font-size: var(--font-size-body-lg); font-weight: 600; opacity: 0.95;">
						<?php echo esc_html( $event_date ? wp_date( 'F Y', strtotime( $event_date ) ) : 'Date TBA' ); ?>
					</div>
				</div>
				<?php if ( $is_past ) { ?>
					<div style="background: rgba(255, 255, 255, 0.2); padding: var(--space-2) var(--space-3); border-radius: var(--radius-sm); text-align: center; min-width: 80px;">
						<div style="font-size: var(--font-size-small); font-weight: 700;">Concluded</div>
					</div>
				<?php } elseif ( $event_date ) {
					$days = ceil( ( strtotime( $event_date ) - time() ) / 86400 );
					if ( $days >= 0 ) {
						?>
						<div style="background: rgba(255, 255, 255, 0.2); padding: var(--space-2) var(--space-3); border-radius: var(--radius-sm); text-align: center; min-width: 80px;">
							<div style="font-size: var(--font-size-small); font-weight: 700; margin-bottom: var(--space-1);">
								<?php echo intval( $days ); ?> Days
							</div>
							<div style="font-size: var(--font-size-caption); opacity: 0.9;">Away</div>
						</div>
						<?php
					}
				} ?>
			</div>
		</div>

		<!-- Content -->
		<div style="padding: var(--space-6); flex: 1; display: flex; flex-direction: column;">

			<!-- Title -->
			<h3 style="margin-bottom: var(--space-4); font-size: 1.2rem; line-height: 1.4; font-weight: 700;">
				<a href="<?php echo esc_url( get_permalink( $event_post ) ); ?>" style="color: var(--color-primary-700); text-decoration: none; transition: color var(--transition-fast);">
					<?php echo esc_html( get_the_title( $event_post ) ); ?>
				</a>
			</h3>

			<!-- Event Meta Info -->
			<div style="margin-bottom: var(--space-4); display: flex; flex-direction: column; gap: var(--space-3);">
				<?php if ( $event_time ) { ?>
					<div style="display: flex; align-items: center; gap: var(--space-2); color: var(--color-gray-700); font-size: var(--font-size-small);">
						<span style="font-size: 1.1rem;"><i class="fa-solid fa-clock" aria-hidden="true"></i></span>
						<span style="font-weight: 600;"><?php echo esc_html( $event_time ); ?></span>
					</div>
				<?php } ?>

				<?php if ( $event_venue ) { ?>
					<div style="display: flex; align-items: center; gap: var(--space-2); color: var(--color-gray-700); font-size: var(--font-size-small);">
						<span style="font-size: 1.1rem;"><i class="fa-solid fa-location-dot" aria-hidden="true"></i></span>
						<span style="font-weight: 600;"><?php echo esc_html( $event_venue ); ?></span>
					</div>
				<?php } ?>

				<?php if ( $event_contact ) { ?>
					<div style="display: flex; align-items: center; gap: var(--space-2); color: var(--color-gray-700); font-size: var(--font-size-small);">
						<span style="font-size: 1.1rem;"><i class="fa-solid fa-phone" aria-hidden="true"></i></span>
						<span style="font-weight: 600;"><?php echo esc_html( $event_contact ); ?></span>
					</div>
				<?php } ?>
			</div>

			<!-- Description -->
			<p style="color: var(--color-gray-600); margin-bottom: var(--space-6); line-height: var(--line-height-relaxed); font-size: var(--font-size-small); flex: 1;">
				<?php echo esc_html( wp_trim_words( get_the_excerpt( $event_post ), 25 ) ); ?>
			</p>

			<!-- CTA Button -->
			<a href="<?php echo esc_url( get_permalink( $event_post ) ); ?>" style="display: inline-flex; align-items: center; gap: var(--space-2); padding: var(--space-3) var(--space-6); background: linear-gradient(135deg, var(--color-primary-700), var(--color-primary-600)); color: var(--color-white); border-radius: var(--radius-lg); text-decoration: none; font-weight: 700; transition: all var(--transition-base); box-shadow: var(--shadow-sm); font-size: var(--font-size-small); width: fit-content;">
				<?php echo $is_past ? 'View Details' : 'Register Now'; ?> <span style="font-size: 1.1rem;">→</span>
			</a>
		</div>
	</article>
	<?php
}

// Partition events into upcoming (incl. no-date/TBA) and past by event date
$all_events = get_posts( array(
	'post_type'      => 'pmo_event',
	'posts_per_page' => 100,
	'post_status'    => 'publish',
) );

$today_start     = strtotime( 'today' );
$upcoming_events = array();
$past_events     = array();

foreach ( $all_events as $event_post ) {
	$event_date = get_post_meta( $event_post->ID, '_event_date', true );
	if ( $event_date && strtotime( $event_date ) < $today_start ) {
		$past_events[] = $event_post;
	} else {
		$upcoming_events[] = $event_post;
	}
}

// Upcoming: soonest first (undated events last); Past: most recent first
usort( $upcoming_events, function ( $a, $b ) {
	$a_date = get_post_meta( $a->ID, '_event_date', true );
	$b_date = get_post_meta( $b->ID, '_event_date', true );
	return ( $a_date ? strtotime( $a_date ) : PHP_INT_MAX ) <=> ( $b_date ? strtotime( $b_date ) : PHP_INT_MAX );
} );
usort( $past_events, function ( $a, $b ) {
	return strtotime( get_post_meta( $b->ID, '_event_date', true ) ) <=> strtotime( get_post_meta( $a->ID, '_event_date', true ) );
} );
?>

<main id="main-content" class="site-content">
	<!-- Hero Section -->
	<section style="background: linear-gradient(135deg, var(--color-primary-700) 0%, var(--color-primary-600) 50%, var(--color-primary-400) 100%); color: var(--color-white); padding: var(--space-20) var(--container-padding-desktop); position: relative; overflow: hidden;">
		<!-- Decorative elements -->
		<div style="position: absolute; top: -50%; right: -10%; width: 800px; height: 800px; background: radial-gradient(circle, rgba(201, 162, 39, 0.12) 0%, transparent 70%); border-radius: 50%; pointer-events: none; animation: float 6s ease-in-out infinite;"></div>
		<div style="position: absolute; bottom: -30%; left: -5%; width: 500px; height: 500px; background: radial-gradient(circle, rgba(201, 162, 39, 0.06) 0%, transparent 70%); border-radius: 50%; pointer-events: none; animation: float 8s ease-in-out infinite 1s;"></div>

		<div class="container" style="position: relative; z-index: 2; animation: slideInUp 0.8s ease-out;">
			<div style="display: inline-block; padding: var(--space-1) var(--space-3); background: rgba(255, 255, 255, 0.15); border-radius: var(--radius-full); margin-bottom: var(--space-4); font-size: var(--font-size-small); font-weight: 700; letter-spacing: 0.5px;">
				<i class="fa-solid fa-bullseye" aria-hidden="true"></i> EVENTS &amp; PROGRAMMES
			</div>
			<h1 style="color: var(--color-white); margin-bottom: var(--space-4); font-size: clamp(2.5rem, 5vw, 3.5rem); font-weight: 800; letter-spacing: -0.02em;">Our Events/Programme</h1>
			<p style="color: rgba(255, 255, 255, 0.95); font-size: var(--font-size-body-lg); line-height: var(--line-height-relaxed); max-width: 600px; font-weight: 400;">Upcoming and past events, workshops, and programmes of the Parastatals Monitoring Office</p>
		</div>
	</section>

	<!-- Events Grid -->
	<section class="section" style="background: var(--color-white);">
		<div class="container">
			<?php if ( ! empty( $upcoming_events ) || ! empty( $past_events ) ) { ?>

				<?php if ( ! empty( $upcoming_events ) ) { ?>
					<div style="margin-bottom: var(--space-12);">
						<h2 style="font-size: clamp(2rem, 4vw, 2.5rem); margin-bottom: var(--space-3); font-weight: 800; color: var(--color-primary-700);">Upcoming Events</h2>
						<div style="width: 120px; height: 5px; background: linear-gradient(90deg, var(--color-primary-700), var(--color-accent)); border-radius: 3px;"></div>
					</div>

					<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(min(100%, 350px), 1fr)); gap: var(--space-8); margin-bottom: var(--space-16);">
						<?php foreach ( $upcoming_events as $i => $event_post ) {
							pmo_render_event_card( $event_post, $i, false );
						} ?>
					</div>
				<?php } ?>

				<?php if ( ! empty( $past_events ) ) { ?>
					<div style="margin-bottom: var(--space-12);">
						<h2 style="font-size: clamp(2rem, 4vw, 2.5rem); margin-bottom: var(--space-3); font-weight: 800; color: var(--color-gray-700);">Past Events</h2>
						<div style="width: 120px; height: 5px; background: linear-gradient(90deg, var(--color-gray-500, #6b7280), var(--color-gray-300, #d1d5db)); border-radius: 3px;"></div>
					</div>

					<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(min(100%, 350px), 1fr)); gap: var(--space-8); margin-bottom: var(--space-16);">
						<?php foreach ( $past_events as $i => $event_post ) {
							pmo_render_event_card( $event_post, $i, true );
						} ?>
					</div>
				<?php } ?>

			<?php } else { ?>
				<div style="text-align: center; padding: var(--space-20); background: var(--color-gray-50); border-radius: var(--radius-xl); animation: slideInUp 0.8s ease-out;">
					<div style="font-size: 4rem; margin-bottom: var(--space-4); animation: float 3s ease-in-out infinite;"><i class="fa-solid fa-bullseye" aria-hidden="true"></i></div>
					<h2 style="color: var(--color-primary-700); margin-bottom: var(--space-4); font-size: 1.8rem; font-weight: 800;">No Events Found</h2>
					<p style="color: var(--color-gray-600); margin-bottom: var(--space-8); font-size: var(--font-size-body-lg); line-height: var(--line-height-relaxed);">Check back soon for upcoming events and programmes</p>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="display: inline-block; padding: var(--space-3) var(--space-8); background: linear-gradient(135deg, var(--color-primary-700), var(--color-primary-600)); color: var(--color-white); border-radius: var(--radius-lg); text-decoration: none; font-weight: 700; transition: all var(--transition-base); box-shadow: var(--shadow-md);">Back to Home</a>
				</div>
			<?php } ?>
		</div>
	</section>
</main>

<?php get_footer(); ?>

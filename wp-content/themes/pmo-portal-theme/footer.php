<?php
/**
 * The footer for our theme
 *
 * @package PMO_Portal_Theme
 */

?>
	</main><!-- #main-content -->

	<!-- Premium Government Footer -->
	<footer id="colophon" class="site-footer">
		<div class="footer-content">
			<div class="footer-grid">
				<!-- About Section -->
				<div class="footer-section">
					<h4><?php esc_html_e( 'About PMO', 'pmo-portal' ); ?></h4>
					<p style="color: var(--color-gray-300); font-size: var(--type-body-sm); margin-bottom: var(--space-4);">
						<?php esc_html_e( 'The Lagos State Parastatals Monitoring Office ensures transparent, accountable and efficient governance across all State Owned Parastatals.', 'pmo-portal' ); ?>
					</p>
				</div>

				<!-- Quick Links -->
				<div class="footer-section">
					<h4><?php esc_html_e( 'Quick Links', 'pmo-portal' ); ?></h4>
					<ul class="footer-links">
						<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'pmo-portal' ); ?></a></li>
						<li><a href="<?php echo esc_url( home_url( '/programmes/' ) ); ?>"><?php esc_html_e( 'Our Mandate', 'pmo-portal' ); ?></a></li>
						<li><a href="<?php echo esc_url( home_url( '/news/' ) ); ?>"><?php esc_html_e( 'News', 'pmo-portal' ); ?></a></li>
						<li><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php esc_html_e( 'Contact', 'pmo-portal' ); ?></a></li>
					</ul>
				</div>

				<!-- Resources -->
				<div class="footer-section">
					<h4><?php esc_html_e( 'Resources', 'pmo-portal' ); ?></h4>
					<ul class="footer-links">
						<li><a href="<?php echo esc_url( home_url( '/publications/' ) ); ?>"><?php esc_html_e( 'Publications', 'pmo-portal' ); ?></a></li>
						<li><a href="<?php echo esc_url( home_url( '/projects/' ) ); ?>"><?php esc_html_e( 'Projects', 'pmo-portal' ); ?></a></li>
						<li><a href="<?php echo esc_url( home_url( '/events/' ) ); ?>"><?php esc_html_e( 'Events', 'pmo-portal' ); ?></a></li>
						<li><a href="<?php echo esc_url( home_url( '/gallery/' ) ); ?>"><?php esc_html_e( 'Gallery', 'pmo-portal' ); ?></a></li>
					</ul>
				</div>

				<!-- Contact -->
				<div class="footer-section">
					<h4><?php esc_html_e( 'Contact', 'pmo-portal' ); ?></h4>
					<ul class="footer-links" style="font-style: normal;">
						<?php $pmo_phone = get_theme_mod( 'pmo_contact_phone', '' ); ?>
						<?php if ( $pmo_phone ) { ?>
							<li><i class="fa-solid fa-phone" aria-hidden="true"></i> <a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $pmo_phone ) ); ?>"><?php echo esc_html( $pmo_phone ); ?></a></li>
						<?php } ?>
						<?php $pmo_email = get_theme_mod( 'pmo_contact_email', 'info@pmo.lagosstate.gov.ng' ); ?>
						<?php if ( $pmo_email ) { ?>
							<li><i class="fa-solid fa-envelope" aria-hidden="true"></i> <a href="mailto:<?php echo esc_attr( $pmo_email ); ?>"><?php echo esc_html( $pmo_email ); ?></a></li>
						<?php } ?>
						<li><i class="fa-solid fa-location-dot" aria-hidden="true"></i> <?php esc_html_e( 'The Secretariat, Alausa, Ikeja, Lagos', 'pmo-portal' ); ?></li>
					</ul>
				</div>
			</div>

			<!-- Footer Bottom -->
			<div class="footer-bottom">
				<p>
					<?php
					printf(
						esc_html__( '&copy; %s Lagos State Parastatals Monitoring Office. All rights reserved.', 'pmo-portal' ),
						date_i18n( 'Y' )
					);
					?>
				</p>
			</div>
		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>

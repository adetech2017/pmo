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
						<?php esc_html_e( 'The Lagos State Project Monitoring Office ensures transparent, accountable infrastructure delivery across all 20 local government areas.', 'pmo-portal' ); ?>
					</p>
				</div>

				<!-- Quick Links -->
				<div class="footer-section">
					<h4><?php esc_html_e( 'Quick Links', 'pmo-portal' ); ?></h4>
					<ul class="footer-links">
						<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'pmo-portal' ); ?></a></li>
						<li><a href="<?php echo esc_url( home_url( '/programmes/' ) ); ?>"><?php esc_html_e( 'Programmes', 'pmo-portal' ); ?></a></li>
						<li><a href="<?php echo esc_url( home_url( '/news/' ) ); ?>"><?php esc_html_e( 'News', 'pmo-portal' ); ?></a></li>
						<li><a href="<?php echo esc_url( home_url( '/contact-us/' ) ); ?>"><?php esc_html_e( 'Contact', 'pmo-portal' ); ?></a></li>
					</ul>
				</div>

				<!-- Resources -->
				<div class="footer-section">
					<h4><?php esc_html_e( 'Resources', 'pmo-portal' ); ?></h4>
					<ul class="footer-links">
						<li><a href="#"><?php esc_html_e( 'Documentation', 'pmo-portal' ); ?></a></li>
						<li><a href="#"><?php esc_html_e( 'FAQs', 'pmo-portal' ); ?></a></li>
						<li><a href="#"><?php esc_html_e( 'Accessibility', 'pmo-portal' ); ?></a></li>
						<li><a href="#"><?php esc_html_e( 'Privacy Policy', 'pmo-portal' ); ?></a></li>
					</ul>
				</div>

				<!-- Contact -->
				<div class="footer-section">
					<h4><?php esc_html_e( 'Contact', 'pmo-portal' ); ?></h4>
					<ul class="footer-links" style="font-style: normal;">
						<li>📞 <a href="tel:+2347001234567"><?php esc_html_e( '+234 (0) 700 LAGOS PMO', 'pmo-portal' ); ?></a></li>
						<li>📧 <a href="mailto:info@pmo.lagosstate.gov.ng"><?php esc_html_e( 'info@pmo.lagosstate.gov.ng', 'pmo-portal' ); ?></a></li>
						<li>🌐 <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'pmo.lagosstate.gov.ng', 'pmo-portal' ); ?></a></li>
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

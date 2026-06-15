/**
 * Mobile Menu Toggle
 */
document.addEventListener('DOMContentLoaded', function() {
	const mobileToggle = document.getElementById('mobile-menu-toggle');
	const mainNav = document.getElementById('site-navigation');

	if (mobileToggle && mainNav) {
		mobileToggle.addEventListener('click', function() {
			mainNav.classList.toggle('active');
		});

		// Close menu when a link is clicked
		const navLinks = mainNav.querySelectorAll('a');
		navLinks.forEach(link => {
			link.addEventListener('click', function() {
				mainNav.classList.remove('active');
			});
		});

		// Close menu on window resize if screen is large enough
		window.addEventListener('resize', function() {
			if (window.innerWidth > 768) {
				mainNav.classList.remove('active');
			}
		});
	}
});

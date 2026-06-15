/* PMO Portal Theme JavaScript */

jQuery(document).ready(function($) {
	console.log('PMO Portal theme loaded');

	// Mobile menu toggle
	const menuToggle = $('.menu-toggle');
	const primaryMenu = $('.primary-menu');

	if (menuToggle.length) {
		menuToggle.on('click', function() {
			primaryMenu.toggleClass('show');
		});
	}

	// Accessible dropdown menus
	$('.primary-menu li a').on('focus blur', function(e) {
		$(this).parents('li').toggleClass('focus');
	});
});

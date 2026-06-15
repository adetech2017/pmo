/**
 * PMO Contact Form Handler
 */

jQuery(document).ready(function($) {
	$('#pmo-contact-form').on('submit', function(e) {
		e.preventDefault();

		const $form = $(this);
		const $submitBtn = $form.find('button[type="submit"]');
		const $messageDiv = $('#pmo-form-message');
		const originalBtnText = $submitBtn.text();

		// Show loading state
		$submitBtn.prop('disabled', true).text('Sending...');

		// Submit form via AJAX
		$.ajax({
			url: pmoContactForm.ajaxUrl,
			type: 'POST',
			data: $form.serialize(),
			success: function(response) {
				if (response.success) {
					$messageDiv
						.removeClass('error')
						.addClass('success')
						.css('background', '#d4edda')
						.css('color', '#155724')
						.css('border', '1px solid #c3e6cb')
						.html(response.data.message)
						.show();

					// Reset form
					$form[0].reset();

					// Hide message after 5 seconds
					setTimeout(function() {
						$messageDiv.fadeOut();
					}, 5000);
				} else {
					$messageDiv
						.removeClass('success')
						.addClass('error')
						.css('background', '#f8d7da')
						.css('color', '#721c24')
						.css('border', '1px solid #f5c6cb')
						.html(response.data.message)
						.show();
				}
			},
			error: function() {
				$messageDiv
					.removeClass('success')
					.addClass('error')
					.css('background', '#f8d7da')
					.css('color', '#721c24')
					.css('border', '1px solid #f5c6cb')
					.html('An error occurred. Please try again.')
					.show();
			},
			complete: function() {
				$submitBtn.prop('disabled', false).text(originalBtnText);
			}
		});
	});
});

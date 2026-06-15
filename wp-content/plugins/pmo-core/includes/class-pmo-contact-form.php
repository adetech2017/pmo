<?php
/**
 * PMO Contact Form
 *
 * Handles contact form submissions
 *
 * @package PMO_Core
 */

class PMO_Contact_Form {

	/**
	 * Initialize contact form
	 */
	public static function init() {
		add_shortcode( 'pmo_contact_form', array( __CLASS__, 'render_contact_form' ) );
		add_action( 'wp_ajax_pmo_submit_contact_form', array( __CLASS__, 'handle_form_submission' ) );
		add_action( 'wp_ajax_nopriv_pmo_submit_contact_form', array( __CLASS__, 'handle_form_submission' ) );
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue_assets' ) );
	}

	/**
	 * Enqueue assets
	 */
	public static function enqueue_assets() {
		wp_enqueue_script(
			'pmo-contact-form-js',
			PMO_CORE_URL . 'assets/js/contact-form.js',
			array( 'jquery' ),
			PMO_CORE_VERSION,
			true
		);

		wp_localize_script( 'pmo-contact-form-js', 'pmoContactForm', array(
			'ajaxUrl' => admin_url( 'admin-ajax.php' ),
			'nonce'   => wp_create_nonce( 'pmo_contact_form_nonce' ),
		) );
	}

	/**
	 * Render contact form shortcode
	 * Usage: [pmo_contact_form]
	 */
	public static function render_contact_form() {
		ob_start();
		?>
		<div class="pmo-contact-form-wrapper" style="max-width: 600px; margin: 30px auto;">
			<form id="pmo-contact-form" class="pmo-contact-form" style="background: #f9f9f9; padding: 30px; border-radius: 4px;">
				<div id="pmo-form-message" style="display: none; padding: 15px; margin-bottom: 20px; border-radius: 4px;"></div>

				<div style="margin-bottom: 20px;">
					<label for="pmo_contact_name" style="display: block; font-weight: 600; margin-bottom: 8px;">
						<?php esc_html_e( 'Full Name *', 'pmo-core' ); ?>
					</label>
					<input
						type="text"
						id="pmo_contact_name"
						name="name"
						required
						style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px;"
					/>
				</div>

				<div style="margin-bottom: 20px;">
					<label for="pmo_contact_email" style="display: block; font-weight: 600; margin-bottom: 8px;">
						<?php esc_html_e( 'Email Address *', 'pmo-core' ); ?>
					</label>
					<input
						type="email"
						id="pmo_contact_email"
						name="email"
						required
						style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px;"
					/>
				</div>

				<div style="margin-bottom: 20px;">
					<label for="pmo_contact_phone" style="display: block; font-weight: 600; margin-bottom: 8px;">
						<?php esc_html_e( 'Phone Number (Optional)', 'pmo-core' ); ?>
					</label>
					<input
						type="tel"
						id="pmo_contact_phone"
						name="phone"
						style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px;"
					/>
				</div>

				<div style="margin-bottom: 20px;">
					<label for="pmo_contact_department" style="display: block; font-weight: 600; margin-bottom: 8px;">
						<?php esc_html_e( 'Department/Subject *', 'pmo-core' ); ?>
					</label>
					<select
						id="pmo_contact_department"
						name="department"
						required
						style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px;"
					>
						<option value="">-- Select Department --</option>
						<option value="Projects"><?php esc_html_e( 'Projects', 'pmo-core' ); ?></option>
						<option value="News"><?php esc_html_e( 'News & Communications', 'pmo-core' ); ?></option>
						<option value="Events"><?php esc_html_e( 'Events', 'pmo-core' ); ?></option>
						<option value="Publications"><?php esc_html_e( 'Publications', 'pmo-core' ); ?></option>
						<option value="General"><?php esc_html_e( 'General Inquiry', 'pmo-core' ); ?></option>
					</select>
				</div>

				<div style="margin-bottom: 20px;">
					<label for="pmo_contact_message" style="display: block; font-weight: 600; margin-bottom: 8px;">
						<?php esc_html_e( 'Message *', 'pmo-core' ); ?>
					</label>
					<textarea
						id="pmo_contact_message"
						name="message"
						required
						rows="6"
						style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px; font-family: inherit;"
					></textarea>
				</div>

				<input type="hidden" name="action" value="pmo_submit_contact_form" />
				<input type="hidden" name="nonce" value="<?php echo esc_attr( wp_create_nonce( 'pmo_contact_form_nonce' ) ); ?>" />

				<button
					type="submit"
					style="background: #003d7a; color: white; padding: 12px 30px; border: none; border-radius: 4px; font-size: 16px; font-weight: 600; cursor: pointer; width: 100%;"
				>
					<?php esc_html_e( 'Send Message', 'pmo-core' ); ?>
				</button>

				<p style="margin-top: 15px; font-size: 12px; color: #7f8c8d;">
					<?php esc_html_e( 'Fields marked with * are required.', 'pmo-core' ); ?>
				</p>
			</form>
		</div>
		<?php
		return ob_get_clean();
	}

	/**
	 * Handle form submission
	 */
	public static function handle_form_submission() {
		check_ajax_referer( 'pmo_contact_form_nonce', 'nonce' );

		// Validate input
		if ( empty( $_POST['name'] ) || empty( $_POST['email'] ) || empty( $_POST['message'] ) ) {
			wp_send_json_error( array( 'message' => __( 'Please fill in all required fields.', 'pmo-core' ) ) );
		}

		$name = sanitize_text_field( $_POST['name'] );
		$email = sanitize_email( $_POST['email'] );
		$phone = sanitize_text_field( $_POST['phone'] ?? '' );
		$department = sanitize_text_field( $_POST['department'] ?? 'General' );
		$message = sanitize_textarea_field( $_POST['message'] );

		// Validate email
		if ( ! is_email( $email ) ) {
			wp_send_json_error( array( 'message' => __( 'Please enter a valid email address.', 'pmo-core' ) ) );
		}

		// Get admin email
		$admin_email = get_option( 'admin_email' );
		$blog_name = get_option( 'blogname' );

		// Prepare email
		$subject = sprintf(
			__( 'New Contact Form Submission - %s', 'pmo-core' ),
			$department
		);

		$email_body = sprintf(
			__( "You have received a new message from the contact form:\n\n" .
				"Name: %s\n" .
				"Email: %s\n" .
				"Phone: %s\n" .
				"Department: %s\n" .
				"Message:\n%s\n\n" .
				"---\n" .
				"This is an automated message from %s", 'pmo-core' ),
			$name,
			$email,
			$phone ?: __( 'Not provided', 'pmo-core' ),
			$department,
			$message,
			$blog_name
		);

		// Send email
		$headers = array( 'Content-Type: text/plain; charset=UTF-8' );
		$headers[] = 'From: ' . $blog_name . ' <' . $admin_email . '>';
		$headers[] = 'Reply-To: ' . $email;

		$mail_sent = wp_mail( $admin_email, $subject, $email_body, $headers );

		if ( $mail_sent ) {
			// Send confirmation email to user
			$user_subject = sprintf(
				__( 'We received your message - %s', 'pmo-core' ),
				$blog_name
			);

			$user_body = sprintf(
				__( "Dear %s,\n\n" .
					"Thank you for contacting us. We have received your message and will get back to you shortly.\n\n" .
					"Best regards,\n" .
					"%s Team", 'pmo-core' ),
				$name,
				$blog_name
			);

			wp_mail( $email, $user_subject, $user_body, $headers );

			wp_send_json_success( array(
				'message' => __( 'Thank you! Your message has been sent successfully. We will get back to you soon.', 'pmo-core' ),
			) );
		} else {
			wp_send_json_error( array(
				'message' => __( 'There was an error sending your message. Please try again later.', 'pmo-core' ),
			) );
		}
	}
}

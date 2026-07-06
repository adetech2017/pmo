<?php
/**
 * Customizer integration
 *
 * @package PMO_Portal_Theme
 */

/**
 * Add theme customizer options
 */
function pmo_theme_customize_register( $wp_customize ) {
	// Add custom panel
	$wp_customize->add_panel( 'pmo_theme_options', array(
		'title'       => esc_html__( 'PMO Theme Options', 'pmo-portal' ),
		'description' => esc_html__( 'Customize your PMO Portal theme', 'pmo-portal' ),
		'priority'    => 160,
	) );

	// ------------------------------------------------------------------
	// Impact statistics (homepage). Keep these numbers current — they are
	// published figures on a government site.
	// ------------------------------------------------------------------
	$wp_customize->add_section( 'pmo_impact_stats', array(
		'title'       => esc_html__( 'Homepage Impact Statistics', 'pmo-portal' ),
		'description' => esc_html__( 'The four statistics shown in the "Our Impact" section. Leave a number empty to hide that statistic.', 'pmo-portal' ),
		'panel'       => 'pmo_theme_options',
		'priority'    => 10,
	) );

	$stat_defaults = array(
		1 => array( '47', 'Parastatals Monitored', 'Across all 20 LGAs' ),
		2 => array( '156', 'Audits Conducted', 'Comprehensive assessments' ),
		3 => array( '89', 'Improvements Implemented', 'Governance enhancements' ),
		4 => array( '34', 'Capacity Sessions', 'Leadership development' ),
	);

	foreach ( $stat_defaults as $i => $defaults ) {
		$wp_customize->add_setting( "pmo_stat_{$i}_number", array(
			'default'           => $defaults[0],
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( "pmo_stat_{$i}_number", array(
			/* translators: %d: statistic number */
			'label'   => sprintf( esc_html__( 'Statistic %d — Number', 'pmo-portal' ), $i ),
			'section' => 'pmo_impact_stats',
			'type'    => 'text',
		) );

		$wp_customize->add_setting( "pmo_stat_{$i}_label", array(
			'default'           => $defaults[1],
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( "pmo_stat_{$i}_label", array(
			/* translators: %d: statistic number */
			'label'   => sprintf( esc_html__( 'Statistic %d — Label', 'pmo-portal' ), $i ),
			'section' => 'pmo_impact_stats',
			'type'    => 'text',
		) );

		$wp_customize->add_setting( "pmo_stat_{$i}_sublabel", array(
			'default'           => $defaults[2],
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( "pmo_stat_{$i}_sublabel", array(
			/* translators: %d: statistic number */
			'label'   => sprintf( esc_html__( 'Statistic %d — Sub-label', 'pmo-portal' ), $i ),
			'section' => 'pmo_impact_stats',
			'type'    => 'text',
		) );
	}

	// ------------------------------------------------------------------
	// Contact details (footer)
	// ------------------------------------------------------------------
	$wp_customize->add_section( 'pmo_contact_details', array(
		'title'       => esc_html__( 'Contact Details', 'pmo-portal' ),
		'description' => esc_html__( 'Shown in the site footer. Leave the phone number empty to hide it.', 'pmo-portal' ),
		'panel'       => 'pmo_theme_options',
		'priority'    => 20,
	) );

	$wp_customize->add_setting( 'pmo_contact_phone', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'pmo_contact_phone', array(
		'label'   => esc_html__( 'Phone Number', 'pmo-portal' ),
		'section' => 'pmo_contact_details',
		'type'    => 'text',
	) );

	$wp_customize->add_setting( 'pmo_contact_email', array(
		'default'           => 'info@pmo.lagosstate.gov.ng',
		'sanitize_callback' => 'sanitize_email',
	) );
	$wp_customize->add_control( 'pmo_contact_email', array(
		'label'   => esc_html__( 'Email Address', 'pmo-portal' ),
		'section' => 'pmo_contact_details',
		'type'    => 'email',
	) );
}
add_action( 'customize_register', 'pmo_theme_customize_register' );

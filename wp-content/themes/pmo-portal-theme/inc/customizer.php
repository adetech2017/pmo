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

	// Color Settings
	$wp_customize->add_section( 'pmo_colors', array(
		'title'       => esc_html__( 'Colors', 'pmo-portal' ),
		'panel'       => 'pmo_theme_options',
		'priority'    => 10,
	) );

	$wp_customize->add_setting( 'pmo_primary_color', array(
		'default'           => '#003d7a',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'pmo_primary_color', array(
		'label'    => esc_html__( 'Primary Color', 'pmo-portal' ),
		'section'  => 'pmo_colors',
		'settings' => 'pmo_primary_color',
	) ) );
}
add_action( 'customize_register', 'pmo_theme_customize_register' );

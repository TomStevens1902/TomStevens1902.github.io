<?php
/**
 * The main template for implementing Theme/Customzer Options
 *
 * @package Catch Themes
 * @subpackage Catch Base
 * @since Catch Base 1.0
 */

if ( ! defined( 'CATCHBASE_THEME_VERSION' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}


/**
 * Implements Catchbase theme options into Theme Customizer.
 *
 * @param $wp_customize Theme Customizer object
 * @return void
 *
 * @since Catch Base 1.0
 */
function catchbase_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';

	/**
	  * Set priority of blogname (Site Title) to 1.
	  *  Strangly, if more than two options is added, Site title is moved below Tagline. This rectifies this issue.
	  */
	$wp_customize->get_control( 'blogname' )->priority          = 1;

	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';

	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	$options  = catchbase_get_theme_options();

	$defaults = catchbase_get_default_theme_options();

	//Custom Controls
	require trailingslashit( get_template_directory() ) . 'inc/customizer-includes/catchbase-customizer-custom-controls.php';

	//@remove Remove this block when WordPress 4.8 is released
	if ( ! function_exists( 'has_custom_logo' ) ) {
		// Custom Logo (added to Site Title and Tagline section in Theme Customizer)
	    $wp_customize->add_setting( 'catchbase_theme_options[logo_disable]', array(
			'capability'		=> 'edit_theme_options',
			'default'			=> $defaults['logo_disable'],
			'sanitize_callback' => 'catchbase_sanitize_checkbox',
		) );

		$wp_customize->add_control( 'catchbase_theme_options[logo_disable]', array(
			'label'    => esc_html__( 'Check to disable logo', 'catch-base' ),
			'priority' => 100,
			'section'  => 'title_tagline',
			'settings' => 'catchbase_theme_options[logo_disable]',
			'type'     => 'checkbox',
		) );

		$wp_customize->add_setting( 'catchbase_theme_options[logo]', array(
			'capability'		=> 'edit_theme_options',
			'default'			=> $defaults['logo'],
			'sanitize_callback'	=> 'catchbase_sanitize_image',
		) );

		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'logo', array(
			'active_callback' 	=> 'catchbase_is_logo_enabled',
			'label'				=> esc_html__( 'Logo', 'catch-base' ),
			'priority'			=> 101,
			'section'   		=> 'title_tagline',
	        'settings'  		=> 'catchbase_theme_options[logo]',
	    ) ) );

		$wp_customize->add_setting( 'catchbase_theme_options[logo_alt_text]', array(
			'capability'		=> 'edit_theme_options',
			'default'			=> $defaults['logo_alt_text'],
			'sanitize_callback'	=> 'sanitize_text_field',
		) );

		$wp_customize->add_control( 'catchbase_logo_alt_text', array(
			'active_callback' 	=> 'catchbase_is_logo_enabled',
			'label'    			=> esc_html__( 'Logo Alt Text', 'catch-base' ),
			'priority'			=> 102,
			'section' 			=> 'title_tagline',
			'settings' 			=> 'catchbase_theme_options[logo_alt_text]',
			'type'     			=> 'text',
		) );
	}

	$wp_customize->add_setting( 'catchbase_theme_options[move_title_tagline]', array(
		'capability'		=> 'edit_theme_options',
		'default'			=> $defaults['move_title_tagline'],
		'sanitize_callback' => 'catchbase_sanitize_checkbox',
	) );

	$wp_customize->add_control( 'catchbase_theme_options[move_title_tagline]', array(
		'active_callback' 	=> 'catchbase_is_logo_enabled',
		'label'    			=> esc_html__( 'Check to move Site Title and Tagline before logo', 'catch-base' ),
		'priority' 			=> function_exists( 'has_custom_logo' ) ? 10 : 103,
		'section'  			=> 'title_tagline',
		'settings' 			=> 'catchbase_theme_options[move_title_tagline]',
		'type'     			=> 'checkbox',
	) );
	// Custom Logo End

	// Color Scheme
	$wp_customize->add_setting( 'catchbase_theme_options[color_scheme]', array(
		'capability' 		=> 'edit_theme_options',
		'default'    		=> $defaults['color_scheme'],
		'sanitize_callback'	=> 'catchbase_sanitize_select',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'catchbase_theme_options[color_scheme]', array(
		'choices'  => catchbase_color_schemes(),
		'label'    => esc_html__( 'Color Scheme', 'catch-base' ),
		'priority' => 5,
		'section'  => 'colors',
		'settings' => 'catchbase_theme_options[color_scheme]',
		'type'     => 'radio',
	) );
	//End Color Scheme

	// Header Options (added to Header section in Theme Customizer)
	require trailingslashit( get_template_directory() ) . 'inc/customizer-includes/catchbase-customizer-header-options.php';

	//Theme Options
	require trailingslashit( get_template_directory() ) . 'inc/customizer-includes/catchbase-customizer-theme-options.php';

	//Featured Content Setting
	require trailingslashit( get_template_directory() ) . 'inc/customizer-includes/catchbase-customizer-featured-content-setting.php';

	//Featured Slider
	require trailingslashit( get_template_directory() ) . 'inc/customizer-includes/catchbase-customizer-featured-slider.php';

	//Social Links
	require trailingslashit( get_template_directory() ) . 'inc/customizer-includes/catchbase-customizer-social-icons.php';

	// Reset all settings to default
	$wp_customize->add_section( 'catchbase_reset_all_settings', array(
		'description'	=> esc_html__( 'Caution: Reset all settings to default. Refresh the page after save to view full effects.', 'catch-base' ),
		'priority' 		=> 700,
		'title'    		=> esc_html__( 'Reset all settings', 'catch-base' ),
	) );

	$wp_customize->add_setting( 'catchbase_theme_options[reset_all_settings]', array(
		'capability'		=> 'edit_theme_options',
		'default'			=> $defaults['reset_all_settings'],
		'sanitize_callback' => 'catchbase_sanitize_checkbox',
		'transport'			=> 'postMessage',
	) );

	$wp_customize->add_control( 'catchbase_theme_options[reset_all_settings]', array(
		'label'    => esc_html__( 'Check to reset all settings to default', 'catch-base' ),
		'section'  => 'catchbase_reset_all_settings',
		'settings' => 'catchbase_theme_options[reset_all_settings]',
		'type'     => 'checkbox',
	) );
	// Reset all settings to default end

	//Important Links
	$wp_customize->add_section( 'important_links', array(
		'priority' 		=> 999,
		'title'   	 	=> esc_html__( 'Important Links', 'catch-base' ),
	) );

	/**
	 * Has dummy Sanitizaition function as it contains no value to be sanitized
	 */
	$wp_customize->add_setting( 'important_links', array(
		'sanitize_callback'	=> 'sanitize_text_field',
	) );

	$wp_customize->add_control( new Catchbase_Important_Links( $wp_customize, 'important_links', array(
        'label'   	=> esc_html__( 'Important Links', 'catch-base' ),
         'section'  	=> 'important_links',
        'settings' 	=> 'important_links',
        'type'     	=> 'important_links',
    ) ) );
    //Important Links End
}
add_action( 'customize_register', 'catchbase_customize_register' );


/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously for catchbase.
 * And flushes out all transient data on preview
 *
 * @since Catch Base 1.0
 */
function catchbase_customize_preview() {
	wp_enqueue_script( 'catchbase_customizer', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'js/catchbase-customizer.min.js', array( 'customize-preview' ), '20120827', true );

	//setting home_url value to avail it in catchbase_customizer script in data object
	$data = array(
			'home_url'			=> esc_url( get_home_url( '/' ) ),
		);

	wp_localize_script( 'catchbase_customizer', 'data', $data );

	//Flush transients on preview
	catchbase_flush_transients();
}
add_action( 'customize_preview_init', 'catchbase_customize_preview' );


/**
 * Custom scripts and styles on customize.php for catchbase.
 *
 * @since Catch Base 1.0
 */
function catchbase_customize_scripts() {
	wp_enqueue_script( 'catchbase_customizer_custom', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'js/catchbase-customizer-custom-scripts.min.js', array( 'customize-controls', 'iris', 'underscore', 'wp-util' ), '20150630', true );

	$catchbase_misc_links['color_list']    = catchbase_color_list();
	$catchbase_misc_links['reset_message'] = esc_html__( 'Refresh the customizer page after saving to view reset effects', 'catch-base' );

	// Add reset message and color list via localized script
	wp_localize_script( 'catchbase_customizer_custom', 'catchbase_misc_links', $catchbase_misc_links );
}
add_action( 'customize_controls_enqueue_scripts', 'catchbase_customize_scripts');

/**
 * Returns list of color keys of array with default values for each color scheme as index
 *
 * @since Catch Base 2.1
 */
function catchbase_color_list() {
	// Get default color scheme values
	$default 		= catchbase_get_default_theme_options();
	// Get default dark color scheme valies
	$default_dark 	= catchbase_default_dark_color_options();

	$catchbase_color_list['background_color']['light']	= $default['background_color'];
	$catchbase_color_list['background_color']['dark']	= $default_dark['background_color'];

	$catchbase_color_list['header_textcolor']['light']	= $default['header_textcolor'];
	$catchbase_color_list['header_textcolor']['dark']	= $default_dark['header_textcolor'];

	return $catchbase_color_list;
}

/**
 * Function to reset date with respect to condition
 */
function catchbase_reset_data() {
	$options  = catchbase_get_theme_options();
    if ( $options['reset_all_settings'] ) {
    	remove_theme_mods();

        // Flush out all transients	on reset
        catchbase_flush_transients();

        return;
    }
}
add_action( 'customize_save_after', 'catchbase_reset_data' );


//Active callbacks for customizer
require trailingslashit( get_template_directory() ) . 'inc/customizer-includes/catchbase-customizer-active-callbacks.php';

//Sanitize functions for customizer
require trailingslashit( get_template_directory() ) . 'inc/customizer-includes/catchbase-customizer-sanitize-functions.php';

// Add Upgrade button
require trailingslashit( get_template_directory() ) . 'inc/customizer-includes/upgrade-button/class-customize.php';

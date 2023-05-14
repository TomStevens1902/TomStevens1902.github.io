<?php
/**
 * The template for adding Additional Header Option in Customizer
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

	// Header Options
	$wp_customize->add_setting( 'catchbase_theme_options[enable_featured_header_image]', array(
		'capability'		=> 'edit_theme_options',
		'default'			=> $defaults['enable_featured_header_image'],
		'sanitize_callback' => 'catchbase_sanitize_select',
	) );

	$wp_customize->add_control( 'catchbase_theme_options[enable_featured_header_image]', array(
			'choices'  	=> catchbase_enable_featured_header_image_options(),
			'label'		=> esc_html__( 'Enable Featured Header Image on ', 'catch-base' ),
			'section'   => 'header_image',
	        'settings'  => 'catchbase_theme_options[enable_featured_header_image]',
	        'type'	  	=> 'select',
	) );


	$wp_customize->add_setting( 'catchbase_theme_options[featured_image_size]', array(
		'capability'		=> 'edit_theme_options',
		'default'			=> $defaults['featured_image_size'],
		'sanitize_callback' => 'catchbase_sanitize_select',
	) );

	$wp_customize->add_control( 'catchbase_theme_options[featured_image_size]', array(
		'active_callback' 	=> 'catchbase_is_featured_header_image_enabled',
		'choices'  	=> catchbase_featured_image_size_options(),
		'label'		=> esc_html__( 'Page/Post Featured Header Image Size', 'catch-base' ),
		'section'   => 'header_image',
		'settings'  => 'catchbase_theme_options[featured_image_size]',
		'type'	  	=> 'select',
	) );

	$wp_customize->add_setting( 'catchbase_theme_options[featured_header_image_alt]', array(
		'capability'		=> 'edit_theme_options',
		'default'			=> $defaults['featured_header_image_alt'],
		'sanitize_callback' => 'sanitize_text_field',
		'transport'			=> 'postMessage'
	) );

	$wp_customize->add_control( 'catchbase_theme_options[featured_header_image_alt]', array(
		'active_callback' 	=> 'catchbase_is_featured_header_image_enabled',
		'label'		=> esc_html__( 'Featured Header Image Alt/Title Tag ', 'catch-base' ),
		'section'   => 'header_image',
        'settings'  => 'catchbase_theme_options[featured_header_image_alt]',
        'type'	  	=> 'text',
	) );

	$wp_customize->add_setting( 'catchbase_theme_options[featured_header_image_url]', array(
		'capability'		=> 'edit_theme_options',
		'default'			=> $defaults['featured_header_image_url'],
		'sanitize_callback' => 'esc_url_raw',
		'transport'			=> 'postMessage'
	) );

	$wp_customize->add_control( 'catchbase_theme_options[featured_header_image_url]', array(
		'active_callback' 	=> 'catchbase_is_featured_header_image_enabled',
		'label'				=> esc_html__( 'Featured Header Image Link URL', 'catch-base' ),
		'section'   		=> 'header_image',
        'settings'  		=> 'catchbase_theme_options[featured_header_image_url]',
        'type'	  			=> 'text',
	) );

	$wp_customize->add_setting( 'catchbase_theme_options[featured_header_image_base]', array(
		'capability'		=> 'edit_theme_options',
		'default'			=> $defaults['featured_header_image_url'],
		'sanitize_callback' => 'catchbase_sanitize_checkbox',
		'transport'			=> 'postMessage'
	) );

	$wp_customize->add_control( 'catchbase_theme_options[featured_header_image_base]', array(
		'active_callback' 	=> 'catchbase_is_featured_header_image_enabled',
		'label'    	=> esc_html__( 'Check to Open Link in New Window/Tab', 'catch-base' ),
		'section'  	=> 'header_image',
		'settings' 	=> 'catchbase_theme_options[featured_header_image_base]',
		'type'     	=> 'checkbox',
	) );
// Header Options End

<?php
/**
 * The template for adding Featured Slider Options in Customizer
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
	// Featured Slider
	if ( 4.3 > get_bloginfo( 'version' ) ) {
		$wp_customize->add_panel( 'catchbase_featured_slider', array(
		    'capability'     => 'edit_theme_options',
		    'description'    => esc_html__( 'Featured Slider Options', 'catch-base' ),
		    'priority'       => 500,
			'title'    		 => esc_html__( 'Featured Slider', 'catch-base' ),
		) );

		$wp_customize->add_section( 'catchbase_featured_slider', array(
			'panel'			=> 'catchbase_featured_slider',
			'priority'		=> 1,
			'title'			=> esc_html__( 'Featured Slider Options', 'catch-base' ),
		) );
	}
	else {
		$wp_customize->add_section( 'catchbase_featured_slider', array(
			'priority'      => 500,
			'title'			=> esc_html__( 'Featured Slider', 'catch-base' ),
		) );
	}

	$wp_customize->add_setting( 'catchbase_theme_options[featured_slider_option]', array(
		'capability'		=> 'edit_theme_options',
		'default'			=> $defaults['featured_slider_option'],
		'sanitize_callback' => 'catchbase_sanitize_select',
	) );

	$wp_customize->add_control( 'catchbase_theme_options[featured_slider_option]', array(
		'choices'   => catchbase_featured_slider_content_options(),
		'label'    	=> esc_html__( 'Enable Slider on', 'catch-base' ),
		'priority'	=> '1.1',
		'section'  	=> 'catchbase_featured_slider',
		'settings' 	=> 'catchbase_theme_options[featured_slider_option]',
		'type'    	=> 'select',
	) );

	$wp_customize->add_setting( 'catchbase_theme_options[featured_slide_transition_delay]', array(
		'capability'		=> 'edit_theme_options',
		'default'			=> $defaults['featured_slide_transition_delay'],
		'sanitize_callback'	=> 'absint',
	) );

	$wp_customize->add_control( 'catchbase_theme_options[featured_slide_transition_delay]' , array(
		'active_callback'	=> 'catchbase_is_slider_active',
		'description'		=> esc_html__( 'seconds(s)', 'catch-base' ),
		'input_attrs' 		=> array(
					            'style' => 'width: 40px;'
					        	),
		'label'    			=> esc_html__( 'Transition Delay', 'catch-base' ),
		'priority'			=> '2.1.1',
		'section'  			=> 'catchbase_featured_slider',
		'settings' 			=> 'catchbase_theme_options[featured_slide_transition_delay]',
		)
	);

	$wp_customize->add_setting( 'catchbase_theme_options[featured_slide_transition_length]', array(
		'capability'		=> 'edit_theme_options',
		'default'			=> $defaults['featured_slide_transition_length'],
		'sanitize_callback'	=> 'absint',
	) );

	$wp_customize->add_control( 'catchbase_theme_options[featured_slide_transition_length]' , array(
		'active_callback'	=> 'catchbase_is_slider_active',
		'description'		=> esc_html__( 'seconds(s)', 'catch-base' ),
		'input_attrs' 		=> array(
					            'style' => 'width: 40px;'
				            	),
		'label'    			=> esc_html__( 'Transition Length', 'catch-base' ),
		'priority'			=> '2.1.2',
		'section'  			=> 'catchbase_featured_slider',
		'settings' 			=> 'catchbase_theme_options[featured_slide_transition_length]',
		)
	);

	$wp_customize->add_setting( 'catchbase_theme_options[featured_slider_image_loader]', array(
		'capability'		=> 'edit_theme_options',
		'default'			=> $defaults['featured_slider_image_loader'],
		'sanitize_callback' => 'catchbase_sanitize_select',
	) );

	$wp_customize->add_control( 'catchbase_theme_options[featured_slider_image_loader]', array(
		'active_callback'	=> 'catchbase_is_slider_active',
		'description'		=> esc_html__( 'True: Fixes the height overlap issue. Slideshow will start as soon as two slider are available. Slide may display in random, as image is fetch.<br>Wait: Fixes the height overlap issue.<br> Slideshow will start only after all images are available.', 'catch-base' ),
		'choices'   		=> catchbase_featured_slider_image_loader(),
		'label'    			=> esc_html__( 'Image Loader', 'catch-base' ),
		'priority'			=> '2.1.3',
		'section'  			=> 'catchbase_featured_slider',
		'settings' 			=> 'catchbase_theme_options[featured_slider_image_loader]',
		'type'    			=> 'select',
	) );

	$wp_customize->add_setting( 'catchbase_theme_options[featured_slider_type]', array(
		'capability'		=> 'edit_theme_options',
		'default'			=> $defaults['featured_slider_type'],
		'sanitize_callback'	=> 'catchbase_sanitize_select',
	) );

	$wp_customize->add_control( 'catchbase_theme_options[featured_slider_type]', array(
		'active_callback'	=> 'catchbase_is_slider_active',
		'choices'  			=> catchbase_featured_slider_types(),
		'label'    			=> esc_html__( 'Select Slider Type', 'catch-base' ),
		'priority'			=> '2.1.3',
		'section'  			=> 'catchbase_featured_slider',
		'settings' 			=> 'catchbase_theme_options[featured_slider_type]',
		'type'	  			=> 'select',
	) );

	$wp_customize->add_setting( 'catchbase_theme_options[featured_slide_number]', array(
		'capability'		=> 'edit_theme_options',
		'default'			=> $defaults['featured_slide_number'],
		'sanitize_callback'	=> 'catchbase_sanitize_number_range',
	) );

	$wp_customize->add_control( 'catchbase_theme_options[featured_slide_number]' , array(
		'active_callback'	=> 'catchbase_is_demo_slider_inactive',
		'description'		=> esc_html__( 'Save and refresh the page if No. of Slides is changed (Max no of slides is 20)', 'catch-base' ),
		'input_attrs' 		=> array(
					            'style' => 'width: 45px;',
					            'min'   => 0,
					            'max'   => 20,
					            'step'  => 1,
					        	),
		'label'    			=> esc_html__( 'No of Slides', 'catch-base' ),
		'priority'			=> '2.1.4',
		'section'  			=> 'catchbase_featured_slider',
		'settings' 			=> 'catchbase_theme_options[featured_slide_number]',
		'type'	   			=> 'number',
		)
	);

	//loop for featured page sliders
	for ( $i=1; $i <= $options['featured_slide_number'] ; $i++ ) {
		$wp_customize->add_setting( 'catchbase_theme_options[featured_slider_page_'. $i .']', array(
			'capability'		=> 'edit_theme_options',
			'sanitize_callback'	=> 'catchbase_sanitize_page',
		) );

		$wp_customize->add_control( 'catchbase_theme_options[featured_slider_page_'. $i .']', array(
			'active_callback'	=> 'catchbase_is_demo_slider_inactive',
			'label'    			=> esc_html__( 'Featured Page', 'catch-base' ) . ' # ' . $i ,
			'priority'			=> '4' . $i,
			'section'  			=> 'catchbase_featured_slider',
			'settings' 			=> 'catchbase_theme_options[featured_slider_page_'. $i .']',
			'type'	   			=> 'dropdown-pages',
		) );
	}
// Featured Slider End

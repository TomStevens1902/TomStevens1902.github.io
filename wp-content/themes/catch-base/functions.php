<?php
/**
 * Functions and definitions
 *
 * Sets up the theme using core catchbase-core and provides some helper functions using catchbase-custon-functions.
 * Others are attached to action and
 * filter hooks in WordPress to change core functionality
 *
 * @package Catch Themes
 * @subpackage Catch Base
 * @since Catch Base 1.0
 */

//define theme version
if ( !defined( 'CATCHBASE_THEME_VERSION' ) ) {
	$theme_data = wp_get_theme();

	define ( 'CATCHBASE_THEME_VERSION', $theme_data->get( 'Version' ) );
}

/**
 * Implement the core functions
 */
require trailingslashit( get_template_directory() ) . 'inc/catchbase-core.php';
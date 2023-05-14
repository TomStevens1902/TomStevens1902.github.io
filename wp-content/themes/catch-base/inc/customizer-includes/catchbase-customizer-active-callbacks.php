<?php
/**
 * Active callbacks for Theme/Customzer Options
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

if ( ! function_exists( 'catchbase_is_logo_enabled' ) ) :
	/**
	* Return true if logo is enabled
	*
	* @since  Catch Base 2.7
	*/
	function catchbase_is_logo_enabled( $control ) {
		if ( function_exists( 'has_custom_logo' ) ) {
			return true;
		}
		else {
			return !$control->manager->get_setting( 'catchbase_theme_options[logo_disable]' )->value();
		}
	}
endif;


if ( ! function_exists( 'catchbase_is_featured_header_image_enabled' ) ) :
	/**
	* Return true if featured header image is enabled
	*
	* @since  Catch Base 2.7
	*/
	function catchbase_is_featured_header_image_enabled( $control ) {
		$enabled = $control->manager->get_setting( 'catchbase_theme_options[enable_featured_header_image]' )->value();
		return ( $enabled !== 'disabled' );
	}
endif;

if ( ! function_exists( 'catchbase_is_promotion_headline_enabled' ) ) :
	/**
	* Return true if promotion headline is enabled
	*
	* @since  Catch Base 2.7
	*/
	function catchbase_is_promotion_headline_enabled( $control ) {
		$enabled = $control->manager->get_setting( 'catchbase_theme_options[promotion_headline_option]' )->value();
		return ( $enabled !== 'disabled' );
	}
endif;


if ( ! function_exists( 'catchbase_is_slider_active' ) ) :
	/**
	* Return true if slider is active
	*
	* @since  Catch Base 2.1
	*/
	function catchbase_is_slider_active( $control ) {
		global $wp_query;

		$page_id = $wp_query->get_queried_object_id();

		// Front page display in Reading Settings
		$page_for_posts = get_option('page_for_posts');

		$enable = $control->manager->get_setting( 'catchbase_theme_options[featured_slider_option]' )->value();

		//return true only if previwed page on customizer matches the type of slider option selected
		return ( 'entire-site' == $enable || ( ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) && 'homepage' == $enable ) );
	}
endif;


if ( ! function_exists( 'catchbase_is_demo_slider_inactive' ) ) :
	/**
	* Return true if demo slider is inactive
	*
	* @since  Catch Base 2.1
	*/
	function catchbase_is_demo_slider_inactive( $control ) {
		global $wp_query;

		$page_id = $wp_query->get_queried_object_id();

		// Front page display in Reading Settings
		$page_for_posts = get_option('page_for_posts');

		$enable	= $control->manager->get_setting( 'catchbase_theme_options[featured_slider_option]' )->value();

		$type 	= $control->manager->get_setting( 'catchbase_theme_options[featured_slider_type]' )->value();

		//return true only if previwed page on customizer matches the type of slider option selected and is not demo slider
		return ( ( 'entire-site' == $enable || ( ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) && 'homepage' == $enable ) ) && !( 'demo-featured-slider' == $type ) );
	}
endif;


if ( ! function_exists( 'catchbase_is_featured_content_active' ) ) :
	/**
	* Return true if featured content is active
	*
	* @since  Catch Base 2.1
	*/
	function catchbase_is_featured_content_active( $control ) {
		global $wp_query;

		$page_id = $wp_query->get_queried_object_id();

		// Front page display in Reading Settings
		$page_for_posts = get_option('page_for_posts');

		$enable = $control->manager->get_setting( 'catchbase_theme_options[featured_content_option]' )->value();

		//return true only if previwed page on customizer matches the type of content option selected
		return ( 'entire-site' == $enable || ( ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) && 'homepage' == $enable ) );
	}
endif;


if ( ! function_exists( 'catchbase_is_demo_featured_content_inactive' ) ) :
	/**
	* Return true if demo featured content is inactive
	*
	* @since  Catch Base 2.1
	*/
	function catchbase_is_demo_featured_content_inactive( $control ) {
		global $wp_query;

		$page_id = $wp_query->get_queried_object_id();

		// Front page display in Reading Settings
		$page_for_posts = get_option('page_for_posts');

		$enable 	= $control->manager->get_setting( 'catchbase_theme_options[featured_content_option]' )->value();

		$type 	= $control->manager->get_setting( 'catchbase_theme_options[featured_content_type]' )->value();

		//return true only if previwed page on customizer matches the type of content option selected and is not demo content
		return ( ( 'entire-site' == $enable || ( ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) && 'homepage' == $enable ) ) && !( 'demo-featured-content' == $type ) );
	}
endif;
<?php
/**
 * The template for Managing Theme Structure
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


if ( ! function_exists( 'catchbase_doctype' ) ) :
	/**
	 * Doctype Declaration
	 *
	 * @since Catch Base 1.0
	 *
	 */
	function catchbase_doctype() {
		?>
		<!DOCTYPE html>
		<html <?php language_attributes(); ?>>
		<?php
	}
endif;
add_action( 'catchbase_doctype', 'catchbase_doctype', 10 );


if ( ! function_exists( 'catchbase_head' ) ) :
	/**
	 * Header Codes
	 *
	 * @since Catch Base 1.0
	 *
	 */
	function catchbase_head() {
		?>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<?php
		if ( is_singular() && pings_open() ) {
			echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
		}
	}
endif;
add_action( 'catchbase_before_wp_head', 'catchbase_head', 10 );


if ( ! function_exists( 'catchbase_page_start' ) ) :
	/**
	 * Start div id #page
	 *
	 * @since Catch Base 1.0
	 *
	 */
	function catchbase_page_start() {
		?>
		<div id="page" class="hfeed site">
		<?php
	}
endif;
add_action( 'catchbase_header', 'catchbase_page_start', 10 );


if ( ! function_exists( 'catchbase_page_end' ) ) :
	/**
	 * End div id #page
	 *
	 * @since Catch Base 1.0
	 *
	 */
	function catchbase_page_end() {
		?>
		</div><!-- #page -->
		<?php
	}
endif;
add_action( 'catchbase_footer', 'catchbase_page_end', 200 );


if ( ! function_exists( 'catchbase_header_start' ) ) :
	/**
	 * Start Header id #masthead and class .wrapper
	 *
	 * @since Catch Base 1.0
	 *
	 */
	function catchbase_header_start() {
		?>
		<header id="masthead" role="banner">
    		<div class="wrapper">
		<?php
	}
endif;
add_action( 'catchbase_header', 'catchbase_header_start', 20 );


if ( ! function_exists( 'catchbase_header_end' ) ) :
	/**
	 * End Header id #masthead and class .wrapper
	 *
	 * @since Catch Base 1.0
	 *
	 */
	function catchbase_header_end() {
		?>
			</div><!-- .wrapper -->
		</header><!-- #masthead -->
		<?php
	}
endif;
add_action( 'catchbase_header', 'catchbase_header_end', 100 );


if ( ! function_exists( 'catchbase_content_start' ) ) :
	/**
	 * Start div id #content and class .wrapper
	 *
	 * @since Catch Base 1.0
	 *
	 */
	function catchbase_content_start() {
		?>
		<div id="content" class="site-content">
			<div class="wrapper">
	<?php
	}
endif;
add_action('catchbase_content', 'catchbase_content_start', 10 );

if ( ! function_exists( 'catchbase_content_end' ) ) :
	/**
	 * End div id #content and class .wrapper
	 *
	 * @since Catch Base 1.0
	 */
	function catchbase_content_end() {
		?>
			</div><!-- .wrapper -->
	    </div><!-- #content -->
		<?php
	}

endif;
add_action( 'catchbase_after_content', 'catchbase_content_end', 30 );


if ( ! function_exists( 'catchbase_content_sidebar_wrap_start' ) ) :
	/**
	 * Start div id #content_sidebar_wrap
	 *
	 * @since Catch Base 1.0
	 */
	function catchbase_content_sidebar_wrap_start() {
		?>
			<div id="content_sidebar_wrap">
		<?php
	}
endif;


if ( ! function_exists( 'catchbase_content_sidebar_wrap_end' ) ) :
	/**
	 * End div id #content_sidebar_wrap
	 *
	 * @since Catch Base 1.0
	 */
	function catchbase_content_sidebar_wrap_end() {
		?>
			</div><!-- #content_sidebar_wrap -->
		<?php
	}
endif;


if ( ! function_exists( 'catchbase_sidebar_secondary' ) ) :
	/**
	 * Secondary Sidebar
	 *
	 * @since Catch Base 1.0
	 */
	function catchbase_sidebar_secondary() {
		get_sidebar( 'secondary' );
	}
endif;


if ( ! function_exists( 'catchbase_layout_condition_check' ) ) :
	/**
	 * Layout Optons Condition Check and Hook
	 *
	 * @since Catch Base 1.0
	 */
	function catchbase_layout_condition_check() {
		$layout = catchbase_get_theme_layout();
		if ( 'three-columns' == $layout || ( $layout=='default' && ( 'three-columns' == $themeoption_layout ) ) ){
			add_action( 'catchbase_after_content', 'catchbase_content_sidebar_wrap_end', 10 );

			add_action( 'catchbase_after_content', 'catchbase_sidebar_secondary', 20 );

			add_action( 'catchbase_content', 'catchbase_content_sidebar_wrap_start', 40 );
		}
	} // catchbase_layout_condition_check
endif;
add_action( 'catchbase_before', 'catchbase_layout_condition_check' );


if ( ! function_exists( 'catchbase_footer_content_start' ) ) :
/**
 * Start footer id #colophon
 *
 * @since Catch Base 1.0
 */
function catchbase_footer_content_start() {
	?>
	<footer id="colophon" class="site-footer" role="contentinfo">
    <?php
}
endif;
add_action( 'catchbase_footer', 'catchbase_footer_content_start', 30 );


if ( ! function_exists( 'catchbase_footer_sidebar' ) ) :
/**
 * Footer Sidebar
 *
 * @since Catch Base 1.0
 */
function catchbase_footer_sidebar() {
	get_sidebar( 'footer' );
}
endif;
add_action( 'catchbase_footer', 'catchbase_footer_sidebar', 40 );


if ( ! function_exists( 'catchbase_footer_content_end' ) ) :
/**
 * End footer id #colophon
 *
 * @since Catch Base 1.0
 */
function catchbase_footer_content_end() {
	?>
	</footer><!-- #colophon -->
	<?php
}
endif;
add_action( 'catchbase_footer', 'catchbase_footer_content_end', 110 );


if ( ! function_exists( 'catchbase_header_right' ) ) :
/**
 * Shows Header Right Social Icon
 *
 * @since Catch Base 1.0
 */
function catchbase_header_right() { ?>
	<aside class="sidebar sidebar-header-right widget-area">
		<?php if ( '' != ( $catchbase_social_icons = catchbase_get_social_icons() ) ) { ?>
			<section class="widget widget_catchbase_social_icons" id="header-right-social-icons">
				<div class="widget-wrap">
					<?php echo $catchbase_social_icons; ?>
				</div>
			</section>
		<?php } ?>
	</aside><!-- .sidebar .header-sidebar .widget-area -->
<?php
}
endif;
add_action( 'catchbase_header', 'catchbase_header_right', 60 );

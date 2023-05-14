<?php
/**
 * Implement Custom Header functionality
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


if ( ! function_exists( 'catchbase_custom_header' ) ) :
/**
 * Implementation of the Custom Header feature
 * Setup the WordPress core custom header feature and default custom headers packaged with the theme.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 */
	function catchbase_custom_header() {
		/**
		 * Get Theme Options Values
		 */
		$options 	= catchbase_get_theme_options();

		if ( 'light' == $options['color_scheme'] ) {
			$default_header_color = catchbase_get_default_theme_options();
			$default_header_color = $default_header_color['header_textcolor'];
		}
		elseif ( 'dark' == $options['color_scheme'] ) {
			$default_header_color = catchbase_default_dark_color_options();
			$default_header_color = $default_header_color['header_textcolor'];
		}

		$args = array(
		// Text color and image (empty to use none).
		'default-text-color'     => $default_header_color,

		// Header image default
		'default-image'			=> trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'images/headers/header-image.jpg',

		// Set height and width, with a maximum value for the width.
		'height'                 => 400,
		'width'                  => 1200,

		// Support flexible height and width.
		'flex-height'            => true,
		'flex-width'             => true,

		// Random image rotation off by default.
		'random-default'         => false,

		// Callbacks for styling the header and the admin preview.
		'wp-head-callback'       => 'catchbase_header_style',
		'admin-head-callback'    => 'catchbase_admin_header_style',
		'admin-preview-callback' => 'catchbase_admin_header_image',
	);

	$args = apply_filters( 'custom-header', $args );

	// Add support for custom header
	add_theme_support( 'custom-header', $args );

	}
endif; // catchbase_custom_header
add_action( 'after_setup_theme', 'catchbase_custom_header' );


if ( ! function_exists( 'catchbase_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 *
 * @see catchbase_custom_header()
 *
 * @since Catch Base 0.3
 */
function catchbase_header_style() {

	// If no custom options for text are set, let's bail
	// get_header_textcolor() options: get_theme_support( 'custom-header', 'default-text-color' ) is default, hide text (returns 'blank') or any hex value
	if ( get_theme_support( 'custom-header', 'default-text-color' ) === get_header_textcolor() )
		return;
	// If we get this far, we have custom styles. Let's do this.
	?>
	<style type="text/css">
	<?php
		// Has the text been hidden?
		if ( 'blank' != get_header_textcolor() ) { ?>
			.site-title a,
			.site-description {
				color: #<?php echo get_header_textcolor(); ?> !important;
			}
	<?php
	} ?>
	</style>
	<?php
}
endif; // catchbase_header_style


if ( ! function_exists( 'catchbase_admin_header_style' ) ) :
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * @since Catch Base 1.0
 */
function catchbase_admin_header_style() {
	$options 	= catchbase_get_theme_options();

	$defaults 	= catchbase_get_default_theme_options();
?>
	<style type="text/css">
	body {
		color: #404040;
		font-family: sans-serif;
		font-size: 15px;
		line-height: 1.5;
	}
	#site-logo,
	#site-header {
	    display: inline-block;
	    float: left;
	}
	#site-branding .site-title {
		font-size: 40px;
    	font-weight: bold;
    	line-height: 1.2;
    	margin: 0;
	}
	#site-branding .site-title a {
		color: #404040;
		text-decoration: none;
	}
	#site-branding .site-description {
		color: #404040;
		font-size: 13px;
		line-height: 1.2;
		font-style: italic;
		padding: 0;
	}
	.logo-left #site-header {
		padding-left: 10px;
	}
	.logo-right #site-header {
		padding-right: 10px;
	}
	#header-featured-image {
		clear: both;
		padding-top: 20px;
		max-width: 90%;
	}
	#header-featured-image img {
		height: auto;
		max-width: 100%;
	}
	<?php
	// If the user has set a custom color for the text use that
	if ( get_theme_support( 'custom-header', 'default-text-color' ) !== get_header_textcolor() ) {
		echo '
		#site-branding .site-title a,
		#site-branding .site-description {
			color: #' . get_header_textcolor() . ';
		}';
	}
	 ?>
	</style>
<?php
}
endif; // catchbase_admin_header_style


if ( ! function_exists( 'catchbase_admin_header_image' ) ) :
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * @since Catch Base 1.0
 */
function catchbase_admin_header_image() {

	catchbase_site_branding();
	catchbase_featured_image();
?>

<?php
}
endif; // catchbase_admin_header_image


if ( ! function_exists( 'catchbase_site_branding' ) ) :
	/**
	 * Get the logo and display
	 *
	 * @uses get_transient, catchbase_get_theme_options, get_header_textcolor, get_bloginfo, set_transient, display_header_text
	 * @get logo from options
	 *
	 * @display logo
	 *
	 * @action
	 *
	 * @since Catch Base 1.0
	 */
	function catchbase_site_branding() {
		//catchbase_flush_transients();
		$options 			= catchbase_get_theme_options();

		$catchbase_site_logo = '';
		//Checking Logo
		if ( function_exists( 'has_custom_logo' ) ) {
			if ( has_custom_logo() ) {
				$catchbase_site_logo = '
				<div id="site-logo">'. get_custom_logo() . '</div><!-- #site-logo -->';
			}
		}
		elseif ( '' != $options['logo'] && !$options['logo_disable'] ) {
			//@remove Remove this elseif block when WordPress 4.8 is released
			$catchbase_site_logo = '
			<div id="site-logo">
				<a href="' . esc_url( home_url( '/' ) ) . '" title="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" rel="home">
					<img src="' . esc_url( $options['logo'] ) . '" alt="' . esc_attr(  $options['logo_alt_text'] ). '">
				</a>
			</div><!-- #site-logo -->';
		}

		$catchbase_header_text = '<div id="site-header">';

		if ( is_front_page() && is_home() ) :
			$catchbase_header_text .= '<h1 class="site-title"><a href="' . esc_url( home_url( '/' ) ) . '">' . get_bloginfo( 'name' ) . '</a></h1>';
		else :
			$catchbase_header_text .= '<p class="site-title"><a href="' . esc_url( home_url( '/' ) ) . '">' . get_bloginfo( 'name' ) . '</a></p>';
		endif;

			$catchbase_header_text .= '<p class="site-description">' . get_bloginfo( 'description' ) . '</p>';

		$catchbase_header_text .= '</div><!-- #site-header -->';

		$text_color = get_header_textcolor();

		$catchbase_site_branding	= '<div id="site-branding">';
		$catchbase_site_branding	.= $catchbase_header_text;

		if ( function_exists( 'has_custom_logo' ) ) {
			if ( has_custom_logo() ) {
				if ( ! $options['move_title_tagline'] && 'blank' != $text_color ) {
					$catchbase_site_branding  = '<div id="site-branding" class="logo-left">';
					$catchbase_site_branding .= $catchbase_site_logo;
					$catchbase_site_branding .= $catchbase_header_text;
				}
				else {
					$catchbase_site_branding  = '<div id="site-branding" class="logo-right">';
					$catchbase_site_branding .= $catchbase_header_text;
					$catchbase_site_branding .= $catchbase_site_logo;
				}
			}
		}
		elseif ( '' != $options['logo'] && !$options['logo_disable'] ) {
			//@remove Remove this elseif block when WordPress 4.8 is released
			if ( ! $options['move_title_tagline'] && 'blank' != $text_color ) {
				$catchbase_site_branding  = '<div id="site-branding" class="logo-left">';
				$catchbase_site_branding .= $catchbase_site_logo;
				$catchbase_site_branding .= $catchbase_header_text;
			}
			else {
				$catchbase_site_branding  = '<div id="site-branding" class="logo-right">';
				$catchbase_site_branding .= $catchbase_header_text;
				$catchbase_site_branding .= $catchbase_site_logo;
			}

		}

		$catchbase_site_branding 	.= '</div><!-- #site-branding-->';

		echo $catchbase_site_branding ;
	}
endif; // catchbase_site_branding
add_action( 'catchbase_header', 'catchbase_site_branding', 50 );


if ( ! function_exists( 'catchbase_featured_image' ) ) :
	/**
	 * Template for Featured Header Image from theme options
	 *
	 * To override this in a child theme
	 * simply create your own catchbase_featured_image(), and that function will be used instead.
	 *
	 * @since Catch Base 1.0
	 */
	function catchbase_featured_image() {
		$options				= catchbase_get_theme_options();

		$header_image 			= get_header_image();

		//Support Random Header Image
		if ( is_random_header_image() ) {
			delete_transient( 'catchbase_featured_image' );
		}

		if ( !$catchbase_featured_image = get_transient( 'catchbase_featured_image' ) ) {

			echo '<!-- refreshing cache -->';

			if ( '' != $header_image ) {

				// Header Image Link and Target
				if ( !empty( $options['featured_header_image_url'] ) ) {
					//support for qtranslate custom link
					if ( function_exists( 'qtrans_convertURL' ) ) {
						$link = qtrans_convertURL($options['featured_header_image_url']);
					}
					else {
						$link = esc_url( $options['featured_header_image_url'] );
					}
					//Checking Link Target
					if ( !empty( $options['featured_header_image_base'] ) )  {
						$target = '_blank';
					}
					else {
						$target = '_self';
					}
				}
				else {
					$link = '';
					$target = '';
				}

				// Header Image Title/Alt
				if ( !empty( $options['featured_header_image_alt'] ) ) {
					$title = esc_attr( $options['featured_header_image_alt'] );
				}
				else {
					$title = '';
				}

				// Header Image
				$feat_image = '<img class="wp-post-image" alt="' . esc_attr( $title ) . '" src="'.esc_url(  $header_image ).'" />';

				$catchbase_featured_image = '<div id="header-featured-image">
					<div class="wrapper">';
					// Header Image Link
					if ( !empty( $options['featured_header_image_url'] ) ) :
						$catchbase_featured_image .= '<a title="'. esc_attr( $title ).'" href="'. esc_url( $link ) .'" target="' . $target . '">' . $feat_image . '</a>';
					else:
						// if empty featured_header_image on theme options, display default
						$catchbase_featured_image .= $feat_image;
					endif;
				$catchbase_featured_image .= '</div><!-- .wrapper -->
				</div><!-- #header-featured-image -->';
			}

			set_transient( 'catchbase_featured_image', $catchbase_featured_image, 86940 );
		}

		echo $catchbase_featured_image;

	} // catchbase_featured_image
endif;


if ( ! function_exists( 'catchbase_featured_page_post_image' ) ) :
	/**
	 * Template for Featured Header Image from Post and Page
	 *
	 * To override this in a child theme
	 * simply create your own catchbase_featured_imaage_pagepost(), and that function will be used instead.
	 *
	 * @since Catch Base 1.0
	 */
	function catchbase_featured_page_post_image() {
		global $post, $wp_query;

		// Get Page ID outside Loop
		$page_id = $wp_query->get_queried_object_id();
		$page_for_posts = get_option('page_for_posts');

		if ( is_home() && $page_for_posts == $page_id ) {
			$header_page_id = $page_id;
		}
		else {
			$header_page_id = $post->ID;
		}

		if ( has_post_thumbnail( $header_page_id ) ) {
		   	$options					= catchbase_get_theme_options();
			$featured_header_image_url	= $options['featured_header_image_url'];
			$featured_header_image_base	= $options['featured_header_image_base'];

			if ( '' != $featured_header_image_url ) {
				//support for qtranslate custom link
				if ( function_exists( 'qtrans_convertURL' ) ) {
					$link = qtrans_convertURL( $featured_header_image_url );
				}
				else {
					$link = esc_url( $featured_header_image_url );
				}
				//Checking Link Target
				if ( '1' == $featured_header_image_base ) {
					$target = '_blank';
				}
				else {
					$target = '_self';
				}
			}
			else {
				$link = '';
				$target = '';
			}

			$featured_header_image_alt	= $options['featured_header_image_alt'];
			// Header Image Title/Alt
			if ( '' != $featured_header_image_alt ) {
				$title = esc_attr( $featured_header_image_alt );
			}
			else {
				$title = '';
			}

			$featured_image_size	= $options['featured_image_size'];

			if ( 'slider' ==  $featured_image_size ) {
				$feat_image = get_the_post_thumbnail( $post->ID, 'catchbase-slider', array('id' => 'main-feat-img'));
			}
			elseif ( 'full' ==  $featured_image_size ) {
				$feat_image = get_the_post_thumbnail( $post->ID, 'full', array('id' => 'main-feat-img'));
			}
			else {
				$feat_image = get_the_post_thumbnail( $post->ID, 'catchbase-large', array('id' => 'main-feat-img'));
			}

			$catchbase_featured_image = '<div id="header-featured-image" class =' . $featured_image_size . '>';
				// Header Image Link
				if ( '' != $featured_header_image_url ) :
					$catchbase_featured_image .= '<a title="'. esc_attr( $title ).'" href="'. esc_url( $link ) .'" target="' . $target . '">' . $feat_image . '</a>';
				else:
					// if empty featured_header_image on theme options, display default
					$catchbase_featured_image .= $feat_image;
				endif;
			$catchbase_featured_image .= '</div><!-- #header-featured-image -->';

			echo $catchbase_featured_image;
		}
		else {
			catchbase_featured_image();
		}
	} // catchbase_featured_page_post_image
endif;


if ( ! function_exists( 'catchbase_featured_overall_image' ) ) :
	/**
	 * Template for Featured Header Image from theme options
	 *
	 * To override this in a child theme
	 * simply create your own catchbase_featured_pagepost_image(), and that function will be used instead.
	 *
	 * @since Catch Base 1.0
	 */
	function catchbase_featured_overall_image() {
		global $post, $wp_query;
		$options				= catchbase_get_theme_options();
		$defaults 				= catchbase_get_default_theme_options();
		$enableheaderimage 		= $options['enable_featured_header_image'];

		// Get Page ID outside Loop
		$page_id = $wp_query->get_queried_object_id();

		$page_for_posts = get_option('page_for_posts');

		// Check Enable/Disable header image in Page/Post Meta box
		if ( is_page() || is_single() ) {
			//Individual Page/Post Image Setting
			$individual_featured_image = get_post_meta( $post->ID, 'catchbase-header-image', true );

			if ( 'disable' == $individual_featured_image || ( 'default' == $individual_featured_image && 'disable' == $enableheaderimage ) ) {
				echo '<!-- Page/Post Disable Header Image -->';
				return;
			}
			elseif ( 'enable' == $individual_featured_image && 'disabled' == $enableheaderimage ) {
				catchbase_featured_page_post_image();
			}
		}

		// Check Homepage
		if ( 'homepage' == $enableheaderimage ) {
			if ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) {
				catchbase_featured_image();
			}
		}
		// Check Excluding Homepage
		if ( 'exclude-home' == $enableheaderimage ) {
			if ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) {
				return false;
			}
			else {
				catchbase_featured_image();
			}
		}
		elseif ( 'exclude-home-page-post' == $enableheaderimage ) {
			if ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) {
				return false;
			}
			elseif ( is_page() || is_single() ) {
				catchbase_featured_page_post_image();
			}
			else {
				catchbase_featured_image();
			}
		}
		// Check Entire Site
		elseif ( 'entire-site' == $enableheaderimage ) {
			catchbase_featured_image();
		}
		// Check Entire Site (Post/Page)
		elseif ( 'entire-site-page-post' == $enableheaderimage ) {
			if ( is_page() || is_single() ) {
				catchbase_featured_page_post_image();
			}
			else {
				catchbase_featured_image();
			}
		}
		// Check Page/Post
		elseif ( 'pages-posts' == $enableheaderimage ) {
			if ( is_page() || is_single() ) {
				catchbase_featured_page_post_image();
			}
			else {
				return false;
			}
		}
		else {
			echo '<!-- Disable Header Image -->';
		}
	} // catchbase_featured_overall_image
endif;


if ( ! function_exists( 'catchbase_featured_image_display' ) ) :
	/**
	 * Display Featured Header Image
	 *
	 * @since Catch Base 1.0
	 */
	function catchbase_featured_image_display() {
		add_action( 'catchbase_after_header', 'catchbase_featured_overall_image', 40 );
	} // catchbase_featured_image_display
endif;
add_action( 'catchbase_before', 'catchbase_featured_image_display' );

<?php
/**
 * The template for displaying the Featured Content
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


if ( !function_exists( 'catchbase_featured_content_display' ) ) :
/**
* Add Featured content.
*
* @uses action hook catchbase_before_content.
*
* @since Catch Base 1.0
*/
function catchbase_featured_content_display() {
	//catchbase_flush_transients();

	global $post, $wp_query;

	// get data value from options
	$options 		= catchbase_get_theme_options();
	$enablecontent 	= $options['featured_content_option'];
	$contentselect 	= $options['featured_content_type'];

	// Front page displays in Reading Settings
	$page_on_front 	= get_option('page_on_front') ;
	$page_for_posts = get_option('page_for_posts');


	// Get Page ID outside Loop
	$page_id = $wp_query->get_queried_object_id();
	if ( 'entire-site' == $enablecontent || ( ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) && 'homepage' == $enablecontent ) ) {
		if ( ( !$catchbase_featured_content = get_transient( 'catchbase_featured_content_display' ) ) ) {
			$layouts 	 = $options['featured_content_layout'];
			$headline 	 = $options['featured_content_headline'];
			$subheadline = $options['featured_content_subheadline'];

			echo '<!-- refreshing cache -->';

			if ( !empty( $layouts ) ) {
				$classes = $layouts ;
			}

			if ( 'demo-featured-content' == $contentselect ) {
				$classes 		.= ' demo-featured-content' ;
				$headline 		= __( 'Featured Content', 'catch-base' );
				$subheadline 	= __( 'Here you can showcase the x number of Featured Content. You can edit this Headline, Subheadline and Feaured Content from "Appearance -> Customize -> Featured Content Options".', 'catch-base' );
			}
			elseif ( 'featured-page-content' == $contentselect ) {
				$classes .= ' featured-page-content' ;
			}

			//Check Featured Content Position
			if ( isset( $options['featured_content_position'] ) ) {
				$featured_content_position = $options['featured_content_position'];
			}
			// Providing Backward Compatible with Version 1.0
			else {
				$featured_content_position =  $options['move_posts_home'];
			}

			if ( '1' == $featured_content_position ) {
				$classes .= ' border-top' ;
			}

			$catchbase_featured_content ='
				<section id="featured-content" class="' . $classes . '">
					<div class="wrapper">';
						if ( !empty( $headline ) || !empty( $subheadline ) ) {
							$catchbase_featured_content .='<div class="featured-heading-wrap">';
								if ( !empty( $headline ) ) {
									$catchbase_featured_content .='<h2 id="featured-heading" class="entry-title">' . wp_kses_post( $headline ) . '</h2>';
								}
								if ( !empty( $subheadline ) ) {
									$catchbase_featured_content .='<p>' . wp_kses_post( $subheadline ) . '</p>';
								}
							$catchbase_featured_content .='</div><!-- .featured-heading-wrap -->';
						}
						$catchbase_featured_content .='
						<div class="featured-content-wrap">';

							// Select content
							if ( 'demo-featured-content' == $contentselect  && function_exists( 'catchbase_demo_content' ) ) {
								$catchbase_featured_content .= catchbase_demo_content( $options );
							}
							elseif ( 'featured-page-content' == $contentselect && function_exists( 'catchbase_page_content' ) ) {
								$catchbase_featured_content .= catchbase_page_content( $options );
							}

			$catchbase_featured_content .='
						</div><!-- .featured-content-wrap -->
					</div><!-- .wrapper -->
				</section><!-- #featured-content -->';
		set_transient( 'catchbase_featured_content', $catchbase_featured_content, 86940 );
		}
	echo $catchbase_featured_content;
	}
}
endif;


if ( ! function_exists( 'catchbase_featured_content_display_position' ) ) :
/**
 * Homepage Featured Content Position
 *
 * @action catchbase_content, catchbase_after_secondary
 *
 * @since Catch Base 1.0
 */
function catchbase_featured_content_display_position() {
	// Getting data from Theme Options
	$options 		= catchbase_get_theme_options();

	//Check Featured Content Position
	if ( isset( $options['featured_content_position'] ) ) {
		$featured_content_position = $options['featured_content_position'];
	}
	// Providing Backward Compatible with Version 1.0
	else {
		$featured_content_position =  $options['move_posts_home'];
	}

	if ( '1' != $featured_content_position ) {
		add_action( 'catchbase_before_content', 'catchbase_featured_content_display', 40 );
	} else {
		add_action( 'catchbase_after_content', 'catchbase_featured_content_display', 40 );
	}

}
endif; // catchbase_featured_content_display_position
add_action( 'catchbase_before', 'catchbase_featured_content_display_position' );


if ( ! function_exists( 'catchbase_demo_content' ) ) :
/**
 * This function to display featured posts content
 *
 * @get the data value from customizer options
 *
 * @since Catch Base 1.0
 *
 */
function catchbase_demo_content( $options ) {
	$catchbase_demo_content = '
		<article id="featured-post-1" class="post hentry post-demo">
			<figure class="featured-content-image">
				<img alt="Durbar Square" class="wp-post-image" src="'.trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'images/gallery/featured1-400x225.jpg" />
			</figure>
			<div class="entry-container">
				<header class="entry-header">
					<h2 class="entry-title">
						Durbar Square
					</h2>
				</header>
				<div class="entry-content">
					The Kathmandu Durbar Square holds the palaces of the Malla and Shah kings who ruled over the city. Along with these palaces, the square surrounds quadrangles revealing courtyards and temples.
				</div>
			</div><!-- .entry-container -->
		</article>

		<article id="featured-post-2" class="post hentry post-demo">
			<figure class="featured-content-image">
				<img alt="Seto Ghumba" class="wp-post-image" src="'.trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'images/gallery/featured2-400x225.jpg" />
			</figure>
			<div class="entry-container">
				<header class="entry-header">
					<h2 class="entry-title">
						Seto Ghumba
					</h2>
				</header>
				<div class="entry-content">
					Situated western part in the outskirts of the Kathmandu valley, Seto Gumba also known as Druk Amitabh Mountain or White Monastery, is one of the most popular Buddhist monasteries of Nepal.
				</div>
			</div><!-- .entry-container -->
		</article>

		<article id="featured-post-3" class="post hentry post-demo">
			<figure class="featured-content-image">
				<img alt="Swayambhunath" class="wp-post-image" src="'.trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'images/gallery/featured3-400x225.jpg" />
			</figure>
			<div class="entry-container">
				<header class="entry-header">
					<h2 class="entry-title">
						Swayambhunath
					</h2>
				</header>
				<div class="entry-content">
					Swayambhunath is an ancient religious site up in the hill around Kathmandu Valley. It is also known as the Monkey Temple as there are holy monkeys living in the north-west parts of the temple.
				</div>
			</div><!-- .entry-container -->
		</article>';

	if ( 'layout-four' == $options['featured_content_layout']) {
		$catchbase_demo_content .= '
		<article id="featured-post-4" class="post hentry post-demo">
			<figure class="featured-content-image">
				<img alt="Dhulikhel" class="wp-post-image" src="'.trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'images/gallery/featured4-400x225.jpg" />
			</figure>
			<div class="entry-container">
				<header class="entry-header">
					<h2 class="entry-title">
						Dhulikhel
					</h2>
				</header>
				<div class="entry-content">
					Dhulikhel is a popular place to observe the high Himalaya - A Tourist Paradise: The spectacular snowfed mountains seen from Dhuklikhel must be one of the finest panoramic views in the world.
				</div>
			</div><!-- .entry-container -->
		</article>';
	}

	return $catchbase_demo_content;
}
endif; // catchbase_demo_content


if ( ! function_exists( 'catchbase_page_content' ) ) :
/**
 * This function to display featured page content
 *
 * @param $options: catchbase_theme_options from customizer
 *
 * @since Catch Base 1.0
 */
function catchbase_page_content( $options ) {
	global $post;

	$quantity 					= $options['featured_content_number'];

	$more_link_text				= $options['excerpt_more_text'];

	$show_content				= isset( $options['featured_content_show'] ) ? $options['featured_content_show'] : 'excerpt';

	$catchbase_page_content 	= '';

   	$number_of_page 			= 0; 		// for number of pages

	$page_list					= array();	// list of valid pages ids

	//Get valid pages
	for( $i = 1; $i <= $quantity; $i++ ){
		if ( isset ( $options['featured_content_page_' . $i] ) && $options['featured_content_page_' . $i] > 0 ){
			$number_of_page++;

			$page_list	=	array_merge( $page_list, array( $options['featured_content_page_' . $i] ) );
		}

	}
	if ( !empty( $page_list ) && $number_of_page > 0 ) {
		$loop = new WP_Query( array(
                    'posts_per_page' 		=> $number_of_page,
                    'post__in'       		=> $page_list,
                    'orderby'        		=> 'post__in',
                    'post_type'				=> 'page',
                ));

		$i=0;
		while ( $loop->have_posts()) : $loop->the_post(); $i++;
			$title_attribute = the_title_attribute( 'echo=0' );

			$excerpt = get_the_excerpt();

			$catchbase_page_content .= '
				<article id="featured-post-' . $i . '" class="post hentry featured-page-content">';
				if ( has_post_thumbnail() ) {
					$catchbase_page_content .= '
					<figure class="featured-homepage-image">
						<a href="' . esc_url( get_permalink() ) . '" title="' . the_title_attribute( array( 'before' => esc_html__( 'Permalink to:', 'catch-base' ), 'echo' => false ) ) . '">
						'. get_the_post_thumbnail( $post->ID, 'medium', array( 'title' => $title_attribute, 'alt' => $title_attribute, 'class' => 'pngfix' ) ) .'
						</a>
					</figure>';
				}
				else {
					$catchbase_first_image = catchbase_get_first_image( $post->ID, 'medium', array( 'title' => $title_attribute, 'alt' => $title_attribute, 'class' => 'pngfix' ) );

					if ( '' != $catchbase_first_image ) {
						$catchbase_page_content .= '
						<figure class="featured-homepage-image">
							<a href="' . esc_url( get_permalink() ) . '" title=""' . the_title_attribute( array( 'before' => esc_html__( 'Permalink to:', 'catch-base' ), 'echo' => false ) ) . '">
								'. $catchbase_first_image .'
							</a>
						</figure>';
					}
				}

				$catchbase_page_content .= '
					<div class="entry-container">
						<header class="entry-header">
							<h2 class="entry-title">
								<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . the_title( '','', false ) . '</a>
							</h2>
						</header>';
						if ( 'excerpt' == $show_content ) {
							$catchbase_page_content .= '<div class="entry-excerpt"><p>' . $excerpt . '</p></div><!-- .entry-excerpt -->';
						}
						elseif ( 'full-content' == $show_content ) {
							$content = apply_filters( 'the_content', get_the_content() );
							$content = str_replace( ']]>', ']]&gt;', $content );
							$catchbase_page_content .= '<div class="entry-content">' . wp_kses_post( $content ) . '</div><!-- .entry-content -->';
						}
					$catchbase_page_content .= '
					</div><!-- .entry-container -->
				</article><!-- .featured-post-'. $i .' -->';
		endwhile;

		wp_reset_postdata();
	}

	return $catchbase_page_content;
}
endif; // catchbase_page_content

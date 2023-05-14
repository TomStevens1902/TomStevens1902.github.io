/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {
	// Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );

	// Header text color.
	wp.customize( 'header_textcolor', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' === to ) {
				$( '.site-title a, .site-description' ).css( {
					'clip': 'rect(1px, 1px, 1px, 1px)',
					'position': 'absolute'
				} );
			} else {
				$( '.site-title a, .site-description' ).css( {
					'clip': 'auto',
					'position': 'relative'
				} );
				$( '.site-title a, .site-description' ).css( {
					'color': to
				} );
			}
		} );
	} );

	/**
	 * Customizer scripts on catchbase-customizer.js for catchbase.
	 *
	 * @since Catch Base 2.7
	 */

	// Logo
	wp.customize( 'catchbase_theme_options[logo]', function( value ) {
		value.bind( function( to ) {
			logo_disable = wp.customize('catchbase_theme_options[logo_disable]').get();
			if ( '' != to ) {
				if ( false === logo_disable ) {
					$( 'div#site-logo a img' ).attr( 'src', to );
					$( 'div#site-logo' ).show();
				}
			}
			else {
				$( 'div#site-logo' ).hide();
			}
		} );
	} );

	// Logo alt text
	wp.customize( 'catchbase_theme_options[logo_alt_text]', function( value ) {
		value.bind( function( to ) {
			var logo 			= wp.customize( 'catchbase_theme_options[logo]' ).get();
			var logo_disable 	= wp.customize( 'catchbase_theme_options[logo_disable]' ).get();

			if ( ( '' != logo ) && ( false === logo_disable ) ) {
				$( 'div#site-logo a img' ).attr( 'alt', to );
			}
		} );
	} );

	// Move site title and tag-line before logo
	wp.customize( 'catchbase_theme_options[move_title_tagline]', function( value ) {
		value.bind( function( to ) {
			logo = wp.customize( 'catchbase_theme_options[logo]' ).get();
			logo_disable = wp.customize( 'catchbase_theme_options[logo_disable]' ).get();

			if ( ( '' != logo ) && ( false === logo_disable ) ) {
				var cur_class 	= $( 'div#site-branding' ).attr( 'class' );
				var $logo_div 	= $( 'div#site-logo' );
				var $header_div = $( 'div#site-header' );
				$header_clone 	= $header_div.clone();
				$logo_clone 	= $logo_div.clone();

				if ( 'logo-right' === cur_class ) {
					if ( !$logo_div.is( ':empty' ) ) {
					    $header_div.replaceWith( $logo_clone );
					    $logo_div.replaceWith( $header_clone );
					}
					$( 'div#site-branding' ).attr( 'class', 'logo-left' );
				} else {
					if ( !$logo_div.is( ':empty' ) ) {
					    $header_div.replaceWith( $logo_clone );
					    $logo_div.replaceWith( $header_clone );
					}
					$( 'div#site-branding' ).attr( 'class', 'logo-right' );
				}
			}
		} );
	} );

	//Header image alt text
	wp.customize( 'catchbase_theme_options[featured_header_image_alt]', function( value ) {
		value.bind( function( to ) {
			var enable_featured_header_image = wp.customize( 'catchbase_theme_options[enable_featured_header_image]' ).get();

			//check if enable featured header image is set to disabled
			if ( 'disabled' !== enable_featured_header_image ) {
				$( 'div#header-featured-image .wrapper img.wp-post-image' ).attr( 'alt', to );

				$a = $( 'div#header-featured-image .wrapper a' );

				//check if link tag for header featured image exists
				if (0 != $a.length ) {
					$a.attr( 'title', to );
				}
			}
		} );
	} );

	//Header image link url
	wp.customize( 'catchbase_theme_options[featured_header_image_url]', function( value ) {
		value.bind( function( to ) {
			var enable_featured_header_image 	= wp.customize( 'catchbase_theme_options[enable_featured_header_image]' ).get();
			var header_image 					= wp.customize( 'header_image' ).get();
			var featured_header_image_alt_text 	= wp.customize( 'catchbase_theme_options[featured_header_image_alt]' ).get();
			var target 							= wp.customize( 'catchbase_theme_options[featured_header_image_base]' ).get();

			if ( true === target ) {
				target 	= '_blank';
			} else {
				target 	= '_self';
			}

			$a 			= $( 'div#header-featured-image .wrapper a' );

			//check if enable featured header image is set to disabled
			if ( 'disabled' != enable_featured_header_image ) {
				//check the link is not null
				if ( '' != to ) {
					//add http:// to link if not provided
					if ( !/^http:\/\//.test( to ) ) {
			            to = "http://" + to;
			        }
					//check if link tag for header featured image exists
					if ( 0 != $a.length ) {
						$a.attr( 'href', to );
					} else {
						$img 	= '<img class="wp-post-image" alt="' + featured_header_image_alt_text + '" src="' + header_image + '" />';
						$a_tag 	= '<a href="' + to + '" title="' + featured_header_image_alt_text + '" target="' + target + '">' + $img + '</a>';
						$( 'div#header-featured-image .wrapper' ).html( $a_tag );
					}
				}
				else {
					$a.replaceWith( function() { return this.innerHTML; } );
				}
			}
		} );
	} );

	//Header image link target
	wp.customize( 'catchbase_theme_options[featured_header_image_base]', function( value ) {
		value.bind( function( to ) {
			var enable_featured_header_image 	= wp.customize( 'catchbase_theme_options[enable_featured_header_image]' ).get();
			$a 									= $( 'div#header-featured-image .wrapper a' );

			//check if link tag for header featured image exists
			if ( 0 != $a.length ) {
				//check if enable featured header image is set to disabled
				if ( 'disabled' != enable_featured_header_image ) {
					if ( true === to ) {
						$a.attr( 'target', '_blank' );
					}
					else {
						$a.attr( 'target', '_self' );
					}
				}
			}
		} );
	} );

	//Breadcrumb seperator
	wp.customize( 'catchbase_theme_options[breadcumb_seperator]', function( value ) {
		value.bind( function( to ) {
			$( 'div#breadcrumb-list .wrapper .breadcrumb a span.sep' ).html( to );
		} );
	} );

	//This function adds promotion section HTML
	function catchbase_insert_promotion_section() {
		//html elements
		var $promotion_section	= $( 'div#promotion-message' );
		var $section_left 		= $( 'div#promotion-message .wrapper .section.left' );
		var $section_right 		= $( 'div#promotion-message .wrapper .section.right' );

		var $section_promotion_subheadline	= $( 'div#promotion-message .wrapper .section.left p' );

		//values
		var promotion_headline 			= wp.customize( 'catchbase_theme_options[promotion_headline]' ).get();
		var promotion_headline_url 		= wp.customize( 'catchbase_theme_options[promotion_headline_url]' ).get();
		var promotion_headline_button 	= wp.customize( 'catchbase_theme_options[promotion_headline_button]' ).get();
		var promotion_headline_target 	= wp.customize( 'catchbase_theme_options[promotion_headline_target]' ).get();
		var promotion_subheadline 		= wp.customize( 'catchbase_theme_options[promotion_subheadline]' ).get();

		if ( 0 != $promotion_section ) {
			$promotion_section.remove();
		}

		if ( '' != promotion_subheadline || '' != promotion_headline || '' != promotion_headline_url ) {

			$promotion_content 	= '';
			$promotion_content += '<div id="promotion-message">';
			$promotion_content += '<div class="wrapper">';
			$promotion_content += '<div class="section left">';

				if ( "" != promotion_headline ) {
					$promotion_content += '<h2>' + promotion_headline + '</h2>';
				}

				if ( "" != promotion_subheadline ) {
					$promotion_content += '<p>' + promotion_subheadline + '</p>';
				}

				$promotion_content += '</div><!-- .section.left -->';

				if ( "" != promotion_headline_url ) {
					if ( true == promotion_headline_target ) {
						headlinetarget = '_blank';
					}
					else {
						headlinetarget = '_self';
					}

					$promotion_content += '<div class="section right">';
					$promotion_content += '<a href="' + promotion_headline_url + '"target="' + headlinetarget + '">' + promotion_headline_button + '</a>'
					$promotion_content += '</div><!-- .section.right -->';
				}

		$promotion_content += '</div><!-- .wrapper -->';
		$promotion_content += '</div><!-- #promotion-message -->';

		//Insert promotion section before div#content
		$( $promotion_content ).insertBefore( '#content' );
		}
	}

	//Promotion Headline
	wp.customize( 'catchbase_theme_options[promotion_headline]', function( value ) {
		value.bind( function( to ) {
			catchbase_insert_promotion_section();
		} );
	} );

	//Promotion Subheadline
	wp.customize( 'catchbase_theme_options[promotion_subheadline]', function( value ) {
		value.bind( function( to ) {
			catchbase_insert_promotion_section();
		} );
	} );

	//Promotion Headline Button
	wp.customize( 'catchbase_theme_options[promotion_headline_button]', function( value ) {
		value.bind( function( to ) {
			catchbase_insert_promotion_section();
		} );
	} );

	//Promotion Headline Button Url
	wp.customize( 'catchbase_theme_options[promotion_headline_url]', function( value ) {
		value.bind( function( to ) {
			catchbase_insert_promotion_section();
		} );
	} );

	//Promotion Headline Button Target
	wp.customize( 'catchbase_theme_options[promotion_headline_target]', function( value ) {
		value.bind( function( to ) {
			catchbase_insert_promotion_section();
		} );
	} );

	// Search Option
	wp.customize( 'catchbase_theme_options[search_text]', function( value ) {
		value.bind( function( to ) {
			$( 'input.search-field' ).attr( 'placeholder', to );
		} );
	} );

	// Featured Content Headline
	wp.customize( 'catchbase_theme_options[featured_content_headline]', function( value ) {
		value.bind( function( to ) {
			var $featured_content_wrapper_div 	= $( 'section#featured-content .wrapper .featured-heading-wrap' );
			var $featured_content_headline 		= $( 'section#featured-content .wrapper .featured-heading-wrap h2#featured-heading' );
			var subheadline 					= wp.customize( 'catchbase_theme_options[featured_content_subheadline]' ).get();

			//check if at least headline or subheadline is not empty
			if ( '' != to || '' != subheadline ) {
				//check if featured-content-wrapper exists
				if ( 0 !== $featured_content_wrapper_div.length ) {
					//check if featured-content-headline exists
					if ( 0 !== $featured_content_headline.length ) {
						$( 'section#featured-content .wrapper .featured-heading-wrap h2#featured-heading' ).text( to );
					} else {
						$featured_headline = '<h2 id="featured-heading" class="entry-title">' + to + '</h2>';

						$featured_content_wrapper_div.prepend( $featured_headline );
					}
				} else {
					$div_featured_heading_wrap 	= '';
					$featured_headline 			= '<h2 id="featured-heading" class="entry-title">' + to + '</h2>';
					$div_featured_heading_wrap 	= '<div class="featured-heading-wrap">' + $featured_headline + '</div>';

					$( 'section#featured-content .wrapper' ).prepend( $div_featured_heading_wrap );
				}
			}
			//if both headline and subheadline are empty, remove the featured-heading-wrap div
			else if ( '' === to && '' === subheadline ) {
				$featured_content_wrapper_div.remove();
			}
			//if only headline is empty, remove headline h2
			else {
				$featured_content_headline.remove();
			}
		} );
	} );

	// Featured Content Subheadline
	wp.customize( 'catchbase_theme_options[featured_content_subheadline]', function( value ) {
		value.bind( function( to ) {
			var $featured_content_wrapper_div 	= $( 'section#featured-content .wrapper .featured-heading-wrap' );
			var $featured_content_headline 		= $( 'section#featured-content .wrapper .featured-heading-wrap h2#featured-heading' );
			var $featured_content_subheadline 	= $( 'section#featured-content .wrapper .featured-heading-wrap p' );

			var headline 	= wp.customize( 'catchbase_theme_options[featured_content_headline]' ).get();

			//check if at least headline or subheadline is not empty
			if ( '' != to || '' != headline ) {
				//check if featured-content-wrapper exists
				if ( 0 != $featured_content_wrapper_div.length ) {
					//check if featured-content-subheadline exists
					if ( 0 != $featured_content_subheadline.length ) {
						$( 'section#featured-content .wrapper .featured-heading-wrap p' ).text( to );
					} else {
						$featured_subheadline = '<p>' + to + '</p>';

						$featured_content_wrapper_div.append( $featured_subheadline );
					}
				} else {
					$div_featured_heading_wrap 	= '';
					$featured_subheadline 		= '<p>' + to + '</p>';
					$div_featured_heading_wrap 	= '<div class="featured-heading-wrap">' + $featured_subheadline + '</div>';

					$( 'section#featured-content .wrapper' ).prepend( $div_featured_heading_wrap );
				}
			}
			//if both headline and subheadline are empty, remove the featured-heading-wrap div
			else if ( '' === to && '' === headline ) {
				$featured_content_wrapper_div.remove();
			}
			//if only subheadline is empty, remove subheadline p
			else {
				$featured_content_subheadline.remove();
			}
		} );
	} );



} )( jQuery );

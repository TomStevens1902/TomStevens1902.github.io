<?php
/**
 * The default template for displaying header
 *
 * @package Catch Themes
 * @subpackage Catch Base
 * @since Catch Base 1.0
 */

	/**
	 * catchbase_doctype hook
	 *
	 * @hooked catchbase_doctype -  10
	 *
	 */
	do_action( 'catchbase_doctype' );?>

<head>
<?php
	/**
	 * catchbase_before_wp_head hook
	 *
	 * @hooked catchbase_head -  10
	 *
	 */
	do_action( 'catchbase_before_wp_head' );

	wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php do_action( 'wp_body_open' );  ?>

<?php
	/**
     * catchbase_before_header hook
     *
     */
    do_action( 'catchbase_before' );

	/**
	 * catchbase_header hook
	 *
	 * @hooked catchbase_page_start -  10
	 * @hooked catchbase_header_start- 20
	 * @hooked catchbase_mobile_header_nav_anchor - 30
	 * @hooked catchbase_mobile_secondary_nav_anchor - 40
	 * @hooked catchbase_site_branding - 50
	 * @hooked catchbase_header_right - 60
	 * @hooked catchbase_header_end - 100
	 *
	 */
	do_action( 'catchbase_header' );

	/**
     * catchbase_after_header hook
     *
     * @hooked catchbase_primary_menu - 20
     * @hooked catchbase_secondary_menu - 30
	 * @hooked catchbase_featured_overall_image - 40
     * @hooked catchbase_add_breadcrumb - 50
     */
	do_action( 'catchbase_after_header' );

	/**
	 * catchbase_before_content hook
	 *
	 * @hooked catchbase_slider - 10
	 * @hooked catchbase_promotion_headline - 30
	 * @hooked catchbase_featured_content_display (move featured content above homepage posts - default option) - 40
	 */
	do_action( 'catchbase_before_content' );

	/**
     * catchbase_content hook
     *
     *  @hooked catchbase_content_start - 10
     *  @hooked catchbase_add_breadcrumb - 20
     *  @hooked catchbase_sidebar_secondary (three-columns-secondary-sidebar-first) - 30
     *  @hooked catchbase_content_sidebar_wrap_start - 40
     *
     */
	do_action( 'catchbase_content' );
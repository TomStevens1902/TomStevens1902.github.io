<?php
/**
 * The Sidebar containing the primary widget area
 *
 * @package Catch Themes
 * @subpackage Catch Base
 * @since Catch Base 1.0
 */


/**
 * catchbase_before_secondary hook
 */
do_action( 'catchbase_before_secondary' );

$catchbase_layout = catchbase_get_theme_layout();

//Bail early if no sidebar layout is selected
if ( 'no-sidebar' == $catchbase_layout || 'no-sidebar-one-column' == $catchbase_layout || 'no-sidebar-full-width' == $catchbase_layout ) {
	return;
}

do_action( 'catchbase_before_primary_sidebar' );
?>

	<aside class="sidebar sidebar-primary widget-area" role="complementary">
	<?php
	//Primary Sidebar
	if ( is_active_sidebar( 'primary-sidebar' ) ) {
    	dynamic_sidebar( 'primary-sidebar' );
		}
	else {
		//Helper Text
		if ( current_user_can( 'edit_theme_options' ) ) { ?>
			<section id="widget-default-text" class="widget widget_text">
				<div class="widget-wrap">
                	<h4 class="widget-title"><?php _e( 'Primary Sidebar Widget Area', 'catch-base' ); ?></h4>

           			<div class="textwidget">
                   		<p><?php _e( 'This is the Primary Sidebar Widget Area if you are using a two or three column site layout option.', 'catch-base' ); ?></p>
                   		<p><?php printf( __( 'By default it will load Search and Archives widgets as shown below. You can add widget to this area by visiting your <a href="%s">Widgets Panel</a> which will replace default widgets.', 'catch-base' ), esc_url( admin_url( 'widgets.php' ) ) ); ?></p>
                 	</div>
           		</div><!-- .widget-wrap -->
       		</section><!-- #widget-default-text -->
		<?php
		} ?>
		<section class="widget widget_search" id="default-search">
			<div class="widget-wrap">
				<?php get_search_form(); ?>
			</div><!-- .widget-wrap -->
		</section><!-- #default-search -->
		<section class="widget widget_archive" id="default-archives">
			<div class="widget-wrap">
				<h4 class="widget-title"><?php _e( 'Archives', 'catch-base' ); ?></h4>
				<ul>
					<?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
				</ul>
			</div><!-- .widget-wrap -->
		</section><!-- #default-archives -->
		<?php
	} ?>
	</aside><!-- .sidebar sidebar-primary widget-area -->

<?php
/**
 * catchbase_after_primary_sidebar hook
 */
do_action( 'catchbase_after_primary_sidebar' );

/**
 * catchbase_after_secondary hook
 *
 */
do_action( 'catchbase_after_secondary' );

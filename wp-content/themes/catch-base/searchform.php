<?php
/**
 * The template for displaying search forms
 *
 * @package Catch Themes
 * @subpackage Catch Base
 * @since Catch Base 1.0
 */
?>

<?php $options 	= catchbase_get_theme_options(); // Get options ?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label>
		<span class="screen-reader-text"><?php echo esc_html_x( 'Search for:', 'label', 'catch-base' ); ?></span>
		<input type="search" class="search-field" placeholder="<?php echo esc_attr( $options['search_text'] ); ?>" value="<?php the_search_query(); ?>" name="s" title="<?php _ex( 'Search for:', 'label', 'catch-base' ); ?>">
	</label>
	<input type="submit" class="search-submit" value="<?php echo esc_attr_x( 'Search', 'submit button', 'catch-base' ); ?>">
</form>

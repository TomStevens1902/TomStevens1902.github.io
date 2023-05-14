<?php
/**
 * The template for displaying the footer
 *
 * @package Catch Themes
 * @subpackage Catch Base
 * @since Catch Base 1.0 
 */
?>

<?php 
    /** 
     * catchbase_after_content hook
     *
     * @hooked catchbase_content_sidebar_wrap_end - 10
     * @hooked catchbase_sidebar_secondary (three-column) - 20 
     * @hooked catchbase_content_end - 30
     * @hooked catchbase_featured_content_display (move featured content below homepage posts) - 40 
     *
     */
    do_action( 'catchbase_after_content' ); 
?>
            
<?php                
    /** 
     * catchbase_footer hook
     *
     * @hooked catchbase_footer_content_start - 30
     * @hooked catchbase_footer_sidebar - 40
     * @hooked catchbase_get_footer_content - 100
     * @hooked catchbase_footer_content_end - 110
     * @hooked catchbase_page_end - 200
     *
     */
    do_action( 'catchbase_footer' );
?>

<?php               
/** 
 * catchbase_after hook
 *
 * @hooked catchbase_scrollup - 10
 * @hooked catchbase_mobile_menus- 20
 *
 */
do_action( 'catchbase_after' );?>

<?php wp_footer(); ?>

</body>
</html>
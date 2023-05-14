<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package Catch Themes
 * @subpackage Catch Base
 * @since Catch Base 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
	/**
	 * catchbase_before_page_container hook
	 *
	 * @hooked catchbase_single_content_image - 10
	 */
	do_action( 'catchbase_before_page_container' ); ?>
	<div class="entry-container">
		<header class="entry-header">
			<h1 class="entry-title"><?php the_title(); ?></h1>
		</header><!-- .entry-header -->

		<div class="entry-content">
			<?php the_content(); ?>
			<?php
				wp_link_pages( array(
					'before' => '<div class="page-links"><span class="pages">' . __( 'Pages:', 'catch-base' ) . '</span>',
					'after'  => '</div>',
					'link_before' 	=> '<span>',
                    'link_after'   	=> '</span>',
				) );
			?>
		</div><!-- .entry-content -->
		<?php edit_post_link( __( 'Edit', 'catch-base' ), '<footer class="entry-footer"><span class="edit-link">', '</span></footer>' ); ?>
	</div><!-- .entry-container -->
</article><!-- #post-## -->
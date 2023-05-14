<?php
/**
 * The template for displaying custom menus
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


if ( ! function_exists( 'catchbase_primary_menu' ) ) :
/**
 * Shows the Primary Menu
 *
 * default load in sidebar-header-right.php
 */
function catchbase_primary_menu() {
    ?>
	<nav class="site-navigation nav-primary search-enabled" role="navigation">
        <div class="wrapper">
            <h3 class="assistive-text"><?php _e( 'Primary Menu', 'catch-base' ); ?></h3>
            <div class="screen-reader-text skip-link"><a href="#content" title="<?php esc_attr_e( 'Skip to content', 'catch-base' ); ?>"><?php _e( 'Skip to content', 'catch-base' ); ?></a></div>
            <?php
                if ( has_nav_menu( 'primary' ) ) {
                    $catchbase_primary_menu_args = array(
                        'theme_location'    => 'primary',
                        'menu_class'        => 'menu catchbase-nav-menu',
                        'container'         => false
                    );
                    wp_nav_menu( $catchbase_primary_menu_args );
                }
                else {
                    wp_page_menu( array( 'menu_class'  => 'menu catchbase-nav-menu' ) );
                }

                ?>
                <div id="search-toggle" class="genericon">
                    <a class="screen-reader-text" href="#search-container"><?php esc_html_e( 'Search', 'catch-base' ); ?></a>
                </div>

                <div id="search-container" class="displaynone">
                    <?php get_search_form(); ?>
                </div>
    	</div><!-- .wrapper -->
    </nav><!-- .nav-primary -->
    <?php
}
endif; //catchbase_primary_menu
add_action( 'catchbase_after_header', 'catchbase_primary_menu', 20 );


if ( ! function_exists( 'catchbase_secondary_menu' ) ) :
/**
 * Shows the Secondary Menu
 *
 * default load in sidebar-header-right.php
 */
function catchbase_secondary_menu() {
    if ( has_nav_menu( 'secondary' ) ) {
	?>
    	<nav class="site-navigation nav-secondary" role="navigation">
            <div class="wrapper">
                <h3 class="assistive-text"><?php _e( 'Secondary Menu', 'catch-base' ); ?></h3>
                <div class="screen-reader-text skip-link"><a href="#content" title="<?php esc_attr_e( 'Skip to content', 'catch-base' ); ?>"><?php _e( 'Skip to content', 'catch-base' ); ?></a></div>
                <?php
                    $catchbase_secondary_menu_args = array(
                        'theme_location'    => 'secondary',
                        'menu_class' => 'menu catchbase-nav-menu'
                    );
                    wp_nav_menu( $catchbase_secondary_menu_args );
                ?>
        	</div><!-- .wrapper -->
        </nav><!-- .nav-secondary -->

<?php
    }
}
endif; //catchbase_secondary_menu
add_action( 'catchbase_after_header', 'catchbase_secondary_menu', 30 );


if ( ! function_exists( 'catchbase_mobile_menus' ) ) :
/**
 * This function loads Mobile Menus
 *
 * @uses catchbase_after action to add the code in the footer
 */
function catchbase_mobile_menus() {
    //For primary menu, check if primary menu exists, if not, page menu
    echo '<nav id="mobile-header-left-nav" class="mobile-menu" role="navigation">';
        if ( has_nav_menu( 'primary' ) ) {
            $args = array(
                'theme_location'    => 'primary',
                'container'         => false,
                'items_wrap'        => '<ul id="header-left-nav" class="menu">%3$s</ul>'
            );
            wp_nav_menu( $args );
        }
        else {
            wp_page_menu( array( 'menu_class'  => 'menu' ) );
        }
    echo '</nav><!-- #mobile-header-left-nav -->';

    //For Secondary Menu
    if ( has_nav_menu( 'secondary' ) ) {
        echo '<nav id="mobile-header-right-nav" class="mobile-menu" role="navigation">';
            $args = array(
                'theme_location'    => 'secondary',
                'container'         => false,
                'items_wrap'        => '<ul id="header-right-nav" class="menu">%3$s</ul>'
            );
            wp_nav_menu( $args );
        echo '</nav><!-- #mobile-header-right-nav -->';
    }
}
endif; //catchbase_mobile_menus

add_action( 'catchbase_after', 'catchbase_mobile_menus', 20 );


if ( ! function_exists( 'catchbase_mobile_header_nav_anchor' ) ) :
/**
 * This function loads Mobile Menus Left Anchor
 *
 * @uses catchbase_header action to add in the Header
 */
function catchbase_mobile_header_nav_anchor() {

    // Header Left Mobile Menu Anchor
    if ( has_nav_menu( 'primary' ) ) {
        $classes = "mobile-menu-anchor primary-menu";
    }
    else {
        $classes = "mobile-menu-anchor page-menu";
    }
    ?>

    <div id="mobile-header-left-menu" class="<?php echo $classes; ?>">
        <a href="#mobile-header-left-nav" id="header-left-menu" class="genericon genericon-menu">
            <span class="mobile-menu-text"><?php _e( 'Menu', 'catch-base' );?></span>
        </a>
    </div><!-- #mobile-header-menu -->
    <?php
}
endif; //catchbase_mobile_menus
add_action( 'catchbase_header', 'catchbase_mobile_header_nav_anchor', 30 );


if ( ! function_exists( 'catchbase_mobile_secondary_nav_anchor' ) ) :
/**
 * This function loads Mobile Menus Footer Anchor
 * @uses catchbase_header action to add in the Header
 */
function catchbase_mobile_secondary_nav_anchor() {
    if ( has_nav_menu( 'secondary' ) ) {
        ?>
        <div id="mobile-header-right-menu" class="mobile-menu-anchor secondary-menu">
            <a href="#mobile-header-right-menu" id="secondary-menu" class="genericon genericon-menu">
                <span class="mobile-menu-text"><?php _e( 'Menu', 'catch-base' );?></span>
            </a>
        </div><!-- #mobile-header-menu -->
    <?php
    }
}
endif; //catchbase_mobile_secondary_nav_anchor
add_action( 'catchbase_header', 'catchbase_mobile_secondary_nav_anchor', 50 );

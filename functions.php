<?php
/**
 * Genesis Sample.
 *
 * This file adds functions to the Genesis Sample Theme.
 *
 * @package Genesis Sample
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://www.studiopress.com/
 */

// Start the engine.
include_once( get_template_directory() . '/lib/init.php' );

// Setup Theme.
include_once( get_stylesheet_directory() . '/lib/theme-defaults.php' );

// Set Localization (do not remove).
add_action( 'after_setup_theme', 'crad_localization_setup' );
function crad_localization_setup(){
	load_child_theme_textdomain( 'crad', get_stylesheet_directory() . '/languages' );
}

// Add the helper functions.
include_once( get_stylesheet_directory() . '/lib/helper-functions.php' );

// Add Image upload and Color select to WordPress Theme Customizer.
require_once( get_stylesheet_directory() . '/lib/customize.php' );

// Include Customizer CSS.
include_once( get_stylesheet_directory() . '/lib/output.php' );

// Add WooCommerce support.
include_once( get_stylesheet_directory() . '/lib/woocommerce/woocommerce-setup.php' );

// Add the required WooCommerce styles and Customizer CSS.
include_once( get_stylesheet_directory() . '/lib/woocommerce/woocommerce-output.php' );

// Add the Genesis Connect WooCommerce notice.
include_once( get_stylesheet_directory() . '/lib/woocommerce/woocommerce-notice.php' );

// Child theme (do not remove).
define( 'CHILD_THEME_NAME', 'C-RAD' );
define( 'CHILD_THEME_URL', 'http://www.studiopress.com/' );
define( 'CHILD_THEME_VERSION', '2.3.0' );

// Enqueue Scripts and Styles.
add_action( 'wp_enqueue_scripts', 'crad_enqueue_scripts_styles' );
function crad_enqueue_scripts_styles() {

	wp_enqueue_style( 'crad-fonts', '//fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,700', array(), CHILD_THEME_VERSION );
	wp_enqueue_style( 'dashicons' );

	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
	wp_enqueue_script( 'crad-responsive-menu', get_stylesheet_directory_uri() . "/js/responsive-menus{$suffix}.js", array( 'jquery' ), CHILD_THEME_VERSION, true );
	wp_localize_script(
		'crad-responsive-menu',
		'genesis_responsive_menu',
		crad_responsive_menu_settings()
	);

}

// Define our responsive menu settings.
function crad_responsive_menu_settings() {

	$settings = array(
		'mainMenu'          => __( 'Menu', 'crad' ),
		'menuIconClass'     => 'dashicons-before dashicons-menu',
		'subMenu'           => __( 'Submenu', 'crad' ),
		'subMenuIconsClass' => 'dashicons-before dashicons-arrow-down-alt2',
		'menuClasses'       => array(
			'combine' => array(
				'.nav-primary',
				'.nav-header',
			),
			'others'  => array(),
		),
	);

	return $settings;

}

// Add HTML5 markup structure.
add_theme_support( 'html5', array( 'caption', 'comment-form', 'comment-list', 'gallery', 'search-form' ) );

// Add Accessibility support.
add_theme_support( 'genesis-accessibility', array( '404-page', 'drop-down-menu', 'headings', 'rems', 'search-form', 'skip-links' ) );

// Add viewport meta tag for mobile browsers.
add_theme_support( 'genesis-responsive-viewport' );

// Add support for custom header.
add_theme_support( 'custom-header', array(
	'width'           => 1049,
	'height'          => 240,
	'header-selector' => '.site-title a',
	'header-text'     => false,
	'flex-height'     => true,
) );

// Add Google site verification custom meta tag
add_action( 'genesis_meta', 'crad_google_site_verification');
function crad_google_site_verification() {
	echo '<meta name="google-site-verification" content="KC4TaDXzdyjXtpjZQnzA3FM0itcB2p4l1Zpx30MIwZo">' . "\n";
}

// Add support for custom background.
add_theme_support( 'custom-background' );

// Add support for after entry widget.
add_theme_support( 'genesis-after-entry-widget-area' );

// Add support for 3-column footer widgets.
add_theme_support( 'genesis-footer-widgets', 1 );

// Add Image Sizes.
add_image_size( 'featured-image', 720, 400, TRUE );

// Rename primary and secondary navigation menus.
add_theme_support( 'genesis-menus', array( 'primary' => __( 'After Header Menu', 'crad' ), 'secondary' => __( 'Footer Menu', 'crad' ) ) );

// Reposition the secondary navigation menu.
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_footer', 'genesis_do_subnav', 5 );

// Reduce the secondary navigation menu to one level depth.
add_filter( 'wp_nav_menu_args', 'crad_secondary_menu_args' );
function crad_secondary_menu_args( $args ) {

	if ( 'secondary' != $args['theme_location'] ) {
		return $args;
	}

	$args['depth'] = 1;

	return $args;

}

// Modify size of the Gravatar in the author box.
add_filter( 'genesis_author_box_gravatar_size', 'crad_author_box_gravatar' );
function crad_author_box_gravatar( $size ) {
	return 90;
}

// Modify size of the Gravatar in the entry comments.
add_filter( 'genesis_comment_list_args', 'crad_comments_gravatar' );
function crad_comments_gravatar( $args ) {

	$args['avatar_size'] = 60;

	return $args;

}

// Remove the edit link
add_filter ( 'genesis_edit_post_link' , '__return_false' );

// Register widget areas
genesis_register_sidebar( array(
	'id'				=> 'members-sidebar',
	'name'			=> __( 'Members Sidebar', 'crad' ),
	'description'	=> __( 'This is the Members sidebar.', 'crad' ),
) );

genesis_register_sidebar( array(
	'id'				=> 'manager-sidebar',
	'name'			=> __( 'Manager Sidebar', 'crad' ),
	'description'	=> __( 'This is the manager sidebar of the members section.', 'crad' ),
) );

// Add our custom sponsor loop
add_action( 'genesis_before_footer', 'crad_sponsor_loop', 5 );
function crad_sponsor_loop() {
	$args = array(
		'post_type' => 'sponsor', 
	);
	$loop = new WP_Query( $args );
	if( $loop->have_posts() ) {
		echo '<div class="sponsor-list"><div class="wrap"><h3>Sponsors</h3>';
		// loop through posts
		while( $loop->have_posts() ): $loop->the_post();

		$sponsor_name = esc_attr( get_the_title() );
		$sponsor_url = esc_attr( get_field( 'sponsor_url' ) );
		$sponsor_logo = esc_attr( get_field( 'sponsor_logo' ) );
		echo '
			<div class="sponsor">
				<a href="' . $sponsor_url . '">
					<img src="' . $sponsor_logo . '" alt="' . $sponsor_name . '">
				</a>
			</div>
		';
		endwhile;
		echo '</div></div>';
	}
	wp_reset_postdata();
}

// Custom footer
remove_action( 'genesis_before_footer', 'genesis_footer_widget_areas' );
remove_action( 'genesis_footer', 'genesis_do_footer' );
add_action( 'genesis_footer', 'crad_custom_footer' );
function crad_custom_footer() {
	include_once( get_stylesheet_directory() . '/lib/custom-footer.php' );
}
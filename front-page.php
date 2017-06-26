<?php
/**
 * C-RAD.
 *
 * This file adds the front page template to the C-RAD theme.
 *
 */

// Function to initiate widgetized page render.
	add_action( 'genesis_meta', 'crad_front_page_init' );
	function crad_front_page_init() {

	// Add front-page body class.
	add_filter( 'body_class', 'crad_body_class' );

	// Force full width.
	add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

	// Add the scripts and styles.
	add_action( 'wp_enqueue_scripts', 'crad_home_scripts_and_styles' );

	// Replace the default loop with the frontpage content.
	remove_action( 'genesis_loop', 'genesis_do_loop' );
	add_action( 'genesis_loop', 'crad_front_page_content' );

	// Remove .site-inner
	add_filter( 'genesis_markup_site-inner', '__return_null' );
	add_filter( 'genesis_markup_content-sidebar-wrap_output', '__return_false' );
	add_filter( 'genesis_markup_content', '__return_null' );


}

// Front page body class.
function crad_body_class( $classes ) {

	$classes[] = 'front-page';

	return $classes;

}

// Define front page scripts.
function crad_home_scripts_and_styles() {
	wp_enqueue_script( 'crad-slick', get_stylesheet_directory_uri() . '/js/slick.min.js', array( 'jquery' ), CHILD_THEME_VERSION, true );
	wp_enqueue_script( 'crad-home', get_stylesheet_directory_uri() . '/js/home.js', array( 'jquery', 'crad-slick' ), CHILD_THEME_VERSION, true );
}

// Front page content
function crad_front_page_content() {
	?>
<section id="front-page-1" class="front-page-1">
	<div class="slider-container">
		<div class="front-page-slider">
			<div class="slide-1"></div>
			<div class="slide-2"></div>
			<div class="slide-3"></div>
			<div class="slide-4"></div>
			<div class="slide-5"></div>
			<div class="slide-6"></div>
		</div>
	</div>
	<div class="mission">
		<div class="wrap"><p>The mission of Colorado Rapid Avalanche Deployment is to cultivate, inspire, and produce dog teams for successful avalanche search and rescue.</p></div>
	</div>
</section>
<section id="front-page-2" class="front-page-2">
	<div class="wrap">
		<h2>A Relationship That Works</h2>
		<img src="/wp-content/uploads/2017/06/DSC_1048-720x400.jpg" alt="A Relationship That Works">
		<p>The Avalanche Deployment Program combines the skill, expertise, and stamina of SAR and avalanche teams, with the Flight For Life® Colorado helicopter and crew, who expedite the rescue of an injured or ill party and evacuate them to appropriate medical care.</p>
		<p>Summit County is one of several counties who participate in this program in which members dedicate numerous personal hours to be ready at a moment’s notice to help others in need.</p>
		<div class="org-list">
			<div class="org"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/orgs/ffl.png" alt="Flight For Life"></div>
			<div class="org"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/orgs/scrg.png" alt="Summit County Rescue Group"></div>
			<div class="org"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/orgs/scs.png" alt="Summit County Sherrif"></div>
		</div>
	</div>
</section>
<section id="front-page-3" class="front-page-3">
	<div class="wrap">
		<h2>The Team Players and Their Role in Avalanche Deployment</h2>
		<p>A C-RAD team includes a dog handler, an avalanche technician, and an avalanche dog – the heart and soul of the program – who work daily to stay sharp and excel in the snow.</p>
		<div class="card one-third first">
			<h3>Level II Validated Snow Tech</h3>
			<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/tech.jpg" alt="Level II Validated Snow Tech">
			<p>The most senior techs participating in the program. They determine snow conditions, scene safety, and perform a survey of the terrain from the air.</p>
		</div>
		<div class="card one-third">
			<h3>Avalanche Dog</h3>
			<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/dog.jpg" alt="Avalanche Dog">
			<p>Validated in avalanche recovery - the heart of the program - dog duties include finding the victim and keeping everyone smiling.</p>
		</div>
		<div class="card one-third">
			<h3>Validated Avalanche Dog Handler</h3>
			<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/handler.jpg" alt="Validated Avalanche Dog Handler">
			<p>Handler duties include management and handling of avalanche dog in flight and on scene.</p>
		</div>
	</div>
</section>
	<?php
}

genesis();

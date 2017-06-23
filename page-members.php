<?php
/**
 * C-RAD
 *
 * This file adds the member page template to the C-RAD Theme.
 *
 * Template Name: Members
 *
 */

// Add member page body class to the head.
add_filter( 'body_class', 'crad_add_body_class' );
function crad_add_body_class( $classes ) {

	$classes[] = 'members';

	return $classes;

}

// Force sidebar-content layout
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_content_sidebar' );

// Remove our custom sponsor loop
remove_action( 'genesis_before_footer', 'crad_sponsor_loop', 5 );


// Display login form to non logged in users  
if ( ! is_user_logged_in()) {

	remove_action( 'genesis_loop', 'genesis_do_loop' );
	add_action( 'genesis_loop', 'crad_add_login_form' );

	function crad_add_login_form() {
		wp_login_form();
		return;
	}

} else {

	// Replace the primary sidebar with the members sidebar

	// Add user meta above sidebar
	add_action( 'genesis_before_sidebar_widget_area', 'crad_add_member_meta' );
	function crad_add_member_meta() {
		$current_user = wp_get_current_user();
		if ( !($current_user instanceof WP_User) )
		return;
		?>

		<p>You are logged in as <?php echo $current_user->user_firstname . ' ' . $current_user->user_lastname ?></p>
		<p><a href="<?php echo wp_logout_url('/members'); ?>">Logout</a></p>

		<?php
	}
	// Create member sidebar widget
	function crad_add_member_sidebar() {
		genesis_widget_area ('members-sidebar', array(
			'before' => '<div class="pagewidget"><div class="members-sidebar">',
			'after' => '</div></div>',
			) );
	}
	// Remove primary sidebar and replace it with member sidebar
	remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );
	add_action( 'genesis_sidebar', 'crad_add_member_sidebar' );

	add_action( 'genesis_entry_header', 'crad_add_custom_member_content' );
	function crad_add_custom_member_content() {
	// Add members post loop after content loop
		if (is_page( $page = '11' )) {
			add_action( 'genesis_after_loop', 'crad_member_home_page_content' );
			function crad_member_home_page_content() {
				?>
				<h2>News</h2>
				<?php
				global $paged; // current paginated page
				global $query_args; // grab the current wp_query() args
				$args = array(
						'cat'   => 4,
						'paged' => $paged, // respect pagination
				);
				genesis_custom_loop( wp_parse_args($query_args, $args) );
			}

		} else if (is_page( $page = '21' )) {
			add_action( 'genesis_after_loop', 'crad_member_downloads_page_loop' );
			function crad_member_downloads_page_loop() {


		$args = array(
			'post_type' => 'download',

		);
		$loop = new WP_Query( $args );
		if( $loop->have_posts() ) {
			?>
				<article class="entry"><ul class="download-list">
			<?php
			// loop through posts
			while( $loop->have_posts() ): $loop->the_post();
			$download_name = esc_attr( get_the_title() );
			$download_description = esc_attr( get_the_content() );
			$download_file = esc_attr( get_field( 'file' ) );
			$download_updated = esc_attr( get_field( 'updated' ) );
			$format_in = 'Ymd';
			$format_out = 'd-m-Y';
			$date = DateTime::createFromFormat($format_in, get_field('updated'));
			echo '
				<li>
					<a href="' . $download_file . '">' . $download_name . '</a><br>
					<small>Updated: ' . $date->format( $format_out ) . '<br>
					' . $download_description . '</small>

				</li>
			';
			endwhile;
			echo '</ul></article>';
		}
		wp_reset_postdata();




			}
		}
	}

}

// Run the Genesis loop.
genesis();

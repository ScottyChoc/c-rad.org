<?php
/**
* C-RAD
*
* This file adds the single post template to the C-RAD theme
*
*/

add_action( 'genesis_entry_header', 'crad_say_hello', 15 );

function crad_say_hello() {
	if ( has_post_thumbnail() ) {
		the_post_thumbnail();
	}
}

genesis();
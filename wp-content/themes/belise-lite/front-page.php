<?php
/**
 * The front page template file.
 *
 * If the user has selected a static page for their homepage, this is what will
 * appear.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Belise
 * @since Belise 1.0
 */
get_header();

do_action( 'belise_front_page_content' );

belise_front_page_events();

get_footer();

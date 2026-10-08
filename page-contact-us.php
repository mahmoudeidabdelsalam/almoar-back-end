<?php
/**
 * Template Name: Contact Us
 * Template Post Type: page
 *
 * Contact pages are rendered by the headless Next.js frontend.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
the_post();
the_content();
get_footer();
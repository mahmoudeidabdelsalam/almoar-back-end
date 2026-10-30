<?php
/**
 * Template Name: About Us
 * Template Post Type: page
 *
 * WordPress stores the page; the public experience is rendered by Next.js.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
the_post();
the_content();
get_footer();
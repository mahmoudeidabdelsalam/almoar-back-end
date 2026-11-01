<?php
/**
 * WP Headless — functions.php
 *
 * Backend-only theme. Alomar content fields and content-type registration
 * are theme-managed; the core plugin supplies the remaining business logic.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Theme-owned ACF configuration. */
require_once get_theme_file_path( '/inc/post-types.php' );
require_once get_theme_file_path( '/inc/taxonomies.php' );
require_once get_theme_file_path( '/inc/graphql.php' );
require_once get_theme_file_path( '/inc/graphql-site-content.php' );
require_once get_theme_file_path( '/inc/graphql-invest-with-us.php' );
require_once get_theme_file_path( '/inc/graphql-investments.php' );
require_once get_theme_file_path( '/inc/acf.php' );

/**
 * Enable featured images for posts and pages.
 */
add_action( 'after_setup_theme', function () {
	add_theme_support( 'post-thumbnails', array( 'post', 'page', 'projects', 'news' ) );
} );

/**
 * Warn in wp-admin if required plugins are missing, instead of failing
 * silently (no fields, no GraphQL type, no error message anywhere).
 */
add_action( 'admin_notices', function () {
	$missing = array();

	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		$missing[] = 'Advanced Custom Fields (Pro)';
	}
	if ( ! function_exists( 'register_graphql_field' ) && ! class_exists( 'WPGraphQL' ) ) {
		$missing[] = 'WPGraphQL';
	}
	if ( ! class_exists( 'WPGraphQL_ACF' ) && ! function_exists( 'wpgraphql_acf_init' ) ) {
		// Best-effort check only — plugin class/function names vary by version.
		$missing[] = 'WPGraphQL for ACF (verify manually if this warning is a false positive)';
	}
	if ( ! class_exists( 'Alomar_REST_API' ) ) {
		$missing[] = 'Alomar Holding Core contact integration';
	}

	if ( ! empty( $missing ) ) {
		printf(
			'<div class="notice notice-warning"><p><strong>WP Headless:</strong> missing required plugin(s): %s.</p></div>',
			esc_html( implode( ', ', $missing ) )
		);
	}
} );

/**
 * This theme serves no frontend templates. Public WordPress-rendered pages
 * must not compete with the headless frontend in search results.
 * If configured, redirect public visitors to the React frontend.
 *
 * Set REACT_FRONTEND_URL to the deployed React app's URL to enable redirects.
 */
add_action( 'template_redirect', function () {
	if ( is_admin() ) {
		return;
	}

	header( 'X-Robots-Tag: noindex, follow', true );

	$frontend_url = defined( 'REACT_FRONTEND_URL' ) ? REACT_FRONTEND_URL : '';

	if ( $frontend_url ) {
		wp_redirect( $frontend_url, 302 );
		exit;
	}
} );

/**
 * Keep the WordPress backend hostname out of search results. The frontend
 * owns public indexing and publishes its own canonical sitemap.
 */
add_filter( 'robots_txt', function ( $output ) {
	$output = preg_replace( '/^Sitemap:.*(?:\R|$)/mi', '', $output );
	$output = rtrim( $output );

	return $output . "\nUser-agent: *\nDisallow: /wp-admin/\nAllow: /wp-admin/admin-ajax.php\n";
}, 100000 );

/**
 * Allow the React frontend's origin to call WPGraphQL directly from
 * the browser if needed (e.g. for previews). If GraphQL requests are
 * always made server-side, this is not required.
 *
 * ASSUMPTION: set REACT_FRONTEND_URL as above.
 */
add_action( 'graphql_response_headers_to_send', function ( $headers ) {
	$frontend_url = defined( 'REACT_FRONTEND_URL' ) ? REACT_FRONTEND_URL : '';

	if ( $frontend_url ) {
		$headers['Access-Control-Allow-Origin']      = $frontend_url;
		$headers['Access-Control-Allow-Credentials'] = 'true';
	}

	return $headers;
} );

/**
 * Trim unused frontend weight since no theme templates are rendered.
 */
add_action( 'init', function () {
	remove_action( 'wp_head', 'wp_generator' );
	remove_action( 'wp_head', 'wlwmanifest_link' );
	remove_action( 'wp_head', 'rsd_link' );
} );

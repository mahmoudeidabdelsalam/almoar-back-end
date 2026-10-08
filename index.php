<?php
/**
 * Minimal fallback template. This theme is backend-only — normal
 * visitors are redirected to the React frontend in functions.php
 * (`template_redirect`). This file exists only because WordPress
 * requires index.php for a theme to be considered valid/activatable.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="robots" content="noindex, nofollow">
	<title><?php bloginfo( 'name' ); ?></title>
	<?php wp_head(); ?>
</head>
<body>
	<p>This site is a headless WordPress backend. Content is served via the WPGraphQL API.</p>
	<?php wp_footer(); ?>
</body>
</html>


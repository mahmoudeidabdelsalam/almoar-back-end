<?php
/**
 * Loads theme-owned ACF configuration.
 *
 * Registration is intentionally guarded. The plugin is kept active for CPTs,
 * REST/GraphQL/business logic but must no longer register the same field groups.
 */
defined('ABSPATH') || exit;

if (!function_exists('acf_add_local_field_group')) {
    return;
}

require_once __DIR__ . '/acf/alomar-acf-content.php';
require_once __DIR__ . '/acf/alomar-site-content.php';
require_once __DIR__ . '/acf/alomar-content-model.php';

// Recovered Git-baseline field groups remain registered for backward compatibility.
// They are legacy definitions only; all new Alomar registrations use unique keys.
require_once __DIR__ . '/acf/acf-fields.php';
require_once __DIR__ . '/acf/acf-header.php';
require_once __DIR__ . '/acf/acf-footer.php';
require_once __DIR__ . '/acf/acf-contact.php';
require_once __DIR__ . '/acf/acf-invest-with-us.php';

Alomar_Theme_ACF_Content::init();
Alomar_Theme_Site_Content::init();
Alomar_Theme_Content_Model::init();

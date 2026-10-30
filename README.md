# Alomar Headless Theme

Headless WordPress theme for the Alomar Holding CMS. It exposes structured content through WordPress, ACF, and WPGraphQL to the Next.js frontend. WordPress remains the editorial/admin backend; the frontend is rendered by the separate application.

## Requirements

Before using this theme, install and activate the following in WordPress:

- WordPress
- Advanced Custom Fields Pro
- WPGraphQL
- WPGraphQL for ACF

This theme expects the headless setup to be used with the separate `almoar-front-end` application.

## Installation

1. Copy this theme folder to your WordPress installation:
   - `wp-content/themes/theme-headless`
2. Activate the theme in WordPress admin:
   - Appearance > Themes > Alomar Headless
3. Install and activate the required plugins listed above.
4. Set the frontend URL in `wp-config.php` if you want WordPress to redirect non-admin visitors to the React app:

```php
define( 'REACT_FRONTEND_URL', 'https://your-frontend-url.com' );
```

5. Make sure the theme-owned ACF field groups are loading correctly from `inc/acf/`.

## How it works

This theme primarily serves the headless frontend. It:

- registers Alomar custom post types, taxonomies, and ACF field groups
- exposes theme-owned content fields to WPGraphQL
- preserves the active Alomar core plugin for existing GraphQL/business logic
- redirects non-admin frontend traffic to the React app
- keeps WordPress as the content source and admin backend only

The main logic lives in:

- `functions.php`
- `inc/post-types.php`
- `inc/taxonomies.php`
- `inc/graphql.php`
- `inc/graphql-site-content.php`
- `inc/graphql-invest-with-us.php`
- `inc/acf/`

## Local development workflow

1. Start your WordPress environment and make sure the theme is active.
2. Configure the React frontend URL in `wp-config.php`.
3. Use WPGraphQL to fetch content for the frontend app.
4. Update ACF fields in `inc/acf/` when the theme-owned content structures change.
5. Refresh WordPress admin after field changes and validate the GraphQL schema.

## Notes

- `page-about-us.php` and `page-contact-us.php` are available for direct WordPress rendering; the public site is still served by the frontend. The Invest With Us field group is located by matching the existing page slug or title.
- The theme removes the matching CPT/taxonomy registration hooks from the active core plugin before registering its equivalents. Keep the plugin active for its other integrations.
- The contact GraphQL mutation is initialized from the existing core plugin class. It has been schema-validated locally, but a real submission has not been tested.
- If the frontend is handled by a reverse proxy or external hosting layer, you can remove the redirect block from `functions.php` and keep only the ACF/GraphQL setup.
- The theme warns in the admin area if required plugins are missing, which helps catch setup issues early.

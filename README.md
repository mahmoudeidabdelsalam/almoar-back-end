# WP.de_backend

Headless WordPress theme for the WP.de backend. This theme is used as the CMS/admin backend only; it exposes structured content through WordPress + ACF + WPGraphQL to the React frontend instead of rendering frontend templates.

## Requirements

Before using this theme, install and activate the following in WordPress:

- WordPress
- Advanced Custom Fields Pro
- WPGraphQL
- WPGraphQL for ACF

This theme expects the headless setup to be used with a separate React frontend.

## Installation

1. Copy this theme folder to your WordPress installation:
   - `wp-content/themes/WP-headless`
2. Activate the theme in WordPress admin:
   - Appearance > Themes > WP Headless
3. Install and activate the required plugins listed above.
4. Set the frontend URL in `wp-config.php` if you want WordPress to redirect non-admin visitors to the React app:

```php
define( 'REACT_FRONTEND_URL', 'https://your-frontend-url.com' );
```

5. Make sure the ACF field groups are loading correctly from `inc/acf/`.

## How it works

This theme does not render front-end templates. Instead, it:

- registers ACF field groups for content management
- exposes custom data to WPGraphQL
- redirects non-admin frontend traffic to the React app
- keeps WordPress as the content source and admin backend only

The main logic lives in:

- `functions.php`
- `inc/acf/`

## Local development workflow

1. Start your WordPress environment and make sure the theme is active.
2. Configure the React frontend URL in `wp-config.php`.
3. Use WPGraphQL to fetch content for the frontend app.
4. Update ACF fields in `inc/acf/` when new content types or data structures are needed.
5. Refresh WordPress admin after field changes and validate the GraphQL schema.

## Notes

- This is a backend-only theme, so you should not expect classic WordPress page templates here.
- If the frontend is handled by a reverse proxy or external hosting layer, you can remove the redirect block from `functions.php` and keep only the ACF/GraphQL setup.
- The theme warns in the admin area if required plugins are missing, which helps catch setup issues early.

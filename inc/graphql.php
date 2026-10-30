<?php
defined('ABSPATH') || exit;

$contact_api_file = WP_PLUGIN_DIR . '/alomar-holding-core/includes/class-rest-api.php';
if (is_readable($contact_api_file)) {
    require_once $contact_api_file;
    if (class_exists('Alomar_REST_API')) {
        Alomar_REST_API::init();
    }
}

$core_schema_modules = [
    'Alomar_ACF_Content' => WP_PLUGIN_DIR . '/alomar-holding-core/includes/class-acf-content.php',
    'Alomar_Site_Content' => WP_PLUGIN_DIR . '/alomar-holding-core/includes/class-site-content.php',
];
foreach ($core_schema_modules as $class_name => $module_file) {
    if (!class_exists($class_name) && is_readable($module_file)) {
        require_once $module_file;
    }

    if (
        class_exists($class_name)
        && method_exists($class_name, 'init')
        && !has_action('graphql_register_types', [$class_name, 'register_graphql_fields'])
        && !has_action('graphql_register_types', [$class_name, 'register_graphql_schema'])
    ) {
        $class_name::init();
    }
}

add_action('graphql_register_types', static function (): void {
    if (!function_exists('register_graphql_field')) {
        return;
    }

    register_graphql_field('NewsArticle', 'relatedArticles', [
        'type' => ['list_of' => 'NewsArticle'],
        'description' => __('Published articles explicitly related to this article.', 'theme-headless'),
        'resolve' => static function ($post): array {
            if (!function_exists('get_field') || !is_object($post) || empty($post->ID)) {
                return [];
            }

            $related = get_field('related_articles', (int) $post->ID);
            $posts = [];
            foreach (is_array($related) ? $related : [] as $item) {
                $related_id = $item instanceof WP_Post ? (int) $item->ID : (is_numeric($item) ? (int) $item : 0);
                $related_post = $related_id ? get_post($related_id) : null;
                if ($related_post instanceof WP_Post && $related_post->post_type === 'news' && $related_post->post_status === 'publish') {
                    $posts[] = $related_post;
                }
            }

            return $posts;
        },
    ]);

    if (!class_exists('Alomar_ACF_Content')) {
        foreach (['ProjectCategory' => 'project_category', 'ProjectLocation' => 'project_location'] as $graphql_type => $taxonomy) {
            register_graphql_field($graphql_type, 'nameEn', [
                'type' => 'String',
                'resolve' => static function ($term) use ($taxonomy) {
                    $term_id = is_object($term) ? (int) ($term->term_id ?? 0) : 0;
                    if (!$term_id) {
                        return null;
                    }

                    return function_exists('get_field')
                        ? get_field('name_en', $taxonomy . '_' . $term_id)
                        : get_term_meta($term_id, 'name_en', true);
                },
            ]);
        }
    }
});

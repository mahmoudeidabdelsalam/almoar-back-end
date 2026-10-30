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

    register_graphql_object_type('AlomarContactPageContent', [
        'description' => __('Contact page fields from the page assigned the Contact Us template.', 'theme-headless'),
        'fields' => [
            'badgeAr' => ['type' => 'String'],
            'badgeEn' => ['type' => 'String'],
            'titleAr' => ['type' => 'String'],
            'titleEn' => ['type' => 'String'],
            'descriptionAr' => ['type' => 'String'],
            'descriptionEn' => ['type' => 'String'],
            'bannerImage' => ['type' => 'String'],
            'headingAr' => ['type' => 'String'],
            'headingEn' => ['type' => 'String'],
            'email' => ['type' => 'String'],
            'phone' => ['type' => 'String'],
            'website' => ['type' => 'String'],
            'addressAr' => ['type' => 'String'],
            'addressEn' => ['type' => 'String'],
            'workingHoursAr' => ['type' => 'String'],
            'workingHoursEn' => ['type' => 'String'],
            'locationAr' => ['type' => 'String'],
            'locationEn' => ['type' => 'String'],
            'mapLat' => ['type' => 'Float'],
            'mapLng' => ['type' => 'Float'],
            'mapUrl' => ['type' => 'String'],
            'linkedinUrl' => ['type' => 'String'],
            'twitterUrl' => ['type' => 'String'],
            'formTitleAr' => ['type' => 'String'],
            'formTitleEn' => ['type' => 'String'],
        ],
    ]);

    register_graphql_field('RootQuery', 'alomarContactPageContent', [
        'type' => 'AlomarContactPageContent',
        'description' => __('Contact page content managed with ACF.', 'theme-headless'),
        'resolve' => static function (): ?array {
            $pages = get_posts([
                'post_type' => 'page',
                'post_status' => 'publish',
                'numberposts' => 1,
                'meta_key' => '_wp_page_template',
                'meta_value' => 'page-contact-us.php',
            ]);
            if (!$pages || !function_exists('get_field')) {
                return null;
            }

            $page_id = (int) $pages[0]->ID;
            $get = static fn(string $name, mixed $fallback = ''): mixed => get_field($name, $page_id) ?? $fallback;
            $link_url = static function (mixed $link): string {
                if (is_array($link)) {
                    return is_string($link['url'] ?? null) ? $link['url'] : '';
                }
                return is_string($link) ? $link : '';
            };
            $image_url = static function (mixed $image): string {
                if (is_array($image)) {
                    return is_string($image['url'] ?? null) ? $image['url'] : '';
                }
                if (is_numeric($image)) {
                    return wp_get_attachment_url((int) $image) ?: '';
                }
                return is_string($image) ? $image : '';
            };
            $lat = (float) $get('contact_map_lat', 0);
            $lng = (float) $get('contact_map_lng', 0);
            $map_url = $get('contact_map_url');

            return [
                'badgeAr' => $get('contact_badge'),
                'badgeEn' => $get('contact_badge_en'),
                'titleAr' => $get('contact_page_title'),
                'titleEn' => $get('contact_page_title_en'),
                'descriptionAr' => $get('contact_page_description'),
                'descriptionEn' => $get('contact_page_description_en'),
                'bannerImage' => $image_url($get('contact_page_banner_image')),
                'headingAr' => $get('contact_heading'),
                'headingEn' => $get('contact_heading_en'),
                'email' => $get('contact_email'),
                'phone' => $get('contact_phone'),
                'website' => $get('contact_website'),
                'addressAr' => $get('contact_address'),
                'addressEn' => $get('contact_address_en'),
                'workingHoursAr' => $get('contact_hours'),
                'workingHoursEn' => $get('contact_hours_en'),
                'locationAr' => $get('contact_location'),
                'locationEn' => $get('contact_location_en'),
                'mapLat' => $lat,
                'mapLng' => $lng,
                'mapUrl' => $map_url ?: ($lat && $lng ? add_query_arg('q', $lat . ',' . $lng, 'https://maps.google.com/') : ''),
                'linkedinUrl' => $link_url($get('contact_linkedin')),
                'twitterUrl' => $link_url($get('contact_twitter')),
                'formTitleAr' => $get('contact_form_title'),
                'formTitleEn' => $get('contact_form_title_en'),
            ];
        },
    ]);

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
                    $posts[] = new \WPGraphQL\Model\Post($related_post);
                }
            }

            return $posts;
        },
    ]);

    register_graphql_object_type('AlomarNewsStatistic', [
        'fields' => [
            'value' => ['type' => 'String'],
            'valueEn' => ['type' => 'String'],
            'label' => ['type' => 'String'],
            'labelEn' => ['type' => 'String'],
        ],
    ]);

    register_graphql_object_type('AlomarNewsDetails', [
        'fields' => [
            'statistics' => ['type' => ['list_of' => 'AlomarNewsStatistic']],
            'companyName' => ['type' => 'String'],
            'companyNameEn' => ['type' => 'String'],
            'companyDescription' => ['type' => 'String'],
            'companyDescriptionEn' => ['type' => 'String'],
            'companyLogoUrl' => ['type' => 'String'],
            'companyLink' => ['type' => 'String'],
        ],
    ]);

    foreach ([
        'titleEn' => ['type' => 'String', 'field' => 'title_en'],
        'excerptEn' => ['type' => 'String', 'field' => 'excerpt_en'],
        'contentEn' => ['type' => 'String', 'field' => 'content_en'],
        'newsCategoryAr' => ['type' => 'String', 'field' => 'category_ar'],
        'newsCategoryEn' => ['type' => 'String', 'field' => 'category_en'],
        'readTimeAr' => ['type' => 'String', 'field' => 'read_time_ar'],
        'readTimeEn' => ['type' => 'String', 'field' => 'read_time_en'],
    ] as $graphql_name => $definition) {
        register_graphql_field('NewsArticle', $graphql_name, [
            'type' => $definition['type'],
            'resolve' => static function ($post) use ($definition) {
                if (!is_object($post) || empty($post->ID) || !function_exists('get_field')) {
                    return null;
                }
                $value = get_field($definition['field'], (int) $post->ID);
                return is_string($value) && $value !== '' ? $value : null;
            },
        ]);
    }

    register_graphql_field('NewsArticle', 'newsDetails', [
        'type' => 'AlomarNewsDetails',
        'resolve' => static function ($post): ?array {
            if (!is_object($post) || empty($post->ID) || !function_exists('get_field')) {
                return null;
            }

            $post_id = (int) $post->ID;
            $statistics = get_field('news_statistics', $post_id);
            $logo = get_field('company_logo', $post_id);
            if (is_array($logo)) {
                $logo = $logo['url'] ?? null;
            } elseif (is_numeric($logo)) {
                $logo = wp_get_attachment_url((int) $logo);
            }
            $statistics = is_array($statistics) ? array_values(array_filter(array_map(
                static function ($statistic): ?array {
                    if (!is_array($statistic)) {
                        return null;
                    }
                    return [
                        'value' => $statistic['value'] ?? null,
                        'valueEn' => $statistic['value_en'] ?? null,
                        'label' => $statistic['label'] ?? null,
                        'labelEn' => $statistic['label_en'] ?? null,
                    ];
                },
                $statistics
            ))) : [];

            return [
                'statistics' => $statistics,
                'companyName' => get_field('company_name', $post_id) ?: null,
                'companyNameEn' => get_field('company_name_en', $post_id) ?: null,
                'companyDescription' => get_field('company_description', $post_id) ?: null,
                'companyDescriptionEn' => get_field('company_description_en', $post_id) ?: null,
                'companyLogoUrl' => is_string($logo) && $logo !== '' ? $logo : null,
                'companyLink' => get_field('company_link', $post_id) ?: null,
            ];
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

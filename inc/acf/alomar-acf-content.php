<?php
/**
 * Theme-owned Alomar ACF field configuration.
 * Original field keys and names are preserved from alomar-holding-core.
 */
defined('ABSPATH') || exit;

final class Alomar_Theme_ACF_Content {
    private const FIELD_GROUPS = [
        'projects' => [
            'title' => 'Alomar Project Details',
            'fields' => [
                ['name' => 'title_ar', 'label' => 'Title (Arabic)', 'type' => 'text', 'graphql' => 'titleAr', 'legacy' => '_alomar_title_ar'],
                ['name' => 'title_en', 'label' => 'Title (English)', 'type' => 'text', 'graphql' => 'titleEn', 'legacy' => '_alomar_title_en'],
                ['name' => 'excerpt_ar', 'label' => 'Summary (Arabic)', 'type' => 'textarea', 'graphql' => 'excerptAr', 'legacy' => '_alomar_excerpt_ar'],
                ['name' => 'excerpt_en', 'label' => 'Summary (English)', 'type' => 'textarea', 'graphql' => 'excerptEn', 'legacy' => '_alomar_excerpt_en'],
                ['name' => 'content_ar', 'label' => 'Description (Arabic)', 'type' => 'textarea', 'graphql' => 'contentAr', 'legacy' => '_alomar_content_ar'],
                ['name' => 'content_en', 'label' => 'Description (English)', 'type' => 'textarea', 'graphql' => 'contentEn', 'legacy' => '_alomar_content_en'],
                ['name' => 'status_ar', 'label' => 'Status (Arabic)', 'type' => 'text', 'graphql' => 'statusAr', 'legacy' => '_alomar_status'],
                ['name' => 'status_en', 'label' => 'Status (English)', 'type' => 'text', 'graphql' => 'statusEn', 'legacy' => '_alomar_status_en'],
                ['name' => 'location_ar', 'label' => 'Location (Arabic)', 'type' => 'text', 'graphql' => 'locationAr', 'legacy' => '_alomar_location'],
                ['name' => 'location_en', 'label' => 'Location (English)', 'type' => 'text', 'graphql' => 'locationEn'],
                ['name' => 'units_count', 'label' => 'Units', 'type' => 'text', 'graphql' => 'unitsCount', 'legacy' => '_alomar_units'],
                ['name' => 'land_area', 'label' => 'Land Area', 'type' => 'text', 'graphql' => 'landArea', 'legacy' => '_alomar_land_area'],
                ['name' => 'built_area', 'label' => 'Built Area', 'type' => 'text', 'graphql' => 'builtArea', 'legacy' => '_alomar_built_area'],
                ['name' => 'completion_year', 'label' => 'Completion Year', 'type' => 'text', 'graphql' => 'completionYear', 'legacy' => '_alomar_year'],
                ['name' => 'brochure_url', 'label' => 'Brochure URL', 'type' => 'url', 'graphql' => 'brochureUrl', 'legacy' => '_alomar_brochure'],
                ['name' => 'featured', 'label' => 'Featured Project', 'type' => 'true_false', 'graphql' => 'featured', 'graphql_type' => 'Boolean'],
            ],
        ],
        'sectors' => [
            'title' => 'Alomar Sector Details',
            'fields' => [
                ['name' => 'title_en', 'label' => 'Title (English)', 'type' => 'text', 'graphql' => 'titleEn', 'legacy' => '_alomar_title_en'],
                ['name' => 'summary_en', 'label' => 'Summary (English)', 'type' => 'textarea', 'graphql' => 'summaryEn', 'legacy' => '_alomar_summary_en'],
                ['name' => 'content_en', 'label' => 'Description (English)', 'type' => 'wysiwyg', 'graphql' => 'contentEn'],
                ['name' => 'icon', 'label' => 'Icon Name', 'type' => 'text', 'graphql' => 'sectorIcon', 'legacy' => '_alomar_icon'],
            ],
        ],
        'companies' => [
            'title' => 'Alomar Company Details',
            'fields' => [
                ['name' => 'name_en', 'label' => 'Company Name (English)', 'type' => 'text', 'graphql' => 'nameEn', 'legacy' => '_alomar_name_en'],
                ['name' => 'tagline_ar', 'label' => 'Tagline (Arabic)', 'type' => 'text', 'graphql' => 'taglineAr', 'legacy' => '_alomar_tagline_ar'],
                ['name' => 'tagline_en', 'label' => 'Tagline (English)', 'type' => 'text', 'graphql' => 'taglineEn', 'legacy' => '_alomar_tagline_en'],
                ['name' => 'description_en', 'label' => 'Description (English)', 'type' => 'textarea', 'graphql' => 'descriptionEn', 'legacy' => '_alomar_ensc_en'],
                ['name' => 'website', 'label' => 'Website', 'type' => 'url', 'graphql' => 'companyWebsite', 'legacy' => '_alomar_website'],
                ['name' => 'founded_year', 'label' => 'Year Founded', 'type' => 'text', 'graphql' => 'companyYear', 'legacy' => '_alomar_year'],
            ],
        ],
        'board_members' => [
            'title' => 'Alomar Leadership Details',
            'fields' => [
                ['name' => 'name_en', 'label' => 'Name (English)', 'type' => 'text', 'graphql' => 'nameEn', 'legacy' => '_alomar_name_en'],
                ['name' => 'role_ar', 'label' => 'Role (Arabic)', 'type' => 'text', 'graphql' => 'roleAr', 'legacy' => '_alomar_role_ar'],
                ['name' => 'role_en', 'label' => 'Role (English)', 'type' => 'text', 'graphql' => 'roleEn', 'legacy' => '_alomar_role_en'],
                ['name' => 'bio_en', 'label' => 'Biography (English)', 'type' => 'textarea', 'graphql' => 'bioEn', 'legacy' => '_alomar_bio_en'],
                ['name' => 'display_order', 'label' => 'Display Order', 'type' => 'number', 'graphql' => 'displayOrder', 'graphql_type' => 'Int'],
            ],
        ],
        'post' => [
            'title' => 'Alomar News Details',
            'fields' => [
                ['name' => 'title_en', 'label' => 'Title (English)', 'type' => 'text', 'graphql' => 'titleEn'],
                ['name' => 'excerpt_en', 'label' => 'Excerpt (English)', 'type' => 'textarea', 'graphql' => 'excerptEn'],
                ['name' => 'content_en', 'label' => 'Article Content (English)', 'type' => 'wysiwyg', 'graphql' => 'contentEn'],
                ['name' => 'category_ar', 'label' => 'News Category (Arabic)', 'type' => 'text', 'graphql' => 'newsCategoryAr'],
                ['name' => 'category_en', 'label' => 'News Category (English)', 'type' => 'text', 'graphql' => 'newsCategoryEn'],
                ['name' => 'read_time_ar', 'label' => 'Reading Time (Arabic)', 'type' => 'text', 'graphql' => 'readTimeAr'],
                ['name' => 'read_time_en', 'label' => 'Reading Time (English)', 'type' => 'text', 'graphql' => 'readTimeEn'],
            ],
        ],
    ];

    public static function init(): void {
        if (!function_exists('acf_add_local_field_group')) {
            return;
        }
        add_action('acf/init', [self::class, 'register_field_groups']);
        add_action('acf/init', [self::class, 'register_project_entail_fields']);
        add_action('acf/init', [self::class, 'register_taxonomy_fields']);
        add_action('acf/init', [self::class, 'register_options_page']);
    }

    public static function register_options_page(): void {
        if (function_exists('acf_add_options_page')) {
            acf_add_options_page([
                'page_title' => 'Alomar Website Content',
                'menu_title' => 'Home Page',
                'menu_slug' => 'alomar-homepage-content',
                'capability' => 'edit_posts',
                'redirect' => false,
                'position'           => 2,
            ]);
        }

        if (!function_exists('acf_add_local_field_group')) {
            return;
        }

        acf_add_local_field_group([
            'key' => 'group_alomar_homepage',
            'title' => 'Alomar Homepage Hero Slides',
            'show_in_graphql' => false,
            'location' => [[[
                'param' => 'options_page',
                'operator' => '==',
                'value' => 'alomar-homepage-content',
            ]]],
            'fields' => [[
                'key' => 'field_alomar_home_hero_slides',
                'label' => 'Hero Slides',
                'name' => 'home_hero_slides',
                'type' => 'repeater',
                'layout' => 'block',
                'button_label' => 'Add Hero Slide',
                'sub_fields' => [
                    ['key' => 'field_alomar_home_hero_image', 'label' => 'Image', 'name' => 'image', 'type' => 'image', 'return_format' => 'url', 'required' => 1],
                    ['key' => 'field_alomar_home_hero_badge_ar', 'label' => 'Badge (Arabic)', 'name' => 'badge_ar', 'type' => 'text', 'required' => 1],
                    ['key' => 'field_alomar_home_hero_badge_en', 'label' => 'Badge (English)', 'name' => 'badge_en', 'type' => 'text'],
                    ['key' => 'field_alomar_home_hero_title_ar', 'label' => 'Title (Arabic)', 'name' => 'title_ar', 'type' => 'text', 'required' => 1],
                    ['key' => 'field_alomar_home_hero_title_en', 'label' => 'Title (English)', 'name' => 'title_en', 'type' => 'text'],
                    ['key' => 'field_alomar_home_hero_ensc_ar', 'label' => 'Description (Arabic)', 'name' => 'desc_ar', 'type' => 'textarea', 'rows' => 3],
                    ['key' => 'field_alomar_home_hero_ensc_en', 'label' => 'Description (English)', 'name' => 'desc_en', 'type' => 'textarea', 'rows' => 3],
                    ['key' => 'field_alomar_home_hero_primary_link', 'label' => 'Primary Link', 'name' => 'primary_link', 'type' => 'url'],
                    ['key' => 'field_alomar_home_hero_secondary_link', 'label' => 'Secondary Link', 'name' => 'secondary_link', 'type' => 'url'],
                ],
            ]],
        ]);
    }

    public static function register_field_groups(): void {
        if (!function_exists('acf_add_local_field_group')) {
            return;
        }

        foreach (self::FIELD_GROUPS as $post_type => $group) {
            $fields = [];
            foreach ($group['fields'] as $index => $field) {
                $fields[] = [
                    'key' => 'field_alomar_' . $post_type . '_' . $field['name'],
                    'label' => $field['label'],
                    'name' => $field['name'],
                    'type' => $field['type'],
                    'show_in_graphql' => false,
                ];
            }

            acf_add_local_field_group([
                'key' => 'group_alomar_' . $post_type,
                'title' => $group['title'],
                'show_in_graphql' => false,
                'location' => [[[
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => $post_type,
                ]]],
                'order_no' => 0,
                'fields' => $fields,
            ]);
        }
    }

    public static function register_project_entail_fields(): void {
        if (!function_exists('acf_add_local_field_group')) {
            return;
        }

        acf_add_local_field_group([
            'key' => 'group_alomar_project_entail_content',
            'title' => 'Alomar Project Gallery and Highlights',
            'show_in_graphql' => false,
            'location' => [[[
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'projects',
            ]]],
            'fields' => [[
                'key' => 'field_alomar_project_gallery',
                'label' => 'Project Gallery',
                'name' => 'project_gallery',
                'type' => 'gallery',
                'return_format' => 'array',
                'preview_size' => 'medium',
            ], [
                'key' => 'field_alomar_project_highlights',
                'label' => 'Project Highlights',
                'name' => 'project_highlights',
                'type' => 'repeater',
                'layout' => 'table',
                'button_label' => 'Add Highlight',
                'sub_fields' => [
                    ['key' => 'field_alomar_project_highlight_ar', 'label' => 'Highlight (Arabic)', 'name' => 'highlight_ar', 'type' => 'text'],
                    ['key' => 'field_alomar_project_highlight_en', 'label' => 'Highlight (English)', 'name' => 'highlight_en', 'type' => 'text'],
                ],
            ]],
        ]);
    }

    public static function register_taxonomy_fields(): void {
        if (!function_exists('acf_add_local_field_group')) {
            return;
        }

        foreach (['project_category' => 'Category', 'project_location' => 'Location'] as $taxonomy => $label) {
            acf_add_local_field_group([
                'key' => 'group_alomar_' . $taxonomy,
                'title' => 'Alomar Project ' . $label . ' Translation',
                'show_in_graphql' => false,
                'location' => [[[
                    'param' => 'taxonomy',
                    'operator' => '==',
                    'value' => $taxonomy,
                ]]],
                'fields' => [[
                    'key' => 'field_alomar_' . $taxonomy . '_name_en',
                    'label' => $label . ' Name (English)',
                    'name' => 'name_en',
                    'type' => 'text',
                ]],
            ]);
        }
    }
}

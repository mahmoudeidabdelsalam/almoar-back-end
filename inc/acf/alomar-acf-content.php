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
                ['name' => 'featured', 'label' => 'Featured Project', 'type' => 'true_false', 'graphql' => 'featured', 'graphql_type' => 'Boolean'],
                ['name' => 'project_logo', 'label' => 'Project Logo', 'type' => 'image', 'return_format' => 'array'],
                ['name' => 'stats_band_tab', 'label' => 'Stats Band', 'type' => 'tab', 'placement' => 'left'],
                ['name' => 'stats_tag', 'label' => 'Stats Tag (Arabic)', 'type' => 'text'],
                ['name' => 'stats_tag_en', 'label' => 'Stats Tag (English)', 'type' => 'text'],
                ['name' => 'stats_headline', 'label' => 'Stats Headline (Arabic)', 'type' => 'text'],
                ['name' => 'stats_headline_en', 'label' => 'Stats Headline (English)', 'type' => 'text'],
                [
                    'name' => 'stats_items',
                    'label' => 'Statistics',
                    'type' => 'repeater',
                    'layout' => 'block',
                    'button_label' => 'Add Statistic',
                    'sub_fields' => [
                        ['key' => 'field_alomar_projects_stat_head', 'label' => 'Statistic Heading (Arabic)', 'name' => 'stat_head', 'type' => 'text'],
                        ['key' => 'field_alomar_projects_stat_head_en', 'label' => 'Statistic Heading (English)', 'name' => 'stat_head_en', 'type' => 'text'],
                        ['key' => 'field_alomar_projects_stat_text', 'label' => 'Statistic Text (Arabic)', 'name' => 'stat_text', 'type' => 'text'],
                        ['key' => 'field_alomar_projects_stat_text_en', 'label' => 'Statistic Text (English)', 'name' => 'stat_text_en', 'type' => 'text'],
                    ],
                ],
                ['name' => 'make_band_tab', 'label' => 'Make Band', 'type' => 'tab', 'placement' => 'left'],
                ['name' => 'make_tag', 'label' => 'Make Tag (Arabic)', 'type' => 'text'],
                ['name' => 'make_tag_en', 'label' => 'Make Tag (English)', 'type' => 'text'],
                ['name' => 'make_headline', 'label' => 'Make Headline (Arabic)', 'type' => 'text'],
                ['name' => 'make_headline_en', 'label' => 'Make Headline (English)', 'type' => 'text'],
                [
                    'name' => 'make_items',
                    'label' => 'Make Items',
                    'type' => 'repeater',
                    'layout' => 'block',
                    'button_label' => 'Add Make Item',
                    'sub_fields' => [
                        ['key' => 'field_alomar_projects_make_head', 'label' => 'Heading (Arabic)', 'name' => 'make_head', 'type' => 'text'],
                        ['key' => 'field_alomar_projects_make_head_en', 'label' => 'Heading (English)', 'name' => 'make_head_en', 'type' => 'text'],
                        ['key' => 'field_alomar_projects_make_text', 'label' => 'Text (Arabic)', 'name' => 'make_text', 'type' => 'text'],
                        ['key' => 'field_alomar_projects_make_text_en', 'label' => 'Text (English)', 'name' => 'make_text_en', 'type' => 'text'],
                    ],
                ],
                ['name' => 'companies_band_tab', 'label' => 'Companies Band', 'type' => 'tab', 'placement' => 'left'],
                ['name' => 'companies_tag', 'label' => 'Companies Tag (Arabic)', 'type' => 'text'],
                ['name' => 'companies_tag_en', 'label' => 'Companies Tag (English)', 'type' => 'text'],
                ['name' => 'companies_headline', 'label' => 'Companies Headline (Arabic)', 'type' => 'text'],
                ['name' => 'companies_headline_en', 'label' => 'Companies Headline (English)', 'type' => 'text'],
                [
                    'name' => 'companies_items',
                    'label' => 'Companies',
                    'type' => 'repeater',
                    'layout' => 'block',
                    'button_label' => 'Add Company',
                    'sub_fields' => [
                        ['key' => 'field_alomar_projects_company_logo', 'label' => 'Company Logo', 'name' => 'company_logo', 'type' => 'image', 'return_format' => 'array'],
                        ['key' => 'field_alomar_projects_company_link', 'label' => 'Company Website', 'name' => 'company_link', 'type' => 'url'],
                    ],
                ],
                ['name' => 'experience_tab', 'label' => 'Experience', 'type' => 'tab', 'placement' => 'left'],
                ['name' => 'experience_tag', 'label' => 'Experience Tag (Arabic)', 'type' => 'text'],
                ['name' => 'experience_tag_en', 'label' => 'Experience Tag (English)', 'type' => 'text'],
                ['name' => 'experience_headline', 'label' => 'Experience Headline (Arabic)', 'type' => 'text'],
                ['name' => 'experience_headline_en', 'label' => 'Experience Headline (English)', 'type' => 'text'],
                [
                    'name' => 'experience_items',
                    'label' => 'Experience Items',
                    'type' => 'repeater',
                    'layout' => 'block',
                    'button_label' => 'Add Experience Item',
                    'sub_fields' => [
                        ['key' => 'field_alomar_projects_experience_head', 'label' => 'Heading (Arabic)', 'name' => 'experience_head', 'type' => 'text'],
                        ['key' => 'field_alomar_projects_experience_head_en', 'label' => 'Heading (English)', 'name' => 'experience_head_en', 'type' => 'text'],
                        ['key' => 'field_alomar_projects_experience_text', 'label' => 'Text (Arabic)', 'name' => 'experience_text', 'type' => 'text'],
                        ['key' => 'field_alomar_projects_experience_text_en', 'label' => 'Text (English)', 'name' => 'experience_text_en', 'type' => 'text'],
                    ],
                ],
                ['name' => 'key_projects_tab', 'label' => 'Key Projects', 'type' => 'tab', 'placement' => 'left'],
                ['name' => 'key_projects_tag', 'label' => 'Key Projects Tag (Arabic)', 'type' => 'text'],
                ['name' => 'key_projects_tag_en', 'label' => 'Key Projects Tag (English)', 'type' => 'text'],
                ['name' => 'key_projects_headline', 'label' => 'Key Projects Headline (Arabic)', 'type' => 'text'],
                ['name' => 'key_projects_headline_en', 'label' => 'Key Projects Headline (English)', 'type' => 'text'],
                [
                    'name' => 'key_projects_items',
                    'label' => 'Key Projects',
                    'type' => 'repeater',
                    'layout' => 'block',
                    'button_label' => 'Add Key Project',
                    'sub_fields' => [
                        ['key' => 'field_alomar_projects_key_projects_img', 'label' => 'Project Image', 'name' => 'key_projects_img', 'type' => 'image', 'return_format' => 'array'],
                        ['key' => 'field_alomar_projects_key_projects_head', 'label' => 'Project Heading (Arabic)', 'name' => 'key_projects_head', 'type' => 'text'],
                        ['key' => 'field_alomar_projects_key_projects_head_en', 'label' => 'Project Heading (English)', 'name' => 'key_projects_head_en', 'type' => 'text'],
                        ['key' => 'field_alomar_projects_key_projects_location', 'label' => 'Project Location (Arabic)', 'name' => 'key_projects_location', 'type' => 'text'],
                        ['key' => 'field_alomar_projects_key_projects_location_en', 'label' => 'Project Location (English)', 'name' => 'key_projects_location_en', 'type' => 'text'],
                        ['key' => 'field_alomar_projects_key_projects_text', 'label' => 'Project Description (Arabic)', 'name' => 'key_projects_text', 'type' => 'text'],
                        ['key' => 'field_alomar_projects_key_projects_text_en', 'label' => 'Project Description (English)', 'name' => 'key_projects_text_en', 'type' => 'text'],
                        ['key' => 'field_alomar_projects_key_projects_link', 'label' => 'Project Link', 'name' => 'key_projects_link', 'type' => 'link', 'return_format' => 'array'],
                    ],
                ],
            ],
        ],
        'news' => [
            'title' => 'Alomar News Details',
            'fields' => [
                ['name' => 'title_en', 'label' => 'Title (English)', 'type' => 'text', 'graphql' => 'titleEn'],
                ['name' => 'excerpt_en', 'label' => 'Excerpt (English)', 'type' => 'textarea', 'graphql' => 'excerptEn'],
                ['name' => 'content_en', 'label' => 'Article Content (English)', 'type' => 'wysiwyg', 'graphql' => 'contentEn'],
                ['name' => 'category_ar', 'label' => 'News Category (Arabic)', 'type' => 'text', 'graphql' => 'newsCategoryAr'],
                ['name' => 'category_en', 'label' => 'News Category (English)', 'type' => 'text', 'graphql' => 'newsCategoryEn'],
                ['name' => 'read_time_ar', 'label' => 'Reading Time (Arabic)', 'type' => 'text', 'graphql' => 'readTimeAr'],
                ['name' => 'read_time_en', 'label' => 'Reading Time (English)', 'type' => 'text', 'graphql' => 'readTimeEn'],
                [
                    'name' => 'news_statistics',
                    'label' => 'Article Statistics',
                    'type' => 'repeater',
                    'layout' => 'table',
                    'button_label' => 'Add Article Statistic',
                    'sub_fields' => [
                        ['key' => 'field_alomar_news_stat_value', 'label' => 'Value (Arabic)', 'name' => 'value', 'type' => 'text'],
                        ['key' => 'field_alomar_news_stat_value_en', 'label' => 'Value (English)', 'name' => 'value_en', 'type' => 'text'],
                        ['key' => 'field_alomar_news_stat_label', 'label' => 'Label (Arabic)', 'name' => 'label', 'type' => 'text'],
                        ['key' => 'field_alomar_news_stat_label_en', 'label' => 'Label (English)', 'name' => 'label_en', 'type' => 'text'],
                    ],
                ],
                ['name' => 'company_name', 'label' => 'Related Company Name (Arabic)', 'type' => 'text'],
                ['name' => 'company_name_en', 'label' => 'Related Company Name (English)', 'type' => 'text'],
                ['name' => 'company_description', 'label' => 'Related Company Description (Arabic)', 'type' => 'textarea'],
                ['name' => 'company_description_en', 'label' => 'Related Company Description (English)', 'type' => 'textarea'],
                ['name' => 'company_logo', 'label' => 'Related Company Logo', 'type' => 'image', 'return_format' => 'array'],
                ['name' => 'company_link', 'label' => 'Related Company Link', 'type' => 'url'],
                ['name' => 'related_articles', 'label' => 'Related Articles', 'type' => 'relationship', 'post_type' => ['news'], 'return_format' => 'object'],
            ],
        ],
    ];

    public static function init(): void {
        if (!function_exists('acf_add_local_field_group')) {
            return;
        }
        add_action('acf/init', [self::class, 'register_field_groups']);
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
                    'show_in_graphql' => $post_type === 'projects',
                    ...array_diff_key($field, array_flip(['name', 'label', 'type', 'graphql', 'legacy'])),
                ];
            }

            acf_add_local_field_group([
                'key' => 'group_alomar_' . $post_type,
                'title' => $group['title'],
                'show_in_graphql' => $post_type === 'projects',
                'graphql_field_name' => $post_type === 'projects' ? 'projectDetails' : '',
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

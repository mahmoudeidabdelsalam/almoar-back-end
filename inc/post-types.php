<?php
defined('ABSPATH') || exit;

if (class_exists('Alomar_Post_Types')) {
    remove_action('init', [Alomar_Post_Types::class, 'register_post_types']);
}

final class Alomar_Theme_Post_Types {
    public static function init(): void {
        add_action('init', [self::class, 'register_post_types']);
    }

    public static function register_post_types(): void {
        $bilingual_cpts = [
            'news' => ['name' => 'News', 'ar' => 'الأخبار', 'slug' => 'news', 'icon' => 'dashicons-welcome-widgets-menus'],
        ];
        $graphql_names = [
            'news' => ['NewsArticle', 'NewsArticles'],
        ];

        foreach ($bilingual_cpts as $post_type => $labels) {
            register_post_type($post_type, [
                'labels' => [
                    'name' => __($labels['name'], 'alomar-holding-core'),
                    'singular_name' => __($labels['name'], 'alomar-holding-core'),
                    'menu_name' => $labels['name'],
                ],
                'public' => true,
                'has_archive' => true,
                'show_in_rest' => true,
                'show_in_graphql' => true,
                'graphql_single_name' => $graphql_names[$post_type][0],
                'graphql_plural_name' => $graphql_names[$post_type][1],
                'rest_base' => $post_type,
                'rewrite' => ['slug' => $labels['slug']],
                'supports' => ['title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'],
                'menu_icon' => $labels['icon'],
                'menu_position' => 5,
            ]);
        }

        register_post_type('projects', [
            'labels' => [
                'name' => __('Projects', 'alomar-holding-core'),
                'singular_name' => __('Project', 'alomar-holding-core'),
                'menu_name' => __('Companies', 'alomar-holding-core'),
                'add_new' => __('Add New Project', 'alomar-holding-core'),
                'add_new_item' => __('Add New Project', 'alomar-holding-core'),
                'edit_item' => __('Edit Project', 'alomar-holding-core'),
                'view_item' => __('View Project', 'alomar-holding-core'),
            ],
            'public' => true,
            'has_archive' => true,
            'show_in_rest' => true,
            'show_in_graphql' => true,
            'graphql_single_name' => 'Project',
            'graphql_plural_name' => 'Projects',
            'rest_base' => 'projects',
            'menu_icon' => 'dashicons-building',
            'supports' => ['title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'],
            'rewrite' => ['slug' => 'projects'],
            'menu_position' => 5,
        ]);

        register_post_type('inquiries', [
            'labels' => [
                'name' => __('Inquiries', 'alomar-holding-core'),
                'singular_name' => __('Inquiry', 'alomar-holding-core'),
                'menu_name' => __('Inquiries (الاستفسارات)', 'alomar-holding-core'),
            ],
            'public' => false,
            'show_ui' => true,
            'show_in_menu' => true,
            'show_in_rest' => false,
            'menu_icon' => 'dashicons-email-alt',
            'supports' => ['title', 'editor', 'custom-fields'],
            'capabilities' => ['create_posts' => 'do_not_allow'],
            'map_meta_cap' => true,
        ]);
    }
}

Alomar_Theme_Post_Types::init();

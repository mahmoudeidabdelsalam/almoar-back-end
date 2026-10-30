<?php
defined('ABSPATH') || exit;

if (class_exists('Alomar_Taxonomies')) {
    remove_action('init', [Alomar_Taxonomies::class, 'register_taxonomies']);
}

final class Alomar_Theme_Taxonomies {
    public static function init(): void {
        add_action('init', [self::class, 'register_taxonomies']);
    }

    public static function register_taxonomies(): void {
        register_taxonomy('project_category', ['projects'], [
            'labels' => [
                'name' => __('Project Categories', 'alomar-holding-core'),
                'singular_name' => __('Project Category', 'alomar-holding-core'),
                'search_items' => __('Search Categories', 'alomar-holding-core'),
                'all_items' => __('All Categories', 'alomar-holding-core'),
                'edit_item' => __('Edit Category', 'alomar-holding-core'),
                'update_item' => __('Update Category', 'alomar-holding-core'),
                'add_new_item' => __('Add New Category', 'alomar-holding-core'),
                'new_item_name' => __('New Category Name', 'alomar-holding-core'),
                'menu_name' => __('Project Categories', 'alomar-holding-core'),
            ],
            'hierarchical' => true,
            'show_ui' => true,
            'show_admin_column' => true,
            'show_in_rest' => true,
            'show_in_graphql' => true,
            'graphql_single_name' => 'ProjectCategory',
            'graphql_plural_name' => 'ProjectCategories',
            'query_var' => true,
            'rewrite' => ['slug' => 'project-category'],
        ]);

        register_taxonomy('project_location', ['projects'], [
            'labels' => [
                'name' => __('Locations', 'alomar-holding-core'),
                'singular_name' => __('Location', 'alomar-holding-core'),
                'menu_name' => __('Locations', 'alomar-holding-core'),
            ],
            'hierarchical' => true,
            'show_ui' => true,
            'show_admin_column' => true,
            'show_in_rest' => true,
            'show_in_graphql' => true,
            'graphql_single_name' => 'ProjectLocation',
            'graphql_plural_name' => 'ProjectLocations',
            'query_var' => true,
            'rewrite' => ['slug' => 'project-location'],
        ]);

        foreach ([
            'news_category' => ['News Categories', 'News Category', 'NewsCategory', 'NewsCategories', ['news']],
        ] as $taxonomy => [$plural, $singular, $graphql_single, $graphql_plural, $post_types]) {
            register_taxonomy($taxonomy, $post_types, [
                'labels' => [
                    'name' => __($plural, 'alomar-holding-core'),
                    'singular_name' => __($singular, 'alomar-holding-core'),
                    'menu_name' => __($plural, 'alomar-holding-core'),
                ],
                'hierarchical' => true,
                'show_ui' => true,
                'show_admin_column' => true,
                'show_in_rest' => true,
                'show_in_graphql' => true,
                'graphql_single_name' => $graphql_single,
                'graphql_plural_name' => $graphql_plural,
                'rewrite' => ['slug' => str_replace('_', '-', $taxonomy)],
            ]);
        }
    }
}

Alomar_Theme_Taxonomies::init();

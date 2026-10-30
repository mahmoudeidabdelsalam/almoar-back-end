<?php
defined('ABSPATH') || exit;

final class Alomar_Investments_Page_ACF {
    public static function init(): void {
        add_filter('acf/location/rule_types', [self::class, 'register_location_rule_type']);
        add_filter('acf/location/rule_values/our_investments_page', [self::class, 'register_location_rule_value']);
        add_filter('acf/location/rule_match/our_investments_page', [self::class, 'match_location_rule'], 10, 3);
        add_action('acf/init', [self::class, 'register_field_group']);
    }

    public static function register_location_rule_type(array $choices): array {
        $choices['Page']['our_investments_page'] = __('Our Investments page', 'theme-headless');
        return $choices;
    }

    public static function register_location_rule_value(array $choices): array {
        return ['our_investments_page' => __('Our Investments page', 'theme-headless')];
    }

    public static function match_location_rule(bool $match, array $rule, array $screen): bool {
        $page_id = absint($screen['post_id'] ?? 0);
        $page = $page_id ? get_post($page_id) : null;
        if (!$page instanceof WP_Post || $page->post_type !== 'page') {
            return false;
        }

        $is_investments_page = $page->post_name === 'our-investments'
            || sanitize_title($page->post_title) === 'our-investments';
        return ($rule['operator'] ?? '==') === '!=' ? !$is_investments_page : $is_investments_page;
    }

    public static function register_field_group(): void {
        if (!function_exists('acf_add_local_field_group')) {
            return;
        }

        $localized = static function (string $name, string $label, string $type = 'text'): array {
            return [
                [
                    'key' => 'field_alomar_investments_' . $name,
                    'label' => $label . ' (Arabic)',
                    'name' => $name,
                    'type' => $type,
                ],
                [
                    'key' => 'field_alomar_investments_' . $name . '_en',
                    'label' => $label . ' (English)',
                    'name' => $name . '_en',
                    'type' => $type,
                ],
            ];
        };

        acf_add_local_field_group([
            'key' => 'group_alomar_investments_page',
            'title' => 'Our Investments Page Content',
            'show_in_graphql' => false,
            'location' => [[[
                'param' => 'our_investments_page',
                'operator' => '==',
                'value' => 'our_investments_page',
            ]]],
            'fields' => [
                [
                    'key' => 'field_alomar_investments_tab_hero',
                    'label' => 'Page Header',
                    'type' => 'tab',
                    'placement' => 'top',
                ],
                ...$localized('hero_badge', 'Page Badge'),
                ...$localized('hero_title', 'Page Title'),
                ...$localized('hero_description', 'Page Description', 'textarea'),
                ...$localized('seo_title', 'SEO Title'),
                ...$localized('seo_description', 'SEO Description', 'textarea'),
                [
                    'key' => 'field_alomar_investments_tab_intro',
                    'label' => 'Investment Introduction',
                    'type' => 'tab',
                    'placement' => 'top',
                ],
                ...$localized('intro_eyebrow', 'Section Label'),
                ...$localized('intro_heading', 'Section Heading'),
                ...$localized('intro_description', 'Section Description', 'textarea'),
                [
                    'key' => 'field_alomar_investments_intro_image',
                    'label' => 'Introduction Image',
                    'name' => 'intro_image',
                    'type' => 'image',
                    'return_format' => 'array',
                ],
                [
                    'key' => 'field_alomar_investments_statistics',
                    'label' => 'Investment Statistics',
                    'name' => 'investment_statistics',
                    'type' => 'repeater',
                    'layout' => 'table',
                    'button_label' => 'Add Statistic',
                    'sub_fields' => [
                        ['key' => 'field_alomar_investments_stat_value', 'label' => 'Value', 'name' => 'stat_value', 'type' => 'text'],
                        ...$localized('stat_label', 'Label'),
                    ],
                ],
                [
                    'key' => 'field_alomar_investments_tab_portfolio',
                    'label' => 'Investment Portfolio',
                    'type' => 'tab',
                    'placement' => 'top',
                ],
                ...$localized('portfolio_eyebrow', 'Section Label'),
                ...$localized('portfolio_heading', 'Section Heading'),
                ...$localized('portfolio_description', 'Section Description', 'textarea'),
                [
                    'key' => 'field_alomar_investments_tab_cta',
                    'label' => 'Investment Call to Action',
                    'type' => 'tab',
                    'placement' => 'top',
                ],
                ...$localized('cta_eyebrow', 'Section Label'),
                ...$localized('cta_heading', 'Section Heading'),
                ...$localized('cta_description', 'Section Description', 'textarea'),
                ...$localized('cta_button_label', 'Button Label'),
                [
                    'key' => 'field_alomar_investments_cta_url',
                    'label' => 'Button Link',
                    'name' => 'cta_url',
                    'type' => 'url',
                    'default_value' => '/invest-with-us',
                ],
                [
                    'key' => 'field_alomar_investments_tab_navigation',
                    'label' => 'Related Pages',
                    'type' => 'tab',
                    'placement' => 'top',
                ],
                [
                    'key' => 'field_alomar_investments_navigation_links',
                    'label' => 'Related Page Links',
                    'name' => 'navigation_links',
                    'type' => 'repeater',
                    'layout' => 'block',
                    'button_label' => 'Add Related Page',
                    'sub_fields' => [
                        ...$localized('link_label', 'Link Label'),
                        ...$localized('link_description', 'Link Description', 'textarea'),
                        ['key' => 'field_alomar_investments_link_url', 'label' => 'Link URL', 'name' => 'link_url', 'type' => 'url'],
                        ['key' => 'field_alomar_investments_link_image', 'label' => 'Link Image', 'name' => 'link_image', 'type' => 'image', 'return_format' => 'array'],
                    ],
                ],
            ],
        ]);
    }
}

Alomar_Investments_Page_ACF::init();

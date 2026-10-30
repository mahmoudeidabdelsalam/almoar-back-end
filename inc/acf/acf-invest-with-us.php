<?php
defined('ABSPATH') || exit;

final class Alomar_Invest_With_Us_ACF {
    private const FORM_FIELD_KEY = 'field_alomar_investment_form_id';

    public static function init(): void {
        add_filter('acf/location/rule_types', [self::class, 'register_location_rule_type']);
        add_filter('acf/location/rule_values/invest_with_us_page', [self::class, 'register_location_rule_value']);
        add_filter('acf/location/rule_match/invest_with_us_page', [self::class, 'match_location_rule'], 10, 3);
        add_filter('acf/load_field/key=' . self::FORM_FIELD_KEY, [self::class, 'load_gravity_form_choices']);
        add_action('acf/init', [self::class, 'register_field_group']);
    }

    public static function register_location_rule_type(array $choices): array {
        $choices['Page']['invest_with_us_page'] = __('Invest With Us page', 'theme-headless');
        return $choices;
    }

    public static function register_location_rule_value(array $choices): array {
        return ['invest_with_us_page' => __('Invest With Us page', 'theme-headless')];
    }

    public static function match_location_rule(bool $match, array $rule, array $screen): bool {
        $page_id = absint($screen['post_id'] ?? 0);
        $page = $page_id ? get_post($page_id) : null;
        if (!$page instanceof WP_Post || $page->post_type !== 'page') {
            return false;
        }

        $is_invest_page = $page->post_name === 'invest-with-us'
            || sanitize_title($page->post_title) === 'invest-with-us';
        return ($rule['operator'] ?? '==') === '!=' ? !$is_invest_page : $is_invest_page;
    }

    public static function load_gravity_form_choices(array $field): array {
        $field['choices'] = [];
        if (class_exists('GFAPI')) {
            foreach ([true, false] as $active) {
                foreach (GFAPI::get_forms($active) as $form) {
                    $form_id = absint($form['id'] ?? 0);
                    if (!$form_id) {
                        continue;
                    }
                    $title = sanitize_text_field(wp_strip_all_tags($form['title'] ?? ''));
                    $status = !empty($form['is_active']) ? '' : ' (' . __('Inactive', 'theme-headless') . ')';
                    $field['choices'][(string) $form_id] = sprintf(
                        '%s (ID: %d)%s',
                        $title !== '' ? $title : __('Untitled form', 'theme-headless'),
                        $form_id,
                        $status
                    );
                }
            }
        }

        $selected_id = absint($field['value'] ?? 0);
        if ($selected_id && !array_key_exists((string) $selected_id, $field['choices'])) {
            $field['choices'][(string) $selected_id] = sprintf(
                __('Unavailable form (ID: %d)', 'theme-headless'),
                $selected_id
            );
        }

        if (!$field['choices']) {
            $field['choices'][''] = class_exists('GFAPI')
                ? __('No active Gravity Forms are available.', 'theme-headless')
                : __('Gravity Forms is not available.', 'theme-headless');
        }

        return $field;
    }

    public static function register_field_group(): void {
        if (!function_exists('acf_add_local_field_group')) {
            return;
        }

        $localized = static function (string $name, string $label, string $type = 'text'): array {
            return [
                [
                    'key' => 'field_alomar_invest_' . $name,
                    'label' => $label . ' (Arabic)',
                    'name' => $name,
                    'type' => $type,
                ],
                [
                    'key' => 'field_alomar_invest_' . $name . '_en',
                    'label' => $label . ' (English)',
                    'name' => $name . '_en',
                    'type' => $type,
                ],
            ];
        };

        acf_add_local_field_group([
            'key' => 'group_alomar_invest_with_us',
            'title' => 'Invest With Us Page Content',
            'show_in_graphql' => false,
            'location' => [[[
                'param' => 'invest_with_us_page',
                'operator' => '==',
                'value' => 'invest_with_us_page',
            ]]],
            'fields' => [
                [
                    'key' => 'field_alomar_invest_tab_hero',
                    'label' => 'Page Header',
                    'type' => 'tab',
                    'placement' => 'top',
                ],
                ...$localized('hero_badge', 'Page Badge'),
                ...$localized('hero_title', 'Page Title'),
                ...$localized('hero_description', 'Page Description', 'textarea'),
                [
                    'key' => 'field_alomar_invest_hero_image',
                    'label' => 'Page Header Image',
                    'name' => 'hero_image',
                    'type' => 'image',
                    'return_format' => 'array',
                ],
                [
                    'key' => 'field_alomar_invest_tab_opportunity',
                    'label' => 'Partnership Opportunity',
                    'type' => 'tab',
                    'placement' => 'top',
                ],
                ...$localized('opportunity_heading', 'Section Heading'),
                ...$localized('opportunity_description', 'Section Description', 'textarea'),
                ...$localized('process_heading', 'Process Heading'),
                [
                    'key' => 'field_alomar_invest_process_items',
                    'label' => 'Process Steps',
                    'name' => 'process_items',
                    'type' => 'repeater',
                    'layout' => 'block',
                    'button_label' => 'Add Process Step',
                    'sub_fields' => [
                        ...$localized('process_title', 'Step Title'),
                        ...$localized('process_description', 'Step Description', 'textarea'),
                    ],
                ],
                [
                    'key' => 'field_alomar_invest_tab_inquiry',
                    'label' => 'Investment Inquiry',
                    'type' => 'tab',
                    'placement' => 'top',
                ],
                ...$localized('contact_heading', 'Contact Panel Heading'),
                ...$localized('contact_description', 'Contact Panel Description', 'textarea'),
                ...$localized('inquiry_form_title', 'Form Heading'),
                ...$localized('inquiry_form_submit_label', 'Submit Button Label'),
                [
                    'key' => self::FORM_FIELD_KEY,
                    'label' => 'Investment Form',
                    'name' => 'investment_form_id',
                    'type' => 'select',
                    'choices' => [],
                    'allow_null' => 1,
                    'ui' => 1,
                    'instructions' => __('Select an active Gravity Form. The title and ID are shown for identification.', 'theme-headless'),
                ],
            ],
        ]);
    }
}

Alomar_Invest_With_Us_ACF::init();

<?php
/**
 * Theme-owned Alomar editorial/options ACF configuration.
 * Original field keys, names, repeaters and groups are preserved.
 */
defined('ABSPATH') || exit;

final class Alomar_Theme_Site_Content {
    private const OPTIONS_PAGE = 'alomar-homepage-content';

    public static function init(): void {
        if (!function_exists('acf_add_local_field_group')) {
            return;
        }
        add_action('acf/init', [self::class, 'register_field_group']);
        add_action('admin_init', [self::class, 'migrate_typo_metadata']);
    }

    public static function migrate_typo_metadata(): void {
        if (get_option('alomar_site_content_metadata_migration_v1')) {
            return;
        }

        self::migrate_group('page_banners', ['seo_enscription_ar' => 'seo_description_ar', 'seo_enscription_en' => 'seo_description_en']);
        self::migrate_group('about_page', [
            'vision_enscription_ar' => 'vision_description_ar',
            'vision_enscription_en' => 'vision_description_en',
            'mission_enscription_ar' => 'mission_description_ar',
            'mission_enscription_en' => 'mission_description_en',
        ]);
        self::migrate_group('footer_content', [
            'company_enscription_ar' => 'company_description_ar',
            'company_enscription_en' => 'company_description_en',
        ]);

        update_option('alomar_site_content_metadata_migration_v1', 1);
    }

    private static function migrate_group(string $group_name, array $field_map): void {
        $group = get_option($group_name);
        if (!is_array($group) || empty($group)) {
            return;
        }

        $migrate_row = static function (array $row) use ($field_map): array {
            foreach ($field_map as $old_name => $new_name) {
                if (!array_key_exists($new_name, $row) && array_key_exists($old_name, $row)) {
                    $row[$new_name] = $row[$old_name];
                }
            }
            return $row;
        };

        if ($group_name === 'page_banners' && isset($group[0]) && is_array($group[0])) {
            $group = array_map(static function ($row) use ($migrate_row): array {
                return is_array($row) ? $migrate_row($row) : [];
            }, $group);
        } else {
            $group = $migrate_row($group);
        }

        update_option($group_name, $group);
    }

    private static function field(string $path, string $name, string $label, string $type = 'text', array $settings = []): array {
        return array_merge([
            'key' => 'field_alomar_content_' . sanitize_key($path),
            'name' => $name,
            'label' => $label,
            'type' => $type,
        ], $settings);
    }

    private static function localized_fields(string $path, string $label, string $type = 'text', ?string $name = null): array {
        $name = $name ?? $path;
        return [
            self::field($path . '_ar', $name . '_ar', $label . ' (Arabic)', $type),
            self::field($path . '_en', $name . '_en', $label . ' (English)', $type),
        ];
    }

    public static function register_field_group(): void {
        if (!function_exists('acf_add_local_field_group')) {
            return;
        }

        $pillar_fields = [
            self::field('home_about_pillar_icon', 'icon', 'Icon Key'),
            ...self::localized_fields('home_about_pillar_title', 'Title', 'text', 'title'),
            ...self::localized_fields('home_about_pillar_enscription', 'Description', 'textarea', 'description'),
        ];
        $value_fields = [
            ...self::localized_fields('about_value_title', 'Value', 'text', 'title'),
            ...self::localized_fields('about_value_enscription', 'Description', 'textarea', 'description'),
        ];
        $vision_pillar_fields = [
            self::field('vision_pillar_icon', 'icon', 'Icon Key'),
            ...self::localized_fields('vision_pillar_title', 'Title', 'text', 'title'),
            ...self::localized_fields('vision_pillar_enscription', 'Description', 'textarea', 'description'),
        ];

        $fields = [[
            'key' => 'field_alomar_content_page_banners',
            'label' => 'Page Banners and SEO',
            'name' => 'page_banners',
            'type' => 'repeater',
            'layout' => 'block',
            'button_label' => 'Add Page Banner',
            'sub_fields' => [
                self::field('page_banners_page_key', 'page_key', 'Page', 'select', [
                    'choices' => [
                        'home' => 'Homepage',
                        'about' => 'About',
                        'sectors' => 'Sectors',
                        'companies' => 'Companies',
                        'projects' => 'Projects',
                        'news' => 'News',
                    ],
                    'required' => 1,
                ]),
                ...self::localized_fields('page_banners_badge', 'Eyebrow', 'text', 'badge'),
                ...self::localized_fields('page_banners_title', 'Title', 'text', 'title'),
                ...self::localized_fields('page_banners_enscription', 'Description', 'textarea', 'description'),
                self::field('page_banners_image', 'image', 'Background Image', 'image', ['return_format' => 'url']),
                ...self::localized_fields('page_banners_seo_title', 'SEO Title', 'text', 'seo_title'),
                ...self::localized_fields('page_banners_seo_enscription', 'SEO Description', 'textarea', 'seo_description'),
            ],
        ], [
            'key' => 'field_alomar_content_section_copy',
            'label' => 'Homepage Section Headings and CTAs',
            'name' => 'section_copy',
            'type' => 'repeater',
            'layout' => 'block',
            'button_label' => 'Add Section Copy',
            'sub_fields' => [
                self::field('section_copy_key', 'section_key', 'Section', 'select', [
                    'choices' => [
                        'sectors' => 'Sectors',
                        'projects' => 'Projects',
                        'companies' => 'Companies',
                        'leadership' => 'Leadership',
                        'news' => 'News',
                    ],
                    'required' => 1,
                ]),
                ...self::localized_fields('section_copy_badge', 'Eyebrow', 'text', 'badge'),
                ...self::localized_fields('section_copy_title', 'Title', 'text', 'title'),
                ...self::localized_fields('section_copy_enscription', 'Description', 'textarea', 'description'),
                ...self::localized_fields('section_copy_cta_label', 'CTA Label', 'text', 'cta_label'),
                self::field('section_copy_cta_url', 'cta_url', 'CTA URL', 'url'),
            ],
        ], [
            'key' => 'field_alomar_content_home_about',
            'label' => 'Homepage About Section',
            'name' => 'home_about',
            'type' => 'group',
            'sub_fields' => [
                ...self::localized_fields('home_about_badge', 'Eyebrow', 'text', 'badge'),
                ...self::localized_fields('home_about_title', 'Title', 'text', 'title'),
                ...self::localized_fields('home_about_enscription_one', 'First Description', 'textarea', 'description_1'),
                ...self::localized_fields('home_about_enscription_two', 'Second Description', 'textarea', 'description_2'),
                self::field('home_about_image', 'image', 'Section Image', 'image', ['return_format' => 'url']),
                [
                    'key' => 'field_alomar_content_home_about_pillars',
                    'label' => 'Investment Pillars',
                    'name' => 'pillars',
                    'type' => 'repeater',
                    'layout' => 'table',
                    'button_label' => 'Add Pillar',
                    'sub_fields' => $pillar_fields,
                ],
            ],
        ], [
            'key' => 'field_alomar_content_about_page',
            'label' => 'About Page Content',
            'name' => 'about_page',
            'type' => 'group',
            'sub_fields' => [
                self::field('about_page_chairman_image', 'chairman_image', 'Chairman Portrait', 'image', ['return_format' => 'url']),
                ...self::localized_fields('about_page_chairman_name', 'Chairman Name', 'text', 'chairman_name'),
                ...self::localized_fields('about_page_chairman_role', 'Chairman Role', 'text', 'chairman_role'),
                ...self::localized_fields('about_page_message_heading', 'Message Heading', 'text', 'message_heading'),
                ...self::localized_fields('about_page_quote', 'Chairman Quote', 'textarea', 'quote'),
                ...self::localized_fields('about_page_message_one', 'Message Paragraph 1', 'textarea', 'message_one'),
                ...self::localized_fields('about_page_message_two', 'Message Paragraph 2', 'textarea', 'message_two'),
                ...self::localized_fields('about_page_vision_title', 'Vision Title', 'text', 'vision_title'),
                ...self::localized_fields('about_page_vision_enscription', 'Vision Description', 'textarea', 'vision_description'),
                ...self::localized_fields('about_page_mission_title', 'Mission Title', 'text', 'mission_title'),
                ...self::localized_fields('about_page_mission_enscription', 'Mission Description', 'textarea', 'mission_description'),
                [
                    'key' => 'field_alomar_content_about_values',
                    'label' => 'Corporate Values',
                    'name' => 'values',
                    'type' => 'repeater',
                    'layout' => 'table',
                    'button_label' => 'Add Value',
                    'sub_fields' => $value_fields,
                ],
            ],
        ], [
            'key' => 'field_alomar_content_vision_section',
            'label' => 'Vision 2030 Section',
            'name' => 'vision_section',
            'type' => 'group',
            'sub_fields' => [
                ...self::localized_fields('vision_section_badge', 'Eyebrow', 'text', 'badge'),
                ...self::localized_fields('vision_section_title', 'Title', 'text', 'title'),
                ...self::localized_fields('vision_section_enscription', 'Description', 'textarea', 'description'),
                [
                    'key' => 'field_alomar_content_vision_pillars',
                    'label' => 'Vision Pillars',
                    'name' => 'pillars',
                    'type' => 'repeater',
                    'layout' => 'table',
                    'button_label' => 'Add Vision Pillar',
                    'sub_fields' => $vision_pillar_fields,
                ],
                ...self::localized_fields('vision_section_footer_line', 'Closing Statement', 'textarea', 'footer_line'),
                ...self::localized_fields('vision_section_cta_label', 'CTA Label', 'text', 'cta_label'),
                self::field('vision_section_cta_url', 'cta_url', 'CTA URL', 'url'),
            ],
        ], [
            'key' => 'field_alomar_content_footer',
            'label' => 'Footer Editorial Copy',
            'name' => 'footer_content',
            'type' => 'group',
            'sub_fields' => [
                ...self::localized_fields('footer_company_enscription', 'Company Description', 'textarea', 'company_description'),
                ...self::localized_fields('footer_vision_badge', 'Vision 2030 Badge', 'text', 'vision_badge'),
            ],
        ]];

        acf_add_local_field_group([
            'key' => 'group_alomar_editorial_content',
            'title' => 'Alomar Website company and homepage content',
            'show_in_graphql' => false,
            'location' => [[[
                'param' => 'options_page',
                'operator' => '==',
                'value' => self::OPTIONS_PAGE,
            ]]],
            'fields' => $fields,
        ]);
    }
}

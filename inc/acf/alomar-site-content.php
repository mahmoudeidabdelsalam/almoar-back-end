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
        add_action('admin_init', [self::class, 'migrate_about_page_content']);
        add_filter('acf/prepare_field', [self::class, 'hide_legacy_editor_fields']);
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

    public static function migrate_about_page_content(): void {
        if (get_option('alomar_about_page_template_migration_v1')) {
            return;
        }

        $page_id = self::get_about_page_id();
        if (!$page_id) {
            return;
        }

        $legacy = get_field('about_page', 'option', false);
        $current = get_field('about_page', $page_id, false);
        $merged = is_array($legacy) ? $legacy : [];

        if (is_array($current)) {
            foreach ($current as $key => $value) {
                if ($value !== null && $value !== '' && $value !== []) {
                    $merged[$key] = $value;
                }
            }
        }

        if (!empty($merged) && update_field('field_alomar_content_about_page', $merged, $page_id) === false) {
            error_log('Unable to migrate About page ACF content to the About Us page.');
            return;
        }

        update_option('alomar_about_page_template_migration_v1', 1);
    }

    public static function hide_legacy_editor_fields(array $field): array|false {
        $hidden_keys = [
            'field_alomar_content_page_banners',
            'field_alomar_content_section_copy',
            'field_alomar_content_home_about_image',
            'field_alomar_content_home_about_pillars',
        ];

        return in_array($field['key'] ?? '', $hidden_keys, true) ? false : $field;
    }

    private static function get_about_page_id(): int {
        $pages = get_posts([
            'post_type' => 'page',
            'post_status' => ['publish', 'draft', 'private'],
            'numberposts' => 1,
            'meta_key' => '_wp_page_template',
            'meta_value' => 'page-about-us.php',
        ]);

        return $pages ? (int) $pages[0]->ID : 0;
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
        $about_localized_fields = static function (string $path, string $name, string $label, string $type = 'text'): array {
            return [
                self::field('about_page_' . $path, $name, $label . ' (Arabic)', $type),
                self::field('about_page_' . $path . '_en', $name . '_en', $label . ' (English)', $type),
            ];
        };
        $about_image_field = static function (string $path, string $name, string $label): array {
            return self::field('about_page_' . $path, $name, $label, 'image', ['return_format' => 'url']);
        };
        $about_principle_fields = [
            ...$about_localized_fields('strategy_principle_title', 'title', 'Principle', 'text'),
            ...$about_localized_fields('strategy_principle_description', 'description', 'Description', 'textarea'),
        ];
        $about_portfolio_fields = [
            ...$about_localized_fields('portfolio_item_title', 'title', 'Portfolio Area', 'text'),
            ...$about_localized_fields('portfolio_item_description', 'description', 'Description', 'textarea'),
            self::field('about_page_portfolio_item_metric', 'metric', 'Displayed Number'),
        ];
        $about_company_fields = [
            ...$about_localized_fields('portfolio_company_name', 'name', 'Company Name', 'text'),
            ...$about_localized_fields('portfolio_company_description', 'description', 'Description', 'textarea'),
            $about_image_field('portfolio_company_logo', 'logo', 'Company Logo'),
            $about_image_field('portfolio_company_image', 'image', 'Company Image'),
            self::field('about_page_portfolio_company_link', 'link', 'Company Website', 'url'),
        ];
        $about_responsibility_fields = [
            ...$about_localized_fields('responsibility_item_title', 'title', 'Initiative Title', 'text'),
            ...$about_localized_fields('responsibility_item_description', 'description', 'Description', 'textarea'),
            $about_image_field('responsibility_item_image', 'image', 'Initiative Image'),
        ];
        $about_board_fields = [
            ...$about_localized_fields('board_member_name', 'name', 'Member Name', 'text'),
            ...$about_localized_fields('board_member_role', 'role', 'Member Role', 'text'),
            $about_image_field('board_member_image', 'image', 'Member Portrait'),
        ];
        $about_navigation_fields = [
            ...$about_localized_fields('about_navigation_label', 'label', 'Link Label', 'text'),
            $about_image_field('about_navigation_image', 'image', 'Link Image'),
            self::field('about_page_navigation_url', 'url', 'Destination URL', 'url'),
        ];
        $vision_pillar_fields = [
            self::field('vision_pillar_icon', 'icon', 'Icon Key'),
            ...self::localized_fields('vision_pillar_title', 'Title', 'text', 'title'),
            ...self::localized_fields('vision_pillar_enscription', 'Description', 'textarea', 'description'),
        ];
        $home_sector_tag_fields = [
            ...self::localized_fields('home_about_sector_tag_label', 'Tag Label', 'text', 'label'),
            self::field('home_about_sector_tag_url', 'url', 'Tag URL', 'text'),
        ];
        $home_sector_fields = [
            ...self::localized_fields('home_about_sector_title', 'Sector Title', 'text', 'title'),
            ...self::localized_fields('home_about_sector_enscription', 'Sector Description', 'textarea', 'description'),
            [
                'key' => 'field_alomar_content_home_about_sector_tags',
                'label' => 'Tags',
                'name' => 'tags',
                'type' => 'repeater',
                'layout' => 'table',
                'button_label' => 'Add Tag',
                'sub_fields' => $home_sector_tag_fields,
            ],
            self::field('home_about_sector_logo', 'logo', 'Sector Logo', 'image', ['return_format' => 'url']),
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
                self::field('section_copy_cta_url', 'cta_url', 'CTA URL', 'text'),
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
                [
                    'key' => 'field_alomar_content_home_about_sectors',
                    'label' => 'Sectors',
                    'name' => 'sectors',
                    'type' => 'group',
                    'layout' => 'block',
                    'sub_fields' => [
                        ...self::localized_fields('home_about_sectors_badge', 'Section Tag', 'text', 'badge'),
                        ...self::localized_fields('home_about_sectors_title', 'Section Title', 'text', 'title'),
                        ...self::localized_fields('home_about_sectors_enscription', 'Section Description', 'textarea', 'description'),
                        [
                            'key' => 'field_alomar_content_home_about_sectors_items',
                            'label' => 'Sectors',
                            'name' => 'items',
                            'type' => 'repeater',
                            'layout' => 'block',
                            'button_label' => 'Add Sector',
                            'sub_fields' => $home_sector_fields,
                        ],
                    ],
                ],
            ],
        ], [
            'key' => 'field_alomar_content_about_page',
            'label' => 'About Page Content',
            'name' => 'about_page',
            'type' => 'group',
            'sub_fields' => [
                [
                    'key' => 'field_alomar_content_about_tab_overview',
                    'label' => 'Overview and Statistics',
                    'type' => 'tab',
                    'placement' => 'top',
                ],
                ...$about_localized_fields('overview_title', 'overview_title', 'Overview Heading'),
                ...$about_localized_fields('overview_description_one', 'overview_description_one', 'Overview Description One', 'textarea'),
                ...$about_localized_fields('overview_description_two', 'overview_description_two', 'Overview Description Two', 'textarea'),
                $about_image_field('overview_image_one', 'overview_image_one', 'Overview Image One'),
                ...$about_localized_fields('overview_image_one_alt', 'overview_image_one_alt', 'Overview Image One Alt Text'),
                $about_image_field('overview_image_two', 'overview_image_two', 'Overview Image Two'),
                ...$about_localized_fields('overview_image_two_alt', 'overview_image_two_alt', 'Overview Image Two Alt Text'),
                [
                    'key' => 'field_alomar_content_about_statistics',
                    'label' => 'About Statistics',
                    'name' => 'statistics',
                    'type' => 'repeater',
                    'layout' => 'table',
                    'button_label' => 'Add Statistic',
                    'sub_fields' => [
                        self::field('about_page_statistic_value', 'value', 'Value'),
                        ...$about_localized_fields('about_page_statistic_label', 'label', 'Label', 'text'),
                    ],
                ],
                [
                    'key' => 'field_alomar_content_about_tab_strategy',
                    'label' => 'Clarity and Strategy',
                    'type' => 'tab',
                    'placement' => 'top',
                ],
                ...$about_localized_fields('strategy_eyebrow', 'strategy_eyebrow', 'Section Eyebrow'),
                ...$about_localized_fields('strategy_title', 'strategy_title', 'Section Title'),
                ...$about_localized_fields('strategy_description', 'strategy_description', 'Section Description', 'textarea'),
                ...$about_localized_fields('strategy_cta_label', 'strategy_cta_label', 'Button Label'),
                self::field('about_page_strategy_cta_url', 'strategy_cta_url', 'Button URL', 'url'),
                ...$about_localized_fields('strategy_focus_title', 'strategy_focus_title', 'Investment Focus Title'),
                ...$about_localized_fields('strategy_focus_description', 'strategy_focus_description', 'Investment Focus Description', 'textarea'),
                [
                    'key' => 'field_alomar_content_about_strategy_principles',
                    'label' => 'Strategy Principles',
                    'name' => 'strategy_principles',
                    'type' => 'repeater',
                    'layout' => 'table',
                    'button_label' => 'Add Principle',
                    'sub_fields' => $about_principle_fields,
                ],
                [
                    'key' => 'field_alomar_content_about_tab_portfolio',
                    'label' => 'Portfolio',
                    'type' => 'tab',
                    'placement' => 'top',
                ],
                ...$about_localized_fields('portfolio_eyebrow', 'portfolio_eyebrow', 'Section Eyebrow'),
                ...$about_localized_fields('portfolio_title', 'portfolio_title', 'Section Title'),
                ...$about_localized_fields('portfolio_cta_label', 'portfolio_cta_label', 'Button Label'),
                self::field('about_page_portfolio_cta_url', 'portfolio_cta_url', 'Button URL', 'url'),
                [
                    'key' => 'field_alomar_content_about_portfolio_items',
                    'label' => 'Portfolio Areas',
                    'name' => 'portfolio_items',
                    'type' => 'repeater',
                    'layout' => 'block',
                    'button_label' => 'Add Portfolio Area',
                    'sub_fields' => $about_portfolio_fields,
                ],
                [
                    'key' => 'field_alomar_content_about_tab_companies',
                    'label' => 'Companies',
                    'type' => 'tab',
                    'placement' => 'top',
                ],
                ...$about_localized_fields('companies_eyebrow', 'companies_eyebrow', 'Section Eyebrow'),
                ...$about_localized_fields('companies_title', 'companies_title', 'Section Title'),
                [
                    'key' => 'field_alomar_content_about_companies',
                    'label' => 'Companies',
                    'name' => 'companies',
                    'type' => 'repeater',
                    'layout' => 'block',
                    'button_label' => 'Add Company',
                    'sub_fields' => $about_company_fields,
                ],
                [
                    'key' => 'field_alomar_content_about_tab_responsibility',
                    'label' => 'Social Responsibility',
                    'type' => 'tab',
                    'placement' => 'top',
                ],
                ...$about_localized_fields('responsibility_eyebrow', 'responsibility_eyebrow', 'Section Eyebrow'),
                ...$about_localized_fields('responsibility_title', 'responsibility_title', 'Section Title'),
                [
                    'key' => 'field_alomar_content_about_responsibility_items',
                    'label' => 'Initiatives',
                    'name' => 'responsibility_items',
                    'type' => 'repeater',
                    'layout' => 'block',
                    'button_label' => 'Add Initiative',
                    'sub_fields' => $about_responsibility_fields,
                ],
                [
                    'key' => 'field_alomar_content_about_tab_board',
                    'label' => 'Board of Directors',
                    'type' => 'tab',
                    'placement' => 'top',
                ],
                ...$about_localized_fields('board_eyebrow', 'board_eyebrow', 'Section Eyebrow'),
                ...$about_localized_fields('board_title', 'board_title', 'Section Title'),
                [
                    'key' => 'field_alomar_content_about_board_members',
                    'label' => 'Board Members',
                    'name' => 'board_members',
                    'type' => 'repeater',
                    'layout' => 'table',
                    'button_label' => 'Add Board Member',
                    'sub_fields' => $about_board_fields,
                ],
                [
                    'key' => 'field_alomar_content_about_tab_navigation',
                    'label' => 'Related Page',
                    'type' => 'tab',
                    'placement' => 'top',
                ],
                [
                    'key' => 'field_alomar_content_about_navigation_links',
                    'label' => 'Related Page',
                    'name' => 'navigation_links',
                    'type' => 'repeater',
                    'layout' => 'table',
                    'button_label' => 'Add Link',
                    'sub_fields' => $about_navigation_fields,
                ],
            ],
        ]];

        $about_page_field = null;
        foreach ($fields as $index => $field) {
            if (($field['name'] ?? '') === 'about_page') {
                $about_page_field = $field;
                unset($fields[$index]);
                break;
            }
        }

        acf_add_local_field_group([
            'key' => 'group_alomar_editorial_content',
            'title' => 'Alomar Website company and homepage content',
            'show_in_graphql' => false,
            'location' => [[[
                'param' => 'options_page',
                'operator' => '==',
                'value' => self::OPTIONS_PAGE,
            ]]],
            'fields' => array_values($fields),
        ]);

        if ($about_page_field !== null) {
            acf_add_local_field_group([
                'key' => 'group_alomar_about_page_content',
                'title' => 'About Us Page Content',
                'show_in_graphql' => false,
                'location' => [[[
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'page-about-us.php',
                ]]],
                'fields' => [$about_page_field],
            ]);
        }
    }
}

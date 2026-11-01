<?php
defined('ABSPATH') || exit;

final class Alomar_Theme_Site_Content_GraphQL {
    private const OBJECT_TYPES = [
        'AlomarSiteStatistic' => [
            'key' => 'String',
            'number' => 'String',
            'labelAr' => 'String',
            'labelEn' => 'String',
        ],
        'AlomarSiteSettings' => [
            'siteNameAr' => 'String',
            'siteNameEn' => 'String',
            'taglineAr' => 'String',
            'taglineEn' => 'String',
            'phone' => 'String',
            'email' => 'String',
            'addressAr' => 'String',
            'addressEn' => 'String',
            'workingHoursAr' => 'String',
            'workingHoursEn' => 'String',
            'mapLat' => 'Float',
            'mapLng' => 'Float',
            'statistics' => ['list_of' => 'AlomarSiteStatistic'],
            'socialX' => 'String',
            'socialLinkedin' => 'String',
            'socialInstagram' => 'String',
        ],
        'AlomarPageBanner' => [
            'pageKey' => 'String',
            'badgeAr' => 'String',
            'badgeEn' => 'String',
            'titleAr' => 'String',
            'titleEn' => 'String',
            'descriptionAr' => 'String',
            'descriptionEn' => 'String',
            'imageUrl' => 'String',
            'seoTitleAr' => 'String',
            'seoTitleEn' => 'String',
            'seoDescriptionAr' => 'String',
            'seoDescriptionEn' => 'String',
        ],
        'AlomarSectionCopy' => [
            'sectionKey' => 'String',
            'badgeAr' => 'String',
            'badgeEn' => 'String',
            'titleAr' => 'String',
            'titleEn' => 'String',
            'descriptionAr' => 'String',
            'descriptionEn' => 'String',
            'ctaLabelAr' => 'String',
            'ctaLabelEn' => 'String',
            'ctaUrl' => 'String',
        ],
        'AlomarEditorialPillar' => [
            'icon' => 'String',
            'titleAr' => 'String',
            'titleEn' => 'String',
            'descriptionAr' => 'String',
            'descriptionEn' => 'String',
        ],
        'AlomarHomeAbout' => [
            'badgeAr' => 'String',
            'badgeEn' => 'String',
            'titleAr' => 'String',
            'titleEn' => 'String',
            'descriptionOneAr' => 'String',
            'descriptionOneEn' => 'String',
            'descriptionTwoAr' => 'String',
            'descriptionTwoEn' => 'String',
            'imageUrl' => 'String',
            'pillars' => ['list_of' => 'AlomarEditorialPillar'],
            'sectors' => 'AlomarHomeSectors',
        ],
        'AlomarHomeSectors' => [
            'badgeAr' => 'String',
            'badgeEn' => 'String',
            'titleAr' => 'String',
            'titleEn' => 'String',
            'descriptionAr' => 'String',
            'descriptionEn' => 'String',
            'items' => ['list_of' => 'AlomarHomeSector'],
        ],
        'AlomarHomeSector' => [
            'titleAr' => 'String',
            'titleEn' => 'String',
            'descriptionAr' => 'String',
            'descriptionEn' => 'String',
            'tags' => ['list_of' => 'AlomarHomeSectorTag'],
            'buttonLabelAr' => 'String',
            'buttonLabelEn' => 'String',
            'buttonUrl' => 'String',
            'logoUrl' => 'String',
        ],
        'AlomarHomeSectorTag' => [
            'labelAr' => 'String',
            'labelEn' => 'String',
            'url' => 'String',
        ],
        'AlomarAboutValue' => [
            'titleAr' => 'String',
            'titleEn' => 'String',
            'descriptionAr' => 'String',
            'descriptionEn' => 'String',
        ],
        'AlomarAboutStatistic' => [
            'value' => 'String',
            'label' => 'String',
            'labelEn' => 'String',
        ],
        'AlomarStrategyPrinciple' => [
            'title' => 'String',
            'titleEn' => 'String',
            'description' => 'String',
            'descriptionEn' => 'String',
        ],
        'AlomarPortfolioItem' => [
            'title' => 'String',
            'titleEn' => 'String',
            'description' => 'String',
            'descriptionEn' => 'String',
            'metric' => 'String',
        ],
        'AlomarPortfolioCompany' => [
            'name' => 'String',
            'nameEn' => 'String',
            'description' => 'String',
            'descriptionEn' => 'String',
            'logoUrl' => 'String',
            'imageUrl' => 'String',
            'link' => 'String',
        ],
        'AlomarResponsibilityItem' => [
            'title' => 'String',
            'titleEn' => 'String',
            'description' => 'String',
            'descriptionEn' => 'String',
            'imageUrl' => 'String',
        ],
        'AlomarBoardMember' => [
            'name' => 'String',
            'nameEn' => 'String',
            'role' => 'String',
            'roleEn' => 'String',
            'imageUrl' => 'String',
        ],
        'AlomarNavigationLink' => [
            'label' => 'String',
            'labelEn' => 'String',
            'imageUrl' => 'String',
            'url' => 'String',
        ],
        'AlomarAboutPage' => [
            'chairmanImageUrl' => 'String',
            'chairmanNameAr' => 'String',
            'chairmanNameEn' => 'String',
            'chairmanRoleAr' => 'String',
            'chairmanRoleEn' => 'String',
            'messageHeadingAr' => 'String',
            'messageHeadingEn' => 'String',
            'quoteAr' => 'String',
            'quoteEn' => 'String',
            'messageOneAr' => 'String',
            'messageOneEn' => 'String',
            'messageTwoAr' => 'String',
            'messageTwoEn' => 'String',
            'visionTitleAr' => 'String',
            'visionTitleEn' => 'String',
            'visionDescriptionAr' => 'String',
            'visionDescriptionEn' => 'String',
            'missionTitleAr' => 'String',
            'missionTitleEn' => 'String',
            'missionDescriptionAr' => 'String',
            'missionDescriptionEn' => 'String',
            'values' => ['list_of' => 'AlomarAboutValue'],
            'overviewTitle' => 'String',
            'overviewTitleEn' => 'String',
            'overviewDescriptionOne' => 'String',
            'overviewDescriptionOneEn' => 'String',
            'overviewDescriptionTwo' => 'String',
            'overviewDescriptionTwoEn' => 'String',
            'overviewImageOneUrl' => 'String',
            'overviewImageOneAlt' => 'String',
            'overviewImageOneAltEn' => 'String',
            'overviewImageTwoUrl' => 'String',
            'overviewImageTwoAlt' => 'String',
            'overviewImageTwoAltEn' => 'String',
            'statistics' => ['list_of' => 'AlomarAboutStatistic'],
            'strategyEyebrow' => 'String',
            'strategyEyebrowEn' => 'String',
            'strategyTitle' => 'String',
            'strategyTitleEn' => 'String',
            'strategyDescription' => 'String',
            'strategyDescriptionEn' => 'String',
            'strategyCtaLabel' => 'String',
            'strategyCtaLabelEn' => 'String',
            'strategyCtaUrl' => 'String',
            'strategyFocusTitle' => 'String',
            'strategyFocusTitleEn' => 'String',
            'strategyFocusDescription' => 'String',
            'strategyFocusDescriptionEn' => 'String',
            'strategyPrinciples' => ['list_of' => 'AlomarStrategyPrinciple'],
            'portfolioEyebrow' => 'String',
            'portfolioEyebrowEn' => 'String',
            'portfolioTitle' => 'String',
            'portfolioTitleEn' => 'String',
            'portfolioCtaLabel' => 'String',
            'portfolioCtaLabelEn' => 'String',
            'portfolioCtaUrl' => 'String',
            'portfolioItems' => ['list_of' => 'AlomarPortfolioItem'],
            'companiesEyebrow' => 'String',
            'companiesEyebrowEn' => 'String',
            'companiesTitle' => 'String',
            'companiesTitleEn' => 'String',
            'companies' => ['list_of' => 'AlomarPortfolioCompany'],
            'responsibilityEyebrow' => 'String',
            'responsibilityEyebrowEn' => 'String',
            'responsibilityTitle' => 'String',
            'responsibilityTitleEn' => 'String',
            'responsibilityItems' => ['list_of' => 'AlomarResponsibilityItem'],
            'boardEyebrow' => 'String',
            'boardEyebrowEn' => 'String',
            'boardTitle' => 'String',
            'boardTitleEn' => 'String',
            'boardMembers' => ['list_of' => 'AlomarBoardMember'],
            'navigationLinks' => ['list_of' => 'AlomarNavigationLink'],
        ],
        'AlomarVisionSection' => [
            'badgeAr' => 'String',
            'badgeEn' => 'String',
            'titleAr' => 'String',
            'titleEn' => 'String',
            'descriptionAr' => 'String',
            'descriptionEn' => 'String',
            'pillars' => ['list_of' => 'AlomarEditorialPillar'],
            'footerLineAr' => 'String',
            'footerLineEn' => 'String',
            'ctaLabelAr' => 'String',
            'ctaLabelEn' => 'String',
            'ctaUrl' => 'String',
        ],
        'AlomarFooterEditorial' => [
            'companyDescriptionAr' => 'String',
            'companyDescriptionEn' => 'String',
            'visionBadgeAr' => 'String',
            'visionBadgeEn' => 'String',
        ],
        'AlomarSiteContent' => [
            'settings' => 'AlomarSiteSettings',
            'pageBanners' => ['list_of' => 'AlomarPageBanner'],
            'sectionCopy' => ['list_of' => 'AlomarSectionCopy'],
            'homeAbout' => 'AlomarHomeAbout',
            'aboutPage' => 'AlomarAboutPage',
            'visionSection' => 'AlomarVisionSection',
            'footer' => 'AlomarFooterEditorial',
        ],
        'AlomarHomePageSlide' => [
            'image' => 'String',
            'badgeAr' => 'String',
            'badgeEn' => 'String',
            'titleAr' => 'String',
            'titleEn' => 'String',
            'descAr' => 'String',
            'descEn' => 'String',
            'primaryLink' => 'String',
            'secondaryLink' => 'String',
        ],
    ];

    public static function register(): void {
        add_action('graphql_register_types', [self::class, 'register_graphql_types']);
    }

    public static function register_graphql_types(): void {
        if (!function_exists('register_graphql_object_type') || !function_exists('register_graphql_field') || class_exists('Alomar_Site_Content')) {
            return;
        }

        foreach (self::OBJECT_TYPES as $type_name => $fields) {
            $graphql_fields = [];
            foreach ($fields as $field_name => $field_type) {
                $graphql_fields[$field_name] = ['type' => $field_type];
            }
            register_graphql_object_type($type_name, ['fields' => $graphql_fields]);
        }

        register_graphql_field('RootQuery', 'alomarSiteContent', [
            'type' => 'AlomarSiteContent',
            'resolve' => [self::class, 'resolve_site_content'],
        ]);
        register_graphql_field('RootQuery', 'homePageContent', [
            'type' => ['list_of' => 'AlomarHomePageSlide'],
            'resolve' => [self::class, 'resolve_home_page_content'],
        ]);
    }

    public static function resolve_site_content(): array {
        $options = static fn(string $name): array => self::field_group($name, 'option');
        $settings = $options('site_settings');
        $about_page = self::field_group('about_page', self::find_page_id_by_template('page-about-us.php'));
        $about_page = self::map_about_page($about_page);
        $home_about = $options('home_about');
        $vision = $options('vision_section');
        $footer = $options('footer_content');

        return [
            'settings' => self::map_settings($settings),
            'pageBanners' => self::map_rows($options('page_banners'), [
                'pageKey' => 'page_key',
                'badgeAr' => 'badge_ar',
                'badgeEn' => 'badge_en',
                'titleAr' => 'title_ar',
                'titleEn' => 'title_en',
                'descriptionAr' => 'description_ar',
                'descriptionEn' => 'description_en',
                'imageUrl' => 'image',
                'seoTitleAr' => 'seo_title_ar',
                'seoTitleEn' => 'seo_title_en',
                'seoDescriptionAr' => 'seo_description_ar',
                'seoDescriptionEn' => 'seo_description_en',
            ], ['imageUrl' => 'image']),
            'sectionCopy' => self::map_rows($options('section_copy'), [
                'sectionKey' => 'section_key',
                'badgeAr' => 'badge_ar',
                'badgeEn' => 'badge_en',
                'titleAr' => 'title_ar',
                'titleEn' => 'title_en',
                'descriptionAr' => 'description_ar',
                'descriptionEn' => 'description_en',
                'ctaLabelAr' => 'cta_label_ar',
                'ctaLabelEn' => 'cta_label_en',
                'ctaUrl' => 'cta_url',
            ]),
            'homeAbout' => [
                'badgeAr' => $home_about['badge_ar'] ?? null,
                'badgeEn' => $home_about['badge_en'] ?? null,
                'titleAr' => $home_about['title_ar'] ?? null,
                'titleEn' => $home_about['title_en'] ?? null,
                'descriptionOneAr' => $home_about['description_1_ar'] ?? null,
                'descriptionOneEn' => $home_about['description_1_en'] ?? null,
                'descriptionTwoAr' => $home_about['description_2_ar'] ?? null,
                'descriptionTwoEn' => $home_about['description_2_en'] ?? null,
                'imageUrl' => self::image_url($home_about['image'] ?? null),
                'pillars' => self::map_rows(is_array($home_about['pillars'] ?? null) ? $home_about['pillars'] : [], [
                    'icon' => 'icon',
                    'titleAr' => 'title',
                    'titleEn' => 'title_en',
                    'descriptionAr' => 'description',
                    'descriptionEn' => 'description_en',
                ]),
                'sectors' => [
                    'badgeAr' => $home_about['sectors']['badge_ar'] ?? null,
                    'badgeEn' => $home_about['sectors']['badge_en'] ?? null,
                    'titleAr' => $home_about['sectors']['title_ar'] ?? null,
                    'titleEn' => $home_about['sectors']['title_en'] ?? null,
                    'descriptionAr' => $home_about['sectors']['description_ar'] ?? null,
                    'descriptionEn' => $home_about['sectors']['description_en'] ?? null,
                    'items' => array_map(static function (array $item): array {
                        $mapped = self::map_rows([$item], [
                        'titleAr' => 'title_ar',
                        'titleEn' => 'title_en',
                        'descriptionAr' => 'description_ar',
                        'descriptionEn' => 'description_en',
                        'buttonLabelAr' => 'button_label_ar',
                        'buttonLabelEn' => 'button_label_en',
                        'buttonUrl' => 'button_url',
                        'logoUrl' => 'logo',
                        ], ['buttonUrl' => 'link', 'logoUrl' => 'image'])[0];
                        $mapped['tags'] = self::map_rows(is_array($item['tags'] ?? null) ? $item['tags'] : [], [
                            'labelAr' => 'label_ar',
                            'labelEn' => 'label_en',
                            'url' => 'url',
                        ], ['url' => 'link']);

                        if (!$mapped['tags'] && (!empty($mapped['buttonLabelAr']) || !empty($mapped['buttonLabelEn']))) {
                            $mapped['tags'][] = [
                                'labelAr' => $mapped['buttonLabelAr'],
                                'labelEn' => $mapped['buttonLabelEn'],
                                'url' => $mapped['buttonUrl'],
                            ];
                        }

                        return $mapped;
                    }, array_values(array_filter(
                        is_array($home_about['sectors']['items'] ?? null) ? $home_about['sectors']['items'] : [],
                        'is_array'
                    ))),
                ],
            ],
            'aboutPage' => $about_page,
            'visionSection' => [
                'badgeAr' => $vision['badge_ar'] ?? null,
                'badgeEn' => $vision['badge_en'] ?? null,
                'titleAr' => $vision['title_ar'] ?? null,
                'titleEn' => $vision['title_en'] ?? null,
                'descriptionAr' => $vision['description_ar'] ?? null,
                'descriptionEn' => $vision['description_en'] ?? null,
                'pillars' => self::map_rows(is_array($vision['pillars'] ?? null) ? $vision['pillars'] : [], [
                    'icon' => 'icon',
                    'titleAr' => 'title',
                    'titleEn' => 'title_en',
                    'descriptionAr' => 'description',
                    'descriptionEn' => 'description_en',
                ]),
                'footerLineAr' => $vision['footer_line_ar'] ?? null,
                'footerLineEn' => $vision['footer_line_en'] ?? null,
                'ctaLabelAr' => $vision['cta_label_ar'] ?? null,
                'ctaLabelEn' => $vision['cta_label_en'] ?? null,
                'ctaUrl' => self::link_url($vision['cta_url'] ?? null),
            ],
            'footer' => [
                'companyDescriptionAr' => $footer['company_description_ar'] ?? null,
                'companyDescriptionEn' => $footer['company_description_en'] ?? null,
                'visionBadgeAr' => $footer['vision_badge_ar'] ?? null,
                'visionBadgeEn' => $footer['vision_badge_en'] ?? null,
            ],
        ];
    }

    public static function resolve_home_page_content(): array {
        $slides = self::field_group('home_hero_slides', 'option');
        return self::map_rows($slides, [
            'image' => 'image',
            'badgeAr' => 'badge_ar',
            'badgeEn' => 'badge_en',
            'titleAr' => 'title_ar',
            'titleEn' => 'title_en',
            'descAr' => 'desc_ar',
            'descEn' => 'desc_en',
            'primaryLink' => 'primary_link',
            'secondaryLink' => 'secondary_link',
        ], ['image' => 'image']);
    }

    private static function map_settings(array $settings): array {
        $statistics = is_array($settings['statistics'] ?? null) ? $settings['statistics'] : [];
        return [
            'siteNameAr' => $settings['site_name_ar'] ?? null,
            'siteNameEn' => $settings['site_name_en'] ?? null,
            'taglineAr' => $settings['tagline_ar'] ?? null,
            'taglineEn' => $settings['tagline_en'] ?? null,
            'phone' => $settings['phone'] ?? null,
            'email' => $settings['email'] ?? null,
            'addressAr' => $settings['address_ar'] ?? null,
            'addressEn' => $settings['address_en'] ?? null,
            'workingHoursAr' => $settings['working_hours_ar'] ?? null,
            'workingHoursEn' => $settings['working_hours_en'] ?? null,
            'mapLat' => isset($settings['map_lat']) ? (float) $settings['map_lat'] : null,
            'mapLng' => isset($settings['map_lng']) ? (float) $settings['map_lng'] : null,
            'statistics' => self::map_rows($statistics, [
                'key' => 'key',
                'number' => 'number',
                'labelAr' => 'label_ar',
                'labelEn' => 'label_en',
            ]),
            'socialX' => $settings['social_x'] ?? null,
            'socialLinkedin' => $settings['social_linkedin'] ?? null,
            'socialInstagram' => $settings['social_instagram'] ?? null,
        ];
    }

    private static function map_about_page(array $about): array {
        $scalar_fields = [
            'chairmanNameAr' => 'chairman_name',
            'chairmanNameEn' => 'chairman_name_en',
            'chairmanRoleAr' => 'chairman_role',
            'chairmanRoleEn' => 'chairman_role_en',
            'messageHeadingAr' => 'message_heading',
            'messageHeadingEn' => 'message_heading_en',
            'quoteAr' => 'quote',
            'quoteEn' => 'quote_en',
            'messageOneAr' => 'message_one',
            'messageOneEn' => 'message_one_en',
            'messageTwoAr' => 'message_two',
            'messageTwoEn' => 'message_two_en',
            'visionTitleAr' => 'vision_title',
            'visionTitleEn' => 'vision_title_en',
            'visionDescriptionAr' => 'vision_description',
            'visionDescriptionEn' => 'vision_description_en',
            'missionTitleAr' => 'mission_title',
            'missionTitleEn' => 'mission_title_en',
            'missionDescriptionAr' => 'mission_description',
            'missionDescriptionEn' => 'mission_description_en',
            'overviewTitle' => 'overview_title',
            'overviewTitleEn' => 'overview_title_en',
            'overviewDescriptionOne' => 'overview_description_one',
            'overviewDescriptionOneEn' => 'overview_description_one_en',
            'overviewDescriptionTwo' => 'overview_description_two',
            'overviewDescriptionTwoEn' => 'overview_description_two_en',
            'overviewImageOneAlt' => 'overview_image_one_alt',
            'overviewImageOneAltEn' => 'overview_image_one_alt_en',
            'overviewImageTwoAlt' => 'overview_image_two_alt',
            'overviewImageTwoAltEn' => 'overview_image_two_alt_en',
            'strategyEyebrow' => 'strategy_eyebrow',
            'strategyEyebrowEn' => 'strategy_eyebrow_en',
            'strategyTitle' => 'strategy_title',
            'strategyTitleEn' => 'strategy_title_en',
            'strategyDescription' => 'strategy_description',
            'strategyDescriptionEn' => 'strategy_description_en',
            'strategyCtaLabel' => 'strategy_cta_label',
            'strategyCtaLabelEn' => 'strategy_cta_label_en',
            'strategyFocusTitle' => 'strategy_focus_title',
            'strategyFocusTitleEn' => 'strategy_focus_title_en',
            'strategyFocusDescription' => 'strategy_focus_description',
            'strategyFocusDescriptionEn' => 'strategy_focus_description_en',
            'portfolioEyebrow' => 'portfolio_eyebrow',
            'portfolioEyebrowEn' => 'portfolio_eyebrow_en',
            'portfolioTitle' => 'portfolio_title',
            'portfolioTitleEn' => 'portfolio_title_en',
            'portfolioCtaLabel' => 'portfolio_cta_label',
            'portfolioCtaLabelEn' => 'portfolio_cta_label_en',
            'companiesEyebrow' => 'companies_eyebrow',
            'companiesEyebrowEn' => 'companies_eyebrow_en',
            'companiesTitle' => 'companies_title',
            'companiesTitleEn' => 'companies_title_en',
            'responsibilityEyebrow' => 'responsibility_eyebrow',
            'responsibilityEyebrowEn' => 'responsibility_eyebrow_en',
            'responsibilityTitle' => 'responsibility_title',
            'responsibilityTitleEn' => 'responsibility_title_en',
            'boardEyebrow' => 'board_eyebrow',
            'boardEyebrowEn' => 'board_eyebrow_en',
            'boardTitle' => 'board_title',
            'boardTitleEn' => 'board_title_en',
        ];
        $mapped = [];
        foreach ($scalar_fields as $output => $source) {
            $mapped[$output] = $about[$source] ?? null;
        }
        $mapped['chairmanImageUrl'] = self::image_url($about['chairman_image'] ?? null);
        $mapped['overviewImageOneUrl'] = self::image_url($about['overview_image_one'] ?? null);
        $mapped['overviewImageTwoUrl'] = self::image_url($about['overview_image_two'] ?? null);
        $mapped['strategyCtaUrl'] = self::link_url($about['strategy_cta_url'] ?? null);
        $mapped['portfolioCtaUrl'] = self::link_url($about['portfolio_cta_url'] ?? null);
        $mapped['values'] = self::map_rows($about['values'] ?? [], [
            'titleAr' => 'title',
            'titleEn' => 'title_en',
            'descriptionAr' => 'description',
            'descriptionEn' => 'description_en',
        ]);
        $mapped['statistics'] = self::map_rows($about['statistics'] ?? [], [
            'value' => 'value',
            'label' => 'label',
            'labelEn' => 'label_en',
        ]);
        $mapped['strategyPrinciples'] = self::map_rows($about['strategy_principles'] ?? [], [
            'title' => 'title',
            'titleEn' => 'title_en',
            'description' => 'description',
            'descriptionEn' => 'description_en',
        ]);
        $mapped['portfolioItems'] = self::map_rows($about['portfolio_items'] ?? [], [
            'title' => 'title',
            'titleEn' => 'title_en',
            'description' => 'description',
            'descriptionEn' => 'description_en',
            'metric' => 'metric',
        ]);
        $mapped['companies'] = self::map_rows($about['companies'] ?? [], [
            'name' => 'name',
            'nameEn' => 'name_en',
            'description' => 'description',
            'descriptionEn' => 'description_en',
            'logoUrl' => 'logo',
            'imageUrl' => 'image',
            'link' => 'link',
        ], ['logoUrl' => 'image', 'imageUrl' => 'image', 'link' => 'link']);
        $mapped['responsibilityItems'] = self::map_rows($about['responsibility_items'] ?? [], [
            'title' => 'title',
            'titleEn' => 'title_en',
            'description' => 'description',
            'descriptionEn' => 'description_en',
            'imageUrl' => 'image',
        ], ['imageUrl' => 'image']);
        $mapped['boardMembers'] = self::map_rows($about['board_members'] ?? [], [
            'name' => 'name',
            'nameEn' => 'name_en',
            'role' => 'role',
            'roleEn' => 'role_en',
            'imageUrl' => 'image',
        ], ['imageUrl' => 'image']);
        $mapped['navigationLinks'] = self::map_rows($about['navigation_links'] ?? [], [
            'label' => 'label',
            'labelEn' => 'label_en',
            'imageUrl' => 'image',
            'url' => 'url',
        ], ['imageUrl' => 'image', 'url' => 'link']);

        return $mapped;
    }

    private static function map_rows(mixed $rows, array $fields, array $transforms = []): array {
        if (!is_array($rows)) {
            return [];
        }

        $mapped = [];
        foreach ($rows as $row) {
            if (!is_array($row)) {
                continue;
            }
            $item = [];
            foreach ($fields as $output => $source) {
                $value = $row[$source] ?? null;
                $transform = $transforms[$output] ?? null;
                if ($transform === 'image') {
                    $value = self::image_url($value);
                } elseif ($transform === 'link') {
                    $value = self::link_url($value);
                }
                $item[$output] = $value;
            }
            $mapped[] = $item;
        }
        return $mapped;
    }

    private static function field_group(string $field, string|int $post_id): array {
        if (!function_exists('get_field')) {
            return [];
        }
        $value = get_field($field, $post_id);
        return is_array($value) ? $value : [];
    }

    private static function find_page_id_by_template(string $template): int {
        $pages = get_posts([
            'post_type' => 'page',
            'post_status' => ['publish', 'draft', 'private'],
            'numberposts' => 1,
            'meta_key' => '_wp_page_template',
            'meta_value' => $template,
        ]);
        return $pages ? (int) $pages[0]->ID : 0;
    }

    private static function image_url(mixed $image): ?string {
        if (is_array($image)) {
            return is_string($image['url'] ?? null) ? $image['url'] : null;
        }
        if (is_numeric($image)) {
            $url = wp_get_attachment_url((int) $image);
            return is_string($url) ? $url : null;
        }
        return is_string($image) && $image !== '' ? $image : null;
    }

    private static function link_url(mixed $link): ?string {
        if (is_array($link)) {
            $url = $link['url'] ?? null;
            return is_string($url) && $url !== '' ? $url : null;
        }
        return is_string($link) && $link !== '' ? $link : null;
    }
}

Alomar_Theme_Site_Content_GraphQL::register();

<?php
defined('ABSPATH') || exit;

add_action('graphql_register_types', static function (): void {
    if (!function_exists('register_graphql_object_type') || !function_exists('register_graphql_field')) {
        return;
    }

    register_graphql_object_type('AlomarInvestmentStatistic', [
        'fields' => [
            'value' => ['type' => 'String'],
            'labelAr' => ['type' => 'String'],
            'labelEn' => ['type' => 'String'],
        ],
    ]);
    register_graphql_object_type('AlomarInvestmentNavigationLink', [
        'fields' => [
            'labelAr' => ['type' => 'String'],
            'labelEn' => ['type' => 'String'],
            'descriptionAr' => ['type' => 'String'],
            'descriptionEn' => ['type' => 'String'],
            'imageUrl' => ['type' => 'String'],
            'url' => ['type' => 'String'],
        ],
    ]);
    register_graphql_object_type('AlomarInvestmentsPageContent', [
        'fields' => [
            'heroBadgeAr' => ['type' => 'String'],
            'heroBadgeEn' => ['type' => 'String'],
            'heroTitleAr' => ['type' => 'String'],
            'heroTitleEn' => ['type' => 'String'],
            'heroDescriptionAr' => ['type' => 'String'],
            'heroDescriptionEn' => ['type' => 'String'],
            'seoTitleAr' => ['type' => 'String'],
            'seoTitleEn' => ['type' => 'String'],
            'seoDescriptionAr' => ['type' => 'String'],
            'seoDescriptionEn' => ['type' => 'String'],
            'introEyebrowAr' => ['type' => 'String'],
            'introEyebrowEn' => ['type' => 'String'],
            'introHeadingAr' => ['type' => 'String'],
            'introHeadingEn' => ['type' => 'String'],
            'introDescriptionAr' => ['type' => 'String'],
            'introDescriptionEn' => ['type' => 'String'],
            'introImage' => ['type' => 'String'],
            'statistics' => ['type' => ['list_of' => 'AlomarInvestmentStatistic']],
            'portfolioEyebrowAr' => ['type' => 'String'],
            'portfolioEyebrowEn' => ['type' => 'String'],
            'portfolioHeadingAr' => ['type' => 'String'],
            'portfolioHeadingEn' => ['type' => 'String'],
            'portfolioDescriptionAr' => ['type' => 'String'],
            'portfolioDescriptionEn' => ['type' => 'String'],
            'ctaEyebrowAr' => ['type' => 'String'],
            'ctaEyebrowEn' => ['type' => 'String'],
            'ctaHeadingAr' => ['type' => 'String'],
            'ctaHeadingEn' => ['type' => 'String'],
            'ctaDescriptionAr' => ['type' => 'String'],
            'ctaDescriptionEn' => ['type' => 'String'],
            'ctaButtonLabelAr' => ['type' => 'String'],
            'ctaButtonLabelEn' => ['type' => 'String'],
            'ctaUrl' => ['type' => 'String'],
            'navigationLinks' => ['type' => ['list_of' => 'AlomarInvestmentNavigationLink']],
        ],
    ]);

    register_graphql_field('RootQuery', 'alomarInvestmentsPageContent', [
        'type' => 'AlomarInvestmentsPageContent',
        'description' => __('Published Our Investments page content managed with ACF.', 'theme-headless'),
        'resolve' => static function (): ?array {
            if (!function_exists('get_field')) {
                return null;
            }

            $page = get_page_by_path('our-investments', OBJECT, 'page');
            if (!$page instanceof WP_Post || $page->post_status !== 'publish') {
                return null;
            }

            $get = static fn(string $name): mixed => get_field($name, (int) $page->ID);
            $image_url = static function (mixed $image): ?string {
                if (is_array($image)) {
                    $image = $image['url'] ?? null;
                } elseif (is_numeric($image)) {
                    $image = wp_get_attachment_url((int) $image);
                }
                return is_string($image) && $image !== '' ? $image : null;
            };

            $statistics = [];
            $stat_rows = $get('investment_statistics');
            foreach (is_array($stat_rows) ? $stat_rows : [] as $stat) {
                if (!is_array($stat) || empty($stat['stat_value'])) {
                    continue;
                }
                $statistics[] = [
                    'value' => (string) $stat['stat_value'],
                    'labelAr' => $stat['stat_label'] ?? null,
                    'labelEn' => $stat['stat_label_en'] ?? null,
                ];
            }

            $navigation_links = [];
            $link_rows = $get('navigation_links');
            foreach (is_array($link_rows) ? $link_rows : [] as $link) {
                if (!is_array($link) || empty($link['link_url'])) {
                    continue;
                }
                $navigation_links[] = [
                    'labelAr' => $link['link_label'] ?? null,
                    'labelEn' => $link['link_label_en'] ?? null,
                    'descriptionAr' => $link['link_description'] ?? null,
                    'descriptionEn' => $link['link_description_en'] ?? null,
                    'imageUrl' => $image_url($link['link_image'] ?? null),
                    'url' => $link['link_url'],
                ];
            }

            return [
                'heroBadgeAr' => $get('hero_badge'),
                'heroBadgeEn' => $get('hero_badge_en'),
                'heroTitleAr' => $get('hero_title'),
                'heroTitleEn' => $get('hero_title_en'),
                'heroDescriptionAr' => $get('hero_description'),
                'heroDescriptionEn' => $get('hero_description_en'),
                'seoTitleAr' => $get('seo_title'),
                'seoTitleEn' => $get('seo_title_en'),
                'seoDescriptionAr' => $get('seo_description'),
                'seoDescriptionEn' => $get('seo_description_en'),
                'introEyebrowAr' => $get('intro_eyebrow'),
                'introEyebrowEn' => $get('intro_eyebrow_en'),
                'introHeadingAr' => $get('intro_heading'),
                'introHeadingEn' => $get('intro_heading_en'),
                'introDescriptionAr' => $get('intro_description'),
                'introDescriptionEn' => $get('intro_description_en'),
                'introImage' => $image_url($get('intro_image')),
                'statistics' => $statistics,
                'portfolioEyebrowAr' => $get('portfolio_eyebrow'),
                'portfolioEyebrowEn' => $get('portfolio_eyebrow_en'),
                'portfolioHeadingAr' => $get('portfolio_heading'),
                'portfolioHeadingEn' => $get('portfolio_heading_en'),
                'portfolioDescriptionAr' => $get('portfolio_description'),
                'portfolioDescriptionEn' => $get('portfolio_description_en'),
                'ctaEyebrowAr' => $get('cta_eyebrow'),
                'ctaEyebrowEn' => $get('cta_eyebrow_en'),
                'ctaHeadingAr' => $get('cta_heading'),
                'ctaHeadingEn' => $get('cta_heading_en'),
                'ctaDescriptionAr' => $get('cta_description'),
                'ctaDescriptionEn' => $get('cta_description_en'),
                'ctaButtonLabelAr' => $get('cta_button_label'),
                'ctaButtonLabelEn' => $get('cta_button_label_en'),
                'ctaUrl' => $get('cta_url'),
                'navigationLinks' => $navigation_links,
            ];
        },
    ]);
});

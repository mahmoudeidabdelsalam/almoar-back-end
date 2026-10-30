<?php
defined('ABSPATH') || exit;

add_action('graphql_register_types', static function (): void {
    if (!function_exists('register_graphql_object_type') || !function_exists('register_graphql_field')) {
        return;
    }

    register_graphql_object_type('AlomarInvestWithUsStep', [
        'fields' => [
            'titleAr' => ['type' => 'String'],
            'titleEn' => ['type' => 'String'],
            'descriptionAr' => ['type' => 'String'],
            'descriptionEn' => ['type' => 'String'],
        ],
    ]);
    register_graphql_object_type('AlomarInvestWithUsPageContent', [
        'fields' => [
            'heroBadgeAr' => ['type' => 'String'],
            'heroBadgeEn' => ['type' => 'String'],
            'heroTitleAr' => ['type' => 'String'],
            'heroTitleEn' => ['type' => 'String'],
            'heroDescriptionAr' => ['type' => 'String'],
            'heroDescriptionEn' => ['type' => 'String'],
            'heroImage' => ['type' => 'String'],
            'opportunityHeadingAr' => ['type' => 'String'],
            'opportunityHeadingEn' => ['type' => 'String'],
            'opportunityDescriptionAr' => ['type' => 'String'],
            'opportunityDescriptionEn' => ['type' => 'String'],
            'processHeadingAr' => ['type' => 'String'],
            'processHeadingEn' => ['type' => 'String'],
            'processItems' => ['type' => ['list_of' => 'AlomarInvestWithUsStep']],
            'contactHeadingAr' => ['type' => 'String'],
            'contactHeadingEn' => ['type' => 'String'],
            'contactDescriptionAr' => ['type' => 'String'],
            'contactDescriptionEn' => ['type' => 'String'],
            'inquiryFormTitleAr' => ['type' => 'String'],
            'inquiryFormTitleEn' => ['type' => 'String'],
            'inquiryFormSubmitLabelAr' => ['type' => 'String'],
            'inquiryFormSubmitLabelEn' => ['type' => 'String'],
            'investmentFormId' => ['type' => 'String'],
        ],
    ]);

    register_graphql_field('RootQuery', 'alomarInvestWithUsPageContent', [
        'type' => 'AlomarInvestWithUsPageContent',
        'description' => __('Published Invest With Us page content managed with ACF.', 'theme-headless'),
        'resolve' => static function (): ?array {
            if (!function_exists('get_field')) {
                return null;
            }

            $pages = get_posts([
                'post_type' => 'page',
                'post_status' => 'publish',
                'numberposts' => -1,
                'orderby' => 'ID',
                'order' => 'ASC',
            ]);
            $page = null;
            foreach ($pages as $candidate) {
                if ($candidate->post_name === 'invest-with-us' || sanitize_title($candidate->post_title) === 'invest-with-us') {
                    $page = $candidate;
                    break;
                }
            }
            if (!$page) {
                return null;
            }

            $get = static fn(string $name): mixed => get_field($name, (int) $page->ID);

            $image = $get('hero_image');
            if (is_array($image)) {
                $image = $image['url'] ?? null;
            } elseif (is_numeric($image)) {
                $image = wp_get_attachment_url((int) $image);
            }
            $steps = [];
            $process_items = $get('process_items');
            foreach (is_array($process_items) ? $process_items : [] as $step) {
                if (!is_array($step)) {
                    continue;
                }
                $steps[] = [
                    'titleAr' => $step['process_title'] ?? null,
                    'titleEn' => $step['process_title_en'] ?? null,
                    'descriptionAr' => $step['process_description'] ?? null,
                    'descriptionEn' => $step['process_description_en'] ?? null,
                ];
            }
            $form_id = $get('investment_form_id');

            return [
                'heroBadgeAr' => $get('hero_badge'),
                'heroBadgeEn' => $get('hero_badge_en'),
                'heroTitleAr' => $get('hero_title'),
                'heroTitleEn' => $get('hero_title_en'),
                'heroDescriptionAr' => $get('hero_description'),
                'heroDescriptionEn' => $get('hero_description_en'),
                'heroImage' => is_string($image) && $image !== '' ? $image : null,
                'opportunityHeadingAr' => $get('opportunity_heading'),
                'opportunityHeadingEn' => $get('opportunity_heading_en'),
                'opportunityDescriptionAr' => $get('opportunity_description'),
                'opportunityDescriptionEn' => $get('opportunity_description_en'),
                'processHeadingAr' => $get('process_heading'),
                'processHeadingEn' => $get('process_heading_en'),
                'processItems' => $steps,
                'contactHeadingAr' => $get('contact_heading'),
                'contactHeadingEn' => $get('contact_heading_en'),
                'contactDescriptionAr' => $get('contact_description'),
                'contactDescriptionEn' => $get('contact_description_en'),
                'inquiryFormTitleAr' => $get('inquiry_form_title'),
                'inquiryFormTitleEn' => $get('inquiry_form_title_en'),
                'inquiryFormSubmitLabelAr' => $get('inquiry_form_submit_label'),
                'inquiryFormSubmitLabelEn' => $get('inquiry_form_submit_label_en'),
                'investmentFormId' => is_scalar($form_id) && ctype_digit((string) $form_id) && (int) $form_id > 0
                    ? (string) $form_id
                    : null,
            ];
        },
    ]);
});

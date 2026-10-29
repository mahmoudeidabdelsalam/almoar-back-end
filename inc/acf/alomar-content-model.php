<?php
/**
 * Complete Alomar content model for the headless WordPress theme.
 * Existing database values are preserved because all names and keys are new only
 * where no equivalent legacy field already existed.
 */
defined('ABSPATH') || exit;

final class Alomar_Theme_Content_Model {
    public static function init(): void {
        if (!function_exists('acf_add_local_field_group')) {
            return;
        }
        add_action('acf/init', [self::class, 'register_post_type_groups']);
        add_action('admin_init', [self::class, 'migrate_investment_description_fields']);
    }

    public static function migrate_investment_description_fields(): void {
        if (get_option('alomar_investment_description_migration_v1')) {
            return;
        }

        $posts = get_posts([
            'post_type' => 'investments',
            'post_status' => 'any',
            'numberposts' => -1,
            'fields' => 'ids',
        ]);

        foreach ($posts as $post_id) {
            foreach ([null => 'investment_enscription', '_en' => 'investment_enscription_en'] as $suffix => $old_name) {
                $new_name = $suffix === '_en' ? 'investment_description_en' : 'investment_description';
                $old_value = get_post_meta($post_id, $old_name, true);
                if ($old_value !== '' && get_post_meta($post_id, $new_name, true) === '') {
                    if (function_exists('update_field')) {
                        update_field($new_name, $old_value, $post_id);
                    } else {
                        update_post_meta($post_id, $new_name, $old_value);
                    }
                }
            }
        }

        update_option('alomar_investment_description_migration_v1', 1);
    }

    private static function field(string $key, string $name, string $label, string $type = 'text', array $settings = []): array {
        return array_merge([
            'key' => $key,
            'name' => $name,
            'label' => $label,
            'type' => $type,
            'show_in_graphql' => true,
        ], $settings);
    }

    private static function localized(string $baseKey, string $baseName, string $label, string $type = 'text', array $settings = []): array {
        return [
            self::field('field_alomar_' . $baseKey, $baseName, $label . ' (Arabic)', $type, $settings),
            self::field('field_alomar_' . $baseKey . '_en', $baseName . '_en', $label . ' (English)', $type, $settings),
        ];
    }


    public static function register_post_type_groups(): void {
        acf_add_local_field_group([
            'key' => 'group_alomar_investment_entails_v2',
            'title' => 'Alomar Investment Details',
            'show_in_graphql' => true,
            'location' => [[['param' => 'post_type', 'operator' => '==', 'value' => 'investments']]],
            'fields' => array_merge(
                self::localized('investment_summary', 'investment_summary', 'Summary', 'textarea', ['rows' => 3]),
                self::localized('investment_enscription', 'investment_description', 'Description', 'wysiwyg'),
                [
                    self::field('field_alomar_investment_logo', 'investment_logo', 'Investment Logo', 'image', ['return_format' => 'array']),
                    self::field('field_alomar_investment_featured_image', 'investment_featured_image', 'Alternate Featured Image', 'image', ['return_format' => 'array']),
                    self::field('field_alomar_investment_sector', 'investment_sector', 'Sector', 'taxonomy', ['taxonomy' => 'investment_category', 'field_type' => 'select', 'return_format' => 'id']),
                    self::field('field_alomar_investment_location', 'investment_location', 'Location (Arabic)'),
                    self::field('field_alomar_investment_location_en', 'investment_location_en', 'Location (English)'),
                    self::field('field_alomar_investment_status', 'investment_status', 'Status (Arabic)'),
                    self::field('field_alomar_investment_status_en', 'investment_status_en', 'Status (English)'),
                    self::field('field_alomar_investment_website', 'investment_website', 'Website', 'url'),
                    self::field('field_alomar_investment_gallery', 'investment_gallery', 'Gallery', 'gallery', ['return_format' => 'array']),
                    self::field('field_alomar_investment_statistics', 'investment_statistics', 'Statistics', 'repeater', ['layout' => 'table', 'sub_fields' => array_merge(self::localized('investment_stat_label', 'label', 'Label'), [
                        self::field('field_alomar_investment_stat_value', 'value', 'Value'),
                    ])]),
                    self::field('field_alomar_investment_related', 'related_investments', 'Related Investments', 'relationship', ['post_type' => ['investments'], 'return_format' => 'object']),
                ]
            ),
        ]);

        acf_add_local_field_group([
            'key' => 'group_alomar_media_center_item',
            'title' => 'Alomar Media Center Item',
            'show_in_graphql' => true,
            'location' => [[['param' => 'post_type', 'operator' => '==', 'value' => 'media-center']]],
            'fields' => array_merge(
                self::localized('media_summary', 'media_summary', 'Summary', 'textarea', ['rows' => 3]),
                self::localized('media_content', 'media_content', 'Content', 'wysiwyg'),
                [
                    self::field('field_alomar_media_type', 'media_type', 'Content Type', 'select', ['choices' => ['press_release' => 'Press Release', 'video' => 'Video', 'gallery' => 'Gallery', 'download' => 'Download', 'report' => 'Report']]),
                    self::field('field_alomar_media_publication_date', 'publication_date', 'Publication Date', 'date_picker', ['display_format' => 'd/m/Y', 'return_format' => 'Y-m-d']),
                    self::field('field_alomar_media_video_url', 'video_url', 'Video URL', 'url'),
                    self::field('field_alomar_media_document', 'document', 'Downloadable Document', 'file', ['return_format' => 'array']),
                    self::field('field_alomar_media_external_url', 'external_media_url', 'External Media URL', 'url'),
                    self::field('field_alomar_media_gallery', 'media_gallery', 'Gallery', 'gallery', ['return_format' => 'array']),
                    self::field('field_alomar_media_related', 'related_media', 'Related Media', 'relationship', ['post_type' => ['media-center'], 'return_format' => 'object']),
                ]
            ),
        ]);

        acf_add_local_field_group([
            'key' => 'group_alomar_news_article_v2',
            'title' => 'Alomar News Article Details',
            'show_in_graphql' => true,
            'location' => [[['param' => 'post_type', 'operator' => '==', 'value' => 'news']]],
            'fields' => array_merge(
                self::localized('news_summary', 'news_summary', 'Summary', 'textarea', ['rows' => 3]),
                self::localized('news_content', 'news_content', 'Article Content', 'wysiwyg'),
                [
                    self::field('field_alomar_news_author', 'news_author', 'Author (Arabic)'),
                    self::field('field_alomar_news_author_en', 'news_author_en', 'Author (English)'),
                    self::field('field_alomar_news_read_time', 'read_time_minutes', 'Estimated Reading Time (Minutes)', 'number'),
                    self::field('field_alomar_news_gallery', 'news_gallery', 'Article Gallery', 'gallery', ['return_format' => 'array']),
                    self::field('field_alomar_news_related', 'related_articles', 'Related Articles', 'relationship', ['post_type' => ['news', 'post'], 'return_format' => 'object']),
                ]
            ),
        ]);
    }
}

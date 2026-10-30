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

}

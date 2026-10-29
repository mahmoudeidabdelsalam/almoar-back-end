<?php
/**
 * WP — Footer Settings (ACF Options Page)
 *
 * Mirrors the existing `headerSettings` pattern inferred from the
 * uploaded `queries/header.ts` (a root-level GraphQL field backed by
 * an ACF Options Page, not tied to a specific post/page). Exposes a
 * `footerSettings { footerFields { ... } }` root field via WPGraphQL.
 *
 * ASSUMPTION: the exact options-page registration for `headerSettings`
 * wasn't available to inspect (only its GraphQL query was uploaded),
 * so the shape/naming here is inferred to match it as closely as
 * possible. If the real header options page differs (e.g. a shared
 * "Theme Options" page with multiple field groups instead of one
 * page per section), move this field group onto that same options
 * page instead of registering a new one.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'acf/init', function () {

	if ( ! function_exists( 'acf_add_options_page' ) || ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_options_page( array(
		'page_title'        => 'Footer',
		'menu_title'        => 'Footer',
		'menu_slug'         => 'WP-footer-settings',
		'capability'        => 'edit_posts',
		'redirect'          => false,
		'show_in_graphql'   => true,
		'graphql_field_name' => 'footerSettings',
		'position'          => 3,
	) );

	acf_add_local_field_group( array(
		'key'               => 'group_wp_footer',
		'title'             => 'Footer Fields',
		'show_in_graphql'   => true,
		'graphql_type_name' => 'WPFooterFields',
		'graphql_field_name' => 'footerFields',
		'location'          => array(
			array(
				array(
					'param'    => 'options_page',
					'operator' => '==',
					'value'    => 'WP-footer-settings',
				),
			),
		),
		'fields' => array(

			array(
				'key'   => 'field_wp_footer_logo',
				'label' => 'Logo',
				'name'  => 'footer_logo',
				'type'  => 'image',
				'return_format' => 'id',
			),

			array(
				'key'          => 'field_wp_footer_social_links',
				'label'        => 'Social Links',
				'name'         => 'social_links',
				'type'         => 'repeater',
				'layout'       => 'table',
				'button_label' => 'Add Social Link',
				'sub_fields'   => array(
					array(
						'key'     => 'field_wp_social_platform',
						'label'   => 'Platform',
						'name'    => 'platform',
						'type'    => 'select',
						'choices' => array(
							'linkedin' => 'LinkedIn',
							'twitter'  => 'Twitter / X',
						),
					),
					array(
						'key'   => 'field_wp_social_link',
						'label' => 'Link',
						'name'  => 'social_link',
						'type'  => 'link',
					),
				),
			),

			array(
				'key'          => 'field_wp_footer_columns',
				'label'        => 'Link Columns',
				'name'         => 'columns',
				'type'         => 'repeater',
				'layout'       => 'block',
				'button_label' => 'Add Column',
				'instructions' => 'e.g. "Explore pages", "WP"',
				'sub_fields'   => array(
					array(
						'key'   => 'field_wp_column_title',
						'label' => 'Column Title',
						'name'  => 'column_title',
						'type'  => 'text',
					),
					array(
						'key'   => 'field_wp_column_title_en',
						'label' => 'Column Title (English)',
						'name'  => 'column_title_en',
						'type'  => 'text',
					),
					array(
						'key'          => 'field_wp_column_links',
						'label'        => 'Links',
						'name'         => 'links',
						'type'         => 'repeater',
						'layout'       => 'table',
						'button_label' => 'Add Link',
						'sub_fields'   => array(
							array(
								'key'   => 'field_wp_column_link',
								'label' => 'Link',
								'name'  => 'column_link',
								'type'  => 'link',
							),
							array(
								'key'   => 'field_wp_column_link_en',
								'label' => 'Link (English)',
								'name'  => 'column_link_en',
								'type'  => 'link',
							),
							array(
								'key'   => 'field_wp_column_link_icon',
								'label' => 'Icon',
								'name'  => 'column_link_icon',
								'type'  => 'image',
								'return_format' => 'id',
							),
						),
					),
				),
			),

			array(
				'key'   => 'field_wp_copyright_text',
				'label' => 'Copyright Text',
				'name'  => 'copyright_text',
				'type'  => 'text',
				'instructions' => 'e.g. "All rights reserved © 2025"',
			),

			array(
				'key'   => 'field_wp_copyright_text_en',
				'label' => 'Copyright Text (English)',
				'name'  => 'copyright_text_en',
				'type'  => 'text',
			),

		),
	) );

} );

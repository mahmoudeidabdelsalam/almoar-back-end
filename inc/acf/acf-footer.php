<?php
/**
 * Erbify — Footer Settings (ACF Options Page)
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
		'menu_slug'         => 'erbify-footer-settings',
		'capability'        => 'edit_posts',
		'redirect'          => false,
		'show_in_graphql'   => true,
		'graphql_field_name' => 'footerSettings',
		'position'          => 3,
	) );

	acf_add_local_field_group( array(
		'key'               => 'group_erbify_footer',
		'title'             => 'Footer Fields',
		'show_in_graphql'   => true,
		'graphql_type_name' => 'ErbifyFooterFields',
		'graphql_field_name' => 'footerFields',
		'location'          => array(
			array(
				array(
					'param'    => 'options_page',
					'operator' => '==',
					'value'    => 'erbify-footer-settings',
				),
			),
		),
		'fields' => array(

			array(
				'key'   => 'field_erbify_footer_logo',
				'label' => 'Logo',
				'name'  => 'footer_logo',
				'type'  => 'image',
				'return_format' => 'id',
			),

			array(
				'key'          => 'field_erbify_footer_social_links',
				'label'        => 'Social Links',
				'name'         => 'social_links',
				'type'         => 'repeater',
				'layout'       => 'table',
				'button_label' => 'Add Social Link',
				'sub_fields'   => array(
					array(
						'key'     => 'field_erbify_social_platform',
						'label'   => 'Platform',
						'name'    => 'platform',
						'type'    => 'select',
						'choices' => array(
							'linkedin' => 'LinkedIn',
							'twitter'  => 'Twitter / X',
						),
					),
					array(
						'key'   => 'field_erbify_social_link',
						'label' => 'Link',
						'name'  => 'social_link',
						'type'  => 'link',
					),
				),
			),

			array(
				'key'          => 'field_erbify_footer_columns',
				'label'        => 'Link Columns',
				'name'         => 'columns',
				'type'         => 'repeater',
				'layout'       => 'block',
				'button_label' => 'Add Column',
				'instructions' => 'e.g. "Explore pages", "Erbify"',
				'sub_fields'   => array(
					array(
						'key'   => 'field_erbify_column_title',
						'label' => 'Column Title',
						'name'  => 'column_title',
						'type'  => 'text',
					),
					array(
						'key'   => 'field_erbify_column_title_de',
						'label' => 'Column Title (German)',
						'name'  => 'column_title_de',
						'type'  => 'text',
					),
					array(
						'key'          => 'field_erbify_column_links',
						'label'        => 'Links',
						'name'         => 'links',
						'type'         => 'repeater',
						'layout'       => 'table',
						'button_label' => 'Add Link',
						'sub_fields'   => array(
							array(
								'key'   => 'field_erbify_column_link',
								'label' => 'Link',
								'name'  => 'column_link',
								'type'  => 'link',
							),
							array(
								'key'   => 'field_erbify_column_link_de',
								'label' => 'Link (German)',
								'name'  => 'column_link_de',
								'type'  => 'link',
							),
						),
					),
				),
			),

			array(
				'key'   => 'field_erbify_newsletter_title',
				'label' => 'Newsletter Title',
				'name'  => 'newsletter_title',
				'type'  => 'text',
				'default_value' => 'Subscribe to the Erbify newsletter',
			),
			array(
				'key'   => 'field_erbify_newsletter_title_de',
				'label' => 'Newsletter Title (German)',
				'name'  => 'newsletter_title_de',
				'type'  => 'text',
				'default_value' => 'Abonnieren Sie den Erbify-Newsletter',
			),
			array(
				'key'   => 'field_erbify_newsletter_description',
				'label' => 'Newsletter Description',
				'name'  => 'newsletter_description',
				'type'  => 'text',
				'default_value' => 'Top news delivered directly to your email daily.',
			),
			array(
				'key'   => 'field_erbify_newsletter_description_de',
				'label' => 'Newsletter Description (German)',
				'name'  => 'newsletter_description_de',
				'type'  => 'text',
				'default_value' => 'Die wichtigsten Neuigkeiten direkt täglich per E-Mail.',
			),
			array(
				'key'   => 'field_erbify_newsletter_placeholder',
				'label' => 'Newsletter Input Placeholder',
				'name'  => 'newsletter_placeholder',
				'type'  => 'text',
				'default_value' => 'Your email here',
			),
			array(
				'key'   => 'field_erbify_newsletter_placeholder_de',
				'label' => 'Newsletter Input Placeholder (German)',
				'name'  => 'newsletter_placeholder_de',
				'type'  => 'text',
				'default_value' => 'Ihre E-Mail-Adresse',
			),
			array(
				'key'   => 'field_erbify_newsletter_button_label',
				'label' => 'Newsletter Button Label',
				'name'  => 'newsletter_button_label',
				'type'  => 'text',
				'default_value' => 'Subscribe',
			),
			array(
				'key'   => 'field_erbify_newsletter_button_label_de',
				'label' => 'Newsletter Button Label (German)',
				'name'  => 'newsletter_button_label_de',
				'type'  => 'text',
				'default_value' => 'Abonnieren',
			),

			array(
				'key'          => 'field_erbify_legal_links',
				'label'        => 'Legal Links',
				'name'         => 'legal_links',
				'type'         => 'repeater',
				'layout'       => 'table',
				'button_label' => 'Add Legal Link',
				'instructions' => 'e.g. Privacy policy, Terms and conditions',
				'sub_fields'   => array(
					array(
						'key'   => 'field_erbify_legal_link',
						'label' => 'Link',
						'name'  => 'legal_link',
						'type'  => 'link',
					),
					array(
						'key'   => 'field_erbify_legal_link_de',
						'label' => 'Link (German)',
						'name'  => 'legal_link_de',
						'type'  => 'link',
					),
				),
			),

			array(
				'key'   => 'field_erbify_copyright_text',
				'label' => 'Copyright Text',
				'name'  => 'copyright_text',
				'type'  => 'text',
				'instructions' => 'e.g. "All rights reserved © 2025"',
			),
			array(
				'key'   => 'field_erbify_copyright_text_de',
				'label' => 'Copyright Text (German)',
				'name'  => 'copyright_text_de',
				'type'  => 'text',
			),

		),
	) );

} );

<?php
/**
 * ERBIFY — Header Settings (ACF Options Page)
 *
 * Matches the EXISTING GraphQL query already used by the frontend
 * (see queries/header.ts, uploaded by the project):
 *
 *   headerSettings {
 *     headerFields {
 *       logo { node { sourceUrl } }
 *       menu {
 *         label
 *         link { url }
 *         submenu { label link { url } }
 *       }
 *       labelButtonRight
 *       linkButtonRight { url }
 *     }
 *   }
 *
 * NOTE: this is a global Options Page (not tied to a specific page),
 * since `headerSettings` is a root query field, not something nested
 * under `page`.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'acf/init', function () {

	if ( ! function_exists( 'acf_add_options_page' ) || ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_options_page( array(
		'page_title'         => 'Header',
		'menu_title'         => 'Header',
		'menu_slug'          => 'header-settings',
		'capability'         => 'edit_posts',
		'redirect'           => false,
		'show_in_graphql'    => true,
		'graphql_field_name' => 'headerSettings',
		'position'           => 2,
	) );

	acf_add_local_field_group( array(
		'key'                => 'group_erbify_header',
		'title'              => 'Header Fields',
		'show_in_graphql'    => true,
		'graphql_field_name' => 'headerFields',
		'location'           => array(
			array(
				array(
					'param'    => 'options_page',
					'operator' => '==',
					'value'    => 'header-settings',
				),
			),
		),
		'fields' => array(
			array(
				'key'           => 'field_erbify_header_logo',
				'label'         => 'Logo',
				'name'          => 'logo',
				'type'          => 'image',
				'return_format' => 'id',
			),
			array(
				'key'          => 'field_erbify_header_menu',
				'label'        => 'Menu',
				'name'         => 'menu',
				'type'         => 'repeater',
				'layout'       => 'block',
				'button_label' => 'Add Menu Item',
				'sub_fields'   => array(
					array(
						'key'   => 'field_erbify_menu_label',
						'label' => 'Label',
						'name'  => 'label',
						'type'  => 'text',
					),
					array(
						'key'   => 'field_erbify_menu_label_de',
						'label' => 'Label (German)',
						'name'  => 'label_de',
						'type'  => 'text',
					),
					array(
						'key'   => 'field_erbify_menu_link',
						'label' => 'Link',
						'name'  => 'link',
						'type'  => 'link',
					),
					array(
						'key'          => 'field_erbify_menu_submenu',
						'label'        => 'Submenu',
						'name'         => 'submenu',
						'type'         => 'repeater',
						'layout'       => 'table',
						'button_label' => 'Add Submenu Item',
						'sub_fields'   => array(
							array(
								'key'   => 'field_erbify_submenu_label',
								'label' => 'Label',
								'name'  => 'label',
								'type'  => 'text',
							),
									array(
										'key'   => 'field_erbify_submenu_label_de',
										'label' => 'Label (German)',
										'name'  => 'label_de',
										'type'  => 'text',
									),
							array(
								'key'   => 'field_erbify_submenu_link',
								'label' => 'Link',
								'name'  => 'link',
								'type'  => 'link',
							),
						),
					),
				),
			),
			array(
				'key'   => 'field_erbify_header_label_button_right',
				'label' => 'Right Button Label',
				'name'  => 'label_button_right',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_erbify_header_label_button_right_de',
				'label' => 'Right Button Label (German)',
				'name'  => 'label_button_right_de',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_erbify_header_link_button_right',
				'label' => 'Right Button Link',
				'name'  => 'link_button_right',
				'type'  => 'link',
			),
		),
	) );

} );

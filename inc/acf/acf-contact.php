<?php
/**
 * WP — Contact page fields.
 *
 * The page is rendered by the headless Next.js frontend. WordPress stores
 * the editable contact details and exposes them through WPGraphQL.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'acf/init', function () {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group( array(
		'key'                => 'group_wp_contact_page',
		'title'              => 'WP — Contact Page',
		'show_in_graphql'    => true,
		'graphql_type_name'  => 'WPContactPage',
		'graphql_field_name' => 'contactPage',
		'location'           => array(
			array(
				array(
					'param'    => 'page_template',
					'operator' => '==',
					'value'    => 'page-contact-us.php',
				),
			),
		),
		'fields' => array(
			array(
				'key'           => 'field_wp_contact_page_badge',
				'label'         => 'Page Badge',
				'name'          => 'contact_badge',
				'type'          => 'text',
			),
			array(
				'key'   => 'field_wp_contact_page_badge_en',
				'label' => 'Page Badge (English)',
				'name'  => 'contact_badge_en',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_wp_contact_page_title',
				'label' => 'Page Title',
				'name'  => 'contact_page_title',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_wp_contact_page_title_en',
				'label' => 'Page Title (English)',
				'name'  => 'contact_page_title_en',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_wp_contact_page_description',
				'label' => 'Page Description',
				'name'  => 'contact_page_description',
				'type'  => 'textarea',
				'rows'  => 3,
			),
			array(
				'key'   => 'field_wp_contact_page_description_en',
				'label' => 'Page Description (English)',
				'name'  => 'contact_page_description_en',
				'type'  => 'textarea',
				'rows'  => 3,
			),
			array(
				'key'   => 'field_wp_contact_page_banner_image',
				'label' => 'Page Banner Image',
				'name'  => 'contact_page_banner_image',
				'type'  => 'image',
				'return_format' => 'array',
			),
			array(
				'key'           => 'field_wp_contact_page_heading',
				'label'         => 'Heading',
				'name'          => 'contact_heading',
				'type'          => 'textarea',
				'rows'          => 2,
				'default_value' => 'Have a question? Want to partner with us?',
			),
			array(
				'key'           => 'field_wp_contact_page_heading_en',
				'label'         => 'Heading (English)',
				'name'          => 'contact_heading_en',
				'type'          => 'textarea',
				'rows'          => 2,
				'default_value' => 'Have a question? Want to partner with us?',
			),
			array(
				'key'   => 'field_wp_contact_page_email',
				'label' => 'Email',
				'name'  => 'contact_email',
				'type'  => 'email',
			),
			array(
				'key'   => 'field_wp_contact_page_phone',
				'label' => 'Phone',
				'name'  => 'contact_phone',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_wp_contact_page_address',
				'label' => 'Address',
				'name'  => 'contact_address',
				'type'  => 'textarea',
				'rows'  => 2,
			),
			array(
				'key'   => 'field_wp_contact_page_address_en',
				'label' => 'Address (English)',
				'name'  => 'contact_address_en',
				'type'  => 'textarea',
				'rows'  => 2,
			),
			array(
				'key'   => 'field_wp_contact_page_hours',
				'label' => 'Working Hours',
				'name'  => 'contact_hours',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_wp_contact_page_hours_en',
				'label' => 'Working Hours (English)',
				'name'  => 'contact_hours_en',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_wp_contact_page_map_lat',
				'label' => 'Map Latitude',
				'name'  => 'contact_map_lat',
				'type'  => 'number',
			),
			array(
				'key'   => 'field_wp_contact_page_map_lng',
				'label' => 'Map Longitude',
				'name'  => 'contact_map_lng',
				'type'  => 'number',
			),
			array(
				'key'   => 'field_wp_contact_page_location',
				'label' => 'Location',
				'name'  => 'contact_location',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_wp_contact_page_location_en',
				'label' => 'Location (English)',
				'name'  => 'contact_location_en',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_wp_contact_page_linkedin',
				'label' => 'LinkedIn Link',
				'name'  => 'contact_linkedin',
				'type'  => 'link',
			),
			array(
				'key'   => 'field_wp_contact_page_twitter',
				'label' => 'Twitter / X Link',
				'name'  => 'contact_twitter',
				'type'  => 'link',
			),
			array(
				'key'           => 'field_wp_contact_page_form_title',
				'label'         => 'Form Title',
				'name'          => 'contact_form_title',
				'type'          => 'text',
				'default_value' => 'أو املأ النموذج أدناه:',
			),
			array(
				'key'           => 'field_wp_contact_page_form_title_en',
				'label'         => 'Form Title (English)',
				'name'          => 'contact_form_title_en',
				'type'          => 'text',
				'default_value' => 'Or fill out the form below:',
			),
		),
	) );
} );
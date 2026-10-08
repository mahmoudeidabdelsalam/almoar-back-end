<?php
/**
 * ERBIFY — Contact page fields.
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
		'key'                => 'group_erbify_contact_page',
		'title'              => 'ERBIFY — Contact Page',
		'show_in_graphql'    => true,
		'graphql_type_name'  => 'ErbifyContactPage',
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
				'key'           => 'field_erbify_contact_page_heading',
				'label'         => 'Heading',
				'name'          => 'contact_heading',
				'type'          => 'textarea',
				'rows'          => 2,
				'default_value' => 'Have a question? Want to partner with us?',
			),
			array(
				'key'           => 'field_erbify_contact_page_heading_de',
				'label'         => 'Heading (German)',
				'name'          => 'contact_heading_de',
				'type'          => 'textarea',
				'rows'          => 2,
				'default_value' => 'Haben Sie eine Frage? Möchten Sie mit uns zusammenarbeiten?',
			),
			array(
				'key'   => 'field_erbify_contact_page_email',
				'label' => 'Email',
				'name'  => 'contact_email',
				'type'  => 'email',
			),
			array(
				'key'   => 'field_erbify_contact_page_location',
				'label' => 'Location',
				'name'  => 'contact_location',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_erbify_contact_page_location_de',
				'label' => 'Location (German)',
				'name'  => 'contact_location_de',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_erbify_contact_page_linkedin',
				'label' => 'LinkedIn Link',
				'name'  => 'contact_linkedin',
				'type'  => 'link',
			),
			array(
				'key'   => 'field_erbify_contact_page_twitter',
				'label' => 'Twitter / X Link',
				'name'  => 'contact_twitter',
				'type'  => 'link',
			),
			array(
				'key'           => 'field_erbify_contact_page_form_title',
				'label'         => 'Form Title',
				'name'          => 'contact_form_title',
				'type'          => 'text',
				'default_value' => 'Or fill out the form below:',
			),
			array(
				'key'           => 'field_erbify_contact_page_form_title_de',
				'label'         => 'Form Title (German)',
				'name'          => 'contact_form_title_de',
				'type'          => 'text',
				'default_value' => 'Oder füllen Sie das Formular unten aus:',
			),
		),
	) );
} );
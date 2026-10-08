<?php
/**
 * ERBIFY — Home Page ACF Field Group
 *
 * Registers all editable content for the Erbify home page via
 * acf_add_local_field_group() and exposes it to WPGraphQL as
 * `page.erbifyHomePage`.
 *
 * ASSUMPTION: since the target WordPress project/theme could not be
 * inspected, the location rule below targets the site's Front Page
 * (Settings → Reading → "A static page" → Homepage). Adjust the
 * `location` array to match the actual project (e.g. a specific page
 * template or page ID) if this assumption is wrong.
 *
 * Navbar and Footer content are intentionally NOT included here —
 * per the existing project structure (see `headerSettings` /
 * `services/header.ts`), navigation and site-wide chrome are managed
 * as separate global settings, not as part of the home page fields.
 *
 * Copy this file into the WordPress theme/plugin (e.g. inc/acf/ or
 * wherever the project already registers PHP-based ACF fields) and
 * make sure it is loaded on `acf/init`.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'acf/init', function () {

	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group( array(
		'key'               => 'group_erbify_home',
		'title'             => 'ERBIFY — Home Page',
		'show_in_graphql'   => true,
		'graphql_type_name' => 'ErbifyHomePage',
		'graphql_field_name' => 'erbifyHomePage',
		'location'          => array(
			array(
				array(
					'param'    => 'page_type',
					'operator' => '==',
					'value'    => 'front_page',
				),
			),
		),
		'fields' => array(

			// ==========================================================
			// HERO SECTION
			// ==========================================================
			array(
				'key'               => 'field_erbify_hero',
				'label'             => 'Hero Section',
				'name'              => 'hero',
				'type'              => 'group',
				'show_in_graphql'   => true,
				'graphql_field_name' => 'hero',
				'sub_fields'        => array(
					array(
						'key'   => 'field_erbify_hero_title',
						'label' => 'Title',
						'name'  => 'hero_title',
						'type'  => 'text',
						'default_value' => 'Plan Your Well Simply, Securely, Legally',
					),
					array(
						'key'   => 'field_erbify_hero_title_de',
						'label' => 'Title (German)',
						'name'  => 'hero_title_de',
						'type'  => 'text',
						'default_value' => 'Planen Sie Ihre Wohlstand einfach, sicher und rechtlich korrekt',
					),
					array(
						'key'   => 'field_erbify_hero_description',
						'label' => 'Description',
						'name'  => 'hero_description',
						'type'  => 'textarea',
						'rows'  => 3,
					),
					array(
						'key'   => 'field_erbify_hero_description_de',
						'label' => 'Description (German)',
						'name'  => 'hero_description_de',
						'type'  => 'textarea',
						'rows'  => 3,
					),
					array(
						'key'   => 'field_erbify_hero_image',
						'label' => 'Hero Image',
						'name'  => 'hero_image',
						'type'  => 'image',
						'return_format' => 'id',
					),
					array(
						'key'   => 'field_erbify_hero_bg_image',
						'label' => 'Hero BG Image',
						'name'  => 'hero_bg_image',
						'type'  => 'image',
						'return_format' => 'id',
					),
					array(
						'key'   => 'field_erbify_hero_cta',
						'label' => 'CTA Button',
						'name'  => 'hero_cta',
						'type'  => 'link',
					),
					array(
						'key'   => 'field_erbify_hero_cta_de',
						'label' => 'CTA Button (German)',
						'name'  => 'hero_cta_de',
						'type'  => 'link',
					),
				),
			),

			// ==========================================================
			// WHY ERBIFY / BENEFITS
			// ==========================================================
			array(
				'key'               => 'field_erbify_benefits_section',
				'label'             => 'Benefits Section',
				'name'              => 'benefits_section',
				'type'              => 'group',
				'show_in_graphql'   => true,
				'graphql_field_name' => 'benefitsSection',
				'sub_fields'        => array(
					array(
						'key'   => 'field_erbify_benefits_title',
						'label' => 'Title',
						'name'  => 'benefits_title',
						'type'  => 'text',
						'default_value' => 'Discover the benefits of Erbify',
					),
					array(
						'key'   => 'field_erbify_benefits_title_de',
						'label' => 'Title (German)',
						'name'  => 'benefits_title_de',
						'type'  => 'text',
						'default_value' => 'Entdecken Sie die Vorteile von Erbify',
					),
					array(
						'key'          => 'field_erbify_benefits',
						'label'        => 'Benefits',
						'name'         => 'benefits',
						'type'         => 'repeater',
						'layout'       => 'block',
						'button_label' => 'Add Benefit',
						'sub_fields'   => array(
							array(
								'key'   => 'field_erbify_benefit_icon',
								'label' => 'Icon',
								'name'  => 'benefit_icon',
								'type'  => 'image',
								'return_format' => 'id',
							),
							array(
								'key'   => 'field_erbify_benefit_title',
								'label' => 'Title',
								'name'  => 'benefit_title',
								'type'  => 'text',
							),
									array(
										'key'   => 'field_erbify_benefit_title_de',
										'label' => 'Title (German)',
										'name'  => 'benefit_title_de',
										'type'  => 'text',
									),
							array(
								'key'   => 'field_erbify_benefit_description',
								'label' => 'Description',
								'name'  => 'benefit_description',
								'type'  => 'textarea',
								'rows'  => 2,
							),
									array(
										'key'   => 'field_erbify_benefit_description_de',
										'label' => 'Description (German)',
										'name'  => 'benefit_description_de',
										'type'  => 'textarea',
										'rows'  => 2,
									),
						),
					),
				),
			),

			// ==========================================================
			// HOW IT WORKS
			// ==========================================================
			array(
				'key'               => 'field_erbify_how_it_works',
				'label'             => 'How It Works Section',
				'name'              => 'how_it_works',
				'type'              => 'group',
				'show_in_graphql'   => true,
				'graphql_field_name' => 'howItWorks',
				'sub_fields'        => array(
					array(
						'key'   => 'field_erbify_hiw_title',
						'label' => 'Title',
						'name'  => 'how_it_works_title',
						'type'  => 'text',
						'default_value' => 'How It Works',
					),
					array(
						'key'   => 'field_erbify_hiw_title_de',
						'label' => 'Title (German)',
						'name'  => 'how_it_works_title_de',
						'type'  => 'text',
						'default_value' => 'So funktioniert es',
					),
					array(
						'key'   => 'field_erbify_hiw_background',
						'label' => 'Background Image',
						'name'  => 'how_it_works_background',
						'type'  => 'image',
						'return_format' => 'id',
					),
					array(
						'key'          => 'field_erbify_hiw_steps',
						'label'        => 'Steps',
						'name'         => 'steps',
						'type'         => 'repeater',
						'layout'       => 'block',
						'button_label' => 'Add Step',
						'sub_fields'   => array(
							array(
								'key'   => 'field_erbify_step_label',
								'label' => 'Step Label',
								'name'  => 'step_label',
								'type'  => 'text',
								'instructions' => 'e.g. "Step 1"',
							),
									array(
										'key'   => 'field_erbify_step_label_de',
										'label' => 'Step Label (German)',
										'name'  => 'step_label_de',
										'type'  => 'text',
									),
							array(
								'key'   => 'field_erbify_step_title',
								'label' => 'Step Title',
								'name'  => 'step_title',
								'type'  => 'text',
							),
									array(
										'key'   => 'field_erbify_step_title_de',
										'label' => 'Step Title (German)',
										'name'  => 'step_title_de',
										'type'  => 'text',
									),
							array(
								'key'   => 'field_erbify_step_description',
								'label' => 'Step Description',
								'name'  => 'step_description',
								'type'  => 'textarea',
								'rows'  => 2,
							),
									array(
										'key'   => 'field_erbify_step_description_de',
										'label' => 'Step Description (German)',
										'name'  => 'step_description_de',
										'type'  => 'textarea',
										'rows'  => 2,
									),
						),
					),
					array(
						'key'   => 'field_erbify_hiw_cta',
						'label' => 'CTA Button',
						'name'  => 'how_it_works_cta',
						'type'  => 'link',
					),
					array(
						'key'   => 'field_erbify_hiw_cta_de',
						'label' => 'CTA Button (German)',
						'name'  => 'how_it_works_cta_de',
						'type'  => 'link',
					),
				),
			),

			// ==========================================================
			// ABOUT US
			// ==========================================================
			array(
				'key'               => 'field_erbify_about',
				'label'             => 'About Us Section',
				'name'              => 'about',
				'type'              => 'group',
				'show_in_graphql'   => true,
				'graphql_field_name' => 'about',
				'sub_fields'        => array(
					array(
						'key'   => 'field_erbify_about_label_title',
						'label' => 'Label Title',
						'name'  => 'about_label_title',
						'type'  => 'text',
						'default_value' => 'About Us',
					),
					array(
						'key'   => 'field_erbify_about_label_title_de',
						'label' => 'Label Title (German)',
						'name'  => 'about_label_title_de',
						'type'  => 'text',
						'default_value' => 'Über uns',
					),
					array(
						'key'   => 'field_erbify_about_label_description',
						'label' => 'Label Description',
						'name'  => 'about_label_description',
						'type'  => 'textarea',
						'rows'  => 2,
					),
					array(
						'key'   => 'field_erbify_about_label_description_de',
						'label' => 'Label Description (German)',
						'name'  => 'about_label_description_de',
						'type'  => 'textarea',
						'rows'  => 2,
					),
					array(
						'key'   => 'field_erbify_about_image',
						'label' => 'Image',
						'name'  => 'about_image',
						'type'  => 'image',
						'return_format' => 'id',
					),
					array(
						'key'   => 'field_erbify_mission_title',
						'label' => 'Mission Title',
						'name'  => 'mission_title',
						'type'  => 'text',
						'default_value' => 'Our Mission',
					),
					array(
						'key'   => 'field_erbify_mission_title_de',
						'label' => 'Mission Title (German)',
						'name'  => 'mission_title_de',
						'type'  => 'text',
						'default_value' => 'Unsere Mission',
					),
					array(
						'key'   => 'field_erbify_mission_description',
						'label' => 'Mission Description',
						'name'  => 'mission_description',
						'type'  => 'textarea',
						'rows'  => 4,
					),
					array(
						'key'   => 'field_erbify_mission_description_de',
						'label' => 'Mission Description (German)',
						'name'  => 'mission_description_de',
						'type'  => 'textarea',
						'rows'  => 4,
					),
					array(
						'key'   => 'field_erbify_story_title',
						'label' => 'Story Title',
						'name'  => 'story_title',
						'type'  => 'text',
						'default_value' => 'Our Story',
					),
					array(
						'key'   => 'field_erbify_story_title_de',
						'label' => 'Story Title (German)',
						'name'  => 'story_title_de',
						'type'  => 'text',
						'default_value' => 'Unsere Geschichte',
					),
					array(
						'key'   => 'field_erbify_story_description',
						'label' => 'Story Description',
						'name'  => 'story_description',
						'type'  => 'wysiwyg',
						'toolbar' => 'basic',
						'media_upload' => 0,
					),
					array(
						'key'   => 'field_erbify_story_description_de',
						'label' => 'Story Description (German)',
						'name'  => 'story_description_de',
						'type'  => 'wysiwyg',
						'toolbar' => 'basic',
						'media_upload' => 0,
					),
					array(
						'key'   => 'field_erbify_team_title',
						'label' => 'Team Title',
						'name'  => 'team_title',
						'type'  => 'text',
						'default_value' => 'The Team',
					),
					array(
						'key'   => 'field_erbify_team_title_de',
						'label' => 'Team Title (German)',
						'name'  => 'team_title_de',
						'type'  => 'text',
						'default_value' => 'Das Team',
					),
					array(
						'key'          => 'field_erbify_team_members',
						'label'        => 'Team Members',
						'name'         => 'team_members',
						'type'         => 'repeater',
						'layout'       => 'table',
						'button_label' => 'Add Member',
						'sub_fields'   => array(
							array(
								'key'   => 'field_erbify_member_name',
								'label' => 'Name',
								'name'  => 'member_name',
								'type'  => 'text',
							),
									array(
										'key'   => 'field_erbify_member_name_de',
										'label' => 'Name (German)',
										'name'  => 'member_name_de',
										'type'  => 'text',
									),
							array(
								'key'   => 'field_erbify_member_role',
								'label' => 'Role',
								'name'  => 'member_role',
								'type'  => 'text',
							),
									array(
										'key'   => 'field_erbify_member_role_de',
										'label' => 'Role (German)',
										'name'  => 'member_role_de',
										'type'  => 'text',
									),
						),
					),
				),
			),

			// ==========================================================
			// WHAT YOU CAN DO WITH ERBIFY
			// ==========================================================
			array(
				'key'               => 'field_erbify_what_you_can_do',
				'label'             => 'What You Can Do Section',
				'name'              => 'what_you_can_do',
				'type'              => 'group',
				'show_in_graphql'   => true,
				'graphql_field_name' => 'whatYouCanDo',
				'sub_fields'        => array(
					array(
						'key'   => 'field_erbify_wycd_title',
						'label' => 'Title',
						'name'  => 'what_you_can_do_title',
						'type'  => 'text',
						'default_value' => 'What You Can Do with Erbify',
					),
					array(
						'key'   => 'field_erbify_wycd_title_de',
						'label' => 'Title (German)',
						'name'  => 'what_you_can_do_title_de',
						'type'  => 'text',
						'default_value' => 'Was Sie mit Erbify tun können',
					),
					array(
						'key'   => 'field_erbify_wycd_image',
						'label' => 'Image',
						'name'  => 'what_you_can_do_image',
						'type'  => 'image',
						'return_format' => 'id',
					),
					array(
						'key'          => 'field_erbify_wycd_items',
						'label'        => 'Items',
						'name'         => 'items',
						'type'         => 'repeater',
						'layout'       => 'table',
						'button_label' => 'Add Item',
						'sub_fields'   => array(
							array(
								'key'   => 'field_erbify_wycd_item_text',
								'label' => 'Item Text',
								'name'  => 'item_text',
								'type'  => 'text',
							),
									array(
										'key'   => 'field_erbify_wycd_item_text_de',
										'label' => 'Item Text (German)',
										'name'  => 'item_text_de',
										'type'  => 'text',
									),
						),
					),
				),
			),

			// ==========================================================
			// PRICING
			// ==========================================================
			array(
				'key'               => 'field_erbify_pricing',
				'label'             => 'Pricing Section',
				'name'              => 'pricing',
				'type'              => 'group',
				'show_in_graphql'   => true,
				'graphql_field_name' => 'pricing',
				'sub_fields'        => array(
					array(
						'key'   => 'field_erbify_pricing_tag',
						'label' => 'Tag / Mini Title',
						'name'  => 'pricing_tag',
						'type'  => 'text',
						'default_value' => 'Pricing',
					),
					array(
						'key'   => 'field_erbify_pricing_tag_de',
						'label' => 'Tag / Mini Title (German)',
						'name'  => 'pricing_tag_de',
						'type'  => 'text',
						'default_value' => 'Preise',
					),
					array(
						'key'   => 'field_erbify_pricing_title',
						'label' => 'Title',
						'name'  => 'pricing_title',
						'type'  => 'text',
						'default_value' => 'Choose the plan that works best for your legacy',
					),
					array(
						'key'   => 'field_erbify_pricing_title_de',
						'label' => 'Title (German)',
						'name'  => 'pricing_title_de',
						'type'  => 'text',
						'default_value' => 'Wählen Sie den für Ihren Nachlass passenden Plan',
					),
					array(
						'key'          => 'field_erbify_pricing_plans',
						'label'        => 'Plans',
						'name'         => 'plans',
						'type'         => 'repeater',
						'layout'       => 'block',
						'button_label' => 'Add Plan',
						'sub_fields'   => array(
							array(
								'key'   => 'field_erbify_plan_name',
								'label' => 'Plan Name',
								'name'  => 'plan_name',
								'type'  => 'text',
							),
									array(
										'key'   => 'field_erbify_plan_name_de',
										'label' => 'Plan Name (German)',
										'name'  => 'plan_name_de',
										'type'  => 'text',
									),
							array(
								'key'   => 'field_erbify_plan_price',
								'label' => 'Price',
								'name'  => 'plan_price',
								'type'  => 'text',
								'instructions' => 'e.g. "€99"',
							),
							array(
								'key'   => 'field_erbify_plan_period',
								'label' => 'Billing Period',
								'name'  => 'plan_period',
								'type'  => 'text',
								'default_value' => '/month',
							),
							array(
								'key'   => 'field_erbify_plan_period_de',
								'label' => 'Billing Period (German)',
								'name'  => 'plan_period_de',
								'type'  => 'text',
								'default_value' => '/Monat',
							),
							array(
								'key'   => 'field_erbify_plan_is_featured',
								'label' => 'Featured / Most Popular',
								'name'  => 'is_featured',
								'type'  => 'true_false',
								'ui'    => 1,
							),
							array(
								'key'   => 'field_erbify_plan_features_title',
								'label' => 'Features Title',
								'name'  => 'features_title',
								'type'  => 'text',
								'instructions' => 'e.g. "All starter features, plus:"',
							),
									array(
										'key'   => 'field_erbify_plan_features_title_de',
										'label' => 'Features Title (German)',
										'name'  => 'features_title_de',
										'type'  => 'text',
									),
							array(
								'key'          => 'field_erbify_plan_features',
								'label'        => 'Features',
								'name'         => 'features',
								'type'         => 'repeater',
								'layout'       => 'table',
								'button_label' => 'Add Feature',
								'sub_fields'   => array(
									array(
										'key'   => 'field_erbify_plan_feature_text',
										'label' => 'Feature Text',
										'name'  => 'feature_text',
										'type'  => 'text',
									),
												array(
													'key'   => 'field_erbify_plan_feature_text_de',
													'label' => 'Feature Text (German)',
													'name'  => 'feature_text_de',
													'type'  => 'text',
												),
								),
							),
							array(
								'key'   => 'field_erbify_plan_cta',
								'label' => 'CTA Button',
								'name'  => 'plan_cta',
								'type'  => 'link',
							),
									array(
										'key'   => 'field_erbify_plan_cta_de',
										'label' => 'CTA Button (German)',
										'name'  => 'plan_cta_de',
										'type'  => 'link',
									),
						),
					),
				),
			),

			// ==========================================================
			// CONTACT
			// ==========================================================
			array(
				'key'               => 'field_erbify_contact',
				'label'             => 'Contact Section',
				'name'              => 'contact',
				'type'              => 'group',
				'show_in_graphql'   => true,
				'graphql_field_name' => 'contact',
				'sub_fields'        => array(
					array(
						'key'   => 'field_erbify_contact_heading',
						'label' => 'Heading',
						'name'  => 'contact_heading',
						'type'  => 'textarea',
						'rows'  => 2,
						'default_value' => 'Have a questions? Want to partner with us?',
					),
					array(
						'key'   => 'field_erbify_contact_heading_de',
						'label' => 'Heading (German)',
						'name'  => 'contact_heading_de',
						'type'  => 'textarea',
						'rows'  => 2,
						'default_value' => 'Haben Sie Fragen? Möchten Sie mit uns zusammenarbeiten?',
					),
					array(
						'key'   => 'field_erbify_contact_email',
						'label' => 'Email',
						'name'  => 'contact_email',
						'type'  => 'text',
					),
					array(
						'key'   => 'field_erbify_contact_location',
						'label' => 'Location',
						'name'  => 'contact_location',
						'type'  => 'text',
					),
					array(
						'key'   => 'field_erbify_contact_location_de',
						'label' => 'Location (German)',
						'name'  => 'contact_location_de',
						'type'  => 'text',
					),
					array(
						'key'   => 'field_erbify_contact_linkedin',
						'label' => 'LinkedIn Link',
						'name'  => 'contact_linkedin',
						'type'  => 'link',
					),
					array(
						'key'   => 'field_erbify_contact_twitter',
						'label' => 'Twitter / X Link',
						'name'  => 'contact_twitter',
						'type'  => 'link',
					),
					array(
						'key'   => 'field_erbify_contact_form_title',
						'label' => 'Form Title',
						'name'  => 'contact_form_title',
						'type'  => 'text',
						'default_value' => 'Or fill out the form below:',
					),
					array(
						'key'   => 'field_erbify_contact_form_title_de',
						'label' => 'Form Title (German)',
						'name'  => 'contact_form_title_de',
						'type'  => 'text',
						'default_value' => 'Oder füllen Sie das Formular unten aus:',
					),
				),
			),

		),
	) );

} );

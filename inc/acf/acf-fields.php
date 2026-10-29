<?php
/**
 * WP — Home Page ACF Field Group
 *
 * Registers all editable content for the WP home page via
 * acf_add_local_field_group() and exposes it to WPGraphQL as
 * `page.WPHomePage`.
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
		'key'               => 'group_wp_home',
		'title'             => 'WP — Home Page',
		'show_in_graphql'   => true,
		'graphql_type_name' => 'WPHomePage',
		'graphql_field_name' => 'WPHomePage',
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
				'key'               => 'field_wp_hero',
				'label'             => 'Hero Section',
				'name'              => 'hero',
				'type'              => 'group',
				'show_in_graphql'   => true,
				'graphql_field_name' => 'hero',
				'sub_fields'        => array(
					array(
						'key'   => 'field_wp_hero_title',
						'label' => 'Title',
						'name'  => 'hero_title',
						'type'  => 'text',
						'default_value' => 'Plan Your Well Simply, Securely, Legally',
					),
					array(
						'key'   => 'field_wp_hero_title_en',
						'label' => 'Title (English)',
						'name'  => 'hero_title_en',
						'type'  => 'text',
						'default_value' => 'Planen Sie Ihre Wohlstand einfach, sicher und rechtlich korrekt',
					),
					array(
						'key'   => 'field_wp_hero_enscription',
						'label' => 'Description',
						'name'  => 'hero_enscription',
						'type'  => 'textarea',
						'rows'  => 3,
					),
					array(
						'key'   => 'field_wp_hero_enscription_en',
						'label' => 'Description (English)',
						'name'  => 'hero_enscription_en',
						'type'  => 'textarea',
						'rows'  => 3,
					),
					array(
						'key'   => 'field_wp_hero_image',
						'label' => 'Hero Image',
						'name'  => 'hero_image',
						'type'  => 'image',
						'return_format' => 'id',
					),
					array(
						'key'   => 'field_wp_hero_bg_image',
						'label' => 'Hero BG Image',
						'name'  => 'hero_bg_image',
						'type'  => 'image',
						'return_format' => 'id',
					),
					array(
						'key'   => 'field_wp_hero_cta',
						'label' => 'CTA Button',
						'name'  => 'hero_cta',
						'type'  => 'link',
					),
					array(
						'key'   => 'field_wp_hero_cta_en',
						'label' => 'CTA Button (English)',
						'name'  => 'hero_cta_en',
						'type'  => 'link',
					),
				),
			),

			// ==========================================================
			// WHY WP / BENEFITS
			// ==========================================================
			array(
				'key'               => 'field_wp_benefits_section',
				'label'             => 'Benefits Section',
				'name'              => 'benefits_section',
				'type'              => 'group',
				'show_in_graphql'   => true,
				'graphql_field_name' => 'benefitsSection',
				'sub_fields'        => array(
					array(
						'key'   => 'field_wp_benefits_title',
						'label' => 'Title',
						'name'  => 'benefits_title',
						'type'  => 'text',
						'default_value' => 'Discover the benefits of WP',
					),
					array(
						'key'   => 'field_wp_benefits_title_en',
						'label' => 'Title (English)',
						'name'  => 'benefits_title_en',
						'type'  => 'text',
						'default_value' => 'Entdecken Sie die Vorteile von WP',
					),
					array(
						'key'          => 'field_wp_benefits',
						'label'        => 'Benefits',
						'name'         => 'benefits',
						'type'         => 'repeater',
						'layout'       => 'block',
						'button_label' => 'Add Benefit',
						'sub_fields'   => array(
							array(
								'key'   => 'field_wp_benefit_icon',
								'label' => 'Icon',
								'name'  => 'benefit_icon',
								'type'  => 'image',
								'return_format' => 'id',
							),
							array(
								'key'   => 'field_wp_benefit_title',
								'label' => 'Title',
								'name'  => 'benefit_title',
								'type'  => 'text',
							),
									array(
										'key'   => 'field_wp_benefit_title_en',
										'label' => 'Title (English)',
										'name'  => 'benefit_title_en',
										'type'  => 'text',
									),
							array(
								'key'   => 'field_wp_benefit_enscription',
								'label' => 'Description',
								'name'  => 'benefit_enscription',
								'type'  => 'textarea',
								'rows'  => 2,
							),
									array(
										'key'   => 'field_wp_benefit_enscription_en',
										'label' => 'Description (English)',
										'name'  => 'benefit_enscription_en',
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
				'key'               => 'field_wp_how_it_works',
				'label'             => 'How It Works Section',
				'name'              => 'how_it_works',
				'type'              => 'group',
				'show_in_graphql'   => true,
				'graphql_field_name' => 'howItWorks',
				'sub_fields'        => array(
					array(
						'key'   => 'field_wp_hiw_title',
						'label' => 'Title',
						'name'  => 'how_it_works_title',
						'type'  => 'text',
						'default_value' => 'How It Works',
					),
					array(
						'key'   => 'field_wp_hiw_title_en',
						'label' => 'Title (English)',
						'name'  => 'how_it_works_title_en',
						'type'  => 'text',
						'default_value' => 'So funktioniert es',
					),
					array(
						'key'   => 'field_wp_hiw_background',
						'label' => 'Background Image',
						'name'  => 'how_it_works_background',
						'type'  => 'image',
						'return_format' => 'id',
					),
					array(
						'key'          => 'field_wp_hiw_steps',
						'label'        => 'Steps',
						'name'         => 'steps',
						'type'         => 'repeater',
						'layout'       => 'block',
						'button_label' => 'Add Step',
						'sub_fields'   => array(
							array(
								'key'   => 'field_wp_step_label',
								'label' => 'Step Label',
								'name'  => 'step_label',
								'type'  => 'text',
								'instructions' => 'e.g. "Step 1"',
							),
									array(
										'key'   => 'field_wp_step_label_en',
										'label' => 'Step Label (English)',
										'name'  => 'step_label_en',
										'type'  => 'text',
									),
							array(
								'key'   => 'field_wp_step_title',
								'label' => 'Step Title',
								'name'  => 'step_title',
								'type'  => 'text',
							),
									array(
										'key'   => 'field_wp_step_title_en',
										'label' => 'Step Title (English)',
										'name'  => 'step_title_en',
										'type'  => 'text',
									),
							array(
								'key'   => 'field_wp_step_enscription',
								'label' => 'Step Description',
								'name'  => 'step_enscription',
								'type'  => 'textarea',
								'rows'  => 2,
							),
									array(
										'key'   => 'field_wp_step_enscription_en',
										'label' => 'Step Description (English)',
										'name'  => 'step_enscription_en',
										'type'  => 'textarea',
										'rows'  => 2,
									),
						),
					),
					array(
						'key'   => 'field_wp_hiw_cta',
						'label' => 'CTA Button',
						'name'  => 'how_it_works_cta',
						'type'  => 'link',
					),
					array(
						'key'   => 'field_wp_hiw_cta_en',
						'label' => 'CTA Button (English)',
						'name'  => 'how_it_works_cta_en',
						'type'  => 'link',
					),
				),
			),

			// ==========================================================
			// ABOUT US
			// ==========================================================
			array(
				'key'               => 'field_wp_about',
				'label'             => 'About Us Section',
				'name'              => 'about',
				'type'              => 'group',
				'show_in_graphql'   => true,
				'graphql_field_name' => 'about',
				'sub_fields'        => array(
					array(
						'key'   => 'field_wp_about_label_title',
						'label' => 'Label Title',
						'name'  => 'about_label_title',
						'type'  => 'text',
						'default_value' => 'About Us',
					),
					array(
						'key'   => 'field_wp_about_label_title_en',
						'label' => 'Label Title (English)',
						'name'  => 'about_label_title_en',
						'type'  => 'text',
						'default_value' => 'Über uns',
					),
					array(
						'key'   => 'field_wp_about_label_enscription',
						'label' => 'Label Description',
						'name'  => 'about_label_enscription',
						'type'  => 'textarea',
						'rows'  => 2,
					),
					array(
						'key'   => 'field_wp_about_label_enscription_en',
						'label' => 'Label Description (English)',
						'name'  => 'about_label_enscription_en',
						'type'  => 'textarea',
						'rows'  => 2,
					),
					array(
						'key'   => 'field_wp_about_image',
						'label' => 'Image',
						'name'  => 'about_image',
						'type'  => 'image',
						'return_format' => 'id',
					),
					array(
						'key'   => 'field_wp_mission_title',
						'label' => 'Mission Title',
						'name'  => 'mission_title',
						'type'  => 'text',
						'default_value' => 'Our Mission',
					),
					array(
						'key'   => 'field_wp_mission_title_en',
						'label' => 'Mission Title (English)',
						'name'  => 'mission_title_en',
						'type'  => 'text',
						'default_value' => 'Unsere Mission',
					),
					array(
						'key'   => 'field_wp_mission_enscription',
						'label' => 'Mission Description',
						'name'  => 'mission_enscription',
						'type'  => 'textarea',
						'rows'  => 4,
					),
					array(
						'key'   => 'field_wp_mission_enscription_en',
						'label' => 'Mission Description (English)',
						'name'  => 'mission_enscription_en',
						'type'  => 'textarea',
						'rows'  => 4,
					),
					array(
						'key'   => 'field_wp_story_title',
						'label' => 'Story Title',
						'name'  => 'story_title',
						'type'  => 'text',
						'default_value' => 'Our Story',
					),
					array(
						'key'   => 'field_wp_story_title_en',
						'label' => 'Story Title (English)',
						'name'  => 'story_title_en',
						'type'  => 'text',
						'default_value' => 'Unsere Geschichte',
					),
					array(
						'key'   => 'field_wp_story_enscription',
						'label' => 'Story Description',
						'name'  => 'story_enscription',
						'type'  => 'wysiwyg',
						'toolbar' => 'basic',
						'media_upload' => 0,
					),
					array(
						'key'   => 'field_wp_story_enscription_en',
						'label' => 'Story Description (English)',
						'name'  => 'story_enscription_en',
						'type'  => 'wysiwyg',
						'toolbar' => 'basic',
						'media_upload' => 0,
					),
					array(
						'key'   => 'field_wp_team_title',
						'label' => 'Team Title',
						'name'  => 'team_title',
						'type'  => 'text',
						'default_value' => 'The Team',
					),
					array(
						'key'   => 'field_wp_team_title_en',
						'label' => 'Team Title (English)',
						'name'  => 'team_title_en',
						'type'  => 'text',
						'default_value' => 'Das Team',
					),
					array(
						'key'          => 'field_wp_team_members',
						'label'        => 'Team Members',
						'name'         => 'team_members',
						'type'         => 'repeater',
						'layout'       => 'table',
						'button_label' => 'Add Member',
						'sub_fields'   => array(
							array(
								'key'   => 'field_wp_member_name',
								'label' => 'Name',
								'name'  => 'member_name',
								'type'  => 'text',
							),
									array(
										'key'   => 'field_wp_member_name_en',
										'label' => 'Name (English)',
										'name'  => 'member_name_en',
										'type'  => 'text',
									),
							array(
								'key'   => 'field_wp_member_role',
								'label' => 'Role',
								'name'  => 'member_role',
								'type'  => 'text',
							),
									array(
										'key'   => 'field_wp_member_role_en',
										'label' => 'Role (English)',
										'name'  => 'member_role_en',
										'type'  => 'text',
									),
						),
					),
				),
			),

			// ==========================================================
			// WHAT YOU CAN DO WITH WP
			// ==========================================================
			array(
				'key'               => 'field_wp_what_you_can_do',
				'label'             => 'What You Can Do Section',
				'name'              => 'what_you_can_do',
				'type'              => 'group',
				'show_in_graphql'   => true,
				'graphql_field_name' => 'whatYouCanDo',
				'sub_fields'        => array(
					array(
						'key'   => 'field_wp_wycd_title',
						'label' => 'Title',
						'name'  => 'what_you_can_do_title',
						'type'  => 'text',
						'default_value' => 'What You Can Do with WP',
					),
					array(
						'key'   => 'field_wp_wycd_title_en',
						'label' => 'Title (English)',
						'name'  => 'what_you_can_do_title_en',
						'type'  => 'text',
						'default_value' => 'Was Sie mit WP tun können',
					),
					array(
						'key'   => 'field_wp_wycd_image',
						'label' => 'Image',
						'name'  => 'what_you_can_do_image',
						'type'  => 'image',
						'return_format' => 'id',
					),
					array(
						'key'          => 'field_wp_wycd_items',
						'label'        => 'Items',
						'name'         => 'items',
						'type'         => 'repeater',
						'layout'       => 'table',
						'button_label' => 'Add Item',
						'sub_fields'   => array(
							array(
								'key'   => 'field_wp_wycd_item_text',
								'label' => 'Item Text',
								'name'  => 'item_text',
								'type'  => 'text',
							),
									array(
										'key'   => 'field_wp_wycd_item_text_en',
										'label' => 'Item Text (English)',
										'name'  => 'item_text_en',
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
				'key'               => 'field_wp_pricing',
				'label'             => 'Pricing Section',
				'name'              => 'pricing',
				'type'              => 'group',
				'show_in_graphql'   => true,
				'graphql_field_name' => 'pricing',
				'sub_fields'        => array(
					array(
						'key'   => 'field_wp_pricing_tag',
						'label' => 'Tag / Mini Title',
						'name'  => 'pricing_tag',
						'type'  => 'text',
						'default_value' => 'Pricing',
					),
					array(
						'key'   => 'field_wp_pricing_tag_en',
						'label' => 'Tag / Mini Title (English)',
						'name'  => 'pricing_tag_en',
						'type'  => 'text',
						'default_value' => 'Preise',
					),
					array(
						'key'   => 'field_wp_pricing_title',
						'label' => 'Title',
						'name'  => 'pricing_title',
						'type'  => 'text',
						'default_value' => 'Choose the plan that works best for your legacy',
					),
					array(
						'key'   => 'field_wp_pricing_title_en',
						'label' => 'Title (English)',
						'name'  => 'pricing_title_en',
						'type'  => 'text',
						'default_value' => 'Wählen Sie den für Ihren Nachlass passenden Plan',
					),
					array(
						'key'          => 'field_wp_pricing_plans',
						'label'        => 'Plans',
						'name'         => 'plans',
						'type'         => 'repeater',
						'layout'       => 'block',
						'button_label' => 'Add Plan',
						'sub_fields'   => array(
							array(
								'key'   => 'field_wp_plan_name',
								'label' => 'Plan Name',
								'name'  => 'plan_name',
								'type'  => 'text',
							),
									array(
										'key'   => 'field_wp_plan_name_en',
										'label' => 'Plan Name (English)',
										'name'  => 'plan_name_en',
										'type'  => 'text',
									),
							array(
								'key'   => 'field_wp_plan_price',
								'label' => 'Price',
								'name'  => 'plan_price',
								'type'  => 'text',
								'instructions' => 'e.g. "€99"',
							),
							array(
								'key'   => 'field_wp_plan_period',
								'label' => 'Billing Period',
								'name'  => 'plan_period',
								'type'  => 'text',
								'default_value' => '/month',
							),
							array(
								'key'   => 'field_wp_plan_period_en',
								'label' => 'Billing Period (English)',
								'name'  => 'plan_period_en',
								'type'  => 'text',
								'default_value' => '/Monat',
							),
							array(
								'key'   => 'field_wp_plan_is_featured',
								'label' => 'Featured / Most Popular',
								'name'  => 'is_featured',
								'type'  => 'true_false',
								'ui'    => 1,
							),
							array(
								'key'   => 'field_wp_plan_features_title',
								'label' => 'Features Title',
								'name'  => 'features_title',
								'type'  => 'text',
								'instructions' => 'e.g. "All starter features, plus:"',
							),
									array(
										'key'   => 'field_wp_plan_features_title_en',
										'label' => 'Features Title (English)',
										'name'  => 'features_title_en',
										'type'  => 'text',
									),
							array(
								'key'          => 'field_wp_plan_features',
								'label'        => 'Features',
								'name'         => 'features',
								'type'         => 'repeater',
								'layout'       => 'table',
								'button_label' => 'Add Feature',
								'sub_fields'   => array(
									array(
										'key'   => 'field_wp_plan_feature_text',
										'label' => 'Feature Text',
										'name'  => 'feature_text',
										'type'  => 'text',
									),
												array(
													'key'   => 'field_wp_plan_feature_text_en',
													'label' => 'Feature Text (English)',
													'name'  => 'feature_text_en',
													'type'  => 'text',
												),
								),
							),
							array(
								'key'   => 'field_wp_plan_cta',
								'label' => 'CTA Button',
								'name'  => 'plan_cta',
								'type'  => 'link',
							),
									array(
										'key'   => 'field_wp_plan_cta_en',
										'label' => 'CTA Button (English)',
										'name'  => 'plan_cta_en',
										'type'  => 'link',
									),
						),
					),
				),
			),


		),
	) );

} );

<?php

namespace WoocommerceUsersBadges\Setting;

use WoocommerceUsersBadges\Woocommerce_Users_Badges;

/**
 * Class SettingPage
 * @package WoocommerceUsersBadges\Setting
 */
class SettingPage {

	/**
	 * configure your admin page
	 */
	public $config;

	/**
	 * Construction
	 */
	public function __construct() {
		$this->config = array(
			'menu'           => 'woocommerce',
			'page_title'     => __( 'Users Badges', Woocommerce_Users_Badges::TEXTDOMAIN ),
			'capability'     => 'manage_options',
			'option_group'   => 'user_badges',
			'id'             => 'admin_page',
			'fields'         => array(),
			'local_images'   => false,
			'use_with_theme' => false
		);

		$options_panel = new \BF_Admin_Page_Class( $this->config );


		/**
		 * define your admin page tabs listing
		 */
		$options_panel->TabsListing( array(
			'links' => array(
				'options_1' => __( 'General Settings', Woocommerce_Users_Badges::TEXTDOMAIN ),
				'options_2' => __( 'Rules', Woocommerce_Users_Badges::TEXTDOMAIN ),
			)
		) );

		// First Tab
		$options_panel->OpenTab( 'options_1' );
		$options_panel->Title( 'General Settings' );
		$options_panel->addParagraph( __( "Here you can add the default width and height for the badge, to show the badges add the shortcut [user_details]", Woocommerce_Users_Badges::TEXTDOMAIN ) );

		$options_panel->addText( 'badge_width', array( 'name' => __( 'Badge Width ( in pixels )', Woocommerce_Users_Badges::TEXTDOMAIN ) ) );
		$options_panel->addText( 'badge_height', array( 'name' => __( 'Badge Height ( in pixels )', Woocommerce_Users_Badges::TEXTDOMAIN ) ) );
		$options_panel->CloseTab();

		// Second Tab
		$options_panel->OpenTab( 'options_2' );
		$options_panel->Title( 'Rules' );
		$options_panel->addParagraph( __( "Here you can add some rules for the badges, you can set an image for every badge and for every badge you set specific rule  ", Woocommerce_Users_Badges::TEXTDOMAIN ) );

		$options_panel->addParagraph( __( "If you choose the registration rule, then you have to add the number of days in the value field, so that the user get the badge if his/her registeration time ( more or less or equal ) the number of days you entered, also if you choose the order rule then you have to add the number of completed orders related to the user", Woocommerce_Users_Badges::TEXTDOMAIN ) );


		$repeater_fields[] = $options_panel->addText( 'rule_name', array( 'name' => __( 'Rule ', Woocommerce_Users_Badges::TEXTDOMAIN ) ), true );
		$repeater_fields[] = $options_panel->addSelect( 'compare_element', array(
			'order'        => 'Order',
			'registration' => 'Registration',
		), array( 'name' => 'User\'s' ), true );
		$repeater_fields[] = $options_panel->addSelect( 'compare_parameter', array(
			'1' => 'Equal',
			'2' => 'Not Equal',
			'3' => 'Less Than',
			'4' => 'Less Than Or Equal',
			'5' => 'More than',
			'6' => 'More Than Or Equal'
		), array( 'name' => __( 'Is', Woocommerce_Users_Badges::TEXTDOMAIN ) ), true );
		$repeater_fields[] = $options_panel->addText( 'compare_value', array( 'name' => __( 'Value', Woocommerce_Users_Badges::TEXTDOMAIN ) ), true );
		$repeater_fields[] = $options_panel->addTextarea( 'desc', array( 'name' => __( 'Description', Woocommerce_Users_Badges::TEXTDOMAIN ) ), true );
		$repeater_fields[] = $options_panel->addImage( 'user_badge_img', array( 'name' => __( 'User Badge', Woocommerce_Users_Badges::TEXTDOMAIN ) ), true );
		$options_panel->addRepeaterBlock( 'rules', array(
			'sortable' => false,
			'inline'   => true,
			'name'     => __( 'Rules', Woocommerce_Users_Badges::TEXTDOMAIN ),
			'fields'   => $repeater_fields
		) );

		$options_panel->CloseTab();

	}

}







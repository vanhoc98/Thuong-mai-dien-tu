<?php
/**
 * UAEL Team Member.
 *
 * @package UAEL
 */

namespace UltimateElementor\Modules\TeamMember\Widgets;

// Elementor Classes.
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Utils;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Border;

// UltimateElementor Classes.
use UltimateElementor\Base\Common_Widget;
use UltimateElementor\Classes\UAEL_Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit;   // Exit if accessed directly.
}

/**
 * Class Team.
 */
class Team_Member extends Common_Widget {

	/**
	 * Retrieve Team Member Widget name.
	 *
	 * @since 1.16.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return parent::get_widget_slug( 'Team_Member' );
	}

	/**
	 * Retrieve Team Member Widget heading.
	 *
	 * @since 1.16.0
	 * @access public
	 *
	 * @return string Widget heading.
	 */
	public function get_title() {
		return parent::get_widget_title( 'Team_Member' );
	}

	/**
	 * Retrieve Team Member Widget icon.
	 *
	 * @since 1.16.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return parent::get_widget_icon( 'Team_Member' );
	}

	/**
	 * Retrieve Team Member Widget Keywords.
	 *
	 * @since 1.16.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_keywords() {
		return parent::get_widget_keywords( 'Team_Member' );
	}


	/**
	 * Register Team Member widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.16.0
	 * @access protected
	 */
	protected function _register_controls() {

		$this->render_team_member_content_control();
		$this->register_content_separator();
		$this->register_content_social_icons_controls();
		$this->register_helpful_information();

		/* Style */
		$this->register_style_team_member_image();
		$this->register_style_team_member_name();
		$this->register_style_team_member_designation();
		$this->register_style_team_member_desc();
		$this->register_style_team_member_icon();
		$this->register_content_spacing_control();
	}

	/**
	 * Register Team Member controls.
	 *
	 * @since 1.16.0
	 * @access protected
	 */
	protected function render_team_member_content_control() {
		$this->start_controls_section(
			'section_team_member',
			[
				'label' => __( 'General', 'uael' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'image',
			[
				'label'   => __( 'Image', 'uael' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'image', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `image_size` and `image_custom_dimension`.
				'default'   => 'medium',
				'separator' => 'none',
			]
		);

		$this->add_responsive_control(
			'member_image_size',
			[
				'label'      => __( 'Width', 'uael' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem' ],
				'range'      => [
					'px' => [
						'min' => 1,
						'max' => 2000,
					],
				],
				'default'    => [
					'size' => 150,
					'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .uael-team-member-image img' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'team_member_name',
			[
				'label'       => __( 'Name', 'uael' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => __( 'Enter Name', 'uael' ),
				'default'     => __( 'John Doe', 'uael' ),
			]
		);
		$this->add_control(
			'team_member_desig',
			[
				'label'       => __( 'Designation', 'uael' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => __( 'Enter Designation', 'uael' ),
				'default'     => __( 'CEO', 'uael' ),
			]
		);
		$this->add_control(
			'team_member_desc',
			[
				'label'       => __( 'Description', 'uael' ),
				'type'        => Controls_Manager::TEXTAREA,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => __( 'Describe here', 'uael' ),
				'default'     => __( 'Use this space to tell a little about your team member. Make it interesting by mentioning his expertise, achievements, interests, hobbies and more.', 'uael' ),
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Register Team member separator style and controls.
	 *
	 * @since 1.16.0
	 * @access protected
	 */
	protected function register_content_separator() {
		$this->start_controls_section(
			'section_separator',
			[
				'label' => __( 'Separator', 'uael' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'separator_settings',
			[
				'label'        => __( 'Separator', 'uael' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'uael' ),
				'label_off'    => __( 'Hide', 'uael' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'separator_position',
			[
				'label'     => __( 'Position', 'uael' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'below_desig',
				'options'   => [
					'below_name'  => __( 'Below Name', 'uael' ),
					'below_desig' => __( 'Below Designation', 'uael' ),
					'below_desc'  => __( 'Below Description', 'uael' ),
				],
				'condition' => [
					'separator_settings' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'separator_size',
			[
				'label'      => __( 'Width', 'uael' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
					'%'  => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default'    => [
					'size' => '20',
					'unit' => '%',
				],
				'selectors'  => [
					'{{WRAPPER}} .uael-separator ' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [
					'separator_settings' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'separator_thickness',
			[
				'label'      => __( 'Thickness', 'uael' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem' ],
				'range'      => [
					'px' => [
						'min' => 1,
						'max' => 10,
					],
				],
				'default'    => [
					'size' => 2,
					'unit' => 'px',
				],
				'condition'  => [
					'separator_settings' => 'yes',
				],
				'selectors'  => [
					'{{WRAPPER}} .uael-separator' => 'border-top-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'separator_color',
			[
				'label'     => __( 'Color', 'uael' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_4,
				],
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .uael-separator' => 'border-top-color: {{VALUE}};',
				],
				'condition' => [
					'separator_settings' => 'yes',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Register social icons controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.16.0
	 * @access protected
	 */
	protected function register_content_social_icons_controls() {
		$this->start_controls_section(
			'section_social_icon',
			[
				'label' => 'Social Icons',
			]
		);

		$this->add_control(
			'social_icons_settings',
			[
				'label'        => __( 'Social Icons', 'uael' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'uael' ),
				'label_off'    => __( 'Hide', 'uael' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$repeater = new Repeater();

		if ( UAEL_Helper::is_elementor_updated() ) {
			$repeater->add_control(
				'new_social',
				[
					'label'            => __( 'Icon', 'uael' ),
					'type'             => Controls_Manager::ICONS,
					'fa4compatibility' => 'social',
					'label_block'      => true,
					'default'          => [
						'value'   => 'fab fa-wordpress',
						'library' => 'fa-brands',
					],
					'recommended'      => [
						'fa-brands' => [
							'android',
							'apple',
							'behance',
							'bitbucket',
							'codepen',
							'delicious',
							'deviantart',
							'digg',
							'dribbble',
							'elementor',
							'facebook',
							'flickr',
							'foursquare',
							'free-code-camp',
							'github',
							'gitlab',
							'globe',
							'google-plus',
							'houzz',
							'instagram',
							'jsfiddle',
							'linkedin',
							'medium',
							'meetup',
							'mixcloud',
							'odnoklassniki',
							'pinterest',
							'product-hunt',
							'reddit',
							'shopping-cart',
							'skype',
							'slideshare',
							'snapchat',
							'soundcloud',
							'spotify',
							'stack-overflow',
							'steam',
							'stumbleupon',
							'telegram',
							'thumb-tack',
							'tripadvisor',
							'tumblr',
							'twitch',
							'twitter',
							'viber',
							'vimeo',
							'vk',
							'weibo',
							'weixin',
							'whatsapp',
							'wordpress',
							'xing',
							'yelp',
							'youtube',
							'500px',
						],
						'fa-solid'  => [
							'envelope',
							'link',
							'rss',
						],
					],
				]
			);
		} else {
			$repeater->add_control(
				'social',
				[
					'label'       => __( 'Icon', 'uael' ),
					'type'        => Controls_Manager::ICON,
					'label_block' => true,
					'default'     => 'fa fa-wordpress',
					'include'     => [
						'fa fa-android',
						'fa fa-apple',
						'fa fa-behance',
						'fa fa-bitbucket',
						'fa fa-codepen',
						'fa fa-delicious',
						'fa fa-deviantart',
						'fa fa-digg',
						'fa fa-dribbble',
						'fa fa-envelope',
						'fa fa-facebook',
						'fa fa-flickr',
						'fa fa-foursquare',
						'fa fa-free-code-camp',
						'fa fa-github',
						'fa fa-gitlab',
						'fa fa-google-plus',
						'fa fa-houzz',
						'fa fa-instagram',
						'fa fa-jsfiddle',
						'fa fa-linkedin',
						'fa fa-medium',
						'fa fa-meetup',
						'fa fa-mixcloud',
						'fa fa-odnoklassniki',
						'fa fa-pinterest',
						'fa fa-product-hunt',
						'fa fa-reddit',
						'fa fa-rss',
						'fa fa-shopping-cart',
						'fa fa-skype',
						'fa fa-slideshare',
						'fa fa-snapchat',
						'fa fa-soundcloud',
						'fa fa-spotify',
						'fa fa-stack-overflow',
						'fa fa-steam',
						'fa fa-stumbleupon',
						'fa fa-telegram',
						'fa fa-thumb-tack',
						'fa fa-tripadvisor',
						'fa fa-tumblr',
						'fa fa-twitch',
						'fa fa-twitter',
						'fa fa-vimeo',
						'fa fa-vk',
						'fa fa-weibo',
						'fa fa-weixin',
						'fa fa-whatsapp',
						'fa fa-wordpress',
						'fa fa-xing',
						'fa fa-yelp',
						'fa fa-youtube',
						'fa fa-500px',
					],
				]
			);
		}

		$repeater->add_control(
			'link',
			[
				'label'       => __( 'Link', 'uael' ),
				'type'        => Controls_Manager::URL,
				'label_block' => true,
				'default'     => [
					'is_external' => 'true',
				],
				'placeholder' => __( 'https://your-link.com', 'uael' ),
			]
		);

		$this->add_control(
			'social_icon_list',
			[
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[
						'new_social' => [
							'value'   => 'fab fa-facebook',
							'library' => 'fa-brands',
						],
					],
					[
						'new_social' => [
							'value'   => 'fab fa-twitter',
							'library' => 'fa-brands',
						],
					],
					[
						'new_social' => [
							'value'   => 'fab fa-google-plus',
							'library' => 'fa-brands',
						],
					],

				],
				'condition'   => [
					'social_icons_settings' => 'yes',
				],
				'title_field' => '<# var migrated = "undefined" !== typeof __fa4_migrated, social = ( "undefined" === typeof social ) ? false : social; #>{{{ elementor.helpers.getSocialNetworkNameFromIcon( new_social, social, true, migrated, true ) }}}',
			]
		);

		$this->add_control(
			'shape',
			[
				'label'        => __( 'Shape', 'uael' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'square',
				'options'      => [
					'square'  => __( 'Square', 'uael' ),
					'rounded' => __( 'Rounded', 'uael' ),
					'circle'  => __( 'Circle', 'uael' ),
				],
				'prefix_class' => 'elementor-shape-',
				'condition'    => [
					'social_icons_settings' => 'yes',
				],
				'default'      => 'rounded',
			]
		);

		$this->add_control(
			'social_icons_border_radius',
			[
				'label'      => __( 'Border Radius', 'uael' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top'    => '10',
					'unit'   => '%',
					'right'  => '10',
					'unit'   => '%',
					'bottom' => '10',
					'unit'   => '%',
					'left'   => '10',
					'unit'   => '%',
				],
				'selectors'  => [
					'{{WRAPPER}} .elementor-social-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'  => [
					'shape' => [ 'rounded' ],
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Helpful Information.
	 *
	 * @since 1.16.0
	 * @access protected
	 */
	protected function register_helpful_information() {
		if ( parent::is_internal_links() ) {
			$this->start_controls_section(
				'section_helpful_info',
				[
					'label' => __( 'Helpful Information', 'uael' ),
				]
			);

			$this->add_control(
				'help_doc_1',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %1$s Doc Link */
					'raw'             => sprintf( __( '%1$s Getting started article » %2$s', 'uael' ), '<a href="https://uaelementor.com/docs/team-member-widget/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin" target="_blank" rel="noopener">', '</a>' ),
					'content_classes' => 'uael-editor-doc',
				]
			);
			$this->end_controls_section();
		}
	}


	/**
	 * Register team member image style.
	 *
	 * @since 1.16.0
	 * @access protected
	 */
	protected function register_style_team_member_image() {
		$this->start_controls_section(
			'section_team_member_image_style',
			[
				'label' => __( 'Image', 'uael' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'image_position',
			[
				'label'        => __( 'Image Position', 'uael' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'above',
				'options'      => [
					'above' => __( 'Top', 'uael' ),
					'left'  => __( 'Left', 'uael' ),
					'right' => __( 'Right', 'uael' ),
				],
				'prefix_class' => 'uael-member-image-pos-',
			]
		);

		$this->add_control(
			'member_mob_view',
			[
				'label'       => __( 'Responsive Support', 'uael' ),
				'description' => __( 'Choose the breakpoint you want the layout will stack.', 'uael' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'none',
				'options'     => [
					'none'   => __( 'No', 'uael' ),
					'tablet' => __( 'For Tablet & Mobile ', 'uael' ),
					'mobile' => __( 'For Mobile Only', 'uael' ),
				],
				'condition'   => [
					'image_position' => [ 'left', 'right' ],
				],
			]
		);

		$this->add_control(
			'member_image_valign',
			[
				'label'       => __( 'Vertical Alignment', 'uael' ),
				'type'        => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options'     => [
					'top'    => [
						'title' => __( 'Top', 'uael' ),
						'icon'  => 'eicon-v-align-top',
					],
					'middle' => [
						'title' => __( 'Middle', 'uael' ),
						'icon'  => 'eicon-v-align-middle',
					],
				],
				'default'     => 'top',
				'condition'   => [
					'image_position' => [ 'left', 'right' ],
				],
			]
		);

		$this->add_responsive_control(
			'align_team_member',
			[
				'label'        => __( 'Overall Alignment', 'uael' ),
				'type'         => Controls_Manager::CHOOSE,
				'options'      => [
					'left'   => [
						'title' => __( 'Left', 'uael' ),
						'icon'  => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'uael' ),
						'icon'  => 'fa fa-align-center',
					],
					'right'  => [
						'title' => __( 'Right', 'uael' ),
						'icon'  => 'fa fa-align-right',
					],
				],
				'condition'    => [
					'image_position' => 'above',
				],
				'default'      => 'center',
				'prefix_class' => 'uael%s-team-member-align-',
			]
		);

		$this->add_control(
			'image_shape',
			[
				'label'        => __( 'Shape', 'uael' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'square',
				'options'      => [
					'square'  => __( 'Square', 'uael' ),
					'rounded' => __( 'Rounded', 'uael' ),
					'circle'  => __( 'Circle', 'uael' ),
				],
				'prefix_class' => 'uael-shape-',
			]
		);

		$this->add_control(
			'team_member_image_border_radius',
			[
				'label'      => __( 'Border Radius', 'uael' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top'    => '10',
					'unit'   => '%',
					'right'  => '10',
					'unit'   => '%',
					'bottom' => '10',
					'unit'   => '%',
					'left'   => '10',
					'unit'   => '%',
				],
				'selectors'  => [
					'{{WRAPPER}} .uael-team-member-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'  => [
					'image_shape' => [ 'rounded' ],
				],
			]
		);

		$this->add_control(
			'image_border',
			[
				'label'       => __( 'Border Style', 'uael' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'none',
				'label_block' => false,
				'options'     => [
					'none'   => __( 'None', 'uael' ),
					'solid'  => __( 'Solid', 'uael' ),
					'double' => __( 'Double', 'uael' ),
					'dotted' => __( 'Dotted', 'uael' ),
					'dashed' => __( 'Dashed', 'uael' ),
				],
				'selectors'   => [
					'{{WRAPPER}} .uael-team-member-image img' => 'border-style: {{VALUE}};',
				],
			]
		);

			$this->add_control(
				'image_border_size',
				[
					'label'      => __( 'Border Width', 'uael' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px' ],
					'default'    => [
						'top'    => '1',
						'bottom' => '1',
						'left'   => '1',
						'right'  => '1',
						'unit'   => 'px',
					],
					'condition'  => [
						'image_border!' => 'none',
					],
					'selectors'  => [
						'{{WRAPPER}} .uael-team-member-image img' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; box-sizing:border-box;',
					],
				]
			);

			$this->add_control(
				'image_border_color',
				[
					'label'     => __( 'Border Color', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'scheme'    => [
						'type'  => Scheme_Color::get_type(),
						'value' => Scheme_Color::COLOR_1,
					],
					'condition' => [
						'image_border!' => 'none',
					],
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .uael-team-member-image img' => 'border-color: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'image_border_hover_color',
				[
					'label'     => __( 'Border Hover Color', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'scheme'    => [
						'type'  => Scheme_Color::get_type(),
						'value' => Scheme_Color::COLOR_2,
					],
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .uael-team-member-image img:hover' => 'border-color: {{VALUE}};',
					],
					'condition' => [
						'image_border!' => 'none',
					],
				]
			);

		$this->add_control(
			'hover_animation',
			[
				'label' => __( 'Hover Animation', 'uael' ),
				'type'  => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Register Team member Name style.
	 *
	 * @since 1.16.0
	 * @access protected
	 */
	protected function register_style_team_member_name() {
		$this->start_controls_section(
			'section_team_member_name_style',
			[
				'label'     => __( 'Name', 'uael' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'team_member_name!' => '',
				],
			]
		);

		$this->add_control(
			'name_size',
			[
				'label'   => __( 'HTML Tag', 'uael' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'h1'   => 'H1',
					'h2'   => 'H2',
					'h3'   => 'H3',
					'h4'   => 'H4',
					'h5'   => 'H5',
					'h6'   => 'H6',
					'div'  => 'div',
					'span' => 'span',
					'p'    => 'p',
				],
				'default' => 'h3',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'name_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .uael-team-name',
			]
		);

		$this->add_control(
			'name_color',
			[
				'label'     => __( 'Color', 'uael' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .uael-team-name' => 'color: {{VALUE}};',
				],
			]
		);
		$this->end_controls_section();
	}

	/**
	 * Register Team member designation style.
	 *
	 * @since 1.16.0
	 * @access protected
	 */
	protected function register_style_team_member_designation() {
		$this->start_controls_section(
			'section_team_member_designation_style',
			[
				'label'     => __( 'Designation', 'uael' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'team_member_desig!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'designation_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .uael-team-desig',
			]
		);

		$this->add_control(
			'designation_color',
			[
				'label'     => __( 'Color', 'uael' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_2,
				],
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .uael-team-desig' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Register Team member description style.
	 *
	 * @since 1.16.0
	 * @access protected
	 */
	protected function register_style_team_member_desc() {
		$this->start_controls_section(
			'section_team_member_desc_style',
			[
				'label'     => __( 'Description', 'uael' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'team_member_desc!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'desc_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .uael-team-desc',
			]
		);

		$this->add_control(
			'desc_color',
			[
				'label'     => __( 'Color', 'uael' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				],
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .uael-team-desc' => 'color: {{VALUE}};',
				],
			]
		);
		$this->end_controls_section();
	}

	/**
	 * Register social icons style.
	 *
	 * @since 1.16.0
	 * @access protected
	 */
	protected function register_style_team_member_icon() {
		$this->start_controls_section(
			'section_social_style',
			[
				'label'     => __( 'Social Icons', 'uael' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'social_icons_settings' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'icon_size',
			[
				'label'     => __( 'Icon Size', 'uael' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 6,
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-social-icon' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .elementor-social-icon svg' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_padding',
			[
				'label'          => __( 'Padding', 'uael' ),
				'type'           => Controls_Manager::SLIDER,
				'selectors'      => [
					'{{WRAPPER}} .elementor-social-icon' => 'padding: {{SIZE}}{{UNIT}};',
				],
				'tablet_default' => [
					'unit' => 'em',
				],
				'mobile_default' => [
					'unit' => 'em',
				],
				'range'          => [
					'em' => [
						'min' => 0,
						'max' => 5,
					],
				],
			]
		);

		$icon_spacing = is_rtl() ? 'margin-left: {{SIZE}}{{UNIT}};' : 'margin-right: {{SIZE}}{{UNIT}};';

		$this->add_responsive_control(
			'icon_spacing',
			[
				'label'     => __( 'Spacing', 'uael' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-social-icon:not(:last-child)' => $icon_spacing,
				],
				'separator' => 'after',
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label'   => __( 'Color', 'uael' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default' => __( 'Official Color', 'uael' ),
					'custom'  => __( 'Custom', 'uael' ),
				],
			]
		);

		$this->start_controls_tabs(
			'icon_style_tabs'
		);

		$this->start_controls_tab(
			'icon_style_normal_tab',
			[
				'label'     => __( 'Normal', 'uael' ),
				'condition' => [
					'icon_color' => 'custom',
				],
			]
		);

		$this->add_control(
			'icon_primary_color_normal',
			[
				'label'     => __( 'Background Color', 'uael' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'icon_color' => 'custom',
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-social-icon:not(:hover), {{WRAPPER}} .elementor-social-icon:not(:hover) svg' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'icon_secondary_color_normal',
			[
				'label'     => __( 'Icon Color', 'uael' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'icon_color' => 'custom',
				],

				'selectors' => [
					'{{WRAPPER}} .elementor-social-icon:not(:hover) i, {{WRAPPER}} .elementor-social-icon:not(:hover) svg' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'icon_style_hover_tab',
			[
				'label'     => __( 'Hover', 'uael' ),
				'condition' => [
					'icon_color' => 'custom',
				],
			]
		);

		$this->add_control(
			'icon_primary_color_hover',
			[
				'label'     => __( 'Background Color', 'uael' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'icon_color' => 'custom',
				],

				'selectors' => [
					'{{WRAPPER}} .elementor-social-icon:hover, {{WRAPPER}} .elementor-social-icon:hover svg' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'icon_secondary_color_hover',
			[
				'label'     => __( 'Icon Color', 'uael' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'icon_color' => 'custom',
				],

				'selectors' => [
					'{{WRAPPER}} .elementor-social-icon:hover i, {{WRAPPER}} .elementor-social-icon:hover svg' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_control(
			'social_icon_border',
			[
				'label'       => __( 'Border Style', 'uael' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'none',
				'label_block' => false,
				'options'     => [
					'none'   => __( 'None', 'uael' ),
					'solid'  => __( 'Solid', 'uael' ),
					'double' => __( 'Double', 'uael' ),
					'dotted' => __( 'Dotted', 'uael' ),
					'dashed' => __( 'Dashed', 'uael' ),
				],
				'selectors'   => [
					'{{WRAPPER}} .elementor-social-icon' => 'border-style: {{VALUE}};',
				],
			]
		);

			$this->add_control(
				'social_icon_border_size',
				[
					'label'      => __( 'Border Width', 'uael' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px' ],
					'default'    => [
						'top'    => '1',
						'bottom' => '1',
						'left'   => '1',
						'right'  => '1',
						'unit'   => 'px',
					],
					'condition'  => [
						'social_icon_border!' => 'none',
					],
					'selectors'  => [
						'{{WRAPPER}} .elementor-social-icon' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; box-sizing:content-box;',
					],
				]
			);

			$this->add_control(
				'social_icon_border_color',
				[
					'label'     => __( 'Border Color', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'scheme'    => [
						'type'  => Scheme_Color::get_type(),
						'value' => Scheme_Color::COLOR_1,
					],
					'condition' => [
						'social_icon_border!' => 'none',
					],
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .elementor-social-icon' => 'border-color: {{VALUE}};',
					],
				]
			);

		$this->add_control(
			'social_icon_border_hover_color',
			[
				'label'     => __( 'Border Hover Color', 'uael' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_2,
				],
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .elementor-social-icon:hover' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'social_icon_border!' => 'none',
				],
			]
		);

		$this->add_control(
			'icon_hover_animation',
			[
				'label' => __( 'Hover Animation', 'uael' ),
				'type'  => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Register Team Member spacing controls.
	 *
	 * @since 1.16.0
	 * @access protected
	 */
	protected function register_content_spacing_control() {

		$this->start_controls_section(
			'section_content_spacing',
			[
				'label' => __( 'Spacing', 'uael' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'image_margin_bottom',
			[
				'label'      => __( 'Image Spacing', 'uael' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
				],
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}}.uael-member-image-pos-above .uael-team-member-image' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.uael-member-image-pos-left .uael-team-member-image' => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.uael-member-image-pos-right .uael-team-member-image' => 'margin-left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'name_margin',
			[
				'label'      => __( 'Name Bottom Spacing', 'uael' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
				],
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .uael-team-name' => 'margin-bottom:{{SIZE}}{{UNIT}};',
				],
				'condition'  => [
					'team_member_name!' => '',
				],
			]
		);

		$this->add_responsive_control(
			'desig_margin',
			[
				'label'      => __( 'Designation Bottom Spacing', 'uael' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
				],
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .uael-team-desig' => 'margin-bottom:{{SIZE}}{{UNIT}};',
				],
				'condition'  => [
					'team_member_desig!' => '',
				],
			]
		);

		$this->add_responsive_control(
			'separator_margin',
			[
				'label'      => __( 'Separator Bottom Spacing', 'uael' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
				],
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .uael-separator-wrapper' => 'padding-bottom:{{SIZE}}{{UNIT}};',
				],
				'condition'  => [
					'separator_settings' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'desc_margin',
			[
				'label'      => __( 'Description Bottom Spacing', 'uael' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
				],
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .uael-team-desc' => 'margin-bottom:{{SIZE}}{{UNIT}};',
				],
				'condition'  => [
					'team_member_desc!' => '',
				],
			]
		);
	}

	/**
	 * Get the position of Separator.
	 *
	 * @since 1.16.0
	 * @access protected
	 */
	protected function get_separator_position() { ?>
		<div class="uael-separator-wrapper">
			<span class="uael-separator"></span>
		</div>
		<?php
	}

	/**
	 * Render team member widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HteamL.
	 *
	 * @since 1.16.0
	 * @access protected
	 */
	protected function render() {

		$settings = $this->get_settings_for_display();
		if ( 'left' === $settings['image_position'] || 'right' === $settings['image_position'] ) {
			if ( 'tablet' === $settings['member_mob_view'] ) {
				$this->add_render_attribute( 'member-classname', 'class', 'uael-member-stacked-tablet' );
			}
			if ( 'mobile' === $settings['member_mob_view'] ) {
				$this->add_render_attribute( 'member-classname', 'class', 'uael-member-stacked-mobile' );
			}
			if ( 'middle' === $settings['member_image_valign'] ) {
				$this->add_render_attribute( 'member-classname', 'class', 'uael-member-image-valign-middle' );
			} else {
				$this->add_render_attribute( 'member-classname', 'class', 'uael-member-image-valign-top' );
			}
		}
		$this->add_render_attribute( 'member-classname', 'class', 'uael-team-member' );

		$fallback_defaults = [
			'fa fa-facebook',
			'fa fa-twitter',
			'fa fa-google-plus',
		];

		?>
		<div <?php echo $this->get_render_attribute_string( 'member-classname' ); ?>>	
			<div class = "uael-team-member-wrap" >
				<div class="uael-member-wrap" >
					<?php
					$has_image = $settings['image']['url'];
					if ( $has_image ) :
						?>
							<div class="uael-team-member-image">
							<?php
							$image_html = Group_Control_Image_Size::get_attachment_image_html( $settings );
							echo '<div class=' . 'elementor-animation-' . $settings['hover_animation'] . '>' . $image_html . '</div>';
							?>
							</div>
					<?php endif; ?>
					<?php
					$this->add_render_attribute( 'member_content', 'class', 'uael-team-member-content' );
					$this->add_render_attribute( 'team_member_name', 'class', 'uael-team-name' );
					$this->add_inline_editing_attributes( 'team_member_name' );
					?>
					<div <?php echo $this->get_render_attribute_string( 'member_content' ); ?>>
					<?php if ( '' !== $settings['team_member_name'] ) { ?>
						<div class="uael-team-member-name">
						<?php
							$name      = $settings['team_member_name'];
							$name_html = sprintf( '<%1$s %2$s>%3$s</%1$s>', $settings['name_size'], $this->get_render_attribute_string( 'team_member_name' ), $name );
							echo $name_html;
						?>
						</div>
					<?php } ?>
					<?php
					if ( 'yes' === $settings['separator_settings'] ) {
						if ( 'below_name' === $settings['separator_position'] ) {
							$this->get_separator_position();
						}
					}

					$this->add_render_attribute( 'team_member_desig', 'class', 'uael-team-desig' );
					$this->add_inline_editing_attributes( 'team_member_desig' );
					?>
					<?php if ( '' !== $settings['team_member_desig'] ) { ?>
						<div class="uael-team-member-designation">
							<div <?php echo $this->get_render_attribute_string( 'team_member_desig' ); ?>><?php echo $settings['team_member_desig']; ?>
							</div>
						</div>
					<?php } ?>
					<?php
					if ( 'yes' === $settings['separator_settings'] ) {
						if ( 'below_desig' === $settings['separator_position'] ) {
							$this->get_separator_position();
						}
					}
					$this->add_render_attribute( 'team_member_desc', 'class', 'uael-team-desc' );
					$this->add_inline_editing_attributes( 'team_member_desc' );
					?>
					<?php if ( '' !== $settings['team_member_desc'] ) { ?>
						<div class="uael-team-member-desc">
							<div <?php echo $this->get_render_attribute_string( 'team_member_desc' ); ?>><?php echo $settings['team_member_desc']; ?></div>
						</div>
					<?php } ?>
					<?php
					if ( 'yes' === $settings['separator_settings'] ) {
						if ( 'below_desc' === $settings['separator_position'] ) {
							$this->get_separator_position();
						}
					}

					?>
					<?php if ( 'yes' === $settings['social_icons_settings'] ) { ?>
						<div class="elementor-social-icons-wrapper">
							<div class="uael-team-social-icon">
							<?php
							foreach ( $settings['social_icon_list'] as $index => $item ) {

								if ( UAEL_Helper::is_elementor_updated() ) {

									$migration_allowed = \Elementor\Icons_Manager::is_migration_allowed();

									$migrated = isset( $item['__fa4_migrated']['new_social'] );
									$is_new   = empty( $item['social'] ) && $migration_allowed;
									$social   = '';

									// add old default.
									if ( empty( $item['social'] ) && ! $migration_allowed ) {
										$item['social'] = isset( $fallback_defaults[ $index ] ) ? $fallback_defaults[ $index ] : 'fa fa-wordpress';
									}

									if ( ! empty( $item['social'] ) ) {
										$social = str_replace( 'fa fa-', '', $item['social'] );
									}

									if ( ( $is_new || $migrated ) && 'svg' !== $item['new_social']['library'] ) {
										$social = explode( ' ', $item['new_social']['value'], 2 );
										if ( empty( $social[1] ) ) {
											$social = '';
										} else {
											$social = str_replace( 'fa-', '', $social[1] );
										}
									}
									if ( 'svg' === $item['new_social']['library'] ) {
										$social = '';
									}

									$link_key        = 'link_' . $index;
									$class_animation = ' elementor-animation-' . $settings['icon_hover_animation'];

									$this->add_render_attribute( $link_key, 'href', $item['link']['url'] );

									$this->add_render_attribute(
										$link_key,
										'class',
										[
											'elementor-icon',
											'elementor-social-icon',
											'elementor-social-icon-' . $social . $class_animation,
											'elementor-repeater-item-' . $item['_id'],
										]
									);

									if ( $item['link']['is_external'] ) {
										$this->add_render_attribute( $link_key, 'target', '_blank' );
									}
									if ( $item['link']['nofollow'] ) {
										$this->add_render_attribute( $link_key, 'rel', 'nofollow' );
									}

									?>
									<a <?php echo $this->get_render_attribute_string( $link_key ); ?>>
										<span class="elementor-screen-only"><?php echo ucwords( $social ); ?></span>
										<?php
										if ( $is_new || $migrated ) {
											\Elementor\Icons_Manager::render_icon( $item['new_social'] );
										} elseif ( ! empty( $item['social'] ) ) {
											?>
											<i class="<?php echo esc_attr( $item['social'] ); ?>"></i>
										<?php } ?>
									</a>
									<?php
								} elseif ( ! empty( $item['social'] ) ) {
									$social   = str_replace( 'fa fa-', '', $item['social'] );
									$link_key = 'link_' . $index;
									$this->add_render_attribute( $link_key, 'href', $item['link']['url'] );
									if ( $item['link']['is_external'] ) {
										$this->add_render_attribute( $link_key, 'target', '_blank' );
									}
									if ( $item['link']['nofollow'] ) {
										$this->add_render_attribute( $link_key, 'rel', 'nofollow' );
									}
									$class_animation = ' elementor-animation-' . $settings['icon_hover_animation'];
									?>
									<a class="elementor-icon elementor-social-icon elementor-social-icon-<?php echo $social . $class_animation; ?>" <?php echo $this->get_render_attribute_string( $link_key ); ?>>
										<span class="elementor-screen-only"><?php echo ucwords( $social ); ?></span>
										<i class="<?php echo $item['social']; ?>"></i>
									</a>
								<?php } ?>
							<?php } ?>
							</div>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
		<?php
	}

	/**
	 * Render heading widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 1.16.0
	 * @access protected
	 */
	protected function _content_template() {
		?>
		<#
			if ( 'left' == settings.image_position || 'right' == settings.image_position ) {
				if ( 'tablet' == settings.member_mob_view  ) {

					view.addRenderAttribute( 'member-classname', 'class', 'uael-member-stacked-tablet' );
				}
				if ( 'mobile' == settings.member_mob_view  ) {

					view.addRenderAttribute( 'member-classname', 'class', 'uael-member-stacked-mobile' );
				}
				if ( 'middle' == settings.member_image_valign ) {
					view.addRenderAttribute( 'member-classname', 'class', 'uael-member-image-valign-middle' );
				} else {
					view.addRenderAttribute( 'member-classname', 'class', 'uael-member-image-valign-top' );
				}
			}
			view.addRenderAttribute( 'member-classname', 'class', 'uael-team-member' );
		#>
		<div {{{ view.getRenderAttributeString( 'member-classname' ) }}} >
			<div class="uael-team-member-wrap">
				<div class="uael-member-wrap">
					<#
					var image = {
						id: settings.image.id,
						url: settings.image.url,
						size: settings.image_size,
						dimension: settings.image_custom_dimension,
						model: view.getEditModel()
					};

					var image_url = elementor.imagesManager.getImageUrl( image );
					if( image_url !== '' ) {
					#>
						<div class="uael-team-member-image"><img src="{{{ image_url }}}" class="elementor-animation-{{{settings.hover_animation}}}" ></div>
						<#
					}
					view.addRenderAttribute( 'member_content', 'class', 'uael-team-member-content' ); #>
					<div {{{ view.getRenderAttributeString( 'member_content' )}}} >
						<div class="uael-team-member-name">
							<# if ( '' !== settings.team_member_name ) {
								view.addRenderAttribute( 'team_member_name', 'class', 'uael-team-name' );
								view.addInlineEditingAttributes( 'team_member_name' );
								var memberNameHtml = settings.team_member_name;
								#>
								<{{{settings.name_size}}} {{{ view.getRenderAttributeString( 'team_member_name' )}}}>{{{settings.team_member_name}}}</{{{settings.name_size}}}>
							<# } #>
						</div>
						<# 
						if( 'yes' == settings.separator_settings) {
							if( 'below_name' == settings.separator_position ) { #>
								<div class="uael-separator-wrapper">
									<div class="uael-separator"></div>
								</div>
							<# } #>
						<# } #>
						<div class="uael-team-member-designation">
							<# if ( '' !== settings.team_member_desig ) {
								view.addRenderAttribute( 'team_member_desig', 'class', 'uael-team-desig' );

								view.addInlineEditingAttributes( 'team_member_desig' );

								var memberDesignHtml = settings.team_member_desig;
								#>
								<div {{{ view.getRenderAttributeString( 'team_member_desig' ) }}}>{{{ memberDesignHtml }}}</div>
							<# } #>
						</div>
						<# if( 'yes' == settings.separator_settings) {
							if( 'below_desig' == settings.separator_position ) { #>
								<div class="uael-separator-wrapper">
									<div class="uael-separator"></div>
								</div>
							<# } #>
						<# } #>
						<div class="uael-team-member-desc">
							<# if ( '' !== settings.team_member_desc ) {
								view.addRenderAttribute( 'team_member_desc', 'class', 'uael-team-desc' );

								view.addInlineEditingAttributes( 'team_member_desc' );

								var memberDescHtml = settings.team_member_desc;
								#>
								<div {{{ view.getRenderAttributeString( 'team_member_desc' ) }}}>{{{ memberDescHtml }}}</div>
							<# } #>
						</div>
						<# if( 'yes' == settings.separator_settings) {
							if( 'below_desc' == settings.separator_position ) { #>
								<div class="uael-separator-wrapper">
									<div class="uael-separator"></div>
								</div>
							<# } #>
						<# } #>
						<# if( 'yes' == settings.social_icons_settings) { #>
							<# var iconsHTML = {}; #>
							<div class="elementor-social-icons-wrapper">
								<div class="uael-team-social-icon">
									<# _.each( settings.social_icon_list, function( item, index ) { #>
										<?php if ( UAEL_Helper::is_elementor_updated() ) { ?>
											<# var link = item.link ? item.link.url : '',
												migrated = elementor.helpers.isIconMigrated( item, 'new_social' ),
												social = elementor.helpers.getSocialNetworkNameFromIcon( item.new_social, item.social, false, migrated );
												#>
												<a class="elementor-icon elementor-social-icon elementor-social-icon-{{ social }} elementor-animation-{{ settings.hover_animation }} elementor-repeater-item-{{item._id}}" href="{{ link }}">

												<span class="elementor-screen-only">{{{ social }}}</span>

												<#
													iconsHTML[ index ] = elementor.helpers.renderIcon( view, item.new_social, {}, 'i', 'object' );
													if ( ( ! item.social || migrated ) && iconsHTML[ index ] && iconsHTML[ index ].rendered ) { #>
														{{{ iconsHTML[ index ].value }}}
													<# } else { #>
														<i class="{{ item.social }}"></i>
													<# }
												#>
											</a>
										<?php } else { ?>
											<# var link = item.link ? item.link.url : '',
											social = item.social.replace( 'fa fa-', '' ); #>
											<a class="elementor-icon elementor-social-icon elementor-social-icon-{{ social }} elementor-animation-{{ settings.icon_hover_animation }}" href="{{ link }}">
												<span class="elementor-screen-only">{{{ social }}}</span>
												<i class="{{ item.social }}"></i>
											</a>
										<?php } ?>
									<# } ); #>
								</div>
							</div>
						<# } #>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
}

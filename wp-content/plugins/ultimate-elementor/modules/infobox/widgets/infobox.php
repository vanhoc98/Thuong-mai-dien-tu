<?php
/**
 * UAEL Infobox.
 *
 * @package UAEL
 */

namespace UltimateElementor\Modules\Infobox\Widgets;

// Elementor Classes.
use Elementor\Controls_Manager;
use Elementor\Control_Media;
use Elementor\Utils;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Scheme_Typography;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Css_Filter;

use UltimateElementor\Base\Common_Widget;
use UltimateElementor\Classes\UAEL_Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit;   // Exit if accessed directly.
}

/**
 * Class Infobox.
 */
class Infobox extends Common_Widget {

	/**
	 * Retrieve Infobox Widget name.
	 *
	 * @since 0.0.1
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return parent::get_widget_slug( 'Infobox' );
	}

	/**
	 * Retrieve Infobox Widget title.
	 *
	 * @since 0.0.1
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return parent::get_widget_title( 'Infobox' );
	}

	/**
	 * Retrieve Infobox Widget icon.
	 *
	 * @since 0.0.1
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return parent::get_widget_icon( 'Infobox' );
	}

	/**
	 * Retrieve Widget Keywords.
	 *
	 * @since 1.5.1
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_keywords() {
		return parent::get_widget_keywords( 'Infobox' );
	}

	/**
	 * Register Infobox controls.
	 *
	 * @since 0.0.1
	 * @access protected
	 */
	protected function _register_controls() {

		$this->register_general_content_controls();
		$this->register_imgicon_content_controls();
		$this->register_separator_content_controls();
		$this->register_cta_content_controls();
		$this->register_typo_content_controls();
		$this->register_margin_content_controls();
		$this->register_helpful_information();
	}

	/**
	 * Register Infobox General Controls.
	 *
	 * @since 0.0.1
	 * @access protected
	 */
	protected function register_general_content_controls() {
		$this->start_controls_section(
			'section_general_field',
			[
				'label' => __( 'General', 'uael' ),
			]
		);

		$this->add_control(
			'infobox_title_prefix',
			[
				'label'    => __( 'Title Prefix', 'uael' ),
				'type'     => Controls_Manager::TEXT,
				'dynamic'  => [
					'active' => true,
				],
				'selector' => '{{WRAPPER}} .uael-infobox-title-prefix',
			]
		);
		$this->add_control(
			'infobox_title',
			[
				'label'    => __( 'Title', 'uael' ),
				'type'     => Controls_Manager::TEXT,
				'selector' => '{{WRAPPER}} .uael-infobox-title',
				'dynamic'  => [
					'active' => true,
				],
				'default'  => __( 'Info Box', 'uael' ),
			]
		);
		$this->add_control(
			'infobox_description',
			[
				'label'    => __( 'Description', 'uael' ),
				'type'     => Controls_Manager::TEXTAREA,
				'selector' => '{{WRAPPER}} .uael-infobox-text',
				'dynamic'  => [
					'active' => true,
				],
				'default'  => __( 'Enter description text here.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.​', 'uael' ),
			]
		);

		$this->end_controls_section();

	}

	/**
	 * Register Infobox Image/Icon Controls.
	 *
	 * @since 0.0.1
	 * @access protected
	 */
	protected function register_imgicon_content_controls() {
		$this->start_controls_section(
			'section_image_field',
			[
				'label' => __( 'Image/Icon', 'uael' ),
			]
		);

		$this->add_control(
			'infobox_image_position',
			[
				'label'       => __( 'Select Position', 'uael' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'above-title',
				'label_block' => false,
				'options'     => [
					'above-title' => __( 'Above Heading', 'uael' ),
					'below-title' => __( 'Below Heading', 'uael' ),
					'left-title'  => __( 'Left of Heading', 'uael' ),
					'right-title' => __( 'Right of Heading', 'uael' ),
					'left'        => __( 'Left of Text and Heading', 'uael' ),
					'right'       => __( 'Right of Text and Heading', 'uael' ),
				],
			]
		);

		$this->add_responsive_control(
			'infobox_align',
			[
				'label'     => __( 'Overall Alignment', 'uael' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
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
				'default'   => 'center',
				'condition' => [
					'uael_infobox_image_type' => [ 'icon', 'photo' ],
					'infobox_image_position'  => [ 'above-title', 'below-title' ],
				],
				'selectors' => [
					'{{WRAPPER}} .uael-infobox,  {{WRAPPER}} .uael-separator-parent' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'infobox_img_mob_view',
			[
				'label'       => __( 'Responsive Support', 'uael' ),
				'description' => __( 'Choose on what breakpoint the Infobox will stack.', 'uael' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'tablet',
				'options'     => [
					'none'   => __( 'No', 'uael' ),
					'tablet' => __( 'For Tablet & Mobile ', 'uael' ),
					'mobile' => __( 'For Mobile Only', 'uael' ),
				],
				'condition'   => [
					'uael_infobox_image_type' => [ 'icon', 'photo' ],
					'infobox_image_position'  => [ 'left', 'right' ],
				],
			]
		);

		$this->add_control(
			'infobox_image_valign',
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
					'uael_infobox_image_type' => [ 'icon', 'photo' ],
					'infobox_image_position'  => [ 'left-title', 'right-title', 'left', 'right' ],
				],
			]
		);

		$this->add_responsive_control(
			'infobox_overall_align',
			[
				'label'     => __( 'Overall Alignment', 'uael' ),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => 'center',
				'options'   => [
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
				'condition' => [
					'uael_infobox_image_type!' => [ 'icon', 'photo' ],
				],
				'selectors' => [
					'{{WRAPPER}} .uael-infobox, {{WRAPPER}} .uael-separator-parent' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'infobox_imgicon_style',
			[
				'label'       => __( 'Image/Icon Style', 'uael' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'normal',
				'label_block' => false,
				'options'     => [
					'normal' => __( 'Normal', 'uael' ),
					'circle' => __( 'Circle Background', 'uael' ),
					'square' => __( 'Square / Rectangle Background', 'uael' ),
					'custom' => __( 'Design your own', 'uael' ),
				],
				'condition'   => [
					'uael_infobox_image_type!' => '',
				],
			]
		);
		$this->add_control(
			'uael_infobox_image_type',
			[
				'label'   => __( 'Image Type', 'uael' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'photo' => [
						'title' => __( 'Image', 'uael' ),
						'icon'  => 'fa fa-picture-o',
					],
					'icon'  => [
						'title' => __( 'Font Icon', 'uael' ),
						'icon'  => 'fa fa-info-circle',
					],
				],
				'default' => 'icon',
				'toggle'  => true,
			]
		);
		$this->add_control(
			'infobox_icon_basics',
			[
				'label'     => __( 'Icon Basics', 'uael' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => [
					'uael_infobox_image_type' => 'icon',
				],
			]
		);

		if ( UAEL_Helper::is_elementor_updated() ) {

			$this->add_control(
				'new_infobox_select_icon',
				[
					'label'            => __( 'Select Icon', 'uael' ),
					'type'             => Controls_Manager::ICONS,
					'fa4compatibility' => 'infobox_select_icon',
					'default'          => [
						'value'   => 'fa fa-star',
						'library' => 'fa-solid',
					],
					'condition'        => [
						'uael_infobox_image_type' => 'icon',
					],
					'render_type'      => 'template',
				]
			);
		} else {
			$this->add_control(
				'infobox_select_icon',
				[
					'label'     => __( 'Select Icon', 'uael' ),
					'type'      => Controls_Manager::ICON,
					'default'   => 'fa fa-star',
					'condition' => [
						'uael_infobox_image_type' => 'icon',
					],
				]
			);
		}

		$this->add_responsive_control(
			'infobox_icon_size',
			[
				'label'      => __( 'Size', 'uael' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem' ],
				'range'      => [
					'px' => [
						'min' => 1,
						'max' => 200,
					],
				],
				'default'    => [
					'size' => 40,
					'unit' => 'px',
				],
				'conditions' => [
					'relation' => 'and',
					'terms'    => [
						[
							'name'     => UAEL_Helper::get_new_icon_name( 'infobox_select_icon' ),
							'operator' => '!=',
							'value'    => '',
						],
						[
							'name'     => 'uael_infobox_image_type',
							'operator' => '==',
							'value'    => 'icon',
						],
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .uael-icon-wrap .uael-icon i' => 'font-size: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};line-height: {{SIZE}}{{UNIT}}; text-align: center;',
					'{{WRAPPER}} .uael-icon-wrap .uael-icon' => ' height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};line-height: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'infobox_icon_rotate',
			[
				'label'      => __( 'Rotate', 'uael' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => [
					'size' => 0,
					'unit' => 'deg',
				],
				'selectors'  => [
					'{{WRAPPER}} .uael-icon-wrap .uael-icon i,
					{{WRAPPER}} .uael-icon-wrap .uael-icon svg' => 'transform: rotate({{SIZE}}{{UNIT}});',
				],
				'conditions' => [
					'relation' => 'and',
					'terms'    => [
						[
							'name'     => UAEL_Helper::get_new_icon_name( 'infobox_select_icon' ),
							'operator' => '!=',
							'value'    => '',
						],
						[
							'name'     => 'uael_infobox_image_type',
							'operator' => '==',
							'value'    => 'icon',
						],
					],
				],
			]
		);
		$this->add_control(
			'infobox_image_basics',
			[
				'label'     => __( 'Image Basics', 'uael' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => [
					'uael_infobox_image_type' => 'photo',
				],
			]
		);
		$this->add_control(
			'uael_infobox_photo_type',
			[
				'label'       => __( 'Photo Source', 'uael' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'media',
				'label_block' => false,
				'options'     => [
					'media' => __( 'Media Library', 'uael' ),
					'url'   => __( 'URL', 'uael' ),
				],
				'condition'   => [
					'uael_infobox_image_type' => 'photo',
				],
			]
		);
		$this->add_control(
			'infobox_image',
			[
				'label'     => __( 'Photo', 'uael' ),
				'type'      => Controls_Manager::MEDIA,
				'dynamic'   => [
					'active' => true,
				],
				'default'   => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'uael_infobox_image_type' => 'photo',
					'uael_infobox_photo_type' => 'media',

				],
			]
		);
		$this->add_control(
			'infobox_image_link',
			[
				'label'         => __( 'Photo URL', 'uael' ),
				'type'          => Controls_Manager::URL,
				'default'       => [
					'url' => '',
				],
				'show_external' => false, // Show the 'open in new tab' button.
				'condition'     => [
					'uael_infobox_image_type' => 'photo',
					'uael_infobox_photo_type' => 'url',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'image', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `image_size` and `image_custom_dimension`.
				'default'   => 'full',
				'separator' => 'none',
				'condition' => [
					'uael_infobox_image_type' => 'photo',
					'uael_infobox_photo_type' => 'media',
				],
			]
		);

		$this->add_responsive_control(
			'infobox_image_size',
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
				'condition'  => [
					'uael_infobox_image_type' => 'photo',
				],
				'selectors'  => [
					'{{WRAPPER}} .uael-image img' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

			$this->add_responsive_control(
				'infobox_icon_bg_size',
				[
					'label'      => __( 'Background Size', 'uael' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'range'      => [
						'px' => [
							'min' => 0,
							'max' => 200,
						],
					],
					'default'    => [
						'size' => 20,
						'unit' => 'px',
					],
					'condition'  => [
						'uael_infobox_image_type' => [ 'icon', 'photo' ],
						'infobox_imgicon_style!'  => 'normal',
					],
					'selectors'  => [
						'{{WRAPPER}} .uael-icon-wrap .uael-icon, {{WRAPPER}} .uael-image .uael-image-content img' => 'padding: {{SIZE}}{{UNIT}}; display:inline-block; box-sizing:content-box;',
					],
				]
			);

		$this->start_controls_tabs( 'infobox_tabs_icon_style' );

			$this->start_controls_tab(
				'infobox_icon_normal',
				[
					'label'     => __( 'Normal', 'uael' ),
					'condition' => [
						'uael_infobox_image_type' => [ 'icon', 'photo' ],
						'infobox_imgicon_style!'  => 'normal',
					],
				]
			);
			$this->add_control(
				'infobox_icon_color',
				[
					'label'      => __( 'Icon Color', 'uael' ),
					'type'       => Controls_Manager::COLOR,
					'scheme'     => [
						'type'  => Scheme_Color::get_type(),
						'value' => Scheme_Color::COLOR_1,
					],
					'conditions' => [
						'relation' => 'and',
						'terms'    => [
							[
								'name'     => UAEL_Helper::get_new_icon_name( 'infobox_select_icon' ),
								'operator' => '!=',
								'value'    => '',
							],
							[
								'name'     => 'uael_infobox_image_type',
								'operator' => '==',
								'value'    => 'icon',
							],
						],
					],
					'default'    => '',
					'selectors'  => [
						'{{WRAPPER}} .uael-icon-wrap .uael-icon i' => 'color: {{VALUE}};',
						'{{WRAPPER}} .uael-icon-wrap .uael-icon svg' => 'fill: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'infobox_icons_hover_color',
				[
					'label'      => __( 'Icon Hover Color', 'uael' ),
					'type'       => Controls_Manager::COLOR,
					'conditions' => [
						'relation' => 'and',
						'terms'    => [
							[
								'name'     => UAEL_Helper::get_new_icon_name( 'infobox_select_icon' ),
								'operator' => '!=',
								'value'    => '',
							],
							[
								'name'     => 'uael_infobox_image_type',
								'operator' => '==',
								'value'    => 'icon',
							],
							[
								'name'     => 'infobox_imgicon_style',
								'operator' => '==',
								'value'    => 'normal',
							],
						],
					],
					'default'    => '',
					'selectors'  => [
						'{{WRAPPER}} .uael-icon-wrap .uael-icon:hover > i, {{WRAPPER}} .uael-infobox-link-type-module .uael-infobox-module-link:hover ~ .uael-infobox-content .uael-imgicon-wrap i, {{WRAPPER}} .uael-infobox-link-type-module .uael-infobox-module-link:hover ~ .uael-imgicon-wrap i' => 'color: {{VALUE}};',
						'{{WRAPPER}} .uael-icon-wrap .uael-icon:hover > svg, {{WRAPPER}} .uael-infobox-link-type-module .uael-infobox-module-link:hover ~ .uael-infobox-content .uael-imgicon-wrap svg, {{WRAPPER}} .uael-infobox-link-type-module .uael-infobox-module-link:hover ~ .uael-imgicon-wrap svg' => 'fill: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'infobox_icon_bgcolor',
				[
					'label'     => __( 'Background Color', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'scheme'    => [
						'type'  => Scheme_Color::get_type(),
						'value' => Scheme_Color::COLOR_2,
					],
					'default'   => '',
					'condition' => [
						'uael_infobox_image_type' => [ 'icon', 'photo' ],
						'infobox_imgicon_style!'  => 'normal',
					],
					'selectors' => [
						'{{WRAPPER}} .uael-icon-wrap .uael-icon, {{WRAPPER}} .uael-image .uael-image-content img' => 'background-color: {{VALUE}};',
						'{{WRAPPER}} .uael-imgicon-style-normal .uael-icon-wrap .uael-icon, {{WRAPPER}} .uael-imgicon-style-normal .uael-image .uael-image-content img' => 'background: none;',
					],
				]
			);

			$this->add_control(
				'infobox_icon_border',
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
					'condition'   => [
						'uael_infobox_image_type' => [ 'icon', 'photo' ],
						'infobox_imgicon_style'   => 'custom',
					],
					'selectors'   => [
						'{{WRAPPER}} .uael-imgicon-style-custom .uael-icon-wrap .uael-icon, {{WRAPPER}} .uael-imgicon-style-custom .uael-image .uael-image-content img' => 'border-style: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'infobox_icon_border_color',
				[
					'label'     => __( 'Border Color', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'scheme'    => [
						'type'  => Scheme_Color::get_type(),
						'value' => Scheme_Color::COLOR_1,
					],
					'condition' => [
						'uael_infobox_image_type' => [ 'icon', 'photo' ],
						'infobox_imgicon_style'   => 'custom',
						'infobox_icon_border!'    => 'none',
					],
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .uael-imgicon-style-custom .uael-icon-wrap .uael-icon, {{WRAPPER}} .uael-imgicon-style-custom .uael-image .uael-image-content img' => 'border-color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'infobox_icon_border_size',
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
						'uael_infobox_image_type' => [ 'icon', 'photo' ],
						'infobox_imgicon_style'   => 'custom',
						'infobox_icon_border!'    => 'none',
					],
					'selectors'  => [
						'{{WRAPPER}} .uael-imgicon-style-custom .uael-icon-wrap .uael-icon, {{WRAPPER}} .uael-imgicon-style-custom .uael-image .uael-image-content img' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; box-sizing:content-box;',
					],
				]
			);

			$this->add_responsive_control(
				'infobox_icon_border_radius',
				[
					'label'      => __( 'Rounded Corners', 'uael' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'default'    => [
						'top'    => '5',
						'bottom' => '5',
						'left'   => '5',
						'right'  => '5',
						'unit'   => 'px',
					],
					'condition'  => [
						'uael_infobox_image_type' => [ 'icon', 'photo' ],
						'infobox_imgicon_style!'  => [ 'normal', 'circle', 'square' ],
					],
					'selectors'  => [
						'{{WRAPPER}} .uael-imgicon-style-custom .uael-icon-wrap .uael-icon, {{WRAPPER}} .uael-imgicon-style-custom .uael-image .uael-image-content img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; box-sizing:content-box;',
					],
				]
			);

			$this->add_control(
				'css_filters_heading',
				[
					'label'     => __( 'Image Style', 'uael' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						'uael_infobox_image_type' => 'photo',
						'infobox_imgicon_style'   => 'custom',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Css_Filter::get_type(),
				[
					'name'      => 'css_filters',
					'selector'  => '{{WRAPPER}} .uael-image .uael-image-content img',
					'condition' => [
						'uael_infobox_image_type' => 'photo',
						'infobox_imgicon_style!'  => 'normal',
					],
				]
			);

			$this->add_control(
				'image_opacity',
				[
					'label'     => __( 'Image Opacity', 'uael' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'max'  => 1,
							'min'  => 0.10,
							'step' => 0.01,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .uael-image .uael-image-content img' => 'opacity: {{SIZE}};',
					],
					'condition' => [
						'uael_infobox_image_type' => 'photo',
						'infobox_imgicon_style!'  => 'normal',
					],
				]
			);

			$this->add_control(
				'background_hover_transition',
				[
					'label'     => __( 'Transition Duration', 'uael' ),
					'type'      => Controls_Manager::SLIDER,
					'default'   => [
						'size' => 0.3,
					],
					'range'     => [
						'px' => [
							'max'  => 3,
							'step' => 0.1,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .uael-image .uael-image-content img' => 'transition-duration: {{SIZE}}s',
					],
					'condition' => [
						'uael_infobox_image_type' => 'photo',
						'infobox_imgicon_style!'  => 'normal',
					],
				]
			);

			$this->end_controls_tab();

			$this->start_controls_tab(
				'infobox_icon_hover',
				[
					'label'     => __( 'Hover', 'uael' ),
					'condition' => [
						'uael_infobox_image_type' => [ 'icon', 'photo' ],
						'infobox_imgicon_style!'  => 'normal',
					],
				]
			);
				$this->add_control(
					'infobox_icon_hover_color',
					[
						'label'      => __( 'Icon Hover Color', 'uael' ),
						'type'       => Controls_Manager::COLOR,
						'conditions' => [
							'relation' => 'and',
							'terms'    => [
								[
									'name'     => UAEL_Helper::get_new_icon_name( 'infobox_select_icon' ),
									'operator' => '!=',
									'value'    => '',
								],
								[
									'name'     => 'uael_infobox_image_type',
									'operator' => '==',
									'value'    => 'icon',
								],
							],
						],
						'default'    => '',
						'selectors'  => [
							'{{WRAPPER}} .uael-icon-wrap .uael-icon:hover > i, {{WRAPPER}} .uael-infobox-link-type-module .uael-infobox-module-link:hover ~ .uael-infobox-content .uael-imgicon-wrap i, {{WRAPPER}} .uael-infobox-link-type-module .uael-infobox-module-link:hover ~ .uael-imgicon-wrap i' => 'color: {{VALUE}};',
							'{{WRAPPER}} .uael-icon-wrap .uael-icon:hover > svg, {{WRAPPER}} .uael-infobox-link-type-module .uael-infobox-module-link:hover ~ .uael-infobox-content .uael-imgicon-wrap svg, {{WRAPPER}} .uael-infobox-link-type-module .uael-infobox-module-link:hover ~ .uael-imgicon-wrap svg' => 'fill: {{VALUE}};',
						],
					]
				);

				$this->add_control(
					'infobox_icon_hover_bgcolor',
					[
						'label'     => __( 'Background Hover Color', 'uael' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '',
						'condition' => [
							'uael_infobox_image_type' => [ 'icon', 'photo' ],
							'infobox_imgicon_style!'  => 'normal',
						],
						'selectors' => [
							'{{WRAPPER}} .uael-icon-wrap .uael-icon:hover, {{WRAPPER}} .uael-image-content img:hover, {{WRAPPER}} .uael-infobox-link-type-module .uael-infobox-module-link:hover ~ .uael-infobox-content .uael-imgicon-wrap .uael-icon, {{WRAPPER}} .uael-infobox-link-type-module .uael-infobox-module-link:hover ~ .uael-imgicon-wrap .uael-icon, {{WRAPPER}} .uael-infobox-link-type-module .uael-infobox-module-link:hover ~ .uael-image .uael-image-content img, {{WRAPPER}} .uael-infobox-link-type-module .uael-infobox-module-link:hover ~ .uael-imgicon-wrap img' => 'background-color: {{VALUE}};',
						],
					]
				);

				$this->add_control(
					'infobox_icon_hover_border',
					[
						'label'     => __( 'Border Hover Color', 'uael' ),
						'type'      => Controls_Manager::COLOR,
						'condition' => [
							'uael_infobox_image_type' => [ 'icon', 'photo' ],
							'infobox_icon_border!'    => 'none',
							'infobox_imgicon_style!'  => 'normal',
						],
						'default'   => '',
						'selectors' => [
							'{{WRAPPER}} .uael-icon-wrap .uael-icon:hover, {{WRAPPER}} .uael-image-content img:hover,  {{WRAPPER}} .uael-infobox-link-type-module .uael-infobox-module-link:hover ~ .uael-infobox-content .uael-imgicon-wrap .uael-icon, {{WRAPPER}} .uael-infobox-link-type-module .uael-infobox-module-link:hover ~ .uael-imgicon-wrap .uael-icon, {{WRAPPER}} .uael-infobox-link-type-module .uael-infobox-module-link:hover ~ .uael-image .uael-image-content img, {{WRAPPER}} .uael-infobox-link-type-module .uael-infobox-module-link:hover ~ .uael-imgicon-wrap img ' => 'border-color: {{VALUE}};',
						],
					]
				);

				$this->add_group_control(
					Group_Control_Css_Filter::get_type(),
					[
						'name'      => 'hover_css_filters',
						'selector'  => '{{WRAPPER}} .uael-image-content img:hover, {{WRAPPER}} .uael-infobox-link-type-module .uael-infobox-module-link:hover ~ .uael-imgicon-wrap .uael-icon, {{WRAPPER}} .uael-infobox-link-type-module .uael-infobox-module-link:hover ~ .uael-image .uael-image-content img, {{WRAPPER}} .uael-infobox-link-type-module .uael-infobox-module-link:hover ~ .uael-imgicon-wrap img',
						'condition' => [
							'uael_infobox_image_type' => 'photo',
							'infobox_imgicon_style!'  => 'normal',
						],
					]
				);

				$this->add_control(
					'hover_image_opacity',
					[
						'label'     => __( 'Opacity', 'uael' ),
						'type'      => Controls_Manager::SLIDER,
						'range'     => [
							'px' => [
								'max'  => 1,
								'min'  => 0.10,
								'step' => 0.01,
							],
						],
						'selectors' => [
							'{{WRAPPER}} .uael-image-content img:hover, {{WRAPPER}} .uael-infobox-link-type-module .uael-infobox-module-link:hover ~ .uael-imgicon-wrap .uael-icon, {{WRAPPER}} .uael-infobox-link-type-module .uael-infobox-module-link:hover ~ .uael-image .uael-image-content img, {{WRAPPER}} .uael-infobox-link-type-module .uael-infobox-module-link:hover ~ .uael-imgicon-wrap img' => 'opacity: {{SIZE}};',
						],
						'condition' => [
							'uael_infobox_image_type' => 'photo',
							'infobox_imgicon_style!'  => 'normal',
						],
					]
				);

				$this->add_control(
					'infobox_imgicon_animation',
					[
						'label'     => __( 'Hover Animation', 'uael' ),
						'type'      => Controls_Manager::HOVER_ANIMATION,
						'condition' => [
							'uael_infobox_image_type' => [ 'icon', 'photo' ],
							'infobox_imgicon_style!'  => 'normal',
						],
					]
				);
			$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'normal_imgicon_animation',
			[
				'label'     => __( 'Hover Animation', 'uael' ),
				'type'      => Controls_Manager::HOVER_ANIMATION,
				'condition' => [
					'uael_infobox_image_type' => [ 'icon', 'photo' ],
					'infobox_imgicon_style'   => 'normal',
				],
			]
		);

		$this->add_control(
			'normal_css_filters_heading',
			[
				'label'     => __( 'Image Style', 'uael' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'uael_infobox_image_type' => 'photo',
					'infobox_imgicon_style'   => 'normal',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name'      => 'normal_css_filters',
				'selector'  => '{{WRAPPER}} .uael-image .uael-image-content img',
				'condition' => [
					'uael_infobox_image_type' => 'photo',
					'infobox_imgicon_style'   => 'normal',
				],
			]
		);

		$this->add_control(
			'normal_image_opacity',
			[
				'label'     => __( 'Image Opacity', 'uael' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max'  => 1,
						'min'  => 0.10,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .uael-image .uael-image-content img' => 'opacity: {{SIZE}};',
				],
				'condition' => [
					'uael_infobox_image_type' => 'photo',
					'infobox_imgicon_style'   => 'normal',
				],
			]
		);

		$this->add_control(
			'normal_bg_hover_transition',
			[
				'label'     => __( 'Transition Duration', 'uael' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 0.3,
				],
				'range'     => [
					'px' => [
						'max'  => 3,
						'step' => 0.1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .uael-image .uael-image-content img' => 'transition-duration: {{SIZE}}s',
				],
				'condition' => [
					'uael_infobox_image_type' => 'photo',
					'infobox_imgicon_style'   => 'normal',
				],
			]
		);

		// End of section for Image Background color if custom design enabled.
		$this->end_controls_section();
	}

	/**
	 * Register Infobox Separator Controls.
	 *
	 * @since 0.0.1
	 * @access protected
	 */
	protected function register_separator_content_controls() {

		$this->start_controls_section(
			'section_separator_field',
			[
				'label' => __( 'Separator', 'uael' ),
			]
		);

		$this->add_control(
			'infobox_separator',
			[
				'label'        => __( 'Separator', 'uael' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'uael' ),
				'label_off'    => __( 'No', 'uael' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);

		$this->add_control(
			'infobox_separator_position',
			[
				'label'       => __( 'Position', 'uael' ),
				'type'        => Controls_Manager::SELECT,
				'label_block' => false,
				'default'     => 'after_heading',
				'options'     => [
					'after_prefix'      => __( 'After Prefix', 'uael' ),
					'after_heading'     => __( 'After Heading', 'uael' ),
					'after_description' => __( 'After Description', 'uael' ),
				],
				'condition'   => [
					'infobox_separator' => 'yes',
				],
			]
		);

		$this->add_control(
			'infobox_separator_style',
			[
				'label'       => __( 'Style', 'uael' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'solid',
				'label_block' => false,
				'options'     => [
					'solid'  => __( 'Solid', 'uael' ),
					'dashed' => __( 'Dashed', 'uael' ),
					'dotted' => __( 'Dotted', 'uael' ),
					'double' => __( 'Double', 'uael' ),
				],
				'condition'   => [
					'infobox_separator' => 'yes',
				],
				'selectors'   => [
					'{{WRAPPER}} .uael-separator' => 'border-top-style: {{VALUE}}; display: inline-block;',
				],
			]
		);

		$this->add_control(
			'infobox_separator_color',
			[
				'label'     => __( 'Color', 'uael' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_4,
				],
				'condition' => [
					'infobox_separator' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .uael-separator' => 'border-top-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'infobox_separator_thickness',
			[
				'label'      => __( 'Thickness', 'uael' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem' ],
				'range'      => [
					'px' => [
						'min' => 1,
						'max' => 200,
					],
				],
				'default'    => [
					'size' => 3,
					'unit' => 'px',
				],
				'condition'  => [
					'infobox_separator' => 'yes',
				],
				'selectors'  => [
					'{{WRAPPER}} .uael-separator' => 'border-top-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'infobox_separator_width',
			[
				'label'          => __( 'Width', 'uael' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => [ '%', 'px' ],
				'range'          => [
					'px' => [
						'max' => 1000,
					],
				],
				'default'        => [
					'size' => 30,
					'unit' => '%',
				],
				'tablet_default' => [
					'unit' => '%',
				],
				'mobile_default' => [
					'unit' => '%',
				],
				'label_block'    => true,
				'condition'      => [
					'infobox_separator' => 'yes',
				],
				'selectors'      => [
					'{{WRAPPER}} .uael-separator' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Register Infobox CTA Controls.
	 *
	 * @since 0.0.1
	 * @access protected
	 */
	protected function register_cta_content_controls() {
		$this->start_controls_section(
			'section_cta_field',
			[
				'label' => __( 'Call To Action', 'uael' ),
			]
		);

		$this->add_control(
			'infobox_cta_type',
			[
				'label'       => __( 'Type', 'uael' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'none',
				'label_block' => false,
				'options'     => [
					'none'   => __( 'None', 'uael' ),
					'link'   => __( 'Text', 'uael' ),
					'button' => __( 'Button', 'uael' ),
					'module' => __( 'Complete Box', 'uael' ),
				],
			]
		);

		$this->add_control(
			'infobox_link_text',
			[
				'label'     => __( 'Text', 'uael' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => __( 'Read More', 'uael' ),
				'dynamic'   => [
					'active' => true,
				],
				'condition' => [
					'infobox_cta_type' => 'link',
				],
			]
		);

		$this->add_control(
			'infobox_button_text',
			[
				'label'     => __( 'Text', 'uael' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => __( 'Click Here', 'uael' ),
				'dynamic'   => [
					'active' => true,
				],
				'condition' => [
					'infobox_cta_type' => 'button',
				],
			]
		);

		$this->add_control(
			'infobox_text_link',
			[
				'label'         => __( 'Link', 'uael' ),
				'type'          => Controls_Manager::URL,
				'default'       => [
					'url'         => '#',
					'is_external' => '',
				],
				'dynamic'       => [
					'active' => true,
				],
				'show_external' => true, // Show the 'open in new tab' button.
				'condition'     => [
					'infobox_cta_type!' => 'none',
				],
				'selector'      => '{{WRAPPER}} a.uael-infobox-cta-link',
			]
		);

		$this->add_control(
			'infobox_button_size',
			[
				'label'     => __( 'Size', 'uael' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'sm',
				'options'   => [
					'xs' => __( 'Extra Small', 'uael' ),
					'sm' => __( 'Small', 'uael' ),
					'md' => __( 'Medium', 'uael' ),
					'lg' => __( 'Large', 'uael' ),
					'xl' => __( 'Extra Large', 'uael' ),
				],
				'condition' => [
					'infobox_cta_type' => 'button',
				],
			]
		);

		$this->add_control(
			'infobox_icon_structure',
			[
				'label'     => __( 'Icon', 'uael' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'infobox_cta_type' => [ 'button', 'link' ],
				],
			]
		);

		if ( UAEL_Helper::is_elementor_updated() ) {

			$this->add_control(
				'new_infobox_button_icon',
				[
					'label'            => __( 'Select Icon', 'uael' ),
					'type'             => Controls_Manager::ICONS,
					'fa4compatibility' => 'infobox_button_icon',
					'condition'        => [
						'infobox_cta_type' => [ 'button', 'link' ],
					],
					'render_type'      => 'template',
				]
			);
		} else {
			$this->add_control(
				'infobox_button_icon',
				[
					'label'       => __( 'Select Icon', 'uael' ),
					'type'        => Controls_Manager::ICON,
					'condition'   => [
						'infobox_cta_type' => [ 'button', 'link' ],
					],
					'render_type' => 'template',
				]
			);
		}
		$this->add_control(
			'infobox_button_icon_position',
			[
				'label'       => __( 'Icon Position', 'uael' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'right',
				'label_block' => false,
				'options'     => [
					'right' => __( 'After Text', 'uael' ),
					'left'  => __( 'Before Text', 'uael' ),
				],
				'condition'   => [
					'infobox_cta_type' => [ 'button', 'link' ],
				],
			]
		);
		$this->add_control(
			'infobox_icon_spacing',
			[
				'label'     => __( 'Icon Spacing', 'uael' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'default'   => [
					'size' => '5',
					'unit' => 'px',
				],
				'condition' => [
					'infobox_cta_type' => [ 'button', 'link' ],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-button .elementor-align-icon-right,{{WRAPPER}} .uael-infobox-link-icon-after' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .elementor-button .elementor-align-icon-left, {{WRAPPER}} .uael-infobox-link-icon-before' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'infobox_button_colors',
			[
				'label'     => __( 'Colors', 'uael' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'infobox_cta_type' => 'button',
				],
			]
		);

		$this->start_controls_tabs( 'infobox_tabs_button_style' );

			$this->start_controls_tab(
				'infobox_button_normal',
				[
					'label'     => __( 'Normal', 'uael' ),
					'condition' => [
						'infobox_cta_type' => 'button',
					],
				]
			);
			$this->add_control(
				'infobox_button_text_color',
				[
					'label'     => __( 'Text Color', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'condition' => [
						'infobox_cta_type' => 'button',
					],
					'selectors' => [
						'{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-button' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'           => 'btn_background_color',
					'label'          => __( 'Background Color', 'uael' ),
					'types'          => [ 'classic', 'gradient' ],
					'selector'       => '{{WRAPPER}} .elementor-button',
					'condition'      => [
						'infobox_cta_type' => 'button',
					],
					'fields_options' => [
						'color' => [
							'scheme' => [
								'type'  => Scheme_Color::get_type(),
								'value' => Scheme_Color::COLOR_4,
							],
						],
					],
				]
			);

			$this->add_control(
				'infobox_button_border',
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
					'condition'   => [
						'infobox_cta_type' => 'button',
					],
					'selectors'   => [
						'{{WRAPPER}} .elementor-button' => 'border-style: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'infobox_button_border_color',
				[
					'label'     => __( 'Border Color', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'condition' => [
						'infobox_cta_type'       => 'button',
						'infobox_button_border!' => 'none',
					],
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .elementor-button' => 'border-color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'infobox_button_border_size',
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
						'infobox_cta_type'       => 'button',
						'infobox_button_border!' => 'none',
					],
					'selectors'  => [
						'{{WRAPPER}} .elementor-button' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_control(
				'infobox_button_radius',
				[
					'label'      => __( 'Rounded Corners', 'uael' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'default'    => [
						'top'    => '0',
						'bottom' => '0',
						'left'   => '0',
						'right'  => '0',
						'unit'   => 'px',
					],
					'selectors'  => [
						'{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'infobox_cta_type' => 'button',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'      => 'infobox_button_box_shadow',
					'selector'  => '{{WRAPPER}} .elementor-button',
					'condition' => [
						'infobox_cta_type' => 'button',
					],
				]
			);

			$this->add_responsive_control(
				'infobox_button_custom_padding',
				[
					'label'      => __( 'Padding', 'uael' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors'  => [
						'{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'infobox_cta_type' => 'button',
					],
				]
			);

			$this->end_controls_tab();

			$this->start_controls_tab(
				'infobox_button_hover',
				[
					'label'     => __( 'Hover', 'uael' ),
					'condition' => [
						'infobox_cta_type' => 'button',
					],
				]
			);
			$this->add_control(
				'infobox_button_hover_color',
				[
					'label'     => __( 'Text Hover Color', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'condition' => [
						'infobox_cta_type' => 'button',
					],
					'selectors' => [
						'{{WRAPPER}} a.elementor-button:hover, {{WRAPPER}} .elementor-button:hover' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'           => 'infobox_button_hover_bgcolor',
					'label'          => __( 'Background Hover Color', 'uael' ),
					'types'          => [ 'classic', 'gradient' ],
					'selector'       => '{{WRAPPER}} a.elementor-button:hover, {{WRAPPER}} .elementor-button:hover',
					'condition'      => [
						'infobox_cta_type' => 'button',
					],
					'fields_options' => [
						'color' => [
							'scheme' => [
								'type'  => Scheme_Color::get_type(),
								'value' => Scheme_Color::COLOR_4,
							],
						],
					],
				]
			);

			$this->add_control(
				'infobox_button_border_hover_color',
				[
					'label'     => __( 'Border Color', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'condition' => [
						'infobox_cta_type'       => 'button',
						'infobox_button_border!' => 'none',
					],
					'selectors' => [
						'{{WRAPPER}} a.elementor-button:hover, {{WRAPPER}} .elementor-button:hover' => 'border-color: {{VALUE}};',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'      => 'cta_hover_box_shadow',
					'label'     => __( 'Box Shadow', 'uael' ),
					'condition' => [
						'infobox_cta_type' => 'button',
					],
					'selector'  => '{{WRAPPER}} .uael-button-wrapper .elementor-button-link:hover',
				]
			);

			$this->add_control(
				'infobox_button_animation',
				[
					'label'       => __( 'Hover Animation', 'uael' ),
					'type'        => Controls_Manager::HOVER_ANIMATION,
					'label_block' => false,
					'condition'   => [
						'infobox_cta_type' => 'button',
					],
					'selector'    => '{{WRAPPER}} .elementor-button',
				]
			);

			$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	/**
	 * Register Infobox Typography Controls.
	 *
	 * @since 0.0.1
	 * @access protected
	 */
	protected function register_typo_content_controls() {
		$this->start_controls_section(
			'section_typography_field',
			[
				'label' => __( 'Typography', 'uael' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'infobox_prefix_typo',
			[
				'label'     => __( 'Title Prefix', 'uael' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => [
					'infobox_title_prefix!' => '',
				],
			]
		);
		$this->add_control(
			'infobox_prefix_tag',
			[
				'label'     => __( 'Prefix Tag', 'uael' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'h1'  => __( 'H1', 'uael' ),
					'h2'  => __( 'H2', 'uael' ),
					'h3'  => __( 'H3', 'uael' ),
					'h4'  => __( 'H4', 'uael' ),
					'h5'  => __( 'H5', 'uael' ),
					'h6'  => __( 'H6', 'uael' ),
					'div' => __( 'div', 'uael' ),
					'p'   => __( 'p', 'uael' ),
				],
				'default'   => 'h5',
				'condition' => [
					'infobox_title_prefix!' => '',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'prefix_typography',
				'scheme'    => Scheme_Typography::TYPOGRAPHY_2,
				'selector'  => '{{WRAPPER}} .uael-infobox-title-prefix',
				'condition' => [
					'infobox_title_prefix!' => '',
				],
			]
		);
		$this->add_control(
			'infobox_prefix_color',
			[
				'label'     => __( 'Color', 'uael' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				],
				'default'   => '',
				'condition' => [
					'infobox_title_prefix!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .uael-infobox-title-prefix' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'infobox_prefix_hover_color',
			[
				'label'     => __( 'Hover Color', 'uael' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'condition' => [
					'infobox_title_prefix!' => '',
					'infobox_cta_type'      => 'module',
				],
				'selectors' => [
					'{{WRAPPER}} .uael-infobox-link-type-module .uael-infobox-module-link:hover + .uael-infobox-content .uael-infobox-title-prefix' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'infobox_prefix_title_separator',
			[
				'type'      => Controls_Manager::DIVIDER,
				'style'     => 'default',
				'condition' => [
					'infobox_title_prefix!' => '',
				],
			]
		);

		$this->add_control(
			'infobox_title_typo',
			[
				'label'     => __( 'Title', 'uael' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => [
					'infobox_title!' => '',
				],
			]
		);
		$this->add_control(
			'infobox_title_tag',
			[
				'label'     => __( 'Title Tag', 'uael' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'h1'  => __( 'H1', 'uael' ),
					'h2'  => __( 'H2', 'uael' ),
					'h3'  => __( 'H3', 'uael' ),
					'h4'  => __( 'H4', 'uael' ),
					'h5'  => __( 'H5', 'uael' ),
					'h6'  => __( 'H6', 'uael' ),
					'div' => __( 'div', 'uael' ),
					'p'   => __( 'p', 'uael' ),
				],
				'default'   => 'h3',
				'condition' => [
					'infobox_title!' => '',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'title_typography',
				'scheme'    => Scheme_Typography::TYPOGRAPHY_1,
				'selector'  => '{{WRAPPER}} .uael-infobox-title',
				'condition' => [
					'infobox_title!' => '',
				],
			]
		);
		$this->add_control(
			'infobox_title_color',
			[
				'label'     => __( 'Color', 'uael' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'default'   => '',
				'condition' => [
					'infobox_title!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .uael-infobox-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'infobox_title_hover_color',
			[
				'label'     => __( 'Hover Color', 'uael' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'condition' => [
					'infobox_title!'   => '',
					'infobox_cta_type' => 'module',
				],
				'selectors' => [
					'{{WRAPPER}} .uael-infobox-link-type-module a.uael-infobox-module-link:hover + .uael-infobox-content .uael-infobox-title' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'infobox_desc_typo',
			[
				'label'     => __( 'Description', 'uael' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'infobox_description!' => '',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'desc_typography',
				'scheme'    => Scheme_Typography::TYPOGRAPHY_3,
				'selector'  => '{{WRAPPER}} .uael-infobox-text',
				'condition' => [
					'infobox_description!' => '',
				],
			]
		);
		$this->add_control(
			'infobox_desc_color',
			[
				'label'     => __( 'Description Color', 'uael' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				],
				'default'   => '',
				'condition' => [
					'infobox_description!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .uael-infobox-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'infobox_desc_hover_color',
			[
				'label'     => __( 'Hover Color', 'uael' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'condition' => [
					'infobox_description!' => '',
					'infobox_cta_type'     => 'module',
				],
				'selectors' => [
					'{{WRAPPER}} .uael-infobox-link-type-module a.uael-infobox-module-link:hover + .uael-infobox-content .uael-infobox-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'infobox_link_typo',
			[
				'label'     => __( 'CTA Link Text', 'uael' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'infobox_cta_type' => 'link',
				],
			]
		);

		$this->add_control(
			'infobox_button_typo',
			[
				'label'     => __( 'CTA Button Text', 'uael' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'infobox_cta_type' => 'button',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'cta_typography',
				'scheme'    => Scheme_Typography::TYPOGRAPHY_2,
				'selector'  => '{{WRAPPER}} .uael-infobox-cta-link, {{WRAPPER}} .elementor-button, {{WRAPPER}} a.elementor-button',
				'condition' => [
					'infobox_cta_type' => [ 'link', 'button' ],
				],
			]
		);
		$this->add_control(
			'infobox_cta_color',
			[
				'label'     => __( 'Link Color', 'uael' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_4,
				],
				'selectors' => [
					'{{WRAPPER}} .uael-infobox-cta-link' => 'color: {{VALUE}};',
				],
				'condition' => [
					'infobox_cta_type' => 'link',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Register Infobox Margin Controls.
	 *
	 * @since 0.0.1
	 * @access protected
	 */
	protected function register_margin_content_controls() {
		$this->start_controls_section(
			'section_margin_field',
			[
				'label' => __( 'Margins', 'uael' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control(
			'infobox_title_margin',
			[
				'label'      => __( 'Title Margin', 'uael' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default'    => [
					'top'      => '0',
					'bottom'   => '10',
					'left'     => '0',
					'right'    => '0',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .uael-infobox-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'  => [
					'infobox_title!' => '',
				],
			]
		);

		$this->add_responsive_control(
			'title_prefix_margin',
			[
				'label'      => __( 'Prefix Margin', 'uael' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'default'    => [
					'top'      => '0',
					'bottom'   => '0',
					'left'     => '0',
					'right'    => '0',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'size_units' => [ 'px' ],
				'condition'  => [
					'infobox_title_prefix!' => '',
				],
				'selectors'  => [
					'{{WRAPPER}} .uael-infobox-title-prefix' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'infobox_responsive_imgicon_margin',
			[
				'label'      => __( 'Image/Icon Margin', 'uael' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'condition'  => [
					'uael_infobox_image_type' => [ 'icon', 'photo' ],
				],
				'selectors'  => [
					'{{WRAPPER}} .uael-imgicon-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'infobox_desc_margin',
			[
				'label'      => __( 'Description Margins', 'uael' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default'    => [
					'top'      => '0',
					'bottom'   => '0',
					'left'     => '0',
					'right'    => '0',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'condition'  => [
					'infobox_description!' => '',
				],
				'selectors'  => [
					'{{WRAPPER}} .uael-infobox-text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'infobox_separator_margin',
			[
				'label'      => __( 'Separator Margins', 'uael' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default'    => [
					'top'      => '20',
					'bottom'   => '20',
					'left'     => '0',
					'right'    => '0',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'condition'  => [
					'infobox_separator' => 'yes',
				],
				'selectors'  => [
					'{{WRAPPER}} .uael-separator' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);
		$this->add_responsive_control(
			'infobox_cta_margin',
			[
				'label'      => __( 'CTA Margin', 'uael' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default'    => [
					'top'      => '10',
					'bottom'   => '0',
					'left'     => '0',
					'right'    => '0',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .uael-infobox-cta-link-style, {{WRAPPER}} .uael-button-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'  => [
					'infobox_cta_type' => [ 'link', 'button' ],
				],
			]
		);
		$this->end_controls_section();
	}

	/**
	 * Helpful Information.
	 *
	 * @since 1.1.0
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
					/* translators: %1$s doc link */
					'raw'             => sprintf( __( '%1$s Getting started video » %2$s', 'uael' ), '<a href="https://www.youtube.com/watch?v=8N_CW1rgvp0&index=2&list=PL1kzJGWGPrW_7HabOZHb6z88t_S8r-xAc" target="_blank" rel="noopener">', '</a>' ),
					'content_classes' => 'uael-editor-doc',
				]
			);

			$this->add_control(
				'help_doc_2',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %1$s doc link */
					'raw'             => sprintf( __( '%1$s Getting started article » %2$s', 'uael' ), '<a href="https://uaelementor.com/docs/info-box-widget/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin" target="_blank" rel="noopener">', '</a>' ),
					'content_classes' => 'uael-editor-doc',
				]
			);

			$this->end_controls_section();
		}
	}

	/**
	 * Display Infobox Icon/Image.
	 *
	 * @since 0.0.1
	 * @access public
	 * @param object $position for Icon/Image position.
	 * @param object $settings for settings.
	 */
	public function render_image( $position, $settings ) {

		$set_pos    = '';
		$anim_class = '';
		$image_html = '';
		$settings   = $this->get_settings_for_display();

		if ( 'icon' === $settings['uael_infobox_image_type'] || 'photo' === $settings['uael_infobox_image_type'] ) {
			$set_pos = $settings['infobox_image_position'];
		}
		if ( $position === $set_pos ) {
			if ( 'icon' === $settings['uael_infobox_image_type'] || 'photo' === $settings['uael_infobox_image_type'] ) {

				if ( 'normal' !== $settings['infobox_imgicon_style'] ) {
					$anim_class = 'elementor-animation-' . $settings['infobox_imgicon_animation'];
				} elseif ( 'normal' === $settings['infobox_imgicon_style'] ) {
					$anim_class = 'elementor-animation-' . $settings['normal_imgicon_animation'];
				}

				?>
				<div class="uael-module-content uael-imgicon-wrap "><?php /* Module Wrap */ ?>
					<?php
					/*Icon Html */
					if ( UAEL_Helper::is_elementor_updated() ) {
						if ( ! isset( $settings['infobox_select_icon'] ) && ! \Elementor\Icons_Manager::is_migration_allowed() ) {
							// add old default.
							$settings['infobox_select_icon'] = 'fa fa-star';
						}
						$has_icon = ! empty( $settings['infobox_select_icon'] );

						if ( ! $has_icon && ! empty( $settings['new_infobox_select_icon']['value'] ) ) {
							$has_icon = true;
						}
						$migrated = isset( $settings['__fa4_migrated']['new_infobox_select_icon'] );
						$is_new   = ! isset( $settings['infobox_select_icon'] ) && \Elementor\Icons_Manager::is_migration_allowed();
						?>
						<?php if ( 'icon' === $settings['uael_infobox_image_type'] && $has_icon ) { ?>
							<div class="uael-icon-wrap <?php echo $anim_class; ?>">
								<span class="uael-icon">
									<?php
									if ( $is_new || $migrated ) {
										\Elementor\Icons_Manager::render_icon( $settings['new_infobox_select_icon'], [ 'aria-hidden' => 'true' ] );
									} elseif ( ! empty( $settings['infobox_select_icon'] ) ) {
										?>
										<i class="<?php echo $settings['infobox_select_icon']; ?>" aria-hidden="true"></i>
									<?php } ?>
								</span>
							</div>
							<?php
						}
					} elseif ( 'icon' === $settings['uael_infobox_image_type'] ) {
						?>
						<div class="uael-icon-wrap <?php echo $anim_class; ?>">
							<span class="uael-icon">
								<i class="<?php echo $settings['infobox_select_icon']; ?>"></i>
							</span>
						</div>
					<?php } // Icon Html End. ?>

					<?php /* Photo Html */ ?>
					<?php
					if ( 'photo' === $settings['uael_infobox_image_type'] ) {
						if ( 'media' === $settings['uael_infobox_photo_type'] ) {
							if ( ! empty( $settings['infobox_image']['url'] ) ) {

								$this->add_render_attribute( 'image', 'src', $settings['infobox_image']['url'] );
								$this->add_render_attribute( 'image', 'alt', Control_Media::get_image_alt( $settings['infobox_image'] ) );
								$this->add_render_attribute( 'image', 'title', Control_Media::get_image_title( $settings['infobox_image'] ) );

								$image_html = Group_Control_Image_Size::get_attachment_image_html( $settings, 'image', 'infobox_image' );
							}
						}
						if ( 'url' === $settings['uael_infobox_photo_type'] ) {
							if ( ! empty( $settings['infobox_image_link'] ) ) {

								$this->add_render_attribute( 'infobox_image_link', 'src', $settings['infobox_image_link']['url'] );

								$image_html = '<img ' . $this->get_render_attribute_string( 'infobox_image_link' ) . '>';
							}
						}
						?>
						<div class="uael-image" itemscope itemtype="http://schema.org/ImageObject">
							<div class="uael-image-content <?php echo $anim_class; ?> ">
								<?php echo $image_html; ?>
							</div>
						</div>

					<?php } // Photo Html End. ?>
				</div>
				<?php
			}
		}
	}

	/**
	 * Display Infobox Title & Prefix.
	 *
	 * @since 0.0.1
	 * @access public
	 * @param object $settings for settings.
	 */
	public function render_title( $settings ) {
		$flag             = false;
		$dynamic_settings = $this->get_settings_for_display();

		if ( ( 'photo' === $settings['uael_infobox_image_type'] && 'left-title' === $settings['infobox_image_position'] ) || ( 'icon' === $settings['uael_infobox_image_type'] && 'left-title' === $settings['infobox_image_position'] ) ) {
			echo '<div class="left-title-image">';
			$flag = true;
		} elseif ( ( 'photo' === $settings['uael_infobox_image_type'] && 'right-title' === $settings['infobox_image_position'] ) || ( 'icon' === $settings['uael_infobox_image_type'] && 'right-title' === $settings['infobox_image_position'] ) ) {
			echo '<div class="right-title-image">';
			$flag = true;
		}
				$this->render_image( 'left-title', $settings );
				echo "<div class='uael-infobox-title-wrap'>";
		if ( ! empty( $dynamic_settings['infobox_title_prefix'] ) ) {
			echo '<' . $settings['infobox_prefix_tag'] . ' class="uael-infobox-title-prefix elementor-inline-editing" data-elementor-setting-key="infobox_title_prefix" data-elementor-inline-editing-toolbar="basic" >' . $this->get_settings_for_display( 'infobox_title_prefix' ) . '</' . $settings['infobox_prefix_tag'] . '>';
		}

		if ( 'after_prefix' === $settings['infobox_separator_position'] ) {
			$this->render_separator( $settings );
		}

		if ( ! empty( $dynamic_settings['infobox_title'] ) ) {
			echo '<' . $settings['infobox_title_tag'] . ' class="uael-infobox-title elementor-inline-editing" data-elementor-setting-key="infobox_title" data-elementor-inline-editing-toolbar="basic" >';
			echo $this->get_settings_for_display( 'infobox_title' );
			echo '</' . $settings['infobox_title_tag'] . '>';
		}
			echo '</div>';
			$this->render_image( 'right-title', $settings );

		if ( $flag ) {
			echo '</div>';
		}
	}
	/**
	 * Method render_link
	 *
	 * @since 0.0.1
	 * @access public
	 * @param object $settings for settings.
	 */
	public function render_link( $settings ) {

		$dynamic_settings = $this->get_settings_for_display();

		$_nofollow = ( 'on' === $dynamic_settings['infobox_text_link']['nofollow'] ) ? 'nofollow' : '';
		$_target   = ( 'on' === $dynamic_settings['infobox_text_link']['is_external'] ) ? '_blank' : '';
		$_link     = ( isset( $dynamic_settings['infobox_text_link']['url'] ) ) ? $dynamic_settings['infobox_text_link']['url'] : '';

		if ( 'link' === $settings['infobox_cta_type'] ) {
			?>
			<div class="uael-infobox-cta-link-style">
				<a href="<?php echo $_link; ?>" rel="<?php echo $_nofollow; ?>" target="<?php echo $_target; ?>"  class="uael-infobox-cta-link">
					<?php
					if ( 'left' === $settings['infobox_button_icon_position'] ) {
						if ( UAEL_Helper::is_elementor_updated() ) {
							if ( ( ! empty( $settings['infobox_button_icon'] ) || ! empty( $settings['new_infobox_button_icon'] ) ) ) {

								$migrated = isset( $settings['__fa4_migrated']['new_infobox_button_icon'] );
								$is_new   = ! isset( $settings['infobox_button_icon'] );
								?>
								<span class="uael-infobox-link-icon uael-infobox-link-icon-before">
									<?php
									if ( $is_new || $migrated ) :
										\Elementor\Icons_Manager::render_icon( $settings['new_infobox_button_icon'], [ 'aria-hidden' => 'true' ] );
									elseif ( ! empty( $settings['infobox_button_icon'] ) ) :
										?>
										<i class="<?php echo $settings['infobox_button_icon']; ?>" aria-hidden="true"></i>
									<?php endif; ?>
								</span>
							<?php } ?>
						<?php } elseif ( ! empty( $settings['infobox_button_icon'] ) ) { ?>
							<span class="uael-infobox-link-icon uael-infobox-link-icon-before">
								<i class="<?php echo $settings['infobox_button_icon']; ?>" aria-hidden="true"></i>
							</span>
						<?php } ?>
					<?php } ?>
						<span class="elementor-inline-editing" data-elementor-setting-key="infobox_link_text" data-elementor-inline-editing-toolbar="basic"><?php echo $this->get_settings_for_display( 'infobox_link_text' ); ?></span>
					<?php
					if ( 'right' === $settings['infobox_button_icon_position'] ) {
						if ( UAEL_Helper::is_elementor_updated() ) {
							if ( ( ! empty( $settings['infobox_button_icon'] ) || ! empty( $settings['new_infobox_button_icon'] ) ) ) {
								$migrated = isset( $settings['__fa4_migrated']['new_infobox_button_icon'] );
								$is_new   = ! isset( $settings['infobox_button_icon'] );
								?>
								<span class="uael-infobox-link-icon uael-infobox-link-icon-after"> 
									<?php
									if ( $is_new || $migrated ) :
										\Elementor\Icons_Manager::render_icon( $settings['new_infobox_button_icon'], [ 'aria-hidden' => 'true' ] );
									elseif ( ! empty( $settings['infobox_button_icon'] ) ) :
										?>
										<i class="<?php echo $settings['infobox_button_icon']; ?>" aria-hidden="true"></i>
									<?php endif; ?>
								</span>
							<?php } ?>
						<?php } elseif ( ! empty( $settings['infobox_button_icon'] ) ) { ?>
							<span class="uael-infobox-link-icon uael-infobox-link-icon-after">
								<i class="<?php echo $settings['infobox_button_icon']; ?>" aria-hidden="true"></i>
							</span>
						<?php } ?>
					<?php } ?>
				</a>
			</div>
			<?php
		} elseif ( 'button' === $settings['infobox_cta_type'] ) {
			$this->add_render_attribute( 'wrapper', 'class', 'uael-button-wrapper elementor-button-wrapper' );

			if ( ! empty( $dynamic_settings['infobox_text_link']['url'] ) ) {
				$this->add_render_attribute( 'button', 'href', $dynamic_settings['infobox_text_link']['url'] );
				$this->add_render_attribute( 'button', 'class', 'elementor-button-link' );

				if ( $dynamic_settings['infobox_text_link']['is_external'] ) {
					$this->add_render_attribute( 'button', 'target', '_blank' );
				}
				if ( $dynamic_settings['infobox_text_link']['nofollow'] ) {
					$this->add_render_attribute( 'button', 'rel', 'nofollow' );
				}
			}
			$this->add_render_attribute( 'button', 'class', ' elementor-button' );

			if ( ! empty( $settings['infobox_button_size'] ) ) {
				$this->add_render_attribute( 'button', 'class', 'elementor-size-' . $settings['infobox_button_size'] );
			}
			if ( $settings['infobox_button_animation'] ) {
				$this->add_render_attribute( 'button', 'class', 'elementor-animation-' . $settings['infobox_button_animation'] );
			}
			?>
			<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
				<a <?php echo $this->get_render_attribute_string( 'button' ); ?>>
					<?php $this->render_button_text(); ?>
				</a>
			</div>
			<?php
		}
	}

	/**
	 * Render button text.
	 *
	 * Render button widget text.
	 *
	 * @since 0.0.1
	 * @access protected
	 */
	protected function render_button_text() {

		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'content-wrapper', 'class', 'elementor-button-content-wrapper' );
		$this->add_render_attribute( 'icon-align', 'class', 'elementor-align-icon-' . $settings['infobox_button_icon_position'] );
		$this->add_render_attribute( 'icon-align', 'class', 'elementor-button-icon' );

		$this->add_render_attribute( 'text', 'class', 'elementor-button-text' );
		$this->add_render_attribute( 'text', 'class', 'elementor-inline-editing' );

		?>
		<span <?php echo $this->get_render_attribute_string( 'content-wrapper' ); ?>>
			<?php if ( UAEL_Helper::is_elementor_updated() ) { ?>
				<?php
				$migrated = isset( $settings['__fa4_migrated']['new_infobox_button_icon'] );
				$is_new   = ! isset( $settings['infobox_button_icon'] );
				?>
				<?php if ( ! empty( $settings['infobox_button_icon'] ) || ! empty( $settings['new_infobox_button_icon'] ) ) : ?>
					<span <?php echo $this->get_render_attribute_string( 'icon-align' ); ?>>
						<?php
						if ( $is_new || $migrated ) :
							\Elementor\Icons_Manager::render_icon( $settings['new_infobox_button_icon'], [ 'aria-hidden' => 'true' ] );
						elseif ( ! empty( $settings['infobox_button_icon'] ) ) :
							?>
							<i class="<?php echo $settings['infobox_button_icon']; ?>" aria-hidden="true"></i>
						<?php endif; ?>
					</span>
				<?php endif; ?>
			<?php } elseif ( ! empty( $settings['infobox_button_icon'] ) ) { ?>
				<span <?php echo $this->get_render_attribute_string( 'icon-align' ); ?>>
					<i class="<?php echo $settings['infobox_button_icon']; ?>" aria-hidden="true"></i>
				</span>
			<?php } ?>

			<span <?php echo $this->get_render_attribute_string( 'text' ); ?>  data-elementor-setting-key="infobox_button_text" data-elementor-inline-editing-toolbar="none"><?php echo $this->get_settings_for_display( 'infobox_button_text' ); ?></span>
		</span>
		<?php
	}

	/**
	 * Render Separator.
	 *
	 * @since 1.10.1
	 * @access protected
	 * @param object $settings for settings.
	 */
	protected function render_separator( $settings ) {
		if ( 'yes' === $settings['infobox_separator'] ) {
			?>
			<div class="uael-separator-parent">
				<div class="uael-separator"></div>		
			</div>
			<?php
		}
	}

	/**
	 * Render Info Box output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 0.0.1
	 * @access protected
	 */
	protected function render() {
		$html     = '';
		$settings = $this->get_settings_for_display();
		$node_id  = $this->get_id();
		ob_start();
		include 'template.php';
		$html = ob_get_clean();
		echo $html;

	}
	/**
	 * Render Info Box widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 0.0.1
	 * @access protected
	 */
	protected function _content_template() {
		?>
		<#
		function render_title() {
			var flag = false;
			if ( ( 'photo' == settings.uael_infobox_image_type && 'left-title' == settings.infobox_image_position ) || ( 'icon' == settings.uael_infobox_image_type && 'left-title' == settings.infobox_image_position ) ) {
				#>
				<div class="left-title-image">
				<#
				flag = true;
			}
			if ( ( 'photo' == settings.uael_infobox_image_type && 'right-title' == settings.infobox_image_position ) || ( 'icon' == settings.uael_infobox_image_type && 'right-title' == settings.infobox_image_position ) ) {
				#>
				<div class="right-title-image">
				<#
				flag = true;
			} #>
			<# render_image( 'left-title' ); #>
			<div class='uael-infobox-title-wrap'>
				<# if ( '' != settings.infobox_title_prefix ) { #>
					<{{ settings.infobox_prefix_tag }} class="uael-infobox-title-prefix elementor-inline-editing" data-elementor-setting-key="infobox_title_prefix" data-elementor-inline-editing-toolbar="basic" >
						{{{ settings.infobox_title_prefix }}}
					</{{ settings.infobox_prefix_tag }}>
				<# } #>
				<# if( 'after_prefix' == settings.infobox_separator_position ) {
					render_separator(); 
				} #>
				<{{ settings.infobox_title_tag }} class="uael-infobox-title elementor-inline-editing" data-elementor-setting-key="infobox_title" data-elementor-inline-editing-toolbar="basic" >
					{{{ settings.infobox_title }}}
				</{{ settings.infobox_title_tag }}>
			</div>
			<# render_image( 'right-title' ); #>
			<# if ( flag ) { #>
			</div>
			<# }
		} #>

		<#
		function render_image( position ) {
			var set_pos = '';
			var media_img = '';
			var anim_class = '';
			if ( 'icon' == settings.uael_infobox_image_type || 'photo' == settings.uael_infobox_image_type ) {
				var set_pos = settings.infobox_image_position;
			}
			if ( position == set_pos ) {
				if ( 'icon' == settings.uael_infobox_image_type || 'photo' == settings.uael_infobox_image_type ) {

					if( 'normal' != settings.infobox_imgicon_style ) {
						anim_class = 'elementor-animation-' + settings.infobox_imgicon_animation;
					} else if ( 'normal' == settings.infobox_imgicon_style ) {
						anim_class = 'elementor-animation-' + settings.normal_imgicon_animation;
					} #>
					<div class="uael-module-content uael-imgicon-wrap">
					<# if ( 'icon' == settings.uael_infobox_image_type ) { #>
						<?php if ( UAEL_Helper::is_elementor_updated() ) { ?>
							<# if ( settings.infobox_select_icon || settings.new_infobox_select_icon ) {
								var iconHTML = elementor.helpers.renderIcon( view, settings.new_infobox_select_icon, { 'aria-hidden': true }, 'i' , 'object' );

								var migrated = elementor.helpers.isIconMigrated( settings, 'new_infobox_select_icon' );

								#>
								<div class="uael-icon-wrap {{ anim_class }} " >
									<span class="uael-icon">
										<# if ( iconHTML && iconHTML.rendered && ( ! settings.infobox_select_icon || migrated ) ) {
										#>
											{{{ iconHTML.value }}}
										<# } else { #>
											<i class="{{ settings.infobox_select_icon }}" aria-hidden="true"></i>
										<# } #>
									</span>
								</div>
							<# } #>
						<?php } else { ?>
							<div class="uael-icon-wrap {{ anim_class }} " >
								<span class="uael-icon">
									<i class="{{ settings.infobox_select_icon }}" aria-hidden="true"></i>
								</span>
							</div>
						<?php } ?>
					<# }
					if ( 'photo' == settings.uael_infobox_image_type ) {
					#>
						<div class="uael-image" itemscope itemtype="http://schema.org/ImageObject">
							<div class="uael-image-content {{ anim_class }} ">
								<#
								if ( 'media' == settings.uael_infobox_photo_type ) {
									if ( '' != settings.infobox_image.url ) {

										var media_image = {
											id: settings.infobox_image.id,
											url: settings.infobox_image.url,
											size: settings.image_size,
											dimension: settings.image_custom_dimension,
											model: view.getEditModel()
										};
										media_img = elementor.imagesManager.getImageUrl( media_image );
										#>
										<img src="{{{ media_img }}}" >
										<#
									}
								}
								if ( 'url' == settings.uael_infobox_photo_type ) {
									if ( '' != settings.infobox_image_link ) {
										view.addRenderAttribute( 'infobox_image_link', 'src', settings.infobox_image_link.url );
										#>
										<img {{{ view.getRenderAttributeString( 'infobox_image_link' ) }}}>
										<#
									}
								} #>
							</div>
						</div>
					<# } #>
					</div>
				<#
				}
			}
		} #>

		<#
		function render_link() {

			if ( 'link' == settings.infobox_cta_type ) {
				#>
				<div class="uael-infobox-cta-link-style">
					<a href="{{ settings.infobox_text_link }}" class="uael-infobox-cta-link">
						<#
						if ( 'left' == settings.infobox_button_icon_position ) {
						#>
							<span class="uael-infobox-link-icon uael-infobox-link-icon-before">
								<?php if ( UAEL_Helper::is_elementor_updated() ) { ?>
									<# 
									var buttoniconHTML = elementor.helpers.renderIcon( view, settings.new_infobox_button_icon, { 'aria-hidden': true }, 'i' , 'object' );

									var buttonMigrated = elementor.helpers.isIconMigrated( settings, 'new_infobox_button_icon' );
									#>
									<# if ( buttoniconHTML && buttoniconHTML.rendered && ( ! settings.infobox_button_icon || buttonMigrated ) ) { #>
										{{{ buttoniconHTML.value }}}
									<# } else { #>
										<i class="{{ settings.infobox_button_icon }}"></i>
									<# } #>
								<?php } else { ?>
									<i class="{{ settings.infobox_button_icon }}"></i>
								<?php } ?>
							</span>
						<# } #>
						<span class="elementor-inline-editing" data-elementor-setting-key="infobox_link_text" data-elementor-inline-editing-toolbar="basic">{{ settings.infobox_link_text }}</span>

						<# if ( 'right' == settings.infobox_button_icon_position ) {
						#>	
							<span class="uael-infobox-link-icon uael-infobox-link-icon-after">
								<?php if ( UAEL_Helper::is_elementor_updated() ) { ?>
									<# 
									var buttoniconHTML = elementor.helpers.renderIcon( view, settings.new_infobox_button_icon, { 'aria-hidden': true }, 'i' , 'object' );

									var buttonMigrated = elementor.helpers.isIconMigrated( settings, 'new_infobox_button_icon' );
									#>
									<# if ( buttoniconHTML && buttoniconHTML.rendered && ( ! settings.infobox_button_icon || buttonMigrated ) ) { #>
										{{{ buttoniconHTML.value }}}
									<# } else { #>
										<i class="{{ settings.infobox_button_icon }}"></i>
									<# } #>
								<?php } else { ?>
									<i class="{{ settings.infobox_button_icon }}"></i>
								<?php } ?>
							</span>
						<# } #>
					</a>
				</div>
			<# }
			else if ( 'button' == settings.infobox_cta_type ) {

				view.addRenderAttribute( 'wrapper', 'class', 'uael-button-wrapper elementor-button-wrapper' );
				if ( '' != settings.infobox_text_link.url ) {
					view.addRenderAttribute( 'button', 'href', settings.infobox_text_link.url );
					view.addRenderAttribute( 'button', 'class', 'elementor-button-link' );
				}
				view.addRenderAttribute( 'button', 'class', 'elementor-button' );

				if ( '' != settings.infobox_button_size ) {
					view.addRenderAttribute( 'button', 'class', 'elementor-size-' + settings.infobox_button_size );
				}

				if ( settings.infobox_button_animation ) {
					view.addRenderAttribute( 'button', 'class', 'elementor-animation-' + settings.infobox_button_animation );
				} #>
				<div {{{ view.getRenderAttributeString( 'wrapper' ) }}}>
					<a  {{{ view.getRenderAttributeString( 'button' ) }}}>
						<#
						view.addRenderAttribute( 'content-wrapper', 'class', 'elementor-button-content-wrapper' );

						view.addRenderAttribute( 'icon-align', 'class', 'elementor-align-icon-' + settings.infobox_button_icon_position );

						view.addRenderAttribute( 'icon-align', 'class', 'elementor-button-icon' );

						view.addRenderAttribute( 'text', 'class', 'elementor-button-text' );

						view.addRenderAttribute( 'text', 'class', 'elementor-inline-editing' );

						#>
						<span {{{ view.getRenderAttributeString( 'content-wrapper' ) }}}>
							<?php if ( UAEL_Helper::is_elementor_updated() ) { ?>
								<# if ( settings.infobox_button_icon || settings.new_infobox_button_icon ) { #>
									<span {{{ view.getRenderAttributeString( 'icon-align' ) }}}>
										<# if ( buttoniconHTML && buttoniconHTML.rendered && ( ! settings.infobox_button_icon || buttonMigrated ) ) { #>
											{{{ buttoniconHTML.value }}}
										<# } else { #>
											<i class= "{{ settings.infobox_button_icon }}" aria-hidden="true"></i>
										<# } #>
									</span>
								<# } #>
							<?php } else { ?>
								<span {{{ view.getRenderAttributeString( 'icon-align' ) }}}>
									<i class="{{ settings.infobox_button_icon }}"></i>
								</span>
							<?php } ?>
							<span {{{ view.getRenderAttributeString( 'text' ) }}} data-elementor-setting-key="infobox_button_text" data-elementor-inline-editing-toolbar="none">{{ settings.infobox_button_text }}</span>
						</span>
					</a>
				</div>
			<#
			}
		}
		#>

		<# function render_separator() {
			if ( 'yes' == settings.infobox_separator ) { #>	
				<div class="uael-separator-parent">
					<div class="uael-separator"></div>		
				</div>				
			<# }
		} #>

		<#
			view.addRenderAttribute( 'classname', 'class', 'uael-module-content uael-infobox' );

			if ( 'icon' == settings.uael_infobox_image_type || 'photo' == settings.uael_infobox_image_type ) {

				view.addRenderAttribute( 'classname', 'class', 'uael-imgicon-style-' + settings.infobox_imgicon_style );

				if ( 'above-title' == settings.infobox_image_position || 'below-title' == settings.infobox_image_position ) {
					view.addRenderAttribute( 'classname', 'class', ' uael-infobox-' + settings.infobox_align );
				}
				if ( 'left-title' == settings.infobox_image_position || 'left' == settings.infobox_image_position ) {
					view.addRenderAttribute( 'classname', 'class', ' uael-infobox-left' );
				}
				if ( 'right-title' == settings.infobox_image_position || 'right' == settings.infobox_image_position ) {
					view.addRenderAttribute( 'classname', 'class', ' uael-infobox-right' );
				}
				if ( 'icon' == settings.uael_infobox_image_type ) {
					view.addRenderAttribute( 'classname', 'class', 'infobox-has-icon uael-infobox-icon-' + settings.infobox_image_position );
				}
				if ( 'photo' == settings.uael_infobox_image_type ) {
					view.addRenderAttribute( 'classname', 'class', 'infobox-has-photo uael-infobox-photo-' + settings.infobox_image_position );
				}
				if ( 'above-title' != settings.infobox_image_position && 'below-title' != settings.infobox_image_position ) {

					if ( 'middle' == settings.infobox_image_valign ) {
						view.addRenderAttribute( 'classname', 'class', ' uael-infobox-image-valign-middle' );
					} else {
						view.addRenderAttribute( 'classname', 'class', ' uael-infobox-image-valign-top' );
					}
				}
				if ( 'left' == settings.infobox_image_position || 'right' == settings.infobox_image_position ) {
					if ( 'tablet' == settings.infobox_img_mob_view ) {
							view.addRenderAttribute( 'classname', 'class', ' uael-infobox-stacked-tablet' );
					}
					if ( 'mobile' == settings.infobox_img_mob_view ) {
							view.addRenderAttribute( 'classname', 'class', ' uael-infobox-stacked-mobile' );
					}
				}
				if ( 'right' == settings.infobox_image_position ) {
					if ( 'tablet' == settings.infobox_img_mob_view ) {
							view.addRenderAttribute( 'classname', 'class', ' uael-reverse-order-tablet' );
					}
					if ( 'mobile' == settings.infobox_img_mob_view ) {
							view.addRenderAttribute( 'classname', 'class', ' uael-reverse-order-mobile' );
					}
				}
			} else {
				if ( 'left' == settings.infobox_overall_align || 'center' == settings.infobox_overall_align || 'right' == settings.infobox_overall_align ) {
					view.addRenderAttribute( 'classname', 'class', ' uael-infobox-' + settings.infobox_overall_align );
				}
			}

			view.addRenderAttribute( 'classname', 'class', 'uael-infobox-link-type-' + settings.infobox_cta_type );
		#>
			<div {{{ view.getRenderAttributeString( 'classname' ) }}}>
				<div class="uael-infobox-left-right-wrap">
					<#
					if ( 'module' == settings.infobox_cta_type && '' != settings.infobox_text_link ) {
					#>
						<a href="{{ settings.infobox_text_link.url }}" class="uael-infobox-module-link"></a>
					<# } #>
					<# render_image( 'left' ); #>
					<div class="uael-infobox-content">
						<# render_image( 'above-title' ); #>
						<# render_title(); #>
						<# if( 'after_heading' == settings.infobox_separator_position ) {
							render_separator(); 
						} #>
						<# render_image( 'below-title' ); #>
						<div class="uael-infobox-text-wrap">
							<div class="uael-infobox-text elementor-inline-editing" data-elementor-setting-key="infobox_description" data-elementor-inline-editing-toolbar="advanced">
								{{{ settings.infobox_description }}}
							</div>
							<# if( 'after_description' == settings.infobox_separator_position ) {
								render_separator(); 
							} #>
							<# render_link(); #>
						</div>
					</div>
					<# render_image( 'right' ); #>
				</div>
			</div>
		<?php
	}
}

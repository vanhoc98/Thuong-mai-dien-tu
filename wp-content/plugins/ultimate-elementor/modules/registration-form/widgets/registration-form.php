<?php
/**
 * UAEL Registration Form.
 *
 * @package UAEL
 */

namespace UltimateElementor\Modules\RegistrationForm\Widgets;

// Elementor Classes.
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Widget_Button;
use Elementor\Icons_Manager;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;

// UltimateElementor Classes.
use UltimateElementor\Base\Common_Widget;
use UltimateElementor\Classes\UAEL_Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit;   // Exit if accessed directly.
}

/**
 * Class RegistrationForm.
 */
class RegistrationForm extends Common_Widget {

	/**
	 * Retrieve RegistrationForm Widget name.
	 *
	 * @since 1.18.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return parent::get_widget_slug( 'RegistrationForm' );
	}

	/**
	 * Retrieve RegistrationForm Widget title.
	 *
	 * @since 1.18.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return parent::get_widget_title( 'RegistrationForm' );
	}

	/**
	 * Retrieve RegistrationForm Widget icon.
	 *
	 * @since 1.18.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return parent::get_widget_icon( 'RegistrationForm' );
	}

	/**
	 * Retrieve Widget Keywords.
	 *
	 * @since 1.18.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_keywords() {
		return parent::get_widget_keywords( 'RegistrationForm' );
	}

	/**
	 * Retrieve the list of scripts the image carousel widget depended on.
	 *
	 * Used to set scripts dependencies required to run the widget.
	 *
	 * @since 1.18.0
	 * @access public
	 *
	 * @return array Widget scripts dependencies.
	 */
	public function get_script_depends() {
		return [ 'uael-registration', 'password-strength-meter', 'uael-google-recaptcha' ];
	}

	/**
	 * Get array of fields type.
	 *
	 * @since 1.18.0
	 * @access protected
	 * @return array fields.
	 */
	protected function get_field_type() {

		$fields = [
			'user_name'    => __( 'Username', 'uael' ),
			'email'        => __( 'Email', 'uael' ),
			'password'     => __( 'Password', 'uael' ),
			'confirm_pass' => __( 'Confirm Password', 'uael' ),
			'first_name'   => __( 'First Name', 'uael' ),
			'last_name'    => __( 'Last Name', 'uael' ),
			'honeypot'     => __( 'Honeypot', 'uael' ),
			'recaptcha_v3' => __( 'reCAPTCHA v3', 'uael' ),
		];

		$fields = apply_filters( 'uael_registration_form_fields', $fields );

		return $fields;
	}

	/**
	 * Retrieve Button sizes.
	 *
	 * @since 1.18.0
	 * @access public
	 *
	 * @return array Button Sizes.
	 */
	public static function get_button_sizes() {
		return Widget_Button::get_button_sizes();
	}

	/**
	 * Retrieve User Roles.
	 *
	 * @since 1.18.0
	 * @access public
	 *
	 * @return array User Roles.
	 */
	public static function get_user_roles() {

		global $wp_roles;

		if ( ! class_exists( 'WP_Roles' ) ) {
			return;
		}

		if ( ! isset( $wp_roles ) ) {
			// $wp_roles = new WP_Roles();
			$wp_roles = get_editable_roles();
		}

		$roles      = isset( $wp_roles->roles ) ? $wp_roles->roles : array();
		$user_roles = array();

		$user_roles['default'] = __( 'Default', 'uael' );

		foreach ( $roles as $role_key => $role ) {
			$user_roles[ $role_key ] = $role['name'];
		}

		return apply_filters( 'uael_user_default_roles', $user_roles );
	}

	/**
	 * Register RegistrationForm controls.
	 *
	 * @since 1.18.0
	 * @access protected
	 */
	protected function _register_controls() {

		$this->register_general_controls();
		$this->register_button_controls();
		$this->register_settings_controls();
		$this->register_action_after_submit_controls();
		$this->register_email_controls();
		$this->register_validation_message_controls();
		$this->register_spacing_controls();
		$this->register_label_style_controls();
		$this->register_input_style_controls();
		$this->register_submit_style_controls();
		$this->register_error_style_controls();
		$this->register_helpful_information();
	}

	/**
	 * Register Registration Form General Controls.
	 *
	 * @since 1.18.0
	 * @access protected
	 */
	protected function register_general_controls() {

		$this->start_controls_section(
			'section_general_field',
			[
				'label' => __( 'Form Fields', 'uael' ),
			]
		);

			$repeater = new Repeater();

			$repeater->add_control(
				'field_type',
				[
					'label'   => __( 'Type', 'uael' ),
					'type'    => Controls_Manager::SELECT,
					'options' => $this->get_field_type(),
					'default' => 'first_name',
				]
			);

			$repeater->add_control(
				'field_label',
				[
					'label'   => __( 'Label', 'uael' ),
					'type'    => Controls_Manager::TEXT,
					'default' => '',
					'dynamic' => [
						'active' => true,
					],
				]
			);

			$repeater->add_control(
				'placeholder',
				[
					'label'     => __( 'Placeholder', 'uael' ),
					'type'      => Controls_Manager::TEXT,
					'default'   => '',
					'dynamic'   => [
						'active' => true,
					],
					'condition' => [
						'field_type!' => [ 'honeypot', 'recaptcha_v3' ],
					],
				]
			);

			$repeater->add_control(
				'required',
				[
					'label'        => __( 'Required', 'uael' ),
					'type'         => Controls_Manager::SWITCHER,
					'return_value' => 'true',
					'default'      => '',
					'condition'    => [
						'field_type!' => [ 'email', 'password', 'honeypot', 'recaptcha_v3' ],
					],
				]
			);

			$repeater->add_control(
				'required_note',
				[
					'type'            => Controls_Manager::RAW_HTML,
					'raw'             => __( 'Note: This field is required by default.', 'uael' ),
					'condition'       => [
						'field_type' => [ 'email', 'password' ],
					],
					'content_classes' => 'uael-editor-doc',
				]
			);

			$repeater->add_responsive_control(
				'width',
				[
					'label'     => __( 'Column Width', 'uael' ),
					'type'      => Controls_Manager::SELECT,
					'options'   => [
						''    => __( 'Default', 'uael' ),
						'100' => '100%',
						'80'  => '80%',
						'75'  => '75%',
						'66'  => '66%',
						'60'  => '60%',
						'50'  => '50%',
						'40'  => '40%',
						'33'  => '33%',
						'25'  => '25%',
						'20'  => '20%',
					],
					'default'   => '100',
					'condition' => [
						'field_type!' => [ 'honeypot', 'recaptcha_v3' ],
					],
				]
			);

			$repeater->add_control(
				'recaptcha_badge',
				[
					'label'     => __( 'Badge Position', 'uael' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'bottomright',
					'options'   => [
						'bottomright' => __( 'Bottom Right', 'uael' ),
						'bottomleft'  => __( 'Bottom Left', 'uael' ),
						'inline'      => __( 'Inline', 'uael' ),
					],
					'condition' => [
						'field_type' => 'recaptcha_v3',
					],
				]
			);

			$integration_options = UAEL_Helper::get_integrations_options();
			$widget_list         = UAEL_Helper::get_widget_list();
			$admin_link          = $widget_list['RegistrationForm']['setting_url'];

		if ( ( ! isset( $integration_options['recaptcha_v3_key'] ) || '' === $integration_options['recaptcha_v3_key'] ) && ( ! isset( $integration_options['recaptcha_v3_secretkey'] ) || '' === $integration_options['recaptcha_v3_secretkey'] ) ) {
			$repeater->add_control(
				'recaptcha_setting',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %s admin link */
						'raw'         => sprintf( __( 'Please configure reCAPTCHA v3 setup from <a href="%s" target="_blank" rel="noopener">here</a>.', 'uael' ), $admin_link ),
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
					'condition'       => [
						'field_type' => 'recaptcha_v3',
					],
				]
			);
		}

			$this->add_control(
				'fields_list',
				[
					'type'        => Controls_Manager::REPEATER,
					'fields'      => array_values( $repeater->get_controls() ),
					'default'     => [
						[
							'field_type'  => 'user_name',
							'field_label' => __( 'Username', 'uael' ),
							'placeholder' => __( 'Username', 'uael' ),
							'width'       => '100',
						],
						[
							'field_type'  => 'email',
							'field_label' => __( 'Email', 'uael' ),
							'placeholder' => __( 'Email', 'uael' ),
							'required'    => 'true',
							'width'       => '100',
						],
						[
							'field_type'  => 'password',
							'field_label' => __( 'Password', 'uael' ),
							'placeholder' => __( 'Password', 'uael' ),
							'required'    => 'true',
							'width'       => '100',
						],
					],
					'title_field' => '{{{ field_label }}}',
				]
			);

			$this->add_control(
				'input_size',
				[
					'label'     => __( 'Input Size', 'uael' ),
					'type'      => Controls_Manager::SELECT,
					'options'   => [
						'xs' => __( 'Extra Small', 'uael' ),
						'sm' => __( 'Small', 'uael' ),
						'md' => __( 'Medium', 'uael' ),
						'lg' => __( 'Large', 'uael' ),
						'xl' => __( 'Extra Large', 'uael' ),
					],
					'default'   => 'sm',
					'separator' => 'before',
				]
			);

			$this->add_control(
				'show_labels',
				[
					'label'        => __( 'Label', 'uael' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => __( 'Show', 'uael' ),
					'label_off'    => __( 'Hide', 'uael' ),
					'return_value' => 'true',
					'default'      => 'true',
				]
			);

			$this->add_control(
				'mark_required',
				[
					'label'     => __( 'Required Mark', 'uael' ),
					'type'      => Controls_Manager::SWITCHER,
					'label_on'  => __( 'Show', 'uael' ),
					'label_off' => __( 'Hide', 'uael' ),
					'default'   => '',
					'condition' => [
						'show_labels!' => '',
					],
				]
			);

		$this->end_controls_section();
	}


	/**
	 * Register Registration Form user settings Controls.
	 *
	 * @since 1.18.0
	 * @access protected
	 */
	protected function register_settings_controls() {

		$this->start_controls_section(
			'section_settings_field',
			[
				'label' => __( 'General Settings', 'uael' ),
			]
		);

			$this->add_control(
				'hide_form',
				[
					'label'        => __( 'Hide Form from Logged in Users', 'uael' ),
					'description'  => __( 'Enable this option if you wish to hide the form at the frontend from logged in users.', 'uael' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => __( 'Yes', 'uael' ),
					'label_off'    => __( 'No', 'uael' ),
					'return_value' => 'true',
					'default'      => 'false',
				]
			);

			$this->add_control(
				'logged_in_text',
				[
					'label'       => __( 'Message For Logged In Users', 'uael' ),
					'description' => __( 'Enter the message to display at the frontend for Logged in users.', 'uael' ),
					'type'        => Controls_Manager::WYSIWYG,
					'dynamic'     => [
						'active' => true,
					],
					'condition'   => [
						'hide_form' => 'true',
					],
				]
			);

			$this->add_control(
				'loggedin_message_color',
				[
					'label'     => __( 'Text Color', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'scheme'    => [
						'type'  => Scheme_Color::get_type(),
						'value' => Scheme_Color::COLOR_3,
					],
					'selectors' => [
						'{{WRAPPER}} .uael-registration-loggedin-message' => 'color: {{VALUE}};',
					],
					'condition' => [
						'logged_in_text!' => '',
						'hide_form'       => 'true',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'      => 'loggedin_message_typography',
					'selector'  => '{{WRAPPER}} .uael-registration-loggedin-message',
					'scheme'    => Scheme_Typography::TYPOGRAPHY_3,
					'condition' => [
						'logged_in_text!' => '',
						'hide_form'       => 'true',
					],
				]
			);

			$this->add_control(
				'select_role',
				[
					'label'     => __( 'New User Role', 'uael' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'default',
					'options'   => $this->get_user_roles(),
					'separator' => 'before',
				]
			);

			$this->add_control(
				'default_role_note',
				[
					'type'            => Controls_Manager::RAW_HTML,
					'raw'             => __( 'The default option will assign the user role as per the WordPress backend setting.', 'uael' ),
					'content_classes' => 'uael-editor-doc',
					'condition'       => [
						'select_role' => 'default',
					],
				]
			);

			$this->add_control(
				'login',
				[
					'label'        => __( 'Login', 'uael' ),
					'description'  => __( 'Add the “Login” link below the register button.', 'uael' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => __( 'Yes', 'uael' ),
					'label_off'    => __( 'No', 'uael' ),
					'return_value' => 'true',
					'default'      => 'no',
					'separator'    => 'before',
				]
			);

			$this->add_control(
				'login_text',
				[
					'label'       => __( 'Text', 'uael' ),
					'type'        => Controls_Manager::TEXT,
					'default'     => __( 'Login', 'uael' ),
					'placeholder' => __( 'Login', 'uael' ),
					'dynamic'     => [
						'active' => true,
					],
					'condition'   => [
						'login' => 'true',
					],
				]
			);

			$this->add_control(
				'login_select',
				[
					'label'     => __( 'Link to', 'uael' ),
					'type'      => Controls_Manager::SELECT,
					'options'   => [
						'default' => __( 'Default WordPress Page', 'uael' ),
						'custom'  => __( 'Custom URL', 'uael' ),
					],
					'default'   => 'default',
					'condition' => [
						'login' => 'true',
					],
				]
			);

			$this->add_control(
				'login_url',
				[
					'label'     => __( 'Enter URL', 'uael' ),
					'type'      => Controls_Manager::URL,
					'dynamic'   => [
						'active' => true,
					],
					'condition' => [
						'login_select' => 'custom',
						'login'        => 'true',
					],
				]
			);

			$this->add_control(
				'lost_password',
				[
					'label'        => __( 'Lost Your Password', 'uael' ),
					'description'  => __( 'Add the “Lost Password” link below the register button', 'uael' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => __( 'Yes', 'uael' ),
					'label_off'    => __( 'No', 'uael' ),
					'return_value' => 'true',
					'default'      => 'no',
					'separator'    => 'before',
				]
			);

			$this->add_control(
				'lost_password_text',
				[
					'label'       => __( 'Text', 'uael' ),
					'type'        => Controls_Manager::TEXT,
					'default'     => __( 'Lost Your Password?', 'uael' ),
					'placeholder' => __( 'Lost Your Password?', 'uael' ),
					'dynamic'     => [
						'active' => true,
					],
					'condition'   => [
						'lost_password' => 'true',
					],
				]
			);

			$this->add_control(
				'lost_password_select',
				[
					'label'     => __( 'Link to', 'uael' ),
					'type'      => Controls_Manager::SELECT,
					'options'   => [
						'default' => __( 'Default WordPress Page', 'uael' ),
						'custom'  => __( 'Custom URL', 'uael' ),
					],
					'default'   => 'default',
					'condition' => [
						'lost_password' => 'true',
					],
				]
			);

			$this->add_control(
				'lost_password_url',
				[
					'label'     => __( 'Enter URL', 'uael' ),
					'type'      => Controls_Manager::URL,
					'dynamic'   => [
						'active' => true,
					],
					'condition' => [
						'lost_password_select' => 'custom',
						'lost_password'        => 'true',
					],
				]
			);

			$this->add_responsive_control(
				'footer_text_align',
				[
					'label'      => __( 'Alignment', 'uael' ),
					'type'       => Controls_Manager::CHOOSE,
					'options'    => [
						'left'   => [
							'title' => __( 'Left', 'uael' ),
							'icon'  => 'eicon-text-align-left',
						],
						'center' => [
							'title' => __( 'Center', 'uael' ),
							'icon'  => 'eicon-text-align-center',
						],
						'right'  => [
							'title' => __( 'Right', 'uael' ),
							'icon'  => 'eicon-text-align-right',
						],
					],
					'separator'  => 'before',
					'default'    => 'left',
					'selectors'  => [
						'{{WRAPPER}} .uael-rform-footer' => 'text-align: {{VALUE}};',
					],
					'conditions' => [
						'relation' => 'or',
						'terms'    => [
							[
								'name'     => 'lost_password',
								'operator' => '==',
								'value'    => 'true',
							],
							[
								'name'     => 'login',
								'operator' => '==',
								'value'    => 'true',
							],
						],
					],
				]
			);

			$this->add_control(
				'footer_text_color',
				[
					'label'      => __( 'Text Color', 'uael' ),
					'type'       => Controls_Manager::COLOR,
					'scheme'     => [
						'type'  => Scheme_Color::get_type(),
						'value' => Scheme_Color::COLOR_4,
					],
					'selectors'  => [
						'{{WRAPPER}} .uael-rform-footer, {{WRAPPER}} .uael-rform-footer a' => 'color: {{VALUE}};',
					],
					'conditions' => [
						'relation' => 'or',
						'terms'    => [
							[
								'name'     => 'lost_password',
								'operator' => '==',
								'value'    => 'true',
							],
							[
								'name'     => 'login',
								'operator' => '==',
								'value'    => 'true',
							],
						],
					],
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'       => 'footer_text_typography',
					'selector'   => '{{WRAPPER}} .uael-rform-footer',
					'scheme'     => Scheme_Typography::TYPOGRAPHY_4,
					'conditions' => [
						'relation' => 'or',
						'terms'    => [
							[
								'name'     => 'lost_password',
								'operator' => '==',
								'value'    => 'true',
							],
							[
								'name'     => 'login',
								'operator' => '==',
								'value'    => 'true',
							],
						],
					],
				]
			);

			$this->add_control(
				'footer_divider',
				[
					'label'      => __( 'Divider', 'uael' ),
					'type'       => Controls_Manager::TEXT,
					'default'    => '|',
					'selectors'  => [
						'{{WRAPPER}} .uael-rform-footer a.uael-rform-footer-link:not(:last-child):after' => 'content: "{{VALUE}}"; margin: 0 0.2em;',
					],
					'conditions' => [
						'relation' => 'and',
						'terms'    => [
							[
								'name'     => 'lost_password',
								'operator' => '==',
								'value'    => 'true',
							],
							[
								'name'     => 'login',
								'operator' => '==',
								'value'    => 'true',
							],
						],
					],
				]
			);

			$this->add_control(
				'strength_checker',
				[
					'label'        => __( 'Password Strength Check', 'uael' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => __( 'Show', 'uael' ),
					'label_off'    => __( 'Hide', 'uael' ),
					'return_value' => 'yes',
					'default'      => 'no',
					'separator'    => 'before',
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'      => 'strength_checker_typography',
					'selector'  => '{{WRAPPER}} .uael-pass-notice',
					'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
					'condition' => [
						'strength_checker' => 'yes',
					],
				]
			);

		$this->end_controls_section();

	}

	/**
	 * Register Registration Form Action afetr submit Controls.
	 *
	 * @since 1.18.0
	 * @access protected
	 */
	protected function register_action_after_submit_controls() {

		$this->start_controls_section(
			'section_action_after_submit_field',
			[
				'label' => __( 'After Register Actions', 'uael' ),
			]
		);

			$this->add_control(
				'actions_array',
				[
					'label'       => __( 'Add Action', 'uael' ),
					'type'        => Controls_Manager::SELECT2,
					'multiple'    => true,
					'label_block' => true,
					'default'     => 'send_email',
					'options'     => [
						'redirect'   => __( 'Redirect', 'uael' ),
						'auto_login' => __( 'Auto Login', 'uael' ),
						'send_email' => __( 'Send Email', 'uael' ),
					],
				]
			);

		if ( parent::is_internal_links() ) {
			$this->add_control(
				'add_action_doc',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %1$s doc link */
					'raw'             => sprintf( __( 'Choose from above actions to perform after successful user registration. Click %1$s here %2$s to learn more.', 'uael' ), '<a href="https://uaelementor.com/docs/create-user-registration-form-using-elementor/#choose-post-registration-action" target="_blank" rel="noopener">', '</a>' ),
					'content_classes' => 'uael-editor-doc',
				]
			);
		}

			$this->add_control(
				'redirect_url',
				[
					'label'     => __( 'Redirect URL', 'uael' ),
					'type'      => Controls_Manager::URL,
					'dynamic'   => [
						'active' => true,
					],
					'condition' => [
						'actions_array' => 'redirect',
					],
				]
			);

		$this->end_controls_section();

	}

	/**
	 * Register RegistrationForm Button Controls.
	 *
	 * @since 1.18.0
	 * @access protected
	 */
	protected function register_button_controls() {

		$this->start_controls_section(
			'section_button_field',
			[
				'label' => __( 'Register Button', 'uael' ),
			]
		);

			$this->add_control(
				'button_text',
				[
					'label'       => __( 'Text', 'uael' ),
					'type'        => Controls_Manager::TEXT,
					'default'     => __( 'Register', 'uael' ),
					'placeholder' => __( 'Register', 'uael' ),
					'dynamic'     => [
						'active' => true,
					],
				]
			);

			$this->add_control(
				'button_size',
				[
					'label'   => __( 'Size', 'uael' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'sm',
					'options' => $this->get_button_sizes(),
				]
			);

			$this->add_responsive_control(
				'button_width',
				[
					'label'   => __( 'Column Width', 'uael' ),
					'type'    => Controls_Manager::SELECT,
					'options' => [
						''    => __( 'Default', 'uael' ),
						'100' => '100%',
						'80'  => '80%',
						'75'  => '75%',
						'66'  => '66%',
						'60'  => '60%',
						'50'  => '50%',
						'40'  => '40%',
						'33'  => '33%',
						'25'  => '25%',
						'20'  => '20%',
					],
					'default' => '100',
				]
			);

			$this->add_responsive_control(
				'button_align',
				[
					'label'        => __( 'Alignment', 'uael' ),
					'type'         => Controls_Manager::CHOOSE,
					'options'      => [
						'start'   => [
							'title' => __( 'Left', 'uael' ),
							'icon'  => 'eicon-text-align-left',
						],
						'center'  => [
							'title' => __( 'Center', 'uael' ),
							'icon'  => 'eicon-text-align-center',
						],
						'end'     => [
							'title' => __( 'Right', 'uael' ),
							'icon'  => 'eicon-text-align-right',
						],
						'stretch' => [
							'title' => __( 'Justified', 'uael' ),
							'icon'  => 'eicon-text-align-justify',
						],
					],
					'default'      => 'stretch',
					'prefix_class' => 'elementor%s-button-align-',
				]
			);

			$this->add_control(
				'button_icon',
				[
					'label'       => __( 'Icon', 'uael' ),
					'type'        => Controls_Manager::ICONS,
					'label_block' => true,
				]
			);

			$this->add_control(
				'button_icon_align',
				[
					'label'     => __( 'Icon Position', 'uael' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'left',
					'options'   => [
						'left'  => __( 'Before', 'uael' ),
						'right' => __( 'After', 'uael' ),
					],
					'condition' => [
						'button_icon[value]!' => '',
					],
				]
			);

			$this->add_control(
				'button_icon_indent',
				[
					'label'     => __( 'Icon Spacing', 'uael' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'max' => 50,
						],
					],
					'condition' => [
						'button_icon[value]!' => '',
					],
					'selectors' => [
						'{{WRAPPER}} .elementor-button .elementor-align-icon-right' => 'margin-left: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .elementor-button .elementor-align-icon-left' => 'margin-right: {{SIZE}}{{UNIT}};',
					],
				]
			);

		$this->end_controls_section();

	}

	/**
	 * Register Registration Form Email Controls.
	 *
	 * @since 1.18.0
	 * @access protected
	 */
	protected function register_email_controls() {

		$this->start_controls_section(
			'section_email_fields',
			[
				'label'     => __( 'Email', 'uael' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
				'condition' => [
					'actions_array' => 'send_email',
				],
			]
		);

		if ( parent::is_internal_links() ) {
			$this->add_control(
				'send_email_note',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %1$s doc link */
					'raw'             => sprintf( __( 'Send the new user an email about their account. Click %1$s here %2$s to learn more.', 'uael' ), '<a href="https://uaelementor.com/docs/introducing-user-registration-form-widget/#send-email" target="_blank" rel="noopener">', '</a>' ),
					'content_classes' => 'uael-editor-doc',
				]
			);
		}

			$this->add_control(
				'email_template',
				[
					'label'   => __( 'Email Template', 'uael' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'default',
					'options' => [
						'default' => __( 'Default', 'uael' ),
						'custom'  => __( 'Custom', 'uael' ),
					],
				]
			);

			$this->add_control(
				'email_imp_custom',
				[
					'type'            => Controls_Manager::RAW_HTML,
					'raw'             => __( '<b>Important Notice:</b> If you have only an Email field in the form, then please select the Custom option in the Email Template field above.', 'uael' ),
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
					'condition'       => [
						'email_template' => 'default',
					],
				]
			);

			$site_title = get_option( 'blogname' );
			$login_url  = site_url() . '/wp-admin';

			/* translators: %s: Site title. */
			$default_message = sprintf( __( 'Thank you for registering with "%s"!', 'uael' ), $site_title );

			$this->add_control(
				'email_subject',
				[
					'label'       => __( 'Subject', 'uael' ),
					'type'        => Controls_Manager::TEXT,
					/* translators: %s: Subject */
					'placeholder' => $default_message,
					'default'     => $default_message,
					'label_block' => true,
					'render_type' => 'none',
					'condition'   => [
						'email_template' => 'custom',
					],
				]
			);

			$this->add_control(
				'email_content',
				[
					'label'       => __( 'Message', 'uael' ),
					'type'        => Controls_Manager::WYSIWYG,
					'placeholder' => __( 'Enter the Email Content', 'uael' ),
					/* translators: %s: Message. */
					'default'     => sprintf( __( 'Dear User,<br/>You have successfully created your "%1$s" account. Thank you for registering with us! <br/>Get the most of our service benefits with your registered account. <br/>Please click the link below to access your account.<br/>%2$s <br/>And here\'s the password [field=password] to log in to the account. <br/><br/>Regards, <br/>Team ___', 'uael' ), $site_title, $login_url ),
					'label_block' => true,
					'render_type' => 'none',
					'condition'   => [
						'email_template' => 'custom',
					],
				]
			);

			$this->add_control(
				'email_content_note',
				[
					'type'            => Controls_Manager::RAW_HTML,
					'raw'             => __( '<b>Note:</b> If you wish to send System Generated Password in the email content, use shortcode - <b>[field=password]</b>', 'uael' ),
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
					'condition'       => [
						'email_template' => 'custom',
					],
				]
			);

			$this->add_control(
				'email_content_type',
				[
					'label'       => __( 'Send As', 'uael' ),
					'type'        => Controls_Manager::SELECT,
					'default'     => 'html',
					'render_type' => 'none',
					'options'     => [
						'html'  => __( 'HTML', 'uael' ),
						'plain' => __( 'Plain', 'uael' ),
					],
					'condition'   => [
						'email_template' => 'custom',
					],
				]
			);

		$this->end_controls_section();

	}

	/**
	 * Register Registration Form General Style Controls.
	 *
	 * @since 1.18.0
	 * @access protected
	 */
	protected function register_validation_message_controls() {
		$this->start_controls_section(
			'section_validation_fields',
			[
				'label' => __( 'Success / Error Messages', 'uael' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

			$this->add_control(
				'validation_success_message',
				[
					'label'       => __( 'Success Message', 'uael' ),
					'type'        => Controls_Manager::TEXT,
					'default'     => __( 'Thank you for registering with us!', 'uael' ),
					'dynamic'     => [
						'active' => true,
					],
					'label_block' => true,
				]
			);

			$this->add_control(
				'validation_error_message',
				[
					'label'       => __( 'Error Message', 'uael' ),
					'type'        => Controls_Manager::TEXT,
					'default'     => __( 'Error: Something went wrong! Unable to complete the registration process.', 'uael' ),
					'dynamic'     => [
						'active' => true,
					],
					'label_block' => true,
				]
			);

		$this->end_controls_section();

	}

	/**
	 * Register Registration Form docs link.
	 *
	 * @since 1.18.0
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
						'raw'             => sprintf( __( '%1$s Getting started article » %2$s', 'uael' ), '<a href="https://uaelementor.com/docs/introducing-user-registration-form-widget/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin" target="_blank" rel="noopener">', '</a>' ),
						'content_classes' => 'uael-editor-doc',
					]
				);

				$this->add_control(
					'help_doc_4',
					[
						'type'            => Controls_Manager::RAW_HTML,
						/* translators: %1$s doc link */
						'raw'             => sprintf( __( '%1$s Create a User Registration Form using Elementor » %2$s', 'uael' ), '<a href="https://uaelementor.com/docs/create-user-registration-form-using-elementor/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin" target="_blank" rel="noopener">', '</a>' ),
						'content_classes' => 'uael-editor-doc',
					]
				);

				$this->add_control(
					'help_doc_2',
					[
						'type'            => Controls_Manager::RAW_HTML,
						/* translators: %1$s doc link */
						'raw'             => sprintf( __( '%1$s Registration Form with Only Email Field » %2$s', 'uael' ), '<a href="https://uaelementor.com/docs/create-user-registration-form-using-only-email-field/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin" target="_blank" rel="noopener">', '</a>' ),
						'content_classes' => 'uael-editor-doc',
					]
				);

				$this->add_control(
					'help_doc_3',
					[
						'type'            => Controls_Manager::RAW_HTML,
						/* translators: %1$s doc link */
						'raw'             => sprintf( __( '%1$s After Registration Actions » %2$s', 'uael' ), '<a href="https://uaelementor.com/docs/create-user-registration-form-using-elementor/#choose-post-registration-action" target="_blank" rel="noopener">', '</a>' ),
						'content_classes' => 'uael-editor-doc',
					]
				);

				$this->add_control(
					'help_doc_5',
					[
						'type'            => Controls_Manager::RAW_HTML,
						/* translators: %1$s doc link */
						'raw'             => sprintf( __( '%1$s Google reCAPTCHA v3 support » %2$s', 'uael' ), '<a href="https://uaelementor.com/docs/user-registration-form-with-recaptcha/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin" target="_blank" rel="noopener">', '</a>' ),
						'content_classes' => 'uael-editor-doc',
					]
				);

				$this->add_control(
					'help_doc_6',
					[
						'type'            => Controls_Manager::RAW_HTML,
						/* translators: %1$s doc link */
						'raw'             => sprintf( __( '%1$s Honeypot Spam Prevention field support » %2$s', 'uael' ), '<a href="https://uaelementor.com/docs/user-registration-form-with-honeypot/?utm_source=uael-pro-dashboard&utm_medium=uael-editor-screen&utm_campaign=uael-pro-plugin" target="_blank" rel="noopener">', '</a>' ),
						'content_classes' => 'uael-editor-doc',
					]
				);

				$this->add_control(
					'help_doc_7',
					[
						'type'            => Controls_Manager::RAW_HTML,
						/* translators: %1$s doc link */
						'raw'             => sprintf( __( '%1$s How to create a User Registration Form for a WooCommerce Page? » %2$s', 'uael' ), '<a href="https://uaelementor.com/docs/create-user-registration-form-using-elementor/#example:-user-registration-form-on-a-woocommerce-page" target="_blank" rel="noopener">', '</a>' ),
						'content_classes' => 'uael-editor-doc',
					]
				);

				$this->add_control(
					'help_doc_8',
					[
						'type'            => Controls_Manager::RAW_HTML,
						/* translators: %1$s doc link */
						'raw'             => sprintf( __( '%1$s How to manage Users on WordPress after Registration? » %2$s', 'uael' ), '<a href="https://uaelementor.com/docs/frequently-asked-questions-about-user-registration-forms/#3.-how-do-i-manage-users-on-wordpress-after-registration-" target="_blank" rel="noopener">', '</a>' ),
						'content_classes' => 'uael-editor-doc',
					]
				);

				$this->add_control(
					'help_doc_9',
					[
						'type'            => Controls_Manager::RAW_HTML,
						/* translators: %1$s doc link */
						'raw'             => sprintf( __( '%1$s Frequently asked questions » %2$s', 'uael' ), '<a href="https://uaelementor.com/docs/frequently-asked-questions-about-user-registration-forms/" target="_blank" rel="noopener">', '</a>' ),
						'content_classes' => 'uael-editor-doc',
					]
				);

			$this->end_controls_section();
		}

	}

	/**
	 * Register Registration Form General Style Controls.
	 *
	 * @since 1.18.0
	 * @access protected
	 */
	protected function register_spacing_controls() {
		$this->start_controls_section(
			'section_spacing_fields',
			[
				'label' => __( 'Spacing', 'uael' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_control(
				'column_gap',
				[
					'label'     => __( 'Columns Gap', 'uael' ),
					'type'      => Controls_Manager::SLIDER,
					'default'   => [
						'size' => 10,
					],
					'range'     => [
						'px' => [
							'min' => 0,
							'max' => 60,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .elementor-field-group' => 'padding-right: calc( {{SIZE}}{{UNIT}}/2 ); padding-left: calc( {{SIZE}}{{UNIT}}/2 );',
						'{{WRAPPER}} .elementor-form-fields-wrapper' => 'margin-left: calc( -{{SIZE}}{{UNIT}}/2 ); margin-right: calc( -{{SIZE}}{{UNIT}}/2 );',
					],
				]
			);

			$this->add_control(
				'row_gap',
				[
					'label'     => __( 'Rows Gap', 'uael' ),
					'type'      => Controls_Manager::SLIDER,
					'default'   => [
						'size' => 20,
					],
					'range'     => [
						'px' => [
							'min' => 0,
							'max' => 60,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .elementor-field-group:not( .elementor-field-type-submit ):not( .uael-rform-footer ):not( .uael-recaptcha-align-bottomright ):not( .uael-recaptcha-align-bottomleft )' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_control(
				'label_spacing',
				[
					'label'     => __( 'Label Bottom Spacing', 'uael' ),
					'type'      => Controls_Manager::SLIDER,
					'default'   => [
						'size' => 0,
					],
					'range'     => [
						'px' => [
							'min' => 0,
							'max' => 60,
						],
					],
					'selectors' => [
						'body.rtl {{WRAPPER}} .elementor-labels-inline .elementor-field-group > label' => 'padding-left: {{SIZE}}{{UNIT}};',
						// for the label position = inline option.
						'body:not(.rtl) {{WRAPPER}} .elementor-labels-inline .elementor-field-group > label' => 'padding-right: {{SIZE}}{{UNIT}};',
						// for the label position = inline option.
						'body {{WRAPPER}} .elementor-labels-above .elementor-field-group > label' => 'padding-bottom: {{SIZE}}{{UNIT}};',
						// for the label position = above option.
					],
					'condition' => [
						'show_labels!' => '',
					],
				]
			);

			$this->add_control(
				'button_spacing',
				[
					'label'              => __( 'Button Spacing', 'uael' ),
					'type'               => Controls_Manager::DIMENSIONS,
					'default'            => [
						'isLinked' => false,
					],
					'allowed_dimensions' => 'vertical',
					'size_units'         => [ 'px', 'em', '%' ],
					'selectors'          => [
						'{{WRAPPER}} .uael-registration-form .elementor-field-group.elementor-field-type-submit' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

		$this->end_controls_section();
	}

	/**
	 * Register Registration Form label Style Controls.
	 *
	 * @since 1.18.0
	 * @access protected
	 */
	protected function register_label_style_controls() {
		$this->start_controls_section(
			'section_label_style',
			[
				'label'     => __( 'Label', 'uael' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_labels!' => '',
				],
			]
		);

			$this->add_control(
				'label_color',
				[
					'label'     => __( 'Text Color', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'scheme'    => [
						'type'  => Scheme_Color::get_type(),
						'value' => Scheme_Color::COLOR_3,
					],
					'selectors' => [
						'{{WRAPPER}} .elementor-field-group > label, {{WRAPPER}} .elementor-field-subgroup label' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'label_typography',
					'selector' => '{{WRAPPER}} .elementor-field-group > label',
					'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
				]
			);

			$this->add_control(
				'mark_required_color',
				[
					'label'     => __( 'Required Mark Color', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .elementor-mark-required .elementor-field-label:after' => 'color: {{COLOR}};',
					],
					'condition' => [
						'mark_required' => 'yes',
					],
				]
			);

		$this->end_controls_section();
	}

	/**
	 * Register Registration Form Input Fields Style Controls.
	 *
	 * @since 1.18.0
	 * @access protected
	 */
	protected function register_input_style_controls() {
		$this->start_controls_section(
			'section_input_style',
			[
				'label' => __( 'Input Fields', 'uael' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_control(
				'input_style',
				[
					'label'   => __( 'Input Style', 'uael' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'box',
					'options' => [
						'box'       => __( 'Box', 'uael' ),
						'underline' => __( 'Underline', 'uael' ),
					],
				]
			);

			$this->add_control(
				'field_text_color',
				[
					'label'     => __( 'Text Color', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .elementor-field-group .elementor-field' => 'color: {{VALUE}};',
					],
					'scheme'    => [
						'type'  => Scheme_Color::get_type(),
						'value' => Scheme_Color::COLOR_3,
					],
				]
			);

			$this->add_control(
				'field_background_color',
				[
					'label'     => __( 'Background Color', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '#ffffff',
					'selectors' => [
						'{{WRAPPER}} .elementor-field-group .elementor-field' => 'background-color: {{VALUE}};',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'field_typography',
					'selector' => '{{WRAPPER}} .elementor-field-group .elementor-field',
					'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
				]
			);

			$this->add_control(
				'input_padding',
				[
					'label'      => __( 'Padding', 'uael' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .elementor-field-group .elementor-field' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_control(
				'field_border_color',
				[
					'label'     => __( 'Border Color', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '#c4c4c4',
					'selectors' => [
						'{{WRAPPER}} .elementor-field-group .elementor-field' => 'border-color: {{VALUE}};',
					],
					'separator' => 'before',
				]
			);

			$this->add_control(
				'active_border_color',
				[
					'label'     => __( 'Border Active Color', 'uael' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '#a5afb8',
					'selectors' => [
						'{{WRAPPER}} .elementor-field-group .elementor-field:focus' => 'border-color: {{VALUE}};',
					],
				]
			);

			$this->add_responsive_control(
				'field_border_width_box',
				[
					'label'       => __( 'Border Width', 'uael' ),
					'type'        => Controls_Manager::DIMENSIONS,
					'placeholder' => '1',
					'selectors'   => [
						'{{WRAPPER}} .elementor-field-group .elementor-field' => 'border-width: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
					],
					'condition'   => [
						'input_style' => 'box',
					],
				]
			);

			$this->add_responsive_control(
				'field_border_width_underline',
				[
					'label'     => __( 'Border Width', 'uael' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'max' => 25,
						],
					],
					'default'   => [
						'size' => '2',
						'unit' => 'px',
					],
					'selectors' => [
						'{{WRAPPER}} .elementor-field-group .elementor-field' => 'border-width: 0px 0px {{SIZE}}px 0px; border-style: solid; box-shadow: none;',
					],
					'condition' => [
						'input_style' => 'underline',
					],
				]
			);

			$this->add_control(
				'field_border_radius',
				[
					'label'      => __( 'Border Radius', 'uael' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'default'    => [
						'top'    => '2',
						'bottom' => '2',
						'left'   => '2',
						'right'  => '2',
						'unit'   => 'px',
					],
					'selectors'  => [
						'{{WRAPPER}} .elementor-field-group .elementor-field' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

		$this->end_controls_section();
	}

	/**
	 * Register Registration Form Register Button Style Controls.
	 *
	 * @since 1.18.0
	 * @access protected
	 */
	protected function register_submit_style_controls() {
		$this->start_controls_section(
			'section_submit_style',
			[
				'label' => __( 'Register Button', 'uael' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'button_typography',
					'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
					'selector' => '{{WRAPPER}} .elementor-button',
				]
			);

			$this->add_control(
				'button_text_padding',
				[
					'label'      => __( 'Padding', 'uael' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .elementor-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->start_controls_tabs( 'tabs_button_style' );

				$this->start_controls_tab(
					'tab_button_normal',
					[
						'label' => __( 'Normal', 'uael' ),
					]
				);

					$this->add_control(
						'button_text_color',
						[
							'label'     => __( 'Text Color', 'uael' ),
							'type'      => Controls_Manager::COLOR,
							'default'   => '',
							'selectors' => [
								'{{WRAPPER}} .elementor-button' => 'color: {{VALUE}};',
								'{{WRAPPER}} .elementor-button svg' => 'fill: {{VALUE}};',
							],
						]
					);

					$this->add_group_control(
						Group_Control_Background::get_type(),
						[
							'name'           => 'button_background_color',
							'label'          => __( 'Background Color', 'uael' ),
							'types'          => [ 'classic', 'gradient' ],
							'selector'       => '{{WRAPPER}} .elementor-button',
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

					$this->add_group_control(
						Group_Control_Border::get_type(),
						[
							'name'     => 'button_border',
							'selector' => '{{WRAPPER}} .elementor-button',
						]
					);

					$this->add_control(
						'button_border_radius',
						[
							'label'      => __( 'Border Radius', 'uael' ),
							'type'       => Controls_Manager::DIMENSIONS,
							'size_units' => [ 'px', '%' ],
							'selectors'  => [
								'{{WRAPPER}} .elementor-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							],
						]
					);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'tab_button_hover',
					[
						'label' => __( 'Hover', 'uael' ),
					]
				);

					$this->add_control(
						'button_hover_color',
						[
							'label'     => __( 'Text Color', 'uael' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .elementor-button:hover' => 'color: {{VALUE}};',
							],
						]
					);

					$this->add_group_control(
						Group_Control_Background::get_type(),
						[
							'name'           => 'button_background_hover_color',
							'label'          => __( 'Hover Background Color', 'uael' ),
							'types'          => [ 'classic', 'gradient' ],
							'selector'       => '{{WRAPPER}} .elementor-button:hover',
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
						'button_hover_border_color',
						[
							'label'     => __( 'Border Color', 'uael' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .elementor-button:hover' => 'border-color: {{VALUE}};',
							],
							'condition' => [
								'button_border_border!' => '',
							],
						]
					);

					$this->add_control(
						'button_hover_animation',
						[
							'label' => __( 'Animation', 'uael' ),
							'type'  => Controls_Manager::HOVER_ANIMATION,
						]
					);

				$this->end_controls_tab();

			$this->end_controls_tabs();

		$this->end_controls_section();
	}

	/**
	 * Register Registration Form Success & Error Messages Style Controls.
	 *
	 * @since 1.18.0
	 * @access protected
	 */
	protected function register_error_style_controls() {
		$this->start_controls_section(
			'section_messages_style',
			[
				'label' => __( 'Success / Error Messages', 'uael' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_control(
				'field_error_heading',
				[
					'label' => __( 'Error Field Validation', 'uael' ),
					'type'  => Controls_Manager::HEADING,
				]
			);

				$this->add_control(
					'error_message_style',
					[
						'label'        => __( 'Message Style', 'uael' ),
						'type'         => Controls_Manager::SELECT,
						'default'      => 'default',
						'options'      => [
							'default' => __( 'Default', 'uael' ),
							'custom'  => __( 'Custom', 'uael' ),
						],
						'prefix_class' => 'uael-form-message-style-',
					]
				);

				// Validation Message color.
				$this->add_control(
					'error_message_highlight_color',
					[
						'label'     => __( 'Message Color', 'uael' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#ffffff',
						'condition' => [
							'error_message_style' => 'custom',
						],
						'selectors' => [
							'{{WRAPPER}} .uael-register-error' => 'color: {{VALUE}};',
						],
					]
				);

				$this->add_control(
					'error_message_bgcolor',
					[
						'label'     => __( 'Message Background Color', 'uael' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => 'rgba(255, 0, 0, 0.6)',
						'condition' => [
							'error_message_style' => 'custom',
						],
						'selectors' => [
							'{{WRAPPER}} .uael-register-error' => 'background-color: {{VALUE}}; padding: 0.2em 0.8em;',
						],
					]
				);

				$this->add_control(
					'error_form_error_msg_color',
					[
						'label'     => __( 'Message Color', 'uael' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#ff0000',
						'condition' => [
							'error_message_style!' => 'custom',
						],
						'selectors' => [
							'{{WRAPPER}} .uael-register-error' => 'color: {{VALUE}}',
						],
					]
				);

				$this->add_group_control(
					Group_Control_Typography::get_type(),
					[
						'name'     => 'error_message_typo',
						'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
						'selector' => '{{WRAPPER}} .uael-register-error',
					]
				);

				$this->add_control(
					'success_message',
					[
						'label'     => __( 'Form Success & Error Messages', 'uael' ),
						'type'      => Controls_Manager::HEADING,
						'separator' => 'before',
					]
				);

				$this->add_control(
					'preview_message',
					[
						'label'        => __( 'Preview Messages', 'uael' ),
						'type'         => Controls_Manager::SWITCHER,
						'return_value' => 'yes',
						'default'      => 'no',
					]
				);

				$this->add_control(
					'message_wrap_style',
					[
						'label'   => __( 'Message Style', 'uael' ),
						'type'    => Controls_Manager::SELECT,
						'default' => 'default',
						'options' => [
							'default' => __( 'Default', 'uael' ),
							'custom'  => __( 'Custom', 'uael' ),
						],
					]
				);

				$this->add_control(
					'success_message_color',
					[
						'label'     => __( 'Success Message Color', 'uael' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#008000',
						'selectors' => [
							'{{WRAPPER}} .uael-registration-message.success,{{WRAPPER}} .uael-reg-preview-message.success' => 'color: {{VALUE}};',
						],
						'condition' => [
							'message_wrap_style' => 'custom',
						],
					]
				);

				$this->add_control(
					'error_message_color',
					[
						'label'     => __( 'Error Message Color', 'uael' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#d9534f',
						'selectors' => [
							'{{WRAPPER}} .uael-registration-message.error,{{WRAPPER}} .uael-reg-preview-message.error' => 'color: {{VALUE}};',
						],
						'condition' => [
							'message_wrap_style' => 'custom',
						],
					]
				);

				$this->add_group_control(
					Group_Control_Typography::get_type(),
					[
						'name'     => 'message_validation_typo',
						'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
						'selector' => '{{WRAPPER}} .uael-registration-message, {{WRAPPER}} .uael-reg-preview-message',
					]
				);

		$this->end_controls_section();
	}

	/**
	 * Render RegistrationForm output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.18.0
	 * @access protected
	 */
	protected function render() {

		$settings               = $this->get_settings_for_display();
		$node_id                = $this->get_id();
		$is_pass_valid          = false;
		$is_confirm_pass        = false;
		$is_editor              = \Elementor\Plugin::instance()->editor->is_edit_mode();
		$page_id                = '';
		$is_email_exists        = 0;
		$is_user_name_exists    = 0;
		$is_password_exists     = 0;
		$is_confirm_pass_exists = 0;
		$is_first_name_exists   = 0;
		$is_last_name_exists    = 0;
		$is_recaptcha_v3_exists = 0;
		$is_honeypot_exists     = 0;

		$integration_settings = UAEL_Helper::get_integrations_options();
		$sitekey              = $integration_settings['recaptcha_v3_key'];
		$secretkey            = $integration_settings['recaptcha_v3_secretkey'];

		if ( 'true' === $settings['hide_form'] && is_user_logged_in() && ! $is_editor ) {
			$current_user = wp_get_current_user();
			?>
			<div class="uael-registration-form">
				<div class="uael-registration-loggedin-message">
					<?php
					if ( '' !== $settings['logged_in_text'] ) {
						echo '<span>' . $settings['logged_in_text'] . '</span>';
					}
					?>
				</div>
			</div>
			<?php
		} else {

			if ( null !== \Elementor\Plugin::$instance->documents->get_current() ) {
				$page_id = \Elementor\Plugin::$instance->documents->get_current()->get_main_id();
			}

			if ( ! empty( $settings['fields_list'] ) ) :

				$this->add_render_attribute(
					[
						'wrapper'      => [
							'class' => [
								'uael-registration-form-wrapper',
								'elementor-form-fields-wrapper',
								'elementor-labels-above',
							],
						],
						'button'       => [
							'class' => 'elementor-button uael-register-submit',
						],
						'submit-group' => [
							'class' => [
								'uael-reg-form-submit',
								'elementor-field-group',
								'elementor-column',
								'elementor-field-type-submit',
								'elementor-col-' . $settings['button_width'],
							],
						],
						'icon-align'   => [
							'class' => [
								empty( $settings['button_icon_align'] ) ? '' :
									'elementor-align-icon-' . $settings['button_icon_align'],
								'elementor-button-icon',
							],
						],
						'widget-wrap'  => [
							'data-page-id'         => $page_id,
							'data-success-message' => $settings['validation_success_message'],
							'data-error-message'   => $settings['validation_error_message'],
							'data-strength-check'  => $settings['strength_checker'],
						],
					]
				);

				if ( ! empty( $settings['button_width_tablet'] ) ) {
					$this->add_render_attribute( 'submit-group', 'class', 'elementor-md-' . $settings['button_width_tablet'] );
				}

				if ( ! empty( $settings['button_width_mobile'] ) ) {
					$this->add_render_attribute( 'submit-group', 'class', 'elementor-sm-' . $settings['button_width_mobile'] );
				}

				if ( ! empty( $settings['button_size'] ) ) {
					$this->add_render_attribute( 'button', 'class', 'elementor-size-' . $settings['button_size'] );
				}

				if ( ! empty( $settings['button_type'] ) ) {
					$this->add_render_attribute( 'button', 'class', 'elementor-button-' . $settings['button_type'] );
				}

				if ( $settings['button_hover_animation'] ) {
					$this->add_render_attribute( 'button', 'class', 'elementor-animation-' . $settings['button_hover_animation'] );
				}

				if ( 'true' === $settings['hide_form'] ) {
					$this->add_render_attribute( 'widget-wrap', 'data-hide_form', 'yes' );
				}

				$actions_arr = [];
				$notify_mail = 'admin';

				if ( ! empty( $settings['actions_array'] ) ) {

					if ( is_array( $settings['actions_array'] ) ) {
						foreach ( $settings['actions_array'] as $action ) {
							if ( 'send_email' === $action ) {
								$notify_mail = 'both';
							} elseif ( 'redirect' === $action ) {
								if ( ! empty( $settings['redirect_url']['url'] ) ) {
									$this->add_render_attribute( 'widget-wrap', 'data-redirect-url', $settings['redirect_url']['url'] );
								}
							} else {
								$this->add_render_attribute(
									'widget-wrap',
									[
										'data-' . $action => 'yes',
									]
								);
							}
						}
					} else {
						if ( 'send_email' === $settings['actions_array'] ) {
							$notify_mail = 'both';
						} elseif ( 'redirect' === $settings['actions_array'] ) {
							if ( ! empty( $settings['redirect_url']['url'] ) ) {
								$this->add_render_attribute( 'widget-wrap', 'data-redirect-url', $settings['redirect_url']['url'] );
							}
						} else {
							$this->add_render_attribute(
								'widget-wrap',
								[
									'data-' . $settings['actions_array'] => 'yes',
								]
							);
						}
					}
				}

				$notify_mail = apply_filters( 'uael_registration_notify_email', $notify_mail, $settings );

				$this->add_render_attribute( 'widget-wrap', 'data-send_email', $notify_mail );

				ob_start();
				?>
					<div class="uael-registration-form" <?php echo $this->get_render_attribute_string( 'widget-wrap' ); ?>>
						<form class="elementor-form" method="post" <?php echo $this->get_render_attribute_string( 'form' ); ?>>
							<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
								<?php
								foreach ( $settings['fields_list'] as $item_index => $item ) :

									$field_type = $item['field_type'];
									if ( 'user_name' === $field_type || 'first_name' === $field_type || 'last_name' === $field_type ) {
										$field_input_type = 'text';
									} elseif ( 'confirm_pass' === $field_type ) {
										$field_input_type = 'password';
										$is_confirm_pass  = true;
									} else {
										if ( 'password' === $field_type ) {
											$is_pass_valid = true;
										}
										$field_input_type = $field_type;
									}

									${ 'is_' . $field_type . '_exists' }++;

									$this->add_render_attribute( 'input' . $item_index, 'type', $field_input_type );

									$this->add_render_attribute(
										[
											'input' . $item_index => [
												'name'  => $field_type,
												'placeholder' => $item['placeholder'],
												'class' => [
													'elementor-field',
													'elementor-size-' . $settings['input_size'],
													'form-field-' . $field_type,
												],
											],
											'label' . $item_index => [
												'for'   => 'form-field-' . $field_type,
												'class' => 'elementor-field-label',
											],
										]
									);

									if ( ! $settings['show_labels'] ) {
										$this->add_render_attribute( 'label' . $item_index, 'class', 'elementor-screen-only' );
									}

									if ( ! empty( $item['required'] ) || 'email' === $field_type || 'password' === $field_type ) {

										$required_class = 'elementor-field-required';
										if ( ! empty( $settings['mark_required'] ) ) {
											$required_class .= ' elementor-mark-required';
										}
										$this->add_render_attribute( 'field-group' . $item_index, 'class', $required_class );

										$this->add_render_attribute( 'input' . $item_index, 'required', 'required' );
										$this->add_render_attribute( 'input' . $item_index, 'aria-required', 'true' );
									}

									$this->add_render_attribute(
										[
											'field-group' . $item_index => [
												'class' => [
													'elementor-field-group',
													'uael-input-fields',
													'elementor-field-type-' . $field_type,
													'elementor-column',
													'elementor-col-' . $item['width'],
												],
											],
										]
									);

									if ( 'recaptcha_v3' === $field_type ) {
										$this->add_render_attribute( 'field-group' . $item_index, 'class', 'uael-recaptcha-align-' . $item['recaptcha_badge'] );
									}

									if ( ! empty( $item['width_tablet'] ) ) {
										$this->add_render_attribute( 'field-group' . $item_index, 'class', 'elementor-md-' . $item['width_tablet'] );
									}

									if ( ! empty( $item['width_mobile'] ) ) {
										$this->add_render_attribute( 'field-group' . $item_index, 'class', 'elementor-sm-' . $item['width_mobile'] );
									}
									if ( 'honeypot' !== $field_type ) {
										?>
										<div <?php echo $this->get_render_attribute_string( 'field-group' . $item_index ); ?>>
											<?php
											if ( $item['field_label'] ) {
												echo '<label ' . $this->get_render_attribute_string( 'label' . $item_index ) . '>' . $item['field_label'] . '</label>';
											}

											switch ( $field_type ) :
												case 'user_name':
												case 'email':
												case 'password':
												case 'first_name':
												case 'last_name':
												case 'confirm_pass':
													$this->add_render_attribute( 'input' . $item_index, 'class', 'elementor-field-textual' );
													echo '<input size="1" ' . $this->get_render_attribute_string( 'input' . $item_index ) . '>';
													break;
												case 'recaptcha_v3':
													if ( '' !== $sitekey && '' !== $secretkey ) {
														echo '<div id="uael-g-recaptcha-' . $node_id . '" class="uael-g-recaptcha-field elementor-field form-field-recaptcha" data-sitekey=' . $sitekey . ' data-type="v3" data-action="Form" data-badge="' . $item['recaptcha_badge'] . '" data-size="invisible"></div>';
													} else {
														echo '<div class="elementor-alert uael-recaptcha-alert elementor-alert-warning">';
														echo __( 'To use reCAPTCHA v3, you need to add the API Key and complete the setup process in Dashboard > Settings > UAE > User Registration Form Settings > reCAPTCHA v3.', 'uael' );
														echo '</div>';
													}
													break;

												default:
													break;

											endswitch;
											?>
											<?php if ( 'password' === $field_type ) : ?>
												<div class="uael-pass-wrapper" style="display: none;">
													<div class="uael-pass-bar"><div class="uael-pass-bar-color"></div></div>
													<span class="uael-pass-notice"></span>
												</div>
											<?php endif; ?>
										</div>
										<?php
									} elseif ( 'honeypot' === $field_type ) {
										echo '<div class="uael-input-fields">';
											echo '<input size="1" type="text" style="display:none !important;" class="elementor-field elementor-field-type-text uael-regform-set-field">';
										echo '</div>';
									}
								endforeach;

								?>
								<div <?php echo $this->get_render_attribute_string( 'submit-group' ); ?>>
									<button type="submit" <?php echo $this->get_render_attribute_string( 'button' ); ?>>
										<span <?php echo $this->get_render_attribute_string( 'content-wrapper' ); ?>>
											<?php if ( ! empty( $settings['button_icon'] ) && '' !== $settings['button_icon']['value'] ) : ?>
												<span <?php echo $this->get_render_attribute_string( 'icon-align' ); ?>>
													<?php Icons_Manager::render_icon( $settings['button_icon'], [ 'aria-hidden' => 'true' ] ); ?>
													<?php if ( empty( $settings['button_text'] ) ) : ?>
														<span class="elementor-screen-only"><?php _e( 'Submit', 'uael' ); ?></span>
													<?php endif; ?>
												</span>
											<?php endif; ?>
											<?php if ( ! empty( $settings['button_text'] ) ) : ?>
												<span class="elementor-button-text uael-registration-submit"><?php echo $settings['button_text']; ?></span>
											<?php endif; ?>
										</span>
									</button>
								</div>
								<div class="uael-rform-footer elementor-field-group">

									<?php
									if ( 'true' === $settings['login'] && '' !== $settings['login_text'] ) {

										$login_url = wp_login_url();

										$this->add_render_attribute( 'login', 'class', 'uael-rform-footer-link' );

										if ( 'custom' === $settings['login_select'] && ! empty( $settings['login_url'] ) ) {

											$this->add_render_attribute( 'login', 'href', $settings['login_url']['url'] );

											if ( $settings['login_url']['is_external'] ) {
												$this->add_render_attribute( 'login', 'target', '_blank' );
											}

											if ( $settings['login_url']['nofollow'] ) {
												$this->add_render_attribute( 'login', 'rel', 'nofollow' );
											}
										} else {
											$this->add_render_attribute( 'login', 'href', $login_url );
										}
										?>

										<a <?php echo $this->get_render_attribute_string( 'login' ); ?>>
											<span><?php echo $settings['login_text']; ?></span>
										</a>
									<?php } ?>

									<?php
									if ( 'true' === $settings['lost_password'] && '' !== $settings['lost_password_text'] ) {

										$lost_pass_url = wp_lostpassword_url();

										$this->add_render_attribute( 'lost_pass', 'class', 'uael-rform-footer-link' );

										if ( 'custom' === $settings['lost_password_select'] && ! empty( $settings['lost_password_url'] ) ) {

											$this->add_render_attribute( 'lost_pass', 'href', $settings['lost_password_url']['url'] );

											if ( $settings['lost_password_url']['is_external'] ) {
												$this->add_render_attribute( 'lost_pass', 'target', '_blank' );
											}

											if ( $settings['lost_password_url']['nofollow'] ) {
												$this->add_render_attribute( 'lost_pass', 'rel', 'nofollow' );
											}
										} else {
											$this->add_render_attribute( 'lost_pass', 'href', $lost_pass_url );
										}
										?>

										<a <?php echo $this->get_render_attribute_string( 'lost_pass' ); ?>>
											<span><?php echo $settings['lost_password_text']; ?></span>
										</a>
									<?php } ?>
								</div>
							</div>
						</form>
						<?php
						$this->add_render_attribute( 'validation_messages', 'class', 'uael-registration-message' );
						if ( 'default' === $settings['message_wrap_style'] ) {
							$this->add_render_attribute( 'validation_messages', 'class', 'elementor-alert' );
						}

						if ( 'yes' === $settings['preview_message'] && $is_editor ) {
							if ( 'default' === $settings['message_wrap_style'] ) {
								?>
								<div class="uael-reg-preview-message elementor-alert success"><?php echo __( 'This is a success message preview!', 'uael' ); ?></div>
								<div class="uael-reg-preview-message elementor-alert error"><?php echo __( 'This is a error message preview!', 'uael' ); ?></div>
							<?php } else { ?>
								<div class="uael-reg-preview-message success"><?php echo __( 'This is a success message preview!', 'uael' ); ?></div>
								<div class="uael-reg-preview-message error"><?php echo __( 'This is a error message preview!', 'uael' ); ?></div>
							<?php } ?>
						<?php } ?>
						<div <?php echo $this->get_render_attribute_string( 'validation_messages' ); ?>></div>
					</div>
					<?php
					$html                = ob_get_clean();
					$is_allowed_register = get_option( 'users_can_register' );
					$fields_array        = array(
						'email'        => 'Email',
						'password'     => 'Password',
						'confirm_pass' => 'Confirm Password',
						'user_name'    => 'Username',
						'first_name'   => 'First Name',
						'last_name'    => 'Last Name',
						'recaptcha_v3' => 'Recaptcha',
					);
					$error_string        = '';

					if ( $is_editor ) {
						if ( $is_allowed_register ) {
							foreach ( $fields_array as $key => $value ) {
								$is_repeated = ${ 'is_' . $key . '_exists' };

								if ( isset( $is_repeated ) && 1 < $is_repeated ) {
									$error_string .= $value . ', ';
								}
							}
							if ( '' !== $error_string ) {
								$error_string = rtrim( $error_string, ', ' );
								?>
								<span class='uael-register-error-message'>
									<?php
									echo '<div class="elementor-alert elementor-alert-warning">';
									/* translators: %s: Error String */
									echo sprintf( __( 'Error! It seems like you have added <b>%s</b> field in the form more than once.', 'uael' ), $error_string );
									echo '</div>';
									?>
								</span>
								<?php
								return false;
							}

							if ( isset( $is_email_exists ) && 0 === $is_email_exists ) {
								?>
								<span class='uael-register-error-message'>
									<?php
									echo '<div class="elementor-alert elementor-alert-warning">';
										echo __( 'For Registration Form E-mail field is required!', 'uael' );
									echo '</div>';
									?>
								</span>
								<?php
								return false;
							} elseif ( $is_confirm_pass && ! $is_pass_valid ) {
								?>
								<span class='uael-register-error-message'>
									<?php
									echo '<div class="elementor-alert elementor-alert-warning">';
									echo __( 'Password field should be added to the form to use the Confirm Password field.', 'uael' );
									echo '</div>';
									?>
								</span>
								<?php
								return false;
							}
						} elseif ( is_multisite() ) {
							?>
							<span class='uael-register-error-message'>
								<?php
								echo '<div class="elementor-alert elementor-alert-warning">';
								echo __( 'To use the Registration Form on your site, you must set the "Allow new registrations" to "User accounts may be registered" setting from Network Admin -> Dashboard -> Settings.', 'uael' );
								echo '</div>';
								?>
							</span>
							<?php
							return false;
						} else {
							?>
							<span class='uael-register-error-message'>
								<?php
								echo '<div class="elementor-alert elementor-alert-warning">';
								echo __( 'To use the Registration Form on your site, you must enable the "Anyone Can Register" setting from Dashboard -> Settings -> General -> Membership.', 'uael' );
								echo '</div>';
								?>
							</span>
							<?php
							return false;
						}
					} elseif ( ( ( ! $is_email_exists ) || ( $is_confirm_pass && ! $is_pass_valid ) ) && ( ! $is_editor ) ) {
						return false;
					} elseif ( ! $is_allowed_register ) {
						return false;
					}
					echo $html;
			endif;

		}

	}

}

<?php
/**
 * UAEL Countdown Timer module.
 *
 * @package UAEL
 */

namespace UltimateElementor\Modules\Countdown;

use UltimateElementor\Base\Module_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class Module.
 */
class Module extends Module_Base {

	/**
	 * Module should load or not.
	 *
	 * @since 1.14.0
	 * @access public
	 *
	 * @return bool true|false.
	 */
	public static function is_enable() {
		return true;
	}

	/**
	 * Get Module Name.
	 *
	 * @since 1.14.0
	 * @access public
	 *
	 * @return string Module name.
	 */
	public function get_name() {
		return 'countdown';
	}

	/**
	 * Get Widgets.
	 *
	 * @since 1.14.0
	 * @access public
	 *
	 * @return array Widgets.
	 */
	public function get_widgets() {
		return [
			'Countdown',
		];
	}

	/**
	 * Constructor.
	 */
	public function __construct() {
		parent::__construct();
	}
}

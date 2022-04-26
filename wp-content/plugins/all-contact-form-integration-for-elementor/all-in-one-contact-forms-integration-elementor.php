<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://theinnovs.com
 * @since             2.0
 * @package           Complete Form Integration with DB For Elementor
 *
 * @wordpress-plugin
 * Plugin Name:       ElementoForms - All Forms Integration with DB for Elementor
 * Plugin URI:        https://wordpress.org/plugins/all-contact-form-integration-for-elementor/
 * Description:       Easily integrate, style and Store Form Submissions of your Contact Form 7, Ninja Forms, Gravity Forms, Elementor Form.
 * Version:           2.3
 * Author:            TheInnovs
 * Author URI:        https://theinnovs.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       Contact Form Integration For Elementor
 * Domain Path:       /languages
 * Requires at least: 4.4
 * Tested up to:    5.3
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
  die;
}
/**
 * Currently plugin version.
 * Start at version 2.2 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'DB_Elementor_Form', '2.3' );


define( 'ACFE_CONTACT_FORM_7_URL', plugins_url( '/', __FILE__ ) );
define( 'ACFE_CONTACT_FORM_7_PATH', plugin_dir_path( __FILE__ ) );
define( 'ACFE_GRAVITY_FORM_URL', plugins_url( '/', __FILE__ ) );
define( 'ACFE_GRAVITY_FORM_PATH', plugin_dir_path( __FILE__ ) );
define( 'Acfe_Ninja_Forms_Style_URL', plugins_url( '/', __FILE__ ) );
define( 'Acfe_Ninja_Forms_Style_PATH', plugin_dir_path( __FILE__ ) );


require_once ACFE_CONTACT_FORM_7_PATH.'includes/elementor-helper.php';
require_once ACFE_CONTACT_FORM_7_PATH.'includes/queries.php';
require_once ACFE_GRAVITY_FORM_PATH.'includes/elementor-helper.php';
require_once ACFE_GRAVITY_FORM_PATH.'includes/queries.php';
require_once Acfe_Ninja_Forms_Style_PATH.'includes/elementor-helper.php';
require_once Acfe_Ninja_Forms_Style_PATH.'includes/queries.php';

// Upsell
include_once dirname( __FILE__ ) . '/includes/acfe-cf7-upsell.php';
new acfe_Upsell('');

include_once dirname( __FILE__ ) . '/includes/acfe-gravity-form-upsell.php';
new Acfe_Gravity_Form_Upsell('');

include_once dirname( __FILE__ ) . '/includes/acfe-ninja-forms-upsell.php';
new Acfe_Ninja_Forms_Style_Upsell('');

/**
 * Load all-elementor-forms and css
 */

//Load IE Contact Form 7
function add_acfe_contact_form_7() {

  if ( function_exists( 'wpcf7' ) ) {
    require_once ACFE_CONTACT_FORM_7_PATH.'includes/contact-form-7.php';
  }

}
add_action('elementor/widgets/widgets_registered','add_acfe_contact_form_7');


//Load IE Gravity Forms
function add_acfe_gravity_form() {

  if ( class_exists( 'GFForms' ) ) {
    require_once ACFE_GRAVITY_FORM_PATH.'includes/gravity-form.php';
  }

}
add_action('elementor/widgets/widgets_registered','add_acfe_gravity_form');

//Load acfe Ninja Form
function add_Acfe_Ninja_Forms_Style() {

  if ( function_exists( 'Ninja_Forms' ) ) {
    require_once Acfe_Ninja_Forms_Style_PATH.'includes/ninja-forms.php';
  }

}
add_action('elementor/widgets/widgets_registered','add_Acfe_Ninja_Forms_Style');


// Load acfe Contact Form 7 CSS
function acfe_contact_form_7_enqueue() {

   wp_enqueue_style('innovs_element_elementor-cf7-css',ACFE_CONTACT_FORM_7_URL.'admin/assets/css/elementor-contact-form-7');

}
add_action( 'wp_enqueue_scripts', 'acfe_contact_form_7_enqueue' );


// Load acfe Gravity Form CSS 
function acfe_gravity_form_enqueue() {

   wp_enqueue_style('innovs_element_all-elementor-forms-css',ACFE_GRAVITY_FORM_URL.'admin/assets/css/elementor-gravity-form');

}
add_action( 'wp_enqueue_scripts', 'acfe_gravity_form_enqueue' );


// Load acfe Ninja Form CSS
function Acfe_Ninja_Forms_Style_enqueue() {

   wp_enqueue_style('innovs_element_elementor-nf-css',Acfe_Ninja_Forms_Style_URL.'admin/assets/css/elementor-ninja-forms');

}
add_action( 'wp_enqueue_scripts', 'Acfe_Ninja_Forms_Style_enqueue' );

// End all in one file ===================================================== Only for this file

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-plugin-name-activator.php
 */
function void_activate_db_elementor_form() {
  require_once plugin_dir_path( __FILE__ ) . 'includes/class-db-elementor-form-activator.php';
  DB_Elementor_Form_Activator::void_db_element_form_activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-plugin-name-deactivator.php
 */
function void_deactivate_db_elementor_form() {
  require_once plugin_dir_path( __FILE__ ) . 'includes/class-db-elementor-form-deactivator.php';
  DB_Elementor_Form_Deactivator::void_db_element_form_deactivate();
}

register_activation_hook( __FILE__, 'void_activate_db_elementor_form' );
register_deactivation_hook( __FILE__, 'void_deactivate_db_elementor_form' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-db-elementor-form.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.7
 */
function void_run_db_elementor_form() {

  $plugin = new DB_Elementor_Form();
  $plugin->run();

}
void_run_db_elementor_form();

<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://https://author.example.com/
 * @since             1.0.0
 * @package           Catalog_Mode
 *
 * @wordpress-plugin
 * Plugin Name:       Catalog Mode
 * Plugin URI:        https:// https://example.com/plugins/the-basics/
 * Description:       Hide Product prices for specific users.
 * Version:           1.0.0
 * Author:            Rajalaxmi
 * Author URI:        https://https://author.example.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       catalog-mode
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
if ( !defined( 'RP_CATALOG_MODE_FILE' ) ) {
    define( 'RP_CATALOG_MODE_FILE', __FILE__ );
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'CATALOG_MODE_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-catalog-mode-activator.php
 */
function activate_catalog_mode() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-catalog-mode-activator.php';
	Catalog_Mode_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-catalog-mode-deactivator.php
 */
function deactivate_catalog_mode() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-catalog-mode-deactivator.php';
	Catalog_Mode_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_catalog_mode' );
register_deactivation_hook( __FILE__, 'deactivate_catalog_mode' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-catalog-mode.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_catalog_mode() {

	$plugin = new Catalog_Mode();
	$plugin->run();

}
run_catalog_mode();

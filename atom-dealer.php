<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              NWS
 * @since             1.0.0
 * @package           Atom_Dealer
 *
 * @wordpress-plugin
 * Plugin Name:       Atom Dealer
 * Plugin URI:        
 * Description:       Wordpress plugin for custom tables and setting pages. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            NWS
 * Author URI:        NWS
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       atom-dealer
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'ATOM_DEALER_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-atom-dealer-activator.php
 */
function activate_atom_dealer() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-atom-dealer-activator.php';
	Atom_Dealer_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-atom-dealer-deactivator.php
 */
function deactivate_atom_dealer() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-atom-dealer-deactivator.php';
	Atom_Dealer_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_atom_dealer' );
register_deactivation_hook( __FILE__, 'deactivate_atom_dealer' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-atom-dealer.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_atom_dealer() {

	$plugin = new Atom_Dealer();
	$plugin->run();

}
run_atom_dealer();

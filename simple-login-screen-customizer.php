<?php
/**
 * @package   Simple Login Screen Customizer
 * @author    Allison Levine (firewatch)
 * @license   GPL-2.0+
 * @link      https://github.com/allilevine/Simple-Login-Screen-Customizer
 * @copyright 2014 Allison Levine
 *
 * @wordpress-plugin
 * Plugin Name:       Simple Login Screen Customizer
 * Plugin URI:        https://github.com/allilevine/Simple-Login-Screen-Customizer
 * Description:       Choose a link color and logo for the login screen.  You can also choose rollover and button colors if you'd like. 
 * Version:           1.0.2
 * Author:            Allison Levine
 * Author URI:        https://github.com/allilevine
 * Text Domain:       plugin-name-locale
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 * GitHub Plugin URI: https://github.com/allilevine/Simple-Login-Screen-Customizer
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

require_once( plugin_dir_path( __FILE__ ) . 'simple-login-screen-customizer-public.php' );
require_once( plugin_dir_path( __FILE__ ) . 'simple-login-screen-customizer-admin.php' );

// Add settings link on plugin page
function simpleloginscreencustomizer_settings_link($links, $file) { 
  $simpleloginscreencustomizer_plugin = plugin_basename(__FILE__); 
  if ($file == $simpleloginscreencustomizer_plugin) {
	  $settings_link = '<a href="options-general.php?page=simpleloginscreencustomizer_plugin_options">Settings</a>'; 
	  array_unshift($links, $settings_link); 
  }
  return $links; 
}
add_filter("plugin_action_links", 'simpleloginscreencustomizer_settings_link', 10, 2 );

// Localization
function simpleloginscreencustomizer_plugin_setup() {
    load_plugin_textdomain('simpleloginscreencustomizer_plugin_display_options', false, dirname(plugin_basename(__FILE__)) . '/languages/');
} // end custom_theme_setup
add_action('after_setup_theme', 'simpleloginscreencustomizer_plugin_setup');


?>
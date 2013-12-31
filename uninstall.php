<?php
/**
 * Fired when the plugin is uninstalled.
 *
 * @package   Simple_Login_Screen_Customizer
 * @author    Allison Levine (firewatch)
 * @license   GPL-2.0+
 * @link      https://github.com/allilevine/Simple-Login-Screen-Customizer
 * @copyright 2013 Allison Levine
 */

// If uninstall, not called from WordPress, then exit
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

delete_option('simpleloginscreencustomizer_plugin_display_options');
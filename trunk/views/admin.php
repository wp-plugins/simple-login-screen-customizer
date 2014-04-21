<?php
/**
 * Represents the view for the administration dashboard.
 *
 * This includes the header, options, and other information that should provide
 * The User Interface to the end user.
 *
 * @package   Simple_Login_Screen_Customizer
 * @author    Allison Levine (firewatch)
 * @license   GPL-2.0+
 * @link      https://github.com/allilevine/Simple-Login-Screen-Customizer
 * @copyright 2013 Allison Levine
 */
?>

<div class="wrap">

	<?php screen_icon(); ?>
	<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
		
		<?php settings_errors( 'simpleloginscreencustomizer-settings-errors' ); ?>
		
		<form id="form-simpleloginscreencustomizer-options" method="post" action="options.php" enctype="multipart/form-data">
			<?php 
				settings_fields( 'simpleloginscreencustomizer_plugin_display_options' );
				do_settings_sections( 'simpleloginscreencustomizer_plugin_display_options' );
			?>
			<p class="submit">
				<input name="simpleloginscreencustomizer_plugin_display_options[submit]" id="submit_options_form" type="submit" class="button-primary" value="<?php esc_attr_e('Save Settings', 'simpleloginscreencustomizer_plugin_display_options'); ?>" />
				<input name="simpleloginscreencustomizer_plugin_display_options[reset]" type="submit" class="button-secondary" value="<?php esc_attr_e('Reset to Defaults', 'simpleloginscreencustomizer_plugin_display_options'); ?>" />
			</p>
		</form>

</div>

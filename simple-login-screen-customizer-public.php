<?php
/**
 * Simple Login Screen Customizer
 *
 * @package   Simple_Login_Screen_Customizer
 * @author    Allison Levine (firewatch)
 * @license   GPL-2.0+
 * @link      https://github.com/allilevine/Simple-Login-Screen-Customizer
 * @copyright 2013 Allison Levine
 */

// Style the login page
function simpleloginscreencustomizer_style_screen() { 
	$display_options = get_option( 'simpleloginscreencustomizer_plugin_display_options' );
	
	/* Define Logo URL and size */
	$logodisplay = simpleloginscreencustomizer_display_logo($display_options);
	$logoURL = $logodisplay[0];
	$logoWidth = $logodisplay[1];
	$logoHeight = $logodisplay[2];
	
	/* Calculate link colors */
	$linkColor = sanitize_text_field( $display_options['link_color'] );
	$rolloverColor = sanitize_text_field( $display_options['rollover_color'] );
	$darklinkColor = simpleloginscreencustomizer_change_color($linkColor, 50);
	if ($rolloverColor != null) {
		$newrolloverColor = $rolloverColor;
	} else {
		$newrolloverColor = $darklinkColor;
	}
	
	/* Calculate button colors */
	$buttonColor = sanitize_text_field( $display_options['button_color'] );
	if ($buttonColor != null) {
		$newbuttonColor = $buttonColor;
	} else {
		$newbuttonColor = $linkColor;
	}
	$darkColor50 = simpleloginscreencustomizer_change_color($newbuttonColor, 50);
	$darkColor15 = simpleloginscreencustomizer_change_color($newbuttonColor, 15);
	?>
	<style type="text/css">
		.login #login h1 a {
			background-image: url( <?php echo $logoURL; ?> );
			background-size: <?php echo $logoWidth . 'px'; ?> auto;
			height: <?php echo $logoHeight . 'px'; ?>;
			width: <?php echo $logoWidth . 'px'; ?>;
		}
		.login #nav a, .login #backtoblog a {
			color: <?php echo $linkColor . ' !important'; ?>;
		}
		.login #nav a:hover, .login #backtoblog a:hover {
			color: <?php echo $newrolloverColor . ' !important'; ?>;
		}
		.login .button-primary {
			background: <?php echo $newbuttonColor; ?>;
			border-color: <?php echo $darkColor50; ?>;
		}
		.login .button-primary.hover,
		.login .button-primary:hover,
		.login .button-primary.focus,
		.login .button-primary:focus  {
			background:  <?php echo $darkColor15; ?>;
			border-color: <?php echo $darkColor50; ?>;
		}
	</style>
	
<?php
	}
	add_action( 'login_enqueue_scripts', 'simpleloginscreencustomizer_style_screen' );
	
	// Change the logo URL to be the URL of the WordPress site
	function the_url( $url ) {
	    return get_bloginfo( 'url' );
	}
	add_filter( 'login_headerurl', 'the_url' );
?>
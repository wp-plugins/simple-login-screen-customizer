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

// Get defaults
function simpleloginscreencustomizer_get_default_options() {
	$defaultoptions = array(
		'logo' => site_url( '/wp-admin/images/wordpress-logo.svg' ),
		'link_color' => '#999999',
		'rollover_color' => '',
		'button_color' => ''
);
	return $defaultoptions;
} // end simpleloginscreencustomizer_get_default_options

// If options not defined, replace with default options
function simpleloginscreencustomizer_check_for_defaults() {
	$simpleloginscreencustomizer_options = get_option( 'simpleloginscreencustomizer_plugin_display_options' );
	
	// Are our options saved in the DB?
	if ( false === $simpleloginscreencustomizer_options ) {
		// If not, save our default options
		$simpleloginscreencustomizer_options = simpleloginscreencustomizer_get_default_options();
		add_option( 'simpleloginscreencustomizer_plugin_display_options', $simpleloginscreencustomizer_options );
	} // end if
	
} // end simpleloginscreencustomizer_check_for_defaults
add_action( 'admin_init', 'simpleloginscreencustomizer_check_for_defaults' );

// Add menu page for plugin
function simpleloginscreencustomizer_plugin_menu() {
	
	add_options_page(
		__('Simple Login Screen Customizer', 'simpleloginscreencustomizer_plugin_display_options'),
		__('Login Screen', 'simpleloginscreencustomizer_plugin_display_options'),
		'administrator',
		'simpleloginscreencustomizer_plugin_options',
		'simpleloginscreencustomizer_plugin_display'
	);
	
} // end simpleloginscreencustomizer_plugin_menu
add_action('admin_menu', 'simpleloginscreencustomizer_plugin_menu');

// Define content of the plugin page
function simpleloginscreencustomizer_plugin_display() {
	include_once( 'views/admin.php' );
} // end simpleloginscreencustomizer_plugin_display

// Add settings to the plugin page
function simpleloginscreencustomizer_initialize_plugin_options() {
	
	// Verify options exist
	if ( false == get_option( 'simpleloginscreencustomizer_plugin_display_options' )) {
		add_option( 'simpleloginscreencustomizer_plugin_display_options' );
	} // end if
	
	add_settings_section(
		'login_settings_section',
		__('Login Screen Settings', 'simpleloginscreencustomizer_plugin_display_options'),
		'simpleloginscreencustomizer_screen_options_callback',
		'simpleloginscreencustomizer_plugin_display_options'
	);
	
	add_settings_field(
		'simpleloginscreencustomizer_logo',
		__('Login Logo', 'simpleloginscreencustomizer_plugin_display_options'),
		'simpleloginscreencustomizer_logo_callback',
		'simpleloginscreencustomizer_plugin_display_options',
		'login_settings_section'
	);
	
	add_settings_field(
		'simpleloginscreencustomizer_logo_preview',
		__('Login Logo Preview', 'simpleloginscreencustomizer_plugin_display_options'),
		'simpleloginscreencustomizer_logo_preview_callback',
		'simpleloginscreencustomizer_plugin_display_options',
		'login_settings_section'
	);
	
	add_settings_field(
		'simpleloginscreencustomizer_link_color',
		__('Login Link Color', 'simpleloginscreencustomizer_plugin_display_options'),
		'simpleloginscreencustomizer_link_color_callback',
		'simpleloginscreencustomizer_plugin_display_options',
		'login_settings_section'
	);
	
	add_settings_field(
		'simpleloginscreencustomizer_rollover_color',
		__('Link Rollover Color', 'simpleloginscreencustomizer_plugin_display_options'),
		'simpleloginscreencustomizer_rollover_color_callback',
		'simpleloginscreencustomizer_plugin_display_options',
		'login_settings_section'
	);
	
	add_settings_field(
		'simpleloginscreencustomizer_button_color',
		__('Login Button Color', 'simpleloginscreencustomizer_plugin_display_options'),
		'simpleloginscreencustomizer_button_color_callback',
		'simpleloginscreencustomizer_plugin_display_options',
		'login_settings_section'
	);
	
	register_setting(
		'simpleloginscreencustomizer_plugin_display_options',
		'simpleloginscreencustomizer_plugin_display_options',
		'simpleloginscreencustomizer_plugin_validate_input'
	);
	
} // end simpleloginscreencustomizer_initialize_plugin_options
add_action('admin_init', 'simpleloginscreencustomizer_initialize_plugin_options');

// Define the settings page intro text
function simpleloginscreencustomizer_screen_options_callback() {
	echo '<p>' . _e('Choose a link color and logo for the login screen.  You can also choose rollover and button colors if you\'d like.  Otherwise they will default to shades of the link color.') . '</p>';
}

// Define the logo upload field
function simpleloginscreencustomizer_logo_callback() {
	$options = get_option('simpleloginscreencustomizer_plugin_display_options');
	?>
	<input type="hidden" id="logo_url" name="simpleloginscreencustomizer_plugin_display_options[logo]" value="<?php echo esc_url( $options['logo'] ); ?>" />
	<input id="upload_logo_button" type="button" class="button" value="<?php _e('Choose Logo', 'simpleloginscreencustomizer'); ?>" />
	<span class="description"><?php _e(' Upload or choose an image to be the logo on your login page.', 'simpleloginscreencustomizer_plugin_display_options' ); ?></span>
		<?php 
}

// Define Logo Display
function simpleloginscreencustomizer_display_logo($options) {
	$logoURL = sanitize_text_field( $options['logo'] );
	$logosize = simpleloginscreencustomizer_get_image_size($logoURL);
	$logoWidth = $logosize["width"];
	$logoHeight = $logosize["height"];
	
	$logodisplay = array($logoURL, $logoWidth, $logoHeight);
	return $logodisplay;
} // end simpleloginscreencustomizer_display_logo

// Define the logo preview field
function simpleloginscreencustomizer_logo_preview_callback() {
	$options = get_option('simpleloginscreencustomizer_plugin_display_options');
	$logodisplay = simpleloginscreencustomizer_display_logo($options);
	echo '<div id="upload_logo_preview" style="height:' . $logodisplay[2] . 'px;"><img style="width:' . $logodisplay[1] . 'px;" src="' . $logodisplay[0] . '" /></div>';
} // end simpleloginscreencustomizer_logo_preview_callback

// Define the link color field
function simpleloginscreencustomizer_link_color_callback() {
	$options = get_option('simpleloginscreencustomizer_plugin_display_options');
	
	echo '<input type="text" id="link_color" class="wp-color-picker-field" name="simpleloginscreencustomizer_plugin_display_options[link_color]" value="' . esc_attr($options[ 'link_color' ]) . '" data-default-color="#21759b" />';
} // end simpleloginscreencustomizer_link_color_callback

// Define the rollover color field
function simpleloginscreencustomizer_rollover_color_callback() {
	$options = get_option('simpleloginscreencustomizer_plugin_display_options');
	
	echo '<input type="text" id="rollover_color" class="wp-color-picker-field" name="simpleloginscreencustomizer_plugin_display_options[rollover_color]" value="' . esc_attr($options[ 'rollover_color']) . '" data-default-color="" />';
	?><span class="description"><?php _e(' Defaults to a darker shade of the link color.', 'simpleloginscreencustomizer_plugin_display_options' ); ?></span><?php
} // end simpleloginscreencustomizer_rollover_color_callback

// Define the button color field
function simpleloginscreencustomizer_button_color_callback() {
	$options = get_option('simpleloginscreencustomizer_plugin_display_options');
	
	echo '<input type="text" id="button_color" class="wp-color-picker-field" name="simpleloginscreencustomizer_plugin_display_options[button_color]" value="' . esc_attr($options[ 'button_color']) . '" data-default-color="" />';
	?><span class="description"><?php _e(' Defaults to a button version of the link color.  Button text is white.', 'simpleloginscreencustomizer_plugin_display_options' ); ?></span><?php
} // end simpleloginscreencustomizer_button_color_callback

// Data validation with submit, reset functions
function simpleloginscreencustomizer_plugin_validate_input( $input ) {
	$default_options = simpleloginscreencustomizer_get_default_options();
	$valid_input = $default_options;
	$options = get_option('simpleloginscreencustomizer_plugin_display_options');
	
	$submit = ! empty($input['submit']) ? true : false;
	$reset = ! empty($input['reset']) ? true : false;
	
	if ( $submit ) {
		$valid_input['logo'] = $input['logo'];
		$valid_input['link_color'] = $input['link_color'];
		$valid_input['rollover_color'] = $input['rollover_color'];
		$valid_input['button_color'] = $input['button_color'];
	}
	elseif ( $reset ) {
		$valid_input['logo'] = $default_options['logo'];
		$valid_input['link_color'] = $default_options['link_color'];
		$valid_input['rollover_color'] = $default_options['rollover_color'];
		$valid_input['button_color'] = $default_options['button_color'];
	}
	
	// Create our array for storing the validated options
	$output = array();

	// Loop through each of the incoming options
	foreach( $valid_input as $key => $value ) {
		// Check to see if the current option has a value.  If so, process it.
		if( isset( $valid_input[$key] ) ) {
			// Strip away all HTML and PHP tags and properly handle quoted strings
			$output[$key] = strip_tags( stripslashes( $valid_input[ $key ] ) );
		} // end if
	} // end foreach

	// Return the array processing any additional functions filtered by this action
	return apply_filters( 'simpleloginscreencustomizer_plugin_validate_input', $output, $valid_input );
	
} // end simpleloginscreencustomizer_plugin_validate_input

// Load Scripts
function simpleloginscreencustomizer_enqueue_scripts() {
	wp_register_script( 'simpleloginscreencustomizer-upload', plugins_url( 'js/simple-login-screen-customizer-upload.js', __FILE__ ), array('jquery','media-upload','thickbox') );
	
	wp_register_script( 'simpleloginscreencustomizer-colorpicker', plugins_url( 'js/simple-login-screen-customizer-colorpicker.js', __FILE__ ), array('wp-color-picker'), false, true );
	
	$screen = get_current_screen();
	if ( 'settings_page_simpleloginscreencustomizer_plugin_options' == $screen->id ) {
		wp_enqueue_script('jquery');
		
		wp_enqueue_script('thickbox');
		wp_enqueue_style('thickbox');
		
		wp_enqueue_script('media-upload');
		wp_enqueue_media();
		wp_enqueue_script('simpleloginscreencustomizer-upload');
		
		wp_enqueue_style('wp-color-picker');
		wp_enqueue_script(
		            'iris',
		            admin_url( 'js/iris.min.js' ),
		            array( 'jquery-ui-draggable', 'jquery-ui-slider', 'jquery-touch-punch' ),
		            false,
		            1
		        );
		wp_enqueue_script('simpleloginscreencustomizer-colorpicker');
		
	} // end if
} // end simpleloginscreencustomizer_enqueue_scripts
add_action('admin_enqueue_scripts', 'simpleloginscreencustomizer_enqueue_scripts');

// Unset Thickbox Size Fields to prevent any size but Full
function simpleloginscreencustomizer_unset_thickbox_fields($form_fields, $post){
    unset(
        $form_fields['image-size']
    );

    //create the size input for full only and set display to none
    $size = 'full';
    $css_id = "image-size-{$size}-{$post->ID}";
    $html = "<div style='display: none;' class='image-size-item'><input type='radio' name='attachments[$post->ID][image-size]' id='{$css_id}' value='{$size}'checked='checked' /></div>";
    //set as image-size field
    $form_fields['image-size'] = array(
        'label' => '', //leave with no label
        'input' => 'html', //input type is html
        'html' => $html //the actual html
    ); 

    return $form_fields;
} // simpleloginscreencustomizer_unset_thickbox_fields

// Apply the unset to the plugin page
function simpleloginscreencustomizer_add_thickbox_filter(){
	$referer = strpos( wp_get_referer(), 'simpleloginscreencustomizer_plugin_options' );
	if ( $referer != '' ) {
    	add_filter('attachment_fields_to_edit', 'simpleloginscreencustomizer_unset_thickbox_fields', 10, 2);
	} // end if
}
add_action( 'admin_init', 'simpleloginscreencustomizer_add_thickbox_filter' );

// Change colors (From http://www.jonasjohn.de/snippets/php/darker-color.htm)
function simpleloginscreencustomizer_change_color($color, $diff=20) {
	
	$color = str_replace('#', '', $color);
	if (strlen($color) != 6) {
		return '000000';
	}
	$rgb = '';
 
    for ($x=0;$x<3;$x++) {
    	$c = hexdec(substr($color,(2*$x),2)) - $diff;
		$c = ($c < 0) ? 0 : dechex($c);
		$rgb .= (strlen($c) < 2) ? '0'.$c : $c;
    }
	
	return '#' . $rgb;
  
} // end simpleloginscreencustomizer_change_color

// Get the logo size and resize if too large for login screen
function simpleloginscreencustomizer_get_image_size( $image_url ) {
	global $wpdb;
	// We need to get the image's meta ID
	$table_name = $wpdb->prefix . 'posts';
	$query = "SELECT ID FROM " . $table_name . " where guid = '" . esc_url($image_url) . "' AND post_type = 'attachment'";
	$results = $wpdb->get_results($query);
	
	// Get the image width and height
	foreach ( $results as $row ) {
		$imagedata = wp_get_attachment_metadata( $row->ID );
		$imagewidth = $imagedata['width'];
		$imageheight = $imagedata['height'];
		// Calculate the height : width ratio
		$imageratio = $imageheight / $imagewidth;
		// If the image is wider than 320px, set the width to 320px and calculate the height using the height : width ratio
		if ($imagewidth > 320) {
			$newimagewidth = 320;
			$newimageheight = $newimagewidth * $imageratio;
			// Otherwise use the original width and height
		} else {
			$newimagewidth = $imagewidth;
			$newimageheight = $imageheight;
		}
		// Return array of width and height of image
		$imagesize = array("width" => $newimagewidth, "height" => $newimageheight);
		return $imagesize;
	} // end foreach
	
} // end simpleloginscreencustomizer_get_image_size

?>
jQuery(document).ready(function($) {
	$('#upload_logo_button').click(function() {
		tb_show('Upload a logo', 'media-upload.php?referer=simpleloginscreencustomizer_plugin_options&type=image&TB_iframe=true&post_id=0', false);
		return false;
	});
	
	window.send_to_editor = function(html) {
		var image_url = $('img',html).attr('src');
		$('#logo_url').val(image_url);
		tb_remove();
		$('#upload_logo_preview img').attr('src',image_url);
		$('#submit_options_form').trigger('click');
	}
});
jQuery(document).ready(function($) {
	
	var custom_uploader;
	
	$('#upload_logo_button').click(function(e) {
		e.preventDefault();
 
		        //If the uploader object has already been created, reopen the dialog
		        if (custom_uploader) {
		            custom_uploader.open();
		            return;
		        }
 
		        //Extend the wp.media object
		        custom_uploader = wp.media.frames.file_frame = wp.media({
		            title: 'Choose a Logo',
		            button: {
		                text: 'Choose Logo'
		            },
					library: { // remove these to show all
                		type: 'image' // specific mime
            		},
					default_tab: 'upload', // Just added for example
		            multiple: false
		        });
				
				//When a file is selected, grab the URL and set it as the text field's value
				custom_uploader.on('select', function() {
				    attachment = custom_uploader.state().get('selection').first().toJSON();
				    $('#logo_url').val(attachment.url);
					$('#upload_logo_preview img').attr('src',attachment.url);
					$('#submit_options_form').trigger('click');
				});
 
		        //Open the uploader dialog
		        custom_uploader.open();
	});
});
// import custom CSS styles
import './index.scss';

// plugin localization functions
import { __ } from '@wordpress/i18n';

(function($){

	// add custom markup to the Insert Link dialog in the TinyMCE (Classic) editor
	$(document).on( 'wplink-open', function( wrap ) {

		const title = __('Or choose existing media file', 'classic-editor-media-link'),
		subTitle = __('Media file', 'classic-editor-media-link'),
		buttonTitle = __('Choose', 'classic-editor-media-link');

		if( $('#media-link-to-media-btn').length < 1 ) {
			$( `<div id="wp-link-media-field">
						<p>${title}</p>
					<div>
						<label>
							<span>${subTitle}:</span>
						</label>
						<button class="button" id="media-link-to-media-btn">${buttonTitle}</button>
					</div>`).insertAfter( $('#link-options') );
		}
	
	});

	let image_frame;

	// handle newly added "choose media" button
	$(document).on( 'click', '#media-link-to-media-btn', function( e ) {
		e.preventDefault();

		if( ! image_frame ){
			image_frame = wp.media({
				title: __('Select Media', 'classic-editor-media-link'),
				multiple : false
			}).on( 'select', function() {
				const attachment = image_frame.state().get('selection').first().toJSON();
				$('#wp-link-url').val( attachment.url );
			});
		}

		image_frame.open();

	});

})( window.jQuery );
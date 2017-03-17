/**
 * Function for adding a class to external links
 * so they can be styled.
 */

(function ($) {

	$(document).ready(function() {

		$('a:not(:has(img)').filter(function() {
			return this.hostname && this.hostname !== location.hostname;
		}).addClass('external');
	});

})(jQuery);

(function ($) {
  "use strict";

  /**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

})(jQuery);

function flexi_download_file(id) {
  alert(id);
  window.location.href = id;
}

//Add parameter to URL
function flexi_updateUrl(url, key, value) {
	if (value !== undefined) {
		value = encodeURI(value);
	}
	var hashIndex = url.indexOf("#") | 0;
	if (hashIndex === -1) hashIndex = url.length | 0;
	var urls = url.substring(0, hashIndex).split('?');
	var baseUrl = urls[0];
	var parameters = '';
	var outPara = {};
	if (urls.length > 1) {
		parameters = urls[1];
	}
	if (parameters !== '') {
		parameters = parameters.split('&');
		for (k in parameters) {
			var keyVal = parameters[k];
			keyVal = keyVal.split('=');
			var ekey = keyVal[0];
			var evalue = '';
			if (keyVal.length > 1) {
				evalue = keyVal[1];
			}
			outPara[ekey] = evalue;
		}
	}

	if (value !== undefined) {
		outPara[key] = value;
	} else {
		delete outPara[key];
	}
	parameters = [];
	for (var k in outPara) {
		parameters.push(k + '=' + outPara[k]);
	}

	var finalUrl = baseUrl;

	if (parameters.length > 0) {
		finalUrl += '?' + parameters.join('&');
	}

	return finalUrl + url.substring(hashIndex);
}


jQuery(document).ready(function() {
	jQuery("#flexi_search").click(function(e) {

		var search_value = jQuery("#search_value").val();
		var cur_url = window.location.href;
		var i = flexi_updateUrl(cur_url, 'search', 'keyword:'+search_value);
		window.location.replace(i);
	});
});

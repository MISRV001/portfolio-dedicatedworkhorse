$(window).ready(function() {
/* ************************************************************** */
/*                    super duper fancy box                       */
/* ************************************************************** */

// Read a page's GET URL variables and return them as an associative array.						//
function getUrlVars() {																			//
	var vars = [], hash;																		//
	var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');	//
	for(var i = 0; i < hashes.length; i++)     {												//
		hash = hashes[i].split('=');															//
		vars.push(hash[0]);																		//
		vars[hash[0]] = hash[1];																//
	}																							//
	return vars;																				//
}																								//
																								//
// Getting URL var by its nam																	//
var pageMode = getUrlVars()["mode"];															//

if (pageMode == "edit"){
	var pageModeWidth = 450;
	var pageModeHeight = 700;
} else {
	var pageModeWidth = 650;
	var pageModeHeight = 2250;
}

$("a.iframe").fancybox({
		'hideOnContentClick': false,
		'hideOnOverlayClick': false,
		'autoDimensions': false,
		'autoScale': false,
		'scrolling': 'no',
		'width': pageModeWidth,
		'height': pageModeHeight,
		'type'	 : 'iframe',
		'onClosed': function() {
		if ($('#prntMsgNotification', window.parent.document).html()!="") { 
			$("#editcolDelete", window.parent.document).val("0");
			$("#editcolUpdateFlag", window.parent.document).val("");
			$('#prntMsgNotification', window.parent.document).html("");
			$("#msgNotification", window.parent.document).html("");

			parent.location.reload(true); $('#prntMsgNotification', window.parent.document).html("");
		}
	}
});


});
















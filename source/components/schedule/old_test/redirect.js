$(document).ready(function() {
	// function to grab the url variables
	function getUrlVars() {
		var vars = [], hash;
		var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
		for(var i = 0; i < hashes.length; i++) {
			hash = hashes[i].split('=');
			vars.push(hash[0]);
			vars[hash[0]] = hash[1];
		}
		return vars;
	}
	
	// Getting URL var by its name
	var action2Perform = getUrlVars()["mode"];
	
	// detect the browser
	if ($.browser.msie) {		// if IE
		// check to see if it is edit or view
		if (action2Perform == "edit") {
			window.location.href = "http://10.10.0.5/quoteprocess/johnTest/schedule/schedule2.php?userID=11";
		} else if (action2Perform == "view") {
			window.location.href = "http://10.10.0.5/quoteprocess/johnTest/schedule/schedule1.php?userID=11";
		} else {
			window.location.href = "http://10.10.0.5/dashboard.php";
		}
	} else {		// if NOT ie
		// check to see if it is edit or view
		if (action2Perform == "edit") {
			window.location.href = "http://10.10.0.5/quoteprocess/johnTest/schedule/schedule3.php?userID=11";
		} else if (action2Perform == "view") {
			window.location.href = "http://10.10.0.5/quoteprocess/johnTest/schedule/schedule4.php?userID=11";
		} else {
			window.location.href = "http://10.10.0.5/dashboard.php";
		}
	}
});
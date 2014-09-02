$(document).ready(function() {
/* ************************************************************** */
/*                    Accordian functionality                     */
/* ************************************************************** */
	//set up variables
	var windowWidth = 0;		//sets a blanket value to the windowWidth variable
	var electricalOpen = 0;		//'0' equals false because the content is closed
	var pipefittingOpen = 0;	//'0' equals false because the content is closed
	var paintersOpen = 0;		//'0' equals false because the content is closed
	var carpentryOpen = 0;		//'0' equals false because the content is closed
	var mobOpen = 0;			//'0' equals false because the content is closed
	var foundationsOpen = 0;	//'0' equals false because the content is closed
	var riggingsOpen = 0;		//'0' equals false because the content is closed
	var shopOpen = 0;			//'0' equals false because the content is closed
	var hvacOpen = 0;			//'0' equals false because the content is closed
	var windowWidth = 0;		//just declaring the variable
	
	/* SIMULATE USER LOG IN */																		//
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
	var userID = getUrlVars()["userID"];															//
	if ( userID == 11 || userID == 14 || userID == 15 || userID == 47) {							//
		electricalOpen = 1;																			//
	} else if ( userID == 16 || userID == 17 || userID == 18 ) {									//
		foundationsOpen = 1;																		//
	} else if ( userID == 21 || userID == 20 || userID == 19 ) {									//
		carpentryOpen = 1;																			//
	} else if ( userID == 22 || userID == 23 || userID == 24 ) {									//
		pipefittingOpen = 1;																		//
	} else if ( userID == 25 || userID == 26 || userID == 27 ) {									//
		riggingsOpen = 1;																			//
	} else if ( userID == 29 || userID == 30 ) {													//
		hvacOpen = 1;																				//
	} else if ( userID == 31 || userID == 32 || userID == 33 ) {									//
		paintersOpen = 1;																			//
	} else if ( userID == 34 || userID == 35 ) {													//
		mobOpen = 1;																				//
	} else if ( userID == 39 || userID == 40 ) {													//
		shopOpen = 1;																				//
	} else if ( userID == 13 ) {																	//
		shopOpen = 1;																				//
		hvacOpen = 1;																				//
		electricalOpen = 1;																			//
	}																								//
	/* END SIMULATE USER LOG IN */																	//
	
	//assign the width of each content area
	var electricalWidth = $('#electricalContent').width();				
	var pipefittingWidth = $('#pipefittingContent').width();
	var paintersWidth = $('#paintersContent').width();
	var carpentryWidth = $('#carpentryContent').width();
	var mobWidth = $('#mobContent').width();
	var foundationsWidth = $('#foundationsContent').width();
	var riggingsWidth = $('#riggingsContent').width();
	var shopWidth = $('#shopContent').width();
	var hvacWidth = $('#hvacContent').width();			
	var contentWidth = 0;		//total conent width
	
	//assign the width the menu bars and a 63 pixel spacer (7px per menu bar) and a 2250 pixel spacer (125px per departments block [2 blocks per department])
	var menuBarWidth = $('#electricalBar').width() + $('#pipefittingBar').width() + $('#paintersBar').width() + $('#carpentryBar').width() + $('#mobBar').width() + $('#foundationsBar').width() + $('#riggingsBar').width() + $('#shopBar').width() + $('#hvacBar').width() + 2313;
	
	//set up page
	if (electricalOpen == 0) {$("#electricalContent").hide();$(".eleTopBar").hide();}else{contentWidth = contentWidth + $("#electricalContent").width();}
	if (pipefittingOpen == 0) {$("#pipefittingContent").hide();$(".pipTopBar").hide();}else{contentWidth = contentWidth + $("#pipfittingContent").width();}
	if (paintersOpen == 0) {$("#paintersContent").hide();$(".paiTopBar").hide();}else{contentWidth = contentWidth + $("#paintersContent").width();}
	if (carpentryOpen == 0) {$("#carpentryContent").hide();$(".carTopBar").hide();}else{contentWidth = contentWidth + $("#carpentryContent").width();}
	if (mobOpen == 0) {$("#mobContent").hide();$(".mobTopBar").hide();}else{contentWidth = contentWidth + $("#mobContent").width();}
	if (foundationsOpen == 0) {$("#foundationsContent").hide();$(".fouTopBar").hide();}else{contentWidth = contentWidth + $("#foundationsContent").width();}
	if (riggingsOpen == 0) {$("#riggingsContent").hide();$(".rigTopBar").hide();}else{contentWidth = contentWidth + $("#riggingsContent").width();}
	if (shopOpen == 0) {$("#shopContent").hide();$(".shoTopBar").hide();}else{contentWidth = contentWidth + $("#shopContent").width();}
	if (hvacOpen == 0) {$("#hvacContent").hide();$(".hvaTopBar").hide();}else{contentWidth = contentWidth + $("#hvacContent").width();}

	windowWidth = contentWidth + menuBarWidth;
	$("#accWrapper").css( "width",windowWidth );
	$(".topBar").css( "width",windowWidth );

	//click functionality for a menu item
	$("#electricalBar").click(function() {
		if (electricalOpen == 0) {
			windowWidth = windowWidth + electricalWidth;		//math for the window's width
			$("#accWrapper").css( "width",windowWidth );			//expand the window
			$(".topBar").css( "width",windowWidth );			//expand the topBar
			$(".eleTopBar")	.animate({width: 'toggle'});
			$("#electricalContent").animate({width: "toggle"}, 600);		//show the content
			electricalOpen = 1;
		} else {
			windowWidth = windowWidth - electricalWidth;		//math for the window's width
			$("#electricalContent").animate({width: "toggle"}, 500, function() {
				$("#accWrapper").css( "width",windowWidth );			//shrink the window
			});
			$(".eleTopBar")	.animate({width: 'toggle'}, 500, function() {
				$(".topBar").css( "width",windowWidth );			//shrink the topBar
			});
			electricalOpen = 0;
		}
	});
	
	//click functionality for a menu item
	$("#pipefittingBar").click(function() {
		if (pipefittingOpen == 0) {
			windowWidth = windowWidth + pipefittingWidth;		//math for the window's width
			$("#accWrapper").css( "width",windowWidth );			//expand the window
			$(".topBar").css( "width",windowWidth );			//expand the topBar
			$("#pipefittingContent").animate({width: "toggle"});		//show the content
			$(".pipTopBar").animate({width: "toggle"});		//show the content
			pipefittingOpen = 1;
		} else {
			windowWidth = windowWidth - pipefittingWidth;		//math for the window's width
			$("#pipefittingContent").animate({width: "toggle"}, 500, function() {
				$("#accWrapper").css( "width",windowWidth );			//shrink the window
			});
			$(".pipTopBar")	.animate({width: 'toggle'}, 500, function() {
				$(".topBar").css( "width",windowWidth );			//shrink the topBar
			});
			pipefittingOpen = 0;
		}
	});

	//click functionality for a menu item
	$("#hvacBar").click(function() {
		if (hvacOpen == 0) {
			windowWidth = windowWidth + hvacWidth;		//math for the window's width
			$("#accWrapper").css( "width",windowWidth );			//expand the window
			$(".topBar").css( "width",windowWidth );			//expand the topBar
			$("#hvacContent").animate({width: "toggle"});		//show the content
			$(".hvaTopBar").animate({width: "toggle"});		//show the content
			hvacOpen = 1;
		} else {
			windowWidth = windowWidth - hvacWidth;		//math for the window's width
			$("#hvacContent").animate({width: "toggle"}, 500, function() {
				$("#accWrapper").css( "width",windowWidth );			//shrink the window
			});
			$(".hvaTopBar")	.animate({width: 'toggle'}, 500, function() {
				$(".topBar").css( "width",windowWidth );			//shrink the topBar
			});
			hvacOpen = 0;
		}
	});

	//click functionality for a menu item
	$("#paintersBar").click(function() {
		if (paintersOpen == 0) {
			windowWidth = windowWidth + paintersWidth;		//math for the window's width
			$("#accWrapper").css( "width",windowWidth );			//expand the window
			$(".topBar").css( "width",windowWidth );			//expand the topBar
			$("#paintersContent").animate({width: "toggle"});		//show the content
			$(".paiTopBar").animate({width: "toggle"});		//show the content
			paintersOpen = 1;
		} else {
			windowWidth = windowWidth - paintersWidth;		//math for the window's width
			$("#paintersContent").animate({width: "toggle"}, 500, function() {
				$("#accWrapper").css( "width",windowWidth );			//shrink the window
			});
			$(".paiTopBar")	.animate({width: 'toggle'}, 500, function() {
				$(".topBar").css( "width",windowWidth );			//shrink the topBar
			});
			paintersOpen = 0;
		}
	});

	//click functionality for a menu item
	$("#carpentryBar").click(function() {
		if (carpentryOpen == 0) {
			windowWidth = windowWidth + carpentryWidth;		//math for the window's width
			$("#accWrapper").css( "width",windowWidth );			//expand the window
			$(".topBar").css( "width",windowWidth );			//expand the topBar
			$("#carpentryContent").animate({width: "toggle"});		//show the content
			$(".carTopBar").animate({width: "toggle"});		//show the content
			carpentryOpen = 1;
		} else {
			windowWidth = windowWidth - carpentryWidth;		//math for the window's width
			$("#carpentryContent").animate({width: "toggle"}, 500, function() {
				$("#accWrapper").css( "width",windowWidth );			//shrink the window
			});
			$(".carTopBar")	.animate({width: 'toggle'}, 500, function() {
				$(".topBar").css( "width",windowWidth );			//shrink the topBar
			});
			carpentryOpen = 0;
		}
	});

	//click functionality for a menu item
	$("#mobBar").click(function() {
		if (mobOpen == 0) {
			windowWidth = windowWidth + mobWidth;		//math for the window's width
			$("#accWrapper").css( "width",windowWidth );			//expand the window
			$(".topBar").css( "width",windowWidth );			//expand the topBar
			$("#mobContent").animate({width: "toggle"});		//show the content
			$(".mobTopBar").animate({width: "toggle"});		//show the content
			mobOpen = 1;
		} else {
			windowWidth = windowWidth - mobWidth;		//math for the window's width
			$("#mobContent").animate({width: "toggle"}, 500, function() {
				$("#accWrapper").css( "width",windowWidth );			//shrink the window
			});
			$(".mobTopBar")	.animate({width: 'toggle'}, 500, function() {
				$(".topBar").css( "width",windowWidth );			//shrink the topBar
			});
			mobOpen = 0;
		}
	});

	//click functionality for a menu item
	$("#foundationsBar").click(function() {
		if (foundationsOpen == 0) {
			windowWidth = windowWidth + foundationsWidth;		//math for the window's width
			$("#accWrapper").css( "width",windowWidth );			//expand the window
			$(".topBar").css( "width",windowWidth );			//expand the topBar
			$("#foundationsContent").animate({width: "toggle"});		//show the content
			$(".fouTopBar").animate({width: "toggle"});		//show the content
			foundationsOpen = 1;
		} else {
			windowWidth = windowWidth - foundationsWidth;		//math for the window's width
			$("#foundationsContent").animate({width: "toggle"}, 500, function() {
				$("#accWrapper").css( "width",windowWidth );			//shrink the window
			});
			$(".fouTopBar")	.animate({width: 'toggle'}, 500, function() {
				$(".topBar").css( "width",windowWidth );			//shrink the topBar
			});
			foundationsOpen = 0;
		}
	});

	//click functionality for a menu item
	$("#riggingsBar").click(function() {
		if (riggingsOpen == 0) {
			windowWidth = windowWidth + riggingsWidth;		//math for the window's width
			$("#accWrapper").css( "width",windowWidth );			//expand the window
			$(".topBar").css( "width",windowWidth );			//expand the topBar
			$("#riggingsContent").animate({width: "toggle"});		//show the content
			$(".rigTopBar").animate({width: "toggle"});		//show the content
			riggingsOpen = 1;
		} else {
			windowWidth = windowWidth - riggingsWidth;		//math for the window's width
			$("#riggingsContent").animate({width: "toggle"}, 500, function() {
				$("#accWrapper").css( "width",windowWidth );			//shrink the window
			});
			$(".rigTopBar")	.animate({width: 'toggle'}, 500, function() {
				$(".topBar").css( "width",windowWidth );			//shrink the topBar
			});
			riggingsOpen = 0;
		}
	});

	//click functionality for a menu item
	$("#shopBar").click(function() {
		if (shopOpen == 0) {
			windowWidth = windowWidth + shopWidth;		//math for the window's width
			$("#accWrapper").css( "width",windowWidth );			//expand the window
			$(".topBar").css( "width",windowWidth );			//expand the topBar
			$("#shopContent").animate({width: "toggle"});		//show the content
			$(".shoTopBar").animate({width: "toggle"});		//show the content
			shopOpen = 1;
		} else {
			windowWidth = windowWidth - shopWidth;		//math for the window's width
			$("#shopContent").animate({width: "toggle"}, 500, function() {
				$("#accWrapper").css( "width",windowWidth );			//shrink the window
			});
			$(".shoTopBar")	.animate({width: 'toggle'}, 500, function() {
				$(".topBar").css( "width",windowWidth );			//shrink the topBar
			});
			shopOpen = 0;
		}
	});
	
/* ************************************************************** */
/*                       fancyBox handler                         */
/* ************************************************************** */
	$("a.iframe").fancybox({
		'hideOnContentClick': false,
		'hideOnOverlayClick': false,
		'autoDimensions': false,
		'autoScale': false,
		'scrolling': 'no',
		'height': 625
	});
	

});		// END DOC READY FUNCTION

















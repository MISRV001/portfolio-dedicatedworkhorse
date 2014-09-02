$(document).ready(function() {
/* ************************************************************** */
/*                    Accordian functionality                     */
/* ************************************************************** */
	//set up variables
	var electricalOpen = 0;		//'0' equals false because the content is closed
	var pipefittingOpen = 0;	//'0' equals false because the content is closed
	var paintersOpen = 0;		//'0' equals false because the content is closed
	var carpentryOpen = 0;		//'0' equals false because the content is closed
	var mobOpen = 0;			//'0' equals false because the content is closed
	var foundationsOpen = 0;	//'0' equals false because the content is closed
	var riggingsOpen = 0;		//'0' equals false because the content is closed
	var shopOpen = 0;			//'0' equals false because the content is closed
	var hvacOpen = 0;			//'0' equals false because the content is closed
	
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
	
	//set up page
	if (electricalOpen == 0) {$("#electricalContent").hide();$(".eleTopBar").hide();}
	if (pipefittingOpen == 0) {$("#pipefittingContent").hide();$(".pipTopBar").hide();}
	if (paintersOpen == 0) {$("#paintersContent").hide();$(".paiTopBar").hide();}
	if (carpentryOpen == 0) {$("#carpentryContent").hide();$(".carTopBar").hide();}
	if (mobOpen == 0) {$("#mobContent").hide();$(".mobTopBar").hide();}
	if (foundationsOpen == 0) {$("#foundationsContent").hide();$(".fouTopBar").hide();}
	if (riggingsOpen == 0) {$("#riggingsContent").hide();$(".rigTopBar").hide();}
	if (shopOpen == 0) {$("#shopContent").hide();$(".shoTopBar").hide();}
	if (hvacOpen == 0) {$("#hvacContent").hide();$(".hvaTopBar").hide();}
	
	$("#accWrapper").css( "width",'10000' );			//expand the window
	$(".topBar").css( "width",'10000' );			//expand the window

	//click functionality for a menu item
	$("#electricalBar").click(function() {
		if (electricalOpen == 0) {
			$(".eleTopBar").animate({width: 'toggle'});
			$("#electricalContent").animate({width: "toggle"});		//show the content
			electricalOpen = 1;
		} else {
			$("#electricalContent").animate({width: "toggle"}, 500);
			$(".eleTopBar")	.animate({width: 'toggle'}, 500);
			electricalOpen = 0;
		}
	});
	
	//click functionality for a menu item
	$("#pipefittingBar").click(function() {
		if (pipefittingOpen == 0) {
			$("#pipefittingContent").animate({width: "toggle"});		//show the content
			$(".pipTopBar").animate({width: "toggle"});		//show the content
			pipefittingOpen = 1;
		} else {
			$("#pipefittingContent").animate({width: "toggle"}, 500);
			$(".pipTopBar")	.animate({width: 'toggle'}, 500);
			pipefittingOpen = 0;
		}
	});

	//click functionality for a menu item
	$("#hvacBar").click(function() {
		if (hvacOpen == 0) {
			$("#hvacContent").animate({width: "toggle"});		//show the content
			$(".hvaTopBar").animate({width: "toggle"});		//show the content
			hvacOpen = 1;
		} else {
			$("#hvacContent").animate({width: "toggle"}, 500);
			$(".hvaTopBar").animate({width: 'toggle'}, 500);
			hvacOpen = 0;
		}
	});

	//click functionality for a menu item
	$("#paintersBar").click(function() {
		if (paintersOpen == 0) {
			$("#paintersContent").animate({width: "toggle"});		//show the content
			$(".paiTopBar").animate({width: "toggle"});		//show the content
			paintersOpen = 1;
		} else {
			$("#paintersContent").animate({width: "toggle"}, 500);
			$(".paiTopBar").animate({width: 'toggle'}, 500);
			paintersOpen = 0;
		}
	});

	//click functionality for a menu item
	$("#carpentryBar").click(function() {
		if (carpentryOpen == 0) {
			$("#carpentryContent").animate({width: "toggle"});		//show the content
			$(".carTopBar").animate({width: "toggle"});		//show the content
			carpentryOpen = 1;
		} else {
			$("#carpentryContent").animate({width: "toggle"}, 500);
			$(".carTopBar").animate({width: 'toggle'}, 500);
			carpentryOpen = 0;
		}
	});

	//click functionality for a menu item
	$("#mobBar").click(function() {
		if (mobOpen == 0) {
			$("#mobContent").animate({width: "toggle"});		//show the content
			$(".mobTopBar").animate({width: "toggle"});		//show the content
			mobOpen = 1;
		} else {
			$("#mobContent").animate({width: "toggle"}, 500);
			$(".mobTopBar").animate({width: 'toggle'}, 500);
			mobOpen = 0;
		}
	});

	//click functionality for a menu item
	$("#foundationsBar").click(function() {
		if (foundationsOpen == 0) {
			$("#foundationsContent").animate({width: "toggle"});		//show the content
			$(".fouTopBar").animate({width: "toggle"});		//show the content
			foundationsOpen = 1;
		} else {
			$("#foundationsContent").animate({width: "toggle"}, 500);
			$(".fouTopBar").animate({width: 'toggle'}, 500);
			foundationsOpen = 0;
		}
	});

	//click functionality for a menu item
	$("#riggingsBar").click(function() {
		if (riggingsOpen == 0) {
			$("#riggingsContent").animate({width: "toggle"});		//show the content
			$(".rigTopBar").animate({width: "toggle"});		//show the content
			riggingsOpen = 1;
		} else {
			$("#riggingsContent").animate({width: "toggle"}, 500);
			$(".rigTopBar").animate({width: 'toggle'}, 500);
			riggingsOpen = 0;
		}
	});

	//click functionality for a menu item
	$("#shopBar").click(function() {
		if (shopOpen == 0) {
			$("#shopContent").animate({width: "toggle"});		//show the content
			$(".shoTopBar").animate({width: "toggle"});		//show the content
			shopOpen = 1;
		} else {
			$("#shopContent").animate({width: "toggle"}, 500);
			$(".shoTopBar").animate({width: 'toggle'}, 500);
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

/* ************************************************************** */
/*                window scrolling functionality                  */
/* ************************************************************** */
	var sideNav = $('.calendar');
	var sideNavPos = sideNav.offset();
	var topNav = $('.topBar');
	var topNavPos = topNav.offset();
	var didScroll = 0;
	
	$(window).scroll(function() {
		didScroll = true;
			/* create functionality for UP/DOWN scrolling */
            if ($(this).scrollTop() > sideNavPos.top) {
                sideNav.css({
                    'position': 'fixed',
					'overflow': 'auto',
					'text-align': 'center',
					'float': 'left',	
					'z-index': '9999',
                    'left': '0',
					'margin-top' : $(window).scrollTop()-($(window).scrollTop()*2)
				});
            } else {
                sideNav.css({
                    'position': 'fixed',
					'overflow': 'auto',
					'text-align': 'center',
					'float': 'left',	
					'z-index': '9999',
					'margin-left' : '0px',
					'margin-top' : $(window).scrollTop()-($(window).scrollTop()*2)
                });
            }
			
			
			/* create functionality for LEFT/RIGHT scrolling */
            if ($(this).scrollLeft() > topNavPos.left) {
                topNav.css({
                    'position': 'fixed',
					'overflow': 'auto',
					'text-align': 'center',
					'float': 'left',	
					'z-index': '99',
                    'top': '0',
					'margin-left' : $(window).scrollLeft()-($(window).scrollLeft()*2)
				});
            } else {
                topNav.css({
                    'position': 'fixed',
					'overflow': 'auto',
					'text-align': 'center',
					'float': 'left',	
					'z-index': '99',
					'margin-top' : '0px',
					'margin-left' : $(window).scrollLeft()-($(window).scrollLeft()*2)
                });
            }
	});
	
	
    setInterval(function() {
		//alert('apples');
        if (didScroll) {
            didScroll = false;
			/* create functionality for UP/DOWN scrolling */
            if ($(this).scrollTop() > sideNavPos.top) {
                sideNav.css({
                    'position': 'fixed',
					'overflow': 'auto',
					'text-align': 'center',
					'float': 'left',	
					'z-index': '9999',
                    'left': '0',
					'margin-top' : $(window).scrollTop()-($(window).scrollTop()*2)
				});
            } else {
                sideNav.css({
                    'position': 'fixed',
					'overflow': 'auto',
					'text-align': 'center',
					'float': 'left',	
					'z-index': '9999',
					'margin-left' : '0px',
					'margin-top' : $(window).scrollTop()-($(window).scrollTop()*2)
                });
            }
			
			
			/* create functionality for LEFT/RIGHT scrolling */
            if ($(this).scrollLeft() > topNavPos.left) {
                topNav.css({
                    'position': 'fixed',
					'overflow': 'auto',
					'text-align': 'center',
					'float': 'left',	
					'z-index': '99',
                    'top': '0',
					'margin-left' : $(window).scrollLeft()-($(window).scrollLeft()*2)
				});
            } else {
                topNav.css({
                    'position': 'fixed',
					'overflow': 'auto',
					'text-align': 'center',
					'float': 'left',	
					'z-index': '99',
					'margin-top' : '0px',
					'margin-left' : $(window).scrollLeft()-($(window).scrollLeft()*2)
                });
            }

			
		}
	}, 1);


});		// END DOC READY FUNCTION

















$(document).ready(function() {
	// if the window scrolled then we set the variable to true
	$(window).scroll(function() {
		didScroll = true;
	});
	
	// set up the variables
	var sideNav = $('.calendar');
	var sideNavPos = sideNav.offset();
	var topNav = $('.topBar');
	var topNavPos = topNav.offset();
	var didScroll = false;
	
	// we are checking on a timed interval if the window has moved at all
    setInterval(function() {
		// check to see if the window scrolled in either direction
        if (didScroll) {
			// hi Freytag...this resets the variable so it isn't in a loop after you stop scrolling the window
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
	}, 100);
});



/*  FREYTAG RULES!!!  */
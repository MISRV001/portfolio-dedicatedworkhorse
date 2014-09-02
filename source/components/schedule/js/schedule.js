$(document).ready(function() {
/* ************************************************************** */
/*                    Accordian functionality                     */
/* ************************************************************** */
//set up variables
	var windowWidth = 0;			//sets a blanket value to the windowWidth variable
	var electricalOpen = 0;			//'0' equals false because the content is closed
	var foundationsOpen = 0;		//'0' equals false because the content is closed
	var carpentryOpen = 0;			//'0' equals false because the content is closed
	var pipefittingOpen = 0;		//'0' equals false because the content is closed
	var riggingsOpen = 0;			//'0' equals false because the content is closed
	var hvacOpen = 0;				//'0' equals false because the content is closed
	var paintersOpen = 0;			//'0' equals false because the content is closed
	var mobOpen = 0;				//'0' equals false because the content is closed
	var shopOpen = 0;				//'0' equals false because the content is closed
	var activeJobsOpen = 0;			//'0' equals false because the content is closed
	var cookieDate = new Date();	// set up a date for the cookies...
	cookieDate.setTime(cookieDate.getTime() + (12 * 60 * 60 * 1000));	// this sets it up to expire after 12 hours
	
	// check to see if anything was opened before refreshing
	if($.cookie("eleCookie") == 1) {electricalOpen = 1;}
	if($.cookie("fouCookie") == 2) {foundationsOpen = 1;}
	if($.cookie("carCookie") == 3) {carpentryOpen = 1;}
	if($.cookie("pipCookie") == 4) {pipefittingOpen = 1;}
	if($.cookie("rigCookie") == 5) {riggingsOpen = 1;}
	if($.cookie("hvaCookie") == 6) {hvacOpen = 1;}
	if($.cookie("paiCookie") == 7) {paintersOpen = 1;}
	if($.cookie("mobCookie") == 8) {mobOpen = 1;}
	if($.cookie("shoCookie") == 10) {shopOpen = 1;}
	
	// get the user's department(s)
	var userDept1 = $("#usersDept1").val();
	var userDept2 = $("#usersDept2").val();
	var userDept3 = $("#usersDept3").val();
	var userDept4 = $("#usersDept4").val();
	var userDept5 = $("#usersDept5").val();
	var userDept6 = $("#usersDept6").val();
	var userDept7 = $("#usersDept7").val();
	var userDept8 = $("#usersDept8").val();
	var userDept10 = $("#usersDept10").val();
	var userDept12 = $("#usersDept12").val();
	
	// open based on user's department(s)
	if ( userDept1 == 1) { electricalOpen = 1; }
	if ( userDept2 == 2 ) { foundationsOpen = 1; }
	if ( userDept3 == 3 ) { carpentryOpen = 1; }
	if ( userDept4 == 4 ) { pipefittingOpen = 1; }
	if ( userDept5 == 5 ) { riggingsOpen = 1; }
	if ( userDept6 == 6 || userDept12 == 12 ) { hvacOpen = 1; }
	if ( userDept7 == 7 ) { paintersOpen = 1; }
	if ( userDept8 == 8 ) { mobOpen = 1; }
	if ( userDept10 == 10 ) { shopOpen = 1; }
	
	// set up the width of the top bars
	if ($.browser.msie) {		// detect the browser and if IE
		var i = 120;		// this takes into account the width of the 2 blocks at the end and their borders
		$('.eleCountMe').each(function(index) { i = i + $('.eleCountMe').width(); });		// the plus 1 is to take into account the borders
		$(".eleTopBar").css("width", i+"px");
		$('#electricalContent').css("width", i+"px");
		i = 120;		// reset i to the block and border width
		$('.pipCountMe').each(function(index) { i = i + $('.pipCountMe').width(); });
		$(".pipTopBar").css("width", i+"px");
		$('#pipefittingContent').css("width", i+"px");
		i = 120;		// reset i to the block and border width
		$('.paiCountMe').each(function(index) { i = i + $('.paiCountMe').width(); });
		$(".paiTopBar").css("width", i+"px");
		$('#paintersContent').css("width", i+"px");
		i = 120;		// reset i to the block and border width
		$('.carCountMe').each(function(index) { i = i + $('.carCountMe').width(); });
		$(".carTopBar").css("width", i+"px");
		$('#carpentryContent').css("width", i+"px");
		i = 120;		// reset i to the block and border width
		$('.mobCountMe').each(function(index) { i = i + $('.mobCountMe').width(); });
		$(".mobTopBar").css("width", i+"px");
		$('#mobContent').css("width", i+"px");
		i = 120;		// reset i to the block and border width
		$('.fouCountMe').each(function(index) { i = i + $('.fouCountMe').width(); });
		$(".fouTopBar").css("width", i+"px");
		$('#foundationsContent').css("width", i+"px");
		i = 120;		// reset i to the block and border width
		$('.rigCountMe').each(function(index) { i = i + $('.rigCountMe').width(); });
		$(".rigTopBar").css("width", i+"px");
		$('#riggingsContent').css("width", i+"px");
		i = 120;		// reset i to the block and border width
		$('.shoCountMe').each(function(index) { i = i + $('.shoCountMe').width(); });
		$(".shoTopBar").css("width", i+"px");
		$('#shopContent').css("width", i+"px");
		i = 120;		// reset i to the block and border width
		$('.hvaCountMe').each(function(index) { i = i + $('.hvaCountMe').width(); });
		$(".hvaTopBar").css("width", i+"px");
		$('#hvacContent').css("width", i+"px");
		$('.colapsedMenu').css("width", "40px");
		$('.colapsedMenuEnd').css("width", "40px");
		i = 0;
	} else {
		var i = 122;
		$('.eleCountMe').each(function(index) { i = i + $('.eleCountMe').width() + 1; });		// the plus 1 is to take into account the borders
		$(".eleTopBar").css("width", i+"px");
		i = 122;		// reset i to the block and border width
		$('.pipCountMe').each(function(index) { i = i + $('.pipCountMe').width() + 1; });
		$(".pipTopBar").css("width", i+"px");
		i = 122;		// reset i to the block and border width
		$('.paiCountMe').each(function(index) { i = i + $('.paiCountMe').width() + 1; });
		$(".paiTopBar").css("width", i+"px");
		i = 122;		// reset i to the block and border width
		$('.carCountMe').each(function(index) { i = i + $('.carCountMe').width() + 1; });
		$(".carTopBar").css("width", i+"px");
		i = 122;		// reset i to the block and border width
		$('.mobCountMe').each(function(index) { i = i + $('.mobCountMe').width() + 1; });
		$(".mobTopBar").css("width", i+"px");
		i = 122;		// reset i to the block and border width
		$('.fouCountMe').each(function(index) { i = i + $('.fouCountMe').width() + 1; });
		$(".fouTopBar").css("width", i+"px");
		i = 122;		// reset i to the block and border width
		$('.rigCountMe').each(function(index) { i = i + $('.rigCountMe').width() + 1; });
		$(".rigTopBar").css("width", i+"px");
		i = 122;		// reset i to the block and border width
		$('.shoCountMe').each(function(index) { i = i + $('.shoCountMe').width() + 1; });
		$(".shoTopBar").css("width", i+"px");
		i = 122;		// reset i to the block and border width
		$('.hvaCountMe').each(function(index) { i = i + $('.hvaCountMe').width() + 1; });
		$(".hvaTopBar").css("width", i+"px");
		$('.colapsedMenu').css("width", "30px");
		$('.colapsedMenuEnd').css("width", "30px");
		i = 0;
	}
	
	// set the width of the contents to variables
	var electricalWidth = $('#electricalContent').width();			
	var electricalHeight = $('#electricalContent').height();				
	var pipefittingWidth = $('#pipefittingContent').width();
	var paintersWidth = $('#paintersContent').width();
	var carpentryWidth = $('#carpentryContent').width();
	var mobWidth = $('#mobContent').width();
	var foundationsWidth = $('#foundationsContent').width();
	var riggingsWidth = $('#riggingsContent').width();
	var shopWidth = $('#shopContent').width();
	var hvacWidth = $('#hvacContent').width();
	var activeJobsWidth = $('#activeJobsContent').width();			
	var contentWidth = 0;		//total conent width
	
	//assign the width the menu bars and a 63 pixel spacer (7px per menu bar) and a 2250 pixel spacer (125px per departments block [2 blocks per department])
	var menuBarWidth = $('#electricalBar').width() + $('#pipefittingBar').width() + $('#paintersBar').width() + $('#carpentryBar').width() + $('#mobBar').width() + $('#foundationsBar').width() + $('#riggingsBar').width() + $('#shopBar').width() + $('#hvacBar').width() + 2313;
	
	//set up page
	if (electricalOpen == 0) {$("#electricalContent").hide();$(".eleTopBar").hide();$("#electricalContent").css({ opacity: 0.5 });}else{contentWidth = contentWidth + $("#electricalContent").width();}
	if (pipefittingOpen == 0) {$("#pipefittingContent").hide();$(".pipTopBar").hide();$("#pipefittingContent").css({ opacity: 0.5 });}else{contentWidth = contentWidth + $("#pipfittingContent").width();}
	if (paintersOpen == 0) {$("#paintersContent").hide();$(".paiTopBar").hide();$("#paintersContent").css({ opacity: 0.5 });}else{contentWidth = contentWidth + $("#paintersContent").width();}
	if (carpentryOpen == 0) {$("#carpentryContent").hide();$(".carTopBar").hide();$("#carpentryContent").css({ opacity: 0.5 });}else{contentWidth = contentWidth + $("#carpentryContent").width();}
	if (mobOpen == 0) {$("#mobContent").hide();$(".mobTopBar").hide();$("#mobContent").css({ opacity: 0.5 });}else{contentWidth = contentWidth + $("#mobContent").width();}
	if (foundationsOpen == 0) {$("#foundationsContent").hide();$(".fouTopBar").hide();$("#foundationsContent").css({ opacity: 0.5 });}else{contentWidth = contentWidth + $("#foundationsContent").width();}
	if (riggingsOpen == 0) {$("#riggingsContent").hide();$(".rigTopBar").hide();$("#riggingsContent").css({ opacity: 0.5 });}else{contentWidth = contentWidth + $("#riggingsContent").width();}
	if (shopOpen == 0) {$("#shopContent").hide();$(".shoTopBar").hide();$("#shopContent").css({ opacity: 0.5 });}else{contentWidth = contentWidth + $("#shopContent").width();}
	if (hvacOpen == 0) {$("#hvacContent").hide();$(".hvaTopBar").hide();$("#hvacContent").css({ opacity: 0.5 });}else{contentWidth = contentWidth + $("#hvacContent").width();}
	if (activeJobsOpen == 0) {$("#activeJobsContent").hide();$("#activeJobsContent").css({ opacity: 0.5 });}else{contentWidth = contentWidth + $("#activeJobsContent").width();}

	windowWidth = contentWidth + menuBarWidth;		// set up the width of the window
	$('.topBar').css("width",windowWidth+"px");
	$('.topBar').css("height",60);
	var barHeight = electricalHeight-255;
	$("#accWrapper").css({"height": electricalHeight,"width": windowWidth+"px"});
	$("#electricalBar").css("height",barHeight);
	$("#pipefittingBar").css("height",barHeight);
	$("#hvacBar").css("height",barHeight);
	$("#paintersBar").css("height",barHeight);
	$("#carpentryBar").css("height",barHeight);
	$("#mobBar").css("height",barHeight);
	$("#foundationsBar").css("height",barHeight);
	$("#riggingsBar").css("height",barHeight);
	$("#shopBar").css("height",barHeight);
	$("#activeJobsBar").css("height",barHeight);

	//click functionality for a menu item
	$("#electricalBar").click(function() {
		if (electricalOpen == 0) {
			windowWidth = windowWidth + electricalWidth;		//math for the window's width
			$("#accWrapper").css( "width",windowWidth );			//expand the window
			$(".topBar").css( "width",windowWidth );			//expand the topBar
			$("#electricalContent").animate({width: 'toggle'}).fadeTo('fast', 1);
			$(".eleTopBar").animate({width: 'toggle'}).fadeTo('fast', 1);
			electricalOpen = 1;
			
			$.cookie("eleCookie", "1", { path: '/' });
		} else {
			windowWidth = windowWidth - electricalWidth;		//math for the window's width
			$("#electricalContent").fadeTo('fast', .1).animate({width: 'toggle'});
			$("#accWrapper").css( "width",windowWidth );			//shrink the window
			$(".eleTopBar").fadeTo('fast', .1).animate({width: 'toggle'});
			$(".topBar").css( "width",windowWidth );			//shrink the topBar
			electricalOpen = 0;
					
			$.cookie("eleCookie", null, { path: '/' });
		}
	});
	
	//click functionality for a menu item
	$("#foundationsBar").click(function() {
		if (foundationsOpen == 0) {
			windowWidth = windowWidth + foundationsWidth;		//math for the window's width
			$("#accWrapper").css( "width",windowWidth );			//expand the window
			$(".topBar").css( "width",windowWidth );			//expand the topBar
			$("#foundationsContent").animate({width: 'toggle'}).fadeTo('fast', 1);		//show the content
			$(".fouTopBar").animate({width: 'toggle'}).fadeTo('fast', 1);		//show the content
			foundationsOpen = 1;
			
			$.cookie("fouCookie", "2", { path: '/' });
		} else {
			windowWidth = windowWidth - foundationsWidth;		//math for the window's width
			$("#foundationsContent").fadeTo('fast', .1).animate({width: 'toggle'});
			$("#accWrapper").css( "width",windowWidth );			//shrink the window
			$(".fouTopBar").fadeTo('fast', .1).animate({width: 'toggle'});
			$(".topBar").css( "width",windowWidth );			//shrink the topBar
			foundationsOpen = 0;
			
			$.cookie("fouCookie", null, { path: '/' });
		}
	});

	//click functionality for a menu item
	$("#carpentryBar").click(function() {
		if (carpentryOpen == 0) {
			windowWidth = windowWidth + carpentryWidth;		//math for the window's width
			$("#accWrapper").css( "width",windowWidth );			//expand the window
			$(".topBar").css( "width",windowWidth );			//expand the topBar
			$("#carpentryContent").animate({width: 'toggle'}).fadeTo('fast', 1);		//show the content
			$(".carTopBar").animate({width: 'toggle'}).fadeTo('fast', 1);		//show the content
			carpentryOpen = 1;
			
			$.cookie("carCookie", "3", { path: '/' });
		} else {
			windowWidth = windowWidth - carpentryWidth;		//math for the window's width
			$("#carpentryContent").fadeTo('fast', .1).animate({width: 'toggle'});
			$("#accWrapper").css( "width",windowWidth );			//shrink the window
			$(".carTopBar").fadeTo('fast', .1).animate({width: 'toggle'});
			$(".topBar").css( "width",windowWidth );			//shrink the topBar
			carpentryOpen = 0;
			
			$.cookie("carCookie", null, { path: '/' });
		}
	});

	//click functionality for a menu item
	$("#pipefittingBar").click(function() {
		if (pipefittingOpen == 0) {
			windowWidth = windowWidth + pipefittingWidth;		//math for the window's width
			$("#accWrapper").css( "width",windowWidth );			//expand the window
			$(".topBar").css( "width",windowWidth );			//expand the topBar
			$("#pipefittingContent").animate({width: 'toggle'}).fadeTo('fast', 1);		//show the content
			$(".pipTopBar").animate({width: 'toggle'}).fadeTo('fast', 1);		//show the content
			pipefittingOpen = 1;
			
			$.cookie("pipCookie", "4", { path: '/' });
		} else {
			windowWidth = windowWidth - pipefittingWidth;		//math for the window's width
			$("#pipefittingContent").fadeTo('fast', .1).animate({width: 'toggle'});
			$("#accWrapper").css( "width",windowWidth );			//shrink the window
			$(".pipTopBar").fadeTo('fast', .1).animate({width: 'toggle'});
			$(".topBar").css( "width",windowWidth );			//shrink the topBar
			pipefittingOpen = 0;

			$.cookie('pipCookie', null, { path: '/' });
		}
	});

	//click functionality for a menu item
	$("#riggingsBar").click(function() {
		if (riggingsOpen == 0) {
			windowWidth = windowWidth + riggingsWidth;		//math for the window's width
			$("#accWrapper").css( "width",windowWidth );			//expand the window
			$(".topBar").css( "width",windowWidth );			//expand the topBar
			$("#riggingsContent").animate({width: 'toggle'}).fadeTo('fast', 1);		//show the content
			$(".rigTopBar").animate({width: 'toggle'}).fadeTo('fast', 1);		//show the content
			riggingsOpen = 1;
			
			$.cookie("rigCookie", "5", { path: '/' });
		} else {
			windowWidth = windowWidth - riggingsWidth;		//math for the window's width
			$("#riggingsContent").fadeTo('fast', .1).animate({width: 'toggle'});
			$("#accWrapper").css( "width",windowWidth );			//shrink the window
			$(".rigTopBar").fadeTo('fast', .1).animate({width: 'toggle'});
			$(".topBar").css( "width",windowWidth );			//shrink the topBar
			riggingsOpen = 0;
			
			$.cookie("rigCookie", null, { path: '/' });
		}
	});

	//click functionality for a menu item
	$("#hvacBar").click(function() {
		if (hvacOpen == 0) {
			windowWidth = windowWidth + hvacWidth;		//math for the window's width
			$("#accWrapper").css( "width",windowWidth );			//expand the window
			$(".topBar").css( "width",windowWidth );			//expand the topBar
			$("#hvacContent").animate({width: 'toggle'}).fadeTo('fast', 1);		//show the content
			$(".hvaTopBar").animate({width: 'toggle'}).fadeTo('fast', 1);		//show the content
			hvacOpen = 1;
			
			$.cookie("hvaCookie", "6", { path: '/' });
		} else {
			windowWidth = windowWidth - hvacWidth;		//math for the window's width
			$("#hvacContent").fadeTo('fast', .1).animate({width: 'toggle'});
			$("#accWrapper").css( "width",windowWidth );			//shrink the window
			$(".hvaTopBar").fadeTo('fast', .1).animate({width: 'toggle'});
			$(".topBar").css( "width",windowWidth );			//shrink the topBar
			hvacOpen = 0;
			
			$.cookie("hvaCookie", null, { path: '/' });
		}
	});

	//click functionality for a menu item
	$("#paintersBar").click(function() {
		if (paintersOpen == 0) {
			windowWidth = windowWidth + paintersWidth;		//math for the window's width
			$("#accWrapper").css( "width",windowWidth );			//expand the window
			$(".topBar").css( "width",windowWidth );			//expand the topBar
			$("#paintersContent").animate({width: 'toggle'}).fadeTo('fast', 1);		//show the content
			$(".paiTopBar").animate({width: 'toggle'}).fadeTo('fast', 1);		//show the content
			paintersOpen = 1;
			
			$.cookie("paiCookie", "7", { path: '/' });
		} else {
			windowWidth = windowWidth - paintersWidth;		//math for the window's width
			$("#paintersContent").fadeTo('fast', .1).animate({width: 'toggle'});
			$("#accWrapper").css( "width",windowWidth );			//shrink the window
			$(".paiTopBar").fadeTo('fast', .1).animate({width: 'toggle'});
			$(".topBar").css( "width",windowWidth );			//shrink the topBar
			paintersOpen = 0;
			
			$.cookie("paiCookie", null, { path: '/' });
		}
	});

	//click functionality for a menu item
	$("#mobBar").click(function() {
		if (mobOpen == 0) {
			windowWidth = windowWidth + mobWidth;		//math for the window's width
			$("#accWrapper").css( "width",windowWidth );			//expand the window
			$(".topBar").css( "width",windowWidth );			//expand the topBar
			$("#mobContent").animate({width: 'toggle'}).fadeTo('fast', 1);		//show the content
			$(".mobTopBar").animate({width: 'toggle'}).fadeTo('fast', 1);		//show the content
			mobOpen = 1;
			
			$.cookie("mobCookie", "8", { path: '/' });
		} else {
			windowWidth = windowWidth - mobWidth;		//math for the window's width
			$("#mobContent").fadeTo('fast', .1).animate({width: 'toggle'});
			$("#accWrapper").css( "width",windowWidth );			//shrink the window
			$(".mobTopBar").fadeTo('fast', .1).animate({width: 'toggle'});
			$(".topBar").css( "width",windowWidth );			//shrink the topBar
			mobOpen = 0;
			
			$.cookie("mobCookie", null, { path: '/' });
		}
	});

	//click functionality for a menu item
	$("#shopBar").click(function() {
		if (shopOpen == 0) {
			windowWidth = windowWidth + shopWidth;		//math for the window's width
			$("#accWrapper").css( "width",windowWidth );			//expand the window
			$(".topBar").css( "width",windowWidth );			//expand the topBar
			$("#shopContent").animate({width: 'toggle'}).fadeTo('fast', 1);		//show the content
			$(".shoTopBar").animate({width: 'toggle'}).fadeTo('fast', 1);		//show the content
			shopOpen = 1;
			
			$.cookie("shoCookie", "10", { path: '/' });
		} else {
			windowWidth = windowWidth - shopWidth;		//math for the window's width
			$("#shopContent").fadeTo('fast', .1).animate({width: 'toggle'});
			$("#accWrapper").css( "width",windowWidth );			//shrink the window
			$(".shoTopBar").fadeTo('fast', .1).animate({width: 'toggle'});
			$(".topBar").css( "width",windowWidth );			//shrink the topBar
			shopOpen = 0;
			
			$.cookie("shoCookie", null, { path: '/' });
		}
	});
	
	//click functionality for a menu item
	$("#activeJobsBar").click(function() {
		if (activeJobsOpen == 0) {
			windowWidth = windowWidth + activeJobsWidth;		//math for the window's width
			$("#accWrapper").css( "width",windowWidth );			//expand the window
			$(".topBar").css( "width",windowWidth );			//expand the topBar
			$("#activeJobsContent").animate({width: 'toggle'}).fadeTo('fast', 1);
			$(".ajTopBar").animate({width: 'toggle'}).fadeTo('fast', 1);
			activeJobsOpen = 1;
		} else {
			windowWidth = windowWidth - activeJobsWidth;		//math for the window's width
			$("#activeJobsContent").fadeTo('fast', .1).animate({width: 'toggle'});
			$("#accWrapper").css( "width",windowWidth );			//shrink the window
			$(".ajTopBar").fadeTo('fast', .1).animate({width: 'toggle'});
			$(".topBar").css( "width",windowWidth );			//shrink the topBar
			activeJobsOpen = 0;
		}
	});
	
/* ************************************************************** */
/*              pop up on hover functionality                     */
/* ************************************************************** */
	$(".iframe").hover(function() {
			if ($(this).contents("span:last-child").text() != "") {
				$(this).contents("span:last-child").css({ display: "block" });
			}
		},
		function() { $(this).contents("span:last-child").css({ display: "none" }); }
	);
});		// END DOC READY FUNCTION















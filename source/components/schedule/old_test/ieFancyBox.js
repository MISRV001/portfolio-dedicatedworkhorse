$(document).ready(function() {
	$('.iframe').click(function(e){
		e.preventDefault();												// stop it from going to the page
		var $urlVars = $(this).attr('href');							// grab the 'href' of the link

		$('.lbBackdrop, .lbBox').animate({'opacity':'.50'}, 600);		// animate the backdrop and box 
		$('.lbBox').animate({'opacity':'1.00'}, 600);					// animate the box 
		$('.lbBackdrop, .lbBox').css('display', 'block');				// make the backdrop and box visible and aligned properly
		
		var dataString = $urlVars.substring(8, 200);
		$.ajax({
			type: "POST",
			url: "editcol.php",
			data: dataString,
			cache: false,
			success: function(html){
				$(".lbContent").html(html);
			} 
		});



		//$('.lbContent').load($urlVars);									// load the php page into the box
		
		$('.lbBox').css("left", (($(window).width() - $('.lbBox').outerWidth()) / 2) + $(window).scrollLeft() + "px");
	});
	
	$('.lbClose').click(function(){
		close_box();
		if ($('#msgNotification').is('.success')) {
			window.top.location.href=window.top.location.href;
		}
	});	
	
	$('.lbBackdrop').click(function(){
		close_box();
	});
	
	function close_box() {
		$('.lbBackdrop, .lbBox').animate({'opacity':'0'}, 600, function(){
			$('.lbBackdrop, .lbBox').css('display', 'none');
		});
	}
});
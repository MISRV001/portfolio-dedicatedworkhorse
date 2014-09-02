$(document).ready(function() {
// set up the date format for the iframe info
 Date.format = 'mm/dd/yyyy';
 
/* ************************************************************** */
/*              fill with box above functionality                 */
/* ************************************************************** */
	if($("#editcolJob").val() == "") {
		if($('#prntMsgNotification', parent.document.body).html() === "") {
			var foreman = $("#empID").val();
			var editcolBlock1 = $("#editcolBlock1").val();
			var editcolBlock2 = $("#editcolBlock2").val();
			var editcolYear = $("#editcolYear").val();
			var editcolMonth = $("#editcolMonth").val();
			var editcolDay = $("#editcolDay").val();
			var currentDepartment = $("#currentDepartment").val();
			var onLoad = "yes";
			
			dataString = 'onLoad='+onLoad+'&foreman='+foreman+'&currentDepartment='+currentDepartment+'&editcolMonth='+editcolMonth+'&editcolDay='+editcolDay+'&editcolYear='+editcolYear+'&editcolBlock1='+editcolBlock1+'&editcolBlock2='+editcolBlock2;
			// saves data in the db
			$.ajax({
				type: "POST",
				url: "doStuff.php",
				data: dataString,
				cache: false,
				success: function(text){
					if (text > 1) {
						$("#msgNotification").show().css({'text-align': 'center', 'background-color': '#33CC00', 'border': 'thin solid #006600', 'font-family': 'helvetica, arial', 'color': '#000000'});
						$("#msgNotification").html(text);
						$('#prntMsgNotification', parent.document.body).html(text);
						if($('#prntMsgNotification', parent.document.body).length) {
							location.reload(true);
							return false;
						}
					}
				} 
			});
		}
	}
	
/* ********************************************************** */
/*              Date Picker functionality                     */
/* ********************************************************** */
if($("#copyUntil").length > 0) {
	$("#copyUntil").datePicker({ clickInput: true });
}

/* ************************************************************** */
/*                  subform button functionality                  */
/* ************************************************************** */
// clear button clicked
	$('#btnClear').click(function(){
		// clear the form
		$("#editcolJob").find('option:first').attr('selected', 'selected');
		$("#editcolLocation").find('option:first').attr('selected', 'selected');
		if($("#editcolLocation").val() != "firstone"){
			$("#editcolLocation").html('<option value="firstone" selected="true">please select a location</option>');
		}
		$("#editcolApprentice").find('option:first').attr('selected', 'selected');
		$("#editcolVan").find('option:first').attr('selected', 'selected');
		$("#editcolEquipment").find('option:first').attr('selected', 'selected');
		$("#editcolComments").val(" ");
		
		// set the delete session variable to 
		$("#editcolDelete").val("1");
		$("#msgNotification").hide("");
	});
	
// save button clicked
	$('#btnSave').click(function(){
		var updateFlag = $("#editcolUpdateFlag").val();
		var editcolJob = $("#editcolJob").val();
		var editcolLocation = $("#editcolLocation").val();
		var editcolApprentice = $("#editcolApprentice").val();
		var editcolVan = $("#editcolVan").val();
		var editcolEquipment = $("#editcolEquipment").val();
		var empID = $("#empID").val();
		var editcolYear = $("#editcolYear").val();
		var editcolMonth = $("#editcolMonth").val();
		var editcolDay = $("#editcolDay").val();
		var editcolBlock1 = $("#editcolBlock1").val();
		var editcolBlock2 = $("#editcolBlock2").val();
		var editcolComments = $("#editcolComments").val();
		var editcolDelete = $("#editcolDelete").val();
		var currentScheduleID = $("#currentScheduleID").val();
		var editcolCurrentJobID = $("#currentJobID").val();
		var currentDepartment = $("#currentDepartment").val();
		var currentLocation = $("#currentLocation").val();
		var currentApprentice = $("#currentApprentice").val();
		var currentVan = $("#currentVan").val();
		var currentEquipment = $("#currentEquipment").val();
		var editcolNewForeman = $("#editcolNewForeman").val();
/*		if(editcolNewForeman!=""){
			updateFlag = "update";
		}
*/		
		if($("#includeWkdsSat").is(':checked')) {
			var includeWkdsSat = "showSaturday";
		}
		
		if($("#includeWkdsSun").is(':checked')) {
			var includeWkdsSun = "showSunday";
		}
		
		var copyUntil = $("#copyUntil").val();
		var editcolError = "";
		var dataString = "";

		if(editcolDelete == 1){
			// blank form now delete
			dataString = 'editcolQueryStyle=delete&editcolJob='+ editcolJob +'&editcolLocation='+ editcolLocation +'&editcolApprentice='+ editcolApprentice +'&editcolVan='+ editcolVan +'&editcolEquipment='+ editcolEquipment+'&empID='+empID+'&currentDepartment='+currentDepartment+'&editcolMonth='+editcolMonth+'&editcolDay='+editcolDay+'&editcolBlock1='+ editcolBlock1 +'&editcolBlock2='+ editcolBlock2+'&editcolComments='+editcolComments+'&currentJobID='+editcolCurrentJobID+'&currentScheduleID='+currentScheduleID +'&currentLocation='+ currentLocation +'&currentApprentice='+ currentApprentice +'&currentVan='+ currentVan +'&currentEquipment='+ currentEquipment+'&editcolYear='+editcolYear+'&includeWkdsSat='+includeWkdsSat+'&includeWkdsSun='+includeWkdsSun;
		} else if (editcolLocation == "firstone") {
			// they need to pick a job
			$("#msgNotification").css({'text-align': 'center', 'background-color': 'red', 'font-weight': 'bold', 'font-family': 'helvetica, arial', 'color': '#FFFFFF'});
			$("#msgNotification").html("Please Select a Job.<br />");
			return false;
		} else if (editcolNewForeman) {
			dataString = 'editcolQueryStyle='+updateFlag+'&editcolJob='+ editcolJob +'&editcolLocation='+ editcolLocation +'&editcolApprentice='+ editcolApprentice +'&editcolVan='+ editcolVan +'&editcolEquipment='+ editcolEquipment+'&empID='+empID+'&currentDepartment='+currentDepartment+'&editcolMonth='+editcolMonth+'&editcolDay='+editcolDay+'&editcolBlock1='+ editcolBlock1 +'&editcolBlock2='+ editcolBlock2+'&editcolComments='+editcolComments+'&currentJobID='+editcolCurrentJobID+'&editcolYear='+editcolYear+'&copyUntil='+copyUntil+'&includeWkdsSat='+includeWkdsSat+'&includeWkdsSun='+includeWkdsSun+'&editcolNewForeman='+editcolNewForeman;
		} else {
			dataString = 'editcolQueryStyle='+updateFlag+'&editcolJob='+ editcolJob +'&editcolLocation='+ editcolLocation +'&editcolApprentice='+ editcolApprentice +'&editcolVan='+ editcolVan +'&editcolEquipment='+ editcolEquipment+'&empID='+empID+'&currentDepartment='+currentDepartment+'&editcolMonth='+editcolMonth+'&editcolDay='+editcolDay+'&editcolBlock1='+ editcolBlock1 +'&editcolBlock2='+ editcolBlock2+'&editcolComments='+editcolComments+'&currentJobID='+editcolCurrentJobID+'&editcolYear='+editcolYear+'&copyUntil='+copyUntil+'&includeWkdsSat='+includeWkdsSat+'&includeWkdsSun='+includeWkdsSun;
		}
		
		if(editcolComments == " " ){
			editcolComments = "";
		}
		
		// saves data in the db
		$.ajax({
			type: "POST",
			url: "doStuff.php",
			data: dataString,
			cache: false,
			success: function(text){
				if(editcolDelete == 1) {
					$("#msgNotification").show().css({'text-align': 'center', 'background-color': '#CC0000', 'border': 'thin solid #660000', 'font-family': 'helvetica, arial', 'color': '#FFFFFF'});
				} else {
					$("#msgNotification").show().css({'text-align': 'center', 'background-color': '#33CC00', 'border': 'thin solid #006600', 'font-family': 'helvetica, arial', 'color': '#000000'});
				}
				$('#prntMsgNotification', window.parent.document).html(text);
				$("#msgNotification").html(text);
				$("#msgNotification").addClass("success");
				$("#editcolDelete").val("0");
			} 
		});
	});
	
// finalized button clicked	
	$('#btnFinalize').click(function(){
		var scheduleID = $("#currentScheduleID").val();
		var finalized = $("#finalized").val();
		var dataString = "";
		
		dataString = 'finalizeME=purple&scheduleID='+scheduleID+'&finalized='+finalized;
		
		// flip the finalize switch
		$.ajax({
			type: "POST",
			url: "doStuff.php",
			data: dataString,
			cache: false,
			success: function(text){
				$("#msgNotification").css({'text-align': 'center', 'background-color': '#00FF00', 'border': 'thin solid #008000', 'font-family': 'helvetica, arial', 'color': '#000000'});
				$("#msgNotification").html(text);
				$("#msgNotification").addClass("success");
				$('#prntMsgNotification', window.parent.document).html("");
				$('#prntMsgNotification', window.parent.document).html(text);
			} 
		});
	});
	
// add new button was pounded upon	
	$('#btnAddRecord').click(function(){
		// clear the form for a fresh start but don't set the delete trigger
		$("#editcolJob").find('option:first').attr('selected', 'selected');
		$("#editcolLocation").find('option:first').attr('selected', 'selected');
		if($("#editcolLocation").val() != "firstone"){
			$("#editcolLocation").html('<option value="firstone" selected="true">please select a location</option>');
		}
		
		$("#editcolApprentice").find('option:first').attr('selected', 'selected');
		$("#editcolVan").find('option:first').attr('selected', 'selected');
		$("#editcolEquipment").find('option:first').attr('selected', 'selected');
		$("#editcolComments").val(" ");
		
		$("#msgNotification").html("");
		$("#msgNotification").hide();
		$("#editcolUpdateFlag").val("insert");
	});
	
/* ************************************************************** */
/*         lbLocations Dropdown Population functionality          */
/* ************************************************************** */
	// when the page is loaded, get the jobs and assigned job if there is a job selected already
	if($("#editcolJob").val()!=''){
		var scheduleid=$("#currentScheduleID").val();
		var jobid=$("#currentJobID").val();
		var dataString = 'scheduleid='+scheduleid+'&jobid='+jobid;
		
		$.ajax({
			type: "POST",
			url: "doStuff.php",
			data: dataString,
			cache: false,
			success: function(text){
				$("#editcolLocation").html(text);
			} 
		});
	}

	// when the job is changed change the locations available
	$("#editcolJob").change(function(){
		var jobid=$("#editcolJob").val();
		var dataString = 'getJobID='+ jobid;
		$.ajax({
			type: "POST",
			url: "doStuff.php",
			data: dataString,
			cache: false,
			success: function(text){
				$("#editcolLocation").html(text);
			} 
		});
		$("#msgNotification").hide();
		$("#msgNotification").html("");

	});
});		// end doc ready




















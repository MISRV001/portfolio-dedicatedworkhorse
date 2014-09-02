<html>
<head>
	<title>schedule Test</title>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
	<![if !IE]><link rel="stylesheet" href="../../../scripts/jquery.fancybox/fancybox/jquery.fancybox-1.3.4.css" type="text/css" media="screen" /><![endif]>
	<![if !IE]><script type="text/javascript" src="../../../scripts/jquery.fancybox/fancybox/jquery.fancybox-1.3.4.pack.js"></script><![endif]>
	<![if !IE]><script language="JavaScript" src="js/fancyBox.js"></script><![endif]>
	<script type="text/javascript" src="js/schedule3.js"></script>
	<script type="text/javascript" src="js/jquery.cookie.js"></script>
	<link rel="stylesheet" type="text/css" href="css/schedule.css" />
	<![if !IE]><script language="JavaScript" src="js/scrollyThing2.js"></script><![endif]>

<!--[if IE]>
	<script language="JavaScript" src="js/ieFancyBox.js"></script>
<![endif]-->

<!--[if IE]>
<style>
.calendar {position:absolute; margin-left:0px; float:left;}
.topBar {position:absolute; margin-left:0px; float:left;}
* html div.calendar {
	left:expression(eval(document.compatMode &&
	document.compatMode=='CSS1Compat') ?
	documentElement.scrollLeft + 0 
	: document.body.scrollLeft + 0);
}

* html div.topBar {
	top:expression(eval(document.compatMode &&
	document.compatMode=='CSS1Compat') ?
	documentElement.scrollTop + 0 
	: document.body.scrollTop + 0);
}

</style>
<![endif]-->

</head>
<?php
include('../../../includes/db.php');

// grab url variables
if(isset($_GET['userID'])) {$userID = $_GET['userID'];}
if(isset($_GET['month'])) {$month = $_GET['month']; } else { $month = time();}
if(isset($_GET['year'])) {$year = $_GET['year'];} else { $year = time();}
if(isset($_GET['mode'])) {$mode = $_GET['mode'];} else { $mode = "view";}

// set up the months
if($month == 'jan' || $month == 1) {
	$month = date('Y')."-01-01";
	$month = strtotime($month);
	$m = '1';
} elseif($month == 'feb' || $month == 2) {
	$month = date('Y')."-02-01";
	$month = strtotime($month);
	$m = '2';
} elseif($month == 'march' || $month == 3) {
	$month = date('Y')."-03-01";
	$month = strtotime($month);
	$m = '3';
} elseif($month == 'april' || $month == 4) {
	$month = date('Y')."-04-01";
	$month = strtotime($month);
	$m = '4';
} elseif($month == 'may' || $month == 5) {
	$month = date('Y')."-05-01";
	$month = strtotime($month);
	$m = '5';
} elseif($month == 'june' || $month == 6) {
	$month = date('Y')."-06-01";
	$month = strtotime($month);
	$m = '6';
} elseif($month == 'july' || $month == 7) {
	$month = date('Y')."-07-01";
	$month = strtotime($month);
	$m = '7';
} elseif($month == 'aug' || $month == 8) {
	$month = date('Y')."-08-01";
	$month = strtotime($month);
	$m = '8';
} elseif($month == 'sep' || $month == 9) {
	$month = date('Y')."-09-01";
	$month = strtotime($month);
	$m = '9';
} elseif($month == 'oct' || $month == 10) {
	$month = date('Y')."-10-01";
	$month = strtotime($month);
	$m = '10';
} elseif($month == 'nov' || $month == 11) {
	$month = date('Y')."-11-01";
	$month = strtotime($month);
	$m = '11';
} elseif($month == 'dec' || $month == 12) {
	$month = date('Y')."-12-01";
	$month = strtotime($month);
	$m = '12';
}

 //This gets today's date 
 $date = $month;

 //This puts the day, month, and year in seperate variables 
 $day = date('d', $date) ; 
 $month = date('m', $date) ; 
 if(!isset($_GET['year'])) {$year = date('Y', $date);}
	
 //Here we generate the first day of the month 
 $first_day = mktime(0,0,0,$month, $day, $year) ; 
 $days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $year) ; 
 $title = date('M-y', $first_day) ;
 $day_num = 1;
 $day_add = 0;
 
// set up links for date navigation
if ($month == 12 ) {
	$nextMonth = 01;
	$previousMonth = $month-1;
	$nextYear = $year+1;
	$previousYear = $year;
} else if ($month == 01) {
	$nextMonth = $month+1;
	$previousMonth = 12;
	$nextYear = $year;
	$previousYear = $year-1;
} else {
	$nextMonth = $month+1;
	$previousMonth = $month-1;
	$nextYear = $year;
	$previousYear = $year;
}

echo "</head><body>";
// my hack to create a seamless "lightbox" for IE
echo '<div class="lbBackdrop"></div><div class="lbBox"><div class="lbContent"></div><div class="lbClose"><img src="images/fancy_close.png" /></div></div>';
// start the wrapper
echo '<div class="wrapper">';

echo "<div class=\"calendar\">";
echo "<div class=\"mockCalendarTable\">";		// start of the calendar table
echo "<div class=\"mockCalendarHRow\"><div class=\"mockCalendarHTD\"><a href=\"schedule3.php?userID=11&month=".$previousMonth."&year=".$previousYear."\" target=\"_self\"><</a> ". $title . " <a href=\"schedule3.php?userID=11&month=".$nextMonth."&year=".$nextYear."\" target=\"_self\">></a></div></div>";		// title row

//count up the days, until we've done all of them in the month
while ( $day_num <= $days_in_month ) { 
	$day_of_week =  mktime(0,0,0,$month, 1+$day_add, $year) ; 

	if ( $day_num == $days_in_month ) {			// checks to see if it is the end of the month for formatting the borders
		$mockCalendarTD1 = "mockCalendarTD1EOM";
		$mockCalendarTD2 = "mockCalendarTD2EOM";
	} else {
		$mockCalendarTD1 = "mockCalendarTD1";
		$mockCalendarTD2 = "mockCalendarTD2";
	}

	if ((date('l',$day_of_week)!="Saturday")&&(date('l',$day_of_week)!="Sunday")){		// checks to see if it is the end of the week for formatting the borders
		echo "<div class='mockCalendarRow weekday'>";									// start the row
		echo "<div class='".$mockCalendarTD1."'>". date('l',$day_of_week)."</div>";		// add the mock cell with the day
	} else {
		echo "<div class='mockCalendarRow weekend'>";									// start the row
		echo "<div class='".$mockCalendarTD1."'>". date('l',$day_of_week)."</div>";		// add the mock cell with the day
	}

	if ($day_num < 10) {
		$day_num = "0".$day_num;		// add the 0's to numbers that are NOT 2 digits long
	}
	echo "<div class='".$mockCalendarTD2."'>".  $day_num ."</div>"; 		// add the date to go with the day
	echo "</div>";		// end calendar row
	
	$day_num++;
	$day_add++;
} 
 echo "</div>";		// end mockCalendarTable
 echo "</div>";		// end calendar

/* top bar wrapper */
echo '<div class="topBar">';

//		//		//		//		//		//		//		//		//	//
// temp system to get the user id									//
if (isset($_GET["userID"])) {$userID = $_GET["userID"];}			//
//		//		//		//		//		//		//		//		//	//

//query for departments that are assigned to person viewing this doc
$sql0 = "SELECT * FROM departments JOIN foremen ON foremen.deptid = departments.iddepartments WHERE foremen.employeeid = '$userID' AND departments.schedulecolor IS NOT NULL GROUP BY departments.name ORDER BY departments.name ASC";
$result0 = mysql_query($sql0);
if(!$result0) {
	$message  = 'Invalid query: ' . mysql_error() . "\n";
	$message .= 'Whole query: ' . $result0;
	die($message);
};

$num_rows0 = mysql_num_rows($result0);

$in = 0;

/**********************************************/
/*      make the user's the top bar           */
/**********************************************/
while($num_rows0 > $in) {
	//assign the variables to the array
	while($rows0 = mysql_fetch_assoc($result0)) {
		//build the "displayed first" accordian boxes
		$bgColor = $rows0['schedulecolor'];
		$currentDepartment = $rows0['iddepartments'];
		$currentDepartmentName = strtolower($rows0['name']);
		$strPartialName = substr($currentDepartmentName, 0, 3);
		
		echo '<div class="headerSpacer" style="background-color:'.$bgColor.'">&nbsp;</div>';			//this is the width of the menu bars for proper alignment
		echo '<div class="mockTopBarTable '.$strPartialName.'TopBar"><div class="mockTopBarRow">';
		$sql1 = "select * from foremen where deptid = '$currentDepartment'";
		$result1 = mysql_query($sql1);
		if(!$result1) { $message  = 'Invalid query: ' . mysql_error() . "\n"; $message .= 'Whole query: ' . $result1; die($message); };
		$num_rows = mysql_num_rows($result1);
		$i = 0;
		while($num_rows > $i) {
			echo '<div class="mockTopBarTD1" style="background-color:'.$bgColor.'">'.$currentDepartmentName.'</div>';
			$i++;
		}
		// add the 2 "block"s at the end
		echo '<div class="mockTopBarTD1" style="background-color:'.$bgColor.'">'.$currentDepartmentName.'</div><div class="mockTopBarTD2" style="background-color:'.$bgColor.'">'.$currentDepartmentName.'</div></div><div class="mockTopBarRow">';
		while($rows1 = mysql_fetch_assoc($result1)) {
			$ids[] = $rows1['employeeid'];
		}
		foreach($ids as $id) {
			$sql1 = "SELECT * FROM foremen, employees WHERE foremen.employeeid = employees.idemployees AND foremen.employeeid = '$id'AND foremen.deptid = '$currentDepartment'";
			$result1 = mysql_query($sql1);
			if(!$result1) { $message  = 'Invalid query: ' . mysql_error() . "\n"; $message .= 'Whole query: ' . $result1; die($message); }
			
			while($rows1 = mysql_fetch_assoc($result1)) {
				$foreman1 = $rows1['foremanid'];
				$first_name1 = $rows1['first_name'];
				$last_name1 = $rows1['last_name'];
				echo "<div class='mockTopBarTD1' style='background-color:".$bgColor."'>".$first_name1.' '.$last_name1."</div>";
			}
		}
		echo '<div class="mockTopBarTD1" style="background-color:'.$bgColor.'">block</div><div class="mockTopBarTD2" style="background-color:'.$bgColor.'">block</div>';
		echo '</div>';		// end row
		echo '</div>';		// end topBar table
	}

	$in++;
}

/**********************************************/
/*          make rest of the top bar          */
/**********************************************/
//query for departments that aren't assigned
$sql0 = "SELECT * FROM departments WHERE name != (SELECT name FROM foremen INNER JOIN departments ON foremen.deptid = departments.iddepartments WHERE foremen.employeeid = '$userID' AND departments.schedulecolor IS NOT NULL GROUP BY departments.name ORDER BY departments.name ASC)  AND departments.schedulecolor IS NOT NULL";
$result0 = mysql_query($sql0);
if(!$result0) {
	$message  = 'Invalid query: ' . mysql_error() . "\n";
	$message .= 'Whole query: ' . $result0;
	die($message);
};

$num_rows0 = mysql_num_rows($result0);
$in = 0;

while($num_rows0 > $in) {
	//assign the variables to the array
	while($rows0 = mysql_fetch_assoc($result0)) {
	
		//build the rest of the accordian boxes
		$bgColor = $rows0['schedulecolor'];
		$currentDepartment = $rows0['iddepartments'];
		$currentDepartmentName = strtolower($rows0['name']);
		$strPartialName = substr($currentDepartmentName, 0, 3);
		
		echo '<div class="headerSpacer" style="background-color:'.$bgColor.'">&nbsp;</div>';
		echo '<div class="mockTopBarTable '.$strPartialName.'TopBar"><div class="mockTopBarRow">';
		$sql2 = "select * from foremen where deptid = '$currentDepartment'";
		$result2 = mysql_query($sql2);
		if(!$result2) { $message  = 'Invalid query: ' . mysql_error() . "\n"; $message .= 'Whole query: ' . $result2; die($message); };
		$num_rows = mysql_num_rows($result2);
		$i = 0;
		while($num_rows > $i) {
			echo '<div class="mockTopBarTD1" style="background-color:'.$bgColor.'">'.$currentDepartmentName.'</div>';
			$i++;
		}
		// add the 2 "block"s at the end
		echo '<div class="mockTopBarTD1" style="background-color:'.$bgColor.'">'.$currentDepartmentName.'</div><div class="mockTopBarTD2" style="background-color:'.$bgColor.'">'.$currentDepartmentName.'</div></div><div class="mockTopBarRow">';
		while($rows = mysql_fetch_assoc($result2)) {
			$ids[] = $rows['employeeid'];
		}
		foreach($ids as $id) {
			$sql2 = "SELECT * FROM foremen, employees WHERE foremen.employeeid = employees.idemployees AND foremen.employeeid = '$id'AND foremen.deptid = '$currentDepartment'";
			$result2 = mysql_query($sql2);
			if(!$result2) { $message  = 'Invalid query: ' . mysql_error() . "\n"; $message .= 'Whole query: ' . $result2; die($message); }
			
			while($rows2 = mysql_fetch_assoc($result2)) {
				$foreman2 = $rows2['foremanid'];
				$first_name2 = $rows2['first_name'];
				$last_name2 = $rows2['last_name'];
				echo "<div class='mockTopBarTD1' style='background-color:".$bgColor."'>".$first_name2.' '.$last_name2."</div>";
			}
		}
		echo '<div class="mockTopBarTD1" style="background-color:'.$bgColor.'">block</div><div class="mockTopBarTD2" style="background-color:'.$bgColor.'">block</div>';
		echo '</div>';		// end row
		echo '</div>';		// end topBar table
	}
	$in++;
}

echo '<div class="headerSpacerEND">&nbsp;</div>';			//this is the width of the menu bars for proper alignment
echo "</div>";

// set up the content wrapper
echo '<div id="accWrapper">';

/**********************************************/
/*          create the menu items             */
/**********************************************/
//query for departments to be displayed first

$sql0 = "SELECT * FROM departments JOIN foremen ON foremen.deptid = departments.iddepartments WHERE foremen.employeeid = '$userID' AND departments.schedulecolor IS NOT NULL GROUP BY departments.name ORDER BY departments.name ASC";
$result0 = mysql_query($sql0);
if(!$result0) {
	$message  = 'Invalid query: ' . mysql_error() . "\n";
	$message .= 'Whole query: ' . $result0;
	die($message);
};

$num_rows0 = mysql_num_rows($result0);

$in = 0;

while($num_rows0 > $in) {
	//assign the variables to the array
	while($rows0 = mysql_fetch_assoc($result0)) {
		//build the "displayed first" accordian boxes
		$deptFirstDisplayed[] = $rows0['iddepartments'];
		$currentDepartment = $rows0['iddepartments'];
		$currentDepartmentName = $rows0['name'];
		$deptColor = $rows0['schedulecolor'];
		$strdeptColor = substr($deptColor, 1, 7);
		
		/* set up for dynamic class assignment and menuBar creation */
		if($currentDepartment == 1){$classDeptName = "electrical";  echo "<div id='menuItem' style='background-color:".$deptColor."'> <div id='" . $classDeptName . "Bar' class='colapsedMenu'>E<br />l<br />e<br />c<br />t<br />r<br />i<br />c<br />a<br />l<br /></div> <div id='" . $classDeptName . "Content' class='floatL'>";}
		if($currentDepartment == 2){$classDeptName = "foundations"; echo "<div id='menuItem' style='background-color:".$deptColor."'> <div id='" . $classDeptName . "Bar' class='colapsedMenu'>F<br />o<br />u<br />n<br />d<br />a<br />t<br />i<br />o<br />n<br />s<br /></div> <div id='" . $classDeptName . "Content' class='floatL'>";}
		if($currentDepartment == 3){$classDeptName = "carpentry"; echo "<div id='menuItem' style='background-color:".$deptColor."'> <div id='" . $classDeptName . "Bar' class='colapsedMenu'>C<br />a<br />r<br />p<br />e<br />n<br />t<br />r<br />y<br /></div> <div id='" . $classDeptName . "Content' class='floatL'>";}
		if($currentDepartment == 4){$classDeptName = "pipefitting"; echo "<div id='menuItem' style='background-color:".$deptColor."'> <div id='" . $classDeptName . "Bar' class='colapsedMenu'>P<br />i<br />p<br />e<br />&nbsp;<br />f<br />i<br />t<br />t<br />i<br />n<br />g<br /></div> <div id='" . $classDeptName . "Content' class='floatL'>";}
		if($currentDepartment == 5){$classDeptName = "riggings"; echo "<div id='menuItem' style='background-color:".$deptColor."'> <div id='" . $classDeptName . "Bar' class='colapsedMenu'>R<br />i<br />g<br />g<br />i<br />n<br />g<br />s<br /></div> <div id='" . $classDeptName . "Content' class='floatL'>";}
		if($currentDepartment == 6){$classDeptName = "hvac"; echo "<div id='menuItem' style='background-color:".$deptColor."'> <div id='" . $classDeptName . "Bar' class='colapsedMenu'>H<br />V<br />A<br />C<br /></div> <div id='" . $classDeptName . "Content' class='floatL'>";}
		if($currentDepartment == 7){$classDeptName = "painters"; echo "<div id='menuItem' style='background-color:".$deptColor."'> <div id='" . $classDeptName . "Bar' class='colapsedMenu'>P<br />a<br />i<br />n<br />t<br />e<br />r<br />s<br /></div> <div id='" . $classDeptName . "Content' class='floatL'>";}
		if($currentDepartment == 8){$classDeptName = "mob"; echo "<div id='menuItem' style='background-color:".$deptColor."'> <div id='" . $classDeptName . "Bar' class='colapsedMenu'>M<br />o<br />b<br />&nbsp;<br />c<br />r<br />e<br />w<br /></div> <div id='" . $classDeptName . "Content' class='floatL'>";}
		if($currentDepartment == 10){$classDeptName = "shop"; echo "<div id='menuItem' style='background-color:".$deptColor."'> <div id='" . $classDeptName . "Bar' class='colapsedMenu'>S<br />h<br />o<br />p<br />&nbsp;<br />g<br />u<br />y<br />s<br /></div> <div id='" . $classDeptName . "Content' class='floatL'>";}
		
		// create the content cells
		echo '<div class="mockContentTable '.$rows0['name'].'">';
		
		$sql = "select * from foremen where deptid = '$currentDepartment'";
		$result = mysql_query($sql);
		if(!$result) { $message  = 'Invalid query: ' . mysql_error() . "\n"; $message .= 'Whole query: ' . $result; die($message); }
		$num_stake = mysql_num_rows($result);
		
		$day_num = 1;
		$cols = 1;
		
		if ($m < 10) {
			$m = "0".$m;
		}
		
		while($days_in_month >= $day_num) {
			$day_num1 = 1;
			$day_add1 = 0;

			//count up the days, until we've done all of them in the month
			while ( $day_num1 <= $days_in_month ) { 
				$day_of_week =  mktime(0,0,0,$month, 1+$day_add1, $year) ; 

				if ((date('l',$day_of_week)!="Saturday")&&(date('l',$day_of_week)!="Sunday")){
					echo "<div class='mockContentRow weekday'>";
					$isWeekend = "0";
				} else {
					$isWeekend = "1";
					echo "<div class='mockContentRow weekend'>";
				}
				
				if ($day_num < 10) {
					$day_num = "0".$day_num;
				}
				
				while($cols <= $num_stake) {
					$jobID = $rows0['foremanid'];
					$strTempPartialName = strtolower($currentDepartmentName);
					$strPartialName = substr($strTempPartialName, 0, 3);
					
					if(isset($_GET['month'])) {
						$colname = $m."-" . $strPartialName . "-".$day_num."-".$cols."-".$year;
						$editcolDateOfJob = $year."-".$m."-".$day_num;
					} else {
						$colname = date('m')."-" . $strPartialName . "-".$day_num."-".$cols."-".$year;
						$editcolDateOfJob = $year."-".date('m')."-".$day_num;
					}
					
					/***************************************************/
					/*       get the foreman's info for querying       */
					/***************************************************/
					$sql = "select * from foremen where deptid = '$currentDepartment'";
					$result = mysql_query($sql);
					if(!$result) {
						$message  = 'Invalid query: ' . mysql_error() . "\n";
						$message .= 'Whole query: ' . $result;
						die($message);
					};

					$num_rows = mysql_num_rows($result);
					$it = 1;		//counter

					if ($cols){
						do {
							$rows = mysql_fetch_array($result);
							$strForeman = $rows['employeeid'];
							$it++;
						} while ($it <= $cols);
						
						$sql = "SELECT * FROM employees WHERE idemployees='$strForeman'";
						
						$result = mysql_query($sql);
						if(!$result) {
							$message  = 'Invalid query: ' . mysql_error() . "\n";
							$message .= 'Whole query: ' . $result;
							die($message);
						};
						$num_rows = mysql_num_rows($result);
						$ii = 0;

						while($num_rows >$ii){
							while($rows = mysql_fetch_array($result)){
								$idOfTheForeman = $rows['idemployees'];
								$displayQueryPiece = "foremanid = ".$idOfTheForeman;
							}
							$ii++;
						}
					} 
					/***************************************************/
					/*           end fetching foreman's info           */
					/***************************************************/
					
					//select the job based on the date, foreman, and department while looping through
					$sql10 = "SELECT * FROM schedule WHERE jobdate = '$editcolDateOfJob' AND deptid = '$currentDepartment' AND ".$displayQueryPiece."";
					$result10 = mysql_query($sql10);
					if(!$result10) {
						$message  = 'Invalid query: ' . mysql_error() . "\n";
						$message .= 'Whole query: ' . $result10;
						die($message);
					};

					$num_rows10 = mysql_num_rows($result10);
					$in = 0;

					while($num_rows10 > $in) {
						//assign the variables to the array
						while($rows10 = mysql_fetch_assoc($result10)) {
							$editcolJobID = $rows10['idjobs'];
							$editcolLocationID = $rows10['locationid'];
							$editcolVanID = $rows10['vanid'];
							$editcolApprenticeID = $rows10['apprenticeid'];
							$editcolEquipmentID = $rows10['equipid'];
							$editcolFinalize = $rows10['finalize'];
							if($editcolFinalize == "0"){
								$editcolDisplayCSS = "displaySaved";
							} else {
								$editcolDisplayCSS = "displayFinalized";
							}
							
							$sql11 = "SELECT idjobs, job_name, idcustomer, cust_name FROM jobs JOIN company ON jobs.company_idcustomer = company.idcustomer WHERE idjobs='$editcolJobID'";
							$result11 = mysql_query($sql11);
							if(!$result11) {
								$message  = 'Invalid query: ' . mysql_error() . "\n";
								$message .= 'Whole query: ' . $result11;
								die($message);
							};

							$num_rows11 = mysql_num_rows($result11);
							$inn = 0;
			
							while($num_rows11 > $inn) {
								//assign the variables to the array
								while($rows11 = mysql_fetch_assoc($result11)) {
									$jobName = $rows11['job_name'];
									$custName = $rows11['cust_name'];
									$jobName8 = substr($jobName, 0, 8);
									$custName8 = substr($custName, 0, 8);
									$name2display = $custName8." : ".$jobName8;
									$linksTitle = $custName." : ".$jobName;
								}
								$inn++;
							}
						}
						$in++;
					}
					
					if($num_rows10 > 1){
						$multipleJobs = "multipleJobs";
					} else {
						$multipleJobs = "";
					}
					
					echo "<div id=\"".$colname."\" class=\"mockContentTD2 ".$multipleJobs."\">";
					if ($mode =="edit") {
						echo "<a class=\"iframe ".$editcolDisplayCSS."\" style=\"display:block;width:100%;height:100%;\" href=\"editcol.php?userID=".$userID."&editSelector=".$colname."&color=".$strdeptColor."&foreman=".$idOfTheForeman."&editcolJob=".$editcolJobID."&editcolLocation=".$editcolLocationID."&editcolVan=".$editcolVanID."&editcolApprentice=".$editcolApprenticeID."&editcolEquipment=".$editcolEquipmentID."\">".$name2display;
					} else {
						echo "<a class=\"iframe ".$editcolDisplayCSS."\" style=\"display:block;width:100%;height: 100%;\" href=\"viewjobinfo.php?job_id=".$editcolJobID."\">".$name2display;
					}
					echo "<span class='tooltipStyle1'>".$linksTitle."</span></a>";
					echo "</div>";
					
					$cols++;
					$jobName = "";
					$custName = "";
					$name2display = "";
					$linksTitle = "";
					$editcolJobID = "";
					$editcolLocationID = "";
					$editcolVanID = "";
					$editcolApprenticeID = "";
					$editcolEquipmentID = "";
				}
				
				/* ************************************************** */
				/*                    set up block 1                  */
				/* ************************************************** */
					$sql10 = "SELECT * FROM schedule WHERE jobdate = '$editcolDateOfJob' AND deptid = '$currentDepartment' AND block1 = '1'";
					$result10 = mysql_query($sql10);
					if(!$result10) {
						$message  = 'Invalid query: ' . mysql_error() . "\n";
						$message .= 'Whole query: ' . $result10;
						die($message);
					};

					$num_rows10 = mysql_num_rows($result10);
					$in = 0;

					while($num_rows10 > $in) {
						//assign the variables to the array
						while($rows10 = mysql_fetch_assoc($result10)) {
							$editcolJobID = $rows10['idjobs'];
							$editcolLocationID = $rows10['locationid'];
							$editcolVanID = $rows10['vanid'];
							$editcolApprenticeID = $rows10['apprenticeid'];
							$editcolEquipmentID = $rows10['equipid'];
							$editcolFinalize = $rows10['finalize'];
							if($editcolFinalize == "0"){
								$editcolDisplayCSS = "displaySaved";
							} else {
								$editcolDisplayCSS = "displayFinalized";
							}
							
							$sql11 = "SELECT idjobs, job_name, idcustomer, cust_name FROM jobs JOIN company ON jobs.company_idcustomer = company.idcustomer WHERE idjobs='$editcolJobID'";
							$result11 = mysql_query($sql11);
							if(!$result11) {
								$message  = 'Invalid query: ' . mysql_error() . "\n";
								$message .= 'Whole query: ' . $result11;
								die($message);
							};

							$num_rows11 = mysql_num_rows($result11);
							$inn = 0;
			
							while($num_rows11 > $inn) {
								//assign the variables to the array
								while($rows11 = mysql_fetch_assoc($result11)) {
									$jobName = $rows11['job_name'];
									$custName = $rows11['cust_name'];
									$jobName8 = substr($jobName, 0, 8);
									$custName8 = substr($custName, 0, 8);
									$name2displayBlock1 = $custName8.": ".$jobName8;
									$linksTitle = $custName.": ".$jobName;
								}
								$inn++;
							}
						}
						$in++;
					}
				// display block 1
				if(isset($_GET['month'])) {
					$colname = $m."-" . $strPartialName . "-".$day_num."-".$year;
					$editcolDateOfJob = $year."-".$m."-".$day_num;
				} else {
					$colname = date('m')."-" . $strPartialName . "-".$day_num."-".$year;
					$editcolDateOfJob = $year."-".date('m')."-".$day_num;
				}

				if($num_rows10 > 1){
					$multipleJobs = "multipleJobs";
				} else {
					$multipleJobs = "";
				}
					
				echo "<div id=\"".$colname."\" class=\"mockContentTD2 ". $multipleJobs."\">";
				if ($mode =="edit") {
					echo "<a class=\"iframe ".$editcolDisplayCSS."\" style=\"display:block;width:100%;height: 100%;\" href=\"editcol.php?userID=".$userID."&editSelector=".$colname."&color=".$strdeptColor."&foreman=block1&editcolJob=".$editcolJobID."&editcolLocation=".$editcolLocationID."&editcolVan=".$editcolVanID."&editcolApprentice=".$editcolApprenticeID."&editcolEquipment=".$editcolEquipmentID."\">".$name2displayBlock1;
				} else {
					echo "<a class=\"iframe ".$editcolDisplayCSS."\" style=\"display:block;width:100%;height: 100%;\" href=\"viewjobinfo.php?job_id=".$editcolJobID."\">".$name2displayBlock1;
				}
				echo "<span class='tooltipStyle1'>".$linksTitle."</span></a>";
				echo "</div>";
				
				$name2displayBlock1 = "";
				$jobName = "";
				$custName = "";
				$linksTitle = "";
				$editcolJobID = "";
				$editcolLocationID = "";
				$editcolVanID = "";
				$editcolApprenticeID = "";
				$editcolEquipmentID = "";

				/* ************************************************** */
				/*                    set up block 2                  */
				/* ************************************************** */
					$sql10 = "SELECT * FROM schedule WHERE jobdate = '$editcolDateOfJob' AND deptid = '$currentDepartment' AND block2 = '1'";
					$result10 = mysql_query($sql10);
					if(!$result10) {
						$message  = 'Invalid query: ' . mysql_error() . "\n";
						$message .= 'Whole query: ' . $result10;
						die($message);
					};

					$num_rows10 = mysql_num_rows($result10);
					$in = 0;

					while($num_rows10 > $in) {
						//assign the variables to the array
						while($rows10 = mysql_fetch_assoc($result10)) {
							$editcolJobID = $rows10['idjobs'];
							$editcolLocationID = $rows10['locationid'];
							$editcolVanID = $rows10['vanid'];
							$editcolApprenticeID = $rows10['apprenticeid'];
							$editcolEquipmentID = $rows10['equipid'];
							$editcolFinalize = $rows10['finalize'];
							if($editcolFinalize == "0"){
								$editcolDisplayCSS = "displaySaved";
							} else {
								$editcolDisplayCSS = "displayFinalized";
							}
							
							$sql11 = "SELECT idjobs, job_name, idcustomer, cust_name FROM jobs JOIN company ON jobs.company_idcustomer = company.idcustomer WHERE idjobs='$editcolJobID'";
							$result11 = mysql_query($sql11);
							if(!$result11) {
								$message  = 'Invalid query: ' . mysql_error() . "\n";
								$message .= 'Whole query: ' . $result11;
								die($message);
							};

							$num_rows11 = mysql_num_rows($result11);
							$inn = 0;
			
							while($num_rows11 > $inn) {
								//assign the variables to the array
								while($rows11 = mysql_fetch_assoc($result11)) {
									$jobName = $rows11['job_name'];
									$custName = $rows11['cust_name'];
									$jobName8 = substr($jobName, 0, 8);
									$custName8 = substr($custName, 0, 8);
									$name2displayBlock2 = $custName8.": ".$jobName8;
									$linksTitle = $custName.": ".$jobName;
								}
								$inn++;
							}
						}
						$in++;
					}
				// display block 2
				if(isset($_GET['month'])) {
					$colname = $m."-" . $strPartialName . "-".$day_num."-".$year;
					$editcolDateOfJob = $year."-".$m."-".$day_num;
				} else {
					$colname = date('m')."-" . $strPartialName . "-".$day_num."-".$year;
					$editcolDateOfJob = $year."-".date('m')."-".$day_num;
				}
				
				if($num_rows10 > 1){
					$multipleJobs = "multipleJobs";
				} else {
					$multipleJobs = "";
				}
					
				echo "<div id=\"".$colname."\" class=\"mockContentTD2 ".$multipleJobs."\">";
				if ($mode =="edit") {
					echo "<a class=\"iframe ".$editcolDisplayCSS."\" style=\"display:block;width:100%;height: 100%;\" href=\"editcol.php?userID=".$userID."&editSelector=".$colname."&color=".$strdeptColor."&foreman=block2&editcolJob=".$editcolJobID."&editcolLocation=".$editcolLocationID."&editcolVan=".$editcolVanID."&editcolApprentice=".$editcolApprenticeID."&editcolEquipment=".$editcolEquipmentID."\">".$name2displayBlock2;
				} else {
					echo "<a class=\"iframe ".$editcolDisplayCSS."\" style=\"display:block;width:100%;height: 100%;\" href=\"viewjobinfo.php?job_id=".$editcolJobID."\">".$name2displayBlock2;
				}
				echo "<span class='tooltipStyle1'>".$linksTitle."</span></a>";
				echo "</div>";

				$name2displayBlock2 = "";
				$jobName = "";
				$custName = "";
				$linksTitle = "";
				$editcolJobID = "";
				$editcolLocationID = "";
				$editcolVanID = "";
				$editcolApprenticeID = "";
				$editcolEquipmentID = "";
				
				echo "</div>";		// end the mock table row
				$day_num++;	
				$cols = 1;
				$day_num1++;
				$day_add1++;
			}
		}
		echo '</div>';	//end mock table for content
		echo "</div>";		//end menu's content
		echo "</div>";		//end menu item's content
	} 
	$in++;
}

/**********************************************/
/*     create the rest of the menu items      */
/**********************************************/
//query for departments to be displayed first
$sql0 = "SELECT * FROM departments WHERE name != (SELECT name FROM foremen INNER JOIN departments ON foremen.deptid = departments.iddepartments WHERE foremen.employeeid = '$userID' AND departments.schedulecolor IS NOT NULL GROUP BY departments.name ORDER BY departments.name ASC)  AND departments.schedulecolor IS NOT NULL";
$result0 = mysql_query($sql0);
if(!$result0) {
	$message  = 'Invalid query: ' . mysql_error() . "\n";
	$message .= 'Whole query: ' . $result0;
	die($message);
};

$num_rows0 = mysql_num_rows($result0);

$in = 0;

while($num_rows0 > $in) {
	//assign the variables to the array
	while($rows0 = mysql_fetch_assoc($result0)) {
		//build the "displayed first" accordian boxes
		$deptFirstDisplayed[] = $rows0['iddepartments'];
		$currentDepartment = $rows0['iddepartments'];
		$currentDepartmentName = $rows0['name'];
		$deptColor = $rows0['schedulecolor'];
		$strdeptColor = substr($deptColor, 1, 7);

		/* set up for dynamic class assignment and menuBar creation */
		if($currentDepartment == 1){$classDeptName = "electrical";  echo "<div id='menuItem' style='background-color:".$deptColor."'> <div id='" . $classDeptName . "Bar' class='colapsedMenu'>E<br />l<br />e<br />c<br />t<br />r<br />i<br />c<br />a<br />l<br /></div> <div id='" . $classDeptName . "Content' class='floatL'>";}
		if($currentDepartment == 2){$classDeptName = "foundations"; echo "<div id='menuItem' style='background-color:".$deptColor."'> <div id='" . $classDeptName . "Bar' class='colapsedMenu'>F<br />o<br />u<br />n<br />d<br />a<br />t<br />i<br />o<br />n<br />s<br /></div> <div id='" . $classDeptName . "Content' class='floatL'>";}
		if($currentDepartment == 3){$classDeptName = "carpentry"; echo "<div id='menuItem' style='background-color:".$deptColor."'> <div id='" . $classDeptName . "Bar' class='colapsedMenu'>C<br />a<br />r<br />p<br />e<br />n<br />t<br />r<br />y<br /></div> <div id='" . $classDeptName . "Content' class='floatL'>";}
		if($currentDepartment == 4){$classDeptName = "pipefitting"; echo "<div id='menuItem' style='background-color:".$deptColor."'> <div id='" . $classDeptName . "Bar' class='colapsedMenu'>P<br />i<br />p<br />e<br />&nbsp;<br />f<br />i<br />t<br />t<br />i<br />n<br />g<br /></div> <div id='" . $classDeptName . "Content' class='floatL'>";}
		if($currentDepartment == 5){$classDeptName = "riggings"; echo "<div id='menuItem' style='background-color:".$deptColor."'> <div id='" . $classDeptName . "Bar' class='colapsedMenu'>R<br />i<br />g<br />g<br />i<br />n<br />g<br />s<br /></div> <div id='" . $classDeptName . "Content' class='floatL'>";}
		if($currentDepartment == 6){$classDeptName = "hvac"; echo "<div id='menuItem' style='background-color:".$deptColor."'> <div id='" . $classDeptName . "Bar' class='colapsedMenu'>H<br />V<br />A<br />C<br /></div> <div id='" . $classDeptName . "Content' class='floatL'>";}
		if($currentDepartment == 7){$classDeptName = "painters"; echo "<div id='menuItem' style='background-color:".$deptColor."'> <div id='" . $classDeptName . "Bar' class='colapsedMenu'>P<br />a<br />i<br />n<br />t<br />e<br />r<br />s<br /></div> <div id='" . $classDeptName . "Content' class='floatL'>";}
		if($currentDepartment == 8){$classDeptName = "mob"; echo "<div id='menuItem' style='background-color:".$deptColor."'> <div id='" . $classDeptName . "Bar' class='colapsedMenu'>M<br />o<br />b<br />&nbsp;<br />c<br />r<br />e<br />w<br /></div> <div id='" . $classDeptName . "Content' class='floatL'>";}
		if($currentDepartment == 10){$classDeptName = "shop"; echo "<div id='menuItem' style='background-color:".$deptColor."'> <div id='" . $classDeptName . "Bar' class='colapsedMenu'>S<br />h<br />o<br />p<br />&nbsp;<br />g<br />u<br />y<br />s<br /></div> <div id='" . $classDeptName . "Content' class='floatL'>";}
		
		// create the content cells
		echo '<div class="mockContentTable '.$rows0['name'].'">';
		
		$sql = "select * from foremen where deptid = '$currentDepartment'";
		$result = mysql_query($sql);
		if(!$result) { $message  = 'Invalid query: ' . mysql_error() . "\n"; $message .= 'Whole query: ' . $result; die($message); }
		$num_stake = mysql_num_rows($result);
		
		$day_num = 1;
		$cols = 1;
		
		while($days_in_month >= $day_num) {
			$day_num1 = 1;
			$day_add1 = 0;

			//count up the days, until we've done all of them in the month
			while ( $day_num1 <= $days_in_month ) { 
				$day_of_week =  mktime(0,0,0,$month, 1+$day_add1, $year) ; 

				if ((date('l',$day_of_week)!="Saturday")&&(date('l',$day_of_week)!="Sunday")){
					echo "<div class='mockContentRow weekday'>";
					$isWeekend = "0";
				} else {
					$isWeekend = "1";
					echo "<div class='mockContentRow weekend'>";
				}
				
				if ($day_num < 10) {
					$day_num = "0".$day_num;
				}
				
				while($cols <= $num_stake) {
					if (isset($rows0['foremanid'])) {$jobID = $rows0['foremanid'];}
					$strTempPartialName = strtolower($currentDepartmentName);
					$strPartialName = substr($strTempPartialName, 0, 3);
					
					if(isset($_GET['month'])) {
						$colname = $m."-" . $strPartialName . "-".$day_num."-".$cols."-".$year;
						$editcolDateOfJob = $year."-".$m."-".$day_num;
					} else {
						if ($cols < 10) {
							$cols = "0".$cols;
						}
						$colname = date('m')."-" . $strPartialName . "-".$day_num."-".$cols."-".$year;
						$editcolDateOfJob = $year."-".date('m')."-".$day_num;
					}
					
					/***************************************************/
					/*       get the foreman's info for querying       */
					/***************************************************/
					$sql = "select * from foremen where deptid = '$currentDepartment'";
					$result = mysql_query($sql);
					if(!$result) {
						$message  = 'Invalid query: ' . mysql_error() . "\n";
						$message .= 'Whole query: ' . $result;
						die($message);
					};

					$num_rows = mysql_num_rows($result);
					$it = 1;		//counter

					if ($cols){
						do {
							$rows = mysql_fetch_array($result);
							$strForeman = $rows['employeeid'];
							$it++;
						} while ($it <= $cols);
						
						$sql = "SELECT * FROM employees WHERE idemployees='$strForeman'";
						
						$result = mysql_query($sql);
						if(!$result) {
							$message  = 'Invalid query: ' . mysql_error() . "\n";
							$message .= 'Whole query: ' . $result;
							die($message);
						};
						$num_rows = mysql_num_rows($result);
						$ii = 0;

						while($num_rows >$ii){
							while($rows = mysql_fetch_array($result)){
								$idOfTheForeman = $rows['idemployees'];
								$displayQueryPiece = "foremanid = ".$idOfTheForeman;
							}
							$ii++;
						}
					} 
					/***************************************************/
					/*           end fetching foreman's info           */
					/***************************************************/
					
					//select the job based on the date, foreman, and department while looping through
					$sql10 = "SELECT * FROM schedule WHERE jobdate = '$editcolDateOfJob' AND deptid = '$currentDepartment' AND ".$displayQueryPiece."";
					$result10 = mysql_query($sql10);
					if(!$result10) {
						$message  = 'Invalid query: ' . mysql_error() . "\n";
						$message .= 'Whole query: ' . $result10;
						die($message);
					};

					$num_rows10 = mysql_num_rows($result10);
					$in = 0;

					while($num_rows10 > $in) {
						//assign the variables to the array
						while($rows10 = mysql_fetch_assoc($result10)) {
							$editcolJobID = $rows10['idjobs'];
							$editcolLocationID = $rows10['locationid'];
							$editcolVanID = $rows10['vanid'];
							$editcolApprenticeID = $rows10['apprenticeid'];
							$editcolEquipmentID = $rows10['equipid'];
							$editcolFinalize = $rows10['finalize'];
							if($editcolFinalize == "0"){
								$editcolDisplayCSS = "displaySaved";
							} else {
								$editcolDisplayCSS = "displayFinalized";
							}
							
							$sql11 = "SELECT idjobs, job_name, idcustomer, cust_name FROM jobs JOIN company ON jobs.company_idcustomer = company.idcustomer WHERE idjobs='$editcolJobID'";
							$result11 = mysql_query($sql11);
							if(!$result11) {
								$message  = 'Invalid query: ' . mysql_error() . "\n";
								$message .= 'Whole query: ' . $result11;
								die($message);
							};

							$num_rows11 = mysql_num_rows($result11);
							$inn = 0;
			
							while($num_rows11 > $inn) {
								//assign the variables to the array
								while($rows11 = mysql_fetch_assoc($result11)) {
									$jobName = $rows11['job_name'];
									$custName = $rows11['cust_name'];
									$jobName8 = substr($jobName, 0, 8);
									$custName8 = substr($custName, 0, 8);
									$name2display = $custName8." : ".$jobName8;
									$linksTitle = $custName." : ".$jobName;
								}
								$inn++;
							}
						}
						$in++;
					}
					
					if($num_rows10 > 1){
						$multipleJobs = "multipleJobs";
					} else {
						$multipleJobs = "";
					}
					
					echo "<div id=\"".$colname."\" class=\"mockContentTD2 ".$multipleJobs."\">";
					if ($mode =="edit") {
						echo "<a class=\"iframe ".$editcolDisplayCSS."\" style=\"display:block;width:100%;height: 100%;\" href=\"editcol.php?userID=".$userID."&editSelector=".$colname."&color=".$strdeptColor."&foreman=".$idOfTheForeman."&editcolJob=".$editcolJobID."&editcolLocation=".$editcolLocationID."&editcolVan=".$editcolVanID."&editcolApprentice=".$editcolApprenticeID."&editcolEquipment=".$editcolEquipmentID."\">".$name2display;
					} else {
						echo "<a class=\"iframe ".$editcolDisplayCSS."\" style=\"display:block;width:100%;height: 100%;\" href=\"viewjobinfo.php?job_id=".$editcolJobID."\">".$name2display;
					}
					echo "<span class='tooltipStyle1'>".$linksTitle."</span></a>";
					echo "</div>";
					
					$cols++;
					$jobName = "";
					$custName = "";
					$name2display = "";
					$linksTitle = "";
					$editcolJobID = "";
					$editcolLocationID = "";
					$editcolVanID = "";
					$editcolApprenticeID = "";
					$editcolEquipmentID = "";
				}
				
				/* ************************************************** */
				/*                    set up block 1                  */
				/* ************************************************** */
					$sql10 = "SELECT * FROM schedule WHERE jobdate = '$editcolDateOfJob' AND deptid = '$currentDepartment' AND block1 = '1'";
					$result10 = mysql_query($sql10);
					if(!$result10) {
						$message  = 'Invalid query: ' . mysql_error() . "\n";
						$message .= 'Whole query: ' . $result10;
						die($message);
					};

					$num_rows10 = mysql_num_rows($result10);
					$in = 0;

					while($num_rows10 > $in) {
						//assign the variables to the array
						while($rows10 = mysql_fetch_assoc($result10)) {
							$editcolJobID = $rows10['idjobs'];
							$editcolLocationID = $rows10['locationid'];
							$editcolVanID = $rows10['vanid'];
							$editcolApprenticeID = $rows10['apprenticeid'];
							$editcolEquipmentID = $rows10['equipid'];
							$editcolFinalize = $rows10['finalize'];
							if($editcolFinalize == "0"){
								$editcolDisplayCSS = "displaySaved";
							} else {
								$editcolDisplayCSS = "displayFinalized";
							}
							
							$sql11 = "SELECT idjobs, job_name, idcustomer, cust_name FROM jobs JOIN company ON jobs.company_idcustomer = company.idcustomer WHERE idjobs='$editcolJobID'";
							$result11 = mysql_query($sql11);
							if(!$result11) {
								$message  = 'Invalid query: ' . mysql_error() . "\n";
								$message .= 'Whole query: ' . $result11;
								die($message);
							};

							$num_rows11 = mysql_num_rows($result11);
							$inn = 0;
			
							while($num_rows11 > $inn) {
								//assign the variables to the array
								while($rows11 = mysql_fetch_assoc($result11)) {
									$jobName = $rows11['job_name'];
									$custName = $rows11['cust_name'];
									$jobName8 = substr($jobName, 0, 8);
									$custName8 = substr($custName, 0, 8);
									$name2displayBlock1 = $custName8." : ".$jobName8;
									$linksTitle = $custName." : ".$jobName;
								}
								$inn++;
							}
						}
						$in++;
					}
				// display block 1
				if(isset($_GET['month'])) {
					$colname = $m."-" . $strPartialName . "-".$day_num."-".$year;
					$editcolDateOfJob = $year."-".$m."-".$day_num;
				} else {
					$colname = date('m')."-" . $strPartialName . "-".$day_num."-".$year;
					$editcolDateOfJob = $year."-".date('m')."-".$day_num;
				}
				
				if($num_rows10 > 1){
					$multipleJobs = "multipleJobs";
				} else {
					$multipleJobs = "";
				}
					
				echo "<div id=\"".$colname."\" class=\"mockContentTD2 ".$multipleJobs."\">";
				if ($mode =="edit") {
					echo "<a class=\"iframe ".$editcolDisplayCSS."\" style=\"display:block;width:100%;height: 100%;\" href=\"editcol.php?userID=".$userID."&editSelector=".$colname."&color=".$strdeptColor."&foreman=block1&editcolJob=".$editcolJobID."&editcolLocation=".$editcolLocationID."&editcolVan=".$editcolVanID."&editcolApprentice=".$editcolApprenticeID."&editcolEquipment=".$editcolEquipmentID."\">".$name2displayBlock1;
				} else {
					echo "<a class=\"iframe ".$editcolDisplayCSS."\" style=\"display:block;width:100%;height: 100%;\" href=\"viewjobinfo.php?job_id=".$editcolJobID."\">".$name2displayBlock1;
				}
				echo "<span class='tooltipStyle1'>".$linksTitle."</span></a>";
				echo "</div>";

				$name2displayBlock1 = "";
				$jobName = "";
				$custName = "";
				$linksTitle = "";
				$editcolJobID = "";
				$editcolLocationID = "";
				$editcolVanID = "";
				$editcolApprenticeID = "";
				$editcolEquipmentID = "";

				/* ************************************************** */
				/*                    set up block 2                  */
				/* ************************************************** */
					$sql10 = "SELECT * FROM schedule WHERE jobdate = '$editcolDateOfJob' AND deptid = '$currentDepartment' AND block2 = '1'";
					$result10 = mysql_query($sql10);
					if(!$result10) {
						$message  = 'Invalid query: ' . mysql_error() . "\n";
						$message .= 'Whole query: ' . $result10;
						die($message);
					};

					$num_rows10 = mysql_num_rows($result10);
					$in = 0;

					while($num_rows10 > $in) {
						//assign the variables to the array
						while($rows10 = mysql_fetch_assoc($result10)) {
							$editcolJobID = $rows10['idjobs'];
							$editcolLocationID = $rows10['locationid'];
							$editcolVanID = $rows10['vanid'];
							$editcolApprenticeID = $rows10['apprenticeid'];
							$editcolEquipmentID = $rows10['equipid'];
							$editcolFinalize = $rows10['finalize'];
							if($editcolFinalize == "0"){
								$editcolDisplayCSS = "displaySaved";
							} else {
								$editcolDisplayCSS = "displayFinalized";
							}
							
							$sql11 = "SELECT idjobs, job_name, idcustomer, cust_name FROM jobs JOIN company ON jobs.company_idcustomer = company.idcustomer WHERE idjobs='$editcolJobID'";
							$result11 = mysql_query($sql11);
							if(!$result11) {
								$message  = 'Invalid query: ' . mysql_error() . "\n";
								$message .= 'Whole query: ' . $result11;
								die($message);
							};

							$num_rows11 = mysql_num_rows($result11);
							$inn = 0;
			
							while($num_rows11 > $inn) {
								//assign the variables to the array
								while($rows11 = mysql_fetch_assoc($result11)) {
									$jobName = $rows11['job_name'];
									$custName = $rows11['cust_name'];
									$jobName8 = substr($jobName, 0, 8);
									$custName8 = substr($custName, 0, 8);
									$name2displayBlock2 = $custName8." : ".$jobName8;
									$linksTitle = $custName." : ".$jobName;
								}
								$inn++;
							}
						}
						$in++;
					}
				// display block 2
				if(isset($_GET['month'])) {
					$colname = $m."-" . $strPartialName . "-".$day_num."-".$year;
					$editcolDateOfJob = $year."-".$m."-".$day_num;
				} else {
					$colname = date('m')."-" . $strPartialName . "-".$day_num."-".$year;
					$editcolDateOfJob = $year."-".date('m')."-".$day_num;
				}
				
				if($num_rows10 > 1){
					$multipleJobs = "multipleJobs";
				} else {
					$multipleJobs = "";
				}
					
				echo "<div id=\"".$colname."\" class=\"mockContentTD2 ".$multipleJobs."\">";
				if ($mode =="edit") {
					echo "<a class=\"iframe ".$editcolDisplayCSS."\" style=\"display:block;width:100%;height: 100%;\" href=\"editcol.php?userID=".$userID."&editSelector=".$colname."&color=".$strdeptColor."&foreman=block2&editcolJob=".$editcolJobID."&editcolLocation=".$editcolLocationID."&editcolVan=".$editcolVanID."&editcolApprentice=".$editcolApprenticeID."&editcolEquipment=".$editcolEquipmentID."\">".$name2displayBlock2; 
				} else {
					echo "<a class=\"iframe ".$editcolDisplayCSS."\" style=\"display:block;width:100%;height: 100%;\" href=\"viewjobinfo.php?job_id=".$editcolJobID."\">".$name2displayBlock2;
				}
				echo "<span class='tooltipStyle1'>".$linksTitle."</span></a>";
				echo "</div>";

				$name2displayBlock2 = "";
				$jobName = "";
				$custName = "";
				$linksTitle = "";
				$editcolJobID = "";
				$editcolLocationID = "";
				$editcolVanID = "";
				$editcolApprenticeID = "";
				$editcolEquipmentID = "";
				
				echo "</div>";		// end the mock table row
				$day_num++;	
				$cols = 1;
				$day_num1++;
				$day_add1++;
			}
		}
		echo '</div>';	//end mock table for content
		echo "</div>";		//end menu's content
		echo "</div>";		//end menu item's content
	} 
	$in++;
}

/**********************************************/
/*     create the active jobs menu item       */
/**********************************************/
// query for a list of active jobs
$sql0 = "SELECT idjobs, job_name, idcustomer, cust_name FROM jobs JOIN company ON jobs.company_idcustomer = company.idcustomer WHERE progress <> 'declined' AND progress <> 'finished' OR progress IS NULL";
$result0 = mysql_query($sql0);
if(!$result0) {
	$message  = 'Invalid query: ' . mysql_error() . "\n";
	$message .= 'Whole query: ' . $result0;
	die($message);
};

$num_rows0 = mysql_num_rows($result0);
$in = 0;

echo "<div id='menuItem'> <div id='activeJobsBar' class='colapsedMenuEnd'>A<br />C<br />T<br />I<br />V<br />E<br />&nbsp;<br />J<br />O<br />B<br />S<br /></div> <div id='activeJobsContent' class='floatL'>";
echo '<table border="1" class="activeJobs"><tr><td style="width:250px">JOB NAME</td><td style="width:250px">CUSTOMER NAME</td></tr>'; 

		
while($num_rows0 > $in) {
	//assign the variables to the array
	while($rows0 = mysql_fetch_assoc($result0)) {
		$jobID = $rows0['idjobs'];
		$jobName = $rows0['job_name'];
		$custID = $rows0['idcustomer'];
		$custName = $rows0['cust_name'];
		
		echo "<tr><td>".$jobName."</td><td>".$custName."</td></tr>"; 
	}
	$in++;
}

echo "</table>";	//end table for content
echo "</div>";		//end menu's content
echo "</div>";		//end menu item's content

echo "</div>";		//end accWrapper div
?>

<!-- here we set up our holders for different functionality -->
<div id="prntMsgNotification"></div>
<div id="openLastViewed"></div>
</div>
</body>
</html>
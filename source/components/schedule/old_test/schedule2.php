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
if($month == 'jan') {
	$month = date('Y')."-01-01";
	$month = strtotime($month);
	$m = '1';
} elseif($month == 'feb') {
	$month = date('Y')."-02-01";
	$month = strtotime($month);
	$m = '2';
} elseif($month == 'march') {
	$month = date('Y')."-03-01";
	$month = strtotime($month);
	$m = '3';
} elseif($month == 'april') {
	$month = date('Y')."-04-01";
	$month = strtotime($month);
	$m = '4';
} elseif($month == 'may') {
	$month = date('Y')."-05-01";
	$month = strtotime($month);
	$m = '5';
} elseif($month == 'june') {
	$month = date('Y')."-06-01";
	$month = strtotime($month);
	$m = '6';
} elseif($month == 'july') {
	$month = date('Y')."-07-01";
	$month = strtotime($month);
	$m = '7';
} elseif($month == 'aug') {
	$month = date('Y')."-08-01";
	$month = strtotime($month);
	$m = '8';
} elseif($month == 'sep') {
	$month = date('Y')."-09-01";
	$month = strtotime($month);
	$m = '9';
} elseif($month == 'oct') {
	$month = date('Y')."-10-01";
	$month = strtotime($month);
	$m = '10';
} elseif($month == 'nov') {
	$month = date('Y')."-11-01";
	$month = strtotime($month);
	$m = '11';
} elseif($month == 'dec') {
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
//set up the navigation for month to month
echo "<div class=\"calendar\"><table class=\"cal\"><tr><td class=\"calendarTitle\" colspan=\"2\"><a href=\"schedule2.php?userID=11&month=".$previousMonth."&year=".$previousYear."\" target=\"_self\"><</a> ". $title . " <a href=\"schedule2.php?userID=11&month=".$nextMonth."&year=".$nextYear."\" target=\"_self\">></a></td></tr>";

//count up the days, until we've done all of them in the month
while ( $day_num <= $days_in_month ) { 
	$day_of_week =  mktime(0,0,0,$month, 1+$day_add, $year) ; 


	if ((date('l',$day_of_week)!="Saturday")&&(date('l',$day_of_week)!="Sunday")){
		echo "<tr class='weekday'>";
		echo "<td>". date('l',$day_of_week)."</td>";
	} else {
		echo "<tr class='weekend'>";
		echo "<td>". date('l',$day_of_week)."</td>";
	}

	if ($day_num < 10) {
		$day_num = "0".$day_num;
	}
	echo "<td class=\"calEndRow\">".  $day_num ."</td>"; 
	echo "</tr>";
	
	$day_num++;
	$day_add++;
} 
 echo "</table></div>";


/* top bar wrapper */
echo '<div class="topBar">';

//		//		//		//		//	//
// temp system to get the user id	//
$userID = $_GET["userID"];			//
//		//		//		//		//	//

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
		
		echo '<div class="headerSpacerIE">&nbsp;</div>';			//this is the width of the menu bars for proper alignment
		echo '<table id="topBarTable" class="floatyTable '.$strPartialName.'TopBar"><tr>';
		
			$sql1 = "select * from foremen where deptid = '$currentDepartment'";
			$result1 = mysql_query($sql1);
			if(!$result1) { $message  = 'Invalid query: ' . mysql_error() . "\n"; $message .= 'Whole query: ' . $result1; die($message); };
			$num_rows = mysql_num_rows($result1);
			$i = 0;
			while($num_rows > $i) {
				echo '<td style="background-color:'.$bgColor.';">'.$currentDepartmentName.'</td>';
				$i++;
			}
			// add the 2 "block"s at the end
			echo '<td style="background-color:'.$bgColor.';">'.$currentDepartmentName.'</td><td style="background-color:'.$bgColor.';">'.$currentDepartmentName.'</td></tr><tr>';
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
					if ($num_rows = $i) {
						echo '<td style="background-color:'.$bgColor.';" class="topEndRow">'.$first_name1.' '.$last_name1.'</td>';
					} else {
						echo "<td style='background-color:".$bgColor.";'>".$first_name1.' '.$last_name1."</td>";
					}
				}
			}
		// add the 2 blocks at the end
		echo '<td style="background-color:'.$bgColor.';">block</td><td style="background-color:'.$bgColor.';">block</td></tr></table>';
	}

	$in++;
}

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

/**********************************************/
/*          make rest of the top bar          */
/**********************************************/
while($num_rows0 > $in) {
	//assign the variables to the array
	while($rows0 = mysql_fetch_assoc($result0)) {
	
		//build the rest of the accordian boxes
		$bgColor = $rows0['schedulecolor'];
		$currentDepartment = $rows0['iddepartments'];
		$currentDepartmentName = strtolower($rows0['name']);
		$strPartialName = substr($currentDepartmentName, 0, 3);
		
		echo '<div class="headerSpacerIE">&nbsp;</div>';
		echo '<table class="floatyTable '.$strPartialName.'TopBar"><tr>';
		
			$sql2 = "select * from foremen where deptid = '$currentDepartment'";
			$result2 = mysql_query($sql2);
			if(!$result2) { $message  = 'Invalid query: ' . mysql_error() . "\n"; $message .= 'Whole query: ' . $result2; die($message); };
			$num_rows = mysql_num_rows($result2);
			$i = 0;
			while($num_rows > $i) {
				echo '<td style="background-color:'.$bgColor.'; width:125px;">'.$currentDepartmentName.'</td>';
				$i++;
			}
			// add the 2 "block"s at the end
			echo '<td style="background-color:'.$bgColor.'; width:125px;">'.$currentDepartmentName.'</td><td style="background-color:'.$bgColor.'; width:125px;">'.$currentDepartmentName.'</td></tr><tr>';
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
					echo "<td style='background-color:".$bgColor."; width:125px;'>".$first_name2.' '.$last_name2."</td>";
				}
			}
		echo '<td style="background-color:'.$bgColor.'; width:125px;">block</td><td style="background-color:'.$bgColor.'; width:125px;">block</td></tr></table>';
	}
	$in++;
}
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
		if($currentDepartment == 1){$classDeptName = "electrical";  echo "<div id='menuItem'> <div id='" . $classDeptName . "Bar' class='colapsedMenu'>E<br />l<br />e<br />c<br />t<br />r<br />i<br />c<br />a<br />l<br /></div> <div id='" . $classDeptName . "Content' class='floatL'>";}
		if($currentDepartment == 2){$classDeptName = "foundations"; echo "<div id='menuItem'> <div id='" . $classDeptName . "Bar' class='colapsedMenu'>F<br />o<br />u<br />n<br />d<br />a<br />t<br />i<br />o<br />n<br />s<br /></div> <div id='" . $classDeptName . "Content' class='floatL'>";}
		if($currentDepartment == 3){$classDeptName = "carpentry"; echo "<div id='menuItem'> <div id='" . $classDeptName . "Bar' class='colapsedMenu'>C<br />a<br />r<br />p<br />e<br />n<br />t<br />r<br />y<br /></div> <div id='" . $classDeptName . "Content' class='floatL'>";}
		if($currentDepartment == 4){$classDeptName = "pipefitting"; echo "<div id='menuItem'> <div id='" . $classDeptName . "Bar' class='colapsedMenu'>P<br />i<br />p<br />e<br />&nbsp;<br />f<br />i<br />t<br />t<br />i<br />n<br />g<br /></div> <div id='" . $classDeptName . "Content' class='floatL'>";}
		if($currentDepartment == 5){$classDeptName = "riggings"; echo "<div id='menuItem'> <div id='" . $classDeptName . "Bar' class='colapsedMenu'>R<br />i<br />g<br />g<br />i<br />n<br />g<br />s<br /></div> <div id='" . $classDeptName . "Content' class='floatL'>";}
		if($currentDepartment == 6){$classDeptName = "hvac"; echo "<div id='menuItem'> <div id='" . $classDeptName . "Bar' class='colapsedMenu'>H<br />V<br />A<br />C<br /></div> <div id='" . $classDeptName . "Content' class='floatL'>";}
		if($currentDepartment == 7){$classDeptName = "painters"; echo "<div id='menuItem'> <div id='" . $classDeptName . "Bar' class='colapsedMenu'>P<br />a<br />i<br />n<br />t<br />e<br />r<br />s<br /></div> <div id='" . $classDeptName . "Content' class='floatL'>";}
		if($currentDepartment == 8){$classDeptName = "mob"; echo "<div id='menuItem'> <div id='" . $classDeptName . "Bar' class='colapsedMenu'>M<br />o<br />b<br />&nbsp;<br />c<br />r<br />e<br />w<br /></div> <div id='" . $classDeptName . "Content' class='floatL'>";}
		if($currentDepartment == 10){$classDeptName = "shop"; echo "<div id='menuItem'> <div id='" . $classDeptName . "Bar' class='colapsedMenu'>S<br />h<br />o<br />p<br />&nbsp;<br />g<br />u<br />y<br />s<br /></div> <div id='" . $classDeptName . "Content' class='floatL'>";}
		
		// create the content cells
		echo '<table class="'.$rows0['name'].'">';
		
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
					echo "<tr class='weekday'>";
					$isWeekend = "0";
				} else {
					$isWeekend = "1";
					echo "<tr class='weekend'>";
				}
				
				if ($m < 10) {
					$m = "0".$m;
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
									$name2display = $custName8.":".$jobName8;
									$linksTitle = $custName.":".$jobName;
								}
								$inn++;
							}
						}
						$in++;
					}
					
					echo "<td id=\"".$colname."\" style=\"width:125px\">";
					echo "<a class=\"iframe ".$editcolDisplayCSS."\" style=\"display:block;width:100%;\" href=\"editcol.php?editSelector=".$colname."&color=".$strdeptColor."&foreman=".$editcolJobID."&editcolJob=".$editcolJobID."&editcolLocation=".$editcolLocationID."&editcolVan=".$editcolVanID."&editcolApprentice=".$editcolApprenticeID."&editcolEquipment=".$editcolEquipmentID."\">".$name2display."&nbsp;";
					echo "<span class='tooltipStyle1'>".$linksTitle."</span></a>";
					echo "</td>";
					
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
									$name2displayBlock1 = $jobName8.":".$custName8;
									$linksTitle = $custName.":".$jobName;
								}
								$inn++;
							}
						}
						$in++;
					}
				// display block 1
				$colname = date('m') . "-" . $strPartialName . "-" . $day_num . "-" . $year;
					echo "<td id=\"".$colname."\" style=\"width:125px\">";
					echo "<a class=\"iframe ".$editcolDisplayCSS."\" style=\"display:block;width:100%;\" href=\"editcol.php?editSelector=".$colname."&color=".$strdeptColor."&foreman=block1&editcolJob=".$editcolJobID."&editcolLocation=".$editcolLocationID."&editcolVan=".$editcolVanID."&editcolApprentice=".$editcolApprenticeID."&editcolEquipment=".$editcolEquipmentID."\">".$name2displayBlock1."&nbsp;";
					echo "<span class='tooltipStyle1'>".$linksTitle."</span></a>";
					echo "</td>";

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
									$name2displayBlock2 = $custName8.":".$jobName8;
									$linksTitle = $custName.":".$jobName;
								}
								$inn++;
							}
						}
						$in++;
					}
				// display block 2
				$colname = date('m') . "-" . $strPartialName . "-" . $day_num . "-" . $year;
				echo "<td id=\"" . $colname . "\" style=\"width:125px\">";
				echo "<a class=\"iframe ".$editcolDisplayCSS."\" style=\"display:block;width:100%;\" href=\"editcol.php?editSelector=".$colname."&color=".$strdeptColor."&foreman=block1&editcolJob=".$editcolJobID."&editcolLocation=".$editcolLocationID."&editcolVan=".$editcolVanID."&editcolApprentice=".$editcolApprenticeID."&editcolEquipment=".$editcolEquipmentID."\">".$name2displayBlock2."&nbsp;"; 
					echo "<span class='tooltipStyle1'>".$linksTitle."</span></a>";
					echo "</td>";

				$name2displayBlock2 = "";
				$jobName = "";
				$custName = "";
				$linksTitle = "";
				$editcolJobID = "";
				$editcolLocationID = "";
				$editcolVanID = "";
				$editcolApprenticeID = "";
				$editcolEquipmentID = "";
				
				echo "</tr>";
				$day_num++;	
				$cols = 1;
				$day_num1++;
				$day_add1++;
			}
		}
		echo '</table>';	//end table for content
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
		if($currentDepartment == 1){$classDeptName = "electrical";  echo "<div id='menuItem'> <div id='" . $classDeptName . "Bar' class='colapsedMenu'>E<br />l<br />e<br />c<br />t<br />r<br />i<br />c<br />a<br />l<br /></div> <div id='" . $classDeptName . "Content' class='floatL'>";}
		if($currentDepartment == 2){$classDeptName = "foundations"; echo "<div id='menuItem'> <div id='" . $classDeptName . "Bar' class='colapsedMenu'>F<br />o<br />u<br />n<br />d<br />a<br />t<br />i<br />o<br />n<br />s<br /></div> <div id='" . $classDeptName . "Content' class='floatL'>";}
		if($currentDepartment == 3){$classDeptName = "carpentry"; echo "<div id='menuItem'> <div id='" . $classDeptName . "Bar' class='colapsedMenu'>C<br />a<br />r<br />p<br />e<br />n<br />t<br />r<br />y<br /></div> <div id='" . $classDeptName . "Content' class='floatL'>";}
		if($currentDepartment == 4){$classDeptName = "pipefitting"; echo "<div id='menuItem'> <div id='" . $classDeptName . "Bar' class='colapsedMenu'>P<br />i<br />p<br />e<br />&nbsp;<br />f<br />i<br />t<br />t<br />i<br />n<br />g<br /></div> <div id='" . $classDeptName . "Content' class='floatL'>";}
		if($currentDepartment == 5){$classDeptName = "riggings"; echo "<div id='menuItem'> <div id='" . $classDeptName . "Bar' class='colapsedMenu'>R<br />i<br />g<br />g<br />i<br />n<br />g<br />s<br /></div> <div id='" . $classDeptName . "Content' class='floatL'>";}
		if($currentDepartment == 6){$classDeptName = "hvac"; echo "<div id='menuItem'> <div id='" . $classDeptName . "Bar' class='colapsedMenu'>H<br />V<br />A<br />C<br /></div> <div id='" . $classDeptName . "Content' class='floatL'>";}
		if($currentDepartment == 7){$classDeptName = "painters"; echo "<div id='menuItem'> <div id='" . $classDeptName . "Bar' class='colapsedMenu'>P<br />a<br />i<br />n<br />t<br />e<br />r<br />s<br /></div> <div id='" . $classDeptName . "Content' class='floatL'>";}
		if($currentDepartment == 8){$classDeptName = "mob"; echo "<div id='menuItem'> <div id='" . $classDeptName . "Bar' class='colapsedMenu'>M<br />o<br />b<br />&nbsp;<br />c<br />r<br />e<br />w<br /></div> <div id='" . $classDeptName . "Content' class='floatL'>";}
		if($currentDepartment == 10){$classDeptName = "shop"; echo "<div id='menuItem'> <div id='" . $classDeptName . "Bar' class='colapsedMenu'>S<br />h<br />o<br />p<br />&nbsp;<br />g<br />u<br />y<br />s<br /></div> <div id='" . $classDeptName . "Content' class='floatL'>";}
		
		// create the content cells
		echo '<table class="'.$rows0['name'].'">';
		
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
					echo "<tr class='weekday'>";
					$isWeekend = "0";
				} else {
					$isWeekend = "1";
					echo "<tr class='weekend'>";
				}
				
				if ($m < 10) {
					$m = "0".$m;
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
									$name2display = $jobName8.":".$custName8;
								}
								$inn++;
							}
						}
						$in++;
					}
					
					echo "<td id=\"".$colname."\" style=\"width:125px\"><a class=\"iframe ".$editcolDisplayCSS."\" style=\"display:block;width:100%;\" href=\"viewcol.php?editSelector=".$colname."&color=".$strdeptColor."&editcolJob=".$editcolJobID."&editcolLocation=".$editcolLocationID."&editcolVan=".$editcolVanID."&editcolApprentice=".$editcolApprenticeID."&editcolEquipment=".$editcolEquipmentID."\">".$name2display."&nbsp;</a></td>"; 

					$cols++;
					$name2display = "";
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
									$name2displayBlock1 = $jobName8.":".$custName8;
								}
								$inn++;
							}
						}
						$in++;
					}
				// display block 2
				$colname = date('m') . "-" . $strPartialName . "-" . $day_num."-".$year;
				echo "<td id=\"" . $colname . "\" style=\"width:125px\"><a class=\"iframe ".$editcolDisplayCSS."\" style=\"display:block;width:100%;\" href=\"editcol.php?editSelector=".$colname."&color=".$strdeptColor."&foreman=block1&editcolJob=".$editcolJobID."&editcolLocation=".$editcolLocationID."&editcolVan=".$editcolVanID."&editcolApprentice=".$editcolApprenticeID."&editcolEquipment=".$editcolEquipmentID."\">".$name2displayBlock1."&nbsp;</a></td>"; 

				$name2displayBlock1 = "";
				$editcolJobID = "";
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
									$name2displayBlock2 = $jobName8.":".$custName8;
								}
								$inn++;
							}
						}
						$in++;
					}
				// display block 2
				$colname = date('m') . "-" . $strPartialName . "-" . $day_num."-".$year;
				echo "<td id=\"" . $colname . "\" style=\"width:125px\"><a class=\"iframe ".$editcolDisplayCSS."\" style=\"display:block;width:100%;\" href=\"editcol.php?editSelector=".$colname."&color=".$strdeptColor."&foreman=block2&editcolJob=".$editcolJobID."&editcolLocation=".$editcolLocationID."&editcolVan=".$editcolVanID."&editcolApprentice=".$editcolApprenticeID."&editcolEquipment=".$editcolEquipmentID."\">".$name2displayBlock2."&nbsp;</a></td>"; 

				$name2displayBlock2 = "";
				$editcolJobID = "";
				$editcolJobID = "";
				$editcolLocationID = "";
				$editcolVanID = "";
				$editcolApprenticeID = "";
				$editcolEquipmentID = "";
				
				echo "</tr>";
				$day_num++;	
				$cols = 1;
				$day_num1++;
				$day_add1++;
			}
		}
		echo '</table>';	//end table for content
		echo "</div>";		//end menu's content
		echo "</div>";		//end menu item's content
	}
	$in++;
}

/**********************************************/
/*     create the active jobs menu item       */
/**********************************************/
// query for a list of active jobs
$sql0 = "SELECT idjobs, job_name, idcustomer, cust_name FROM jobs JOIN company ON jobs.company_idcustomer = company.idcustomer WHERE progress <> 'declined' AND progress <> 'fished' OR progress IS NULL";
$result0 = mysql_query($sql0);
if(!$result0) {
	$message  = 'Invalid query: ' . mysql_error() . "\n";
	$message .= 'Whole query: ' . $result0;
	die($message);
};

$num_rows0 = mysql_num_rows($result0);
$in = 0;

echo "<div id='menuItem'> <div id='activeJobsBar' class='colapsedMenu'>A<br />C<br />T<br />I<br />V<br />E<br />&nbsp;<br />J<br />O<br />B<br />S<br /></div> <div id='activeJobsContent' class='floatL'>";
echo '<table class="activeJobs"><tr><td style="width:250px">JOB NAME</td><td style="width:250px">CUSTOMER NAME</td></tr>'; 

		
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
</div>
</body>
</html>
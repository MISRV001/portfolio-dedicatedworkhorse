<html>
<head>
	<title>schedule Test</title>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/schedule.css" />
	<script language="JavaScript" src="js/schedule.js"></SCRIPT>
	<script language="JavaScript" src="js/scrollyThing2.js"></SCRIPT>
	<script type="text/javascript" src="../../../scripts/jquery.fancybox/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
	<link rel="stylesheet" href="../../../scripts/jquery.fancybox/fancybox/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />
<style>
body { margin: 0; padding: 0;}
#accWrapper{position: relative;width:2500;left:115;top:60;}
.topBar{position:fixed; overflow:auto; top:0; left:115; text-align:left !important; background-color:#FFFFFF; float:left; z-index: 99;}
.calendar{position:fixed; overflow:auto; top:0; left:0; text-align:center; background-color:#EAEAEA; width:104px; float:left; z-index: 9999;}
.floatyTable{position:relative;display: inline}
</style>
<?php
include('../../../includes/db.php');
echo '<div class="wrapper">';

if(isset($_GET['month'])) {
	$month = $_GET['month'];
} else {
	$month = time();
}

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
$year = date('Y', $date) ;

//Here we generate the first day of the month 
$first_day = mktime(0,0,0,$month, $day, $year) ; 
$days_in_month = cal_days_in_month(0, $month, $year) ; 
$title = date('M-y', $first_day) ;
$day_num = 1;
$day_add = 0;

echo "</head><body>";
echo "<table class=\"calendar\" border=\"1\">";
echo "<tr class=\"year\"><td colspan=\"2\">". $title . "</td></tr>";

//count up the days, untill we've done all of them in the month
while ( $day_num <= $days_in_month )  { 
	$day_of_week =  mktime(0,0,0,$month, 1+$day_add, $year) ; 
	echo "<tr>";
	echo "<td>". date('l',$day_of_week)."</td>";
	echo "<td> $day_num </td>"; 
	echo "</tr>";
 
	$day_num++;
	$day_add++;
} 

echo "</table>";
/*the top table goes here */

/* wrapper */
echo '<div class="topBar">';

//		//		//		//		//	//
// temp system to get the user id	//
$userID = $_GET["userID"];			//
//		//		//		//		//	//

//query for departments to be displayed first
$sql0 = "SELECT * FROM departments INNER JOIN employees_dept ON employees_dept.iddepartments = departments.iddepartments WHERE employees_dept.idemployees = '$userID' AND departments.schedulecolor IS NOT NULL GROUP BY employees_dept.iddepartments ORDER BY departments.name ASC";
$result0 = mysql_query($sql0);
if(!$result0) {
	$message  = 'Invalid query: ' . mysql_error() . "\n";
	$message .= 'Whole query: ' . $result0;
	die($message);
};

$num_rows0 = mysql_num_rows($result0);

$in = 0;

/**********************************************/
/*            make the top bar                */
/**********************************************/
while($num_rows0 > $in) {
	//assign the variables to the array
	while($rows0 = mysql_fetch_assoc($result0)) {
	
		//build the "displayed first" accordian boxes
		$bgColor = $rows0['schedulecolor'];
		$currentDepartment = $rows0['iddepartments'];
		$currentDepartmentName = strtolower($rows0['name']);
		$strPartialName = substr($currentDepartmentName, 0, 3);
		
		echo '<div class="headerSpacer">&nbsp;</div>';
		echo '<table border="1" class="floatyTable" id="'.$strPartialName.'TopBar"><tr>';
		
			$sql = "select * from foremen where deptid = '$currentDepartment'";
			$result = mysql_query($sql);
			if(!$result) { $message  = 'Invalid query: ' . mysql_error() . "\n"; $message .= 'Whole query: ' . $result; die($message); };
			$num_rows = mysql_num_rows($result);
			$i = 0;
			while($num_rows > $i) {
				echo '<td style="background-color:'.$bgColor.'; width:125px;">'.$currentDepartmentName.'</td>';
				$i++;
			}
			echo '</tr><tr>';
			while($rows = mysql_fetch_assoc($result)) {
				$ids[] = $rows['employeeid'];
			}
			foreach($ids as $id) {
				$sql = "SELECT * FROM employees_dept, employees WHERE employees_dept.idemployees=employees.idemployees AND employees.idemployees = '$id' AND employees_dept.iddepartments='$currentDepartment' GROUP BY employees_dept.idemployees";
				$result = mysql_query($sql);
				if(!$result) { $message  = 'Invalid query: ' . mysql_error() . "\n"; $message .= 'Whole query: ' . $result; die($message); }
				
				while($rows = mysql_fetch_assoc($result)) {
					$first_name = $rows['first_name'];
					$last_name = $rows['last_name'];
					echo "<td style='background-color:".$bgColor."; width:125px;'>".$first_name.' '.$last_name."</td>";
				}
			}
		echo '</tr></table>';
	}

	$in++;
}
echo "</div>";


/**********************************************/
/*          create the menu items             */
/**********************************************/
//query for departments to be displayed first
$sql0 = "SELECT * FROM departments INNER JOIN employees_dept ON employees_dept.iddepartments = departments.iddepartments WHERE employees_dept.idemployees = '$userID' AND departments.schedulecolor IS NOT NULL GROUP BY employees_dept.iddepartments ORDER BY departments.name ASC";
$result0 = mysql_query($sql0);
if(!$result0) {
	$message  = 'Invalid query: ' . mysql_error() . "\n";
	$message .= 'Whole query: ' . $result0;
	die($message);
};

$num_rows0 = mysql_num_rows($result0);

$in = 0;

// set up the content wrapper
echo '<div id="accWrapper">';
while($num_rows0 > $in) {
	//assign the variables to the array
	while($rows0 = mysql_fetch_assoc($result0)) {
		//build the "displayed first" accordian boxes
		$deptFirstDisplayed[] = $rows0['iddepartments'];
		$currentDepartment = $rows0['iddepartments'];
		$currentDepartmentName = $rows0['name'];

	/* set up for dynamic class assignment and menuBar creation */
	if($currentDepartment == 1){$classDeptName = "electrical";  echo "<div id='menuItem'> <div id='" . $classDeptName . "Bar' class='colapsedMenu'>e<br />l<br />e<br />c<br />t<br />r<br />i<br />c<br />a<br />l<br /></div> <div id='" . $classDeptName . "Content' class='floatL'>";}
	if($currentDepartment == 2){$classDeptName = "foundations"; echo "<div id='menuItem'> <div id='" . $classDeptName . "Bar' class='colapsedMenu'>f<br />o<br />u<br />n<br />d<br />a<br />t<br />i<br />o<br />n<br />s<br /></div> <div id='" . $classDeptName . "Content' class='floatL'>";}
	if($currentDepartment == 3){$classDeptName = "carpentry"; echo "<div id='menuItem'> <div id='" . $classDeptName . "Bar' class='colapsedMenu'>c<br />a<br />r<br />p<br />e<br />n<br />t<br />r<br />y<br /></div> <div id='" . $classDeptName . "Content' class='floatL'>";}
	if($currentDepartment == 4){$classDeptName = "pipefitting"; echo "<div id='menuItem'> <div id='" . $classDeptName . "Bar' class='colapsedMenu'>p<br />i<br />p<br />e<br />&nbsp;<br />f<br />i<br />t<br />t<br />i<br />n<br />g<br /></div> <div id='" . $classDeptName . "Content' class='floatL'>";}
	if($currentDepartment == 5){$classDeptName = "rigging"; echo "<div id='menuItem'> <div id='" . $classDeptName . "Bar' class='colapsedMenu'>r<br />i<br />g<br />g<br />i<br />n<br />g<br />s<br /></div> <div id='" . $classDeptName . "Content' class='floatL'>";}
	if($currentDepartment == 6){$classDeptName = "hvac"; echo "<div id='menuItem'> <div id='" . $classDeptName . "Bar' class='colapsedMenu'>H<br />V<br />A<br />C<br /></div> <div id='" . $classDeptName . "Content' class='floatL'>";}
	if($currentDepartment == 7){$classDeptName = "painter"; echo "<div id='menuItem'> <div id='" . $classDeptName . "Bar' class='colapsedMenu'>p<br />a<br />i<br />n<br />t<br />e<br />r<br />s<br /></div> <div id='" . $classDeptName . "Content' class='floatL'>";}
	if($currentDepartment == 8){$classDeptName = "mob"; echo "<div id='menuItem'> <div id='" . $classDeptName . "Bar' class='colapsedMenu'>m<br />o<br />b<br />&nbsp;<br />c<br />r<br />e<br />w<br /></div> <div id='" . $classDeptName . "Content' class='floatL'>";}
	if($currentDepartment == 10){$classDeptName = "shop"; echo "<div id='menuItem'> <div id='" . $classDeptName . "Bar' class='colapsedMenu'>s<br />h<br />o<br />p<br />&nbsp;<br />g<br />u<br />y<br />s<br /></div> <div id='" . $classDeptName . "Content' class='floatL'>";}
	
		// create the content cells
		echo '<table border="1" class="'.$rows0['name'].'">';
		
		$sql = "select * from foremen where deptid = '$currentDepartment'";
		$result = mysql_query($sql);
		if(!$result) { $message  = 'Invalid query: ' . mysql_error() . "\n"; $message .= 'Whole query: ' . $result; die($message); }
		$num_stake = mysql_num_rows($result);
		
		$day_num = 1;
		$cols = 1;
		
		while($days_in_month >= $day_num) {
			echo "<tr>";
			while($cols <= $num_stake) {
				$strTempPartialName = strtolower($currentDepartmentName);
				$strPartialName = substr($strTempPartialName, 0, 3);
				
				if(isset($_GET['month'])) {
					$colname = $m."-" . $strPartialName . "-".$day_num."-".$cols;
				} else {
					$colname = date('n')."-" . $strPartialName . "-".$day_num."-".$cols;
				}
				echo "<td id=\"".$colname."\" style=\"width:125px\"><a class=\"iframe\" href=\"editcol.php?editSelector=".$colname."\">".$colname."</a></td>"; 
				$cols++;
			}
			echo "</tr>";
			$day_num++;	
			$cols = 1;
		}
		echo '</table>';	//end table for content
	echo "</div>";		//end menu's content

	}
	$in++;
}



//query for departments to be displayed first
$sql0 = "SELECT * FROM departments INNER JOIN employees_dept ON employees_dept.iddepartments = departments.iddepartments WHERE employees_dept.idemployees <> '$userID' AND departments.schedulecolor IS NOT NULL GROUP BY employees_dept.iddepartments ORDER BY departments.name ASC";
$result0 = mysql_query($sql0);
if(!$result0) {
	$message  = 'Invalid query: ' . mysql_error() . "\n";
	$message .= 'Whole query: ' . $result0;
	die($message);
};

$num_rows0 = mysql_num_rows($result0);

$in = 0;

/**********************************************/
/*            make the top bar                */
/**********************************************/
while($num_rows0 > $in) {
	//assign the variables to the array
	while($rows0 = mysql_fetch_assoc($result0)) {
	
		//build the "displayed first" accordian boxes
		$bgColor = $rows0['schedulecolor'];
		$currentDepartment = $rows0['iddepartments'];
		$currentDepartmentName = strtolower($rows0['name']);
		$strPartialName = substr($currentDepartmentName, 0, 3);
		
		echo '<div class="headerSpacer">&nbsp;</div>';
		echo '<table border="1" class="floatyTable" id="'.$strPartialName.'TopBar"><tr>';
		
			$sql = "select * from foremen where deptid = '$currentDepartment'";
			$result = mysql_query($sql);
			if(!$result) { $message  = 'Invalid query: ' . mysql_error() . "\n"; $message .= 'Whole query: ' . $result; die($message); };
			$num_rows = mysql_num_rows($result);
			$i = 0;
			while($num_rows > $i) {
				echo '<td style="background-color:'.$bgColor.'; width:125px;">'.$currentDepartmentName.'</td>';
				$i++;
			}
			echo '</tr><tr>';
			while($rows = mysql_fetch_assoc($result)) {
				$ids[] = $rows['employeeid'];
			}
			foreach($ids as $id) {
				$sql = "SELECT * FROM employees_dept, employees WHERE employees_dept.idemployees=employees.idemployees AND employees.idemployees = '$id' AND employees_dept.iddepartments='$currentDepartment' GROUP BY employees_dept.idemployees";
				$result = mysql_query($sql);
				if(!$result) { $message  = 'Invalid query: ' . mysql_error() . "\n"; $message .= 'Whole query: ' . $result; die($message); }
				
				while($rows = mysql_fetch_assoc($result)) {
					$first_name = $rows['first_name'];
					$last_name = $rows['last_name'];
					echo "<td style='background-color:".$bgColor."; width:125px;'>".$first_name.' '.$last_name."</td>";
				}
			}
		echo '</tr></table>';
	}

	$in++;
}
echo "</div>";


/**********************************************/
/*          create the menu items             */
/**********************************************/
//query for departments to be displayed first
$sql0 = "SELECT * FROM departments INNER JOIN employees_dept ON employees_dept.iddepartments = departments.iddepartments WHERE employees_dept.idemployees <> '$userID' AND departments.schedulecolor IS NOT NULL GROUP BY employees_dept.iddepartments ORDER BY departments.name ASC";
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

	/* set up for dynamic class assignment and menuBar creation */
	if($currentDepartment == 1){$classDeptName = "electrical";  echo "<div id='menuItem'> <div id='" . $classDeptName . "Bar' class='colapsedMenu'>e<br />l<br />e<br />c<br />t<br />r<br />i<br />c<br />a<br />l<br /></div> <div id='" . $classDeptName . "Content' class='floatL'>";}
	if($currentDepartment == 2){$classDeptName = "foundations"; echo "<div id='menuItem'> <div id='" . $classDeptName . "Bar' class='colapsedMenu'>f<br />o<br />u<br />n<br />d<br />a<br />t<br />i<br />o<br />n<br />s<br /></div> <div id='" . $classDeptName . "Content' class='floatL'>";}
	if($currentDepartment == 3){$classDeptName = "carpentry"; echo "<div id='menuItem'> <div id='" . $classDeptName . "Bar' class='colapsedMenu'>c<br />a<br />r<br />p<br />e<br />n<br />t<br />r<br />y<br /></div> <div id='" . $classDeptName . "Content' class='floatL'>";}
	if($currentDepartment == 4){$classDeptName = "pipefitting"; echo "<div id='menuItem'> <div id='" . $classDeptName . "Bar' class='colapsedMenu'>p<br />i<br />p<br />e<br />&nbsp;<br />f<br />i<br />t<br />t<br />i<br />n<br />g<br /></div> <div id='" . $classDeptName . "Content' class='floatL'>";}
	if($currentDepartment == 5){$classDeptName = "riggings"; echo "<div id='menuItem'> <div id='" . $classDeptName . "Bar' class='colapsedMenu'>r<br />i<br />g<br />g<br />i<br />n<br />g<br />s<br /></div> <div id='" . $classDeptName . "Content' class='floatL'>";}
	if($currentDepartment == 6){$classDeptName = "hvac"; echo "<div id='menuItem'> <div id='" . $classDeptName . "Bar' class='colapsedMenu'>H<br />V<br />A<br />C<br /></div> <div id='" . $classDeptName . "Content' class='floatL'>";}
	if($currentDepartment == 7){$classDeptName = "painters"; echo "<div id='menuItem'> <div id='" . $classDeptName . "Bar' class='colapsedMenu'>p<br />a<br />i<br />n<br />t<br />e<br />r<br />s<br /></div> <div id='" . $classDeptName . "Content' class='floatL'>";}
	if($currentDepartment == 8){$classDeptName = "mob"; echo "<div id='menuItem'> <div id='" . $classDeptName . "Bar' class='colapsedMenu'>m<br />o<br />b<br />&nbsp;<br />c<br />r<br />e<br />w<br /></div> <div id='" . $classDeptName . "Content' class='floatL'>";}
	if($currentDepartment == 10){$classDeptName = "shop"; echo "<div id='menuItem'> <div id='" . $classDeptName . "Bar' class='colapsedMenu'>s<br />h<br />o<br />p<br />&nbsp;<br />g<br />u<br />y<br />s<br /></div> <div id='" . $classDeptName . "Content' class='floatL'>";}
	
		// create the content cells
		echo '<table border="1" class="'.$rows0['name'].'">';
		
		$sql = "select * from foremen where deptid = '$currentDepartment'";
		$result = mysql_query($sql);
		if(!$result) { $message  = 'Invalid query: ' . mysql_error() . "\n"; $message .= 'Whole query: ' . $result; die($message); }
		$num_stake = mysql_num_rows($result);
		
		$day_num = 1;
		$cols = 1;
		
		while($days_in_month >= $day_num) {
			echo "<tr>";
			while($cols <= $num_stake) {
				$strTempPartialName = strtolower($currentDepartmentName);
				$strPartialName = substr($strTempPartialName, 0, 3);
				
				if(isset($_GET['month'])) {
					$colname = $m."-" . $strPartialName . "-".$day_num."-".$cols;
				} else {
					$colname = date('n')."-" . $strPartialName . "-".$day_num."-".$cols;
				}
				echo "<td id=\"".$colname."\" style=\"width:125px\"><a class=\"iframe\" href=\"editcol.php?editSelector=".$colname."\">".$colname."</a></td>"; 
				$cols++;
			}
			echo "</tr>";
			$day_num++;	
			$cols = 1;
		}
		echo '</table>';	//end table for content
	echo "</div>";		//end menu's content

	}
	$in++;
}




















echo "</div>";		//end accWrapper div

?>

</div>
</body>
</html>












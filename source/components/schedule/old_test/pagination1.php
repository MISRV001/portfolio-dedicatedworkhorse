<?php
//include the DB
include('../../../includes/db.php');

// get the variables necessary for functionality
if(isset($_GET['editSelector'])){$editcolMaster = $_GET['editSelector'];}
if(isset($_GET['foreman'])){$editcolForeman = $_GET['foreman'];}
if(isset($_GET['editSelector'])){$editcolMonth = substr($editcolMaster, 0, 2);}
if(isset($_GET['editSelector'])){$editcolDay = substr($editcolMaster, 7, 2);}
if(isset($_GET['editSelector'])){$editcolDept = substr($editcolMaster, 3, 3);}
if(isset($_GET['dateOfJobs'])){$date = $_GET['dateOfJobs'];}

// figure out if it is assigned or a block element
if(($editcolForeman!='block1')&&($editcolForeman!='block2')){
	$editcolColumn = substr($editcolMaster, 10, 2);
	$editcolYear = substr($editcolMaster, 13, 4);
} else {
	$editcolYear = substr($editcolMaster, 10, 4);
}

// assemble dates
$date = $editcolYear."/".$editcolMonth."/".$editcolDay;
$displayDate = $editcolMonth."/".$editcolDay."/".$editcolYear;

// process getted variables
// parse the department
switch ($editcolDept){
	case "ele":
		$editcolDept = "Electrical";
		$currentDepartment = 1;
		break;
	case "car":
		$editcolDept = "Carpentry";
		$currentDepartment = 3;
		break;	
	case "pip":
		$editcolDept = "Pipe Fitting";
		$currentDepartment = 4;
		break;	
	case "fou":
		$editcolDept = "Foundations";
		$currentDepartment = 2;
		break;
	case "rig":
		$editcolDept = "Riggings";
		$currentDepartment = 5;
		break;	
	case "pai":
		$editcolDept = "Painters";
		$currentDepartment = 7;
		break;
	case "mob":
		$editcolDept = "Mob Crew";
		$currentDepartment = 8;
		break;	
	case "sho":
		$editcolDept = "Shop Guys";
		$currentDepartment = 10;
		break;	
	case "hva":
		$editcolDept = "HVAC";
		$currentDepartment = 6;
		break;
}

$sql = "SELECT COUNT(*) FROM schedule WHERE deptid = $currentDepartment AND foremanid = '$editcolForeman' AND jobdate = '$date'";		// find out how many rows are in the table 
$result = mysql_query($sql);
$r = mysql_fetch_row($result);
$numrows = $r[0];

$rowsperpage = 1;									// number of rows to show per page
$totalpages = ceil($numrows / $rowsperpage);		// find out total pages

// get the current page or set a default
if (isset($_GET['currentpage']) && is_numeric($_GET['currentpage'])) {
   $currentpage = (int) $_GET['currentpage'];
} else {
   $currentpage = 1;   // default page num
}

// if current page is greater than total pages...and you're a complete boob!
if ($currentpage > $totalpages) {
   $currentpage = $totalpages;
}

// if current page is less than first page...and again...if you're a complete boob!
if ($currentpage < 1) {
   $currentpage = 1;
}

$offset = ($currentpage - 1) * $rowsperpage;

$sql = "SELECT * FROM schedule WHERE deptid = '$currentDepartment' AND foremanid = '$editcolForeman' AND jobdate = '$date' LIMIT $offset, $rowsperpage";
$result = mysql_query($sql);

if(!$result) {
	$message  = 'Invalid query: ' . mysql_error() . "\n";
	$message .= 'Whole query: ' . $result;
	die($message);
};

$num_rows = mysql_num_rows($result);
$i = 0;

/************************************************/
/*             display the content              */
/************************************************/
if ($num_rows > 0) {			// IF THERE IS INFO ALREADY ASSIGNED TO THIS DATE
	while($num_rows > $i) {
		//assign the variables to the array
		while ($list = mysql_fetch_assoc($result)) {
			// assign the variables for this job
			if(isset($list['scheduleid'])){$scheduleid = $list['scheduleid'];}
			if(isset($list['deptid'])){$deptid = $list['deptid'];}
			if(isset($list['foremanid'])){$foremanid = $list['foremanid'];}
			if(isset($list['apprenticeid'])){$apprenticeid = $list['apprenticeid'];}
			if(isset($list['vanid'])){$vanid = $list['vanid'];}
			if(isset($list['equipid'])){$equipid = $list['equipid'];}
			if(isset($list['idjobs'])){$idjobs = $list['idjobs'];}
			if(isset($list['locationid'])){$locationid = $list['locationid'];}
			if(isset($list['jobdate'])){$jobdate = $list['jobdate'];}
			if(isset($list['comments'])){$comments = $list['comments'];}
			if(isset($list['finalize'])){$finalize = $list['finalize'];}
			
			if($editcolForeman == "block1"){
				$last_name = "Time 1";
				$block1 = "<input type='hidden' id='editcolBlock1' name='editcolBlock1' value='block1' />";
				$block2 = "";
			}elseif($editcolForeman == "block2"){
				$last_name = "Time 2";
				$block1 = "";
				$block2 = "<input type='hidden' id='editcolBlock2' name='editcolBlock2' value='block2' />";
			}else{
				$block1 = "";
				$block2 = "";
			}
			
			//echo $list['scheduleid']." = ".$editcolDept." = ".$editcolForeman." = ".$date." = ".$location."-".$scheduleid."-".$deptid."-".$foremanid."-".$apprenticeid."-".$vanid."-".$equipid."-".$idjobs."-".$locationid."-".$jobdate."-".$block1."-".$block2."-".$comments."-".$finalize;
			
			// get the foreman's name
			$sql = "SELECT * FROM employees WHERE idemployees='$foremanid'";
			
			$result = mysql_query($sql);
			if(!$result) {
				$message  = 'Invalid query: ' . mysql_error() . "\n";
				$message .= 'Whole query: ' . $result;
				die($message);
			};
			
			$num_rows = mysql_num_rows($result);
			$ii = 0;		//counter
			while($num_rows >$ii){
				while($rows = mysql_fetch_array($result)){
					$first_name = $rows['first_name'];
					$last_name = $rows['last_name'];
				}
				$ii++;
			}
			
			// get the border color
			$sql = "SELECT schedulecolor FROM departments WHERE iddepartments='$deptid'";
			
			$result = mysql_query($sql);
			if(!$result) {
				$message  = 'Invalid query: ' . mysql_error() . "\n";
				$message .= 'Whole query: ' . $result;
				die($message);
			};
			
			$num_rows = mysql_num_rows($result);
			$ii = 0;		//counter
			while($num_rows >$ii){
				while($rows = mysql_fetch_array($result)){
					$borderColor = $rows['schedulecolor'];
				}
				$ii++;
			}
			
			?>
			<html>
			<head>
				<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
				<script type="text/javascript" src="js/editcol.js"></script>
			</head>
			<body>
			<div id="msgWrapper">
				<div class="topWrapper" style="border: thick solid <?php echo $borderColor; ?>; margin-bottom:10px;">
					<h3 style=" text-align: center"><?php echo $editcolDept; ?> - <?php echo $displayDate; ?></h3>
					<h4 style=" text-align: center"><?php echo $first_name.' '.$last_name; ?></h4> 
					<input type="hidden" id="empID" name="empID" value="<?php echo $foremanid; ?>" />
					<input type="hidden" id="currentDepartment" name="currentDepartment" value="<?php echo $deptid; ?>" />
					<input type="hidden" id="currentJobID" name="currentJobID" value="<?php echo $idjobs; ?>" />
					<input type="hidden" id="editcolYear" name="editcolYear" value="<?php echo $editcolYear; ?>" />
					<input type="hidden" id="editcolMonth" name="editcolMonth" value="<?php echo $editcolMonth; ?>" />
					<input type="hidden" id="editcolDay" name="editcolDay" value="<?php echo $editcolDay; ?>" />
					<input type="hidden" id="currentLocation" name="currentLocation" value="<?php echo $location; ?>" />
					<input type="hidden" id="currentApprentice" name="currentApprentice" value="<?php echo $apprenticeid; ?>" />
					<input type="hidden" id="currentVan" name="currentVan" value="<?php echo $vanid; ?>" />
					<input type="hidden" id="currentEquipment" name="currentEquipment" value="<?php echo $equipid; ?>" />
					<input type="hidden" id="editcolUpdateFlag" name="editcolUpdateFlag" value="<?php if($idjobs<>""){echo "update";}else{echo "insert";} ?>" />
					<input type="hidden" id="editcolDelete" name="editcolDelete" value="0" />
					<input type="hidden" id="currentScheduleID" name="currentScheduleID" value="<?php echo $scheduleid; ?>" />
					<input type="hidden" id="finalized" name="finalized" value="<?php echo $finalize; ?>" />
					<?php echo $block1; ?>
					<?php echo $block2; ?>
				</div>
				<div id="contentWrapper">
					<div id="msgNotification"></div> 
					<table cellpadding="3" cellspacing="0">
					<tr>
						<td>Job</td>
						<td>
							<select id="editcolJob" style="width: 300px">
								<option value="" selected="true">please select a job</option>
								<?php
								//query for departments to be displayed first
								$sql = "SELECT idjobs, job_name FROM jobs WHERE progress <> 'declined' AND progress <> 'finished' OR progress IS NULL";
								$result = mysql_query($sql);
								if(!$result) {
									$message  = 'Invalid query: ' . mysql_error() . "\n";
									$message .= 'Whole query: ' . $result;
									die($message);
								};
								
								$num_rows = mysql_num_rows($result);
								$i = 0;
								
								while($num_rows > $i) {
									while($rows = mysql_fetch_assoc($result)) {
										$jobID = $rows['idjobs'];
										$jobName = $rows['job_name'];
										
										if($jobID <> $idjobs){
											echo '<option value="' . $jobID . '">'. $jobID . ' - ' . $jobName . '</option>';
										} else {
											echo '<option value="' . $jobID . '" selected="true">' . $jobID . ' - ' . $jobName . '</option>';
										}
									}
									$i++;
								}
								?>
							</select>
						</td>
					</tr>
					<tr>
						<td>location</td>
						<td>
							<select id="editcolLocation" style="width: 300px">
								<option value="firstone" selected="true">please select a job</option>
							</select>
						</td>
					</tr>
					<tr>
						<td>Apprentice</td>
						<td>
							<select id="editcolApprentice" style="width: 300px">
								<?php
								// fetch the assigned van number
								$sql = "SELECT first_name, last_name, idemployees FROM employees JOIN foremen_assign ON foremen_assign.apprenticeid = employees.idemployees WHERE foremanid = '$strForeman' GROUP BY last_name";
								$result = mysql_query($sql);
								if(!$result) {
									$message  = 'Invalid query: ' . mysql_error() . "\n";
									$message .= 'Whole query: ' . $result;
									die($message);
								};
								
								$num_rows = mysql_num_rows($result);
								$i = 0;
								
								while($num_rows > $i) {
									while($rows = mysql_fetch_assoc($result)) {
										$apprenNumber1 = $rows['idemployees'];
										$firstname1 = $rows['first_name'];
										$lastname1 = $rows['last_name'];
									}
									$i++;
								}
									
								//query for the rest of the vans
								$sql = "SELECT idemployees, first_name, last_name FROM employees LEFT JOIN foremen ON foremen.employeeid = employees.idemployees WHERE employeeid IS NULL ORDER BY last_name";
								$result = mysql_query($sql);
								if(!$result) {
									$message  = 'Invalid query: ' . mysql_error() . "\n";
									$message .= 'Whole query: ' . $result;
									die($message);
								};
								
								$num_rows = mysql_num_rows($result);
								$i = 0;
								
								echo '<option selected="true">select an apprentice</option>';
								while($num_rows > $i) {
									while($rows = mysql_fetch_assoc($result)) {
										$apprenNumber = $rows['idemployees'];
										$firstname = $rows['first_name'];
										$lastname = $rows['last_name'];
										
										if($apprenNumber <> $apprenticeid){
											echo '<option value="' . $apprenNumber . '">' . $firstname . ' ' . $lastname . '</option>';
										} else {
											echo '<option value="' . $apprenNumber . '" selected="true">' . $firstname . ' ' . $lastname . '</option>';
										}
									}
									$i++;
								}
								?>
							</select>
						</td>
					</tr>
					<tr>
						<td>Van</td>
						<td>
							<select id="editcolVan" style="width: 300px">
								<?php
								// fetch the assigned van number
								$sql = "SELECT vannumber FROM van JOIN foremen_assign ON foremen_assign.vanid = van.vanid WHERE foremanid = '$strForeman' GROUP BY vannumber";
								$result = mysql_query($sql);
								if(!$result) {
									$message  = 'Invalid query: ' . mysql_error() . "\n";
									$message .= 'Whole query: ' . $result;
									die($message);
								};
								
								$num_rows = mysql_num_rows($result);
								$i = 0;
								
								while($num_rows > $i) {
									while($rows = mysql_fetch_assoc($result)) {
										$assignedVanID = $rows['vannumber'];
										$assignedVanNumber = $rows['vannumber'];
									}
									$i++;
								}
									
								//query for the rest of the vans
								$sql = "SELECT * FROM van";
								$result = mysql_query($sql);
								if(!$result) {
									$message  = 'Invalid query: ' . mysql_error() . "\n";
									$message .= 'Whole query: ' . $result;
									die($message);
								};
								
								$num_rows = mysql_num_rows($result);
								$i = 0;
								
								echo '<option selected="true">select a van</option>';
								while($num_rows > $i) {
									while($rows = mysql_fetch_assoc($result)) {
										$vanID = $rows['vanid'];
										$number = $rows['vannumber'];
										
										if($assignedVanID = $vanID){
											echo '<option value="' . $vanID . '" selected="true">' . $number . '</option>';
										} else if($assignedVanID = $vanid) {
											echo '<option value="' . $vanID . '" selected="true">' . $number . '</option>';
										} else {
											echo '<option value="' . $vanID . '">' . $number . '</option>';
										}
									}
									$i++;
								}
								?>
							</select>
						</td>
					</tr>
					<tr>
						<td>Equipment</td>
						<td>
							<select id="editcolEquipment" style="width: 300px">
								<option value='' selected='true'>select a piece of equipment</option>
								<?php
								//query for equipment to be displayed first
								$sql = "SELECT * FROM equipment";
								$result = mysql_query($sql);
								if(!$result) {
									$message  = 'Invalid query: ' . mysql_error() . "\n";
									$message .= 'Whole query: ' . $result;
									die($message);
								};
								
								$num_rows = mysql_num_rows($result);
								$i = 0;
								
								while($num_rows > $i) {
									while($rows = mysql_fetch_assoc($result)) {
										$equipmentID = $rows['equipid'];
										$name = $rows['name'];
										
										if($equipmentID <> $equipid){
											echo '<option value="' . $equipID . '">' . $name . '</option>';
										} else {
											echo '<option value="' . $equipID . '" selected="true">' . $name . '</option>';
										}
									}
									$i++;
								}
								?>
							</select>
						</td>
					</tr>
					<tr>
						<td>Comments</td>
						<td>
							<?php
							$sql = "SELECT comments FROM schedule WHERE (scheduleid= '$scheduleid')";
							
							$result = mysql_query($sql);
							if(!$result) {
								$message  = 'Invalid query: ' . mysql_error() . "\n";
								$message .= 'Whole query: ' . $result;
								die($message);
							};
							
							$num_rows = mysql_num_rows($result);
							$i = 0;

							while($num_rows > $i) {
								while($rows = mysql_fetch_assoc($result)) {
									$comments = $rows['comments'];
									if($comments!=""){echo '<textarea rows="5" cols="35" name="editcolComments" id="editcolComments">'. $comments . '</textarea>';}
								}
								
								$i++;
							}
							if ($comments==""){echo '<textarea rows="4" cols="35" name="editcolComments" id="editcolComments"></textarea>';}
							?>
						</td>
					</tr>
					<tr>
						<td>Copy Until:</td>
						<td>
							<input type="text" name="copyUntil" id="copyUntil" style="width: 250px" />
						</td>
					</tr>

<?php
		}
		$i++;
	}
/**            END IF THERE WAS CONTENT TO DISPLAY             **/
} else {
/**            BEGIN IF THEY CLICKED ON A BLANK CELL           **/
// assign variables
if(isset($_GET['color'])){$borderColor = $_GET['color'];}
if(isset($_GET['editSelector'])){$editcolMaster = $_GET['editSelector'];}
if(isset($_GET['foreman'])){$editcolForeman = $_GET['foreman'];}
if(isset($_GET['editcolJob'])){$editcolJob = $_GET['editcolJob'];}
if(isset($_GET['editSelector'])){$editcolMaster = $_GET['editSelector'];}
if(isset($_GET['foreman'])){$editcolForeman = $_GET['foreman'];}
if(isset($_GET['editSelector'])){$editcolMonth = substr($editcolMaster, 0, 2);}
if(isset($_GET['editSelector'])){$editcolDay = substr($editcolMaster, 7, 2);}
if(isset($_GET['editSelector'])){$editcolDept = substr($editcolMaster, 3, 3);}
if(isset($_GET['dateOfJobs'])){$date = $_GET['dateOfJobs'];}

// figure out if it is assigned or a block element
if(($editcolForeman!='block1')&&($editcolForeman!='block2')){
	$editcolColumn = substr($editcolMaster, 10, 2);
	$editcolYear = substr($editcolMaster, 13, 4);
} else {
	$editcolYear = substr($editcolMaster, 10, 4);
}

// set up the date for the database and display
$editcolMonth = substr($editcolMaster, 0, 2);
$editcolDay = substr($editcolMaster, 7, 2);
$editcolDept = substr($editcolMaster, 3, 3);
$date = $editcolYear."/".$editcolMonth."/".$editcolDay;
$displayDate = $editcolMonth."/".$editcolDay."/".$editcolYear;

// parse the department
switch ($editcolDept){
	case "ele":
		$editcolDept = "Electrical";
		$currentDepartment = 1;
		break;
	case "car":
		$editcolDept = "Carpentry";
		$currentDepartment = 3;
		break;	
	case "pip":
		$editcolDept = "Pipe Fitting";
		$currentDepartment = 4;
		break;	
	case "fou":
		$editcolDept = "Foundations";
		$currentDepartment = 2;
		break;
	case "rig":
		$editcolDept = "Riggings";
		$currentDepartment = 5;
		break;	
	case "pai":
		$editcolDept = "Painters";
		$currentDepartment = 7;
		break;
	case "mob":
		$editcolDept = "Mob Crew";
		$currentDepartment = 8;
		break;	
	case "sho":
		$editcolDept = "Shop Guys";
		$currentDepartment = 10;
		break;	
	case "hva":
		$editcolDept = "HVAC";
		$currentDepartment = 6;
		break;
}

$sql = "select * from foremen where deptid = '$currentDepartment'";
$result = mysql_query($sql);
if(!$result) {
	$message  = 'Invalid query: ' . mysql_error() . "\n";
	$message .= 'Whole query: ' . $result;
	die($message);
};

$num_rows = mysql_num_rows($result);
$i = 1;		//counter

if ($editcolColumn){
	do {
		$rows = mysql_fetch_array($result);
		$strForeman = $rows['employeeid'];
		$i++;
	} while ($i <= $editcolColumn);
	
	$sql = "SELECT * FROM employees WHERE idemployees='$strForeman'";
	
	$result = mysql_query($sql);
	if(!$result) {
		$message  = 'Invalid query: ' . mysql_error() . "\n";
		$message .= 'Whole query: ' . $result;
		die($message);
	};
	$num_rows = mysql_num_rows($result);
	$i = 1;		//counter
	$ii = 0;
	while($num_rows >$ii){
		while($rows = mysql_fetch_array($result)){
			$first_name = $rows['first_name'];
			$last_name = $rows['last_name'];
			$empID = $rows['idemployees'];
		}
		$ii++;
	}
} else {
	$first_name = "Block ";
	if($editcolForeman == "block1"){
		$last_name = "Time 1";
		$block1 = "<input type='hidden' id='editcolBlock1' name='editcolBlock1' value='block1' />";
		$block2 = "";
	}elseif($editcolForeman == "block2"){
		$last_name = "Time 2";
		$block1 = "";
		$block2 = "<input type='hidden' id='editcolBlock2' name='editcolBlock2' value='block2' />";
	}else{
		$block1 = "";
		$block2 = "";
	}
}

?>
			<html>
			<head>
				<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
				<script type="text/javascript" src="js/editcol.js"></script>
			</head>
			<body>
			<div id="msgWrapper">
				<div class="topWrapper" style="border: thick solid <?php echo $borderColor; ?>; margin-bottom:10px;">
					<h3 style=" text-align: center"><?php echo $editcolDept; ?> - <?php echo $displayDate; ?></h3>
					<h4 style=" text-align: center"><?php echo $first_name.' '.$last_name; ?></h4> 
					<input type="hidden" id="empID" name="empID" value="<?php echo $strForeman; ?>" />
					<input type="hidden" id="currentDepartment" name="currentDepartment" value="<?php echo $currentDepartment; ?>" />
					<input type="hidden" id="currentJobID" name="currentJobID" value="<?php echo $idjobs; ?>" />
					<input type="hidden" id="editcolYear" name="editcolYear" value="<?php echo $editcolYear; ?>" />
					<input type="hidden" id="editcolMonth" name="editcolMonth" value="<?php echo $editcolMonth; ?>" />
					<input type="hidden" id="editcolDay" name="editcolDay" value="<?php echo $editcolDay; ?>" />
					<input type="hidden" id="currentLocation" name="currentLocation" value="<?php echo $location; ?>" />
					<input type="hidden" id="currentApprentice" name="currentApprentice" value="<?php echo $apprenticeid; ?>" />
					<input type="hidden" id="currentVan" name="currentVan" value="<?php echo $vanid; ?>" />
					<input type="hidden" id="currentEquipment" name="currentEquipment" value="<?php echo $equipid; ?>" />
					<input type="hidden" id="editcolUpdateFlag" name="editcolUpdateFlag" value="<?php if($idjobs<>""){echo "update";}else{echo "insert";} ?>" />
					<input type="hidden" id="editcolDelete" name="editcolDelete" value="0" />
					<?php echo $block1; ?>
					<?php echo $block2; ?>
				</div>
				<div id="contentWrapper">
					<div id="msgNotification"></div> 
					<table cellpadding="3" cellspacing="0">
					<tr>
						<td>Job</td>
						<td>
							<select id="editcolJob" style="width: 300px">
								<option value="" selected="true">please select a job</option>
								<?php
								//query for departments to be displayed first
								$sql = "SELECT idjobs, job_name FROM jobs WHERE progress <> 'declined' AND progress <> 'finished' OR progress IS NULL";
								$result = mysql_query($sql);
								if(!$result) {
									$message  = 'Invalid query: ' . mysql_error() . "\n";
									$message .= 'Whole query: ' . $result;
									die($message);
								};
								
								$num_rows = mysql_num_rows($result);
								$i = 0;
								
								while($num_rows > $i) {
									while($rows = mysql_fetch_assoc($result)) {
										$jobID = $rows['idjobs'];
										$jobName = $rows['job_name'];
										
										echo '<option value="' . $jobID . '">'. $jobID . ' - ' . $jobName . '</option>';
									}
									$i++;
								}
								?>
							</select>
						</td>
					</tr>
					<tr>
						<td>location</td>
						<td>
							<select id="editcolLocation" style="width: 300px">
								<option value="firstone" selected="true">please select a job</option>
							</select>
						</td>
					</tr>
					<tr>
						<td>Apprentice</td>
						<td>
							<select id="editcolApprentice" style="width: 300px">
								<?php
								// fetch the assigned van number
								$sql = "SELECT first_name, last_name, idemployees FROM employees JOIN foremen_assign ON foremen_assign.apprenticeid = employees.idemployees WHERE foremanid = '$strForeman' GROUP BY last_name";
								$result = mysql_query($sql);
								if(!$result) {
									$message  = 'Invalid query: ' . mysql_error() . "\n";
									$message .= 'Whole query: ' . $result;
									die($message);
								};
								
								$num_rows = mysql_num_rows($result);
								$i = 0;
								
								while($num_rows > $i) {
									while($rows = mysql_fetch_assoc($result)) {
										$apprenNumber1 = $rows['idemployees'];
										$firstname1 = $rows['first_name'];
										$lastname1 = $rows['last_name'];
									}
									$i++;
								}
									
								//query for the rest of the vans
								$sql = "SELECT idemployees, first_name, last_name FROM employees LEFT JOIN foremen ON foremen.employeeid = employees.idemployees WHERE employeeid IS NULL ORDER BY last_name";
								$result = mysql_query($sql);
								if(!$result) {
									$message  = 'Invalid query: ' . mysql_error() . "\n";
									$message .= 'Whole query: ' . $result;
									die($message);
								};
								
								$num_rows = mysql_num_rows($result);
								$i = 0;
								
								echo '<option selected="true">select an apprentice</option>';
								while($num_rows > $i) {
									while($rows = mysql_fetch_assoc($result)) {
										$apprenNumber = $rows['idemployees'];
										$firstname = $rows['first_name'];
										$lastname = $rows['last_name'];
										
										if($apprenNumber <> $apprenNumber1){
											echo '<option value="' . $apprenNumber . '">' . $firstname . ' ' . $lastname . '</option>';
										} else {
											echo '<option value="' . $apprenNumber . '" selected="true">' . $firstname . ' ' . $lastname . '</option>';
										}
									}
									$i++;
								}
								?>
							</select>
						</td>
					</tr>
					<tr>
						<td>Van</td>
						<td>
							<select id="editcolVan" style="width: 300px">
								<?php
								// fetch the assigned van number
								$sql = "SELECT vannumber FROM van JOIN foremen_assign ON foremen_assign.vanid = van.vanid WHERE foremanid = '$strForeman' GROUP BY vannumber";
								$result = mysql_query($sql);
								if(!$result) {
									$message  = 'Invalid query: ' . mysql_error() . "\n";
									$message .= 'Whole query: ' . $result;
									die($message);
								};
								
								$num_rows = mysql_num_rows($result);
								$i = 0;
								
								while($num_rows > $i) {
									while($rows = mysql_fetch_assoc($result)) {
										$assignedVanID = $rows['vannumber'];
										$assignedVanNumber = $rows['vannumber'];
									}
									$i++;
								}
									
								//query for the rest of the vans
								$sql = "SELECT * FROM van";
								$result = mysql_query($sql);
								if(!$result) {
									$message  = 'Invalid query: ' . mysql_error() . "\n";
									$message .= 'Whole query: ' . $result;
									die($message);
								};
								
								$num_rows = mysql_num_rows($result);
								$i = 0;
								
								echo '<option selected="true">select a van</option>';
								while($num_rows > $i) {
									while($rows = mysql_fetch_assoc($result)) {
										$vanID = $rows['vanid'];
										$number = $rows['vannumber'];
										
										if($assignedVanID = $vanID){
											echo '<option value="' . $vanID . '" selected="true">' . $number . '</option>';
										} else if($assignedVanID = $vanid) {
											echo '<option value="' . $vanID . '" selected="true">' . $number . '</option>';
										} else {
											echo '<option value="' . $vanID . '">' . $number . '</option>';
										}
									}
									$i++;
								}
								?>
							</select>
						</td>
					</tr>
					<tr>
						<td>Equipment</td>
						<td>
							<select id="editcolEquipment" style="width: 300px">
								<option value='' selected='true'>select a piece of equipment</option>
								<?php
								//query for equipment to be displayed first
								$sql = "SELECT * FROM equipment";
								$result = mysql_query($sql);
								if(!$result) {
									$message  = 'Invalid query: ' . mysql_error() . "\n";
									$message .= 'Whole query: ' . $result;
									die($message);
								};
								
								$num_rows = mysql_num_rows($result);
								$i = 0;
								
								while($num_rows > $i) {
									while($rows = mysql_fetch_assoc($result)) {
										$equipmentID = $rows['equipid'];
										$name = $rows['name'];
										
										if($equipmentID <> $equipid){
											echo '<option value="' . $equipID . '">' . $name . '</option>';
										} else {
											echo '<option value="' . $equipID . '" selected="true">' . $name . '</option>';
										}
									}
									$i++;
								}
								?>
							</select>
						</td>
					</tr>
					<tr>
						<td>Comments</td>
						<td>
							<?php
							$sql = "SELECT comments FROM schedule WHERE (scheduleid= '$scheduleid')";
							
							$result = mysql_query($sql);
							if(!$result) {
								$message  = 'Invalid query: ' . mysql_error() . "\n";
								$message .= 'Whole query: ' . $result;
								die($message);
							};
							
							$num_rows = mysql_num_rows($result);
							$i = 0;

							while($num_rows > $i) {
								while($rows = mysql_fetch_assoc($result)) {
									$comments = $rows['comments'];
									if($comments!=""){echo '<textarea rows="5" cols="35" name="editcolComments" id="editcolComments">'. $comments . '</textarea>';}
								}
								
								$i++;
							}
							if ($comments==""){echo '<textarea rows="4" cols="35" name="editcolComments" id="editcolComments"></textarea>';}
							?>
						</td>
					</tr>
					<tr>
						<td>Copy Until:</td>
						<td>
							<input type="text" name="copyUntil" id="copyUntil" style="width: 250px" />
						</td>
					</tr>
<?php
}
?>
		<tr>
			<td class="centered" colspan="2">
				<button id="btnSave" name="btnSave">save</button>
				<span class="spacer"> </span>
				<button id="btnClear" name="btnClear">clear</button>
				<span class="spacer"> </span>
				<button id="btnFinalize" name="btnFinalize">finalize</button>
				<span class="spacer"> </span>
				<button id="btnAddRecord" name="btnAddRecord">add another job</button>
			</td>
		</tr>
		<?php
		/**          IF THERE ARE EXTRA PAGES...SHOW THE NAVI CLICKY THINGS           **/
		if($totalpages > 1) {
		?>
		
		<tr>
			<td colspan="2">
				<?php
				/************************************************/
				/*             build the links                  */
				/************************************************/
				$range = 3;			// range of num links to show
				echo "<br /><br />";
				if ($currentpage > 1) {
				   echo "&nbsp;&nbsp;<a href='{$_SERVER['PHP_SELF']}?currentpage=1&editSelector=".$editcolMaster."&foreman=".$editcolForeman."&dateOfJobs=".$date."'><<</a>&nbsp; &nbsp;";
				   $prevpage = $currentpage - 1;
				   echo "&nbsp;&nbsp;<a href='{$_SERVER['PHP_SELF']}?currentpage=$prevpage&editSelector=".$editcolMaster."&foreman=".$editcolForeman."&dateOfJobs=".$date."'><</a>&nbsp; &nbsp;";
				}
				
				// loop to show links to range of pages around current page
				for ($x = ($currentpage - $range); $x < (($currentpage + $range) + 1); $x++) {
				   if (($x > 0) && ($x <= $totalpages)) {
					  if ($x == $currentpage) {
						 echo " [<b>$x</b>] ";
					  } else {
						 echo "&nbsp;&nbsp;<a href='{$_SERVER['PHP_SELF']}?currentpage=$x&editSelector=".$editcolMaster."&foreman=".$editcolForeman."&dateOfJobs=".$date."'>$x</a>&nbsp;&nbsp;";
					  }
				   }
				}
				
				if ($currentpage != $totalpages) {
				   $nextpage = $currentpage + 1;
				   echo "&nbsp;&nbsp;<a href='{$_SERVER['PHP_SELF']}?currentpage=$nextpage&editSelector=".$editcolMaster."&foreman=".$editcolForeman."&dateOfJobs=".$date."'>></a>&nbsp; &nbsp;";
				   echo "&nbsp;&nbsp;<a href='{$_SERVER['PHP_SELF']}?currentpage=$totalpages&editSelector=".$editcolMaster."&foreman=".$editcolForeman."&dateOfJobs=".$date."'>>></a>&nbsp; &nbsp;";
				}
				/**              end build links               **/
				
				?>
			</td>
		</tr>
		<?php
		}
		?>
		</table>
	</div>
</div>
</body>
</html>


















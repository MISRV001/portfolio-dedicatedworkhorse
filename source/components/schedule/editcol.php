<?php
session_start();
$uid = $_SESSION['uid'];
$logon_group = $_SESSION['logon_group'];
$name = $_SESSION['name'];
$username = $_SESSION['username'];
$department = $_SESSION['department'];
$title = $_SESSION['title'];
$email = $_SESSION['email'];
$address = $_SESSION['address'];
$city = $_SESSION['city'];
$state = $_SESSION['state'];
$zip = $_SESSION['zip'];
$cell = $_SESSION['cell'];
/* SIMULATE USER LOG IN */			//		//		//		//		//		//		//		//	//
// Getting URL var by its name																	//
if(isset($_GET['userID'])){$userID = $_GET["userID"];} 
else { $userID = $uid; }										//
if ( $userID == 11 || $userID == 14 || $userID == 15 || $userID == 47 || $userID == 8) {						//
	$_SESSION['userDepartment'] = "Electrical";													//
} else if ( $userID == 16 || $userID == 17 || $userID == 18 ) {									//
	$_SESSION['userDepartment'] = "Foundations";												//
} else if ( $userID == 21 || $userID == 20 || $userID == 19 || $userID == 8) {									//
	$_SESSION['userDepartment'] = "Carpentry";													//
} else if ( $userID == 22 || $userID == 23 || $userID == 24 ) {									//
	$_SESSION['userDepartment'] = "Pipe Fitting";												//
} else if ( $userID == 25 || $userID == 26 || $userID == 27 ) {									//
	$_SESSION['userDepartment'] = "Riggings";													//
} else if ( $userID == 29 || $userID == 30 ) {													//
	$_SESSION['userDepartment'] = "HVAC";														//
} else if ( $userID == 31 || $userID == 32 || $userID == 33 ) {									//
	$_SESSION['userDepartment'] = "Painters";													//
} else if ( $userID == 34 || $userID == 35 ) {													//
	$_SESSION['userDepartment'] = "Mob Crew";													//
} else if ( $userID == 39 || $userID == 40 ) {													//
	$_SESSION['userDepartment'] = "Shop Guys";													//
}																								//
/* END SIMULATE USER LOG IN */		//		//		//		//		//		//		//		//	//

//include the DB
include('includes/db.php');

// get the variables necessary for functionality
if(isset($_GET['editSelector'])){$editcolMaster = $_GET['editSelector'];}
if(isset($_GET['foreman'])){$editcolForeman = $_GET['foreman'];}
if(isset($_GET['editSelector'])){$editcolMonth = substr($editcolMaster, 0, 2);}
if(isset($_GET['editSelector'])){$editcolDay = substr($editcolMaster, 7, 2);}
if(isset($_GET['editSelector'])){$editcolDept = substr($editcolMaster, 3, 3);}
if(isset($_GET['dateOfJobs'])){$date = $_GET['dateOfJobs'];}

// figure out if it is assigned or a block element and pluck out the year
if(($editcolForeman!='block1')&&($editcolForeman!='block2')){
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

/****************************************************************/
/***                 the user HAS edit writes                 ***/
/****************************************************************/
if ($editcolDept == $_SESSION['userDepartment']) {
	$first_name = "Block ";
	if($editcolForeman == "block1"){
		$last_name = "Time 1";
		$block1 = "<input type='hidden' id='editcolBlock1' name='editcolBlock1' value='block1' />";
		$block2 = "";
		// set up the query if this is block 1
		$sql = "SELECT COUNT(*) FROM schedule WHERE deptid = $currentDepartment AND block1 = '1' AND jobdate = '$date'";		// find out how many rows are in the table 
	}else if($editcolForeman == "block2"){
		$last_name = "Time 2";
		$block1 = "";
		$block2 = "<input type='hidden' id='editcolBlock2' name='editcolBlock2' value='block2' />";
		// set up the query if this is block 2
		$sql = "SELECT COUNT(*) FROM schedule WHERE deptid = $currentDepartment AND block2 = '1' AND jobdate = '$date'";		// find out how many rows are in the table 
	}else{
	// there is a foreman...
		$sql1 = "SELECT * FROM employees WHERE idemployees='$editcolForeman'";
		
		$result1 = mysql_query($sql1);
		if(!$result1) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $result1;
			die($message);
		};
		$num_rows1 = mysql_num_rows($result1);
		$ii = 0;
		
		while($num_rows1 >$ii){
			while($rows1 = mysql_fetch_array($result1)){
				$first_name = $rows1['first_name'];
				$last_name = $rows1['last_name'];
				$empID = $rows1['idemployees'];
			}
			$ii++;
		}
		
		// set up the query if there is a foreman
		$sql = "SELECT COUNT(*) FROM schedule WHERE deptid = $currentDepartment AND foremanid = '$editcolForeman' AND jobdate = '$date'";		// find out how many rows are in the table 
		
		$block1 = "";
		$block2 = "";
	}	// end if

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
	
	// set up the sql based on if there is a foreman or which block element
	if($editcolForeman == "block1"){
		$sql = "SELECT * FROM schedule WHERE deptid = '$currentDepartment' AND block1 = '1' AND jobdate = '$date' LIMIT $offset, $rowsperpage";
		$alertBlock1 = "yup";
	} else if($editcolForeman == "block2"){
		$sql = "SELECT * FROM schedule WHERE deptid = '$currentDepartment' AND block2 = '1' AND jobdate = '$date' LIMIT $offset, $rowsperpage";
		$alertBlock2 = "yup";
	} else {
		$sql = "SELECT * FROM schedule WHERE deptid = '$currentDepartment' AND foremanid = '$editcolForeman' AND jobdate = '$date' LIMIT $offset, $rowsperpage";
	}

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
						$borderColor = "border: thick solid ".$rows['schedulecolor'].";";
					}
					$ii++;
				}
				
				?>
				<html>
				<head>
					<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
					<script type="text/javascript" src="js/date.js"></script>
					<script type="text/javascript" src="js/jquery.datePicker.js"></script>
					<link rel="stylesheet" type="text/css" href="css/datePicker.css" />
					<link rel="stylesheet" type="text/css" href="css/editcol.css" />
					<script type="text/javascript" src="js/editcol.js"></script>
				</head>
				<body>
				<div id="msgWrapper">
					<div class="topWrapper" style="<?php echo $borderColor; ?> margin-bottom:10px;">
						<h3 style=" text-align: center"><?php echo $editcolDept; ?> - <?php echo $displayDate; ?></h3>
						<h4 style=" text-align: center"><?php echo $first_name.' '.$last_name; ?></h4> 
						
						<!-- hidden fields -->
						<input type="hidden" id="empID" name="empID" value="<?php echo $editcolForeman; ?>" />
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
						<?php
						if (($alertBlock1) || ($alertBlock2)) {		// looking for the 2 block elements
						?>
						<tr>
							<td>Foreman</td>
							<td>
								<select id="editcolNewForeman" style="width: 300px">
									<option value="" selected="true">please select a foreman</option>
									<?php
									//query for departments to be displayed first
									$sql = "SELECT * FROM foremen, employees WHERE foremen.employeeid = employees.idemployees AND foremen.deptid = '$currentDepartment'";
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
											$foremanID = $rows['idemployees'];
											$foremanName = $rows['first_name'] . " " . $rows['last_name'];
											
											if($jobID <> $idjobs){
												echo '<option value="' . $foremanID . '">' . $foremanName . '</option>';
											} else {
												echo '<option value="' . $foremanID . '" selected="true">' . $foremanName . '</option>';
											}
										}
										$i++;
									}
									?>
								</select>
							</td>
						</tr>
						<?php
						}		// end block if
						?>
						<tr>
							<td>Job</td>
							<td>
								<select id="editcolJob" style="width: 300px">
									<option value="" selected="true">please select a job</option>
									<?php
									//query for departments to be displayed first
									$sql = "SELECT idjobs, job_name FROM jobs WHERE is_active='y'";	//awsarded or in progress
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
									$sql = "SELECT first_name, last_name, idemployees FROM employees JOIN foremen_assign ON foremen_assign.apprenticeid = employees.idemployees WHERE foremanid = '$foremanID' GROUP BY last_name";
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
									$sql = "SELECT vanid FROM schedule WHERE scheduleid = '$scheduleid'";
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
											$assignedVanID = $rows['vanid'];
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
											$vansID = $rows['vanid'];
											$number = $rows['vannumber'];
											
											if($assignedVanID <> $vansID){
												echo '<option value="' . $vansID . '">' . $number . '</option>';
											} else {
												echo '<option value="' . $vansID . '" selected="true">' . $number . '</option>';
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
												echo '<option value="' . $equipmentID . '">' . $name . '</option>';
											} else {
												echo '<option value="' . $equipmentID . '" selected="true">' . $name . '</option>';
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
							<td>copy until</td>
							<td>
								<input type="text" name="copyUntil" id="copyUntil" readonly="readonly" />&nbsp;
								<input type="checkbox" name="includeWkdsSat" value="includeWkdsSat" /> Sat&nbsp;
								<input type="checkbox" name="includeWkdsSun" value="includeWkdsSun" /> Sun
							</td>
						</tr>

	<?php
			}
			$i++;
		}
	/**            END IF THERE WAS CONTENT TO DISPLAY             **/
	} else {
	/**            BEGIN IF THEY CLICKED ON A BLANK CELL in their department          **/
	// assign variables
	if(isset($_GET['color'])){$borderColor = $_GET['color'];}
		$borderColor = "border: thick solid #".$borderColor.";";
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
			$foremanID = $rows['employeeid'];
			$i++;
		} while ($i <= $editcolColumn);
		
		$sql = "SELECT * FROM employees WHERE idemployees='$foremanID'";
		
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
					<script type="text/javascript" src="js/date.js"></script>
					<script type="text/javascript" src="js/jquery.datePicker.js"></script>
					<link rel="stylesheet" type="text/css" href="css/datePicker.css" />
					<link rel="stylesheet" type="text/css" href="css/editcol.css" />
					<script type="text/javascript" src="js/editcol.js"></script>
				</head>
				<body>
				<div id="msgWrapper">
					<div class="topWrapper" style="<?php echo $borderColor; ?> margin-bottom:10px;">
						<h3 style=" text-align: center"><?php echo $editcolDept; ?> - <?php echo $displayDate; ?></h3>
						<h4 style=" text-align: center"><?php echo $first_name.' '.$last_name; ?></h4> 
						<!-- hidden elements -->
						<input type="hidden" id="empID" name="empID" value="<?php echo $empID; ?>" />
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
									$sql = "SELECT idjobs, job_name FROM jobs WHERE is_active='y'";
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
									$sql = "SELECT first_name, last_name, idemployees FROM employees JOIN foremen_assign ON foremen_assign.apprenticeid = employees.idemployees WHERE foremanid = '$foremanID' GROUP BY last_name";
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
									$sql = "SELECT * FROM van JOIN foremen_assign ON foremen_assign.vanid = van.vanid WHERE foremanid = '$foremanID' GROUP BY vannumber";
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
											$assignedVanID = $rows['vanid'];
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
											$vansID = $rows['vanid'];
											$number = $rows['vannumber'];
											
											if($assignedVanID <> $vansID){
												echo '<option value="' . $vansID . '">' . $number . '</option>';
											} else {
												echo '<option value="' . $vansID . '" selected="true">' . $number . '</option>';
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
												echo '<option value="' . $equipmentID . '">' . $name . '</option>';
											} else {
												echo '<option value="' . $equipmentID . '" selected="true">' . $name . '</option>';
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
							<td>copy until</td>
							<td>
								<input type="text" name="copyUntil" id="copyUntil" readonly="readonly" />&nbsp;
								<input type="checkbox" name="includeWkdsSat" id="includeWkdsSat" /> Sat&nbsp;
								<input type="checkbox" name="includeWkdsSun" id="includeWkdsSun" /> Sun
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
	
<?php
} else {
/****************************************************************/
/***             the user doesn't have edit writes            ***/
/****************************************************************/
	$first_name = "Block ";
	if($editcolForeman == "block1"){
		$last_name = "Time 1";
		$block1 = "<input type='hidden' id='editcolBlock1' name='editcolBlock1' value='block1' />";
		$block2 = "";
		// set up the query if this is block 1
		$sql = "SELECT COUNT(*) FROM schedule WHERE deptid = $currentDepartment AND block1 = '1' AND jobdate = '$date'";		// find out how many rows are in the table 
	}else if($editcolForeman == "block2"){
		$last_name = "Time 2";
		$block1 = "";
		$block2 = "<input type='hidden' id='editcolBlock2' name='editcolBlock2' value='block2' />";
		// set up the query if this is block 2
		$sql = "SELECT COUNT(*) FROM schedule WHERE deptid = $currentDepartment AND block2 = '1' AND jobdate = '$date'";		// find out how many rows are in the table 
	}else{
	// there is a foreman...
		$sql1 = "SELECT * FROM employees WHERE idemployees='$editcolForeman'";
		
		$result1 = mysql_query($sql1);
		if(!$result1) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $result1;
			die($message);
		};
		$num_rows1 = mysql_num_rows($result1);
		$ii = 0;
		while($num_rows1 >$ii){
			while($rows1 = mysql_fetch_array($result1)){
				$first_name = $rows1['first_name'];
				$last_name = $rows1['last_name'];
				$empID = $rows1['idemployees'];
			}
			$ii++;
		}
		
		// set up the query if there is a foreman
		$sql = "SELECT COUNT(*) FROM schedule WHERE deptid = $currentDepartment AND foremanid = '$editcolForeman' AND jobdate = '$date'";		// find out how many rows are in the table 
		
		$formDisabling = 'disabled="disabled"';
		$textDisabling = 'readonly="readonly"';
		$block1 = "";
		$block2 = "";
	}	// end if

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

	if($editcolForeman == "block1"){
		$sql = "SELECT * FROM schedule WHERE deptid = '$currentDepartment' AND block1 = 1 AND jobdate = '$date' LIMIT $offset, $rowsperpage";
	} else if($editcolForeman == "block2"){
		$sql = "SELECT * FROM schedule WHERE deptid = '$currentDepartment' AND block2 = 1 AND jobdate = '$date' LIMIT $offset, $rowsperpage";
	} else {
		$sql = "SELECT * FROM schedule WHERE deptid = '$currentDepartment' AND foremanid = '$editcolForeman' AND jobdate = '$date' LIMIT $offset, $rowsperpage";
	}

	$result = mysql_query($sql);

	if(!$result) {
		$message  = 'Invalid query: ' . mysql_error() . "\n";
		$message .= 'Whole query: ' . $result;
		die($message);
	};

	$num_rows = mysql_num_rows($result);
	$i = 0;

	/************************************************/
	/*   display the content of other department    */
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
					$modButtons = '<button id="btnSave" name="btnSave">save</button><span class="spacer"> </span><button id="btnClear" name="btnClear">clear</button><span class="spacer"> </span><button id="btnAddRecord" name="btnAddRecord">add another job</button>';
				}elseif($editcolForeman == "block2"){
					$last_name = "Time 2";
					$block1 = "";
					$block2 = "<input type='hidden' id='editcolBlock2' name='editcolBlock2' value='block2' />";
					$modButtons = '<button id="btnSave" name="btnSave">save</button><span class="spacer"> </span><button id="btnClear" name="btnClear">clear</button><span class="spacer"> </span><button id="btnAddRecord" name="btnAddRecord">add another job</button>';
				}else{
					$block1 = "";
					$block2 = "";
					$formDisabling = 'disabled="disabled"';
					$textDisabling = 'readonly="readonly"';
					$modButtons = '';
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
						$empID = $rows['idemployees'];
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
						$borderColor = "border: thick solid ".$rows['schedulecolor'].";";
					}
					$ii++;
				}
					
				?>
				<html>
				<head>
					<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
					<script type="text/javascript" src="js/date.js"></script>
					<script type="text/javascript" src="js/jquery.datePicker.js"></script>
					<link rel="stylesheet" type="text/css" href="css/datePicker.css" />
					<link rel="stylesheet" type="text/css" href="css/editcol.css" />
					<script type="text/javascript" src="js/editcol.js"></script>
				</head>
				<body>
				<div id="msgWrapper">
					<div class="topWrapper" style="<?php echo $borderColor; ?> margin-bottom:10px;">
						<h3 style=" text-align: center"><?php echo $editcolDept; ?> - <?php echo $displayDate; ?></h3>
						<h4 style=" text-align: center"><?php echo $first_name.' '.$last_name; ?></h4> 
						
						<!-- hidden fields -->
						<input type="hidden" id="empID" name="empID" value="<?php echo $empID; ?>" />
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
								<select id="editcolJob" style="width: 300px" <?php echo $formDisabling; ?>>
									<option value="" selected="true">please select a job</option>
									<?php
									//query for departments to be displayed first
									$sql = "SELECT idjobs, job_name FROM jobs WHERE is_active='y'";	//awsarded or in progress
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
								<select id="editcolLocation" style="width: 300px" <?php echo $formDisabling; ?>>
									<option value="firstone" selected="true">please select a job</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>Apprentice</td>
							<td>
								<select id="editcolApprentice" style="width: 300px" <?php echo $formDisabling; ?>>
									<?php
									// fetch the assigned van number
									$sql = "SELECT first_name, last_name, idemployees FROM employees JOIN foremen_assign ON foremen_assign.apprenticeid = employees.idemployees WHERE foremanid = '$foremanID' GROUP BY last_name";
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
								<select id="editcolVan" style="width: 300px" <?php echo $formDisabling; ?>>
									<?php
									// fetch the assigned van number
									$sql = "SELECT * FROM van JOIN foremen_assign ON foremen_assign.vanid = van.vanid WHERE foremanid = '$foremanID' GROUP BY vannumber";
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
											$assignedVanID = $rows['vanid'];
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
											$vansID = $rows['vanid'];
											$number = $rows['vannumber'];
											
											if($assignedVanID <> $vansID){
												echo '<option value="' . $vansID . '">' . $number . '</option>';
											} else {
												echo '<option value="' . $vansID . '" selected="true">' . $number . '</option>';
											}
										}
										$i++;
									}
									?>
								</select>
								<?php echo $foremanID; ?>
							</td>
						</tr>
						<tr>
							<td>Equipment</td>
							<td>
								<select id="editcolEquipment" style="width: 300px" <?php echo $formDisabling; ?>>
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
												echo '<option value="' . $equipmentID . '">' . $name . '</option>';
											} else {
												echo '<option value="' . $equipmentID . '" selected="true">' . $name . '</option>';
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
										if($comments!=""){echo '<textarea rows="5" cols="35" name="editcolComments" id="editcolComments" '.$textDisabling.'>'. $comments . '</textarea>';}
									}
									
									$i++;
								}
								if ($comments==""){echo '<textarea rows="4" cols="35" name="editcolComments" id="editcolComments" '.$textDisabling.'></textarea>';}
								?>
							</td>
						</tr>
	<?php
			}
			$i++;
		}
	/**            END IF THERE WAS CONTENT TO DISPLAY             **/
	} else {
	/*********************************************************************************/
	/**            BEGIN IF THEY CLICKED ON A BLANK CELL for another dept           **/
	/*********************************************************************************/
	// assign variables
	if(isset($_GET['color'])){$borderColor = $_GET['color'];}
		$borderColor = "border: thick solid #".$borderColor.";";
	if(isset($_GET['editSelector'])){$editcolMaster = $_GET['editSelector'];}
	if(isset($_GET['foreman'])){$editcolForeman = $_GET['foreman'];}
	if(isset($_GET['editcolJob'])){$editcolJob = $_GET['editcolJob'];}
	if(isset($_GET['editSelector'])){$editcolMaster = $_GET['editSelector'];}
	if(isset($_GET['editSelector'])){$editcolMonth = substr($editcolMaster, 0, 2);}
	if(isset($_GET['editSelector'])){$editcolDay = substr($editcolMaster, 7, 2);}
	if(isset($_GET['editSelector'])){$editcolDept = substr($editcolMaster, 3, 3);}
	if(isset($_GET['dateOfJobs'])){$date = $_GET['dateOfJobs'];}

	// figure out if it is assigned or a block element
	if(($editcolForeman!='block1')&&($editcolForeman!='block2')){
		// if there is a foreman
		$editcolYear = substr($editcolMaster, 13, 4);
	} else {
		// if it is a block element
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

	$first_name = "Block ";
	if($editcolForeman == "block1"){
		$last_name = "Time 1";
		$block1 = "<input type='hidden' id='editcolBlock1' name='editcolBlock1' value='block1' />";
		$block2 = "";
		// set up the query if this is block 1
		$sql = "SELECT COUNT(*) FROM schedule WHERE deptid = $currentDepartment AND block1 = '1' AND jobdate = '$date'";		// find out how many rows are in the table 
		$modButtons = '<button id="btnSave" name="btnSave">save</button><span class="spacer"> </span><button id="btnClear" name="btnClear">clear</button><span class="spacer"> </span><button id="btnAddRecord" name="btnAddRecord">add another job</button>';
	}else if($editcolForeman == "block2"){
		$last_name = "Time 2";
		$block1 = "";
		$block2 = "<input type='hidden' id='editcolBlock2' name='editcolBlock2' value='block2' />";
		// set up the query if this is block 2
		$sql = "SELECT COUNT(*) FROM schedule WHERE deptid = $currentDepartment AND block2 = '1' AND jobdate = '$date'";		// find out how many rows are in the table 
		$modButtons = '<button id="btnSave" name="btnSave">save</button><span class="spacer"> </span><button id="btnClear" name="btnClear">clear</button><span class="spacer"> </span><button id="btnAddRecord" name="btnAddRecord">add another job</button>';
	}else{
	// there is a foreman...
		$sql1 = "SELECT * FROM employees WHERE idemployees='$editcolForeman'";
		
		$result1 = mysql_query($sql1);
		if(!$result1) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $result1;
			die($message);
		};
		$num_rows1 = mysql_num_rows($result1);
		$ii = 0;
		while($num_rows1 >$ii){
			while($rows1 = mysql_fetch_array($result1)){
				$first_name = $rows1['first_name'];
				$last_name = $rows1['last_name'];
				$empID = $rows1['idemployees'];
			}
			$ii++;
			
		}
		
		// set up the query if there is a foreman
		$sql = "SELECT COUNT(*) FROM schedule WHERE deptid = $currentDepartment AND foremanid = '$editcolForeman' AND jobdate = '$date'";		// find out how many rows are in the table 
		
		$block1 = "";
		$block2 = "";
		$formDisabling = 'disabled="disabled"';
		$textDisabling = 'readonly="readonly"';
	}	// end if

	$result = mysql_query($sql);
	if(!$result) {
		$message  = 'Invalid query: ' . mysql_error() . "\n";
		$message .= 'Whole query: ' . $result;
		die($message);
	};

	$num_rows = mysql_num_rows($result);
	$i = 1;		//counter


	?>
				<html>
				<head>
					<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
					<script type="text/javascript" src="js/date.js"></script>
					<script type="text/javascript" src="js/jquery.datePicker.js"></script>
					<link rel="stylesheet" type="text/css" href="css/datePicker.css" />
					<link rel="stylesheet" type="text/css" href="css/editcol.css" />
					<script type="text/javascript" src="js/editcol.js"></script>
				</head>
				<body>
				<div id="msgWrapper">
					<div class="topWrapper" style="<?php echo $borderColor; ?> margin-bottom:10px;">
						<h3 style=" text-align: center"><?php echo $editcolDept; ?> - <?php echo $displayDate; ?></h3>
						<h4 style=" text-align: center"><?php echo $first_name.' '.$last_name; ?></h4> 
						<!-- hidden elements -->
						<input type="hidden" id="empID" name="empID" value="<?php echo $editcolForeman; ?>" />
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
								<select id="editcolJob" style="width: 300px;" <?php echo $formDisabling; ?>>
									<option value="" selected="true">please select a job</option>
									<?php
									//query for departments to be displayed first
									$sql = "SELECT idjobs, job_name FROM jobs WHERE is_active='y'";
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
								<select id="editcolLocation" style="width: 300px;" <?php echo $formDisabling; ?>>
									<option value="firstone" selected="true">please select a job</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>Apprentice</td>
							<td>
								<select id="editcolApprentice" style="width: 300px;" <?php echo $formDisabling; ?>>
									<?php
									// fetch the assigned van number
									$sql = "SELECT first_name, last_name, idemployees FROM employees JOIN foremen_assign ON foremen_assign.apprenticeid = employees.idemployees WHERE foremanid = '$foremanID' GROUP BY last_name";
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
								<select id="editcolVan" style="width: 300px;" <?php echo $formDisabling; ?>>
									<?php
									// fetch the assigned van number
									$sql = "SELECT * FROM van JOIN foremen_assign ON foremen_assign.vanid = van.vanid WHERE foremanid = '$foremanID' GROUP BY vannumber";
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
											$assignedVanID = $rows['vanid'];
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
											$vansID = $rows['vanid'];
											$number = $rows['vannumber'];
											
											if($assignedVanID <> $vansID){
												echo '<option value="' . $vansID . '">' . $number . '</option>';
											} else {
												echo '<option value="' . $vansID . '" selected="true">' . $number . '</option>';
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
								<select id="editcolEquipment" style="width: 300px;" <?php echo $formDisabling; ?>>
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
												echo '<option value="' . $equipmentID . '">' . $name . '</option>';
											} else {
												echo '<option value="' . $equipmentID . '" selected="true">' . $name . '</option>';
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
										if($comments!=""){echo '<textarea rows="5" cols="35" name="editcolComments" id="editcolComments" '.$textDisabling.'>'. $comments . '</textarea>';}
									}
									
									$i++;
								}
								if ($comments==""){echo '<textarea rows="4" cols="35" name="editcolComments" id="editcolComments" '.$textDisabling.'></textarea>';}
								?>
							</td>
						</tr>
	<?php
	}
	?>
						<tr>
							<td>copy until</td>
							<td>
								<input type="text" name="copyUntil" id="copyUntil" readonly="readonly" />&nbsp;
								<input type="checkbox" name="includeWkdsSat" id="includeWkdsSat" /> Sat&nbsp;
								<input type="checkbox" name="includeWkdsSun" id="includeWkdsSun" /> Sun
							</td>
						</tr>
			<tr>
				<td class="centered" colspan="2">
					<?php echo $modButtons; ?>
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
<?php
}
?>




















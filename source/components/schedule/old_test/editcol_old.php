<?php
//include the DB
include('../../../includes/db.php');

// assign variables
$borderColor = $_GET['color'];
$editcolMaster = $_GET['editSelector'];
$editcolForeman = $_GET['foreman'];
$editcolJob = $_GET['editcolJob'];

// set up the date for the database
$editcolMonth = substr($editcolMaster, 0, 2);
$editcolDay = substr($editcolMaster, 7, 2);
$editcolDept = substr($editcolMaster, 3, 3);
if(($editcolForeman!='block1')&&($editcolForeman!='block2')){
	$editcolColumn = substr($editcolMaster, 10, 2);
	$editcolYear = substr($editcolMaster, 13, 4);
} else {
	$editcolYear = substr($editcolMaster, 10, 4);
}
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
	<div class="topWrapper" style="border: thick solid #<?php echo $borderColor; ?>; margin-bottom:10px;">
		<h3 style=" text-align: center"><?php echo $editcolDept; ?> - <?php echo $displayDate; ?></h3>
		<h4 style=" text-align: center"><?php echo $first_name.' '.$last_name; ?></h4> 
		<input type="hidden" id="empID" name="empID" value="<?php echo $empID; ?>" />
		<input type="hidden" id="currentDepartment" name="currentDepartment" value="<?php echo $currentDepartment; ?>" />
		<input type="hidden" id="currentJobID" name="currentJobID" value="<?php echo $editcolJob; ?>" />
		<input type="hidden" id="editcolYear" name="editcolYear" value="<?php echo $editcolYear; ?>" />
		<input type="hidden" id="editcolMonth" name="editcolMonth" value="<?php echo $editcolMonth; ?>" />
		<input type="hidden" id="editcolDay" name="editcolDay" value="<?php echo $editcolDay; ?>" />
		<input type="hidden" id="currentLocation" name="currentLocation" value="<?php echo $editcolLocationID; ?>" />
		<input type="hidden" id="currentApprentice" name="currentApprentice" value="<?php echo $editcolApprenticeID; ?>" />
		<input type="hidden" id="currentVan" name="currentVan" value="<?php echo $editcolVanID; ?>" />
		<input type="hidden" id="currentEquipment" name="currentEquipment" value="<?php echo $editcolEquipmentID; ?>" />
		<input type="hidden" id="editcolUpdateFlag" name="editcolUpdateFlag" value="<?php if($editcolJob<>""){echo "update";}else{echo "insert";} ?>" />
		<input type="hidden" id="editcolDelete" name="editcolDelete" value="0" />
		<?php echo $block1; ?>
		<?php echo $block2; ?>
		<?php
		if (currentJobID != "") {
			$result = mysql_query("SELECT * FROM schedule WHERE deptid = '$currentDepartment' AND idjobs = '$editcolJob' AND foremanid = '$empID' AND jobdate = '$date'");
			
			while($row = mysql_fetch_array($result)) {
				$currentScheduleID = $row['scheduleid'];
			}
		}
		echo "<input type='hidden' id='currentScheduleID' name='currentScheduleID' value='$currentScheduleID' />";
		?>
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
							
							if($jobID <> $editcolJob){
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
					<option value="firstone" selected="true">please select a location</option>
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
							} else if($apprenNumber <> $editcolApprenticeID) {
								echo '<option value="' . $apprenNumber . '" selected="true">' . $firstname . ' ' . $lastname . '</option>';
							} else {
								echo '<option value="' . $apprenNumber1 . '" selected="true">' . $firstname1 . ' ' . $lastname1 . '</option>';
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
							$vanNumber = $rows['vannumber'];
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
							
							if($vanNumber <> $number){
								echo '<option value="' . $vanID . '">' . $number . '</option>';
							} else if($vanNumber <> $editcolVanID) {
								echo '<option value="' . $vanID . '" selected="true">' . $number . '</option>';
							} else {
								echo '<option value="' . $vanID . '" selected="true">' . $number . '</option>';
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
					<option selected='true'>select a piece of equipment</option>
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
							$equipID = $rows['equipid'];
							$name = $rows['name'];
							
							if($equipID <> $editcolEquipmentID){
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
				if(($editcolForeman!='block1')&&($editcolForeman!='block2')){
					$sql = "SELECT comments FROM schedule WHERE (idjobs = '$editcolJob' AND jobdate = '$date' AND foremanid = '$empID' AND block1 = '0' AND block1 = '0')";
				} else if ($editcolForeman=='block1') {
					$sql = "SELECT comments FROM schedule WHERE (idjobs = '$editcolJob' AND foremanid = '0' AND jobdate = '$date' AND block1 = '1')";
				} else {
					$sql = "SELECT comments FROM schedule WHERE (idjobs = '$editcolJob' AND foremanid = '0' AND jobdate = '$date' AND block2 = '1')";
				}
				
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
		<tr>
			<td colspan="2">
				<p style="text-align: center; margin-top: 10px;">1 | <a href="">2</a> | <a href="">3</a> | <a href="">4</a> | <a href="">5</a> <a href="">>></a><span style="margin-left: 50px"><a href=""><<</a> <a href="">1</a> | 2 | <a href="">3</a> | <a href="">4</a> | <a href="">5</a> <a href="">>></a></span></p>
			</td>
		</tr>
		</table>
	</div>
</div>
</body>
</html>

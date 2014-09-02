<?php
/* *************************************** */
/*       all I do is view the column       */
/* *************************************** */
//include the DB
include('../../../includes/db.php');

// assign variables
$borderColor = $_GET['color'];
$editcolMaster = $_GET['editSelector'];
$editcolForeman1 = $_GET['foreman1'];
$editcolForeman2 = $_GET['foreman2'];
$editcolJob = $_GET['editcolJob'];
$editcolLocationID = $_GET['editcolLocation'];
$editcolVanID = $_GET['editcolVan'];
$editcolApprenticeID = $_GET['editcolApprentice'];
$editcolEquipmentID = $_GET['editcolEquipment'];

$editcolMonth = substr($editcolMaster, 0, 2);
$editcolDay = substr($editcolMaster, 7, 2);
$editcolDept = substr($editcolMaster, 3, 3);
if(!$editcolForeman1||!$editcolForeman2){
	$editcolColumn = substr($editcolMaster, 10, 2);
}

// parse the department
switch ($editcolDept){
	case "ele":
		$editcolDept = "Electric";
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
	if($editcolForeman1 == "block1"){
		$last_name = "Time 1";
	}elseif($editcolForeman2 == "block2"){
		$last_name = "Time 2";
	}else{
		$block1 = "";
		$block2 = "";
	}
}
$date = "2011/".$editcolMonth."/".$editcolDay;
$displayDate = $editcolMonth."/".$editcolDay."/2011";
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
</div>
<div id="contentWrapper">
<table cellpadding="3" cellspacing="0">
<tr>
	<td>Job</td>
	<td>
		<?php
		//query for departments to be displayed first
		$sql = "SELECT idjobs, job_name FROM jobs WHERE progress <> 'declined' AND progress <> 'fished' OR progress IS NULL";
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
				
				if($jobID == $editcolJob){
					echo $jobID . ' - ' . $jobName;
				}
			}
			$i++;
		}
		?>
	</td>
</tr>
<tr>
	<td>location</td>
	<td>
			<?php
			//query for departments to be displayed first
			if($editcolLocationID != ""){
				$sql = "SELECT address, city, state FROM locations WHERE idship_to_address = '$editcolLocationID'";
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
						$locID = $rows['idship_to_address'];
						$locAddress = $rows['address'];
						$locCity = $rows['city'];
						$locState = $rows['state'];
						
						echo $locAddress . ' ' . $locCity . ', ' . $locState;
					}
					$i++;
				}
			}
			?>
	</td>
</tr>
<tr>
	<td>Apprentice</td>
	<td>
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
					
					if($apprenNumber == $editcolApprenticeID) {
						echo $firstname . ' ' . $lastname;
					}
				}
				$i++;
			}
			?>
	</td>
</tr>
<tr>
	<td>Van</td>
	<td>
			<?php
			//query for the rest of the vans
			$sql = "SELECT * FROM van WHERE vanid = '$editcolVanID'";
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
					$number = $rows['vannumber'];
					
						echo $number;
				}
				$i++;
			}
			?>
	</td>
</tr>
<tr>
	<td>Equipment</td>
	<td>
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
					
					if($equipID == $editcolEquipmentID){
						echo $name;
					} 
				}
				$i++;
			}
			?>
	</td>
</tr>
<tr>
	<td>Comments</td>
	<td>
		<?php
		//query for departments to be displayed first
		$sql = "SELECT comments FROM schedule WHERE idjobs = '$editcolJob' AND jobdate = '$date' AND foremanid = '$empID' OR block1 = '$editcolForeman1' OR block2 = '$editcolForeman2'";
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
				echo $comments;
			}
			$i++;
		}
		?>
	</td>
</tr>
<tr>
	<td class="centered" colspan="2">
	</td>
</tr>
</table>
<div id="ajaxHack"></div>
</div>
</div>
</body>
</html>

















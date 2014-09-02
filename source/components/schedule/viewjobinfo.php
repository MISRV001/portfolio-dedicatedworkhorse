<?php
include('includes/db.php');

if(isset($_GET['job_id'])) {
	$job_id = $_GET['job_id'];
	
	$sql = "select * from quotes where job_id='$job_id'";
	$result = mysql_query($sql);
	if(!$result) {
		$message  = 'Invalid query: ' . mysql_error() . "\n";
		$message .= 'Whole query: ' . $result;
		die($message);
	}
	
	$countquote = mysql_num_rows($result);
	if($countquote > 0) {
		$readonly = 1;
	} else {
		$readonly = '';
	}

	$sql = "select rev from quotes where job_id='$job_id' order by rev desc limit 1";
	$result = mysql_query($sql);
	if(!$result) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $result;
			die($message);
	}
	
	while($row = mysql_fetch_assoc($result)) {
		if(isset($rev)) {
			if($rev > $row['rev']) {
				unset($rev);
			}
		} else {
			$rev = $row['rev'];
		}
	}
	// Get the job with the ID
	$sql = "select * from jobs where idjobs = '$job_id'";
	$result = mysql_query($sql);
	if(!$result) {
		$message  = 'Invalid query: ' . mysql_error() . "\n";
		$message .= 'Whole query: ' . $result;
		die($message);
	}
	
	while($row = mysql_fetch_assoc($result)) {
		$scope = $row['scope_of_work'];
		$benefit = $row['benefits'];
		$comments = $row['comments'];
		$writeupcomments = $row['writeup_comments'];
		$location = $row['location'];
		$estimate = $row['estimate'];
		$job_name = $row['job_name'];
		$budget = $row['budget'];
		$quotedue = $row['quote_due'];
		$jobstart = $row['est_job_start'];
		$jobstart2 = $row['est_job_start2'];
		$writeupdue = $row['writeup_due'];
		$award = $row['awarded_status'];
		$likelihood = $row['likehood'];
		$terms = $row['terms'];
		$rfqcontact = $row['rfq_cust_contact'];
		$accountrep = $row['accountrep'];
		$progress = $row['progress'];
		$company = $row['company_idcustomer'];
		$pm_terms = $row['pm_terms'];
		$ongoingnotes = $row['pm_notes'];
		$changetracking = $row['pm_changeorder'];
		$tmtracking = $row['pm_tmtracking'];
		$completion = $row['completion'];
	}
}

if ($job_id != "") {

// Get the Account Rep Info
$sql = "select first_name, last_name, email from employees where idemployees = '$accountrep'";
$result = mysql_query($sql);
if(!$result) {
	$message  = 'Invalid query: ' . mysql_error() . "\n";
	$message .= 'Whole query: ' . $result;
	die($message);
}

while($row = mysql_fetch_assoc($result)) {
	$arf_name = $row['first_name'];
	$arl_name = $row['last_name'];
	$aremail = $row['email'];
}

// Get the Site Info 
$sql = "select * from siteinfo where idship_to_address = '$location'";
$result = mysql_query($sql);
	if(!$result) {
		$message  = 'Invalid query: ' . mysql_error() . "\n";
		$message .= 'Whole query: ' . $result;
		die($message);
	}
			
while($row = mysql_fetch_assoc($result)) {
	$siteinfo = $row['site_info'];
	$hours = $row['hours'];
	$ceiling = $row['ceiling'];
	$floor = $row['floor'];
	$loadingdock = $row['loadingdock'];
	$loadingdocksize = $row['loadingdocksize'];
	$grounddoor = $row['grounddoor'];
	$grounddoorsize = $row['grounddoorsize'];
	$crane = $row['crane'];
	$cranesize = $row['cranesize'];
	$fullprotection = $row['fullprotection'];
	$hardhats = $row['hardhats'];
	$safetyglasses = $row['safetyglasses'];
	$earplugs = $row['earplugs'];
	$steelboots = $row['steelboots'];
	$inside = $row['inside'];
	$outside = $row['outside'];
}
	
// Get the RFQ Contact
$sql = "select * from cust_cont where idcustcontacts = '$rfqcontact'";
$result = mysql_query($sql);
if(!$result) {
	$message  = 'Invalid query: ' . mysql_error() . "\n";
	$message .= 'Whole query: ' . $result;
	die($message);
}

while($row = mysql_fetch_assoc($result)) {
	$rfqf_name = $row['cust_cont_first_name'];
	$rfql_name = $row['cust_cont_last_name'];
	$rfqaddress = $row['cust_cont_address'];
	$rfqcity = $row['cust_cont_city'];
	$rfqstate = $row['cust_cont_state'];
	$rfqzip = $row['cust_cont_zip'];
	$rfqtitle = $row['cust_cont_title'];
	$rfqemail = $row['email'];
	$rfqphone = $row['cust_cont_phone'];
	$rfqfax = $row['cust_cont_phone'];
}

// Get the company info
$sql = "select cust_name from company where idcustomer = '$company'";
$result = mysql_query($sql);
if(!$result) {
	$message  = 'Invalid query: ' . mysql_error() . "\n";
	$message .= 'Whole query: ' . $result;
	die($message);
}

while($row = mysql_fetch_assoc($result)) {
	$companyname = $row['cust_name'];
}

// Get the job location info
$sql = "select * from locations where idship_to_address = '$location'";
$result = mysql_query($sql);
if(!$result) {
	$message  = 'Invalid query: ' . mysql_error() . "\n";
	$message .= 'Whole query: ' . $result;
	die($message);
}
			
while($row = mysql_fetch_assoc($result)) {
	$address = $row['address'];
	$city = $row['city'];
	$state = $row['state'];
	$zip = $row['zip'];
	$phone = $row['phone'];
	$fax = $row['fax'];
}

// Get the billing address info
$sql = "select * from job_locations where job_id = '$job_id' and billto = '1'";
$result = mysql_query($sql);
if(!$result) {
	$message  = 'Invalid query: ' . mysql_error() . "\n";
	$message .= 'Whole query: ' . $result;
	die($message);
}
			
while($row = mysql_fetch_assoc($result)) {
	$billto = $row['idship_to_address'];
	$sql = "select * from locations where idship_to_address='$billto'";
	$result = mysql_query($sql);
	if(!$result) {
		$message  = 'Invalid query: ' . mysql_error() . "\n";
		$message .= 'Whole query: ' . $result;
		die($message);
	}
			
	while($row = mysql_fetch_assoc($result)) {
		$billaddress = $row['address'];
		$billcity = $row['city'];
		$billstate = $row['state'];
		$billzip = $row['zip'];
		$billphone = $row['phone'];
		$billfax = $row['fax'];
	}
}
	
// Get the Writeup info
$sql = "select * from dept_writeups where jobs_id = '$job_id'"; 
$result = mysql_query($sql);
if(!$result) {
	$message  = 'Invalid query: ' . mysql_error() . "\n";
	$message .= 'Whole query: ' . $result;
	die($message);
}
				
while($row = mysql_fetch_assoc($result)) {
	$d = $row['departments_id'];
	// Electrical
	if($d == 1) {
		$electricalwriteup = $row['writeup'];
		$electricalmen = $row['manpower_men'];
		$electricalmendays = $row['manpower_days'];
		$electricalmenhours = $row['manpower_hours'];
		$electricalpurchasing = $row['purchase_items'];
		$electricallaborcost = $row['cost_of_labor'];
		$electricalequipmentcost = $row['cost_of_equipment'];
		$electricalmaterialcost = $row['cost_of_materials'];
		$electricalactualcost = $row['actual_cost'];
		$electricalnotes = $row['notes'];
	}
	//Foundations
	if($d == 2) {
		$foundationswriteup = $row['writeup'];
		$foundationsmen = $row['manpower_men'];
		$foundationsmendays = $row['manpower_days'];
		$foundationsmenhours = $row['manpower_hours'];
		$foundationspurchasing = $row['purchase_items'];
		$foundationslaborcost = $row['cost_of_labor'];
		$foundationsequipmentcost = $row['cost_of_equipment'];
		$foundationsmaterialcost = $row['cost_of_materials'];
		$foundationsactualcost = $row['actual_cost'];
		$foundationsnotes = $row['notes'];
	}
	// Etc...
	if($d == 3) {
		$carpentrywriteup = $row['writeup'];
		$carpentrymen = $row['manpower_men'];
		$carpentrymendays = $row['manpower_days'];
		$carpentrymenhours = $row['manpower_hours'];
		$carpentrypurchasing = $row['purchase_items'];
		$carpentrylaborcost = $row['cost_of_labor'];
		$carpentryequipmentcost = $row['cost_of_equipment'];
		$carpentrymaterialcost = $row['cost_of_materials'];
		$carpentryactualcost = $row['actual_cost'];
		$carpentrynotes = $row['notes'];
	}
	// Etc...
	if($d == 4) {
		$pipefittingwriteup = $row['writeup'];
		$pipefittingmen = $row['manpower_men'];
		$pipefittingmendays = $row['manpower_days'];
		$pipefittingmenhours = $row['manpower_hours'];
		$pipefittingpurchasing = $row['purchase_items'];
		$pipefittinglaborcost = $row['cost_of_labor'];
		$pipefittingequipmentcost = $row['cost_of_equipment'];
		$pipefittingmaterialcost = $row['cost_of_materials'];
		$pipefittingactualcost = $row['actual_cost'];
		$pipefittingnotes = $row['notes'];
	}
	if($d == 5) {
		$riggingwriteup = $row['writeup'];
		$riggingmen = $row['manpower_men'];
		$riggingmendays = $row['manpower_days'];
		$riggingmenhours = $row['manpower_hours'];
		$riggingpurchasing = $row['purchase_items'];
		$rigginglaborcost = $row['cost_of_labor'];
		$riggingequipmentcost = $row['cost_of_equipment'];
		$riggingmaterialcost = $row['cost_of_materials'];
		$riggingactualcost = $row['actual_cost'];
		$riggingnotes = $row['notes'];
	}
	if($d == 6) {
		$hvacwriteup = $row['writeup'];
		$hvacmen = $row['manpower_men'];
		$hvacmendays = $row['manpower_days'];
		$hvacmenhours = $row['manpower_hours'];
		$hvacpurchasing = $row['purchase_items'];
		$hvaclaborcost = $row['cost_of_labor'];
		$hvacequipmentcost = $row['cost_of_equipment'];
		$hvacmaterialcost = $row['cost_of_materials'];
		$hvacactualcost = $row['actual_cost'];
		$hvacnotes = $row['notes'];
	}
	if($d == 7) {
		$painterwriteup = $row['writeup'];
		$paintermen = $row['manpower_men'];
		$paintermendays = $row['manpower_days'];
		$paintermenhours = $row['manpower_hours'];
		$painterpurchasing = $row['purchase_items'];
		$painterlaborcost = $row['cost_of_labor'];
		$painterequipmentcost = $row['cost_of_equipment'];
		$paintermaterialcost = $row['cost_of_materials'];
		$painteractualcost = $row['actual_cost'];
		$painternotes = $row['notes'];
	}
	if($d == 8) {
		$mobcrewwriteup = $row['writeup'];
		$mobcrewmen = $row['manpower_men'];
		$mobcrewmendays = $row['manpower_days'];
		$mobcrewmenhours = $row['manpower_hours'];
		$mobcrewpurchasing = $row['purchase_items'];
		$mobcrewlaborcost = $row['cost_of_labor'];
		$mobcrewequipmentcost = $row['cost_of_equipment'];
		$mobcrewmaterialcost = $row['cost_of_materials'];
		$mobcrewactualcost = $row['actual_cost'];
		$mobcrewnotes = $row['notes'];
	}
	if($d == 9) {
		$weldfabwriteup = $row['writeup'];
		$weldfabmen = $row['manpower_men'];
		$weldfabmendays = $row['manpower_days'];
		$weldfabmenhours = $row['manpower_hours'];
		$weldfabpurchasing = $row['purchase_items'];
		$weldfablaborcost = $row['cost_of_labor'];
		$weldfabequipmentcost = $row['cost_of_equipment'];
		$weldfabmaterialcost = $row['cost_of_materials'];
		$weldfabactualcost = $row['actual_cost'];
		$weldfabnotes = $row['notes'];
	}
	if($d == 10) {
		$shopguyswriteup = $row['writeup'];
		$shopguysmen = $row['manpower_men'];
		$shopguysmendays = $row['manpower_days'];
		$shopguysmenhours = $row['manpower_hours'];
		$shopguyspurchasing = $row['purchase_items'];
		$shopguyslaborcost = $row['cost_of_labor'];
		$shopguysequipmentcost = $row['cost_of_equipment'];
		$shopguysmaterialcost = $row['cost_of_materials'];
		$shopguysactualcost = $row['actual_cost'];
		$shopguysnotes = $row['notes'];
	}
	if($d == 11) {
		$aircompressorwriteup = $row['writeup'];
		$aircompressormen = $row['manpower_men'];
		$aircompressormendays = $row['manpower_days'];
		$aircompressormenhours = $row['manpower_hours'];
		$aircompressorpurchasing = $row['purchase_items'];
		$aircompressorlaborcost = $row['cost_of_labor'];
		$aircompressorequipmentcost = $row['cost_of_equipment'];
		$aircompressormaterialcost = $row['cost_of_materials'];
		$aircompressoractualcost = $row['actual_cost'];
		$aircompressornotes = $row['notes'];
	}
	if($d == 12) {
		$mechanicalwriteup = $row['writeup'];
		$mechanicalmen = $row['manpower_men'];
		$mechanicalmendays = $row['manpower_days'];
		$mechanicalmenhours = $row['manpower_hours'];
		$mechanicalpurchasing = $row['purchase_items'];
		$mechanicallaborcost = $row['cost_of_labor'];
		$mechanicalequipmentcost = $row['cost_of_equipment'];
		$mechanicalmaterialcost = $row['cost_of_materials'];
		$mechanicalactualcost = $row['actual_cost'];
		$mechanicalnotes = $row['notes'];
	}
}
?>




<html>
<head>
	<link rel="stylesheet" type="text/css" href="css/viewjobinfo.css" />
</head>
<body>
<div id="contentWrapper">
	<h4>Customer Info:</h4>
	<div id="lefttable"><span class="jobinfo">Company Name:</span></div><div id="righttable"><?php echo $companyname; ?></div><div id="break"></div>
	<div id="lefttable"><span class="jobinfo">RFQ Contact Name:</span></div><div id="righttable"><?php echo $rfqf_name.' '.$rfql_name; ?></div><div id="break"></div>
	<div id="lefttable"><span class="jobinfo">Title:</span></div><div id="righttable"><?php echo $rfqtitle; ?></div><div id="break"></div>
	<div id="lefttable"><span class="jobinfo">E-mail:</span></div><div id="righttable"><a href="mailto:<?php echo $rfqemail; ?>"><?php echo $rfqemail; ?></a></div><div id="break"></div>
	<div id="lefttable"><span class="jobinfo">Address:</span></div><div id="righttable"><?php echo $rfqaddress; ?><br /><?php echo $rfqcity.', '.$rfqstate.' '.$rfqzip; ?></div><div id="break"></div>
	<div id="lefttable"><span class="jobinfo">Work Number:</span></div><div id="righttable"><?php echo $rfqphone; ?></div><div id="break"></div>
	<div id="lefttable"><span class="jobinfo">Fax Number:</span></div><div id="righttable"><?php echo $rfqfax; ?></div><div id="break"></div>
	<hr />

	<h4>Job Info:</h4>
	<div id="lefttable"><span class="jobinfo">Account Rep: </span></div><div id="righttable"><?php echo $arf_name.' '.$arl_name; ?></div><div id="break"></div>
	<div id="lefttable"><span class="jobinfo">Job Name:</span></div><div id="righttable"><?php echo $companyname.' : '.$job_name; ?></div><div id="break"></div>
	<div id="lefttable"><span class="jobinfo">Location:</span></div><div id="righttable"><?php echo $address; ?><br /><?php echo $city.', '.$state.' '.$zip; ?></div><div id="break"></div>
	<div id="lefttable"><span class="jobinfo">Budget:</span></div><div id="righttable"><?php echo $budget; ?></div><div id="break"></div>
	<div id="lefttable"><span class="jobinfo">Write Up Due Date:</span></div><div id="righttable"><?php echo date('m/d/Y', strtotime($writeupdue)); ?></div><div id="break"></div>
	<div id="lefttable"><span class="jobinfo">Job Start Date:</span></div><div id="righttable"><?php echo date('m/d/Y', strtotime($jobstart)).' through '.date('m/d/Y', strtotime($jobstart2)); ?></div><div id="break"></div>
	<div id="lefttable"><span class="jobinfo">Terms:</span></div><div id="righttable"><?php echo $terms; ?></div><div id="break"></div>
	<hr />

	<div id="lefttable"><span class="jobinfo">Scope of Work:</span></div><div id="righttable"><?php echo nl2br($scope); ?></div><div id="break"></div>
	<hr />

	<?php
	// Get the job location info
	$sql = "select * from locations where idship_to_address = '$location'";
	$result = mysql_query($sql);
	if(!$result) {
		$message  = 'Invalid query: ' . mysql_error() . "\n";
		$message .= 'Whole query: ' . $result;
		die($message);
	}
					
	while($row = mysql_fetch_assoc($result)) {
		$address = $row['address'];
		$city = $row['city'];
		$state = $row['state'];
		$zip = $row['zip'];
		$phone = $row['phone'];
		$fax = $row['fax'];
	}
		
	// Get the billing address info
	$sql = "select * from job_locations where job_id = '$job_id' and billto = '1'";
	$result = mysql_query($sql);
		if(!$result) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $result;
			die($message);
		}
				
	while($row = mysql_fetch_assoc($result)) {
		$billto = $row['idship_to_address'];
		$sql = "select * from locations where idship_to_address='$billto'";
		$result = mysql_query($sql);
		if(!$result) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $result;
			die($message);
		}
				
		while($row = mysql_fetch_assoc($result)) {
			$billaddress = $row['address'];
			$billcity = $row['city'];
			$billstate = $row['state'];
			$billzip = $row['zip'];
			$billphone = $row['phone'];
			$billfax = $row['fax'];
		}
	}
	
	$num_rows = mysql_num_rows($result);
	if($num_rows > 0) {
		?>
   	    <h4>Addresses:</h4>
   	    <div id="lefttable"><span class="jobinfo">Bill to Address:</span></div><div id="righttable"><?php echo $billaddress; ?><br /><?php echo $billcity.', '.$billstate.' '.$billzip; ?></div><div id="break"></div><br />
		<?php 
		
		//Get the shipping address(es) info
		$sql = "select * from job_locations where job_id = '$job_id' and shipto = '1'";
		$result = mysql_query($sql);
		if(!$result) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $result;
			die($message);
		}
		$num_rows = mysql_num_rows($result);
		$i = 0;
		
		while($row = mysql_fetch_assoc($result)) {
			$shipids[] = $row['idship_to_address'];
		}

		foreach($shipids as $shipid) {	
			$sql = "select * from locations where idship_to_address = '$shipid'";
			$result = mysql_query($sql);
			if(!$result) {
				$message  = 'Invalid query: ' . mysql_error() . "\n";
				$message .= 'Whole query: ' . $result;
				die($message);
			}
			while($row = mysql_fetch_assoc($result)) {
			$shipaddress = $row['address'];
			$shipcity = $row['city'];
			$shipstate = $row['state'];
			$shipzip = $row['zip'];
			$shipphone = $row['phone'];
			$shipfax = $row['fax'];
			?>
			 <div id="lefttable"><span class="jobinfo">Work Location</span> <?php echo $i+1;  ?>:</div><div id="righttable"><?php echo $shipaddress . '<br />' . $shipcity.', '.$shipstate.' '.$shipzip; ?></div><div id="break"></div>
			<br />
			
			<?php
			$i++;	
			
			}
		}
		?>
		<hr />
		<?php
	}

	$sql = "select * from project_contacts where job_id = '$job_id' and is_rfq = '0'";
  $result = mysql_query($sql);
	if(!$result) {
		$message  = 'Invalid query: ' . mysql_error() . "\n";
		$message .= 'Whole query: ' . $result;
		die($message);
	}
	$num_rows = mysql_num_rows($result);
	if($num_rows > 0) {
		?>
		<h4>Project Contact(s):</h4>
		<!--Get and Dsiplay Project Contact Information-->
		<?php
		$i = 0;
		while($row = mysql_fetch_assoc($result)) {
			$custids[] = $row['idcustcontacts'];
		}
		
		foreach($custids as $custid) {
			$sql = "select * from cust_cont where idcustcontacts = '$custid'";
			$result = mysql_query($sql);
				if(!$result) {
					$message  = 'Invalid query: ' . mysql_error() . "\n";
					$message .= 'Whole query: ' . $result;
					die($message);
				}
			while($row = mysql_fetch_assoc($result)) {
				$pfirst = $row['cust_cont_first_name'];
				$plast = $row['cust_cont_last_name'];
				$ptitle = $row['cust_cont_title'];
				$pwork = $row['cust_cont_phone'];
				$pcell = $row['cust_cont_cell'];
				$pfax = $row['cust_cont_fax'];
				$pemail = $row['email'];
				?>
				<div id="lefttable"><span class="jobinfo">Contact <?php echo $i + 1;  ?>:</span></div><div id="righttable"></div><div id="break"></div>
				<div id="lefttable"><span class="jobinfo">Name:</span></div><div id="righttable"><?php echo $pfirst.' '.$plast; ?></div><div id="break"></div>
				<div id="lefttable"><span class="jobinfo">Title:</span></div><div id="righttable"><?php echo $ptitle; ?></div><div id="break"></div>
				<div id="lefttable"><span class="jobinfo">E-mail:</span></div><div id="righttable"><a href="mailto:<?php echo $pemail; ?>"><?php echo $pemail; ?></a></div><div id="break"></div>
				<div id="lefttable"><span class="jobinfo">Work Number:</span></div><div id="righttable"><?php echo $pwork; ?></div><div id="break"></div>
				<div id="lefttable"><span class="jobinfo">Cell Number:</span></div><div id="righttable"><?php echo $pcell; ?></div><div id="break"></div>
				<div id="lefttable"><span class="jobinfo">Fax Number:</span></div><div id="righttable"><?php echo $pfax; ?></div><div id="break"></div>
				<?php 
				$i++;
			} 
		}
		?>
		<br />
        <hr />
	<?php
	}

	$sql = "select * from project_writeup where jobid = '$job_id' order by iddepartments asc";
	$result = mysql_query($sql);
	if(!$result) {
		$message  = 'Invalid query: ' . mysql_error() . "\n";
		$message .= 'Whole query: ' . $result;
		die($message);
	}
	
	while($row = mysql_fetch_assoc($result)) {
		$departments[] = $row['iddepartments'];
	}
	
	foreach($departments as $department) {
		if($department == 1) {
			$depart = 'Electrical';
			$sdepart = 'electrical';
			$writeup = $electricalwriteup;
			$men = $electricalmen;
			$mendays = $electricalmendays;
			$menhours = $electricalmenhours;
			$purchasing = $electricalpurchasing;
			$laborcost = $electricallaborcost;
			$matcost = $electricalmaterialcost;
			$equipcost = $electricalequipmentcost;
			$actual = $electricalactualcost;
			$notes = $electricalnotes;
		}elseif($department == 2) {
			$depart = 'Foundations';
			$sdepart = 'foundations';
			$writeup = $foundationswriteup;
			$writeup = $foundationswriteup;
			$men = $foundationsmen;
			$mendays = $foundationsmendays;
			$menhours = $foundationsmenhours;
			$purchasing = $foundationspurchasing;
			$laborcost = $foundationslaborcost;
			$matcost = $foundationsmaterialcost;
			$equipcost = $foundationsequipmentcost;
			$actual = $foundationsactualcost;
			$notes = $foundationsnotes;
		}elseif($department == 3) {
			$depart = 'Carpentry';
			$sdepart = 'carpentry';
			$writeup = $carpentrywriteup;
			$men = $carpentrymen;
			$mendays = $carpentrymendays;
			$menhours = $carpentrymenhours;
			$purchasing = $carpentrypurchasing;
			$laborcost = $carpentrylaborcost;
			$matcost = $carpentrymaterialcost;
			$equipcost = $carpentryequipmentcost;
			$actual = $carpentryactualcost;
			$notes = $carpentrynotes;
		}elseif($department == 4) {
			$depart = 'Pipe Fitting';
			$sdepart = 'pipefitting';
			$writeup = $pipefittingwriteup;
			$men = $pipefittingmen;
			$mendays = $pipefittingmendays;
			$menhours = $pipefittingmenhours;
			$purchasing = $pipefittingpurchasing;
			$laborcost = $pipefittinglaborcost;
			$matcost = $pipefittingmaterialcost;
			$equipcost = $pipefittingequipmentcost;
			$actual = $pipefittingactualcost;
			$notes = $pipefittingnotes;
		}elseif($department == 5) {
			$depart = 'Rigging';
			$sdepart = 'rigging';
			$writeup = $riggingwriteup;
			$men = $riggingmen;
			$mendays = $riggingmendays;
			$menhours = $riggingmenhours;
			$purchasing = $riggingpurchasing;
			$laborcost = $rigginglaborcost;
			$matcost = $riggingmaterialcost;
			$equipcost = $riggingequipmentcost;
			$actual = $riggingactualcost;
			$notes = $riggingnotes;
		}elseif($department == 6) {
			$depart = 'HVAC';
			$sdepart = 'hvac';
			$writeup = $hvacwriteup;
			$men = $hvacmen;
			$mendays = $hvacmendays;
			$menhours = $hvacmenhours;
			$purchasing = $hvacpurchasing;
			$laborcost = $hvaclaborcost;
			$matcost = $hvacmaterialcost;
			$equipcost = $hvacequipmentcost;
			$actual = $hvacactualcost;
			$notes = $hvacnotes;
		}elseif($department == 7) {
			$depart = 'Painter';
			$sdepart = 'painter';
			$writeup = $painterwriteup;
			$men = $paintermen;
			$mendays = $paintermendays;
			$menhours = $paintermenhours;
			$purchasing = $painterpurchasing;
			$laborcost = $painterlaborcost;
			$matcost = $paintermaterialcost;
			$equipcost = $painterequipmentcost;
			$actual = $painteractualcost;
			$notes = $painternotes;
		}elseif($department == 8) {
			$depart = 'Mob Crew';
			$sdepart = 'mobcrew';
			$writeup = $mobcrewwriteup;
			$men = $mobcrewmen;
			$mendays = $mobcrewmendays;
			$menhours = $mobcrewmenhours;
			$purchasing = $mobcrewpurchasing;
			$laborcost = $mobcrewlaborcost;
			$matcost = $mobcrewmaterialcost;
			$equipcost = $mobcrewequipmentcost;
			$actual = $mobcrewactualcost;
			$notes = $mobcrewnotes;
		}elseif($department == 9) {
			$depart = 'Weld/Fab';
			$sdepart = 'weldfab';
			$writeup = $weldfabwriteup;
			$men = $weldfabmen;
			$mendays = $weldfabmendays;
			$menhours = $weldfabmenhours;
			$purchasing = $weldfabpurchasing;
			$laborcost = $weldfablaborcost;
			$matcost = $weldfabmaterialcost;
			$equipcost = $weldfabequipmentcost;
			$actual = $weldfabactualcost;
			$notes = $weldfabnotes;
		}elseif($department == 10) {
			$depart = 'Shop Guys';
			$sdepart = 'shopguys';
			$writeup = $shopguyswriteup;
			$men = $shopguysmen;
			$mendays = $shopguysmendays;
			$menhours = $shopguysmenhours;
			$purchasing = $shopguyspurchasing;
			$laborcost = $shopguyslaborcost;
			$matcost = $shopguysmaterialcost;
			$equipcost = $shopguysequipmentcost;
			$actual = $shopguysactualcost;
			$notes = $shopguysnotes;
		}elseif($department == 11) {
			$depart = 'Air Compressor';
			$sdepart = 'aircompressor';
			$writeup = $aircompressorwriteup;
			$men = $aircompressormen;
			$mendays = $aircompressormendays;
			$menhours = $aircompressormenhours;
			$purchasing = $aircompressorpurchasing;
			$laborcost = $aircompressorlaborcost;
			$matcost = $aircompressormaterialcost;
			$equipcost = $aircompressorequipmentcost;
			$actual = $aircompressoractualcost;
			$notes = $electricalnotes;
		}elseif($department == 12) {
			$depart = 'Mechanical';
			$sdepart = 'mechanical';
			$writeup = $mechanicalwriteup;
			$men = $mechanicalmen;
			$mendays = $mechanicalmendays;
			$menhours = $mechanicalmenhours;
			$purchasing = $mechanicalpurchasing;
			$laborcost = $mechanicallaborcost;
			$matcost = $mechanicalmaterialcost;
			$equipcost = $mechanicalequipmentcost;
			$actual = $mechanicalactualcost;
			$notes = $mechanicalnotes;
		}
		?>
		<br />
		<h4><?php echo $depart; ?> Write-up:</h4>
		<div id="lefttable"><span class="jobinfo">Site Visit Notes: </span></div>
		<?php 
		echo '<div id="righttable">'.nl2br($writeup).'</div><div id="break"></div>';
		
		$sql = "select * from equip_writeup where job_id = '$job_id' and iddepartments = '$department'";
		$result = mysql_query($sql);
		if(!$result) {
			 $message  = 'Invalid query: ' . mysql_error() . "\n";
			 $message .= 'Whole query: ' . $reqult;
			 die($message);
		}
		$count = mysql_num_rows($result); 
		if($count > 0) {
			?>
			<div id="<?php echo $sdepart."-equip"; ?>">
				<div id="lefttable"><span class="jobinfo">Equipment List:</span></div>
				<div id="righttable">
				<?php
				while($row = mysql_fetch_assoc($result)) {
					$eid[] = $row['equipment'];
				}
				foreach($eid as $e) {
					$sql = "select * from equipment where equipid= '$e'";
					$result = mysql_query($sql);
					if(!$result) {
						 $message  = 'Invalid query: ' . mysql_error() . "\n";
						 $message .= 'Whole query: ' . $reqult;
						 die($message);
					}
					while ($row = mysql_fetch_assoc($result)) {
						$equipname = $row['name'];			
						?>
						<?php echo $equipname ?>
						<?php
					}
				}
				unset($eid);
				?>
				</div><div id="break"></div>
			</div>
		<?php 
		}
		
		if($men || $mendays || $menhours) {
		?>
			<div id="lefttable"><span class="jobinfo">Man Power:</span></div><div id="righttable"></div><div id="break"></div>
			<?php
			if($men) {
				?>
				<div id="lefttable"><span class="jobinfo">Men:</span></div><div id="righttable"><?php echo $men; ?></div><div id="break"></div>
				<?php 
			}
			if($mendays) {
				?>
				<div id="lefttable"><span class="jobinfo">Days:</span></div><div id="righttable"><?php echo $mendays; ?></div><div id="break"></div>
				<?php 
			}
			if($menhours) {
				?>
				<div id="lefttable"><span class="jobinfo">Hours Per Day:</span></div><div id="righttable"><?php echo $menhours; ?></div><div id="break"></div>
				<?php
			}
		}
		?>
		<div id="lefttable"><span class="jobinfo">Purchasing Items:</span></div><div id="righttable">
			<?php 
		   if($purchasing = 'y') {
				echo "Yes";
			} else {
				echo "No";
			}
			?>
		</div><div id="break"></div>
		<?php
		if($laborcost) {
			?>
			<div id="lefttable"><span class="jobinfo">Cost of Labor:</span></div><div id="righttable"><?php echo $laborcost; ?></div><div id="break"></div>
			<?php
		}
		if($matcost) {
			?>
			<div id="lefttable"><span class="jobinfo">Cost of Materials:</span></div><div id="righttable"><?php echo $matcost; ?></div><div id="break"></div>
			<?php
		}
		if($equipcost) {
			?>
			<div id="lefttable"><span class="jobinfo">Equipment Cost:</span></div><div id="righttable"><?php echo $equipcost; ?></div><div id="break"></div>
			<?php 
		}
		if($actual) {
			?>
			<div id="lefttable"><span class="jobinfo">Actual Cost:</span></div><div id="righttable"><strong><?php echo $actual; ?></strong></div><div id="break"></div>
			<?php
		}
		if($notes) {
			?>
			<div id="lefttable"><span class="jobinfo">Extra Writeup Notes:</span></div><div id="righttable"><?php echo nl2br($notes); ?></div><div id="break"></div>
			<?php
		}
		?>
		<br />
		<hr />
		<?php
	}
	
	setlocale(LC_MONETARY, 'en_US');
	$sql = "select * from quotes where job_id='$job_id' order by rev desc limit 1";
	$result = mysql_query($sql);
	if(!$result) {
		$message  = 'Invalid query: ' . mysql_error() . "\n";
		$message .= 'Whole query: ' . $result;
		die($message);
	}
	$sales_count = mysql_num_rows($result);
	
	if($sales_count > 0) {
	?>
		<h4>Sales Writeup:</h4>
		<?php 
		while($row = mysql_fetch_assoc($result)) {
			$rev = $row['rev'];
		}
		
		$sql = "select * from quotes where job_id='$job_id' and rev='$rev'";
		$result = mysql_query($sql);
		if(!$result) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $result;
			die($message);
		}
		while($row = mysql_fetch_assoc($result)) {
			$items[] = $row['item'];
			$totals[] = $row['total'];
		}
		$i = 1;
		$num_rows = mysql_num_rows($result);
		if($num_rows > 0) {
			foreach($items as $t=>$item) {
				?>
				<div id="lefttable"><span class="jobinfo">Line Item <?php echo $i; ?></span></div><div id="righttable"><?php echo nl2br($item); ?></div><div id="break"></div>				
				<div id="lefttable"><span class="alignRight"><strong>Total</strong>: </span></div><div id="righttable"><?php echo money_format('%(#10n', $totals[$t]); ?></div><div id="break"></div>
				<br />
				<?php 
				$i++;
			}
			?>
			<div id="lefttable"><span class="jobinfo">Latest Revision: </span></div><div id="righttable">
			<?php 
			if($rev == 0) {
				echo "No Revisions";
			} else {
				echo $rev;
			}
			?>
			</div><div id="break"></div>
			<hr />
			<?php
		}
	}
	if(isset($ongoingnotes) || isset($changetracking) || isset($tmtracking)) {
		?>
		<h4>Project Management:</h4>
		<div id="lefttable"><span class="jobinfo">Ongoing Job Notes: </span></div><div id="righttable"><?php echo nl2br($ongoingnotes); ?></div><div id="break"></div>
		<br />
		<div id="lefttable"><span class="jobinfo">Change Order Tracking:</strong> </span></div><div id="righttable"><?php echo nl2br($changetracking); ?></div><div id="break"></div>
		<br />
		<div id="lefttable"><span class="jobinfo">T+M Tracking: </span></div><div id="righttable"><?php echo nl2br($tmtracking); ?></div><div id="break"></div>
		<br />
		<div id="lefttable"><span class="jobinfo">Percentage Complete:</strong> </span></div><div id="righttable"><?php if($completion == "") { echo "0%"; } else { echo $completion."%"; } ?></div><div id="break"></div>
		<?php
	}
	?>
</div>		<!-- end contentWrapper -->
</body>
</html>

<?php 
} else {
	echo "There is nothing to display in this cell.";
}
?>
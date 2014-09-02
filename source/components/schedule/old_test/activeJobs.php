<html>
<head>
	<title>schedule Test</title>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/schedule.css" />
	<script type="text/javascript" src="js/schedule3.js"></script>

<![if !IE]><link rel="stylesheet" href="../../../scripts/jquery.fancybox/fancybox/jquery.fancybox-1.3.4.css" type="text/css" media="screen" /><![endif]>
<![if !IE]><script type="text/javascript" src="../../../scripts/jquery.fancybox/fancybox/jquery.fancybox-1.3.4.pack.js"></script><![endif]>
<![if !IE]><script language="JavaScript" src="js/scrollyThing2.js"></script><![endif]>
<![if !IE]><script language="JavaScript" src="js/fancyBox.js"></script><![endif]>

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

/**********************************************/
/*     create the active jobs menu item       */
/**********************************************/
//       query for a list of active jobs
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
echo '<table border="1" class="activeJobs"><tr><td style="width:500px">JOB NAME</td><td style="width:500px">CUSTOMER NAME</td></tr>'; 

		
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
echo "</body></html>";





?>
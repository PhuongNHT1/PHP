<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Doc Dine v1.0 IIF Generator</title>
<meta name="robots" content="noindex, nofollow" />
<link href="../templatemo_style.css" rel="stylesheet" type="text/css" />
<link type="text/css" href="jquery-ui-1.8.10.custom.css" rel="Stylesheet" />	
<script type="text/javascript" src="jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="jquery-ui-1.8.10.custom.min.js"></script>
<script type="text/javascript" src="jquery.ui.core.js"></script>
<script type="text/javascript" src="jquery.ui.datepicker.js"></script>
<script type="text/javascript" src="jquery.ui.widget.js"></script>
<script type="text/javascript" src="timepicker.js"></script>
<script>
	$(function() {
		$("#startdate").datepicker({showOn: "button", buttonImage: "calendar.gif", buttonImageOnly: true});
			         //minDate: "-3M", maxDate: 0  'If needed'
					 });
	
	$(function() {
		$("#enddate").datepicker({showOn: "button", buttonImage: "calendar.gif", buttonImageOnly: true});
	                  //minDate: "-3M", maxDate: 0 'If needed'
					  });
</script>

<script language="javascript" type="text/javascript">
function validateSubmit() {
	if(document.form.startdate.value == "") {
		alert("Please insure you select a Start Date!");
		document.form.startdate.focus();
		return false;
	}
	if(document.form.enddate.value == "") {
		alert("Please insure you select an End Date!");
		document.form.enddate.focus();
		return false;
	}
}
</script>

<style type="text/css">
#entry {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10pt;
	font-weight: bold;
	border: 2px dashed;
	border-color: #CCC;
	background-color: #F5F5F5;
	width: 51%;
	position: relative;
	top: 3px;
	left: 230px;
	}
</style>
</head>

<body>

<div id="templatemo_container">
<div id="templatemo_header">
<div id="site_title">
<p>&nbsp;</p>
</div>
<div id="docdinelogo">
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
</div>
</div> 
 
<div id="templatemo_menu">
<ul>
<li class="current"><a href="../index.html"><b>Home</b></a></li>
</ul>
</div> 
    
<div id="templatemo_top_dishes">

<h1 align="center">Quickbooks IIF File Generator</h1>

<div align="center" id="entry">
<form action="" method="post" id="form" name="form">
Start Date:<input type="text" name="startdate" id="startdate" size="20" />
&nbsp;&nbsp;&nbsp;
End Date:<input type="text" name="enddate" id="enddate" size="20"/>
<br />
<br />
<input type="submit" name="submit" id="submit" value="Generate Quickbooks Import File" onClick="return validateSubmit()"/>
</form>
<br />

<?php

//Connect to database
include("connect.inc.php");

//Grab date values selected.
$startdate = $_POST['startdate'];
$enddate = $_POST['enddate'];

//Display in red last date and time IIF File Import was ran. 
if(isset($_COOKIE['lastimport'])) {
$lastimport = $_COOKIE['lastimport'];	
echo "<span class=submit_button>Your Last Quickbooks Import File Was Generated On:<br />
<font color=red> ".$lastimport."</font>";
} else {
echo "<font color=red>Cookies must enabled in your web browser<br />in order to see the last time that you ran 
the<br />Quickbooks IIF File Import!</font></span>";	
}

//If the Submit button is clicked,create the file. Form will not submit with enter key. A manual click to the submit button is needed.
if($_POST['submit']) {

/*Open the file in writable 'text' mode so that windows will append the necessary carriage-return characters onto the line-feed characters you send.
Once file is open, add Quickbooks header with the $qbheader variable. This is needed in order for a successfull IIF file import into QB.
*/Because we are using the 'w' in fopen(filepath,w), the existing file in the monthlyscans dir will be overwritten with the below. 
$file = fopen("../scans/monthlyscans/" .date("m-d-y")."QBDoctorMealScans.iif",'wt');
$qbheader = "!TRNS\tTRNSTYPE\tDATE\tACCNT\tNAME\tAMOUNT\tTOPRINT\tNAMEIS TAXABLE\tADDR1\r
!SPL\tTRNSTYPE\tDATE\tACCNT\tNAME\tAMOUNT\tPRICE\tINVITEM\r
!ENDTRNS\n";

//Write the Quickbooks header into the file
fwrite($file,$qbheader);
	   
/*Setup query to find dates user selected in iifexport.php. 
Ideally, the dates will be between first of month and last of month to get entire month of scans.
Once query finds desired dates, insert data from fields into $transline variable. 
Each STMT CHG should be on a line by itself. *Again, required for QB.
*/
$query = mssql_query("SELECT badgeno, CONVERT(VARCHAR(10),scantime,101) AS scantime, mealtype, price FROM sometable WHERE scantime BETWEEN '$startdate' AND '$enddate' ORDER BY scantime ASC ");
while($row = mssql_fetch_array($query)) {
$badgeno = $row['badgeno'];	
$scantime = $row['scantime'];	
$mealtype = $row['mealtype'];
$price = $row['price'];
$transline = "TRNS\tSTMT CHG\t".$scantime."\tDoctors\t".$badgeno."\t".$price."\tY\tN\t\r
SPL\tSTMT CHG\t".$scantime."\tMeals:".$mealtype."\t \t-".$price."\t-1\t".$mealtype."\r
ENDTRNS\n";

//Let's do some magic :-) Take all the data from the query and insert it into our file.
fwrite($file,$transline);
                                        }
//Close our file
fclose($file);

//Send a copy of the file to the history folder for future reference if needed
$orig_file = "../scans/monthlyscans/" .date("m-d-y")."QBDoctorMealScans.iif";
$history_file = $_SERVER['DOCUMENT_ROOT']."\\applications\\phydining\\scans\\monthlyscans\\history\\".date("m-d-y")."QBDoctorMealScansBAK.iif";
$file_copy = copy($orig_file,$history_file);
if($file_copy) {
	header("Location: iiffilecreatesuccess.php");
    }

}

//Close DB connection
mssql_close($query);

?>

</div>
<br />
<br />    
<br />
<br />
</div> 

<div id="templatemo_footer">
<a href="../index.html">Home</a> |<a href="iifgenerator.php">IIF Export</a> |<a href="some_URL">Some Company's Hompage</a>| <a href="../faq.php">FAQs</a> | <a href="mailto:admin@email.com">Contact Us</a> | <a href="some_URL/scanerrors/filelist.php" target="_blank">Badge Error Logfile</a><br />
Doc Dine Developed By:Tony Hill - Solutions Development Analyst</div> 
</div>

</body>
</html>

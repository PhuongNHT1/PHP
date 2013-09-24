<?php require("connect.inc.php");?>
<html>
<head>
<meta name="robots" content="noindex, nofollow"> 
<title>E-Voice: Reporting</title>
<style type="text/css">
 
#header {
	position: absolute;
	top: 1px;
	height: 190px;
	width: 650px;
	border: 1px dashed #333;
    }
 
#form {
	position: absolute;
	top: 192px;
	height: 85%;
	width: 650px;
	background-color: #F7F7F7;
	border: 1px dashed #333;
	height: 504px;
	padding: 5px;
	color:#F00;
    }

.form_font {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10pt;
	font-weight: bold;	
	color: #333;
	text-align: center;
    }
	
.results_font {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 9pt;
	color: #333;
	text-align: left;
	padding: 3px;
	border: 1px dashed #CCC;
    }

.row_data {
    background: #E4E4E4; 
    text-align: center;	
	width: 648px;
    }
	
.row_spacer {
   height: 7px;
   background-color: #999;	
   }
	
.timestamp_font {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 9pt;
	color: #333;
	text-align: center;
	padding: 3px;
	}	
	
.ascensionlogo {
	font-family: "Times New Roman", Times, serif;
	font-size: 12px;
	font-style: italic;
	font-weight: bold;
    }
	
.ascensionlogo1 {	
    text-align: center;
	font-family: "Times New Roman", Times, serif;
	font-size: 12px;
	font-style: italic;
	font-weight: bold;
    }
	
.evoicefont {	
    text-align: center;
	font-family: "Times New Roman", Times, serif;
	font-size: 14px;
	font-style: italic;
	font-weight: bold;
    }	
	
</style>

<script language="javascript" type="text/javascript">
function validateSubmit() {
	if(document.form.startdate.value == "") {
		alert("Please insure you select a From: Date!");
		document.form.startdate.focus();
		return false;
	}
	if(document.form.enddate.value == "") {
		alert("Please insure you select an To: Date!");
		document.form.enddate.focus();
		return false;
	}
}
</script>

<link type="text/css" href="some_URL/scans/jquery-ui-1.8.10.custom.css" rel="Stylesheet" />	
<script type="text/javascript" src="some_URL/scans/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="some_URL/scans/jquery-ui-1.8.10.custom.min.js"></script>
<script type="text/javascript" src="some_URL/scans/jquery.ui.core.js"></script>
<script type="text/javascript" src="some_URL/scans/jquery.ui.datepicker.js"></script>
<script type="text/javascript" src="some_URL/scans/jquery.ui.widget.js"></script>
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

</head>

<body bottommargin="5">
<div id="header">
<table width="650" border="0" align="center" cellpadding="1" cellspacing="1">
<tr>
<td valign="top" class="ascensionlogo1"><br>
<br>
<img src="STVHSLogo.png" width="250" height="66" alt="STVHS" />
<br />
</td>
<td class="evoicefont">
<p><span><img src="eVoice.png" alt="eVoice Logo" border="0" /></span>
<span>Sharing the Strength of our Ministry</span>
<br />
<br />
</td>
</tr>
</table>
</div>

<!--Begin topiccount.php results-->
<div id="form">

<p align="center">
<form method="post" action="topiccount.php" name="form" />
<p class="form_font">Topic Count By Senior Executive:
<br />
<br />
From:<input type="text" name="startdate" id="startdate" size="20" />
&nbsp;&nbsp;&nbsp;
To:<input type="text" name="enddate" id="enddate" size="20"/>
<br />
<br />
<input type="submit" name="submit" value="Submit" onClick="return validateSubmit();" />
</form>
</p>

<?php

//Grab date values selected 
$startdate = $_POST['startdate'];
$enddate = $_POST['enddate'];

if(isset($startdate) && !empty($startdate) && isset($enddate) && !empty($enddate)) {

//Setup query to return topic count by manager
$query = mysql_query("SELECT DISTINCT evoicename, COUNT(*) AS topiccount, topic AS topic FROM sometable WHERE (id > 0) AND senddate BETWEEN '$startdate' AND '$enddate' GROUP BY evoicename, topic ORDER BY evoicename ASC");

//Count the total number of records returned based on From and To Date Range
$countquery = mysql_query("SELECT * FROM sometable WHERE senddate BETWEEN '$startdate' AND '$enddate'");
$totalcount = mysql_num_rows($countquery);

//Start the table to display the results
print "<br /><div align=center>";
print "<p class=timestamp_font>Statistics Results: <font color=red>".$startdate." to ".$enddate."</font></p>";
print "
<table class=results_font border=0 cellpadding=2 cellspacing=5>
<tr><td align=center><b><u>NAME</u></b></td>
<td align=center><b><u>TOPIC</u></b></td>
<td align=center><b><u>COUNT</u></b></td>
</tr>";
    
    //Loop through the records
    while($row = mysql_fetch_assoc($query)) {
		$name = $row['evoicename'];
		$topicname = $row['topic'];
		$topiccount = $row['topiccount'];
		
		//Display the results each in their own row
		print "<tr><td class=row_data>".$name."</td><td class=row_data>".$topicname."</td><td class=row_data>".$topiccount."</td></tr>";
		print "<tr><td class=row_spacer></td><td class=row_spacer></td><td class=row_spacer></td></tr>";
	 }
		print "<tr><td align=center></td><td align=right><b>Total:</td><td align=center><font color=red>".$totalcount."</font></td></tr>";

//End the table
print "</table></div>";
   
} 

//Close the connection
mysql_close($query);

?>

</div>
<!--End topiccount.php results-->

</body>
</html>

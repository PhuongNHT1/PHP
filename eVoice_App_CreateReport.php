<html>
<head>
<meta name="robots" content="noindex, nofollow"> 
<title>E-Voice: Reporting</title>
<style type="text/css">
 
#header {
	position: absolute;
	top: 2px;
	height: 100px;
	width: 100%;
	border: 1px dashed #333;
    }
 
#form {
	position: absolute;
	top: 161px;
	height: 65%;
	margin-bottom: 10px;
	width: 100%;
	background-color: #F7F7F7;
	border: 1px dashed #333;
	height: 180px;
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
	
.instructions {
    font-family: Arial, Helvetica, sans-serif;
	font-size: 10pt;
	font-weight: bold;	
	color: #F00;	
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

<!-- Validate names dropdown -->
<script language="javascript" type="text/javascript">
/*
<!-- hide script from older browsers

function validateForm(form)
{

if (document.form.names.options[document.form.names.selectedIndex].value == "none")
	{
	alert("Please select a name.");
	document.form.names.focus();
	return false;
	} 
	
else
 {
   return true;	 
 }
  
}
stop hiding script -->
*/
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

</head>

<body>
<div id="header">
<table width="100%" border="0" align="center" cellpadding="1" cellspacing="1">
<tr>
<td valign="top" class="ascensionlogo1"><br />
<br>
<img src="some_URL/evoice/STVHSLogo.png" width="250" height="66" alt="Ascension" />
</td>
<td class="evoicefont">
<p>
<span><img src="some_URL/evoice/eVoice.png" alt="eVoice Logo" border="0" /></span>
</p>
<p><b><span>Sharing the Strength of our Ministry</span></b></p>
<br />
<br />
</td>
</tr>
</table>
</div>

<form method="post" action="csvreportresults.php" name="form" id="form" onSubmit="return validateForm(form);">
<br />
<br />
<p class="form_font">
Show me eVoice usage:
<br>
*Click on red calendar icon to choose a date.
<br />
<br />
From:<input type="text" name="startdate" id="startdate" size="20" />
&nbsp;&nbsp;&nbsp;
To:<input type="text" name="enddate" id="enddate" size="20"/>
<br />
<br />
<input type="submit" name="submit" value="Submit" onClick="return validateSubmit();" />
<br />
</p>
</form>

</body>
</html>

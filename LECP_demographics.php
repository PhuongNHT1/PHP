<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8" />
<title>LECP</title>
<link rel="stylesheet" href="css/main.css" type="text/css" />
<script language="javascript" type="text/javascript" src="js/fieldvalidation.js"></script>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<!--[if IE]>
<script src="http://html5shiv.google.com/svn/trunk/html5.js"></script>
<![end if]-->
</head>

<body>
<h1>Lovenox(enoxaparin)/Epidural Catheter Protocol</h1>
<h2>PATIENT INFORMATION:</h2>
<form method="post" action="hadsurgerypast24hrsresults.php" name="demographicsp3" id="demographicsp3" onSubmit="return validate_hadsurgerycheckbox();" >
<label>First Name:</label><input type="text" name="demographicsp3fname" id="demographicsp3fname" />
<br /><br />
<label>Last Name:</label><input type="text" name="demographicsp3lname" id="demographicsp3lname" /> 
<br /><br />
<label>Room No.:</label><input type="text" name="demographicsp3roomnum" id="demographicsp3roomnum" /> 
<br /><br />
<label>Current Date and Time:</label><input name="demographicsp3datetime" type="text" value="<?php echo date("m/d/Y H:i");?>" readonly="readonly" /> 
<br /><br />
<h2>Has the patient had surgery within the past 24 hours?</h2> 
Yes<input type="checkbox" name="hadsurgerypast24hrs" value="Yes" />&nbsp;No<input type="checkbox" name="hadsurgerypast24hrs" value="No"/> 
<br /><br />
<input type="submit" name="submit" value="Continue" onFocus="validate_demographicsp3();" /> 
</form>



</body>

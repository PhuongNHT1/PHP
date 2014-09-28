<?php
session_start();
session_register('lovlastadmin');
?>

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
<?php
//Last time Lovenox was administered. Convert to Epoch to use with time variables.
$lovlastadmin = $_SESSION['lovlastadmin'] = $_POST['lovlastadmin'];

//Convert above date into the Unix timestamp.
$lovlasttime = strtotime($lovlastadmin); 

//Store the current time.
$current_time = time();

//Store the difference in number of seconds between lovenox last admin field and current time.
$time_diff = $current_time - $lovlasttime;

//Calculate the number of days, hours, and minutes that have passed.
$days_passed = floor($time_diff/60/60/24);
$hours_passed = floor($time_diff/60/60)%24;
$minutes_passed = floor($time_diff/60)%60;

//2. Remove epidural in 18 hours.
$removeepidural = $lovlasttime +18*60*60;

//3. Next dosage of Lovenox (enoxaparin).
$nextdosage = $removeepidural +3*60*60;

//4. Resume regulary scheduled Lovenox.
$resumelov = $nextdosage +24*60*60;

if($time_diff <= 64800)  { // Less than or equal to 18 hrs ago. 
 echo "
<div id='protocol_layout'>
<div id='patient_label'>Patient Label</div>
<h2 align='left'>LOVENOX (enoxaparin) / EPIDURAL CATHETER PROTOCOL</h2>
<span class='protocol_text'>Protocol 1
<br />
Less than 18 hours since Lovenox was last administered<b> ".$hours_passed. "</b> hour(s) and <b>".$minutes_passed."</b> minute(s) ago.
</span>
<br /><br />
<div id='form_results'>
First Name: <span class='form_field_results' >"  .$_SESSION['patient_fname'].  "</span>
Last Name: <span class='form_field_results'>"  .$_SESSION['patient_lname'].  "</span>
<br />Room Number: <span class='form_field_results'>"  .$_SESSION['patient_roomno'].  "</span>
<br />Current Date and Time: <span class='form_field_results'>"  .date('m/d/Y H:i').  "</span>
<br />Date and time that Lovenox (enoxaparin) was last administered: <span class='form_field_results'>" .$lovlastadmin. "</span>
</div>
<br />
<b>1. If epidural medication has not been turned off, do so NOW.</b>
<br /><br />
2. Remove epidural catheter at:<span class='form_field_results'> ".date('m/d/Y H:i',$removeepidural)."</span>
<br />
(A minimum of 18 hours must elapse from the time Lovenox was last administered before the epidural catheter can be removed.)
<br /><br />
3. Administer next dose of Lovenox (enoxaparin) at: <span class='form_field_results'>".date('m/d/Y H:i',$nextdosage)."</span>
<br />
(A minimum of 3 hours must elapse between the removal of the epidural catheter and the next administration of Lovenox.)
<br /><br />
4. Resume regulary scheduled Lovenox (enoxaparin) dosing on: <span class='form_field_results'>".date('m/d/Y H:i',$resumelov)."</span>
<br /><br />
<b><u>UNLESS, today's dose was given between 22:01 and 05:59. For any dose given today between the hours of 22:01 and 05:59, administer
at the time indicated in the right-hand column of the chart below.</u></b>
<br />
<table border='1' align='center' cellpadding='2' cellspacing='2'>
<tr>
<td align='center'>For all doses given today between the times of:</td>
<td align='center'>All future daily dosing will resume will resume at the following times:</td>
</tr>
<tr><td align='center'>22:01 - 23:59</td><td align='center'>22:00 the next day</td></tr>
<tr><td align='center'>24:00 - 01:59</td><td align='center'>22:00 this PM</td></tr>
<tr><td align='center'>02:00 - 05:59</td><td align='center'>06:00 the next day</td></tr>
</table>
<br /><br />
5.<input type='button' value='PRINT THIS PAGE' onClick='window.print();'> as the order sheet for the chart.
<br /><br />
6. Record on MAR, scan to Pharmacy, and place order sheet on chart.
<br /><br />
RN Signature: __________________________ 
<br />
Date: ______________ Time: _____________
<br /><br />
Scanned to Pharmacy by: _____________________(initials) 
<br />
Date: ______________ Time: __________________
</div>
</div>";
} 
elseif($time_diff >= 64860 && $time_diff < 75600) { // >= 18hrs and 1 sec, but less than 21 hrs.
	echo "
<div id='protocol_layout'>
<div id='patient_label'>Patient Label</div>
LOVENOX (enoxaparin) / EPIDURAL CATHETER PROTOCOL
<br />
<span class='protocol_text'>Protocol 2
<br />
18 to 21 hours since Lovenox was last administered <b>".$hours_passed. "</b> hour(s) and <b>".$minutes_passed."</b> minute(s) ago.
</span>
<br /><br />
<div id='form_results'>
First Name: <span class='form_field_results' >"  .$_SESSION['patient_fname'].  "</span>
Last Name: <span class='form_field_results'>"  .$_SESSION['patient_lname'].  "</span>
<br />Room Number: <span class='form_field_results'>"  .$_SESSION['patient_roomno'].  "</span>
<br />Current Date and Time: <span class='form_field_results'>"  .date('m/d/Y H:i').  "</span>
<br />Date and time that Lovenox (enoxaparin) was last administered: <span class='form_field_results'>" .$lovlastadmin. "</span>
</div>
<br />
<b>1. If epidural medication has not been turned off, do so NOW.</b>
<br /><br />
2. Remove epidural catheter <b>NOW</b> at: <span class='form_field_results'>".date('m/d/Y H:i',$removeepidural)."</span>
<br />
(A minimum of 18 hours must elapse from the time Lovenox was last administered before the epidural catheter can be removed.)
<br /><br />
3. Administer next dose of Lovenox (enoxaparin) at: <span class='form_field_results'>".date('m/d/Y H:i',$nextdosage)."</span>
<br />
(A minimum of 3 hours must elapse between the removal of the epidural catheter and the next administration of Lovenox.)
<br /><br />
4. Resume regulary scheduled Lovenox (enoxaparin) dosing on: <span class='form_field_results'>".date('m/d/Y H:i',$resumelov)."</span>
<br /><br />
<b><u>UNLESS, today's dose was given between 22:01 and 05:59. For any dose given today between the hours of 22:01 and 05:59, administer
at the time indicated in the right-hand column of the chart below.</u></b>
<br />
<table border='1' align='center' cellpadding='2' cellspacing='2'>
<tr>
<td align='center'>For all doses given today between the times of:</td>
<td align='center'>All future daily dosing will resume will resume at the following times:</td>
</tr>
<tr><td align='center'>22:01 - 23:59</td><td align='center'>22:00 the next day</td></tr>
<tr><td align='center'>24:00 - 01:59</td><td align='center'>22:00 this PM</td></tr>
<tr><td align='center'>02:00 - 05:59</td><td align='center'>06:00 the next day</td></tr>
</table>
<br /><br />
5. Record on MAR, scan to Pharmacy, and place order sheet on chart.
<br /><br />
RN Signature: __________________________ 
<br />
Date: ______________ Time: _____________
<br /><br />
Scanned to Pharmacy by: _____________________(initials) 
<br />
Date: ______________ Time: __________________
</div>
</div>";
}
elseif($time_diff >= 75600 && $time_diff < 86400) { // >= 21 hrs, but less than 24 hrs.
	echo "
<div id='protocol_layout'>
<div id='patient_label'>Patient Label</div>
LOVENOX (enoxaparin) / EPIDURAL CATHETER PROTOCOL
<br />
<span class='protocol_text'>Protocol 3
<br />
21-24 hours since last dose of Lovenox was administered <b>".$hours_passed. "</b> hour(s) and <b>".$minutes_passed."</b> minute(s) ago.
</span>
<br /><br />
<div id='form_results'>
First Name: <span class='form_field_results' >"  .$_SESSION['patient_fname'].  "</span>
Last Name: <span class='form_field_results'>"  .$_SESSION['patient_lname'].  "</span>
<br />Room Number: <span class='form_field_results'>"  .$_SESSION['patient_roomno'].  "</span>
<br />Current Date and Time: <span class='form_field_results'>"  .date('m/d/Y H:i').  "</span>
<br />Date and time that Lovenox (enoxaparin) was last administered: <span class='form_field_results'>" .$lovlastadmin. "</span>
</div>
<br />
<b>1. If epidural medication has not been turned off, do so NOW.</b>
<br /><br />
2. Remove epidural catheter at: <span class='form_field_results'>".date('m/d/Y H:i',$removeepidural)."</span>
<br />
(A minimum of 18 hours must elapse from the time Lovenox was last administered before the epidural catheter can be removed.)
<br /><br />
3. Administer next dose of Lovenox (enoxaparin) at: <span class='form_field_results'>".date('m/d/Y H:i',$nextdosage)."</span>
<br />
(A minimum of 3 hours must elapse between the removal of the epidural catheter and the next administration of Lovenox.)
<br /><br />
4. Resume regulary scheduled Lovenox (enoxaparin) dosing on: <span class='form_field_results'>".date('m/d/Y H:i',$resumelov)."</span>
<br /><br />
<b><u>UNLESS, today's dose was given between 22:01 and 05:59. For any dose given today between the hours of 22:01 and 05:59, administer
at the time indicated in the right-hand column of the chart below.</u></b>
<br />
<table border='1' align='center' cellpadding='2' cellspacing='2'>
<tr>
<td align='center'>For all doses given today between the times of:</td>
<td align='center'>All future daily dosing will resume will resume at the following times:</td>
</tr>
<tr><td align='center'>22:01 - 23:59</td><td align='center'>22:00 the next day</td></tr>
<tr><td align='center'>24:00 - 01:59</td><td align='center'>22:00 this PM</td></tr>
<tr><td align='center'>02:00 - 05:59</td><td align='center'>06:00 the next day</td></tr>
</table>
<br />
<br />
5. Record on MAR, scan to Pharmacy, and place order sheet on chart.
<br />
<br />
RN Signature: __________________________ 
<br />
Date: ______________ Time: _____________
<br /><br />
Scanned to Pharmacy by: _____________________(initials) 
<br />
Date: ______________ Time: __________________
</div>
</div>";
}
elseif($time_diff > 86401) { // One second greater than 24 hours.
	echo "
<div id='form_results'>
<p class='form_fieldnames'>
First Name: <span class='form_field_results' >"  .$_SESSION['patient_fname'].  "</span>
Last Name: <span class='form_field_results'>"  .$_SESSION['patient_lname'].  "</span>
<br />Room Number: <span class='form_field_results'>"  .$_SESSION['patient_roomno'].  "</span>
<br />Current Date and Time: <span class='form_field_results'>"  .date('m/d/Y H:i').  "</span>
<br />Date and time that Lovenox (enoxaparin) was last administered: <span class='form_field_results'>" .$lovlastadmin. "</span>
</p>
</div>
<span class='notrun'>
<p align='center'>
WARNING: It has been greater than 24 hours since Lovenox was last administered 
<b><font color='black'>".$days_passed."</font></b> day(s), <b><font color='black'>".$hours_passed. "</font></b> hour(s), and <b><font color='black'>".$minutes_passed."</font></b> minute(s) ago.
</span>
<span class='protocoltext'>
<br /><br />
1. Contact Anesthesiology for directions on removal of epidural catheter and administration of Lovenox.
<br />
2. Complete SafERsystems Event Report as a medication error has occurred.
</span>
</p>

";
} 
else {
  echo "Error, time not in range of protocols!";	
}

//Kill the session
session_destroy();

?>
</body>

</html>

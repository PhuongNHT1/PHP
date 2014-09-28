<?php 
session_start();
session_register('patient_fname','patient_lname','patient_roomno','had_surgery');
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
//Get field data from demographicsp3.php page via session data
$patient_fname = $_SESSION['patient_fname'] = $_POST['demographicsp3fname'];
$patient_lname = $_SESSION['patient_lname'] = $_POST['demographicsp3lname'];
$patient_roomno =  $_SESSION['patient_roomno'] = $_POST['demographicsp3roomnum'];
$had_surgery = $_SESSION['had_surgery'] = $_POST['hadsurgerypast24hrs'];

//Display results depending on Yes or No input from previous demographicsp3.php page
if($had_surgery == 'Yes') {
echo
"
<h1>Lovenox(enoxaparin)/Epidural Catheter Protocol</h1>
<h2>PATIENT INFORMATION:</h2>
<p class='form_fieldnames'>First Name: <span class='form_field_results'>"  .$patient_fname.  "</span>&nbsp;&nbsp;
Last Name: <span class='form_field_results'>"  .$patient_lname.  "</span>
<br /><br />Room Number: <span class='form_field_results'>"  .$patient_roomno.  "</span>
<br /><br />Current Date and Time: <span class='form_field_results'>" .date('m/d/Y H:i'). "</span>
</p>
<br />
<form method='post' action='haspatreceivedlovporesults.php' name='hasreclovpo' onSubmit = 'return validate_lovpostop_checkbox();' >
<h2>Has the patient received any Lovenox post-operatively?</h2>
Yes<input type='checkbox' name='lovpostopquestion' value='Yes' />&nbsp;No<input type='checkbox' name='lovpostopquestion' />
<br /><br />
<input type='submit' name='submit' value='Continue' />
</form>
";
} else {
echo "
<h1>Lovenox(enoxaparin)/Epidural Catheter Protocol</h1>
<form method='post' action='haspatreceivedlovresults.php' name='hasrecanylov' onSubmit = 'return validate_hasrecanylov_checkbox();' >
<h2>Has the patient received any Lovenox?</h2>
Yes<input type='checkbox' name='anylovrecquestion' value='Yes' />&nbsp;No<input type='checkbox' name='anylovrecquestion' value='No' />
<br /><br />
<input type='submit' name='submit' value='Continue' />
</form>
";
}
?>

</body>


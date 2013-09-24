<?php require("connect.inc.php");?>

<html>
<head>
<meta name="robots" content="noindex, nofollow"> 
<title>Mailer: Version 1.1</title>
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
<style type="text/css">
 
#header {
	position: absolute;
	top: 6px;
	left: 1px;
	height: 116px;
	width: 890px;
	border: 1px dashed #333;
}
 
#form {
	position: absolute;
	top: 124px;
	left: 1px;
	width: 889px;
	background-color: #F7F7F7;
	border: 1px dashed #333;
	height: 779px;
	padding: 5px;
	color:#F00;
}

.input_fields {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10pt;
	font-weight: bold;	
	border-style: 1px inset;
	color: #333;
	}

.instructions {
    font-family: Arial, Helvetica, sans-serif;
	font-size: 10pt;
	font-weight: bold;	
	color: #F00;	
}

#facility_select {
	position: absolute;
	top: 123px;
	left: 103px;
	border: 1px dashed #333;
	background-color: #FFF;
	height: 22px;
}

.facility_dropdown  {
    font-family: Arial, Helvetica, sans-serif;
	font-size: 10pt;
	font-weight: bold;	
}

.message {
	position: absolute;
	top: 298px;
	left: 5px;
	border: 1px dashed #333;
	width: 863px;
	height: 198px;
}

#submit_button {
	position: absolute;
	top: 769px;
	left: 350px;
}

</style>

<!-- Validate name and message fields -->
<script language="javascript" type="text/javascript">
<!-- hide script from older browsers
function validateForm(form)
{

 if(""==document.forms.form.sender_name.value)
 {
 alert("Please enter your name!");
 document.forms.form.sender_name.focus();
 return false;
 }
}
stop hiding script -->
</script>
</head>
<body>
<div id="header">
<img src="PhyMailer.png" alt="Physician Mailer" border="0" width="873">
</div>
<form method="post" action="send.php" name="form" id="form" onSubmit="return validateForm(form);">
  <p>
  <br />
  <br />
  <span class="input_fields">Your Name:</span>
  <input type="text" name="sender_name" maxlength="51" size="51"/>
  <br>
  <!-- 
  For passing field value to sendresults.php if needed
  <span class=input_fields>Your Email Address:</span>
  <input type="text" name="sender_email" maxlength="42" size="42" />
  -->
  <input id="submit_button" type="submit" name="submit" value="Send Message" />
  <br />
  <br>
  <span class="instructions">
  To send email to ALL PHYSICIANS, click the checkbox below, enter your message, and click the Send Message button.</span>
  <br />
  <span class="input_fields"><span class="instructions">
  <input type="checkbox" name="alldeptspec" value="alldeptspec" />
  </span>Send message to all physicians.</span></p>
  <p> <br />
    
<?php
//Wrap dropdowns in table
print "<table border=0 width=100% cellpadding=2 cellspacing=2><tr>";

//Setup docname dropdown
print "<span class=instructions>To send email to a specific physician(s), please make your selection(s) below, enter your message, and click the Send Message button.</span>";
print "<td><span class=input_fields>Physician Name:<br /></span>";
echo "<select name=doctor[] multiple=multiple>";

// Setup query to display dropdown data
$doctor_query = mssql_query("SELECT (Lastname + Firstname + Middleinitial) AS Name FROM sometable ORDER BY Name ASC");

//Loop through Lastname column 
while($doctor_row = mssql_fetch_assoc($doctor_query))
                              {
							  $doctor_name = $doctor_row['Name'];
							  echo "<option>$doctor_name</option>";
							  }							  

echo "</select></td></tr>";

//Close the query
mysql_close($doctor_query);

//Setup department dropdown
print "
<tr><td>
<span class=instructions><br />To send email to a specific department, section, specialty, or status please make your selection(s), enter your message, and click the Send Message button.</span>
</td>
<td>
<span class=input_fields>Department:<br /></span>";
echo "<select name=department[] multiple=multiple>";

//Setup query to display dropdown data
$department_query = mssql_query("SELECT DISTINCT Departmentname FROM sometable ORDER BY Departmentname ASC");

//Loop through Department name column and display departments from table
while($department_row = mssql_fetch_assoc($department_query))
                {
							  $department = $department_row['Departmentname'];
							  echo "<option>$department</option>";
							  }							  

echo "</select></td>";

//Close the query
mysql_close($department_query);

//Setup Section dropdown
print "<td><span class=input_fields>Section:<br /></span>";
echo "<select name=section[] multiple=multiple>";

// Setup query to display dropdown data
$section_query = mssql_query("SELECT DISTINCT Section FROM sometable ORDER BY Section ASC");

//Loop through department column and display departments from table
while($section_row = mssql_fetch_assoc($section_query))
                {
							  $section = $section_row['Section'];
							  echo "<option>$section</option>";
							  }							  
echo "</select></td>";

//Close the query
mysql_close($section_query);
 
//Setup Specialty(Expertise) dropdown
print "<td><span class=input_fields>Specialty:<br /></span>";
echo "<select name=specialty[] multiple=multiple>";

// Setup query to display dropdown data
$specialty_query = mssql_query("SELECT DISTINCT Expertise FROM sometable ORDER BY Expertise ASC");

//Loop through Expertise column and display specialties
while($expertise_row = mssql_fetch_assoc($specialty_query))
                {
							  $specialty = $expertise_row['Expertise'];
							  echo "<option>$specialty</option>";
							  }							  
echo "</select></td>";

//Close the query
mysql_close($specialty_query);

//Setup Currentstatus dropdown
print "<td><span class=input_fields>Status:<br /></span>";
echo "<select name=status[] multiple=multiple>";

// Setup query to display dropdown data
$status_query = mssql_query("SELECT DISTINCT Currentstatus FROM sometable ORDER BY Currentstatus ASC");

//Loop through Currentstatus column and display statuses
while($status_row = mssql_fetch_assoc($status_query))
                {
							  $status = $status_row['Currentstatus'];
							  echo "<option>$status</option>";
							  }	
							  
echo "</select></td></tr></table>";

//Close the query
mysql_close($status_query);

?>

  <br />
  <br />
    <span class="input_fields">Enter Your Message:</span><br />
    <textarea name="message" class="message" id="message" cols="10" rows="10"></textarea>
    <!--Function that loads ckeditor window-->
    <script type="text/javascript">
	  window.onload = function()
	  {
		CKEDITOR.replace( 'message' );
	  };
    </script>
  </p>
</form>

</body>
</html>

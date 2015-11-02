<html>
<head>
<meta name="robots" content="noindex, nofollow">
<title>Physician Mailer Send Results</title>
<style type="text/css">
#body_header{
    font-family: arial;
    font-size: 12px;
    font-weight: bold;
}
#body_content {
    font-family: arial;
    font-size: 12px;
}
#results_area {
  position: absolute;
	top: 2px;
	left: 2px;
	width: 96%;
	border: thin #CCC 1px dotted;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10pt;
	text-align: center;
}
#no_email_list {
   width: 90%;
   border: dashed #CCC 1px dotted;
   font-family: Arial, Helvetica, sans-serif;
   font-size: 9pt;
   text-align: center;
}
</style>
</head>
<body>

<?php

//Turn on errors for browser
error_reporting(1);

//Connect to database
require("connect.inc.php");

$sender_name = $_POST['sender_name'];
$message = $_POST['message'];
$body = "
<html>
<head>
<style>
#body_header 
{
font-family: arial;
font-size: 12px;
font-weight: bold;
}
#body_content
{
font-family: arial;
font-size: 12px;
}
</style>
</head>
<body>
<p id=body_header>Hello,</p>
<p id=body_content>$message</p>
<p id=body_content>$sender_name<br />
Some Hospital<br />
Address Line 1<br />
Address Line 2<br />
Address Line 3<br /><br />
Phone<br /><br />
Fax<br />
</p>
</body>
</html>
";

//Force PHP to use this SMTP server address and email account -- (optional)
ini_set("SMTP","your SMTP address here");	
//This email address will show in the From field of the message. 
ini_set("sendmail_from","some email address"); 

//Setup mail parameters for HTML formatted email from $body variable
$subject = "Message From Hospital Medical Affairs Office";
$headers  = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";

echo "<div id=results_area>";
//Send mail to all physicians
if(isset($_POST['alldeptspec']))
{
	$allemails =mssql_query("SELECT DISTINCT some_column FROM some_table WHERE some_column IS NOT NULL");	
	//Loop through email column 		
	while($rowall = mssql_fetch_assoc($allemails))
	   {
	   $sendmail_all =  $rowall['PersonalSalutation']; //This variable will be used as the To: parameter for the mail() function
	   echo $sendmail_all."<br />"; //Displays a list of email addresses in results page so user can print page for record. 
	   mail($sendmail_all,$subject,$body,$headers);
	   }
	 echo "<br /><br />
	 Thank you $sender_name, your email has been sent on ".date("F j, Y, g:i a"). " to <b><u>ALL</u></b> physicians with an email address in MSO!
	<br /><br />
	<hr width=12%>
	<a href=javascript:history.go(-1)>Send Another Message</a>.
	<hr width=12%>
	<br /><br />
	 <u>Please Note</u>:The following physicians did not receive your message because they do not have an email address listed:
	<br />
	";
	//Check for <NULL> in emailaddress field. If found, display a list of docs along with their phone number who do not have email addresses.
	$no_email_address2 = mssql_query("SELECT * FROM some_table WHERE some_column IS NULL ORDER BY some_column ASC");
	while($row2 = mssql_fetch_assoc($no_email_address2)) 
	{
		$lname2 = $row2['Lastname'];
		$fname2 = $row2['Firstname'];
		$mname2 = $row2['Middleinitial'];
		$offphone2 = $row2['Phonenumber1'];
		echo $fname2. " " .$mname2. " " .$lname2. " " . " -- <u>Office Phone</u>:" .$offphone2. "<br />"; 
	}
	   mssql_close();
     
 }			 
 
//Send emails based on doctor(s) selected		     
			if(isset($_POST['doctor']))
			{
			 $doctor = $_POST['doctor'];
				foreach($doctor as $doc) {
				            $doc_sql = mssql_query("SELECT some_column FROM some_table WHERE (Lastname + Firstname + Middleinitial)='$doc'");
										 while($row = mssql_fetch_assoc($doc_sql))
										 {
										 $doc_email_address = $row['PersonalSalutation'];
										 echo $doc_email_address."<br />";
										 mail($doc_email_address,$subject,$body,$headers);
										  }
				                        }
										mssql_close();
			}	
			
//Send emails based on department(s) selected		   
			if(isset($_POST['department']))
			{
			$department = $_POST['department'];
			foreach($department as $dept)  {
			$status = $_POST['status'];
			foreach($status as $stat) {
			echo $stat."<br />";
			$dept_sql = mssql_query("SELECT some_column FROM some_table WHERE some_column='$dept' GROUP BY some_column,some_column HAVING some_column='$stat'"); 	
			while($row = mssql_fetch_assoc($dept_sql))
			{
			$dept_email_address = $row['PersonalSalutation'];
			echo $dept_email_address."<br />";
			mail($dept_email_address,$subject,$body,$headers);
			 }
										          }
			} mssql_close();
			}
		

//Send emails based on section(s) selected		   	 
/*			elseif(isset($_POST['section']))
			{
			$section = $_POST['section'];
			foreach($section as $sect) {
			$status = $_POST['status'];
			foreach($status as $stat) {
			echo $stat."<br />";
			$sect_sql = mssql_query("SELECT some_column FROM some_table WHERE some_column='$sect' GROUP BY some_column,some_column HAVING some_column='$stat'"); 	
			while($row = mssql_fetch_assoc($sect_sql)) 
			{
			$section_email_address = $row['PersonalSalutation'];
			echo $section_email_address."<br />";
			mail($section_email_address,$subject,$body,$headers);
			}
										           }
				    } mssql_close();
			}
*/

//Send emails based on specialty(s) selected		   	 
			elseif(isset($_POST['specialty']))
			{
			$specialty = $_POST['specialty'];
			foreach($specialty as $spec) {
			$status = $_POST['status'];
			foreach($status as $stat) {
			echo $stat."<br />";
			$spec_sql = mssql_query("SELECT some_column FROM some_table WHERE some_column='$spec' GROUP BY some_column,some_column HAVING some_column='$stat'"); 
			while($row = mssql_fetch_assoc($spec_sql)) 
			{
			$specialty_email_address = $row['PersonalSalutation'];
			echo $specialty_email_address."<br />";
			mail($specialty_email_address,$subject,$body,$headers);
			}
										          }
			} mssql_close();
			}
			
//Send emails based on status(s) selected		   	 
			elseif(isset($_POST['status']))
			{
			$status = $_POST['status'];
			foreach($status as $stat) {
			echo $stat."<br />";
			$status_sql = mssql_query("SELECT some_column FROM some_table WHERE some_column='$stat' GROUP BY some_column,some_column HAVING some_column='$stat'"); 	
			while($row = mssql_fetch_assoc($status_sql)) 
			{
			$status_email_address = $row['PersonalSalutation'];
			echo $status_email_address."<br />";
			mail($status_email_address,$subject,$body,$headers);
			}
			} mssql_close();
										 
			}
			 
//Display date and time message was sent along with which docs who do not have an email address in MSO		 
if(isset($doc_email_address) || isset($dept_email_address) || isset($specialty_email_address) ||  isset($status_email_address)) 
{
	 echo "<br /><br />Thank you $sender_name, your physician email was sent on ".date("F j, Y, g:i a")." using the following selections:<br /><br />";
	 echo "<b><u>Physician Name:</b></u>"; if(isset($_POST['doctor'])){$dn=$_POST['doctor'];foreach($dn as $docname) {echo "\t" .$docname. ","."\t";}}
	 echo "<br /><b><u>Department:</b></u>"; if(isset($_POST['department'])){$d=$_POST['department'];foreach($d as $dep) {echo "\t" .$dep."\t";}}
	 //echo "<br /><b><u>Section:</b></u>"; if(isset($_POST['section'])){$s=$_POST['section'];foreach($s as $sec) {echo "\t" .$sec."\t";}}
	 echo "<br /><b><u>Specialty:</b></u>"; if(isset($_POST['specialty'])){$sp=$_POST['specialty'];foreach($sp as $spe) {echo "\t" .$spe."\t";}}
	 echo "<br /><b><u>Status:</b></u>"; if(isset($_POST['status'])){$st=$_POST['status'];foreach($st as $sta) {echo "\t" .$sta."\t";}}
	 echo "<br /><br />
	<hr width=12%>
	<a href=javascript:history.go(-1)>Send Another Message</a>.
	<hr width=12%>
	<br />
	<u><font color=red>Please Note</u>:</font>These physicians do not have an email address listed in MSO:
	<br /><br />
	";
	//Check for <NULL> in emailaddress field. If found, display a list of docs along with their phone number who do not have email addresses.
	$no_email_address2 = mssql_query("SELECT * FROM some_table WHERE some_column IS NULL ORDER BY some_column ASC");
	while($row2 = mssql_fetch_assoc($no_email_address2)) 
	{
		$lname2 = $row2['Lastname'];
		$fname2 = $row2['Firstname'];
		$mname2 = $row2['Middleinitial'];
		$offphone2 = $row2['Phonenumber1'];
		$dep = $row2['Departmentname'];
		//$sec = $row2['Section'];
		$spe = $row2['Expertise'];
		$sta = $row2['Currentstatus'];
		echo "<table id=no_email_list><tr><td>" .$fname2. " " .$mname2. " " .$lname2. " " . " -- <b>Office Phone:</b>" .$offphone2. " " ."\t\t\t\t<b>Department:</b>" .$dep. " " ."\t\t\t\t<b>Specialty:</b>" .$spe. " " ."\t\t\t\t<b>Status:</b>" .$sta. "</td></tr></table><br /><br />"; 
	 }
	   mssql_close();	
}	
    echo "<br /><br /><input type=button value=Print onclick=window.print();return false; />";
    echo "</div>";
     
 ?>
<br /><br /><br />
</body>
 </html>

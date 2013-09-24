<?php include("connect.inc.php");  ?>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="noindex, nofollow" />
<title>Welcome to Some Company's Dining App!</title>

<style type="text/css">

#entry {
font-family: Arial, Helvetica, sans-serif;
font-size: 18pt;
font-weight: bold;
border: 2px dashed;
border-color: #CCC;
background-color: #F5F5F5;
width: auto;
position: absolute;
top: 20%;
left: 33%;
}

#badgenumber {
border: 3px solid #e1e0e0;	
}
</style>

<script language="javascript" type="text/javascript">
//A little code to make sure cursor is always blinking on page load and after each scan
function fieldfocus() {
document.	input.badgenumber.focus();
return false;
}
</script>

</head>

<body onload="fieldfocus();">

<div id="entry">
<form name= "input" method="post" action="">
Scan Your Badge:
<input type="text" name="badgenumber" id="badgenumber" maxlength="5" size="20" />
<!--<input type="submit" value="Send" name="submit" />-->
</form>

<?php

///Begin scan code

//Get badgenumber value from field 
$badgenum = $_POST['badgenumber'];

//Set meal prices, meal type, and current time
$breakfast = 2.5."0";
$bfastmealtype = 'Breakfast';
$lunchmealtype = 'Lunch';
$lunch = 4.5."0";
$time = date("H:i:s");
$datestamp = date("m-d-Y");

/*If badgenumber field value is not empty or doesn't contain lower/upper-case letters, 
proceed with SELECT query to find out if $num_rows does find a record with scanned
badge number. If it finds a record and badge number matches what is scanned, 
insert scan record with breakfast or lunch price according to time of day.
*/
if($badgenum != "" || $badgenum != preg_match("[a-z,A-Z]",$badgenum)) {
 $doctor_name = mssql_query("SELECT * FROM sometable WHERE badgeno = '$badgenum'") or die("Database connection failed!");
     while($row = mssql_fetch_assoc($doctor_name)) {
		 $physician_badge = $row['badgeno'];
		 }
$num_rows = mssql_num_rows($doctor_name);

//Close the database connection
mysql_close($doctor_name);
		
/*If no records are returned and badge number doesn't match query above when badge is scanned, 
log that badge number in badgeerrorreport.csv 
*/ Also, send email to Nancy and HR with badge number and time/date of scan. 
if($num_rows != 1 && $badgenum != $physician_badge) {
 $filepath = "../phydining/scanerrors/" .date("m-d-y")."badgeerrorreport.csv";	 
 $errorreportfile = fopen($filepath,'a');
 
$stringdata = $badgenum. " ,Time:" .date('H:i:s'). " ,Date:" .date("m-d-y"). "\n";
fwrite($errorreportfile,$stringdata);
fclose($errorreportfile);
		 
//Send email to Nancy and HR each time a bad badge number is scanned
//Force PHP to use this email account 
$server_email = ini_set("sendmail_from","someemail@somemailserver.com");

// Email address for copies to be sent to 
$emailto = "user1@mail.com,user2@mail.com,user3@mail.com";
//Add more - seperate by comma. 

// Notification email subject for your copy
$esubject = "-SECURE- Badge ID Request From Some Administration"; 
		 // Email body text for notifications
        $emailtext = "
        <html>
        <head>
        <style>
        .body_header 
        {
        font-family: arial;
        font-size: 10pt;
        font-weight: bold;
        }
        #body_content
        {
        font-family: arial;
        font-size: 10pt;
        } 
       </style>
       </head>
       <body>
       <span class=body_header>Unrecognized badge number was just scanned in Dining!
       <br /><br />
	     Please use badge number below to identify this person and forward to user1@mail.com and user2@stvhs.com with person's name.
		   <br />
	     Thank You!
		   <br />
		   <br />
		   <u>Meal Times Are As Followed</u>:<br />
		   Breakfast: 06:00 AM till 09:30 AM<br />
		   Lunch:11:00 AM till 13:30 PM<br />
		   </span>
       <br />
       <div id=body_content>
       <br />
       <b><u>Badge Information:</u></b><br /><br />
       <b>Badge Number:</b>$badgenum<br /><br /><br />
       <b>Scan Time:</b>$time<br /><br /><br />
       <b>Scan Date:</b>$datestamp<br /><br /><br />
	     </div>
	     <br />
	     <div id=body_content>
       If you have any questions, please contact the Some Administrative Office at the following:<br /><br />
       Jane Doe<br />
       Email: <a href=mailto:user1@mail.com>Some Person</a><br />
       Phone: (000) 000-0000 <br />
	     Fax: (000) 000-0000   <br />
       </div>
       </body>
       </html>
      ";
	    //Set content-type for sending email via HTML
      $header = "MIME-Version: 1.0" . "\r\n";
      $header .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
	    $header .= "From: $server_email";

      //Send the email
      mail($emailto, $esubject, $emailtext, $header);	
	  }
		
//Update physician's record according to breakfast or lunch time and if badge number matches $doctor_name query above.
	 if($time > '06:00:00' && $time < '09:30:00' && $badgenum != "") {
		 $getbadge = mssql_query("SELECT badgeno FROM sometable WHERE badgeno = '$badgenum' ");
  		 while($row1 = mssql_fetch_assoc($getbadge)) {
			 $badge = $row1['badgeno'];
			 }
			 if($badge == $badgenum) {
	     mssql_query("INSERT INTO sometable (badgeno, mealtype, price) VALUES ('$badge', '$bfastmealtype', '$breakfast')");
       }
			 echo "<p align=center>Thank you, enjoy your breakfast!<br /><br />Waiting for next scan...<br /><img src=waiting.gif border=0></p>";
      }
	 elseif($time > '11:00:00' && $time < '14:00:00' && $badgenum != "") {
	   $getbadge2 = mssql_query("SELECT badgeno FROM sometable WHERE badgeno = '$badgenum' ");
		   while($row1 = mssql_fetch_assoc($getbadge2)) {
			 $badge = $row1['badgeno'];
			 }
			 if($badge == $badgenum) {
				mssql_query("INSERT INTO sometable (badgeno, mealtype, price) VALUES ('$badge', '$lunchmealtype', '$lunch')");
			 }
		   echo "<p align=center>Thank you, enjoy your lunch!<br /><br />Waiting for next scan...<br /><img src=waiting.gif border=0></p>";
         } 
		   else {
	       echo "<br /><p align=center>Breakfast:6 AM till 9:30 AM<br /><br />Lunch:11:00 AM till 2:00 PM</p>";	
		   }
}

//Close connection
mssql_close();	

///End scan code///

?>

</div>
</body>
</html>

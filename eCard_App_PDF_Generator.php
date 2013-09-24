<?php

//Get form data
$patientname = $_POST['recipientname'];
$roomnum = $_POST['roomnum'];
$sendername = $_POST['sendername'];
$senderemail = $_POST['senderemail'];
$message = $_POST["message"];

//Setup filename for Output() in line 38
$file = "congratulations.pdf";

//Call fpdf.php class
require('fpdf.php');

//Custom from fpdf.php class
class PDF extends FPDF
{
   function Header()
    {
	global $patientname,$roomnum,$sendername,$message;
  //Set Background image and then output field data from form
   $this->Image('congratulations1.jpg',0,0,210); //0=From left, 0=From top,213=proportional resize -13 FROM TOP IS ORIG
   $this->SetFont('Times','I',26); //Was 28
   $this->Cell(36); //Position cells from left margin
   $this->Cell(120,18,"To:$patientname",0,2,'C'); //Cell width=120, Cell height=18, data, 0=no border, 2=not sure, C=Align text in center of cell
   $this->Cell(120,15,"Room:$roomnum",0,2,'C'); //" "
   $this->Cell(120,12,"From:$sendername",0,2,'C');
   $this->Ln();
   $this->Cell(36);
   $this->SetFont('Times','I',20); //Was 20
   $this->MultiCell(120,9,"$message",0,'J',false);
    }
}

//Create new PDF instance from fpdf.php class
 $pdf=new PDF();
 $pdf->SetTopMargin(80);
 $pdf->Output("$file",'F');
//End PDF generation and format
 
//Setup copy of ecard.pdf with "nameofsubmitter".pdf
$newfile = $_SERVER['DOCUMENT_ROOT']."\\php\\auxecards\\ecards\\"."congratulations".$_POST['recipientname'].".pdf";

//Make copy of ecard.pdf and send it to the ecards folder 
if($newfile) {copy($file,$newfile);}

//Send confirmation email to ecard sender
$to = $senderemail;

//Force PHP to use specific email account
$from = ini_set("SMTP","some_mail_server_IP");	
$from .= ini_set("sendmail_from","me@here.com");
$subject = "Your Sunshine Express E-Card Has Been Received!";
$message = 
"<html>
<head>
<style type=text/css>
.greeting {
font-family: arial;
font-size: 10pt;
font-weight: bold;
}
.body {
font-family:arial;
font-size: 10pt;
}
</style>
</head>
<body>
<p class=greeting>Dear $sendername,</p>
<p class=body>
Thank you for sending a Sunshine Express E-Card to a patient at some hospital! Your card has been received and will be printed for delivery.
<br />
<br />
<u>Please don't forget the following important notes regarding delivery of your card</u>: <br />
•	E-Cards are available for patients at some hospital campus only.<br /><br />
•	E-Cards are available only for inpatients (those who have been admitted to the hospital.) <br /><br />
•	E-cards are delivered only Monday through Friday by members of some auxiliary, although you may send us the card at anytime. <br /><br />
•	This service is not available on Saturdays, Sundays or holidays. <br /><br /> 
•	The Auxiliary is unable to forward Sunshine Express E-Cards to home addresses if the patient has been discharged. <br /><br />
• Please make sure your patient is still in the hospital, or will still be in the hospital on Monday through Friday. 
</p>
<br /><br />
<p class=body>
For questions or comments, please contact the following:<br />
Jane Doe, Acme Auxiliary<br />
Phone: 000-000-0000<br />
Email: Please reply to this email.
<br />
<a style=text-deocoration:none; href=some_URL/volunteerinfo.asp>Click Here</a> to visit the some hospital Auxiliary online!
</p>
</body>
</html>";
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
$header .= "From: $from";

//Fire off the email receipt to the sender
mail($to,$subject,$message,$headers);

//After pdf has been created and copy made in ecards directory for batch file to grab it and move it to pc, send email receipt to sender, and redirect back to ecard.asp page
header("Location: some_URL/ecard.asp");

?>

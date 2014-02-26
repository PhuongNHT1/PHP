<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Roll The Dice</title>
<style type="text/css" rel="stylesheet" href="css/dice.css"></style>
</head>
<body>
<div class="body_content">
<h1>Roll The Dice Program</h1>
<br />
<br />

<?php
//Create number range
$roll = rand(1,6);
print "You rolled a " .$roll;
print "<br />";
switch($roll) {
case 1:
$romValue = "I";
break;
case 2:
$romValue = "II";
break;
case 3:
$romValue = "III";
break;
case 4:
$romValue = "IV";
break;
case 5:
$romValue = "V";
break;
case 6:
$romValue = "VI";
break;
default:
print "This is not the case.";
}
print "<br /><img src='/images/die$roll.jpg'><br />";
?>

<br />

<section>Refresh this page in the browser to roll another die.</section>

</div>
</body>

</html>

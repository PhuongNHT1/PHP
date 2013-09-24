<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>eVoice: View Records</title> 
<meta name="robots" content="noindex,nofollow">
<style type="text/css">
.header {
font-family:Arial, Helvetica, sans-serif;
font-size: 11pt;
font-style:italic;
color:#06F;
}

.comment {
font-family:Arial, Helvetica, sans-serif;
font-size: 10pt;
}

.response {
font-family:Arial, Helvetica, sans-serif;
font-size: 10pt;
font-style: italic;
color:#06F;
}

.pagination {
font-family:Arial, Helvetica, sans-serif;
font-size: 10pt;
}

a:link {color:#00F;}
a:visited {color:#00F;}
a:active{color:#00F;}
</style>
</head>

<body>
<a name=top></a>
<form action="commentsearchresults.php" method="POST">
<strong><span class="comment">Search By:
<br />
leader's name <font color="#FF0000"> OR
</font> by comment, letter of appreciation keyword:(i.e. food, linens, security, patient care, etc.)<font color="#FF0000"> OR
</font> by submission date:(i.e. 01/19/2012)</span>
<br />
</strong>
<input name="commentsearch" type="text"  size="33" maxlength="75" />
<input type="submit" value="Search!" />
</form>
<br />

<?php

//Connect to the database 
include('connect.inc.php');

$limit = 6;
$start = 1;
$slice = 3;

//$q = "SELECT * FROM some_table WHERE approved='yes' ORDER BY responsedate DESC"; Commented out on 4-2-12.
$q = "SELECT * FROM some_table WHERE approved='yes' ORDER BY id DESC";
$r = mysql_query($q);
$totalrows = mysql_num_rows($r);

if(!isset($_GET['page']) || !is_numeric($_GET['page'])){
$page = 1;
} else {
$page = $_GET['page'];
}

$numofpages = ceil($totalrows / $limit);
$limitvalue = $page * $limit - ($limit);

if($page != 1) {
echo "";
} else {
echo "<p class=comment>This page has been viewed ";include("count.php"); echo " times!</p>";
}

echo "<a name=top></a><br />";

//Display pagination at top of page
if($page!= 1){
$pageprev = $page - 1;
echo '<a class=pagination href="'.$_SERVER['PHP_SELF'].'?page='.$pageprev.'">PREV</a> - ';
}else{
echo "<font class=pagination>PREV -</font> ";
}

if (($page + $slice) < $numofpages) {
$this_far = $page + $slice;
} else {
$this_far = $numofpages;
}

if (($start + $page) >= 6 && ($page - 6) > 0) {
$start = $page - 6;
}

for ($i = $start; $i <= $this_far; $i++){
if($i == $page){
echo "<u class=pagination><b>".$i."</b></u> ";
}else{
echo '<a class=pagination href="'.$_SERVER['PHP_SELF'].'?page='.$i.'">'.$i.'</a> ';
}
}

if(($totalrows - ($limit * $page)) > 0){
$pagenext = $page + 1;
echo ' - <a class=pagination href="'.$_SERVER['PHP_SELF'].'?page='.$pagenext.'">NEXT</a><hr />';
}else{
echo "<font class=pagination> - NEXT</font><br />";
}

//End pagination at top of page

//$q = "SELECT * FROM sometable WHERE approved ='yes' ORDER BY responsedate DESC LIMIT $limitvalue, $limit"; Commented out on 4-2-12.
$q = "SELECT * FROM sometable WHERE approved='yes' ORDER BY id DESC LIMIT $limitvalue, $limit";
if ($r = mysql_query($q)) {

//Display records here
while ($row = mysql_fetch_assoc($r)) {
        echo "<br />";
        if($row['anonymous']=='Yes') {
        echo "<br /><p class=header>An associate submitted the following on ".$row['senddate']."</p>"; 
				if(strlen($row['letterofappreciation']) > 0) {
				echo "<p class=comment><a target=_blank style=text-decoration:none; href=some_URL?id=".$row['id'].">
				<img src=thankyou.png border=0><i>Click here</a> to view letter of appreciation!</i></p>";
				}
				echo '<p class=comment><u>Comment</u>:<br />' .$row['comment']. '</p><br />';
				echo '<p class=response><u>Response From</u>: '.$row['evoicename'].' on '.$row['responsedate'].'<br />' .$row['response']. '</p><br /><br />';
				echo "<hr />";
				} 
				elseif($row['anonymous']=='No') {
                echo "<p class=header>An associate at ".$row['senderlocation']." submitted the following on ".$row['senddate']."</p>";	
				if(strlen($row['letterofappreciation']) > 0) {
				echo "<p class=comment><a target=_blank style=text-decoration:none; href=some_URL?id=".$row['id'].">
				<img src=thankyou.png border=0><i>Click here</a> to view letter of appreciation!</i></p>";
				}
				echo '<p class=comment><u>Comment</u>:<br />' .$row['comment']. '</p><br />';
				echo '<p class=response><u>Response From</u>: '.$row['evoicename'].' on '.$row['responsedate'].'<br />' .$row['response']. '</p><br /><br />';
				echo "<hr />";
				}
				elseif($row['evoicename']=='eVoice Administrator' && strlen($row['letterofappreciation']) > 0) {
				echo "<p class=comment><a target=_blank style=text-decoration:none; href=some_URL?id=".$row['id'].">
				<img src=thankyou.png border=0><i>Click here</a> to view letter of appreciation!</i></p>";
				echo '<p class=comment><u>Comment</u>:<br />' .$row['comment']. '</p><br />';
				echo '<p class=response><u>Response From</u>: '.$row['evoicename'].'<br />' .$row['response']. '</p><br /><br />';
				echo "<hr />";
				} 
				else {
				echo "No records returned!";	
				}
}

//Close the db connection
mysql_close($q);


//Display pagination at bottom of page
/*
if($page!= 1){
$pageprev = $page - 1;
echo '<a class=pagination href="'.$_SERVER['PHP_SELF'].'?page='.$pageprev.'">PREV</a> - ';
}else{
echo "<font class=pagination>PREV -</font> ";
}

if (($page + $slice) < $numofpages) {
$this_far = $page + $slice;
} else {
$this_far = $numofpages;
}

if (($start + $page) >= 3 && ($page - 3) > 0) {
$start = $page - 3;
}

for ($i = $start; $i <= $this_far; $i++){
if($i == $page){
echo "<u class=pagination><b>".$i."</b></u> ";
}else{
echo '<a class=pagination href="'.$_SERVER['PHP_SELF'].'?page='.$i.'">'.$i.'</a> ';
}
}

if(($totalrows - ($limit * $page)) > 0){
$pagenext = $page + 1;
echo ' - <a class=pagination href="'.$_SERVER['PHP_SELF'].'?page='.$pagenext.'">NEXT</a>';
}else{
echo "<font class=pagination> - NEXT</font>";
}
*/
}

echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class=pagination href=#top>Top of Page</a>";
?> 
</body>
</html>

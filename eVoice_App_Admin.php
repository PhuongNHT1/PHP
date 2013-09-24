<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd"> 
<html> 
<head> 
<title>eVoice: View Records</title> 
<meta name="robots" content="noindex,nofollow">

<style type="text/css">

a:link {color:#00F;}
a:visited {color:#00F;}
a:active{color:#00F;}

.commentheader {
font-family:Arial, Helvetica, sans-serif;
font-size: 10pt;
}

.comment {
font-family:Arial, Helvetica, sans-serif;
font-size: 10pt;
font-weight: normal; 
}

.pagination {
font-family:Arial, Helvetica, sans-serif;
font-size: 10pt;
}

</style>
//Open letter of appreciation form and .csv report generation window.
<script language="javascript" type="text/javascript">
function openevoicelop() {
adminwindow = window.open("some_URL","_blank","toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=706, height=840");
adminwindow.moveTo(250,1);	
}

function openevoicereportcsv() {
adminwindow = window.open("some_URL","_blank","toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=706, height=540");
adminwindow.moveTo(250,1);
}
</script>

</head> 
<body> 

<a name=top></a>
<span class="comment">
Show Me: 
<a href="approved.php">Approved</a>
|| <a href="needsresponse.php">Needs Response</a> 
|| <a href="pending.php">Pending</a> 
|| <a href="donotpost.php">Do Not Post</a> 
|| <a href="report.php" target="_blank">eVoice Reports</a> 
|| <a onclick="openevoicelop();" style="cursor:hand;color:#00F;text-decoration:underline;">Letter of Appreciation Submission</a> || <a onclick="openevoicereportcsv();" style="cursor:hand;color:#00F;text-decoration:underline;">eVoice Usage .csv File Export</a>
</span>
<br />
<form action="commentsearchresults.php" method="POST">
<strong><span class="comment">
<br />
Search Comments or Letter of Appreciation By keyword(s), send date, or leader name:</span>
<input type="text" name="commentsearch"  size="33" />
<input type="submit" value="Search!" />
</form>
<br />

<?php 

// Connect to the database 
include('connect.inc.php'); 

//Set limits for pagination beginning on line 87         
$limit = 10;
$start = 1;
$slice = 3;
         
$q = "SELECT * FROM some_table ORDER BY id DESC";
$r = mysql_query($q);
$totalrows = mysql_num_rows($r);

if(!isset($_GET['page']) || !is_numeric($_GET['page'])){
$page = 1;
} else {
$page = $_GET['page'];
}

$numofpages = ceil($totalrows / $limit);
$limitvalue = $page * $limit - ($limit);


echo "<a name=top></a>";

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

if (($start + $page) >= 10 && ($page - 10) > 0) {
$start = $page - 10;
}

for ($i = $start; $i <= $this_far; $i++){
if($i == $page){
echo "<u><b>".$i."</b></u> ";
}else{
echo '<a class=pagination href="'.$_SERVER['PHP_SELF'].'?page='.$i.'">'.$i.'</a> ';
}
}

if(($totalrows - ($limit * $page)) > 0){
$pagenext = $page + 1;
echo ' - <a class=pagination href="'.$_SERVER['PHP_SELF'].'?page='.$pagenext.'">NEXT</a>';
}else{
echo "<font class=pagination> - NEXT</font><br /><br />";
}
//End pagination at top of page

$q = "SELECT * FROM some_table ORDER BY id DESC LIMIT $limitvalue, $limit";
if ($r = mysql_query($q)) {
         
		 
        // display data in table 
        echo "<br /><br /><table border='1' cellpadding='5' align=center>"; 
        echo "<tr> <th class=commentheader>Evoice Name</th> <th class=commentheader>Topic</th> <th class=commentheader>Sender Name</th> <th class=commentheader>Send Date</th> <th class=commentheader>Comment</th> <th class=commentheader>Followup Notes</th><th class=commentheader>Response</th> <th class=commentheader>Approved</th> <th class=commentheader>Response Date</th><th class=commentheader>Letter of Apprec</th></tr>"; 
 
        //Display records here
          while ($row = mysql_fetch_assoc($r)) {
           // echo out the contents of each row into a table 
              echo "<tr>"; 
              //echo '<td>' .$row['id']. '</td>'; 
              echo '<td class=comment>' .$row['evoicename'].'</td>'; 
              echo '<td class=comment>' .$row['topic'].'</td>';
				      //echo '<td class=comment>' .$row['anonymous'].'</td>';
				      echo '<td class=comment>' .$row['sendername'].'</td>';
				      echo '<td class=comment>' .$row['senddate'].'</td>';
				      //echo '<td>' .$row['senderemail'].'</td>';
				     //echo '<td>' .$row['senderlocation'].'</td>';
				     echo '<td class=comment>' .$row['comment'].'</td>';
				     echo '<td class=comment>' .$row['followupnote'].'</td>';
				     echo '<td class=comment>' .$row['response'].'</td>';
				     echo '<td class=comment>' .$row['approved'].'</td>';	
				     echo '<td class=comment>' .$row['responsedate'].'</td>';
				     echo '<td class=comment>' .$row['letterofappreciation'].'</td>';
             echo '<td class=comment><a href="edit.php?id=' .$row['id']. '">Edit</a></td>'; 
             echo '<td class=comment><a href="delete.php?id=' .$row['id']. '">Delete</a></td>'; 
             echo "</tr>";  
        } 
        // close table> 
        echo "</table><br />";  

//Display pagination at bottom of page
if($page!= 1){
$pageprev = $page - 1;
echo '<br /><br /><a class=pagination href="'.$_SERVER['PHP_SELF'].'?page='.$pageprev.'">PREV</a> - ';
}else{
echo "<font class=pagination>PREV -</font> ";
}

if (($page + $slice) < $numofpages) {
$this_far = $page + $slice;
} else {
$this_far = $numofpages;
}

if (($start + $page) >= 10 && ($page - 10) > 0) {
$start = $page - 10;
}

for ($i = $start; $i <= $this_far; $i++){
if($i == $page){
echo "<u><b>".$i."</b></u> ";
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

}

//Close the database connection
mysql_close($r);

//echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class=pagination href=#top>Top of Page</a>";

?> 
<!--<p><a href="new.php">Add a new record</a></p>-->
 
</form>
</body> 
</html>

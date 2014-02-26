<?php

error_reporting(0);

//Max displayed per page
$per_page = 3;

//Get start variable
$start = $_GET['start'];

//Count records
$record_count = mysql_num_rows(mysql_query("SELECT * FROM some_table"));

//Count max pages
$max_pages = $record_count / $per_page; //May come out as decimal

if(!$start) {
$start = 0;
}

//Display the data
$get = mysql_query("SELECT * FROM some_table LIMIT $start, $per_page");
while($row = mysql_fetch_assoc($get)) {
$name = $row['name'];
$age = $row['age'];
echo $name." ($age)<br />"; 
}

//Setup prev and next variables
$prev = $start - $per_page;
$next = $start + $per_page;

//Show start button
if(!($start <= 0))
echo "<br /> <a href=index.php?start=$prev>Prev</a>  ";

//Set variable for first page
$i = 1;
//Show page numbers
for($x=0;$x<$record_count;$x=$x+$per_page) {
if($start != $x) {
echo " <a href=index.php?start=$x>$i</a> ";
} else {
echo " <a href=index.php?start=$x><b>$i</b></a> ";
}
$i++;
}

//Show end button
if(!($start >= $record_count - $per_page))
echo " <a href=index.php?start=$next>Next</a> ";

?>

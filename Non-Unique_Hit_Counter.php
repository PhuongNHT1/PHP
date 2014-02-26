<?php

function hit_count() {
//Specify our filename to store the count. *count.txt will be stored in same directory in this case.
$filename = 'count.txt';

//Open count.txt as 'read-only'. 
$handle = fopen($filename,'r');

//Open the file and read all characters 
$current = fread($handle,filesize($filename)); 

//Close the count.txt file
fclose($handle);

//Increment the number in count.txt  
$current_inc = $current + 1;

//Open the count.txt file again and write in the increment everytime is it opened
$handle = fopen($filename,'w');
fwrite($handle,$current_inc);

//Close the count.txt file
fclose($handle);
}


?>

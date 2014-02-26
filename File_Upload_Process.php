<?php

error_reporting(0);

// Put properties of uploaded file into variables. 
$name = $_FILES['myfile'] ['name'];
$type = $_FILES["myfile"] ["type"];
$extension = strtolower(substr($name,strpos($name,'.') +1)); //Make filename lowercase
echo $extension."<br />";
$size = $_FILES["myfile"] ["size"];
$maxsize = 2097152; //Use can use google to get file sizes - Type in for example "2 megabytes to" in search bar
$tmp = $_FILES["myfile"] ["tmp_name"];
$error = $_FILES["myfile"] ["error"];

//Set conditions for file before uploading just anything
//We want to check for file size limit and if file extension is .jpg
 if($size > $maxsize) {
  echo "Your file size of ".$size." is too big! Maximum allowed filesize is ".$mazsize." MB.<br />";
 } 
 else if(strpos("j",$extension) != 0 || strpos("p",$extension) != 1) {
  echo "You have chosen an incorrect file type of <b>.".$extension."</b><br /> <b>.jpg</b> is only allowed!";	 
 } 
 else {
  move_uploaded_file($tmp,"uploaded/".$name);
  echo "File upload was successfull!";
  echo "Details of your uploaded file >>";
  echo "Filename: ".$name."<br />";
  echo "Filetype: ".$type."<br />";
  echo "Filesize: ".$size."<br />";
 }
 
?>

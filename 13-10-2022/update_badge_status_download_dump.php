<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include('db.inc.php');
include('functions.php');


$path    = 'images/badges/';
$files = scandir($path);
$files = array_diff(scandir($path), array('.', '..'));
foreach($files as $file){
  

  $array = explode(".", $file);
  $unique_code = trim($array[0]);

  // if($unique_code !==""){
  // 	 // $updateGlobal = "UPDATE gjepclivedatabase.globalExhibition SET `isGenerated`='1'  WHERE uniqueIdentifier ='$unique_code'  ";
  // 	 // $resultUpdateGlobal = $conn->query($updateGlobal);
  // }

  
}




?>
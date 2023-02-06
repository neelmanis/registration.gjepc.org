<?php 
include('db.inc.php'); 

if($_SERVER['REQUEST_METHOD'] == "POST"){

$json = file_get_contents('php://input');
$obj = json_decode($json,true);
 

?>
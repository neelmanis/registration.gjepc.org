<?php
/*
** WEBSITE:REGISTRATION.GJEPC.ORG 
** FILE: DATABASE CONNECTION
** DEVELOPER: SANTOSH SHRIKHANDE
** PHP VERSION SUPPORT ABOVE 5.6
*/

date_default_timezone_set('Asia/Calcutta');
//  error_reporting(0);

$hostname = "localhost";
$uname = "gjepcliveuserdb";
$pwd = "KGj&6(pcvmLk5";
$database = "gjepclivedatabase";

// Create connection
$conn = new mysqli($hostname, $uname, $pwd, $database);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
	
}

/*
VERSION FOR CSS AND JS FILES
*/
$version = "1.1.28";
// Create a new CSRF token
function token()
{
	$token = substr(base_convert(sha1(uniqid(mt_rand())),16,36),0,32);
	$_SESSION['token'] = $token;
	//creating hidden field
	echo "<input type='hidden' name='token' value='$token'/>";
	return $token;
}


function filter($data)
{
   $data = stripslashes($data);
   $data = trim($data);
   $data = strip_tags($data);
   $data = htmlentities($data);
   return $data;
}

function filter_replace($data)
{
	$data=str_replace(" ","",$data);
	$data=str_replace(";","",$data);
	$data=str_replace("-","",$data);
	$data=str_replace("|","",$data);
	$data=str_replace("'","",$data);
	$data=str_replace("\"","",$data);
	$data=str_replace("*","",$data);
	return $data;
}

function clean($string) {
   $string = str_replace(' ', '_', $string); // Replaces all spaces with hyphens.
   $string = preg_replace('/[^A-Za-z0-9\.-]/', '', $string); // Removes special chars and leave dot
   $string = str_replace(".php","",$string); // Removes .php extension
   $string = preg_replace('/-+/', '_', $string); // Replaces multiple hyphens with single one.
   return $string;
}
	
foreach ($_REQUEST as $key => $value) {
   $request[$key] = filter($value);
}

foreach ($_GET as $key => $value) {
   $get[$key] = filter($value);
}

foreach ($_POST as $key => $value) {
   $post[$key] = filter($value);
}
?>
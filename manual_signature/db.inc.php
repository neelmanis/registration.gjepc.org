<?php
error_reporting(0);
$hostname = "192.168.40.107";
$uname="appadmin";
$pwd= "G@k593#sgtk";
$database="manual_signature";

// Create connection
$conn = new mysqli($hostname, $uname, $pwd, $database);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
	
}

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

function replace_comma($data)
{
	$data=str_replace(","," ",$data);
	$data=str_replace(";","",$data);
	$data=str_replace("-","",$data);
	$data=str_replace("|","",$data);
	$data=str_replace("'","",$data);
	$data=str_replace("\"","",$data);
	$data=str_replace("*","",$data);
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

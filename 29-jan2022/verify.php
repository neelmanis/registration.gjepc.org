
<?php include('header_include.php');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GJEPC</title>
<link rel="icon" href="https://gjepc.org/images/favicon.ico" type="image/x-icon"/>
<link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Cabin'>

<link rel="stylesheet" type="text/css" href="css/general.css?v=<?php echo $version;?>" />
<link rel="stylesheet" type="text/css" href="css/inner_pg_style.css?v=<?php echo $version;?>" />

<link rel="stylesheet" type="text/css" href="css/responsive.css?v=<?php echo $version;?>" />
<link rel="stylesheet" type="text/css" href="css/media_query.css?v=<?php echo $version;?>" />
<script type="text/javascript" src="js/jquery-1.8.3.min.js?v=<?php echo $version;?>"></script>
<style>
.n-danger {
    background-color:#f46262;
    border-color: #f46262;
	text-align:center;
}
</style>
</head>
<?php 

if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash']))
{
    $email = filter($_GET['email']); 
    $hash = filter($_GET['hash']); 

	$sqlx = "SELECT email_id, hash, status FROM registration_master WHERE email_id='$email'  AND status='0'";
	$result = $conn->query($sqlx);
	$match = $result->num_rows;
                 
    if($match > 0){
	$updx = "UPDATE registration_master SET status='1' WHERE email_id='".$email."'  AND status='0'";
	$result = $conn->query($updx);
        echo "<span class='notification n-success'>Your account has been activated, you can now login</span>";
    } else {
        echo "<span class='notification n-danger'>Your account already has been activated, you can now login <a href='https://registration.gjepc.org/login.php'>Click here.</a> </span>";
    }
                 
} else {
    echo "<span class='notification n-danger'>Invalid approach, please use the link that has been send to your email.</span>";
}
?>



<body>

</body>
</html>
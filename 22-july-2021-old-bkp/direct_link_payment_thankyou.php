<?php
session_start();
unset($_SESSION['orderId']);		
unset($_SESSION['visitor_id_temp']);		
unset($_SESSION['registration_id_temp']);
header("location:login.php");		
?>

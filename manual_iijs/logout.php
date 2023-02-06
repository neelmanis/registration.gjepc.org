<?php
session_start();
ob_start();
session_destroy();

unset($_SESSION['EXHIBITOR_CODE']);
unset($_SESSION['EMAILID']);
unset($_SESSION['CUST_NO']);
unset($_SESSION['EXHIBITOR_NAME']);
$_SESSION['succ_msg']="";
header("Location: https://gjepc.org/iijs-premiere/");  

?>
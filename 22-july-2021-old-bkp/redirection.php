<?php
session_start();
ob_start();
session_destroy();

unset($_SESSION['USERID']);
unset($_SESSION['EMAILID']);
unset($_SESSION['COMPANYNAME']);
unset($_SESSION['registration_id']);
header("Location:https://registration.gjepc.org/single_visitor.php"); exit;
?>
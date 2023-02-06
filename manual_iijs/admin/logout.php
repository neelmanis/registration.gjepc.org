<?php
session_start();
unset($_SESSION['admin_email_id']);
unset($_SESSION['admin_login_id']);
unset($_SESSION['admin_region_name']);
unset($_SESSION['admin_role']);
unset($_SESSION['admin_division_name']);

session_destroy();
echo"<meta http-equiv=refresh content=\"0;url=index.php\">";
?>

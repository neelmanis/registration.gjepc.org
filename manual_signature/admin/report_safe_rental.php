<?php session_start(); ?>
<?php include('../db.inc.php');?>
<?php include('../functions.php');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Safe Rental</title>

<link rel="stylesheet" type="text/css" href="css/style.css" />

<!--navigation-->
<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>      
<link rel="stylesheet" type="text/css" href="css/ddsmoothmenu.css" />
<script type="text/javascript" src="js/ddsmoothmenu.js"></script>

<link href="css/jquery.datepick.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.datepick.js"></script>
<script type="text/javascript">
$(function() {
	$('#popupDatepicker').datepick();
	$('#inlineDatepicker').datepick({onSelect: showDate});
	$('#popupDatepicker1').datepick();
	$('#inlineDatepicker1').datepick({onSelect: showDate});
});
function showDate(date) {
	alert('The date chosen is ' + date);}
</script>

<script type="text/javascript">
ddsmoothmenu.init({
	mainmenuid: "smoothmenu1", //menu DIV id
	orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"
	classname: 'ddsmoothmenu', //class added to menu's outer DIV
	//customtheme: ["#1c5a80", "#18374a"],
	contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
})
</script>
<!--navigation end-->

<!-- lightbox Thum -->
<link rel="stylesheet" type="text/css" href="css/jquery.fancybox.css" media="screen" />
<script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="js/jquery.fancybox-1.2.1.js"></script>
<script type="text/javascript">
		$(document).ready(function() {
			$("div.fancyDemo a").fancybox();
		});
</script>
<!-- lightbox Thum -->
</head>

<body>
<div id="header_wrapper"><?php include("include/header.php");?></div>

<div id="nav_wrapper">
	<div class="nav"><?php include("include/menu.php");?></div>
</div>

<div class="clear"></div>

<div class="breadcome_wrap">
	<div class="breadcome"><a href="report_wireless_internet.php">Home</a> > Safe Rental</div>
</div>

<div id="main">
	<div class="content">
    <div class="content_head"><div class="content_head_button">Safe Rental</div></div>
    <div class="content_details1">
	  <div class="report_button"><a href="export_safe_nonfill.php">Export to Excel Non Filled Exhibitor</a></div>&nbsp;&nbsp;
	  <div class="report_button"><a href="export_safe_approve.php">Export to Excel Approved</a></div>&nbsp;&nbsp;
	  <div class="report_button"><a href="export_safe_disapprove.php">Export to Excel DisApproved</a></div>&nbsp;&nbsp;
	  <div class="report_button"><a href="export_safe_pending.php">Export to Excel Pending</a></div>
	  <div class="report_button"><a href="export_safe_all.php">Export to Excel All</a></div>
	  <div class="report_button"><a href="export_godrej.php">Export Godrej</a></div>
	</div>
	<div class="clear"></div>	
	</div>
</div>
<div id="footer_wrap"><?php include("include/footer.php");?></div>
</body>
</html>
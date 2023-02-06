<?php session_start(); ?>
<?php include('../db.inc.php');?>
<?php include('../functions.php');?>

<?php
$id = $_REQUEST['id'];
$exhibitor_data = "select * from zone_manager where id='$id'";
$result = $conn->query($exhibitor_data);
$fetch_data = $result->fetch_assoc();

$zone_manager = $fetch_data['zone_manager'];
$mobile = $fetch_data['mobile'];
$email = $fetch_data['email'];
$division = $fetch_data['division'];
$section = $fetch_data['section'];

if(isset($_POST['Save']))
{
$zone_manager = $_POST['zone_manager'];
$mobile = $_POST['mobile'];
$email = $_POST['email'];
$division = $_POST['division'];
$section = $_POST['section'];


		$executeResult = $conn ->query("UPDATE `manual_iijs2021`.`zone_manager` SET `zone_manager` = '$zone_manager',mobile='$mobile', email='$email',division='$division',section='$section' WHERE id='$id'");
		if($executeResult)
		{
			echo '<script type="text/javascript">'; 
			echo 'alert("You have successfully update  your application.");'; 
			echo 'window.location.href = "manage_zone.php?action=view"';
			echo '</script>';	
			exit;
		}
		else
			echo "error while updating records";
  
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Zone Management</title>

<link rel="stylesheet" type="text/css" href="css/style.css" />
<!-- form css -->
<link rel="stylesheet" type="text/css" href="css/adminForm.css">
<!--navigation-->
<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>      
<link rel="stylesheet" type="text/css" href="css/ddsmoothmenu.css" />
<script type="text/javascript" src="js/ddsmoothmenu.js"></script>

<link href="css/jquery.datepick.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.datepick.js"></script>

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
	<div class="breadcome"><a href="search_application.php">Home</a> >Zone Management</div>
</div>

<div id="main">
	<div class="content">
    	<div class="content_head">Zone Management</div>
 
<div class="content_details22">
<div id="formWrapper">

<form name="catalogue_entry" id="form1" action="" enctype="multipart/form-data" method="post" onsubmit="return validation()">
<input type="hidden" name="action" value="ADD" />

<table border="0" cellspacing="0" cellpadding="0" class="formManual">
  <tr>
    <td class="bold">Zone Manager</td>
    <td>:</td>
    <td><input type="text" name="zone_manager" id="zone_manager" class="textField" value="<?php echo $zone_manager;?>"/>
      <input type="hidden" name="id" id="id" class="textField" value="<?php echo $id;?>"/>
      <br />
      <span id="name_error" class="error_msg"></span>
   </td>
    <td>&nbsp;</td>
    <td class="bold">Mobile</td>
    <td>:</td>
    <td><input type="text" name="mobile" id="mobile" class="textField" value="<?php echo $mobile;?>" /></td>
  </tr>
  
  <tr>
    <td class="bold">Email</td>
    <td>:</td>
    <td>
    <input type="text" name="email" id="email" class="textField" value="<?php echo $email;?>" />
    </td>
    <td>&nbsp;</td>
    <td class="bold">Division</td>
    <td>:</td>
    <td><input type="text" name="division" id="division" class="textField" value="<?php echo $division;?>" /></td>
  </tr>

  <tr>
    <td class="bold">Section<sup> </sup></td>
    <td>:</td>
    <td>
    <select name="section" id="section" >
    <option value="">-----Select Section----</option>
            <?php 
			
			$sql="SELECT * FROM signature_section_master";
            $query=$conn ->query($sql);
            while($result=$query->fetch_assoc()){
            ?>
            <option value="<?php echo $result['name'];?>" <?php if($result['name']==$section){?> selected="selected" <?php }?> ><?php echo $result['section_desc'];?></option>
            <?php }?>
            <option value="International Jewellery" <?php if($section=="International Jewellery"){?> selected="selected" <?php }?>>International Jewellery</option>
            <option value="International Loose" <?php if($section=="International Loose"){?> selected="selected" <?php }?>>International Loose</option>
    </select>
    </td>
   </tr>
 
</table>

<div class="clear"></div>

    <div align="center">
    <input type="hidden" name="Exhibitor_ID" id="Exhibitor_ID" value="<?php echo $_REQUEST['Exhibitor_ID'];?>"/>
        <input type="submit" name="Save" id="Save" value="Submit" class="maroon_btn" />
    </div>	
</form>
		</div>
		</div>
	</div>
</div>

<div id="footer_wrap"><?php include("include/footer.php");?></div>


</body>
</html>

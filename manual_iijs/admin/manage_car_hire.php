<?php session_start(); ?>
<?php include('../db.inc.php');?>
<?php include('../functions.php');?>
<?php
 
if($_REQUEST['Reset']=="Reset")
{
  $action="";
  $_SESSION['agent_id']="";
  $_SESSION['member_type']="";
  $_SESSION['status']="";
  $_SESSION['app_type']="";
  $_SESSION['from_date']="";
  $_SESSION['to_date']="";
 
  header("Location: manage_badges.php?action=view");
}else if($_REQUEST['action']=="search")
{ 
  $action=$_REQUEST['action'];
  $_SESSION['agent_id']=$_REQUEST['agent_id'];
  $_SESSION['member_type']=$_REQUEST['member_type'];
  $_SESSION['status']=$_REQUEST['status'];
  $_SESSION['app_type']=$_REQUEST['app_type'];
  $_SESSION['from_date']=$_REQUEST['from_date'];
  $_SESSION['to_date']=$_REQUEST['to_date'];
 
  if($action=='search')
  {
  	if($_SESSION['agent_id']=="")
	{
	$_SESSION['error_msg']="Please select Agent Name";
	}
	
	if($_SESSION['member_type']=="")
	{
	$_SESSION['error_msg1']="Please select Member Type";
	}
	
  }
}
?>  
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title> Manual || Manage Car Hire </title>

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
	<div class="breadcome"><a href="search_application.php">Home</a> > Manage Car Hire </div>
</div>

<div id="main">
	<div class="content">
    	<div class="content_head"><div class="content_head_button">Manage Car Hire</div></div>
    	
      
<div class="content_details1">
<form name="search" action="" method="post" > 
<input type="hidden" name="action" value="search" />        	
<?php 
if($_SESSION['error_msg']!=""){
echo "<span class='notification n-error'>".$_SESSION['error_msg']."</span>";
$_SESSION['error_msg']="";
}
if($_SESSION['error_msg1']!=""){
echo "<span class='notification n-error'>".$_SESSION['error_msg1']."</span>";
$_SESSION['error_msg1']="";
}

?>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt" >
<tr class="orange1">
    <td colspan="11" >Search Options</td>
</tr>
      
<tr >
    <td width="19%" ><strong>Search</strong></td>
    <td width="81%"><label>
      <input type="text" name="textfield" id="textfield" />
    </label></td>
</tr>	
    
    
<tr >
  <td><strong>Status</strong></td>
  <td><select name="status" id="status" class="input_txt">
    <option value="">Please Select Status</option>
    <?php 
	   $sql="select * from  kp_lookup_details where LOOKUP_ID='8'";
	   $result=mysql_query($sql);
	   while($rows=mysql_fetch_array($result))
	   {
	   if($rows['LOOKUP_VALUE_ID']==$_SESSION['status'])
	   {
	   echo "<option selected='selected' value='$rows[LOOKUP_VALUE_ID]'>$rows[LOOKUP_VALUE_NAME]</option>";
	   }else
	   {
	   echo "<option value='$rows[LOOKUP_VALUE_ID]'>$rows[LOOKUP_VALUE_NAME]</option>";
	   }
	   }
	   ?>
  </select></td>
  </tr>
<tr >
  <td><strong>Section</strong></td>
  <td><select name="status" id="status" class="input_txt">
    <option value="">Please Select Status</option>
    <?php 
	   $sql="select * from  kp_lookup_details where LOOKUP_ID='8'";
	   $result=mysql_query($sql);
	   while($rows=mysql_fetch_array($result))
	   {
	   if($rows['LOOKUP_VALUE_ID']==$_SESSION['status'])
	   {
	   echo "<option selected='selected' value='$rows[LOOKUP_VALUE_ID]'>$rows[LOOKUP_VALUE_NAME]</option>";
	   }else
	   {
	   echo "<option value='$rows[LOOKUP_VALUE_ID]'>$rows[LOOKUP_VALUE_NAME]</option>";
	   }
	   }
	   ?>
  </select></td>
  </tr>
<tr >
  <td>&nbsp;</td>
  <td><input type="submit" name="Search" value="Search"  class="input_submit" /> </td>
</tr>	
</table>
</form>      
</div>

<div class="content_details1">
<form name="form1" action="" method="post" > 

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  <tr class="orange1">
    <td>Exhibitor Name</td>
    <td>Country</td>
    <td>Date</td>
    <td>Info <br />
      Approved</td>
    <td>PickUp Info <br/> Approved</td>
	<td>Drop Info<br/> Approved</td>
    <td>Application <br />
      Complete</td>
    <td>Action</td>
  </tr>
  <?php
  
	$page=1;//Default page
	$limit=20;//Records per page
	$start=0;//starts displaying records from 0
	if(isset($_GET['page']) && $_GET['page']!=''){
	$page=$_GET['page'];
	}
	$start=($page-1)*$limit;
   
	 $sql="SELECT * FROM iijs_car_hire order by Car_Hire_ID desc";
	
 	$result=mysql_query($sql);
	$rCount=mysql_num_rows($result);	

	$sql1=$sql." limit $start, $limit"; 
	$result1=mysql_query($sql1);
		
  if($rCount>0)
  {	
  while($rows=mysql_fetch_array($result1))
  {
  ?>
  <tr>
    <td><?php echo getExhibitorName($rows['Exhibitor_Code']); ?></td>
    <td><?php echo getCountryName(getExhibitorCountryID($rows['Exhibitor_Code']));?></td>
    <td><?php echo date("d-m-Y",strtotime($rows['Create_Date']));?></td>
    <td>
	<?php  
			if($rows['Info_Approved']=='Y')
			echo "<img src='images/notification-tick.gif'  alt='' />";
			else if($rows['Info_Approved']=='N')
			echo "<img src='images/no.gif'  alt='' />";
			else
			echo "<img src='images/notification-exclamation.gif'  alt='' />";		
	?>
	</td>
    <td>
	<?php  
			if($rows['Payment_Master_Approved']=='Y')
			echo "<img src='images/notification-tick.gif'  alt='' />";
			else if($rows['Payment_Master_Approved']=='N')
			echo "<img src='images/no.gif'  alt='' />";
			else
			echo "<img src='images/notification-exclamation.gif'  alt='' />";		
	?>
	</td>
	
    <td>
	<?php  
			if($rows['PickUp_Info_Approved']=='Y')
			echo "<img src='images/notification-tick.gif'  alt='' />";
			else if($rows['PickUp_Info_Approved']=='N')
			echo "<img src='images/no.gif'  alt='' />";
			else
			echo "<img src='images/notification-exclamation.gif'  alt='' />";		
	?>
	</td>
	<td>
	<?php  
			if($rows['Application_Complete']=='Y')
			echo "<img src='images/notification-tick.gif'  alt='' />";
			else if($rows['Application_Complete']=='N')
			echo "<img src='images/no.gif'  alt='' />";
			else
			echo "<img src='images/notification-exclamation.gif'  alt='' />";		
	?>
	</td>
   	<td><a href="Form10.php?Exhibitor_Code=<?php echo $rows['Exhibitor_Code'];?>&Floral_ID=<?php echo $rows['Floral_ID'];?>" class="edit">Edit</a></td>
  </tr>
  
  <?php
   $i++;
   }
}
   else
   {
   ?>
   <tr>
     <td colspan="8">Records Not Found</td>
   </tr>
   <tr>
     <td colspan="5">&nbsp;</td>
     <td colspan="3"></td>
   </tr>
   <?php  }  	?>  
</table>

</form>
</div>  
<?php
function pagination($per_page = 10, $page = 1, $url = '', $total){ 

$adjacents = "2";

$page = ($page == 0 ? 1 : $page); 
$start = ($page - 1) * $per_page; 

$prev = $page - 1; 
$next = $page + 1;
$lastpage = ceil($total/$per_page);
$lpm1 = $lastpage - 1;

$pagination = "";
if($lastpage > 1)
{ 
$pagination .= "<ul class='pagination'>";
$pagination .= "<li class='details'>Page $page of $lastpage</li>";
if ($lastpage < 7 + ($adjacents * 2))
{ 
for ($counter = 1; $counter <= $lastpage; $counter++)
{
if ($counter == $page)
$pagination.= "<li><a class='current'>$counter</a></li>";
else
$pagination.= "<li><a href='{$url}$counter'>$counter</a></li>"; 
}
}
elseif($lastpage > 5 + ($adjacents * 2))
{
if($page < 1 + ($adjacents * 2)) 
{
for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
{
if ($counter == $page)
$pagination.= "<li><a class='current'>$counter</a></li>";
else
$pagination.= "<li><a href='{$url}$counter'>$counter</a></li>"; 
}
$pagination.= "<li class='dot'>...</li>";
$pagination.= "<li><a href='{$url}$lpm1'>$lpm1</a></li>";
$pagination.= "<li><a href='{$url}$lastpage'>$lastpage</a></li>"; 
}
elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
{
$pagination.= "<li><a href='{$url}1'>1</a></li>";
$pagination.= "<li><a href='{$url}2'>2</a></li>";
$pagination.= "<li class='dot'>...</li>";
for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
{
if ($counter == $page)
$pagination.= "<li><a class='current'>$counter</a></li>";
else
$pagination.= "<li><a href='{$url}$counter'>$counter</a></li>"; 
}
$pagination.= "<li class='dot'>..</li>";
$pagination.= "<li><a href='{$url}$lpm1'>$lpm1</a></li>";
$pagination.= "<li><a href='{$url}$lastpage'>$lastpage</a></li>"; 
}
else
{
$pagination.= "<li><a href='{$url}1'>1</a></li>";
$pagination.= "<li><a href='{$url}2'>2</a></li>";
$pagination.= "<li class='dot'>..</li>";
for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
{
if ($counter == $page)
$pagination.= "<li><a class='current'>$counter</a></li>";
else
$pagination.= "<li><a href='{$url}$counter'>$counter</a></li>"; 
}
}
}

if ($page < $counter - 1){
$pagination.= "<li><a href='{$url}$next'>Next</a></li>";
// $pagination.= "<li><a href='{$url}$lastpage'>Last</a></li>";
}else{
//$pagination.= "<li><a class='current'>Next</a></li>";
// $pagination.= "<li><a class='current'>Last</a></li>";
}
$pagination.= "</ul>\n"; 
} 
return $pagination;
} 

?>	
<div class="pages_1">Total number of order: <?php echo $rCount;?><?php echo pagination($limit,$page,'manage_car_hire.php?action=view&page=',$rCount); //call function to show pagination?></div>        
     
	</div>
</div>

<div id="footer_wrap"><?php include("include/footer.php");?></div>


</body>
</html>

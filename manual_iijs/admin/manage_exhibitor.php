<?php session_start(); ?>
<?php include('../db.inc.php');?>
<?php include('../functions.php');?>
<?php
if($_REQUEST['Reset']=="Reset")
{
  	$action="";
	$_SESSION['Exhibitor_Name']="";
	$_SESSION['Exhibitor_Section']="";
	  
	header("Location: manage_exhibitor.php?action=view");
  
}else if($_REQUEST['action']=="search")
{ 
  	$_SESSION['Exhibitor_Name']=$_REQUEST['Exhibitor_Name'];
 	$_SESSION['Exhibitor_Section']=$_REQUEST['Exhibitor_Section'];
 
 
	$_SESSION['Stall_P']=$_REQUEST['Stall_P'];
	$_SESSION['Stall_Y']=$_REQUEST['Stall_Y'];
	$_SESSION['Stall_N']=$_REQUEST['Stall_N'];
	
	$_SESSION['Application_P']=$_REQUEST['Application_P'];
	$_SESSION['Application_Y']=$_REQUEST['Application_Y'];
	$_SESSION['Application_N']=$_REQUEST['Application_N'];
}

?>  
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Exhibitor's Management</title>

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
	<div class="breadcome"><a href="manage_exhibitor.php">Home</a> > Exhibitor's Management</div>
</div>

<div id="main">
	<div class="content">
    	<div class="content_head"><div class="content_head_button">Exhibitor's Management</div><div class="content_head_button"><a href="export_exhibitor_manual.php">Export Exhibitor to Excel</a></div></div>
		     
<div class="content_details1">
<form name="search" action="" method="post" > 
<input type="hidden" name="action" value="search" />        	

<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt" >
<tr class="orange1">
    <td colspan="11" >Search Options</td>
</tr>
      
<tr >
    <td width="19%" ><strong>Search</strong></td>
    <td width="81%"><label>
      <input type="text" name="Exhibitor_Name" id="Exhibitor_Name" value="<?php echo $_SESSION['Exhibitor_Name']; ?>" />
    </label></td>
</tr>	
    
    

<tr >
  <td><strong>Section</strong></td>
  <td>
  	<select name="Exhibitor_Section" id="Exhibitor_Section">
	<option selected="selected" value="">-- Select --</option>
	<option  value="Studded Jewellery" <?php if($_SESSION['Exhibitor_Section']=='Studded Jewellery'){echo "selected='selected'";}?>>Studded Jewellery</option>
	<option value="Gold Jewellery" <?php if($_SESSION['Exhibitor_Section']=='Gold Jewellery'){echo "selected='selected'";}?>>Gold Jewellery</option>
	<option value="Loose Diamond" <?php if($_SESSION['Exhibitor_Section']=='Loose Stones'){echo "selected='selected'";}?>>Loose Stones</option>
	<option value="Signature Club" <?php if($_SESSION['Exhibitor_Section']=='Signature Club'){echo "selected='selected'";}?>>Signature Club</option>
	<option value="International" <?php if($_SESSION['Exhibitor_Section']=='International'){echo "selected='selected'";}?>>International</option>
</select>
  </td>
</tr>
<tr >
  <td>&nbsp;</td>
  <td><input type="submit" name="Search" value="Search"  class="input_submit" />  <input type="submit" name="Reset" value="Reset"  class="input_submit" /></td>
</tr>	
</table>
</form>      
</div>

<div class="content_details1">
<form name="form1" action="" method="post" > 

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  <tr class="orange1">
    <td>Exhibitor Name</td>
    <td>Contact Person</td>
    <td>BP</td>
    <td>Exhibitor Code</td>
    <td>Billing BP</td>
    <td>Exhibitor Password</td>
    <td>Exhibitor Section</td>
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
  
  
  	
	if($_SESSION['admin_role']=='Super Admin')
	{
		$sql="SELECT * from iijs_exhibitor WHERE 1 ";		
	}else if($_SESSION['admin_role']=='Admin')
	{
		if($_SESSION['admin_admin_access']=='Region Wise')
		{
		$sql="SELECT * from iijs_exhibitor WHERE 1 and Exhibitor_Region='".$_SESSION['admin_region_name']."'";
		}else
		{
		$sql="SELECT * from iijs_exhibitor WHERE 1 and Exhibitor_DivisionNo='".$_SESSION['admin_division_name']."'";
		}
	}
	
	if($_SESSION['Exhibitor_Name']!="")
	{
	$sql.=" and Exhibitor_Name like '%".$_SESSION['Exhibitor_Name']."%'";
	}
	
	if($_SESSION['Exhibitor_Section']!="")
	{
	$sql.=" and Exhibitor_Section = '".$_SESSION['Exhibitor_Section']."'";
	}
	//echo $sql;
	$result=$conn ->query($sql);
	$rCount=$result->num_rows;	

	$sql1=$sql." order by Exhibitor_ID desc limit $start, $limit"; 
	$result1=$conn ->query($sql1);
		
  if($rCount>0)
  {	
  while($rows=$result->fetch_assoc())
  {
  ?>
  <tr>
    <td><a href="exhibitor_summary_report.php?Exhibitor_Code=<?php echo $rows['Exhibitor_Code']; ?>"><?php echo $rows['Exhibitor_Name']; ?></a></td>
    <td><?php echo $rows['Exhibitor_Contact_Person'];?></td>
    <td><a href="https://registration.gjepc.org/manual_iijs/admin_login.php?action=admin_login&Exhibitor_Code=<?php echo $rows['Exhibitor_Code'];?>&auth=admin" target="_blank"><?php echo $rows['Customer_No'];?></td>
    <td><?php echo $rows['Exhibitor_Code'];?></td>
	<td><?php echo $rows['billing_bp_no'];?></td>
    <td><?php echo $rows['Exhibitor_Password'];?></td>
    <td><?php echo $rows['Exhibitor_Section'];?></td>
<?php if($_SESSION['admin_role']=="Super Admin") {?>
   	<td><a href="exhibitor_details.php?Exhibitor_ID=<?php echo $rows['Exhibitor_ID'];?>&Exhibitor_Code=<?php echo $rows['Exhibitor_Code'];?>" class="edit">Edit</a></td>
<?php } ?>
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
<div class="pages_1">Total number of Members: <?php echo $rCount;?><?php echo pagination($limit,$page,'manage_exhibitor.php?action=view&page=',$rCount); //call function to show pagination?></div>        
     
	</div>
</div>

<div id="footer_wrap"><?php include("include/footer.php");?></div>


</body>
</html>

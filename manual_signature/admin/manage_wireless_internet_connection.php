<?php session_start(); ?>
<?php include('../db.inc.php');?>
<?php include('../functions.php');?>
<?php
if($_REQUEST['Reset']=="Reset")
{
  	$action="";
	$_SESSION['Exhibitor_Name']="";
	$_SESSION['Exhibitor_Section']="";
	  
	$_SESSION['Items_P']="";
	$_SESSION['Items_Y']="";
	$_SESSION['Items_N']="";
	
	$_SESSION['Application_P']="";
	$_SESSION['Application_Y']="";
	$_SESSION['Application_N']="";
 
  header("Location: manage_wireless_internet_connection.php?action=view");
  
}else if($_REQUEST['action']=="search")
{ 
  	$_SESSION['Exhibitor_Name']=$_REQUEST['Exhibitor_Name'];
 	$_SESSION['Exhibitor_Section']=$_REQUEST['Exhibitor_Section'];
 
 
	$_SESSION['Items_P']=$_REQUEST['Items_P'];
	$_SESSION['Items_Y']=$_REQUEST['Items_Y'];
	$_SESSION['Items_N']=$_REQUEST['Items_N'];
	
	$_SESSION['Application_P']=$_REQUEST['Application_P'];
	$_SESSION['Application_Y']=$_REQUEST['Application_Y'];
	$_SESSION['Application_N']=$_REQUEST['Application_N'];
}
?>  


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Wireless Internet Connection</title>

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
	<div class="breadcome"><a href="manage_wireless_internet_connection.php">Home</a> > Wired Internet Connection</div>
</div>

<div id="main">
	<div class="content">
    	<div class="content_head"><div class="content_head_button">Wired Internet Connection</div></div>
<div class="content_details1">
<?php 
	/*
	if($_SESSION['admin_role']=='Super Admin')
	{
		$sql5="SELECT a.*,b.* FROM `iijs_wirelessinternet` a,iijs_exhibitor b WHERE 1 and a.`Exhibitor_Code`=b.Exhibitor_Code";		
	}else if($_SESSION['admin_role']=='Admin')
	{
		if($_SESSION['admin_admin_access']=='Region Wise')
		{
		$sql5="SELECT a.*,b.* FROM `iijs_wirelessinternet` a,iijs_exhibitor b WHERE 1 and a.`Exhibitor_Code`=b.Exhibitor_Code and b.Exhibitor_Region='".$_SESSION['admin_region_name']."'";
		}else
		{
		$sql5="SELECT a.*,b.* FROM `iijs_wirelessinternet` a,iijs_exhibitor b WHERE 1 and a.`Exhibitor_Code`=b.Exhibitor_Code and b.Exhibitor_DivisionNo='".$_SESSION['admin_division_name']."'";
		}
	} */
	
	if($_SESSION['admin_role']=='Super Admin')
	{
	$sql5="SELECT a.*,b.*,c.* FROM `iijs_wirelessinternet` a,iijs_payment_master b,iijs_exhibitor c WHERE b.Form_ID='7' and  a.`Exhibitor_Code`=c.Exhibitor_Code and  b.`Exhibitor_Code`=c.`Exhibitor_Code` and a.Payment_Master_ID=b.Payment_Master_ID group by a.`Exhibitor_Code`";		
	}
	else if($_SESSION['admin_role']=='Admin')
	{
		if($_SESSION['admin_admin_access']=='Region Wise')
		{
		$sql5="SELECT a.*,b.*,c.* FROM `iijs_wirelessinternet` a,iijs_payment_master b,iijs_exhibitor c WHERE 1 and a.`Payment_Master_ID`=b.`Payment_Master_ID` and b.Form_ID='7' and a.`Exhibitor_Code`=c.Exhibitor_Code and b.`Exhibitor_Code`=c.`Exhibitor_Code` and c.Exhibitor_Region='".$_SESSION['admin_region_name']."' group by a.`Exhibitor_Code`";
		}
		else
		{
		$sql5="SELECT a.*,b.*,c.* FROM `iijs_wirelessinternet` a,iijs_payment_master b,iijs_exhibitor c WHERE 1 and a.`Payment_Master_ID`=b.`Payment_Master_ID` and b.Form_ID='7' and a.`Exhibitor_Code`=c.Exhibitor_Code and b.`Exhibitor_Code`=c.`Exhibitor_Code` and c.Exhibitor_DivisionNo='".$_SESSION['admin_division_name']."' group by a.`Exhibitor_Code`";
		}
	}
	
	$result5=$conn ->query($sql5);
	$total_application=$result5->num_rows;
	
	$total_approve=0;
	$total_pending=0;
	$total_disapprove=0;
	while($rows5 = $result5->fetch_assoc())
	{
		if($rows5['Info_Approved']=='Y' && $rows5['Payment_Master_Approved']=='Y')
		{
			$total_approve=$total_approve+1;
		}else if($rows5['Info_Approved']=='P' && $rows5['Payment_Master_Approved']=='P')
		{
			$total_pending=$total_pending+1;
		}else
		{
			$total_disapprove=$total_disapprove+1;
		}
	}
	
?>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt" >
  <tr class="orange1">
    <td colspan="11" >Report Summary</td>
  </tr>
  <tr>
    <td><strong>Total Application</strong></td>
    <td><strong>Approve Application</strong></td>
    <td><strong>Disapprove Application</strong></td>
    <td><strong>Pending Application</strong></td>
  </tr>
   <tr>
    <td><?php echo $total_application;?></td>
    <td><?php echo $total_approve;?></td>
    <td><?php echo $total_disapprove;?></td>
    <td><?php echo $total_pending;?></td>
  </tr>
</table>
</div>    	
      
<div class="content_details1">

<form name="search" action="" method="POST"> 
<input type="hidden" name="action" value="search" />        	

<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt" >
<tr class="orange1">
    <td colspan="11" >Search Options</td>
</tr>
      
<tr>
    <td width="19%" ><strong>Search</strong></td>
    <td width="81%"><label>
      <input type="text" name="Exhibitor_Name" id="Exhibitor_Name" value="<?php echo $_SESSION['Exhibitor_Name']; ?>" />
    </label></td>
</tr>	
    
<tr >
  <td><strong>Status</strong></td>
  <td>
    <div class="leftAlignment">
        <div><input name="Items_P" type="checkbox" value="P" <?php if($_SESSION['Items_P']=='P'){echo "checked='checked'";}?>/>Items Pending</div>
        <div><input name="Application_P" type="checkbox" value="P" <?php if($_SESSION['Application_P']=='P'){echo "checked='checked'";}?>/>Application Pending</div>
    </div>
      
    <div class="leftAlignment">
        <div> <input name="Items_Y" type="checkbox" value="Y" <?php if($_SESSION['Items_Y']=='Y'){echo "checked='checked'";}?>/>Items Approved</div>
        <div> <input name="Application_Y" type="checkbox" value="Y" <?php if($_SESSION['Application_Y']=='Y'){echo "checked='checked'";}?>/>Application Approved</div>
    </div>
      
    <div class="leftAlignment">
        <div> <input name="Items_N" type="checkbox" value="N" <?php if($_SESSION['Items_N']=='N'){echo "checked='checked'";}?> />Items Disapproved</div>
        <div> <input name="Application_N" type="checkbox" value="N" <?php if($_SESSION['Application_N']=='N'){echo "checked='checked'";}?> />Application Disapproved</div>
    </div>
    <div class="clear"></div>
  
</td>
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
    <td>Country</td>
    <td>Date</td>
    <td>Item Approved</td>
    <td>Application Complete</td>
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
  
   /*
  	if($_SESSION['admin_role']=='Super Admin')
	{
		$sql="SELECT a.*,b.* FROM `iijs_wirelessinternet` a,iijs_exhibitor b WHERE 1 and a.`Exhibitor_Code`=b.Exhibitor_Code";		
	}else if($_SESSION['admin_role']=='Admin')
	{
		if($_SESSION['admin_admin_access']=='Region Wise')
		{
		$sql="SELECT a.*,b.* FROM `iijs_wirelessinternet` a,iijs_exhibitor b WHERE 1 and a.`Exhibitor_Code`=b.Exhibitor_Code and b.Exhibitor_Region='".$_SESSION['admin_region_name']."'";
		}else
		{
		$sql="SELECT a.*,b.* FROM `iijs_wirelessinternet` a,iijs_exhibitor b WHERE 1 and a.`Exhibitor_Code`=b.Exhibitor_Code and b.Exhibitor_DivisionNo='".$_SESSION['admin_division_name']."'";
		}
	} */
	
	if($_SESSION['admin_role']=='Super Admin')
	{
		$sql="SELECT a.*,b.*,c.* FROM `iijs_wirelessinternet` a,iijs_payment_master b,iijs_exhibitor c WHERE b.Form_ID='7' and  a.`Exhibitor_Code`=c.Exhibitor_Code and  b.`Exhibitor_Code`=c.`Exhibitor_Code` and a.Payment_Master_ID=b.Payment_Master_ID";		
	}
	else if($_SESSION['admin_role']=='Admin')
	{
		if($_SESSION['admin_admin_access']=='Region Wise')
		{
		$sql="SELECT a.*,b.*,c.* FROM `iijs_wirelessinternet` a,iijs_payment_master b,iijs_exhibitor c WHERE b.Form_ID='7' and a.`Exhibitor_Code`=c.Exhibitor_Code and  b.`Exhibitor_Code`=c.`Exhibitor_Code` and c.Exhibitor_Region='".$_SESSION['admin_region_name']."'";
		}
		else
		{
		$sql="SELECT a.*,b.*,c.* FROM `iijs_wirelessinternet` a,iijs_payment_master b,iijs_exhibitor c WHERE b.Form_ID='7' and a.`Exhibitor_Code`=c.Exhibitor_Code and  b.`Exhibitor_Code`=c.`Exhibitor_Code` and c.Exhibitor_DivisionNo='".$_SESSION['admin_division_name']."'";
		}
	}
	
	if($_SESSION['Items_P']!="" || $_SESSION['Items_Y']!="" || $_SESSION['Items_N']!="" || $_SESSION['Application_P']!="" || $_SESSION['Application_Y']!="" || $_SESSION['Application_N']!="" )
		
	
		$flag=1;
	else
		$flag=0;
		
	if($flag)
		$sql.=" and (";

	if($_SESSION['Items_P']=="P")
	{
	$sql.="a.Items_Approved='P' or ";
	}
	if($_SESSION['Items_Y']=="Y")
	{
	$sql.="a.Items_Approved='Y' or ";
	}
	if($_SESSION['Items_N']=="N")
	{
	$sql.="a.Items_Approved='N' or ";
	}
	
	
	if($_SESSION['Application_P']=="P")
	{
	$sql.="a.Application_Complete='P' or ";
	}
	if($_SESSION['Application_Y']=="Y")
	{
	$sql.="a.Application_Complete='Y' or ";
	}
	if($_SESSION['Application_N']=="N")
	{
	$sql.="a.Application_Complete='N' or ";
	}
	
	if($flag)
	{
		$sql=rtrim($sql,"or ");
		$sql.=")";
	}
	
	
	if($_SESSION['Exhibitor_Name']!="")
	{
	$sql.=" and c.Exhibitor_Name like '%".$_SESSION['Exhibitor_Name']."%'";
	}
	
	if($_SESSION['Exhibitor_Section']!="")
	{
	$sql.=" and c.Exhibitor_Section = '".$_SESSION['Exhibitor_Section']."'";
	}
	
	$sql.=" group by a.`Exhibitor_Code`";

 	$result=$conn ->query($sql);
	$rCount=$result->num_rows;	

	$sql1=$sql." limit $start, $limit"; 
	$result1=$conn ->query($sql1);
		
  if($rCount>0)
  {	
  while($rows=$result1->fetch_assoc())
  {
  ?>
  <tr>
 	<td><?php echo $rows['Exhibitor_Name']; ?></td>
    <td><?php echo getCountryName($rows['Exhibitor_Country_ID'],$conn);?></td>
    <td><?php echo date("d-m-Y",strtotime($rows['Create_Date']));?></td>
    <td align="center">
	<?php 
	if($rows['Items_Approved']=='Y')
	{
		echo "<img src='images/notification-tick.gif' alt='' />";
	}else if($rows['Items_Approved']=='N')
	{
		echo "<img src='images/no.gif' alt='' />";
	}else 
	{
		echo "<img src='images/notification-exclamation.gif' alt='' />";
	}
	?>
    </td>
   <td align="center">
	<?php 
	if($rows['Application_Complete']=='Y')
	{
		echo "<img src='images/notification-tick.gif' alt='' />";
	}else if($rows['Application_Complete']=='N')
	{
		echo "<img src='images/no.gif' alt='' />";
	}else 
	{
		echo "<img src='images/notification-exclamation.gif' alt='' />";
	}
	?>
	</td>
   	<td><a href="Form7.php?WireLessInternet_ID=<?php echo $rows['WireLessInternet_ID'];?>&Exhibitor_Code=<?php echo $rows['Exhibitor_Code'];?>" class="edit">Edit</a></td>
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
<div class="pages_1">Total number of Memberships: <?php echo $rCount;?><?php echo pagination($limit,$page,'manage_wireless_internet_connection.php?action=view&page=',$rCount); //call function to show pagination?></div>        
     
	</div>
</div>

<div id="footer_wrap"><?php include("include/footer.php");?></div>


</body>
</html>

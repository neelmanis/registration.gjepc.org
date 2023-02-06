<?php session_start(); ?>
<?php include('../db.inc.php');?>
<?php include('../functions.php');?>
<?php
 
if($_REQUEST['Reset']=="Reset")
{
  	$action="";
	$_SESSION['Exhibitor_Name']="";
	$_SESSION['Exhibitor_Section']="";
	$_SESSION['Exhibitor_HallNo']="";
	  
	$_SESSION['Stall_P']="";
	$_SESSION['Stall_Y']="";
	$_SESSION['Stall_N']="";
	
	$_SESSION['Application_P']="";
	$_SESSION['Application_Y']="";
	$_SESSION['Application_N']="";
	$_SESSION['Exhibitor_Division'] = '';
  header("Location: manage_stall_layout.php?action=view");
  
}else if($_REQUEST['action']=="search")
{ 
  	$_SESSION['Exhibitor_Name']=$_REQUEST['Exhibitor_Name'];
 	$_SESSION['Exhibitor_Section']=$_REQUEST['Exhibitor_Section'];
 	$_SESSION['Exhibitor_HallNo']=$_REQUEST['Exhibitor_HallNo'];

	$_SESSION['Stall_P']=$_REQUEST['Stall_P'];
	$_SESSION['Stall_Y']=$_REQUEST['Stall_Y'];
	$_SESSION['Stall_N']=$_REQUEST['Stall_N'];
	
	$_SESSION['Application_P']=$_REQUEST['Application_P'];
	$_SESSION['Application_Y']=$_REQUEST['Application_Y'];
	$_SESSION['Application_N']=$_REQUEST['Application_N'];
	$_SESSION['Exhibitor_Division']=$_REQUEST['Exhibitor_Division'];
}

?>  
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Stall Layout</title>

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
	<div class="breadcome"><a href="manage_stall_layout.php">Home</a> > Stall Layout</div>
</div>

<div id="main">
	<div class="content">
    	<div class="content_head"><div class="content_head_button">Stall Layout</div></div>
<div class="content_details1">
<?php 

	if($_SESSION['admin_role']=='Super Admin')
	{
		$exhibitorSection = $_SESSION['admin_section'];
		if($_SESSION['admin_section']==""){
			$sql5="SELECT a.*,b.* FROM `iijs_stall_master` a,iijs_exhibitor b WHERE 1 and a.`Exhibitor_Code`=b.Exhibitor_Code";		
		} else {
			$sql5="SELECT a.*,b.* FROM `iijs_stall_master` a,iijs_exhibitor b WHERE 1 and a.`Exhibitor_Code`=b.Exhibitor_Code and b.Exhibitor_Section='$exhibitorSection'";		
		}
		
	}else if($_SESSION['admin_role']=='Admin')
	{
		if($_SESSION['admin_admin_access']=='Region Wise')
		{
		$sql5="SELECT a.*,b.* FROM `iijs_stall_master` a,iijs_exhibitor b WHERE 1 and a.`Exhibitor_Code`=b.Exhibitor_Code and b.Exhibitor_Region='".$_SESSION['admin_region_name']."'";
		}else
		{
		$sql5="SELECT a.*,b.* FROM `iijs_stall_master` a,iijs_exhibitor b WHERE 1 and a.`Exhibitor_Code`=b.Exhibitor_Code and b.Exhibitor_DivisionNo='".$_SESSION['admin_division_name']."'";
		}
	}
	else if($_SESSION['admin_role']=='Vendor')
	{
		if($_SESSION['admin_vendor_access']=="All"){
			$sql5="SELECT a.*,b.* FROM `iijs_stall_master` a,iijs_exhibitor b WHERE 1 and a.`Exhibitor_Code`=b.Exhibitor_Code";	
		}else{
			$admin_vendor_access=explode(',',$_SESSION['admin_vendor_access']);
			$div1=$admin_vendor_access[0];
			$div2=$admin_vendor_access[1];
			$div3=$admin_vendor_access[2];

			$sql5="SELECT a.*,b.* FROM `iijs_stall_master` a,iijs_exhibitor b WHERE 1 and a.`Exhibitor_Code`=b.Exhibitor_Code and (";
			if($div1!="")
			$sql5.="b.vendor='$div1'";
			if($div2!="")
			$sql5.=" || b.vendor='$div2'";
			if($div3!="")
			$sql5.=" || b.vendor='$div3'";
			$sql5.=" ) ";
		}
	}

	$result5=$conn ->query($sql5);
	$total_application=$result5->num_rows;
	
	$total_approve=0;
	$total_pending=0;
	$total_disapprove=0;
	while($rows5=$result5->fetch_assoc())
	{
		if($rows5['Stall_Basic_Layout_Approved']=='Y')
		{
			$total_approve=$total_approve+1;
		}else if($rows5['Stall_Basic_Layout_Approved']=='P')
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
  <td><strong>Status</strong></td>
  <td>
    <div class="leftAlignment">
        <div><input name="Stall_P" type="checkbox" value="P" <?php if($_SESSION['Stall_P']=='P'){echo "checked='checked'";}?>/>Stall Layout Pending</div>
        <div><input name="Application_P" type="checkbox" value="P" <?php if($_SESSION['Application_P']=='P'){echo "checked='checked'";}?>/>Application Pending</div>
    </div>
      
    <div class="leftAlignment">
        <div> <input name="Stall_Y" type="checkbox" value="Y" <?php if($_SESSION['Stall_Y']=='Y'){echo "checked='checked'";}?>/>Stall Layout Approved</div>
        <div> <input name="Application_Y" type="checkbox" value="Y" <?php if($_SESSION['Application_Y']=='Y'){echo "checked='checked'";}?>/>Application Approved</div>
    </div>
      
    <div class="leftAlignment">
        <div> <input name="Stall_N" type="checkbox" value="N" <?php if($_SESSION['Stall_N']=='N'){echo "checked='checked'";}?> />Stall Layout Disapproved</div>
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
		<option  value="studded_jewellery" <?php if($_SESSION['Exhibitor_Section']=='studded_jewellery'){echo "selected='selected'";}?>>Studded Jewellery</option>
		<option value="plain_gold" <?php if($_SESSION['Exhibitor_Section']=='plain_gold'){echo "selected='selected'";}?>>Gold Jewellery</option>
		<option value="loose_stones" <?php if($_SESSION['Exhibitor_Section']=='loose_stones'){echo "selected='selected'";}?>>Loose Stones</option>
		<option value="signature_club" <?php if($_SESSION['Exhibitor_Section']=='signature_club'){echo "selected='selected'";}?>>Signature Club</option>
		<option value="International" <?php if($_SESSION['Exhibitor_Section']=='International'){echo "selected='selected'";}?>>International</option>
	</select>
  </td>
</tr>
<tr >
  <td><strong>Hall</strong></td>
  <td>
	<select name="Exhibitor_HallNo" id="Exhibitor_HallNo">
		<option selected="selected" value="">-- Select --</option>
		<option  value="1" <?php if($_SESSION['Exhibitor_HallNo']=='1'){echo "selected='selected'";}?>>1</option>
		<option  value="2" <?php if($_SESSION['Exhibitor_HallNo']=='2'){echo "selected='selected'";}?>>2</option>
		<option value="3" <?php if($_SESSION['Exhibitor_HallNo']=='3'){echo "selected='selected'";}?>>3</option>
		<option value="4" <?php if($_SESSION['Exhibitor_HallNo']=='4'){echo "selected='selected'";}?>>4</option>
		<option value="6" <?php if($_SESSION['Exhibitor_HallNo']=='6'){echo "selected='selected'";}?>>6</option>
		<option value="7" <?php if($_SESSION['Exhibitor_HallNo']=='7'){echo "selected='selected'";}?>>7</option>
	</select>
  </td>
</tr>

<tr >
  <td><strong>Division No</strong></td>
  <td>
	<select name="Exhibitor_Division" id="Exhibitor_Division">
		<option selected="selected" value="">-- Select --</option>
		<option  value="1A" <?php if($_SESSION['Exhibitor_Division']=='1A'){echo "selected='selected'";}?>>1A</option>
		<option value="1B" <?php if($_SESSION['Exhibitor_Division']=='1B'){echo "selected='selected'";}?>>1B</option>
		<option value="1C" <?php if($_SESSION['Exhibitor_Division']=='1C'){echo "selected='selected'";}?>>1C</option>
		<option value="1D" <?php if($_SESSION['Exhibitor_Division']=='1D'){echo "selected='selected'";}?>>1D</option>
		<option  value="2A" <?php if($_SESSION['Exhibitor_Division']=='2A'){echo "selected='selected'";}?>>2A</option>
		<option value="2B" <?php if($_SESSION['Exhibitor_Division']=='2B'){echo "selected='selected'";}?>>2B</option>
		<option value="3A" <?php if($_SESSION['Exhibitor_Division']=='3A'){echo "selected='selected'";}?>>3A</option>
		<option value="3B" <?php if($_SESSION['Exhibitor_Division']=='3B'){echo "selected='selected'";}?>>3B</option>
		<option  value="4A" <?php if($_SESSION['Exhibitor_Division']=='4A'){echo "selected='selected'";}?>>4A</option>
		<option value="4B" <?php if($_SESSION['Exhibitor_Division']=='4B'){echo "selected='selected'";}?>>4B</option>
		<option value="5A" <?php if($_SESSION['Exhibitor_Division']=='5A'){echo "selected='selected'";}?>>5A</option>
		<option value="5B" <?php if($_SESSION['Exhibitor_Division']=='5B'){echo "selected='selected'";}?>>5B</option>
		<option value="7A" <?php if($_SESSION['Exhibitor_Division']=='7A'){echo "selected='selected'";}?>>7A</option>
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

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt">
  <tr class="orange1">
    <td>Exhibitor Name</td>
    <td>Hall</td>
    <td>Country</td>
    <td>Stall Type</td>
    <td>Stall Display Light</td>
    <td>Option</td>
    <td>Date</td>
    <td>Info Approved</td>
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
  	
	$getSection = $_SESSION['admin_section'];
	$getScheme = $_SESSION['admin_scheme'];
	$getHall = $_SESSION['admin_hall'];
	
	if($_SESSION['admin_role']=='Super Admin')
	{ //echo '<pre>'; print_r($_SESSION);

		if($_SESSION['admin_admin_access']=='Stall Layout')
		{
			if($getSection == "studded_jewellery" && $getScheme=="BI2" && $getHall=="1")
			{
				$sql="SELECT a.*,b.* FROM `iijs_stall_master` a,iijs_exhibitor b WHERE 1 and a.`Exhibitor_Code`=b.Exhibitor_Code and b.Exhibitor_Section='$getSection' AND b.Exhibitor_Scheme='$getScheme' AND b.Exhibitor_HallNo='$getHall'";
			} else if($getSection == "plain_gold" && $getScheme=="BI2")
			{
				$sql="SELECT a.*,b.* FROM `iijs_stall_master` a,iijs_exhibitor b WHERE 1 and a.`Exhibitor_Code`=b.Exhibitor_Code and b.Exhibitor_Section='$getSection' AND b.Exhibitor_Scheme='$getScheme' AND b.Exhibitor_HallNo IN ('5','6')";
			} else if($getSection == "signature_club" && $getScheme=="BI2")
			{
				$sql="SELECT a.*,b.* FROM `iijs_stall_master` a,iijs_exhibitor b WHERE 1 and a.`Exhibitor_Code`=b.Exhibitor_Code and b.Exhibitor_Section='$getSection' AND b.Exhibitor_Scheme='$getScheme' AND b.Exhibitor_HallNo IN ('1','5','6')";
			} else if($getScheme=="BI1")
			{
				$sql="SELECT a.*,b.* FROM `iijs_stall_master` a,iijs_exhibitor b WHERE 1 and a.`Exhibitor_Code`=b.Exhibitor_Code AND b.Exhibitor_Scheme='$getScheme' AND b.Exhibitor_HallNo IN ('1','5','6')";
			}
		} /*else {
		echo '=='.$sql="SELECT a.*,b.* FROM `iijs_stall_master` a,iijs_exhibitor b WHERE 1 and a.`Exhibitor_Code`=b.Exhibitor_Code and b.Exhibitor_Section='".$_SESSION['admin_section']."'";
		}*/ else {
		$sql="SELECT a.*,b.* FROM `iijs_stall_master` a,iijs_exhibitor b WHERE 1 and a.`Exhibitor_Code`=b.Exhibitor_Code";	
		}
	}else if($_SESSION['admin_role']=='Admin')
	{ 
		if($_SESSION['admin_admin_access']=='Region Wise')
		{
		$sql="SELECT a.*,b.* FROM `iijs_stall_master` a,iijs_exhibitor b WHERE 1 and a.`Exhibitor_Code`=b.Exhibitor_Code and b.Exhibitor_Region='".$_SESSION['admin_region_name']."'";
		}else
		{
		$sql="SELECT a.*,b.* FROM `iijs_stall_master` a,iijs_exhibitor b WHERE 1 and a.`Exhibitor_Code`=b.Exhibitor_Code and b.Exhibitor_DivisionNo='".$_SESSION['admin_division_name']."'";
		}
	}
	else if($_SESSION['admin_role']=='Vendor')
	{ 
		if($_SESSION['admin_vendor_access']=="All"){
			
			$sql="SELECT a.*,b.* FROM `iijs_stall_master` a,iijs_exhibitor b WHERE 1 and a.`Exhibitor_Code`=b.Exhibitor_Code";	
		}else{
			
			$admin_vendor_access=explode(',',$_SESSION['admin_vendor_access']);
			$div1=$admin_vendor_access[0];
			$div2=$admin_vendor_access[1];
			$div3=$admin_vendor_access[2];

			$sql="SELECT a.*,b.* FROM `iijs_stall_master` a,iijs_exhibitor b WHERE 1 and a.`Exhibitor_Code`=b.Exhibitor_Code and (";
			if($div1!="")
			$sql.="b.vendor='$div1'";
			if($div2!="")
			$sql.=" || b.vendor='$div2'";
			if($div3!="")
			$sql.=" || b.vendor='$div3'";
			$sql.=" ) ";
		}
	}
	
	if($_SESSION['Stall_P']!="" || $_SESSION['Stall_Y']!="" || $_SESSION['Stall_N']!="" || $_SESSION['Application_P']!="" || $_SESSION['Application_Y']!="" || $_SESSION['Application_N']!="" )
		$flag=1;
	else
		$flag=0;
		
	if($flag)
		$sql.=" and (";

	if($_SESSION['Stall_P']=="P")
	{
	$sql.="a.Stall_Basic_Layout_Approved='P' or ";
	}
	if($_SESSION['Stall_Y']=="Y")
	{
	$sql.="a.Stall_Basic_Layout_Approved='Y' or ";
	}
	if($_SESSION['Stall_N']=="N")
	{
	$sql.="a.Stall_Basic_Layout_Approved='N' or ";
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
	$sql.=" and b.Exhibitor_Name like '%".$_SESSION['Exhibitor_Name']."%'";
	}
	
	if($_SESSION['Exhibitor_Section']!="")
	{
	$sql.=" and b.Exhibitor_Section = '".$_SESSION['Exhibitor_Section']."'";
	}
	if($_SESSION['Exhibitor_HallNo']!="")
	{
	$sql.=" and b.Exhibitor_HallNo = '".$_SESSION['Exhibitor_HallNo']."'";
	}
	if($_SESSION['Exhibitor_Division']!="")
	{
		$sql.=" and b.Exhibitor_DivisionNo = '".$_SESSION['Exhibitor_Division']."'";
	}
	$result=$conn ->query($sql);
	$rCount=$result->num_rows;	

	 $sql1=$sql." order by a.Create_Date  asc limit $start, $limit"; 
	//echo $sql1;
	$result1=$conn ->query($sql1);
		
  if($rCount>0)
  {	
  while($rows=$result1->fetch_assoc())
  {
  ?>
  <tr>
    <td><?php echo $rows['Exhibitor_Name']; ?></td>
    <td><?php echo $rows['Exhibitor_HallNo']; ?></td>
    <td><?php echo getCountryName($rows['Exhibitor_Country_ID'],$conn);?></td>
    <td><?php echo $rows['Stall_Image_Layout_Type'];?></td>
    <td><?php if($rows['Stall_Display_Light']=='0'){echo "White";}else{echo "Yellow";}?></td>
    <td><?php echo $rows['option'];?></td>
    <td><?php echo date("d-m-Y",strtotime($rows['Create_Date']));?></td>
    <td align="center">
	<?php 
	if($rows['Stall_Basic_Layout_Approved']=='Y')
	{
		echo "<img src='images/notification-tick.gif' alt='' />";
	}else if($rows['Stall_Basic_Layout_Approved']=='N')
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
   	<td><a href="Form2.php?Stall_ID=<?php echo $rows['Stall_ID'];?>&Exhibitor_Code=<?php echo $rows['Exhibitor_Code'];?>" class="edit">Edit</a></td>
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
<div class="pages_1">Total number : <?php echo $rCount;?><?php echo pagination($limit,$page,'manage_stall_layout.php?action=view&page=',$rCount); //call function to show pagination?></div>        
     
	</div>
</div>

<div id="footer_wrap"><?php include("include/footer.php");?></div>


</body>
</html>

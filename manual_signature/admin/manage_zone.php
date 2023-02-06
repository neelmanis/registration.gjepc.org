<?php session_start(); ?>
<?php include('../db.inc.php');?>
<?php include('../functions.php');?>
<?php
if($_REQUEST['Reset']=="Reset")
{
  	$action="";
	$_SESSION['zone_manager']="";
	$_SESSION['section']="";
	  
	header("Location: manage_zone.php?action=view");
  
}else if($_REQUEST['action']=="search")
{ 
  	$_SESSION['zone_manager']=$_REQUEST['zone_manager'];
 	$_SESSION['section']=$_REQUEST['section'];
 
 
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
	<div class="breadcome"><a href="manage_zone.php">Home</a> > Zone's Management</div>
</div>

<div id="main">
	<div class="content">
    	<div class="content_head"><div class="content_head_button">Zone's Management</div><div class="content_head_button"></div></div>
		     
<div class="content_details1">
<form name="search" action="" method="post" > 
<input type="hidden" name="action" value="search" />        	

<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt" >
<tr class="orange1">
    <td colspan="11" >Search Options</td>
</tr>
      
<tr >
    <td width="19%" ><strong>Zone Manager</strong></td>
    <td width="81%"><label>
      <input type="text" name="zone_manager" id="zone_manager" value="<?php echo $_SESSION['zone_manager']; ?>" />
    </label></td>
</tr>	

<tr >
  <td><strong>Section</strong></td>
  <td>
  	<select name="section" id="section">
	<option selected="selected" value="">-- Select --</option>
	<option  value="Studded Jewellery" <?php if($_SESSION['section']=='Studded Jewellery'){echo "selected='selected'";}?>>Studded Jewellery</option>
	<option value="Gold Jewellery" <?php if($_SESSION['section']=='Gold Jewellery'){echo "selected='selected'";}?>>Gold Jewellery</option>
	<option value="Loose Diamond" <?php if($_SESSION['section']=='Loose Stones'){echo "selected='selected'";}?>>Loose Stones</option>
	<option value="Signature Club" <?php if($_SESSION['section']=='Signature Club'){echo "selected='selected'";}?>>Signature Club</option>
	<option value="International" <?php if($_SESSION['section']=='International'){echo "selected='selected'";}?>>International</option>
	</select>
  </td>
</tr>
<tr >
  <td>&nbsp;</td>
  <td><input type="submit" name="Search" value="Search"  class="input_submit" />
	  <input type="submit" name="Reset" value="Reset" class="input_submit" /></td>
</tr>	
</table>
</form>      
</div>

<div class="content_details1">
<form name="form1" action="" method="post" > 

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  <tr class="orange1">
    <td>Section</td>
    <td>Zone Manager</td>
    <td>Division</td>
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

	$sql="SELECT * from zone_manager WHERE 1 ";		
	
	if($_SESSION['zone_manager']!="")
	{
	$sql.=" and zone_manager like '%".$_SESSION['zone_manager']."%'";
	}
	
	if($_SESSION['section']!="")
	{
	$sql.=" and section = '".$_SESSION['section']."'";
	}
	//echo $sql;
	$result=$conn ->query($sql);
	$rCount=$result->num_rows;	

	$sql1 = $sql." order by id desc limit $start, $limit"; 
	$result1=$conn ->query($sql1);
		
  if($rCount>0)
  {
  while($rows=$result->fetch_assoc())
  {
  ?>
  <tr>
   <td><?php echo $rows['section'];?></td>
    <td><?php echo $rows['zone_manager'];?></td>
    <td><?php echo $rows['division'];?></td>
	<?php if($_SESSION['admin_role']=="Super Admin") { ?>
   	<td><a href="zone_details.php?id=<?php echo $rows['id'];?>" class="edit">Edit</a></td>
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
<div class="pages_1">Total number of Members: <?php echo $rCount;?><?php echo pagination($limit,$page,'manage_zone.php?action=view&page=',$rCount); //call function to show pagination?></div>        
     
	</div>
</div>

<div id="footer_wrap"><?php include("include/footer.php");?></div>


</body>
</html>

<?php session_start(); ?>
<?php include('../db.inc.php');?>
<?php include('../functions.php');?>
<?php 
if (($_REQUEST['action']=='del') && ($_REQUEST['id']!=''))
{
	$sql="delete from iijs_stall_basic_furniture where id='$_REQUEST[id]'";
	
	if (!$conn ->query($sql))
	{
		die('Error: ' . mysqli_error());
	}
	echo"<meta http-equiv=refresh content=\"0;url=stall_basic_furniture_master.php?action=view\">";
}

if (($_REQUEST['action']=='update')&&($_REQUEST['id']!=''))
{
	$ex_section=$_REQUEST['ex_section']; 
	$ex_area=$_REQUEST['ex_area']; 
	$ex_stall_type=$_REQUEST['ex_stall_type'];
	$no_of_table= $_REQUEST['no_of_table'];
	$chair=$_REQUEST['chair'];
	 $dustbin=$_REQUEST['dustbin'];
	 $plug_point=$_REQUEST['plug_point'];
	$cfl=$_REQUEST['cfl'];
	$tall_showcase=$_REQUEST['tall_showcase']; 
	 $top_glass_showcase=$_REQUEST['top_glass_showcase']; 
	$l_window=$_REQUEST['l_window']; 
	$open_tray= $_REQUEST['open_tray']; 
	 $display_unit=$_REQUEST['display_unit']; 
	 $fascia=$_REQUEST['fascia']; 
	
	$id=$_REQUEST['id'];	
	$sql="update iijs_stall_basic_furniture set ex_section='$ex_section',ex_area='$ex_area',ex_stall_type='$ex_stall_type',no_of_table='$no_of_table',chair='$chair',dustbin='$dustbin',plug_point='$plug_point',cfl='$cfl', tall_showcase='$tall_showcase',top_glass_showcase='$top_glass_showcase',l_window='$l_window',open_tray='$open_tray',display_unit='$display_unit',fascia='$fascia' where id='$id'";
	
	if (!$conn ->query($sql))
	{
		die('Error: ' . mysqli_error());
	}
	echo"<meta http-equiv=refresh content=\"0;url=stall_basic_furniture_master.php?action=view\">";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome to GJEPC</title>

<link rel="stylesheet" type="text/css" href="css/style.css" />

<!--navigation-->
<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>   
   
<link rel="stylesheet" type="text/css" href="css/ddsmoothmenu.css" />
<script type="text/javascript" src="js/ddsmoothmenu.js"></script>
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

<style type="text/css">
<!--
.style1 {color: #FF0000}
.style2 {
	font-size: 16px;
	font-weight: bold;
}
-->
</style>
<script language="javascript">
function checkdata()
{
	if(document.getElementById('contact_name').value == '')
	{
		alert("Please Enter Name");
		document.getElementById('contact_name').focus();
		return false;
	}
	
	if(document.getElementById('mobile_no').value == '')
	{
		alert("Please Enter Mobile No.");
		document.getElementById('mobile_no').focus();
		return false;
	}
	if(!IsNumeric(document.getElementById('mobile_no').value))
	{
		alert("Please enter valid Mobile No.")
		document.getElementById('mobile_no').focus();
		return false;
	}	
	
	if(document.getElementById('mobile_no').value.length < 10)
	{
		alert("Please enter 10 digit Mobile No.");
		document.getElementById('mobile_no').focus();
		return false;
	}

	if(document.getElementById('email_id').value == '')
	{
		alert("Please enter Email ID.");
		document.getElementById('email_id').focus();
		return false;
	}
	if(echeck(document.getElementById('email_id').value)==false)
	{
		document.getElementById('email_id').focus();
		return false;
	}
	if(document.getElementById('password').value == '')
	{
		alert("Please Enter Password");
		document.getElementById('password').focus();
		return false;
	}
	if(document.getElementById('password').value.length < 5)
	{
		alert("password must be at least 5 characters long");
		document.getElementById('password').focus();
		return false;
	}
	if(document.getElementById('role').value == '')
	{
		alert("Please Select Role");
		document.getElementById('role').focus();
		return false;
	}
	
	if(document.getElementById('role').value == 'Admin')
	{
		if(document.getElementById('admin_access').value == '')
		{
		alert("Please Select Admin Access");
		document.getElementById('admin_access').focus();
		return false;
		}
	}
	
	if(document.getElementById('admin_access').value == 'Region Wise')
	{
		if(document.getElementById('region_name').value == '')
		{
		alert("Please Select Region Name");
		document.getElementById('region_name').focus();
		return false;
		}
	}else if(document.getElementById('admin_access').value == 'Division Wise')
	{
		if(document.getElementById('division_name').value == '')
		{
		alert("Please Select Division Name");
		document.getElementById('division_name').focus();
		return false;
		}
	}
			
}
function echeck(str) 
{
	var at="@"
	var dot="."
	var lat=str.indexOf(at)
	var lstr=str.length
	var ldot=str.indexOf(dot)
	if (str.indexOf(at)==-1){
	   alert("Invalid E-mail ID")
	   return false
	}
	if (str.indexOf(at)==-1 || str.indexOf(at)==0 || str.indexOf(at)==lstr){
	   alert("Invalid E-mail ID")
	   return false
	}
	if (str.indexOf(dot)==-1 || str.indexOf(dot)==0 || str.indexOf(dot)==lstr){
		alert("Invalid E-mail ID")
		return false
	}
	 if (str.indexOf(at,(lat+1))!=-1){
		alert("Invalid E-mail ID")
		return false
	 }
	 if (str.substring(lat-1,lat)==dot || str.substring(lat+1,lat+2)==dot){
		alert("Invalid E-mail ID")
		return false
	 }
	 if (str.indexOf(dot,(lat+2))==-1){
		alert("Invalid E-mail ID")
		return false
	 }
	 if (str.indexOf(" ")!=-1){
		alert("Invalid E-mail ID")
		return false
	 }
	 return true					
}

function IsNumeric(strString)
{
   var strValidChars = "0123456789,\. /-";
   var strChar;
   var blnResult = true;

   //if (strString.length == 0) return false;

   //  test strString consists of valid characters listed above
   for (i = 0; i < strString.length && blnResult == true; i++)
   {
      strChar = strString.charAt(i);
      if (strValidChars.indexOf(strChar) == -1)
         {
			blnResult = false;
         }
   }
   return blnResult;
}


</script>
<script language="javascript">
$(document).ready(function(){
 $("#role").change(function () {
	var role=$(this).val();
	if(role=="Super Admin" || role=="Vendor")
	{
		$("#admin_access_div").hide();
	}else
	{
		$("#admin_access_div").show();
	}
	
	if(role=="Vendor")
	{
		$("#vendor_access_div").show();
	}else
	{
		$("#vendor_access_div").hide();
	}
	
 });
 
  $("#admin_access").change(function () {
	var admin_access=$(this).val();
	if(admin_access=="Region Wise")
	{
		$("#admin_resion_div").show();
		$("#admin_division_div").hide();
		
	}else
	{
		$("#admin_resion_div").hide();
		$("#admin_division_div").show();
	}
	
 });
  
});
</script>
</head>

<body>
<div id="header_wrapper"><?php include("include/header.php");?></div>


<div id="nav_wrapper">
	<div class="nav"><?php include("include/menu.php");?></div>
</div>

<div class="clear"></div>

<div class="breadcome_wrap">
	<div class="breadcome"><a href="admin.php">Home</a> > Stall Basic</div>
</div>

<div id="main">
	<div class="content">
    	<div class="content_head">Stall Basic<!--<a href="manage_admin.php?action=add"><div class="content_head_button">Add Admin</div></a> <a href="manage_admin.php?action=view"><div class="content_head_button">View Admin</div></a>--> </div>

<?php if($_REQUEST['action']=='view') {?>    	
<div class="content_details1">
        	
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  	<tr class="orange1">
        <td ><a href="#">Sr. No.</a></td>
		<td >Exhibitor Section</td>
		<td>Area</td>
		<td >Stall Type</td>
		<td >No of Table</td>
		<td >Chair</td>
		<td>Dustbin</td>
		<td >Plug Point</td>
		<td >CFL</td>
		<td >Tall showcase</td>
		<td>Top glass showcase</td>
		<td >door</td>

        <td colspan="3" align="center">Action</td>
       <!-- <td>Password</td>
        <td>Role</td>
        <td>Region/Division</td>
        <td>Status</td>
        <td colspan="3" align="center">Action</td>-->
    </tr>
    
    <?php 
    $order_by = isset($_REQUEST['order_by'])?$_REQUEST['order_by']:'id';
    $asc_desc = isset($_REQUEST['asc_desc'])?$_REQUEST['asc_desc']:'asc';
    $attach = " order by ".$order_by." ".$asc_desc." ";
    
    $i=1;
	//$query="SELECT * FROM iijs_stall_basic_furniture where 1".$attach." ";
	$result = $conn ->query("SELECT * FROM iijs_stall_basic_furniture where 1 and (hall='1' || hall='All' || hall='3') ".$attach." ");
    $rCount=0;
   $rCount = $result->num_rows;		
    if($rCount>0)
    {	
	while($row = $result->fetch_assoc())
	{	
    ?>
   
 	<tr <?php if($i%2==0){echo "bgcolor='#CCCCCC'";}?>>
		<td><?php echo $i;?></td>
		<td><?php echo $row['ex_section']; ?></td>
		<td><?php echo $row['ex_area']; ?></td>
		<td><?php echo $row['ex_stall_type']; ?></td>
		<td><?php echo $row['no_of_table']; ?></td>
		<td><?php echo $row['chair']; ?></td>
		<td><?php echo $row['dustbin']; ?></td>
		<td><?php echo $row['plug_point']; ?></td>
		<td><?php echo $row['cfl']; ?></td>
		<td><?php echo $row['tall_showcase']; ?></td>
		<td><?php echo $row['top_glass_showcase']; ?></td>
		<td><?php echo $row['door']; ?></td>
         <td ><a href="stall_basic_furniture_master.php?action=edit&id=<?php echo $row['id']?>"><img src="images/edit.png" title="Edit" border="0" /></a></td>
        <td ><a href="stall_basic_furniture_master.php?action=del&id=<?php echo $row['id']?>" onClick="return(window.confirm('Are you sure you want to delete?'));"><img src="images/delete.png" title="Delete" border="0" /></td>
       </tr>

	<?php
	$i++;
	   }
	 }
	 else
	 {
	 ?>
    <tr>
        <td colspan="10">Records Not Found</td>
    </tr>
    <?php  }  	?>
</table>
</div>

<?php } ?>        
 
 
<?php 
if(($_REQUEST['action']=='add') || ($_REQUEST['action']=='edit'))
{
  $action='save';
  if(($_REQUEST['id']!='') || ($_REQUEST['action']=='edit'))
  {
		$action='update';
		$result2 = $conn ->query("SELECT *  FROM iijs_stall_basic_furniture  where id='$_REQUEST[id]'");
		if($row2 = $result2->fetch_assoc())
		{	
		$ex_section=$row2['ex_section']; 
		$ex_area=$row2['ex_area']; 
		$ex_stall_type=$row2['ex_stall_type'];
		$no_of_table= $row2['no_of_table'];
		$chair=$row2['chair'];
		$dustbin=$row2['dustbin'];
		$plug_point=$row2['plug_point'];
		$cfl=$row2['cfl'];
		$tall_showcase=$row2['tall_showcase']; 
		$top_glass_showcase=$row2['top_glass_showcase']; 
		$l_window=$row2['l_window']; 
		$open_tray= $row2['open_tray']; 
		$display_unit=$row2['display_unit']; 
		$fascia=$row2['fascia']; 
		}
  }
?>
 
<div class="content_details1 ">
<form action="" method="post" name="form1" id="form1" onsubmit="return checkdata()">
<table width="100%" border="0" cellspacing="0" cellpadding="0"  >
  	<tr class="orange1">
    <td colspan="2"> &nbsp;Update standfitting</td>
    </tr>

    <tr>
    <td class="content_txt">Exhibitor Section <span class="star">*</span></td>
    <td><input type="text" name="ex_section" id="ex_section" title="Please enter Section" class="show-tooltip input_txt" value="<?php echo $ex_section; ?>" />    </td>
    </tr>
    <tr>
      <td class="content_txt">Area <span class="star">*</span></td>
      <td><input type="text" name="ex_area" id="ex_area" class="input_txt" value="<?php echo $ex_area; ?>" />
            </td>
    </tr>
    
    <tr>
    <td class="content_txt">Stall Type <span class="star">*</span></td>
    <td><input type="text" name="ex_stall_type" id="ex_stall_type" class="input_txt" value="<?php echo $ex_stall_type; ?>" /></td>
    </tr>
    
     <tr>
    <td class="content_txt">No of Table <span class="star">*</span></td>
    <td><input type="text" name="no_of_table" id="no_of_table" class="input_txt" value="<?php echo $no_of_table; ?>" /></td>
    </tr>
    
     <tr>
    <td class="content_txt">Chair <span class="star">*</span></td>
    <td><input type="text" name="chair" id="chair" class="input_txt" value="<?php echo $chair; ?>" /></td>
    </tr>
    
     <tr>
    <td class="content_txt"> Dustbin<span class="star">*</span></td>
    <td><input type="text" name="dustbin" id="dustbin" class="input_txt" value="<?php echo $dustbin; ?>" /></td>
    </tr>
    
     <tr>
    <td class="content_txt">Plug Point <span class="star">*</span></td>
    <td><input type="text" name="plug_point" id="plug_point" class="input_txt" value="<?php echo $plug_point; ?>" /></td>
    </tr>
    
    
     <tr>
    <td class="content_txt">CFL <span class="star">*</span></td>
    <td><input type="text" name="cfl" id="cfl" class="input_txt" value="<?php echo $cfl; ?>" /></td>
    </tr>
    
    <tr>
    <td class="content_txt">Tall Showcase <span class="star">*</span></td>
    <td><input type="text" name="tall_showcase" id="tall_showcase" class="input_txt" value="<?php echo $tall_showcase; ?>" /></td>
    </tr>
    
    <tr>
    <td class="content_txt">Top glass showcase <span class="star">*</span></td>
    <td><input type="text" name="top_glass_showcase" id="top_glass_showcase" class="input_txt" value="<?php echo $top_glass_showcase; ?>" /></td>
    </tr>
    
    <tr>
    <td class="content_txt">l window <span class="star">*</span></td>
    <td><input type="text" name="l_window" id="l_window" class="input_txt" value="<?php echo $l_window; ?>" /></td>
    </tr>
    
    <tr>
    <td class="content_txt">Open Tray <span class="star">*</span></td>
    <td><input type="text" name="open_tray" id="open_tray" class="input_txt" value="<?php echo $open_tray; ?>" /></td>
    </tr>
    
     <tr>
    <td class="content_txt">Display Unit <span class="star">*</span></td>
    <td><input type="text" name="display_unit" id="display_unit" class="input_txt" value="<?php echo $display_unit; ?>" /></td>
    </tr>
    
    <tr>
    <td class="content_txt">Fascia <span class="star">*</span></td>
    <td><input type="text" name="fascia" id="fascia" class="input_txt" value="<?php echo $fascia; ?>" /></td>
    </tr>
    
    <tr>
    <td>&nbsp;</td>
    <td>
    <input type="submit" value="Submit" class="input_submit"/>
    <input type="hidden" name="action" id="action" value="<?php echo $action;?>" />
    <input type="hidden" name="id" id="id"  value="<?php echo $_REQUEST['id'];?>" />    </td>
    </tr>
</table>
</form>
        </div>
        
 <?php } ?>    
    
    </div>
</div>

<div id="footer_wrap"><?php include("include/footer.php");?></div>


</body>
</html>

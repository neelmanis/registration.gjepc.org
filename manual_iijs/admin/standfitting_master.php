<?php session_start(); ?>
<?php include('../db.inc.php');?>
<?php include('../functions.php');?>
<?php 

if (($_REQUEST['action']=='del') && ($_REQUEST['id']!=''))
{
	$sql="delete from iijs_stand_items_master where Item_Id='$_REQUEST[id]'";
	
	if (!$conn ->query($sql))
	{
		die('Error: ' . mysqli_error());
	}
	echo"<meta http-equiv=refresh content=\"0;url=standfitting_master.php?action=view\">";
}

if (($_REQUEST['action']=='update')&&($_REQUEST['id']!=''))
{
	$Item_Description=$_REQUEST['Item_Description'];
	$Item_Quantity=$_REQUEST['Item_Quantity'];
	$Item_Rate=$_REQUEST['Item_Rate'];
	
	$id=$_REQUEST['id'];	

	$sql="update iijs_stand_items_master set Item_Description='$Item_Description',Item_Quantity='$Item_Quantity',Item_Rate='$Item_Rate' where Item_Id='$id'";
	
	if (!$conn ->query($sql))
	{
		die('Error: ' . mysqli_error());
	}
	echo"<meta http-equiv=refresh content=\"0;url=standfitting_master.php?action=view\">";
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
	<div class="breadcome"><a href="admin.php">Home</a> > Standfitting master</div>
</div>

<div id="main">
	<div class="content">
    	<div class="content_head"><!--<a href="manage_admin.php?action=add"><div class="content_head_button">Add Admin</div></a> <a href="manage_admin.php?action=view"><div class="content_head_button">View Admin</div></a>--> </div>

<?php if($_REQUEST['action']=='view') {?>    	
<div class="content_details1">
        	
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  	<tr class="orange1">
        <td ><a href="#">Sr. No.</a></td>
        <td >Category</td>
        <td >Item Description</td>
       <!-- <td>Item ERPCode</td>-->
        <td >Item Quantity</td>
        <td >Item Rate</td>
        <td colspan="3" align="center">Action</td>
       <!-- <td>Password</td>
        <td>Role</td>
        <td>Region/Division</td>
        <td>Status</td>
        <td colspan="3" align="center">Action</td>-->
    </tr>
    
    <?php 
    $order_by = isset($_REQUEST['order_by'])?$_REQUEST['order_by']:'Item_Section_Type';
    $asc_desc = isset($_REQUEST['asc_desc'])?$_REQUEST['asc_desc']:'asc';
    $attach = " order by ".$order_by." ".$asc_desc." ";
    
    $i=1;
	$query="SELECT * FROM iijs_stand_items_master where 1".$attach." ";
	$result = $conn ->query("SELECT * FROM iijs_stand_items_master where 1".$attach." ");
    $rCount=0;
   $rCount = $result->num_rows;	
    if($rCount>0)
    {	
	while($row = $result->fetch_assoc())
	{	
	
    ?>  
 	<tr <?php if($i%2==0){echo "bgcolor='#CCCCCC'";}?>>
        <td><?php echo $i;?></td>
		 <td><?php echo $row['Item_Section_Type'];?></td>
        <td><?php echo $row['Item_Description']; ?></td>
      
        <td><?php echo $row['Item_Quantity']; ?></td>
        <td><?php echo $row['Item_Rate']; ?></td>
         <td ><a href="standfitting_master.php?action=edit&id=<?php echo $row['Item_ID']?>"><img src="images/edit.png" title="Edit" border="0" /></a></td>
        <td ><a href="standfitting_master.php?action=del&id=<?php echo $row['Item_ID']?>" onClick="return(window.confirm('Are you sure you want to delete?'));"><img src="images/delete.png" title="Delete" border="0" /></td>
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
		$result2 = $conn ->query("SELECT *  FROM iijs_stand_items_master  where Item_Id='$_REQUEST[id]'");
		if($row2 = $result2->fetch_assoc())
		{
			
			$Item_Description=stripslashes($row2['Item_Description']);
			$Item_Quantity=stripslashes($row2['Item_Quantity']);
			$Item_Rate=stripslashes($row2['Item_Rate']);
			

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
    <td class="content_txt">Item Description <span class="star">*</span></td>
    <td><input type="text" name="Item_Description" id="Item_Description" title="Please enter description" class="show-tooltip input_txt" value="<?php echo $Item_Description; ?>" />    </td>
    </tr>
    <tr>
      <td class="content_txt">Item Quantity <span class="star">*</span></td>
      <td><input type="text" name="Item_Quantity" id="Item_Quantity" class="input_txt" value="<?php echo $Item_Quantity; ?>" />
            </td>
    </tr>
    
    <tr>
    <td class="content_txt">Item Rate <span class="star">*</span></td>
    <td><input type="text" name="Item_Rate" id="Item_Rate" class="input_txt" value="<?php echo $Item_Rate; ?>" /></td>
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

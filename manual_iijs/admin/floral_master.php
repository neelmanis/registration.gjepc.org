<?php session_start(); ?>
<?php include('../db.inc.php');?>
<?php include('../functions.php');?>
<?php 

if (($_REQUEST['action']=='del') && ($_REQUEST['id']!=''))
{
	$sql="delete from iijs_floral_items_master where Floral_Items_Master_ID='$_REQUEST[id]'";
	
	if (!$conn ->query($sql))
	{
		die('Error: ' . mysqli_error());
	}
	echo"<meta http-equiv=refresh content=\"0;url=floral_master.php?action=view\">";
}

if (($_REQUEST['action']=='update')&&($_REQUEST['id']!=''))
{
	$Floral_Items_Master_Description=addslashes($_REQUEST['Floral_Items_Master_Description']);
	$Item_Rate=$_REQUEST['Item_Rate'];
	$Item_Quantity=$_REQUEST['Item_Quantity'];
	$id=$_REQUEST['id'];	

	$sql="update iijs_floral_items_master set Floral_Items_Master_Description='$Floral_Items_Master_Description',Item_Rate='$Item_Rate',Item_Quantity='$Item_Quantity' where Floral_Items_Master_ID='$id'";

	if (!$conn ->query($sql))
	{
		die('Error: ' . mysqli_error());
	}
	echo"<meta http-equiv=refresh content=\"0;url=floral_master.php?action=view\">";
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


</script>
<script language="javascript">
$(document).ready(function(){
 
  
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
	<div class="breadcome"><a href="admin.php">Home</a> > Badges Master</div>
</div>

<div id="main">
	<div class="content">
    	<div class="content_head"><!--<a href="manage_admin.php?action=add"><div class="content_head_button">Add Admin</div></a> <a href="manage_admin.php?action=view"><div class="content_head_button">View Admin</div></a> --></div>

<?php if($_REQUEST['action']=='view') {?>    	
<div class="content_details1">
        	
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  	<tr class="orange1">
        <td ><a href="#">Sr. No.</a></td>
        <td >Floral Items Master Description</td>
       
         <td>Item Rate</td>
         <td>Item Quantity</td>
       <td colspan="3" align="center">Action</td>
       <!-- <td>Password</td>
        <td>Role</td>
        <td>Region/Division</td>
        <td>Status</td>
        <td colspan="3" align="center">Action</td>-->
    </tr>
    
    <?php 
    $order_by = isset($_REQUEST['order_by'])?$_REQUEST['order_by']:'Floral_Items_Master_ID';
    $asc_desc = isset($_REQUEST['asc_desc'])?$_REQUEST['asc_desc']:'asc';
    $attach = " order by ".$order_by." ".$asc_desc." ";
    
    $i=1;
	//$query="SELECT * FROM iijs_safe_rental_master where 1".$attach." ";
	$result = $conn ->query("SELECT * FROM iijs_floral_items_master where 1".$attach." ");
    $rCount=0;
    $rCount = $result->num_rows;		
    if($rCount>0)
    {	
	while($row = $result->fetch_assoc())
	{	
    ?>  
 	<tr <?php if($i%2==0){echo "bgcolor='#CCCCCC'";}?>>
        <td><?php echo $i;?></td>
        <td><?php echo $row['Floral_Items_Master_Description']; ?></td>
       
        <td><?php echo $row['Item_Rate']; ?></td>
         <td><?php echo $row['Item_Quantity']; ?></td>
         <td ><a href="floral_master.php?action=edit&id=<?php echo $row['Floral_Items_Master_ID']?>"><img src="images/edit.png" title="Edit" border="0" /></a></td>
        <td ><a href="floral_master.php?action=del&id=<?php echo $row['Floral_Items_Master_ID']?>" onClick="return(window.confirm('Are you sure you want to delete?'));"><img src="images/delete.png" title="Delete" border="0" /></td>
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
		$result2 = $conn ->query("SELECT *  FROM iijs_floral_items_master  where Floral_Items_Master_ID='$_REQUEST[id]'");
		if($row2 = $result2->fetch_assoc())
		{
			
			$Floral_Items_Master_Description=$row2['Floral_Items_Master_Description'];
			$Item_Rate=stripslashes($row2['Item_Rate']);
			$Item_Quantity=stripslashes($row2['Item_Quantity']);
			

		}
  }
?>
 
<div class="content_details1 ">
<form action="" method="post" name="form1" id="form1" onsubmit="return checkdata()">
<table width="100%" border="0" cellspacing="0" cellpadding="0"  >
  	<tr class="orange1">
    <td colspan="2"> &nbsp;update floral </td>
    </tr>

    <tr>
    <td class="content_txt">Floral Items Master Description <span class="star">*</span></td>
    <td><!--<input type="text" name="Floral_Items_Master_Description" id="Floral_Items_Master_Description" title="Please enter description" class="show-tooltip input_txt" value="<?php echo $Floral_Items_Master_Description; ?>" />--> <textarea  rows="4" name="Floral_Items_Master_Description" id="Floral_Items_Master_Description"><?php echo $Floral_Items_Master_Description; ?></textarea>   </td>
    </tr>
    <tr>
      <td class="content_txt">Item Rate <span class="star">*</span></td>
      <td><input type="text" name="Item_Rate" id="Item_Rate" class="input_txt" value="<?php echo $Item_Rate; ?>" />
           </td>
    </tr>
    
    <tr>
    <td class="content_txt">Item Quantity<span class="star">*</span></td>
    <td><input type="text" name="Item_Quantity" id="Item_Quantity" class="input_txt" value="<?php echo $Item_Quantity; ?>" /></td>
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

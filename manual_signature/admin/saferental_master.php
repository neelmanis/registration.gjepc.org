<?php session_start(); ?>
<?php include('../db.inc.php');?>
<?php include('../functions.php');?>
<?php 

if (($_REQUEST['action']=='del') && ($_REQUEST['id']!=''))
{
	$sql="delete from iijs_safe_rental_master where Safe_ID='$_REQUEST[id]'";
	
	if (!$conn ->query($sql))
	{
		die('Error: ' . mysqli_error());
	}
	echo"<meta http-equiv=refresh content=\"0;url=saferental_master.php?action=view\">";
}

if (($_REQUEST['action']=='update')&&($_REQUEST['id']!=''))
{
	$Safe_Description=$_REQUEST['Safe_Description'];
	$vendor=$_REQUEST['vendor'];
	$Outside_height=$_REQUEST['Outside_height'];
	$Outside_width=$_REQUEST['Outside_width'];
	$Outside_depth=$_REQUEST['Outside_depth'];
	$Inside_height=$_REQUEST['Inside_height'];
	$Inside_width=$_REQUEST['Inside_width'];
	$Inside_depth=$_REQUEST['Inside_depth'];
	$Adj_Shelves=$_REQUEST['Adj_Shelves'];
	$Lockers=$_REQUEST['Lockers'];
	$Item_Quantity=$_REQUEST['Item_Quantity'];
	$deadline_1_inr=$_REQUEST['deadline_1_inr'];
	$deadline_2_inr=$_REQUEST['deadline_2_inr'];
	$deadline_3_inr=$_REQUEST['deadline_3_inr'];
	$deadline_1_us=$_REQUEST['deadline_1_us'];
	$deadline_2_us=$_REQUEST['deadline_2_us'];
	$deadline_3_us=$_REQUEST['deadline_3_us'];
	$id=$_REQUEST['id'];	

	$sql="update iijs_safe_rental_master set Safe_Description='$Safe_Description',vendor='$vendor',Outside_height='$Outside_height',Outside_width='$Outside_width',Outside_depth='$Outside_depth',Inside_height='$Inside_height',Inside_width='$Inside_width',Inside_depth='$Inside_depth',Adj_Shelves='$Adj_Shelves',Lockers='$Lockers',Item_Quantity='$Item_Quantity',deadline_1_inr='$deadline_1_inr',deadline_2_inr='$deadline_2_inr',deadline_3_inr='$deadline_3_inr',deadline_1_us='$deadline_1_us',deadline_2_us='$deadline_2_us',deadline_3_us='$deadline_3_us' where Safe_ID='$id'";
	
	if (!$conn ->query($sql))
	{
		die('Error: ' . mysqli_error());
	}
	echo"<meta http-equiv=refresh content=\"0;url=saferental_master.php?action=view\">";
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
	<div class="breadcome"><a href="admin.php">Home</a> > Safe Rental Master</div>
</div>

<div id="main">
	<div class="content">
    	<div class="content_head"><!--<a href="manage_admin.php?action=add"><div class="content_head_button">Add Admin</div></a> <a href="manage_admin.php?action=view"><div class="content_head_button">View Admin</div></a> --></div>

<?php if($_REQUEST['action']=='view') {?>    	
<div class="content_details1">
        	
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  	<tr class="orange1">
        <td ><a href="#">Sr. No.</a></td>
        <td >Safe Description</td>
       <!-- <td>Item ERPCode</td>-->
        <td >Outside height</td>
         <td>Outside_width</td>
         <td>Outside_depth</td>
        <td>Inside height</td>
        <td>Inside width</td>
        <td>Inside depth</td>
        <td>Adj Shelves</td>
        <td>Lockers</td>
        <td>Item Quantity</td>
        <td>Deadline 1 Domestic</td>
        <td>Deadline 2 Domestic</td>
        <td>Deadline 3 Domestic</td>
         <td>Deadline 1 international</td>
        <td>Deadline 2 international</td>
        <td>Deadline 3 international</td>
        <td colspan="3" align="center">Action</td>
    </tr>
    
    <?php 
    $order_by = isset($_REQUEST['order_by'])?$_REQUEST['order_by']:'Safe_ID';
    $asc_desc = isset($_REQUEST['asc_desc'])?$_REQUEST['asc_desc']:'asc';
    $attach = " order by ".$order_by." ".$asc_desc." ";
    
    $i=1;
	//$query="SELECT * FROM iijs_safe_rental_master where 1".$attach." ";
	$result = $conn ->query("SELECT * FROM iijs_safe_rental_master where 1".$attach." ");
    $rCount=0;
   $rCount = $result->num_rows;		
    if($rCount>0)
    {	
	while($row = $result->fetch_assoc())
	{	
    ?>  
 	<tr <?php if($i%2==0){echo "bgcolor='#CCCCCC'";}?>>
        <td><?php echo $i;?></td>
        <td><?php echo $row['Safe_Description']; ?></td>
        <!--<td><?php echo $row['Item_ERPCode']; ?></td>-->
        <td><?php echo $row['Outside_height']; ?></td>
        <td><?php echo $row['Outside_width']; ?></td>
         <td><?php echo $row['Outside_depth']; ?></td>
        <td><?php echo $row['Inside_height']; ?></td>
        <td><?php echo $row['Inside_width']; ?></td>
        <td><?php echo $row['Inside_depth']; ?></td>
        <td><?php echo $row['Adj_Shelves']; ?></td>
        <td><?php echo $row['Lockers']; ?></td>
        <td><?php echo $row['Item_Quantity']; ?></td>
        <td><?php echo $row['deadline_1_inr']; ?></td>
        <td><?php echo $row['deadline_2_inr']; ?></td>
        <td><?php echo $row['deadline_3_inr']; ?></td>
        <td><?php echo $row['deadline_1_us']; ?></td>
        <td><?php echo $row['deadline_2_us']; ?></td>
        <td><?php echo $row['deadline_3_us']; ?></td>
        <td ><a href="saferental_master.php?action=edit&id=<?php echo $row['Safe_ID']?>"><img src="images/edit.png" title="Edit" border="0" /></a></td>
        <td ><a href="saferental_master.php?action=del&id=<?php echo $row['Safe_ID']?>" onClick="return(window.confirm('Are you sure you want to delete?'));"><img src="images/delete.png" title="Delete" border="0" /></td>
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
		$result2 =$conn ->query("SELECT *  FROM iijs_safe_rental_master  where Safe_ID='$_REQUEST[id]'");
		if($row2 = $result2->fetch_assoc())
		{
			
			$Safe_Description=stripslashes($row2['Safe_Description']);
			$vendor=stripslashes($row2['vendor']);
			$Outside_height=stripslashes($row2['Outside_height']);
			$Outside_width=stripslashes($row2['Outside_width']);
			$Outside_depth=stripslashes($row2['Outside_depth']);
			$Inside_height=stripslashes($row2['Inside_height']);
			$Inside_width=$row2['Inside_width'];
			$Inside_depth=stripslashes($row2['Inside_depth']);
			$Adj_Shelves=stripslashes($row2['Adj_Shelves']);
			$Lockers=stripslashes($row2['Lockers']);
			$Item_Quantity=$row2['Item_Quantity'];
			$deadline_1_inr=stripslashes($row2['deadline_1_inr']);
			$deadline_2_inr=stripslashes($row2['deadline_2_inr']);
			$deadline_3_inr=stripslashes($row2['deadline_3_inr']);
			$deadline_1_us=stripslashes($row2['deadline_1_us']);
			$deadline_2_us=stripslashes($row2['deadline_2_us']);
			$deadline_3_us=stripslashes($row2['deadline_3_us']);
		}
  }
?>
 
<div class="content_details1 ">
<form action="" method="post" name="form1" id="form1" onsubmit="return checkdata()">
<table width="100%" border="0" cellspacing="0" cellpadding="0"  >
  	<tr class="orange1">
    <td colspan="2"> &nbsp;update Saferental</td>
    </tr>

    <tr>
    <td class="content_txt">Safe Description <span class="star">*</span></td>
    <td><input type="text" name="Safe_Description" id="Safe_Description" title="Please enter Description" class="show-tooltip input_txt" value="<?php echo $Safe_Description; ?>" />    </td>
    </tr>
	
	<tr>
    <td class="content_txt">Vendor<span class="star">*</span></td>
	<td>
    <select name="vendor" id="vendor">
    <option selected="selected" value="">-----Select Vendor----</option>
        <option value="godrej" <?php if($vendor=="godrej"){?> selected="selected" <?php }?>>Godrej</option>
        <option value="vendor2" <?php if($vendor=="vendor2"){?> selected="selected" <?php }?>>Other Vendor</option>
        </select>
    </td>
	</tr>
	
    <tr>
      <td class="content_txt">Outside height<span class="star">*</span></td>
      <td><input type="text" name="Outside_height" id="Outside_height" class="input_txt" value="<?php echo $Outside_height; ?>" />
    </tr>
    
    <tr>
    <td class="content_txt">Outside width <span class="star">*</span></td>
    <td><input type="text" name="Outside_width" id="Outside_width" class="input_txt" value="<?php echo $Outside_width; ?>" /></td>
    </tr>
    
    <tr>
    <td class="content_txt">Outside depth <span class="star">*</span></td>
    <td><input type="text" name="Outside_depth" id="Outside_depth" class="input_txt" value="<?php echo $Outside_depth; ?>" /></td>
    </tr>
    
     <tr>
    <td class="content_txt">Inside_height <span class="star">*</span></td>
    <td><input type="text" name="Inside_height" id="Inside_height" class="input_txt" value="<?php echo $Inside_height; ?>" /></td>
    </tr>
     <tr>
    <td class="content_txt">Inside width <span class="star">*</span></td>
    <td><input type="text" name="Inside_width" id="Inside_width" class="input_txt" value="<?php echo $Inside_width; ?>" /></td>
    </tr>
     <tr>
    <td class="content_txt">Inside depth <span class="star">*</span></td>
    <td><input type="text" name="Inside_depth" id="Inside_depth" class="input_txt" value="<?php echo $Inside_depth; ?>" /></td>
    </tr>
     <tr>
    <td class="content_txt">Adj_Shelves <span class="star">*</span></td>
    <td><input type="text" name="Adj_Shelves" id="Adj_Shelves" class="input_txt" value="<?php echo $Adj_Shelves; ?>" /></td>
    </tr>
    
    <tr>
    <td class="content_txt">Lockers <span class="star">*</span></td>
    <td><input type="text" name="Lockers" id="Lockers" class="input_txt" value="<?php echo $Lockers; ?>" /></td>
    </tr>
    
      <tr>
    <td class="content_txt">Item Quantity <span class="star">*</span></td>
    <td><input type="text" name="Item_Quantity" id="Item_Quantity" class="input_txt" value="<?php echo $Item_Quantity; ?>" /></td>
    </tr>
    
    
      <tr>
    <td class="content_txt">Deadline 1 Domestic <span class="star">*</span></td>
    <td><input type="text" name="deadline_1_inr" id="deadline_1_inr" class="input_txt" value="<?php echo $deadline_1_inr; ?>" /></td>
    </tr>
    
      <tr>
    <td class="content_txt">Deadline 2 Domestic <span class="star">*</span></td>
    <td><input type="text" name="deadline_2_inr" id="deadline_2_inr" class="input_txt" value="<?php echo $deadline_2_inr; ?>" /></td>
    </tr>
    
      <tr>
    <td class="content_txt">Deadline 3 Domestic <span class="star">*</span></td>
    <td><input type="text" name="deadline_3_inr" id="deadline_3_inr" class="input_txt" value="<?php echo $deadline_3_inr; ?>" /></td>
    </tr>
    
      <tr>
    <td class="content_txt">Deadline 1 International <span class="star">*</span></td>
    <td><input type="text" name="deadline_1_us" id="deadline_1_us" class="input_txt" value="<?php echo $deadline_1_us; ?>" /></td>
    </tr>
    
     <tr>
    <td class="content_txt">Deadline 2 International <span class="star">*</span></td>
    <td><input type="text" name="deadline_2_us" id="deadline_2_us" class="input_txt" value="<?php echo $deadline_2_us; ?>" /></td>
    </tr>
    
     <tr>
    <td class="content_txt">Deadline 3 International <span class="star">*</span></td>
    <td><input type="text" name="deadline_3_us" id="deadline_3_us" class="input_txt" value="<?php echo $deadline_3_us; ?>" /></td>
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

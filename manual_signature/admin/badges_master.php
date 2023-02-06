<?php session_start(); ?>
<?php include('../db.inc.php');?>
<?php include('../functions.php');?>
<?php 

if (($_REQUEST['action']=='del') && ($_REQUEST['id']!=''))
{
	$sql="delete from iijs_badge_master where Badge_Master_ID='$_REQUEST[id]'";
	
	if (!$conn->query($sql))
	{
		die('Error: ' . mysqli_error());
	}
	echo"<meta http-equiv=refresh content=\"0;url=badges_master.php?action=view\">";
}




if (($_REQUEST['action']=='update')&&($_REQUEST['id']!=''))
{
	$Stall_Area=$_REQUEST['Stall_Area'];
	$Exhibitor_Badges=$_REQUEST['Exhibitor_Badges'];
	$Service_Badges=$_REQUEST['Service_Badges'];
	$isDuplex=$_REQUEST['isDuplex'];
	$id=$_REQUEST['id'];	

	$sql="update iijs_badge_master set Stall_Area='$Stall_Area',Exhibitor_Badges='$Exhibitor_Badges',Service_Badges='$Service_Badges',isDuplex='$isDuplex' where Badge_Master_ID='$id'";

	if (!$conn->query($sql))
	{
		die('Error: ' . mysqli_error());
	}
	echo"<meta http-equiv=refresh content=\"0;url=badges_master.php?action=view\">";
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
        <td >Stall Area</td>
        <td>Exhibitor Badges</td>
        <td >Service Badges</td>
        <td >Replace Badges</td>
        <td >Duplex</td>
        <td colspan="3" align="center">Action</td>
      
    </tr>
    
    <?php 
    $order_by = isset($_REQUEST['order_by'])?$_REQUEST['order_by']:'Badge_Master_ID';
    $asc_desc = isset($_REQUEST['asc_desc'])?$_REQUEST['asc_desc']:'asc';
    $attach = " order by ".$order_by." ".$asc_desc." ";
    
    $i=1;
	//echo $query="SELECT * FROM iijs_badge_master where 1".$attach." ";
	$result = $conn ->query("SELECT * FROM iijs_badge_master where 1".$attach." ");
    $rCount=0;
   $rCount = $result->num_rows;	
    if($rCount>0)
    {	
	while($row = $result->fetch_assoc())
	{	
    ?>  
 	<tr <?php if($i%2==0){echo "bgcolor='#CCCCCC'";}?>>
        <td><?php echo $i;?></td>
        <td><?php echo $row['Stall_Area']; ?></td>
        <td><?php echo $row['Exhibitor_Badges']; ?></td>
        <td><?php echo $row['Service_Badges']; ?></td>
        <td><?php echo $row['Replace_Badges']; ?></td>
        <td><?php echo $row['isDuplex']; ?></td>
        <td ><a href="badges_master.php?action=edit&id=<?php echo $row['Badge_Master_ID']?>"><img src="images/edit.png" title="Edit" border="0" /></a></td>
        <td ><a href="badges_master.php?action=del&id=<?php echo $row['Badge_Master_ID']?>" onClick="return(window.confirm('Are you sure you want to delete?'));"><img src="images/delete.png" title="Delete" border="0" /></td>
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
		$result2 = $conn ->query("SELECT *  FROM iijs_badge_master  where Badge_Master_ID='$_REQUEST[id]'");
		if($row2 = $result2->fetch_assoc())
		{
			
			$Stall_Area=stripslashes($row2['Stall_Area']);
			$Exhibitor_Badges=stripslashes($row2['Exhibitor_Badges']);
			$Service_Badges=stripslashes($row2['Service_Badges']);
			$isDuplex=stripslashes($row2['isDuplex']);
			

		}
  }
?>
 
<div class="content_details1 ">
<form action="" method="post" name="form1" id="form1" onsubmit="return checkdata()">
<table width="100%" border="0" cellspacing="0" cellpadding="0"  >
  	<tr class="orange1">
    <td colspan="2"> &nbsp;Update Badges</td>
    </tr>

    <tr>
    <td class="content_txt">Stall Area <span class="star">*</span></td>
    <td><input type="text" name="Stall_Area" id="Stall_Area" title="Please enter Area" class="show-tooltip input_txt" value="<?php echo $Stall_Area; ?>" />    </td>
    </tr>
    <tr>
      <td class="content_txt">Exhibitor Badges <span class="star">*</span></td>
      <td><input type="text" name="Exhibitor_Badges" id="Exhibitor_Badges" class="input_txt" value="<?php echo $Exhibitor_Badges; ?>" />
            </td>
    </tr>
    
    <tr>
    <td class="content_txt">Service Badges <span class="star">*</span></td>
    <td><input type="text" name="Service_Badges" id="Service_Badges" class="input_txt" value="<?php echo $Service_Badges; ?>" /></td>
    </tr>
    <tr>
    <td class="content_txt">Duplex <span class="star">*</span></td>
    <td><input type="text" name="isDuplex" id="isDuplex" class="input_txt" value="<?php echo $isDuplex; ?>" /></td>
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

<?php 
session_start(); 
include('../db.inc.php'); 
include('../functions.php'); ?>
<?php 
if(($_REQUEST['action']=='del') && ($_REQUEST['id']!=''))
{
	$sql="delete from admin_master where id='$_REQUEST[id]'";
	$result = $conn ->query($sql);   
    if(!$result) die ($conn->error);
	echo"<meta http-equiv=refresh content=\"0;url=manage_admin.php?action=view\">";
}

if(($_REQUEST['action']=='active') && ($_REQUEST['id']!=''))
{
	$status=$_REQUEST['status'];	
	$id=$_REQUEST['id'];
	$sql="update admin_master set status='$status' where id='$id'";
	$result = $conn ->query($sql);   
    if(!$result) die ($conn->error);
	echo"<meta http-equiv=refresh content=\"0;url=manage_admin.php?action=view\">";
}

if ($_REQUEST['action']=='save')
{
	$post_date = date('Y-m-d');
	$contact_name = filter($_REQUEST['contact_name']);
	$mobile_no = filter($_REQUEST['mobile_no']);
	$email_id = filter($_REQUEST['email_id']);
	$password = filter($_REQUEST['password']);
	$role = filter($_REQUEST['role']);
	if($role=="Admin")
	{
		$admin_access=$_REQUEST['admin_access'];
		if($admin_access=='Region Wise')
		{
			$region_name=$_REQUEST['region_name'];
		}else
		{
			$division_name=$_REQUEST['division_name'];
		}	
	} 
	
	if($role=="Vendor")
	{
		$admin_access=$_REQUEST['vendor_access'];
	} 
	
	$result = $conn ->query("select * from admin_master where email_id='$email_id' and password='$password'");
	$cnt = $result->num_rows; 
	if($cnt > 0)
	{
		echo "<script langauge=\"javascript\">alert(\"Email ID or Password already in use\");location.href='manage_admin.php?action=view';</script>";
	}
	else
	{
		$sql="INSERT INTO admin_master (contact_name, mobile_no,email_id,password,role,admin_access,region_name,division_name,status) VALUES ('$contact_name', '$mobile_no','$email_id','$password','$role','$admin_access','$region_name','$division_name','1')";	
		$result = $conn ->query($sql);   
		echo"<meta http-equiv=refresh content=\"0;url=manage_admin.php?action=view\">";
	}
}

if(($_REQUEST['action']=='update')&&($_REQUEST['id']!=''))
{
	$contact_name=filter($_REQUEST['contact_name']);
	$mobile_no=filter($_REQUEST['mobile_no']);
	$email_id=filter($_REQUEST['email_id']);
	$password=filter($_REQUEST['password']);
	$role=filter($_REQUEST['role']);
	if($role=="Admin")
	{
		$admin_access=$_REQUEST['admin_access'];
		if($admin_access=='Region Wise')
		{
			$region_name=$_REQUEST['region_name'];
		}else
		{
			$division_name=$_REQUEST['division_name'];
		}
	} 
	
	if($role=="Vendor")
	{
		$admin_access=$_REQUEST['vendor_access'];
	} 
	$id=$_REQUEST['id'];	

	$sqlx="update admin_master set contact_name='$contact_name',mobile_no='$mobile_no',email_id='$email_id',password='$password',role='$role',admin_access='$admin_access',region_name='$region_name',division_name='$division_name' where id='$id'";
	$result = $conn ->query($sqlx);   
	echo"<meta http-equiv=refresh content=\"0;url=manage_admin.php?action=view\">";
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

var roleVal = $('#role').val();
if(roleVal=="Vendor")
{
	$("#vendor_access_div").show();
	$("#admin_access_div").hide();
	$("#admin_division_div").hide();
	$("#admin_resion_div").hide();
}else
{
	$("#vendor_access_div").hide();
}
 $("#role").change(function () {
	var role=$(this).val();
	if(role=="Super Admin" || role=="Vendor")
	{
		$("#admin_access_div").hide();
		$("#admin_division_div").hide();
		$("#admin_resion_div").hide();
	} else
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
	<div class="breadcome"><a href="admin.php">Home</a> > Manage Admin</div>
</div>

<div id="main">
	<div class="content">
    	<div class="content_head"><a href="manage_admin.php?action=add"><div class="content_head_button">Add Admin</div></a> <a href="manage_admin.php?action=view"><div class="content_head_button">View Admin</div></a> </div>

<?php if($_REQUEST['action']=='view') {?>    	
<div class="content_details1">
        	
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  	<tr class="orange1">
        <td ><a href="#">Sr. No.</a></td>
        <td >Name</td>
        <td >Email ID</td>
        <td >Mobile No.</td>
        <td>Password</td>
        <td>Role</td>
        <td>Region/Division</td>
        <td>Vendor</td>
        <td>Status</td>
        <td colspan="3" align="center">Action</td>
    </tr>
    
    <?php 
    $order_by = isset($_REQUEST['order_by'])?$_REQUEST['order_by']:'id';
    $asc_desc = isset($_REQUEST['asc_desc'])?$_REQUEST['asc_desc']:'desc';
    $attach = " order by ".$order_by." ".$asc_desc." ";
    
    $i=1;
	
	$result = $conn ->query("SELECT * FROM admin_master where 1".$attach." ");
    $rCount=0;
    $rCount = $result->num_rows;		
    if($rCount>0)
    {	
	while($row = $result->fetch_assoc())
	{	
    ?>  
 	<tr <?php if($i%2==0){echo "bgcolor='#CCCCCC'";}?>>
        <td><?php echo $i;?></td>
        <td><?php echo $row['contact_name']; ?></td>
        <td><?php echo $row['email_id']; ?></td>
        <td><?php echo $row['mobile_no']; ?></td>
        <td><?php echo $row['password']; ?></td>
        <td><?php echo $row['role']; ?></td>
        <td><?php if($row['admin_access']=='Region Wise'){echo $row['region_name'];}else {echo $row['division_name'];} ?></td>
        <td><?php echo $row['vendor_access']; ?></td>
        <td>
		<?php if($row['status'] == '1') 
        { 
        echo "<span style='color:green'>Active</span>";
        }else if($row['status'] == '0') 
        {
        echo "<span style='color:red'>Deactive</span>";
        } 
        ?>
        </td>
        <td><?php if($row['status'] == 1) { ?> <a style="text-decoration:none;" href="manage_admin.php?id=<?php echo $row['id']; ?>&status=0&action=active" onClick="return(window.confirm('Are you sure you want to Deactivate.'));"><img src="images/inactive.png" border="0" title="Inactive"/></a><?php } else { ?><a style="text-decoration:none;" href="manage_admin.php?id=<?php echo $row['id']; ?>&status=1&action=active" onClick="return(window.confirm('Are you sure you want to Activate.'));"><img src="images/active.png" border="0" title="Active"/></a><?php } ?></td>
        
        <td ><a href="manage_admin.php?action=edit&id=<?php echo $row['id']?>"><img src="images/edit.png" title="Edit" border="0" /></a></td>
        <td ><a href="manage_admin.php?action=del&id=<?php echo $row['id']?>" onClick="return(window.confirm('Are you sure you want to delete?'));"><img src="images/delete.png" title="Delete" border="0" /></td>
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
		$result2 = $conn ->query("SELECT *  FROM admin_master  where id='$_REQUEST[id]'");
		if($row2 = $result2->fetch_assoc())
		{			
			$contact_name=stripslashes($row2['contact_name']);
			$mobile_no=stripslashes($row2['mobile_no']);
			$email_id=stripslashes($row2['email_id']);
			$password=stripslashes($row2['password']);
			$role=stripslashes($row2['role']);
			$admin_access=$row2['admin_access'];
			$region_name=stripslashes($row2['region_name']);
			$division_name=stripslashes($row2['division_name']);

		}
  }
?>
 
<div class="content_details1 ">
<form action="" method="post" name="form1" id="form1" onsubmit="return checkdata()">
<table width="100%" border="0" cellspacing="0" cellpadding="0"  >
  	<tr class="orange1">
    <td colspan="2"> &nbsp;Add New Admin</td>
    </tr>

    <tr>
    <td class="content_txt">Name <span class="star">*</span></td>
    <td><input type="text" name="contact_name" id="contact_name" title="Please enter your name" class="show-tooltip input_txt" value="<?php echo $contact_name; ?>" />    </td>
    </tr>
    <tr>
      <td class="content_txt">Mobile No. <span class="star">*</span></td>
      <td><input type="text" name="mobile_no" id="mobile_no" class="input_txt" value="<?php echo $mobile_no; ?>" />
        <label id="lblMsg" style="display:none;">Please enter your contact no.</label>    </td>
    </tr>
    
    <tr>
    <td class="content_txt">Email ID <span class="star">*</span></td>
    <td><input type="text" name="email_id" id="email_id" class="input_txt" value="<?php echo $email_id; ?>" /></td>
    </tr>
    
    <tr>
    <td class="content_txt">Password <span class="star">*</span></td>
    <td><input type="password" name="password" id="password" class="input_txt" value="<?php echo $password; ?>" /></td>
    </tr>
    
    <tr>
    <td class="content_txt">Role <span class="star">*</span></td>
    <td>
    <select name="role" id="role" class="input_txt">
    <option value="">Select Role</option>
    <option value="Admin" <?php if($role=="Admin"){echo "selected='selected'";} ?>>Admin</option>
    <option value="Super Admin" <?php if($role=="Super Admin"){echo "selected='selected'";} ?>>Super Admin</option>
    <option value="Vendor" <?php if($role=="Vendor"){echo "selected='selected'";} ?>>Vendor</option>    
    </select>
	</td>
    </tr>

<tbody <?php if($role=='Vendor' || $role==''){?> style="display:none" <?php }?> id="vendor_access_div">
    <tr>
      <td valign="top" bgcolor="#FFFFFF" class="text_content">Form Name <span class="star">*</span></td>
      <td bgcolor="#FFFFFF" class="text_content">
      <select name="vendor_access" id="vendor_access" class="input_txt" >
        <option value="">Select Form</option>
        <option value="Safe Rental" <?php if($admin_access=="Safe Rental"){echo "selected='selected'";} ?>>Safe Rental</option>
        <option value="Stadfitting" <?php if($admin_access=="Stadfitting"){echo "selected='selected'";} ?>>Stadfitting</option> 
        <option value="Stall Layout" <?php if($admin_access=="Stall Layout"){echo "selected='selected'";} ?>>Stall Layout</option> 
        <option value="Floral" <?php if($admin_access=="Floral"){echo "selected='selected'";} ?>>Floral / Plant Form</option> 
        <option value="Electronic Surveillance" <?php if($admin_access=="Electronic Surveillance"){echo "selected='selected'";} ?>>Electronic Surveillance</option>
        <option value="Badges" <?php if($admin_access=="Badges"){echo "selected='selected'";} ?>>Badges/Carpasss</option> 
        
       </select>
      </td>
    </tr>

</tbody>  

<tbody <?php if($role=='Super Admin' || $role=='' ){?> style="display:none" <?php }?> id="admin_access_div">
    <tr>
      <td valign="top" bgcolor="#FFFFFF" class="text_content">Admin Access <span class="star">*</span></td>
      <td bgcolor="#FFFFFF" class="text_content">
      <select name="admin_access" id="admin_access" class="input_txt" >
        <option value="">Select Access</option>
        <option value="Region Wise" <?php if($admin_access=="Region Wise"){echo "selected='selected'";} ?>>Region Wise</option>
        <option value="Division Wise" <?php if($admin_access=="Division Wise"){echo "selected='selected'";} ?>>Division Wise</option> 
       </select>
      </td>
    </tr>
</tbody>  

<?php //if( $role!='Vendor' ){?> 
<tbody >
    <tr <?php if($_REQUEST['action']=='edit'){if($admin_access=='Division Wise'){?> style="display:none" <?php }}else{if($admin_access=='Region Wise' || $admin_access==''){?> style="display:none" <?php }}?> id="admin_resion_div" >
      <td class="content_txt">Region <span class="star">*</span></td>
      <td> 
        <select name="region_name" id="region_name" class="input_txt" >
          <option value="">Select Region</option>
          <option value="EX-MUM" <?php if($region_name=="EX-MUM"){echo "selected='selected'";} ?>>MUMBAI</option>
          <option value="RO-CHE" <?php if($region_name=="RO-CHE"){echo "selected='selected'";} ?>>CHENNAI</option>
          <option value="RO-DEL" <?php if($region_name=="RO-DEL"){echo "selected='selected'";} ?>>DELHI</option>
          <option value="RO-JAI" <?php if($region_name=="RO-JAI"){echo "selected='selected'";} ?>>JAIPUR</option>
          <option value="RO-KOL" <?php if($region_name=="RO-KOL"){echo "selected='selected'";} ?>>KOLKATA</option>
          <option value="RO-SRT" <?php if($region_name=="RO-SRT"){echo "selected='selected'";} ?>>SURAT</option>
        </select>
      </td>
    </tr>
</tbody>

<tbody>
   
    <tr <?php if($_REQUEST['action']=='edit'){if($admin_access=='Region Wise'){?> style="display:none" <?php }}else{if($admin_access=='Division Wise' || $admin_access==''){?> style="display:none" <?php }}?>  id="admin_division_div">
      <td valign="top" bgcolor="#FFFFFF" class="text_content">Division <span class="star">*</span></td>
      <td bgcolor="#FFFFFF" class="text_content">
      <select name="division_name" id="division_name" class="input_txt">
      <option value="">Select Division</option>
			<?php 
			$sql="SELECT distinct(Exhibitor_DivisionNo) FROM manual_signature.iijs_exhibitor order by Exhibitor_DivisionNo asc";
			$query=$conn ->query($sql);
			while($result=$query->fetch_assoc()){
            ?>
            <option value="<?php echo $result['Exhibitor_DivisionNo'];?>" <?php if($result['Exhibitor_DivisionNo']==$division_name){?> selected="selected" <?php }?>><?php echo $result['Exhibitor_DivisionNo'];?></option>
            <?php }?> 
		<!--<option value="1A" <?php if($division_name=="1A"){echo "selected='selected'";} ?>>1A</option>
		<option value="2A" <?php if($division_name=="2A"){echo "selected='selected'";} ?>>2A</option>
		<option value="2B" <?php if($division_name=="2B"){echo "selected='selected'";} ?>>2B</option>
		<option value="3A" <?php if($division_name=="3A"){echo "selected='selected'";} ?>>3A</option>
		<option value="3B" <?php if($division_name=="3B"){echo "selected='selected'";} ?>>3B</option>
		<option value="3C" <?php if($division_name=="3C"){echo "selected='selected'";} ?>>3C</option>
		<option value="4A" <?php if($division_name=="4A"){echo "selected='selected'";} ?>>4A</option> 
		<option value="4B" <?php if($division_name=="4B"){echo "selected='selected'";} ?>>4B</option> 
		<option value="4C" <?php if($division_name=="4C"){echo "selected='selected'";} ?>>4C</option> 
		<option value="4D" <?php if($division_name=="4D"){echo "selected='selected'";} ?>>4D</option> 
		<option value="5A" <?php if($division_name=="5A"){echo "selected='selected'";} ?>>5A</option>
		<option value="5B" <?php if($division_name=="5B"){echo "selected='selected'";} ?>>5B</option>
		<option value="5C" <?php if($division_name=="5C"){echo "selected='selected'";} ?>>5C</option>
		<option value="5D" <?php if($division_name=="5D"){echo "selected='selected'";} ?>>5D</option>-->
		
	  
      <!--<option value="CLUB" <?php if($division_name=="CLUB"){echo "selected='selected'";} ?>>CLUB</option>
      <option value="GJ1A" <?php if($division_name=="GJ1A"){echo "selected='selected'";} ?>>GJ1A</option>
      <option value="GJ1B" <?php if($division_name=="GJ1B"){echo "selected='selected'";} ?>>GJ1B</option>
      <option value="GJ2A" <?php if($division_name=="GJ2A"){echo "selected='selected'";} ?>>GJ2A</option>
      <option value="GJ2B" <?php if($division_name=="GJ2B"){echo "selected='selected'";} ?>>GJ2B</option>
	  <option value="LS" <?php if($division_name=="LS"){echo "selected='selected'";} ?>>LS</option>
      <option value="LSA" <?php if($division_name=="LSA"){echo "selected='selected'";} ?>>LSA</option> 
      <option value="LSB" <?php if($division_name=="LSB"){echo "selected='selected'";} ?>>LSB</option> 
      <option value="ST1A" <?php if($division_name=="ST1A"){echo "selected='selected'";} ?>>ST1A</option> 
      <option value="ST1B" <?php if($division_name=="ST1B"){echo "selected='selected'";} ?>>ST1B</option> 
      <option value="ST2A" <?php if($division_name=="ST2A"){echo "selected='selected'";} ?>>ST2A</option> 
      <option value="ST2B" <?php if($division_name=="ST2B"){echo "selected='selected'";} ?>>ST2B</option> -->
      </select>
	  </td>
    </tr>
</tbody>
<?php //} ?>
<?php } ?>
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
</div>
</div>
<div id="footer_wrap"><?php include("include/footer.php");?></div>
</body>
</html>
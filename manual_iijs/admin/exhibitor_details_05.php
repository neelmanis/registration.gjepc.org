<?php session_start(); ?>
<?php include('../db.inc.php');?>
<?php include('../functions.php');?>

<?php
$Exhibitor_ID=$_REQUEST['Exhibitor_ID'];

$exhibitor_code=$_REQUEST['Exhibitor_Code'];
 $exhibitor_data="select * from iijs_exhibitor where Exhibitor_Code='$exhibitor_code'";
$result=mysql_query($exhibitor_data);
$fetch_data=mysql_fetch_array($result);

 $Exhibitor_Name=$fetch_data['Exhibitor_Name'];
 $Exhibitor_Contact_Person=$fetch_data['Exhibitor_Contact_Person'];
 $Exhibitor_Designation=$fetch_data['Exhibitor_Designation'];
$Exhibitor_Mobile=$fetch_data['Exhibitor_Mobile'];
$Exhibitor_Phone=$fetch_data['Exhibitor_Phone'];
$Exhibitor_Fax=$fetch_data['Exhibitor_Fax'];

$Exhibitor_StallNo[]="";

for($i=0;$i<8;$i++){
	if($fetch_data["Exhibitor_StallNo".($i+1)]!="")
		$Exhibitor_StallNo[$i]=$fetch_data["Exhibitor_StallNo".($i+1)];
}

$stall_no=implode(", ",$Exhibitor_StallNo);

$Exhibitor_HallNo=$fetch_data['Exhibitor_HallNo'];
$Exhibitor_Region=$fetch_data['Exhibitor_Region'];
$Exhibitor_Section=$fetch_data['Exhibitor_Section'];
$Exhibitor_Category=$fetch_data['Exhibitor_StallType'];
$Exhibitor_Scheme==$fetch_data['Exhibitor_Scheme'];
$Exhibitor_Premium==$fetch_data['Exhibitor_Premium'];
$Exhibitor_Area=$fetch_data['Exhibitor_Area'];
$Exhibitor_DivisionNo=$fetch_data['Exhibitor_DivisionNo'];


 $Exhibitor_Address1=$fetch_data['Exhibitor_Address1'];
 $Exhibitor_Address2=$fetch_data['Exhibitor_Address2'];
 $Exhibitor_Address3=$fetch_data['Exhibitor_Address3'];

 $Exhibitor_Email=$fetch_data['Exhibitor_Email'];
 $Exhibitor_Email1=$fetch_data['Exhibitor_Email1'];
 $Exhibitor_Pincode=$fetch_data['Exhibitor_Pincode'];
 $Exhibitor_State=$fetch_data['Exhibitor_State'];
 $Exhibitor_Country_ID=$fetch_data['Exhibitor_Country_ID'];
$Exhibitor_IsActive=$fetch_data['Exhibitor_IsActive'];

$Exhibitor_City=$fetch_data['Exhibitor_City'];
$Exhibitor_Website=$fetch_data['Exhibitor_Website'];
$comments = $fetch_data['comments'];
$Exhibitor_Scheme=$fetch_data['Exhibitor_Scheme'];
$Exhibitor_Premium=$fetch_data['Exhibitor_Premium'];

if(isset($_POST['Save']))
{
$Exhibitor_Name=$_POST['Exhibitor_Name'];
$Exhibitor_Contact_Person=$_POST['Exhibitor_Contact_Person'];
$Exhibitor_Designation=$_POST['Exhibitor_Designation'];
$Exhibitor_Email=$_POST['Exhibitor_Email'];
$Exhibitor_HallNo=$_POST['Exhibitor_HallNo'];
$Exhibitor_DivisionNo=$_POST['Exhibitor_DivisionNo'];
$Exhibitor_StallNo1=$_POST['Exhibitor_StallNo1'];
$Exhibitor_StallNo2=$_POST['Exhibitor_StallNo2'];
$Exhibitor_StallNo3=$_POST['Exhibitor_StallNo3'];
$Exhibitor_StallNo4=$_POST['Exhibitor_StallNo4'];
$Exhibitor_StallNo5=$_POST['Exhibitor_StallNo5'];
$Exhibitor_StallNo6=$_POST['Exhibitor_StallNo6'];
$Exhibitor_StallNo7=$_POST['Exhibitor_StallNo7'];
$Exhibitor_StallNo8=$_POST['Exhibitor_StallNo8'];

 $Exhibitor_IsActive=$_POST['Exhibitor_IsActive'];

$Exhibitor_Section=$_POST['Exhibitor_Section'];
$Exhibitor_Category=$_POST['Exhibitor_Category'];
$Exhibitor_Scheme=$_POST['Exhibitor_Scheme'];
$Exhibitor_Premium=$_POST['Exhibitor_Premium'];
$Exhibitor_Area=$_POST['Exhibitor_Area'];
$Exhibitor_Region=$_POST['Exhibitor_Region'];
$Exhibitor_Country_ID=$_POST['Exhibitor_Country_ID'];
$comments = mysql_real_escape_string($_POST['comments']);
$Exhibitor_ID=$_POST['Exhibitor_ID'];

mysql_query("update iijs_exhibitor set Exhibitor_Name='$Exhibitor_Name',Exhibitor_Contact_Person='$Exhibitor_Contact_Person',Exhibitor_Designation='$Exhibitor_Designation',Exhibitor_Email='$Exhibitor_Email',Exhibitor_Country_ID='$Exhibitor_Country_ID',Exhibitor_HallNo='$Exhibitor_HallNo',Exhibitor_DivisionNo='$Exhibitor_DivisionNo',Exhibitor_StallNo1='$Exhibitor_StallNo1',Exhibitor_StallNo2='$Exhibitor_StallNo2',Exhibitor_StallNo3='$Exhibitor_StallNo3',Exhibitor_StallNo4='$Exhibitor_StallNo4',Exhibitor_StallNo5='$Exhibitor_StallNo5',Exhibitor_StallNo6='$Exhibitor_StallNo6',Exhibitor_StallNo7='$Exhibitor_StallNo7',Exhibitor_StallNo8='$Exhibitor_StallNo8',Exhibitor_Section='$Exhibitor_Section',Exhibitor_StallType='$Exhibitor_Category',Exhibitor_IsActive=$Exhibitor_IsActive,comments='$comments', Exhibitor_Scheme='$Exhibitor_Scheme',Exhibitor_Premium='$Exhibitor_Premium',Exhibitor_Area='$Exhibitor_Area',Exhibitor_Region='$Exhibitor_Region' where Exhibitor_ID='$Exhibitor_ID'");

	    echo '<script type="text/javascript">'; 
		echo 'alert("You have successfully update  your application.");'; 
		echo 'window.location.href = "manage_exhibitor.php?action=view"';
		echo '</script>';	
		exit;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Exhibitor Management</title>

<link rel="stylesheet" type="text/css" href="css/style.css" />
<!-- form css -->
<link rel="stylesheet" type="text/css" href="css/adminForm.css">
<!--navigation-->
<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>      
<link rel="stylesheet" type="text/css" href="css/ddsmoothmenu.css" />
<script type="text/javascript" src="js/ddsmoothmenu.js"></script>

<link href="css/jquery.datepick.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.datepick.js"></script>


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
	<div class="breadcome"><a href="search_application.php">Home</a> >Exhibitor Management</div>
</div>

<div id="main">
	<div class="content">
    	<div class="content_head">Exhibitor Management</div>
 
<div class="content_details22">
<div id="formWrapper">
<table border="0" cellspacing="0" cellpadding="0" class="formManual">
  <tr>
    <td class="bold">Exhibitor Name</td>
    <td>:</td>
    <td><?php echo $Exhibitor_Name;?></td>
    <td width="50">&nbsp;</td>
    <td class="bold">Contact Person</td>
    <td>:</td>
    <td><?php echo $Exhibitor_Contact_Person;?></td>
  </tr>
  <tr>
    <td class="bold">Stall No(s)</td>
    <td>:</td>
    <td><?php echo $stall_no;?></td>
    <td>&nbsp;</td>
    <td class="bold">Hall No</td>
    <td>:</td>
    <td><?php echo $Exhibitor_HallNo;?></td>
  </tr>
  <tr>
    <td class="bold">Zone</td>
    <td>:</td>
    <td><?php echo $Exhibitor_DivisionNo; ?></td>
    <td>&nbsp;</td>
    <td class="bold">Region</td>
    <td>:</td>
    <td><?php echo $Exhibitor_Region;?></td>
  </tr>
  <tr>
    <td class="bold">Section</td>
    <td>:</td>
    <td><?php echo $Exhibitor_Section; ?></td>
    <td>&nbsp;</td>
    <td class="bold">Area</td>
    <td>:</td>
    <td><?php echo $Exhibitor_Area; ?></td>
  </tr>
  <tr>
    <td class="bold">Scheme</td>
    <td>:</td>
    <td><?php echo $Exhibitor_Scheme; ?></td>
    <td>&nbsp;</td>
    <td class="bold">Premium</td>
    <td>:</td>
    <td><?php echo $Exhibitor_Premium; ?></td>
  </tr>
  
</table>


<form name="catalogue_entry" id="form1" action="" enctype="multipart/form-data" method="post" onsubmit="return validation()">
<input type="hidden" name="action" value="ADD" />

<table border="0" cellspacing="0" cellpadding="0" class="formManual">
  <tr>
    <td class="bold">Exhibitor Name</td>
    <td>:</td>
    <td><input type="text" name="Exhibitor_Name" id="Exhibitor_Name" class="textField" value="<?php echo $Exhibitor_Name;?>"/>
      <input type="hidden" name="Exhibitor_ID" id="Exhibitor_ID" class="textField" value="<?php echo $Exhibitor_ID;?>"/>
      <br />
      <span id="name_error" class="error_msg"></span>
   </td>
    <td>&nbsp;</td>
    <td class="bold">Contact Person</td>
    <td>:</td>
    <td><input type="text" name="Exhibitor_Contact_Person" id="Exhibitor_Contact_Person" class="textField" value="<?php echo $Exhibitor_Contact_Person;?>" /></td>
  </tr>
  
  <tr>
    <td class="bold">Designation</td>
    <td>:</td>
    <td>
    <input type="text" name="Exhibitor_Designation" id="Exhibitor_Designation" class="textField" value="<?php echo $Exhibitor_Designation;?>" />
    </td>
    <td>&nbsp;</td>
    <td class="bold">E-Mail</td>
    <td>:</td>
    <td><input type="text" name="Exhibitor_Email" id="Exhibitor_Email" class="textField" value="<?php echo $Exhibitor_Email;?>" /></td>
  </tr>
  
  <tr>
    <td class="bold">Hall No</td>
    <td>:</td>
    <td><input type="text" name="Exhibitor_HallNo" id="Exhibitor_HallNo" class="textField" value="<?php echo $Exhibitor_HallNo;?>" /></td>
    <td>&nbsp;</td>
    <td class="bold">Division</td>
    <td>:</td>
    <td><input type="text" name="Exhibitor_DivisionNo" id="Exhibitor_DivisionNo" class="textField" value="<?php echo $Exhibitor_DivisionNo;?>" /></td>
  </tr>
  <tr>
    <td class="bold">StallNo 1</td>
    <td>:</td>
    <td><input type="text" name="Exhibitor_StallNo1" id="Exhibitor_StallNo1" class="textField" value="<?php echo $Exhibitor_StallNo[0];?>" /></td>
    <td>&nbsp;</td>
    <td class="bold">StallNo 2</td>
    <td>:</td>
    <td><input type="text" name="Exhibitor_StallNo2" id="Exhibitor_StallNo2" class="textField" value="<?php echo $Exhibitor_StallNo[1];?>" /></td>
  </tr>
  <tr>
    <td class="bold">StallNo 3</td>
    <td>:</td>
    <td><input type="text" name="Exhibitor_StallNo3" id="Exhibitor_StallNo3" class="textField" value="<?php echo $Exhibitor_StallNo[2];?>" /></td>
    <td>&nbsp;</td>
    <td class="bold">StallNo 4</td>
    <td>:</td>
    <td><input type="text" name="Exhibitor_StallNo4" id="Exhibitor_StallNo4" class="textField" value="<?php echo $Exhibitor_StallNo[3];?>" /></td>
  </tr>
  <tr>
    <td class="bold">StallNo 5</td>
    <td>:</td>
    <td><input type="text" name="Exhibitor_StallNo5" id="Exhibitor_StallNo5" class="textField" value="<?php echo $Exhibitor_StallNo[4];?>" /></td>
    <td>&nbsp;</td>
    <td class="bold">StallNo 6</td>
    <td>:</td>
    <td><input type="text" name="Exhibitor_StallNo6" id="Exhibitor_StallNo6" class="textField" value="<?php echo $Exhibitor_StallNo[5];?>" /></td>
  </tr>
  <tr>
    <td class="bold">StallNo 7</td>
    <td>:</td>
    <td><input type="text" name="Exhibitor_StallNo7" id="Exhibitor_StallNo7" class="textField" value="<?php echo $Exhibitor_StallNo[6];?>" /></td>
    <td>&nbsp;</td>
    <td class="bold">StallNo 8</td>
    <td>:</td>
    <td><input type="text" name="Exhibitor_StallNo8" id="Exhibitor_StallNo8" class="textField" value="<?php echo $Exhibitor_StallNo[7];?>" /></td>
  </tr>
  <tr>
    <td class="bold">Section<sup> </sup></td>
    <td>:</td>
    <td>
    <select name="Exhibitor_Section" id="Exhibitor_Section" >
    <option value="">-----Select Section----</option>
            <?php 
			
			$sql="SELECT * FROM signature_section_master";
            $query=mysql_query($sql);
            while($result=mysql_fetch_array($query)){
            ?>
            <option value="<?php echo $result['section'];?>" <?php if($result['section']==$Exhibitor_Section){?> selected="selected" <?php }?> ><?php echo $result['section_desc'];?></option>
            <?php }?>
            <option value="International Jewellery" <?php if($Exhibitor_Section=="International Jewellery"){?> selected="selected" <?php }?>>International Jewellery</option>
            <option value="International Loose" <?php if($Exhibitor_Section=="International Loose"){?> selected="selected" <?php }?>>International Loose</option>
    </select>
    </td>
    <td>&nbsp;</td>
    <td class="bold">Category</td>
    <td>:</td>
    <td>
    <select name="Exhibitor_Category" id="Exhibitor_Category" >
    <option selected="selected" value="">-----Select Category----</option>
            <?php 
			$sql="SELECT * FROM signature_category_master";
            $query=mysql_query($sql);
            while($result=mysql_fetch_array($query)){
            ?>
            <option value="<?php echo $result['category'];?>" <?php if($result['category']==$Exhibitor_Category){?> selected="selected" <?php }?> ><?php echo $result['category_desc'];?></option>
            <?php }?>
    </select>
    </td>
   </tr>
  <tr>
    <td class="bold">Scheme</td>
    <td>:</td>
    <td>
    <select name="Exhibitor_Scheme" id="Exhibitor_Scheme" >
   <option selected="selected" value="">---Select Scheme---</option>
    <option value="Raw" <?php if($Exhibitor_Scheme=="Raw"){?> selected="selected" <?php }?> >Raw Space</option> 
    <option value="Shell" <?php if($Exhibitor_Scheme=="Shell"){?> selected="selected" <?php }?> >Shell Scheme</option> 
    
    </select>
    </td>
    <td>&nbsp;</td>
    <td class="bold">Premium</td>
    <td>:</td>
    <td>
      <select name="Exhibitor_Premium" id="Exhibitor_Premium" >
        <option selected="selected" value="">-----Select Premium Type----</option>
			<?php 
				$sql="SELECT * FROM signature_premium_master order by premium_id asc";
				$query=mysql_query($sql);
				while($result=mysql_fetch_array($query)){
            ?>
            <option value="<?php echo $result['premium'];?>" <?php if($result['premium']==$Exhibitor_Premium){?> selected="selected" <?php }?>><?php echo $result['premium_desc'];?></option>
            <?php }?> 
    </select>
    </td>
  </tr>
  <tr>
    <td class="bold">Area</td>
    <td>:</td>
    <td>
      <select name="Exhibitor_Area" id="Exhibitor_Area" >
        <option value="">---Select Area---</option>
         <?php 
			/*if($selected_area==9){$sql="SELECT * FROM iijs_area_master where area=9 or area=18 or area=25";}
			else if($selected_area==18){$sql="SELECT * FROM iijs_area_master where area=18 or area=25 or area=27";}
			else if($selected_area==25){$sql="SELECT * FROM iijs_area_master where area=25 or area=25 or area=36";}
			else if($selected_area==27){$sql="SELECT * FROM iijs_area_master where area=27 or area=36 or area=45";}
			else if($selected_area==36){$sql="SELECT * FROM iijs_area_master where area=36 or area=45 or area=54";}
			else if($selected_area==45){$sql="SELECT * FROM iijs_area_master where area=45 or area=54 or area=72";}
			else if($selected_area==54){$sql="SELECT * FROM iijs_area_master where area=54 or area=72 or area=144" ;}
			else if($selected_area>54){$sql="SELECT * FROM iijs_area_master order by area_id desc limit 0,2" ;}*/
			$sql="SELECT * FROM signature_area_master order by area_id asc";
				$query=mysql_query($sql);
				while($result=mysql_fetch_array($query)){
            ?>
            <option value="<?php echo $result['area'];?>" <?php if($result['area']==$Exhibitor_Area){?> selected="selected" <?php }?>><?php echo $result['area'];?></option>
            <?php }?>
    </select>
    </td>
    <td>&nbsp;</td>
    <td class="bold">Region</td>
    <td>:</td>
    <td>
    <select name="Exhibitor_Region" id="Exhibitor_Region" >
        <option selected="selected" value="">---Select Region---</option>
        <option value="EX-MUM" <?php if($Exhibitor_Region=="EX-MUM"){?> selected="selected" <?php }?> >GJEPC- E.X.-MUMBAI</option>
        <option value="RO-JAI" <?php if($Exhibitor_Region=="RO-JAI"){?> selected="selected" <?php }?> >GJEPC- R.O.-JAIPUR</option> 
        <option value="RO-KOL" <?php if($Exhibitor_Region=="RO-KOL"){?> selected="selected" <?php }?> >GJEPC- R.O.-KOLKATTA</option> 
        <option value="RO-CHE" <?php if($Exhibitor_Region=="RO-CHE"){?> selected="selected" <?php }?> >GJEPC- R.O.-CHENNAI</option> 
        <option value="RO-DEL" <?php if($Exhibitor_Region=="RO-DEL"){?> selected="selected" <?php }?> >GJEPC- R.O.-DELHI</option> 
         <option value="RO-SRT" <?php if($Exhibitor_Region=="RO-SRT"){?> selected="selected" <?php }?> >GJEPC- R.O.-SURAT</option> 
    </select>
    </td>
  </tr>
  
  <tr>
    <td class="bold">Country</td>
    <td>:</td>
    <td>
      <select name="Exhibitor_Country_ID" id="Exhibitor_Country_ID" >
        <option selected="selected" value="">---Select Country---</option>
        <?php 
		$sql="select * from iijs_country_master";
		$query=mysql_query($sql);
		while($result=mysql_fetch_array($query)){
		?>
        <option value="<?php if($Exhibitor_Country_ID==64){echo $result['Country_ID'];} else {echo $result['Country_Name'];}?>" <?php if($result['Country_ID']==$Exhibitor_Country_ID){?> selected="selected" <?php }?> ><?php echo $result['Country_Name'];?></option>
        <?php }?>
    </select>
    </td>
    <td>&nbsp;</td>
     <td class="bold">Exhibitor Activation</td>
    <td>:</td>
    <td>
       <input type="radio" name="Exhibitor_IsActive" id="Exhibitor_IsActive" value="1" <?php if($Exhibitor_IsActive==1){ echo "checked='checked'"; } ?>/>Yes
       
       <input type="radio" name="Exhibitor_IsActive" id="Exhibitor_IsActive" value="0" <?php if($Exhibitor_IsActive==0){ echo "checked='checked'"; } ?>/>No
    </td>
    <td>&nbsp;</td>
  </tr>
  
  
  <tr>
    <td class="bold">Comments</td>
    <td>:</td>
    <td colspan="5">
    <input type="text" name="comments" class="textField" value="<?php echo stripslashes($comments);?>">
    <!--<textarea name = "comments" rows="8" cols="30"><?php echo stripslashes($comments); ?></textarea>-->
    </td>
  </tr>
  
  
</table>

<div class="clear"></div>

    <div align="center">
    <input type="hidden" name="Exhibitor_ID" id="Exhibitor_ID" value="<?php echo $_REQUEST['Exhibitor_ID'];?>"/>
        <input type="submit" name="Save" id="Save" value="Submit" class="maroon_btn" />
    </div>	
</form>
		</div>
		</div>
	</div>
</div>

<div id="footer_wrap"><?php include("include/footer.php");?></div>


</body>
</html>

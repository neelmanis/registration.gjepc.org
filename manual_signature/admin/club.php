<?php session_start(); ?>
<?php include('../db.inc.php');?>
<?php include('../functions.php');?>

<?php
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
$Exhibitor_City=$fetch_data['Exhibitor_City'];
$Exhibitor_Website=$fetch_data['Exhibitor_Website'];

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Elite Club Form</title>

<link rel="stylesheet" type="text/css" href="css/style.css" />
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
<script>
$('.editAdd').live('click',function(){
	clasvar = $(this).attr('class');
	x = clasvar.split(' ');
	id = x[1];
	exhibitor_code = x[2];
		$.ajax({ 
					type: 'POST',
					url: 'personalInfo_ajax.php',
					data: "actiontype=editAdd&id="+id+"&exhibitor_code="+exhibitor_code,
					dataType:'html',
					beforeSend: function(){
						
							},
					success: function(data){
						 
							$('#update_comm').html(data);
							 //$("#CommunicationDetails").html(data);  
							}
		});
});
</script>
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
<style>
.Catalog_Brief { width: 100%; height: 110px; }
</style>
</head>

<body>
<div id="header_wrapper"><?php include("include/header.php");?></div>

<div id="nav_wrapper">
	<div class="nav"><?php include("include/menu.php");?></div>
</div>

<div class="clear"></div>

<div class="breadcome_wrap">
	<div class="breadcome"><a href="manage_elite_club.php?action=view">Home</a> > Elite Club</div>
</div>

<div id="main">
	<div class="content">
    	<div class="content_head">Compulsory Catalogue Entry Form</div>
 
<div class="content_details22">
<div id="formWrapper">
<h2>Elite Club Information</h2>
<?php 
$catalog_data1="select * from iijs_personalInfo where Exhibitor_Code='$exhibitor_code'";
$result_catalog1=mysql_query($catalog_data1);
$result_count = mysql_num_rows($result_catalog1);

$name_of_retail_showroom=$fetch_catalog['name_of_retail_showroom'];
$company_gst=$fetch_catalog['company_gst'];
if($result_count>0){ ?>

<table border="0" cellspacing="0" cellpadding="0" class="formManual">
<th>Showroom</th>
<th>Action</th>
<?php while($fetch_row = mysql_fetch_array($result_catalog1)){ ?>
<tr>
<td><?php echo $fetch_row['name_of_retail_showroom'];?></td>
<td></td>
<td class="editAdd <?php echo $fetch_row['id'];?> <?php echo $exhibitor_code;?>">VIEW</td>
</tr>
<?php } ?>
</table>
<?php } ?>
</div>

<div id="update_comm">
<div class="clear"></div>
<div class="borderBottom"></div>
<div class="clear"></div>
<table border="0" cellspacing="0" cellpadding="0" class="formManual">
  <tr>
    <td>Name of Retail Showroom <span class="red">*</span> </td>
    <td>:</td>
    <td><input type="text" class="textField" name="name_of_retail_showroom" id="name_of_retail_showroom" value="<?php echo $name_of_retail_showroom?>" autocomplete="off"/> <?php if(isset($showroomError)){ echo '<span style="color: red;" />'.$showroomError.'</span>';} ?></td>
  </tr>
  <tr>
    <td>Company GST No <span class="red">*</span> </td>
    <td>:</td>
    <td><input type="text" class="textField" name="company_gst" id="company_gst" maxlength="15" minlength="15" value="<?php echo $company_gst?>" autocomplete="off"/> <?php if(isset($gstNameError) ){ echo '<span style="color: red;" />'.$gstNameError.'</span>';} ?></td>
  </tr>
</table>

<table border="0" cellspacing="0" cellpadding="0" class="formManual">
  <tr>
    <td>Contact Person 1</td>
    <td>:</td>
    <td><input type="text" name="contact_person[]"  class="textField" value="<?php echo $brand_name1;?>"/>
	<?php if(isset($personError) ){ echo '<span style="color: red;" />'.$personError.'</span>';} ?></td>
    <td>Mobile No. 1</td>
    <td>:</td>
    <td><input type="text" name="mobile_no[]"  class="textField" value="<?php echo $mobile1; ?>" maxlength="10" minlength="10"/>
	<?php if(isset($mobileError) ){ echo '<span style="color: red;" />'.$mobileError.'</span>';} ?></td>
	<td>Designation 1</td>
    <td>:</td>
    <td><input type="text" name="designation[]"  class="textField" value="<?php echo $designation1; ?>"/>
	<?php if(isset($designationError) ){ echo '<span style="color: red;" />'.$designationError.'</span>';} ?></td>
	<td>Email 1</td>
    <td>:</td>
    <td><input type="email" name="email[]"  class="textField" value="<?php echo $email1; ?>"/>
	<?php if(isset($emailError) ){ echo '<span style="color: red;" />'.$emailError.'</span>';} ?></td>
  </tr>
  <tr>
    <td width="146">Contact Person 2</td>
    <td width="36">:</td>
    <td width="253"><input type="text" name="contact_person[]"  class="textField" value="<?php echo $brand_name2;?>" autocomplete="off"/></td>
    <td width="163">Mobile No. 2</td>
    <td width="30">:</td>
    <td width="262"><input type="text" name="mobile_no[]"  class="textField" value="<?php echo $mobile2; ?>" maxlength="10" minlength="10"/></td>
	<td width="163">Designation 2</td>
    <td width="30">:</td>
    <td width="262"><input type="text" name="designation[]" class="textField" value="<?php echo $designation2; ?>"/></td>
	<td width="163">Email 2</td>
    <td width="30">:</td>
    <td width="262"><input type="email" name="email[]" class="textField" value="<?php echo $email2;?>"/></td>
  </tr>
  <tr>
    <td width="146">Contact Person 3</td>
    <td width="36">:</td>
    <td width="253"><input type="text" name="contact_person[]"  class="textField" value="<?php echo $brand_name3;?>"/></td>
    <td width="163">Mobile No. 3</td>
    <td width="30">:</td>
    <td width="262"><input type="text" name="mobile_no[]"  class="textField" value="<?php echo $mobile3; ?>"/></td>
	<td width="163">Designation 3</td>
    <td width="30">:</td>
    <td width="262"><input type="text" name="designation[]"  class="textField" value="<?php echo $designation3; ?>"/></td>
	<td width="163">Email 3</td>
    <td width="30">:</td>
    <td width="262"><input type="text" name="email[]"  class="textField" value="<?php echo $email3; ?>"/></td>
  </tr>
  <tr>
    <td width="146">Contact Person 4</td>
    <td width="36">:</td>
    <td width="253"><input type="text" name="contact_person[]" class="textField" value="<?php echo $brand_name4;?>"/></td>
    <td width="163">Mobile No. 4</td>
    <td width="30">:</td>
    <td width="262"><input type="text" name="mobile_no[]"  class="textField" value="<?php echo $mobile4; ?>"/></td>
	<td width="163">Designation 4</td>
    <td width="30">:</td>
    <td width="262"><input type="text" name="designation[]"  class="textField" value="<?php echo $designation4; ?>"/></td>
	<td width="163">Email 4</td>
    <td width="30">:</td>
    <td width="262"><input type="text" name="email[]"  class="textField" value="<?php echo $email4; ?>"/></td>
  </tr>
  <tr>
    <td width="146">Contact Person 5</td>
    <td width="36">:</td>
    <td width="253"><input type="text" name="contact_person[]"  class="textField" value="<?php echo $brand_name5;?>"/></td>
    <td width="163">Mobile No. 5</td>
    <td width="30">:</td>
    <td width="262"><input type="text" name="mobile_no[]"  class="textField" value="<?php echo $mobile5; ?>"/></td>
	<td width="163">Designation 5</td>
    <td width="30">:</td>
    <td width="262"><input type="text" name="designation[]"  class="textField" value="<?php echo $designation5; ?>"/></td>
	<td width="163">Email 5</td>
    <td width="30">:</td>
    <td width="262"><input type="text" name="email[]"  class="textField" value="<?php echo $email5; ?>"/></td>
  </tr>
  
</table>
<table class="rwd-table">  					
                    <tbody><tr>
    					<th width="50">Sr No.</th>
    					<th class="smallTh">Showroom branch in which city</th>
    					<th>Showroom Address</th>
    					<th class="smallTh">Area of Showroom in (Sqft)</th>
                        <th class="smallTh">Year of Establishment </th>
					</tr>  					
                    <tr>
    					<td data-th="Sr No.">1</td>
    					<td data-th="Showroom branch in which city"><input type="text" name="showroom_city[]" value="<?php echo $city1;?>"></td>
    					<td data-th="Showroom Address"><input type="text" name="showroom_address[]" value="<?php echo $address1;?>"></td>
    					<td data-th="Area of Showroom in (Sqft)"><input type="text" name="showroom_area[]" value="<?php echo $area1;?>"></td>
                        <td data-th="Year of Establishment"><input type="text" name="year_of_establishment[]" maxlength="4" minlength="4" value="<?php echo $year1;?>"></td>
  					</tr>                    
                    <tr>
    					<td data-th="Sr No.">2</td>
    					<td data-th="Showroom branch in which city"><input type="text" name="showroom_city[]" value="<?php echo $city2;?>"></td>
    					<td data-th="Showroom Address"><input type="text" name="showroom_address[]" value="<?php echo $address2;?>"></td>
    					<td data-th="Area of Showroom in (Sqft)"><input type="text" name="showroom_area[]" value="<?php echo $area2;?>"></td>
                        <td data-th="Year of Establishment"><input type="text" name="year_of_establishment[]" maxlength="4" minlength="4" value="<?php echo $year2;?>"></td>
  					</tr>                    
                    <tr>
    					<td data-th="Sr No.">3</td>
    					<td data-th="Showroom branch in which city"><input type="text" name="showroom_city[]" value="<?php echo $city3;?>"></td>
    					<td data-th="Showroom Address"><input type="text" name="showroom_address[]" value="<?php echo $address3;?>"></td>
    					<td data-th="Area of Showroom in (Sqft)"><input type="text" name="showroom_area[]" value="<?php echo $area3;?>"></td>
                        <td data-th="Year of Establishment"><input type="text" name="year_of_establishment[]" maxlength="4" minlength="4" value="<?php echo $year3;?>"></td>
  					</tr>
                    <tr>
    					<td data-th="Sr No.">4</td>
    					<td data-th="Showroom branch in which city"><input type="text" name="showroom_city[]" value="<?php echo $city4;?>"></td>
    					<td data-th="Showroom Address"><input type="text" name="showroom_address[]" value="<?php echo $address4;?>"></td>
    					<td data-th="Area of Showroom in (Sqft)"><input type="text" name="showroom_area[]" value="<?php echo $area4;?>"></td>
                        <td data-th="Year of Establishment"><input type="text" name="year_of_establishment[]" maxlength="4" minlength="4" value="<?php echo $year4;?>"></td>
  					</tr>
                    <tr>
    					<td data-th="Sr No.">5</td>
    					<td data-th="Showroom branch in which city"><input type="text" name="showroom_city[]" value="<?php echo $city5;?>"></td>
    					<td data-th="Showroom Address"><input type="text" name="showroom_address[]" value="<?php echo $address5;?>"></td>
    					<td data-th="Area of Showroom in (Sqft)"><input type="text" name="showroom_area[]" value="<?php echo $area5;?>"></td>
                        <td data-th="Year of Establishment"><input type="text" name="year_of_establishment[]" maxlength="4" minlength="4" value="<?php echo $year5;?>"></td>
  					</tr>
					</tbody>
</table>


</div>
</div>
</div>
<div id="footer_wrap"><?php include("include/footer.php");?></div>
</body>
</html>
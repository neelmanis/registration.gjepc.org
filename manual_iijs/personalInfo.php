<?php 
include('header_include.php');
if(!isset($_SESSION['EXHIBITOR_CODE'])){ header("location:index.php");	exit; }
?>
<?php 
date_default_timezone_set('Asia/Kolkata');
$cr_date=date('d-m-Y H:i:s');
$current_time = strtotime($cr_date);
$formDeadLine = getFormDeadLineTime(1,$conn);
?>
<!--IF THE DEADLINE HAS PASSED, LET USER KNOW...ELSE, DISPLAY THE REGISTRATION FORM-->
<?php /*if($current_time >= $formDeadLine) { echo 'HIDE'; } else { echo 'SHOW'; } */ ?>
<?php
$exhibitor_code = $_SESSION['EXHIBITOR_CODE'];

$exhibitor_data = "select * from iijs_exhibitor where Exhibitor_Code='$exhibitor_code'";
$resultEXH = $conn ->query($exhibitor_data);
$fetch_data = $resultEXH->fetch_assoc();
$num = $resultEXH->num_rows;
if($_REQUEST['action']=="ADD")
{			
		$name_of_retail_showroom = filter(strtoupper($_POST['name_of_retail_showroom']));
		$company_gst			 = filter(strtoupper($_POST['company_gst']));
		
		$contact_persons	=	implode(",",$_POST['contact_person']);
		$contact_person		=	filter(trim($contact_persons));
		$mobile_nos	=	implode(",",$_POST['mobile_no']);
		$mobile_no	=	filter($mobile_nos);		
		$designations	=	implode(",",$_POST['designation']);
		$designation	=	filter(trim($designations));		
		$emails	=	implode(",",$_POST['email']);
		$email	=	filter(trim($emails));
				
		$showroom_city	=	implode(",",replace_comma($_POST['showroom_city']));
		$city	=	filter($showroom_city);		
		$showroom_address	=	implode(",",replace_comma($_POST['showroom_address']));
		$address	=	filter($showroom_address);		
		$showroom_area	=	implode(",",replace_comma($_POST['showroom_area']));
		$area	=	filter($showroom_area);		
		$year_of_establishment =	implode(",",$_POST['year_of_establishment']);
		$year	=	filter($year_of_establishment);
		
		$flag=1;
		if(empty($name_of_retail_showroom)){
		$showroomError = "Please Enter Showroom Name"; $flag=0;
		} else {
		$name_of_retail_showroom = filter($name_of_retail_showroom); // check name only contains letters and whitespace
		}
		if(empty($company_gst)){
		$gstNameError = "Please Enter GST No"; $flag=0;
		} else { 
		if(!preg_match("/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/", $company_gst)) {
		$gstNameError = "Please Enter Valid GSTIN No."; $flag=0;
		$company_gst = filter($company_gst);
		}}
		
		if(empty($_POST['contact_person'][0])){ $personError = "Enter Contact Person Name"; $flag=0; }
		if(empty($_POST['mobile_no'][0]))	  { $mobileError = "Enter Mobile No"; $flag=0; }
		if(empty($_POST['designation'][0]))   { $designationError = "Enter Designation"; $flag=0; }
		if(empty($_POST['email'][0]))		  { $emailError = "Enter Email"; $flag=0; }
		
		if($flag==1) {
		if(empty($showroomError))
		{
		/*if($num>0)
		{
		$sql_update="update iijs_personalInfo SET Create_Date=NOW(),Exhibitor_Code='$exhibitor_code',name_of_retail_showroom='$name_of_retail_showroom',company_gst='$company_gst',contact_person='$contact_person',mobile='$mobile_no',designation='$designation',email='$email',status='1',showroom_city='$city',showroom_address='$address',showroom_area='$area',year_of_establishment='$year'";
		$execute=$conn ->query($sql_update);
		if(!$execute)
		echo "Error : ".mysql_error();
		}
		else
		{ */
		$sql_insert="insert into iijs_personalInfo SET Create_Date=NOW(),Exhibitor_Code='$exhibitor_code',name_of_retail_showroom='$name_of_retail_showroom',company_gst='$company_gst',contact_person='$contact_person',mobile='$mobile_no',designation='$designation',email='$email',status='1',showroom_city='$city',showroom_address='$address',showroom_area='$area',year_of_establishment='$year'";
		$execute=$conn ->query($sql_insert);
		if(!$execute)
		echo "Error : ".mysql_error();
		//}
		echo '<script type="text/javascript">'; 
		echo 'alert("You have successfully submitted your application.");'; 
		echo 'window.location.href = "personalInfo.php";';
		echo '</script>';	
		}
		}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome to GJEPC</title>
<link rel="stylesheet" type="text/css" href="css/mystyle.css" />
<!--<script src="https://iijs.org/js/jquery-1.8.3.min.js"></script>-->
<script type="text/javascript" src="../js/jquery_002.js"></script>
<script type="text/javascript">
    $(function() {
        if (!$.support.placeholder) {
            var active = document.activeElement;
            
            $(':text').focus(function() {
                if ($(this).attr('placeholder') != '' && $(this).val() == $(this).attr('placeholder')) {
                    $(this).val('').removeClass('hasPlaceholder');
                }
            }).blur(function() {
                if ($(this).attr('placeholder') != '' && ($(this).val() == '' || $(this).val() == $(this).attr('placeholder'))) {
                    $(this).val($(this).attr('placeholder')).addClass('hasPlaceholder');
                }
            });
            $(':text').blur();         
            $(active).focus();
        }
    });
</script> 
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
						$('.loader').show();
							},
					success: function(data){
						$('.loader').hide();
					//console.log(data);
					//alert(data);  
							$('#update_comm').html(data);
							 //$("#CommunicationDetails").html(data);  
							}
		});
});
</script>

<script src="js/jquery.validate.js"></script>
<link rel="stylesheet" type="text/css" href="../css/manual.css"/>

<style>
.tooltip {
    position: relative;
    display: inline-block;
    border-bottom: 1px dotted black;
    padding: 7.5px 30px;
	margin-left: 10px;
	color:#fff;
    background-color: #924b77;
}

.tooltip .tooltiptext {
    visibility: hidden;
    width: 600px;
    background-color: #924b77;
    color: #fff;
    text-align: left;
    border-radius: 6px;
    padding: 5px 0;
    position: absolute;
    z-index: 1;
    top: 250%;
    right: 0%;
    margin-left: -60px;
    opacity: 0;
    transition: opacity 1s;
}

.tooltip .tooltiptext::after {
    content: "";
    position: absolute;
    top: -58%;
    left: 93%;
    margin-left: -60px;
    border-width: 50px;
    border-style: solid;
    border-color: #924b77 transparent transparent transparent;
	transform: rotate(180deg);
}
.tooltip:hover .tooltiptext {
    visibility: visible;
    opacity: 1;
}
#formWrapper{width:100%;}
#formWrapper > h3{float:left;}

#formWrapper .spanbox{
    padding: 8px 20px;
    background-color: #924b77;	
}
.tooltip{float:right;}
.bigTextField { width: 100%; height: 110px; }
</style>
<style> .error {  color: red; }
#formWrapper .textField 
 { width:auto;
 }
 </style>
	<style>
	.loader {
    position: fixed;
    left: 0px;
    top: 0px;
    width: 100%;
    height: 100%;
    z-index: 9999;
    background: url('images/progress.gif') 50% 50% no-repeat rgb(249,249,249);
    opacity: 80;
	}
	</style>
	
	<script type="text/javascript">
	$(window).load(function() {
		$(".loader").fadeOut("slow");
	});
	</script>
</head>

<body>
<div class="loader"></div>
<!-- header starts -->
<div class="header_wrap"><?php include ('header.php'); ?></div>
<!-- header ends -->
<div class="clear"></div>
<div class="container_wrap">
<div class="container" id="manualFormContainer">
<h1>Online Manual </h1>

<div id="formWrapper">
<h3>ELITE CLUB NOMINATION FORM FOR YOUR RETAILER</h3>

<div class="tooltip"><strong>Note</strong>
<span class="tooltiptext">
<ol class="numeric">
<li>The selection of single OR multiple members from same company will be based on the criteria set by the GJEPC.</li>
		<li>The Selection will be duly informed to Selected Retailer by tele calling/emailer/ letter along with elite card by GJEPC Team.</li>
		<li>Only Retailer Owner/Partner/ Director can avail this facility.</li>
		<li>Elite Card will be couriered to the selected Retailer. In case of non-receipt of the card, you may collect the Elite Card from Visitor Registration Hall.</li>
		<li>IIJS SIGNATURE 2021 badge is compulsory for your entry at the show.</li>
		<li>The database provided to GJEPC will be highly confidential and will solely be used for the promotion of GJEPC events only.</li>
</ol>
</span>
</div>

<span style="color:#fff;float:right;" class="spanbox">Deadline : <strong>15th March 2021</strong></span>

<div class="clear"></div>
<p>The sections marked with a <span class="red">*</span> are compulsory.</p>

<?php 
$catalog_data1="select * from iijs_personalInfo where Exhibitor_Code='$exhibitor_code'";
$result_catalog1=$conn ->query($catalog_data1);
$result_count = $result_catalog1->num_rows;

$name_of_retail_showroom=$fetch_catalog['name_of_retail_showroom'];
$company_gst=$fetch_catalog['company_gst'];
if($result_count>0){ ?>

<table border="0" cellspacing="0" cellpadding="0" class="formManual">
<th>Showroom</th>
<th>Action</th>
<?php while($fetch_row = $result_catalog1->fetch_assoc()){ ?>
<tr>
<td><?php echo $fetch_row['name_of_retail_showroom'];?></td>
<td></td>
<td class="editAdd <?php echo $fetch_row['id'];?> <?php echo $exhibitor_code;?>">VIEW</td>
</tr>
<?php } ?>
</table>
<?php } ?>

<div id="update_comm">
<form name="form1" id="form1" method="POST" autocomplete="off" onsubmit="return validation()">
<input type="hidden" name="action" value="ADD" />

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
	<ul> 
        ** Please note: 		
		<li>The selection of single OR multiple members from same company will be based on the criteria set by the GJEPC.</li>
		<li>The Selection will be duly informed to Selected Retailer by tele calling/emailer/ letter along with elite card by GJEPC Team.</li>
		<li>Only Retailer Owner/Partner/ Director can avail this facility.</li>
		<li>Elite Card will be couriered to the selected Retailer. In case of non-receipt of the card, you may collect the Elite Card from Visitor Registration Hall.</li>
		<li>IIJS 2020 badge is compulsory for your entry at the show.</li>
		<li>The database provided to GJEPC will be highly confidential and will solely be used for the promotion of GJEPC events only.</li>
		<li>The last date to submit the form is 10th January 2020.</li>
    </ul>
<div align="center">
<?php if($_REQUEST['auth']=="admin" && $current_time >= $formDeadLine){ ?>
<input type="submit"  name="submit" value="Add more" class="maroon_btn"/>
<a href="admin_manual_list.php"><input name="input2" type="button" value="BACK" class="maroon_btn" /></a>
<?php } ?>

<?php if($current_time >= $formDeadLine) { } else { ?> 
<input type="submit" name="submit" value="Add more" class="maroon_btn"/>
<a href="manual_list.php"><input name="input2" type="button" value="BACK" class="maroon_btn" /></a>
<?php } ?>

</div>
</form>

</div>
</div>
<div class="clear"></div>
</div>
</div>
<div class="footer_wrap">
<?php include ('footer.php'); ?>
</div>
<!--footer ends-->
</body>
</html>
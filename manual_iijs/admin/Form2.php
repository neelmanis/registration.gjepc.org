<?php session_start(); ?>
<?php include('../db.inc.php');?>
<?php include('../functions.php');?>

<?php
$event = getEventDescription($conn);
$exhibitor_code=$_REQUEST['Exhibitor_Code'];

$exhibitor_data="select * from iijs_exhibitor where Exhibitor_Code='$exhibitor_code'";
$result=$conn ->query($exhibitor_data);
$fetch_data=$result->fetch_assoc();

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
$Exhibitor_Scheme=$fetch_data['Exhibitor_Scheme'];
$Exhibitor_Area=$fetch_data['Exhibitor_Area'];
$Exhibitor_DivisionNo=$fetch_data['Exhibitor_DivisionNo'];
$Exhibitor_StallType=$fetch_data['Exhibitor_StallType'];

$Exhibitor_Address1=$fetch_data['Exhibitor_Address1'];
$Exhibitor_Address2=$fetch_data['Exhibitor_Address2'];
$Exhibitor_Address3=$fetch_data['Exhibitor_Address3'];

$Exhibitor_Layout=$fetch_data['Exhibitor_Layout'];
$Exhibitor_Email=$fetch_data['Exhibitor_Email'];
$Exhibitor_Email1=$fetch_data['Exhibitor_Email1'];
$Exhibitor_Pincode=$fetch_data['Exhibitor_Pincode'];
$Exhibitor_State=$fetch_data['Exhibitor_State'];
$Exhibitor_Country_ID=$fetch_data['Exhibitor_Country_ID'];
$Exhibitor_City=$fetch_data['Exhibitor_City'];
$Exhibitor_Website=$fetch_data['Exhibitor_Website'];
$Exhibitor_Layout=$fetch_data['Exhibitor_Layout'];
$specific_area=$fetch_data['specific_area'];
$getSection = getSection_type($fetch_data['Exhibitor_Section'],$conn);
if(!isset($specific_area)){
	$specific_area = '';
}
?>

<?php 
$sql="select * from iijs_stall_master where Exhibitor_Code='$exhibitor_code'";
$result=$conn ->query($sql);
$rows=$result->fetch_assoc();
$num_rows=$result->num_rows;

$Stall_CustomizedLayout_Image=$rows['Stall_CustomizedLayout_Image'];
$Stall_Display_Light=$rows['Stall_Display_Light'];
$Stall_Display_Light_d=$rows['Stall_Display_Light_d'];
$Stall_Image_Layout_Type=$rows['Stall_Image_Layout_Type'];
$Stall_Basic_Layout_Approved=$rows['Stall_Basic_Layout_Approved'];
$Stall_Basic_Layout_Reason=$rows['Stall_Basic_Layout_Reason'];
$Application_Complete=$rows['Application_Complete'];
$option_lay=$rows['option'];
$option_image_path = $rows['Option_Image_Path'];
$Create_Date=$rows['Create_Date'];
?>

<?php 
$action=$_REQUEST['action'];
if($action=='ADD')
{	
	if($num_rows==0)
	{
		$Stall_Display_Light=$_REQUEST['Stall_Display_Light'][0];
		$Stall_Display_Light_d=$_REQUEST['Stall_Display_Light_d'][0];
		$Stall_Image_Layout_Type=$_REQUEST['Stall_Image_Layout_Type'][0];
		$option_layout=$_REQUEST['option_layout'];
		$option_image_path = $_REQUEST['option_image_path'];
		if($Stall_Image_Layout_Type=='Layout1')
		{
			$Stall_CustomizedLayout_Image="";
		}
		if(isset($_FILES['Stall_CustomizedLayout_Image']) && $_FILES['Stall_CustomizedLayout_Image']['name']!="")
		{
			$file_name=$_FILES['Stall_CustomizedLayout_Image']['name'];
			$file_temp=$_FILES['Stall_CustomizedLayout_Image']['tmp_name'];
			$file_type=$_FILES['Stall_CustomizedLayout_Image']['type'];
			$file_size=$_FILES['Stall_CustomizedLayout_Image']['size'];
			$attach="SL";
			if($_FILES['Stall_CustomizedLayout_Image']['name']!="")
			{
				$Stall_CustomizedLayout_Image=uploadImageAdmin($file_name,$file_temp,$file_type,$file_size,$attach,"stall_layout",$exhibitor_code);
			}
		}
		if($Stall_CustomizedLayout_Image=="" && $Stall_Image_Layout_Type=='Custom')
		{
		echo '<script type="text/javascript">'; 
		echo 'alert("Invalid File,Kindly Upload file in .jpg,.png formate only.");';
		echo 'window.location.href = "Form2.php";';
		echo '</script>';
		
		exit;
		}else
		{
		$sql_insert="insert into iijs_stall_master set Exhibitor_Code='$exhibitor_code',Stall_CustomizedLayout_Image='$Stall_CustomizedLayout_Image',Stall_Display_Light='$Stall_Display_Light',Stall_Display_Light_d='$Stall_Display_Light_d',Stall_Image_Layout_Type='$Stall_Image_Layout_Type',Stall_Basic_Layout_Approved='P',Create_Date=NOW(),Application_Complete='P',`option`='$option_layout',Option_Image_Path='$option_image_path'";
		$execute = $conn ->query($sql_insert);
		if(!$execute)
		echo "Error : ".mysql_error();
		
		}
		
	}else
	{
		$EXHIBITOR_CODE=$_REQUEST['EXHIBITOR_CODE'];
		$Stall_Display_Light=$_REQUEST['Stall_Display_Light'][0];
		$Stall_Display_Light_d=$_REQUEST['Stall_Display_Light_d'][0];
		$Stall_Image_Layout_Type=$_REQUEST['Stall_Image_Layout_Type'][0];
		$option_layout=$_REQUEST['option_layout'];

		$option_image_path = $_REQUEST['option_image_path'];
		$Stall_Basic_Layout_Approved=$_REQUEST['Stall_Basic_Layout_Approved'];

		if($Stall_Basic_Layout_Approved=='Y')
		{
		$Stall_Basic_Layout_Reason="";	
		}else
		{
		   $Stall_Basic_Layout_Reason=$_REQUEST['Stall_Basic_Layout_Reason'];
		}
		if($Stall_Basic_Layout_Approved=='')
		{
			$Stall_Basic_Layout_Approved='P';
			$Stall_Basic_Layout_Reason="";	
		}
		
		if($Stall_Basic_Layout_Approved=='Y')
		{
			$Application_Complete='Y';
		}else if($Stall_Basic_Layout_Approved=='P')
		{
			$Application_Complete='P';
		}else
		{
			$Application_Complete='N';
		}
		
		
		if($Stall_Image_Layout_Type=='Layout1')
		{
			$Stall_CustomizedLayout_Image="";
		}
		
		//Unlink the previuos image
		   $qpreviousimg=$conn ->query("select Stall_CustomizedLayout_Image from iijs_stall_master where Exhibitor_Code='$exhibitor_code'");
		   $rpreviousimg=$qpreviousimg->fetch_assoc();
		   $filename="images/stall_layout/$exhibitor_code/".$rpreviousimg['Stall_CustomizedLayout_Image'];
		   unlink($filename);
		   
		if(isset($_FILES['Stall_CustomizedLayout_Image']) && $_FILES['Stall_CustomizedLayout_Image']['name']!="")
		{
			$file_name=$_FILES['Stall_CustomizedLayout_Image']['name'];
			list($txt, $ext) = explode(".", $file_name);
			$actual_image_name = $Exhibitor_Name.".".$ext;
			$file_temp=$_FILES['Stall_CustomizedLayout_Image']['tmp_name'];
			$file_type=$_FILES['Stall_CustomizedLayout_Image']['type'];
			$file_size=$_FILES['Stall_CustomizedLayout_Image']['size'];
			$attach="SL";
			if($_FILES['Stall_CustomizedLayout_Image']['name']!="")
			{
				$Stall_CustomizedLayout_Image=uploadImageAdmin($actual_image_name,$file_temp,$file_type,$file_size,$attach,"stall_layout",$exhibitor_code);
				
			}
			if($Stall_CustomizedLayout_Image=="" && $Stall_Image_Layout_Type=='Custom')
			{
			echo '<script type="text/javascript">'; 
			echo 'alert("Invalid File,Kindly Upload file in .jpg,.png formate only.");'; 
			echo 'window.location.href = "Form2.php";';
			echo '</script>';
			exit;
			}
		}
		
		 $sql_insert="update iijs_stall_master set Stall_CustomizedLayout_Image='$Stall_CustomizedLayout_Image',Stall_Display_Light='$Stall_Display_Light',Stall_Display_Light_d='$Stall_Display_Light_d',Stall_Image_Layout_Type='$Stall_Image_Layout_Type',Stall_Basic_Layout_Approved='$Stall_Basic_Layout_Approved',Stall_Basic_Layout_Reason='$Stall_Basic_Layout_Reason',Application_Complete='$Application_Complete',`option`='$option_layout',Option_Image_Path='$option_image_path', Modify_Date=NOW() where Exhibitor_Code='$exhibitor_code'";
		
		$execute=$conn->query($sql_insert);
		if(!$execute)
		echo "Error : ".mysqli_error();
		
if($Stall_Basic_Layout_Approved!='P')
{
		if($Stall_Basic_Layout_Approved=='Y'){$Stall_Basic_Layout_Approved='Approved';}else if($Stall_Basic_Layout_Approved=='N'){$Stall_Basic_Layout_Approved='Disapproved';}
	
		/*.......................................Send mail to users mail id...............................................*/
	 	 $message ='<table width="96%" bgcolor="#fbfbfb" style="margin:2% auto; border:2px solid #ddd; font-family:Arial, sans-serif; color:#333333; font-size:13px; border-radius:10px;">
		
		<tr>
		<td style="padding:30px;">
		<table width="100%" border="0px" background="#fbfbfb" cellpadding="0px" cellspacing="0px">
		<tr>
		<td align="left" height="60px"><img src="https://gjepc.org/assets/images/logo.png" border="0" width="220"/></td>
		<td align="right" height="60px"><img src="https://registration.gjepc.org/manual_iijs/images/logo.png" border="0"/></td>
		</tr>
		<tr>
		<td></td>
		<td align="right"></td>
		</tr>
		<tr>
		<td align="right" colspan="2" height="30px"><hr /></td>
		</tr>
		<tr>
		<td colspan="2" style="font-size:13px; line-height:22px;">
		<p>Dear <strong>'.$Exhibitor_Contact_Person.',</strong> </p>
		<p>Company Name: <strong>'.$Exhibitor_Name.'</strong> </p>
		<p>Your details for the Online Application for <strong>Form No. 4. STALL LAYOUT</strong> has been updated by IIJS Admin.</p>
		<p>Kindly login at our website - <a href="gjepc.org/iijs-premiere/">gjepc.org/iijs-premiere/</a> to verify the same.</p>
		
		<table width="600" border="0" cellspacing="0" cellpadding="0"  style="border:1px solid #ccc;">
		  <tr style="height:20px; border:1px solid  #FF0000; background:#751b53; color:#FFFFFF;">
			<td style="border:1px solid  #cccccc; padding:5px;" ><strong>Details</strong></td>
			<td style="border:1px solid  #cccccc; padding:5px;"><strong>Status</strong></td>
			<td style="border:1px solid  #cccccc; padding:5px;"><strong>Reason for  Disapproval </strong></td>
		  </tr>
		  <tr style="height:20px; border:1px solid  #FF0000;">
			<td style="border:1px solid  #cccccc; padding:5px;" >Stall Layout</td>
			<td style="border:1px solid  #cccccc; padding:5px;">'.$Stall_Basic_Layout_Approved.'</td>
			<td style="border:1px solid  #cccccc; padding:5px;">'.$Stall_Basic_Layout_Reason.' </td>
		  </tr>
		 		  
</table>

		<p>Kind regards, <br />
		<strong>IIJS Web Team,</strong>
		</p>
		</td>
		</tr>
	
		<tr>
		<td colspan="2" align="center" style="font-size:13px; line-height:22px;">    
		</td>
		</tr>
		</table>
		</td>
		
		
		</tr>
		
		</table>';
		
		$to =$Exhibitor_Email.',notification@gjepcindia.com';
		//$to ='santosh@kwebmaker.com';
		$subject = "".$event." Exhibitor Manual - Form No. 4. STALL LAYOUT"; 
		$headers  = 'MIME-Version: 1.0' . "\n"; 
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n"; 
		$headers .= 'From: IIJS PREMIERE 2021 <admin@gjepc.org>';			
		mail($to, $subject, $message, $headers);
}
			
}
	echo '<script type="text/javascript">'; 
	//echo 'alert("Stall Layout Upload Successfully.");'; 
	echo 'window.location.href = "manage_stall_layout.php";';
	echo '</script>';
	
}
?>

<?php
/*...............................Set Default Teplate..................................*/
$default_custom_template=$Exhibitor_Area."_".$Exhibitor_StallType.".jpg";

if($Exhibitor_StallType=="normal")
	$category=1;
else if($Exhibitor_StallType=="corner_2side")
	$category=2;
else if($Exhibitor_StallType=="corner_3side")
	$category=3;
else if($Exhibitor_StallType=="island_4side")
	$category=4;
/*...............................Set Default Layout..................................*/
$default_custom_layout=$Exhibitor_Area.".png";
/*
if($Exhibitor_Section=='signature_club')
{
	$default_custom_layout=$Exhibitor_Scheme."_SC_".$Exhibitor_Area."_".$category.".JPG";
}else if($Exhibitor_Section=='loose_stones')
{
$default_custom_layout=$Exhibitor_Scheme."_LS_".$Exhibitor_Area."_".$category.".JPG";
}else if($Exhibitor_Section=='plain_gold')
{
	$default_custom_layout=$Exhibitor_Scheme."_GJ_".$Exhibitor_Area."_".$category.".JPG";
}else if($Exhibitor_Section=='studded_jewellery')
{
$default_custom_layout=$Exhibitor_Scheme."_SJ_".$Exhibitor_Area."_".$category.".JPG";
}
*/
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Stall Layout</title>
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
<script type="text/javascript">
function check_disable(){
    if ($('input[name=\'Stall_Image_Layout_Type[]\']:checked').val() == "Custom"){
        $("#custom_lay").show();
    }
    else{
        $("#custom_lay").hide();
    }	
}
</script>

<script type="text/javascript">
function validation()
{
	var getSection = "<?php echo $getSection; ?>";
	if($('input[name=\'Stall_Basic_Layout_Approved\']:checked').val() == "N")
	{
		if(document.getElementById('Stall_Basic_Layout_Reason').value=="")
		{
			alert("Please Enter Stall Layout Disapprove Reason");
			document.getElementById('Stall_Basic_Layout_Reason').focus();
			return false;
		}
	}

	var option_layout = $('input[name=option_layout]:checked').val();
	if(getSection != "machinery"){
		if(option_layout == undefined || option_layout == null || option_layout == ''){
			alert("Please Select Option.");
			//document.getElementsByClassName('option').focus();
			return false;
		}
	}
	
	
}
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
	var option_image = "<?php echo $default_custom_layout; ?>";
	var specific_area = "<?php echo $specific_area; ?>";
	var getSection = "<?php echo $getSection; ?>";
	var option_lay = "<?php echo $option_lay ?>";
	$(document).ready(function(){
	//var option_image = ''; 
	$('#option_table_one').hide();
	$('#option_table_two').hide();
	$('#option_table_three').hide();
	$('#option_table_four').hide();
	$('#option_table').hide();
	if(option_lay != '' && option_lay != null && option_lay != undefined){
		if(option_lay == "1"){
			$('#option_table_one').show();
		} else if(option_lay == "2"){
			$('#option_table_two').show();
		} else if(option_lay == "3"){
			$('#option_table_three').show();
		} else if(option_lay == "4"){
			$('#option_table_four').show();
		}
	}
	if(getSection == "machinery" && getSection != null && getSection != '' && getSection != undefined){
		$('#machinery_table').show();
		$('#option_table_two').hide();
		$('#option_table_three').hide();
		$('#option_table_four').hide();
		$('#option_table_one').hide();
	} 
	$('.option').on('click',function(e){
		//e.preventDefault();
		var option = $('input[type=radio]:checked').val();
		if(getSection == "machinery"){
			$('#machinery_table').show();
			$('#option_table_two').hide();
			$('#option_table_three').hide();
			$('#option_table_four').hide();
			$('#option_table_one').hide();
		} else {
			if(option == 1){
				$('#option_table').hide();
				$('#option_table_two').hide();
				$('#option_table_three').hide();
				$('#option_table_four').hide();
				$('#option_table_one').show();
				//if(specific_area != '' && specific_area != undefined && specific_area != null && specific_area == "1" ){
				if(specific_area != '' && specific_area != undefined && specific_area != null ){
					var images = '../images/stall_layout/layout/'+'option1_'+specific_area+option_image;
		    		$(".image_change").attr('src', images);
		    		$(".example2").attr("href", '../images/stall_layout/layout/'+'option1_'+specific_area+option_image);
		    		var option_image_path = 'images/stall_layout/layout/'+'option1_'+specific_area+option_image;
		    		$("#option_image_path").val(option_image_path);
				} else {
					var images = '../images/stall_layout/layout/'+'option1_'+option_image;
		    		$(".image_change").attr('src', images);
		    		$(".example2").attr("href", '../images/stall_layout/layout/'+'option1_'+option_image);
		    		var option_image_path = 'images/stall_layout/layout/'+'option1_'+option_image;
		    		$("#option_image_path").val(option_image_path);
				}
				
			}
			if(option == 2){
				$('#option_table').hide();
				$('#option_table_one').hide();
				$('#option_table_three').hide();
				$('#option_table_four').hide();
				$('#option_table_two').show();
				//if(specific_area != '' && specific_area != undefined && specific_area != null && specific_area == "2"){
				if(specific_area != '' && specific_area != undefined && specific_area != null ){	
					var images = '../images/stall_layout/layout/'+'option2_'+specific_area+option_image;
		    		$(".image_change").attr('src', images)
		    		$(".example2").attr("href", '../images/stall_layout/layout/'+'option2_'+specific_area+option_image);
					var option_image_path = 'images/stall_layout/layout/'+'option2_'+specific_area+option_image;
		    		$("#option_image_path").val(option_image_path);
				} else {
					var images = '../images/stall_layout/layout/'+'option2_'+option_image;
		    		$(".image_change").attr('src', images)
		    		$(".example2").attr("href", '../images/stall_layout/layout/'+'option2_'+option_image);
		    		var option_image_path = 'images/stall_layout/layout/'+'option2_'+option_image;
		    		$("#option_image_path").val(option_image_path);
				}
				
			}
			if(option == 3){
				$('#option_table').hide();
				$('#option_table_one').hide();
				$('#option_table_three').show();
				$('#option_table_four').hide();
				$('#option_table_two').hide();
				if(specific_area != '' && specific_area != undefined && specific_area != null ){
					var images = '../images/stall_layout/layout/'+'option3_'+specific_area+option_image;
		    		$(".image_change").attr('src', images)
		    		$(".example2").attr("href", '../images/stall_layout/layout/'+'option3_'+specific_area+option_image);
		    		var option_image_path = 'images/stall_layout/layout/'+'option3_'+specific_area+option_image;
		    		$("#option_image_path").val(option_image_path);
				} else {
					var images = '../images/stall_layout/layout/'+'option3_'+option_image;
		    		$(".image_change").attr('src', images)
		    		$(".example2").attr("href", '../images/stall_layout/layout/'+'option3_'+option_image);
		    		var option_image_path = 'images/stall_layout/layout/'+'option3_'+option_image;
		    		$("#option_image_path").val(option_image_path);
				}
				
			}if(option == 4){
				$('#option_table').hide();
				$('#option_table_one').hide();
				$('#option_table_three').hide();
				$('#option_table_four').show();
				$('#option_table_two').hide();
				if(specific_area != '' && specific_area != undefined && specific_area != null ){
					var images = '../images/stall_layout/layout/'+'option4_'+specific_area+option_image;
		    		$(".image_change").attr('src', images)
		    		$(".example2").attr("href", '../images/stall_layout/layout/'+'option4_'+specific_area+option_image);
		    		var option_image_path = 'images/stall_layout/layout/'+'option4_'+specific_area+option_image;
		    		$("#option_image_path").val(option_image_path);
				} else {
					var images = '../images/stall_layout/layout/'+'option4_'+option_image;
		    		$(".image_change").attr('src', images)
		    		$(".example2").attr("href", '../images/stall_layout/layout/'+'option4_'+option_image);
		    		var option_image_path = 'images/stall_layout/layout/'+'option4_'+option_image;
		    		$("#option_image_path").val(option_image_path);
				}
				
			}
			if(option == '2a'){
				$('#option_table').hide();
				$('#option_table_one').hide();
				$('#option_table_three').hide();
				$('#option_table_four').hide();
				$('#option_table_two').show();
				if(specific_area != '' && specific_area != undefined && specific_area != null ){
					var images = '../images/stall_layout/layout/'+'option2a_'+specific_area+option_image;
		    		$(".image_change").attr('src', images)
		    		$(".example2").attr("href", '../images/stall_layout/layout/'+'option2a_'+specific_area+option_image);
		    		$("#option_image_path").val(images);
				} else {
					var images = '../images/stall_layout/layout/'+'option2a_'+option_image;
		    		$(".image_change").attr('src', images)
		    		$(".example2").attr("href", '../images/stall_layout/layout/'+'option2a_'+option_image);
		    		$("#option_image_path").val(images);
				}
			}
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
	<div class="breadcome"><a href="manage_stall_layout.php?action=view">Home</a> > Stall Layout</div>
</div>

<div id="main">

	<div class="content">		
	<span style="margin-left:10px;float:right" class="spanbox"><a href="../images/pdf/<?php echo $Exhibitor_Area; ?>.pdf" target="_blank"><strong>Click here to download stall layout</strong></a></span>
    	<div class="content_head">Stall Layout</div>
     	<div class="content_details22">
         <div id="formWrapper">
		 
<div class="title"><h4>Exhibitor Information</h4></div>
<div class="clear"></div>
<form name="form1" action="" method="post" enctype="multipart/form-data" onsubmit="return validation()">
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
</table>

<div class="title"><h4>Basic Furniture</h4></div>
<div class="clear"></div>
<?php if($getSection != "machinery") { ?>
	<input type="radio" id="option_one" class="option" name="option_layout" value="1" <?php if($option_lay=="1"){echo "checked='checked'" ;} ?> >
	<label for="option_one">Option One</label>

	<input type="radio" id="option_two" class="option" name="option_layout" value="2" <?php if($option_lay=="2"){echo "checked='checked'" ;} ?> >
	<label for="option_two">Option Two</label>

	<input type="radio" id="option_three" class="option" name="option_layout" value="3" <?php if($option_lay=="3"){echo "checked='checked'" ;} ?>>
	<label for="option_three">Option Three</label>

	<input type="radio" id="option_Four" class="option" name="option_layout" value="4" <?php if($option_lay=="4"){echo "checked='checked'" ;} ?> >
	<label for="option_Four">Option Four</label>
	<?php if($Exhibitor_Area >= 27) {?>
		 <input type="radio" id="option_2a" class="option <?php if($option_lay!=""){echo 'not_clickable' ;} ?>" name="option_layout" value="2a" <?php if($option_lay=="2a"){echo "checked='checked'" ;} ?> <?php if($option_lay!='' || $option_lay=='2a' ) {echo 'readonly=readonly';} ?> >
		<label for="option_2a">Option 2a</label> 
	<?php } ?>
<?php } ?>
<div class="title"><h4>Stall Layout</h4></div>
<div class="clear"></div>
<table border="0" cellspacing="0" cellpadding="0" class="formManual" style="margin-bottom:0px;">
  <tr>
  	<?php if(isset($option_image_path) && $option_image_path != null){ ?>
		    <td width="24%"><div class="boothImage"><img src="<?php echo '../'.$option_image_path;?>" alt="" class="image_change" width="149" height="140" />
		    <input type="hidden" name="option_image_path" id="option_image_path" value="<?php echo $option_image_path; ?>" >
		    </div></td>
    <?php } else { ?>
    		 <td width="24%"><div class="boothImage"><img src="../images/stall_layout/layout/<?php echo $default_custom_layout;?>" alt="" class="image_change" width="149" height="140" /><input type="hidden" name="option_image_path" id="option_image_path" value="<?php echo $option_image_path; ?>" >
		    </div></td>
    <?php } ?>
    <td width="28%"><div style="float:left; margin-right:10px;">
      <input name="Stall_Image_Layout_Type[]" id="Stall_Image_Layout_Type2" type="radio" value="Layout1" onchange="check_disable()" <?php if($Stall_Image_Layout_Type=="Layout1"){echo "checked='checked'";}?>/>
    </div>
    
    <div style="float:left;">Choose Layout 1<br />Normal</div>
    
    <div class="clear bottomSpace"></div>
    
    <?php if(isset($option_image_path) && $option_image_path != null){ ?>
	    <div><a class="example2" href="<?php echo '../'.$option_image_path; ?>" target="_blank">
	      <input name="input" type="button" value="View Image" class="maroon_btn" />
	    </a><a class="example2" href="<?php echo '../'.$option_image_path; ?>" target="_blank"></a></div>    </td>
    <?php } else { ?>
    	<div><a class="example2" href="../images/stall_layout/layout/<?php echo $default_custom_layout;?>" target="_blank">
	      <input name="input" type="button" value="View Image" class="maroon_btn" />
	    </a><a class="example2" href="../images/stall_layout/layout/<?php echo $default_custom_layout;?>" target="_blank"></a></div>    </td>
    <?php } ?>
    <td width="2%">&nbsp;</td>
    <td width="24%"><img src="<?php if($Stall_CustomizedLayout_Image==""){ echo "../images/customeImage.jpg";}else{?>../images/stall_layout/<?php echo $exhibitor_code;?>/<?php echo $Stall_CustomizedLayout_Image;?><?php }?>" width="149" height="140" alt="" /></td>
    <td width="22%"><div style="float:left; margin-right:10px;"><input name="Stall_Image_Layout_Type[]" id="Stall_Image_Layout_Type" type="radio" value="Custom" onchange="check_disable()" <?php if($Stall_Image_Layout_Type=="Custom"){echo "checked='checked'";}?> /></div>
    
    <div style="float:left;">Choose Custome <br />Layout</div>
    <div class="clear bottomSpace"></div>
    
    <?php if($Stall_CustomizedLayout_Image!=""){?>
    <div><a class="example2" href="../images/stall_layout/<?php echo $exhibitor_code;?>/<?php echo $Stall_CustomizedLayout_Image;?>" target="_blank"><input name="input4" type="button" value="View Image" class="maroon_btn" /></a></div>
    <?php }?>    </td>
  </tr>
</table>

<?php if($getSection == "machinery") { ?>
<table border="0" cellspacing="0" cellpadding="0" id="machinery_table" class="formManual tableBorder">  
	<?php
	$getSection = getSection_type($fetch_data['Exhibitor_Section'],$conn);
	if($getSection == "machinery"){
		$sql10 = "SELECT * FROM iijs_stall_basic_furniture where ex_section='$getSection' AND `ex_area`='$Exhibitor_Area' ";
	} 
	
	$result10 = $conn ->query($sql10);
	//$rows10 = $result10->fetch_assoc();
	$count10  = $result10->num_rows;
	?>
  
	<?php
	
	?>
	  <tr>
	    <th colspan="10" class="bold" align="center" style="text-align:center;"><strong><?php echo getSection_desc($Exhibitor_Section,$conn); ?> - <?php echo $Exhibitor_Area; ?>sqmt (<?php echo $Exhibitor_StallType;?>)</strong></th>
	  </tr>
	  <tr>
	    <td class="bold" width="14%">Tall Showcase</td>
	    <td class="bold" width="14%">Top Glass Showcase</td>
	    <td class="bold" width="14%">Table</td>
	    <td class="bold" width="14%">Chair</td>
	   <td class="bold" width="14%"><?php if($getSection=="machinery"){?>16 Watt LED Light<?php } else { ?>50 Watt Track Light<?php } ?></td>
	    <td class="bold" width="14%">Dustbin</td>
	    <td class="bold" width="14%">Plug Point</td>
	    <td class="bold" width="14%">2mtr window Glass Unit</td>
	    <td class="bold" width="14%">1mtr window Glass Unit</td>
	  </tr>
	   <?php
	  	if($count10 > 0){
	  		 while ($rows10 = $result10->fetch_assoc() ) { ?>
			  <tr>
			 	  <td><?php echo $rows10['tall_showcase'];?></td>
				<td><?php echo $rows10['top_glass_showcase'];?></td> 	
			    <td><?php echo $rows10['no_of_table'];?></td>
			    <td><?php echo $rows10['chair'];?></td>
			    <td><?php echo $rows10['50_w_track_light'];?></td>
			    <td><?php echo $rows10['dustbin'];?></td>
				<td><?php echo $rows10['plug_point'];?></td>
			    <td><?php echo $rows10['2m_window_glass_unit'];?></td>
			    <td><?php echo $rows10['1m_window_glass_unit'];?></td>
			  </tr>
	  		<?php } ?>
	  	<?php } ?>
	    <?php
		?>
</table>
<?php } ?>

<?php if($getSection != "machinery") { ?>
<table border="0" cellspacing="0" cellpadding="0" id="option_table_one" class="formManual tableBorder">  
	<?php
	if($getSection == "machinery"){
		$sql1 = "SELECT * FROM iijs_stall_basic_furniture where ex_section='$getSection' and  `ex_area`='$Exhibitor_Area' "; 
	} else {
		$sql1 = "SELECT * FROM iijs_stall_basic_furniture where ex_section='$getSection' and `option`= '1' and  `ex_area`='$Exhibitor_Area' "; 
	}
	$result1 = $conn ->query($sql1);
	$count1  = $result1->num_rows;

	?>
  
	<?php
	
	?>
	  <tr>
	    <th colspan="10" class="bold" align="center" style="text-align:center;"><strong><?php  echo getSection_desc($Exhibitor_Section,$conn); ?> - <?php echo $Exhibitor_Area; ?>sqmt (<?php echo $Exhibitor_StallType;?>)</strong></th>
	  </tr>
	 <tr>
	    <td class="bold" width="14%">Tall Showcase</td>
	    <td class="bold" width="14%">Top Glass Showcase</td>
	    <td class="bold" width="14%">Table</td>
	    <td class="bold" width="14%">Chair</td>
	    <td class="bold" width="14%">50 w Track Light</td>
	    <td class="bold" width="14%">Dustbin</td>
	    <td class="bold" width="14%">Plug Point</td>
	    <td class="bold" width="14%">2mtr window Glass Unit</td>
	    <td class="bold" width="14%">1mtr window Glass Unit</td>
	  </tr>
	  <?php
	  	if($count1 > 0){
	  		 while ($rows1 = $result1->fetch_assoc() ) { ?>
			  <tr>
			 	 <td><?php echo $rows1['tall_showcase'];?></td>
				<td><?php echo $rows1['top_glass_showcase'];?></td> 	
			    <td><?php echo $rows1['no_of_table'];?></td>
			    <td><?php echo $rows1['chair'];?></td>
			    <td><?php echo $rows1['50_w_track_light'];?></td>
			    <td><?php echo $rows1['dustbin'];?></td>
				<td><?php echo $rows1['plug_point'];?></td>
			    <td><?php echo $rows1['2m_window_glass_unit'];?></td>
			    <td><?php echo $rows1['1m_window_glass_unit'];?></td>
			  </tr>
	  		<?php } ?>
	  	<?php } ?>
	    <?php
		?>
</table>

<table border="0" cellspacing="0" cellpadding="0" id="option_table_two" class="formManual tableBorder">  
	<?php
	if($getSection == "machinery"){
		$sql2 = "SELECT * FROM iijs_stall_basic_furniture where ex_section='$getSection'  and  `ex_area`='$Exhibitor_Area' ";
	} else {
		$sql2 = "SELECT * FROM iijs_stall_basic_furniture where ex_section='$getSection' and `option`= '2' and  `ex_area`='$Exhibitor_Area' "; 
	}
	
	$result2 = $conn ->query($sql2);
	$count2  = $result2->num_rows;
	?>
  
	<?php
	
	?>
	  <tr>
	    <th colspan="10" class="bold" align="center" style="text-align:center;"><strong><?php echo getSection_desc($Exhibitor_Section,$conn); ?> - <?php echo $Exhibitor_Area; ?>sqmt (<?php echo $Exhibitor_StallType;?>)</strong></th>
	  </tr>
	  <tr>
	    <td class="bold" width="14%">Tall Showcase</td>
	    <td class="bold" width="14%">Top Glass Showcase</td>
	    <td class="bold" width="14%">Table</td>
	    <td class="bold" width="14%">Chair</td>
	    <td class="bold" width="14%">50 w Track Light</td>
	    <td class="bold" width="14%">Dustbin</td>
	    <td class="bold" width="14%">Plug Point</td>
	    <td class="bold" width="14%">2mtr window Glass Unit</td>
	    <td class="bold" width="14%">1mtr window Glass Unit</td>
	  </tr>
	  <?php
	  	if($count2 > 0){
	  		 while ($rows2 = $result2->fetch_assoc() ) { ?>
			  <tr>
			 	  <td><?php echo $rows2['tall_showcase'];?></td>
					<td><?php echo $rows2['top_glass_showcase'];?></td> 	
				    <td><?php echo $rows2['no_of_table'];?></td>
				    <td><?php echo $rows2['chair'];?></td>
				    <td><?php echo $rows2['50_w_track_light'];?></td>
				    <td><?php echo $rows2['dustbin'];?></td>
					<td><?php echo $rows2['plug_point'];?></td>
				    <td><?php echo $rows2['2m_window_glass_unit'];?></td>
				    <td><?php echo $rows2['1m_window_glass_unit'];?></td>
			  </tr>
	  		<?php } ?>
	  	<?php } ?>
</table>

<table border="0" cellspacing="0" cellpadding="0" id="option_table_three" class="formManual tableBorder">  
	<?php
	if($getSection == "machinery"){
			$sql3 = "SELECT * FROM iijs_stall_basic_furniture where ex_section='$getSection' and  `ex_area`='$Exhibitor_Area' ";
	} else {
		$sql3 = "SELECT * FROM iijs_stall_basic_furniture where ex_section='$getSection' and `option`= '3' and  `ex_area`='$Exhibitor_Area' "; 
	}

	$result3 = $conn ->query($sql3);
	$count3  = $result3->num_rows;
	?>
  
	<?php
	
	?>
	  <tr>
	    <th colspan="10" class="bold" align="center" style="text-align:center;"><strong><?php echo getSection_desc($Exhibitor_Section,$conn); ?> - <?php echo $Exhibitor_Area; ?>sqmt (<?php echo $Exhibitor_StallType;?>)</strong></th>
	  </tr>
	  <tr>
	    <td class="bold" width="14%">Tall Showcase</td>
	    <td class="bold" width="14%">Top Glass Showcase</td>
	    <td class="bold" width="14%">Table</td>
	    <td class="bold" width="14%">Chair</td>
	    <td class="bold" width="14%">50 w Track Light</td>
	    <td class="bold" width="14%">Dustbin</td>
	    <td class="bold" width="14%">Plug Point</td>
	    <td class="bold" width="14%">2mtr window Glass Unit</td>
	    <td class="bold" width="14%">1mtr window Glass Unit</td>
	  </tr>
	  <?php
	  	if($count3 > 0){
	  		 while ($rows3 = $result3->fetch_assoc() ) { ?>
			  <tr>
			 	 <td><?php echo $rows3['tall_showcase'];?></td>
					<td><?php echo $rows3['top_glass_showcase'];?></td> 	
				    <td><?php echo $rows3['no_of_table'];?></td>
				    <td><?php echo $rows3['chair'];?></td>
				    <td><?php echo $rows3['50_w_track_light'];?></td>
				    <td><?php echo $rows3['dustbin'];?></td>
					<td><?php echo $rows3['plug_point'];?></td>
				    <td><?php echo $rows3['2m_window_glass_unit'];?></td>
				    <td><?php echo $rows3['1m_window_glass_unit'];?></td>
			  </tr>
	  		<?php } ?>
	  	<?php } ?>
</table>
<table border="0" cellspacing="0" cellpadding="0" id="option_table_four" class="formManual tableBorder">  
	<?php

	if($getSection == "machinery"){
			$sql4 = "SELECT * FROM iijs_stall_basic_furniture where ex_section='$getSection' and  `ex_area`='$Exhibitor_Area' ";
	} else {
		$sql4 = "SELECT * FROM iijs_stall_basic_furniture where ex_section='$getSection' and `option`= '4' and  `ex_area`='$Exhibitor_Area' "; 
	}
	$result4 = $conn ->query($sql4);
	$count4  = $result4->num_rows;
	?>
  
	<?php
	
	?>
	  <tr>
	    <th colspan="10" class="bold" align="center" style="text-align:center;"><strong><?php echo getSection_desc($Exhibitor_Section,$conn) ?> - <?php echo $Exhibitor_Area; ?>sqmt (<?php echo $Exhibitor_StallType;?>)</strong></th>
	  </tr>
	  <tr>
	    <td class="bold" width="14%">Tall Showcase</td>
	    <td class="bold" width="14%">Top Glass Showcase</td>
	    <td class="bold" width="14%">Table</td>
	    <td class="bold" width="14%">Chair</td>
	    <td class="bold" width="14%">50 w Track Light</td>
	    <td class="bold" width="14%">Dustbin</td>
	    <td class="bold" width="14%">Plug Point</td>
	    <td class="bold" width="14%">2mtr window Glass Unit</td>
	    <td class="bold" width="14%">1mtr window Glass Unit</td>
	  </tr>
	  <?php
	  	if($count4 > 0){
	  		 while ($rows4 = $result4->fetch_assoc() ) { ?>
			  <tr>
			 	 <td><?php echo $rows4['tall_showcase'];?></td>
					<td><?php echo $rows4['top_glass_showcase'];?></td> 	
				    <td><?php echo $rows4['no_of_table'];?></td>
				    <td><?php echo $rows4['chair'];?></td>
				    <td><?php echo $rows4['50_w_track_light'];?></td>
				    <td><?php echo $rows4['dustbin'];?></td>
					<td><?php echo $rows4['plug_point'];?></td>
				    <td><?php echo $rows4['2m_window_glass_unit'];?></td>
				    <td><?php echo $rows4['1m_window_glass_unit'];?></td>
			  </tr>
	  		<?php } ?>
	  	<?php } ?>
</table>
<?php } ?>
<!-- <table border="0" cellspacing="0" cellpadding="0" class="formManual tableBorder">   -->

	<?php
/*	if($Exhibitor_Section=='signature_club' && $Exhibitor_Scheme=='BI2')
	{
	$sql1="SELECT * FROM `iijs_stall_basic_furniture` WHERE `ex_section`='$Exhibitor_Section' and `ex_area`='$Exhibitor_Area' and `ex_scheme`='$Exhibitor_Scheme' and `ex_stall_type`='$Exhibitor_StallType'";
	} else if($Exhibitor_Section=='loose_stones' && $Exhibitor_Scheme=='BI2')
	{
	$sql1="SELECT * FROM `iijs_stall_basic_furniture` WHERE `ex_section`='$Exhibitor_Section' and `ex_area`='$Exhibitor_Area' and `ex_scheme`='$Exhibitor_Scheme'";
	} else if($Exhibitor_Scheme=='BI1' || $Exhibitor_Scheme=='BI2')
	{
	$sql1="SELECT * FROM `iijs_stall_basic_furniture` WHERE `ex_section`='$Exhibitor_Section' AND`ex_scheme`='$Exhibitor_Scheme' AND `ex_area`='$Exhibitor_Area'";	
	} */
	// $getSection = getSection_type($fetch_data['Exhibitor_Section'],$conn);
	// $sql1="SELECT * FROM iijs_stall_basic_furniture where ex_section='$getSection' AND `ex_area`='$Exhibitor_Area'";
 //  	$result1 = $conn ->query($sql1);
	// $rows1 = $result1->fetch_assoc();
	// $order_number =  $result1->num_rows;
	// if($order_number>0)
	// {
	?>
  <!-- <tr>
    <th colspan="10" class="bold" align="center" style="text-align:center;"><strong>
	<?php //echo getSection_desc($Exhibitor_Section,$conn); ?> - <?php //echo $Exhibitor_Area; ?>sqmt (<?php //echo $Exhibitor_StallType;?>)</strong></th>
  </tr>
  <tr>
    <td class="bold" width="14%">Tall Showcase</td>
    <td class="bold" width="14%">Top Glass Showcase</td>
    <td class="bold" width="14%">Table</td>
    <td class="bold" width="14%">Chair</td>
    <td class="bold" width="14%">50 w Track Light</td>
    <td class="bold" width="14%">Dustbin</td>
    <td class="bold" width="14%">Plug Point</td>
    <td class="bold" width="14%">2mtr window Glass Unit</td>
    <td class="bold" width="14%">1mtr window Glass Unit</td>
  </tr>
  <tr>
 	<!-- <td><?php //echo $rows1['tall_showcase'];?></td>
	<td><?php //echo $rows1['top_glass_showcase'];?></td> 	
    <td><?php //echo $rows1['no_of_table'];?></td>
    <td><?php //echo $rows1['chair'];?></td>
    <td><?php //echo $rows1['50_w_track_light'];?></td>
    <td><?php //echo $rows1['dustbin'];?></td>
	<td><?php //echo $rows1['plug_point'];?></td>
    <td><?php //echo $rows1['2m_window_glass_unit'];?></td>
    <td><?php //echo $rows1['1m_window_glass_unit'];?></td>
  </tr> -->
    <?php //} ?>
<!-- </table> --> 
<!--
<div class="title"><h4>Standfitting</h4></div>
<div class="clear"></div>
<table border="0" cellspacing="0" cellpadding="0" class="formManual tableBorder"> 
<tr>
    <td class="bold">Items Applied </td>
    <td class="bold">Rate</td>
	<td class="bold">Quantity</td>
	<td class="bold"><span>Amount</span></td> 	  
</tr>
<?php
$query=$conn ->query("SELECT a.*,b.* FROM `iijs_stand` a,iijs_payment_master b WHERE 1 and a.`Payment_Master_ID`=b.`Payment_Master_ID` and a.Exhibitor_Code='$exhibitor_code' and b.Form_ID='3' order by b.Payment_Master_ID asc");
while($resulty=$query->fetch_assoc())
{
	$Stand_ID = $resulty['Stand_ID'];
	$getItems = "select * from iijs_stand_items where Stand_ID='$Stand_ID'";
	$querys=$conn ->query($getItems);
	while($result=$querys->fetch_assoc()){  //echo '<pre>'; print_r($result);
	$tot=$result['Item_Rate']*$result['Item_Quantity'];
	?>
	<tr>
 	<td><?php echo getItemDescription($result['Item_Master_ID'],$conn);?></td>
    <td><?php echo $result['Item_Rate']?></td>
	<td><?php echo $result['Item_Quantity'];?></td>
	<td><?php echo $tot;?></td>  
    </tr>
	<?php }
}
?>
</table>
-->
<!-- <form name="form1" action="" method="post" enctype="multipart/form-data" onsubmit="return validation()"> -->
<input type="hidden" name="action" value="ADD" />
<input type="hidden" name="EXHIBITOR_CODE" id="EXHIBITOR_CODE" value="<?php echo $exhibitor_code;?>" />

<div class="title"><h4>Stall & Display Lights</h4></div>
<div class="clear"></div>
<table border="0" cellspacing="0" cellpadding="0" class="formManual">
  <tr>
    <td width="60%"><strong>Stall and display lights for your booth (General) :</strong></td>
    <td width="40%"><input name="Stall_Display_Light[]" id="Stall_Display_Light" type="radio" value="0" <?php if($Stall_Display_Light=="0"){echo "checked='checked'";}?> />White
    <input name="Stall_Display_Light[]" id="Stall_Display_Light" type="radio" value="1" <?php if($Stall_Display_Light=="1"){echo "checked='checked'";}?> />Yellow</td>
    
    </tr>
    
     <tr>
    <td width="60%"><strong>Stall and display lights for your booth (Display) :</strong></td>
    <td width="40%"><input name="Stall_Display_Light_d[]" id="Stall_Display_Light_d" type="radio" value="0" <?php if($Stall_Display_Light_d=="0"){echo "checked='checked'";}?> />White
    <input name="Stall_Display_Light_d[]" id="Stall_Display_Light_d" type="radio" value="1" <?php if($Stall_Display_Light_d=="1"){echo "checked='checked'";}?> />Yellow</td>
    
    </tr>
</table>



<div id="custom_lay" <?php if($Stall_Image_Layout_Type=="Layout1"){?>style="display:none;"<?php }?>>
<table border="0" cellspacing="0" cellpadding="0" class="formManual">
  <tr>
    <td width="42%"><strong>Upload your customized stall layout</strong></td>
    <td width="58%"><div class="chooseButton"><input type="file" name="Stall_CustomizedLayout_Image" id="Stall_CustomizedLayout_Image" class="textField" /></div></td>
    <td width="17%">&nbsp;</td>
    </tr>
</table>
</div>

<br />

<div class="title"><h4>Info Approval</h4></div>
<div class="clear"></div>
<table border="0" cellspacing="0" cellpadding="0" class="formManual">
  <tr>
    <td width="150" class="bold"><strong>Status</strong></td>
    <td>:</td>
    <td>
 
    
   <div class="leftStatus"><span><input name="Stall_Basic_Layout_Approved" id="Stall_Basic_Layout_Approved" type="radio" value="Y" <?php if($Stall_Basic_Layout_Approved=='Y'){ echo "checked='checked'";}?> />
   </span>Approval </div> 
   <div class="leftStatus"> <span><input name="Stall_Basic_Layout_Approved" id="Stall_Basic_Layout_Approved" type="radio" value="N" <?php if($Stall_Basic_Layout_Approved=='N'){ echo "checked='checked'";}?> /></span> Disapprove</div>
    
    <div class="clear"></div>
    <textarea name="Stall_Basic_Layout_Reason" id="Stall_Basic_Layout_Reason" class="textArea"><?php echo "$Stall_Basic_Layout_Reason"; ?></textarea></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>




<div class="clear"></div>
<div align="center">
<input name="input2" type="submit" value="Submit" class="maroon_btn" />
<a href="manage_stall_layout.php"><input name="input2" type="button" value="Cancel" class="maroon_btn" /></a>
</div>

</form>
</div>
</div>
</div>
</div>
<div id="footer_wrap"><?php include("include/footer.php");?></div>
</body>
</html>
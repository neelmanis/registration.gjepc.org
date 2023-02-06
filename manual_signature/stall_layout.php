<?php 
include('header_include.php');
// ini_set('display_errors', 1);
//     ini_set('error_reporting', E_ALL);
if(!isset($_SESSION['EXHIBITOR_CODE'])){ header("location:index.php");	exit; }
$event = getEventDescription($conn);
?>
<?php  
// Define path and new folder name 
$create_dir = "images/stall_layout/".$_SESSION['EXHIBITOR_CODE']; 
if (!file_exists($create_dir)) {   mkdir($create_dir, 0777); } 
?>
<?php 
$exhibitor_code=$_SESSION['EXHIBITOR_CODE'];
$qcheck_stand = $conn ->query("select * from iijs_stand where Exhibitor_Code='$exhibitor_code'");
$ncheck_stand = $qcheck_stand->num_rows;

$sqlquery="SELECT * FROM `iijs_catalog` WHERE `Exhibitor_Code`='$exhibitor_code'";
$result1=$conn ->query($sqlquery);
$total_badge = $result1->num_rows;
if($total_badge<=0)
{
	echo '<script type="text/javascript">'; 
	echo 'alert("Please Apply COMPULSORY CATALOGUE FORM to access this form.");'; 
	echo 'window.location.href = "manual_list.php";';
	echo '</script>';	
} 
?>
<?php
$exhibitor_data="select * from iijs_exhibitor where Exhibitor_Code='$exhibitor_code'";
$result = $conn ->query($exhibitor_data);
$fetch_data = $result->fetch_assoc();

$Exhibitor_Name=addslashes($fetch_data['Exhibitor_Name']);
$Exhibitor_Contact_Person=$fetch_data['Exhibitor_Contact_Person'];
$Exhibitor_Phone=$fetch_data['Exhibitor_Phone'];
$Exhibitor_Fax=$fetch_data['Exhibitor_Fax'];

$Exhibitor_StallNo[]="";
// for($i=0;$i<8;$i++){
// 	if($fetch_data["Exhibitor_StallNo".($i+1)]!="")
// 		$Exhibitor_StallNo[$i]=$fetch_data["Exhibitor_StallNo".($i+1)];
// }
for($i=0;$i<1;$i++){
		if($fetch_data["Exhibitor_StallNo".($i+1)]!="")
			$Exhibitor_StallNo[$i]=$fetch_data["Exhibitor_StallNo".($i+1)];
	}
$stall_no=implode(",",$Exhibitor_StallNo);

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
	
$default_custom_layout=$Exhibitor_Area.".png";

/*...............................Set Default Layout..................................*/
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

//echo '----------'.$default_custom_layout;
$sql = "select * from iijs_stall_master where Exhibitor_Code='$exhibitor_code'";
$result = $conn ->query($sql);
$rows = $result->fetch_assoc();
$num_rows= $result->num_rows;

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
// if(isset($option_lay)){
// 	//echo $option_lay;exit;
// 	if(isset($specific_area)){
// 		$area = $default_custom_layout;
// 		$default_custom_layout = "option".$option_lay."_".$specific_area.$area;
// 	} else{
// 		$default_custom_layout = "option".$option_lay."_".$area;
// 	}
// }
//echo $default_custom_layout
?>

<?php 

$action=$_REQUEST['action'];
if($action=='ADD')
{
	
	if($num_rows==0)
	{
		$EXHIBITOR_CODE=$_REQUEST['EXHIBITOR_CODE'];
		$option_layout=$_REQUEST['option_layout'];
		$Stall_Display_Light=$_REQUEST['Stall_Display_Light'][0];
		$Stall_Display_Light_d=$_REQUEST['Stall_Display_Light_d'][0];
		$Stall_Image_Layout_Type=$_REQUEST['Stall_Image_Layout_Type'][0];
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
			$ext = pathinfo($file_name, PATHINFO_EXTENSION);
			if($ext == 'php'){
				echo '<script>alert("File is not valid")</script>';
			}
			if($_FILES['Stall_CustomizedLayout_Image']['name']!="")
			{
				$Stall_CustomizedLayout_Image=uploadImage($file_name,$file_temp,$file_type,$file_size,$attach,"stall_layout");
			}
		}
		//echo $Stall_CustomizedLayout_Image."--".$Stall_Image_Layout_Type; exit;
		
		if($Stall_CustomizedLayout_Image=="" && $Stall_Image_Layout_Type=='Custom')
		{
		echo '<script type="text/javascript">'; 
		echo 'alert("Invalid File,Kindly Upload file in .jpg,.png formate only.");';
		echo 'window.location.href = "stall_layout.php";';
		echo '</script>';
		
		exit;
		}else
		{
		$sql_insert="insert into iijs_stall_master set Exhibitor_Code='$exhibitor_code',Stall_CustomizedLayout_Image='$Stall_CustomizedLayout_Image',Stall_Display_Light='$Stall_Display_Light',Stall_Display_Light_d='$Stall_Display_Light_d',Stall_Image_Layout_Type='$Stall_Image_Layout_Type', Stall_Basic_Layout_Approved='P', Create_Date=NOW(), Application_Complete='P',`option`='$option_layout',Option_Image_Path='$option_image_path'";
		$execute=$conn ->query($sql_insert);
		if(!$execute) die ($conn->error);
		
		/*.......................................Send mail to users mail id...............................................*/
		 $message ='<table width="96%" bgcolor="#fbfbfb" style="margin:2% auto; border:2px solid #ddd; font-family:Arial, sans-serif; color:#333333; font-size:13px; border-radius:10px;">
		
		<tr>
		<td style="padding:30px;">
		<table width="100%" border="0px" background="#fbfbfb" cellpadding="0px" cellspacing="0px">
		
		<tr>
		<td align="left" height="60px"><img src="https://gjepc.org/assets/images/logo.png" border="0" width="220" /></td>
		<td align="right" height="60px"><img src="https://registration.gjepc.org/manual_signature/images/SIGNATURE-LOGO-4.jpg" border="0"/></td>
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
		<p>Thank  you for applying Online for <strong>Form No. 4. STALL LAYOUT</strong>. Please note your application is under approval process. </p>
		<p>A system generated notification will be sent to you on successful Approval/Disapproval of your application</p>
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
		///$to ='rohit@kwebmaker.com';
		$subject = " ".$event." Exhibitor Manual - Form No. 4. STALL LAYOUT"; 
		$headers  = 'MIME-Version: 1.0' . "\n"; 
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n"; 
		$headers .= 'From:  "'.$event.'" <admin@gjepc.org>';			
		mail($to, $subject, $message, $headers);
		}
		
	} else
	{
		
		$EXHIBITOR_CODE=$_REQUEST['EXHIBITOR_CODE'];
		$Stall_Display_Light=$_REQUEST['Stall_Display_Light'][0];
		$Stall_Display_Light_d=$_REQUEST['Stall_Display_Light_d'][0];
		$Stall_Image_Layout_Type=$_REQUEST['Stall_Image_Layout_Type'][0];
		if(isset($_POST['option_layout'])) {
			$option_layout = $_POST['option_layout'];
		} else {
			$option_layout = '';
		}
		if($Stall_Image_Layout_Type=='Layout1')
		{
			$Stall_CustomizedLayout_Image="";
		}
		$option_image_path = $_REQUEST['option_image_path'];
		//Unlink the previuos image
		   $qpreviousimg=$conn ->query("select Stall_CustomizedLayout_Image from iijs_stall_master where Exhibitor_Code='$exhibitor_code'");
		   $rpreviousimg= $qpreviousimg->fetch_assoc();
		   $filename="images/stall_layout/".$_SESSION['EXHIBITOR_CODE']."/".$rpreviousimg['Stall_CustomizedLayout_Image'];
		   unlink($filename);
		   
		if(isset($_FILES['Stall_CustomizedLayout_Image']) && $_FILES['Stall_CustomizedLayout_Image']['name']!="")
		{
			$file_name=$_FILES['Stall_CustomizedLayout_Image']['name'];
			$file_temp=$_FILES['Stall_CustomizedLayout_Image']['tmp_name'];
			$file_type=$_FILES['Stall_CustomizedLayout_Image']['type'];
			$file_size=$_FILES['Stall_CustomizedLayout_Image']['size'];
			$attach="SL";
			if($_FILES['Stall_CustomizedLayout_Image']['name']!="")
			{
				$Stall_CustomizedLayout_Image=uploadImage($file_name,$file_temp,$file_type,$file_size,$attach,"stall_layout");
				
			}
			if($Stall_CustomizedLayout_Image=="" && $Stall_Image_Layout_Type=='Custom')
			{
			echo '<script type="text/javascript">'; 
			echo 'alert("Invalid File,Kindly Upload file in .jpg,.png formate only.");'; 
			echo 'window.location.href = "stall_layout.php";';
			echo '</script>';
			exit;
			}else
			{
			$sql_insert="update iijs_stall_master set Stall_CustomizedLayout_Image='$Stall_CustomizedLayout_Image',Stall_Display_Light='$Stall_Display_Light',Stall_Display_Light_d='$Stall_Display_Light_d',Stall_Image_Layout_Type='$Stall_Image_Layout_Type',`option`='$option_layout',Stall_Basic_Layout_Approved='P',Stall_Basic_Layout_Reason='',Application_Complete='P',Option_Image_Path='$option_image_path' where Exhibitor_Code='$exhibitor_code'";
			$execute=$conn ->query($sql_insert);
			if(!$execute) die ($conn->error);
			}
		}
}
	echo '<script type="text/javascript">'; 
	echo 'alert("Stall Layout Upload Successfully.");'; 
	echo 'window.location.href = "manual_list.php";';
	echo '</script>';
	
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Stall Layout</title>
<link rel="stylesheet" type="text/css" href="css/mystyle.css" />
<!--navigation script-->
<script type="text/javascript" src="../js/jquery_002.js"></script>
<!--<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>    -->  
<!-- place holder script for ie -->

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
<!-------------------fancybox----------------->
	<script type="text/javascript" src="../fancybox/jquery.fancybox-1.3.4.pack.js"></script>
	<link rel="stylesheet" type="text/css" href="../fancybox/jquery.fancybox-1.3.4.css" media="screen" />
	<script type="text/javascript">
		$(document).ready(function() {
			$(".example2").fancybox({
				'overlayShow'	: true,
				'transitionIn'	: 'elastic',
				'transitionOut'	: 'elastic'
			});
			$("a[rel=example_group]").fancybox({
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'titlePosition' 	: 'over',
				'titleFormat'		: function(title, currentArray, currentIndex, currentOpts) {
					return '<span id="fancybox-title-over">Image ' + (currentIndex + 1) + ' / ' + currentArray.length + (title.length ? ' &nbsp; ' + title : '') + '</span>';
				}
			});
		});
</script>
 <!--fancybox ends-->
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
	if($('input[name="Stall_Display_Light[]"]:checked').length == 0)
		{
			alert("Please Select Stall General Light.");
			document.getElementById('Stall_Display_Light').focus();
			return false;
		}
		
	if($('input[name="Stall_Display_Light_d[]"]:checked').length == 0)
		{
			alert("Please Select Stall Display Light.");
			document.getElementById('Stall_Display_Light_d').focus();
			return false;
		}	
	
	if($('input[name="Stall_Image_Layout_Type[]"]:checked').length == 0)
		{
			alert("Please Select Layout Type.");
			document.getElementById('Stall_Image_Layout_Type').focus();
			return false;
		}
	
	if($('input[name=\'Stall_Image_Layout_Type[]\']:checked').val() == "Custom")
	{
		if(document.getElementById('Stall_CustomizedLayout_Image').value=="")
		{
			alert("Please Upload Customize Layout");
			document.getElementById('Stall_CustomizedLayout_Image').focus();
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
	var option_lay = "<?php echo $option_lay; ?>";
	
	$(document).ready(function(){
		$('.not_clickable').click(function(){
			// $("#option_one").removeClass("option");
			// $("#option_two").removeClass("option");
			// $("#option_three").removeClass("option");
			// $("#option_Four").removeClass("option");
			alert("You Cannot Modify The Selection.");
			window.location.reload();
			//return false;
		});
		console.log(option_lay);
		if(option_lay == ""){
			$('#option_table_one').hide();
			$('#option_table_two').hide();
			$('#option_table_three').hide();
			$('#option_table_four').hide();
			$('#option_table').hide();
			$('#machinery_table').hide();
		}
	//var option_image = ''; 
	if(option_lay != null && option_lay != undefined && option_lay != ''){

		if(option_lay == "1"){
			$('#option_table_one').show();
			$('#option_table_two').hide();
			$('#option_table_three').hide();
			$('#option_table_four').hide();
			$('#option_table').hide();
			$('#machinery_table').hide();
		} else if(option_lay == "2"){
			$('#option_table_two').show();
			$('#option_table_one').hide();
			$('#option_table_three').hide();
			$('#option_table_four').hide();
			$('#option_table').hide();
			$('#machinery_table').hide();
		} else if(option_lay == "3") {
			$('#option_table_three').show();
			$('#option_table_one').hide();
			$('#option_table_two').hide();
			$('#option_table_four').hide();
			$('#option_table').hide();
			$('#machinery_table').hide();
		} else if(option_lay == "4"){
			$('#option_table_four').show();
			$('#option_table_one').hide();
			$('#option_table_two').hide();
			$('#option_table_three').hide();
			$('#option_table').hide();
			$('#machinery_table').hide();
		} else if(option_lay == "2a"){
			$('#option_table_four').show();
			$('#option_table_one').hide();
			$('#option_table_two').hide();
			$('#option_table_three').hide();
			$('#option_table').hide();
			$('#machinery_table').hide();
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
				if(specific_area != '' && specific_area != undefined && specific_area != null ){
					var images = 'images/stall_layout/layout/'+'option1_'+specific_area+option_image;
		    		$(".image_change").attr('src', images);
		    		$(".example2").attr("href", 'images/stall_layout/layout/'+'option1_'+specific_area+option_image);
		    		$("#option_image_path").val(images);
				} else {
					var images = 'images/stall_layout/layout/'+'option1_'+option_image;
		    		$(".image_change").attr('src', images);
		    		$(".example2").attr("href", 'images/stall_layout/layout/'+'option1_'+option_image);
		    		$("#option_image_path").val(images);
				}
				
			}
			if(option == 2){
				$('#option_table').hide();
				$('#option_table_one').hide();
				$('#option_table_three').hide();
				$('#option_table_four').hide();
				$('#option_table_two').show();
				if(specific_area != '' && specific_area != undefined && specific_area != null ){
					var images = 'images/stall_layout/layout/'+'option2_'+specific_area+option_image;
		    		$(".image_change").attr('src', images)
		    		$(".example2").attr("href", 'images/stall_layout/layout/'+'option2_'+specific_area+option_image);
		    		$("#option_image_path").val(images);
				} else {
					var images = 'images/stall_layout/layout/'+'option2_'+option_image;
		    		$(".image_change").attr('src', images)
		    		$(".example2").attr("href", 'images/stall_layout/layout/'+'option2_'+option_image);
		    		$("#option_image_path").val(images);
				}
				
			}
			if(option == 3){
				$('#option_table').hide();
				$('#option_table_one').hide();
				$('#option_table_three').show();
				$('#option_table_four').hide();
				$('#option_table_two').hide();
				if(specific_area != '' && specific_area != undefined && specific_area != null  ){
					var images = 'images/stall_layout/layout/'+'option3_'+specific_area+option_image;
		    		$(".image_change").attr('src', images)
		    		$(".example2").attr("href", 'images/stall_layout/layout/'+'option3_'+specific_area+option_image);
		    		$("#option_image_path").val(images);
				} else {
					var images = 'images/stall_layout/layout/'+'option3_'+option_image;
		    		$(".image_change").attr('src', images)
		    		$(".example2").attr("href", 'images/stall_layout/layout/'+'option3_'+option_image);
		    		$("#option_image_path").val(images);
				}
				
			}if(option == 4){
				$('#option_table').hide();
				$('#option_table_one').hide();
				$('#option_table_three').hide();
				$('#option_table_four').show();
				$('#option_table_two').hide();
				if(specific_area != '' && specific_area != undefined && specific_area != null ){
					var images = 'images/stall_layout/layout/'+'option4_'+specific_area+option_image;
		    		$(".image_change").attr('src', images)
		    		$(".example2").attr("href", 'images/stall_layout/layout/'+'option4_'+specific_area+option_image);
		    		$("#option_image_path").val(images);
				} else {
					var images = 'images/stall_layout/layout/'+'option4_'+option_image;
		    		$(".image_change").attr('src', images)
		    		$(".example2").attr("href", 'images/stall_layout/layout/'+'option4_'+option_image);
		    		$("#option_image_path").val(images);
				}
				
			}if(option == '2a'){
				$('#option_table').hide();
				$('#option_table_one').hide();
				$('#option_table_three').hide();
				$('#option_table_four').hide();
				$('#option_table_two').show();
				if(specific_area != '' && specific_area != undefined && specific_area != null ){
					var images = 'images/stall_layout/layout/'+'option2a_'+specific_area+option_image;
		    		$(".image_change").attr('src', images)
		    		$(".example2").attr("href", 'images/stall_layout/layout/'+'option2a_'+specific_area+option_image);
		    		$("#option_image_path").val(images);
				} else {
					var images = 'images/stall_layout/layout/'+'option2a_'+option_image;
		    		$(".image_change").attr('src', images)
		    		$(".example2").attr("href", 'images/stall_layout/layout/'+'option2a_'+option_image);
		    		$("#option_image_path").val(images);
				}
			}
		}
		
		//x = clasvar.split(' ');
		//registration_id = x[1];
			// $.ajax({ 		
			// 			type: 'POST',
			// 			data : {option : option},
			// 			url: 'stall_layout.php',
			// 			dataType:'json',
			// 			success: function(data){
			// 					console.log(data);
			// 						$('.option_table').show();
			// 						$('#status').hide();
			// 					 	$(location).attr('href','final_submisson.php');  
			// 					}
			// });
		});		
	});
</script>
<!--manual form css-->
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
    top: -52%;
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
</head>

<body>
<!-- header starts -->

<div class="header_wrap">
	<?php include ('header.php'); ?>
</div>

<!-- header ends -->
<div class="clear"></div>
<div class="clear"></div>

<div class="container_wrap">
<div class="container" id="manualFormContainer">
<h1>Online Manual </h1>

<div id="formWrapper">
<h3>Stall Layout</h3>

<div class="tooltip"><strong>Note</strong>
<span class="tooltiptext">
<ol class="numeric">
  <li>Please note given below are the pictures of your  basic stall layout. If you would like to change your booth layout, kindly Choose Custom Layout &amp; Upload  your customized stall layout.</li>
  <li>Electrical fittings would remain same as per the  basic stall layout</li>
  <li>Extra furniture / lights shown in layout but not ordered in standfitting form (Form No.3) will not be considered.</li>
</ol>
</span>
</div>

<span style="color:#fff;float:right;" class="spanbox">Deadline : <strong><?php echo getFormDeadLine(4,$conn);?></strong></span>
</style>
<!--
<div class="stall_layput_wrp">
<ul>
    <li> <a href="images/pdf/stall_layout/9sqmtr_stall_branding.pdf" target="_blank" class="maroon_btn"> 9 sqm - New Shell Scheme branding</a> </li>
	<li> <a href="images/pdf/stall_layout/18sqmtr_stall_branding.pdf" target="_blank" class="maroon_btn"> 18 sqm - New Shell Scheme branding</a> </li>    
</ul>
</div>
-->
<form name="form1" action="" method="post" enctype="multipart/form-data" onsubmit="return validation()">
<div class="clear"></div>
<h2>Application Summary</h2>
<table  cellspacing="0" cellpadding="0" class="common">
                                    <tbody>
                                    <tr>                                        
                                        <th valign="top">Date</th>
                                        <th valign="top">Information Status</th>
                                        <th valign="top">Application Status</th>
                                    </tr>
                                  	
                                    <tr>                                        
                                        <td valign="middle">
                                          <?php if($Create_Date==""){ echo "NA"; }else{echo date("d-m-Y",strtotime($Create_Date));} ?></td>
                                        <td valign="middle" class="centerAlign">
                                        <?php  
											if($Stall_Basic_Layout_Approved=='Y')
												echo "<img src='images/correct.png'  alt='' />";
											else if($Stall_Basic_Layout_Approved=='N')
												echo "<img src='images/red_cross.png'  alt='' />";
											else if($Stall_Basic_Layout_Approved=='')
												echo "<img src='images/pending_apply.png'  alt='' />";
											else
												echo "<img src='images/pending.png'  alt='' />";                                   	
                                        ?>
                                       </td>
                                        
                                        <td valign="middle" colspan="1" class="centerAlign">
                                          <?php  
											if($Application_Complete=='Y')
												echo "<img src='images/correct.png'  alt='' />";
											else if($Application_Complete=='N')
												echo "<img src='images/red_cross.png'  alt='' />";
											else if($Application_Complete=='')
												echo "<img src='images/pending_apply.png'  alt='' />";
											else
												echo "<img src='images/pending.png'  alt='' />";
                                        ?>
                                        </td>
                                    </tr>
                                </tbody></table>
                                
<p>The sections marked with an <span class="red">*</span> are compulsory.</p>

<div class="title">
<h4>Exhibitor Information</h4>
</div>
<div class="clear"></div>

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
    <td><?php  echo getSection_desc($Exhibitor_Section,$conn); ?></td>
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
</table>

<div class="title">
<h4>Basic Furniture</h4>
</div>
<div class="clear"></div>
<?php if($getSection != "machinery") { ?>
	<input type="radio" id="option_one" class="option <?php if($option_lay!=""){echo 'not_clickable' ;} ?>" name="option_layout" value="1"  <?php if($option_lay=="1"){echo "checked='checked'" ;} ?> <?php if($option_lay!='' || $option_lay=='1' ) {echo 'readonly=readonly';} ?> >
	<label for="option_one">Option One</label>

	<input type="radio" id="option_two" class="option <?php if($option_lay!=""){echo 'not_clickable' ;} ?>" name="option_layout" value="2"  <?php if($option_lay=="2"){echo "checked='checked'" ;} ?> <?php if($option_lay!='' || $option_lay=='2' ) {echo 'readonly=readonly';} ?> >
	<label for="option_two">Option Two</label>

	<input type="radio" id="option_three" class="option <?php if($option_lay!=""){echo 'not_clickable' ;} ?>" name="option_layout" value="3"  <?php if($option_lay=="3"){echo "checked='checked'" ;} ?> <?php if($option_lay!='' || $option_lay=='3' ) {echo 'readonly=readonly';} ?> >
	<label for="option_three">Option Three</label>

	<input type="radio" id="option_Four" class="option <?php if($option_lay!=""){echo 'not_clickable' ;} ?>" name="option_layout" value="4" <?php if($option_lay=="4"){echo "checked='checked'" ;} ?> <?php if($option_lay!='' || $option_lay=='4' ) {echo 'readonly=readonly';} ?> >
	<label for="option_Four">Option Four</label>

	<?php /*if($Exhibitor_Area >= 27){?>
		 <input type="radio" id="option_2a" class="option <?php if($option_lay!=""){echo 'not_clickable' ;} ?>" name="option_layout" value="2a" <?php if($option_lay=="2a"){echo "checked='checked'" ;} ?> <?php if($option_lay!='' || $option_lay=='2a' ) {echo 'readonly=readonly';} ?> >
		<label for="option_2a">Option 2a</label> 
	<?php }*/ ?>
<?php } ?>
<!-- <table border="0" cellspacing="0" cellpadding="0" id="option_table" class="formManual tableBorder">  
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
	
	// if(isset($_POST['option'])){
	// 	$option = trim($_POST['option']);
		
	// 	if($option != '' || $option != null ){
	// 		$sql = "SELECT * FROM iijs_stall_basic_furniture where `option`='$option' ";
	// 		$result1 = $conn ->query($sql);
	// 		$rows1 = $result1->fetch_assoc(); 
	// 		$data = array('status' =>'success','data' => $rows1);
	// 		echo json_encode($data);exit;	
	// 	} else{
	// 		$sql = "SELECT * FROM iijs_stall_basic_furniture";
	// 		$result1 = $conn ->query($sql);
	// 		$rows1 = $result1->fetch_assoc();
	// 		$data = array('status' =>'success','data' => $rows1);
	// 		echo json_encode($data);exit;		
	// 	}	
		
	// }	
	// $sql = "SELECT * FROM iijs_stall_basic_furniture";
	// $result1 = $conn ->query($sql);
	// $rows1 = $result1->fetch_assoc();
	// if($Exhibitor_HallNo=="2" || $Exhibitor_HallNo=="4" || $Exhibitor_HallNo=="5" || $Exhibitor_HallNo=="")
	// {
	//   $sql1="SELECT * FROM iijs_stall_basic_furniture where hall='All' AND `ex_area`='$Exhibitor_Area'";
	// }
	// else if($Exhibitor_HallNo=="3")
	// {
	//   $sql1="SELECT * FROM iijs_stall_basic_furniture where hall='3' AND `ex_area`='$Exhibitor_Area'";
	// }
	// else
	// {
	// $sql1="SELECT * FROM iijs_stall_basic_furniture where hall='1' AND `ex_area`='$Exhibitor_Area'";
	// }	
	//echo $sql1;
    //  	$result1 = $conn ->query($sql1);
	// $rows1 = $result1->fetch_assoc(); 
	?>
  
	<?php
	if($Exhibitor_HallNo=="2" || $Exhibitor_HallNo=="4" || $Exhibitor_HallNo=="5" || $Exhibitor_HallNo=="")
	{
	?>
  <tr>
    <th colspan="10" class="bold" align="center" style="text-align:center;"><strong><?php //echo $Exhibitor_Section; ?> - <?php //echo $Exhibitor_Area; ?>sqmt (<?php //echo $Exhibitor_StallType;?>)</strong></th>
  </tr>
  <tr>
    <td class="bold" width="14%">Top glass showcase with 1m channel LED Profile 18 W (2nos), 2 arm/joota lights 5 W (Yellow/White) & lockable storage</td>
    <td class="bold" width="14%">Tall Glass Showcase with 1m channel LED Profile 18 W (2nos), 2 arm/joota lights 5 W (6nos), 6 arm/joota lights (Yellow/White) & lockable storage</td>
    <td class="bold" width="14%">Table (All side Open)</td>
    <td class="bold" width="14%">Novia Chairs</td>
    <td class="bold" width="14%">16 W LED for general lighting (White/Yellow)</td>
    <td class="bold" width="14%">Dustbin with Lid </td>
    <td class="bold" width="14%">Door (36 Sq Mtr & above)</td>
    <td class="bold" width="14%">Plug Point 15 amp (Multi Socket)</td>
  </tr>
  <tr>
 	 <td><?php //echo $rows1['top_glass_showcase'];?></td>
 	 <td><?php //echo $rows1['tall_showcase'];?></td>
    <td><?php //echo $rows1['no_of_table'];?></td>
     <td><?php //echo $rows1['chair'];?></td>
    <td><?php //echo $rows1['cfl'];?></td>
    <td><?php //echo $rows1['dustbin'];?></td>
    <td><?php //echo $rows1['door'];?></td>
    <td><?php //echo $rows1['plug_point'];?></td>
  </tr>
    <?php
	}
	else if($Exhibitor_HallNo=="3" || $Exhibitor_HallNo=="")
	{
	?>
  <tr>
    <th colspan="8" class="bold" align="center" style="text-align:center;"><strong><?php echo $Exhibitor_Section; ?> - <?php echo $Exhibitor_Area; ?>sqmt (<?php echo $Exhibitor_StallType;?>)</strong></th>
  </tr>
  <tr>
    <td class="bold" width="14%">Top glass showcase with 1m channel LED Profile 18 W (2nos), 2 arm/joota lights 5 W (Yellow/White) & lockable storage</td>
    <td class="bold" width="14%">Tall Glass Showcase with 1m channel LED Profile 18 W (2nos), 2 arm/joota lights 5 W (6nos), 6 arm/joota lights (Yellow/White) & lockable storage</td>
    <td class="bold" width="14%">Table (All side Open)</td>
    <td class="bold" width="14%">Novia Chairs</td>
    <td class="bold" width="14%">16 W LED for general lighting (White/Yellow)</td>
    <td class="bold" width="14%">Dustbin with Lid </td>
    <td class="bold" width="14%">Door (36 Sq Mtr & above)</td>
    <td class="bold" width="14%">Plug Point 15 amp (Multi Socket)</td>
  </tr>
  <tr>
 	 <td><?php //echo $rows1['top_glass_showcase'];?></td>
 	 <td><?php //echo $rows1['tall_showcase'];?></td>
    <td><?php //echo $rows1['no_of_table'];?></td>
     <td><?php //echo $rows1['chair'];?></td>
    <td><?php //echo $rows1['cfl'];?></td>
    <td><?php //echo $rows1['dustbin'];?></td>
    <td><?php //echo $rows1['door'];?></td>
    <td><?php //echo $rows1['plug_point'];?></td>
  </tr>
    <?php 	
	}  
	else if($Exhibitor_HallNo=="1")
	{
	?>
  <tr>
    <th colspan="8" class="bold" align="center" style="text-align:center;"><strong><?php   //echo $Exhibitor_Section; ?> - <?php e//cho $Exhibitor_Area; ?>sqmt (<?php //echo $Exhibitor_StallType;?>)</strong></th>
  </tr>
  <tr>
    <td class="bold" width="14%">Top Glass Showcase 2 arm/joota lights & lockable storage (Yellow/White)</td>
    <td class="bold" width="14%">Table (All side Open)</td>
    <td class="bold" width="14%">Chairs</td>
    <td class="bold" width="14%">16 W LED for general lighting (White/Yellow)</td>
    <td class="bold" width="14%">Dustbin with Lid</td>
    <td class="bold" width="14%">Plug Point 15 amp</td>
  </tr>
  <tr>
 	 <td><?php //echo $rows1['top_glass_showcase'];?></td>
    <td><?php //echo $rows1['no_of_table'];?></td>
     <td><?php //echo $rows1['chair'];?></td>
    <td><?php //echo $rows1['cfl'];?></td>
    <td><?php //echo $rows1['dustbin'];?></td>
    <td><?php //echo $rows1['plug_point'];?></td>
  </tr>
    <?php 
	} ?>
</table> -->
<div class="title"><h4>Stall Layout</h4></div>
<div class="clear"></div>


<style>
	.stall_layput_wrp {margin-bottom: 15px; width: 100%;}
	.stall_layput_wrp ul {display:block; padding-left:0;}
	.stall_layput_wrp ul li {display:inline-block;}
	.stall_layput_wrp ul li a.maroon_btn {display:block!important; font-weight:normal!important; border-radius:0!important; transition:all 0.3s ease-in-out; -webkit-transition:all 0.3s ease-in-out; -moz-transition:all 0.3s ease-in-out; -o-transition:all 0.3s ease-in-out;}
	.stall_layput_wrp ul li a.maroon_btn:hover {transition:all 0.3s ease-in-out; -webkit-transition:all 0.3s ease-in-out; -moz-transition:all 0.3s ease-in-out; -o-transition:all 0.3s ease-in-out;}
</style>
<!--
<div class="stall_layput_wrp">
<ul>
    <li> <a href="images/pdf/stall_layout/9sqmtr_stall_branding.pdf" target="_blank" class="maroon_btn"> 9 sqm - New Shell Scheme branding</a> </li>
	<li> <a href="images/pdf/stall_layout/18sqmtr_stall_branding.pdf" target="_blank" class="maroon_btn"> 18 sqm - New Shell Scheme branding</a> </li>   
</ul>
</div>
-->

<table border="0" cellspacing="0" cellpadding="0" class="formManual" style="margin-bottom:0px;">
  <tr>
  	<?php if(isset($option_image_path) && $option_image_path != null){ ?>
    	<td width="24%"><div class="boothImage"><img src="<?php echo $option_image_path;?>" class="image_change" alt="" width="149" height="140" />
    	<input type="hidden" name="option_image_path" id="option_image_path" value="<?php echo $option_image_path; ?>" ></div></td>
    <?php } else {?>
    	<td width="24%"><div class="boothImage"><img src="images/stall_layout/layout/<?php echo $default_custom_layout;?>" class="image_change" alt="" width="149" height="140" />
    	<input type="hidden" name="option_image_path" id="option_image_path" value="<?php echo "images/stall_layout/layout".$default_custom_layout; ?>" ></div></td>
    <?php } ?>	
	
    <td width="28%">
   	<div style="float:left; margin-right:10px;">
      <input name="Stall_Image_Layout_Type[]" id="Stall_Image_Layout_Type2" type="radio" value="Layout1" onchange="check_disable()" <?php if($Stall_Basic_Layout_Approved=='Y' || $Stall_Basic_Layout_Approved=='P' ) {echo 'disabled=disabled';} if($Stall_Image_Layout_Type=="Layout1") ?> <?php if($Stall_Image_Layout_Type=="Layout1"){echo "checked='checked'";}?>/>
    </div>
    
    <div style="float:left;">Choose Layout 1 Normal</div>    
    <div class="clear bottomSpace"></div>
   	<?php if(isset($option_image_path) && $option_image_path != null){ ?>
	    <div><a class="example2" href="<?php echo $option_image_path;?>" target="_blank">
	      <input name="input" type="button" value="View Image" class="maroon_btn" />
	    </a><a class="example2" href="<?php echo $option_image_path;?>" target="_blank"></a></div>    </td>
    <?php } else { ?>
    	 <div><a class="example2" href="images/stall_layout/layout/<?php echo $default_custom_layout;?>" target="_blank">
	      <input name="input" type="button" value="View Image" class="maroon_btn" />
	    </a><a class="example2" href="images/stall_layout/layout/<?php echo $default_custom_layout;?>" target="_blank"></a></div>    </td>
    <?php } ?>	
	
    <td width="2%">&nbsp;</td>
	<td width="24%"><img src="<?php if($Stall_CustomizedLayout_Image==""){ ?> images/stall_layout/template/<?php echo $default_custom_layout;?>"<?php }else{?>images/stall_layout/<?php echo $_SESSION['EXHIBITOR_CODE'];?>/<?php echo $Stall_CustomizedLayout_Image;?><?php }?>" width="149" height="140" alt="" /></td>
    <!--<td width="24%"><img src="<?php if($Stall_CustomizedLayout_Image==""){ echo "images/customeImage.jpg";}else{?>images/stall_layout/<?php echo $_SESSION['EXHIBITOR_CODE'];?>/<?php echo $Stall_CustomizedLayout_Image;?><?php }?>" width="149" height="140" alt="" /></td>-->
    <td width="22%"><div style="float:left; margin-right:10px;"><input name="Stall_Image_Layout_Type[]" id="Stall_Image_Layout_Type" type="radio" value="Custom" onchange="check_disable()" <?php if($Stall_Basic_Layout_Approved=='Y' || $Stall_Basic_Layout_Approved=='P') {echo 'disabled=disabled';} ?> <?php if($Stall_Image_Layout_Type=="Custom"){echo "checked='checked'";}?> /></div>
    
    <div style="float:left;">Choose Custome Layout</div>
    <div class="clear bottomSpace"></div>
    
    <?php if($Stall_CustomizedLayout_Image!=""){?>
    <div><a class="example2" href="images/stall_layout/<?php echo $_SESSION['EXHIBITOR_CODE'];?>/<?php echo $Stall_CustomizedLayout_Image;?>" target="_blank"><input name="input4" type="button" value="View Image" class="maroon_btn" /></a></div>
    <?php }else{ ?>
	<?php /*?><div><a class="example2" href="images/stall_layout/template/<?php echo $default_custom_layout;//$default_custom_template;?>" target="_blank"><input name="input4" type="button" value="Download Template" class="maroon_btn" /></a></div><?php */?>
	<?php }?>    </td>
  </tr>
</table>

<div id="custom_lay" <?php if($Stall_Basic_Layout_Approved!='N'){?>style="display:none;"<?php }?>>
<table border="0" cellspacing="0" cellpadding="0" class="formManual">
  <tr>
    <td width="42%"><strong>Upload your customized stall layout</strong></td>
    <td width="58%"><div class="chooseButton"><input type="file" name="Stall_CustomizedLayout_Image" id="Stall_CustomizedLayout_Image" class="textField" <?php if($Stall_Basic_Layout_Approved=='Y' || $Stall_Basic_Layout_Approved=='P') {echo 'disabled=disabled';} ?> /></div></td>
    <td width="17%">&nbsp;</td>
    </tr>
</table>
</div>
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
	    <td class="bold" width="14%">Tall Showcases</td>
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

<input type="hidden" name="action" value="ADD" />
<input type="hidden" name="EXHIBITOR_CODE" id="EXHIBITOR_CODE" value="<?php echo $_SESSION['EXHIBITOR_CODE'];?>" />

<div class="title"><h4>Stall & Display Lights</h4></div>
<div class="clear"></div>
<table border="0" cellspacing="0" cellpadding="0" class="formManual">
  <tr>
    <td width="60%"><strong>Stall and display lights for your booth (General) :</strong></td>
    <td width="40%"><input name="Stall_Display_Light[]" id="Stall_Display_Light" type="radio" value="0" <?php if($Stall_Basic_Layout_Approved=='Y' || $Stall_Basic_Layout_Approved=='P') {echo 'disabled=disabled';} ?> <?php if($Stall_Display_Light=="0"){echo "checked='checked'";}?> />White
    <input name="Stall_Display_Light[]" id="Stall_Display_Light" type="radio" value="1" <?php if($Stall_Basic_Layout_Approved=='Y' || $Stall_Basic_Layout_Approved=='P') {echo 'disabled=disabled';} ?> <?php if($Stall_Display_Light=="1"){echo "checked='checked'";}?> />Yellow</td>    
  </tr>
  <tr>
    <td width="60%"><strong>Stall and display lights for your booth (Display) :</strong></td>
    <td width="40%"><input name="Stall_Display_Light_d[]" id="Stall_Display_Light_d" type="radio" value="0" <?php if($Stall_Basic_Layout_Approved=='Y' || $Stall_Basic_Layout_Approved=='P') {echo 'disabled=disabled';} ?> <?php if($Stall_Display_Light_d=="0"){echo "checked='checked'";}?> />White
    <input name="Stall_Display_Light_d[]" id="Stall_Display_Light_d" type="radio" value="1" <?php if($Stall_Basic_Layout_Approved=='Y' || $Stall_Basic_Layout_Approved=='P') {echo 'disabled=disabled';} ?> <?php if($Stall_Display_Light_d=="1"){echo "checked='checked'";}?> />Yellow</td>   
  </tr>
</table>

<br/>
<div class="title"><h4>Info Approval</h4></div>
<div class="clear"></div>

<table border="0" cellspacing="0" cellpadding="0" class="formManual">
  <tr>
    <td width="150"><strong>Status</strong></td>
    <td>:</td>
    <td>
    <?php 
		if($Stall_Basic_Layout_Approved=='Y')
			echo "<img src='images/correct.png'  alt='' /> &nbsp;&nbsp;Approved";
		else if($Stall_Basic_Layout_Approved=='N')
			echo "<img src='images/red_cross.png'  alt='' /> &nbsp;&nbsp;Disapproved";
		else
			echo "<img src='images/pending.png'  alt='' /> &nbsp;&nbsp;Pending";                                	
    ?>
    </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <?php 
	if($Stall_Basic_Layout_Approved=='N'){?>
  <tr>
    <td><strong>Reason</strong></td>
    <td>:</td>
    <td><?php echo "$Stall_Basic_Layout_Reason"; ?></td>
  </tr>
  <?php }?>
</table>

<div class="clear"></div>
<div align="center">
<?php if($Stall_Basic_Layout_Approved=='N' || $Stall_Basic_Layout_Approved=='' || $_REQUEST['auth']=='admin'){ ?>

<input name="input2" type="submit" value="Submit" class="maroon_btn" />
<a href="manual_list.php"><input name="input2" type="button" value="Cancel" class="maroon_btn" /></a>
<?php } else { ?>
<a href="manual_list.php"><input name="input2" type="button" value="BACK" class="maroon_btn" /></a>
<?php } ?>
<?php /*?><?php if($_GET['permission']=='newEntry'): ?>
<?php else: 
	  if($Stall_Basic_Layout_Approved=='N' ): ?>
			<input name="input2" type="submit" value="Submit" class="maroon_btn" disabled="disabled" />
<?php endif;?><?php */?>
</div>

</form>
</div>

<div class="clear"> </div>
</div>
</div>
<div class="footer_wrap">
<?php include ('footer.php'); ?>
</div>
<!--footer ends-->
</body>
</html>
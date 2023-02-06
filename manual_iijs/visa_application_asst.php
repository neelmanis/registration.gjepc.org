<?php 
include('header_include.php');
if(!isset($_SESSION['EXHIBITOR_CODE']))
{
	header("location:index.php");
	exit;
}
?>
<?php  
// Define path and new folder name 
$create_dir = "images/visa/".$_SESSION['EXHIBITOR_CODE']; 

if (!file_exists($create_dir)) { 
   mkdir($create_dir, 0777);
} 
?>
<?php
$exhibitor_code=$_SESSION['EXHIBITOR_CODE'];

$exhibitor_data="select * from iijs_exhibitor where Exhibitor_Code='$exhibitor_code'";
$result=mysql_query($exhibitor_data);
$fetch_visa=mysql_fetch_array($result);

$Exhibitor_Name=$fetch_visa['Exhibitor_Name'];
$Exhibitor_Contact_Person=$fetch_visa['Exhibitor_Contact_Person'];
$Exhibitor_Phone=$fetch_visa['Exhibitor_Phone'];
$Exhibitor_Fax=$fetch_visa['Exhibitor_Fax'];
$Exhibitor_StallNo[]="";
for($i=0;$i<8;$i++){
	if($fetch_visa["Exhibitor_StallNo".($i+1)]!="")
		$Exhibitor_StallNo[$i]=$fetch_visa["Exhibitor_StallNo".($i+1)];
}
$stall_no=implode(", ",$Exhibitor_StallNo);
$Exhibitor_HallNo=$fetch_visa['Exhibitor_HallNo'];
$Exhibitor_Region=$fetch_visa['Exhibitor_Region'];
$Exhibitor_Section=$fetch_visa['Exhibitor_Section'];
$Exhibitor_Area=$fetch_visa['Exhibitor_Area'];
$Exhibitor_DivisionNo=$fetch_visa['Exhibitor_DivisionNo'];

$visa_data="select * from iijs_visa_application where Exhibitor_Code='$exhibitor_code'";
$result_visa=mysql_query($visa_data);
$fetch_visa=mysql_fetch_array($result_visa);
$num=mysql_num_rows($result_visa);

$Exhibitor_Code=$_SESSION['EXHIBITOR_CODE'];
$Visa_Application_Name=$fetch_visa['Visa_Application_Name'];
$Visa_Application_Gender=$fetch_visa['Visa_Application_Gender'];
$Visa_Application_Nationality=$fetch_visa['Visa_Application_Nationality'];
$Visa_Application_DOB=date('d-m-Y',strtotime($fetch_visa['Visa_Application_DOB']));
$Visa_Application_Designation=$fetch_visa['Visa_Application_Designation'];
$Visa_Application_PassportNo=$fetch_visa['Visa_Application_PassportNo'];
$Visa_Application_Date_of_Issue=date('d-m-Y',strtotime($fetch_visa['Visa_Application_Date_of_Issue']));
$Visa_Application_Date_of_Expiry=date('d-m-Y',strtotime($fetch_visa['Visa_Application_Date_of_Expiry']));
$Visa_Application_Place_of_Issue=$fetch_visa['Visa_Application_Place_of_Issue'];
$Visa_Application_Location=$fetch_visa['Visa_Application_Location'];
$Visa_Application_Indian_Embassy=$fetch_visa['Visa_Application_Indian_Embassy'];
$Visa_Application_Address1=$fetch_visa['Visa_Application_Address1'];
$Visa_Application_City=$fetch_visa['Visa_Application_City'];
$Visa_Application_Country_ID=$fetch_visa['Visa_Application_Country_ID'];
$Visa_Application_Pincode=$fetch_visa['Visa_Application_Pincode'];
$Visa_Application_Telephone=$fetch_visa['Visa_Application_Telephone'];
$Visa_Application_Fax=$fetch_visa['Visa_Application_Fax'];
$Visa_Application_Date=date('d-m-Y',strtotime($fetch_visa['Visa_Application_Date']));
$Visa_Application_Arrival_Date=date('d-m-Y',strtotime($fetch_visa['Visa_Application_Arrival_Date']));
$Visa_Application_Arrival_FlightNo=$fetch_visa['Visa_Application_Arrival_FlightNo'];
$Visa_Application_Arrival_Entry_Port=$fetch_visa['Visa_Application_Arrival_Entry_Port'];
$Visa_Application_Departure_Date=date('d-m-Y',strtotime($fetch_visa['Visa_Application_Departure_Date']));
$Visa_Application_Departure_FlightNo=$fetch_visa['Visa_Application_Departure_FlightNo'];
$Visa_Application_Departure_Port=$fetch_visa['Visa_Application_Departure_Port'];
$Info_Recieved=$fetch_visa['Info_Recieved'];
$Info_Reason=$fetch_visa['Info_Reason'];
$Info_Approved=$fetch_visa['Info_Approved'];
$Application_Complete=$fetch_visa['Application_Complete'];
$passport_pic=$fetch_visa['passport_pic'];
$passport_pic_approved=$fetch_visa['passport_pic_approved'];
$passport_pic_reason=$fetch_visa['passport_pic_reason'];
$Create_Date=$fetch_visa['Create_Date'];




if($_REQUEST['action']=="ADD")
{
		   
	if(isset($_FILES['passport_pic']) && $_FILES['passport_pic']['name']!="")
	{
		//Unlink the previuos image
		$qpreviousimg=mysql_query("select passport_pic from iijs_visa_application where Exhibitor_Code='$exhibitor_code'");
		$rpreviousimg=mysql_fetch_array($qpreviousimg);
		$filename="images/visa/".$_SESSION['EXHIBITOR_CODE']."/".$rpreviousimg['passport_pic'];
		unlink($filename);
	
		$file_name=$_FILES['passport_pic']['name'];
		$file_temp=$_FILES['passport_pic']['tmp_name'];
		$file_type=$_FILES['passport_pic']['type'];
		$file_size=$_FILES['passport_pic']['size'];
		$attach="P";
		if($_FILES['passport_pic']['name']!="")
		{
			$passport_pic=uploadImage($file_name,$file_temp,$file_type,$file_size,$attach,"visa");
		}
		
		$sql_passport_pic="update iijs_visa_application set Modify_Date=NOW(),passport_pic='$passport_pic',passport_pic_approved='P',passport_pic_reason='',Application_Complete='P' where Exhibitor_Code='$exhibitor_code'";
		if(!mysql_query($sql_passport_pic)){
			echo "error ".mysql_error();
		}
	}
	
	if(isset($_POST['Visa_Application_Name']))
	{
		
	$Visa_Application_Name=mysql_real_escape_string($_POST['Visa_Application_Name']);
	$Visa_Application_Gender=$_POST['Visa_Application_Gender'];
	$Visa_Application_Nationality=mysql_real_escape_string($_POST['Visa_Application_Nationality']);
	$Visa_Application_DOB=date("Y-m-d",strtotime($_POST['Visa_Application_DOB']));
	$Visa_Application_Designation=mysql_real_escape_string($_POST['Visa_Application_Designation']);
	$Visa_Application_PassportNo=mysql_real_escape_string($_POST['Visa_Application_PassportNo']);
	$Visa_Application_Date_of_Issue=date("Y-m-d",strtotime($_POST['Visa_Application_Date_of_Issue']));
	$Visa_Application_Date_of_Expiry=date("Y-m-d",strtotime($_POST['Visa_Application_Date_of_Expiry']));
	$Visa_Application_Place_of_Issue=mysql_real_escape_string($_POST['Visa_Application_Place_of_Issue']);
	$Visa_Application_Location=mysql_real_escape_string($_POST['Visa_Application_Location']);
	$Visa_Application_Indian_Embassy=mysql_real_escape_string($_POST['Visa_Application_Indian_Embassy']);
	$Visa_Application_Address1=mysql_real_escape_string($_POST['Visa_Application_Address1']);
	$Visa_Application_City=mysql_real_escape_string($_POST['Visa_Application_City']);
	$Visa_Application_Country_ID=mysql_real_escape_string($_POST['Visa_Application_Country_ID']);
	$Visa_Application_Pincode=mysql_real_escape_string($_POST['Visa_Application_Pincode']);
	$Visa_Application_Telephone=mysql_real_escape_string($_POST['Visa_Application_Telephone']);
	$Visa_Application_Fax=mysql_real_escape_string($_POST['Visa_Application_Fax']);
	$Visa_Application_Date=date("Y-m-d",strtotime($_POST['Visa_Application_Date']));
	$Visa_Application_Arrival_Date=date("Y-m-d",strtotime($_POST['Visa_Application_Arrival_Date']));
	$Visa_Application_Arrival_FlightNo=mysql_real_escape_string($_POST['Visa_Application_Arrival_FlightNo']);
	$Visa_Application_Arrival_Entry_Port=mysql_real_escape_string($_POST['Visa_Application_Arrival_Entry_Port']);
	$Visa_Application_Departure_Date=date("Y-m-d",strtotime($_POST['Visa_Application_Departure_Date']));
	$Visa_Application_Departure_FlightNo=mysql_real_escape_string($_POST['Visa_Application_Departure_FlightNo']);
	$Visa_Application_Departure_Port=mysql_real_escape_string($_POST['Visa_Application_Departure_Port']);
	
	$sql_update="update iijs_visa_application set Visa_Application_Name='$Visa_Application_Name',
									Visa_Application_Gender='$Visa_Application_Gender',
									Visa_Application_Nationality='$Visa_Application_Nationality',
									Visa_Application_DOB='$Visa_Application_DOB',
									Visa_Application_Designation='$Visa_Application_Designation',
									Visa_Application_PassportNo='$Visa_Application_PassportNo',
									Visa_Application_Date_of_Issue='$Visa_Application_Date_of_Issue',
									Visa_Application_Date_of_Expiry='$Visa_Application_Date_of_Expiry',
									Visa_Application_Place_of_Issue='$Visa_Application_Place_of_Issue',
									Visa_Application_Location='$Visa_Application_Location',
									Visa_Application_Indian_Embassy='$Visa_Application_Indian_Embassy',
									Visa_Application_Address1='$Visa_Application_Address1',
									Visa_Application_City='$Visa_Application_City',
									Visa_Application_Country_ID='$Visa_Application_Country_ID',
									Visa_Application_Pincode='$Visa_Application_Pincode',
									Visa_Application_Telephone='$Visa_Application_Telephone',
									Visa_Application_Fax='$Visa_Application_Fax',
									Visa_Application_Date='$Visa_Application_Date',
									Visa_Application_Arrival_Date='$Visa_Application_Arrival_Date',
									Visa_Application_Arrival_FlightNo='$Visa_Application_Arrival_FlightNo',
									Visa_Application_Arrival_Entry_Port='$Visa_Application_Arrival_Entry_Port',
									Visa_Application_Departure_Date='$Visa_Application_Departure_Date',
									Visa_Application_Departure_FlightNo='$Visa_Application_Departure_FlightNo',
									Info_Approved='P',
									Info_Reason='',
									Application_Complete='P',
									Modify_Date=NOW(),
									Visa_Application_Departure_Port='$Visa_Application_Departure_Port' where Exhibitor_Code='$exhibitor_code'";
									
	$sql_insert="insert into iijs_visa_application set Exhibitor_Code='$exhibitor_code',	
									Visa_Application_Name='$Visa_Application_Name',
									Visa_Application_Gender='$Visa_Application_Gender',
									Visa_Application_Nationality='$Visa_Application_Nationality',
									Visa_Application_DOB='$Visa_Application_DOB',
									Visa_Application_Designation='$Visa_Application_Designation',
									Visa_Application_PassportNo='$Visa_Application_PassportNo',
									Visa_Application_Date_of_Issue='$Visa_Application_Date_of_Issue',
									passport_pic='$passport_pic',
									Visa_Application_Date_of_Expiry='$Visa_Application_Date_of_Expiry',
									Visa_Application_Place_of_Issue='$Visa_Application_Place_of_Issue',
									Visa_Application_Location='$Visa_Application_Location',
									Visa_Application_Indian_Embassy='$Visa_Application_Indian_Embassy',
									Visa_Application_Address1='$Visa_Application_Address1',
									Visa_Application_City='$Visa_Application_City',
									Visa_Application_Country_ID='$Visa_Application_Country_ID',
									Visa_Application_Pincode='$Visa_Application_Pincode',
									Visa_Application_Telephone='$Visa_Application_Telephone',
									Visa_Application_Fax='$Visa_Application_Fax',
									Visa_Application_Date='$Visa_Application_Date',
									Visa_Application_Arrival_Date='$Visa_Application_Arrival_Date',
									Visa_Application_Arrival_FlightNo='$Visa_Application_Arrival_FlightNo',
									Visa_Application_Arrival_Entry_Port='$Visa_Application_Arrival_Entry_Port',
									Visa_Application_Departure_Date='$Visa_Application_Departure_Date',
									Visa_Application_Departure_FlightNo='$Visa_Application_Departure_FlightNo',
									Info_Recieved='Y',
									Application_Complete='P',
									Create_Date=NOW(),
									Visa_Application_Departure_Port='$Visa_Application_Departure_Port'";
									
	
				if($num>0)
				{
					if(!mysql_query($sql_update))
						echo "error ".mysql_error();
				}
				else
				{
					if(!mysql_query($sql_insert))
						echo "error ".mysql_error();
					/*.......................................Send mail to users mail id...............................................*/
					$message ='<table width="96%" bgcolor="#fbfbfb" style="margin:2% auto; border:2px solid #ddd; font-family:Arial, sans-serif; color:#333333; font-size:13px; border-radius:10px;">
					
					<tr>
					<td style="padding:30px;">
					<table width="100%" border="0px" background="#fbfbfb" cellpadding="0px" cellspacing="0px">
					
					<tr>
					<td align="left" height="60px"><img src="http://iijs-signature.org/images/logo.png" border="0" width="230" /></td>
					<td align="right" height="60px"><img src="http://iijs-signature.org/images/gjepc_logo.png" width="120" border="0"/></td>
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
					<p>Thank  you for applying Online for <strong>Form No. 14. VISA APPLICATION ASSISTANCE</strong>. Please note your  application is under approval process. </p>
					<p>All the applicant members will have to send the  requisite payment along with the print acknowledgement receipt which will be  available after successful submission of online application with company seal  in 4 working days from date of online submission.</p>
					<p>A  system generated notification will be sent to you on successful  approval/Disapproval of your application</p>
					<p>Kind regards, <br />
					<strong>Signature Web Team,</strong>
					</p>
					</td>
					</tr>
				
					<tr>
					<td colspan="2" align="center" style="font-size:13px; line-height:22px;">    
					</td>
					</tr>
					</table>
					</td>
					
					<map name="Map" id="Map"><area shape="rect" coords="0,0,185,67" href="http://www.iijs-signature.org/"  target="_blank" style="outline:none;"/><area shape="rect" coords="82,58,83,71" href="#" /></map>
					<map name="Map2" id="Map2"><area shape="rect" coords="2,0,312,68" href="http://www.gjepc.org/"  target="_blank" style="outline:none;" /></map>
					
					</tr>
					
					</table>';
					
					$to =$Exhibitor_Email.',notification@gjepcindia.com';
					$subject = "Signature 2016 Exhibitor Manual - Form No. 14. VISA APPLICATION ASSISTANCE"; 
					$headers  = 'MIME-Version: 1.0' . "\r\n"; 
					$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"; 
					$headers .= 'From:admin@gjepc.org';			
					mail($to, $subject, $message, $headers);

				}	
	}
	echo '<script type="text/javascript">'; 
	echo 'alert("You have successfully submitted your application.");'; 
	echo 'window.location.href = "list.php";';
	echo '</script>';
}




?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome to SIGNATURE</title>

<link rel="stylesheet" type="text/css" href="../css/mystyle.css" />

<!--navigation script-->
<script type="text/javascript" src="../js/jquery_002.js"></script>
<!--<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>    -->  

<link rel="stylesheet" type="text/css" href="../css/ddsmoothmenu.css" />

<script type="text/javascript" src="../js/ddsmoothmenu.js">
</script>

<script type="text/javascript">

ddsmoothmenu.init({
	mainmenuid: "smoothmenu1", //menu DIV id
	orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"
	classname: 'ddsmoothmenu', //class added to menu's outer DIV
	//customtheme: ["#1c5a80", "#18374a"],
	contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
})

</script>

<!--navigation script end-->


<!-- small slider -->
	<script type="text/javascript" src="../js/jquery.cycle.all.js"></script>

<!-- SLIDER -->
	<script type="text/javascript">
	$(document).ready(function(){ 
	
	$('#imgSlider').cycle({ 
			fx:    'scrollHorz', 
			timeout: 6000, 
			delay: -1000,
			prev:'.prev1',
			next:'.next1', 
		});
	});
	
		


	</script>


<!--  SLIDER ends  -->



<link href="../css/slider.css" rel="stylesheet" type="text/css" />

<script type="text/javascript">
$(function() {
	$("#scroller .item").css("width", 986);
	$("#scroller").scrollable({
			circular: true,
			speed: 1500
	}).autoscroll({ interval: 9000 }).navigator();
	api = $('#scroller').data("scrollable");
	$(window).resize(function() {
		if($('#scroller .items:animated').length == 0) {
			$("#scroller .item").css("width", $(document).width());
			nleft = $(document).width() * (api.getIndex() + 1);
			$("#scroller .items").css("left", "-"+nleft+"px");
		}
	});
});
</script>

<!--  SLIDER Ends  -->



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

	<script type="text/javascript" src="../fancybox/jquery.fancybox-1.3.4.pack.js"></script>
	<link rel="stylesheet" type="text/css" href="../fancybox/jquery.fancybox-1.3.4.css" media="screen" />
 	<link rel="stylesheet" href="../css/style.css" />
	<script type="text/javascript">
		$(document).ready(function() {
			/*
			*   Examples - images
			*/
			
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

<!--manual form css-->

<link rel="stylesheet" type="text/css" href="../css/manual.css"/>

<!-- calendar starts-->
<link rel="stylesheet" href="../calendar/css/jquery-ui.css" />
  <script src="../calendar/js/jquery-1.9.1.js"></script>
  <script src="../calendar/js/jquery-ui.js"></script>
  <!--<link rel="stylesheet" href="/resources/demos/style.css" />-->
  <script>
  $(function() {
    $( ".datepicker" ).datepicker();
  });
  </script>
<!-- calendar ends-->

<script language="javascript">
function validation()
{
	var Visa_Application_Name=document.getElementById('Visa_Application_Name');
	var Visa_Application_Gender=document.getElementById('Visa_Application_Gender');	
	var Visa_Application_Nationality=document.getElementById('Visa_Application_Nationality');
	var Visa_Application_DOB=document.getElementById('Visa_Application_DOB');
	var Visa_Application_Designation=document.getElementById('Visa_Application_Designation');
	var Visa_Application_PassportNo=document.getElementById('Visa_Application_PassportNo');
	var Visa_Application_Date_of_Issue=document.getElementById('Visa_Application_Date_of_Issue');
	var Visa_Application_Date_of_Expiry=document.getElementById('Visa_Application_Date_of_Expiry');
	var Visa_Application_Place_of_Issue=document.getElementById('Visa_Application_Place_of_Issue');
	var passport_pic=document.getElementById('passport_pic');
	var Visa_Application_Address1=document.getElementById('Visa_Application_Address1');
	var Visa_Application_Telephone=document.getElementById('Visa_Application_Telephone');
	var Visa_Application_Pincode=document.getElementById('Visa_Application_Pincode');
	var Visa_Application_City=document.getElementById('Visa_Application_City');
	var Visa_Application_Date=document.getElementById('Visa_Application_Date');
	var Visa_Application_Country_ID=document.getElementById('Visa_Application_Country_ID');
	
	if(Visa_Application_Name.value=="")
	{
		alert("Name Cannot be empty ");
		Visa_Application_Name.focus();
		return false;
	}
	if( $('input[name="Visa_Application_Gender"]:checked').length == 0)
	{
		alert("Please Select Gender");
		return false;
	}
	if(Visa_Application_Nationality.value=="")
	{
		alert("Nationality Cannot be empty ");
		Visa_Application_Nationality.focus();
		return false;
	}
	if(Visa_Application_DOB.value=="")
	{
		alert("DOB Cannot be empty ");
		Visa_Application_DOB.focus();
		return false;
	}
	if(Visa_Application_Designation.value=="")
	{
		alert("Designation Cannot be empty ");
		Visa_Application_Designation.focus();
		return false;
	}
	if(Visa_Application_PassportNo.value=="")
	{
		alert("Passport No. cannot be empty");
		Visa_Application_PassportNo.focus();
		return false;
	}
	if(Visa_Application_Date_of_Issue.value=="")
	{
		alert("Passport Issue Date Cannot be empty ");
		Visa_Application_Date_of_Issue.focus();
		return false;
	}
	if(Visa_Application_Date_of_Expiry.value=="")
	{
		alert("Passport Expiry Date Cannot be empty ");
		Visa_Application_Date_of_Expiry.focus();
		return false;
	}
	if(Visa_Application_Place_of_Issue.value=="")
	{
		alert("Place of Issue cannot be empty");
		Visa_Application_Place_of_Issue.focus();
		return false;
	}
	
	<?php if($passport_pic==""){?>
	if(passport_pic.value=="")
	{
		alert("Please attach your passport copy ");
		passport_pic.focus();
		return false;
	}
	<?php }?>
	
	if(Visa_Application_Address1.value=="")
	{
		alert("Address Cannot be empty ");
		Visa_Application_Address1.focus();
		return false;
	}
	if(Visa_Application_Telephone.value=="")
	{
		alert("Telephone no Cannot be empty ");
		Visa_Application_Telephone.focus();
		return false;
	}
	if(Visa_Application_Pincode.value=="")
	{
		alert("Pin code Cannot be empty ");
		Visa_Application_Pincode.focus();
		return false;
	}
	if(Visa_Application_City.value=="")
	{
		alert("City Cannot be empty ");
		Visa_Application_City.focus();
		return false;
	}
	if(Visa_Application_Date.value=="")
	{
		alert("Application Date cannot be empty ");
		Visa_Application_Date.focus();
		return false;
	}
	if(Visa_Application_Country_ID.value=="")
	{
		alert("Please select your country ");
		Visa_Application_Country_ID.focus();
		return false;
	}
	
	if( $('input[name="iagree"]:checked').length==0)
	{
		alert("Please agree to the Terms");
		return false;
	}
	
}
</script>

<style>
.tooltip {
    position: relative;
    display: inline-block;
    border-bottom: 1px dotted black;
    padding: 5px 30px;
    background-color: #d661aa;
}

.tooltip .tooltiptext {
    visibility: hidden;
    width: 600px;
    background-color: #d661aa;
    color: #fff;
    text-align: left;
    border-radius: 6px;
    padding: 5px 0;
    position: absolute;
    z-index: 1;
    top: 350%;
    right: -50%;
    margin-left: -60px;
    opacity: 0;
    transition: opacity 1s;
}

.tooltip .tooltiptext::after {
    content: "";
    position: absolute;
    top: -32%;
    left: 93%;
    margin-left: -60px;
    border-width: 50px;
    border-style: solid;
    border-color: #d661aa transparent transparent transparent;
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
    background-color: #d661aa;	
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

<!--banner starts-->
<div class="banner_inner_wrap">
	<div class="banner_inner">
    	<img src="../images/highlight_banner.jpg" />    </div>
</div>
<!--banner ends-->
	

<div class="clear"></div>


<div class="container_wrap">
<div class="container" id="manualFormContainer">
<h1>Online Manual </h1>

<div id="formWrapper">
<h3>Visa Application Assistance</h3>

<span style="margin-left:40%;" class="spanbox">Deadline : <strong>21st Dec 2016</strong></span>

<div class="tooltip"><strong>Note</strong>
<span class="tooltiptext">
<ol class="numeric">
<li>I shall enter India for the purpose of visiting in the SIGNATURE 2016 and shall not engage in any other activities not related to this event during my stay.</li>

<li>I shall act as per attached itinerary (Daily schedule) during my stay in India and leave India as scheduled. If there is any change in my itinerary, I shall intimate the Gem & Jewellery Export Promotion Council. India, immediately.</li>

<li>I shall observe the Indian law during my stay in India.</li>

<li>I shall bear by myself all the expenses incurred in my visit to and in India, including airfare from and to my country, expenses for accommodation, and all other costs for my stay, and confirm that The Gem &amp; Jewellery Export Promotion Council has no responsibility for such expenses.</li>

<li>Upon return to my country, I shall fax to GJEPC immediately the pages in my passport that shows my Indian entry visa and the departure stamp when leaving India.</li>
 
</ol>
</span>
</div>
<div class="clear"></div>
<h2>Application Summary</h2>


<table  cellspacing="0" cellpadding="0" class="common">
<tbody>
<tr>
	<th valign="top">Date</th>
    <th valign="top">Information Status</th>
    <th valign="top">Passport Status</th>
    <th valign="top">Application Status</th>
</tr>

<tr>
	<td valign="middle"><?php if($Create_Date==""){ echo "NA"; }else{echo date("d-m-Y",strtotime($Create_Date));} ?></td>
    <td valign="middle">
	<?php  
        if($Info_Approved=='Y')
            echo "<img src='images/correct.png'  alt='' />";
        else if($Info_Approved=='N')
            echo "<img src='images/red_cross.png'  alt='' />";
        else
            echo "<img src='images/pending.png'  alt='' />";        
    ?>
   </td>
   
    <td valign="middle"><?php 
            if($passport_pic_approved=='Y')
                echo "<img src='images/correct.png'  alt='' />";
            else if($passport_pic_approved=='N')
                echo "<img src='images/red_cross.png'  alt='' />";
            else
                echo "<img src='images/pending.png'  alt='' />";
            ?></td>
    <td valign="middle"  class="centerAlign">
	  <?php  
        if($Application_Complete=='Y')
            echo "<img src='images/correct.png'  alt='' />";
        else if($Application_Complete=='N')
            echo "<img src='images/red_cross.png'  alt='' />";
        else
            echo "<img src='images/pending.png'  alt='' />";
    ?>
    </td>
</tr>
</tbody></table>


<p>The sections marked with an <span class="red">*</span> are compulsory.</p>


<h2>Exhibitor Information</h2>
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
<div class="title">
<h4>Instructions On Form Submission Personal Details</h4>
</div>

<div class="clear"></div>
<form name="catalogue_entry" id="form1" action="visa_application_asst.php" enctype="multipart/form-data" method="post" onsubmit="return validation()">
<input type="hidden" name="action" value="ADD" />
<table border="0" cellspacing="0" cellpadding="0" class="formManual">
  <tr>
    <td width="25%" class="bold">Name <sup>*</sup></td>
    <td>:</td>
    <td><input type="text" name="Visa_Application_Name" id="Visa_Application_Name" class="textField" value="<?php echo $Visa_Application_Name; ?>" <?php if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'disabled=disabled';} ?>/>   </td>
    <td >&nbsp;</td>
    <td class="bold">Gender <sup>* </sup></td>
    <td >:</td>
    <td ><input type="radio" id="Visa_Application_Gender" name="Visa_Application_Gender" value="Male" <?php if(preg_match('/Male/',$Visa_Application_Gender)){ echo ' checked="checked"'; } ?><?php if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'disabled=disabled';} ?> /> Male <input type="radio" name="Visa_Application_Gender" value="Female" <?php if(preg_match('/Female/',$Visa_Application_Gender)){ echo ' checked="checked"'; } ?> <?php if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'disabled=disabled';} ?> /> Female</td>
  </tr>
  
  <tr>
    <td class="bold">Nationality <sup>* </sup></td>
    <td>:</td>
    <td><input type="text" name="Visa_Application_Nationality" id="Visa_Application_Nationality" class="textField" value="<?php echo $Visa_Application_Nationality; ?>" <?php if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'disabled=disabled';} ?>/></td>
    <td>&nbsp;</td>
    <td class="bold">DOB <sup>* </sup></td>
    <td>:</td>
    <td><input name="Visa_Application_DOB" id="Visa_Application_DOB" type="text"  class="calendar datepicker" value="<?php if($Visa_Application_DOB!="01-01-1970"){echo $Visa_Application_DOB; }?>" <?php if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'disabled=disabled';} ?> /> <img src="../manual/images/calendar.png" /></td>
  </tr>
  
  <tr>
    <td class="bold">Designation <sup>* </sup> </td>
    <td>:</td>
    <td><input type="text" name="Visa_Application_Designation" id="Visa_Application_Designation" class="textField" value="<?php echo $Visa_Application_Designation; ?>" <?php if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'disabled=disabled';} ?> /></td>
    <td>&nbsp;</td>
    <td class="bold">Passport No.<sup> *</sup></td>
    <td>:</td>
    <td><input type="text" name="Visa_Application_PassportNo" id="Visa_Application_PassportNo" class="textField" value="<?php echo $Visa_Application_PassportNo; ?>" <?php if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'disabled=disabled';} ?> /></td>
  </tr>
  <tr>
    <td class="bold">Date of Issue <sup>*</sup></td>
    <td>:</td>
    <td><input name="Visa_Application_Date_of_Issue" id="Visa_Application_Date_of_Issue" type="text"  class="calendar datepicker" value="<?php if($Visa_Application_Date_of_Issue!="01-01-1970"){echo $Visa_Application_Date_of_Issue;} ?>" <?php if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'disabled=disabled';} ?> /> <img src="../manual/images/calendar.png" /></td>
    <td>&nbsp;</td>
    <td class="bold">Date of Expiry <sup>* </sup></td>
    <td>:</td>
    <td><input name="Visa_Application_Date_of_Expiry" id="Visa_Application_Date_of_Expiry" type="text"  class="calendar datepicker" value="<?php if($Visa_Application_Date_of_Expiry!="01-01-1970"){echo $Visa_Application_Date_of_Expiry;} ?>" <?php if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'disabled=disabled';} ?>/> <img src="../manual/images/calendar.png" /></td>
  </tr>
  <tr>
    <td class="bold">Place of Issue <sup>* </sup></td>
    <td>:</td>
    <td><input type="text" name="Visa_Application_Place_of_Issue" id="Visa_Application_Place_of_Issue" class="textField" value="<?php echo $Visa_Application_Place_of_Issue; ?>" <?php if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'disabled=disabled';} ?>/></td>
    <td>&nbsp;</td>
    <td class="bold">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td class="bold">Passport Copy <sup>* </sup></td>
    <td>:</td>
    <td><input type="file" name="passport_pic" id="passport_pic" <?php if($passport_pic_approved=='Y' || $passport_pic_approved=='P') {echo 'disabled=disabled';} ?>  /></td>
    <td colspan="4"><?php if($passport_pic==""){ ?>
      <img src="images/user_pic.jpg" width="189" height="177" alt="" />
      <?php }else{ ?>
      <img src="images/visa//<?php echo $_SESSION['EXHIBITOR_CODE'];?>/<?php echo $passport_pic; ?>" width="189" height="177" alt="" />
      <?php }?></td>
    </tr>
  
   <tr>
    <td colspan="8" ><strong>Passport Approval : &nbsp;&nbsp;&nbsp; </strong>
     <?php 
		if($passport_pic_approved=='Y')
			echo "<img src='images/correct.png'  alt='' /> &nbsp;&nbsp;Approved";
		else if($passport_pic_approved=='N')
			echo "<img src='images/red_cross.png'  alt='' /> &nbsp;&nbsp;Disapproved";
		else
			echo "<img src='images/pending.png'  alt='' /> &nbsp;&nbsp;Pending";
     if($passport_pic_approved=='N'){echo "<strong><br />Reason : </strong>".$passport_pic_reason; };                                   	
    ?></td>
    
  </tr>
   <tr>
    <td colspan="5" >Where do you want to submit your visa application ?</td>
    <td>:</td>
    <td><input type="text" name="Visa_Application_Location" id="Visa_Application_Location" class="textField" value="<?php echo $Visa_Application_Location; ?>" <?php if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'disabled=disabled';} ?> /></td>
  </tr>
  
   <tr>
    <td colspan="5" >Name  Of Indian Embassy/ Consulate</td>
    <td>:</td>
    <td><input type="text" name="Visa_Application_Indian_Embassy" id="Visa_Application_Indian_Embassy" class="textField" value="<?php echo $Visa_Application_Indian_Embassy; ?>"<?php if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'disabled=disabled';} ?> /></td>
  </tr>
  
  <tr>
    <td class="bold">Address <sup>*</sup></td>
    <td>:</td>
    <td><input type="text" name="Visa_Application_Address1" id="Visa_Application_Address1" class="textarea" value="<?php echo $Visa_Application_Address1; ?>" <?php if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'disabled=disabled';} ?> /></td>
    <td>&nbsp;</td>
    <td class="bold">Telephone <sup>*</sup></td>
    <td>:</td>
    <td><input type="text" name="Visa_Application_Telephone" id="Visa_Application_Telephone" class="textField" value="<?php echo $Visa_Application_Telephone; ?>" <?php if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'disabled=disabled';} ?> /></td>
  </tr>
  <tr>
    <td class="bold">Pincode <sup>*</sup></td>
    <td>:</td>
    <td><input type="text" name="Visa_Application_Pincode" id="Visa_Application_Pincode" class="textField" value="<?php echo $Visa_Application_Pincode; ?>" <?php if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'disabled=disabled';} ?> /></td>
    <td>&nbsp;</td>
    <td class="bold">Fax</td>
    <td>:</td>
    <td><input type="text" name="Visa_Application_Fax" id="Visa_Application_Fax" class="textField" value="<?php echo $Visa_Application_Fax; ?>" <?php if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'disabled=disabled';} ?> /></td>
  </tr>
  <tr>
    <td class="bold">City <sup>*</sup></td>
    <td>:</td>
    <td><input type="text" name="Visa_Application_City" id="Visa_Application_City" class="textField" value="<?php echo $Visa_Application_City; ?>" <?php if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'disabled=disabled';} ?> /></td>
    <td>&nbsp;</td>
    <td class="bold">Date of Visa App.<sup>*</sup></td>
    <td>:</td>
    <td><input name="Visa_Application_Date" type="text"  class="calendar datepicker" id="Visa_Application_Date" value="<?php if($Visa_Application_Date!="01-01-1970"){echo $Visa_Application_Date;} ?>" <?php if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'disabled=disabled';} ?> /><img src="../manual/images/calendar.png" /></td>
  </tr>
  <tr>
    <td class="bold">Country <sup>*</sup></td>
    <td>:</td>
    <td>
    <select name="Visa_Application_Country_ID" id="Visa_Application_Country_ID" style="width:150px;" <?php if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'disabled=disabled';} ?> >
      <option value="" >-- Select -- </option>
    	<?php 
			$country_sql = "SELECT * FROM  iijs_country_master";
			$getCountry = mysql_query($country_sql);		
		
			while($showCountry=mysql_fetch_array($getCountry))
			{	
				$countryId=$showCountry['Country_ID'];
				$countryName=$showCountry['Country_Name'];
				if($countryId==$Visa_Application_Country_ID)
					echo "<option value=$countryId selected='selected'>$countryName</option>";		
				else
					echo "<option value=$countryId >$countryName</option>";		
			}
		?>
    </select>    </td>
    <td>&nbsp;</td>
    <td class="bold">&nbsp;</td>
    <td>&nbsp;</td>
    <td></td>
  </tr>
</table>

<div class="title">
<h4>Flight Schedule</h4>
</div>

<div class="clear"></div>

<table border="0" cellspacing="0" cellpadding="0" class="formManual">
  <tr>
    <td class="bold">Arrival / Entry Date</td>
    <td>:</td>
    <td><input name="Visa_Application_Arrival_Date" type="text"  class="calendar datepicker" id="Visa_Application_Arrival_Date" value="<?php if($Visa_Application_Arrival_Date!="01-01-1970"){echo $Visa_Application_Arrival_Date;} ?>" <?php if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'disabled=disabled';} ?> /> <img src="../manual/images/calendar.png" /></td>
    <td>&nbsp;</td>
    <td class="bold">Departure Date</td>
    <td>:</td>
    <td><input name="Visa_Application_Departure_Date" type="text"  class="calendar datepicker" id="Visa_Application_Departure_Date" value="<?php if($Visa_Application_Departure_Date!="01-01-1970"){echo $Visa_Application_Departure_Date;} ?>" <?php if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'disabled=disabled';} ?> /> <img src="../manual/images/calendar.png" /></td>
  </tr>  
  
  <tr>
    <td class="bold">Arrival Flight No.</td>
    <td>:</td>
    <td><input type="text" name="Visa_Application_Arrival_FlightNo" id="Visa_Application_Arrival_FlightNo" class="textField" value="<?php echo $Visa_Application_Arrival_FlightNo; ?>" <?php if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'disabled=disabled';} ?> /></td>
    <td>&nbsp;</td>
    <td class="bold">Departure Flight No.</td>
    <td>:</td>
    <td><input type="text" name="Visa_Application_Departure_FlightNo" id="Visa_Application_Departure_FlightNo" class="textField"  value="<?php echo $Visa_Application_Departure_FlightNo; ?>" <?php if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'disabled=disabled';} ?> /></td>
  </tr>
  <tr>
    <td class="bold">Entry Port</td>
    <td>:</td>
    <td><input type="text" name="Visa_Application_Arrival_Entry_Port" id="Visa_Application_Arrival_Entry_Port" class="textField" value="<?php echo $Visa_Application_Arrival_Entry_Port; ?>" <?php if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'disabled=disabled';} ?> /></td>
    <td>&nbsp;</td>
    <td class="bold">Departing Port</td>
    <td>:</td>
    <td><input type="text" name="Visa_Application_Departure_Port" id="Visa_Application_Departure_Port" class="textField" value="<?php echo $Visa_Application_Departure_Port; ?>" <?php if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'disabled=disabled';} ?> /></td>
  </tr>
  
</table>
<div class="clear"></div>
<div class="title"><h4>Information Approval</h4></div>
<div class="clear"></div>


<table border="0" cellspacing="0" cellpadding="0" class="formManual">
  <tr>
    <td width="150"><strong>Status</strong></td>
    <td>:</td>
    <td>
    <?php 
		if($Info_Approved=='Y')
			echo "<img src='images/correct.png'  alt='' /> &nbsp;&nbsp;Approved";
		else if($Info_Approved=='N')
			echo "<img src='images/red_cross.png'  alt='' /> &nbsp;&nbsp;Disapproved";
		else
			echo "<img src='images/pending.png'  alt='' /> &nbsp;&nbsp;Pending";                                        	
    ?>
    </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <?php 
	if($Info_Approved=='N'){?>
  <tr>
    <td><strong>Reason</strong></td>
    <td>:</td>
    <td><?php echo "$Info_Reason"; ?></td>
  </tr>
  <?php }?>
</table>
<div class="clear"></div>

<p><sup>*</sup> <input name="iagree" type="checkbox" checked="checked" <?php if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'disabled=disabled';} ?> /> 
I hereby agree to vow to abide the given mentioned terms and conditions.</p>
    <div align="center">
       <?php if($Info_Approved=='N' || $Info_Approved=='' || $passport_pic_approved=='N' || $passport_pic_approved==''){ ?>
       <!--<input type="submit" value="Submit" class="maroon_btn" />-->
       <?php }?>
    <a href="list.php"><input name="input2" type="button" value="Cancel" class="maroon_btn" /></a>
    </div>

</form>
</div>

<div class="clear">	
 
</div>
</div>
</div>
<div class="footer_wrap">
<?php include ('footer.php'); ?>
</div>
</body>
</html>

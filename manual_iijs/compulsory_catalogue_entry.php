<?php 
include('header_include.php');
if(!isset($_SESSION['EXHIBITOR_CODE'])){ header("location:index.php");	exit; }
	$event = getEventDescription($conn); 
?>
<?php  
// Define path and new folder name 
$create_dir = "images/catalog/".$_SESSION['EXHIBITOR_CODE']; 
if (!file_exists($create_dir)) {   mkdir($create_dir, 0777); } 
?>
<?php
$exhibitor_code = $_SESSION['EXHIBITOR_CODE'];
/*
$sqlquery = "SELECT * FROM `iijs_personalInfo` WHERE `Exhibitor_Code`='$exhibitor_code'";
$result1 = $conn ->query($sqlquery);
$total_badge = $result1->num_rows;
if($total_badge<=0)
{
	echo '<script type="text/javascript">'; 
	echo 'alert("Please Apply ELITE CLUB NOMINATION FORM to access this form.");'; 
	echo 'window.location.href = "manual_list.php";';
	echo '</script>';	
} */
?>
<?php
$exhibitor_code=$_SESSION['EXHIBITOR_CODE'];

$exhibitor_data="select * from iijs_exhibitor where Exhibitor_Code='$exhibitor_code'";
$result =  $conn ->query($exhibitor_data);
$fetch_data = $result->fetch_assoc();

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
$Exhibitor_Pincode = filter_replace(filter($fetch_data['Exhibitor_Pincode']));
$Exhibitor_State=$fetch_data['Exhibitor_State'];
$Exhibitor_Country_ID=$fetch_data['Exhibitor_Country_ID'];
$Exhibitor_City=$fetch_data['Exhibitor_City'];
$Exhibitor_Website=$fetch_data['Exhibitor_Website'];

$catalog_data="select * from iijs_catalog where Exhibitor_Code='$exhibitor_code'";
$result_catalog= $conn ->query($catalog_data);
$fetch_catalog = $result_catalog->fetch_assoc();
$brand_names=$fetch_catalog['brand_names'];
if($brand_names!="")
{
	$brand_names=explode(",",$brand_names);
	$brand_name1=$brand_names[0];
	$brand_name2=$brand_names[1];
	$brand_name3=$brand_names[2];
	$brand_name4=$brand_names[3];
	$brand_name5=$brand_names[4];
}
else
{
	$brand_name1="";
	$brand_name2="";
	$brand_name3="";
	$brand_name4="";
	$brand_name5="";
}
$num =  $result_catalog->num_rows;
if($num>0)
{
	$Exibitor_Name=$fetch_catalog['Exibitor_Name'];
	$Catalog_Phone=$fetch_catalog['Catalog_Phone'];
	$Catalog_ContactPerson=$fetch_catalog['Catalog_ContactPerson'];
	$Catalog_Fax=$fetch_catalog['Catalog_Fax'];
	$Catalog_Designation=$fetch_catalog['Catalog_Designation'];
	$Catelog_mobile=$fetch_catalog['Catelog_mobile'];
	$Catalog_Address1=$fetch_catalog['Catalog_Address1'];
	$Catalog_Email=$fetch_catalog['Catalog_Email'];
	$Catalog_City=$fetch_catalog['Catalog_City'];
	$Catalog_Email1=$fetch_catalog['Catalog_Email1'];
	$Catalog_Pincode=$fetch_catalog['Catalog_Pincode'];
	$Catalog_Website=$fetch_catalog['Catalog_Website'];
	$Catalog_CountryId=$fetch_catalog['Catalog_CountryId'];
	$Catalog_StallNo=$fetch_catalog['Catalog_StallNo'];
	$Catalog_State=$fetch_catalog['Catalog_State'];
	$Create_Date=$fetch_catalog['Create_Date'];
	$Catalog_Brief=stripslashes($fetch_catalog['Catalog_Brief']);
	$Catalog_CompanyLogo=$fetch_catalog['Catalog_CompanyLogo'];
	$CompanyLogo_Approved=$fetch_catalog['CompanyLogo_Approved'];
	$CompanyLogo_Reason=$fetch_catalog['CompanyLogo_Reason'];
	$Catalog_ProductLogo=$fetch_catalog['Catalog_ProductLogo'];
	$ProductLogo_Reason=$fetch_catalog['ProductLogo_Reason'];
	$ProductLogo_Approved=$fetch_catalog['ProductLogo_Approved'];	
	$Info_Reason=$fetch_catalog['Info_Reason'];
	$Info_Approved=$fetch_catalog['Info_Approved'];
	$Application_Complete=$fetch_catalog['Application_Complete'];
} else {
	$Catalog_ContactPerson=$Exhibitor_Contact_Person;
	$Catalog_Designation=$Exhibitor_Designation;
	$Catelog_mobile=$Exhibitor_Mobile;
	$Catalog_Phone=$Exhibitor_Phone;
	$Catalog_Fax=$Exhibitor_Fax;
	$Catalog_StallNo=$stall_no;		
	$Catalog_Address1=$Exhibitor_Address1;
	$Catalog_Address2=$Exhibitor_Address2;
	$Catalog_Address3=$Exhibitor_Address3;	
	$Catalog_Email=$Exhibitor_Email;
	$Catalog_Email1=$Exhibitor_Email1;
	$Catalog_Pincode=$Exhibitor_Pincode;
	$Catalog_State=$Exhibitor_State;
	$Catalog_CountryId=$Exhibitor_Country_ID;
	$Catalog_City=$Exhibitor_City;
	$Catalog_Website=$Exhibitor_Website;
}

if($_REQUEST['action']=="ADD")
{ //echo '<pre>'; print_r($_POST); exit;
		if(isset($_FILES['Catalog_ProductLogo']) && $_FILES['Catalog_ProductLogo']['name']!="")
		{
		//Unlink the previuos image
		$qpreviousimg = $conn ->query("select Catalog_ProductLogo from iijs_catalog where Exhibitor_Code='$exhibitor_code'");
		$rpreviousimg = $qpreviousimg->fetch_assoc();
		$filename="images/catalog/".$_SESSION['EXHIBITOR_CODE']."/".$rpreviousimg['Catalog_ProductLogo'];
		unlink($filename);

			$file_name=$_FILES['Catalog_ProductLogo']['name'];
			$file_temp=$_FILES['Catalog_ProductLogo']['tmp_name'];
			$file_type=$_FILES['Catalog_ProductLogo']['type'];
			$file_size=$_FILES['Catalog_ProductLogo']['size'];
			$attach="P";
			if($_FILES['Catalog_ProductLogo']['name']!="")
			{
				$Catalog_ProductLogo=uploadImage($file_name,$file_temp,$file_type,$file_size,$attach,"catalog");
			}
			if($Catalog_ProductLogo=="")
			{
			echo '<script type="text/javascript">'; 
			echo 'alert("Invalid File,Kindly Upload file in .jpg,.png Format only.");'; 
			echo 'window.location.href = "compulsory_catalogue_entry.php";';
			echo '</script>';
			exit;
			}else
			{
			$update_plogo="update iijs_catalog set Catalog_ProductLogo='$Catalog_ProductLogo',ProductLogo_Approved='P',ProductLogo_Reason='',Application_Complete='P' where Exhibitor_Code='$exhibitor_code'";
			$update_plogoresult =  $conn ->query($update_plogo);
			}
		}
		
		if(isset($_FILES['Catalog_CompanyLogo']) && $_FILES['Catalog_CompanyLogo']['name']!="")
		{
		//Unlink the previuos image
		$qpreviousimg = $conn ->query("select Catalog_CompanyLogo from iijs_catalog where Exhibitor_Code='$exhibitor_code'");
		$rpreviousimg = $qpreviousimg->fetch_assoc();
		$filename="images/catalog/".$_SESSION['EXHIBITOR_CODE']."/".$rpreviousimg['Catalog_CompanyLogo'];
		unlink($filename);
		
			$file_name=$_FILES['Catalog_CompanyLogo']['name'];
			$file_temp=$_FILES['Catalog_CompanyLogo']['tmp_name'];
			$file_type=$_FILES['Catalog_CompanyLogo']['type'];
			$file_size=$_FILES['Catalog_CompanyLogo']['size'];
			$attach="C";
			$ext = pathinfo($file_name, PATHINFO_EXTENSION);
			if($ext == 'php'){
				echo '<script>alert("File Format is not valid")</script>';
			}
			if($_FILES['Catalog_CompanyLogo']['name']!="")
			{
				$Catalog_CompanyLogo=uploadImage($file_name,$file_temp,$file_type,$file_size,$attach,"catalog");
			}
			if($Catalog_CompanyLogo=="")
			{
			echo '<script type="text/javascript">'; 
			echo 'alert("Invalid File,Kindly Upload file in .jpg,.png Format only.");'; 
			echo 'window.location.href = "compulsory_catalogue_entry.php";';
			echo '</script>';
			exit;
			}else
			{
			$update_clogo="update iijs_catalog set Catalog_CompanyLogo='$Catalog_CompanyLogo',CompanyLogo_Approved='P',CompanyLogo_Reason='',Application_Complete='P' where Exhibitor_Code='$exhibitor_code'";
			$update_clogoresult = $conn ->query($update_clogo);
			}			
		}		

if(isset($_POST['brand_names']))//if(isset($_POST['submit']))
{		
		$Exibitor_Name=filter($_POST['Exibitor_Name']);
		$Catalog_Phone=filter($_POST['Catalog_Phone']);
		$Catalog_ContactPerson=filter($_POST['Catalog_ContactPerson']);
		$Catalog_Fax=filter($_POST['Catalog_Fax']);
		$Catalog_Designation=filter($_POST['Catalog_Designation']);
		$Catelog_mobile=filter($_POST['Catelog_mobile']);
		$Catalog_Address1=filter($_POST['Catalog_Address1']);
		$Catalog_Email=filter($_POST['Catalog_Email']);
		$Catalog_City=filter($_POST['Catalog_City']);
		$Catalog_Email1=filter($_POST['Catalog_Email1']);
		$Catalog_Pincode=filter($_POST['Catalog_Pincode']);
		$Catalog_Website=filter($_POST['Catalog_Website']);
		$Catalog_CountryId=filter($_POST['Catalog_CountryId']);		
		$Catalog_CountryId=getCountryCode($Catalog_CountryId,$conn);	
		$Catalog_StallNo=filter($_POST['Catalog_StallNo']);
		$Catalog_State=filter($_POST['Catalog_State']);		 
	    //$Catalog_Brief = preg_replace("/[^A-Za-z0-9]/", " ", $_POST['Catalog_Brief']);
		$Catalog_Brief = addslashes($_POST['Catalog_Brief']);
		$brand_names=implode(",",$_POST['brand_names']);

		if($num>0)
		{
		$sql_update="update iijs_catalog set Exibitor_Name='$Exibitor_Name',Catalog_Phone='$Catalog_Phone',Catalog_ContactPerson='$Catalog_ContactPerson',Catalog_Fax='$Catalog_Fax',Catalog_Designation='$Catalog_Designation',Catelog_mobile='$Catelog_mobile',Catalog_Address1='$Catalog_Address1',Catalog_Email='$Catalog_Email',Catalog_City='$Catalog_City',Catalog_Pincode='$Catalog_Pincode',Catalog_Website='$Catalog_Website',Catalog_CountryId='$Catalog_CountryId',Catalog_StallNo='$Catalog_StallNo',Catalog_State='$Catalog_State',brand_names='$brand_names',Catalog_Brief='$Catalog_Brief',Info_Reason='',Info_Approved='P',Application_Complete='P',Modify_Date=NOW()	where Exhibitor_Code='$exhibitor_code'"; 
		$execute= $conn ->query($sql_update);
		if(!$execute) die ($conn->error);
		}
		else
		{
		$sql_insert="insert into iijs_catalog set Exhibitor_Code='$exhibitor_code',Exibitor_Name='$Exibitor_Name',Catalog_Phone='$Catalog_Phone',Catalog_ContactPerson='$Catalog_ContactPerson',Catalog_Fax='$Catalog_Fax',Catalog_Designation='$Catalog_Designation',Catelog_mobile='$Catelog_mobile',Catalog_Address1='$Catalog_Address1',Catalog_Email='$Catalog_Email',	Catalog_City='$Catalog_City',Catalog_Pincode='$Catalog_Pincode',Catalog_Website='$Catalog_Website',Catalog_CountryId='$Catalog_CountryId',Catalog_StallNo='$Catalog_StallNo',Catalog_State='$Catalog_State',brand_names='$brand_names',Catalog_Brief='$Catalog_Brief',	Catalog_ProductLogo='$Catalog_ProductLogo',Catalog_CompanyLogo='$Catalog_CompanyLogo', Info_Recieved='1',Application_Complete='P',Create_Date=NOW()";
		$execute= $conn ->query($sql_insert);
		if(!$execute) die ($conn->error);
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
		<p>Company Name: <strong>'.$Exibitor_Name.'</strong> </p>
		<p>Thank you for applying Online for <strong>COMPULSORY CATALOGUE ENTRY</strong>. Please note your application is under approval process.</p>
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
		
		//$to ='rohit@kwebmaker.com';
		$to = $Exhibitor_Email.',notification@gjepcindia.com';	
		$subject = "".$event." Exhibitor Manual - COMPULSORY CATALOGUE ENTRY"; 
		$headers  = 'MIME-Version: 1.0' . "\n"; 
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n"; 
		$headers .= 'From: "'.$event.'" <admin@gjepc.org>';			
		mail($to, $subject, $message, $headers);
		}
		
}
		echo '<script type="text/javascript">'; 
		echo 'alert("You have successfully submitted your application.");'; 
		echo 'window.location.href = "manual_list.php";';
		echo '</script>';	
}
	
if($Catalog_CompanyLogo!="")
{
	$sql_comp_logo="update iijs_catalog set CompanyLogo_Recieved='1' where Exhibitor_Code='$exhibitor_code'";
	$comp_logo_result= $conn ->query($sql_comp_logo);
}

if($Catalog_ProductLogo!="")
{
	$sql_prod_logo="update iijs_catalog set ProductLogo_Recieved='1' where Exhibitor_Code='$exhibitor_code'";
	$prod_logo_result= $conn ->query($sql_prod_logo);
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome to IIJS</title>
<link rel="stylesheet" type="text/css" href="css/mystyle.css"/>
<!--navigation script-->
<script type="text/javascript" src="../js/jquery_002.js"></script>
<link rel="stylesheet" type="text/css" href="../css/ddsmoothmenu.css" />
<script type="text/javascript" src="../js/ddsmoothmenu.js"></script>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

<script type="text/javascript">
$(document).ready(function() {
   $('textarea[maxlength]').keyup(function(){
      var max = parseInt($(this).attr('maxlength'));
 
      if($(this).val().length > max){
         $(this).val($(this).val().substr(0, max));
      }
      
      $(this).parent().find('.charleft').html(max - $(this).val().length);
   });  
});
</script>
<!--manual form css-->

<link rel="stylesheet" type="text/css" href="../css/manual.css"/>
<script type="text/javascript">
function validation()
{
		var Catalog_Phone=document.getElementById('Catalog_Phone');
		var Catalog_Designation=document.getElementById('Catalog_Designation');
		var Catalog_Address1=document.getElementById('Catalog_Address1');
		var Catalog_Email=document.getElementById('Catalog_Email');
		var Catalog_City=document.getElementById('Catalog_City');
		var Catalog_Pincode=document.getElementById('Catalog_Pincode');
		var Catalog_ProductLogo=document.getElementById('Catalog_ProductLogo');
		var Catalog_CompanyLogo=document.getElementById('Catalog_CompanyLogo');
		
		if(Catalog_Phone.value=="")
		{
			alert("Please Enter Phone No");
			Catalog_Phone.focus();
			return false;
		}
		
		if(Catalog_Designation.value=="")
		{
			alert("Please Enter Designation");
			Catalog_Designation.focus();
			return false;
		}
		
		if(Catalog_Address1.value=="")
		{
			alert("Please Enter Address");
			Catalog_Address1.focus();
			return false;
		}
		if(Catalog_Email.value=="")
		{
			alert("Please Enter Email");
			Catalog_Email.focus();
			return false;
		}
		if(Catalog_City.value=="")
		{
			alert("Please Enter City");
			Catalog_City.focus();
			return false;
		}
		if(Catalog_Pincode.value=="")
		{
			alert("Please Enter Pincode");
			Catalog_Pincode.focus();
			return false;
		}		
		
		if(Catalog_Brief.value=="")
		{
			alert("Please Enter Catalog Brief");
			Catalog_Brief.focus();
			return false;
		}
		if(Catalog_ProductLogo.value=="")
		{
			alert("Please Upload Catalog Product Logo");
			Catalog_ProductLogo.focus();
			return false;
		}
		if(Catalog_CompanyLogo.value=="")
		{
			alert("Please Upload Catalog Company Logo");
			Catalog_CompanyLogo.focus();
			return false;
		}
}
</script>

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
<h3>Compulsory Catalogue Entry Form</h3>
<div class="tooltip"><strong>Note</strong>
<span class="tooltiptext">
<ol class="numeric">
<li>This form is mandatory for entry in the Exhibitor Catalogue for information purpose.</li>
<li>If you fail to upload the company profile, product picture & logo of your company then the IIJS Premiere show logo will be published or will be kept blank in your picture field of Exhibitor Catalogue.</li>
<li>If write-up is not received, Details will be kept blank in exhibitor catalogue.</li>
</ol>
</span>
</div>

<span style="color:#fff;float:right;" class="spanbox">Deadline : <strong><?php echo getFormDeadLine(1,$conn);?></strong></span>

<div class="clear"></div>
<h2>Application Summary</h2>

<table cellspacing="0" cellpadding="0" class="common">
                                    <tbody>
                                    <tr>
                                        <th valign="top">Sr. No.</th>
                                        <th valign="top">Date</th>
                                        <th valign="top">Information Status</th>
                                        <th valign="top">Product Picture Status</th>
                                        <th valign="middle">Company Logo Status</th>
                                        <th valign="top">Application Status</th>
                                    </tr>
                                  	
                                    <tr>
                                        <td valign="middle">1</td>
                                        <td valign="middle" width="100">
                                          <?php if($Create_Date==""){ echo "NA"; }else{echo date("d-m-Y",strtotime($Create_Date));} ?></td>
                                        <td valign="middle" class="centerAlign">
                                        <?php  
											if($Info_Approved=='Y')
												echo "<img src='images/correct.png'  alt='' />";
											else if($Info_Approved=='N')
												echo "<img src='images/red_cross.png'  alt='' />";
											else
												echo "<img src='images/pending.png'  alt='' />";                                        	
                                        ?>
                                       </td>
                                        <td valign="middle" class="centerAlign">
                                         <?php  
											if($ProductLogo_Approved=='Y')
												echo "<img src='images/correct.png'  alt='' />";
											else if($ProductLogo_Approved=='N')
												echo "<img src='images/red_cross.png'  alt='' />";
											else
												echo "<img src='images/pending.png'  alt='' />";                                        	
                                        ?>
                                        </td>
                                        <td valign="middle" colspan="1" class="centerAlign">
                                         <?php  
											if($CompanyLogo_Approved=='Y')
												echo "<img src='images/correct.png'  alt='' />";
											else if($CompanyLogo_Approved=='N')
												echo "<img src='images/red_cross.png'  alt='' />";
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
											else
												echo "<img src='images/pending.png'  alt='' />";                                        	
                                        ?>
                                        </td>
                                    </tr>
                                </tbody></table>

<p>The sections marked with a <span class="red">*</span> are compulsory.</p>
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
    <td><?php  echo getSection_desc($Exhibitor_Section,$conn); ?></td>
    <td>&nbsp;</td>
    <td class="bold">Area</td>
    <td>:</td>
    <td><?php echo $Exhibitor_Area; ?></td>
  </tr>
</table>

<form name="catalogue_entry" id="form1" action="compulsory_catalogue_entry.php" enctype="multipart/form-data" method="post" onsubmit="return validation()" autocomplete="off">
<input type="hidden" name="action" value="ADD" />

<table border="0" cellspacing="0" cellpadding="0" class="formManual">
  <tr>
    <td class="bold">Exhibitor Name</td>
    <td>:</td>
    <td><input type="text" name="EN" id="EN" class="textField" value="<?php echo $Exhibitor_Name;?>" disabled="disabled"/>
      <input type="hidden" name="Exibitor_Name" id="Exibitor_Name" class="textField" value="<?php echo $Exhibitor_Name;?>"/>
      <br />
      <span id="name_error" class="error_msg"></span>
   </td>
    <td>&nbsp;</td>
    <td class="bold">Telephone <sup>*</sup></td>
    <td>:</td>
    <td><input type="text" name="Catalog_Phone" id="Catalog_Phone" class="textField" minlength="10" maxlength="10" value="<?php echo $Catalog_Phone;?>" <?php if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'readonly';} ?>/></td>
  </tr>
  <tr>
    <td class="bold">Contact Person</td>
    <td>:</td>
    <td>
    <input type="text" name="CPN" id="CPN" class="textField" value="<?php echo $Catalog_ContactPerson;?>" disabled="disabled"/>
    <input type="hidden" name="Catalog_ContactPerson" id="Catalog_ContactPerson" class="textField" value="<?php echo $Catalog_ContactPerson;?>" />
    </td>
    <td>&nbsp;</td>
    <td class="bold">Fax</td>
    <td>:</td>
    <td><input type="text" name="Catalog_Fax" id="Catalog_Fax" class="textField" minlength="10" maxlength="10" value="<?php echo $Catalog_Fax;?>" <?php if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'readonly';} ?>/></td>
  </tr>
  <tr>
    <td class="bold">Designation <sup>* </sup></td>
    <td>:</td>
    <td><input type="text" name="Catalog_Designation" id="Catalog_Designation" class="textField" value="<?php echo $Catalog_Designation;?>" /></td>
    <td>&nbsp;</td>
    <td class="bold">Mobile</td>
    <td>:</td>
    <td><input type="text" name="Catelog_mobile" id="Catelog_mobile" class="textField" autocomplete="off" minlength="10" maxlength="10" value="<?php echo $Catelog_mobile;?>" <?php if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'readonly';} ?>/></td>
  </tr>
  <tr>
    <td class="bold">Address <sup>* </sup></td>
    <td>:</td>
    <td><textarea name="Catalog_Address1" id="Catalog_Address1" cols="45" rows="5" class="textArea" <?php if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'readonly';} ?>><?php echo $Catalog_Address1;?></textarea></td>
    <td>&nbsp;</td>
    <td class="bold">E-Mail <sup>*</sup></td>
    <td>:</td>
    <td><input type="text" name="Catalog_Email" id="Catalog_Email" class="textField" autocomplete="off" value="<?php echo $Catalog_Email;?>" <?php if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'readonly';} ?>/></td>
  </tr>
  <tr>
    <td class="bold">City <sup>*</sup></td>
    <td>:</td>
    <td><input type="text" name="Catalog_City" id="Catalog_City" class="textField" value="<?php echo $Catalog_City; ?>" <?php if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'readonly';} ?>/></td>
    <td>&nbsp;</td>
    <td class="bold">Pin Code <sup>* </sup></td>
    <td>:</td>
    <td><input type="text" name="Catalog_Pincode" id="Catalog_Pincode" class="textField" value="<?php echo $Catalog_Pincode; ?>" <?php if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'readonly';} ?> maxlength="6"/></td>
    <td>&nbsp;</td>
  </tr>
  <tr>    
    <td class="bold">Website</td>
    <td>:</td>
    <td><input type="text" name="Catalog_Website" id="Catalog_Website" class="textField" value="<?php echo $Catalog_Website; ?>" <?php if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'readonly';} ?>/></td>
	<td>&nbsp;</td>
    <td class="bold">Stall No.</td>
    <td>:</td>
    <td>
    <input type="text" name="CSN" id="CSN" class="textField" value="<?php echo $Catalog_StallNo; ?>"  disabled="disabled"/>
    <input type="hidden" name="Catalog_StallNo" id="Catalog_StallNo" class="textField" value="<?php echo $Catalog_StallNo; ?>" readonly="readonly"/></td>
  </tr>
  <tr>
    <td class="bold">Country</td>
    <td>:</td>
    <td><input type="text" name="Catalog_CountryId" id="Catalog_CountryId" class="textField" autocomplete="off" value="<?php echo getCountryName($Catalog_CountryId,$conn); ?>" <?php if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'readonly';} ?>/></td>
    <td>&nbsp;</td>
	<td class="bold">State</td>
    <td>:</td>
    <td><input type="text" name="Catalog_State" id="Catalog_State" autocomplete="off" class="textField" value="<?php echo $Catalog_State; ?>" <?php if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'readonly';} ?>/></td>
  </tr>
</table>

<div class="title">
<h4>A brief write-up of the company is not more than 1000 characters</h4>
</div>

<div class="clear"></div>
<p>The write-up should give information on present exports, number of years the company has been operating, offices around the world if any, special product features, special customer services, certifications received etc</p>
<!--<textarea class="bigTextField" name="Catalog_Brief" id="Catalog_Brief" maxlength="1000"  <?php if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'disabled=disabled';} ?>><?php echo $Catalog_Brief;?></textarea>-->

<textarea class="bigTextField" name="Catalog_Brief" id="Catalog_Brief" maxlength="1000" <?php if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'readonly';} ?> onpaste="return false;" onCopy="return false" onCut="return false" onDrag="return false" onDrop="return false" ><?php echo $Catalog_Brief;?></textarea>

<?php if($Info_Approved=='Y' || $Info_Approved=='P') {}else { ?>
<p>Remaining characters: <span class="charleft">1000</span></p>
<?php } ?>

<div class="title"><h4>Info Approval</h4></div>
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
  if($Info_Approved=='N'){ ?>
  <tr>
    <td><strong>Reason</strong></td>
    <td>:</td>
    <td><?php echo "$Info_Reason"; ?></td>
  </tr>
  <?php } ?>
</table>

<div class="title"><h4>Brand Names</h4></div>

<div class="clear"></div>
<div class="borderBottom"></div>
<div class="clear"></div>

<table border="0" cellspacing="0" cellpadding="0" class="formManual">
  <tr>
    <td width="146">Brand Name 1</td>
    <td width="36">:</td>
    <td width="253"><input type="text" name="brand_names[]" id="textfield18" class="textField" value="<?php echo $brand_name1?>" <?php if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'disabled=disabled';} ?>/></td>
    <td width="163">Brand Name 4</td>
    <td width="30">:</td>
    <td width="262"><input type="text" name="brand_names[]" id="textfield19" class="textField" value="<?php echo $brand_name4; ?>" <?php if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'disabled=disabled';} ?>/></td>
  </tr>
  <tr>
    <td>Brand Name 2</td>
    <td>:</td>
    <td><input type="text" name="brand_names[]" id="textfield20" class="textField" value="<?php echo $brand_name2; ?>" <?php if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'disabled=disabled';} ?>/></td>
    <td>Brand Name 5</td>
    <td>:</td>
    <td><input type="text" name="brand_names[]" id="textfield20" class="textField" value="<?php echo $brand_name5; ?>" <?php if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'disabled=disabled';} ?>/></td>
  </tr>
  <tr>
    <td>Brand Name 3</td>
    <td>:</td>
    <td><input type="text" name="brand_names[]" id="textfield20" class="textField" value="<?php echo $brand_name3; ?>" <?php if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'disabled=disabled';} ?>/></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

<div class="title"><h4>Product Picture</h4></div>

<div class="clear"></div>
<p>Please upload colored picture of your choice representing a product or advertising campaign of your company. Please ensure there is no integration of additional text to the picture or mention of prices. The size of the photo should not exceed 2 MB, minimum resolution required is 300 dpi (Accepted Format JPEG)</p>

<table border="0" cellspacing="0" cellpadding="0" class="formManual">
  <tr>
    <td width="37%"><div class="bottomSpace">
	<?php if($Catalog_ProductLogo==""){ ?>
	<img src="images/logo.png" width="200" height="130" alt="Product Logo" />
	<?php } else { ?>
    	<img src="images/catalog/<?php echo $_SESSION['EXHIBITOR_CODE'];?>/<?php echo $Catalog_ProductLogo; ?>" width="200" height="150" alt="" />
    <?php } ?>
    </div>
    </td>
    <td width="57%"> 
       <div class="bottomSpace"><strong>Product Approval</strong></div>
        
        <div class="bottomSpace">
        Status :&nbsp;&nbsp;
        <?php 
		if($ProductLogo_Approved=='Y')
			echo "<img src='images/correct.png'  alt='' /> &nbsp;&nbsp;Approved";
		else if($ProductLogo_Approved=='N')
			echo "<img src='images/red_cross.png'  alt='' /> &nbsp;&nbsp;Disapproved";
		else
			echo "<img src='images/pending.png'  alt='' /> &nbsp;&nbsp;Pending";                                        	
         ?>
         </div>
        <div class="bottomSpace"></div>
        <div class="bottomSpace">
          <?php if($ProductLogo_Approved=='N'){	echo "Reason :  $ProductLogo_Reason"; }else if($ProductLogo_Approved=='') { echo "Image will be displayed after final submission."; }?>
      	</div>
        
        </td>
    <td width="3%">&nbsp;</td>
    <td width="3%">&nbsp;</td>
  </tr>
  <?php if($ProductLogo_Approved!='Y'){ ?>
  <tr>
    <td colspan="2">
    <div class="chooseButton" style="float:left;">
      <input type="file" name="Catalog_ProductLogo" id="Catalog_ProductLogo" class="chooseFile" <?php if($ProductLogo_Approved=='Y' || $ProductLogo_Approved=='P'){ echo 'disabled=disabled'; }?> />
      </div> 
    <div class="clear"></div>
          </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <?php } ?>
</table>

<div class="title">
<h4>Company Logo / Trademark</h4>
</div>

<div class="clear"></div>

<p>Please upload a logo of your company and ensure that the size of the logo should not exceed 2MB, minimum resolution required is 300 dpi (Accepted Format JPEG, GIF)</p>

<table border="0" cellspacing="0" cellpadding="0" class="formManual">
  <tr>
    <td width="37%"><div class="bottomSpace">
    <?php if($Catalog_CompanyLogo==""){ ?>
    	<img src="images/logo.png" width="200" height="130" alt="Company logo" />
    <?php }else{ ?>
    <img src="images/catalog/<?php echo $_SESSION['EXHIBITOR_CODE'];?>/<?php echo $Catalog_CompanyLogo; ?>" width="200" height="150" alt="" />
    <?php }?>
    </div></td>
    <td width="57%"><div class="bottomSpace">
    <strong>Product Approval</strong>
    </div>
        
        <div class="bottomSpace">
        Status :&nbsp;&nbsp;
		<?php 
		if($CompanyLogo_Approved=='Y')
			echo "<img src='images/correct.png'  alt='' />&nbsp;&nbsp; Approved";
		else if($CompanyLogo_Approved=='N')
			echo "<img src='images/red_cross.png'  alt='' />&nbsp;&nbsp; Disapproved";
		else
			echo "<img src='images/pending.png'  alt='' />&nbsp;&nbsp; Pending";
                                        	
         ?>
         </div>
          <div class="bottomSpace"></div>
         <div class="bottomSpace">
        <?php 
			if($CompanyLogo_Approved=='N')
			{
				echo "Reason:  $CompanyLogo_Reason";
			}else if($ProductLogo_Approved=='')
			{
				echo "Image will be displayed after final submission.";
			}
		?>
      </div>
        
        </td>
    <td width="3%">&nbsp;</td>
    <td width="3%">&nbsp;</td>
  </tr>
  <?php if($CompanyLogo_Approved!='Y') {?>
  <tr>
    <td colspan="2">
    <div class="chooseButton" style="float:left;"><span class="chooseButton" style="float:left;"><span class="chooseButton" style="float:left;"><span class="chooseButton" style="float:left;">
      <input type="file" name="Catalog_CompanyLogo" id="Catalog_CompanyLogo" class="chooseFile" <?php if($CompanyLogo_Approved=='Y' || $CompanyLogo_Approved=='P'){ echo 'disabled=disabled';} ?>/>
    </span></span></span></div> 
   <div class="clear"></div>
          </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <?php }?>
</table>
<div align="center">
<input type="checkbox" name="tandc" value="Y" checked="checked"/>"I hereby give the consent to use the above and attached submitted information and images of my company to be used in the Digital Directory developed by GJEPC"
</div>

<div align="center">
<?php if($Info_Approved=='N' || $ProductLogo_Approved=='N' || $CompanyLogo_Approved=='N' || $Info_Approved=='' || $ProductLogo_Approved=='' || $CompanyLogo_Approved=='' || $_REQUEST['auth']=='admin') { ?>
<?php if($_REQUEST['auth']=="admin" || $_SESSION['ACCESS']=="ADMIN"){ ?>
<?php } ?>
<input type="submit"  name="submit" value="Submit" class="maroon_btn"/>
<?php  } ?>
<a href="manual_list.php"><input name="input2" type="button" value="BACK" class="maroon_btn" /></a>
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
<!--footer ends-->
</body>
</html>
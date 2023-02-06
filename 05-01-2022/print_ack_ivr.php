<?php
include('header_include.php');
if(!isset($_SESSION['USERID'])){ header("location:login.php");	exit; }
$uid = intval($_SESSION['USERID']);
$eid = intval($_REQUEST['id']);

	$fetch_data="select * from ivr_registration_details where uid='$uid' and eid='$eid'";	
	$result = $conn->query($fetch_data);
	if(!$result){	echo "Error: ".$conn->error;	}
	$rows = $result->fetch_assoc();
	
	$date = date("d-m-Y");
	$contact_person = ucwords($rows["first_name"])." ".ucwords($rows["last_name"]);
	$company_name = ucfirst($rows["company_name"]);
	$address1 = $rows["office_add"];
	$address2 = $rows["city"];
	$address3 = $rows["state"];
	$country = getCountryName($rows["country"],$conn);
	
	$office_add = $address1." ".$address2." ".$address3." ".$country;
	$postal_code = $rows["postal_code"];
	$photo_image = $rows["photograph_fid"];
	$photograph_fid = $rows["photo_approval"];
	if($photograph_fid=='Y')
		$photograph_fid="Approved";
	elseif($photograph_fid=='N')
		$photograph_fid="Disapproved";
	else if($photograph_fid=='P')
		$photograph_fid="Pending";	
	
	$passport_fid = $rows["valid_passport_copy_approval"];
	if($passport_fid=='Y')
		$passport_fid="Approved";
	elseif($passport_fid=='N')
		$passport_fid="Disapproved";
	else if($passport_fid=='P')
		$passport_fid="Pending";		
		
	$visit_card_fid = $rows["visiting_card_approval"];
	if($visit_card_fid=='Y')
		$visit_card_fid="Approved";
	elseif($visit_card_fid=='N')
		$visit_card_fid="Disapproved";
	else if($visit_card_fid=='P')
		$visit_card_fid="Pending";
	
	$nri_fid = $rows["nri_photo_approval"];
	if($nri_fid=='Y')
		$nri_fid="Approved";
	elseif($nri_fid=='N')
		$nri_fid="Disapproved";
	else if($nri_fid=='P')
		$nri_fid="Pending";
		
	$personal_info_approval = $rows["personal_info_approval"];
	if($personal_info_approval=='Y')
		$personal_info_approval="Approved";
	elseif($personal_info_approval=='N')
		$personal_info_approval="Disapproved";
	else if($personal_info_approval=='P')
		$personal_info_approval="Pending";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Print Acknowledgment</title>
	<link rel="shortcut icon" href="images/fav.png" />
    <!--navigation script-->
    <script src="js/jquery-1.8.3.min.js" type="text/javascript"></script>
	<script type="text/javascript">
	function PrintContent(){
		var DocumentContainer = document.getElementById("divtoprint");
		var WindowObject = window.open("", "PrintWindow","width=1200,height=650,top=50,left=50,toolbars=no,scrollbars=yes,status=no,resizable=yes");
		WindowObject.document.writeln(DocumentContainer.innerHTML);
		WindowObject.document.close();
		WindowObject.focus();
		WindowObject.print();
		WindowObject.close();
	}
	</script>	
	
  </head>
  <body>
  <a onClick="PrintContent();" target="_blank" style="cursor:pointer;text-align:center;color:#FF0000;font-size:20px; display:block; border:1px solid#0000">Print</a>
  <div id="divtoprint">
<table width="80%" align="center" style="margin:2% auto; border:1px solid #ddd; font-family:Arial, sans-serif; color:#333333; font-size:13px; padding:10px;">
    <tr>
    	<td>
        	<table width="100%" cellspacing="0" style="font-family:Arial, sans-serif; color:#333333; font-size:13px; line-height:20px;">
				<tr>
                	<td align="left"> <img src="https://gjepc.org/images/gjepc_logon.png"/> </td>
                    <td align="right"> <img src="https://registration.gjepc.org/images/iijslogo-2020.png"/> </td>
				</tr>
			</table>
        </td>
  	</tr>
	<tr><td colspan="3" height="30"><hr></td></tr>	
    <tr>    	
        <td>        	
            <p align="center"> <strong> International Visitor Registration </strong> </p>            
            <p align="right"> <img src="images/ivr_image/photograph/<?php echo $photo_image;?>" width="100" height="100" style="align:center;"/> </p> 			
            <p> <strong> Date: <?php echo $date;?></strong> </p>           
            <p>Thank you for registering at IIJS PREMIERE, scheduled from 06th to 10th August 2020, at Bombay Exhibition Centre, Mumbai.</p>           
            <p> <strong> YOUR VISITOR REGISTRATION DETAILS: </strong> </p>            
            <p> <strong> Company Name </strong> : <?php echo $company_name;?> </p>
            <p> <strong> Contact Person </strong> : <?php echo $contact_person;?> </p>
			<p> <strong> Address: </strong><?php echo $office_add.' '.$postal_code;?></p>     
                 
              
			<p> <strong><u>Application No : </u></strong><?php echo $eid;?> </p>
			<p> <strong><u>Application Status : </u></strong></p>
			<p> <strong>Personal Info approval : </strong> <?php echo $personal_info_approval;?></p>
			<p> <strong>Photo Approval:</strong> <?php echo $photograph_fid;?></p>
			<p> <strong>Passport Approval:</strong> <?php echo $passport_fid;?></p>
			<p> <strong>Visiting Card Approval:</strong> <?php echo $visit_card_fid; ?></p>
			<p> <strong>Kindly produce the print acknowledgement at the venue for easy identification.</strong></p>
			<p> <strong>Badges will be available at the registration area during the show.</strong> </p>
			<p> <strong>Free WIFI access code to be collected at the registration area during the show.</strong></p>
			<p> We wish you a fruitful experience at the IIJS and look forward to your continued association with Council&#39;s activities.</p>
			<p> For more information, please contact our visitor registration desk on 1800-103-4353 or write to us on <br> overseas@gjepcindia.com.</p>
               
        </td>        
    </tr>
</table>
</div>
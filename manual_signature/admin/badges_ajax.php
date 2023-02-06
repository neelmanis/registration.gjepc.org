<?php 
include ("../db.inc.php");
include ("../functions.php");
$event = getEventDescription($conn);
if(isset($_POST['actiontype']) && $_POST['actiontype']=="deleteBadges"){
$Badge_Item_ID=$_POST['Badge_Item_ID'];  
$Badge_ID=$_POST['Badge_ID'];
$Exhibitor_Code=$_POST['Exhibitor_Code'];
$Badge_Type=$_POST['Badge_Type'];
$del = $conn ->query("delete from iijs_badge_items where Badge_Item_ID='$Badge_Item_ID'");
if($Badge_Type=="S")
{
		$query=$conn ->query("select * from iijs_payment_master where  Exhibitor_Code='$Exhibitor_Code' and  Form_ID='4'");
		$result=$query->fetch_assoc();
		$Payment_Master_ID=$result['Payment_Master_ID'];
		$Payment_Master_Amount=intval($result['Payment_Master_Amount'])-500;
		$Payment_Master_ServiceTax=$Payment_Master_Amount*18/100;
		$Payment_Master_EducationCess=0;
		$she_cess_tax=0;
		$Payment_Master_AmountPaid=round($Payment_Master_Amount+$Payment_Master_ServiceTax+$Payment_Master_EducationCess+$she_cess_tax);
		$Create_Date=date('Y-m-d h:i:s');
		
		$upd =  $conn ->query("update iijs_payment_master set Form_ID='4',Exhibitor_Code='$Exhibitor_Code',Payment_Master_Amount='$Payment_Master_Amount',Payment_Master_ServiceTax='$Payment_Master_ServiceTax',Payment_Master_EducationCess='$Payment_Master_EducationCess',Payment_Master_AmountPaid='$Payment_Master_AmountPaid',Create_Date='$Create_Date',Modify_Date='$Modify_Date' where Payment_Master_ID='$Payment_Master_ID'");
}
echo  $Badge_ID."#".$Exhibitor_Code;
} 
?>

<?php 
if(isset($_POST['actiontype']) && $_POST['actiontype']=="updateAddress"){
$Exhibitor_Code	=	$_REQUEST['Exhibitor_Code'];
$Badge_Addres	=	strtoupper($_REQUEST['Badge_Addres']);
$Badge_Country	=	strtoupper($_REQUEST['Badge_Country']);
$Badge_City		=	$_REQUEST['Badge_City'];
$Badge_Pincode	=	$_REQUEST['Badge_Pincode'];
$Badge_State	=	$_REQUEST['Badge_State'];
$Badge_Mobile	=	$_REQUEST['address_mobile'];
$Badge_ID=$request['Badge_ID'];

$query1=$conn ->query("select * from iijs_badge_address where Exhibitor_Code='$Exhibitor_Code' limit 0,1");
$num1=$query1->num_rows;
if($num1>0){
$upd = $conn ->query("update iijs_badge_address set BadgeAddres='$Badge_Addres',BadgeCountry='$Badge_Country',BadgeCity='$Badge_City',BadgePincode='$Badge_Pincode',BadgeState='$Badge_State',BadgeMobile='$Badge_Mobile' where Exhibitor_Code='$Exhibitor_Code'");
} else {
$upd = $conn ->query("insert into iijs_badge_address set Exhibitor_Code='$Exhibitor_Code',BadgeAddres='$Badge_Addres',BadgeCountry='$Badge_Country',BadgeCity='$Badge_City',BadgePincode='$Badge_Pincode',BadgeState='$Badge_State',BadgeMobile='$Badge_Mobile'");	
}
echo  $Badge_ID."#".$Exhibitor_Code;
} 
?>

<?php 
if(isset($_POST['actiontype']) && $_POST['actiontype']=="updateBadges"){
	
	$Badge_ID=$_POST['Badge_ID'];
	$order_id=$_POST['order_id'];
	$Exhibitor_Code=$_POST['Exhibitor_Code'];
	$Exhibitor_Section= getExhibitorSection($Exhibitor_Code,$conn);
	$badge=explode(",",$_POST['badge_details']);

	 
	 $badge_count=count($badge);
	 for($i=0;$i<$badge_count;$i++)
	 {
	 	$main_badge=explode('-',$badge[$i]);
		$Badge_Approved=$main_badge[0];
		$Badge_Reason=$main_badge[1];
		$Badge_Item_ID=$main_badge[2];
		$Badge_Type=$main_badge[3];
		
		if($Badge_Approved=="undefined")
			$Badge_Approved="P";
					
		$sql_badge="update iijs_badge_items set Badge_Approved='$Badge_Approved',Badge_Reason='$Badge_Reason' where Badge_ID='$Badge_ID' and Badge_Item_ID='$Badge_Item_ID'";
		$result_badge=$conn ->query($sql_badge);
		if(!$result_badge) die ($conn->error);	
		/*..............................Global Table Start................................................*/
		if($Exhibitor_Section !=="machinery"){
			if($Badge_Approved=="Y"){	
			if($Badge_Type=="R"){
				$replacementID = getReplacementID($Badge_Item_ID,$conn);
				$check1 = $conn ->query("SELECT isDataPosted FROM gjepclivedatabase.globalExhibition where visitor_id='$replacementID' AND participant_Type='EXH'");
				$result=$check1->fetch_assoc();
				$isDataPosted=$result['isDataPosted'];
				if($isDataPosted=="Y"){
					$updateStatus='U';
					$isDataPosted="N";
				}
				else{
					$updateStatus='I';
					$isDataPosted="N";
				}
				$qreplace = "UPDATE gjepclivedatabase.globalExhibition SET srl_report_url='replaced',status='P',isDataPosted='$isDataPosted',updateStatus='$updateStatus',isReplaced='Y' where visitor_id='$replacementID' AND participant_Type='EXH' AND `event`='signature23'";
				$globalQuery = $conn ->query($qreplace);
			}
		$name = strtoupper(getKeyName($Badge_Item_ID,$conn));
		$mobile = getKeyMobile($Badge_Item_ID,$conn);
		$designation = strtoupper(getKeyDesignation($Badge_Item_ID,$conn));
		$Badge_Photo = getKeyPhoto($Badge_Item_ID,$conn);
		$company = getExhibitorName($Exhibitor_Code,$conn);
		$registration_id = getExhibitorID($Exhibitor_Code,$conn);

		$photo_url = "https://registration.gjepc.org/manual_signature/images/badges/".$Exhibitor_Code."/".$Badge_Photo;

		$digits = 9;	
		$uniqueIdentifier = rand(pow(10, $digits-1), pow(10, $digits)-1);
		$checkUniqueIdentifier = $conn->query("SELECT * FROM globalExhibition WHERE `uniqueIdentifier`='$uniqueIdentifier'");
		$countUniqueIdentifier = $checkUniqueIdentifier->num_rows;
		while($countUniqueIdentifier > 0) {
		$uniqueIdentifier = rand(pow(10, $digits-1), pow(10, $digits)-1);
		} 

		$check = "SELECT * FROM gjepclivedatabase.globalExhibition where visitor_id='$Badge_Item_ID' AND registration_id='$registration_id' AND participant_Type='EXH' AND `event`='signature23'";
		$getResult = $conn ->query($check);
		$countx = $getResult->num_rows;
		if($countx>0){
		$global = "UPDATE gjepclivedatabase.globalExhibition SET registration_id='$registration_id',visitor_id='$Badge_Item_ID',fname='$name',designation='$designation',company='$company',photo_url='$photo_url',days_allow='all',mobile='$mobile',agency_category='$Badge_Type',isDataPosted='N',status='$Badge_Approved'  where visitor_id='$Badge_Item_ID' AND participant_Type='EXH' AND `event`='signature23'";
		$globalQuery = $conn ->query($global);
		if(!$globalQuery) die ($conn->error);
		} else {
		$global = "INSERT INTO gjepclivedatabase.globalExhibition SET `uniqueIdentifier`='$uniqueIdentifier',registration_id='$registration_id',visitor_id='$Badge_Item_ID',fname='$name',mobile='$mobile',designation='$designation',company='$company',photo_url='$photo_url',participant_Type='EXH',days_allow='all',`event`='signature23',agency_category='$Badge_Type'";
		$globalQuery = $conn ->query($global);
		if(!$globalQuery) die ($conn->error);
		
		
		}
		
		
	}
}else{
	if($Badge_Approved=="Y"){	
			if($Badge_Type=="R"){
				$replacementID = getReplacementID($Badge_Item_ID,$conn);
				$check1 = $conn ->query("SELECT isDataPosted FROM gjepclivedatabase.globalExhibition where visitor_id='$replacementID' AND participant_Type='EXHM'");
				$result=$check1->fetch_assoc();
				$isDataPosted=$result['isDataPosted'];
				if($isDataPosted=="Y"){
					$updateStatus='U';
					$isDataPosted="N";
				}
				else{
					$updateStatus='I';
					$isDataPosted="N";
				}
				$qreplace = "UPDATE gjepclivedatabase.globalExhibition SET srl_report_url='replaced',status='P',isDataPosted='$isDataPosted',updateStatus='$updateStatus',isReplaced='Y' where visitor_id='$replacementID' AND participant_Type='EXHM' AND `event`='igjme23'";
				$globalQuery = $conn ->query($qreplace);
			}
		$name = strtoupper(getKeyName($Badge_Item_ID,$conn));
		$mobile = getKeyMobile($Badge_Item_ID,$conn);
		$designation = strtoupper(getKeyDesignation($Badge_Item_ID,$conn));
		$Badge_Photo = getKeyPhoto($Badge_Item_ID,$conn);
		$company = getExhibitorName($Exhibitor_Code,$conn);
		$registration_id = getExhibitorID($Exhibitor_Code,$conn);

		$photo_url = "https://registration.gjepc.org/manual_signature/images/badges/".$Exhibitor_Code."/".$Badge_Photo;

		$digits = 9;	
		$uniqueIdentifier = rand(pow(10, $digits-1), pow(10, $digits)-1);
		$checkUniqueIdentifier = $conn->query("SELECT * FROM globalExhibition WHERE `uniqueIdentifier`='$uniqueIdentifier'");
		$countUniqueIdentifier = $checkUniqueIdentifier->num_rows;
		while($countUniqueIdentifier > 0) {
		$uniqueIdentifier = rand(pow(10, $digits-1), pow(10, $digits)-1);
		} 

		$check = "SELECT * FROM gjepclivedatabase.globalExhibition where visitor_id='$Badge_Item_ID' AND registration_id='$registration_id' AND participant_Type='EXHM' AND `event`='igjme23'";
		$getResult = $conn ->query($check);
		$countx = $getResult->num_rows;
		if($countx>0){
		$global = "UPDATE gjepclivedatabase.globalExhibition SET registration_id='$registration_id',visitor_id='$Badge_Item_ID',fname='$name',designation='$designation',company='$company',photo_url='$photo_url',days_allow='all',mobile='$mobile',agency_category='$Badge_Type',isDataPosted='N',status='$Badge_Approved'  where visitor_id='$Badge_Item_ID' AND participant_Type='EXHM' AND `event`='igjme23'";
		$globalQuery = $conn ->query($global);
		if(!$globalQuery) die ($conn->error);
		} else {
		$global = "INSERT INTO gjepclivedatabase.globalExhibition SET `uniqueIdentifier`='$uniqueIdentifier',registration_id='$registration_id',visitor_id='$Badge_Item_ID',fname='$name',mobile='$mobile',designation='$designation',company='$company',photo_url='$photo_url',participant_Type='EXHM',days_allow='all',`event`='igjme23',agency_category='$Badge_Type'";
		$globalQuery = $conn ->query($global);
		if(!$globalQuery) die ($conn->error);
		
		
		}
		
		
	}
}
		
	/*..............................Global Table End................................................*/
	}
	
	$CarPass1=$_POST['CarPass1'];
	$CarPass2=$_POST['CarPass2'];
	$Info_Approved=$_POST['Info_Approved'];
	if($Info_Approved=="Y")
	{
		$Info_Approved_msg="Approved";
	}
	else if($Info_Approved=="N")
	{
		$Info_Approved_msg="Disapproved";
	}
	else
	{
		$Info_Approved_msg="Pending";
	}
	$Info_Reason=$_POST['Info_Reason'];
	$Payment_Master_Approved=$_POST['Payment_Master_Approved'];
	if($Payment_Master_Approved=="Y")
	{
		$Payment_Master_Approved_msg="Approved";
	}
	else if($Payment_Master_Approved=="N")
	{
		$Payment_Master_Approved_msg="Disapproved";
	}
	else
	{
		$Payment_Master_Approved_msg="Pending";
	}

	$Payment_Master_Reason=$_POST['Payment_Master_Reason'];

	if($Info_Approved=='Y' && $Payment_Master_Approved=='Y')
	{
		$Application_Complete='Y';
	}
	else if($Info_Approved=='P' || $Payment_Master_Approved=='P')
	{
		$Application_Complete='P';
	}
	else
	{
		$Application_Complete='N';
	}

	$WaveOff=$_POST['WaveOff'];
	$WaveOff_Reason=$_POST['WaveOff_Reason'];
	$Badge_Addres=$_POST['Badge_Addres'];
	$Badge_Country=$_POST['Badge_Country'];
	$Badge_City=$_POST['Badge_City'];
	$Badge_Pincode=$_POST['Badge_Pincode'];
	$Badge_State=$_POST['Badge_State'];
	$Badge_Mobile=$_POST['Badge_Mobile'];
	$items = $conn ->query("update iijs_badge_items set WaveOff='$WaveOff',WaveOff_Reason='$WaveOff_Reason' where Badge_ID='$Badge_ID' and Badge_Type='E'");

	$payment =  $conn ->query("update iijs_payment_master set Payment_Master_Approved='$Payment_Master_Approved',Payment_Master_Reason='$Payment_Master_Reason' where  Exhibitor_Code='$Exhibitor_Code' and Form_ID='4' and Payment_Master_OrderNo='$order_id'");

	//echo "update iijs_badge set BadgeAddres='$Badge_Addres',BadgeCountry='$Badge_Country',BadgeCity='$Badge_City',BadgePincode='$Badge_Pincode',BadgeState='$Badge_State',BadgeMobile='$Badge_Mobile',Info_Approved='$Info_Approved',Info_Reason='$Info_Reason',Application_Complete='$Application_Complete',CarPass1='$CarPass1',CarPass2='$CarPass2' where Badge_ID='$Badge_ID'";exit;
	$badge = $conn ->query("update iijs_badge set BadgeAddres='$Badge_Addres',BadgeCountry='$Badge_Country',BadgeCity='$Badge_City',BadgePincode='$Badge_Pincode',BadgeState='$Badge_State',BadgeMobile='$Badge_Mobile',Info_Approved='$Info_Approved',Info_Reason='$Info_Reason',Application_Complete='$Application_Complete',CarPass1='$CarPass1',CarPass2='$CarPass2' where Badge_ID='$Badge_ID'");

/*...............................Exhibitor Information.......................................*/

$exhibitor_data="select * from iijs_exhibitor where Exhibitor_Code='$Exhibitor_Code'";
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


	/*.......................................Send mail to users mail id...............................................*/
	$message ='<table width="96%" bgcolor="#fbfbfb" style="margin:2% auto; border:2px solid #ddd; font-family:Arial, sans-serif; color:#333333; font-size:13px; border-radius:10px;">
		<tr>
		<td style="padding:30px;">
		<table width="100%" border="0px" background="#fbfbfb" cellpadding="0px" cellspacing="0px">
		<tr>
		<td align="left" height="60px"><img src="https://gjepc.org/assets/images/logo.png" border="0" width="220"/></td>
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
		<p>Your details for the Online Application for  <strong>EXHIBITOR BADGES FORM</strong> has been updated by IIJS Admin.</p>
		<p>Kindly login at our website - <a href="https://gjepc.org/iijs-signature/">https://gjepc.org/iijs-signature/</a> to verify the same.</p>
		
		<table width="600" border="0" cellspacing="0" cellpadding="0"  style="border:1px solid #ccc;">
		  <tr style="height:20px; border:1px solid  #FF0000; background:#751b53; color:#FFFFFF;">
			<td style="border:1px solid  #cccccc; padding:5px;" ><strong>Details</strong></td>
			<td style="border:1px solid  #cccccc; padding:5px;"><strong>Status</strong></td>
			<td style="border:1px solid  #cccccc; padding:5px;"><strong>Reason for  Disapproval </strong></td>
		  </tr>
		  <tr style="height:20px; border:1px solid  #FF0000;">
			<td style="border:1px solid  #cccccc; padding:5px;" >Information</td>
			<td style="border:1px solid  #cccccc; padding:5px;">'.$Info_Approved_msg.'</td>
			<td style="border:1px solid  #cccccc; padding:5px;">'.$Info_Reason.' </td>
		  </tr>
		  <tr style="height:20px; border:1px solid  #FF0000;">
			<td style="border:1px solid  #cccccc; padding:5px;" >Payment</td>
			<td style="border:1px solid  #cccccc; padding:5px;">'.$Payment_Master_Approved_msg.'</td>
			<td style="border:1px solid  #cccccc; padding:5px;">'.$Payment_Master_Reason.'</td>
		  </tr>
		</table>
		<P>Generate and print your Paper-Badge from 10th December onwards.</p> 
		<p>For further assistance you may please feel free to contact us on 1800-103-4353 / OR give us missed call on +91-7208048100;</p>
	
		<p>A system generated notification will be sent to you on successful approval/Disapproval of your application</p>
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
		
		<map name="Map" id="Map"><area shape="rect" coords="0,0,185,67" href="http://www.iijs.org/"  target="_blank" style="outline:none;"/><area shape="rect" coords="82,58,83,71" href="#" /></map>
		<map name="Map2" id="Map2"><area shape="rect" coords="2,0,312,68" href="http://www.gjepc.org/"  target="_blank" style="outline:none;" /></map>
		</tr>
		</table>';
		
		//$to =$Exhibitor_Email.',notification@gjepcindia.com';
		//$to ='rohit@kwebmaker.com';
		$subject = "".$event." Exhibitor Manual - EXHIBITOR BADGES FORM"; 
		$headers  = 'MIME-Version: 1.0' . "\n"; 
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n"; 
		$headers .= 'From:  "'.$event.'" <admin@gjepc.org>';			
		mail($to, $subject, $message, $headers);
		
		echo  $Badge_ID."#".$Exhibitor_Code;
}
?>
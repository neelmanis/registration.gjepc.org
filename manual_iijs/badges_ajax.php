<?php 
session_start();
include ("db.inc.php");
include ("functions.php");
?>
<?php 
/*.............................Update Exhibitor Address.........................................*/
if(isset($_POST['actiontype']) && $_POST['actiontype']=="updateBadges")
{
$Exhibitor_Code	=	$_REQUEST['Exhibitor_Code'];
$Badge_Addres	=	strtoupper($_REQUEST['Badge_Addres']);
$Badge_Country	=	strtoupper($_REQUEST['Badge_Country']);
$Badge_City		=	$_REQUEST['Badge_City'];
$Badge_Pincode	=	$_REQUEST['Badge_Pincode'];
$Badge_State	=	$_REQUEST['Badge_State'];
$Badge_Mobile	=	$_REQUEST['Badge_Mobile'];

$query1 = $conn ->query("select * from iijs_badge_address where Exhibitor_Code='$Exhibitor_Code' limit 0,1");
$num1 = $query1->num_rows;
if($num1>0){
$address = $conn ->query("update iijs_badge_address set BadgeAddres='$Badge_Addres',BadgeCountry='$Badge_Country',BadgeCity='$Badge_City',BadgePincode='$Badge_Pincode',BadgeState='$Badge_State',BadgeMobile='$Badge_Mobile' where Exhibitor_Code='$Exhibitor_Code'");
} else {
$address = $conn ->query("insert into iijs_badge_address set Exhibitor_Code='$Exhibitor_Code',BadgeAddres='$Badge_Addres',BadgeCountry='$Badge_Country',BadgeCity='$Badge_City',BadgePincode='$Badge_Pincode',BadgeState='$Badge_State',BadgeMobile='$Badge_Mobile'");	
}
} 
?>
<?php 
/*.............................Update Exhibitor Address.........................................*/
if(isset($_POST['actiontype']) && $_POST['actiontype']=="checkMobileno")
{
	$mobile_no = $_REQUEST['mobile_no'];
	$mob = $conn->query("select * from iijs_badge_items where Badge_Mobile='$mobile_no'");
	$num = $mob->num_rows;
	$mob_temp = $conn->query("select * from iijs_badge_items_tmp where Badge_Mobile='$mobile_no'");
	$num_temp = $mob_temp->num_rows;
	
	$hostname = "localhost";
	$uname = "gjepcliveuserdb";
	$pwd = "KGj&6(pcvmLk5";
	$database = "gjepclivedatabase";
	// Create connection
	$conn1 = new mysqli($hostname, $uname, $pwd, $database);
	
	$query_sel = $conn1->query("SELECT * FROM visitor_directory where mobile='$mobile_no' and visitor_approval='Y'");
	$num_vis_dir = $query_sel->num_rows;
	
	if($num==0 && $num_temp==0)
		echo 1;
	else
		echo 0;
}
?>

<?php 
if(isset($_POST['actiontype']) && $_POST['actiontype']=="addExhBadges")
{	
	$Payment_Mode_ID=$_POST['Payment_Mode_ID'];
	$Exhibitor_Code=$_POST['Exhibitor_Code'];
	
	$exhibitor_data="select * from iijs_exhibitor where Exhibitor_Code='$Exhibitor_Code'";
	$result=$conn->query($exhibitor_data);
	$fetch_data = $result->fetch_assoc();
	
	$Exhibitor_Name=strtoupper($fetch_data['Exhibitor_Name']);
	$Exhibitor_Email=$fetch_data['Exhibitor_Email'];
	$Exhibitor_Contact_Person=strtoupper($fetch_data['Exhibitor_Contact_Person']);	
	
	$Collection_Mode=$_POST['Collection_Mode'];

	$query = $conn ->query("SELECT sum(exhibitor_maintenance_charge) as exhibitor_maintenance_charge,sum(surcharge) as Surcharge from iijs_badge_items_tmp where Exhibitor_Code='$Exhibitor_Code'");	
	$result = $query->fetch_assoc();
	$Payment_Master_Amount= intval($result['exhibitor_maintenance_charge'])+intval($result['Surcharge']);
	$Payment_Master_ServiceTax=$Payment_Master_Amount*18/100;
	$Payment_Master_AmountPaid=round($Payment_Master_Amount+$Payment_Master_ServiceTax);
	$Create_Date=date('Y-m-d h:i:s');
	
	$qorder = $conn->query("select * from iijs_payment_master order by `Payment_Master_ID` desc limit 1");
	$num = $qorder->num_rows;
	$strNo = rand(1,1000000);
	$Payment_Master_OrderNo = 'BADGE'.$strNo;
	
	$paymentSql = "insert into iijs_payment_master set Form_ID='4',Exhibitor_Code='$Exhibitor_Code',Payment_Master_OrderNo='$Payment_Master_OrderNo',Payment_Mode_ID='1',Payment_Master_Amount='$Payment_Master_Amount',Payment_Master_ServiceTax='$Payment_Master_ServiceTax',Payment_Master_AmountPaid='$Payment_Master_AmountPaid',tds_tax='0',tds_amount='0',net_payable_amount='0',Create_Date='$Create_Date',Payment_Master_Approved='Y'";
	$paymentResult = $conn->query($paymentSql);
	if(!$paymentResult) die ($conn->error);
	$Payment_Master_ID = mysqli_insert_id($conn);
	
	$query = $conn ->query("insert into iijs_badge set BadgeAddres='0',BadgeCountry='0',BadgeCity='0',BadgePincode='0',BadgeState='0',BadgeMobile='0',Exhibitor_Code='$Exhibitor_Code',Payment_Master_ID='$Payment_Master_ID',Collection_Mode='$Collection_Mode',Create_Date='$Create_Date'");
	$Badge_ID = mysqli_insert_id($conn);
	
	$query = $conn->query("SELECT * FROM `iijs_badge_items_tmp` WHERE `Exhibitor_Code`='$Exhibitor_Code'");
	while($result = $query->fetch_assoc())
	{
		$Badge_Item_ID=$result['Badge_Item_ID'];
		$Exhibitor_Code=$result['Exhibitor_Code'];
		$Badge_Type = $result['Badge_Type'];
		$Badge_Name = strtoupper(filter($result['Badge_Name']));
		$Badge_Designation=$result['Badge_Designation'];
		$Badge_Mobile = filter($result['Badge_Mobile']);
		$Badge_Photo=$result['Badge_Photo'];
		$Badge_Document=$result['Badge_Document'];
		$exhibitor_maintenance_charge=$result['exhibitor_maintenance_charge'];
		$Surcharge=$result['surcharge'];
		
	$mm = "insert into iijs_badge_items set Exhibitor_Code='$Exhibitor_Code',Badge_ID='$Badge_ID',Badge_Name='$Badge_Name',Badge_Designation='$Badge_Designation',Badge_Mobile='$Badge_Mobile',Badge_Photo='$Badge_Photo',Badge_Document='$Badge_Document',Badge_Type='$Badge_Type',Surcharge='$Surcharge',Waveoff_Reason='0',Create_Date='$Create_Date'";
	$mResult = $conn->query($mm);	
	if(!$mResult) die ($conn->error);
	$del = $conn ->query("delete from iijs_badge_items_tmp where Badge_Item_ID='$Badge_Item_ID'");
	}
	
	$message ='<table width="96%" style="margin:2% auto; border:2px solid #ddd; font-family:Arial, sans-serif; color:#333333; font-size:13px; border-radius:10px;">
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
	<p>Thank you for applying Online for <strong>Form No. 2. EXHIBITOR BADGES FORM</strong> with Order number '.$Payment_Master_OrderNo.' </p>
	<P>Download and print your Paper-Badge from GJEPC App. 2 dose of vaccines is compulsory to visit the show. 
	<p>Please Upload Your Vaccination Certificate. For further assistance you may please feel free to contact us on 1800-103-4353 / OR give us missed call on +91-7208048100;</p>
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
	</tr>
	</table>';
	
	$to =$Exhibitor_Email.',notification@gjepcindia.com';
	//$to ='rohit@kwebmaker.com';
	$subject  = "IIJS PREMIERE 2022 Exhibitor Manual - Form No. 2. EXHIBITOR BADGES FORM";	
	$headers  = 'MIME-Version: 1.0' . "\n";	
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n";
	$headers .= 'From:IIJS PREMIERE 2022 <admin@gjepc.org>';
	@mail($to, $subject, $message, $headers);
} 
?>
<?php
include('header_include.php');
if(!isset($_SESSION['USERID'])){	header("location:login.php");	exit;	}
$show = filter($_REQUEST["show"]);

//$sql="select * from approval_master where registration_id='".$_SESSION['USERID']."' AND (`membership_issued_certificate_dt` between '2019-03-31' and '2020-03-31' || invoice_date between '2019-03-31' and '2020-03-31')";
$sql="SELECT * FROM `approval_master`  WHERE 1 and `registration_id`='".$_SESSION['USERID']."' AND issue_membership_certificate_expire_status='Y'";
$result=$conn->query($sql);
$rows1=$result->fetch_assoc();
$num_rows=$result->num_rows;
if($num_rows>0)
{
	$type='M';
} else {
	$type='NM';
}

if(isset($type) && !empty($type))
{
$sql="SELECT * FROM `visitor_fee_structure` WHERE min_date <=  NOW() AND max_date >=  NOW() AND type='$type'";
$result=$conn->query($sql);
while($rows2=$result->fetch_assoc())
{
	if($show == "signature2")
		echo $participation_fee=$rows2['igjme_signature'];
	elseif($show == "igjme")
		echo $participation_fee=$rows2['igjme'];
	else
		echo "";
	
	/* if($show == "vbsm2")
		echo $participation_fee=$rows2['vbsm'];
	else
		echo ""; */
	/*if($show == "1show")
		echo $participation_fee=$rows2['1show'];
	elseif($show == "4show")
		echo $participation_fee=$rows2['4show'];
	elseif($show == "combo")
		echo $participation_fee=$rows2['combo'];
	elseif($show == "igjme")
		echo $participation_fee=$rows2['igjme'];
	else
		echo ""; */
}
}
?>
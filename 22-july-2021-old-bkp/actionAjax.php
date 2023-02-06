<?php 
include ("db.inc.php");
include ("functions.php");
session_start();
$registration_id = intval(filter($_SESSION['USERID']));
if(!isset($registration_id)){ header("location:login.php");	exit; }
?>
<?php
if(isset($_POST['actiontype']) && $_POST['actiontype']=="saveVisitorDetails")
{ //print_r($_POST); exit;
	$visitor_id = filter($_POST['visitor_id']);
	$payment_made_for = filter($_POST['payment_made_for']);
	$amount	=	filter($_POST['participation_fee']);
	$show	=	filter($_POST['show']);
	$year	=	filter($_POST['year']);
	
	if(isset($registration_id) && $registration_id!=""){
	if($visitor_id!='0' && !empty($visitor_id) && !empty($payment_made_for) && !empty($show)){
	$checkVisitor = "SELECT * FROM `visitor_order_temp` WHERE visitor_id='$visitor_id' AND registration_id='$registration_id' AND `show`='$show' AND `year`='$year' AND `status`='1' AND paymentThrough='online'";
	$checkVisitorResult = $conn->query($checkVisitor);
	$getCountx = $checkVisitorResult->num_rows;
	if($getCountx==0)
	{
	$ins = "INSERT INTO `visitor_order_temp`(`registration_id`, `visitor_id`, `payment_made_for`, `amount`,`show`, `year`, `status`,`paymentThrough`) VALUES ('$registration_id','$visitor_id','$payment_made_for','$amount','$show','$year','1','online')"; 
	$getResult = $conn->query($ins);
	if($getResult)
		{
			echo 'Y';
		}
	} else {
		echo 'N';
	}
	} else {
	  echo 'E';	
	}
	}
}
?>

<?php
if(isset($_POST['actiontype']) && $_POST['actiontype']=="deleteItemDetails"){
	$id = trim($_POST['v_id']);
	$sqlx = "delete from visitor_order_temp where id='$id' AND registration_id='$registration_id'";
	$deleteResult = $conn->query($sqlx);
}
?>

<?php
if(isset($_POST['actiontype']) && $_POST['actiontype']=="checkDesignation")
{ //print_r($_POST); exit;
	$designation = filter($_POST['designation']);
	$sqlx= "SELECT * FROM `visitor_designation_master` WHERE type='$designation'";
	$query = $conn->query($sqlx);
	?>
	<select name="designation" id="designation" class="textField">
      <option value="">--Select Designation--</option>
      <?php while($result=$query->fetch_assoc()){?>
      <option value="<?php echo filter($result['role_type']);?>"><?php echo filter($result['type_of_designation']);?></option>
      <?php }?>
    </select>
<?php	
}
?>

<?php
if(isset($_POST['actiontype']) && $_POST['actiontype']=="getEvent")
{ //print_r($_POST); exit;
	$visitors_ID = filter($_POST['visitors_ID']);
	$visitor_designationType = getVisitorDesignationType($visitors_ID,$conn);
	if(!empty($visitor_designationType))
	{ ?>
	<select name="payment_made_for" id="payment_made_for" onchange="fees_calculate(this.value)" class="selectField" style="width:100%">
		<option value="">--- Please Select One ---</option>
		<option value="signature2" <?php if($payment_made_for=="signature2") echo "selected"; ?>>IIJS Premiere 2020 + Machinery 2020</option>
		<option value="igjme" <?php if($payment_made_for=="igjme") echo "selected"; ?>>Machinery 2020</option>
	</select>
	<?php } ?>
	
	<!--<select name="payment_made_for" id="payment_made_for" onchange="fees_calculate(this.value)" class="selectField" style="width:100%">
		<option value="">--- Please Select One ---</option>
		<option value="vbsm2" <?php if($payment_made_for=="vbsm") echo "selected"; ?>>IIJS Virtual Show 2021</option>
	</select>-->
	<?php /*
	if($visitor_designationType == "Owner"){ ?>
	<select name="payment_made_for" id="payment_made_for" onchange="fees_calculate(this.value)" class="selectField" style="width:100%">
		<option value="">--- Please Select One ---</option>
		<option value="1show" <?php if($payment_made_for=="1show") echo "selected"; ?>>IIJS Premiere 2020 + Machinery 2020</option>
		<option value="combo" <?php if($payment_made_for=="combo") echo "selected"; ?>>IIJS Premiere 2020 + IIJS Signature 2021 + Machinery 2020</option>
		<option value="4show" <?php if($payment_made_for=="4show") echo "selected"; ?>>IIJS Premiere 2020 + IIJS Signature 2021 + IIJS Premiere 2021 + IIJS Signature 2022</option>
		<option value="igjme" <?php if($payment_made_for=="igjme") echo "selected"; ?>>Machinery 2020</option>
	</select>
	<?php } else { ?>
	<select name="payment_made_for" id="payment_made_for" onchange="fees_calculate(this.value)" class="selectField" style="width:100%">
		<option value="">--- Please Select One ---</option>
		<option value="1show" <?php if($payment_made_for=="1show") echo "selected"; ?>>IIJS Premiere 2020 + Machinery 2020</option>
		<option value="combo" <?php if($payment_made_for=="combo") echo "selected"; ?>>IIJS Premiere 2020 + IIJS Signature 2021 + Machinery 2020</option>
		<option value="4show" <?php if($payment_made_for=="4show") echo "selected"; ?>>IIJS Premiere 2020 + IIJS Signature 2021 + IIJS Premiere 2021 + IIJS Signature 2022</option>
		<option value="igjme" <?php if($payment_made_for=="igjme") echo "selected"; ?>>Machinery 2020</option>
	</select>
	<?php } */
}
?>

<?php
if(isset($_POST['action']) && $_POST['action']=="saveCovidDetails")
{
	//echo '<pre>';  print_r($_POST); exit;	
	$registration_id = $_POST['registration_id'];
	$visitor_id = $_POST['visitor_id'];
	$pan_no = $_POST['pan_no'];
	$mobile_no = $_POST['mobile_no'];
	$via = $_POST['valueType'];
	$lab_name = $_POST['labs'];
	$location = $_POST['location'];
	
	if(empty($registration_id && $visitor_id)){
	  header("location:single_visitor.php"); exit;
	}
		
	$sqlx = "INSERT INTO `visitor_lab_info` (`registration_id`, `visitor_id`, `pan_no`, `mobile_no`, `via`, `lab_name`, `location`, `status`) VALUES ('$registration_id', '$visitor_id', '$pan_no', '$mobile_no', '$via', '$lab_name', '$location', '1');";
	$ansData = $conn ->query($sqlx);
	if($ansData){
	echo json_encode($data = array("status"=>'success')); exit;
	} else {
	$updateData =  $conn->query("UPDATE visitor_lab_info SET via='$via', lab_name='$lab_name', location='$location' WHERE registration_id='$registration_id' AND visitor_id='$visitor_id'");
	echo json_encode($data = array("status"=>'error')); exit;
	}
}
?>
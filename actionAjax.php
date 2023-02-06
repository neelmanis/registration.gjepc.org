<?php 
include ("db.inc.php");
include ("functions.php");
session_start();
$registration_id = intval(filter($_SESSION['USERID']));
if(!isset($registration_id)){ header("location:login.php");	exit; }
?>
<?php
if(isset($_POST['actiontype']) && $_POST['actiontype']=="saveVisitorDetails")
{  
	// echo "<pre>"; print_r($_POST);exit;
	$visitor_id = filter($_POST['visitor_id']);
	$payment_made_for = filter($_POST['payment_made_for']);
	$amount	=	filter($_POST['participation_fee']);
	
	// GET SHOW YEAR FROM MASTER

	$year	=	getVisEventYear($_POST['payment_made_for'],$conn);
	
	if(isset($registration_id) && $registration_id!=""){
		if($visitor_id!='0' && !empty($visitor_id) && !empty($payment_made_for) ){

			// CHECK CURRENTLY SELECTED SHOW IS DIFFERENT THAN TEMP SHOW
			$checkTemp = "SELECT * FROM `visitor_order_temp` WHERE  registration_id='$registration_id' AND `show` !='$payment_made_for'  AND `status`='1' AND paymentThrough='online'";
			$checkTempResult = $conn->query($checkTemp);
			$getTempCount = $checkTempResult->num_rows;
			if($getTempCount>0)
			{
				echo json_encode(array("status"=>"error","message"=>"Please complete your registration for previous selected show and continue"));exit;
			}else{
				$checkVisitor = "SELECT * FROM `visitor_order_temp` WHERE visitor_id='$visitor_id' AND registration_id='$registration_id' AND `show`='$payment_made_for' AND `year`='$year' AND `status`='1' AND paymentThrough='online'";
				$checkVisitorResult = $conn->query($checkVisitor);
				$getCountx = $checkVisitorResult->num_rows;
				if($getCountx==0)
				{
					  $ins = "INSERT INTO `visitor_order_temp`(`registration_id`, `visitor_id`, `payment_made_for`, `amount`,`show`, `year`, `status`,`paymentThrough`) VALUES ('$registration_id','$visitor_id','$payment_made_for','$amount','$payment_made_for','$year','1','online')"; 
					$getResult = $conn->query($ins);
					if($getResult)
						{
							echo json_encode(array("status"=>"success","message"=>"Visitor has been added successfully"));exit;

						}
				} else {
					echo json_encode(array("status"=>"error","message"=>"Visitor is already added"));exit;
				}
			}

		} else {
			echo json_encode(array("status"=>"error","message"=>"Something went wrong"));exit;

		}
	}
}
?>

<?php
if(isset($_POST['actiontype']) && $_POST['actiontype']=="deleteItemDetails"){
	$id = trim($_POST['v_id']);
	$sqlx = "delete from visitor_order_temp where id='$id' AND registration_id='$registration_id'";
	$deleteResult = $conn->query($sqlx);
	if(!$deleteResult){  echo("Error description: " . mysqli_error($conn)); } exit;
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
		<option value="signature22" <?php if($payment_made_for=="signature22") echo "selected"; ?>>IIJS SIGNATURE 2022 Show</option>
		<!--<option value="igjme22" <?php if($payment_made_for=="igjme22") echo "selected"; ?>>Machinery 2022</option>-->
	</select>
<?php } 
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
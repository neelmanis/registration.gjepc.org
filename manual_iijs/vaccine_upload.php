<?php 
include('header_include.php');
if(!isset($_SESSION['EXHIBITOR_CODE'])){	header("location:index.php");exit; }
?>
<?php 
$hostname_main = "localhost";
$uname_main = "gjepcliveuserdb";
$pwd_main = "KGj&6(pcvmLk5";
$database_main = "gjepclivedatabase";

// Create connection
$conn_main = new mysqli($hostname_main, $uname_main, $pwd_main, $database_main);
// Check connection
if ($conn_main->connect_error) {
    die("Connection failed: " . $conn_main->connect_error);
} else {
	
}

date_default_timezone_set('Asia/Kolkata');
$cr_date=date('d-m-Y H:i:s');
$exhibitor_code = $_SESSION['EXHIBITOR_CODE'];

$exhibitor_data="select * from iijs_exhibitor where Exhibitor_Code='$exhibitor_code'";
$result = $conn ->query($exhibitor_data);
$fetch_data = $result->fetch_assoc();

$Exhibitor_Name=$fetch_data['Exhibitor_Name'];
$registration_id = $fetch_data['Exhibitor_Registration_ID'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Vaccination certificate</title>
<link rel="stylesheet" type="text/css" href="css/mystyle.css" />
<!--navigation script-->
<!--<script type="text/javascript" src="../js/jquery_002.js"></script>-->
<!-- <script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>  -->
<script src="https://code.jquery.com/jquery-1.12.4.min.js" ></script>
<!--manual form css-->
<script src="js/electronic_surveillance.js"></script>
<script src="js/jquery.validate.js" type="text/javascript"></script>
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
    top: -8%;
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
	float:right;
	color:#fff;
    background-color: #924b77;	
	margin-left:10px;
}
#formWrapper .spanbox a,#formWrapper .spanbox strong{
	color:#fff;
}
.tooltip{float:right;}
.error{color: red;}
.bigTextField { width: 100%; height: 110px; }
.alert{
	background: lightgreen;
	padding: 20px 10px;
}
</style>

<script type="text/javascript">
	$(document).ready(function(){
	    $("#vaccine-upload").hide();
		$('input[name="valueType"]').click(function(){
			var valueType = $('[name="valueType"]:checked').val();
			$("#vaccine-upload").show();

			if(valueType =="dose1"){
              $("#for_vaccine_certificate").html('Attach First dose vaccine certificate');
			} else {
              $("#for_vaccine_certificate").html('Attach Second dose vaccine certificate');
				
			}
		});
	});	
</script>
<script type="text/javascript">
$(document).ready(function()
{
	$("#regisForm").validate({
rules: {
		exhibitor_id:{
		required:true,
		},
		valueType:{
		required:true,
		},
		vaccine_certificate:{
		required:true,
		accept:"jpg,png,jpeg,pdf"
		},
		agree:{
		required:true,
		}
},
messages: {
		exhibitor_id:{
		required: "Select Exhibitor",
		},
		valueType:{
		required: "Select any one of the above",
		},
		vaccine_certificate:{
		required: "Upload Vaccine certificate",
		accept:"Please select only jpg,png,jpeg,pdf file"
		},
		agree:{
		required: "Please select Terms & Condition",
		}
	},
		submitHandler: covidAction
});
	});
			
function covidAction(){
		$('#submit').val('please wait...');
		$('#submit').attr('disabled',true);
	    var form = $('#regisForm');
	    var formdata = false;
	    if (window.FormData){
	        formdata = new FormData(form[0]);
	    }
	    $.ajax({
		    type:'POST',
		    url:"vaccine_upload_ajax.php",
		    data:formdata ? formdata : form.serialize(),
		    dataType: "json",
		    cache:false,
		    contentType: false,
		    processData: false,
		    
		    beforeSend: function(){
		    	$('#submit').val('please wait...');
		    	$('#submit').attr('disabled',true);	
		   		$('.loaderWrapper').show();
		    },
		    success:function(data){
		    	$('.loaderWrapper').delay(2000).fadeOut();
			    if(data.status == 'success'){
			    	$("#regisForm")[0].reset();
	
					$("#formWrapper2").html('<div class="col-12"><div class="alert alert-success" role="alert">'+data.message+'</div></div>');
					 setTimeout(function(){
					    window.location = "vaccine_upload.php?action=upload-vaccine";
					  },3000)
					// if(data.device=="android"){
	                // window.location.href ="https://registration.gjepc.org/openApp.php";
					// }else if(data.device=="ios"){
					// }else{
				    // window.location = "single_visitor.php";
					// }
					$('#submit').val('Submit');		
					$('#submit').attr('disabled',false);		
				  
			    } else if(data.status =='error'){
				    alert(data.message);
					$('#submit').val('Submit');		
					$('#submit').attr('disabled',false);		
				   
			    }
		    }
	    });
    }
</script>

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
<h3>Vaccination Certificate Upload</h3>

<div class="clear"></div>
<div class="clear"></div>
<?php 
$action = $_REQUEST['action'];

?>
    <?php if($action ="upload-vaccine"){ ?>
    	<div id="formWrapper2">
	<form method="POST" name="regisForm" id="regisForm">
						<input type="hidden" name="action" value="UpdateCovidReport"/>
						<input type="hidden" name="registration_id" value="<?php echo $registration_id;?>"/>					
						
						<div class="row">
							<div><b class="d-block">Select Exhibitor</b></div>
							<div class="col-12">
							<?php
							$exh_list_sql =  "SELECT * FROM `iijs_badge_items` WHERE Exhibitor_Code='$exhibitor_code' AND `badge_approved`='Y'"; 
							$exh_list_result = $conn->query($exh_list_sql);
							$exh_list_count = $exh_list_result->num_rows; ?>
							
							<select name="exhibitor_id" id="exhibitor_id" class="textField" >
								<option value="">Select</option>
								<?php if($exh_list_count > 0){
							 	while($exh_list_row = $exh_list_result->fetch_assoc()){?>
								<option value="<?php echo $exh_list_row['Badge_Item_ID']?>"><?php echo $exh_list_row['Badge_Name']?></option>
							<?php }
							 } ?>
							</select>
							</div>
							<div class="col-12">
								<label for="exhibitor_id" generated="true" class="error d-none" style="display:none;">Select any one of the above</label>
							</div>
							<div><b class="d-block">Select vaccine dose</b></div>
							<div class="col-12">
								<label>
									<input type="radio" id="dose2" name="valueType" value="dose2"/>&nbsp;&nbsp;Second Dose
								</label>
							</div>
							<div class="col-12">
								<label for="valueType" generated="true" class="error d-none" style="display:none;">Select any one of the above</label>
							</div>
						
							<div class="col-12 mb-2" id="vaccine-upload" >
								
								<div class="row">
									
									<div class="form-group col-sm-6">
										<div class="row">
											<div class="col-12"><label id="for_vaccine_certificate"> </label></div>
											<div class="col-12 "><input type="file" name="vaccine_certificate" class="form-control" id="vaccine_certificate" style="width:100%"></div>
											<div class="col-12"><i>(.jpg,png,pdf and maximum 2mb size allowed)</i></div>
										</div>
										
										
									</div>
								</div>
							</div>
							<div class="col-12 mb-2">
								<div class="d-block">
									<input type="checkbox" name="agree" value="YES"> I Accept that <br/>
									<p>1. I have read and understood the 
									<a href="pdf/IIJS-Premeire-2022-T-&-C.pdf" target="_blank"><strong>terms and conditions </strong></a> with regard to the visitor's registration at IIJS PREMIERE 2022.<br/>
									2.	I confirm that the upload vaccination certificate is genuine and valid.<br/>
									3.	I agree to abide by the terms and conditions applicable for domestic visitor's registration set by "The Gem & Jewellery Export Promotion Council (GJEPC)".<br/>
									4.	I accept that GJEPC reserves the rights of admission to the show. <br/>
									</p>
								</div>
								
								<label for="agree" generated="true" style="display: none;" class="error"></label>
							</div>
							<div class="col-12">
								<input type="submit" name="submit" id="submit" value="Submit" class="maroon_btn">
							</div>
						</div>
						
					</form>
					</div>
<?php } ?>

<div class="clear"></div>
<hr style="margin-top: 30px;">
<h2 >Application Summary</h2>
<table  cellspacing="0" cellpadding="0" class="common">
	<tbody>
	<tr>
	<th valign="top">Sr. No.</th>
	<th valign="top">Date</th>
    <th valign="middle">Badge Name</th>
	<th valign="middle">Mobile</th>
    <th valign="middle">Vaccine</th>
    <th valign="middle">Dose 2 Status</th>
	<th valign="middle">Remark</th>
    <th valign="middle">View</th>
	</tr>
	
	<?php
	$i=1;
	//$query = $conn_main->query("SELECT * FROM `visitor_lab_info` WHERE registration_id='$registration_id' AND category_for='EXH' order by create_date desc");
		$badge_info = $conn->query("SELECT * FROM iijs_badge_items WHERE 1 AND exhibitor_code='$exhibitor_code'");
		$count = $badge_info->num_rows;
		if($count>0){
		while($badge_row = $badge_info->fetch_assoc()){
		$badge_name = $badge_row['Badge_Name'];
		$badge_mobile = $badge_row['Badge_Mobile'];
		$lab = "SELECT * FROM `visitor_lab_info` WHERE mobile_no='$badge_mobile' AND category_for='EXH' order by create_date desc";
		$query2 = $conn_main->query($lab);
		$countx = $query2->num_rows;
		if($countx>0){
		$row = $query2->fetch_assoc();
		$create_date = $row['create_date'];
		
		if($row['certificate'] =="dose1"){
			$vaccine = "Dose 1";
			$vaccine_file = $row['dose1'];
		}else{
			$vaccine = "Dose 2";
			$vaccine_file = $row['dose2'];

		}

		$dose1_status = $row['dose1_status'];
		$dose2_status = $row['dose2_status'];
		$remark = $row['remark'];
		
		if($dose1_status =="P"){
          $dose1_status ="Pending";
		}elseif($dose1_status =="Y"){
		  $dose1_status ="Approved";
		}elseif($dose1_status =="N"){
		  $dose1_status ="Disapproved";
		}elseif($dose1_status =="U"){
		  $dose1_status ="Pending";
		}
		if($dose2_status =="P"){
          $dose2_status ="Pending";
		}elseif($dose2_status =="Y"){
		  $dose2_status ="Approved";
		}elseif($dose2_status =="N"){
		  $dose2_status ="Disapproved";
		}elseif($dose2_status =="U"){
		  $dose2_status ="Pending";
		}
		
         
	?>
	<tr>
	<td valign="middle"><?php echo $i;?></td>
	<td valign="middle"><?php echo $create_date ;?></td>
	<td valign="middle"><?php echo $badge_name;?></td>
	<td valign="middle"><?php echo $badge_mobile;?></td>
	<td valign="middle"><?php echo $vaccine;?></td>
	<td valign="middle"><?php echo $dose2_status;?></td>
	<td valign="middle"><?php echo $remark;?></td>
	<td valign="middle"><a class="maroon_btn" href="https://registration.gjepc.org/images/covid/exh/<?php echo $registration_id; ?>/vaccine_certificate/<?php echo $vaccine_file;?>" target="_blank">View</a></td>
	</tr>
		<?php  $i++; } } }?>
	</tbody>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="formManual" style="width:550px;"></table>

<div class="clear"></div>	
</form>

</div>

<div class="clear"></div>
</div>
</div>
<div class="footer_wrap">
<?php include ('footer.php'); ?>
</div>
<!--footer ends-->
</body>
</html>
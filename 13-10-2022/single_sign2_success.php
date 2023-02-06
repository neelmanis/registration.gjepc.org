<?php include('header_include.php');
if(!isset($_SESSION['registration_id'])){ header("location:login.php");	exit; }
if(!isset($_SESSION['isFree']) && $_SESSION['isFree']!="yes"){ header("location:login.php");	exit; }

$registration_id = $_SESSION['registration_id'];
$visitor_id = $_SESSION['visitor_id'];
$email = getVisitorEmail($visitor_id,$conn); 
$CompanyName = getCompanyName($registration_id,$conn); 
$visitorName = getVisitorName($visitor_id,$conn); 
$visitorMobile = getVisitorMobile($visitor_id,$conn);
$visitorPAN = getVisitorPAN($visitor_id,$conn);
$ownerMobile = getOwnerVisitorMobile($registration_id,$conn);
$visitoSecondaryMobile = getVisitorSecondaryMobile($visitor_id,$conn);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome to IIJS</title>
<link rel="shortcut icon" href="images/fav.png" />
	<link rel="stylesheet" type="text/css" href="css/mystyle.css" />
	<link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Cabin'>
	<link rel="stylesheet" type="text/css" href="css/general.css" />
	<link rel="stylesheet" type="text/css" href="css/inner_pg_style.css" />
	 
	<link rel="stylesheet" type="text/css" href="css/responsive.css" />
	<link rel="stylesheet" type="text/css" href="css/media_query.css" />
	<link rel="stylesheet" type="text/css" href="css/visitor_reg.css?v=<?php echo $version;?>" />
	<link rel="stylesheet" type="text/css" href="css/jquery.fancybox.min.css?v=<?php echo $version;?>" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>
	<script type="text/javascript" src="js/jquery.fancybox.min.js?v=<?php echo $version;?>"></script>
	<!--NAV-->
	<link href="css/flexnav.css" media="screen, projection" rel="stylesheet" type="text/css">
	<script src="js/jquery.flexnav.js" type="text/javascript"></script>
	<script src="js/common.js"></script> 
	<!--NAV-->
	 <script src="jsvalidation/jquery.validate.js" type="text/javascript"></script>

	<!-- UItoTop plugin -->
	<link rel="stylesheet" type="text/css" media="screen,projection" href="css/ui.totop.css" />
	<script src="js/easing.js" type="text/javascript"></script>
	<script src="js/jquery.ui.totop.js" type="text/javascript"></script>    
	<script type="text/javascript">
		$(document).ready(function() {        
			$().UItoTop({ easingType: 'easeOutQuart' });        
		});
	</script>
	<style type="text/css">
		.container_wrap{  border: 1px solid#aa9e5f;}
		.error{color:red;}
	</style>

</head>

<body>
<div class="wrapper">

<div class="header">
	<?php include('header1.php'); ?>
</div>
<!--container starts-->

<?php
$show ="signature2";
$year = 2021;
$orderId=$_SESSION['orderId'];
$post_date=date('Y-m-d');

	if(isset($registration_id) && $registration_id!="")
	{
		$orderUpdate ="update visitor_order_detail set payment_status='Y' where orderId='$orderId' AND regId='$registration_id' AND paymentThrough='single' ";
		$getResult = $conn->query($orderUpdate);
		if(!$getResult) { die($conn->error); }
		$ssx = "SELECT * FROM `visitor_order_temp` WHERE `registration_id`='$registration_id' AND `show`='$show' AND `year`='$year' AND paymentThrough='single' AND orderId='$orderId'";
		$query_result=$conn->query($ssx);
		while($result1=$query_result->fetch_assoc())
		{ //echo '<pre>'; print_r($result1);
			$visitor_id = $result1['visitor_id'];
			$payment_made_for = $result1['payment_made_for'];		
			$amount = $result1['amount'];
			$show = $result1['show'];
			$year = $result1['year'];
		
		/*Global Table Start */
		
		$name = getVisitorName($visitor_id,$conn);
		$visitorPAN = getVisitorPAN($visitor_id,$conn);
		$visitorMobile = getVisitorMobile($visitor_id,$conn);
		$designation = getVisitorDesignation($visitor_id,$conn);
		$visitorDesignation =  getVisitorDesignationID($designation,$conn); 
		$visitorPhoto =  getVisitorPhoto($visitor_id,$conn); 		 
		$photo_url = "https://registration.gjepc.org/images/employee_directory/".$registration_id."/photo/".$visitorPhoto;
		
		$getCompany_name = trim(getCompanyName($registration_id,$conn));
		$company_name = str_replace('&amp;', '&', $getCompany_name);
        $company_first_letter = $company_name[0];
        if(!is_numeric($company_first_letter)){
        $alphabet = strtoupper($company_first_letter);
        } else {
        $alphabet = "NA";
        }
        $slot_query = "SELECT * FROM visitor_slot_master  where alphabets like '%$alphabet%' AND status = '1'";
        $result_slot = $conn->query($slot_query);
        $count_slot = $result_slot->num_rows;
        if($count_slot>0){
        $row_slot = $result_slot->fetch_assoc();
        }else{
        $row_slot = array("dates"=>"");
        }
        $slots_array = explode(",",$row_slot['dates']);
        //echo date("d F Y",strtotime(getEventSlotDate($slots_array[0],$conn)))." & ". date("d F Y",strtotime(getEventSlotDate($slots_array[1],$conn)));
		$days_allow = date("d",strtotime(getEventSlotDate($slots_array[0],$conn))).",". date("d",strtotime(getEventSlotDate($slots_array[1],$conn)));
		
		$digits = 9;	
	    $uniqueIdentifier = rand(pow(10, $digits-1), pow(10, $digits)-1);
	    $checkUniqueIdentifier = $conn->query("SELECT * FROM globalExhibition WHERE `uniqueIdentifier`='$uniqueIdentifier'");
	    $countUniqueIdentifier = $checkUniqueIdentifier->num_rows;
		while($countUniqueIdentifier > 0) {
		$uniqueIdentifier = rand(pow(10, $digits-1), pow(10, $digits)-1);
		} 
						
		$checkGlobalRecord = "SELECT * FROM globalExhibition WHERE `registration_id`='$registration_id' AND `visitor_id`='$visitor_id' AND `pan_no`='$visitorPAN' AND participant_Type='VIS'";
		$globalResult = $conn->query($checkGlobalRecord);
        $checkGlobalCount = $globalResult->num_rows;
	    if($checkGlobalCount>0){
			
		} else { 
		$insertGlobal = "INSERT INTO globalExhibition  SET `uniqueIdentifier`='$uniqueIdentifier',`registration_id`='$registration_id',`visitor_id`='$visitor_id',`fname`='$name',`mobile`='$visitorMobile',`pan_no`='$visitorPAN',`designation`='$visitorDesignation',`company`='$company_name',`photo_url`='$photo_url',`participant_type`='VIS',`covid_report_status`='pending',`days_allow`='$days_allow',`status`='P'";
			$insertGlobalResult = $conn->query($insertGlobal);
		}
		/*Global Table End */
		
		$sqlx1 = "INSERT INTO `visitor_order_history`(`create_date`, `registration_id`,`orderId`, `visitor_id`, `payment_made_for`, `amount`,`show`, `year`,`payment_status`, `status`,`paymentThrough`) VALUES (NOW(),'$registration_id','$orderId','$visitor_id','$payment_made_for','$amount','$show','$year','Y','1','single')";
		$result = $conn->query($sqlx1);
		if($result){
		 $updatx = "DELETE FROM `visitor_order_temp` WHERE `registration_id`='$registration_id' AND `visitor_id` ='$visitor_id' AND `show`='$show' AND `year`='$year' AND paymentThrough='single'"; 
		$resultx = $conn->query($updatx);

		/* Send SMS to Visitors Start */
		$messagev = "Thank you for registration at IIJS SIGNATURE 2021. Your Unique ID number is $orderId. Please make sure to do your RT PCR Covid-19 test 72 hours before the show visit. Please download GJEPC App to get the E-Badge of the show. Your E Badge will get activated Only after successful submission of negative report.";
		get_data($messagev,$visitorMobile); 
		
		/* First optin API After that Msg API */
		$visitorMobiles = $visitorMobile;
		$apiurl = sendOPTIN($visitorMobiles);
		$getResult = json_decode($apiurl,true);
		if($getResult['response']['status']=="success")
		{
			foreach($getResult['data'] as $value)
			{
				$code = $value[0]['id'];
				$msg  = $value[0]['details'];
				$phone = $value[0]['phone'];
				
				$msgurl = visitor_covid_payment_success($visitorMobiles,$orderId);
				$getResults = json_decode($msgurl,true);
				if($getResults['response']['status']=="success")
				{
					echo $getResults['response']['status'];
				} else { 
					echo $getResults['response']['details'];
				}		
			}
		} else { 
			echo $getResult['response']['details'];
		} 
		
		
		if($_SESSION['visitor_id']=="Y"){
		/* Send SMS to Visitors Secondary Mobile */
		$messagev = "Thank you for registration at IIJS SIGNATURE Show.We request you to visit https://iijsvirtual.com/ and login with your registered mobile number.";
	//	get_data($messagev,$visitoSecondaryMobile);
		}
		
		/*Send Email Receipt to Company */
		$message ='<table class="table2" width="80%" bgcolor="#fbfbfb" align="center" style="margin:2% auto; border:2px solid #ddd; font-family:Arial, sans-serif; color:#333333; font-size:13px; border-radius:10px;padding:10px;">	
    <tbody>    
    	<tr>
            <td align="left"><img id="ri" src="https://gjepc.org/iijs-signature/assets/images/gjepc_logo.png">
            <td align="center"> <img id="mi"> </td>
            <td align="right"><img id="ri" src="https://gjepc.org/emailer_gjepc/06.03.2021/iijs.jpg"></td>
            </td>                        
		</tr>
        <tr>
            <td align="center" colspan="3">
                <p style="line-height:25px;">
                    <h3 style="margin: 5px;">THE GEM JEWELLERY EXPORT PROMOTION COUNCIL</h3>
                    <b>GJEPC-H.O.-MUMBAI:1st Flr, Tower A,G Block, BDB, Bandra-Kurla Complex, Bandra(E)-400 051</b><br>
                    <b>GJEPC-E.X.-MUMBAI:G2-A, Trade Center, Bandra-Kurla Complex, Bandra(E)-400 051</b><br>
					<b>Toll Free Number :</b> 1800-103-4353, <b>Missed Call Number :</b> +91-7208048100<br>Website: https://gjepc.org/iijs-signature/ Email: visitors@gjepcindia.com</p>
            </td>
        </tr>            
        <tr><td colspan="3" height="30"><hr></td></tr>        
        <tr>           
        	<td colspan="3" id="content">
            	<table class="table1"width="100%" style="font-family:Arial, sans-serif; color:#333333; font-size:13px;">
                <tr>
                <td style="padding:0 10px;" align="left">Order ID: '.$orderId.' </td>
                <td style="padding:0 60px;" align="right">Date: '.date("d-m-y").'</td>
                </tr>                    
                </table>

                <table class="table2"width="100%" style="font-family:Arial, sans-serif; color:#333333; font-size:13px;" cellpadding="10">
                <tr>
                    <td width="20%">Received with Thanks From M/s: </td>
                    <td width="75%">'.$CompanyName.'</td>
                </tr>
                <tr>
                    <td width="20%">Rupees: </td>
                    <td width="75%">0</td>
                </tr>
				<tr>
                    <td width="20%">Events: </td>
                    <td width="75%">IIJS-SIGNATURE 2021</td>
                </tr>
				<tr>
                    <td width="20%"></td>
                    <td width="75%"><strong>Please Make sure to do your RT PCR Covid-19 test 72 Hours before the show visit</strong></td>
                </tr>
				<tr>
                <td width="100%" colspan="2">
                    <p style="text-align: left; width: 100%; padding-top: 10px; margin: 0;">
                    We thank you for your visitor registration for IIJS Signature 2021.  
					Please download GJEPC app to get the E-Badge of the show. Your E Badge will get activated Only after successful submission of Negative report of RT-PCR Covid-19 test. 
					For further assistance you may please feel free to contact us on 1800-103-4353 / OR give us missed call on +91-7208048100; or write to us on visitors@gjepcindia.com.</p>
				
                </td>
				</tr>
                <tr>
                <td width="100%" colspan="2">
                    <h4 style="text-align: center; width: 100%; padding-top: 30px; margin: 0;">This is a computer generated receipt requires no signature. Invoice as per GST Format would be dispatched seperately.</h4>
                </td>
				</tr>
				<tr>
                <td width="100%" colspan="2">
                    <p>
            <strong>Disclaimer:</strong> <span style="font-size: 10px">This information contained in this circular are provided for the purpose of making application for the participation and visiting IIJS Signature 2021 (the show). Please note that the Council reserves all the rights to postpone or cancel the show completely or partially without any prior intimation, subject to the changes in the Govt. rules and regulations and any such changes thereof for organising the show. In case of any delay or failure to organise the show which is caused by matters beyond reasonable control of the Council including, but not limited to the force majeure events, the Council shall not accept any responsibility or indemnity, whatsoever, and under no circumstance shall the Council have any liability to participants and visitors for any loss or damage of any kind incurred as a result of the postponement or cancellation of the show.</span> 
           </p>
                </td>
                </tr>
            </table>
		</td>            
        </tr>   
           <style type="text/css">
           .table2 input{width: 80%;border-left: none; border-right: none; border-top: none; border-bottom: 1px solid #000;}
               .table1 input{border-left: none; border-right: none; border-top: none; border-bottom: 1px solid #000; width: 150px;}
           }          
            .table2 h4{text-align: center;}
           </style>
	</tbody>
	</table>';
		
		$to =$email.',visitors@gjepcindia.com';
		$subject = "Thank you for registering to visit IIJS SIGNATURE 2021 Show."; 
		$headers  = 'MIME-Version: 1.0' . "\n"; 
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n"; 
		$headers .= 'From: IIJS SIGNATURE 2021 SHOW <admin@gjepc.org>';			
		mail($to, $subject, $message, $headers);
		/*  Email End */
		
		header("Refresh: 30; url=https://registration.gjepc.org/single_visitor.php");
		//unset($_SESSION['registration_id']);
		}		
		}
		?>

	<?php
	} else	{
		echo "<script type='text/javascript'> alert('Your session has been expired');
		window.location.href='https://registration.gjepc.org/login.php';
		</script>";
		return;	exit;
	}
	?>

		<div class="container">
			<div class="border w-100"></div>
			<div class="row mt-5">
				<div class="col-12">
	             <h3 class="text-center font-weight-bold text-success">Registration Successful </h3>
	             <p class="mt-3 text-center">Thank you for your Visitor Registration in IIJS SIGNATURE 2021.</p>
				</div>
				<div class="border w-100"></div>
				<div class="col-12 mt-3">
					
					<p class="text-center font-weight-bold">RT-PCR Test report (Covid-19 test)</p>
		            <p class="text-center font-weight-bold">It is mandatory to submit RT-PCR test report 72 hours before visit date</p>
					<div class="container_wrap">
			<div class="container" id="manualFormContainer">
			
			<div id="formWrapper" class="py-5 ">

			
			<form method="POST" name="regisForm" id="regisForm">
			<input type="hidden" name="action" value="saveCovidDetails"/>	
			<input type="hidden" name="registration_id" value="<?php echo $registration_id;?>"/>	
			<input type="hidden" name="visitor_id" value="<?php echo $visitor_id;?>"/>	
			<input type="hidden" name="pan_no" value="<?php echo $visitorPAN;?>"/>	
			<input type="hidden" name="mobile_no" value="<?php echo $visitorMobile;?>"/>	
			<div class="row">
				<div class="col-12">
					<label class="d-inline-block mr-5">
						<input type="radio" id="self" name="valueType" value="self"/>&nbsp;&nbsp;Self Upload
					</label>
					<label>
						<input type="radio" id="lab" name="valueType" value="lab"/>&nbsp;&nbsp;Upload Via Lab
					</label>
				</div>
				<div class="col-12">
					<label for="valueType" generated="true" class="error d-none">Select any one of the above</label>
				</div>			
				<div class="col-12 mb-2" id="specific-company" style="display: none">
					<p class="font-weight-bold">I will upload RT-PCR test report myself</p>
				</div>
				<div class="col-12 mb-2" id="company-wise" style="display: none">
					  
							<div class="row">
								<div class="col-12">
									<p class="font-weight-bold">I would like to do RT-PCR testing via SRL Labs  <a data-fancybox data-src="#modals" href="javascript:;" id="Offers" class="cta">Click here to View Offers</a></p>
								</div>
								<div class="form-group col-sm-6">
									<label class="form-label" for="location"><p>Select Lab: </p></label>
									<select name="labs" id="labs" class="form-control" style="width:100%">
										<!--<option value="">--- Please Select One ---</option>-->
										<option value="srl" <?php if($lab=="lab") echo "selected"; ?>>SRL Diagnostics</option>
									</select>
								</div>
								
								<div class="form-group col-sm-6">
									<label class="form-label" for="location"><p>Lab Location </p></label>
									<select name="location" id="location" class="form-control" style="width:100%">
										<option value="">--- Please Select Lab Location ---</option>
										<?php
										$city= "SELECT * FROM `cities` order by city_name asc";
										$cityquery = $conn->query($city);
										while($row1 = $cityquery->fetch_assoc()){?>
										<option value="<?php echo $row1['city_name'];?>"><?php echo strtoupper($row1['city_name']);?></option>
										<?php }	?>
									</select>		
								</div>
							
					</div>
				</div>
				<div class="col-12">
                  <input type="checkbox" name="agree" value="YES"> I declare that my covid report can be share with GJEPC
                <label for="agree" generated="true" style="display: none;" class="error"></label>
				</div>
				<div class="col-12">
					<input type="submit" name="submit" id="submit" value="Submit" class="cta">
				</div>
			</div>
			
			</form>
			
			</div>
			
			<div class="clear"></div>
			</div>
		</div>
				</div>
			</div>
		</div>
</div>
 <div style="display: none;" id="modals">
            <h1 align="center" class="mb-2 blue" >Offers</h1>
<table class="table_responsive"><thead><tr class="tableizer-firstrow"><th>City</th><th>Walk-in ( Yes/No ) if Yes pls give the address</th><th>Home Collection ( Yes/No)</th><th>Offered Price</th></tr></thead><tbody><tr><td>Agra </td><td>NO</td><td>YES</td><td>800</td></tr><tr><td>Aligarh</td><td>NO</td><td>YES</td><td>800</td></tr><tr><td>Amritsar</td><td>YES</td><td>YES</td><td>700</td></tr><tr><td>BANGALORE</td><td>NO</td><td>YES</td><td>800</td></tr><tr><td>Bareilly</td><td>YES</td><td>YES</td><td>800</td></tr><tr><td>Chandigarh</td><td>NO</td><td>YES</td><td>900</td></tr><tr><td>CHENNAI</td><td>YES</td><td>YES</td><td>1200</td></tr><tr><td>Dehradun</td><td>NO</td><td>YES</td><td>500</td></tr><tr><td>Delhi</td><td>YES</td><td>NO</td><td>1000</td></tr><tr><td>Deoghar</td><td>NO</td><td>YES</td><td>600</td></tr><tr><td>Dibrugarh</td><td>YES</td><td>YES</td><td>1000</td></tr><tr><td>Gorakhpur</td><td>NO</td><td>YES</td><td>800</td></tr><tr><td>Goa</td><td>YES</td><td>YES</td><td>900</td></tr><tr><td>Gurgaon</td><td>YES</td><td>NO</td><td>699</td></tr><tr><td>Guwahati</td><td>YES</td><td>YES</td><td>1000</td></tr><tr><td>GWALIOR</td><td>NO</td><td>YES</td><td>900</td></tr><tr><td>HALDWANI</td><td>YES</td><td>YES</td><td>500</td></tr><tr><td>Hyderabad</td><td>YES</td><td>YES</td><td>600</td></tr><tr><td>Imphal</td><td>YES</td><td>YES</td><td>1200</td></tr><tr><td>Indore</td><td>YES</td><td>YES</td><td>900</td></tr><tr><td>Jabalpur</td><td>NO</td><td>YES</td><td>900</td></tr><tr><td>Jalandhar</td><td>YES</td><td>YES</td><td>900</td></tr><tr><td>Jammu</td><td>YES</td><td>YES</td><td>1400</td></tr><tr><td>Kolhapur</td><td>YES</td><td>YES</td><td>850</td></tr><tr><td>Kolkata</td><td>YES</td><td>YES</td><td>950</td></tr><tr><td>Lucknow</td><td>NO</td><td>YES</td><td>800</td></tr><tr><td>Ludhiana</td><td>YES</td><td>YES</td><td>900</td></tr><tr><td>Meerut</td><td>NO</td><td>YES</td><td>800</td></tr><tr><td>Moradabad</td><td>YES</td><td>YES</td><td>800</td></tr><tr><td>Mumbai</td><td>YES</td><td>NO</td><td>800</td></tr><tr><td>Muzzafarnagar</td><td>YES</td><td>YES</td><td>800</td></tr><tr><td>Nagpur</td><td>YES</td><td>YES</td><td>850</td></tr><tr><td>Navi Mumbai</td><td>YES</td><td>NO</td><td>850</td></tr><tr><td>Prayagraj</td><td>NO</td><td>YES</td><td>800</td></tr><tr><td>Pune</td><td>YES</td><td>YES</td><td>850</td></tr><tr><td>Raipur</td><td>YES</td><td>YES</td><td>800</td></tr><tr><td>Rishikesh</td><td>NO</td><td>YES</td><td>500</td></tr><tr><td>Silchar</td><td>YES</td><td>YES</td><td>1000</td></tr><tr><td>Ujjain</td><td>NO</td><td>YES</td><td>900</td></tr><tr><td>Varanasi</td><td>NO</td><td>YES</td><td>800</td></tr><tr><td>Vizag</td><td>NO</td><td>YES</td><td>499</td></tr></tbody></table>
                  
              </div>
<?php include ('footer.php'); ?>

<script type="text/javascript">
			$('input[name="valueType"]').click(function(){
		    var valueType = $('[name="valueType"]:checked').val();
			//alert(valueType);
		    if(valueType =="self"){
		    	$("#specific-company").slideDown();
				$("#company-wise").slideUp();
				$("#labs").attr("disabled", "disabled"); 
				$("#location").attr("disabled", "disabled"); 
				} else { 
				$("#company-wise").slideDown();
		    	$("#specific-company").slideUp();	
				$("#labs").removeAttr("disabled");  
				$("#location").removeAttr("disabled"); 
				}
 });     
</script>

<script type="text/javascript">
$(document).ready(function()
{   
	$("#regisForm").validate({
    rules: {
		valueType:{
		required:true,
		},
		labs:{
		required:true,
		},
		location:{
		required:true,
		},
		agree:{
		required:true,
		}
    },
    messages: {
		valueType:{
		required: "Select any one of the above",
		},
		labs:{
		required: "Lab Name required",
		},
		location:{
		required: "Location required",
		},
		agree:{
		required: "Required",
		}
	},
	submitHandler: covidAction	
    });     
    });	

			
	function covidAction(){
		jQuery('#submit').val('please wait...');
		jQuery('#submit').attr('disabled',true);
    var formdata = $('#regisForm').serialize();
	// alert(formdata);return false;
   
    $.ajax({
    type:'POST',
    data:formdata,
    url:"actionAjax.php",
    dataType: "json",
    
    beforeSend: function(){
    $('.loaderWrapper').show();
    },
    success:function(data){
    //    alert(data);
    if(data.status == 'success'){
	//jQuery("#chkPendingPANStatus").html("Your Application is Submitted successfully");
	 alert("Your Application is Submitted successfully");   
    window.location = "single_visitor.php";
	
	jQuery('#submit').val('Submit');		
	jQuery('#submit').attr('disabled',false);		
    $('#regisForm').hide();
    
    } else if(data.status =='error'){
    alert("Your Application is Submitted successfully");   
    window.location = "single_visitor.php";
	jQuery('#submit').val('Submit');		
	jQuery('#submit').attr('disabled',false);		
    $('#regisForm').hide();	
    }
    }
    });
    }
</script>

<!--footer ends-->
</body>
</html>
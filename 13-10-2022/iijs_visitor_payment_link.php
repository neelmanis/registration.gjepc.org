<?php
include('header_include.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Welcome to IIJS VISITOR REGISTRATION</title>
		<link rel="shortcut icon" href="images/fav.png" />
		<link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Cabin'>
		<link rel="stylesheet" type="text/css" href="css/general.css?v=<?php echo $version;?>" />
		<link rel="stylesheet" type="text/css" href="css/inner_pg_style.css?v=<?php echo $version;?>" />
		<link rel="stylesheet" type="text/css" href="css/responsive.css?v=<?php echo $version;?>" />
		<link rel="stylesheet" type="text/css" href="css/media_query.css?v=<?php echo $version;?>" />
		<link rel="stylesheet" type="text/css" href="css/jquery.fancybox.min.css?v=<?php echo $version;?>" />

		<link rel="stylesheet" type="text/css" href="css/visitor_reg.css?v=<?php echo $version;?>" />
		<script type="text/javascript" src="js/jquery-1.8.3.min.js?v=<?php echo $version;?>"></script>
		<script type="text/javascript" src="js/jquery.fancybox.min.js?v=<?php echo $version;?>"></script>

		<!--NAV-->
		<link href="css/flexnav.css?v=<?php echo $version;?>" media="screen, projection" rel="stylesheet" type="text/css">
		<!--<script src="js/jquery.flexnav.js" type="text/javascript"></script>-->
		<script type="text/javascript" src="flexnav-master/js/jquery.flexnav.min.js?v=<?php echo $version;?>"></script>
		<script src="js/common.js?v=<?php echo $version;?>"></script>
		<!--NAV-->
		<script src="jsvalidation/jquery.validate.js?v=<?php echo $version;?>" type="text/javascript"></script>
		<script type="text/javascript">
		$(document).ready(function()
		{
		$("#singleVisitorRegistration").validate({
		rules: {
		address_billing:{
		required:true
		},
		address_shipping:{
		required:true
		},
		payment_made_for:{
		required:true
		},
		participation_fee:{
		required:true
		},
		},
		address_billing: {
		address_billing:{
		required: "Billing address is required"
		},
		address_shipping:{
		required: "Shipping address is required"
		},
		payment_made_for:{
		required: "payment made for is required"
		},
		participation_fee:{
		required: "Participation fee is required"
		},
		},
		submitHandler: singleVisitorRegistrationAction
		});
		});
		$(document).ready(function() {
			$(".agree-terms").fancybox({
			   closeBtn    : false, // hide close button
			    closeClick  : false, // prevents closing when clicking INSIDE fancybox
			    helpers     : { 
			        overlay : {closeClick: false} 
			    },
			    keys : {
			        close  : null
			    }
			}).trigger("click");

			$('.cancel').click(function(){
		    $.fancybox.close();
	        });
	        
		});
		$(document).ready(function(){
			
			$('#visitor_id').change(function(e){
				e.preventDefault();
				var visitors_ID = $(this).val();
		$.ajax({
		type: 'POST',
		url: 'actionAjax.php',
		data: "actiontype=getEvent&&visitors_ID="+visitors_ID,
		dataType:'html',
		beforeSend: function(){
		$('.loader').show();
		},
		success: function(data){
		if($.trim(data)!=""){
		$('.loader').hide();
		$("#payment_made_for").html(data);
		}
		}
				});
			});
		});
		</script>
		<script type="text/javascript">
		function fees_calculate(show,registration_id)
		{
		//console.log(show);
		if(show === '' || show == null || show == 0) {
		
		$("#participation_fee").val("");
		$('label[for="payment_made_for"]').show().html("Please Select Show");
		
		return false;
		}
		$("#add_visitor").attr("disabled");
		$.ajax({
		type: "POST",
		url: "single-ajax-fees-display.php",
		data: "show="+show+"&&registration_id="+registration_id,
		beforeSend: function(){
		$('.loaderWrapper').show();
		},
		success: function(response){
		//alert(response);
		if(response!==''){
		$('.loaderWrapper').hide();
		$("#participation_fee").val(response);
		$("#add_visitor").removeAttr("disabled");
		} else {
		$("#participation_fee").val(response);
		$('.loaderWrapper').show();
		}
		}
		});
		}
		
		function singleVisitorRegistrationAction(){
		var formdata = $('#singleVisitorRegistration').serialize();
		$.ajax({
		type:'POST',
		data:formdata,
		url:"singleVisitorAjax.php",
		dataType: "json",
		beforeSend: function(){
		$('.loaderWrapper').show();
		},
		success:function(data){
		if(data.status == "signatureSuccess"){
		window.location = "ebs/direct_link_techprocess.php";
		}else if(data.status == "sign2Success"){
		window.location = "direct_link_vbsm_success.php";
		}else if(data.status == "machinerySuccess"){
		//window.location = "direct_link_igjme_success.php";
		}else if(data.status=="error"){
			alert(data.message);
		}
		
		}
		});
		}
		</script>
		<style type="text/css">
			.head_main{max-width: 100%;}
			.logo{margin:0;}
			.logo2{margin:0;}
			.customDiv{
				width: 100;
		height: 320px;
		border: 1px solid#ccc;
		/* margin: 0 auto; */
		position: relative;
		display: flex;
		justify-content: center;
		align-items: center;
			}
		.customDiv p{
					text-align: center;
		color: #000;
		font-size: 28px;
		font-weight: bold;
		/* margin: 0 auto; */
		
				}
				#formContainer {
		border: 1px solid #aa9e5f;
		}
		</style>
	</head>
	<body>
		<div class="wrapper">
			
			<!--container starts-->
			<div class="container_wrap">
				<div class="container">
					<div class="header">
	<?php include('header1.php'); ?>
</div>
					<div class="clear" style="margin-bottom: 50px;display: block;"></div>
					<h3 class="headtxt">IIJS SIGNATURE SHOW  </h3>
                <div style="display: none;" id="modals">
            <h1 align="center" class="mb-2 blue" >Terms & Conditions For Visitor Registration </h1>
            <h3>Visit by Pre-Defined Date:  </h3>
            <ul class="inner_under_listing">
              <li>Days of Entry are restricted as per Alphabetical Order as per Company Names</li>
              <li>Maximum 2 visitor registration per company</li>
              <li>Maximum of 10 Badges per company for 25 & above Stores </li>
              <li>Refer to the given below table for detailed information on registration</li>
              
            </ul>
            <table class="table_responsive ">
              <thead>
                <tr>
                  <th>Alphabetic Company</th>
                  <th>Days to be visited</th>
                  <th></th>
                </tr>

              </thead>
              <tbody>
                <tr>
                  <td>A - J</td>
                  <td>07- 08   April 2021</td>
                   <td rowspan="3">Maximum 2 person per company and for 2 consecutive days per company</td>
                </tr>
                <tr>
                  <td>K - R</td>
                  <td>09-10    April 2021</td>
                </tr>
                <tr>
                  <td>S - Z</td>
                  <td>11–12   April 2021</td>
                </tr>
              </tbody>

            </table>

            <h3> Visitor Registration:</h3>
            <p>Registration Charges</p>
            <ul class="inner_under_listing">
              <li>Rs.3000 per visitor for member company </li>
              <li>Rs.3500 per visitors for non-member company</li>
              <li>Complimentary entry for International Visitors</li>
            </ul>
            <h3>Visitors who have already paid for multiple shows format like 2,3,4,5,6 shows do not need to pay for IIJS Signature 2021</h3>

                  <a class="cta btn btn-secondary cancel">Agree</a>
              </div>
					<?php
					$encrypted_pan = filter($_GET['key']);
					$show = "signature2";
					$year = '2021';
					if($_GET['key'] ==""){ ?>
					<div class="customDiv" >
						<p>Invalid Access</p>
					</div>
					<?php }
					
						$pan_no = base64_decode(strtr($encrypted_pan, '-_,', '+/='));

						$sql = "SELECT * FROM visitor_directory WHERE pan_no = '$pan_no' AND visitor_approval='Y'";
						$result = $conn->query($sql);
						$row = $result->fetch_assoc();
						$num = $result->num_rows;
						if($num>0){
							if($row['status']==1){
								$registration_id = $row['registration_id'];
								$visitorID = $row['visitor_id'];
								$status = $row['visitor_approval'];
								$schk_membership="SELECT * FROM `approval_master` WHERE `registration_id`='$registration_id' and issue_membership_certificate_expire_status='Y'";
								$qchk_membership = $conn->query($schk_membership);
								$nchk_membership = $qchk_membership->num_rows;
								if($nchk_membership>0){
								$_SESSION['member_type']= 'MEMBER';
								} else {
								$_SESSION['member_type']= 'NON_MEMBER';
								}
								$member_type = $_SESSION['member_type'];

								if($member_type == "MEMBER"){
		                        $addflag = "SELECT distinct c_bp_number,id,address1,address2,state,city,pincode,gst_no,type_of_address FROM `communication_address_master` WHERE `address_identity`='CTC' AND `registration_id`='$registration_id' AND c_bp_number!=''";
		                        } else {
		                        $addflag = "SELECT * FROM `n_m_billing_address` WHERE `registration_id`='$registration_id'";
		                          }
		                        $queryadd = $conn->query($addflag);
		                        $nans = $queryadd->num_rows;
		                        $rowsaddress_billing = $queryadd->fetch_assoc();
								/*
								** CHECKING PAYMENT IS ALREADY DONE OR NOT START
								*/
								$sqlPaymentCheck = "SELECT * FROM visitor_order_history WHERE  visitor_id='$visitorID' AND status='1' AND payment_status='Y' AND `show`='$show' AND year='$year'";
					            $resultPaymentCheck = $conn->query($sqlPaymentCheck);
					            $countPaymentCheck = $resultPaymentCheck->num_rows;
						        if($countPaymentCheck>0){?>
						        	<div class="customDiv">
						        		 <p style="text-align: center;"> You are already registered for this event</p>
						        		 <a data-fancybox data-src="#modals" href="javascript:;" class="agree-terms"></a>
						        	</div>
						           
								<?php }else {


								$quota = "select quota from registration_master where id='$registration_id'";
								$quotaQuery = $conn->query($quota);
								$quotaResult = $quotaQuery->fetch_assoc();
								$visitor_Badges_avail = $quotaResult['quota'];
								
								$temp = $conn->query("SELECT * FROM `visitor_order_temp` WHERE `registration_id`='$registration_id'");
								$Enum_temp = $temp->num_rows;
								
								$Equery = $conn->query("SELECT * FROM `visitor_order_history` WHERE registration_id='$registration_id' AND `status`='1' AND (payment_made_for='signature2') AND payment_status='Y'");
								$Enum_live = $Equery->num_rows;
								$Enum=$Enum_temp+$Enum_live;
								
								if($Enum!=0){ $visitor_Badges_taken=$Enum; } else { $visitor_Badges_taken=0; }
								//echo $visitor_Badges_avail."--".$visitor_Badges_taken;
								if($visitor_Badges_avail<=$visitor_Badges_taken)
								{ ?>
									<div class="customDiv">
										<p style="text-align: center;"> Registration quota is already full for your company</p>
									</div>
									 
								<?php }else{

											$checkHistory = "SELECT * FROM `visitor_order_history` WHERE  visitor_id='$visitorID' AND (payment_made_for='6show' OR payment_made_for='5show' OR payment_made_for='4show' OR payment_made_for='3show') AND `status`='1' AND payment_status='Y'";
						            $getQuery = $conn ->query($checkHistory);
						            $checkResult = $getQuery->num_rows;	
						            if($checkResult > 0 ){?>
                                        <form class="" method="POST" id="singleVisitorRegistration" autocomplete="off">
							                <div class="d-flex flex-column">
							                  <div class="d-flex flex-row form-setup">
							                    <div class="col-50 d-flex justify-around flex-wrap form-group">
							                      <div class="col-50 d-flex align-center">
							                        <label>I am interested to visit</label>
							                      </div>
							                      <div class="col-50">
							                        <?php
							                        
							                        $sqlVisitor = $conn->query("SELECT degn_type FROM visitor_directory WHERE visitor_id ='$visitorID'");
							                        $sqlVisitorRow = $sqlVisitor->fetch_assoc();
							                        $designationType = $sqlVisitorRow['degn_type'];
							                        $visitor_designationType = getVisitorDesignationType($visitorID,$conn);
							                        if(!empty($visitor_designationType))
							                        { ?>
							                        <select name="payment_made_for" id="payment_made_for"   class="select-control" style="width:100%">
							                          <option value="">--- Please Select One ---</option>
							                          <option value="signature2" <?php if($payment_made_for==$show) echo "selected"; ?>>IIJS SIGNATURE Show</option>
							                        </select>
							                        <?php } ?>
							                      </div>
							                    </div>
							                    <input type="hidden" class="form-control" id="participation_fee" name="participation_fee" value="0"/>
							                  </div>
							                </div>
											<div class="d-flex flex-row form-setup">
							                    <div class="col-50 d-flex justify-around flex-wrap form-group">
							                      <div class="col-50 d-flex align-center">
							                        <label>Allowed dates to visit:</label>
							                      </div>
							                      <div class="col-50">
							                        <?php 
							                         $company_name = trim(getCompanyName($registration_id,$conn));
							                         $company_first_letter = $company_name[0];
							                         if(!is_numeric($company_first_letter)){
							                           $alphabet = strtoupper($company_first_letter);
							                         }else{
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
							                         
							                         
							                          echo date("d F Y",strtotime(getEventSlotDate($slots_array[0],$conn)))." & ". date("d F Y",strtotime(getEventSlotDate($slots_array[1],$conn)));
							                         
							                        ?>
							                      </div>
							                    </div>
							                  </div>
							                <div class="col-100"><input type="checkbox" name="agree" value="YES" checked="">I also agree to receive information from GJEPC via Whatsapp & other Media </div>
							                 <a data-fancybox data-src="#modals" href="javascript:;" class="agree-terms"></a>
							                <div class="d-flex flex-column ">
							                  <div class="d-flex flex-row form-setup">
							                    <div class="col-50 d-flex  flex-wrap form-group">
							                      <input type="submit" name="submit" id="submit" value="Submit" class="btn btn-submit" >
							                      <input type="hidden" name="action" value="singleVisitorRegistrationForDirectPayment" >
							                      <input type="hidden" name="type_of_member" value="<?php if($nchk_membership>0){ $_SESSION['member_type']= 'MEMBER'; echo 'M'; } else { $_SESSION['member_type']= 'NON_MEMBER'; echo 'NM'; } ?>">
							                    
							                      <input type="hidden" name="visitor_id" value="<?php echo $visitorID;?>">
							                      <p id="addVisitor" class="fail"></p>
							                    </div>
							                  </div>
							                </div>
							              </form>
						            <?php }else { ?>
								            <div id="loginForm">
											<div id="formContainer">
												<div class="loaderWrapper">
													<div class="formLoader">
														<img src="images/formloader.gif" alt="">
														<p> Please Wait....</p>
													</div>
												</div>
												<form class="" method="POST" id="singleVisitorRegistration" autocomplete="off">
													<div class="d-flex flex-column ">
														<div class="d-flex flex-row form-setup">
															<div class="col-50 d-flex justify-around flex-wrap form-group">
																<div class="col-50 d-flex align-center">
																	<label>Company Name:</label>
																</div>
																<div class="col-50">
																	<p style="font-size: 15px"><?php echo strtoupper(getCompanyName($registration_id,$conn)) ;?></p>
																</div>
															</div>
															<div class="col-50 d-flex justify-around flex-wrap form-group">
																<div class="col-50 d-flex align-center">
																	<label style="font-size: 15px">Visitor name:</label>
																</div>
																<div class="col-50">
																	<p><?php echo getVisitorName($visitorID,$conn);  ?></p>
																</div>
															</div>
														</div>
														<div class="d-flex flex-row form-setup">
															<div class="col-50 d-flex justify-around flex-wrap form-group">
																<div class="col-50 d-flex align-center">
																	<label>Visitor Photo :</label>
																</div>
																<div class="col-50">
																	<img src="images/employee_directory/<?php echo $registration_id; ?>/photo/<?php echo getVisitorPhoto($visitorID,$conn);?>"style="width :100px;height: auto;">
																</div>
															</div>
															
														</div>
														
												    <input type="hidden" name="address_billing" value="<?php echo $rowsaddress_billing['id']; ?>">
                 									<input type="hidden" name="address_shipping" value="<?php echo $rowsaddress_billing['id']; ?>">
									                <div class="d-flex flex-row form-setup">
									                    <div class="col-50 d-flex justify-around flex-wrap form-group">
									                      <div class="col-50 d-flex align-center">
									                        <label>I am interested to visit</label>
									                      </div>
									                      <div class="col-50">
									                        <?php
									                     
									                        $sqlVisitor = $conn->query("SELECT degn_type FROM visitor_directory WHERE visitor_id ='$visitorID'");
									                        $sqlVisitorRow = $sqlVisitor->fetch_assoc();
									                        $designationType = $sqlVisitorRow['degn_type'];
									                        $visitor_designationType = getVisitorDesignationType($visitorID,$conn);
									                        if(!empty($visitor_designationType))
									                        { ?>
									                        <select name="payment_made_for" id="payment_made_for" onchange="fees_calculate(this.value,<?php echo $registration_id;?>)" class="select-control" style="width:100%">
									                          <option value="">--- Please Select One ---</option>
									                          <option value="signature2" <?php if($payment_made_for=="signature2") echo "selected"; ?>>IIJS SIGNATURE Show</option>
									                        </select>
									                        <?php
									                        }
									                        ?>
									                   
									                      </div>
									                    </div>
									                    
									                    <div class="col-50 d-flex justify-around flex-wrap form-group">
									                      <div class="col-50 d-flex align-center">
									                        <label>Amount</label>
									                      </div>
									                      <div class="col-50">
									                        <input type="text" class="form-control" id="participation_fee" name="participation_fee" autocomplete="off" readonly="readonly" />
									                      </div>
									                    </div>
									                    
									                  </div>
														
													
														<div class="d-flex flex-row form-setup">
										                    <div class="col-50 d-flex justify-around flex-wrap form-group">
										                      <div class="col-50 d-flex align-center">
										                        <label>Allowed dates to visit:</label>
										                      </div>
										                      <div class="col-50">
										                        <?php 
										                         $company_name = trim(getCompanyName($registration_id,$conn));
										                         $company_first_letter = $company_name[0];
										                         if(!is_numeric($company_first_letter)){
										                           $alphabet = strtoupper($company_first_letter);
										                         }else{
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
										                       
										                          echo date("d F Y",strtotime(getEventSlotDate($slots_array[0],$conn)))." & ". date("d F Y",strtotime(getEventSlotDate($slots_array[1],$conn)));
										                         
										                        ?>
										                      </div>
										                    </div>
										                </div>
														<div class="col-100 " style="margin-left: 10px">
														<input type="checkbox" name="agree" value="YES" checked>I also agree to receive information from GJEPC via Whatsapp & other Media</div>
													</div>
													 <a data-fancybox data-src="#modals" href="javascript:;" class="agree-terms"></a>
													
													<div class="d-flex flex-column ">
														<div class="d-flex flex-row form-setup">
															<div class="col-50 d-flex  flex-wrap form-group">
																<input type="submit" name="submit" id="submit" value="Submit" class="btn btn-submit" >
																<input type="hidden" name="action" value="singleVisitorRegistrationForDirectPayment" >
																<input type="hidden" name="type_of_member" value="<?php if($nchk_membership>0){ $member_type= 'MEMBER'; echo 'M'; } else { $member_type = 'NON_MEMBER'; echo 'NM'; } ?>">
																<input type="hidden" name="visitor_id" value="<?php echo $visitorID ; ?>">
																<p id="addVisitor" class="fail"></p>
															</div>
														</div>
													</div>
												</form>
											</div>
										</div>

						            <?php } ?>

								<?php } 
							
                                 }  }  } else { ?>
					<div class="customDiv" >
						<p>Invalid access</p>
					</div>
			<?php }	?>
				</div>
				<div class="clear"></div>
			</div>
		</div>
		<!--container ends-->
		<!--footer starts-->
		<!-- <a data-fancybox data-src="#modals" href="javascript:;" class="cta"><strong>Terms And Conditions</strong></a> -->

		<div class="footer_wrap">
			<?php include ('footer.php'); ?>
		</div>
	</div>
	<!--footer ends-->
	<link rel="stylesheet" type="text/css" href="css/new_style.css" />
</body>
</html>
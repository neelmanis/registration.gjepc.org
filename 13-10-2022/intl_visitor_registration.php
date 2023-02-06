<?php include('header_include.php');
// echo "<script>alert('redirecting to visitor registration page...'); window.location = 'redirection.php';</script>";
if(!isset($_SESSION['USERID'])){ header("location:login.php");	exit; }
$registration_id = intval(trim($_SESSION['USERID']));
if($_SESSION['COUNTRY']=="IN"){ echo "<script>alert('You Are Domestic Visitor'); window.location = 'my_dashboard.php';</script>"; }
$show ="signature22";
$year = 2022;
$member_type = $_SESSION['member_type'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<title>Visitor Registration</title>
		<link rel="icon" href="https://gjepc.org/assets/images/fav_icon.png" type="image/x-icon"/>
		<link rel="stylesheet" type="text/css" href="https://gjepc.org/assets-new/css/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="css/mystyle.css?v=<?php echo $version;?>" />
		<link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Cabin'>
		<link rel="stylesheet" type="text/css" href="css/general.css?v=<?php echo $version;?>" />
		<link rel="stylesheet" type="text/css" href="css/inner_pg_style.css?v=<?php echo $version;?>" />
		<link rel="stylesheet" type="text/css" href="css/visitor_reg.css?v=<?php echo $version;?>" />
		
		<link rel="stylesheet" type="text/css" href="css/responsive.css?v=<?php echo $version;?>" />
		<link rel="stylesheet" type="text/css" href="css/media_query.css?v=<?php echo $version;?>" />
		<script type="text/javascript" src="js/jquery-1.8.3.min.js?v=<?php echo $version;?>"></script>
		<!--NAV-->
		<link href="css/flexnav.css?v=<?php echo $version;?>" media="screen, projection" rel="stylesheet" type="text/css">
		<script src="js/jquery.flexnav.js?v=<?php echo $version;?>" type="text/javascript"></script>
		<script src="js/common.js?v=<?php echo $version;?>"></script>
		<!--NAV-->
		
		<script src="js/intlvisitor.js?v=<?php echo $version;?>8988" type="text/javascript"></script>
		<!-- Global site tag (gtag.js) - Google Analytics -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=UA-178505237-1"></script>
		<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());
		gtag('config', 'UA-178505237-1');
		</script>
		<!-- Event snippet for GJEPC_Google_PageView conversion page --> <script> gtag('event', 'conversion', {'send_to': 'AW-679056788/N1zUCJPKxLsBEJSr5sMC'}); </script>
		<!-- Facebook Pixel Code -->

		<script type="text/javascript">
		$("#add_visitor").attr("disabled",false);
		function get_employees(show)
		{
			$("#add_visitor").attr("disabled",true);
			$("#participation_fee").val("");
			let action = "get_employees";
			if(show === '' || show == null ) {
				$("#visitor_id").html("");
				alert("Please Select Show");
				return false;
			}
			
			$.ajax({
				type: "POST",
				url: "intl-ajax-fees-display.php",
				dataType: "json",
				data: {show:show,action:action},
				beforeSend: function(){
					$('.loader').show();
				},
				success: function(response){
					$('.loader').hide();
					$("#visitor_id").html(response.output);
				}
				});
		}

		function get_fees(visitor_id)
		{
			$("#add_visitor").attr("disabled",true);
		  let show = $("#payment_made_for").val();

		  let action = "get_fees";
		  if(visitor_id === '' || visitor_id == null || visitor_id == 0) {
		  	$("#payment_made_for").val("");
		  	$("#participation_fee").val("");
				alert("Please Select employee");
				return false;
			}
		  if(show === '' || show == null ) {
				alert("Please Select show");
				return false;
			}
			
			$.ajax({
				type: "POST",
				url: "intl-ajax-fees-display.php",
				dataType: "json",
				data: {visitor_id:visitor_id,show:show,action:action},
				beforeSend: function(){
						$('.loader').show();
				},
				success: function(response){
					$('.loader').hide();
					$("#participation_fee").val(response.output);
					$("#add_visitor").attr("disabled",false);
				}
			});
		}
		</script>
		<script src="jsvalidation/jquery.validate.js" type="text/javascript"></script>
		
		<style>
		.loader {
		position: fixed;
		left: 0px;
		top: 0px;
		width: 100%;
		height: 100%;
		z-index: 9999;
		background: url('images/progress.gif') 50% 50% no-repeat rgb(249,249,249);
		opacity: 80;
		}
		.body_text{height: 95px;margin-top: 20px;}
		ol li{list-style: disc;}
		</style>
		
		<script type="text/javascript">
			$(window).load(function() {
				$(".loader").fadeOut("slow");
			});
		</script>
		
	</head>
	<body>
		<div class="wrapper">
			<div class="loader">  <div style="display:table; width:100%; height:100%;"><span style="display:table-cell; vertical-align:middle; text-align:center; padding-top:100px;">Please wait....</span></div></div>
			<div class="header">
				<?php include('header1.php'); ?>
			</div>
			<div class="clear"></div>
			
			<!--container starts-->
			<div class="">
				<div class="">
					
					<div class="container mb-5">
						<div class="bold_font text-center">
							<div class="d-block">
							<img src="https://www.gjepc.org/assets/images/gold_star.png" class=""></div>International Employee Registration
							</div><p><span class='blink d-block'>2 Vaccine Doses Mandatory For Entry</span> </p>
							<div class="box-shadow">
								<form id="item_selection" name="item_selection" method="POST" onSubmit="return validate()">
									<div class="row">
										<div class="col-12 form-group">
											<div class="title margin_t duo">
											<a href="intl_employee_directory.php" class="cta" title="ADD / Edit Application">Manage Directory</a>
											</div>
										</div>
												
									<div class="col-12 form-group">
										<table class="responsive_table">
										<thead>
											<tr>
											<th scope="col">Registration For</th>
											<th scope="col" width="35%">Select Visitor</th>							
											<th scope="col">Amount</th>
											<th scope="col">&nbsp;</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td data-column="Show">
													<select name="payment_made_for" id="payment_made_for" onchange="get_employees(this.value)" class="select-control" style="width:100%">
														<option value="">--- Please Select One ---</option>
															<?php 
															$sql_event = "SELECT * FROM `visitor_event_master` WHERE `status` ='1' order by id asc ";
															$result_event = $conn->query($sql_event);
															$count_event = $result_event->num_rows;
															if($count_event > 0){
															   while($row_event = $result_event->fetch_assoc()){ ?>
																<option value="<?php echo $row_event['shortcode'];?>"><?php echo $row_event['event_name'];?></option>
															   <?php }
																}
															?>
													</select>
												</td>
												<td data-column="Name">
													<select class="select-control" id="visitor_id" name="visitor_id" onchange="get_fees(this.value)">
													<option value="" selected="selected">-- Select Visitor --</option>
													</select>
												</td>
																	                    
												<td data-column="Fee">
													<input name="participation_fee" id="participation_fee" type="text" class="form-control" readonly/> 
												</td>
												<td><input type="button" name="add_visitor" id="add_visitor" value="ADD" class="cta" disabled/></td>																		
						                    </tr>
						                </tbody>
							            </table>
							        </div>
							        </div>
									</form>
									
										<div class="content" id="data"></div>
												<!-- Add Visitor End -->
												            <div class="row">
													            <div class="col-12 form-group">
														  
														        <table class="responsive_table" class="formManual">                
															                <thead>
																                  <tr>
																	                    <th scope="col">Name</th>
																	                    <th scope="col">Show</th>
																	                    <th scope="col">Designation</th>
																	                    <th scope="col">Photo</th>
																	                    <th scope="col">Amount</th>                 
																	                    <th scope="col">Delete</th>                 
																                  </tr>
															                </thead>
															    <tbody id="Applied_Items">
																<?php
																$query1="select * from ivr_registration_order_temp where registration_id='$registration_id'  AND `status`='1' AND visitor_id!='0' AND paymentThrough='online'";
																$showResult = $conn->query($query1);
																while($result1=$showResult->fetch_assoc()){
																$visitor_id = $result1['visitor_id'];
																$total = $result1['amount'];
																?>
																<tr>
																	<td data-column="Name"><?php echo getINTLVisitorName($visitor_id,$conn);?></td>
																	<td data-column="Show"><?php echo getVisEventName($result1['show'],$conn);?></td>
																	<td data-column="Designation"><?php echo getINTLVisitorDesignation($visitor_id,$conn);?></td>												
																	<td data-column="Photo"><img src="images/ivr_image/photograph/<?php echo getINTLVisitorPhoto($visitor_id,$conn);?>" class="emp_img"></td>
																	<td data-column="Amount"><?php echo $total;?></td>
																	<td data-column=""><img src='images/delete.png' alt='Delete' title='Delete' class="deleteOrder <?php echo $result1['id']?>" style="cursor:pointer;" /></td>
																</tr>  
																<?php } ?>
															    </tbody>
														</table>
													</div>
												</div>
												<div class="title margin_t">                
													<h3 class="gold_text">Payment Information</h3>
												</div>
												<div class="row">
												  <div class="col-12 form-group">
														              
														<form name="visitorRegn" action="intl_payment_thankyou.php" method="POST" onsubmit="document.getElementById('myButton').disabled=true;
															document.getElementById('myButton').value='Submitting, please wait...';">
															
															  <div id="paymentDiv">
																<?php
																if(isset($registration_id) && $registration_id!="")
																{
																$sqlP = "select sum(amount) as amount from ivr_registration_order_temp where registration_id='$registration_id' AND visitor_id!='0' AND paymentThrough='online'";
																$queryP = $conn->query($sqlP);
																}
																else
																{
																echo 'something wrong';
																}
																$resultP = $queryP->fetch_assoc();
																$total_payable = trim($resultP['amount']);
																$gst_amount = $amount*18/100;
																?>
																<!--
																            <table class="w-100 responsive_table form-group">                
																	                <thead>  
																		                <tr>
																			                <th> Total Amount</th>
																			                <th>GST(18%)</th>
																			                <th>Total Payable</th>
																		                </tr>                
																	                </thead>
																	                <tbody>
																		                  <tr>
																			                   
																			<td scope="col" data-column="Total Amount"> <?php echo $amount = round($total_payable*100/118);?>
																				<input type="hidden" name="amount" id="amount" value="<?php echo base64_encode($amount);?>"/></td>
																				<td data-column="GST" data-column="GST(18%)"> <?php echo $gst_amount = round($amount*18/100);?>
																					<input type="hidden" name="gst_amount" id="gst_amount" value="<?php echo base64_encode($gst_amount);?>"/></td>
																					<td data-column="Total Payable" data-column="Total Payable"> <?php echo $total_payable;?>
																						<input type="hidden" name="total_payable" id="total_payable" value="<?php echo base64_encode($total_payable);?>"/></td>
																					                  </tr>
																					                 
																					                 
																				                </tbody>
																			</table>-->
																			<!--<input type="checkbox" name="chk" value="Chk"> I Agree and accept that all the information provided  by me is authentic and i do not wish
																			to misrepresent any data<br>-->
																			        <div class="form-group">
																				            <input type="checkbox" name="agree" value="YES" checked><span style="color:blue"> I also agree to receive information from GJEPC via Whatsapp & other Media </span>
																				            <a href="pdf/<?php  echo $evt_term_condition_file; ?>" target="_blank" style="color: red; text-decoration: underline;font-size: 12px;">Read More...</a>
																			          </div>
																			             
																			<div class="">
																			<input type="submit" name="Submit" value="Submit" id="myButton" class="cta">
																			</div>
																		    </div>
																	</form>
																</div>
															</div>
														        </div>
													        </div>
												      </div>   
												      
											    </div>
										  </div>
										 
										<div class="clear"></div>
									</div>
									<!--container ends-->
									<!--footer starts-->
									<div class="footer">
										<?php include ('footer.php'); ?>
									      </div>
									<!--footer ends-->
									<style type="text/css">
									.submitbtn {
									background: #e2e2e2;
									border: none;
									padding: 7px 15px;
									margin-top: 15px;
									cursor: pointer;
									}
									#form .textField{width: 138px;padding: 3px;}
									#form .textField2{width: 215px;padding: 3px;}
									#form .field {
									background: #f6f6f6;
									padding: 10px 20px 3px 20px;
									margin-bottom: 10px;
									float: left;
									}
									.button2 {
									margin: 20px 10px 20px 0px;
									background: #751c54;
									padding: 7px 12px;
									font-size: 12px;
									margin-left: 13px;
									border-radius: 5px;
									color: #fff;}
									.button1 {
									float: left;
									margin: 20px 10px 20px 0px;
									background: #751c54;
									padding: 5px 15px;
									border-radius: 15px;
									color: #fff;}
									select{padding: 5px 0px; }
									#form label {
									min-width: 120px;
									display: block;
									float: left;
									/* font-weight: bold; */
									font-size: 11px;
									vertical-align: middle;
									padding-top: 2px;
									color: #751c54;
									}
									ta
									.margin_t{margin-top:30px;}
									.duo h4{display:inline; padding:3px!important; margin-right:10px; }
									.emp_img{width: 75px;}
									select {background:#fff;}
									#participation_fee {background:#fff;}
									#formContainer .title {width: auto;
									    padding-right: 12px;
									    }
									#formContainer {padding-bottom:20px;}
									.content_area table {width: 100%; margin: 0;}
									.title h3.gold_text {
									    font-style: normal;
									    font-weight: bold;
									    padding: 7px 7px 7px 0;
									    font-size: 14px;
									   
									    border-bottom: 1px dashed #a89c5d;
									    color: #9e9457;
									    margin-bottom: 15px;
									}
									</style>
								</body>
							</html>
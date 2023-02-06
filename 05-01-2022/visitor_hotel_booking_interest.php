<?php include('header_include.php');
// echo "<script>alert('redirecting to visitor registration page...'); window.location = 'redirection.php';</script>";
if(!isset($_SESSION['USERID'])){ header("location:login.php");	exit; }
$registration_id = intval(trim($_SESSION['USERID']));
$show = "signature22";
 $company_quota =  getVisitorHotelQuota($registration_id,$conn);
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
		
		<script src="js/visitor.js?v=<?php echo $version;?>8988" type="text/javascript"></script>
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
		// get_employees("signature22");
		function get_employees(show)
		{
			$("#add_visitor").attr("disabled",true);
			let ref = $(this);

			let action = "get_registered_employees";
			if(show === '' || show == null ) {
				
				$("#visitor_id").html("");

				alert("Please Select Show");
				return false;
			}
			
			$.ajax({
				type: "POST",
				url: "ajax-fees-display.php",
				dataType: "json",
				data: {show:show,action:action},
				beforeSend: function(){
					$('.loader').show();
				},
				success: function(response){
					$('.loader').hide();
					$(".reg_visitors").html(response.output);
				}
				});
		}

		$(document).ready(function()
		{
			$("#hotel_registration").validate({
			rules: {
					payment_made_for:{
					required:true,
					},
					"visitor_id[]":{
					required:true,
					},
			},
			messages: {
					payment_made_for:{
					required: "Select Show",
					},
					"visitor_id[]":{
					required:"Select key person",
					},
					
				},
					submitHandler: hotelSubmitAction
			});
		});

		function hotelSubmitAction(){
         	let form = $("#hotel_registration");
         	
		    var formdata = false;
		    if (window.FormData){
		        formdata = new FormData(form[0]);
		    }
          
			$.ajax({
				type: "POST",
				data: formdata ? formdata : form.serialize(),
				url: "ajax.php",
				contentType: false,
		      	processData: false,
		      	dataType: "json",
				beforeSend: function(){
					$('.loader').show();
				},
				success: function(response){
					$('.loader').hide();
					if(response.status=="success"){
						alert(response.message);
						window.location.reload();
					}else{
						alert(response.message);

					}
					
				}
				});
		}
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
							<img src="https://www.gjepc.org/assets/images/gold_star.png" class=""></div>VISITOR HOTEL REGISTRATION
						</div>
							<div class="box-shadow">
<?php 
$check_history  = "SELECT * FROM visitor_hotel_registration WHERE registration_id='$registration_id' and event='$show'";
$result_history  = $conn->query($check_history);
?>
<?php if($result_history->num_rows < $company_quota){ ?>
<div class="alert alert-warning" role="alert">
 <p><strong>Note:</strong> </p>
  <ul class="inner_under_listing">
  	<li>Key Person 1 And Key Person 2 cannot same</li>
  	<li>You have been allowed to add maximum <?php echo $company_quota; ?> key persons .</li>
  </ul> 
</div>
<form id="hotel_registration" method="POST" >
											<div class="row">
												<div class="col-12 form-group">
												<!-- 	<div class="title margin_t duo">
														<a href="manage_address.php" class="cta" style="margin-right: 20px" title="Add / Edit Address" >Add / Edit Address</a><a href="employee_directory.php" class="cta" title="ADD / Edit Application">Manage Directory</a>
													</div> -->
												</div>
												
												<?php 
												$sql_reg_vis = "SELECT CONCAT(name, ' ', lname) AS visitor_name, visitor_id,visitor_approval FROM visitor_directory 
															WHERE EXISTS 
															(SELECT * FROM visitor_order_history 
															WHERE visitor_directory.visitor_id = visitor_order_history.visitor_id and visitor_order_history.payment_status='Y' AND visitor_order_history.payment_made_for='$show') AND `visitor_approval`='Y' AND `registration_id`='$registration_id'";		

												$query_reg_vis=$conn->query($sql_reg_vis);
												$count_reg_vis = $query_reg_vis->num_rows;
												?>
												<div class="col-12 ">
													<div class="form-group row">
														<div class="col-6">
															<label>Select Show</label>
															<select name="payment_made_for" id="payment_made_for" onchange="get_employees(this.value)" class="select-control" style="width:100%">
																<option value="">Select Show</option>
																<?php 
																$sql_event = "SELECT * FROM `visitor_event_master` WHERE `status` ='1' AND hotelRegistration='1' order by serial_no asc ";
																$result_event = $conn->query($sql_event);
																$count_event = $result_event->num_rows;
																if($count_event > 0){
																   while($row_event = $result_event->fetch_assoc()){ ?>
																	<option value="<?php echo $row_event['shortcode'];?>"><?php echo $row_event['event_name'];?></option>
																   <?php }  
																		}
																	?>
															</select>
														</div>
													</div>

													<?php if($count_reg_vis > 0 ){ ?>
													<div class="form-group row">
                                                        <?php for ($i=0; $i < $count_reg_vis ; $i++) { ?>
														<div class="col-6">
															<label>Key Person <?php echo $i+1;?></label>
															<select class="select-control reg_visitors" name="visitor_id[]">
																<option value="" selected="selected">-- Select Visitor --</option>
															</select>
														</div>													
                                                        <?php } ?>
													</div>
													<?php } else { ?>
													<div class="row">
														<p class="alert alert-warning">Please complete your registration for the show</p>
													</div>
													<?php } ?>
													<div class="form-group row">
														<div class="col-md-6">
															<input type="hidden" name="actionType" value="hotel_registration">
															<input type="submit" name="Submit" value="Submit" class="cta">
														</div>
													</div>
													
												
							          </div>
							        </div>
										</form>
						<?php } ?>
 	
						<?php 
						$counter = 1;
						if($result_history->num_rows > 0 ){ ?>
						<h5 class="title">Registered key persons  </h5>

						<table class="table table-light responsive_table">
							<thead>
								<tr>
									<th>#</th>
									<th>Key Person Name</th>
									<th>Event</th>
								</tr>
							</thead>
							<tbody>
								<?php while ($row_history = $result_history->fetch_assoc()) { ?>
								<tr>
									<td><?php echo $counter++; ?></td>
									<td><?php echo getVisitorName($row_history['visitor_id'],$conn);?></td>
									<td><?php echo getVisEventName($row_history['event'],$conn);?></td>
								</tr>
								<?php }?>
								
							</tbody>
						</table>
						 <?php } ?>

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
									
								</body>
							</html>
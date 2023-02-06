<?php include('header_include.php');
 // echo "<script>alert('redirecting to visitor registration page...'); window.location = 'redirection.php';</script>"; 
if(!isset($_SESSION['USERID'])){ header("location:login.php");	exit; }
$registration_id = intval(trim($_SESSION['USERID']));
$show ="signature22";
$year = 2022;
$member_type = $_SESSION['member_type'];
?>

<?php
//include('ebs/statusapi/techprocess.php');

$sql = "select obmp_application_status from visitor_obmp_details where uid='$registration_id' and participate_for_show='$show' and year='$year' LIMIT 1";
$ans = $conn->query($sql);
$nans=$ans->num_rows;
if($nans==0){
	echo "<script>alert('Plz Fill OBMP Details'); window.location = 'member_obmp_profile.php';</script>";
} ?>

<?php
$sqlxx = "select pan_no_copy,gst_copy from registration_master where id = '$registration_id' AND pan_no_copy!='' AND gst_copy!=''";
$xx = $conn->query($sqlxx);
$numbers = $xx->num_rows;
if($numbers==0){
	echo "<script type='text/javascript'> alert('Please Upload GST AND PAN');
		window.location.href='employee_directory.php';
		</script>";
		return;	exit;
}
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
	
	<script src="js/visitor.js?v=<?php echo $version;?>" type="text/javascript"></script>
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
	$(document).ready(function(){
			$('#visitor_id').change(function(e){
				e.preventDefault();
					//alert($( this ).val());
					var visitors_ID = $(this).val();
				
				    $.ajax({ type: 'POST',
						url: 'actionAjax.php',
						data: "actiontype=getEvent&&visitors_ID="+visitors_ID,
						dataType:'html',
						beforeSend: function(){
								$('.loader').show();
								},
						success: function(data){
							 //alert(data);
							if($.trim(data)!=""){
								  $('.loader').hide();
								  $("#payment_made_for").html(data);
							}
						}
			});
		});
			$('#address_selection').change(function(){
              var address_selection = $(this).val();
              if(address_selection !=""){
               localStorage.setItem("address_selection", address_selection);
              }
			});
			$('#billing_address_selection').change(function(){
              var billing_address_selection = $(this).val();
              if(billing_address_selection !=""){
               localStorage.setItem("billing_address_selection", billing_address_selection);
              }
			});
			$(window).load(function(){
             var get_address_selection  = localStorage.getItem("address_selection");
             var get_billing_address_selection = localStorage.getItem("billing_address_selection");

           $('#delivery_id').val(get_address_selection);
           $('#billing_delivery_id').val(get_billing_address_selection);

             if(get_address_selection !="" || get_address_selection != undefined || get_address_selection != null){
           $('#address_selection option').each(function(){
             if ($(this).val() == get_address_selection) {
                $(this).attr("selected", true);
            }
           });
             }
             if(get_billing_address_selection !="" || get_billing_address_selection != undefined || get_billing_address_selection != null){
             	   $('#billing_address_selection option').each(function(){
               if ($(this).val() == get_billing_address_selection) {
                $(this).attr("selected", true);
            }
            });
             }
			});
	});
	</script>
	<script type="text/javascript">
	function fees_calculate(show)
	{
		//console.log(show);
		if(show === '' || show == null || show == 0) {
			alert("Please Select Show");
			return false;
		} 
		$("#add_visitor").attr("disabled");
		$.ajax({
			type: "POST",  
			url: "ajax-fees-display.php",
			data: "show="+show,
			beforeSend: function(){
					$('.loader').show();
				},
			success: function(response){
				//alert(response);
				if(response!==''){
				$('.loader').hide();
				$("#participation_fee").val(response);
				$("#add_visitor").removeAttr("disabled");
				} else {
				//$("#participation_fee").val(response);
				$('.loader').show();
				}
			}      
		});	
	}
	</script>
<script src="jsvalidation/jquery.validate.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){
	$("#delivery_id").val($('#address_selection').val());
	$("#billing_delivery_id").val($('#billing_address_selection').val());

		//alert('hello'); 
		$('#address_selection').change(function(){
			//	alert($( this ).val());
				$("#delivery_id").val($(this).val());
		});
		$('#billing_address_selection').change(function(){
				//alert($( this ).val());
				$("#billing_delivery_id").val($(this).val());
		});
});
</script>

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
		<img src="https://www.gjepc.org/assets/images/gold_star.png" class=""></div>VISITOR REGISTRATION
		</div>
        <div class="box-shadow">
                    
	<!--  Start Delivery Start -->		  
		<form action="" class="cmxform" method="POST" name="form" id="form">    

			<div class="row">
				<div class="col-12 form-group">
            <table class="responsive_table">                
                <thead>
                  <tr>
                    <th scope="col">Shipping Address (For Badges Courier)</th>                   
                    <th scope="col">Billing Address (For Billing Purpose)</th>                   
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td data-column="Shipping Address">
						<?php
						if($member_type == "MEMBER") 
                        //$addflag = "SELECT * FROM `communication_address_master` WHERE `address_identity`='CTC' and `registration_id`='$registration_id'";
						$addflag = "SELECT distinct c_bp_number,id,address1,address2,state,city,pincode,gst_no,type_of_address FROM `communication_address_master` WHERE `address_identity`='CTC' AND `registration_id`='$registration_id' AND c_bp_number!=''";
						else
						$addflag = "SELECT * FROM `n_m_billing_address` WHERE `registration_id`='$registration_id'";			
                        ?>
					   <select class="select-control" id="address_selection" name="address_selection">                      
							<option value="">---- Shipping Address ----</option>	
                            <?php 
							$queryadd = $conn->query($addflag);
							$nans = $queryadd->num_rows;
							if($nans > 0){
                            while($rows = $queryadd->fetch_assoc())
							{ ?>
                            <option value="<?php echo $rows['id']; ?>" ><?php echo strtoupper($rows['address1'])." ".strtoupper($rows['city']);?></option>
                            <?php } } else { ?>	
							<option value="">Not Found</option>	
							<?php } ?>
					   </select>					   
                    </td>
				  
                    <td data-column="Billing Address">
						<?php
						if($member_type == "MEMBER")
						$addflag = "SELECT distinct c_bp_number,id,address1,address2,state,city,pincode,gst_no,type_of_address FROM `communication_address_master` WHERE `address_identity`='CTC' AND `registration_id`='$registration_id' AND c_bp_number!=''";
						else
						$addflag = "SELECT * FROM `n_m_billing_address` WHERE `registration_id`='$registration_id'";			
                        ?>
					   <select class="select-control" id="billing_address_selection" name="billing_address_selection">                      
							<option value="">---- Billing Address ----</option>	
                            <?php 
							$queryadd = $conn->query($addflag);
							$nans = $queryadd->num_rows;
							if($nans > 0){
                            while($rows = $queryadd->fetch_assoc())
							{ ?>
                            <option value="<?php echo $rows['id']; ?>" ><?php echo strtoupper($rows['address1'])." ".strtoupper($rows['city']);?></option>
                            <?php } } else { ?>	
							<option value="">Not Found</option>	
							<?php } ?>				
					   </select>					   
                    </td>
				  </tr>
                </tbody>				
            </table>
		</div></div>        </form> 
	<!--   End Delivery Start -->
    <!--   Add Visitor Start -->	
	
	<form id="item_selection" name="item_selection" method="POST" onSubmit="return validate()">

		<div class="row">

			<div class="col-12 form-group">
				<div class="title margin_t duo">
                <a href="manage_address.php" class="cta" style="margin-right: 20px" title="Add / Edit Address" >Add / Edit Address</a><a href="employee_directory.php" class="cta" title="ADD / Edit Application">Manage Directory</a>
              </div>
			</div>
	
              <div class="col-12 form-group">
            <table class="responsive_table">
                
                <thead>
                  <tr>
                    <th scope="col" width="35%">Select Visitor</th>
                    <th scope="col">Registration For</th>
                    <th scope="col">Amount</th>
                    <th scope="col">&nbsp;</th>                    
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td data-column="Name">
					<input type="hidden" name="xyz" value=""/>
					<input type="hidden" name="year" value="<?php echo $year;?>"/> 
					<input type="hidden" name="show" value="<?php echo $show;?>"/>
					
							<select class="select-control" id="visitor_id" name="visitor_id">
							<?php
							$newx = "SELECT * from visitor_directory where `registration_id`='$registration_id' AND status='1' AND visitor_approval='Y' order by name";
							$query=$conn->query($newx);
							$countx = $query->num_rows;
							if($countx > 0) {
							$lettersinDB = array();
							while($rows = $query->fetch_assoc()){
								array_push($lettersinDB,array('visitor_id'=>$rows['visitor_id'],'name'=>$rows['name']));
							}
							?>							
							<option value="" selected="selected">-- Select Visitor --</option>
							<?php
			/* 27/10/2021	$checkHistory = "SELECT * FROM `visitor_order_history` WHERE registration_id='$registration_id' AND `status`='1' AND payment_status='Y'"; */
						//	$checkHistory = "SELECT * FROM `visitor_order_history` WHERE registration_id='$registration_id' AND `status`='1' AND payment_made_for='vbsm2' AND payment_status='Y'";
							$checkHistory = "SELECT * FROM `visitor_order_history` WHERE registration_id='$registration_id' AND `status`='1' AND (payment_made_for='6show' OR payment_made_for='5show' OR payment_made_for='4show' OR payment_made_for='combo' OR payment_made_for='igjme22' OR payment_made_for='signature22') AND payment_status='Y'";
							$getQuery = $conn->query($checkHistory);
							$checkResult = $getQuery->num_rows;
							$gotcommaid = array();
							while($checkQuery = $getQuery->fetch_assoc()){
								//$gotcommaid = explode(",",$checkQuery['visitor_id']);
								array_push($gotcommaid,explode(",",$checkQuery['visitor_id']));															
							}
							//print_r($gotcommaid);
							$finalvisitoridarray = array();
							foreach($gotcommaid as $k => $v){
								$finalvisitoridarray = array_merge($finalvisitoridarray,$v);
							}
							//print_r($finalvisitoridarray);
							//print_r($gotcommaid);
							foreach($lettersinDB as $option_value)
							{ //echo '<pre>'; print_r($option_value);								
								if(!in_array($option_value['visitor_id'], $finalvisitoridarray)) { ?>								
								<option value="<?php echo $option_value['visitor_id']; ?>"><?php echo strtoupper($option_value['name']); ?></option>
								<?php
								}
							}
							?>
							<?php } else { ?>
							<option value="0">Not Found</option>
							<?php }	?>							
					</select>
                    </td>
                    <td data-column="Show">
                      <select name="payment_made_for" id="payment_made_for" onchange="fees_calculate(this.value)" class="select-control" style="width:100%">
						<option value="">--- Please Select One ---</option>
					  </select>
                    </td>
                    <td data-column="Fee">
					<input name="participation_fee" id="participation_fee" type="text" class="form-control" readonly/> </td>
                    <td><input type="button" name="add_visitor" id="add_visitor" value="ADD" class="cta" disabled/></td>
					<!--<span id='progress' style="display:none"><img src="images/progress.gif"/>  Please wait....</span>-->
                  </tr>
                </tbody>				
            </table>
          </div>
        </div>
	</form>	
	<div class="content" id="data"></div>
	<!-- Add Visitor End -->
	
            <!--<h3 class="gold_text">Selected Registration</h3>-->
            <div class="clear"></div>
            <!--<p style="color: red; margin-bottom: 5px; font-weight: bold;">Please Note : Visitor who already Registered for 2/5 & 3/6 Shows starting from IIJS PREMIERE 2021 need to preserve the badge</p>-->           

            <div class="row">

            	<div class="col-12 form-group">
			  	
        <table class="responsive_table" class="formManual">                
                <thead>
                  <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Designation</th>
                    <th scope="col">Mobile Number</th>
                    <th scope="col">Photo</th>
                    <th scope="col">Amount</th>                 
                    <th scope="col">Delete</th>                 
                  </tr>
                </thead>
                <tbody id="Applied_Items">
				<?php
				$query1="select * from visitor_order_temp where registration_id='$registration_id' AND `show`='$show' AND `year`='$year' AND `status`='1' AND visitor_id!='0' AND paymentThrough='online'";
				$showResult = $conn->query($query1);
				while($result1=$showResult->fetch_assoc()){
				$visitor_id = $result1['visitor_id'];
				$total = $result1['amount'];
				?>
                  <tr>
                    <td data-column="Name"><?php echo getVisitorName($visitor_id,$conn);?></td>
                    <td data-column="Designation"><?php echo getVisitorDesignationID(getVisitorDesignation($visitor_id,$conn),$conn);?></td>
                    <td data-column="Mobile Number"><?php echo getVisitorMobile($visitor_id,$conn);?></td>
                    <td data-column="Photo"><img src="images/employee_directory/<?php echo $registration_id;?>/photo/<?php echo getVisitorPhoto($visitor_id,$conn);?>" class="emp_img"></td>
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
              
		<form name="visitorRegn" action="payment_thankyou.php" method="POST" onsubmit="document.getElementById('myButton').disabled=true;
document.getElementById('myButton').value='Submitting, please wait...';">
<input type="hidden" name="delivery_id" id="delivery_id"/>
<input type="hidden" name="billing_delivery_id" id="billing_delivery_id"/>

				<input type="hidden" name="type_of_member" id="type_of_member" <?php if($member_type == "MEMBER"){?>value="M" <?php } ?><?php if($member_type != "MEMBER"){?>value="NM" <?php } ?> />
			  <div id="paymentDiv">
			    <?php  
				if(isset($registration_id) && $registration_id!="")
				{
				$sqlP = "select sum(amount) as amount from visitor_order_temp where registration_id='$registration_id' AND `show`='$show' AND `year`='$year' AND visitor_id!='0' AND paymentThrough='online'";
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
            </table>
              <!--<input type="checkbox" name="chk" value="Chk"> I Agree and accept that all the information provided  by me is authentic and i do not wish
              to misrepresent any data<br>-->         
        <div class="form-group">
            <input type="checkbox" name="agree" value="YES" checked><span style="color:blue"> I also agree to receive information from GJEPC via Whatsapp & other Media </span><a href="pdf/Visitor-Terms-Conditions-IIJS-Signature-2022.pdf" target="_blank" style="color: red; text-decoration: underline;font-size: 12px;">Read More...</a>
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
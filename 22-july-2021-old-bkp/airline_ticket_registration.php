<?php include('header_include.php');?>
<?php 
if(!isset($_SESSION['IsOtpVerified'])){	header('location:airline_ticket.php');exit; }
?>

<?php
$action=$_REQUEST['action'];
if($action=="save")
{
	$title = filter(strtolower($_REQUEST['title']));
	$first_name = strtoupper(filter($_REQUEST['first_name']));
	$last_name= strtoupper(filter($_REQUEST['last_name']));
	$gender= $_REQUEST['gender'];
	$mobile_no= strtoupper(filter($_REQUEST['mobile_no']));
	$company_name = filter($_REQUEST['company_name']);
	$company_gst = filter($_REQUEST['company_gst']);
    $company_email = $_REQUEST['company_email'];
	$company_address = strtoupper($_REQUEST['company_address']);
	$purpose_of_visit = $_REQUEST['purpose_of_visit'];
	$purpose_of_visit = $_REQUEST['purpose_of_visit'];
	$registration_order_id= filter($_REQUEST['registration_order_id']);
	$stall_number= $_REQUEST['stall_number'];
	$date_of_arrival= $_REQUEST['date_of_arrival'];
	$date_of_departure= $_REQUEST['date_of_departure'];
	$arrival_city= $_REQUEST['arrival_city'];
	$destination_to= $_REQUEST['destination_to'];
	$wish_to_round_trip= $_REQUEST['wish_to_round_trip'];
	$Travel_benifit= $_REQUEST['Travel_benifit'];
	$Payment_mode= $_REQUEST['Payment_mode'];
	$card_detail= $_REQUEST['card_detail'];
	$post_date= date('Y-m-d');
	$ip_address = $_SERVER['REMOTE_ADDR'];
	
	$sql="insert into airticket_application set title='$title',first_name='$first_name',last_name='$last_name',gender='$gender',mobile_no='$mobile_no',company_name='$company_name',company_gst='$company_gst',company_email='$company_email',company_address='$company_address',purpose_of_visit='$purpose_of_visit',registration_order_id='$registration_order_id',stall_number='$stall_number',date_of_arrival='$date_of_arrival',date_of_departure='$date_of_departure',arrival_city='$arrival_city',destination_to='$destination_to',wish_to_round_trip='$wish_to_round_trip',Travel_benifit='$Travel_benifit',Payment_mode='$Payment_mode',card_detail='$card_detail',post_date='$post_date',ip_address='$ip_address'";
	$query = $conn->query($sql);
	if($query)
		$_SESSION['succ_msg']="You have successfully submitted";
	else
		$_SESSION['err_msg']="Sorry There is an error..!! ";
	header('location:thank_you.php');exit;
}
if(isset($_SESSION['visitor_type'])){
	$pan_number=$_SESSION['pan_number'];
	$mobile_no=$_SESSION['mobile_no'];
if($_SESSION['visitor_type']=="V"){
	//echo "select * from visitor_directory where mobile='9987753842' and pan_no='$pan_number' limit 0,1";
	$query=$conn->query("select * from visitor_directory where mobile='9440232306' AND pan_no='$pan_number' AND visitor_approval='Y' limit 0,1");
	$row=$query->fetch_assoc();
	$first_name=$row['name'];
	$last_name=$row['lname'];
	$gender=$row['gender'];
	$mobile_no=$row['mobile'];
	$visitorOrderNO = getVisitorOrderNO($row['visitor_id'],$conn); 
	$company_name=getCompanyName($row['registration_id'],$conn);
	$company_gst=getCompanyGst($row['registration_id'],$conn);
	$company_email=getUserEmail($row['registration_id'],$conn);	
	$company_address=getCompanyAddress($row['registration_id'],$conn);
	}
}



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome to GJEPC Registration</title>
    <link rel="icon" href="https://gjepc.org/images/favicon.ico" type="image/x-icon"/>
    <!--<link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Cabin'>-->
    <link rel="stylesheet" type="text/css" href="css/general.css" />
    <link rel="stylesheet" type="text/css" href="css/inner_pg_style.css" />
    <link rel="stylesheet" type="text/css" href="css/responsive.css" />
    <link rel="stylesheet" type="text/css" href="css/media_query.css" />
    <link rel="stylesheet" type="text/css" href="css/visitor_reg.css" />
    <link rel="stylesheet" type="text/css" href="css/new_style.css" /> 

    <script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>
   <!--NAV-->
	<link href="css/flexnav.css" media="screen, projection" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="flexnav-master/js/jquery.flexnav.min.js"></script>
	<script src="js/common.js"></script> 
	<!--NAV-->
    <script src="jsvalidation/jquery.validate.js" type="text/javascript"></script>
    <script type="text/javascript">
    $(document).ready(function() {
		
	jQuery.validator.addMethod("mobno", function (value, element) {
	var regExp = /^[6-9]\d{9}$/; 
	if (value.match(regExp) ) {
		return true;
	} else {
		return false;
	};
	},"Please Enter valid Mobile No");

	$.validator.addMethod("company_gstn", function(value, element) {
		var gstinformat = new RegExp('^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$');
		if (gstinformat.test(value)) {
			return true;
		} else {
			return false;
		}
	},"Please Enter Valid GSTIN Number");
	
    $("#Air_Ticket").validate({
    rules: {
		title:
		{
			required:true,
		},
		first_name:
		{
			required:true,
		},
		last_name:
		{
			required:true,
		},
		gender:
		{
			required:true,
		},
		mobile_no:
		{
			required: true,
			number:true,
			minlength: 10,
			maxlength:10,
			mobno: true
		},
		company_name:
		{
			required:true,
		},
		company_gst:
		{
			required: true,
            minlength: 15,
            maxlength: 15,
			company_gstn: true
		},
		company_email:
		{
			required:true,
		},
		company_address:
		{
			required:true,
		},
		purpose_of_visit:
		{
			required:true,
		},
		date_of_arrival:
		{
			required:true,
		},
		date_of_departure:
		{
			required:true,
		},
		arrival_city:
		{
			required:true,
		},
		wish_to_round_trip:
		{
			required:true,
		},
		Payment_mode:
		{
			required:true,
		},
		card_detail:
		{
			required: true,
			number:true,
			minlength: 16,
			maxlength:16,
		}	
    },
    messages: {
		title:{
			required: "Select a Title",
		},
		first_name:{
			required: "Enter Your First Name",
		},
		last_name:{
			required: "Enter Your First Name",
		},
		gender:{
			required: "Select Your First Gender",
		},
		mobile_no:{
			required:"Please Enter Mobile Number",
			number:"Please Enter Numbers only",
			minlength:"Please enter at least {10} digit.",
			maxlength:"Please enter no more than {10} digit."
		},
		company_name:{
			required: "Enter Your Company Name",
		},
		company_gst:{
			required: "Please Enter GSTIN No.",
			minlength:"Please enter not less than 15 characters",
			maxlength:"Please enter not more than 15 characters"
		},
		company_email:{
			required: "Enter Company Email",
		},
		company_address:{
			required: "Enter Company Address",
		},
		purpose_of_visit:{
			required: "Select Purpose of Visit",
		},
		date_of_arrival:{
			required: "Select Date of Arrival",
		},
		date_of_departure:{
			required: "Select Date of Departure",
		},
		arrival_city:{
			required: "Required.",
		},
		wish_to_round_trip:{
			required: "Required.",
		},
		Payment_mode:{
			required: "Required.",
		},
		card_detail:{
			required:"Please Enter Card Details",
			number:"Please Enter Numbers only",
			minlength:"Please enter at least {16} digit.",
			maxlength:"Please enter no more than {16} digit."
		}
    }
    });
   });
</script>

  </head>
  
<body>

<div class="wrapper">
	
    <div class="header">
		<?php include('header1.php'); ?>
		<div class="clear"> </div>
	</div>
    <div class="clear"> </div>
    <!--container starts-->
    <div class="container_wrap">
    
    	<div class="container">
        
        	<span class="headtxt">IIJS Signature 2020 Airline Booking Form to get travel benefits</span>
            
          	<div id="loginForm">
            	
                <div id="formContainer">
                 <div class="loaderWrapper">
                        <div class="formLoader"> <img src="images/formloader.gif" alt=""> <p> Please Wait....</p> </div>
              	  </div>
              		<form method="POST" name="Air_Ticket" id="Air_Ticket" autocomplete="off">
                    <input type="hidden" name="action" value="save" />
             			
                         <div class="form-group"> 
                         <label>Prefix</label>
                    	<div class="d-flex">
                        
                            <div style="margin-right:15px;">
                            	<label class="container_radio">
                                    <span class="check_text">Mr.</span>
                                    <input type="radio" name="title" id="title" value="Mr">
                                    <span class="checkmark_radio"></span>
                                </label>
                            </div>
                        
                        	<div style="margin-right:15px;">
                           		<label class="container_radio">
                                	<span class="check_text">Ms.</span>
                                    <input type="radio" name="title" id="title" value="Ms" >
                           			<span class="checkmark_radio"></span>
                           		</label>
                           </div>
                           
                           <div>
                           		<label class="container_radio">
                                	<span class="check_text">Mrs.</span>
                                    <input type="radio" name="title" id="title" value="Mrs">
                           			<span class="checkmark_radio"></span>
                           		</label>
                           </div>
                            
                      	</div>  
                        </div>  
                        
                        <div class="form-group">
                        	<label>First Name</label>
                            <input type="text" class="form-control" name="first_name" id="first_name" value="<?php echo $first_name;?>"  readonly/>
                        </div>
                        
                        <div class="form-group">
                        	<label>Last Name</label>
                            <input type="text" class="form-control" name="last_name" id="last_name" value="<?php echo $last_name;?>" readonly/>
                        </div>
                        
                        <div class="form-group">
                        	<label>Gender</label>
                        	<div class="d-flex">
                            <div>
                            	<label class="container_radio">
                                    <span class="check_text">Male</span>
                                    <input type="radio" name="gender" id="gender" value="M" <?php if($gender=="M"){?> checked="checked"<?php }?>>
                                    <span class="checkmark_radio"></span>
                                </label>
                            </div>
                        
                        	<div>
                           		<label class="container_radio">
                                	<span class="check_text">Female</span>
                                    <input type="radio" name="gender" id="gender" value="F" <?php if($gender=="F"){?> checked="checked"<?php }?> >
                           			<span class="checkmark_radio"></span>
                           		</label>
                           </div>
                           
                           <div>
                           		<label class="container_radio">
                                	<span class="check_text">Transgender</span>
                                    <input type="radio" name="gender" id="gender" value="T" <?php if($gender=="T"){?> checked="checked"<?php }?>>
                           			<span class="checkmark_radio"></span>
                           		</label>
                           </div>
                            
                      	</div>
                        </div>
                        
                        <div class="form-group">
                        	<label>Mobile Number</label>
                            <input type="text" class="form-control" name="mobile_no" id="mobile_no" value="<?php echo $mobile_no;?>" maxlength="10" minlength="10" readonly/>
                        </div>
                        
                        <div class="clear"></div>
                        
                        <div class="form-group">
                        	<label>Company Name</label>
                            <input type="text" class="form-control" name="company_name" id="company_name" value="<?php echo $company_name;?>"  readonly/>
                        </div>
                        
                        <div class="form-group">
                        	<label>Company GST Number</label>
                            <input type="text" class="form-control" name="company_gst" id="company_gst" value="<?php echo $company_gst;?>" maxlength="15" minlength="15" readonly/>
                        </div>
                        
                        <div class="form-group">
                        	<label>Company E-mail address  </label>
                            <input type="text" class="form-control" name="company_email" id="company_email" value="<?php echo $company_email;?>" readonly/>
                        </div>
                        
                        <div class="form-group col-100">
                        	<label>Company Address (Registered with GST) </label>
                           <textarea class="form-control" name="company_address" id="company_address"><?php echo $company_address;?></textarea>
                        </div>
                        
                        <div class="form-group">
                        <label>Purpose of Visit to IIJS Signature 2020 </label>
                        <div class="d-flex">
							<?php if($_SESSION['visitor_type']=="V"){ ?>
                            <div>
                            <label class="container_radio">
                                <span class="check_text">Visitor </span>
                                <input type="radio" name="purpose_of_visit" id="purpose_of_visit" value="V" checked>
                                <span class="checkmark_radio"></span>
                            </label>
                            </div>
							<?php } else { ?>
                        	<div>
                            <label class="container_radio">
                                <span class="check_text">Exhibitor</span>
                                <input type="radio" name="purpose_of_visit" id="purpose_of_visit" value="E" checked>
                                <span class="checkmark_radio"></span>
                            </label>
                           </div> 
							<?php } ?>
                      	</div>
                        </div>
                        
                        <div class="form-group">
                        	<label>Registration ORDER ID number (Visitor)  </label>
                            <input type="text" class="form-control" name="registration_order_id" id="registration_order_id" value="<?php echo $visitorOrderNO;?>" readonly />
                        </div>
                        <?php if($_SESSION['visitor_type']!="V"){ ?>
                        <div class="form-group">
                        	<label>stall number (Exhibitor )  </label>
                            <input type="text" class="form-control" name="stall_number" id="stall_number"  />
                        </div>
						<?php } ?>
                        
                         <div class="form-group col-50">
                        	<label>Date of Travel (Arrival) </label>
                            <input type="date" class="form-control" name="date_of_arrival" id="date_of_arrival"   />
                        </div>
                        
                        <div class="form-group col-50">
                        	<label>Date of Travel (Departure) </label>
                            <input type="date" class="form-control" name="date_of_departure" id="date_of_departure"  />
                        </div>
                        
                        <div class="form-group col-50">
                        	<label>Arrival City (From)  </label>
                            <input type="text" class="form-control" name="arrival_city" id="arrival_city" />
                        </div>
                        
                        <div class="form-group col-50">
                        	<label>Destination (To)  </label>
                           	<div class="d-flex">
                            <div>
                            	<label class="container_radio">
                                    <span class="check_text">Mumbai </span>
                                    <input type="radio" name="destination_to" id="destination_to" value="Mumbai" checked="checked">
                                    <span class="checkmark_radio"></span>
                                </label>
                            </div>
                        	</div>
                        </div>	
                        
                        <div class="clear"></div>
                        <div class="form-group col-50">
                        	<label>Do you wish to book Round Trip ticket</label>
                           <div class="d-flex">
                            <div>
                            <label class="container_radio">
                                <span class="check_text">Yes  </span>
                                <input type="radio" name="wish_to_round_trip" id="wish_to_round_trip" value="Yes">
                                <span class="checkmark_radio"></span>
                            </label>
                            </div>
                            <div>
                            <label class="container_radio">
                                <span class="check_text">No  </span>
                                <input type="radio" name="wish_to_round_trip" id="wish_to_round_trip" value="No">
                                <span class="checkmark_radio"></span>
                            </label>
                            </div>
                            <div>
                            <label class="container_radio">
                                <span class="check_text">Not decided yet </span>
                                <input type="radio" name="wish_to_round_trip" id="wish_to_round_trip" value="NDY">
                                <span class="checkmark_radio"></span>
                            </label>
                            </div>
                        	</div>
                        </div>
                        
                    <div class="form-group col-50">
                    <label>Travel Benefits </label>
                        <div class="d-flex">
                            <div>
                            	<label class="container_radio">
                            	<span class="check_text">Interested</span>
                            	<input type="radio" name="travel_benifit" id="travel_benifit" value="Interested" checked="checked">
                            	<span class="checkmark_radio"></span>
                            	</label>
                            </div> 
                        <div>
                        </div>
                        </div>
                    </div>
                   <div class="clear"></div>
                        
                    <div class="form-group col-50">
                        <label>Payment mode</label>
                       <div class="d-flex">
                    
                        <div>
                            <label class="container_radio">
                                <span class="check_text">Credit card  </span>
                                <input type="radio" name="Payment_mode" id="Payment_mode" value="CC">
                                <span class="checkmark_radio"></span>
                            </label>
                        </div>
                        
                        <div>
                            <label class="container_radio">
                                <span class="check_text">Debit card </span>
                                <input type="radio" name="Payment_mode" id="Payment_mode" value="DC">
                                <span class="checkmark_radio"></span>
                            </label>
                        </div>
                        
                        <div>
                            <label class="container_radio">
                                <span class="check_text">NEFT </span>
                                <input type="radio" name="Payment_mode" id="Payment_mode" value="NEFT">
                                <span class="checkmark_radio"></span>
                            </label>
                        </div>
                    
                        </div>
                    </div>
                        
                <div class="form-group col-50">
                    <label>Credit/Debit Card Number  </label>
                    <input type="text" class="form-control" name="card_detail" placeholder="1234 5678 9012 3456" id="card_detail" maxlength='16' minlength='16'/>
                </div>
                <div class="col-50 form-group">
                    <label>&nbsp</label>
                    <input type="submit" class="btn-submit" value="Submit"/>
                </div>
                    	
                <div class="clear"></div>
		</form>           
            </div>
                
         </div>
            
	  </div>
    <div class="clear"></div>      
	</div>
	<!--container ends-->
</div>
<!--footer starts-->
<div class="footer">
	<?php include ('footer.php'); ?>
</div>
<!--footer ends-->

<style>
	
	#formContainer {padding:20px;}
	label {margin-bottom:10px; display:block; font-size:13.5px;}
	.form-group {padding:0; width:33.33%; float:left}
	.form-group.col-50 {width:50%;}
	.form-group.col-50 input {width:90%;}
	.form-group.col-100 {width:100%;}
	.form-group.col-100 input {width:95%;}
	textarea.form-control {width:95%; height:100px;}
	.form-control {width:85%;}
	.form-control:focus {
    border: 1px solid #222;
}
.btn-submit {box-shadow:none; border:0; height:32px; padding:0 15px; cursor:pointer;}
.checkmark_radio {width:15px; height:15px;}
.check_text {margin-top:0;}
.container_radio {padding-left:24px;}
 .container_radio .checkmark_radio:after {
                top: 5px;
                left: 5px;
                width: 6px;
                height: 6px;
             
            }
			
			.d-flex {display:block;}
			.d-flex>div {display:inline-block; margin-right:15px;}
	
</style>
</body>
</html>
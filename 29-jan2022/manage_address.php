<?php 
include('header_include.php');
if(!isset($_SESSION['USERID'])){header("location:login.php"); exit; }
$registration_id = $_SESSION['USERID'];

$sql = "select * from exh_reg_payment_details where uid='$registration_id' and `show`='IIJS S 2021' AND allow_visitor='N' order by payment_id desc limit 0,1";
$ans = $conn->query($sql);
$nans=$ans->num_rows;
if($nans>0){
	echo "<script>alert('You are Exhibitor'); window.location = 'my_dashboard.php';</script>";
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<title>Manage Address</title>
<link rel="shortcut icon" href="images/fav.png" />
<link rel="stylesheet" type="text/css" href="https://gjepc.org/assets-new/css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="css/mystyle.css?v=<?php echo $version;?>" />

<link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Cabin'>
<link rel="stylesheet" type="text/css" href="css/general.css?v=<?php echo $version;?>" />
<link rel="stylesheet" type="text/css" href="css/inner_pg_style.css?v=<?php echo $version;?>" />
 
<link rel="stylesheet" type="text/css" href="css/responsive.css?v=<?php echo $version;?>" />
<link rel="stylesheet" type="text/css" href="css/visitor_reg.css?v=<?php echo $version;?>" />
<link rel="stylesheet" type="text/css" href="css/media_query.css?v=<?php echo $version;?>" />
<script type="text/javascript" src="js/jquery-1.8.3.min.js?v=<?php echo $version;?>"></script>
<!--NAV-->
<link href="css/flexnav.css?v=<?php echo $version;?>" media="screen, projection" rel="stylesheet" type="text/css">
<script src="js/jquery.flexnav.js?v=<?php echo $version;?>" type="text/javascript"></script>
<script src="js/common.js?v=<?php echo $version;?>"></script> 
<!--NAV-->

<!-- UItoTop plugin -->
<link rel="stylesheet" type="text/css" media="screen,projection" href="css/ui.totop.css?v=<?php echo $version;?>" />
<script src="js/easing.js?v=<?php echo $version;?>" type="text/javascript"></script>
<script src="js/jquery.ui.totop.js?v=<?php echo $version;?>" type="text/javascript"></script>  
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-178505237-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-178505237-1');
</script> 
<!-- Global site tag (gtag.js) - Google Ads: 679056788 --> <!-- <script async src="https://www.googletagmanager.com/gtag/js?id=AW-679056788"></script> <script> window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag('js', new Date()); gtag('config', 'AW-679056788'); </script>  -->
<!-- Event snippet for GJEPC_Google_PageView conversion page --> <script> gtag('event', 'conversion', {'send_to': 'AW-679056788/N1zUCJPKxLsBEJSr5sMC'}); </script> 
<script type="text/javascript">
    $(document).ready(function() {        
        $().UItoTop({ easingType: 'easeOutQuart' });        
    });
</script>

<!--<script src="jsvalidation/jquery.js" type="text/javascript"></script>-->
<style>
	.breadcome{
		background: #ccc;
    padding: 10px 14px;
    border-radius: 4px;
}
.address_box_container{width: 100%;display: flex;justify-content:flex-start;flex-wrap: wrap;}
.address_box_wrapper{padding: 10px;}
.address_box{/* width: 260px; */height: 100%;border: 1px solid #ccc;border-bottom:4px solid #a59459;border-radius: 7px;}

.btn{padding:7px 15px; background: #ccc; color: #fff;margin: 5px 0 16px 11px;
    display: inline-block;border-radius: 5px;transition: all 0.4s;color:#000;cursor: pointer;}
    .btn:hover{background: #000;color: #fff}
    .fancybox-can-swipe .fancybox-content, .fancybox-can-pan .fancybox-content{cursor:auto!important;}
    .addAddress{width:750px;}
    .Title{text-align: center;} 
    .Title h3{font-size: 18px;color: #000;text-align: center; display: inline-block; border-bottom: 1px solid#000;padding: 10px}
    label{display: block;

    font-size: 14px !important; 
 
    padding: 10px 0px 0px 4px;}
  .field{
background:#fff;
padding:3px 20px 3px 20px;
margin-bottom:1px;
}
 .field sup{
}
color:#F00;}

 .textField{
border:1px solid #9f9f9f;
padding:5px;
width:200px;
}
    .addressForm{    border: 1px solid#efefef;
    margin: -10px;
    padding: 11px;}
    .checkbox{margin-left: 10px;}
    .m-l-10{margin-left: 10px}
    .btn_wrapper{display: flex;justify-content: space-between;}
    .btn_box{width:50%;text-align: center;}
    .btn_address{display: block;padding: 7px 15px;text-align:  center }
    .bg_yellow{background: #000; color: #fff;}
     .bg_yellow:hover {background: #a59459; color: #fff;}
    .bg_red{background: #f14e23}
    .address{padding: 7px;}
    .address p{margin: 0;padding: 0px 5px 3px 5px;text-align: justify;}
</style>
<script src="jsvalidation/jquery.validate.js" type="text/javascript"></script> 
<script type="text/javascript">
$().ready(function() {
	$("#form").validate({
		rules: {
			addressType: {
			required: true,
			},
			address1: {
			required: true,
			},
			address2: {
			required: true,
			},
			state: {
			required: true,
			},    
			city: {
				required: true,
			},
			pin_code: {
				required: true,
				number:true,
				minlength:6,
				maxlength:6
			},
		},
		messages: {
		    addressType:{
				required: "Please Select Address Type"
			} ,	
			address1:{
				required: "Please Enter Your Address"
			} ,
			address2:{
				required: "Please Enter Your Address"
			} ,
			state: {
				required: "Please Select State",
			},  
			city:{
				required: "Please Enter City"
			},
			pin_code: {
				required: "Please Enter your pin code",
				number:"please Enter numbers only",
				minlength:"please Enter not less than 6 characters",
				maxlength:"please Enter not more than 6 characters"				
			},
	 }
	});
});
</script>
<script>
$(document).ready(function(){	
	 
	/*Remove Script Start*/
	$(document).on('click','.remove_image',function(){
    var remove_id = $(this).data('imageid');
	if(remove_id != ""){
	if(confirm("Are you sure you want to remove Address?"))  
	{
	    $.ajax({
            url: "ajax.php",
            type: "GET",        
            data:{remove_image:"remove_image", remove_id:remove_id},
			beforeSend: function(){
						//$('#progress').show();
						$('.loader').show();
						},
            success: function(data){					
				//alert("Address has been removed");
				window.location.href='manage_address.php';
				$('.loader').hide();
             }	
        }); 
	} }
	else  
    {  
       return false;  
    } 
  });  
  /*End*/ 
	 });
</script>
<script type="text/javascript">
	$(window).load(function() {
		$(".loader").fadeOut("slow");
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
background: url('images/loader.gif') 50% 50% no-repeat rgb(249,249,249);
opacity: 80;
}
</style>

<!-- Facebook Pixel Code -->
<script>
  !function(f,b,e,v,n,t,s)
  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
  n.queue=[];t=b.createElement(e);t.async=!0;
  t.src=v;s=b.getElementsByTagName(e)[0];
  s.parentNode.insertBefore(t,s)}(window, document,'script',
  'https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', '398834417477910');
  fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
  src="https://www.facebook.com/tr?id=398834417477910&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->
</head>

<body>
<div class="wrapper">
<div class="loader">  <div style="display:table; width:100%; height:100%;"><span style="display:table-cell; vertical-align:middle; text-align:center; padding-top:100px;">Please wait....</span></div></div>
<div class="header">
	<?php include('header1.php'); ?>
</div>

<!--container starts-->
<div class="inner_container my-5">
	<div class="bold_font text-center">
				<div class="d-block">
					<img src="https://www.gjepc.org/assets/images/gold_star.png" class="">
				</div>
				 Manage Address 
			</div>
  <div class="container box-shadow">
  		
    <div class="">
    
      
      <div id="loginForm">
     <p><span class='blink d-block'>2 Vaccine Doses Mandatory For Entry</span> </p>

        <div>
			<?php if($_SESSION['member_type'] != "MEMBER") { ?>
			<div>
			<a href="address.php" class="btn btn_add" style="float: left;" >Add Address</a>
			<!--<a href="visitor_registration.php"  class="btn btn_add" style="float: right;">Visitor Registration</a>-->
				<div class="clear"></div>
			</div> 
			
			<div class="row address_box_container">
				<?php
				//if($_SESSION['member_type'] != "MEMBER")
               // $addflag = "SELECT * FROM `communication_address_master` WHERE `address_identity`='CTC' and `registration_id`='$registration_id'";
				
				$addflag = "SELECT * FROM `n_m_billing_address` WHERE `registration_id`='$registration_id'";
				$queryadd = $conn->query($addflag);
				 $countx = $queryadd->num_rows;
				if($countx > 0){
                while($row1 = $queryadd->fetch_assoc())
				{

				 $addressType = filter(strtoupper($row1['type_of_address']));
				 $address1 = filter(strtoupper($row1['address1']));
				$address2 = filter(strtoupper($row1['address2']));
				$state = getStateName($row1['state'],$conn);
				$city = filter(strtoupper($row1['city']));
				$pin_code = filter($row1['pin_code']);
				$gst_number = filter(strtoupper($row1['gst_number']));
				?>      
				
				<div class="col-sm-6 col-md-4 mb-4 mb-sm-0 address_box_wrapper">
				<div class="address_box">
					<div class="address">
						
						<p><?php echo $address1;?></p>
						<p><?php echo $address2;?></p>
						<p><?php echo $city.' - '.$pin_code.', '.$state?></p>
						<p><?php echo $gst_number;?></p>		
					</div>
					<div class="btn_wrapper">
						<div class="btn_box">
						<a href="addressedit.php?id=<?php echo $row1['id'];?>" class="btn_address bg_yellow edit_data">Edit</a>
						</div>
						<div class="btn_box" style="border:1px solid #ccc">
						<p style="margin-top:6px;"><strong><?php echo getaddresstype($addressType,$conn);?></strong></p></div>
					</div>
				</div>
				</div>				
				<?php } } ?>
				</div>
			<div class="clear"></div>  
			<?php } ?>
				
				<?php
				if($_SESSION['member_type'] == "MEMBER"){ ?>
				<div class="cta">Member's Addresses coming from Membership dept</div>
				<div class="d-flex flex-wrap col-100">
				<?php
                $addflag = "SELECT distinct c_bp_number,address1,address2,state,city,pincode,gst_no FROM `communication_address_master` WHERE `address_identity`='CTC' and `registration_id`='$registration_id' AND c_bp_number!=''";
				$queryadd = $conn->query($addflag);
				$countx = $queryadd->num_rows;
				if($countx > 0){
                while($row2 = $queryadd->fetch_assoc())
				{
				$address1 = filter(strtoupper($row2['address1']));
				$address2 = filter(strtoupper($row2['address2']));
				$state = getStateName($row2['state'],$conn);
				$city = filter(strtoupper($row2['city']));
				$pin_code = filter($row2['pincode']);
				$gst_number = filter(strtoupper($row2['gst_no']));
				?>      
				
				<div class="address_box_wrapper col-100">
				<div class="address_box">
					<div class="address">
						<p><?php echo $address1;?></p>
						<p><?php echo $address2;?></p>
						<p><?php echo $city.' - '.$pin_code.', '.$state?></p>
						<p><?php echo $gst_number;?></p>		
					</div>					
				</div>
				</div>				
				<?php } } ?>
				</div>
				<?php } ?>
		</div>
		          
          <div class="clear"></div>
        </div>
      </div>
    </div>
  </div>

<div class="clear"></div>

<!--container ends-->
<!--footer starts-->
<div class="footer">
        <?php include ('footer.php'); ?>
      </div>
</div>
<!--footer ends-->
 <style type="text/css">
.appr_icon{
    border: 0px;
    outline: none;
    width: 44px;
}
#form1{display: none;}
#form2{display: none;}	
select{width: 96%;padding: 0px;height:37px; margin :0 auto; display:table;}
#updatefrom .textField,#form .textField{width: 96%;padding: 0px 2%;height:35px; margin :0 auto; display:table;}
#updatefrom .textField2,#form .textField2{width:80%;padding:0; float:left;}
#updatefrom .field,#form .field {
    background: none;
    padding: 0;
    float: left;
	width:31.33%;
	margin:0 1%;	
}
.submitbtn {
background: #f04e21;
border: none;
padding: 10px 15px;
margin-top: 15px;
color: #000;
cursor: pointer;
}
.button2 {    
    margin: 20px 10px 20px 0px;
    background: #751c54;
    padding: 7px 12px;
    font-size: 12px;
    margin-left: 13px;
    border-radius: 5px;
    color: #fff;
    cursor: pointer;
  }

.button1 {
    float: left;
    margin: 20px 10px 20px 0px;
    background: #751c54;
    padding: 5px 15px;
    border-radius: 15px;
    cursor: pointer;
    color: #fff;}

    #form label {
    width: 96%;
    display: block;
    float: none;
    /* font-weight: bold; */
    font-size: 10px;
    vertical-align: middle;
    padding-top: 2px;
    color: #751c54;;
	/*height:26px;*/
	margin:0 auto;
	line-height:initial;
	margin-bottom:5px;
	}
}
</style> 

</body>
</html>
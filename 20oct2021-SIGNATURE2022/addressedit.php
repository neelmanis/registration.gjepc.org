<?php include('header_include.php');
if(!isset($_SESSION['USERID'])){header("location:login.php");exit;}
$registration_id=$_SESSION['USERID'];
$sql = "select * from exh_reg_payment_details where uid='$registration_id' and `show`='IIJS Premiere 2021' AND allow_visitor='N' order by payment_id desc limit 0,1";
$ans = $conn->query($sql);
$nans=$ans->num_rows;
if($nans>0){
	echo "<script>alert('You are Exhibitor'); window.location = 'my_dashboard.php';</script>";
}
?>

<?php
$addressId = trim($_REQUEST['id']);
$action = $_REQUEST['action'];
if($action == 'editAddress')
{
	$type_of_address = filter($_POST['addresstype']);
	$address1 = filter($_POST['address1']);
	$address2 = filter($_POST['address2']);
	$state = filter($_POST['state']);
	$city = filter($_POST['city']);
	$pin_code = filter($_POST['pin_code']);
	$gst_number = filter(strtoupper($_POST['gst_number']));
	
	if($type_of_address=='2' || $type_of_address=='6'){
	$sqly="UPDATE `registration_master` SET `address_line1`='$address1',`address_line2`='$address2',`city`='$city',`state`='$state',`pin_code`='$pin_code' WHERE id='$registration_id'";
	$result = $conn->query($sqly);
	}
	
	$sqlOffice = "SELECT  type_of_address FROM n_m_billing_address WHERE registration_id='".$registration_id."'";
	$resultOffice = $conn->query($sqlOffice);
	while($officeRow =  $resultOffice->fetch_assoc()){
	$arrayOffice[]= $officeRow['type_of_address'];
	} 

	if(empty($type_of_address))
	{ $signup_error="Please Select Address Type"; }
	elseif(empty($address1))
	{ $signup_error="Please Enter Address 1"; }
	elseif(empty($address2))
	{ $signup_error="Please Enter Address 2"; }
	elseif(empty($state) && $state==0)
	{ $signup_error="Please Choose State"; }
	elseif(empty($city))
	{ $signup_error="Please Enter City"; }
	elseif(empty($pin_code) || strlen($pin_code)<6)
	{ $signup_error="Please Enter Pincode"; }
	/*elseif(empty($gst_number) || strlen($gst_number)>15 || strlen($gst_number)<15)
	{ $signup_error="Please Enter Valid GSTIN No"; } */
	elseif(isset($registration_id) && $registration_id!=""){
	
	if(isset($_FILES['gst_copy']) && $_FILES['gst_copy']['name']!="")
	{
		$gst_copy_name=$_FILES['gst_copy']['name'];
		$gst_copy_temp=$_FILES['gst_copy']['tmp_name'];
		$gst_copy_type=$_FILES['gst_copy']['type'];
		$gst_copy_size=$_FILES['gst_copy']['size'];
		
		if($gst_copy_name!="")
		{
			$create_gst_copy = 'images/address_gst_copy/'.$_SESSION['USERID'];
			if(!file_exists($create_gst_copy)) {
			mkdir($create_gst_copy, 0777);
			}
			$gst_copy = uploadAddressGST($gst_copy_name,$gst_copy_temp,$gst_copy_type,$gst_copy_size,$gst_number);
			
	$sqlx = "UPDATE `n_m_billing_address` SET `mod_date`=NOW(),`type_of_address`='$type_of_address',`address1`='$address1',`address2`='$address2',`state`='$state',`city`='$city',`pin_code`='$pin_code',`gst_number`='$gst_number',`gst_copy`='$gst_copy' WHERE registration_id='$registration_id' AND id='$addressId'";
	$resultx = $conn->query($sqlx);
	if($resultx){
	$signup_error = "Successfully Address Updated";
	header('location:manage_address.php');
	} else { $signup_error = "Server Error"; }
		}
	} else {
    $sqlx = "UPDATE `n_m_billing_address` SET `mod_date`=NOW(),`type_of_address`='$type_of_address',`address1`='$address1',`address2`='$address2',`state`='$state',`city`='$city',`pin_code`='$pin_code',`gst_number`='$gst_number' WHERE registration_id='$registration_id' AND id='$addressId'";
	$resultx = $conn->query($sqlx);
	if($resultx){
	$signup_error = "Successfully Address Updated";
	header('location:manage_address.php');
	} else { $signup_error = "Server Error";	}
	}
	}	
}
?>

<?php
$getAddress = "SELECT * FROM `n_m_billing_address` WHERE `registration_id`='$registration_id' AND `id`='$addressId'";
$queryadd = $conn->query($getAddress);		
$addressRow = $queryadd->fetch_assoc();

$type_of_address = filter($addressRow['type_of_address']);
$address1 = filter($addressRow['address1']);
$address2 = filter($addressRow['address2']);
$state = filter($addressRow['state']);
$city = filter($addressRow['city']);
$pin_code = filter($addressRow['pin_code']);
$gst_number = filter($addressRow['gst_number']);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<title>Manage Address</title>
<link rel="shortcut icon" href="images/fav.png" />
<link rel="stylesheet" type="text/css" href="css/mystyle.css?v=<?php echo $version;?>" />
<link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Cabin'>
<link rel="stylesheet" type="text/css" href="css/general.css?v=<?php echo $version;?>" />
<link rel="stylesheet" type="text/css" href="css/inner_pg_style.css?v=<?php echo $version;?>" />
 
<link rel="stylesheet" type="text/css" href="css/responsive.css?v=<?php echo $version;?>" />
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
.address_box{width: 260px; min-height: 100px;background: #ccc;border-bottom: 4px solid #282b8a;border-radius: 7px}
.btn{padding:7px 15px; background: #ccc; color: #fff;margin: 5px 0 16px 11px;
    display: inline-block;border-radius: 5px;transition: all 0.4s;color:#000;cursor: pointer;}
    .btn:hover{background: #000;color: #fff}
    .fancybox-can-swipe .fancybox-content, .fancybox-can-pan .fancybox-content{cursor:auto!important;}
    .addAddress{max-width:750px;}
    .Title{text-align: center;} 
    .Title h3{font-size: 18px;color: #000;text-align: center; display: inline-block; border-bottom: 1px solid#000;padding: 10px}
    #form label{display: block;

    font-size: 14px !important; 
 
    padding: 10px 0px 0px 4px;}
    .addressForm{    border: 1px solid#efefef;
    margin: -10px;
    padding: 11px;}
    .checkbox{margin-left: 10px;}
    .m-l-10{margin-left: 10px}
    .btn_wrapper{display: flex;justify-content: space-between;}
    .btn_box{width:50%;text-align: center;}
    .btn_address{display: block;padding: 7px 15px;text-align:  center }
    .bg_yellow{background: #fbcc0c}
    .bg_red{background: #f14e23}
    .address{padding: 7px;}
    .address p{margin: 0;padding: 0px 5px 3px 5px;text-align: justify;}
</style>


<style>
.error 
{ color:red;
}
.success 
{ color:green;
}
</style>

</head>

<body>
<div class="wrapper">

<div class="header">
	<?php include('header1.php'); ?>
</div>

<!--container starts-->
<div class="inner_container">
  <div class="container">
    <div class="container_leftn">
      <div class="breadcome"><a href="index.html">Home</a> > Manage Address </div>
      
      <div id="loginForm">
     
			<div id="formContainer">
       
          	<div class="addressForm">
          	<div class="Title"><h3>Update Address</h3></div>
			<?php if(isset($signup_error)){ echo '<span style="color: red;" />'.$signup_error.'</span>';} ?>
			<?php if(isset($_SESSION['address_error'])){ echo '<span style="color: red;" />'.$_SESSION['address_error'].'</span>'; unset($_SESSION['address_error']); } ?>
			
          	<form action="" class="cmxform" method="post" enctype="multipart/form-data" name="from" id="form">
			<input type="hidden" name="action" value="editAddress">	
            <div id="">
               <div class="field">
                <label> Address Type  <sup>*</sup> </label>
					<select name="addresstype" id="addresstype" class="textFieldsel">
					<option value="<?php echo $addressRow['type_of_address'];?>"><?php echo getaddresstype($addressRow['type_of_address'],$conn);?></option>}
          
					
					</select>
              </div>  			  
              <div class="field">
                <label> Address Line 1<sup>*</sup> </label>
				<input id="address1" name="address1" type="text" value="<?php echo $addressRow['address1']; ?>" class="textField" maxlength="40" autocomplete="off">
              </div>              
              <div class="field">
                <label>Address Line 2 <sup>*</sup> </label>
                <input id="address2" name="address2" type="text" class="textField" value="<?php echo $addressRow['address2']; ?>" maxlength="40" autocomplete="off">
              </div>   
              <div class="clear"></div>           
              <div class="field">
                <label>State  <sup>*</sup> </label>
                <select name="state" id="state" class="textFieldsel">
                    <?php 
                    $query=$conn->query("SELECT * from state_master WHERE country_code = 'IN'");
                    while($result=$query->fetch_assoc()){?>
                    <option value="<?php echo $result['state_code'];?>" <?php if($result['state_code']==$state){?> selected="selected" <?php }?>><?php echo $result['state_name'];?></option>
                    <?php } ?>
                </select>
				<span id="stateError" class="error"></span>
              </div>    
              
              <div class="field">
                <label>City  <sup>*</sup> </label>
                <input id="city" name="city" type="text" class="textField" value="<?php echo $addressRow['city']; ?>" autocomplete="off"/>
				<span id="cityError" class="error"></span>
              </div>			                
              <div class="field">
                <label>Pin Code <sup>*</sup> </label>
                <input id="pin_code" name="pin_code" type="text" class="textField" value="<?php echo $addressRow['pin_code']; ?>" maxlength="6" autocomplete="off"/>
				<span id="pinError" class="error"></span>
              </div>
              <div class="clear"></div>
			  <div class="field">
                <label>GST  <sup>*</sup> </label>
                <input id="gst_number" type="text" name="gst_number" class="textField" value="<?php echo $addressRow['gst_number']; ?>" maxlength="15">
				<span id="gstError" class="error"></span>
              </div>
                <div class="field">
                <label>GST Copy <sup>*</sup> </label>
                <input id="gst_copy" type="file" name="gst_copy" class="textField">
				<span id="gstCopyError" class="error"></span>
              </div>
                 <div class="field">
                <a  href="images/address_gst_copy/<?php echo $registration_id.'/'.$addressRow['gst_copy']; ?>" target="_blank"><img src="images/address_gst_copy/<?php echo $registration_id.'/'.$addressRow['gst_copy']; ?>" width="100%" height="100px" style="padding:7px;" alt=""></a>
              </div>
              <div class="clear"></div>
			  <span class="success" style="color: #0c6122;"></span>

            <div class="clear"></div>
             	 <input type="submit" name="submit" value="Submit" id="formBtn" class="submitbtn m-l-10">
            <div class="clear"></div> <br>
            
            </div>             
			</form>			
	
            </div>
          </div>
          <div class="clear"></div>
        </div>
      </div>
    </div>
  </div>

<div class="clear"></div>

<!--container ends-->
<!--footer starts-->
<div class="footer_wrap">
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
select{width: 100%;padding: 0px;height:37px; margin :0 auto; display:table;}
#form .textField{width: 96%;padding: 0px 2%;height:35px; margin :0 auto; display:table;}
#form .textField2{width:80%;padding:0; float:left;}
#form .field {
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
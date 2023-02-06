<?php include('header_include.php');?>
<?php
//echo '<pre>'; print_r($_SESSION);
if(empty($_SESSION['regis_id']))
{
$_SESSION['error'] = 0;
header("location: domestic_user_registration_step1.php"); //redirecting to first page
}
?>

<?php
$action = $_REQUEST['action'];
if($action == 'saveAddress')
{
	//validate Token
	if(isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {
	$type_of_address = filter($_POST['addresstype']);
	$address1 = filter($_POST['address1']);
	$address2 = filter($_POST['address2']);
	$state = filter($_POST['state']);
	$city = filter($_POST['city']);
	$pin_code = filter($_POST['pin_code']);
	$gst_number = filter(strtoupper($_POST['gst_number']));
	
	$sqlx="SELECT type_of_address FROM n_m_billing_address WHERE type_of_address='2' AND registration_id='".$_SESSION['regis_id']."'";
	$result = $conn->query($sqlx);
	$mysqlrow = $result->fetch_assoc();
	
	if(empty($type_of_address))
	{ $signup_error="Please Select Address Type"; }
	elseif($mysqlrow[0] == $type_of_address)
	{ $signup_error = "Head Office Already Selected"; }

	elseif(empty($address1))
	{ $signup_error="Please Enter Address 1"; }
	elseif(empty($address2))
	{ $signup_error="Please Enter Address 2"; }
	elseif(empty($state) && $state==0)
	{ $signup_error="Please Choose State"; }
	elseif(empty($city))
	{ $signup_error="Please Enter City"; }
    elseif(strlen($city)>19){
       $signup_error="Please Enter Correct City";	
    }
	elseif(empty($pin_code) || strlen($pin_code)<6)
	{ $signup_error="Please Enter Pincode"; }
	/*elseif(empty($gst_number) || strlen($gst_number)>15 || strlen($gst_number)<15)
	{ $signup_error="Please Enter Valid GSTIN No"; }*/
	elseif(isset($_SESSION['regis_id']) && $_SESSION['regis_id']!=""){
	
	if(isset($_FILES['gst_copy']) && $_FILES['gst_copy']['name']!="")
	{
		$gst_copy_name=$_FILES['gst_copy']['name'];
		$gst_copy_temp=$_FILES['gst_copy']['tmp_name'];
		$gst_copy_type=$_FILES['gst_copy']['type'];
		$gst_copy_size=$_FILES['gst_copy']['size'];
		
		if($gst_copy_name!="")
		{
			$create_gst_copy = 'images/address_gst_copy/'.$_SESSION['regis_id'];
			if(!file_exists($create_gst_copy)) {
			mkdir($create_gst_copy, 0777);
			}
			$gst_copy = uploadRegisAddressGST($gst_copy_name,$gst_copy_temp,$gst_copy_type,$gst_copy_size,$gst_number);
		}
			//if($gst_copy != '') {
	}		
	$sqlx = "INSERT INTO `n_m_billing_address`(`registration_id`, `post_date`,`type_of_address`, `address1`, `address2`, `state`, `city`, `pin_code`, `gst_number`,`gst_copy`) VALUES ('".$_SESSION['regis_id']."',NOW(),'$type_of_address', '$address1','$address2','$state','$city','$pin_code','$gst_number','$gst_copy')"; 
	$resultx = $conn->query($sqlx);
	if($type_of_address==2)
	{
		$updateHO = "UPDATE `registration_master` SET `address_line1`='$address1',`address_line2`='$address2',`city`='$city',`country`='IN',`state`='$state',`pin_code`='$pin_code' WHERE id='".$_SESSION['regis_id']."'";
		$resultHO = $conn->query($updateHO);
	}
	if($resultx){ $signup_success = "Address Added Successfully"; $type_of_address=''; $address1=''; $address2=''; $city=''; $pin_code=''; $gst_number=''; } else {	$signup_error = "Server Error";	}
		//}	
		//}
	/*} else {
     $signup_error = "Please Upload GSTIN Copy";
	}*/
	}
	} else {
	 $signup_error ="Invalid Token Error";
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Domestic User Registration Step - 2</title>
	<link rel="icon" href="https://gjepc.org/images/favicon.ico" type="image/x-icon"/>
	<link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Cabin'>
	<link rel="stylesheet" type="text/css" href="css/general.css?v=<?php echo $version;?>" />
	<link rel="stylesheet" type="text/css" href="css/inner_pg_style.css?v=<?php echo $version;?>"/>	 
	<link rel="stylesheet" type="text/css" href="css/responsive.css?v=<?php echo $version;?>"/>
	<link rel="stylesheet" type="text/css" href="css/media_query.css?v=<?php echo $version;?>"/>
	<link rel="stylesheet" type="text/css" href="css/visitor_reg.css?v=<?php echo $version;?>"/>
	<script type="text/javascript" src="js/jquery-1.8.3.min.js?v=<?php echo $version;?>"></script>

	<!--NAV-->
	<link href="css/flexnav.css?v=<?php echo $version;?>" media="screen, projection" rel="stylesheet" type="text/css">
	<!--<script src="js/jquery.flexnav.js" type="text/javascript"></script>-->
	<script type="text/javascript" src="flexnav-master/js/jquery.flexnav.min.js?v=<?php echo $version;?>"></script>
	<script src="js/common.js?v=<?php echo $version;?>"></script> 
	<!--NAV-->
	<script src="jsvalidation/jquery.validate.js?v=<?php echo $version;?>" type="text/javascript"></script>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-178505237-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-178505237-1');
</script>
<!-- Event snippet for Virtual IIJS Sign-up conversion page In your html page, add the snippet and call gtag_report_conversion when someone clicks on the chosen link or button. --> 
<!-- <script> 
function gtag_report_conversion(url) { 
	var callback = function () { 
		if (typeof(url) != 'undefined') { 
	        window.location = url; 
	    }
	}; 
    gtag('event', 'conversion', { 'send_to': 'AW-679056788/yzWTCLL_luABEJSr5sMC', 'event_callback': callback }); return false; 
} 
</script> -->
<!-- Event snippet for Virtual IIJS Sign-up-Step2 conversion page
In your html page, add the snippet and call gtag_report_conversion when someone clicks on the chosen link or button. -->
<script>
function gtag_report_conversion(url) {
  var callback = function () {
    if (typeof(url) != 'undefined') {
      window.location = url;
    }
  };
  gtag('event', 'conversion', {'send_to': 'AW-679056788/kpIqCL-NieEBEJSr5sMC'});
  return false;
}

</script>
<script type="text/javascript">
	
   
      	gtag_report_conversion();
      	fbq('track', 'Step2');

</script>
<!-- Event snippet for Virtual IIJS Sign-up-Step1 conversion page --> <script>  </script> 


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
	<script> 
	history.pushState(null, null, null); 
	window.addEventListener('popstate', function () { 
	history.pushState(null, null, null); 
	}); 
	</script>
	
	<script src="jsvalidation/jquery.validate.js" type="text/javascript"></script> 
<script type="text/javascript">
$().ready(function() {
	
	//validate file extension custom  method.
    jQuery.validator.addMethod("extension", function (value, element, param) {
            param = typeof param === "string" ? param.replace(/,/g, '|') : "pdf|docx|doc|txt";
            return this.optional(element) || value.match(new RegExp(".(" + param + ")$", "i"));
            }, jQuery.format("Please enter a value with a valid extension."));
			
	$("#regisForm").validate({
		rules: {
			addresstype: {
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
		    addresstype:{
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
				required: "Please Enter City",
				maxlength:19
			},
			pin_code: {
				required: "Please Enter your pin code",
				number:"Please Enter numbers only",
				minlength:"Please Enter not less than 6 characters",
				maxlength:"Please Enter not more than 6 characters"				
			},
	 }
	});
});
	 function onlyAlphabets(e, t) {
            try {
                if (window.event) {
                    var charCode = window.event.keyCode;
                }
                else if (e) {
                    var charCode = e.which;
                }
                else { return true; }
                if ((charCode > 64 && charCode < 91) || (charCode > 96 && charCode < 123))
                    return true;
                else
                    return false;
            }
            catch (err) {
                alert(err.Description);
            }
        } 
</script>
<script>
$(document).ready(function(){

      $('.gstholder_status_no').click(function(){
        
		$('#companyDoc').html("<ul class='error'><li>(Kindly upload Max 2MB. jpeg, png,pdf)</li><li>Kindly upload Shop certificate / Gomastha Lisence</li></ul>");
		$('#gst_number').attr('placeholder','Not Applicable');
		$('#gst_number').attr('disabled',true);
      });
	  $('.gstholder_status_yes').click(function(){
        $('#gst_number').attr('placeholder','GST Number');
$('#gst_number').attr('disabled',false);
		$('#companyDoc').html("<ul class='error'><li>(Kindly upload Max 2MB. jpeg, png,pdf)</li><li>Kindly Upload GSTIN</li></ul>");
      });
});
</script>
<style>
.error 
{ color:red;
}
.success 
{ color:green;
}
</style>



</head>
<style>
  #table_data {
  font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 98%;
  margin-bottom: 20px;
}

#table_data td, #table_data th {
  border: 1px solid #ddd;
  padding: 8px;
}

#table_data tr:nth-child(even){background-color: #f2f2f2;}

#table_data tr:hover {background-color: #ddd;}

#table_data th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #776e6e;
  color: white;
}
</style>

<body>
	
	
    <div class="wrapper">
       <div class="header">
          <?php include('header1.php'); ?>
      </div>
      <!-- <div class="new_banner">
    <img src="images/iijs-virtual-1.jpg">
    </div> -->
    <div class="clear"></div>

    <!--container starts-->
    <div class="container_wrap">
       <div class="container">

        <span class="headtxt">Domestic User Registration Step - 2</span>	
        <div id="loginForm">
        <div class="box-shadow">
        <div class="d-flex flex-row justify-center form-group m-10 form-tab">
			<label class="container_radio"><span class="check_text"></span>
			  <input type="radio" disabled>
			  <span class="checkmark_radio"></span>
		  </label>
		  <label class="container_radio radio_center"><span class="check_text"></span>
			  <input type="radio" checked="checked" disabled >
			  <span class="checkmark_radio"></span>
		  </label>
		  <label class="container_radio"><span class="check_text"></span>
			  <input type="radio"disabled >
			  <span class="checkmark_radio"></span>
		  </label>
		</div>
           
        <div class="clear"></div>
        <?php if(isset($signup_error)){ echo '<span style="color: red;" />'.$signup_error.'</span>';} ?>
        <?php if(isset($signup_success)){ echo '<span style="color: green;" />'.$signup_success.'</span>';} ?>
         
		<div class="title">
		  <h4>Address Information</h4>
		</div>
		<div class="clear"></div>
		<div class="borderBottom"></div>
		
		<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data" name="regisForm" id="regisForm" autocomplete="off"> 
		<input type="hidden" name="action" value="saveAddress">
		<?php token(); ?>
		
		<div class="d-flex flex-column">

		<div class="d-flex flex-row form-setup">
		<div class="col-50 d-flex justify-around flex-wrap form-group">
		    <div class="col-50 d-flex align-baseline">
			  <label><span style="color: red;" />*</span>Address Type:  </label>
			</div>
		    <div class="col-50">
				<select name="addresstype" id="addresstype" class="select-control">
					<option value="">-- Select Address Type --</option>
						<?php 
						$sql2="SELECT * FROM `type_of_comaddress_master` WHERE `address_identity`='CTC'";
						$result2=$conn->query($sql2);
						while($rows2=$result2->fetch_assoc())
						{
							if($rows2['id']==$type_of_address)
							{
							echo "<option selected='selected' value='$rows2[id]'>$rows2[type_of_comaddress_name]</option>";
							}	else	{
							echo "<option value='$rows2[id]'>$rows2[type_of_comaddress_name]</option>";
							}
						} ?>
				</select>
		    </div>
		  </div>
		<div class="col-50 d-flex justify-around flex-wrap form-group">
			<div class="col-50 d-flex align-baseline">
				<label><span style="color: red;" />*</span>Address Line 1 : </label>
			</div>
			<div class="col-50">
				<input type="text" class="form-control" id="address1" name="address1" value="<?php echo $address1;?>" autocomplete="off"/>
			</div>
		</div>
		</div>
		
		<div class=" d-flex flex-row form-setup">
			<div class="col-50 d-flex justify-around flex-wrap form-group">
		  <div class="col-50 d-flex align-baseline">
			<label><span style="color: red;" />*</span> Address Line 2: </label>
		</div>
		<div class="col-50">
			<input type="text" class="form-control" id="address2" name="address2" value="<?php echo $address2;?>" autocomplete="off"/>  
		</div>
		</div>
		
			<div class="col-50 d-flex justify-around flex-wrap form-group">
			<div class="col-50 d-flex align-baseline">
			  <label><span style="color: red;" />*</span>State : </label>
			</div>
			
			<div class="col-50">
			<select name="state" id="state" class="select-control">
			<option value="">---------- Select State ----------</option>
			<?php 
			$query=$conn->query("SELECT * from state_master WHERE country_code = 'IN'");
			while($result=$query->fetch_assoc()){?>
			<option value="<?php echo $result['state_code'];?>"><?php echo strtoupper($result['state_name']);?></option>
			<?php }?>
			</select>  
			</div>
			</div>			
		</div>
		
		<div class=" d-flex flex-row form-setup">
		  <div class="col-50 d-flex justify-around flex-wrap form-group">
			<div class="col-50 d-flex align-baseline">
			  <label><span style="color: red;" />*</span>City : </label>
		  </div>
		  <div class="col-50">
			  <input type="text" class="form-control" id="city" name="city" onkeypress="return onlyAlphabets(event,this);" value="<?php echo $city;?>" autocomplete="off" maxlength='19'/> </div>
		  </div>
		 <div class="col-50 d-flex justify-around flex-wrap form-group">
			  <div class="col-50 d-flex align-baseline">
				<label><span style="color: red;" />*</span>Pin Code : </label>
			</div>
			<div class="col-50">
				<input type="text" class="form-control" id="pin_code" name="pin_code" value="<?php echo $pin_code;?>" maxlength="6" autocomplete="off"/>
			</div>
		 </div>
		
		</div>
		     <div class=" d-flex flex-row form-setup">
				<div class="col-50 d-flex justify-around flex-wrap form-group ">
				<div class="col-50 d-flex align-baseline">
					<label>GST holder status:</label>
				</div>
				<div class="col-50 d-flex justify-around align-center">
					<label class="container_radio"><span class="check_text">Yes</span>
					  <input type="radio"  id="gstholder_status" class="gstholder_status_yes" name="gstholder_status" value="Y">
					  <span class="checkmark_radio"></span>
				  </label>
				  <label class="container_radio"><span class="check_text">No</span>
					  <input type="radio"  id="gstholder_status" class="gstholder_status_no" name="gstholder_status" value="N">
					  <span class="checkmark_radio"></span>
				  </label>
				</div>
				</div>
			
			</div>
		<div class=" d-flex flex-row form-setup">	
			<div class="col-50 d-flex justify-around flex-wrap form-group">
			<div class="col-50 d-flex align-baseline">
			  <label>GSTIN : </label>
		  </div>
		  <div class="col-50">
		  <input type="text" class="form-control" id="gst_number" name="gst_number" value="<?php echo $gst_number;?>" maxlength="15" autocomplete="off"/> </div>
		  </div>
		  
		 <div class="col-50 d-flex justify-around flex-wrap form-group">
			<div class="col-50 d-flex align-baseline">
			  <label>GSTIN Upload: </label>
			</div>
		    <div class="col-50">
		    <input type="file" class="form-control" id="gst_copy" name="gst_copy" accept=".jpg,.jpeg,.png,.pdf"/>
			<div id="companyDoc"></div>
			</div>
		  </div>		  
		</div>
		</div>
		<?php
		$AddressCount = "SELECT * FROM `n_m_billing_address` WHERE registration_id='".$_SESSION['regis_id']."'";
		$mrows = $conn->query($AddressCount);
		$countx = $mrows->num_rows;
		?>
		<div class="d-flex flex-row form-setup">
		<div class="col-50 d-flex  flex-wrap form-group">      
		  <input type="submit" name="submit" value="Submit"  class="btn btn-submit">
		  <?php if($countx > 0){ ?>
		  <a href="domestic_user_registration_step3.php"  class="btn btn-submit" >Next </a>
		  <?php } ?>
		</div>
		</div>

		</form>
		
		<?php if($countx > 0){ ?>
		<div class="d-flex justify-center">
			<table id="table_data">
							<tr>
							<th align="center">Address Type</th>
							<th align="center">Address 1</th>
							<th align="center">Address 2:</th>
							<th align="center">State :</th>
							<th align="center">Pin Code  :</th>
							<th align="center">City  :</th>
							<th align="center">GSTIN  :</th>
							</tr>
							<tbody>
							<?php while($rowx = $mrows->fetch_assoc()) {?>
							<tr>
							<td align="center"><?php echo getaddresstype($rowx['type_of_address'],$conn);?></td>
							<td align="center"><?php echo $rowx['address1'];?></td>
							<td align="center"><?php echo $rowx['address2'];?></td>
							<td align="center"><?php echo getStateName($rowx['state'],$conn);?></td>
							<td align="center"><?php echo $rowx['pin_code'];?></td>
							<td align="center"><?php echo $rowx['city'];?></td>
							<td align="center"><?php echo $rowx['gst_number'];?></td>				
							</tr>
							<?php } ?>
							</tbody>
			</table> 
		</div>
		<?php } ?>		
</div>
</div>
</div>
<div class="clear"></div>
</div>
</div>
<!--container ends-->
<!--footer starts-->
<div class="footer">
    <?php include ('footer.php'); ?>
</div>
</div>
<!--footer ends-->


<link rel="stylesheet" type="text/css" href="css/new_style.css" />

</body>
</html>
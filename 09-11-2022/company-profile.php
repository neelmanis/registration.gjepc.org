<?php include('header_include.php');
if(!isset($_SESSION['USERID'])){header("location:login.php");exit;}
$registration_id = $_SESSION['USERID'];
$sql = "select * from exh_reg_payment_details where uid='$registration_id' and `show`='IIJS SIGNATURE 2022' AND allow_visitor='N' order by payment_id desc limit 0,1";
$ans = $conn->query($sql);
$nans=$ans->num_rows;
if($nans>0){
	echo "<script>alert('You are Exhibitor'); window.location = 'my_dashboard.php';</script>";
}
?>

<?php
$action = $_REQUEST['action'];
if($action == 'saveProfile')
{
	$address1 = filter($_POST['address1']);
	$address2 = filter($_POST['address2']);
	$state = filter($_POST['state']);
	$city = filter($_POST['city']);
	$pin_code = filter($_POST['pin_code']);
	$company_pan_no = filter(strtoupper($_POST['company_pan_no']));
	$company_gstn = filter(strtoupper($_POST['company_gstn']));
	
	if($company_pan_no!='' || $company_gstn!=''){
	//	echo "select id from registration_master where (company_pan_no='$company_pan_no' || company_gstn='$company_gstn') AND id!=$registration_id"; exit;
	$query = $conn ->query("select id from registration_master where (company_pan_no='$company_pan_no' || company_gstn='$company_gstn') AND id!=$registration_id");
    $num   = $query->num_rows;
	if($num>0)
	{
		echo '<script language="javascript">';
		echo 'alert("PAN No or GSTIN Already Exist")';
		echo '</script>';		
	echo "<meta http-equiv=refresh content=\"0;url=company-profile.php?action=view\">"; exit;
	}
	} else { 
	
	}


	if(isset($_FILES['gst_copy']) && $_FILES['gst_copy']['name']!="")
	{
		/* GST COPY */
		$gst_copy_name=$_FILES['gst_copy']['name'];
		$gst_copy_temp=$_FILES['gst_copy']['tmp_name'];
		$gst_copy_type=$_FILES['gst_copy']['type'];
		$gst_copy_size=$_FILES['gst_copy']['size'];
		$attach="gst_copy";
		if($gst_copy_name!="")
		{
			$create_gst_copy = 'images/'.$attach;
			$gst_copy=uploadPanGST($gst_copy_name,$gst_copy_temp,$gst_copy_type,$gst_copy_size,$attach);
		}
	}	
	if(isset($_FILES['pan_no_copy']) && $_FILES['pan_no_copy']['name']!="")
	{
		/* PAN COPY */
		$pan_no_copy_name=$_FILES['pan_no_copy']['name'];
		$pan_no_copy_temp=$_FILES['pan_no_copy']['tmp_name'];
		$pan_no_copy_type=$_FILES['pan_no_copy']['type'];
		$pan_no_copy_size=$_FILES['pan_no_copy']['size'];
		$attach="pan_no_copy";
		if($pan_no_copy_name!="")
		{
			$create_pan_no_copy = 'images/'.$attach;
			$pan_no_copy=uploadPanGST($pan_no_copy_name,$pan_no_copy_temp,$pan_no_copy_type,$pan_no_copy_size,$attach);
		}
	}
	
	if(empty($company_pan_no))
	{ $signup_error="Please Enter PAN No"; }
	elseif(empty($company_gstn))
	{ $signup_error="Please Enter GSTIN No"; }
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
	elseif($pan_no_copy=='invalidfile')
	{ $signup_error="Invalid file Selected or more than 2MB ";  }
	elseif($gst_copy=='invalidfile')
	{ $signup_error="Invalid file Selected or more than 2MB "; }
	elseif(isset($registration_id) && $registration_id!=""){
		
		$sqlreg.="update registration_master set approval_status='U'"; 
	if(isset($gst_copy) && $gst_copy!='')
		$sqlreg.=",`gst_copy`='$gst_copy'";
	if(isset($pan_no_copy) && $pan_no_copy!='')
		$sqlreg.=",`pan_no_copy`='$pan_no_copy'";
	if(isset($company_pan_no) && $company_pan_no!='')
		$sqlreg.=",`company_pan_no`='$company_pan_no'";
	if(isset($company_gstn) && $company_gstn!='')
		$sqlreg.=",`company_gstn`='$company_gstn'";
	$sqlreg.=" ,address_line1='$address1',address_line2='$address2',state='$state',city='$city',pin_code='$pin_code' where id = '$registration_id'";
//	echo $sqlreg; exit;
	$resultx = $conn->query($sqlreg);
	if($resultx){
		header('location:company-profile.php');
	} else {
		$signup_error = "Server Error";
	}
	}	
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<title>Company Profile</title>
<link rel="icon" href="https://gjepc.org/assets/images/fav_icon.png" type="image/x-icon"/>
<link rel="stylesheet" type="text/css" href="https://gjepc.org/assets-new/css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="css/mystyle.css" />
<link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Cabin'>
<link rel="stylesheet" type="text/css" href="css/general.css" />
<link rel="stylesheet" type="text/css" href="css/inner_pg_style.css" />
 
<link rel="stylesheet" type="text/css" href="css/responsive.css" />
<link rel="stylesheet" type="text/css" href="css/media_query.css" />
 <link rel="stylesheet" type="text/css" href="css/visitor_reg.css?v=1.27" />
<script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>

<!--NAV-->
<link href="css/flexnav.css" media="screen, projection" rel="stylesheet" type="text/css">
<script src="js/jquery.flexnav.js" type="text/javascript"></script>
<script src="js/common.js"></script> 
<!--NAV-->

<!-- UItoTop plugin -->
<link rel="stylesheet" type="text/css" media="screen,projection" href="css/ui.totop.css" />
<script src="js/easing.js" type="text/javascript"></script>
<script src="js/jquery.ui.totop.js" type="text/javascript"></script>    
<!-- <script type="text/javascript">
    $(document).ready(function() {        
        $().UItoTop({ easingType: 'easeOutQuart' });        
    });
</script> -->

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
/*.btn{padding:7px 15px; background: #ccc; color: #fff;margin: 5px 0 16px 11px;
    display: inline-block;border-radius: 5px;transition: all 0.4s;color:#000;cursor: pointer;}
    .btn:hover{background: #000;color: #fff}*/
    .fancybox-can-swipe .fancybox-content, .fancybox-can-pan .fancybox-content{cursor:auto!important;}
    .addAddress{max-width:750px;}
    .Title{text-align: center;} 
    .Title h3{font-size: 18px;color: #000;text-align: center; display: inline-block; border-bottom: 1px solid#000;padding: 10px}
    #form label{display: block;

    font-size: 14px !important; 
 
    padding: 10px 0px 0px 4px;}
   /* .addressForm{    border: 1px solid#efefef;
    margin: -10px;
    padding: 11px;}*/
    .checkbox{margin-left: 10px;}
    .m-l-10{margin-left: 10px}
    .btn_wrapper{display: flex;justify-content: space-between;}
    .btn_box{width:50%;text-align: center;}
    .btn_address{display: block;padding: 7px 15px;text-align:  center }
    .bg_yellow{background: #fbcc0c}
    .bg_red{background: #f14e23}
    .address{padding: 7px;}
    .address p{margin: 0;padding: 0px 5px 3px 5px;text-align: justify;}
    #formContainer {    
    padding: 20px 10px;
    border: 0px solid #f3f3f3;
	}
</style>
<script src="jsvalidation/jquery.validate.js" type="text/javascript"></script> 
<script type="text/javascript">
$().ready(function() {

	$("#form").validate({
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
	
$('.numeric').keypress(function (event) {
  var keycode = event.which;
  if (!(event.shiftKey == false && (keycode == 46 || keycode == 8 || keycode == 37 || keycode == 39 || (keycode >= 48 && keycode <= 57)))) 
  {
    event.preventDefault();
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
    gstinValidation = () => {
        const fi = document.getElementById('gst_copy'); 
        // Check if any file is selecteds.
        if (fi.files.length > 0) {
            for (const i = 0; i <= fi.files.length - 1; i++) {
  
                const fsize = fi.files.item(i).size;
                const file = Math.round((fsize / 1024));
                // The size of the file.
                if (file >= 2048) {
                    //alert("File too Big, please select a file less than 2MB");
					$("#gstinSizeError").text("Please select a file less than 2MB"); 
                } /* else if(file < 2048) {
                    alert(
                      "File too small, please select a file greater than 2mb");
                }  else {
                    document.getElementById('size').innerHTML = '<b>'
                    + file + '</b> KB';
                } */
            }
        }
    }
	
	panValidation = () => {
        const fi = document.getElementById('pan_no_copy');
        // Check if any file is selected.
        if (fi.files.length > 0) {
            for (const i = 0; i <= fi.files.length - 1; i++) {
  
                const fsize = fi.files.item(i).size;
                const file = Math.round((fsize / 1024));
                // The size of the file.
                if (file >= 2048) {
                    //alert("File too Big, please select a file less than 2MB");
					$("#panSizeError").text("Please select a file less than 2MB"); 
                } /* else if(file < 2048) {
                    alert(
                      "File too small, please select a file greater than 2mb");
                }  else {
                    document.getElementById('size').innerHTML = '<b>'
                    + file + '</b> KB';
                } */
            }
        }
    }
</script>
<style>
.error 
{ color:red;
}
.success 
{ color:green;
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

<div class="header">
	<?php include('header1.php'); ?>
</div>

<!--container starts-->

  <div class="container my-5">
    <div class="container_leftn">
     <!--  <div class="breadcome"><a href="index.php">Home</a> > Manage Address </div> -->

     <div class="bold_font text-center">
			<div class="d-block">
				<img src="https://www.gjepc.org/assets/images/gold_star.png" class="">
			</div>
			Company Profile
		</div>
      <div class="clear"></div>
      <div id="loginForm" class="box-shadow">
     
			<div id="formContainer" class="border-0 p-0">
          	<div class="">
          	<div class="addressForm border-0 p-0">
			<?php if(isset($signup_error)){ echo '<span style="color: red;" />'.$signup_error.'</span>';} ?>			
			
			<?php
			$sqlxx = "select company_name,company_pan_no,company_gstn,approval_status,disapprove,pan_no_copy,gst_copy,address_line1,address_line2, city,state,pin_code,disapprove from registration_master where id = '$registration_id'";
			$xx = $conn->query($sqlxx);
			$getimg = $xx->fetch_assoc();
			$company_name = strtoupper(str_replace(array('&amp;','&AMP;'), '&', $getimg['company_name']));
			$pan_no_copy = $getimg['pan_no_copy'];
			$gst_copy = $getimg['gst_copy'];
			$company_pan_no = $getimg['company_pan_no'];
			$company_gstn = $getimg['company_gstn'];
			$address1 = $getimg['address_line1'];
			$address2 = $getimg['address_line2'];
			$city	  =	$getimg['city'];
			$state    =	$getimg['state'];
			$pin_code	= $getimg['pin_code'];	
			$disapprove	= $getimg['disapprove'];	
			$gst_copy_ext = pathinfo($getimg['gst_copy'], PATHINFO_EXTENSION); 
			$pan_no_copy_ext = pathinfo($getimg['pan_no_copy'], PATHINFO_EXTENSION); 
			?>
			
			
          	<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="cmxform" method="POST" enctype="multipart/form-data" name="from" id="form">
			<input type="hidden" name="action" value="saveProfile">			
            <div id="" class="row">
				<div class="col-sm-6 col-md-4 form-group">
                <label> Company Name <span style="color: red;">*</span></label>
				<input class="form-control" value="<?php echo $company_name;?>" readonly>
                </div>
				
				<div class="col-sm-6 col-md-4 form-group">
                <label> Company PAN No <span style="color: red;">*</span></label>
				<input id="company_pan_no" name="company_pan_no" type="text" class="form-control" value="<?php echo $company_pan_no;?>" autocomplete="off" maxlength="10" <?php if($company_pan_no =="NULL" || $company_pan_no ==""){?> value="" <?php } else {?> value="<?php echo $company_pan_no;?>" readonly <?php } ?>>
                </div>
				
				<div class="col-sm-6 col-md-4 form-group">
                <label>PAN Copy <span style="color: red;">*</span></label>
                <input id="pan_no_copy" type="file" name="pan_no_copy" class="form-control" onchange="panValidation()" accept=".jpg,.jpeg,.png,.pdf">
				<p class="fail" id="panCopyEmpty"></p><p class="fail" id="panSizeError"></p>
				
                </div>
				
				<div class="col-sm-6 col-md-4 form-group">
                <label>GSTIN <span style="color: red;">*</span></label>
                <input type="text" class="form-control" id="company_gstn" name="company_gstn" autocomplete="off" maxlength="15" <?php if($company_gstn =="NULL" || $company_gstn ==""){?> value="" <?php } else {?> value="<?php echo $company_gstn;?>" readonly  <?php } ?>>
                </div>
				
                <div class="col-sm-6 col-md-4 form-group">
                <label>GST Copy <span style="color: red;">*</span></label>
                <input id="gst_copy" type="file" name="gst_copy" class="form-control" onchange="gstinValidation()" accept=".jpg,.jpeg,.png,.pdf">
				
                 </div><p class="fail" id="gstinEmpty"></p><p class="fail" id="gstinSizeError"></p>
			   			  
                <div class="col-sm-6 col-md-4 form-group">
                <label> Address 1 <span style="color: red;">*</span></label>
				<input id="address1" name="address1" type="text" class="form-control" value="<?php echo $address1;?>" maxlength="40" autocomplete="off">
                </div>
				
                <div class="col-sm-6 col-md-4 form-group">
                <label>Address 2 <span style="color: red;">*</span></label>
                <input id="address2" name="address2" type="text" class="form-control" value="<?php echo $address2;?>" maxlength="40" autocomplete="off">
                </div> 
		          
                <div class="col-sm-6 col-md-4 form-group">
                <label>State <span style="color: red;">*</span></label>
                <select name="state" id="state" class="form-control">
                    <option value="">---- Select State ----</option>
                    <?php
					$sql="SELECT * from state_master WHERE country_code = 'IN'";
					$result=$conn->query($sql);
					while($rows=$result->fetch_assoc())
					{
					if($rows['state_code']==$state)
					{
					echo "<option selected='selected' value='$rows[state_code]'>$rows[state_name]</option>";
					}	else	{
					echo "<option value='$rows[state_code]'>$rows[state_name]</option>";
					}}	?>
                </select>
                </div>
				
                <div class="col-sm-6 col-md-4 form-group">
                <label>City <span style="color: red;">*</span></label>
                <input id="city" name="city" type="text" class="form-control" onkeypress="return onlyAlphabets(event,this);" value="<?php echo $city;?>" autocomplete="off" maxlength="30"/>
                </div>
				
                <div class="col-sm-6 col-md-4 form-group">
                <label>Pin Code <span style="color: red;">*</span></label>
                <input id="pin_code" name="pin_code" type="text" class="form-control numeric" value="<?php echo $pin_code;?>" maxlength="6" autocomplete="off"/>
                </div>
				<?php  if($getimg['approval_status']=="D"){ ?>
				<div class="col-12">
             	 <input type="submit" name="submit" value="Submit" id="formBtn" class="btn btn-submit">
				</div>
				<?php } ?>

			    <div class="col-12 form-group">
				  <span class="success" style="color: #0c6122;"></span>
				</div>            
            </div>             
			</form>
			
			<?php if($getimg['approval_status']=="D"){ ?>
				<div class="alert alert-danger" role="alert"> Reason of DisApprove : <?php echo $disapprove;?></div>
			<?php } elseif($getimg['approval_status']=="U"){ ?>
				<div class="alert alert-warning" role="alert">Approval is Pending from Admin</div>
			<?php } ?>
			
		</div>
            </div>
          
          <div class="clear"></div>
      </div>
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
    width: 100%;
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
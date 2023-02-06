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
$action=$_REQUEST['action'];
if($action=="save")
{
	//validate Token
	if(isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {
	$create_dir = 'images/employee_directory/'.$_SESSION['regis_id'];
	if (!file_exists($create_dir)) {
	   mkdir($create_dir, 0777);
	}
	
	function uploadOwnerImage($file_name,$file_temp,$file_type,$file_size,$id,$name)
	{
		$upload_image = '';
		$target_folder = 'images/employee_directory/'.$_SESSION['regis_id'].'/'.$name.'/';
		$target_path = "";
		$user_id = $_SESSION['regis_id'];
		$file_name = str_replace(" ","_",$file_name);
		
		if(preg_match("/.php/i", $file_name) || preg_match("/shell/i", $file_name)) {
		echo "Sorry something error while uploading..."; exit;
		}
		else if($file_name != '')
		{
			if((($file_type == "image/jpg") || ($file_type == "image/jpeg") || ($file_type == "image/png") || ($file_type == "application/pdf")) && $file_size < 2097152)
			{
				$random_name = rand();
				$target_path = $target_folder.$user_id.'_'.$id.'_'.$name.'_'.$random_name.$file_name;
				if(@move_uploaded_file($file_temp, $target_path))
				{
					$upload_image = $user_id.'_'.$id.'_'.$name.'_'.$random_name.$file_name;
				}
				else
				{
					echo "Sorry error while uploading";
				}
			}
			else
			{
				echo "Invalid file";
			}	
		}		
		return $upload_image;
	}
	
		$shows = "signature2";
		$year = "2021";
		$degn_type = "Owner";
		$designation = $_REQUEST['designation'];
		$name = filter(strtoupper($_REQUEST['name']));
		$lname = filter(strtoupper($_REQUEST['lname']));
		$email = filter(strtoupper($_REQUEST['email']));
		$mobile = filter($_REQUEST['mobile']);
		$gender = $conn->real_escape_string($_REQUEST['gender']);		
		$pan_no = filter(strtoupper($_REQUEST['pan_no']));
		$aadhar_no = filter(strtoupper($_REQUEST['aadhar_no']));
		
	if(isset($_FILES['photo']) && $_FILES['photo']['name']!="")
	{
		/* passport picture */
		$photo_name=$_FILES['photo']['name'];
		$photo_temp=$_FILES['photo']['tmp_name'];
		$photo_type=$_FILES['photo']['type'];
		$photo_size=$_FILES['photo']['size'];
		$attach="photo";
		if($photo_name!="")
		{
			$create_photo = 'images/employee_directory/'.$_SESSION['regis_id'].'/'.$attach;
			if (!file_exists($create_photo)) {
			mkdir($create_photo, 0777);
			}
			$photo=uploadOwnerImage($photo_name,$photo_temp,$photo_type,$photo_size,$mobile,$attach);
		}
	}
	
	if(isset($_FILES['pan_copy']) && $_FILES['pan_copy']['name']!="")
	{
		/* pan picture */
		$pan_name=$_FILES['pan_copy']['name'];
		$pan_temp=$_FILES['pan_copy']['tmp_name'];
		$pan_type=$_FILES['pan_copy']['type'];
		$pan_size=$_FILES['pan_copy']['size'];
		$attach="pan_copy";
		if($pan_name!="")
		{
			$create_pan = 'images/employee_directory/'.$_SESSION['regis_id'].'/'.$attach;
			if (!file_exists($create_pan)) {
			mkdir($create_pan, 0777);
			}
			$pan_copy=uploadOwnerImage($pan_name,$pan_temp,$pan_type,$pan_size,$mobile,$attach);
		}
	}	
	
	if(isset($_FILES['partner']) && $_FILES['partner']['name']!="")
	{
		/* passport picture */
		$partner_name=$_FILES['partner']['name'];
		$partner_temp=$_FILES['partner']['tmp_name'];
		$partner_type=$_FILES['partner']['type'];
		$partner_size=$_FILES['partner']['size'];
		$attach="partner";
		if($partner_name!="")
		{
			$create_partner = 'images/employee_directory/'.$_SESSION['regis_id'].'/'.$attach;
			if (!file_exists($create_partner)) {
			mkdir($create_partner, 0777);
			}
			$partner=uploadOwnerImage($partner_name,$partner_temp,$partner_type,$partner_size,$mobile,$attach);
		}
	}

function checkMobile($mobile,$conn)
{
     $sql = "SELECT mobile FROM visitor_directory WHERE mobile='$mobile'";
    $result = $conn->query($sql);
    if($result->num_rows > 0)
    {
        return true;
    }
    return false;
}

function checkEmail($email,$conn)
{
     $sql = "SELECT email FROM visitor_directory WHERE email='$email'";
    $result = $conn->query($sql);
    if($result->num_rows > 0)
    {
        return true;
    }
    return false;
}

function checkPan($pan_no,$conn)
{
      $sql = "SELECT pan_no FROM visitor_directory WHERE pan_no='$pan_no'";
     $result = $conn->query($sql);
    if($result->num_rows > 0)
    {
        return true;
    }
    return false;
}

if(empty($name))
{ $signup_error = "Please Enter First Name";}
elseif(strlen($name)>14)
{ $signup_error="First Name must be at least 14 characters";}
elseif(empty($lname))
{ $signup_error = "Please Enter Last Name";}
elseif(strlen($lname)>14){
$signup_error="Last Name must be at least 14 characters";}
elseif(empty($email))
{ $signup_error = "Please Enter Email Id";}
elseif(!filter_var($email, FILTER_VALIDATE_EMAIL))
{ $signup_error = "Please Enter Valid Email";}
elseif(checkEmail($email,$conn))
{ $signup_error = "Email Id Already Exist";}
elseif(empty($mobile))
{ $signup_error = "Please Enter Mobile No";}
elseif(is_numeric($mobile) == false)
{ $signup_error = "Please Enter Valid Mobile No";}
elseif(strlen($mobile)>10 || strlen($mobile)<10)
{ $signup_error = "Mobile Number should be 10 digits.";}
elseif(checkMobile($mobile,$conn))
{ $signup_error = "Mobile No Already Exist";}
elseif(!preg_match("/^[6-9]\d{9}$/",$mobile))
{ $signup_error = "Please Enter Valid Mobile No"; }
elseif(empty($pan_no))
{ $signup_error = "Please Enter PAN No";}
elseif(checkPan($pan_no,$conn))
{ $signup_error = "PAN No Already Exist";}
elseif(!preg_match("/^([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}?$/",$pan_no))
{ $signup_error = "Please Enter Valid PAN No";}
elseif(empty($designation))
{ $signup_error = "Please Select Designation";}
elseif(empty($photo) || empty($pan_copy) || empty($partner))
{ $signup_error="Please Upload the required image";}
elseif(isset($_SESSION['regis_id']) && $_SESSION['regis_id']!="")
{
	 $sql1="insert into visitor_directory set registration_id='".$_SESSION['regis_id']."', shows='$shows', year='$year', gender='$gender', name='$name', lname='$lname', degn_type ='$degn_type', designation='$designation', mobile='$mobile', email='$email',pan_no='$pan_no',aadhar_no='$aadhar_no', photo='$photo', pan_copy='$pan_copy', partner='$partner', status='1', post_date=NOW(),isApplied='Y',paymentThrough='step3'";
	$resultx = $conn->query($sql1);
	if($resultx){	$signup_success = "You have been successfully created your Username and Password<br/>Please check your email for getting Username and Password.";?>
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-178505237-1"></script>
<!-- Event snippet for Virtual IIJS Sign-up-Step3 conversion page In your html page, add the snippet and call gtag_report_conversion when someone clicks on the chosen link or button. --> <script> function gtag_report_conversion(url) { var callback = function () { if (typeof(url) != 'undefined') { window.location = url; } }; gtag('event', 'conversion', { 'send_to': 'AW-679056788/yzWTCLL_luABEJSr5sMC', 'event_callback': callback }); return false; } 
gtag_report_conversion();</script>
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
  fbq('track', 'Step3');
</script>
<noscript><img height="1" width="1" style="display:none"
  src="https://www.facebook.com/tr?id=398834417477910&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->

<?php	unset($_SESSION['regis_id']); }
} else { header('location:domestic_user_registration_step1.php'); }
	} else {
	 $signup_error ="Invalid Token Error";
	}	
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Domestic User Registration Step - 3</title>
	<link rel="icon" href="https://gjepc.org/images/favicon.ico" type="image/x-icon"/>
	<link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Cabin'>
	<link rel="stylesheet" type="text/css" href="css/general.css?v=<?php echo $version;?>" />
	<link rel="stylesheet" type="text/css" href="css/inner_pg_style.css?v=<?php echo $version;?>" />	 
	<link rel="stylesheet" type="text/css" href="css/responsive.css?v=<?php echo $version;?>" />
    <link rel="stylesheet" type="text/css" href="css/media_query.css?v=<?php echo $version;?>" />
	<link rel="stylesheet" type="text/css" href="css/visitor_reg.css?v=<?php echo $version;?>" />
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
<!-- Event snippet for Virtual IIJS Sign-up-Step3 conversion page
In your html page, add the snippet and call gtag_report_conversion when someone clicks on the chosen link or button. -->
<script>
function gtag_report_conversion(url) {
  var callback = function () {
    if (typeof(url) != 'undefined') {
      window.location = url;
    }
  };
 gtag('event', 'conversion', {'send_to': 'AW-679056788/Y_RfCNrS-uABEJSr5sMC'});
  return false;
}

</script>
<script type="text/javascript">
	
     
      	fbq('track', 'Step2');
      	gtag_report_conversion();
   

</script>
<!-- Event snippet for Virtual IIJS Sign-up-Step2 conversion page -->

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
	$().ready(function() {
	//validate file extension custom  method.
    jQuery.validator.addMethod("extension", function (value, element, param) {
        param = typeof param === "string" ? param.replace(/,/g, '|') : "pdf|docx|doc|txt";
        return this.optional(element) || value.match(new RegExp(".(" + param + ")$", "i"));
        }, jQuery.format("Please enter a value with a valid extension."));
	
	jQuery.validator.addMethod("mobno", function (value, element) {
	var regExp = /^[6-9]\d{9}$/; 
	if (value.match(regExp) ) {
		return true;
	} else {
		return false;
	};
	},"Please Enter valid Mobile No");
	
	jQuery.validator.addMethod("panno", function (value, element) {
	var regExp = /[a-zA-z]{5}\d{4}[a-zA-Z]{1}/; 
	if (value.match(regExp) ) {
		return true;
	} else {
		return false;
	};
	},"Please Enter valid PAN No");
	
	$("#regisForm").validate({
		rules: {			
			name: {
				required: true,
				maxlength:14
			}, 
			lname: {
				required: true,
				maxlength:14
			}, 
			mobile: {
				required: true,
				number:true,
				minlength: 10,
				maxlength:10,
				mobno: true
			},
			gender: {
				required: true,
			},
			email: {
				required: true,
				email:true
			},
			pan_no:{
				required: true,
				panno: true,
				minlength: 10,
				maxlength:10
			},
			photo:{
				required: true,
                extension: "jpg,jpeg,png,pdf",
                filesize: 5,
			},
			pan_copy:{
				required: true,
                extension: "jpg,jpeg,png,pdf",
                filesize: 5,
			},			
			partner:{
				required: true,
                extension: "jpg,jpeg,png,pdf",
                filesize: 5,
			},
			designation:{
				required: true,
			},
		},
		messages: {			
			name: {
				required: "Please Enter First Name",
				maxlength:"Please Enter no more than 14 digit."
			}, 
			lname: {
				required: "Please Enter Last Name",
				maxlength:"Please Enter no more than 14 digit."
			},  
			mobile: {
				required:"Please Enter Mobile Number",
				number:"Please Enter Numbers only",
				minlength:"Please enter at least 10 digit.",
				maxlength:"Please enter no more than 0 digit."
			},
			gender: {
				required: "Please Select Gender",
			},
		    email: {
				required:"Please Enter valid email id",
			},
			pan_no: {
				required: "Please Enter PAN No",
				minlength:"Please Enter correct PAN NO",
				maxlength:"Please enter no more than {0} digit."
			},
			photo:{
				required: "Please Upload Photo",
				accept: "Only image type jpg/png/jpeg/pdf is allowed"
			},
			pan_copy:{
				required: "Please Upload Pan Card Copy",
				accept: "Only image type jpg/png/jpeg/pdf is allowed"
			},
			partner:{
				required: "Please Upload Valid Document",
			},
			designation:{
				required: "Please Choose Designation",
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
	

    
</head>

<body>
<noscript><img height="1" width="1" style="display:none"
	  src="https://www.facebook.com/tr?id=398834417477910&ev=PageView&noscript=1"
	/></noscript>
	
    <div class="wrapper">
       <div class="header">
          <?php include('header1.php'); ?>
      </div>
     <!--  <div class="new_banner">
       <img src="images/iijs-virtual-1.jpg">
    </div> -->
    <div class="clear"></div>

    <!--container starts-->
    <div class="container_wrap">
       <div class="container">

           <span class="headtxt">Domestic User Registration Step - 3</span>	
           <div id="loginForm">
        <div class="box-shadow">
            <div class="d-flex flex-row justify-center form-group m-10 form-tab">
				<label class="container_radio"><span class="check_text"></span>
				  <input type="radio"  disabled>
				  <span class="checkmark_radio"></span>
			    </label>
			    <label class="container_radio radio_center"><span class="check_text"></span>
				  <input type="radio"  disabled >
				  <span class="checkmark_radio"></span>
			    </label>
			    <label class="container_radio"><span class="check_text"></span>
				  <input type="radio"disabled checked="checked" >
				  <span class="checkmark_radio"></span>
			    </label>
			</div>
        
<div class="d-flex flex-column">
		<?php if(isset($signup_error)){ echo '<span style="color: red;" />'.$signup_error.'</span>';} ?>
        <?php if(isset($signup_success)){ echo '<span style="color: green;" />'.$signup_success.'</span>';} else { ?>
<div class="title">
<h4>Owners Information</h4>
<span id="chkregisuser" style="color:#FF0000; display:block;"></span><span id="chkpanuser"></span><span id="chkgstnuser"></span><span id="chkMobileuser"></span>
</div>
<div class="clear"></div>
<div class="borderBottom"></div>

<form class="" method="POST" enctype="multipart/form-data" name="regisForm" id="regisForm" autocomplete="off"> 
<input type="hidden" name="action" id="action" value="save" />
<?php token(); ?>

<div class=" d-flex flex-row form-setup">
	<div class="col-50 d-flex justify-around flex-wrap form-group">
    <div class="col-50 d-flex align-center">
    <label><span style="color: red;" />*</span>First Name :</label>
	</div>
	<div class="col-50">
    <input type="text" class="form-control" onKeyPress="return onlyAlphabets(event,this);" id="name" name="name" maxlength="14" value="<?php echo $name;?>" autocomplete="off"/> 
	</div>    
	</div>
	<div class="col-50 d-flex justify-around flex-wrap form-group">
    <div class="col-50 d-flex align-center">
    <label><span style="color: red;" />*</span>Last Name :</label>
    </div>
    <div class="col-50">
    <input type="text" class="form-control" onKeyPress="return onlyAlphabets(event,this);" id="lname" name="lname" maxlength="14" value="<?php echo $lname;?>" autocomplete="off"/>  
	</div>
    </div>
</div>

<div class=" d-flex flex-row form-setup">   
	<div class="col-50 d-flex justify-around flex-wrap form-group">
    <div class="col-50 d-flex align-center">
    <label><span style="color: red;" />*</span>Email : </label>
	</div>
	<div class="col-50">
    <input type="text" class="form-control" id="email" name="email" value="<?php echo $email;?>" autocomplete="off"/> </div>
	</div>
	<div class="col-50 d-flex justify-around flex-wrap form-group">
    <div class="col-50 d-flex align-center">
    <label><span style="color: red;" />*</span>Mobile : </label>
    </div>
    <div class="col-50">
    <input type="text" class="form-control" id="mobile" name="mobile" value="<?php echo $mobile;?>" maxlength="10" autocomplete="off"/>  </div>
    </div>
</div>
<div class="d-flex flex-row form-setup">  
	<div class="col-50 d-flex justify-around flex-wrap form-group">
		<div class="col-50 d-flex align-center">
		<label><span style="color: red;" />*</span>Gender : </label>
		</div>
		<div class="col-50">
		<select class="select-control" name="gender" id="gender">
		 <option value="">---Select Gender---</option>
            <option value="M" <?php if($gender == 'M'){ ?> selected="selected"<?php } ?>>Male</option>
            <option value="F" <?php if($gender == 'F'){ ?> selected="selected"<?php } ?>>Female</option>
            <option value="T" <?php if($gender == 'T'){ ?> selected="selected"<?php } ?>>Trans-Gender</option>
        </select>
       </div>
	</div>
    <div class="col-50 d-flex justify-around flex-wrap form-group">
	<div class="col-50 d-flex align-center">
		  <label>Aadhar No : </label>
	</div>
<div class="col-50">
	<input type="text" class="form-control" id="aadhar_no" name="aadhar_no" value="<?php echo $aadhar_no;?>" maxlength="12" autocomplete="off"/>
	</div>
	</div>
</div>

<div class="d-flex flex-row form-setup">    
    <div class="col-50 d-flex justify-around flex-wrap form-group">
		<div class="col-50 d-flex align-center">
		  <label> <span style="color: red;" />*</span>PAN No :</label>
		</div>
		<div class="col-50">
			<input type="text" class="form-control" id="pan_no" name="pan_no" value="<?php echo $pan_no;?>" maxlength="10" autocomplete="off"/>
		</div>
	</div>
	<div class="col-50 d-flex justify-around flex-wrap form-group">
		<div class="col-50 d-flex align-center">
		  <label><span style="color: red;" />*</span>Upload PAN Copy : </label>
		</div>
		<div class="col-50">
			<input type="file" class="form-control" id="pan_copy" name="pan_copy" autocomplete="off" accept=".jpg,.jpeg,.png,.pdf"/>
					 (Kindly upload Max 2MB. jpeg, png,pdf) 
		</div>
    </div>
</div>
<div class="d-flex flex-row form-setup">    
    <div class="col-50 d-flex justify-around flex-wrap form-group">
    <div class="col-50 d-flex align-center">
      <label><span style="color: red;" />*</span>GST annexture (Showing the Owner's Name): </label>
    </div>
    <div class="col-50 ">
	<input type="file" class="form-control" id="partner" name="partner" autocomplete="off" accept=".jpg,.jpeg,.png,.pdf"/>(Kindly upload Max 2MB. jpeg, png,pdf) 
    </div>
	</div>
	
	<div class="col-50 d-flex justify-around flex-wrap form-group">
    <div class="col-50 d-flex align-center">
      <label><span style="color: red;" />*</span>Photo (Passport size): </label>
    </div>
	<div class="col-50">
	<input type="file" class="form-control" id="photo"  name="photo" value="" autocomplete="off" accept=".jpg,.jpeg,.png,.pdf"/>
					 (Kindly upload Max 2MB. jpeg, png,pdf) 
	</div>
	</div>
</div>

<div class="d-flex flex-row form-setup">    
    <div class="col-50 d-flex justify-around flex-wrap form-group">
		<div class="col-50 d-flex align-center">
		  <label><span style="color: red;">*</span>Designation : </label>
		</div>
		<div class="col-50">
		<select class="select-control valid" name="designation" id="designation">
		<option value="">--- Select Designation ---</option>
           <?php
			$sqlx1= "SELECT * FROM `visitor_designation_master` where type='Owner'";
			$query1 = $conn->query($sqlx1);
			while($row1 = $query1->fetch_assoc()){?>
			<option value="<?php echo $row1['id'];?>"><?php echo strtoupper($row1['type_of_designation']);?></option>
			<?php }	?>
        </select>
       </div>
	</div>
	
	<div class="col-50 d-flex justify-around flex-wrap form-group"></div>
</div>

</div>
<div class="d-flex flex-row form-setup">
    <div class="col-50 d-flex  flex-wrap form-group">      
      <input type="submit"   name="submit" value="Submit" class="btn btn-reset">
	</div>
</div>
</form>
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

<script>
function goback()
{
	window.history.back();
}
</script>
<?php include('header_include.php');?>
<?php
//echo '<pre>'; print_r($_SESSION);
//$_SESSION['regis_id'] = '600908649';
$registration_id = $_SESSION['regis_id'];
if(empty($_SESSION['regis_id']))
{
$_SESSION['error'] = 0;
//header("location: domestic_user_registration_step1.php"); //redirecting to first page

}
	$sql_event = "SELECT * FROM `visitor_event_master` WHERE `status` ='1' AND `isParentShow`='1' ";
	 $result_event = $conn->query($sql_event);
	 $count_event = $result_event->num_rows;
	 if($count_event > 0){
	   $row_event = $result_event->fetch_assoc();
	   $shows = $row_event['shortcode'];
	   $year = $row_event['year'];
	   
	 }else{
	 	$shows = "iijs";
	 	$year = date("Y");
	 }
?>

<?php
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


	function checkMobile($mobile,$type,$id,$conn)
	{
        if($type =="insert"){
			$sql = "SELECT mobile FROM visitor_directory WHERE mobile='$mobile' ";
        }else{
			$sql = "SELECT mobile FROM visitor_directory WHERE mobile='$mobile' AND visitor_id !='$id'";
        }
	    
	    $result = $conn->query($sql);
	    if($result->num_rows > 0)
	    {
	        return true;
	    }
	    return false;
	}

	function checkEmail($email,$type,$id,$conn)
	{
		if($type =="insert"){
	    $sql = "SELECT email FROM visitor_directory WHERE email='$email'";
    	}else{
	    $sql = "SELECT email FROM visitor_directory WHERE email='$email' AND visitor_id !='$id' ";
    	} 
	    $result = $conn->query($sql);
	    if($result->num_rows > 0)
	    {
	        return true;
	    }
	    return false;
	}

	function checkPan($pan_no,$type,$id,$conn)
	{
		if($type =="insert"){
	    $sql = "SELECT pan_no FROM visitor_directory WHERE pan_no='$pan_no'";
	    }else{
	    $sql = "SELECT pan_no FROM visitor_directory WHERE pan_no='$pan_no'  AND visitor_id !='$id'";
	    }
	    $result = $conn->query($sql);
	    if($result->num_rows > 0)
	    {
	        return true;
	    }
	    return false;
	}

if($_REQUEST['action'] =="save")
{
	//validate Token
	if(isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {
		$create_dir = 'images/employee_directory/'.$_SESSION['regis_id'];
	if (!file_exists($create_dir)) {
	   mkdir($create_dir, 0777);
	}
	
  	//print_r($_FILES);exit;
	
	$degn_type = $_REQUEST['design_category'];
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
			$photo = $_SESSION['photo'] = uploadOwnerImage($photo_name,$photo_temp,$photo_type,$photo_size,$mobile,$attach);
		}
	}else{
		$photo  = $_SESSION['photo'];
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
			$pan_copy = $_SESSION['pan_copy'] = uploadOwnerImage($pan_name,$pan_temp,$pan_type,$pan_size,$mobile,$attach);
		}
	}else{
		$pan_copy  = $_SESSION['pan_copy'];
	}	
	if(isset($_FILES['salary']) && $_FILES['salary']['name']!="")
	{
		/* passport picture */
		$salary_name=$_FILES['salary']['name'];
		$salary_temp=$_FILES['salary']['tmp_name'];
		$salary_type=$_FILES['salary']['type'];
		$salary_size=$_FILES['salary']['size'];
		$attach="salary";
		if($salary_name!="")
		{
			$create_salary = 'images/employee_directory/'.$_SESSION['regis_id'].'/'.$attach;
			if (!file_exists($create_salary)) {
			mkdir($create_salary, 0777);
			}
			$salary = $_SESSION['salary'] = uploadOwnerImage($salary_name,$salary_temp,$salary_type,$salary_size,$mobile,$attach);
		}
	}else{
		$salary  = $_SESSION['salary'];
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
			$partner =  $_SESSION['partner'] = uploadOwnerImage($partner_name,$partner_temp,$partner_type,$partner_size,$mobile,$attach);
		}
	}else{
		$partner  = $_SESSION['partner'];
	}


	if($degn_type == "Owner")
	{ $emp_val = $partner;} else { $emp_val = $salary; }
	if(empty($degn_type))
	{$signup_error="Please Choose Designation";}
	elseif(empty($name))
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
	elseif(checkEmail($email,"insert","",$conn))
	{ $signup_error = "Email Id Already Exist";}
	elseif(empty($mobile))
	{ $signup_error = "Please Enter Mobile No";}
	elseif(is_numeric($mobile) == false)
	{ $signup_error = "Please Enter Valid Mobile No";}
	elseif(strlen($mobile)>10 || strlen($mobile)<10)
	{ $signup_error = "Mobile Number should be 10 digits.";}
	elseif(checkMobile($mobile,"insert","",$conn))
	{ $signup_error = "Mobile No Already Exist";}
	elseif(!preg_match("/^[6-9]\d{9}$/",$mobile))
	{ $signup_error = "Please Enter Valid Mobile No"; }
	elseif(empty($pan_no))
	{ $signup_error = "Please Enter PAN No";}
	elseif(checkPan($pan_no,"insert","",$conn))
	{ $signup_error = "PAN No Already Exist";}
	elseif(!preg_match("/^([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}?$/",$pan_no))
	{ $signup_error = "Please Enter Valid PAN No";}
	elseif(empty($designation))
	{ $signup_error = "Please Select Designation";}
	elseif(empty($photo) || empty($pan_copy) )
	{ $signup_error="Please Upload the required image";}
	elseif(isset($_SESSION['regis_id']) && $_SESSION['regis_id']!="")
	{
		$sql1="insert into visitor_directory set registration_id='".$_SESSION['regis_id']."', shows='$shows', year='$year', gender='$gender', name='$name', lname='$lname', degn_type ='$degn_type', designation='$designation', mobile='$mobile', email='$email',pan_no='$pan_no',aadhar_no='$aadhar_no', photo='$photo', pan_copy='$pan_copy',salary_slip_copy='$salary', partner='$partner', status='1', post_date=NOW(),isApplied='Y',paymentThrough='step3'";
		$resultx = $conn->query($sql1);
		if($resultx){ 
	         unset($_SESSION['photo']);
	         unset($_SESSION['pan_copy']);
	         unset($_SESSION['salary']);
	         unset($_SESSION['partner']);

			$signup_success = "Person details has been successfully added";
			header("Refresh:5; url=domestic_user_registration_step3.php");
        }
	}else{
	 	header('location:domestic_user_registration_step1.php');
	}
	} else {
	    //$signup_error ="Invalid Token Error";
	}	
}


if($_REQUEST['action'] == "update")
{
	//validate Token
	if(isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {
		$create_dir = 'images/employee_directory/'.$_SESSION['regis_id'];
	if (!file_exists($create_dir)) {
	   mkdir($create_dir, 0777);
	}
	
  	//print_r($_FILES);exit;
	
	$visitor_id = $_REQUEST['visitor_id'];
	$degn_type = $_REQUEST['design_category'];
	$designation = $_REQUEST['designation'];
	$name = filter(strtoupper($_REQUEST['name']));
	$lname = filter(strtoupper($_REQUEST['lname']));
	$email = filter(strtoupper($_REQUEST['email']));
	$mobile = filter($_REQUEST['mobile']);
	$gender = $conn->real_escape_string($_REQUEST['gender']);		
	$pan_no = filter(strtoupper($_REQUEST['pan_no']));
	$aadhar_no = filter(strtoupper($_REQUEST['aadhar_no']));
	
	$visitor_result = $conn->query("SELECT * FROM visitor_directory WHERE visitor_id ='$visitor_id'");
	$visitor_row = $visitor_result->fetch_assoc();

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
			$photo = $_SESSION['photo'] = uploadOwnerImage($photo_name,$photo_temp,$photo_type,$photo_size,$mobile,$attach);
		}
	}else{
		$photo  = $visitor_row['photo'];
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
			$pan_copy = $_SESSION['pan_copy'] = uploadOwnerImage($pan_name,$pan_temp,$pan_type,$pan_size,$mobile,$attach);
		}
	}else{
		$pan_copy  = $visitor_row['pan_copy'];
	}	
	if(isset($_FILES['salary']) && $_FILES['salary']['name']!="")
	{
		/* passport picture */
		$salary_name=$_FILES['salary']['name'];
		$salary_temp=$_FILES['salary']['tmp_name'];
		$salary_type=$_FILES['salary']['type'];
		$salary_size=$_FILES['salary']['size'];
		$attach="salary";
		if($salary_name!="")
		{
			$create_salary = 'images/employee_directory/'.$_SESSION['regis_id'].'/'.$attach;
			if (!file_exists($create_salary)) {
			mkdir($create_salary, 0777);
			}
			$salary = $_SESSION['salary'] = uploadOwnerImage($salary_name,$salary_temp,$salary_type,$salary_size,$mobile,$attach);
		}
	}else{
		$salary  = $visitor_row['salary_slip_copy'];
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
			$partner =  $_SESSION['partner'] = uploadOwnerImage($partner_name,$partner_temp,$partner_type,$partner_size,$mobile,$attach);
		}
	}else{
		$partner  = $visitor_row['partner'];
	}


	if($degn_type == "Owner")
	{ $emp_val = $partner;} else { $emp_val = $salary; }
	if(empty($degn_type))
	{$signup_error="Please Choose Designation";}
	elseif(empty($name))
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
	elseif(checkEmail($email,"update",$visitor_id,$conn))
	{ $signup_error = "Email Id Already Exist";}
	elseif(empty($mobile))
	{ $signup_error = "Please Enter Mobile No";}
	elseif(is_numeric($mobile) == false)
	{ $signup_error = "Please Enter Valid Mobile No";}
	elseif(strlen($mobile)>10 || strlen($mobile)<10)
	{ $signup_error = "Mobile Number should be 10 digits.";}
	elseif(checkMobile($mobile,"update",$visitor_id,$conn))
	{ $signup_error = "Mobile No Already Exist";}
	elseif(!preg_match("/^[6-9]\d{9}$/",$mobile))
	{ $signup_error = "Please Enter Valid Mobile No"; }
	elseif(empty($pan_no))
	{ $signup_error = "Please Enter PAN No";}
	elseif(checkPan($pan_no,"update",$visitor_id,$conn))
	{ $signup_error = "PAN No Already Exist";}
	elseif(!preg_match("/^([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}?$/",$pan_no))
	{ $signup_error = "Please Enter Valid PAN No";}
	elseif(empty($designation))
	{ $signup_error = "Please Select Designation";}
	elseif(empty($photo) || empty($pan_copy) )
	{ $signup_error="Please Upload the required image";}
	elseif(isset($_SESSION['regis_id']) && $_SESSION['regis_id']!="" && $visitor_id !=="")
	{
		$sql1="UPDATE visitor_directory SET  shows='$shows', year='$year', gender='$gender', name='$name', lname='$lname', degn_type ='$degn_type', designation='$designation', mobile='$mobile', email='$email',pan_no='$pan_no',aadhar_no='$aadhar_no', photo='$photo', pan_copy='$pan_copy', partner='$partner',salary_slip_copy='$salary', status='1',visitor_approval='U', mod_date=NOW(),paymentThrough='step3' WHERE visitor_id='$visitor_id' ";
		$resultx = $conn->query($sql1);
		if($resultx){ 
	         unset($_SESSION['photo']);
	         unset($_SESSION['pan_copy']);
	         unset($_SESSION['salary']);
	         unset($_SESSION['partner']);

			$signup_success = 	"Person details has been updated successfully! ";
			//header('location:domestic_user_registration_step3.php');
			header("Refresh:5; url=domestic_user_registration_step3.php");
        }
	}else{
	 	header('location:domestic_user_registration_step1.php');
	}
	} else {
	    //$signup_error ="Invalid Token Error";
	}	
}


                    
if($_REQUEST['action'] =="edit" && $_REQUEST['id'] !==""){
    $action = "update";
    $sql_person = "SELECT * FROM visitor_directory WHERE visitor_id='{$_REQUEST['id']}'";
    $result_person = $conn->query($sql_person);
    $count_person = $result_person->num_rows;
    if($count_person > 0 ){
	      $row_person = $result_person->fetch_assoc();
	      $degn_type = $row_person['degn_type'];
	      $designation = $row_person['designation'];
	      $name = $row_person['name'];
	      $lname = $row_person['lname'];
	      $email = $row_person['email'];
	      $mobile = $row_person['mobile'];
	      $gender = $row_person['gender'];
	      $aadhar_no = $row_person['aadhar_no'];
	      $pan_no = $row_person['pan_no'];
	      $photo = $row_person['photo'];
	      $pan_copy = $row_person['pan_copy'];
	      $partner = $row_person['partner'];
	      $salary = $row_person['salary_slip_copy'];
    }else{
     	header('location:domestic_user_registration_step3.php');
    }
}else{
    $action = "save";
}
                    
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Domestic User Registration Step - 3</title>
	<link rel="icon" href="https://gjepc.org/assets/images/fav_icon.png" type="image/x-icon"/>
	<link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Cabin'>
	<link rel="stylesheet" type="text/css" href="https://gjepc.org/assets-new/css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="css/general.css?v=<?php echo $version;?>" />
	<link rel="stylesheet" type="text/css" href="css/inner_pg_style.css?v=<?php echo $version;?>" />	 
	<link rel="stylesheet" type="text/css" href="css/responsive.css?v=<?php echo $version;?>" />
    <link rel="stylesheet" type="text/css" href="css/media_query.css?v=<?php echo $version;?>" />
	<link rel="stylesheet" type="text/css" href="css/visitor_reg.css?v=<?php echo $version;?>" />
	<script type="text/javascript" src="https://gjepc.org/assets-new/js/jquery.min.js"></script>
	<script type="text/javascript" src="https://gjepc.org/assets-new/js/bootstrap.min.js"></script>


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
	
     
      //	fbq('track', 'Step2');
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
   function readURL(input,divid) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();            
            reader.onload = function (e) {
                $("#"+divid).attr('src', e.target.result);
                $("#"+divid).show();
            }            
            reader.readAsDataURL(input.files[0]);
        }
    }

$(document).ready(function() {
	$(".openDetails").on("click",function(e){
	    e.preventDefault();
        let visitor_id = $(this).data("id");
	    $.ajax({
	      type : 'POST',
	      data : {visitor_id:visitor_id,actiontype:"getCompanyPersonDetails"},
	      url : 'ajax.php',
	      dataType: "json",
	      success:function(result){
	        if(result.status == "success"){
	           $("#person_details_body").html(result.output);
	           $('#detailModal').modal('show');
	        }
	      }
	    });
	});
	
	$(".removePerson").on("click",function(e){
	    e.preventDefault();
	    if (confirm("Click OK to continue?")){
        let visitor_id = $(this).data("id");
        let ref = $(this);
	    $.ajax({
	      type : 'POST',
	      data : {visitor_id:visitor_id,actiontype:"removeCompanyPerson"},
	      url : 'ajax.php',
	      dataType: "json",
	      success:function(result){
	        if(result.status == "success"){
	           	ref.parent("td").parent("tr").fadeOut("slow");
	        } else {	      	
	      		alert(result.message);
	      	}
	      }
	    });
		} else {
			return false;
		}
	});
	
    		
	$(".imgsel").change(function(){
        var imgdiv = $(this).attr('data-imgsrc');
      //  alert(imgdiv);
        readURL(this,imgdiv);
    });
	var pan = $('#pn').val();
	var sal = $('#s').val();
	var par = $('#p').val();
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
	//	$('#name').val("");
	//	$('#lname').val("");
		return false;
		
	};
	},"Please Enter valid PAN No");
	
	$("#regisForm").validate({
		rules: {
			design_category:{
				required: true,
			},			
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
				required: function(element){
						if($('#ph').val()==0){
						  return true;
						} else {
						  return false;
						}
					},
			},
			pan_copy:{
				required: function(element){
						if($('#pn').val()==0){
						  return true;
						} else {
						  return false;
						}
					},
			},
			salary:{
				required: function(element){
						if($('#s').val()==0){
						  return true;
						} else {
						  return false;
						}
					},
			},
			partner:{
				required: function(element){
						if($('#s').val()==0){
						  return true;
						} else {
						  return false;
						}
					},
			},
			designation:{
				required: true,
			},
		},
		messages: {			
			design_category: {
				required: "Select Owner or employee category",
				
			}, 
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
				accept: "Only image type jpg/png/jpeg is allowed"
			},
			pan_copy:{
				required: "Please Upload Pan Card Copy",
				accept: "Only image type jpg/png/jpeg is allowed"
			},
			salary:{
				required: "Please Upload Salary Copy or statement",
			},
			partner:{
				required: "Please Upload Valid Document",
			},
			designation:{
				required: "Please Choose Designation",
			},
	 }
	});

	<?php if(!empty($degn_type)){ ?>
	getDesignation("<?php echo $degn_type; ?>","<?php echo $designation; ?>");
    <?php } ?>
	$('input[name="design_category"]').click(function(){
        var designation = $('[name="design_category"]:checked').val();
        getDesignation(designation,"");
        });
	});

	$(document).ready(function(){
	  $("#panVerifyIcon").hide();
	  $("#pan_no").change(function(){
		  	$("#panVerifyIcon").hide();
			var company_pan_no=$("#pan_no").val();
		 	var regExp = /[a-zA-z]{5}\d{4}[a-zA-Z]{1}/; 
			if (company_pan_no.match(regExp) ) {

			$.ajax({		
				type: 'POST',
				url: 'ajax.php',
				data: "actiontype=checkPanApi&company_pan_no="+company_pan_no,
				dataType:'json',
				beforeSend: function(){
							$('#preloader').show();
							$('#status').show();
						},
				success: function(data){
						  		$('#preloader').hide();
								$('#status').hide();
							  	if(data.success == true){
								   if(data.response_code=="100"){
								   	$("#panVerifyIcon").show();
									$('#submit').attr("disabled", false);
									$("#chkpanuser").html("");
									
									/*$('#pan_type').val(data.result.pan_type); 
									if(data.result.pan_type =="Person"){
									$('#name').val(data.result.user_first_name);
									$('#lname').val(data.result.user_last_name);
									} else {
									$('#name').val("");
									$('#lname').val("");	
									} */
									
								   } else {
								   	$("#panVerifyIcon").hide();
								   	$('#submit').attr("disabled", true);
									$("#chkpanuser").html("Please enter valid pan number").css("color", "red"); 
								//	$('#name').val("");
								//	$('#lname').val("");
								   }
								} else {
									$("#panVerifyIcon").hide();
									$('#submit').attr("disabled", true);
									$("#chkpanuser").html("Please enter valid pan number").css("color", "red"); 
								//	$('#name').val("");
								//	$('#lname').val("");
								}
						  	}
			});
	        
			}else{
				$("#chkpanuser").html("Please enter valid pan number").css("color", "red"); 
				return false;
			}
	 });
	});
    function getDesignation(designation,selected){
		$.ajax({
            type: 'POST',
            url: 'ajax.php',
            data: "actiontype=checkDesignationWithCompanyRegistration&designation="+designation+"&selected="+selected,
            dataType:'html',
            beforeSend: function(){
            $('#preloader').show();
			$('#status').show();
            },
            success: function(data)
            {              
			//alert(data);
			$('#preloader').hide();
			$('#status').hide();
            $("#designation").html(data);
            }
        });
    }

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
	<script type="text/javascript">
<?php if($degn_type == 'Owner') { ?>
	$('#salary').attr('name', 'partner');
	$('#emp_text').html('<sup>*</sup>GST certificate/ Partnership deed/ Memorandum of Article of Association stating your name ');
	<?php } else { ?>
	$('#salary').attr('name', 'salary');
	$('#emp_text').html('<sup>*</sup>Salary Slip / Bank Statment/ Recommendation Letter CA Certification');
	<?php } ?>
    $(document).ready(function(){
      $('#Owner').click(function(){
		$('#Owner_degn').show();
        //$('#parner_ship').show();
        //$('#salary_slip').hide();
		$('#salary').attr('name', 'partner');
		$('#emp_text').html('<sup>*</sup>GST certificate/ Partnership deed/ Memorandum of Article of Association stating your name ');
      });
    });

    $(document).ready(function(){
      $('#Employee').click(function(){
		//$('#Emp_degn').show();
        //$('#salary_slip').show();
        //$('#parner_ship').hide();
		$('#salary').attr('name', 'salary');
		$('#emp_text').html('<sup>*</sup>Salary Slip / Bank Statment/ Recommendation Letter CA Certification');
      });
    });
</script>
<script>
    photoValidation = () => {
        const fi = document.getElementById('photo');
        // Check if any file is selected.
        if (fi.files.length > 0) {
            for (const i = 0; i <= fi.files.length - 1; i++) {
  
                const fsize = fi.files.item(i).size;
                const file = Math.round((fsize / 1024));
                // The size of the file.
                if (file >= 5120) {
                    //alert("File too Big, please select a file less than 2MB");
					$("#photoSizeError").text("Please select a file less than 5MB"); 
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
        const fi = document.getElementById('pan_copy');
        // Check if any file is selected.
        if (fi.files.length > 0) {
            for (const i = 0; i <= fi.files.length - 1; i++) {
  
                const fsize = fi.files.item(i).size;
                const file = Math.round((fsize / 1024));
                // The size of the file.
                if (file >= 5120) {
                    //alert("File too Big, please select a file less than 2MB");
					$("#panSizeError").text("Please select a file less than 5MB"); 
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
<style type="text/css">
	.inputWrapper{
		position: relative;
	}
	.inputMaskIcon{
		position: absolute;
		top: 5px;
		right: 10px;
	}
	.inputMaskIcon i{font-size: 24px;}
</style>
    
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
           <h2 class="title2">Domestic User Registration Step - 3</h2>
           
           <div id="loginForm">
        		
        		<div class="box-shadow">

		            <!-- <div class="d-flex flex-row justify-center form-group m-10 form-tab">
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
					</div> -->
        

			      	<ul class="d-flex justify-content-center step_list pb-4 mb-4">
						<li class="col-4">
							<div class="step_icon"><i class="fa fa-pencil" aria-hidden="true"></i></div>
							Account Information
						</li>
						<li class="col-4">
							<div class="step_icon"><i class="fa fa-map-marker" aria-hidden="true"></i></div>
							Address Information
						</li>
						<li class="col-4 active">
							<div class="step_icon"><i class="fa fa-user" aria-hidden="true"></i></div>
							Owners Information
						</li>
					</ul>
					
					<div class="title">
						<!-- <h4>Owners Information</h4> -->
						<span id="chkregisuser" style="color:#FF0000; display:block;"></span>
						<span id="chkpanuser"></span>
						<span id="chkgstnuser"></span>
						<span id="chkMobileuser"></span>
					</div>
					
					<!-- <div class="clear"></div>
					<div class="borderBottom"></div> -->
             		<?php if(isset($signup_error)){ echo '<div class="alert alert-danger" role="alert">'.$signup_error.'</div>';} ?>
			        <?php if(isset($signup_success)){ echo '<div class="alert alert-success" role="alert">'.$signup_success.'</div>';} ?>
					<form class="" method="POST" enctype="multipart/form-data" name="regisForm" id="regisForm" autocomplete="off"> 
						<input type="hidden" name="action" id="action" value="<?php echo $action; ?>" />
						<input type="hidden" name="visitor_id"  value="<?php echo $_REQUEST['id']; ?>"  />

						<?php token(); ?>

						<div class="row">
							 <div class="col-sm-12  form-group">						

								<div class="form-group p-0 px-3 pt-3" id="radio" style="font-size: 14px;">
			               		<input type="radio" class="mr-1"  name="design_category" <?php echo ($degn_type =="Owner" ? "checked":"");?> value="Owner"  id="Owner"> <label for="Owner">Owner</label> &nbsp;
			              		<input type="radio" class="mr-1" name="design_category" <?php echo ($degn_type =="Employee" ? "checked":"");?> value="Employee" id="Employee" ><label for="Employee">Employee</label>  
			            		</div>
			            		<label for="design_category" generated="true" class="error d-none"></label>
		            	    </div>
                            <div class="col-sm-6 col-md-4 form-group" id="design_div">
								<label><span style="color: red;">*</span>Designation :  </label>
							  	<select class="valid form-control" name="designation" id="designation">
									<option value="">--- Select Designation ---</option>
						          
					        	</select>
							</div>
						    <div class="col-sm-6 col-md-4 form-group">
							    <label><span style="color: red;" />*</span>First Name :</label>
							    <input type="text" class="form-control" onKeyPress="return onlyAlphabets(event,this);" id="name" name="name" maxlength="14" value="<?php echo $name;?>" autocomplete="off"/> 
							</div>
							   
							<div class="col-sm-6 col-md-4 form-group">
							    <label><span style="color: red;" />*</span>Last Name :</label>
							    <input type="text" class="form-control" onKeyPress="return onlyAlphabets(event,this);" id="lname" name="lname" maxlength="14" value="<?php echo $lname;?>" autocomplete="off"/>  
							</div>

							<div class="col-sm-6 col-md-4 form-group">   
							    <label><span style="color: red;" />*</span>Email : </label>
							    <input type="text" class="form-control" id="email" name="email" value="<?php echo $email;?>" autocomplete="off"/>
							</div>
								
							<div class="col-sm-6 col-md-4 form-group">  
							    <label><span style="color: red;" />*</span>Mobile : </label>
							    <input type="text" class="form-control" id="mobile" name="mobile" value="<?php echo $mobile;?>" maxlength="10" autocomplete="off"/>
							</div>

							<div class="col-sm-6 col-md-4 form-group">
								<label><span style="color: red;" />*</span>Gender : </label>
								<select class="form-control" name="gender" id="gender">
								 	<option value="">---Select Gender---</option>
						            <option value="M" <?php if($gender == 'M'){ ?> selected="selected"<?php } ?>>Male</option>
						            <option value="F" <?php if($gender == 'F'){ ?> selected="selected"<?php } ?>>Female</option>
						            <option value="T" <?php if($gender == 'T'){ ?> selected="selected"<?php } ?>>Trans-Gender</option>
						        </select>
					       	</div>

							<div class="col-sm-6 col-md-4 form-group">
								<label>Aadhar No : </label>
							  	<input type="text" class="form-control" id="aadhar_no" name="aadhar_no" value="<?php echo $aadhar_no;?>" maxlength="12" autocomplete="off"/>
							</div>

							<div class="col-sm-6 col-md-4 form-group">
								<label> <span style="color: red;" />*</span>PAN No :</label>
							  	

							  	<div class="inputWrapper">
									<input type="text" class="form-control" id="pan_no" name="pan_no" value="<?php echo $pan_no;?>" maxlength="10" autocomplete="off" data-imgsrc="blah"/>
									<span id="panVerifyIcon" class="inputMaskIcon"><i class="text-success fa fa-check"></i></span>
								</div>

							</div>
							<div class="col-sm-6 col-md-4">
								
							</div>
							<div class="col-sm-6 col-md-4 form-group">
					      		<label><span style="color: red;" />*</span>Photo (Passport size): </label>
					      		<input id="photo"  name="photo" type="file"  class="imgsel form-control" value="<?php echo $photo; ?>" data-imgsrc="blah1" /> <p class="fail" id="photoSizeError"></p> 
								<input type="hidden" id="ph" name="ph" class="textField imgsel form-control" data-imgsrc="blah1" value="<?php if(empty($photo)){ echo 0;} else { echo 1;} ?>"/>
								<?php if(!empty($photo)){?>
								<img class="blah" id="blah1" style="display: block"  src="images/employee_directory/<?php echo $_SESSION['regis_id']; ?>/photo/<?php echo $photo; ?>" alt="your image"/> 
								<?php } else { ?>
								<img class="blah" id="blah1"  src="images/upload_img.jpg" alt="your image" />
								<?php } ?> <p class="d-block">(Kindly upload Max 2MB. jpg ,jpeg, png)</p> 
					    	</div>
							<div class="col-sm-6 col-md-4 form-group">
								<label><span style="color: red;" />*</span>Upload PAN Copy : </label>
								<input id="pan_copy" name="pan_copy"  type="file"  class="imgsel form-control"  data-imgsrc="blah2" value="<?php echo $pan_copy;?>" /> <p class="fail" id="panSizeError"></p>
								<input type="hidden" id="pn" name="pn" class="textField imgsel form-control" data-imgsrc="blah2" value="<?php if(empty($pan_copy)){ echo 0;} else { echo 1;} ?>"/>
								<?php if(!empty($pan_copy)){?>
								<img class="blah" id="blah2" style="display: block" src="images/employee_directory/<?php echo $_SESSION['regis_id']; ?>/pan_copy/<?php echo $pan_copy; ?>" alt="your image"/> 
								<?php } else { ?>
								<img class="blah" id="blah2"  src="images/upload_img.jpg" alt="your image" />  
								<?php } ?>
								<p class="d-block">(Kindly upload Max 2MB. jpg ,jpeg, png)</p> 
							</div>

					    	<!-- <div class="col-sm-6 col-md-4 form-group">
					      		<label><span style="color: red;" />*</span>GST annexture (Showing the Owner's Name): </label>
					      		<input type="file" class="form-control" id="partner" name="partner" autocomplete="off" accept=".jpg,.jpeg,.png,.pdf"/>(Kindly upload Max 2MB. jpeg, png,pdf)
					    	</div> -->
					   
							
					    	<div class="col-sm-6 col-md-4 form-group" id="salary_slip">
								<?php if($degn_type == 'Owner') 
								{ 
								$emp_files = $partner; 
								$folder = "partner";
								$blah = "blah4";
								} 
								else 
								{ 
								$emp_files = $salary; 
								$folder = "salary";
								$blah = "blah3";
								}
								?>
								<label><label  id="emp_text" style="display:inline;"> Salary Slip / Bank Statment</label>: (Max 2MB.jpg, .png)</label>
								<input id="salary" name="salary" type="file"  class="imgsel form-control" data-imgsrc="<?php echo $blah; ?>" value="<?php echo $emp_files; ?>"/>
								<input type="hidden" id="s" name="s" class="textField textField2 imgsel" data-imgsrc="<?php echo $blah; ?>" value="<?php if(empty($emp_files)){ echo 0;} else { echo 1;} ?>"/>
								<?php if(!empty($emp_files)){?>
								<img class="blah" id="<?php echo $blah; ?>" style="display: block" src="images/employee_directory/<?php echo $_SESSION['regis_id']; ?>/<?php echo $folder?>/<?php echo $emp_files; ?>" alt="your image"/> 
								<?php } else { ?>
								<img class="blah" id="<?php echo $blah; ?>" src="images/upload_img.jpg" alt="your image" /> 
								<?php } ?>
								<p class="d-block">(Kindly upload Max 2MB. jpg ,jpeg, png)</p> 
							</div>
						
							

							<div class="col-12 form-group">    
							    <input type="submit"   name="submit" value="Submit" class="btn btn-submit">
							</div>
						</div>
					</form>
				 <hr>
			

          <div class="clear"></div>
          <!-- <div class="borderBottom"></div> -->
          
            <?php
			$query_owner =  $conn->query("select * from visitor_directory where degn_type = 'Owner' and registration_id='$registration_id' and status='1'");
			$owner_count = $query_owner ->num_rows;
			?>

      		<?php if($owner_count> 0){ ?>
      	  <div class="title margin_t">
            <h6>Owner Details</h6>
   
          </div>
             <table class="responsive_table">
            <thead>
              <tr>
                <th scope="col">Name</th>
                <th scope="col">Designation</th>
                <th scope="col">Mobile Number</th>
                <th scope="col">Photo</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
			<?php 
			while($owner = $query_owner->fetch_assoc())
			{
			$visitor_id = $owner['visitor_id'];
			$visitor_approval = $owner['visitor_approval'];
			$disapproval = $owner['disapprove_reason'];
			$combo = $owner['combo'];
			$owner_photo_ext =  pathinfo($owner['photo'], PATHINFO_EXTENSION);
			
			$sqlBadgeOwn =  "select * from visitor_order_history where visitor_id='$visitor_id' AND payment_status='Y' AND (payment_made_for='3show' || payment_made_for='6show' || payment_made_for='2show' || payment_made_for='5show') AND registration_id='$registration_id'";
			$resultBadgeOwn =  $conn->query($sqlBadgeOwn);
			$ownBadgeCount = $resultBadgeOwn->num_rows; 
			?>
              <tr>
                <td data-column="Name"><?php echo strtoupper($owner['name']); ?></td>
                <td data-column="Designation"><?php echo getVisitorDesignationID($owner['designation'],$conn); ?></td>
                <td data-column="Mobile"><?php echo $owner['mobile']; ?></td>
				<td data-column="Photo"><?php if($owner_photo_ext =="pdf" || $owner_photo_ext =="PDF"){?><a href="images/employee_directory/<?php echo $registration_id;?>/photo/<?php echo $owner['photo'];?>" target="_blank"><img src="images/pdf_icon.png"></a><?php }else{?> <img src="images/employee_directory/<?php echo $registration_id;?>/photo/<?php echo $owner['photo'];?>" class="emp_img img-fluid" style="max-width: 100px;height: auto;"><?php } ?></td>
                <td data-column="Status">
				<?php 
				if($visitor_approval=="Y"){
				echo "Approved"; 
				if($combo=="2show") { echo "<br> <b><hr>Already registered for 2 Shows <hr>(IIJS Signature 2020+IIJS Premiere 2020) +IGJME 2020</b>"; }
				if($combo=="3show") { echo "<br> <b><hr>Already registered for 3 Shows <hr>(IIJS 2019+ Signature 2020+ IIJS 2020)</b>"; } 
				if($combo=="5show") { echo "<br> <b><hr>Already registered for 5 Shows <hr>(Only for owner category)
(IIJS Signature 2020+IIJS 2020+IIJS Signature 2021+ IIJS 2021+ IIJS Signature 2022) +IGJME 2020</b>"; } 
				if($combo=="6show") { echo "<br> <b><hr>Already registered for 6 Shows <hr>(IIJS 2019+Signature 2020+IIJS 2020+ Signature 2021+ IIJS 2021+ Signature 2022)</b>"; } 
				} elseif($visitor_approval=="D"){ echo "Disapproved"."<br> <hr>".$disapproval;} elseif($visitor_approval=="U"){ echo "Updated";} else {echo "Pending";}?></td>
                <td scope="col" data-column="Action">
                <?php if($visitor_approval == "Y") { 
                	$encrypted_id =base64_encode($owner['visitor_id']); 
                	?>
                <img src="images/done.png" title="Approved" border="0" /> / <img src="images/eye.png" data-id="<?php echo $encrypted_id;?>" class="openDetails"   title="View Details" border="0" class="pointer" />
                <?php } else { ?>                
                <a href="domestic_user_registration_step3.php?action=edit&id=<?php echo $owner['visitor_id'];?>"><img src="images/edit.png" title="Edit" border="0" /></a> /
                <a  href="javascript:void(0)"  data-id="<?php echo $owner['visitor_id']; ?>" class="removePerson"> 
                <img src="images/delete.png" title="Delete" border="0" /></a>
                <?php } ?>
				<!-- <?php /*if($ownBadgeCount>0){ ?>
                  <a href="lost_visitor_badge.php?visitor_id=<?php echo $encrypted_id ;?>"><img src="images/id-card.png" title="Apply for Lost Badge" border="0" /></a>
                 <?php } */?> -->
                </td>
              </tr>
            <?php } ?>
            </tbody>
          </table>
      <?php } ?>
			
          <?php 
		  $query_emp =  $conn->query("select * from visitor_directory where degn_type = 'Employee' and registration_id='$registration_id' and status='1'");
		  $employee_count = $query_emp ->num_rows;
		  ?>

      		<?php if($employee_count> 0){ ?>
      	  <div class="title margin_t">
            <h6>Employee Details</h6>
   
          </div>
             <table class="responsive_table">
            <thead>
              <tr>
                <th scope="col">Name</th>
                <th scope="col">Designation</th>
                <th scope="col">Mobile Number</th>
                <th scope="col">Photo</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
			<?php 
		  while($emp = $query_emp->fetch_assoc())
		  {
		  $visitor_id = $emp["visitor_id"];
		  $status = $emp['status'];
		  $visitor_approval = $emp['visitor_approval'];
		  $combo = filter($emp['combo']);
		  $disapproval = filter($emp['disapprove_reason']);
		  $employee_photo_ext =  pathinfo($emp['photo'], PATHINFO_EXTENSION);
		  $sqlBadgeEmp =  "select * from visitor_order_history where visitor_id='$visitor_id' and payment_status='Y' and (payment_made_for='3show' || payment_made_for='2show' || payment_made_for='5show') AND registration_id='$registration_id'";
		  $resultBadgeEmp =  $conn->query($sqlBadgeEmp);
		  $empBadgeCount = $resultBadgeEmp->num_rows;
		  ?>
              <tr>
                <td data-column="Name"><?php echo strtoupper($emp['name']); ?></td>  
                <td data-column="Designation"><?php echo getVisitorDesignationID($emp['designation'],$conn); ?></td>
                <td data-column="Mobile"><?php echo $emp['mobile']; ?></td>
				<td data-column="Photo"><?php if($employee_photo_ext =="pdf" || $employee_photo_ext =="PDF"){?><a href="images/employee_directory/<?php echo $registration_id;?>/photo/<?php echo $emp['photo'];?>" target="_blank"> <img src="images/pdf_icon.png"></a><?php }else{?>
				<img src="images/employee_directory/<?php echo $registration_id;?>/photo/<?php echo $emp['photo'];?>" class="emp_img img-fluid" style="max-width: 100px;height: auto;">
				 <?php } ?></td>
				<td data-column="Status">
				<?php 
				if($visitor_approval=="Y"){
				echo "Approved";
				if($combo=="2show") { echo "<br> <b><hr>Already registered for 2 Shows <hr>(IIJS Signature 2020+IIJS Premiere 2020) +IGJME 2020</b>"; }
				if($combo=="3show") { echo "<br> <b><hr>Already registered for 3 Shows <hr>(IIJS 2019+ Signature 2020+ IIJS 2020)</b>"; }
				} elseif($visitor_approval=="D"){ echo "Disapproved"."<br> <hr>".$disapproval;} elseif($visitor_approval=="U"){ echo "Updated";} else {echo "Pending";}?></td>
                <td scope="col" data-column="Action">
                <?php if($visitor_approval == "Y") { 
                	$encrypted_id =base64_encode($emp['visitor_id']); 
                	?>
                <img src="images/done.png" title="Approved" border="0" /> / <img src="images/eye.png" data-id="<?php echo $encrypted_id;?>" class="openDetails"  title="View Details" border="0" />
                <?php } else { ?>
                <a href="domestic_user_registration_step3.php?action=edit&id=<?php echo $emp['visitor_id'];?>"><img src="images/edit.png" title="Edit"/></a> / 
                <a  href="javascript:void(0)"  data-id="<?php echo $emp['visitor_id']; ?>" class="removePerson"> 
                <img src="images/delete.png" title="Delete" /></a>
                <?php } ?>
				<?php /*if($empBadgeCount>0){ ?>
                  <a href="lost_visitor_badge.php?visitor_id=<?php echo $encrypted_id ;?>"><img src="images/id-card.png" title="Apply for Lost Badge" border="0" /></a>
                 <?php } */?>
				</td>
              </tr>
        <?php } ?>
          </tbody>
          </table>
			<?php } ?> 
				</div>
			</div>

		</div>

	</div>
<div class="modal  fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog  modal-lg modal-dialog-centered" role="document">
    <div class="modal-content box-shadow">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Person Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
          </button>
      </div>
      <div class="modal-body" id="person_details_body">
      
      </div>
    
    </div>
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
<style type="text/css">
	.blah{    display: block;
    max-width: 150px;
    height: auto;
    border: 1px dotted #ccc;
    padding: 8px;}
</style>
</body>
</html>

<script>
function goback()
{
	window.history.back();
}
</script>
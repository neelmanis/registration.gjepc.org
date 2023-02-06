<?php 
include('header_include.php');
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

if(!isset($_SESSION['USERID'])){	header("location:login.php");	exit;	}
//echo "<script>alert('Registration under maintenance'); window.location = 'my_dashboard.php';</script>";

$registration_id=$_SESSION['USERID'];
$sql = "select * from exh_reg_payment_details where uid='$registration_id' AND (`show`='IIJS SIGNATURE 2023' OR `show`='IIJS TRITIYA 2023' OR `show`='IGJME') AND allow_visitor='N' order by payment_id desc limit 0,1";
$ans = $conn->query($sql);
$nans=$ans->num_rows;
if($nans>0){
	echo "<script>alert('You are Exhibitor'); window.location = 'my_dashboard.php';</script>";
}
?>

<?php 




if($_REQUEST['upload']=="UPLOAD")
{	
	if(isset($_FILES['gst_copy']) && $_FILES['gst_copy']['name']!="")
	{
		/* passport picture */
		$gst_copy_name=$_FILES['gst_copy']['name'];
		$gst_copy_temp=$_FILES['gst_copy']['tmp_name'];
		$gst_copy_type=$_FILES['gst_copy']['type'];
		$gst_copy_size=$_FILES['gst_copy']['size'];
		$attach="gst_copy";
		if($gst_copy_name!="")
		{
			$create_gst_copy = 'images/'.$attach;
			if (!file_exists($create_gst_copy)) {
			mkdir($create_salary, 0777);
			}
			$gst_copy=uploadPanGST($gst_copy_name,$gst_copy_temp,$gst_copy_type,$gst_copy_size,$attach);
		}
	}
	
	if(isset($_FILES['pan_no_copy']) && $_FILES['pan_no_copy']['name']!="")
	{
		/* passport picture */
		$pan_no_copy_name=$_FILES['pan_no_copy']['name'];
		$pan_no_copy_temp=$_FILES['pan_no_copy']['tmp_name'];
		$pan_no_copy_type=$_FILES['pan_no_copy']['type'];
		$pan_no_copy_size=$_FILES['pan_no_copy']['size'];
		$attach="pan_no_copy";
		if($pan_no_copy_name!="")
		{
			$create_pan_no_copy = 'images/'.$attach;
			if (!file_exists($create_pan_no_copy)) {
			mkdir($create_partner, 0777);
			}
			$pan_no_copy=uploadPanGST($pan_no_copy_name,$pan_no_copy_temp,$pan_no_copy_type,$pan_no_copy_size,$attach);
		}
	}
 
	$sqlreg="update registration_master set gst_copy='$gst_copy', pan_no_copy='$pan_no_copy',approval_status='U' where id = '$registration_id'";
	$sqlResult = $conn->query($sqlreg);
	if($sqlResult){	header('location:employee_directory.php'); }
} 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<title>Employee Directory</title>
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
<!-- <script type="text/javascript">
    $(document).ready(function() {        
        $().UItoTop({ easingType: 'easeOutQuart' });        
    });
</script> -->

<!--<script src="jsvalidation/jquery.js" type="text/javascript"></script>-->
<script src="jsvalidation/jquery.validate.js" type="text/javascript"></script> 
<script type="text/javascript">
$().ready(function() {

var pan = $('#pn').val();
var sal = $('#s').val();
var par = $('#p').val();
	
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
	
	$("#commentForm").validate()
	$("#form").validate({
		rules: {
			radio1: {
			required: true,
			},
			gender: {
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
			designation: {
				required: true,
			},
			email: {
				required: true,
				email:true
			},
			/*aadhar_no:{
				required: true,
				number:true,
				minlength: 12,
				maxlength:12
			},*/
			pan_no:{
				required:true,
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
			agree:{
				required:true,
			},
		},
		messages: {	
			radio1:{
				required: "Please Select Type"
			},
			gender: {
				required: "Please Select Gender",
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
			designation:{
				required: "Please Select Designation"
			} ,    
		    email: {
				required:"Please Enter valid email id",
			},
			/*aadhar_no: {
				required:"Please Enter Aadhar Number",
				number:"Please Enter Numbers only",
				minlength:"Please enter at least 12 digit.",
				maxlength:"Please enter no more than 0 digit."
			},*/
			pan_no: {
				required: "Please Enter PAN No",
				minlength:"Please Enter at least {10} digit.",
				maxlength:"Please Enter no more than {0} digit."
			},
			photo:{
				required: "Please Upload Photo",
				accept: "Only Image Type JPG/PNG/JPEG is allowed"
			},
			pan_copy:{
				required: "Please Upload PAN Card Copy",
				accept: "Only Image Type JPG/PNG/JPEG is allowed"
			},
			salary:{
				required: "Please Upload Salary Copy or statement",
			},
			partner:{
				required: "Please Upload Valid Document",
			},
			agree:{
				required: "Please click on agree button",
			},
	 }
	});
});
</script>

<script type="text/javascript">
$().ready(function() {
	$("#formupload").validate({
		rules: {
			gst_copy: {
			required: true,
			},
			pan_no_copy: {
			required: true,
			},
		},
		messages: {	
			gst_copy:{
				required: "Please choose GST Copy file"
			},
			pan_no_copy: {
				required: "Please choose PAN Copy file",
			},
	 }
	});
});
</script>

<script>
$(document).ready(function(){            		
    $('input[type="radio"]').click(function(){
    var designation = $('[name="radio1"]:checked').val();
    //alert(designation);
            $.ajax({
                    type: 'POST',
                    url: 'ajax.php',
                    data: "actiontype=checkDesignation&designation="+designation,
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
                    $("#Owner_degn").html(data);
                    }
                    });
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
	  $("#panVerifyIcon").hide();
	  $("#panFailedIcon").hide();
	  $("#pan_no").change(function(){
		  	$("#panVerifyIcon").hide();
		  	$("#panFailedIcon").hide();
			var company_pan_no=$("#pan_no").val();
		 	var regExp = /[a-zA-z]{5}\d{4}[a-zA-Z]{1}/; 
			if (company_pan_no.match(regExp) ) {

			$.ajax({		
				type: 'POST',
				url: 'ajax.php',
				data: "actiontype=checkPanApi&company_pan_no="+company_pan_no,
				dataType:'json',
				beforeSend: function(){
							$('.loader').show();
						},
				success: function(data){
						  		$('.loader').hide();
							  	if(data.success == true){
								   if(data.response_code=="100"){
								   	$("#panVerifyIcon").show();
									$('#send_otp').attr("disabled", false);
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
									$("#panFailedIcon").show();
								   	$('#send_otp').attr("disabled", true);
									$("#chkpanuser").html("Please enter valid pan number").css("color", "red"); 
								//	$('#name').val("");
								//	$('#lname').val("");
								   }
								} else {
									$("#panVerifyIcon").hide();
									$("#panFailedIcon").show();
									$('#send_otp').attr("disabled", true);
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
	
<script type="text/javascript">
	$(window).load(function() {
		$(".loader").fadeOut("slow");
	}); 
</script>
</head>

<body>

<div class="wrapper">

	<div class="loader">
		<div style="display:table; width:100%; height:100%;">
			<span style="display:table-cell; vertical-align:middle; text-align:center; padding-top:100px;">Please wait....</span>
		</div>
	</div>

	<div class="header"><?php include('header1.php'); ?></div>

	<div id="preloader">
	    <div id="status"> <img src="images/loader.gif"></div>
	</div>

<!--container starts-->

  	<div class="container my-5">

  		<div class="bold_font text-center">
			<div class="d-block">
				<img src="https://www.gjepc.org/assets/images/gold_star.png" class="">
			</div>
			Employee Registration
		</div>
		
		<h2 class="title2 text-center">Visitor can Register / make Payment after Approval of Below records</h2>
		<!--<a href="visitor_registration.php" style="float: right;" class="cta" title="Select Show And Make Payment">Registration Application</a>-->

      
      <div class="box-shadow">
      	
      	<div class="userName"></div>

			<?php
				$sqlmaster = $conn->query("select * from registration_master where id = '$registration_id'");
				while($rows = $sqlmaster->fetch_assoc())
				{
				$approval_status = $rows['approval_status'];
				$pan_no_copy = $rows['pan_no_copy'];
				}
				if($pan_no_copy==''){
				echo "<p style='color:#FF0000'>Kindly Upload Company GST and PAN Document.</p>";
			}
		
			if($approval_status !='Y'){	?>   

        	<div class="gp_wrp">			
            
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="cmxform" method="POST" name="formupload" id="formupload" enctype="multipart/form-data">		  		
               
               <div class="field">
                	<label>Company Document</label>
                	<input id="gst_copy" name="gst_copy" type="file" class="textField textField2 imgsel" value="" accept=".jpg,.jpeg,.png" data-imgsrc="blah">
						<b>Kindly upload Max 2MB. jpeg, png</b>
					</div>

              	<div class="field">
                	<label>Company PAN Copy</label>
                	<input id="pan_no_copy" name="pan_no_copy" type="file" class="textField textField2 imgsel" value="" accept=".jpg,.jpeg,.png" data-imgsrc="blah">  
					</div>

               <div class="field"><input type="submit" name="upload" id="upload" value="UPLOAD" class="submitbtn"></div>			
            </form>

        	</div> <!-- kalpesh -->	

        	<?php } ?>

			<?php
				$sqlxx = "select company_pan_no,company_gstn,approval_status,disapprove,pan_no_copy,gst_copy from registration_master where id = '$registration_id' AND pan_no_copy!='' AND gst_copy!=''";
				$xx = $conn->query($sqlxx);
				$getimg = $xx->fetch_assoc();
				$numbers = $xx->num_rows;
				if($numbers>0){
				$pan_no_copy = $getimg['pan_no_copy'];
				$gst_copy = $getimg['gst_copy'];
				$company_pan_no = $getimg['company_pan_no'];
				$company_gstn = $getimg['company_gstn'];
				$gst_copy_ext = pathinfo($getimg['gst_copy'], PATHINFO_EXTENSION); 
				$pan_no_copy_ext = pathinfo($getimg['pan_no_copy'], PATHINFO_EXTENSION); 
				?>
			
				<table class="responsive_table">
	            <thead>
	              <tr>
	                <th scope="col">Company Document</th>
	                <th scope="col">Company Pan</th>
	              </tr>
	            </thead>

					<tbody>

					<tr>
							<td data-column="Company Doc"> 
								<div class="row">
									<div class="col-auto">
										<?php if($gst_copy_ext =="pdf"){?><a href="images/gst_copy/<?php echo $gst_copy;?>
								" target="_blank"><img src="images/pdf_icon.png"></a> <?php }else{?><img src="images/gst_copy/<?php echo $gst_copy;?>" class="emp_img">  <?php } ?>
									</div>
									<div class="col mt-3 mt-md-0">
										<span class="label"><?php 
								if($company_gstn =="NULL"){echo "Not Applicable";}else{echo $company_gstn;}?></span>
									</div>
								</div>
							</td>
							<td data-column="Pan">
								<div class="row">
									<div class="col-auto">
										<?php if($pan_no_copy_ext =="pdf"){?><a href="images/gst_copy/<?php echo $gst_copy;?>
									" target="_blank"><img src="images/pdf_icon.png"></a> <?php } else { ?> <img src="images/pan_no_copy/<?php echo $pan_no_copy;?>" class="emp_img"> <?php } ?>		
									</div>
									<div class="col mt-3 mt-md-0">
										<span class="label"><?php echo $company_pan_no;?></span>	
									</div>
								</div>
							</td>				
	              	</tr>

	              <?php if($getimg['approval_status']=="D"){ ?>
	              <tr>
	              	<td colspan="2">
	              		<p style="text-align: center;"><span>Remark:&nbsp;&nbsp;&nbsp;</span><span style="color: red"><?php echo $getimg['disapprove'];?></span></p>
	              	</td>             
	              <?php } ?>
	              </tr>
	             </tbody>
	        	</table>

			<?php } ?> 

        	<div id="formContainer" class="p-0 mt-4">

         	<?php if($_REQUEST['action']=="edit"){ ?>

          	<div class="title m-0 float-none" id="title_open">
            	<h4 class="cta border-0">NEW REGISTRATION / ADD VISITOR<div class="plus">+</div> <div class="minus">-</div></h4>  
            </div>

	         <?php } else { ?>
	          	<div class="title m-0 float-none" id="title_open">
	            	<h4 class="cta border-0">NEW REGISTRATION / ADD VISITOR <div class="plus">+</div> <div class="minus">-</div></h4>
	            </div>
	         <?php } ?>

          	<div class="form_detailp"></div>          	
					<?php 
					if(($_REQUEST['id']!='') || ($_REQUEST['action']=='edit'))
					{
					$action='update';
					$id=$_REQUEST['id'];
					$sql="SELECT * FROM visitor_directory where visitor_id='$_REQUEST[id]'";
					$result2 = $conn->query($sql);
					if($row2 = $result2->fetch_assoc())
					{
					$shows=filter($row2['shows']);
					$year=$row2['year'];
					$degn_type=$row2['degn_type'];
					$name	=	filter($row2['name']);
					$lname	=	filter($row2['lname']);
					$gender	=	filter($row2['gender']);
					$designation=$row2['designation'];
					$mobile=filter($row2['mobile']);
					$email=filter($row2['email']);
					$aadhar_no=$row2['aadhar_no'];
					$pan_no=filter($row2['pan_no']);
					$photo=$row2['photo'];
					$salary=$row2['salary_slip_copy'];
					$pan_copy=$row2['pan_copy'];
					$partner=$row2['partner'];
					$mod_date=$row2['mod_date'];
					}			
					$designation_type = $degn_type;
					$queryGetCount = $conn->query("SELECT * FROM `visitor_directory` WHERE registration_id='$registration_id' AND (designation='19' || designation='20')");
					$getCount = $queryGetCount->num_rows;
					if($designation_type=='Owner' && $getCount>0)
					$sqlx= "SELECT * FROM `visitor_designation_master` WHERE type='$designation_type' AND id!='18'";
					else
					$sqlx= "SELECT * FROM `visitor_designation_master` WHERE type='$designation_type'";
					$query =  $conn->query($sqlx);
					$desgination_data = array();
					while($row = $query->fetch_assoc()){
					array_push($desgination_data,$row);
					}
					}	
					?>
          		
          		<?php if(isset($signup_error)){ echo '<span style="color: red;" />'.$signup_error.'</span>';} ?>

          		<form action="" method="POST" name="from" id="form" enctype="multipart/form-data">

          			<div class="form-group p-0 px-3 pt-3" id="radio" style="font-size: 14px;">
               		Owner <input type="radio" name="radio1" value="Owner" <?php echo ($degn_type=='Owner')?'checked':'' ?> id="Owner">
              		Employee <input type="radio" name="radio1" value="Employee" <?php echo ($degn_type=='Employee')?'checked':'' ?> id="Employee" >
            		</div>
		    			
		    			<div id="form1" class="px-3 ">

		    			<div class="row">
		  
			  				<div class="col-sm-6 col-md-4 form-group" id="Owner_degn">
                			<label><sup>*</sup>Designation  </label>
			                <select class="select_v form-control" name="designation" id="designation">                                  
			                  <option value="" <?php echo $_REQUEST['action']=='edit'?'':'selected'?> selected="selected">-- Select Designation-- </option> 
			                  <?php if($_REQUEST['action']=='edit'){ ?> 
			                  <?php foreach($desgination_data as $k => $v){ ?>
			                  	<option value="<?php echo $v['id']?>" <?php echo $v['id'] == $designation?'selected':''?>><?php echo $v['type_of_designation'];?></option>
			                  <?php } ?>
			                  <?php } else { ?>
							  <?php 
								if($signup_error!=''){
								$sqlx1= "SELECT * FROM `visitor_designation_master` WHERE type='ss'";
							   } else {
								$sqlx1= "SELECT * FROM `visitor_designation_master` WHERE type='$degn_type'";
							   }
								$query1 =  $conn->query($sqlx1);
								$desgination_data1 = array();
								while($row1 = $query1->fetch_assoc){
								array_push($desgination_data1,$row1);
								}
							  ?>
							  <?php foreach($desgination_data1 as $k1 => $v1){ ?>
			                  	<option value="<?php echo $v1['id']?>" <?php echo $v1['id'] == $designation?'selected':''?>><?php echo $v1['type_of_designation'];?></option>
			                  <?php } ?>
			                  <?php } ?>
			                </select>
              			</div>
			  
		              	<div class="col-sm-6 col-md-4 form-group">
		               	<label> <sup>*</sup>First Name  </label>
		                	<input id="name" name="name" type="text" onkeypress="return onlyAlphabets(event,this);" maxlength="14" class="form-control" value="<?php echo $name; ?>"/>
		              	</div>
              
		              	<div class="col-sm-6 col-md-4 form-group">
			               <label> <sup>*</sup>Last Name  </label>
			               <input id="lname" name="lname" type="text" onkeypress="return onlyAlphabets(event,this);" maxlength="14" class="form-control" value="<?php echo $lname; ?>"/>
		              	</div>
              
		              	<div class="col-sm-6 col-md-4 form-group">
		               	<label><sup>*</sup>Gender </label>
			               <select class="select_v form-control" name="gender" id="gender">                                  
			                  <option value="">-- Select Gender-- </option> 
			                  <option value="M" <?php if($gender == 'M'){ ?> selected="selected"<?php } ?>>Male</option>
			                  <option value="F" <?php if($gender == 'F'){ ?> selected="selected"<?php } ?>>Female</option>
			                  <option value="T" <?php if($gender == 'T'){ ?> selected="selected"<?php } ?>>Trans-Gender</option>
			               </select>
		              	</div>
              
							<div class="col-sm-6 col-md-4 form-group">
								<label><sup>*</sup>Mobile No </label>
								<input id="mobile" name="mobile" type="text" class="form-control" maxlength="10" value="<?php echo $mobile; ?>"/>
							</div>
			                
							<div class="col-sm-6 col-md-4 form-group">
								<label><sup>*</sup>E-Mail </label>
								<input id="email" name="email" type="text" class="form-control" value="<?php echo $email; ?>"/>
							</div>          

							<div class="col-sm-6 col-md-4 form-group">
								<label><sup>*</sup>Individual PAN No </label>
								<input id="pan_no" name="pan_no" type="text" class="form-control" maxlength="10" value="<?php echo $pan_no; ?>"/>
								<span id="panVerifyIcon" class="inputMaskIcon"><i class="text-success fa fa-check"></i></span>
					<span id="panFailedIcon" class="inputMaskIcon"><i class="text-danger fa fa-close"></i></span>
					<span id="chkpanuser"></span>
							</div>

						</div>

						<div class="row">
			  
							<div class="col-sm-6 col-md-4 form-group">
								<label> <sup>*</sup>Photo Passport size with white background : (Max 2MB.jpg, .png)<br></label>
								<input id="photo"  name="photo" type="file"  class="imgsel form-control" value="<?php echo $photo; ?>" data-imgsrc="blah" onchange="photoValidation()"/> <p class="fail" id="photoSizeError"></p> 
								<input type="hidden" id="ph" name="ph" class="textField imgsel form-control" data-imgsrc="blah" value="<?php if(empty($photo)){ echo 0;} else { echo 1;} ?>"/>
								<?php if(!empty($photo)){?>
								<img class="blah" id="blah" src="images/employee_directory/<?php echo $_SESSION['USERID']; ?>/photo/<?php echo $photo; ?>" alt="your image"/> 
								<?php } else { ?>
								<img class="blah" id="blah"  src="images/upload_img.jpg" alt="your image" />
								<?php } ?>
							</div>

							<div class="col-sm-6 col-md-4 form-group">
								<label><sup>*</sup> Individual Pan Card : (Max 2MB.jpg, .png)<br></label>
								<input id="pan_copy" name="pan_copy"  type="file"  class="imgsel form-control"  data-imgsrc="blah2" value="<?php echo $pan_copy;?>" onchange="panValidation()"/> <p class="fail" id="panSizeError"></p>
								<input type="hidden" id="pn" name="pn" class="textField imgsel form-control" data-imgsrc="blah2" value="<?php if(empty($pan_copy)){ echo 0;} else { echo 1;} ?>"/>
								<?php if(!empty($pan_copy)){?>
								<img class="blah" id="blah2" src="images/employee_directory/<?php echo $_SESSION['USERID']; ?>/pan_copy/<?php echo $pan_copy; ?>" alt="your image"/> 
								<?php } else { ?>
								<img class="blah" id="blah2"  src="images/upload_img.jpg" alt="your image" />  
								<?php } ?>
							</div>
              
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
								<img class="blah" id="<?php echo $blah; ?>" src="images/employee_directory/<?php echo $_SESSION['USERID']; ?>/<?php echo $folder?>/<?php echo $emp_files; ?>" alt="your image"/> 
								<?php } else { ?>
								<img class="blah" id="<?php echo $blah; ?>" src="images/upload_img.jpg" alt="your image" /> 
								<?php } ?>
							</div>
           
              <!--<div class="field" id="parner_ship">
                <label>GST certificate/ Partnership deed/ Memorandum of Article of Association stating your name :(.jpg, .png)<sup>*</sup> <br/>(.jpg, .png)</label>
                <input id="partner" name="partner" type="file"  class="textField textField2 imgsel" data-imgsrc="blah4" value="<?php //echo $partner; ?>"/>
                
				<?php //if(!empty($partner)){?>
                <img class="blah" id="blah4" src="images/employee_directory/<?php echo $_SESSION['USERID']; ?>/partner/<?php //echo $partner; ?>" alt="your image"  /> 
				<?php //} else { ?>
				<img class="blah" id="blah4" src="images/upload_img.jpg" alt="your image" />
				<?php// } ?>
              </div>-->	
             
							<div class="col-12 form-group">
								<?php if($_REQUEST['action']!='edit'){ ?>
								<p style="display:block;"> <input type="checkbox" checked="checked" name="agree" value="agree">
								I Agree and accept that all the information provided  by me is authentic and i do not wish
								to misrepresent any data<br> </p><label for="agree" generated="true" style="display: none;" class="error"></label>
								<?php } ?>
							</div>

							<div class="col-12">
								<input type="submit" name="submit" value="Submit" class="submitbtn">
								<?php if($_REQUEST['action']=='edit'){ ?>
								<input type="hidden" name="action" id="action" value="update" />
								<?php } else { ?>
								<input type="hidden" name="action1" id="action1" value="save" />
								<?php } ?>
							</div>
             		</div> 
             	</div>
          		</form>

				</div>

	<div class="clear"></div>
		  
          <div class="title margin_t">
            <h4>OWNER DETAILS</h4>
         <!--<p style="color: red;font-weight:bold;">Please Note : Visitor who already Registered for 2/5 & 3/6 Shows starting from IIJS PREMIERE 2019 need to preserve the badge</p>-->
          </div>

          <div class="clear"></div>
          <!-- <div class="borderBottom"></div> -->
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
			$query_owner =  $conn->query("select * from visitor_directory where degn_type = 'Owner' and registration_id='$registration_id' and status='1'");
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
				<td data-column="Photo"><?php if($owner_photo_ext =="pdf" || $owner_photo_ext =="PDF"){?><a href="images/employee_directory/<?php echo $_SESSION['USERID'];?>/photo/<?php echo $owner['photo'];?>" target="_blank"><img src="images/pdf_icon.png"></a><?php }else{?> <img src="images/employee_directory/<?php echo $_SESSION['USERID'];?>/photo/<?php echo $owner['photo'];?>" class="emp_img"><?php }) ?></td>
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
                <img src="images/done.png" title="Approved" border="0" /> / <img src="images/eye.png" onclick="window.location.href='employee_details.php?id=<?php echo $encrypted_id;?>'"  title="View Details" border="0" />
                <?php } else { ?>                
                <a href="employee_directory.php?action=edit&id=<?php echo $owner['visitor_id'];?>"><img src="images/edit.png" title="Edit" border="0" /></a> /
                <a href="employee_directory.php?action=del&id=<?php echo $owner['visitor_id']?>" onclick="return(window.confirm('Are you sure you want to delete?'));">
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
          <div class="title margin_t">
            <h4>EMPLOYEE DETAILS</h4>
            <!--<p style="color: red; font-weight:bold;">Please Note : Visitor who already Registered for 2/5 & 3/6 Shows starting from IIJS PREMIERE 2019 need to preserve the badge</p>-->
          </div>
          <div class="clear"></div>
         <!--  <div class="borderBottom"></div> -->
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
		  $query_emp =  $conn->query("select * from visitor_directory where degn_type = 'Employee' and registration_id='$registration_id' and status='1'");
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
				<td data-column="Photo"><?php if($employee_photo_ext =="pdf" || $employee_photo_ext =="PDF"){?><a href="images/employee_directory/<?php echo $_SESSION['USERID'];?>/photo/<?php echo $emp['photo'];?>" target="_blank"> <img src="images/pdf_icon.png"></a><?php }else{?>
				<img src="images/employee_directory/<?php echo $_SESSION['USERID'];?>/photo/<?php echo $emp['photo'];?>" class="emp_img">
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
                <img src="images/done.png" title="Approved" border="0" /> / <img src="images/eye.png" onclick="window.location.href='employee_details.php?id=<?php echo $encrypted_id;?>'"  title="View Details" border="0" />
                <?php } else { ?>
                <a href="employee_directory.php?action=edit&id=<?php echo $emp['visitor_id'];?>"><img src="images/edit.png" title="Edit"/></a> / 
                <a  href="employee_directory.php?action=del&id=<?php echo $emp['visitor_id']?>" onclick="return(window.confirm('Are you sure you want to delete?'));"> 
                <img src="images/delete.png" title="Delete" /></a>
		  <?php } }?>
				<?php /*if($empBadgeCount>0){ ?>
                  <a href="lost_visitor_badge.php?visitor_id=<?php echo $encrypted_id ;?>"><img src="images/id-card.png" title="Apply for Lost Badge" border="0" /></a>
                 <?php } */?>
				</td>
              </tr>
        <?php } ?>
          </tbody>
          </table>
		  
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
#form .textField{width: 92%;padding: 0px 2%;height:35px; margin :0 auto; display:table;}
#form .textField2{width:80%;padding:0; float:left;}
#form .field {
    background: none;
    padding: 0;
    float: left;
	width:31.33%;
	margin:0 1%;
}
.submitbtn {
background: #e2e2e2;
border: none;
padding: 7px 15px;
/*margin-top: 15px;*/
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
#updatefrom label.error, #form label.error{font-size: 14px}
    #form label {
    width: 96%;
    display: block;
    float: none;
    /* font-weight: bold; */
    font-size: 14px;
    vertical-align: middle;
    padding-top: 2px;
    color: #751c54;;
	/*height:26px;*/
	margin:0 auto;
	line-height:initial;
	margin-bottom:5px;
	}
  
.icons{border: 0px; outline: none; width:20px;}
.margin_t{margin-top:30px;}
.blah{width: 35px;  height:35px;vertical-align: top;}
#blah{display: none;}
#blah2{display: none;}
#blah3{display: none;}
.form_detail{margin:20px 0; display:none;}
.form_detail p{font-size: 15px;font-weight: 600;text-transform: uppercase;}
#select_v{margin-top:20px; width: 200px; font-size: 16px; color: #ffffff;border: #751c54 1px solid;background: #751c54; padding: 5px;}
#title_open{cursor: pointer;}
<?php if($_REQUEST['action']=='edit'){ ?> 
#form1{display: block;}
#radio{display: block;}
<?php } else { ?>
#form1{display: none; margin-bottom:20px;}
#radio{display: none; padding:0 2%;}
<?php } ?>
.minus{display: none; font-size: 20px; font-weight: 600; float:right;}
.plus{display: inline; font-size: 20px; font-weight: 600; float:right;}
#title_open h4{padding: 10px 15px; margin-top:0px; background: #1a1a1a; color: #fff;}
.minus_1{display: inline!important; font-size: 20px; font-weight: 600;}
.plus_1{display: none;}
.emp_img{max-width: 150px; width: 100%; height: 100px; object-fit: contain; display: table; object-position: left;}

.title h4 {
    font-style: normal;
    font-weight: bold;
    padding: 7px 7px 7px 0;
    font-size: 14px;
    /* background: #000; */
    border-bottom: 1px dashed #a89c5d;
    color: #9e9457;
    margin-bottom: 15px; 
}

.padding-b{padding-bottom:65px;}

/*<?php //if($degn_type == 'Owner') { ?>
#parner_ship{display: block;}
#salary_slip{display: none;}
<?php //} else { ?>
#parner_ship{display: none;}
#salary_slip{display: block;}
<?php //} ?>*/

.gp_wrp {margin-bottom:20px; background:#f8f8f8; padding:20px;}
.gp_wrp .cmxform{display:table; width:100%;}
.gp_wrp .cmxform .field {display:inline-block; margin-right:0; width:33.33%; vertical-align:text-top; }
.gp_wrp .cmxform .field input[type=file] {border:1px solid #ddd; padding:5px; cursor:pointer;}
.gp_wrp .cmxform .field label {margin-right:20px;}
.gp_wrp .cmxform .field .submitbtn {margin:0;margin-top:20px; height:33px; }
.submitbtn { cursor:pointer; transition:0.3s ease-in-out; -moz-transition:0.3s ease-in-out; -o-transition:0.3s ease-in-out; -webkit-transition:0.3s ease-in-out;}
.submitbtn:hover {background:#000; color:#fff; transition:0.3s ease-in-out; -moz-transition:0.3s ease-in-out; -o-transition:0.3s ease-in-out; -webkit-transition:0.3s ease-in-out;}
.label{display: inline-block; padding: 8px; border:1px solid#000;}
.cmxform .error {color:red;}
</style>

<script type="text/javascript">
  $(document).ready(function(){
    $("#title_open").click(function(){
      $("#radio").toggle(400);
      $("#form1").toggle(400);
    });
  });
</script>
<?php if(isset($signup_error)){ ?>
	<script type="text/javascript">
  $(document).ready(function(){
    
      $("#radio").toggle(400);
      $("#form1").slideDown();
    
  });
</script> <?php } ?>

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
    
    $(".imgsel").change(function(){
        var imgdiv = $(this).attr('data-imgsrc');
        readURL(this,imgdiv);
    });
</script>

<script type="text/javascript">
  $(document).ready(function(){
    $("#title_open").click(function(){
      $('.minus').toggleClass('minus_1');
      $('.plus').toggleClass('plus_1')
    });
  });
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
</body>
</html>
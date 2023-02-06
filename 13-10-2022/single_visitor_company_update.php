<?php include('header_include.php');
$registration_id = $_SESSION['registration_id'];
if(!isset($registration_id) && $registration_id==''){ header("location:single_visitor.php"); exit; } 
?>
<?php
if(isset($_REQUEST['submit'])=="Submit")
{	//echo '<pre>'; print_r($_POST); exit;
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
			$gst_copy=uploadSinglePanGST($gst_copy_name,$gst_copy_temp,$gst_copy_type,$gst_copy_size,$attach);
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
			$pan_no_copy=uploadSinglePanGST($pan_no_copy_name,$pan_no_copy_temp,$pan_no_copy_type,$pan_no_copy_size,$attach);
		}
	}
	
	$company_pan_no = filter(strtoupper($_REQUEST['company_pan_no']));	
	$company_gstn = filter(strtoupper($_REQUEST['company_gstn']));	

	if($pan_no_copy=='invalidfile')
	{ $signup_error="Invalid file Selected or more than 2MB ";  }
	else if($gst_copy=='invalidfile')
	{ $signup_error="Invalid file Selected or more than 2MB "; }
	else {
	$sqlreg.="update registration_master set approval_status='U'"; 
	if(isset($gst_copy) && $gst_copy!='')
		$sqlreg.=",`gst_copy`='$gst_copy'";
	if(isset($pan_no_copy) && $pan_no_copy!='')
		$sqlreg.=",`pan_no_copy`='$pan_no_copy'";
	if(isset($company_pan_no) && $company_pan_no!='')
		$sqlreg.=",`company_pan_no`='$company_pan_no'";
	if(isset($company_gstn) && $company_gstn!='')
		$sqlreg.=",`company_gstn`='$company_gstn'";
	$sqlreg.=" where id = '$registration_id'";
	//echo $sqlreg; exit;
	$sqlResult = $conn->query($sqlreg);
	if($sqlResult){
		$_SESSION['succ_msg']= "Dear your Company data has been updated successfully, you will be notified on approval/disapproval.".
		"<a href='single_visitor.php'> <strong>GO TO HOME PAGE</strong></a>"; ?>
	<?php }
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Welcome to IIJS Registration</title>
  <link rel="shortcut icon" href="images/fav.png" />
  <link rel="stylesheet" type="text/css" href="css/mystyle.css?v=<?php echo $version;?>" />
  <link rel="stylesheet" type="text/css" href="https://gjepc.org/assets-new/css/bootstrap.min.css" />
  <link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Cabin'>
  <link rel="stylesheet" type="text/css" href="css/general.css?v=<?php echo $version;?>" />
  <link rel="stylesheet" type="text/css" href="css/inner_pg_style.css?v=<?php echo $version;?>" />  
  <link rel="stylesheet" type="text/css" href="css/responsive.css?v=<?php echo $version;?>" />
  <link rel="stylesheet" type="text/css" href="css/media_query.css?v=<?php echo $version;?>" />
  <link rel="stylesheet" type="text/css" href="css/visitor_reg.css?v=<?php echo $version;?>" />
  <script type="text/javascript" src="js/jquery-1.8.3.min.js?v=<?php echo $version;?>"></script>

  <!--NAV-->
  <link href="css/flexnav.css?v=<?php echo $version;?>" media="screen, projection" rel="stylesheet" type="text/css">
  <script src="js/jquery.flexnav.js?v=<?php echo $version;?>" type="text/javascript"></script>
  <script src="js/common.js"></script> 
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

<!-- Global site tag (gtag.js) - Google Ads: 679056788 --><!--  <script async src="https://www.googletagmanager.com/gtag/js?id=AW-679056788"></script> <script> window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag('js', new Date()); gtag('config', 'AW-679056788'); </script> --> 
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
	$("#company_update").validate({
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
</head>

<body>
    <div class="wrapper">
       <div class="header">
          <?php include('header1.php'); ?>
      </div>
    <div class="clear"></div>

    <!--container starts-->
    <div class="container_wrap">
       <div class="container">

           <div class="bold_font text-center">
              <div class="d-block">
                  <img src="https://www.gjepc.org/assets/images/gold_star.png" class="">
              </div>
            Visitor Registration Update Company Details
          </div>  
           <div id="loginForm">           
        <div class="box-shadow">
       <div class="loaderWrapper">
        <div class="formLoader">
         <img src="images/formloader.gif" alt="">
          <p> Please Wait....</p>
       </div>
       </div>
	   <?php if(isset($signup_error)){ echo '<span style="color: red;" />'.$signup_error.'</span>';} ?>
	   <?php
	   if($_SESSION['succ_msg']!=""){
		echo "<div class='text-center py-5'><span style='color: green;'>".$_SESSION['succ_msg']."</span></div>";
		$_SESSION['succ_msg']="";
		} else { ?>
		<?php
		$sqlxx = "select company_pan_no,company_gstn,approval_status,disapprove,pan_no_copy,gst_copy from registration_master where id = '$registration_id'";
		$xx = $conn->query($sqlxx);
		$getimg = $xx->fetch_assoc();
		$numbers = $xx->num_rows;
		$pan_no_copy = $getimg['pan_no_copy'];
		$gst_copy = $getimg['gst_copy'];
		$company_pan_no = $getimg['company_pan_no'];
		$company_gstn = $getimg['company_gstn'];
		$gst_copy_ext = pathinfo($getimg['gst_copy'], PATHINFO_EXTENSION); 
		$pan_no_copy_ext = pathinfo($getimg['pan_no_copy'], PATHINFO_EXTENSION); 
		?>
		
		<?php  if($getimg['approval_status']=="D"){ ?>
        <form id="company_update" enctype="multipart/form-data" method="POST" autocomplete="off"> 
           <div class="row">            
					<div class="col-sm-6 form-group">
					<label><strong>Company Name : </strong></label>
					 <?php echo getCompanyName($registration_id,$conn);?>
					</div>
					
					<?php  if($getimg['approval_status']=="D"){ ?>
					<div class="col-sm-6 form-group">
					<label><strong>Remark : </strong></label>
					<span style="color: red"><?php echo $getimg['disapprove'];?></span>
					</div>
					<?php } ?>
			
					<div class="col-sm-6">	 
                    <label>Company PAN No</label>
                    <input type="text" class="form-control" id="company_pan_no" name="company_pan_no" autocomplete="off" maxlength="10" <?php if($company_pan_no =="NULL" || $company_pan_no ==""){?> value="" <?php } else {?> value="<?php echo $company_pan_no;?>" disabled <?php } ?> />
                    <p class="fail" id="panEmpty"></p>
					</div>
				
					<div class="col-sm-6">	 
                    <label>Upload Company PAN </label>
                    <input type="file" class="form-control" id="pan_no_copy" name="pan_no_copy" onchange="panValidation()" accept=".jpg,.jpeg,.png,.pdf"/>
					<p class="fail" id="panCopyEmpty"></p><p class="fail" id="panSizeError"></p>
                    <img id="blah2" src="#" alt="your image" style="max-width: 200px;height: auto;"/>
					</div>
					
					<div class="col-sm-6">	 
                    <label>Company GSTIN No</label>
                    <input type="text" class="form-control" id="company_gstn" name="company_gstn" autocomplete="off" maxlength="15" <?php if($company_gstn =="NULL" || $company_gstn ==""){?> value="" <?php } else {?> value="<?php echo $company_gstn;?>" disabled  <?php } ?>/>
                    <p class="fail" id="panEmpty"></p>
					</div>
					
					<div class="col-sm-6">	
                    <label class="star">Upload Company GSTIN</label><br>
                    <input type="file" class="form-control" id="gst_copy" name="gst_copy" onchange="gstinValidation()" accept=".jpg,.jpeg,.png,.pdf"/>
                    <p class="fail" id="gstinEmpty"></p><p class="fail" id="gstinSizeError"></p>
                    <img id="blah1" src="#" alt="your image" style="max-width: 200px;height: auto;"/>
                    </div>
	
            <div class="col-12 form-group">
           	 	<label><input type="checkbox" name="agree" checked="checked">I Agree and accept that all the information provided by me is authentic and i do not wish to misrepresent any data</label>
           	</div>

		<div class="col-12">
        <input type="submit" name="submit" value="Submit" class="btn btn-submit">
		
        <input type="hidden" name="action" value="AddVisitor">
      </div>
    </div>
    </div>
  </div>
    </form>
		<?php } else { ?> Approval is Pending from Admin<?php } ?>
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
</body>
</html>
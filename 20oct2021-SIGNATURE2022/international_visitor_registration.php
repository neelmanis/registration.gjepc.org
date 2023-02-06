<?php include('header_include.php');
	if(!isset($_SESSION['USERID'])){ header("location:login.php");	exit;}
?> <!--login check and redirecting to appropriate page-->

<!-- uploading images and updating the database -->
<?php
$uid = $_SESSION['USERID'];
$erp_code = "";
$eid=$_REQUEST['eid'];

if(isset($eid) && $eid!=''){
	$select="SELECT * FROM ivr_registration_details where uid='$uid' and eid='$eid'";
} else {
	$select="SELECT * FROM ivr_registration_details where uid='$uid' order by eid desc limit 1";
}

$count_result=$conn->query($select);
$count=$count_result->num_rows;
$rows = $count_result->fetch_assoc();
$eid=$rows['eid'];

$photo_updated="yes";
$valid_passport_copy_updated="yes";
$visiting_card_updated="yes";
$nri_photo_updated="yes";
$vaccination_id_updated="yes";

if($_REQUEST['action']=='SEND')
{	
	$photograph_fid1=$conn->real_escape_string($_REQUEST['photograph_fid1']);
	$passport_fid1=$conn->real_escape_string($_REQUEST['passport_fid1']);
	$visit_card_fid1=$conn->real_escape_string($_REQUEST['visit_card_fid1']);
	$nri_fid1=$conn->real_escape_string($_REQUEST['nri_fid1']);
	
	if($status == 0){
	$sqlupdate="update ivr_registration_details set photograph_fid='$photograph_fid1',passport_fid='$passport_fid1',visit_card_fid='$visit_card_fid1',nri_fid='$nri_fid1',modified_date=NOW() where uid='$uid' AND eid = '$eid'";
	}
	$conn->query($sqlupdate);
}

if(isset($_FILES['photograph_fid']) && $_FILES['photograph_fid']['name']!="")
{
	/* photograph */
	$file_name=$_FILES['photograph_fid']['name'];
	$file_temp=$_FILES['photograph_fid']['tmp_name'];
	$file_type=$_FILES['photograph_fid']['type'];
	$file_size=$_FILES['photograph_fid']['size'];
	$attach="photograph";
	if($_FILES['photograph_fid']['name']!="")
	{
		$photo=uploadImage($file_name,$file_temp,$file_type,$file_size,$attach);
	}
	
	$update_photo="update ivr_registration_details set photograph_fid='$photo',photo_updated='$photo_updated',photo_approval='P',photo_reason='' where uid='$uid' and eid = '$eid'";
	$update_photoresult = $conn->query($update_photo);
}	

if(isset($_FILES['passport_fid']) && $_FILES['passport_fid']['name']!="")
{
	/* passport picture */
	$passfile_name=$_FILES['passport_fid']['name'];
	$passfile_temp=$_FILES['passport_fid']['tmp_name'];
	$passfile_type=$_FILES['passport_fid']['type'];
	$passfile_size=$_FILES['passport_fid']['size'];
	$attach="passport";
	if($passfile_name!="")
	{
		$passport=uploadImage($passfile_name,$passfile_temp,$passfile_type,$passfile_size,$attach);
	}
	
	$update_passport="update ivr_registration_details set passport_fid='$passport',valid_passport_copy_updated='$valid_passport_copy_updated',valid_passport_copy_approval='P',valid_passport_copy_reason='' where uid='$uid' AND eid = '$eid'";	
	$update_passresult = $conn->query($update_passport);
}

if(isset($_FILES['visiting_card_fid']) && $_FILES['visiting_card_fid']['name']!="")
{	
	/* visiting card */
	$visitfile_name=$_FILES['visiting_card_fid']['name'];
	$visitfile_temp=$_FILES['visiting_card_fid']['tmp_name'];
	$visitfile_type=$_FILES['visiting_card_fid']['type'];
	$visitfile_size=$_FILES['visiting_card_fid']['size'];
	$attach="visiting_card";
	if($visitfile_name!="")
	{
		$visit_card=uploadImage($visitfile_name,$visitfile_temp,$visitfile_type,$visitfile_size,$attach);
	}
	
	$update_visitcard="update ivr_registration_details set visit_card_fid='$visit_card',visiting_card_updated='$visiting_card_updated',visiting_card_approval='P',visiting_card_reason='' where uid='$uid' AND eid = '$eid'";
	$update_visitresult = $conn->query($update_visitcard);
}
	
if(isset($_FILES['nri_fid']) && $_FILES['nri_fid']['name']!="")
{
	/* nri proof */
	$nrifile_name=$_FILES['nri_fid']['name'];
	$nrifile_temp=$_FILES['nri_fid']['tmp_name'];
	$nrifile_type=$_FILES['nri_fid']['type'];
	$nrifile_size=$_FILES['nri_fid']['size'];
	$attach="nri";
	if($nrifile_name!="")
	{
		$nri_file=uploadImage($nrifile_name,$nrifile_temp,$nrifile_type,$nrifile_size,$attach);
	}
	
	$update_nri="update ivr_registration_details set nri_fid='$nri_file',nri_photo_updated='$nri_photo_updated',nri_photo_approval='P',nri_photo_reason='' where uid='$uid' AND eid = '$eid'";
	$update_nriresult = $conn->query($update_nri);	
}
	
$fetch_data="select * from ivr_registration_details where uid=".$_SESSION['USERID']." AND eid='$eid'";	
//print_r($fetch_data);
$result = $conn->query($fetch_data);
if(!$result){
	die($conn->error);	
}
$data = $result->fetch_assoc();

if($_REQUEST['action']=='SEND')
{
	if($data['application_status']=='0')
	{
		$message ='<table width="800px" bgcolor="#fbfbfb" style="margin:2% auto; border:2px solid #ddd; font-family:Arial, sans-serif; color:#333333; font-size:13px; border-radius:10px;">
		
		<tr>
		<td style="padding:30px;">
		<table width="100%" border="0px" background="#fbfbfb" cellpadding="0px" cellspacing="0px">
			
		<tr>
           	<td align="left"> <img src="https://gjepc.org/assets/images/logo.png"/> </td>
            <td align="right"> <img src="https://registration.gjepc.org/images/IIJS-Premiere-2021-logo.png"/> </td>
		</tr>
			
			<tr>
			<td> </td>
			<td align="right"></td>
			</tr>
			
			<tr>
			<td align="right" colspan="3" height="30px"><hr/></td>
			</tr>
		
			<tr>
			<td align="right" colspan="3" height="10px"></td>
			</tr>
			
			<tr>
			<td colspan="3" style="font-size:13px; line-height:22px;">
			
		    <p> Dear '.$data['title'].' '.$data['first_name'].' '.$data['last_name'].',</p>
		
			<p>Thank you for registering at IIJS SIGNATURE 2021 SHOW 2.0. Your registration is pending for the admin approval which you will be notified shortly.</p>
			
			<p>Application No. '.$eid.'</p>
			<p>You can also check the status of your application. </p>
		<!--	<p>Following are your login credentials:</p>
			<p><strong>Name : </strong>'.$data['title'].' '.$data['first_name'].' '.$data['last_name'].'</p>
			<p><strong>Login ID : </strong>'.getUserEmail($uid,$conn).'</p>
			
			<p>Please <a href="https://iijs.org/login.php" style="color:#751b53; text-decoration:none; font-weight:bold;">click here</a> to login to iijs.org.</p>
			
			<p>In case you have forgotten your password, <a href="https://registration.gjepc.org/forgot_password.php" style="color:#751b53; text-decoration:none; font-weight:bold;">click here</a>.</p>
			
			<p>To avail exclusive hotel packages <a href="https://iijs.org/official_hotels.php" style="color:#751b53; text-decoration:none; font-weight:bold;">click here</a>.</p>-->
			<p>Warm Regards,</br></br>
			IIJS SIGNATURE 2021 SHOW Team</p>
			</td>
			</tr>
			</table>
		</td>
		</tr>
		<tr>
		<td colspan="4" align="right" ><hr /></td>
	</tr>
		</table>';	
			
		//$to = 'neelmani@kwebmaker.com';
		//$to = $data['email'];
		$subject = "Thank you for registering to visit IIJS SIGNATURE 2021"; 
		$headers  = 'MIME-Version: 1.0' . "\n"; 
		$headers .= "Cc:overseas@gjepcindia.com" . "\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n"; 
		$headers .='From: IIJS SIGNATURE 2021 SHOW <admin@gjepc.org>';		
		mail($to, $subject, $message, $headers);
	} else {
		
			if($data['personal_info_approval']=='Y')
			{
			$info_status="Approved";
			}else if($data['personal_info_approval']=='N')
			{
			$info_status="Disapproved";
			}else if($data['personal_info_approval']=='P')
			{
			$info_status="<strong>Pending for approval</strong>";
			}
			
			if($data['photo_approval']=='Y')
			{
			$photo_status="Approved";
			}else if($data['photo_approval']=='N')
			{
			$photo_status="Disapproved";
			}else if($data['photo_approval']=='P')
			{
			$photo_status="<strong>Pending for approval</strong>";
			}
			
			if($data['valid_passport_copy_approval']=='Y')
			{
			$passport_status="Approved";
			}else if($data['valid_passport_copy_approval']=='N')
			{
			$passport_status="Disapproved";
			}else if($data['valid_passport_copy_approval']=='P')
			{
			$passport_status="<strong>Pending for approval</strong>";
			}
			
			if($data['visiting_card_approval']=='Y')
			{
			$visiting_status="Approved";
			}else if($data['visiting_card_approval']=='N')
			{
			$visiting_status="Disapproved";
			}else if($data['visiting_card_approval']=='P')
			{
			$visiting_status="<strong>Pending for approval</strong>";
			}
			
			if($data['nri_photo_approval']=='Y')
			{
			$nri_status="Approved";
			}else if($data['nri_photo_approval']=='N')
			{
			$nri_status="Disapproved";
			}else if($data['nri_photo_approval']=='P')
			{
			$nri_status="<strong>Pending for approval</strong>";
			}
		
	$message ='<table width="800px" bgcolor="#fbfbfb" style="margin:2% auto; border:2px solid #ddd; font-family:Arial, sans-serif; color:#333333; font-size:13px; border-radius:10px;">
	
	<tr>
	<td style="padding:30px;">	
		<table width="100%" border="0px" background="#fbfbfb" cellpadding="0px" cellspacing="0px">
		
		<tr>
           	<td align="left"> <img src="https://gjepc.org/images/gjepc_logon.png"/> </td>
            <td align="right"> <img src="https://gjepc.org/iijs-signature/assets/images/logo.png"/> </td>
		</tr>
		
		<tr>
		<td> </td>
		<td align="right"></td>
		</tr>
		
		<tr>
		<td align="right" colspan="3" height="30px"><hr /></td>
		</tr>
	
		<tr>
		<td align="right" colspan="3" height="10px"></td>
		</tr>
		
		<tr>
		<td colspan="3" style="font-size:13px; line-height:22px;">
		
	   <p> Dear '.$data['title'].' '.$data['first_name'].' '.$data['last_name'].',</p>
	
	<p>Details given below on the IIJS SIGNATURE 2021 SHOW, has been updated.</p>
	
	<table width="500" border="0" cellspacing="0" cellpadding="0" >
	  <tr style="height:20px; border:1px solid  #FF0000; background:#751b53; color:#FFFFFF;">
		<td style="border:1px solid  #cccccc; padding:5px;" ><strong>Details</strong></td>
		<td style="border:1px solid  #cccccc; padding:5px;"><strong>Status</strong></td>
	  </tr>
	  <tr style="height:20px; border:1px solid  #FF0000;">
		<td style="border:1px solid  #cccccc; padding:5px;" >Personal Information</td>
		<td style="border:1px solid  #cccccc; padding:5px;">'.$info_status.'</td>
	  </tr>
	  <tr style="height:20px; border:1px solid  #FF0000;">
		<td style="border:1px solid  #cccccc; padding:5px;" >Photo</td>
		<td style="border:1px solid  #cccccc; padding:5px;">'.$photo_status.'</td>
	  </tr>
	  <tr style="height:20px; border:1px solid  #FF0000;">
		<td style="border:1px solid  #cccccc; padding:5px;" >Passport Copy</td>
		<td style="border:1px solid  #cccccc; padding:5px;">'.$passport_status.'</td>
	  </tr>
	  <tr style="height:20px; border:1px solid  #FF0000;">
		<td style="border:1px solid  #cccccc; padding:5px;" >Visiting/Businees Card</td>
		<td style="border:1px solid  #cccccc; padding:5px;">'.$visiting_status.'</td>
	  </tr>
	  <tr style="height:20px; border:1px solid  #FF0000;">
		<td style="border:1px solid  #cccccc; padding:5px;" >NRI Status Proof</td>
		<td style="border:1px solid  #cccccc; padding:5px;">'.$nri_status.'</td>
	  </tr>
	</table>
	
	<p>Your updated details are pending in the admin approval, which will be notified to you shortly.</p>
	<p>Request you to kindly login at our website and verify the same. </p>
	
	<p>Following are your login credentials:</p>
	<p><strong>Name : </strong>'.$data['title'].' '.$data['first_name'].' '.$data['last_name'].'</p>
	<p><strong>Email ID : </strong>'.getUserEmail($uid,$conn).'</p>
			
	<!--<p>Please <a href="http://iijs.org/login.php" style="color:#751b53; text-decoration:none; font-weight:bold;">click here</a> to login to iijs.org.</p>	
	
	<p>In case you have forgotten your password, <a href="https://registration.gjepc.org/forgot_password.php" style="color:#751b53; text-decoration:none; font-weight:bold;">click here</a>.</p>
	
	<p>Badges will be available at the venue at hall 2 during the show.</p>
	
	<p>To avail exclusive hotel packages <a href="http://iijs.org/official_hotels.php" style="color:#751b53; text-decoration:none; font-weight:bold;">click here</a>.</p>-->
	<p>Warm Regards,</br>
	IIJS SIGNATURE 2021 SHOW Web Team</p>
		</td>
		</tr>
		<tr>
		<td colspan="4" align="right" ><hr /></td>
	</tr>
	</table>
	</td>
	</tr>	
	</table>';	
	
		 //$to ='neelmani@kwebmaker.com,Snehal.Rane@gjepcindia.com';
	//	 $to =$data['email']; 
		 $subject = "IIJS SIGNATURE 2021 - Update"; 
		 $headers  = 'MIME-Version: 1.0' . "\n"; 
		 $headers .= "Cc:overseas@gjepcindia.com" . "\n";
		 $headers .= 'Content-type: text/html; charset=iso-8859-1'. "\n"; 
		 $headers .='From: IIJS SIGNATURE 2021 <admin@gjepc.org>';			
		 mail($to, $subject, $message, $headers);
	}
}
		if($_POST['email_notification']=="on")
		{
			$email_notification="1";
		} else {
			$email_notification="0";
		}
		if($_POST['apply_visa']=="1")
		{
			$apply_visa="1";
		} else
		{
			$apply_visa="0";
		}
	
		$update_query="update ivr_registration_details set email_notification='$email_notification', apply_visa='$apply_visa',application_status='1' where uid='$uid' AND eid = '$eid'";		
		$update_result = $conn->query($update_query);
		if($update_result){
		
		/*Send Email Receipt to Company */
		$message ='<table class="table2" width="80%" bgcolor="#fbfbfb" align="center" style="margin:2% auto; border:2px solid #ddd; font-family:Arial, sans-serif; color:#333333; font-size:13px; border-radius:10px;padding:10px;">	
    <tbody>    
    	<tr>
            <td align="left"><img id="ri" src="https://gjepc.org/assets/images/logo.png">
            <td align="center"> <img id="mi"> </td>
            <td align="right"><img id="ri" src="https://gjepc.org/iijs-signature/assets/images/logo.png"></td>
            </td>                        
		</tr>
            
        <tr><td colspan="3" height="30"><hr></td></tr>        
        <tr>           
        	<td colspan="3" id="content">
				<p> Dear '.$data['title'].' '.$data['first_name'].' '.$data['last_name'].',</p>
				<p> Thank you for registering at IIJS SIGNATURE 2021. Your registration is completed.</p>
				<p> Login and password will be sent shortly on your registered email to visit the show.</p>
				<p> You can also check more details on https://gjepc.org/iijs-signature/</p>
                
		</td>            
        </tr>   
           <style type="text/css">
           .table2 input{width: 80%;border-left: none; border-right: none; border-top: none; border-bottom: 1px solid #000;}
               .table1 input{border-left: none; border-right: none; border-top: none; border-bottom: 1px solid #000; width: 150px;}
           }          
            .table2 h4{text-align: center;}
           </style>
	</tbody>
	</table>';
		
	//	$to ='neelmani@kwebmaker.com,Snehal.Rane@gjepcindia.com';
	//	$to =$data['email'];
		$subject = "Thank you for registering to visit IIJS SIGNATURE 2021."; 
		$headers  = 'MIME-Version: 1.0' . "\n"; 
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n"; 
		$headers .= 'From: IIJS SIGNATURE 2021 <admin@gjepc.org>';			
		mail($to, $subject, $message, $headers);
		/*  Email End */
		
		} else {
		echo "Error: ".$conn->error;		
		header("location:international_visitor_registration.php");
		exit;
		}
?> 

<?php
$actions=@$_REQUEST['actions'];
if(isset($actions)=="saveInfo")
{
	//echo '<pre>';  print_r($_POST); exit;
	if(isset($_POST['agree']) && $_POST['agree'] == 'YES'){   $agree = "YES"; } else {  $agree = "NO"; }
	$trade_shows = $_REQUEST['trade_show']; 
	
	$update_query = "update ivr_registration_details set agree='$agree', trade_show='$trade_shows',modified_date=NOW() where uid='$uid' AND eid = '$eid'";	
	$update_result = $conn->query($update_query);	
	if(!$update_result){
	echo "Error: ".$conn->error;		
	header("location:international_visitor_registration.php");	exit;
	} else { 
	echo "<meta http-equiv=refresh content=\"0;url=international_visitor_registration.php?eid=$eid\">";
	}
	
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>International Visitor Registration </title>
<link rel="shortcut icon" href="images/fav.png" />
<link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Cabin'>
<link rel="stylesheet" type="text/css" href="css/general.css?v=<?php echo $version;?>" />
<link rel="stylesheet" type="text/css" href="css/inner_pg_style.css?v=<?php echo $version;?>" />
<link rel="stylesheet" type="text/css" href="css/form.css?v=<?php echo $version;?>" />
<link rel="stylesheet" type="text/css" href="css/visitor_reg.css?v=<?php echo $version;?>" />

<!-- UItoTop plugin -->
<link rel="stylesheet" type="text/css" media="screen,projection" href="css/ui.totop.css?v=<?php echo $version;?>" />
 <script src="calendar/js/jquery-1.9.1.js?v=<?php echo $version;?>"></script>
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
<!-- Global site tag (gtag.js) - Google Ads: 679056788 --><!--  <script async src="https://www.googletagmanager.com/gtag/js?id=AW-679056788"></script> <script> window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag('js', new Date()); gtag('config', 'AW-679056788'); </script>  -->
<!-- Event snippet for GJEPC_Google_PageView conversion page --> <script> gtag('event', 'conversion', {'send_to': 'AW-679056788/N1zUCJPKxLsBEJSr5sMC'}); </script> 
<script type="text/javascript">
    $(document).ready(function() {        
        $().UItoTop({ easingType: 'easeOutQuart' });        
    });
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
<!-- calendar starts-->
<link rel="stylesheet" href="calendar/css/jquery-ui.css" />
 
  <script src="calendar/js/jquery-ui.js"></script>
  <!--<link rel="stylesheet" href="/resources/demos/style.css" />-->
  <script>
  $(function() {
    $( "#datepicker" ).datepicker();
  });
  </script>
<style type="text/css">
#personalData .right_text {
    width: 570px;
}
</style>
<!-- calendar ends-->
</head>

<body>

<div class="wrapper">

<div class="header"><?php include('header1.php');?></div>

<div class="inner_container">

	<div class="bold_font text-center">
    <div class="d-block">
        <img src="https://www.gjepc.org/assets/images/gold_star.png" class="">
    </div>
    International Visitor Registration
</div>  
    <div class="content_area ">   
                      
<!--                <div>              
               <div class="leftPic">
               <img src="images/ivr_image/photograph/<?php echo $data['photograph_fid'];?>"  alt="Photo" />
               <div class="clear"></div>               
               </div>               
               </div> -->
              
              <div class="box-shadow">
              
              	<img src="images/ivr_image/photograph/<?php echo $data['photograph_fid'];?>"  alt="Photo" style="width: 100px; display:table; margin:0 auto 20px auto;" />
           
                <table class="responsive_table newTable">
                
                <thead>
                	<thead>
                     	<tr>
                        	<th>Company	</th>
                            <th>Contact Person	</th>
                            <th>Designation</th>
                            <th>Country</th>
                            <th>City</th>
                            <th>Email</th>
                            <th>Mobile</th>
                        </tr>
                     </thead>
                </thead>
                
                <tbody>
                  <tr>
                    <td class="bold">Company</td>
                    <td data-column="Company"><?php echo $data['company_name'];?></td>
                   
                  </tr>
                  <tr>
                    <td class="bold">Contact Person</td>
                    <td data-column="Contact Person"><?php echo $data['first_name']." ".$data['last_name'];?></td>
                  </tr>
                  <tr>
                    <td class="bold">Designation</td>
                    <td data-column="Designation"><?php echo $data['designation'];?></td>
                  </tr>
                  <tr>
                    <td class="bold">Country</td>
                    <td data-column="Country"><?php echo getCountryName($data['country'],$conn);?></td>
                  </tr>
                  <tr>
                    <td class="bold">City</td>
                    <td data-column="City"><?php echo $data['city'];?></td>
                  </tr>
                  <tr>
                    <td class="bold">Email</td>
                    <td data-column="Email"><a href="mailto:<?php echo $data['email'];?>"><?php echo $data['email'];?></a></td>
                  </tr>
                   <tr>
                    <td class="bold">Mobile</td>
                    <td data-column="Mobile"><?php echo $data['mob_no'];?></td>
                  </tr>
                  
                  </tbody>
                  
                  </table>
                  
                  <div class="viBtn">
                  
                <div>
                <?php /*if($data['trade_show'] !='VBSM 2020' || $data['personal_info_approval']=='Y'){ ?>
                    <div class="maroonBtn" style="margin-right:10px;"><a href="i_v_r.php?id=<?php echo $eid; ?>">Apply</a></div>
                <?php } else { ?>
                	<div class="maroonBtn" style="margin-right:10px;"><a href="i_v_r.php?id=<?php echo $eid; ?>">View Your Application </a></div>
					<div class="maroonBtn"><a href="print_ack_ivr.php?id=<?php echo $eid; ?>" target="_blank">Print Acknowledgement</a></div>
                <?php } */?>
					
				<?php 
				if($data['trade_show']=='IIJS 2021'){ ?>
				<div class="maroonBtn" style="margin-right:10px;"><a href="i_v_r.php?id=<?php echo $eid; ?>" target="_blank">View Your Application </a></div>
				</div>				
				
					<div class="gold_bg" style="padding: 7px 5px">
					<span><strong>IIJS Premiere 2021 Application 
					<?php if($data['application_approved']=='Y' && $data['trade_show']=='IIJS 2021'){ echo "Done"; } elseif($data['application_approved']=='N'){ echo "Disapproved";}else{echo "Pending";}?>  </strong></span>
					</div>			
				
				<?php } else {	?>
                    
					<form method="POST" enctype="multipart/form-data">
					<input type="hidden" name="actions" value="saveInfo">
					<input type="hidden" name="uid" value="<?php echo $_SESSION['USERID'];?>">
					<input type="hidden" name="eid" value="<?php echo $_REQUEST['eid'];?>">
					<strong>I am interested to visit</strong> 
					<table class="responsive_table newTable">
					<tr> 
						<td>	
							<select name="trade_show" class="select-control">
							<option value="IIJS 2021" selected="selected">IIJS Premiere 2021</option>
							</select> 	
						</td>
					</tr>
					
					<tr> 
						<td><input type="checkbox" name="agree" value="YES" checked="">
                    I also agree to receive information from GJEPC via Whatsapp & other Media   
						</td>
					</tr>
					<tr><td><input type="submit" name="submit" value="SUBMIT" class="cta"></td></tr>
					</table>					
					</form>
					<?php } 
					
					/*} else { ?>
                	<div class="maroonBtn" style="margin-right:10px;"><a href="i_v_r.php?id=<?php echo $eid; ?>">View Your Application </a></div>
					<!--<div class="maroonBtn"><a href="print_ack_ivr.php?id=<?php echo $eid; ?>" target="_blank">Print Acknowledgement</a></div>-->
					<?php } */ ?>
				
			
            </div>
            
              </div>  
              
              <table class="responsive_table newTable">
                  
                     <thead>
                     	<tr>
                        	<th>Personal Info approval</th>
                            <th>Photo Approval</th>
                            <th>Passport Approval</th>
                            <th>Visiting Card Approval</th>
                            <th>NRI Approval</th>
                        </tr>
                     </thead>
                     
                     <tbody>
                     
                     <?php $personal_info_reason=$data['personal_info_reason'];?>
                       <tr>

                       <td class="bold bgImage">Personal Info approval</td>
                       <td class="bgImage" data-column="Personal Info approval">
					   <?php
					   	if($data['personal_info_approval']=='Y')
							echo "Approved";	
						else if($data['personal_info_approval']=='P')
							echo "Pending";	
						else
							echo "Disapproved <span style='margin-left:50px;font-style:italic;'>$personal_info_reason</span>";	
					?>
                    </td>
                
                  </tr>
                  <?php $photo_reason=$data['photo_reason'];?>
                      <tr>
                        <td class="bold bgImage">Photo Approval</td>
                        <td class="bgImage" data-column="Photo Approval">
						<?php
					   	if($data['photo_approval']=='Y')
							echo "Approved";	
						else if($data['photo_approval']=='P')
							echo "Pending";	
						else
							echo "Disapproved <span style='margin-left:50px;font-style:italic;'>$photo_reason</span>";	
					?>
                    </td>
                  </tr>
                  <?php $valid_passport_copy_reason=$data['valid_passport_copy_reason'];?>
                      <tr>
                        <td class="bold bgImage">Passport Approval</td>
                        <td class="bgImage" data-column="Passport Approval">
						<?php
					   	if($data['valid_passport_copy_approval']=='Y')
							echo "Approved";	
						else if($data['valid_passport_copy_approval']=='P')
							echo "Pending";	
						else
							echo "Disapproved <span style='margin-left:50px;font-style:italic;'>$valid_passport_copy_reason</span>";	
					?>
                    </td>
                  </tr>
                       <?php $visiting_card_reason=$data['visiting_card_reason'];?>
                    <tr>
                    <td class="bold bgImage">Visiting Card Approval</td>
                    <td class="bgImage" data-column="Visiting Card Approval"><?php
					   	if($data['visiting_card_approval']=='Y')
							echo "Approved";	
						else if($data['visiting_card_approval']=='P')
							echo "Pending";	
						else
							echo "Disapproved <span style='margin-left:50px;font-style:italic;'>$visiting_card_reason</span>";	
					?></td>
                  </tr>
                  <?php $nri_photo_reason=$data['nri_photo_reason'];?>
                   <tr>
                    <td class="bold bgImage">NRI Approval</td>
                    <td class="bgImage" data-column="NRI Approval"><?php
					   	if($data['nri_photo_approval']=='Y')
							echo "Approved";	
						else if($data['nri_photo_approval']=='P')
							echo "Pending";	
						else
							echo "Disapproved <span style='margin-left:50px;font-style:italic;'>$nri_photo_reason</span>";	
					?></td>
                  </tr>  
                 
                  </tbody>                  
                  
                </table>
             <!--  <div class="right_area">    
			    <?php include('include_account_links.php'); ?>    
			  <div class="clear"></div>
			  </div>  -->

              <div class="clear"></div>              

	</div>
</div>

</div>

<div class="clear"></div>

<div class="footer">
	<?php include('footer.php'); ?>

</div>

<!--
<link rel="stylesheet" type="text/css" href="css/responsive.css" />
<link rel="stylesheet" type="text/css" href="css/media_query.css" />

NAV-->

<link href="css/flexnav.css?v=<?php echo $version;?>" media="screen, projection" rel="stylesheet" type="text/css">
<script src="js/jquery.flexnav.js?v=<?php echo $version;?>" type="text/javascript"></script>
<script src="js/common.js?v=<?php echo $version;?>"></script> 
<!--NAV-->
</body>
</html>
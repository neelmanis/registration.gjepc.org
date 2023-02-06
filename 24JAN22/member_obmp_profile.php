<?php include('header_include.php');
if(!isset($_SESSION['USERID'])){	header("location:login.php");	exit;	}
?>
<?php
$participate_for_show = 'signature22';
$year = '2022';
$saveOBMP = $_POST['saveOBMP'];
if($saveOBMP=="saveinfo")
{
	//print_r($_POST);
	$uid = intval(filter($_SESSION['USERID']));
	
	$pd_jewellery=implode(",",$_POST['pd_jewellery']);
	if(preg_match('/Any Other/',$pd_jewellery))
		$pd_jewellery_other=$_POST['pd_jewellery_other'];
	else
		$pd_jewellery_other="";
		
	$obj_of_visit=implode(",",$_POST['obj_of_visit']);
	if(preg_match('/Any Other/',$obj_of_visit))
		$oov_other=$_POST['oov_other'];
	else
		$oov_other="";
		
	$items_interested=implode(",",$_POST['items_interested']);
	if(preg_match('/Any Other/',$items_interested))
		$items_interested_other=$_POST['items_interested_other'];
	else
		$items_interested_other="";
	
	$how_you_learn_abt_iijs=implode(",",$_POST['how_you_learn_abt_iijs']);
	if(preg_match('/Any Other/',$how_you_learn_abt_iijs))
		$how_you_learn_abt_iijs_other=$_POST['how_you_learn_abt_iijs_other'];
	else
		$how_you_learn_abt_iijs_other="";
	
	$send_info_abt=implode(",",$_POST['send_info_abt']);
	if(preg_match('/Tours/',$send_info_abt))
		$send_info_abt_other=$_POST['send_info_abt_other'];
	else
		$send_info_abt_other="";
	$ip = $_SERVER['REMOTE_ADDR'];
	
	$sqlx= "SELECT * FROM `visitor_obmp_details` WHERE uid='$uid' AND participate_for_show='$participate_for_show' AND year='$year' LIMIT 1";
	$resultx = $conn->query($sqlx);
	$countx = $resultx->num_rows;
	if($countx > 0)
	{
		$updatequery="UPDATE `visitor_obmp_details` SET `modified_dt`=NOW(),`pd_jewellery`='".$pd_jewellery."',`pd_other`='".$pd_jewellery_other."',`obj_of_visit`='".$obj_of_visit."',`oov_other`='".$oov_other."',`how_you_learn_abt_iijs`='".$how_you_learn_abt_iijs."',`how_you_learn_abt_iijs_other`='".$how_you_learn_abt_iijs_other."',`obmp_approve`='P',`obmp_reason`='',`ip_address`='".$ip."',`obmp_application_status`='1' WHERE uid='$uid' AND participate_for_show='$participate_for_show' AND year='$year'";		
		$update_result = $conn->query($updatequery);
		if(!$update_result){ echo "Error: ".$conn->error; }
		header("location:visitor_registration.php");	exit;
	}	
	else
	{
		$insertquery="INSERT INTO `visitor_obmp_details`(`uid`, `pd_jewellery`, `pd_other`, `obj_of_visit`, `oov_other`, `how_you_learn_abt_iijs`, `how_you_learn_abt_iijs_other`, `participate_for_show`, `year`, `obmp_approve`, `obmp_reason`, `ip_address`, `obmp_application_status`) VALUES ('$uid','$pd_jewellery','$pd_jewellery_other','$obj_of_visit','$oov_other','$how_you_learn_abt_iijs','$how_you_learn_abt_iijs_other','$participate_for_show','$year','P','','$ip','1')";
		$insert_result = $conn->query($insertquery);
		if(!$insert_result){ echo "Error: ".$conn->error; }
		header("location:visitor_registration.php");	exit;
	}	
}
?>

<?php
	$uid = intval(filter($_SESSION['USERID']));
	$sql="SELECT * FROM `visitor_obmp_details` WHERE `uid`='$uid' and `participate_for_show`='$participate_for_show' AND `year`='$year' limit 1";
	$result=$conn->query($sql);
	$rows=$result->fetch_assoc();
	
	$pd_jewellery=$rows['pd_jewellery'];
	$pd_jewellery_other=$rows['pd_other'];
		
	$obj_of_visit=$rows['obj_of_visit'];
	$oov_other=$rows['oov_other'];
			
	$how_you_learn_abt_iijs=$rows['how_you_learn_abt_iijs'];
	$how_you_learn_abt_iijs_other=$rows['how_you_learn_abt_iijs_other'];
	$participate_for_show=$rows['participate_for_show'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<title>Company Profile</title>
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

<script type="text/javascript" src="js/member_directory.js?v=<?php echo $version;?>"></script>
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
function validation() {
		
		if( $('input[name="pd_jewellery[]"]:checked').length == 0)
		{
			$("#pd_error").text("Please select atleast one");
			$flag_pd=1;
		}
		else
			$flag_pd=0;
			
		if( $('input[name="obj_of_visit[]"]:checked').length == 0)
		{
			$("#obj_of_visit_error").text("Please select atleast one");
			$flag_obj=1;
		}
		else
			$flag_obj=0;
			
		if( $('input[name="how_you_learn_abt_iijs[]"]:checked').length == 0)
		{
			$("#how_you_learn_abt_iijs_error").text("Please select atleast one");
			$flag_learn=1;
		}
		else
			$flag_learn=0;
		
		if($flag_pd==1 || $flag_obj==1 || flag_learn==1)
			return false;
		else
			return true;
}
</script>
   
</head>

<body>
    <div class="wrapper">

	<div class="header">
		<?php include('header1.php'); ?>
	</div>

    <!--container starts-->
	
    <div class="container_wrap">
      <div class="container">
        <div class="container_leftn">
          <div class="breadcome"><a href="#">Home</a> > COMPANY PROFILE </div>
          <span class="headtxt">COMPANY PROFILE</span>
          <div id="loginForm">
            
            <div id="formContainer">
			
            <form method="post" id="form1" name="obmp_profile_ivr" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" onsubmit="return validation()">
			
            <div id="form">              
            <div class="title" style="margin:0;">
            <h4>Products Dealing in</h4>
            </div>
            
             <div class="clear"></div>
             <div class="borderBottom"></div>          
            
        <div class="field bottomSpace">            
        <div class="leftTitle" style="padding-top:0px;"><span id="pd_error" class="error_msg"></span></div>
        <div class="rightContent">               
            <ul class="matterText">               
            <li><input name="pd_jewellery[]" type="checkbox" value="Diamond Jewellery" <?php if(preg_match('/Diamond Jewellery/',$pd_jewellery)){ echo 'checked="checked"'; } ?>/>
            <span>Diamond Jewellery</span></li>                
            <li><input name="pd_jewellery[]" type="checkbox" value="Fine Gold Jewellery" <?php if(preg_match('/Fine Gold Jewellery/',$pd_jewellery)){ echo 'checked="checked"'; } ?>/>
            Fine Gold Jewellery</li>
			<li><input name="pd_jewellery[]" type="checkbox" value="platinum jewellery" <?php if(preg_match('/platinum jewellery/',$pd_jewellery)){ echo ' checked="checked"'; } ?>/>
            Platinum Jewellery</li>
			<li><input name="pd_jewellery[]" type="checkbox" value="Precious Stone Jewellery" <?php if(preg_match('/Precious Stone Jewellery/',$pd_jewellery)){ echo 'checked="checked"'; } ?>/>Precious Stone Jewellery</li>
			<li><input name="pd_jewellery[]" type="checkbox" value="silver jewellery" <?php if(preg_match('/silver jewellery/',$pd_jewellery)){ echo 'checked="checked"'; } ?>/>
            <span>Silver Jewellery</span></li>
            <li><input name="pd_jewellery[]" type="checkbox" value="loose diamonds" <?php if(preg_match('/loose diamonds/',$pd_jewellery)){ echo 'checked="checked"'; } ?>/>
            Loose Diamonds</li>                
            <li><input name="pd_jewellery[]" type="checkbox" value="Loose Colourstones" <?php if(preg_match('/Loose Colourstones/',$pd_jewellery)){ echo 'checked="checked"'; } ?>/>
            Loose Colourstones</li>                                
            <li><input name="pd_jewellery[]" type="checkbox" value="pearls" <?php if(preg_match('/pearls/',$pd_jewellery)){ echo ' checked="checked"'; } ?>/>
            Pearls</li>                
            <li><input name="pd_jewellery[]" type="checkbox" value="Lab Grown Diamond" <?php if(preg_match('/Lab Grown Diamond/',$pd_jewellery)){ echo 'checked="checked"'; } ?>/>
            Lab Grown Diamond</li>
			<li><input name="pd_jewellery[]" type="checkbox" value="Coated Diamond" <?php if(preg_match('/Coated Diamond/',$pd_jewellery)){ echo 'checked="checked"'; } ?>/>
            Coated Diamond</li>
			<li><input name="pd_jewellery[]" type="checkbox" value="cvd" <?php if(preg_match('/cvd/',$pd_jewellery)){ echo 'checked="checked"'; } ?>/>
            CVD / HPHT</li>                           
            <li>
            <input name="pd_jewellery[]" type="checkbox" id="other-pd-jewellery" value="Any Other" <?php if(preg_match('/Any Other/',$pd_jewellery)){ echo ' checked="checked"'; } ?>/><span> Any Other</span></li>
            </ul>
                            
        </div>
		<div class="clear" style="margin-bottom:8px;"></div>      
		<div class="tablewidth_101" style="display:none;" id="pd-jewellery-other-id"> 
		<div><label style="min-width:179px;">Any other, please specify: </label></div>
		<div>
		<input type="text" class="textField" name="pd_jewellery_other" id="edit-pd-jewellery-other" value="<?php echo $pd_jewellery_other; ?>" />
		</div>
		</div>
		<div class="clear"></div>
        </div>
            
        <div class="title"><h4>Objective of Visiting </h4></div>
        <div class="clear"></div>
        <div class="borderBottom"></div>
            
        <div class="field bottomSpace">            
           <span id="obj_of_visit_error" class="error_msg"></span>
            
            <div class="rightContent">               
            <ul class="matterText">
            <li><input name="obj_of_visit[]" type="checkbox" value="place orders" <?php if(preg_match('/place orders/',$obj_of_visit)){ echo "checked"; }?>/>
            Place Orders</li>
			<li><input name="obj_of_visit[]" type="checkbox" value="Meet Regular Suppliers" <?php if(preg_match('/Meet Regular Suppliers/',$obj_of_visit)){ echo "checked"; }?> />
            Meet Regular Suppliers</li>
			<li><input name="obj_of_visit[]" type="checkbox" value="source suppliers" <?php if(preg_match('/source suppliers/',$obj_of_visit)){ echo "checked"; }?> />
            Source New Suppliers</li>
			<li><input name="obj_of_visit[]" type="checkbox" value="joint ventures" <?php if(preg_match('/joint ventures/',$obj_of_visit)){ echo "checked"; }?>/>
            Joint Ventures</li>
			<li><input name="obj_of_visit[]" type="checkbox" value="market information" <?php if(preg_match('/market information/',$obj_of_visit)){ echo "checked"; }?>/>
            Market Information</li>			
            <li><input name="obj_of_visit[]" type="checkbox" value="Technology" <?php if(preg_match('/Technology/',$obj_of_visit)){ echo "checked"; }?>/>
            Technology</li>                
            <li><input name="obj_of_visit[]" type="checkbox" id="other-obj-of-visit" value="Any Other" <?php if(preg_match('/Any Other/',$obj_of_visit)){ echo "checked"; }?>/>
            <span> Any Other</span> </li>
            </ul>             
            </div>              
              
			<div class="clear" style="margin-bottom:8px;"></div>    
			<div class="tablewidth_101" style="display:none;" id="obj-of-visit-other-id"> 
				<div><label style="min-width:179px;">Any other, please specify: </label></div>
				<div>
				<input type="text" class="textField" name="oov_other" id="obj-of-visit-other" value="<?php echo $oov_other;?>" />
				</div>
			</div>
			<div class="clear"></div>      
		</div>
                
		<div class="title"><h4>How did you first came to know about the show</h4></div>
        <div class="clear"></div>
        <div class="borderBottom"></div>
            
          <div class="field bottomSpace">
          <span id="how_you_learn_abt_iijs_error" class="error_msg"></span>
            <div class="rightContent">
               
            <ul class="matterText">
            <li><input name="how_you_learn_abt_iijs[]" type="checkbox" value="Last year visited" <?php if(preg_match('/Last year visited/',$how_you_learn_abt_iijs)){ echo "checked"; }?>/>Last year visited</li>
			<li><input name="how_you_learn_abt_iijs[]" type="checkbox" value="Trade Association" <?php if(preg_match('/Trade Association/',$how_you_learn_abt_iijs)){ echo "checked"; }?>/>Trade Association</li>
			<li><input name="how_you_learn_abt_iijs[]" type="checkbox" value="publications" <?php if(preg_match('/publications/',$how_you_learn_abt_iijs)){ echo "checked"; }?>/>
            Publication</li>
			<li><input name="how_you_learn_abt_iijs[]" type="checkbox" value="trade fairs" <?php if(preg_match('/trade fairs/',$how_you_learn_abt_iijs)){ echo "checked"; }?>/>
            Trade Fair</li>
			<li><input name="how_you_learn_abt_iijs[]" type="checkbox" value="Exhibitors" <?php if(preg_match('/Exhibitors/',$how_you_learn_abt_iijs)){ echo "checked"; }?>/>
            Exhibitors</li>
			<li><input name="how_you_learn_abt_iijs[]" type="checkbox" value="website" <?php if(preg_match('/website/',$how_you_learn_abt_iijs)){ echo "checked"; }?>/>
            Website</li>
			<li><input name="how_you_learn_abt_iijs[]" type="checkbox" value="Newsletter & Emailers" <?php if(preg_match('/Newsletter & Emailers/',$how_you_learn_abt_iijs)){ echo "checked"; }?>/>Newsletter & Emailers</li>
			<li><input name="how_you_learn_abt_iijs[]" type="checkbox" value="Road Shows" <?php if(preg_match('/Road Shows/',$how_you_learn_abt_iijs)){ echo "checked"; }?>/>
            Road Shows</li>
			<li><input name="how_you_learn_abt_iijs[]" type="checkbox" value="promotional brochures" <?php if(preg_match('/promotional brochures/',$how_you_learn_abt_iijs)){ echo "checked"; }?>/>Promotional Brochures</li>
            <li><input name="how_you_learn_abt_iijs[]" type="checkbox" value="sms" <?php if(preg_match('/sms/',$how_you_learn_abt_iijs)){ echo "checked"; }?>/>
            SMS</li>                
			
            <li><input name="how_you_learn_abt_iijs[]" type="checkbox" value="Any Other" id="how_you_learn_abt_iijs_other" <?php if(preg_match('/Any Other/',$how_you_learn_abt_iijs)){ echo "checked"; }?>/>
            <span> Any Other</span>
			</li>
            </ul>
                  
            </div>              
              
			<div class="clear" style="margin-bottom:8px;"></div>
    
		  <div class="tablewidth_101" style="display:none;" id="how_you_learn_abt_iijs_other_id"> 
			<div><label style="min-width:179px;">Any other, please specify: </label></div>
			<div>
			<input type="text" class="textField" name="how_you_learn_abt_iijs_other" value="<?php echo $how_you_learn_abt_iijs_other; ?>" />
			</div>
		  </div>
		<div class="clear"></div>            
            </div>
                
			<input type="hidden" name="saveOBMP" value="saveinfo">
			<input type="submit" name="submit" value="Submit" class="newMaroonBtn"/>
            </div>
          </form>
            </div>
            </div>
          </div>
        </div>
      </div>
      
<div class="clear"></div>
</div>
<!--container ends-->
<!--footer starts-->
<div class="footer">
	<?php include('footer.php'); ?>
<div class="clear"></div>
</div>
<!--footer ends-->
</body>
</html>
<style type="text/css">
.submitbtn {
background: #e2e2e2;
border: none;
padding: 7px 15px;
margin-top: 15px;
}
.visitor_wrap{margin: 0 auto; display: table; width: 100%;}
.checkbox_field {display: inline-block;font-size: 15px; width: 33.33%; margin-bottom: 10px;}
.checkbox_field2 {display: inline-block;font-size: 15px; width: 20%; margin-bottom: 10px;}
.margin_t{margin-top:30px;}

#formContainer .title {margin-bottom: 0;
    display: table;
    width: auto;
    padding: 10px 2%;
    background: #000;
    color: #fff!important; width:96%;}
	#formContainer h4 {	color: #fff;
    padding: 0; font-size:14px; background:none!important;}
	#form {margin-bottom:20px;}
</style>
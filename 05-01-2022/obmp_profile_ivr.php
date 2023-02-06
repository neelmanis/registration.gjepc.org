<?php 
include('header_include.php');
	if(!isset($_SESSION['USERID'])){ header("location:login.php");	exit;	}
?> 
<?php
if(isset($_POST['submit']))
{
	$uid = intval($_SESSION['USERID']);
	$erp_code = "";
	$rules_reg="";
	$eid=$_POST['eid'];
	$action=$_REQUEST['action'];
	
	$iagree=filter($_POST["iagree"]);
	$iconfirm=filter($_POST["iconfirm"]);
	$intrested_in_iijs=filter($_POST["intrested_in_iijs"]);
	
	$rules_reg=$iagree.",".$iconfirm.",".$intrested_in_iijs;
	
	/*echo $rules_reg;*/
	
	$indian_passport =filter($_POST["indian_passport"]);
	$title =filter($_POST["title"]);  
	$first_name =filter(strtoupper($_POST["first_name"])); 
	$last_name =filter(strtoupper($_POST["last_name"]));
	$designation =filter(strtoupper($_POST["designation"]));
	$passport_no =filter($_POST["passport_no"]);
	$valid_upto =filter($_POST["valid_upto"]);
	$issue_place =filter($_POST["issue_place"]);
	$origin =filter($_POST["origin"]);
	$company_name =filter(strtoupper($_POST["company_name"]));
	$office_add =filter($_POST["office_add"]);
	$city =filter($_POST["city"]);
	$state =filter($_POST["state"]);
	$country =filter(strtoupper($_POST["country"]));
	$postal_code =filter($_POST["postal_code"]);
	$tel_no =filter($_POST["tel_no"]);
	$mob_no =filter($_POST["mob_no"]);
	
	$email =filter($_POST["email"]);
	
	$india_stay =filter($_POST["india_stay"]);
	if($india_stay=='hotel'){
		$hotel_name =filter($_POST["hotel_name"]);
		$hotel_address =filter($_POST["hotel_address"]);
		$stay_from =filter($_POST["stay_from"]);
		$stay_to =filter($_POST["stay_to"]);
		$name_of_person = "";
		$family_address = "";
		$family_contact = "";
		$family_relation = "";
		$family_stay_from = "";
		$family_stay_to = "";
	}else if($india_stay=='family'){
		$name_of_person = filter($_POST["name_of_person"]);
		$family_address = filter($_POST["family_address"]);
		$family_contact = filter($_POST["family_contact"]);
		$family_relation = filter($_POST["family_relation"]);
		$family_stay_from = filter($_POST["family_stay_from"]);
		$family_stay_to = filter($_POST["family_stay_to"]);
		$hotel_name = "";
		$hotel_address = "";
		$stay_from = "";
		$stay_to = "";
	}else{
		$hotel_name = "";
		$hotel_address = "";
		$stay_from = "";
		$stay_to = "";
		$name_of_person = "";
		$family_address = "";
		$family_contact = "";
		$family_relation = "";
		$family_stay_from = "";
		$family_stay_to = "";
	}			
	/*$company_profile = mysql_real_escape_string($_POST["company_profile"]);*/
	$trade_show="IIJS PREMIERE 2022";
	$time_stamp=date("Y-m-d h:i:s");
	$modified_date=date("Y-m-d h:i:s");
	$ip_add=$_SERVER['REMOTE_ADDR'];
	$personal_info_updated="yes";
	
	/*$chEmail = "select * from ivr_registration_details where email='$email'";
	$result = mysql_query($chEmail);
	$cnt = mysql_num_rows($result);
	if($cnt > 0)
	{
		echo "<script langauge=\"javascript\">alert(\"Email ID already in use\");location.href='i_v_r.php?action=addnew';</script>"; exit;
	} */
	
	if(!empty($email)){
	$sqlx1="select email from ivr_registration_details where email='$email' AND eid!='$eid'"; 
	$resultsqlx1 = $conn->query($sqlx1);
	$mysqlrows = $resultsqlx1->fetch_array();
	if($mysqlrows[0] == $email)
	{
		echo '<script language="javascript">';	echo 'alert("Email Id Already Exist")';	echo '</script>'; 
		echo "<meta http-equiv=refresh content=\"0;url=intl_employee_directory.php\">";
		exit;  
	}
	}

	$chEmail = "select passport_no from ivr_registration_details where passport_no='$passport_no' and eid!='$eid'";
	$results = $conn->query($chEmail);
	$mysqlrow=$results->fetch_assoc();
	//echo $mysqlrow[0]; exit;
	if($mysqlrow[0] == $passport_no)
	{
		echo "<script langauge=\"javascript\">alert(\"Passport No already in use\");location.href='i_v_r.php?action=addnew';</script>"; exit;
	}
	
 	$insertstep1="insert into ivr_registration_details set uid='".$uid."',erp_code='".$erp_code."',rules_reg='".$rules_reg."',indian_passport='".$indian_passport."',title='".$title."',first_name='".$first_name."',last_name='".$last_name."',designation='".$designation."',passport_no='".$passport_no."',valid_upto='".$valid_upto."',issue_place='".$issue_place."',origin='".$origin."',company_name='".$company_name."',office_add='".$office_add."',city='".$city."',state='".$state."',country='".$country."',postal_code='".$postal_code."',tel_no='".$tel_no."',mob_no='".$mob_no."',email='".$email."',website='".$website."',india_stay='".$india_stay."',hotel_name='".$hotel_name."',hotel_address='".$hotel_address."',stay_from='".$stay_from."',stay_to='".$stay_to."',name_of_person='".$name_of_person."',family_address='".$family_address."',family_contact='".$family_contact."',family_relation='".$family_relation."',family_stay_from='".$family_stay_from."',family_stay_to='".$family_stay_to."',trade_show='".$trade_show."',time_stamp='".$time_stamp."',modified_date='".$modified_date."',ip_add='".$ip_add."'"; 
		
	$select="SELECT * FROM ivr_registration_details where uid='$uid' and eid='$eid'";
	$count_result=$conn->query($select);
	$count=$count_result->num_rows;
	
	if($count==0 || $action=="addnew")
	{
		//echo $insertstep1;exit;
		$insert_result = $conn->query($insertstep1);
		if(!$insert_result){
			die($conn->error);	
		}
		else
		{
			header("location:obmp_profile_ivr.php");			exit;
		}
	} else {
		$updatestep1="update ivr_registration_details set erp_code='".$erp_code."',rules_reg='".$rules_reg."',indian_passport='".$indian_passport."',title='".$title."',first_name='".$first_name."',last_name='".$last_name."',designation='".$designation."',passport_no='".$passport_no."',valid_upto='".$valid_upto."',issue_place='".$issue_place."',origin='".$origin."',company_name='".$company_name."',office_add='".$office_add."',city='".$city."',state='".$state."',country='".$country."',postal_code='".$postal_code."',tel_no='".$tel_no."',mob_no='".$mob_no."',email='".$email."',website='".$website."',india_stay='".$india_stay."',hotel_name='".$hotel_name."',hotel_address='".$hotel_address."',stay_from='".$stay_from."',stay_to='".$stay_to."',name_of_person='".$name_of_person."',family_address='".$family_address."',family_contact='".$family_contact."',family_relation='".$family_relation."',family_stay_from='".$family_stay_from."',family_stay_to='".$family_stay_to."',trade_show='".$trade_show."' where uid='$uid' and eid = '$eid'";		
	    //echo $updatestep1;exit;
		
		$insert_result = $conn->query($updatestep1);
		$get_approval=$count_result->fetch_assoc;

		$personal_info_approval=$get_approval['personal_info_approval'];
		if($personal_info_approval=='N')
		{
			$update_query="update ivr_registration_details set personal_info_approval='P' where uid='$uid'";
			$result_update=$conn->query($update_query);
			
			if(!$result_update)
				die($conn->error);
		}
	}
	/*$insert_result = mysql_query($insertstep1);*/
}
?>

<!-- fetch and show data -->
<?php
	$uid=$_SESSION['USERID'];
	if(isset($_REQUEST['eid']) && $_REQUEST['eid']!='')
		$sql="SELECT * FROM `ivr_registration_details` WHERE uid=$uid and eid=".$_REQUEST['eid']." order by eid desc limit 1";
	else
		$sql="SELECT * FROM `ivr_registration_details` WHERE uid=$uid order by eid desc limit 1";
	
	$result=$conn->query($sql);
	$rows=$result->fetch_assoc();
	
	$eid=$rows['eid'];
	
	$pd_jewellery=$rows['pd_jewellery'];
	$pd_jewellery_other=$rows['pd_jewellery_other'];
	$no_of_years=$rows['no_of_years'];
	$emp_strength=$rows['emp_strength'];
	$no_of_branches=$rows['no_of_branches'];
	$turnover=$rows['turnover'];
	
	$obj_of_visit=$rows['obj_of_visit'];
	$oov_other=$rows['oov_other'];
	
	$import_frm=$rows['import_frm'];
	$import_frm_other=$rows['import_frm_other'];
	
	$items_interested=$rows['items_interested'];
	$items_interested_other=$rows['items_interested_other'];
	$caratage_pref=$rows['caratage_pref'];
	
	$dr_size_frm=$rows['dr_size_frm'];
	$dr_clarity=$rows['dr_clarity'];
	$dr_colour_shade=$rows['dr_colour_shade'];
	$dr_from=$rows['dr_from'];
	$dr_to=$rows['dr_to'];
	
	$cgr_name_stone=$rows['cgr_name_stone'];
	$cgr_size_frm=$rows['cgr_size_frm'];
	$cgr_size_to=$rows['cgr_size_to'];
	$cgr_shape=$rows['cgr_shape'];
	$cgr_colour_shade=$rows['cgr_colour_shade'];
	$cgr_from=$rows['cgr_from'];
	$cgr_to=$rows['cgr_to'];
	
	$how_you_learn_abt_iijs=$rows['how_you_learn_abt_iijs'];
	$how_you_learn_abt_iijs_other=$rows['how_you_learn_abt_iijs_other'];
	
	$send_info_abt=$rows['send_info_abt'];
	$send_info_abt_other=$rows['send_info_abt_other'];
	$would_you_like=$rows['would_you_like'];
	$personal_info_approval=$rows["personal_info_approval"];
	$trade_show1=$rows['trade_show'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>OBMP PROFILE </title>
<link rel="shortcut icon" href="images/fav.png" />
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
<script type="text/javascript">
    $(document).ready(function() {        
        $().UItoTop({ easingType: 'easeOutQuart' });        
    });
</script>
<!-- form -->

<link rel="stylesheet" type="text/css" href="css/form.css?v=<?php echo $version; ?>"/>
<link rel="stylesheet" type="text/css" media="screen" href="css/rcmc.validation.css?v=<?php echo $version; ?>" /> 
<script type="text/javascript" src="js/member_directory.js"></script>

<script type="text/javascript">
function validation() {
		
		if( $('input[name="pd_jewellery[]"]:checked').length == 0)
		{
			$("#pd_error").text("please select atleast one");
			$flag_pd=1;
		}
		else
			$flag_pd=0;
			
		if( $('input[name="obj_of_visit[]"]:checked').length == 0)
		{
			$("#obj_of_visit_error").text("please select atleast one");
			$flag_obj=1;
		}
		else
			$flag_obj=0;
			
		if( $('input[name="how_you_learn_abt_iijs[]"]:checked').length == 0)
		{
			$("#how_you_learn_abt_iijs_error").text("please select atleast one");
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

<div class="inner_container">

			<div class="bold_font text-center">
    <div class="d-block">
        <img src="https://www.gjepc.org/assets/images/gold_star.png" class="">
    </div>
    International Visitor Registration
</div>  
  <div class="clear"></div>
    
    <div class="content_area box-shadow">    
    
    <div id="">
    <div id="">            
            
    <div class="tabb_link">
    	<div><a href="#" class="tab"> <span class="no">1</span> Personal <br>Information</a></div>
    	<div><a href="#" class="tab current"> <span class="no">2</span> OBMP <br>Information   <span class="dwn_arw"></span></a></div>
    	<div><a href="#" class="tab"> <span class="no">3</span> Upload <br>Documents</a></div> 
    <div class="clear"></div>    
    </div>
        <div class="clear"></div>
            
        <form method="post" id="form1" name="obmp_profile_ivr" action="photo_form_ivr.php" onsubmit="return validation()" >
            <div id="form">
			<?php  $eid; ?>
            <input type="hidden" name="eid" value="<?php echo $eid; ?>"/>
            <input type="hidden" name="abc" value="mukesh"/>
                                   
            <div class="title">
            Products Dealing in
            </div>
            
             <div class="clear"></div>
             <div class="borderBottom"></div>            
            
            <div class="field bottomSpace">
            
            <div class="leftTitle" style="padding-top:0px;">Jewellery : <sup>*</sup> <span id="pd_error" class="error_msg"></span></div>
            
               <div class="rightContent" style="width:100%;">
               
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
            
            <div class="title">
            Objective of Visiting 
            </div>
            <div class="clear"></div>
             <div class="borderBottom"></div>
            
          <div class="field bottomSpace">
            
           <span id="obj_of_visit_error" class="error_msg"></span>
            
               <div class="rightContent" style="width:100%;">
               
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
            
          <div class="title">
            How did you first learn about the show
            </div>
            
            <div class="clear"></div>
             <div class="borderBottom"></div>
            
          <div class="field bottomSpace">
          <span id="how_you_learn_abt_iijs_error" class="error_msg"></span>
               <div class="rightContent" style="width:100%;">
               
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
        <div class="clear"></div>
            
        <?php if($personal_info_approval!='Y'){ ?>
        <div class="maroonBtn">
        <input type="submit" name="submit" value="Next" class="cta" />     
        </div>
        <?php } ?>
          
		<?php if($personal_info_approval=='Y'){ ?>
        <div class="maroonBtn" style="margin-right:10px;"><a href="photo_form_ivr.php?eid=<?php echo $_REQUEST['eid'];?>">Next</a></div> <div class="maroonBtn"><a href="i_v_r.php">Previous</a></div>
        <?php } ?>      
        </div>
	</form>          
                       
            <div class="clear"></div>
            </div>            
            <div class="clear"></div>
            </div>	   
    <div class="clear"></div>
	</div>

<div class="clear" style="height:10px;"></div>
</div>

<div class="footer">
	<?php include('footer.php'); ?>
<div class="clear"></div>
</div>

<div class="clear"></div>
</div>

</body>
</html>
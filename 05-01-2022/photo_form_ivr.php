<?php 
include('header_include.php');
if(!isset($_SESSION['USERID'])){	header("location:login.php");	exit; }
?> 
<?php
$eid = $_REQUEST['eid'];
if($_POST){
	if(isset($_REQUEST['pd_jewellery']))
	{
		$uid = $_SESSION['USERID'];
		$erp_code = "";
		$rules_reg="";
		$eid=$_POST['eid'];
		
		if(isset($eid) && $eid!=''){
				$select="SELECT * FROM ivr_registration_details where uid='$uid' and eid='$eid'";
		} else {
				$select="SELECT * FROM ivr_registration_details where uid='$uid' order by eid desc limit 1";
		}
		$count_result=$conn->query($select);
		$count=$count_result->num_rows;
		$rows = $count_result->fetch_assoc();
		$eid = $rows['eid'];
	
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
		
		$would_you_like=$_POST['would_you_like'];
		
		$updatequery="update ivr_registration_details set pd_jewellery='".$pd_jewellery."',pd_jewellery_other='".$pd_jewellery_other."',obj_of_visit='".$obj_of_visit."',oov_other='".$oov_other."',how_you_learn_abt_iijs='".$how_you_learn_abt_iijs."',how_you_learn_abt_iijs_other='".$how_you_learn_abt_iijs_other."',send_info_abt='".$send_info_abt."',send_info_abt_other='".$send_info_abt_other."',would_you_like='".$would_you_like."' where uid='$uid' AND eid = '$eid'";		
		$update_result = $conn->query($updatequery);
		}
	}
?>

<?php
	if(isset($eid) && $eid!='')
		$sql1="SELECT * FROM `ivr_registration_details` WHERE uid='".$_SESSION['USERID']."' and eid='$eid' limit 1";
	else
		$sql1="SELECT * FROM `ivr_registration_details` WHERE uid='".$_SESSION['USERID']."' order by eid desc limit 1";		

	$result1=$conn->query($sql1);
	$rows1=$result1->fetch_assoc();	
	$indian_passport=$rows1['indian_passport'];
//	echo $eid=$rows1['eid'];
?>
<?php
	$uid=$_SESSION['USERID'];
	
	if(isset($eid) && $eid!='')
		$sql="SELECT * FROM `ivr_registration_details` WHERE uid='$uid' and eid='$eid' and photograph_fid!='' order by eid desc limit 1";
	else
		$sql="SELECT * FROM `ivr_registration_details` WHERE uid='$uid' and photograph_fid!='' order by eid desc limit 1";
	
	$result=$conn->query($sql);
	$rows=$result->fetch_assoc();	
	$personal_info_approval=$rows['personal_info_approval'];
	$applicationStatus = $rows["application_approved"];
	$photo_approval=$rows['photo_approval'];
	$photo_reason=$rows['photo_reason'];
	$valid_passport_copy_approval=$rows['valid_passport_copy_approval'];
	$valid_passport_copy_reason=$rows['valid_passport_copy_reason'];
	$visiting_card_approval=$rows['visiting_card_approval'];
	$visiting_card_reason=$rows['visiting_card_reason'];
	$nri_photo_approval=$rows['nri_photo_approval'];
	$nri_photo_reason=$rows['nri_photo_reason'];
	$trade_show=$rows['trade_show'];
		
		$passport_fid=$rows['passport_fid'];
		if($passport_fid=="")
		{
		$passportsql="SELECT b.fid, b.filename as passport_fid FROM  `ivr_registration_details` a, files b WHERE a.`passport_fid` = b.fid AND a.`uid` ='$uid' and a.`eid`='$eid'";	
		$passportresult=$conn->query($passportsql);
		$passportrows=$passportresult->fetch_assoc();
		$passport_fid=$passportrows['passport_fid'];
		}	
	
		$visit_card_fid=$rows['visit_card_fid'];
		if($visit_card_fid=="")
		{
		$visitsql="SELECT b.fid, b.filename as visit_card_fid FROM  `ivr_registration_details` a, files b WHERE a.`visit_card_fid` = b.fid AND a.`uid` ='$uid' and a.`eid`='$eid'";	
		$visitresult=$conn->query($visitsql);
		$visitrows=$visitresult->fetch_assoc();	
		$visit_card_fid=$visitrows['visit_card_fid'];
		}	
	
		$photograph_fid=$rows['photograph_fid'];
		if($photograph_fid=="")
		{
		$photosql="SELECT b.fid, b.filename as photograph_fid FROM  `ivr_registration_details` a, files b WHERE a.`photograph_fid` = b.fid AND a.`uid` ='$uid' and a.`eid`='$eid'";	
		$photoresult=$conn->query($photosql);
		$photorows=$photoresult->fetch_assoc();
		$photograph_fid=$photorows['photograph_fid'];
		}

	$nri_fid=$rows['nri_fid'];
	if($nri_fid=="")
		{
			$nrisql="SELECT b.fid, b.filename as nri_fid FROM  `ivr_registration_details` a, files b WHERE a.`nri_fid` = b.fid AND a.`uid` ='$uid' and a.`eid`='$eid'";	
			$nriresult=$conn->query($nrisql);
			$nrirows=$nriresult->fetch_assoc();	
			$nri_fid=$nrirows['nri_fid'];
		}
	
	$apply_visa=$rows['apply_visa'];
	$email_notification=$rows['email_notification'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Upload Documents</title>
<link rel="shortcut icon" href="images/fav.png" />
<link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Cabin'>
<link rel="stylesheet" type="text/css" href="css/general.css?v=<?php echo $version;?>" />
<link rel="stylesheet" type="text/css" href="css/inner_pg_style.css?v=<?php echo $version;?>" />
<script type="text/javascript" src="js/jquery-1.3.2.min.js?v=<?php echo $version;?>"></script>
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

<link rel="stylesheet" type="text/css" href="css/form.css"/>
<style>
	.note strong{font-weight: 700;color: red}
	.status {   margin-right: 210px;  font-weight: bold; }
</style>
<script>
function check_extension(file_name)
{
	var result=file_name.split('.').pop();
	if(result=="gif" || result=="jpeg" || result=="jpg" || result=="png" || result=="GIF" || result=="JPEG" || result=="JPG" || result=="PNG" )
		return true;
	else
		return false;
}

function check_vax_extension(file_name)
{
	var result=file_name.split('.').pop();
	if(result=="jpeg" || result=="jpg" || result=="png" || result=="JPEG" || result=="JPG" || result=="PNG" || result=="pdf" || result=="pdf" )
		return true;
	else
		return false;
}
function validation(){
		
	/* photograph validation */
	var photograph_fid=document.getElementById("photograph_fid").value;
	var photo_ext=check_extension(photograph_fid);
	
	if(photograph_fid==""){
		document.getElementById("photograph_error").innerHTML="Please Select file";
		/*flag_photo=1; */
		document.getElementById('photograph_fid').focus();
		return false;
	}
	else if(!photo_ext){
		document.getElementById("photograph_error").innerHTML="Invalid File";
		/*flag_photo=1;  */
		document.getElementById('photograph_fid').focus();
		return false;
	} else {
		document.getElementById("photograph_error").innerHTML="";
		/*flag_photo=0; */
	}
	
	/* passport validation */
	
	var passport_fid=document.getElementById("passport_fid").value;
	var passport_ext=check_extension(passport_fid);
	
	if(passport_fid==""){
		document.getElementById("passport_error").innerHTML="Please Select file";
		/*flag_pass=1;*/
		document.getElementById('passport_fid').focus();
		return false;
	}
	else if(!passport_ext){
		document.getElementById("passport_error").innerHTML="Invalid File";
		/*flag_pass=1;*/
		document.getElementById('passport_fid').focus();
		return false;
	}else{
		document.getElementById("passport_error").innerHTML="";
		/*flag_pass=0;*/
	}
	
	/* visiting card validation */
	var visiting_card_fid=document.getElementById("visiting_card_fid").value;
	var visiting_card_ext=check_extension(visiting_card_fid);
	
	if(visiting_card_fid==""){
		document.getElementById("visiting_error").innerHTML="Please Select file";
		/*flag_visit=1;*/
		return false;	
	}
	else if(!visiting_card_ext){
		document.getElementById("visiting_error").innerHTML="Invalid File";
		/*flag_visit=1;*/
		return false;
	}else{
		document.getElementById("visiting_error").innerHTML="";
		/*flag_visit=0;*/
	}
	
}

function validatepass(){
		
}

function validatevisit(){	
	
}

function validatenri(){	
	/* nri validation */
	var nri_fid=document.getElementById("nri_fid").value;
	var nri_ext=check_extension(nri_fid);
		
	if(nri_fid==""){
		document.getElementById("nri_error").innerHTML="Please Select file";
		/*flag_nri=1;*/
		return false;
	}
	else if(!nri_ext){
		document.getElementById("nri_error").innerHTML="Invalid File";
		/*flag_nri=1;*/
		return false;
	}
	else{
		document.getElementById("nri_error").innerHTML="";
		/*flag_nri=0;*/
	}
	
}

//if(flag_photo==1 || flag_pass==1 || flag_visit==1 || flag_nri==1)
/*if(flag_photo==1 )
		return false;
	else
		return true; */
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
    <div class="clear"></div>
    <div id="">
    <div id="">
			
	<form id="form1" enctype="multipart/form-data" method="post" action="international_visitor_registration.php" onsubmit="return validation()" >
            <input name="action" value="SEND" type="hidden" />
            <input name="photograph_fid1" value="<?php echo $photograph_fid;?>" type="hidden" />
            <input name="passport_fid1" value="<?php echo $passport_fid;?>" type="hidden" />
            <input name="visit_card_fid1" value="<?php echo $visit_card_fid;?>" type="hidden" />
            <input name="nri_fid1" value="<?php echo $nri_fid;?>" type="hidden" />
                       
    <div class="tabb_link">
    	<div><a href="#" class="tab"> <span class="no">1</span> Personal <br>Information</a></div>
    	<div> <a href="#" class="tab"> <span class="no">2</span> OBMP <br>Information  </a> </div>
    	<div><a href="#" class="tab current"> <span class="no">3</span> Upload <br>Documents <span class="dwn_arw"></span></a></div>

    <div class="clear"></div>    
    </div>
            <div class="clear"></div>
            <div id="form">
	
			<!-- ---------------------first photo start---------------------------------------->
            <div class="title"><b>Photograph</b></div>
            <div class="clear"></div>
            <div class="borderBottom"></div>
            <div class="field bottomSpace">
                <div class="userPic">
                <?php if($photograph_fid=="")
				{
					echo "<img src='images/noprofile.jpg' width='100' height='100'/>";
 				} else { 
                  echo  "<img src='images/ivr_image/photograph/$photograph_fid' width='100' height='100' alt='' />";
                }				
				?>
				</div>
                
                <div class="leftFile">
                <div class="midTitle">Kindly upload Passport Size Colour Photograph <sup>*</sup> </div>                
                <div class="clear"></div>
                <!--<p><strong>Filename</strong></p>-->
				<input name="photograph_fid" id="photograph_fid" type="file" class="textField" style="margin-bottom:10px; background:#fff;" <?php if($photo_approval=='Y'){?> disabled="disabled" <?php } ?>/>
                <span id="photograph_error" class="error_msg"></span>
                </div>
                
                <div class="approval">
                <div class="status">Approval Status :</div>
                <div class="appr">
				<?php 
                if($photo_approval=='P')
                echo "Pending";
                else if($photo_approval=='Y')
                echo "Approved";
                else if($photo_approval=='D')
                echo "Disapproved  <span style='margin-left:50px;font-style:italic;'>$photo_reason</span>";	
                ?>
                </div>
                </div>
                
                <span id="photograph_fid_msg"></span>
                <div class="clear"></div>
                <div class="note">
                    <strong>Only JPEG, PNG  images are allowed.</strong> <br>
                    <strong>The maximum upload size is 2MB.</strong><br>
                    Changes made are not permanent until you save this form.
                </div>
                <div class="clear"></div>
            </div>
			<!-- ---------------------first photo end---------------------------------------->
         
            <!-- ---------------------second photo start---------------------------------------->
            <div class="clear"></div>
			<div class="title"><b>Valid Passport Copy</b></div>
            <div class="clear"></div>
            <div class="borderBottom"></div>
            <div class="field bottomSpace">
            <div class="userPic">
             <?php if($passport_fid=="")
			 {
				echo "<img src='images/noprofile.jpg' width='100' height='100' />";
			 } else { 
                  echo  "<img src='images/ivr_image/passport/$passport_fid' width='100' height='100' alt='' />";
             } 
			 ?>
            </div>
            
            <div class="leftFile">
             <div class="midTitle">Kindly upload a Passport Copy with Photograph &amp; validity <sup>*</sup> </div>
             <div class="clear"></div>
             <!--<p><strong>Filename</strong></p>-->
             <input name="passport_fid" type="file" class="textField" style="margin-bottom:10px; background:#fff;" id="passport_fid" <?php if($valid_passport_copy_approval=='Y'){?> disabled="disabled" <?php } ?> /> <br>
             <span id="passport_error" class="error_msg"></span>
            </div>
            
            <div class="approval">
                <div class="status">Approval Status :</div>
                <div class="appr">
                <?php 
                if($valid_passport_copy_approval=='P')
                echo "Pending";
                else if($valid_passport_copy_approval=='Y')
                echo "Approved";
                else if($photo_approval=='D')
                echo "Disapproved  <span style='margin-left:50px;font-style:italic;'>$valid_passport_copy_reason</span>";	
                ?>
                </div>
            </div>
            
            <div class="clear"></div>
            <div class="note"><strong>Only JPEG, PNG images are allowed.</strong> <br><strong>The maximum upload size is 2MB.</strong><br>
            	Changes made are not permanent until you save this form.</div>
            <div class="clear"></div>
            </div>
			<!-- ---------------------second photo end---------------------------------------->
            
            <!-- ---------------------third photo start---------------------------------------->
            <div class="clear"></div>
			<div class="title"><b>Business / Visiting Card</b></div>
            <div class="clear"></div>
            <div class="borderBottom"></div>
			
            <div class="field bottomSpace">
            <div class="userPic">
            <?php if($visit_card_fid=="")
			{
				echo "<img src='images/noprofile.jpg' width='100' height='100' />";
			}else
			{ 
            	echo "<img src='images/ivr_image/visiting_card/$visit_card_fid' width='100' height='100' alt='' />";
            } 
			?>
            </div>

            <div class="leftFile">
            <div class="midTitle">Kindly upload a Business / Visiting Card with your Name &amp; company details on it : <sup>*</sup> </div>
                <div class="clear"></div>
            <!--<p><strong>Filename</strong></p>-->
            <input name="visiting_card_fid" id="visiting_card_fid" type="file" class="textField" style="margin-bottom:10px; background:#fff;" <?php if($visiting_card_approval=='Y'){?> disabled="disabled" <?php } ?> /><br>
            <span id="visiting_error" class="error_msg"></span>
            <div class="clear"></div>
            </div>

            <div class="approval">
            <div class="status">Approval Status :</div>
            <div class="appr">
           <?php 
            if($visiting_card_approval=='P')
            echo "Pending";
            else if($visiting_card_approval=='Y')
            echo "Approved";
            else if($visiting_card_approval=='D')
            echo "Disapproved  <span style='margin-left:50px;font-style:italic;'>$visiting_card_reason</span>";	
            ?>
             </div>
            </div>

            <div class="clear"></div>
            <div class="note"><strong>Only JPEG, PNG  images are allowed.</strong> <br>
            	<strong>The maximum upload size is 2MB.</strong><br>Changes made are not permanent until you save this form.</div>
            <div class="clear"></div>
			</div>
            <!-- ---------------------third photo end---------------------------------------->
            <div class="clear"></div>			
			
            <div class="clear"></div>
          
			
            <!-- ---------------------fourth photo start---------------------------------------->
			<?php if($indian_passport=="yes"){ ?>

            <div class="title"><h4>NRI Status Proof</h4></div>
            <div class="clear"></div>
            <div class="borderBottom"></div>
			<div class="field bottomSpace">
            <div class="userPic">
            <?php if($nri_fid=="")
			{
				echo "<img src='images/noprofile.jpg' width='100' height='100' />";	
			} else { 
            	echo  "<img src='images/ivr_image/nri/$nri_fid' width='100' height='100' alt='' />";
            } ?>
            </div>
            <div class="leftFile">
            <div class="midTitle">NRI Proof is required only if you have <br />Indian passport (* Residential proof/card/Green <br />card/Driving license/ work permit)  : <sup>*</sup> </div>
            <!--<p><strong>Filename</strong></p>-->
             <input name="nri_fid" id="nri_fid" type="file" class="textField" style="margin-bottom:10px; background:#fff;" <?php if($nri_photo_approval=='Y'){?> disabled="disabled" <?php } ?>/><br><span id="nri_error" class="error_msg"></span>
            </div>
			
            <div class="approval">
            <div class="status">Approval Status :</div>
            <div class="appr">
            <?php 
            if($nri_photo_approval=='P')
            echo "Pending";
            else if($nri_photo_approval=='Y')
            echo "Approved";
            else if($photo_approval=='D')
            echo "Disapproved  <span style='margin-left:50px;font-style:italic;'>$nri_photo_reason</span>";	
            ?>
            </div>
            </div>

            <div class="clear"></div>
            <div class="note"><strong>Only JPEG, PNG images are allowed.</strong> 
             <br /><strong>The maximum upload size is 2MB.</strong><br />Changes made are not permanent until you save this form.</div>
			<br />
			<strong>Check your spam folder in-case you do not receive our mails in your inbox.</strong>
            <div class="clear"></div>
			</div>
			<?php } ?>
            <!-- ---------------------fourth photo end---------------------------------------->
        <div class="clear"></div>
        <div class="borderBottom"></div>
		<p><input type="checkbox"  name="apply_visa" value="1" <?php if($apply_visa=="1"){ echo 'checked="checked"'; } ?>/>Apply for Visa Recommendation Letter</p> 
		<?php 
		if($personal_info_approval!='Y' || $photo_approval!='Y' ||	$valid_passport_copy_approval!='Y' || $visiting_card_approval!='Y' || $nri_photo_approval!='Y')
		{
		?>
        
      <!-- 24July2018<div class="maroonBtn" id="submit" style="margin-right:10px;"><a href="photo_form_ivr.php?action=check">Submit</a></div>-->
       <div class="clear"></div>
      <input type="submit" name="input" value="Submit" class="cta" />
        <?php } ?>
        <input type="hidden" name="eid"  value="<?php echo $eid; ?>"/>
        <?php if($personal_info_approval=='Y' && $photo_approval=='Y' && $valid_passport_copy_approval=='Y' && $visiting_card_approval=='Y' && $nri_photo_approval=='Y'){ ?>  

        <div class="maroonBtn col-100" style="margin-right:10px;"><a href="international_visitor_registration.php">Next</a></div>
        <div class="maroonBtn"><a href="obmp_profile_ivr.php">Previous</a></div>
        <?php } ?> 
        <div class="clear"></div>
        </div>         
        </div>
		</form>
        </div>
	   
    <div class="clear"></div>
	</div>

	<div class="right_area">    
    <?php //include('include_account_links.php'); ?>    
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

<?php 
if(isset($_REQUEST["action"]))
{
	if($_REQUEST["action"]=="check")
	{
		if($photograph_fid=="" || $passport_fid=="" || $visit_card_fid=="" || ($indian_passport=="yes" && $nri_fid==""))
		{
			echo "<script language='javascript'>alert('Please upload all the photograph required')</script>";
			echo "<script language='javascript'>window.location.href='photo_form_ivr.php'</script>";
		} else	{
			header("location:international_visitor_registration.php?update=t");
			exit;
		}
	}
}
?>
</body>
</html>
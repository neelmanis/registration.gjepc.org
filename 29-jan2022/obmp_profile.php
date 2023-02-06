<?php include('header_include.php');?>
<?php if(!isset($_SESSION['USERID'])){header('location:login.php');}?>

<?php
$registration_id=$_SESSION['USERID'];
//echo "====>".$registration_id; 
$sqly="SELECT * FROM `registration_master` where id=$registration_id";
$results=$conn->query($sqly);
$rowx=$results->fetch_assoc();

//echo "---------".$rowx['first_name'];
$fname=$rowx['first_name'];
$lname=$rowx['last_name'];
$co_name=$rowx['company_name'];
//$designation=$rowx['designation'];
//echo "---->".$designation;

$sql="SELECT * FROM `member_directory` WHERE 1 and registration_id=$registration_id";
$result=$conn->query($sql);
$rows=$result->fetch_assoc();
//print_r($rows);
$company_name=$rows['company_name'];
$contact_person=$rows['contact_person'];
$usertype=$rows['buy_sell_profile_code'];
if($usertype==""){$usertype="NM";}

$designation=$rows['designation'];
$website=$rows['website'];
$write_up=$rows['write_up'];
$wa_jewellery=$rows['wa_jewellery'];
$pos=strpos($wa_jewellery, 'other,');
$wa_jewellery_other=substr($wa_jewellery, $pos+6);

$pd_jewellery=$rows['pd_jewellery'];
$pos=strpos($pd_jewellery, 'other,');
$pd_jewellery_other=substr($pd_jewellery, $pos+6);

$item_description=$rows['item_description'];
$pos=strpos($item_description, 'other,');
$item_description_other=substr($item_description, $pos+6);

$focus=explode(",",$rows['item_desc_other']);
$get_other = implode(",", $focus);
//$start=$rows['starts'];
//echo "------------>".$get_other;
//echo "++++++++++>".$starts;

$focus1=explode(",",$rows['wa_other']);
$get_other1 = implode(",", $focus1);
//$start1=$rows['start1'];

$focus2=explode(",",$rows['pd_jewellery_other']);
$get_other2 = implode(",", $focus2);

$d_size=$rows['d_size'];
$d_clarity=$rows['d_clarity'];
$d_color_shade=$rows['d_color_shade'];
$d_pp_from=$rows['d_pp_from'];
$d_pp_to=$rows['d_pp_to'];
$cgs_stone=$rows['cgs_stone'];
$cgs_shade=$rows['cgs_shade'];
$cgs_shape=$rows['cgs_shape'];
$cgs_quantity=$rows['cgs_quantity'];
$cgs_pp_from=$rows['cgs_pp_from'];
$cgs_pp_to=$rows['cgs_pp_to'];
$product_logo=$rows['product_logo'];
$company_logo=$rows['company_logo'];
//$catalog_image=$rows['catalog_image'];
$support_images=$rows['support_images'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>IIJS - OBMP > OBMP Profile </title>
<link rel="shortcut icon" href="images/fav.png" />
<link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Cabin'>

<link rel="stylesheet" type="text/css" href="css/general.css" />
<link rel="stylesheet" type="text/css" href="css/inner_pg_style.css" />
<link rel="stylesheet" type="text/css" href="css/form.css" />
<link rel="stylesheet" type="text/css" href="css/rcmc.validation.css" />


<link rel="stylesheet" type="text/css" href="css/responsive.css" />
<link rel="stylesheet" type="text/css" href="css/media_query.css" />
<script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>

<!--NAV-->
<link href="css/flexnav.css" media="screen, projection" rel="stylesheet" type="text/css">
<script src="js/jquery.flexnav.js" type="text/javascript"></script>
<script src="js/common.js"></script> 
<!--NAV-->
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
 

<!-- Start For Any other checkbox -->
<!--<script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>-->
<script type="text/javascript">
$(document).ready(function(){
$('#neel').click(function(){
if ( $(this).is(':checked') ) {
$('#item_other').show();
} else {
$('#item_other').hide();
}
});
});
</script>
<script type="text/javascript">
$(document).ready(function(){
$('#neel1').click(function(){
if ( $(this).is(':checked') ) {
$('#item_other1').show();
} else {
$('#item_other1').hide();
}
});
});
</script>

<script type="text/javascript">
$(document).ready(function(){
$('#neel2').click(function(){
if ( $(this).is(':checked') ) {
$('#item_other2').show();
} else {
$('#item_other2').hide();
}
});
});
</script>
<!-- Over For Any other checkbox -->

<!-- UItoTop plugin -->
<link rel="stylesheet" type="text/css" media="screen,projection" href="css/ui.totop.css" />
<script src="js/easing.js" type="text/javascript"></script>
<script src="js/jquery.ui.totop.js" type="text/javascript"></script>    
<script type="text/javascript">
    $(document).ready(function() {        
        $().UItoTop({ easingType: 'easeOutQuart' });        
    });
</script>
<script type="text/javascript" src="js/buy_shell.js"></script>
<?php 
/*..............Check Company Logo..................*/
$qgetimg=$conn->query("select company_logo from member_directory where registration_id='".$_SESSION['USERID']."'");
$rgetimg=$qgetimg->fetch_assoc();
$company_logo=$rgetimg['company_logo'];
?>

<script type="text/javascript">
function validate() {
		
		if(document.getElementById('edit-company-name').value =='')
		{
			alert("Please enter company name");
			document.getElementById('edit-company-name').focus();
			return false;
		}
		
		if(document.getElementById('edit-contact-person').value ==''){
			alert("Please enter contact name");
			document.getElementById('edit-contact-person').focus();
			return false;
		}
		
		if(document.getElementById('edit-designation').value ==''){
			alert("Please enter designation");
			document.getElementById('edit-designation').focus();
			return false;
		}
		
		if(document.getElementById('edit-write-up').value ==''){
			alert("Please enter brief description");
			document.getElementById('edit-write-up').focus();
			return false;
		}
		
		if( $('input[name="item_description[]"]:checked').length == 0)
		{
			alert("Item description field is manadatory");
			document.getElementById('edit-item-description').focus();
			return false;
		}
		
		if( $('input[name="wa_jewellery[]"]:checked').length == 0 && $('input[name="wa_machinery[]"]:checked').length == 0)
		{
			alert("We are field is manadatory");
			document.getElementById('edit-wa-jewellery').focus();
			return false;
		}
		
		if( $('input[name="pd_jewellery[]"]:checked').length == 0 && $('input[name="pd_machinery[]"]:checked').length == 0)
		{
			alert("Product dealing field is manadatory");
			document.getElementById('edit-pd-jewellery').focus();
			return false;
		}
   
		var company_logo = "<?php echo $company_logo?>";
		if((document.getElementById('company_logo').value =='') && (company_logo =='')){
		alert("Please upload company logo");
		document.getElementById('company_logo').focus();
		return false;
		}
}
</script> 

<script type="text/javascript" src="js/member_directory_pvr.js"></script>

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

<div class="new_banner">
<img src="images/banners/banner.jpg" />
</div>

<div class="inner_container">

	<div class="breadcrum"><a href="index.php">Home</a> > OBMP > OBMP Profile</div>    
    <div class="clear"></div>
    
    <div class="content_area">
    
    <div class="pg_title">
    
    <div class="title_cont">
        <span class="top">OBMP <img src="images/titles/joint.png" style="position:absolute; top:31px; right:0px;" /></span>   
        <span class="below">Profile</span>
        <div class="clear"></div>
    </div>
    
    </div> 
    <div class="clear"></div>
       
<div id="formContainer">
<form action="members_profile_inc.php" method="post" enctype="multipart/form-data" name="member"  id="member" onSubmit="return validate()"> 
    <?php 
    if($_SESSION['msg']!=""){
    echo "<span class='notification n-success'>".$_SESSION['msg']."</span>";
    $_SESSION['msg']="";
    }
    
    if($_SESSION['upload_error']!=""){
    echo "<span class='notification n-attention'>".$_SESSION['upload_error']."</span>";
    $_SESSION['upload_error']="";
    }
    ?>  
            <div id="form">
                       
            
             <div class="title">Company Details</div>
             <div class="borderBottom"></div>
             
             <div class="clear"></div>
            <input type="hidden" name="user_type" id="edit-user-type" value="<?php echo $usertype;?>"  />
            <div class="field">
            
            <label>Company Name : <sup>*</sup></label>
            <input name="company_name" id="edit-company-name" type="text" class="textField" value="<?php echo $co_name?>" readonly="readonly"/>
            <span id="error_company"></span>
            </div>
            
            <div class="field">
            <label>Contact Person : <sup>*</sup></label>
            <input name="contact_person" id="edit-contact-person" value="<?php echo $fname." ".$lname;?>" type="text"  class="textField" readonly="readonly"/>
            <span id="error_contact"></span>
            </div>
            
            <div class="field">
            <label>Designation : <sup>*</sup></label>
     <select name="designation" class="form_text_text bgcolor"  id="edit-designation">
<option value="">None of these</option>
<option value="Act. Executive Director" <?php if(preg_match('/Act. Executive Director/',$designation)){echo 'selected="selected"'; } ?> >A.E.D.</option>
<option value="Asstt. Director" <?php if(preg_match('/Asstt. Director/',$designation)){echo 'selected="selected"'; } ?>>ASSTT. DIR</option>
<option value="Authorised Signatory" <?php if(preg_match('/Authorised Signatory/',$designation)){echo 'selected="selected"'; } ?>>AUTHO</option>
<option value="CEO" <?php if(preg_match('/CEO/',$designation)){echo 'selected="selected"'; } ?>>CEO</option>
<option value="Chairman" <?php if(preg_match('/Chairman/',$designation)){echo 'selected="selected"'; } ?>>CHAIRMAN</option>
<option value="Chief Designer" <?php if(preg_match('/Chief Designer/',$designation)){echo 'selected="selected"'; } ?>>CHIEF DESI</option>
<option value="Chief Executive" <?php if(preg_match('/Chief Executive/',$designation)){echo 'selected="selected"'; } ?>>CHIEF EXEC</option>
<option value="CMD" <?php if(preg_match('/CMD/',$designation)){echo 'selected="selected"'; } ?>>CMD</option>
<option value="Co-Convener" <?php if(preg_match('/Co-Convener/',$designation)){echo 'selected="selected"'; } ?>>COCONV</option>
<option value="Commercial Officer" <?php if(preg_match('/Commercial Officer/',$designation)){echo 'selected="selected"'; } ?>>COMMERCIAL</option>
<option value="Computer Engineer" <?php if(preg_match('/Computer Engineer/',$designation)){echo 'selected="selected"'; } ?>>COMPUTER E</option>
<option value="Convener" <?php if(preg_match('/Convener/',$designation)){echo 'selected="selected"'; } ?>>CONV</option>
<option value="Director" <?php if(preg_match('/Director/',$designation)){echo 'selected="selected"'; } ?>>DIRECTOR</option>
<option value="Director (EOU &amp; SEZ)" <?php if(preg_match('/Director (EOU &amp; SEZ)/',$designation)){echo 'selected="selected"'; } ?>>DIRECTOR (EOU &amp; SEZ)</option>
<option value="Director (P T &amp; C)" <?php if(preg_match('/Director (P T &amp; C)/',$designation)){echo 'selected="selected"'; } ?>>DIRECTOR (P T &amp; C)</option>
<option value="Deputy Director" <?php if(preg_match('/Deputy Director/',$designation)){echo 'selected="selected"'; } ?>>DY. DIRECTOR</option>
<option value="DY. M.D. (COMMERCIAL)" <?php if(preg_match('/DY. M.D. (COMMERCIAL)/',$designation)){echo 'selected="selected"'; } ?>>DY. M.D. CO</option>
<option value="Executive Director" <?php if(preg_match('/Executive Director/',$designation)){echo 'selected="selected"'; } ?>>E.D.</option>
<option value="E.D. (Admin &amp; Fin)" <?php if(preg_match('/E.D. (Admin &amp; Fin)/',$designation)){echo 'selected="selected"'; } ?>>E.D. (Admn &amp; Fin)</option>
<option value="Export Executive" <?php if(preg_match('/Export Executive/',$designation)){echo 'selected="selected"'; } ?>>EXPORT EXE</option>
<option value="Export Man" <?php if(preg_match('/Export Man/',$designation)){echo 'selected="selected"'; } ?>>EXPORT MAN</option>
<option value="Finance Manager" <?php if(preg_match('/Finance Manager/',$designation)){echo 'selected="selected"'; } ?>>FINANCE MANAGER</option>
<option value="Food &amp; Beverage Manager" <?php if(preg_match('/Food &amp; Beverage Manager/',$designation)){echo 'selected="selected"'; } ?>>FOOD &amp; BEVERAGE MANAGER</option>
<option value="General Manager" <?php if(preg_match('/General Manager/',$designation)){echo 'selected="selected"'; } ?>>GEN MANAGER</option>
<option value="Gjepc Leader" <?php if(preg_match('/Gjepc Leader/',$designation)){echo 'selected="selected"'; } ?>>GJEPC LEADER</option>
<option value="GJEPC SECRETARIAL" <?php if(preg_match('/GJEPC SECRETARIAL/',$designation)){echo 'selected="selected"'; } ?>>GJEPC SECRET</option>
<option value="Government Nominee" <?php if(preg_match('/Government Nominee/',$designation)){echo 'selected="selected"'; } ?>>GOVTNOMN</option>
<option value="Head" <?php if(preg_match('/Head/',$designation)){echo 'selected="selected"'; } ?>>HEAD</option>
<option value="Jewellery" <?php if(preg_match('/Jewellery/',$designation)){echo 'selected="selected"'; } ?>>JEWELLERY</option>
<option value="KARTA OF HUF" <?php if(preg_match('/KARTA OF HUF/',$designation)){echo 'selected="selected"'; } ?>>KARTA</option>
<option value="Manager" <?php if(preg_match('/Manager/',$designation)){echo 'selected="selected"'; } ?>>MANAGER</option>
<option value="Manager M &amp; R" <?php if(preg_match('/Manager M &amp; R/',$designation)){echo 'selected="selected"'; } ?>>MANAGER M &amp; R</option>
<option value="Managing Director" <?php if(preg_match('/Managing Director/',$designation)){echo 'selected="selected"'; } ?>>MANAGING D</option>
<option value="Marketing" <?php if(preg_match('/Marketing/',$designation)){echo 'selected="selected"'; } ?>>MARKETING</option>
<option value="Member" <?php if(preg_match('/Member/',$designation)){echo 'selected="selected"'; } ?>>MEMB</option>
<option value="Partner" <?php if(preg_match('/Partner/',$designation)){echo 'selected="selected"'; } ?>>PARTNER</option>
<option value="President" <?php if(preg_match('/President/',$designation)){echo 'selected="selected"'; } ?>>PRESIDENT</option>
<option value="Prod. Man.&amp; Int. Bus. Cordin." <?php if(preg_match('/Prod. Man.&amp; Int. Bus. Cordin./',$designation)){echo 'selected="selected"'; } ?>>PROD. MAN.</option>
<option value="Proprietor" <?php if(preg_match('/Proprietor/',$designation)){echo 'selected="selected"'; } ?>>PROPRIETER</option>
<option value="Permanent Special Invitee" <?php if(preg_match('/Permanent Special Invitee/',$designation)){echo 'selected="selected"'; } ?>>PSPINVT</option>
<option value="Regional Chairman" <?php if(preg_match('/Regional Chairman/',$designation)){echo 'selected="selected"'; } ?>>RCHRMN</option>
<option value="Resigned" <?php if(preg_match('/Resigned/',$designation)){echo 'selected="selected"'; } ?>>RESIGNED</option>
<option value="Sales Executive" <?php if(preg_match('/Sales Executive/',$designation)){echo 'selected="selected"'; } ?>>SALES EXEC</option>
<option value="Sales Manager" <?php if(preg_match('/Sales Manager/',$designation)){echo 'selected="selected"'; } ?>>SALES MANAGER</option>
<option value="Secretary" <?php if(preg_match('/Secretary/',$designation)){echo 'selected="selected"'; } ?>>SECRETARY</option>
<option value="Senior Vice President" <?php if(preg_match('/Senior Vice President/',$designation)){echo 'selected="selected"'; } ?>>SENIOR VICE PRESIDENT</option>
<option value="Special Invitee" <?php if(preg_match('/Special Invitee/',$designation)){echo 'selected="selected"'; } ?>>SPINVT</option>
<option value="Sr. Executive" <?php if(preg_match('/Sr. Executive/',$designation)){echo 'selected="selected"'; } ?>>SR. EXECUTIVE</option>
<option value="Vice Chairman" <?php if(preg_match('/Vice Chairman/',$designation)){echo 'selected="selected"'; } ?>>VICECHRMN</option>
<option value="Whole Time Director" <?php if(preg_match('/Whole Time Director/',$designation)){echo 'selected="selected"'; } ?>>WHOLE TIME DIRECTOR</option>
</select>
            <span id="error_designation"></span>
            </div>
            
            <div class="field">
            <label>Website : </label>
            <input  name="website" id="edit-website" value="<?php echo $website;?>" type="text"  class="textField" required/>
            </div>
            
            <div class="field bottomSpace">
            <label>Brief write up  : <sup>*</sup></label>
            <textarea name="write_up" id="edit-write-up" class="textField" style="height:60px;" required><?php echo $write_up;?></textarea>
            <span id="error_brief"></span>
            </div>
                  
            
             <div class="title">Item Intersted In :</div>
             <div class="borderBottom"></div>
             
             <div class="clear"></div>
            
            <div class="field bottomSpace">
            <div class="leftTitle" style="padding-top:0px; margin-bottom:5px;">Description of the items to be displayed :  <sup>*</sup></div>
               <div class="rightContent" style="width:100%;">
               <ul class="matterText">
                   <li>
                    <input name="item_description[]" id="edit-item-description" type="checkbox" value="Plain Gold Jewellery" <?php if(preg_match('/Plain Gold Jewellery/',$item_description)){echo 'checked="checked"'; } ?>/>
                    <span>Plain Gold Jewellery</span>
                   </li>
                   <li>
                    <input name="item_description[]" id="edit-item-description" type="checkbox" value="Studded Gold Jewellery" <?php if(preg_match('/Studded Gold Jewellery/',$item_description)){echo 'checked="checked"'; } ?> />
                    <span>Studded Gold Jewellery</span>
                   </li>
                
                 <li>
                    <input name="item_description[]" id="edit-item-description" type="checkbox" value="Platinum Jewellery" <?php if(preg_match('/Platinum Jewellery/',$item_description)){echo 'checked="checked"'; } ?> />
                    <span>Platinum Jewellery</span>
                 </li>
                <li>
                 <input name="item_description[]" id="edit-item-description" type="checkbox" value="Silver Jewellery" <?php if(preg_match('/Silver Jewellery/',$item_description)){echo 'checked="checked"'; } ?> />
                 <span> Silver Jewellery</span>
                </li>
                <li>
                 <input name="item_description[]" id="neel" type="checkbox" <?php if($get_other!='') { echo 'checked="checked"'; } ?>/>
                 <span>Any Other</span>
                </li>     
				
           </ul>
	<!--	   <ul id="item_other" style="display:none">
			<input id="start" name="start" size="5" type="text" class="small" value="" />
			</ul> -->
       </div>
	   
      <div class="clear" style="margin-bottom:8px;"></div>
      <div style="display:none;" id="item-description-other-id">
 <label style="min-width:179px;"> Please Specify :</label> 
<input name="item_description_other" id="edit-item-description-other" type="text" class="textField" value="<?php echo $item_description_other;?>" />
            </div>
           
 <!--           
<p><input type="checkbox" name="focus[]" <?php //if($get_other!='') { echo 'checked="checked"'; } ?>/>
Click To Show Texbox</p>-->
<?php
if($get_other!='')
{
echo "Please Specify : <input type='text' id='starts' name='starts' value='$get_other'/>";	
}else{
echo "<ul id='item_other' style='display:none'>Please Specify : <input type='text' id='starts' name='starts' value='$get_other'/></ul>";	
}
?>
<!--
 <ul id="item_other" style="display:none">
Please Specify: <input type="text" id="start1" name="start1" value="" size="20"  />
</ul>
-->		
			 </div>
			
             <div class="title">We Are :</div>
             <div class="borderBottom"></div>
             
             <div class="clear"></div>
            
            <div class="field bottomSpace">
            <div class="leftTitle" style="padding-top:0px; margin-bottom:5px;">Jewellery  :  <sup>*</sup><span id="error_weare"></span></div>
               <div class="rightContent" style="width:100%;">
               <ul class="matterText">
               <li>
            	<input name="wa_jewellery[]" id="edit-wa-jewellery" type="checkbox" <?php if(preg_match('/importers/',$wa_jewellery)){echo 'checked="checked"'; } ?> value="importers"  />
            	<span>Importers</span>
               </li>
             <li>
                <input name="wa_jewellery[]" id="edit-wa-jewellery" type="checkbox" <?php if(preg_match('/wholesalers/',$wa_jewellery)){echo 'checked="checked"'; } ?> value="wholesalers" />
                <span>Wholesalers</span>
             </li>
             <li>
            	<input name="wa_jewellery[]" id="edit-wa-jewellery" type="checkbox" <?php if(preg_match('/agents/',$wa_jewellery)){echo 'checked="checked"'; } ?> value="agents" />
            	<span>Agents</span>
             </li>
             <li>
            	<input name="wa_jewellery[]" id="edit-wa-jewellery" type="checkbox" <?php if(preg_match('/chain stores/',$wa_jewellery)){echo 'checked="checked"'; } ?> value="chain stores" />
            	<span> Chain Stores</span>
             </li>
                
            <li>
           	 <input name="wa_jewellery[]" id="edit-wa-jewellery" type="checkbox" <?php if(preg_match('/retailers/',$wa_jewellery)){echo 'checked="checked"'; } ?> value="retailers" />
             <span>Retailers</span>
           </li>
                
            <li>
            	<input name="wa_jewellery[]" id="edit-wa-jewellery" type="checkbox" <?php if(preg_match('/manufacturers/',$wa_jewellery)){echo 'checked="checked"'; } ?>  value="manufacturers"/>
            	<span> Manufacturers</span>
            </li>
                
            <li>
            	<input name="wa_jewellery[]" id="edit-wa-jewellery" type="checkbox" <?php if(preg_match('/exporters/',$wa_jewellery)){echo 'checked="checked"'; } ?> value="exporters"/>
            	<span> Exporters</span>
             </li>
            <li>
            	<input name="wa_jewellery[]" id="edit-wa-jewellery" type="checkbox" <?php if(preg_match('/designers/',$wa_jewellery)){echo 'checked="checked"'; } ?> value="designers" />
            	<span> Designers</span>
            </li>
            <li>
            	<input name="wa_jewellery[]" id="edit-wa-jewellery" type="checkbox" <?php if(preg_match('/students/',$wa_jewellery)){echo 'checked="checked"'; } ?>  value="students"/>
            	<span> Students</span>
             </li>
            <li>
              <input name="wa_jewellery[]" id="edit-wa-jewellery" type="checkbox" <?php if(preg_match('/artists/',$wa_jewellery)){echo 'checked="checked"'; } ?> value="artists/craftsmen" />
               <span> Artists / Craftsmen</span>
             </li>
            <li>
               <input name="wa_jewellery[]" id="edit-wa-jewellery" type="checkbox" <?php if(preg_match('/goldsmiths/',$wa_jewellery)){echo 'checked="checked"'; } ?> value="goldsmiths" />
               <span> Goldsmiths</span>
            </li>
            
            <li>
         <!--      <input name="wa_jewellery[]" id="edit-wa-jewellery" type="checkbox" <?php if(preg_match('/any other/',$wa_jewellery)){echo 'checked="checked"'; } ?> value="any other"/>-->
		 <input name="wa_jewellery[]" id="neel1" type="checkbox" <?php if($get_other1!='') { echo 'checked="checked"'; } ?>/>
               <span> any other</span>
            </li>         </ul>
      </div>
      <div class="clear"></div>
      	<div style="display:none;" id="wa-jewellery-other-id" >
          <label style="min-width:179px;"> Any Other Please Specify :</label> 
		  <input name="wa_jewellery_other" id="edit-wa-jewellery-other" value="<?php echo $wa_jewellery_other;?>"  type="text" class="textField" />
        </div>
        <?php
if($get_other1!='')
{
echo "Please Specify : <input type='text' id='startx' name='startx' value='$get_other1'/>";	
}else{
echo "<ul id='item_other1' style='display:none'>Please Specify : <input type='text' id='startx' name='startx' value='$get_other1'/></ul>";	
}
?>
<!--
 <ul id="item_other1" style="display:none">
<input type="text" id="start2" name="start2" value="" size="20" />
</ul>
-->
      </div>
            
            
     <div class="title">Products Dealing in</div>
     <div class="borderBottom"></div>
     
     <div class="clear"></div>
      
      <div class="field bottomSpace">
      <div class="leftTitle" style="padding-top:0px; margin-bottom:5px;">Jewellery  :  <sup>*</sup></div>
      <div class="rightContent" style="width:100%">
               <ul class="matterText">
                <li>
                <input name="pd_jewellery[]" id="edit-pd-jewellery" type="checkbox" <?php if(preg_match('/plain gold jewellery/',$pd_jewellery)){echo 'checked="checked"'; } ?> value="plain gold jewellery" />
                <span>Plain Gold Jewellery</span>
                </li>
                
                <li>
                <input name="pd_jewellery[]" id="edit-pd-jewellery" type="checkbox" <?php if(preg_match('/studded gold jewellery/',$pd_jewellery)){echo 'checked="checked"'; } ?> value="studded gold jewellery" />
                <span>Studded Gold Jewellery</span>
                </li>
                
                <li>
                <input name="pd_jewellery[]" id="edit-pd-jewellery" type="checkbox" <?php if(preg_match('/loose diamonds/',$pd_jewellery)){echo 'checked="checked"'; } ?> value="loose diamonds" />
                <span>Loose Diamonds</span>
                </li>
                
                <li>
                <input name="pd_jewellery[]" id="edit-pd-jewellery" type="checkbox" <?php if(preg_match('/coloured gemstones/',$pd_jewellery)){echo 'checked="checked"'; } ?> value="coloured gemstones" />
                <span>Coloured Gemstones</span>
                </li>
                <li>
                <input name="pd_jewellery[]" id="edit-pd-jewellery" type="checkbox" <?php if(preg_match('/pearls/',$pd_jewellery)){echo 'checked="checked"'; } ?>value="pearls" />
                <span>Pearls</span>
                </li>
                
                <li>
                <input name="pd_jewellery[]" id="edit-pd-jewellery" type="checkbox" <?php if(preg_match('/costume jewellery/',$pd_jewellery)){echo 'checked="checked"'; } ?> value="costume jewellery" />
                <span> Costume Jewellery</span>
                </li>
                
                <li>
                <input name="pd_jewellery[]" id="edit-pd-jewellery" type="checkbox" <?php if(preg_match('/platinum jewellery/',$pd_jewellery)){echo 'checked="checked"'; } ?>  value="platinum jewellery"/>
                <span>Platinum Jewellery</span>
                </li>
                <li>
                <input name="pd_jewellery[]" id="edit-pd-jewellery" type="checkbox" <?php if(preg_match('/silver jewellery/',$pd_jewellery)){echo 'checked="checked"'; } ?>  value="silver jewellery"/>
                <span>Silver Jewellery</span>
                </li>
                
                
                <li>
                <input name="pd_jewellery[]" id="edit-pd-jewellery" type="checkbox" <?php if(preg_match('/publications/',$pd_jewellery)){echo 'checked="checked"'; } ?>  value="publications"/>
                <span> Publications</span>
                </li>
                
                <li>
                <input name="pd_jewellery[]" id="edit-pd-jewellery" type="checkbox" <?php if(preg_match('/educational institutions/',$pd_jewellery)){echo 'checked="checked"'; } ?> value="educational institutions" />
                <span>Educational Institutions</span>
                </li>
                
                <li>
                <input name="pd_jewellery[]" id="edit-pd-jewellery" type="checkbox" <?php if(preg_match('/associations/',$pd_jewellery)){echo 'checked="checked"'; } ?> value="associations"/>
                <span>Associations</span>
                </li>
                
        <li>
        <input name="pd_jewellery[]" id="neel2" type="checkbox" <?php if($get_other2!='') { echo 'checked="checked"'; } ?>/>
        <span> any other</span>
        </li>  
        </ul>
        </div>
                
      <div class="clear"></div>
      
<div style="display:none; margin-top:10px;" id="pd-jwellery-other-id">
<label style="min-width:179px;">Please Specify :</label>  <input name="pd_jewellery_other" id="edit-pd-jewellery-other" value="<?php echo $pd_jewellery_other;?>"  type="text" class="textField" />
</div>
<?php
if($get_other2!='')
{
echo "Please Specify : <input type='text' id='starty' name='starty' value='$get_other2'/>";	
}else{
echo "<ul id='item_other2' style='display:none'>Please Specify : <input type='text' id='starty' name='starty' value='$get_other2'/></ul>";	
}
?>
      </div>
            
      <!--  XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX  -->
      
      <div <?php if(!preg_match('/loose diamonds/',$pd_jewellery)){?>style="display:none;" <?php }?> id="diamond-requirement-id">
   		<div class="gray"><strong>Diamond Requirement :</strong></div>
      <div class="clear" style="height:5px;"></div>
        <div class="borderBottom"></div>
        <div class="field">
            <div class="leftTitle" style="padding-top:0px;">Size  :  <sup>*</sup></div>
               <div class="rightContent" style="width:100%">
           <ul class="matterText">
            <li>
            <input name="d_size[]" id="edit-d-size" type="checkbox" value="0.004 - 0.008" <?php if(preg_match('/0.004 - 0.008/',$d_size)){echo 'checked="checked"'; } ?> />
            <span>0.004 - 0.008</span>
            </li>
            <li>
            <input name="d_size[]" id="edit-d-size" type="checkbox" value="0.09 - 0.02" <?php if(preg_match('/0.09 - 0.02/',$d_size)){echo 'checked="checked"'; } ?> />
            <span>0.09 - 0.02</span>
            </li>
            <li>
            <input name="d_size[]" id="edit-d-size" type="checkbox" value="0.025 - 0.07" <?php if(preg_match('/0.025 - 0.07/',$d_size)){echo 'checked="checked"'; } ?> />
            <span>0.025 - 0.07</span>
            </li>
            <li>
            <input name="d_size[]" id="edit-d-size" type="checkbox" value="" />
            <span>0.08 - 0.13</span>
            </li>
            <li>
            <input name="d_size[]" id="edit-d-size" type="checkbox" value="0.14 - 0.17" <?php if(preg_match('/0.14 - 0.17/',$d_size)){echo 'checked="checked"'; } ?> />
            <span>0.14 - 0.17</span>
            </li>
            <li>
            <input name="d_size[]" id="edit-d-size" type="checkbox" value="0.18 - 0.22" <?php if(preg_match('/0.18 - 0.22/',$d_size)){echo 'checked="checked"'; } ?> />
            <span>0.18 - 0.22</span>
            </li>
            <li>
            <input name="d_size[]" id="edit-d-size" type="checkbox" value="0.23 - 0.29" <?php if(preg_match('/0.23 - 0.29/',$d_size)){echo 'checked="checked"'; } ?>/>
            <span>0.23 - 0.29</span>
            </li>
            <li>
            <input name="d_size[]" id="edit-d-size" type="checkbox" value="0.30 - 0.37" <?php if(preg_match('/0.30 - 0.37/',$d_size)){echo 'checked="checked"'; } ?> />
            <span>0.30 - 0.37</span>
            </li>
            <li>
            <input name="d_size[]" id="edit-d-size" type="checkbox" value="0.38 - 0.45" <?php if(preg_match('/0.38 - 0.45/',$d_size)){echo 'checked="checked"'; } ?> />
            <span>0.38 - 0.45</span>
            </li>
            <li>
            <input name="d_size[]" id="edit-d-size" type="checkbox" value="0.46 - 0.69" <?php if(preg_match('/0.46 - 0.69/',$d_size)){echo 'checked="checked"'; } ?> />
            <span>0.46 - 0.69</span>
            </li>
            <li>
            <input name="d_size[]" id="edit-d-size" type="checkbox" value="0.70 - 0.89" <?php if(preg_match('/0.70 - 0.89/',$d_size)){echo 'checked="checked"'; } ?> />
            <span>0.70 - 0.89</span>
            </li>
            <li>
            <input name="d_size[]" id="edit-d-size" type="checkbox" value="0.90 - 1.00" <?php if(preg_match('/0.90 - 1.00/',$d_size)){echo 'checked="checked"'; } ?> />
            <span>0.90 - 1.00</span>
            </li>
            <li>
            <input name="d_size[]" id="edit-d-size" type="checkbox" value="1.00 - 2.00" <?php if(preg_match('/1.00 - 2.00/',$d_size)){echo 'checked="checked"'; } ?> />
            <span>1.00 - 2.00</span>
            </li>
            <li>
            <input name="d_size[]" id="edit-d-size" type="checkbox" value="2.00 - 3.00" <?php if(preg_match('/2.00 - 3.00/',$d_size)){echo 'checked="checked"'; } ?> />
            <span>2.00 - 3.00</span>
            </li>
            <li>
            <input name="d_size[]" id="edit-d-size" type="checkbox" value="3.00 plus" <?php if(preg_match('/3.00 plus/',$d_size)){echo 'checked="checked"'; } ?>/>
            <span>3.00 plus</span>
            </li>
            <input name="d_size[]" id="edit-d-size" type="checkbox" value="3.00 plus" />
            <span>3.00 plus</span>
            </li>
           </ul>
        </div>
      <div class="clear"></div>
      </div>
          
          <div class="field">
            <div class="leftTitle" style="padding-top:0px;">Clarity :  <sup>*</sup></div>
               <div class="rightContent" style="width:100%">
               <ul class="matterText">
            <li>
           		<input name="d_clarity[]" id="edit-d-clarity" type="checkbox" value="SI1 - SI2" <?php if(preg_match('/SI1 - SI2/',$d_clarity)){echo 'checked="checked"'; } ?> />
            	<span>SI1 - SI2</span>
            </li>
            
            <li>
            	<input name="d_clarity[]" id="edit-d-clarity" type="checkbox" value="IF" <?php if(preg_match('/IF/',$d_clarity)){echo 'checked="checked"'; } ?> />
            	<span>IF</span>
            </li>
            
            <li>
            	<input name="d_clarity[]" id="edit-d-clarity" type="checkbox" value="VVS1 - VVS2" <?php if(preg_match('/VVS1 - VVS2/',$d_clarity)){echo 'checked="checked"'; } ?> />
            	<span>VVS1 - VVS2</span>
            </li>
            
            <li>
            	<input name="d_clarity[]" id="edit-d-clarity" type="checkbox" value="VS1 - VS2" <?php if(preg_match('/VS1 - VS2/',$d_clarity)){echo 'checked="checked"'; } ?> />
            	<span>VS1 - VS2</span>
            </li>
          </ul>
       </div>
      <div class="clear"></div>
    </div>
            
         <div class="field">
            <div class="leftTitle">Color / Shade</div>
         	<div class="rightContent" style="width:100%">
            <ul class="matterText">   
           <li>
            <input name="d_color_shade[]" id="edit-d-color-shade" type="checkbox" value="DE" <?php if(preg_match('/DE/',$d_color_shade)){echo 'checked="checked"'; } ?> />
            <span>D/E</span>
            </li>
            
            <li>
            <input name="d_color_shade[]" id="edit-d-color-shade" type="checkbox" value="FG" <?php if(preg_match('/FG/',$d_color_shade)){echo 'checked="checked"'; } ?> />
            <span>F/G</span>
            </li>
            
            <li>
            <input name="d_color_shade[]" id="edit-d-color-shade" type="checkbox" value="HI" <?php if(preg_match('/HI/',$d_color_shade)){echo 'checked="checked"'; } ?> />
            <span>H/I</span>
            </li>
            
            <li>
            <input name="d_color_shade[]" id="edit-d-color-shade" type="checkbox" value="JK" <?php if(preg_match('/JK/',$d_color_shade)){echo 'checked="checked"'; } ?> />
            <span>J/K</span>
            </li>
             <li>
            <input name="d_color_shade[]" id="edit-d-color-shade" type="checkbox" value="TTLC" <?php if(preg_match('/TTLC/',$d_color_shade)){echo 'checked="checked"'; } ?> />
            <span>TTLC</span>
            </li>
             <li>
            <input name="d_color_shade[]" id="edit-d-color-shade" type="checkbox" value="TLC" <?php if(preg_match('/TLC/',$d_color_shade)){echo 'checked="checked"'; } ?>/>
            <span>TLC</span>
            </li>
            <li>
            <input name="d_color_shade[]" id="edit-d-color-shade" type="checkbox" value="LC" <?php if(preg_match('/LC/',$d_color_shade)){echo 'checked="checked"'; } ?> />
            <span>LC</span>
            </li>
            
            <li>
            <input name="d_color_shade[]" id="edit-d-color-shade" type="checkbox" value="TTLB" <?php if(preg_match('/TTLB/',$d_color_shade)){echo 'checked="checked"'; } ?> />
            <span>TTLB</span>
            </li>
            
            <li>
            <input name="d_color_shade[]" id="edit-d-color-shade" type="checkbox" value="TLB" <?php if(preg_match('/TLB/',$d_color_shade)){echo 'checked="checked"'; } ?> />
            <span>TLB</span>
            </li>
            
            <li>
            <input name="d_color_shade[]" id="edit-d-color-shade" type="checkbox" value="LB" <?php if(preg_match('/LB/',$d_color_shade)){echo 'checked="checked"'; } ?>/>
            <span>LB</span>
            </li>
            <li>
            <input name="d_color_shade[]" id="edit-d-color-shade" type="checkbox" value="M" <?php if(preg_match('/M/',$d_color_shade)){echo 'checked="checked"'; } ?> />
            <span>M</span>
            </li>
          </ul>
         </div>
      	<div class="clear"></div>
       </div>
        <div class="field">
        <div class="leftTitle">Price Point :</div>
        <div class="clear"></div>
        <div class="leftTitle">From :</div>
        <input name="d_pp_from" id="edit-d-pp-from" type="text"  class="textField" value="<?php echo $d_pp_from;?>"/>
        <div class="clear"></div>
        <div class="leftTitle">To :</div>
        <input name="d_pp_to" id="edit-d-pp-to" type="text"  class="textField" value="<?php echo $d_pp_to;?>"/>
        <div class="clear"></div>
        </div>
       </div>
            
      <!--  XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX  -->
      
      <div <?php if(!preg_match('/coloured gemstones/',$pd_jewellery)){?> style="display:none;" <?php }?> id="coloured-gem-stone-requirement-id">
        <div class="gray"><strong>Coloured Gem Stone Requirement :</strong></div>
      <div class="clear" style="height:5px;"></div>
        <div class="borderBottom"></div>
        <div class="field">
        <div class="leftTitle">Name of the stone:</div>
            <div class="rightContent" style="width:100%;">
            <ul class="matterText">
            <li>
            <input name="cgs_stone[]" id="edit-cgs-stone" type="checkbox" value="actinolite" <?php if(preg_match('/actinolite/',$cgs_stone)){echo 'checked="checked"'; } ?> />
            <span>Actinolite</span>
            </li>
            
            <li>
            <input name="cgs_stone[]" id="edit-cgs-stone" type="checkbox" value="alexandrite" <?php if(preg_match('/alexandrite/',$cgs_stone)){echo 'checked="checked"'; } ?> />
            <span>Alexandrite</span>
            </li>
            
            <li>
            <input name="cgs_stone[]" id="edit-cgs-stone" type="checkbox" value="almandite garnet" <?php if(preg_match('/almandite garnet/',$cgs_stone)){echo 'checked="checked"'; } ?> />
            <span>Almandite Garnet</span>
            </li>
            
            <li>
            <input name="cgs_stone[]" id="edit-cgs-stone" type="checkbox" value="amazonite" <?php if(preg_match('/amazonite/',$cgs_stone)){echo 'checked="checked"'; } ?> />
            <span>Amazonite</span>
            </li>
            
            <li>
            <input name="cgs_stone[]" id="edit-cgs-stone" type="checkbox" value="amber" <?php if(preg_match('/amber/',$cgs_stone)){echo 'checked="checked"'; } ?> />
            <span>Amber</span>
            </li>
          </ul>
        </div>
      <div class="clear"></div>
    </div>
    <div class="field">
    <div class="leftTitle">Shade :</div>
    <input name="cgs_shade" id="edit-cgs-shade" type="text" class="textField" value="<?php echo $cgs_shade;?>" />
    <div class="clear"></div>
    </div>
            
    <div class="field">
    <div class="leftTitle">Shape :</div>
    <input name="cgs_shape" id="edit-cgs-shape" type="text" class="textField" value="<?php echo $cgs_shape;?>" />
    <div class="clear"></div>
    </div>
            
    <div class="field">
    <div class="leftTitle">Quantity :</div>
    <input name="cgs_quantity" id="edit-cgs-quantity" type="text" class="textField" value="<?php echo $cgs_quantity;?>" />
    <div class="clear"></div>
    </div>
    
    <div class="field bottomSpace">
    <div class="leftTitle">Price Point :</div>
    <div class="clear"></div>
    <div class="leftTitle">From :</div>
    <input name="cgs_pp_from" id="edit-cgs-pp-from" type="text"  class="textField" value="<?php echo $cgs_pp_from;?>"/>
    <div class="clear" style="height:10px;"></div>
    <div class="leftTitle">To :</div>
    <input name="cgs_pp_to" id="edit-cgs-pp-to" type="text"  class="textField" value="<?php echo $cgs_pp_to;?>"/>
    <div class="clear"></div>
    </div>  
   </div>
      
      <!--  XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX  -->
      
      
      <div class="title">Product Logo</div>
      <div class="borderBottom"></div>
      <div class="clear"></div>
      
        <div class="field bottomSpace">
        <div class="userPic">
        <?php if($product_logo!=''){?><img src="product_logo/<?php echo $product_logo;?>" width="105" height="112" /><?php } else {?><img src="images/upload_img.jpg" /><?php }?>       
        </div>
        <div class="leftFile">
        <p><strong>Filename</strong></p>
        <input name="product_logo" type="file" class="textField" style="margin-bottom:10px;" />
        <!--<div class="maroonBtn"><a href="#">Upload File</a></div>-->
        </div>
        <div class="clear"></div>
        </div>        
        
        <div class="title">Company Logo</div>
        <div class="borderBottom"></div>
        <div class="clear"></div>
        
        <div class="field bottomSpace">
        <div class="userPic">
        <!--<img src="images/user_pic.jpg" width="100px" height="auto" alt="" />-->
        <?php if($company_logo!=''){?><img src="company_logo/<?php echo $company_logo;?>" width="105" height="112" /><?php } else {?><img src="images/upload_img.jpg" /><?php }?>
    
        </div>
        
        <div class="leftFile">
        <p><strong>Filename</strong><sup>*</sup></p>
        <input name="company_logo" id="company_logo" type="file" class="textField" style="margin-bottom:10px;" />
        </div>
        <div class="clear"></div>
        </div>    
<!-- Catalog Image Path --->
		<div class="title">Product Catalog</div>
        <div class="borderBottom"></div>
        <div class="clear"></div>        
        <div class="field bottomSpace">
		
		<div class="user_box">
		<?php   
	$query=$conn->query("select id,image from member_catalog_image where regis_id='$registration_id'");
	while($result1=$query->fetch_assoc())
	{		//print_r($result1);
   $image=$result1['image'];
	if($result1['image']!=""){
    ?>
    
<div class="img">
<a href="">
<img src="catalog_image/<?php echo $image; ?>"" width="110" height="90" /></a>
<div class="desc">
<a href="delete_catalog_img.php?id=<?php echo $result1['id']?>" 
 onclick="return confirm('Are you sure to delete this image?'); ">Remove</a>
</div>
</div>
<?php }	else{?>
	<img src="images/upload_img.jpg" />
	<?php }	}?> 
</div>
		
    <!--
	<div class="userPic">		
	<?php   
	$query=$conn->query("select id,image from member_catalog_image where regis_id='$registration_id'");
	while($result1=$query->fetch_assoc())
	{		//print_r($result1);
   $image=$result1['image'];
	if($result1['image']!=""){
    ?>
	<a href="delete_catalog_img.php?id=<?php echo $result1['id']?>" 
 onclick="return confirm('Are you sure to delete this image?'); ">Remove</a>
	<img src="catalog_image/<?php echo $image; ?>" width="240" height="140">
	<?php }	else{?>
	<img src="images/upload_img.jpg" />
	<?php }	}?> 
    </div>
	-->
        
        <div class="leftFile"><br/>
        <p><strong>Filename</strong><sup>*</sup> Select Ctrl button for Multiple Catalog Images</p>
        <input name="support_images[]" id="support_images" type="file" multiple="multiple" class="textField" style="margin-bottom:10px;" />
        </div>
        <div class="clear"></div>
        </div>     	
              

            <div class="maroonBtn">
              <input type="submit" name="submit" value="Submit" class="newMaroonBtn" />
            </div>
             
            </div>
          </form>
           <div class="clear"></div>
           
            </div>
            <div class="clear"></div>
            
	   
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

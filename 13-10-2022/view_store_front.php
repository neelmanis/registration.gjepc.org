<?php include('header_include.php');
if(!isset($_SESSION['USERID'])){
		header("location:login.php");
		exit;
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome to SIGNATURE</title>
<link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Cabin'>
<link rel="stylesheet" type="text/css" href="css/general.css?v=<?php echo $version;?>" />
<link rel="stylesheet" type="text/css" href="css/inner_pg_style.css?v=<?php echo $version;?>" />
 
<link rel="stylesheet" type="text/css" href="css/responsive.css?v=<?php echo $version;?>" />
<link rel="stylesheet" type="text/css" href="css/visitor_reg.css?v=<?php echo $version;?>" />
<link rel="stylesheet" type="text/css" href="css/media_query.css?v=<?php echo $version;?>" />

<!--navigation script-->
<script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>
<!--<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>    -->  
<!--NAV-->
<link href="css/flexnav.css" media="screen, projection" rel="stylesheet" type="text/css">
<script src="js/jquery.flexnav.js" type="text/javascript"></script>
<script src="js/common.js"></script> 
<!--NAV-->

<script type="text/javascript">
    $(function() {
        if (!$.support.placeholder) {
            var active = document.activeElement;
            
            $(':text').focus(function() {
                if ($(this).attr('placeholder') != '' && $(this).val() == $(this).attr('placeholder')) {
                    $(this).val('').removeClass('hasPlaceholder');
                }
            }).blur(function() {
                if ($(this).attr('placeholder') != '' && ($(this).val() == '' || $(this).val() == $(this).attr('placeholder'))) {
                    $(this).val($(this).attr('placeholder')).addClass('hasPlaceholder');
                }
            });
            $(':text').blur();
            $(active).focus();
        }
    });
</script>   

<script type="text/javascript" src="js/jquery.carouFredSel-6.2.1-packed.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	// Using default configuration
	
});

function startSlider() {
	$("#image-slider-1").carouFredSel({
		auto: false,
		prev	: {	
			button	: "#image-slider-prev"
		},
		next	: { 
			button	: "#image-slider-next"
		}
	});
}
</script>

<!-- tab jquery -->
<script type="text/javascript">
$(document).ready(function() {
	$("#content>div").hide(); // Initially hide all content
	$("#tabs li:first").attr("id","current"); // Activate first tab
	$("#content div:first").fadeIn(); // Show first tab content
    var started = false;
    $('#tabs a').click(function(e) {
        e.preventDefault();
        $("#content>div").hide(); //Hide all content
        $("#tabs li").attr("id",""); //Reset id's
        $(this).parent().attr("id","current"); // Activate this
		var currentTab = $(this).attr('title');
        $('#' + $(this).attr('title')).fadeIn(function() {
			if (currentTab == 'tab2' && started == false) {
				//console.log('starting ...');
				startSlider();
				started = true;
			}
		}); // Show content for current tab
//		console.log($(this).attr('title'));
    });
});
</script>
 
<script type="text/javascript">
function validate()
{
  if(document.forms['send_enquiry']['item_interest'].value=="")
  {
  alert("Please fill your interest.");
  document.forms['send_enquiry']['item_interest'].focus();
  return false;
  }
  if(document.forms['send_enquiry']['enquiry'].value=="")
  {
	  alert("Please fill your enquiry.");
	  document.forms['send_enquiry']['enquiry'].focus();
	  return false;
  }
}
</script>

</head>

<body>
<div class="wrapper">

<div class="header">
	<?php include('header1.php'); ?>
</div>

<div class="new_banner">
<img src="images/banners/banner.jpg" />
</div>

<div class="clear"></div>
<?php 
if(isset($_REQUEST['registration_id']))
{
	$registration_id=filter($_REQUEST['registration_id']);
}
else 
{
	$registration_id=$_SESSION['USERID'];
}
$query=$conn->query("select * from member_directory where registration_id='$registration_id'");
$result=$query->fetch_assoc();
?>

<div class="inner_container">

	<div class="breadcrum"><a href="index.php">Home</a> > OBMP > View Storefront</div>    
    <div class="clear"></div>
    
    <div class="content_area">    
    <div class="pg_title">    
    <div class="title_cont">
        <span class="top">OBMP <img src="images/titles/joint.png" style="position:absolute; top:31px; right:0px;" /></span>   
        <span class="below">View Storefront</span>
        <div class="clear"></div>
    </div>    
    </div> 
    <div class="clear"></div>
       
<div id="formContainer">
    <div id="form">
      <div class="righttable_css">
        <div class="midletext">
        <ul id="tabs">
            <li id=""><a href="" title="tab1">Company Profile</a></li>
            <li id=""><a href="" title="tab2">Product Catalogue</a></li>  
            <li id=""><a href="" title="tab3">Product's Details</a></li>  
            <li id=""><a href="" title="tab4" class="lastBg">Send Enquiry</a></li>  
        </ul>

<div id="content" style="border:0px;"> 
<div id="tab1" style="display: none;">
<table width="98%" border="0" align="left" bordercolor="#e0e0e0" cellpadding="0" cellspacing="0" style="border-collapse: collapse; margin-left:0px;">
  <tbody><tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td width="22%" height="25" align="left" class="bold">Contact Person </td>
    <td width="3%">:</td>
    <td width="56%" align="left" valign="top"> [ <?php echo strtoupper($result['contact_person']);?> ]</td>
    <td>&nbsp;</td>
    <td width="56%" rowspan="5" align="center" valign="top" ><!--<img src="images/auto_match/1_thum.jpg" width="100" height="106" />-->

<?php if($result['company_logo']!=''){?><img src="company_logo/<?php echo $result['company_logo'];?>" width="100" height="106" /><?php } else {?><img src="images/upload_img.jpg" /><?php }?>  
    </td>
  </tr>
  <tr>
    <td height="25" align="left" class="bold">We are</td>
    <td>:</td>
    <td align="left" valign="top"><strong>Jewellery</strong> <?php echo $result['wa_jewellery'];?></td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td height="25" align="left" class="bold">We deal in</td>
    <td>:</td>
    <td align="left" valign="top"><strong>Jewellery</strong> <?php echo $result['pd_jewellery'];?></td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td align="left" class="bold" valign="top">Brief write up</td>
    <td valign="top">:</td>
    <td align="left" valign="top" style="text-align:justify;"><?php echo $result['write_up'];?></td>
    <td>&nbsp;</td>
    </tr>
  <!--<tr>
    <td height="25" align="left">Description of items to be displayed</td>
    <td valign="top">:</td>
    <td align="left" valign="top">Studded Gold Jewellery</td>
    </tr>-->
</tbody></table>
</div>
    
<div id="tab2" style="display: none;">
	<div class="list_carousel">
	<div class="prev_1" id="image-slider-prev">&nbsp;</div>
    
	<ul id="image-slider-1">
    <?php 
    $query1=$conn->query("select product_image_fid from product_catalogue where uid='$registration_id'");
	while($result1=$query1->fetch_assoc()){
	if($result1['product_image_fid']!=""){
    ?>
	<li><img src="product_catalogue/<?php echo $result1['product_image_fid'];?>" width="105" height="112" /></li>
    <?php }} ?> 
	</ul>   
    <div class="next_1" id="image-slider-next">&nbsp;</div>
	</div>
</div>

<div id="tab3" style="display: none;">
  <table width="98%" border="0" align="left" bordercolor="#e0e0e0" cellpadding="0" cellspacing="0" style="border-collapse: collapse; margin-left:3px;">
    <tbody><tr>
      <td height="25" colspan="4" align="left"><strong></strong></td>
    </tr>
    <tr>
      <td width="28%" height="25" align="left"><strong>Diamond offers</strong></td>
      <td width="4%">:</td>
      <td width="68%" align="left" valign="top">&nbsp;</td>     
    </tr>
    <tr>
      <td height="25" align="left" class="bold">Size</td>
      <td>:</td>
      <td align="left" valign="top"><?php if($result['d_size']!=""){echo $result['d_size'];}else{echo "NA";}?></td>
    </tr>
    <tr>
      <td height="25" align="left" class="bold">Clarity</td>
      <td>:</td>
      <td align="left" valign="top"><?php if($result['d_clarity']!=""){echo $result['d_clarity'];}else{echo "NA";}?></td>
    </tr>
    <tr>
      <td align="left" class="bold">Colour/ Shade</td>
      <td valign="top">:</td>
      <td align="left" valign="top"><?php if($result['d_color_shade']!=""){echo $result['d_color_shade'];}else{echo "NA";}?></td>
    </tr>
    <tr>
      <td height="25" align="left" class="bold">Price Point</td>
      <td valign="top">:</td>
      <td align="left" valign="top">From :-  <?php if($result['d_pp_from']!=""){echo $result['d_pp_from'];}else{echo "NA";}?> to <?php if($result['d_pp_to']!=""){echo $result['d_pp_to'];}else{echo "NA";}?></td>
    </tr>
  </tbody></table>
  <table width="100%" border="0" align="center" bordercolor="#e0e0e0" cellpadding="0" cellspacing="0" style="border-collapse: collapse; margin-left:3px;">
  <tbody><tr>
    <td>&nbsp;</td>
  </tr>
</tbody></table>

  <table width="98%" border="0" align="center" bordercolor="#e0e0e0" cellpadding="0" cellspacing="0" style="border-collapse: collapse; margin-left:3px;">
    <tbody><tr>
      <td height="25" colspan="4" align="left"><strong>Color Stone</strong></td>
    </tr>
    <tr>
      <td width="28%" height="25" align="left" class="bold">Name of the stone</td>
      <td width="4%">:</td>
      <td width="68%" align="left" valign="top" class="bold"><?php if($result['cgs_stone']!=""){echo $result['cgs_stone'];}else{echo "NA";}?></td>
    </tr>
    <tr>
      <td height="25" align="left" class="bold">Price Point</td>
      <td>:</td>
      <td align="left" valign="top">From :- <?php if($result['cgs_pp_from']!=""){echo $result['cgs_pp_from'];}else{echo "NA";}?> to <?php if($result['cgs_pp_to']!=""){echo $result['cgs_pp_to'];}else{echo "NA";}?></td>
    </tr>
  </tbody></table>
</div>

<div id="tab4" align="left">
<form action="obmp_enquiry_inc.php" method="post" name="send_enquiry" id="send_enquiry" onsubmit="return validate()">
<table width="98%" border="0" align="left" bordercolor="#e0e0e0" cellpadding="0" cellspacing="0" style="border-collapse: collapse; margin-left:3px;">
  <tbody><tr>
      <td height="25" colspan="4" align="left"><strong><?php echo strtoupper($result['company_name']);?></strong></td>
    </tr>
  <tr>
    <td width="28%" height="25" align="left" class="bold">Company Name:&nbsp;<span>*</span></td>
    <td width="3%">:</td>
    <td width="69%" align="left" valign="top" class="contact_form_bg">
    <input type="text" class="textField" value="<?php echo strtoupper($result['company_name']);?>" disabled="disabled"/>
    </td>
  <input type="hidden" name="company_name" id="company_name" value="<?php echo strtoupper($result['company_name']);?>"/>
   <input type="hidden" name="to_uid" id="to_uid" value="<?php echo $result['registration_id'];?>"/>
  </tr>
  
  <tr>
    <td height="25" align="left" class="bold">Contact Person:&nbsp;<span>*</span></td>
    <td>:</td>
    <td width="69%" align="left" valign="top" class="contact_form_bg">
    <input type="text" class="textField" value="<?php echo strtoupper($result['contact_person']);?>" disabled="disabled"/>
    <input type="hidden" name="contact_person" id="contact_person" value="<?php echo strtoupper($result['contact_person']);?>"/>
    </td>
    </tr>
  <tr>
    <td height="25" align="left" class="bold">Products Interested In:&nbsp;<span>*</span></td>
    <td>:</td>
    <td width="69%" align="left" valign="top" class="contact_form_bg"><input type="text" class="textField" id="item_interest" name="item_interest" value="" /></td>
    </tr>
  <tr>
    <td align="left" class="bold">Enquiry Description:&nbsp;<span>*</span></td>
    <td valign="top">:</td>
    <td width="69%" align="left" valign="top" class="contact_form_bg"><input type="text" class="textField" id="enquiry" name="enquiry" value="" /></td>
    </tr>
  <tr>
    <td height="25" align="left">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td align="left" valign="top"><input  type="submit" value="Submit" class="grayButton" /></td>
    </tr>
</tbody></table>
<div class="clear"></div>
</form>
</div>
<div class="clear"></div>
</div>

<div class="clear"></div>
</div>




<div class="clear"></div>
</div>
            </div>
            
            </div>
          
          
          </div>
           
            
        
        </div>
        
        
        <?php //include ('rightContent.php'); ?>
       
      
        <div class="clear"></div>
        
    </div>
    

    
</div>
<!--container ends-->

<!--footer starts-->
<div class="footer">
	<?php include('footer.php'); ?>
<div class="clear"></div>
</div>

<div class="clear"></div>
</div>
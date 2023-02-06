<?php 
include('header_include.php');
if(!isset($_SESSION['USERID'])){ header("location:login.php"); exit; }
if(($_SESSION['eventInfo']['event_selected'] =="")){ header("location:event_selection.php");	exit; }

/*  Check Event */
 if($_SESSION['eventInfo']['event_selected']=="signature"){ $show="IIJS Signature 2021"; } 
 if($_SESSION['eventInfo']['event_selected']=="iijs") { $show="IIJS 2021"; }
 /*  Check Event */
?>
<?php
//echo '<pre>'; print_r($_SESSION); exit;
$uid = intval($_SESSION['USERID']);
$gid = intval($_REQUEST['gid']);

if(strtoupper($_SESSION['COUNTRY'])=="IN")	$currency="INR";  else	$currency="USD";

//echo '<pre>'; print_r($_SESSION['companyInfo']);
	if(($_SESSION['companyInfo'] != '') || (isset($_SESSION['companyInfo'])))
	{
	$getcompanyInfo = $_SESSION['companyInfo'];
	$wa_jewellery = $getcompanyInfo['we_are_jewellery'];
	$wa_loose = $getcompanyInfo['we_are_loose'];
	$wa_machinery = $getcompanyInfo['we_are_machinery'];
	$we_are = $getcompanyInfo['we_are'];
	$we_are_jewellery_any_other = $getcompanyInfo['we_are_jewellery_any_other'];
	$we_are_machinery_any_other = $getcompanyInfo['we_are_machinery_any_other'];
	$we_are_any_other = $getcompanyInfo['we_are_any_other'];
	$comp_desc = stripslashes($getcompanyInfo["comp_desc"]);
	$last_yr_turn_over = $getcompanyInfo["last_yr_turn_over"];
	}
?>

<?php
$action=@$_REQUEST['action'];
if($action=="Save")
{
	$created_date = date("Y-m-d");
	$modified_date = date("Y-m-d");
			
	$wa_jewellery=implode(",",$_POST['wa_jewellery']);
	if(preg_match('/Any Other/',$wa_jewellery))
		$wa_jewellery_other=$_POST['wa_jewellery_other_text'];
	else
		$wa_jewellery_other="";
	
	$wa_loose=implode(",",$_POST['wa_loose']);
	if(preg_match('/Any Other/',$wa_loose))
		$wa_loose_other=$_POST['wa_loose_other_text'];
	else
		$wa_loose_other="";
		
	$wa_machinery=implode(",",$_POST['wa_machinery']);
	if(preg_match('/Any Other/',$wa_machinery))
		$wa_machinery_other=$_POST['wa_machinery_other_text'];
	else
		$wa_machinery_other="";
	
	$we_are=implode(",",$_POST['we_are']);
	if(preg_match('/Any Other/',$we_are))
		$we_are_other=$_POST['we_are_other_text'];
	else
		$we_are_other="";
		
	$comp_desc = $conn->real_escape_string($_POST["comp_desc"]);
	$last_yr_turn_over = floatval($_POST["last_yr_turn_over"]);

    $companyInfo = array('we_are_jewellery'=>$wa_jewellery,'we_are_loose'=>$wa_loose,'we_are_machinery'=>$wa_machinery,'we_are'=>$we_are,'we_are_jewellery_any_other'=>$wa_jewellery_other,'we_are_loose_any_other'=>$wa_loose_other,'we_are_machinery_any_other'=>$wa_machinery_other,'we_are_any_other'=>$we_are_other,'comp_desc'=>$comp_desc,'last_yr_turn_over'=>$last_yr_turn_over,'show'=>$show);
     // print_r($companyInfo);exit;
     $_SESSION['companyInfo'] =$companyInfo;
	 if($_SESSION['eventInfo']['event_selected']!='combo'){
     header("location:exhibitor_registration_step_3.php"); exit;
	 } else { header("location:exhibitor_registration_step_3_combo.php"); exit; }
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Exhibitor Registration - Company Details</title>
<link rel="icon" href="https://gjepc.org/images/favicon.ico" type="image/x-icon"/>
<link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Cabin'>
<link rel="stylesheet" type="text/css" href="css/general.css?v=<?php echo $version;?>" />
<link rel="stylesheet" type="text/css" href="css/inner_pg_style.css?v=<?php echo $version;?>" />
<style>
.error_mg{
color:red;
font-size:11px;
margin-left:-10px;
font-weight:normal !important;
}
</style>
 
<link rel="stylesheet" type="text/css" href="css/responsive.css?v=<?php echo $version;?>" />
<link rel="stylesheet" type="text/css" href="css/media_query.css?v=<?php echo $version;?>" />
<script type="text/javascript" src="js/jquery-1.8.3.min.js?v=<?php echo $version;?>"></script>
<link rel="stylesheet" type="text/css" href="css/visitor_reg.css?v=<?php echo $version;?>" />

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
<!-- Global site tag (gtag.js) - Google Ads: 679056788 --><!--  <script async src="https://www.googletagmanager.com/gtag/js?id=AW-679056788"></script> <script> window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag('js', new Date()); gtag('config', 'AW-679056788'); </script>  -->
<!-- Event snippet for GJEPC_Google_PageView conversion page --> <script> gtag('event', 'conversion', {'send_to': 'AW-679056788/N1zUCJPKxLsBEJSr5sMC'}); </script> 
<script type="text/javascript">
    $(document).ready(function() {        
        $().UItoTop({ easingType: 'easeOutQuart' });        
    });
</script>
<script type="text/javascript" src="js/drop_any_other.js"></script>
<script language="javascript">
function validation() {
		var last_yr_turn_over = $("#last_yr_turn_over").val();
		/*Jellery error check */		
		if($('input[name="wa_jewellery[]"]:checked').length == 0)
		{
			$("#wa_jewellery_error").text("Please Select Atleast one");
			$flag_wa=1;
		}
		else
			$flag_wa=0;
		
		if($("#wa_jewellery_other").attr("checked"))
		{
			if($("#wa_jewellery_other_input").val()=="")
			{
				$("#wa_jewellery_text_error").text("Required Field");
				$flag_wat = 1;
			}
			else
				$flag_wat = 0;
		}
		else
				$flag_wat = 0;
		
		/* loose error check */
		if($('input[name="wa_loose[]"]:checked').length == 0)
		{
			$("#wa_loose_error").text("Please Select Atleast one");
			$flag_wl=1;
		}
		else
			$flag_wl=0;
		
		if($("#wa_loose_other").attr("checked"))
		{
			if($("#wa_loose_other_input").val()=="")
			{
				$("#wa_loose_text_error").text("Required Field");
				$flag_wal = 1;
			}
			else
				$flag_wal = 0;
		}
		else
				$flag_wal = 0;
		
		/* machinery error check */
		if( $('input[name="wa_machinery[]"]:checked').length == 0)
		{
			$("#wa_machinery_error").text("Please Select atleast one");
			$flag_ma=1;
		}
		else
		{
			$("#wa_machinery_error").text("");
			$flag_ma=0;
		}	
		
		if($("#wa_machinery_other").attr("checked"))
		{
			if($("#wa_machinery_other_input").val()=="")
			{
				$("#wa_machinery_text_error").text("Required Field");
				$flag_mat = 1;
			}
			else
				$flag_mat = 0;
		}
		else
				$flag_mat = 0;
		
		/* We are error check */
		if( $('input[name="we_are[]"]:checked').length == 0)
		{
			$("#we_are_error").text("please select atleast one");
			$flag_wr=1;
		}
		else
			$flag_wr=0;
			
		if($("#we_are_other").attr("checked"))
		{
			if($("#we_are_other_input").val()=="")
			{
				$("#we_are_text_error").text("Required Field");
				$flag_wrt = 1;
			}
			else
				$flag_wrt = 0;
		}
		else
				$flag_wrt = 0;
			
		if($("#comp_desc").val()=="")
		{
			$("#comp_desc_error").text("Required Field");
			$flag_comp = 1;
		}
		else
			$flag_comp = 0;
			
		if($("#last_yr_turn_over").val()=="")
		{
			$("#last_yr_turn_over_error").text("Required Field");
			$flag_turn_over = 1;
		}
		else if(isNaN(last_yr_turn_over))
		{
			$("#last_yr_turn_over_error").text("only numeric values allowed");
			$flag_turn_over = 1;
		}
		else
				$flag_turn_over = 0;
		/* Combined Check for all four */
		if($flag_wa==1 && $flag_wl==1 && $flag_ma==1 && $flag_wr==1)
		{
			return false;
		}
		else if($flag_comp==1 || $flag_turn_over == 1 )
		{
			return false;
		}
		else
			return true;
		
		if($flag_wa==1 || $flag_wl==1 || $flag_wal || $flag_wat==1 || $flag_ma==1 || $flag_mat==1 || $flag_wr==1 || $flag_wrt==1 || $flag_comp==1 || $flag_turn_over == 1 )
			return false;
		else
			return true;
}
</script>

</head>
<body>
<div class="wrapper">

<div class="header"><?php include('header1.php'); ?></div>
<div class="inner_container">
	
    <div class="clear"></div>    
    <div class="content_area">    
    <div class="pg_title">    
    <div class="title_cont">
        <span class="top">Exhibitor <img src="images/titles/joint.png" style="position:absolute; top:31px; right:0px;" /></span>   
        <span class="below">Registration</span>
        <div class="clear"></div>
    </div>    
    </div> 
    <div class="clear"></div>	
    
		<div class="d-flex flex-row justify-center form-group m-10 form-tab">
			<label class="container_radio"><span class="check_text"></span>
			  <input type="radio" disabled="disabled" >
			  <span class="checkmark_radio"></span>
			</label>
			<label class="container_radio"><span class="check_text"></span>
			  <input type="radio" disabled="disabled" >
			  <span class="checkmark_radio"></span>
			</label>
			<label class="container_radio"><span class="check_text"></span>
			  <input type="radio" checked="checked" disabled="disabled">
			  <span class="checkmark_radio"></span>
			</label>
			<label class="container_radio"><span class="check_text"></span>
			  <input type="radio" disabled="disabled">
			  <span class="checkmark_radio"></span>
			</label>
			<label class="container_radio"><span class="check_text"></span>
			  <input type="radio" disabled="disabled">
			  <span class="checkmark_radio"></span>
			</label>
		</div>
        <div class="title"><h4 style="padding:10px 15px;text-align: center; color: #fff; display: table; background: #00000099; margin: 20px auto; border: 1px solid#000; -webkit-box-shadow: 0px 0px 11px -2px rgba(0,0,0,1); -moz-box-shadow: 0px 0px 11px -2px rgba(0,0,0,1); box-shadow: 0px 0px 11px -2px rgba(0,0,0,1); border-radius: 6px;">COMPANY DETAILS</h4></div>
    
	<form name="company_details" action="" method="POST" onsubmit="return validation()">
	
    <div class="form_main">    
        <div class="field_box">
        <div class="field_name">Product Dealing In : &nbsp; <span id="wa_jewellery_error" class="error_mg"></span></div>
        <div class="field_name"></div>
        <div class="field_input" style="padding-top:5px;">
        <div class="chkbox"><input name="wa_jewellery[]" type="checkbox" value="Diamond Jewellery" id="a_1" class="bgcolor" <?php if(preg_match('/Diamond Jewellery/',$wa_jewellery)){ echo ' checked="checked"'; } ?> /> <label for="a_1">Diamond Jewellery</label></div>
        <div class="chkbox"><input name="wa_jewellery[]" type="checkbox" value="Fine Gold Jewellery" id="a_2" class="bgcolor" <?php if(preg_match('/Fine Gold Jewellery/',$wa_jewellery)){ echo ' checked="checked"'; } ?>/> <label for="a_2">Fine Gold Jewellery</label></div>
        <div class="chkbox"><input name="wa_jewellery[]" type="checkbox" value="Platinum Jewellery" id="a_3" class="bgcolor" <?php if(preg_match('/Platinum Jewellery/',$wa_jewellery)){ echo ' checked="checked"'; } ?>/> <label for="a_3">Platinum Jewellery</label></div>
        <div class="chkbox"><input name="wa_jewellery[]" type="checkbox" value="Precious Stone Jewellery" id="a_4" class="bgcolor" <?php if(preg_match('/Precious Stone Jewellery/',$wa_jewellery)){ echo ' checked="checked"'; } ?> /> <label for="a_4">Precious Stone Jewellery</label></div>
        <div class="chkbox"><input name="wa_jewellery[]" type="checkbox" value="Silver Jewellery" id="a_5" class="bgcolor" <?php if(preg_match('/Silver Jewellery/',$wa_jewellery)){ echo ' checked="checked"'; } ?>/> <label for="a_5">Silver Jewellery</label></div>
        <div class="chkbox"><input name="wa_jewellery[]" type="checkbox" value="Loose Diamonds" id="a_6" class="bgcolor" <?php if(preg_match('/Loose Diamonds/',$wa_jewellery)){ echo ' checked="checked"'; } ?> /> <label for="a_6">Loose Diamonds</label></div>
        <div class="chkbox"><input name="wa_jewellery[]" type="checkbox" value="Loose Colour stones" id="a_7" class="bgcolor" <?php if(preg_match('/Loose Colour stones/',$wa_jewellery)){ echo ' checked="checked"'; } ?> /> <label for="a_7">Loose Colour stones</label></div>
        <div class="chkbox"><input name="wa_jewellery[]" type="checkbox" value="Pearls" id="a_9" class="bgcolor" <?php if(preg_match('/Pearls/',$wa_jewellery)){ echo ' checked="checked"'; } ?> /> <label for="a_8">Pearls</label></div>
        <div class="chkbox"><input name="wa_jewellery[]" type="checkbox" value="Lab Grown Diamond" id="a_10" class="bgcolor" <?php if(preg_match('/Lab Grown Diamond/',$wa_jewellery)){ echo ' checked="checked"'; } ?> /> <label for="a_9">Lab Grown Diamond</label></div>
        <div class="chkbox"><input name="wa_jewellery[]" type="checkbox" value="Coated Diamond" id="a_11" class="bgcolor" <?php if(preg_match('/Coated Diamond/',$wa_jewellery)){ echo ' checked="checked"'; } ?> /> <label for="a_10">Coated Diamond</label></div>
        <div class="chkbox"><input name="wa_jewellery[]" type="checkbox" value="CVD" id="a_11" class="bgcolor" <?php if(preg_match('/CVD/',$wa_jewellery)){ echo ' checked="checked"'; } ?> /> <label for="a_11">CVD / HPHT</label></div>
		<div class="chkbox"><input name="wa_jewellery[]" type="checkbox" value="machinery" id="a_13" class="bgcolor" <?php if(preg_match('/machinery/',$wa_jewellery)){ echo ' checked="checked"'; } ?> /> <label for="a_13">Machinery</label></div>
        <div class="chkbox"><input name="wa_jewellery[]" type="checkbox" value="Any Other" id = "wa_jewellery_other" class="bgcolor dropOther" <?php if(preg_match('/Any Other/',$wa_jewellery)){ echo ' checked="checked"'; } ?> /> <label for="a_12">Any Other (Specify)</label></div>
                
        <div class="clear"></div>        
        <div id = "wa_jewellery_other_text" style="display:none;margin-top:10px;">Any other : <input type="text" name="wa_jewellery_other_text" id="wa_jewellery_other_input" class="bgcolor" value="<?php echo $we_are_jewellery_any_other; ?>" />&nbsp;&nbsp;&nbsp;<span id="wa_jewellery_text_error" style="color:red;font-size:11px"></span></div>                
        </div>
        <div class="clear"></div>
        </div>
                
        <div class="field_box">
        <div class="field_name">Business Nature : &nbsp; <span id="wa_machinery_error" class="error_mg"></span></div>
        <div class="field_name"></div>
        <div class="field_input" style="padding-top:5px;">
        	 <div class="chkbox"><input type="checkbox" name="wa_machinery[]" value="Manufacturer" id="b_4" class="bgcolor" <?php if(preg_match('/Manufacturer/',$wa_machinery)){ echo ' checked="checked"'; } ?> /> <label for="b_4">Manufacturer</label></div>
        	 <div class="chkbox"><input type="checkbox" name="wa_machinery[]" value="Wholesaler-Retailer" id="b_2" class="bgcolor" <?php if(preg_match('/Wholesaler-Retailer/',$wa_machinery)){ echo ' checked="checked"'; } ?> />  <label for="b_2">Wholesaler</label></div>
        <div class="chkbox"><input type="checkbox" name="wa_machinery[]" value="Retailer" id="b_1" class="bgcolor" <?php if(preg_match('/Retailer/',$wa_machinery)){ echo ' checked="checked"'; } ?> />  <label for="b_1">Retailer</label></div>
        
        <div class="chkbox"><input type="checkbox" name="wa_machinery[]" value="Importer-Exporter" id="b_3" class="bgcolor" <?php if(preg_match('/Importer-Exporter/',$wa_machinery)){ echo ' checked="checked"'; } ?> /> <label for="b_3">Importer/Exporter</label></div>
       
        <div class="chkbox"><input type="checkbox" name="wa_machinery[]" value="Machinery Any Other" id = "wa_machinery_other" class="bgcolor dropOther" <?php if(preg_match('/Machinery Any Other/',$wa_machinery)){ echo ' checked="checked"'; } ?> /> <label for="b_11">Any Other (Specify)</label></div>
                
        <div class="clear"></div>        
        <div id = "wa_machinery_other_text" style="display:none; margin-top:10px;">Any other : <input type="text" id="wa_machinery_other_input" class="bgcolor" name="wa_machinery_other_text" value="<?php echo $we_are_machinery_any_other; ?>" />&nbsp;&nbsp;&nbsp;<span id="wa_machinery_text_error" style="color:red;font-size:11px"></span></div>      
                
        </div>
        <div class="clear"></div>
        </div>
        
        <div class="field_box">
        <div class="field_name">Company's Description <span>*</span> :</div>
        <div class="field_name"><span id="comp_desc_error" class="error_mg" ></span></div>
        <div class="clear"> </div>
        <div class="field_input" style="width:100%;">
        <textarea name="comp_desc" id="comp_desc" class=""><?php echo $comp_desc; ?></textarea>                
        </div>
        <div class="clear"></div>
        </div>                
        
        <div class="field_box">
        <div class="field_name">Last year's turn over in <?php echo $currency;?> <br />(e.g. 10000000) <span>*</span> :</div>
        <div class="field_input"><input type="text" id="last_yr_turn_over" name = "last_yr_turn_over" class="" value="<?php echo $last_yr_turn_over; ?>" />
        <br><span id="last_yr_turn_over_error" style="color:red;font-size:11px;"></span>
        </div>
        <div class="clear"></div>
        </div>
        
        <div class="clear" style="height:10px;"></div>       
    
        <div class="field_box">
        <div class="field_name"></div>
        <div class="field_input">
        	<a href="exhibitor_registration_step_1.php" class="button">Prev</a>
        <input type="submit" class="button" value="Proceed to Next Step" />
        <input type="hidden" name="action" id="action" value="Save"/>
        </div>
        <div class="clear"></div>
        </div>
	
	  
    <div class="clear"></div>
	</div>
	</form>
    <div class="clear"></div>
	</div>

	<div class="right_area">
    <?php include('include_account_links.php'); ?>
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

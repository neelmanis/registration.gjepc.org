<?php include('header_include.php');
if(!isset($_SESSION['USERID'])){ header("location:login.php");exit;}
if(($_SESSION['eventInfo']['event_selected'] =="")){ header("location:event_selection.php");	exit; }
if($_SESSION['eventInfo']['event_selected']=='combo'){ header("location:event_selection.php");	exit; }
$event_selected = $_SESSION['eventInfo']['event_selected'];

/*  Check Event */
 if($_SESSION['eventInfo']['event_selected']=="signature"){ $event_for="IIJS SIGNATURE 2022"; } 
 if($_SESSION['eventInfo']['event_selected']=="iijs") { $event_for="IIJS 2021"; }

 /*  Check Event */
?>
<?php
//echo '<pre>'; print_r($_SESSION); exit;
$registration_id=$_SESSION['USERID'];
$gid = intval($_REQUEST['gid']);
$action=@$_REQUEST['action'];
if($action=="Save")
{
	$exh_id=$_REQUEST['exh_id'];
	$last_yr_participant=$conn->real_escape_string($_REQUEST['last_yr_participant']);
	$option=$conn->real_escape_string($_REQUEST['option']);
	$section=$conn->real_escape_string($_REQUEST['section']);
	$selected_area=$conn->real_escape_string($_REQUEST['selected_area']);
	$category=$conn->real_escape_string($_REQUEST['category']);
	$selected_scheme_type=$conn->real_escape_string($_REQUEST['selected_scheme_type']);
	$selected_premium_type=$conn->real_escape_string($_REQUEST['selected_premium_type']);
	$woman_entrepreneurs=$_REQUEST['woman_entrepreneurs'];
	
	$tot_space_cost_rate=$conn->real_escape_string($_REQUEST['tot_space_cost_rate']);	
	if($tot_space_cost_rate=='')
		$tot_space_cost_rate=0;
	
	$tot_space_cost_discount=$conn->real_escape_string($_REQUEST['tot_space_cost_discount']);	
	if($tot_space_cost_discount=='')
		$tot_space_cost_discount=0;
	
	$get_tot_space_cost_rate=$conn->real_escape_string($_REQUEST['get_tot_space_cost_rate']);	
	if($get_tot_space_cost_rate=='')
		$get_tot_space_cost_rate=0;  
	
	$get_category_rate=$conn->real_escape_string($_REQUEST['get_category_rate']);	
	if($get_category_rate=='')
		$get_category_rate=0;
	
	$selected_scheme_rate=$conn->real_escape_string($_REQUEST['selected_scheme_rate']);	
	if($selected_scheme_rate=='')
		$selected_scheme_rate=0;
		
	$selected_premium_rate=$conn->real_escape_string($_REQUEST['selected_premium_rate']);	
	if($selected_premium_rate=='')
		$selected_premium_rate=0;
		
	$sub_total_cost=$conn->real_escape_string($_REQUEST['sub_total_cost']);	
	if($sub_total_cost=='')
		$sub_total_cost=0;
	$mezzanine_space_charges=$conn->real_escape_string($_REQUEST['mezzanine_space_charges']);
	if($mezzanine_space_charges=='')
		$mezzanine_space_charges=0;
		
	$security_deposit=$conn->real_escape_string($_REQUEST['security_deposit']);
	if($security_deposit=='')
		$security_deposit=0;
		
	$country=$conn->real_escape_string($_REQUEST['country']);
	$govt_service_tax=$_REQUEST['govt_service_tax'];
	$grand_total=$_REQUEST['grand_total'];
	if($grand_total=='')
		$grand_total=0;
		
	$mcb_charges=$_REQUEST['mcb_charges'];
	if($mcb_charges=='')	
		$mcb_charges=0;
	$created_date=date('Y-m-d');
	
	if(strtoupper($_SESSION['COUNTRY'])=="IN")
	  $currency = "";
	else
		$currency = "USD";

	 $stallInfo = array('option'=>$option,'woman_entrepreneurs'=>$woman_entrepreneurs,'last_yr_participant'=>$last_yr_participant,'section'=>$section,'category'=>$category,'selected_area'=>$selected_area,'selected_scheme_type'=>$selected_scheme_type,'selected_premium_type'=>$selected_premium_type,'tot_space_cost_rate'=>$tot_space_cost_rate,'tot_space_cost_discount'=>$tot_space_cost_discount,'get_tot_space_cost_rate'=>$get_tot_space_cost_rate,'get_category_rate'=>$get_category_rate,'mezzanine_space_charges'=>$mezzanine_space_charges,'selected_scheme_rate'=>$selected_scheme_rate,'selected_premium_rate'=>$selected_premium_rate,'sub_total_cost'=>$sub_total_cost,'security_deposit'=>$security_deposit,'govt_service_tax'=>$govt_service_tax,'grand_total'=>$grand_total,'mcb_charges'=>$mcb_charges,'show'=>$event_for);
	// print_r($stallInfo);
	 $_SESSION['stallInfo'] =$stallInfo;
	
header('location:exhibitor_registration_step_4.php');
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Exhibitor Registration - Participation Stall Details</title>
<link rel="icon" href="https://gjepc.org/assets/images/fav_icon.png" type="image/x-icon"/>
<link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Cabin'>
<link rel="stylesheet" type="text/css" href="css/general.css?v=<?php echo $version;?>"/>
<link rel="stylesheet" type="text/css" href="css/inner_pg_style.css?v=<?php echo $version;?>" />
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
<style>.btn{padding:5px 10px;border:1px solid#ccc;margin-bottom:10px;display:inline-block}</style>
<style>
#status {
    width: 200px;
    height: 100px;
    position: absolute;
    left: 40%;
    top: 40%;
    margin: -22px 0 0 -22px;
    display: none;
}
#getDiscountRate
{ display:none;
}
</style>
<script>
$(document).ready(function(){
  $("#calculate").click(function(){	

  section=$("#section").val();
  selected_area=$("#selected_area").val();
  selected_scheme_type=$("#selected_scheme_type").val();
  category=$('#category').val();
  selected_premium_type=$("#selected_premium_type").val();
  last_yr_participant=$("#last_yr_participant").val();
  woman_entrepreneurs=$('[name=woman_entrepreneurs]:checked').val();
  <?php if($event_selected=='iijs'){ ?>
  var url = 'iijs_combo_ajax.php';
  <?php } else if($event_selected=='signature'){ ?>
  var url = 'signature_combo_ajax.php';
  <?php } ?>
  
		$.ajax({ 		
					type: 'POST',
					url: url,
					data: "actiontype=calculatePayment&&section="+section+"&&selected_area="+selected_area+"&&selected_scheme_type="+selected_scheme_type+"&&selected_premium_type="+selected_premium_type+"&&woman_entrepreneurs="+woman_entrepreneurs+"&&category="+category+"&&last_yr_participant="+last_yr_participant,
					dataType:'html',
					beforeSend: function(){
							$('#preloader').show();
							$('#status').show();
							},
					success: function(data){
							    //alert(data);return false;
								$('#preloader').hide();
								$('#status').hide();
								var data=data.split("#");
								$('#tot_space_cost_rate').val(data[0]);
							//	$('#tot_space_cost_discount').val(data[1]);
							//	$('#get_tot_space_cost_rate').val(data[2]);
								$('#get_category_rate').val(data[1]);
								$('#selected_scheme_rate').val(data[2]);
								$('#selected_premium_rate').val(data[3]); 
								$('#sub_total_cost').val(data[4]);
								$('#security_deposit').val(data[5]);
								$('#govt_service_tax').val(data[6]);
								$('#grand_total').val(data[7]);
								
								$('#getDiscountRate').show();
								/*$('#mcb_charges').val(data[8]);*/
							}
		});
 });
 
	if($("input[name=woman_entrepreneurs]:checked").val()=="1")
	{
		$("#women_desc").css("display","block");
		//$("#chequeordd").css("display","none");
	}
	else
	{
		$("#women_desc").css("display","none");
		//$("#chequeordd").css("display","block");
	}
	
	$("input:radio[name=woman_entrepreneurs]").click(function(){
		var value = $(this).val();
		//alert(value);
		
		if(value == "1")
		{
			$("#women_desc").css("display","block");
			//$("#chequeordd").css("display","none");
		}
		else
		{
			$("#women_desc").css("display","none");
			//$("#chequeordd").css("display","block");
		}
	});
});
</script>
<script src="jsvalidation/jquery.validate.js" type="text/javascript"></script> 
<link rel="stylesheet" type="text/css" media="screen" href="css/rcmc.validation.css" /> 

<script type="text/javascript">
$().ready(function() {
	$("#commentForm").validate();
	$("#form1").validate({
		rules: {  
			section: {
			required: true,
			},  
			selected_area: {
				required: true,
			},  
			selected_scheme_type: {
				required: true,
			},
			selected_premium_type: {
				required: true,
			},
			option: {
				required: true,
			},
			tot_space_cost_rate:{
			required: true,
			},
		},
		messages: {   
			section: {
				required: "Please select section",
			},
			selected_area: {
				required: "Please select area",
			},  
			selected_scheme_type: {
				required: "Please select scheme type",
			},
			selected_premium_type: {
				required: "Please enter premium type",
			},
			option:{
			required: "Please select a option",
			},
			tot_space_cost_rate:{
			required: "Please calculate before final submission",
			},
	 }
	});
});
</script>
<script>
  $("#section").live('change',function(){
  	  section=$("#section").val();
	  selected_area=$("#selected_area_hid").val();
	  option=$("input[name='option']:checked").val();
	  $('#tot_space_cost_rate').val('');
	  $('#tot_space_cost_discount').val('');
	  $('#get_tot_space_cost_rate').val('');
	  $('#selected_scheme_rate').val('');
	  $('#selected_premium_rate').val('');
	  $('#sub_total_cost').val('');
	  $('#security_deposit').val('');
	  $('#govt_service_tax').val('');
	  $('#grand_total').val('');
	  
	  <?php if($event_selected=='iijs'){ ?>
	  var url = 'iijs_combo_ajax.php';
	  <?php } else if($event_selected=='signature'){ ?>
	  var url = 'signature_combo_ajax.php';
	  <?php } ?>
	  
	  $.ajax({ type: 'POST',
					url: url,
					data: "actiontype=selectArea&&section="+section+"&&option="+option+"&&selected_area="+selected_area,
					dataType:'html',
					beforeSend: function(){
							$('#preloader').show();
							$('#status').show();
							},
					success: function(data){
								//alert(data);
							$('#preloader').hide();
							$('#status').hide();
							$("#selected_area").html(data);
							}
		});
});
</script>
<!--<script>
  $("#section").live('change',function(){
	  $('#tot_space_cost_rate').val('');
	  $('#mezzanine_space_charges').val('');
	  $('#selected_scheme_rate').val('');
	  $('#selected_premium_rate').val('');
	  $('#sub_total_cost').val('');
	  $('#security_deposit').val('');
	  $('#govt_service_tax').val('');
	  $('#grand_total').val('');
	  $('#mcb_charges').val('');
 });
</script>-->
<script>
  $("#category").live('change',function(){
	  $('#tot_space_cost_rate').val('');
	  $('#tot_space_cost_discount').val('');
	  $('#get_tot_space_cost_rate').val('');
	  $('#mezzanine_space_charges').val('');
	  $('#selected_scheme_rate').val('');
	  $('#selected_premium_rate').val('');
	  $('#sub_total_cost').val('');
	  $('#security_deposit').val('');
	  $('#govt_service_tax').val('');
	  $('#grand_total').val('');
	  $('#mcb_charges').val('');
 });
</script>

<script>
  $("#selected_area").live('change',function(){
	  $('#tot_space_cost_rate').val('');
	  $('#tot_space_cost_discount').val('');
	  $('#get_tot_space_cost_rate').val('');
	  $('#mezzanine_space_charges').val('');
	  $('#selected_scheme_rate').val('');
	  $('#selected_premium_rate').val('');
	  $('#sub_total_cost').val('');
	  $('#security_deposit').val('');
	  $('#govt_service_tax').val('');
	  $('#grand_total').val('');
	  $('#mcb_charges').val('');
 });
</script>

<script>
  $("#selected_scheme_type").live('change',function(){
	  $('#tot_space_cost_rate').val('');
	  $('#tot_space_cost_discount').val('');
	  $('#get_tot_space_cost_rate').val('');
	  $('#mezzanine_space_charges').val('');
	  $('#selected_scheme_rate').val('');
	  $('#selected_premium_rate').val('');
	  $('#sub_total_cost').val('');
	  $('#security_deposit').val('');
	  $('#govt_service_tax').val('');
	  $('#grand_total').val('');
	  $('#mcb_charges').val('');
 });
</script>

<script>
  $("#selected_premium_type").live('change',function(){
	  $('#tot_space_cost_rate').val('');
	  $('#tot_space_cost_discount').val('');
	  $('#get_tot_space_cost_rate').val('');
	  $('#mezzanine_space_charges').val('');
	  $('#selected_scheme_rate').val('');
	  $('#selected_premium_rate').val('');
	  $('#sub_total_cost').val('');
	  $('#security_deposit').val('');
	  $('#govt_service_tax').val('');
	  $('#grand_total').val('');
	  $('#mcb_charges').val('');
 });
</script>

<script>
  /*$("#option").live('change',function(){
	  option=$('input[name=option]:checked').val();
	  //alert(option);
	  lastYearArea=$('#lastYearArea').val();
	$.ajax({ type: 'POST',
					url: 'iijs_combo_ajax.php',
					data: "actiontype=optionValue&&option="+option+"&&lastYearArea="+lastYearArea,
					dataType:'html',
					beforeSend: function(){
							},
					success: function(data){
					//alert(data);
						if($.trim(data)!=""){
							$('#selected_area').html(data);
						}
					}
		});
 });*/
</script>
<script>
/*$("#section").live('change',function(){
var section=$("#section").val();
if(section=="plain_gold")
{
	if($("#selected_area").is(":contains('12')"))
	{
		$("#selected_area option[value='24']").remove();
	}else
	{
			if($("#selected_area").is(":contains('9')"))
		{
			$("#selected_area").append("<option value='12'>12</option>");
		}
	}
}else if(section=="allied")
{
	if($("#selected_area").is(":contains('12')"))
	{
	$("#selected_area").append("<option value='24'>24</option>");
	}else
	{
		$("#selected_area").append("<option value='12'>12</option>");
	}
	
}else
{
	$("#selected_area option[value='12']").remove();
	$("#selected_area option[value='24']").remove();
}
});
*/</script>
<script>

  /*$("#section").live('change',function(){
	section=$('#section').val();
    $.ajax({ type: 'POST',
					url: 'iijs_combo_ajax.php',
					data: "actiontype=getCategory&&section="+section,
					dataType:'html',
					beforeSend: function(){
							},
					success: function(data){
					//alert(data);
					$('#category').html(data);
					}
		});
 }); */
</script>
<script>
/*  $("#category").live('change',function(){
	category=$('#category').val();
    $.ajax({ type: 'POST',
					url: 'iijs_combo_ajax.php',
					data: "actiontype=getSchemeType&&category="+category,
					dataType:'html',
					beforeSend: function(){
							},
					success: function(data){
					//alert(data);
					$('#selected_scheme_type').html(data);
					}
		});
 });*/
 $("#selected_area").live('change',function(){
	selected_area=$('#selected_area').val();
	 <?php if($event_selected=='iijs'){ ?>
	  var url = 'iijs_combo_ajax.php';
	  <?php } else if($event_selected=='signature'){ ?>
	  var url = 'signature_combo_ajax.php';
	  <?php } ?>
    $.ajax({ type: 'POST',
					url: url,
					data: "actiontype=getPremiumType&&selected_area="+selected_area,
					dataType:'html',
					beforeSend: function(){
							$('#preloader').show();
							$('#status').show();
							},
					success: function(data){
					//console.log(data);
					$('#preloader').hide();
					$('#status').hide();
					var res = data.split("#");
					if($.trim(res[0])!=""){
							$('#selected_scheme_type').html(res[0]);
						}
					if($.trim(res[1])!=""){
						$('#selected_premium_type').html(res[1]);
					}
				}
		});
 });
</script>
<script>
  $("#option").live('change',function(){
	  option=$('input[name=option]:checked').val();
	  
	  if($('#section_hid').val()!='')
	  		var section=$('#section_hid').val();
	  else
	  		var section=$("#section").val();
			
	 if($('#selected_scheme_type_hid').val()!='')
	  		var selected_scheme_type=$('#selected_scheme_type_hid').val();
	  else
	  		var selected_scheme_type=$("#selected_scheme_type").val();
		
	if($('#selected_premium_type_hid').val()!='')
	  		var selected_premium_type=$('#selected_premium_type_hid').val();
	  else
	  		var selected_premium_type=$("#selected_premium_type").val();
		<?php if($event_selected=='signature'){ ?>
		if(option=="Same stall position size as of previous year")
		{

			 $("#section").attr("disabled", "disabled");
			$("#selected_area").attr("disabled", "disabled");
			$("#category").attr("disabled", "disabled");
			$("#selected_premium_type").attr("disabled", "disabled");
			$("#selected_scheme_type").removeAttr("disabled");
			
			$("#section_hid").removeAttr("disabled");
			$("#selected_area_hid").removeAttr("disabled");
			$("#category_hid").removeAttr("disabled");
			$("#selected_premium_type_hid").removeAttr("disabled");
			$("#selected_scheme_type_hid").attr("disabled", "disabled");

			$("#section").val($("#section_hid").val());
			$("#selected_area").val($("#selected_area_hid").val());
			$("#category").val($("#category_hid").val());
			$("#selected_premium_type").val($("#selected_premium_type_hid").val());
			
			var selected_area=$("#selected_area_hid").val();
			if(selected_area==9 || selected_area==12)
				$("#selected_scheme_type").html("<option value='BI2'>Old Shell Scheme</option><option value='BI1'>New Shell Scheme</option>");	
		}
		else if(option=="Same area but different location as of previous year Signature")
		{

			// $("#section").attr("disabled", "disabled");
			$("#section").removeAttr("disabled");
			$("#category").removeAttr("disabled");
			$("#selected_premium_type").removeAttr("disabled");
			$("#section_hid").removeAttr("disabled");
			$("#selected_scheme_type").removeAttr("disabled");
			
			$("#selected_area").attr("disabled", "disabled"); 
			$("#section_hid").attr("disabled", "disabled");
			$("#category_hid").attr("disabled", "disabled");
			$("#selected_premium_type_hid").attr("disabled", "disabled");
			$("#selected_scheme_type_hid").attr("disabled", "disabled");
			
			$("#section").val($("#section_hid").val());
		}
		else if(option=="More area than previous year Signature")
		{
			// $("#section").attr("disabled", "disabled");
			$("#section").removeAttr("disabled");
			$("#selected_area").removeAttr("disabled");
			$("#category").removeAttr("disabled");
			$("#selected_premium_type").removeAttr("disabled"); 
			$("#selected_scheme_type").removeAttr("disabled");
			
			$("#selected_area_hid").attr("disabled", "disabled");
			$("#category_hid").attr("disabled", "disabled");
			$("#selected_premium_type_hid").attr("disabled", "disabled");
			$("#selected_scheme_type_hid").attr("disabled", "disabled");
			$("#section_hid").attr("disabled", "disabled");
		}
		else if(option=="Less area as previous year")
		{
			$("#section").removeAttr("disabled");
			// $("#section").attr("disabled", "disabled");
			$("#selected_area").removeAttr("disabled");
			$("#category").removeAttr("disabled");
			$("#selected_premium_type").removeAttr("disabled");
			$("#selected_scheme_type").removeAttr("disabled");			
			
			$("#section_hid").attr("disabled", "disabled");
			$("#selected_area_hid").attr("disabled", "disabled");
			$("#category_hid").attr("disabled", "disabled");
			$("#selected_premium_type_hid").attr("disabled", "disabled");
			$("#selected_scheme_type_hid").attr("disabled", "disabled");
		}
		<?php } ?>
		<?php if($event_selected=='iijs'){ ?>

		  if(option=="Same stall")
		  {
			$("#section").attr("disabled", "disabled");
			$("#selected_area").attr("disabled", "disabled");
			$("#category").attr("disabled", "disabled");
			$("#selected_premium_type").attr("disabled", "disabled");
			$("#selected_scheme_type").removeAttr("disabled");
			
			$("#section_hid").removeAttr("disabled");
			$("#selected_area_hid").removeAttr("disabled");
			$("#category_hid").removeAttr("disabled");
			$("#selected_premium_type_hid").removeAttr("disabled");
			$("#selected_scheme_type_hid").attr("disabled", "disabled");
			var selected_area=$("#selected_area_hid").val();
			if(selected_area==9 || selected_area==12)
				$("#selected_scheme_type").html("<option value='RW'>Raw Space</option><option value='BI1'>Shell Scheme A</option>");	
		  }
		  else if(option=="Same area but different location as of previous year IIJS")
		  {
			$("#section").attr("disabled", "disabled");
			$("#category").attr("disabled", "disabled");
			$("#selected_premium_type").removeAttr("disabled"); 
			$("#selected_scheme_type").removeAttr("disabled");
			$("#selected_area").attr("disabled", "disabled");
			
			$("#selected_area_hid").removeAttr("disabled");
			$("#category_hid").removeAttr("disabled");
			
			$("#selected_scheme_type_hid").attr("disabled", "disabled");
			$("#selected_premium_type_hid").attr("disabled", "disabled");
			$("#section_hid").removeAttr("disabled");
			var selected_area=$("#selected_area_hid").val();
		  }
		  else if(option=="More area than previous year IIJS")
		  {

			$("#section").attr("disabled", "disabled");
			$("#category").attr("disabled", "disabled");
			$("#selected_area").removeAttr("disabled");
			$("#selected_scheme_type").removeAttr("disabled");
			$("#selected_premium_type").removeAttr("disabled");
			
			$("#category_hid").removeAttr("disabled");
			$("#selected_area_hid").attr("disabled", "disabled");
			$("#selected_scheme_type_hid").attr("disabled", "disabled");
			$("#selected_premium_type_hid").attr("disabled", "disabled");
			$("#section_hid").removeAttr("disabled");
			$('#selected_premium_type').prop("selectedIndex", 0);
		 }
		  else if(option=="Less area as previous year at diffrent location")
		  {
			$("#section").attr("disabled", "disabled");
			$("#category").attr("disabled", "disabled");
			$("#selected_area").removeAttr("disabled");
			$("#selected_scheme_type").removeAttr("disabled");
			$("#selected_premium_type").removeAttr("disabled");
			
			$("#category_hid").removeAttr("disabled");
			$("#selected_area_hid").attr("disabled", "disabled");
			$("#selected_scheme_type_hid").attr("disabled", "disabled");
			$("#selected_premium_type_hid").attr("disabled", "disabled");
			var selected_area=$("#selected_area_hid").val();
			$("#section_hid").removeAttr("disabled");
			$('#selected_premium_type').prop("selectedIndex", 0);
			
			//if(selected_area=='9')
				//$("#selected_scheme_type").html("<option value='RW'>Raw Space</option><option value='BI1'>Shell Scheme Ae</option>");
		  }
		  else if(option=="Less area as previous year")
		  {
			$("#section").attr("disabled", "disabled");
			$("#category").attr("disabled", "disabled");
			$("#selected_area").removeAttr("disabled");
			$("#selected_scheme_type").removeAttr("disabled");
			$("#selected_premium_type").removeAttr("disabled");
			
			$("#section_hid").removeAttr("disabled");
			$("#category_hid").removeAttr("disabled");
			$("#selected_area_hid").attr("disabled", "disabled");
			$("#selected_scheme_type_hid").attr("disabled", "disabled");
			$("#selected_premium_type_hid").attr("disabled", "disabled");
			$('#selected_premium_type').prop("selectedIndex", 0);
		  }
		<?php } ?>
	  
	  lastYearArea=$('#lastYearArea').val();
	  $("#im_registration_no").attr("disabled", "disabled");
	  
	  $('#tot_space_cost_rate').val('');
	  $('#tot_space_cost_discount').val('');
	  $('#get_tot_space_cost_rate').val('');
	  $('#mezzanine_space_charges').val('');
	  $('#selected_scheme_rate').val('');
	  $('#selected_premium_rate').val('');
	  $('#sub_total_cost').val('');
	  $('#security_deposit').val('');
	  $('#govt_service_tax').val('');
	  $('#grand_total').val('');
	  $('#mcb_charges').val('');
	  
	  <?php if($event_selected=='iijs'){ ?>
	  var url = 'iijs_combo_ajax.php';
	  var getdata = "actiontype=optionValue&&option="+option+"&&lastYearArea="+lastYearArea+"&&section="+section+"&selected_scheme_type="+selected_scheme_type+"&selected_premium_type="+selected_premium_type;
	  <?php } else if($event_selected=='signature'){ ?>
	  var url = 'signature_combo_ajax.php';
	  var getdata = "actiontype=optionValue&&option="+option+"&&lastYearArea="+lastYearArea+"&&section="+section;
	  <?php } ?>
	   
	 //alert(lastYearArea);
	 
		$.ajax({ 		
					type: 'POST',
					url: url,
					data: getdata,
					dataType:'html',
					beforeSend: function(){
							$('#preloader').show();
							$('#status').show();
							},
					success: function(data){ 
						//alert(data);
						//console.log(data)
						var res = data.split("#");
						$('#preloader').hide();
						$('#status').hide();
						<?php if($event_selected=='iijs'){ ?>
						if($.trim(res[0])!=""){
							$('#section').html(res[0]);
						}
						if($.trim(res[1])!=""){
							$('#selected_area').html(res[1]);
						}
						if($.trim(res[2])!=""){
							$('#selected_scheme_type').html(res[2]);
						}
						if($.trim(res[3])!=""){
							$('#selected_premium_type').html(res[3]);
						}
						<?php } else { ?>
						if($.trim(res[0])!=""){
							$('#selected_area').html(res[0]);
						}
						if($.trim(res[1])!=""){
							$('#selected_scheme_type').html(res[1]);
						}
						<?php } ?>
					}
		});	
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

</head>
<body>
<div class="wrapper">
<div class="header">
	<?php include('header1.php'); ?>
</div>
<div id="preloader">
 <div id="status"> <img src="https://gjepc.org/assets/images/logo.png"></div>
</div>
<div class="inner_container">
    <div class="clear"></div>
    
    <div class="content_area">
      <div class="pg_title">
        <div class="title_cont"> <span class="top">Exhibitor <img src="images/titles/joint.png" style="position:absolute; top:31px; right:0px;" /></span> <span class="below">Registration</span>
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
			  <input type="radio" disabled="disabled">
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
		</div>
        <div class="title"><h4 style="padding:10px 15px;text-align: center; color: #fff; display: table; background: #00000099; margin: 20px auto; border: 1px solid#000; -webkit-box-shadow: 0px 0px 11px -2px rgba(0,0,0,1); -moz-box-shadow: 0px 0px 11px -2px rgba(0,0,0,1); box-shadow: 0px 0px 11px -2px rgba(0,0,0,1); border-radius: 6px;">PARTICIPATION STALL DETAILS</h4></div>
		<!--  <div style="text-align: center;margin-bottom:10px "><a href="pdf/New-Shell-Scheme.pdf" style="margin-right: 10px;text-decoration: underline;" title="Click here to view New Shell Scheme" target="_blank"> New Shell Scheme</a><a style="margin-right: 10px;text-decoration: underline;" href="pdf/Old-Shell-Scheme.pdf" title="Click here to view old shell scheme" target="_blank">Old Shell Scheme</a></div> -->
		
    <form action="" method="post" name="form1" id="form1">
    <div class="form_main">
    <!--<div><a href="http://gjepc.org/emailer_gjepc/22.04.2019/01/Mezzanine_docket.rar" style="color:red;float:left" target="_blank" class="btn"> Click Here to Downlaod Mezzanine Booth Docket</a> <a href="https://gjepc.org/emailer_gjepc/22.04.2019/01/Annexure_II_New_Booth_Design.pdf" target="_blank" style="color:red;cursor:pointer;float:right"  class="btn">New Shell Scheme Description (Click here)</a></div>-->
    <div class="clear"></div>
    
    <div style="float:right; font-size:13px; font-weight:bold;"></div>    
    <div class="clear"></div>
    <?php 
	/*...........................Last year participant  ..........................*/
	//echo "select * from exh_registration where uid='$registration_id' and `show`='IIJS Signature 2019' and last_yr_section_flag='1' and  curr_last_yr_check='N' order by exh_id desc limit 0,1";
	  
	if($event_selected=='iijs'){ $lastYearEvent = "IIJS 2019"; }
	if($event_selected=='signature'){ $lastYearEvent = "IIJS Signature 2020"; }
	
	 $last_query = "select * from exh_registration where uid='$registration_id' AND `show`='$lastYearEvent' AND last_yr_section_flag='1' AND  curr_last_yr_check='N' order by exh_id desc limit 0,1";
	$query1=$conn->query($last_query);
	$result1=$query1->fetch_assoc();
	$exh_id=$result1['exh_id'];
	$retain_restrict=$result1['retain_restrict'];
	$num1=$query1->num_rows;

	$query=$conn->query("select * from exh_registration where uid='$registration_id' AND `show`='$event_for' AND event_selected='$event_selected'");
	$result=$query->fetch_assoc();
	$num=$query->num_rows;
	if($num1>0)
	{
		$option=$result1['options'];
		$category=$result1['category'];
		$selected_area=$result1['selected_area'];
		$section=$result1['section'];
		$selected_scheme_type=$result1['selected_scheme_type'];
		$selected_premium_type=$result1['selected_premium_type'];
	}
	else
	{
		$section=$result['section'];
		$category=$result['category'];
		$option=$result['options'];
		$selected_area=$result['selected_area'];
		$stall_options=$result['stall_options'];
		$selected_scheme_type=$result['selected_scheme_type'];
		$selected_premium_type=$result['selected_premium_type'];
		$tot_space_cost_rate=$result['tot_space_cost_rate'];
		$selected_scheme_rate=$result['selected_scheme_rate'];
		$selected_premium_rate=$result['selected_premium_rate'];
		$sub_total_cost=$result['sub_total_cost'];
		$security_deposit=$result['security_deposit'];
		$govt_service_tax=$result['govt_service_tax'];
		$grand_total=$result['grand_total'];
		$mezzanine_space_charges=$result['mezzanine_space_charges'];
		$mcb_charges=$result['mcb_charges'];
		$woman_entrepreneurs=$result['woman_entrepreneurs'];		
    }
	?>
        <div class="field_box">
            <div class="field_name">Last year participant :</div>
            <div class="field_input" style="padding-top:5px;">
            <div class="chkbox" style="width:100px;">
              <span class="chkbox" style="width:100px;">
              <?php if($num1>0){ echo $last_yr="YES"; } else { echo $last_yr="NO"; } ?>
              </span>
              <input type="hidden" name="last_yr_participant" id="last_yr_participant" value="<?php echo $last_yr;?>"/>
            </div>
            </div>
            <div class="clear"></div>
        </div>
        <div class="field_box">
            <div class="field_name">Membership Status :</div>
            <div class="field_input" style="padding-top:5px;">
            <div class="chkbox" style="width:100px;">
              <?php echo $_SESSION['member_type'];?>
             </div>
            </div>
            <div class="clear"></div>
        </div>
        <?php  if($num1>0){?>
        <div class="field_box">
            <div class="field_name">Last year details :</div>
            <div class="field_input" style="padding-top:5px; line-height:25px;">
            <strong>Section :</strong><?php echo strtoupper($section);?><br />
            <strong>Area :</strong> <?php echo strtoupper($selected_area);?> <br />
            <strong>Scheme type :</strong> <?php echo $selected_scheme_type?> <br />
            <strong>Premium type :</strong> <?php echo strtoupper($selected_premium_type);?>           
            </div>
            <div class="clear"></div>
        </div>
        <?php } ?>
       <div class="field_box">
        <div class="field_name">Select any of the option <span>*</span> :</div>
        <div class="field_input" style="padding-top:5px; line-height:25px;">
        <input type="hidden" name="exh_id" id="exh_id" value="<?php echo $exh_id?>"/>
        <?php if($num1==0){ ?>
        <input type="radio" id="option" class="bgcolor" name="option"  checked="checked" value="New participant"/> <label for="b_1">New participant</label><br />
        <?php } else { ?>
		<?php if($event_selected=='iijs'){ ?>
        <input type="radio" id="option" class="bgcolor" name="option" value="Same stall" <?php /* if($option=="Same stall"){?> checked="checked" <?php } */?> /> Same stall position as offered by GJEPC refer Annexure 1.<br/>
        
        <input type="radio" id="option" class="bgcolor" name="option" value="Same area but different location as of previous year IIJS" <?php /*if($option=="Same area but different location as of previous year IIJS"){?> checked="checked" <?php } */?> /> 
        Same area but different location as offered by GJEPC refer Annexure 1.<br/>  
        
        <input type="radio" id="option" class="bgcolor" name="option" value="More area than previous year IIJS" <?php /*if($option=="More area than previous year IIJS"){?> checked="checked" <?php } */?> /> 
        More area than previous year IIJS<br/>
        
        <?php if($selected_area>9){ ?>
        <input type="radio" id="option" class="bgcolor" name="option" value="Less area as previous year at diffrent location" <?php /*if($option=="Less area as previous year at diffrent location"){?> checked="checked" <?php } */?> /> Less area as previous year at diffrent location<br/>
         <input type="radio" id="option" class="bgcolor" name="option" value="Less area as previous year" <?php /*if($option=="Less area as previous year"){?> checked="checked" <?php } */?> /> Less area as previous year at same location <?php }
		
		} else { ?>
		
		<!--<input type="radio" id="option" class="bgcolor" name="option" value="Same stall position size as of previous year" <?php /*if($option=="Same stall position size as of previous year"){?> checked="checked" <?php } */?> /> Same stall position as offered by GJEPC refer Annexure 1.<br/>-->
        
        <input type="radio" id="option" class="bgcolor" name="option" value="Same area but different location as of previous year Signature" <?php /*if($option=="Same area but different location as of previous year Signature"){?> checked="checked" <?php } */?>/> 
        Same area but different location as offered by GJEPC refer Annexure 1.<br/>
		
        <!--<input type="radio" id="option" class="bgcolor" name="option" value="More area than previous year Signature" <?php /*if($option=="More area than previous year Signature"){?> checked="checked" <?php } */?>/> More area than previous year<br/>-->
		<?php if($selected_area!=9){?>
        <input type="radio" id="option" class="bgcolor" name="option" value="Less area as previous year" <?php /*if($option=="Less area as previous year"){?> checked="checked" <?php } */?> /> Less area as previous year <?php } ?>
		
		<?php } ?>
		<?php } ?>
        </div>        
        <div class="clear"></div>
        </div>
		
        <div class="field_box">
        <div class="field_name">Select your section <span>*</span>:</div>
        <div class="field_input">
          <select name="section" id="section" class="bgcolor" <?php if($section!="" && ($_SESSION['COUNTRY']=="IN") && $num1!=0){?> disabled="disabled" <?php }?>>
          <option selected="selected" value="">-----Select Section----</option>
            <?php
			if($_SESSION['COUNTRY']=="IN")
			{
				if($_SESSION['member_type']=='MEMBER')
				{ 	
					if($event_selected=='iijs'){
					$sql="SELECT * FROM iijs_section_master where member_type ='MEMBER' and status='Y' ORDER BY section_desc";
					} else { 
					$sql="SELECT * FROM signature_section_master WHERE member_type ='MEMBER' AND status='Y' ORDER BY section_desc";
					}
				} else {
					if($event_selected=='iijs'){
					$sql="SELECT * FROM iijs_section_master where member_type ='NON_MEMBER' and status='Y' ORDER BY section_desc";
					} else { 
					$sql="SELECT * FROM signature_section_master WHERE member_type ='NON_MEMBER' and status='Y' ORDER BY section_desc";
					}
				}
            $query=$conn->query($sql);
            while($result=$query->fetch_assoc()){
            ?>
            <option value="<?php echo $result['section'];?>" <?php if($result['section']==trim($section)){?> selected="selected" <?php }?> ><?php echo strtoupper($result['section_desc']);?></option>
            <?php } } else { ?>
            <option value="International Jewellery" <?php if($section=="International Jewellery"){?> selected="selected" <?php }?>>International Jewellery</option>
            <option value="International Loose" <?php if($section=="International Loose"){?> selected="selected" <?php }?>>International Loose</option>
            <option value="machinery" <?php if($section=="machinery"){?> selected="selected" <?php }?>>Machinery</option>
            <!--<option value="Allied" <?php if($section=="Allied"){?> selected="selected" <?php }?>>Allied</option>-->            
            <?php } ?>
          </select>
          <?php if($section!="" && $num1>0){?><input type="hidden" name="section" id="section_hid" value="<?php echo $section;?>"/><?php }?>          
        </div>
        <div class="clear"></div>
        </div>
		
		<?php 
		if($event_selected=='iijs'){
		if($category!=""){?>
		<input type="hidden" name="category" id="category_hid" value="normal"/>
		<?php } } else { ?>
        
		<div class="field_box">
        <div class="field_name">Select your category <span>*</span>:</div>
        <div class="field_input">
          <select name="category" id="category" class="bgcolor" <?php if($category!=""){?> disabled="disabled"<?php }?>>
          <option selected="selected" value="">-----Select Category----</option>
            <?php 
			$sql="SELECT * FROM signature_category_master";
            $query=$conn->query($sql);
            while($result=$query->fetch_assoc()){
            ?>
            <option value="<?php echo $result['category'];?>" <?php if($result['category']==$category){?> selected="selected" <?php }?> ><?php echo $result['category_desc'];?></option>
            <?php }?>
          </select>
          <?php if($category!=""){?><input type="hidden" name="category" id="category_hid" value="<?php echo $category;?>"/><?php }?>
        </div>
        <div class="clear"></div>
        </div>
		<?php } ?>
        
		<?php if($event_selected=='iijs'){ ?>
        <div class="field_box">
        <div class="field_name">Select your area <span>*</span>:</div>
        <div class="field_input"> 
          <select name="selected_area" id="selected_area" class="bgcolor" <?php if($selected_area!="" && $num1!=0){?> disabled="disabled"<?php }?>>
            <option selected="selected" value="">-----Select Area----</option>
            <?php //if($section!='machinery'){
			if($num1==0){ $sql="SELECT * FROM iijs_area_master where area=6"; } 
			else if($selected_area==6){$sql="SELECT * FROM iijs_area_master where area=6 or area=18";}
			else if($selected_area==9){$sql="SELECT * FROM iijs_area_master where area=9 or area=18";}
			else if($selected_area==12){$sql="SELECT * FROM iijs_area_master where area=12 or area=27";}
			else if($selected_area==24){$sql="SELECT * FROM iijs_area_master where area=24 or area=45";}
			else if($selected_area==18){$sql="SELECT * FROM iijs_area_master where area=18 or area=25 or area=27";}
			else if($selected_area==25){$sql="SELECT * FROM iijs_area_master where area=25 or area=25 or area=36";}
			else if($selected_area==27){$sql="SELECT * FROM iijs_area_master where area=27 or area=36 or area=45";}
			else if($selected_area==28){$sql="SELECT * FROM iijs_area_master where area=28";}
			else if($selected_area==36){$sql="SELECT * FROM iijs_area_master where area=36 or area=45 or area=54";}
			else if($selected_area==45){$sql="SELECT * FROM iijs_area_master where area=45 or area=54 or area=72";}
			else if($selected_area==54){$sql="SELECT * FROM iijs_area_master where area=54 or area=72 or area=144" ;}
			else if($selected_area>54){$sql="SELECT * FROM iijs_area_master where area>54";}
			else {$sql="SELECT * FROM iijs_area_master order by area_id asc limit 0,1" ;}
				echo $sql;
				$query=$conn->query($sql);
				while($result=$query->fetch_assoc()){
            ?>
            <option value="<?php echo $result['area'];?>" <?php if($result['area']==$selected_area){?> selected="selected" <?php }?>><?php echo $result['area'];?></option>
            <?php }?>
          </select>
           <?php if($selected_area!=""){?><input type="hidden" name="selected_area" id="selected_area_hid" value="<?php echo $selected_area;?>"/><?php }?>
          
          <input type="hidden" name="lastYearArea" id="lastYearArea" value="<?php echo $selected_area;?>"/>
        </div>
        <div class="clear"></div>
        </div>
		<?php } else { ?>
		<div class="field_box">
        <div class="field_name">Select your area <span>*</span>:</div>
        <div class="field_input"> 
        	<select name="selected_area" id="selected_area" class="bgcolor" <?php if($selected_area!="" && $num1!=0){?> disabled="disabled"<?php }?>>
            <option selected="selected" value="">-----Select Area----</option>
            <?php 
			/*if($selected_area==9){$sql="SELECT * FROM iijs_area_master where area=9 or area=18 or area=25";}
			else if($selected_area==18){$sql="SELECT * FROM iijs_area_master where area=18 or area=25 or area=27";}
			else if($selected_area==25){$sql="SELECT * FROM iijs_area_master where area=25 or area=25 or area=36";}
			else if($selected_area==27){$sql="SELECT * FROM iijs_area_master where area=27 or area=36 or area=45";}
			else if($selected_area==36){$sql="SELECT * FROM iijs_area_master where area=36 or area=45 or area=54";}
			else if($selected_area==45){$sql="SELECT * FROM iijs_area_master where area=45 or area=54 or area=72";}
			else if($selected_area==54){$sql="SELECT * FROM iijs_area_master where area=54 or area=72 or area=144" ;}
			else if($selected_area>54){$sql="SELECT * FROM iijs_area_master order by area_id desc limit 0,2" ;}*/
			$sql="SELECT * FROM signature_area_master order by area_id asc";
			$query=$conn->query($sql);
			while($result=$query->fetch_assoc()){
            ?>
            <option value="<?php echo $result['area'];?>" <?php if($result['area']==$selected_area){?> selected="selected" <?php }?>><?php echo $result['area'];?></option>
            <?php }?>
           </select>
           <?php if($selected_area!=""){?><input type="hidden" name="selected_area" id="selected_area_hid" value="<?php echo $selected_area;?>"/><?php }?>          
          <input type="hidden" name="lastYearArea" id="lastYearArea" value="<?php echo $selected_area;?>"/>            
        </div>
		<div class="clear"></div>
        </div>
		<?php } ?>
		
		<?php if($event_selected=='iijs'){ ?>
        <?php if($section!='machinery'){ ?>
        <div class="field_box">
        <div class="field_name">Select your scheme type <span>*</span>:</div>
        <div class="field_input">
        <select class="bgcolor" id="selected_scheme_type" name="selected_scheme_type" <?php if($selected_scheme_type!="" && $num1!=0){?> disabled="disabled"<?php }?>>
        <option selected="selected" value="">-----Select Scheme Type----</option>
			<?php 
			$sql="SELECT * FROM iijs_scheme_master where status='Y'";
			$query=$conn->query($sql);
			while($result=$query->fetch_assoc()){
            ?>
            <option value="<?php echo $result['scheme'];?>" <?php if($selected_scheme_type==$result['scheme']){ echo "selected=selected"; }?> ><?php echo $result['scheme_desc'];?></option>
            <?php }?> 
         </select>
         <?php if($selected_scheme_type!="" && $num1>0){?>
         <input type="hidden" name="selected_scheme_type" id="selected_scheme_type_hid" value="<?php echo $selected_scheme_type;?>" />
		 <?php }?>
        </div>
        <div class="clear"></div>
        </div>
        <?php } else { ?>
        <input type="hidden" name="selected_scheme_type" id="selected_scheme_type" value="0"/>
        <?php } ?>
        <?php } else { ?>
		<?php if($section!='machinery'){ ?>
        <div class="field_box">
        <div class="field_name">Select your scheme type <span>*</span>:</div>
        <div class="field_input">
        <select class="bgcolor" id="selected_scheme_type" name="selected_scheme_type" <?php if($selected_scheme_type!="" && $num1!=0){?> disabled="disabled"<?php }?>>
        <option selected="selected" value="">-----Select Scheme Type----</option>
		<?php 
		$sql="SELECT * FROM signature_scheme_master where status='Y'";
		$query=$conn->query($sql);
		while($result=$query->fetch_assoc()){
        ?>
        <option value="<?php echo $result['scheme'];?>" <?php if($selected_scheme_type==$result['scheme']){ echo "selected=selected"; }?> ><?php echo $result['scheme_desc'];?></option>
        <?php } ?>        
         </select>
         <?php if($selected_scheme_type!="" && $num1>0){?>
         <input type="hidden" name="selected_scheme_type" id="selected_scheme_type_hid" value="<?php echo $selected_scheme_type;?>" />
		 <?php }?>
        </div>
        <div class="clear"></div>
        </div>
        <?php } else { ?>
        <input type="hidden" name="selected_scheme_type" id="selected_scheme_type" value="0"/>
        <?php } ?>
        <?php } ?>
		
		<?php if($event_selected=='iijs'){ ?>
        <div class="field_box">
        <div class="field_name">Select your premium type <span>*</span>:</div>
        <div class="field_input">
            <select class="bgcolor" name="selected_premium_type" id="selected_premium_type" <?php if($selected_premium_type!="" && $num1!=0){?> disabled="disabled"<?php }?>>
            <option selected="selected" value="">-----Select Premium Type----</option>
			<?php 
			if($num1==0)
				$sql="SELECT * FROM iijs_premium_master where status='Y' order by premium_id asc";
			else
				$sql="SELECT * FROM iijs_premium_master order by premium_id asc";
			$query=$conn->query($sql);
			while($result=$query->fetch_assoc()){
            ?>
            <option value="<?php echo $result['premium'];?>" <?php if($result['premium']==$selected_premium_type){?> selected="selected" <?php }?>><?php echo $result['premium_desc'];?></option>
            <?php }?> 
            </select>
            <?php if($selected_premium_type!="" && $num1>0){?><input type="hidden" name="selected_premium_type" id="selected_premium_type_hid" value="<?php echo $selected_premium_type;?>"/><?php }?>
        </div>
        <div class="clear"></div>
        </div>
		<?php } else { ?>
		<div class="field_box">
        <div class="field_name">Select your premium type <span>*</span>:</div>
        <div class="field_input">
       		<select class="bgcolor" name="selected_premium_type" id="selected_premium_type" <?php if($option=="Same stall position size as of previous year"){?> disabled="disabled"<?php } /*if($selected_premium_type!=""){?> disabled="disabled"<?php }*/?>>
            <option selected="selected" value="">-----Select Premium Type----</option>
			<?php 
			$sql="SELECT * FROM signature_premium_master order by premium_id asc";
			$query=$conn->query($sql);
			while($result=$query->fetch_assoc()){
            ?>
            <option value="<?php echo $result['premium'];?>" <?php if($result['premium']==$selected_premium_type){?> selected="selected" <?php }?>><?php echo $result['premium_desc'];?></option>
            <?php }?> 
            </select>
            <?php if($selected_premium_type!=""){?><input type="hidden" name="selected_premium_type" id="selected_premium_type_hid" value="<?php echo $selected_premium_type;?>"/><?php }?>
            <div class="clear"></div>
        </div>
        </div>		
		<?php } ?>
		
		<?php if($event_selected=='iijs'){ ?>
        <?php if($_SESSION['member_type']=="MEMBER"){ ?>
		<div class="field_box">
        <div class="field_name">Woman Entrepreneurs :</div>
        <div class="field_input" style="padding-top:5px;">
        <div class="chkbox" style="width:100px;"><input type="radio" id="woman_entrepreneurs" name="woman_entrepreneurs" class="bgcolor" value="1" <?php if($woman_entrepreneurs==1){?> checked="checked"<?php }?> /> <label for="c_1">Yes</label></div>
        <div class="chkbox" style="width:100px;"><input type="radio" id="woman_entrepreneurs" name="woman_entrepreneurs" class="bgcolor" value="0" <?php if($woman_entrepreneurs==0){?> checked="checked"<?php }?> /> <label for="c_2">No</label></div>                    
        </div>
        <div class="clear"></div>
        <div id="women_desc" style="margin-bottom:10px;font-size:12px;">
        <p><strong>As a special policy to promote and encourage Woman Entrepreneurs in the Industry, a special discount of 25% on the basic space rental (without the Construction cost for shell scheme) will be offered to any firm which is having the following characteristics:</strong> </p>
		   I. If the firm is a proprietorship / partnership concern (all women); and<br/>
		  II. Member of GJEPC for at least two years; and<br/>
		  III. Constitution of the firm in terms of partners / proprietors has not changed for those two years.<br/>
		  IV. The above scheme is open to participation by Indian firm only<br/>
		</div>
        </div>
        <?php } else { ?>
        <input type="hidden" name="woman_entrepreneurs" id="woman_entrepreneurs" value="0"/>
        <?php } } else { ?>
        <input type="hidden" name="woman_entrepreneurs" id="woman_entrepreneurs" value="0"/>
		<?php } ?>
		
        <div class="field_box">
        <div class="field_name"><strong style="color:#000; font-size:14px;">Application Summary :</strong><br />
        <span class="clear" style="height:1px; background:#ccc; display:block; margin-top:5px;"></span></div> 
        <div class="clear"></div>
        </div>
        
        <div class="field_box">
        <span style="display:inline-block; float:left; margin-right:10px; margin-top:10px;">Click on calculate button to calculate the figures</span>
        <input type="button" name="calculate" id="calculate" value="Calculate" class="button" />
        <!--<a href="#" class="button">Calculate</a>-->
        <div class="clear"></div>
        </div>                
        <div class="clear"></div>                
        
        <div class="field_box">
        <div class="field_name"><strong>Space cost rate </strong><?php echo $currency;?> :</div>
        <div class="field_input"><input type="text" class="bgcolor" name="tot_space_cost_rate" id="tot_space_cost_rate"  value="<?php echo $tot_space_cost_rate;?>" readonly="readonly" /></div>
        <div class="clear"></div>
        </div>
		<?php 
		// if(strtoupper($last_yr)=="YES")
		// {
		//  if($_SESSION['membership_certificate_type']!='')
		//  {
		// 	if($_SESSION['membership_certificate_type']=='ZASSOC')
		// 	{
		// 		$space_rate_discount_per="5%";
		// 	}
		// 	if($_SESSION['membership_certificate_type']=='ZASSOC' && $_SESSION['msme_ssi_status']=="Yes")
		// 	{
		// 		$space_rate_discount_per="10%";
		// 	}
		// 	if($_SESSION['membership_certificate_type']=='ZORDIN')
		// 	{
		// 		$space_rate_discount_per="15%";
		// 	}
		//  }
		// }		
		?>
		<!--<div class="field_box">
        <div class="field_name"><strong>Discount space cost rate </strong><?php echo $currency; ?> : <span id='getDiscountRate'><?php echo $space_rate_discount_per; ?></span></div>
        <div class="field_input"><input type="text" class="bgcolor" name="tot_space_cost_discount" id="tot_space_cost_discount"  value="<?php echo $tot_space_cost_discount;?>" readonly="readonly" /></div>
        <div class="clear"></div>
        </div>
          
		<div class="field_box">
        <div class="field_name"><strong>After Discount space cost </strong><?php echo $currency; ?> :</div>
        <div class="field_input"><input type="text" class="bgcolor" name="get_tot_space_cost_rate" id="get_tot_space_cost_rate"  value="<?php echo $get_tot_space_cost_rate;?>" readonly="readonly" /></div>
        <div class="clear"></div>
        </div>-->
		
        <div class="field_box">
        <div class="field_name"><strong>Category  cost </strong><?php echo $currency;?> :</div>
        <div class="field_input"><input type="text" class="bgcolor" name="get_category_rate" id="get_category_rate"  value="<?php echo $get_category_rate;?>" readonly="readonly"/></div>
        <div class="clear"></div>
        </div>
        
        <div class="field_box">
        <div class="field_name"><strong>Selected scheme rate </strong><?php echo $currency;?>:</div>
        <div class="field_input"><input type="text" class="bgcolor" name="selected_scheme_rate" id="selected_scheme_rate" readonly="readonly" value="<?php echo $selected_scheme_rate;?>"/></div>
        <div class="clear"></div>
        </div>
                        
        <div class="field_box">
        <div class="field_name"><strong>Selected premium rate </strong><?php echo $currency;?>:</div>
        <div class="field_input"><input type="text" class="bgcolor" name="selected_premium_rate" id="selected_premium_rate" readonly="readonly" value="<?php echo $selected_premium_rate;?>"/></div>
        <div class="clear"></div>
        </div>                
        
        <div class="field_box">
        <div class="field_name"><strong>Sub Total cost </strong><?php echo $currency;?>:</div>
        <div class="field_input"><input type="text" class="bgcolor" name="sub_total_cost" id="sub_total_cost" readonly="readonly" value="<?php echo $sub_total_cost;?>" /></div>
        <div class="clear"></div>
        </div>                
        
        <div class="field_box">
        <div class="field_name"><strong>Security Deposit (10% on<br /> SubTotal Cost) </strong><?php echo $currency;?> :</div>
        <div class="field_input"><input type="text" class="bgcolor" name="security_deposit" id="security_deposit" readonly="readonly" value="<?php echo $security_deposit;?>" /></div>
        <div class="clear"></div>
        </div>                
        
        <div class="field_box">
        <div class="field_name"><strong>GST (18% on SubTotal Cost) </strong><?php echo $currency;?> :</div>
        <div class="field_input"><input type="text" class="bgcolor" id="govt_service_tax" name="govt_service_tax" readonly="readonly" value="<?php echo $govt_service_tax;?>" /></div>
        <div class="clear"></div>
        </div>                
        
        <div class="field_box">
        <div class="field_name"><strong>Grand Total </strong><?php echo $currency;?> :</div>
        <div class="field_input"><input type="text" class="bgcolor" id="grand_total" name="grand_total" readonly="readonly" value="<?php echo $grand_total;?>" /></div>
        <div class="clear"></div>
        </div>
    
        <!--<div class="field_box">
        <div class="field_name"><strong>MCB Charges</strong><?php echo $currency;?> :</div>
        <div class="field_input"><input type="text" class="bgcolor" id="mcb_charges" name="mcb_charges" readonly="readonly" value="<?php echo $mcb_charges;?>" /></div>
        <div class="clear"></div>
        </div>
        
    	<span style="color:#FF0000;font-size:16px">*&nbsp;Kindly issue different cheque towards MCB charges. </span>-->        
        <div class="clear" style="height:10px;"></div>       
    
        <div class="field_box">
        <div class="field_name"></div>
        <div class="field_input">
        <a href="exhibitor_registration_step_2.php" class="button">Prev</a>
        <input type="hidden" name="action" value="Save" />
        <?php //if($section!="machinery"){ ?>
        <input type="submit" class="button" value="Proceed to next step" />
        <?php //} ?>
        </div>
        <div class="clear"></div>
        </div>	
	  
    <div class="clear"></div>
	</div>
	</form>
    <div class="clear"></div>
	</div>

<div class="clear" style="height:10px;"></div>
</div>
<div class="footer"><?php include('footer.php');?><div class="clear"></div>
</div>

<div class="clear"></div>
</div>
</body>
</html>
<?php include('header_include.php');
if(!isset($_SESSION['USERID'])){ header("location:login.php");exit;}
if(($_SESSION['eventInfo']['event_selected'] =="")){    header("location:event_selection.php");	exit; }
if($_SESSION['eventInfo']['event_selected']!='combo'){  header("location:event_selection.php"); exit; }
$registration_id=$_SESSION['USERID'];
$premiere_show = "iijs22";
$signature_show = "signature22";
$tritiya_show = "iijstritiya22";

//echo '<pre>'; print_r($_SESSION['iijsInfo']); exit;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Exhibitor Registration - Participation Stall Details</title>
<link rel="icon" href="https://gjepc.org/assets/images/fav_icon.png" type="image/x-icon"/>
<link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Cabin'>
<link rel="stylesheet" type="text/css" href="css/general.css" />
<link rel="stylesheet" type="text/css" href="css/inner_pg_style.css" />
<link rel="stylesheet" type="text/css" href="css/responsive.css" />
<link rel="stylesheet" type="text/css" href="css/media_query.css" />
<script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/visitor_reg.css" />

<!--NAV-->
<link href="css/flexnav.css" media="screen, projection" rel="stylesheet" type="text/css">
<script src="js/jquery.flexnav.js" type="text/javascript"></script>
<script src="js/common.js"></script> 
<!--NAV-->

<!-- UItoTop plugin -->
<link rel="stylesheet" type="text/css" media="screen,projection" href="css/ui.totop.css" />
<script src="js/easing.js" type="text/javascript"></script>
<script src="js/jquery.ui.totop.js" type="text/javascript"></script>    
<script type="text/javascript">
    $(document).ready(function() {        
        $().UItoTop({ easingType: 'easeOutQuart' });     
    });
</script>
<style>.btn{padding:5px 10px;border:1px solid#ccc;margin-bottom:10px;display:inline-block}</style>
<style>
#getDiscountRate
{ display:none;
}
#getDiscountRateSignature
{ display:none;
}
.field_box .field_input {
   
    width: 88%!important;
}


.form_main {
    width: auto;
    height: auto;
    margin: 0px 15px;
    border: 1px solid #000;
    padding: 3%;
}
</style>
<script>
$(document).ready(function(){
  $("#calculate1").click(function(){
  section=$("#section").val();
  selected_area=$("#selected_area").val();
  selected_scheme_type=$("#selected_scheme_type").val();
  category=$('#category').val();
  selected_premium_type=$("#selected_premium_type").val();
  country=$("#country").val();
  last_yr_participant=$("#last_yr_participant").val();
  woman_entrepreneurs=$('[name=woman_entrepreneurs]:checked').val();
		$.ajax({ 		
					type: 'POST',
					url: 'iijs_combo_ajax.php',
					data: "actiontype=calculatePayment&&section="+section+"&&selected_area="+selected_area+"&&selected_scheme_type="+selected_scheme_type+"&&selected_premium_type="+selected_premium_type+"&&woman_entrepreneurs="+woman_entrepreneurs+"&&category="+category+"&&last_yr_participant="+last_yr_participant,
					dataType:'html',
					beforeSend: function(){
							$('#preloader').show();
							$('#status').show();
							},
					success: function(data){
							   // alert(data);return false;
								$('#preloader').hide();
								$('#status').hide();
								var data=data.split("#");
								$('#submitIijs').attr('disabled',false);
								$('#tot_space_cost_rate').val(data[0]);
								$('#tot_space_cost_discount').val(data[1]);
								$('#get_tot_space_cost_rate').val(data[2]);
								$('#get_category_rate').val(data[3]);
								$('#selected_scheme_rate').val(data[4]);
								$('#selected_premium_rate').val(data[5]); 
								$('#sub_total_cost').val(data[6]);
								$('#security_deposit').val(data[7]);
								$('#govt_service_tax').val(data[8]);
								$('#grand_total').val(data[9]);
								
								$('#getDiscountRate').show();
								/*$('#mcb_charges').val(data[8]);*/
							}
		});
 });
 
	if($("input[name=woman_entrepreneurs]:checked").val()=="1")
	{
		$("#women_desc").css("display","block");
	} else
	{
		$("#women_desc").css("display","none");
	}
	
	$("input:radio[name=woman_entrepreneurs]").click(function()
	{
		var value = $(this).val();
		if(value == "1")
		{
			$("#women_desc").css("display","block");
		} else
		{
			$("#women_desc").css("display","none");
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
		$("#form2").validate({
		rules: {  
			signature_section: {
				required: true,
			},  
			signature_area: {
				required: true,
			},  
			signature_selected_scheme_type: {
				required: true,
			},
			signature_selected_premium_type: {
				required: true,
			},
			signature_option: {
				required: true,
			},
			signature_tot_space_cost_rate:{
				required: true,
			},
		},
		messages: {   
			signature_section: {
				required: "Please select section",
			},
			signature_area: {
				required: "Please select area",
			},  
			signature_selected_scheme_type: {
				required: "Please select scheme type",
			},
			signature_selected_premium_type: {
				required: "Please enter premium type",
			},
			signature_option:{
				required: "Please select a option",
			},
			signature_tot_space_cost_rate:{
				required: "Please calculate before final submission",
			},
		}
	});
		$("#form3").validate({
		rules: {  
			tritiya_section: {
				required: true,
			},  
			tritiya_area: {
				required: true,
			},  
			// tritiya_selected_scheme_type: {
			// 	required: true,
			// },
			// tritiya_selected_premium_type: {
			// 	required: true,
			// },
			// tritiya_option: {
			// 	required: true,
			// },
			// tritiya_tot_space_cost_rate:{
			// 	required: true,
			// },
		},
		messages: {   
			tritiya_section: {
				required: "Please select section",
			},
			tritiya_area: {
				required: "Please select area",
			},  
			// tritiya_selected_scheme_type: {
			// 	required: "Please select scheme type",
			// },
			// tritiya_selected_premium_type: {
			// 	required: "Please enter premium type",
			// },
			// tritiya_option:{
			// 	required: "Please select a option",
			// },
			// tritiya_tot_space_cost_rate:{
			// 	required: "Please calculate before final submission",
			// },
		}
	});
});
</script>
<script>
  $("#category").live('change',function(){
	  $('#tot_space_cost_rate').val('');
	  $('#tot_space_cost_discount').val('');
	  $('#get_tot_space_cost_rate').val('');
	  $('#submitIijs').attr('disabled',true);
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
	  $('#submitIijs').attr('disabled',true);
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
	   $('#submitIijs').attr('disabled',true);
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
	   $('#submitIijs').attr('disabled',true);
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
  $("#section").live('change',function(){
  	  section=$("#section").val();
	  selected_area=$("#selected_area_hid").val();
	  option=$("input[name='option']:checked").val();
	  
	  $('#tot_space_cost_rate').val('');
	  $('#selected_scheme_rate').val('');
	  $('#selected_premium_rate').val('');
	  $('#sub_total_cost').val('');
	  $('#security_deposit').val('');
	  $('#govt_service_tax').val('');
	  $('#grand_total').val('');
	  
		$.ajax({ 
					type: 'POST',
					url: 'iijs_combo_ajax.php',
					data: "actiontype=selectArea&&section="+section+"&&option="+option+"&&selected_area="+selected_area,
					dataType:'html',
					beforeSend: function(){
							$('#preloader').show();
							$('#status').show();
							},
					success: function(data){
							//	alert(data);
								$('#preloader').hide();
								$('#status').hide();
								$('#submitSignature').attr('disabled',true);
							//	$("#selected_area").html(data);
							}
		});
});
</script>

<script>
 $("#selected_area").live('change',function(){
	selected_area=$('#selected_area').val();
    $.ajax({ type: 'POST',
					url: 'iijs_combo_ajax.php',
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

					 $('#submitIijs').attr('disabled',true);
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
			  
		  if(option=="Same stall")
		  {
		//	$("#section").attr("disabled", "disabled");
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
		//	$("#section").attr("disabled", "disabled");
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

		//	$("#section").attr("disabled", "disabled");
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
		//	$("#section").attr("disabled", "disabled");
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
		//	$("#section").attr("disabled", "disabled");
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
	   
	 //alert(lastYearArea);
	 
		$.ajax({ 
					type: 'POST',
					url: 'iijs_combo_ajax.php',
					data: "actiontype=optionValue&&option="+option+"&&lastYearArea="+lastYearArea+"&&section="+section+"&selected_scheme_type="+selected_scheme_type+"&selected_premium_type="+selected_premium_type,
					dataType:'html',
					beforeSend: function(){
							$('#preloader').show();
							$('#status').show();
							},
					success: function(data){//alert(data);
						//console.log(data)
						var res = data.split("#");
						$('#preloader').hide();
						$('#status').hide();
						 $('#submitIijs').attr('disabled',true);
						/* if($.trim(res[0])!=""){
							$('#section').html(res[0]);
						} Not getting from ajax*/
						if($.trim(res[1])!=""){
							$('#selected_area').html(res[1]);
						}
						if($.trim(res[2])!=""){
							$('#selected_scheme_type').html(res[2]);
						}
						if($.trim(res[3])!=""){
							$('#selected_premium_type').html(res[3]);
						}
					}
		});	
 });
</script>

<!-------------------------  SIGNATURE ------------->
<script>
$(document).ready(function(){
  $("#calculate2").click(function(){
	selected_area=$("#signature_area").val();
	section=$("#signature_section").val();
	category=$('#signature_category').val();
    selected_premium_type=$("#signature_selected_premium_type").val();
    woman_entrepreneurs=$('#signature_woman_entrepreneurs').val();
	last_yr_participant=$("#last_yr_signature_participant").val();
		$.ajax({ 		
					type: 'POST',
					url: 'signature_combo_ajax.php',
					data: "actiontype=calculatePayment&&selected_area="+selected_area+"&&section="+section+"&&selected_premium_type="+selected_premium_type+"&&woman_entrepreneurs="+woman_entrepreneurs+"&&category="+category+"&&last_yr_participant="+last_yr_participant,
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
								$('#submitSignature').attr('disabled',false);
								$('#signature_tot_space_cost_rate').val(data[0]);								
								$('#signature_tot_space_cost_discount').val(data[1]);
								$('#signature_get_tot_space_cost_rate').val(data[2]);
								$('#signature_get_category_rate').val(data[3]);								
								$('#signature_selected_scheme_rate').val(data[4]);
								$('#signature_selected_premium_rate').val(data[5]); 
								$('#signature_sub_total_cost').val(data[6]);
								$('#signature_security_deposit').val(data[7]);
								$('#signature_govt_service_tax').val(data[8]);
								$('#signature_grand_total').val(data[9]);
								
								$('#getDiscountRateSignature').show();
							}
		});
 });
});
</script>
<script>
  $("#signature_section").live('change',function(){
  	  section=$("#signature_section").val();
	  selected_area=$("#signature_area_hid").val();
	  option=$("input[name='signature_option']:checked").val();
	  
	  $('#signature_tot_space_cost_rate').val('');
	  $('#signature_selected_scheme_rate').val('');
	  $('#signature_selected_premium_rate').val('');
	  $('#signature_sub_total_cost').val('');
	  $('#signature_security_deposit').val('');
	  $('#signature_govt_service_tax').val('');
	  $('#signature_grand_total').val('');
	  
		$.ajax({ 
					type: 'POST',
					url: 'signature_combo_ajax.php',
					data: "actiontype=selectArea&&section="+section+"&&option="+option+"&&selected_area="+selected_area,
					dataType:'html',
					beforeSend: function(){
							$('#preloader').show();
							$('#status').show();
							},
					success: function(data){
							//	alert(data);
								$('#preloader').hide();
								$('#status').hide();
								$('#submitSignature').attr('disabled',true);
								$("#signature_area").html(data);
							}
		});
});
</script>
<script>
  $("#signature_category").live('change',function(){
	  $('#signature_tot_space_cost_rate').val('');
	  $('#signature_tot_space_cost_discount').val('');
	  $('#signature_get_category_rate').val('');
	  $('#signature_selected_scheme_rate').val('');
	  $('#signature_selected_premium_rate').val('');
	  $('#signature_sub_total_cost').val('');
	  $('#signature_security_deposit').val('');
	  $('#signature_govt_service_tax').val('');
	  $('#signature_grand_total').val('');
	  $('#submitSignature').attr('disabled',true);
 });
</script>
<script>
  $("#signature_area").live('change',function(){
	  $('#signature_tot_space_cost_rate').val('');
	  $('#signature_tot_space_cost_discount').val('');
	  $('#signature_get_category_rate').val('');
	  $('#signature_selected_scheme_rate').val('');
	  $('#signature_selected_premium_rate').val('');
	  $('#signature_sub_total_cost').val('');
	  $('#signature_security_deposit').val('');
	  $('#signature_govt_service_tax').val('');
	  $('#signature_grand_total').val('');
	  $('#submitSignature').attr('disabled',true);
 });
</script>
<script>
  $("#signature_selected_scheme_type").live('change',function(){
	  $('#signature_tot_space_cost_rate').val('');
	  $('#signature_tot_space_cost_discount').val('');
	  $('#signature_get_category_rate').val('');
	  $('#signature_selected_scheme_rate').val('');
	  $('#signature_selected_premium_rate').val('');
	  $('#signature_sub_total_cost').val('');
	  $('#signature_security_deposit').val('');
	  $('#signature_govt_service_tax').val('');
	  $('#signature_grand_total').val('');
	  $('#submitSignature').attr('disabled',true);
 });
</script>
<script>
  $("#signature_selected_premium_type").live('change',function(){
	  $('#signature_tot_space_cost_rate').val('');
	  $('#signature_tot_space_cost_discount').val('');
	  $('#signature_get_category_rate').val('');
	  $('#signature_selected_scheme_rate').val('');
	  $('#signature_selected_premium_rate').val('');
	  $('#signature_sub_total_cost').val('');
	  $('#signature_security_deposit').val('');
	  $('#signature_govt_service_tax').val('');
	  $('#signature_grand_total').val('');
	  $('#submitSignature').attr('disabled',true);
 });
</script>
<script>
$("#signature_area").live('change',function(){
	selected_area=$('#signature_area').val();
	
		$.ajax({ 
					type: 'POST',
					url: 'signature_combo_ajax.php',
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
					$('#submitSignature').attr('disabled',true);
					if($.trim(res[0])!=""){
							$('#signature_selected_scheme_type').html(res[0]);
						}
					if($.trim(res[1])!=""){
						$('#signature_selected_premium_type').html(res[1]);
					}
				}
		});
 });
</script>

<script>
  $("#signature_option").live('change',function(){
	  option=$('input[name=signature_option]:checked').val();
	  section=$('#signature_section_hid').val();
	  
	  if($('#signature_selected_scheme_type_hid').val()!='')
				var signature_selected_scheme_type=$('#signature_selected_scheme_type_hid').val();
		  else
	  		var signature_selected_scheme_type=$("#signature_selected_scheme_type").val();
		
	  if(option=="Same stall position size as of previous year")
	  {
	  	$("#signature_section").attr("disabled", "disabled");
		$("#signature_area").attr("disabled", "disabled");
		$("#signature_category").attr("disabled", "disabled");
		$("#signature_selected_premium_type").attr("disabled", "disabled");
		$("#signature_selected_scheme_type").removeAttr("disabled");
		
		$("#signature_section_hid").removeAttr("disabled");
		$("#signature_area_hid").removeAttr("disabled");
		$("#signature_category_hid").removeAttr("disabled");
		$("#signature_selected_premium_type_hid").removeAttr("disabled");
		$("#signature_selected_scheme_type_hid").attr("disabled", "disabled");

		$("#signature_section").val($("#signature_section_hid").val());
		$("#signature_area").val($("#signature_area_hid").val());
		$("#signature_category").val($("#signature_category_hid").val());
		$("#signature_selected_premium_type").val($("#signature_selected_premium_type_hid").val());
		
		var selected_area=$("#selected_area_hid").val();
		if(selected_area==9 || selected_area==12)
				$("#signature_selected_scheme_type").html("<option value='BI2'>Old Shell Scheme</option><option value='BI1'>New Shell Scheme</option>");	
	  }
	  else if(option=="Same area but different location as of previous year Signature")
	  {
		$("#signature_section").removeAttr("disabled");
		$("#signature_category").removeAttr("disabled");
		$("#signature_selected_premium_type").removeAttr("disabled");
		$("#signature_section_hid").removeAttr("disabled");
		$("#signature_selected_scheme_type").removeAttr("disabled");
		
		$("#signature_area").attr("disabled", "disabled"); 
		$("#signature_section_hid").attr("disabled", "disabled");
		$("#signature_category_hid").attr("disabled", "disabled");
		$("#signature_selected_premium_type_hid").attr("disabled", "disabled");
		$("#signature_selected_scheme_type_hid").attr("disabled", "disabled");
		
		$("#signature_section").val($("#signature_section_hid").val());
	  }
	  else if(option=="More area than previous year Signature")
	  {
		$("#signature_section").removeAttr("disabled");
		$("#signature_area").removeAttr("disabled");
		$("#signature_category").removeAttr("disabled");
		$("#signature_selected_premium_type").removeAttr("disabled"); 
		$("#signature_selected_scheme_type").removeAttr("disabled");
		
		$("#signature_area_hid").attr("disabled", "disabled");
		$("#signature_category_hid").attr("disabled", "disabled");
		$("#signature_selected_premium_type_hid").attr("disabled", "disabled");
		$("#signature_section_hid").attr("disabled", "disabled");
		$("#signature_selected_scheme_type_hid").attr("disabled", "disabled");
	 }
	  else if(option=="Less area as previous year")
	  {
		$("#signature_section").removeAttr("disabled");
		
		$("#signature_area").removeAttr("disabled");
		$("#signature_category").removeAttr("disabled");
		$("#signature_selected_premium_type").removeAttr("disabled"); 		
		
		$("#signature_section_hid").attr("disabled", "disabled");
		$("#signature_area_hid").attr("disabled", "disabled");
		$("#signature_category_hid").attr("disabled", "disabled");
		$("#signature_selected_premium_type_hid").attr("disabled", "disabled");
		$("#signature_selected_scheme_type_hid").attr("disabled", "disabled");
	  }
	  lastYearArea=$('#lastYearSignatureArea').val();
	  $("#im_registration_no").attr("disabled", "disabled"); 
	 	  
	  $('#signature_tot_space_cost_rate').val('');
	  $('#signature_tot_space_cost_discount').val('');
	  $('#signature_get_tot_space_cost_rate').val('');
	  $('#signature_get_category_rate').val('');
	  $('#signature_selected_scheme_rate').val('');
	  $('#signature_selected_premium_rate').val('');
	  $('#signature_sub_total_cost').val('');
	  $('#signature_security_deposit').val('');
	  $('#signature_govt_service_tax').val('');
	  $('#signature_grand_total').val('');
	  
	  
		$.ajax({
					type: 'POST',
					url: 'signature_combo_ajax.php',
					data: "actiontype=optionValue&&option="+option+"&&lastYearArea="+lastYearArea+"&&section="+section+"&signature_selected_scheme_type="+signature_selected_scheme_type,
					dataType:'html',
					beforeSend: function(){
							$('#preloader').show();
							$('#status').show();
							},
					
					
					success: function(data){
							//alert(data);
							var res = data.split("#");
							$('#preloader').hide();
							$('#status').hide();
							$('#submitSignature').attr('disabled',true);
							if($.trim(res[0])!=""){
							$('#signature_area').html(res[0]);
							}
							if($.trim(res[1])!=""){
								$('#signature_selected_scheme_type').html(res[1]);
							}
						}
			});
 });
</script>


<script>
$(document).ready(function(){
	
  $("#tritiya_area").on('change',function(){
	selected_area=$('#tritiya_area').val();
	event_name="iijstritiya22";
    $.ajax({ type: 'POST',
					url: 'iijs_combo_ajax.php',
					data: "actiontype=TRITIYACAL&&selected_area="+selected_area+"&&event_name="+event_name,
					dataType:'html',
					beforeSend: function(){
							},
					success: function(data){
					var res = data.split("#");		
					$('#tritiya_sub_total_cost').val(res[0]);

					$('#tritiya_govt_service_tax').val(res[1]);

					$('#tritiya_grand_total').val(res[2]);
					$("#submitTritiya").attr("disabled",false);
					}
		});
 }); 
 
  $("#tritiya_section").on('change',function(){
	section=$('#tritiya_section').val();
    $.ajax({ type: 'POST',
					url: 'iijs_combo_ajax.php',
					data: "actiontype=ROIALLOEDAREA&&section="+section,
					dataType:'html',
					beforeSend: function(){
					},
					success: function(data){//alert(data);	
					console.log(data);
					$('#tritiya_area').html(data);
				}
		});
	}); 
});
</script>

<!-- All Data Submit one  button Start -->
<script>
$(document).ready(function(){
	$('#submitIijs').on('click',function(){		
		var submitid = $(this).attr('id');
		if(submitid =="submitIijs"){
			var formData1 = $('#form1').serialize();
        	$.ajax({
			type:'POST',
			data:formData1,
			url:'combo_submit.php',
			dataType: "json",
			beforeSend: function(){
							$('#preloader').show();
							$('#status').show();
							},
			success:function(result){
					$('#preloader').delay(300).fadeOut();
					$('#status').hide();
				if(result.status==result.name+'_empty'){
					$("label[for='"+result.name+"']").html(result.msg);

				}else if(result.status=="success"){
					$('#form1').addClass('overlay');
					$('#form2').children(".form_main ").removeClass('overlay_blur');
					$("#submitIijs").attr('value',"Submit IIJS Signature 2022 Data");
					$("#submitIijs").attr('id',"submitSignature");
					$("#submitSignature").attr('disabled',true);
					$("label[for='submit']").html(result.msg);
				}				
			}
		});
		} else if(submitid =="submitSignature"){			
			var formData2 = $('#form2').serialize();
			//alert(formData2);
			value=$('#signature_selected_scheme_type').val();
			//alert(value);
			$.ajax({
			type:'POST',
			data:formData2,
			url:'combo_submit.php',
			dataType: "json",
		beforeSend: function(){
							$('#preloader').show();
							$('#status').show();
							},
			success:function(result){
					$('#preloader').delay(300).fadeOut();
					$('#status').hide();
				if(result.status==result.name+'_empty'){
					$("label[for='"+result.name+"']").html(result.msg);

				} else if(result.status=="success"){
				
					$('#form2').addClass('overlay');
					$('#form3').children(".form_main ").removeClass('overlay_blur');
					$("#submitSignature").attr('value',"Submit IIJS Tritiya 2022 Data");
					$("#submitSignature").attr('id',"submitTritiya");
					$("#submitTritiya").attr('disabled',true);
					
					
					$("label[for='submit']").html(result.msg);
				}				
			}
		});

		} else {
			var formData3 = $('#form3').serialize();
			//alert(formData2);
			value=$('#tritiya_selected_scheme_type').val();
			//alert(value);
			$.ajax({
			type:'POST',
			data:formData3,
			url:'combo_submit.php',
			dataType: "json",
		beforeSend: function(){
							$('#preloader').show();
							$('#status').show();
							},
			success:function(result){
					$('#preloader').delay(300).fadeOut();
					$('#status').hide();
				if(result.status==result.name+'_empty'){
					$("label[for='"+result.name+"']").html(result.msg);

				} else if(result.status=="success"){
					$('#form3').addClass('overlay');
					$('#form3').children(".form_main ").removeClass('overlay_blur');
				
					$("#submitTritiya").hide();
					$('#step4combo').show();
					$("label[for='submit']").html(result.msg);
				}				
			}
		});
		}	
	});
});	
</script>

<!-- All Data Submit one  button End -->

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
<div class="header"><?php include('header1.php');?></div>
<div id="preloader"><div id="status"><img src="images/loaderp.gif"></div>
</div>
<div class="inner_container">
    <div class="clear"></div>
    
    <div class="content_area">
      <div class="pg_title">
        <div class="title_cont"> <span class="top">Exhibitor <img src="images/titles/joint.png" style="position:absolute; top:31px; right:0px;"/></span><span class="below">Registration</span>
          <div class="clear"></div>
        </div>
      </div>
    <div class="clear"></div>      
    <div class="clear"></div>
      
		<div class="d-flex flex-row justify-center form-group m-10 form-tab">
			<label class="container_radio"><span class="check_text"></span>
			  <input type="radio" disabled="disabled">
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
    <div class="form_wrp">	
        <p style="text-align: center;"><strong>Note:</strong><span  style="color: red"> Kindly submit the IIJS Premiere 2022 form first,in order to submit the IIJS signature 2023 & IIJS TRITIYA 2023 Form</span></p>
        <div style="text-align: center;margin-bottom:10px "></div>


    <form  method="post" name="form1" id="form1" style="width:32%; float:left; border-right:2px dotted #ddd; box-sizing:border-box;" >
     <h1 class="form-title">IIJS Premiere 2022</h1>
    <div class="form_main ">
    
    <!--<div><a href="http://gjepc.org/emailer_gjepc/22.04.2019/01/Mezzanine_docket.rar" style="color:red;float:left" target="_blank" class="btn"> Click Here to Downlaod Mezzanine Booth Docket</a> <a href="https://gjepc.org/emailer_gjepc/22.04.2019/01/Annexure_II_New_Booth_Design.pdf" target="_blank" style="color:red;cursor:pointer;float:right"  class="btn">New Shell Scheme Description (Click here)</a></div>-->
    <div class="clear"></div>    
    <div style="float:right; font-size:13px; font-weight:bold;"></div>    
    <div class="clear"></div>
    <?php 
	/*...........................Last year participant  ..........................*/
	//echo "select * from exh_registration where uid='$registration_id' and `show`='IIJS Signature 2019' and last_yr_section_flag='1' and  curr_last_yr_check='N' order by exh_id desc limit 0,1";
	$last_query = "select * from exh_registration where uid='$registration_id' AND `show`='IIJS 2021' AND last_yr_section_flag='1' AND  curr_last_yr_check='N' order by exh_id desc limit 0,1";
	$query1=$conn->query($last_query);
	$result1=$query1->fetch_assoc();
	$exh_id=$result1['exh_id'];
	$retain_restrict=$result1['retain_restrict'];
	$num1=$query1->num_rows;

	$query=$conn->query("select * from exh_registration where uid='$registration_id' AND `show`='IIJS Signature 2022'");
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
    if($_SESSION['member_type']=='MEMBER')
		{ 	
				$sql_section="SELECT * FROM signature_section_master where member_type ='MEMBER' and status='Y' ORDER BY section_desc";
		} else {					
				$sql_section="SELECT * FROM signature_section_master where member_type ='NON_MEMBER' and status='Y' ORDER BY section_desc";
		}

	?>
        <div class="field_box">
            <div class="field_name">IIJS 2021 Participation Detail :  <?php if($num1>0){ echo $last_yr="YES"; } else { echo $last_yr="NO"; } ?></div>
           
              <input type="hidden" name="last_yr_participant" id="last_yr_participant" value="<?php echo $last_yr;?>"/>                
            <label for="last_yr_participant" generated="true" class="error"></label>
            <div class="clear"></div>
        </div>
        <div class="field_box">
          <div class="field_name" style="width:100%"> Membership Status : <?php echo $_SESSION['member_type'];?></div>
        </div>
        <?php if($num1>0){ ?>
        <div class="field_box">
            <div class="field_name">Last year details :</div>
            <div class="field_input" style="padding-top:5px; line-height:25px;">
            <strong>Section :</strong> <?php echo strtoupper($section);?><br />
            <strong>Area :</strong> <?php echo strtoupper($selected_area);?> <br />
            <!--<strong>Scheme type :</strong> <?php echo $selected_scheme_type?> <br />
            <strong>Premium type :</strong> <?php echo strtoupper($selected_premium_type);?> -->          
            </div>
            <div class="clear"></div>
        </div>
        <?php } ?>
       <div class="field">
        <strong> Please select any of the option </strong> <span>*</span> : 
        <input type="hidden" name="exh_id" id="exh_id" value="<?php echo $exh_id?>"/>
        <?php if($num1==0){?>
        <input type="radio" id="option" class="bgcolor" name="option" checked="checked" value="New participant" /> New participant<br/>
       <div style="margin-top:175"></div>
        <?php } else { ?>
        <!--<input type="radio" id="option" class="bgcolor" name="option" value="Same stall" <?php /*if($option=="Same stall"){?> checked="checked" <?php } */?> /> Same stall position size as of previous year<br/>-->
        
        <input type="radio" id="option" class="bgcolor" name="option" value="Same area but different location as of previous year IIJS" <?php /*if($option=="Same area but different location as of previous year IIJS"){?> checked="checked" <?php } */?> /> 
        Same area but different location as alloted at IIJS Premiere 2020.<br/>  
        
        <input type="radio" id="option" class="bgcolor" name="option" value="More area than previous year IIJS" <?php /*if($option=="More area than previous year IIJS"){?> checked="checked" <?php } */?> /> 
        More area than previous year IIJS<br/>
         
        <?php if($selected_area>9){ ?>
        <input type="radio" id="option" class="bgcolor" name="option" value="Less area as previous year at diffrent location" <?php /*if($option=="Less area as previous year at diffrent location"){?> checked="checked" <?php } */?> /> Less area as previous year at different location<br/>
        <!-- <input type="radio" id="option" class="bgcolor" name="option" value="Less area as previous year" <?php /*if($option=="Less area as previous year"){?> checked="checked" <?php } */?> /> Less area as previous year at same location -->
		<?php }
		} ?>
        <label for="option" generated="true" class="error"></label>
               
        <div class="clear"></div>
        </div>
	   
        <div class="field_box">
        <div class="field_name ">Select your section <span>*</span>:</div>
        <div class="field_input">
          <select name="section" id="section" class="bgcolor" 
		  <?php /*if($section!="" && ($_SESSION['COUNTRY']=="IN") && $num1!=0){ ?> disabled="disabled" <?php } */?>>
          <option selected="selected" value="">-----Select Section----</option>
            <?php
			if($_SESSION['COUNTRY']=="IN")
			{				
            $query=$conn->query($sql_section);
            while($result=$query->fetch_assoc()){
            ?>
            <option value="<?php echo $result['section'];?>" <?php if($result['section']==trim($section)){?> selected="selected" <?php }?> ><?php echo $result['section_desc'];?></option>
            <?php } } else { ?>
            <option value="International Jewellery" <?php if($section=="International Jewellery"){?> selected="selected" <?php }?>>International Jewellery</option>
            <option value="International Loose" <?php if($section=="International Loose"){?> selected="selected" <?php }?>>International Loose</option>
            <option value="machinery" <?php if($section=="machinery"){?> selected="selected" <?php }?>>Machinery</option>     
            <?php } ?>
          </select>
          <?php /*if($section!="" && $num1>0){?><input type="hidden" name="section" id="section_hid" value="<?php echo $section;?>"/><?php } */ ?>          
        </div>
        <label for="section" generated="true" class="error"></label>
        <div class="clear"></div>
        </div>
		
        <?php if($category!=""){?><input type="hidden" name="category" id="category_hid" value="<?php echo $category;?>"/><?php }?>
                
        <div class="field_box">
        <div class="field_name">Select your area <span>*</span>:</div>
        <div class="field_input"> 
          <select name="selected_area" id="selected_area" class="bgcolor" <?php if($selected_area!="" && $num1!=0){?> disabled="disabled"<?php }?>>
            <option selected="selected" value="">-----Select Area----</option>
            <?php 
			if($num1==0){$sql="SELECT * FROM iijs_area_master where area=6";}
			elseif($selected_area==6){$sql="SELECT * FROM iijs_area_master where area=6 or area=18";}
			elseif($selected_area==9){$sql="SELECT * FROM iijs_area_master where area=9 or area=18";}
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
        <label for="selected_area" generated="true" class="error"></label>
        <div class="clear"></div>
        </div>
		
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
            <?php } ?> 
         </select>
         <?php if($selected_scheme_type!="" && $num1>0){?>
         <input type="hidden" name="selected_scheme_type" id="selected_scheme_type_hid" value="<?php echo $selected_scheme_type;?>" />
		 <?php }?>
		 <label for="selected_scheme_type" generated="true" class="error"></label>
        </div>
        <div class="clear"></div>
        </div>
        <?php } else { ?>
        <input type="hidden" name="selected_scheme_type" id="selected_scheme_type" value="0"/>
        <?php } ?>
		
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
         <label for="selected_premium_type" generated="true" class="error"></label>
        <div class="clear"></div>
        </div>
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
        <?php } ?>
		
        <div class="field_box">
        <div class="field_name"><strong style="color:#000; font-size:14px;">Application Summary :</strong><br />
        <span class="clear" style="height:1px; background:#ccc; display:block; margin-top:5px;"></span></div> 
        <div class="clear"></div>
        </div>
        
        <div class="field_box">
        	<input type="button" name="calculate1" id="calculate1" value="Calculate" class="button" />
        <span style="display:inline-block; float:left; margin:10px 0;">Click on calculate button to calculate the figures</span>
        
        <!--<a href="#" class="button">Calculate</a>-->
        <div class="clear"></div>
        </div>                
        <div class="clear"></div>                
        
        <div class="field_box">
        <div class="field_name">Space cost rate <?php echo $currency;?> :</div>
        <div class="field_input"><input type="text" class="bgcolor" name="tot_space_cost_rate" id="tot_space_cost_rate"  value="<?php echo $tot_space_cost_rate;?>" readonly="readonly" /></div>
        <label for="tot_space_cost_rate" generated="true" class="error"></label>
		<div class="clear"></div>
        </div>
		
		<?php 
		if(strtoupper($last_yr)=="YES")
		{
		 if($_SESSION['membership_certificate_type']!='')
		 {
			if($_SESSION['membership_certificate_type']=='ZASSOC')
			{
				$space_rate_discount_per="5%";
			}
			if($_SESSION['membership_certificate_type']=='ZASSOC' && $_SESSION['msme_ssi_status']=="Yes")
			{
				$space_rate_discount_per="10%";
			}
			if($_SESSION['membership_certificate_type']=='ZORDIN')
			{
				$space_rate_discount_per="15%";
			}
		 }
		}		
		?>
          
        <div class="field_box">
        <div class="field_name">Discount space cost rate <?php echo $currency;?> : <span id='getDiscountRate'><?php echo $space_rate_discount_per; ?></span></div>
        <div class="field_input"><input type="text" class="bgcolor" name="tot_space_cost_discount" id="tot_space_cost_discount"  value="<?php echo $tot_space_cost_discount;?>" readonly="readonly" /></div>
        <div class="clear"></div>
        </div>
          
		<div class="field_box">
        <div class="field_name">After Discount space cost <?php echo $currency;?> :</div>
        <div class="field_input"><input type="text" class="bgcolor" name="get_tot_space_cost_rate" id="get_tot_space_cost_rate"  value="<?php echo $get_tot_space_cost_rate;?>" readonly="readonly" /></div>
        <div class="clear"></div>
        </div>
        
        <div class="field_box">
        <div class="field_name">Selected scheme rate <?php echo $currency;?>:</div>
        <div class="field_input"><input type="text" class="bgcolor" name="selected_scheme_rate" id="selected_scheme_rate" readonly="readonly" value="<?php echo $selected_scheme_rate;?>" /></div>
        <div class="clear"></div>
        </div>
                        
        <div class="field_box">
        <div class="field_name">Selected premium rate <?php echo $currency;?>:</div>
        <div class="field_input"><input type="text" class="bgcolor" name="selected_premium_rate" id="selected_premium_rate" readonly="readonly" value="<?php echo $selected_premium_rate;?>"/></div>
        <label for="selected_premium_rate" generated="true" class="error"></label>
        <div class="clear"></div>
        </div>                
        
        <div class="field_box">
        <div class="field_name">Sub Total cost <?php echo $currency;?>:</div>
        <div class="field_input"><input type="text" class="bgcolor" name="sub_total_cost" id="sub_total_cost" readonly="readonly" value="<?php echo $sub_total_cost;?>" /></div>
        <label for="sub_total_cost" generated="true" class="error"></label>
        <div class="clear"></div>
        </div>                
        
        <div class="field_box">
        <div class="field_name">Security Deposit (10% on SubTotal Cost) <?php echo $currency;?> :</div>
        <div class="field_input"><input type="text" class="bgcolor" name="security_deposit" id="security_deposit" readonly="readonly" value="<?php echo $security_deposit;?>" /></div>
        <label for="security_deposit" generated="true" class="error"></label>
        <div class="clear"></div>
        </div>                
        
        <div class="field_box">
        <div class="field_name">GST (18% on SubTotal Cost) <?php echo $currency;?> :</div>
        <div class="field_input"><input type="text" class="bgcolor" id="govt_service_tax" name="govt_service_tax" readonly="readonly" value="<?php echo $govt_service_tax;?>" /></div>
        <label for="govt_service_tax" generated="true" class="error"></label>
        <div class="clear"></div>
        </div>                
        
        <div class="field_box">
        <div class="field_name"><strong>Grand Total </strong><?php echo $currency;?> :</div>
        <div class="field_input"><input type="text" class="bgcolor" id="grand_total" name="grand_total" readonly="readonly" value="<?php echo $grand_total;?>" /></div>
        <label for="govt_service_tax" generated="true" class="error"></label>
        <div class="clear"></div>
        </div>    
        
        <!--<div class="field_box">
        <div class="field_name"><strong>MCB Charges</strong><?php echo $currency;?> :</div>
        <div class="field_input"><input type="text" class="bgcolor" id="mcb_charges" name="mcb_charges" readonly="readonly" value="<?php echo $mcb_charges;?>" /></div>
        <div class="clear"></div>
        </div>
        
    	<span style="color:#FF0000;font-size:16px">*&nbsp;Kindly issue different cheque towards MCB charges. </span>-->
        
        <div class="clear" style="height:10px;"></div>       
    
        <!--<div class="field_box">
        <div class="field_name"></div>
        <div class="field_input">
        	<a href="exhibitor_registration_step_2.php" class="button">Prev</a>
        <input type="hidden" name="action" value="Save" />
        <?php //if($section!="machinery"){ ?>
        <input type="submit" class="button" value="Proceed to next step" />
        <?php //} ?>
        </div>
        <div class="clear"></div>
        </div>-->
	
    <div class="clear"></div>
	</div>
	<input type="hidden" name="action" value="iijsAction">
	</form>
    	
	
	<!----------------------------------------------  IIJS Tritiya  --------------------------------------------------------------------------->
	
	<form  method="post" name="form2" id="form2" style="width:32%; float:left;" class="">
    <h1 class="form-title">IIJS Signature 2023</h1>
    <div class="form_main overlay_blur">
    
    <div class="clear"></div>    
    <div style="float:right; font-size:13px; font-weight:bold;"></div>    
    <div class="clear"></div>
  <?php 
	/*...........................Last year participant  ..........................*/
	//echo "select * from exh_registration where uid='$registration_id' and `show`='IIJS Signature 2019' and last_yr_section_flag='1' and  curr_last_yr_check='N' order by exh_id desc limit 0,1";
	$signQuery = "select * from exh_registration where uid='$registration_id' and `show`='IIJS Signature 2019' and last_yr_section_flag='1' and  curr_last_yr_check='N' order by exh_id desc limit 0,1";
	$query_signature = $conn->query($signQuery);
	$result_signature1 = $query_signature->fetch_assoc();
	$signature_exh_id = $result_signature1['exh_id'];
	$num2=$query_signature->num_rows;	

	$query=$conn->query("select * from exh_registration where uid='$registration_id' AND gid='$gid' AND `show`='$signature_show'");
	$resultx=$query->fetch_assoc();
	$num=$query->num_rows;
	if($num2>0)
	{
		$signature_option=$result_signature1['options'];
		$signature_category=$result_signature1['category'];
		$signature_area=$result_signature1['selected_area'];
		$signature_section=$result_signature1['section'];
		$signature_selected_scheme_type=$result_signature1['selected_scheme_type'];
		$signature_selected_premium_type=$result_signature1['selected_premium_type'];			
	}
	else
	{
		$signature_section=$resultx['section'];
		$signature_category=$resultx['category'];
		$signature_option=$resultx['options'];
		$signature_area=$resultx['selected_area'];
		$signature_selected_scheme_type=$resultx['selected_scheme_type'];
		$signature_selected_premium_type=$resultx['selected_premium_type'];
		$signature_tot_space_cost_rate=$resultx['tot_space_cost_rate'];
		$signature_selected_scheme_rate=$resultx['selected_scheme_rate'];
		$signature_selected_premium_rate=$resultx['selected_premium_rate'];
		$signature_sub_total_cost=$resultx['sub_total_cost'];
		$signature_security_deposit=$resultx['security_deposit'];
		$signature_govt_service_tax=$resultx['govt_service_tax'];
		$signature_grand_total=$resultx['grand_total'];
		$signature_mezzanine_space_charges=$resultx['mezzanine_space_charges'];
		$signature_mcb_charges=$resultx['mcb_charges'];
		$signature_woman_entrepreneurs=$resultx['woman_entrepreneurs'];			
    }
	?>
        <div class="field_box">
            <div class="field_name">Last year participant :  <?php if($result_signature1['last_yr_participant']=='YES'){ echo $last_yr_signature="YES"; } else {echo $last_yr_signature="NO";}?> </div>
           
        
              <input type="hidden" name="last_yr_signature_participant" id="last_yr_signature_participant" value="<?php echo $last_yr_signature;?>"/>
            
           
            <label for="last_yr_signature_participant" generated="true" class="error"></label>
            <div class="clear"></div>
        </div>
        <div class="field_box">
            <div class="field_name" style="width:100%">Membership Status : <?php echo $_SESSION['member_type'];?></div>
           
            <div class="clear"></div>
        </div>
        <?php if($num2>0){ ?>
        <div class="field_box">
            <div class="field_name">Last year details :</div>
            <div class="field_input" style="padding-top:5px; line-height:25px;">
            <strong>Section :</strong> <?php echo strtoupper($result_signature1['section']);?><br />
            <strong>Area :</strong> <?php echo strtoupper($result_signature1['selected_area']);?> <br />
            <strong>Category type :</strong> <?php echo $result_signature1['category'];?> <br />
            <strong>Premium type :</strong> <?php echo strtoupper($result_signature1['selected_premium_type']);?>           
            </div>
            <div class="clear"></div>
        </div>
        <?php } ?>
        <div class="field">
         <strong> Please select any of the option </strong><span>*</span> :
         <input type="hidden" name="signature_exh_id" id="signature_exh_id" value="<?php echo $signature_exh_id?>"/>
        <?php if($num2==0){ ?>
        <input type="radio" id="signature_option" class="bgcolor" name="signature_option" checked="checked" value="New participant"/>New participant<br />
        <div style="margin-top:175"></div>
        <?php } else { ?>
        <input type="radio" id="signature_option" class="bgcolor" name="signature_option" value="Same stall position size as of previous year" <?php /*if($signature_option=="Same stall position size as of previous year"){?> checked="checked" <?php } */?> /> Same stall position size as of previous year<br/>        
        <input type="radio" id="signature_option" class="bgcolor" name="signature_option" value="Same area but different location as of previous year Signature" <?php /*if($signature_option=="Same area but different location as of previous year Signature"){?> checked="checked" <?php } */?>/> 
        Same area but different location as of previous year Signature<br/>		
        <input type="radio" id="signature_option" class="bgcolor" name="signature_option" value="More area than previous year Signature" <?php /*if($signature_option=="More area than previous year Signature"){ ?> checked="checked" <?php } */?>  /> More area than previous year Signature<br/>
		<?php if($signature_area!=9){ ?>
        <input type="radio" id="signature_option" class="bgcolor" name="signature_option" value="Less area as previous year" <?php /*if($signature_option=="Less area as previous year"){?> checked="checked" <?php } */?>/> Less area as previous year <?php } ?>
		<?php } ?>
        <label for="signature_option" generated="true" class="error"></label>
        <div class="clear"></div>
        </div>
				 
        <div class="field_box">
        <div class="field_name">Select your section <span>*</span>:</div>
        <div class="field_input">
          <select name="signature_section" id="signature_section" class="bgcolor" <?php if($signature_section!="" && ($_SESSION['COUNTRY']=="IN") && $num2!=0){?> disabled="disabled" <?php }?>>
          <option selected="selected" value="">-----Select Section----</option>
            <?php
			if($_SESSION['COUNTRY']=="IN")
			{				
            $query=$conn->query($sql_section);
            while($result=$query->fetch_assoc()){
            ?>
            <option value="<?php echo $result['section'];?>" <?php if($result['section']==trim($signature_section)){?> selected="selected" <?php }?> ><?php echo $result['section_desc'];?></option>
            <?php } } else { ?>
            <option value="International Jewellery" <?php if($signature_section=="International Jewellery"){?> selected="selected" <?php }?>>International Jewellery</option>
            <option value="International Loose" <?php if($signature_section=="International Loose"){?> selected="selected" <?php }?>>International Loose</option>
            <?php } ?>
          </select>
          <?php if($signature_section!="" && $num2>0){?><input type="hidden" name="signature_section" id="signature_section_hid" value="<?php echo $signature_section;?>"/><?php } ?>          
        </div>
        <label for="signature_section" generated="true" class="error"></label>
        <div class="clear"></div>
        </div>
        				
        <div class="field_box">
        <div class="field_name">Select your category <span>*</span>:</div>
        <div class="field_input">
          <select name="signature_category" id="signature_category" class="bgcolor" <?php if($signature_category!=""){?> disabled="disabled"<?php }?>>
          <option selected="selected" value="">-----Select Category----</option>
            <?php 
			$sql="SELECT * FROM signature_category_master";
            $query=$conn->query($sql);
            while($result=$query->fetch_assoc()){ ?>
            <option value="<?php echo $result['category'];?>" <?php if($result['category']==$signature_category){?> selected="selected" <?php }?> ><?php echo $result['category_desc'];?></option>
            <?php }?>
          </select>
          <?php if($signature_category!=""){?><input type="hidden" name="signature_category" id="signature_category_hid" value="<?php echo $signature_category;?>"/><?php }?>
        </div>
        <label for="signature_category" generated="true" class="error"></label>
        <div class="clear"></div>
        </div>
        
        <div class="field_box">
        <div class="field_name">Select your area <span>*</span>:</div>
        <div class="field_input"> 
          <select name="signature_area" id="signature_area" class="bgcolor" <?php if($signature_area!="" && $num2!=0){?> disabled="disabled"<?php }?>>
            <option selected="selected" value="">-----Select Area----</option>
            <?php
			//if($num2==0){ $sql="SELECT * FROM signature_area_master where area=9"; } else {
			$sql="SELECT * FROM signature_area_master order by area_id asc"; //}
			$query=$conn->query($sql);
			while($result=$query->fetch_assoc()){ ?>
            <option value="<?php echo $result['area'];?>" <?php if($result['area']==$signature_area){?> selected="selected" <?php }?>><?php echo $result['area'];?></option>
            <?php }?>
          </select>
           <?php if($signature_area!=""){?><input type="hidden" name="signature_area" id="signature_area_hid" value="<?php echo $signature_area;?>"/><?php }?>    
        <input type="hidden" name="lastYearSignatureArea" id="lastYearSignatureArea" value="<?php echo $signature_area;?>"/>
        </div>
        <label for="signature_area" generated="true" class="error"></label>
        <div class="clear"></div>
        </div>
		
		<!--........................Selected Scheme Type...........................-->
		<?php if($section!='machinery'){ ?>
        <div class="field_box">
        <div class="field_name">Select your scheme type <span>*</span>:</div>
        <div class="field_input">
        <select class="bgcolor" id="signature_selected_scheme_type" name="signature_selected_scheme_type" <?php if($signature_selected_scheme_type!="" && $num2!=0){?> disabled="disabled"<?php }?>>
        <option selected="selected" value="">-----Select Scheme Type----</option>
		<?php 
		$sql="SELECT * FROM signature_scheme_master where status='Y'";
		$query=$conn->query($sql);
		while($result=$query->fetch_assoc()){
        ?>
        <option value="<?php echo $result['scheme'];?>" <?php if($signature_selected_scheme_type==$result['scheme']){ echo "selected=selected"; }?> ><?php echo $result['scheme_desc'];?></option>
        <?php } ?>        
         </select>
         <?php if($signature_selected_scheme_type!="" && $num2>0){?>
         <input type="hidden" name="signature_selected_scheme_type" id="signature_selected_scheme_type_hid" value="<?php echo $signature_selected_scheme_type;?>" />
		 <?php }?>
        </div>
        <div class="clear"></div>
        </div>
        <?php } else { ?>
        <input type="hidden" name="signature_selected_scheme_type" id="signature_selected_scheme_type" value="0"/>
        <?php } ?>
        <label for="signature_selected_scheme_type" generated="true" class="error"></label>

						
        <div class="field_box">
        <div class="field_name">Select your premium type <span>*</span>:</div>
        <div class="field_input">
            <select class="bgcolor" name="signature_selected_premium_type" id="signature_selected_premium_type" <?php if($signature_option=="Same stall position size as of previous year"){?> disabled="disabled"<?php } /*if($selected_premium_type!=""){?> disabled="disabled"<?php }*/?>>
            <option selected="selected" value="">-----Select Premium Type----</option>
			<?php 
			$sql="SELECT * FROM signature_premium_master order by premium_id asc";
			$query=$conn->query($sql);
			while($result=$query->fetch_assoc()){
            ?>
            <option value="<?php echo $result['premium'];?>" <?php if($result['premium']==$signature_selected_premium_type){?> selected="selected" <?php }?>><?php echo $result['premium_desc'];?></option>
            <?php }?> 
            </select>
            <?php if($signature_selected_premium_type!=""){?><input type="hidden" name="signature_selected_premium_type" id="signature_selected_premium_type_hid" value="<?php echo $signature_selected_premium_type;?>"/><?php }?>
        </div>
        <label for="signature_selected_premium_type" generated="true" class="error"></label>
        <div class="clear"></div>
        </div>
        <!--.......................Woman Entrepreneurs............................-->
        <input type="hidden" name="signature_woman_entrepreneurs" id="signature_woman_entrepreneurs" value="0" />
		
        <div class="field_box">
        <div class="field_name"><strong style="color:#000; font-size:14px;">Application Summary :</strong><br />
        <span class="clear" style="height:1px; background:#ccc; display:block; margin-top:5px;"></span></div> 
        <div class="clear"></div>
        </div>
        
        <div class="field_box">
        	<input type="button" name="calculate2" id="calculate2" value="Calculate" class="button" />
        <span style="display:inline-block; float:left; margin:10px 0;">Click on calculate button to calculate the figures</span>
        
        <div class="clear"></div>
        </div>                
        <div class="clear"></div>                
        
        <div class="field_box">
        <div class="field_name">Space cost rate <?php echo $currency;?> :</div>
        <div class="field_input"><input type="text" class="bgcolor" name="signature_tot_space_cost_rate" id="signature_tot_space_cost_rate"  value="<?php echo $signature_tot_space_cost_rate;?>" readonly="readonly" /></div>
        <div class="clear"></div>
        </div>
		
		<?php 
		if(strtoupper($last_yr_signature)=="YES")
		{
		 if($_SESSION['membership_certificate_type']!='')
		 {
			if($_SESSION['membership_certificate_type']=='ZASSOC')
			{
				$space_rate_discount__sign_per="5%";
			}
			if($_SESSION['membership_certificate_type']=='ZASSOC' && $_SESSION['msme_ssi_status']=="Yes")
			{
				$space_rate_discount__sign_per="10%";
			}
			if($_SESSION['membership_certificate_type']=='ZORDIN')
			{
				$space_rate_discount__sign_per="15%";
			}
		 }
		}		
		?>
		
		<div class="field_box">
        <div class="field_name">Discount space cost rate <?php echo $currency;?> : <span id='getDiscountRateSignature'><?php echo $space_rate_discount__sign_per; ?></span></div>
        <div class="field_input"><input type="text" class="bgcolor" name="signature_tot_space_cost_discount" id="signature_tot_space_cost_discount"  value="<?php echo $signature_tot_space_cost_discount;?>" readonly="readonly" /></div>
        <div class="clear"></div>
        </div>
          
		<div class="field_box">
        <div class="field_name">After Discount space cost <?php echo $currency;?> :</div>
        <div class="field_input"><input type="text" class="bgcolor" name="signature_get_tot_space_cost_rate" id="signature_get_tot_space_cost_rate"  value="<?php echo $signature_get_tot_space_cost_rate;?>" readonly="readonly" /></div>
        <div class="clear"></div>
        </div>
		
        <div class="field_box">
        <div class="field_name">Category  cost <?php echo $currency;?> :</div>
        <div class="field_input"><input type="text" class="bgcolor" name="signature_get_category_rate" id="signature_get_category_rate"  value="<?php echo $signature_get_category_rate;?>" readonly="readonly" /></div>
        <div class="clear"></div>
        </div>
        
        <div class="field_box">
        <div class="field_name">Selected scheme rate <?php echo $currency;?>:</div>
        <div class="field_input"><input type="text" class="bgcolor" name="signature_selected_scheme_rate" id="signature_selected_scheme_rate" readonly="readonly" value="<?php echo $signature_selected_scheme_rate;?>" /></div>
        <div class="clear"></div>
        </div>
                        
        <div class="field_box">
        <div class="field_name">Selected premium rate <?php echo $currency;?>:</div>
        <div class="field_input"><input type="text" class="bgcolor" name="signature_selected_premium_rate" id="signature_selected_premium_rate" readonly="readonly" value="<?php echo $signature_selected_premium_rate;?>"/></div>
        <div class="clear"></div>
        </div>                
        
        <div class="field_box">
        <div class="field_name">Sub Total cost <?php echo $currency;?>:</div>
        <div class="field_input"><input type="text" class="bgcolor" name="signature_sub_total_cost" id="signature_sub_total_cost" readonly="readonly" value="<?php echo $signature_sub_total_cost;?>" /></div>
        <div class="clear"></div>
        </div>     
        
        <div class="field_box">
        <div class="field_name">Security Deposit (10% on SubTotal Cost) <?php echo $currency;?> :</div>
        <div class="field_input"><input type="text" class="bgcolor" name="signature_security_deposit" id="signature_security_deposit" readonly="readonly" value="<?php echo $signature_security_deposit;?>" /></div>
        <div class="clear"></div>
        </div>                
        
        <div class="field_box">
        <div class="field_name">GST (18% on SubTotal Cost) <?php echo $currency;?> :</div>
        <div class="field_input"><input type="text" class="bgcolor" id="signature_govt_service_tax" name="signature_govt_service_tax" readonly="readonly" value="<?php echo $signature_govt_service_tax;?>" /></div>
        <div class="clear"></div>
        </div>             
        
        <div class="field_box">
        <div class="field_name"><strong>Grand Total </strong><?php echo $currency;?> :</div>
        <div class="field_input"><input type="text" class="bgcolor" id="signature_grand_total" name="signature_grand_total" readonly="readonly" value="<?php echo $signature_grand_total;?>" /></div>
        <div class="clear"></div>
        </div>    
        <div class="clear" style="height:10px;"></div>       
    	  
    <div class="clear"></div>
	</div>
	<input type="hidden" name="action" value="signatureAction">
	</form>


	<!--------------------------------------      IIJS TRITIYA   ------------------------------ -->
<!--     <div class="clear"></div> -->
    <form  method="post" name="form3" id="form3" style="width:32%; float:left;" class="">
     <h1 class="form-title">IIJS Tritiya 2023</h1>
    <div class="form_main overlay_blur">
 
    <div class="clear"></div>    
    <div style="float:right; font-size:13px; font-weight:bold;"></div>    
    <div class="clear"></div>
    <?php 
	/*...........................Last year participant  ..........................*/
	//echo "select * from exh_registration where uid='$registration_id' and `show`='IIJS Signature 2019' and last_yr_section_flag='1' and  curr_last_yr_check='N' order by exh_id desc limit 0,1";
	$tritiyaQuery = "select * from exh_registration where uid='$registration_id' and `show`='IIJS Tritiya 2022' and last_yr_section_flag='1' and  curr_last_yr_check='N' order by exh_id desc limit 0,1";
	$query_tritiya = $conn->query($tritiyaQuery);
	$result_tritiya1 = $query_tritiya->fetch_assoc();
	$tritiya_exh_id = $result_tritiya1['exh_id'];
	$num3=$query_tritiya->num_rows;	

	$query=$conn->query("select * from exh_registration where uid='$registration_id' AND gid='$gid' AND `show`='$tritiya_show'");
	$resulty=$query->fetch_assoc();
	$num=$query->num_rows;
	if($num3>0)
	{
		$tritiya_option=$result_tritiya1['options'];
		$tritiya_category=$result_tritiya1['category'];
		$tritiya_area=$result_tritiya1['selected_area'];
		$tritiya_section=$result_tritiya1['section'];
		$tritiya_selected_scheme_type=$result_tritiya1['selected_scheme_type'];
		$tritiya_selected_premium_type=$result_tritiya1['selected_premium_type'];			
	}
	else
	{
		$tritiya_section=$resulty['section'];
		$tritiya_category=$resulty['category'];
		$tritiya_option=$resulty['options'];
		$tritiya_area=$resulty['selected_area'];
		$tritiya_selected_scheme_type=$resulty['selected_scheme_type'];
		$tritiya_selected_premium_type=$resulty['selected_premium_type'];
		$tritiya_tot_space_cost_rate=$resulty['tot_space_cost_rate'];
		$tritiya_selected_scheme_rate=$resulty['selected_scheme_rate'];
		$tritiya_selected_premium_rate=$resulty['selected_premium_rate'];
		$tritiya_sub_total_cost=$resulty['sub_total_cost'];
		$tritiya_security_deposit=$resulty['security_deposit'];
		$tritiya_govt_service_tax=$resulty['govt_service_tax'];
		$tritiya_grand_total=$resulty['grand_total'];
		$tritiya_mezzanine_space_charges=$resulty['mezzanine_space_charges'];
		$tritiya_mcb_charges=$resulty['mcb_charges'];
		$tritiya_woman_entrepreneurs=$resulty['woman_entrepreneurs'];			
  }
	?>
        <div class="field_box">
            <div class="field_name">Last year participant : <?php if($result_tritiya1['last_yr_participant']=='YES'){ echo $last_yr_signature="YES"; } else {echo $last_yr_signature="NO";}?></div>
          
              <input type="hidden" name="last_yr_tritiya_participant" id="last_yr_tritiya_participant" value="<?php echo $last_yr_signature;?>"/>
             	<input type="hidden" name="tritiya_exh_id" id="tritiya_exh_id" value="<?php echo $tritiya_exh_id?>"/>
            <label for="last_yr_tritiya_participant" generated="true" class="error"></label>
            <div class="clear"></div>
        </div>
        <div class="field_box" >
            <div class="field_name" style="width:100%">Membership Status :  <?php echo $_SESSION['member_type'];?></div>
           
            <div class="clear"></div>
        </div>
        <?php if($num2>0){ ?>
        <div class="field_box">
            <div class="field_name">Last year details :</div>
            <div class="field_input" style="padding-top:5px; line-height:25px;">
            <strong>Section :</strong> <?php echo strtoupper($result_tritiya1['section']);?><br />
            <strong>Area :</strong> <?php echo strtoupper($result_tritiya1['selected_area']);?> <br />
            <strong>Category type :</strong> <?php echo $result_tritiya1['category'];?> <br />
            <strong>Premium type :</strong> <?php echo strtoupper($result_tritiya1['selected_premium_type']);?>           
            </div>
            <div class="clear"></div>
        </div>
        <?php } ?>
      
				 
        <div class="field_box">
        <div class="field_name">Select your section <span>*</span>:</div>
        <div class="field_input">
          <select name="tritiya_section" id="tritiya_section" class="bgcolor" <?php if($tritiya_section!="" && ($_SESSION['COUNTRY']=="IN") && $num2!=0){?> disabled="disabled" <?php }?>>
          <option selected="selected" value="">-----Select Section----</option>
            <?php
			if($_SESSION['COUNTRY']=="IN")
			{
				
            $query=$conn->query($sql_section);
            while($result=$query->fetch_assoc()){
            ?>
            <option value="<?php echo $result['section'];?>" <?php if($result['section']==trim($tritiya_section)){?> selected="selected" <?php }?> ><?php echo $result['section_desc'];?></option>
            <?php } } else { ?>
            <option value="International Jewellery" <?php if($tritiya_section=="International Jewellery"){?> selected="selected" <?php }?>>International Jewellery</option>
            <option value="International Loose" <?php if($tritiya_section=="International Loose"){?> selected="selected" <?php }?>>International Loose</option>
            <?php } ?>
          </select>
          <?php if($tritiya_section!="" && $num2>0){?><input type="hidden" name="tritiya_section" id="tritiya_section_hid" value="<?php echo $tritiya_section;?>"/><?php } ?>          
        </div>
        <label for="tritiya_section" generated="true" class="error"></label>
        <div class="clear"></div>
        </div>
        				
       
        
        <div class="field_box">
        <div class="field_name">Select your area <span>*</span>:</div>
        <div class="field_input"> 
          <select name="tritiya_area" id="tritiya_area" class="bgcolor" <?php if($tritiya_area!="" && $num2!=0){?> disabled="disabled"<?php }?>>
            <option selected="selected" value="">-----Select Area----</option>
            <?php
			//if($num2==0){ $sql="SELECT * FROM signature_area_master where area=9"; } else {
			$sql="SELECT * FROM signature_area_master order by area_id asc"; //}
			$query=$conn->query($sql);
			while($result=$query->fetch_assoc()){ ?>
            <option value="<?php echo $result['area'];?>" <?php if($result['area']==$tritiya_area){?> selected="selected" <?php }?>><?php echo $result['area'];?></option>
            <?php }?>
          </select>
           <?php if($tritiya_area!=""){?><input type="hidden" name="tritiya_area" id="tritiya_area_hid" value="<?php echo $tritiya_area;?>"/><?php }?>    
        <input type="hidden" name="lastYearTritiyaArea" id="lastYearTritiyaArea" value="<?php echo $tritiya_area;?>"/>
        </div>
        <label for="tritiya_area" generated="true" class="error"></label>
        <div class="clear"></div>
        </div>
		
	
        <!--.......................Woman Entrepreneurs............................-->
   
		
        <div class="field_box">
        <div class="field_name"><strong style="color:#000; font-size:14px;">Application Summary :</strong><br />
        <span class="clear" style="height:1px; background:#ccc; display:block; margin-top:5px;"></span></div> 
        <div class="clear"></div>
        </div>
        
       <!--  <div class="field_box">
        	<input type="button" name="calculate3" id="calculate3" value="Calculate" class="button" />
        <span style="display:inline-block; float:left; margin:10px 0;">Click on calculate button to calculate the figures</span>
        
        <div class="clear"></div>
        </div>   -->              
        <div class="clear"></div>                
        
      
	  		<!-- <div class="field_box">
        <div class="field_name">Space cost rate <?php echo $currency;?> :</div>
        <div class="field_input"><input type="text" class="bgcolor" name="tritiya_tot_space_cost_rate" id="tritiya_tot_space_cost_rate"  value="<?php echo $tritiya_tot_space_cost_rate;?>" readonly="readonly" /></div>
        <div class="clear"></div>
        </div>
		 -->
	

		
        
        <div class="field_box">
        <div class="field_name">Sub Total cost <?php echo $currency;?>:</div>
        <div class="field_input"><input type="text" class="bgcolor" name="tritiya_sub_total_cost" id="tritiya_sub_total_cost" readonly="readonly" value="<?php echo $tritiya_sub_total_cost;?>" /></div>
        <div class="clear"></div>
        </div>     
        
                
        
        <div class="field_box">
        <div class="field_name">GST (18% on SubTotal Cost) <?php echo $currency;?> :</div>
        <div class="field_input"><input type="text" class="bgcolor" id="tritiya_govt_service_tax" name="tritiya_govt_service_tax" readonly="readonly" value="<?php echo $tritiya_govt_service_tax;?>" /></div>
        <div class="clear"></div>
        </div>             
        
        <div class="field_box">
        <div class="field_name"><strong>Grand Total </strong><?php echo $currency;?> :</div>
        <div class="field_input"><input type="text" class="bgcolor" id="tritiya_grand_total" name="tritiya_grand_total" readonly="readonly" value="<?php echo $tritiya_grand_total;?>" /></div>
        <div class="clear"></div>
        </div>    
        <div class="clear" style="height:10px;"></div>       
    	  
    <div class="clear"></div>
	</div>
	<input type="hidden" name="action" value="tritiyaAction">
	</form>
    
    <div class="field_box" style=" display: inline-block;text-align: center;margin-left: 50%;transform: translate(-50%); ">
	<a href="exhibitor_registration_step_2.php" class="button">Prev</a>
	<a href="exhibitor_registration_step_4_combo.php" class="button" id="step4combo" style="display: none;">Exhibitor Registration Combo Step 4 </a>
    <input type="submit" id="submitIijs" class="button" value="Submit IIJS Premiere 2022 Information" disabled='disabled' />
    </div>
    <label for="submit" class="success" generated="true" style="display: block;
    text-align: center;"></label>
    </div>
	</div>	
<div class="clear" style="height:10px;"></div>
</div>

<div class="footer"><?php include('footer.php'); ?><div class="clear"></div></div>
<div class="clear"></div>
</div>

<style>
.field_box .field_name {width:50%; margin:5px 0; font-weight:bold; font-size:12px;}
.field_box input[type="submit"], .field_box input[type="button"], .field_box a.button {padding:8px 12px;}
.inner_container {width:80%; margin:0 auto;}
.content_area {width:100%; background-size:100%;}
.form_wrp {width:100%; float:left; border-right:2px dotted #ddd;}
.container_right {width:38%; float:left; margin-left:1%;}
.form-title {padding-left:15px;  font-size:16px; color:#ef4e22;}
.field_box .field_input select {width:100%;}
.field_box .field_input {display:block; width:50%;}
.field_box .field_input input[type="text"] {width:97%;}
.overlay{position: relative;}

.overlay:after{  
	content: "";
    position: absolute;
    height: auto;
    width: auto;
    top: 0;
    right: 0;
    left: 0;
    bottom: 0;
    border: 1px solid#efb0b0;
    background: #4caf5066; }
    
	.overlay_blur{position: relative;}

.overlay_blur:after{  
    content: "";
    position: absolute;
    height: auto;
    width: auto;
    top: 0;
    right: 0;
    left: 0;
    bottom: 0;
    border: 1px solid#efb0b0;
    background: #fafafaeb; }
  

/**/
</style>
</body>
</html>
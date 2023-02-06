<?php include('header_include.php');
if(!isset($_SESSION['USERID'])){ header("location:login.php"); exit; }

if(($_SESSION['eventInfo']['event_selected'] =="")){ header("location:event_selection.php");	exit; }
if($_SESSION['eventInfo']['event_selected']=='combo'){ header("location:event_selection.php");	exit; }
$event_selected = $_SESSION['eventInfo']['event_selected'];

/*  Check Event */
/*
 if($_SESSION['eventInfo']['event_selected']=="signature"){ $event_for="IIJS SIGNATURE 2022"; } 
 if($_SESSION['eventInfo']['event_selected']=="iijs") { $event_for="IIJS 2022"; }
*/

$event_selected = $_SESSION['eventInfo']['event_selected'];
$event_for = getExhEventDescriptionEvent($event_selected,$conn);
/*  Check Event */
?>
<?php
//echo '<pre>'; print_r($_SESSION); exit;
$registration_id=$_SESSION['USERID'];
$gid = intval($_REQUEST['gid']);
$action=@$_REQUEST['action'];
if($action=="Save")
{ //echo '<pre>'; print_r($_REQUEST); exit;
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
	//print_r($stallInfo);
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
  category=$('#category').val();
  selected_area=$("#selected_area").val();
  selected_premium_type=$("#selected_premium_type").val();
  
 selected_scheme_type = $('#selected_scheme_type').val();
 country =  <?php echo json_encode($_SESSION['COUNTRY']);?>
  
	$.ajax({ type: 'POST',
					url: 'igjme_ajax.php',
					data: "actiontype=calculatePayment&&selected_area="+selected_area+"&&selected_premium_type="+selected_premium_type+"&&selected_scheme_type="+selected_scheme_type+"&&category="+category,
					//dataType:'html',
					beforeSend: function(){
							$('#preloader').show();
							$('#status').show();
							},
					success: function(data){
							   // alert(data);return false;
							   $('#preloader').hide();
								$('#status').hide();
								var data=data.split("#");
								$('#tot_space_cost_rate').val(data[0]);
								//$('#selected_scheme_rate').val(data[]);
								$('#selected_premium_rate').val(data[1]); 
								$('#sub_total_cost').val(data[2]);
								$('#security_deposit').val(data[3]);
								$('#govt_service_tax').val(data[4]);
								$('#grand_total').val(data[5]);
							}
		});
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
			/*category: {
			required: true,
			},*/
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
			/*category:{
				required: "Please select category",
			},*/
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
  $("#category").live('change',function(){
	  $('#tot_space_cost_rate').val('');
	  $('#selected_scheme_rate').val('');
	  $('#selected_premium_rate').val('');
	  $('#sub_total_cost').val('');
	  $('#security_deposit').val('');
	  $('#govt_service_tax').val('');
	  $('#grand_total').val('');
 });
</script>

<script>
  $("#selected_area").live('change',function(){
	  $('#tot_space_cost_rate').val('');
	  $('#selected_scheme_rate').val('');
	  $('#selected_premium_rate').val('');
	  $('#sub_total_cost').val('');
	  $('#security_deposit').val('');
	  $('#govt_service_tax').val('');
	  $('#grand_total').val('');
 });
</script>

<script>
  $("#selected_scheme_type").live('change',function(){
	  $('#tot_space_cost_rate').val('');
	  $('#selected_scheme_rate').val('');
	  $('#selected_premium_rate').val('');
	  $('#sub_total_cost').val('');
	  $('#security_deposit').val('');
	  $('#govt_service_tax').val('');
	  $('#grand_total').val('');
 });
</script>

<script>
  $("#selected_premium_type").live('change',function(){
	  $('#tot_space_cost_rate').val('');
	  $('#selected_scheme_rate').val('');
	  $('#selected_premium_rate').val('');
	  $('#sub_total_cost').val('');
	  $('#security_deposit').val('');
	  $('#govt_service_tax').val('');
	  $('#grand_total').val('');
 });
</script>
<script>
// $("#option").live('change',function(){
	
// var selectedVal = "";
// var selected = $("input[type='radio'][name='option']:checked");
// if (selected.length > 0) {
    // selectedVal = selected.val();
	// if(selectedVal=='New participant')
	// {
		// $("#selected_area").attr("disabled", "disabled");
	// }

	
	// }
// });
</script>
<script>
  $("#option").live('change',function(){
	
	  option=$('input[name=option]:checked').val(); alert(option);
	  
	  if(option=="Same stall position size as of previous year")
	  {
		//$("#category").attr("disabled", "disabled"); comment on 12nov
		$("#category").removeAttr("disabled");
		$("#selected_area").attr("disabled", "disabled");
		$("#selected_scheme_type").attr("disabled", "disabled");
		$("#selected_premium_type").attr("disabled", "disabled");
		
		$("#selected_area").val($("#selected_area_hid").val());
		$("#selected_scheme_type").val($("#selected_scheme_type_hid").val());
		$("#selected_premium_type").val($("#selected_premium_type_hid").val());
	  }
	  else if(option=="Same area but different location as of previous year IGJME")
	  {
		$("#category").removeAttr("disabled");
		//$("#selected_scheme_type").removeAttr("disabled");
		$("#selected_scheme_type").attr("disabled");
		$("#selected_premium_type" ).removeAttr("disabled");
		$("#selected_area").attr("disabled", "disabled"); 
		
		//$("#selected_scheme_type_hid").attr("disabled", "disabled");
		$("#selected_premium_type_hid").attr("disabled", "disabled");
	  }
	  else if(option=="More area than previous year IGJME")
	  {
		$("#category").removeAttr("disabled");
	  	$("#selected_area").removeAttr("disabled");
		$("#selected_scheme_type").attr("disabled");
		$("#selected_premium_type").removeAttr("disabled");
		
		$("#selected_area_hid").attr("disabled", "disabled");
		//$("#selected_scheme_type_hid").attr("disabled", "disabled");
		$("#selected_premium_type_hid").attr("disabled", "disabled");
	 }
	  else if(option=="Less area as previous year")
	  {
		$("#category").removeAttr("disabled");
		$("#selected_area").removeAttr("disabled");
		$("#selected_scheme_type").attr("disabled");
		$("#selected_premium_type").removeAttr("disabled");
		
		$("#selected_area_hid").attr("disabled", "disabled");
		//$("#selected_scheme_type_hid").attr("disabled", "disabled");
		$("#selected_premium_type_hid").attr("disabled", "disabled");
	  }
	  lastYearArea=$('#lastYearArea').val();
	
	  $.ajax({ type: 'POST',
					url: 'igjme_ajax.php',
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
 });
</script>

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
	  <div class="title"><h4 style="padding:10px 15px;text-align: center; color: #fff; display: table; background: #00000099; margin: 20px auto; border: 1px solid#000; -webkit-box-shadow: 0px 0px 11px -2px rgba(0,0,0,1); -moz-box-shadow: 0px 0px 11px -2px rgba(0,0,0,1); box-shadow: 0px 0px 11px -2px rgba(0,0,0,1); border-radius: 6px;">PARTICIPATION STALL DETAILS</h4></div>
	  
   
                        <!--
                        <table class="table">
                            <thead class="thead-dark">
                                <th>Category</th>
                                <th>IGJME</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>GJEPC Member</td>
                                    <td>14500</td>
                                </tr>
                                <tr>
                                    <td>GJEPC Non-Member</td>
                                    <td>15000</td>
                                </tr>
                            </tbody>
                        </table>-->
                        
                        <form class="cmxform" method="post" name="from1" id="form1">
                        
                            <div class="form_main">
							<div class="clear"></div>
    
							<div style="float:right; font-size:13px; font-weight:bold;"></div>    
							<div class="clear"></div>
                            
                                <?php 
                                    /*...........................Last year participant  ..........................*/
                                    //echo "select * from igjme_exh_registration where uid='$registration_id' and `show`='IGJME 2020' and last_yr_section_flag='1' and  curr_last_yr_check='N' order by exh_id desc limit 0,1";
                                    $query1=$conn->query("select * from igjme_exh_registration where uid='$registration_id' and `show`='IGJME 2020' and last_yr_section_flag='1' and  curr_last_yr_check='N' order by exh_id desc limit 0,1");
                                    $result1=$query1->fetch_assoc();
                                    $exh_id=$result1['exh_id'];
                                    $num1=$query1->num_rows;
                                    $query=$conn->query("select * from exh_registration where uid='$registration_id' and gid='$gid' and `show`='$show'");
                                    $result=$query->fetch_assoc();
                                    $num=$query->num_rows;
                                    if($num>0)
                                    {
                                        $section=$result['section'];
                                        $category=$result['category'];
                                        $selected_scheme_type=$result['selected_scheme_type'];
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
                                    }else{
                                        $option=$result1['options'];
                                        $category=$result1['category'];
                                        $selected_scheme_type=$result1['selected_scheme_type'];
                                        $selected_area=$result1['selected_area'];
                                        $section=$result1['section'];
                                        $selected_premium_type=$result1['selected_premium_type'];
                                    }
                                ?>
                                
                                <!--<div class="col-12 form-group">
                                    <span style="font-size:14px;">Last year participant :
                                        <span class="chkbox" style="width:100px;">
                                            <?php if($num1>0){ echo $last_yr="Yes"; ?>
                                            <?php } else { echo $last_yr="No";}?>
                                        </span>
                                        <input type="hidden" name="last_yr_participant" id="last_yr_participant" class="form-control" value="<?php echo $last_yr;?>"/>
                                    </span>
                                    <div class="clear"></div>
                                </div>-->
                                
                                <?php  if($num1>0){ ?>
                                    <!--<div class="col-12 form-group">                                    
                                        <p class="blue">Last year details</p>                                        
                                        <strong>Category :</strong> <?php echo strtoupper($category);?> <br />
                                        <p><strong>Area :</strong> <?php echo strtoupper($selected_area);?> </p>
                                        <p><strong>Scheme type :</strong> <?php echo $selected_scheme_type;?> </p>
                                        <p><strong>Premium type :</strong> <?php echo getPremiumName($selected_premium_type,$conn);?></p> 
                                    </div>-->
                                <?php } ?>
                                
                                <div class="field_box">
									<div class="field_name">Please select any of the option <span>*</span> :</div>
									 <div class="field_input" style="padding-top:5px; line-height:25px;">
								</div>
                                
                                 <div class="col-12 form-group">
                                    
                                    <input type="hidden" name="exh_id" id="exh_id" value="<?php echo $exh_id?>"/>
                                    <?php if($num1==0){ ?>
                                    
                                    <!--<p> <input type="radio" id="option" class="bgcolor" name="option"  checked="checked" value="New participant" /> <label for="b_1">New participant</label></p>-->	
                                    
                                    <?php } else { ?>
                                    
                                    <p><input type="radio" id="option" class="bgcolor" name="option" value="Same stall position size as of previous year" <?php if($option=="Same stall position size as of previous year"){?> checked="checked" <?php } ?> /> Same stall position size as of previous year</p>
                                    
                                    <p><input type="radio" id="option" class="bgcolor" name="option" value="Same area but different location as of previous year IGJME" <?php if($option=="Same area but different location as of previous year IGJME"){?> checked="checked" <?php } ?>/> 
                                    Same area but different location as of previous year IGJME</p>
                                    
                                    <p> <input type="radio" id="option" class="bgcolor" name="option" value="More area than previous year IGJME" <?php if($option=="More area than previous year IGJME"){?> checked="checked" <?php } ?>  /> More area than previous year IGJME</p>
                                    
                                    <p> <input type="radio" id="option" class="bgcolor" name="option" value="Less area as previous year" <?php if($option=="Less area as previous year"){?> checked="checked" <?php } ?>  /> Less area as previous year </p>
                                    
                                    <?php } ?>
                                </div>        
								<div class="clear"></div>
								</div>
                     
                                <!--<div class="field">
                                 Please select any of the option <span>*</span> : <br/>
                                 <input type="hidden" name="exh_id" id="exh_id" value="<?php echo $exh_id?>"/>
                                <?php if($num1==0){?>
                                <input type="radio" id="option" class="bgcolor" name="option"  checked="checked" value="New participant" /> <label for="b_1">New participant</label><br />
                                <?php } else { ?>
                                
                                <?php if($option=="Same stall position size as of previous year"){ ?>
                                <input type="radio" id="option" class="bgcolor" name="option" value="Same area but different location as of previous year IGJME 2016" <?php if($option=="Same stall position size as of previous year"){?> checked="checked" <?php } ?>/>
                                Same area but different location as of previous year IGJME 2016<br/>
                                
                                <?php } elseif($option=="More area than previous year IGJME") {?>
                                <input type="radio" id="option" class="bgcolor" name="option" value="More area than previous year IGJME" <?php if($option=="More area than previous year IGJME"){?> checked="checked" <?php } ?>  /> More area than previous year IGJME<br/>
                                
                                <?php } elseif($option=="Less area as previous year") {?>
                                <input type="radio" id="option" class="bgcolor" name="option" value="Less area as previous year" <?php if($option=="Less area as previous year"){?> checked="checked" <?php } ?>  /> Less area as previous year
                                <?php } ?>
                                <?php } ?>
                                    <div class="clear"></div>
                                 </div>-->
                                 
                                <input type="hidden" id="category" name="category" value="IGJME"/>
                                <!--<div class="field">
                                <label>Select your Category <span>*</span>: </label>
                                  <select class="textField" id="category" name="category">
                                    <option value="">-----Select Category----</option>
                                    <option value="IGJME" <?php if($category=='IGJME'){?> selected="selected" <?php }?> >IGJME</option>
                                    <?php /*?><option value="IIJS" <?php if($category=='IIJS'){?> selected="selected" <?php }?> >IIJS</option><?php */?>
                                    <option value="COMBO" <?php if($category=='COMBO'){?> selected="selected" <?php }?> >IGJME & IIJS Combo</option>
                                 </select>
                                    <div class="clear"></div>
                                </div>-->
                
                                <div class="field_box">
									<div class="field_name">Select your area <span>*</span>:</div>
									<div class="field_input">
                                    <select name="selected_area" id="selected_area" class="form-control valid" <?php /*if($selected_area!=""){?> disabled="disabled"<?php }*/?>>
                                    <option  value="">-----Select Area----</option>
                                    <?php 
                                        $sql="SELECT * FROM igjme_area_master WHERE STATUS =  '1' ORDER BY area ASC ";
                                        $query=$conn->query($sql);
                                        while($result=$query->fetch_assoc()){
                                    ?>
                                    <option value="<?php echo $result['area'];?>" <?php if($result['area']==$selected_area){?> selected="selected" <?php }?>><?php echo $result['area'];?></option>
                                    <?php }?>
                                    </select>
                                    <input type="hidden" name="lastYearArea" id="lastYearArea" value="<?php echo $selected_area;?>"/>
                                    <?php if($selected_area!=""){?><input type="hidden" name="selected_area" id="selected_area_hid" value="<?php echo $selected_area;?>"/><?php }?>
                                    </div>
									<div class="clear"></div>
								</div>
                                
                                <div class="field_box">
									<div class="field_name">Select your scheme type <span>*</span>:</div>
									<div class="field_input">
                                    <select class="form-control" id="selected_scheme_type" name="selected_scheme_type" <?php if($selected_scheme_type!=""){?> disabled="disabled"<?php }?>>
                                        <option  value="">-----Select Scheme Type----</option>
                                        <option value="BI1" <?php if($selected_scheme_type=='BI1'){?> selected="selected" <?php }?> >Shell Scheme</option>
                                    </select>
                                    <div class="clear"></div>
                                    <?php if($selected_scheme_type!=""){?>
                                        <input type="hidden" name="selected_scheme_type" id="selected_scheme_type_hid" value="<?php echo $selected_scheme_type;?>"/>
                                    <?php }?>
									</div>
								<div class="clear"></div>
								</div>
                                
                                <div class="field_box">
									<div class="field_name">Select your premium type <span>*</span>:</div>
									<div class="field_input">
                                    <select class="form-control" name="selected_premium_type" id="selected_premium_type" <?php if($selected_premium_type!=""){?> disabled="disabled"<?php }?>>
                                        <option selected="selected" value="">-----Select Premium Type----</option>
                                        <?php 
                                        $sql="SELECT * FROM iijs_premium_master order by premium_id asc";
                                        $query=$conn->query($sql);
                                        while($result=$query->fetch_assoc()){
                                        ?>
                                        <option value="<?php echo $result['premium'];?>" <?php if($result['premium']==$selected_premium_type){?> selected="selected"  <?php }?>><?php echo $result['premium_desc'];?></option>
                                        <?php }?> 
                                    </select>
                                    <div class="clear"></div>
                                    <?php if($selected_premium_type!=""){?>
                                        <input type="hidden" name="selected_premium_type" id="selected_premium_type_hid" value="<?php echo $selected_premium_type;?>"/>
                                    <?php }?>
									</div>
								<div class="clear"></div>
								</div>
                                
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
								<div class="field_name"><strong>Space cost rate </strong>:</div>
								<div class="field_input"><input type="text" class="bgcolor" name="tot_space_cost_rate" id="tot_space_cost_rate"  value="<?php echo $tot_space_cost_rate;?>" readonly="readonly" /></div>
								<div class="clear"></div>
								</div>
                                
                                <div class="field_box">
								<div class="field_name"><strong>Premium Rate</strong>:</div>
                                <div class="field_input"><input type="text" class="bgcolor" name="selected_premium_rate" id="selected_premium_rate" readonly="readonly" value="<?php echo $selected_premium_rate;?>"/>
                                </div>
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
                            
                                <div class="field_box">
								<div class="field_name"></div>
								<div class="field_input">
                                    <input type="hidden" name="action" value="Save" />
                                    <input type="submit" class="button" value="Proceed to next step" />  
                                </div>
								</div>   
                            
                    	</form>
                	
                    </div>  
            
                </div>
                
                       
            </div>        
        </div>  	
    </div>
</section>

<div class="clear" style="height:10px;"></div>
</div>
<div class="footer"><?php include('footer.php');?><div class="clear"></div>
</div>

<div class="clear"></div>
</div>
</body>
</html>
   


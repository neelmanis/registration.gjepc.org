<?php
/*
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/
include('header_include.php');
if(!isset($_SESSION['USERID'])){ header("location:login.php"); exit; }
$uid = $_SESSION['USERID'];
$gid = intval($_REQUEST['gid']);
$show = $_REQUEST['show'];
$year = $_REQUEST['year'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Exhibitor Registration - Print Application</title>
<link rel="icon" href="https://gjepc.org/assets/images/fav_icon.png" type="image/x-icon"/>
<link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Cabin'>
<link rel="stylesheet" type="text/css" href="https://gjepc.org/assets-new/css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="css/general.css?v=<?php echo $version;?>" />
<link rel="stylesheet" type="text/css" href="css/inner_pg_style.css?v=<?php echo $version;?>" />
<link rel="stylesheet" type="text/css" href="css/responsive.css?v=<?php echo $version;?>" />
<link rel="stylesheet" type="text/css" href="css/media_query.css?v=<?php echo $version;?>" />
<script type="text/javascript" src="js/jquery-1.9.1.js"></script>
 <script src="https://gjepc.org/assets-new/js/bootstrap.min.js"></script>
<!--NAV-->
<link href="css/flexnav.css?v=<?php echo $version;?>" media="screen, projection" rel="stylesheet" type="text/css">
<script src="js/jquery.flexnav.js?v=<?php echo $version;?>" type="text/javascript"></script>
<script src="js/common.js?v=<?php echo $version;?>"></script> 
<!--NAV-->
<script src="jsvalidation/jquery.validate.js" type="text/javascript"></script>
<!-- UItoTop plugin -->
<link rel="stylesheet" type="text/css" media="screen,projection" href="css/ui.totop.css?v=<?php echo $version;?>" />
<script src="js/easing.js?v=<?php echo $version;?>" type="text/javascript"></script>
<script src="js/jquery.ui.totop.js?v=<?php echo $version;?>" type="text/javascript"></script>    
<script type="text/javascript">
    $(document).ready(function() {        
        $().UItoTop({ easingType: 'easeOutQuart' });        
    });
</script>
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
<script language="javascript">
function first_alert()
{
	alert("Coming Soon !!!");
}
function balance_alert()
{
	alert("Kindly clear your balance payment to access Exhibitor Manual");
}
function second_alert()
{
	//alert("Coming Soon !!!");
	alert("Closed !!!");
}
</script>
<style>
button.accordion {
    background-color: #eee;
    color: #444;
    cursor: pointer;
    padding: 18px;
    width: 100%;
    border: none;
    text-align: left;
    outline: none;
    font-size: 15px;
    transition: 0.4s;
}

button.accordion.active, button.accordion:hover {
    background-color: #ddd;
}

button.accordion:after {
    content: '\002B';
    color: #777;
    font-weight: bold;
    float: right;
    margin-left: 5px;
}

button.accordion.active:after { content: "\2212"; }
div.panel {  padding: 0 18px 20px 18px;
    background-color: white;
    max-height: 0;
    overflow: hidden;
    transition: 0.6s ease-in-out;
    opacity: 0;
}
div.panel.show { opacity: 1;    max-height: 500px;  }
</style>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<?php if($show!="tritiya"){ ?>
<script src="js/save_allotment_payment.js" type="text/javascript"></script>

<script type="text/javascript">
    /*$(function () {
		$("#save").attr("disabled",true);
		
			var balancePayment = $('#balancePayment').val(); //alert(balancePayment);
			if(balancePayment != '' || balancePayment != 0)
			{			
			   var gross_total = $('#grand_total').val() * balancePayment/100;
			$("#net_payable_amount").val(gross_total);
			$("#save").attr("disabled",false);
			} else {
				alert("Please Select Amount Payable");
				return false;
			}
		
    }); */
	
	
	$(function () {
	$("#save").attr("disabled",true);
	$("#cheque_tds_per").on('change',function(){
		var balancePayment = $("#balancePayment").val(); //alert(balancePayment);
		var cheque_tds_per = $("#cheque_tds_per").val();
		$("#cheque_tds_amount").val('0').attr('readonly',false);
		if(cheque_tds_per != 0){
			if(balancePayment == '' || balancePayment == 0)
			{
				alert("Balance Payment is missing");
				return false;			
			}	else { 
				alert("Please Deduct TDS Amount on Balance payment");
				$("#cheque_tds_amount").val('');
				$("#cheque_tds_Netamount").val(''); 
			}
		} else { 
			$("#save").attr("disabled",false);
			$("#cheque_tds_Netamount").val(balancePayment); 
		//	$("#cheque_tds_amount").val('0');
			$("#cheque_tds_amount").val('0').attr('readonly',true);
		}
	});
	});
	
	function change_amount() {
		$("#save").attr("disabled",true);
        var balancePayment = $("#balancePayment").val();
        var cheque_tds_amount = $("#cheque_tds_amount").val();
		var cheque_tds_per = $("#cheque_tds_per").val();
				
		if(balancePayment != '' || balancePayment != 0)
		{
			var get_tds_amount = balancePayment * cheque_tds_per/100;
			var amount = balancePayment - cheque_tds_amount;
			// if(amount>0 && get_tds_amount >= cheque_tds_amount && cheque_tds_amount>0){
			$("#cheque_tds_Netamount").val(amount); 
			$("#save").attr("disabled",false);
			// } else {
			// alert('TDS Amount should be less than selected TDS percentage of Balance Amount'); 
			// $("#pay").attr("disabled",true);
			// $("#cheque_tds_amount").val('');
			// $("#cheque_tds_Netamount").val(''); 
			// }
		} else {
			alert("Please Select Amount Payable");
			return false;
		}
    }
</script>
<?php } ?>

<!-- Tritiya 25 % -->
<?php if($show=="tritiya"){ ?>
<script src="js/save_part_payment.js" type="text/javascript"></script>
<script type="text/javascript">	
	$(function () {
	$("#savePart").attr("disabled",true);
	$("#payment_percentage").on('change',function(){
		var payment_percentage = $('#payment_percentage').val();
		if(payment_percentage != '' || payment_percentage != 0)
		{			
			var gross_total = $('#grand_total').val() * payment_percentage/100;
		$("#net_payable_amount").val(gross_total);
		//$("#savePart").attr("disabled",false);
		} else {
			alert("Please Select Part Payment");
			$("#net_payable_amount").val('0');
			$("#savePart").attr("disabled",true);
			return false;
		}
	});
		
	$("#cheque_tds_part_per").on('change',function(){
		//var grand_total = $("#grand_total").val();
		var net_payable_amount = $("#net_payable_amount").val();
		var cheque_tds_part_per = $("#cheque_tds_part_per").val();
		
		if(cheque_tds_part_per != 0){
			if(net_payable_amount == '' || net_payable_amount == 0)
			{
				alert("Something is missing in Part Balance Payment");
				return false;			
			} else { 
				//alert("Please Enter TDS Amount");
				$("#cheque_tds_amount").val('');
				$("#cheque_tds_Netamount").val(''); 
			}
		} else {
			$("#savePart").attr("disabled",false);
			//$("#cheque_tds_Netamount").val(grand_total); 
			$("#cheque_tds_Netamount").val(net_payable_amount); 
			$("#cheque_tds_amount").val('0');
		}
	});
	});
	
	function change_PartAmount() {
		$("#savePart").attr("disabled",true);
        var net_payable_amount = $("#net_payable_amount").val();
        var cheque_tds_amount = $("#cheque_tds_amount").val();
		var cheque_tds_part_per = $("#cheque_tds_part_per").val();
		
		if(net_payable_amount != '' || net_payable_amount != 0)
		{
			//var get_tds_amount = balancePayment * cheque_tds_part_per/100;
			var get_tds_amount = net_payable_amount * cheque_tds_part_per/100;
			var amount = net_payable_amount - cheque_tds_amount;
			// if(amount>0 && get_tds_amount >= cheque_tds_amount && cheque_tds_amount>0){
			$("#cheque_tds_Netamount").val(amount); 
			$("#savePart").attr("disabled",false);
			// } else {
			// alert('TDS Amount should be less than selected TDS percentage of Gross Amount'); 
			// $("#cheque_tds_amount").val('');
			// $("#cheque_tds_Netamount").val(''); 
			//}
		} else {
			alert("Please Enter Amount Payable");
			return false;
		}
    }
</script>
<?php } ?>
</head>

<body>

<div class="wrapper">
<div class="header"><?php include('header1.php'); ?></div>

<div class="inner_container">
    <div class="clear"></div>
    
    <div class="container">
      <div class="pg_title">
        <div class="title_cont"> <span class="top">Exhibitor <img src="images/titles/joint.png" style="position:absolute; top:31px; right:0px;" /></span> <span class="below">Registration</span>
        <div class="clear"></div>
        </div>
      </div>
      
    <div class="clear"></div>
	  
    <div class="form_main">  
    <div class="form_title">Print Acknowledgment <div class="clear"></div></div>
	<?php
	if($show=="iijs")
	{
 /* comment 1 start  
 $sql_signature ="select * from exh_registration where uid='$uid' AND curr_last_yr_check='Y' AND `show`='IIJS PREMIERE 2022' order by gid desc";
    $query_signature = $conn->query($sql_signature);		
	$num1=$query_signature->num_rows;		
    if($num1>0)
	{
    while ($result_signature = $query_signature->fetch_assoc())
	{
	if($result_signature['event_selected']=="signature23"){ $event_for="IIJS SIGNATURE 2023"; } 
	if($result_signature['event_selected']=="iijs"){ $event_for="IIJS PREMIERE 2022"; $event_show = "IIJS PREMIERE 2022";} 
	$category=$result_signature['category'];
	if($category=="normal")
		$category_rate=0;
	else if($category=="corner_2side")
		$category_rate=5;
	else if($category=="corner_3side")
		$category_rate=10;
	else if($category=="island_4side")
		$category_rate=15;
		
		$category_cost=$result_signature['get_tot_space_cost_rate']*$category_rate/100;
	?>
    <button class="accordion">Click here to view Application Summary for <?php echo $event_show;?>(Exh<?php echo $result_signature['gid'];?>)</button>
	
	<div class="panel">
	<div class="clear"></div>

	<p><strong style="text-transform:uppercase; font-size:14px; padding-top: 15px">Application <?php //echo $result_signature['section'];?> on <?php echo date('jS F Y',strtotime($result_signature['created_date']));?></strong></p>
        <div class="summary_box">		
        <p><strong style="text-transform:uppercase; font-size:14px;">Application Summary</strong> <br />
        <span class="clear" style="height:1px; background:#ccc; display:block;"></span>
        <strong>Last Year Participant :</strong>&nbsp; <?php echo $result_signature['last_yr_participant'];?> <br />
        <strong>Option :</strong>&nbsp; <?php echo $result_signature['options'];?> <br />
        <strong>Section :</strong>&nbsp; <?php echo getSection_description($result_signature['section'],$conn);?> <br />
        <strong>Category :</strong>&nbsp; <?php echo strtoupper($result_signature['category']);?> <br />
        <strong>Area :</strong>&nbsp; <?php echo $result_signature['selected_area'];?> &nbsp;sqrt<br />
        <strong>Scheme :</strong>&nbsp; <?php echo getSchemeDescription_signature($result_signature['selected_scheme_type'],$conn);?> <br />
        <!--<strong>Premium :</strong>&nbsp; <?php echo $result_signature['selected_premium_type'];?>--></p>
        </div>
        
		<div class="summary_box">
        <p><strong style="text-transform:uppercase; font-size:14px;">Application Payment Summary</strong> <br />
        <span class="clear" style="height:1px; background:#ccc; display:block;"></span>
        <strong>Space Cost <?php echo $currency;?> :</strong>&nbsp; <?php echo $result_signature['tot_space_cost_rate'];?> <br />
        <strong>Category Cost <?php echo $currency;?> :</strong>&nbsp; <?php echo $result_signature['get_category_rate'];?> <br />
        <!--<strong>Space Cost Discount <?php echo $currency;?> :</strong>&nbsp; <?php echo $result_signature['tot_space_cost_discount'];?> <br />
		<strong>Space cost after Incentive<?php echo $currency;?> :</strong>&nbsp; <?php echo $result_signature['incentive_value'];?> <br />
        <strong>After Discount Space Cost<?php echo $currency;?> :</strong>&nbsp; <?php echo $result_signature['get_tot_space_cost_rate'];?> <br />-->
        
        <!--<strong>Category cost INR <?php echo $currency;?> :</strong>&nbsp; <?php echo $category_cost;?> <br />
        <strong>Selected scheme rate <?php echo $currency;?> :</strong>&nbsp; <?php echo $result_signature['selected_scheme_rate'];?> <br />
        <strong>Selected premium rate <?php echo $currency;?> :</strong>&nbsp; <?php echo $result_signature['selected_premium_rate'];?> <br />-->
        <strong>Sub Total <?php echo $currency;?> :</strong>&nbsp; <?php echo $result_signature['sub_total_cost'];?> <br />
        <strong>Security Deposit (10% on Sub Total) <?php echo $currency;?> :</strong>&nbsp; <?php echo $result_signature['security_deposit'];?> <br />
        <strong>GST (18% on Sub Total) <?php echo $currency;?> :</strong>&nbsp; <?php echo $result_signature['govt_service_tax'];?><br />
        <strong>Grand Total <?php echo $currency;?> :</strong>&nbsp; <?php echo $result_signature['grand_total'];?></p>
        </div>
		
		<div class="clear" style="height:10px;"></div>
		<?php 
		$query1=$conn->query("select * from exh_reg_payment_details where uid='$uid' AND `show`='IIJS PREMIERE 2022' order by payment_id desc limit 0,1");
		$result1=$query1->fetch_assoc();		
		?>        
        <p><strong style="text-transform:uppercase; font-size:14px;">Application Status </strong> <br />
        <span class="clear" style="height:1px; background:#ccc; display:block;"></span>
        <div style="height:10px; display:block; padding:10px;">
		<!--<div style="margin-right:50px; float:left; width: 212px;">
        <strong >Manual Application Status<?php echo $currency;?> :</strong>&nbsp; <?php echo $result1['application_status'];?></div> -->
        <div style="margin-right:50px; float:left; width: 212px;"> <strong>Application Status<?php echo $currency;?> :</strong>&nbsp; <?php echo $result1['document_status'];?>  </div>        
        <div style="margin-right:50px; float:left; width: 212px;">
        <strong>Payment  Status<?php echo $currency;?> :</strong>&nbsp; <?php echo $result1['payment_status'];?>  </div>
		</div>     
	</div>       	
      <?php
      }
	  } comment 1 End */
	  
	  
	  /*..................................Get UTR DETAIL Start.....................................*/
				$utrExist = "SELECT sum(amountPaid) as `amountPaid`,sum(tdsAmount) as `tdsAmount` FROM `utr_history` WHERE registration_id='$uid' AND `show`='IIJS PREMIERE 2022' AND payment_status='captured'";
				$existResult = $conn->query($utrExist);	
							
				while($printutr = $existResult->fetch_assoc())
				{				
					$amountPaid = $printutr['amountPaid'];
					$tdsAmountUTR = $printutr['tdsAmount'];
				}
				
				function getSpaceTDSAmount($uid,$conn)
				{
					$query_sel = "select cheque_tds_amount from exh_reg_payment_details where uid='$uid' AND `show`='IIJS PREMIERE 2022' AND event_selected='iijs' limit 0,1";
					$result_sel = $conn->query($query_sel);								
					$row = $result_sel->fetch_assoc();								
					return $row['cheque_tds_amount'];							
				}
				
				$tds_amount = getSpaceTDSAmount($uid,$conn) + $tdsAmountUTR;
				
				$tdsAmount = $tds_amount; 
				
				$getSql_signature ="select * from exh_registration where uid='$uid' AND curr_last_yr_check='Y' AND `show`='IIJS PREMIERE 2022' order by gid desc";
				$getQuery_signature = $conn->query($getSql_signature);	
				$getResult_signature = $getQuery_signature->fetch_assoc();
				$getgid = $getResult_signature['gid'];
		
				/*..................................Get UTR DETAIL END.....................................*/
				
				$host = "192.168.40.107";
				$user = "appadmin";
				$password = "G@k593#sgtk";
				$dbname = "manual_iijs2021";

                // Create connection
                $conn2 = new mysqli($host, $user, $password, $dbname);
                // Check connection
                if($conn2->connect_error) {
                    die("Connection failed: " . $conn2->connect_error);
                } else {
                    
                }
			
		$sexh="SELECT manual_iijs2021.iijs_exhibitor.exempt_gst,manual_iijs2021.iijs_exhibitor.Exhibitor_HallNo,manual_iijs2021.iijs_exhibitor.Exhibitor_Section,manual_iijs2021.iijs_exhibitor.Exhibitor_Scheme,manual_iijs2021.iijs_exhibitor.Exhibitor_DivisionNo,manual_iijs2021.iijs_exhibitor.Exhibitor_StallNo1,manual_iijs2021.iijs_exhibitor.Exhibitor_StallNo2,manual_iijs2021.iijs_exhibitor.Exhibitor_StallNo3,manual_iijs2021.iijs_exhibitor.Exhibitor_StallNo4,manual_iijs2021.iijs_exhibitor.Exhibitor_StallNo5,manual_iijs2021.iijs_exhibitor.Exhibitor_StallNo6,manual_iijs2021.iijs_exhibitor.Exhibitor_Area,manual_iijs2021.iijs_exhibitor.Exhibitor_StallType,manual_iijs2021.iijs_exhibitor.Exhibitor_Premium, manual_iijs2021.iijs_exhibitor.amountPaid, manual_iijs2021.iijs_exhibitor.amountUnpaid,manual_iijs2021.iijs_exhibitor.allotted_women FROM manual_iijs2021.iijs_exhibitor where manual_iijs2021.iijs_exhibitor.Exhibitor_Registration_ID='$uid' and manual_iijs2021.iijs_exhibitor.Exhibitor_Gid='$getgid'";
			
			/*	$sexh ="select * from exh_registration where uid='$uid' AND curr_last_yr_check='Y' AND `show`='IIJS 2021' order by gid desc"; 
			$qexh = $conn->query($sexh);  /* Don't forget to uncomment $conn*/
			
			$qexh = $conn2->query($sexh); /* This is for Manual */
			$countx = $qexh->num_rows;
			$rexh = $qexh->fetch_assoc();
			
			 $section=$rexh['Exhibitor_Section'];
			 $scheme=$rexh['Exhibitor_Scheme'];
			 $get_area=$rexh['Exhibitor_Area'];
			$allotted_women=$rexh['allotted_women'];
			 $exempt_gst=$rexh['exempt_gst'];
			 $category=$rexh['Exhibitor_StallType'];
			 $selected_premium_type=$rexh['Exhibitor_Premium'];	
		
			if($countx > 0 && $countx!='') { ?>
		<div class="field">
            <p><strong style="text-transform:uppercase; font-size:14px;">Payment Status</strong> <br />
		
		<?php
		if(strtoupper($_SESSION['COUNTRY'])=="IN")
		{
			if($section=="plain_gold" && $allotted_women =="0")
			{
				$charge="22000";
			}
			else if($section=="loose_stones" && $allotted_women =="0")
			{
				$charge="22000";
			}
			else if($section=="lab_edu" && $allotted_women =="0")
			{
				$charge="22000";
			}
			else if($section=="diamond_colorstone" && $allotted_women =="0")
			{
				$charge="22000";
			}
			else if($section=="silver" && $allotted_women =="0")
			{
				$charge="22000";
			}
			
			if($section=="plain_gold" && $allotted_women =="1")
			{
				$charge="16500";
			}
			else if($section=="loose_stones" && $allotted_women =="1")
			{
				$charge="16500";
			}
			else if($section=="lab_edu" && $allotted_women =="1")
			{
				$charge="16500";
			}
			else if($section=="diamond_colorstone" && $allotted_women =="1")
			{
				$charge="16500";
			}
			else if($section=="silver" && $allotted_women =="1")
			{
				$charge="16500";
			}
			elseif($section=="machinery" || $section=='allied'){
				if($_SESSION['member_type']=='MEMBER')
					$charge="14500";
				else
					$charge="15000";	
			}
			
		} else {
			if($section=="International Jewellery")
			{
				$charge="350";
			}
			else if($section=="International Loose")
			{
				$charge="350";
			}
			elseif($section=="machinery"){
				$charge="300";
			}
		}
		
		$last_yr_participant = $getResult_signature['last_yr_participant'];	
		$membership_certificate_type = trim($_SESSION['membership_certificate_type']);	
		$msme_ssi_status = trim($_SESSION['msme_ssi_status']);
		$space_rate	=	intval($get_area*$charge);
		/*
		if(strtoupper($last_yr_participant)=="YES")
		{
		if($membership_certificate_type!=''){
			if($membership_certificate_type=='ZASSOC')
			{
				$space_rate_discount=($space_rate*0.05);
				$space_rate_discount_per="5%";
			}
			if($membership_certificate_type=='ZASSOC' && $_SESSION['msme_ssi_status']=="Yes")
			{
				$space_rate_discount=($space_rate*0.10);
				$space_rate_discount_per="10%";
			}
			if($membership_certificate_type=='ZORDIN')
			{
				$space_rate_discount=($space_rate*0.15);
				$space_rate_discount_per="15%";
			}
		}
		}
		*/		
		if($selected_premium_type=="normal")
		{
			$selected_premium_type=0;
			$selected_premium_per="0%";
		}		
		else if($selected_premium_type=="premium")
		{
			$selected_premium_type=0.05;
			$selected_premium_per="5%";
		}
		
		if($rexh['Exhibitor_Premium']=="premium"){
			$categoryINR=0.25;
			$category_per=25;
		} else {
			if($category=="normal")
			{
				$categoryINR=0;
				$category_per=0;
			}		
			else if($category=="corner_2side")
			{
				$categoryINR=0.1;
				$category_per=10;
			}
			else if($category=="corner_3side")
			{
				$categoryINR=0.1;
				$category_per=10;
			}
			else if($category=="island_4side")
			{
				$categoryINR=0.15;
				$category_per=15;
			}
		}
				
		if($exempt_gst =="1"){
		$gst_percentage ="0";	
		}else if($exempt_gst =="0" || $exempt_gst ==""){
	    $gst_percentage ="18";
		} 
		
		//$gst_percentage ="18";
		/*
		$tot_space_cost_discount=intval($space_rate_discount);
		$get_tot_space_cost = intval($space_rate-$space_rate_discount);  // Get the total difference of Space cost Rate - Discount space cost rate

		$category_rate=$get_tot_space_cost*$categoryINR;
		
		$premium_rate=intval($get_tot_space_cost*$selected_premium_type);
		
		$sub_total_cost = floatval($get_tot_space_cost+$category_rate+$premium_rate);
		*/
		//echo $get_area .'---'.$charge;
		$category_rate = $space_rate*$categoryINR;
		
		$premium_rate = intval($space_rate*$selected_premium_type);
		
		$sub_total_cost = floatval($space_rate+$category_rate);
		
	//	$sub_total_cost = floatval($space_rate);
		$security_deposit = floatval($sub_total_cost*10)/100;
		$govt_service_tax = floatval($sub_total_cost*$gst_percentage)/100;
		$grand_total = round($sub_total_cost+$security_deposit+$govt_service_tax);				
	?>
				
		<style>.error { color :red;} #message { color :green;}</style>
		<div class="error" role="alert"></div>
		<div class="alert alert-info success-div" role="alert"></div>
		
		<div id="message"></div>
		
		<form onsubmit="return validation()">
        <table id="example" class="display" cellspacing="0" border="1" width="100%">
        <thead style="font-family:verdana; color:#fff; background-color:#924b77">
            <tr>
				<th></th>
				<th></th>
				<th align="center">Amount</th>
            </tr>
        </thead>       
        <tbody>
            <tr>
                <td align='center'>Area </td>
                <td><?php echo $rexh['Exhibitor_Area'];?></td>
                <td></td>
            </tr> 
			<tr>
                <td align='center'>Space Cost</td>
                <td><?php echo $charge;?></td>
                <td><?php echo $space_rate;?></td>
            </tr> 
			<!--<tr>
                <td align='center'>Discount Space Cost Rate</td>
                <td><?php echo $space_rate_discount_per;?></td>
                <td><?php echo $space_rate_discount;?></td>
            </tr>
			<tr>
                <td align='center'>After Discount Space Cost</td>
                <td></td>
                <td><?php echo $get_tot_space_cost;?></td>
            </tr>
            <tr>
                <td align='center'>Premium</td>
                <td><?php echo $selected_premium_per;?></td>
                <td><?php echo $premium_rate;?></td>
            </tr>-->             
			<tr>
                <td align='center'>Premium</td>
                <td><?php echo $category_per."%";?></td>
                <td><?php echo $category_rate;?></td>
            </tr> 
			<tr>
                <td align="right">TOTAL</td>
                <td></td>
                <td><?php echo $sub_total_cost;?></td>
            </tr> 
			<tr>
                <td align='center'>10% Sec Dep.</td>
                <td>10%</td>
                <td><?php echo $security_deposit;?></td>
            </tr> 
			<tr>
                <td align='center'>18% GST</td>
                <td><?php echo $gst_percentage;?>%</td>
                <td><?php echo $govt_service_tax;?></td>
            </tr> 
			<tr>
                <td align="right">TOTAL</td>
                <td></td>
                <td><?php echo $grand_total;?></td>
            </tr> 
			<tr>
                <td align="right">Total Amount Paid</td>
                <td></td>
                <td><?php echo $amountPaid;?></td>
            </tr> 
            <tr>
                <td align="right">Total TDS Paid</td>
                <td></td>
                <td><?php echo $tdsAmount;?></td>
            </tr> 
			<tr>
                <td align="right">Balance Payment</td>
                <td></td>
                <td><?php echo $amountUnpaid = $grand_total-($amountPaid+$tdsAmount);?></td>
            </tr> 
			
			<tr>
                <td align="right">TDS Percentage 0%,2%,10%<span>*</span> </td>
                <td>
				<select class="textField" name="cheque_tds_per" id="cheque_tds_per">
				<option value="">-- Select TDS Percentage --</option>
			     <option value="0">0 %</option>
			     <option value="2">2 %</option>
				 <option value="10">10 %</option>
				</select>				
                <br><label class="error" id="cheque_tds_per_error"></label></td>
                <td><?php if(isset($cheque_tds_per_error)){ echo "<span style='color: red;'>".$cheque_tds_per_error.'</span>';} ?></td>
            </tr> 
			
			<tr>
                <td align="right">TDS Amount <span>*</span> </td>
                <td>

				<input name="cheque_tds_amount" type="text" id="cheque_tds_amount" class="textField" value="<?php echo $cheque_tds_amount;?>" autocomplete="off" onkeyup="return change_amount()"/>
                <br><label class="tds_error" id="cheque_tds_amount_error"></label>
				</td>
                <td><?php if(isset($cheque_tds_amount_error)){ echo "<span style='color: red;'>".$cheque_tds_amount_error.'</span>';} ?></td>
            </tr> 
			
			<tr>
                <td align="right">Net Amount<span>*</span> </td>
                <td>
				<input name="cheque_tds_Netamount" type="text" id="cheque_tds_Netamount" class="textField" readonly	/>
                <br><label class="error" id="cheque_tds_Netamount_error"></label>
				</td>
                <td><?php if(isset($cheque_tds_Netamount_error)){ echo "<span style='color: red;'>".$cheque_tds_Netamount_error.'</span>';} ?></td>
            </tr> 
								
		</tbody>
		</table>
		<input type="hidden" name="balancePayment" id="balancePayment" value="<?php echo $amountUnpaid;?>">
		<input type="hidden" name="govt_service_tax" id="govt_service_tax" value="<?php echo $govt_service_tax;?>">
		<input type="hidden" name="security_deposit" id="security_deposit" value="<?php echo $security_deposit;?>">
		<input type="hidden" name="sub_total_cost" id="sub_total_cost" value="<?php echo $sub_total_cost;?>">
		<input type="hidden" name="tot_space_cost_rate" id="tot_space_cost_rate" value="<?php echo $space_rate;?>">
		<input type="hidden" name="selected_area" id="selected_area" value="<?php echo $rexh['Exhibitor_Area'];?>">
		<input type="hidden" name="gid" id="gid" value="<?php echo $getgid;?>">
		  <?php if($amountUnpaid>=500){ ?>
		<button class="cta fade_anim d-table mx-auto" id="save" onclick="return savePayment.save()">Click here for Payment</button>
		<?php } else { echo '---';}?>
		</form>		
        </div>
		<?php } ?>
		
        <div class="clear" style="height:10px;"></div>
		
		<!--  23 DEC 2016  ----->		
        <?php 		
		if($countx > 0 && $countx!='') { ?>
        <div style="float:right; display:block; font-size:35px; font-weight:normal;background-color:#924b77">
        <?php if($amountUnpaid<=500){?>
        	<a href="manual_iijs/index.php?uid=<?php echo $uid;?>&gid=<?php echo $getgid;?>&section=<?php echo $rexh['Exhibitor_Section'];?>" class="newMaroonBtn">Online Exhibitor Manual</a>
			<!--<a href="javascript: void(0)" onclick = "second_alert()" class="newMaroonBtn">Online Exhibitor Manuals</a>-->
            <?php } else { ?>
            <a href="javascript: void(0)" onclick = "balance_alert()" class='newMaroonBtn' style="width:420px;margin-left:145px">Online Exhibitor Manual</a>
            <?php } ?>
       	 </div>
        <?php } ?>
        <div class="clear" style="height:10px;"></div>  
	<?php	
	}
    ?>













	<?php
	if($show=="signature"){
     $shows = "IIJS SIGNATURE 2023";
			$sql_signature ="select * from exh_registration where uid='$uid' AND curr_last_yr_check='Y' AND `show`='IIJS Signature 2023' order by gid desc ";
			$query_signature = $conn->query($sql_signature);		
			$num1=$query_signature->num_rows;	
			{
				while ($result_signature = $query_signature->fetch_assoc())
				{	
					if($result_signature['event_selected']=="signature23"){ $event_for="IIJS SIGNATURE 2023"; $event_show = "IIJS SIGNATURE 2023";} 
					$category=$result_signature['category'];
					if($category=="normal")
						$category_rate=0;
					else if($category=="corner_2side")
						$category_rate=10;
					else if($category=="corner_3side")
						$category_rate=10;
					else if($category=="island_4side")
						$category_rate=15;
						
					$category_cost=$result_signature['get_tot_space_cost_rate']*$category_rate/100;
					?>
					<button class="accordion">Click here to view Application Summary for <?php echo $event_show;?>(Exh<?php echo $result_signature['gid'];?>)</button>
	
					<div class="panel">
					<div class="clear"></div>

					<p><strong style="text-transform:uppercase; font-size:14px; padding-top: 15px">Application <?php //echo $result_signature['section'];?> on <?php echo date('jS F Y',strtotime($result_signature['created_date']));?></strong></p>
						<div class="summary_box">		
						<p><strong style="text-transform:uppercase; font-size:14px;">Application Summary</strong> <br />
						<span class="clear" style="height:1px; background:#ccc; display:block;"></span>
						<strong>Last Year Participant :</strong>&nbsp; <?php echo $result_signature['last_yr_participant'];?> <br />
						<strong>Option :</strong>&nbsp; <?php echo $result_signature['options'];?> <br />
						<strong>Section :</strong>&nbsp; <?php echo getSection_description($result_signature['section'],$conn);?> <br />
						<strong>Category :</strong>&nbsp; <?php echo strtoupper($result_signature['category']);?> <br />
						<strong>Area :</strong>&nbsp; <?php echo $result_signature['selected_area'];?> &nbsp;sqrt<br />
						<strong>Scheme :</strong>&nbsp; <?php echo getSchemeDescription_signature($result_signature['selected_scheme_type'],$conn);?> <br />
						<!--<strong>Premium :</strong>&nbsp; <?php echo $result_signature['selected_premium_type'];?>--></p>
						</div>
						
						<div class="summary_box">
						<p><strong style="text-transform:uppercase; font-size:14px;">Application Payment Summary</strong> <br />
						<span class="clear" style="height:1px; background:#ccc; display:block;"></span>
						<strong>Space Cost <?php echo $currency;?> :</strong>&nbsp; <?php echo $result_signature['tot_space_cost_rate'];?> <br />
						<strong>Category Cost <?php echo $currency;?> :</strong>&nbsp; <?php echo $result_signature['get_category_rate'];?> <br />
						<!--<strong>Space Cost Discount <?php echo $currency;?> :</strong>&nbsp; <?php echo $result_signature['tot_space_cost_discount'];?> <br />
						<strong>Space cost after Incentive<?php echo $currency;?> :</strong>&nbsp; <?php echo $result_signature['incentive_value'];?> <br />
						<strong>After Discount Space Cost<?php echo $currency;?> :</strong>&nbsp; <?php echo $result_signature['get_tot_space_cost_rate'];?> <br />-->
						
						<!--<strong>Category cost INR <?php echo $currency;?> :</strong>&nbsp; <?php echo $category_cost;?> <br />
						<strong>Selected scheme rate <?php echo $currency;?> :</strong>&nbsp; <?php echo $result_signature['selected_scheme_rate'];?> <br />
						<strong>Selected premium rate <?php echo $currency;?> :</strong>&nbsp; <?php echo $result_signature['selected_premium_rate'];?> <br />-->
						<strong>Sub Total <?php echo $currency;?> :</strong>&nbsp; <?php echo $result_signature['sub_total_cost'];?> <br />
						<strong>Security Deposit (10% on Sub Total) <?php echo $currency;?> :</strong>&nbsp; <?php echo $result_signature['security_deposit'];?> <br />
						<strong>GST (18% on Sub Total) <?php echo $currency;?> :</strong>&nbsp; <?php echo $result_signature['govt_service_tax'];?><br />
						<strong>Grand Total <?php echo $currency;?> :</strong>&nbsp; <?php echo $result_signature['grand_total'];?></p>
						</div>
						
						<div class="clear" style="height:10px;"></div>
						<?php 
						$query1=$conn->query("select * from exh_reg_payment_details where uid='$uid' AND `show`='IIJS SIGNATURE 2023' order by payment_id desc limit 0,1");
						$result1=$query1->fetch_assoc();		
						?>        
						<p><strong style="text-transform:uppercase; font-size:14px;">Application Status </strong> <br />
						<span class="clear" style="height:1px; background:#ccc; display:block;"></span>
						<div style="height:10px; display:block; padding:10px;">
						<!--<div style="margin-right:50px; float:left; width: 212px;">
						<strong >Manual Application Status<?php echo $currency;?> :</strong>&nbsp; <?php echo $result1['application_status'];?></div> -->
						<div style="margin-right:50px; float:left; width: 212px;"> <strong>Application Status<?php echo $currency;?> :</strong>&nbsp; <?php echo $result1['document_status'];?>  </div>        
						<div style="margin-right:50px; float:left; width: 212px;">
						<strong>Payment Status<?php echo $currency;?> :</strong>&nbsp; <?php echo $result1['payment_status'];?>  </div>
						</div>     
					</div>       	
					<?php
					}
			}
				
			/*..................................Get UTR DETAIL Start.....................................*/
				$utrExist = "SELECT sum(amountPaid) as `amountPaid`,sum(tdsAmount) as `tdsAmount` FROM `utr_history` WHERE registration_id='$uid' AND `show`='$shows' AND payment_status='captured'";
				$existResult = $conn->query($utrExist);	
							
				while($printutr = $existResult->fetch_assoc())
				{				
					$amountPaidFromUTR = $printutr['amountPaid'];
					$tdsAmountUTR = $printutr['tdsAmount'];
				}
				
				function getSpaceTDSAmount($uid,$conn)
				{
					$query_sel = "select cheque_tds_amount from exh_reg_payment_details where uid='$uid' AND `show`='IIJS SIGNATURE 2023' AND event_selected='signature23' limit 0,1";
					$result_sel = $conn->query($query_sel);								
					$row = $result_sel->fetch_assoc();								
					return $row['cheque_tds_amount'];							
				}
				
				$tds_amount = getSpaceTDSAmount($uid,$conn) + $tdsAmountUTR;
				
				$tdsAmount = $tds_amount; 
				
				$getSql_signature ="select * from exh_registration where uid='$uid' AND curr_last_yr_check='Y' AND `show`='$shows' order by gid desc";
				$getQuery_signature = $conn->query($getSql_signature);	
				$getResult_signature = $getQuery_signature->fetch_assoc();
				$getgid = $getResult_signature['gid'];
				/*..................................Get UTR DETAIL END.....................................*/
				
				$host = "192.168.40.107";
				$user = "appadmin";
				$password = "G@k593#sgtk";
				$dbname = "manual_signature";

                // Create connection
                $conn2 = new mysqli($host, $user, $password, $dbname);
                // Check connection
				
                if ($conn2->connect_error) {
                    die("Connection failed: " . $conn2->connect_error);
                } else { 
				
                }
				
			$sexh="SELECT manual_signature.iijs_exhibitor.Exhibitor_Gid,manual_signature.iijs_exhibitor.Exhibitor_Registration_ID,manual_signature.iijs_exhibitor.exempt_gst,manual_signature.iijs_exhibitor.Exhibitor_HallNo,manual_signature.iijs_exhibitor.Exhibitor_Section,manual_signature.iijs_exhibitor.Exhibitor_Scheme,manual_signature.iijs_exhibitor.Exhibitor_DivisionNo,manual_signature.iijs_exhibitor.Exhibitor_StallNo1,manual_signature.iijs_exhibitor.Exhibitor_StallNo2,manual_signature.iijs_exhibitor.Exhibitor_StallNo3,manual_signature.iijs_exhibitor.Exhibitor_StallNo4,manual_signature.iijs_exhibitor.Exhibitor_StallNo5,manual_signature.iijs_exhibitor.Exhibitor_StallNo6,manual_signature.iijs_exhibitor.Exhibitor_Area,manual_signature .iijs_exhibitor.Exhibitor_StallType,manual_signature .iijs_exhibitor.Exhibitor_Premium,manual_signature .iijs_exhibitor.amountPaid, manual_signature.iijs_exhibitor.amountUnpaid FROM manual_signature.iijs_exhibitor where manual_signature.iijs_exhibitor.Exhibitor_Registration_ID='$uid' and manual_signature.iijs_exhibitor.Exhibitor_Gid='$getgid'";

			 $qexh = $conn2->query($sexh); 
			 $countx1 = $qexh->num_rows;
			 $rexh = $qexh->fetch_assoc();
			 $section=$rexh['Exhibitor_Section'];
			 $scheme=$rexh['Exhibitor_Scheme'];
			 $get_area=$rexh['Exhibitor_Area']; 
			 $allotted_women=0;
			 $exempt_gst=$rexh['exempt_gst'];
			 $category = $rexh['Exhibitor_StallType'];
			 $selected_premium_type=$rexh['Exhibitor_Premium'];
			 $last_yr_participant = $rexh['last_yr_participant'];	?>
			 
         <div class="row">
        	<div class="col-12 mt-2">
        		<?php 
           $signature_exh_area = $rexh['Exhibitor_Area'];
           $visitor_type = "exhibitor";
           $plant_rate = 155;
           $visitor_id = 0;
           $registration_id = $uid;
           include ('include_plant_registration.php');

        ?>
        	</div>
        </div>
	    <?php
			// echo "____".$countx1;
		if($countx1 > 0 && $countx1!='') { ?>
			
		<div class="field">
		<style>.error { color :red;} #message { color :green;}</style>
		<div class="error" role="alert"></div>
		<div class="alert alert-info success-div" role="alert"></div>
		
		<div id="message"></div>
        <p><strong style="text-transform:uppercase; font-size:14px;">Payment Status</strong> <br/>		
		<?php
		if(strtoupper($_SESSION['COUNTRY'])=="IN")
		{
			if($section=="plain_gold")
			{
				$charge="22000";
			}
			else if($section=="loose_stones")
			{
				$charge="22000";
			}			
			else if($section=="diamond_colorstone")
			{
				$charge="22000";
			}
			else if($section=="lab_edu")
			{
				$charge="22000";
			}
			else if($section=="lgd" )
			{
				$charge="22000";
			}
			else if($section=="silver")
			{
				$charge="22000";
			} elseif($section=="machinery" || $section=='allied'){
				if($_SESSION['member_type']=='MEMBER')
					$charge="14500";
				else
					$charge="15000";	
			} 
		} else {
			if($section=="International Jewellery")
			{
				$charge="350";
			}
			else if($section=="International Loose")
			{
				$charge="350";
			}
			else if($section=="machinery"){
				$charge="300";
			}
		}
		
		$membership_certificate_type = trim($_SESSION['membership_certificate_type']);	
		$msme_ssi_status = trim($_SESSION['msme_ssi_status']);
		
		$space_rate	=	intval($get_area*$charge);
		
		if($rexh['Exhibitor_Premium']=="premium"){
			$categoryINR=0.15;
			$category_per=15;
		} else {
			if($category=="normal")
			{
				$categoryINR=0;
				$category_per=0;
			}		
			else if($category=="corner_2side")
			{
				$categoryINR=0.01;
				$category_per=10;
			}
			else if($category=="corner_3side")
			{
				$categoryINR=0.01;
				$category_per=10;
			}
			else if($category=="island_4side")
			{
				$categoryINR=0.15;
				$category_per=15;
			}
		}
		
		$category_cost = floatval($space_rate*$category_per)/100;
		
		if($exempt_gst =="1"){
		$gst_percentage ="0";	
		}else if($exempt_gst =="0" || $exempt_gst ==""){
	    $gst_percentage ="18";
		}
		
		//$tot_space_cost_discount=intval($space_rate_discount);
		
		//$get_tot_space_cost = intval($space_rate-$space_rate_discount);  // Get the total difference of Space cost Rate - Discount space cost rate

		//$category_rate=$get_tot_space_cost*$categoryINR;
		
		//$premium_rate=intval($get_tot_space_cost*$selected_premium_type);
		
		$sub_total_cost = floatval($space_rate+$category_cost);
		
		$security_deposit=floatval($sub_total_cost*10)/100;
		$govt_service_tax=floatval($sub_total_cost*$gst_percentage)/100;
		$grand_total = round($sub_total_cost+$security_deposit+$govt_service_tax);				
		?>
		<style>.error { color :red;} #message { color :green;}</style>
		<div class="error" role="alert"></div>
		<div class="alert alert-info success-div" role="alert"></div>
		
		<div id="message"></div>
		
		<form onsubmit="return validation()">
		<table id="example" class="display mb-5" cellspacing="0" border="1" width="100%">
        <thead style="font-family:verdana; color:#fff; background-color:#924b77">
            <tr>
				<th></th>
				<th></th>
				<th align="center">Amount</th>
            </tr>
        </thead>       
        <tbody>
            <tr>
                <td align='center'>Area </td>
                <td><?php echo $get_area;?></td>
                <td></td>
            </tr> 
			<tr>
                <td align='center'>Space Cost</td>
                <td><?php echo $charge;?></td>
                <td><?php echo $space_rate;?></td>
            </tr> 		
			
            <tr>
                <td align='center'>Premium Charges</td>
                <td><?php echo $category_per."%";?></td>
                <td><?php echo $category_cost;?></td>
            </tr>             
			<!--<tr>
                <td align='center'>Selected scheme rate</td>
                <td><?php //echo $category_per."%";?></td>
                <td><?php echo $rexh['selected_scheme_rate'];?></td>
            </tr>--> 
			<tr>
                <td align="right">Sub Total</td>
                <td></td>
                <td><?php echo $sub_total_cost;?></td>
            </tr> 
			<tr>
                <td align='center'>10% Sec Dep.</td>
                <td>10%</td>
                <td><?php echo $security_deposit;?></td>
            </tr> 
			<tr>
                <td align='center'>18% GST</td>
                <td><?php echo $gst_percentage;?>%</td>
                <td><?php echo $govt_service_tax;?></td>
            </tr> 
			<tr>
                <td align="right">TOTAL</td>
                <td></td>
                <td><?php echo $grand_total;?></td>
            </tr>
			
			<tr>
                <td align="right">Amount Paid SIGNATURE 2023</td>
                <td></td>
                <td><?php echo $amountPaidFromUTR;?></td>
            </tr> 
			<tr>
                <td align="right">TDS SIGNATURE 2023</td>
                <td></td>
                <td><?php echo $tdsAmount;?></td>
            </tr>
			<tr>
                <td align="right">Total Amount Paid</td>
                <td></td>
                <td><?php echo $totalAmountPaid = $amountPaidFromUTR+$tdsAmount;?></td>
            </tr> 			
            <tr>
                <td align="right"><b>Balance Payment</b></td>
                <td></td>
                <td><b><?php echo $amountUnpaid = $grand_total-$totalAmountPaid;?></b></td>
            </tr> 
			<tr>
                <td align="right">TDS Percentage 0%,2%,10%<span>*</span> </td>
                <td>
				<select class="textField" name="cheque_tds_per" id="cheque_tds_per">
				<option value="">-- Select TDS Percentage --</option>
			     <option value="0">0 %</option>
			     <option value="2">2 %</option>
				 <option value="10">10 %</option>
				</select>				
                <br><label class="error" id="cheque_tds_per_error"></label></td>
                <td><?php if(isset($cheque_tds_per_error)){ echo "<span style='color: red;'>".$cheque_tds_per_error.'</span>';} ?></td>
            </tr> 
			
			<tr>
                <td align="right">TDS Amount <span>*</span> </td>
                <td>

				<input name="cheque_tds_amount" type="text" id="cheque_tds_amount" class="textField" value="<?php echo $cheque_tds_amount;?>" autocomplete="off" onkeyup="return change_amount()"/>
                <br><label class="tds_error" id="cheque_tds_amount_error"></label>
				</td>
                <td><?php if(isset($cheque_tds_amount_error)){ echo "<span style='color: red;'>".$cheque_tds_amount_error.'</span>';} ?></td>
            </tr> 
			
			<tr>
                <td align="right">Net Amount<span>*</span> </td>
                <td>
				<input name="cheque_tds_Netamount" type="text" id="cheque_tds_Netamount" class="textField" readonly	/>
                <br><label class="error" id="cheque_tds_Netamount_error"></label>
				</td>
                <td><?php if(isset($cheque_tds_Netamount_error)){ echo "<span style='color: red;'>".$cheque_tds_Netamount_error.'</span>';} ?></td>
            </tr> 
		</tbody>
		</table>
				<input type="hidden" name="balancePayment" id="balancePayment" value="<?php echo $amountUnpaid;?>">
				<input type="hidden" name="govt_service_tax" id="govt_service_tax" value="<?php echo $govt_service_tax;?>">
				<input type="hidden" name="security_deposit" id="security_deposit" value="<?php echo $security_deposit;?>">
				<input type="hidden" name="sub_total_cost" id="sub_total_cost" value="<?php echo $sub_total_cost;?>">
				<input type="hidden" name="tot_space_cost_rate" id="tot_space_cost_rate" value="<?php echo $space_rate;?>">
				<input type="hidden" name="selected_area" id="selected_area" value="<?php echo $rexh['Exhibitor_Area'];?>">
				<input type="hidden" name="show_type" id="show_type" value="<?php echo $show; ?>">
				<input type="hidden" name="gid" id="gid" value="<?php echo $getgid;?>">	
				<?php if($amountUnpaid>=500){ ?>
				<button class="cta fade_anim d-table mx-auto" id="save" onclick="return savePayment.save()">Click here for Payment</button>
				
		<?php } else { echo '';}?>
        </div>
		<?php } ?>
		
		 <?php		
		if($countx1 > 0 && $countx1!='') { ?>

        <?php if($amountUnpaid<=500){?>
        	<a href="manual_signature/index.php?uid=<?php echo $uid;?>&gid=<?php echo $rexh['Exhibitor_Gid'];?>&section=<?php echo $rexh['Exhibitor_Section'];?>" class="cta btn fade_anim mb-3">Click here to access online Exhibitor Manual</a><br/>
			<?php if($uid=='121148') { ?>
        	<a href="manual_signature/index.php?uid=121148&gid=26192&section=loose_stones" class="cta btn fade_anim " >Click here to access online Exhibitor Manual</a>
			<?php } ?>

			<!-- MEHTA GOLD AND DIAMONDS -->
			<?php if($uid=='214869') { ?>
        	<a href="manual_signature/index.php?uid=214869&gid=30502&section=loose_stones" class="cta btn fade_anim " >Click here to access online Exhibitor Manual</a>
			<?php } ?>
			<!-- MUKTI GOLD PVT. LTD -->
			<?php if($uid=='167') { ?>
        	<a href="manual_signature/index.php?uid=167&gid=30096&section=loose_stones" class="cta btn fade_anim ">Click here to access online Exhibitor Manual</a>
			<?php } ?>
			<!--<a href="javascript: void(0)" onclick = "second_alert()" class="newMaroonBtn">Online Exhibitor Manual</a>-->
            <?php } else { ?>
            <a href="javascript: void(0)" onclick = "balance_alert()" class="cta btn fade_anim" >Online Exhibitor Manual</a>
            <?php } ?>
       
        <?php } ?>
        <div class="clear" style="height:10px;"></div> 
		
		<?php } ?>
		<!-- MEHTA GOLD AND DIAMONDS -->
			<?php
			if($show=="signature"){
			if($uid=='214869' || $uid=='167') { // Mukti gold & MEHTA GOLD AND DIAMONDS  ka ye code karaya h

			 if($uid=='214869'){
			 	$sexh="SELECT manual_signature.iijs_exhibitor.Exhibitor_Gid,manual_signature.iijs_exhibitor.Exhibitor_Registration_ID,manual_signature.iijs_exhibitor.exempt_gst,manual_signature.iijs_exhibitor.Exhibitor_HallNo,manual_signature.iijs_exhibitor.Exhibitor_Section,manual_signature.iijs_exhibitor.Exhibitor_Scheme,manual_signature.iijs_exhibitor.Exhibitor_DivisionNo,manual_signature.iijs_exhibitor.Exhibitor_StallNo1,manual_signature.iijs_exhibitor.Exhibitor_StallNo2,manual_signature.iijs_exhibitor.Exhibitor_StallNo3,manual_signature.iijs_exhibitor.Exhibitor_StallNo4,manual_signature.iijs_exhibitor.Exhibitor_StallNo5,manual_signature.iijs_exhibitor.Exhibitor_StallNo6,manual_signature.iijs_exhibitor.Exhibitor_Area,manual_signature .iijs_exhibitor.Exhibitor_StallType,manual_signature .iijs_exhibitor.Exhibitor_Premium,manual_signature .iijs_exhibitor.amountPaid, manual_signature.iijs_exhibitor.amountUnpaid FROM manual_signature.iijs_exhibitor where manual_signature.iijs_exhibitor.Exhibitor_Registration_ID='$uid' and manual_signature.iijs_exhibitor.Exhibitor_Gid='30502'";

			 }else if($uid=='167'){
			 	$sexh="SELECT manual_signature.iijs_exhibitor.Exhibitor_Gid,manual_signature.iijs_exhibitor.Exhibitor_Registration_ID,manual_signature.iijs_exhibitor.exempt_gst,manual_signature.iijs_exhibitor.Exhibitor_HallNo,manual_signature.iijs_exhibitor.Exhibitor_Section,manual_signature.iijs_exhibitor.Exhibitor_Scheme,manual_signature.iijs_exhibitor.Exhibitor_DivisionNo,manual_signature.iijs_exhibitor.Exhibitor_StallNo1,manual_signature.iijs_exhibitor.Exhibitor_StallNo2,manual_signature.iijs_exhibitor.Exhibitor_StallNo3,manual_signature.iijs_exhibitor.Exhibitor_StallNo4,manual_signature.iijs_exhibitor.Exhibitor_StallNo5,manual_signature.iijs_exhibitor.Exhibitor_StallNo6,manual_signature.iijs_exhibitor.Exhibitor_Area,manual_signature .iijs_exhibitor.Exhibitor_StallType,manual_signature .iijs_exhibitor.Exhibitor_Premium,manual_signature .iijs_exhibitor.amountPaid, manual_signature.iijs_exhibitor.amountUnpaid FROM manual_signature.iijs_exhibitor where manual_signature.iijs_exhibitor.Exhibitor_Registration_ID='$uid' and manual_signature.iijs_exhibitor.Exhibitor_Gid='30096'";
			 }	
            

			 $qexh = $conn2->query($sexh); 
			 $countx1 = $qexh->num_rows;
			 $rexh = $qexh->fetch_assoc();
			 $section=$rexh['Exhibitor_Section'];
			 $scheme=$rexh['Exhibitor_Scheme'];
			 $get_area=$rexh['Exhibitor_Area']; 
			 $allotted_women=0;
			 $exempt_gst=$rexh['exempt_gst'];
			 $category = $rexh['Exhibitor_StallType'];
			 $selected_premium_type=$rexh['Exhibitor_Premium'];
			 $last_yr_participant = $rexh['last_yr_participant'];	

			
		if($countx1 > 0 && $countx1!='') { ?>
		
		<div class="field">
		<style>.error { color :red;} #message { color :green;}</style>
		<div class="error" role="alert"></div>
		<div class="alert alert-info success-div" role="alert"></div>
		
		<div id="message"></div>
        <p><strong style="text-transform:uppercase; font-size:14px;">Payment Status</strong> <br/>		
		<?php
		if(strtoupper($_SESSION['COUNTRY'])=="IN")
		{
			if($section=="plain_gold")
			{
				$charge="22000";
			}
			else if($section=="loose_stones")
			{
				$charge="22000";
			}			
			else if($section=="diamond_colorstone")
			{
				$charge="22000";
			}
			else if($section=="lab_edu")
			{
				$charge="22000";
			}
			else if($section=="lgd" )
			{
				$charge="22000";
			}
			else if($section=="silver")
			{
				$charge="22000";
			} elseif($section=="machinery" || $section=='allied'){
				if($_SESSION['member_type']=='MEMBER')
					$charge="14500";
				else
					$charge="15000";	
			} 
		} else {
			if($section=="International Jewellery")
			{
				$charge="350";
			}
			else if($section=="International Loose")
			{
				$charge="350";
			}
			else if($section=="machinery"){
				$charge="300";
			}
		}
		
		$membership_certificate_type = trim($_SESSION['membership_certificate_type']);	
		$msme_ssi_status = trim($_SESSION['msme_ssi_status']);
		
		$space_rate	=	intval($get_area*$charge);
		
		if($rexh['Exhibitor_Premium']=="premium"){
			$categoryINR=0.15;
			$category_per=15;
		} else {
			if($category=="normal")
			{
				$categoryINR=0;
				$category_per=0;
			}		
			else if($category=="corner_2side")
			{
				$categoryINR=0.01;
				$category_per=10;
			}
			else if($category=="corner_3side")
			{
				$categoryINR=0.01;
				$category_per=10;
			}
			else if($category=="island_4side")
			{
				$categoryINR=0.15;
				$category_per=15;
			}
		}
		
		$category_cost = floatval($space_rate*$category_per)/100;
		
		if($exempt_gst =="1"){
		$gst_percentage ="0";	
		}else if($exempt_gst =="0" || $exempt_gst ==""){
	    $gst_percentage ="18";
		}
		
		//$tot_space_cost_discount=intval($space_rate_discount);
		
		//$get_tot_space_cost = intval($space_rate-$space_rate_discount);  // Get the total difference of Space cost Rate - Discount space cost rate

		//$category_rate=$get_tot_space_cost*$categoryINR;
		
		//$premium_rate=intval($get_tot_space_cost*$selected_premium_type);
		
		$sub_total_cost = floatval($space_rate+$category_cost);
		
		$security_deposit=floatval($sub_total_cost*10)/100;
		$govt_service_tax=floatval($sub_total_cost*$gst_percentage)/100;
		$grand_total = round($sub_total_cost+$security_deposit+$govt_service_tax);				
		?>
		<style>.error { color :red;} #message { color :green;}</style>
		<div class="error" role="alert"></div>
		<div class="alert alert-info success-div" role="alert"></div>
		
		<div id="message"></div>
		
		<form onsubmit="return validation()">
		<table id="example" class="display mb-5" cellspacing="0" border="1" width="100%">
        <thead style="font-family:verdana; color:#fff; background-color:#924b77">
            <tr>
				<th></th>
				<th></th>
				<th align="center">Amount</th>
            </tr>
        </thead>       
        <tbody>
            <tr>
                <td align='center'>Area </td>
                <td><?php echo $get_area;?></td>
                <td></td>
            </tr> 
			<tr>
                <td align='center'>Space Cost</td>
                <td><?php echo $charge;?></td>
                <td><?php echo $space_rate;?></td>
            </tr> 		
			
            <tr>
                <td align='center'>Premium Charges</td>
                <td><?php echo $category_per."%";?></td>
                <td><?php echo $category_cost;?></td>
            </tr>             
			<!--<tr>
                <td align='center'>Selected scheme rate</td>
                <td><?php //echo $category_per."%";?></td>
                <td><?php echo $rexh['selected_scheme_rate'];?></td>
            </tr>--> 
			<tr>
                <td align="right">Sub Total</td>
                <td></td>
                <td><?php echo $sub_total_cost;?></td>
            </tr> 
			<tr>
                <td align='center'>10% Sec Dep.</td>
                <td>10%</td>
                <td><?php echo $security_deposit;?></td>
            </tr> 
			<tr>
                <td align='center'>18% GST</td>
                <td><?php echo $gst_percentage;?>%</td>
                <td><?php echo $govt_service_tax;?></td>
            </tr> 
			<tr>
                <td align="right">TOTAL</td>
                <td></td>
                <td><?php echo $grand_total;?></td>
            </tr>
			
			<tr>
                <td align="right">Amount Paid SIGNATURE 2023</td>
                <td></td>
                <td><?php echo $amountPaidFromUTR;?></td>
            </tr> 
			<tr>
                <td align="right">TDS SIGNATURE 2023</td>
                <td></td>
                <td><?php echo $tdsAmount;?></td>
            </tr>
			<tr>
                <td align="right">Total Amount Paid</td>
                <td></td>
                <td><?php echo $totalAmountPaid = $amountPaidFromUTR+$tdsAmount;?></td>
            </tr> 			
            <tr>
                <td align="right"><b>Balance Payment</b></td>
                <td></td>
                <td><b><?php echo $amountUnpaid = $grand_total-$totalAmountPaid;?></b></td>
            </tr> 
			<tr>
                <td align="right">TDS Percentage 0%,2%,10%<span>*</span> </td>
                <td>
				<select class="textField" name="cheque_tds_per" id="cheque_tds_per">
				<option value="">-- Select TDS Percentage --</option>
			     <option value="0">0 %</option>
			     <option value="2">2 %</option>
				 <option value="10">10 %</option>
				</select>				
                <br><label class="error" id="cheque_tds_per_error"></label></td>
                <td><?php if(isset($cheque_tds_per_error)){ echo "<span style='color: red;'>".$cheque_tds_per_error.'</span>';} ?></td>
            </tr> 
			
			<tr>
                <td align="right">TDS Amount <span>*</span> </td>
                <td>

				<input name="cheque_tds_amount" type="text" id="cheque_tds_amount" class="textField" value="<?php echo $cheque_tds_amount;?>" autocomplete="off" onkeyup="return change_amount()"/>
                <br><label class="tds_error" id="cheque_tds_amount_error"></label>
				</td>
                <td><?php if(isset($cheque_tds_amount_error)){ echo "<span style='color: red;'>".$cheque_tds_amount_error.'</span>';} ?></td>
            </tr> 
			
			<tr>
                <td align="right">Net Amount<span>*</span> </td>
                <td>
				<input name="cheque_tds_Netamount" type="text" id="cheque_tds_Netamount" class="textField" readonly	/>
                <br><label class="error" id="cheque_tds_Netamount_error"></label>
				</td>
                <td><?php if(isset($cheque_tds_Netamount_error)){ echo "<span style='color: red;'>".$cheque_tds_Netamount_error.'</span>';} ?></td>
            </tr> 
		</tbody>
		</table>
				<input type="hidden" name="balancePayment" id="balancePayment" value="<?php echo $amountUnpaid;?>">
				<input type="hidden" name="govt_service_tax" id="govt_service_tax" value="<?php echo $govt_service_tax;?>">
				<input type="hidden" name="security_deposit" id="security_deposit" value="<?php echo $security_deposit;?>">
				<input type="hidden" name="sub_total_cost" id="sub_total_cost" value="<?php echo $sub_total_cost;?>">
				<input type="hidden" name="tot_space_cost_rate" id="tot_space_cost_rate" value="<?php echo $space_rate;?>">
				<input type="hidden" name="selected_area" id="selected_area" value="<?php echo $rexh['Exhibitor_Area'];?>">
				<input type="hidden" name="show_type" id="show_type" value="<?php echo $show; ?>">
				<input type="hidden" name="gid" id="gid" value="<?php echo $getgid;?>">	
				
        </div>
		<?php } ?>
		<?php } }?>
		
		
        <div class="clear" style="height:10px;"></div>
		

	<?php
	if($show=="tritiya"){
     	$shows = "IIJS TRITIYA 2023";
		  $sql_signature ="select * from exh_registration where uid='$uid' AND `show`='IIJS TRITIYA 2023' order by gid desc";
		$query_signature = $conn->query($sql_signature);		
		$num1=$query_signature->num_rows;	
		{
			while ($result_signature = $query_signature->fetch_assoc())
			{	
				if($result_signature['event_selected']=="iijstritiya23"){ $event_for="IIJS TRITIYA 2023"; $event_show = "IIJS TRITIYA 2023";} 
				$category=$result_signature['category'];
				if($category=="normal")
					$category_rate=0;
				else if($category=="corner_2side")
					$category_rate=5;
				else if($category=="corner_3side")
					$category_rate=10;
				else if($category=="island_4side")
					$category_rate=15;
					
				$category_cost=$result_signature['get_tot_space_cost_rate']*$category_rate/100;
				?>
				<button class="accordion">Click here to view Application Summary for <?php echo $event_show;?>(Exh<?php echo $result_signature['gid'];?>)</button>

				<div class="panel">
				<div class="clear"></div>

				<p><strong style="text-transform:uppercase; font-size:14px; padding-top: 15px">Application <?php //echo $result_signature['section'];?> on <?php echo date('jS F Y',strtotime($result_signature['created_date']));?></strong></p>
					<div class="summary_box">		
					<p><strong style="text-transform:uppercase; font-size:14px;">Application Summary</strong> <br />
					<span class="clear" style="height:1px; background:#ccc; display:block;"></span>
					<strong>Last Year Participant :</strong>&nbsp; <?php echo $result_signature['last_yr_participant'];?> <br />
					<strong>Option :</strong>&nbsp; <?php echo $result_signature['options'];?> <br />
					<strong>Section :</strong>&nbsp; <?php echo getSection_description($result_signature['section'],$conn);?> <br />
					<strong>Category :</strong>&nbsp; <?php echo strtoupper($result_signature['category']);?> <br />
					<strong>Area :</strong>&nbsp; <?php echo $result_signature['selected_area'];?> &nbsp;sqrt<br />
					<strong>Scheme :</strong>&nbsp; <?php echo getSchemeDescription_signature($result_signature['selected_scheme_type'],$conn);?> <br />
					<!--<strong>Premium :</strong>&nbsp; <?php echo $result_signature['selected_premium_type'];?>--></p>
					</div>
					
					<div class="summary_box">
					<p><strong style="text-transform:uppercase; font-size:14px;">Application Payment Summary</strong> <br />
					<span class="clear" style="height:1px; background:#ccc; display:block;"></span>
					<strong>Space Cost <?php echo $currency;?> :</strong>&nbsp; <?php echo $result_signature['tot_space_cost_rate'];?> <br />
					<strong>Category Cost <?php echo $currency;?> :</strong>&nbsp; <?php echo $result_signature['get_category_rate'];?> <br />
					<!--<strong>Space Cost Discount <?php echo $currency;?> :</strong>&nbsp; <?php echo $result_signature['tot_space_cost_discount'];?> <br />
					<strong>Space cost after Incentive<?php echo $currency;?> :</strong>&nbsp; <?php echo $result_signature['incentive_value'];?> <br />
					<strong>After Discount Space Cost<?php echo $currency;?> :</strong>&nbsp; <?php echo $result_signature['get_tot_space_cost_rate'];?> <br />-->
					
					<!--<strong>Category cost INR <?php echo $currency;?> :</strong>&nbsp; <?php echo $category_cost;?> <br />
					<strong>Selected scheme rate <?php echo $currency;?> :</strong>&nbsp; <?php echo $result_signature['selected_scheme_rate'];?> <br />
					<strong>Selected premium rate <?php echo $currency;?> :</strong>&nbsp; <?php echo $result_signature['selected_premium_rate'];?> <br />-->
					<strong>Sub Total <?php echo $currency;?> :</strong>&nbsp; <?php echo $result_signature['sub_total_cost'];?> <br />
					<strong>Security Deposit (10% on Sub Total) <?php echo $currency;?> :</strong>&nbsp; <?php echo $result_signature['security_deposit'];?> <br />
					<strong>GST (18% on Sub Total) <?php echo $currency;?> :</strong>&nbsp; <?php echo $result_signature['govt_service_tax'];?><br />
					<strong>Grand Total <?php echo $currency;?> :</strong>&nbsp; <?php echo $result_signature['grand_total'];?></p>
					</div>
					
					<div class="clear" style="height:10px;"></div>
					<?php 
					$query1=$conn->query("select * from exh_reg_payment_details where uid='$uid' AND `show`='IIJS TRITIYA 2023' order by payment_id desc limit 0,1");
					$result1=$query1->fetch_assoc();		
					?>        
					<p><strong style="text-transform:uppercase; font-size:14px;">Application Status </strong> <br />
					<span class="clear" style="height:1px; background:#ccc; display:block;"></span>
					<div style="height:10px; display:block; padding:10px;">
					<!--<div style="margin-right:50px; float:left; width: 212px;">
					<strong >Manual Application Status<?php echo $currency;?> :</strong>&nbsp; <?php echo $result1['application_status'];?></div> -->
					<div style="margin-right:50px; float:left; width: 212px;"> <strong>Application Status<?php echo $currency;?> :</strong>&nbsp; <?php echo $result1['document_status'];?>  </div>        
					<div style="margin-right:50px; float:left; width: 212px;">
					<strong>Payment  Status<?php echo $currency;?> :</strong>&nbsp; <?php echo $result1['payment_status'];?>  </div>
					</div>     
				</div>       	
				<?php 
			}
		}
		
		/* 25% Payment for Tritiya only */
		$checkPartPayment = "SELECT id FROM `utr_history` WHERE registration_id='$uid' AND `show`='IIJS TRITIYA 2023' AND payment_made_for='PART' AND payment_status='captured'";
		$partResultPayment = $conn->query($checkPartPayment);
		$partCountx = $partResultPayment->num_rows;		
		if($partCountx==0)
		{
			
		$utrExistPayment = "SELECT * FROM `utr_history` WHERE registration_id='$uid' AND `show`='IIJS TRITIYA 2023' AND payment_made_for='SPACE' AND payment_status='captured'";
		$existResultPayment = $conn->query($utrExistPayment);
		if($existResultPayment){			
		
		$getTritiyaData ="select * from exh_registration where uid='$uid' AND `show`='IIJS TRITIYA 2023' order by gid desc";
		$tritiyaResult = $conn->query($getTritiyaData);
		$tritiyaRowx = $tritiyaResult->fetch_assoc();
		//echo '<pre>'; print_r($tritiyaRowx);
		
		$utrPaidAmount = "SELECT sum(amountPaid) as `amountPaid`,sum(cheque_tds_amount) as `cheque_tds_amount` FROM `utr_history` WHERE registration_id='$uid' AND `show`='IIJS TRITIYA 2023' AND  payment_made_for='SPACE' AND payment_status='captured'";
		$existPaidResult = $conn->query($utrPaidAmount);	
		while($utrPaid = $existPaidResult->fetch_assoc())
		{				
			$amountPaid = $utrPaid['amountPaid'];
			$cheque_tds_amount = $utrPaid['cheque_tds_amount'];
		}
		?>	
		<style>.error { color :red;} #message { color :green;}</style>
		<div class="error" role="alert"></div>
		<div class="alert alert-info success-div" role="alert"></div>
		
		<div id="message"></div>
		
		<form onsubmit="return validation()">
        <table id="example" class="display" cellspacing="0" border="1" width="100%">
        <thead style="font-family:verdana; color:#fff; background-color:#924b77">
            <tr>
				<th></th>
				<th></th>
				<th align="center">Amount</th>
            </tr>
        </thead>       
        <tbody>
            <tr>
                <td align='center'>Area </td>
                <td><?php echo $tritiyaRowx['selected_area'];?></td>
                <td></td>
            </tr> 
			<tr>
                <td align='center'>Space Cost</td>
                <td></td>
                <td><?php echo $tritiyaRowx['tot_space_cost_rate'];?></td>
            </tr>			
			<tr>
                <td align="right">TOTAL</td>
                <td></td>
                <td><?php echo $tritiyaRowx['sub_total_cost'];?></td>
            </tr> 
			<tr>
                <td align='center'>Security Deposit (10% on Sub Total) </td>
                <td>10%</td>
                <td><?php echo $tritiyaRowx['security_deposit'];?></td>
            </tr> 
			<tr>
                <td align='center'>GST (18% on Sub Total)</td>
                <td>18%</td>
				<td><?php echo $tritiyaRowx['govt_service_tax'];?></td>
            </tr> 
			<tr>
                <td align="right">TOTAL</td>
                <td></td>
				<td><?php echo $tritiyaRowx['grand_total'];?></td>
            </tr> 
			<tr>
                <td align="right">Total Amount Paid</td>
                <td></td>
				<td><?php echo $amountPaid;?></td>
            </tr> 
            <tr>
                <td align="right">Total TDS Paid</td>
                <td></td>
				<td><?php echo $cheque_tds_amount;?></td>
            </tr> 
			<tr>
                <td align="right">Balance Payment</td>
                <td></td>
                <td><?php echo $amountUnpaid = $tritiyaRowx['grand_total']-($amountPaid+$cheque_tds_amount);?></td>
            </tr> 
			
			<tr>
                <td align="right">Pay Part Balance Payment Percentage 25%<span>*</span> </td>
                <td>
				<select class="textField" name="payment_percentage" id="payment_percentage">
				<option value="">-- Select Part Payment Percentage --</option>
			     <option value="25">25 %</option>
				</select>				
                <br><label class="payment_percentage_error"></label></td>
                <td><input name="net_payable_amount" id="net_payable_amount" type="text" class="textField" 
			<?php if(!empty($net_payable_amount)){ ?> value="<?php echo $net_payable_amount;?>" <?php } ?> readonly/> </td>
            </tr> 
			
			<tr>
                <td align="right">TDS Percentage 0%,2%,10%<span>*</span> </td>
                <td>
				<select class="textField" name="cheque_tds_part_per" id="cheque_tds_part_per">
				<option value="">-- Select TDS Percentage --</option>
			     <option value="0">0 %</option>
			     <option value="2">2 %</option>
				 <option value="10">10 %</option>
				</select><br/>
				<span style='color: red;'><label class="cheque_tds_per_error"></label></span>
                </td>
                <td></td>
            </tr> 
			
			<tr>
                <td align="right">TDS Amount <span>*</span> </td>
                <td>
				<input name="cheque_tds_amount" type="text" id="cheque_tds_amount" class="textField" value="" autocomplete="off" onkeyup="return change_PartAmount()"/>
                <br>
				<span style='color: red;'><label class="cheque_tds_amount_error"></label></span>
				</td>
                <td></td>
            </tr> 
			
			<tr>
                <td align="right">Net Amount<span>*</span> </td>
                <td>
				<input name="cheque_tds_Netamount" type="text" id="cheque_tds_Netamount" class="textField" readonly	/>
                <br><label class="error" id="cheque_tds_Netamount_error"></label>
				</td>
                <td><?php if(isset($cheque_tds_Netamount_error)){ echo "<span style='color: red;'>".$cheque_tds_Netamount_error.'</span>';} ?></td>
            </tr> 
								
		</tbody>
		</table>
		<input type="hidden" name="balancePayment" id="balancePayment" value="<?php echo $amountUnpaid;?>">
		<input type="hidden" name="govt_service_tax" id="govt_service_tax" value="<?php echo $tritiyaRowx['govt_service_tax'];?>">
		<input type="hidden" name="security_deposit" id="security_deposit" value="<?php echo $tritiyaRowx['security_deposit'];?>">
		<input type="hidden" name="sub_total_cost" id="sub_total_cost" value="<?php echo $tritiyaRowx['sub_total_cost'];?>">
		<input type="hidden" name="tot_space_cost_rate" id="tot_space_cost_rate" value="<?php echo $tritiyaRowx['tot_space_cost_rate'];?>">
		<input type="hidden" name="selected_area" id="selected_area" value="<?php echo $tritiyaRowx['selected_area'];?>">
		<input type="hidden" name="show_type" id="show_type" value="<?php echo $show;?>">
		<input type="hidden" name="gid" id="gid" value="<?php echo $tritiyaRowx['gid'];?>">
		<input type="hidden" name="grand_total" id="grand_total" value="<?php echo round($tritiyaRowx['grand_total']);?>"/>
		<?php 
		if($amountUnpaid>=500){ ?>
		<button class="cta fade_anim d-table mx-auto" id="savePart" onclick="return savePartPayment.savePart()">Click here for Payment</button>
		<?php } else { echo '---'; } ?>
		</form>
		<?php
		
			
		} else { 
			echo 'Payment Pending';
		}
		
		} else { 
			echo 'Part Payment is done';
		}
				 
				 
	} ?>



		<!--- 23 NOV 2021 --->		
     
	  
	
    <?php
	if($show=="igjme")
	{
		$shows = "IGJME";
    $sql_igjme ="select * from exh_registration where uid='$uid' AND curr_last_yr_check='Y' AND `show`='IGJME' order by gid desc";
    $query_igjme = $conn->query($sql_igjme);		
	$igjmeCountx = $query_igjme->num_rows;		
    if($igjmeCountx>0)
	{
    while ($result_igjme = $query_igjme->fetch_assoc())
	{
	if($result_igjme['event_selected']=="igjme"){ $event_for="IGJME 2023"; $event_show = "IGJME 2023";} 
	$category=$result_igjme['category'];
	if($category=="normal")
		$category_rate=0;
	else if($category=="corner_2side")
		$category_rate=5;
	else if($category=="corner_3side")
		$category_rate=10;
	else if($category=="island_4side")
		$category_rate=15;
		
		$category_cost=$result_igjme['get_tot_space_cost_rate']*$category_rate/100;
	?>
    <button class="accordion">Click here to view Application Summary for <?php echo $event_show;?>(Exh<?php echo $result_igjme['gid'];?>)</button>
	
	<div class="panel">
	<div class="clear"></div>

	<p><strong style="text-transform:uppercase; font-size:14px; padding-top: 15px">Application <?php //echo $result_igjme['section'];?> on <?php echo date('jS F Y',strtotime($result_igjme['created_date']));?></strong></p>
        <div class="summary_box">		
        <p><strong style="text-transform:uppercase; font-size:14px;">Application Summary</strong> <br />
        <span class="clear" style="height:1px; background:#ccc; display:block;"></span>
        <strong>Last Year Participant :</strong>&nbsp; <?php echo $result_igjme['last_yr_participant'];?> <br />
        <!--<strong>Option :</strong>&nbsp; <?php echo $result_igjme['options'];?> <br />
        <strong>Section :</strong>&nbsp; <?php echo getSection_description($result_igjme['section'],$conn);?> <br />
        <strong>Category :</strong>&nbsp; <?php echo strtoupper($result_igjme['category']);?> <br />-->
        <strong>Area :</strong>&nbsp; <?php echo $result_igjme['selected_area'];?> &nbsp;sqrt<br />
        <strong>Scheme :</strong>&nbsp; <?php echo getSchemeDescription_signature($result_igjme['selected_scheme_type'],$conn);?> <br />
        <strong>Premium :</strong>&nbsp; <?php echo $result_igjme['selected_premium_type'];?></p>
        </div>
        
		<div class="summary_box">
        <p><strong style="text-transform:uppercase; font-size:14px;">Application Payment Summary</strong> <br />
        <span class="clear" style="height:1px; background:#ccc; display:block;"></span>
        <strong>Space Cost <?php echo $currency;?> :</strong>&nbsp; <?php echo $result_igjme['tot_space_cost_rate'];?> <br />
        <strong>Category Cost <?php echo $currency;?> :</strong>&nbsp; <?php echo $result_igjme['get_category_rate'];?> <br />
        <!--<strong>Space Cost Discount <?php echo $currency;?> :</strong>&nbsp; <?php echo $result_igjme['tot_space_cost_discount'];?> <br />
		<strong>Space cost after Incentive<?php echo $currency;?> :</strong>&nbsp; <?php echo $result_igjme['incentive_value'];?> <br />
        <strong>After Discount Space Cost<?php echo $currency;?> :</strong>&nbsp; <?php echo $result_igjme['get_tot_space_cost_rate'];?> <br />-->
        
        <!--<strong>Category cost INR <?php echo $currency;?> :</strong>&nbsp; <?php echo $category_cost;?> <br />
        <strong>Selected scheme rate <?php echo $currency;?> :</strong>&nbsp; <?php echo $result_igjme['selected_scheme_rate'];?> <br />
        <strong>Selected premium rate <?php echo $currency;?> :</strong>&nbsp; <?php echo $result_igjme['selected_premium_rate'];?> <br />-->
        <strong>Sub Total <?php echo $currency;?> :</strong>&nbsp; <?php echo $result_igjme['sub_total_cost'];?> <br />
        <strong>Security Deposit (10% on Sub Total) <?php echo $currency;?> :</strong>&nbsp; <?php echo $result_igjme['security_deposit'];?> <br />
        <strong>GST (18% on Sub Total) <?php echo $currency;?> :</strong>&nbsp; <?php echo $result_igjme['govt_service_tax'];?><br />
        <strong>Grand Total <?php echo $currency;?> :</strong>&nbsp; <?php echo $result_igjme['grand_total'];?></p>
        </div>
		
		<div class="clear" style="height:10px;"></div>
		<?php 
		$query1=$conn->query("select * from exh_reg_payment_details where uid='$uid' AND `show`='IGJME' order by payment_id desc limit 0,1");
		$result1=$query1->fetch_assoc();		
		?>        
        <p><strong style="text-transform:uppercase; font-size:14px;">Application Status </strong> <br />
        <span class="clear" style="height:1px; background:#ccc; display:block;"></span>
        <div style="height:10px; display:block; padding:10px;">
		<!--<div style="margin-right:50px; float:left; width: 212px;">
        <strong >Manual Application Status<?php echo $currency;?> :</strong>&nbsp; <?php echo $result1['application_status'];?></div> -->
        <div style="margin-right:50px; float:left; width: 212px;"> <strong>Application Status<?php echo $currency;?> :</strong>&nbsp; <?php echo $result1['document_status'];?>  </div>        
        <div style="margin-right:50px; float:left; width: 212px;">
        <strong>Payment  Status<?php echo $currency;?> :</strong>&nbsp; <?php echo $result1['payment_status'];?>  </div>
		</div>     
	</div>       	
      <?php
      }
	  }
	  
	  
	  /*..................................Get UTR DETAIL Start.....................................*/
			
			$utrExist = "SELECT sum(amountPaid) as `amountPaid`,sum(tdsAmount) as `tdsAmount` FROM `utr_history` WHERE registration_id='$uid' AND `show`='$shows' AND payment_status='captured'";
			$existResult = $conn->query($utrExist);	
							
				while($printutr = $existResult->fetch_assoc())
				{				
					$amountPaid = $printutr['amountPaid'];
					$tdsAmountUTR = $printutr['tdsAmount'];
				}
				
				function getSpaceTDSAmount($uid,$conn)
				{
					$query_sel = "select cheque_tds_amount from exh_reg_payment_details where uid='$uid' AND `show`='IGJME' AND event_selected='igjme23' limit 0,1";
					$result_sel = $conn->query($query_sel);								
					$row = $result_sel->fetch_assoc();								
					return $row['cheque_tds_amount'];							
				}
				
				$tds_amount = getSpaceTDSAmount($uid,$conn) + $tdsAmountUTR;
				
				$tdsAmount = $tds_amount; 
				
				$getSql_igjme ="select * from exh_registration where uid='$uid' AND curr_last_yr_check='Y' AND `show`='$shows' order by gid desc";
				$getQuery_igjme = $conn->query($getSql_igjme);	
				$getResult_igjme = $getQuery_igjme->fetch_assoc();
				$getgid = $getResult_igjme['gid'];
		
				$host = "192.168.40.107";
				$user = "appadmin";
				$password = "G@k593#sgtk";
				$dbname = "manual_signature";

                // Create connection
                $conn2 = new mysqli($host, $user, $password, $dbname);
                // Check connection
                if($conn2->connect_error) {
                    die("Connection failed: " . $conn2->connect_error);
                } else {
                    
                }
			
			 $sexh="SELECT manual_signature.iijs_exhibitor.Exhibitor_Gid,manual_signature.iijs_exhibitor.Exhibitor_Registration_ID,manual_signature.iijs_exhibitor.exempt_gst,manual_signature.iijs_exhibitor.Exhibitor_HallNo,manual_signature.iijs_exhibitor.Exhibitor_Section,manual_signature.iijs_exhibitor.Exhibitor_Scheme,manual_signature.iijs_exhibitor.Exhibitor_DivisionNo,manual_signature.iijs_exhibitor.Exhibitor_StallNo1,manual_signature.iijs_exhibitor.Exhibitor_StallNo2,manual_signature.iijs_exhibitor.Exhibitor_StallNo3,manual_signature.iijs_exhibitor.Exhibitor_StallNo4,manual_signature.iijs_exhibitor.Exhibitor_StallNo5,manual_signature.iijs_exhibitor.Exhibitor_StallNo6,manual_signature.iijs_exhibitor.Exhibitor_Area,manual_signature .iijs_exhibitor.Exhibitor_StallType,manual_signature .iijs_exhibitor.Exhibitor_Premium,manual_signature .iijs_exhibitor.amountPaid, manual_signature.iijs_exhibitor.amountUnpaid FROM manual_signature.iijs_exhibitor where manual_signature.iijs_exhibitor.Exhibitor_Registration_ID='$uid' and manual_signature.iijs_exhibitor.Exhibitor_Gid='$getgid'";
			
			/*	$sexh ="select * from exh_registration where uid='$uid' AND curr_last_yr_check='Y' AND `show`='IIJS 2021' order by gid desc"; 
			$qexh = $conn->query($sexh);  */
			
			$qexh = $conn2->query($sexh); 
			$countx = $qexh->num_rows;
			$rexh = $qexh->fetch_assoc();
			
			 $section=$rexh['Exhibitor_Section'];
			 $scheme=$rexh['Exhibitor_Scheme'];
			 $get_area=$rexh['Exhibitor_Area'];
			$allotted_women=$rexh['allotted_women'];
			 $exempt_gst=$rexh['exempt_gst'];
			 $category=$rexh['Exhibitor_StallType'];
			 $selected_premium_type=$rexh['Exhibitor_Premium'];	
			 $last_yr_participant = $rexh['last_yr_participant'];	
		
			if($countx > 0 && $countx!='') { ?>
			<div class="field">
			<style>.error { color :red;} #message { color :green;}</style>
			<div class="error" role="alert"></div>
			<div class="alert alert-info success-div" role="alert"></div>
			
			<div id="message"></div>
			<p><strong style="text-transform:uppercase; font-size:14px;">Payment Status</strong> <br/>		
		
		<?php
		if(strtoupper($_SESSION['COUNTRY'])=="IN")
		{
			if($section=="plain_gold" && $allotted_women =="0")
			{
				$charge="22000";
			}
			else if($section=="loose_stones" && $allotted_women =="0")
			{
				$charge="22000";
			}
			else if($section=="lab_edu" && $allotted_women =="0")
			{
				$charge="22000";
			}
			else if($section=="diamond_colorstone" && $allotted_women =="0")
			{
				$charge="22000";
			}
			else if($section=="silver" && $allotted_women =="0")
			{
				$charge="22000";
			}
			
			if($section=="plain_gold" && $allotted_women =="1")
			{
				$charge="16500";
			}
			else if($section=="loose_stones" && $allotted_women =="1")
			{
				$charge="16500";
			}
			else if($section=="lab_edu" && $allotted_women =="1")
			{
				$charge="16500";
			}
			else if($section=="diamond_colorstone" && $allotted_women =="1")
			{
				$charge="16500";
			}
			else if($section=="silver" && $allotted_women =="1")
			{
				$charge="16500";
			}
			elseif($section=="machinery" || $section=='allied'){
				if($_SESSION['member_type']=='MEMBER')
					$charge="14500";
				else
					$charge="15000";	
			}
			
		} else {
			if($section=="International Jewellery")
			{
				$charge="350";
			}
			else if($section=="International Loose")
			{
				$charge="350";
			}
			elseif($section=="machinery"){
				$charge="300";
			}
		}
		
		$membership_certificate_type = trim($_SESSION['membership_certificate_type']);	
		$msme_ssi_status = trim($_SESSION['msme_ssi_status']);
		$space_rate	=	intval($get_area*$charge);
			
		if($selected_premium_type=="normal")
		{
			$selected_premium_type=0;
			$selected_premium_per="0%";
		}		
		else if($selected_premium_type=="premium")
		{
			$selected_premium_type=0.05;
			$selected_premium_per="5%";
		}
		
		if($rexh['Exhibitor_Premium']=="premium"){
			$categoryINR=0.25;
			$category_per=25;
		} else {
			if($category=="normal")
			{
				$categoryINR=0;
				$category_per=0;
			}		
			else if($category=="corner_2side")
			{
				$categoryINR=0.1;
				$category_per=10;
			}
			else if($category=="corner_3side")
			{
				$categoryINR=0.1;
				$category_per=10;
			}
			else if($category=="island_4side")
			{
				$categoryINR=0.15;
				$category_per=15;
			}
		}
				
		if($exempt_gst =="1"){
		$gst_percentage ="0";	
		}else if($exempt_gst =="0" || $exempt_gst ==""){
	    $gst_percentage ="18";
		} 
		
		$category_cost = floatval($space_rate*$category_per)/100;
		
		/*
		// $tot_space_cost_discount=intval($space_rate_discount);
		// $get_tot_space_cost = intval($space_rate-$space_rate_discount);  // Get the total difference of Space cost Rate - Discount space cost rate

		// $category_rate=$get_tot_space_cost*$categoryINR;
		
		// $premium_rate=intval($get_tot_space_cost*$selected_premium_type);
		
		// $sub_total_cost = floatval($get_tot_space_cost+$category_rate+$premium_rate);
		
		//echo $get_area .'---'.$charge;
		$category_rate = $space_rate*$categoryINR;
		
		$premium_rate = intval($space_rate*$selected_premium_type);
		*/
		$sub_total_cost = floatval($space_rate+$category_cost);
		
		//	$sub_total_cost = floatval($space_rate);
		$security_deposit = floatval($sub_total_cost*10)/100;
		$govt_service_tax = floatval($sub_total_cost*$gst_percentage)/100;
		$grand_total = round($sub_total_cost+$security_deposit+$govt_service_tax);				
		?>
		
		<form onsubmit="return validation()">
        <table id="example" class="display" cellspacing="0" border="1" width="100%">
        <thead style="font-family:verdana; color:#fff; background-color:#924b77">
            <tr>
				<th></th>
				<th></th>
				<th align="center">Amount</th>
            </tr>
        </thead>       
        <tbody>
            <tr>
                <td align='center'>Area </td>
                <td><?php echo $rexh['Exhibitor_Area'];?></td>
                <td></td>
            </tr> 
			<tr>
                <td align='center'>Space Cost</td>
                <td><?php echo $charge;?></td>
                <td><?php echo $space_rate;?></td>
            </tr> 
			<!--<tr>
                <td align='center'>Discount Space Cost Rate</td>
                <td><?php echo $space_rate_discount_per;?></td>
                <td><?php echo $space_rate_discount;?></td>
            </tr>
			<tr>
                <td align='center'>After Discount Space Cost</td>
                <td></td>
                <td><?php echo $get_tot_space_cost;?></td>
            </tr>
            <tr>
                <td align='center'>Premium</td>
                <td><?php echo $selected_premium_per;?></td>
                <td><?php echo $premium_rate;?></td>
            </tr>-->             
			<tr>
                <td align='center'>Premium</td>
                <td><?php echo $category_per."%";?></td>
                <td><?php echo $category_rate;?></td>
            </tr> 
			<tr>
                <td align="right">TOTAL</td>
                <td></td>
                <td><?php echo $sub_total_cost;?></td>
            </tr> 
			<tr>
                <td align='center'>10% Sec Dep.</td>
                <td>10%</td>
                <td><?php echo $security_deposit;?></td>
            </tr> 
			<tr>
                <td align='center'>18% GST</td>
                <td><?php echo $gst_percentage;?>%</td>
                <td><?php echo $govt_service_tax;?></td>
            </tr> 
			<tr>
                <td align="right">TOTAL</td>
                <td></td>
                <td><?php echo $grand_total;?></td>
            </tr> 
			<tr>
                <td align="right">Total Amount Paid</td>
                <td></td>
                <td><?php echo $amountPaid;?></td>
            </tr> 
            <tr>
                <td align="right">Total TDS Paid</td>
                <td></td>
                <td><?php echo $tdsAmount;?></td>
            </tr> 
			<tr>
                <td align="right">Balance Payment</td>
                <td></td>
                <td><?php echo $amountUnpaid = $grand_total-($amountPaid+$tdsAmount);?></td>
            </tr> 
			
			<tr>
                <td align="right">TDS Percentage 0%,2%,10%<span>*</span> </td>
                <td>
				<select class="textField" name="cheque_tds_per" id="cheque_tds_per">
				<option value="">-- Select TDS Percentage --</option>
			     <option value="0">0 %</option>
			     <option value="2">2 %</option>
				 <option value="10">10 %</option>
				</select>				
                <br><label class="error" id="cheque_tds_per_error"></label></td>
                <td><?php if(isset($cheque_tds_per_error)){ echo "<span style='color: red;'>".$cheque_tds_per_error.'</span>';} ?></td>
            </tr> 
			
			<tr>
                <td align="right">TDS Amount <span>*</span> </td>
                <td>

				<input name="cheque_tds_amount" type="text" id="cheque_tds_amount" class="textField" value="<?php echo $cheque_tds_amount;?>" autocomplete="off" onkeyup="return change_amount()"/>
                <br><label class="tds_error" id="cheque_tds_amount_error"></label>
				</td>
                <td><?php if(isset($cheque_tds_amount_error)){ echo "<span style='color: red;'>".$cheque_tds_amount_error.'</span>';} ?></td>
            </tr> 
			
			<tr>
                <td align="right">Net Amount<span>*</span> </td>
                <td>
				<input name="cheque_tds_Netamount" type="text" id="cheque_tds_Netamount" class="textField" readonly	/>
                <br><label class="error" id="cheque_tds_Netamount_error"></label>
				</td>
                <td><?php if(isset($cheque_tds_Netamount_error)){ echo "<span style='color: red;'>".$cheque_tds_Netamount_error.'</span>';} ?></td>
            </tr> 
								
		</tbody>
		</table>
		<input type="hidden" name="balancePayment" id="balancePayment" value="<?php echo $amountUnpaid;?>">
		<input type="hidden" name="govt_service_tax" id="govt_service_tax" value="<?php echo $govt_service_tax;?>">
		<input type="hidden" name="security_deposit" id="security_deposit" value="<?php echo $security_deposit;?>">
		<input type="hidden" name="sub_total_cost" id="sub_total_cost" value="<?php echo $sub_total_cost;?>">
		<input type="hidden" name="tot_space_cost_rate" id="tot_space_cost_rate" value="<?php echo $space_rate;?>">
		<input type="hidden" name="selected_area" id="selected_area" value="<?php echo $rexh['Exhibitor_Area'];?>">
		<input type="hidden" name="show_type" id="show_type" value="<?php echo $show; ?>">
		<input type="hidden" name="gid" id="gid" value="<?php echo $getgid;?>">
		  <?php if($amountUnpaid>=500){ ?>
		<button class="btn mt-3 cta fade_anim d-table mx-auto" id="save" onclick="return savePayment.save()">Click here for Payment</button>
		<?php } else { echo '---';}?>
		</form>		
        </div>
		<?php } ?>
		
        <div class="clear" style="height:10px;"></div>
		
		<!--  23 DEC 2016  ----->		
        <?php 		
		if($countx > 0 && $countx!='') { ?>
			<div class="row">
        	<div class="col-12 mt-2">
        		<?php 
           $signature_exh_area = $rexh['Exhibitor_Area'];
           $visitor_type = "exhibitor";
           $plant_rate = 155;
           $visitor_id = 0;
           $registration_id = $uid;
           include ('include_plant_registration.php');

        ?>
        	</div>
        	
        </div>
        
        <?php if($amountUnpaid<=500){?>
        	<a href="manual_signature/index.php?uid=<?php echo $uid;?>&gid=<?php echo $getgid;?>&section=<?php echo $rexh['Exhibitor_Section'];?>" class="cta fade_anim d-table mx-auto">Online Exhibitor Manual</a>
			<!--<a href="javascript: void(0)" onclick = "second_alert()" class="newMaroonBtn">Online Exhibitor Manuals</a>-->
            <?php } else { ?>
            <a href="javascript: void(0)" onclick = "balance_alert()" class='cta btn fade_anim d-table mx-auto' style="width:420px;margin-left:145px">Online Exhibitor Manual</a>
            <?php } ?>
       	
        <?php } ?>
        <div class="clear" style="height:10px;"></div>  
		<?php	
	}
    ?>
    
<!----------------------------------Second Application----------------------------------->
		<?php 
		// $sql="select * from  exh_registration where uid='$uid' and gid!='$gid' and `show`='IIJS 2019'";
		// $query=$conn->query($sql);		
		// $result=$query->fetch_assoc();
		// $second_application=$query->num_rows;
		// $check_gid=$result['gid'];
		
		// $check_query=$conn->query("select * from exh_reg_payment_details where gid='$check_gid'");
		// $check_num=$check_query->num_rows;
		
		// if(strtoupper($_SESSION['COUNTRY'])=="IN")
		// {
		//   $currency="";
		// }
		// else
		// {
		// 	$currency="USD";
		// }
		// if($second_application>0 && $check_num>0){
?>
		<!-- <span class="clear" style="height:1px; background:#ccc; display:block;"></span>  
  		<div class="clear" style="height:10px;"></div>
          
          <span class="clear" style="height:1px; background:#ccc; display:block;"></span>
        <div class="clear"></div>
    	<div class="summary_box">
        <p><strong style="text-transform:uppercase; font-size:14px;">Application Summary(Exh<?php echo $result['gid'];?>)</strong><br />
        <span class="clear" style="height:1px; background:#ccc; display:block;"></span>
        <strong>Last Year Participant :</strong>&nbsp; <?php echo $result['last_yr_participant'];?> <br />
        <strong>Option :</strong>&nbsp; <?php echo $result['options'];?> <br />
        <strong>Section :</strong>&nbsp; <?php echo $result['section'];?> <br />
        <strong>Area :</strong>&nbsp; <?php echo $result['selected_area'];?> &nbsp;sqrt<br />
        <strong>Scheme :</strong>&nbsp; <?php echo getSchemeDescription($result['selected_scheme_type'],$conn);?> <br />
        <strong>Premium :</strong>&nbsp; <?php echo $result['selected_premium_type'];?></p>
        </div>
        
        <div class="summary_box">
        <p><strong style="text-transform:uppercase; font-size:14px;">Application Payment Summary</strong> <br />
        
        <div class="clear"></div>
        <span class="clear" style="height:1px; background:#ccc; display:block;"></span>
        <strong>Total Space Cost <?php echo $currency;?> :</strong>&nbsp; <?php echo $result['tot_space_cost_rate'];?> <br />
        <strong>Selected scheme rate <?php echo $currency;?> :</strong>&nbsp; <?php echo $result['selected_scheme_rate'];?> <br />
        <strong>Selected premium rate <?php echo $currency;?> :</strong>&nbsp; <?php echo $result['selected_premium_rate'];?> <br />
        <strong>Mezzanine rate <?php echo $currency;?> :</strong>&nbsp; <?php echo $result['mezzanine_space_charges'];?> <br />
        <strong>Sub Total <?php echo $currency;?> :</strong>&nbsp; <?php echo $result['sub_total_cost'];?> <br />
        <strong>Security Deposit (10% on Sub Total) <?php echo $currency;?> :</strong>&nbsp; <?php echo $result['security_deposit'];?> <br />
        <strong>GST (18% on Sub Total) <?php echo $currency;?> :</strong>&nbsp; <?php echo $result['govt_service_tax'];?><br />
        <strong>Grand Total <?php echo $currency;?> :</strong>&nbsp; <?php echo $result['grand_total'];?></p>
        </div>
    	<div class="clear"></div> -->
        <?php 
		// $query1=$conn->query("select * from exh_reg_payment_details where gid='$check_gid' order by payment_id desc limit 0,1");
		// $result1=$query1->fetch_assoc();		
		?>
        
       <!--  <p><strong style="text-transform:uppercase; font-size:14px;">Application Status </strong><br/>
            <span class="clear" style="height:1px; background:#ccc; display:block;"></span>
           <p><div style="height:10px; display:block; padding:10px;">
 <div style="margin-right:50px; float:left; width: 212px;"><strong>Manual Application Status<?php echo $currency;?> :</strong>&nbsp; <?php echo $result1['application_status'];?> </div>
           <div style="margin-right:50px; float:left; width: 212px;"><strong>Manual Document Status<?php echo $currency;?> :</strong>&nbsp; <?php echo $result1['document_status'];?></div> 
            <div style="margin-right:50px; float:left; width: 212px;"><strong>Manual Payment  Status<?php echo $currency;?> :</strong>&nbsp; <?php echo $result1['payment_status'];?> </div></div></p>
       
        <span class="clear" style="height:1px; background:#ccc; display:block;"></span>
        
       <div class="clear"></div> -->
       
         <?php 
		 //if($result1['application_status']=="approved"){
            ?>
        <!-- <div class="field_input"> -->
        	<!--<a href="manual/index.php?uid=<?php echo $uid;?>&gid=<?php echo $check_gid;?>" class='select_dash_btn'>Online Exhibitor Manual</a>-->
			<!-- <a href="javascript: void(0)" onclick = "first_alert()" class='select_dash_btn'>Online Exhibitor Manual</a> -->
       	 </div>
        <?php //} else {?>
         <!-- <div class="field_input">
        	<a href="javascript: void(0)" onclick = "second_alert()" class='select_dash_btn'>Online Exhibitor Manual</a>
       	 </div> -->
         <?php //}?>
    	<!-- <div class="clear"></div>
        <div class="clear" style="height:10px;"></div>     -->   
 		<?php //}  ?>
    
        <div class="field_box">
       	  <div class="field_name"></div>
          <div class="clear"></div>
           <?php
		   // $query=$conn->query("select * from exh_reg_general_info where uid='$uid' and event_for='IIJS 2019'");
		   // $num=$query->num_rows;	
		   
		   // $query12=$conn->query("select * from exh_reg_payment_details where uid='$uid' and `show`='IIJS 2019'");
		   // $num12=$query12->num_rows;	
		   
		   //if($num<2){
           ?>
           <!--<div class="field_input" >
        	<a href="exhibitor_registration_step_1.php?Action=ADD" class="button">Add New Application</a>
       	    </div>-->
           <?php// } else if($num12<2) { ?>
           <?php 
		   // $query11=$conn->query("select * from exh_reg_general_info where uid='$uid' and event_for='IIJS 2019' order by id limit 1,1");
		   // $result11=$query11->fetch_assoc();
		   // $gid=$result11['id'];
		   ?>
           
           <!--<div class="field_input" >
        	<a href="exhibitor_registration_step_2.php?gid=<?php echo $gid;?>" class="button">Add New Application</a>
       	   </div>-->         
           <?php // } ?>        	
        </div>
	  
    <div class="clear"></div>
	</div>
	   
    <div class="clear"></div>
	</div>

<div class="clear" style="height:10px;"></div>
</div>

<div class="footer">
<script>
var acc = document.getElementsByClassName("accordion");
var i;

for (i = 0; i < acc.length; i++) {
    acc[i].onclick = function(){
        this.classList.toggle("active");
        this.nextElementSibling.classList.toggle("show");
  }
}
</script>
	<?php include('footer.php'); ?>
<div class="clear"></div>
</div>
<div class="clear"></div>
</div>
</body>
</html>
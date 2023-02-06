<?php 
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
</head>

<body>

<div class="wrapper">
<div class="header"><?php include('header1.php'); ?></div>
<div class="inner_container">
    <div class="clear"></div>
    
    <div class="content_form_area">
      <div class="pg_title">
        <div class="title_cont"> <span class="top">Exhibitor <img src="images/titles/joint.png" style="position:absolute; top:31px; right:0px;" /></span> <span class="below">Registration</span>
        <div class="clear"></div>
        </div>
      </div>
      
    <div class="clear"></div>
	  
    <div class="form_main">  
    <div class="form_title">Print Acknowledgment <div class="clear"></div></div>
	<?php	
    $sql_signature ="select * from exh_registration where uid='$uid' AND curr_last_yr_check='Y' AND `show`='IIJS SIGNATURE 2022' order by gid desc";
    $query_signature = $conn->query($sql_signature);		
	$num1=$query_signature->num_rows;		
    if($num1>0)
	{
    while ($result_signature = $query_signature->fetch_assoc()) {
	if($result_signature['event_selected']=="signature"){ $event_for="IIJS SIGNATURE 2022"; } 
	if($result_signature['event_selected']=="iijs"){ $event_for="IIJS 2021"; $event_show = "IIJS Premiere 2021";} 
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
        <strong>Section :</strong>&nbsp; <?php echo getSection_desc($result_signature['section'],$conn);?> <br />
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
		$query1=$conn->query("select * from exh_reg_payment_details where uid='$uid' AND `show`='IIJS Premiere 2021' order by payment_id desc limit 0,1");
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
      ?>

	<?php
	if($show=="signature"){
     $shows = "IIJS SIGNATURE 2022";
			/*..................................Get UTR DETAIL Start.....................................*/
				$utrExist = "SELECT sum(amountPaid) as `amountPaid`,sum(tdsAmount) as `tdsAmount` FROM `utr_history` WHERE registration_id='$uid' AND `show`='$shows' AND utr_approved='Y'";
				$existResult = $conn->query($utrExist);	
							
				while($printutr = $existResult->fetch_assoc())
				{				
					$amountPaidFromUTR = $printutr['amountPaid'];
					$tdsAmountFromUTR = $printutr['tdsAmount'];
				}
				
				$getSql_signature ="select * from exh_registration where uid='$uid' AND curr_last_yr_check='Y' AND `show`='$shows' order by gid desc";
				$getQuery_signature = $conn->query($getSql_signature);	
				$getResult_signature = $getQuery_signature->fetch_assoc();
				$getgid = $getResult_signature['gid'];
				/*..................................Get UTR DETAIL END.....................................*/
				
				$host="localhost";
				$user="appadmin";
				$password="#21SAq109@65%n";
				$dbname="manual_signature";

                // Create connection
                $conn2 = new mysqli($host, $user, $password, $dbname);
                // Check connection
                if ($conn2->connect_error) {
                    die("Connection failed: " . $conn2->connect_error);
                } else { 
				
                }
				
			$sexh="SELECT manual_signature.iijs_exhibitor.Exhibitor_Gid,manual_signature.iijs_exhibitor.Exhibitor_Registration_ID,manual_signature.iijs_exhibitor.exempt_gst,manual_signature.iijs_exhibitor.Exhibitor_HallNo,manual_signature.iijs_exhibitor.Exhibitor_Section,manual_signature.iijs_exhibitor.Exhibitor_Scheme,manual_signature.iijs_exhibitor.Exhibitor_DivisionNo,manual_signature.iijs_exhibitor.Exhibitor_StallNo1,manual_signature.iijs_exhibitor.Exhibitor_StallNo2,manual_signature.iijs_exhibitor.Exhibitor_StallNo3,manual_signature.iijs_exhibitor.Exhibitor_StallNo4,manual_signature.iijs_exhibitor.Exhibitor_StallNo5,manual_signature.iijs_exhibitor.Exhibitor_StallNo6,manual_signature.iijs_exhibitor.Exhibitor_Area,manual_signature .iijs_exhibitor.Exhibitor_StallType,manual_signature .iijs_exhibitor.Exhibitor_Premium,manual_signature .iijs_exhibitor.amountPaid, manual_signature.iijs_exhibitor.amountUnpaid FROM manual_signature.iijs_exhibitor where manual_signature.iijs_exhibitor.Exhibitor_Registration_ID='$uid' and manual_signature.iijs_exhibitor.Exhibitor_Gid='$getgid'";
			$qexh = $conn2->query($sexh); 
		/*	$sexh ="select * from exh_registration where uid='$uid' AND curr_last_yr_check='Y' AND `show`='IIJS 2021' order by gid desc";
			$qexh = $conn->query($sexh); */ /* Don't forget to uncomment $conn*/
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
        <p><strong style="text-transform:uppercase; font-size:14px;">Payment Status</strong> <br/>		
		<?php
		if(strtoupper($_SESSION['COUNTRY'])=="IN")
		{
			if($section=="plain_gold")
			{
				$charge="21000";
			}
			else if($section=="loose_stones")
			{
				$charge="21000";
			}
			else if($section=="signature_club")
			{
				$charge="21000";
			}
			else if($section=="studded_jewellery")
			{
				$charge="21000";
			}
			else if($section=="lab_edu")
			{
				$charge="21000";
			}
			else if($section=="allied")
			{
				$charge="21000";
			}
			else if($section=="synthetics" )
			{
				$charge="21000";
			}
			else if($section=="silver_jewellery_artifacts")
			{
				$charge="21000";
			}		
			
			/*elseif($section=="machinery"){
				if($_SESSION['member_type']=='MEMBER')
					$charge="16500";
				else
					$charge="17500";	
			} */
		} else {
			if($section=="International Jewellery")
			{
				$charge="500";
			}
			else if($section=="International Loose")
			{
				$charge="500";
			}
			else if($section=="machinery"){
				$charge="325";
			}
		}
		
		$membership_certificate_type = trim($_SESSION['membership_certificate_type']);	
		$msme_ssi_status = trim($_SESSION['msme_ssi_status']);
		
		$space_rate	=	intval($get_area*$charge);
		
		/*if(strtoupper($last_yr_participant)=="YES")
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
				
		if($selected_premium_type=="normal")
		{
			$selected_premium_type=0;
			$selected_premium_per="0%";
		}		
		else if($selected_premium_type=="premium")
		{
			$selected_premium_type=0.05;
			$selected_premium_per="5%";
		} */
		
		if($category=="normal")
		{
			$categoryINR=0;
			$category_per=0;
		}		
		else if($category=="corner_2side")
		{
			$categoryINR=0.05;
			$category_per=5;
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
		
		$category_cost = floatval($space_rate*$category_per)/100;
		
		if($exempt_gst =="1"){
		$gst_percentage ="0";	
		}else if($exempt_gst =="0" || $exempt_gst ==""){
	    $gst_percentage ="18";
		}
		
		/*$tot_space_cost_discount=intval($space_rate_discount);
		
		$get_tot_space_cost = intval($space_rate-$space_rate_discount);  // Get the total difference of Space cost Rate - Discount space cost rate

		$category_rate=$get_tot_space_cost*$categoryINR;
		
		$premium_rate=intval($get_tot_space_cost*$selected_premium_type);
		*/
		$sub_total_cost = floatval($space_rate+$category_cost);
		
		$security_deposit=floatval($sub_total_cost*10)/100;
		$govt_service_tax=floatval($sub_total_cost*18)/100;
		$grand_total = round($sub_total_cost+$security_deposit+$govt_service_tax);				
	?>
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
                <td align="right">Amount Paid SIGNATURE 2022</td>
                <td></td>
                <td><?php echo $amountPaidFromUTR;?></td>
            </tr> 
			<tr>
                <td align="right">TDS SIGNATURE 2022</td>
                <td></td>
                <td><?php echo $tdsAmountFromUTR;?></td>
            </tr>
			<tr>
                <td align="right">Total Amount Paid</td>
                <td></td>
                <td><?php echo $totalAmountPaid = $amountPaidFromUTR+$tdsAmountFromUTR;?></td>
            </tr> 			
            <tr>
                <td align="right"><b>Balance Payment</b></td>
                <td></td>
                <td><b><?php echo $amountUnpaid = $grand_total-$totalAmountPaid;?></b></td>
            </tr> 
		</tbody>
		</table>
					
        </div>
		<?php } ?>
		<?php } ?>
		
		
        <div class="clear" style="height:10px;"></div>
		
		<!--- 23 NOV 2021 --->		
        <?php 		
		if($countx1 > 0 && $countx1!='') { ?>
        <div style="float:right; display:block; font-size:35px; font-weight:normal;background-color:#924b77">
        <?php if($amountUnpaid<=500){?>
        	<a href="manual_signature/index.php?uid=<?php echo $uid;?>&gid=<?php echo $rexh['Exhibitor_Gid'];?>&section=<?php echo $rexh['Exhibitor_Section'];?>" class="newMaroonBtn">Click here to access online Exhibitor Manual</a><br/>
			<?php if($uid=='121148') { ?>
        	<a href="manual_signature/index.php?uid=121148&gid=26192&section=loose_stones" class="newMaroonBtn">Click here to access online Exhibitor Manual</a>
			<?php } ?>
			<!--<a href="javascript: void(0)" onclick = "second_alert()" class="newMaroonBtn">Online Exhibitor Manual</a>-->
            <?php } else { ?>
            <a href="javascript: void(0)" onclick = "balance_alert()" class='newMaroonBtn' style="width:420px;margin-left:145px">Online Exhibitor Manual</a>
            <?php } ?>
       	 </div>
        <?php } ?>
        <div class="clear" style="height:10px;"></div> 
	  

        <?php 
		if($show=="iijs"){
			/*..................................Get UTR DETAIL Start.....................................*/
				$utrExist = "SELECT sum(amountPaid) as `amountPaid`,sum(tdsAmount) as `tdsAmount` FROM `utr_history` WHERE registration_id='$uid' AND `show`='IIJS 2021'";
				$existResult = $conn->query($utrExist);	
							
				while($printutr = $existResult->fetch_assoc())
				{				
					$amountPaid=$printutr['amountPaid'];
					$tdsAmount=$printutr['tdsAmount'];
				}
				
				$getSql_signature ="select * from exh_registration where uid='$uid' AND curr_last_yr_check='Y' AND `show`='IIJS 2021' order by gid desc";
				$getQuery_signature = $conn->query($getSql_signature);	
				$getResult_signature = $getQuery_signature->fetch_assoc();
		
				/*..................................Get UTR DETAIL END.....................................*/
				
				$host="localhost";
				$user="appadmin";
				$password="#21SAq109@65%n";
				$dbname="manual_signature";

                // Create connection
                $conn2 = new mysqli($host, $user, $password, $dbname);
                // Check connection
                if ($conn2->connect_error) {
                    die("Connection failed: " . $conn2->connect_error);
                } else {
                    
                }
				
		//echo $sexh="SELECT manual_signature.iijs_exhibitor.exempt_gst,manual_signature.iijs_exhibitor.Exhibitor_HallNo,manual_signature.iijs_exhibitor.Exhibitor_Section,manual_signature.iijs_exhibitor.Exhibitor_Scheme,manual_signature .iijs_exhibitor.Exhibitor_DivisionNo,manual_signature .iijs_exhibitor. Exhibitor_StallNo1 ,manual_signature .iijs_exhibitor.Exhibitor_StallNo2,manual_signature .iijs_exhibitor.Exhibitor_StallNo3,manual_signature .iijs_exhibitor.Exhibitor_StallNo4,manual_signature.iijs_exhibitor.Exhibitor_StallNo5,manual_signature.iijs_exhibitor.Exhibitor_StallNo6,manual_signature .iijs_exhibitor.Exhibitor_Area,manual_signature .iijs_exhibitor.Exhibitor_StallType,manual_signature .iijs_exhibitor.Exhibitor_Premium, manual_signature .iijs_exhibitor.amountPaid, manual_signature .iijs_exhibitor.amountUnpaid FROM manual_signature .iijs_exhibitor where manual_signature .iijs_exhibitor.Exhibitor_Registration_ID='$uid' and manual_signature.iijs_exhibitor.Exhibitor_Gid='$gid'";
		//Commented in 04 August 2021
			 
			$sexh ="select * from exh_registration where uid='$uid' AND curr_last_yr_check='Y' AND `show`='IIJS 2021' order by gid desc";
			 $qexh=$conn->query($sexh); /* Don't forget to uncomment $conn*/
			 $rexh=$qexh->fetch_assoc();
			 
			 $section=$rexh['Exhibitor_Section'];
			 $scheme=$rexh['Exhibitor_Scheme'];
			 $get_area=$rexh['Exhibitor_Area'];
			 $allotted_women=0;
			 $exempt_gst=$rexh['exempt_gst'];
			 $category=$rexh['Exhibitor_StallType'];
			 $selected_premium_type=$rexh['Exhibitor_Premium'];
				
			$countx=$qexh->num_rows;
			if($countx > 0 && $countx!='') {	 ?>
	<!--			
		<div class="field">
            <p><strong style="text-transform:uppercase; font-size:14px;">Allotment Status</strong> <br />
            <span class="clear" style="height:1px; background:#ccc; display:block;"></span>
            <label><strong>Stall No : </strong><span style="color:#000000"><?php echo $rexh['Exhibitor_StallNo1']; echo'&nbsp;'; echo $rexh['Exhibitor_StallNo2']; echo'&nbsp;'; echo $rexh['Exhibitor_StallNo3']; echo'&nbsp;'; echo $rexh['Exhibitor_StallNo4']; echo'&nbsp;'; echo $rexh['Exhibitor_StallNo5']; echo'&nbsp;'; echo $rexh['Exhibitor_StallNo6']; ?> </span></label>
			<label><span style="color:#000000" > &nbsp;&nbsp;&nbsp;</span> </label><br/>
            <label><strong>Zone <?php echo $currency;?> : </strong><span style="color:#000000"><?php echo $rexh['Exhibitor_DivisionNo'];?></span> </label>
			<label><strong>Section : </strong><span style="color:#000000"><?php echo $section;?></span> </label>
			<label><strong>Area : </strong><span style="color:#000000"><?php echo $get_area;?></span> </label>
            <label><strong>Hall NO : </strong><span style="color:#000000"> <?php echo $rexh['Exhibitor_HallNo'];?></span> </label>
        </div>
        <div class="clear" style="height:10px;"></div>
		-->
		<div class="field">
            <p><strong style="text-transform:uppercase; font-size:14px;">Payment Status</strong> <br />
		
		<?php
		if(strtoupper($_SESSION['COUNTRY'])=="IN")
		{
			if($section=="plain_gold" && $allotted_women =="0")
			{
				$charge="22650";
			}
			else if($section=="loose_stones" && $allotted_women =="0")
			{
				$charge="21450";
			}
			else if($section=="Laboratories_&_Education" && $allotted_women =="0")
			{
				$charge="21450";
			}
			else if($section=="allied" && $allotted_women =="0")
			{
				$charge="21450";
			}
			else if($section=="studded_jewellery" && $allotted_women =="0")
			{
				$charge="22650";
			}
			else if($section=="signature_club" && $allotted_women =="0")
			{
				$charge="30500";
			}
			else if($section=="Synthetics_&_Simulants" && $allotted_women =="0")
			{
				$charge="21450";
			}
			elseif($section=="machinery"){
				if($_SESSION['member_type']=='MEMBER')
					$charge="16500";
				else
					$charge="17500";	
			}
		} else {
			if($section=="International Jewellery")
			{
				$charge="450";
			}
			else if($section=="International Loose")
			{
				$charge="450";
			}
			elseif($section=="machinery"){
				$charge="325";
			}
		}
		$last_yr_participant = $getResult_signature['last_yr_participant'];	
		$membership_certificate_type = trim($_SESSION['membership_certificate_type']);	
		$msme_ssi_status = trim($_SESSION['msme_ssi_status']);
		$space_rate	=	intval($get_area*$charge);
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
		
		if($category=="normal")
		{
			$categoryINR=0;
			$category_per=0;
		}		
		else if($category=="corner_2side")
		{
			$categoryINR=0.05;
			$category_per=5;
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
		
		if($exempt_gst =="1"){
		$gst_percentage ="0";	
		}else if($exempt_gst =="0" || $exempt_gst ==""){
	    $gst_percentage ="18";
		}
		
		$tot_space_cost_discount=intval($space_rate_discount);
		$get_tot_space_cost = intval($space_rate-$space_rate_discount);  // Get the total difference of Space cost Rate - Discount space cost rate

		$category_rate=$get_tot_space_cost*$categoryINR;
		
		$premium_rate=intval($get_tot_space_cost*$selected_premium_type);
		
		$sub_total_cost=floatval($get_tot_space_cost+$category_rate+$premium_rate);
		$security_deposit=floatval($sub_total_cost*10)/100;
		$govt_service_tax=floatval($sub_total_cost*18)/100;
		$grand_total=round($sub_total_cost+$security_deposit+$govt_service_tax);				
	?>
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
                <td><?php echo $rexh['selected_area'];?></td>
                <td></td>
            </tr> 
			<tr>
                <td align='center'>Space Cost</td>
                <td><?php echo $charge;?></td>
                <td><?php echo $rexh['tot_space_cost_rate'];?></td>
            </tr> 
			<tr>
                <td align='center'>Space cost after Incentive</td>
                <td><?php //echo $space_rate_discount_per;?></td>
                <td><?php echo $rexh['incentive_value'];?></td>
            </tr>
			<tr>
                <td align='center'>After Discount Space Cost</td>
                <td></td>
                <td><?php echo $rexh['get_tot_space_cost_rate'];?></td>
            </tr>
            <tr>
                <td align='center'>Premium</td>
                <td><?php echo $selected_premium_per;?></td>
                <td><?php echo $rexh['selected_premium_rate'];?></td>
            </tr>             
			<tr>
                <td align='center'>Selected scheme rate</td>
                <td><?php //echo $category_per."%";?></td>
                <td><?php echo $rexh['selected_scheme_rate'];?></td>
            </tr> 
			<tr>
                <td align="right">Sub Total</td>
                <td></td>
                <td><?php echo $rexh['sub_total_cost'];?></td>
            </tr> 
			<tr>
                <td align='center'>10% Sec Dep.</td>
                <td>10%</td>
                <td><?php echo $rexh['security_deposit'];?></td>
            </tr> 
			<tr>
                <td align='center'>18% GST</td>
                <td><?php echo $gst_percentage;?>%</td>
                <td><?php echo $rexh['govt_service_tax'];?></td>
            </tr> 
			<tr>
                <td align="right">TOTAL</td>
                <td></td>
                <td><?php echo $rexh['grand_total'];?></td>
            </tr> 
			<?php
			$iijs2020 ="SELECT * FROM utr_history_last_year where registration_id='$uid' AND `show`='IIJS 2020'";
			$iijs2020Query = $conn->query($iijs2020);
			$iijs2020Result = $iijs2020Query->fetch_assoc();
			
			$iijs2021 ="SELECT * FROM utr_history_last_year where registration_id='$uid' AND `show`='IIJS Signature 2021'";
			$iijs2021Query = $conn->query($iijs2021);
			$iijs2021Result = $iijs2021Query->fetch_assoc();
			?>
			<tr>
                <td align="right">Amount Paid IIJS 2020</td>
                <td></td>
                <td><?php echo $iijs2020Result['amountPaid'];?></td>
            </tr>
			<tr>
                <td align="right">TDS 2020</td>
                <td></td>
                <td><?php echo $iijs2020Result['tdsAmount'];?></td>
            </tr>
			<tr>
                <td align="right">Amount Paid SIGNATURE 2021</td>
                <td></td>
                <td><?php echo $iijs2021Result['amountPaid'];?></td>
            </tr>
			<tr>
                <td align="right">Amount Paid IIJS 2021</td>
                <td></td>
                <td><?php echo $amountPaid;?></td>
            </tr> 
			<tr>
                <td align="right">Total Amount Paid</td>
                <td></td>
                <td><?php echo $totalAmountPaid = $iijs2020Result['amountPaid']+$iijs2021Result['amountPaid']+$amountPaid;?></td>
            </tr> 			
			
            <tr>
                <td align="right">TDS 2021</td>
                <td></td>
                <td><?php echo $tdsAmount;?></td>
            </tr> 
			<tr>
                <td align="right"><b>Balance Payment</b></td>
                <td></td>
                <td><b><?php echo $amountUnpaid = $rexh['grand_total']-($totalAmountPaid+$tdsAmount+$iijs2020Result['tdsAmount']);?></b></td>
            </tr> 
		</tbody>
		</table>
			
    <!--    <table id="example" class="display" cellspacing="0" border="1" width="100%">
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
			<tr>
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
            </tr>             
			<tr>
                <td align='center'>Category</td>
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
                <td><?php echo $amountUnpaid=$grand_total-($amountPaid+$tdsAmount);?></td>
            </tr> 
		</tbody>
		</table>-->				
        </div>
		<?php } ?>
		<?php } ?>
		
		
        <div class="clear" style="height:10px;"></div>
		
		<!--  23 DEC 2016  ----->		
        <?php 		
		if($countx > 0 && $countx!='') { ?>
        <div style="float:right; display:block; font-size:35px; font-weight:normal;background-color:#924b77">
        <?php if($amountUnpaid<=500){?>
        	<!--<a href="manual_iijs/index.php?uid=<?php echo $uid;?>&gid=<?php echo $rexh['gid'];?>&section=<?php echo $rexh['section'];?>" class="newMaroonBtn">Online Exhibitor Manual</a>-->
			<a href="javascript: void(0)" onclick = "second_alert()" class="newMaroonBtn">Online Exhibitor Manuals</a>
            <?php } else { ?>
            <a href="javascript: void(0)" onclick = "balance_alert()" class='newMaroonBtn' style="width:420px;margin-left:145px">Online Exhibitor Manual</a>
            <?php } ?>
       	 </div>
        <?php } ?>
        <div class="clear" style="height:10px;"></div>         
    
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
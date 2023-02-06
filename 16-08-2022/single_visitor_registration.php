<?php 
include('header_include.php');
$registration_id = $_SESSION['registration_id'];
if(empty($registration_id)){
header("location:single_visitor.php");
}
$schk_membership="SELECT * FROM `approval_master` WHERE `registration_id`='$registration_id' and issue_membership_certificate_expire_status='Y'";
$qchk_membership = $conn->query($schk_membership);
$nchk_membership = $qchk_membership->num_rows;
if($nchk_membership>0){
$_SESSION['member_type']= 'MEMBER';
} else {
$_SESSION['member_type']= 'NON_MEMBER';
}
$member_type = $_SESSION['member_type'];
/*print_r($_SESSION);exit;*/

$addNMflag = "SELECT * FROM `n_m_billing_address` WHERE `registration_id`='$registration_id'";
$addNMflag = $conn->query($addNMflag);
$numAdd = $addNMflag->num_rows;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $evt_name; ?> IIJS VISITOR REGISTRATION</title>
    <link rel="shortcut icon" href="images/fav.png" />
    <link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Cabin'>
    <link rel="stylesheet" type="text/css" href="https://gjepc.org/assets-new/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="css/general.css?v=<?php echo $version;?>" />
    <link rel="stylesheet" type="text/css" href="css/inner_pg_style.css?v=<?php echo $version;?>" />
    <link rel="stylesheet" type="text/css" href="css/responsive.css?v=<?php echo $version;?>" />
    <link rel="stylesheet" type="text/css" href="css/media_query.css?v=<?php echo $version;?>" />
    <link rel="stylesheet" type="text/css" href="css/jquery.fancybox.min.css?v=<?php echo $version;?>" />
    <link rel="stylesheet" type="text/css" href="css/visitor_reg.css?v=<?php echo $version;?>" />
    <script type="text/javascript" src="js/jquery-1.8.3.min.js?v=<?php echo $version;?>"></script>
    <script type="text/javascript" src="js/jquery.fancybox.min.js?v=<?php echo $version;?>"></script>
    <!--NAV-->
    <link href="css/flexnav.css?v=<?php echo $version;?>" media="screen, projection" rel="stylesheet" type="text/css">
    <!--<script src="js/jquery.flexnav.js" type="text/javascript"></script>-->
    <script type="text/javascript" src="flexnav-master/js/jquery.flexnav.min.js?v=<?php echo $version;?>"></script>
    <script src="js/common.js?v=<?php echo $version;?>"></script>
    <!--NAV-->
    <script src="jsvalidation/jquery.validate.js?v=<?php echo $version;?>" type="text/javascript"></script>
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
    fbq('track', 'Step2');
    
    </script>
    <noscript><img height="1" width="1" style="display:none"
    src="https://www.facebook.com/tr?id=398834417477910&ev=PageView&noscript=1"
    /></noscript>
    <!-- End Facebook Pixel Code -->
    <script type="text/javascript">
    
    $(document).ready(function() {
    $("#singleVisitorRegistration").validate({
    rules: {
    address_billing:{
    required:true
    },
    /* address_shipping:{
    required:true
    }, */
    payment_made_for:{
    required:true
    },
    participation_fee:{
    required:true
    },
     agree:{
    required:true
    },
    
    },
    messages: {
    address_billing:{
    required: "Billing address is required"
    },
    /* address_shipping:{
    required: "Shipping address is required"
    }, */
    payment_made_for:{
    required: "Show is required"
    },
    participation_fee:{
    required: "Participation fee is required"
    },
    agree:{
    required: "Please agree the terms and conditions before submitting"
    },
    },
    submitHandler: singleVisitorRegistrationAction
    });
    
    });
    </script>
    <script type="text/javascript">
    $(document).ready(function(){
    $('#visitor_id').change(function(e){
    e.preventDefault();
    //alert($( this ).val());
    var visitors_ID = $(this).val();
    
    $.ajax({ type: 'POST',
    url: 'actionAjax.php',
    data: "actiontype=getEvent&&visitors_ID="+visitors_ID,
    dataType:'html',
    beforeSend: function(){
    $('.loader').show();
    },
    success: function(data){
    //alert(data);
    if($.trim(data)!=""){
    $('.loader').hide();
    $("#payment_made_for").html(data);
    }
    }
    });
    });
    });
    </script>
    <script type="text/javascript">
    function fees_calculate(show,registration_id)
    {
    //console.log(show);
    if(show === '' || show == null || show == 0) {
    alert("Please Select Show");
    return false;
    }
    $("#add_visitor").attr("disabled");
    $.ajax({
    type: "POST",
    url: "single-ajax-fees-display.php",
    data: "show="+show+"&&registration_id="+registration_id,
    beforeSend: function(){
    $('.loaderWrapper').show();
    },
    success: function(response){
        // alert(show);
      if(show =="iijs22"){        
       $(".terms_conditions_file").attr("href","pdf/IIJS-Premeire-2022-T-&-C.pdf");
      }else if(show =="signature23"){
      $(".terms_conditions_file").attr("href","pdf/IIJS-Signature-2023-T-&-C.pdf");
      }else if(show =="iijstritiya23"){
          $(".terms_conditions_file").attr("href","pdf/IIJS-Tritiya-2023-T-&-C.pdf");
      }else if(show =="combo23"){
          $(".terms_conditions_file").attr("href","pdf/Visitor-Terms-Conditions-IIJS-Premiere-2022.pdf");
        
      }
    /*alert(response);*/
    if(response!==''){
    $('.loaderWrapper').hide();
    $("#participation_fee").val(response);
    $("#add_visitor").removeAttr("disabled");
    } else {
    //$("#participation_fee").val(response);
    $('.loaderWrapper').show();
    }
    }
    });
    }
    function singleVisitorRegistrationAction(){
    var formdata = $('#singleVisitorRegistration').serialize();
    let selected_show = $("#payment_made_for").val();

    let message;
    if(selected_show =="iijs22"){
      message = "Dear visitor - Are you sure you want to register for IIJS Premiere 2022 show , dated 4th - 8th August 2022  ";
    }else if(selected_show =="signature23"){
      message = "Dear visitor - Are you sure you want to register for IIJS Signature 2023 show , dated 5th - 8th January 2023  ";
    }else if(selected_show =="iijstritiya23"){
      message = "Dear visitor - Are you sure you want to register for IIJS Tritiya 2023 show , dated 17th - 20th March 2023  ";
    }else if(selected_show =="combo23"){
      message = "Dear visitor - Are you sure you want to register for IIJS Premiere 2022, IIJS Signature 2023 & IIJS Tritiya 2023 show . ";
    }else if(selected_show =="igjme22"){
      message = "Dear visitor - Are you sure you want to register for IIJS Machinery 2022 show . This badge is valid to visit only in MACHINERY Hall ";
    }
    if(confirm(message)){

    }else{
      return false;
    }
    $.ajax({
    type:'POST',
    data:formdata,
    url:"singleVisitorAjax.php",
    dataType: "json",
    beforeSend: function(){
    $('.loaderWrapper').show();
    },
    success:function(data){
    if(data.status == "success"){
    window.location = "ebs/single_techprocess.php";
    }else if(data.status == "vbsmSuccess"){
    // window.location = "single_vbsm_success.php";
    } else if(data.status == "sign2Success"){
    // window.location = "single_sign2_success.php";
    } else if(data.status == "machinerySuccess"){
      window.location = "single_payment_igjme_success.php";
    }else if(data.status == "zeroPaymentSuccess"){
      window.location = "single_payment_iijs_success.php";
    }else if(data.status=="error"){
    alert(data.message);
     $('.loaderWrapper').hide();
    return false;
    }
    }
    });
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
    <style type="text/css">
    .fancybox-content{width: 70%}
    </style>
	<?php if($numAdd==0){ /* Address Validation*/?>
	<script type="text/javascript">
    $(document).ready(function() {
    $("#singleAddress").validate({
    rules: {
    address1:{
    required:true
    },
    address2:{
    required:true
    }, 
    state:{
    required:true
    },
    city:{
    required:true
    },
	pin_code:{
    required:true
    },
    },
    messages: {
    address1:{
    required: "Address 1 is required"
    },
    address2:{
    required: "Address 2 is required"
    },
    state:{
    required: "State is required"
    },
    city:{
    required: "city is required"
    },
	pin_code:{
    required: "Pin Code is required"
    },
    },
    submitHandler: submitAddressAction
    });
    
    });
	
	function submitAddressAction(){
    var formdata = $('#singleAddress').serialize();
    $.ajax({
    type:'POST',
    data:formdata,
    url:"addressAjax.php",
    dataType: "json",
    beforeSend: function(){
    $('.loaderWrapper').show();
    },
    success:function(data){ 
    if(data.status == "success"){
    $('.loaderWrapper').delay(300).fadeOut();
    $("#chkAddressStatus").html("Address saved successfully").delay(1000).fadeOut();
	$('#singleAddress').remove();
	$("#chkAddressStatus").css("display", "block");
    location.reload();
    }else if(data.status=="error"){
    alert(data.message);
    return false;
    }
    }
    });
    }
    </script>

	<?php } ?>	
	
  </head>
  <body>
    <div class="wrapper">
      <div class="header">
        <?php include('header1.php'); ?>
      </div>
      
      <div class="clear"></div>
      <!--container starts-->
      <div class="container_wrap">
        <div class="container">
             <div class="bold_font text-center">
              <div class="d-block">
                  <img src="https://www.gjepc.org/assets/images/gold_star.png" class="">
              </div>
         <?php //echo $evt_name; ?> VISITOR REGISTRATION
          </div>
          <div id="loginForm">
            
            <div class="box-shadow">
              <div class="loaderWrapper">
                <div class="formLoader">
                  <img src="images/formloader.gif" alt="">
                  <p> Please Wait....</p>
                </div>
              </div>
			  
			  <?php if($numAdd==0 && $_SESSION['member_type'] == 'NON_MEMBER'){ ?>
				<form class="row" method="POST" id="singleAddress" autocomplete="off">
			    <div class="col-12 form-group">
                    <div class="accordian">
                      <div class="card">
                        <div class="card-header">
                          <h3>Manage Address</h3>
                          <i class="fa fa-plus" aria-hidden="true"></i>
                        </div>
                        <div class="card-body">                          
                          <div class="row">                            
                            <div class="col-sm-6 col-md-4 form-group">
                              <label for="">Address Line 1</label>
                             <input id="address1" name="address1" type="text" class="form-control" value="<?php echo $address1;?>" maxlength="40" autocomplete="off">
                            </div>

                            <div class="col-sm-6 col-md-4 form-group">
                              <label for="">Address Line 2</label>
                              <input id="address2" name="address2" type="text" class="form-control" value="<?php echo $address2;?>" maxlength="40" autocomplete="off">
                            </div>

                            <div class="col-sm-6 col-md-4 form-group">
                              <label>State <sup>*</sup> </label>
							<select name="state" id="state" class="select-control">
								<option value="">---- Select State ----</option>
								<?php
								$sql="SELECT * from state_master WHERE country_code = 'IN'";
								$result=$conn->query($sql);
								while($rows=$result->fetch_assoc())
								{
								if($rows['state_code']==$state)
								{
								echo "<option selected='selected' value='$rows[state_code]'>$rows[state_name]</option>";
								}	else	{
								echo "<option value='$rows[state_code]'>$rows[state_name]</option>";
								}}	?>
							</select>
                            </div>

                            <div class="col-sm-6 col-md-4 form-group">
                            <label>City <sup>*</sup> </label>
							<input id="city" name="city" type="text" class="form-control" onkeypress="return onlyAlphabets(event,this);" value="<?php echo $city;?>" autocomplete="off"/>
                            </div>

                            <div class="col-sm-6 col-md-4 form-group">
                            <label>Pin Code <sup>*</sup> </label>
							<input id="pin_code" name="pin_code" type="text" class="form-control" value="<?php echo $pin_code;?>" maxlength="6" autocomplete="off"/>
                            </div>
							
							<div class="col-sm-6 col-md-4 form-group">
							<label class="d-block">. </label>
							<input type="submit" name="submit" id="submit" value="Submit" class="btn btn-submit" >
							<input type="hidden" name="action" value="submitAddressAction">
							</div>
														
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
				</form>
				<p id="chkAddressStatus" class="alert alert-success" style="display:none"></p>
				<?php } ?>
				
              <?php
              $visitor_id = $_SESSION['visitor_id'];
              if(isset($_SESSION['is_secondary']) && $_SESSION['is_secondary'] =="Y"){
              $visitorMobile = getVisitorSecondaryMobile($visitor_id,$conn);
              } else {
              $visitorMobile = getVisitorMobile($visitor_id,$conn);
              }
              $sql = "SELECT * FROM visitor_mobileotpverification WHERE visitor_id='$visitor_id' AND registration_id = '$registration_id' AND mobile_no='$visitorMobile'";
              $resultm = $conn->query($sql);
              $count = $resultm->num_rows;
              if($count > 0 ){
              $getData = $resultm->fetch_assoc();
              $isVerified = $getData['verified'];
              if($isVerified == 0){
              header("location:single_visitor.php");
              }
              } else {
              header("location:single_visitor.php");
              }
              
              // $show = $shortcode;
              // $year = $year;
             //  $sqlCombo = "SELECT combo FROM visitor_directory WHERE visitor_id='$visitor_id' AND visitor_approval ='Y' limit 1";
             //  $resultCombo = $conn->query($sqlCombo);
             //  $rowCombo = $resultCombo->fetch_assoc();
              
             //  $sqlPaymentCheck = "SELECT * FROM visitor_order_history WHERE registration_id='$registration_id' AND visitor_id='$visitor_id' AND status='1' AND payment_status='Y' AND `show`='$show' AND year='$year'";
             //  $resultPaymentCheck = $conn->query($sqlPaymentCheck);
             //  $countPaymentCheck = $resultPaymentCheck->num_rows;
             // if($countPaymentCheck > 0 ){ 
             //    echo '<p style="text-align: center;"> Your Application for this Show is Already Registered </p>';
             //    } else {
              

              
              $checkHistory = "SELECT * FROM `visitor_order_history` WHERE registration_id='$registration_id' AND visitor_id='$visitor_id' AND (payment_made_for='6show' OR payment_made_for='5show' ) AND `status`='1' AND payment_status='Y'";
              $getQuery = $conn ->query($checkHistory);
              $checkResult = $getQuery->num_rows;
              // ASSINGNED NUMBER IS 10 TO UNCHECK THE CONDITION
              if($checkResult > 10 ){ 
              ?>
 
              <form class="" method="POST" id="singleVisitorRegistration" autocomplete="off">

                <div class="row">
                  
                  <!-- <div class="col-12">
                    <p style="color: red;font-weight: bold;font-size: 14px;">"Please note : All the visitors visiting the exhibition should be fully vaccinated."</p>
                  </div> -->

                  <div class="col-sm-6 col-md-4 form-group">
                    <label>I am interested to visit</label>
                    <?php
                    $visitor_id = $_SESSION['visitor_id'];
                    $sqlVisitor = $conn->query("SELECT degn_type FROM visitor_directory WHERE visitor_id ='$visitor_id'");
                    $sqlVisitorRow = $sqlVisitor->fetch_assoc();
                    $designationType = $sqlVisitorRow['degn_type'];
                    $visitor_designationType = getVisitorDesignationType($visitor_id,$conn);
                    if(!empty($visitor_designationType))
                    { ?>
                    <select name="payment_made_for" id="payment_made_for"  class="form-control" style="width:100%">
                      <option value="">--- Please Select One ---</option>

                      <?php 
                      $sql_event_nm = "SELECT * FROM `visitor_event_master` WHERE `status` ='1'  order by `serial_no` ASC";  
                      $result_event_nm = $conn->query($sql_event_nm);
                      $count_event_nm = $result_event_nm->num_rows;
                      if($count_event_nm > 0){
                        while($row_event_nm = $result_event_nm->fetch_assoc()){ ?>
                          <option value="<?php echo $row_event_nm['shortcode'];?>" ><?php echo $row_event_nm['event_name']; ?></option>
                        <?php } } ?>                 
                     
                    </select>
                    <?php } ?>
                  </div>                  
                     
                  <div class="col-sm-6 col-md-4 form-group">  
                    <input type="hidden" class="form-control" id="participation_fee" name="participation_fee" value="0"/>
                  </div>

                  <div class="col-12 form-group">
                    <input type="checkbox" name="agree" value="YES" checked="">I also agree to receive information from GJEPC via Whatsapp & other Media 
                    <a href="pdf/<?php echo $evt_term_condition_file; ?>" class="terms_conditions_file" target="_blank" style="color: red; text-decoration: underline;font-size: 12px;">Read More...</a>
                    <label for="agree" generated="true" class="error" style="display:none"></label>
                  </div>

                  <div class="col-12"><a data-fancybox data-src="#modals" href="javascript:;" class="agree-terms"></a></div>

                  <div class="col-12 form-group">
                    <input type="submit" name="submit" id="submit" value="Submit" class="btn btn-submit" >
                    <input type="hidden" name="action" value="singleVisitorRegistration" >
                    <input type="hidden" name="type_of_member" value="<?php if($nchk_membership>0){ $_SESSION['member_type']= 'MEMBER'; echo 'M'; } else { $_SESSION['member_type']= 'NON_MEMBER'; echo 'NM'; } ?>">
                   
                    <input type="hidden" name="visitor_id" value="<?php echo $_SESSION['visitor_id']?>">
                        <p id="addVisitor" class="fail"></p>
                  </div>

                </div>
                  
              </form>
              
              <?php } else {  ?>
              
              <form class="" method="POST" id="singleVisitorRegistration" autocomplete="off">
                
                <div class="row">

                  <!-- <div class="col-12 form-group" style="padding-left: 10px"><p class="mb-0" style="color: red;font-weight: bold;font-size: 14px;">Please note : All the visitors visiting the exhibition should be fully vaccinated.</p>
                  </div> -->
                  
                  <div class="col-sm-6 col-md-4 form-group">

                    <label>Billing Address</label>

                    <?php
                    if($member_type == "MEMBER"){
                    $addflag = "SELECT distinct c_bp_number,id,address1,address2,state,city,pincode,gst_no,type_of_address FROM `communication_address_master` WHERE `address_identity`='CTC' AND `registration_id`='$registration_id' AND c_bp_number!=''";
                    } else {
                    $addflag = "SELECT * FROM `n_m_billing_address` WHERE `registration_id`='$registration_id'";
                    }
                    $queryadd = $conn->query($addflag);
                    $nans = $queryadd->num_rows;
                    $queryadd2 = $conn->query($addflag);
                    $rowsaddress_billing = $queryadd2->fetch_assoc();
                    ?>
                        
                    <select name="address_billing" id="address_billing" class="select-control">
                      <option value="">--- Please Select One ---</option>
                      <?php
                      if($nans > 0){
                      while($rows = $queryadd->fetch_assoc())
                      { ?>
                      <option value="<?php echo $rows['id']; ?>" <?php if($rows['type_of_address']==2){?> selected="selected" <?php } ?>><?php echo strtoupper($rows['address1'])." ".strtoupper($rows['city']);?></option>
                      <?php } } else { ?>
                      <option value="">Not Found</option>
                      <?php } ?>
                    </select>

                    <input type="hidden" name="address_billing" value="<?php echo $rowsaddress_billing['id']; ?>">
                    <input type="hidden" name="address_shipping" value="<?php echo $rowsaddress_billing['id']; ?>">
                  
                  </div>
                  
                  <div class="col-sm-6 col-md-4 form-group">
                    <label>I am interested to visits</label>
                    <?php
                    $visitor_id = $_SESSION['visitor_id'];
                    $sqlVisitor = $conn->query("SELECT degn_type FROM visitor_directory WHERE visitor_id ='$visitor_id'");
                    $sqlVisitorRow = $sqlVisitor->fetch_assoc();
                    $designationType = $sqlVisitorRow['degn_type'];
                    $visitor_designationType = getVisitorDesignationType($visitor_id,$conn);
                    if(!empty($visitor_designationType))
                    { ?>
                    <select name="payment_made_for" id="payment_made_for" onchange="fees_calculate(this.value,<?php echo $registration_id;?>)" class="select-control" style="width:100%">
                      <option value="">--- Please Select One ---</option>
                    <?php
                      $sql_history  = "SELECT `payment_made_for` FROM  `visitor_order_history` WHERE visitor_id='$visitor_id' and registration_id ='$registration_id' AND payment_status='Y'";
                      $result_history = $conn->query($sql_history);
                      $registered_events = array();
                      
                      while($row_history = $result_history->fetch_assoc()){
                        $registered_events[] = $row_history['payment_made_for'];
                      }

                      $sql_event = "SELECT * FROM `visitor_event_master` WHERE `status` ='1'  order by `serial_no` ASC";  
                      $result_event = $conn->query($sql_event);
                      $count_event = $result_event->num_rows;
                      if($count_event > 0){
                        while($row_event = $result_event->fetch_assoc()){ 
                          if(!in_array( $row_event['shortcode'], $registered_events)){
                          ?>
                          <option value="<?php echo $row_event['shortcode'];?>" ><?php echo $row_event['event_name']; ?></option>
                        <?php 
                          } } }?>
                    </select>
                    <?php
                    }
                    ?>
                  </div>
                    
                  <div class="col-sm-6 col-md-4 form-group">
                    <label>Amount</label>
                    <input type="text" class="form-control" id="participation_fee" name="participation_fee" autocomplete="off" readonly="readonly" />
                  </div>

                  <div class="col-12 form-group" style="padding-left: 10px">
                    <input type="checkbox" name="agree" value="YES" checked="">
                    I also agree to receive information from GJEPC via Whatsapp & other Media <a href="pdf/<?php echo $evt_term_condition_file; ?>" class="terms_conditions_file"  target="_blank" style="color: red; text-decoration: underline;font-size: 12px;">Read More...</a>

                    <div class="d-block"><label for="agree" generated="true" class="error" style="display:none"></label></div> 
                  </div>
                     
                  <div class="col-12"><a data-fancybox data-src="#modals" href="javascript:;" class="agree-terms"></a></div>

                  <div class="col-12 form-group mb-0">
                    <input type="submit" name="submit" id="submit" value="Submit" class="btn btn-submit" >
                    <input type="hidden" name="action" value="singleVisitorRegistration" >
                    <input type="hidden" name="type_of_member" value="<?php if($nchk_membership>0){ $_SESSION['member_type']= 'MEMBER'; echo 'M'; } else { $_SESSION['member_type']= 'NON_MEMBER'; echo 'NM'; } ?>">
                    
                    <input type="hidden" name="visitor_id" value="<?php echo $_SESSION['visitor_id']?>">
                    <p id="addVisitor" class="fail"></p>
                  </div>

                </div>

                
              </form>
              <?php
              }
              // }
              ?>
            </div>
          </div>
        </div>
        <div class="clear"></div>
      </div>
    </div>
    <!--container ends-->
    <!--footer starts-->
   <div class="footer">
  <?php include ('footer.php'); ?>
</div>
  </div>
  <!--footer ends-->
  <link rel="stylesheet" type="text/css" href="css/new_style.css" />
  <script>
    // Accordian
$(".card-header").click(function(){
  $(this).parent('.card').siblings('.card').children('.card-header').removeClass('active');
  $(this).toggleClass('active');
  if($(this).next(".card-body").hasClass("active")){
   $(this).next(".card-body").removeClass("active").slideUp()
  }
  else{
  $(".card .card-body").removeClass("active").slideUp();
  $(this).next(".card-body").addClass("active").slideDown()
  }

});

  </script>

  <style>
    .accordian .card{width:100%;background:#fff;border:1px solid #a89c5d; border-radius: 5px; overflow: hidden;}
.accordian .card .card-header h3{font-weight:700;font-size:14px;cursor:pointer;background:#fff;color:#000;position:relative;margin:0;padding:15px 30px 15px 15px; transition:all 0.3s ease-in-out; -webkit-transition:all 0.3s ease-in-out; -moz-transition:all 0.3s ease-in-out; -o-transition:all 0.3s ease-in-out;}
.accordian .card .card-header{position:relative;padding:0;border:0}
.accordian .card .card-header i{position:absolute;right:20px;top:12px; font-size: 18px;}
.accordian .card .card-body{display:none;padding:15px;}
.accordian .card .card-header.active h3 {background: #000; color: #fff; transition:all 0.3s ease-in-out; -webkit-transition:all 0.3s ease-in-out; -moz-transition:all 0.3s ease-in-out; -o-transition:all 0.3s ease-in-out;}
.accordian .card .card-header.active i {color: #fff;}
  </style>

</body>
</html>
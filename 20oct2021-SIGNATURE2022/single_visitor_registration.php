<?php include('header_include.php');
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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IIJS VISITOR REGISTRATION</title>
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
          <h3 class="headtxt" style="margin-top: 50px">IIJS PREMIERE SHOW - Visitor Registration </h3>
          <div id="loginForm">
            
            <div id="formContainer">
              <div class="loaderWrapper">
                <div class="formLoader">
                  <img src="images/formloader.gif" alt="">
                  <p> Please Wait....</p>
                </div>
              </div>
              <?php
              $visitor_id = $_SESSION['visitor_id'];
              if(isset($_SESSION['is_secondary']) && $_SESSION['is_secondary'] =="Y"){
              $visitorMobile = getVisitorSecondaryMobile($visitor_id,$conn);
              } else {
              $visitorMobile = getVisitorMobile($visitor_id,$conn);
              }
              $sql  = "SELECT * FROM visitor_mobileotpverification WHERE visitor_id='$visitor_id' AND registration_id = '$registration_id' AND mobile_no='$visitorMobile'";
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
              
              $show = "iijs21";
              $year = '2021';
              $sqlCombo = "SELECT combo FROM visitor_directory WHERE visitor_id='$visitor_id' AND visitor_approval ='Y' limit 1";
              $resultCombo = $conn->query($sqlCombo);
              $rowCombo = $resultCombo->fetch_assoc();
              
              $sqlPaymentCheck = "SELECT * FROM visitor_order_history WHERE registration_id='$registration_id' AND visitor_id='$visitor_id' AND status='1' AND payment_status='Y' AND `show`='$show' AND year='$year'";
              $resultPaymentCheck = $conn->query($sqlPaymentCheck);
              $countPaymentCheck = $resultPaymentCheck->num_rows;
              if($countPaymentCheck > 0 ){ ?>
              <p style="text-align: center;"> Your Application for this Show is already registered</p>
              <?php } else {
              
              $checkHistory = "SELECT * FROM `visitor_order_history` WHERE registration_id='$registration_id' AND visitor_id='$visitor_id' AND (payment_made_for='6show' OR payment_made_for='5show' OR payment_made_for='4show' OR payment_made_for='3show' OR payment_made_for='2show' OR payment_made_for='1show' OR payment_made_for='combo') AND `status`='1' AND payment_status='Y'";
              $getQuery = $conn ->query($checkHistory);
              $checkResult = $getQuery->num_rows;
              if($checkResult > 0 ){ ?>
        
              
              <form class="" method="POST" id="singleVisitorRegistration" autocomplete="off">
                <div class="d-flex flex-column">
                  
                  <div class="d-flex flex-row form-setup">
                    <div class="col-50 d-flex justify-around flex-wrap form-group">
                      <div class="col-50 d-flex align-center">
                        <label>I am interested to visit</label>
                      </div>
                      <div class="col-50">
                        <?php
                        $visitor_id = $_SESSION['visitor_id'];
                        $sqlVisitor = $conn->query("SELECT degn_type FROM visitor_directory WHERE visitor_id ='$visitor_id'");
                        $sqlVisitorRow = $sqlVisitor->fetch_assoc();
                        $designationType = $sqlVisitorRow['degn_type'];
                        $visitor_designationType = getVisitorDesignationType($visitor_id,$conn);
                        if(!empty($visitor_designationType))
                        { ?>
                        <select name="payment_made_for" id="payment_made_for"  class="select-control" style="width:100%">
                          <option value="">--- Please Select One ---</option>
                          <option value="iijs21" <?php if($payment_made_for=="iijs21") echo "selected"; ?>>IIJS PREMIERE 2021 Show</option>
                          <option value="igjme21" <?php if($payment_made_for=="igjme21") echo "selected"; ?>>Machinery</option>
                        </select>
                        <?php } ?>
                      </div>
                    </div>
                    <input type="hidden" class="form-control" id="participation_fee" name="participation_fee" value="0"/>
                  </div>
                </div>
                <div class="col-100"><p style="color: red;font-weight: bold;font-size: 16px;">???Please Note: To visit and to register for the show, minimum 1 dose of Covid-19 vaccination is compulsory???</p></div>
                <div class="col-100"><input type="checkbox" name="agree" value="YES" checked="">I also agree to receive information from GJEPC via Whatsapp & other Media </div>
                <a data-fancybox data-src="#modals" href="javascript:;" class="agree-terms"></a>
                <div class="d-flex flex-column ">
                  <div class="d-flex flex-row form-setup">
                    <div class="col-50 d-flex  flex-wrap form-group">
                      <input type="submit" name="submit" id="submit" value="Submit" class="btn btn-submit" >
                      <input type="hidden" name="action" value="singleVisitorRegistration" >
                      <input type="hidden" name="type_of_member" value="<?php if($nchk_membership>0){ $_SESSION['member_type']= 'MEMBER'; echo 'M'; } else { $_SESSION['member_type']= 'NON_MEMBER'; echo 'NM'; } ?>">
                      <!-- <input type="hidden" name="type_of_member" id="type_of_member" <?php  if($nchk_membership>0){ if($_SESSION['member_type'] == "MEMBER"){?>value="M" <?php } ?><?php if($_SESSION['member_type'] != "MEMBER"){?>value="NM" <?php } }?> /> -->
                      <input type="hidden" name="visitor_id" value="<?php echo $_SESSION['visitor_id']?>">
                      <p id="addVisitor" class="fail"></p>
                    </div>
                  </div>
                </div>
              </form>
              
              <?php } else {  ?>
              
              <form class="" method="POST" id="singleVisitorRegistration" autocomplete="off">
                <div class="d-flex flex-column ">
                  <div class="d-flex flex-row form-setup">
                    <div class="col-50 d-flex justify-around flex-wrap form-group">
                      <div class="col-50 d-flex align-center">
                        <label>Billing Address</label>
                      </div>
                      <div class="col-50">
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
                      </div>
                    </div>
                    <div class="col-50 d-flex justify-around flex-wrap form-group"></div>
                    
                  </div>
                  <input type="hidden" name="address_billing" value="<?php echo $rowsaddress_billing['id']; ?>">
                  <input type="hidden" name="address_shipping" value="<?php echo $rowsaddress_billing['id']; ?>">
                  <div class="d-flex flex-row form-setup">
                    <div class="col-50 d-flex justify-around flex-wrap form-group">
                      <div class="col-50 d-flex align-center">
                        <label>I am interested to visit</label>
                      </div>
                      <div class="col-50">
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
                          <option value="iijs21" <?php if($payment_made_for=="iijs21") echo "selected"; ?>>IIJS PREMIERE 2021 Show</option>
                          <option value="igjme21" <?php if($payment_made_for=="igjme21") echo "selected"; ?>>Machinery</option>
                        </select>
                        <?php
                        }
                        ?>
                        
                      </div>
                    </div>
                    
                    <div class="col-50 d-flex justify-around flex-wrap form-group">
                      <div class="col-50 d-flex align-center">
                        <label>Amount</label>
                      </div>
                      <div class="col-50">
                        <input type="text" class="form-control" id="participation_fee" name="participation_fee" autocomplete="off" readonly="readonly" />
                      </div>
                    </div>
                    
                  </div>
                  
                </div>
                 <div class="col-100" style="padding-left: 10px"><p style="color: red;font-weight: bold;font-size: 16px;">???Please Note: To visit and to register for the show, minimum 1 dose of Covid-19 vaccination is compulsory???</p></div>
                <div class="col-100 " style="padding-left: 10px">
                  <input type="checkbox" name="agree" value="YES" checked="">I also agree to receive information from GJEPC via Whatsapp & other Media
                </div>
                <a data-fancybox data-src="#modals" href="javascript:;" class="agree-terms"></a>
                <div class="d-flex flex-column ">
                  <div class="d-flex flex-row form-setup">
                    <div class="col-50 d-flex  flex-wrap form-group">
                      <input type="submit" name="submit" id="submit" value="Submit" class="btn btn-submit" >
                      <input type="hidden" name="action" value="singleVisitorRegistration" >
                      <input type="hidden" name="type_of_member" value="<?php if($nchk_membership>0){ $_SESSION['member_type']= 'MEMBER'; echo 'M'; } else { $_SESSION['member_type']= 'NON_MEMBER'; echo 'NM'; } ?>">
                      <!-- <input type="hidden" name="type_of_member" id="type_of_member" <?php  if($nchk_membership>0){ if($_SESSION['member_type'] == "MEMBER"){?>value="M" <?php } ?><?php if($_SESSION['member_type'] != "MEMBER"){?>value="NM" <?php } }?> /> -->
                      <input type="hidden" name="visitor_id" value="<?php echo $_SESSION['visitor_id']?>">
                      <p id="addVisitor" class="fail"></p>
                    </div>
                  </div>
                </div>
              </form>
              <?php
              }
              }
              ?>
            </div>
          </div>
        </div>
        <div class="clear"></div>
      </div>
    </div>
    <!--container ends-->
    <!--footer starts-->
    <div class="footer_wrap">
      <?php include ('footer.php'); ?>
    </div>
  </div>
  <!--footer ends-->
  <link rel="stylesheet" type="text/css" href="css/new_style.css" />
</body>
</html>
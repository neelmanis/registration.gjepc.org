<?php 
include('header_include.php');
$uid = $_SESSION['uid'];
$eid = $_SESSION['eid'];
if(empty($uid)){ header("location:single_intl_registration.php"); }

$sql  = "SELECT verified FROM ivr_registration_details WHERE eid='$eid' AND uid= '$uid'";
$resultm = $conn->query($sql);
$count = $resultm->num_rows;
if($count > 0 ){
$getData = $resultm->fetch_assoc();
$isVerified = $getData['verified'];
if($isVerified == 0){
header("location:single_intl_registration.php");
}
} else { header("location:single_intl_registration.php"); } 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IIJS INTERNATIONAL VISITOR REGISTRATION</title>
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
    payment_made_for:{
        required:true
      }
    },
    messages: {
    payment_made_for:{
        required: "payment made for is required"
      }
    },
    submitHandler: singleVisitorRegistrationAction
    });    
    });
	
	function singleVisitorRegistrationAction(){
          var formdata = $('#singleVisitorRegistration').serialize();
          $.ajax({
            type:'POST',
            data:formdata,
            url:"singleINTLVisitorAjax.php",
            dataType: "json",
              beforeSend: function(){
               $('.loaderWrapper').show();
              }, 
            success:function(data){      
            if(data.status == "virtualSuccess"){
			window.location = "single_intl_success.php";
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
  </head>
  <body>


    <div class="wrapper">

      <div class="header"><?php include('header1.php'); ?></div>
      
      <div class="container">
        <div class="bold_font text-center">
        <div class="d-block">
          <img src="https://www.gjepc.org/assets/images/gold_star.png" class="">
        </div>
        International Visitor Registration
      </div>
        

        <div id="loginForm" class="box-shadow">
            
          <div id="formContainer" class="border-0 p-0">

            <div class="loaderWrapper">
              <div class="formLoader">
                <img src="images/formloader.gif" alt="">
                <p> Please Wait....</p>
              </div>
            </div>

              <?php			  
              $sqlPaymentCheck = "SELECT * FROM ivr_registration_details WHERE eid='$eid' AND uid= '$uid' AND trade_show='IIJS SIGNATURE 2022'";
              $resultPaymentCheck = $conn->query($sqlPaymentCheck);
              $countPaymentCheck = $resultPaymentCheck->num_rows;
              if($countPaymentCheck > 0 ){ ?>
             
			       <?php include("include_intl_vaccine_upload.php");?>
              <?php } else { ?>
              
              <form class="" method="POST" id="singleVisitorRegistration" autocomplete="off">

                <div class="row">

                  <div class="col-12 form-group">
                    <p style="color: red;font-weight: bold;font-size: 15px;" class="mb-0">"Please note : All the visitors visiting the exhibition should be fully vaccinated."</p>
                  </div>

                  <div class="col-md-4 form-group">
                    <label>I am interested to visit</label>
                    <select name="trade_show" id="trade_show" class="select-control">
                    <option value="IIJS SIGNATURE 2022">IIJS SIGNATURE 2022</option>
                    </select>
                  </div>

                  <div class="col-12 form-group">
                    <input type="checkbox" name="agree" value="YES" checked="">I also agree to receive information from GJEPC via Whatsapp & other Media 
                    <a data-fancybox data-src="#modals" href="javascript:;" class="agree-terms"></a>
                  </div>

                  <div class="col-12">
                    <input type="submit" name="submit" id="submit" value="Submit" class="btn btn-submit" >
                    <input type="hidden" name="action" value="singleVisitorRegistration">
                    <p id="addVisitor" class="fail"></p>
                  </div>
                        
                </div>
                    
                    
                
                
              </form>
			  
              <?php
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
    <div class="footer">
        <?php include ('footer.php'); ?>
      </div>
  </div>
  <!--footer ends-->
  <link rel="stylesheet" type="text/css" href="css/new_style.css" />
</body>
</html>
<?php 
include('header_include.php');
if(isset($_SESSION['USERID'])){ header("location:my_dashboard.php"); exit;	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Welcome to IIJS-SIGNATURE</title>
<link rel="icon" href="images/fav_icon.png" type="image/x-icon"/>
<link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Cabin'>
<link rel="stylesheet" type="text/css" href="https://gjepc.org/assets-new/css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="css/general.css?v=<?php echo $version;?>" />

<link rel="stylesheet" type="text/css" href="css/inner_pg_style.css?v=<?php echo $version;?>" />
<link rel="stylesheet" type="text/css" href="css/responsive.css?v=<?php echo $version;?>" />
<link rel="stylesheet" type="text/css" href="css/media_query.css?v=<?php echo $version;?>" />
<script type="text/javascript" src="js/jquery-1.8.3.min.js?v=<?php echo $version;?>"></script>

<!--NAV-->
<link href="css/flexnav.css?v=<?php echo $version;?>" media="screen, projection" rel="stylesheet" type="text/css">
<script type="text/javascript" src="flexnav-master/js/jquery.flexnav.min.js?v=<?php echo $version;?>"></script>
<script src="js/common.js"></script> 
<!--NAV-->
  
<!-- colorbox -->
<link media="screen" rel="stylesheet" href="css/colorbox.css?v=<?php echo $version;?>" />
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-178505237-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-178505237-1');
</script>
<!-- Global site tag (gtag.js) - Google Ads: 679056788 --> <!-- <script async src="https://www.googletagmanager.com/gtag/js?id=AW-679056788"></script> <script> window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag('js', new Date()); gtag('config', 'AW-679056788'); </script>  -->
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
<script src="js/jquery.colorbox-min.js?v=<?php echo $version;?>"></script>
<script>
	$(document).ready(function(){
		//Examples of how to assign the ColorBox event to elements
		$("a[rel='example1']").colorbox({transition:"elastic"});
		$(".example6").colorbox({iframe:true, innerWidth:640, innerHeight:480});
	});
</script>

<!-- UItoTop plugin -->
<link rel="stylesheet" type="text/css" media="screen,projection" href="css/ui.totop.css?v=<?php echo $version;?>" />
<script src="js/easing.js?v=<?php echo $version;?>" type="text/javascript"></script>
<script src="js/jquery.ui.totop.js?v=<?php echo $version;?>" type="text/javascript"></script>    
<script type="text/javascript">
    $(document).ready(function() {        
        $().UItoTop({ easingType: 'easeOutQuad' });        
    });
</script>
<script type="text/javascript">
	$(window).load(function() {
		$(".loader").fadeOut("slow");
	});
</script>
<style>
.loader{
    position: fixed;
    left: 0px;
    top: 0px;
    width: 100%;
    height: 100%;
    z-index: 9999;
    background: url(../images/logo.png) 50% 50% no-repeat rgb(255, 255, 255);
    opacity: 1;
  }
  .loader p{
    position: fixed;
    left: 45%;
    top: 58%;
    width: 100%;
    height: 100%;
    z-index: 9999;
    opacity: .80; 
  }
/*  .content_area{background: #1a1a1a}
  .login_box{margin: 0}*/
</style>
<script src="jsvalidation/jquery.validate.js" type="text/javascript"></script> 
<link rel="stylesheet" type="text/css" media="screen" href="css/rcmc.validation.css" /> 
<script type="text/javascript">
$().ready(function() {
	// validate the comment form when it is submitted
	$("#commentForm").validate();
	// validate signup form on keyup and submit
	$("#form1").validate({
		rules: {  
			email_id: {
				required: true,
				email:true
			},  
			password:{
				required: true,
			},
			captcha_code:{
				required: true,
			},
		},
		messages: {
			email_id: {
				required: "Please enter a valid email id",
			},
			password: {
				required: "Please enter your password",
			},
			captcha_code:{
				required: "Please enter captcha code",
		}
	 }
	});
});
</script>
<style type="text/css">
	.price_table{width: 100%;margin: 0; overflow:scroll;}
	.content_area table {
    width: 94%;
    margin-left: 3%;
    margin-right: 2%;
    margin-bottom: 10px;
    /* margin: 0px 18px 15px; */
}
/*.loginform{width: 100%;float: left;}*/
.box-shadow {
   width: 50%;
   margin-left: 50%;
   transform: translate(-50%);
}
.login_box {
  
   
    margin: 0 auto;

}
</style>


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
<div class="loader"><p>loading please wait....</p></div>
<div class="wrapper">

<div class="header"><?php include('header1.php'); ?></div>
<!--<div class="new_banner"><img src="https://registration.gjepc.org/images/iijs-virtual-1.jpg"/></div>-->


<div class="inner_container" style="padding-top:50px;">

<div class="bold_font text-center">
    <div class="d-block">
        <img src="https://www.gjepc.org/assets/images/gold_star.png" class="">
    </div>
   <?php if(isset($_REQUEST['visitor']) && $_REQUEST['visitor']=="international" ){?> 
           International Visitor Registration 
        <?php }else{?>
            Login
        <?php } ?>
</div>
    <div class="clear"></div>
    
    <div class="content_area">    
    
    <div class="clear"></div>

<!--<div class="price_table">
<table cellspacing="0"  border="1" >
<h3 style="padding: 15px 0px;border-bottom: 1px dotted #751c54;color: #751c54;margin: 20px;font-size: 18px ">Domestic Visitor Registration Details</h3>
    
    <tbody>
        <tr>
            <td rowspan="6" style="padding: 5px 5px;; line-height: 20px; background-color:white; text-align:center; vertical-align:middle; white-space:normal;"><strong>Visitor Profile</strong></td>
            <td rowspan="2" style="padding: 5px 5px; line-height: 20px; background-color:white; text-align:center; vertical-align:middle; white-space:normal;width: 20%"><strong>Criteria</strong></td>
            <td colspan="" style="padding: 5px 5px; line-height: 20px; text-align:center; vertical-align:middle; white-space:normal;"><strong>1 show</strong></td>  
            <td colspan="" style="padding: 5px 5px; line-height: 20px; text-align:center; vertical-align:middle; white-space:normal;"><strong>Combo</strong></td>
            <td colspan="" style="padding: 5px 5px; line-height: 20px; text-align:center; vertical-align:middle; white-space:normal;"><strong>4 show</strong></td>                     
        </tr>
        <tr>
            <td style="padding: 5px 5px; line-height: 20px; text-align:center; vertical-align:middle; white-space:normal;"><strong>Open For All Trade visitors Of Gem & Jewellery Industry</strong></td>
            <td style="padding: 5px 5px; line-height: 20px; text-align:center; vertical-align:middle; white-space:normal;"><strong>Open For All Trade visitors Of Gem & Jewellery Industry</strong></td>
            <td style="padding: 5px 5px; line-height: 20px; text-align:center; vertical-align:middle; white-space:normal;"><strong>Open For All Trade visitors Of Gem & Jewellery Industry</strong></td>             
        </tr>
        <tr>          
            <td  rowspan='4' style="padding: 5px 5px; line-height: 20px; text-align:center; vertical-align:middle; white-space:normal;"><strong>Registration Date for year 2020</strong></td>
            <td rowspan="4" style="padding: 5px 5px; line-height: 20px; text-align:center; vertical-align:middle; white-space:normal;"><strong>IIJS PREMIERE 2020 </strong></td>
                       
        </tr>
        <tr>
			<td style="padding: 5px 5px; line-height: 20px; text-align:center; vertical-align:middle; white-space:normal;"><strong>2020: IIJS PREMIERE</strong></td>
            <td style="padding: 5px 5px; line-height: 20px; text-align:center; vertical-align:middle; white-space:normal;"><strong>2020: IIJS PREMIERE</strong></td>
		</tr>
        <tr>
			<td rowspan='2' style="padding: 5px 5px; line-height: 20px; text-align:center; vertical-align:middle; white-space:normal;"><strong>2021: IIJS Signature</strong></td>
            <td style="padding: 5px 5px; line-height: 20px; text-align:center; vertical-align:middle; white-space:normal;"><strong>2021: IIJS Premiere & IIJS Signature</strong></td>
		</tr>
        <tr>
			<td style="padding: 5px 5px; line-height: 20px; text-align:center; vertical-align:middle; white-space:normal;"><strong>2022: IIJS  Signature</strong></td>   
        </tr>
        <tr>
            <td rowspan="3" style="padding: 5px 5px; line-height: 20px; background-color:white; text-align:center; vertical-align:middle; white-space:normal;"><strong>MEMBER FIRM OF GJEPC</strong></td>
            <td style="padding: 5px 5px; line-height: 20px; background-color:white; text-align:center; vertical-align:middle; white-space:normal;"><strong>16th March 2020 To 30th May 2020</strong></td>
            <td  style="padding: 5px 5px; line-height: 20px; text-align:center; vertical-align:middle; white-space:normal;"><strong>1,230</strong></td> 
			<td  style="padding: 5px 5px; line-height: 20px; text-align:center; vertical-align:middle; white-space:normal;"><strong>2,000</strong></td>
            <td  style="padding: 5px 5px; line-height: 20px; text-align:center; vertical-align:middle; white-space:normal;"><strong>3,700</strong></td>            
		</tr> 
		<tr>          
            <td style="padding: 5px 5px; line-height: 20px; background-color:white; text-align:center; vertical-align:middle; white-space:normal;"><strong>31st May 2020 To 10th July 2020</strong></td>
            <td  style="padding: 5px 5px; line-height: 20px; text-align:center; vertical-align:middle; white-space:normal;"><strong>2,460</strong></td> 
            <td  style="padding: 5px 5px; line-height: 20px; text-align:center; vertical-align:middle; white-space:normal;"><strong>3,300</strong></td> 
            <td  style="padding: 5px 5px; line-height: 20px; text-align:center; vertical-align:middle; white-space:normal;"><strong>5,000</strong></td>
		</tr>
        <tr>           
            <td style="padding: 5px 5px; line-height: 20px; background-color:white; text-align:center; vertical-align:middle; white-space:normal;"><strong>11th July 2020 To 10th August 2020</strong></td>
            <td  style="padding: 5px 5px; line-height: 20px; text-align:center; vertical-align:middle; white-space:normal;"><strong>4,100</strong></td> 
            <td  style="padding: 5px 5px; line-height: 20px; text-align:center; vertical-align:middle; white-space:normal;"><strong>4,800</strong></td> 
            <td  style="padding: 5px 5px; line-height: 20px; text-align:center; vertical-align:middle; white-space:normal;"><strong>6,800</strong></td>
		</tr>
        <tr>
            <td rowspan="3" style="padding: 5px 5px; line-height: 20px; background-color:white; text-align:center; vertical-align:middle; white-space:normal;"><strong>NON-MEMBER FIRM OF GJEPC</strong></td>
            <td style="padding: 5px 5px; line-height: 20px; background-color:white; text-align:center; vertical-align:middle; white-space:normal;"><strong>16th March 2020 To 30th May 2020</strong></td>
            <td  style="padding: 5px 5px; line-height: 20px; text-align:center; vertical-align:middle; white-space:normal;"><strong>1,500</strong></td> 
            <td  style="padding: 5px 5px; line-height: 20px; text-align:center; vertical-align:middle; white-space:normal;"><strong>2,500</strong></td>		 
            <td  style="padding: 5px 5px; line-height: 20px; text-align:center; vertical-align:middle; white-space:normal;"><strong>4,600</strong></td>
		</tr> 
		<tr>          
            <td style="padding: 5px 5px; line-height: 20px; background-color:white; text-align:center; vertical-align:middle; white-space:normal;"><strong>31st May 2020 To 10th July 2020</strong></td>
            <td  style="padding: 5px 5px; line-height: 20px; text-align:center; vertical-align:middle; white-space:normal;"><strong>3,000</strong></td>
            <td  style="padding: 5px 5px; line-height: 20px; text-align:center; vertical-align:middle; white-space:normal;"><strong>4,050</strong></td>		  
            <td  style="padding: 5px 5px; line-height: 20px; text-align:center; vertical-align:middle; white-space:normal;"><strong>6,050</strong></td>
		</tr>
        <tr>           
            <td style="padding: 5px 5px; line-height: 20px; background-color:white; text-align:center; vertical-align:middle; white-space:normal;"><strong>11th July 2020 To 10th August 2020</strong></td>
            <td  style="padding: 5px 5px; line-height: 20px; text-align:center; vertical-align:middle; white-space:normal;"><strong>5,000</strong></td>
            <td  style="padding: 5px 5px; line-height: 20px; text-align:center; vertical-align:middle; white-space:normal;"><strong>5,800</strong></td>  
            <td  style="padding: 5px 5px; line-height: 20px; text-align:center; vertical-align:middle; white-space:normal;"><strong>8,400</strong></td>
        </tr>
    </tbody>
</table>

</div>    --> 
<?php include('include_login.php'); ?>  

<div class="clear"></div>
</div>	
 
<div class="clear" style="height:10px;"></div>
</div>
<div class="footer"><?php include('footer.php'); ?><div class="clear"></div>
</div>

<div class="clear"></div>
</div>



</body>
</html>
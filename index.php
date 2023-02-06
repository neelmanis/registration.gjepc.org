<?php include('header_include.php');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Welcome to GJEPC  Registration</title>
	<link rel="icon" href="images/fav_icon_2.png" type="image/x-icon"/>
	<link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Cabin'>
	<link rel="stylesheet" type="text/css" href="css/general.css?v=<?php echo $version;?>" />
	<link rel="stylesheet" type="text/css" href="css/inner_pg_style.css?v=<?php echo $version;?>" />	 
	<link rel="stylesheet" type="text/css" href="css/responsive.css?v=<?php echo $version;?>" />
	<link rel="stylesheet" type="text/css" href="css/media_query.css?v=<?php echo $version;?>" />
	<script type="text/javascript" src="js/jquery-1.8.3.min.js?v=<?php echo $version;?>"></script>

	<!--NAV-->
	<link href="css/flexnav.css?v=<?php echo $version;?>" media="screen, projection" rel="stylesheet" type="text/css">
	<!--<script src="js/jquery.flexnav.js" type="text/javascript"></script>-->
	<script type="text/javascript" src="flexnav-master/js/jquery.flexnav.min.js?v=<?php echo $version;?>"></script>
	<script src="js/common.js?v=<?php echo $version;?>"></script> 
	<!--NAV-->
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
</head>

<body>
<div class="wrapper">
	<div class="header">
	<?php include('header1.php'); ?>
    <div class="clear"> </div>
	</div>
<div class="clear"> </div>
<div class="clear"> </div>

<div class="new_banner">
<img src="images/banners/banner.jpg">
</div>
<div class="clear"></div>
<!--container starts-->

<?php
date_default_timezone_set('Asia/Kolkata');
 $cr_date=date('d-m-Y H:i:s');
 $current_time=strtotime($cr_date).'<br>';

 $closetime = strtotime("27-07-2019 10:00:00");
?>
<div class="container_wrap">
  <div class="container">
    <div class="btnwrap"> 
    <button type="button" class="btnw col-sm-5 col-xs-12 reg_btn"  onclick="window.location.href='single_visitor.php';"/>Domestic  Registration </button>
<!--<button type="button" class="btnw col-sm-5 col-xs-12 reg_btn"  onclick="window.location.href='#';"/>  Registration Closed</button>-->
       
      <button type="button" class="btnw col-sm-5 col-xs-12 reg_btn" onclick="window.location.href='international_user_registration.php';"/>International  Registration </button>
      </div>
<style>
.sequal_logo_wrp {
		margin-top:20px; 
		border:1px solid #e0e0e0; 
		text-align:center; 
		padding:20px 0;
		}
.reg_btn{    
		background: #A59459;
		border: none;
		color: #fff;
		text-transform: uppercase;
		padding: 20px 15px;
		margin-right: 10px;
		width: 47.666667%;
		cursor: pointer;
		}
@media (max-width: 600px) {
  .reg_btn {width:100%; margin-bottom:15px;}
}
  
</style>  
  </div>
</div>
<div class="clear"></div>

<!--container ends-->
<!--footer starts-->
<div class="footer">
  <?php include ('footer.php'); ?>
<div class="clear"></div>
</div>
<!--footer ends-->
<link rel="stylesheet" type="text/css" href="css/new_style.css" />
</body>
</html>

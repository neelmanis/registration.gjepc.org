<?php include('header_include.php');
if(!isset($_SESSION['USERID'])){	header("location:login.php");	exit; }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title> OBMP</title>
<link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Cabin'>
<link rel="stylesheet" type="text/css" href="css/general.css?v=<?php echo $version;?>" />
<link rel="stylesheet" type="text/css" href="css/inner_pg_style.css?v=<?php echo $version;?>" />
 
<link rel="stylesheet" type="text/css" href="css/responsive.css?v=<?php echo $version;?>" />
<link rel="stylesheet" type="text/css" href="css/visitor_reg.css?v=<?php echo $version;?>" />
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
<script type="text/javascript">
    $(document).ready(function() {        
        $().UItoTop({ easingType: 'easeOutQuart' });        
    });
</script>

</head>

<body>
<div class="wrapper">
<div class="header">
	<?php include('header1.php'); ?>
</div>

<div class="new_banner">
<img src="images/banners/banner.jpg" />
</div>

<!--container starts-->
<div class="inner_container">
	<div class="breadcrum"><a href="index.php">Home</a> > OBMP </div>    
    <div class="clear"></div>    
    <div class="content_area">    
    <div class="pg_title">    
    <div class="title_cont">
        <span class="top">OBMP <img src="images/titles/joint.png" style="position:absolute; top:31px; right:0px;" /></span>   
        <div class="clear"></div>
    </div>    
    </div> 
			<div class="clear"></div>            
			<div class="clear"></div>            
            <div class="grayBlock">
            <p>Online OBMP program enables registered visitors to find and interact with exhibitors exhibiting at the trade show that match their business profile.</p>
            </div>

            <div class="grayBlock">            
			<h3>OBMP Profile</h3>            
            <p>View / Edit your OBMP company profile</p>   
            <div class="maroonBtn"><a href="obmp_profile.php" class="cta">Click here</a></div>            
            <div class="clear"></div>  
            </div>            
            
            <div class="grayBlock">            
			<h3>Product Catalogue</h3>            
            <p>You can upload / edit unlimited product images with detailed categorization and description for website users to view your product gallery.</p>            
            <div class="maroonBtn"><a href="product_catalogue.php" class="cta">Click here</a></div>            
            <div class="clear"></div>            
            </div>            
            
            <div class="grayBlock">            
			<h3>View Storefront</h3>            
            <p>An Online Virtual store where individual companies can display their product for them to receive enquiries which helps in promoting / branding and increase in sales.</p> 
            <div class="maroonBtn"><a href="view_store_front.php" class="cta">Click here</a></div>            
            <div class="clear"></div>         
            </div>
            
            <div class="grayBlock">            
            <h3>Advance Directory Search</h3>            
            <p>You can search companies according to business types and line of products they deal in. Search for companies dealing in diamonds or colourstones as per your needs.</p>            
            <div class="maroonBtn"><a href="directory_search.php" class="cta">Click here</a></div>            
            <div class="clear"></div>    
            </div>
            
            <div class="grayBlock">            
            <h3>My Enquires</h3>            
            <p>View enquiries you have received from companies and reply to it.</p>            
            <div class="maroonBtn"><a href="my_enquiry.php" class="cta">Click here</a></div>            
            <div class="clear"></div>    
            </div>
            
            <!--<div class="grayBlock">
            
        <h3>Sent Enquiries</h3>
            
            <p>View enquiries you have made to companies and enquiries your have received replies to.</p>
            
            
               <div class="maroonBtn"><a href="list_enquiries.php">Click here</a></div>
            
            <div class="clear"></div>
         
            
            </div>-->
            
            <!--<div class="grayBlock">
            
        <h3>My Appointments</h3>
            
            <p>Reply against appointment requests made to you by visitors.</p>
            
            
               <div class="maroonBtn"><a href="list_appointment.php">Click here</a></div>
            
            <div class="clear"></div>
         
            
            </div>-->

            </div>
			<div class="clear" style="height:10px;"></div>
          </div>
       
<!--container ends-->
<!--footer starts-->
<div class="footer">
	<?php include('footer.php'); ?>
<div class="clear"></div>
</div>
<div class="clear"></div>
</div>
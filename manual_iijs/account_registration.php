<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome to SIGNATURE</title>

<link rel="stylesheet" type="text/css" href="../css/mystyle.css" />

<!--navigation script-->
<script type="text/javascript" src="js/jquery_002.js"></script>
<!--<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>    -->  

<link rel="stylesheet" type="text/css" href="css/ddsmoothmenu.css" />

<script type="text/javascript" src="js/ddsmoothmenu.js">
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
	<script type="text/javascript" src="js/jquery.cycle.all.js"></script>

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



<link href="css/slider.css" rel="stylesheet" type="text/css" />

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
    	<img src="images/highlight_banner.jpg" />
    </div>
</div>
<!--banner ends-->

<div class="clear"></div>


<!--container starts-->
<div class="container_wrap">
	<div class="container">
    	<div class="container_left">
        	
            
        	
        	<span class="headtxt">My Signature - Registration</span>

            
          		
			<div id="loginForm">
            
            <!--<div class="userName">
            
            
            <div class="left">
            Welcome to <span>Username</span> 
            </div>
            
            <div class="rightButton"><a href="#">Logout</a></div>
            
            <div class="clear"></div>
            
            
            </div>-->
            
            <div id="formContainer">
            
            
            
            
             
              
              
                    <div class="title">
            <h4>Do you have any one of the following</h4>
            </div>
            
             <div class="clear"></div>
            <div class="borderBottom"></div>
            
            
             <div id="form">
            
            
            <div class="field">
            
            <input name="registration" type="radio"  />
            Privilege Visitor Registration Code
            
            
            </div>
            
            <div class="field">
            
            <label>Privilege Code :  </label>
            
            <input name="" type="text"  class="textField"/>
            
            </div>
            
            
            <div class="field">
            
            <input name="registration" type="radio"  />
            International Visitor's reference number sent by emailer
            
            
            </div>
            
            <div class="field">
            
            <label>Reference Number :  </label>
            
            <input name="" type="text"  class="textField"/>
            
            </div>
            
            <div class="field">
            
            <input name="registration" type="radio"  />
            New User
            
            
            </div>
            
                       
            
            <div class="field">
            
            <label></label>
            <a href="registration.php"><input name="input" type="submit"  class="submitButton" value="Procced to Registration"/></a>
            </div>
            
            
            </div>
            </div>
          
          
          </div>
           
            
        
        </div>
        
        
        <?php include ('rightContent.php'); ?>
       
      
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

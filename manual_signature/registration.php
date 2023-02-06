<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome to SIGNATURE</title>

<link rel="stylesheet" type="text/css" href="../css/mystyle.css" />

<!--navigation script-->
<script type="text/javascript" src="js/jquery_002.js"></script>
<!--<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>    -->  

<link rel="stylesheet" type="text/css" href="../css/ddsmoothmenu.css" />

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
        	
           
        	
        	<span class="headtxt">My Signature - Registration </span>

            
          		
			<div id="loginForm">
            
            <!--<div class="userName">
            
            
            <div class="left">
            Welcome to <span>Username</span> 
            </div>
            
            <div class="rightButton"><a href="#">Logout</a></div>
            
            <div class="clear"></div>
            
            
            </div>-->
            
            <div id="formContainer">
            


            
  <!--  <h3>Step 1 for National Privilege Visitor Registration</h3>-->
            
           
           
                       <div class="title">
            <h4>Account Information</h4>
            </div>
            
            <div class="clear"></div>
            
            <div class="borderBottom"></div>
            
            
            <div id="form">
            
            <div class="field">
            
            <label>E-mail :</label>
            
            <input name="" type="text"  class="textField"/>
            
            </div>
            
            <div class="field">
            
            <label>Confirm Email : <sup>*</sup></label>
            
            <input name="" type="text"  class="textField"/>
            
            </div>
            
       


            </div>
           
           
           
          <div class="bottomSpace"></div>
           
           
            
            <div class="title">
            <h4>Personal Information</h4>
            </div>
            
            <div class="clear"></div>
            
            <div class="borderBottom"></div>
            
            
            <div id="form">
            
            <div class="field">
            
            <label>Designation : </label>
            
            <input name="" type="text"  class="textField"/>
            
            </div>
            
            <div class="field">
            
            <label>First Name : </label>
            
            <input name="" type="text"  class="textField"/>
            
            </div>
            
            <div class="field">
            
            <label>Last Name : </label>
            
            <input name="" type="text"  class="textField"/>
            
            </div>
            
            
            
            <div class="field">
            
            <label>Company Name : </label>
            
            <input name="" type="text"  class="textField"/>
            
            </div>
            
            <div class="field">
            
            <div class="leftTitle">Address 1 : <sup>*</sup> </div>
            
           <textarea name="" cols="" rows="" class="textField"></textarea>
            
            </div>
            
            <div class="field">
            
            <div class="leftTitle">Address 2 : <sup>*</sup> </div>
            
           <textarea name="" cols="" rows="" class="textField"></textarea>
            
            </div>
            
            <div class="field">
            
            <div class="leftTitle">Address 3 : <sup>*</sup> </div>
            
           <textarea name="" cols="" rows="" class="textField"></textarea>
            
            </div>
            
            <div class="field">
            
            <label>City : <sup>*</sup></label>
            
            <input name="" type="text"  class="textField"/>
            
            </div>
            
            
            
            
            
            <div class="field">
            
            <label>State / Province : <sup>*</sup></label>
            
            <input name="" type="text"  class="textField"/>
            
            </div>
            
            <div class="field">
            
            <label>Country : <sup>*</sup></label>
            
            <input name="" type="text"  class="textField"/>
            
            </div>
            
            <div class="field">
            
            <label style="padding-top:0px;">Landline Number : <sup>*</sup></label>
            
            <input name="" type="text"  class="textField"/>
            
            <div class="clear"></div>
            
            </div>
            
            <div class="field">
            
            <label style="padding-top:0px;">Mobile Number : <sup>*</sup></label>
            
            <input name="" type="text"  class="textField"/>
            
            <div class="clear"></div>
            
            </div>
            
          <div class="bottomSpace"></div>
            
            <div class="title">
            <h4>Terms of Agreement</h4>
            </div>
            
            <div class="clear"></div>
            
            <div class="borderBottom"></div>
            
            
            <div class="body_text">These are the general terms and conditions of <b>Gems and Jewellery Export Promotion Council</b> (GJEPC) for use of the GJEPC web site. Please read these terms and conditions carefully as your use of the Site is subject to them. GJEPC reserves the right at its sole discretion to change, modify or add to these terms and conditions without prior notice to you. By continuing to use the Site you agree to be bound by such amended terms.
        <ol class="number">
        <li><strong>What you are allowed to do You may:</strong>
		<ol type="a"><li>browse the Site and view the information on it for personal, professional or other commercial purposes;</li>
		<li>print off pages from the Site to the extent reasonably necessary for your use of the Site in accordance with the above. Provided that at all times you do not do any of the things set out in clause 2.</li></ol></li>
        <li><strong>What you are not allowed to do Subject to these terms and conditions, you may not:</strong>
		<ol type="a"><li>systematically copy (whether by printing off onto paper, storing on disk or in any other way) substantial parts of the Site;</li>
		<li>remove, change or obscure in any way anything on the Site or otherwise use any material contained on the Site except as set out in these terms and conditions;</li>
		<li>include or create hyperlinks to the Site or any materials contained on the Site; or</li>
		<li>use the Site and anything available from the Site in order to produce any publication or otherwise provide any service that competes with the Site (whether on-line or by other media); or</li>
		<li>for unlawful purposes and you shall comply with all applicable laws, statutes and regulations at all times.</li></ol></li>
		<li><strong>No Investment Advice You acknowledge that:</strong>
		<ol type="a"><li>GJEPC does not provide investment advice and that nothing on the Site constitutes investment advice (as defined in the Financial Services Act 1986) and that you will not treat any of the Site's content as such;</li>
		<li>GJEPC does not recommend any financial product;</li>
		<li>GJEPC does not recommend that any financial product should be bought, sold or held by you; and</li>
		<li>nothing on the Site should be construed as an offer, nor the solicitation of an offer, to buy or sell securities by GJEPC</li>
		<li>information which may be referred to on the Site from time to time may not be suitable for you and that you should not make any investment decision without consulting a fully qualified financial adviser.</li></ol></li>
		<li><strong>Access The Site is directed exclusively at users located within the United Kingdom and as such any use of the site by users outside India is at their sole risk. By using the Site you confirm that you are located within India and that you are permitted by law to use the Site.</strong></li>
		<li><strong>Your personal information:</strong><br>
        GJEPC's use of your personal information is governed by GJEPC's Privacy Policy, which forms part of these terms and conditions.</li>
		<li><strong>Copyright and Trade Marks</strong>
<ol><li>All copyright and other intellectual property rights in any material (including text, photographs and other images and sound) contained in the Site is either owned by GJEPC or has been licensed to GJEPC by the rights owner(s) for use by GJEPC on the Site. You are only allowed to use the Site and the material contained in the Site as set out in these terms and conditions.</li>
		<li>The Site contains trade marks, including the GJEPC name and logo. All trade marks included on the Site belong to GJEPC or have been licensed to GJEPC by the trade mark owner(s) for use on the Site. You are not allowed to copy or otherwise use any of these trade marks in any way except as set out in these terms and conditions.</li></ol></li>
		<li><strong>Exclusions and limitations of liability</strong>
<ol><li>GJEPC does not exclude or limit its liability for death or personal injury resulting from its negligence, fraud or any other liability which may not by applicable law be excluded or limited.</li>
		<li>Subject to clause 7.1, in no event shall GJEPC be liable (whether for breach of contract, negligence or for any other reason) for (i) any loss of profits, (ii) exemplary or special damages, (iii) loss of sales, (iv) loss of revenue, (v) loss of goodwill, (vi) loss of any software or data, (vii) loss of bargain, (viii) loss of opportunity, (ix) loss of use of computer equipment, software or data, (x) loss of or waste of management or other staff time, or (xi) for any indirect, consequential or special loss, however arising.</li>
		</ol></li>
		<li><strong>Disclaimer</strong>
<ol><li>ALL INFORMATION CONTAINED ON THE SITE IS FOR GENERAL INFORMATIONAL USE ONLY AND SHOULD NOT BE RELIED UPON BY YOU IN MAKING ANY INVESTMENT DECISION. THE SITE DOES NOT PROVIDE INVESTMENT ADVICE AND NOTHING ON THE SITE SHOULD BE CONSTRUED AS BEING INVESTMENT ADVICE. BEFORE MAKING ANY INVESTMENT CHOICE YOU SHOULD ALWAYS CONSULT A FULLY QUALIFIED FINANCIAL ADVISER.</li>
		<li>ALTHOUGH GJEPC USES ITS REASONABLE EFFORTS TO ENSURE THAT INFORMATION ON THE SITE IS ACCURATE AND COMPLETE, WE CANNOT GUARANTEE THIS TO BE THE CASE. AS A RESULT, USE OF THE SITE IS AT YOUR SOLE RISK AND GJEPC CANNOT ACCEPT ANY LIABILITY FOR LOSS OR DAMAGE SUFFERED BY YOU ARISING FROM YOUR USE OF INFORMATION CONTAINED ON THE SITE. YOU SHOULD TAKE ADEQUATE STEPS TO VERIFY THE ACCURACY AND COMPLETENESS OF ANY INFORMATION CONTAINED ON THE SITE.</li>
		<li>Information contained on the site is not tailored for individual use and as a result such information may be unsuitable for you and your investment decisions. You should consult a financial adviser before making any investment decision.</li>
		<li>The Site includes advertisements and links to external sites and co-branded pages in order to provide you with access to information and services which you may find useful or interesting. GJEPC does not endorse such sites nor approve any content, information, goods or services provided by them and cannot accept any responsibility or liability for any loss or damage suffered by you as a result of your use of such sites.</li>
		<li>GJEPC is unable to exercise control over the security or content of information passing over the network or via the Service, and GJEPC hereby excludes all liability of any kind for the transmission or reception of infringing or unlawful information of whatever nature.</li>
		<li>GJEPC accepts no liability for loss or damage suffered by you as a result of accessing Site content which contains any virus or which has been maliciously corrupted.</li></ol></li>
		<li><strong>Availability and updating of the Site</strong>
<ol><li>GJEPC may suspend the operation of the Site for repair or maintenance work or in order to update or upgrade its content or functionality from time to time. GJEPC does not warrant that access to or use of the Site or of any sites or pages linked to it will be uninterrupted or error free.</li>
		<li>GJEPC may change the format and content of the Site at its sole discretion from time to time. You should refresh your browser each time you visit the Site to ensure that you access the most up to date version of the Site.</li></ol></li>
		<li><strong>Enquiries or complaints</strong><br>
		If you have any enquiries or complaints about the Site then please address them (within 30 days of such enquiry or complaint first arising) to :  email: info@gjepc.org</li>
		<li><strong>General and governing law</strong>
<ol><li>These terms and conditions form the entire understanding of the parties and supersede all previous agreements, understandings and representations relating to the subject matter. If any provision of these terms and conditions is found to be unenforceable, this shall not affect the validity of any other provision. GJEPC may delay enforcing its rights under these terms and conditions without losing them. You agree that GJEPC may sub-contract the performance of any of its obligations or may assign these terms and conditions or any of its rights or obligations without giving you notice.</li>
		<li>GJEPC will not be liable to you for any breach of these terms and conditions which arises because of any circumstances which GJEPC cannot reasonably be expected to control.</li>
		<li>These terms and conditions shall be governed and interpreted in accordance with Indian law, and you consent to the non-exclusive jurisdiction of the Indian courts.</li></ol></li>
		</ol></div>
            
<div class="form-item" id="edit-terms-checkbox-wrapper">
 <label class="option" for="edit-terms-checkbox"><input type="checkbox" name="terms_checkbox" id="edit-terms-checkbox" value="1" class="form-checkbox"> I have read and agreed to the 'Terms of Agreement' above.</label>
 
 <div class="clear"></div>
 
</div>


<div class="clear"></div>

<div class="maroonBtn"><a href="my_signature_iijs_dashboard.php">Create new account</a></div>
<div class="clear"></div>

            </div>
            
            
            
            </div>
            
            
            </div>
          
          
          
           
            
        
        </div>
        
        
        <?php include ('advertise.php'); ?>
       
      
        <div class="clear"></div>
        
    </div>
    
    <!--<div class="container_2">
    	<?php include ('container2.php'); ?>
    </div>-->
    
</div>
<!--container ends-->

<!--footer starts-->

<div class="footer_wrap">


<?php include ('footer.php'); ?>



</div>

<!--footer ends-->

</body>
</html>

<div class="head_main">
  <div class="logo_setup">
	<div class="logo"><a href="#"><img src="https://gjepc.org/emailer_gjepc/04.09.2020/iijs_virtual_white.jpg" title="GJEPC"/ class="logo_img" style="width: 100px;"></a></div>

    <div class="logo2">
      <a href="https://www.gjepc.org/"><img src="https://gjepc.org/images/gjepc_logon.png" title="GJEPC" style="width:140px;" class="logo_img"></a>
    </div>
  </div>
  
  <?php if(!isset($_SESSION['USERID'])){ ?>
  
  <div class="login_btn">
    <ul class="iijs-social">
      <li> <a href="https://www.facebook.com/GJEPC" target="_blank" class="fb"> </a> </li>
      <li> <a href="https://twitter.com/GJEPCIndia" target="_blank" class="tw"> </a></li>
      <li> <a href="https://www.instagram.com/gjepcindia/" target="_blank" class="insta"> </a></li>
      <li> <a href="https://www.linkedin.com/in/sabyaray/" target="_blank" class="link"> </a></li>
    </ul>
    
    <div class="language">
      <div id="google_translate_element" class="text-uppercase" data-toggle="tooltip" data-placement="bottom" title="Click For a Personalized Fit"> </div>
    </div>
    
    <div style="display:inline-block; vertical-align:top;">
      
      <a href="login.php">
        <picture>
          <source media="(max-width: 600px)" srcset="images/login-mb.png">
          <img src="images/login.png" title="Login"/>
        </picture>
      </a>
      <a href="registration_landing.php">
        <picture>
          <source media="(max-width: 600px)" srcset="images/register-mb.png">
          <img src="images/register.png" title="Login"/>
        </picture>
      </a>
    </div>
  </div>
  
  <?php } else { ?>
  <div class="login_btn_after">
    <span>Welcome &nbsp;<strong><a href="my_dashboard.php"><?php echo $_SESSION['COMPANYNAME'];?></a></strong> &nbsp;&nbsp;|&nbsp;&nbsp; <a href="logout.php">Logout</a> </span>
  </div>
  <?php } ?>
  
  <div style="clear:right;"></div>
  <div class="up_logos1">
    <div id="navigation">
      <div  class="navi">
        <div class="menu-button"> Menu  </div>
        <nav>
          <ul data-breakpoint="800" class="flexnav nav navigation-menu">
            <li><a  href="https://iijs-signature.org" target="_blank">Home</a></li>
            <!--<li>
              <a href="#">About Show</a>
              <ul>
                <li><a href="https://iijs-signature.org/show_details.php" target="_blank">Show Details</a></li>
                <li><a href="https://iijs-signature.org/council.php" target="_blank">The Council</a></li>
                <li><a href="https://iijs-signature.org/faqs.php" target="_blank">FAQs</a></li>
              </ul>
            </li>-->
			<li>
                <a href="#">For Exhibitor</a>
                <ul>
                  <li><a href="https://gjepc.org/iijs-premiere/assets/circular/Circular-for-IIJS-Virtual-show.html" target="_blank">Circular for Registration of Interest (ROI) of IIJS Virtual 2020</a></li>
                    <li><a href="https://gjepc.org/iijs-premiere/assets/circular/Circular-for-IIJS-Virtual-show-hindi.html" target="_blank" >Circular for Registration of Interest (ROI) of IIJS Virtual 2020 - Hindi</a></li>
                    <li><a href="https://forms.microsoft.com/Pages/ResponsePage.aspx?id=SFfXOEKTbkSJkyB6nZ4-HtfWy70eRilJpjEDL7NQplFUNFRNMUMwNkhGM0UwNjNZTEFJWVhHMjI3TC4u" target="_blank">Fill the Registration of Interest (ROI) form  for IIJS Virtual 2020 </a></li>
                </ul> 
            </li>
			  
            <li>
              <a href="#"> Visitor</a>
              <!--<ul>
                <li><a href="domestic_user_registration_step1.php">National Visitor Registration</a></li>                
                <li><a href="pdf/badge-descliamer-2018-2020.pdf" target="_blank">Badge Disclaimer 2018-2020</a></li>                
              </ul>-->
            </li> 
            <li>
              <a href="#"> Media</a>
              <!--<ul>
                <li><a href="domestic_user_registration_step1.php">National Visitor Registration</a></li>                
                <li><a href="pdf/badge-descliamer-2018-2020.pdf" target="_blank">Badge Disclaimer 2018-2020</a></li>                
              </ul>-->
             </li> 
        </nav>
        <div class="clear"></div>
      </div>
      <div class="clear"></div>
    </div>
  </div>
  
  <div style="clear:both;"> </div>
</div>
<style>
.titles {float: left; margin:20px 0 0 15px;}
.titles p{padding:0;margin: 0}
.line1{font-size: 12px}
.line2{font-size: 11px}
.language{margin-right:10px; float:left;width:80px;height:35px;background:#fff;border:1px solid #ccc;overflow:hidden;-webkit-border-radius:3px;-moz-border-radius:3px;border-radius:3px}#google_translate_element{border:0;background:transparent}#google_translate_element .goog-te-gadget{height:33px;padding:0}#google_translate_element .goog-te-gadget-simple{width:78px;height:33px;padding:0;border:0;font-size:13px;background:transparent}#google_translate_element .goog-te-gadget-simple>span{width:78px;display:inline-block}#google_translate_element .goog-te-menu-value{line-height:33px;color:#666;width:100%;display:block;position:relative;margin:0;padding:0 4px;text-align:left}#google_translate_element .goog-te-gadget-icon,.goog-te-menu-value img,.goog-te-menu-value span:nth-child(3){display:none}.goog-te-menu-value span:nth-child(5){font-size:10px!important;position:absolute;right:0;padding-right:4px;background:#fff}.goog-te-banner-frame.skiptranslate{display:none!important}
.iijs-social {float:left; margin:8px 12px 0 0;}
.iijs-social li {display:inline-block;}
.iijs-social li a {display:inline-block; width:16px; height:16px; margin:0 3px; transition:all 0.3s ease-in-out; -webkit-transition:all 0.3s ease-in-out; -moz-transition:all 0.3s ease-in-out; -o-transition:all 0.3s ease-in-out;}
.iijs-social li a.fb {background:url("../images/iijs-fb.png") no-repeat;}
.iijs-social li a.tw {background:url("../images/iijs-tw.png") no-repeat;}
.iijs-social li a.insta {background:url("../images/iijs-insta.png") no-repeat;}
.iijs-social li a.link {background:url("../images/iijs-link.png") no-repeat;}
.iijs-social li a:hover {transition:all 0.3s ease-in-out; -webkit-transition:all 0.3s ease-in-out; -moz-transition:all 0.3s ease-in-out; -o-transition:all 0.3s ease-in-out;}
.iijs-social li a.fb:hover {background:url("../images/iijs-fb-hvr.png") no-repeat;}
.iijs-social li a.tw:hover {background:url("../images/iijs-tw-hvr.png") no-repeat;}
.iijs-social li a.insta:hover {background:url("../images/iijs-insta-hvr.png") no-repeat;}
.iijs-social li a.link:hover {background:url("../images/iijs-link-hvr.png") no-repeat;}
.login_btn a {display:inline-block;}
@media (max-width:600px)
{
.login_btn {text-align:center; display:table; width:100%;}
.iijs-social {display:inline-block; float:none; vertical-align:top;}
.language {float:none; display:inline-block;}
}
</style>
<script type="text/javascript">
/* for third level navigation*/
jQuery(document).ready(function($) {
//  console.log("Ready");
jQuery("li.item-with-ul").hover(function() {
$("ul.flexnav-show").css('overflow','visible');
//alert("hdjfhdf");
}, function() {
/* Stuff to do when the mouse leaves the element */
});
});
</script>
<script>
function googleTranslateElementInit() {new google.translate.TranslateElement({pageLanguage:'en',includedLanguages:'hi,en,gu',layout:google.translate.TranslateElement.InlineLayout.SIMPLE },'google_translate_element');}
$(window).bind("load",function(){$("span:first",".goog-te-menu-value").text('English');})
</script>
<script src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
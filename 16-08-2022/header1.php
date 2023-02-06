<?php 
$sql_evt = "SELECT * FROM `visitor_event_master` WHERE `status` ='1' AND `isParentShow`='1' ";
$result_evt = $conn->query($sql_evt);
$count_evt = $result_evt->num_rows;
if($count_evt > 0){
   $row_evt = $result_evt->fetch_assoc();
   $evt_logo = $row_evt['logo'];
   $evt_name = $row_evt['event_name'];
   $evt_term_condition_file = $row_evt['term_condition_file'];
}?>


<div class="head_main">

	<div class="logo_setup">
    <?php if(isset($evt_logo)){ ?>
      <div class="logo pr-3"><a href="#"><img src="images/logo/<?php echo $evt_logo; ?>" class="logo_img"></a></div>
    <?php }?>


    <div class="logo2">
      <a href="https://www.gjepc.org/"><img src="images/logo.png" title="GJEPC" style="width:140px;" class="logo_img"></a>
    </div>
  </div>
	<div class="headLeft">
    <ul class="iijs-social">
     <li><a href="https://www.facebook.com/GJEPC" class="facebook" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
            <li><a href="https://twitter.com/GJEPCIndia" class="twitter" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
            <li><a href="https://www.instagram.com/gjepcindia/?hl=en" class="instagram" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
            <li><a href="https://www.linkedin.com/in/sabyaray/" class="linkedin" target="_blank"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
    </ul>
    
    <table class="contact_no">
                      <tbody>
                        <tr>
                          <td>Toll Free</td>
                          <td><a href="tel:18001034353">1800-103-4353</a></td>
                        </tr>
                        <tr>
                          <td>Missed Call</td>
                          <td><a href="tel:917208048100">91-7208048100</a></td>
                        </tr>
                        <div class="clear"></div>
                      </tbody>
                    </table>
    </div>

  
  
  <?php if(isset($_SESSION['USERID'])){ ?>
 
  <div class="login_btn_after">  
  <div class="d-flex">  
  <div class="text-center">
    <span>Welcome <strong><a href="my_dashboard.php"><?php echo $_SESSION['COMPANYNAME'];?></a></strong> </span>  <br /> <br />
    <a href="change_password.php" style="font-size:14px;">Change Password</a> </div>    
    <div> &nbsp; &nbsp; | &nbsp; &nbsp;<a href="logout.php">Logout</a></div>    
   <span></span>   
   </div>    
  </div>
  <?php }else if(isset($_SESSION['AGENCYID'])){?>
  <div class="login_btn_after">  
  <div class="d-flex">  
  <div class="text-center">
    <span>Welcome <strong><a href="vendor-agency-dashboard.php"><?php echo $_SESSION['COMPANYNAME'];?></a></strong> </span>  </div>    
    <div> &nbsp; &nbsp; | &nbsp; &nbsp;<a href="logout.php">Logout</a></div>    
   <span></span>   
   </div>    
  </div>
  <?php } else { ?>
   <div class="headRight">
    <div class="login_btn">
      <a href="login.php">
        LOGIN
      </a>
      <a href="registration_landing.php">
        NEW REGISTRATION
      </a>
   
  </div>
     <div class="language">
      <div id="google_translate_element" class="text-uppercase" data-toggle="tooltip" data-placement="bottom" title="Click For a Personalized Fit"> </div>
    </div>
  </div>
  <?php } ?>
  
  <div style="clear:right;"></div>
  <div class="up_logos1">
    <div id="navigation">
      <div  class="navi">
        <div class="menu-button"> Menu  </div>
        <nav>
          <ul data-breakpoint="800" class="flexnav nav navigation-menu new_menu">
            <li><a href="https://gjepc.org/iijs-premiere/">Home</a></li>
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
             <!--    <ul> -->
               
                  
                   <!--   <li><a href="https://gjepc.org/emailer_gjepc/28.11.2020/index.html" target="_blank" class="d-block"> Circular for Stall Booking at the 2nd edition of “IIJS Virtual 2.0 </a></li> -->
                 <!--  <li><a href="https://gjepc.org/emailer_gjepc/21.10.2021/index2.html" target="_blank" class="d-block"> Circular for Opening of Stall booking at 14th edition of IIJS Signature 2022</a></li> -->

                  
                    <!--<li><a href="https://gjepc.org/iijs-premiere/assets/circular/Circular-for-IIJS-Virtual-show-hindi.html" target="_blank" >Circular for Registration of Interest (ROI) of IIJS Virtual 2020 - Hindi</a></li>
                    <li><a href="https://forms.microsoft.com/Pages/ResponsePage.aspx?id=SFfXOEKTbkSJkyB6nZ4-HtfWy70eRilJpjEDL7NQplFUNFRNMUMwNkhGM0UwNjNZTEFJWVhHMjI3TC4u" target="_blank">Fill the Registration of Interest (ROI) form  for IIJS Virtual 2020 </a></li>-->
               <!--  </ul>  -->

               <ul>
                <li><li><a href="https://gjepc.org/emailer_gjepc/01.05.2022/index.html" target="_blank" class="d-block ">Circular for Opening of Stall Booking of IIJS Premiere 2022, IIJS Signature 2023 &amp; IIJS Tritiya 2023 </a></li></li>
              </ul>
            </li>
			  
            <li>
              <a href="#"> For Visitor</a>
              <ul>
                <!-- <li><a href="https://registration.gjepc.org/international_visitor_photo_update.php"  class="d-block">International Badge Generate Link <span class="blink">Live...</span> </a></li> -->
                <li><a href="https://registration.gjepc.org/visitor_badge.php"  class="d-block">Domestic Visitor Badge <span class="blink">Live...</span> </a></li>
                <li><a href="https://registration.gjepc.org/international_visitor_badge.php"  class="d-block">International Visitor Badge <span class="blink">Live...</span> </a></li>
                <li><a href="https://registration.gjepc.org/single_visitor.php"  class="d-block">Domestic Visitor Registration <span class="blink">Live...</span> </a></li>
                <li><a href="https://registration.gjepc.org/international_visitor_event_registration.php"  class="d-block">International Visitor Registration <span class="blink">Live...</span> </a></li>                
                <!-- <li><a href="pdf/badge-descliamer-2018-2020.pdf" target="_blank">Badge Disclaimer 2018-2020</a></li>                   -->
                
              </ul>

             <!--  <ul>
                <li><a href="https://gjepc.org/emailer_gjepc/29.04.2022/02/index.html" target="_blank">Introduction Multiple Visitor Registration Package For IIJS Shows Commencing From Iijs Premier 2022– 4-8 August 2022 – BEC, mumbai</a></li>
              </ul> -->
            </li> 
            <!--<li>
              <a href="#"> Media</a>
              <ul>
                <li><a href="domestic_user_registration_step1.php">National Visitor Registration</a></li>                
                <li><a href="pdf/badge-descliamer-2018-2020.pdf" target="_blank">Badge Disclaimer 2018-2020</a></li>                
              </ul>
             </li>  -->
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
.language{/* margin-right:10px; *//* float:left; */width:80px;/* height:35px; */background:#fff;border-bottom: 1px solid #ccc;overflow:hidden;-webkit-border-radius:3px;-moz-border-radius:3px;/* border-radius:3px; */}#google_translate_element{border:0;background:transparent}#google_translate_element .goog-te-gadget{height:33px;padding:0}#google_translate_element .goog-te-gadget-simple{width:78px;height:33px;padding:0;border:0;font-size:13px;background:transparent}#google_translate_element .goog-te-gadget-simple>span{width:78px;display:inline-block}#google_translate_element .goog-te-menu-value{line-height:33px;color:#666;width:100%;display:block;position:relative;margin:0;padding:0 4px;text-align:left}#google_translate_element .goog-te-gadget-icon,.goog-te-menu-value img,.goog-te-menu-value span:nth-child(3){display:none}.goog-te-menu-value span:nth-child(5){font-size:10px!important;position:absolute;right:0;padding-right:4px;background:#fff}.goog-te-banner-frame.skiptranslate{display:none!important}
#google_translate_element{border:0;background:transparent}#google_translate_element .goog-te-gadget{height:33px;padding:0}#google_translate_element .goog-te-gadget-simple{width:78px;height:33px;padding:0;border:0;font-size:13px;background:transparent}#google_translate_element .goog-te-gadget-simple>span{width:78px;display:inline-block}#google_translate_element .goog-te-menu-value{line-height:33px;color:#666;width:100%;display:block;position:relative;margin:0;padding:0 4px;text-align:left}#google_translate_element .goog-te-gadget-icon,.goog-te-menu-value img,.goog-te-menu-value span:nth-child(3){display:none}.goog-te-menu-value span:nth-child(5){font-size:10px!important;position:absolute;right:0;padding-right:4px;background:#fff}.goog-te-banner-frame.skiptranslate{display:none!important}
.headLeft {position:absolute; top:15px;}
.iijs-social {margin-bottom:10px;}
.iijs-social li {display:inline-block; margin-right:15px;}
.iijs-social li a {display:inline-block; width:16px; height:16px; margin:0 3px; transition:all 0.3s ease-in-out; -webkit-transition:all 0.3s ease-in-out; -moz-transition:all 0.3s ease-in-out; -o-transition:all 0.3s ease-in-out;}

.iijs-social li a:hover {color:#a89c5d; transition:all 0.3s ease-in-out; -webkit-transition:all 0.3s ease-in-out; -moz-transition:all 0.3s ease-in-out; -o-transition:all 0.3s ease-in-out;}

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

<script src="https://gjepc.org/assets-new/js/FontAwesome.js"></script> 
<script>
function googleTranslateElementInit() {new google.translate.TranslateElement({pageLanguage:'en',includedLanguages:'hi,en,gu',layout:google.translate.TranslateElement.InlineLayout.SIMPLE },'google_translate_element');}
$(window).bind("load",function(){$("span:first",".goog-te-menu-value").text('English');})
</script>
<script src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

<link rel="stylesheet" type="text/css" href="css/fonts.css?v=<?php echo $version;?>" />


<link rel="stylesheet" type="text/css" href="css/kalpesh.css?v=<?php echo $version;?>" />

<?php include('header_include.php');
if(!isset($_SESSION['USERID'])){
		header("location:login.php");
		exit;
	}

?>
<?php 
$registration_id=$_SESSION['USERID'];
$member_registration=$conn->query("select * from member_directory where registration_id='$registration_id'");
$member_registration_num=$member_registration->num_rows;
if($member_registration_num==0){
$_SESSION['msg']="Please register first in member directory";
header('location:obmp.php');
exit;
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome to SIGNATURE</title>
<link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Cabin'>
<link rel="stylesheet" type="text/css" href="css/general.css?v=<?php echo $version;?>" />
<link rel="stylesheet" type="text/css" href="css/inner_pg_style.css?v=<?php echo $version;?>" />
 
<link rel="stylesheet" type="text/css" href="css/responsive.css?v=<?php echo $version;?>" />
<link rel="stylesheet" type="text/css" href="css/visitor_reg.css?v=<?php echo $version;?>" />
<link rel="stylesheet" type="text/css" href="css/media_query.css?v=<?php echo $version;?>" />

<!--navigation script-->
<script type="text/javascript" src="js/jquery_002.js"></script>
<!--NAV-->
<link href="css/flexnav.css?v=<?php echo $version;?>" media="screen, projection" rel="stylesheet" type="text/css">
<script src="js/jquery.flexnav.js?v=<?php echo $version;?>" type="text/javascript"></script>
<script src="js/common.js?v=<?php echo $version;?>"></script> 
<!--NAV-->

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

<!-- Tab-->

<script>
$(document).ready(function() {
	$("#content div").hide(); // Initially hide all content
	$("#tabs li:first").attr("id","current"); // Activate first tab
	$("#content div:first").fadeIn(); // Show first tab content
    
    $('#tabs a').click(function(e) {
        e.preventDefault();        
        $("#content div").hide(); //Hide all content
        $("#tabs li").attr("id",""); //Reset id's
        $(this).parent().attr("id","current"); // Activate this
        $('#' + $(this).attr('title')).fadeIn(); // Show content for current tab
    });
})();
</script>
<!-- Tab-->

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
	<div class="breadcrum"><a href="index.php">Home</a> > OBMP > My Enquiry</div>    
    <div class="clear"></div>
    
    <div class="content_area">    
    <div class="pg_title">    
    <div class="title_cont">
        <span class="top">OBMP <img src="images/titles/joint.png" style="position:absolute; top:31px; right:0px;" /></span>   
        <span class="below">My Enquiry List</span>
        <div class="clear"></div>
    </div>    
    </div> 
    <div class="clear"></div>
       <div id="loginForm">
<div id="formContainer">
			
          <div class="clear"></div>  
              <div id="received_enquiry">
              <div class="midletext">
<div  class="padding_width_head" style="margin-left:0px;">
<ul id="tabs">
    <li><a href="#" title="tab1">Send Enquiry</a></li>
    <li><a href="#" title="tab2" class="lastBg">Recieved Enquiry</a></li>  
</ul>
</div>

<div id="content" style=" border:0px;"> 
<div id="tab1">
<table width="100%" border="1" align="left" bordercolor="#e0e0e0" cellpadding="2" cellspacing="2" style="border-collapse: collapse; margin-left:0px;" >

  <tr bgcolor="#F0F0F0">
    <td width="4%" height="25" align="center"><strong> No.</strong></td>
    <td width="26%" align="center"><strong>Comapny Name </strong></td>
    <td width="15%" align="center"><strong>Date and Time</strong></td>
    <td width="24%" align="center"><strong>Description</strong></td>
    <td width="16%" align="center"><strong>Contact Person</strong></td>
    <td width="15%" align="center"><strong>Products Interested In</strong></td>
  </tr>
<?php 
  		/*............................Send Enquiry....................................*/
	   $i=1;
       $sendenquiry=$conn->query("select * from obmp_enquiries where from_uid='$registration_id'");
	   $num_enquiry=$sendenquiry->num_rows;;
	   if($num_enquiry>0){
	   
  	   while($rsendenquiry=$sendenquiry->fetch_assoc()){
  ?> 
  <tr>
    <td width="4%" height="25" align="center" valign="top"  style="padding:5px;"><?php echo $i;?></td>
    <td valign="top" style="padding:5px;"><?php echo stripslashes($rsendenquiry['from_company_name']);?></td>
    <td align="center" valign="top"  style="padding:5px;"><?php echo $rsendenquiry['created'];?></td>
    <td align="left" valign="top"  style="padding:5px;"><?php echo stripslashes($rsendenquiry['enquiry_description']);?></td>
    <td align="center" valign="top"  style="padding:5px;"><?php echo stripslashes($rsendenquiry['from_contact_person']);?></td>
    <td align="center" valign="top"  style="padding:5px;"><?php echo stripslashes($rsendenquiry['product_interested']);?></td>
  </tr>

<?php $i++;}} else{?>
<tr><td colspan="6">No record found</td></tr>
<?php }?>

</table>

</div>
    
    
<div id="tab2">
  <table width="100%" border="1" align="left" bordercolor="#e0e0e0" cellpadding="2" cellspacing="3" style="border-collapse: collapse; margin-left:0px;" >
  <tr bgcolor="#F0F0F0">
    <td width="4%" height="25" align="center"><strong> No.</strong></td>
    <td width="26%" align="center"><strong>Company Name </strong></td>
    <td width="15%" align="center"><strong>Date and Time</strong></td>
    <td width="24%" align="center"><strong>Description</strong></td>
    <td width="16%" align="center"><strong>Contact Person</strong></td>
    <td width="15%" align="center"><strong>Products Interested In</strong></td>
  </tr>
  <?php 
  		/*............................Recieved Enquiry....................................*/
	   $j=1;
       $rec_enquiry=$conn->query("select * from obmp_enquiries where to_uid='$registration_id'");
	   $num_rec_enquiry=$rec_enquiry->num_rows;
	   if($num_rec_enquiry>0){
  	   while($result_rec_enquiry= $rec_enquiry->fetch_assoc()){
  ?>
  <tr>
    <td width="4%" height="25" align="center" valign="top"  style="padding:5px;"><?php echo $j;?></td>
    <td valign="top" style="padding:5px;"><?php echo $result_rec_enquiry['to_company_name'];?></td>
    <td align="center" valign="top"  style="padding:5px;"><?php echo $result_rec_enquiry['created'];?></td>
    <td align="left" valign="top"  style="padding:5px;"><?php echo $result_rec_enquiry['enquiry_description'];?></td>
    <td align="center" valign="top"  style="padding:5px;"><?php echo $result_rec_enquiry['to_contact_person'];?></td>
    <td align="center" valign="top"  style="padding:5px;"><?php echo $result_rec_enquiry['product_interested'];?></td>
   </tr>

  <?php $j++;}} else {?>
 <tr><td colspan="6">No record found</td></tr>
  <?php }?>
 
</table>
</div>

</div>
<div class="clear"></div>
</div>
 <div class="clear"></div>
       </div>
     </div>
    </div>
 </div>
<div class="clear"></div>
</div>
</div>
<!--container ends-->
<!--footer starts-->
<div class="footer">
	<?php include('footer.php'); ?>
<div class="clear"></div>
</div>

<div class="clear"></div>
</div>

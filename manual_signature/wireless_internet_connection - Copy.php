<?php 
include('header_include.php');
if(!isset($_SESSION['EXHIBITOR_CODE']))
{
	header("location:index.php");
	exit;
}
?>

<?php
$exhibitor_code=$_SESSION['EXHIBITOR_CODE'];

$exhibitor_data="select * from iijs_exhibitor where Exhibitor_Code='$exhibitor_code'";
$result=mysql_query($exhibitor_data);
$fetch_data=mysql_fetch_array($result);

$Exhibitor_Name=$fetch_data['Exhibitor_Name'];
$Exhibitor_Contact_Person=$fetch_data['Exhibitor_Contact_Person'];
$Exhibitor_Phone=$fetch_data['Exhibitor_Phone'];
$Exhibitor_Fax=$fetch_data['Exhibitor_Fax'];

$Exhibitor_HallNo=$fetch_data['Exhibitor_HallNo'];
$Exhibitor_Region=$fetch_data['Exhibitor_Region'];
$Exhibitor_Section=$fetch_data['Exhibitor_Section'];
$Exhibitor_Area=$fetch_data['Exhibitor_Area'];
$Exhibitor_DivisionNo=$fetch_data['Exhibitor_DivisionNo'];
$Exhibitor_StallType=$fetch_data['Exhibitor_StallType'];
$Exhibitor_Address1=$fetch_data['Exhibitor_Address1'];
$Exhibitor_Address2=$fetch_data['Exhibitor_Address2'];
$Exhibitor_Address3=$fetch_data['Exhibitor_Address3'];
$Exhibitor_Email=$fetch_data['Exhibitor_Email'];
$Exhibitor_Email1=$fetch_data['Exhibitor_Email1'];
$Exhibitor_Pincode=$fetch_data['Exhibitor_Pincode'];
$Exhibitor_State=$fetch_data['Exhibitor_State'];
$Exhibitor_Country_ID=$fetch_data['Exhibitor_Country_ID'];
$Exhibitor_City=$fetch_data['Exhibitor_City'];
$Exhibitor_Website=$fetch_data['Exhibitor_Website'];

$wireless_data="select * from iijs_wirelessinternet where Exhibitor_Code='$exhibitor_code'";
$result_wireless=mysql_query($wireless_data);
$fetch_wireless=mysql_fetch_array($result_wireless);

$subscription=$fetch_wireless['subscription'];
$Items_Approved=$fetch_wireless['Items_Approved'];
$Items_Reason=$fetch_wireless['Items_Reason'];
$Application_Complete=$fetch_wireless['Application_Complete'];
$got_wifi_ordered = explode(", ", $fetch_wireless['wifi_ordered']);
$got_wifi_ordered1 = $fetch_wireless['wifi_ordered'];
$Create_Date=$fetch_wireless['Create_Date'];

$num=mysql_num_rows($result_wireless);


if(isset($_POST['submit']))
{ 
	$subscription=$_POST['subscription'];
	if($subscription=='Y')
		$subscription='Y';
	else
		$subscription='N';
	
	$ordered_wifi = implode(", ", $_POST['get_wifi']);
	
	$sql_update="update iijs_wirelessinternet set subscription='$subscription',Items_Approved='P',Items_Reason='',wifi_ordered='$ordered_wifi' where Exhibitor_Code='$exhibitor_code'";
	
	$sql_insert="insert into iijs_wirelessinternet set Exhibitor_Code='$exhibitor_code',wifi_ordered='$ordered_wifi',Create_Date=NOW(),Modify_Date=NOW(),subscription='$subscription'";
	
	if($num>0)
	{
		if(!mysql_query($sql_update))
			echo "error ".mysql_error();
	}
	else
	{
		if(!mysql_query($sql_insert))
			echo "error ".mysql_error();
		/*.......................................Send mail to users mail id...............................................*/
		 $message ='<table width="96%" bgcolor="#fbfbfb" style="margin:2% auto; border:2px solid #ddd; font-family:Arial, sans-serif; color:#333333; font-size:13px; border-radius:10px;">
		
		<tr>
		<td style="padding:30px;">
		<table width="100%" border="0px" background="#fbfbfb" cellpadding="0px" cellspacing="0px">
		
		<tr>
		<td align="left" height="60px"><img src="http://iijs-signature.org/images/logo.png" border="0" width="230" /></td>
		<td align="right" height="60px"><img src="http://iijs-signature.org/images/gjepc_logo.png" width="120" border="0"/></td>
		</tr>		
		
		<tr>
		<td></td>
		<td align="right"></td>
		</tr>
		
		<tr>
		<td align="right" colspan="2" height="30px"><hr /></td>
		</tr>
		
		<tr>
		<td colspan="2" style="font-size:13px; line-height:22px;">
		<p>Dear <strong>'.$Exhibitor_Contact_Person.',</strong> </p>
		<p>Company Name: <strong>'.$Exhibitor_Name.'</strong> </p>
		<p>Thank  you for applying Online for <strong>Form No. 5. WIRELESS INTERNET CONNECTION</strong>. Please note your  application is under approval process. </p>
		<p>All the applicant members will have to send the  requisite payment along with the print acknowledgement receipt which will be  available after successful submission of online application with company seal  in 4 working days from date of online submission.</p>
		<p>A  system generated notification will be sent to you on successful  approval/Disapproval of your application</p>
		<p>Kind regards, <br />
		<strong>Signature Web Team,</strong>
		</p>
		</td>
		</tr>
	
		<tr>
		<td colspan="2" align="center" style="font-size:13px; line-height:22px;">    
		</td>
		</tr>
		</table>
		</td>
		
		<map name="Map" id="Map"><area shape="rect" coords="0,0,185,67" href="http://www.iijs-signature.org/"  target="_blank" style="outline:none;"/><area shape="rect" coords="82,58,83,71" href="#" /></map>
		<map name="Map2" id="Map2"><area shape="rect" coords="2,0,312,68" href="http://www.gjepc.org/"  target="_blank" style="outline:none;" /></map>
		
		</tr>
		
		</table>';
		
		//$to =$Exhibitor_Email.',notification@gjepcindia.com';
		$to ='bhavin@gjepcindia.com';
		$subject = "Signature 2017 Exhibitor Manual - Form No. 5. WIRELESS INTERNET CONNECTION"; 
		$headers  = 'MIME-Version: 1.0' . "\r\n"; 
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"; 
		$headers .= 'From:admin@gjepc.org';			
		mail($to, $subject, $message, $headers);
	}	
	
	header("location:list.php");							
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome to SIGNATURE</title>

<link rel="stylesheet" type="text/css" href="../css/mystyle.css" />

<!--navigation script-->
<script type="text/javascript" src="../js/jquery_002.js"></script>

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

<!--  SLIDER ends  -->

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

<!-------------------fancybox----------------->
	<script type="text/javascript" src="../fancybox/jquery.fancybox-1.3.4.pack.js"></script>
	<link rel="stylesheet" type="text/css" href="../fancybox/jquery.fancybox-1.3.4.css" media="screen" />
 	<link rel="stylesheet" href="../css/style.css" />
	<script type="text/javascript">
		$(document).ready(function() {
			
			$(".example2").fancybox({
				'overlayShow'	: true,
				'transitionIn'	: 'elastic',
				'transitionOut'	: 'elastic'
			});
			
			$("a[rel=example_group]").fancybox({
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'titlePosition' 	: 'over',
				'titleFormat'		: function(title, currentArray, currentIndex, currentOpts) {
					return '<span id="fancybox-title-over">Image ' + (currentIndex + 1) + ' / ' + currentArray.length + (title.length ? ' &nbsp; ' + title : '') + '</span>';
				}
			});

		});
	</script>
 <!--fancybox ends-->
<script language="javascript">
function validation()
{
	if( $('input[name="subscription"]:checked').length==0)
	{
		alert("Please Check subscribe box");
		return false;
	}
	
}
</script>
<!--manual form css-->
<link rel="stylesheet" type="text/css" href="../css/manual.css"/>

<style>
.tooltip {
    position: relative;
    display: inline-block;
    border-bottom: 1px dotted black;
    padding: 5px 30px;
    background-color: #d661aa;
}

.tooltip .tooltiptext {
    visibility: hidden;
    width: 600px;
    background-color: #d661aa;
    color: #fff;
    text-align: left;
    border-radius: 6px;
    padding: 5px 0;
    position: absolute;
    z-index: 1;
    top: 350%;
    right: -50%;
    margin-left: -60px;
    opacity: 0;
    transition: opacity 1s;
}

.tooltip .tooltiptext::after {
    content: "";
    position: absolute;
    top: -64%;
    left: 93%;
    margin-left: -60px;
    border-width: 50px;
    border-style: solid;
    border-color: #d661aa transparent transparent transparent;
	transform: rotate(180deg);
}

.tooltip:hover .tooltiptext {
    visibility: visible;
    opacity: 1;
}

#formWrapper{width:100%;}
#formWrapper > h3{float:left;}

#formWrapper .spanbox{
    padding: 8px 20px;
    background-color: #d661aa;	
}

.tooltip{float:right;}

.bigTextField { width: 100%; height: 110px; }
</style>
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

<div class="container_wrap">
<div class="container" id="manualFormContainer">
<h1>Online Manual </h1>

<div id="formWrapper">
<h3>Wired Internet Connection</h3>

<span style="margin-left:40%;" class="spanbox">Deadline : <strong>21st Dec 2016</strong></span>

<div class="tooltip"><strong>Note</strong>
<span class="tooltiptext">
<ol class="numeric">
<li>This form is mandatory for entry in the Exhibitor Catalogue for information purpose.</li>
<li>If write-up is not received by 21st December 2015, then only the data given in the application form for stall booking by the exhibitor will be used.</li>
<li>If you fail to upload the company profile, product picture &amp; logo of your company then the SIGNATURE 2016 will be published or will be kept blank in your picture field of Exhibitor Catalogue.</li>
</ol>
</span>
</div>

<form name="catalogue_entry" id="form1" action="wireless_internet_connection.php" method="post" onsubmit="return validation()">
<div class="clear"></div>
<p><strong>Wireless Internet (wi-fi) connections will be provided Complimentary to each exhibitor who will be applying to the council within 21st December 2017.</strong></p>
<p>
  <input type="checkbox" name="subscription" id="subscription" value="Y" <?php if(preg_match('/Y/',$subscription)){ echo ' checked="checked"'; } ?> <?php if($Items_Approved=='Y' || $Items_Approved=='P') {echo 'disabled=disabled';} ?>/>
  <input type="hidden" name="status" value="subscribe" />
 <strong> I want to subscribe for Complimentary Wireless Connection </strong></p>


<h2>Exhibitor Information</h2>
<table border="0" cellspacing="0" cellpadding="0" class="formManual">
  <tr>
    <td class="bold">Exhibitor Name</td>
    <td>:</td>
    <td><?php echo $Exhibitor_Name;?></td>
    <td width="50">&nbsp;</td>
    <td class="bold">Contact Person</td>
    <td>:</td>
    <td><?php echo $Exhibitor_Contact_Person;?></td>
  </tr>
  <tr>
    <td class="bold">Stall No(s)</td>
    <td>:</td>
    <td><?php echo $stall_no;?></td>
    <td>&nbsp;</td>
    <td class="bold">Hall No</td>
    <td>:</td>
    <td><?php echo $Exhibitor_HallNo;?></td>
  </tr>
  <tr>
    <td class="bold">Zone</td>
    <td>:</td>
    <td><?php echo $Exhibitor_DivisionNo; ?></td>
    <td>&nbsp;</td>
    <td class="bold">Region</td>
    <td>:</td>
    <td><?php echo $Exhibitor_Region;?></td>
  </tr>
  <tr>
    <td class="bold">Section</td>
    <td>:</td>
    <td><?php echo $Exhibitor_Section; ?></td>
    <td>&nbsp;</td>
    <td class="bold">Area</td>
    <td>:</td>
    <td><?php echo $Exhibitor_Area; ?></td>
  </tr>
</table>
<div class="clear"></div>

<table border="2" class="formManual">
      <thead>
        <tr>
          <th>Sr. No.</th>
          <th>Particulars</th>
          <th>Charges</th>
          <th>Select WIFI</th>
        </tr>
      </thead>
<?php
$sqlx="SELECT `id`, `description`, `charges` FROM `iijs_wifi_master` WHERE status='1'";
$resultx=mysql_query($sqlx);
while($rowx=mysql_fetch_array($resultx))
{ ?>
			<tr>
              <td><?php echo $rowx['id'];?></td>
              <td><?php echo $rowx['description'];?></td>
              <td><?php echo $rowx['charges'];?></td>
              <td><?php if($Items_Approved=='N' || $Items_Approved==''){ ?>
				<input type="checkbox" name="get_wifi[]" value="<?php echo $rowx['id'];?>">
			  <?php } else { ?>
			  <input type="checkbox" name="get_wifi[]" value="<?php echo $rowx['id'];?>" 
			  <?php if(in_array($rowx['id'], $got_wifi_ordered)) {	echo 'checked="checked"'; echo 'disabled="disabled"'; } else { echo 'disabled="disabled"';} ?> >
			  <?php } ?>
			  </td>
			</tr>
<?php 
}
?>

</table>
<div class="clear"></div>

<?php
if(!empty($got_wifi_ordered1)){
$sqlx="SELECT `id`, SUM(charges) as total FROM `iijs_wifi_master` WHERE id IN ($got_wifi_ordered1)";
$resultx=mysql_query($sqlx);
$rowy=mysql_fetch_array($resultx);
$urTotal=$rowy['total'];
?>
<table border="1" class="formManual">
      <thead>
        <tr>
          <th>Total Charges</th>
          <th><?php echo $urTotal;?> Rs.</th>
        </tr>
      </thead>
</table>
<?php }  ?>

<div class="clear"></div>
	  
<div align="center">
	  <?php if($Items_Approved=='N' || $Items_Approved==''){ ?>
      <input name="submit" type="submit" value="Submit" class="maroon_btn"/>
      <?php } else {?>
      <a href="list.php"><input name="input2" type="button" value="Back To List" class="maroon_btn" /></a>
	  <?php }?>
</div>
</form>
</div>
<div class="clear">	
</div>

</div>
</div>
<div class="footer_wrap">
<?php include ('footer.php'); ?>
</div>
</body>
</html>

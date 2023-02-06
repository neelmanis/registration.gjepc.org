<?php 
include('header_include.php');
if(!isset($_SESSION['EXHIBITOR_CODE']))
{
header("location:index.php");	exit;
}	
?>
<?php
$exhibitor_code=$_SESSION['EXHIBITOR_CODE'];
$exhibitor_data="select * from iijs_exhibitor where Exhibitor_Code='$exhibitor_code'";
$result=mysql_query($exhibitor_data);
$fetch_data=mysql_fetch_array($result);
$Exhibitor_Area=$fetch_data['Exhibitor_Area'];
$Exhibitor_Country_ID=$fetch_data['Exhibitor_Country_ID'];
$Exhibitor_DivisionNo=$fetch_data['Exhibitor_DivisionNo'];
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
<script type="text/javascript" src="../js/ddsmoothmenu.js"></script>
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
	<script type="text/javascript">
	function Safe()
	{		
		if(confirm("Are You sure you want to apply safe rental"))
			return true;
		else
			return false;
	}
	function Strong()
	{
		if(confirm("Are You sure you want to apply strong room"))
			return true;
		else
			return false;
	}
	</script>
 <!--fancybox ends-->
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
<div class="clear"></div>
<div class="container_wrap">
<div class="container">
<h1>Online Manual </h1>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" ><img src="images/pending_apply.png"  alt="" /> </td>
    <td >Application Pending to Apply </td>
    <td align="center"><img src="images/pending.png" alt="" /> </td>
    <td >Action Pending from Admin</td>
	<td align="center"><img src="images/red_cross.png"  alt="" /></td>
    <td>Application Disapproved</td>
  </tr>
  <tr>    
	<td height="40" align="center"><img src="images/correct.png"  alt="" /></td>
    <td> Application Approved</td>
	<td align="center"><img src="images/pdf_icon.png" alt="" /></td>
    <td>PDF</td>
	<td align="center">&nbsp;</td>
    <td><a href="images/pdf/SIGNATURE_IIJS_2018_EXMANUAL_v1.pdf" target="_blank" style="padding:10px;border:1px solid #FF0000;background:#999999;color:#FFFFFF;">Download Exhibitor Manual PDF</a></td>
  </tr>
<div class="clear"></div>
</table>

<h3> Zone Manager Detail</h3>
<?php
$sql_manager = "select * from zone_manager where division='$Exhibitor_DivisionNo' and status='1'";
$query_manager = mysql_query($sql_manager);
$result_manager = mysql_fetch_array($query_manager);
//print_r($result_manager);
?>

<table id="example" class="display" cellspacing="0" border="1" width="100%">
        <thead style="font-family:verdana; color:#fff; background-color:#924b77">
            <tr>                
				<th>Division</th>
				<th>Zone Manager</th>
				<th>Email Id</th>
				<th>Contact No</th>
            </tr>
        </thead>       
        <tbody>
            <tr>
                <td><?php echo trim($result_manager['division']);?></td>
                <td><?php echo trim($result_manager['zone_manager']);?></td>
                <td><?php echo trim($result_manager['email']);?></td>
                <td><?php echo trim($result_manager['mobile']);?></td>
            </tr>            
		</tbody>
</table>
<br/>
<div class="clear"></div>

<table cellpadding="0" cellspacing="0" class="common" border="1" width="100%">
<tbody>
<tr>
    <th>FORM NO.</th>
    <th>FORM NAME</th>
	<th>FORM DETAILS</th>
    <th>START DATE</th>
    <th>DEADLINE</th>
    <th>STATUS</th>
</tr>
<!--- Start COMPULSORY CATALOGUE ENTRY -->
<tr>
    <td>FORM NO.1</td>
    <td><?php echo "<a href='compulsory_catalogue_entry.php'>COMPULSORY CATALOGUE ENTRY</a>";?></td>
    <td>Submit Online only</td>
    <td>10-01-2018</td>
	<td><?php echo getFormDeadLine(1);?></td>
    <td class="centerAlign">
	<?php
	$app_status=getApplicationStatus("iijs_catalog");
	if($app_status=="application" )
		echo "<img src='images/pending_apply.png'  alt='' />";
	else
	{
		if($app_status=='Y')
			echo "<img src='images/correct.png'  alt='' />";
		else if($app_status=='N')
			echo "<img src='images/red_cross.png'  alt='' />";
		else 
			echo "<img src='images/pending.png'  alt='' />";
	}
    ?>
    </td>
</tr>
<!--- End COMPULSORY CATALOGUE ENTRY -->

<!--- Start EXHIBITOR BADGES -->
<tr>
    <td >FORM NO.2</td>
    <td >
    <?php 
	$app_status=getApplicationStatus("iijs_badge");
	if($app_status=="P" || $app_status=="N" || $app_status=="Y")
	{
		echo "<a href='exhibitors_badges.php'>EXHIBITOR BADGES</a>";
	}else
	{
		echo "<a href='exhibitors_badges.php'>EXHIBITOR BADGES</a>";
		//echo "<a href='#' onClick='alert('Deadline is over form can not be accesssed');return false'>EXHIBITOR BADGES / CAR PASSES FORM</a>";		
	}
	?>
    <td>Online Form </td>
    <td>10-01-2018</td>
    <td><?php echo getFormDeadLine(2);?></td>
    <td class="centerAlign">
	<?php
	$app_status=getApplicationStatus("iijs_badge");
	if($app_status=="application" )
		echo "<img src='images/pending_apply.png'  alt='' />";
	else
	{
		if($app_status=='Y')
			echo "<img src='images/correct.png'  alt='' />";
		else if($app_status=='N')
			echo "<img src='images/red_cross.png'  alt='' />";
		else 
			echo "<img src='images/pending.png'  alt='' />";
	}
    ?>
	</td>
</tr>

<!--- End EXHIBITOR BADGES -->

<!--- Start STANDFITTING SERVICES -->
<tr>
    <td>FORM NO.3</td>
    <td>
    <?php 
		echo "<a href='standfitting_services.php'>STANDFITTING SERVICES</a>";
	?>
    </td>
    <td>Submit Online & Payment with print acnowledgement to GJEPC</td>
    <td>10-01-2018</td>
	<td><?php echo getFormDeadLine(3);?></td>
    <td class="centerAlign">
    <?php
	$app_status=getApplicationStatus("iijs_stand");
	if($app_status=="application" )
		echo "<img src='images/pending_apply.png'  alt='' />";
	else
	{
		if($app_status=='Y')
			echo "<img src='images/correct.png'  alt='' />";
		else if($app_status=='N')
			echo "<img src='images/red_cross.png'  alt='' />";
		else 
			echo "<img src='images/pending.png'  alt='' />";
	}
    ?>
    </td>
</tr>
<!--- End STANDFITTING SERVICES -->

<!--- Start STALL LAYOUT -->
<tr>
    <td>FORM NO.4</td>
    <td>
    <?php 
		echo "<a href='stall_layout.php'>STALL LAYOUT</a>";
	?></td>
    <td>Submit Online only</td>
    <td>10-01-2018</td>
	<td><?php echo getFormDeadLine(4);?></td>
    <td class="centerAlign">
	<?php
	$app_status=getApplicationStatus("iijs_stall_master");
	if($app_status=="application" )
		echo "<img src='images/pending_apply.png'  alt='' />";
	else
	{
		if($app_status=='Y')
			echo "<img src='images/correct.png'  alt='' />";
		else if($app_status=='N')
			echo "<img src='images/red_cross.png'  alt='' />";
		else 
			echo "<img src='images/pending.png'  alt='' />";
	}
    ?></td>
</tr>
<!--- End STALL LAYOUT -->     

<!--- Start Safe Leasing Facility | Strong Room Facility -->
<tr>
    <td rowspan="2">FORM NO.5</td>
    <td rowspan="2">
    <?php //echo $Exhibitor_Area;
    if($Exhibitor_Area==9 || $Exhibitor_Area==18){?>
	<?php 
	$app_status=getApplicationStatus("iijs_safe_rental");
	$app_status1=getApplicationStatus("iijs_strongroom");
	if($app_status=="P" || $app_status=="N" || $app_status=="Y")
		{
			echo "<a href='safe_rental_or_indemnity_bond_form.php'>SAFE RENTAL</a><br/>";
		}
		elseif($app_status1=="P" || $app_status1=="N" || $app_status1=="Y")
		{			
			echo "<a href='strong_room_facility.php?auth=admin'>STRONG ROOM</a>"; 
		}
		else
		{
			echo "<a href='safe_rental_or_indemnity_bond_form.php' onclick='Safe();'>SAFE RENTAL</a><br/>";
			echo " <a href='strong_room_facility.php?auth=admin' onclick='Strong();'>STRONG ROOM</a><br/>";
		} 
	/*
	if($app_status=="P" || $app_status=="N" || $app_status=="Y")
	{
		echo "<a href='safe_rental_or_indemnity_bond_form.php'>SAFE RENTAL</a><br/>";
	}
	elseif($app_status1=="P" || $app_status1=="N" || $app_status1=="Y")
	{
		echo "<a href='strong_room_facility.php'> STRONG ROOM</a>";
	}
	else
	{
		echo "<a href='safe_rental_or_indemnity_bond_form.php' onclick='Safe();'>SAFE RENTAL</a><br/>";
		echo "<a href='strong_room_facility.php' onclick='Strong();'> STRONG ROOM</a>";
	} */
	?>
	<?php } else {?>
		<a href='safe_rental_or_indemnity_bond_form.php?auth=admin'>SAFE RENTAL</a>
	<?php }?>
    </td>
    
    <td>Online & Print Phase 1</td>
    <td>10-01-2018</td>
    <td><?php echo getFormDeadLine(5);?></td>
    <td class="centerAlign">
    <?php
    $app_status=getApplicationStatus("iijs_safe_rental");
    if($app_status=="application" )
        echo "<img src='images/pending_apply.png'  alt='' />";
    else
    {
        if($app_status=='Y')
            echo "<img src='images/correct.png'  alt='' />";
        else if($app_status=='N')
            echo "<img src='images/red_cross.png'  alt='' />";
        else 
            echo "<img src='images/pending.png'  alt='' />";
    }
    ?>    </td>
</tr>

<tr>
    <td>Online & Print Phase 2</td>
    <td>15-01-2018</td>
    <td>20-01-2018</td>
    <td class="centerAlign"></td>
</tr> 

<!--- End Safe Leasing Facility | Strong Room Facility -->

<!--- Start Safe Leasing Facility | Strong Room Facility -->
<?php /*
if($Exhibitor_Area==9){?>
<tr>
    <td>FORM NO.5</td>
    <td><?php echo "<a href='strong_room_facility.php'>STRONG ROOM</a>";?></td>
    <td>Submit Online only</td>
    <td>10-01-2018</td>
	<td><?php echo getFormDeadLine(4);?></td>
    <td class="centerAlign">
	<?php
	$app_status1=getApplicationStatus("iijs_strongroom");
	if($app_status1=="application")
			echo "<img src='images/pending_apply.png'  alt='' />";
		else
		{
			if($app_status1=='Y')
				echo "<img src='images/correct.png'  alt='' />";
			else if($app_status=='N')
				echo "<img src='images/red_cross.png'  alt='' />";
			else 
				echo "<img src='images/pending.png'  alt='' />";
		}	
    ?>
	</td>
	
</tr>
<?php } else { ?>

<tr>
    <td rowspan="2">FORM NO.5</td>
    <td rowspan="2"><a href='safe_rental_or_indemnity_bond_form.php'>SAFE RENTAL</a></td> 
     <td>Online & Print Phase 1</td>
    <td>10-01-2018</td>
    <td><?php echo getFormDeadLine(5);?></td>
    <td class="centerAlign">
    <?php
    $app_status=getApplicationStatus("iijs_safe_rental");
    
		if($app_status=="application" )
			echo "<img src='images/pending_apply.png'  alt='' />";
		else
		{
			if($app_status=='Y')
				echo "<img src='images/correct.png'  alt='' />";
			else if($app_status=='N')
				echo "<img src='images/red_cross.png'  alt='' />";
			else 
				echo "<img src='images/pending.png'  alt='' />";
		}    
	?>
    </td>	
</tr>
<tr>
    <td>Online & Print Phase 2</td>
    <td>15-01-2018</td>
    <td>20-01-2018</td>
    <td class="centerAlign">
    <?php
    $app_status=getApplicationStatus("iijs_safe_rental");
    if($app_status=="application" )
        echo "<img src='images/pending_apply.png'  alt='' />";
    else
    {
        if($app_status=='Y')
            echo "<img src='images/correct.png'  alt='' />";
        else if($app_status=='N')
            echo "<img src='images/red_cross.png'  alt='' />";
        else 
            echo "<img src='images/pending.png'  alt='' />";
    }
    ?>    </td>
</tr>
<?php } */?>
<!--- End Safe Leasing Facility | Strong Room Facility -->

<!--- Start Stand Cleaning Services (House Keeping) -->
<tr>
    <td>FORM NO.6</td>
    <td>
    <?php
		echo "<a href='housekeeping.php'>STAND CLEANING SERVICES (HOUSE KEEPING)</a>";
	?>
    </td>
    <td width="30%">Submit Online & Payment with print acnowledgement to GJEPC</td>
    <td>10-01-2018</td>
	<td><?php echo getFormDeadLine(6);?></td>
    <td class="centerAlign">
    <?php
    $app_status=getApplicationStatus("iijs_housekeeping");
    if($app_status=="application" )
        echo "<img src='images/pending_apply.png'  alt='' />";
    else
    {
        if($app_status=='Y')
            echo "<img src='images/correct.png'  alt='' />";
        else if($app_status=='N')
            echo "<img src='images/red_cross.png'  alt='' />";
        else 
            echo "<img src='images/pending.png'  alt='' />";
    }
    ?>
    </td>
</tr>
<!--- End Stand Cleaning Services (House Keeping) -->

<!--- Start Wired Internet Connection (LAN) -->
<tr>
    <td>FORM NO.7</td>
    <td>
    <?php 
		echo "<a href='wireless_internet_connection.php'>WIRED INTERNET CONNECTION</a>";
	?>
    </td>
    <td>Submit Online only</td>
    <td>10-01-2018</td>
	<td><?php echo getFormDeadLine(7);?></td>
    <td class="centerAlign">
	<?php
    $app_status=getApplicationStatus("iijs_wirelessinternet");
    if($app_status=="application" )
        echo "<img src='images/pending_apply.png'  alt='' />";
    else
    {
        if($app_status=='Y')
            echo "<img src='images/correct.png'  alt='' />";
        else if($app_status=='N')
            echo "<img src='images/red_cross.png'  alt='' />";
        else 
            echo "<img src='images/pending.png'  alt='' />";
    }
    ?>
    </td>
</tr>
<!--- End Wired Internet Connection (LAN) -->	

<!--- Start Electronic Surveillance -->			
<tr>
    <td>FORM NO.8</td>
    <td>
	<a href="electronic_surveillance.php">ELECTRONIC SURVEILLANCE</a>
    <?php 
		//echo "ELECTRONIC SURVEILLANC (Coming Soon)";
		//echo "<a href='electronic_surveillance.php'>ELECTRONIC SURVEILLANCE</a>";
	?>
    </td>
    <td>Submit Online & Payment with print acnowledgement to Vendor</td>
    <td>10-01-2018</td>
    <td><?php echo getFormDeadLine(8);?></td>
    <td class="centerAlign">
    <?php
    $app_status=getApplicationStatus("iijs_cctv");
    if($app_status=="application" )
        echo "<img src='images/pending_apply.png'  alt='' />";
    else
    {
        if($app_status=='Y')
            echo "<img src='images/correct.png'  alt='' />";
        else if($app_status=='N')
            echo "<img src='images/red_cross.png'  alt='' />";
        else 
            echo "<img src='images/pending.png'  alt='' />";
    }
    ?>
    </td>
</tr>
<!--- End Electronic Surveillance -->        

<!--- Strat UNDERTAKING OF JEWELLERY FINENESS -->
<tr>
    <td>FORM NO.9</td>
    <td><a href="images/pdf/Jewellery_Fineness_Certificate.pdf" target="_blank">UNDERTAKING OF JEWELLERY FINENESS</a></td>
    <td>PDF Download Print & Submit to GJEPC</td>
    <td>10-01-2018</td>
	<td><?php echo getFormDeadLine(9);?></td>
    <td class="centerAlign"><img src="images/pdf_icon.png" alt="" /></td>
</tr>
<!--- End UNDERTAKING OF JEWELLERY FINENESS -->

<!--- Start Stall Allotment Letter -->
 <tr>
    <td>FORM NO.10</td>
    <td>
    <?php if(getApplicationStatus("iijs_stall_master")=='Y'){?>
    <a href='print_acknowledge/stall_allotment_letter.php' target="_blank">STALL ALLOTMENT LETTER</a>
    <?php } else {?>
    <a href='#' onClick="alert('Stall allotment letter will be available after approval of form no. 4 Stall layout');return false">STALL ALLOTMENT LETTER</a>
    <?php }?>
    </td>
	<td></td>
    <td>10-01-2018</td>
    <td><?php echo getFormDeadLine(10);?></td>
    <td class="centerAlign"><img src="images/pdf_icon.png" alt="" /></td>
</tr>
<!--- End Stall Allotment Letter -->

<!--- Start xhibitor Clearance -->
<tr>
    <td>FORM NO.11</td>
    <td><a href="images/pdf/Exhibitor_Clearance_SIGNATURE_IIJS_2018.pdf" target="_blank">EXHIBITOR CLEARANCE</a></td>
    <td>PDF Download Print & Submit to GJEPC</td>
    <td>10-01-2018</td>
	<td><?php echo getFormDeadLine(11);?></td>
    <td class="centerAlign"><img src="images/pdf_icon.png" alt="" /></td>
</tr>
<!--- End Exhibitor Clearance -->


 <!--     
<tr>
    <td>FORM NO.10</td>
    <td>
    <?php
		echo "<a href='floral_plant_rental.php'>FLORAL / PLANT RENTAL</a>";
	?>
    </td>
    <td>Submit Online & Payment with print acnowledgement to Vendor</td>
    <td>20-11-2015</td>
	<td><?php echo getFormDeadLine(10);?></td>
    <td class="centerAlign">
    <?php
    $app_status=getApplicationStatus("iijs_floral");
    if($app_status=="application" )
        echo "<img src='images/pending_apply.png'  alt='' />";
    else
    {
        if($app_status=='Y')
            echo "<img src='images/correct.png'  alt='' />";
        else if($app_status=='N')
            echo "<img src='images/red_cross.png'  alt='' />";
        else 
            echo "<img src='images/pending.png'  alt='' />";
    }
    ?>
    </td>
</tr>
        
            
<tr>
    <td>FORM NO.11</td>
    <td>
    <?php 
		echo "<a href='car_hire_reservations.php'>CAR HIRE RESERVATION REQUEST FORM</a>";
	?>
    </td>
    <td>Submit Online only</td>
    <td>20-11-2015</td>
	<td><?php echo getFormDeadLine(11);?></td>
    <td class="centerAlign">
    <?php
    $app_status=getApplicationStatus("iijs_car_hire");
    if($app_status=="application" )
        echo "<img src='images/pending_apply.png'  alt='' />";
    else
    {
        if($app_status=='Y')
            echo "<img src='images/correct.png'  alt='' />";
        else if($app_status=='N')
            echo "<img src='images/red_cross.png'  alt='' />";
        else 
            echo "<img src='images/pending.png'  alt='' />";
    }
    ?>
    </td>
</tr>
            
<tr>
    <td>FORM NO.12</td>
    <td>
    <?php 
		echo "<a href='hotel_reservations.php'>HOTEL RESERVATIONS</a>";
	?>
    </td>
    <td>Submit Online only</td>
    <td>20-11-2015</td>
	<td><?php echo getFormDeadLine(12);?></td>
    <td class="centerAlign">
    <?php
    $app_status=getApplicationStatus("hotel_registration_details");
    if($app_status=="application" )
        echo "<img src='images/pending_apply.png'  alt='' />";
    else
    {
        if($app_status=='Y')
            echo "<img src='images/correct.png'  alt='' />";
        else if($app_status=='N')
            echo "<img src='images/red_cross.png'  alt='' />";
        else 
            echo "<img src='images/pending.png'  alt='' />";
    }
    ?>
    </td>
</tr>
            
            
<tr>
    <td>FORM NO.13</td>
    <td>
    <?php 
		echo "<a href='visa_application_asst.php'>VISA APPLICATION ASSISTANCE</a>";
	?>
    </td>
    <td>Submit Online only</td>
    <td>20-11-2015</td>
	<td><?php echo getFormDeadLine(13);?></td>
    <td class="centerAlign">
    <?php
    $app_status=getApplicationStatus("iijs_visa_application");
    if($app_status=="application" )
        echo "<img src='images/pending_apply.png'  alt='' />";
    else
    {
        if($app_status=='Y')
            echo "<img src='images/correct.png'  alt='' />";
        else if($app_status=='N')
            echo "<img src='images/red_cross.png'  alt='' />";
        else 
            echo "<img src='images/pending.png'  alt='' />";
    }
    ?>
    </td>
</tr>
            
            
<tr>
    <td>FORM NO.14</td>
    <td><a href="images/pdf/R_Form.pdf" target="_blank">'R' FORM FOR OCTROI</a></td>
    <td>PDF Download Print</td>
    <td>20-11-2015</td>
	<td><?php echo getFormDeadLine(14);?></td>
    <td class="centerAlign"><img src="images/pdf_icon.png" alt="" /></td>
    
</tr>
-->          
        
</tbody>
</table>
<div class="clear"></div>

</div>
</div>
<div class="footer_wrap">
<?php include ('footer.php'); ?>
</div>
<!--footer ends-->
</body>
</html>

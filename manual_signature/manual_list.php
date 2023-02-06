<?php 
include('header_include.php');
if(!isset($_SESSION['EXHIBITOR_CODE'])){ header("location:index.php");	exit; }	
?>
<?php
$exhibitor_code = $_SESSION['EXHIBITOR_CODE'];
$exhibitor_data = "select * from iijs_exhibitor where Exhibitor_Code='$exhibitor_code'";
$result = $conn ->query($exhibitor_data);
$fetch_data = $result->fetch_assoc();
$Exhibitor_Area=$fetch_data['Exhibitor_Area'];
$Exhibitor_Country_ID=$fetch_data['Exhibitor_Country_ID'];
$Exhibitor_DivisionNo=$fetch_data['Exhibitor_DivisionNo'];
$Exhibitor_Section = $fetch_data['Exhibitor_Section'];
$specific_area = $fetch_data['specific_area'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome to SIGNATURE</title>
<link rel="shortcut icon" href="https://gjepc.org/assets/images/fav_icon.png">
<link rel="stylesheet" type="text/css" href="css/mystyle.css"/>
<!--navigation script-->
<script type="text/javascript" src="../js/jquery_002.js"></script>
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
	<script>
	function something()
	{		
		if(confirm("Under Maintenance will be live at 3 O'clock"))
			return true;
	}
	function coming()
	{		
		if(confirm("Coming soon"))
			return true;
	}
	
	function Fineness(id)
	{
		if(confirm("Submit hard copy to GJEPC Office"))
		{
			if(id == 1){
				Exhibitor_Code = $('#Exhibitor_Code').val();
				$.ajax({ type: 'POST',
					url: 'finenes_ajax.php',
					data: "actiontype=addFines&Exhibitor_Code="+Exhibitor_Code,
					dataType:'html',
					beforeSend: function(){
							},
					success: function(data){
							console.log(data);
							window.location.href = 'https://registration.gjepc.org/manual_signature/images/pdf/Jewellery_Fineness_Certificate_SIG_2023.pdf';
				return true;
							/*var data=data.split("#");
							$('#Charges').val(data[0]);
							$('#paymentDiv').html(data[1]);*/
							//location.href = "exhibitors_badges.php"							
							}
				});
					
			}
			
		} else {
			window.location.href = ('');
			return false;
		}
	}
	</script>

 <!--fancybox ends-->
<!--manual form css-->
<link rel="stylesheet" type="text/css" href="../css/manual.css"/>
<style>
	.loader {
    position: fixed;
    left: 0px;
    top: 0px;
    width: 100%;
    height: 100%;
    z-index: 9999;
    background: url('images/progress.gif') 50% 50% no-repeat rgb(249,249,249);
    opacity: .80;
	}
	.loader p{
	position: fixed;
    left: 45%;
    top: 58%;
    width: 100%;
    height: 100%;
    z-index: 9999;
    opacity: .80;	
	}	
    @-webkit-keyframes blinker {
        from {opacity: 1.0;}
        to {opacity: 0.0;}
    }
    .blink{
        color:#fff;
        text-decoration: blink;
        -webkit-animation-name: blinker;
        -webkit-animation-duration: 0.6s;
        -webkit-animation-iteration-count:infinite;
        -webkit-animation-timing-function:ease-in-out;
        -webkit-animation-direction: alternate;
    }
</style>
	
<script type="text/javascript">
	$(window).load(function() {
		$(".loader").fadeOut("slow");
	});
</script>
</head>
<body>
<div class="loader"><p>Manual loading please wait....</p></div>
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
    <td align="center" width="30px"><img src="images/pending_apply.png" alt="" /> </td>
    <td>Application Pending to Apply </td>
    <td align="center"><img src="images/pending.png" alt="" /> </td>
    <td>Action Pending from Admin</td>
	<td align="center"><img src="images/red_cross.png"  alt="" /></td>
    <td>Application Disapproved</td>
	<?php if($Exhibitor_Section != "machinery"){ ?>
    <td><a href="images/pdf/Guidelines_for_stall_layout_Revised_Sig_23.pdf" target="_blank" style="padding:10px;border:1px solid #FF0000;background:#999999;color:#FFFFFF;">Guidelines For Stall Layout</a></td>
	<?php } ?>
  </tr>
  <tr>    
	<td height="40" align="center"><img src="images/correct.png"  alt="" /></td>
    <td> Application Approved</td>
	<td align="center"><img src="images/pdf_icon.png" alt="" /></td>
    <td>PDF</td>
	
	<span style="margin-left:10px;float:right" class="spanbox"><a href="standfitting_items.php" target="_blank"><strong>Click here to view furniture dimensions</strong></a></span>
	<?php if($specific_area != null && $specific_area != '' && isset($specific_area)) {
	$Exhibitor_Area = $Exhibitor_Area.'_'.$specific_area; } else { $Exhibitor_Area = $Exhibitor_Area; } ?>
	<?php if($Exhibitor_Section != "machinery"){ ?>
	<td><td><a href="images/pdf/<?php echo $Exhibitor_Area; ?>.pdf" target="_blank" style="padding:10px;border:1px solid #FF0000;background:#999999;color:#FFFFFF;">Click here to download stall layout</a></td></td>
	<?php } ?>
	<!-- <td><td><a href="images/pdf/3 X 3 Octanorm stall -1 side open-merged.pdf" target="_blank" style="padding:10px;border:1px solid #FF0000;background:#999999;color:#FFFFFF;">Click here to download stall layout</a></td></td> -->
	<?php if($Exhibitor_Section != "machinery"){ ?>
    <td><a href="images/pdf/IIJS_SIGNATURE_2023_EXH_MANUAL.pdf" target="_blank" style="padding:10px;border:1px solid #FF0000;background:#999999;color:#FFFFFF;">Download Exhibitor Manual PDF</a></td>
	<?php } else { ?>
	<td><a href="images/pdf/IGJME_2023_EXH_MANUAL.pdf" target="_blank" style="padding:10px;border:1px solid #FF0000;background:#999999;color:#FFFFFF;">Download Exhibitor Manual PDF</a></td>
	<?php } ?>
  </tr>
  <?php if ($Exhibitor_Section != "machinery") { ?>
        <tr>
            <td colspan="7">
                <a href="https://registration.gjepc.org/manual_signature/visiting_card_signature.php?exihibitor_code=<?php echo $exhibitor_code ?>"  style="padding:10px;border:1px solid #FF0000;background:#999999;color:#FFFFFF;display: table;transition: 0.5s;font-size: 15px;font-weight: bold;color: #2d38be;"><span class="blink">Download Exhibitor QR Code</span></a>
            </td>
        </tr>
    <?php } else if($Exhibitor_Section == "machinery") { ?>
        <tr>
            <td>
                <a href="https://registration.gjepc.org/manual_signature/visiting_card_igjme.php?exihibitor_code=<?php echo $exhibitor_code ?>"  style="padding:10px;border:1px solid #FF0000;background:#999999;color:#FFFFFF;display: table"><span class="blink">Download Exhibitor QR Code</span></a>
            </td>
        </tr>
    <?php } ?>   
<div class="clear"></div>
</table>

<?php
$sql_manager = "select * from admin_master where division_name='$Exhibitor_DivisionNo' and status='1'";
$query_manager = $conn ->query($sql_manager);
$result_manager = $query_manager->fetch_assoc();
//print_r($result_manager);
?>

<h3> Zone Manager Detail</h3>
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
                <td><?php echo trim($result_manager['division_name']);?></td>
                <td><?php echo trim($result_manager['contact_name']);?></td>
                <td><?php echo trim($result_manager['email_id']);?></td>
                <td><?php echo trim($result_manager['mobile_no']);?></td>
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
<!--<tr>
    <td>FORM NO.0</td>
    <td><?php echo "<a href='personalInfo.php'>ELITE CLUB NOMINATION FORM FOR YOUR RETAILER</a>";?></td>
    <td>Submit Online only</td>
    <td>10-08-2021</td>
	<td><?php echo getFormDeadLine(1,$conn);?></td>
    <td class="centerAlign">
	<?php
	$app_status=getApplicationStatus("iijs_form",$conn);
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
</tr>-->
<!--- End COMPULSORY CATALOGUE ENTRY -->
<!--- Start COMPULSORY CATALOGUE ENTRY -->
<tr>
    <td>FORM NO.1</td>
    <td><?php echo "<a href='compulsory_catalogue_entry.php'>COMPULSORY CATALOGUE ENTRY</a>";?></td>
    <td>Submit Online only</td>
    <td><?php echo getFormStartDate(1,$conn);?></td>
	<td><?php echo getFormDeadLine(1,$conn);?></td>
    <td class="centerAlign">
	<?php
	$app_status=getApplicationStatus("iijs_catalog",$conn);
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
    <td>FORM NO.2</td>
    <td>
    <?php 
	$app_status = getApplicationStatus("iijs_badge",$conn);
	if($app_status=="P" || $app_status=="N" || $app_status=="Y")
	{
		echo "<a href='exhibitors_badges.php'>EXHIBITOR BADGES</a>";
		//echo "<a href='#' onclick='coming();'>EXHIBITOR BADGES</a>";		
	} else	{
		echo "<a href='exhibitors_badges.php'>EXHIBITOR BADGES</a>";
		//echo "<a href='#' onclick='coming();'>EXHIBITOR BADGES</a>";		
		//echo "<a href='#' onClick='alert('Deadline is over form can not be accesssed');return false'>EXHIBITOR BADGES / CAR PASSES FORM</a>";		
	}
	?>
    <td>Submit Online Form and online payment</td>
    <td><?php echo getFormStartDate(2,$conn);?></td>
    <td><?php echo getFormDeadLine(2,$conn);?></td>
    <td class="centerAlign">
	<?php
	$app_status=getApplicationStatus("iijs_badge",$conn);
	if($app_status=="application")
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
<!-- START VACCINE UPLOAD -->
	<!-- <tr>
	<td>FORM NO.12</td>
	<td>
	    <a href="#" class='maroon_btn'>VACCINE CERTIFICATE</a>
	    <a href="vaccine_upload.php?action=upload-vaccine" class='maroon_btn'>VACCINE CERTIFICATE</a>
	</td>
	<td>Upload Vaccination certificate for approved exhibitors</td>
	<td>13-12-2021</td>
	<td><?php //echo getFormDeadLine(12,$conn); ?></td>
	<td class="centerAlign"></td>
	</tr> -->
<!-- END VACCINE UPLOAD -->

<!--- End EXHIBITOR BADGES -->

<!--- Start STANDFITTING SERVICES -->
<tr>
    <td>FORM NO.3</td>
    <td>
    <?php 
	echo "<a href='standfitting_services.php'>STANDFITTING SERVICES</a>";
	//echo "<a href='#' onclick='coming();'>STANDFITTING SERVICES</a>";
	?>
    </td>
    <td>Submit Online Form and online payment</td>
    <td><?php echo getFormStartDate(3,$conn);?></td>
	<td><?php echo getFormDeadLine(3,$conn);?></td>
    <td class="centerAlign">
    <?php
	$app_status=getApplicationStatus("iijs_stand",$conn);
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
	<?php echo "<a href='stall_layout.php'>STALL LAYOUT</a>";?></td>
	<?php //echo "<a href='#' onclick='coming();'>STALL LAYOUT</a>"; ?>
	</td>
    <td>Submit Online only</td>
    <td><?php echo getFormStartDate(4,$conn);?></td>
	<td><?php echo getFormDeadLine(4,$conn);?></td>
    <td class="centerAlign">
	<?php
	$app_status=getApplicationStatus("iijs_stall_master",$conn);
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
    <td>FORM NO.5</td>
    <td>
    <?php //echo $Exhibitor_Area;
    /*if($Exhibitor_Area==9){ ?>
	<?php 
	$app_status=getApplicationStatus("iijs_safe_rental",$conn);
	$app_status1=getApplicationStatus("iijs_strongroom",$conn);
	if($app_status=="P" || $app_status=="N" || $app_status=="Y")
		{
			echo "<a href='safe_rental_or_indemnity_bond_form.php'>SAFE RENTAL</a><br/>";
		}
		elseif($app_status1=="P" || $app_status1=="N" || $app_status1=="Y")
		{			
			echo "<a href='strong_room_facility.php'>STRONG ROOM</a>"; 
		}
		else
		{
			echo "<a href='safe_rental_or_indemnity_bond_form.php' onclick='Safe();'>SAFE RENTAL</a><br/>";
			echo " <a href='strong_room_facility.php' onclick='Strong();'>STRONG ROOM</a><br/>";
		} 
	?>
	<?php } else { */?>
	<a href='safe_rental_or_indemnity_bond_form.php'>SAFE RENTAL</a>
	<!-- <a href='#' onclick='coming();'>SAFE RENTAL</a> -->
	<?php //}  ?>
    </td>
    
    <td>Submit Online & Submit to GJEPC</td>
    <td><?php echo getFormStartDate(5,$conn);?></td>
    <td><?php echo getFormDeadLine(5,$conn);?></td>
    <td class="centerAlign">
    <?php
    $app_status=getApplicationStatus("iijs_safe_rental",$conn);
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
<!--
<tr>
    <td>Online & Print Phase 2</td>
    <td>31-12-2019</td>
    <td>19-01-2019</td>
    <td class="centerAlign"></td>
</tr> -->

<!--- End Safe Leasing Facility | Strong Room Facility -->

<!--- Start Safe Leasing Facility | Strong Room Facility -->
<?php /*
if($Exhibitor_Area==9){?>
<tr>
    <td>FORM NO.5</td>
    <td><?php echo "<a href='strong_room_facility.php'>STRONG ROOM</a>";?></td>
    <td>Submit Online only</td>
    <td>31-12-2019</td>
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
    <td>10-01-2020</td>
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
	//echo "<a href='#' onclick='coming();'>STAND CLEANING SERVICES (HOUSE KEEPING)</a>";
	?>
    </td>
    <td width="30%">Submit Online Form and online payment</td>
    <td><?php echo getFormStartDate(6,$conn);?></td>
	<td><?php echo getFormDeadLine(6,$conn);?></td>
    <td class="centerAlign">
    <?php
    $app_status=getApplicationStatus("iijs_housekeeping",$conn);
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
	echo "<a href='wireless_internet_connection.php'>WIRED INTERNET CONNECTION (LAN)</a>";
	//echo "<a href='#' onclick='coming();'>WIRED INTERNET CONNECTION</a>";
	?>
    </td>
    <td>Submit Online Form and online payment</td>
    <td><?php echo getFormStartDate(7,$conn);?></td>
	<td><?php echo getFormDeadLine(7,$conn);?></td>
    <td class="centerAlign">
	<?php
    $app_status=getApplicationStatus("iijs_wirelessinternet",$conn);
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
	<a href="electronic_surveillance.php">ELECTRONIC SURVEILLANCE (CCTV)</a>
	<!--<a href='#' onclick='coming();'>ELECTRONIC SURVEILLANCE</a>-->
    </td>
    <td>Submit Online & Payment with print acknowledgment to Vendor</td>
    <td><?php echo getFormStartDate(8,$conn);?></td>
    <td><?php echo getFormDeadLine(8,$conn);?></td>
    <td class="centerAlign">
    <?php
    $app_status=getApplicationStatus("iijs_cctv",$conn);
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
<?php if($Exhibitor_Section != "machinery"){ ?>
<!--- Strat UNDERTAKING OF JEWELLERY FINENESS -->
<tr>
    <td>FORM NO.9</td>
	 <td><a href="javascript:void(0);" onclick='Fineness(1); return false;' >UNDERTAKING OF JEWELLERY FINENESS</a></td>
    <td>PDF Download Print & Submit to GJEPC</td>
    <td><?php echo getFormStartDate(9,$conn);?></td>
	<td><?php echo getFormDeadLine(9,$conn);?></td>
    <td class="centerAlign"><img src="images/pdf_icon.png" alt="" /></td>
</tr>
<?php } ?>
<!--- End UNDERTAKING OF JEWELLERY FINENESS -->

<!--- Start Stall Allotment Letter -->
 <tr>
    <td>FORM NO.10</td>
    <td>
    <?php if(getApplicationStatus("iijs_stall_master",$conn)=='Y'){?>
    <a href='print_acknowledge/stall_allotment_letter.php' target="_blank">STALL ALLOTMENT LETTER</a>
    <?php } else {?>
    <a href='#' onClick="alert('Stall allotment letter will be available after approval of form no. 4 Stall layout');return false">STALL ALLOTMENT LETTER</a>
    <?php }?>
    </td>
	<td>PDF Download Print</td>
	<td><?php echo getFormStartDate(10,$conn);?></td>
    <td><?php echo getFormDeadLine(10,$conn);?></td>
    <td class="centerAlign"><img src="images/pdf_icon.png" alt="" /></td>
</tr>
<!--- End Stall Allotment Letter -->

<!--- Start Exhibitor Clearance -->
<tr>
    <td>FORM NO.11</td>
    <td><a href="images/pdf/Exhibitor_Clearance_SIG_2023.pdf" target="_blank">EXHIBITOR CLEARANCE</a></td>
    <td>PDF Download Print & Submit to GJEPC</td>
    <td><?php echo getFormStartDate(11,$conn);?></td>
	<td><?php echo getFormDeadLine(11,$conn);?></td>
    <td class="centerAlign"><img src="images/pdf_icon.png" alt="" /></td>
</tr>
<!--- End Exhibitor Clearance -->

<!--- Start Air water connection for Machinery only -->
<?php if($Exhibitor_Section == "machinery"){?>
<tr>
    <td>FORM NO.12</td>
    <td>
    <?php 
    $app_status=getApplicationStatus("igjme_air_water",$conn);
	if($app_status=="P" || $app_status=="N" || $app_status=="Y")
	{
		echo "<a href='compressed_air_water_connection.php'>COMPRESSED AIR / WATER CONNECTION / 3 PHASE CONNECTION</a>";
	}else
	{
		echo "<a href='compressed_air_water_connection.php'>COMPRESSED AIR / WATER CONNECTION / 3 PHASE CONNECTION</a>";
		//echo "<a href='javascript:void(0)' onClick='Alret()'>COMPRESSED AIR / WATER CONNECTION</a>";	
	}
    ?>
    </td>
    <td>Online Form</td>
    <td><?php echo getFormStartDate(12,$conn);?></td>
	<td><?php echo getFormDeadLine(12,$conn);?></td>
    <td class="centerAlign">
    <?php
    $app_status=getApplicationStatus("igjme_air_water",$conn);
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
<?php } ?>
<!--- End Air water connection for Machinery only -->

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
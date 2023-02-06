<?php
if($_SESSION['admin_login_id']=="" || $_SESSION['admin_email_id']=="")
{  
	echo"<meta http-equiv=refresh content=\"0;url=index.php\">";	exit;
}
?>
<?php 
$url = $_SERVER['PHP_SELF'];
#for Local
$attach = "/signature/manual/admin/";
#for Live
//$attach = "/manual/admin/";
?>

<div id="smoothmenu1" class="ddsmoothmenu ">
<ul> 
<?php
if($_SESSION['admin_role']=="Super Admin")
{
	if($_SESSION['admin_admin_access']=='Safe Rental'){
	?>
    <li><a href="manage_safe_rental.php?action=view">Safe Rental</a></li>
    <?php 
	}else if($_SESSION['admin_admin_access']=='Stadfitting' && $_SESSION['admin_section']!=""){
	?>
    <li><a href="manage_stadfitting.php?action=view">Standfitting Services</a></li>
	<li><a href="manage_stall_layout.php?action=view">Stall Layout</a></li>
	<?php }else if($_SESSION['admin_admin_access']=='Stadfitting'){?>
	<li><a href="manage_stadfitting.php?action=view">Standfitting Services</a></li>
    <?php		
	}else if($_SESSION['admin_admin_access']=='Stall Layout'){
	?>
    <li><a href="manage_stall_layout.php?action=view">Stall Layout</a></li>
    <?php
	}else if($_SESSION['admin_admin_access']=='Floral'){
	?>
    <li><a href="manage_floral_rental.php?action=view">Floral / Plant Rental</a></li>
    <?php
	}else if($_SESSION['admin_admin_access']=='Electronic Surveillance'){
	?>
    <li><a href="manage_electronic_surveillance.php?action=view">Electronic Surveillance</a></li>
    <?php
	}else if($_SESSION['admin_admin_access']=='Badges'){
	?>
    <li><a href="manage_badges.php?action=view">Exhibitor Badges / Car Passes</a></li>
    <?php
	}else if($_SESSION['admin_admin_access']=='Badges'){
	?>
    <li><a href="manage_badges.php?action=view">Exhibitor Badges / Car Passes</a></li>
    <?php
	}else{
?>               
    <li><a href="manage_admin.php?action=view" <?php if($url == $attach.'manage_admin.php')  { ?> class="selected" <?php } ?>>Manage Admin</a></li>
    <li style="background:none;"> | </li>
    <li><a href="#">Manual</a>
         <ul class="terms">
        	<li><a href="manage_elite_club.php?action=view">Elite club</a></li>
        	<li><a href="manage_compulsory_catalogue.php?action=view">Compulsory Catalogue Entrys</a></li>
            <li><a href="manage_stall_layout.php?action=view">Stall Layout</a></li>
            <li><a href="manage_stadfitting.php?action=view">Standfitting Services</a></li>
            <li><a href="manage_badges.php?action=view">Exhibitor Badges / Car Passes</a></li>
            <li><a href="manage_wireless_internet_connection.php?action=view">Wireless Internet Connection</a></li>
            <li><a href="manage_electronic_surveillance.php?action=view">Electronic Surveillance</a></li>
            <li><a href="manage_safe_rental.php?action=view">Safe Rental</a></li>
            <li><a href="manage_storng_room.php?action=view">Strong Room</a></li>
            <!--<li><a href="manage_floral_rental.php?action=view">Floral / Plant Rental</a></li>
            <li><a href="manage_car_hire.php?action=view">Car Hire Reservation Form</a></li>
            <li><a href="manage_hotel_reservation.php?action=view">Hotel Reservation</a></li>
            <li><a href="manage_visa_application_assistance.php?action=view">Visa Application Assistance</a></li>-->
            <li><a href="manage_house_keeping.php?action=view">House Keeping Services</a></li>            
        </ul>
	</li>	
     
<li style="background:none;"> | </li>
<li><a href="#">Form Management</a>
   <ul class="terms">
        <li><a href="manage_exhibitor.php?action=view">Manage Exhibitor</a></li>
        <li><a href="standfitting_master.php?action=view">Standfitting Master</a></li>
        <li><a href="badges_master.php?action=view">Badges Master</a></li>
        <li><a href="saferental_master.php?action=view">Safe Rental Master</a></li>
        <li><a href="floral_master.php?action=view">Floral/plant Master</a></li>
        <li><a href="stall_basic_furniture_master.php?action=view">Basic stall Master</a></li>
        <li><a href="date_master.php?action=view">Date Master</a></li>
    </ul>
</li>
<li style="background:none;"> | </li>
<li><a href="#">Reports</a>
   
   <ul class="terms">
        <li><a href="export_club.php">Elite Club</a></li>
        <li><a href="report_compulsory_catalogue.php?action=view">Compulsory Catalogue Entry</a></li>
        <li><a href="report_stall_layout.php?action=view">Stall Layout</a></li>
      	<li><a href="report_stadfitting.php?action=view">Standfitting Services</a></li>
        <li><a href="report_badges_carpass.php?action=view">Exhibitor Badges / Car Passes</a></li>
        <li><a href="report_wireless_internet.php?action=view">Wireless Internet Connection</a></li>
        <li><a href="report_electronic_surveillance.php?action=view">Electronic Surveillance</a></li>
        <li><a href="report_safe_rental.php?action=view">Safe Rental</a></li>
		<li><a href="report_strongroom.php?action=view">Strong Room</a></li>
        <li><a href="report_floral.php?action=view">Floral / Plant Rental</a></li>
        <li><a href="report_housekeeping.php?action=view">House Keeping Services</a></li>
    </ul>
</li>    
	<li><a href="#">Manage Pre SO & TDS</a>
        <ul class="terms">
            <li><a href="manage_so.php?action=view">Manage Sales Order</a></li>            
            <li><a href="manage_so_housekeep.php?action=view">Manage Housekeeping Sales Order</a></li>            
        </ul>
	</li>
	<li><a href="#">Manage Onspot SO & TDS</a>
        <ul class="terms">
            <li><a href="manage_onspot_so.php?action=view">Manage Sales Order</a></li>            
            <li><a href="manage_onspot_so_housekeep.php?action=view">Manage Housekeeping Sales Order</a></li>       
            <li><a href="manage_onspot_so_badges.php?action=view">Manage Badges Sales Order</a></li>            
        </ul>
	</li>
	<?php }	} else if($_SESSION['admin_role']=="Vendor"){
	if($_SESSION['admin_admin_access']=='Safe Rental'){?>
    <li><a href="manage_safe_rental.php?action=view">Safe Rental</a></li>
    <?php 
	}else if($_SESSION['admin_admin_access']=='Stadfitting'){
	?>
    <li><a href="manage_stadfitting.php?action=view">Standfitting Services</a></li>
	<li><a href="manage_stall_layout.php?action=view">Stall Layout</a></li>
	<?php } else if($_SESSION['admin_admin_access']=='Floral'){
	?>
    <li><a href="manage_floral_rental.php?action=view">Floral / Plant Rental</a></li>
    <?php
	}else if($_SESSION['admin_admin_access']=='Electronic Surveillance'){
	?>
    <li><a href="manage_electronic_surveillance.php?action=view">Electronic Surveillance</a></li>
    <?php
	}else if($_SESSION['admin_admin_access']=='Badges'){
	?>
    <li><a href="manage_badges.php?action=view">Exhibitor Badges / Car Passes</a></li>
    <?php } }else {?>
	<li><a href="#">Manual</a>
		 <ul class="terms">
			<li><a href="manage_compulsory_catalogue.php?action=view">Compulsory Catalogue Entry</a></li>
			<li><a href="manage_stall_layout.php?action=view">Stall Layout</a></li>
			<li><a href="manage_stadfitting.php?action=view">Standfitting Services</a></li>
			<li><a href="manage_badges.php?action=view">Exhibitor Badges / Car Passes</a></li>
			<li><a href="manage_wireless_internet_connection.php?action=view">Wireless Internet Connection</a></li>
			<li><a href="manage_electronic_surveillance.php?action=view">Electronic Surveillance</a></li>
			<li><a href="manage_safe_rental.php?action=view">Safe Rental</a></li>
			<li><a href="manage_storng_room.php?action=view">Strong Room</a></li>
			<li><a href="manage_floral_rental.php?action=view">Floral / Plant Rental</a></li>
			<li><a href="manage_car_hire.php?action=view">Car Hire Reservation Form</a></li>
			<li><a href="manage_hotel_reservation.php?action=view">Hotel Reservation</a></li>
			<li><a href="manage_visa_application_assistance.php?action=view">Visa Application Assistance</a></li>
			<li><a href="manage_house_keeping.php?action=view">House Keeping Services</a></li>                        
		</ul>
	</li>
	<li style="background:none;"> | </li>
	<li><a href="#">Form Management</a>
	<ul class="terms">
        <li><a href="manage_exhibitor.php?action=view">Manage Exhibitor</a></li>
	</ul>
	</li>
	<li><a href="#">Manage Pre SO & TDS</a>
        <ul class="terms">
            <li><a href="manage_so.php?action=view">Manage Sales Order</a></li>            
            <li><a href="manage_so_housekeep.php?action=view">Manage Housekeeping Sales Order</a></li>            
        </ul>
	</li>
	<li><a href="#">Manage Onspot SO & TDS</a>
        <ul class="terms">
            <li><a href="manage_onspot_so.php?action=view">Manage Sales Order</a></li>            
            <li><a href="manage_onspot_so_housekeep.php?action=view">Manage Housekeeping Sales Order</a></li>       
            <li><a href="manage_onspot_so_badges.php?action=view">Manage Badges Sales Order</a></li>            
        </ul>
	</li>
	<li style="background:none;"> | </li>
	<li><a href="#">Reports</a>
   <ul class="terms">
        <li><a href="export_club.php">Elite Club</a></li>
        <li><a href="report_compulsory_catalogue.php?action=view">Compulsory Catalogue Entry</a></li>
        <li><a href="report_stall_layout.php?action=view">Stall Layout</a></li>
      	<li><a href="report_stadfitting.php?action=view">Standfitting Services</a></li>
        <li><a href="report_badges_carpass.php?action=view">Exhibitor Badges / Car Passes</a></li>
        <li><a href="report_wireless_internet.php?action=view">Wireless Internet Connection</a></li>
        <li><a href="report_electronic_surveillance.php?action=view">Electronic Surveillance</a></li>
        <li><a href="report_safe_rental.php?action=view">Safe Rental</a></li>
		<li><a href="report_strongroom.php?action=view">Strong Room</a></li>
        <li><a href="report_floral.php?action=view">Floral / Plant Rental</a></li>
        <li><a href="report_housekeeping.php?action=view">House Keeping Services</a></li>
    </ul>
</li>
<?php } ?>
	
</ul>
</div>
</div>
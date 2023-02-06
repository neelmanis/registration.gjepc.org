<?php 
include('header_include.php');
if(!isset($_SESSION['EXHIBITOR_CODE'])){ header("location:index.php");	exit; }	
?>
<?php
$exhibitor_code=$_SESSION['EXHIBITOR_CODE'];
$exhibitor_data="select * from iijs_exhibitor where Exhibitor_Code='$exhibitor_code'";
$result = $conn ->query($exhibitor_data);
$fetch_data = $result->fetch_assoc();

$Exhibitor_Area=$fetch_data['Exhibitor_Area'];
$Exhibitor_Country_ID=$fetch_data['Exhibitor_Country_ID'];
$Exhibitor_Section=$fetch_data['Exhibitor_Section'];
$Exhibitor_StallType=$fetch_data['Exhibitor_StallType'];
$Exhibitor_Scheme=$fetch_data['Exhibitor_Scheme'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome to SIGNATURE</title>
<link rel="stylesheet" type="text/css" href="css/mystyle.css" />

<!--navigation script-->
<script type="text/javascript" src="../js/jquery-1.3.2.min.js"></script>      
<!--navigation script end-->
<script type="text/javascript" src="js/jquery.fancybox-1.3.4.js"></script>
<link rel="stylesheet" type="text/css" href="css/jquery.fancybox-1.3.4.css" media="screen" />
 	
<script type="text/javascript">
		$(document).ready(function() {
				$(".various3").fancybox({
				'transitionIn'		: 'elastic',
				'transitionOut'		: 'elastic',
	
			});
		});
</script>
 <!--fancybox ends-->
<!--manual form css-->
<link rel="stylesheet" type="text/css" href="../css/manual.css"/>
</head>
<body>
<!-- header starts -->
<div class="header_wrap"><?php include ('header.php'); ?></div>
<!-- header ends -->

<div class="clear"></div>
<div class="container_wrap">
<div class="container">
<h1>Standfitting Items</h1>

<div id="formWrapper">
<div class="standimage">
<table cellspacing="0" cellpadding="0" class="common">
 
  <tr>
    <th>Sr No.</th>
    <th>Item Description</th>    
    <th>Item Image</th>
  </tr>
  <?php if($Exhibitor_Scheme=='BI2' && $Exhibitor_Section!='signature_club'){ ?>   
  <tr>
    <td >1</td>
    <td>70 W Metal Halide</td>    
    <td><a href="standfitting/70-W-Metal-Halide-(White).jpg" class="various3"><img src="standfitting/70-W-Metal-Halide-(White).jpg" alt=""  /></a></td>
  </tr>
  <tr>
    <td >2</td>
    <td>Bar Stools</td>
    <td><a href="standfitting/Bar-Stools.jpg" class="various3"><img src="standfitting/Bar-Stools.jpg" alt="" /></a></td>
  </tr>
  <tr >
    <td >3</td>
    <td>Brochure Rack</td>
    <td><a href="standfitting/Brouchre-Rack.jpg" class="various3"><img src="standfitting/Brouchre-Rack.jpg" alt=""  /></a></td>
  </tr>
   <tr >
    <td >4</td>
    <td>Comptalux Spot - Yellow Lights</td>
    <td><a href="standfitting/Comptalux-Spot-Yellow-Lights.jpg" class="various3"><img src="standfitting/Comptalux-Spot-Yellow-Lights.jpg" alt="" /></a></td>
  </tr>
   <tr >
    <td >5</td>
    <td>Desk Table with Lockable storage (octonorm)</td>
    <td><a href="standfitting/Desk-Table-with-Lockable-storage-(octonorm).jpg" class="various3"><img src="standfitting/Desk-Table-with-Lockable-storage-(octonorm).jpg" alt="" /></a></td>
  </tr>
   <tr >
    <td>6</td>
    <td>Dustbin</td>
    <td><a href="standfitting/Dustbin.jpg" class="various3"><img src="standfitting/Dustbin.jpg" alt=""  /></a></td>
  </tr>
   <tr>
    <td >7</td>
    <td>Fiber Chairs</td>
    <td><a href="standfitting/Fiber-Chairs.jpg" class="various3"><img src="standfitting/Fiber-Chairs.jpg" alt=""  /></a></td>
   </tr>
   <tr >
    <td >8</td>
    <td>Folding Door</td>
    <td><a href="standfitting/260.jpg" class="various3"><img src="standfitting/260.jpg" alt="" /></a></td>
  </tr>
  <tr >
    <td >9</td>
    <td>Glass Round Table</td>
    <td><a href="standfitting/Glass-Round-Table.jpg" class="various3"><img src="standfitting/Glass-Round-Table.jpg" alt=""  /></a></td>
  </tr>
   <tr >
    <td >10</td>
    <td>Maxima System Panel</td>
    <td><a href="standfitting/Maxima-System-Panel.jpg" class="various3"><img src="standfitting/Maxima-System-Panel.jpg" alt=""  /></a></td>
  </tr>
 
  <tr >
    <td >11</td>
    <td>Plug Point</td>
    <td><a href="standfitting/Plug-Point-15-Amps.jpg" class="various3"><img src="standfitting/Plug-Point-15-Amps.jpg" alt=""  /></a></td>
  </tr>
  <tr >
    <td >12</td>
    <td>Single shelf - Glass</td>
    <td><a href="standfitting/Single-shelf---Glass.jpg" class="various3"><img src="standfitting/Single-shelf---Glass.jpg" alt="" width="332" height="337" /></a></td>
  </tr>
  <tr >
    <td >13</td>
    <td>Spiral CFL Lights 23 Watt for Stall Lighting</td>
    <td><a href="standfitting/Spiral-CFL-Lights-23-Watt-for-Stall-Lighting-(Yellow).jpg" class="various3"><img src="standfitting/Spiral-CFL-Lights-23-Watt-for-Stall-Lighting-(Yellow).jpg" alt=""  /></a></td>
  </tr>
 
   <tr >
    <td >14</td>
    <td>Table(Without Panel)</td>
    <td><a href="standfitting/Table-(Wthout-Panel).jpg" class="various3"><img src="standfitting/Table-(Wthout-Panel).jpg" alt=""/></a></td>
  </tr>
   <tr >
    <td >15</td>
    <td>Table (With 3 side close Panel )</td>
    <td><a href="standfitting/Information-Table-without-Lock-(octonorm).jpg" class="various3"><img src="standfitting/Information-Table-without-Lock-(octonorm).jpg" alt=""  /></a></td>
  </tr>
   <tr >
    <td >16</td>
    <td>Tall Glass Showcase with LED Strip, 6 LED Spot & lockable storage</td>
    <td><a href="standfitting/Tall-Glass-Showcase-with-lockable-storage-(octonorm-Type)-with-6-LED-Lights---Copy.jpg" class="various3"><img src="standfitting/Tall-Glass-Showcase-with-lockable-storage-(octonorm-Type)-with-6-LED-Lights---Copy.jpg" alt="" width="771" height="771" /></a></td>
  </tr>
  
  <tr >
    <td >17</td>
    <td>Top Glass Showcase with LED Strip & lockable storage</td>
    <td><a href="standfitting/Top--Glass-Showcase-with-1Q5-LED-in-brushed-finished-Ms-Tube-(White--Yellow)-With-2-LED-Spot.jpg" class="various3"><img src="standfitting/Top--Glass-Showcase-with-1Q5-LED-in-brushed-finished-Ms-Tube-(White--Yellow)-With-2-LED-Spot.jpg" alt="" /></a></td>
  </tr>
 
<?php } else if($Exhibitor_Scheme=='BI1' && $Exhibitor_Section!='signature_club'){ ?>
  <tr>
    <td>1</td>
    <td>Glass Shelves -ready mould glass shelves fixed on metal fixture</td>    
    <td><a href="standfitting/images/Single-shelf---Glass.jpg" class="various3"><img src="standfitting/images/Single-shelf---Glass.jpg" alt=""  /></a></td>
  </tr>
  <tr>
    <td>2</td>
    <td>Brochure Rack</td>    
    <td><a href="standfitting/images/Brouchre_Rack.jpg" class="various3"><img src="standfitting/images/Brouchre_Rack.jpg" alt=""  /></a></td>
  </tr>
  <!--<tr>
    <td>3</td>
    <td>Eye Cutter (partition wall)</td>    
    <td><a href="standfitting/images/EYE_CUTTER_(PARTITION)_WALL).jpg" class="various3"><img src="standfitting/images/EYE_CUTTER_(PARTITION)_WALL).jpg" alt=""  /></a></td>
  </tr>
  <tr>
    <td>4</td>
    <td>Curtain</td>    
    <td><a href="standfitting/images/Curtain.jpg" class="various3"><img src="standfitting/images/Curtain.jpg" alt=""  /></a></td>
  </tr>-->
  <!-- <tr>
    <td>5</td>
    <td>70-watt Metal Halide (white)</td>    
    <td><a href="standfitting/images/70-W-Metal-Halide-(White).jpg" class="various3"><img src="standfitting/images/70-W-Metal-Halide-(White).jpg" alt=""/></a></td>
  </tr>
  <tr> -->
  <tr>  
    <td>5</td>
    <td>50-watt Track Light (yellow)</td>    
    <td><a href="standfitting/images/50_watt_Track_Light.png" class="various3"><img src="standfitting/images/50_watt_Track_Light.png" alt=""/></a></td>
  </tr>
  <tr>  
    <td>6</td>
    <td>50-watt Track Light (white)</td>    
    <td><a href="standfitting/images/50_watt_Track_Light.png" class="various3"><img src="standfitting/images/50_watt_Track_Light.png" alt=""/></a></td>
  </tr>
  <!-- <tr>
    <td>6</td>
    <td>70-watt Metal Halide (yellow)</td>    
    <td><a href="standfitting/images/70-W-Metal-Halide-(Yellow).jpg" class="various3"><img src="standfitting/images/70-W-Metal-Halide-(Yellow).jpg" alt=""/></a></td>
  </tr> -->
  <tr>
    <td>7</td>
    <td>Tall Glass Unit (wide) (white)</td>    
    <td><a href="standfitting/images/Tall_glass_unit_white.png" class="various3"><img src="standfitting/images/Tall_glass_unit_white.png" alt=""/></a></td>
  </tr>
  <tr>
    <td>8</td>
    <td>Tall Glass Unit (wide) (yellow)</td>    
    <td><a href="standfitting/images/Tall_glass_unit_yellow.png" class="various3"><img src="standfitting/images/Tall_glass_unit_yellow.png" alt=""  /></a></td>
  </tr>
  <!--<tr>
    <td>9</td>
    <td>Window Glass Showcase (white)</td>    
    <td><a href="standfitting/images/Window_Display.jpg" class="various3"><img src="standfitting/images/Window_Display.jpg" alt=""  /></a></td>
  </tr>
  <tr>
    <td>10</td>
    <td>Window Glass Showcase (yellow)</td>    
    <td><a href="standfitting/images/Window_Display.jpg" class="various3"><img src="standfitting/images/Window_Display.jpg" alt=""  /></a></td>
  </tr>-->
  <tr>
    <td>11</td>
    <td>Top Glass Unit (wide) (white)</td>    
    <td><a href="standfitting/images/Top_glass_unit_white.png" class="various3"><img src="standfitting/images/Top_glass_unit_white.png" alt=""  /></a></td>
  </tr><tr>
    <td>12</td>
    <td>Top Glass Unit (wide) (yellow)</td>    
    <td><a href="standfitting/images/Top_glass_unit_white.png" class="various3"><img src="standfitting/images/Top_glass_unit_white.png" alt=""  /></a></td>
  </tr>
  <tr>
    <td>13</td>
    <td>1 MTR window Glass Unit White</td>    
    <td><a href="standfitting/images/1_MTR_window_glass_unit_white.png" class="various3"><img src="standfitting/images/1_MTR_window_glass_unit_white.png" alt=""  /></a></td>
  </tr>
  <tr>
    <td>14</td>
    <td>1 MTR window Glass Unit Yellow</td>    
    <td><a href="standfitting/images/1_MTR_window_glass_unit_yellow.png" class="various3"><img src="standfitting/images/1_MTR_window_glass_unit_yellow.png" alt=""  /></a></td>
  </tr>
  <tr>
    <td>15</td>
    <td>2 MTR window Glass Unit White</td>    
    <td><a href="standfitting/images/2_MTR_window_glass_unit_white.png" class="various3"><img src="standfitting/images/2_MTR_window_glass_unit_white.png" alt=""  /></a></td>
  </tr>
  <tr>
    <td>16</td>
    <td>2 MTR window Glass Unit Yellow</td>    
    <td><a href="standfitting/images/2_MTR_window_glass_unit_yellow.png" class="various3"><img src="standfitting/images/2_MTR_window_glass_unit_yellow.png" alt=""  /></a></td>
  </tr>
  <tr>
    <td>17</td>
    <td>Storage Unit With 2 Shelve</td>    
    <td><a href="standfitting/images/Storage_Unit.png" class="various3"><img src="standfitting/images/Storage_Unit.png" alt=""  /></a></td>
  </tr>
 <!-- <tr>
    <td>13</td>
    <td>Tall Glass Unit (thin) (white)</td>    
    <td><a href="standfitting/images/Tall_glass_unit_(Thin).jpg" class="various3"><img src="standfitting/images/Tall_glass_unit_(Thin).jpg" alt=""  /></a></td>
  </tr><tr>
    <td>14</td>
    <td>Tall Glass Unit (thin) (yellow)</td>    
    <td><a href="standfitting/images/Tall_glass_unit_(Thin).jpg" class="various3"><img src="standfitting/images/Tall_glass_unit_(Thin).jpg" alt=""  /></a></td>
  </tr>
  <tr>
    <td>15</td>
    <td>Top Glass Unit (thin) (white)</td>    
    <td><a href="standfitting/images/Top_glass_unit_(Thin).jpg" class="various3"><img src="standfitting/images/Top_glass_unit_(Thin).jpg" alt=""  /></a></td>
  </tr>
  <tr>
    <td>16</td>
    <td>Top Glass Unit (thin) (yellow)</td>    
    <td><a href="standfitting/images/Top_glass_unit_(Thin).jpg" class="various3"><img src="standfitting/images/Top_glass_unit_(Thin).jpg" alt=""  /></a></td>
  </tr>-->
  <tr>
    <td>18</td>
    <td>Information Table without Lock (Maxima)</td>   <!--  Desk Table with three side panel in octornorm -->
    <td><a href="standfitting/Desk-Table-with-Lockable-storage-(octonorm).jpg" class="various3"><img src="standfitting/Desk-Table-with-Lockable-storage-(octonorm).jpg" alt=""  /></a></td>
  </tr>
  <tr>
    <td>19</td>
    <td>Desk Table, lockable in octonorm</td>    
    <td><a href="standfitting/Information-Table-without-Lock-(octonorm).jpg" class="various3"><img src="standfitting/Information-Table-without-Lock-(octonorm).jpg" alt=""  /></a></td>
  </tr>
  <tr>
    <td>20</td>
    <td>Meeting Table</td>    
    <td><a href="standfitting/images/Maxima_Table.jpg" class="various3"><img src="standfitting/images/Maxima_Table.jpg" alt=""  /></a></td>
  </tr>
  <tr>
    <td>21</td>
    <td>Chair</td>    
    <td><a href="standfitting/images/Fiber_Chairs.jpg" class="various3"><img src="standfitting/images/Fiber_Chairs.jpg" alt=""  /></a></td>
  </tr>
  <tr>
    <td>22</td>
    <td>Plug point 5/15 amp</td>    
    <td><a href="standfitting/images/Plug_Point.jpg" class="various3"><img src="standfitting/images/Plug_Point.jpg" alt=""  /></a></td>
  </tr><tr>
    <td>23</td>
    <td>Dustbin</td>    
    <td><a href="standfitting/images/Dustbin.jpg" class="various3"><img src="standfitting/images/Dustbin.jpg" alt=""  /></a></td>
  </tr>
  <tr>
    <td>24</td>
    <td>Bar Stool</td>    
    <td><a href="standfitting/images/Bar_Stools.jpg" class="various3"><img src="standfitting/images/Bar_Stools.jpg" alt=""  /></a></td>
  </tr>
  
<?php } if($Exhibitor_Section=='signature_club') { ?>  
  <tr>
    <td>1</td>
    <td>Top Glass showcase in MDF varnish finish with LED strip lighting</td>    
    <td><a href="standfitting/Top-Glass.jpg" class="various3"><img src="standfitting/Top-Glass.jpg" alt=""  /></a></td>
  </tr>
  <tr>
    <td>2</td>
    <td>Partition wall in wood & MDF paint finish</td>
    <td><a href="standfitting/Movable-Partition-Wall.jpg" class="various3"><img src="standfitting/Movable-Partition-Wall.jpg" alt=""  /></a></td>
  </tr>
  <tr >
    <td>3</td>
    <td>Plug point 5/15 Amp</td>
    <td><a href="standfitting/Plug-Point.jpg" class="various3"><img src="standfitting/Plug-Point.jpg" alt=""  /></a></td>
  </tr>
  <tr >
    <td >4</td>
    <td>Novia chair</td>
    <td><a href="standfitting/Visitor-Chair-Novia.jpg" class="various3"><img src="standfitting/Visitor-Chair-Novia.jpg" alt=""  /></a></td>
  </tr>
  <tr >
    <td >5</td>
    <td>Table in aluminium frame with glass</td>
    
    <td><a href="standfitting/Table.jpg" class="various3"><img src="standfitting/Table.jpg" alt="" /></a></td>
  </tr>
  <tr >
    <td >6</td>
    <td>70 W Metal Halide (Yellow)</td>
    
    <td><a href="standfitting/70-W-Metal-Halide-(White).jpg" class="various3"><img src="standfitting/70-W-Metal-Halide-(White).jpg" alt="" /></a></td>
  </tr>
  <tr >
    <td>7</td>
    <td>70 W Metal Halide (White)</td>
    
    <td><a href="standfitting/70-W-Metal-Halide-(White).jpg" class="various3"><img src="standfitting/70-W-Metal-Halide-(White).jpg" alt="" /></a></td>
  </tr>
  <!--<tr>
    <td>8</td>
    <td>Tall glass showcase thin with MDF paint finish LED spot & strip</td>
    
    <td><a href="standfitting/Tall-Glass-Showcase(Wide).jpg" class="various3"><img src="standfitting/Tall-Glass-Showcase(Wide).jpg" alt=""  /></a></td>
  </tr>-->
  <tr>
    <td>8</td>
    <td>Tall glass showcase wide with MDF paint finish LED spot & strip</td>
    
    <td><a href="standfitting/Tall-Glass-Showcase(Wide).jpg" class="various3"><img src="standfitting/Tall-Glass-Showcase(Wide).jpg" alt=""  /></a></td>
  </tr>
  <tr >
    <td>9</td>
    <td>Tray Storage</td>
    
    <td><a href="standfitting/Tray-Storage-signature.jpg" class="various3"><img src="standfitting/Tray-Storage-signature.jpg" alt="" /></a></td>
  </tr>
<?php } ?>
</table>
</div>
<div class="clear"></div>
</div>
<div class="clear"></div>
</div>
</div>
<div class="footer_wrap">
<?php include ('footer.php'); ?>
</div>
<!--footer ends-->
</body>
</html>
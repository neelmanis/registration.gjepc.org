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
$Exhibitor_Area=$fetch_data['Exhibitor_Area'];
$Exhibitor_Country_ID=$fetch_data['Exhibitor_Country_ID'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome to SIGNATURE</title>

<link rel="stylesheet" type="text/css" href="../css/mystyle.css" />

<!--navigation script-->
<!--<script type="text/javascript" src="../js/jquery_002.js"></script>-->
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
<div class="header_wrap">
	<?php include ('header.php'); ?>
</div>
<!-- header ends -->
<div class="clear"></div>
<!--banner starts-->
<!--<div class="banner_inner_wrap">
	<div class="banner_inner">
    	<img src="../images/highlight_banner.jpg" />    </div>
</div>-->
<!--banner ends-->
<div class="clear"></div>
<div class="container_wrap">
<div class="container">
<h1>Floral Items</h1>

<div id="formWrapper">
<div class="standimage">
<table cellspacing="0" cellpadding="0" class="common">

  <tr>
    <th>Sr. No.</th>
    <th>Description</th>
    <th>Charges For    Exhibitor</th>
    <th>Images</th>
  </tr>
  <tr >
    <td  ><div align="center">1</div></td>
    <td >Ficus    benjamina - pot size - 12&quot;, Height - 3' - 4'</td>
    <td >20/-</td>
    <td ><a href="../floral/ficus_benjamina.jpg" class="various3"><img src="../floral/ficus_benjamina.jpg" alt=""/></a></td>
  </tr>
  <tr >
    <td  ><div align="center">2</div></td>
    <td >Areca    palm - pot size - 14&quot; , height - 4' - 5'</td>
    <td >20/-</td>
    <td ><a href="../floral/areca_palm.jpg" class="various3"><img src="../floral/areca_palm.jpg" alt=""  /></a></td>
  </tr>
  <tr >
    <td  ><div align="center">3</div></td>
    <td >Ficus    variegated - pot size - 8&quot; , height - 2' - 3' </td>
    <td >20/-</td>
    <td ><a href="../floral/ficus_variegated.jpg" class="various3"><img src="../floral/ficus_variegated.jpg" alt=""  /></a></td>
  </tr>
  <tr >
    <td  ><div align="center">4</div></td>
    <td >Dracaena    Plant - 8&quot; , height - 2' - 3' </td>
    <td >20/-</td>
    <td ><a href="../floral/dracaena_plant.jpg" class="various3"><img src="../floral/dracaena_plant.jpg" alt=""  /></a></td>
  </tr>
  <tr >
    <td  ><div align="center">5</div></td>
    <td >Flower    Arrangement of Roses - A</td>
    <td >90/-</td>
    <td ><a href="../floral/flower_arrangement_roses.jpg" class="various3"><img src="../floral/flower_arrangement_roses.jpg" alt=""  /></a></td>
  </tr>
  <tr >
    <td  ><div align="center">6</div></td>
    <td >Flower    Arrangement of Roses - B</td>
    <td >125/-</td>
    <td ><a href="../floral/flower_arrangement_roses_b.jpg" class="various3"><img src="../floral/flower_arrangement_roses_b.jpg" alt=""  /></a></td>
  </tr>
  <tr >
    <td  ><div align="center">7</div></td>
    <td >Flower    Arrangement of Carnations -A</td>
    <td >140/-</td>
    <td ><a href="../floral/flower_arrangement_carnations_a.jpg" class="various3"><img src="../floral/flower_arrangement_carnations_a.jpg" alt="" /></a></td>
  </tr>
  <tr >
    <td  ><div align="center">8</div></td>
    <td >Flower    Arrangement of Carnations - B</td>
    <td >175/-</td>
    <td ><a href="../floral/flower_arrangement_carnations_b.jpg" class="various3"><img src="../floral/flower_arrangement_carnations_b.jpg" alt=""  /></a></td>
  </tr>
  <tr >
    <td  ><div align="center">9</div></td>
    <td >Flower    Arrangement of Lilium - A</td>
    <td >200/-</td>
    <td ><a href="../floral/flower_arrangement_lilium_A.jpg" class="various3"><img src="../floral/flower_arrangement_lilium_A.jpg" alt=""  /></a></td>
  </tr>
  <tr >
    <td  ><div align="center">10</div></td>
    <td >Flower    Arrangement of Lilium - B</td>
    <td >250/-</td>
    <td ><a href="../floral/flower_arrangement_lilium_B.jpg" class="various3"><img src="../floral/flower_arrangement_lilium_B.jpg" alt=""  /></a></td>
  </tr>
  <tr >
    <td  ><div align="center">11</div></td>
    <td >Flower    Arrangement of Anthurium - A</td>
    <td >150/-</td>
    <td ><a href="../floral/flower_arrangement_anthurium_A.jpg" class="various3"><img src="../floral/flower_arrangement_anthurium_A.jpg" alt=""/></a></td>
  </tr>
  <tr >
    <td  ><div align="center">12</div></td>
    <td >Flower    Arrangement of Anthurium - B</td>
    <td >200/-</td>
    <td ><a href="../floral/flower_arrangement_anthurium_B.jpg" class="various3"><img src="../floral/flower_arrangement_anthurium_B.jpg" alt="" /></a></td>
  </tr>
  <tr >
    <td  ><div align="center">13</div></td>
    <td >Flower    Arrangement of Orchids in a glass vase -A</td>
    <td >200/-</td>
    <td ><a href="../floral/Flower_Arrangement_Orchids_glass_vase_A.jpg" class="various3"><img src="../floral/Flower_Arrangement_Orchids_glass_vase_A.jpg" alt=""  /></a></td>
  </tr>
  <tr >
    <td  ><div align="center">14</div></td>
    <td >Flower    Arrangement of Orchids in a glass vase -B</td>
    <td >250/-</td>
    <td ><a href="../floral/flower_Arrangement_Orchids_glass_vase_B.jpg" class="various3"><img src="../floral/flower_Arrangement_Orchids_glass_vase_B.jpg" alt="" /></a></td>
  </tr>
  <tr >
    <td  ><div align="center">15</div></td>
    <td >Flower    Arrangement of Birds Of Paradise -A</td>
    <td >200/-</td>
    <td ><a href="../floral/Flower_Arrangement_Birds_Paradise_A.jpg" class="various3"><img src="../floral/Flower_Arrangement_Birds_Paradise_A.jpg" alt=""  /></a></td>
  </tr>
  <tr >
    <td  ><div align="center">16</div></td>
    <td >Flower    Arrangement of Birds Of Paradise -B</td>
    <td >250/-</td>
    <td ><a href="../floral/flower_Arrangement_Birds_Paradise_B.jpg" class="various3"><img src="../floral/flower_Arrangement_Birds_Paradise_B.jpg" alt=""  /></a></td>
  </tr>
  <tr >
    <td  ><div align="center">17</div></td>
    <td >5    Feet Long Flower Arrangement (Pedestial) - Exotic Flowers - A</td>
    <td >1250/-</td>
    <td ><a href="../floral/5_Feet_Long_Flower_Arrangement_(Pedestial)_Exotic_Flowers_A.jpg" class="various3"><img src="../floral/5_Feet_Long_Flower_Arrangement_(Pedestial)_Exotic_Flowers_A.jpg" alt=""  /></a></td>
  </tr>
  <tr >
    <td  ><div align="center">18</div></td>
    <td >6    Feet Long Flower Arrangement (Pedestial) - Exotic Flowers - B</td>
    <td >1300/-</td>
    <td ><a href="../floral/6_feet_long_flower_arrangement_Exotic_Flowers_B.jpg" class="various3"><img src="../floral/6_feet_long_flower_arrangement_Exotic_Flowers_B.jpg" alt=""/></a></td>
  </tr>
  <tr >
    <td  ><div align="center">19</div></td>
    <td >Arrangement    Of Assorted Normal Flowers - A</td>
    <td >200/-</td>
    <td ><a href="../floral/arrangement_Assorted_normal_Flowers_A.jpg" class="various3"><img src="../floral/arrangement_Assorted_normal_Flowers_A.jpg" alt="" /></a></td>
  </tr>
  <tr>
    <td><div align="center">20</div></td>
    <td >Arrangement    Of Assorted Normal Flowers - B</td>
    <td >250/-</td>
    <td ><a href="../floral/arrangement_Assorted_Exotic_Flowers_B.jpg" class="various3"><img src="../floral/arrangement_Assorted_Exotic_Flowers_B.jpg" alt="" /></a></td>
  </tr>
  <tr>
    <td  ><div align="center">21</div></td>
    <td >Arrangement    Of Assorted Exotic Flowers - A</td>
    <td >300/-</td>
    <td ><a href="../floral/arrangement_Assorted_Exotic_Flowers_A.jpg" class="various3"><img src="../floral/arrangement_Assorted_Exotic_Flowers_A.jpg" alt="" /></a></td>
  </tr>
  <tr >
    <td ><div align="center">22</div></td>
    <td >Arrangement    Of Assorted Exotic Flowers - B</td>
    <td >250/-</td>
    <td ><a href="../floral/arrangement_Assorted_Exotic_Flowers_B.jpg" class="various3"><img src="../floral/arrangement_Assorted_Exotic_Flowers_B.jpg" alt=""  /></a></td>
  </tr>
  <tr >
    <td  ><div align="center">23</div></td>
    <td >Table    top Arrangement - A</td>
    <td >150/-</td>
    <td ><a href="../floral/table_top_Arrangement_A.jpg" class="various3"><img src="../floral/table_top_Arrangement_A.jpg" alt="" /></a></td>
  </tr>
  <tr >
    <td  ><div align="center">24</div></td>
    <td >Table    top Arrangement - B</td>
    <td >200/-</td>
    <td ><a href="../floral/table_top_Arrangement_B.jpg" class="various3"><img src="../floral/table_top_Arrangement_B.jpg" alt=""  /></a></td>
  </tr>
  <tr >
    <td  ><div align="center">25</div></td>
    <td >Arrangement    for Exotic Flowers-A</td>
    <td >250/-</td>
    <td ><a href="../floral/arrangement_Exotic_Flowers_A.jpg" class="various3"><img src="../floral/arrangement_Exotic_Flowers_A.jpg" alt="" width="375" height="375" /></a></td>
  </tr>
  <tr >
    <td  ><div align="center">26</div></td>
    <td >Arrangement    for Exotic Flowers-B</td>
    <td >400/-</td>
    <td ><a href="../floral/arrangement_Exotic_Flowers_B.jpg" class="various3"><img src="../floral/arrangement_Exotic_Flowers_B.jpg" alt="" /></a></td>
  </tr>
  <tr >
    <td  ><div align="center">27</div></td>
    <td >Décor    for stall- A</td>
    <td >350/-    per feet</td>
    <td ><a href="../floral/decor_for_stall_A.jpg" class="various3"><img src="../floral/decor_for_stall_A.jpg" alt=""  /></a></td>
  </tr>
  <tr >
    <td  ><div align="center">28</div></td>
    <td >Décor    for stall- B</td>
    <td >300/-    per feet</td>
    <td ><a href="../floral/decor_stall_B.jpg" class="various3"><img src="../floral/decor_stall_B.jpg" alt=""  /></a></td>
  </tr>
  <!-- start from here -->
  
  <tr >
    <td  ><div align="center">29</div></td>
    <td >Décor    for stall- C</td>
    <td >400/-    per feet</td>
    <td ><a href="../floral/Decor_stall_C.jpg" class="various3"><img src="../floral/Decor_stall_C.jpg" alt="" width="302" height="302" /></a></td>
  </tr>
  <tr >
    <td  ><div align="center">30</div></td>
    <td >Décor    for stall- D</td>
    <td >350/-    per feet</td>
    <td ><a href="../floral/decor_stall_D.jpg" class="various3"><img src="../floral/decor_stall_D.jpg" alt="" /></a></td>
  </tr>
</table>

</div>

<div class="clear"></div>



</div>


<?php include ('advertise.php'); ?>

<div class="clear"></div>


</div>
</div>


<div class="footer_wrap">


<?php include ('footer.php'); ?>



</div>

<!--footer ends-->

</body>
</html>

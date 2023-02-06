<?php 
session_start();
include ("db.inc.php");
?>
<?php 
if(isset($_POST['actiontype']) && $_POST['actiontype']=="getBadgeDetails")
{
    $Badge_Item_ID = $_POST['Badge_Item_ID'];
	$query = $conn ->query("select * from iijs_badge_items where Badge_Item_ID='$Badge_Item_ID'");
    $rows = $query->fetch_assoc();
	
	echo "<table border='0' cellspacing='0' cellpadding='0' class='formManual'>";
    echo "<tr>";
    echo "<td width='29%'>Designation</td>";
    echo "<td width='6%'>:</td>";
    echo "<td width='65%'>$rows[Badge_Designation]</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>Photo</td>";
    echo "<td>:</td>";
    echo "<td><img src='images/badges/".$_SESSION['EXHIBITOR_CODE']."/$rows[Badge_Photo]' width='150px' height='120' /></td>";
    echo "</tr></table>";
    
}
?>

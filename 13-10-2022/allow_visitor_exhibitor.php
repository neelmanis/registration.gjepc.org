<?php include('db.inc.php');?>
<?php
$sqlx = "select uid from exhibitor_to_visitor";
$query=$conn->query($sqlx);
while($row=$query->fetch_assoc())
{
	$uid=$row['uid'];	
	$rowx = "SELECT * FROM exh_reg_payment_details WHERE uid='$uid' and `show`='IIJS 2019'";
	$result = $conn->query($rowx);
	$countx = $result->num_rows;
	if($countx > 0) 
	{
	echo $querxy = "update exh_reg_payment_details set allow_visitor='Y' where uid='$uid' and `show`='IIJS 2019'";
	echo '<br/>';
//	$result = $conn->query($querxy);
	} else	{
	echo 'Not Found';
	}
}
?>
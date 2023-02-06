<?php include 'db.inc.php';?>
<?php
$sqlquery = "SELECT registration_id ,name ,mobile,photo,paymentThrough,post_date FROM gjepclivedatabase.visitor_directory where isApplied='Y' and visitor_approval='Y' and `shows`='signature' and year='2020'";
$query=mysql_query($sqlquery);
while($row=mysql_fetch_array($query)){

$registration_id=$row['registration_id'];
$photo=$row['photo'];
$name=$row['name'];
$mobile=$row['mobile'];
$paymentThrough=$row['paymentThrough'];
$post_date=$row['post_date'];

$file_pointer = 'images/employee_directory/'.$registration_id."/photo/".$photo; 

if (file_exists($file_pointer))  
{ 
   //echo "The file $registration_id exists"; 
} 
else 
{ 
    echo $registration_id."==".$name."==".$mobile."==".$paymentThrough."====".$post_date; echo "<br/>";
} 

}

?>
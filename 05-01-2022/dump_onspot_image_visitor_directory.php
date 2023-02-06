<?php 
include('db.inc.php');

/*
SELECT * FROM `dump_visitor_directory` LIMIT 0, 100
SELECT * FROM `dump_visitor_directory` LIMIT 100, 100
SELECT * FROM `dump_visitor_directory` LIMIT 200, 100
SELECT * FROM `dump_visitor_directory` LIMIT 300, 100
SELECT * FROM `dump_visitor_directory` LIMIT 400, 100
SELECT * FROM `dump_visitor_directory` LIMIT 500, 100
SELECT * FROM `dump_visitor_directory` LIMIT 600, 100
SELECT * FROM `dump_visitor_directory` LIMIT 700, 100
SELECT * FROM `dump_visitor_directory` LIMIT 800, 100
SELECT * FROM `dump_visitor_directory` LIMIT 900, 100
SELECT * FROM `dump_visitor_directory` LIMIT 1000, 100
*/
//$query=mysql_query("SELECT registration_id,visitor_id,photo,salary_slip_copy,pan_copy,partner,paymentThrough FROM `dump_visitor_directory` WHERE `paymentThrough` = 'onSpot' LIMIT 0, 100");


$checkHistory = "SELECT registration_id,visitor_id,photo FROM `visitor_directory` where 1 AND visitor_approval='D' AND disapprove_reason='Kindly update your data.' AND paymentThrough='onSpot' LIMIT 10";
$resultQuery = $conn->query($checkHistory);
$num = $resultQuery->num_rows;
if($num>0)
{
	while($resultHistory = $resultQuery->fetch_assoc())
 	{
	$registration_id = $resultHistory['registration_id'];	
	$photos = $resultHistory['photo'];
//	echo $ext = strtolower(pathinfo($resultHistory['photo'], PATHINFO_EXTENSION)); // Using strtolower to overcome case sensitive
	$photo = str_replace('.JPG', '.jpg', $photos);	
	

	$directoryPath = 'images/covid/image/'.$registration_id;
	$subdirectoryPhoto = './'.$directoryPath.'/photo';
	
	if(!is_dir($registration_id)){
    mkdir($directoryPath, 0777);
    mkdir($subdirectoryPhoto, 0777);
	}
	
	//$destination  = 'images/covid/image/'.$visitorPhoto;
	
    $source ='images/signature_image2020/'.$photo;
    $destination  = 'images/covid/image/'.$registration_id.'/photo/'.$photo;
    copy($source ,$destination);

    //echo "Copied $source INTO $destination <br/>";
     
    if (!copy($source, $destination)) {
        echo "failed to copy $source...\n";
    }else{
        echo "copied $source into $destination <br/>";
    } 
	}
}
?>
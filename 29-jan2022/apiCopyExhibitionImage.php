<?php include('db.inc.php');?>
<h1> API to Move IVR Image From One Folder to Another</h1>
<?php


/*
$sqlx= "SELECT * FROM gjepclivedatabase.globalExhibition where status='Y' and dose2_status='Y' AND participant_Type='VIS' limit 500";
$result = $conn ->query($sqlx);
while($rows = $result->fetch_assoc())
{ //echo '<pre>'; print_r($rows); exit;
    $image = $rows['photo_url'];
    $registration_id = $rows['registration_id'];
	
	$file_name = basename(parse_url($image, PHP_URL_PATH));
	//echo $file_name; 
	echo '<br/>';
		
    $source ='images/employee_directory/'.$registration_id.'/photo/'.$file_name;
    $destination  = 'moveIVRimage1/'.$file_name;
	
    copy($source ,$destination);
    echo "Copied $source INTO $destination <br/>";
     
    if (!copy($source, $destination)) {
        echo "failed to copy $source...\n";
    }else{
        echo "copied $source into $destination\n";
    }
    
    //unlink($source);
    //echo '<pre>';
    //print_r($rows);
} */
?>
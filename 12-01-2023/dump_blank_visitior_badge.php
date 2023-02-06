<?php

include('db.inc.php');
//include('functions.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
exit;
for ($x = 1; $x <= 500; $x++) {
    $digits = 9;
    $vis_digits = 12;
    $registration_id = '88986215';
    $visitor_id = $x;//rand(pow(10, $vis_digits - 1), pow(10, $vis_digits) - 1);
    $uniqueIdentifier = rand(pow(10, $digits-1), pow(10, $digits)-1);
    $checkUniqueIdentifier = $conn->query("SELECT * FROM globalExhibition WHERE `uniqueIdentifier`='$uniqueIdentifier'");

    $countUniqueIdentifier = $checkUniqueIdentifier->num_rows;
    while($countUniqueIdentifier > 0) {
        $uniqueIdentifier = rand(pow(10, $digits-1), pow(10, $digits)-1);
    }
    $date = date('Y-m-d H:i:s');

    $insertGlobalParking = "INSERT INTO globalExhibition  SET `uniqueIdentifier`='$uniqueIdentifier',`registration_id`='$registration_id',`visitor_id`='$visitor_id',`srl_report_url`='1000',`participant_Type`='VIS',`event`='signature23',`status`='P',`post_date`='$date'";
    $insertParkingResult = $conn->query($insertGlobalParking);
    echo $insertParkingResult = 1;
}
    
    

?>
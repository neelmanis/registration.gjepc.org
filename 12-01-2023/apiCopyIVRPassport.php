<?php include('db.inc.php');?>
<h1> API to Move IVR Image From One Folder to Another</h1>
<?php
$sqlx= "SELECT passport_fid FROM  `ivr_registration_details` WHERE  `trade_show` = 'IIJS 2019' AND  `application_approved` = 'Y' limit 1";
$result=mysql_query($sqlx);
while($rows=mysql_fetch_array($result))
{ //echo '<pre>'; print_r($rows); exit;
    $image=$rows['passport_fid'];
    $source ='images/ivr_image/passport/'.$image;
    $destination  = 'movePassportIVR/'.$image;
    copy($source ,$destination);
    //echo "Copied $source INTO $destination <br/>";
     
    if (!copy($source, $destination)) {
        echo "failed to copy $source...\n";
    }else{
        echo "copied $source into $destination\n";
    }
     
    //unlink($source);
    //echo '<pre>';
    //print_r($rows);
}
?>
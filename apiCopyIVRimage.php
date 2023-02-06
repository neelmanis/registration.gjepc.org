<?php include('db.inc.php');?>
<h1> API to Move IVR Image From One Folder to Another</h1>
<?php
//$sqlx= "SELECT photograph_fid FROM  `ivr_registration_details` WHERE `trade_show` = 'Signature 2020' AND `application_approved` = 'Y' AND eid IN(1291,1269,1271,1270,1264,1275,1284,1258,1179,1287,1286,1268,1261,1278,1290,1289,607,1267,1254,1273,1276,1272,1274,626,1235,1266,1265)";
$sqlx= "SELECT photograph_fid FROM  `ivr_registration_details` WHERE `trade_show` = 'Signature 2020' AND `application_approved` = 'Y' limit 1";
$result=mysql_query($sqlx);
while($rows=mysql_fetch_array($result))
{ //echo '<pre>'; print_r($rows); exit;
    $image=$rows['photograph_fid'];
    $source ='images/ivr_image/photograph/'.$image;
    $destination  = 'moveIVRimage1/'.$image;
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
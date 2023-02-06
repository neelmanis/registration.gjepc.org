<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$app = "PradeeshGopalanGjepcindiaCom";
$username = "pradeesh.gopalan@gjepcindia.com";
$password = "gjepc@123";

function getTrkdapiToken($app, $username, $password)
{
   $trkdapi_url = "https://api.rkd.refinitiv.com";
   $trkdapi_tm_url = "$trkdapi_url/api/TokenManagement/TokenManagement.svc/REST/Anonymous/TokenManagement_1/CreateServiceToken_1";
   $trkdapi_tm_body = @"
   {
        "CreateServiceToken_Request_1":
        {
            "ApplicationID": "$app",
            "Username": "$username",
            "Password": "$password"
        }
    }
"@
 
   $w = invoke-webrequest -Uri $trkdapi_tm_url -Body $trkdapi_tm_body -ContentType "application/json" -Method Post
   $b = $w.Content
   $j = $b | ConvertFrom-Json
   $r = $j.CreateServiceToken_Response_1
   $t = $r.Token
   $e = $r.Expiration
   return $t
}

?>
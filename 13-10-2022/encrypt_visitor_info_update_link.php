<?php
function base64_url_encode($input)
{
return strtr(base64_encode($input), '+/=', '-_,');
}
//$pan_no ="HTEPS6574R";
$pan_no ="AOMPG8472N";

$encrypted_pan = base64_url_encode($pan_no);

header("location:https://registration.gjepc.org/visitor_info_update.php?key=$encrypted_pan");
?>
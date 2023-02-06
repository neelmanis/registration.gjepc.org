<?php
function base64_url_encode($input)
{
return strtr(base64_encode($input), '+/=', '-_,');
}
//$pan_no ="HTEPS6574R";
$pan_no ="AIMOJ7865N";

$encrypted_pan = base64_url_encode($pan_no);

header("location:https://registration.gjepc.org/iijs_visitor_payment_link.php?key=$encrypted_pan");
?>
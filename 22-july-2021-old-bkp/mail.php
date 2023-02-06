<?php 
$neel = "neelmani@kwebmaker.com";
$to_admin = "santosh@kwebmaker.com";
	$to_admins = $neel.",".$to_admin.",notification@gjepcindia.com,iijs.gjepc@gmail.com"; 
	//$to_admins = "neelmani@kwebmaker.com,sheetal.kesarkar@gjepcindia.com";
	$email_array = explode(",",$to_admins);
	//echo '<pre>'. print_r($email_array); 
	//echo '<pre>'. print_r($to_admin); exit;
	send_mailArray($email_array,"Hello Test Emails","This is test mail","");
	
	function send_mailArray($to, $subject, $message,$cc)
{ 
	/*Start Config*/
	$account="donotreply@gjepcindia.com";
	$password="welcome@321";
	$from="donotreply@gjepcindia.com";
	$from_name="GJEPC INDIA";
	$cc="";
    /*End Config*/
	
	include("phpmailer/class.phpmailer.php");
	$mail = new PHPMailer();
	$mail->IsSMTP();
	$mail->CharSet = 'UTF-8';
	$mail->Host = "smtp.live.com";
	$mail->SMTPAuth= true;
	$mail->Port = 587;
	$mail->Username= $account;
	$mail->Password= $password;
	$mail->SMTPSecure = 'tls';
	$mail->From = $from;
	$mail->FromName= $from_name;
	$mail->isHTML(true);
	$mail->Subject = $subject;
	$mail->Body = $message;
	foreach($to as $email_to){ $mail->addAddress($email_to); }
	if($cc!=''){ $mail->AddCC($cc); } 	
	if(!$mail->send()){
	 //return false;
	} else {
	 //return true;
	}
	}
?>
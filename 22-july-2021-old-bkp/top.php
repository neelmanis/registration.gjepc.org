<?php
	$message = 'Hello ';
	$to_admin = 'neelmani@kwebmaker.com';
	//$to = "notification@gjepcindia.com";
	//$to ='neelmani@kwebmaker.com';	
	$subject = "Exhibitor Registration for IIJS Signature 2020 (EXREG/IIJS Signature/2020/".$resultm['exh_id']."/dated".date('Y-m-d').")";
	$headers  = 'MIME-Version: 1.0' . "\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1'."\n";	
	$headers .='From: IIJS Signature 2020 <admin@gjepc.org>';	
	@mail($to, $subject, $message, $headers);
?>
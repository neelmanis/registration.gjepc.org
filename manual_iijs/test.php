<?php
$to = "ajit@kwebmaker.com,sawant.ajit11@gmail.com";
$subject = "Test mail";
$message = "Hello! This is a simple email message.";
$from = "admin@gjepc.org";
$headers = "From:" . $from;
mail($to,$subject,$message,$headers);
echo "Mail Sent.";
?>
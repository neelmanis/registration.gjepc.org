<?php 
$surname = "Shrikhande";
$name = "Santosh";
$qualification = "B.E.";
$position = "DEVEOPER";
$email = "tenvn@sdss.con";
$telephone = "0229898989898";
$cellno = "9898989898";
$fax = "9898989898";
$vcard = "BEGIN:VCARD\r\nVERSION:3.0\r\n
N:" . $surname . ";" . $name . "\r\n
FN:" . $name . " " . $surname . "\r\n
ORG:Example Organisation\r\n
TITLE:" . $position . " [" . $qualification . "]\r\n
TEL;TYPE=work,voice:" . $telephone . "\r\n
TEL;TYPE=cell,voice:" . $cellno . "\r\n
TEL;TYPE=work,fax:" . $fax . "\r\n
URL;TYPE=work:www.example.com\r\n
EMAIL;TYPE=internet,pref:" . $email . "\r\n
REV:" . date('Ymd') . "T195243Z\r\n
END:VCARD";
//$vcard = "BEGIN:VCARD VERSION:3.0 N:User;Test FN:Test User ORG:Example Organisation TITLE:asgfas [asgasg] TEL;TYPE=work,voice:2523626 TEL;TYPE=cell,voice:2365236 TEL;TYPE=work,fax:236236 URL;TYPE=work:www.example.com EMAIL;TYPE=internet,pref:testu@example.com REV:20121015T195243Z END:VCARD";

echo '<img src="http://chart.apis.google.com/chart?chs=500x500&cht=qr&chld=H&chl=' . urlencode($vcard) . '"/>';
?>
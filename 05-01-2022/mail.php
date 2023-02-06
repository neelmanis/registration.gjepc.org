<?php 

	$message ='<table class="table2" width="80%" bgcolor="#fbfbfb" align="center" style="margin:2% auto; border:2px solid #ddd; font-family:Arial, sans-serif; color:#333333; font-size:13px; border-radius:10px;padding:10px;">	
    <tbody>    
    	<tr>
            <td align="left"><img id="ri" src="https://registration.gjepc.org/images/logo.png">
            <td align="center"> <img id="mi"> </td>
            <td align="right"><img id="ri" src="https://registration.gjepc.org/images/logo/iijs-signature-22.png"></td>
            </td>                        
		</tr>
        <tr>
            <td align="center" colspan="3">
                <p style="line-height:25px;">
                    <h3 style="margin: 5px;">THE GEM JEWELLERY EXPORT PROMOTION COUNCIL</h3>
                    <b>GJEPC-H.O.-MUMBAI:1st Flr, Tower A,G Block, BDB, Bandra-Kurla Complex, Bandra(E)-400 051</b><br>
                    <b>GJEPC-E.X.-MUMBAI:G2-A, Trade Center, Bandra-Kurla Complex, Bandra(E)-400 051</b><br>
					<b>Toll Free Number :</b> 1800-103-4353, <b>Missed Call Number :</b> +91-7208048100<br>Website: https://gjepc.org/iijs-signature/ Email: visitors@gjepcindia.com</p>
            </td>
        </tr>              
        <tr><td colspan="3" height="30"><hr></td></tr>        
        <tr>           
        	<td colspan="3" id="content">
            	<table class="table1"width="100%" style="font-family:Arial, sans-serif; color:#333333; font-size:13px;">
                <tr>
                <td style="padding:0 10px;" align="left">Order ID: SIGN224221151 </td>
                <!--<td style="padding:0 60px;" align="right">Date: '.date("d-m-y").'</td>-->
                <td style="padding:0 60px;" align="right">Date: 10-12-21</td>
                </tr>                    
                </table>

                <table class="table2"width="100%" style="font-family:Arial, sans-serif; color:#333333; font-size:13px;" cellpadding="10">
                <tr>
                    <td width="20%">Received with Thanks From M/s: </td>
                    <td width="75%">THE JOSCO FASHION JEWELLERS </td>
                </tr>
                <tr>
                    <td width="20%">Rupees: </td>
                    <td width="75%">4000/-</td>
                </tr>
				<tr>
                    <td width="20%">Events: </td>
                    <td width="75%">IIJS SIGNATURE 2022</td>
                </tr>
				<tr>
                 <td width="100%" colspan="2">
                    <p style="text-align: left; width: 100%; padding-top: 10px; margin: 0;">
                 <strong>We thank you for your visitor registration for IIJS SIGNATURE 2022.  
					Please download GJEPC app to get the E-Badge of the show. All the visitors visiting the exhibition should be fully vaccinated.. Please Upload Your Vaccination Certificate. 
					<br/>For further assistance you may please feel free to contact us on 1800-103-4353 / OR give us missed call on +91-7208048100; or write to us on visitors@gjepcindia.com.</strong></p>				
                </td>
				</tr>
                <tr>
                <td width="100%" colspan="2">
                    <h4 style="text-align: center; width: 100%; padding-top: 30px; margin: 0;">This is a computer generated receipt requires no signature. Invoice as per GST Format would be dispatched separately.</h4>
                </td>
				</tr>

				 <tr>
                <td width="100%" colspan="2">
                    <p>
            <strong>Disclaimer:</strong> <span style="font-size: 10px">This information contained in this circular are provided for the purpose of making application for the participation and visiting IIJS SIGNATURE 2022 (the show). Please note that the Council reserves all the rights to postpone or cancel the show completely or partially without any prior intimation, subject to the changes in the Govt. rules and regulations and any such changes thereof for organising the show. In case of any delay or failure to organise the show which is caused by matters beyond reasonable control of the Council including, but not limited to the force majeure events, the Council shall not accept any responsibility or indemnity, whatsoever, and under no circumstance shall the Council have any liability to participants and visitors for any loss or damage of any kind incurred as a result of the postponement or cancellation of the show.</span> 
           </p>
                </td>
                </tr>
            </table>
		</td>            
        </tr>   
           <style type="text/css">
           .table2 input{width: 80%;border-left: none; border-right: none; border-top: none; border-bottom: 1px solid #000;}
               .table1 input{border-left: none; border-right: none; border-top: none; border-bottom: 1px solid #000; width: 150px;}
           }          
            .table2 h4{text-align: center;}
           </style>
	</tbody>
	</table>';	
	
//	$to = "neelmani@kwebmaker.com,akash@gjepcindia.com";
	//$to = $neel.",visitors@gjepcindia.com"; 
	$subject = "Thank you for registering at IIJS SIGNATURE 2022 SHOW"; 
	$cc = "";
	$email_array = explode(",",$to);
	send_mailArray($email_array,$subject,$message,$cc);
	
	function send_mailArray($to, $subject, $message,$cc)
	{ 
	/*Start Config*/
	$account="donotreply@gjepcindia.com";
	$password="Gjepc@786";
	$from="donotreply@gjepcindia.com";
	$from_name="GJEPC INDIA";
	$cc="";
    /*End Config*/
	
	include("phpmailer/class.phpmailer.php");
	$mail = new PHPMailer();
	$mail->IsSMTP();
	$mail->CharSet = 'UTF-8';
	$mail->Host = "smtp.live.com";
	$mail->Host = "smtp.office365.com";
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
<?php 
include('../header_include.php');
?>
<?php
$Payment_Master_ID=$_REQUEST['Payment_Master_ID'];
$CCTV_ID=$_REQUEST['CCTV_ID'];
$orderno=$_REQUEST['orderno'];
$exhibitor_code=$_SESSION['EXHIBITOR_CODE'];
$exhibitor_data="select * from iijs_exhibitor where Exhibitor_Code='$exhibitor_code'";
$result = $conn ->query($exhibitor_data);
$fetch_data = $result->fetch_assoc();

$Exhibitor_Name=$fetch_data['Exhibitor_Name'];
$Exhibitor_Contact_Person=$fetch_data['Exhibitor_Contact_Person'];
$Exhibitor_Phone=$fetch_data['Exhibitor_Phone'];
$Exhibitor_Fax=$fetch_data['Exhibitor_Fax'];

$Exhibitor_StallNo[]="";

for($i=0;$i<8;$i++){
	if($fetch_data["Exhibitor_StallNo".($i+1)]!="")
		$Exhibitor_StallNo[$i]=$fetch_data["Exhibitor_StallNo".($i+1)];
}

$stall_no=implode(", ",$Exhibitor_StallNo);

$Exhibitor_HallNo=$fetch_data['Exhibitor_HallNo'];
$Exhibitor_Region=$fetch_data['Exhibitor_Region'];
$Exhibitor_Section=$fetch_data['Exhibitor_Section'];
$Exhibitor_Area=$fetch_data['Exhibitor_Area'];
$Exhibitor_DivisionNo=$fetch_data['Exhibitor_DivisionNo'];

$Exhibitor_Address1=$fetch_data['Exhibitor_Address1'];
$Exhibitor_Address2=$fetch_data['Exhibitor_Address2'];
$Exhibitor_Address3=$fetch_data['Exhibitor_Address3'];

$Exhibitor_Email=$fetch_data['Exhibitor_Email'];
$Exhibitor_Email1=$fetch_data['Exhibitor_Email1'];
$Exhibitor_Pincode=$fetch_data['Exhibitor_Pincode'];
$Exhibitor_State=$fetch_data['Exhibitor_State'];
$Exhibitor_Country_ID=$fetch_data['Exhibitor_Country_ID'];
$Exhibitor_City=$fetch_data['Exhibitor_City'];
$Exhibitor_Website=$fetch_data['Exhibitor_Website'];
?>
<?php 
/*...............................Payment Details.....................................*/
$query =  $conn ->query("select * from iijs_payment_master where Payment_Master_ID='$Payment_Master_ID'");
$result= $query->fetch_assoc();

$Payment_Mode_ID=$result['Payment_Mode_ID'];
//$Surcharge_Rate=$result['Surcharge_Rate'];
$Create_Date=$result['Create_Date'];
?>
<?php 
   $query2= $conn ->query("select * from iijs_cctv where Payment_Master_ID='$Payment_Master_ID'");
   $result= $query2->fetch_assoc();
   $cctv_company=$result['CCTV_CompanyName'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="content-type" content="text/html; charset=windows-1252">
<title>IIJS Signature</title>
<link rel="stylesheet" type="text/css" href="../../css/mystyle.css" />
<link href="Signature%202013_files/styles_print.css" rel="stylesheet" type="text/css">
<script src="Signature%202013_files/ga.js" async="" type="text/javascript"></script>
<script type="text/javascript" language="javascript">
 function printWin()
 {
    window.print();
    return false;    
 }
function TABLE1_onclick() {
}
</script>
</head>
<body style="">
    <form name="form1" method="post" action="#" id="form1">
    <div>
        <table class="table_display_ack" style="margin: 0px auto;">
            <tbody><tr>
                <td align="center" valign="middle">
                    <table border="0" cellpadding="0" cellspacing="0" width="700">
                        <tbody>
						<tr >
                            <td ><img id="Image1" src="https://registration.gjepc.org/manual_signature/images/logo.png" style="border-width:0px;" align="left"></td>
                        </tr>
						 <tr align="center">
                        <td class="iijs_print" valign="bottom" style="font-size: 14px"><strong>Print Acknowledgement</strong></td>
                        </tr>
                    </tbody></table>
                </td>
            </tr>
            <tr>
                        <th colspan="8" style="background:#40a9e6; color:#fff;">
                        <h3 style="margin:0; display:inline-block; text-transform:uppercase; font-size: 18px">ELECTRONIC SURVEILLANCE</h3></th>
                    </tr>
           
            <tr>
                <td align="left" valign="top">
                    
<table id="tblMain_ExhibitorInfo" cellpadding="0" cellspacing="0" width="700">
    <tbody><tr>
        <h5 style="margin: 0 0 5px 0;padding: 6px;">Exhibitor Information :</h5>
    </tr>
    
    <tr>
        <td style="font-size: 14px"  class="black_subhead" align="left" valign="top" width="125">
            Order ID</td>
        <td style="font-size: 14px"  align="left" valign="top">
            :
            <span id="PrintAck_ExhibitorInfo1_lblExhibitorID"><?php echo $orderno;?></span>
        </td>
         <td style="font-size: 14px"  style="height: 18px" class="black_subhead" align="left" valign="top" width="125px">
            <span > Date</span></td>
        <td style="font-size: 14px"  style="height: 18px" align="left" valign="top">
            : 
            <span > <?php echo date('d/m/Y',strtotime($Create_Date));?></span>
        </td>
      
        
    </tr>
    <tr>
          <td style="font-size: 14px"  class="black_subhead" align="left" valign="top" width="125">
            Exhibitor ID</td>
        <td style="font-size: 14px"  align="left" valign="top">
            :
            <span id="PrintAck_ExhibitorInfo1_lblExhibitorID"><?php echo $exhibitor_code;?></span>
        </td>
        <td style="font-size: 14px"  style="height: 18px" class="black_subhead" align="left" valign="top" width="125px">
            Exhibitor Name </td>
        <td style="font-size: 14px"  style="height: 18px" align="left" valign="top">
            : <span ><?php echo $Exhibitor_Name;?></span></td>

    </tr>
    <tr>
        <td style="font-size: 14px"  class="black_subhead" style="height: 18px" align="left" valign="top">
            Contact Person</td>
        <td style="font-size: 14px"  align="left" valign="top">: 
            <span ><?php echo $Exhibitor_Contact_Person;?> </span>
        </td>
         <td style="font-size: 14px"  class="black_subhead">
           Section</td>
        <td style="font-size: 14px" > :
            <span ><?php echo $Exhibitor_Section; ?></span>
        </td>

    </tr>
 <tr style="height: 25px">
        <td style="font-size: 14px"  class="black_subhead">
            Stall No(s)</td>
        <td style="font-size: 14px" > :
            <span id="PrintAck_ExhibitorInfo1_lblStall"><?php echo $stall_no;?></span></td>
        <td style="font-size: 14px"  class="black_subhead">
            Hall No</td>
        <td style="font-size: 14px" > :
            <span ><?php echo $Exhibitor_HallNo;?></span></td>
    </tr>
    <tr >
        <td style="font-size: 14px"  class="black_subhead">
            Zone</td>
        <td style="font-size: 14px" > :
            <span><?php echo $Exhibitor_DivisionNo; ?></span></td>
        <td style="font-size: 14px"  class="black_subhead">
            Region</td>
        <td style="font-size: 14px" > :
            <span ><?php echo $Exhibitor_Region;?></span></td>
    </tr>
   
</tbody></table>

                </td>
            </tr>
          
           
			<tr>
                <td align="left">
                    <table>
                        <tbody><tr>
                            <td style="font-size: 14px" class="table_head" align="left" valign="middle"> CCTV Company</td>
                            <td style="font-size: 14px" align="center" valign="middle">:&nbsp;</td>								
                            <td style="font-size: 14px" align="left" valign="top">
                                <span id="radPaymentMode" disabled="disabled">
								<span disabled="disabled">
								<input type="radio" name="cctv_company" id="cctv_company" value="jaymit" disabled="disabled" <?php if($cctv_company=='jaymit'){?> checked="checked"<?php }?> />
								<label for="radPaymentMode_1">M/s Jaymit Security Systems Pvt. Ltd</label></span>
								<span disabled="disabled">
								<!--<input type="radio" name="cctv_company" id="cctv_company" value="exim" disabled="disabled" <?php if($cctv_company=='exim'){?> checked="checked"<?php }?> />
								<label for="radPaymentMode_2">Ankitst Exim</label></span>
								<span disabled="disabled">
								<input type="radio" name="cctv_company" id="cctv_company" value="sai" disabled="disabled" <?php if($cctv_company=='sai'){?> checked="checked"<?php }?> />
								<label for="radPaymentMode_2">Sai Enterprises</label></span>
								<span disabled="disabled">-->
								<input type="radio" name="cctv_company" id="cctv_company" value="spectra" disabled="disabled" <?php if($cctv_company=='spectra'){?> checked="checked"<?php }?> />
								<label for="radPaymentMode_2">Spectra Services</label></span>						
								
								</span>&nbsp;
						   </td>
                        </tr>
                    </tbody></table>
                </td>
            </tr>
            <tr>
                <td align="left">
                    <table>
                        <tbody><tr>
                            <td style="font-size: 14px" class="table_head" align="left" valign="middle"> Payment Mode &nbsp;</td>
                            <td style="font-size: 14px" align="center" valign="middle"> :&nbsp;</td>
								
                            <td style="font-size: 14px" align="left" valign="top">
                                <span id="radPaymentMode" disabled="disabled"><span disabled="disabled">
								<!--<input id="radPaymentMode_0" name="radPaymentMode" value="1" disabled="disabled" type="radio" <?php if($Payment_Mode_ID==1){?> checked="checked"<?php }?>>
								<label for="radPaymentMode_0">Credit Card</label>-->
								</span><span disabled="disabled">
								<input id="radPaymentMode_1" name="radPaymentMode" value="2"  disabled="disabled" type="radio" <?php if($Payment_Mode_ID==2){?> checked="checked"<?php }?>>
								<label for="radPaymentMode_1">NEFT</label></span><span disabled="disabled">
								<input id="radPaymentMode_2" name="radPaymentMode" value="4" disabled="disabled" type="radio" <?php if($Payment_Mode_ID==4){?> checked="checked"<?php }?>>
								<label for="radPaymentMode_2">RTGS</label></span></span>&nbsp;
						   </td>
                        </tr>
                    </tbody></table>
                </td>
            </tr>
            
            <tr>
                <td  style="font-size: 14px" align="left" valign="top">
                    <div>
	<table rules="all" id="gvStand" style="width:100%;border-collapse:collapse;" border="1" cellspacing="0">
		<tbody> <tr style="background:#40a9e6; color:#fff;">
			<th scope="col" align="left">Item Description</th><th scope="col">Price</th><th scope="col">Qty</th><th scope="col">Total</th>
		</tr>
		<?php 		
		$totamt=0;
		$query = $conn ->query("select * from iijs_cctv_items where CCTV_ID='$CCTV_ID'");
		while($result= $query->fetch_assoc()){
		$totamt=$totamt+$result['CCTV_Items_Rate']*$result['CCTV_Items_Quantity'];
		?>
		<tr align="left">
			<td style="font-size: 14px;" align="left">
			<span id="gvStand_ctl02_lblItemDescForms"><?php echo getElectronicItemName($result['CCTV_Items_Master_ID'],$conn);?></span>
			</td>
			<td style="font-size: 14px;text-align: center;" align="left">
			<span id="gvStand_ctl02_lblPrice"><?php echo $result['CCTV_Items_Rate'];?></span>
			</td><td style="font-size: 14px;text-align: center;" align="left">
			<span id="gvStand_ctl02_lblQty" style="display:inline-block;width:99px;text-align: center;"><?php echo $result['CCTV_Items_Quantity'];?></span>
			</td><td style="font-size: 14px;text-align: center;" align="left">
			<span id="gvStand_ctl02_lblTotalAmt" disabled="disabled"><?php echo $result['CCTV_Items_Rate']*$result['CCTV_Items_Quantity'];?></span>
			</td>
		</tr>	
		<?php }?>	
	</tbody>
</table>
</div>
                </td>
            </tr>
            <tr>
                <td align="left" height="10" valign="top">
                </td>
            </tr>
            <tr>
                <td align="right" valign="top">
                    <table class="table_display" cellpadding="0" cellspacing="0" width="100%">
                        <tbody>
						<tr>
                            <td class="ack_text" style="width: 70%;" align="left" valign="top"></td>
                            <td class="ack_text" style="width: 20%;font-size: 14px" align="left" valign="top"><b>Total Amount</b>  </td>
                            <td class="ack_text" style="width: 1%" align="center" valign="top">:</td>
                            <td class="ack_text" style="width: 9%;font-size: 14px" align="left" valign="top">
                                &nbsp;<span id="lblAmount"><?php echo $totamt;?></span></td>
                        </tr>
                        <tr>
                            <td class="ack_text" style="width: 70%" align="left" valign="top"></td>
                            <td class="ack_text" style="width: 20%;font-size: 14px" align="left" valign="top"> <b>GST (18%)</b>                             </td>
                            <td class="ack_text" style="width: 1%" align="center" valign="top">:</td>
                            <td class="ack_text" style="width: 19%;font-size: 14px" align="left" valign="top">
                                &nbsp;<span id="lblserviceTax"><?php echo $service_tax=$totamt*18/100;?></span></td>
                        </tr>
                        <!--<tr>
                            <td class="ack_text" style="width: 49%" align="left" valign="top"></td>
                            <td class="ack_text" style="width: 30%" align="left" valign="top">
                              Swachh Bharat Cess (0.50%)</td>
                            <td class="ack_text" style="width: 1%" align="center" valign="top">:</td>
                            <td class="ack_text" style="width: 20%" align="left" valign="top">
                                &nbsp;
                                <span id="lblCess"><?php echo $e_cess_tax=$totamt*.50/100;?></span></td>
                        </tr>-->
		

                        <tr>
                            <td class="ack_text" style="width: 70%" align="left" valign="top"></td>
                            <td class="ack_text" style="width: 20%;font-size: 14px" align="left" valign="top">
                               <b>Total Payable:</b>                             </td>
                            <td class="ack_text" style="width: 1%" align="center" valign="top">
                                :</td>
                            <td class="ack_text" style="width: 19%;font-size: 14px" align="left" valign="top">
                                &nbsp;<span id="lblTotaAmount"><?php echo $total_payble= round($totamt+$service_tax);?></span></td>
                        </tr>
						<tr>
						<td style="font-size: 14px">Cheque will be in Favour of :
						<ol>
						<?php if($cctv_company=='jaymit') { ?>
							<strong>M/s Jaymit Security Systems Pvt. Ltd</strong><br />
							<strong>BANK:</strong> Indian Bank<br />
							<strong>BRANCH:</strong> Prarthna Samaj<br />
							<strong>ACCOUNT NO.:</strong> 417749843<br />
							<strong>IFSC CODE:</strong> IDIB000P049<br />
							<strong>Address:</strong> 19. Tinwala Bldg; Tribhuvan road,<br />
							Near, Dreamland Cinema,<br />
							Mumbai - 400 004<br />
							<strong>Contact Person:</strong> Mr. Rajiv Mody / Mr. sanjeev Chavan<br />
							<strong>Contact Number:</strong> +91 9004603313 / +91 9323104011 / 022 23864011<br />
							<strong>Email:</strong> sanjeev@jaymit.com / rajiv@jaymit.com / info@jaymit.com<br />
							
						<?php	} elseif($cctv_company=='spectra') { ?>
							<strong>Spectra Services</strong><br />
							<strong>BANK:</strong> Canara Bank<br />
							<strong>BRANCH:</strong> Vakola,Santacruz<br />
							<strong>ACCOUNT NO.:</strong> 0119201002842<br />
							<strong>IFSC CODE:</strong> CNRB0000119<br />
							<strong>Address:</strong> 707, Pride of Vakola Bldg, Vakola pipeline,<br />
							Santacruz East,<br />
							Mumbai-400055<br />
							<strong>Contact Person:</strong> Mr Rajesh & MS Pushpa<br />
							<strong>Contact Number:</strong> +91 8879970901 / +91 9820748996<br />
							<strong>Email:</strong> nemarajesh8@gmail.com, rajesh@spectraservices.co.in<br />	
							
						<?php	} elseif($cctv_company=='sai') { ?>
							<strong>Sai Enterprises</strong><br />
							<strong>BANK:</strong> BANK OF BARODA<br />
							<strong>BRANCH:</strong> ASAF ALI ROAD, NEW DELHI<br />
							<strong>ACCOUNT NO.:</strong> 00930200000236<br />
							<strong>IFSC CODE:</strong> BARB0ASAFAL<br />
							<strong>Address:</strong> 2354, Street Ravidass,<br />
							Bazar Sita Ram,<br />
							Delhi - 110006<br />
							<strong>Contact Person:</strong> Mr. Navrattan Gautam / Mr. Ramesh Gautam <br />
							<strong>Contact Number:</strong> +91 9873092354 / + 91 9811393599<br />
							<strong>Email:</strong> gautamenterprises@hotmail.com / gautamenterprises1@yahoo.com<br />
						
						<?php	} elseif($cctv_company=='exim') { ?>
							<strong>ANKITST EXIM INC.</strong><br />
							<strong>BANK:</strong> KOTAK MAHINDRA BANK <br />
							<strong>BRANCH:</strong> Vile Parle (West)<br />
							<strong>ACCOUNT NO.:</strong> 3511893697<br />
							<strong>IFSC CODE:</strong> KKBK0000674<br />
							<strong>Address:</strong> Shop No.1A, 1B, 2 & 3,Irla Majhithia Apartment,189, Vile Parle (West), Mumbai - 400 056.Maharashtra, India,<br />
							Mumbai - 400093<br />
							<strong>Contact Person:</strong> Mr. Vinay Bangera / Ms. Rupali <br />
							<strong>Contact Number:</strong> +91 8828108395 / 022-42724055<br />
							<strong>Email:</strong> iijscctv@gmail.com<br />
						<?php }	?>						
						 </ol>
						</td>
						</tr>
                    </tbody></table>
                </td>
            </tr>
            
            <tr>
                <td style="height: 26px">
                    &nbsp;&nbsp;
                    <input name="btnPrint" id="btnPrint" src="print.jpg" onclick="printWin();" style="border-width:0px;" type="image">&nbsp;<input name="btnCancel" id="btnCancel" src="cancel_btn.jpg" style="border-width:0px;" type="image"></td>
            </tr>
        </tbody></table>
    </div>
    </form>
</body>
</html>
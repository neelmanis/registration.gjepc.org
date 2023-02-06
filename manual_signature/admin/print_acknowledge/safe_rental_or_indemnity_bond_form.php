<?php include('../../header_include.php');?>
<?php
$Payment_Master_ID=$_REQUEST['Payment_Master_ID'];
$Safe_Rental_ID=$_REQUEST['Safe_Rental_ID'];
$orderno=$_REQUEST['orderno'];
$Badge_Item_ID1=$_REQUEST['Badge_Item_ID1'];
$Badge_Item_ID2=$_REQUEST['Badge_Item_ID2'];
$exhibitor_code=$_REQUEST['Exhibitor_Code'];
$exhibitor_data="select * from iijs_exhibitor where Exhibitor_Code='$exhibitor_code'";
$result=$conn ->query($exhibitor_data);
$fetch_data=$result->fetch_assoc();

$gcode=$fetch_data['Customer_No'];
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
$query=$conn ->query("select * from iijs_payment_master where Payment_Master_ID='$Payment_Master_ID'");
$result=$query->fetch_assoc();

$Payment_Mode_ID=$result['Payment_Mode_ID'];
$Surcharge_Rate=$result['Surcharge_Rate'];
$Create_Date=$result['Create_Date'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="content-type" content="text/html; charset=windows-1252">
<title>SAFE RENTAL ACKNOWLEDGEMENT</title>
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
<body>

     <div>
         &nbsp;</div>
        <table class="table_display_ack" style="margin: 0px auto;">
            <tbody><tr>
                <td style="border-bottom: #ededed 1px solid" align="center" valign="middle">
                    <table border="0" cellpadding="0" cellspacing="0" width="700">
                        <tbody>
						<tr>
                            <td>
                                <img src="../../images/logo.png" style="border-width:0px;" align="left"></td>
						</tr>
							<tr>
                            <td align="right">
                                Print Acknowledgement
							 </td>
                        </tr>
                    </tbody></table>
                </td>
            </tr>
            <tr align="center"><td>SAFE RENTAL / INDEMNITY BOND FORM</td></tr> <tr>
                <td align="left">
                    
<table id="tblMain_ExhibitorInfo" cellpadding="0" cellspacing="0" width="700">
    <tbody>
	<tr>
        <td colspan="4" class="black_subhead" style="background-color:#ededed;" align="left" valign="bottom">
        <span style="padding-top:5px">&nbsp;Exhibitor Information</span></td>
    </tr>
    <tr>
        <td align="left" height="7" valign="top" width="125">
        </td>
        <td align="left" height="7" valign="top">
        </td>
        <td align="left" height="7" valign="top" width="125">
        </td>
        <td align="left" height="7" valign="top">
        </td>
    </tr>
    <tr>
        <td class="black_subhead" align="left" valign="top" width="125">
            &nbsp;Exhibitor ID</td>
        <td align="left" valign="top">
            :
            <span id="PrintAck_ExhibitorInfo1_lblExhibitorID"><?php echo $exhibitor_code;?></span></td>
        <td class="black_subhead" align="left" valign="top" width="125">
        </td>
        <td align="left" valign="top">
        </td>
    </tr>
    <tr>
        <td style="height: 18px" class="black_subhead" align="left" valign="top" width="125px">
            &nbsp;Exhibitor Name </td>
        <td style="height: 18px" align="left" valign="top">
            : <span id="PrintAck_ExhibitorInfo1_lblName"><?php echo $Exhibitor_Name;?></span></td>
        <td style="height: 18px" class="black_subhead" align="left" valign="top" width="125px">
            <span id="PrintAck_ExhibitorInfo1_lblTxt">Order No &amp; Date</span></td>
        <td style="height: 18px" align="left" valign="top"> : 
        <span id="PrintAck_ExhibitorInfo1_lblOrderNoAndDt"><?php echo $orderno;?> - <?php echo date('d/m/Y',strtotime($Create_Date));?></span></td>
    </tr>
    <tr>
        <td class="black_subhead" style="height: 18px" align="left" valign="top">
            &nbsp;Contact Person</td>
        <td align="left" valign="top">
            : 
            <span id="PrintAck_ExhibitorInfo1_lblContactPerson"><?php echo $Exhibitor_Contact_Person;?> </span></td>
    </tr>
 <tr style="height: 25px">
        <td class="black_subhead">
            &nbsp;Stall No(s)</td>
        <td>:  <span id="PrintAck_ExhibitorInfo1_lblStall"><?php echo $stall_no;?></span></td>
        <td class="black_subhead">
            &nbsp;Hall No</td>
        <td> : <span id="PrintAck_ExhibitorInfo1_lblHall"><?php echo $Exhibitor_HallNo;?></span></td>
    </tr>
    <tr style="height: 25px">
        <td class="black_subhead">&nbsp;Zone</td>
        <td>  : <span id="PrintAck_ExhibitorInfo1_lblZone"><?php echo $Exhibitor_DivisionNo; ?></span></td>
        <td class="black_subhead">
            &nbsp;Region</td>
        <td> :  <span id="PrintAck_ExhibitorInfo1_lblRegion"><?php echo $Exhibitor_Region;?></span></td>
    </tr>
    <tr style="height: 25px">
        <td class="black_subhead">
            &nbsp;Section</td>
        <td>  :  <span id="PrintAck_ExhibitorInfo1_lblSection"><?php echo getSection_desc($Exhibitor_Section,$conn); ?></span></td>
   </tr>
</tbody></table>
                </td>
            </tr>
        <tr>
                <td class="black_subhead" style="text-align:left;border-bottom: #2f2f2f 1px solid">
                    
                    Acknowledgement for Safe Key Holder</td>
            </tr>
	<?php 
		$sql=$conn ->query("SELECT * FROM `iijs_badge_items` WHERE `Badge_Item_ID`='$Badge_Item_ID1'");
		$result=$sql->fetch_assoc();
		$name1=$result['Badge_Name'];
		$Badge_Designation1=$result['Badge_Designation'];
		$Badge_Photo1=$result['Badge_Photo'];
		$sql=$conn ->query("SELECT * FROM `iijs_badge_items` WHERE `Badge_Item_ID`='$Badge_Item_ID2'");
		$result=$sql->fetch_assoc();
		$name2=$result['Badge_Name'];
		$Badge_Designation2=$result['Badge_Designation'];
		$Badge_Photo2=$result['Badge_Photo'];
	?>
			
            <tr>
                <td>
                    <table class="table_display">
                        <tbody><tr>
                            <td align="left"></td>
                            <td align="left">Key Person 1 </td>
                            <td align="left"></td>
                            <td align="left">Key Person 2</td>
                        </tr>
                        <tr>
                            <td align="left">Name</td>
                            <td align="left">
                                <input name="txtKeyHolder1" value="<?php echo $name1;?>" id="txtKeyHolder1" disabled="disabled" class="iijs_input_box" type="text"></td>
                            <td align="left">Name</td>
                            <td align="left">
                                <input name="txtKeyHolder2" value="<?php echo $name2;?>" id="txtKeyHolder2" disabled="disabled" class="iijs_input_box" type="text"></td>
                        </tr>
                        <tr>
                            <td align="left" valign="top">Photograph</td>
                            <td align="left"><img id="imgKeyPerson1" src="../../images/badges/<?php echo $exhibitor_code."/".$Badge_Photo1;?>" alt="Key Holder 1 Photo" style="height:100px;width:100px;border-width:0px;" /></td>
              <td align="left" valign="top">Photograph</td>
                            <td align="left">
                                <img id="imgKeyPerson2" src="../../images/badges/<?php echo $exhibitor_code."/".$Badge_Photo2;?>" alt="Key Holder 2 Photo" style="height:100px;width:100px;border-width:0px;"></td>
                        </tr>
                        <tr>
                            <td colspan="2" align="left"></td>
                            <td colspan="2" align="left"></td>
                        </tr>
                        <tr>
                            <td colspan="2" align="center"></td>
                            <td colspan="2" align="center"></td>
                        </tr>
                    </tbody></table>
              </td>
            </tr>
            <tr><td>&nbsp;</td>
            </tr>
            <tr>
                <td class="black_subhead" style="text-align:left;border-bottom: #2f2f2f 1px solid">
                    Acknowledgement for Safe Rental </td>
            </tr>
            <tr>
                <td>
                    <table class="table_display">
                        <tbody><tr>
                            <td class="ack_text" style="width: 103px" align="left">
                                Payment Mode &nbsp;</td>
                            <td align="left">
                                :&nbsp;</td>
                            <td align="left">
                                <span id="radPaymentMode" disabled="disabled"><span disabled="disabled"><input id="radPaymentMode_0" name="radPaymentMode" value="4" checked="checked" disabled="disabled" type="radio"><label for="radPaymentMode_0">NEFT</label></span></span></td>
                        </tr>
                    </tbody></table>
                </td>
            </tr>	
			
	<tr>
		<td align="left" valign="top">
		<div>
			<table rules="all" id="gvsafeRental" style="height:25px;width:100%;border-collapse:collapse;" border="1" cellspacing="0">
				<tbody>
				<tr>
				<th scope="col">Item Description</th>
				<th scope="col">Item Rate</th>
				<th scope="col">Qty</th><th scope="col">Total</th>
				</tr>
			<?php 
				$totamt=0;		
				$query=$conn ->query("select * from iijs_safe_rental_items where Safe_Rental_ID='$Safe_Rental_ID'");
				while($result=$query->fetch_assoc()){
				$totamt=$totamt+$result['Item_Rate']*$result['Item_Quantity'];
			?>	
			<tr>
				<td><?php echo getSaferentalId($result['Safe_ID'],$conn);?></td>
				<td>
				<span id="gvsafeRental_ctl02_lblDate3"><?php echo $result['Item_Rate'];?></span> 
				</td>
				<td>
				<span id="gvsafeRental_ctl02_lblQtyForms" style="display:inline-block;width:99px;"><?php echo $result['Item_Quantity'];?></span> 
				</td>
				<td> 
				<span id="gvsafeRental_ctl02_lblTotalAmt" disabled="disabled" style="display:inline-block;width:99px;"><?php echo $result['Item_Rate']*$result['Item_Quantity'];?></span> 
				</td>
			</tr>
				<?php }?>
				</tbody>
			</table>
		</div>
		</td>
	</tr>
		
            <tr>
                <td>
                    <table class="table_display">
                        <tbody><tr>
                            <td style="width: 156px" align="left"></td>
                            <td style="width: 182px" align="left"></td>
                            <td style="width: 137px" align="left"><strong>
                            Total Amount :</strong></td>
                            <td align="left">
                                &nbsp;&nbsp;
                            <span id="lblTotalAmount" style="font-weight:bold;"><?php echo $totamt;?></span></td>
                        </tr>
                        <tr>
                            <td style="width: 156px" align="left" valign="top">
                            </td>
                            <td style="width: 182px" align="left">
                                &nbsp;&nbsp;
                            </td>
                            <td style="width: 137px" align="left">
                            </td>
                            <td style="width: 230px" align="left">
                            </td>
                        </tr>
		<?php 
		$query=$conn ->query("select Location_Layout from iijs_safe_rental where Safe_Rental_ID='".$_REQUEST['Safe_Rental_ID']."'");
		$result=$query->fetch_assoc();
		$Location_Layout=$result['Location_Layout'];
		
		?>
                        <tr>
                            <td style="width: 156px" align="left" valign="top">
                                <strong>Safe Key Location </strong>
                            </td>
                            <td style="width: 182px" align="left">
                    <img id="imgLocationlayout" src="../../images/Location_Layout/<?php echo $exhibitor_code."/".$Location_Layout;?>" alt="Location Layout" style="height:100px;width:100px;border-width:0px;"></td>
                            <td style="width: 137px" align="left">
                                </td>
                            <td style="width: 230px" align="left">
                                </td>
                        </tr>
                    </tbody></table>
                </td>
            </tr>
            <tr>
                <td><table class="table_display">
                    <tbody><tr>
                        <td class="ack_text" style="width: 461px" align="right">
                            </td>
                        <td class="ack_text" align="center">
                            </td>
                    </tr>
                </tbody></table>
                </td>
            </tr>
            <tr>
                <td>
                    </td>
            </tr>
            <tr>
                <td style="height: 44px">
                    <table class="table_display">
                        <tbody><tr>
                            <td class="ack_text" align="left" height="20">
                            </td>
                            <td class="ack_text" align="right" height="20">
                            </td>
                        </tr>
                        <tr>
<td colspan="2" class="ack_text" align="left">
<p style="font-size: 14px"><strong>Note :</strong> </p>
<p style="margin-left:0.5in;font-size: 14px">
1) After form submission, please print an acknowledgment and "AFFIDAVIT CUM INDEMNITY BOND" <br/> printed on stamp paper minimum value of Rs 200 & notary and</p>
<p style="margin-left:0.5in;font-size: 14px"><strong>Return to:</strong> <strong>The Gem &amp; Jewellery Export Promotion Council</strong><br />
D2B, Ground Floor,'D' Tower, West Core,<br />
Bharat Diamond Bourse, 'G' Block, <br /> Bandra Kurla Complex, Bandra (E), Mumbai - 400 051, India<br />
Call Centre No. : 1800-103-4353 Missed Call No: +91 7208048100<br />
Email: iijs@gjepcindia.com</p>
<p style="margin-left:0.5in;font-size: 14px">2) For payment approval UTR number / Payment details should be updated within 3 working days after order date. </p>
<p style="margin-left:0.5in;font-size: 14px">3) The AFFIDAVIT CUM INDEMNITY BOND required to notary before submission  </p>
<p style="margin-left:0.5in;font-size: 14px">3) NEFT Details
        <strong><u>For Domestic Exhibitors only</u></strong><br />
        Company Name : Godrej & Boyce Mfg. Co. Ltd<br />
        Name of the Bank : CITIBANK<br />
        Branch Address : D. N. Road, Fort, Mumbai 400001<br />
        MICR code : 400037002<br />
        Type of Account with code (10/11/13) : Current Account 11<br />
        Account Number : 0003708748<br />
        NEFT IFSC Code (11 digit) : CITI0100000<br />
        
        <strong>Telephone No: 022 6651 5603/04</strong><br /></p>
</td>
                        </tr>
                    </tbody></table>
                </td>
            </tr>
            <tr>
                <td>&nbsp;
                    </td>
            </tr>
            <tr>
                <td>
                    &nbsp;&nbsp;
                    <input name="btnPrint" id="btnPrint" src="print.jpg" onclick="printWin();" style="border-width:0px;" type="image">&nbsp;<input name="btnCancel" id="btnCancel" src="cancel_btn.jpg" style="border-width:0px;" type="image"></td>
            </tr>
        </tbody></table>
    </form>
</body></html>
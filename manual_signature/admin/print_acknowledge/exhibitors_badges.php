<?php 
include('../../header_include.php');
?>
<?php
$Payment_Master_ID=$_REQUEST['Payment_Master_ID'];
$Badge_ID=$_REQUEST['Badge_ID'];

$exhibitor_code=$_REQUEST['EXHIBITOR_CODE'];
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
$Create_Date=$result['Create_Date'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="content-type" content="text/html; charset=windows-1252">
<title>	IIJS-Signature <?php echo date("Y"); ?></title>
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
						<tr>
                            <td>
                                <img id="Image1" src="../../images/logo.png" style="border-width:0px;" align="left">
							</td>
						</tr>
						<tr align="right">
                            <td class="iijs_print" valign="bottom">Print Acknowledgement</td>
                        </tr>
                    </tbody></table>
                </td>
            </tr>
            <tr>
                <td align="center">EXHIBITOR BADGES FORM</td>
            </tr>
            <tr>
                <td align="left" valign="top">
                    
<table id="tblMain_ExhibitorInfo" cellpadding="0" cellspacing="0" width="700">
    <tbody><tr>
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
        <td style="height: 18px" class="black_subhead" align="left" valign="top" width="125px">
            <span id="PrintAck_ExhibitorInfo1_lblTxt">G Code</span></td>
        <td style="height: 18px" align="left" valign="top">: 
            <span id="PrintAck_ExhibitorInfo1_lblOrderNoAndDt"><?php echo $gcode;?></span></td>
    </tr>
    <tr>
        <td style="height: 18px" class="black_subhead" align="left" valign="top" width="125px">
            &nbsp;Exhibitor Name </td>
        <td style="height: 18px" align="left" valign="top">
            : <span id="PrintAck_ExhibitorInfo1_lblName"><?php echo $Exhibitor_Name;?></span></td>
        <td style="height: 18px" class="black_subhead" align="left" valign="top" width="125px">
            <span id="PrintAck_ExhibitorInfo1_lblTxt">Order No &amp; Date</span></td>
        <td style="height: 18px" align="left" valign="top">
            : 
            <span id="PrintAck_ExhibitorInfo1_lblOrderNoAndDt">1 - <?php echo date('d/m/Y',strtotime($Create_Date));?></span></td>
    </tr>
    <tr>
        <td class="black_subhead" style="height: 18px" align="left" valign="top">
            &nbsp;Contact Person</td>
        <td align="left" valign="top">   : 
            <span id="PrintAck_ExhibitorInfo1_lblContactPerson"><?php echo $Exhibitor_Contact_Person;?> </span></td>
    </tr>
 <tr style="height: 25px">
        <td class="black_subhead">
            &nbsp;Stall No(s)</td>
        <td>  :
            <span id="PrintAck_ExhibitorInfo1_lblStall"><?php echo $stall_no;?></span></td>
        <td class="black_subhead">
            &nbsp;Hall No</td>
        <td> :
            <span id="PrintAck_ExhibitorInfo1_lblHall"><?php echo $Exhibitor_HallNo;?></span></td>
    </tr>
    <tr style="height: 25px">
        <td class="black_subhead">
            &nbsp;Zone</td>
        <td>:
            <span id="PrintAck_ExhibitorInfo1_lblZone"><?php echo $Exhibitor_DivisionNo; ?></span></td>
        <td class="black_subhead">
            &nbsp;Region</td>
        <td> :
            <span id="PrintAck_ExhibitorInfo1_lblRegion"><?php echo $Exhibitor_Region;?></span></td>
    </tr>
    <tr style="height: 25px">
        <td class="black_subhead">
            &nbsp;Section</td>
        <td>:
            <span id="PrintAck_ExhibitorInfo1_lblSection"><?php echo $Exhibitor_Section; ?></span></td>
   </tr>
</tbody></table>

                </td>
            </tr>
            <tr>
                <td align="left" height="10" valign="top">
                </td>
            </tr>
            <tr>
                <td class="black_subhead" align="left">
                    <span id="lblOwnStall">No</span>, I'm <span id="lblNot">not </span>constructing my own stall.</td>
            </tr>
			
            <tr>
                <td align="left">
                    <table>
                        <tbody><tr>
                            <td class="table_head" align="left" valign="middle">
                                Payment Mode &nbsp;</td>
                            <td style="height: 22px" align="center" valign="middle">
                                :&nbsp;</td>
								
                            <td style="height: 22px" align="left" valign="top">
                                <span id="radPaymentMode" disabled="disabled"><span disabled="disabled">
								<!--<input id="radPaymentMode_0" name="radPaymentMode" value="1" disabled="disabled" type="radio" <?php if($Payment_Mode_ID==1){?> checked="checked"<?php }?>>
								<label for="radPaymentMode_0">Credit Card</label>-->
								</span><span disabled="disabled">
								<input id="radPaymentMode_1" name="radPaymentMode" value="2"  disabled="disabled" type="radio" <?php if($Payment_Mode_ID==2){?> checked="checked"<?php }?>>
								<label for="radPaymentMode_1">Cheque</label></span><span disabled="disabled">
								<input id="radPaymentMode_2" name="radPaymentMode" value="4" disabled="disabled" type="radio" <?php if($Payment_Mode_ID==4){?> checked="checked"<?php }?>>
								<label for="radPaymentMode_2">DD</label></span></span>&nbsp;
						   </td>
                        </tr>
                    </tbody></table>
                </td>
            </tr>	
	<tr>
		<td style="height: 10px">
		</td>
	</tr>

<tr>
<td align="left" valign="top">
	<table rules="all" id="gvStand" style="width:700px;border-collapse:collapse;" border="1" cellspacing="0">
	<tr><h4>Exhibitor Badges Taken</h4></tr>
  <tr>
    <th>Date</th>
    <th>Name</th>
    <th>Designation</th>
    <th>Charges Applicable</th>
   </tr>
   <?php 
	/*...................Exhibitor Badges Taken.........................*/
	$query=$conn ->query("select * from iijs_badge_items where Exhibitor_Code='$exhibitor_code' and Badge_Type='E' and Badge_ID='$Badge_ID'");
	$Additional_Charges=0;
	$extra_charge=0;
	$Tot_Additional_Charges=0;
	while($result=$query->fetch_assoc()){
	if($result['WaveOff']!="Y")
	{
		$extra_charge=$extra_charge+intval($result['Surcharge']);
	}
   ?>
   <tr>
	<td><?php echo date('d-m-Y',strtotime($result['Create_Date']));?></td>
    <td><?php echo $result['Badge_Name'];?></td>
    <td><?php echo $result['Badge_Designation'];?></td>
     <td>
	<?php 
	if($result['Is_Additional']=='Y'){
		echo $Additional_Charges=round($result['Additional_Charges']);
		$Tot_Additional_Charges=$Tot_Additional_Charges+round($result['Additional_Charges']);
	}
	if(intval($result['Surcharge'])!='0'){ 
	 echo intval($result['Surcharge']);
	}
	?>
    </td>
   </tr>
  <?php }?>
</table>
	</td>
</tr>


<tr>
<td align="left" valign="top">
	<table rules="all" id="gvStand" style="width:700px;border-collapse:collapse;" border="1" cellspacing="0">
	<tr><h4>Management Badges Taken</h4></tr>
  <tr>
    <th>Date</th>
    <th>Name</th>
    <th>Designation</th>
    <th>Charges Applicable</th>
   </tr>
   <?php 
	/*...................Management Badges Taken.........................*/
	$query=$conn ->query("select * from iijs_badge_items where Exhibitor_Code='$exhibitor_code' and Badge_Type='M' and Badge_ID='$Badge_ID'");
	$mangmnt_charge=0;
	while($result=$query->fetch_assoc()){
	if($result['WaveOff']!="Y")
	{
		$mangmnt_charge=$mangmnt_charge+intval($result['Surcharge']);
	}
   ?>
   <tr>
	<td><?php echo date('d-m-Y',strtotime($result['Create_Date']));?></td>
    <td><?php echo $result['Badge_Name'];?></td>
    <td><?php echo $result['Badge_Designation'];?></td>
    <td>
	<?php 
	if(intval($result['Surcharge'])!='0'){ 
	 echo intval($result['Surcharge']);
	}
	else
		echo "0";
	?>
	</td>
   </tr>
  <?php }?>
</table>
</td>
</tr>

<tr>
<td align="left" valign="top">
	<table rules="all" id="gvStand" style="width:700px;border-collapse:collapse;" border="1" cellspacing="0">
	<tr><h4>Service Badges Taken</h4></tr>
  <tr>
    <th>Date</th>
    <th>Name</th>
    <th>Designation</th>
    <th>Charges Applicable</th>
   </tr>
   <?php 
	/*...................Maintenance Badges Taken.........................*/
	$i=0;
	$query=$conn ->query("select * from iijs_badge_items where Exhibitor_Code='$exhibitor_code' and Badge_Type='S' and Badge_ID='$Badge_ID'");
	$Conversion_Charges=0;
	$maint_Additional_Charges=0;
	$Tot_Conversion_Charges=0;
	while($result=$query->fetch_assoc()){
   ?>
   <tr>
	<td><?php echo date('d-m-Y',strtotime($result['Create_Date']));?></td>
    <td><?php echo $result['Badge_Name'];?></td>
    <td><?php echo $result['Badge_Designation'];?></td>
    <td>
	<?php 
	if($result['Is_Converted']=='Y'){
	$Conversion_Charges=round($result['Conversion_Charges']);
	$Tot_Conversion_Charges=$Tot_Conversion_Charges+$Conversion_Charges;
	}
	if($result['Is_Converted']=='Y' || $result['Is_Additional']=='Y' || intval($result['Surcharge'])!='0'){
	echo round($result['Conversion_Charges'])+intval($result['Surcharge']);
	}
	else
	{
		echo "0";
	}
	?></td>
   </tr>
  <?php $i++;}?>
</table>
</td>
</tr>


	<tr>
		<td align="left" height="10" valign="top">
		</td>
	</tr>
            <tr>
                <td align="right" valign="top">
                    <table class="table_display" cellpadding="0" cellspacing="0" width="700">
                        <tbody>
                        <tr>
                            <td class="ack_text" style="width: 49%" align="left" valign="top"></td>
                            <td class="ack_text" style="width: 30%" align="left" valign="top">Additional Charge</td>
                            <td class="ack_text" style="width: 1%" align="center" valign="top">:</td>
                            <td class="ack_text" style="width: 20%" align="left" valign="top">
                                &nbsp;<span id="lblAmount"><?php echo $Tot_Additional_Charges;?></span></td>
                        </tr>
                        <tr>
                            <td class="ack_text" style="width: 49%" align="left" valign="top"></td>
                            <td class="ack_text" style="width: 30%" align="left" valign="top">Conversion Charge</td>
                            <td class="ack_text" style="width: 1%" align="center" valign="top">:</td>
                            <td class="ack_text" style="width: 20%" align="left" valign="top">
                                &nbsp;<span id="lblAmount"><?php echo $Tot_Conversion_Charges;?></span></td>
                        </tr>
                        <tr>
                            <td class="ack_text" style="width: 49%" align="left" valign="top"></td>
                            <td class="ack_text" style="width: 30%" align="left" valign="top">Surcharge</td>
                            <td class="ack_text" style="width: 1%" align="center" valign="top">:</td>
                            <td class="ack_text" style="width: 20%" align="left" valign="top">
                                &nbsp;<span id="lblAmount">
							<?php
							$wquery=mysql_query("select * from iijs_badge_items where Badge_ID='$Badge_ID' and WaveOff!='Y' and Badge_Type='E'");
							$wresult=mysql_fetch_array($wquery);
							$wnum=mysql_num_rows($wquery); 
                            if($wnum>0){echo $extra_charge;}
                            else{echo $extra_charge=0;}
                            ?></span></td>
                        </tr>
                        <tr>
                            <td class="ack_text" style="width: 49%" align="left" valign="top"></td>
                            <td class="ack_text" style="width: 30%" align="left" valign="top">Total</td>
                            <td class="ack_text" style="width: 1%" align="center" valign="top">:</td>
                            <td class="ack_text" style="width: 20%" align="left" valign="top">
                                &nbsp;<span id="lblAmount"><?php echo $totamt=round($Tot_Additional_Charges+$Tot_Conversion_Charges+$extra_charge);?></span></td>
                        </tr>
                        
                        <tr>
                            <td class="ack_text" style="width: 49%" align="left" valign="top"></td>
                            <td class="ack_text" style="width: 30%" align="left" valign="top">GST (18%)&nbsp;</td>
                            <td class="ack_text" style="width: 1%" align="center" valign="top">:</td>
                            <td class="ack_text" style="width: 20%" align="left" valign="top">
                                &nbsp;<span id="lblserviceTax"><?php echo $service_tax=round($totamt*18/100);?></span></td>
                        </tr>
						
						<?php $education_cess_tax=0;?>
						<?php $she_cess_tax=0;?>
                        <tr>
                            <td class="ack_text" style="width: 49%" align="left" valign="top"></td>
                            <td class="ack_text" style="width: 30%" align="left" valign="top">Total Payable:</td>
                            <td class="ack_text" style="width: 1%" align="center" valign="top">:</td>
                            <td class="ack_text" style="width: 20%" align="left" valign="top">
                                &nbsp;<span id="lblTotaAmount"><?php echo $total_payble= round($totamt+$service_tax+$Surcharge_Rate);?></span></td>
                        </tr>
                    </tbody>
					</table>
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
<p >Note :</p>
<p style="margin-left:0.5in">
1) For order/payment approval, print acknowledgement along with Payment should reach the council within 3 <br/>working days after order date failing will result in cancellation of order. <br />
2) Cheque / Demand Draft must be made in favour of <strong>&ldquo;The Gem &amp; Jewellery Export Promotion Council&rdquo;</strong></p>
<p style="margin-left:0.5in"><strong>Return to:</strong> <strong>The Gem &amp; Jewellery Export Promotion Council</strong><br />
Unit G2-A, Trade Center, Opp. BKC Telephone Exchange,<br />
Bandra Kurla Complex, Bandra (E), Mumbai - 400 051, India<br />
Tel : 0091-22-43541800</p>
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
                <td style="height: 26px">
                    &nbsp;&nbsp;
                    <input name="btnPrint" id="btnPrint" src="print.jpg" onclick="printWin();" style="border-width:0px;" type="image">&nbsp;<input name="btnCancel" id="btnCancel" src="cancel_btn.jpg" style="border-width:0px;" type="image"></td>
            </tr>
        </tbody></table>
    </div>
    </form>
</body>
</html>
<?php 
include('../../header_include.php');
?>
<?php
$HouseKeeping_ID=$_REQUEST['HouseKeeping_ID'];

$exhibitor_code=$_REQUEST['exhibitor_code'];
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
$query=$conn ->query("select * from iijs_housekeeping where HouseKeeping_ID='$HouseKeeping_ID'");
$result=$query->fetch_assoc();

$orderno=$result['orderId'];
$HouseKeepingService_ID=$result['HouseKeepingService_ID'];
$Payment_Amount=$result['Payment_Amount'];
$tds_amount=$result['tds_amount'];
$tds_tax=$result['tds_tax'];
$net_payable_amount=$result['net_payable_amount'];
$Create_Date=$result['Create_Date'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="content-type" content="text/html; charset=windows-1252">
<title>IIJS <?php echo date("Y"); ?></title>
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
                        <tbody><tr>
                            <td>
                                <img id="Image1" src="../../images/logo.png" style="border-width:0px;" align="left"></td>
                            <td class="iijs_print" valign="bottom">Print Acknowledgement</td>
                        </tr>
                    </tbody></table>
                </td>
            </tr>
            <tr>
                 <td align="center">STAND CLEANING SERVICE (HOUSEKEEPING)</td>
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
            <span id="PrintAck_ExhibitorInfo1_lblOrderNoAndDt"><?php echo date('d/m/Y',strtotime($Modify_Date));?></span></td>
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
        <td>
            :
            <span id="PrintAck_ExhibitorInfo1_lblStall"><?php echo $stall_no;?></span></td>
        <td class="black_subhead">
            &nbsp;Hall No</td>
        <td>
            :
            <span id="PrintAck_ExhibitorInfo1_lblHall"><?php echo $Exhibitor_HallNo;?></span></td>
    </tr>
    <tr style="height: 25px">
        <td class="black_subhead">
            &nbsp;Zone</td>
        <td>
            :
            <span id="PrintAck_ExhibitorInfo1_lblZone"><?php echo $Exhibitor_DivisionNo; ?></span></td>
        <td class="black_subhead">
            &nbsp;Region</td>
        <td>
            :
            <span id="PrintAck_ExhibitorInfo1_lblRegion"><?php echo $Exhibitor_Region;?></span></td>
    </tr>
    <tr style="height: 25px">
        <td class="black_subhead">
            &nbsp;Section</td>
        <td>
            :
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
                <td align="left">
                    <table>
                        <tbody><tr>
                            <td class="table_head" align="left" valign="middle">
                                Time of Service  &nbsp;</td>
                            <td style="height: 22px" align="center" valign="middle">
                                :&nbsp;</td>
							<td> <?php if($HouseKeepingService_ID=='1'){echo "8.00 a.m. to 9.00 a.m";}else {echo "8.00 p.m. to 9.00 p.m";}?></td>	
                            
                        </tr>
                    </tbody></table>
                </td>
            </tr>
            
            <tr>
                <td style="height: 10px">
                </td>
            </tr>
            
           
            <tr>
                <td align="right" valign="top">
                    <table class="table_display" cellpadding="0" cellspacing="0" width="700">
                        <tbody>
						<tr>
                            <td class="ack_text" style="width: 49%" align="left" valign="top"></td>
                            <td class="ack_text" style="width: 30%" align="left" valign="top">Total Amount</td>
                            <td class="ack_text" style="width: 1%" align="center" valign="top">:</td>
                            <td class="ack_text" style="width: 20%" align="left" valign="top"><span class="ack_text" style="width: 20%"><?php echo $Payment_Amount;?></span></td>
                        </tr>
						<tr>
                            <td class="ack_text" style="width: 49%" align="left" valign="top"></td>
                            <td class="ack_text" style="width: 30%" align="left" valign="top">TDS</td>
                            <td class="ack_text" style="width: 1%" align="center" valign="top">:</td>
                            <td class="ack_text" style="width: 20%" align="left" valign="top"><span class="ack_text" style="width: 20%"><?php echo $tds_tax;?>%</span></td>
                        </tr>
						<tr>
                            <td class="ack_text" style="width: 49%" align="left" valign="top"></td>
                            <td class="ack_text" style="width: 30%" align="left" valign="top">TDS Amount</td>
                            <td class="ack_text" style="width: 1%" align="center" valign="top">:</td>
                            <td class="ack_text" style="width: 20%" align="left" valign="top"><span class="ack_text" style="width: 20%"><?php echo $tds_amount;?></span></td>
                        </tr>
						<tr>
                            <td class="ack_text" style="width: 49%" align="left" valign="top"></td>
                            <td class="ack_text" style="width: 30%" align="left" valign="top">Net payable</td>
                            <td class="ack_text" style="width: 1%" align="center" valign="top">:</td>
                            <td class="ack_text" style="width: 20%" align="left" valign="top"><span class="ack_text" style="width: 20%"><?php echo $net_payable_amount;?></span></td>
                        </tr>
                    </tbody></table>
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
1) For order/payment approval, print acknowledgement along with Payment should reach the council within 3<br> working days after order date failing will result in cancellation of order. <br />
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
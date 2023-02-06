<?php 
include('../header_include.php');
?>
<?php
$HouseKeeping_ID=$_REQUEST['HouseKeeping_ID'];

$exhibitor_code=$_SESSION['EXHIBITOR_CODE'];
$exhibitor_data="select * from iijs_exhibitor where Exhibitor_Code='$exhibitor_code'";
$result = $conn ->query($exhibitor_data);
$fetch_data = $result->fetch_assoc();

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
$query = $conn ->query("select * from iijs_housekeeping where HouseKeeping_ID='$HouseKeeping_ID'");
$result= $query->fetch_assoc();

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
<title>IIJS</title>
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
 <style type="text/css">
        @media print {
            #no_print{display: none!important;}
            #Header, #Footer { display: none ! important; }
    
  }

    </style>
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
                            <td><img id="Image1" src="https://registration.gjepc.org/manual_signature/images/logo.png" style="border-width:0px;" align="left"></td>
                        </tr>
						 <tr align="center">
                             <td class="iijs_print" valign="bottom" style="font-size: 14px"><strong>Print Acknowledgement</strong></td>
                         </tr>
                    </tbody>
				 </table>
                </td>
            </tr>
           
            <tr>
            <th colspan="8" style="background:#40a9e6; color:#fff;">
            <h3 style="margin:0; display:inline-block; text-transform:uppercase; font-size: 18px">STAND CLEANING SERVICE (HOUSEKEEPING)</h3></th>
             </tr>
            <tr>
             <td align="left" valign="top">
                    
<table id="tblMain_ExhibitorInfo" cellpadding="0" cellspacing="0" width="700">
    <tbody>
	<tr>
        <h5 style="margin: 0 0 5px 0;padding: 6px;">Exhibitor Information :</h5>
    </tr>
    <tr>
      
        <td   align="left" valign="top" width="125px">
            <span id="PrintAck_ExhibitorInfo1_lblTxt" style="font-size: 14px">Order No</span></td>
        <td  align="left" valign="top" style="font-size: 14px">  : 
            <span id="PrintAck_ExhibitorInfo1_lblOrderNoAndDt"><?php echo $orderno;?> </span></td>
         <td  align="left" valign="top" width="125" style="font-size: 14px">
          Date</td>
        <td align="left" valign="top" style="font-size: 14px">     :
            <span id="PrintAck_ExhibitorInfo1_lblExhibitorID"><?php echo date('d-m-Y',strtotime($Create_Date));?></span>
        </td>
      
    </tr>
    <tr>
        <td  align="left" valign="top" width="125" style="font-size: 14px">Exhibitor ID</td>
        <td align="left" valign="top" style="font-size: 14px">     :
            <span id="PrintAck_ExhibitorInfo1_lblExhibitorID"><?php echo $exhibitor_code;?></span>
        </td>

        <td   align="left" valign="top" width="125px" style="font-size: 14px">Exhibitor Name </td>
        <td  align="left" valign="top">
            : <span id="PrintAck_ExhibitorInfo1_lblName" style="font-size: 14px"><?php echo $Exhibitor_Name;?></span>
        </td>
        
    </tr>
    <tr>

        <td style="font-size: 14px"  align="left" valign="top">Contact Person</td>
        <td align="left" valign="top" style="font-size: 14px">  : 
            <span id="PrintAck_ExhibitorInfo1_lblContactPerson"><?php echo $Exhibitor_Contact_Person;?> </span>
        </td>
           <td style="font-size: 14px" >Stall No(s)</td>
        <td style="font-size: 14px;">   :
            <span id="PrintAck_ExhibitorInfo1_lblStall"><?php echo $stall_no;?></span>
        </td>
    </tr>
 <tr >

        <td style="font-size: 14px" >
           Hall No</td>
        <td style="font-size: 14px">  :
            <span id="PrintAck_ExhibitorInfo1_lblHall"><?php echo $Exhibitor_HallNo;?></span>
        </td>
         <td style="font-size: 14px" >Section</td>
        <td style="font-size: 14px">    :
            <span id="PrintAck_ExhibitorInfo1_lblSection"><?php echo $Exhibitor_Section; ?></span>
        </td>
    </tr>
    <tr >
        <td style="font-size: 14px">
           Zone</td>
        <td style="font-size: 14px">   :
            <span id="PrintAck_ExhibitorInfo1_lblZone"><?php echo $Exhibitor_DivisionNo; ?></span>
        </td>
        <td style="font-size: 14px">
          Region</td>
        <td style="font-size: 14px">    :
            <span id="PrintAck_ExhibitorInfo1_lblRegion"><?php echo $Exhibitor_Region;?></span>
        </td>
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
                        <tbody>
                            <tr>
                            <td class="table_head" align="left" valign="middle" style="font-size: 14px">
                               <b> Time of Service  </b></td>
                            <td style="height: 22px" align="center" valign="middle">:</td>
							<td style="font-size: 14px"> <?php if($HouseKeepingService_ID=='1'){echo "8.00 a.m. to 9.00 a.m";}else {echo "8.00 p.m. to 9.00 p.m";}?></td>	
                            
                        </tr>
                    </tbody>
                </table>
                </td>
            </tr>
            <tr>
                <td style="width: 100%; border-top: 1px solid #000"></td>
            </tr>
                        
           
            <tr>
                <td align="right" valign="top">
                    <table class="table_display" cellpadding="0" cellspacing="0" width="700">
                        <tbody>
						<tr>
                            <td class="ack_text" style="width: 70%; font-size: 14px" align="left" valign="top"></td>
                            <td class="ack_text" style="width: 20%; font-size: 14px" align="left" valign="top"> <b>Total Amount</b></td>
                            <td class="ack_text" style="width: 1%; font-size: 14px" align="center" valign="top">:</td>
                            <td class="ack_text" style="width: 19%; font-size: 14px" align="left" valign="top"><span class="ack_text" style="width: 20%"><?php echo $Payment_Amount;?></span></td>
                        </tr>
						<tr>
                            <td class="ack_text" style="width: 70%; font-size: 14px" align="left" valign="top"></td>
                            <td class="ack_text" style="width: 20%; font-size: 14px" align="left" valign="top"> <b>TDS</b></td>
                            <td class="ack_text" style="width: 1%; font-size: 14px" align="center" valign="top">:</td>
                            <td class="ack_text" style="width: 19%; font-size: 14px" align="left" valign="top"><span class="ack_text" style="width: 20%"><?php echo $tds_tax;?>%</span></td>
                        </tr>
						<tr>
                            <td class="ack_text" style="width: 70%; font-size: 14px" align="left" valign="top"></td>
                            <td class="ack_text" style="width: 20%; font-size: 14px" align="left" valign="top"> <b>TDS Amount</b></td>
                            <td class="ack_text" style="width: 1%; font-size: 14px" align="center" valign="top">:</td>
                            <td class="ack_text" style="width: 19%; font-size: 14px" align="left" valign="top"><span class="ack_text" style="width: 20%"><?php echo $tds_amount;?></span></td>
                        </tr>
						<tr>
                            <td class="ack_text" style="width: 70%; font-size: 14px" align="left" valign="top"></td>
                            <td class="ack_text" style="width: 20%; font-size: 14px" align="left" valign="top"><b>Net payable</b></td>
                            <td class="ack_text" style="width: 1%; font-size: 14px" align="center" valign="top">:</td>
                            <td class="ack_text" style="width: 19%; font-size: 14px" align="left" valign="top"><span class="ack_text" style="width: 20%"><?php echo $net_payable_amount;?></span></td>
                        </tr>
                    </tbody></table>
                </td>
            </tr>
            <tr id="no_print">
                <td style="height: 26px">
                    &nbsp;&nbsp;
                    <input name="btnPrint" id="btnPrint" src="print.jpg" onclick="printWin();" style="border-width:0px;" type="image">&nbsp;<input name="btnCancel" id="btnCancel" src="cancel_btn.jpg" style="border-width:0px;" type="image"></td>
            </tr>
        </tbody></table>
    </div>
    </form>
</body>
</html>
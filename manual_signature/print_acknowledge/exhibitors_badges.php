<?php
include('../header_include.php');
?>
<?php
$order_id=$_REQUEST['order_id'];
if(isset($_REQUEST['EXHIBITOR_CODE']))
    $exhibitor_code=$_REQUEST['EXHIBITOR_CODE'];
else
    $exhibitor_code=$_SESSION['EXHIBITOR_CODE'];
    
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
$query=$conn ->query("SELECT b.* FROM `iijs_badge` a,iijs_payment_master b WHERE 1 and a.`Payment_Master_ID`=b.`Payment_Master_ID` and a.Exhibitor_Code='$exhibitor_code' and b.Form_ID='4' and b.Payment_Master_OrderNo='$order_id'");
$result=$query->fetch_assoc();
$Payment_Mode_ID=$result['Payment_Mode_ID'];
$Surcharge_Rate=$result['Surcharge_Rate'];
$Create_Date=$result['Create_Date'];
$tds_amount=$result['tds_amount'];
$tds_tax=$result['tds_tax'];
$net_payable_amount=$result['net_payable_amount'];
$tpsl_txn_time=date("d-m-Y", strtotime($result['tpsl_txn_time']));
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
            <table class="table_display_ack" style="margin: 0px auto; ">
                <tbody>
                    <tr>
                        <td align="center" valign="middle">
                            <table border="0" cellpadding="0" cellspacing="0" width="700">
                                <tbody>
                                    <tr>
                                        <td><img id="Image1" src="https://gjepc.org/assets/images/logo.png" style="border-width:0px;" align="left"></td>
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
                        <h3 style="margin:0; display:inline-block; text-transform:uppercase; font-size: 18px">EXHIBITOR BADGES FORM</h3></th>
                    </tr>
                    <tr>
                        <td align="left" valign="top">
                            
                            <table id="tblMain_ExhibitorInfo" cellpadding="0" cellspacing="0" width="700">
                                <tbody>
                                    <tr>
                                         <h5 style="margin: 0 0 5px 0; padding: 6px;">Exhibitor Information :</h5>
                                    </tr>
                                     
                                        <tr>
                                            <td align="left" valign="top" width="125" style="font-size: 14px">Order No.
                                            </td>
                                            <td align="left" valign="top" style="font-size: 14px"> :
                                                <span id="PrintAck_ExhibitorInfo1_lblExhibitorID"> <?php echo $order_id;?></span>
                                            </td>
                                            
                                            
                                            <td  align="left" valign="top" width="125px" style="font-size:14px">
                                                <span id="PrintAck_ExhibitorInfo1_lblTxt">Date</span>
                                            </td>
                                            <td  align="left" valign="top" style="font-size: 14px">  :
                                                <span id="PrintAck_ExhibitorInfo1_lblOrderNoAndDt"><?php echo date('d/m/Y',strtotime($Create_Date));?></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td  align="left" valign="top" width="125px" style="font-size: 14px">
                                            Exhibitor ID </td>
                                            <td  align="left" valign="top" style="font-size: 14px">
                                                : <span id="PrintAck_ExhibitorInfo1_lblName"><?php echo $exhibitor_code;?></span>
                                            </td>
                                            <td  align="left" valign="top" width="125px" style="font-size: 14px">
                                            Exhibitor Name </td>
                                            <td  align="left" valign="top" style="font-size: 14px">
                                                : <span id="PrintAck_ExhibitorInfo1_lblName"><?php echo $Exhibitor_Name;?></span>
                                            </td>
                                         
                                            
                                        </tr>
                                        
                                        <tr >
                                               <td  align="left" valign="top" style="font-size: 14px">
                                            Contact Person</td>
                                            <td align="left" valign="top" style="font-size: 14px"> :
                                                <span id="PrintAck_ExhibitorInfo1_lblContactPerson"><?php echo $Exhibitor_Contact_Person;?> </span>
                                            </td>
                                            <td style="font-size: 14px">Stall No(s)</td>
                                            <td style="font-size: 14px"> :
                                                <span id="PrintAck_ExhibitorInfo1_lblStall"><?php echo $stall_no;?></span></td>
                                                
                                            </tr>
                                            <tr >
                                                <td  style="font-size: 14px">Hall No</td>
                                                <td style="font-size: 14px">:<span id="PrintAck_ExhibitorInfo1_lblHall"><?php echo $Exhibitor_HallNo;?></span></td>
                                                <td style="font-size: 14px">Zone</td>
                                                <td style="font-size: 14px">:<span id="PrintAck_ExhibitorInfo1_lblZone"> <?php echo $Exhibitor_DivisionNo; ?></span></td>
                                            </tr>
                                            <tr>
                                                <td style="font-size: 14px" class="black_subhead">Region</td>
                                                <td style="font-size: 14px">:<span id="PrintAck_ExhibitorInfo1_lblRegion"> <?php echo $Exhibitor_Region;?></span></td>
                                                  <td style="font-size: 14px" class="black_subhead">Section</td>
                                                <td style="font-size: 14px">:<span id="PrintAck_ExhibitorInfo1_lblSection"> <?php echo getSection_desc($Exhibitor_Section,$conn); ?></span></td>

                                            </tr>
                                            
                                           <!-- <tr>
                                                <td style="font-size: 14px" class="black_subhead">Gst No.</td>
                                                <td style="font-size: 14px">:<span id="PrintAck_ExhibitorInfo1_lblGST"></span></td>
                                                <td  style="font-size: 14px" class="black_subhead">Pan No.</td>
                                                <td style="font-size: 14px">:<span id="PrintAck_ExhibitorInfo1_lblPan"> </span></td>
                                            </tr>-->
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td align="left" valign="top">
                                    <table rules="all" id="gvStand" class="table_invoice" style="width:700px;border-collapse:collapse;font-size: 13px" border="1" cellspacing="0">
                                        <tr>
                                            <h5 style="margin: 0 0 5px 0;padding: 6px">Exhibitor Badges Taken</h5>

                                        </tr>
                                        <tr style="background:#40a9e6; color:#fff;">
                                            <th>Date</th>
                                            <th>Name</th>
                                            <th>Designation</th>
                                            
                                        </tr>
                                        <?php
                                            /*...................Exhibitor Badges Taken.........................*/
                                            $query=$conn ->query("SELECT a.Badge_ID , b.* FROM  `iijs_badge` a,  `iijs_badge_items` b WHERE 1  AND a.`Badge_ID` = b.`Badge_ID` AND b.Badge_Type='E' AND a.`Payment_Master_ID` =(select Payment_Master_ID from iijs_payment_master where Payment_Master_OrderNo='$order_id')");
                                            $extra_charge=0;
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
                                            
                                        </tr>
                                        <?php }?>
                                    </table>
                                </td>
                            </tr>
							<!--
                            <tr>
                                <td align="left" valign="top">
                                    <table rules="all" id="gvStand" style="width:700px;border-collapse:collapse;font-size: 13px" border="1" cellspacing="0">
                                    <tr>
                                        <h5 style="margin: 0 0 5px 0;padding: 6px">Temporary Badges Taken</h5>
                                    </tr>
                                    <tr style="background:#40a9e6; color:#fff;">
                                        <th>Date</th>
                                        <th>Name</th>
                                        <th>Designation</th>
                                        <th>Charges Applicable</th>
                                    </tr>
                                    <?php
                                        /*...................Maintenance Badges Taken.........................*/
                                        $i=0;
                                        $query=$conn ->query("SELECT a.Badge_ID , b.* FROM  `iijs_badge` a,  `iijs_badge_items` b WHERE 1  AND a.`Badge_ID` = b.`Badge_ID` AND b.Badge_Type='S' AND a.`Payment_Master_ID` =(select Payment_Master_ID from iijs_payment_master where Payment_Master_OrderNo='$order_id')");
                                        while($result=$query->fetch_assoc()){
                                    ?>
                                    <tr>
                                        <td><?php echo date('d-m-Y',strtotime($result['Create_Date']));?></td>
                                        <td><?php echo $result['Badge_Name'];?></td>
                                        <td><?php echo $result['Badge_Designation'];?></td>
                                        <td>500</td>
                                    </tr>
                                    <?php $i++;}?>
                                </table>
                            </td>
                        </tr>
						
                        <tr>
                            <td align="left" valign="top">
                                <table rules="all" id="gvStand" style="width:700px;border-collapse:collapse; font-size: 13px" border="1" cellspacing="0">
                                <tr><h5 style="margin: 0 0 5px 0;padding: 6px">Additional Badges Taken</h5></tr>
                                <tr style="background:#40a9e6; color:#fff;">
                                    <th>Date</th>
                                    <th>Name</th>
                                    <th>Designation</th>
                                    
                                </tr>
                                <?php
                                    /*...................Management Badges Taken.........................*/
                                    $query=$conn ->query("SELECT a.Badge_ID , b.* FROM  `iijs_badge` a,  `iijs_badge_items` b WHERE 1  AND a.`Badge_ID` = b.`Badge_ID` AND b.Badge_Type='M' AND a.`Payment_Master_ID` =(select Payment_Master_ID from iijs_payment_master where Payment_Master_OrderNo='$order_id')");
                                    $mangmnt_charge=0;
                                    $k=0;
                                    while($result=$query->fetch_assoc()){
                                    $mangmnt_charge=$mangmnt_charge+1500;
                                ?>
                                <tr>
                                    <td><?php echo date('d-m-Y',strtotime($result['Create_Date']));?></td>
                                    <td><?php echo $result['Badge_Name'];?></td>
                                    <td><?php echo $result['Badge_Designation'];?></td>
                                    
                                </tr>
                                <?php $k++;}?>
                            </table>
                        </td>
                    </tr>
					-->
                    
                    <tr>
                            <td align="left" valign="top">
                                <table rules="all" id="gvStand" style="width:700px;border-collapse:collapse; font-size: 13px" border="1" cellspacing="0">
                                <tr><h5 style="margin: 0 0 5px 0;padding: 6px">Replacement Badges Taken</h5></tr>
                                <tr style="background:#40a9e6; color:#fff;">
                                    <th>Date</th>
                                    <th>Name</th>
                                    <th>Designation</th>
                                    
                                </tr>
                                <?php
                                    /*...................Replacement Badges Taken.........................*/
                                    $query=$conn ->query("SELECT a.Badge_ID , b.* FROM  `iijs_badge` a,  `iijs_badge_items` b WHERE 1  AND a.`Badge_ID` = b.`Badge_ID` AND b.Badge_Type='R' AND a.`Payment_Master_ID` =(select Payment_Master_ID from iijs_payment_master where Payment_Master_OrderNo='$order_id')");
									$j=0;
                                    $replacement_charge=0;
                                    while($result=$query->fetch_assoc()){
                                    $replacement_charge=$replacement_charge+$result['Surcharge'];
                                ?>
                                <tr>
                                    <td><?php echo date('d-m-Y',strtotime($result['Create_Date']));?></td>
                                    <td><?php echo $result['Badge_Name'];?></td>
                                    <td><?php echo $result['Badge_Designation'];?></td>
                                    
                                </tr>
                                <?php $j++;}?>
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
                                                <td class="ack_text" style="width: 75%" align="left" valign="top"></td>
                                                <td class="ack_text" style="width: 15%;font-size: 14px; " align="left" valign="top"><b>Total Amount</b></td>
                                                <td class="ack_text" style="width: 1%" align="center" valign="top">:</td>
                                                <td class="ack_text" style="width: 9%;text-align: right;font-size: 14px" align="left" valign="top">
                                                <span id="lblAmount"><?php echo $totamt=500*$i+1500*$k+500*$j;?></span></td>
                                            </tr>
                                            
                                            <tr>
                                                <td class="ack_text" style="width: 75%" align="left" valign="top"> </td>
                                                <td class="ack_text" style="width:15%;font-size: 14px" align="left" valign="top"><b>GST (18%)</b></td>
                                                <td class="ack_text" style="width: 1%" align="center" valign="top">:</td>
                                                <td class="ack_text" style="width: 9%;text-align: right;font-size: 14px" align="left" valign="top"><span id="lblserviceTax"><?php echo $service_tax=$totamt*18/100;?></span></td>
                                            </tr>
                                            
                                            <tr>
                                                <td class="ack_text" style="width: 70%" align="left" valign="top"></td>
                                                <td class="ack_text" style="width: 20%; font-size: 14px" align="left" valign="top"><b>Total Payable</b></td>
                                                <td class="ack_text" style="width: 1%" align="center" valign="top">:</td>
                                                <td class="ack_text" style="width: 9%;text-align: right;font-size: 14px" align="left" valign="top">
                                                   <span id="lblTotaAmount"><?php echo $total_payble= round($totamt+$service_tax);?></span>
                                               </td>
                                            </tr>
                                            <tr>
                                                <td class="ack_text" style="width: 70%" align="left" valign="top"></td>
                                                <td class="ack_text" style="width: 20%;font-size: 14px" align="left" valign="top"><b>TDS</b></td>
                                                <td class="ack_text" style="width: 1%" align="center" valign="top">:</td>
                                                <td class="ack_text" style="width: 9%;text-align: right;font-size: 14px" align="left" valign="top">
                                                    <span class="ack_text" style="width: 20%"><?php echo $tds_tax;?>%</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="ack_text" style="width: 70%" align="left" valign="top"></td>
                                                <td class="ack_text" style="width: 20%;font-size: 14px" align="left" valign="top"><b>TDS Amount</b></td>
                                                <td class="ack_text" style="width: 1%" align="center" valign="top">:</td>
                                                <td class="ack_text" style="width: 9%;text-align: right;font-size: 14px" align="left" valign="top"><span class="ack_text" style="width: 20%"><?php echo $tds_amount;?></span></td>
                                            </tr>
                                            <tr>
                                                <td class="ack_text" style="width: 70%" align="left" valign="top"></td>
                                                <td class="ack_text" style="width: 20%;font-size: 14px" align="left" valign="top"><b>Net payable</b></td>
                                                <td class="ack_text" style="width: 1%" align="center" valign="top">:</td>
                                                <td class="ack_text" style="width: 9%;text-align: right;font-size: 14px" align="left" valign="top"><span class="ack_text" style="width: 20%"><?php echo $net_payable_amount;?></span></td>
                                            </tr>
                                            </tbody></table>
                                        </td>
                                    </tr>
                                    <tr><td>&nbsp;</td></tr>
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
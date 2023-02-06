<?php 
include('../../header_include.php');
?>
<?php
$StrongRoom_ID=$_REQUEST['StrongRoom_ID'];
$exhibitor_code=$_REQUEST['exhibitor_code'];
$exhibitor_data="select * from iijs_exhibitor where Exhibitor_Code='$exhibitor_code'";
$result=mysql_query($exhibitor_data);
$fetch_data=mysql_fetch_array($result);

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
$query=mysql_query("select * from iijs_strongroom where StrongRoom_ID='$StrongRoom_ID'");
$result=mysql_fetch_array($query);

$StrongRoom_Taken=$result['StrongRoom_Taken'];
$keyperson1=$result['keyperson1'];
$keyperson2=$result['keyperson2'];
$Create_Date=$result['Create_Date'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="content-type" content="text/html; charset=windows-1252">
<title>	Signature <?php echo date("Y"); ?></title>
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
    <form name="form1" method="post" action="#" id="form1">
<div>
</div>

     <div>
         &nbsp;</div>
        <table class="table_display_ack" style="margin: 0px auto;">
            <tbody><tr>
                <td style="border-bottom: #ededed 1px solid" align="center" valign="middle">
                    <table border="0" cellpadding="0" cellspacing="0" width="700">
                        <tbody>
						<tr>
                            <td>
                                <img src="../../images/logo.png" align="left" style="border-width:0px;"></td>
						</tr>
							<tr>
                            <td align="right">
                                Print Acknowledgement
							 </td>
                        </tr>
                    </tbody></table>
                </td>
            </tr>
            <tr align="center">
                <td>
                    STRONG ROOM FACILITY FORM</td>
            </tr>
            <tr>
                <td align="left">
                    
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
            <span id="PrintAck_ExhibitorInfo1_lblOrderNoAndDt"><?php echo date('d/m/Y',strtotime($Create_Date));?></span></td>
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
                <td>
                    <table class="table_display">
                        <tbody><tr>
                            <td align="left" class="ack_text" >
                                Would you like to avail of strong room facilities at the show? &nbsp;</td>
                            <td align="left">
                                :&nbsp;</td>
                            <td  align="left">
                               <?php if($StrongRoom_Taken=="Y"){echo "Yes";}else{echo "No";}?></td>
                        </tr>
                    </tbody></table>
             </td>
            </tr>
           
            <tr>
                <td class="black_subhead" style="text-align:left;border-bottom: #2f2f2f 1px solid">
                    
                    Acknowledgement for Key Holder</td>
            </tr>
            <tr>
                <td>
                    <table class="table_display">
                        <tbody><tr>
                            <td align="left">
                            </td>
                            <td align="left">
                               <strong> Key Person 1</strong>
                            </td>
                            <td align="left" width="50"></td>
                            <td align="left">
                            </td>
                            <td align="left">
                                <strong>Key Person 2</strong></td>
                        </tr>
                        <tr>
                            <td align="left">
                                Name</td>
                            <td align="left">
                                <?php echo getKeyName($keyperson1);?></td>
                            <td align="left">&nbsp;</td>
                            <td align="left">
                                Name</td>
                            <td align="left">
                                <?php echo getKeyName($keyperson2);?></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top">Designation</td>
                          <td align="left"><?php echo getKeyDesignation($keyperson1);?></td>
                          <td align="left" valign="top">&nbsp;</td>
                          <td align="left" valign="top">Designation</td>
                          <td align="left"><?php echo getKeyDesignation($keyperson2);?></td>
                        </tr>
                        <tr>
                            <td align="left" valign="top">
                                Photograph</td>
                            <td align="left">
                                <img src="../../images/badges/<?php echo $exhibitor_code;?>/<?php echo getKeyPhoto($keyperson1);?>" style="height:100px;width:100px;border-width:0px;"></td>
                            <td align="left" valign="top">&nbsp;</td>
                            <td align="left" valign="top">
                                Photograph</td>
                            <td align="left">
                                <img  src="../../images/badges/<?php echo $exhibitor_code;?>/<?php echo getKeyPhoto($keyperson2);?>" style="height:100px;width:100px;border-width:0px;"></td>
                        </tr>
                        <tr>
                            <td colspan="2" align="left">
                                </td>
                            <td colspan="3" align="left">
                                </td>
                        </tr>
                        <tr>
                            <td colspan="2" align="center">
                                </td>
                            <td colspan="3" align="center">
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
                <td>
                    <table class="table_display">
                        <tbody>
						<tr>
<td colspan="2" class="ack_text" align="left">
<p >Note :</p>
<p style="margin-left:0.5in">
1) For order approval, Strong Room Disclaimer on Company Letterhead should reach the council within 3 <br/> working days after order date failing will result in cancellation of order.<br />
2) Cheque / Demand Draft must be made in favour of <strong>&ldquo;The Gem &amp; Jewellery Export Promotion Council&rdquo;</strong></p>
<p style="margin-left:0.5in"><strong>Return to:</strong> <strong>The Gem &amp; Jewellery Export Promotion Council</strong><br />
Unit G2-A, Trade Center, Opp. BKC Telephone Exchange,<br />
Bandra Kurla Complex, Bandra (E), Mumbai - 400 051, India<br />
Tel : 0091-22-43541800</p>
</td>
                        </tr>
                        <tr>
                            <td class="ack_text" align="left">
                            </td>
                            <td class="ack_text" align="right">
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
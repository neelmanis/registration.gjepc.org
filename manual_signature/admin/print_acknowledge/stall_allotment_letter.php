<?php 
include('../header_include.php');
?>
<?php
$exhibitor_code=$_SESSION['EXHIBITOR_CODE'];
$exhibitor_data="select * from iijs_exhibitor where Exhibitor_Code='$exhibitor_code'";
$result=mysql_query($exhibitor_data);
$fetch_data=mysql_fetch_array($result);

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
$Exhibitor_Gid=$fetch_data['Exhibitor_Gid'];
$Exhibitor_Region=$fetch_data['Exhibitor_Region'];
$Exhibitor_Section=$fetch_data['Exhibitor_Section'];
$Exhibitor_Category=$fetch_data['Exhibitor_Category'];
$Exhibitor_Scheme=$fetch_data['Exhibitor_Scheme'];
$Exhibitor_Premium=$fetch_data['Exhibitor_Premium'];
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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="content-type" content="text/html; charset=windows-1252"><title>
	Signature 2016
</title><link href="IIJS%202013_files/styles_print.css" rel="stylesheet" type="text/css"></head>
<body style="">
    <form name="form1" method="post" action="#" id="form1">
    <div>
        <table width="850px" border="0px" cellspacing="15" cellpadding="0" align="center" style="border:1px solid #bbb;">
<tr>
<td align="center">

<font face="Arial, Helvetica, sans-serif" size="-1">

    <table width="100%" border="0px" cellspacing="0" cellpadding="5">
      <tr>
        <td colspan="2" align="right"><img src="../print_acknowledge/logo.png" height="120px" /></td>
      </tr>
      <tr><td height="5px" colspan="2"></td></tr>
      
      <tr>
        <td colspan="2" align="center" bgcolor="#333333"><font size="+1" color="#FFFFFF">Stall Allotment Letter</font></td>
      </tr>
      <tr><td height="5px" colspan="2"></td></tr>
      
      <tr>
        <td width="50%">Ref. No : <b>GJC/D/EVENT/1<font size="-1" face="Arial, Helvetica, sans-serif">5</font>-1<font size="-1" face="Arial, Helvetica, sans-serif">6</font>/<?php echo $Exhibitor_Gid;?></b></td>
        <td width="50%" align="right">Date : <b></b><?php echo date('Y-m-d');?></b></td>
      </tr>
      <tr><td height="5px" colspan="2"></td></tr>
      
      <tr>
        <td colspan="2"><b>To :</b><br />
        <?php echo $Exhibitor_Name;?><br />
        <?php echo $Exhibitor_Address1;?><br />
        <?php if($Exhibitor_Address2!=''){echo $Exhibitor_Address2."<br />";}?>
        <?php echo $Exhibitor_City;?>- <?php echo $Exhibitor_Pincode;?><br />
        <?php if($Exhibitor_Country_ID=='64'){echo "INDIA";}else {$Exhibitor_Country_ID;}?></td>
      </tr>
      <tr><td height="5px" colspan="2"></td></tr>
      
      <tr>
        <td colspan="2">Dear Sir / Madam,</td>
      </tr>
      
      <tr>
        <td colspan="2"><b>Sub : Stall allotment at Signature 201<font size="-1" face="Arial, Helvetica, sans-serif">6</font></b></td>
      </tr>
      
      <tr>
        <td colspan="2">This has a reference to your participation at Signature 2015, to be held at BOMBAY EXHIBITON CENTRE GOREGAON, MUMBAI from February <font size="-1" face="Arial, Helvetica, sans-serif">5</font>, 201<font size="-1" face="Arial, Helvetica, sans-serif">6</font> – February <font size="-1" face="Arial, Helvetica, sans-serif">8</font>, 201<font size="-1" face="Arial, Helvetica, sans-serif">6</font></td>
      </tr>
      
      <tr>
        <td colspan="2">We confirm having allotted to you following stall/s subject to terms & conditions as per the application form, contract and the declaration form which is duly signed and submitted to the council by you for participating at Signature 201<font size="-1" face="Arial, Helvetica, sans-serif">6</font></td>
      </tr>
      <tr><td height="5px" colspan="2"></td></tr>
      
      <tr>
        <td colspan="2" align="center">
        
            <table width="600px" cellspacing="0" cellpadding="5" border="1" bordercolor="#ddd" align="center">
            
            <tr align="center" bgcolor="#eeeeee">
            <td><b>Stall No/s</b></td>
            <td><b>Area</b></td>
            <td><b>Premium Stalls</b></td>
            <td><b>Scheme</b></td>
            </tr>
            
            <tr align="center">
            <td><?php echo $stall_no;?></td>
            <td><?php echo $Exhibitor_Area;?>sq.mts.</td>
            <td><?php if($Exhibitor_Premium=='nornmal'){echo "No";}else {echo "Yes";}?></td>
            <td><?php echo $Exhibitor_Scheme;?></td>
            </tr>
            
            </table>        
        
        </td>
      </tr>
      <tr><td height="5px" colspan="2"></td></tr>
      
      <tr>
        <td colspan="2">We wish you a successful participation in Signature 201<font size="-1" face="Arial, Helvetica, sans-serif">6</font> and look forward to your all round co-operation.</td>
      </tr>
      <tr><td height="5px" colspan="2"></td></tr>
      
      <tr>
        <td colspan="2"><b>Note : This is only letter of allotment of stall at Signature 201<font size="-1" face="Arial, Helvetica, sans-serif">6</font>. The possession of stall/s is purely subject to full payment of the space rental</b></td>
      </tr>
      <tr><td height="5px" colspan="2"></td></tr>
      
      <tr>
        <td colspan="2">Thanking you,<br />Regards</td>
      </tr>
           
      <tr>
        <td colspan="2"><hr /></td>
      </tr>
      
       
      <tr>
        <td colspan="2">(P.S. Stall confirmation subject to realization of cheque/DD)<br />
        This is a computer generated letter, requires no signature.</td>
      </tr>
      
      <tr>
        <td colspan="2">        
        
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
        <td rowspan="2" align="left" valign="middle"><img src="http://www.gjepc.org/images/gjepc_logo.png" height="65px" /></td>
        <td align="center"><font size="+1" face="Times New Roman, Times, serif"><b>The Gem & Jewellery Export Promotion Council</b></font></td>
        <td rowspan="2" align="right" valign="middle"><img src="../print_acknowledge/logo.png" height="65px" /></td>
        </tr>
        <tr>
        <td align="center">
        <font size="1">Unit G2-A, Trade Center, Opp. BKC Telephone Exchange,<br />
        Bandra Kurla Complex, Bandra (E), Mumbai - 400 051. India <br />
        Tel: +91-22-4354 1800 &nbsp;&nbsp; Fax: +91-22-2652 4769 &nbsp;&nbsp; Email: iijs@gjepcindia.com &nbsp;&nbsp; Web: www.iijs.org
        </font>
        </td>
        </tr>
        </table>
        
        
        </td>
      </tr>
      <tr><td height="5px" colspan="2"></td></tr>
      
    </table>

</font>

</td>
</tr>
</table>
    </div>
    </form>
</body>
</html>
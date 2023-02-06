<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
include('../db.inc.php');
session_start();
$adminID=$_SESSION['admin_login_id'];

function getSap_material_no($id)
{
	$query_sel = "SELECT sap_material_no FROM iijs_stand_items_master where Item_ID='$id'";	
	$result_sel = $conn ->query($query_sel);								
		if($row = mysql_fetch_array($result_sel))		 	
		{ 		
			return $row['sap_material_no'];
		}
}

if(!empty($_POST))  
{	//echo "><pre>"; print_r($_POST);exit;	
	$exhibitor_code = trim($_POST['Exhibitor_Code']);
	$badge_id 		= trim($_POST['badge_id']);

	//$soapRenewalUrl = "https://webdisp.gjepcindia.com:44303/XISOAPAdapter/MessageServlet?channel=:BC_Exhibition:CC_Exhibition_Sender"; // Development
	$soapRenewalUrl = "https://webdisp.gjepcindia.com:44306/XISOAPAdapter/MessageServlet?channel=:BC_Exhibition:CC_Exhibition_Sender"; // LIVE
	$soapUser = "pi_admin";  //  username
	$soapPassword = "Deloitte@123"; // password
		
	$query="SELECT * FROM `dump_onspot_exhibitor` WHERE exhibitor_code='$exhibitor_code' AND badge_id='$badge_id'";
	$getChallanResult = $conn ->query($query);
	$challanResult = mysql_fetch_array($getChallanResult);

	$ho_bp_number = $challanResult['company_bp'];
	$billing_bp_number = $challanResult['billing_bp'];
	$net_payable_amount = $challanResult['amount'];
	$txnDate = $challanResult['receipt_date'];
	$date = str_replace('/', '-', $txnDate); 
	$getTxnDate = date('Ymd', strtotime($date)); 	
	//echo $getTxnDate = date("Ymd", strtotime($txnDate));exit; 
	$badge_id = trim($challanResult['badge_id']);	
	$item_material = trim($challanResult['material_no']);	
	$receipt_no = trim($challanResult['receipt_no']);		
	$remarks = $challanResult['remarks'];
	$po_ref = $receipt_no.'-'.$remarks;
	$item_rate = $challanResult['rates'];
	$shows = $challanResult['shows'];
	if($shows=="SIGNATURE")
	{
	$wbs = "DE-018";
	} else { 
	$wbs = "-";
	}
			
	$xml_exhibition_string = '<?xml version="1.0" encoding="utf-8"?>
	<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:gjep="http://gjepcexhibition.com">
    <soapenv:Header/>
    <soapenv:Body>
      <gjep:MT_Exhibition_IN>
        <SOAD_Header>
            <Sales_Doc>ZEVT</Sales_Doc>
            <SOrg>1000</SOrg>
            <Dis_channel>30</Dis_channel>
            <Division>20</Division>
            <sold_cust>'.$billing_bp_number.'</sold_cust>
            <ship_cust>'.$ho_bp_number.'</ship_cust>
            <po_ref>'.$po_ref.'</po_ref>
            <Pay_term>0001</Pay_term>
            <order_Reason>112</order_Reason>
            <Incoterms>CFR</Incoterms>
            <Incoterm_Loc>Onspot Badges</Incoterm_Loc>
			<Event_Type>D</Event_Type>
        </SOAD_Header>';
	
	$xml_exhibition_string .= '
        <SOAD_Item>
            <Item>0010</Item>
            <Material>'.$item_material.'</Material>
            <Order_Qty>1</Order_Qty>
            <Plant>1110</Plant>
            <Item_Category>TAD</Item_Category>
            <cond1_Lebel>ZREG</cond1_Lebel>
            <Cond1_Val>'.$item_rate.'</Cond1_Val>			
            <Cond2_Lebel></Cond2_Lebel>
            <Cond2_Val></Cond2_Val>			
            <Cond3_Lebel></Cond3_Lebel>
            <Cond3_val></Cond3_val>			
            <Cond4_Lebel></Cond4_Lebel>
            <Cond4_Val></Cond4_Val>
            <Cond5_Lebel></Cond5_Lebel>
            <Cond5_Val></Cond5_Val>
            <Cond6_Lebel></Cond6_Lebel>
            <Cond6_Val></Cond6_Val>
            <Batch></Batch>
            <WBS>'.$wbs.'</WBS>
            <Incoterms>CFR</Incoterms>
            <Incoterms_Loc>Onspot Badges</Incoterms_Loc>
            <Net_weight>1</Net_weight>
            <Gross_Weight>1</Gross_Weight>
        </SOAD_Item>';
				
	$xml_exhibition_string .= '
         <SOAD_Advance>
            <Doc_date>20200306</Doc_date>
            <Posting_date>'.$getTxnDate.'</Posting_date>
            <Company_code>1000</Company_code>
            <Currency>INR</Currency>
            <Account>'.$billing_bp_number.'</Account>
            <Sp_gl_indicator>A</Sp_gl_indicator>
            <Doc_text>SK</Doc_text>
            <Bank_Acc_No>255000</Bank_Acc_No>
            <Bus_area>1111</Bus_area>
            <Amount>'.$net_payable_amount.'</Amount>
            <Profit_centre>1110</Profit_centre>
            <Assignment></Assignment>
            <Sales_Doc></Sales_Doc>
            <Line_item>10</Line_item>
         </SOAD_Advance>
      </gjep:MT_Exhibition_IN>
   </soapenv:Body>
</soapenv:Envelope>';
				
	/*header ("Content-Type:text/xml");
	echo $xml_exhibition_string; exit; */
	
			$headers1 = array(
                        "Content-type: text/xml;charset=\"utf-8\"",
                        "Accept: text/xml",
                        "Cache-Control: no-cache",
                        "Pragma: no-cache",
                        //"SOAPAction: http://connecting.website.com/WSDL_Service/GetPrice", 
                        "Content-length: ".strlen($xml_exhibition_string),
                    ); //SOAPAction: your op URL

            $urls = $soapRenewalUrl;

            // PHP cURL  for https connection with auth
            $ch1 = curl_init();
            curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, 1);
            curl_setopt($ch1, CURLOPT_URL, $urls);
            curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch1, CURLOPT_USERPWD, $soapUser.":".$soapPassword); // username and password - declared at the top of the doc
            curl_setopt($ch1, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
           // curl_setopt($ch1, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch1, CURLOPT_POST, true);
            curl_setopt($ch1, CURLOPT_POSTFIELDS, $xml_exhibition_string); // the SOAP request
            curl_setopt($ch1, CURLOPT_HTTPHEADER, $headers1);

            // converting
            $respons = curl_exec($ch1); 
			//echo $respons;
            if(curl_errno($ch1))
				print curl_error($ch1);
			else
				curl_close($ch1);

			// print to get response print_r($response);
			//var_dump($respons); exit;			
			$xmlstr="<?xml version='1.0' encoding='UTF-8'?>".$respons;
			//echo $xmlstr;
			
			$xml = simplexml_load_string($xmlstr, NULL, NULL, "http://schemas.xmlsoap.org/soap/envelope/");
			$xml->registerXPathNamespace('soapenv', 'http://schemas.xmlsoap.org/soap/envelope/');
			$flag=0;			
			foreach($xml->xpath('//soapenv:Body') as $header)
			{
					$arr = $header->xpath('//msg_val'); // Should output 'something'.
					$leadid = $arr[0];
					$strings = $leadid;
					if(!empty($strings))
					{	$flag=1;
						$sales_order_no = trim(substr($strings, strpos($strings, "@ ")+1,11));
						$sqlx = "UPDATE `dump_onspot_exhibitor` SET `sap_push_date`=NOW(),`sap_push_admin`='$adminID',`sales_order_no`='$sales_order_no',`sap_sale_order_create_status`='1' WHERE `exhibitor_code`='$exhibitor_code' AND `badge_id` ='$badge_id'";
					 $result = $conn ->query($sqlx);
					}
			}
			echo $flag;	
}
?>
<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
include('../db.inc.php');
session_start();
$adminID=$_SESSION['admin_login_id'];

function getSap_material_no($id,$conn)
{
	$query_sel = "SELECT sap_material_no FROM iijs_stand_items_master where Item_ID='$id'";	
	$result_sel = $conn ->query($query_sel);								
		if($row = $result_sel->fetch_assoc())		 	
		{ 		
			return $row['sap_material_no'];
		}
}

if(!empty($_POST))
//if(true) 
{	//echo "<pre>"; print_r($_POST);exit;
	if(!empty($_POST['Form_ID']) && $_POST['Form_ID']==3)
	{	
	
		$Form_ID 		= trim($_POST['Form_ID']);
		$exhibitor_code = trim($_POST['Exhibitor_Code']);
		$order_id 		= trim($_POST['order_id']);
		
	//$soapRenewalUrl = "https://webdisp.gjepcindia.com:44303/XISOAPAdapter/MessageServlet?channel=:BC_Exhibition:CC_Exhibition_Sender"; // Development
	$soapRenewalUrl = "https://webdisp.gjepcindia.com:44306/XISOAPAdapter/MessageServlet?channel=:BC_Exhibition:CC_Exhibition_Sender"; // LIVE
	$soapUser = "pi_admin";  //  username
	$soapPassword = "Deloitte@123"; // password
	
	/*................................Get Country Code.....................................*/
	$exhibitor_data="select * from iijs_exhibitor where Exhibitor_Code='$exhibitor_code'";
	$result=$conn ->query($exhibitor_data);
	$fetch_data=$result->fetch_assoc();
	
	$Exhibitor_Name = $fetch_data['Exhibitor_Name'];
	$Exhibitor_Contact_Person = $fetch_data['Exhibitor_Contact_Person'];
	$Exhibitor_Phone = $fetch_data['Exhibitor_Phone'];
	$city = trim($fetch_data['Exhibitor_City']);
	$country_code = $fetch_data['Exhibitor_Country_ID'];
	$ho_bp_number = $fetch_data['Customer_No'];
	$billing_bp_number = $fetch_data['billing_bp_no'];
		
	$query="SELECT a.*,b.* FROM `iijs_stand` a,iijs_payment_master b WHERE 1 and a.`Payment_Master_ID`=b.`Payment_Master_ID` and a.Exhibitor_Code='$exhibitor_code' and b.Form_ID='3' and b.Payment_Master_OrderNo='$order_id' order by b.Payment_Master_ID asc";
	$getChallanResult = $conn ->query($query);
	$challanResult = $getChallanResult->fetch_assoc();	
	
	$net_payable_amount = $challanResult['Payment_Master_AmountPaid'];
	$txnDate = $challanResult['Create_Date'];
	$getTxnDate = date("Ymd", strtotime($txnDate));
	$Stand_ID = trim($challanResult['Stand_ID']);	
	$txn_status = trim($challanResult['txn_status']);	
			
	if($txn_status=='800'){ 
		$bank_acnt_no="255241"; /*online*/
	} elseif($txn_status=='900'){ 
		$bank_acnt_no="255000"; /*Cash*/
	}
	
	$Date = date('Ymd');
	$cur_year = (int)date('Y'); // Current Year
	$next_year  = $cur_year+1;
	$next_finyr = $next_year."0331"; // Next Financial year
			
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
            <po_ref>'.$order_id.'</po_ref>
            <Pay_term>0001</Pay_term>
            <order_Reason>112</order_Reason>
            <Incoterms>CFR</Incoterms>
            <Incoterm_Loc>'.$city.'</Incoterm_Loc>
			<Event_Type>D</Event_Type>
        </SOAD_Header>';
		
	$ssx = "select * from iijs_stand_items where Stand_ID='$Stand_ID'";
	$getItemsResult = $conn ->query($ssx);
	$countx = $getItemsResult->num_rows;
	$counter = "10";
	if($countx > 0){
	while($itemsResult = $getItemsResult->fetch_assoc())
	{	
	$item_material = trim(getSap_material_no($itemsResult['Item_Master_ID'],$conn));
	$item_qty = trim($itemsResult['Item_Quantity']);
	$item_rate = trim($itemsResult['Item_Rate']);
	
	$xml_exhibition_string .= '
        <SOAD_Item>
            <Item>00'.$counter.'</Item>
            <Material>'.$item_material.'</Material>
            <Order_Qty>'.$item_qty.'</Order_Qty>
            <Plant>1110</Plant>
            <Item_Category>ZTAD</Item_Category>
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
            <WBS>DE-056</WBS>
            <Incoterms>CFR</Incoterms>
            <Incoterms_Loc>'.$city.'</Incoterms_Loc>
            <Net_weight>1</Net_weight>
            <Gross_Weight>1</Gross_Weight>
         </SOAD_Item>';
		$counter=$counter+10;
	}}
		
	$xml_exhibition_string .= '
         <SOAD_Advance>
            <Doc_date>'.$Date.'</Doc_date>
            <Posting_date>'.$getTxnDate.'</Posting_date>
            <Company_code>1000</Company_code>
            <Currency>INR</Currency>
			<WBS>DE-056</WBS>
            <Account>'.$billing_bp_number.'</Account>
            <Sp_gl_indicator>A</Sp_gl_indicator>
            <Doc_text>SK</Doc_text>
            <Bank_Acc_No>'.$bank_acnt_no.'</Bank_Acc_No>
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
			//echo $respons;exit;
            if(curl_errno($ch1))
				print curl_error($ch1);
			else
				curl_close($ch1);

			// print to get response print_r($response);
			var_dump($respons);			
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
						$sqlx = "UPDATE `iijs_payment_master` SET `sap_push_date`=NOW(),`sap_push_admin`='$adminID',`sales_order_no`='$sales_order_no',`sap_sale_order_create_status`='1',api_used='onspot' WHERE `Exhibitor_Code`='$exhibitor_code' AND `Payment_Master_OrderNo` ='$order_id'";
						$result = $conn ->query($sqlx);
					}
			}
			echo $flag;	
}
}
?>
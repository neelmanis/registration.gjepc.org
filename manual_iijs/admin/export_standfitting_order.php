<?php
session_start(); 
ob_start();
include('../db.inc.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);
$date=date("d_m_Y");
?>
<?PHP
  // filename for download
  $export_filename = "StandfittingAll_" . date('Ymd') . ".xls";
  $table = $display = "";	
  $fn = "Standfiting_Item_Order";
 
  $sql = "SELECT ist.Exhibitor_Code,iie.Exhibitor_Name,ipm.sales_order_no,ist.orderId,ist.Items_Approved,ist.Payment_Master_ID,ist.Application_Complete, iisi.Item_Quantity, iisi.Item_Rate,ist.Create_Date,
  SUM(CASE isim.Item_ID when 2 then iisi.Item_Quantity ELSE 0 END) as 'Track Lights of 50 watt - Yellow',
  SUM(CASE isim.Item_ID when 3 then iisi.Item_Quantity ELSE 0 END) as 'Bar Stools',
  SUM(CASE isim.Item_ID when 5 then iisi.Item_Quantity ELSE 0 END) as 'Desk Table with Lockable storage (Maxima)' ,
  SUM(CASE isim.Item_ID when 6 then iisi.Item_Quantity ELSE 0 END) as 'Top Glass showcase - White' ,
  SUM(CASE isim.Item_ID when 7 then iisi.Item_Quantity ELSE 0 END) as '50 W LED - White' ,
  SUM(CASE isim.Item_ID when 8 then iisi.Item_Quantity ELSE 0 END) as '50 W LED - Yellow' ,
  SUM(CASE isim.Item_ID when 12 then iisi.Item_Quantity ELSE 0 END) as 'Brochure Rack' ,
  SUM(CASE isim.Item_ID when 15 then iisi.Item_Quantity ELSE 0 END) as 'Storage Unit with 2 shelves' ,
  SUM(CASE isim.Item_ID when 16 then iisi.Item_Quantity ELSE 0 END) as 'Plug Point' ,
  SUM(CASE isim.Item_ID when 17 then iisi.Item_Quantity ELSE 0 END) as 'Window show case 2M - White',
  SUM(CASE isim.Item_ID when 18 then iisi.Item_Quantity ELSE 0 END) as 'Window showcase 1M - White',
  SUM(CASE isim.Item_ID when 19 then iisi.Item_Quantity ELSE 0 END) as 'Window showcase 1M - Yellow',
  SUM(CASE isim.Item_ID when 20 then iisi.Item_Quantity ELSE 0 END) as 'Tall glass unit - Yellow',
  SUM(CASE isim.Item_ID when 21 then iisi.Item_Quantity ELSE 0 END) as 'Chair - BLACK cushion leather',
  SUM(CASE isim.Item_ID when 22 then iisi.Item_Quantity ELSE 0 END) as 'Track Lights of 50 watt - white',
  SUM(CASE isim.Item_ID when 23 then iisi.Item_Quantity ELSE 0 END) as 'Maxima System Panel',
  SUM(CASE isim.Item_ID when 31 then iisi.Item_Quantity ELSE 0 END) as 'Folding Door',
  SUM(CASE isim.Item_ID when 35 then iisi.Item_Quantity ELSE 0 END) as 'Dustbin with Lid',
  SUM(CASE isim.Item_ID when 37 then iisi.Item_Quantity ELSE 0 END) as 'Window show case 2M - Yellow',
  SUM(CASE isim.Item_ID when 38 then iisi.Item_Quantity ELSE 0 END) as 'Table (without panel)',
  SUM(CASE isim.Item_ID when 39 then iisi.Item_Quantity ELSE 0 END) as 'Tall glass unit - White',
  SUM(CASE isim.Item_ID when 40 then iisi.Item_Quantity ELSE 0 END) as 'Single Glass shelf',
  SUM(CASE isim.Item_ID when 41 then iisi.Item_Quantity ELSE 0 END) as 'Information Table without Lock (Maxima)',
  SUM(CASE isim.Item_ID when 66 then iisi.Item_Quantity ELSE 0 END) as 'Top Glass showcase Yellow',
  SUM(CASE isim.Item_ID when 67 then iisi.Item_Quantity ELSE 0 END) as 'Glass Round Table',

  SUM(CASE isim.Item_ID when 42 then iisi.Item_Quantity ELSE 0 END) as '50W LED light Metal - Yellow(M)',
  SUM(CASE isim.Item_ID when 43 then iisi.Item_Quantity ELSE 0 END) as '50W LED light Metal - White(M)' ,
  SUM(CASE isim.Item_ID when 45 then iisi.Item_Quantity ELSE 0 END) as 'Brochure Rack(M)' ,
  SUM(CASE isim.Item_ID when 46 then iisi.Item_Quantity ELSE 0 END) as 'Bar Stools(M)' ,
  SUM(CASE isim.Item_ID when 47 then iisi.Item_Quantity ELSE 0 END) as 'Chair - BLACK(M)' ,
  SUM(CASE isim.Item_ID when 48 then iisi.Item_Quantity ELSE 0 END) as 'Glass Round Table(M)' ,
  SUM(CASE isim.Item_ID when 49 then iisi.Item_Quantity ELSE 0 END) as 'Top Glass Showcase with 2arm / joota (COB LED) Lights & Lockable storage (White)(M)' ,
  SUM(CASE isim.Item_ID when 50 then iisi.Item_Quantity ELSE 0 END) as 'Top Glass Showcase with 2arm / joota (COB LED) Lights & Lockable storage (Yellow)(M)' ,
  SUM(CASE isim.Item_ID when 51 then iisi.Item_Quantity ELSE 0 END) as 'Tall Glass Showcase with 6 arm/joota (COB LED) lights & lockable storage (White)(M)' ,
  SUM(CASE isim.Item_ID when 52 then iisi.Item_Quantity ELSE 0 END) as 'Tall Glass Showcase with 6 arm/joota (COB LED) lights & lockable storage (Yellow)(M)' ,
  SUM(CASE isim.Item_ID when 54 then iisi.Item_Quantity ELSE 0 END) as 'Single Glass Shelf(M)' ,
  SUM(CASE isim.Item_ID when 55 then iisi.Item_Quantity ELSE 0 END) as 'Folding Door(M)' ,
  SUM(CASE isim.Item_ID when 56 then iisi.Item_Quantity ELSE 0 END) as 'System Panel(M)' ,
  SUM(CASE isim.Item_ID when 58 then iisi.Item_Quantity ELSE 0 END) as 'Dustbin(M)' ,
  SUM(CASE isim.Item_ID when 59 then iisi.Item_Quantity ELSE 0 END) as 'Plug Point(M)' ,
  SUM(CASE isim.Item_ID when 60 then iisi.Item_Quantity ELSE 0 END) as 'Table (with 3 Side Close Panel)(M)' ,
  SUM(CASE isim.Item_ID when 61 then iisi.Item_Quantity ELSE 0 END) as 'Desk Table with Lockable storage (Maxima)(M)' ,
  SUM(CASE isim.Item_ID when 64 then iisi.Item_Quantity ELSE 0 END) as 'Table (without panel)(M)' ,
  SUM(CASE isim.Item_ID when 68 then iisi.Item_Quantity ELSE 0 END) as '16 W LED - White(M)' ,
  SUM(CASE isim.Item_ID when 69 then iisi.Item_Quantity ELSE 0 END) as '16 W LED - Yellow(M)' 
  FROM `iijs_stand` as ist
  Join iijs_exhibitor as iie 
  on iie.Exhibitor_Code = ist.Exhibitor_Code
  LEFT JOIN  iijs_stand_items as iisi 
  on ist.Stand_ID = iisi.Stand_ID
  left JOIN iijs_stand_items_master as isim 
  on iisi.Item_Master_ID = isim.Item_ID
  Join iijs_payment_master as ipm on ipm.Payment_Master_OrderNo = ist.orderId
--   where ist.Exhibitor_Code = 'EXH252' and 
--   ist.Stand_ID = iisi.Stand_ID
  GROUP BY ist.orderId
  ORDER BY ist.Create_Date desc";
  $result= $conn ->query($sql);
  
  $table .= '<table  border="0" cellpadding="0" cellspacing="0"><tr>
  <td><b>Exhibitor Code</b></td>
  <td><b>Exhibitor Name</b></td>
  <td><b>Sale Order Number</b></td>
  <td><b>Order Id</b></td>
  <td><b>Item Approved</b></td>
  <td><b>Payment Master Id</b></td>
  <td><b>Track Lights of 50 watt - Yellow<b></td>
  <td><b>Bar Stools<b></td>
  <td><b>Desk Table with Lockable storage (Maxima)<b></td>
  <td><b>Top Glass showcase - White<b></td>
  <td><b>50 W LED - White<b></td>
  <td><b>50 W LED - Yellow<b></td>
  <td><b>Brochure Rack<b></td>
  <td><b>Storage Unit with 2 shelves<b></td>
  <td><b>Plug Point<b></td>
  <td><b>Window show case 2M - White<b></td>
  <td><b>Window showcase 1M - White<b></td>
  <td><b>Window showcase 1M - Yellow<b></td>
  <td><b>Tall glass unit - Yellow<b></td>
  <td><b>Chair - BLACK cushion leather<b></td>
  <td><b>Track Lights of 50 watt - white<b></td>
  <td><b>Maxima System Panel<b></td>
  <td><b>Folding Door<b></td>
  <td><b>Dustbin with Lid<b></td>
  <td><b>Window show case 2M - Yellow<b></td>
  <td><b>Table (without panel)<b></td>
  <td><b>Tall glass unit - White<b></td>
  <td><b>Single Glass shelf<b></td>
  <td><b>Information Table without Lock (Maxima)<b></td>
  <td><b>Top Glass showcase Yellow<b></td>
  <td><b>Glass Round Table<b></td>
  <td><b>50W LED light Metal - Yellow(M)<b></td>
  <td><b>50W LED light Metal - White(M)<b></td>
  <td><b>Brochure Rack(M)<b></td>
  <td><b>Bar Stools(M)<b></td>
  <td><b>Chair - BLACK(M)<b></td>
  <td><b>Glass Round Table(M)<b></td>
  <td><b>Top Glass Showcase with 2arm / joota (COB LED) Lights & Lockable storage (White)(M)<b></td>
  <td><b>Top Glass Showcase with 2arm / joota (COB LED) Lights & Lockable storage (Yellow)(M)<b></td>
  <td><b>Tall Glass Showcase with 6 arm/joota (COB LED) lights & lockable storage (White)(M)<b></td>
  <td><b>Tall Glass Showcase with 6 arm/joota (COB LED) lights & lockable storage (Yellow)(M)<b></td>
  <td><b>Single Glass Shelf(M)<b></td>
  <td><b>Folding Door(M)<b></td>
  <td><b>System Panel(M)<b></td>
  <td><b>Dustbin(M)<b></td>
  <td><b>Plug Point(M)<b></td>
  <td><b>Table (with 3 Side Close Panel)(M)<b></td>
  <td><b>Desk Table with Lockable storage (Maxima)(M)<b></td>
  <td><b>Table (without panel)(M)<b></td>
  <td><b>16 W LED - White(M)<b></td>
  <td><b>16 W LED - Yellow(M)<b></td>
        <td>Application Complete</td>



  
  </tr>';
  
  while($rows=$result->fetch_assoc())
  {     
        if(!isset($rows['Window show case 2M - White'])){
                $rows['Window show case 2M - White']=0;
        }if(!isset($rows['Window showcase 1M - Yellow'])){
                $rows['Window showcase 1M - Yellow']=0;
        }if(!isset($rows['Tall glass unit - Yellow'])){
                $rows['Tall glass unit - Yellow']=0;
        }if(!isset($rows['Chair - BLACK cushion leather'])){
                $rows['Chair - BLACK cushion leather']=0;
        }if(!isset($rows['Track Lights of 50 watt - white'])){
                $rows['Track Lights of 50 watt - white']=0;
        }if(!isset($rows['Maxima System Panel'])){
                $rows['Maxima System Panel']=0;
        }if(!isset($rows['Folding Door'])){
                $rows['Folding Door']=0;
        }
        if(!isset($rows['Single Glass shelf'])){
                $rows['Single Glass shelf']=0;
        }
        if(!isset($rows['Dustbin with Lid'])){
                $rows['Dustbin with Lid'] = 0;
        } if(!isset($rows['Window show case 2M - Yellow'])){
                $rows['Window show case 2M - Yellow']=0;
        }if(!isset($rows['Table (without panel)'])){
                $rows['Table (without panel)']=0;
        }if(!isset($rows['Tall glass unit - White'])){
                $rows['Tall glass unit - White']=0;
        }if(!isset($rows['Information Table without Lock (Maxima)'])){
                $rows['Information Table without Lock (Maxima)']=0;
        }if(!isset($rows['Top Glass showcase Yellow'])){
                $rows['Top Glass showcase Yellow']=0;
        }if(!isset($rows['Glass Round Table'])){
                $rows['Glass Round Table']=0;
        }
  $table .= '<tr>
  <td>'.$rows['Exhibitor_Code'].'</td>
  <td>'.$rows['Exhibitor_Name'].'</td>
  <td>'.$rows['sales_order_no'].'</td>
  <td>'.$rows['orderId'].'</td>
  <td>'.$rows['Items_Approved'].'</td>
  <td>'.$rows['Payment_Master_ID'].'</td>
  <td>'.$rows['Track Lights of 50 watt - Yellow'].'</td>
  <td>'.$rows['Bar Stools'].'</td>
  <td>'.$rows['Desk Table with Lockable storage (Maxima)'].'</td>
  <td>'.$rows['Top Glass showcase - White'].'</td>
  <td>'.$rows['50 W LED - White'].'</td>
  <td>'.$rows['50 W LED - Yellow'].'</td>
  <td>'.$rows['Brochure Rack'].'</td>
  <td>'.$rows['Storage Unit with 2 shelves'].'</td>
  <td>'.$rows['Plug Point'].'</td>
  <td>'.$rows['Window show case 2M - White'].'</td>
  <td>'.$rows['Window showcase 1M - White'].'</td>
  <td>'.$rows['Window showcase 1M - Yellow'].'</td>
  <td>'.$rows['Tall glass unit - Yellow'].'</td>
  <td>'.$rows['Chair - BLACK cushion leather'].'</td>
  <td>'.$rows['Track Lights of 50 watt - white'].'</td>
  <td>'.$rows['Maxima System Panel'].'</td>
  <td>'.$rows['Folding Door'].'</td>
  <td>'.$rows['Dustbin with Lid'].'</td>
  <td>'.$rows['Window show case 2M - Yellow'].'</td>
  <td>'.$rows['Table (without panel)'].'</td>
  <td>'.$rows['Tall glass unit - White'].'</td>
  <td>'.$rows['Single Glass shelf'].'</td>
  <td>'.$rows['Information Table without Lock (Maxima)'].'</td>
  <td>'.$rows['Top Glass showcase Yellow'].'</td>
  <td>'.$rows['Glass Round Table'].'</td>
  <td>'.$rows['50W LED light Metal - Yellow(M)'].'</td>
  <td>'.$rows['50W LED light Metal - White(M)'].'</td>
  <td>'.$rows['Brochure Rack(M)'].'</td>
  <td>'.$rows['Bar Stools(M)'].'</td>
  <td>'.$rows['Chair - BLACK(M)'].'</td>
  <td>'.$rows['Glass Round Table(M)'].'</td>
  <td>'.$rows['Top Glass Showcase with 2arm / joota (COB LED) Lights & Lockable storage (White)(M)'].'</td>
  <td>'.$rows['Top Glass Showcase with 2arm / joota (COB LED) Lights & Lockable storage (Yellow)(M)'].'</td>
  <td>'.$rows['Tall Glass Showcase with 6 arm/joota (COB LED) lights & lockable storage (White)(M)'].'</td>
  <td>'.$rows['Tall Glass Showcase with 6 arm/joota (COB LED) lights & lockable storage (Yellow)(M)'].'</td>
  <td>'.$rows['Single Glass Shelf(M)'].'</td>
  <td>'.$rows['Folding Door(M)'].'</td>
  <td>'.$rows['System Panel(M)'].'</td>
  <td>'.$rows['Dustbin(M)'].'</td>
  <td>'.$rows['Plug Point(M)'].'</td>
  <td>'.$rows['Table (with 3 Side Close Panel)(M)'].'</td>
  <td>'.$rows['Desk Table with Lockable storage (Maxima)(M)'].'</td>
  <td>'.$rows['Table (without panel)(M)'].'</td>
  <td>'.$rows['16 W LED - White(M)'].'</td>
  <td>'.$rows['16 W LED - Yellow(M)'].'</td>
  <td>'.$rows['Application_Complete'].'</td>
 
  
  
  </tr>';
  }
  $table .= $display;
  $table .= '</table>';
  
                  header("Content-type: application/x-msdownload"); 
                  # replace excelfile.xls with whatever you want the filename to default to
                  header("Content-Disposition: attachment; filename=$fn.xls");
                  header("Pragma: no-cache");
                  header("Expires: 0");
                  echo $table;
//   $result = $conn ->query("SELECT ist.Exhibitor_Code,iie.Exhibitor_Name,ist.orderId,ist.Items_Approved,ist.Payment_Master_ID,ist.Application_Complete, iisi.Item_Quantity, iisi.Item_Rate,ist.Create_Date,
//   SUM(CASE isim.Item_ID when 2 then iisi.Item_Quantity ELSE 0 END) as 'Track Lights of 50 watt - Yellow',SUM(CASE isim.Item_ID when 3 then iisi.Item_Quantity ELSE 0 END) as 'Bar Stools',
//   SUM(CASE isim.Item_ID when 5 then iisi.Item_Quantity ELSE 0 END) as 'Desk Table with Lockable storage (Maxima)' ,
//   SUM(CASE isim.Item_ID when 6 then iisi.Item_Quantity ELSE 0 END) as 'Top Glass showcase - White' ,
//   SUM(CASE isim.Item_ID when 7 then iisi.Item_Quantity ELSE 0 END) as '50 W LED - White' ,
//   SUM(CASE isim.Item_ID when 8 then iisi.Item_Quantity ELSE 0 END) as '50 W LED - Yellow' ,
//   SUM(CASE isim.Item_ID when 12 then iisi.Item_Quantity ELSE 0 END) as 'Brochure Rack' ,
//   SUM(CASE isim.Item_ID when 15 then iisi.Item_Quantity ELSE 0 END) as 'Storage Unit with 2 shelves' ,
//   SUM(CASE isim.Item_ID when 16 then iisi.Item_Quantity ELSE 0 END) as 'Plug Point' ,
//   SUM(CASE isim.Item_ID when 17 then iisi.Item_Quantity ELSE 0 END) as 'Window show case 2M - White ',
//   SUM(CASE isim.Item_ID when 18 then iisi.Item_Quantity ELSE 0 END) as 'Window showcase 1M - White',
//   SUM(CASE isim.Item_ID when 19 then iisi.Item_Quantity ELSE 0 END) as 'Window showcase 1M - Yellow ',
//   SUM(CASE isim.Item_ID when 20 then iisi.Item_Quantity ELSE 0 END) as 'Tall glass unit - Yellow ',
//   SUM(CASE isim.Item_ID when 21 then iisi.Item_Quantity ELSE 0 END) as 'Chair - BLACK cushion leather ',
//   SUM(CASE isim.Item_ID when 22 then iisi.Item_Quantity ELSE 0 END) as 'Track Lights of 50 watt - white ',
//   SUM(CASE isim.Item_ID when 23 then iisi.Item_Quantity ELSE 0 END) as 'Maxima System Panel ',
//   SUM(CASE isim.Item_ID when 31 then iisi.Item_Quantity ELSE 0 END) as 'Folding Door ',
//   SUM(CASE isim.Item_ID when 35 then iisi.Item_Quantity ELSE 0 END) as 'Dustbin with Lid ',
//   SUM(CASE isim.Item_ID when 37 then iisi.Item_Quantity ELSE 0 END) as 'Window show case 2M - Yellow ',
//   SUM(CASE isim.Item_ID when 38 then iisi.Item_Quantity ELSE 0 END) as 'Table (without panel) ',
//   SUM(CASE isim.Item_ID when 39 then iisi.Item_Quantity ELSE 0 END) as 'Tall glass unit - White ',
//   SUM(CASE isim.Item_ID when 40 then iisi.Item_Quantity ELSE 0 END) as 'Single Glass shelf ',
//   SUM(CASE isim.Item_ID when 41 then iisi.Item_Quantity ELSE 0 END) as 'Information Table without Lock (Maxima) ',
//   SUM(CASE isim.Item_ID when 66 then iisi.Item_Quantity ELSE 0 END) as 'Top Glass showcase Yellow ',
//   SUM(CASE isim.Item_ID when 67 then iisi.Item_Quantity ELSE 0 END) as 'Glass Round Table ',
  
//   SUM(CASE isim.Item_ID when 42 then iisi.Item_Quantity ELSE 0 END) as '50W LED light Metal - Yellow',
//   SUM(CASE isim.Item_ID when 43 then iisi.Item_Quantity ELSE 0 END) as '50W LED light Metal - White' ,
//   SUM(CASE isim.Item_ID when 45 then iisi.Item_Quantity ELSE 0 END) as 'Brochure Rack' ,
//   SUM(CASE isim.Item_ID when 46 then iisi.Item_Quantity ELSE 0 END) as 'Bar Stools' ,
//   SUM(CASE isim.Item_ID when 47 then iisi.Item_Quantity ELSE 0 END) as 'Chair - BLACK' ,
//   SUM(CASE isim.Item_ID when 48 then iisi.Item_Quantity ELSE 0 END) as 'Glass Round Table' ,
//   SUM(CASE isim.Item_ID when 49 then iisi.Item_Quantity ELSE 0 END) as 'Top Glass Showcase with 2arm / joota (COB LED) Lights & Lockable storage (White)' ,
//   SUM(CASE isim.Item_ID when 50 then iisi.Item_Quantity ELSE 0 END) as 'Top Glass Showcase with 2arm / joota (COB LED) Lights & Lockable storage (Yellow)' ,
//   SUM(CASE isim.Item_ID when 51 then iisi.Item_Quantity ELSE 0 END) as 'Tall Glass Showcase with 6 arm/joota (COB LED) lights & lockable storage (White)' ,
//   SUM(CASE isim.Item_ID when 52 then iisi.Item_Quantity ELSE 0 END) as 'Tall Glass Showcase with 6 arm/joota (COB LED) lights & lockable storage (Yellow)' ,
//   SUM(CASE isim.Item_ID when 54 then iisi.Item_Quantity ELSE 0 END) as 'Single Glass Shelf' ,
//   SUM(CASE isim.Item_ID when 55 then iisi.Item_Quantity ELSE 0 END) as 'Folding Door' ,
//   SUM(CASE isim.Item_ID when 56 then iisi.Item_Quantity ELSE 0 END) as 'System Panel' ,
//   SUM(CASE isim.Item_ID when 58 then iisi.Item_Quantity ELSE 0 END) as 'Dustbin' ,
//   SUM(CASE isim.Item_ID when 59 then iisi.Item_Quantity ELSE 0 END) as 'Plug Point' ,
//   SUM(CASE isim.Item_ID when 60 then iisi.Item_Quantity ELSE 0 END) as 'Table (with 3 Side Close Panel)' ,
//   SUM(CASE isim.Item_ID when 61 then iisi.Item_Quantity ELSE 0 END) as 'Desk Table with Lockable storage (Maxima)' ,
//   SUM(CASE isim.Item_ID when 64 then iisi.Item_Quantity ELSE 0 END) as 'Table (without panel)' ,
//   SUM(CASE isim.Item_ID when 68 then iisi.Item_Quantity ELSE 0 END) as '16 W LED - White' ,
//   SUM(CASE isim.Item_ID when 69 then iisi.Item_Quantity ELSE 0 END) as '16 W LED - Yellow' 
//   FROM `iijs_stand` as ist
//   Join iijs_exhibitor as iie 
//   on iie.Exhibitor_Code = ist.Exhibitor_Code
//   LEFT JOIN  iijs_stand_items as iisi 
//   on ist.Stand_ID = iisi.Stand_ID
//   left JOIN iijs_stand_items_master as isim 
//   on iisi.Item_Master_ID = isim.Item_ID
//   and ist.Stand_ID = iisi.Stand_ID
//   GROUP BY ist.orderId
//   ORDER BY ist.Create_Date desc") or die('Query failed!');
// 	$count = $result->num_rows;$data='';
// 	$header = '';
// 	for ($i = 0; $i < $count; $i++){
//                 try {
//                         $datatype = mysqli_fetch_field_direct($result, $i);
//                         if(isset($datatype->name)){

//                         $header .= $datatype->name."\t";
//                 }
//                 }catch (Exception $e){
//                         $error = $e->getMessage();
//                         echo $error;
//                 }
                
                
	        
// 	}
// 	//echo "<pre>"; print_r($result->fetch_assoc());exit;
// 	while($row = $result->fetch_assoc()){
// 		$line = '';
// 		foreach($row as $value){
// 		if(!isset($value) || $value == ""){
// 		$value = "\t";
// 		}else{
// 		$value = str_replace('"', '""', $value);
// 		$value = stripslashes($value);
// 		$value = '"' . $value . '"' . "\t";
// 		}
// 		$line .= $value;
// 		}
// 		$data .= trim($line)."\n";
// 	}
	
// $data = str_replace("\r", "", $data);
// if ($data == "") {
// $data = "\nNo Data Found\n";
// }
// // create table header showing to download a xls (excel) file
// header("Content-type: application/octet-stream");
// header("Content-Disposition: attachment; filename=$export_filename");
// header("Cache-Control: public");
// header("Content-length: ".strlen($data)); // tells file size
// header("Pragma: no-cache");
// header("Expires: 0");
// // output data
// echo $header."\n".$data;
?>

<?php
include('db.inc.php');
/*
$table = $display = "";	
$fn = "Photo report";

$table .= '<table border="1" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td>Company Name</td>
<td>Registration Id</td>
<td>Visitor Id</td>
<td>Name</td>
<td>Person PAN No.</td>
<td>Person Mobile No.</td>
<td>Photo </td>
</tr>';
*/

$checkHistory = "SELECT visitor_id,registration_id,photo_url FROM `globalExhibition` WHERE (participant_Type='VIS' || participant_Type='IGJME') order by registration_id"; 
$resultQuery = $conn->query($checkHistory);
$num = $resultQuery->num_rows;

if($num>0)
{
	while($resultHistory = $resultQuery->fetch_assoc())
	{
		//echo '<pre>'; print_r($resultHistory);
		$visitor_id =  $resultHistory['visitor_id'];
		$registration_id = $resultHistory['registration_id'];
		$photo = basename($resultHistory['photo_url']);
		
		$src = './images/employee_directory/'.$registration_id.'/photo/'.$photo;
		$imagesize = filesize($src);
		  if($imagesize < 1024){
		//     $checkHistorys = "SELECT  company,fname,lname ,visitor_id,registration_id,pan_no,photo_url,mobile FROM  `globalExhibition` WHERE registration_id='$registration_id' AND visitor_id='$visitor_id'";
            echo "UPDATE `visitor_directory` SET `visitor_approval`='D',disapprove_reason='Kindly update your data' WHERE registration_id='$registration_id' AND visitor_id='$visitor_id'";
             echo '<br/>';
        /*    $result = $conn->query($checkHistorys);
            $row =$result->fetch_assoc();
             $table .= '<tr>
			<td>'.$row['company'].'</td>
			<td>'.$row['registration_id'].'</td>
			<td>'.$row['visitor_id'].'</td>
			<td>'.$row['fname'].' '.$row['lname'].'</td>
			<td>'.$row['pan_no'].'</td>
			<td>'.$row['mobile'].'</td>
			<td>'.$row['photo_url'].'</td>
			</tr>'; 
			
           */

		}
	}

}
/*
$table .= $display;
$table .= '</table>';

header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=$fn.xls");
header("Pragma: no-cache");
header("Expires: 0");
echo $table;
*/
?>
<?php
session_start(); 
ob_start();
include('../db.inc.php');
$date=date("d_m_Y");

function getExhibitorName($Exhibitor_Code)
{
	$query_sel = "SELECT Exhibitor_Name FROM iijs_exhibitor where Exhibitor_Code='$Exhibitor_Code'";
	$result_sel = mysql_query($query_sel);								
	if($row = mysql_fetch_array($result_sel))		 	
	{ 		
		return $row['Exhibitor_Name'];		
	}
}
?>

<?php
$stmtSql = "SELECT * FROM iijs_personalInfo WHERE  1 ORDER BY Exhibitor_Code ASC";
$stmt=mysql_query($stmtSql);
$setData='';
while($row = mysql_fetch_array($stmt))
{
$payment_date = date("d-m-Y", strtotime($row['Create_Date']));
$Exhibitor_Code=$row['Exhibitor_Code'];
$CompanyName=getExhibitorName($row['Exhibitor_Code']);
$showroom=$row['name_of_retail_showroom'];
$company_gst=$row['company_gst'];
$contact_person=strtoupper($row['contact_person']);
$mobile=$row['mobile'];
$designation=strtoupper($row['designation']);
$email_id=$row['email'];
$showroom_city=$row['showroom_city'];
$showroom_address=$row['showroom_address'];
$showroom_area=$row['showroom_area'];
$year_of_establishment=$row['year_of_establishment'];

	if($contact_person!=""){
		$contact_persons=explode(",",$contact_person);
		$count_person =   sizeof($contact_persons);
	}
	if($mobile!="")
	{
		$mobile=explode(",",$mobile);
		$count_mobile =   sizeof($mobile);
	}
	if($designation!="")
	{
		$designation=explode(",",$designation);
		$count_designation =   sizeof($designation);
	} 
	if($email_id!="")
	{
		$email=explode(",",$email_id);
		$count_email =   sizeof($email);
	}
	if($showroom_city!="")
	{
		$city=explode(",",$showroom_city);
		$count_city =   sizeof($city);
	}
	if($showroom_address!="")
	{
		$address=explode(",",$showroom_address);
		$count_address =   sizeof($address);
	} 
	if($showroom_area!="")
	{
		$area=explode(",",$showroom_area);
		$count_area =   sizeof($area);
	} 
	if($year_of_establishment!="")
	{
		$year=explode(",",$year_of_establishment);
		$count_year =   sizeof($year);
	}
	
	$value='';
    $columnHeader =   ''."Exhibitor Code"."\t"."Showroom"."\t"."Company Name"."\t"."Company GST"."\t"."Person"."\t"."Person Mobile"."\t"."Person Designation"."\t"."Email"."\t"."Showroom City"."\t"."Show Room Address"."\t"."Area"."\t"."Year"."\t";
	
	for( $k=0 ;$k < $count_person ; $k++){
              if(!empty($contact_persons[$k]) || $contact_persons[$k] !="" ){
             $value .= ''.$Exhibitor_Code."\t".$showroom."\t".$CompanyName."\t".$company_gst."\t".$contact_persons[$k]."\t".$mobile[$k]."\t".$designation[$k]."\t".$email[$k]."\t".$city[$k]."\t".$address[$k]."\t".$area[$k]."\t".$year[$k]."\t"."\n";
            }              
        }	
		$setData .= trim($value)."\n";
}

		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=elite_club_report.xls");
		header("Pragma: no-cache");
header("Expires: 0");

echo ucwords($columnHeader)."\n".$setData."\n";
?>
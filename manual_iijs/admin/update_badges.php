<?php
//include('../header_include.php');
include ("../db.inc.php");
include ("functions.php");
$Exhibitor_Code=$_POST['Exhibitor_Code'];
// Define path and new folder name
$path = "../images/badges/".$Exhibitor_Code."/";
if (!file_exists($path)) {
mkdir($path, 0777);
} 
	
	$Badge_ID=$_POST['Badge_ID'];
	$Badge_Item_ID=$_POST['Badge_Item_ID'];
	$Badge_Type=$_POST['Badge_Type'];
	if($Badge_Type=="E" || $Badge_Type=="M"){$exhibitor_maintenance_charge=0;}
	else {$exhibitor_maintenance_charge=500;}
	$Badge_Name=$_POST['Badge_Name'];
	$Badge_Mobile=$_POST['Badge_Mobile'];
	$Badge_Designation=$_POST['Badge_Designation'];
	/*if(isset($_POST['Badge_Approved']) && $_POST['Badge_Approved']!="")
	{
		$Badge_Approved=$_POST['Badge_Approved'];
	}	
	else
	{
		$Badge_Approved="P";
	}
	if(isset($_POST['Badge_Approved']) && $_POST['Badge_Approved']=="N")
	{
		$Badge_Reason=$_POST['Badge_Reason'];
	}
	else
	{
		$Badge_Reason="";
	}*/
    $exhibitor_data="select * from iijs_exhibitor where Exhibitor_Code='$Exhibitor_Code'";
	$result=$conn ->query($exhibitor_data);
	$fetch_data=$result->fetch_assoc();
	
	$Exhibitor_Name=$fetch_data['Exhibitor_Name'];
	$Exhibitor_Contact_Person=$fetch_data['Exhibitor_Contact_Person'];
	$Exhibitor_Email=$fetch_data['Exhibitor_Email'];
	
	$name = $_FILES['photoimg']['name'];
	$size = $_FILES['photoimg']['size'];
	$post_date=date('Y-m-d h:i:s');
	
	/*..................................Form Dead Line....................................*/	
	
	/*
	$query=$conn ->query("select Surcharge_Rate from iijs_form_details where Form_No='4' and  Dedline_Date <='2014-01-20 00:00:00'");
	$result=mysql_fetch_array($query);
	$surcharge=$result['surcharge'];
	*/
	
		list($txt, $ext) = explode(".", $name);
		$actual_image_name = $Badge_Type."_".$Badge_Name.".".$ext;
		$target_path=$path.$actual_image_name;
		$tmp = $_FILES['photoimg']['tmp_name'];
		
		$query=$conn ->query("select * from iijs_badge_items where Exhibitor_Code='$Exhibitor_Code' and Badge_ID='$Badge_ID'");
		$num_badges=$query->num_rows;
	
		move_uploaded_file($tmp,$target_path);
		$sql="update iijs_badge_items set Badge_Name='$Badge_Name',Badge_Mobile='$Badge_Mobile',Badge_Designation='$Badge_Designation'";
		if($name!=""){$sql.=",Badge_Photo='$actual_image_name'";}
		$sql.=" where Badge_ID='$Badge_ID' and Badge_Item_ID='$Badge_Item_ID'";		
		//echo $sql;exit;
		$ok = $conn ->query($sql);
		
		
		/*........................................Update in GJEPCLIVEDB...................................................*/
		
		$conn ->query("update gjepclivedatabase.globalExhibition set mobile='$Badge_Mobile',fname='$Badge_Name' where visitor_id='$Badge_Item_ID' and participant_Type='EXH'");
		$conn ->query("update gjepclivedatabase.visitor_lab_info set mobile_no='$Badge_Mobile' where visitor_id='$Badge_Item_ID' and category_for='EXH'");
		
		header('location:Form4.php?Badge_ID='.$Badge_ID.'&Exhibitor_Code='.$Exhibitor_Code);		
?>

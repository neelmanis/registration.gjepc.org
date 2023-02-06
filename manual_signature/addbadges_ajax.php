<?php
include('header_include.php');

// Define path and new folder name
$path = "images/badges/".$_SESSION['EXHIBITOR_CODE']."/";
if (!file_exists($path)) {
mkdir($path, 0777);
} 	
	$_SESSION['CarPass1']=$_POST['CarPass1'];
	if(isset($_SESSION['CarPass2'])){
	$_SESSION['CarPass2']=$_POST['CarPass2'];
	} else {
	$_SESSION['CarPass2']="";
	}
		
	$Badge_ID=$_POST['Badge_ID'];
	$Badge_Type=$_POST['Badge_Type'];
	if($Badge_Type=="E"){$exhibitor_maintenance_charge=0;}
	elseif($Badge_Type=="M"){$exhibitor_maintenance_charge=8000;}
	else{$exhibitor_maintenance_charge=0;}
	
	$Replace_Badge_Item_ID=$_POST['RBadge_Item_ID'];
	$Badge_Name = trim($_POST['Badge_Name']);
	$Badge_Mobile_No = trim($_POST['Badge_Mobile_No']);
	$Badge_Designation = $_POST['Badge_Designation'];
	$Exhibitor_Code = $_POST['Exhibitor_Code'];
	
	$exhibitor_data = "select * from iijs_exhibitor where Exhibitor_Code='$Exhibitor_Code'";
	$result = $conn ->query($exhibitor_data);
	$fetch_data = $result->fetch_assoc();
	
	$Exhibitor_Name=$fetch_data['Exhibitor_Name'];
	$Exhibitor_Contact_Person=$fetch_data['Exhibitor_Contact_Person'];
	$Exhibitor_Email=$fetch_data['Exhibitor_Email'];
	$Exhibitor_Section=$fetch_data['Exhibitor_Section'];
	
	$name = $_FILES['photoimg']['name'];
	$document = $_FILES['document']['name'];
	$size = $_FILES['photoimg']['size'];
	$post_date=date('Y-m-d h:i:s');

	/*..................................Form Dead Line....................................*/
	
	$query = $conn ->query("select Surcharge_Rate from iijs_form_details where Form_No=4 and isSurcharge='1' order by Form_DetailID desc limit 1");
	
	/*.......................Replacement badge count.................................*/
	$result = $query->fetch_assoc();
	$Rquery=$conn ->query("select * from iijs_badge_items_tmp where Exhibitor_Code='$Exhibitor_Code' and Badge_Type='R'");
	$Rnum_temp = $Rquery->num_rows; 
	
	$Rquery2 = $conn ->query("select * from iijs_badge_items where Exhibitor_Code='$Exhibitor_Code' and Badge_Type='R'");
	$Rnum_live = $Rquery2->num_rows; 
	$Rnum=$Rnum_temp+$Rnum_live;
	
	if($Badge_Type=="E" && $Exhibitor_Section=="machinery")
		$Surcharge=0;
	elseif($Badge_Type=="M")
		$Surcharge=8000;
	elseif($Badge_Type=="E" || $Badge_Type=="S")
		$Surcharge=0;
	else if($Badge_Type=="R" && $Rnum>=2)
		$Surcharge=2000;
	else if($Badge_Type=="R")
		$Surcharge=500;
				
	if(preg_match("/.php/i", $name)) {
   			echo "<script langauge=\"javascript\">alert(\"Sorry you have select Invalid file.\");location.href='exhibitors_badges.php?action=ADD';</script>";
			exit;
	}

	if(preg_match("/.php/i", $document)) {
				echo "<script langauge=\"javascript\">alert(\"Sorry you have select Invalid file.\");location.href='exhibitors_badges.php?action=ADD';</script>";
				exit;
	}
	if(strlen($name))
	{
		/*................Photo Upload..................*/
		$img_name=explode(".", $name);
		$ext=end($img_name);
		$actual_image_name = $Badge_Type."_".$Badge_Name.".".$ext;
		$target_path=$path.$actual_image_name;
		$tmp = $_FILES['photoimg']['tmp_name'];
		move_uploaded_file($tmp,$target_path );	
		/*.......................Document Upload.........................*/
		$img_document=explode(".", $document);
		$ext1=end($img_document);
		$actual_image_document = $Badge_Type."_".$Exhibitor_Code."_".$Badge_Name.".".$ext1;
		$target_path1=$path.$actual_image_document;
		$tmp1 = $_FILES['document']['tmp_name'];
		move_uploaded_file($tmp1,$target_path1);			
					
		$sqlx = "insert into iijs_badge_items_tmp set Replace_Badge_Item_ID='$Replace_Badge_Item_ID',Exhibitor_Code='$Exhibitor_Code',Badge_Type='$Badge_Type',Badge_Name='$Badge_Name',Badge_Designation='$Badge_Designation',Badge_Mobile='$Badge_Mobile_No',Badge_Photo='$actual_image_name',Badge_Document='$actual_image_document',exhibitor_maintenance_charge='$exhibitor_maintenance_charge',Surcharge='$Surcharge',post_date='$post_date'";
		$tmpResult=$conn ->query($sqlx);
		if(!$tmpResult) die ($conn->error);
	}
?>
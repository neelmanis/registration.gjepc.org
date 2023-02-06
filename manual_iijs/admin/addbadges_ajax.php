<?php
include('../header_include.php');


$Exhibitor_Code=$_POST['Exhibitor_Code'];
// Define path and new folder name
$path = "../images/badges/".$Exhibitor_Code."/";
if (!file_exists($path)) {
mkdir($path, 0777);
} 
	$Badge_ID=$_POST['Badge_ID'];
	$Badge_Type=$_POST['Badge_Type'];
	if($Badge_Type=="E" || $Badge_Type=="M"){$exhibitor_maintenance_charge=0;}
	else{$exhibitor_maintenance_charge=500;}
	
	$Badge_Name=$_POST['Badge_Name'];
	$Badge_Mobile=$_POST['Badge_Mobile'];
	$Badge_Designation=$_POST['Badge_Designation'];

    $exhibitor_data="select * from iijs_exhibitor where Exhibitor_Code='$Exhibitor_Code'";
	$result=mysql_query($exhibitor_data);
	$fetch_data=mysql_fetch_array($result);
	
	$Exhibitor_Name=$fetch_data['Exhibitor_Name'];
	$Exhibitor_Contact_Person=$fetch_data['Exhibitor_Contact_Person'];
	$Exhibitor_Email=$fetch_data['Exhibitor_Email'];
	
	$name = $_FILES['photoimg']['name'];
	$size = $_FILES['photoimg']['size'];
	$post_date=date('Y-m-d h:i:s');
	
		/*..................................Form Dead Line....................................*/
	$query=mysql_query("select Surcharge_Rate from iijs_form_details where Form_No=4 and Dedline_Date >= '2018-01-20 23:59:59' order by Form_DetailID desc limit 1");
	$result=mysql_fetch_array($query);
	if($Badge_Type=="E" || $Badge_Type=="M")
	{
		$Surcharge=intval($result['Surcharge_Rate']);
	}
	else
	{
		$Surcharge=0;
	}
	
	
	if(strlen($name))
	{
		list($txt, $ext) = explode(".", $name);
		$actual_image_name = $Badge_Type."_".$Badge_Name.".".$ext;
		$target_path=$path.$actual_image_name;
		$tmp = $_FILES['photoimg']['tmp_name'];
		
		$query=mysql_query("select * from iijs_badge_items where Exhibitor_Code='$Exhibitor_Code' and Badge_ID='$Badge_ID'");
		$num_badges=mysql_num_rows($query);
	
			move_uploaded_file($tmp,$target_path);
			mysql_query("insert into iijs_badge_items set Exhibitor_Code='$Exhibitor_Code',Badge_ID='$Badge_ID',Badge_Type='$Badge_Type',Badge_Name='$Badge_Name',Badge_Designation='$Badge_Designation',Badge_Mobile='$Badge_Mobile',Badge_Photo='$actual_image_name',Surcharge='$Surcharge',Create_Date='$post_date'");
		
		$query=mysql_query("select * from iijs_payment_master where  Exhibitor_Code='$Exhibitor_Code' and  Form_ID='4'");
		$result=mysql_fetch_array($query);
		$Payment_Master_ID=$result['Payment_Master_ID'];
		$Payment_Master_Amount1=$result['Payment_Master_Amount'];
		$Payment_Master_Amount=$exhibitor_maintenance_charge+$Payment_Master_Amount1;
		$Payment_Master_ServiceTax=$Payment_Master_Amount*18/100;
		//$Payment_Master_EducationCess=$Payment_Master_ServiceTax*.5/100;
		//$she_cess_tax=$Payment_Master_ServiceTax*0/100;
		$Payment_Master_AmountPaid=round($Payment_Master_Amount+$Payment_Master_ServiceTax);
		$Create_Date=date('Y-m-d h:i:s');
		mysql_query("update iijs_payment_master set Form_ID='4',Exhibitor_Code='$Exhibitor_Code',Payment_Master_Amount='$Payment_Master_Amount',Payment_Master_ServiceTax='$Payment_Master_ServiceTax',Payment_Master_EducationCess='$Payment_Master_EducationCess',Payment_Master_AmountPaid='$Payment_Master_AmountPaid',Create_Date='$Create_Date',Modify_Date='$Modify_Date' where Payment_Master_ID='$Payment_Master_ID'");	
		
echo $Badge_ID."#".$Exhibitor_Code;
}
?>

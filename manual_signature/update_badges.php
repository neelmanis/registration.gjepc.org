<?php
include('header_include.php');

// Define path and new folder name
$path = "images/badges/".$_SESSION['EXHIBITOR_CODE']."/";
if (!file_exists($path)) {
mkdir($path, 0777);
}
/*
if(isset($_POST['convert_to_exhibitor']) && $_POST['convert_to_exhibitor']=='Convert To Exhibitor')
{
	$Badge_ID=$_POST['Badge_ID'];
	$Badge_Item_ID=$_POST['Badge_Item_ID'];
	$Badge_Type=$_POST['Badge_Type'];
	$Exhibitor_Code=$_POST['Exhibitor_Code'];
	$Conversion_Charges=1750;
	mysql_query("update iijs_badge_items set Is_Converted='Y',Conversion_Charges='$Conversion_Charges' where Badge_Item_ID='$Badge_Item_ID' and Exhibitor_Code='$Exhibitor_Code'");
	echo '<script type="text/javascript">window.location="exhibitors_badges.php?badges=update";</script>';
} */

if(isset($_POST['save']) && $_POST['save']=='Update'){
	$Badge_ID=$_POST['Badge_ID'];
	$Badge_Item_ID=$_POST['Badge_Item_ID'];
	$Badge_Type=$_POST['Badge_Type'];
	$Exhibitor_Code=$_POST['Exhibitor_Code'];
	$Badge_Name=$_POST['Badge_Name'];
	$Badge_Designation=$_POST['Badge_Designation'];
	$Badge_Mobile=$_POST['Badge_Mobile'];
	
	if(isset($_FILES['replace_badge_img']['name']))
	{
		$name = $_FILES['replace_badge_img']['name'];
		$size = $_FILES['replace_badge_img']['size'];
		$tmp = $_FILES['replace_badge_img']['tmp_name'];
	}
	if(isset($_FILES['replace_badge_img1']['name']))
	{
		$name = $_FILES['replace_badge_img1']['name'];
		$size = $_FILES['replace_badge_img1']['size'];
		$tmp = $_FILES['replace_badge_img1']['tmp_name'];
	}
	if(isset($_FILES['replace_badge_img2']['name']))
	{
		$name = $_FILES['replace_badge_img2']['name'];
		$size = $_FILES['replace_badge_img2']['size'];
		$tmp = $_FILES['replace_badge_img2']['tmp_name'];
	}
	if(isset($_FILES['replace_badge_img3']['name']))
	{
		$name = $_FILES['replace_badge_img3']['name'];
		$size = $_FILES['replace_badge_img3']['size'];
		$tmp = $_FILES['replace_badge_img3']['tmp_name'];
	}
	if(isset($_FILES['replace_badge_docuemnt']['name']))
	{
		$doc_name = $_FILES['replace_badge_docuemnt']['name'];
		$doc_tmp = $_FILES['replace_badge_docuemnt']['tmp_name'];
	}
	if(isset($_FILES['replace_badge_docuemnt1']['name']))
	{
		$doc_name = $_FILES['replace_badge_docuemnt1']['name'];
		$doc_tmp = $_FILES['replace_badge_docuemnt1']['tmp_name'];
	}
	if(isset($_FILES['replace_badge_docuemnt2']['name']))
	{
		$doc_name = $_FILES['replace_badge_docuemnt2']['name'];
		$doc_tmp = $_FILES['replace_badge_docuemnt2']['tmp_name'];
	}
	if(isset($_FILES['replace_badge_docuemnt3']['name']))
	{
		$doc_name = $_FILES['replace_badge_docuemnt3']['name'];
		$doc_tmp = $_FILES['replace_badge_docuemnt3']['tmp_name'];
	}
	
	$post_date=date('Y-m-d h:i:s');
	$img_name=explode(".", $name);
	$ext=end($img_name);
	
	if($ext =="GIF" || $ext=="gif" || $ext=="jpg" || $ext=="JPG" || $ext=="png" || $ext=="PNG" || $ext=="jpeg")
	{
		$actual_image_name = $Badge_Type."_".$Badge_Name.".".$ext;
		$target_path=$path.$actual_image_name;	
		move_uploaded_file($tmp,$target_path);
		$sql="update iijs_badge_items set Badge_Name='$Badge_Name'";
		if($name!=""){$sql.=",Badge_Photo='$actual_image_name'";}
		$sql.=" where Badge_ID='$Badge_ID' and Badge_Item_ID='$Badge_Item_ID'";
		$result = $conn ->query($sql);
	}
	if($doc_name!="")
	{
		$img_document=explode(".", $doc_name);
		$ext1=end($img_document);
		$actual_image_document = $Badge_Type."_".$Exhibitor_Code."_".$Badge_Name.".".$ext1;
		$target_path1=$path.$actual_image_document;
		move_uploaded_file($doc_tmp,$target_path1);
		
		$sql="update iijs_badge_items set ";
		if($doc_name!=""){$sql.=" Badge_Document='$actual_image_document'";}
		$sql.=" where Badge_ID='$Badge_ID' and Badge_Item_ID='$Badge_Item_ID'";
		$result = $conn ->query($sql);
	}
	 $result = $conn ->query("update iijs_badge_items set Badge_Approved='P' where Badge_Item_ID='$Badge_Item_ID'");
	 if($result)
		$conn ->query("update iijs_badge set Info_Approved='P',Modify_Date='$post_date' where Badge_ID='$Badge_ID'");
	
	echo '<script type="text/javascript">window.location="exhibitors_badges.php?badges=update";</script>';
}
if(isset($_POST['action']) && $_POST['action']=='safe_key_person_update'){
	
	$safeKeyPerson1 = $_POST['safeKeyPerson1'];
	$safeKeyPerson2 = $_POST['safeKeyPerson2'];
	$EXHIBITOR_CODE = $_SESSION['EXHIBITOR_CODE'];
	if($safeKeyPerson1 ==""){
	echo json_encode(array("status"=>"error","label"=>"safeKeyPerson1","message"=>"Select safe key person 1"));exit;
	}
	if($safeKeyPerson2 ==""){
	echo json_encode(array("status"=>"error","label"=>"safeKeyPerson2","message"=>"Select safe key person 2"));exit;
	}
	//echo "UPDATE iijs_badge_items SET Badge_IsKeyPerson='1' WHERE Badge_IsKeyPerson = '$safeKeyPerson1' and Exhibitor_Code= '$EXHIBITOR_CODE' ";exit;
	
	if($safeKeyPerson1 !==""){
		$update1 = $conn->query("UPDATE iijs_badge_items SET Badge_IsKeyPerson='1' WHERE Badge_Item_ID = '$safeKeyPerson1' and Exhibitor_Code= '$EXHIBITOR_CODE' ");
	}
	if($safeKeyPerson2 !==""){
		$update2 = $conn->query("UPDATE iijs_badge_items SET Badge_IsKeyPerson='1' WHERE Badge_Item_ID = '$safeKeyPerson2' and Exhibitor_Code= '$EXHIBITOR_CODE' ");
	}
	echo json_encode(array("status"=>"success","message"=>"Safe Key person has been updated sussessfully"));exit;
    


}			
?>

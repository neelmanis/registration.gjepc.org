<?php 
include('header_include.php');

$registration_id = $_SESSION['USERID'];

$buy_sell_profile_code=filter($_REQUEST['user_type']);
$obmp_profile_code=$_SESSION['profile_code'];
$company_name=filter($_REQUEST['company_name']);
$contact_person=filter($_REQUEST['contact_person']);
$designation=filter($_REQUEST['designation']);
$website=filter($_REQUEST['website']);
$write_up=filter($_REQUEST['write_up']);
$wa_jewellery1=$_REQUEST['wa_jewellery'];
$wa_jewellery_other=filter($_REQUEST['wa_jewellery_other']);
foreach($wa_jewellery1 as $val)
{
    $end=end($wa_jewellery1);
	$wa_jewellery.=$val;
	if($end!=$val){$wa_jewellery.=",";}
    if($val=='any other'){$wa_jewellery.=",".$wa_jewellery_other;} 
}
 
$pd_jewellery1=$_REQUEST['pd_jewellery'];
$pd_jewellery_other=$_REQUEST['pd_jewellery_other'];

foreach($pd_jewellery1 as $val)
{
	$end=end($pd_jewellery1);
	$pd_jewellery.=$val;
	if($end!=$val){$pd_jewellery.=",";}
    if($val=='any other'){$pd_jewellery.=",".$pd_jewellery_other;}
}

$item_description1=$_REQUEST['item_description'];
$item_description_other=$_REQUEST['item_description_other'];
foreach($item_description1 as $val)
{
	$end=end($item_description1);
	$item_description.=$val;
	if($end!=$val){$item_description.=",";}
    if($val=='any other'){$item_description.=",".$item_description_other;}
}

$d_size1=$_REQUEST['d_size'];
foreach($d_size1 as $val){
$end=end($d_size1);
$d_size.=$val;
if($end!=$val){$d_size.=",";}
}

$d_clarity1=$_REQUEST['d_clarity'];
foreach($d_clarity1 as $val){
$end=end($d_clarity1);
$d_clarity.=$val;
if($end!=$val){$d_clarity.=",";}
}

$d_color_shade1=$_REQUEST['d_color_shade'];
foreach($d_color_shade1 as $val){
$end=end($d_color_shade1);
$d_color_shade.=$val;
if($end!=$val){$d_color_shade.=",";}
}

$d_pp_from=$_REQUEST['d_pp_from'];
$d_pp_to=$_REQUEST['d_pp_to'];

$cgs_stone1=$_REQUEST['cgs_stone'];
foreach($cgs_stone1 as $val){
$end=end($cgs_stone1);
$cgs_stone.=$val;
if($end!=$val){$cgs_stone.=",";}
}
$cgs_shade=$_REQUEST['cgs_shade'];
$cgs_shape=$_REQUEST['cgs_shape'];
$cgs_quantity=$_REQUEST['cgs_quantity'];
$cgs_pp_from=$_REQUEST['cgs_pp_from'];
$cgs_pp_to=$_REQUEST['cgs_pp_to'];

$ip_address=$_SERVER['REMOTE_ADDR'];

if(in_array("loose diamonds", $pd_jewellery1))
{
if(count($d_size1)==0){$_SESSION['upload_error'].="diamond size is required.<br/>";header('location:obmp_profile.php');} 
if(count($d_clarity)==0){$_SESSION['upload_error'].="diamond clarity is required.<br/>";header('location:obmp_profile.php');}
if(count($d_color_shade)==0){$_SESSION['upload_error'].="diamond color/shade is require.";header('location:obmp_profile.php');}
}
if(in_array("coloured gemstones", $pd_jewellery1))
{
if(count($cgs_stone1)==0) {$_SESSION['upload_error']="Name of the stone is required.";header('location:obmp_profile.php');exit;}
}
$dt=date('Y-m-d');
/*...........................Check if already there...............................*/
$query=$conn->query("select * from member_directory where registration_id='$registration_id'");
$num=$query->num_rows;;
if($num>0)
{
	$product_logo = '';
	$target_folder = 'product_logo/';
	$temp_code = rand();
	if($_FILES['product_logo']['name'] != '')
	{  
		if (($_FILES["product_logo"]["type"] == "image/jpg") || ($_FILES["product_logo"]["type"] == "image/jpeg") || ($_FILES["product_logo"]["type"] == "image/png"))
		{
			$target_path = $target_folder.$temp_code.'_'.$_FILES['product_logo']['name'];
			if(@move_uploaded_file($_FILES['product_logo']['tmp_name'], $target_path))
			{
				$product_logo = $temp_code.'_'.$_FILES['product_logo']['name'];
				$sql="update member_directory set product_logo='$product_logo' where registration_id='$registration_id'";
				$result=$conn->query($sql);
			}
			else
			{
				$_SESSION['upload_error']="Sorry product image could not be upload";
				header('location:obmp_profile.php');
				exit;
			}
		}
		else
		 {
			$_SESSION['upload_error']="Sorry you have select Invalid file for product logo";
			header('location:obmp_profile.php');
			exit;
		 }	
	}

	$company_logo = '';
	$target_folder = 'company_logo/';
	$temp_code = rand();
	if($_FILES['company_logo']['name'] != '')
	{  
		if (($_FILES["company_logo"]["type"] == "image/jpg") || ($_FILES["company_logo"]["type"] == "image/jpeg") || ($_FILES["company_logo"]["type"] == "image/png"))
		{
			$target_path = $target_folder.$temp_code.'_'.$_FILES['company_logo']['name'];
			if(@move_uploaded_file($_FILES['company_logo']['tmp_name'], $target_path))
			{
				$company_logo = $temp_code.'_'.$_FILES['company_logo']['name'];
				$sql="update member_directory set company_logo='$company_logo' where registration_id='$registration_id'";
				$result=$conn->query($sql);
			}
			else
			{
				$_SESSION['upload_error']="Sorry comapny image could not be upload";
				header('location:obmp_profile.php');
				exit;
			}
		}
		else
		 {
			$_SESSION['upload_error']="Sorry you have select Invalid file for company logo";
			header('location:obmp_profile.php');
			exit;
		 }	
	}


$update = $conn->query("update member_directory set registration_id='$registration_id',buy_sell_profile_code='$buy_sell_profile_code',obmp_profile_code='$obmp_profile_code',company_name='$company_name',contact_person='$contact_person',designation='$designation',website='$website',write_up='$write_up',wa_jewellery='$wa_jewellery',pd_jewellery='$pd_jewellery',item_description='$item_description',d_size='$d_size',d_clarity='$d_clarity',d_color_shade='$d_color_shade',d_pp_from='$d_pp_from',d_pp_to='$d_pp_to',cgs_stone='$cgs_stone',cgs_shade='$cgs_shade',cgs_shape='$cgs_shape',cgs_quantity='$cgs_quantity',cgs_pp_from='$cgs_pp_from',cgs_pp_to='$cgs_pp_to',ip_address='$ip_address' where registration_id='$registration_id'");

$_SESSION['msg']="Member directory updated successfully";
header('location:obmp_profile.php');
}
else
{
	$product_logo = '';
	$target_folder = 'product_logo/';
	$temp_code = rand();
	if($_FILES['product_logo']['name'] != '')
	{  
		if (($_FILES["product_logo"]["type"] == "image/gif") || ($_FILES["product_logo"]["type"] == "image/jpeg") || ($_FILES["product_logo"]["type"] == "image/png"))
		{
			$target_path = $target_folder.$temp_code.'_'.$_FILES['product_logo']['name'];
			if(@move_uploaded_file($_FILES['product_logo']['tmp_name'], $target_path))
			{
				$product_logo = $temp_code.'_'.$_FILES['product_logo']['name'];
			}
			else
			{
				$_SESSION['upload_error']="Sorry image could not be upload";
				header('location:obmp_profile.php');
			    exit;
			}
		}
		else
		 {
			$_SESSION['upload_error']="Sorry you have select Invalid file";
			header('location:obmp_profile.php');
			exit;
		 }	
	}
	
	$company_logo = '';
	$target_folder = 'company_logo/';
	$temp_code = rand();
	if($_FILES['company_logo']['name'] != '')
	{  
		if (($_FILES["company_logo"]["type"] == "image/gif") || ($_FILES["company_logo"]["type"] == "image/jpeg") || ($_FILES["company_logo"]["type"] == "image/png"))
		{
			$target_path = $target_folder.$temp_code.'_'.$_FILES['company_logo']['name'];
			if(@move_uploaded_file($_FILES['company_logo']['tmp_name'], $target_path))
			{
				$company_logo = $temp_code.'_'.$_FILES['company_logo']['name'];
			}
			else
			{
				$_SESSION['upload_error']="Sorry image could not be upload";
				header('location:obmp_profile.php');
			    exit;
			}
		}
		else
		 {
			$_SESSION['upload_error']="Sorry you have select Invalid file";
			header('location:obmp_profile.php');
			exit;
		 }	  
	}

$insert = $conn->query("insert into member_directory set registration_id='$registration_id', 	buy_sell_profile_code='$buy_sell_profile_code',obmp_profile_code='$obmp_profile_code',company_name='$company_name',contact_person='$contact_person',designation='$designation',website='$website',write_up='$write_up',wa_jewellery='$wa_jewellery',pd_jewellery='$pd_jewellery',item_description='$item_description',d_size='$d_size',d_clarity='$d_clarity',d_color_shade='$d_color_shade',d_pp_from='$d_pp_from',d_pp_to='$d_pp_to',cgs_stone='$cgs_stone',cgs_shade='$cgs_shade',cgs_shape='$cgs_shape',cgs_quantity='$cgs_quantity',cgs_pp_from='$cgs_pp_from',cgs_pp_to='$cgs_pp_to',product_logo='$product_logo',company_logo='$company_logo',status=1,ip_address='$ip_address',post_date='$dt'");

$_SESSION['msg']="Member directory save successfully";
header('location:obmp_profile.php');
}
?>
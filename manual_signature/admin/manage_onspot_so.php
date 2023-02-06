<?php session_start(); ?>
<?php include('../db.inc.php');?>
<?php include('../functions.php');?>
<?php
if($_REQUEST['Reset']=="Reset")
{
  	$action="";
	$_SESSION['Exhibitor_Name']="";
	 
  header("Location: manage_onspot_so.php?action=view");
}
else if($_REQUEST['action']=="search")
{ 
  	$_SESSION['Exhibitor_Name']=$_REQUEST['Exhibitor_Name'];
}
?>  

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title> Manual || Manage OnSpot SALES Order</title>
<link rel="stylesheet" type="text/css" href="css/style.css" />

<!--navigation-->
<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>      
<link rel="stylesheet" type="text/css" href="css/ddsmoothmenu.css" />
<script type="text/javascript" src="js/ddsmoothmenu.js"></script>

<script type="text/javascript">
ddsmoothmenu.init({
	mainmenuid: "smoothmenu1", //menu DIV id
	orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"
	classname: 'ddsmoothmenu', //class added to menu's outer DIV
	//customtheme: ["#1c5a80", "#18374a"],
	contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
})
</script>
<!--navigation end-->
</head>

<body>
<div id="header_wrapper"><?php include("include/header.php");?></div>

<div id="nav_wrapper">
	<div class="nav"><?php include("include/menu.php");?></div>
</div>

<div class="clear"></div>

<div class="breadcome_wrap">
	<div class="breadcome"><a href="search_application.php">Home</a> > Manage OnSpot Sales Order</div>
</div>

<div id="main">
	<div class="content">
    	<div class="content_head"><div class="content_head_button">Manage OnSpot Sales Order</div></div>

<div class="content_details1">
<form name="search" action="" method="post" > 
<input type="hidden" name="action" value="search" />        	
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt" >
<tr class="orange1">
    <td colspan="11" >Search Options</td>
</tr>   
<tr>
    <td width="19%" ><strong>Search</strong></td>
    <td width="81%"><label>
      <input type="text" name="Exhibitor_Name" id="Exhibitor_Name" value="<?php echo $_SESSION['Exhibitor_Name']; ?>" />
    </label></td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td><input type="submit" name="Search" value="Search"  class="input_submit" />  <input type="submit" name="Reset" value="Reset"  class="input_submit" /></td>
</tr>	
</table>
</form>      
</div>

<div class="content_details1">
<form name="form1" action="" method="post" > 

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  <tr class="orange1">
    <td>EXH</td>
    <td>FORM ID</td>
    <td>Exhibitor Name</td>
    <td>OrderID</td>
    <td>Billing BP No</td>
    <td>Payment <br />
    Approved Date</td>
    <td>SO No</td>
	<td>API Used</td>
    <td>Action</td>
  </tr>
    <?php  
	$page=1;//Default page
	$limit=20;//Records per page
	$start=0;//starts displaying records from 0
	if(isset($_GET['page']) && $_GET['page']!=''){
	$page=$_GET['page'];
	}
	$start=($page-1)*$limit;
   
	//if($_SESSION['admin_role']=='Super Admin')	{
		$sql="SELECT a.*,b.Exhibitor_Name,b.billing_bp_no,b.Exhibitor_Country_ID FROM `iijs_payment_master` a,iijs_exhibitor b WHERE (a.`Form_ID`='3' || a.`Form_ID`='7') AND a.Payment_Master_Amount>'0' and (a.txn_status is null or a.txn_status!=300) AND a.Payment_Master_Approved='Y'";		
	//}
	
	if($_SESSION['Exhibitor_Name']!="")
	{
	$sql.=" and b.Exhibitor_Name like '%".$_SESSION['Exhibitor_Name']."%'";
	}
	
	$sql.=" and a.Exhibitor_Code=b.Exhibitor_Code order by b.`Exhibitor_Code` ";
	//echo $sql;
	$result=$conn ->query($sql);
	$rCount=$result->num_rows;	
	$sql1=$sql." limit $start, $limit"; 
	$result1=$conn ->query($sql1);
  	if($rCount>0)
  	{	
  		while($rows=$result1->fetch_assoc())
  		{
  ?>
   <tr>
    <td><?php echo $rows['Exhibitor_Code']; ?></td>
    <td><?php echo $rows['Form_ID']; ?></td>
    <td><?php echo getExhibitorName($rows['Exhibitor_Code'],$conn); ?></td>
    <td><?php echo $rows['Payment_Master_OrderNo']; ?></td>
    <td><?php echo $rows['billing_bp_no']; ?></td>
    <td><?php echo date("d-m-Y",strtotime($rows['Create_Date']));?></td>
    <td><?php echo $rows['sales_order_no'];?></td>
	<td><?php echo strtoupper($rows['api_used']);?></td>
	<!--..................... Sales Order Create API ------------>
	<?php $gotcountry = $rows['Exhibitor_Country_ID'];
	if($gotcountry == 'IN'){ ?>
    <?php if($rows['sap_sale_order_create_status'] == 0) { ?>
	<td class="so" data-url="<?php echo $rows['Form_ID'];?> <?php echo $rows['Exhibitor_Code'];?> <?php echo $rows['Payment_Master_OrderNo'];?>">CREATE SO</td>
    <?php } else { ?>
    <td><a onclick="return(window.confirm('Sales Order Already Created'));"><img src="images/active.png"/></a></td>
    <?php } ?>
    <?php } ?>
	<!--..................... End Sales Order Create API------------>
  </tr>
  
  <?php
   $i++;
   }
}
   else
   {
   ?>
   <tr>
     <td colspan="8">Records Not Found</td>
   </tr>
   <tr>
     <td colspan="5">&nbsp;</td>
     <td colspan="3"></td>
   </tr>
   <?php  } ?>  
</table>

</form>
</div>  
<?php
function pagination($per_page = 10, $page = 1, $url = '', $total){ 

$adjacents = "2";

$page = ($page == 0 ? 1 : $page); 
$start = ($page - 1) * $per_page; 

$prev = $page - 1; 
$next = $page + 1;
$lastpage = ceil($total/$per_page);
$lpm1 = $lastpage - 1;

$pagination = "";
if($lastpage > 1)
{ 
$pagination .= "<ul class='pagination'>";
$pagination .= "<li class='details'>Page $page of $lastpage</li>";
if ($lastpage < 7 + ($adjacents * 2))
{ 
for ($counter = 1; $counter <= $lastpage; $counter++)
{
if ($counter == $page)
$pagination.= "<li><a class='current'>$counter</a></li>";
else
$pagination.= "<li><a href='{$url}$counter'>$counter</a></li>"; 
}
}
elseif($lastpage > 5 + ($adjacents * 2))
{
if($page < 1 + ($adjacents * 2)) 
{
for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
{
if ($counter == $page)
$pagination.= "<li><a class='current'>$counter</a></li>";
else
$pagination.= "<li><a href='{$url}$counter'>$counter</a></li>"; 
}
$pagination.= "<li class='dot'>...</li>";
$pagination.= "<li><a href='{$url}$lpm1'>$lpm1</a></li>";
$pagination.= "<li><a href='{$url}$lastpage'>$lastpage</a></li>"; 
}
elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
{
$pagination.= "<li><a href='{$url}1'>1</a></li>";
$pagination.= "<li><a href='{$url}2'>2</a></li>";
$pagination.= "<li class='dot'>...</li>";
for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
{
if ($counter == $page)
$pagination.= "<li><a class='current'>$counter</a></li>";
else
$pagination.= "<li><a href='{$url}$counter'>$counter</a></li>"; 
}
$pagination.= "<li class='dot'>..</li>";
$pagination.= "<li><a href='{$url}$lpm1'>$lpm1</a></li>";
$pagination.= "<li><a href='{$url}$lastpage'>$lastpage</a></li>"; 
}
else
{
$pagination.= "<li><a href='{$url}1'>1</a></li>";
$pagination.= "<li><a href='{$url}2'>2</a></li>";
$pagination.= "<li class='dot'>..</li>";
for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
{
if ($counter == $page)
$pagination.= "<li><a class='current'>$counter</a></li>";
else
$pagination.= "<li><a href='{$url}$counter'>$counter</a></li>"; 
}
}
}

if ($page < $counter - 1){
$pagination.= "<li><a href='{$url}$next'>Next</a></li>";
// $pagination.= "<li><a href='{$url}$lastpage'>Last</a></li>";
}else{
//$pagination.= "<li><a class='current'>Next</a></li>";
// $pagination.= "<li><a class='current'>Last</a></li>";
}
$pagination.= "</ul>\n"; 
} 
return $pagination;
} 

?>	
<div class="pages_1">Total number of order: <?php echo $rCount;?><?php echo pagination($limit,$page,'manage_onspot_so.php?action=view&page=',$rCount); //call function to show pagination?></div>        
</div>
</div>

<div id="footer_wrap"><?php include("include/footer.php");?></div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">
/* SO Creation */
$(".so").click(function() {
	var values = $(this).data('url').split(" ");
	var Form_ID = values[0];
	var Exhibitor_Code = values[1];
	var order_id = values[2];
	
	//alert(Form_ID);
	if(Form_ID=='3'){ var ajaxurl  = 'sap_onspot_standfitting_api.php'; msg = 'Are you sure you want to onspot Create Standfitting Sales order'; }
	if(Form_ID=='4'){ var ajaxurl  = 'sap_onspot_badges_api.php';       msg = 'Are you sure you want to onspot Create Badges Sales order'; }
	if(Form_ID=='7'){ var ajaxurl  = 'sap_onspot_wifi_api.php';         msg = 'Are you sure you want to onspot Create Wifi Sales order'; }
		//alert(ajaxurl);
	
	if (confirm(msg)) {
		$.ajax({
		url: ajaxurl,
		method:"POST",
		data:{Form_ID:Form_ID,Exhibitor_Code:Exhibitor_Code,order_id:order_id},
		type: "POST",
		beforeSend: function() {
        	$("#overlay").show();
    	},
		success:function(data)
		{
			//console.log(data); exit;
			if($.trim(data)==1){
				alert("Sales Order successfully Created..");
				window.location.reload(true);
			}else{
				alert("Sorry There is some problem with SAP response");
				window.location.reload(true);			
			}
			console.log(data);
		},
		});
	}	  
});
</script>
<div id="overlay"></div>
<style>
#overlay {
    position: fixed;
    display: none; 
    width: 100%; 
    height: 100%; 
    top: 0; 
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0,0,0,0.8);
z-index:999;}  	
</style>

<style>
.modal {
    display: none; 
    position: fixed; 
    z-index: 1; 
    padding-top: 100px; 
    left: 0;
    top: 0;
    width: 100%; 
    height: 100%; 
    overflow: auto; 
    background-color: rgb(0,0,0); 
    background-color: rgba(0,0,0,0.4);    
}
@keyframes modalFade {
  from {transform: translateY(-50%);opacity: 0;}
  to {transform: translateY(0);opacity: 1;}
}

.modal-content {
    background-color: #fefefe;
    margin: auto;
    padding: 20px;
    border: 1px solid #888;
    width: 50%;
     animation-name: modalFade;
  animation-duration: .6s;
}
.modal_inner_content{margin: 20px 10px;}

.close {
    color: #aaaaaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
}
.form-horizontal{border: 1px solid #ccc;padding: 25px;margin-top: 10px;}
.form-control{width: 100%;margin-bottom: 15px;}
.form-control label{width: 150px;display: inline-block;}
.form-control input{width: auto;}
</style>
</body>
</html>
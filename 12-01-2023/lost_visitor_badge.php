<?php
include('header_include.php');
if(!isset($_SESSION['USERID'])){	header("location:login.php");	exit;	}
$encrypted_id = $_GET['visitor_id'];
$visitorId = base64_decode($encrypted_id);
$member_type = $_SESSION['member_type'];
if($member_type == "MEMBER"){ $type_of_member="M";  } else { $type_of_member="NM"; }
?>
<?php
$sqlBadgeEmp = "select * from visitor_order_history where visitor_id='$visitorId' and payment_status='Y' and year='2019' and (payment_made_for='3show' OR payment_made_for='6show') AND `show`='iijs' limit 1";
$resultBadgeEmp = mysql_query($sqlBadgeEmp);
$empBadgeCount = mysql_num_rows($resultBadgeEmp);
if($empBadgeCount == 0){
header("location:employee_directory.php"); exit;
}

$registration_id=$_SESSION['USERID'];
$company_pan_no = getCompanyPan($registration_id);
$sql = "select * from exh_reg_payment_details where uid='$registration_id' AND `year`='2019' AND allow_visitor='N' order by payment_id desc limit 0,1";
$ans = mysql_query($sql);
$nans=mysql_num_rows($ans);
if($nans>0){
	echo "<script>alert('You are Exhibitor'); window.location = 'my_dashboard.php';</script>";
}

if($_POST['action']=="lostBadgePayment" && $visitorId !="")
{

  /*----------------Get Visitor Data from last order and visitor directory--------*/
$lastVisitor = "SELECT v.visitor_id,v.bp_number, v.gender,v.degn_type, v.name, v.lname ,v.mobile,v.email,v.pan_no,v.photo,v.designation,u.delivery_id,u.billing_delivery_id FROM visitor_directory v  JOIN visitor_order_detail u ON u.regId=v.registration_id  WHERE v.visitor_id ='$visitorId' AND u.payment_status='Y' LIMIT 1";
  $lastVisitorResult =  mysql_query($lastVisitor);
  $rowlastVisitor = mysql_fetch_assoc($lastVisitorResult);
  $bp_number = $rowlastVisitor['bp_number']; 
  $degn_type = $rowlastVisitor['degn_type']; 
  $designation = $rowlastVisitor['designation']; 
  $name = $rowlastVisitor['name']; 
  $show = filter($_POST['show']); 
  $lname = $rowlastVisitor['lname']; 
  $gender = $rowlastVisitor['gender']; 
  $mobile = $rowlastVisitor['mobile']; 
  $email = $rowlastVisitor['email']; 
  $pan_no = $rowlastVisitor['pan_no']; 
  $photo = $rowlastVisitor['photo']; 
  $billing_delivery_id = $rowlastVisitor['billing_delivery_id']; 
  $delivery_id = $rowlastVisitor['delivery_id']; 
  $post_date = date('Y-m-d');
  $amount= "600";
  $year = '2020';
  $event = "signature";
  /*----------------------------Create Order Id Start---------------------------*/
  $resultOrder=mysql_query("select * from visitor_lost_badges order by id desc limit 1");
  $rowOrder=mysql_fetch_assoc($resultOrder);
   $numOrder = mysql_num_rows($resultOrder);
   $strNo = rand(1,1000000);
	if($numOrder<=0)
	{ $orderId = 'LOST20'; }
	else
	{
	  $orderId='LOST20'.$strNo;
	}

  /*----------------------------Create Order Id End---------------------------*/
$_SESSION['orderId']=$orderId;
$_SESSION['visitor_id']=$visitorId;

/*-------- check previous incomplete order in visitor_lost_badges table Start---------*/

$checkOrder ="SELECT * FROM visitor_lost_badges WHERE regId = '$registration_id' AND visitor_id='$visitorId' AND payment_status!='Y'";
$checkOrderResult = mysql_query($checkOrder);
$checkOrderCount = mysql_num_rows($checkOrderResult);
/*-------- check previous incomplete order in visitor_lost_badges table End--------- */
if($checkOrderCount>0){
$UpdateData =  "UPDATE `visitor_lost_badges` SET `modified_date`='$post_date', `regId`='$registration_id',`company_pan_no`='$company_pan_no',`orderId`='$orderId', `name`='$name', `lname`='$lname',`gender`='$gender',`mobile`='$mobile', `email`='$email', `pan_no`='$pan_no',`photo`='$photo',`payment_status`='P',type_of_member='$type_of_member',`total_payable`='$amount',billing_delivery_id='$billing_delivery_id',delivery_id='$delivery_id', bp_number='$bp_number',degn_type='$degn_type',`event`='$event',`show`='$show',`year`='$year',`designation`='$designation' WHERE regId = '$registration_id' AND visitor_id='$visitorId' AND payment_status!='Y' ";
$result = mysql_query($UpdateData);
} else {
$insertData =  "INSERT INTO `visitor_lost_badges`(`create_date`, `regId`,`company_pan_no`,`visitor_id`,`orderId`, `name`, `lname`,`gender`,`mobile`, `email`, `pan_no`,`photo`,`payment_status`,type_of_member,`total_payable`,`billing_delivery_id`,`delivery_id`,`bp_number`,`degn_type`,`event`,`show`,`year`,`designation`) VALUES ('$post_date','$registration_id','$company_pan_no','$visitorId','$orderId','$name','$lname','$gender','$mobile','$email','$pan_no','$photo','P','$type_of_member','$amount','$billing_delivery_id','$delivery_id','$bp_number','$degn_type','$event','$show','$year','$designation')";
$result = mysql_query($insertData);
}

if($result){
header("location:ebs/lost_badge_techprocess.php");exit;	
} else {
header("location:employee_directory.php"); exit;
}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<title>Lost badge</title>
<link rel="icon" href="https://gjepc.org/images/favicon.ico" type="image/x-icon"/>
<link rel="stylesheet" type="text/css" href="css/mystyle.css" />
<link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Cabin'>
<link rel="stylesheet" type="text/css" href="css/general.css" />
<link rel="stylesheet" type="text/css" href="css/inner_pg_style.css" /> 
<link rel="stylesheet" type="text/css" href="css/responsive.css" />
<link rel="stylesheet" type="text/css" href="css/media_query.css" />
<script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>

<!--NAV-->
<link href="css/flexnav.css" media="screen, projection" rel="stylesheet" type="text/css">
<script src="js/jquery.flexnav.js" type="text/javascript"></script>
<script src="js/common.js"></script> 
<!--NAV-->

<!-- UItoTop plugin -->
<link rel="stylesheet" type="text/css" media="screen,projection" href="css/ui.totop.css" />
<script src="js/easing.js" type="text/javascript"></script>
<script src="js/jquery.ui.totop.js" type="text/javascript"></script>    
<script type="text/javascript">
    $(document).ready(function() {        
        $().UItoTop({ easingType: 'easeOutQuart' });        
    });
</script>

<style>
	.loader {
    position: fixed;
    left: 0px;
    top: 0px;
    width: 100%;
    height: 100%;
    z-index: 9999;
    background: url('images/progress.gif') 50% 50% no-repeat rgb(249,249,249);
    opacity: 80;
	}
	.body_text{height: 95px;margin-top: 20px;}
	ol li{list-style: disc;}
</style>
	
<script type="text/javascript">
	$(window).load(function() {
		$(".loader").fadeOut("slow");
	}); 
</script>
</head>

<body>

<div class="wrapper">
<div class="loader">  <div style="display:table; width:100%; height:100%;"><span style="display:table-cell; vertical-align:middle; text-align:center; padding-top:100px;">Please wait....</span></div></div>

<div class="header">
	<?php include('header1.php'); ?>
</div>
<div id="preloader">
    <div id="status"> <img src="images/loader.gif"></div>
</div>

<!--container starts-->
<div class="inner_container">
  <div class="container">
    <div class="container_leftn">
      <div class="breadcome"><a href="#">Home</a> ><a href="employee_directory.php">Employee Directory</a> >Visitor Lost Badge</div>
     
     <div class="clear"></div>
      <div><a href="employee_directory.php" class="btn_back">Back to Employee Directory</a></div>
          <div class="clear"></div>
    
		<?php  
		$statement = "SELECT * FROM visitor_order_history WHERE visitor_id = '$visitorId' and payment_status='Y' and year='2019' and `show`='iijs' and (payment_made_for='3show' || payment_made_for='6show')";
        $Query = mysql_query($statement);
        $row = mysql_fetch_assoc($Query);
        ?>
<div class="form_main">
    <p class="title">Lost badge details</p>
    <form class="cmxform" method="POST" name="from1" id="form1">  
    <div class="" style="width: 50%; float: left;">
        <div class="field_box">
            <div class="field_name" style="width:150px;">Visitor Name <span>*</span> :</div>
            <div class="field_input"><h4><?php echo getVisitorName($row['visitor_id']); ?></h4></div>
            <div class="clear"></div>
        </div>
        <div class="clear" style="height:10px;"></div>       
        <div class="field_box">
            <div class="field_name" style="width:150px;">Applied Show <span>*</span> :</div>
            <div class="field_input"><h4><?php echo $row['payment_made_for'];?></h4></div>
            <div class="clear"></div>
        </div>
        <div class="clear" style="height:10px;"></div>
    </div>     
    <div class="" style="width: 50%; float: right;">
    <div class="image_wrapper">
    <img src="images/employee_directory/<?php echo $registration_id;?>/photo/<?php echo getVisitorPhoto($row['visitor_id'])?>" class="image-resp">
    </div>
    </div>  

        <div class="field_box">
        <div class="field_name" style="width:150px;">Badge Fee <span>*</span> :</div>
        <div class="field_input"><h4>600/-</h4></div>
        <div class="clear"></div>
        </div>
		<p style="color: red;">Please Note : Visitor if you dont have Image. Please Upload image</p>
        <div class="clear" style="height:10px;"></div>        
        <div class="field_box">          
        <div class="field_input">
        <input type="hidden" name="action" value="lostBadgePayment"/>
        <input type="hidden" name="show" value="<?php echo $row['payment_made_for']; ?>">
        <input type="submit" class="button" value="Click Here to Pay" />
        </div>
        <div class="clear"></div>
        </div>
  </form>       
    </div>       
    <div class="clear"></div>        
    <div class="clear"></div>    
    </div>
    </div>
  </div>
<div class="clear"></div>

<!--container ends-->
<!--footer starts-->
<div class="footer_wrap">
  <?php include ('footer.php'); ?>
</div>
</div>
<!--footer ends-->
<style type="text/css">
  .btn_back{padding: 5px; background: #ccc;color: #000}

  .form_main{border:1px solid#ccc; margin: 0;padding: 20px 15px;}
  .field_input h4{margin-top: 8px}
  .form_main p{font-size: 16px;text-align:center; }
  .image-resp{max-width: 100%}
  .image_wrapper{width: 120px;height: auto;}
</style>
</body>
</html>
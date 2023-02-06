<?php include('header_include.php');
if(!isset($_SESSION['USERID'])){ header("location:login.php");	exit; }
$registration_id = $_SESSION['USERID'];


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Order History</title>
	<link rel="icon" href="https://gjepc.org/images/favicon.ico" type="image/x-icon"/>
	<link rel="stylesheet" type="text/css" href="css/mystyle.css" />
	<link rel='stylesheet' type='text/css' href='http://fonts.googleapis.com/css?family=Cabin'>
	<link rel="stylesheet" type="text/css" href="css/general.css" />
	<link rel="stylesheet" type="text/css" href="css/inner_pg_style.css" />
	 
	<link rel="stylesheet" type="text/css" href="css/responsive.css" />
	<link rel="stylesheet" type="text/css" href="css/media_query.css" />
	<link rel="stylesheet" type="text/css" href="css/visitor_v1.css" />
	<script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>

	<!--NAV-->
	<link href="css/flexnav.css" media="screen, projection" rel="stylesheet" type="text/css">
	<script src="js/jquery.flexnav.js" type="text/javascript"></script>
	<script src="js/common.js"></script> 
	<script type="text/javascript">
		$(document).ready(function(){
			$(document).on("click",".tab-title", function(){
				//e.stopPropagation();
				var checkActive  = $(this).siblings(".tab-content").hasClass("active");
				if(checkActive == true){
                 $(this).siblings(".tab-content").removeClass("active");
				}
				// $(this).siblings(".tab-content").slideToggle();
				 if ($('.tab-content').is(':visible')) {
			      $(".tab-content").slideUp(300);
			      $(this).children(".tab-img").attr('src','images/tab_accordian/right-arrow.png');
			    }
			    if ($(this).next(".tab-content").is(':visible')) {
			      $(this).next(".tab-content").slideUp(300);
			      $(this).children(".tab-img").attr('src','images/tab_accordian/right-arrow.png');
			      
			    } else {
			      $(this).next(".tab-content").slideDown(300);
			      $(this).children(".tab-img").attr('src','images/tab_accordian/down-arrow.png');
			      
			    }
			});

		});
	</script>
	<!--NAV-->    
  </head>
  <body>
    <div class="wrapper">
	<div class="header"><?php include('header1.php'); ?></div>
	<?php
	$getapplication ="SELECT * FROM `visitor_lost_badges` WHERE `regId` = '$registration_id' AND payment_status='Y' AND year='2020'";
	$getApplicationResult = $conn->query($getapplication);
	$countApplication = $getApplicationResult->num_rows; 
	//if($countApplication > 0){
	?>
	
    <!--container starts-->
    <div class="container_wrap">
      <div class="container">
        <div class="container_leftn">
          <div class="breadcome"><a href="#">Home</a> > Order History </div>
          
          <div id="loginForm">
            <div class="userName">
              <div class="clear"></div>
            </div>
            <div id="formContainer">             
              <div class="title" style="margin-top:0;"><h4>Order History <?php if($countApplication > 0){ ?>/ <a href="lost_order_history.php" target="_blank"><b>Click here for Lost badge</b></a><?php } ?></h4></div>
              <div class="clear"></div>
              <div class="borderBottom"></div>

              <div class="tab"><p class="tab-title">IIJS- PREMIERE 2019 <img src="images/tab_accordian/right-arrow.png" class="tab-img"></p>
              <div class="tab-content">
                <table style="margin-bottom:20px">                
                <thead>
				 <tr>
                    <th scope="col">Sr No.</th>
                    <th scope="col">Date </th>                    
                    <th scope="col">Name </th>                    
                    <th scope="col">Show </th>  
                  </tr>
                </thead>
				<tbody>
				<?php
				$getiijs2019 ="SELECT * FROM visitor_order_history where registration_id = '$registration_id' AND payment_status='Y' AND year='2019' AND `show`='iijs'"; 
				$getiijs2019Result = $conn->query($getiijs2019);
				$getiijs2019Count = $getiijs2019Result->num_rows; 
				if($getiijs2019Count > 0){
				$i=1;
				while($getiijs2019Row=$getiijs2019Result->fetch_assoc)
				{
					$createDate = date('d-m-Y', strtotime($getiijs2019Row['create_date']));
				?>           
                
                  <tr>
                    <td data-label="Sr No."><?php echo $i;?></td>                    
                    <td data-label="Date"><?php echo $createDate;?></td>
                    <td data-label="Visitor Name"><?php echo strtoupper(getVisitorFullName($getiijs2019Row['visitor_id'],$conn));?></td> 					
                    <td data-label="Show"><?php echo strtoupper($getiijs2019Row['show']);?></td> 					
                  </tr>
				  <?php $i++; } } else { ?> 
					<tr>
                    <td colspan='4'>No Order Found</td>
					</tr>
				<?php } ?>
                </tbody>
              </table>          
              </div>
              </div>
              <div class="tab"><p class="tab-title">IIJS - SIGNATURE 2020<img src="images/tab_accordian/right-arrow.png" class="tab-img"></p>
              <div class="tab-content">
                          <table style="margin-bottom:20px">                
                <thead>
				 <tr>
                     <th scope="col">Sr No.</th>
                    <th scope="col">Date </th>                    
                    <th scope="col">Name </th>                    
                    <th scope="col">Show </th>  
                  </tr>
                </thead>
				<tbody>
				<?php 
				$getSignature2020="SELECT * FROM visitor_order_history where registration_id = '$registration_id' AND year='2020' AND `show`='signature'";
				$getSignature2020Result = $conn->query($getSignature2020);
				$getSignature2020Count = $getSignature2020Result->num_rows; 
				if($getSignature2020Count > 0){
				$i=1;
				while($getSignature2020Row=$getSignature2020Result->fetch_assoc())
				{
					$createDate = date('d-m-Y', strtotime($getSignature2020Row['create_date']));
				?>           
                
                  <tr>
                    <td data-label="Sr. No"><?php echo $i;?></td>                    
                    <td data-label="Date"><?php echo $createDate;?></td>
                    <td data-label="Visitor Name"><?php echo strtoupper(getVisitorFullName($getSignature2020Row['visitor_id']),$conn);?></td> 					
                    <td data-label="Show"><?php echo strtoupper($getSignature2020Row['show']);?></td> 					
                  </tr>
				  <?php $i++; } } else { ?> 
					<tr>
                    <td colspan='4'>No Order Found</td>
					</tr>
				<?php } ?>
                </tbody>
              </table>
              </div>
              </div>
              <div class="tab"><p class="tab-title">IIJS - PREMIERE 2020 <img src="images/tab_accordian/right-arrow.png" class="tab-img"></p>
              <div class="tab-content active">
                           <table style="margin-bottom:20px">                
                <thead>
				 <tr>
                    <th scope="col">Sr No.</th>
                    <th scope="col">Date </th>                    
                    <th scope="col">Payment Status </th>                 
                    <th scope="col">View </th>    
					<th scope="col">Badge Status</th>
                  </tr>
                </thead>
				<tbody>
				<?php 
				$getIijs2020 ="SELECT * FROM `visitor_order_detail` WHERE `regId` = '$registration_id' AND payment_status='Y' AND year='2020' AND event='iijs'";
			//	$getapplication ="SELECT a.*,b.* FROM `visitor_order_detail` a, visitor_order_history b where a.`orderId`=b.`orderId` AND b.show='signature' AND b.year='2020' AND a.regId = '$registration_id' AND b.payment_status='Y'";
				$getIijs2020Result = $conn->query($getIijs2020);
				$getIijs2020Count = $getIijs2020Result->num_rows; 
				if($getIijs2020Count > 0){
				$i=1;
				while($getIijs2020Row=$getIijs2020Result->fetch_assoc())
				{
					$id = $getIijs2020Row['id'];
					$orderId = $getIijs2020Row['orderId'];
					$createDate = date('d-m-Y', strtotime($getIijs2020Row['create_date']));
					$payment_status = $getIijs2020Row['payment_status'];
					if($payment_status=="P") { $payment_status="Pending"; }
					if($payment_status=="Y") { $payment_status="Approved"; }
				?>           
                
                  <tr>
                    <td data-label="Sr.No"><?php echo $i;?></td>                    
                    <td data-label="Date"><?php echo $createDate;?></td>
                    <td data-label=" Payment Status"><?php echo $payment_status;?></td>
                    <td data-label="View Details"><?php if($getIijs2020Row['payment_status']=="Y"){?><a href="print_acknowledgement.php?orderid=<?php echo $orderId;?>" target="_blank">VIEW</a>
					<?php } else { ?><a href="#">VIEW</a> <?php } ?></td>
					<td data-label="Badge Status"><a href="check_badge_status.php?orderid=<?php echo $orderId;?>">Check Badge Status</a></td>
                  </tr>
				  <?php $i++; } } else { ?> 
					<tr>
                    <td colspan='5'>No Order Found</td>
					</tr>
				<?php } ?>
                </tbody>
              </table>
              </div>
              </div>
                 
            </div>
          </div>
        </div>
      </div>      
    </div>
  </div>
<!--container ends-->
<!--footer starts-->
<div class="footer_wrap">
<?php include ('footer.php'); ?>
</div>
<!--footer ends-->
<style type="text/css">
	.tab{margin-bottom: 5px}
	.tab-title{padding: 10px 15px;background: #aba8a8;position: relative; border-radius: 5px;font-size: 16px;color: #fff;font-weight: 500px;cursor: pointer;}
	.tab-img{position: absolute;right: 10px; cursor: pointer;}
	.tab-content{display: none;}
	.active{display: block!important;}
	table{border:1px solid#ccc;}
	table th {
    color: #fff;
    background: #aa9e5f;
}
</style>

</body>
</html>
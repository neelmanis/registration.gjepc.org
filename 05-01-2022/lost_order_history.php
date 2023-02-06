<?php include('header_include.php');
if(!isset($_SESSION['USERID'])){ header("location:login.php");	exit; }
$registration_id = $_SESSION['USERID'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Lost Order History</title>
	<link rel="icon" href="https://gjepc.org/images/favicon.ico" type="image/x-icon"/>
	<link rel="stylesheet" type="text/css" href="css/mystyle.css" />
	<link rel='stylesheet' type='text/css' href='http://fonts.googleapis.com/css?family=Cabin'>
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
  </head>
  <body>
    <div class="wrapper">
	<div class="header"><?php include('header1.php'); ?></div>
	
    <!--container starts-->
    <div class="container_wrap">
      <div class="container">
        <div class="container_leftn">
          <div class="breadcome"><a href="#">Home</a> > Lost Order History </div>
          
          <div id="loginForm">
            <div class="userName">
              <div class="clear"></div>
            </div>
            <div id="formContainer">             
              <div class="title" style="margin-top:0;"><h4>Lost Order History </h4></div>
              <div class="clear"></div>
              <div class="borderBottom"></div>
              <table style="margin-bottom:20px">                
                <thead>
				 <tr>
                    <th scope="col">Sr No.</th>
                    <th scope="col">Date </th>                    
                    <th scope="col">Payment Status </th>                 
                    <th scope="col">View </th>    
					<th scope="col"></th>
                  </tr>
                </thead>
				<tbody>
				<?php 
				$getapplication ="SELECT * FROM `visitor_lost_badges` WHERE `regId` = '$registration_id' AND payment_status='Y' AND year='2020'";
				$getApplicationResult = mysql_query($getapplication);
				$countApplication = mysql_num_rows($getApplicationResult); 
				if($countApplication > 0){
				$i=1;
				while($getApplicationRow=mysql_fetch_array($getApplicationResult))
				{
					$id = $getApplicationRow['id'];
					$orderId = $getApplicationRow['orderId'];
					$createDate = date('d-m-Y', strtotime($getApplicationRow['create_date']));
					$payment_status = $getApplicationRow['payment_status'];
					if($payment_status=="P") { $payment_status="Pending"; }
					if($payment_status=="Y") { $payment_status="Approved"; }
				?>           
                
                  <tr>
                    <td data-label="Pattern Name"><?php echo $i;?></td>                    
                    <td data-label="SIZE"><?php echo $createDate;?></td>
                    <td data-label="Star Rating"><?php echo $payment_status;?></td>
                    <td data-label="Star Rating"><?php if($getApplicationRow['payment_status']=="Y"){?><a href="lost_print_acknowledgement.php?orderid=<?php echo $orderId;?>" target="_blank">VIEW</a>
					<?php } else { ?><a href="#">VIEW</a> <?php } ?></td>
					<td data-label="SIZE"><!--<a href="check_badge_status.php?orderid=<?php echo $orderId;?>">Check Badge Status</a>--></td>
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
.submitbtn {
background: #e2e2e2;
border: none;
padding: 7px 15px;
margin-top: 15px;
}
#form .textField{width: 138px;padding: 3px;}
#form .textField2{width: 215px;padding: 3px;}
#form .field {
background: #f6f6f6;
padding: 10px 20px 3px 20px;
margin-bottom: 10px;
float: left;
}
.button2 {
margin: 20px 10px 20px 0px;
background: #751c54;
padding: 7px 12px;
font-size: 12px;
margin-left: 13px;
border-radius: 5px;
color: #fff;}
.button1 {
float: left;
margin: 20px 10px 20px 0px;
background: #751c54;
padding: 5px 15px;
border-radius: 15px;
color: #fff;}
select{padding: 5px 0px; }
#form label {
min-width: 120px;
display: block;
float: left;
/* font-weight: bold; */
font-size: 11px;
vertical-align: middle;
padding-top: 2px;
color: #751c54;
}
table {
/*  border: 1px solid #ccc;
*/  border-collapse: separate;
margin: 0;
padding: 0;
width: 100%;
table-layout: fixed;
}
table caption {
font-size: 1.5em;
margin: .5em 0 .75em;
text-align: left;
text-transform: uppercase;
color: #000;
}
table tr {
background: #f8f8f8;
border: 1px solid #ddd;
padding: .35em;
}
table th,
table td {
padding: .625em;
text-align: left;
padding:5px 10px;
}
table th {
font-size: .85em;
letter-spacing: .1em;
text-transform: uppercase;
color: #000;
background: #ccc;
}
@media screen and (max-width: 600px) {
table {
border: 0;
}
table caption {
font-size: 1.3em;
}
table thead {
border: none;
clip: rect(0 0 0 0);
height: 1px;
margin: -1px;
overflow: hidden;
padding: 0;
position: absolute;
width: 1px;
}
table tr {
border-bottom: 3px solid #ddd;
display: block;
margin-bottom: .625em;
}
table td {
border-bottom: 1px solid #ddd;
display: block;
font-size: .8em;
text-align: right;
}
table td:before {
/*
* aria-label has no advantage, it won't be read inside a table
content: attr(aria-label);
*/
content: attr(data-label);
float: left;
font-weight: bold;
text-transform: uppercase;
}
table td:last-child {
border-bottom: 0;
}
}
.margin_t{margin-top:30px;}
</style>
</body>
</html>
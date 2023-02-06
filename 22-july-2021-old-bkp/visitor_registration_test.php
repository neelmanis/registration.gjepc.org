<?php include('header_include.php');
//echo "<script>alert('Registration Closed'); window.location = 'my_dashboard.php';</script>";
if(!isset($_SESSION['USERID'])){ header("location:login.php");	exit; }
$registration_id = $_SESSION['USERID'];
$show ="iijs";
$year = 2020;
$member_type = $_SESSION['member_type'];
?>

<?php
//include('ebs/statusapi/techprocess.php');

$sql = "select obmp_application_status from visitor_obmp_details where uid='$registration_id' and participate_for_show='$show' and year='$year' LIMIT 1";
$ans = mysql_query($sql);
$nans=mysql_num_rows($ans);
if($nans==0){
	echo "<script>alert('Plz Fill OBMP Details'); window.location = 'member_obmp_profile.php';</script>";
} ?>

<?php
$sqlxx = "select pan_no_copy,gst_copy from registration_master where id = '$registration_id' AND pan_no_copy!='' AND gst_copy!=''";
$xx = mysql_query($sqlxx);
$numbers = mysql_num_rows($xx);
if($numbers==0){
	echo "<script type='text/javascript'> alert('Please Upload GST AND PAN');
		window.location.href='employee_directory.php';
		</script>";
		return;	exit;
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Visitor Registration</title>
	<link rel="icon" href="https://gjepc.org/images/favicon.ico" type="image/x-icon"/>
	<link rel="stylesheet" type="text/css" href="css/mystyle.css" />
	<link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Cabin'>
	<link rel="stylesheet" type="text/css" href="css/general.css" />
	<link rel="stylesheet" type="text/css" href="css/inner_pg_style.css" />
	<link rel="stylesheet" type="text/css" href="css/responsive.css" />
	<link rel="stylesheet" type="text/css" href="css/media_query.css" />
	<link rel="stylesheet" type="text/css" href="css/fastselect.min.css"/>
	<link rel="stylesheet" type="text/css" href="css/visitor_v1.css">
	<script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>
	<script type="text/javascript" src="js/fastselect.standalone.min.js"></script>

	<!--NAV-->
	<link href="css/flexnav.css" media="screen, projection" rel="stylesheet" type="text/css">
	<script src="js/jquery.flexnav.js" type="text/javascript"></script>
	<script src="js/common.js"></script> 
	<!--NAV-->

<script src="js/visitor_v1.js" type="text/javascript"></script>

<script src="jsvalidation/jquery.validate.js" type="text/javascript"></script>

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
    <div class="clear"></div>
	
    <!--container starts-->
    <div class="container_wrap">
      <div class="container">
        <div class="container_leftn">
          <div class="breadcome"></div>
          
          <div id="loginForm">
            <div class="userName">
              <div class="clear"></div>
            </div>
			
            <div id="formContainer">
			
              <span class="headtxt">VISITOR REGISTRATION</span>
	<!--  Start Delivery Start -->		  
		<form action="" class="cmxform" method="post" name="form" id="form">    
            <table>                
                <thead>
                  <tr>
                    <th scope="col">Shipping Address (For Badges Courier)</th>                   
                    <th scope="col">Billing Address (For Billing Purpose)</th>                   
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td data-label="Pattern Name">
						<?php
						if($member_type == "MEMBER") 
                        //$addflag = "SELECT * FROM `communication_address_master` WHERE `address_identity`='CTC' and `registration_id`='$registration_id'";
						$addflag = "SELECT distinct c_bp_number,id,address1,address2,state,city,pincode,gst_no,type_of_address FROM `communication_address_master` WHERE `address_identity`='CTC' AND `registration_id`='$registration_id' AND c_bp_number!=''";
						else
						$addflag = "SELECT * FROM `n_m_billing_address` WHERE `registration_id`='$registration_id'";			
                        ?>
					   <select class="textField" id="address_selection" name="address_selection">                      
							<option value="">---- Shipping Address ----</option>	
                            <?php 
							$queryadd = mysql_query($addflag);
							$nans = mysql_num_rows($queryadd);
							if($nans > 0){
                            while($rows = mysql_fetch_array($queryadd))
							{ ?>
                            <option value="<?php echo $rows['id']; ?>" ><?php echo strtoupper($rows['address1'])." ".strtoupper($rows['city']);?></option>
                            <?php } } else { ?>	
							<option value="">Not Found</option>	
							<?php } ?>
					   </select>					   
                    </td>
				  
                    <td data-label="Pattern Name">
						<?php
						if($member_type == "MEMBER")
						$addflag = "SELECT distinct c_bp_number,id,address1,address2,state,city,pincode,gst_no,type_of_address FROM `communication_address_master` WHERE `address_identity`='CTC' AND `registration_id`='$registration_id' AND c_bp_number!=''";
						else
						$addflag = "SELECT * FROM `n_m_billing_address` WHERE `registration_id`='$registration_id'";			
                        ?>
					   <select class="textField" id="billing_address_selection" name="billing_address_selection">                      
							<option value="">---- Billing Address ----</option>	
                            <?php 
							$queryadd = mysql_query($addflag);
							$nans = mysql_num_rows($queryadd);
							if($nans > 0){
                            while($rows = mysql_fetch_array($queryadd))
							{ ?>
                            <option value="<?php echo $rows['id']; ?>" ><?php echo strtoupper($rows['address1'])." ".strtoupper($rows['city']);?></option>
                            <?php } } else { ?>	
							<option value="">Not Found</option>	
							<?php } ?>				
					   </select>					   
                    </td>
				  </tr>
                </tbody>				
            </table>
		<div class="clear"></div>
        </form> 
	<!--   End Delivery Start -->
    <!--   Add Visitor Start -->		  
	<form id="item_selection" name="item_selection" method="POST" onSubmit="return validate()">      
              <div class="title margin_t  ml-10 duo">
              	<a class="btn btn_link" href="employee_directory.php" title="Add / Edit information">Manage Directory</a>
              	<a class="btn btn_link" href="manage_address.php" title="Add / Edit Address">Add / Edit Address</a>
              </div>
              <div class="clear"></div>
            <table>
                
                <thead>
                  <tr>
                    <th width="30%" scope="col" width="35%">Select Visitor</th>
                    <th width="30%" scope="col">Registration For</th>
                    <th width = "30%" scope="col">Amount</th>
                    <th width="10%" scope="col">Add</th>                    
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td data-label="Pattern Name">
					<input type="hidden" name="xyz" value=""/>
					<input type="hidden" name="year" value="<?php echo $year;?>"/> 
					<input type="hidden" name="show" value="<?php echo $show;?>"/>
					
							<select class="textField multipleSelect" id="visitor_id" name="visitor_id[]" multiple="multiple">
							<?php	
							$checkVisitor = "SELECT * FROM `visitor_order_temp` WHERE registration_id='$registration_id' AND `show`='$show' AND `year`='$year' AND `status`='1' AND paymentThrough='online'";	
							$resultCheckVisitor =mysql_query($checkVisitor);
							$visCartArr = array();
							while( $rowCheckVisitor =mysql_fetch_array($resultCheckVisitor)){
                                $visCartArr[] = $rowCheckVisitor['visitor_id'] ;
                            }

							$newx = "SELECT * from visitor_directory where `registration_id`='$registration_id' AND status='1' AND visitor_approval='Y'  AND (combo='N' OR combo is NULL) order by name";
							$query=mysql_query($newx);
							$countx = mysql_num_rows($query);
							if($countx > 0) {


							$lettersinDB = array();
							while($rows = mysql_fetch_assoc($query)){
								array_push($lettersinDB,array('visitor_id'=>$rows['visitor_id'],'name'=>$rows['name']));
							}
							?>							
							<!-- <option value="" selected="selected">-- Select Visitor --</option> -->
							<?php
							$checkHistory = "SELECT * FROM `visitor_order_history` WHERE registration_id='$registration_id' AND `status`='1' AND  payment_status='Y'";
							$getQuery = mysql_query($checkHistory);
							$checkResult = mysql_num_rows($getQuery);
							$gotcommaid = array();
							while($checkQuery = mysql_fetch_assoc($getQuery)){
								//$gotcommaid = explode(",",$checkQuery['visitor_id']);
								array_push($gotcommaid,explode(",",$checkQuery['visitor_id']));															
							}
							//print_r($gotcommaid);
							$finalvisitoridarray = array();
							foreach($gotcommaid as $k => $v){
								$finalvisitoridarray = array_merge($finalvisitoridarray,$v);
							}
							//print_r($finalvisitoridarray);
							//print_r($gotcommaid);
							foreach($lettersinDB as $option_value)
							{ //echo '<pre>'; print_r($option_value);								
								if(!in_array($option_value['visitor_id'], $finalvisitoridarray) && !in_array($option_value['visitor_id'], $visCartArr)) { ?>								
								<option  value="<?php echo $option_value['visitor_id']; ?>"><?php echo strtoupper($option_value['name']); ?></option>
								<?php
								}
							}
							?>
							<?php } else { ?>
							<option value="0">Not Found</option>
							<?php }	?>							
					</select>

					<label for="visitor_id" class="error"></label>
                    </td>
                    <td data-label="SIZE">
					  	<select name="payment_made_for" id="payment_made_for"  class="textField" style="width:100%">
							<option value="">--- Please Select One ---</option>
							<option value="1show">IIJS Premiere 2020 + Machinery 2020</option>
							<option value="combo">IIJS Premiere 2020 + IIJS Signature 2021 + Machinery 2020</option>
							<option value="4show">IIJS Premiere 2020 + IIJS Signature 2021 + IIJS Premiere 2021 + IIJS Signature 2022</option>
							<option value="igjme">Machinery 2020</option>
						</select>
						<label for="payment_made_for" class="error"></label>
                    </td>
                    <td data-label="Star Rating">
					<input name="participation_fee" id="participation_fee" type="text" class="inputField" readonly/> 
				<label for="participation_fee" class="error"></label>
			</td>
					
                    <td data-label="TRACode"><input type="button" name="add_visitor" id="add_visitor" value="ADD" class="btn" ></td>
					<!--<span id='progress' style="display:none"><img src="images/progress.gif"/>  Please wait....</span>-->
                  </tr>
                </tbody>				
            </table>
	</form>	
	<div class="content" id="data"></div>
	<!-- Add Visitor End -->
	
            <div class="title margin_t"><h4>Selected Registration</h4></div>
            <div class="clear"></div>
             <p style="color: red; margin-bottom: 5px; font-weight: bold;">Please Note : Visitor who already Registered for 2/5 & 3/6 Shows starting from IIJS PREMIERE 2019 need to preserve the badge</p>            
			  	
        <table border="0" cellspacing="0" cellpadding="0" class="formManual">                
                <thead>
                  <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Designation</th>
                    <th scope="col">Mobile Number</th>
                    <th scope="col">Photo</th>
                    <th scope="col">Amount</th>                 
                    <th scope="col">Delete</th>                 
                  </tr>
                </thead>
                <tbody id="Applied_Items">
				<?php
				$query1="select * from visitor_order_temp where registration_id='$registration_id' AND `show`='$show' AND `year`='$year' AND `status`='1' AND visitor_id!='0' AND paymentThrough='online'";
				$showResult = mysql_query($query1);
				while($result1=mysql_fetch_array($showResult)){
				$visitor_id = $result1['visitor_id'];
				$total = $result1['amount'];
				?>
                  <tr>
                    <td data-label="Name"><?php echo getVisitorName($visitor_id);?></td>
                    <td data-label="SIZE"><?php echo getVisitorDesignationID(getVisitorDesignation($visitor_id));?></td>
                    <td data-label="Star Rating"><?php echo getVisitorMobile($visitor_id);?></td>
                    <td data-label="TRACode"><img src="images/employee_directory/<?php echo $registration_id;?>/photo/<?php echo getVisitorPhoto($visitor_id);?>" class="emp_img"></td>
                    <td data-label="Pattern Name"><?php echo $total;?></td>
                    <td data-label="Delete"><img src='images/delete.png'  alt='Delete' title='Delete' class="deleteOrder <?php echo $result1['id']?>" style="cursor:pointer;" /></td>					
                  </tr>  
				<?php } ?>
                </tbody>
		</table>
              <div class="clear"></div>
              <div class="title margin_t">
                <h4>Payment Information</h4>
              </div>
		<form name="visitorRegn" action="payment_thankyou.php" method="POST" onsubmit="document.getElementById('myButton').disabled=true;
document.getElementById('myButton').value='Submitting, please wait...';">
<input type="hidden" name="delivery_id" id="delivery_id"/>
<input type="hidden" name="billing_delivery_id" id="billing_delivery_id"/>

				<input type="hidden" name="type_of_member" id="type_of_member" <?php if($member_type == "MEMBER"){?>value="M" <?php } ?><?php if($member_type != "MEMBER"){?>value="NM" <?php } ?> />
			  <div id="paymentDiv">
			    <?php  
				if(isset($registration_id) && $registration_id!="")
				{
				$sqlP = "select sum(amount) as amount from visitor_order_temp where registration_id='$registration_id' AND `show`='$show' AND `year`='$year' AND visitor_id!='0' AND paymentThrough='online'";
				$queryP = mysql_query($sqlP);
				}
				else
				{
					echo 'something wrong';
				}
				$resultP = mysql_fetch_array($queryP);
				$total_payable = trim($resultP['amount']);
				$gst_amount = $amount*18/100;
				?>
              <table>
                
                <thead>                  
                </thead>
                <tbody>
                  <tr>
                    <td scope="col">Total Amount</td>
                    <td scope="col">: <?php echo $amount = round($total_payable*100/118);?>
					<input type="hidden" name="amount" id="amount" value="<?php echo base64_encode($amount);?>"/></td>                    
                  </tr>
                  <tr>
                    <td data-label="Pattern Name">GST(18%)</td>
                    <td data-label="SIZE">: <?php echo $gst_amount = round($amount*18/100);?>
					<input type="hidden" name="gst_amount" id="gst_amount" value="<?php echo base64_encode($gst_amount);?>"/></td>
                  </tr>
                  <tr>
                    <td data-label="Pattern Name">Total Payable</td>
                    <td data-label="SIZE">: <?php echo $total_payable;?> 
					<input type="hidden" name="total_payable" id="total_payable" value="<?php echo base64_encode($total_payable);?>"/></td>
                  </tr>
                </tbody>
              </table>
              <!--<input type="checkbox" name="chk" value="Chk"> I Agree and accept that all the information provided  by me is authentic and i do not wish
              to misrepresent any data<br>-->         
        
            <input type="checkbox" name="agree" value="agree" checked ><span style="color:blue"> I Agree with above terms and conditions </span><a href="pdf/Visitor-Terms-&-Conditions-IIJS-Premiere-2020.pdf" target="_blank" style="color: red; text-decoration: underline;font-size: 12px;">Read More...</a>
              <br>
              <input type="submit" name="Submit" value="Submit" id="myButton" class="submitbtn">
            </div>
		</form>
        </div>
        </div>
      </div>   
      
    </div>
  </div>
 
<div class="clear"></div>
</div>
<!--container ends-->
<!--footer starts-->
<div class="footer_wrap">
<?php include ('footer.php'); ?>
</div>
<!--footer ends-->


</body>
</html>
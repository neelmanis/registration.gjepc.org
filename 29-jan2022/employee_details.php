<?php
$encrypted_id = $_GET['id'];
$visitorId = base64_decode($encrypted_id);
?>
<?php include('header_include.php');
if(!isset($_SESSION['USERID'])){header("location:login.php");exit;}
$registration_id=$_SESSION['USERID'];
$sql = "select * from exh_reg_payment_details where uid='$registration_id' and `show`='IIJS SIGNATURE 2022' AND `year`='2022' AND allow_visitor='N' order by payment_id desc limit 0,1";
$ans = $conn->query($sql);
$nans=$ans->num_rows;
if($nans>0){
	echo "<script>alert('You are Exhibitor'); window.location = 'my_dashboard.php';</script>";
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<title>Employee Directory</title>
<link rel="icon" href="https://gjepc.org/assets/images/fav_icon.png" type="image/x-icon"/>
<link rel="stylesheet" type="text/css" href="https://gjepc.org/assets-new/css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="css/mystyle.css?v=<?php echo $version;?>" />
<link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Cabin'>
<link rel="stylesheet" type="text/css" href="css/general.css?v=<?php echo $version;?>" />
<link rel="stylesheet" type="text/css" href="css/inner_pg_style.css?v=<?php echo $version;?>" />
 
<link rel="stylesheet" type="text/css" href="css/responsive.css?v=<?php echo $version;?>" />
<link rel="stylesheet" type="text/css" href="css/media_query.css?v=<?php echo $version;?>" />
<script type="text/javascript" src="js/jquery-1.8.3.min.js?v=<?php echo $version;?>"></script>

<!--NAV-->
<link href="css/flexnav.css?v=<?php echo $version;?>" media="screen, projection" rel="stylesheet" type="text/css">
<script src="js/jquery.flexnav.js?v=<?php echo $version;?>" type="text/javascript"></script>
<script src="js/common.js?v=<?php echo $version;?>"></script> 
<!--NAV-->

<!-- UItoTop plugin -->
<link rel="stylesheet" type="text/css" media="screen,projection" href="css/ui.totop.css?v=<?php echo $version;?>" />
<script src="js/easing.js?v=<?php echo $version;?>" type="text/javascript"></script>
<script src="js/jquery.ui.totop.js?v=<?php echo $version;?>" type="text/javascript"></script>    
<script type="text/javascript">
    $(document).ready(function() {        
        $().UItoTop({ easingType: 'easeOutQuart' });        
    });
</script>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-178505237-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-178505237-1');
</script>
<!-- Global site tag (gtag.js) - Google Ads: 679056788 --><!--  <script async src="https://www.googletagmanager.com/gtag/js?id=AW-679056788"></script> <script> window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag('js', new Date()); gtag('config', 'AW-679056788'); </script>  -->
<!-- Event snippet for GJEPC_Google_PageView conversion page --> <script> gtag('event', 'conversion', {'send_to': 'AW-679056788/N1zUCJPKxLsBEJSr5sMC'}); </script> 
<!-- Facebook Pixel Code -->
<script>
  !function(f,b,e,v,n,t,s)
  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
  n.queue=[];t=b.createElement(e);t.async=!0;
  t.src=v;s=b.getElementsByTagName(e)[0];
  s.parentNode.insertBefore(t,s)}(window, document,'script',
  'https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', '398834417477910');
  fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
  src="https://www.facebook.com/tr?id=398834417477910&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->

</head>


<body>

<div class="wrapper">

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
      <!-- <div class="breadcome"><a href="#">Home</a> ><a href="employee_directory.php">Employee Directory</a> > Employee Registration Details</div> -->
     
     <div class="clear"></div>
      <div><a href="employee_directory.php" class="btn_back cta mb-3" style="display:table">Back to Employee Directory</a></div>
          <div class="clear"></div>
			<?php  
			$statement = "SELECT * FROM visitor_directory WHERE visitor_id = '$visitorId'";
            $Query = $conn->query($statement);
            while($row = $Query->fetch_assoc()){
            ?>

<div class="box-shadow mb-5">

			<table class="table" style="border:1px solid #ddd">
            <thead>
						<tr>
                        <td><b> Employee Name</b></td>                            
                            <td><?php echo $row['name'].' '.$row['lname']; ?> </td>
                           <td><b>Designation</b></td>                            
                            <td><?php echo getVisitorDesignationID($row['designation'],$conn); ?> </td>                            
                        </tr>                       
                        <tr>
                            <td><b> Mobile </b></td>                            
                            <td><?php echo $row['mobile']; ?> </td>
                            <td> <b>Email:</b></td>                        
							<td><?php echo $row['email']; ?></td>                            
                        </tr>                           
                        <tr>
                           	<td><b> Aadhar Number</b></td>                            
                            <td><?php echo $row['aadhar_no']?> </td>
                            <td><b>  PAN  Number</b></th>                            
                            <td><?php echo $row['pan_no']?> </td>
                        </tr>
                        <tr>
                        <td><b>  Photo</b></td>                            
                        <td>
                        <?php  $photoext = pathinfo($row['photo'], PATHINFO_EXTENSION);
                            if($photoext =="pdf" || $photoext =="PDF"){?>
                            <a href="images/employee_directory/<?php echo $_SESSION['USERID'];?>/photo/<?php echo $row['photo'];?>" target="_blank"><img src="images/pdf.png" alt="pdf File" title="Click Here to View"></a>
                            <?php } else { ?>
                              <img src="images/employee_directory/<?php echo $_SESSION['USERID'];?>/photo/<?php echo $row['photo'];?>" style="width:75px"> 
                        <?php } ?>
                        </td>
						<td><b>  PAN Copy</b></td>                            
                        <td>
						<?php  $panext = pathinfo($row['pan_copy'], PATHINFO_EXTENSION);
                            if($panext =="pdf" || $panext =="PDF"){?>
                            <a href="images/employee_directory/<?php echo $_SESSION['USERID'];?>/pan_copy/<?php echo $row['pan_copy'];?>" target="_blank"><img src="images/pdf.png" alt="pdf File" title="Click Here to View"></a>
                            <?php }else{ ?>
                              <img src="images/employee_directory/<?php echo $_SESSION['USERID'];?>/pan_copy/<?php echo $row['pan_copy'];?>" style="width:75px">
						<?php } ?>
                        </td>                            
                        </tr>                      
                        <tr>                        
                              <?php if($row['degn_type']=="Employee"){?>
                            <td><b>  Salary Slip Copy</b></td>
                            
                            <td colspan="3">
                               <?php  $salaryext = pathinfo($row['salary_slip_copy'], PATHINFO_EXTENSION);
                            if($salaryext =="pdf" || $salaryext =="PDF"){?>
                            <a href="images/employee_directory/<?php echo $_SESSION['USERID'];?>/salary/<?php echo $row['salary_slip_copy'];?>" target="_blank"><img src="images/pdf.png" alt="pdf File" title="Click Here to View"></a>
                            <?php }else{ ?>
                            <img src="images/employee_directory/<?php echo $_SESSION['USERID'];?>/salary/<?php echo $row['salary_slip_copy'];?>" style="width:75px"> 
							<?php } ?>
                            </td>
                          <?php } else { ?>                          
                            <td><b>  Partner</b></td>                            
                            <td>
                            <?php  $partnerext = pathinfo($row['partner'], PATHINFO_EXTENSION);
                            if($partnerext =="pdf" || $partnerext =="PDF"){?>
                            <a href="images/employee_directory/<?php echo $_SESSION['USERID'];?>/partner/<?php echo $row['partner'];?>" target="_blank"><img src="images/pdf.png" alt="pdf File" title="Click Here to View"></a>
                            <?php }else{ ?>
                            <img src="images/employee_directory/<?php echo $_SESSION['USERID'];?>/partner/<?php echo $row['partner'];?>" style="width:75px"> 
                            <?php } ?>
                          </td>                         
                          
                        <?php } ?>
                         
                        </tr>                    
            </thead>          
          </table>
        </div>
      <?php } ?>         
          <div class="clear"></div>    
      </div>
    </div>
  </div>

<div class="clear"></div>

<!--container ends-->
<!--footer starts-->
 <div class="footer">
        <?php include ('footer.php'); ?>
      </div>
</div>
<!--footer ends-->
<style type="text/css">
  .btn_back{padding: 5px; background: #ccc;color: #000}

@media  (max-width: 600px){
  .table td {width: 50%;display: inline-block;word-wrap: break-word;}
}
</style>
</body>
</html>
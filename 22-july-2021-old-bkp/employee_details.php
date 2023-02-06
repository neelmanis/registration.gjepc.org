<?php
$encrypted_id = $_GET['id'];
$visitorId = base64_decode($encrypted_id);
?>
<?php include('header_include.php');
if(!isset($_SESSION['USERID'])){header("location:login.php");exit;}
$registration_id=$_SESSION['USERID'];
$sql = "select * from exh_reg_payment_details where uid='$registration_id' and `show`='IIJS 2019' AND allow_visitor='N' order by payment_id desc limit 0,1";
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
<link rel="icon" href="https://gjepc.org/images/favicon.ico" type="image/x-icon"/>
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
      <div class="breadcome"><a href="#">Home</a> ><a href="employee_directory.php">Employee Directory</a> > Employee Registration Details</div>
     
     <div class="clear"></div>
      <div><a href="employee_directory.php" class="btn_back">Back to Employee Directory</a></div>
          <div class="clear"></div>
          <div class="borderBottom"></div>
			<?php  
			$statement = "SELECT * FROM visitor_directory WHERE visitor_id = '$visitorId'";
            $Query = $conn->query($statement);
            while($row = $Query->fetch_assoc()){
            ?>
			<table>
            <thead>
						<tr>
                        <th><b> Employee Name</b></th>                            
                            <th><?php echo $row['name'].' '.$row['lname']; ?> </th>
                           <th><b>Designation</b></th>                            
                            <th><?php echo getVisitorDesignationID($row['designation'],$conn); ?> </th>                            
                        </tr>                       
                        <tr>
                            <th><b> Mobile </b></th>                            
                            <th><?php echo $row['mobile']; ?> </th>
                            <th> <b>Email:</b></th>                        
							<th><?php echo $row['email']; ?></th>                            
                        </tr>                           
                        <tr>
                           	<th><b> Aadhar Number</b></th>                            
                            <th><?php echo $row['aadhar_no']?> </th>
                            <th><b>  PAN  Number</b></th>                            
                            <th><?php echo $row['pan_no']?> </th>
                        </tr>
                        <tr>
                        <th><b>  Photo</b></th>                            
                        <th>
                        <?php  $photoext = pathinfo($row['photo'], PATHINFO_EXTENSION);
                            if($photoext =="pdf" || $photoext =="PDF"){?>
                            <a href="images/employee_directory/<?php echo $_SESSION['USERID'];?>/photo/<?php echo $row['photo'];?>" target="_blank"><img src="images/pdf.png" alt="pdf File" title="Click Here to View"></a>
                            <?php } else { ?>
                              <img src="images/employee_directory/<?php echo $_SESSION['USERID'];?>/photo/<?php echo $row['photo'];?>" style="width:75px"> 
                        <?php } ?>
                        </th>
						<th><b>  PAN Copy</b></th>                            
                        <th>
						<?php  $panext = pathinfo($row['pan_copy'], PATHINFO_EXTENSION);
                            if($panext =="pdf" || $panext =="PDF"){?>
                            <a href="images/employee_directory/<?php echo $_SESSION['USERID'];?>/pan_copy/<?php echo $row['pan_copy'];?>" target="_blank"><img src="images/pdf.png" alt="pdf File" title="Click Here to View"></a>
                            <?php }else{ ?>
                              <img src="images/employee_directory/<?php echo $_SESSION['USERID'];?>/pan_copy/<?php echo $row['pan_copy'];?>" style="width:75px">
						<?php } ?>
                        </th>                            
                        </tr>                      
                        <tr>                        
                              <?php if($row['degn_type']=="Employee"){?>
                            <th><b>  Salary Slip Copy</b></th>
                            
                            <th>
                               <?php  $salaryext = pathinfo($row['salary_slip_copy'], PATHINFO_EXTENSION);
                            if($salaryext =="pdf" || $salaryext =="PDF"){?>
                            <a href="images/employee_directory/<?php echo $_SESSION['USERID'];?>/salary/<?php echo $row['salary_slip_copy'];?>" target="_blank"><img src="images/pdf.png" alt="pdf File" title="Click Here to View"></a>
                            <?php }else{ ?>
                            <img src="images/employee_directory/<?php echo $_SESSION['USERID'];?>/salary/<?php echo $row['salary_slip_copy'];?>" style="width:75px"> 
							<?php } ?>
                            </th>
                          <?php } else { ?>                          
                            <th><b>  Partner</b></th>                            
                            <th>
                            <?php  $partnerext = pathinfo($row['partner'], PATHINFO_EXTENSION);
                            if($partnerext =="pdf" || $partnerext =="PDF"){?>
                            <a href="images/employee_directory/<?php echo $_SESSION['USERID'];?>/partner/<?php echo $row['partner'];?>" target="_blank"><img src="images/pdf.png" alt="pdf File" title="Click Here to View"></a>
                            <?php }else{ ?>
                            <img src="images/employee_directory/<?php echo $_SESSION['USERID'];?>/partner/<?php echo $row['partner'];?>" style="width:75px"> 
                            <?php } ?>
                          </th>                         
                          
                        <?php } ?>
                         <th></th>
                             <th></th>
                        </tr>                    
            </thead>          
          </table>
      <?php } ?>         
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

table thead tr th:first-child{width: 150px;border-right: 1px solid #ccc}


  table {
/*  border: 1px solid #ccc;
*/  border-collapse: separate;
  margin: 0;
  padding: 0;
  width: 100%;
/*  table-layout: fixed;*/
border-spacing: 0px;
margin-bottom:20px;
}
  table a{color: #751c54;}

table caption {
  font-size: 1.5em;
  margin: .5em 0 .75em;
  text-align: left;
  text-transform: uppercase;
  color: #000;
}
table tr {
/*  background: #f8f8f8;*/
  border: 1px solid #ddd;
  padding: .35em;
}
table th,
table td {
  padding: .625em;
  text-align: left;
}
table th {
  font-size: 12px;
  font-weight: 500;
  letter-spacing: .1em;
  text-transform: uppercase;
 font-family: Arial, Helvetica, sans-serif;    
    text-align: left;
    color: #000;  
}
table th b{
font-family: Arial, Helvetica, sans-serif;
    font-size: 12px;
    text-align: left;
    color: #000;
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
</style>
</body>
</html>
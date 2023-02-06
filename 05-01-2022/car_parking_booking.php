<?php 
include('header_include.php');
if(!isset($_SESSION['USERID'])){ header("location:login.php");	exit; }
$registration_id = filter($_SESSION['USERID']);



if(isset($registration_id)){
    $query = "select * from globalparking where registration_id = '$registration_id' and isSubmitted = '0'";
    $result_sel = $conn->query($query);
    $pass_count = $result_sel->num_rows;	

    $row = $result_sel->fetch_assoc();		 	
    $name = $row['name'];
    $unique_code = $row['unique_code'];
}

$action=@$_REQUEST['action'];
if ($action == "save") {
    $vehicle_number = trim(strtoupper($_REQUEST['vehicle_number']));
    //$date = $_REQUEST['date'];
    $ar_time = $_REQUEST['arrival_time'];
    $arrival_time = date("g:i a", strtotime($ar_time));
    $unique_code = $_REQUEST['car_pass'];
    $query = "select * from globalparking where unique_code = '$unique_code' and isSubmitted = '1'";
    $result_sel = $conn->query($query);
    $pass_count = $result_sel->num_rows;
    $rows = $result_sel->fetch_assoc();	
    if($rows['isSubmitted'] == 1){
        echo '<script>alert("This Pass Already Registered")</script>';
        exit;
    }	
    // if($rows['vehicle_no'] == $vehicle_number ){
    //     echo '<script>alert("This Pass Already Registered")</script>';
    // }

    $row = $result_sel->fetch_assoc();		
    $sqlx = "update globalparking set `vehicle_no`='$vehicle_number',`arrival_time`='$arrival_time',`isSubmitted`='1' where `unique_code` = '$unique_code'";
    
    $resultx = $conn->query($sqlx);
    if ($resultx) {
        header("Refresh: 2; url=https://registration.gjepc.org/car_parking_booking.php");
    }
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Virual Show Selection</title>
		<link rel="icon" href="https://gjepc.org/images/favicon.ico" type="image/x-icon"/>
		<link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Cabin'>
		<link rel="stylesheet" type="text/css" href="css/general.css?v=<?php echo $version;?>" />
		<link rel="stylesheet" type="text/css" href="css/inner_pg_style.css?v=<?php echo $version;?>" />		
		<link rel="stylesheet" type="text/css" href="css/responsive.css?v=<?php echo $version;?>" />
		<link rel="stylesheet" type="text/css" href="css/media_query.css?v=<?php echo $version;?>" />
		<link rel="stylesheet" type="text/css" href="css/visitor_reg.css?v=<?php echo $version;?>" />
		<script type="text/javascript" src="js/jquery-1.8.3.min.js?v=<?php echo $version;?>"></script>
		<!--NAV-->
		<link href="css/flexnav.css?v=<?php echo $version;?>" media="screen, projection" rel="stylesheet" type="text/css">
		<script type="text/javascript" src="flexnav-master/js/jquery.flexnav.min.js?v=<?php echo $version;?>"></script>
		<script src="js/common.js"></script>
		<!--NAV-->
		<!-- UItoTop plugin -->
		<link rel="stylesheet" type="text/css" media="screen,projection" href="css/ui.totop.css?v=<?php echo $version;?>" />
		<script src="js/easing.js?v=<?php echo $version;?>" type="text/javascript"></script>
		<script src="js/jquery.ui.totop.js?v=<?php echo $version;?>" type="text/javascript"></script>
		<script src="jsvalidation/jquery.validate.js?v=<?php echo $version;?>" type="text/javascript"></script> 
         <link rel="stylesheet" type="text/css" media="screen" href="css/rcmc.validation.css?v=<?php echo $version;?>" />
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
		<script type="text/javascript">
            $(window).load(function() {
                $(".loader").fadeOut("slow");

                var checkEvent = $('input[name="event"]').val();
                        
            });
		
        </script>
        <script>
            $(document).ready(function(){
                $(function () {
                    $('#datetimepicker4').datetimepicker();
                });
            });
        </script>
        <style>
            .form_wrapper {width:50%; float:left;}
            @media (max-width:768px)
            {
                .form_wrapper {width:100%; float:none;}
            }
            .box-shad {
                background: #fff;
                padding: 30px;
                /* width: 100%; */
                box-shadow: 0 5px 10px 0 rgb(0 0 0 / 12%);
                position: relative;
                border: 1px solid #161612;
                /* margin-bottom: 7%; */
            }
        </style>
        <script>
            $(window).ready(function(e){
                $("#eventForm").validate({
                    rules: {
                        car_pass: {
                            required: true,
                        },  
                        vehicle_number: {
                            required: true,
                        },
                        date: {
                            required: true,
                        },		
                        arrival_time: {
                            required: true,
                        },
                        
                    },
                    messages: {
                        car_pass: {
                            required: "Please select car pass",
                        },
                        vehicle_number: {
                            required: "Please Enter Vehicle Number",
                        },	
                        date: {
                            required: "Please select date",
                        },
                        arrival_time: {
                            required: "Please Enter Arrival Time",
                        },
                    }
                });
            });
        </script>
    </head>

<body>

    <div class="loader"><p>loading please wait....</p></div>
	<div class="wrapper">
	    <div class="header"><?php include('header1.php'); ?></div>
        <div class="inner_container">
                        
            <div class="container_wrap">
                <div class="container">
                <span class="headtxt"></span>	
                <div id="loginForm">		  
                
                        <div id="formContainer">
                            <?php $query_se = "select gp.car_pass,gp.unique_code,gp.isSubmitted from globalparking  as gp where registration_id='$registration_id'  and isSubmitted = '0' ";
                            $result_se = $conn->query($query_se);
                            if ($result_se->num_rows > 0) { ?>
                                <div class="field_box">
                                    <div class="field_name" style=" text-align: center;font-weight: 900;font-size: larger;">Car Pass Booking </div>
                                    
                                    <div class="clear"></div>
                                </div>
                            
                                <div class="form_main box-shad small_box">
        
                                    <form class="eventForm " method="POST" name="eventForm" id="eventForm">       
                                        <div class="field_box">
                                            <div class="field_name">Compant Name <span>*</span> :</div>
                                            <?php echo $_SESSION['COMPANYNAME']; ?>
                                            <div class="clear"></div>
                                        </div>
                                        <div class="field_box">
                                        <?php $query_sel = "select gp.car_pass,gp.unique_code,gp.isSubmitted from globalparking  as gp where registration_id='$registration_id' ";
                                            $result_sel = $conn->query($query_sel);
                                            while ($row = $result_sel->fetch_assoc()) { ?>
                                                <input type="radio" id="<?php echo $row['car_pass']; ?>" name="car_pass" value="<?php echo $row['unique_code'] ?>" <?php echo $row['isSubmitted'] == '1' ? 'disabled' : ''; ?>>
                                                <label for="<?php echo $row['car_pass']; ?>">Car Pass <?php echo $row['car_pass']; ?><span>  &nbsp;(<?php echo $row['unique_code']; ?>)</span></label><br>
                                                <div class="clear"></div>
                                            <?php } ?>
                                            <div class="clear"></div>
                                        </div>
                                    
                                        <div class="field_box">
                                            <div class="field_name">Vehicle Number <span>*</span> :</div>
                                            <div class="field_input"><input type="vehicle_number" class="bgcolor" id="vehicle_number" name="vehicle_number" placeholder="MH03DR7000" autocomplete="off" style="text-transform:uppercase;"/></div>
                                            <div class="clear"></div>
                                        </div>
                                        <!-- <div class="field_box">
                                            <div class="field_name">date <span>*</span> :</div>
                                            <div class="field_input"><input type="date" class="bgcolor" id="date" name="date" autocomplete="off"/></div>
                                            <div class="clear"></div>
                                        </div> -->
                                        <div class="field_box">
                                            <div class="field_name">Estimated Arrival Time <span>*</span> :</div>
                                            <div class="field_input"><input type="time" class="bgcolor" id="arrival_time" name="arrival_time" autocomplete="off"/></div>
                                            <div class="clear"></div>
                                        </div>
                                    
                                        
                                        <div class="field_box">
                                            <input type="hidden" name="action" value="save"/>  
                                            
                                            <input type="submit" name="submit" id="submit" value="SUBMIT" class="btn btn-submit">	
                                            <div class="clear"></div>
                                        </div>
                                    </form>       
                                </div>  
                            <?php } ?>         
                            <div class="clear"></div>
                            <?php  $query_se = "select * from globalparking  as gp where registration_id='$registration_id' and isSubmitted = '1' ";
                            $results = $conn->query($query_se);
                            if($results->num_rows > 0 ){ ?>
                            
                                <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">

                                    <table class="table_responsive">
                                        <tbody><tr> <td><strong class="title">Car Passes List</strong>  </td></tr>
                                        </tbody>
                                    </table>
                                    
                                    <div class="alert alert-danger error-div" role="alert" style="display: none;"></div>
                                    <div class="alert alert-info success-div" role="alert" style="display: none;"></div>
                                    
                                    <form>
                                    
                                        <table class="table_responsive">
                                            <tbody>
                                                <?php while ($rows = $results->fetch_assoc()) { ?>
                                                <tr>
                                                    <th align="center">Name</th>
                                                    <th align="center">Car Pass Number (<?php echo $rows['unique_code'] ?>)</th>
                                                    <th align="center">Vehicle Number</th>
                                                    <!-- <th align="center">Date</th> -->
                                                    <th align="center">Arrival Time</th>
                                                </tr>
                                                
                                                <tr>
                                                    <td align="center"><?php echo $rows['name']; ?></td>
                                                    <td align="center"><?php echo $rows['car_pass']; ?></td>
                                                    <td align="center"><?php echo $rows['vehicle_no']; ?></td>
                                                    <!-- <td align="center"><?php echo $rows['vehicle_parking_date']; ?></td> -->
                                                    <td align="center"><?php echo $rows['arrival_time']; ?></td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    
                                    </form>
                                </div>
                            <?php } ?>    

                        </div>   
                        
                    
                    </div>
            
                </div>
            </div>

        </div>
        <div class="clear"></div>
    </div>

		
</body>
</html>
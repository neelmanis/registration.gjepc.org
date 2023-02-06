<?php 
include('header_include.php');
if(!isset($_SESSION['USERID'])){	header("location:login.php");	exit;	}
//echo "<script>alert('Registration under maintenance'); window.location = 'my_dashboard.php';</script>";
if($_SESSION['COUNTRY']=="IN"){ echo "<script>alert('You Are Domestic Visitor'); window.location = 'my_dashboard.php';</script>"; }

$registration_id=$_SESSION['USERID'];

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<title>INTL Employee Directory</title>
<link rel="icon" href="https://gjepc.org/assets/images/fav_icon.png" type="image/x-icon"/>
<link rel="stylesheet" type="text/css" href="https://gjepc.org/assets-new/css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="css/mystyle.css?v=<?php echo $version;?>" />
<link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Cabin'>
<link rel="stylesheet" type="text/css" href="css/general.css?v=<?php echo $version;?>" />
<link rel="stylesheet" type="text/css" href="css/inner_pg_style.css?v=<?php echo $version;?>" />
 <link rel="stylesheet" type="text/css" href="css/visitor_reg.css?v=<?php echo $version;?>" />
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
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-178505237-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-178505237-1');
</script>  
<!-- Global site tag (gtag.js) - Google Ads: 679056788 --> <!-- <script async src="https://www.googletagmanager.com/gtag/js?id=AW-679056788"></script> <script> window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag('js', new Date()); gtag('config', 'AW-679056788'); </script>  -->
<!-- Event snippet for GJEPC_Google_PageView conversion page --> <script> gtag('event', 'conversion', {'send_to': 'AW-679056788/N1zUCJPKxLsBEJSr5sMC'}); </script> 
<!-- <script type="text/javascript">
    $(document).ready(function() {        
        $().UItoTop({ easingType: 'easeOutQuart' });        
    });
</script> -->

<!--<script src="jsvalidation/jquery.js" type="text/javascript"></script>-->
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
	<div class="loader">
		<div style="display:table; width:100%; height:100%;">
			<span style="display:table-cell; vertical-align:middle; text-align:center; padding-top:100px;">Please wait....</span>
		</div>
	</div>
	<div class="header"><?php include('header1.php'); ?></div>

	<div id="preloader">
	    <div id="status"> <img src="images/loader.gif"></div>
	</div>

<!--container starts-->

  	<div class="container my-5">

  		<div class="bold_font text-center">
			<div class="d-block">
				<img src="https://www.gjepc.org/assets/images/gold_star.png" class="">
			</div>International Employee Registration
		</div>
		
		<h2 class="title2 text-center">Visitor can Register after Approval of Below records</h2>
		<!--<a href="visitor_registration.php" style="float: right;" class="cta" title="Select Show And Make Payment">Registration Application</a>-->

      <div class="box-shadow">
      	<div class="userName"></div>
        	<div id="formContainer" class="p-0 mt-4">
          	<div class="title m-0 float-none" id="title_open">
            	<h3><a href="i_v_r.php?action=addnew" target="_blank">NEW REGISTRATION / ADD VISITOR</a><div class="plus">+</div>
			</h4>  
            </div>    	
			</div>

	<div class="clear"></div>
          <div class="title margin_t">
            <h4>EMPLOYEE DETAILS</h4>
            <!--<p style="color: red; font-weight:bold;">Please Note : Visitor who already Registered for 2/5 & 3/6 Shows starting from IIJS PREMIERE 2019 need to preserve the badge</p>-->
          </div>
          <div class="clear"></div>
          <table class="responsive_table">
            <thead>
              <tr>
                <th scope="col">Name</th>                
                <th scope="col">Designation</th>
                <th scope="col">Passport Number</th>
                <th scope="col">Photo</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
          <?php
		  $query_emp =  $conn->query("select * from ivr_registration_details where 1 and uid='$registration_id'");
		  while($emp = $query_emp->fetch_assoc())
		  {
		  $eid = $emp["eid"];
		  $visitor_approval = $emp['application_approved'];
		  $personal_info_reason = filter($emp['personal_info_reason']);
		  $photo_reason = filter($emp['photo_reason']);
		  $valid_passport_copy_reason = filter($emp['valid_passport_copy_reason']);
		  $visiting_card_reason = filter($emp['visiting_card_reason']);
		  $employee_photo_ext =  pathinfo($emp['photograph_fid'], PATHINFO_EXTENSION);
		  ?>
              <tr>
                <td data-column="Name"><?php echo strtoupper($emp['first_name'].' '.$emp['last_name']); ?></td>  
                <td data-column="Designation"><?php echo strtoupper($emp['designation']); ?></td>
                <td data-column="Passport"><?php echo $emp['passport_no']; ?></td>
				<td data-column="Photo"><?php if($employee_photo_ext =="pdf" || $employee_photo_ext =="PDF"){?><a href="images/ivr_image/photograph/<?php echo $emp['photograph_fid'];?>" target="_blank"> <img src="images/pdf_icon.png"></a>
				<?php } else { ?>
				<img src="images/ivr_image/photograph/<?php echo $emp['photograph_fid'];?>" class="emp_img">
				<?php } ?></td>
				 
				<td data-column="Status">
				<?php 
				if($visitor_approval=="Y"){
				echo "Approved";
				} elseif($visitor_approval=="N"){
					echo "Disapproved"."<br> <hr>".$personal_info_reason; echo '<br/>';
					echo $photo_reason; echo '<br/>';
					echo $valid_passport_copy_reason; echo '<br/>';
					echo $visiting_card_reason; echo '<br/>';
					} elseif($visitor_approval=="P"){ echo "Pending";} else { echo ""; } ?>
				</td>
                <td scope="col" data-column="Action">
                <?php if($visitor_approval == "Y") { 
                	$encrypted_id =base64_encode($emp['eid']); 
                ?>
                <!--<img src="images/done.png" title="Approved" border="0" /> / <img src="images/eye.png" onclick="window.location.href='employee_details.php?id=<?php echo $encrypted_id;?>'"  title="View Details" border="0" />-->
                <?php } else { ?>
                <a href="i_v_r.php?id=<?php echo $emp['eid'];?>"><img src="images/edit.png" title="Edit"/></a> / 
                <a href="i_v_r.php?action=del&id=<?php echo $emp['eid']?>" onclick="return(window.confirm('Are you sure you want to delete?'));"> 
                <img src="images/delete.png" title="Delete"/></a>
                <?php } ?>
				</td>
              </tr>
        <?php } ?>
          </tbody>
          </table>
		  
          <div class="clear"></div>
        </div>
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
.appr_icon{
    border: 0px;
    outline: none;
    width: 44px;
}
#form1{display: none;}
#form2{display: none;}	
select{width: 96%;padding: 0px;height:37px; margin :0 auto; display:table;}
#form .textField{width: 92%;padding: 0px 2%;height:35px; margin :0 auto; display:table;}
#form .textField2{width:80%;padding:0; float:left;}
#form .field {
    background: none;
    padding: 0;
    float: left;
	width:31.33%;
	margin:0 1%;
}
.submitbtn {
background: #e2e2e2;
border: none;
padding: 7px 15px;
/*margin-top: 15px;*/
}
.button2 {    
    margin: 20px 10px 20px 0px;
    background: #751c54;
    padding: 7px 12px;
    font-size: 12px;
    margin-left: 13px;
    border-radius: 5px;
    color: #fff;
    cursor: pointer;
}
.button1 {
    float: left;
    margin: 20px 10px 20px 0px;
    background: #751c54;
    padding: 5px 15px;
    border-radius: 15px;
    cursor: pointer;
    color: #fff;}
#updatefrom label.error, #form label.error{font-size: 14px}
    #form label {
    width: 96%;
    display: block;
    float: none;
    /* font-weight: bold; */
    font-size: 14px;
    vertical-align: middle;
    padding-top: 2px;
    color: #751c54;;
	/*height:26px;*/
	margin:0 auto;
	line-height:initial;
	margin-bottom:5px;
	}
  
.icons{border: 0px; outline: none; width:20px;}
.margin_t{margin-top:30px;}
.blah{width: 35px;  height:35px;vertical-align: top;}
#blah{display: none;}
#blah2{display: none;}
#blah3{display: none;}
.form_detail{margin:20px 0; display:none;}
.form_detail p{font-size: 15px;font-weight: 600;text-transform: uppercase;}
#select_v{margin-top:20px; width: 200px; font-size: 16px; color: #ffffff;border: #751c54 1px solid;background: #751c54; padding: 5px;}
#title_open{cursor: pointer;}
.minus{display: none; font-size: 20px; font-weight: 600; float:right;}
.plus{display: inline; font-size: 20px; font-weight: 600; float:right;}
#title_open h4{padding: 10px 15px; margin-top:0px; background: #1a1a1a; color: #fff;}
.minus_1{display: inline!important; font-size: 20px; font-weight: 600;}
.plus_1{display: none;}
.emp_img{max-width: 150px; width: 100%; height: 100px; object-fit: contain; display: table; object-position: left;}

.title h4 {
    font-style: normal;
    font-weight: bold;
    padding: 7px 7px 7px 0;
    font-size: 14px;
    /* background: #000; */
    border-bottom: 1px dashed #a89c5d;
    color: #9e9457;
    margin-bottom: 15px; 
}
.padding-b{padding-bottom:65px;}

.gp_wrp {margin-bottom:20px; background:#f8f8f8; padding:20px;}
.gp_wrp .cmxform{display:table; width:100%;}
.gp_wrp .cmxform .field {display:inline-block; margin-right:0; width:33.33%; vertical-align:text-top; }
.gp_wrp .cmxform .field input[type=file] {border:1px solid #ddd; padding:5px; cursor:pointer;}
.gp_wrp .cmxform .field label {margin-right:20px;}
.gp_wrp .cmxform .field .submitbtn {margin:0;margin-top:20px; height:33px; }
.submitbtn { cursor:pointer; transition:0.3s ease-in-out; -moz-transition:0.3s ease-in-out; -o-transition:0.3s ease-in-out; -webkit-transition:0.3s ease-in-out;}
.submitbtn:hover {background:#000; color:#fff; transition:0.3s ease-in-out; -moz-transition:0.3s ease-in-out; -o-transition:0.3s ease-in-out; -webkit-transition:0.3s ease-in-out;}
.label{display: inline-block; padding: 8px; border:1px solid#000;}
.cmxform .error {color:red;}
</style>
</body>
</html>
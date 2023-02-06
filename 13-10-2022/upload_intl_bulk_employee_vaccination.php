<?php 
include('header_include.php');
if(!isset($_SESSION['USERID'])){header("location:login.php");exit;}
$registration_id = $_SESSION['USERID'];
if($_SESSION['COUNTRY']=="IN"){ echo "<script>alert('You Are Domestic Visitor'); window.location = 'my_dashboard.php';</script>"; }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Upload Vaccine Certificate</title>
   <link rel="icon" href="https://gjepc.org/assets/images/fav_icon.png" type="image/x-icon"/>
    <!--<link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Cabin'>-->
    <link rel="stylesheet" type="text/css" href="https://gjepc.org/assets-new/css/bootstrap.min.css" />
   <link rel="stylesheet" type="text/css" href="css/general.css?v=<?php echo $version;?>" />
    <link rel="stylesheet" type="text/css" href="css/inner_pg_style.css?v=<?php echo $version;?>" />
    <link rel="stylesheet" type="text/css" href="css/responsive.css?v=<?php echo $version;?>" />
    <link rel="stylesheet" type="text/css" href="css/media_query.css?v=<?php echo $version;?>" />
    <link rel="stylesheet" type="text/css" href="css/jquery.fancybox.min.css?v=<?php echo $version;?>" />

    <link rel="stylesheet" type="text/css" href="css/visitor_reg.css?v=<?php echo $version;?>" />
    <script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>
    <script type="text/javascript" src="js/jquery.fancybox.min.js"></script>
   <!--NAV-->
  <link href="css/flexnav.css?v=<?php echo $version;?>" media="screen, projection" rel="stylesheet" type="text/css">
  <script type="text/javascript" src="flexnav-master/js/jquery.flexnav.min.js"></script>
  <script src="js/common.js?v=<?php echo $version;?>"></script> 
  <!--NAV-->
    <script src="jsvalidation/jquery.validate.js" type="text/javascript"></script>
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
  
<!-- End Facebook Pixel Code -->
   
<style type="text/css">
/*  .formwrapper2{display: flex;
    justify-content: space-between;
} */
.form-notes{
  border: 1px solid#000;
  padding: 20px 15px;
}

.form-notes p.gold_text {
font-size:16px;
}
</style>
  </head>
  <body>
    <noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=398834417477910&ev=PageView&noscript=1"
  /></noscript>
    <div class="wrapper">
    <div class="header">
    <?php include('header1.php'); ?>
    <div class="clear"> </div>
  </div>
    <div class="clear"> </div>
    <div class="clear"> </div>

      <!--container starts-->
      <div class="container_wrap my-5">
        <div class="container">
     
          <div class="bold_font text-center">
              <div class="d-block">
                  <img src="https://www.gjepc.org/assets/images/gold_star.png" class="">
              </div>
             <div class="col-12">
					  	 	<p>Select Visitor Add & Update Vaccine Certificate</p>
					  </div>
          </div><p><span class='blink d-block'>Final vaccination certificate Mandatory For Entry</span> </p>
          <div id="loginForm">
            <div id="formWrapper" class="box-shadow">

            <div class="loaderWrapper">
                <div class="formLoader">
                  <img src="images/formloader.gif" alt="">
                  <p> Please Wait....</p>
                </div>
            </div>

            <form method="POST" name="regisForm" id="regisForm">
                <input type="hidden" name="action" value="UpdateCovidReport"/>
                <div class="row">
					<div class="col-md-6 form-group">
						<?php
						$checkHistory = "SELECT * FROM `ivr_registration_history` WHERE registration_id='$registration_id' AND (`show`='iijs22' || `show`='signature23' || `show`='iijstritiya22') AND `status`='1' AND payment_status='Y' group by visitor_id";
						$getQuery = $conn ->query($checkHistory);
						$checkResult = $getQuery->num_rows;
						?>
						<select name="visitor_id" id="visitor_id" class="form-control">
							<option value="">Select</option>
							<?php if($checkResult > 0){
						 	while($vis_list_row = $getQuery->fetch_assoc()){ ?>
							<option value="<?php echo $vis_list_row['visitor_id']?>"><?php echo getINTLVisitorName($vis_list_row['visitor_id'],$conn);?>  (<?php echo getINTLVisitorDesignation($vis_list_row['visitor_id'],$conn);?>)</option>
						<?php }
						} ?>
						</select>
					</div>
					 <div class="col-12">
					  	 	<p>Select Visitor Add & Update Vaccine Certificate</p>
					  </div>
				  <div class="col-12">
                    <label class="d-block">Select vaccine dose</label>
                    <!--<label class="d-inline-block mr-5">
                      <input type="radio" id="dose1" name="valueType" value="dose1"/>First Dose 
                    </label>-->
                    <label>
                      <input type="radio" id="dose2" name="valueType" value="dose2"/>Fully vaccinated visitors are mandatory
                    </label>
                  </div>
                
                  <div class="col-12 form-group" id="vaccine-upload">               
                    <div class="row">                 
                      <div class="form-group col-sm-6">
                        <label id="for_vaccine_certificate"> </label>
                        <input type="file" name="vaccine_certificate" class="form-control" id="vaccine_certificate" accept="image/png, image/jpg,image/jpeg,application/pdf">
                        <i>(only pdf,png,jpg,jpeg file and maximum 2mb size allowed)</i>
                      </div>
                    </div>
                  </div>
                  <div class="col-12 mb-2">
                    <div class="d-block">
                      <input type="checkbox" name="agree" value="YES"> <strong> I Accept That</strong>

                      <ul class="inner_under_listing mt-3">
                        <li>I have read and understood the <a href="pdf/IIJS-Premeire-2022-T-&-C.pdf" target="_blank"><strong>terms and conditions</strong></a> with regard to the visitor's registration</li>
                        <li>I confirm that the upload vaccination certificate is genuine and valid.</li>
                        <li>I agree to abide by the terms and conditions applicable for domestic visitor's registration set by "The Gem & Jewellery Export Promotion Council (GJEPC)".</li>
                        <li>I accept that GJEPC reserves the rights of admission to the show.</li>
						<li>All the visitors visiting the exhibition should be fully vaccinated.</li>
                      </ul>
                    </div>
                    
                    <label for="agree" generated="true" style="display: none;" class="error"></label>
                  </div>
                  <div class="col-12 form-group">
                    <input type="submit" name="submit" id="submit" value="Submit" class="cta">
                  </div>
				</div>            
            </form>
			  
                  <div class="col-12 p-0">
					<?php
					$i=1;
					$sql="SELECT * FROM visitor_lab_info WHERE registration_id='$registration_id' AND (category_for='INTL') order by create_date desc";
					$result = $conn ->query($sql);
					$rCount = $result->num_rows;
					if($rCount>0)
					{
					?>
                  <table class="w-100 responsive_table">
                    <thead>
                      <tr>
                        <th>Sr. No.</th>
                        <th>Date</th>
                        <th>Name</th>
                        <th>Vaccine</th>
                        <th>Dose 1 Status</th>
                        <th>Dose 2 Status</th>
                        <th>Remark</th>
                        <th>Dose 1 Certificate</th>
                        <th>Dose 2 Certificate</th>
                      </tr>
                    </thead>
                    <tbody>
						<?php 
						while($rows = $result->fetch_assoc())
						{
							$visitor_name  = getINTLVisitorName($rows['visitor_id'], $conn);
							
									$pan_no = $rows['pan_no'];
								$mobile_no  = $rows['mobile_no'];
								$certificate = $rows['certificate'];
								$remark = $rows['remark'];
								$dose1_status = $rows['dose1_status'];
								$dose2_status = $rows['dose2_status'];
								
								if($certificate == "dose1"){
								   $certificate = "Dose 1";
								} elseif($certificate == "dose2"){
									$certificate = "Dose 2";
								} elseif($certificate == "booster_dose"){
									$certificate = "Booster Dose";
								}
								
								if($dose1_status == "Y"){
								   $dose1_status = "Approved";
								    $remark = "We will notify you when you can download the badge from GJEPC app.";
								} elseif($dose1_status == "P"){
									$dose1_status = "Pending";
									$remark = "We will notify you on approval or disapproval of your Vaccination Certificate.";
								} elseif($dose1_status == "N"){
									$dose1_status = "DisApproved";
								} elseif($dose1_status == "U"){
									$dose1_status = "Updated";
								}
								
								if($dose2_status == "Y"){
								   $dose2_status = "Approved";
								   $remark = "We will notify you when you can download the badge from GJEPC app.";
								} elseif($dose2_status == "P"){
									$dose2_status = "Pending";
									$remark = "We will notify you on approval or disapproval of your Vaccination Certificate.";
								} elseif($dose2_status == "N"){
									$dose2_status = "DisApproved";
								} elseif($dose2_status == "U"){
									$dose2_status = "Updated";
								}
								
					$dose1_certificate = "https://registration.gjepc.org/images/covid/intl/".$rows['registration_id']."/vaccine_certificate/".$rows['dose1']."";
                    $dose2_certificate = "https://registration.gjepc.org/images/covid/intl/".$rows['registration_id']."/vaccine_certificate/".$rows['dose2']."";
						?>
                     <tr <?php if($i%2==0){echo "bgcolor='#CCCCCC'";}?>>
						<td data-column="Sr. No."><?php echo $i;?></td>
                        <td data-column="Date"><?php echo date("d-m-Y",strtotime($rows['create_date'])); ?></td>
                        <td data-column="Name"><?php echo strtoupper($visitor_name);?></td>
                        <td data-column="Vaccine"><?php echo filter($certificate);?></td>
                        <td data-column="Dose 1 Status"><?php echo filter($dose1_status);?></td>
                        <td data-column="Dose 2 Status"><?php echo filter($dose2_status);?></td>
                        <td data-column="Remark"><?php echo filter($remark);?></td>
                        <td data-column="View">
						<?php if($rows['dose1'] !=""){ ?>           
						   <a <?php if($dose1_ext =="pdf" || $dose1_ext =="PDF"){?> <?php }else{?> data-fancybox="gallery" <?php }?>  href="<?php echo $dose1_certificate;?>" target="_blank">View Report</a>
						<?php } else {	echo "Not Uploaded"; } ?>
						</td>
						 <td data-column="View">
						 <?php if($rows['dose2'] !=""){?>
						   <a <?php if($dose2_ext =="pdf" || $dose2_ext =="PDF"){?> <?php }else{?> data-fancybox="gallery" <?php }?> href="<?php echo $dose2_certificate;?>" target="_blank">View Report</a>
						<?php } else {
							echo "Not Uploaded";
							} ?>
						</td>
                      </tr>
					  	<?php $i++; } ?>
                    </tbody>
                  </table>
					<?php } ?>
                </div>               
               
              </div>
            </div>

          </div>
          <div class="clear"></div>
        </div>
      </div>

      <!--container ends-->
      <!--footer starts-->
      <div class="footer">
        <?php include ('footer.php'); ?>
      </div>
    </div>
    <!--footer ends-->
  </body>
  
<script type="text/javascript">
$(document).ready(function()
{
	$("#regisForm").validate({
	rules: {
		visitor_id:{
		required:true,
		},
		valueType:{
		required:true,
		},
		vaccine_certificate:{
		required:true,
		accept:"jpg,png,jpeg,pdf"
		},
		agree:{
		required:true,
		}
	},
	messages: {
		visitor_id:{
		required: "Select Visitor",
		},
		valueType:{
		required: "Select Your Dose",
		},
		vaccine_certificate:{
		required: "Upload Vaccine certificate",
		accept:"Please select only jpg,png,jpeg,pdf file"
		},
		agree:{
		required: "Please select Terms & Condition",
		}
	},
		submitHandler: covidAction
	});
	});
			
function covidAction(){
		$('#submit').val('please wait...');
		$('#submit').attr('disabled',true);
	    var form = $('#regisForm');
	    var formdata = false;
	    if (window.FormData){
	        formdata = new FormData(form[0]);
	    }
	    $.ajax({
		    type:'POST',
		    url:"upload-intl_bulk-covid-report-ajax.php",
		    data:formdata ? formdata : form.serialize(),
		    dataType: "json",
		    cache:false,
		    contentType: false,
		    processData: false,
		    
		    beforeSend: function(){
		    	$('#submit').val('please wait...');
		    	$('#submit').attr('disabled',true);	
		   		$('.loaderWrapper').show();
		    },
		    success:function(data){
		    	$('.loaderWrapper').delay(1000).fadeOut();
			    if(data.status == 'success'){
			    	$("#regisForm")[0].reset();
	
					$("#formWrapper").html('<div class="col-12"><div class="alert alert-success" role="alert">'+data.message+'</div></div>');
					 setTimeout(function(){
					    window.location = "upload_intl_bulk_employee_vaccination.php";
					  },3000)
					// if(data.device=="android"){
	                // window.location.href ="https://registration.gjepc.org/openApp.php";
					// }else if(data.device=="ios"){
					// }else{
				    // window.location = "single_visitor.php";
					// }
					$('#submit').val('Submit');		
					$('#submit').attr('disabled',false);		
				  
			    } else if(data.status =='error'){
				    alert(data.message);
					$('#submit').val('Submit');		
					$('#submit').attr('disabled',false);		
				   
			    }
		    }
	    });
    }
</script>
<link rel="stylesheet" type="text/css" href="css/new_style.css" /> 
</html>
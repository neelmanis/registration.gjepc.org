<?php 
include('header_include.php');
if(!isset($_SESSION['AGENCYID'])){ header("location:vendor-or-agency-login.php");exit;	}
$registration_id = filter($_SESSION['AGENCYID']);
?>
<?php
date_default_timezone_set('Asia/Kolkata');
$cr_date=date('d-m-Y H:i:s');
$current_time=strtotime($cr_date);
$checking_time=strtotime("23-07-2019 23:59:00");
$closetime = strtotime("20-04-2021 23:55:00");
$covid_report_link = "Y";
?>
<?php 

if(($_REQUEST['action']=='unregister') && ($_REQUEST['agency-visitor']!=''))
{
	$pan_no = base64_decode(filter($_REQUEST['agency-visitor']));	
	
	$modified_at = date("Y-m-d H:i:s");
	 $sql = "DELETE FROM visitor_agency_registration  WHERE agency_id='$registration_id' AND pan_no='$pan_no'";
	$result = $conn->query($sql);
	if($result){
	  echo"<meta http-equiv=refresh content=\"0;url=vendor-agency-dashboard.php?action=view\">";
	} else {
		echo "<script langauge=\"javascript\">alert(\"Invalid Request\");</script>";
	
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>My Dashboard</title>
		<link rel="shortcut icon" href="images/fav.png" />
<link rel="stylesheet" type="text/css" href="https://gjepc.org/assets-new/css/bootstrap.min.css" />
		<link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Cabin'>
		<link rel="stylesheet" type="text/css" href="css/general.css?v=<?php echo $version;?>" />
		<link rel="stylesheet" type="text/css" href="css/inner_pg_style.css?v=<?php echo $version;?>" />
		<link rel="stylesheet" type="text/css" href="css/jquery.fancybox.min.css?v=<?php echo $version;?>" />
		<link rel="stylesheet" type="text/css" href="css/responsive.css?v=<?php echo $version;?>" />
		<link rel="stylesheet" type="text/css" href="css/visitor_reg.css?v=<?php echo $version;?>" />
		<link rel="stylesheet" type="text/css" href="css/media_query.css?v=<?php echo $version;?>" />

		<script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>
		<script type="text/javascript" src="js/jquery.fancybox.min.js?v=<?php echo $version;?>"></script>
		<!--NAV-->
		<link href="css/flexnav.css?v=<?php echo $version;?>" media="screen, projection" rel="stylesheet" type="text/css">
		<script type="text/javascript" src="flexnav-master/js/jquery.flexnav.min.js"></script>
		<script src="js/common.js"></script>
		 <script src="jsvalidation/jquery.validate.js" type="text/javascript"></script>
		<!--NAV-->
		<!-- UItoTop plugin -->
		<link rel="stylesheet" type="text/css" media="screen,projection" href="css/ui.totop.css" />
		<script src="js/easing.js" type="text/javascript"></script>
		<script src="js/jquery.ui.totop.js" type="text/javascript"></script>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-178505237-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-178505237-1');
</script>
<script> gtag('event', 'conversion', {'send_to': 'AW-679056788/N1zUCJPKxLsBEJSr5sMC'}); </script> 
		<script type="text/javascript">
		$(document).ready(function() {
		$().UItoTop({ easingType: 'easeOutQuart' });
		});
		</script>
		<style>
		.member_type {float: right;margin-top: -70px;width: auto; height: auto; background: #a59c5b; } .member_type img{ display: inline-block; width: 35px; background: #a59c5b;margin-top: -1px; margin-right: -4px;} .member_type span{padding: 10px 15px;background: #a59459; font-weight:bold; color:#fff;}.btn{padding:10px 15px; text-align: center;/*margin-right: 8px;*/ border-radius: 5px;background: #000;color: #fff;	transition: all 0.4s ;margin: 10px 10px	} .btn:hover{background: #a59c5b;color:#000;} .box_dash_container{position: relative; margin-bottom:30px;} .box_dash_container .box_title {position: absolute; text-align: center; left: 0; right:0; z-index: 1; top: -22px; } .box_dash_container .box_title h3{display: inline-block; background:#fff; padding:0 10px;}.box_exhibitor{flex-flow: column;padding-top: 30px;padding-bottom: 30px} #form-horizontal{margin: 20px 0; } .form-group{display: flex; flex-flow: row;justify-content: space-between;margin-bottom: 15px} .box_dash a {position:relative;padding: 15px 20px 25px 20px; font-size:13px;} .box_dash a span {position:absolute;bottom: -10px;max-width: 50px;margin: 0 auto;font-size: 12px;background: #fff;border: 2px solid #ddd;/* padding:0 10px; */line-height: 20px;color: #444;border-radius: 100px;font-weight:bold;left: 0;right: 0;} @media screen and (max-width: 768px) { .box_dash{flex-wrap: wrap;} }.box-shadow{ padding:0; }.mt-3{margin-top: 30px}.p-2{padding: 20px}input[type="radio" i] {margin: -6px 0px 0 0;}.radioInput label{display: inline}.mt-2{margin-top: 20px}.label{padding: 5px;color: #fff!important; font-size: 12px;border-radius: 3px}.danger{background: #d9534f}.warning{background: #f0ad4e}.success{background: #5cb85c}
	    </style>
	    <link rel="stylesheet" type="text/css" href="css/form.css?v=<?php echo $version;?>"/>
</head>

<body>
		<div class="wrapper">
			<div class="header">
				<?php include('header1.php'); ?>
			</div>
			
			<div class="inner_container">
				<div class="bold_font text-center">
					<div class="d-block">
						<img src="https://www.gjepc.org/assets/images/gold_star.png" class="">
					</div>
					My Dashboard
				</div>			
				<div class="content_area box-shadow">
					<div class="box_title text-center">
						<h3>Agency / Vendor Visitor Registration</h3>
					</div>
					<div class='d-block mt-3 text-center '>
						<?php if(isset($_REQUEST['action']) && $_REQUEST['action']=='view'){?>
							<a href="vendor-agency-dashboard.php?action=addnew" class="btn  ">Add Visitor</a>
						<?php }else if(isset($_REQUEST['action']) && $_REQUEST['action']=='addnew'){?>
							<a href="vendor-agency-dashboard.php?action=view" class="btn  ">View Visitors</a>
						<?php }else if($_REQUEST['action']=="upload-covid-report"){?>
							<a href="vendor-agency-dashboard.php?action=addnew" class="btn  ">Add Visitor</a>
							<a href="vendor-agency-dashboard.php?action=view" class="btn  ">Back </a>
						<?php }else{?>
							<a href="vendor-agency-dashboard.php?action=addnew" class="btn  ">Add Visitor</a>
						<?php }?>							
					</div>
					<div class="tabb_link mt-3">
			    	
			    	<div class="clear"></div>
			    	</div>  
			    	<?php if(isset($_REQUEST['action']) && $_REQUEST['action']=='addnew'){?>

			    		<?php
                         $companyData = $conn->query("SELECT * FROM visitor_agency_master WHERE `id`='$registration_id'");
                         $rowcompanyData = $companyData->fetch_assoc();
                         $isDocument = $rowcompanyData['isDocument'];

			    		?>
                        <form class="p-2" method="POST" name="regisForm" id="regisForm" enctype="multipart/form-data" autocomplete="off">
						<input type="hidden" name="action" value="agency-visitor-add-action">
						 <div class="clear"></div>
					    <div class="d-block col-100">
					    	<h3>Personal Details</h3>
					    </div>
						<div class="field">
					        <label>Company Name : <sup>*</sup><br />&nbsp;</label>
					        <input name="agency_name" id="agency_name" type="text" class="textField" <?php if($_SESSION['CATEGORYID']!=5){?> value="<?php echo $_SESSION['COMPANYNAME']?>" readonly <?php }?> autocomplete="off"  />
					    </div>
					    <div class="field">
					        <label>Contact Person Name : <sup>*</sup><br />&nbsp;</label>
					        <input name="person_name" id="person_name" type="text" class="textField" value="<?php echo $person_name;?>" autocomplete="off"/>
					    </div>
						<div class="field">
					        <label>Contact Person Mobile Number : <sup>*</sup><br />&nbsp;</label>
					        <input name="mobile" id="mobile" type="text" class="textField" value="<?php echo $mobile;?>" maxlength='10' autocomplete="off"/>
					    </div>
					  
				        <div class="field">
						    <label>Category : <sup>*</sup><br />&nbsp; </label>
						    <input type="text"  name="categoryName" id="categoryName" value="<?php echo getVisitorAgencyCategoryName($rowcompanyData['category'],$conn);?>" class="textField" readonly="readonly">
						    <input type="hidden"  name="category" id="category" value="<?php echo getVisitorAgencyCategory($rowcompanyData['category'],$conn);?>" class="textField" readonly="readonly">
						    <!-- <select name="category" id="category" class="selectField">
						    <option value="">---Select One---</option>
						    <option value="Organiser" <?php if($category=="Organiser") echo "selected"; ?>>Organiser  </option>
						    <option value="Committee Member" <?php if($title=="Committee Member") echo "selected"; ?>>Committee Member </option>
						    <option value="Official Agency" <?php if($title=="Official Agency") echo "selected"; ?>>Official Agency </option>
						    <option value="Security" <?php if($title=="Security") echo "selected"; ?>>Security </option>
						    <option value="Guest" <?php if($title=="Guest") echo "selected"; ?>>Guest </option>
						    <option value="VVIP" <?php if($title=="VVIP") echo "selected"; ?>>VVIP </option>
						    <option value="Press" <?php if($title=="Press") echo "selected"; ?>>Press </option>
						    
						    </select> -->
						</div> 

						<div class="field" <?php if($rowcompanyData['category']=="2"){?> style="display: block;"<?php }else{?> style="display: none;" <?php }?>>
						    <label>Committee Member : <sup>*</sup><br />&nbsp; </label>
						    <select name="committee" id="committee" class="selectField">
						    <option value="">---Select One---</option>
						    <option value="C" <?php if($title=="C") echo "selected"; ?>> Chairman (All Access) </option>
						    <option value="VC" <?php if($title=="VC") echo "selected"; ?>> Vice-Chairman (All Access) </option>
						    <option value="CM" <?php if($title=="CM") echo "selected"; ?>> Committee Member </option>
						    <option value="COA" <?php if($title=="COA") echo "selected"; ?>> Committee Member (All Access) </option>
						    <option value="CO" <?php if($title=="CO") echo "selected"; ?>> Convener </option>
						    <option value="CC" <?php if($title=="CC") echo "selected"; ?>> Co-Convener </option>
						    
						    </select>
						</div>
						 <div class="field">
					        <label>Upload Photo: <sup>*</sup><br />&nbsp;</label>
					        <input name="photo" id="photo" type="file" class="textField" value="<?php echo $photo;?>" autocomplete="off"/>
					        <i>jpg,png,jpeg file type are allowed & maximum size 2MB</i>
					    </div>
					    <div class="clear"></div>
						<div class="field"  <?php if($isDocument=="yes"){?> style="display: block;"<?php }else{?> style="display: none;" <?php }?>>
						    <label>Select ID Proof :  <?php if( $isDocument =="yes"){?><sup>*</sup><?php } ?><br />&nbsp; </label>
						    <select name="id_proof_name" id="id_proof_name" class="selectField">
						    <option value="">---Select One---</option>
						    <option value="Driving License" <?php if($title=="Driving License") echo "selected"; ?>> Driving License </option>
						    <option value="Aadhar Card" <?php if($title=="Aadhar Card") echo "selected"; ?>> Aadhar Card </option>
						    <option value="Pan Card" <?php if($title=="Pan Card") echo "selected"; ?>> Pan Card </option>
						    <option value="Voter ID Card" <?php if($title=="Voter ID Card") echo "selected"; ?>> Voter ID Card </option>
						    <option value="Other" <?php if($title=="Other") echo "selected"; ?>> Other </option>
						    </select>
						</div>
						<div class="field" <?php if($isDocument=="yes"){?> style="display: block;"<?php }else{?> style="display: none;" <?php }?>>
					        <label>Upload ID Proof: <?php if( $isDocument =="yes"){?><sup>*</sup><?php } ?><br />&nbsp;</label>
					        <input name="id_proof" id="id_proof" type="file" class="textField" value="<?php echo $id_proof;?>" autocomplete="off"/>
					          <i>jpg,png,jpeg file type are allowed & maximum size 2MB</i>
					    </div>
					      <div class="field" <?php if($isDocument=="yes"){?> style="display: block;"<?php }else{?> style="display: none;" <?php }?>>
					        <label>ID Proof No. : <?php if( $isDocument =="yes"){?><sup>*</sup><?php } ?><br />&nbsp;</label>
					        <input name="pan" id="pan" type="text" class="textField" value="<?php echo $pan;?>" autocomplete="off"/>
					    </div>
					   
					     <div class="clear"></div>
					    <div class="d-block col-100">
					    	<h3>Event Details</h3>
					    </div>
                        
                        <div class="field">
						    <label>I am interested to visit : <sup>*</sup><br />&nbsp; </label>
						    <select name="payment_made_for" id="payment_made_for" class="selectField">
						     <option value="iijs21" selected="selected">IIJS Premiere 2021 Show</option>
						    </select>
						</div>
						 <div class="field">
						    <label>Amount : <sup>*</sup><br />&nbsp; </label>
						    
						    <input  name="amount" id="amount"   class="textField" value="00" readonly="readonly"  autocomplete="off"/>
						</div>

					  
						
					    <div class="clear"></div>
						<div class="col-100">
							<input type="checkbox" name="agreeWhatsapp" value="YES"> I also agree to receive information from GJEPC via Whatsapp & other Media 
               			    <label for="agree" generated="true" style="display: none;" class="error"></label>
               			     <div class="d-block"><label for="agreeWhatsapp" generated="true" class="error" style="display: none;margin-top: 10px;margin-bottom: 10px">Accept Terms And Conditions</label></div>
						</div>
						<div class="clear"></div>
						 <div class="field">
						 	<input type="submit" name="submit" id="submit" value="Submit" class="cta mt-3" style="cursor: pointer;">
						 </div>
					</form>
			        <?php }?>
			        <?php if(!isset($_REQUEST['action']) || $_REQUEST['action']=='view'){?>

			        	<?php 
                          $visitors = "SELECT * FROM visitor_agency_registration WHERE `agency_id`='$registration_id' ORDER BY modifiedDate DESC";
                          $visitorsResult = $conn->query($visitors);
                          $visitorCount =$visitorsResult->num_rows;
			        	?>
			        	<div class="d-block p-2">
			        		<h3>Registered Visitors for IIJS Premiere 2021</h3>
			        		<table class="table_responsive">
			        			<thead>
			        				<th>Sr. No.</th>
			        				<th>Person Name</th>
			        				<th>Category</th>
			        				<th>Document No.</th>
			        				<th>Mobile Number</th>
			        				<th>Vaccine Status</th>
			        				<th>Visitor Approval</th>
			        				<?php if($covid_report_link =='Y'){?>
                                    <th class="text-center">Upload Report</th>
			        				<?php } ?>
			        				
			        			</thead>
			        			<tbody>
			        				<?php if($visitorCount  > 0){?>
                                       <tbody>
                                       	<?php 

                                       	    $i = 1;
                                            while ($rowVisitors =$visitorsResult->fetch_assoc() ) {
                                            $covid_status = getCovidStatus($registration_id,$rowVisitors['id'],"CONTR",$conn);
                                            
                                            switch ($covid_status) {
                                            	case 'P':
                                            		$covid_result = "<span class=' label warning'>Pending</span>"; 
                                            		break;
                                            	case 'Y':
                                            		$covid_result = "<span class=' label success'>Approved</span>"; 
                                            		break;
                                            	case 'N':
                                            		$covid_result = "<span class=' label danger'>Disapproved</span>"; 
                                            		break;
                                          		case 'N':
                                            		$covid_result = "<span class=' label danger'>Updated</span>"; 
                                            		break;		
                                            	default:
                                            		$covid_result = "<span class=' label warning'>Pending</span>"; 
                                            		break;
                                            }

                                            switch ($rowVisitors['person_status']) {
                                            	case 'Y':
                                            		$person_status = "<span class=' label success'>Approved</span>";
                                            		break;
                                            	case 'D':
                                            		$person_status = "<span class=' label danger'>Dispproved</span>";
                                            		break;
          
                                            	default:
                                            		$person_status = "<span class=' label warning'>Pending</span>";
                                            		break;
                                            }
                                            	?>    	
                                        <tr>
                                       		<td><?php echo  $i ;?></td>
                                       		<td><?php echo $rowVisitors['person_name'];?></td>
                                       		<td><?php echo $rowVisitors['category'];?></td>
                                       		<td><?php echo $rowVisitors['pan_no'];?></td>
                                       		<td><?php echo $rowVisitors['mobile'];?></td>
                                       		<td><?php echo $covid_result;?></td>
                                       		<td><?php echo $person_status;?></td>
                                       		<?php if($covid_report_link =='Y'){?>
                                       		<td>
                                       			<?php if($rowVisitors['person_status'] =='Y'){?>
                                       				<?php 
                                                        

                                                     // if($covid_status =='P' || $covid_status =='N' || $covid_status ==''){?>
                                                         <a href="https://registration.gjepc.org/vendor-agency-dashboard.php?action=upload-covid-report&agency-visitor=<?php echo base64_encode($rowVisitors['id']);?>&agency=<?php echo base64_encode($rowVisitors['agency_id']);?>" class="cta">Upload report</a>
                                                     <?php // }else{
                                                    //   echo "<span class=' label success'>View Certificate</span>";
                                                    // }
                                       				?>
                                                   <!--   -->
                                       			<?php }?>

                                       			<?php if($rowVisitors['person_status'] !='Y'){?>
                                                   <!--  <a href="https://registration.gjepc.org/vendor-agency-dashboard.php?action=unregister&agency-visitor=<?php echo base64_encode($rowVisitors['pan_no']);?>" class="cta">Unregister</a> -->
                                       			<?php }?>


                                       			
                                       		</td>
                                       		<?php } ?>
                                       		
                                       	</tr>
                                       	<?php $i++;} ?>
                                       	
                                       </tbody>
			        			    <?php }else{?>
                                      <tbody>
                                      	<tr>
                                      		<td colspan="8">Visitors not added</td>
                                      	</tr>
                                      </tbody>
			        				<?php }?>
			        				
			        			</tbody>
			        		</table>

			        	</div>
			        <?php } ?>

			        <?php if(isset($_REQUEST['action']) && $_REQUEST['action']=='upload-covid-report' && isset($_REQUEST['agency-visitor']) ){
			             $vis_id = base64_decode($_REQUEST['agency-visitor']);
			             

			            $sqlCheckApproval = $conn->query("SELECT `person_status`,`person_name` FROM visitor_agency_registration WHERE `id`='$vis_id' AND `agency_id`='$registration_id'");
			            $rowCheckApproval =  $sqlCheckApproval->fetch_assoc();
			            
			            if($rowCheckApproval['person_status'] =='Y'){ ?>

			            	<!-- <p>Dear <strong><?php echo $rowCheckApproval['person_name'];?>,</strong>  Upload your Covid Report Here</p> -->
                   <?php include('include_vendor_vaccine_upload.php');?>
                   

			        <?php  } } ?>
					
				</div>	
			</div>
			<div class="clear" style="height:10px;"></div>
			</div>

			<div class="footer">
				<?php include('footer.php'); ?>
				<div class="clear"></div>
			</div>
			<div class="clear"></div>
		</div>
	</body>
</html>
<script>
	// $("#self-upload").hide();
	// $("#lab-upload").hide();
	$("#committeeDiv").hide();
	// $('input[name="via"]').click(function(){
 //    var via = $('[name="via"]:checked').val();
	// //alert(valueType);
	//     if(via =="self"){
	//     	$("#self-upload").slideDown();
	// 		$("#lab-upload").slideUp();
	// 		$("#labs").attr("disabled", "disabled"); 
	// 		$("#location").attr("disabled", "disabled"); 
	// 	} else { 
	// 		$("#lab-upload").slideDown();
	//     	$("#self-upload").slideUp();	
	// 		$("#labs").removeAttr("disabled");  
	// 		$("#location").removeAttr("disabled"); 
	//     }
 //    }); 

    // $("#category").change(function(){
	   //  var category = $(this).val();
	   //  if(category=="Committee Member"){
	   //  	$("#committeeDiv").show();
	   //  	$("#committee").removeAttr("disabled"); 
	   //  }else{
	   //  	$("#committeeDiv").hide();
	   //  	$("#committee").attr("disabled", "disabled");
           
	   //  }
    // }); 
    $(document).ready(function()
{   

	  var MAX_FILE_SIZE = 2 * 1024 * 1024; // 5MB
    $('input[type="file"]').change(function(){
        var fileSize = this.files[0].size;
        if (fileSize > MAX_FILE_SIZE) {
            this.setCustomValidity("File must not exceed 2 MB!");
            this.reportValidity();
        } else {
            this.setCustomValidity("");
        }
    });

   
	jQuery.validator.addMethod("panno", function (value, element) {
    var regExp = /[a-zA-z]{5}\d{4}[a-zA-Z]{1}/; 
    if (value.match(regExp) ) {
      return true;
    } else {
      return false;
    };
    },"This is not valid Pan number");
	$("#regisForm").validate({
	    rules: {
			agency_name:{
			required:true,
			},
			person_name:{
			required:true,
			},
			mobile:{
			required:true,
			minlength: 10,
	        maxlength:10
			},
			category:{
			required:true,
			},
			<?php if($rowcompanyData['category']=='2'){?>
            committee:{
			required:true,
			},
			<?php }?>
			
			payment_made_for:{
			required:true,
			},
			agreeWhatsapp:{
			required:true,
			},
            <?php if( $isDocument =="yes"){?>
        	id_proof_name:{
			required:true,
			},
			pan:{
			required:true,
			},
			id_proof:{
			required:true,
			accept:"jpg,png,jpeg,pdf"
			},
            <?php } ?>
			photo:{
			required:true,
			accept:"jpg,png,jpeg,pdf"
			}
	    },
	    messages: {
			agency_name:{
			required: "Check Company Name",
			},
			person_name:{
			required: "Person Name is required",
			},
			mobile:{
			required: "Mobile number is required",
			minlength:"Please Enter 10 digit  Mobile NO",
	        maxlength:"Please Enter 10 digit Mobile NO"
			},
			category:{
			required: "Select Person category",
			},
			<?php if($rowcompanyData['category']=='2'){?>
			committee:{
			required:"Select Committee Person designation",
			},
			<?php }?>
			
			
			payment_made_for:{
			required:"Select event",
			},
			agreeWhatsapp:{
			required:"Accept Terms And Conditions",
			},
            <?php if( $isDocument =="yes"){?>
            id_proof_name:{
			required:"Select ID Proof name",
			},
			pan:{
			required:"Enter Id proof Number",
			},
			id_proof:{
			required:"Select ID Proof ",
			accept:"Please select only jpg,png,jpeg,pdf file "
			},

			 <?php } ?>
			photo:{
			required:"Select Photo ",
			accept:"Please select only jpg,png,jpeg,pdf file "
			},
		},
		submitHandler: agencyVisitorAdd	
    });     
	    $("#covidReportForm").validate({
		    rules: {
				agreeCovid:{
				required:true,
				},
				agreeNegative:{
				required:true,
				},
				self_report:{
				required:true,
				accept:"jpg,png,jpeg,pdf"
				},
				certificate:{
				required:true,
				}
		    },
		    messages: {
				agreeCovid:{
				required:"Accept Terms And Conditions",
				},
				agreeNegative:{
				required:"Accept Terms And Conditions",
				},
				self_report:{
				required:"Select Report",
				accept:"Please select only jpg,png,jpeg,pdf file "
				},
				certificate:{
				required:"Select Certificate ",
			
				}
			},
			submitHandler: covidReportUpload	
	    });     
    });	

    function agencyVisitorAdd(){
	    var form = $('#regisForm');
	    var formdata = false;
	    if (window.FormData){
	        formdata = new FormData(form[0]);
	    }
	    $.ajax({
	    type:'POST',
	    url:"visitor-agency-ajax.php",
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
				alert(data.message);   
				$("#regisForm")[0].reset();
			    window.location.href='https://registration.gjepc.org/vendor-agency-dashboard.php?action=view';
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
    function covidReportUpload(){
	    var form = $('#covidReportForm');
	    var formdata = false;
	    if (window.FormData){
	        formdata = new FormData(form[0]);
	    }
	    $.ajax({
	    type:'POST',
	    url:"visitor-agency-ajax.php",
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
				alert(data.message);   
				$("#covidReportForm")[0].reset();
			    window.location.href='https://registration.gjepc.org/vendor-agency-dashboard.php?action=view';
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
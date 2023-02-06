<?php 
include('header_include.php');
$uid = $_SESSION['uid'];
$eid = $_SESSION['eid'];
if(empty($uid)){ header("location:single_intl_registration.php"); }

$sql  = "SELECT verified FROM ivr_registration_details WHERE eid='$eid' AND uid= '$uid'";
$resultm = $conn->query($sql);
$count = $resultm->num_rows;
if($count > 0 ){
$getData = $resultm->fetch_assoc();
$isVerified = $getData['verified'];
if($isVerified == 0){
header("location:single_intl_registration.php");
}
} else { header("location:intl_covid-registration.php"); } 

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome to IIJS SIGNATURE </title>
<link rel="shortcut icon" href="images/fav.png" />
	<link rel="stylesheet" type="text/css" href="css/mystyle.css" />
	<link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Cabin'>
	<link rel="stylesheet" type="text/css" href="css/general.css" />
	<link rel="stylesheet" type="text/css" href="css/inner_pg_style.css" />
	 
	<link rel="stylesheet" type="text/css" href="css/responsive.css" />
	<link rel="stylesheet" type="text/css" href="css/media_query.css" />
	<link rel="stylesheet" type="text/css" href="css/visitor_reg.css?v=<?php echo $version;?>" />
	<link rel="stylesheet" type="text/css" href="css/jquery.fancybox.min.css?v=<?php echo $version;?>" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>
	<script type="text/javascript" src="js/jquery.fancybox.min.js?v=<?php echo $version;?>"></script>
	<!--NAV-->
	<link href="css/flexnav.css" media="screen, projection" rel="stylesheet" type="text/css">
	<script src="js/jquery.flexnav.js" type="text/javascript"></script>
	<script src="js/common.js"></script> 
	<!--NAV-->
	 <script src="jsvalidation/jquery.validate.js" type="text/javascript"></script>

	<!-- UItoTop plugin -->
	<link rel="stylesheet" type="text/css" media="screen,projection" href="css/ui.totop.css" />
	<script src="js/easing.js" type="text/javascript"></script>
	<script src="js/jquery.ui.totop.js" type="text/javascript"></script>    
	<script type="text/javascript">
		$(document).ready(function() {        
			$().UItoTop({ easingType: 'easeOutQuart' });        
		});
	</script>
	<style type="text/css">
		.container_wrap{  border: 1px solid#aa9e5f;}
		.error{color:red;}
	</style>

</head>

<body>
<div class="wrapper">

<div class="header">
	<?php include('header1.php'); ?>
</div>
<!--container starts-->

<?php
$show ="SIGNATURE 2021";
?>

		<div class="container">
			<div class="border w-100"></div>
			<div class="row mt-5">
	
				<div class="col-12 mt-3">
					
					<p class="text-center font-weight-bold">RT-PCR Test report (Covid-19 test)</p>
		            <p class="text-center font-weight-bold">It is mandatory to submit RT-PCR test report 72 hours before visit date</p>
					<div class="container_wrap">
			<div class="container" id="manualFormContainer">
			
			<div id="formWrapper" class="py-5 " style="position: relative;">

			
			<form method="POST" name="regisForm" id="regisForm" enctype="multipart/form-data" autocomplete="off">
				 <div class="loaderWrapper">
        <div class="formLoader">
         <img src="images/formloader.gif" alt="">
          <p> Please Wait....</p>
       </div>
       </div>
			<input type="hidden" name="action" value="UpdateCovidReport"/>	
			<input type="hidden" name="uid" value="<?php echo $uid;?>"/>	
			<input type="hidden" name="eid" value="<?php echo $eid;?>"/>	
			<div class="row">
		<!-- 		<div class="col-12">
					<label class="d-inline-block mr-5">
						<input type="radio" id="self" name="valueType" value="self"/>&nbsp;&nbsp;Self Upload
					</label>
					<label>
						<input type="radio" id="lab" name="valueType" value="lab"/>&nbsp;&nbsp;Upload Via Lab
					</label>
				</div> -->
				<!-- <div class="col-12">
					<label for="valueType" generated="true" class="error d-none">Select any one of the above</label>
				</div>		 -->	
					<div class="col-12 mb-2"  >
					
					<div class="form-group row">
						<div class="col-lg-6">
							<div class="row">
								<div class="col-12">
									<label>Are you uploading ? </label>
								</div>
								<div class="col-12">
									 <label style="display:inline;"><input type="radio" name="certificate" value="rtpcr">&nbsp;<span>RT-PCR</span></label>&nbsp;&nbsp;
					        <label style="display:inline;"><input type="radio" name="certificate" value="vaccine">&nbsp;<span>Vaccine certificate</span></label>
								</div>
							</div>
							
						   
					        <div>
					        	<label for="certificate" generated="true" class="error" style="display: none;margin-top: 5px"> </label>
					        </div>
						</div>
						
					</div>
				</div>	
				<div class="col-12 mb-2"  >
					<p class="font-weight-bold">I will upload RT-PCR test report myself</p>
					<div class="form-group row">
						<div class="col-6">
							<label>Upload COVID Report: </label>
						    <input type="file" name="self_report" id="self_report" class="form-control" style="height: auto;" accept=".pdf,.png,.jpg,.jpeg">
						</div>
						
					</div>
				</div>
			<!-- 	<div class="col-12 mb-2" id="company-wise" style="display: none">
					  
							<div class="row">
								<div class="col-12">
									<p class="font-weight-bold">I would like to do RT-PCR testing via SRL Labs  <a data-fancybox data-src="#modals" href="javascript:;" id="Offers" class="cta">Click here to View Offers</a></p>
								</div>
								<div class="form-group col-sm-6">
									<label class="form-label" for="location"><p>Select Lab: </p></label>
									<select name="labs" id="labs" class="form-control" style="width:100%">
										
										<option value="srl" <?php if($lab=="lab") echo "selected"; ?>>SRL Diagnostics</option>
									</select>
								</div>
								
								<div class="form-group col-sm-6">
									<label class="form-label" for="location"><p>Lab Location </p></label>
									<select name="location" id="location" class="form-control" style="width:100%">
										<option value="">--- Please Select Lab Location ---</option>
										<?php
										$city= "SELECT * FROM `cities` order by city_name asc";
										$cityquery = $conn->query($city);
										while($row1 = $cityquery->fetch_assoc()){?>
										<option value="<?php echo $row1['city_name'];?>"><?php echo strtoupper($row1['city_name']);?></option>
										<?php }	?>
									</select>		
								</div>
							
					</div>
				</div> -->
				<div class="col-12">
                  <input type="checkbox" name="agreeCovid" value="YES"> I declare that my COVID report is negative
                <label for="agreeCovid" generated="true" style="display: none;" class="error"></label>
				</div>
				<div class="col-12">
                  <input type="checkbox" name="agree" value="YES"> I declare that my covid report can be share with GJEPC
                <label for="agree" generated="true" style="display: none;" class="error"></label>
				</div>

				<div class="col-12 mt-3">
					<input type="submit" name="submit" id="submit" value="Submit" class="cta">
				</div>
			</div>
			
			</form>
			
			</div>
			
			<div class="clear"></div>
			</div>
		</div>
				</div>
			</div>
		</div>
</div>
 <div style="display: none;" id="modals">
            <h1 align="center" class="mb-2 blue" >Offers</h1>
<table class="table_responsive"><thead><tr class="tableizer-firstrow"><th>City</th><th>Walk-in ( Yes/No ) if Yes pls give the address</th><th>Home Collection ( Yes/No)</th><th>Offered Price</th></tr></thead><tbody><tr><td>Agra </td><td>NO</td><td>YES</td><td>800</td></tr><tr><td>Aligarh</td><td>NO</td><td>YES</td><td>800</td></tr><tr><td>Amritsar</td><td>YES</td><td>YES</td><td>700</td></tr><tr><td>BANGALORE</td><td>NO</td><td>YES</td><td>800</td></tr><tr><td>Bareilly</td><td>YES</td><td>YES</td><td>800</td></tr><tr><td>Chandigarh</td><td>NO</td><td>YES</td><td>900</td></tr><tr><td>CHENNAI</td><td>YES</td><td>YES</td><td>1200</td></tr><tr><td>Dehradun</td><td>NO</td><td>YES</td><td>500</td></tr><tr><td>Delhi</td><td>YES</td><td>NO</td><td>1000</td></tr><tr><td>Deoghar</td><td>NO</td><td>YES</td><td>600</td></tr><tr><td>Dibrugarh</td><td>YES</td><td>YES</td><td>1000</td></tr><tr><td>Gorakhpur</td><td>NO</td><td>YES</td><td>800</td></tr><tr><td>Goa</td><td>YES</td><td>YES</td><td>900</td></tr><tr><td>Gurgaon</td><td>YES</td><td>NO</td><td>699</td></tr><tr><td>Guwahati</td><td>YES</td><td>YES</td><td>1000</td></tr><tr><td>GWALIOR</td><td>NO</td><td>YES</td><td>900</td></tr><tr><td>HALDWANI</td><td>YES</td><td>YES</td><td>500</td></tr><tr><td>Hyderabad</td><td>YES</td><td>YES</td><td>600</td></tr><tr><td>Imphal</td><td>YES</td><td>YES</td><td>1200</td></tr><tr><td>Indore</td><td>YES</td><td>YES</td><td>900</td></tr><tr><td>Jabalpur</td><td>NO</td><td>YES</td><td>900</td></tr><tr><td>Jalandhar</td><td>YES</td><td>YES</td><td>900</td></tr><tr><td>Jammu</td><td>YES</td><td>YES</td><td>1400</td></tr><tr><td>Kolhapur</td><td>YES</td><td>YES</td><td>850</td></tr><tr><td>Kolkata</td><td>YES</td><td>YES</td><td>950</td></tr><tr><td>Lucknow</td><td>NO</td><td>YES</td><td>800</td></tr><tr><td>Ludhiana</td><td>YES</td><td>YES</td><td>900</td></tr><tr><td>Meerut</td><td>NO</td><td>YES</td><td>800</td></tr><tr><td>Moradabad</td><td>YES</td><td>YES</td><td>800</td></tr><tr><td>Mumbai</td><td>YES</td><td>NO</td><td>800</td></tr><tr><td>Muzzafarnagar</td><td>YES</td><td>YES</td><td>800</td></tr><tr><td>Nagpur</td><td>YES</td><td>YES</td><td>850</td></tr><tr><td>Navi Mumbai</td><td>YES</td><td>NO</td><td>850</td></tr><tr><td>Prayagraj</td><td>NO</td><td>YES</td><td>800</td></tr><tr><td>Pune</td><td>YES</td><td>YES</td><td>850</td></tr><tr><td>Raipur</td><td>YES</td><td>YES</td><td>800</td></tr><tr><td>Rishikesh</td><td>NO</td><td>YES</td><td>500</td></tr><tr><td>Silchar</td><td>YES</td><td>YES</td><td>1000</td></tr><tr><td>Ujjain</td><td>NO</td><td>YES</td><td>900</td></tr><tr><td>Varanasi</td><td>NO</td><td>YES</td><td>800</td></tr><tr><td>Vizag</td><td>NO</td><td>YES</td><td>499</td></tr></tbody></table>
                  
              </div>
<?php include ('footer.php'); ?>

<script type="text/javascript">
	// 		$('input[name="valueType"]').click(function(){
	// 	    var valueType = $('[name="valueType"]:checked').val();
		
	// 	    if(valueType =="self"){
	// 	    	$("#specific-company").slideDown();
	// 			$("#company-wise").slideUp();
	// 			$("#labs").attr("disabled", "disabled"); 
	// 			$("#location").attr("disabled", "disabled"); 
	// 			$("#self_report").removeAttr("disabled"); 

	// 			} else { 
	// 			$("#company-wise").slideDown();
	// 	    	$("#specific-company").slideUp();	
	// 			$("#labs").removeAttr("disabled");  
	// 			$("#location").removeAttr("disabled"); 
	// 			$("#self_report").attr("disabled", "disabled"); 

	// 			}
 // });     
</script>

<script type="text/javascript">
$(document).ready(function()
{   
	$("#regisForm").validate({
    rules: {
		// valueType:{
		// required:true,
		// },
		// labs:{
		// required:true,
		// },
		// location:{
		// required:true,
		// },
		agree:{
		required:true,
		},
		agreeCovid:{
		required:true,
		},
		self_report:{
		required:true,
		accept:"pdf,jpg,png"
		// extension: "jpg,jpeg,pdf,png",
  //       filesize: 2,
		},
		certificate:{
		required:true,
		}
    },
    messages: {
		// valueType:{
		// required: "Select any one of the above",
		// },
		// labs:{
		// required: "Lab Name required",
		// },
		// location:{
		// required: "Location required",
		// },
		agree:{
		required: "Required",
		},
		agreeCovid:{
		required: "Required",
		},
		self_report:{
		required:"Select Report",
		accept:"Please select only pdf,jpg,png file "
		},
		certificate:{
		required:"Select Certificate ",
	
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
	    url:"singleINTLVisitorAjax.php",
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
			    window.location = "intl_covid-registration.php";
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

<!--footer ends-->
</body>
</html>
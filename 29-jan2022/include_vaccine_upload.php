<?php 
$sqlx = "SELECT * FROM visitor_lab_info WHERE registration_id='$registration_id' AND visitor_id='$visitor_id'" ;
$resultx = $conn->query($sqlx);
$countx = $resultx->num_rows;
$rowx = $resultx->fetch_assoc();

$vaccine_approval = $rowx['approval_status'];
$certificate = $rowx['certificate'];

if($certificate =="dose1"){
	//$messageVacccine = "It is compulsory to carry Covid-19 Negative Report (RT PCR Test) done before 72 hrs before your first visit at IIJS SIGNATURE 2022.";
	$messageVacccine = "All the visitors visiting the exhibition should be fully vaccinated.";
}else{
	//$messageVacccine ="We will update you After approval of your vaccination certificate, Your Digital badge will be available soon on GJEPC APP.";
	$messageVacccine ="We will update you on vaccination certificate approval soon";
}

if($certificate =="booster_dose"){
	$reportPath = 'https://registration.gjepc.org/images/covid/vis/'.$registration_id.'/vaccine_certificate/'.$rowx['booster_dose'].'';
} else {
    $reportPath = 'https://registration.gjepc.org/images/covid/vis/'.$registration_id.'/vaccine_certificate/'.$rowx['dose2'].'';
}                	
?>

<div class="container">
	<div class="row">
			<div class="container" id="manualFormContainer">
<!-- 				<h4 class="text-center mt-4"> Vaccination Certificate Upload</h4> -->
				<div id="formWrapper" class="box-shadow">
					<?php if($vaccine_approval =="P" || $vaccine_approval=="U" ){ ?>
					<div class="col-12">
						<div class="alert alert-success" role="alert"><?php echo $messageVacccine;?></div>
					</div>
					<?php } else if($vaccine_approval=="Y" ){ ?>
						<?php if( $certificate =="dose2"){ ?>
                       <div class="row">
                    	<div class="col-12">
                    		<div class="alert alert-success" role="alert">Status: <b><?php echo $rowx['remark'];?>Approved</b></div>
                    	</div>
						<div class="col-12">                    		
                    		<div class="alert alert-success" role="alert">Certificate: <b><?php echo strtoupper($certificate);?></b></div>
                    	</div>
                    	<div class="col-12">                    		
                    		<a href="<?php echo $reportPath ; ?>" target="_blank"><div class="alert border cta" role="alert">View Certificate <i class="fa fa-eye"></i> </div></a>
                    	</div>
                    </div>
                 	<?php } ?>
                  <?php if( $certificate =="booster_dose"){ ?>
                       <div class="row">
                    	<div class=" col-12 ">
                    		<div class="alert alert-success" role="alert">Status: <b>Approved</b></div>
                    	</div>
                    	<div class="col-12">                    		
                    		<div class="alert alert-success" role="alert">Certificate: <b><?php echo strtoupper($certificate);?></b></div>
                    	</div>
                    	<div class="col-12">                    		
                    		<a href="<?php echo $reportPath ; ?>" target="_blank"><div class="alert border cta" role="alert">View Certificate <i class="fa fa-eye"></i> </div></a>
                    	</div>                    	
                    </div> 
						<?php } ?>
 
					<?php } else { ?>
					<?php if($vaccine_approval =="N" ){ ?>
                    <div class="row">
                    	<div class=" col-12 ">
                    		<div class="alert alert-warning" role="alert"><?php echo $rowx['remark'];?></div>                    		
                    	</div>
                    	<div class="col-12">                    		
                    		<a href="<?php echo $reportPath ; ?>" target="_blank"><div class="alert border cta" role="alert">View Certificate <i class="fa fa-eye"></i> </div></a>
                    	</div>
                    </div>
					<?php } ?>
                   
                   					
					<form method="POST" name="regisForm" id="regisForm">
						<input type="hidden" name="action" value="UpdateCovidReport"/>
						<input type="hidden" name="registration_id" value="<?php echo $registration_id;?>"/>
						<input type="hidden" name="visitor_id" value="<?php echo $visitor_id;?>"/>
						<input type="hidden" name="pan_no" value="<?php echo $visitorPAN;?>"/>
						<input type="hidden" name="mobile_no" value="<?php echo $visitorMobile;?>"/>
						<div class="row">
							<div class="col-12 ">
								<label class="d-block">Select vaccine</label>
								<!--<label class="d-inline-block mr-5">
									<input type="radio" id="dose1" name="valueType" value="dose1"/>&nbsp;&nbsp;First Dose 
								</label>-->
								<label>
									<input type="radio" id="dose2" name="valueType" value="dose2"/>&nbsp;&nbsp;Second Dose (Final Vaccination)
								</label>
								<label class="d-inline-block mr-5">
									<input type="radio" id="dose3" name="valueType" value="booster_dose"/>&nbsp;&nbsp;Booster Dose 
								</label>
							</div>
							<div class="col-12 form-group">
								<label for="valueType" generated="true" class="error d-none">Select any one of the above</label>
							</div>
						
							<div class="col-12 form-group" id="vaccine-upload">								
								<div class="row">									
									<div class="form-group col-sm-6">
										<label id="for_vaccine_certificate"> </label>
										<input type="file" name="vaccine_certificate" class="form-control" id="vaccine_certificate">
										<i>(only pdf,png,jpg,jpeg file and maximum 2mb size allowed)</i>
									</div>
								</div>
							</div>
							<div class="col-12 mb-2">
								<div class="d-block">

									<input type="checkbox" name="agree" value="YES"> <strong> I Accept That</strong>

									<ul class="inner_under_listing mt-3">
										<li>I have read and understood the <a href="pdf/<?php echo $evt_term_condition_file; ?>" target="_blank"><strong>terms and conditions</strong></a> with regard to the visitor's registration at <?php echo $evt_name; ?></li>
										<li>I confirm that the upload vaccination certificate is genuine and valid.</li>
										<li>I agree to abide by the terms and conditions applicable for domestic visitor's registration set by "The Gem & Jewellery Export Promotion Council (GJEPC)".</li>
										<li>I accept that GJEPC reserves the rights of admission to the show.</li>
										<li>All the visitors visiting the exhibition should be fully vaccinated.</li>
									</ul>

								
								</div>
								
								<label for="agree" generated="true" style="display: none;" class="error"></label>
							</div>
							<div class="col-12">
								<input type="submit" name="submit" id="submit" value="Submit" class="cta">
							</div>
						</div>
						
					</form>
<?php } ?>	
				</div>
				<div class="clear"></div>
			</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
	    $("#vaccine-upload").hide();
		$('input[name="valueType"]').click(function(){
			var valueType = $('[name="valueType"]:checked').val();
			$("#vaccine-upload").show();

			if(valueType =="dose1"){
              $("#for_vaccine_certificate").html('Attatch First dose vaccine certificate');
			} else {
              $("#for_vaccine_certificate").html('Attatch Second dose vaccine certificate');
				
			}
		});
	});
	
</script>
<script type="text/javascript">
$(document).ready(function()
{
	$("#regisForm").validate({
rules: {
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
		valueType:{
		required: "Select any one of the above",
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
		    url:"visitor-covid-report-upload-ajax.php",
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
					    window.location = "single_visitor.php";
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
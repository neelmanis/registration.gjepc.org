<?php 
//include('header_include.php');
/*$uid = $_SESSION['uid'];
$eid = $_SESSION['eid'];
$email = $_SESSION['email'];
*/
if(empty($uid)){ header("location:single_intl_registration.php"); }

$sqlx = "SELECT * FROM visitor_lab_info WHERE registration_id='$uid' AND visitor_id='$eid'"; 
$resultx = $conn->query($sqlx);
$countx = $resultx->num_rows;
$rowx = $resultx->fetch_assoc();

$vaccine_approval = $rowx['approval_status'];
$certificate = $rowx['certificate'];
if($certificate =="dose1"){
	$messageVacccine = "It is compulsory to carry Covid-19 Negative Report(RT PCR Test) done before 72 hrs of your first scheduled entry at IIJS Premiere 2021.";
} else {
	$messageVacccine ="Please download your E-badge from GJEPC app post approval of your final vaccination certificate.";
}

if($certificate =="dose1"){
	$reportPath = 'https://registration.gjepc.org/images/covid/intl/'.$uid.'/vaccine_certificate/'.$rowx['dose1'].'';
} else {
    $reportPath = 'https://registration.gjepc.org/images/covid/intl/'.$uid.'/vaccine_certificate/'.$rowx['dose2'].'';
}
?>


<div class="container">
	<div class="row ">
		
			<div class="container" id="manualFormContainer">
				<h4 class="text-center mt-4"> Vaccination Certificate Upload</h4>
				<div id="formWrapper" class="p-5 border w-100">
					<?php if($vaccine_approval =="P" || $vaccine_approval=="U" ){ ?>
					<div class="col-12">
						<div class="alert alert-warning" role="alert"><?php echo "Your Vaccination Certificate has been pending from admin";?></div>
						<div class="alert alert-success" role="alert"><?php echo $messageVacccine;?></div>
						
					</div>
					<?php } else if($vaccine_approval=="Y" && $certificate =="dose2"){?>
                       <div class="row">
                    	<div class=" col-12 ">
                    		<div class="alert alert-success" role="alert">Status: <b>Approved</b></div>
                    	</div>
                    	<div class=" col-12 ">
                    		
                    		<a href="<?php echo $reportPath ; ?>" target="_blank"><div class="alert border cta" role="alert">View Certificate <i class="fa fa-eye"></i> </div></a>
                    	</div>
                    </div> 
					<?php }else{?>

						<?php if($vaccine_approval =="N" ){?>
                    <div class="row">
                    	<div class=" col-12 ">
                    		<div class="alert alert-warning" role="alert">Status: <b>Disapproved</b></div>
                    		<div class="alert alert-warning" role="alert">Remark: <?php echo $rowx['remark'];?></div>
                    	</div>
                    </div>
					<?php }?>
					<?php if($vaccine_approval=="Y" && $certificate =="dose1"){?>
                       <div class="row">
                    	<div class=" col-12 ">
                    		<div class="alert alert-success" role="alert">Status: <b><?php echo $rowx['remark'];?>Approved</b></div>
                    	</div>
                    	<div class=" col-12 ">
                    		
                    		<div class="alert alert-success" role="alert">Certificate: <b><?php echo $certificate;?></b></div>
                    	</div>
                    	<div class=" col-12 ">
                    		
                    		<a href="<?php echo $reportPath ; ?>" target="_blank"><div class="alert border cta" role="alert">View Certificate <i class="fa fa-eye"></i> </div></a>
                    	</div>
                    	
                    </div> 
					<?php } ?>
					
					<form method="POST" name="regisForm" id="regisForm">
						<input type="hidden" name="action" value="UpdateCovidReport"/>
						<input type="hidden" name="uid" value="<?php echo $uid;?>"/>
						<input type="hidden" name="eid" value="<?php echo $eid;?>"/>
						<input type="hidden" name="email" value="<?php echo $email;?>"/>
						<div class="row">
							<div class="col-12">
								<label class="d-block">Select vaccine dose</label>
								<label class="d-inline-block mr-5">
									<input type="radio" id="dose1" name="valueType" value="dose1"/>&nbsp;&nbsp;First Dose 
								</label>
								<label>
									<input type="radio" id="dose2" name="valueType" value="dose2"/>&nbsp;&nbsp;Second Dose
								</label>
							</div>
							<div class="col-12">
								<label for="valueType" generated="true" class="error d-none">Select any one of the above</label>
							</div>
						
							<div class="col-12 mb-2" id="vaccine-upload" >
								<div class="row">
									<div class="form-group col-sm-6">
										<label id="for_vaccine_certificate"> </label>
										<input type="file" name="vaccine_certificate" class="form-control" id="vaccine_certificate">
										<i>(PDF,JPG,PNG,JPEG maximum 2mb size allowed)</i>
									</div>
								</div>
							</div>
							<div class="col-12 mb-2">
								<div class="d-block">
									<input type="checkbox" name="agree" value="YES"> I Accept that <br/>
									<p>1. I have read and understood the 
									<a href="pdf/Visitor-Terms-Conditions-IIJS-Premiere-2021.pdf" target="_blank"><strong>terms and conditions </strong></a> with regard to the visitor's registration at IIJS Premier 2021, BIEC, Bengaluru.<br/>
2.	I confirm that the upload vaccination certificate is genuine and valid.<br/>
3.	I agree to abide by the terms and conditions applicable for domestic visitor???s registration set by "The Gem & Jewellery Export Promotion Council (GJEPC)".<br/>
4.	I accept that GJEPC reserves the rights of admission to the show. <br/>
</p>
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
              $("#for_vaccine_certificate").html('Attach First dose vaccine certificate');
			} else {
              $("#for_vaccine_certificate").html('Attach Second dose vaccine certificate');
				
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
		accept:"pdf,jpg,png,jpeg"
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
		accept:"Please select only pdf,jpg,png,jpeg file"
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
		    	$('.loaderWrapper').delay(2000).fadeOut();
			    if(data.status == 'success'){
			    	$("#regisForm")[0].reset();
	
					$("#formWrapper").html('<div class="col-12"><div class="alert alert-success" role="alert">'+data.message+'</div></div>');
					 setTimeout(function(){
					    window.location = "single_intl_registration.php";
					  },10000)
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
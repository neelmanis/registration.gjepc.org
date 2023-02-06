<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <title>Verify GSTIN Advances detail</title>
</head>

<?php
if(isset($_POST['submit']))
{
$gstin_no = $_POST['gstin_no'];

		$fieldsArr = '{
			"data": 
			{
			"business_gstin_number": "'.$gstin_no.'",
			"consent": "Y",
			"consent_text": "Approve the values here"
			}
			}';
		
		$headers = array(
		    "auth: false",
            "app-id: 61dd9a0d1acfae001ddde527",
			"api-key: F69KN53-A384XAC-KHX20F5-D4AF852",
            "Content-Type: application/json"
        );
		  $curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://test.zoop.one/api/v1/in/merchant/gstin/advance',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => $fieldsArr,
  CURLOPT_HTTPHEADER => $headers,
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;
}
?>
<body>
<!--https://github.com/abhi11verma/PANverify/tree/master/API-->
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="pan-lite.php">PAN Lite Verification</a>
      <a class="navbar-brand" href="pan-advance.php">PAN Advance Verification</a>
      <a class="navbar-brand" href="gstin-lite.php">GST Lite Verification</a>
      <a class="navbar-brand" href="gstin-advance.php">GST Advance Verification</a>
    </div>
</div>
</nav>

        <section>
            <div class="container">
            <div class="row margin">
                    <div class="col-md-3"></div>
					<form method="POST" id="panChkFORM">
                    <div class="col-md-6 panel panel-default">
                        <div class="form-group">
                             <label for="GSTIN">GSTIN :</label>
                            <input type="text" class="form-control" id="gstin_no" name="gstin_no" maxlength="15">
                        </div>
                        <!--<div class="form-group text-center">
                            <input type="button" value="Verify" id="verify_btn" class="btn btn-primary btn-lg">
							<input type="submit" name="submit" value="submit">
                        </div>-->
						<div id='imgLoading1' style='display:none'><img src="https://registration.gjepc.org/images/loader.gif" alt="Uploading...."/></div>
                        <div id="result" class="alert">                              
                        </div>						
                    </div>
					</form>
                    <div class="col-md-3"></div>
            </div>  
			
			<div class="row" id="panFORM">
				<div class="col-md-3">
                    <p class="text-center">Response Message </p>
                </div>	
				<div class="col-auto">
                    <p class="glance_no" id="response_message" style="font-weight:bold;">  </p>                              
                </div>
				<div class="col-md-3">
                    <p class="text-center">Response Code </p>
                </div>	
				<div class="col-auto">
                    <p class="glance_no" id="response_code" style="font-weight:bold;">  </p>                              
                </div>
				<div class="col-md-3">
                    <p class="text-center">Registration Status</p>
                </div>	
				<div class="col-auto">
                    <p class="glance_no" id="current_registration_status" style="font-weight:bold;">  </p>                              
                </div>
				<div class="col-md-3">
                    <p class="text-center">Business Constitution</p>
                </div>	
				<div class="col-auto">
                    <p class="glance_no" id="business_constitution" style="font-weight:bold;">  </p>                              
                </div>	
				<div class="col-md-3">
                    <p class="text-center">Register Date</p>
                </div>	
				<div class="col-auto">
                    <p class="glance_no" id="register_date" style="font-weight:bold;">  </p>                              
                </div>
				<div class="col-md-3">
                    <p class="text-center">Trade Name</p>
                </div>	
				<div class="col-auto">
                    <p class="glance_no" id="trade_name" style="font-weight:bold;">  </p>                              
                </div>	
				<div class="col-md-3">
                    <p class="text-center">Legal Name</p>
                </div>	
				<div class="col-auto">
                    <p class="glance_no" id="legal_name" style="font-weight:bold;">  </p>                              
                </div>	
				
				<div class="col-md-3">
                    <p class="text-center">Primary Business Address</p>
                </div>	
				<div class="col-auto">
                    <p class="glance_no" id="registered_address" style="font-weight:bold;">  </p>                              
                </div>
				
				<div class="col-md-3">
                    <p class="text-center">Address</p>
                </div>	
				<div class="col-auto">
                    <p class="glance_no" id="state_jurisdiction" style="font-weight:bold;">  </p>                              
                </div>	
				<div class="col-md-3">
                    <p class="text-center">Business Nature</p>
                </div>	
				<div class="col-auto">
                    <p class="glance_no" id="business_nature" style="font-weight:bold;">  </p>                              
                </div>
				<div class="col-md-3">
                    <p class="text-center">Gross Total Income</p>
                </div>	
				<div class="col-auto">
                    <p class="glance_no" id="gross_total_income" style="font-weight:bold;">  </p>                              
                </div>
				<div class="col-md-3">
                    <p class="text-center">Gross Total Income Financial Year</p>
                </div>	
				<div class="col-auto">
                    <p class="glance_no" id="gross_total_income_financial_year" style="font-weight:bold;">  </p>                              
                </div>
				
			</div>
            </div>
			
        </section>
    
        <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
        crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        
<script>
$(document).ready(function(){
	
	$("#panFORM").hide();
	$("#gstin_no").on("change",function(){
    	gstin_no = $('#gstin_no').val();
		if(gstin_no == "")
		{
        alert("Please enter GSTIN No!");
		}  else {
	 	$.ajax({
	 			type:'POST',
	 			data:"actiontype=checkDetails&gstin_no="+gstin_no,
	 			url:'API/verify_gstin_advance.php',
	 		//	url:'API/test_json.php',
	 			dataType: "json",
	 			beforeSend: function(){
					$('#imgLoading1').show();
					
					$('#response_code').html("");
					$('#response_message').html("");
					$('#business_constitution').html("");
					$('#current_registration_status').html("");
					$('#trade_name').html("");
					$('#legal_name').html("");
					$('#business_nature').html("");
					$('#register_date').html("");
					$('#state_jurisdiction').html("");
					$('#gross_total_income').html("");
					$('#gross_total_income_financial_year').html("");
	 			},
				success: function(data)
				{ //alert(data.success);
					$('#imgLoading1').hide();
					$("#panFORM").slideDown();
					if(data.response_code=="100")
					{
						//alert(data.success);

						$('#response_code').html(data.response_code);
						$('#response_message').html(data.response_message);
						$('#business_constitution').html(data.result.business_constitution);
						$('#current_registration_status').html(data.result.current_registration_status);
						$('#trade_name').html(data.result.trade_name);
						$('#legal_name').html(data.result.legal_name);
						$('#business_nature').html(data.result.business_nature);
						$('#register_date').html(data.result.register_date);
						$('#state_jurisdiction').html(data.result.state_jurisdiction);
						$('#gross_total_income').html(data.result.gross_total_income);
						$('#gross_total_income_financial_year').html(data.result.gross_total_income_financial_year);
						
						$('#registered_address').html(data.result.primary_business_address.registered_address);
						
					} else {
						$('#response_code').html(data.response_code);
						$('#response_message').html(data.response_message);
						$('#business_constitution').html(data.result.business_constitution);
						$('#current_registration_status').html(data.result.current_registration_status);
						$('#trade_name').html(data.result.trade_name);
						$('#legal_name').html(data.result.legal_name);
						$('#business_nature').html(data.result.primary_business_address.business_nature);
						$('#register_date').html(data.result.primary_business_address.register_date);
						$('#state_jurisdiction').html(data.result.primary_business_address.state_jurisdiction);
						$('#gross_total_income').html(data.result.gross_total_income);
						$('#gross_total_income_financial_year').html(data.result.gross_total_income_financial_year);
						$('#registered_address').html(data.result.primary_business_address.registered_address);
					}	 			 	
				}
	 	});
		}
	 });
  });
</script>
</body>
</html>
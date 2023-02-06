<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <title>Verify Pan detail</title>
</head>

<?php
if(isset($_POST['submit']))
{
$pan_no = $_POST['pan_no'];

		$fieldsArr = '{
			"data": 
			{
			"customer_pan_number": "'.$pan_no.'",
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
  CURLOPT_URL => 'https://test.zoop.one/api/v1/in/identity/pan/lite',
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
                            <label for="pan">Pan:</label>
                            <input type="text" class="form-control" id="pan_no" name="pan_no" maxlength="10">
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
                    <p class="text-center">Name</p>
                </div>	
				<div class="col-auto">
                    <p class="glance_no" id="user_full_name" style="font-weight:bold;">  </p>                              
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
	$("#pan_no").on("change",function(){
    	pan_numbers = $('#pan_no').val();
		if(pan_numbers == "")
		{
        alert("Please enter PAN No!");
		}  else {
	 	$.ajax({
	 			type:'POST',
	 			data:"actiontype=checkDetails&pan_numbers="+pan_numbers,
	 			url:'API/verify_pan_script.php',
	 			dataType: "json",
	 			beforeSend: function(){
					$('#imgLoading1').show();
					
					$('#response_code').html("");
					$('#response_message').html("");
					$('#user_full_name').html("");
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
						$('#user_full_name').html(data.result.user_full_name);
						
					} else {
						$('#response_code').html(data.response_code);
						$('#response_message').html(data.response_message);
						$('#user_full_name').html(data.result.user_full_name);
					}	 			 	
				}
	 	});
		}
	 });
  });
</script>
</body>
</html>
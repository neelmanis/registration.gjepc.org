<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" type="text/css" href="https://gjepc.org/assets-new/css/bootstrap.min.css" />
		   <link rel="stylesheet" type="text/css" href="css/general.css?v=<?php echo $version;?>" />
		<script src="picojs/camvas.js"></script>
		<script src="picojs/pico.js"></script>
		<script src="picojs/lploc.js"></script>
		<script src="picojs/detection.js?v=1.33"></script>
	</head>
	<body style="background:#f6f6f6">
		<div class="w-100 vh-100 py-5 d-flex justify-content-center">
			<div class="col-auto text-center">
				<div class="camerabox_wrp mb-3">
				<canvas class="camerabox" height="300" width="300"></canvas>
				<!-- <div class="overlay"></div> -->
			</div>
			<div>
				<p id="hint">
					<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="#a89c5d" class="me-3" viewBox="0 0 16 16"><path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/></svg>
				Please align your face properly in box </p>
				<progress value="0" max="4" id="progressBar" class="mb-3"></progress>
				<input type="button" value="Start Camera" id="captureImage" onclick="button_callback(false)" class="camBtn mx-auto" style="display:block;">
				<input type="button" id="recaptureImage" value="Recapture Image" onclick="button_callback(false)" class="camBtn mx-auto" style="display:none;">
			</div>
		
		  <div class="mt-4">	<?php include 'view.php'; ?></div>
			</div>
			
		</div>
	
			
	
	</body>
		<style>
		.camerabox_wrp {width: 300px; height: 300px; position: relative; display: table; margin: 0 auto; border: 1px solid#ccc; border-radius: 10px;background:#fff;}
		.camerabox_wrp:before{content: ""; position: absolute;top: 50px; bottom: 50px; right: 25%; left: 25%; border:1px dashed #fff ;padding: 10px; border-radius: 10px; }
		/*.camerabox{max-width: 300px;height:auto; }*/
		.camBtn {background:#a89c5d; color:#fff; padding:10px 20px;border:0;}
		.camBtn:hover{background:#1a1a1a; color:#fff;}
	    </style>
</html>
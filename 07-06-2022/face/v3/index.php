<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Face Capture </title>
        <link rel="stylesheet" type="text/css" href="https://gjepc.org/assets-new/css/bootstrap.min.css" />
         <link rel="stylesheet" type="text/css" href="./css/face_detection.css?v=1.17" />
    </head>
    <body style="background:#f6f6f6">
    <div class="container">
            <div class="w-100 py-5 d-flex justify-content-center">
                <div class="col-auto text-center">
                    <div class="videoWrapper">
                         <div class="oval"></div>
                         <video id="video" class="video"  playsinline autoplay muted loop></video>
                    </div>
               
                <div class="ocrloader">
                  <em></em>
                  <div>
                    
                  </div>
                  <span></span>
                </div>
                <canvas id="canvas" ></canvas>
                <img src="" id="respImage" class="img-fluid" style="height: auto;width:320" />
            </div>
        </div>
        <div class="w-100 py-5 mb-5 d-flex justify-content-center">
            <div class="col-auto text-center">
                <p id="hint">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="#a89c5d" class="me-3" viewBox="0 0 16 16"><path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/></svg>
                Please align your face properly in box </p>
                <button id="start-camera" class="camBtn">Start Camera</button>
                <button id="click-photo" class="camBtn">Click Photo</button>                
            </div>            
        </div>        
    </div>    


<!-- hosted libraries -->
<script src="https://gjepc.org/assets-new/js/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://gjepc.org/assets-new/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" ></script>
<script type="text/javascript" src="./js/face_detection.js?v=1.1"></script>
</body>
</html>
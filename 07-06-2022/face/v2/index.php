<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Face Capture </title>
        <link rel="stylesheet" type="text/css" href="./css/face_detection.css" />
        <link rel="stylesheet" type="text/css" href="https://gjepc.org/assets-new/css/bootstrap.min.css" />
    </head>
    <body style="background:#f6f6f6">
    <div class="container">
            <div class="w-100 py-5 d-flex justify-content-center">
                <div class="col-auto text-center">
                    <div class="videoWrapper">
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

<style type="text/css">
       
</style>
<!-- hosted libraries -->
<script src="https://gjepc.org/assets-new/js/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://gjepc.org/assets-new/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" ></script>
<script>
    $("#click-photo").hide();
    $("#canvas").hide();
    $(".ocrloader").hide();
    $("#respImage").hide();

function parseImageData(imageData) {
imageData = imageData.replace("data:image/jpeg;base64,", "");
imageData = imageData.replace("data:image/jpg;base64,", "");
imageData = imageData.replace("data:image/png;base64,", "");
imageData = imageData.replace("data:image/gif;base64,", "");
imageData = imageData.replace("data:image/bmp;base64,", "");
return imageData;
}
let camera_button = document.querySelector("#start-camera");
let video = document.querySelector("#video");
let click_button = document.querySelector("#click-photo");
let canvas = document.querySelector("#canvas");
var ctx = canvas.getContext('2d');

camera_button.addEventListener('click', async function() {
    let stream = await navigator.mediaDevices.getUserMedia({ video: true, audio: false });
    video.srcObject = stream;
    $("#video").show();
    $("#canvas").hide();
    $("#start-camera").hide();
    $("#click-photo").show();
     $(".videoWrapper").show();
     $("#respImage").hide().attr("src","");
});
click_button.addEventListener('click', function() {
    $("#canvas").show();
    let widthX = window.innerWidth;
                    // console.log(widthX);
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    // console.log(canvas.width);
    // console.log("----");
    // console.log(canvas.width);
    ctx.translate(video.videoWidth, 0);
    ctx.scale(-1, 1);
                    if(widthX > 500){
                        ctx.drawImage(video,0,0, canvas.width, canvas.height);
                    }else{
                        ctx.drawImage(video,0, 0, canvas.width, canvas.height);
                    }
                  
    // canvas.getContext('2d').drawImage(video, 0, 0, 300, 350);
    let image_data_url = canvas.toDataURL('image/jpeg');
    $("#video").hide();
    $("#start-camera").show().text("Restart camera");
      $("#click-photo").hide();
      $(".videoWrapper").hide();
    $.ajax({
        type: 'POST',
        url: 'detect.php',
        data: {
        image_file: JSON.stringify({image:parseImageData(image_data_url)}), // < note use of 'this' here
        action: "check_image"
        },
        dataType: 'json',
        beforeSend:function(){
          $(".ocrloader").show();
          $("#start-camera").show().text("Checking photo please wait...").attr("disabled",true);
        },

        success: function(result) {
        $("#responseBox").text(result);
         $(".ocrloader").hide();
           $("#start-camera").show().text("start camera").attr("disabled",false);
        if(result.status =="success"){
        swal({
            title: "Face detection success",
            icon: "success",
            text: result.message,
            // buttons:false,
            timer: 2000
      
          }).then(function(){
            $("#respImage").show().attr("src",image_data_url);
            $("#canvas").hide();

          });
        }else{
            swal({
            title: "Face detection ",
            icon: "warning",
            text: result.message,
            // buttons:false,
      
          }).then(function(){

            $("#video").show();
            $("#canvas").hide();
            $("#start-camera").hide();
            $("#click-photo").show();
             $(".videoWrapper").show();
             $("#respImage").hide().attr("src","");
          });
        }        
        }
        });
    }); 
</script>
</body>
</html>
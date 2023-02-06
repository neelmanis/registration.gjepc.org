<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Face Capture </title>
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
       .videoWrapper{max-width:400px;height: 400px;}
       .video{width:100%;height: 100%;}
        .camBtn {background:#a89c5d; color:#fff; padding:10px 20px;border:0;}
        .camBtn:hover{background:#1a1a1a; color:#fff;}
        #video{border-radius:10px ;border: 1px solid #a89c5d;  object-fit: cover;
    object-position: center center;}
     #canvas{border-radius:10px; border: 1px solid #f6f6f6; }
    @media only screen and (max-width: 600px) {
       #canvas{border-radius:10px; border: 1px solid #f6f6f6; max-width:400px;height: 400px;}
    }
    #respImage{border: 1px solid #a89c5d; border-radius: 10px ;}

        * {
     margin: 0;
     padding: 0;
     box-sizing: border-box;
        }
 body {
     height: 100vh;
     position: relative;
}
 .ocrloader {
     width: 291px;
    height: 211px;
    position: absolute;
    left: 50%;
    top: 49%;
    transform: translate(-50%,-50%);
    backface-visibility: hidden;
}
 .ocrloader span {
     position: absolute;
     left: 0;
     top: 0;
     width: 100%;
     height: 20px;
     background-color: rgba(45,183,183,0.54);
     z-index: 1;
     animation: move 3s ease-in-out;
     animation-iteration-count: infinite;
}
 .ocrloader > div {
     z-index: 1;
     position: absolute;
     left: 50%;
     top: 50%;
     transform: translate(-50%,-50%);
     width: 48%;
     backface-visibility: hidden;
}
 .ocrloader i {
     display: block;
     height: 1px;
     background: #000;
     margin: 0 auto 2px;
     margin: 0 auto 2.2px;
     backface-visibility: hidden;
}
 .ocrloader i:nth-child(2) {
     width: 75%;
}
 .ocrloader i:nth-child(3) {
     width: 81%;
}
 .ocrloader i:nth-child(4) {
     width: 87%;
}
 .ocrloader i:nth-child(6) {
     width: 71%;
}
 .ocrloader i:nth-child(7) {
     width: 81%;
}
 .ocrloader i:nth-child(8) {
     width: 65%;
}
 .ocrloader i:nth-child(9) {
     width: 83%;
}
 .ocrloader i:nth-child(10) {
     width: 75%;
}
 .ocrloader i:nth-child(12) {
     width: 86%;
}
 .ocrloader i:nth-child(14) {
     width: 65%;
}
 .ocrloader i:nth-child(16) {
     width: 75%;
}
 .ocrloader i:nth-child(18) {
     width: 83%;
}
 .ocrloader:before, .ocrloader:after, .ocrloader em:after, .ocrloader em:before {
     border-color: #000;
     content: "";
     position: absolute;
     width: 19px;
     height: 16px;
     border-style: solid;
     border-width: 0px;
}
 .ocrloader:before {
     left: 0;
     top: 0;
     border-left-width: 1px;
     border-top-width: 1px;
}
 .ocrloader:after {
     right: 0;
     top: 0;
     border-right-width: 1px;
     border-top-width: 1px;
}
 .ocrloader em:before {
     left: 0;
     bottom: 0;
     border-left-width: 1px;
     border-bottom-width: 1px;
}
 .ocrloader em:after {
     right: 0;
     bottom: 0;
     border-right-width: 1px;
     border-bottom-width: 1px;
}
 @keyframes move {
     0%, 100% {
         top: 0;
    }
     50% {
         top: 90%;
    }

}
.videoWrapper{position: relative;}
.videoWrapper:before {
    position: absolute;
    content: "";
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    /* background: #000; */
    width: 100%;
    height: 100%;
    border-radius: 10px;
    border-top: 100px solid #000000bf;
    border-bottom: 100px solid #000000bf;
    border-left: 50px solid #000000bf;
    border-right: 50px solid #000000bf;
}
video {
  -webkit-transform: scaleX(-1);
  transform: scaleX(-1);
}
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
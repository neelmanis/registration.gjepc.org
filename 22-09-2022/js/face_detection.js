
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
let ctx = canvas.getContext('2d');

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
        url: 'face/detect.php',
        data: {
        image_file: JSON.stringify({image:parseImageData(image_data_url)}), // < note use of 'this' here
        action: "check_image",
        image_actual_file:image_data_url
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
            $("#blah_photo").show().attr("src",image_data_url);
            $("#face-detection-modal").modal("hide");
            $("#photo").val(image_data_url);
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

  $(document).on("click","#openFaceDetectionModal", function(e){
            e.preventDefault();
           
              $('#face-detection-modal').modal({ backdrop: 'static', keyboard: false});

          });
function onScanSuccess(decodedText, decodedResult) {
     // console.log(`Code scanned = ${decodedText}`, decodedResult);
  if(decodedText !==""){
              // alert(content);
              let device_type = $("#device_type").val();
              let zone = $("#zone").val();
              if(device_type ==""){
                swal({
                    title: "Warning !",
                    icon: "warning",
                    text: "Please Select Check-in / check-out "
                    });
                return false;
              }
              if(zone ==""){
                swal({
                    title: "Warning !",
                    icon: "warning",
                    text: "Please Select Zone "
                    });
                return false;
              }

              $.ajax({
                type:'POST',
                    data:{qr_content:content,device_type:device_type,zone:zone},
                    url: CI_ROOT + "user/scanVisitor",
                    dataType: "json",
                    beforeSend:function(){
                     showLoader();
                    },
                    success:function(result){
                      hideLoader(100,"fast");
                      var audio = new Audio('https://scanapp.kwebmaker.com/assets/admin/audio/beep_1.mp3');
                      navigator.vibrate(200);
                audio.play();
                // scanner.stop();
                //alert(result.result.name);
                if(result.status =="success"){
                  // $("#video_preview").hide();
                  // $("#preview").hide();
                   $(".video_container").hide();


                  $("#scan_preview").show();
                  $("#vis_photo_url").attr("src",result.result.photo_url);
                  $("#vis_name").html(result.result.name);
                  $("#vis_company").html(result.result.company);
                  $("#vis_category").html(result.result.category);
                  $("#vis_description").html(result.result.description);
                  $("#scan").html("Rescan");

                  if(result.result.status =="APPROVED"){
                    
                                       $("#response_message_section").addClass("alert alert-success");
                  }else{
                     $("#response_message_section").addClass("alert alert-danger");
                  } 
                  // $("#response_status").html(result.result.status);
                  $("#response_message").html(result.result.message);
                  // alert(result.result.message);

                }else{
                  swal({
                    title: "Warning !",
                    icon: "warning",
                    text: result.message
                    });
                }
                    }
                  });
            }else{
              // alert("Qr Code Currupted..!");
            }
}
var html5QrcodeScanner = new Html5QrcodeScanner(
  "qr-reader", { fps: 10, qrbox: 250 });

html5QrcodeScanner.render(onScanSuccess);
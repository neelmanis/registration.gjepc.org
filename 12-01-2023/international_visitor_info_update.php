<?php 
include('header_include.php');

$registration_id = $_SESSION['uid'];
$visitor_id = $_SESSION['eid'];
if(empty($registration_id)){
header("location:international_visitor_photo_update.php");
}

//$encrypted_pan = filter($_GET['key']);
$show = "iijs22";
$year = '2022';
/*
if($_GET['key'] ==""){ ?>
<div class="customDiv" >
    <p>Invalid Access</p>
</div>
<?php }  
  
$pan_no = base64_decode(strtr($encrypted_pan, '-_,', '+/='));
$sql = "SELECT * FROM visitor_directory WHERE pan_no = '$pan_no'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$num = $result->num_rows;
if($num>0){
    if($row['status']==1){
        $registration_id = $_SESSION['registration_id'] = $row['registration_id'];
        $visitor_id = $_SESSION['visitor_id'] = $row['visitor_id'];
        if(empty($registration_id)  ){
          header("location:single_visitor.php");
        }
    }
} */
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome to IIJS PREMIERE photo update</title>
    <link rel="shortcut icon" href="images/fav.png" />
<!--<link rel="stylesheet" type="text/css" href="css/mystyle.css" />--> 
<link rel="stylesheet" type="text/css" href="https://gjepc.org/assets-new/css/bootstrap.min.css" />
<link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Cabin'>
    <link rel="stylesheet" type="text/css" href="css/general.css?v=<?php echo $version;?>" />
    <link rel="stylesheet" type="text/css" href="css/inner_pg_style.css?v=<?php echo $version;?>" />     
    <link rel="stylesheet" type="text/css" href="css/responsive.css?v=<?php echo $version;?>" />
    <link rel="stylesheet" type="text/css" href="css/media_query.css?v=<?php echo $version;?>" />
    <link rel="stylesheet" type="text/css" href="css/visitor_reg.css?v=<?php echo $version;?>" />
    <link rel="stylesheet" type="text/css" href="css/face_detection.css?v=<?php echo $version;?>" />
    <script type="text/javascript" src="https://gjepc.org/assets-new/js/jquery.min.js?v=<?php echo $version;?>"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" ></script>
    <!--NAV-->
<link href="css/flexnav.css?v=<?php echo $version;?>" media="screen, projection" rel="stylesheet" type="text/css">
<!--<script src="js/jquery.flexnav.js" type="text/javascript"></script>-->
<script type="text/javascript" src="flexnav-master/js/jquery.flexnav.min.js?v=<?php echo $version;?>"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" ></script>
<script type="text/javascript" src="https://gjepc.org/assets-new/js/FontAwesome.js"></script>
<script src="js/common.js?v=<?php echo $version;?>"></script> 
<!-- CROPPER JS START-->
        <link href="https://unpkg.com/cropperjs/dist/cropper.css" rel="stylesheet"/>
        <script src="https://unpkg.com/dropzone"></script>
        <script src="https://unpkg.com/cropperjs"></script>
<!-- CROPPER JS END -->
<!--NAV-->
    <script src="jsvalidation/jquery.validate.js?v=<?php echo $version;?>" type="text/javascript"></script> 
    <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-178505237-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-178505237-1');
</script>

<!-- Global site tag (gtag.js) - Google Ads: 679056788 --> <!-- <script async src="https://www.googletagmanager.com/gtag/js?id=AW-679056788"></script> <script> window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag('js', new Date()); gtag('config', 'AW-679056788'); </script>  -->
<!-- Event snippet for GJEPC_Google_PageView conversion page --> <script> gtag('event', 'conversion', {'send_to': 'AW-679056788/N1zUCJPKxLsBEJSr5sMC'}); </script> 
<!-- Facebook Pixel Code -->
<script>
  !function(f,b,e,v,n,t,s)
  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
  n.queue=[];t=b.createElement(e);t.async=!0;
  t.src=v;s=b.getElementsByTagName(e)[0];
  s.parentNode.insertBefore(t,s)}(window, document,'script',
  'https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', '398834417477910');
  fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
  src="https://www.facebook.com/tr?id=398834417477910&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->
    <script type="text/javascript">
    $(document).ready(function(){
        $("#single_visitor_update").on("submit",function(e){
    e.preventDefault();  
    var form = $('#single_visitor_update');
    var formdata = false;

    if (window.FormData){
        formdata = new FormData(form[0]);
    }

   /* alert(formdata);return false;*/

    $.ajax({
      type:'POST',
      url:"intlVisitorPhotoAjax.php",
      data:formdata ? formdata : form.serialize(),
      dataType: "json",
      cache:false,
      contentType: false,
      processData: false,
      beforeSend:function(){
        $('.loaderWrapper').show();
      },
      success:function(data){
         $('.loaderWrapper').hide();
         
         if(data['status'] == "error"){
         $("#photoEmpty").text(data.message); 
          $("#emailSuccess").html(data.message);
         }else if(data['status'] == "updateSuccess"){
            window.location = "Visitor_registration_success.php";
         }
      }
    });
  });
   function ValidateEmail(mail) 
    {
        if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(mail))
        {
            return true;
        }else{
            return false;
        }  
    }
    $(function () {
      $('[data-toggle="tooltip"]').tooltip()
    });
    $(document).ready(function(){
     $("#editEmail").on("click", function(e){
        e.preventDefault();
        $("#email").attr("readonly", false);
         $("#verifyEmailBtn").show();
     });
      $("#email_otp").hide();
      $("#verifyEmailBtn").hide();

     $("#verifyEmailBtn").on("click", function(e){
        e.preventDefault();
       let email = $("#email").val();
       $("#checkForOtp").val("yes");
       $.ajax({
          type:'POST',
          url:"intlVisitorPhotoAjax.php",
          data:{action:"visitorEmailOtpAction",email:email},
          dataType: "json",
          success:function(data){
              if(data.status=="success"){
                $("#email_otp").slideDown();
                
                $("#emailSuccess").html(data.message);
                $("#emailError").html("");
                $("#verifyEmailBtn").hide();

              }else{
                $("#email_otp").slideUp();
                $("#emailError").html(data.message);
                $("#emailSuccess").html("");
                $("#verifyEmailBtn").hide();

              }
          }
        });

       

     });
    });
     $("input[name='designation']").change(function(e){
        e.preventDefault();
        var radioValue = $('[name="designation"]:checked').val();
        if(radioValue =="Owner"){
        $("#OwnerDiv").show();    
        $("#EmployeeDiv").hide();    
        }else if(radioValue =="Employee"){
        $("#OwnerDiv").hide();    
        $("#EmployeeDiv").show(); 

        }

        $.ajax({
          type:'POST',
          url:"intlVisitorPhotoAjax.php",
          data:{action:"visitorDesignationChange",type:radioValue},
          dataType: "json",
          success:function(data){
              if(data.status=="success"){
                $("#designationList").html(data.output);
              }
          }
        });

        });
   

  });

  // ==============================XXXXXXXXXXXXXXXXXXXXXXXXXXXX CROPPING & PREVIEW START XXXXXXXXXXXXXXXXXXXXXXXXXXXXX===============================//
        $(document).ready(function(){
        var $modal = $('#myModal');
        var image = document.getElementById('crop_image');
        var cropper;
        var input = document.getElementById('photo');

        $(".preview_crop").change(function(event){
            let ref = $(this).data('ref');
            let isCrop = $(this).data("crop");
           
            $("#crop").val(ref);
            var files = event.target.files;
            if(files && files.length > 0)
            {
                reader = new FileReader();
                reader.onload = function(event)
                {
                    image.src = reader.result;
                    
                    displayImage(reader.result,ref);
                    addToInput(reader.result,ref);
                    if(isCrop =="1"){
                        $modal.modal('show');
                    }else{
                        $modal.modal('hide');
                    }
                    
                   
                
                };
                reader.readAsDataURL(files[0]);
            }
        });

        $modal.on('shown.bs.modal', function() {
            cropper = new Cropper(image, {
                aspectRatio: "NAN",
                viewMode: 3,
                preview:'.preview'
            });
        }).on('hidden.bs.modal', function(){
            cropper.destroy();
            cropper = null;
        });
         
        
        $(document).on("click","#crop",function(event){
            let ref = $(this).val();
        
            canvas = cropper.getCroppedCanvas({
                width:400,
                height:400
            });
            canvas.toBlob(function(blob){
                url = URL.createObjectURL(blob);
                readImage(blob, function(dataUrl) {
                  displayImage(dataUrl,ref);
                  addToInput(dataUrl,ref);
                   $modal.modal('hide');
                });

            });
        });

        
        function dataURLtoFile(dataurl, filename) {
     
            var arr = dataurl.split(','),
                mime = arr[0].match(/:(.*?);/)[1],
                bstr = atob(arr[1]), 
                n = bstr.length, 
                u8arr = new Uint8Array(n);
                
            while(n--){
                u8arr[n] = bstr.charCodeAt(n);
            }
            
            return new File([u8arr], filename, {type:mime});
        }

        function readImage(file, callback) {
          var reader = new FileReader();
          reader.onload = function() {
            callback(reader.result);
          }
          reader.readAsDataURL(file);
        }

        function displayImage(dataUrl,ref) {
           $('#blah_'+ref).attr('src', dataUrl);
        }

        function addToInput(dataUrl,ref) {
          var file = dataURLtoFile(dataUrl,ref+'.jpg');
          let container = new DataTransfer(); 
          container.items.add(file);
          document.querySelector('#'+ref).files = container.files;
        }

        });

       // ==============================XXXXXXXXXXXXXXXXXXXXXXXXXXXX CROPPING & PREVIEW END XXXXXXXXXXXXXXXXXXXXXXXXXXXXX===============================//      
         
        function onlyAlphabets(e, t) {
            try {
                if (window.event) {
                    var charCode = window.event.keyCode;
                }
                else if (e) {
                    var charCode = e.which;
                }
                else { return true; }
                if ((charCode > 64 && charCode < 91) || (charCode > 96 && charCode < 123))
                    return true;
                else
                    return false;
            }
            catch (err) {
                alert(err.Description);
            }
        }       
</script>
 <script src="https://gjepc.org/iijs-signature/assets/js/bootstrap.min.js"></script>
<!-- Facebook Pixel Code -->
<script>
  !function(f,b,e,v,n,t,s)
  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
  n.queue=[];t=b.createElement(e);t.async=!0;
  t.src=v;s=b.getElementsByTagName(e)[0];
  s.parentNode.insertBefore(t,s)}(window, document,'script',
  'https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', '398834417477910');
  fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
  src="https://www.facebook.com/tr?id=398834417477910&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->
<style type="text/css">
    .blah {border-radius: 10px;}
</style>
</head>

<body>
    <div class="wrapper">
       <div class="header">
          <?php include('header1.php'); ?>
      </div>
    <div class="clear"></div>
          <div id="myModal" class="modal fade"   tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
               
                    <div class="modal-dialog modal-lg " role="document">
                        <div class="modal-content ">
                             <div class="modal-content">
                                <div class="modal-header">
                              <button type="button" class="close d-inline" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body text-center p-0  border-0">
                               <div class="img-container">
                                <div class="row">
                                    <div class="col-md-8">
                                        <img src="" id="crop_image" class="img-fluid h-75 w-100" />
                                    </div>
                                    <div class="col-md-4">
                                        <div class="preview"></div>
                                    </div>
                                    
                                </div>
                            </div>
                            </div>
                            <div class="modal-footer">
                            <button type="button" id="crop" class="cta" value=""  >Crop </button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close & Continue</button>
                            </div>
                            </div>
                        </div>
                    </div>
               
            </div>
    <!--container starts-->
    <div class="container_wrap">
       <div class="container">

           <div class="bold_font text-center">
              <div class="d-block">
                  <img src="https://www.gjepc.org/assets/images/gold_star.png" class="">
              </div>
            <?php echo $evt_name; ?> - PHOTO UPDATE 
          </div>  
           <div id="loginForm">           
        <div class="box-shadow">
       <div class="loaderWrapper">
        <div class="formLoader">
         <img src="images/formloader.gif" alt="">
          <p>  Please Wait....</p>
       </div>
       </div>
       <?php 

       
     $sql = "SELECT * FROM ivr_registration_details WHERE uid='$registration_id' AND eid='$visitor_id'";
     $result = $conn->query($sql); 
     $row = $result->fetch_assoc(); 
     $company_name = $row['company_name'];  
     $designation = $row['designation'];  
     $first_name = $row['first_name'];  
     $last_name = $row['last_name'];  
     $gender = $row['gender'];  
     $mob_no = $row['mob_no'];  
     $email_id = $row['email'];  
     $passport_no = $row['passport_no'];  
   
     $photo = $row['photograph_fid'];  
     
     $photo_new = $row['face_photo'];  
     $passport_fid = $row['passport_fid'];  
     $visit_card_fid = $row['visit_card_fid'];  
     $nri_fid = $row['nri_fid'];  
 
     $face_status = $row['face_status'];  

     ?>
        <form class="" id="single_visitor_update" enctype="multipart/form-data" autocomplete="off">  
           
           <div class="row">
                
                 <div class="col-sm-6 col-md-4 form-group">
                    <label><strong style="color:#a89c5d">Company </strong> - <?php echo $company_name;?></label><br>
                </div>
                
                <div class="col-sm-6 col-md-4 form-group">
                    <label ><strong style="color:#a89c5d">Name</strong> - <?php echo $first_name." ". $last_name ;?></label>
                </div>
                <div class="col-sm-6 col-md-4 form-group">
                    <label style="" ><strong style="color:#a89c5d" >Designation</strong> - <?php echo $designation; ?></label><br>
                    
                       
                </div>
                  
               
               
           
                <div class="col-sm-6 col-md-4 form-group">
                    <label ><strong style="color:#a89c5d"> Mobile No</strong> - <?php echo $mob_no;?></label>
                </div>
     
                <div class="col-sm-6 col-md-4 form-group">
                   <strong style="color:#a89c5d">E-mail id</strong> <a href="javascript:void()" id="editEmail" class="cta btn d-inline-block mb-2 active"  style="background:#a89c5d" >I want to change my e-mail id <i class="fa fa-pencil"></i></a><input type="text" name="email" id="email" class="form-control" readonly value="<?php echo trim($email_id);?>">
                    <div style="margin-top: 5px;">
                        <a href="javascript:void()"  class="btn cta" id="verifyEmailBtn">Verify Email </a>
                        <i class=" fa fa-info"> </i>  <i>Update E-mail Id </i>

                        <input type="hidden" name="checkForOtp" id="checkForOtp" value="no" >
                        
                    </div>
                    <input type="number" name="email_otp" id="email_otp" class="form-control" placeholder="Enter OTP here" >
                    <label class="error" id="emailError"></label>
                    <label class="success" id="emailSuccess"></label>
                   
                </div>
               <?php if($adhaar_no !==""){ ?> 
                <div class="col-sm-6 col-md-4 form-group">
                    <label><strong style="color:#a89c5d">Passport No</strong> - <?php echo $passport_no;?></label>
                </div>
                <?php } ?>
                <!-- <div class="col-sm-6 col-md-4 form-group">
                    <label> <strong style="color:#a89c5d">Country</strong> - <?php echo $country;?></label>

                </div>
 -->
            </div>

            <div class="row">
            
              

                <div class="col-sm-6 col-md-4 form-group">
                                <label ><strong style="color:#a89c5d">Old Photo </strong> </label>
                                
                                     
                               
                                <div class="blah mb-2">
                                    <img  class="img-fluid " src="images/ivr_image/photograph/<?php echo $photo; ?>" alt="your image" style="display: block;"/>
                                </div>
                                 
                </div>
          
                <div class="col-sm-6 col-md-4 form-group">
                    <label ><strong style="color:#a89c5d"> Passport photo Card</strong></label>
                    <div class="blah">
                        <img id="blah_pan_copy" class="img-fluid " src="images/ivr_image/passport/<?php echo $passport_fid; ?>" alt="your image" style="display: block;"/>
                    </div>
                </div>
                 <div class="col-sm-6 col-md-4 form-group">
                    <label ><strong style="color:#a89c5d"> Visiting  Card</strong></label>
                    <div class="blah">
                        <img id="blah_pan_copy" class="img-fluid " src="images/ivr_image/visiting_card/<?php echo $visit_card_fid; ?>" alt="your image" style="display: block;"/>
                    </div>
                </div>
             
                
                <div class="col-12  mb-5" style="border-top: 1px dashed #a89c5d;"></div>
                 <div class="col-sm-6 col-md-6 form-group">
                    <label><strong  style="color:#a89c5d"> New Photo </strong></label>
                  
                   <div class="blah mb-2">
                        <input type="hidden" name="photo" id="photo" value="" >
                        <?php if($photo_new ==""){ ?>
                            <img id="blah_photo" class="img-fluid " src="https://registration.gjepc.org/images/employee_directory/600865078/photo//600865078_9856574587_photo_666473303download.png" alt="your image" style="display: block;"/>
                        <?php } else{?>
                            <img id="blah_photo" class="img-fluid " src="images/ivr_image/photograph/<?php echo $photo_new;?>" alt="your image" style="display: block;"/>
                        <?php }?>
                        
                    </div>
                     <?php if($face_status !="Y"){ ?>
                     <a class="btn border  text-left"  href="javascript:void(0)" id="openFaceDetectionModal"> <i class="fa fa-camera"></i> Click here to capture your photo</a>
                 <?php } ?>
                </div>
            
              
        
                <div class="col-12 form-group">
                    <?php if($face_status !="Y"){ ?>
                      <div>
                         <label class="error" id="photoEmpty"></label>
                          
                      </div> 
                    <input type="submit" name="send_otp"  value="Update" class="btn btn-submit" >
                    <input type="hidden" name="action" value="UpdateVisitorLink">
                    <?php }else{ ?>
<div class="alert alert-success" role="alert">
  Your Details are approved
</div>
                    <?php } ?>
                    
                </div>

            </div>
          
            </div>
        
        </form>
</div>
</div>

</div>
<div class="clear"></div>
</div>

</div>
<div class="modal fade" id="face-detection-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Capture photo  </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="company-change-modal-content">
           <div class="container">
            <div class="w-100  d-flex justify-content-center">
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
        <div class="w-100  mb-5 d-flex justify-content-center">
            <div class="col-auto text-center">
                <p id="hint " style="margin-bottom: 5px;margin-top: 5px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="#a89c5d" class="me-3" viewBox="0 0 16 16"><path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/></svg>
                Please align your face properly in box </p>
                <button id="start-camera" class="camBtn">Start Camera</button>
                <button id="click-photo" class="camBtn">Click Photo</button>                
            </div>            
        </div>        
    </div>    
      </div>
      
    </div>
  </div>
</div>
<!--container ends-->
<!--footer starts-->
<div class="footer">
    <?php include ('footer.php'); ?>
</div>
</div>
<!--footer ends-->
<!-- FACE DETECTION JS START -->
        <script type="text/javascript" src="js/face_detection.js?v=<?php echo $version;?>"></script>
<!-- FACE DETECTION JS END -->
<link rel="stylesheet" type="text/css" href="css/new_style.css" />
</body>
</html>
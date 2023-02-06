<?php include('header_include.php');
$registration_id = $_SESSION['registration_id'];
$visitor_id = $_SESSION['visitor_id'];
/*echo $registration_id ;exit;*/
if(empty($registration_id)  ){
  header("location:single_visitor.php");
}
/* if(!isset($_SERVER['HTTP_REFERER']))
        { 
      
             header("location:index.php"); 
             unset($_SESSION['visitor_id']); 
             unset($_SESSION['registration_id']); 
        }*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Welcome to IIJS Registration</title>
	<link rel="shortcut icon" href="images/fav.png" />
<!--<link rel="stylesheet" type="text/css" href="css/mystyle.css" />-->	
<link rel="stylesheet" type="text/css" href="https://gjepc.org/assets-new/css/bootstrap.min.css" />
<link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Cabin'>
	<link rel="stylesheet" type="text/css" href="css/general.css?v=<?php echo $version;?>" />
	<link rel="stylesheet" type="text/css" href="css/inner_pg_style.css?v=<?php echo $version;?>" />	 
	<link rel="stylesheet" type="text/css" href="css/responsive.css?v=<?php echo $version;?>" />
    <link rel="stylesheet" type="text/css" href="css/media_query.css?v=<?php echo $version;?>" />
	<link rel="stylesheet" type="text/css" href="css/visitor_reg.css?v=<?php echo $version;?>" />
	<script type="text/javascript" src="https://gjepc.org/assets-new/js/jquery.min.js?v=<?php echo $version;?>"></script>

	<!--NAV-->
<link href="css/flexnav.css?v=<?php echo $version;?>" media="screen, projection" rel="stylesheet" type="text/css">
<!--<script src="js/jquery.flexnav.js" type="text/javascript"></script>-->
<script type="text/javascript" src="flexnav-master/js/jquery.flexnav.min.js?v=<?php echo $version;?>"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" ></script>
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
      url:"singleVisitorAjax.php",
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
         if(data['status'] == "fnameEmpty"){
         $("#fnameEmpty").text("First Name is Required");
         }else if(data['status'] == "lnameEmpty"){
         $("#lnameEmpty").text("Last Name is Required");
         }else if(data['status'] == "genderEmpty"){
         $("#genderEmpty").text("Gender is Required");
         }else if(data['status'] == "mobileEmpty"){
         $("#mobileEmpty").text("Mobile Number is Required");
         }else if(data['status'] == "invalidMobileNumber"){
         $("#mobileEmpty").text("Mobile Number is Not Valid");
         }else if(data['status'] == "emailEmpty"){
         $("#emailEmpty").text("Email-Id is Required");
         }else if(data['status'] == "adhaarEmpty"){
         $("#adhaarEmpty").text("Adhaar Number is Required"); 
         }else if(data['status'] == "panEmpty"){
         $("#panEmpty").text("Pan Number is Required"); 
         }else if(data['status'] == "invalidEmail"){
         $("#emailEmpty").text("Invalid Email-Id"); 
         }else if(data['status'] == "invalidPanNumber"){
         $("#panEmpty").text("Invalid Pan Number"); 
         }else if(data['status'] == "panExist"){
         $("#panEmpty").text("Pan Number already Exist"); 
         }else if(data['status'] == "photoInvalid"){
         $("#photoEmpty").text("Invalid Photo Selected"); 
         }else if(data['status'] == "photoFail"){
         $("#photoEmpty").text("Photo Uploading Failed"); 
         }else if(data['status'] == "panCopyInvalid"){
         $("#panCopyEmpty").text("Invalid Pan Copy Selected"); 
         }else if(data['status'] == "panCopyFail"){
         $("#panCopyEmpty").text("Pan Copy Uploading Failed"); 
         }else if(data['status'] == "salaryInvalid"){
         $("#salarySlipEmpty").text("Invalid Salary Slip Selected"); 
         }else if(data['status'] == "salaryFail"){
         $("#salarySlipEmpty").text("Salary Slip Uploading Failed"); 
         }else if(data['status'] == "partnerInvalid"){
         $("#gstCopyEmpty").text("Invalid GST Copy Selected"); 
         }else if(data['status'] == "partnerFail"){
         $("#gstCopyEmpty").text("GST Copy Uploading Failed"); 
         }else if(data['status'] == "emailExist"){
         $("#emailEmpty").text("Email id already exist"); 
         }else if(data['status'] == "mobileExist"){
         $("#mobileEmpty").text("Mobile number already exist"); 
         }else if(data['status'] == "updateSuccess"){
			window.location = "Visitor_registration_success.php";
         }
      }
    });
  });

    $(function () {
      $('[data-toggle="tooltip"]').tooltip()
    })
   

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
            <?php echo $evt_name; ?> -  Registration
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
     $sql =  "SELECT * FROM visitor_directory WHERE registration_id='$registration_id' AND visitor_id='$visitor_id'";
     $result = $conn->query($sql); 
     $row = $result->fetch_assoc(); 
     $designation_type = $row['degn_type'];  
     $first_name = $row['name'];  
     $last_name = $row['lname'];  
     $gender = $row['gender'];  
     $mobile_no = $row['mobile'];  
     $email_id = $row['email'];  
     $adhaar_no = $row['aadhar_no'];  
     $pan_no = $row['pan_no'];  
     $photo = $row['photo'];  
     $pan_copy = $row['pan_copy'];  
     $salary_slip_copy = $row['salary_slip_copy'];  
     $gst_copy = $row['partner'];  

     ?>
        <form class="" id="single_visitor_update" enctype="multipart/form-data" autocomplete="off">  
           
           <div class="row">
                
                <div class="col-sm-6 col-md-4 form-group">
                    <label class="star">Designation:</label>
                    <div class="d-flex">
                        <label class="container_radio col-auto"><span class="check_text ">Owner</span>
                            <input type="radio" <?php if($designation_type =='Owner'){echo 'checked="checked" ';}else{echo 'disabled';}?> id="designation" name="designation" value="Owner" >
                            <span class="checkmark_radio"></span>
                        </label>
                        <label class="container_radio col-auto"><span class="check_text">Employee</span>
                            <input type="radio" <?php if($designation_type =='Employee'){echo 'checked="checked"';}else{echo 'disabled';}?> id="designation" name="designation" value="Employee" >
                            <span class="checkmark_radio"></span>
                        </label>
                    </div>
                </div>
                
                <div class="col-sm-6 col-md-4 form-group">
                    <label class="star">First Name:</label>
                    <input type="text" class="form-control" onkeypress="return onlyAlphabets(event,this);"  id="first_name" name="first_name" autocomplete="off" value="<?php echo $first_name;?>" maxlength="14"  />
                    <p class="fail" id="fnameEmpty"></p>
                </div>
                
                <div class="col-sm-6 col-md-4 form-group">
                    <label class="star">Last Name:</label>
                    <input type="text" class="form-control" onkeypress="return onlyAlphabets(event,this);"  id="last_name" name="last_name" autocomplete="off" value="<?php echo $last_name;?>" maxlength="14" />
                    <p class="fail" id="lnameEmpty"></p>
                </div>
               
                <div class="col-sm-6 col-md-4 form-group">
                    <label class="star">Gender:</label>
                    <select class="select-control" name="gender" id="gender">
                        <option <?php if($gender=='M'){echo 'selected="selected"';}?>value="M">Male</option>
                        <option <?php if($gender=='F'){echo 'selected="selected"';}?> value="F">Female</option>
                        <option <?php if($gender=='T'){echo 'selected="selected"';}?> value="T">Transgender</option>
                    </select>
                    <p class="fail" id="genderEmpty"></p>
                </div>
           
                <div class="col-sm-6 col-md-4 form-group">
                    <label class="star">Mobile No:</label>
                    <input type="text" class="form-control" id="mobile_no" name="mobile_no" autocomplete="off" value="<?php echo $mobile_no;?>"  />
                    <p class="fail" id="mobileEmpty"></p>
                </div>
     
                <div class="col-sm-6 col-md-4 form-group">
                    <label class="star">Email-Id:</label>
                    <input type="text" class="form-control" id="email_id" name="email_id" autocomplete="off" value="<?php echo $email_id;?>"  />
                    <p class="fail" id="emailEmpty"></p>
                </div>
               
                <div class="col-sm-6 col-md-4 form-group">
                    <label >Adhaar No:</label>
                    <input type="text" class="form-control" id="adhaar_no" name="adhaar_no" autocomplete="off"  value="<?php echo $adhaar_no;?>"  />
                    <p class="fail" id="adhaarEmpty"></p>
                </div>
    
                <div class="col-sm-6 col-md-4 form-group">
                    <label class="star">Pan No:</label>
                    <input type="text" class="form-control" id="pan_no" name="pan_no" autocomplete="off" maxlength="10" value="<?php echo $pan_no;?>"  />
                    <p class="fail" id="panEmpty"></p>
                </div>

            </div>

            <div class="row">
            
                <?php if($designation_type == 'Owner') 
                    { 
                    $emp_files = $partner; 
                    $folder = "partner";
                    $blah = "blah_gst_copy";
                    } 
                    else 
                    { 
                    $emp_files = $salary; 
                    $folder = "salary";
                    $blah = "blah_salary_slip";
                    }
                ?>

                <div class="col-sm-6 col-md-4 form-group">
                                <label class="star">Photo </label>
                                <input type="file" class="form-control preview_crop" id="photo" name="photo" autocomplete="off" data-ref='photo'    data-crop="0"  accept=".jpg,.jpeg,.png" data-toggle="tooltip" data-placement="top" title="Photo Passport size with white background"/>
                                <p class="fail" id="photoEmpty"></p><p class="fail" id="photoSizeError"></p>
                                <div class="blah">
                                    <img id="blah_photo" class="img-fluid " src="images/employee_directory/<?php echo $registration_id.'/photo/'.$emp_files.'/'.$photo;?>" alt="your image" style="display: block;"/>
                                </div>
                </div>
          
                <div class="col-sm-6 col-md-4 form-group">
                                <label class="star">Individual Pan Card</label>
                                <input type="file" class="form-control preview_crop" id="pan_copy" name="pan_copy" autocomplete="off" data-ref='pan_copy' data-crop="0"  accept=".jpg,.jpeg,.png" data-toggle="tooltip" data-placement="top" title="Individual Pan Card"/>
                                <p class="fail" id="panCopyEmpty"></p><p class="fail" id="panSizeError"></p>
                                <div class="blah">
                                    <img id="blah_pan_copy" class="img-fluid " src="images/employee_directory/<?php echo $registration_id.'/pan_copy/'.$emp_files.'/'.$pan_copy;?>" alt="your image" style="display: block;"/>
                                </div>
                                
                            </div>
             
                <?php if($designation_type =='Employee'){ ?>

                <div class="col-sm-6 col-md-4 form-group">
                    <label class="star">Salary Slip / Bank Statment :</label>

                    <input type="file" class="form-control preview_crop" id="salary_slip" name="salary_slip" autocomplete="off"  data-ref='salary_slip'     data-crop="0" autocomplete="off" accept=".jpg,.jpeg,.png" data-toggle="tooltip" data-placement="top" title="Salary Slip / Bank Statment/ Recommendation Letter CA Certification" />

                    <p class="fail" id="salarySlipEmpty"></p>
                    <div class="blah">
                    <img id="blah_salary_slip" src="images/employee_directory/<?php echo $registration_id.'/'.$folder.'/'.$emp_files.'/'.$salary_slip_copy;?>"  style="display: block;" >
                    </div>
                </div>
           
                <?php }else if($designation_type =='Owner'){?>
                
                <div class="col-sm-6 col-md-4 form-group">
                    <label class="star">GST Certificate :</label>
                    <input type="file" class="form-control preview_crop" id="gst_copy" name="gst_copy" aautocomplete="off" data-ref='gst_copy' data-crop="0" accept=".jpg,.jpeg,.png" data-toggle="tooltip" data-placement="top" title="GST certificate/ Partnership deed/ Memorandum of Article of Association stating your name"   />
                    <p class="fail" id="gstCopyEmpty"></p>
                    <div class="blah">
                    <img id="blah_gst_copy" src="images/employee_directory/<?php echo $registration_id.'/'.$folder.'/'.$emp_files.'/'.$gst_copy;?>"         style="display: block;">
                </div>
                </div>
            
                <?php } ?>
        
                <div class="col-12 form-group">
                    <input type="submit" name="send_otp"  value="Update" class="btn btn-submit" >
                    <input type="hidden" name="action" value="UpdateVisitor">
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
<!--container ends-->
<!--footer starts-->
<div class="footer">
    <?php include ('footer.php'); ?>
</div>
</div>
<!--footer ends-->

<link rel="stylesheet" type="text/css" href="css/new_style.css" />
</body>
</html>
<?php include('header_include.php');
$registration_id = $_SESSION['registration_id'];
/*echo $registration_id ;exit;*/
/*print_r($_SESSION['USERID']);*/
/*if(!isset($_SERVER['HTTP_REFERER']))
{
session_unset($registration_id);
header("location:index.php");
}*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Welcome to IIJS Registration</title>
        <link rel="shortcut icon" href="images/fav.png" />
        <link rel="stylesheet" type="text/css" href="css/mystyle.css?v=<?php echo $version;?>" />
        <link rel="stylesheet" type="text/css" href="https://gjepc.org/assets-new/css/bootstrap.min.css" />
        <link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Cabin'>
        <link rel="stylesheet" type="text/css" href="css/general.css?v=<?php echo $version;?>" />
        <link rel="stylesheet" type="text/css" href="css/inner_pg_style.css?v=<?php echo $version;?>" />
        <link rel="stylesheet" type="text/css" href="css/responsive.css?v=<?php echo $version;?>" />
        <link rel="stylesheet" type="text/css" href="css/media_query.css?v=<?php echo $version;?>" />
        <link rel="stylesheet" type="text/css" href="css/visitor_reg.css?v=<?php echo $version;?>" />
        <link rel="stylesheet" type="text/css" href="css/face_detection.css?v=<?php echo $version;?>" />
        <script type="text/javascript" src="https://gjepc.org/assets-new/js/jquery.min.js?v=<?php echo $version;?>"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script src="https://gjepc.org/assets-new/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" ></script>
        <!--NAV-->
        <link href="css/flexnav.css?v=<?php echo $version;?>" media="screen, projection" rel="stylesheet" type="text/css">
        <script src="js/jquery.flexnav.js?v=<?php echo $version;?>" type="text/javascript"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" ></script>
        <script src="js/common.js"></script>
        <!--NAV-->
        
        <!-- CROPPER JS START-->
        <link href="https://unpkg.com/cropperjs/dist/cropper.css" rel="stylesheet"/>
        <script src="https://unpkg.com/dropzone"></script>
        <script src="https://unpkg.com/cropperjs"></script>
        <!-- CROPPER JS END -->

        

        <script src="jsvalidation/jquery.validate.js?v=<?php echo $version;?>" type="text/javascript"></script>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-178505237-1"></script>
        <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'UA-178505237-1');
        </script>
        <!-- Global site tag (gtag.js) - Google Ads: 679056788 --><!--  <script async src="https://www.googletagmanager.com/gtag/js?id=AW-679056788"></script> <script> window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag('js', new Date()); gtag('config', 'AW-679056788'); </script> -->
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
        $("#single_visitor_add").on("submit",function(e){
        e.preventDefault();
        var form = $('#single_visitor_add');
        var formdata = false;
        if(window.FormData){
        formdata = new FormData(form[0]);
        }
        /* alert(formdata);return false;*/
        $.ajax({
        type:'POST',
        url:"singleVisitorAjaxTest.php",
        data:formdata ? formdata : form.serialize(),
        dataType: "json",
        cache:false,
        contentType: false,
        processData: false,
        beforeSend:function(){
        $('.loaderWrapper').show();
        },
        success:function(data){
        $('.loaderWrapper').delay(1000).fadeOut();
        if(data['status'] == "designationTypeEmpty"){
        $("#designationTypeEmpty").text("Designation Type is Required");
        }else if(data['status'] == "designationEmpty"){
        $("#designationEmpty").text("Designation is Required");
        }else if(data['status'] == "fnameEmpty"){
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
        }else if(data['status'] == "photoEmpty"){
        $("#photoEmpty").text("Photo is Required");
        }else if(data['status'] == "panCopyEmpty"){
        $("#panCopyEmpty").text("Pan Copy is Required");
        }else if(data['status'] == "gstCopyEmpty"){
        $("#gstCopyEmpty").text("GST Copy is Required");
        }else if(data['status'] == "SalarySlipEmpty"){
        $("#salarySlipEmpty").text("Salary Slip is Required");
        }else if(data['status'] == "invalidEmail"){
        $("#emailEmpty").text("Please Enter Valid Email");
        }else if(data['status'] == "invalidPanNumber"){
        $("#panEmpty").text("Please Enter Valid Pan Number");
        }else if(data['status'] == "panExist"){
        $("#panEmpty").text("Pan number already exist");
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
        $("#emailEmpty").text("Email Id already exist ");
        }else if(data['status'] == "mobileExist"){
        $("#mobileEmpty").text("Mobile Number already exist");
        }else if(data['status'] == "error"){
        $("#"+data['label']).text(data['message']);
        }else if(data['status'] == "insertSuccess"){
        
        setTimeout(function(){
        window.location = "Visitor_registration_success.php";
        }, 1000);
        }
        }
        });
        });
        });
        
        $(document).ready(function(){
        $('input[name="designationType"]').click(function(){
        var designation = $('[name="designationType"]:checked').val();
        
        //alert(designation);
        $.ajax({
        type: 'POST',
        url: 'ajax.php',
        data: "actiontype=checkDesignationSingleVisitor&designation="+designation,
        dataType:'html',
                            beforeSend: function(){
                            $('.loaderWrapper').show();
                            },
        success: function(data)
        {
        setTimeout(function(){
        $('.loaderWrapper').fadeOut();
                            }, 1000);
        
        $("#Owner_degn").html(data);
        $("#designationTypeEmpty").text("");
        }
        });
        });
        });
        
        $(document).ready(function(){
        $(function () {
          $('[data-toggle="tooltip"]').tooltip()
        })
        $('#blah_salary_slip').hide();
        $('#blah_salary').hide();

        $("input[name='designationType']").change(function(e){
        e.preventDefault();
        var radioValue = $('[name="designationType"]:checked').val();
        /*alert(radioValue); */
        /*alert("hgh");*/
        if(radioValue =="Owner"){
        $('#gstCopy').show();
        $('#gst_copy').show();
        $('#salaryCopy').hide();
        $('#salary_slip').hide();
        $('#blah_salary_slip').hide();
        $('#blah_salary').hide();
        $('#blah_gst_copy').show();
        $('#blah_gst').show();
        }else if(radioValue =="Employee"){
        $('#gstCopy').hide();
        $('#gst_copy').hide();
        $('#salary_slip').show();
        $('#salaryCopy').show();
        $('#blah_salary').show();
        $('#blah_salary_slip').show();
        $('#blah_gst_copy').hide();
        $('#blah_gst').hide();
        }
        });
        });

        
        $(document).ready(function() {
        jQuery.validator.addMethod("specialChrs", function (value, element) {
        if (/[^a-zA-Z 0-9\-]+$/i.test(value)) {
        return false;
        } else {
        return true;
        };
        },  "Special Characters Not Allowed");
        
        jQuery.validator.addMethod("Chrs", function (value, element) {
        if (/[^a-zA-Z\-]+$/i.test(value)) {
        return false;
        } else {
        return true;
        };
        },  "Only Characters are Allowed");
        
        jQuery.validator.addMethod("panno", function (value, element) {
        var regExp = /[a-zA-z]{5}\d{4}[a-zA-Z]{1}/;
        if (value.match(regExp) ) {
        return true;
        } else {
        return false;
        };
        },"Not valid PAN no");
        
        $("#check_company_pan").validate({
        rules: {
        company_pan_no:{
        required:true,
        panno: true,
        minlength: 10,
        maxlength:10
        }
        },
        messages: {
        company_pan_no:{
        required: "Pan No is required",
        minlength:"Please Enter Correct PAN NO",
        maxlength:"Please Enter no more than {0} digit."
        }
        },
        submitHandler: companyPanAction
        });
        });
        function companyPanAction(){
        var formdata = $('#check_company_pan').serialize();
        $.ajax({
        type:'POST',
        data:formdata,
        url:"singleVisitorAjax.php",
        dataType: "json",
        beforeSend: function(){
        $('.loaderWrapper').show();
        },
        success:function(data){
        
        if(data['status'] == "exist"){
        
        $('#company_name').text(data.company_name);
        $('#check_company_pan').hide();
        $('#single_visitor_add').show();
        $('.loaderWrapper').delay(2000).fadeOut();
        }else if(data['status'] == 'exhibitor'){
        $('#check_company_pan').show();
        $('#single_visitor_add').hide();
        $("#chkPendingPANStatus").html("You are Exhibitor");
        $('.loaderWrapper').delay(2000).fadeOut();
                }else if(data['status'] == "deActive"){
        $('#chkPendingPANStatus').text("Your Company PAN Number Deactivated");
        $('#check_company_pan').show();
        $('#single_visitor_add').hide();
        $('.loaderWrapper').delay(2000).fadeOut();
        }else if(data['status'] == "notExist"){
        setTimeout(function(){
        window.location = "domestic_user_registration_step1.php";
        }, 1000);
        }
        }
        });
        }
        
        
       
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

       
        $(document).ready(function(){
            $("#self_report").change(function(){
                readUrlvaccineCertificate(this);
            });
            $('.Number').keypress(function (event) {
                var keycode = event.which;
                if (!(event.shiftKey == false && (keycode == 46 || keycode == 8 || keycode == 37 || keycode == 39 || (keycode >= 48 && keycode <= 57)))) {
                    event.preventDefault();
                }
            });
        });
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
       
        <script>
        photoValidation = () => {
        const fi = document.getElementById('photo');
        // Check if any file is selected.
        if (fi.files.length > 0) {
        for (const i = 0; i <= fi.files.length - 1; i++) {
        
        const fsize = fi.files.item(i).size;
        const file = Math.round((fsize / 1024));
        // The size of the file.
        if (file >= 4096) {
        //alert("File too Big, please select a file less than 2MB");
                            $("#photoSizeError").text("Please select a file less than 4MB");
        } /* else if(file < 2048) {
        alert(
        "File too small, please select a file greater than 2mb");
        }  else {
        document.getElementById('size').innerHTML = '<b>'
        + file + '</b> KB';
        } */
        }
        }
        }
            
            panValidation = () => {
        const fi = document.getElementById('pan_copy');
        // Check if any file is selected.
        if (fi.files.length > 0) {
        for (const i = 0; i <= fi.files.length - 1; i++) {
        
        const fsize = fi.files.item(i).size;
        const file = Math.round((fsize / 1024));
        // The size of the file.
        if (file >= 4096) {
        //alert("File too Big, please select a file less than 2MB");
                            $("#panSizeError").text("Please select a file less than 4MB");
        } /* else if(file < 2048) {
        alert(
        "File too small, please select a file greater than 2mb");
        }  else {
        document.getElementById('size').innerHTML = '<b>'
        + file + '</b> KB';
        } */
        }
        }
        }
        </script>
        <style>
        #salary_slip{display: none}
        </style>
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
            <!-- <div class="new_banner">
                <img src="images/banners/banner.jpg">
            </div> -->
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
                                        <img src="" id="crop_image" class="img-fluid h-100 w-100" />
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
                                    <p> Please Wait....</p>
                                </div>
                            </div>
                            
                            <form method="POST" id="check_company_pan" autocomplete="off">
                                <div class="row">
                                    <div class="col-12 form-group">
                                        <h3 class="fail text-left">Your Pan Number Does not Exist Please Insert Your Company Pan Number For Registration</h3>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="star">Company Pan No:</label>
                                        <input type="text" class="form-control pan_no" id="company_pan_no" name="company_pan_no" value="" maxlength="10" autocomplete="off"/>
                                        <p id="chkPendingPANStatus" style="color:#FF0000; display:block;"></p>
                                    </div>
                                    <div class="col-12">
                                        <input type="submit" name="submit" id="submit" value="Submit" class="btn btn-submit" >
                                        <input type="hidden" name="action" value="check_company_pan">
                                    </div>
                                </div>
                                
                            </form>
                            
                            <form class="" id="single_visitor_add" enctype="multipart/form-data" autocomplete="off">
                                <div class="row">
                                    
                                    <div class="col-sm-6 col-md-4 form-group">
                                        <label class="star">Company:</label>
                                        <p id="company_name"></p>
                                    </div>
                                    
                                    <div class="col-sm-6 col-md-4 form-group">
                                        <label class="star">Designation Type:</label>
                                        
                                        <div class="row">
                                            <div class="col-auto">
                                                <label class="container_radio"><span class="check_text">Owner</span>
                                                <input type="radio"  id="designationType" name="designationType" value="Owner">
                                                <span class="checkmark_radio"></span>
                                            </label>
                                        </div>
                                        
                                        <div class="col-auto">
                                            <label class="container_radio"><span class="check_text">Employee</span>
                                            <input type="radio" id="designationType" name="designationType" value="Employee">
                                            <span class="checkmark_radio"></span>
                                        </label>
                                    </div>
                                </div>
                                <p id="designationTypeEmpty" class="fail"></p>
                            </div>
                            
                            <div class="col-sm-6 col-md-4 form-group">
                                <label class="star">Designation:</label>
                                <div id="Owner_degn">
                                    
                                    <select class="select-control" name="designation" id="designation">
                                        <option value="" <?php echo $_REQUEST['action']=='edit'?'':'selected'?> selected="selected">-- Select Designation-- </option>
                                        <?php if($_REQUEST['action']=='edit'){ ?>
                                        <?php foreach($desgination_data as $k => $v){ ?>
                                        <option value="<?php echo $v['id']?>" <?php echo $v['id'] == $designation?'selected':''?>><?php echo $v['type_of_designation'];?></option>
                                        <?php } ?>
                                        <?php } else { ?>
                                        <?php
                                        $sqlx1= "SELECT * FROM `visitor_designation_master` WHERE type='$degn_type'";
                                        $query1 = $conn->query($sqlx1);
                                        $desgination_data1 = array();
                                        while($row1 = $query1->fetch_assoc()){
                                        array_push($desgination_data1,$row1);
                                        }
                                        ?>
                                        <?php foreach($desgination_data1 as $k1 => $v1){ ?>
                                        <option value="<?php echo $v1['id']?>" <?php echo $v1['id'] == $designation?'selected':''?>><?php echo $v1['type_of_designation'];?></option>
                                        <?php } ?>
                                        <?php } ?>
                                    </select>
                                </div>
                                <p id="designationEmpty" class="fail"></p>
                            </div>
                            
                            <div class="col-sm-6 col-md-4 form-group">
                                <label class="star">First Name:</label>
                                <input type="text" class="form-control"  onkeypress="return onlyAlphabets(event,this);" id="first_name" name="first_name" autocomplete="off" maxlength="14" />
                                <p class="fail" id="fnameEmpty"></p>
                            </div>
                            
                            <div class="col-sm-6 col-md-4 form-group">
                                <label class="star">Last Name:</label>
                                <input type="text" class="form-control" id="last_name"  onkeypress="return onlyAlphabets(event,this);" name="last_name" autocomplete="off" maxlength="14"/>
                                <p class="fail" id="lnameEmpty"></p>
                            </div>
                            <div class="col-sm-6 col-md-4 form-group">
                                <label class="star">Gender:</label>
                                <select class="select-control" name="gender" id="gender">
                                    <option value="">--Select Gender--</option>
                                    <option value="M">Male</option>
                                    <option value="F">Female</option>
                                    <option value="T">Transgender</option>
                                </select>
                                <p class="fail" id="genderEmpty"></p>
                            </div>
                            
                            <div class="col-sm-6 col-md-4 form-group">
                                <label class="star">Mobile No:</label>
                                <input type="text" class="form-control Number" id="mobile_no" name="mobile_no" autocomplete="off" maxlength="10"/>
                                <p class="fail" id="mobileEmpty"></p>
                            </div>
                            
                            <div class="col-sm-6 col-md-4 form-group">
                                <label class="star">Email-Id:</label>
                                <input type="text" class="form-control" id="email_id" name="email_id" autocomplete="off"/>
                                <p class="fail" id="emailEmpty"></p>
                            </div>
                            
                            <div class="col-sm-6 col-md-4 form-group">
                                <label>Aadhaar No:</label>
                                <input type="text" class="form-control Number" id="adhaar_no" name="adhaar_no" autocomplete="off" maxlength="12" minlength="12"/>
                                <p class="fail" id="adhaarEmpty"></p>
                            </div>
                            
                            <div class="col-12 form-group">
                                <div class="row">
                                    <div class="col-sm-6 col-md-4">
                                        <label class="star">Pan No:</label>
                                        <input type="text" class="form-control" id="pan_no" name="pan_no" autocomplete="off" maxlength="10"/>
                                        <p class="fail" id="panEmpty"></p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <p>Note: Image files .jpg, jpeg, .png and max 2MB  </p>
                            </div>
                            <div class="col-sm-6 col-md-4 form-group">
                                <label class="star">Photo </label>
                              
                                    <a class="btn border btn-block text-left"  href="javascript:void(0)" id="openFaceDetectionModal"> <i class="fa fa-camera"></i>  Capture your photo</a>
                                     <input type="hidden" name="photo" id="photo" value="" >
                                <!-- <input type="file" class="form-control preview_crop" id="photo" name="photo" autocomplete="off" data-ref='photo'    data-crop="0"  accept=".jpg,.jpeg,.png" data-toggle="tooltip" data-placement="top" title="Photo Passport size with white background"/> -->
                                <!-- <input type="file" class="form-control preview_crop" id="photo" name="photo" autocomplete="off" data-ref='photo'    data-crop="0"  accept=".jpg,.jpeg,.png" data-toggle="tooltip" data-placement="top" title="Photo Passport size with white background"/> -->
                                <p class="fail" id="photoEmpty"></p><p class="fail" id="photoSizeError"></p>
                                <div class="blah">
                                    <img id="blah_photo" class="img-fluid " src="/images/user_img.png" alt="your image" style="display: block;"/>
                                </div> 
                            </div>
                            
                            <div class="col-sm-6 col-md-4 form-group">
                                <label class="star">Individual Pan Card</label>
                                <input type="file" class="form-control preview_crop" id="pan_copy" name="pan_copy" autocomplete="off" data-ref='pan_copy' data-crop="0"  accept=".jpg,.jpeg,.png" data-toggle="tooltip" data-placement="top" title="Individual Pan Card"/>
                                <p class="fail" id="panCopyEmpty"></p><p class="fail" id="panSizeError"></p>
                                <div class="blah">
                                    <img id="blah_pan_copy" class="img-fluid " src="/images/pan_image.jpeg" alt="your image" style="display: block;"/>
                                </div>
                                
                            </div>
                            
                            
                            <div class="col-sm-6 col-md-4 form-group">

                                <label class="star" id="salaryCopy" >Salary Slip  </label>
                                <label class="star" id="gstCopy">GST certificate</label>
                                <input type="file" class="form-control preview_crop" id="salary_slip" name="salary_slip" data-ref='salary_slip'     data-crop="0" autocomplete="off" accept=".jpg,.jpeg,.png" data-toggle="tooltip" data-placement="top" title="Salary Slip / Bank Statment/ Recommendation Letter CA Certification"  />
                                
                                
                                <input type="file" class="form-control preview_crop" id="gst_copy" name="gst_copy" autocomplete="off" data-ref='gst_copy' data-crop="0" accept=".jpg,.jpeg,.png" data-toggle="tooltip" data-placement="top" title="GST certificate/ Partnership deed/ Memorandum of Article of Association stating your name" />
                                <p class="fail" id="gstCopyEmpty"></p>
                                <div class="blah" id="blah_salary">
                                <p class="fail" id="salarySlipEmpty"></p>    
                                    <img id="blah_salary_slip" src="/images/Basic-Salary-Slip.jpg" class="img-fluid " alt="your image" style="display:block;"/ >
                                </div>
                                <div class="blah" id="blah_gst">
                                    <img id="blah_gst_copy" src="/images/GST-Certificate-Sample.png" class="img-fluid " alt="your image" style=""/>
                                </div>
                                
                            </div>
                            <!--    <div class="d-flex flex-row">
                                <div class=" form-group col-100">
                                    
                                    <label><b>Are you uploading ?</b>  <sup>*</sup><br>&nbsp;</label>
                                    <label style="display:inline;"><input type="radio" name="certificate" value="rtpcr">&nbsp;<span>RT-PCR</span></label>&nbsp;&nbsp;
                                    <label style="display:inline;"><input type="radio" name="certificate" value="vaccine">&nbsp;<span>Vaccine certificate</span></label>
                                    <div>
                                        <label id="certificateEmpty" generated="true" class="error" > </label>
                                    </div>
                                    
                                    
                                    
                                </div>
                                <div class=" form-group col-100">
                                    <div class="col-100 d-flex flex-column ">
                                        <label class="star">Vaccination/RT-PCR Certificate : (Max 2MB.jpg, .png, .pdf) :</label><br>
                                        <input type="file" class="form-control" id="self_report" name="self_report" autocomplete="off" accept=".jpg,.jpeg,.png" />
                                        <p class="fail" id="self_reportEmpty"></p>
                                        <img id="blah5" src="#" alt="your image" style="max-width: 200px;height: auto;"/>
                                    </div>
                                </div>
                                
                                <div class=" form-group col-100"></div>
                            </div> -->
                            <div class="col-12 form-group">
                                <label><input type="checkbox" name="agree" checked="checked">I Agree and accept that all the information provided by me is authentic and i do not wish to misrepresent any data</label>
                            </div>
                            <div class="col-12">
                                <input type="submit" name="submit" value="Submit" class="btn btn-submit">
                                <input type="hidden" name="action" value="AddVisitor">
                            </div>
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
</body>
</html>
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
  <title>Welcome to IIJS  Registration</title>
  <link rel="shortcut icon" href="images/fav.png" />
  <link rel="stylesheet" type="text/css" href="css/mystyle.css?v=<?php echo $version;?>" />
  <link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Cabin'>
  <link rel="stylesheet" type="text/css" href="css/general.css?v=<?php echo $version;?>" />
  <link rel="stylesheet" type="text/css" href="css/inner_pg_style.css?v=<?php echo $version;?>" />  
  <link rel="stylesheet" type="text/css" href="css/responsive.css?v=<?php echo $version;?>" />
    <link rel="stylesheet" type="text/css" href="css/media_query.css?v=<?php echo $version;?>" />
  <link rel="stylesheet" type="text/css" href="css/visitor_reg.css?v=<?php echo $version;?>" />
  <script type="text/javascript" src="js/jquery-1.8.3.min.js?v=<?php echo $version;?>"></script>

  <!--NAV-->
  <link href="css/flexnav.css?v=<?php echo $version;?>" media="screen, projection" rel="stylesheet" type="text/css">
  <script src="js/jquery.flexnav.js?v=<?php echo $version;?>" type="text/javascript"></script>
  <script src="js/common.js"></script> 
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
          $('#blah4').hide();
          $('#blah3').hide();
        }else if(radioValue =="Employee"){
        $('#gstCopy').hide();
        $('#gst_copy').hide();
        $('#salary_slip').show();
          $('#salaryCopy').show();
           $('#blah3').hide();
           $('#blah4').hide();
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
          
          $(document).ready(function(){

$('.Number').keypress(function (event) {
    var keycode = event.which;
    if (!(event.shiftKey == false && (keycode == 46 || keycode == 8 || keycode == 37 || keycode == 39 || (keycode >= 48 && keycode <= 57)))) {
        event.preventDefault();
    }
});
function readUrlPhoto(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#blah1').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
         $('#blah1').show();
    }
}

$("#photo").change(function(){
  /*alert("hii");return false;*/
    readUrlPhoto(this);

});
function readUrlPanCopy(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#blah2').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
        $('#blah2').show();
    }
}

$("#pan_copy").change(function(){
  /*alert("hii");return false;*/
    readUrlPanCopy(this);

});
function readUrlSalarySlip(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#blah3').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
        $('#blah3').show();
    }
}

$("#salary_slip").change(function(){
  /*alert("hii");return false;*/
    readUrlSalarySlip(this);

});
function readUrlGstCopy(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#blah4').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
        $('#blah4').show();
    }
}

$("#gst_copy").change(function(){
  /*alert("hii");return false;*/
    readUrlGstCopy(this);

});
 $('#blah5').hide();
function readUrlvaccineCertificate(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#blah5').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
        $('#blah5').show();
    }
}

$("#self_report").change(function(){

    readUrlvaccineCertificate(this);

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

    <!--container starts-->
    <div class="container_wrap">
       <div class="container">

           <div class="bold_font text-center">
              <div class="d-block">
                  <img src="https://www.gjepc.org/assets/images/gold_star.png" class="">
              </div>
            IIJS SIGNATURE -  Registration
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
           <div class="d-flex flex-column ">
             <div class="d-flex flex-row">
                <div class="col-100 d-flex justify-around flex-wrap form-group">
           <h3 class="fail">Your Pan Number Does not Exist Please Insert Your Company Pan Number For Registration</h3>  
                </div>
             </div>

            <div class="d-flex flex-row">
                <div class="col-50 col-m-100 d-flex justify-around flex-wrap form-group">
                  <div class="col-50 col-m-100 d-flex align-center">
                    <label class="star">Company Pan No:</label>
                </div>
                <div class="col-50 col-m-100">
                    <input type="text" class="form-control pan_no" id="company_pan_no" name="company_pan_no" value="" maxlength="10" autocomplete="off"/>
                    <p id="chkPendingPANStatus" style="color:#FF0000; display:block;"></p>
                </div>
            </div>
          <!--   <div class="col-50 col-m-100 d-flex justify-around flex-wrap form-group"> </div> -->
      </div>
      </div>
    <div class="d-flex flex-column ">
    <div class="d-flex flex-row">
      <div class="col-50 col-m-100 d-flex  flex-wrap form-group">
        <input type="submit" name="submit" id="submit" value="Submit" class="btn btn-submit" >
        <input type="hidden" name="action" value="check_company_pan">
      </div>      
    </div>
    </div>
    </form> 
        <form class=""  id="single_visitor_add" enctype="multipart/form-data" autocomplete="off"> 

           <div class="d-flex flex-column">             
             <div class="d-flex flex-row">
                <div class="col-50 col-m-100 d-flex justify-around flex-wrap form-group">
                  <div class="col-50 col-m-100 d-flex align-center">
                    <label class="star">Company:</label>
                </div>
                <div class="col-50 col-m-100">
                    <p id="company_name"></p>                   
                </div>
            </div>
            <div class="col-50 col-m-100 d-flex justify-around flex-wrap form-group">
                  
      </div>
      </div>
                <div class="d-flex flex-row">
      <div class="col-50 col-m-100 d-flex justify-around flex-wrap form-group ">
        <div class="col-50 col-m-100 d-flex align-center">
          <label class="star">Designation Type:</label>
        </div>
        <div class="col-50 col-m-100 d-flex justify-flex-start align-center">
          <label class="container_radio"><span class="check_text">Owner</span>
            <input type="radio"  id="designationType" name="designationType" value="Owner" >
            <span class="checkmark_radio"></span>
          </label>
          <label style="width: 20px;"></label>
          <label class="container_radio"><span class="check_text">Employee</span>
            <input type="radio"  id="designationType" name="designationType" value="Employee" >
            <span class="checkmark_radio"></span>
          </label>
          
        </div>
        <p id="designationTypeEmpty" class="fail"></p>
        </div>
                 <div class="col-50 col-m-100 d-flex justify-around flex-wrap form-group">
                  <div class="col-50 col-m-100 d-flex align-center">
                    <label class="star">Designation:</label>
                </div>
                <div class="col-50 col-m-100">
                      <div  id="Owner_degn">
               
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
            </div>
        </div>
       
            <div class="d-flex flex-row">
                <div class="col-50 col-m-100 d-flex justify-around flex-wrap form-group">
                  <div class="col-50 col-m-100 d-flex align-center">
                    <label class="star">First Name:</label>
                </div>
                <div class="col-50 col-m-100">
                    <input type="text" class="form-control"  onkeypress="return onlyAlphabets(event,this);" id="first_name" name="first_name" autocomplete="off" maxlength="14" />
                    <p class="fail" id="fnameEmpty"></p>
                </div>
            </div>
            <div class="col-50 col-m-100 d-flex justify-around flex-wrap form-group">
                   <div class="col-50 col-m-100 d-flex align-center">
                       <label class="star">Last Name:</label>
                </div>
                <div class="col-50 col-m-100">
                    <input type="text" class="form-control" id="last_name"  onkeypress="return onlyAlphabets(event,this);" name="last_name" autocomplete="off" maxlength="14"  />
                    <p class="fail" id="lnameEmpty"></p>
                </div>
      </div>
      </div>


              <div class="d-flex flex-row">
                <div class="col-50 col-m-100 d-flex justify-around flex-wrap form-group">
                  <div class="col-50 col-m-100 d-flex align-center">
                    <label class="star">Gender:</label>
                </div>
                <div class="col-50 col-m-100">
                  <select class="select-control" name="gender" id="gender">
                    <option value="">--Select Gender--</option>
                    <option value="M">Male</option>
                    <option value="F">Female</option>
                    <option value="T">Transgender</option>
                  </select>
                  <p class="fail" id="genderEmpty"></p>
                    
                </div>
            </div>
            <div class="col-50 col-m-100 d-flex justify-around flex-wrap form-group">
                   <div class="col-50 col-m-100 d-flex align-center">
                       <label class="star">Mobile No:</label>
                </div>
                <div class="col-50 col-m-100">
                    <input type="text" class="form-control Number" id="mobile_no" name="mobile_no" autocomplete="off" maxlength="10"   />
                  <p class="fail" id="mobileEmpty"></p>

                </div>
      </div>
      </div>
                <div class="d-flex flex-row">
                <div class="col-50 col-m-100 d-flex justify-around flex-wrap form-group">
                  <div class="col-50 col-m-100 d-flex align-center">
                    <label class="star">Email-Id:</label>
                </div>
                <div class="col-50 col-m-100">
                    <input type="text" class="form-control" id="email_id" name="email_id" autocomplete="off"   />
                  <p class="fail" id="emailEmpty"></p>

                </div>
            </div>
            <div class="col-50 col-m-100 d-flex justify-around flex-wrap form-group">
                   <div class="col-50 col-m-100 d-flex align-center">
                       <label >Adhaar No:</label>
                </div>
                <div class="col-50 col-m-100">
                    <input type="text" class="form-control Number" id="adhaar_no" name="adhaar_no" autocomplete="off" maxlength="12" minlength="12"  />
                  <p class="fail" id="adhaarEmpty"></p>

                </div>
      </div>
      </div>
         <div class="d-flex flex-row">
                <div class="col-50 col-m-100 d-flex justify-around flex-wrap form-group">
                  <div class="col-50 col-m-100 d-flex align-center">
                    <label class="star">Pan No:</label>
                </div>
                <div class="col-50 col-m-100">
                    <input type="text" class="form-control" id="pan_no" name="pan_no" autocomplete="off" maxlength="10"  />
                    <p class="fail" id="panEmpty"></p>

                </div>
            </div>
            <div class="col-50 col-m-100 d-flex justify-around flex-wrap form-group">
       
      </div>
          
      </div>


      
               <div class="d-flex flex-row">
                  <div class=" form-group col-100">
                    <div class="col-100 d-flex flex-column ">
                      <label class="star">Photo Passport size with white background : (Max 2MB.jpg, .png, .pdf) :</label><br>
                      <input type="file" class="form-control" id="photo" name="photo" autocomplete="off" accept=".jpg,.jpeg,.png" />
                      <p class="fail" id="photoEmpty"></p>
                      <img id="blah1" src="#" alt="your image" style="max-width: 200px;height: auto;"/>
                    </div> 
                  </div>
                <div class="form-group col-100">
                  <div class="col-100 d-flex flex-column  ">
                    <label class="star">Individual Pan Card : (Max 2MB.jpg, .png, .pdf)</label><br><br>  
                      <input type="file" class="form-control" id="pan_copy" name="pan_copy" autocomplete="off" accept=".jpg,.jpeg,.png"  />
                  <p class="fail" id="panCopyEmpty"></p>
                    <img id="blah2" src="#" alt="your image" style="max-width: 200px;height: auto;"/>
                </div>
           
            </div>
        
            <div class="form-group col-100" >
                  <div class="col-100 d-flex flex-column ">
                    <label class="star" id="salaryCopy">Salary Slip / Bank Statment/ Recommendation Letter CA Certification: (Max 2MB.jpg, .png, .pdf)</label>
                    <label class="star" id="gstCopy">GST certificate/ Partnership deed/ Memorandum of Article of Association stating your name : (Max 2MB.jpg, .png, .pdf)</label>
                    <input type="file" class="form-control" id="salary_slip" name="salary_slip" autocomplete="off" accept=".jpg,.jpeg,.png"  />
                    <p class="fail" id="salarySlipEmpty"></p>
                    <input type="file" class="form-control" id="gst_copy" name="gst_copy" autocomplete="off" accept=".jpg,.jpeg,.png"  />
                    <p class="fail" id="gstCopyEmpty"></p>
                    <img id="blah3" src="#" alt="your image" style="max-width: 200px;height: auto;"/>
                    <img id="blah4" src="#" alt="your image" style="max-width: 200px;height: auto;"/>

                </div>
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
           <div class="d-flex flex-row">
           	 <div class=" form-group col-100">
           	 	<label><input type="checkbox" name="agree" checked="checked">I Agree and accept that all the information provided by me is authentic and i do not wish to misrepresent any data</label>
           
           	 </div>
           </div>
            
          
   
    <div class="d-flex flex-column">
    <div class="d-flex flex-row">
      <div class="col-50 col-m-100 d-flex  flex-wrap form-group">
        <input type="submit" name="submit"  value="Submit" class="btn btn-submit" >
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
<!--container ends-->
<!--footer starts-->
<div class="footer_wrap">
    <?php include ('footer.php'); ?>
</div>
</div>
<!--footer ends-->
</body>
</html>
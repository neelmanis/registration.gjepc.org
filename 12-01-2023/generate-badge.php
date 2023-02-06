
<?php
include('header_include.php');

$sql = "SELECT * FROM `visitor_event_master` WHERE `status` ='1'  order by `id` desc ";
$result = $conn->query($sql);
$count = $result->num_rows;
if($count > 0){
  $row = $result->fetch_assoc();
   $event_name = $row['event_name'];
   $registration_start_date = $row['registration_start_date'];
   $registration_close_date = $row['registration_close_date'];
}
$message_warning ="";
$pan_no = "";
$mobile = "";
$email = "";

$action=$_REQUEST['action'];
if($action=="generate_badge"){
   $category = filter($_REQUEST['category']);
 
    $mobile = filter($_REQUEST['mobile']);
    $email = filter($_REQUEST['email']);

    if($category == "VIS" || $category == "IGJME"){
      $pan_no = filter($_REQUEST['pan_no']);
       
      $sql = "SELECT * FROM  globalExhibition WHERE pan_no='$pan_no' AND ( participant_Type ='VIS' OR participant_Type='IGJME') and event!='iijstritiya23'";
      $result = $conn->query($sql);
      $row = $result->fetch_assoc();
      $count = $result->num_rows;
      if($count > 0){
      $uniqueId = $row['uniqueIdentifier'];
       $badge_link = 'https://registration.gjepc.org/visitor-badge.php?action=generateBadge&uniqueIdentifier='.$uniqueId;
      header('Location: '.$badge_link);
      }else{
        $message_warning = "Visitor pan number not found in system";
    }

  }else if($category == "INTL"){

      $email = filter($_REQUEST['email']);
       
      $sql = "SELECT * FROM  globalExhibition WHERE email='$email' AND  participant_Type='INTL'  ";

      $result = $conn->query($sql);

      $row = $result->fetch_assoc();
      $count = $result->num_rows;
      if($count > 0){
        $face_status = $row['face_status'];


      $uniqueId = $row['uniqueIdentifier'];
       $badge_link = 'https://registration.gjepc.org/visitor-badge.php?action=generateBadge&uniqueIdentifier='.$uniqueId;
       header('Location: '.$badge_link);
      }else{
        $message_warning = "Visitor Email not found in system";
      }
  }else if($category == "CONTR"){

      $mobile = filter($_REQUEST['mobile']);
       
      $sql = "SELECT * FROM  globalExhibition WHERE mobile='$mobile' AND  participant_Type='CONTR' order by post_date desc ";

      $result = $conn->query($sql);

      $row = $result->fetch_assoc();
      $count = $result->num_rows;
      if($count > 0){
        $face_status = $row['face_status'];
        $agency_category = $row['agency_category'];
        $status = $row['status'];
      if($agency_category =="G"){
        if( $status !="Y" ){
          $message_warning = "Not registered for the show.";
        }
      }
      $uniqueId = $row['uniqueIdentifier'];
       $badge_link = 'https://registration.gjepc.org/visitor-badge.php?action=generateBadge&uniqueIdentifier='.$uniqueId;
       header('Location: '.$badge_link);
      }else{
        $message_warning = "Visitor Mobile not found in system";
      }
  }else if($category == "EXH"){

      $mobile = filter($_REQUEST['mobile']);
       
      $sql = "SELECT * FROM  globalExhibition WHERE mobile='$mobile' AND  participant_Type='EXH'";

      $result = $conn->query($sql);

      $row = $result->fetch_assoc();
      $count = $result->num_rows;
      if($count > 0){
        $face_status = $row['face_status'];
     
      $uniqueId = $row['uniqueIdentifier'];
       $badge_link = 'https://registration.gjepc.org/visitor-badge.php?action=generateBadge&uniqueIdentifier='.$uniqueId;
       header('Location: '.$badge_link);
      }else{
        $message_warning = "Visitor Mobile not found in system";
      }
  }else if($category == "EXHM"){

      $mobile = filter($_REQUEST['mobile']);
       
      $sql = "SELECT * FROM  globalExhibition WHERE mobile='$mobile' AND  participant_Type='EXHM'";

      $result = $conn->query($sql);

      $row = $result->fetch_assoc();
      $count = $result->num_rows;
      if($count > 0){
        $face_status = $row['face_status'];
     
      $uniqueId = $row['uniqueIdentifier'];
       $badge_link = 'https://registration.gjepc.org/visitor-badge.php?action=generateBadge&uniqueIdentifier='.$uniqueId;
       header('Location: '.$badge_link);
      }else{
        $message_warning = "Visitor Mobile not found in system";
      }
  }	
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $evt_name;?> Badge Generate </title>
   <link rel="icon" href="https://gjepc.org/assets/images/fav_icon.png" type="image/x-icon"/>
    <!--<link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Cabin'>-->
    <link rel="stylesheet" type="text/css" href="https://gjepc.org/assets-new/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="css/general.css?v=<?php echo $version;?>" />
    <link rel="stylesheet" type="text/css" href="css/inner_pg_style.css?v=<?php echo $version;?>" />
    <link rel="stylesheet" type="text/css" href="css/responsive.css?v=<?php echo $version;?>" />
    <link rel="stylesheet" type="text/css" href="css/media_query.css?v=<?php echo $version;?>" />

    <link rel="stylesheet" type="text/css" href="css/visitor_reg.css?v=<?php echo $version;?>" />
    <script type="text/javascript" src="https://gjepc.org/assets-new/js/jquery.min.js"></script>
    
   <!--NAV-->
  <link href="css/flexnav.css?v=<?php echo $version;?>" media="screen, projection" rel="stylesheet" type="text/css">
  <script type="text/javascript" src="flexnav-master/js/jquery.flexnav.min.js"></script>
  <script src="js/common.js?v=<?php echo $version;?>"></script> 
  <!--NAV-->
    <script src="jsvalidation/jquery.validate.js" type="text/javascript"></script>

    <script type="text/javascript">
    $(document).ready(function() {
        jQuery.validator.addMethod("specialChrs", function (value, element) {
  if(/[^a-zA-Z 0-9\-]+$/i.test(value)) {
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
    
    $("#panForm").validate({
      rules: {
        pan_no:{
          required:true,
          minlength: 10,
          panno: true,
          maxlength:10
        },
       mobile:{
          required:true,
          minlength: 10,
          maxlength:10
        },
        pan_no:{
          required:true,
          minlength: 10,
          panno: true,
          maxlength:10
        },
        email:{
          required:true,
         
        },
      },
      messages: {
        pan_no:{
          required: "Pan No is required",
          minlength:"Please Enter Correct PAN NO",
          maxlength:"Please Enter no more than {0} digit."
        }, 
        mobile:{
          required: "Mobile No is required",
          minlength:"Please Enter Correct Mobile NO",
          maxlength:"Please Enter no more than {0} digit."
        },
        email:{
          required:"E-mail ID is required",         
        },
      }
    });
    });

  $(document).ready(function() {
    $('.numeric').keypress(function (event) {
      var keycode = event.which;
      if (!(event.shiftKey == false && (keycode == 46 || keycode == 8 || keycode == 37 || keycode == 39 || (keycode >= 48 && keycode <= 57)))) 
      {
        event.preventDefault();
      }
    });
    $(".category").click(function(){
      $("#mobile").val('');
      let category = $(this).val();
      let ref = $(this).data("ref");
      let target_div= ref +"_div";
      // // $(".field_wrap").slideUp();
      // $("#"+target_div).slideDown();

      if(category =="VIS" || category=="IGJME"){
        $("#pan_no_div").slideDown();
        $("#mobile_div").slideUp();
        $("#email_div").slideUp();

        $("#pan_no").attr("disabled", false);
        $("#mobile").attr("disabled", true);
        $("#email").attr("disabled", true);
      }else if(category =="INTL"){
        $("#pan_no_div").slideUp();
        $("#mobile_div").slideUp();
        $("#email_div").slideDown();
        $("#pan_no").attr("disabled", true);
        $("#mobile").attr("disabled", true);
        $("#email").attr("disabled", false);
		$("#pan_no").val('');
      }else{
        $("#pan_no_div").slideUp();
        $("#mobile_div").slideDown();
        $("#email_div").slideUp();
        $("#pan_no").attr("disabled", true);
        $("#mobile").attr("disabled", false);
        $("#email").attr("disabled", true);
      }
    });
  });
</script>
  </head>
  <body>
   
    <div class="wrapper">
    <div class="header">
    <?php include('header1.php'); ?>
    <div class="clear"> </div>
  </div>
    <div class="clear"> </div>
    <div class="clear"> </div>
  
      <!--container starts-->
      <div class="container_wrap my-5">
        <div class="container">
     
          <div class="bold_font text-center">
              <div class="d-block">
                  <img src="https://www.gjepc.org/assets/images/gold_star.png" class="">
              </div>
         <?php //echo $evt_name; ?>GENERATE BADGE FOR IIJS SIGNATURE 2023
          </div>
          <div id="loginForm">
            <div class="box-shadow">

              <div class="loaderWrapper">
                <div class="formLoader">
                  <img src="images/formloader.gif" alt="">
                  <p> Please Wait....</p>
                </div>
              </div>
              <div class="formwrapper2 d-block">

                <!--<div style="text-align: center;"><h1 style="font-size: 30px;text-align: center;">Registration has been closed for IIJS PREMIERE 2021</h1></div>-->

                <form id="panForm" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" autocomplete="off">

                <div class="row">

                    <div class="col-12">
                      <input type="radio" name="category" class="category" id="category_vis" value="VIS" data-ref="pan_no" ><label for="category_vis">Domestic Visitor</label>
                    </div>
                     <div class="col-12">
                      <input type="radio" name="category" class="category" id="category_igjme" value="IGJME" data-ref="pan_no" ><label for="category_igjme">Machinery Visitor</label>
                    </div>
                    <div class="col-12">
                      <input type="radio" name="category" class="category" id="category_intl" value="INTL" data-ref="email" ><label for="category_intl">International Visitor</label>
                    </div>
                    <div class="col-12">
                      <input type="radio" name="category" class="category" id="category_exh" value="EXH" data-ref="mobile" ><label for="category_exh">Exhibitor</label>
                    </div>    
                    <div class="col-12" >
                      <input type="radio" name="category" class="category" id="category_contr" value="CONTR" data-ref="mobile" ><label for="category_contr">Committee member / Organizers / GUEST / Agency / Student</label>
                    </div>  
                    <div class="col-md-5 form-group" style="display:none;"  id="pan_no_div">
                      <label><strong>PAN Number</strong></label>
                      <input type="text" class="form-control " id="pan_no" name="pan_no" value="<?php echo $pan_no;?>" maxlength="10" autocomplete="off"/>                    
                    </div>
                    <div class="col-md-5 form-group" style="display:none;" id="mobile_div">
                      <label><strong>Mobile Number</strong></label>
                      <input type="text" class="form-control numeric" id="mobile" name="mobile" value="<?php echo $mobile;?>" maxlength="10" autocomplete="off"/>
                    </div>
                    <div class="col-md-5 form-group" style="display:none;" id="email_div">
                      <label><strong>E-mail ID</strong></label>
                      <input type="email" class="form-control " id="email" name="email" value="<?php echo $email;?>"  autocomplete="off"/>
                    </div>
                    <div class="col-md-12">
                      <label class="error"><?php echo $message_warning; ?></label>
                    </div>
                                    
                    <div class="col-12 form-group">
                      <input type="submit" name="submit" id="submit" value="Submit" class="btn btn-submit">
                      <input type="hidden" name="action" value="generate_badge">
                    </div>                     
                   
                </div>                    
                </form> 
             
              </div>

<style>
  .table-bordered, .table-bordered td {border: 1px solid #dee2e6;}
  .table-bordered th, .table-bordered td {vertical-align: middle; padding: 10px;}
  .table-bordered td {white-space: nowrap;}
</style>

  <style>
    .date {background: #a89c5d; color: #fff; font-size: 12px; display: table; margin: 0 auto; line-height: inherit; padding: 5px 10px; font-weight: 700; border-radius: 100px;}
    p, .responsive_table {font-size: 15px; line-height: 26px;}
    .gold_clr {color: #a89c5d;}
    li a:hover {text-decoration: none; color: #000}
    .inner_under_listing li {font-size: 15px;}
    h2.title{font-size:16px;  color: #a89c5d; font-weight:bold; line-height: 28px;}

    @media (min-width: 768px){
      .responsive_table th, .responsive_table td {text-align: center; font-size: 14px; padding: 5px;}
    } 
    @media (max-width: 768px){
/*       h2.title {font-size: 18px;}
*/       .responsive_table th, .responsive_table td { font-size: 12px; padding-top: 5px; padding-bottom: 5px;}
    }     

    @media (min-width: 576px){
.modal-dialog {
    max-width: 450px;
}}

.close {color: #fff; text-shadow: none; opacity: 1;}
  </style>

        </div>
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
  </body>
<link rel="stylesheet" type="text/css" href="css/new_style.css" /> 

<script src="https://gjepc.org/assets-new/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function(){
        $("#myModal").modal('show');
    });
</script>
</html>
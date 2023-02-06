<?php
include ("db.inc_test.php");
include ("functions.php");
session_start();
$action = $_REQUEST['action'];
if($action =="ownerMobileOtpSend" && isset($_POST['mobile_number']) && $_POST['mobile_number'] !=""){
   $mobile_number = filter($_POST['mobile_number']);
   $sql = "SELECT `registration_id`,`visitor_id`,`mobile`,`degn_type`,`status` FROM visitor_directory WHERE `mobile`='$mobile_number' ";
   $result = mysql_query($sql);
   $count = mysql_num_rows($result);
   $row = mysql_fetch_array($result);
   if($count == 1){
    if($row['status'] ==1){
      if($row['degn_type'] =="Owner"){
        $registration_id = $row['registration_id'];
        $visitor_id = $row['visitor_id'];
        $otp = rand(1000,9999);
        $post_date = date("Y-m-d H:i:s");
        $modified_date = date("Y-m-d H:i:s");
        $message = 'One Time Password for mobile verification is '.$otp;
        $isSent =get_data($message,$mobile_number);
        if($isSent ==TRUE){
        $sqlCheck = "SELECT `registration_id`,`visitor_id`,`mobile` FROM visitor_ownersMobileOtpVerification WHERE `registration_id`='$registration_id' AND `visitor_id`='$visitor_id' AND `mobile`='$mobile_number' LIMIT 1 ";
        $resultCheck = mysql_query($sqlCheck);
        $countCheck = mysql_num_rows($resultCheck);
        if($countCheck>0){
          $sqlOtp = "UPDATE visitor_ownersMobileOtpVerification SET `otp`='$otp',`verified`='0',`modified_date`='$modified_date'WHERE `registration_id`='$registration_id' AND `visitor_id`='$visitor_id' AND `mobile`='$mobile_number' ";
          $resultOtp = mysql_query($sqlOtp);
          echo json_encode(array("status"=>"success","message"=>"Otp Sent to mobile kindly check and enter above"));exit;
        }else{
          $sqlOtp = "INSERT INTO visitor_ownersMobileOtpVerification SET `registration_id`='$registration_id',`visitor_id`='$visitor_id',`mobile`='$mobile_number',`otp`='$otp',`verified`='0',`post_date`='$post_date',`modified_date`='$modified_date'";
          $resultOtp = mysql_query($sqlOtp);
          echo json_encode(array("status"=>"success","message"=>"Otp Sent to mobile kindly check and enter above"));exit;
        }  
        
        }else{
          echo json_encode(array("status"=>"error","message"=>"Server not responding"));exit;
        }
      }else{
      echo json_encode(array("status"=>"error","message"=>"Employees are not allowed here"));exit;
      }
    }else{
      echo json_encode(array("status"=>"error","message"=>"Mobile number related profile is deactive"));exit;
    }
   }else{
      echo json_encode(array("status"=>"error","message"=>"Mobile number is not related to any profile"));exit;
   }

}

if($action =="otpCheck" && isset($_POST['otp']) && $_POST['otp'] !=""){
   $enteredOtp = filter($_POST['otp']);
   $mobile = $_POST['mobile'];
   $sql = "SELECT `registration_id`,`visitor_id`,`mobile`,`otp` FROM visitor_ownersMobileOtpVerification WHERE  `otp`='$enteredOtp' AND `mobile`='$mobile' LIMIT 1 ";
   $result = mysql_query($sql);
   $count = mysql_num_rows($result);
   if($count>0){
   echo json_encode(array("status"=>"success","message"=>"OTP Matched"));exit;
   }else{
   echo json_encode(array("status"=>"error","message"=>"OTP Not Matched"));exit;
   }
}

if(isset($_POST) && $action =="OwnerLogin" ){


  //echo "<pre>"; print_r($_SESSION);exit;
  $captcha_code = $_SESSION['captcha_code'];
   $choice = filter($_POST['choice']);
  if(isset($_POST['choice'])){
    $choice = filter($_POST['choice']);
  }else{
    $choice = "";
  }

  $mobile_number = filter($_POST['mobile_number']);
  $pass = filter($_POST['pass']);
  $captcha = filter($_POST['captcha']);
   $sql = "SELECT `registration_id`,`visitor_id`,`mobile`,`degn_type`,`status` FROM visitor_directory WHERE `mobile`='$mobile_number' ";
   $result = mysql_query($sql);
   $count = mysql_num_rows($result);
   $row = mysql_fetch_array($result);
   $registration_id = $row['registration_id'];
  /*
  **  form validation start
  */
  if(empty($mobile_number))
  {
    $mobile_number_error[] = array("status"=>"error","msg"=>"Please Enter Mobile Number","label"=>"mobile_number");
  }else{
     
   if($count == 1){
    if($row['status'] ==1){
      if($row['degn_type'] =="Owner"){
       $mobile_number_error[] = array();
      }else{
      $mobile_number_error[] = array("status"=>"error","msg"=>"Employees are not allowed here","label"=>"mobile_number");
      }
    }else{
      $mobile_number_error[] = array("status"=>"error","msg"=>"Mobile number related profile is deactive","label"=>"mobile_number");
    }
   }else{
      $mobile_number_error[] = array("status"=>"error","msg"=>"Mobile number is not related to any profile","label"=>"mobile_number");
   }
  }
  if(empty($pass))
    {
      $pass_error[] = array("status"=>"error","msg"=>"Please Enter OTP/ Password Here","label"=>"password");
    }else{
    $pass_error[] = array();
  }
  if(empty($choice))
  {
    $choice_error[] = array("status"=>"error","msg"=>"Please Select Your Login Preference ","label"=>"choice");
  }else{
    if($choice =="otp"){
         if(empty($pass))
      {
        $pass_error[] = array("status"=>"error","msg"=>"Please Enter  OTP Here","label"=>"password");
      }else{
        $sqlCheck = "SELECT `otp` FROM visitor_ownersMobileOtpVerification WHERE   `mobile`='$mobile_number' AND `otp`='$pass' ORDER BY `post_date` DESC LIMIT 1 ";
        $resultCheck = mysql_query($sqlCheck);
         $countCheck = mysql_num_rows($resultCheck);
        if($countCheck>0){
         $pass_error[] = array();
        }else{
         $pass_error[] = array("status"=>"error","msg"=>"OTP Not Matched","label"=>"password");
          
        }
     }
    }elseif($choice == "password"){

     
     
     $sqlPassword = "SELECT `company_secret`,`status` FROM registration_master WHERE  `id`='$registration_id' ";
     $resultPassword = mysql_query($sqlPassword);
     $getCount = mysql_num_rows($resultPassword);
     $rowPassword = mysql_fetch_array($resultPassword);
     if(empty($pass))
      {
        $pass_error[] = array("status"=>"error","msg"=>"Please Enter  Password Here","label"=>"password");
      }else{
        if($getCount>0){
          if($rowPassword['company_secret'] == $pass){
            if($rowPassword['status'] == 0){
              $pass_error[] = array("status"=>"error","msg"=>"Account is Deactive","label"=>"password");
            }else{
              $pass_error[] = array();
            }
          }else{
            $pass_error[] = array("status"=>"error","msg"=>"Invalid Password","label"=>"password");
          }
       }else{
          $pass_error[] = array("status"=>"error","msg"=>"Account Not Found ","label"=>"password");
       }     
     }
    }
    $choice_error[] = array(); 
  }
 
  //print_r ($pass_error);exit;
  if(empty($captcha))
  {
    $captcha_error[] = array("status"=>"error","msg"=>"Please Enter Security Code ","label"=>"captcha");
  }else{
    if($captcha_code == $captcha )
    {
      $captcha_error[] = array();
    }else{
      $captcha_error[] = array("status"=>"error","msg"=>"Invalid Captcha Code  ","label"=>"captcha");

    }
    
  }
  /*
  **  form validation end
  */
  $data_error = array_merge(array_filter($mobile_number_error),array_filter($choice_error),array_filter($pass_error),array_filter($captcha_error));
  if(!empty($data_error))
  {
    echo json_encode($data_error);exit;
  }
  else{
     $query=mysql_query("select * from registration_master where id='$registration_id' and status=1");
  $resultLogin=mysql_fetch_array($query);
  $num=mysql_num_rows($query);
  if($num>0)
  {
    $_SESSION['USERID']=$resultLogin['id'];
    $_SESSION['EMAILID']=$resultLogin['email_id'];
    $_SESSION['COMPANYNAME']=strtoupper($resultLogin['company_name']);
    $_SESSION['COUNTRY']=strtoupper($resultLogin['country']);
    mysql_query("update registration_master set lastlogin_website='registration.gjepc.org',last_login=Now() where id='$registration_id'");  
      echo json_encode(array("status"=>"loggedIn"));
 
  }
  }

}
if($action =="checkEmailAction" && isset($_POST['email']) ){
  $email = filter($_POST['email']);
  if(!empty($email)){
  $query = "SELECT * FROM registration_master WHERE `email_id` ='$email'";
    $result = mysql_query($query);
    $num = mysql_num_rows($result);
    $row = mysql_fetch_array($result);

    if($num>0){
      if($row['status'] == 1){
        echo json_encode(array("status"=>"success","msg"=>"Great..! Email-Id is active ","label"=>"email"));exit;
      }else{
       echo json_encode(array("status"=>"error","msg"=>"Email Id related Account is Deactive","label"=>"email"));exit;
      }
    }else{
      echo json_encode(array("status"=>"error","msg"=>"Email-Id Does Not Exist","label"=>"email"));exit;

    }
  }else{
    echo json_encode(array("status"=>"error","msg"=>"Please Enter Email-Id","label"=>"email"));exit;
 
  }
  
}
if($action =="loginFormAction" && isset($_POST)){
$generatedCaptchaCode = $_SESSION['captcha_code'];   
$email = filter($_POST['email']);
$password = filter($_POST['password']);
$captcha = filter($_POST['captcha']);
 
if(empty($email))
  {
    $email_error[] = array("status"=>"error","msg"=>"Please Enter Email-Id ","label"=>"email");

  }else{
    $query = "SELECT * FROM registration_master WHERE `email_id` ='$email'";
    $result = mysql_query($query);
    $num = mysql_num_rows($result);
    $row = mysql_fetch_array($result);
    if($num>0){
      if($row['status'] == 1){
        $email_error[] = array();
      }else{
        $email_error[] = array("status"=>"error","msg"=>"Email Id related Account is Deactive","label"=>"email");
      }
      }else{
        $email_error[] = array("status"=>"error","msg"=>"Email-Id Does Not Exist","label"=>"email");
      }
  }

if(empty($password))
  {
    $password_error[] = array("status"=>"error","msg"=>"Please Enter Password","label"=>"password");
  }else{
     $password_error[] = array();
  }
if(empty($captcha))
  {
      $captcha_error[] = array("status"=>"error","msg"=>"Please Enter Security Code","label"=>"captcha");
  }else{
      // $captcha_error[] = array();
    if($captcha == $generatedCaptchaCode ){
      $captcha_error[] = array();
    }else{
      $captcha_error[] = array("status"=>"error","msg"=>"Please Enter Correct Security Code","label"=>"captcha");  
    }
  }
  $data_error = array_merge(array_filter($email_error),array_filter($password_error),array_filter($captcha_error));
  // print_r($data_error);exit;
  if(!empty($data_error))
  {
    echo json_encode($data_error);exit;
  }
  else{
    $sqlCheck =  "SELECT * FROM  registration_master WHERE `email_id` ='$email' AND `company_secret`='$password'";
    $resultCheck = mysql_query($sqlCheck);
    $rowCheck = mysql_fetch_array($resultCheck);

    $countCheck = mysql_num_rows($resultCheck);
    if($countCheck > 0){
      $registration_id =  $rowCheck['id'];
      $getData=mysql_query("select * from registration_master where id='$registration_id' and status=1");
      $resultLogin=mysql_fetch_array($getData);
      $count=mysql_num_rows($getData);
      if($count>0)
      {
        if($password == $rowCheck['company_secret']){
          if($rowCheck['status'] == 1){
            $_SESSION['USERID']=$resultLogin['id'];
            $_SESSION['EMAILID']=$resultLogin['email_id'];
            $_SESSION['COMPANYNAME']=strtoupper($resultLogin['company_name']);
            $_SESSION['COUNTRY']=strtoupper($resultLogin['country']);
            mysql_query("update registration_master set lastlogin_website='registration.gjepc.org',last_login=Now() where id='$registration_id'");
            echo json_encode(array("status"=>"loggedIn","msg"=>"","label"=>"email"));exit;
          }else{
             echo json_encode(array("status"=>"customError","msg"=>"Account is Deactivated","label"=>"password"));exit;
          }
        }else{
             echo json_encode(array("status"=>"customError","msg"=>"Invalid Password","label"=>"password"));exit;
        }
      }
    }else{
      echo json_encode(array("status"=>"customError","msg"=>"Username And Password Not Matched","label"=>"password"));exit;
    }
  }



}

?>
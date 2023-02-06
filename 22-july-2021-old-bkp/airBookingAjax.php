<?php
include ("db.inc.php");
include ("functions.php");
session_start();
$action = $_REQUEST['action'];
$registration_id=$_SESSION['USERID'];


if(isset($_POST) && $action =="airBooking" && $registration_id !=""){
   $type = filter($_POST['type']);
  if(isset($_POST['traveller'])){
    $traveller = $_POST['traveller'];
  }else{
    $traveller = "";
  }
  if(isset($_POST['type'])){
    $type = filter($_POST['type']);
  }else{
    $type = "";
  }

 
 
  $from_city = filter($_POST['from_city']);
  $dep_date = filter($_POST['dep_date']);
  $ret_date = filter($_POST['ret_date']);
  $post_date = date("Y-m-d H:i:s");
// echo "<pre>";print_r($_POST);exit;
/*
**  form validation start
*/
if(empty($type)){
    $type_error[] = array("status"=>"empty","msg"=>"Select Your travel type","label"=>"type");
  }else{
    $type_error[] = array();
  }
  if(empty($traveller)){
    $traveller_error[] = array("status"=>"empty","msg"=>"Select Your travel traveller","label"=>"traveller");
  }else{
    $traveller_error[] = array();
  }
if(empty($from_city))
{
    $from_city_error[] = array("status"=>"empty","msg"=>"Enter city here","label"=>"from_city"); 
}else{
    $from_city_error[] =array();
}

if(empty($dep_date))
{
    $dep_date_error[] = array("status"=>"empty","msg"=>"Select Departure Date here","label"=>"dep_date"); 
}else{
    $dep_date_error[] =array();
}
if(empty($ret_date))
{
    $ret_date_error[] = array("status"=>"empty","msg"=>"Select return Date here","label"=>"ret_date"); 
}else{
    $ret_date_error[] =array();
}
//echo "<pre>";print_r($ret_date_error);exit;
  if($type =="one_way")
    {
      $ret_date = "";
      $data_error = array_merge(array_filter($traveller_error),array_filter($from_city_error),array_filter($dep_date_error));
      if(!empty($data_error))
      {
        echo json_encode($data_error);exit;
      }
    }else if($type =="round_trip"){
      $data_error = array_merge(array_filter($traveller_error),array_filter($from_city_error),array_filter($dep_date_error),array_filter($ret_date_error));
      if(!empty($data_error))
      {
        echo json_encode($data_error);exit;
      }
    }else{
      $data_error = array_merge(array_filter($type_error),array_filter($traveller_error),array_filter($from_city_error),array_filter($dep_date_error),array_filter($ret_date_error));
      if(!empty($data_error))
      {
        echo json_encode($data_error);exit;
      }
    }


/*
**  form validation end
*/

 $traveller = implode(",", $traveller );
  $sql = "INSERT INTO iijs_airline_booking_enquiry SET type='$type', traveller='$traveller', from_city='$from_city', dep_date='$dep_date', ret_date='$ret_date',post_date = '$post_date',registration_id='$registration_id'";
 $result = mysql_query($sql);
 $enquiry_no =  mysql_insert_id();
 if($result == TRUE &&  $enquiry_no !=""){
   $email = getCompanyEmail($registration_id);
      $message = "";
      $message .= '
  <table class="table2" width="80%" bgcolor="#fbfbfb" align="center" style="margin:2% auto; border:2px solid #ddd; font-family:Arial, sans-serif; color:#333333; font-size:13px; border-radius:10px;padding:10px;">   
    <tbody>    
          <tr>
          
           
            <td  ><img id="ri" src="https://iijs.org/assets/images/logo.png">
            </td>         
            <td ><p style="line-height: 22px;"><strong>IIJS Premiere 2020: Airline Booking Enquiry - Request Form !</strong></p></td>               
        </tr>
        <tr>
        <td colspan="2">
           
          <p style="line-height:22px;text-align: right;"><strong>Date: </strong>'.date("d-m-y").'</p>
            <p style="line-height:22px;text-align: left;">Dear Sir / Madam,</p>
          
            <table cellpadding="20px" cellspacing="0">
                <tbody>
                    <tr>
                        <td><strong>Enquiry Number </strong></td>
                        <td><strong>  : </strong> </td>
                        <td>'.$enquiry_no.'</td>
                    </tr>
                    <tr>
                        <td><strong> Travelling Type </strong></td>
                        <td><strong>  : </strong> </td>
                        <td>'.$type.'</td>
                    </tr>
                     <tr>
                        <td><strong> Company Name </strong></td>
                        <td><strong>  : </strong> </td>
                        <td>'.getCompanyName($registration_id).'</td>
                    </tr>
                     <tr>
                        <td><strong> Traveller Name </strong></td>
                        <td><strong>  : </strong> </td>
                        <td>'; 
                      foreach($_POST['traveller'] as $vis){
        $message .=   getVisitorName($vis)."  ,";
                        }
        $message .=   '</td>
                    </tr>';
                     
        $message .= '<tr>
                        <td><strong> Travelling From </strong></td>
                        <td><strong>  : </strong> </td>
                        <td>'.$from_city.'</td>
                    </tr>
                    <tr>
                        <td><strong> Departure Date </strong></td>
                        <td><strong>  : </strong> </td>
                        <td>'.$dep_date.'</td>
                    </tr>
                     <tr>
                        <td><strong> Return Date </strong></td>
                        <td><strong>  : </strong> </td>
                        <td>'.$ret_date.'</td>
                    </tr>
                   
               
                </tbody>
            </table>
            <p>Thank you for your Airline Booking enquiry &ndash; Request form !</p>
            <p width="20%" colspan="2">Thank you! We have received your request.
                Our empanelled travel representative  will revert back to you within 24hrs to process your booking.
                For more information and queries you may write to us on our email  <a href="mailto:iijstravel@gmail.com"> iijstravel@gmail.com </a> 
            </p>

           <p>
             Write to us on email <a href="mailto:iijstravel@gmail.com"> iijstravel@gmail.com </a> with your enquiry number
            </p>
            <p>
            We once again thank you for your enquiry and look forward to welcome you at IIJS Premiere 2020. 
            </p>
        </td>
        </tr>
        <tr>
         <td colspan="2">
         <hr>
         </td>
        </tr>
        <tr>
            <td align="center" colspan="2">
                <p style="line-height:25px;">
                    <h3 style="margin: 5px;">THE GEM JEWELLERY EXPORT PROMOTION COUNCIL</h3>
                    <b>GJEPC-H.O.-MUMBAI:1st Flr, Tower A,G Block, BDB, Bandra-Kurla Complex, Bandra(E)-400 051</b><br>
                    <b>GJEPC-E.X.-MUMBAI:G2-A, Trade Center, Bandra-Kurla Complex, Bandra(E)-400 051</b><br>
                    <b>Toll Free Number :</b> 1800-103-4353, <b>Missed Call Number :</b> +91-7208048100<br>Website: https://iijs.org Email: visitors@gjepcindia.com</p>
            </td>
        </tr>  
         <tr>
          <td align="center" colspan="2">
            <img id="ri" src="http://registration.gjepc.org/images/mailer/gjepc_logo.png" width="100px">  
          </td>
            
        </tr>
        <tr>
          <td colspan="2" align="center">
            <a href="https://www.facebook.com/GJEPC" target="_blank">Facebook</a>
            <a href="https://twitter.com/GJEPCIndia" target="_blank">Twitter</a>
            <a href="" target="_blank">Instagram</a>
            <a href="https://www.linkedin.com/in/sabyaray/" target="_blank">Linkedin</a>
          </td>
        </tr>          
        <tr><td colspan="2" height="30"><hr></td></tr>        
    </tbody>
    </table>';  
   
    //$to =$email.',iijstravel@gmail.com';
    $to ="iijstravel@gmail.com,santosh@kwebmaker.com";
    $subject = "IIJS Premiere 2020: Airline Booking Enquiry - Request Form !"; 
    $headers  = 'MIME-Version: 1.0' . "\n"; 
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n"; 
    $headers .= 'From: IIJS PREMIERE 2020 <admin@gjepc.org>';     
    mail($to, $subject, $message, $headers);
  echo json_encode(array("status" =>'success'));exit;
 }else{
  echo json_encode(array("status" =>'fail'));exit;
 }
}

if(isset($_POST) && $action =="delete_bookig" && $registration_id !=""){
  
  $id = $_POST['id'];
  if($id !=""){
    $sql = "DELETE FROM iijs_airline_booking_enquiry WHERE id ='$id' ";
    $result = mysql_query($sql);
    if($result == TRUE){
   
    /*  Email End */
      echo json_encode(array("status" =>'success'));exit;
    }else{
      echo json_encode(array("status" =>'fail'));exit;
    }
  }
}

if(isset($_POST) && $action =="hotelBooking" && $registration_id !=""){
     // echo '<pre>';print_r($_POST);exit;
  if(isset($_POST['type']))
  {
    $type = filter($_POST['type']);
  }else{
    $type = "";
  }
  if(isset($_POST['guest'])){
    $guest = $_POST['guest'];
  }else{
    $guest = "";
  }
  
  $hotels = filter($_POST['hotels']);
  $area = filter($_POST['area']);
  $price = filter($_POST['price']);
  $check_in = filter($_POST['check_in']);
  $check_out = filter($_POST['check_out']);
  $link = $_POST['link'];
  $post_date = date("Y-m-d H:i:s");
  /*
  **  form validation start
  */
  if(empty($type))
  {
    $type_error[] = array("status"=>"empty","msg"=>"Select Your occupancy ","label"=>"type");
  }else{
    if($type =="single" && count($guest) !=1 ){
      $guest_error[] = array("status"=>"empty","msg"=>"Only  one guest is allowed in single occupancy","label"=>"guest");

    }elseif($type =="single" && count($guest) ==1){
      $guest_error[] = array();

    }elseif ($type =="double" && count($guest) !=2 ) {
      $guest_error[] = array("status"=>"empty","msg"=>"Two  guests are allowed in double occupancy","label"=>"guest");
      
    }elseif($type =="double" && count($guest) ==2 ){
      $guest_error[] = array();

    }
    $type_error[] = array();
  }
  if(empty($guest))
  {
    $guest_error[] = array("status"=>"empty","msg"=>"Select guest","label"=>"guest");
  }else{

    $guest_error[] = array();
  }
  if(empty($hotels))
  {
    $hotels_error[] = array("status"=>"empty","msg"=>"Select hotel","label"=>"hotels");
  }else{

    $hotels_error[] = array();
  }
   
  if(empty($area))
  {
    $area_error[] = array("status"=>"empty","msg"=>"Select area","label"=>"area");
  }else{
    $area_error[] = array();
  }
  if(empty($price))
  {
    $price_error[] = array("status"=>"empty","msg"=>"Price is Required","label"=>"price");
  }else{
    $price_error[] = array();
  }
  if(empty($check_in))
  {
    $check_in_error[] = array("status"=>"empty","msg"=>"Select check-in date","label"=>"check_in");
  }else{
    $check_in_error[] = array();
  }
    if(empty($check_out))
  {
    $check_out_error[] = array("status"=>"empty","msg"=>"Select check-out date","label"=>"check_out");
  }else{
    $check_out_error[] = array();
  }

  $data_error = array_merge(array_filter($type_error),array_filter($guest_error),array_filter($area_error),array_filter($price_error),array_filter($check_in_error),array_filter($check_out_error),array_filter($hotels_error));
  //echo "--------";print_r($data_error);exit;
  if(!empty($data_error))
    {
      echo json_encode($data_error);exit;
    }
    

   

  /*
  **  form validation start
  */

  $sql_hotel = "SELECT hotel_name FROM iijs_oyo_hotels_master WHERE id ='$hotels'";
  $result_hotel = mysql_query($sql_hotel);
  $row_hotel = mysql_fetch_array($result_hotel);
  $hotel_name = $row_hotel['hotel_name'];
    $guest = implode(",", array_unique($guest));
    $sql = "INSERT INTO iijs_hotel_booking_enquiry SET type='$type', guest='$guest', area='$area', price='$price', check_in='$check_in',check_out = '$check_out',post_date='$post_date',registration_id='$registration_id',link='$link',hotel='$hotel_name'";
    $result = mysql_query($sql);
    $enquiry_no =  mysql_insert_id();
    if($result == TRUE && $enquiry_no !=""){
       $email = getCompanyEmail($registration_id);
       $message = "";
       $message .='
				<table class="table2" width="80%" bgcolor="#fbfbfb" align="center" style="margin:2% auto; border:2px solid #ddd; font-family:Arial, sans-serif; color:#333333; font-size:13px; border-radius:10px;padding:10px;">   
				    <tbody>    
				        <tr>
				            <td  ><img id="ri" src="https://iijs.org/assets/images/logo.png">
				            </td>         
				            <td ><p style="line-height: 22px;"><strong>IIJS Premiere 2020: Hotel Booking Enquiry - Request Form ! </strong></p></td>               
				        </tr>
				        <tr>
				            <td colspan="2">
				                <p style="line-height:22px;text-align: right;"><strong>Date: </strong>'.date("d-m-y").'</p>
				                <p style="line-height:22px;text-align: left;">Dear Sir / Madam,</p>
				<table cellpadding="20px" cellspacing="0">
				    <tbody>
				        <tr>
	                        <td><strong> Enquiry Number</strong></td>
	                        <td><strong>  : </strong> </td>
	                        <td>'.$enquiry_no.'</td>
				        </tr>
                 <tr>
                          <td><strong> Company Name </strong></td>
                          <td><strong>  : </strong> </td>
                          <td>'.getCompanyName($registration_id).'</td>
                </tr>';

        $message .='<tr>
                        <td><strong> Hotel Name </strong></td>
                        <td><strong>  : </strong> </td>
                        <td>'.$hotel_name.'</td>
                    </tr>

                    <tr>
                        <td><strong> Guest Name</strong></td>
                        <td><strong>  : </strong> </td>
                        <td>';
                     foreach($_POST['guest'] as $vis){
        $message .=   getVisitorName($vis)."  ,";
                        }
        $message .=    '</td>
                    </tr>
                    <tr>
                        <td><strong> Occupancy  </strong></td>
                        <td><strong>  : </strong> </td>
                        <td>'. strtoupper($type).'</td>
                    </tr>
                   
                     <tr>
                        <td><strong> Area  </strong></td>
                        <td><strong>  : </strong> </td>
                        <td>'.$area.'</td>
                    </tr>
                    <tr>
                        <td><strong> Check In </strong></td>
                        <td><strong>  : </strong> </td>
                        <td>'.$check_in.'</td>
                    </tr>
                     <tr>
                        <td><strong> Check Out </strong></td>
                        <td><strong>  : </strong> </td>
                        <td>'.$check_out.'</td>
                    </tr>
                      <tr>
                        <td><strong> Price </strong></td>
                        <td><strong>  : </strong> </td>
                        <td>'.$price.'</td>
                    </tr>
                   
                    <tr>
                        <td><strong>Hotel Link </strong></td>
                        <td><strong>  : </strong> </td>
                        <td>'.$link.'</td>
                    </tr>
                     
                     
               
                </tbody>
            </table>
            <p>
            Thank you for your Hotel Booking enquiry &ndash; Request form !</p>
            <p>We have received your enquiry form towards Hotel bookings. The empanelled travel representative will revert back to you within 24hrs to process your booking enquiry. For more information and queries you may write to us on our email- 
             <a href="mailto:iijstravel@gmail.com"> iijstravel@gmail.com </a>
            </p>
            <p>
             Write to us on email <a href="mailto:iijstravel@gmail.com"> iijstravel@gmail.com </a> with your enquiry number
            </p>
            <p>
            We once again thank you for your enquiry and look forward to welcome you at IIJS Premiere 2020. 
            </p>
            

        </td>
        </tr>
        <tr>
         <td colspan="2">
         <hr>
         </td>
        </tr>
        <tr>
          <td align="center" colspan="2">
              <p style="line-height:25px;">
                <h3 style="margin: 5px;">THE GEM JEWELLERY EXPORT PROMOTION COUNCIL</h3>
                <b>GJEPC-H.O.-MUMBAI:1st Flr, Tower A,G Block, BDB, Bandra-Kurla Complex, Bandra(E)-400 051</b><br>
                <b>GJEPC-E.X.-MUMBAI:G2-A, Trade Center, Bandra-Kurla Complex, Bandra(E)-400 051</b><br>
                <b>Toll Free Number :</b> 1800-103-4353, <b>Missed Call Number :</b> +91-7208048100<br>Website: https://iijs.org Email: visitors@gjepcindia.com</p>
          </td>
        </tr>    
        <tr>
          <td align="center" colspan="2">
            <img id="ri" src="http://registration.gjepc.org/images/mailer/gjepc_logo.png" width="100px">  
          </td>
            
        </tr>
        <tr>
          <td colspan="2" align="center">
            <a href="https://www.facebook.com/GJEPC" target="_blank">Facebook</a>
            <a href="https://twitter.com/GJEPCIndia" target="_blank">Twitter</a>
            <a href="" target="_blank">Instagram</a>
            <a href="https://www.linkedin.com/in/sabyaray/" target="_blank">Linkedin</a>
          </td>
        </tr>         
        <tr><td colspan="2" height="30"><hr></td></tr>        
    </tbody>
    </table>';  
   
    //$to =$email.',iijstravel@gmail.com';
    $to ="iijstravel@gmail.com,santosh@kwebmaker.com";
    $subject = "IIJS Premiere 2020: Hotel Booking Enquiry - Request Form !"; 
    $headers  = 'MIME-Version: 1.0' . "\n"; 
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n"; 
    $headers .= 'From: IIJS PREMIERE 2020 <admin@gjepc.org>';     
    mail($to, $subject, $message, $headers);

      echo json_encode(array("status" =>'success'));exit;
    }else{
      echo json_encode(array("status" =>'fail'));exit;
    }
}

if(isset($_POST) && $action =="delete_hotel_booking" && $registration_id !=""){
  
  $id = $_POST['id'];
  if($id !=""){
    $sql = "DELETE FROM iijs_hotel_booking_enquiry WHERE id ='$id' ";
    $result = mysql_query($sql);
    if($result == TRUE){
      echo json_encode(array("status" =>'success'));exit;
    }else{
      echo json_encode(array("status" =>'fail'));exit;
    }
  }
}
if(isset($_POST) && $action =="Get_hotel_data" && $registration_id !=""){
  
  $area = $_POST['area'];
  if($area !=""){
   $sql = "SELECT * FROM iijs_oyo_hotels_master WHERE `location`='$area' AND `status` = '1'";
   $result = mysql_query($sql);
   $output = "";
   $output .= '<option value="">--Select Hotel--</option>';
   while ($row = mysql_fetch_array($result)) {
     $output .= '<option value=" '.$row['id'].'">'.$row['hotel_name'].'</option>';
   }
   $data = array('status'=>'success','hotelData' => $output);
  echo json_encode($data);exit;

  }
}
if(isset($_POST) && $action =="Get_hotel_rates" && $registration_id !=""){
  
  $type = $_POST['type'];
  if(isset($_POST['type']))
  {
    $type = filter($_POST['type']);
  }else{
    $type = "";
  }
  //echo $area ;exit;
  $hotel_id = $_POST['hotel_id'];
  if($hotel_id !="" && $type !=""){
   $sql = "SELECT * FROM iijs_oyo_hotels_master WHERE `id`='$hotel_id' AND `status` = '1'";
   $result = mysql_query($sql);
   $row = mysql_fetch_array($result);
   if($type = "single"){
    $output = $row['single_inr'];
   }elseif($type = "double"){
    $output = $row['double_inr'];
   }else{
    $output = "";

   }
   $link = $row['link'];
   $name = $row['hotel_name'];
   
   $data = array('status'=>'success','hotelRates' => $output,'link'=>$link,'name'=>$name);
   echo json_encode($data);exit;
  
  }
}


?>
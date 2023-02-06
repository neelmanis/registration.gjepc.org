<?php include('header_include.php');
if(!isset($_SESSION['USERID'])){header("location:login.php");exit;}
$registration_id=$_SESSION['USERID'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Manage Address</title>
    <link rel="shortcut icon" href="images/fav.png" />
    <link rel="stylesheet" type="text/css" href="css/mystyle.css" />
    <link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Cabin'>
    <link rel="stylesheet" type="text/css" href="css/general.css" />
    <link rel="stylesheet" type="text/css" href="css/inner_pg_style.css" />
    <link rel="stylesheet" type="text/css" href="css/responsive.css" />
    <link rel="stylesheet" type="text/css" href="css/media_query.css" />
    <link rel="stylesheet" type="text/css" href="css/fastselect.min.css"/>
    <script type="text/javascript" src="https://gjepc.org/assets/js/jquery.min.js"></script>
    <!--NAV-->
    <script type="text/javascript" src="js/fastselect.standalone.min.js"></script>
    <link href="css/flexnav.css" media="screen, projection" rel="stylesheet" type="text/css">
    <script src="js/jquery.flexnav.js" type="text/javascript"></script>
    <script src="js/common.js"></script>
    <!--NAV-->
    <!-- UItoTop plugin -->
    <link rel="stylesheet" type="text/css" media="screen,projection" href="css/ui.totop.css" />
    <script src="js/easing.js" type="text/javascript"></script>
    <script src="js/jquery.ui.totop.js" type="text/javascript"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script type="text/javascript">
      $(window).load(function() {
        $(".loader").fadeOut("slow");
      });
    $(document).ready(function(){
    $('.multipleSelect').fastselect();
    $('.singleSelect').fastselect();
    $("#dep_date_div").hide();
    $("#ret_date_div").hide();
    
    $(".type").on("click", function(){
    var val = $(this).val();
    if(val =="one_way"){
    $("#dep_date_div").slideDown();
    $("#ret_date_div").slideUp();
    }else if(val =="round_trip"){
    $("#dep_date_div").slideDown();
    $("#ret_date_div").slideDown();
    }else{
    $("#dep_date_div").slideUp();
    $("#ret_date_div").slideUp();
    }
    });
    $("#airBookingForm").on("submit",function(e){
    e.preventDefault();
    $(".error").html("");
    $(".error").css("display","none");
    var formdata = $(this).serialize();
    $.ajax({
    type:'POST',
    data:formdata,
    url:"airBookingAjax.php",
    dataType: "json",
    beforeSend: function() {
     $(".loader").show();
    },
    success:function(result){
     $(".loader").fadeOut("slow");
    if(result['status'] == "success")
    {
      $("#submit").attr("disable",true);
     
    swal({
    icon:"success",   
    title: "Thank you for your Airline Booking enquiry- Request form.",
    text: "Thank you! We have received your request. Our empanelled travel representative  will revert back to you within 24hrs to process your booking. For more information and queries you may write to us on our email   iijstravel@gmail.com .Write to us on email iijstravel@gmail.com with your enquiry number. We once again thank you for your enquiry and look forward to welcome you at IIJS Premiere 2020.",
    buttons: false,
    showConfirmButton: true
   
    }).then(function(){
      $("#airBookingForm").trigger("reset");
      window.location.reload();
    });


    }else{
    $.each(result, function(i, v) {
    $("label[for='"+v.label+"']").html(v.msg);
    });
    var keys = Object.keys(result);
    $(".error").css("display","block");
    }
    }
    });
    });
    $(".delete_bookig").on("click",function(){
    //var confirm = alert("Are you confirm");
    if(confirm("Are you confirm")){
    var id = $(this).data("id");
    var action = "delete_bookig";
    $.ajax({
    type:'POST',
    data:{action:action,id:id},
    url:"airBookingAjax.php",
    dataType: "json",
    success:function(result){
    
    if(result['status'] == "success")
    {
    alert("Enquiry removed successfully");
    window.location.reload();
    }else{
    alert("Server error");
    }
    }
    });
    }else{
    return false;
    }
    });
    $(window).keydown(function(event){
    if(event.keyCode == 13) {
      event.preventDefault();
      return false;
    }
  });
    });
    
    </script>
    <style>
    table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
    }
    td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
    }
    .loader {
    position: fixed;
    left: 0px;
    top: 0px;
    width: 100%;
    height: 100%;
    z-index: 9999;
    background: url('images/loader.gif') 50% 50% no-repeat rgb(249,249,249);
    opacity: 80;
    }
    .breadcome{background: #ccc;padding: 10px 14px;border-radius: 4px;}
    .address_box_container{width: 100%;display: flex;justify-content:flex-start;flex-wrap: wrap;}
    .address_box_wrapper{padding: 10px;}
    .address_box{width: 260px; min-height: 100px;background: #ccc;border-bottom: 4px solid #282b8a;border-radius: 7px}
    .btn{padding:7px 15px; background: #ccc; color: #fff;margin: 5px 0 16px 15px;display: inline-block;border-radius: 5px;transition: all 0.4s;color:#000;cursor: pointer;}
    .submitbtn{display: block; color:#fff;background:#aa9e5f;border:1px solid#ccc;padding:7px 15px;margin-bottom:10px; }
    .btn:hover{background: #000;color: #fff}
    .submitbtn{cursor:pointer}
    .fancybox-can-swipe .fancybox-content, .fancybox-can-pan .fancybox-content{cursor:auto!important;}
    .addAddress{width:750px;}
    form{width:100%}
    .field{width:33%; display:inline-block; vertical-align: top;margin-bottom:15px}
    .field .inner_div{padding:0 15px}
    .form-control{padding:7px 0px;font-size:15px;border:1px solid #ccc;display:block;width:100%;text-align:left;padding:8px 5px}
    .radio_box{display:flex;justify-content:space-between}
    .fstChoiceItem {display: block;font-size: 11px;width: 87%;padding: 0px 15px;   }
    .fstResultItem {font-size: 12px;display: block; padding: 5px;}
    .fstMultipleMode .fstQueryInput{font-size: 14px; margin:0;}
    .fstMultipleMode .fstQueryInputExpanded{ padding:5px 5px}
    .fstMultipleMode .fstControls{padding:5px 5px}
    .error{color:red}
    .fstToggleBtn{padding:8px 7px}
    .fstElement{display: block;font-size: 11px;color:#444;}
    .fstResults{max-height: 200px}
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
      <div class="loader">  <div style="display:table; width:100%; height:100%;"><span style="display:table-cell; vertical-align:middle; text-align:center; padding-top:100px;">Please wait....</span></div></div>
      <div class="header">
        <?php include('header1.php'); ?>
      </div>
      <?php
      function getVisitorInFormat($string)
      {
      $string = explode(",",$string);
      foreach($string as $val)
      {
      $visitors .=  "'".$val."',";
      }
      $visitors = substr_replace($visitors, "", -1);
      return $visitors;
      }
      ?>
      <!--container starts-->
      <div class="inner_container">
        <div class="container">
          <div class="container_leftn">
            <div class="breadcome"><a href="">Home</a> > Book Airline Ticket
          </div>
          <div id="loginForm">
            <div id="formContainer">
              <!-- <a href="address.php" class="btn btn_add" style="float: left;" >Add Traveller </a> -->
              <div class="address_box_container">
                <form id="airBookingForm" >
                  <div class="form_wrapper">
                    <div class="field">
                      <div class="inner_div">
                        <label> Select Traveling Type  <sup>*</sup> </label>
                        <div class=radio_box>
                          <label><input type="radio" name="type" class="type" value="one_way"> One Way</label>
                          <label><input type="radio" name="type" class="type" value="round_trip"> Round Trip</label>
                          
                        </div>
                        <label for="type" class="error"></label>
                        
                      </div>
                    </div><br>
                    <div class="field">
                      <div class="inner_div">
                        <label> Add Traveller  <sup>*</sup> </label>
                        <select class="multipleSelect form-control" multiple="multiple" name="traveller[]" id="traveller">
                          <?php
                          $sql_booked_visitor = "SELECT traveller FROM iijs_airline_booking_enquiry WHERE registration_id = '$registration_id'";
                          $result_booked_visitor =mysql_query($sql_booked_visitor);
                          $booked_visitors = array();
                          $book_vis_count =mysql_num_rows($result_booked_visitor);
                          if( $book_vis_count > 0 ){
                          while( $row_booked_visitors =mysql_fetch_array($result_booked_visitor)){
                          $booked_visitors[] = getVisitorInFormat($row_booked_visitors['traveller']);
                          }
                          $booked_visitor = implode(",",$booked_visitors);
                          }else{
                          $booked_visitor ='" "';
                          }
                          $sqlVisitors = "SELECT * FROM visitor_order_history WHERE registration_id = '$registration_id' AND (payment_made_for='2show' OR payment_made_for='6show' OR payment_made_for='3show' OR payment_made_for='5show') AND visitor_id NOT IN ($booked_visitor)";
                          $resultVisitors = mysql_query($sqlVisitors);
                          while ($rowVisitors = mysql_fetch_array($resultVisitors)) {?>
                          <option value="<?php echo $rowVisitors['visitor_id'];?>"><?php echo  getVisitorName($rowVisitors['visitor_id']);?></option>
                          <?php }
                          ?>
                        </select>
                      <label for="traveller" class="error"></label>
                    </div>
                  </div>
                  <div class="field">
                    <div class="inner_div">
                      <label> From City  <sup>*</sup> </label>
                      <select name="from_city" id="from_city" class="form-control singleSelect">
                        <option value="">--Select CIty--</option>
                        <option value="Ahmedabad">Ahmedabad </option>
                        <option value="Aizawl">Aizawl</option>
                        <option value="Aurangabad">Aurangabad </option>
                        <option value="Bagdogra">Bagdogra </option>
                        <option value="Bengaluru">Bengaluru </option>
                        <option value="Bhubaneswar">Bhubaneswar</option>
                        <option value="Chandigarh ">Chandigarh </option>
                        <option value="Chennai">Chennai</option>
                        <option value="Delhi">Delhi</option>
                        <option value="Goa">Goa</option>
                        <option value="Guwahati">Guwahati</option>
                        <option value="Hyderabad ">Hyderabad </option>
                        <option value="Indore ">Indore </option>
                        <option value="Jaipur  ">Jaipur  </option>
                        <option value="Jammu  ">Jammu  </option>
                        <option value="Kannur  ">Kannur  </option>
                        <option value="Kochi  ">Kochi  </option>
                        <option value="Kolkata  ">Kolkata  </option>
                        <option value="Leh  ">Leh  </option>
                        <option value="Lucknow  ">Lucknow  </option>
                        <option value="Mumbai  ">Mumbai  </option>
                        <option value="Nagpur  ">Nagpur  </option>
                        <option value="Patna  ">Patna  </option>
                        <option value="Port Blair  ">Port Blair  </option>
                        <option value="Pune  ">Pune  </option>
                        <option value="Ranchi  ">Ranchi  </option>
                        <option value="Srinagar   ">Srinagar   </option>
                        <option value="Udaipur">Udaipur</option>
                        <option value="Varanasi">Varanasi</option>
                      </select>
                    <label for="from_city" class="error"></label>
                  </div>
                </div>
                <div class="field">
                  <div class="inner_div">
                    <label> To City  <sup>*</sup> </label>
                    <input id="to_city" name="to_city" type="text" class="form-control" value="Mumbai" readonly autocomplete="off">
                  <label for="to_city" class="error"></label>
                </div>
              </div>
              <div class="field" id="dep_date_div">
                <div class="inner_div">
                  <label> Departure Date <sup>*</sup> </label>
                  <input id="dep_date" min="2020-08-03" max="2020-08-13" name="dep_date" type="date" class="form-control"autocomplete="off">
                <label for="dep_date" class="error"></label>
              </div>
            </div>
            <div class="field" id="ret_date_div">
              <div class="inner_div">
                <label> Return Date <sup>*</sup> </label>
                <input id="ret_date" min="2020-08-03" max="2020-08-13" name="ret_date" type="date" class="form-control"  autocomplete="off">
              <label for="ret_date" class="error"></label>
            </div>
          </div>
          <br>
          <div class="field">
            <div class="inner_div">
              <input type="hidden" name="action" value="airBooking" >
              <input type="submit" name="submit" value="Submit" id="submit" class="submitbtn ">
            </div>
          </div>
        </div>
      </form>
      <table>
        <tr>
          <th>Journey Type</th>
          <th>Traveller Name</th>
          <th>From</th>
          <th>Departure </th>
          <th>Return</th>
          <th>Action</th>
        </tr>
        <?php
        
        $sql = "SELECT * FROM iijs_airline_booking_enquiry WHERE registration_id = '$registration_id' ORDER BY  post_date DESC";
        $result = mysql_query($sql);
        while($row = mysql_fetch_array($result)){
        if($row['type'] == "one_way"){
        $type = "One Way" ;
        }else{
        $type = "Round Trip" ;
        }
        
        ?>
        <tr>
          <td><?php echo $type  ;?></td>
          <td><?php foreach (explode(",",$row['traveller']) as $value)
            {
            echo $vis =  getVisitorName($value).", ";
            }
            ?>
          </td>
          <td><?php echo $row['from_city'] ;?></td>
          <td><?php echo $row['dep_date'] ;?></td>
          <td><?php echo $row['ret_date'] ;?></td>
          <td><a class="delete_bookig" data-id="<?php echo $row['id']; ?>"> <img src="images/delete.png" title="Delete"></a></td>
        </tr>
        <?php } ?>
        
        
      </table>
    </div>
  </div>
</div>
</div>
</div>
</div>
<!--container ends-->
<!--footer starts-->
<div class="footer_wrap">
<?php include ('footer.php'); ?>
</div>
</div>
<!--footer ends-->
<style type="text/css">
</style>
</body>
</html>
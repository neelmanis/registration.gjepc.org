<?php include('header_include.php');
if(!isset($_SESSION['USERID'])){header("location:login.php");exit;}
$registration_id=$_SESSION['USERID'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Hotel Booking</title>
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
    $("#link_section").hide();	
    $('.multipleSelect').fastselect();
    $("#hotelBookingForm").on("submit",function(e){
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
    
    if(result['status'] == "success")
    {
    $("#submit").attr("disable",true);
     $(".loader").fadeOut("slow");

      swal({
    icon:"success",  	
    title: "Thank You For Your Hotel Booking Enquiry - Request Form .",
    
    text:"Thank you! We have received your request. Our empanelled travel representative  will revert back to you within 24hrs to process your booking. For more information and queries you may write to us on our email   iijstravel@gmail.com .Write to us on email iijstravel@gmail.com with your enquiry number. We once again thank you for your enquiry and look forward to welcome you at IIJS Premiere 2020.",
    buttons: false,
    showConfirmButton: true
   
    }).then(function(){
      $("#hotelBookingForm").trigger("reset");
      window.location.reload();
    });

    
    }else{
    $(".loader").fadeOut("slow");
    $.each(result, function(i, v) {
    $("label[for='"+v.label+"']").html(v.msg);
    });
    var keys = Object.keys(result);
    $(".error").css("display","block");
    }
    }
    });
    });
    $(".delete_hotel_booking").on("click",function(){
    //var confirm = alert("Are you confirm");
    if(confirm("Are you confirm")){
    var id = $(this).data("id");
    var action = "delete_hotel_booking";
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

    $("#area").on("change", function(){
    	var area = $(this).val();
    	var action = "Get_hotel_data";
    	var type = $("#type").val();
    	 $.ajax({
    type:'POST',
    data:{action:action,area:area},
    url:"airBookingAjax.php",
    dataType: "json",
     beforeSend: function() {
     $(".loader").show();
    },
    success:function(result){
    $(".loader").fadeOut("slow");
    if(result['status'] == "success")
    {
      $('#hotels').html(result.hotelData);
    }else{
     return false;
    }
    }
    });

    });
    $("#hotels").on("change", function(){
    	$(".error").css("display","none");
        $("label[for='type']").html("");
    	var hotel_id = $(this).val();
    	var action = "Get_hotel_rates";
    	var type = $('input[name="type"]:checked').val();    
    
		if( typeof type !="undefined"){
		    $.ajax({
		    type:'POST',
		    data:{action:action,hotel_id:hotel_id,type:type},
		    url:"airBookingAjax.php",
		    dataType: "json",
		     beforeSend: function() {
		     $(".loader").show();
		    },
		    success:function(result){
		    $(".loader").fadeOut("slow");
		    if(result['status'] == "success")
		    {
		      $("#link_section").show();
		      $('#price').val(result.hotelRates);
		      $('#link_href').attr('href',result.link);
		      $('#link_href').text(result.name);
		      $('#link').val(result.link);


		    }else{
		     return false;
		    }
		    }
		    });
		}else{

	     $(".error").css("display","block");
	     $("label[for='type']").html("Select Occupancy Type Here");
	    return false;
		}

    });
    $("input[type='radio']").on("click",function(){
    $(".error").css("display","block");
    $("label[for='area']").html("Select area ");
    $("#price").val();
    $("#hotels").html("<option value=''>--Select hotels--</option>");
    $("#link").val();
    $('#link_href').attr('href',"");
    $('#link_href').text("");
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
    .delete_hotel_booking{cursor: pointer;}
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
      <!--container starts-->
      <div class="inner_container">
        <div class="container">
          <div class="container_leftn">
            <div class="breadcome"><a href="">Home</a> > Book Hotel 
          </div>
          <div id="loginForm">
            <div id="formContainer">
              <!-- <a href="address.php" class="btn btn_add" style="float: left;" >Add Traveller </a> -->
              <div class="address_box_container">
                <form id="hotelBookingForm" >
                  <div class="form_wrapper">
                    <div class="field">
                      <div class="inner_div">
                        <label> Select occupancy   <sup>*</sup> </label>
                        <div class=radio_box>
                          <label><input type="radio" name="type" class="type" value="single"> Single occupancy </label>
                          <label><input type="radio" name="type" class="type" value="double"> Double Occupancy </label>
                          
                        </div>
                        <label for="type" class="error"></label>
                        
                      </div>
                    </div><br>
                    <div class="field">
                      <div class="inner_div">
                        <?php 
                        function getVisitorInFormat($string){
                        $string = explode(",",$string);
                        foreach($string as $val){
                            $visitors .=  "'".$val."',";
                        }
                         $visitors = substr_replace($visitors, "", -1);
                        return $visitors;
                        }
                        ?>
                        <label> Select Guest  <sup>*</sup> </label>
                        <select class="multipleSelect form-control" multiple="multiple" name="guest[]" id="guest">
                          <option value="">--Select Guest--</option>
                          <?php
                          $sql_booked_visitor = "SELECT guest FROM iijs_hotel_booking_enquiry WHERE registration_id = '$registration_id'";
                          $result_booked_visitor =mysql_query($sql_booked_visitor);
                         
                          $booked_visitors = array();
                          
                          $book_vis_count =mysql_num_rows($result_booked_visitor); 
                          if( $book_vis_count > 0 ){
                          while( $row_booked_visitors =mysql_fetch_array($result_booked_visitor)){
                          $booked_visitors[] = getVisitorInFormat($row_booked_visitors['guest']);
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
                        <label for="guest" class="error"></label>
                      </div>
                    </div>
                    <?php
                     $locationSql ="SELECT DISTINCT `location` FROM iijs_oyo_hotels_master WHERE status='1'";
                     $locationResult = mysql_query($locationSql);
                     ?>
                    
                    <div class="field">
                      <div class="inner_div">
                        <label> Area  <sup>*</sup> </label>
                        <select class=" form-control"  name="area" id="area">
                          <option value="">--Select Area--</option>
                          <?php while($locationRow = mysql_fetch_array($locationResult)){?>
                           <option value="<?php echo $locationRow['location'];?>"><?php echo $locationRow['location'];?></option>
                          <?php }?>
                          
                        </select>
                        <label class="error" for="area"></label>
                      </div>
                    </div>
                     <div class="field">
                      <div class="inner_div">
                        <label> Hotels  <sup>*</sup> </label>
                        <select class="form-control"  name="hotels" id="hotels">
                          <option value="">--Select Hotels--</option>
                          
                        </select>
                        <label class="error" for="hotels"></label>
                      </div>
                    </div>
                    <div class="field">
                      <div class="inner_div">
                        <label> Price  <sup>*</sup> </label>
                       <input type="text" name="price" id="price" class="form-control" readonly="readonly">
                        <label class="error" for="price"></label>
                      </div>
                    </div>
                    <div class="field">
                      <div class="inner_div">
                        <label> Check In  <sup>*</sup> </label>
                        <input type="date" min="2020-08-03" max="2020-08-13" name="check_in" id="check_in" class="form-control">
                        <label class="error" for="check_in"></label>
                      </div>
                    </div>
                    <div class="field">
                      <div class="inner_div">
                        <label> Check Out  <sup>*</sup> </label>
                        <input type="date" min="2020-08-03" max="2020-08-13" name="check_out" id="check_out" class="form-control">
                        <label class="error" for="check_out"></label>
                      </div>
                    </div>

                    <div id="link_section">
                    	<input type="hidden" name="link" id="link">
                    	<a href="" id="link_href" target="_blank" style="color: blue;font-size: 18px;text-decoration: underline;margin-left: 20px"></a>
                    </div>
                    
                    <br>
                    <div class="field">
                      <div class="inner_div">
                        <input type="hidden" name="action" value="hotelBooking" >
                        <input type="submit" name="submit" value="Proceed" id="submit" class="submitbtn ">
                      </div>
                    </div>
                  </div>
                </form>
                <table>
                  <tr>
                    <th>Occupancy Type</th>
                    <th>Guest Name </th>
                    
                   
                    <th>Hotel </th>
                    <th>Area</th>
                     <th>Price </th>
                    <th>Hotel Link </th>
                    <th>Check-In</th>
                    <th>Check-Out</th>
                    <th>Action</th>
                  </tr>
                  <?php
                  
                  $sql = "SELECT * FROM iijs_hotel_booking_enquiry WHERE registration_id = '$registration_id' ORDER BY  post_date DESC";
                  $result = mysql_query($sql);
                  while($row = mysql_fetch_array($result)){
                  if($row['type'] == "single"){
                  $type = "Single" ;
                  }else{
                  $type = "Double" ;
                  }
                  
                  ?>
                  <tr>
                    <td><?php echo $type;?></td>
                    <td><?php foreach (explode(",",$row['guest']) as $value) {
                    echo $vis =  getVisitorName($value).", ";
                    } 
                   
                    ?></td>
                    
                    
                    <td><?php echo $row['hotel'] ;?></td>
                    <td><?php echo $row['area'] ;?></td>
                    <td><?php echo $row['price'] ;?></td>
                    <td><a href="<?php echo $row['link'] ;?>" class="btn" target="_blank" >Link</a></td>
                    <td><?php echo $row['check_in'] ;?></td>
                    <td><?php echo $row['check_out'] ;?></td>
                    <td><a class="delete_hotel_booking" data-id="<?php echo $row['id']; ?>"> <img src="images/delete.png" title="Delete"></a></td>
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
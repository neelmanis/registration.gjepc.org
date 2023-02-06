<?php 
include('header_include.php');
if(!isset($_SESSION['USERID'])){ header("location:login.php");	exit; }
if($_SESSION['COUNTRY']=="IN") { header("location:my_dashboard.php"); }
?>

<?php 
$uid=$_SESSION['USERID'];
$company_name = getCompanyName($_SESSION['USERID'],$conn);
$action=$_REQUEST['action'];

	if($action!="addnew"){
	$eid = $_REQUEST['id'];
	
	if(isset($eid) && $eid!='')
		$sql="SELECT * FROM `ivr_registration_details` WHERE uid='$uid' and eid = '$eid' order by eid desc limit 1";
	else
		$sql="SELECT * FROM `ivr_registration_details` WHERE uid='$uid' order by eid desc limit 1";
		
	$result=$conn->query($sql);
	$rows=$result->fetch_assoc();
	$eid=$rows['eid'];
	
	$indian_passport = $rows["indian_passport"];
	$title = $rows["title"];  
	$first_name=filter(strtoupper($rows["first_name"]));
	$last_name=filter(strtoupper($rows["last_name"]));
	$designation = $rows["designation"]; 
	$company_name = strtoupper($rows["company_name"]);
	$city = $rows["city"];
	$state = $rows["state"];
	$country = $rows["country"];
	$email = $rows["email"];
	$website = $rows["website"];
	
	$india_stay = $rows["india_stay"];
	
	$hotel_name = $rows["hotel_name"];
	$hotel_address = $rows["hotel_address"];
	$stay_from = $rows["stay_from"];
	$stay_to = $rows["stay_to"];
	
	$name_of_person = $rows["name_of_person"];
	$family_address = $rows["family_address"];
	$family_contact = $rows["family_contact"];
	$family_relation = $rows["family_relation"];
	$family_stay_from = $rows["family_stay_from"];
	$family_stay_to = $rows["family_stay_to"];
	
	$office_add = $rows["office_add"];
	$passport_no = $rows["passport_no"];
	$valid_upto = $rows["valid_upto"];
	$issue_place = $rows["issue_place"];
	$origin = $rows["origin"];
	$postal_code = $rows["postal_code"];
	$tel_no = $rows["tel_no"];
	$mob_no = $rows["mob_no"];
	$fax_no=$rows["fax_no"];
	//$company_profile = $rows["company_profile"];
	$rules_reg=$rows["rules_reg"];
	$personal_info_approval=$rows["personal_info_approval"];
	$trade_show=$rows["trade_show"];
	
	if($_SESSION['UID_EXISTS_IVR']==0)
	{
		$sql="SELECT * FROM `ivr_registration_details` WHERE uid='$uid' and eid = '$eid' order by eid desc limit 1";
		$result=$conn->query($sql);
		$rows1=$result->fetch_assoc();
		$no_of_rows=$result->num_rows;
		if($no_of_rows==0)
		{
			$sql="SELECT * FROM `registration_master` WHERE id=$uid";
			$result=$conn->query($sql);
			$row_register=$result->fetch_assoc();

			$company_name = $row_register["company_name"];
			$city = $row_register["city"];
			$state = $row_register["state"];
			$country = $row_register["country"];
			$email = $row_register["email_id"];
			$website = $row_register["website"];
			$office_add=$row_register["address_line1"];
			$postal_code=$row_register["pin_code"];
			if($postal_code=''){ $postal_code = $rows["postal_code"]; }else { $postal_code=$row_register["pin_code"]; }
			
			$passport_no = $rows["passport_no"];
			$valid_upto = $rows["valid_upto"];
			$issue_place = $rows["issue_place"];
			$origin = $rows["origin"];
			
			$tel_no = $rows["tel_no"];
			$mob_no = $rows["mob_no"];
			$fax_no=$rows["fax_no"];
			//$company_profile = $rows["company_profile"];
			$rules_reg=$rows["rules_reg"];
			$personal_info_approval=$rows["personal_info_approval"];
			
		} else
		{
			$indian_passport = $rows1["indian_passport"];
			$title = $rows1["title"];
			$first_name=$rows1["first_name"];
			$last_name=$rows1["last_name"];
			$designation = $rows1["designation"]; 
			$company_name = $rows1["company_name"];
			$city = $rows1["city"];
			$state = $rows1["state"];
			$country = $rows1["country"];
			$email = $rows1["email"];
			$website = $rows1["website"];
			$office_add = $rows1["office_add"];
			$passport_no = $rows1["passport_no"];
			$valid_upto = $rows1["valid_upto"];
			$issue_place = $rows1["issue_place"];
			$origin = $rows1["origin"];
			$postal_code = $rows1["postal_code"];
			$tel_no = $rows1["tel_no"];
			$mob_no = $rows1["mob_no"];
			$fax_no=$rows1["fax_no"];
			//$company_profile = $rows1["company_profile"];
			$rules_reg=$rows1["rules_reg"];
			$personal_info_approval=$rows["personal_info_approval"];
		}
	}
	} else {
	$Data = "SELECT * FROM `registration_master` WHERE id='$uid' limit 1";
    $resultData=$conn->query($Data);
	$rowsData=$resultData->fetch_assoc();
	$company_name = filter(strtoupper($rowsData['company_name']));
	$office_add = $rowsData['address_line1'].','.$rowsData['address_line2'].','.$rowsData['address_line3'];
	$city = $rowsData["city"];
	$state = $rowsData["state"];
	$country = $rowsData["country"];
	$postal_code = $rowsData["pin_code"];
	}	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>International Visitor Registration </title>
<link rel="shortcut icon" href="images/fav.png" />
<link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Cabin'>
<link rel="stylesheet" type="text/css" href="css/general.css?v=<?php echo $version;?>" />
<link rel="stylesheet" type="text/css" href="css/inner_pg_style.css?v=<?php echo $version;?>" />
<script type="text/javascript" src="https://code.jquery.com/jquery.js?v=<?php echo $version;?>"></script>
<!--<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>-->

<!-- UItoTop plugin -->
<link rel="stylesheet" type="text/css" media="screen,projection" href="css/ui.totop.css?v=<?php echo $version;?>" />
<script src="js/easing.js?v=<?php echo $version;?>" type="text/javascript"></script>
<script src="js/jquery.ui.totop.js?v=<?php echo $version;?>" type="text/javascript"></script>  
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

<noscript>
<img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=398834417477910&ev=PageView&noscript=1"/></noscript>
<!-- End Facebook Pixel Code -->

<script type="text/javascript">
    $(document).ready(function(){
        $('input[name="\apply_visa\"]').click(function(){
		if($(this).attr("value")=="yes"){
		$('#div_apply_visa').show();           
       }else {
            $('#div_apply_visa').hide();   
       }
           
        });
    });
</script>

<!-- calendar starts-->
<link rel="stylesheet" href="calendar/css/jquery-ui.css?v=<?php echo $version;?>" />
  <script src="calendar/js/jquery-1.9.1.js?v=<?php echo $version;?>"></script>
  <script src="calendar/js/jquery-ui.js?v=<?php echo $version;?>"></script>
  <!--<link rel="stylesheet" href="/resources/demos/style.css" />-->
  <script>
  $(function() {
    $( "#datepicker" ).datepicker();
  });
  </script>
<script src="jsvalidation/jquery.validate.js?v=<?php echo $version;?>" type="text/javascript"></script> 
<link rel="stylesheet" type="text/css" media="screen" href="css/rcmc.validation.css?v=<?php echo $version;?>" /> 

<script type="text/javascript">
function validation()
{
		var india_stay = $("input[name='india_stay']:checked").val();
		if(india_stay=='hotel'){
			if($('#hotel_name').val()==""){
				alert("Enter Hotel Name");
				$('#hotel_name').focus();
				return false;
			}
			if($('#hotel_address').val()==""){
				alert("Enter Hotel Address");
				$('#hotel_address').focus();
				return false;
			}
			if($('#stay_from').val()==""){
				alert("Enter stay date from");
				$('#stay_from').focus();
				return false;
			}
			if($('#stay_to').val()==""){
				alert("Enter stay to");
				$('#stay_from').focus();
				return false;
			}
		}
		if(india_stay=='family'){
			if($('#name_of_person').val()==""){
				alert("Enter Person Name");
				$('#name_of_person').focus();
				return false;
			}
			if($('#family_address').val()==""){
				alert("Enter Family Address");
				$('#family_address').focus();
				return false;
			}
			if($('#family_stay_from').val()==""){
				alert("Enter stay date from");
				$('#family_stay_from').focus();
				return false;
			}
			if($('#family_stay_to').val()==""){
				alert("Enter stay to");
				$('#family_stay_to').focus();
				return false;
			}
			if($('#family_contact').val()==""){
				alert("Enter Family contact no");
				$('#family_contact').focus();
				return false;
			}
		}		
}

$().ready(function() {
	// validate the comment form when it is submitted
	// validate signup form on keyup and submit
	$("#form1").validate({
			//var member_id=$("#member_type_id").val();
		rules: {  
			email: {
				required: true,
				email:true
			},  
			designation: {
				required: true,
			},
			title: {
				required: true,
			},  
			origin: {
				required: true,
			}, 
			indian_passport: {
				required: true,
			},
			first_name: {
				required: true,
			},  
			last_name: {
				required: true,
			},
			company_name: {
				required: true,
			}, 	
			valid_upto: {
				required: true,
			},
			issue_place: {
				required: true,
			},
			passport_no: {
				required: true,
			},
			office_add: {
				required: true,
			},
			country: {
				required: true,
			},
			state: {
				required: true,
			},
			city: {
				required: true,
			}, 
			postal_code: {
				required: true,
			}, 
			tel_no: {
				required: true,
				number:true
			},
			mob_no: {
				required: true,
				number:true,
				minlength: 10,
				maxlength:15
			},
			iagree: {
				required: true,
			}, 
			iconfirm: {
				required: true,
			},
				
		},
		messages: {
			email: {
				required: "Please enter a valid email id",
			},
			designation: {
				required: "Please enter your designation",
			},  
			first_name: {
				required: "Please enter your first name",
			},
			last_name: {
				required: "Please enter last name",
			}, 
			valid_upto: {
				required: "Please select a date",
			},
			issue_place: {
				required: "Please enter Place of Issue",
			},
			passport_no: {
				required: "Please enter your passport no",
			},
			indian_passport: {
				required: "Please select One",
			},
			company_name: {
				required: "Please enter company name",
			},  
			office_add: {
				required: "Please enter address",
			},   
			country: {
				required: "Please choose a country",
			},
			state: {
				required: "Please enter state",
			}, 
			city: {
				required: "Please enter city",
			},
			postal_code: {
				required: "Please enter pincode",
			},
			tel_no: {
				required: "Please enter landline number",
				number:"please enter numbers only"
			},
			mob_no: {
				required: "Please enter mobile number",
				number:"please enter numbers only",
				minlength:"Please enter at least {10} digit.",
				maxlength:"Mobile No less than {15} digit."
			},
			title: {
			required: "Please Select One",
			}, 
			origin: {
			required: "Please Select One",
			}, 
			iagree: {
				required: "Please Agree to the Terms",
			}, 
			iconfirm: {
				required: "Please confirm your participation",
			},
			
	 }
	});
	
	
	$("#iconfirm").click(function(){
		$('#iconfirm_error').text("");
	});
	$("#iagree").click(function(){
		$('#iagree_error').text("");
	});

var radioValue = $("input[name='india_stay']:checked").val();
if(radioValue=='hotel'){
		$('#hotel_detail').show();
		$('#family_detail').hide();
	}
	else if(radioValue=='family'){
		$('#hotel_detail').hide();
		$('#family_detail').show();
	}
	else{
		$('#hotel_detail').hide();
		$('#family_detail').hide();
	}

$('input[type="radio"]').on('click', function(){
    val=$(this).val();
	if(val=='hotel'){
		$('#hotel_detail').show();
		$('#family_detail').hide();
	}
	else if(val=='family'){
		$('#hotel_detail').hide();
		$('#family_detail').show();
	}
	else{
		$('#hotel_detail').hide();
		$('#family_detail').hide();
	}
	
});	
});
</script>

<script>
$(document).ready(function(){
	/* Visitor Email Check */
	$("#email").change(function(){
	email = $("#email").val();
	eid = $("#eid").val();
			$.ajax({
					type: 'POST',
					url: 'ajax.php',
					data: "actiontype=email&email="+email+"&eid="+eid,
					dataType:'html',
					beforeSend: function(){
						$('#preloader').show();
						$("#status").show();
					},
					success: function(data){						
							     //alert(data);
								$('#preloader').hide();
								$("#status").hide(); 
								if($.trim(data)==1){
								 	$('#submit').attr('disabled', true);
									$("#chkEmailuser").html("Email is Already Exist").css("color", "red"); 
								} /*else if($.trim(data)==2){
								 	$('#submit').attr('disabled', true);
									$("#chkEmailuser").html("Please Enter Email").css("color", "red");
								} */
								else {
								 	$("#chkEmailuser").html("");
								 	$('#submit').removeAttr("disabled");
								}
							}
		});
	});
	});
</script>
<link rel="stylesheet" type="text/css" href="css/form.css?v=<?php echo $version;?>"/>
</head>

<body>
<div class="wrapper">

<div class="header">
	<?php include('header1.php'); ?>
</div>
<div id="preloader">
    <div id="status"> <img src="https://www.gjepc.org/assets/images/logo.png"></div>
</div>
<div class="inner_container">
	<div class="bold_font text-center">
    <div class="d-block">
    <img src="https://www.gjepc.org/assets/images/gold_star.png" class="">
    </div>
    International Visitor Registration
	</div>  
    <div class="clear"></div>
    <div class="content_area box-shadow">    
    <div id="">              
    <div id="">          
            
    <div class="tabb_link">
    	<div><a href="#" class="tab current"> <span class="no">1</span> Personal <br>Information <span class="dwn_arw"></span></a></div>
        <div><a href="#" class="tab"> <span class="no">2</span> OBMP <br>Information  </a></div>
        <div><a href="#" class="tab"> <span class="no">3</span> Upload <br>Documents</a>   </div>     
    <div class="clear"></div>    
    </div>
<div class="clear"></div>
                 
<form method="post" id="form1" name="ivr_registration_step1" action="obmp_profile_ivr.php" onsubmit="return validation()">
<input type="hidden" name="eid" id="eid" value="<?php echo $_REQUEST['id'];?>"/>
<div id="form" style="display:flex; flex-wrap:wrap;">
	<input type='hidden' name='personal_info_approval' value='<?php echo $personal_info_approval;?>'>
    <div class="field">
    <label>Title : <sup>*</sup><br />&nbsp; </label>
    <select name="title" class="selectField">
    <option value="">---Select One---</option>
    <option value="Mr" <?php if($title=="Mr") echo "selected"; ?>> Mr </option>
    <option value="Ms" <?php if($title=="Ms") echo "selected"; ?>> Ms </option>
    <option value="Mrs" <?php if($title=="Mrs") echo "selected"; ?>> Mrs </option>
    <option value="Dr" <?php if($title=="Dr") echo "selected"; ?>> Dr </option>
    </select>
    </div>            
            
    <div class="field">
    <label>First Name : <sup>*</sup><br />&nbsp;</label>
    <input name="first_name" id="first_name" type="text" class="textField" value="<?php echo $first_name;?>" autocomplete="off"/>
    </div>
            
    <div class="field">
    <label>Last Name : <sup>*</sup><br />&nbsp;</label>
    <input name="last_name" type="text" id="last_name" class="textField" value="<?php echo $last_name;?>" autocomplete="off"/>
    <div class="clear"></div>
    </div>
            
    <div class="field">
    <label>Designation : <sup>*</sup><br />&nbsp;</label>
	<select class="selectField" name="designation" id="designation">                                  
		<option value="" selected="selected">-- Select Designation-- </option> 
		<?php 
		$sqlx1= "SELECT * FROM `visitor_designation_master` order by type";
		$query1 =  $conn->query($sqlx1);
		while($row1 = $query1->fetch_assoc()){?>
		<option value="<?php echo $row1['type_of_designation']?>" <?php if($row1['type_of_designation']==$designation)echo "selected";?>><?php echo $row1['type_of_designation'];?></option>
		<?php } ?>
	</select>
    </div>
	
    <div class="field">
    <label>Origin : <sup>*</sup><br />&nbsp;</label>
    <select name="origin" class="selectField" id="origin">
    <option value="">---Select One---</option>    
    <option value="Non Resident Indian" <?php if($origin=="Non Resident Indian" || $origin=="NRI") echo "selected"; ?>> Non Resident Indian</option>
    <option value="Foreign National" <?php if($origin=="Foreign National") echo "selected"; ?>> Foreign National </option>
    </select>
    </div>
	
    <div class="field">
    <label>Do you have an Indian Passport ?: <sup>*</sup><br />&nbsp;</label>
    <div class="leftContent">
    <span>Yes</span>
    <input name="indian_passport" type="radio" value="yes" class="radio radioBtn" <?php if($indian_passport=="yes")echo "checked"; ?>/> 
    <span>No</span>
    <input name="indian_passport" type="radio" value="no" class="radio radioBtn" <?php if($indian_passport=="no")echo "checked"; ?>/>
    </div>
    </div>            
            
    <div class="field">
    <label>Passport No. : <sup>*</sup><br />&nbsp;</label>
    <input name="passport_no" id="passport_no" type="text" class="textField" value="<?php echo $passport_no;?>"/>
    </div>
            
    <div class="field">
    <label>Valid Upto : <sup>*</sup><br />&nbsp;</label>
    <input name="valid_upto" type="text"  class="textField" id="datepicker" value="<?php echo $valid_upto;?>" autocomplete="off"/>
    </div>            
            
    <div class="field">
    <label>Issue Place : <sup>*</sup><br />&nbsp;</label>
    <input name="issue_place" type="text" id="issue_place" class="textField" value="<?php echo $issue_place;?>" autocomplete="off"/>
    </div>
     
    <div class="field">
    <label>Company Name : <sup>*</sup><br />&nbsp;</label>
    <input name="company_name" type="text" class="textField" id="company_name" value="<?php echo $company_name;?>" autocomplete="off" readonly/>
    </div>
            
    <div class="field">
    <label>Office Address : <sup>*</sup><br />&nbsp;</label>
    <textarea name="office_add" cols="" rows="" id="office_add" class="textField"><?php echo $office_add;?></textarea>
    </div>
                        
    <div class="field">
    <label>Country : <sup>*</sup><br />&nbsp;</label>
    <select name="country" id="country" class="selectField" > 
    <option value="">---------- Select ----------</option>
    <?php 
    $query=$conn->query("SELECT * FROM country_master where country_code!='IN'");
    while($result=$query->fetch_assoc()){  ?>
    <option value="<?php echo $result['country_code'];?>" <?php if($result['country_code']==$country)echo "selected";?> ><?php echo $result['country_name'];?></option>
    <?php } ?>
    </select>  
    <br />
    <span id="error_first_name"></span>
    <div class="clear"></div>
    </div>
            
    <div class="field">
    <div id="stateDiv">
    <label>State : <sup>*</sup><br />&nbsp;</label>
    <input name="state" type="text"  class="textField" id="state" value="<?php echo $state;?>"/>
    </div>
 
    </div>
            
    <div class="field">
    <label>City : <sup>*</sup><br />&nbsp;</label>
    <input name="city" type="text"  class="textField" id="city" value="<?php echo $city;?>" autocomplete="off"/>

    </div>
            
    <div class="field">
    <label>Zip Code / Postal Code : <sup>*</sup><br />&nbsp;</label>
    <input name="postal_code" type="text" class="textField" id="postal_code" maxlength="10" value="<?php echo $postal_code;?>" autocomplete="off"/>

    </div>
        
    <div class="field">            
    <label>Office No.  <sup>*</sup><br />
    </label>
    <input name="tel_no" type="text"  class="textField" id="tel_no" value="<?php echo $tel_no;?>"/>              
 
    </div>            
            
    <div class="field">            
    <label>Mobile No.  <sup>*</sup>
    for e.g. 918975685265</label>            
    <input name="mob_no" type="text"  class="textField" id="mob_no" value="<?php echo $mob_no;?>"/>  
              
    </div>            
            
    <!-- <div class="field">
    <label>Office. No. (with country & city code) <sup>*</sup><br />
    for e.g. 2224065689</label>
    <input name="fax_no" type="text"  class="textField" id="fax_no" value="<?php echo $fax_no;?>"/>
    <div class="clear"></div>
    </div>  -->           
            
    <div class="field">
    <label>Email : <sup>*</sup>&nbsp;</label>
    <input type="text" name="email" id="email" class="textField" value="<?php echo $email;?>" autocomplete="off"/>
    <div class="clear"></div>
	<p id="chkEmailuser"></p>      
    </div>            
            
    <div class="field">
    <label>Website :</label>
    <input name="website" type="text" id="website" class="textField" value="<?php echo $website;?>"/>
    <div class="clear"></div>
    </div>            
            
    <!-- <div class="field">
    <label>Company Profile :<sup>*</sup><br />&nbsp;</label>
    <textarea name="company_profile" id="company_profile" class="textField" rows="5" cols="5"><?php echo $company_profile;?></textarea>
    <div class="clear"></div>
    </div> -->
    <style>
	.rightContent span {
    display: inline-block;
    width: 75px;
	}
	</style>
	<!--<div class="field">
        	<div class="leftTitle" style="padding-top:0px;">Please confirm your India stay during  IIJS Premiere : <sup>*</sup></div>
        	<div class="rightContent">
        	<span>Hotel</span>
        	<input name="india_stay" type="radio" value="hotel"  class="radio radioBtn" <?php if($india_stay=="hotel")echo "checked"; ?>/> 
        	<span>Friend/Family</span>
        	<input name="india_stay" type="radio" value="family" class="radio radioBtn" <?php if($india_stay=="family")echo "checked"; ?>/>
            <span>Not yet confirmed</span>
        	<input name="india_stay" type="radio" value="nyc" class="radio radioBtn" <?php if($india_stay=="nyc")echo "checked"; ?>/>
        </div>
        <div class="clear"></div>
    </div>
        
        <div id="hotel_detail" style="display:none;">
            <div class="field">
                <label>Hotel Name :<sup>*</sup></label>
                <input type="text" name="hotel_name" id="hotel_name" class="textField" value="<?php echo $hotel_name;?>" />
                <div class="clear"></div>
                <label>Address :<sup>*</sup></label>
                <input type="text" name="hotel_address" id="hotel_address" class="textField" value="<?php echo $hotel_address;?>" />
                <div class="clear"></div>
            </div>
            <div class="field">
                <div class="leftTitle" style="padding-top:0px;"><label>Stay Duration :<sup>*</sup></label></div>
                <div class="rightContent">
                    <span>From</span>
                    <input name="stay_from" id="stay_from" type="date" value="<?php echo $stay_from;?>" />  
                    <span>To</span>
                    <input name="stay_to" id="stay_to" type="date"  value="<?php echo $stay_to;?>" />
               </div>
            <div class="clear"></div>
            </div>
        </div>
        
        <div id="family_detail" style="display:none;">
            <div class="field">
                <label>Name of person:<sup>*</sup></label>
                <input type="text" name="name_of_person" id="name_of_person" class="textField" value="<?php echo $name_of_person;?>" />
                <div class="clear"></div>
                <label>Address :<sup>*</sup></label>
                <input type="text" name="family_address" id="family_address" class="textField" value="<?php echo $family_address;?>" />
                <div class="clear"></div>
                <label>Contact :<sup>*</sup></label>
                <input type="text" name="family_contact" id="family_contact" class="textField" value="<?php echo $family_contact;?>" />
                <div class="clear"></div>
                <label>Relation with visitor :<sup>*</sup></label>
                <input type="text" name="family_relation" id="family_relation" class="textField" value="<?php echo $family_relation;?>" />
                <div class="clear"></div>
                
                <div class="field">
                <div class="leftTitle" style="padding-top:0px;"><label>Stay Duration :<sup>*</sup></label></div>
                <div class="rightContent">
                    <span>From</span>
                    <input name="family_stay_from" id="family_stay_from" type="date" value="<?php echo $family_stay_from;?>" />  
                    <span>To</span>
                    <input name="family_stay_to" id="family_stay_to" type="date"  value="<?php echo $family_stay_to;?>" />
               </div>
            <div class="clear"></div>
            </div>
                
            </div>
        </div>-->
		
            <div class="bottomSpace"></div> 
            <div class="clear" style="width: 100%"></div> 
            
             <?php /* if($personal_info_approval!='Y' || $trade_show =="IIJS 2019"  || $trade_show =="Signature 2020" || $trade_show =="Signature 2021" || $trade_show =="IIJS 2021"){ */ ?> 
             <?php
			 if($personal_info_approval!='Y'){ ?>             
            <div class="w-100">             
            <div class="title">Terms of Agreement</div> 
            <div class="body_text">
            
            <div class="paragraph">These are the general terms and conditions of <b>Gems and Jewellery Export Promotion Council</b> (GJEPC) for use of the GJEPC web site. Please read these terms and conditions carefully as your use of the Site is subject to them. GJEPC reserves the right at its sole discretion to change, modify or add to these terms and conditions without prior notice to you. By continuing to use the Site you agree to be bound by such amended terms.</div>
        <ol class="number">
        <li><strong>What you are allowed to do You may:</strong>
		<ol type="a"><li>browse the Site and view the information on it for personal, professional or other commercial purposes;</li>
		<li>print off pages from the Site to the extent reasonably necessary for your use of the Site in accordance with the above. Provided that at all times you do not do any of the things set out in clause 2.</li></ol></li>
        <li><strong>What you are not allowed to do Subject to these terms and conditions, you may not:</strong>
		<ol type="a"><li>systematically copy (whether by printing off onto paper, storing on disk or in any other way) substantial parts of the Site;</li>
		<li>remove, change or obscure in any way anything on the Site or otherwise use any material contained on the Site except as set out in these terms and conditions;</li>
		<li>include or create hyperlinks to the Site or any materials contained on the Site; or</li>
		<li>use the Site and anything available from the Site in order to produce any publication or otherwise provide any service that competes with the Site (whether on-line or by other media); or</li>
		<li>for unlawful purposes and you shall comply with all applicable laws, statutes and regulations at all times.</li></ol></li>
		<li><strong>No Investment Advice You acknowledge that:</strong>
		<ol type="a"><li>GJEPC does not provide investment advice and that nothing on the Site constitutes investment advice (as defined in the Financial Services Act 1986) and that you will not treat any of the Site's content as such;</li>
		<li>GJEPC does not recommend any financial product;</li>
		<li>GJEPC does not recommend that any financial product should be bought, sold or held by you; and</li>
		<li>nothing on the Site should be construed as an offer, nor the solicitation of an offer, to buy or sell securities by GJEPC</li>
		<li>information which may be referred to on the Site from time to time may not be suitable for you and that you should not make any investment decision without consulting a fully qualified financial adviser.</li></ol></li>
		<li><strong>Access The Site is directed exclusively at users located within the United Kingdom and as such any use of the site by users outside India is at their sole risk. By using the Site you confirm that you are located within India and that you are permitted by law to use the Site.</strong></li>
		<li><strong>Your personal information:</strong><br>
        GJEPC's use of your personal information is governed by GJEPC's Privacy Policy, which forms part of these terms and conditions.</li>
		<li><strong>Copyright and Trade Marks</strong>
<ol><li>All copyright and other intellectual property rights in any material (including text, photographs and other images and sound) contained in the Site is either owned by GJEPC or has been licensed to GJEPC by the rights owner(s) for use by GJEPC on the Site. You are only allowed to use the Site and the material contained in the Site as set out in these terms and conditions.</li>
		<li>The Site contains trade marks, including the GJEPC name and logo. All trade marks included on the Site belong to GJEPC or have been licensed to GJEPC by the trade mark owner(s) for use on the Site. You are not allowed to copy or otherwise use any of these trade marks in any way except as set out in these terms and conditions.</li></ol></li>
		<li><strong>Exclusions and limitations of liability</strong>
<ol><li>GJEPC does not exclude or limit its liability for death or personal injury resulting from its negligence, fraud or any other liability which may not by applicable law be excluded or limited.</li>
		<li>Subject to clause 7.1, in no event shall GJEPC be liable (whether for breach of contract, negligence or for any other reason) for (i) any loss of profits, (ii) exemplary or special damages, (iii) loss of sales, (iv) loss of revenue, (v) loss of goodwill, (vi) loss of any software or data, (vii) loss of bargain, (viii) loss of opportunity, (ix) loss of use of computer equipment, software or data, (x) loss of or waste of management or other staff time, or (xi) for any indirect, consequential or special loss, however arising.</li>
		</ol></li>
		<li><strong>Disclaimer</strong>
<ol><li>All information contained on the site is for general informational use only and should not be relied upon by you in making any investment decision. The site does not provide investment advice and nothing on the site should be construed as being investment advice. Before making any investment choice you should always consult a fully qualified financial adviser.</li>
		<li>Although gjepc uses its reasonable efforts to ensure that information on the site is accurate and complete, we cannot guarantee this to be the case. As a result, use of the site is at your sole risk and gjepc cannot accept any liability for loss or damage suffered by you arising from your use of information contained on the site. You should take adequate steps to verify the accuracy and completeness of any information contained on the site.</li>
		<li>Information contained on the site is not tailored for individual use and as a result such information may be unsuitable for you and your investment decisions. You should consult a financial adviser before making any investment decision.</li>
		<li >The Site includes advertisements and links to external sites and co-branded pages in order to provide you with access to information and services which you may find useful or interesting. GJEPC does not endorse such sites nor approve any content, information, goods or services provided by them and cannot accept any responsibility or liability for any loss or damage suffered by you as a result of your use of such sites.</li>
		<li >GJEPC is unable to exercise control over the security or content of information passing over the network or via the Service, and GJEPC hereby excludes all liability of any kind for the transmission or reception of infringing or unlawful information of whatever nature.</li>
		<li>GJEPC accepts no liability for loss or damage suffered by you as a result of accessing Site content which contains any virus or which has been maliciously corrupted.</li></ol></li>
		<li><strong>Availability and updating of the Site</strong>
<ol><li>GJEPC may suspend the operation of the Site for repair or maintenance work or in order to update or upgrade its content or functionality from time to time. GJEPC does not warrant that access to or use of the Site or of any sites or pages linked to it will be uninterrupted or error free.</li>
		<li>GJEPC may change the format and content of the Site at its sole discretion from time to time. You should refresh your browser each time you visit the Site to ensure that you access the most up to date version of the Site.</li></ol></li>
		<li><strong>Enquiries or complaints</strong><br>
		If you have any enquiries or complaints about the Site then please address them (within 30 days of such enquiry or complaint first arising) to :  email: info@gjepc.org</li>
		<li><strong>General and governing law</strong>
<ol><li>These terms and conditions form the entire understanding of the parties and supersede all previous agreements, understandings and representations relating to the subject matter. If any provision of these terms and conditions is found to be unenforceable, this shall not affect the validity of any other provision. GJEPC may delay enforcing its rights under these terms and conditions without losing them. You agree that GJEPC may sub-contract the performance of any of its obligations or may assign these terms and conditions or any of its rights or obligations without giving you notice.</li>
		<li>GJEPC will not be liable to you for any breach of these terms and conditions which arises because of any circumstances which GJEPC cannot reasonably be expected to control.</li>
		<li>These terms and conditions shall be governed and interpreted in accordance with Indian law, and you consent to the non-exclusive jurisdiction of the Indian courts.</li></ol></li>
		</ol></div>
        
        </div>
            
<!--<div class="agreement">     
<div class="form-item" id="edit-terms-checkbox-wrapper">
 <label class="option" for="edit-terms-checkbox"><input type="checkbox" name="iagree" id="iagree" value="1" <?php if(preg_match('/1/',$rules_reg)){ echo ' checked="checked"'; } ?> class="form-checkbox">  I agree to above mentioned rules & regulations <sup>*</sup></label><span id="iagree_error" class="error_msg"></span>
<div class="clear"></div>
</div>

<div class="form-item" id="edit-terms-checkbox-wrapper">
 <label class="option" for="edit-terms-checkbox">
 <input type="checkbox" id="iconfirm" name="iconfirm" value="2" <?php if(preg_match('/2/',$rules_reg)){ echo ' checked="checked"'; } ?> class="form-checkbox" />
 <strong>Please confirm my visit for IIJS PREMIERE. </strong></br>
 • Jewellery, Stones & Allied Section - BEC,  <strong> Mumbai (06th – 10th August, 2020)</strong></br>
 • Machinery Section <strong> Mumbai (06th – 10th August, 2020) </strong> </br></label>
 <span id="iconfirm_error" class="error_msg"></span>
 <div class="clear"></div>
</div>

<div class="form-item" id="edit-terms-checkbox-wrapper">
 <label class="option" for="edit-terms-checkbox">
 <input type="checkbox" name="iconfirms[]" value="IIJS PREMIERE 2019 and MACHINERY 2019" <?php if(preg_match('/13th – 16st February, 2020/',$rules_reg)){ echo 'checked="checked"'; } ?> class="form-checkbox" />
 <strong>Please confirm my visit for IIJS PREMIERE 2019 and MACHINERY 2019 - BEC, Mumbai. </strong></label>
 <span id="iconfirm_error" class="error_msg"></span> 
 <div class="clear"></div>
</div>
<div class="clear"></div>
</div>-->
<div class="form-item w-100" id="edit-terms-checkbox-wrapper">
    <label class="option" for="edit-terms-checkbox"><input type="checkbox" name="terms_and_cond" id="terms_and_cond" checked value="1" class="form-checkbox"> I have read and agreed to the 'Terms of Agreement' above. </label>
    <div class="clear"></div>
    <div class="form-item" id="edit-terms-checkbox-wrapper">
    <label class="option" for="edit-terms-checkbox">This question is for testing whether you are a human visitor and to prevent automated spam submissions.</label>
    <div class="clear"></div>
    </div>
   
    </div>
    <div class="form-item w-100" id="edit-terms-checkbox-wrapper">
    <label class="option" for="edit-terms-checkbox"><input type="checkbox" name="visit_iijs_virtual" id="visit_iijs_virtual" checked value="1" class="form-checkbox"> I am interested to visit Show</label>
    <div class="clear"></div>
    </div>
    <div class="clear"></div>

<div class=""><input type="submit" name="submit" id="submit" value="Proceed To Next Step" class="cta"></div>
<?php } else { ?>
<div class=""><a class="cta" href="obmp_profile_ivr.php?eid=<?php echo $eid; ?>">Next</a></div>
<?php } ?>
<input type="hidden" name="action" id="action" value="submit"/>
<input type="hidden" name="eid" id="eid" class="newMaroonBtn" value="<?php echo $eid; ?>"/>
<div class="clear"></div>
</div>
</form>          
</div>
</div>
	   
    <div class="clear"></div>
	</div>

	<!-- <div class="right_area">
    <?php include('include_account_links.php'); ?>
    <div class="clear"></div>
    </div> -->
<div class="clear" style="height:10px;"></div>
</div>

<div class="footer">
	<?php include('footer.php'); ?>
<div class="clear"></div>
</div>

<div class="clear"></div>
</div>

<link rel="stylesheet" type="text/css" href="css/responsive.css?v=<?php echo $version;?>" />
<link rel="stylesheet" type="text/css" href="css/media_query.css?v=<?php echo $version;?>" />
<!--<script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>-->

<!--NAV-->
<link href="css/flexnav.css?v=<?php echo $version;?>" media="screen, projection" rel="stylesheet" type="text/css">
<script src="js/jquery.flexnav.js?v=<?php echo $version;?>" type="text/javascript"></script>
<script src="js/common.js?v=<?php echo $version;?>"></script> 
<!--NAV-->
</body>
</html>
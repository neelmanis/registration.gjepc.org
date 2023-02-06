<?php 
/*
NECCESSERAY FILES  FOR THIS PAGE
css/general.css
https://gjepc.org/assets-new/css/bootstrap.min.css
js/jquery-1.9.1.js
https://gjepc.org/assets-new/js/bootstrap.min.js
jsvalidation/jquery.validate.js
$no_of_trees = 
$plant_rate;
$visitor_id;
$registration_id;
$visitor_type;
$tree_amount =  $plant_rate * $no_of_trees;
*/

$general_info = $conn->query("SELECT * FROM registration_master WHERE id='$registration_id' ");
$general_info_result  = $general_info->fetch_assoc();
$billing_state = filter($general_info_result['state']);
$tree_name = $general_info_result['company_name'];
$billing_city = filter($general_info_result['city']);
$billing_postcode = filter($general_info_result['pin_code']);
$billing_pan_card_no = filter($general_info_result['company_pan_no']);



if($visitor_type =="exhibitor"){
  $sql_plant_qty = "SELECT * FROM plant_exhibitor_master WHERE area='$signature_exh_area'";
  $result_plant_qty = $conn->query($sql_plant_qty);
  $row_plant_qty = $result_plant_qty->fetch_assoc(); 
  $no_of_trees =  $row_plant_qty['no_tree'];
  $exh_reg_general_info = $conn->query("SELECT * FROM exh_reg_general_info WHERE uid='$registration_id' and event_for='IIJS SIGNATURE 2023'");
  $exh_reg_general_info_result = $exh_reg_general_info->fetch_assoc();
  $tree_name = $exh_reg_general_info_result['company_name'];
  // $fname = substr( $exh_reg_general_info_result['contact_person'], 0, strpos( $exh_reg_general_info_result['contact_person'], ' ' ) );
	//  $lname =  substr(strstr($exh_reg_general_info_result['contact_person']," "), 1);
	 $mobile = filter($exh_reg_general_info_result['mobile']);
	 $email = filter($exh_reg_general_info_result['email']);
	 $billing_first_name = substr( $exh_reg_general_info_result['contact_person'], 0, strpos( $exh_reg_general_info_result['contact_person'], ' ' ) );
	 $billing_last_name = substr(strstr($exh_reg_general_info_result['contact_person']," "), 1);
   $billing_address_1 = filter($exh_reg_general_info_result['billing_address1']);
	 // $billing_state = filter($exh_reg_general_info_result['billing_address']);
	 $billing_city = filter($exh_reg_general_info_result['bcity']);
	 $billing_postcode = filter($exh_reg_general_info_result['bpincode']);
	 $billing_pan_card_no = filter($exh_reg_general_info_result['pan_no']);
	 $billing_aadhar_card_no = filter($_POST['billing_aadhar_card_no']);

}else if($visitor_type =="visitor"){
  $sql_plant_qty = "SELECT * FROM plant_category_master WHERE category='VIS'";
  $result_plant_qty = $conn->query($sql_plant_qty);
  $row_plant_qty = $result_plant_qty->fetch_assoc(); 
  $no_of_trees =  $row_plant_qty['quota'];
}else if($visitor_type =="international"){
  $sql_plant_qty = "SELECT * FROM plant_category_master WHERE category='INTL'";
  $result_plant_qty = $conn->query($sql_plant_qty);
  $row_plant_qty = $result_plant_qty->fetch_assoc(); 
  $no_of_trees =  $row_plant_qty['quota'];
}
$tree_amount =  $plant_rate * $no_of_trees;


if($visitor_type =="visitor" ||  $visitor_type =="international" ){




	 
   if($visitor_type =="visitor"){
   	$query_sel = "SELECT name,lname,mobile,email FROM visitor_directory where visitor_id='$visitor_id'";	
    $result_sel = $conn->query($query_sel);								
		$row = $result_sel->fetch_assoc();	
		$billing_first_name=	strtoupper($row['name']);
		$billing_last_name=	strtoupper($row['lname']);
		$mobile=	strtoupper($row['mobile']);
		$email=	strtoupper($row['email']);

   }


   if($visitor_type =="international"){
   	$query_sel = "SELECT first_name,last_name,mob_no,email,state FROM ivr_registration_details where eid='$visitor_id' AND uid='$registration_id'";	

    $result_sel = $conn->query($query_sel);								
		$row = $result_sel->fetch_assoc();	
		$billing_first_name=	strtoupper($row['first_name']);
		$billing_last_name=	strtoupper($row['last_name']);
		$mobile=	strtoupper($row['mob_no']);
		$email=	strtoupper($row['email']);
		$billing_state=	strtoupper($row['state']);


   }

	 
	
}
$billing_address_1 = $general_info_result['address_line1']." ".$general_info_result['address_line2']." ".$general_info_result['address_line3'];

$action=$_REQUEST['action'];
if($action == "plant_registration")
{
	  $visitor_type = filter($_POST['visitor_type']);
		$tree_name = filter($_POST['tree_name']);
		$tree_qty = filter($_POST['tree_qty']);
		$tree_amount = filter($_POST['tree_amount']);
		// $fname = filter($_POST['fname']);
		// $lname = filter($_POST['lname']);
		$mobile = filter($_POST['mobile']);
		$email = filter($_POST['email']);
		$billing_first_name = filter($_POST['billing_first_name']);
		$billing_last_name = filter($_POST['billing_last_name']);
		$billing_address_1 = filter($_POST['billing_address_1']);
		$billing_state = filter($_POST['billing_state']);
		$billing_city = filter($_POST['billing_city']);
		$billing_postcode = filter($_POST['billing_postcode']);
		$billing_pan_card_no = filter($_POST['billing_pan_card_no']);
		$billing_aadhar_card_no = filter($_POST['billing_aadhar_card_no']);
		$exhibitor_area = filter($_POST['exhibitor_area']);
    
		 $insert =  "INSERT INTO plant_registration SET create_date=NOW(),registration_id='$registration_id',visitor_type='$visitor_type',tree_name='$tree_name',tree_qty='$tree_qty',tree_amount='$tree_amount',mobile='$mobile',email='$email',billing_first_name='$billing_first_name',billing_last_name='$billing_last_name',billing_address_1='$billing_address_1',billing_state='$billing_state',billing_city='$billing_city',billing_postcode='$billing_postcode',billing_pan_card_no='$billing_pan_card_no',billing_aadhar_card_no='$billing_aadhar_card_no',exhibitor_area='$exhibitor_area'";
		$conn->query($insert);


	if($visitor_type =="international"){
 	  $state = $_POST['billing_state'];
  }else{
  	$state = getStateName(filter($_POST['billing_state']),$conn);
  }
 
 $response_url = "https://sankalptaru.org/brand-promotions/one-earth-initiative/?tree_name=".$tree_name."&phone_number=".$mobile."&email_id=".$email."&billing_first_name=".$billing_first_name."&billing_last_name=".$billing_last_name."&billing_address_1=".$billing_address_1."&billing_state=".$state."&billing_city=".$billing_city."&billing_postcode=".$billing_postcode."&billing_pan_card_number=".$billing_pan_card_no."&billing_aadhar_card_number=".$billing_aadhar_card_no."&tree_count=".$tree_qty;

 echo "<script langauge=\"javascript\">window.open('".$response_url."', '_blank');</script>";
 //echo "<script langauge=\"javascript\">window.open('".$response_url."', '_blank', 'toolbar=0,location=0,menubar=0');</script>";
 //header("Location: ". $response_url); 

}

?>
	<div class="row "   >
		<div class="col-12" >

	<img src="images/ONE-EARTH-Banner-400.jpg" class="img-fluid p-0">
</div>
</div>
	<div class="  "   >
		<div class="p-3 mt-3" style="border: 1px dotted #000;">
		<?php if($visitor_type =="exhibitor"){ ?> 

			<p style="font-weight: bold; text-decoration: underline;">  Tree Plantation appeal to the IIJS family</p>
			<p style="font-weight: bold; ">  The Global Phenomenon</p>
			<p>In 2021 Global CO2 emissions grew 4.8%, reaching 34.9 billion tonnes of CO2. The increase in carbon emission only added to the climatic change, causing extreme weather conditions like tropical storms, wildfires, severe droughts, and heat waves, negatively affecting crop production and causing disruption to the natural habitats. The time has come to do our bit to reduce carbon footprints to make the world a better inhabitable place. </p>
			<p style="font-weight:bold"> GJEPC's Role in Preserving Mother Earth</p>
			<p>GJEPC is committed to contributing to Mother Earth while creating a conducive ecosystem for our valued gem and jewellery members. We are introducing the <b>“ONE EARTH”</b> initiative to treasure Planet Earth, in association with <b>SankalpTaru Foundation</b>. As a part of our initiative, we aim to preserve nature, plant more trees and generate income for our nation's farmers.</p>
			<p style="font-weight:bold;">Appeal to all IIJS SIGNATURE 2023; EXHIBITORS</p>
			<p>GJEPC is donating 2 trees per stall as a part of shared responsibility in contributing towards the<b> ONE EARTH</b> initiative. At just <b>Rs. 155/-per tree</b> , you can contribute to planting more and more trees, and the proceeds would go to <b>SankalpTaru Foundation</b>. They will, in turn, utilize the fund to generate income for a <b>farmer</b>, enabling him to earn approximately <b>Rs. 10,000/-</b> in <b>20 years</b>. The tree plantation drive will be instrumental in securing the future of our country's millions of farmers.  </p>
			<p>Therefore, let us come together to play our part in this noble project. We urge you to contribute at least <b>1%</b> of <b>the booth cost or more</b>, towards the cause and support the initiative to take shape</p>
			<p>All contributors are eligible to receive an <b>80G certificate</b></p>
			<p>Join us in this initiative to collectively engage in nurturing <b>ONE EARTH.</b> </p>
		<?php }else if($visitor_type =="visitor" || $visitor_type =="international" ){ ?>

			<p style="font-weight: bold; text-decoration: underline;">  Tree Plantation appeal to the IIJS family</p>
			<p style="font-weight: bold; ">  The Global Phenomenon</p>
			<p>In 2021 Global CO2 emissions grew 4.8%, reaching 34.9 billion tonnes of CO2. The increase in carbon emission only added to the climatic change, causing extreme weather conditions like tropical storms, wildfires, severe droughts, and heat waves, negatively affecting crop production and causing disruption to the natural habitats. The time has come to do our bit to reduce carbon footprints to make the world a better inhabitable place. </p>
			<p style="font-weight:bold"> GJEPC's Role in Preserving Mother Earth</p>
			<p>GJEPC is committed to contributing to Mother Earth while creating a conducive ecosystem for our valued gem and jewellery members. We are introducing the <b>“ONE EARTH”</b> initiative to treasure Planet Earth, in association with <b>SankalpTaru Foundation</b>. As a part of our initiative, we aim to preserve nature, plant more trees and generate income for our nation's farmers.</p>
			<p style="font-weight:bold;">Appeal to Visitors @ IIJS Signature 2023</p>
			<p>GJEPC is donating 2 trees per stall as a part of shared responsibility in contributing towards the<b> ONE EARTH</b> initiative. At just <b>Rs. 155/-per tree</b> , you can contribute to planting more and more trees, and the proceeds would go to <b>SankalpTaru Foundation</b>. They will, in turn, utilize the fund to generate income for a <b>farmer</b>, enabling him to earn approximately <b>Rs. 10,000/-</b> in <b>20 years</b>. The tree plantation drive will be instrumental in securing the future of our country's millions of farmers.  </p>

			<p><u>National Visitors</u>, we urge you to contribute a minimum of <b>5 trees</b> to support the initiative to take shape. </p>
			<p><u>International Visitors</u>, we urge you to contribute a minimum of <b>10 trees</b> to support the initiative to take shape.  </p>

			<p>All contributors are eligible to receive an <b>80G certificate</b></p>
			<p>Join us in this initiative to collectively engage in nurturing <b>ONE EARTH.</b> </p>

		<?php } ?>


		
<a class="" style="color: blue; cursor: pointer; font-size: 15px;" data-toggle="modal" data-target="#exampleModal133" > <input type="checkbox" name="agree_plantation" /> I agree to plant a tree .  <span class="blink">Click Here.</span></a>
</div>

</div>

       
<div class="modal fade" id="exampleModal133" tabindex="-1" role="dialog" aria-labelledby="exampleModal133Label" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center" id="exampleModal133Label">Thank You for your support and acknowledgment. To ensure more tree plantations, we urge you to contribute the maximum! Please fill up the form below to complete your donation process.</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<form class="form" id='plant_registration' <?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?> method="POST">
				 <input type="hidden" name="action" value="plant_registration">
				 <input type="hidden" name="exhibitor_area" value="<?php echo $signature_exh_area ;?>">
				 <input type="hidden" name="visitor_type" value="<?php echo $visitor_type ;?>">
				 <input type="hidden" name="registration_id" value="<?php echo $registration_id ;?>">
				 <input type="hidden" name="visitor_id" value="<?php echo $visitor_id ;?>">
				 <div class="row">
				 	<div class="col-md-6">
				 		<div class="form-group mb-0">
      				<label>Suggested Plants:</label>
		      		<input type="number" class="form-control" name="tree_qty" id="tree_qty"  value="<?php echo  $no_of_trees ; ?>" >
		        	<label for="tree_qty" class=""></label>
      			</div>
				 	</div>
				 	<div class="col-md-6">
				 		<div class="form-group mb-0">
      				<label>Price Per Plant:</label>
		        	<input type="text" class="form-control" name="plant_rate" id="plant_rate" value="<?php echo $plant_rate; ?>" readonly  >
		        	<label for="plant_rate" class=""></label>
      			</div>
				 	</div>
				 	<div class="col-md-6">
				 		<div class="form-group mb-0">
      				<label>Total Price:</label>
		        	<input type="text" class="form-control" name="tree_amount" id="tree_amount" value="<?php echo $tree_amount; ?>" readonly >
		        	<label for="tree_amount" class=""></label>
      			</div>
				 	</div>
				 	<div class="col-md-6">
				 		<div class="form-group mb-0">
      				<label>Name on Tree:</label>
		      		<input type="text" class="form-control" name="tree_name" id="tree_name" value="<?php echo $tree_name; ?>">
		        	<label for="tree_name" class=""></label>
      			</div>
				 	</div>
				 	<!-- <div class="col-md-6">
				 		<div class="form-group mb-0">
      				<label>First Name:</label>
		      		<input type="text" class="form-control" name="fname" id="fname" value="<?php echo $fname; ?>">
		        	<label for="fname" class=""></label>
      			</div>
				 	</div>
				 	<div class="col-md-6">
				 		<div class="form-group mb-0">
      				<label>Last Name:</label>
		      		<input type="text" class="form-control" name="lname" id="lname" value="<?php echo $lname; ?>" />
		        	<label for="lname" class=""></label>
      			</div>
				 	</div> -->
				 		<div class="col-md-6">
				 		<div class="form-group mb-0">
      				<label>Billing First Name:</label>
		      		<input type="text" class="form-control" name="billing_first_name" id="billing_first_name" value="<?php echo $billing_first_name; ?>">
		        	<label for="billing_first_name" class=""></label>
      			</div>
				 	</div>
				 	<div class="col-md-6">
				 		<div class="form-group mb-0">
      				<label>Billing Last Name:</label>
		      		<input type="text" class="form-control" name="billing_last_name" id="billing_last_name" value="<?php echo $billing_last_name; ?>"/>
		        	<label for="billing_last_name" class=""></label>
      			</div>
				 	</div>
				 	<div class="col-md-6">
				 		<div class="form-group mb-0">
      				<label>Mobile:</label>
		      		<input type="number" class="form-control" name="mobile" id="mobile" value="<?php echo $mobile; ?>" />
		        	<label for="mobile" class=""></label>
      			</div>
				 	</div>
				 	<div class="col-md-6">
				 		<div class="form-group mb-0">
      				<label>Email:</label>
		      		<input type="text" class="form-control" name="email" id="email" value="<?php echo $email; ?>" />
		        	<label for="email" class=""></label>
      			</div>
				 	</div>
				 
				 	<div class="col-md-6"><div class="form-group mb-0">
      				<label>Billing Address 1:</label>
		      		<input type="text" class="form-control" name="billing_address_1" id="billing_address_1" value="<?php echo $billing_address_1; ?>"/>
		        	<label for="billing_address_1" class=""></label>
      			</div></div>
				 	<div class="col-md-6">
				 		<div class="form-group mb-0">
      				<label>Billing State:</label>
      				<?php if($visitor_type =="international"){ ?>
								<input type="text" class="form-control" name="billing_state" id="billing_state" value="<?php echo $billing_state; ?>"/>
      				<?php }else{ ?>
							<select name="billing_state" id="billing_state" class="form-control">
                            <option value="">--- Select State ---</option>
                            <?php 
							$sql="SELECT * from state_master WHERE country_code = 'IN'";
							$stmt = $conn -> prepare($sql);
							$stmt -> execute();			
							$query = $stmt->get_result();
							while($result = $query->fetch_assoc()) { ?>
							<option value="<?php echo $result['state_code'];?>"  <?php if($result['state_code'] == $billing_state ){ echo "selected"; }?>><?php echo $result['state_name'];?></option>
							<?php } ?>
              </select>
      			  <?php	}?>
					


		        	<label for="billing_state" class=""></label>
      			</div></div>
				 	<div class="col-md-6">
				 		<div class="form-group mb-0">
      				<label>Billing City:</label>
		      		<input type="text" class="form-control" name="billing_city" id="billing_city" value="<?php echo $billing_city; ?>"/>
		        	<label for="billing_city" class=""></label>
      			</div>
				 	</div>
				 	<div class="col-md-6"><div class="form-group mb-0">
      				<label>Billing Pincode:</label>
		      		<input type="text" class="form-control" name="billing_postcode" id="billing_postcode" maxlength="6" minlength="6" autocomplete="off" value="<?php echo $billing_postcode; ?>"/>
		        	<label for="billing_postcode" class=""></label>
      			</div> 
      		</div>
				 	<div class="col-md-6 <?php if($visitor_type =="international"){ echo "d-none"; }?>"><div class="form-group mb-0">
      				<label>Billing PAN Card No:</label>
		      		<input type="text" class="form-control" name="billing_pan_card_no" id="billing_pan_card_no" maxlength="10" autocomplete="off" value="<?php echo $billing_pan_card_no; ?>" />
		        	<label for="billing_pan_card_no" class=""></label>
      			</div></div>
				 	<div class="col-md-6 <?php if($visitor_type =="international"){ echo "d-none"; }?>">
				 		<div class="form-group mb-0">
      				<label>Billing Aadhar Card No:</label>
		      		<input type="text" class="form-control" name="billing_aadhar_card_no" id="billing_aadhar_card_no" value="<?php echo $billing_aadhar_card_no; ?>"/>
		        	<label for="billing_aadhar_card_no" class="" ></label>
      			</div>
				 	</div>
				 	<div class="col-md-6">
				 		<div class="form-group mb-0">
      				<input type="submit" class=" btn cta fade_anim" name="Pay Now" value="Pay Now" >
      			</div>
				 	</div>
				 

				 </div>
				
    <!--<div class="modal-footer d-flex justify-content-start"></div> -->
				
      	</form>
      </div>
      
    </div>
  </div>
</div>

<script type="text/javascript">
$(document).ready(function(){
	jQuery.validator.addMethod("panno", function (value, element) {
	var regExp = /[a-zA-z]{5}\d{4}[a-zA-Z]{1}/; 
	if (value.match(regExp) ) {
		return true;
	} else {
		return false;
	};
	},"Please Enter valid PAN No");
  <?php if($visitor_type =="international" ){ ?>
$("#plant_registration").validate({
	rules: {
			tree_qty:{
			required:true
			},
			plant_rate:{
			required:true
			},
			tree_amount:{
			required:true
		    },  
			tree_name:{
			required:true
			},
			fname:{
			required:true
			},
			lname:{
			required:true
			},
			mobile:{
			required:true,
		
			},
			email:{
			required:true,
			email:true
			},
			billing_first_name:{
			required:true
			},
			billing_last_name:{
			required:true
			},
			billing_address_1:{
			required:true
			},
			billing_state:{
			required:true
			},
			billing_city:{
			required:true
			},
			billing_postcode:{
			required:true,
			minlength: 6,
      maxlength: 6,
			}
	},
	messages: {
			tree_qty:{
			required: "Enter No of Trees"
			},
			plant_rate:{
			required: "Plant Rate is required"
			},
			tree_amount:{
			required: "Tree amount is required"
			},
			tree_name:{
			required: "Enter Name of Tree"
			},
			fname:{
			required: "First name is required"
			},
			lname:{
			required: "Last name is required"
			},
			mobile:{
			required: "Enter Mobile Number",
		
			},
			email:{
			required: "E-mail ID is required"
			},
			billing_first_name:{
			required: "Billing first name required"
			},
			billing_last_name:{
			required: "Billing last name is required"
			},
			billing_address_1:{
			required: "Billing address is required"
			},
			billing_state:{
			required: "Billing state is required"
			},
			billing_city:{
			required: "Billing city is required"
			},
			billing_postcode:{
			required: "Billing Postcode  required",
			minlength:"Please enter at least {6} digit.",
			maxlength:"Please enter no more than {6} digit."
			}
		}
			// submitHandler: plantAction
	});
  <?php }else{ ?>
  	$("#plant_registration").validate({
	rules: {
			tree_qty:{
			required:true
			},
			plant_rate:{
			required:true
			},
			tree_amount:{
			required:true
		    },  
			tree_name:{
			required:true
			},
			fname:{
			required:true
			},
			lname:{
			required:true
			},
			mobile:{
			required:true,
			minlength: 10,
      maxlength: 10,
			},
			email:{
			required:true,
			email:true
			},
			billing_first_name:{
			required:true
			},
			billing_last_name:{
			required:true
			},
			billing_address_1:{
			required:true
			},
			billing_state:{
			required:true
			},
			billing_city:{
			required:true
			},
			billing_postcode:{
			required:true,
			minlength: 6,
      maxlength: 6,
			},
			billing_pan_card_no:{
			required:true,
			panno: true,
			},
			billing_aadhar_card_no:{
			// required:true,
			minlength: 12,
      maxlength: 12,

			}
	},
	messages: {
			tree_qty:{
			required: "Enter No of Trees"
			},
			plant_rate:{
			required: "Plant Rate is required"
			},
			tree_amount:{
			required: "Tree amount is required"
			},
			tree_name:{
			required: "Enter Name of Tree"
			},
			fname:{
			required: "First name is required"
			},
			lname:{
			required: "Last name is required"
			},
			mobile:{
			required: "Enter mobile number",
			minlength:"Please enter at least {10} digit.",
			maxlength:"Please enter no more than {10} digit."
			},
			email:{
			required: "E-mail ID is required"
			},
			billing_first_name:{
			required: "Billing first name required"
			},
			billing_last_name:{
			required: "Billing last name is required"
			},
			billing_address_1:{
			required: "Billing address required"
			},
			billing_state:{
			required: "Billing state is required"
			},
			billing_city:{
			required: "Billing city  is required"
			},
			billing_postcode:{
			required: "Billing postcode required",
			minlength:"Please enter at least {6} digit.",
			maxlength:"Please enter no more than {6} digit."
			},
			billing_pan_card_no:{
			required: "Billing pan card number required",
			minlength:"Please enter at least {10} digit.",
			maxlength:"Please enter no more than {10} digit."
			},
			billing_aadhar_card_no:{
			required: "Billing adhaar card is  required",
			minlength:"Please enter not less than 12 characters",
			maxlength:"Please enter not more than 12 characters"
			}	
		}
			// submitHandler: plantAction
	});


  <?php } ?>
	

	$(document).on("change","#tree_qty", function(e){
		e.preventDefault();
		let tree_qty = $(this).val();
		let plant_rate = $("#plant_rate").val();
		let tree_amount = tree_qty * plant_rate;
		$("#tree_amount").val(tree_amount);

	});

});
			

</script>
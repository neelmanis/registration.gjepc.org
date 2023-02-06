<?php 
include ("db.inc.php");
include ("functions.php");
?>
<?php 
if(isset($_POST['actiontype']) && $_POST['actiontype']=="editAdd"){
$id = filter($_POST['id']);
$exhibitor_code = filter($_POST['exhibitor_code']);

$catalog_data="select * from iijs_personalInfo where Exhibitor_Code='$exhibitor_code' and id='$id'";
$result_catalog= $conn ->query($catalog_data);
$fetch_catalog = $result_catalog->fetch_assoc();

$name_of_retail_showroom=$fetch_catalog['name_of_retail_showroom'];
$company_gst=$fetch_catalog['company_gst'];

$contact_person=$fetch_catalog['contact_person'];
$mobile=$fetch_catalog['mobile'];
$designation=$fetch_catalog['designation'];
$email=$fetch_catalog['email'];
$showroom_city=$fetch_catalog['showroom_city'];
$showroom_address=$fetch_catalog['showroom_address'];
$showroom_area=$fetch_catalog['showroom_area'];
$year_of_establishment=$fetch_catalog['year_of_establishment'];
if($contact_person!="")
	{
		$contact_person=explode(",",$contact_person);
		$brand_name1=$contact_person[0];
		$brand_name2=$contact_person[1];
		$brand_name3=$contact_person[2];
		$brand_name4=$contact_person[3];
		$brand_name5=$contact_person[4];
	} else	{
		$brand_name1="";		$brand_name2="";		$brand_name3="";		$brand_name4="";		$brand_name5="";
	}

	if($mobile!="")
	{
		$mobile=explode(",",$mobile);
		$mobile1=$mobile[0];
		$mobile2=$mobile[1];
		$mobile3=$mobile[2];
		$mobile4=$mobile[3];
		$mobile5=$mobile[4];
	} else	{
		$mobile1="";		$mobile2="";		$mobile3="";		$mobile4="";		$mobile5="";
	}
	if($designation!="")
	{
		$designation=explode(",",$designation);
		$designation1=$designation[0];
		$designation2=$designation[1];
		$designation3=$designation[2];
		$designation4=$designation[3];
		$designation5=$designation[4];
	} else	{
		$designation1="";		$designation2="";		$designation3="";		$designation4="";		$designation5="";
	}
	if($email!="")
	{
		$email=explode(",",$email);
		$email1=$email[0];
		$email2=$email[1];
		$email3=$email[2];
		$email4=$email[3];
		$email5=$email[4];
	} else	{
		$email1="";		$email2="";		$email3="";		$email4="";		$email5="";
	}
	if($showroom_city!="")
	{
		$city=explode(",",$showroom_city);
		$city1=$city[0];
		$city2=$city[1];
		$city3=$city[2];
		$city4=$city[3];
		$city5=$city[4];
	} else	{
		$city1="";		$city2="";		$city3="";		$city4="";		$city5="";
	}
	
	if($showroom_address!="")
	{
		$address=explode(",",$showroom_address);
		$address1=$address[0];
		$address2=$address[1];
		$address3=$address[2];
		$address4=$address[3];
		$address5=$address[4];
	} else	{
		$address1="";		$address2="";		$address3="";		$address4="";		$address5="";
	}
	
	if($showroom_area!="")
	{
		$area=explode(",",$showroom_area);
		$area1=$area[0];
		$area2=$area[1];
		$area3=$area[2];
		$area4=$area[3];
		$area5=$area[4];
	} else	{
		$area1="";		$area2="";		$area3="";		$area4="";		$area5="";
	}
	
	if($year_of_establishment!="")
	{
		$year=explode(",",$year_of_establishment);
		$year1=$year[0];
		$year2=$year[1];
		$year3=$year[2];
		$year4=$year[3];
		$year5=$year[4];
	} else	{
		$year1="";		$year2="";		$year3="";		$year4="";		$year5="";
	}
?>
<table border="0" cellspacing="0" cellpadding="0" class="formManual">
  <tr>
    <td>Name of Retail Showroom <span class="red">*</span> </td>
    <td>:</td>
    <td><input type="text" class="textField" name="name_of_retail_showroom" id="name_of_retail_showroom" value="<?php echo $name_of_retail_showroom?>" autocomplete="off"/> <?php if(isset($showroomError)){ echo '<span style="color: red;" />'.$showroomError.'</span>';} ?></td>
  </tr>
  <tr>
    <td>Company GST No <span class="red">*</span> </td>
    <td>:</td>
    <td><input type="text" class="textField" name="company_gst" id="company_gst" maxlength="15" minlength="15" value="<?php echo $company_gst?>" autocomplete="off"/> <?php if(isset($gstNameError) ){ echo '<span style="color: red;" />'.$gstNameError.'</span>';} ?></td>
  </tr>
</table>

<table border="0" cellspacing="0" cellpadding="0" class="formManual">
  <tr>
    <td>Contact Person 1</td>
    <td>:</td>
    <td><input type="text" name="contact_person[]"  class="textField" value="<?php echo $brand_name1;?>"/>
	<?php if(isset($personError) ){ echo '<span style="color: red;" />'.$personError.'</span>';} ?></td>
    <td>Mobile No. 1</td>
    <td>:</td>
    <td><input type="text" name="mobile_no[]"  class="textField" value="<?php echo $mobile1; ?>" maxlength="10" minlength="10"/>
	<?php if(isset($mobileError) ){ echo '<span style="color: red;" />'.$mobileError.'</span>';} ?></td>
	<td>Designation 1</td>
    <td>:</td>
    <td><input type="text" name="designation[]"  class="textField" value="<?php echo $designation1; ?>"/>
	<?php if(isset($designationError) ){ echo '<span style="color: red;" />'.$designationError.'</span>';} ?></td>
	<td>Email 1</td>
    <td>:</td>
    <td><input type="email" name="email[]"  class="textField" value="<?php echo $email1; ?>"/>
	<?php if(isset($emailError) ){ echo '<span style="color: red;" />'.$emailError.'</span>';} ?></td>
  </tr>
  <tr>
    <td width="146">Contact Person 2</td>
    <td width="36">:</td>
    <td width="253"><input type="text" name="contact_person[]"  class="textField" value="<?php echo $brand_name2;?>" autocomplete="off"/></td>
    <td width="163">Mobile No. 2</td>
    <td width="30">:</td>
    <td width="262"><input type="text" name="mobile_no[]"  class="textField" value="<?php echo $mobile2; ?>" maxlength="10" minlength="10"/></td>
	<td width="163">Designation 2</td>
    <td width="30">:</td>
    <td width="262"><input type="text" name="designation[]" class="textField" value="<?php echo $designation2; ?>"/></td>
	<td width="163">Email 2</td>
    <td width="30">:</td>
    <td width="262"><input type="email" name="email[]" class="textField" value="<?php echo $email2;?>"/></td>
  </tr>
  <tr>
    <td width="146">Contact Person 3</td>
    <td width="36">:</td>
    <td width="253"><input type="text" name="contact_person[]"  class="textField" value="<?php echo $brand_name3;?>"/></td>
    <td width="163">Mobile No. 3</td>
    <td width="30">:</td>
    <td width="262"><input type="text" name="mobile_no[]"  class="textField" value="<?php echo $mobile3; ?>"/></td>
	<td width="163">Designation 3</td>
    <td width="30">:</td>
    <td width="262"><input type="text" name="designation[]"  class="textField" value="<?php echo $designation3; ?>"/></td>
	<td width="163">Email 3</td>
    <td width="30">:</td>
    <td width="262"><input type="text" name="email[]"  class="textField" value="<?php echo $email3; ?>"/></td>
  </tr>
  <tr>
    <td width="146">Contact Person 4</td>
    <td width="36">:</td>
    <td width="253"><input type="text" name="contact_person[]" class="textField" value="<?php echo $brand_name4;?>"/></td>
    <td width="163">Mobile No. 4</td>
    <td width="30">:</td>
    <td width="262"><input type="text" name="mobile_no[]"  class="textField" value="<?php echo $mobile4; ?>"/></td>
	<td width="163">Designation 4</td>
    <td width="30">:</td>
    <td width="262"><input type="text" name="designation[]"  class="textField" value="<?php echo $designation4; ?>"/></td>
	<td width="163">Email 4</td>
    <td width="30">:</td>
    <td width="262"><input type="text" name="email[]"  class="textField" value="<?php echo $email4; ?>"/></td>
  </tr>
  <tr>
    <td width="146">Contact Person 5</td>
    <td width="36">:</td>
    <td width="253"><input type="text" name="contact_person[]"  class="textField" value="<?php echo $brand_name5;?>"/></td>
    <td width="163">Mobile No. 5</td>
    <td width="30">:</td>
    <td width="262"><input type="text" name="mobile_no[]"  class="textField" value="<?php echo $mobile5; ?>"/></td>
	<td width="163">Designation 5</td>
    <td width="30">:</td>
    <td width="262"><input type="text" name="designation[]"  class="textField" value="<?php echo $designation5; ?>"/></td>
	<td width="163">Email 5</td>
    <td width="30">:</td>
    <td width="262"><input type="text" name="email[]"  class="textField" value="<?php echo $email5; ?>"/></td>
  </tr>
  
</table>
<table class="rwd-table">  					
                    <tbody><tr>
    					<th width="50">Sr No.</th>
    					<th class="smallTh">Showroom branch in which city</th>
    					<th>Showroom Address</th>
    					<th class="smallTh">Area of Showroom in (Sqft)</th>
                        <th class="smallTh">Year of Establishment </th>
					</tr>  					
                    <tr>
    					<td data-th="Sr No.">1</td>
    					<td data-th="Showroom branch in which city"><input type="text" name="showroom_city[]" value="<?php echo $city1;?>"></td>
    					<td data-th="Showroom Address"><input type="text" name="showroom_address[]" value="<?php echo $address1;?>"></td>
    					<td data-th="Area of Showroom in (Sqft)"><input type="text" name="showroom_area[]" value="<?php echo $area1;?>"></td>
                        <td data-th="Year of Establishment"><input type="text" name="year_of_establishment[]" maxlength="4" minlength="4" value="<?php echo $year1;?>"></td>
  					</tr>                    
                    <tr>
    					<td data-th="Sr No.">2</td>
    					<td data-th="Showroom branch in which city"><input type="text" name="showroom_city[]" value="<?php echo $city2;?>"></td>
    					<td data-th="Showroom Address"><input type="text" name="showroom_address[]" value="<?php echo $address2;?>"></td>
    					<td data-th="Area of Showroom in (Sqft)"><input type="text" name="showroom_area[]" value="<?php echo $area2;?>"></td>
                        <td data-th="Year of Establishment"><input type="text" name="year_of_establishment[]" maxlength="4" minlength="4" value="<?php echo $year2;?>"></td>
  					</tr>                    
                    <tr>
    					<td data-th="Sr No.">3</td>
    					<td data-th="Showroom branch in which city"><input type="text" name="showroom_city[]" value="<?php echo $city3;?>"></td>
    					<td data-th="Showroom Address"><input type="text" name="showroom_address[]" value="<?php echo $address3;?>"></td>
    					<td data-th="Area of Showroom in (Sqft)"><input type="text" name="showroom_area[]" value="<?php echo $area3;?>"></td>
                        <td data-th="Year of Establishment"><input type="text" name="year_of_establishment[]" maxlength="4" minlength="4" value="<?php echo $year3;?>"></td>
  					</tr>
                    <tr>
    					<td data-th="Sr No.">4</td>
    					<td data-th="Showroom branch in which city"><input type="text" name="showroom_city[]" value="<?php echo $city4;?>"></td>
    					<td data-th="Showroom Address"><input type="text" name="showroom_address[]" value="<?php echo $address4;?>"></td>
    					<td data-th="Area of Showroom in (Sqft)"><input type="text" name="showroom_area[]" value="<?php echo $area4;?>"></td>
                        <td data-th="Year of Establishment"><input type="text" name="year_of_establishment[]" maxlength="4" minlength="4" value="<?php echo $year4;?>"></td>
  					</tr>
                    <tr>
    					<td data-th="Sr No.">5</td>
    					<td data-th="Showroom branch in which city"><input type="text" name="showroom_city[]" value="<?php echo $city5;?>"></td>
    					<td data-th="Showroom Address"><input type="text" name="showroom_address[]" value="<?php echo $address5;?>"></td>
    					<td data-th="Area of Showroom in (Sqft)"><input type="text" name="showroom_area[]" value="<?php echo $area5;?>"></td>
                        <td data-th="Year of Establishment"><input type="text" name="year_of_establishment[]" maxlength="4" minlength="4" value="<?php echo $year5;?>"></td>
  					</tr>
					</tbody>
</table>
<?php }?>
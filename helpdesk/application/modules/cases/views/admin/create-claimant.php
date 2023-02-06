<?php $this->load->view('includes/admin/cases/case-step-timeline'); ?>



<div class="boxType1 tabType5">

    <form class="tabFormUI" id="submit-claimant-details" autocomplete="off">
        <div class="row w-100">
            <div class="col-md-12 form-group mt-2 m25">
                <label class="paraType5 mb-2">Claimant Details</label>
                <div class="tbb mb-3"></div>
            </div>
            <div class="col-md-6 form-group">
                <label>Email</label>
                <input type="text" class="form-control" name="claimant_email" value="<?php echo $claimant_email; ?>" placeholder="Email" id="claimant_email">
                <label class="error" for="claimant_email"></label>
            </div>
            <div class="col-md-6 form-group">
                <label> Name</label>
                <input type="text" class="form-control" name="claimant_name" id="claimant_name" value="<?php echo $claimant_name; ?>" placeholder=" Name" >
                <label class="error" for="claimant_name"></label>
            </div>

            <div class="col-md-6 form-group">
                <label>Phone Number</label>
                <input type="text" class="form-control numeric" name="claimant_phone" id="claimant_phone" maxlength="10" value="<?php echo $claimant_phone; ?>" placeholder="Phone Number" >
                <label class="error" for="claimant_phone"></label>
            </div>
            <div class="col-md-6 form-group">
                <label>Address (with URL if any)</label>
                <input type="text" class="form-control" name="claimant_address" id="claimant_address" value="<?php echo $claimant_address; ?>" placeholder="Address (with URL if any)" >
                <label class="error" for="claimant_address"></label>
            </div>
            <div class="col-md-12 form-group mt-2 m25">
                <label class="paraType5 mb-2">Authorized Person Details</label>
                <div class="tbb mb-3"></div>
            </div>
            <!-- <div class="col-md-6 form-group d-flex align-items-center">
                <div class="addButton addMore">
                    <a class="pointer removeClaimant"><img src="<?php //echo $global['web_assets']; ?>images/icons/minusicon.png" alt="icon" class="mr-3" />Remove Claimant</a>
                </div>
            </div> -->
            <div class="col-12 field_wrapper">
                <?php echo $authorized_persons;?>
                <!-- <div class="col-md-6 form-group d-flex align-items-center">
                    <div class="addButton addMore">
                        <a class="pointer removeClaimant"><img src="<?php //echo $global['web_assets']; ?>images/icons/minusicon.png" alt="icon" class="mr-3" />Remove Claimant</a>
                    </div>
                 </div> -->
                <div class="row ">
                    
                    <div class="col-md-6 form-group">
                        <label>Select Authorized Person</label>
                        <select class="form-control" name="type[0]" id="type0" >
                            <option value="">Select</option>
                            <option value="representative">Representative</option>
                            <option value="counsel">Counsel</option>
                        </select>
                        <label class="error" for="type[0]"></label>
                    </div>
                    <div class="col-md-6 ">
                        
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Email</label>
                        <input type="text" class="form-control person_email" name="person_email[0]" id="person_email0" data-id="0" placeholder="Email">
                        <label class="error" for="person_email[0]"></label>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Full Name (with Title)</label>
                        <input type="text" class="form-control" name="person_name[0]" id="person_name0"  placeholder="Full Name" >
                        <label class="error" for="person_name[0]"></label>
                    </div>

                    <div class="col-md-6 form-group">
                        <label>Mobile</label>
                        <input type="text" class="form-control numeric" name="person_phone[0]" id="person_phone0" maxlength="10" placeholder="Mobile Number" >
                        <label class="error" for="person_phone[0]"></label>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Address</label>
                        <input type="text" class="form-control" name="person_address[0]" id="person_address0" placeholder="Address" >
                        <label class="error" for="person_address[0]"></label>
                    </div>
                    <div class="col-md-6 form-group d-flex align-items-center">
                        <div class="addButton addMore">
                            <a class="pointer"><img src="<?php echo $global['web_assets']; ?>images/icons/plusicon.png" alt="icon" class="mr-3" />Add More</a>
                        </div>
                    </div>
                    <div class="col-md-12 form-group mb-4 pb-3">
                        <label>Additional info</label>
                        <textarea name="c_additional_info" id="c_additional_info" class="form-control h100" placeholder="Additional Info"><?php echo $c_additional_info != null &&  $c_additional_info != "" ? $c_additional_info : "" ?></textarea>
                        <label class="error" for="c_additional_info"></label>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <?php $_SESSION["token"] = md5(uniqid(mt_rand(), true)); ?>
                <input type="hidden" name="enc_data" id="enc_data" value="<?php echo $enc_data; ?>">
                <input type="hidden" name="csrfToken" id="csrfreg" value="<?php echo $_SESSION["token"]; ?>">
                <div class="text-left">
                <a href="<?php echo base_url();?>cases/list"  class="btnType1 Green1 mr-3  btn  btn-dark" onclick="">Back</a>

                
                <?php if($claimant_email != ""){ ?>
                    <button type="submit" class="btnType1 mr-3 btn btn-success">Save and Continue</button>  
                    <a href="<?php echo base_url("cases/caseStepThree/".$enc_data);?>" class="btnType1 btn btn-info">Next</a>
                <?php }else{?>
                    <button type="submit" class="btnType1 mr-3 btn btn-success">Save and Continue</button>
                <?php }?> 
                </div>
            </div>

        </div>
    </form>
</div>
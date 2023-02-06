<?php $this->load->view('includes/admin/cases/case-step-timeline'); 
?>
<div class="row">
    <div class="col-lg-12 mt-4">
        <div class="card">


            <div class="paraType5 mb-3 card-header">
                Case Details
            </div>
            <div class="tbb mb-3"></div>
            <form class="tabFormUI form-material" id="update-case" autocomplete="off">

                <div class="col-12 mb-2">
                    <span>Note :</span>
                    <small>Recommended types - jpg, jpeg, png, pdf, doc, xls </small>
                </div>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label>Case ID <sup>*</sup></label>
                        <input type="text" name="case_offline_id" id="case_offline_id" placeholder="e.g. ADRAAS0001" value="<?php echo $case_details[0]->offline_id; ?>" class="form-control" />
                        <label for="case_offline_id" class="error"></label>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Date of commencement</label>
                        <input type="text" id="date_of_commencement" name="date_of_commencement" class="form-control"
                            value="<?php  if(!empty($case_details[0]->date_of_commencement) && $case_details[0]->date_of_commencement !==null ){
                                echo date("d-m-Y",strtotime($case_details[0]->date_of_commencement)) ;
                             } ?>"
                           >
                        <label for="date_of_commencement" class="error"></label>
                    </div>
                </div>
                <div class="col-md-12 form-group">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="mb-2"> Whether Case Filing Fee is paid? </label>
                            <div class="row align-items-center">
                                <div class="col-6 form-group">
                                    <div class="radioType1">
                                        <input type="radio" class="payment_method_icon" id="isPaidYes" name="isPaid" value="yes" <?php echo ($case_details[0]->isPaid =="yes") ? "checked" : ''; ?> />
                                        <label for="isPaidYes"><span class="fw500 ml-3">Yes</span></label>
                                    </div>
                                </div>

                                <div class="col-6 form-group">
                                    <div class="radioType1">
                                        <input type="radio" class="payment_method_icon" id="isPaidNo" name="isPaid" value="no" <?php echo ($case_details[0]->isPaid =="no") ? "checked" : ''; ?> />
                                        <label for="isPaidNo"><span class="fw500 ml-3">No</span></label>
                                    </div>
                                </div>
                            </div>
                            <label class="error" for="isPaid"> </label>
                        </div>
                        <div class="col-md-6" id="amount_paid_div">
                            <label>Amount Paid</label>
                            <input type="text" class="form-control numeric " name="amount_paid" id="amount_paid" value="<?php echo $case_details[0]->amount_paid; ?>" placeholder="" />
                            <label for="amount_paid" class="error"></label>
                        </div>
                    </div>

                </div>

                <div class="col-md-12 form-group mb-4 pb-3">
                    <label>Brief Description</label>
                    <textarea name="case_description" id="case_description" class="form-control h100" placeholder="Case description">
                        <?php echo trim($case_details[0]->description); ?>
                    </textarea>
                    <label class="error" for="case_description"></label>
                </div>

                <div class="col-md-12 form-group">
                    <label class="mb-2 paraType5 ">Arbitration Details</label>
                    <div class="tbb mb-3"></div>
                </div>
                <div class="col-md-12 form-group">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Type of Arbitration</label>
                            <select name="arbitration_type" id="arbitration_type" class="form-control">
                                <option value="">Select Arbitration Type</option>
                                <option <?php echo ($case_details[0]->arbitration_type == "Emergency arbitration") ? "selected" : ""; ?> value="Emergency arbitration">Emergency arbitration</option>
                                <option <?php echo ($case_details[0]->arbitration_type == "Expedited arbitration") ? "selected" : ""; ?> value="Expedited arbitration">Expedited arbitration</option>
                                <option <?php echo ($case_details[0]->arbitration_type == "Standard Arbitration") ? "selected" : ""; ?> value="Standard Arbitration">Standard Arbitration</option>
                            </select>
                            <label for="arbitration_type" class="error"></label>
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Number of Arbitrators</label>
                            <select name="arbitration_number" id="arbitration_number" class="form-control">
                                <option value="">Select</option>
                                <option <?php echo ($case_details[0]->arbitration_number == "1") ? "selected" : ""; ?> value="1">1</option>
                                <option <?php echo ($case_details[0]->arbitration_number == "2") ? "selected" : ""; ?> value="2">2</option>
                                <option <?php echo ($case_details[0]->arbitration_number == "3") ? "selected" : ""; ?> value="3">3</option>
                                <option <?php echo ($case_details[0]->arbitration_number == "4") ? "selected" : ""; ?> value="4">4</option>
                                <option <?php echo ($case_details[0]->arbitration_number == "5") ? "selected" : ""; ?> value="5">5</option>
                                <option <?php echo ($case_details[0]->arbitration_number == "6") ? "selected" : ""; ?> value="6">6</option>
                                <option <?php echo ($case_details[0]->arbitration_number == "7") ? "selected" : ""; ?> value="7">7</option>
                                <option <?php echo ($case_details[0]->arbitration_number == "8") ? "selected" : ""; ?> value="8">8</option>
                                <option <?php echo ($case_details[0]->arbitration_number == "9") ? "selected" : ""; ?> value="9">9</option>
                                <option <?php echo ($case_details[0]->arbitration_number == "10") ? "selected" : ""; ?> value="10">10</option>

                            </select>
                            <label for="arbitration_number" class="error"></label>
                        </div>

                    </div>



                </div>
                <div class="col-md-12 form-group">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Seat</label>
                            <input type="text" class="form-control" name="seat" id="seat" value="<?php echo ucfirst($case_details[0]->seat); ?>" placeholder="ex. Mumbai" />
                            <label for="seat" class="error"></label>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Venue</label>
                            <input type="text" class="form-control" name="venue" id="venue" placeholder="" value="<?php echo ucfirst($case_details[0]->venue); ?>" />
                            <label for="venue" class="error"></label>
                        </div>
                    </div>
                </div>

                 <?php if($institution !== "NA") {?>
                    <div class="col-md-12 form-group">
                        <div class="row">
                        <div class="col-md-6 form-group">
                                <label><strong>Selected Institute : </strong></label>
                                <p>
                                     <?php if (isset($institution) &&  $institution  !== "NA") { ?>
                                     <?php echo  $institution[0]->organisation_name; ?>
                                <?php } ?> 
                                </p>
                                                         
                        </div>
                        </div>
                    </div>
                <?php }   ?>
                <?php if($institutions != "NA") {?>
                    <div class="col-md-12 form-group">
                        <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Institute</label>
                            <select class="form-control" name="institution" >
                                <option value="">Select Institute</option>
                                <?php if (isset($institutions) &&  $institutions  !== "NA") { ?>
                                    <?php foreach($institutions as $institute) {?>
                                        <option value="<?php echo $institute->registration_id?>" <?php echo  ($institute->registration_id == $institution[0]->registration_id) ? 'selected' : ''; ?>> <?php echo  $institute->organisation_name; ?></option>
                                    <?php }?>
                                <?php } ?>
                                <!-- <option value="">None</option> -->

                            </select>
                            <label for="institution" class="error"></label>
                        </div>
                        </div>
                    </div>
                <?php } ?>
                
                
                <div class="col-md-12 form-group m25">
                    <label class="mb-2 paraType5">
                        Upload Arbitration Agreement
                    </label>
                    <div class="tbb mb-3"></div>
                </div>


                <div class="col-12 field_wrapper_agreement mb-3">
                    <?php if (isset($documents['agreement']) && !empty($documents['agreement'])) {
					    $counter_agreement = 1;
                        foreach ($documents['agreement'] as $x => $agreement) { 
							if(!empty($agreement) ){?>
	                        <div class="row" id="agreement<?php echo $x; ?>">
	                            <div class="col-md-6 form-group d-flex align-items-center">
								<?php echo $counter_agreement;?> . &nbsp;<a target="_blank" href=<?php echo $global['upload_path'] . "case_uploads/" . $case_registration[0]->serial_no . "/" . $agreement; ?>><?php echo $agreement; ?></a>

	                            </div>
	                            <div class="col-md-6 form-group">
	                                <div class="addButton ">
	                                    <a href='javascript:void(0)' class="pointer trash-file" data-doc = "agreement" data-param="<?php echo $enc_data; ?>" data-file-id='<?php echo $x; ?>'><img src="<?php echo $global['web_assets']; ?>images/icons/x-mark.png" alt="icon" class="mr-3" />Delete</a>
	                                </div>
	                            </div>
	                        </div>
	                    <?php $counter_agreement++ ;}  }
                    } ?>
                </div>



                <div class="col-md-12 form-group m25">
                    <label class="mb-2 paraType5">
                        Upload Contract and Other Documents
                    </label>
                    <div class="tbb mb-3"></div>
                </div>
                <div class="col-12 field_wrapper mb-3">
                    <div class="row">
                        <div class="col-md-6 form-group mb-3">

                            <div class="uploadType1">
                                <input type="file" class="" name="document0" id="document0" />
                                <img src="<?php echo $global['web_assets'] ?>images/icons/upload.png" alt="Icon" class="uploadImg">
                                <span class="paraType3 ml-3">Click to browse a file</span>
                            </div>
                            <label class="error" for="document0"></label>

                        </div>
                        <div class="col-md-6 form-group">
                            <div class="addButton addMore">
                                <a class="pointer"><img src="<?php echo $global['web_assets']; ?>images/icons/plusicon.png" alt="icon" class="mr-3" />Add More</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 form-group">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Select Currency</label>
                            <select id="currency" name="currency" class="form-control">
                                <option>Select currency</option>
                                <?php if(isset($currency) && $currency !=="NA"){
                                foreach ($currency as $curr) {?>
                                    <option <?php echo ($case_details[0]->currency == $curr->currency_code) ? "selected" : ""; ?>  value="<?php echo $curr->currency_code;?>"><?php echo $curr->currency_name;?></option>
                            
                                <?php }
                                }?>
                                
                            </select>

                            <label for="currency" class="error"></label>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Claim value</label>
                            <input type="text" class="form-control numeric " name="claim_value" id="claim_value" value="<?php echo ucfirst($case_details[0]->claim_value); ?>" placeholder="Counter claim value">
                            <label for="claim_value" class="error"></label>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 form-group">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Counter Claim value</label>
                            <input type="text" class="form-control numeric " name="counter_claim_value" id="counter_claim_value" value="<?php echo ucfirst($case_details[0]->counter_claim_value); ?>" placeholder="Counter claim value">
                            <label for="counter_claim_value" class="error"></label>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Total Claim value</label>
                            <input type="text" class="form-control numeric " name="total_claim_value" id="total_claim_value" alue="<?php echo ucfirst($case_details[0]->total_claim_value); ?>" placeholder="Counter claim value">
                            <label for="total_claim_value" class="error"></label>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 form-group mt-3 mb-4 pb-3 textleft1 align-self-center">
                    <div class="row">
                        <!-- <div class="col-md-6 form-group">
                            <?php //if($schedule !=="" && !empty($schedule)){
                            ?>
                            <a target="_blank" href='<?php //echo $global['upload_path'] . "user_uploads/" . $registration_id . '/' . $schedule; ?>' class="btnType1 Green1 bt1  mr-3">View Fee
                                Schedule</a>
                            <?php //} 
                            ?>
                        </div> -->
                        <div class="col-md-6 form-group">
                            <label>Administration fees</label>
                            <input type="text" class="form-control numeric " name="administration_fees" value="<?php echo ucfirst($case_details[0]->administration_fees); ?>" id="administration_fees" placeholder="Administration fees">
                            <label for="administration_fees" class="error"></label>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Arbitrator/Tribunal Fees</label>
                            <input type="text" class="form-control numeric " name="arbitration_fees" id="arbitration_fees" placeholder="Arbitration fees" value="<?php echo ucfirst($case_details[0]->arbitration_fees); ?>">
                            <label for="arbitration_fees" class="error"></label>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 form-group">
                    <div class="row">
                        
                        <div class="col-md-6 form-group">
                            <label>Miscellaneous fees</label>
                            <input type="text" class="form-control numeric " name="miscellaneous_fees" id="miscellaneous_fees" placeholder="Miscellaneous fees" alue="<?php echo ucfirst($case_details[0]->miscellaneous_fees); ?>">
                            <label for="miscellaneous_fees" class="error"></label>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Out of pocket Expenses</label>
                            <input type="text" class="form-control numeric " name="out_of_pocket_expences" id="out_of_pocket_expences" placeholder="Out of pocket Expenses" value="<?php echo ucfirst($case_details[0]->out_of_pocket_expences); ?>">
                            <label for="out_of_pocket_expences" class="error"></label>
                        </div>
                    </div>
                </div>
                

                <div class="col-md-12 form-group">
                    <div class="topSet1 textSet1 mhauto">
                        <input id="readTerms_" class="checkbox-custom" name="readTerms" type="checkbox" value="Y" <?php echo ($case_details[0]->readTerms == "Y") ? "checked" : ""; ?> >
                        <label for="readTerms_" class="checkbox-custom-label"></label>
                        <span>I have read<span class="fw500 italic"><a href="<?php echo $global['web_assets']; ?>pdf/Terms-of-Service-for-Website.pdf?<?php echo  $global['version']; ?>" target="_blank"> Terms of
                                    Service</a></span> and agree to them </span>
                    </div>
                    <label for="readTerms" class="error"></label>
                </div>

                <div class="col-md-12 form-group">
                    <div class="topSet1 textSet1 mhauto">
                        <input id="readPrivacy_" class="checkbox-custom" name="readPrivacy" type="checkbox" value="Y" <?php echo ($case_details[0]->readPrivacy == "Y") ? "checked" : ""; ?> >
                        <label for="readPrivacy_" class="checkbox-custom-label"></label>
                        <span>I have read<span class="fw500 italic"><a href="<?php echo $global['web_assets']; ?>pdf/Privacy-Policy_03-November-2021.pdf?<?php echo  $global['version']; ?>" target="_blank"> Privacy Policy</a></span> and agree to them </span>
                    </div>
                    <label for="readPrivacy" class="error"></label>
                </div>
                <div class="col-12">
                    <input type="hidden" name="countcheck[]" />
					<input type="hidden" name="countcheck_agreement[]" />
                    <input type="hidden" name="enc_data" id="enc_data" value="<?php echo $enc_data;?>">    
                    <input type="hidden" name="csrfToken" id="csrfreg" value="<?php echo $_SESSION["token"];?>"> 
                    <?php $_SESSION["token"] = md5(uniqid(mt_rand(), true)); ?>
                    <input type="hidden" name="csrfToken" id="csrfreg" value="<?php echo $_SESSION["token"]; ?>">
                    <div class="text-left">
                        <a href="<?php echo base_url();?>cases/list" class="btnType1 Green1  mr-3 btn  btn-dark">Back</a>
                        <?php if($institution_case_status =="1"){ ?>
                            <button type="submit" class="btnType1 btn btn-success">Save and Continue</button>
                        <?php }else{?>
                            <button type="submit" class="btnType1 btn btn-success">Save and Continue</button>
                            <a href="<?php echo base_url("cases/caseStepTwo/".$enc_data);?>" class="btnType1 btn btn-info">Next</a>
                        <?php }?>
                    </div>
                </div>
        </div>
        </form>


    </div>
</div>
</div>
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor"><?php echo $breadcrumb;?></h4>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                
                
                <form class="form-material" id="onspot-form">
                					
					<div class="form-group row">
                        <label for="example-search-input" class="col-sm-12 col-form-label"><strong>SELECT CATEGORY</strong></label>
                        <div class="col-sm-12">
                            <select class="form-control" name="category" id="category">                            
                              <option value="">SELECT CATEGORY</option>
							  <?php foreach($designation as $val){ ?>
							  <option value="<?php echo $val->short_name; ?>"><?php echo strtoupper($val->cat_name); ?></option>
							  <?php } ?>
							   </select>
                            <label for="category" generated="true" class="error"></label>
                        </div>                        
                    </div>
					
                    <div class="form-group  row">
                        <label for="example-text-input" class="col-sm-10 col-form-label"><strong>VISITOR NAME</strong></label>
                        <div class="col-sm-12">
                            <input class="form-control" type="text" name="fname" id="fname">
                            <label for="fname" generated="true" class="error"></label>
                        </div>                        
                    </div>
                   
                    <div class="form-group row">
                        <label for="example-search-input" class="col-sm-12 col-form-label"><strong>PHOTO</strong></label>
                        <div class="col-sm-12">
                            <input type="file" class="form-control" name="visitor_photo" id="visitor_photo">
                            <label for="visitor_photo" generated="true" class="error"></label>
                        </div>                        
                    </div>
					
                        <div class="form-group row mobile-div">
                            <label for="example-search-input" class="col-sm-12 col-form-label"><strong>MOBILE</strong></label>
                            <div class="col-sm-12">
                                <input class="form-control" name="mobile" type="text" id="mobile">
                                <label for="mobile" generated="true" class="error"></label>
                            </div>                            
                        </div>
                        <div class="form-group row">
                            <label for="example-search-input" class="col-sm-12 col-form-label"><strong>EMAIL</strong></label>
                            <div class="col-sm-12">
                                <input class="form-control" name="email" type="text" id="email">
                                <label for="email" generated="true" class="error"></label>
							</div>                            
                        </div>
						<div class="form-group row pan-div">
                            <label for="example-search-input" class="col-sm-12 col-form-label"><strong>PAN</strong></label>
                            <div class="col-sm-12">
                                <input class="form-control" name="pan_no" type="text" id="pan_no">
                                <label for="pan_no" generated="true" class="error"></label>
                            </div>                            
                        </div>
                        <div class="form-group row">
                            <label for="example-search-input" class="col-sm-12 col-form-label"><strong>COMPANY</strong></label>
                            <div class="col-sm-12">
                                <input class="form-control" name="company" type="text" id="company">
                                <label for="company" generated="true" class="error"></label>
                            </div>                            
                        </div>
						<div class="form-group row">
                            <label for="example-search-input" class="col-sm-12 col-form-label"><strong>DESIGNATION</strong></label>
                            <div class="col-sm-12">
                                <input class="form-control" name="designation" type="text" id="designation">
                                <label for="designation" generated="true" class="error"></label>
                            </div>                            
                        </div>
						
                        <div class="form-group row country-div">
                            <label for="example-search-input" class="col-sm-12 col-form-label"><strong>SELECT COUNTRY</strong></label>
                            <div class="col-sm-12">
                                <select class="form-control" name="country" id="country">                            
                                <option value="">SELECT COUNTRY</option>
                                <?php foreach($country as $val){ ?>
                                    <option <?php if($val->id =="107"){ echo "selected"; } ?> value="<?php echo $val->id; ?>"><?php echo strtoupper($val->country_name); ?></option>
                                <?php } ?>
                                </select>
                                <label for="country" generated="true" class="error"></label>
                            </div>                        
                        </div>

                        <div class="form-group row " id="state-div-select" >
                            <label for="example-search-input" class="col-sm-12 col-form-label"><strong>SELECT STATE</strong></label>
                            <div class="col-sm-12">
                                <select class="form-control" name="state_select" id="state_select">                            
                                <option value="">SELECT STATE</option>
                                <?php foreach($state as $val){ ?>
                                    <option value="<?php echo $val->state_code; ?>"><?php echo strtoupper($val->state_name); ?></option>
                                <?php } ?>
                                </select>
                                <label for="state" generated="true" class="error"></label>
                            </div>                        
                        </div>
                        <div class="form-group row " id="state-div-input" style="display: none;">
                            <label for="example-search-input" class="col-sm-12 col-form-label"><strong>SELECT STATE</strong></label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" name="state_input" id="state_input" />
                                
                                <label for="state" generated="true" class="error"></label>
                            </div>                        
                        </div>
                        
                        <div class="form-group row">
                            <label for="example-search-input" class="col-sm-12 col-form-label"><strong>CITY</strong></label>
                            <div class="col-sm-12">
                                <input class="form-control" name="city" type="text" id="city">
                                <label for="city" generated="true" class="error"></label>
                            </div>                            
                        </div>

                        <div class="nri_ov_div" id="nri_ov_div" style="display: none;">
                            <div class="form-group row">
                                <label for="example-search-input" class="col-sm-12 col-form-label"><strong>PASSPORT</strong></label>
                                <div class="col-sm-12">
                                    <input type="file" class="form-control" name="pass_port" id="pass_port">
                                    <label for="pass_port" generated="true" class="error"></label>
                                </div>                        
                            </div>
                            <div class="form-group row">
                                <label for="example-search-input" class="col-sm-12 col-form-label"><strong>BUSINESS CARD</strong></label>
                                <div class="col-sm-12">
                                    <input type="file" class="form-control" name="business_card" id="business_card">
                                    <label for="business_card" generated="true" class="error"></label>
                                </div>                        
                            </div>
                            <div class="form-group row">
                                <label for="example-search-input" class="col-sm-2 col-form-label"><strong>NRI CARD</strong></label>
                                <label><input type="radio" name="nri_card_check" id="nri_card_check_yes" value="yes">Yes </label>  
                                <label><input type="radio" name="nri_card_check" id="nri_card_check_no" checked value="no">No</label>
                            </div>    
                            <div class="form-group row " id="nri_card_div" style="display: none;">
                                <label for="example-search-input" class="col-sm-12 col-form-label"><strong>NRI CARD UPLOAD</strong></label>
                                <div class="col-sm-12">
                                    <input type="file" class="form-control" name="nri_card" id="nri_card">
                                    <label for="nri_card" generated="true" class="error"></label>
                                </div>                        
                            </div>
                        </div>
                    <div class="form-group row">
                        <label for="example-email-input" class="col-sm-2 col-form-label"><strong>STATUS</strong></label>
                        <div class="form-group row">
                            
                            <div class="col-sm-10 ">
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="customRadio1" name="status" value="Y" class="custom-control-input status form-control" checked>
                                    <label class="custom-control-label" for="customRadio1">Active</label>
                                    
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="customRadio2" name="status" value="P"  class="custom-control-input form-control">
                                    <label class="custom-control-label status" for="customRadio2">Inactive</label>
                                    
                                </div>
                            </div>
                            <label for="status" generated="true" class="error"></label>
                        </div>
                        
                    </div>
                    <div class="form-group row">
                        
                        <div class="col-10">
                            <input class="btn btn-success" type="submit"  name="submit" value="submit">
                            <button class="btn " type="Reset">Reset</button>
                        </div>
                    </div>
                    
                    
                </form>
            </div>
        </div>
    </div>
</div>
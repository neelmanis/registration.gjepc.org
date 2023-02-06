<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor"><?php echo $breadcrumb;?></h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url();?>admin/dashboard">Home</a></li>
                <li class="breadcrumb-item active">Onspot Visitors</li>
            </ol>
            <!--<button type="button" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Create New</button>-->
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title"><?php echo $breadcrumb;?></h4>
                
                <form class="form-material" id="update_visitor">
					<div class="form-group row">
                        <label for="example-search-input" class="col-sm-12 col-form-label"><strong>SELECT CATEGORY</strong></label>
                        <div class="col-sm-12">
                            <select class="form-control" name="category" id="category">                            
                              <option value="">SELECT CATEGORY</option>
							  <?php foreach($category as $val){  ?>
							    <option value="<?php echo $val->short_name; ?>" <?php if($val->short_name == $onspot_visitor[0]->category){ echo 'selected'; }?>><?php echo strtoupper($val->cat_name); ?></option>
							  <?php } ?>
							 </select>							
					  
                            <label for="category" generated="true" class="error"></label>
                        </div>                        
                    </div>
					<!-- <div class="form-group row">
                        <label for="example-search-input" class="col-2 col-form-label">Select Category</label>
                        <div class="col-10"><?php //echo $onspot_visitor[0]->category;?>
                        </div>                        
                    </div> -->
					
                    <div class="form-group  row">
                        <label for="example-text-input" class="col-sm-12 col-form-label"><strong>VISITOR NAME</strong></label>
                        <div class="col-sm-12">
                            <input class="form-control" type="text" name="fname" id="fname" value="<?php echo $onspot_visitor[0]->name; ?>" >
                            <label for="fname" generated="true" class="error"></label>
                        </div>                        
                    </div>
                   
                    <div class="form-group row">
                        <label for="example-search-input" class="col-sm-12 col-form-label"><strong>PHOTO</strong></label>
                        <div class="col-sm-12">
                            <input type="file" class="form-control" name="visitor_photo" id="visitor_photo">
						<div>
                        <?php
                          $url = '';
                          if($onspot_visitor[0]->photo_name == "NA" || $onspot_visitor[0]->photo_name == ""){
                            $url = 'admin-assets/images/team/default.jpg';
                          }else{
                            $url = 'images/'.$onspot_visitor[0]->photo_name;
                          }
                        ?>
                        <img src="<?php echo base_url().$url; ?>" height="250px" width="250px">  
                        </div>
                            <label for="visitor_photo" generated="true" class="error"></label>
                        </div>                        
                    </div>
					
                        <div class="form-group row">
                            <label for="example-search-input" class="col-sm-12 col-form-label"><strong>MOBILE</strong></label>
                            <div class="col-sm-12">
                                <input class="form-control" name="mobile" type="text" id="mobile" value="<?php echo $onspot_visitor[0]->mobile; ?>" >
                                <label for="mobile" generated="true" class="error"></label>
                            </div>                            
                        </div>
                        <div class="form-group row">
                            <label for="example-search-input" class="col-sm-12 col-form-label"><strong>EMAIL</strong></label>
                            <div class="col-sm-12">
                                <input class="form-control" name="email" type="text"  id="email" value="<?php echo $onspot_visitor[0]->email; ?>" >
                                <label for="email" generated="true" class="error"></label>
							</div>                            
                        </div>
						<div class="form-group row pan-div">
                            <label for="example-search-input" class="col-sm-12 col-form-label"><strong>PAN<strong></label>
                            <div class="col-sm-12">
                                <input class="form-control" name="pan_no" type="text" id="pan_no" value="<?php echo $onspot_visitor[0]->pan_no; ?>" >
                                <label for="pan_no" generated="true" class="error"></label>
                            </div>                            
                        </div>
						<div class="form-group row">
                            <label for="example-search-input" class="col-sm-12 col-form-label"><strong>DESIGNATION</strong></label>
                            <div class="col-sm-12">
                                <input class="form-control" name="designation" type="text" id="designation" value="<?php echo $onspot_visitor[0]->designation; ?>" >
                                <label for="designation" generated="true" class="error"></label>
                            </div>                            
                        </div>

                        <div class="form-group row country-div">
                            <label for="example-search-input" class="col-sm-12 col-form-label"><strong>SELECT COUNTRY</strong></label>
                            <div class="col-sm-12">
                                <select class="form-control" name="country" id="country">                            
                                <option value="">SELECT COUNTRY</option>
                                <?php foreach($country as $val){ ?>
                                    <option value="<?php echo  $val->id; ?>" <?php if($val->country_name == $onspot_visitor[0]->country){echo 'selected';}  ?>><?php echo strtoupper($val->country_name);  ?></option>
                                <?php } ?>
                                </select>
                                <label for="country" generated="true" class="error"></label>
                            </div>                        
                        </div>

                        <div class="form-group row state-div" style="<?php echo $onspot_visitor[0]->country_code == '107' ? '' : 'display: none;'; ?>">
                            <label for="example-search-input" class="col-sm-12 col-form-label"><strong>SELECT STATE</strong></label>
                            <div class="col-sm-12">
                                <select class="form-control" name="state" id="state">                            
                                <option value="">SELECT STATE</option>
                                <?php foreach($state as $val){ ?>
                                    <option value="<?php echo $val->state_code; ?>" <?php if($val->state_code == $onspot_visitor[0]->state_code){echo 'selected';}  ?>><?php echo strtoupper($val->state_name); ?></option>
                                <?php } ?>
                                </select>
                                <label for="state" generated="true" class="error"></label>
                            </div>                        
                        </div>
                        
                        <div class="form-group row">
                            <label for="example-search-input" class="col-sm-12 col-form-label"><strong>CITY</strong></label>
                            <div class="col-sm-12">
                                <input class="form-control" name="city" type="text" id="city" value="<?php echo $onspot_visitor[0]->city; ?>">
                                <label for="city" generated="true" class="error"></label>
                            </div>                            
                        </div>

						<div class="form-group row">
                            <label for="example-search-input" class="col-sm-12 col-form-label"><strong>COMPANY</strong></label>
                            <div class="col-sm-12">
                                <input class="form-control" name="company" type="text" id="company" value="<?php echo $onspot_visitor[0]->company; ?>" >
                                <label for="company" generated="true" class="error"></label>
                            </div>                            
                        </div>

                        <?php if( $onspot_visitor[0]->category == "OV") {?>
                            <div class="nri_ov_div" >
                                <div class="form-group row">
                                    <label for="example-search-input" class="col-sm-12 col-form-label"><strong>PASSPORT</strong></label>
                                    <div class="col-sm-12">
                                        <input type="file" class="form-control" name="pass_port" id="pass_port">
                                        <div>
                                        <?php
                                            $url = '';
                                            if($onspot_visitor[0]->pass_port_name == "NA" || $onspot_visitor[0]->pass_port_name == ""){
                                                $url = 'admin-assets/images/team/default.jpg';
                                            }else{
                                                $url = 'images/'.$onspot_visitor[0]->pass_port_name;
                                            }
                                            ?>
                                        <img src="<?php echo base_url().$url; ?>" height="250px" width="250px">  
                                        </div>
                                        <label for="pass_port" generated="true" class="error"></label>
                                    </div>  
                                </div>
                                <div class="form-group row">
                                    <label for="example-search-input" class="col-sm-12 col-form-label"><strong>BUSINESS CARD</strong></label>
                                    <div class="col-sm-12">
                                        <input type="file" class="form-control" name="business_card" id="business_card">
                                        <div>
                                        <?php
                                            $url = '';
                                            if($onspot_visitor[0]->business_card_name == "NA" || $onspot_visitor[0]->business_card_name == ""){
                                                $url = 'admin-assets/images/team/default.jpg';
                                            }else{
                                                $url = 'images/'.$onspot_visitor[0]->business_card_name;
                                            }
                                            ?>
                                        <img src="<?php echo base_url().$url; ?>" height="250px" width="250px">  
                                        </div>
                                        <label for="business_card" generated="true" class="error"></label>
                                    </div>
                                </div>
                                        <?php //echo "<pre>";print_r($onspot_visitor);exit;?>
                                <div class="form-group row">
                                    <label for="example-search-input" class="col-sm-2 col-form-label"><strong>NRI CARD</strong></label>
                                    <input type="checkbox" name="nri_card_check" id="nri_card_check" value="" <?php echo $onspot_visitor[0]->nri_card_check == "true" ? "checked" : ""; ?>>  
                                </div> 
                                  
                                <div class="form-group row nri_div" <?php echo $onspot_visitor[0]->nri_card_check == "true" ? '' : 'style="display: none;"'; ?>>
                                    <label for="example-search-input" class="col-2 col-form-label">Nri Card Upload</label>
                                    <div class="col-sm-12">
                                        <input type="file" class="form-control" name="nri_card" id="nri_card">
                                        <div>
                                        <?php
                                            $url = '';
                                            if($onspot_visitor[0]->nri_card_name == "NA" || $onspot_visitor[0]->nri_card_name == ""){
                                                $url = 'admin-assets/images/team/default.jpg';
                                            }else{
                                                $url = 'images/'.$onspot_visitor[0]->nri_card_name;
                                            }
                                            ?>
                                        <img src="<?php echo base_url().$url; ?>" height="250px" width="250px">  
                                        </div>
                                        <label for="nri_card" generated="true" class="error"></label>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    <div class="form-group row">
                        <label for="example-email-input" class="col-sm-2 col-form-label"><strong>Status</strong></label>
                        <div class="form-group row">
                            
                            <div class="col-sm-10 ">
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="customRadio1" name="status" value="Y" class="custom-control-input status form-control" <?php if($onspot_visitor[0]->status == "Y"){ echo 'checked="checked"'; } ?>>
                                    <label class="custom-control-label" for="customRadio1">Approve</label>                                    
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="customRadio2" name="status" value="P" class="custom-control-input form-control" <?php if($onspot_visitor[0]->status == "P"){ echo 'checked="checked"'; } ?>>
                                    <label class="custom-control-label status" for="customRadio2">Pending</label>                                    
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="customRadio3" name="status" value="D" class="custom-control-input form-control" <?php if($onspot_visitor[0]->status == "D"){ echo 'checked="checked"'; } ?>>
                                <label class="custom-control-label status" for="customRadio3">Disapproved</label>                                    
                                </div>
                                 <div class="custom-control custom-radio">
                                    <input type="radio" id="customRadio4" name="status" value="R" class="custom-control-input form-control" <?php if($onspot_visitor[0]->status == "R"){ echo 'checked="checked"'; } ?>>
                                <label class="custom-control-label status" for="customRadio4">Replaced</label>                                    
                                </div>
                            </div>
                            <label for="status" generated="true" class="error"></label>
                        </div>
                        
                    </div>
					<input type="hidden" id="id" name="id" value="<?php echo $onspot_visitor[0]->id; ?>">
					<input type="hidden" id="unique_code" name="unique_code" value="<?php echo $onspot_visitor[0]->unique_code; ?>">
					<input type="hidden" id="imgpath" name="imgpath" value="<?php echo $onspot_visitor[0]->photo_name; ?>">
                    <div class="form-group row">
                        
                        <div class="col-10">
                            <input class="btn btn-success" type="submit"  name="submit" value="Update">
                            <button class="btn " type="Reset">Reset</button>
                        </div>
                    </div>                    
                    
                </form>
            </div>
        </div>
    </div>
</div>
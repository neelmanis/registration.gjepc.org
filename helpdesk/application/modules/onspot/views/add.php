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
                
                <form class="form" id="onspot-form">
                					
					<div class="form-group row">
                        <label for="example-search-input" class="col-2 col-form-label">Select Category</label>
                        <div class="col-10">
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
                        <label for="example-text-input" class="col-2 col-form-label">Visitor Name</label>
                        <div class="col-10">
                            <input class="form-control" type="text" name="fname" id="fname">
                            <label for="fname" generated="true" class="error"></label>
                        </div>                        
                    </div>
                   
                    <div class="form-group row">
                        <label for="example-search-input" class="col-2 col-form-label">Photo</label>
                        <div class="col-10">
                            <input type="file" class="form-control" name="visitor_photo" id="visitor_photo">
                            <label for="visitor_photo" generated="true" class="error"></label>
                        </div>                        
                    </div>
					
                        <div class="form-group row">
                            <label for="example-search-input" class="col-2 col-form-label">Mobile</label>
                            <div class="col-10">
                                <input class="form-control" name="mobile" type="text"  id="mobile">
                                <label for="mobile" generated="true" class="error"></label>
                            </div>                            
                        </div>
                        <div class="form-group row">
                            <label for="example-search-input" class="col-2 col-form-label">Email</label>
                            <div class="col-10">
                                <input class="form-control" name="email" type="text"  id="email">
                                <label for="email" generated="true" class="error"></label>
							</div>                            
                        </div>
						<div class="form-group row">
                            <label for="example-search-input" class="col-2 col-form-label">PAN</label>
                            <div class="col-10">
                                <input class="form-control" name="pan_no" type="text" id="pan_no">
                                <label for="pan_no" generated="true" class="error"></label>
                            </div>                            
                        </div>
						<div class="form-group row">
                            <label for="example-search-input" class="col-2 col-form-label">Designation</label>
                            <div class="col-10">
                                <input class="form-control" name="designation" type="text" id="designation">
                                <label for="designation" generated="true" class="error"></label>
                            </div>                            
                        </div>
						<div class="form-group row">
                            <label for="example-search-input" class="col-2 col-form-label">Company</label>
                            <div class="col-10">
                                <input class="form-control" name="company" type="text" id="company">
                                <label for="company" generated="true" class="error"></label>
                            </div>                            
                        </div>
						
                    <div class="form-group row">
                        <label for="example-email-input" class="col-2 col-form-label">Status</label>
                        <div class="form-group row">
                            
                            <div class="col-10 ">
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="customRadio1" name="status" value="Y" class="custom-control-input status form-control">
                                    <label class="custom-control-label" for="customRadio1">active</label>
                                    
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="customRadio2" name="status" value="P"  class="custom-control-input form-control">
                                    <label class="custom-control-label status" for="customRadio2">inactive</label>
                                    
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
<?php
if($this->session->userdata('rights')){
		$rightsArray = $this->session->userdata('rights');
		$permissions = $rightsArray['rights'];
		$rights = explode(",",$permissions);
}
?>
<div class="row page-titles">
  <div class="col-md-5 align-self-center">
    <h4 class="text-themecolor"><?php echo $breadcrumb;?></h4>
  </div>
  <div class="col-md-7 align-self-center text-right">
    <div class="d-flex justify-content-end align-items-center">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo base_url();?>admin/dashboard">Home</a></li>
        <li class="breadcrumb-item active"><?php echo $breadcrumb;?></li>
      </ol>
    </div>
  </div>
</div>
  <div class="row">
    <div class="col-lg-12 mt-4">
      <div class="card">
        
		<div class="card-header bg-info">
        <h4 class="m-b-0 text-white"><?php echo $breadcrumb;?></h4>
		</div>

        <div class="card-body">
          <form id="update_category" class="form-material">
            <div class="form-body">
              <div class="row">

				<div class="col-md-8">
					<div class="form-group">
					  <label class="control-label"><strong>Category Name</strong> <span>*</span></label>
					  <input type="text" class="form-control" id="cat_name" name="cat_name" value="<?php echo $category[0]->cat_name; ?>">
					 <label for="cat_name" class="error"></label> 
					</div>
				</div>
				
				<div class="col-md-8">
					<div class="form-group">
					  <label class="control-label"><strong>Short Name</strong> <span>*</span></label>
					  <input type="text" class="form-control slug" id="short_name" name="short_name" value="<?php echo $category[0]->short_name; ?>">
					  <label for="short_name" class="error"></label> 
					</div>
				</div>
						
				<div class="col-md-4">
					<div class="form-group">
					  <label class="control-label"><strong>Sort Order</strong> <span>*</span></label>
					  <input type="text" class="form-control" id="order" name="order" value="<?php echo $category[0]->sort_order; ?>">
					  <label for="order" class="error"></label> 
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
					  <label class="control-label"><strong>Status</strong> <span>*</span></label>
					  <select name="status" id="status" class="form-control">
						<option value="">Select</option>
						 <option value="1" <?php echo $category[0]->status == '1' ? 'selected' : ''; ?> >ACTIVE</option>
						  <option value="0" <?php echo $category[0]->status == '0' ? 'selected' : ''; ?> >DEACTIVE</option>
					  </select>
					  <label for="status" class="error"></label> 
					</div>
				</div>			  

              </div>
            </div>
            
            <input type="hidden" id="id" name="id" value="<?php echo $category[0]->id; ?>">
			<label for="id" class="error"></label> 

            <div class="form-actions mt-4 d-flex">
			<?php /*
			if(in_array('3', $rights)){ */?>
              <button type="submit" class="btn btn-rounded btn-outline-success col-md-3 m-r-10" >Update</button>  
			<?php //} ?>
              <button type="button" class="btn btn-rounded btn-outline-danger col-md-3"  onclick="window.location.href='<?php echo base_url(); ?>category/lists'">Cancel</button>  
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>
<?php
/*
if($this->session->userdata('rights')){
$rightsArray = $this->session->userdata('rights');
$permissions = $rightsArray['rights'];
$rights = explode(",",$permissions);
} */
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
        
		<div class="card-header bg-success">
        <h4 class="m-b-0 text-white">Update Zone</h4>
		</div>

        <div class="card-body">
		<form id="editZone" class="form-material style-form categoryform" >
	
         
		<?php if(is_array($getData)) { ?>  
		<div class="col-md-12">
	        <div class="form-group">
                <label class="control-label"><strong>Title<span>*</span></strong></label>
				<input type="text" name="title" id="title" class="form-control" value="<?php echo $getData[0]->name; ?>"/>
			</div>
		</div>

		<div class="col-md-12">
	        <div class="form-group">
                <label class="control-label"><strong>Short Description<span>*</span></strong></label>
				<textarea id="shortDesc" name="shortDesc" class="contenteditor form-control"><?php echo $getData[0]->description; ?></textarea>
			</div>
		</div>
				
		<div class="form-group">
		    <label class="col-sm-3 control-label">Status <span style="color:red;">*</span></label>
		    <div class="col-sm-9">
			    <select  name="status" id="status" class="form-control">
			    	<option disabled>Choose One</option>
			        <option <?php if($getData[0]->status == '1'){ echo "selected"; }?> value="1">Active</option>
			        <option <?php if($getData[0]->status == '0'){ echo "selected"; }?> value="0">Deactivate</option>
			    </select>
		    </div>
		</div>
		
		<?php $id = $getData[0]->id;	?>
        <input type="hidden" name="id" value="<?php echo $id; ?>">
		
        <?php } ?>
		 <div class="form-actions">
            <?php /*
			if(in_array('30', $rights)){ */?>
			<button type="submit" class="btn btn-rounded btn-outline-success col-md-3">UPDATE</button>  
			<?php //} ?>
            <button type="button" class="btn btn-rounded btn-outline-danger col-md-3" onclick="window.location.href='<?php echo base_url(); ?>master/zone/lists'">CANCEL</button>  
          </div>

	</form>
</div>			
</div>			
</div>			
</div>	
		
	
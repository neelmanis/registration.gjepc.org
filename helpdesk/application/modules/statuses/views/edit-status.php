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
        
		<div class="card-header bg-info">
        <h4 class="m-b-0 text-white">Update Zone</h4>
		</div>

        <div class="card-body">
		<form id="editZone" class="form-horizontal style-form categoryform" >
		<div id="formError" style="display: none;" class="alert alert-danger alert-dismissible"></div>
		<div id="formSuccess" style="display: none;" class="alert alert-success alert-dismissible"></div>
         
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
			<button type="submit" class="btn btn-rounded btn-outline-success col-md-3">UDATE</button>  
			<?php //} ?>
            <button type="button" class="btn btn-rounded btn-outline-danger col-md-3" onclick="window.location.href='<?php echo base_url(); ?>zone/lists'">CANCEL</button>  
          </div>

	</form>
</div>			
</div>			
</div>			
</div>	
		
<script>
var baseUrl = '<?php echo base_url() ?>';
$(document).ready(function(){	
	
	$("#editZone").on("submit",function(e){
		e.preventDefault();
		
		for (instance in CKEDITOR.instances){
			CKEDITOR.instances[instance].updateElement();
		}
			
		if(window.FormData != 'undefined'){
			var formdata = new FormData(this);
	
			$.ajax({
				type:"POST",
				url:"<?php echo base_url();?>zone/editZoneAction",	
				data:formdata,
				processData : false,
				contentType : false,
				mimeType : 'multipart/form-data',
				beforeSend:function() {    
					$("#preloader").show();
				},
				success:function(result){
					$("#preloader").hide(); 
					if(result == 1){
						$(window).scrollTop(0);
						$("#formSuccess").css("display","block");
						$("#formSuccess").html("<b>Zone is updated successfully. </b>").delay(5000).fadeOut();
						window.location.reload(true);
					}else if(result == 2){
						$(window).scrollTop(0);
						$("#formError").css("display","block");
						$("#formError").html("<b>Entered Title already exist.</b>").delay(5000).fadeOut();
					}else{
						$(window).scrollTop(0);
						$("#formError").css("display","block");
						$("#formError").html(result).delay(5000).fadeOut();
					}
				}
			});
		}
	});
})
</script>			
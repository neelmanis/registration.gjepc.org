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
        <h4 class="m-b-0 text-white">Add Zone </h4>
      </div>
    
      <div class="card-body">
		<form id="add_zone" class="form-material">
		<div id="formError" style="display: none;" class="alert alert-danger alert-dismissible"></div>
		<div id="formSuccess" style="display: none;" class="alert alert-success alert-dismissible"></div>
	
		<div class="col-md-12">
	        <div class="form-group">
                <label class="control-label"><strong>Name<span>*</span></strong></label>
				<input type="text" name="title" id="title" class="form-control"/>
				<label for="title" class="error"></label> 
			</div>
		</div>

		<div class="col-md-12">
	        <div class="form-group">
                <label class="control-label"><strong>Short Description<span>*</span></strong></label>
				<textarea id="shortDesc" name="shortDesc" class="contenteditor form-control"></textarea>
				<label for="shortDesc" class="error"></label> 
			</div>
		</div>

		<div class="col-md-4">
                <div class="form-group">
                  <label class="control-label"><strong>Status</strong> <span>*</span></label>
                  <select name="status" id="status" class="form-control">
                    <option value="">Select</option>
                    <option value="1">Active</option>
                    <option value="0">Deactive</option>
                  </select>
                  <label for="status" class="error"></label> 
                </div>
        </div>
		
		 <?php $_SESSION["token"] = md5(uniqid(mt_rand(), true)); ?>
			<input type="hidden" name="csrfToken" id="csrfreg" value="<?php echo $_SESSION["token"];?>">
          <div class="form-actions m-t-10 d-flex">
			<?php 
		/*	if(in_array('29', $rights)){ */ ?>
            <button type="submit" class="btn btn-rounded btn-outline-success col-md-3 m-r-10">Save</button> 
			<?php //} ?>
            <button type="button" class="btn btn-rounded btn-outline-danger col-md-3" onclick="window.location.href='<?php echo base_url(); ?>zone/lists'">Cancel</button>  
          </div>
	</form>
</div>			
</div>			
</div>			
</div>			
<script>
	var baseUrl = '<?php echo base_url() ?>';	
	$(document).ready(function(){	
					   
		$("#add_zone").on("submit",function(e){
			e.preventDefault();
			for (instance in CKEDITOR.instances){
				CKEDITOR.instances[instance].updateElement();
			}
			
			if(window.FormData != 'undefined'){
				var formdata = new FormData(this);
	
				$.ajax({
					type:"POST",
					url:"<?php echo base_url();?>zone/addZoneAction",	
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
							$("#add_zone")[0].reset();
							$(window).scrollTop(0);
							$("#formSuccess").css("display","block");
							$("#formSuccess").html("<b> Zone added successfully. </b>").delay(5000).fadeOut();
						}else if(result == 2){
							$(window).scrollTop(0);
							$("#formError").css("display","block");
							$("#formError").html("<b>Title Already Exist !!</b>").delay(5000).fadeOut();
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
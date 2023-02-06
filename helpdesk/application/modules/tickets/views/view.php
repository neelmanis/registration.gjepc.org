<?php 
 $admin = $this->session->userdata('admin');
 $admin_id = $admin['admin_id'];
 $role = $admin['role'];
 if($role == 'Super Admin'){
$url = 'https://gjepc.org/assets/images/logo.png';
}else if($role == 'Admin'){
$url = base_url().'/assets/admin/images/users/hall-manager.png'; 
}else if($role == 'Vendor'){
$url = base_url().'/assets/admin/images/users/vendor.png';
}
	$activeUser = '';						
	if($onlineStatus[0]->online) {
		$activeUser = 'ppWrp'; //online
	}
?>
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor"><?php //echo $breadcrumb;?> Ticket ID # <?php echo $onspot_visitor[0]->id;?></h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url();?>admin/dashboard">Home</a></li>
                <li class="breadcrumb-item active">View Tickets</li>
            </ol>
        </div>
    </div>
</div>
<div class="row">

    <div class="col-sm-12">
		<form class="form-material" id="update_tickets">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title"><?php echo $breadcrumb;?></h4>      
				<div class="row">	
					<div class="form-group col-md-4">
                        <label for="example-search-input" class="col-sm-12 col-form-label"><strong>Department</strong></label>
                        <div class="col-sm-12">
                            <select class="form-control" name="department_id" id="department_id">                            
                              <option value="">SELECT Department</option>
							  <?php foreach($dept as $val){ ?>
							  <option value="<?php echo $val->id; ?>" <?php if($val->id == $onspot_visitor[0]->department_id){ echo 'selected'; }?>><?php echo strtoupper($val->name); ?></option>
							  <?php } ?>
							</select>	
							<label for="department_id" generated="true" class="error"></label>
                        </div>                        
                    </div>
					
                   	<div class="form-group col-md-4">
                        <label for="example-text-input" class="col-sm-12 col-form-label"><strong>Exhibitor NAME</strong></label>
                        <div class="col-sm-12">
                            <input class="form-control" type="text" name="exhibitor_name" id="exhibitor_name" value="<?php echo $onspot_visitor[0]->exhibitor_name;?>">
                            <label for="exhibitor_name" generated="true" class="error"></label>
                        </div>                        
                    </div>
					
					<div class="form-group col-md-4">
                        <label for="example-text-input" class="col-sm-12 col-form-label"><strong>Exhibitor Hall</strong></label>
                        <div class="col-sm-12">
                        <input class="form-control" type="text" name="hall_no" id="hall_no" value="<?php echo $onspot_visitor[0]->hall_no; ?>">
                        <label for="hall_no" generated="true" class="error"></label>
                        </div>                        
                    </div>
					
					<div class="form-group col-md-4">
                        <label for="example-text-input" class="col-sm-12 col-form-label"><strong>Exhibitor Division</strong></label>
                        <div class="col-sm-12">
                            <input class="form-control" type="text" name="division_no" id="division_no" value="<?php echo $onspot_visitor[0]->division_no; ?>" >
                            <label for="division_no" generated="true" class="error"></label>
                        </div>                        
                    </div>
                </div>
			</div>                        
        </div>	
			<div class="card">
			<div class="card-body">
				
				<?php if($role == "Super Admin" || $role == "Admin"){ ?>
				<div class="row">            				
				<div class="col-md-6">
                <div class="table-responsive">
                  <table class="table color-table">
                    <thead>
                      <tr style="background: #333; color:#fff;">
                        <th>Vendor RIGHTS</th>
                        <th>ALLOW ACCESS</th>
                      </tr>
                    </thead>
                    <tbody>
					<?php foreach($vendorUser as $vd){ ?>
					<tr>
                        <td>
						<?php echo strtoupper($vd->contact_name); 
								$rights = explode(",", $onspot_visitor[0]->vendor_id); ?></td>
                        <td>
                          <div class="switchery-demo">
                           <!--<input type="checkbox" name="rights[]" value="<?php echo $vd->id;?>" class="js-switch" data-color="#009efb" checked="" style="display: none;" data-switchery="true"><span class="switchery switchery-default" style="background-color: rgb(255, 255, 255); border-color: rgb(223, 223, 223); box-shadow: rgb(223, 223, 223) 0px 0px 0px 0px inset; transition: border 0.4s ease 0s, box-shadow 0.4s ease 0s;"><small style="left: 20px; background-color: rgb(255, 255, 255); transition: background-color 0.4s ease 0s, left 0.2s ease 0s;"></small></span>-->
                            <input type="checkbox" name="rights[]" value="<?php echo $vd->id;?>" <?php if(in_array($vd->id, $rights)){ echo "checked='checked'";} ?>>
                          </div>
                        </td>
                    </tr>
					<?php } ?>
                    </tbody>
                  </table>
                </div>
                <label for="rights[]" class="error ml-2"></label>
				</div>
				</div>
				<?php } ?>
					<div class="row">	
					<div class="form-group col-md-4">
                        <label for="example-search-input" class="col-sm-12 col-form-label"><strong>SELECT Priority</strong></label>
                        <div class="col-sm-12">
                            <select class="form-control" name="priority_id" id="priority_id">                            
                              <option value="">SELECT Priority</option>
							  <?php foreach($priorities as $priority){ ?>
							  <option value="<?php echo $priority->id; ?>" <?php if($priority->id == $onspot_visitor[0]->priority_id){ echo 'selected'; }?>><?php echo strtoupper($priority->name); ?></option>
							  <?php } ?>
							</select>	
							<label for="priority_id" generated="true" class="error"></label>
                        </div>                        
                    </div>					
					<div class="form-group row">
                        <label for="example-search-input" class="col-sm-12 col-form-label"><strong>SELECT Status</strong></label>
                        <div class="col-sm-12">
                            <select class="form-control" name="statuses" id="statuses">                            
                              <option value="">SELECT STATUS</option>
							  <?php foreach($statuses as $val){ ?>
							  <option value="<?php echo $val->id; ?>" <?php if($val->id == $onspot_visitor[0]->status_id){ echo 'selected'; }?>><?php echo strtoupper($val->name); ?></option>
							  <?php } ?>
							</select>	
							<label for="statuses" generated="true" class="error"></label>
                        </div>                        
                    </div>
                    </div>
					
					<!--<input type="hidden" id="unique_code" name="unique_code" value="<?php //echo $onspot_visitor[0]->unique_code; ?>">
					<input type="hidden" id="imgpath" name="imgpath" value="<?php //echo $onspot_visitor[0]->photo_name; ?>">-->
                    <!--<div class="form-group row">
                        
                        <div class="col-10">
                            <input class="btn btn-success" type="submit"  name="submit" value="Update">
                            <button class="btn " type="Reset">Reset</button>
                        </div>
                    </div>  -->   
					<input type="hidden" id="id" name="id" value="<?php echo $onspot_visitor[0]->id; ?>">
					<div class="form-group row">                        
                        <div class="col-10">
                            <input class="btn btn-success" type="submit" name="submit" value="Update">
                        </div>
                    </div>     
            </div>		
        </div>
		</form>		
			<!-- Comments Section -->
			<div class="card">
			<div class="card-body">
				<div class="form-group row">
                        <label for="example-text-input" class="col-sm-12 col-form-label"><strong>SUBJECT </strong></label>
                        <div class="col-sm-12">
                         <input class="form-control" type="text" name="subject" id="subject" value="<?php echo $onspot_visitor[0]->subject; ?>">
                        <label for="subject" generated="true" class="error"></label>
                        </div>                        
                </div>
				<div class="form-group row">
                        <label for="example-text-input" class="col-sm-12 col-form-label"><strong>Ticket Summary </strong></label>
                        <div class="col-sm-12">
                        <textarea class="form-control" name="description" id="description"><?php echo $onspot_visitor[0]->description; ?></textarea>
                        <label for="fname" generated="true" class="error"></label>
                        </div>
						<?php echo $strTimeAgo = timeago($onspot_visitor[0]->created_at);?>                       
                </div>
				<?php
				function timeago($date) {
				   $timestamp = strtotime($date);	
				   
				   $strTime = array("second", "minute", "hour", "day", "month", "year");
				   $length = array("60","60","24","30","12","10");

				   $currentTime = time();
				   if($currentTime >= $timestamp) {
						$diff     = time()- $timestamp;
						for($i = 0; $diff >= $length[$i] && $i < count($length)-1; $i++) {
						$diff = $diff / $length[$i];
						}

						$diff = round($diff);
						return $diff . " " . $strTime[$i] . "(s) ago ";
					}
					}	?>            
				
				<div class="container-fluid comments_area" id="commentToTop">
					<!-- Comment Form -->
					<div class="comment_box">
						<!-- Image of Account-->
						<div class="author_dp">
						<div><span class="<?php echo $activeUser;?>"></span><img src="<?php echo $url; ?>" style="border-radius:100px;"></div>
						</div> 
						<div class="comment">
							<form id="comment_form">
								<input type="hidden" name="user_id" id="user_id" value="<?php echo $admin_id;?>"/>
								<input type="hidden" name="utype" id="utype" value="<?php echo $role; ?>"/>
								<input type="hidden" name="ticket_id" id="ticket_id" value="<?php echo $onspot_visitor[0]->id;?>"/>
								<input type="hidden" name="pid" id="pid" value="0"/>
								<div class="form-group" id="commentTrigger">
								<textarea class="form-control" name="comment" id="commentBox" placeholder="Enter your reply..."></textarea>
								</div>
								<div id='submit_button'>
									<button id="postComment" class="btn bluebtn" style="margin:0 auto 20px;display:table;width:100%; max-width:280px;">Send Reply</button>
								</div>
							</form>
						</div>
					</div>

					<div id="comment_result"><?php echo $comments; ?></div>
				</div>
				</div>
            </div>            
    </div>	
</div>
<STYLE>
textarea {
  width: 800px;
  height: 150px;
}
.ppWrp{ position:relative}
.ppWrp:before {content:'';position:absolute;top: -4px;left: 0px;width: 8px;height: 8px;background: #00ff2b;border-radius: 100px;}
</STYLE>
<link href="https://registration.gjepc.org/manual_tritiya/helpdesk/assets/admin/css/comment.css" rel="stylesheet">
<script>var CI_ROOT = '<?php echo base_url()?>';</script>
<script>
$(document).ready(function(){	
	$("#postComment").click(function(e){
		e.preventDefault();
		var formdata = $("#comment_form").serialize();
		$.ajax({
			type:"POST",
			url:CI_ROOT+"tickets/addComment",	
			data:formdata,
			beforeSend:function() { 
				showLoader();
			},
			success : function(result){
				hideLoader();
				if(result == 1){
					window.location.reload();
				}else{
					//alert(result);
					window.location.reload();
				}
			}
		});
	});
	
	$("a.reply").click(function (e){
		e.preventDefault();
		var id = $(this).attr("id");
		$("#pid").attr("value", id);
		$('html, body').animate({
			scrollTop: $("#commentToTop").offset().top-80
		}, 200);
		//$("#commentBox").focus();
		$('#commentTrigger').addClass('comment_trigger');
	});
	
	$('#commentBox').click(function() { $('#commentTrigger').removeClass('comment_trigger'); });
});
</script>
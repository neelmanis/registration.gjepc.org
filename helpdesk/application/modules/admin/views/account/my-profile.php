<div class="row">
  <div class="col-lg-12 mt-4">
    <div class="card">
      <div class="card-header form-card-header">
        <h4 class="m-b-0 text-light text-center">MY PROFILE</h4>
      </div>

      <div class="card-body">
        <?php if( $admin_details !== "NA" ){ ?>
        
          <form id="my_profile" class="form-horizontal form-material">

            <div class="form-group row">
              <label for="inputEmail3" class="col-sm-3 control-label col-form-label">Name</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $admin_details[0]->name; ?>">
                <label for="name" class="error"></label>
              </div>
            </div>

            <div class="form-group row">
              <label for="inputEmail3" class="col-sm-3 control-label col-form-label">Email</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="email" name="email" value="<?php echo $admin_details[0]->email; ?>">
                <label for="email" class="error"></label>
              </div>
            </div>
            
            <div class="form-group row">
              <label for="inputEmail3" class="col-sm-3 control-label col-form-label">Username</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="username" name="username" value="<?php echo $admin_details[0]->username; ?>">
                <label for="username" class="error"></label>
              </div>
            </div>

            <div class="form-group row">
              <label for="inputEmail3" class="col-sm-3 control-label col-form-label">New Password</label>
              <div class="col-sm-9">
                <input type="password" class="form-control" id="newPassword" name="newPassword">
                <label for="newPassword" class="error"></label>
              </div>
            </div>

            <div class="form-group row">
              <label for="inputEmail3" class="col-sm-3 control-label col-form-label">Confirm Password</label>
              <div class="col-sm-9">
                <input type="password" class="form-control" id="confirmPassword" name="confirmPassword">
                <label for="confirmPassword" class="error"></label>
              </div>
            </div>
              
            <?php $_SESSION["token"] = md5(uniqid(mt_rand(), true)); ?>
            <input type="hidden" name="csrfToken" id="csrfToken" value="<?php echo $_SESSION["token"];?>">

            <input type="hidden" name="adminUsername" id="adminUsername" value="<?php echo $admin_details[0]->username;  ?>"> 

            <input type="hidden" name="adminEmail" id="adminEmail" value="<?php echo $admin_details[0]->email;  ?>"> 

            <div class="offset-sm-3 col-sm-9">
              <button type="submit" class="col-md-3 btn btn-rounded btn-outline-success">Update</button>  
              <button type="button" class="col-md-3 btn btn-rounded btn-outline-danger" onclick="window.location.href='<?php echo base_url(); ?>admin/dashboard'">Cancel</button> 
            </div>
          </form>

        <?php } ?>
      </div>
    </div>
  </div>
</div>
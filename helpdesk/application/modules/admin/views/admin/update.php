<div class="row">
  <div class="col-lg-12 mt-4">
    <div class="card">

      <div class="card-header form-card-header">
        <h4 class="m-b-0 text-light text-center">UPDATE ACCOUNT DETAILS</h4>
      </div>

      <div class="card-body">
        <form id="update_admin" class="form-material">
          <div class="form-body">
            <div class="row">

              <div class="col-md-4">
                <div class="form-group">
                  <label class="control-label"><strong>Name</strong> <span>*</span></label>
                  <input type="text" name="name" id="name" value="<?php echo $admin[0]->name; ?>" class="form-control"/>
                  <label for="name" class="error"></label> 
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group">
                  <label class="control-label"><strong>Email</strong> <span>*</span></label>
                  <input type="text" name="email" id="email" value="<?php echo $admin[0]->email; ?>" class="form-control"/>
                  <label for="email" class="error"></label> 
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group">
                  <label class="control-label"><strong>Username</strong> <span>*</span></label>
                  <input type="text" name="username" id="username" value="<?php echo $admin[0]->username; ?>" class="form-control"/>
                  <label for="username" class="error"></label> 
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group">
                  <label class="control-label"><strong>Password</strong> <span>*</span></label>
                  <input type="text" name="password_text" id="password_text" value="<?php echo $admin[0]->password_text; ?>" class="form-control"/>
                  <label for="password_text" class="error"></label> 
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group">
                  <label class="control-label"><strong>Role</strong> <span>*</span></label>
                  <select name="role" id="role" class="form-control">
                    <option value="">Select</option>
                    <?php if($roles !== "NA"){ 
                      foreach($roles as $r){  
                    ?>
                      <option value="<?php echo $r->role_id; ?>" <?php  if($r->role_id == $admin[0]->role_id){ echo 'selected'; } ?> ><?php echo $r->name; ?></option>
                    <?php } } ?>
                  </select>
                  <label for="role" class="error"></label> 
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group">
                  <label class="control-label"><strong>Status</strong> <span>*</span></label>
                  <select name="status" id="status" class="form-control">
                    <option value="">Select</option>
                    <option value="active" <?php if($admin[0]->status == "active"){ echo "selected"; } ?> >Active</option>
                    <option value="deactive" <?php if($admin[0]->status == "deactive"){ echo "selected"; } ?> >Inactive</option>
                  </select>
                  <label for="status" class="error"></label> 
                </div>
              </div>

            </div>
          </div>

          <input type="hidden" name="admin_id" id="admin_id" value="<?php echo $admin[0]->admin_id;  ?>"> 
          <input type="hidden" name="adminUsername" id="adminUsername" value="<?php echo $admin[0]->username;  ?>"> 
          <input type="hidden" name="adminEmail" id="adminEmail" value="<?php echo $admin[0]->email;  ?>"> 

          <?php $_SESSION["token"] = md5(uniqid(mt_rand(), true)); ?>
          <input type="hidden" name="csrfToken" id="csrfToken" value="<?php echo $_SESSION["token"];?>">

          <div class="form-actions m-t-10 d-flex">
            <button type="submit" class="btn btn-rounded btn-outline-success col-md-3 m-r-10" >Save</button>  
            <button type="button" class="btn btn-rounded btn-outline-danger col-md-3"  onclick="window.location.href='<?php echo base_url(); ?>admin/list'">Cancel</button>  
          </div>
        </form>
      </div>
      
    </div>
  </div>
</div>
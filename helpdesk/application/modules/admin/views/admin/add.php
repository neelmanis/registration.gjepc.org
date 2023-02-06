<div class="row">
  <div class="col-lg-12 mt-4">
    <div class="card">

      <div class="card-header form-card-header">
        <h4 class="m-b-0 text-light text-center">CREATE ADMIN ACCOUNT</h4>
      </div>

      <div class="card-body">
        <form id="add_admin" class="form-material">
          <div class="form-body">
            <div class="row">

              <div class="col-md-4">
                <div class="form-group">
                  <label class="control-label"><strong>Name</strong> <span>*</span></label>
                  <input type="text" name="name" id="name" class="form-control"/>
                  <label for="name" class="error"></label> 
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group">
                  <label class="control-label"><strong>Email</strong> <span>*</span></label>
                  <input type="text" name="email" id="email" class="form-control"/>
                  <label for="email" class="error"></label> 
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="control-label"><strong>Mobile</strong> <span>*</span></label>
                  <input type="text" name="mobile" id="mobile" class="form-control"/>
                  <label for="mobile" class="error"></label> 
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group">
                  <label class="control-label"><strong>Username</strong> <span>*</span></label>
                  <input type="text" name="username" id="username" class="form-control"/>
                  <label for="username" class="error"></label> 
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group">
                  <label class="control-label"><strong>Password</strong> <span>*</span></label>
                  <input type="text" name="password_text" id="password_text" class="form-control"/>
                  <label for="password_text" class="error"></label> 
                </div>
              </div>
              

              <div class="col-md-4">
                <div class="form-group">
                  <label class="control-label"><strong>Role</strong> <span>*</span></label>
                  <select name="role" id="role" class="form-control">
                    <option value="">Select</option>
                    <option value="superadmin">Superadmin</option>
                    <?php if($roles !== "NA"){ 
                      foreach($roles as $r){  
                    ?>
                      <option value="<?php echo $r->role_id; ?>"><?php echo $r->name; ?></option>
                    <?php } } ?>
                  </select>
                  <label for="role" class="error"></label> 
                </div>
              </div>
              
              <div class="col-md-4">
                <div class="form-group">
                  <label class="control-label"><strong>Allow Category</strong> <span>*</span></label>
                  <select type="text" name="category" id="category" class="form-control">
                    <option value="">Select Category</option>
                    <?php if($category !=="NA"){
                      foreach($category as $cat){ ?>
                        <option value="<?php echo $cat->short_name; ?>"><?php echo $cat->cat_name; ?></option>
                      <?php }
                    }?>

                   
                  </select>
                  <label for="access" class="error"></label> 
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="control-label"><strong>Access Platform</strong> <span>*</span></label>
                  <select type="text" name="access" id="access" class="form-control">
                    <option value="">Select</option>
                    <option value="app">App</option>
                    <option value="web">Web</option>
                    <option value="both">Both</option>
                  </select>
                  <label for="access" class="error"></label> 
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="control-label"><strong>SuperAdmin</strong> <span>*</span></label>
                  <select type="text" name="access" id="access" class="form-control">
                    <option value="">Select</option>
                    <option value="0">No</option>
                    <option value="1">Yes</option>
                    
                  </select>
                  <label for="access" class="error"></label> 
                </div>
              </div>

            </div>
          </div>

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
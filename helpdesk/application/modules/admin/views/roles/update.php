<div class="row">
  <div class="col-lg-12 mt-4">
    <div class="card">

      <div class="card-header form-card-header">
        <h4 class="m-b-0 text-light text-center">UPDATE ROLE DETAILS</h4>
      </div>

      <div class="card-body">
        <form id="update_role" class="form-material">
          <div class="form-body">
            <div class="row">

              <div class="col-md-4">
                <div class="form-group">
                  <label class="control-label">Role Name <span>*</span></label>
                  <input type="text" id="name" name="name" value="<?php echo $role[0]->name; ?>" class="form-control">
                  <label for="name" class="error"></label> 
                </div>
              </div>
            </div>
           
            <?php $rights = explode(",", $role[0]->rights); ?>

            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table class="table color-table">
                    <thead>
                      <tr style="background: #333; color:#fff;">
                        <th>RIGHTS</th>
                        <th>ALLOW ACCESS</th>
                      </tr>
                    </thead>
                    <tbody>

                      <tr>
                        <td>Master</td>
                        <td>
                          <div class="switchery-demo">
                            <input type="checkbox" name="rights[]" value="4" class="js-switch" data-color="#009efb" <?php if(in_array("4", $rights)){ echo 'checked'; }?> />
                          </div>
                        </td>
                      </tr>

                      <tr>
                        <td>Institution</td>
                        <td>
                          <div class="switchery-demo">
                            <input type="checkbox" name="rights[]" value="2" class="js-switch" data-color="#009efb" <?php if(in_array("2", $rights)){ echo 'checked'; }?> />
                          </div>
                        </td>
                      </tr>

                      <tr>
                        <td>SEO</td>
                        <td>
                          <div class="switchery-demo">
                            <input type="checkbox" name="rights[]" value="1" class="js-switch" data-color="#009efb" <?php if(in_array("1", $rights)){ echo 'checked'; }?>/>
                          </div>
                        </td>
                      </tr>

                      <tr>
                        <td>Blogs</td>
                        <td>
                          <div class="switchery-demo">
                            <input type="checkbox" name="rights[]" value="3" class="js-switch" data-color="#009efb" <?php if(in_array("3", $rights)){ echo 'checked'; }?>/>
                          </div>
                        </td>
                      </tr>

                    </tbody>
                  </table>
                </div>
                <label for="rights[]" class="error ml-2"></label>
              </div>
            </div>
          </div>

          <?php $_SESSION["token"] = md5(uniqid(mt_rand(), true)); ?>
          <input type="hidden" name="csrfToken" id="csrfToken" value="<?php echo $_SESSION["token"];?>">
          
          <input type="hidden" id="role_id" name="role_id" value="<?php echo $role[0]->role_id; ?>">
          <input type="hidden" id="roleName" name="roleName" value="<?php echo $role[0]->name; ?>">

          <div class="form-actions m-t-10 d-flex">
            <button type="submit" class="btn btn-rounded btn-outline-success col-md-3 m-r-10" >Update</button>  
            <button type="button" class="btn btn-rounded btn-outline-danger col-md-3"  onclick="window.location.href='<?php echo base_url(); ?>admin/roles/list'">Cancel</button>  
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
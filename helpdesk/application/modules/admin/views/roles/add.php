<div class="row">
  <div class="col-lg-12 mt-4">
    <div class="card">

      <div class="card-header form-card-header">
        <h4 class="m-b-0 text-light text-center">CREATE ROLE</h4>
      </div>

      <div class="card-body">
        <form id="add_role" class="form-material">
          <div class="form-body">
            <div class="row">

              <div class="col-md-4">
                <div class="form-group">
                  <label class="control-label">Role Name <span>*</span></label>
                  <input type="text" id="name" name="name" class="form-control" style="text-transform: none;">
                  <label for="name" class="error"></label> 
                </div>
              </div>
            </div>
           
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
                      <?php
                      if($menu !=="NA"){
                        foreach($menu as $val){ ?>
                             <td><?php echo $val->name; ?></td>
                                <td>
                                  <div class="switchery-demo">
                                    <input type="checkbox" name="rights[]" value="<?php echo $val->id; ?>" class="js-switch" data-color="#009efb" />
                                  </div>
                                </td>
                              </tr>
                        <?php }
                      } 
                       
                      ?>
                      

                    </tbody>
                  </table>
                </div>
                <label for="rights[]" class="error ml-2"></label>
              </div>
            </div>
          </div>

          <?php $_SESSION["token"] = md5(uniqid(mt_rand(), true)); ?>
          <input type="hidden" name="csrfToken" id="csrfToken" value="<?php echo $_SESSION["token"];?>">
          
          <div class="form-actions m-t-10 d-flex">
            <button type="submit" class="btn btn-rounded btn-outline-success col-md-3 m-r-10" >Save</button>  
            <button type="button" class="btn btn-rounded btn-outline-danger col-md-3"  onclick="window.location.href='<?php echo base_url(); ?>admin/roles/list'">Cancel</button>  
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-lg-12 mt-4">
    <div class="card-header form-card-header">
      <h4 class="m-b-0 text-light text-center">UPDATE STATUS</h4>
    </div>

    <div class="card">
      <form id="update_status" class="form-material">
        <div class="card-body">

          <div class="form-body">
            <div class="row">

              <div class="col-12">
                <div class="form-group">
                  <label class="control-label"><strong>Step</strong></label>
                  <input 
                    type="text" 
                    name="step" 
                    id="step" 
                    value="<?= $status[0]->dashboard; ?>"
                    class="form-control" />
                  <label for="step" class="error"></label> 
                </div>
              </div>

              <div class="col-12">
                <div class="form-group">
                  <label class="control-label"><strong>Details</strong></label>
                  <input 
                    type="text" 
                    name="details" 
                    id="details" 
                    value="<?= $status[0]->case_details; ?>"
                    class="form-control" />
                  <label for="details" class="error"></label> 
                </div>
              </div>

              <div class="col-12">
                <div class="form-group">
                  <label class="control-label"><strong>Information</strong></label>
                  <textarea 
                    name="info" 
                    id="info" 
                    class="form-control" 
                    rows="3" ><?= $status[0]->info; ?></textarea>
                  <label for="info" class="error"></label> 
                </div>
              </div>

              <div class="col-md-3 col-sm-12">
                <div class="form-group">
                  <label class="control-label"><strong>Status</strong></label>
                  <select 
                    name="status" 
                    id="status" 
                    class="form-control" >
                    <option 
                      value="1" 
                      <?php echo $status[0]->status == "1" ? "selected" : ""; ?> 
                      >Active</option>
                    <option 
                      value="0" 
                      <?php echo $status[0]->status == "0" ? "selected" : ""; ?> 
                      >Inactive</option>
                  </select>
                  <label for="status" class="error"></label> 
                </div>
              </div>

            </div>
          </div>

          <input 
            type="hidden" 
            id="statusId" 
            name="statusId" 
            value="<?= $status[0]->id; ?>" >

          <?php $_SESSION["token"] = md5(uniqid(mt_rand(), true)); ?>

          <input 
            type="hidden" 
            name="csrfToken" 
            id="csrfToken" 
            value="<?= $_SESSION["token"];?>" >

          <div class="form-actions mt-4 d-flex">
            <button type="submit" class="btn btn-rounded btn-outline-success col-md-3 m-r-10 mb-2 mb-md-0" >Update</button>  
            <button type="button" class="btn btn-rounded btn-outline-danger col-md-3"  onclick="window.location.href='<?php echo base_url(); ?>master/status/list'">Cancel</button> 
          </div>
          
        </div>
      </form>
    </div>
  </div>
</div>
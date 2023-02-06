<div class="row">
  <div class="col-lg-12 mt-4">
    <div class="card-header form-card-header">
      <h4 class="m-b-0 text-light text-center">ADD TIMETABLE</h4>
    </div>

    <div class="card">
      <form id="add_timetable" class="form-material">
        <div class="card-body">

          <div class="form-body">
            <div class="row">

              <div class="col-12">
                <div class="form-group">
                  <label class="control-label"><strong>Title</strong></label>
                  <input 
                    type="text" 
                    name="title" 
                    id="title" 
                    class="form-control" />
                  <label for="title" class="error"></label> 
                </div>
              </div>

            </div>
          </div>
          
          <?php $_SESSION["token"] = md5(uniqid(mt_rand(), true)); ?>
          <input 
            type="hidden" 
            name="csrfToken" 
            id="csrfToken" 
            value="<?php echo $_SESSION["token"];?>" >

          <div class="form-actions mt-4 d-flex">
            <button type="submit" class="btn btn-rounded btn-outline-success col-md-3 m-r-10 mb-2 mb-md-0" >Save</button>  
            <button type="button" class="btn btn-rounded btn-outline-danger col-md-3"  onclick="window.location.href='<?php echo base_url(); ?>master/timetable/list'">Cancel</button> 
          </div>

        </div>
      </form>
    </div>
  </div>
</div>
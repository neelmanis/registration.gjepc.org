<div class="row">
  <div class="col-lg-12 mt-4">
    <div class="card-header form-card-header">
      <h4 class="m-b-0 text-light text-center">UPDATE SEO</h4>
    </div>

    <div class="card">
      <form id="update_seo" class="form-material">
        <div class="card-body">

          <div class="form-body">
            <div class="row">

              <div class="col-md-6 col-sm-12">
                <div class="form-group">
                  <label class="control-label"><strong>Page</strong></label>
                  <input type="input" name="page" id="page" value="<?php echo $seo[0]->page; ?>" class="form-control" readonly/>
                  <label for="page" class="error"></label> 
                </div>
              </div>
              
              <div class="col-md-12 col-sm-12">
                <div class="form-group">
                  <label class="control-label"><strong>Meta Title</strong></label>
                  <input type="input" name="meta_title" id="meta_title" value="<?php echo $seo[0]->meta_title; ?>" class="form-control" />
                  <label for="meta_title" class="error"></label> 
                </div>
              </div>

              <div class="col-md-12 col-sm-12">
                <div class="form-group">
                  <label class="control-label"><strong>Meta Description</strong></label>
                  <textarea type="input" name="meta_description" id="meta_description" rows="2" class="form-control"><?php echo $seo[0]->meta_description; ?></textarea>
                  <label for="meta_description" class="error"></label> 
                </div>
              </div>

              <div class="col-md-12 col-sm-12">
                <div class="form-group">
                  <label class="control-label"><strong>Meta Keywords</strong></label>
                  <textarea type="input" name="meta_keywords" id="meta_keywords" rows="2" class="form-control"><?php echo $seo[0]->meta_keywords; ?></textarea>
                  <label for="meta_keywords" class="error"></label> 
                </div>
              </div>

              <div class="col-md-12 col-sm-12">
                <div class="form-group">
                  <label class="control-label"><strong>Canonical Url</strong></label>
                  <input type="input" name="canonical" id="canonical" value="<?php echo $seo[0]->canonical; ?>" class="form-control" />
                  <label for="canonical" class="error"></label> 
                </div>
              </div>

            </div>
          </div>
          
          <input type="hidden" id="seoId" name="seoId" value="<?php echo $seo[0]->seo_id; ?>" >

          <?php $_SESSION["token"] = md5(uniqid(mt_rand(), true)); ?>
          <input type="hidden" name="csrfToken" id="csrfToken" value="<?php echo $_SESSION["token"];?>">
          
          <div class="form-actions mt-4 d-flex">
            <button type="submit" class="btn btn-rounded btn-outline-success col-md-3 m-r-10 mb-2 mb-md-0" >Update</button>  
            <button type="button" class="btn btn-rounded btn-outline-danger col-md-3"  onclick="window.location.href='<?php echo base_url(); ?>seo/list'">Cancel</button> 
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
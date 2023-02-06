<?php
  $admin = $this->session->userdata('admin');
  // $rights = explode(",",$admin['rights']);
?>

<style>
  table{
    margin: 0 auto;
    width: 100% !important;
    clear: both;
    border-collapse: collapse;
    table-layout: fixed; 
    word-wrap:break-word; 
  }

  table.dataTable thead .sorting_asc:after {
    content: "\f0de" !important;
    margin-left: 10px;
    font-family: fontawesome !important;
    cursor: pointer;
    color: #fff;
    font-size: 19px;
  }

  table.dataTable thead .sorting_desc:after {
    content: "\f0dd" !important;
    margin-left: 10px;
    font-family: fontawesome !important;
    cursor: pointer;
    color: #fff;
    font-size: 19px;
  }
  #allVisitorsTable_filter {
    display: none;
  }
</style>

<div class="row justify-content-between page-titles">
  <div class="col-auto align-self-center">
    <h4 class="text-themecolor">All Visitors</h4>
  </div>
  <div class="col-auto align-self-center text-right">
    <div class="d-flex justify-content-end align-items-center">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo base_url();?>admin/dashboard">Home</a></li>
        <li class="breadcrumb-item active ">All Visitors <a href="<?php echo base_url();?>visitors/add" class="btn btn-inline-block">Add</a></li>
      </ol>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-12">
    <div class="card">
    
      <div class="card-body">
    <form class="form-material" id='form-filter'>
        <div class="row">
          <div class="col-md-3">
              <label>Pan Number</label>
              <input type="text" name="vis_pan" id="vis_pan" class="form-control" maxlength="10" placeholder="Search Pan Number" autofocus/>
            </div>
            <div class="col-md-3">
              <label>Visitor Name</label>
              <input type="text" name="vis_name" id="vis_name" class="form-control" placeholder="Search User" autofocus/>
            </div>
            <div class="col-md-3">
              <label>Company Name</label>
              <input type="text" name="company_name" id="company_name" class="form-control" placeholder="Search Company" autofocus/>
            </div>

            <div class="col-md-3">
               <label>Category</label>
                <select  name="category" id="category" class="form-control" >
                    <option value="">All Categories</option>
                    <?php if($categories !=="NA"){
                      foreach($categories as $cat){ ?>
                      <option  value="<?php echo $cat->short_name; ?>"><?php echo $cat->cat_name; ?></option>
                    <?php } } ?>
                </select>
            </div>
            <div class="col-md-3 mt-3">
                   <button type="submit" id="btn-filter" class="btn btn-inline-block btn-primary mr-2" > <i class="icon-refresh"></i> Fetch User</button>
                   <button type="submit" id="btn-reset" class="btn btn-inline-block btn-secondary" > </i> Reset</button>
                   
            </div>
        </div>
    </form>
</div>
    </div>
  </div>
</div>


<div class="row">
  <div class="col-12">
    <div class="card">
    
      <div class="card-body">
        <table id="allVisitorsTable" class="table color-table purple-table text-center" cellspacing="0" width="100%">
          <thead>
            <tr>
              <th>Name</th>
              <th>Company</th>
              <th>Category</th>
              <th>Handover</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>

          <tbody>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
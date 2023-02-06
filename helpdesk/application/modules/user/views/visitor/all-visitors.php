<?php
  $admin = $this->session->userdata('admin');
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
    <h4 class="text-themecolor">Visitor  List</h4>
  </div>
  
</div>
<div class="row">
  <div class="col-12">
    <div class="card">
    
      <div class="card-body">
    <form class="form-material" id='form-filter'>
        <div class="row">
          
            <div class="col-md-3">
              <label>Visitor Name</label>
              <input type="text" name="vis_name" id="vis_name" class="form-control" placeholder="Search User" autofocus/>
            </div>
            <div class="col-md-3">
              <label>Company Name</label>
              <input type="text" name="company_name" id="company_name" class="form-control" placeholder="Search Company" autofocus/>
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
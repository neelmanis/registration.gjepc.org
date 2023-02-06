<?php
  $admin = $this->session->userdata('admin');
?>

<style>
table{
  margin: 0 auto;
  width: 100%;
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
  color: #200425;
  font-size: 19px;
}

table.dataTable thead .sorting_desc:after {
  content: "\f0dd" !important;
  margin-left: 10px;
  font-family: fontawesome !important;
  cursor: pointer;
  color: #200425;
  font-size: 19px;
}
</style>

<div class="row page-titles">
  <div class="col-md-5 align-self-center">
    <h4 class="text-themecolor">Manage Roles</h4>
  </div>
  <div class="col-md-7 align-self-center text-right">
    <div class="d-flex justify-content-end align-items-center">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo base_url();?>admin/dashboard">Home</a></li>
        <li class="breadcrumb-item active">Manage Roles</li>
      </ol>
    </div>
  </div>
</div>

<div class="col-12">
  <div class="card">
    <div class="card-body">
      <div class="row">
        <div class="col-md-4 col-sm-6 offset-0 offset-md-8">
          <a class="btn btn-block btn-rounded btn-outline-success" href="<?php echo base_url(); ?>admin/roles/add">Create Role</a>  
        </div>
      </div>
    </div>

    <div class="card-body">
      <table id="adminRolesTable" class="table color-table purple-table text-center" cellspacing="0"  width="100%">
        <thead>
          <tr>
            <th>Update</th>
            <th>Delete</th>
            <th>Name</th>
            <th>Date</th>
          </tr>
        </thead>

        <tbody>
        </tbody>
      </table>
    </div>
  </div>
</div>
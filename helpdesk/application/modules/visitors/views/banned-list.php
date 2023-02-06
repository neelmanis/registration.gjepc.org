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
</style>

<div class="row page-titles">
  <div class="col-md-5 align-self-center">
    <h4 class="text-themecolor"><?php echo $breadcrumb;?></h4>
  </div>
  <div class="col-md-7 align-self-center text-right">
    <div class="d-flex justify-content-end align-items-center">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo base_url();?>admin/dashboard">Home</a></li>
        <li class="breadcrumb-item active"><?php echo $breadcrumb;?></li>
      </ol>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <!-- 
        <div class="row">
          <div class="col-md-4 col-sm-6 offset-0 offset-md-8">
            <a class="btn btn-block btn-rounded btn-outline-success" href="<?php echo base_url(); ?>master/status/add">Add Status</a>
          </div>
        </div> -->
      </div>
	  <div class="card-body">
        <table id="bannedTable" class="table color-table purple-table text-center" cellspacing="0" width="100%">
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
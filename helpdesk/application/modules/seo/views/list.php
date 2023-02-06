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

<div class="row justify-content-between page-titles">
  <div class="col-auto align-self-center">
    <h4 class="text-themecolor">SEO</h4>
  </div>
  <div class="col-auto align-self-center text-right">
    <div class="d-flex justify-content-end align-items-center">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo base_url();?>admin/dashboard">Home</a></li>
        <li class="breadcrumb-item active">SEO</li>
      </ol>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-12">
    <div class="card">

      <div class="card-body">
        <table id="seoTable" class="table color-table purple-table text-center" cellspacing="0" width="100%">
          <thead>
            <tr>
              <th>Actions</th>
              <th>Page</th>
              <th>Meta Title</th>
            </tr>
          </thead>

          <tbody>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<style>
table{
  margin: 0 auto;
  width: 100%;
  clear: both;
  border-collapse: collapse;
  table-layout: fixed; 
  word-wrap:break-word; 
}
</style>
<?php
$admin = $this->session->userdata('admin');
?>
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

<div class="col-12">
	<div class="card">
    
    <div class="card-body">
      <table id="DeptTable" class="table table-striped table-bordered text-center" cellspacing="0" width="100%">
        <thead>
          <tr>
            <th>Id</th>
            <th>Dept</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php
  $admin = $this->session->userdata('admin');
  $role = $admin['role'];
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
    <h4 class="text-themecolor">All Tickets</h4>
	<?php if($role == "Super Admin" || $role == "Admin"){ ?>
	<ol class="breadcrumb">
        <li class="btn btn-inline-block btn-primary mr-2"><a href="<?php echo base_url();?>tickets/add">Create Ticket</a></li>
    </ol>
	<?php } ?>
  </div>
  <div class="col-auto align-self-center text-right">
    <div class="d-flex justify-content-end align-items-center">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo base_url();?>admin/dashboard">Home</a></li>
        <li class="breadcrumb-item active ">All Tickets</li>
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
              <label>Ticket ID</label>
              <input type="text" name="unique_code" id="unique_code" class="form-control" maxlength="10" placeholder="Search Ticket ID" autofocus/>
            </div>
            <div class="col-md-3">
              <label>Exhibitor Name</label>
              <input type="text" name="exhibitor_name" id="exhibitor_name" class="form-control" placeholder="Search Exhibitor" autofocus/>
            </div>
            <div class="col-md-3">
                <label>Status</label>
                <select name="statuses" id="statuses" class="form-control"/>
                    <option value="">All Status</option>
                    <?php if($categories !=="NA"){
                      foreach($categories as $cat){ ?>
                      <option value="<?php echo $cat->id; ?>"><?php echo $cat->name; ?></option>
                    <?php } } ?>
                </select>
            </div>
            <div class="col-md-3 mt-3">
                <button type="submit" id="btn-filter" class="btn btn-inline-block btn-primary mr-2"> <i class="icon-refresh"></i> Fetch Tickets</button>
                <button type="submit" id="btn-reset" class="btn btn-inline-block btn-secondary"> </i> Reset</button>                   
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
              <th>Ticket ID</th>
              <th>Exhibitor</th>
              <th>Subject</th>
              <th>Department</th>
              <th>Hall No</th>
              <th>Division </th>
              <th>Status</th>
              <th>Priority</th>
              <th>Date</th>
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
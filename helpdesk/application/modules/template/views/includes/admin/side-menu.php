<?php
  $admin_session = $this->session->userdata('admin');
// echo '<pre>'; print_r($admin_session);
  $role = $admin_session['role'];
?>

<aside class="left-sidebar">
  <div class="scroll-sidebar">
    <nav class="sidebar-nav">
      <ul id="sidebarnav">
      
        <!-- Dashboard -->
        <li>
          <a class=" waves-effect waves-dark" href="<?php echo base_url('admin/dashboard')?>" aria-expanded="false"><i class="ti-bar-chart"></i><span class="hide-menu">Dashboard</span></a>
        </li>

        <!-- Admin -->
        <?php if($role == "Super Admin"){ ?>
        <li>
          <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="ti-id-badge"></i><span class="hide-menu">Admins</span></a>
          <ul aria-expanded="false" class="collapse">
            <li><a class="submenu-name" href="<?php echo base_url(); ?>admin/list"><span class="submenu-name">View All</span></a></li>
            <!--<li><a class="submenu-name" href="<?php echo base_url(); ?>admin/roles/list"><span class="submenu-name">Manage Roles</span></a></li>-->
          </ul>
        </li>
        <li>
          <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="ti-id-badge"></i><span class="hide-menu">Masters</span></a>
          <ul aria-expanded="false" class="collapse">
            <li><a class="submenu-name" href="<?php echo base_url(); ?>statuses/lists"><span class="submenu-name">Status</span></a></li>
            <li><a class="submenu-name" href="<?php echo base_url(); ?>priorities/lists"><span class="submenu-name">Priorities</span></a></li>
            <li><a class="submenu-name" href="<?php echo base_url(); ?>dept/lists"><span class="submenu-name">Department</span></a></li>
          </ul>
        </li>
        <?php } ?>

        <!-- Hall Manager -->
		<li>
          <a class="waves-effect waves-dark" href="<?php echo base_url(); ?>tickets/all_tickets" aria-expanded="false"><i class=" fa fa-ticket"></i><span class="hide-menu">Tickets</span>
          </a>
        </li> 

      </ul>
    </nav>
  </div>
</aside>
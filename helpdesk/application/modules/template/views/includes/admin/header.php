<?php
  $admin_session = $this->session->userdata('admin');
 //echo "----------------"; print_r($admin_session);
  $image = $admin_session['image'];
  $name = $admin_session['contact_name'];
?>

<header class="topbar">
  <nav class="navbar top-navbar navbar-expand-md navbar-dark">
    <div class="navbar-header">
      <!-- <a class="navbar-brand" href="<?php echo base_url('admin/dashboard')?>">
        <b>
          <img src="<?php echo base_url();?>assets/admin/images/adraasSmall.png" class="light-logo logo_sm" />
        </b> 
        <span>
          <img src="<?php echo  base_url();?>assets/admin/images/adraasLarge.png" class="light-logo logo_abs"/>
        </span>
      </a> -->
    </div> 
    <div class="navbar-collapse ">
      <ul class="navbar-nav mr-auto ">
        <li class="nav-item"> <a class="nav-link nav-toggler d-block d-sm-none waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
        <li class="nav-item"> <a class="nav-link sidebartoggler d-none d-lg-block d-md-block waves-effect waves-dark" href="javascript:void(0)"><i class="icon-menu"></i></a> </li>
      </ul>

      <ul class="navbar-nav my-lg-0">
        <li class="nav-item dropdown u-pro">
          <a class="nav-link dropdown-toggle waves-effect waves-dark profile-pic" href="javascript:void(0)" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
           <?php if(!empty($image)){?><img src="<?php echo base_url()?>assets/admin/images/users/<?php echo $image;?>" alt="user" class=""><?php } else { ?><img src="<?php echo base_url()?>assets/admin/images/users/1.jpg" alt="user" class="img-circle"><?php } ?>
            <span class="hidden-md-down"><strong><?php echo strtoupper($name); ?></strong> &nbsp;
            <i class="fa fa-angle-down"></i></span>
          </a>
          <div class="dropdown-menu dropdown-menu-right animated flipInY">
            <!--<a href="<?php echo base_url('admin/my-profile')?>" class="dropdown-item"><i class="ti-settings" style="margin-right: 10px;"></i> My Profile</a>-->
            <div class="dropdown-divider"></div>
            <a href="<?php echo base_url('admin/logout')?>" class="dropdown-item"><i class="ti-power-off" style="margin-right: 10px;"></i> Logout</a> 
          </div>
        </li>
      </ul>
    </div>
  </nav>
</header>
<aside class="left-sidebar">
  <div class="scroll-sidebar">
    <nav class="sidebar-nav">
      <ul id="sidebarnav">
        <!-- Dashboard -->
        <?php if(in_array("5",$rights) ){ ?>
        <li>
          <a class=" waves-effect waves-dark" href="<?php echo base_url('user/dashboard')?>" aria-expanded="false"><i class="ti-bar-chart"></i><span class="hide-menu">Visitor Scan </span></a>
        </li> 
         <?php } ?>
        <?php if(in_array("4",$rights) ){ ?>
        <li>
          <a class=" waves-effect waves-dark" href="<?php echo base_url('user/visitors/add')?>" aria-expanded="false"><i class="ti-user"></i><span class="hide-menu">Add Visitor</span></a>
        </li>
        <li>
          <a class=" waves-effect waves-dark" href="<?php echo base_url('user/visitors/visitor_list')?>" aria-expanded="false"><i class="ti-user"></i><span class="hide-menu">Visitor List</span></a>
        </li>
        <?php } ?>

      </ul>
    </nav>
  </div>
</aside>

<div class="header">
    	<div class="logo"><a href="manual_list.php"><img src="https://registration.gjepc.org/manual_signature/images/LOGO-UNIT.svg" width="350px;" title="Signature" /></a></div>
        <div class="menu"> 			
        <div class="login">
          <?php if(isset($_SESSION['EXHIBITOR_CODE'])){ ?><div class="em">Welcome <span><a href="<?php echo $_SESSION['urls'];?>"><?php echo filter($_SESSION['EXHIBITOR_NAME']);?></a></span> | <a href="logout.php">Logout</a></div><?php } else { ?>
            <div class="em"><a href="index.php">Login</a></div>
            <?php } ?>
        </div>
        <div class="clear"></div>
            <div class="menu_logo"><a href="http://www.gjepc.org" target="_blank"><img src="https://gjepc.org/assets/images/logo.png" /></a> </div>
        </div>
</div>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Adraas</title>

  <style>
  .link_btn {
    padding: 10px 25px;
    text-decoration: none !important;
    background: #d6d6d6;
    color: #000;
  }
  </style>
</head>
<body>
  <div style="margin:0 auto; max-width:700px; width:700px; position:relative; line-height:18px;">
    <table  cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; color:#292b29; width:100%; border:1px solid #619855; border-bottom:4px solid #0aa360; font-size:14px; border-collapse:collapse;">

    <tr>
      <td colspan="2" style="background:#02015e; height:20px;"></td>
    </tr>

    <tr >
      <td style="padding:30px 30px 30px 30px;" >
        <img src="<?php echo base_url(); ?>assets/web/images/logo-footer.png" alt="" style="padding: 6px 25px; position:relative;"> 
      </td>
    </tr>

    <tr>
      <td style="padding:30px 30px 30px 30px;">
        <p ><strong>Dear <?php echo $name; ?></strong></p>
        <br />

        <p style="color:#02015e; font-size: 14px;">You are nominated for appointment as an arbitrator for Arbitration Case ID <strong><?php echo $case_Id; ?></strong> </p>

        <p> To view case details, sign conflict disclosure form and confirm/deny nomination, login to your acount by clicking here.  <button ><a href="<?php echo $info_link; ?>">here</a></button></p>
        
        <p>We hope you like the Adraas experience!</p>

        <br>
        <p>Regards,</p>
        <p><strong>Adraas</strong> </p>
      </td>
    </tr>
    
    <tr style="background:#72a268; color:#fff;"></tr>
  </table>
</div>

</body>
</html>

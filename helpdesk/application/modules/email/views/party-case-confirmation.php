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

    <tr style="">
      <td style="padding:30px 30px 30px 30px;">
        <img src="<?php echo base_url(); ?>assets/web/images/logo-footer.png" alt="" style="padding: 6px 25px; position:relative;"> 
      </td>
    </tr>

    <tr>
      <td style="padding:30px 30px 30px 30px;">
        <p style=""><strong>Hello <?php echo $name; ?></strong></p>
        <br />
        <p style=" font-size: 14px;">Welome to Adraas! </p>
        <p style=" font-size: 14px;"><?php echo $assigner; ?> has registered you as <?php echo $role; ?> for the <?php echo $party; ?> in Arbitration Case ID No. <?php echo $case_id; ?></p>
        <p style=" font-size: 14px;">To manage and monitor the case, log on to https://adraas.com using:</p>
        <p style=" font-size: 14px;">We hope you like the Adraas experience!</p>
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

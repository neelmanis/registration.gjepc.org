<?php 

 $html = '

<!doctype html>
<html style="margin:0; padding:0; box-sizing:border-box;">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>

  <body style="margin:0; padding:0; ">
    
    <table cellpadding="0" cellspacing="0" width="100%" style="font-size:12px; font-family:Arial, Helvetica, sans-serif;">

      <tbody style="height:100%">
        
        <tr>
          <td style="width: 50%; border:5px solid '.$color_code.';height:553.7px;overflow:hidden;" valign="top">
            <div style="height:553.7px; position:relative">
              <table cellpadding="8" cellspacing="0" style="width: 100%;">
                <tbody>
                  <tr style="background:#f2f2f2; height: 50px;">
                    <td align="left">
                      <img src="https://scanapp.kwebmakerdigitalagency.com/assets/images/iijs_logo.png" style="max-width: 100px;">
                    </td>
                    <td align="right">
                      <img src="https://scanapp.kwebmakerdigitalagency.com/assets/images/gjepc_logo.png" style="max-width: 85px;">
                    </td>
                  </tr>
                  <tr>
                    <td align="center">
                        <img src="'.$photo_url.'" style="max-height:160px; max-width: 160px; display:table; margin:0 auto;" alt="">
                    </td>
                    <td>
                      <img src="'.$qr_code.'" style="max-height:128px; max-width: auto;" alt="">
                    </td>
                  </tr>
                  <tr>
                    <td style="width:50%;">
                        <h3 style="font-weight: bold; letter-spacing: 1px; font-size: 16px; color: #000;">
                          '.strtoupper($name).'</h3>
                        <p style="font-size: 14px; font-weight: bold;">'.strtoupper($company).'</p>
                        <p style="font-size: 13px; font-weight: bold;">'.strtoupper($designation).'</p>
                        <p style="font-size: 13px; font-weight: bold;">'.strtoupper($location).'</p>
                    </td>
                    <td style="width:50%;vertical-align: baseline;">
                      <h3 style="font-size: 13px;">'.strtoupper($uniqueIdentifier).'</h3>
                      
                      <p style="font-size: 13px;"><b>Vaccination status<b></p>
                      <img src="https://scanapp.kwebmakerdigitalagency.com/assets/images/heart.jpg" style="width:40px;">
                    </td>
                  </tr>
                  
                  
                </tbody>
              </table>
              '.$no_entry_title.'

             
                <div style="background: '.$color_code.'; width:100%; color:'.$color_text.'; padding:10px 0; position:absolute; bottom:0; text-align:center">
                  <strong style="font-size: 30px;">'.strtoupper($category).'</strong><br>
                  <p style="font-size: 28px; margin: 0; font-size: 20px; ">'.strtoupper($category_name).'</p>
                </div>
                
             

            </div>
          </td>
          <td style="width: 50%; height:553.7px; border:5px solid '.$color_code.';">
            <div style="height:553.7px; position:relative">

              <table cellpadding="8" cellspacing="0" style="width: 100%;">
                <tr style="background:#f2f2f2; height: 50px;">
                  <td align="left">
                    <img src="https://scanapp.kwebmakerdigitalagency.com/assets/images/iijs_logo.png" style="max-width: 100px;">
                  </td>
                  <td align="right">
                    <img src="https://scanapp.kwebmakerdigitalagency.com/assets/images/gjepc_logo.png" style="max-width: 85px;">
                  </td>
                </tr>
              </table>

              <div style="margin-top:30px; text-align:center ">
              '.$show_timing.'
              '.$title_iijs.'
              '.$icons_images.'
              </div>

              <div style="background: '.$color_code.'; width:100%; color:'.$color_text.'; padding:22.5px 0; position:absolute; bottom:0; text-align:center">
                <p style="font-size: 15px;margin: 0px;"><b>Toll Free Number: 1800-103-4353</b></p>
                <p style="font-size: 15px;margin: 0px;"><b>Missed call Number: +91-7208048100</b></p>
              </div>


            </div>
          </td>
        </tr>
        
        <tr>

          <td align="center" style="width: 50%; border:5px solid '.$color_code.'; height:553.7px; overflow:hidden" valign="middle">

            <div style="overflow:hidden;">
              <img src="https://scanapp.kwebmakerdigitalagency.com/assets/images/gold_star.png"/>
              <h3>BLOCK THE DATES</h3>
              <img src="https://scanapp.kwebmakerdigitalagency.com/assets/images/SHOWLOGOS.jpg" style="width:350px; margin:0 auto; display:table; text-align:center">
              
              

              <h3 style="color:#a89c5d; font-size: 18px;">GET THE APP</h3>

              <p style="color:#a89c5d">Scan the below QR code to download the GJEPC App</p>

              <table width="100%" cellspacing="0" cellpadding="0">

                <tr>

                  <td align="center">
                    <div style="margin-bottom:5px">
                      <img src="https://scanapp.kwebmakerdigitalagency.com/assets/images/android.png">
                    </div>
                    <div>
                      <img src="https://scanapp.kwebmakerdigitalagency.com/assets/images/ios.png">
                    </div>
                  </td>

                  <td><img src="https://scanapp.kwebmakerdigitalagency.com/assets/images/qr.png" width="100px"/></td>

                </tr>

              </table>

            </div>

          </td>

          <td style="width: 50%; border:5px solid '.$color_code.'; height:549px" valign="top">

            <div>

              <table width="100%" cellspacing="0" cellpadding="10">

                <tr>
                  <td>
                    <h3 style="font-size: 18px;color: #a89c5d; margin-bottom:0px;padding:0px;">Rules & Regulations</h3>
                  </td>
                  <td align="right"><img src="https://scanapp.kwebmakerdigitalagency.com/assets/images/rules_qr.jpeg" style="width:70px;">
                  <p style="font-size:10px; display:table; margin: 0 0 0 auto; text-align:center">Scan QR Code</p></td>
                </tr>

                
              
              </table>
              '.$rules.'

            </div>
          
          </td>

        </tr> 
    
      </tbody>
        
    </table>
    
  </body>

</html>';

echo $html;exit;

?>
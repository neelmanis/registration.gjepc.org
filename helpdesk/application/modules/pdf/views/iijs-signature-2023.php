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
          <td style="width: 50%;">
            <div style="border:5px solid '.$color_code.';height:551px;overflow:hidden; position:relative">
              <table cellpadding="8" cellspacing="0" style="width: 100%;">
                <tbody>
                  <tr style="background:#f1f1f1; height: 50px;">
                    <td align="left">
                      <img src="'.$show_logo.'" style="max-width: 200px;">
                    </td>
                    <td align="right">
                      <img src="https://gjepc.org/iijs-premiere/assets/images/gjepc_logo.png" style="max-width: 85px;">
                    </td>
                  </tr>
                  <tr>
                    <td align="center">
                        <img src="'.$photo_url.'" style="max-height:160px; max-width: auto; display:table; margin:0 auto;" alt="">
                    </td>
                    <td>
                      <img src="'.$file.'" style="max-height:128px; max-width: auto;" alt="">
                    </td>
                  </tr>
                  <tr>
                    <td style="width:50%;">
                        <h3 style="font-weight: bold; letter-spacing: 1px; font-size: 20px; color: #000;">
                        '.$name.'</h3>
                        <p style="font-size: 20px; font-weight: bold; text-transform:uppercase;">'.$company.'</p>
                        <p style="font-size: 13px; font-weight: bold; text-transform:uppercase;">'.$designation.'</p>
                        <h3 style="font-size: 13px;">'.$uniqueIdentifier.'</h3>
                        
                    </td>';
                  // ONE EARTH INITIATIVE  TABLE
                  $html .= $one_earth; 

                  $html .='</tr>
                  <tr>
                    <td colspan="2" align="center">
                    <div style="background:'.$color_code.'; padding:10px 0;  color: '.$color_text.'; width:100%; left:0; position:absolute; bottom:0;">
                      <strong style="font-size: 28px;">'.$category.'</strong><br>
                      <p style="font-size: 28px; margin: 0; font-size: 20px; text-transform:uppercase;">'.$category_name.'</p>
                    </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </td>
          <td style="width: 50%;">
            <div style="border:5px solid '.$color_code.'; height:551px; position:relative">
              <div style="width:100%; position:absolute; top:50%; transform:translateY(-50%)">
                <table cellpadding="8" cellspacing="0" style="width: 100%;">
                  <tbody>
                    <tr>
                      <td style="text-align:center;"> 
                        <img src="'.$show_logo.'" style="width: 250px;">
                      </td>
                    </tr>
                    <tr>
                      <td style="text-align:center;">
                        <div style="margin:10px 0">
                          <img src="https://gjepc.org/iijs-signature/assets/images/visitor_badges/grey_icon/01.png" style="width: 25px;height: auto;margin-left:5px" alt="">
                          <img src="https://gjepc.org/iijs-signature/assets/images/visitor_badges/grey_icon/02.png" style="width: 25px;height: auto;margin-left:5px" alt="">
                          <img src="https://gjepc.org/iijs-signature/assets/images/visitor_badges/grey_icon/03.png" style="width: 25px;height: auto;margin-left:5px" alt="">
                          <img src="https://gjepc.org/iijs-signature/assets/images/visitor_badges/grey_icon/04.png" style="width: 25px;height: auto;margin-left:5px" alt="">
                          <img src="https://gjepc.org/iijs-signature/assets/images/visitor_badges/grey_icon/05.png" style="width: 25px;height: auto;margin-left:5px" alt="">
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td align="center" style="background: '.$color_code.'; color:'.$color_text.'">
                        <p style="font-size: 15px;margin: 0px;"><b>Toll Free Number: 1800-103-4353</b></p>
                        <p style="font-size: 15px;margin: 0px;"><b>Missed call Number: +91-7208048100</b></p>
                      </td>
                    </tr>
                    <tr>
                      <td style="text-align:center">
                        <div style="margin-top:10px;">
                          <table cellpadding="0" cellspacing="0" align="center" style="background:#f2f2f2; padding:10px 20px">
                            <tr>
                              <td colspan="2" align="center">
                                <h3 style="font-size:14px; margin-bottom:10px">ENTRY INTO EXHIBITION HALL</h3>';
                                $html .= $show_timing;
                                $html .= '</td>
                            </tr>
                          </table>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td style="text-align:center">
                        <img src="https://gjepc.org/iijs-premiere/assets/images/gjepc_logo.png" style="max-width: 200px;">
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
          </td>
        </tr>
        <tr>
          <td align="center" style="width: 50%;">
            <div style="border:5px solid '.$color_code.'; height:551px; position:relative;">
              <div style="position:absolute; top:50%; left:10px; right:10px; transform:translateY(-50%)">
                <img src="https://gjepc.org/assets/images/gold_star.png"/>
                <h3>BLOCK THE DATES</h3>
                <img src="images/signature23_badge_assets/iijs-tritiya.jpg" style="width:150px; margin-bottom:15px;">';
                 // Rates Table
                $html .= $rates_table;
                $html .='<h3 style="color:#a89c5d; font-size: 18px;">GET THE APP</h3>
                <p style="color:#a89c5d">Scan the below QR code to download the GJEPC App</p>
                <table width="100%" cellspacing="0" cellpadding="0">
                  <tr>
                    <td align="center">
                      <div style="margin-bottom:5px">
                        <img src="https://gjepc.org/assets/images/android.png">
                      </div>
                      <div>
                        <img src="https://gjepc.org/assets/images/ios.png">
                      </div>
                    </td>
                    <td><img src="https://gjepc.org/assets/images/qr.png" width="100px"/></td>
                  </tr>
                </table>
              </div>
            </div>
          </td>
          <td style="width: 50%;">
            <div style="border:5px solid '.$color_code.'; height:551px">
              <table width="100%" cellspacing="0" cellpadding="10">
                <tr>
                  <td>
                    <h3 style="font-size: 18px;color: #a89c5d; margin-bottom:0px;padding:0px;">Rules & Regulations</h3>
                  </td>
                  <td align="right"><img src="images/signature23_badge_assets/rules_qr.jpeg" style="width:70px;"/></td>
                </tr>
                <tr>
                  <td colspan="2">';
                    $html .=$rules;
                    $html .= '</td>
                </tr>
              </table>
            </div>
          </td>
        </tr> 
      </tbody>
    </table>
  </body>
</html>

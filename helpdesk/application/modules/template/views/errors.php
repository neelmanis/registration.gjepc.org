<!doctype html>
<html lang="en" class="no-js">
<head>
	<meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo $global['web_assets']; ?>images/favicon-32x32.png">
  <title>AJVA Saarthi</title>
  <style> 
    @import url('https://fonts.googleapis.com/css?family=Roboto:300,400,500,700');
    *{ margin:0px; padding:0px; }
    .clear { clear:both; } 
    html, body { line-height: 23px; font-family: 'Roboto', sans-serif; background:#eee;  }
    .top_patch { width:100%; height:4px; background:red; position:absolute; top:0px;  }
    .main_wrapper { width:80%; background:#6699CC; margin:5% auto; margin-top:15%; color:#fe0000; }
    .main_wrapper .left_wpr { width:50%; float:left; text-align:center; }
    .main_wrapper .left_wpr h1 { font-size:150px; display:block; margin:0px; padding:0px; text-align:center;  font-family: 'Roboto', sans-serif;  }
    .main_wrapper .left_wpr h2 { font-size:20px;  font-family: 'Roboto', sans-serif; margin-top:50px; color:#000; }
    .main_wrapper .left_wpr h4 { font-size:20px;  font-family: 'Roboto', sans-serif;  margin-top:70px; }
    .main_wrapper .right_wpr { width:40%; float:right;   }
    .main_wrapper .right_wpr b { font-weight:bold; color:#333; margin-bottom:20px; }
    ul.list_style { margin:0px; padding:0px; margin-top:20px; }
    .list_style li { width:100%; margin-bottom:10px; list-style:none;  }
    .list_style li a { background: #a1db55; color: #fff; display: block; text-decoration: none; padding:10px; list-style:none; width: 300px; text-align: center;  }
    .list_style li a:hover { background:#2e3192; color:#fff; }
    @media (max-width:768px){
    .main_wrapper { width:100%; margin:1% auto; margin-top:1%; }
    .main_wrapper .left_wpr { width:100%; margin-top: 50px; }
    .main_wrapper .left_wpr h1 { font-size: 100px; }
    .main_wrapper .left_wpr h4 { font-size:16px; margin-top: 30px; }
    .main_wrapper .right_wpr { width:100%;   }
    .main_wrapper .right_wpr b { float: initial; display: table; margin: 20px auto; }
    .list_style li a { text-align: center; width: 80%; margin: 0px auto; }
    }
  </style> 
  </head>
  <body>
    <div class="top_patch"></div>
    <?php 
      $path = $module. '/' . $viewFile;
      echo $this->load->view($path);  
    ?>
  </body>
</html>
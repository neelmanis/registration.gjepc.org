<?php

$configs = include('./config.php');
$queryUrl = API_URL . "/detect";

//print_r($_POST);
$request = curl_init($queryUrl);
// set curl options
curl_setopt($request, CURLOPT_POST, true);
curl_setopt($request,CURLOPT_POSTFIELDS, $_POST["image_file"]);
curl_setopt($request, CURLOPT_HTTPHEADER, array(
        "Content-type: application/json",
        "app_id:" . APP_ID,
        "app_key:" . APP_KEY
    )
);
curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($request);


curl_close($request);

$response = json_decode($response,true);
 // echo "<pre>";  print_r($response);

if(isset($response['Errors'])){
        $message = $response['Errors'][0]['Message'];
        echo json_encode(array("status"=>"error","message"=>$message));exit;   


}else{
        $images = $response['images'][0];

       
        $faces = $images['faces'];
        $countFaces = count($faces);
        if($countFaces > 1){
              $message = "Please capture single image only.";   
              echo json_encode(array("status"=>"error","message"=>$message));exit;   

        }else{
                $attributes =  $faces[0]['attributes'];
                
                $quality =     $faces[0]['quality'] ;
                $topLeftX =     $faces[0]['topLeftX'];
                $topLeftY =     $faces[0]['topLeftY'];

                if($quality < 0.8 ){
                       $message = "Please take proper photo"; 
                       echo json_encode(array("status"=>"error","message"=>$message));exit;   

                }

                $isMobile= preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);

                if($isMobile){
                        if($topLeftX < 100){
                               $message = "Please align your face in center";  
                               echo json_encode(array("status"=>"error","message"=>$message."_".$topLeftX));exit;   

                        }
                        if($topLeftX > 170){
                               $message = "Please align your face in center";  
                               echo json_encode(array("status"=>"error","message"=>$message."_".$topLeftX));exit;   

                        }   

                }else{
                        if($topLeftX < 150){
                               $message = "Please align your face in center";  
                               echo json_encode(array("status"=>"error","message"=>$message."_".$topLeftX));exit;   

                        }
                        if($topLeftX > 290){
                               $message = "Please align your face in center";  
                               echo json_encode(array("status"=>"error","message"=>$message."_".$topLeftX));exit;   

                        }  
                }
               

                echo json_encode(array("status"=>"success","message"=>"Image Captured successfully"."_".$topLeftX));exit;   


        }


}
// echo $message;




?> 
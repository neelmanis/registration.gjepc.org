
                <style type="text/css">
                    .video_container{
                        position: relative;
                        height: auto;
                        width: 100%;
                    }
                    .video_preview{
                        height: 390px;
                        width: 100%;
                    }
                    .badge_photo{
                        max-width: 130px;
                        max-height: auto;
                    }

 
 .outer-div, .inner-div {
     height: auto;
     max-width: 100%;
     margin: 0 auto;
     position: relative;
}
 .outer-div {
     padding: 10px;
     perspective: 900px;
     perspective-origin: 50% calc(50% - 18em);
}
 .inner-div {
     margin: 0 auto;
     border-radius: 5px;
     font-weight: 400;
     color: #071011;
     font-size: 1rem;
     text-align: center;
     transition: all 0.6s cubic-bezier(0.8, -0.4, 0.2, 1.7);
     transform-style: preserve-3d;
}
 .front {
    position: relative;
     top: 0;
     left: 0;
     backface-visibility: hidden;
     cursor: pointer;
     height: 400px;
     background: #fff;
     backface-visibility: hidden;
     border-radius: 5px;
     box-shadow: 0 15px 10px -10px rgba(0, 0, 0, 0.5), 0 1px 4px rgba(0, 0, 0, 0.3), 0 0 40px rgba(0, 0, 0, 0.1) inset;
}
 .front__bkg-photo {
     position: relative;
     height: 120px;
     width: 100%;
     background: #343a40;
     background-size: cover;
     backface-visibility: hidden;
     overflow: hidden;
     border-top-right-radius: 5px;
     border-top-left-radius: 5px;
}
 .front__bkg-photo:after {
     content: "";
     position: absolute;
     top: 0;
     left: 0;
     height: 100%;
     width: 100%;
}
 .front__face-photo {
     position: relative;
     top: -85px;
     height: 140px;
     width: 140px;
     margin: 0 auto;
     border-radius: 50%;
     border: 5px solid #fff;

     background-size: contain;
     overflow: hidden;
}
 .front__text {
     position: relative;
     top: -75px;
     margin: 0 auto;
     font-family: "Montserrat";
     font-size: 18px;
     backface-visibility: hidden;
}
 .front__text .front__text-header {
     font-weight: 700;
     font-family: "Oswald";
     text-transform: uppercase;
     font-size: 20px;
}
 .front__text .front__text-para {
     position: relative;
     top: -5px;
     color: #000;
     font-size: 14px;
     letter-spacing: 0.4px;
     font-weight: 400;
     font-family: "Montserrat", sans-serif;
}
 .front__text .front-icons {
     position: relative;
     top: 0;
     font-size: 14px;
     margin-right: 6px;
     color: gray;
}

 
                </style>
                <div class="row m-t-20 justify-content-center">
                    
                    <div class="col-lg-3 col-md-6 col-6">
                        <div class="card mb-2 h-100">
                            <div class="p-2">
                                <h5 class="card-title text-center">Select Zone</h5>
                                <div class="d-flex no-block align-items-center ">
                                <select class="selectpicker form-control" name="zone" id="zone"  data-style="btn-success">
                                    <option value="" >Select Zone</option>
                                    <?php if($zones !=="NA"){
                                        foreach ($zones as $zone) {
                                            
                                        
                                         ?>
                                           <option <?php if($userDetails[0]->current_zone == $zone->name ){ echo "selected"; } ?> value="<?php echo $zone->name; ?>"><?php echo $zone->description; ?></option>
                                       <?php }
                                    }?>
                                </select>
                                    
                                </div>
                            </div>
                            
                        </div>
                    </div> 
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6 col-6">
                        <div class="card mb-2 h-100">
                            <div class="p-2">
                                <h5 class="card-title text-center">Check-In/Out</h5>
                                <div class="d-flex no-block align-items-center ">
                                <select  class="selectpicker form-control" name="device_type" id="device_type" data-style="btn-success">
                                   <option  value=""> Select Device Type</option>
                                   <option <?php if($userDetails[0]->device_type =="check_in"  ){ echo "selected"; } ?>  value="check_in"> Check In</option>
                                   <option <?php if($userDetails[0]->device_type =="check_out"  ){ echo "selected"; } ?> value="check_out"> Check Out</option>
                                </select>
                                    
                                </div>
                            </div>
                           
                        </div>
                    </div> 
                    <!-- Column -->
                    
                </div>
                <div class="row  justify-content-center m-t-20">
                    <div class="col-12">
                      <div id="qr-reader" style="max-width: 400px"></div>
                    </div>
                </div>
                
                <div class="row  justify-content-center m-t-20">
                    <div class=" col-md-6 col-12">
                        <div class="card mb-0 h-100">
                            <div class="pb-2">
                                <div class="row">
                                   <!--  <div class="col-sm-12 pb-2">
                                        <div class="video_container front pt-1 pb-1"  >
                                            <div   id="video_preview" class="h-100 d-flex flex-column justify-content-center  text-center  align-items-center ">
                                                <img src="<?php //echo  base_url("assets/admin/images/scanning.png?v=1");?>" class="img-fluid mt-5"  />
                                                <h3 class="front__text-header" >Scan Badge QR Code here</h3>
                                               
                                            </div>
                                            <video id="preview" class="video_preview" ></video>
                                        </div>
                                    </div> -->
                                    <div class="col-sm-12">
                                        <div class="outer-div" id="scan_preview"  style="display:none">
                                          <div class="inner-div">
                                            <div class="front">
                                                <div class="front__bkg-photo"></div>
                                                <img src="" class="front__face-photo" id='vis_photo_url' />
                                                <div class="front__text">
                                                <h3 class="front__text-header" id="vis_name"></h3>
                                                <p class="front__text-para" id="vis_company"></p>
                                                <div class="box bg-info text-center m-t-20 w-100">
                                                    <h1 class=" text-white" id="vis_category"></h1>
                                                    <h6 class="text-white" id="vis_description"></h6>
                                                </div>
                                                <div class="col-md-12 col-sm-12  text-center" id="response_message_section">
                                                        
                                                        <h5 class="card-title m-b-0" id="response_message"></h5> 
                                                </div>

                                                </div>
                                            </div>
                                          </div>
                                        </div>
                                        <button id="scan" class="btn btn-primary d-block p-3 text-center ml-auto mr-auto "><i class="fa fa-search"> </i> Scan</button>
                                    </div>

                                   

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
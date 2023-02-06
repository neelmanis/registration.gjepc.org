
<?php //echo $arbitrators; ?>
<?php  if ($arbitrators !== "NA") {

   foreach ($arbitrators as $arbitrator) {
      $professional_details = unserialize($arbitrator->professional_details);
      if (isset($professional_details['professional_experience'])) {
         $professional_experience = $professional_details['professional_experience'];
      } else {
         $professional_experience = "";
      }
      if (isset($professional_details['professional_experience'])) {
         $arbitration_experience = $professional_details['arbitration_experience'];
      } else {
         $arbitration_experience = "";
      }
      if (isset($professional_details['professional_experience'])) {
         $no_of_arbitrations_counsel = $professional_details['no_of_arbitrations_counsel'];
      } else {
         $no_of_arbitrations_counsel = "";
      }
      if (isset($professional_details['professional_experience'])) {
         $no_of_arbitrations_arbitrator = $professional_details['no_of_arbitrations_arbitrator'];
      } else {
         $no_of_arbitrations_arbitrator = "";
      }
   ?>
<div class="boxType1 tabType5 boxType7">
   <div class="paraType5">Registered Arbitrators </div>
      <div class="tab-content" id="myTabContent">
         <div class="tab-pane fade active show" id="select-arbitrator" role="tabpanel" aria-labelledby="select-arbitrator-tab">
            <div class="card">
               <div class="card-body">
                  <div class="row">
                     <div class="col-md-12">
                        <div class="table-responsive" style="clear: both;">
                           <form id="arbitration-selection">
                              <table class="table table-hover color-table info-table">
                                 <thead>
                                    <tr>
                                       <th colspan="3"> Registered Arbitrators</th>
                                    </tr>
                                 </thead> 
                                 <tody>
                                    <tr class="lightGrayBg">
                                       <div class="">
                                          <td width="30%" class="title">
                                             <div class="">
                                                <div class="arbitDetails">
                                                   <?php if ($arbitrator->photo !== "" && !empty($arbitrator->photo)) { ?>
                                                      <img src="<?php echo $global['upload_path']; ?>user_uploads/<?php echo  $arbitrator->registration_id . '/' . $arbitrator->photo; ?>" alt="User Details" class="w-100 img-fluid r5">
                                                   <?php } else { ?>
                                                      <img src="<?php echo $global['web_assets']; ?>images/pro_pic.jpg" alt="User Details" class="w-100 img-fluid r5">
                                                   <?php } ?>
                                                </div>
                                             </div>
                                          </td> 
                                          <td>  
                                             <div class="col-md-9">
                                                <div class="form-group">
                                                   <label class="labelType1 mb-2"><?php echo $arbitrator->name; ?>
                                                      <?php if (!empty($arbitrator->location)) { ?>
                                                         <span class="pl-1 pr-1">|</span>
                                                         <span><?php echo $arbitrator->location; ?></span>
                                                      <?php } ?>
                                                      <?php if (!empty($arbitrator->email !== "")) { ?>
                                                         <span class="pl-1 pr-1">|</span>
                                                         <span><?php echo $arbitrator->email; 
                                                               ?></span>
                                                      <?php } ?>
                                                   </label>
                                                   <span class="pull-right">
                                                      <div class="topSet1">
                                                         <input id="arbitrator-<?php echo $arbitrator->registration_id; ?>" class="checkbox-custom" name="arbitrator[]" value="<?php echo $arbitrator->registration_id; ?>" <?php echo (in_array($arbitrator->registration_id, $selected_arbitrators) ? "checked" : "") ?> type="checkbox">
                                                         <label for="arbitrator-<?php echo $arbitrator->registration_id; ?>" class="checkbox-custom-label"></label>
                                                      </div>
                                                   </span>
                                                   <div class="tbb mb-3"></div>
                                                   <div class="paraType8 mb-2">
                                                      <?php echo  $arbitrator->more_info; ?>
                                                   </div>
                                                   <div class=" align-items-center mb-2">
                                                      <!-- <button type="button" class="btn btn-success"><a target="_blank" href="<?php echo base_url("institution/profile/arbitratorDetails/" . $arbitrator->registration_id) ?>" class="btnType1 btn small7 mr-4">
                                                         READ MORE
                                                      </a></button> -->
                                                      <!-- <div class="row">
                                                         <div class="col-md-6">
                                                            <div class="paraType8 mb-2">
                                                            <span class="fw500">Professional Experience:</span>
                                                            <?php //if (is_array($professional_experience)) {
                                                               //foreach ($professional_experience as $pe) {
                                                                  // if ($pe !== "") {
                                                                     //echo $pe . ", ";
                                                                  // }
                                                               // }
                                                            //} ?>
                                                            </div>
                                                         </div>
                                                         <div class="col-md-6">
                                                            <div class="paraType8 mb-2">
                                                               <span class="fw500">Arbitration experience :</span> <?php //echo $arbitration_experience . " Years"; ?>
                                                            </div>
                                                         </div>
                                                         <div class="col-md-6">
                                                            <div class="paraType8 mb-2">
                                                               <span class="fw500">No of Arbitrations (Counsel) :</span> <?php //echo $no_of_arbitrations_counsel; ?>
                                                            </div>
                                                         </div>
                                                         <div class="col-md-6">
                                                            <div class="paraType8 mb-2">
                                                               <span class="fw500">No of Arbitrations (Arbitrator) :</span> <?php echo $no_of_arbitrations_arbitrator; ?>
                                                            </div>
                                                         </div>
                                                      </div>       -->
                                                   </div>
                                                </div>
                                             </div> 
                                             <?php }  } ?>
                                          </td>
                                       </div>    
                                    </tr>
                                    <tr>
                                       <td>
                                          <div class="row">
                                             <div class="col-12">
                                                <label class="error" for="arbitrator[]"></label>
                                             </div>
                                             <div class="col-12 mt-3">
                                                <div class="text-left">
                                                   <?php $_SESSION["token"] = md5(uniqid(mt_rand(), true)); ?>
                                                   <input type="hidden" name="enc_data" id="enc_data" value="<?php echo $enc_data; ?>">
                                                   <input type="hidden" name="csrfToken" id="csrfreg" value="<?php echo $_SESSION["token"]; ?>">
                                                   <a href="<?php echo base_url(); ?>cases/list" class="btnType1 Green1 mr-3 btn btn-dark" onclick="goBack()">Back</a>

                                                   <?php if ($institution_case_status == "1") { ?>
                                                      <button type="submit" class="btnType1 mr-3 btn btn-success"> Appoint</button>
                                                   <?php } ?>
                                                </div>

                                             </div>
                                          </div>
                                       </td>
                                    </tr>
                                 </tbody> 
                              </table>
                           </form>  
                        </div>   
                     </div>
                  </div>
               </div>   
            </div>       
         </div>
      </div>
   </div>
</div>
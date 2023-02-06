<!-- <style>
  .title {
    font-size: 14px;
    font-weight: 600;
  }

  .details {
    font-size: 14px;
    font-weight: 400;
  }

  .badge-success {
    color: #fff;
    font-size: 11px;
    background-color: #096f56;
  }

  .badge-warning {
    color: #3a1010;
    font-size: 11px;
    background-color: #fec107;
  }

  .badge-danger {
    color: #fff;
    font-size: 11px;
    background-color: #d02013;
  }

  .status-selector{
    width: 50%;
  }
</style> -->

<div class="row">
  <div class="col-lg-12 mt-4">
    <div class="card">
    
      <div class="card-body">
       
          
            <div class="row">
              <div class="col-md-12">

                <div class="table-responsive" style="clear: both;">
                  <table class="table table-hover color-table info-table">
                    <thead>
                      <tr>
                        <th colspan="3">Case Details</td>
                      </tr>
                    </thead>

                    <tbody>
                      <tr class="lightGrayBg" style="display: none;">
                        <td width="30%" class="title">Case Id</td>
                        <td width="5%" class="title"><stron>:</stron></td>
                        <td width="65%" class="details" id="case_id"><?= $cases[0]->id; ?></td>
                      </tr>
                      <tr class="lightGrayBg">
                        <td width="30%" class="title">Status</td>
                        <td width="5%" class="title"><stron>:</stron></td>
                        <td width="65%" class="details">
                        <?php
                          //echo $cases[0]->status == 'active' ? '<span class="badge badge-success">ACTIVE</span>' : ( $cases[0]->status == 'closed' ? '<span class="badge badge-info">CLOSED</span>' : '<span class="badge badge-danger">INACTIVE</span>' );
                          echo $isStatus != "1" ? '<span class="badge badge-success">ACTIVE</span>' : '<span class="badge btn-dark">CLOSED</span>' ;
                        ?>
                        </td>
                      </tr>

                      <tr class="lightGrayBg">
                        <td width="30%" class="title">Serial Number</td>
                        <td width="5%" class="title"><stron>:</stron></td>
                        <td width="65%" class="details"><?= $cases[0]->serial_no; ?></td>
                      </tr>

                      <tr class="lightGrayBg">
                        <td width="30%" class="title">Brief Description</td>
                        <td width="5%" class="title"><stron>:</stron></td>
                        <td width="65%" class="details"><?= $details[0]->description ; ?></td>
                      </tr>

                      <tr class="lightGrayBg">
                        <td width="30%" class="title">More Description</td>
                        <td width="5%" class="title"><stron>:</stron></td>
                        <td width="65%" class="details"><?= $details[0]->more_description ; ?></td>
                      </tr>

                      <tr class="lightGrayBg">
                        <td width="30%" class="title">Type of Arbitration</td>
                        <td width="5%" class="title"><stron>:</stron></td>
                        <td width="65%" class="details"><?= $details[0]->arbitration_type; ?></td>
                      </tr>

                      <tr class="lightGrayBg">
                        <td width="30%" class="title">Arbitration</td>
                        <td width="5%" class="title"><stron>:</stron></td>
                        <td width="65%" class="details"><?= $details[0]->arbitration_number; ?></td>
                      </tr>

                      <tr class="lightGrayBg">
                        <td width="30%" class="title">Paid</td>
                        <td width="5%" class="title"><stron>:</stron></td>
                        <td width="65%" class="details"><?= $details[0]->isPaid; ?></td>
                      </tr>

                      <tr class="lightGrayBg">
                        <td width="30%" class="title">Amount Paid</td>
                        <td width="5%" class="title"><stron>:</stron></td>
                        <td width="65%" class="details"><?= $details[0]->amount_paid; ?></td>
                      </tr>

                      <tr class="lightGrayBg">
                        <td width="30%" class="title">Seat</td>
                        <td width="5%" class="title"><stron>:</stron></td>
                        <td width="65%" class="details"><?= $details[0]->seat; ?></td>
                      </tr>

                      <tr class="lightGrayBg">
                        <td width="30%" class="title">Venue</td>
                        <td width="5%" class="title"><stron>:</stron></td>
                        <td width="65%" class="details"><?= $details[0]->venue; ?></td>
                      </tr>

                      <tr class="lightGrayBg">
                        <td width="30%" class="title">Currency</td>
                        <td width="5%" class="title"><stron>:</stron></td>
                        <td width="65%" class="details"><?= $details[0]->currency; ?></td>
                      </tr>

                      <tr class="lightGrayBg">
                        <td width="30%" class="title">Claim value</td>
                        <td width="5%" class="title"><stron>:</stron></td>
                        <td width="65%" class="details"><?= $details[0]->claim_value; ?></td>
                      </tr>

                      <tr class="lightGrayBg">
                        <td width="30%" class="title">Counter Claim value</td>
                        <td width="5%" class="title"><stron>:</stron></td>
                        <td width="65%" class="details"><?= $details[0]->counter_claim_value; ?></td>
                      </tr>
                      
                      <tr class="lightGrayBg">
                        <td width="30%" class="title">Total Claim value</td>
                        <td width="5%" class="title"><stron>:</stron></td>
                        <td width="65%" class="details"><?= $details[0]->total_claim_value; ?></td>
                      </tr>

                      <tr class="lightGrayBg">
                        <td width="30%" class="title">Modified By</td>
                        <td width="5%" class="title"><stron>:</stron></td>
                        <td width="65%" class="details"><?= $modify_by == "NA" ? "" : $modify_by[0]->name; ?></td>
                      </tr>
 
                    </tbody>

                    <?php 
                      $documents = unserialize($details[0]->documents);
                      // echo var_dump($documents);

                      $contract = $documents['contract'];
                      $agreement = $documents['agreement'];
                      $claimantDoc = $documents['claimant'];
                      $respondantDoc = $documents['respondant'];
                      $arbitratorDoc = $documents['arbitrator'];
                    ?>

                    <thead>
                      <tr>
                        <th colspan="3">Arbitration Agreement</td>
                      </tr>
                    </thead>

                    <tbody>
                      <?php 
                        foreach( $agreement as $a ){
                          if( $a !== "" ){
                            $url = base_url().'web_uploads/case_uploads/'.$cases[0]->serial_no.'/'. $a;
                      ?>
                      <tr class="lightGrayBg">
                        <td colspan="3" class="details">
                          <a href="<?= $url ?>" target="_blank">
                            <img src="<?php echo $global['web_assets']; ?>images/download.jpg" class="mr-3" /><?= $a ?>
                          </a>
                        </td>
                      </tr>
                      <?php } } ?>
                    </tbody>

                    <thead>
                      <tr>
                        <th colspan="3">Contract and Other Documents</td>
                      </tr>
                    </thead>

                    <tbody>
                      <?php 
                        foreach( $contract as $c ){
                          if( $c !== "" ){
                            $url = base_url().'web_uploads/case_uploads/'.$cases[0]->serial_no.'/'. $c;
                      ?>
                      <tr class="lightGrayBg">
                        <td colspan="3" class="details">
                          <a href="<?= $url ?>" target="_blank">
                            <img src="<?php echo $global['web_assets']; ?>images/download.jpg" class="mr-3" /><?= $c ?>
                          </a>
                        </td>
                      </tr>
                      <?php } } ?>
                    </tbody>

                    <?php 
                      ////$claimantDetails = Modules::run('cases/getClaimant', $cases[0]->id); 
                      //$claimantAuthorisedPersons = Modules::run('cases/getAuthorisedClaimants', $cases[0]->id); 
                    ?>

                    <thead>
                      <tr>
                        <th colspan="3">Claimant Details</td>
                      </tr>
                    </thead>

                    <tbody>
                              
                      <tr class="lightGrayBg">
                        <td width="30%" class="title">Full Name</td>
                        <td width="5%" class="title"><stron>:</stron></td>
                        <td width="65%" class="details"><?= $claimant_profile !== "NA" ? $claimant_profile[0]->name : ""; ?></td>
                      </tr>

                      <tr class="lightGrayBg">
                        <td width="30%" class="title">Email</td>
                        <td width="5%" class="title"><stron>:</stron></td>
                        <td width="65%" class="details"><?= $claimant_profile !== "NA" ? $claimant_profile[0]->email : ""; ?></td>
                      </tr>

                      <tr class="lightGrayBg">
                        <td width="30%" class="title">Mobile</td>
                        <td width="5%" class="title"><stron>:</stron></td>
                        <td width="65%" class="details"><?= $claimant_profile !== "NA" ? $claimant_profile[0]->mobile : ""; ?></td>
                      </tr>

                      <tr class="lightGrayBg">
                        <td width="30%" class="title">Address</td>
                        <td width="5%" class="title"><stron>:</stron></td>
                        <td width="65%" class="details"><?= $claimant_profile !== "NA" ? $claimant_profile[0]->address : ""; ?></td>
                      </tr>

                      <thead>
                        <tr>
                          <th colspan="3">Claimant Authorized Person</td>
                        </tr>
                      </thead>  
                       

                      <?php if($claimantAuthorisedPersons != "NA") { ?>
                          <?php foreach( $claimantAuthorisedPersons as $claimaAuthorisedPersons ) {?>
                            <?php if($claimantAuthorisedPersons != "NA"){?>
                              <tr class="lightGrayBg">
                                <td width="30%" class="title">Full Name</td>
                                <td width="5%" class="title"><stron>:</stron></td>
                                <td width="65%" class="details"><?= $claimaAuthorisedPersons !== "NA" ? $claimaAuthorisedPersons[0]->name : ""; ?></td>
                              </tr>

                              <tr class="lightGrayBg">
                                <td width="30%" class="title">Email</td>
                                <td width="5%" class="title"><stron>:</stron></td>
                                <td width="65%" class="details"><?= $claimaAuthorisedPersons !== "NA" ? $claimaAuthorisedPersons[0]->email : ""; ?></td>
                              </tr>

                              <tr class="lightGrayBg">
                                <td width="30%" class="title">Mobile</td>
                                <td width="5%" class="title"><stron>:</stron></td>
                                <td width="65%" class="details"><?= $claimaAuthorisedPersons !== "NA" ? $claimaAuthorisedPersons[0]->mobile : ""; ?></td>
                              </tr>

                              <tr class="lightGrayBg">
                                <td width="30%" class="title">Address</td>
                                <td width="5%" class="title"><stron>:</stron></td>
                                <td width="65%" class="details"><?= $claimaAuthorisedPersons !== "NA" ? $claimaAuthorisedPersons[0]->address : ""; ?></td>
                              </tr>
                            <?php } ?>  
                          <?php }?>
                        <?php } ?>
                      

                    </tbody>

                    <?php 
                      //$respondentDetails = Modules::run('cases/getRespondent', $cases[0]->id); 
                      //$respondentAuthorisedPersons = Modules::run('cases/getAuthorisedRespondent', $cases[0]->id); 
                    ?>

                    <thead>
                      <tr>
                        <th colspan="3">Respondent Details</td>
                      </tr>
                    </thead>

                    <tbody>
                              
                      <tr class="lightGrayBg">
                        <td width="30%" class="title">Full Name</td>
                        <td width="5%" class="title"><stron>:</stron></td>
                        <td width="65%" class="details"><?= $respondentDetails !== "NA" ? $respondentDetails[0]->name : ""; ?></td>
                      </tr>

                      <tr class="lightGrayBg">
                        <td width="30%" class="title">Email</td>
                        <td width="5%" class="title"><stron>:</stron></td>
                        <td width="65%" class="details"><?= $respondentDetails !== "NA" ? $respondentDetails[0]->email : ""; ?></td>
                      </tr>

                      <tr class="lightGrayBg">
                        <td width="30%" class="title">Mobile</td>
                        <td width="5%" class="title"><stron>:</stron></td>
                        <td width="65%" class="details"><?= $respondentDetails !== "NA" ? $respondentDetails[0]->mobile : ""; ?></td>
                      </tr>

                      <tr class="lightGrayBg">
                        <td width="30%" class="title">Address</td>
                        <td width="5%" class="title"><stron>:</stron></td>
                        <td width="65%" class="details"><?= $respondentDetails !== "NA" ? $respondentDetails[0]->address : ""; ?></td>
                      </tr>

                      <thead>
                        <tr>
                          <th colspan="3">Respondent Authorized Person</td>
                        </tr>
                      </thead>  
                        <?php if($respondentAuthorisedPersons != "NA") { ?>
                          <?php foreach($respondentAuthorisedPersons as $resAuthorisedPersons ) {?>
                            <?php if($respondentAuthorisedPersons != "NA"){?>
                              <tr class="lightGrayBg">
                                <td width="30%" class="title">Full Name</td>
                                <td width="5%" class="title"><stron>:</stron></td>
                                <td width="65%" class="details"><?= $resAuthorisedPersons !== "NA" ? $resAuthorisedPersons[0]->name : ""; ?></td>
                              </tr>

                              <tr class="lightGrayBg">
                                <td width="30%" class="title">Email</td>
                                <td width="5%" class="title"><stron>:</stron></td>
                                <td width="65%" class="details"><?= $resAuthorisedPersons !== "NA" ? $resAuthorisedPersons[0]->email : ""; ?></td>
                              </tr>

                              <tr class="lightGrayBg">
                                <td width="30%" class="title">Mobile</td>
                                <td width="5%" class="title"><stron>:</stron></td>
                                <td width="65%" class="details"><?= $resAuthorisedPersons !== "NA" ? $resAuthorisedPersons[0]->mobile : ""; ?></td>
                              </tr>

                              <tr class="lightGrayBg">
                                <td width="30%" class="title">Address</td>
                                <td width="5%" class="title"><stron>:</stron></td>
                                <td width="65%" class="details"><?= $resAuthorisedPersons !== "NA" ? $resAuthorisedPersons[0]->address : ""; ?></td>
                              </tr>
                            <?php } ?>  
                        <?php }?>
                      <?php } ?> 
                      
                    </tbody>
                    
                    <thead>
                      <tr>
                        <th colspan="3">Arbitrator Details</td>
                      </tr>
                    </thead>
                   
                    
                    <?php if($details[0]->arbitrator_show_request =="requested"){ ?>
                      <tr class="lightGrayBg">
                      <td width="30%" class="title">All arbitrator show request</td>
                      <td width="5%" class="title"><stron>:</stron></td>
                      <td width="65%" class="details"><a href="javascript:void(0)" class="btn btn-success mr-3 arbitratorShowRequestAction" data-case_id ="<?php echo $details[0]->case_id; ?>" data-response="approve"> Approve </a> <a href="javascript:void(0)" class="btn btn-danger mr-3 arbitratorShowRequestAction" data-case_id ="<?php echo $details[0]->case_id; ?>" data-response="reject">Reject</a></td>
                    </tr>
                    <?php }else if($details[0]->arbitrator_show_request =="approve"){?> 
                      <tr class="lightGrayBg">
                        <td width="30%" class="title">All arbitrator show request</td>
                        <td width="5%" class="title"><stron>:</stron></td>
                        <td width="65%" class="details">Approved</td>
                      </tr>  
                      <?php }else if($details[0]->arbitrator_show_request =="reject"){?> 
                      <tr class="lightGrayBg">
                        <td width="30%" class="title">All arbitrator show request</td>
                        <td width="5%" class="title"><stron>:</stron></td>
                        <td width="65%" class="details">Rejected &nbsp;&nbsp; <a href="javascript:void(0)" class="btn btn-success mr-3 arbitratorShowRequestAction" data-case_id ="<?php echo $details[0]->case_id; ?>" data-response="approve"> Approve </a> <a href="javascript:void(0)" class="btn btn-danger mr-3 arbitratorShowRequestAction" data-case_id ="<?php echo $details[0]->case_id; ?>" data-response="reject">Reject</a></td>
                      </tr>  
                      <?php }else if($details[0]->arbitrator_show_request =="no"){?> 
                      <tr class="lightGrayBg">
                        <td width="30%" class="title">All arbitrator show request</td>
                        <td width="5%" class="title"><stron>:</stron></td>
                        <td width="65%" class="details">Not requested</td>
                      </tr>  
                    <?php } ?>
                    <!-- <tr class="lightGrayBg">
                      <td width="30%" class="title">Claimant Arbitrator Selection Type</td>
                      <td width="5%" class="title"><stron>:</stron></td>
                      <td width="65%" class="details"><?php //$arbitratorDetails !== "NA" && $details[0]->c_arbitration_selection_type != '' ? $arbitratorDetails['arbitration_selection_type'] : ""; ?></td>
                    </tr>

                    <tr class="lightGrayBg">
                      <td width="30%" class="title">Respondent Arbitrator Selection Type</td>
                      <td width="5%" class="title"><stron>:</stron></td>
                      <td width="65%" class="details"><?php //$arbitratorDetails !== "NA" && $details[0]->r_arbitration_selection_type != ''? $arbitratorDetails['r_arbitration_selection_type'] : ""; ?></td>
                    </tr> -->
                    
                    <tr class="lightGrayBg">
                      <td width="30%" class="title">Institution </td>
                      <td width="5%" class="title"><stron>:</stron></td>
                      <td width="65%" class="details"><?= $institution !== "NA" && $institution[0]->organisation_name != ''? $institution[0]->organisation_name : ""; ?></td>
                    </tr>
                    
                  

                  </table>
                  
                          
                        
                </div>

                

              </div>
            </div>
          </div>

      </div>
      <!-- checking condition for case is active or close -->
      <?php if($isStatus != "1") {?>
        <div class="card">
              <div class="card-body">
          <div class="row">
            <div class="col-12 mb-2">
              <div class="card-header bg-success">
                <h4 class="m-b-0 ">Appoint arbitrator from party selection list</h4>
              </div>
             
            </div>
            <div class="col-md-6">
              <div class="card-title">Claimant selected Arbitrators</div>
              
                  <div class="table-responsive">
                     <?php if(sizeOf($claimantArbdetail) != 0) {?>
                                     <table class="table color-table dark-table">
                                  
                                       
                                          <!-- <thead>
                                            <tr>
                                              <th colspan="">Claimant Details</th>
                                            </tr>
                                          </thead>  -->
                                         <thead> 
                                            <tr>
                                             
                                              <th>Name</th>
                                              <th>Mobile</th>
                                              <th>Email</th>
                                              
                                            </tr>
                                         </thead>
                                         
                                          <?php foreach( $claimantArbdetail as $claArbdetail) {?>
                                            <?php if($claArbdetail != "NA") { ?>
                                                <tr>
                                                <?php ?>
                                                <th style="<?= $claArbdetail[0]->type == "arbitrator" ?  "background-color:green;" : ""?>"><input type="radio" id="p<?=  (int)$claArbdetail[0]->registration_id ?>" name="party_arbitrator" value="<?= (int)$claArbdetail[0]->registration_id ?>"  > <label for="p<?=  (int)$claArbdetail[0]->registration_id ?>"><?= $claArbdetail[0]->name !== "NA" ? $claArbdetail[0]->name : ""; ?></label></th>
                                              
                                                <th><?= $claArbdetail[0]->mobile !== "NA" ? $claArbdetail[0]->mobile : ""; ?></th>
                                                <th><?= $claArbdetail[0]->email !== "NA" ? $claArbdetail[0]->email : ""; ?></th>
                                                
                                                </tr>
                                            <?php } ?>
                                          <?php } ?>
                                        
                                       
                                      </table>
                                     <?php } ?>
                  </div>
                
            </div>
            <div class="col-md-6">
              <div class="card-title">Respondent selected Arbitrators</div>
              
                  <div class="table-responsive">
                           <?php if(sizeOf($respondantArbitrators) != 0 ) {?>
                                     <table class="table color-table dark-table">
                                          
                                          <thead>
                                            <tr>
                                            
                                              <th>Name</th>
                                              <th>Mobile</th>
                                              <th>Email</th>
                                              
                                            </tr>
                                          </thead>
                                           
                                         
                                            <?php foreach( $respondantArbitrators as $resarbitrators ) {?>
                                              <?php if($resarbitrators != "NA") { ?>
                                                <tr>
                                                  <th style="<?= $resarbitrators[0]->type == "arbitrator" ?  "background-color:green;" : ""?>">
                                                    <input type="radio" id="p<?= (int)$resarbitrators[0]->registration_id ?>" name="party_arbitrator" value="<?= (int)$resarbitrators[0]->registration_id ?>"> <label for="p<?= (int)$resarbitrators[0]->registration_id ?>"><?= $resarbitrators[0]->name !== "NA" ? $resarbitrators[0]->name : ""; ?></label>
                                                  </th>
                                                 
                                                  <th><?= $resarbitrators[0]->mobile !== "NA" ? $resarbitrators[0]->mobile : ""; ?></th>
                                                  <th><?= $resarbitrators[0]->email !== "NA" ? $resarbitrators[0]->email : ""; ?></th>
                                                 
                                                </tr>
                                              <?php } ?>
                                            <?php } ?>
                                        
                                     </table>
                                     <?php } ?>
                  </div>
                
            </div>

            <div class="col-12">
              
               <?php if(sizeOf($respondantArbitrators) != 0 || sizeOf($claimantArbdetail) != 0 ) {?>
                             
                                      <button type="button" class="btn btn-rounded btn-outline-success col-md-3" id="checkArbitrator" >Submit</button>  
                                    
                                 <?php } ?>
                             
            </div>
          </div>
        </div>
        </div>
      <?php } ?>

       <!-- checking condition for case is active or close -->
      <?php if($isStatus != "1") {?>
        <div class="card">
          <div class="card-body">
            <div class="table-responsive">
         <div class="row">
            <div class="col-12 mb-2">
            <div class="card-header bg-success">
              <h4 class="m-b-0 ">Appoint Arbitrator from all arbitrator list</h4>
            </div>
           
          </div>
         </div>
                
                           
                <table class="table ">
                    <thead>
                      <tr>
                        <th>Name</th>
            
                        <th>Mobile</th>
                        <th>Email</th>
                        <th>Institution</th>
                        
                      </tr>
                    </thead>
                    <?php if($allArbitrators != "NA") {?>
                      <?php foreach( $allArbitrators as $allArbitrators) {?>
                        <?php if($allArbitrators != "NA") { ?>
                            <tr>
                            <th><input type="radio" id="<?=  (int)$allArbitrators->registration_id ?>" name="admin_arbitrator" value="<?= (int)$allArbitrators->registration_id ?>"> <label for="<?=  (int)$allArbitrators->registration_id ?>"><?= $allArbitrators->name !== "NA" ? $allArbitrators->name : ""; ?></label></th>
                
                            <th><?= $allArbitrators->mobile !== "NA" ? $allArbitrators->mobile : ""; ?></th>
                            <th><?= $allArbitrators->email !== "NA" ? $allArbitrators->email : ""; ?></th>

                            <?php $arbitratorOrg = Modules::run('cases/arbitratorOrg', $allArbitrators->registration_id); ?>
                            <?php $orgName = '';?>
                            <?php if($arbitratorOrg != "NA") {?>
                                <?php if(sizeOf($arbitratorOrg) > 1) {?>
                                  <?php foreach( $arbitratorOrg as $arbitratorOrg) { ?>
                                      <?php $orgName .= $arbitratorOrg->organisation_name.','; ?>
                                  <?php }?>
                                  <th><?= $orgName !== "NA" ? $orgName : ""; ?></th>
                                <?php } else { ?>  
                                    <?php foreach( $arbitratorOrg as $arbitratorOrg) { ?>
                                      <th><?= $arbitratorOrg->organisation_name !== "NA" ? $arbitratorOrg->organisation_name : ""; ?></th>
                                    <?php }?>
                                <?php } ?>
                            <?php } ?>
                            
                            </tr>
                        <?php } ?>
                      <?php } ?>
                    <?php } ?>
                    <?php if( $allArbitrators !== "NA" ){ ?>
                      <tr class="lightGrayBg">
                    <td colspan="5">
                      <div class="paginationType1">
                          <ul class="pagination">
                              <?php echo $arbitrator_pagination; ?>
                          </ul>
                      </div>
                    </td>
                  </tr>
                  <?php } ?>
                  <tr class="lightGrayBg">
                    <td colspan="5">
                      <button type="button" class="btn btn-rounded btn-outline-success col-md-3" id="adminSelectedArb" >Submit</button>  
                    </td>
                  </tr>
                </table>
            </div>
          </div>
        </div>
      <?php } ?>
      <div class="card">
        <div class="card-body">
          <button type="button" class="btn btn-rounded btn-outline-danger col-md-3"  onclick="window.location.href='<?php echo base_url(); ?>cases/list'">Back</button>  
        </div>
      </div>
    </div>

</div>
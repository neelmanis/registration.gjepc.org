<div class="d-flex justify-content-center">
    <div class="col-12 col-md-6">
        <div class="boxType1 tabType5 mt-5 mb-5">
            <div class="paraType5 mb-3">
                Please Reset/Create password for your account - <?=$email;?>
            </div>
            <form class="tabFormUI" id="reset-account-password">
                <div class="row w-100">
                <div class="col-md-12 form-group">
                    <label>Password</label>
                    <input type="password" class="form-control" name="password"
                        placeholder="Password" id="password" >
                        <label class="error" for="password"></label>
                </div>
                <div class="col-md-12 form-group">
                    <label>Confirm Passsword</label>
                    <input type="password" class="form-control" name="c_password" id="c_password"
                        placeholder="Confirm password" >
                        <label class="error" for="c_password"></label>
                </div>
                <div class="col-12">
                    <?php $_SESSION["token"] = md5(uniqid(mt_rand(), true)); ?>
                    <input type="hidden" name="enc_data" id="enc_data" value="<?php echo $enc_data;?>">    
                    <input type="hidden" name="csrfToken" id="csrfreg" value="<?php echo $_SESSION["token"];?>">    
                    <div class="text-left">
                        <button type="submit" class="btnType1 mr-3">Confirm & Proceed</button>
                    </div>
                    </div>
                
                </div>
            </form>
        </div>
    </div>
</div>

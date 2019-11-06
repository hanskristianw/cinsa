<div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
            <div class="col-lg">
            <div class="p-5">
                <div class="text-center">
                    <h3 class="text-gray-900 mb-2"><u><?= $title ?></u></h3>
                    <h5 class="text-gray-900 mb-4"><?= $kr_update['kr_nama_depan'].' '.$kr_update['kr_nama_belakang'] ?></h5>
                </div>

                
                <form class="user" method="post" action="<?php echo base_url('Karyawan_CRUD/reset_proses'); ?>">
                  
                    <input type="hidden" name="kr_id" value="<?= $kr_update['kr_id'] ?>">
                    
                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <label for="kr_password1"><b><u>Password</u>:</b></label>
                            <input type="password" class="form-control" id="kr_password1" required name="kr_password1" pattern="^\S{6,}$" onchange="this.setCustomValidity(this.validity.patternMismatch ? 'Must have at least 6 characters' : ''); if(this.checkValidity()) form.kr_password2.pattern = this.value;">
                        </div>
                        <div class="col-sm-6">
                            <label for="kr_password2"><b><u>Repeat Password</u>:</b></label>
                            <input type="password" class="form-control" id="kr_password2" required name="kr_password2" pattern="^\S{6,}$" onchange="this.setCustomValidity(this.validity.patternMismatch ? 'Please enter the same Password' : '');" >
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary btn-user btn-block">
                        Reset Password
                    </button>
                </form>
                <hr>
            </div>
            </div>
        </div>
        </div>
    </div>

</div>
<div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
            <div class="col-lg">
            <div class="p-5">
                <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4"><?= $title ?></h1>
                </div>

                <?= $this->session->flashdata('message'); ?>

                <?= form_open_multipart('Profile/update'); ?>
                    
                    <h4 class="text-muted mb-3"><u>REQUIRED FIELD</u></h4>

                    <input type="hidden" name="kr_pp" value="<?php echo set_value('kr_pp', $kr['kr_pp']); ?>">
                    <input type="hidden" name="_kr_username" value="<?php echo set_value('_kr_username', $kr['kr_username']); ?>">
                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <input type="text" class="form-control" id="kr_username" name="kr_username" placeholder="Username" value="<?php echo set_value('kr_username', $kr['kr_username']); ?>">
                            <?= form_error('kr_username','<small class="text-danger pl-3">','</small>'); ?>
                        </div>
                    </div>

                    <!-- NAMA DEPAN dan BELAKANG -->
                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <input type="text" class="form-control" id="kr_nama_depan" name="kr_nama_depan" placeholder="First Name" value="<?php echo set_value('kr_nama_depan', $kr['kr_nama_depan']); ?>">
                            <?= form_error('kr_nama_depan','<small class="text-danger pl-3">','</small>'); ?>
                        </div>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="kr_nama_belakang" name="kr_nama_belakang" placeholder="Last Name" value="<?php echo set_value('kr_nama_belakang', $kr['kr_nama_belakang']); ?>">
                            <?= form_error('kr_nama_belakang','<small class="text-danger pl-3">','</small>'); ?>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <input type="password" class="form-control" id="kr_password1" name="kr_password1" placeholder="Password">
                            <?= form_error('kr_password1','<small class="text-danger pl-3">','</small>'); ?>
                        </div>
                        <div class="col-sm-6">
                            <input type="password" class="form-control" id="kr_password2" name="kr_password2" placeholder="Repeat Password">
                        </div>
                    </div>
                    
                    <h4 class="text-muted mb-3 mt-5"><u>OPTIONAL FIELD</u></h4>
                    
                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <input type="text" class="form-control" id="kr_gelar_depan" name="kr_gelar_depan" placeholder="First Name Title (Dr, Prof)" value="<?php echo set_value('kr_gelar_depan', $kr['kr_gelar_depan']); ?>">
                        </div>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="kr_gelar_belakang" name="kr_gelar_belakang" placeholder="Last Name Title (S.kom, M.M)" value="<?php echo set_value('kr_gelar_belakang', $kr['kr_gelar_belakang']); ?>">
                        </div>
                    </div>

                    
                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <img height="300px" width="300px" src="<?= base_url('assets/img/profile/') .$kr['kr_pp'];?> "class="img-thumbnail">
                            <div class="custom-file mt-2">
                                <input type="file" class="custom-file-input" id="image"name="image">
                                <label class="custom-file-label" for="image">Choose Profile Picture</label>
                            </div>
                        </div>
                        <div class="col-sm-6 mt-2">
                            <input type="text" class="form-control mb-2" id="kr_alamat_ktp" name="kr_alamat_ktp" placeholder="ID Address" value="<?php echo set_value('kr_alamat_ktp', $kr['kr_alamat_ktp']); ?>">
                            <input type="text" class="form-control mb-2" id="kr_alamat_tinggal" name="kr_alamat_tinggal" placeholder="Home Address" value="<?php echo set_value('kr_alamat_tinggal', $kr['kr_alamat_tinggal']); ?>">
                            <input type="text" class="form-control mb-2" id="kr_ktp" name="kr_ktp" placeholder="ID number" value="<?php echo set_value('kr_ktp', $kr['kr_ktp']); ?>">
                            <input type="text" class="form-control mb-2" id="kr_npwp" name="kr_npwp" placeholder="NPWP number" value="<?php echo set_value('kr_npwp', $kr['kr_npwp']); ?>">
                            <input type="text" class="form-control mb-2" id="kr_bca" name="kr_bca" placeholder="BCA Account Number" value="<?php echo set_value('kr_bca', $kr['kr_bca']); ?>">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-user btn-block">
                        Update
                    </button>
                </form>
                <hr>
            </div>
            </div>
        </div>
        </div>
    </div>

</div>

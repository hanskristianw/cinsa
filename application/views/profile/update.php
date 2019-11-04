<div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
            <div class="col-lg">
            <div class="p-5">
                <div class="text-center">
                    <h1 class="h3 text-gray-900 mb-4"><u><?= $title ?></u></h1>
                </div>

                <?= $this->session->flashdata('message'); ?>

                <?= form_open_multipart('Profile/update'); ?>
                    
                    <h4 class="text-danger mb-3"><u>REQUIRED FIELD</u></h4>

                    <input type="hidden" name="kr_pp" value="<?php echo set_value('kr_pp', $kr['kr_pp']); ?>">
                    <input type="hidden" name="_kr_username" value="<?php echo set_value('_kr_username', $kr['kr_username']); ?>">
                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <label for="kr_username"><b><u>Username</u>:</b></label>
                            <input type="text" class="form-control" pattern="^\S+$" title="No Space Allowed" id="kr_username" name="kr_username" placeholder="Username" value="<?php echo set_value('kr_username', $kr['kr_username']); ?>">
                            <?= form_error('kr_username','<small class="text-danger pl-3">','</small>'); ?>
                        </div>
                    </div>

                    <!-- NAMA DEPAN dan BELAKANG -->
                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0 mt-3">
                            <label for="kr_nama_depan"><b><u>First Name</u>:</b></label>
                            <input type="text" class="form-control" id="kr_nama_depan" name="kr_nama_depan" placeholder="First Name" value="<?php echo set_value('kr_nama_depan', $kr['kr_nama_depan']); ?>" required>
                            <?= form_error('kr_nama_depan','<small class="text-danger pl-3">','</small>'); ?>
                        </div>
                        <div class="col-sm-6 mt-3">
                            <label for="kr_nama_belakang"><b><u>Last Name</u>:</b></label>
                            <input type="text" class="form-control" id="kr_nama_belakang" name="kr_nama_belakang" placeholder="Last Name" value="<?php echo set_value('kr_nama_belakang', $kr['kr_nama_belakang']); ?>">
                            <?= form_error('kr_nama_belakang','<small class="text-danger pl-3">','</small>'); ?>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0 mt-3">
                            <label for="kr_password1"><b><u>Password</u>:</b></label>
                            <input type="password" class="form-control" id="kr_password1" name="kr_password1" required>
                            <?= form_error('kr_password1','<small class="text-danger pl-3">','</small>'); ?>
                        </div>
                        <div class="col-sm-6 mt-3">
                            <label for="kr_password2"><b><u>Repeat Password</u>:</b></label>
                            <input type="password" class="form-control" id="kr_password2" name="kr_password2" required>
                        </div>
                    </div>
                    
                    <h4 class="text-success mb-3 mt-5"><u>OPTIONAL FIELD</u></h4>
                    
                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <label for="kr_gelar_depan"><b><u>First Name Title (Dr, Prof)</u>:</b></label>
                            <input type="text" class="form-control" id="kr_gelar_depan" name="kr_gelar_depan" value="<?php echo set_value('kr_gelar_depan', $kr['kr_gelar_depan']); ?>">
                        </div>
                        <div class="col-sm-6">
                            <label for="kr_gelar_belakang"><b><u>Last Name Title (S.kom, M.M)</u>:</b></label>
                            <input type="text" class="form-control" id="kr_gelar_belakang" name="kr_gelar_belakang" value="<?php echo set_value('kr_gelar_belakang', $kr['kr_gelar_belakang']); ?>">
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
                            <label for="kr_alamat_ktp"><b><u>Address Based On ID</u>:</b></label>
                            <input type="text" class="form-control mb-3" id="kr_alamat_ktp" name="kr_alamat_ktp" value="<?php echo set_value('kr_alamat_ktp', $kr['kr_alamat_ktp']); ?>">
                            <label for="kr_alamat_tinggal"><b><u>Current Address</u>:</b></label>
                            <input type="text" class="form-control mb-3" id="kr_alamat_tinggal" name="kr_alamat_tinggal" value="<?php echo set_value('kr_alamat_tinggal', $kr['kr_alamat_tinggal']); ?>">
                            <label for="kr_alamat_tinggal"><b><u>ID number</u>:</b></label>
                            <input type="text" class="form-control mb-3" id="kr_ktp" name="kr_ktp" value="<?php echo set_value('kr_ktp', $kr['kr_ktp']); ?>">
                            <label for="kr_alamat_tinggal"><b><u>NPWP number</u>:</b></label>
                            <input type="text" class="form-control mb-2" id="kr_npwp" name="kr_npwp" value="<?php echo set_value('kr_npwp', $kr['kr_npwp']); ?>">
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

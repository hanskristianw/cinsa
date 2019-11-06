<div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
            <div class="col-lg">
            <div class="p-5">
                <div class="text-center">
                    <h3 class="text-gray-900 mb-5"><u><?= $title ?></u></h3>
                </div>
                
                <?= $this->session->flashdata('message'); ?>
                
                <form class="user" method="post" action="<?php echo base_url('Karyawan_CRUD/add'); ?>">
                
                <h4 class="mb-3 text-danger"><u>REQUIRED FIELD</u></h4>
                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <label for="kr_nama_depan"><b><u>First Name</u>:</b></label>
                            <input type="text" class="form-control" id="kr_nama_depan" name="kr_nama_depan" required>
                        </div>
                        <div class="col-sm-6">
                            <label for="kr_nama_belakang"><b><u>Last Name</u>:</b></label>
                            <input type="text" class="form-control" id="kr_nama_belakang" name="kr_nama_belakang" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="kr_username"><b><u>Username</u>:</b></label>
                        <input type="text" class="form-control" id="kr_username" name="kr_username" required pattern="^\S+$" title="No Space Allowed">
                    </div>
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
                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">

                            <label for="kr_jabatan"><b><u>Position</u>:</b></label>
                            <select name="kr_jabatan" id="kr_jabatan" class="form-control">
                                <?php
                                    $_selected = set_value('kr_jabatan');

                                    foreach($jabatan_all as $m) :
                                        if($_selected == $m['jabatan_id']){
                                            $s = "selected";
                                        }
                                        else{
                                            $s = "";
                                        }
                                        if($m['jabatan_id']!=1){
                                            echo "<option value=".$m['jabatan_id']." ".$s.">".$m['jabatan_nama']."</option>";
                                        }
                                    endforeach
                                ?>
                            </select>
                        </div>

                        
                        <div class="col-sm-6 mb-sm-0">

                            <label for="sk"><b><u>Unit</u>:</b></label>
                            <select name="sk" id="sk" class="form-control">
                                <?php
                                    $_selected = set_value('sk');

                                    foreach($sk_all as $m) :
                                        if($_selected == $m['sk_id']){
                                            $s = "selected";
                                        }
                                        else{
                                            $s = "";
                                        }
                                        echo "<option value=".$m['sk_id']." ".$s.">".$m['sk_nama']."</option>";
                                    endforeach
                                ?>
                            </select>
                        </div>
                    </div>
                    
                    <div style='height: 20px;'></div>


                    <h4 class="text-success mb-3 mt-4"><u>ADDITIONAL INFORMATION (OPTIONAL)</u></h4>

                    <div class="form-group row mt-4">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <label for="kr_gelar_depan"><b><u>First Name Title (Dr, Prof)</u>:</b></label>
                            <input type="text" class="form-control mb-2" id="kr_gelar_depan" name="kr_gelar_depan">
                            
                            <label for="kr_ktp"><b><u>ID number</u>:</b></label>
                            <input type="text" class="form-control mb-2" id="kr_ktp" name="kr_ktp">

                            <label for="kr_alamat_ktp"><b><u>Address Based On ID</u>:</b></label>
                            <input type="text" class="form-control mb-2" id="kr_alamat_ktp" name="kr_alamat_ktp">

                            <label for="kr_alamat_tinggal"><b><u>Current Address</u>:</b></label>
                            <input type="text" class="form-control mb-2" id="kr_alamat_tinggal" name="kr_alamat_tinggal">
                            <div class="form-group row mt-4">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <label for="kr_pendidikan_skrng"><b><u>Current Education</u>:</b></label>
                                    <select name="kr_pendidikan_skrng" id="kr_pendidikan_skrng" class="form-control mb-1">
                                    <option value="SD">SD</option>
                                    <option value="SMP">SMP</option>
                                    <option value="SMA">SMA</option>
                                    <option value="S1" selected>S1</option>
                                    <option value="S2">S2</option>
                                    <option value="S3">S3</option>
                                    </select>
                                </div>
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <label for="kr_pendidikan_univ"><b><u><i>From</i></u>:</b></label>
                                    <input type="text" class="form-control mb-2" id="kr_pendidikan_univ" name="kr_pendidikan_univ">
                                </div>
                            </div>
                            
                        </div>
                        <div class="col-sm-6">
                            <label for="kr_gelar_belakang"><b><u>Last Name Title (S.kom, M.M)</u>:</b></label>
                            <input type="text" class="form-control mb-2" id="kr_gelar_belakang" name="kr_gelar_belakang">

                            <label for="kr_npwp"><b><u>NPWP number</u>:</b></label>
                            <input type="text" class="form-control mb-2" id="kr_npwp" name="kr_npwp">

                            <label for="kr_bca"><b><u>BCA Account Number</u>:</b></label>
                            <input type="text" class="form-control mb-2" id="kr_bca" name="kr_bca">

                            <label for="kr_mulai_tgl"><b><u>Date started work</u>:</b></label>
                            <input type="date" class="form-control mb-2" id="kr_mulai_tgl" name="kr_mulai_tgl">
                        </div>
                    </div>
                    
                    <div style='height: 20px;'></div>
                    <h4 class="text-success mb-3 mt-4"><u>MARITAL STATUS (OPTIONAL)</u></h4>
                    
                    <div class="form-group row mt-4">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <label for="kr_marital"><b><u>Status</u>:</b></label>
                            <select name="kr_marital" id="kr_marital" class="form-control mb-2">
                               <option value="single">Single</option>
                               <option value="married">Married</option>
                               <option value="others">Others</option>
                            </select>

                            <label for="kr_anak1"><b><u>1st Child's name</u>:</b></label>
                            <input type="text" class="form-control mb-2" id="kr_anak1" name="kr_anak1">
                            
                            <label for="kr_anak2"><b><u>2nd Child's name</u>:</b></label>
                            <input type="text" class="form-control mb-2" id="kr_anak2" name="kr_anak2">

                            <label for="kr_anak3"><b><u>3rd Child's name</u>:</b></label>
                            <input type="text" class="form-control mb-2" id="kr_anak3" name="kr_anak3">

                            <label for="kr_anak4"><b><u>4th Child's name</u>:</b></label>
                            <input type="text" class="form-control mb-2" id="kr_anak4" name="kr_anak4">
                        </div>

                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <label for="kr_nama_pasangan"><b><u>Husband / wife's name</u>:</b></label>
                            <input type="text" class="form-control mb-2" id="kr_nama_pasangan" name="kr_nama_pasangan">

                            <label for="kr_nikah_tanggal"><b><u>Date married</u>:</b></label>
                            <input type="date" class="form-control mb-2" id="kr_nikah_tanggal" name="kr_nikah_tanggal">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-user btn-block">
                        Insert
                    </button>
                </form>
                <hr>
            </div>
            </div>
        </div>
        </div>
    </div>

</div>

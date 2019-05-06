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
                
                <form class="user" method="post" action="<?php echo base_url('Karyawan_CRUD/add'); ?>">
                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <input type="text" class="form-control" id="kr_nama_depan" name="kr_nama_depan" placeholder="First Name" value="<?php echo set_value('kr_nama_depan'); ?>">
                            <?= form_error('kr_nama_depan','<small class="text-danger pl-3">','</small>'); ?>
                        </div>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="kr_nama_belakang" name="kr_nama_belakang" placeholder="Last Name" value="<?php echo set_value('kr_nama_belakang'); ?>">
                            <?= form_error('kr_nama_belakang','<small class="text-danger pl-3">','</small>'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="kr_username" name="kr_username" placeholder="Username" value="<?php echo set_value('kr_username'); ?>">
                        <?= form_error('kr_username','<small class="text-danger pl-3">','</small>'); ?>
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
                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">

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
                        <div class="col-sm-6">
                          <select name="st" id="st" class="form-control">
                                <?php
                                    $_selected = set_value('st');

                                    foreach($st_all as $m) :
                                        if($_selected == $m['st_id']){
                                            $s = "selected";
                                        }
                                        else{
                                            $s = "";
                                        }

                                        echo "<option value=".$m['st_id']." ".$s.">".$m['st_nama']."</option>";
                                    endforeach
                                ?>
                          </select>
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

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
                
                <form class="user" method="post" action="<?php echo base_url('Sekolah_CRUD/update'); ?>">
                    
                    <input type="hidden" name="_id" value="<?= set_value('_id',$sk_update['sk_id']); ?>">
                    
                    <input type="hidden" name="is_update" value="1">
                    
                    <div class="form-group row">
                        <div class="col-sm mb-3 mb-sm-0">
                            <label for="sk_nama"><b><u>Name</u>:</b></label>
                            <input type="text" class="form-control" id="sk_nama" name="sk_nama" placeholder="School Name" value="<?= set_value('sk_nama',$sk_update['sk_nama']); ?>">
                            <?php echo form_error('sk_nama','<small class="text-danger pl-3">','</small>'); ?>
                        </div>
                        <div class="col-sm mb-3 mb-sm-0">
                            <label for="sk_nickname"><b><u>Nickname</u>:</b></label>
                            <input type="text" class="form-control" id="sk_nickname" name="sk_nickname" placeholder="School Nickname (Ex: Highschool, Elementary)" value="<?= set_value('sk_nickname',$sk_update['sk_nickname']); ?>">
                            <?php echo form_error('sk_nickname','<small class="text-danger pl-3">','</small>'); ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm mb-3 mb-sm-0">
                            <label for="kr_id"><b><u>Principal</u>:</b></label>
                            <select name="kr_id" id="kr_id" class="form-control mb-2">
                                <?php
                                $_selected = set_value(kr_id,$sk_update['sk_kepsek']);

                                echo "<option value= '0'> Select Principal</option>";
                                foreach ($guru_all as $n) :
                                    if ($_selected == $n['kr_id']) {
                                        $s = "selected";
                                    } else {
                                        $s = "";
                                    }
                                    echo "<option value=" . $n['kr_id'] . " " . $s . ">" . $n['kr_nama_depan'] . " " . $n['kr_nama_belakang'][0] . "</option>";
                                endforeach
                                ?>
                            </select>
                        </div>
                        <div class="col-sm mb-3 mb-sm-0">
                            <label for="scout_id"><b><u>Scout Teacher</u>:</b></label>
                            <select name="scout_id" id="scout_id" class="form-control mb-2">
                                <?php
                                $_selected = set_value(kr_id,$sk_update['sk_scout_kr_id']);

                                echo "<option value= '0'> Select Scout Teacher</option>";
                                foreach ($guru_all as $n) :
                                    if ($_selected == $n['kr_id']) {
                                        $s = "selected";
                                    } else {
                                        $s = "";
                                    }
                                    echo "<option value=" . $n['kr_id'] . " " . $s . ">" . $n['kr_nama_depan'] . " " . $n['kr_nama_belakang'][0] . "</option>";
                                endforeach
                                ?>
                                </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm mb-3 mb-sm-0">
                            <label for="sk_mid"><b><u>Report Mid Date</u>:</b></label>
                            <input type="date" name="sk_mid" class="form-control form-control-sm" value="<?= set_value('sk_mid',$sk_update['sk_mid']); ?>">
                        </div>
                        <div class="col-sm mb-3 mb-sm-0">
                            <label for="sk_mid"><b><u>Report Final Date</u>:</b></label>
                            <input type="date" name="sk_fin" class="form-control form-control-sm" value="<?= set_value('sk_fin',$sk_update['sk_fin']); ?>">
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

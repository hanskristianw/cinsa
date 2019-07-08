<div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Insert School</h1>
                        </div>

                        <?= $this->session->flashdata('message'); ?>

                        <form class="user" method="post" action="<?= base_url('Sekolah_CRUD/add'); ?>">
                            <div class="form-group row">
                                <div class="col-sm mb-3 mb-sm-0">
                                    <input type="text" class="form-control" id="sk_nama" name="sk_nama" placeholder="School Name" value="<?= set_value('sk_nama') ?>">
                                    <?= form_error('sk_nama', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                                <div class="col-sm mb-3 mb-sm-0">
                                    <input type="text" class="form-control" id="sk_nickname" name="sk_nickname" placeholder="School Nickname (Ex: Highschool, Elementary)" value="<?= set_value('sk_nickname'); ?>">
                                    <?php echo form_error('sk_nickname', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                                <div class="col-sm mb-3 mb-sm-0">
                                    <select name="kr_id" id="kr_id" class="form-control mb-2">
                                        <?php
                                        $_selected = set_value(kr_id);

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
                            </div>
                            <div class="form-group row">
                                <div class="col-sm mb-3 mb-sm-0">
                                    <label for="sk_mid"><b><u>Report Mid Date</u>:</b></label>
                                    <input type="date" name="sk_mid" class="form-control form-control-sm" value="<?= set_value('sk_mid'); ?>">
                                </div>
                                <div class="col-sm mb-3 mb-sm-0">
                                    <label for="sk_mid"><b><u>Report Final Date</u>:</b></label>
                                    <input type="date" name="sk_fin" class="form-control form-control-sm" value="<?= set_value('sk_fin'); ?>">
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
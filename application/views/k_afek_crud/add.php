<div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Insert Indicator</h1>
                        </div>

                        <?= $this->session->flashdata('message'); ?>

                        <form class="user" method="post" action="<?= base_url('K_afek_CRUD/add'); ?>">
                            <div class="form-group row">
                                <div class="col-sm mb-3 mb-sm-0">
                                    <input type="text" class="form-control" id="k_afek_nama" name="k_afek_nama" placeholder="Criteria Name" value="<?= set_value('k_afek_nama') ?>">
                                    <?= form_error('k_afek_nama', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm mb-3 mb-sm-0">
                                    <textarea class="form-control" rows="4" id="k_afek_1" name="k_afek_1" placeholder="Indicator 1"><?= set_value('k_afek_1') ?></textarea>
                                    <?= form_error('k_afek_1', '<small class="text-danger pl-3">', '</small>'); ?>
                                    <textarea class="form-control mt-3" rows="4" id="k_afek_3" name="k_afek_3" placeholder="Indicator 3"><?= set_value('k_afek_3') ?></textarea>
                                    <?= form_error('k_afek_3', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                                <div class="col-sm mb-3 mb-sm-0">
                                    <textarea class="form-control" rows="4" id="k_afek_2" name="k_afek_2" placeholder="Indicator 2"><?= set_value('k_afek_2') ?></textarea>
                                    <?= form_error('k_afek_2', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">

                                    <select name="k_afek_bulan_id" id="k_afek_bulan_id" class="form-control">
                                        <?php
                                        $_selected = set_value('k_afek_bulan_id');

                                        foreach ($bulan_all as $m) :
                                            if ($_selected == $m['bulan_id']) {
                                                $s = "selected";
                                            } else {
                                                $s = "";
                                            }
                                            echo "<option value=" . $m['bulan_id'] . " " . $s . ">" . $m['bulan_nama'] . "</option>";
                                        endforeach
                                        ?>
                                    </select>
                                </div>
                                <div class="col-sm-6 mb-3 mb-sm-0">

                                    <select name="k_afek_t_id" id="k_afek_t_id" class="form-control">
                                        <?php
                                        $_selected = set_value('k_afek_t_id');

                                        foreach ($tahun_all as $m) :
                                            if ($_selected == $m['t_id']) {
                                                $s = "selected";
                                            } else {
                                                $s = "";
                                            }
                                            echo "<option value=" . $m['t_id'] . " " . $s . ">" . $m['t_nama'] . "</option>";
                                        endforeach
                                        ?>
                                    </select>
                                </div>
                                <div class="col-sm-6 mb-3 mt-4 mb-sm-0">
                                    <textarea rows="4" name="k_afek_instruksi_1" class="form-control" placeholder="Score Instruction 1"><?= set_value('k_afek_instruksi_1') ?></textarea>
                                    <?= form_error('k_afek_instruksi_1', '<small class="text-danger pl-3">', '</small>'); ?>

                                    <textarea rows="4" name="k_afek_instruksi_3" class="form-control mt-3" placeholder="Score Instruction 3"><?= set_value('k_afek_instruksi_3') ?></textarea>
                                    <?= form_error('k_afek_instruksi_3', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                                <div class="col-sm-6 mt-4 mb-3 mb-sm-0">
                                    <textarea rows="4" name="k_afek_instruksi_2" class="form-control" placeholder="Score Instruction 2"><?= set_value('k_afek_instruksi_2') ?></textarea>
                                    <?= form_error('k_afek_instruksi_2', '<small class="text-danger pl-3">', '</small>'); ?>
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
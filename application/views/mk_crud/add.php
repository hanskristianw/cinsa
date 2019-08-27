<div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
            <div class="col-lg">
            <div class="p-5">
                <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Insert Special Subject Name</h1>
                </div>

                <?= $this->session->flashdata('message'); ?>

                <form class="user" method="post" action="<?= base_url('MK_CRUD/add'); ?>">
                    <div class="form-group row">
                        <div class="col-sm mb-3 mb-sm-0">
                            <input type="text" class="form-control" id="mk_nama" name="mk_nama" placeholder="Name (Ex: Mandarin Advance)" value="<?= set_value('mk_nama') ?>">
                            <?= form_error('mk_nama','<small class="text-danger pl-3">','</small>'); ?>
                        </div>
                        <div class="col-sm mb-sm-0">
                            <select name="mk_t_id" id="mk_t_id" class="form-control">
                                <?php 
                                $_selected = set_value(mk_t_id);
                                foreach ($t_all as $m) :
                                    if ($_selected == $m['t_id']) {
                                        $s = "selected";
                                    } else {
                                        $s = "";
                                    }
                                    echo "<option value=" . $m['t_id'] . " " . $s . ">" . $m['t_nama'] . "</option>";
                                endforeach ?>
                            </select>
                        </div>
                        <div class="col-sm mb-sm-0">
                            <select name="mk_mapel_id" id="mk_mapel_id" class="form-control">
                                <?php 
                                $_selected = set_value(mk_mapel_id);
                                foreach ($mapel_all as $m) :
                                    if ($_selected == $m['mapel_id']) {
                                        $s = "selected";
                                    } else {
                                        $s = "";
                                    }
                                    echo "<option value=" . $m['mapel_id'] . " " . $s . ">" . $m['mapel_nama'] . "</option>";
                                endforeach ?>
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

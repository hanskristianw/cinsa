<div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Edit Topic</h1>
                        </div>

                        <?= $this->session->flashdata('message'); ?>

                        <form class="user" method="post" action="<?= base_url('Topik_CRUD/edit'); ?>">
                            <input type="hidden" name="_id" value="<?= set_value('_id', $topik_update['topik_id']) ?>">
                            <div class="form-group row">
                                <div class="col-sm mb-3 mb-sm-0">
                                    <input type="text" class="form-control" id="topik_nama" name="topik_nama" placeholder="Topic Name" value="<?= set_value('topik_nama', $topik_update['topik_nama']) ?>">
                                    <?= form_error('topik_nama', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                                <div class="col-sm mb-3 mb-sm-0">
                                    <select name="topik_semester" class="form-control">
                                        <?php
                                            $_selected = set_value('topik_semester', $topik_update['topik_semester']);

                                            if ($_selected == 1) {
                                                echo '<option value="1" selected>Semester 1</option>
                                                <option value="2">Semester 2</option>';
                                            } elseif ($_selected == 2) {
                                                echo '<option value="1">Semester 1</option>
                                                <option value="2" selected>Semester 2</option>';
                                            }
                                            else{
                                                echo '<option value="1">Semester 1</option>
                                                <option value="2">Semester 2</option>';
                                            }
                                        ?>
                                        
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">

                                    <select name="jenj_id" id="jenj_id" class="form-control">
                                        <?php
                                        $_selected = set_value('jenj_id', $topik_update['topik_jenj_id']);

                                        foreach ($jenj_all as $m) :
                                        if ($_selected == $m['jenj_id']) {
                                            $s = "selected";
                                        } else {
                                            $s = "";
                                        }
                                        echo "<option value=" . $m['jenj_id'] . " " . $s . ">" . $m['jenj_nama'] . "</option>";
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
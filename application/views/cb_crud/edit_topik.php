<div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Update Topic</h1>
                        </div>

                        <?= $this->session->flashdata('message'); ?>

                        <form class="user" method="post" action="<?= base_url('CB_CRUD/edit_topik_proses'); ?>">
                            <input type="hidden" name="topik_cb_id" value="<?= set_value('topik_cb_id', $topik_cb['topik_cb_id']) ?>">
                            <div class="form-group row">
                                <div class="col-sm mb-3 mb-sm-0">
                                    <label for="topik_cb_nama"><b><u>Name</u>:</b></label>
                                    <input type="text" class="form-control" id="topik_cb_nama" name="topik_cb_nama" value="<?= set_value('topik_cb_nama', $topik_cb['topik_cb_nama']) ?>" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                
                                <?php if($jum_cb == 0): ?>
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <label for="topik_cb_jenj_id"><b><u>For Level</u>:</b></label>
                                    <select name="topik_cb_jenj_id" id="topik_cb_jenj_id" class="form-control">
                                        <?php
                                        $_selected = set_value('topik_cb_jenj_id',$topik_cb['topik_cb_jenj_id']);

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
                                <?php else: ?>
                                    <input type="hidden" value="<?= $topik_cb['topik_cb_jenj_id'] ?>" name="topik_cb_jenj_id">
                                <?php endif; ?>
                                <div class="col-sm mb-3 mb-sm-0">
                                    <label for="topik_cb_semester"><b><u>Semester</u>:</b></label>
                                    <select name="topik_cb_semester" class="form-control">
                                        <?php
                                            $_selected = set_value('topik_cb_semester',$topik_cb['topik_cb_semester']);

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
                              <div class="col-sm mb-3 mb-sm-0">
                                  <label for="topik_cb_a"><b><u>Description if A</u>:</b></label>
                                  <textarea class="form-control" name="topik_cb_a" id="" rows="5" required><?= $topik_cb['topik_cb_a'] ?></textarea>
                              </div>
                            </div>
                            <div class="form-group row">
                              <div class="col-sm mb-3 mb-sm-0">
                                  <label for="topik_cb_b"><b><u>Description if B</u>:</b></label>
                                  <textarea class="form-control" name="topik_cb_b" id="" rows="5" required><?= $topik_cb['topik_cb_b'] ?></textarea>
                              </div>
                            </div>
                            <div class="form-group row">
                              <div class="col-sm mb-3 mb-sm-0">
                                  <label for="topik_cb_c"><b><u>Description if C</u>:</b></label>
                                  <textarea class="form-control" name="topik_cb_c" id="" rows="5" required><?= $topik_cb['topik_cb_c'] ?></textarea>
                              </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-user btn-block">
                                Update Topic
                            </button>
                        </form>
                        <hr>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<div class="container">

  <div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
      <!-- Nested Row within Card Body -->
      <div class="row">
        <div class="col-lg">
          <div class="p-5">
            <div class="text-center">
              <h1 class="h4 text-gray-900 mb-4">Insert Student</h1>
            </div>

            <?= $this->session->flashdata('message'); ?>

            <form class="user" method="post" action="<?= base_url('Siswa_CRUD/add'); ?>">
              <div class="form-group row">
                <div class="col-sm mb-3 mb-sm-0">
                  <input type="text" class="form-control" id="sis_no_induk" name="sis_no_induk" placeholder="NIS" value="<?= set_value('sis_no_induk') ?>">
                  <?= form_error('sis_no_induk', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
                <div class="col-sm mb-3 mb-sm-0">
                  <input type="text" class="form-control" id="sis_nama_depan" name="sis_nama_depan" placeholder="First Name" value="<?= set_value('sis_nama_depan') ?>">
                  <?= form_error('sis_nama_depan', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm mb-3 mb-sm-0">
                  <input type="text" class="form-control" id="sis_nama_bel" name="sis_nama_bel" placeholder="Last Name" value="<?= set_value('sis_nama_bel') ?>">
                  <?= form_error('sis_nama_bel', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
                <div class="col-sm-6 mb-3 mb-sm-0">
                  <select name="sis_t_id" id="sis_t_id" class="form-control">
                    <?php
                    $_selected = set_value('sis_t_id');
                    echo "<option value = 0>Select Year</option>";
                    foreach ($tahun_all as $m) :
                      if ($_selected == $m['tahun_id']) {
                        $s = "selected";
                      } else {
                        $s = "";
                      }
                      if ($m['tahun_id'] != 0) {
                        echo "<option value=" . $m['tahun_id'] . " " . $s . ">" . $m['tahun_nama'] . "</option>";
                      }
                    endforeach
                    ?>
                  </select>
                  <?= form_error('sis_t_id', '<small class="text-danger pl-3">', '</small>'); ?>
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
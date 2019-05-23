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
                  <input type="number" class="form-control" id="sis_no_induk" name="sis_no_induk" placeholder="Registration Number" min="1" value="<?= set_value('sis_no_induk') ?>">
                  <?= form_error('sis_no_induk', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
                <div class="col-sm-6 mb-3 mb-sm-0">
                  <select name="sis_t_id" id="sis_t_id" class="form-control">
                    <?php
                      $_selected = set_value('sis_t_id');
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
              </div>
              <div class="form-group row">
                <div class="col-sm mb-3 mb-sm-0">
                  <input type="text" class="form-control" id="sis_nama_depan" name="sis_nama_depan" placeholder="First Name" value="<?= set_value('sis_nama_depan') ?>">
                  <?= form_error('sis_nama_depan', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
                <div class="col-sm mb-3 mb-sm-0">
                  <input type="text" class="form-control" id="sis_nama_bel" name="sis_nama_bel" placeholder="Last Name" value="<?= set_value('sis_nama_bel') ?>">
                  <?= form_error('sis_nama_bel', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm mb-3 mb-sm-0">
                  <select class="form-control" name="sis_jk" id="sis_jk">
                      <option value="Male">Male</option>
                      <option value="Female">Female</option>
                  </select>
                </div>
                <div class="col-sm-6 mb-3 mb-sm-0">
                  <select name="sis_agama_id" id="sis_agama_id" class="form-control">
                    <?php
                      $_selected = set_value('sis_agama_id');
                      foreach ($agama_all as $m) :
                        if ($_selected == $m['agama_id']) {
                          $s = "selected";
                        } else {
                          $s = "";
                        }
                        echo "<option value=" . $m['agama_id'] . " " . $s . ">" . $m['agama_nama'] . "</option>";
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
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

            <form class="user" method="post" action="<?= base_url('Kelas_CRUD/update'); ?>">
              <div class="form-group row">
                <div class="col-sm mb-3 mb-sm-0">
                  <input type="hidden" name="_id" value="<?= set_value('_id', $kelas_update['kelas_id']); ?>">
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">

                  <select name="kelas_t_id" id="kelas_t_id" class="form-control">
                    <?php
                      $_selected = set_value('kelas_t_id', $kelas_update['kelas_t_id']);

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
                <div class="col-sm mb-3 mb-sm-0 cek">
                  <input type="text" class="form-control" id="kelas_nama" name="kelas_nama" placeholder="Class" value="<?= set_value('kelas_nama', $kelas_update['kelas_nama']) ?>">
                  <?= form_error('kelas_nama', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
              </div>
              <?= $this->session->flashdata('warning'); ?>
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
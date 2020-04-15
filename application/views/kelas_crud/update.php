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

                <?php if ($jum['total'] == 0) : ?>

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
                <?php else : ?>
                  <input type="hidden" value="<?= $kelas_update['kelas_t_id'] ?>" name="kelas_t_id">
                <?php endif; ?>
                <div class="col-sm mb-3 mb-sm-0 cek">
                  <input type="text" class="form-control" id="kelas_nama" name="kelas_nama" placeholder="Class" value="<?= set_value('kelas_nama', $kelas_update['kelas_nama']) ?>">
                  <?= form_error('kelas_nama', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
              </div>
              <div class="form-group row">

                <?php if ($jum['total'] == 0) : ?>
                  <div class="col-sm-6 mb-3 mb-sm-0">

                    <select name="jenj_id" id="jenj_id" class="form-control">
                      <?php
                      $_selected = set_value('jenj_id', $kelas_update['kelas_jenj_id']);

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
                <?php else : ?>
                  <input type="hidden" value="<?= $kelas_update['kelas_jenj_id'] ?>" name="jenj_id">
                <?php endif; ?>

                <div class="col-sm mb-3 mb-sm-0 cek">
                  <input type="text" class="form-control" id="kelas_nama_singkat" name="kelas_nama_singkat" placeholder="Class Abbreviation (Ex: Xsc1)" value="<?= set_value('kelas_nama_singkat', $kelas_update['kelas_nama_singkat']) ?>">
                  <?= form_error('kelas_nama_singkat', '<small class="text-danger pl-3">', '</small>'); ?>
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
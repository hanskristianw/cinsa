<div class="container">

  <div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
      <!-- Nested Row within Card Body -->
      <div class="row">
        <div class="col-lg">
          <div class="p-5">
            <div class="text-center">
              <h1 class="h4 text-gray-900 mb-4"><u><?= $title ?></u></h1>
            </div>

            <form class="user" method="post" action="<?php echo base_url('Tahun_CRUD/update'); ?>">

              <input type="hidden" name="_id" value="<?= set_value('_id', $tahun_update['t_id']); ?>">

              <div class="form-group row">
                <div class="col-sm mb-3 mb-sm-0">
                  <label><b>Nama Tahun Ajaran:</b></label>
                  <input type="text" class="form-control form-control-sm" id="tahun_nama" name="tahun_nama" value="<?= set_value('tahun_nama', $tahun_update['t_nama']); ?>" required>
                  <?php echo form_error('tahun_nama', '<small class="text-danger pl-3">', '</small>'); ?>

                </div>
                <div class="col-sm mb-3 mb-sm-0">
                  <label><b>Tanggal Berakhir:</b></label>
                  <input type="date" class="form-control form-control-sm" name="t_akhir" value="<?= $tahun_update['t_akhir'] ?>" required>

                  <label class="mt-3"><b>Tanggal Mulai:</b></label>
                  <input type="date" class="form-control form-control-sm" name="t_awal" value="<?= $tahun_update['t_awal'] ?>" required>
                </div>
                <div class="col-sm mb-3 mb-sm-0">
                  <label><b>Semester Aktif untuk Siswa:</b></label>
                  <input type="number" class="form-control form-control-sm" name="t_sem_aktif" value="<?= $tahun_update['t_sem_aktif'] ?>" min="1" max="2" required>
                  <label class="mt-3"><b>Jenis Rapor untuk Siswa:</b></label>
                  <select name="t_jenis_rapor" class="form-control form-control-sm">
                    <?php
                    if ($tahun_update['t_jenis_rapor'] == 1) {
                      echo '<option value="1" selected>Sisipan</option>
                      <option value="2">Semester</option>';
                    } else {
                      echo '<option value="1">Sisipan</option>
                      <option value="2" selected>Semester</option>';
                    }
                    ?>
                  </select>
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
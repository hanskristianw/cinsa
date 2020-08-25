<div class="container">

  <div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
      <!-- Nested Row within Card Body -->
      <div class="row">
        <div class="col-lg">
          <div class="p-5">
            <div class="text-center">
              <h1 class="h4 text-gray-900 mb-4"><u>Tambah Siswa</u></h1>
            </div>

            <?= $this->session->flashdata('message'); ?>

            <form class="user" method="post" action="<?= base_url('Siswa_CRUD/add_baru_proses'); ?>">
              <div class="form-group row">
                <div class="col-sm mb-3 mb-sm-0">
                  <label><b>No induk:</b></label>
                  <input type="text" class="form-control form-control-sm" name="sis_no_induk" required>
                </div>
                <div class="col-sm mb-3 mb-sm-0">
                  <label><b>NISN:</b></label>
                  <input type="text" class="form-control form-control-sm" name="sis_nisn">
                </div>
                <div class="col-sm-6 mb-3 mb-sm-0">
                  <label><b>Angkatan Siswa:</b></label>
                  <select name="sis_t_id" class="form-control form-control-sm">
                    <?php
                      foreach ($tahun_all as $m) :
                        echo "<option value=" . $m['t_id'] . " " . $s . ">" . $m['t_nama'] . "</option>";
                      endforeach
                    ?>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm mb-3 mb-sm-0">
                  <label><b>Nama Depan:</b></label>
                  <input type="text" class="form-control form-control-sm" name="sis_nama_depan">
                </div>
                <div class="col-sm mb-3 mb-sm-0">
                  <label><b>Nama Belakang:</b></label>
                  <input type="text" class="form-control form-control-sm" name="sis_nama_bel">
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm mb-3 mb-sm-0">
                  <label><b>Gender:</b></label>
                  <select class="form-control form-control-sm" name="sis_jk" id="sis_jk">
                      <option value="1">Laki-laki</option>
                      <option value="2">Perempuan</option>
                  </select>
                </div>
                <div class="col-sm-6 mb-3 mb-sm-0">
                  <label><b>Agama:</b></label>
                  <select name="sis_agama_id" class="form-control form-control-sm">
                    <?php
                      foreach ($agama_all as $m) :
                        echo "<option value=" . $m['agama_id'] . " " . $s . ">" . $m['agama_nama'] . "</option>";
                      endforeach
                    ?>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm mb-3 mb-sm-0">
                  <label><b>Email Gsuite Siswa:</b></label>
                  <input type="text" class="form-control form-control-sm" name="sis_email" pattern="[^' ']+@nationstaracademy.sch.id" title="Tidak boleh ada spasi, harus account nationstaracademy.sch.id">
                </div>
              </div>
              <button type="submit" class="btn btn-primary btn-user btn-block">
                Tambah
              </button>
            </form>
            <hr>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>

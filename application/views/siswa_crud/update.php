<div class="container">

  <div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
      <!-- Nested Row within Card Body -->
      <div class="row">
        <div class="col-lg">
          <div class="p-5">
            <div class="text-center">
              <h1 class="h4 text-gray-900 mb-4"><u>Update Siswa</u></h1>
            </div>

            <?= $this->session->flashdata('message'); ?>

            <form class="user" method="post" action="<?= base_url('Siswa_CRUD/update_baru_proses'); ?>">
              <div class="form-group row">
                <div class="col-sm mb-3 mb-sm-0">
                  <label><b>No induk:</b></label>
                  <input type="hidden" name="sis_id" value="<?= $siswa_update['sis_id']; ?>">
                  <input type="text" class="form-control form-control-sm" name="sis_no_induk" value="<?= $siswa_update['sis_no_induk'] ?>" required>
                </div>
                <div class="col-sm mb-3 mb-sm-0">
                  <label><b>NISN:</b></label>
                  <input type="number" class="form-control form-control-sm" name="sis_nisn" min="1" value="<?= $siswa_update['sis_nisn'] ?>">
                </div>
                <?php if($cek_siswa['jum'] == 0): ?>
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <label><b>Angkatan siswa:</b></label>
                    <select name="sis_t_id" class="form-control form-control-sm">
                      <?php
                        $_selected = $siswa_update['sis_t_id'];

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
                <?php else:?>
                  <input type="hidden" name="sis_t_id" value="<?= $siswa_update['sis_t_id'] ?>">
                <?php endif; ?>
              </div>
              <div class="form-group row">
                <div class="col-sm mb-3 mb-sm-0">
                  <label><b>Nama Depan:</b></label>
                  <input type="text" class="form-control form-control-sm" name="sis_nama_depan" value="<?= $siswa_update['sis_nama_depan'] ?>" required>
                </div>
                <div class="col-sm mb-3 mb-sm-0">
                  <label><b>Nama Belakang:</b></label>
                  <input type="text" class="form-control form-control-sm" name="sis_nama_bel" value="<?= $siswa_update['sis_nama_bel'] ?>" required>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm mb-3 mb-sm-0">
                  <label><b>Gender:</b></label>
                  <select class="form-control form-control-sm" name="sis_jk">
                    <?php
                      $_selected = $siswa_update['sis_jk'];

                      if($_selected == "1"){
                        echo "<option value='1' selected>Laki-Laki</option>";
                      }
                      else{
                        echo "<option value='1'>Laki-Laki</option>";
                      }

                      if($_selected == "2"){
                        echo "<option value='2' selected>Perempuan</option>";
                      }
                      else{
                        echo "<option value='2'>Perempuan</option>";
                      }
                    ?>
                  </select>
                </div>
                <div class="col-sm-6 mb-3 mb-sm-0">
                  <label><b>Agama:</b></label>
                  <select name="sis_agama_id" class="form-control form-control-sm">
                    <?php
                      $_selected = $siswa_update['sis_agama_id'];
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
              <div class="form-group row">
                <div class="col-sm mb-3 mb-sm-0">
                  <label><b>Email Gsuite Siswa:</b></label>
                  <input type="hidden" name="sis_email_lama" value="<?= $siswa_update['sis_email'] ?>">
                  <input type="text" class="form-control form-control-sm" value="<?= $siswa_update['sis_email'] ?>" name="sis_email" pattern="[^' ']+@nationstaracademy.sch.id" title="Tidak boleh ada spasi, harus account nationstaracademy.sch.id">
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

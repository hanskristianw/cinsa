<style>
.grid-container {
  display: grid;
  grid-template-columns: 15% 15% 15% 25% 15% 15%;
  grid-column-gap:4px;
  padding-right:3px;
}
.grid-container > div{
  text-align:left;
}

.grid-main {
  display: grid;
  grid-template-columns: 5% 90% 5%;
  grid-column-gap:3px;
  padding: 10px;
  margin: 20px;
  box-shadow: 5px 5px 5px 5px;
  overflow: auto;
  padding-bottom: 20px;
  padding-top: 20px;
}

.box1{
  /*align-self:start;*/
  grid-column:2/3;
  /* overflow: auto; */
}

.box2{
  /*align-self:start;*/
  display: grid;
  grid-template-columns: 50% 50%;
  margin-right: 20px;
}

</style>

<div class="grid-main">

  <div class="box1 text-center">
    <h1 class="h4 text-gray-900 mb-4"><u>Update Siswa</u></h1>
  </div>

  <div class="box1 text-center">
    <?= $this->session->flashdata('message'); ?>
  </div>

  <div class="box1 text-center">
    <form class="user" method="post" action="<?= base_url('Siswa_CRUD/update_baru_proses'); ?>">
      <div class="form-group row">
        <div class="col-sm mb-3 mb-sm-0">
          <label><b>No induk:</b></label>
          <input type="hidden" name="sis_id" value="<?= $siswa_update['sis_id']; ?>">
          <input type="text" class="form-control form-control-sm" name="sis_no_induk" value="<?= $siswa_update['sis_no_induk'] ?>" required>
        </div>
        <div class="col-sm mb-3 mb-sm-0">
          <label><b>NISN:</b></label>
          <input type="text" class="form-control form-control-sm" name="sis_nisn" value="<?= $siswa_update['sis_nisn'] ?>">
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

      <div class="form-group row">
        <div class="col-sm mb-3 mb-sm-0">
          <label><b>Nama Ayah:</b></label>
          <input type="text" class="form-control form-control-sm" name="sis_ayah" value="<?= $siswa_update['sis_ayah'] ?>">
        </div>
        <div class="col-sm-6 mb-3 mb-sm-0">
          <label><b>Nama Ibu:</b></label>
          <input type="text" class="form-control form-control-sm" name="sis_ibu" value="<?= $siswa_update['sis_ibu'] ?>">
        </div>
      </div>

      <button type="submit" class="btn btn-primary btn-user btn-block">
        Update
      </button>
    </form>
    <hr>
  </div>

</div>

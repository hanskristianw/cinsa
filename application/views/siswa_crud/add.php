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
    <h1 class="h4 text-gray-900 mb-4"><u>Tambah Siswa</u></h1>
  </div>

  <?= $this->session->flashdata('message'); ?>

  <div class="box1 p-2">
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
      <div class="form-group row">
        <div class="col-sm mb-3 mb-sm-0">
          <label><b>Nama Ayah:</b></label>
          <input type="text" class="form-control form-control-sm" name="sis_ayah">
        </div>
        <div class="col-sm-6 mb-3 mb-sm-0">
          <label><b>Nama Ibu:</b></label>
          <input type="text" class="form-control form-control-sm" name="sis_ibu">
        </div>
      </div>
      <button type="submit" class="btn btn-primary btn-user btn-block">
        Tambah
      </button>
    </form>
  </div>
  <hr>

</div>

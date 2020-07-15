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
  overflow: auto;
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
    <h1 class="h4 text-gray-900 mt-4"><u>Upload Rapor PDF</u></h1>
    <h5><?= $nama_siswa ?></h5>
  </div>


  <div class="box1">
      <?= $this->session->flashdata('message'); ?>
  </div>

  <div class="box1 mb-4">

    <form method="post" action="<?= base_url('komen_crud/save_rapor_pdf') ?>" enctype="multipart/form-data">
      <div class="custom-file mt-2">
        <input type="hidden" value="<?= $d_s_id ?>" name="d_s_id">
        <input type="hidden" value="<?= $jenis_upload ?>" name="jenis_upload">

        <input type="hidden" value="<?= $rapor['yppi_1_sis'] ?>" name="yppi_1_sis">
        <input type="hidden" value="<?= $rapor['yppi_1_sem'] ?>" name="yppi_1_sem">
        <input type="hidden" value="<?= $rapor['yppi_2_sis'] ?>" name="yppi_2_sis">
        <input type="hidden" value="<?= $rapor['yppi_2_sem'] ?>" name="yppi_2_sem">

        <input type="file" class="custom-file-input" id="image" name="image" required>
        <label class="custom-file-label" for="image">Pilih PDF</label>
      </div>

      <button type="submit" class="btn btn-secondary btn-user btn-block mt-3">
        Upload Rapor
      </button>
    </form>

  </div>

</div>

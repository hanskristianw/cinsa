<style>
.grid-container {
  display: grid;
  grid-template-columns: 5% 90% 5%;
  grid-column-gap:3px;
  padding: 10px;
  margin: 20px;
  box-shadow: 5px 5px 5px 5px;
  overflow: auto;
  padding-bottom: 120px;
  padding-top: 50px;
}


.box1{
  /*align-self:start;*/
  grid-column:2/3;
}

.box2{
  /*align-self:start;*/
  grid-template-columns: 50% 50%;
}
</style>


<div class="grid-container">

  <div class="box1 mb-3">
    <h5 class="text-center"><b><u><?= $title .' '. $sk['sk_nama'] ?></u></b></h5>
    <div><?= $this->session->flashdata('message'); ?></div>
  </div>
  <div class="box1">
    <form method="post" action="<?= base_url('wakasis_crud/edit_proses') ?>">
      <label for="pelanggaran_nama"><b>Nama Kategori Pelanggaran:</b></label>
      <input type="hidden" name="pelanggaran_id" value="<?= $pelanggaran['pelanggaran_id'] ?>">
      <input type="text" name="pelanggaran_nama" class="form-control form-control-sm" value="<?= $pelanggaran['pelanggaran_nama'] ?>" required>
      <button type="submit" class="btn btn-primary btn-user btn-block mt-3">
        Simpan
      </button>
    </form>
  </div>
</div>

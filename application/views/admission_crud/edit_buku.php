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
    <h5 class="text-center"><b><u><?= $title ?></u></b></h5>
    <div><?= $this->session->flashdata('message'); ?></div>
  </div>
  <div class="box1">
    <form method="post" action="<?= base_url('admission_crud/edit_buku_proses') ?>">
      
      <input type="hidden" name="buku_id" value="<?= $buku['buku_id'] ?>">

      <label for="buku_harga_beli" style="font-size:14px;"><b>Nama Buku:</b></label>
      <input type="text" name="buku_nama" class="form-control form-control-sm mb-2" value="<?= $buku['buku_nama'] ?>" required>

      <label for="buku_harga_beli" style="font-size:14px;"><b>Harga Beli:</b></label>
      <input type="number" name="buku_harga_beli" min="0" class="form-control form-control-sm mb-2" value="<?= $buku['buku_harga_beli'] ?>" required>

      <label for="buku_harga_jual" style="font-size:14px;"><b>Harga Jual</b></label>
      <input type="number" name="buku_harga_jual" min="0" class="form-control form-control-sm mb-2" value="<?= $buku['buku_harga_jual'] ?>" required>

      <button type="submit" class="btn btn-primary btn-user btn-block mt-3" style="cursor: pointer;">
        Update
      </button>
    </form>
  </div>
</div>

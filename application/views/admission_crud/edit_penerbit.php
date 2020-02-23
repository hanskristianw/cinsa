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
    <form method="post" action="<?= base_url('admission_crud/edit_penerbit_proses') ?>">
      
      <input type="hidden" name="penerbit_id" value="<?= $penerbit['penerbit_id'] ?>">

      <label for="buku_harga_beli" style="font-size:14px;"><b>Nama Buku:</b></label>
      <input type="text" name="penerbit_nama" class="form-control form-control-sm mb-2" value="<?= $penerbit['penerbit_nama'] ?>" required>

      <button type="submit" class="btn btn-primary btn-user btn-block mt-3" style="cursor: pointer;">
        Update
      </button>
    </form>
  </div>
</div>

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
    <?php if(count($cek_jual) > 0): ?>
      <div class="alert alert-primary" role="alert">
        <b>Perhatian: </b>Jika buku sudah pernah terjual, maka tidak dapat merubah harga beli maupun harga jual, karena berpengaruh terhadap perhitungan laporan penjualan
      </div>
    <?php endif; ?>

    <div><?= $this->session->flashdata('message'); ?></div>
  </div>
  <div class="box1">
    <form method="post" action="<?= base_url('admission_crud/edit_buku_proses') ?>">
      
      <input type="hidden" name="buku_id" value="<?= $buku['buku_id'] ?>">

      <label for="buku_harga_beli" style="font-size:14px;"><b>Nama Buku:</b></label>
      <input type="text" name="buku_nama" class="form-control form-control-sm mb-2" value="<?= $buku['buku_nama'] ?>" required>

      <?php if(count($cek_jual) == 0): ?>
        <label for="buku_harga_beli" style="font-size:14px;"><b>Harga Beli:</b></label>
        <input type="number" name="buku_harga_beli" min="0" class="form-control form-control-sm mb-2" value="<?= $buku['buku_harga_beli'] ?>" required>

        <label for="buku_harga_jual" style="font-size:14px;"><b>Harga Jual</b></label>
        <input type="number" name="buku_harga_jual" min="0" class="form-control form-control-sm mb-2" value="<?= $buku['buku_harga_jual'] ?>" required>
      <?php else: ?>
        <input type="hidden" name="buku_harga_beli" value="<?= $buku['buku_harga_beli'] ?>">
        <input type="hidden" name="buku_harga_jual" value="<?= $buku['buku_harga_jual'] ?>">
      <?php endif; ?>


      <label for="buku_penerbit_id" style="font-size:14px;"><b>Penerbit:</b></label>
      <select name="buku_penerbit_id" class="form-control form-control-sm">
        <?php foreach($p_all as $p): ?>
          <?php if($p['penerbit_id'] == $buku['buku_penerbit_id']): ?>
            <option value="<?= $p['penerbit_id'] ?>" selected><?= $p['penerbit_nama'] ?></option>
          <?php else: ?>
            <option value="<?= $p['penerbit_id'] ?>"><?= $p['penerbit_nama'] ?></option>
          <?php endif; ?>
        <?php endforeach; ?>
      </select>

      <button type="submit" class="btn btn-primary btn-user btn-block mt-3" style="cursor: pointer;">
        Update
      </button>
    </form>
  </div>
</div>

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

  <div class="box1">
    <h4 class="h4 text-gray-900 mt-3 text-center"><u><?= $title ?></u></h4>

    <?= $this->session->flashdata('message'); ?>
  </div>
  <div class="box1">

    <form method="post" action="<?= base_url('Jadwal_CRUD/pengumuman_update_proses'); ?>">
      <input type="hidden" name="pengumuman_id" value="<?=$pengumuman_all['pengumuman_id'] ?>">

      <label><b>Judul Pengumuman:</b></label>
      <input type="text" value="<?=$pengumuman_all['pengumuman_judul'] ?>" name="pengumuman_judul" class="form-control form-control-sm mb-2" required>

      <label><b>Tanggal:</b></label><br>
      <input type="date" value="<?=$pengumuman_all['pengumuman_tgl'] ?>" name="pengumuman_tgl" class="form-control form-control-sm mb-2" required>

      <label><b>Isi Pengumuman:</b></label>
      <textarea name="pengumuman_isi" rows="8" cols="80" class="form-control" required maxlength="300"><?=$pengumuman_all['pengumuman_isi'] ?></textarea>
      <button type="submit" class="btn btn-secondary btn-block mt-3">
       <i class="fa fa-save"></i> UPDATE
      </button>
    </form>

  </div>
</div>

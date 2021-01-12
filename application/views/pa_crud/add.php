<style>
.grid-container {
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
}

.box2{
  /*align-self:start;*/
  display: grid;
  grid-template-columns: 50% 50%;
  margin-right: 20px;
}
</style>


<div class="grid-container">
  <div class="box1">
    <h5 class="text-center"><b><u><?= $title ?></u></b></h5>
    <?= $this->session->flashdata('message'); ?>
  </div>
  <div class="box1">

    <form class="" action="<?= base_url('PA_CRUD/add_proses'); ?>" method="post">
      
      <input type="hidden" name="jabatan_kpi_id" value="<?= $jabatan_kpi_id ?>">

      <label style="font-size:14px;"><b>Nama Kompetensi:</b></label>
      <input type="text" class="form-control form-control-sm mb-3" name="kompe_pa_nama" value="" required>

      <button type="submit" class="btn btn-secondary btn-user btn-block mt-3">
        Simpan
      </button>
    </form>
  </div>

</div>

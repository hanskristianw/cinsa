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

    <form class="" action="<?= base_url('KPI_CRUD/edit_indi_proses'); ?>" method="post">

      <input type="hidden" name="indi_kpi_id" value="<?= $indi['indi_kpi_id'] ?>" required>
      <label style="font-size:14px;"><b>Nama Indikator:</b></label>
      <input type="text" class="form-control form-control-sm mb-3" name="indi_kpi_nama" value="<?= $indi['indi_kpi_nama'] ?>" required>

      <label style="font-size:14px;"><b>Target Indikator:</b></label>
      <input type="number" class="form-control form-control-sm mb-3" name="indi_kpi_target" value="<?= $indi['indi_kpi_target'] ?>" required>

      <label style="font-size:14px;"><b>Bobot Indikator dalam persen:</b></label>
      <input type="number" class="form-control form-control-sm mb-3" name="indi_kpi_bobot" value="<?= $indi['indi_kpi_bobot'] ?>" required>

      <button type="submit" class="btn btn-secondary btn-user btn-block mt-3">
        Update
      </button>
    </form>
  </div>

</div>

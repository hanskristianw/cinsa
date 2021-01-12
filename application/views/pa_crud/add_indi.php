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

    <form class="" action="<?= base_url('PA_CRUD/add_indi_proses'); ?>" method="post">

      <input type="hidden" name="kompe_pa_id" value="<?= $kompe_pa_id ?>">
      <input type="hidden" name="jabatan_kpi_id" value="<?= $jabatan_kpi_id ?>">

      <label style="font-size:14px;"><b>Nama Indikator:</b></label>
      <input type="text" class="form-control form-control-sm mb-3" name="indi_pa_nama" value="" required>

      <button type="submit" class="btn btn-secondary btn-user btn-block mt-3">
        Simpan
      </button>
    </form>
    <hr>
    <h5 class="mt-4 text-center"><u>Daftar Indikator</u></h4>
    <table class="table table-bordered table-hover table-sm mt-2" style="font-size:14px;">
      <thead class="thead-dark">
        <tr>
          <th class="pt-4 pb-4 pl-2">Indikator</th>
          <th class="pt-4 pb-4 pl-2 text-center" colspan="3" style="width:20%;">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        foreach ($all_indi as $m) :
        ?>
          <tr>
            <td><?= $m['indi_pa_nama'] ?></td>
            <td class="text-center">
              <form class="" action="<?= base_url('PA_CRUD/edit_indi') ?>" method="post">
                <input type="hidden" name="indi_pa_id" value=<?= $m['indi_pa_id'] ?>>
                <input type="hidden" name="jabatan_kpi_id" value="<?= $jabatan_kpi_id ?>">
                <button type="submit" class="badge badge-warning">
                  Edit
                </button>
              </form>
            </td>
          </tr>
        <?php
        endforeach;
        ?>
      </tbody>
    </table>
  </div>

</div>

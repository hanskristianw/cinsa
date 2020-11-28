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

    <form class="" action="<?= base_url('Jabatan_KPI_CRUD/edit_penilai_proses'); ?>" method="post">
      <label style="font-size:14px;"><b>Nama Jabatan:</b></label>
      <input type="hidden" name="dkpi_responden_jabatan_kpi_id" value="<?= $responden ?>">
      <select name="dkpi_penilai_jabatan_kpi_id" class="form-control form-control-sm">
        <?php
          foreach ($jabatan_all as $m) :
            echo "<option value=" . $m['jabatan_kpi_id'] . ">" . $m['jabatan_kpi_nama'] . "</option>";
          endforeach
        ?>
      </select>

      <button type="submit" class="btn btn-secondary btn-user btn-block mt-3">
        Update
      </button>
    </form>

    <hr>
    <h5 class="mt-4 text-center"><u>Daftar Penilai</u></h4>
    <table class="table table-bordered table-hover table-sm mt-2" style="font-size:14px;">
      <thead class="thead-dark">
        <tr>
          <th class="pt-4 pb-4 pl-2">Penilai</th>
          <th class="pt-4 pb-4 pl-2 text-center" colspan="3" style="width:20%;">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        foreach ($penilai_all as $m) :
        ?>
          <tr>
            <td><?= $m['jabatan_kpi_nama'] ?></td>
            <td class="text-center">
              <form class="" action="<?= base_url('Jabatan_KPI_CRUD/delete_penilai') ?>" method="post">
                <input type="hidden" name="dkpi_id" value=<?= $m['dkpi_id'] ?>>
                <button type="submit" class="badge badge-danger">
                  Delete
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

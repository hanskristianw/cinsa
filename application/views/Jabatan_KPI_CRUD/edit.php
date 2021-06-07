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

    <form class="" action="<?= base_url('Jabatan_KPI_CRUD/edit_proses'); ?>" method="post">

      <input type="hidden" name="jabatan_kpi_id" value="<?= $jabatan_all['jabatan_kpi_id'] ?>" required>
      <label style="font-size:14px;"><b>Nama Jabatan:</b></label>
      <input type="text" class="form-control form-control-sm mb-3" name="jabatan_kpi_nama" value="<?= $jabatan_all['jabatan_kpi_nama'] ?>" required>

      <!-- <label style="font-size:14px;"><b>Dapat melihat laporan untuk:</b></label>
      <select class="form-control form-control-sm mb-2" name="jabatan_kpi_hak"> -->
        <?php
          // if($jabatan_all['jabatan_kpi_hak'] == 0)
          //   echo "<option value = '0' selected>Semua unit</option>
          //         <option value = '1'>Hanya unit yang sama</option>";
          // elseif($jabatan_all['jabatan_kpi_hak'] == 1)
          //   echo "<option value = '0'>Semua unit</option>
          //         <option value = '1' selected>Hanya unit yang sama</option>";
        ?>
      <!-- </select> -->

      <label style="font-size:14px;"><b>Dapat menilai:</b></label>
      <select class="form-control form-control-sm" name="jabatan_kpi_hak_penilai">
        <?php
          if($jabatan_all['jabatan_kpi_hak_penilai'] == 0)
            echo "<option value = '0' selected>Semua unit</option>
                  <option value = '1'>Hanya unit yang sama + unit tambahan</option>";
          elseif($jabatan_all['jabatan_kpi_hak_penilai'] == 1)
            echo "<option value = '0'>Semua unit</option>
                  <option value = '1' selected>Hanya unit yang sama + unit tambahan</option>";
        ?>
      </select>

      <button type="submit" class="btn btn-secondary btn-user btn-block mt-3">
        Update
      </button>
    </form>
  </div>

</div>

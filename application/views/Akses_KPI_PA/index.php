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
    <h6 class="text-center"><b><u><?= $title ?></u></b></h6>
    <div><?= $this->session->flashdata('message'); ?></div>
  </div>
  <div class="box1">
    <table class="table table-sm table-bordered mt-4" style="font-size:13px;">
      <thead class="thead-dark">
        <th colspan="2" class="pt-3 pb-3">Status KPI</th>
        <th colspan="2" class="pt-3 pb-3">Status PA</th>
      </thead>
      <tbody>
        <tr>
          <td style="width:150px;">
            <?php
              if($a['akses_kpi'] == 0)
                echo "<label class='text-danger mt-2'><b>Tidak Dapat Diakses Karyawan</b></label>";
              else
                echo "<label class='text-success mt-2'><b>Dapat Diakses Karyawan</b></label>";
            ?>
          </td>
          <td>
            <form class="" action="<?= base_url('Akses_KPI_PA/update_kpi') ?>" method="post">
              <input type="hidden" name="akses_kpi" value=<?= $a['akses_kpi'] ?>>
              <button type="submit" class="badge badge-primary mt-2">
                Ubah Akses KPI
              </button>
            </form>
          </td>
          <td style="width:150px;">
            <?php
              if($a['akses_pa'] == 0)
                echo "<label class='text-danger mt-2'><b>Tidak Dapat Diakses Karyawan</b></label>";
              else
                echo "<label class='text-success mt-2'><b>Dapat Diakses Karyawan</b></label>";
            ?>
          </td>
          <td>
            <form class="" action="<?= base_url('Akses_KPI_PA/update_pa') ?>" method="post">
              <input type="hidden" name="akses_pa" value=<?= $a['akses_pa'] ?>>
              <button type="submit" class="badge badge-primary mt-2">
                Ubah Akses PA
              </button>
            </form>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

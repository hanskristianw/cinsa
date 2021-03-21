<style>
.grid-container {
  display: grid;
  grid-template-columns: 15% 15% 15% 25% 15% 15%;
  grid-column-gap:4px;
  padding-right:3px;
}
.grid-container > div{
  text-align:left;
}

.grid-main {
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
  overflow: auto;
}

.box2{
  /*align-self:start;*/
  display: grid;
  grid-template-columns: 50% 50%;
  margin-right: 20px;
}

</style>

<div class="grid-main">

  <div class="box1 text-center mt-4"><h4><u>Daftar Jabatan KPI</u></h4></div>


  <div class="box1">
    <a href="<?= base_url('Jabatan_KPI_CRUD/add') ?>" class="btn btn-primary mb-3">&plus; Jabatan</a>
  </div>

  <div class="box1">
    <?= $this->session->flashdata('message'); ?>
  </div>

  <div class="box1 mb-4">
    <table class="table table-bordered table-hover table-sm" style="font-size:14px;">
      <thead class="thead-dark">
        <tr>
          <th class="pt-4 pb-4 pl-2 text-center" colspan="4">Jabatan</th>
          <th class="pt-4 pb-4 pl-2 text-center" colspan="2">Penilai</th>
          <th class="pt-4 pb-4 pl-2 text-center" colspan="3" style="width:20%;">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        foreach ($jabatan_all as $m) :
        ?>
          <tr>
            <td><?= $m['responden'] ?></td>
            <td class="text-center">
              <form class="" action="<?= base_url('Jabatan_KPI_CRUD/edit_peserta') ?>" method="post">
                <input type="hidden" name="jabatan_kpi_id" value=<?= $m['jabatan_kpi_id'] ?>>
                <button type="submit" class="badge badge-info">
                  Edit Pegawai
                </button>
              </form>
            </td>
            <td class="text-center">
              <form class="" action="<?= base_url('Jabatan_KPI_CRUD/edit') ?>" method="post">
                <input type="hidden" name="jabatan_kpi_id" value=<?= $m['jabatan_kpi_id'] ?>>
                <button type="submit" class="badge badge-success">
                  Edit Nama
                </button>
              </form>
            </td>
            <td class="text-center">
              <form class="" action="<?= base_url('Laporan_KPI_CRUD') ?>" method="get">
                <input type="hidden" name="jabatan_kpi_id" value=<?= $m['jabatan_kpi_id'] ?>>
                <button type="submit" class="badge badge-secondary">
                  Dapat melihat laporan
                </button>
              </form>
            </td>
            <td><?= $m['penilai'] ?></td>
            <td class="text-center">
              <form class="" action="<?= base_url('Jabatan_KPI_CRUD/edit_penilai') ?>" method="post">
                <input type="hidden" name="jabatan_kpi_id" value=<?= $m['jabatan_kpi_id'] ?>>
                <button type="submit" class="badge badge-primary">
                  Edit Penilai
                </button>
              </form>
            </td>
            <td class="text-center">
              <form class="" action="<?= base_url('KPI_CRUD/tahun') ?>" method="get">
                <input type="hidden" name="jabatan_kpi_id" value=<?= $m['jabatan_kpi_id'] ?>>
                <button type="submit" class="badge badge-secondary">
                  Edit KPI
                </button>
              </form>
            </td>
            <td class="text-center">
              <form class="" action="<?= base_url('PA_CRUD/tahun') ?>" method="get">
                <input type="hidden" name="jabatan_kpi_id" value=<?= $m['jabatan_kpi_id'] ?>>
                <button type="submit" class="badge badge-secondary">
                  Edit PA
                </button>
              </form>
            </td>
            <td class="text-center">
              <form class="" action="<?= base_url('Jabatan_KPI_CRUD/delete') ?>" method="post">
                <input type="hidden" name="jabatan_kpi_id" value=<?= $m['jabatan_kpi_id'] ?>>
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

<script type="text/javascript">
  $(document).ready(function() {

    $(".alert-danger").fadeTo(2000, 500).slideUp(500, function() {
      $(".alert-danger").slideUp(500);
    });
    $(".alert-success").fadeTo(2000, 500).slideUp(500, function() {
      $(".alert-success").slideUp(500);
    });

  });
</script>

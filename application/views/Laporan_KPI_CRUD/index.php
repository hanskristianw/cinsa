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

  <div class="box1 text-center mt-4"><h5><u>Pilih jabatan laporan yang dapat dilihat oleh <?= $jabatan_nama['jabatan_kpi_nama'] ?></u></h5></div>


  <div class="box1">
    <?= $this->session->flashdata('message'); ?>
  </div>

  <div class="box1 mb-4">

      <?php if($jabatan_ada): ?>
        <label class="mt-3"><b><u>Jabatan sudah dapat dilihat</u>:</b></label>
        <table class="table table-bordered table-hover table-sm" style="font-size:14px;">
          <thead class="thead-dark">
            <th class="pt-3 pb-3">Nama Jabatan</th>
            <th class="pt-3 pb-3">Action</th>
          </thead>
          <tbody>
            <?php
              foreach ($jabatan_ada as $i) :
            ?>
            <tr>
              <td><?= $i['jabatan_kpi_nama'] ?></td>
              <td>
                <form class="" action="<?= base_url('Laporan_KPI_CRUD/delete') ?>" method="post">
                  <input type="hidden" name="lap_id" value=<?= $i['lap_id'] ?>>
                  <input type="hidden" name="lap_jabatan_kpi_melihat" value="<?= $lap_jabatan_kpi_melihat ?>">
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
      <?php endif; ?>

      <form class="" action="<?= base_url('Laporan_KPI_CRUD/input_proses') ?>" method="post">

        <input type="hidden" name="lap_jabatan_kpi_melihat" value="<?= $lap_jabatan_kpi_melihat ?>">

        <label class="mt-3"><b><u>Jabatan yang belum dapat dilihat</u>:</b></label>
        <table class="table table-bordered table-hover table-sm" style="font-size:14px;">
          <thead class="thead-dark">
            <th class="pt-3 pb-3 text-center" style="width:5%;">Pilih?</th>
            <th class="pt-3 pb-3">Nama Jabatan</th>
          </thead>
          <tbody>
            <?php
              foreach ($jabatan_tidak_ada as $i) :
            ?>
            <tr>
              <td class="text-center"> <input type="checkbox" name="jabatan_kpi_id[]" value="<?= $i['jabatan_kpi_id'] ?>"> </td>
              <td><?= $i['jabatan_kpi_nama'] ?></td>
            </tr>
            <?php
              endforeach;
            ?>
          </tbody>
        </table>
        <button type="submit" class="btn btn-success btn-user btn-block mt-3">
          Tambah
        </button>
      </form>

  </div>
</div>

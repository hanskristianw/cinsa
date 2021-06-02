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


  <div class="box1">
    <?= $this->session->flashdata('message'); ?>
  </div>


  <div class="box1 mb-4">

    <?php if($kr_all2): ?>

    <div class="box1 text-center mt-4 text-success"><h4><u>Daftar <?= $nama_jabatan ?></u></h4></div>
    <table class="table table-bordered table-hover table-sm" style="font-size:12px;">
      <thead class="thead-dark">
        <tr>
          <th style="width:5%;" class="pt-4 pb-4 pl-2 text-center">No</th>
          <th class="pt-4 pb-4 pl-2">Nama</th>
          <th style="width:10%;" class="pt-4 pb-4 pl-2 text-center">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $no = 1;
        $temp = "";
        foreach ($kr_all2 as $m) :
        ?>
        <?php if ($m['sk_nama'] !== $temp) : ?>
          <tr>
            <td colspan="3" class="text-center bg-info text-white pt-2 pb-2"><?= $m['sk_nama'] ?></td>
          </tr>
        <?php endif; ?>
          <tr>
            <td class="text-center m-0 pt-1 pb-0"><?= $no ?></td>
            <td class="m-0 pt-1 pb-0"><?= $m['kr_nama_depan'].' '.$m['kr_nama_belakang'] ?></td>
            <td class="text-center m-0 p-0">
              <form class="" action="<?= base_url('Jabatan_KPI_CRUD/delete_peserta') ?>" method="post">
                <input type="hidden" name="d_jabatan_kpi_id" value=<?= $m['d_jabatan_kpi_id'] ?>>
                <button type="submit" class="badge badge-danger">
                  Delete
                </button>
              </form>
            </td>
          </tr>
        <?php
        $no++;
        $temp = $m['sk_nama'];
        endforeach;
        ?>
      </tbody>
    </table>

    <?php endif; ?>


    <div class="box1 text-center text-danger mt-4"><h4><u>Daftar Karyawan yang TIDAK Terdaftar sebagai <?= $nama_jabatan ?></u></h4></div>

    <form class="" action="<?= base_url('Jabatan_KPI_CRUD/edit_peserta_proses'); ?>" method="post">
      <input type="hidden" name="jabatan_kpi_id" value="<?= $jabatan_kpi_id ?>">
      <table class="table table-bordered table-hover table-sm" style="font-size:12px;">
        <thead class="thead-dark">
          <tr>
            <th style="width:10%;" class="pt-4 pb-4 pl-2 text-center">Daftarkan?</th>
            <th class="pt-4 pb-4 pl-2">Nama</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $temp = "";
          foreach ($kr_all as $m) :
          ?>
          <?php if ($m['sk_nama'] !== $temp) : ?>
            <tr>
              <td colspan="2" class="text-center bg-secondary text-white"><?= $m['sk_nama'] ?></td>
            </tr>
          <?php endif; ?>
            <tr>
              <td class="text-center m-0 pt-1 pb-0"> <input type="checkbox" name="kr_id[]" value="<?= $m['kr_id'] ?>">  </td>
              <td class="m-0 pt-1 pb-0"><?= $m['kr_nama_depan'].' '.$m['kr_nama_belakang'] ?></td>
            </tr>
          <?php
            $temp = $m['sk_nama'];
          endforeach;
          ?>
        </tbody>
      </table>

      <button type="submit" class="btn btn-secondary btn-user btn-block mt-3">
        Simpan
      </button>
    </form>


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

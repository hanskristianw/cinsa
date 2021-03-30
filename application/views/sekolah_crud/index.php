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

  <?php
    function returnTypeUnit($no)
    {
      if ($no == "0")
        return "Sekolah";
      else
        return "Manajemen";
    }

    function returnTypeRapor($no)
    {
      if ($no == "0")
        return "NSA";
      else
        return "YPPI";
    }

    function returnTanggal($no)
    {
      $tgl = explode("-",$no);

      return $tgl[2].' '.return_nama_bulan_indo($tgl[1]).' '.$tgl[0];
    }
  ?>

  <div class="box1 text-center mt-4"><h4><u>Daftar Unit</u></h4></div>

  <div class="box1">
    <div class="alert alert-warning alert-dismissible fade show">
        <button class="close" data-dismiss="alert" type="button">
            <span>&times;</span>
        </button>
        <strong>Perhatian:</strong>
        <br><br>
        <ul>
          <li>Ubah rapor digunakan untuk merubah jenis rapor, jika sekolah NSA gunakan rapor jenis NSA dan sebaliknya</li>
          <li>Upload TTD kepsek sebaiknya menggunakan gambar dengan dimensi yang sama, misal 200px x 200px</li>
        </ul>
    </div>
  </div>

  <div class="box1">
    <a href="<?= base_url('sekolah_crud/add') ?>" class="btn btn-primary mb-3">&plus; Unit</a>
  </div>

  <div class="box1">
    <?= $this->session->flashdata('message'); ?>
  </div>

  <div class="box1 mb-4">
    <table class="table table-bordered table-hover table-sm" style="font-size:12px;">
      <thead class="thead-dark">
        <tr>
          <th class="pt-4 pb-4 pl-2">Nama</th>
          <th class="pt-4 pb-4 pl-2">Jenis Rapor</th>
          <th class="pt-4 pb-4 pl-2">Kepsek</th>
          <th class="pt-4 pb-4 pl-2">Tanggal Rapor Mid</th>
          <th class="pt-4 pb-4 pl-2">Tanggal Rapor Final</th>
          <th class="pt-4 pb-4 pl-2">Instagram</th>
          <th class="pt-4 pb-4 pl-2 text-center" colspan="3">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $temp = "";
        foreach ($sk_all as $m) :
        ?>

          <?php if ($m['sk_type'] !== $temp) : ?>
            <tr>
              <td colspan="9" class="text-center bg-info text-white"><?= returnTypeUnit($m['sk_type']) ?></td>
            </tr>
          <?php endif; ?>
          <tr>
            <td><?= $m['sk_nama'] ?></td>
            <?php if ($m['sk_type'] == 0) : ?>
              <td><?= returnTypeRapor($m['sk_jenis_rapor']) ?></td>
              <td><?= $m['kepsek'] ?></td>
              <td><?= returnTanggal($m['sk_mid']) ?></td>
              <td><?= returnTanggal($m['sk_fin']) ?></td>
              <td><?= $m['sk_insta'] ?></td>
            <?php else : ?>
              <td>-</td>
              <td>-</td>
              <td>-</td>
              <td>-</td>
              <td>-</td>
            <?php endif; ?>
            <td class="text-center">
              <form class="" action="<?= base_url('Sekolah_CRUD/update') ?>" method="post">
                <input type="hidden" name="_id" value=<?= $m['sk_id'] ?>>
                <input type="hidden" name="sk_type" value=<?= $m['sk_type'] ?>>
                <button type="submit" class="badge badge-warning">
                  Edit
                </button>
              </form>
            </td>

            <?php if ($m['sk_type'] == 0) : ?>
              <td class="text-center">
                <form class="" action="<?= base_url('Sekolah_CRUD/ttd_kepsek') ?>" method="post">
                  <input type="hidden" name="sk_id" value=<?= $m['sk_id'] ?>>
                  <button type="submit" class="badge badge-secondary">
                    Ttd Kepsek
                  </button>
                </form>
              </td>
              <td class="text-center">
                <form class="" action="<?= base_url('Sekolah_CRUD/ubah_rapor') ?>" method="post">
                  <input type="hidden" name="sk_id" value=<?= $m['sk_id'] ?>>
                  <button type="submit" class="badge badge-primary">
                    Ubah Rapor
                  </button>
                </form>
              </td>
            <?php else : ?>
              <td>-</td>
              <td>-</td>
            <?php endif; ?>
          </tr>
        <?php
          $temp = $m['sk_type'];
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

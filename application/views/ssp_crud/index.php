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
  grid-column-gap:3px;
}

</style>

<div class="grid-main">

    <div class="box1 mb-4">
      <div class="text-center">
          <h1 class="h4 text-gray-900 mb-4"><u><?= $title ?></u></h1>
      </div>

      <?= $this->session->flashdata('message'); ?>

      <div class="alert alert-warning alert-dismissible fade show">
          <button class="close" data-dismiss="alert" type="button">
              <span>&times;</span>
          </button>
          <strong>PERHATIAN:</strong><br>
          <ul>
            <li>Bila membuat SSP Scout, silahkan masukkan pesertanya menjadi semua siswa, jangan lupa berikan topik dan nilai sesuai semester</li>
            <li>Topik dan Nilai SSP dapat disetting oleh login guru pengajar</li>
          </ul>
      </div>

      <a href="<?= base_url('ssp_crud/add') ?>" class="btn btn-sm btn-primary mb-3">&plus; SSP/NSP</a>

      <table class="table table-sm table-bordered table-striped table-hover" style="font-size:14px;">
        <thead class='bg-dark text-light'>
          <tr>
            <th class="pt-3 pb-3">Nama</th>
            <th class="pt-3 pb-3">Tahun Ajaran</th>
            <th class="pt-3 pb-3">Pengajar</th>
            <th class="pt-3 pb-3">&Sigma; Peserta</th>
            <th class="pt-3 pb-3 text-center" colspan="4">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $t_nama_temp = "";
          foreach($ssp_all as $m) : ?>
          <?php
            if ($t_nama_temp != $m['t_nama']) {
              $tahun_fix = "<tr class='bg-secondary text-light'>
                                <td class='text-center' colspan='8'><b>" . $m['t_nama'] . "</b></td>
                              </tr>";
            } else {
              $tahun_fix = "";
            }
          ?>
          <?= $tahun_fix ?>
            <tr>
              <td style="width:150px;"><?= $m['ssp_nama'] ?></td>
              <td style="width:50px;"><?= $m['t_nama'] ?></td>
              <td><?= $m['kr_nama_depan'].' '.$m['kr_nama_belakang'] ?></td>
              <td style="width:50px;"><?= $m['jum_peserta'] ?></td>
              <td>
                <form class="" action="<?= base_url('SSP_CRUD/update') ?>" method="get">
                  <input type="hidden" name="_id" value=<?= $m['ssp_id'] ?>>
                  <button type="submit" class="badge badge-warning">
                      Edit SSP
                  </button>
                </form>
              </td>
              <td>
                <form class="" action="<?= base_url('SSP_CRUD/edit_student') ?>" method="post">
                  <input type="hidden" name="ssp_id" value=<?= $m['ssp_id'] ?>>
                  <button type="submit" class="badge badge-success">
                      Edit Peserta
                  </button>
                </form>
              </td>
              <td>
                <form class="" action="<?= base_url('SSP_CRUD/delete_grade') ?>" method="post">
                  <input type="hidden" name="ssp_id" value=<?= $m['ssp_id'] ?>>
                  <button type="submit" class="badge badge-primary">
                      &#10060; berdasarkan topik
                  </button>
                </form>
              </td>
              <td>
                <form class="" action="<?= base_url('SSP_CRUD/delete') ?>" method="post">
                  <input type="hidden" name="ssp_id" value=<?= $m['ssp_id'] ?>>
                  <button type="submit" class="badge badge-danger" onclick="return confirm('Seluruh nilai dan topik akan terhapus dan tidak dapat dikembalikan, lanjutkan?');">
                      &#10060; Delete
                  </button>
                </form>
              </td>
            </tr>
          <?php
            $t_nama_temp = $m['t_nama'];
            endforeach ?>
        </tbody>
      </table>
      <hr>
    </div>

</div>

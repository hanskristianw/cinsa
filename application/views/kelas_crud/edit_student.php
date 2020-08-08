<style>
.grid-main {
  display: grid;
  grid-template-columns: 100%;
  box-shadow: 5px 5px 5px 5px;
  padding: 10px;
  margin: 20px;
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
  grid-column-gap: 10px;
  padding-right:10px;
  padding-bottom:10px;
  overflow: auto;
}

</style>

<div class="grid-main">

  <div class="box2">
    <div>
      <div class="text-center">
        <h5 class="mt-3"><u><?= $title ?></u></h5>
      </div>
      <table class="table table-sm table-bordered display compact table-hover dt" style="font-size:13px;">
          <thead>
              <tr>
                  <th>Nama</th>
                  <th>No induk</th>
                  <th>Kelas Sebelumnya</th>
                  <th>Action</th>
              </tr>
          </thead>
          <tbody>
              <?php foreach ($sis_all as $m) : ?>
                  <tr>
                    <td><?= $m['sis_nama_depan'] ?> <?= $m['sis_nama_bel'] ?></td>
                    <td><?= $m['sis_no_induk'] ?></td>
                    <td>
                      <?= get_kelas_t_sebelumnya($m['sis_id'], $t_sebelum); ?>
                    </td>
                    <td>
                      <form class="" action="<?= base_url('Kelas_CRUD/edit_student') ?>" method="post">
                          <input type="hidden" name="sis_id" value=<?= $m['sis_id'] ?>>
                          <input type="hidden" name="kelas_id" value=<?= $kelas_all['kelas_id']; ?>>
                          <button type="submit" class="ml-2 badge badge-success">
                              &plus; <?= $kelas_all['kelas_nama']; ?>
                          </button>
                      </form>
                    </td>
                  </tr>
              <?php endforeach ?>
          </tbody>
      </table>
    </div>

    <div>
      <div class="text-center">
        <h5 class="mt-3"><u>Siswa di <?= $kelas_all['kelas_nama']; ?></u></h5>
      </div>
      <div class="mb-3 pr-3 pl-3"><?= $this->session->flashdata('message'); ?></div>
      <table class="table table-sm table-bordered display compact table-hover dt" style="font-size:13px;">
          <thead>
            <tr>
              <th>Nama</th>
              <th>No induk</th>
              <th>Angkatan</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($d_s_all as $m) : ?>
                <tr>
                  <td><?= $m['sis_nama_depan'] ?> <?= $m['sis_nama_bel'] ?></td>
                  <td><?= $m['sis_no_induk'] ?></td>
                  <td><?= $m['t_nama'] ?></td>
                  <td>
                    <form class="" action="<?= base_url('Kelas_CRUD/delete_student') ?>" method="post">
                        <input type="hidden" name="d_s_id" value=<?= $m['d_s_id'] ?>>
                        <input type="hidden" name="kelas_id" value=<?= $kelas_all['kelas_id']; ?>>
                        <button onclick="return confirm('Seluruh nilai siswa akan hilang jika melakukan penghapusan, lanjutkan?')" type="submit" class="ml-2 badge badge-danger">
                            Hapus
                        </button>
                    </form>
                  </td>
                </tr>
            <?php endforeach ?>
          </tbody>
      </table>
    </div>
  </div>
</div>

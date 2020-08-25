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

  <div class="box1 text-center">
    <h1 class="h4 text-gray-900 mb-4"><u>Daftar Siswa</u></h1>
  </div>

  <div class="box1">
    <?= $this->session->flashdata('message'); ?>
  </div>

  <div class="box1">
    <a href="<?= base_url('siswa_crud/add_baru') ?>" class="btn btn-sm btn-primary mb-3">&plus; Siswa</a>
    <a href="<?= base_url('siswa_crud/add_csv') ?>" class="btn btn-sm btn-success mb-3">&plus; Siswa dari CSV</a>
  </div>

  <div class="box1 mb-4">
    <table class="table table-sm table-bordered display compact table-hover dt" style="font-size:13px;">
      <thead>
        <tr class="bg-dark text-white text-center">
          <th class="p-3" rowspan="2">Nama</th>
          <th style='width: 50px;' class="p-3" rowspan="2">No Induk</th>
          <th class="p-3" rowspan="2">Email</th>
          <th class="p-3" rowspan="2">NISN</th>
          <th class="p-3" rowspan="2">Gender</th>
          <th class="p-3" rowspan="2">Agama</th>
          <th class="p-3" rowspan="2">Tahun Masuk</th>
          <th class="p-3" colspan="2">Action</th>
        </tr>
        <tr class="bg-dark text-white text-center">
          <th></th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($sis_all as $m) : ?>
          <tr>
            <td><?= $m['sis_nama_depan'] ?> <?= $m['sis_nama_bel'] ?></td>
            <td><?= $m['sis_no_induk'] ?></td>
            <td><?= $m['sis_email'] ?></td>
            <td><?= $m['sis_nisn'] ?></td>
            <td>
              <?php
                if($m['sis_jk'] == "1"){
                  echo "Laki";
                }else{
                  echo "Perempuan";
                }

              ?>

            </td>
            <td><?= $m['agama_nama'] ?></td>
            <td><?= $m['t_nama'] ?></td>
            <td>
              <form class="" action="<?= base_url('Siswa_CRUD/update_baru') ?>" method="post">
                <input type="hidden" name="sis_id" value=<?= $m['sis_id'] ?>>
                <button type="submit" class="badge badge-warning">
                  Edit
                </button>
              </form>
            </td>
            <td>
                <form class="" action="<?= base_url('Siswa_CRUD/delete') ?>" method="post">
                  <input type="hidden" name="sis_id" value=<?= $m['sis_id'] ?>>
                  <button onclick="return confirm('Siswa tidak akan dapat dihapus jika sudah ada dalam kelas, coba untuk melakukan penghapusan?')" type="submit" class="badge badge-danger">
                    Del
                  </button>
                </form>
            </td>
          </tr>
        <?php endforeach ?>
      </tbody>
    </table>
  </div>

</div>

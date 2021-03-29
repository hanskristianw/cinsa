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

      <div class="alert alert-warning alert-dismissible fade show">
          <button class="close" data-dismiss="alert" type="button">
              <span>&times;</span>
          </button>
          <strong>PERHATIAN:</strong><br><br>
          <ul>
            <li>Mapel Khusus hanya nama pengganti mapel asal di rapor sisipan, bukan merupakan mapel tambahan, jika ingin menambah mapel silahkan ke menu master mapel</li><br>
            <li>Mapel Khusus digunakan jika terdapat pembagian kelompok di dalam mapel asal yang diikuti sebagian siswa, misal mandarin beginner diikuti 10 siswa, mandarin advance diikuti 20 siswa</li>
          </ul>
      </div>

      <?= $this->session->flashdata('message'); ?>

      <a href="<?= base_url('mk_crud/add') ?>" class="btn btn-primary mb-3">&plus; Mapel</a>

      <table class="table display compact table-hover dt">
        <thead>
          <tr>
            <th>Nama Mapel Khusus</th>
            <th>Mapel Asal</th>
            <th>Tahun Ajaran</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          foreach($mk_all as $m) : ?>
            <tr>
              <td><?= $m['mk_nama'] ?></td>
              <td><?= $m['mapel_nama'] ?></td>
              <td><?= $m['t_nama'] ?></td>
              <td>
                <div class="form-group row m-0 p-0">
                  <form class="" action="<?= base_url('MK_CRUD/update') ?>" method="get">
                    <input type="hidden" name="mk_id" value=<?= $m['mk_id'] ?>>
                    <button type="submit" class="badge badge-warning">
                        Edit
                    </button>
                  </form>
                  <form class="" action="<?= base_url('MK_CRUD/edit_student') ?>" method="post">
                    <input type="hidden" name="mk_id" value=<?= $m['mk_id'] ?>>
                    <button type="submit" class="badge badge-success">
                        Edit Siswa
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          <?php endforeach ?>
        </tbody>
      </table>
      <hr>
    </div>

</div>

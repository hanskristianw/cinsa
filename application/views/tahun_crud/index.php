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

<?php
function return_jenis_rapor($num)
{
  if ($num == 1)
    return "Sisipan";
  elseif ($num == 2)
    return "Semester";
}
?>

<div class="grid-main">

  <div class="box1 mb-4">
    <div class="text-center">
      <h1 class="h4 text-gray-900 mb-4"><u>Daftar Tahun Ajaran</u></h1>
    </div>

    <?= $this->session->flashdata('message'); ?>

    <div class="alert alert-warning alert-dismissible fade show">
        <button class="close" data-dismiss="alert" type="button">
            <span>&times;</span>
        </button>
        <strong>Perhatian:</strong>
        <br><br>
        <ul>
          <li>Tahun ajaran tidak dapat dihapus, jika salah lakukan edit</li>
          <li>Tanggal mulai dan tanggal berakhir sama dengan waktu XAMPP di server tempat program berjalan, bisa jadi terdapat perbedaan waktu beberapa jam dengan waktu server</li>
        </ul>
    </div>

    <a href="<?= base_url('tahun_crud/add') ?>" class="btn btn-secondary mb-3">&plus; Tahun Ajaran</a>

    <table class="table table-sm table-bordered" style="font-size:13px;">
      <thead>
        <tr class="bg-dark text-white">
          <th style="height: 50px;" class="align-middle  text-center">Nama<br>Tahun Ajaran</th>
          <th class="align-middle text-center">Tanggal Mulai<br>Tahun Ajaran</th>
          <th class="align-middle text-center">Tanggal Berakhir<br>Tahun Ajaran</th>
          <th class="align-middle text-center">Semester Aktif<br>untuk Web Student<br>dan Android</th>
          <th class="align-middle text-center">Jenis Rapor yang dapat dilihat<br>untuk Web Student<br>dan Android</th>
          <th class="align-middle text-center">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($tahun_all as $m) : ?>
          <tr>
            <td class="align-middle text-center"><?= $m['t_nama'] ?></td>
            <td class="align-middle text-center"><?= date("d-m-Y", strtotime($m['t_awal'])) ?></td>
            <td class="align-middle text-center"><?= date("d-m-Y", strtotime($m['t_akhir'])) ?></td>
            <td class="align-middle text-center"><?= $m['t_sem_aktif'] ?></td>
            <td class="align-middle text-center"><?= return_jenis_rapor($m['t_jenis_rapor']) ?></td>
            <td class="align-middle text-center">
              <form class="" action="<?= base_url('Tahun_CRUD/update') ?>" method="get">
                <input type="hidden" name="_id" value=<?= $m['t_id'] ?>>
                <button type="submit" class="badge badge-warning">
                  Edit
                </button>
              </form>
            </td>
          </tr>
        <?php endforeach ?>
      </tbody>
    </table>
    <hr>
  </div>

</div>

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
    <h1 class="h4 text-gray-900 mb-4"><u><?= $title ?></u></h1>
  </div>

  <div class="box1">
    <?= $this->session->flashdata('message'); ?>
  </div>

  <div class="box1 mb-4">
    <table class="table table-sm table-bordered display compact table-hover dt" style="font-size:12px;">
      <thead>
        <tr class="bg-dark text-white text-center">
          <th style='width: 100px;' class="p-3">No Induk</th>
          <th style='width: 50px;' class="p-3">Tahun Masuk</th>
          <th style='width: 120px;' class="p-3">Asal Sekolah</th>
          <th style='width: 50px;' class="p-3">Status</th>
          <th class="p-3">Nama Siswa</th>
          <th class="p-3">Nama Ayah</th>
          <th class="p-3">Nama Ibu</th>
          <th class="p-3">Gender</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($sis_all as $m) : ?>
          <tr>
            <td><?= $m['sis_no_induk'] ?></td>
            <td><?= $m['t_nama'] ?></td>
            <td><?= $m['sk_nama'] ?></td>
            <td><?= $m['sis_alumni'] ?></td>
            <td><?= strtoupper($m['sis_nama_depan']) ?> <?= strtoupper($m['sis_nama_bel']) ?></td>
            <td><?= $m['sis_ayah'] ?></td>
            <td><?= $m['sis_ibu'] ?></td>
            <td>
              <?= $m['sis_jk'] ?>
            </td>
          </tr>
        <?php endforeach ?>
      </tbody>
    </table>
  </div>

</div>

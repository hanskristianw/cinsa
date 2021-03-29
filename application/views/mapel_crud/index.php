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

      <a href="<?= base_url('mapel_crud/add') ?>" class="btn btn-secondary mb-3">&plus; Mapel</a>

      <table class="table table-sm table-hover table-bordered table-striped" style="font-size:14px;">
        <thead>
          <tr>
            <th>Nama</th>
            <th style="width:50px;">KKM</th>
            <th style="width:100px;">Singkatan</th>
            <th style="width:60px;">Urutan dalam rapor</th>
            <th class="text-center" colspan="2">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($mapel_all as $m) : ?>
            <tr>
              <td><?= $m['mapel_nama'] ?></td>
              <td><?= $m['mapel_kkm'] ?></td>
              <td><?= $m['mapel_sing'] ?></td>
              <td><?= $m['mapel_urutan'] ?></td>
              <td style="width:60px;" class="text-center">
                <form class="" action="<?= base_url('Mapel_CRUD/update') ?>" method="get">
                  <input type="hidden" name="_id" value=<?= $m['mapel_id'] ?>>
                  <button type="submit" class="badge badge-warning">
                      Edit
                  </button>
                </form>
              </td>
              <td style="width:60px;" class="text-center">
                <form class="" action="<?= base_url('Mapel_CRUD/delete') ?>" method="post">
                  <input type="hidden" name="mapel_id" value=<?= $m['mapel_id'] ?>>
                  <button onclick="return confirm('Lanjutkan?, Seluruh nilai pada mapel akan terhapus dan tidak dapat dikembalikan');" type="submit" class="badge badge-danger">
                      Delete
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

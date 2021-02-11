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

  <div class="box1 text-center mt-4"><h4><u><?= $title ?></u></h4></div>

  <div class="box1">
    <?= $this->session->flashdata('message'); ?>
  </div>

  <div class="box1">
    <a href="<?= base_url('Jenjang_crud/add') ?>" class="btn btn-primary mb-3">Tambah Jenjang</a>
  </div>

  <div class="box1 mb-4">
    <table class="table table-bordered display compact table-hover dt" style="font-size:14px;">
      <thead class="thead-dark">
        <tr>
          <th style="height:40px;" class="pb-4">Nama</th>
          <th class="pb-4">Urutan</th>
          <th style="width:100px;" colspan="2" class="pb-4">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($jenj_all as $m) : ?>
          <tr>
            <td><?= $m['jenj_nama'] ?></td>
            <td><?= $m['jenj_urutan'] ?></td>
            <td style="width:50px;">
              <form action="<?= base_url('Jenjang_CRUD/update') ?>" method="get">
                <input type="hidden" name="_id" value=<?= $m['jenj_id'] ?>>
                <button type="submit" class="badge badge-warning">
                  Edit
                </button>
              </form>
            </td>
            <td style="width:50px;">
              <form action="<?= base_url('Jenjang_CRUD/delete') ?>" method="post">
                <input type="hidden" name="jenj_id" value=<?= $m['jenj_id'] ?>>
                <button type="submit" class="badge badge-danger" onclick="return confirm('Jenjang yang sudah memiliki kelas tidak dapat dihapus, coba untuk hapus?')">
                  Delete
                </button>
              </form>
            </td>
          </tr>
        <?php endforeach ?>
      </tbody>
    </table>
  </div>

</div>

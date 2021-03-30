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
      <div class="text-center">
          <h1 class="h4 text-gray-900 mb-4"><u><?= $title ?></u></h1>
      </div>

      <?= $this->session->flashdata('message'); ?>

      <a href="<?= base_url('karakter_crud/add') ?>" class="btn btn-secondary mb-3">&plus; Karakter</a>

      <table class="table display compact table-hover dt table-bordered" style="font-size:13px;">
        <thead>
          <tr>
            <th>Nama Karakter</th>
            <th>Karakter A</th>
            <th>Karakter B</th>
            <th>Karakter C</th>
            <th>Urutan</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($karakter_all as $m) : ?>
            <tr>
              <td><?= $m['karakter_nama'] ?></td>
              <td><?= $m['karakter_a'] ?></td>
              <td><?= $m['karakter_b'] ?></td>
              <td><?= $m['karakter_c'] ?></td>
              <td><?= $m['karakter_urutan'] ?></td>
              <td>
                <div class="form-group row m-0 p-0">
                  <form class="" action="<?= base_url('Karakter_CRUD/update') ?>" method="get">
                    <input type="hidden" name="_id" value=<?= $m['karakter_id'] ?>>
                    <button type="submit" class="badge badge-success">
                        Edit Karakter
                    </button>
                  </form>
                  <form class="" action="<?= base_url('Karakter_CRUD/edit_subject') ?>" method="post">
                    <input type="hidden" name="karakter_id" value=<?= $m['karakter_id'] ?>>
                    <button type="submit" class="badge badge-primary">
                        Edit Mapel
                    </button>
                  </form>
                  <form class="" action="<?= base_url('Karakter_CRUD/delete') ?>" method="post">
                    <input type="hidden" name="karakter_id" value=<?= $m['karakter_id'] ?>>
                    <button type="submit" class="badge badge-danger">
                        Delete
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

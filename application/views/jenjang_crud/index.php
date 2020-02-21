<style>
.grid-d {
  display: grid;
  grid-template-columns: 50% 50%;
}
</style>

<div class="container">

  <div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
      <!-- Nested Row within Card Body -->
      <div class="row">
        <div class="col-lg">
          <div class="p-5 overflow-auto">
            <div class="text-center">
              <h1 class="h4 text-gray-900 mb-4">Daftar Jenjang</h1>
            </div>


            <?= $this->session->flashdata('message'); ?>

            <a href="<?= base_url('Jenjang_crud/add') ?>" class="btn btn-primary mb-3">Tambah Jenjang</a>

            <table class="table table-bordered display compact table-hover dt" style="font-size:14px;">
              <thead>
                <tr>
                  <th>Nama</th>
                  <th>Urutan</th>
                  <th style="width:100px;">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($jenj_all as $m) : ?>
                  <tr>
                    <td><?= $m['jenj_nama'] ?></td>
                    <td><?= $m['jenj_urutan'] ?></td>
                    <td>
                      <div class="grid-d">
                        <div>
                          <form class="" action="<?= base_url('Jenjang_CRUD/update') ?>" method="get">
                            <input type="hidden" name="_id" value=<?= $m['jenj_id'] ?>>
                            <button type="submit" class="badge badge-warning">
                              Edit
                            </button>
                          </form>
                        </div>
                        <div class="mr-2">
                          <form class="" action="" method="post">
                            <input type="hidden" name="" value="">
                            <button type="submit" class="badge badge-danger">
                              Delete
                            </button>
                          </form>
                        </div>
                      </div>
                    </td>
                  </tr>
                <?php endforeach ?>
              </tbody>
            </table>
            <hr>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>
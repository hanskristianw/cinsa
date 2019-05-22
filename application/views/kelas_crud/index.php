<div class="container">

  <div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
      <!-- Nested Row within Card Body -->
      <div class="row">
        <div class="col-lg">
          <div class="p-5 overflow-auto">
            <div class="text-center">
              <h1 class="h4 text-gray-900 mb-4">List of Class</h1>
            </div>
            

            <?= $this->session->flashdata('message'); ?>
            
            <a href="<?= base_url('kelas_crud/add') ?>" class="btn btn-primary mb-3">Add New Class</a>

            <table class="table display compact table-hover dt">
              <thead>
                <tr>
                  <th>List of Class</th>
                  <th>Year</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($kelas_all as $m) : ?>
                  <tr>
                    <td><?= $m['kelas_nama'] ?></td>
                    <td><?= $m['t_nama'] ?></td>
                    <td>
                      <div class="form-group row">
                        <form class="" action="<?= base_url('Kelas_CRUD/update') ?>" method="get">
                          <input type="hidden" name="_id" value=<?= $m['kelas_id'] ?>>
                          <button type="submit" class="badge badge-warning">
                            Edit
                          </button>
                        </form>
                        <form class="" action="" method="post">
                          <input type="hidden" name="" value="">
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
      </div>
    </div>
  </div>

</div>
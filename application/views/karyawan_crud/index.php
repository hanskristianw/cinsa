<div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
            <div class="col-lg">
              <div class="p-5 overflow-auto">
                  <div class="text-center">
                      <h1 class="h4 text-gray-900 mb-4">Employee List</h1>
                  </div>

                  <a href="<?= base_url('karyawan_crud/add') ?>" class="btn btn-primary mb-3">Add New Employee</a>

                  <table class="table display compact table-hover dt">
                    <thead>
                      <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Username</th>
                        <th>Jabatan</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach($kr_all as $m) : ?>
                        <tr>
                          <td><?= $m['kr_nama_depan'] ?></td>
                          <td><?= $m['kr_nama_belakang'] ?></td>
                          <td><?= $m['kr_username'] ?></td>
                          <td><?= $m['jabatan_nama'] ?></td>
                          <td>
                            <div class="form-group row">
                              <form class="" action="<?= base_url('Karyawan_CRUD/update') ?>" method="get">
                                <input type="hidden" name="_id" value=<?= $m['kr_id'] ?>>
                                <button type="submit" class="badge badge-warning">
                                    Edit
                                </button>
                              </form>
                              <form class="" action="" method="get">
                                <input type="hidden" name="" value=<?= $m['kr_id'] ?>>
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

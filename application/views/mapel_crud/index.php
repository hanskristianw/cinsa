<div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
            <div class="col-lg">
              <div class="p-5 overflow-auto">
                  <div class="text-center">
                      <h1 class="h4 text-gray-900 mb-4">Subject List</h1>
                  </div>

                  <?= $this->session->flashdata('message'); ?>

                  <a href="<?= base_url('mapel_crud/add') ?>" class="btn btn-primary mb-3">Add New Subject</a>

                  <table class="table display compact table-hover dt">
                    <thead>
                      <tr>
                        <th>Subject Name</th>
                        <th>Passing Grade</th>
                        <th>Abbreviation</th>
                        <th>Order</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach($mapel_all as $m) : ?>
                        <tr>
                          <td><?= $m['mapel_nama'] ?></td>
                          <td><?= $m['mapel_kkm'] ?></td>
                          <td><?= $m['mapel_sing'] ?></td>
                          <td><?= $m['mapel_urutan'] ?></td>
                          <td>
                            <div class="form-group row">
                              <form class="" action="<?= base_url('Mapel_CRUD/update') ?>" method="get">
                                <input type="hidden" name="_id" value=<?= $m['mapel_id'] ?>>
                                <button type="submit" class="badge badge-warning">
                                    Edit
                                </button>
                              </form>
                              <form class="" action="<?= base_url('Mapel_CRUD/delete') ?>" method="post">
                                <input type="hidden" name="mapel_id" value=<?= $m['mapel_id'] ?>>
                                <button onclick="return confirm('Lanjutkan?, Seluruh nilai pada mapel akan terhapus dan tidak dapat dikembalikan');" type="submit" class="badge badge-danger">
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

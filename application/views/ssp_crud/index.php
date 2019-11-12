<div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
            <div class="col-lg">
              <div class="p-5 overflow-auto">
                  <div class="text-center">
                      <h1 class="h4 text-gray-900 mb-4">Extracurricular List</h1>
                  </div>

                  <?= $this->session->flashdata('message'); ?>

                  <a href="<?= base_url('ssp_crud/add') ?>" class="btn btn-primary mb-3">Add New</a>

                  <table class="table display compact table-hover dt">
                    <thead>
                      <tr>
                        <th>Name</th>
                        <th>Year</th>
                        <th>Teacher</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 
                      foreach($ssp_all as $m) : ?>
                        <tr>
                          <td><?= $m['ssp_nama'] ?></td>
                          <td><?= $m['t_nama'] ?></td>
                          <td><?= $m['kr_nama_depan'] ?></td>
                          <td>
                            <div class="form-group row">
                              <form class="" action="<?= base_url('SSP_CRUD/update') ?>" method="get">
                                <input type="hidden" name="_id" value=<?= $m['ssp_id'] ?>>
                                <button type="submit" class="badge badge-warning">
                                    Edit
                                </button>
                              </form>
                              <form class="" action="<?= base_url('SSP_CRUD/edit_student') ?>" method="post">
                                <input type="hidden" name="ssp_id" value=<?= $m['ssp_id'] ?>>
                                <button type="submit" class="badge badge-success">
                                    Edit Students
                                </button>
                              </form>
                              <form class="" action="<?= base_url('SSP_CRUD/delete_grade') ?>" method="post">
                                <input type="hidden" name="ssp_id" value=<?= $m['ssp_id'] ?>>
                                <button type="submit" class="badge badge-primary">
                                    Delete Grade
                                </button>
                              </form>
                              <form class="" action="" method="get">
                                <input type="hidden" name="" value=<?= $m['ssp_id'] ?>>
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

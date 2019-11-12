<div class="container">

  <div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
      <!-- Nested Row within Card Body -->
      <div class="row">
        <div class="col-lg">
          <div class="p-5 overflow-auto">
            <div class="text-center">
              <h1 class="h4 text-gray-900 mb-4">School List</h1>
            </div>

            <a href="<?= base_url('sekolah_crud/add') ?>" class="btn btn-primary mb-3">Add New School</a>

            <?= $this->session->flashdata('message'); ?>

            <table class="table table-bordered table-sm display compact table-hover dt">
              <thead>
                <tr>
                  <th>School Name</th>
                  <th>Principal</th>
                  <th>Vice Principal of<br>Students Affairs</th>
                  <th>Scout<br>Teacher</th>
                  <th>Mid<br>Report Date</th>
                  <th>Final<br>Report Date</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($sk_all as $m) : ?>
                  <tr>
                    <td><?= $m['sk_nama'] ?></td>
                    <td><?= $m['kepsek'] ?></td>
                    <td><?= $m['wakasis'] ?></td>
                    <td><?= $m['guru_scout'] ?></td>
                    <td><?= $m['sk_mid'] ?></td>
                    <td><?= $m['sk_fin'] ?></td>
                    <td class="pl-3">
                      <div class="form-group row">
                        <form class="" action="<?= base_url('Sekolah_CRUD/update') ?>" method="get">
                          <input type="hidden" name="_id" value=<?= $m['sk_id'] ?>>
                          <button type="submit" class="badge badge-warning">
                            Edit
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
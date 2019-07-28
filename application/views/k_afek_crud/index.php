<div class="container">

  <div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
      <!-- Nested Row within Card Body -->
      <div class="row">
        <div class="col-lg">
          <div class="p-5 overflow-auto">
            <div class="text-center">
              <h1 class="h4 text-gray-900 mb-4"><?= $title ?></h1>
            </div>
            <div class="p-2"><?= $this->session->flashdata('message'); ?></div>
            <a href="<?= base_url('k_afek_crud/add') ?>" class="btn btn-primary mb-3">Add New Indicator</a>

            <table class="table display compact table-hover dt">
              <thead>
                <tr>
                  <th>Indicator Name</th>
                  <th>Indicator 1</th>
                  <th>Indicator 2</th>
                  <th>Indicator 3</th>
                  <th>Month</th>
                  <th>Year</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($k_afek_all as $m) : ?>
                  <tr>
                    <td><?= $m['k_afek_topik_nama'] ?></td>
                    <td><?= $m['k_afek_1'] ?></td>
                    <td><?= $m['k_afek_2'] ?></td>
                    <td><?= $m['k_afek_3'] ?></td>
                    <td><?= $m['bulan_nama'] ?></td>
                    <td><?= $m['t_nama'] ?></td>
                    <td>
                      <div class="form-group row">
                        <form class="" action="<?= base_url('k_afek_crud/update') ?>" method="get">
                          <input type="hidden" name="_id" value=<?= $m['k_afek_id'] ?>>
                          <button type="submit" class="badge badge-warning">
                            Edit
                          </button>
                        </form>
                        <form class="" action="" method="post">
                          <input type="hidden" name="" method="get" value=<?= $m['k_afek_id'] ?>>
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
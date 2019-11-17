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

            <form action="k_afek_crud/add" class="mb-3" method="POST">
              <input type="hidden" name="sk_id" value = <?= $sk_id ?>>
              <button type="submit" class="btn btn-primary btn-user">
                Add New Indicator
              </button>
            </form>
            
            <table style='font-size:13px;' class="table table-bordered display compact table-hover dt">
              <thead>
                <tr>
                  <th>Value</th>
                  <th>Indicator 1</th>
                  <th>Indicator 2</th>
                  <th>Indicator 3</th>
                  <th>Score 1</th>
                  <th>Score 2</th>
                  <th>Score 3</th>
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
                    <td><?= $m['k_afek_instruksi_1'] ?></td>
                    <td><?= $m['k_afek_instruksi_2'] ?></td>
                    <td><?= $m['k_afek_instruksi_3'] ?></td>
                    <td><?= $m['bulan_nama'] ?></td>
                    <td><?= $m['t_nama'] ?></td>
                    <td>
                      <div class="form-group row ml-1">
                        <form class="" action="<?= base_url('k_afek_crud/update') ?>" method="post">
                          <input type="hidden" name="k_afek_id" value=<?= $m['k_afek_id'] ?>>
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
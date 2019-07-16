<div class="container">

  <div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
      <!-- Nested Row within Card Body -->
      <div class="row">
        <div class="col-lg">
          <div class="p-5 overflow-auto">
            <div class="text-center">
              <h1 class="h4 text-gray-900 mb-4">List of SSP</h1>
            </div>

            <?= $this->session->flashdata('message'); ?>

            <form class="user" action="SSP_grade_CRUD/input" method="POST">

              <div class="form-group row">
                <div class="col-sm mb-sm-0">
                  <select name="arr_ssp" id="arr_ssp" class="form-control">
                    <?php foreach ($ssp_all as $m) : ?>
                      <option value='<?= $m['ssp_id'] ?>'>
                        <?= "(".$m['t_nama'].") ".$m['ssp_nama'] ?>
                      </option>
                    <?php endforeach ?>
                  </select>
                </div>
              </div>

              <button type="submit" class="btn btn-primary btn-user btn-block">
                  Insert Grade
              </button>
            </form>

          </div>
        </div>
      </div>
    </div>
  </div>

</div>

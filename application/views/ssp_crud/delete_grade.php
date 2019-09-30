<div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                
                <div class="col-lg p-5">
                    <div class="text-center">
                        <h1 class="h4 text-gray-900 mt-4 mb-4">Delete SSP Grade</h1>
                    </div>

                    <form class="user" action="<?= base_url('SSP_CRUD/delete_grade_show'); ?>" method="POST">
                        <div class="col-sm mb-sm-0">
                          <select name="ssp_topik_id" class="form-control">
                              <?php foreach ($topik_all as $m) : ?>
                              <option value='<?=$m['ssp_topik_id']?>'>
                                  <?= $m['ssp_topik_nama'] ?>
                              </option>
                              <?php endforeach ?>
                          </select>
                          <button type="submit" class="btn btn-primary btn-user btn-block mt-3">
                            View Grade
                          </button>
                        </div>
                    </form>
                </div>
                
            </div>
        </div>
    </div>

</div>
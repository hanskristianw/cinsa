<div class="container">

  <div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
      <!-- Nested Row within Card Body -->
      <div class="row">
        <div class="col-lg">
          <div class="p-5 overflow-auto">
            <div class="text-center">
              <h1 class="h4 text-gray-900"><u><b>COUNSELOR LIST</b></u></h1>
              <h5 class="text-gray-900 mb-4">Select School</h5>
            </div>

            <input type="hidden" id="tes_flag" value = 1>

            <?= $this->session->flashdata('message'); ?>

            <form class="user" action="<?= base_url('Konselor_CRUD/add') ?>" method="POST">
              <div class="form-group row">
                <div class="col-sm mb-sm-0">
                  <select name="sk_id" id="kadiv_kon_sk" class="form-control mb-3">
                    <option value="0">Select School</option>
                    <?php foreach ($sk_all as $m) : ?>
                      <option value='<?= $m['sk_id'] ?>'>
                        <?= $m['sk_nama'] ?>
                      </option>
                    <?php endforeach ?>
                  </select>
                </div>
              </div>
              <div id="but_konselor">
                <button type="submit" class="btn btn-primary btn-user mt-4">
                  Add Counselor
                </button>
              </div>
            </form>
            
            <div id="kadiv_kon_detail">
                
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>

</div>

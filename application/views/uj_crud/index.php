<div class="container">

  <div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
      <!-- Nested Row within Card Body -->
      <div class="row">
        <div class="col-lg">
          <div class="p-5 overflow-auto">
            <div class="text-center">
              <h1 class="h4 text-gray-900 mb-4">List of Class & Subject</h1>
            </div>

            <?= $this->session->flashdata('message'); ?>

            <form class="user" action="<?= base_url('Uj_CRUD/input') ?>" method="POST">
              <input type="hidden" id="flag_uj" value="1">
              <div class="form-group row">
                <div class="col-sm mb-sm-0">
                  <select name="t_id" id="tes_t_id" class="form-control">
                    <option value="0">Select Year</option>
                    <?php foreach ($t_all as $m) : ?>
                      <option value='<?= $m['t_id'] ?>'>
                        <?= $m['t_nama'] ?>
                      </option>
                    <?php endforeach ?>
                  </select>
                </div>
                <div class="col-sm mb-sm-0">
                  <select name="cek_agama" class="form-control">
                      <option value='0'>Order By Name</option>
                      <option value='1'>Group By Religion</option>
                  </select>
                </div>
              </div>
              <div id="kelas_tes_ajax">
              
              </div>
              <div id="mapel_tes_ajax">
              
              </div>
            </form>

          </div>
        </div>
      </div>
    </div>
  </div>

</div>

<div class="container">

  <div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
      <!-- Nested Row within Card Body -->
      <div class="row">
        <div class="col-lg">
          <div class="p-5 overflow-auto">
            <div class="text-center">
              <h1 class="h4 text-gray-900"><u><b>MID & FINAL</b></u></h1>
              <h5 class="text-gray-900 mb-4">Select School and Class</h5>
            </div>

            <?= $this->session->flashdata('message'); ?>

            <form class="user" action="<?= base_url('Uj_CRUD/input') ?>" method="POST">
              <div class="form-group row">
                <div class="col-sm mb-sm-0">
                  <select name="sk_id" id="kadiv_uj_sk" class="form-control mb-3">
                    <option value="0">Select School</option>
                    <?php foreach ($sk_all as $m) : ?>
                      <option value='<?= $m['sk_id'] ?>'>
                        <?= $m['sk_nama'] ?>
                      </option>
                    <?php endforeach ?>
                  </select>
                </div>
                <div class="col-sm mb-sm-0">
                  <select name="t_id" id="kadiv_uj_t_id" class="form-control mb-3">
                    <option value="0">Select Year</option>
                    <?php foreach ($t_all as $m) : ?>
                      <option value='<?= $m['t_id'] ?>'>
                        <?= $m['t_nama'] ?>
                      </option>
                    <?php endforeach ?>
                  </select>
                </div>
              </div>
              <div id="kadiv_uj_kelas">
              
              </div>
              <div id="kadiv_uj_mapel">
              
              </div>
              <!-- <button type="submit" class="btn btn-primary btn-user btn-block">
                  Insert Mid & Final
              </button> -->
            </form>

          </div>
        </div>
      </div>
    </div>
  </div>

</div>

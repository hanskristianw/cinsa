<div class="container">

  <div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
      <!-- Nested Row within Card Body -->
      <div class="row">
        <div class="col-lg">
          <div class="p-5 overflow-auto">
            <div class="text-center">
              <h1 class="h4 text-gray-900"><u><b>SELECT SCHOOL, CLASS and STUDENT</b></u></h1>
            </div>

            <?= $this->session->flashdata('message'); ?>

            <form class="user" action="<?= base_url('Konseling_CRUD/add') ?>" method="POST">
              <div class="form-group row">
                <div class="col-sm mb-sm-0 mt-2">
                  <select name="sk_id" id="konseling_sk_id" class="form-control mb-1">
                    <option value="0">Select School</option>
                    <?php foreach ($sk_all as $m) : ?>
                      <option value='<?= $m['sk_id'] ?>'>
                        <?= $m['sk_nama'] ?>
                      </option>
                    <?php endforeach ?>
                  </select>
                </div>
                <div class="col-sm mb-sm-0 mt-2">
                  <select name="t_id" id="konseling_t_id" class="form-control">
                    <?php foreach ($t_all as $m) : ?>
                      <option value='<?=$m['t_id']?>'>
                        <?= $m['t_nama'] ?>
                      </option>
                    <?php endforeach ?>
                  </select>
                </div>
              </div>
              <div id="konseling_kelas_id"></div>
              <div id="konseling_siswa_id"></div>
              <div id="btn_add_konseling"></div>
              <!-- <button type="submit" class="btn btn-primary btn-user btn-block">
                  Show Value
              </button> -->
            </form>

            
            <div id="detail_konseling"></div>

          </div>
        </div>
      </div>
    </div>
  </div>

</div>

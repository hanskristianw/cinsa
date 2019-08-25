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

            <input type="hidden" id="report_konseling_flag" value="1">

            <?= $this->session->flashdata('message'); ?>

            <form class="user" action="<?= base_url('Konseling_CRUD/print_report') ?>" method="POST">
              <div class="form-group row mt-5">
                <div class="col-sm mb-sm-0 mt-2">
                  <h6 class="ml-2"><b><u>School</u>:</b></h6>
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
                  <h6 class="ml-2"><b><u>Year</u>:</b></h6>
                  <select name="t_id" id="konseling_t_id" class="form-control">
                    <?php foreach ($t_all as $m) : ?>
                      <option value='<?=$m['t_id']?>'>
                        <?= $m['t_nama'] ?>
                      </option>
                    <?php endforeach ?>
                  </select>
                </div>
                <div class="col-sm mb-sm-0 mt-2">
                  <h6 class="ml-2"><b><u>Print Date</u>:</b></h6>
                  <input type="date" name="tanggal" class="form-control form-control" required>
                </div>
              </div>
              <div id="konseling_kelas_id"></div>
              <div id="konseling_siswa_check"></div>
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
